<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SimplifiedDebit;
use App\Models\SimplifiedDebitDetails;
use App\Models\Company;
use App\Models\Branch;
use App\Models\ExitWork;
use App\Models\Karat; 
use App\Models\CompanyInfo;
use Carbon\Carbon;
use Illuminate\Support\Str; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SimplifiedDebitController extends Controller
{
 
    public function create()
    {
        $vendors =  Company::where('vat_no' , 0)->where('group_id' , '=' , 3) -> get();
        $branches = Branch::where('status',1)->get();

        return view('admin.simplified.debit.create', compact('vendors','branches'));
    }

    public function show(Request $request)
    {
        return view('admin.simplified.debit.show');
    }

    public function add_simplified_dept($id)
    {
        $sale = ExitWork::find($id); 

        $siteContrller = new SystemController();
        $branches = $siteContrller->getBranches();
        $customers = $siteContrller->getAllClients();

        $saleItems = DB::table('exit_work_details')
            ->join('items','items.id','=','exit_work_details.item_id')
            ->join('karats','karats.id','=','exit_work_details.karat_id')
            ->join('exit_works','exit_works.id','=','exit_work_details.bill_id') 
            ->select('exit_work_details.*','items.name_ar as product_name','karats.name_ar as karat_name')
            ->where('exit_work_details.bill_id',$id)
            ->get();


        $saleItems = $saleItems->toJson();
      
        return view('admin.simplified.debit.create',compact('branches','customers','saleItems','id','sale'));
       
    }


    public function store_simplified_dept(Request $request,$id)
    {
     
        $request['serial_number'] = $this->get_simplified_debit_no( 1 ,$request -> branch_id); 
 
        $validated = $request->validate([ 
            'serial_number' => 'required|unique:simplified_debit', 
            'bill_number' => 'required',
            'customer_id' => 'required', 
            'branch_id' => 'required',
        ]); 

        $siteController = new SystemController();
        $total = 0;
        $tax = 0; 
        $discount = 0;
        $net = 0; 

        $items = array();
        if(count($request -> item_id)){ 

            for($i = 0 ; $i < count($request -> item_id) ; $i++ ){ 
                if(is_numeric($request -> net[$i]) > 0){
                    $item =[
                        'bill_id' => 0,
                        'simplified_detail_id' => $request -> simplified_detail_id[$i],
                        'item_id' => $request -> item_id[$i],
                        'karat_id' => $request -> karat_id[$i],
                        'weight' => $request -> weight[$i],
                        'gram_price' => $request -> gram_price[$i], 
                        'gram_manufacture' => 0,
                        'gram_tax' => $request -> tax[$i],
                        'net_money'=> $request -> net[$i],
                    ];
                    $total += ($request -> net[$i] - $request -> tax[$i]);
                    $tax +=  $request -> tax[$i];
                    $net +=  $request -> net[$i];
                    $items[] = $item ; 

                }
               
            } 

            $id =  SimplifiedDebit::create([
                'uuid' => Str::uuid(),
                'branch_id' => $request -> branch_id,
                'serial_number' => $request -> serial_number,
                'reference_id' => $request ->reference_id,
                'bill_number' => $request -> bill_number, 
                'date' => date('Y-m-d\TH:i:s'),
                'client_id' => $request -> customer_id, 
                'total_money' => $total,
                'total21_gold' => $request -> total_weight21 ?? 0,
                'paid_money' => $request -> paid ?? 0,
                'remain_money' => $request -> net_after_discount - $request -> paid ??0,
                'paid_gold' => 0,
                'remain_gold' => 0,
                'discount' => $request -> discount ?? 0,
                'tax' => $tax ,
                'net_money' => $net,
                'bill_client_name' => $request -> bill_client_name ?? 0,
                'pos' => 1,
                'notes'=> $request -> notes ?? '',
                'user_id' => Auth::user() -> id
            ]) -> id;
    
            foreach ($items as $product){
                $product['bill_id'] = $id;
                SimplifiedDebitDetails::create($product) ; 
            }
    
            $WarehouseController = new WarehouseController(); 
            $WarehouseController-> syncVendorAccount($request -> customer_id , $net ,0 , 1 ,
                $id, $request -> bill_number, 'simplified_debit', $request -> branch_id);
    
            $PosController = new PosController(); 
            $request['bill_date'] = date('Y-m-d\TH:i:s');
            $PosController -> MakePayment($request , $net, 0, $id, 1, $request -> bill_number); 
    
            $auto_accounting = env("AUTO_ACCOUNTING", 1);

            if($auto_accounting == 1){
                $systemController = new SystemController();
                $systemController -> SimplifiedDebitAccounting($id);
            }
    
            $simplified_invoice = new ZataControlle();
            $simplified_invoice->simplified_debit($id);
    
            return redirect()->route('simplified.debit.print' , $id)
                ->with('success' ,  __('main.created'));
        
        } else {
            return redirect()->route('simplified.debit.index')->with('error' ,  __('main.nodetails'));
        }
    }


    public function print($id){ 

        $data = SimplifiedDebit::join('companies' , 'companies.id' , '=' , 'simplified_debit.client_id')
            -> join('branches' , 'branches.id' , '=' , 'simplified_debit.branch_id')
            -> select('simplified_debit.*' , 'companies.name as vendor_name' , 'branches.branch_name','companies.phone as vendor_phone' , 'companies.vat_no as vendor_vat_no' )
            -> where('simplified_debit.id' , '=' , $id) 
            -> first();
      
        $details = SimplifiedDebitDetails::join('items' , 'items.id' , '=' , 'simplified_debit_details.item_id')
           -> join('karats' , 'karats.id' , '=' , 'simplified_debit_details.karat_id')
           -> select('simplified_debit_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor as transform_factor',
               'items.name_ar as item_ar' , 'items.name_en as item_en' , 'items.no_metal' , 'items.no_metal_type' , 'items.code as item_code')
           -> where('simplified_debit_details.bill_id' , '=' , $id)
           -> get();

       $karats = Karat::all();
       $grouped_ar = $details -> groupBy('karat_ar'); 
       $company = CompanyInfo::first() ; 

       return view('admin.simplified.debit.print' , compact('data' , 'details' , 'karats' , 'grouped_ar', 'company'));
      
   }

    public function get_simplified_debit_no($type,$branch_id){ 

        $bills = SimplifiedDebit::where('branch_id',$branch_id) 
                    ->count();

        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        }
            
        $prefix = "DN";
        $prefix = $prefix .'-'.$branch_id.'-';
   
        if($type == 1){
            $no = $prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT);
            return $no ; 
        }else{
            $no = json_encode($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
            echo $no ;
            exit;
        }
   
    }

    public function get_sales($code)
    {
        $single = $this->getSingleSales($code);

        if($single){ 
            echo json_encode([$single]);
            exit;
        }else{
            if(!empty(Auth::user()->branch_id)) {
                $sale = ExitWork::where('bill_number' , 'like' , '%'.$code.'%')  
                ->where('branch_id', Auth::user()->branch_id)
                ->limit(5)
                ->get();
            }else{
                $sale = ExitWork::where('bill_number' , 'like' , '%'.$code.'%')  
                ->limit(5)
                ->get();
            }

            echo json_encode ($sale);
            exit;
        }

    }

    private function getSingleSales($code){
        if(!empty(Auth::user()->branch_id)) {
            return ExitWork::where('bill_number', '=' , $code) 
            ->where('branch_id', Auth::user()->branch_id)
            ->first();
        }else{
            return ExitWork::where('bill_number', '=' , $code) 
            ->first(); 
        }
 
    }   
	
}
