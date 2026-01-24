<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyInfo;
use App\Models\EnterMoney;
use App\Models\EnterOld;
use App\Models\EnterOldDetails;
use App\Models\EnterWork;
use App\Models\EnterWorkDetails;
use App\Models\ExitMoney;
use App\Models\ExitOld;
use App\Models\ExitOldDetails;
use App\Models\ExitWork;
use App\Models\ExitWorkDetails;
use App\Models\Item;
use App\Models\Karat;
use App\Models\Pricing;
use App\Models\TaxSettings;
use App\Models\Branch;
use App\Models\NotificationWahtsapp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Str; 
use Illuminate\Http\Request;
use DataTables; 
use Barryvdh\DomPDF\Facade\Pdf;     
use ArPHP\I18N\Arabic;

class PosController extends WarehouseController
{
    public function index(Request $request){

        $work = ExitWork::with('branch:id,branch_name','cash:id,based_on_bill_number,amount','visa:id,based_on_bill_number,amount')
            ->where('pos' , 1) 
            ->where('net_money' , '>=' , 0)
            ->orderBy('id', 'DESC')
            ->get(); 
    
        $old = ExitOld::with('branch:id,branch_name','cash:id,based_on_bill_number,amount','visa:id,based_on_bill_number,amount')
            ->where('pos' , 1)
            ->where('net_money' , '>=' , 0) 
            ->orderBy('id', 'DESC')
            ->get();

        if (!empty(Auth::user()->branch_id)) {
            $work = $work->where('branch_id', Auth::user()->branch_id);
            $old = $old->where('branch_id', Auth::user()->branch_id);
        } 

        foreach ($work as $w){
            $w -> type = 1 ;
            $w -> cash_amount =  $w -> cash-> amount ?? 0;
            $w -> visa_amount =  $w -> visa-> amount ?? 0;
            $client = Company::find($w -> client_id );
            $w -> vendor_name = $client ? $client -> name : '--';
        } 

        foreach ($old as $o){
            $o -> type = 0 ;
            $o -> cash_amount = $o -> cash-> amount ?? 0;
            $o -> visa_amount = $o -> visa-> amount ?? 0;
            $client = Company::find($o -> supplier_id );
            $o -> vendor_name = $client ? $client -> name : '--';
        }
         
        $data = $work -> mergeRecursive($old);
        $branches = Branch::all();

        if ($request->ajax()) {  

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){ 
                    if($row -> type == 1){
                        if(auth()->user()->can('عرض فاتورة ضريبية')){  
                         $btn = '<a href='.route('workExitPreview',$row->id).' class="btn btn-primary" 
                                    value="'.$row->id.'" role="button" data-bs-toggle="button" target="_blank" >
                                    <i class="fa fa-eye"></i>معاينة</a>';
                        }
                        if($row -> returned_bill_id == 0 && $row -> net_money > 0){
                            if(auth()->user()->can(['اضافة مرتجع فاتورة مبيعات','عرض مرتجع فاتورة مبيعات'])){     
                                $btn = $btn.'<a href='.route('return_work',$row->id).' class="btn btn-info" 
                                value="'.$row->id.'" role="button"  data-bs-toggle="button" ><i class="fa fa-retweet"></i> عمل مرتجع</a>';
                            } 
                        }
                    }else{
                        if(auth()->user()->can('عرض فاتورة ضريبية')){  
                            $btn = '<a href='.route('oldExitPreview',$row->id).' class="btn btn-primary" 
                                       value="'.$row->id.'" role="button" data-bs-toggle="button" target="_blank" >
                                       <i class="fa fa-eye"></i>معاينة</a>';
                           }
                           if($row -> returned_bill_id == 0 && $row -> net_money > 0){
                               if(auth()->user()->can(['اضافة مرتجع فاتورة مبيعات','عرض مرتجع فاتورة مبيعات'])){     
                                   $btn = $btn.'<a href='.route('return_old',$row->id).' class="btn btn-info" 
                                   value="'.$row->id.'" role="button"  data-bs-toggle="button" ><i class="fa fa-retweet"></i> عمل مرتجع</a>';
                               } 
                           }
                    } 
                    return $btn; 
                }) 
                ->rawColumns(['action']) 
                ->make(true);
        } 

        return view ('admin.pos.sales' , compact('branches'));
    } 
 
    public function create(){

        $customers =  Company::where('vat_no' , 0)->where('group_id' , '=' , 3) -> get();
        $suppliers =  Company::where('group_id' , '=' , 4) -> get();
        $karats = Karat::all();
        $setting = TaxSettings::all() -> first();
        $pricings = Pricing::all(); 
        $branches = Branch::where('status',1)->get();
        $uuid = Str::uuid();
        
        return view('admin.pos.create' , compact('customers' , 'suppliers' ,'karats' , 'setting','branches','uuid' ));
    
    }

    public function store(Request $request){

        //document_type == 1 ExitWork , ExitOld
        if($request -> document_type == 1 ){
            return $this->sellNewGold($request);
        } else{
            return $this-> sellOldGold($request);
        }

    }

    public function MakePayment($request , $money , $type , $based_on , $doc_type ,$based_on_num){
        
        $bill_number = $this -> getpaymentNo($request -> branch_id);

        $id = EnterMoney::create([
            'branch_id' => $request -> branch_id ,
            'doc_number' => $bill_number ,
            'date' => $request -> bill_date,
            'client_id' => $request -> customer_id,
            'amount' => $money,
            'payment_method' => $type, 
            'based_on' => $based_on,
            'based_on_bill_number' => $based_on_num,
            'notes' => '',
            'user_id' => Auth::user() -> id
        ]) -> id   ;

        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        
        if($auto_accounting == 1){
            $systemController = new SystemController();
            $systemController -> EnterMoneyAccounting($id);
        }

        if($request -> customer_id > 0){
            $this -> syncVendorAccount($request -> customer_id , $money ,0 , -1 ,
                $id , $bill_number , 'Enter Money Bill',$request -> branch_id);
        }

        if($based_on > 0){
            if($doc_type == 1){
                $bill = ExitWork::find($based_on);
            } else {
                $bill = ExitOld::find($based_on);
            }

            if($bill ){
                $bill -> remain_money -= $money ;
                $bill -> paid_money += $money ;
                $bill -> update();
            }
        }
    }

    public function MakePaymentOut($request , $money , $type , $based_on ){

        $bill_number = $this -> getpaymentOutNo($request ->branch_id);

        $id =  ExitMoney::create([
            'branch_id' => $request ->branch_id ,
            'doc_number' => $bill_number ,
            'date' => date("Y-m-d H:i:s"),
            'supplier_id' => $request -> customer_id2,
            'type' => 4,
            'based_on' => $based_on,
            'amount' => $money,
            'payment_method' => $type,
            'price_gram' => 0,
            'based_on_bill_number' => $request -> bill_number2, 
            'notes' =>  '',
            'user_id' => Auth::user() -> id
        ]) -> id;

        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        if($auto_accounting == 1){
            $systemController = new SystemController();
            $systemController -> ExitMoneyAccounting($id);
        }

        if($request -> customer_id2 > 0){

            $moneyout = $money ;
            $gold = 0;

            $this->syncVendorAccount($request->customer_id2, $moneyout, $gold, 1
                , $id, $bill_number, 'Exit Money Bill',$request -> branch_id);
        }

        if($based_on > 0){

            $bill = EnterOld::find($based_on);
            if($bill ){
                $bill -> remain_money -= $money ;
                $bill -> paid_money += $money ;
                $bill -> update();
            }
        }
    }

    public function get_sales_pos_no($type,$invoic_type,$branch_id){ 

        if($invoic_type == 1){    

            $no = $this->GetPosNo($branch_id);
           
        } else {  

            $no  = $this->GetOldNo($branch_id);
        }

        if($type == 1){ 

            $no = json_encode($no) ;
            echo $no ;
            exit;

        }else{ 

            return $no ; 
        }  
    }

    public function GetPosNo($branch_id)
    {
        $prefix = "SWSI-".$branch_id."-"; 

        $lastId = ExitWork::where('branch_id', $branch_id)  
            ->where('returned_bill_id',0) 
            ->count();
    
        do { 
     
            $No = $prefix . str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);
            $lastId ++;
      
        } while (ExitWork::where('bill_number', $No)->exists()); 
    
        return $No;
    }

    public function GetOldNo($branch_id)
    {
        $prefix = "SOSI-".$branch_id."-"; 

        $lastId = ExitOld::where('branch_id', $branch_id)  
            ->where('returned_bill_id',0) 
            ->count();
    
        do { 
     
            $No = $prefix . str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);
            $lastId ++;
      
        } while (ExitOld::where('bill_number', $No)->exists()); 
    
        return $No;
    }

    public function GetWorkReturnNo($branch_id){

        $prefix = "RSWSI-".$branch_id."-"; 

        $lastId = ExitWork::where('branch_id', $branch_id)  
            ->where('returned_bill_id','>',0)
            ->count();
    
        do { 
     
            $No = $prefix . str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);
            $lastId ++;
      
        } while (ExitWork::where('bill_number', $No)->exists()); 
    
        return $No; 
    }

    public function GetWorkOldReturnNo($branch_id){

        $prefix = "RSOSI-".$branch_id."-"; 

        $lastId = ExitOld::where('branch_id', $branch_id)  
            ->where('returned_bill_id','>',0)
            ->count();
    
        do { 
     
            $No = $prefix . str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);
            $lastId ++;
      
        } while (ExitOld::where('bill_number', $No)->exists()); 
    
        return $No;  
    }

    public function getpaymentNo($branch_id){ 
        
        $bills = EnterMoney::where('branch_id', $branch_id)  
            ->orderBy('id', 'ASC')
            ->get(); 

        if(count($bills) > 0){
            $id = $bills[count($bills) -1] -> id ;
        } else{
            $id = 0 ;
        }

        $prefix = "ME-".$branch_id."-";
        $no = ($prefix . str_pad($id + 1, 6, '0', STR_PAD_LEFT));

        return $no ;
    }

    public function getpaymentOutNo($branch_id){

        $bills = ExitMoney::where('branch_id', $branch_id)
            ->orderBy('id', 'ASC')
            ->get(); 
    
        if(count($bills) > 0){
            $id = $bills[count($bills) -1] -> id ;
        } else{
            $id = 0 ;
        }

        $i = 0;
        do { 
            $i++;
            $prefix = "MEx-".$branch_id."-";
            $no = $prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT) ;
        } while (ExitMoney::where("doc_number","=",$prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT))->exists());
     
        return $no;
    }
    

    public function pos_payment_show($money , $type){
        $html = view('admin.pos.payment' , compact('money', 'type')) -> render();
        return $html ;
    }

    public function pos_payment_show2($money){
        $html = view('admin.pos.payment2' , compact('money')) -> render();
        return $html ;
    }

    public function sellNewGold($request){

        try { 

            $request['bill_number'] = $this->get_sales_pos_no(2 , 1 ,$request -> branch_id); 

            $validated = $request->validate([ 
                'bill_number' => 'required|unique:exit_works',
                'uuid' => 'required|unique:exit_works',
                'bill_date' => 'required',
                'customer_id' => 'required',
                'branch_id' => 'required',
                'net_after_discount' =>['required', 'numeric', 'min:1'], 
                'item_id' => ['required', 'array'],   
                'item_id.*' => ['required', 'numeric'],  
                'weight' => ['required', 'array'],   
                'weight.*' => ['required', 'numeric', 'min:0.01'],   
                'gram_price' => ['required', 'array'],   
                'gram_price.*' => ['required', 'numeric', 'min:1'],    
                'net_money' => ['required', 'array'],   
                'net_money.*' => ['required', 'numeric'],  
                
            ]);
             
            $items = array();
            if(count($request -> item_id)){
                //store header
                $total = 0 ;
                for($i = 0 ; $i < count($request -> item_id) ; $i++ ){
                    $item =[
                        'bill_id' => 0,
                        'item_id' => $request -> item_id[$i],
                        'karat_id' => $request -> karat_id[$i],
                        'count' => $request -> count[$i], 
                        'weight' => $request -> weight[$i],
                        'gram_price' => $request -> gram_price[$i], 
                        'gram_manufacture' => 0,
                        'gram_tax' => $request -> item_tax[$i],
                        'net_money'=> $request -> net_money[$i],
                    ];
                    $total += ($request -> net_money[$i] - $request -> item_tax[$i]);
                    $items[] = $item ;
                }
    
                $id = ExitWork::create([
                    'uuid' => $request->uuid,
                    'branch_id' => $request -> branch_id,
                    'bill_number' => $request -> bill_number,
                    'date' => date('Y-m-d\TH:i:s'),
                    'client_id' => $request -> customer_id,
                    'client_phone' => $request -> bill_client_phone,
                    'total_money' => $total,
                    'total21_gold' => $request -> total_weight21,
                    'paid_money' => $request -> paid,
                    'remain_money' => $request -> net_after_discount - $request -> paid,
                    'paid_gold' => 0,
                    'remain_gold' => 0,
                    'discount' => $request -> discount,
                    'tax' => $request ->tax ,
                    'net_money' => $request -> net_after_discount,
                    'bill_client_name' => $request -> bill_client_name,
                    'pos' => 1,
                    'notes'=> $request -> notes ?? '',
                    'user_id' => Auth::user() -> id
                ]) -> id;
    
                foreach ($items as $product){
                    $product['bill_id'] = $id;
                    ExitWorkDetails::create($product) ;
                    $this -> syncQnt(1 , $product['karat_id'],0, $id , $product['weight'] , -1 , $request -> branch_id);
 
                }
    
                $this -> syncVendorAccount($request -> customer_id , $request -> net_after_discount ,0 , 1 ,
                    $id , $request -> bill_number , 'Work Exit Bill', $request -> branch_id);
    
                if($request -> cash > 0){
                    $this -> MakePayment($request , $request -> cash, 0, $id, 1, $request -> bill_number);
                }
    
                if($request -> visa > 0){
                    $this -> MakePayment($request , $request -> visa, 1, $id, 1, $request -> bill_number);
                }
    
                $auto_accounting =  env("AUTO_ACCOUNTING", 1);
                if($auto_accounting == 1){
                    $systemController = new SystemController();
                    $systemController -> ExitWorkAccounting($id);
                }

                //$simplified_invoice = new ZataControlle();
                //$simplified_invoice->simplified_tax_invoice($id);
    
                return redirect()->route('workExitPreview' , $id)->with('success' ,  __('main.created'));
            
            } else {
                return redirect()->route('pos')->with('error' ,  __('main.nodetails'));
            }
           
            
        } catch (QueryException $ex) {
            return redirect()->route('pos')->with('error', $ex->getMessage());
        }


    }


    public function sellOldGold($request){

        try {
            
            $request['bill_number'] = $this->get_sales_pos_no(2 , 0 ,$request -> branch_id); 
            
            $validated = $request->validate([
                'bill_date' => 'required',
                'bill_number' => 'required|unique:exit_olds',
                'customer_id' => 'required',
                'branch_id' => 'required',
            ]);
            
            $items = array();
            if(count($request -> karat_id_old )){ 

                $total_money = 0 ;
                $total21_gold = 0 ;

                for($i = 0 ; $i < count($request -> karat_id_old); $i++ ){

                    $item =[
                        'bill_id' => 0,
                        'karat_id' => $request -> karat_id_old[$i],
                        'weight' => $request -> weight_old[$i],
                        'weight21'=> $request -> weight21_old[$i],
                        'gram_price' => $request -> gram_price_old[$i],
                        'made_money'=> 0,
                        'gram_tax' => $request -> gram_tax_old[$i],
                        'net_weight' => $request -> weight21_old [$i],
                        'net_money' => $request -> net_money_old[$i],
                    ];
                    $total21_gold += $request -> weight21_old[$i];
                    $total_money += ($request -> net_money_old[$i] - $request -> gram_tax_old[$i]);
                    $items[] = $item ;
                }
    
                $id = ExitOld::create([
                    'uuid' => Str::uuid(),
                    'branch_id' => $request -> branch_id,
                    'bill_number' => $request -> bill_number,
                    'bill_type' => $request -> document_type,
                    'date' => $request -> bill_date,
                    'supplier_id' => $request -> customer_id,
                    'total_money' => $total_money,
                    'total21_gold' => $total21_gold,
                    'paid_money' => 0,
                    'remain_money' => $request -> net_after_discount,
                    'paid_gold' => 0,
                    'remain_gold' => 0,
                    'discount' => $request -> discount,
                    'tax' => $request -> tax ,
                    'net_money' => $request -> net_after_discount,
                    'bill_client_name' => $request -> bill_client_name ?? '',
                    'pos' => 1,
                    'notes'=> $request -> notes ?? '',
                    'user_id' => Auth::user() -> id
    
                ]) -> id;
    
                foreach ($items as $product){
                    $product['bill_id'] = $id;
                    ExitOldDetails::create($product) ; 
                    $this -> syncQnt($request -> document_type, $product['karat_id'], 0, $id, $product['weight'], -1, $request -> branch_id);
                }
    
                $this -> syncVendorAccount($request -> customer_id , $request -> net_after_discount , 0 , 1 ,
                    $id , $request -> bill_number , 'Old Exit Bill',$request -> branch_id);
    
                if($request -> cash > 0){
                    $this -> MakePayment($request , $request -> cash , 0 , $id , 2 , $request -> bill_number);
                }
                if($request -> visa > 0){
                    $this -> MakePayment($request , $request -> visa , 1 , $id , 2 , $request -> bill_number);
                }
    
                $auto_accounting =  env("AUTO_ACCOUNTING", 1);
                if($auto_accounting == 1){
                    $systemController = new SystemController();
                    $systemController -> ExitOldAccounting($id);
                }
               
                return redirect()->route('oldExitPreview' ,$id )->with('success' ,  __('main.created'));
            
            } else {
                return redirect()->route('pos')->with('error' ,  __('main.nodetails'));
            }

        } catch (QueryException $ex) {
            return redirect()->route('pos')->with('error', $ex->getMessage());
        }
        
    }

    public function test_print(){
        return view ('pos.print_sales');
    }

    public function return_work($id){

        if (!empty(Auth::user()->branch_id)) {

            $bill = DB::table('exit_works')
                -> leftJoin('companies' , 'companies.id' , '=' , 'exit_works.client_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_works.branch_id')
                -> select('exit_works.*' , 'companies.name as vendor_name' , 'branches.branch_name' , 'companies.vat_no as vendor_vat_no')
                -> where('exit_works.id' , '=' , $id)
                -> where('exit_works.branch_id' , Auth::user()->branch_id)
                -> first();

            if(!$bill) return;

        } else{

            $bill = DB::table('exit_works')
                -> leftJoin('companies' , 'companies.id' , '=' , 'exit_works.client_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_works.branch_id')
                -> select('exit_works.*' , 'companies.name as vendor_name' , 'branches.branch_name' , 'companies.vat_no as vendor_vat_no')
                -> where('exit_works.id' , '=' , $id) 
                -> first();
        }
  
        $details   =  DB::table('exit_work_details')
            -> join('items' , 'items.id' , '=' , 'exit_work_details.item_id')
            -> join('karats' , 'karats.id' , '=' , 'exit_work_details.karat_id')
            -> select('exit_work_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor as transform_factor',   'items.name_ar as item_ar' , 'items.name_en as item_en')
            -> where('exit_work_details.bill_id' , '=' , $id)
            -> get(); 

        return view ('admin.pos.workReturn' , compact('bill' , 'details'));
    }

    public function return_work_post(Request $request){

        $bill = ExitWork::find($request -> bill_id);
        $data = ExitWorkDetails::where('bill_id' , '=' , $request -> bill_id) -> get();
        $details = [] ;
        $total = 0 ;
        $money = 0 ;
        $tax = 0 ;
        $total_weight21 = 0 ;

        foreach ($data as $detail){
            if(in_array($detail -> id , $request -> checkDetail)){
                array_push($details , $detail); 
                $total += $detail -> net_money - $detail ->gram_tax;
                $karat = Karat::find($detail -> karat_id);
                $total_weight21 += ($detail -> weight * $karat ->transform_factor);
                $tax += $detail->gram_tax;
            }
        }

        $discountOld = $bill -> discount ;
        $discountPer = 1 - ($bill ->total_money - $discountOld) /($bill ->total_money) ;
        $discount = $discountPer * $total ; 
        $net = $total + $tax - $discount ;

        $previous_invoice = ExitWork::where('net_money','<',0)->orderBy('id', 'DESC')->limit(1)->first();
        
        if($previous_invoice){
            $previous_invoice_hash = $previous_invoice->invoice_hash;
        }else{
            $previous_invoice_hash = '';
        }

        $request['bill_number'] = $this -> GetWorkReturnNo($bill -> branch_id); 
            
        $validated = $request->validate([ 
            'bill_number' => 'required|unique:exit_works'
        ]);

        $id =  ExitWork::create([
            'uuid' => Str::uuid(),
            'branch_id' => $bill -> branch_id,
            'bill_number' => $request->bill_number,
            'date' => Carbon::now(),
            'client_id' => $bill -> client_id,
            'total_money' => $total * -1,
            'total21_gold' => $total_weight21 * -1 ,
            'paid_money' => 0,
            'remain_money' => 0,
            'paid_gold' => 0,
            'remain_gold' => 0,
            'discount' => $discount * -1,
            'tax' => $tax * -1,
            'net_money' =>  $net * -1,
            'bill_client_name' => $bill -> bill_client_name,
            'pos' => 1,
            'notes'=> $bill -> notes ?? '',
            'user_id' => Auth::user() -> id

        ]) -> id;

        $bill -> returned_bill_id = $id ;
        $bill -> update ();

        foreach ($details as $detail){
            $item = Item::find($detail -> item_id) ;
            if($item){
                $item -> state = 1 ;
                $item -> update();
                $this -> syncQnt( 1, $item -> karat_id, 0, $id, $item -> weight, 1, $bill -> branch_id);
            }

            ExitWorkDetails::create([
                'bill_id' => $id,
                'item_id' => $detail -> item_id,
                'karat_id' => $detail -> karat_id,
                'weight' => $detail -> weight,
                'gram_price'=> $detail -> gram_price,
                'gram_manufacture'=> $detail -> gram_manufacture,
                'gram_tax'=> $detail -> gram_tax,
                'net_money' => $detail -> net_money,
            ]);

            $detail -> returned = 1;
            $detail -> update();
        }

        $this -> syncVendorAccount($bill -> client_id , $net ,0 , -1 ,
            $id ,  $request->bill_number , 'Return Work Exit Bill',$bill -> branch_id);

        //update 15-10-2023
        $payments = EnterMoney::where('based_on',$bill ->id) ->get();
        $request['bill_date2'] =  Carbon::now();
        $request['customer_id2'] =  $bill -> client_id ;
        $request['bill_number2'] = $request->bill_number;   
        $request['branch_id'] = $bill -> branch_id;          
   
        $this -> MakePaymentOut($request , $net , 0 , $id );

        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        if($auto_accounting == 1){
            $systemController = new SystemController();
            $systemController -> ReturnExitWorkAccounting($id);
        }

        //$simplified_invoice = new ZataControlle();
       // $simplified_invoice->simplified_credit($id, $previous_invoice_hash);

        return redirect() -> route('pos_sales') ->with('success' ,  __('main.created'));

    }

    public function return_sales(Request $request){  

        $work = ExitWork::with('branch:id,branch_name')
            ->where('pos' , '=' , 1) 
            -> where('net_money' , '<' , 0)
            -> orderBy('id', 'DESC')
            -> get();

        $old = ExitOld::with('branch:id,branch_name')
            ->where('pos' , '=' , 1) 
            -> where('net_money' , '<' , 0)
            -> orderBy('id', 'DESC')
            -> get();

        if (!empty(Auth::user()->branch_id)) {
            $work = $work->where('branch_id', Auth::user()->branch_id); 
            $old = $old->where('branch_id', Auth::user()->branch_id); 
        } 
         
        foreach ($work as $w){
            $w -> type = 1 ;
            $client = Company::find($w -> client_id );
            $w -> vendor_name = $client ? $client -> name : '--';
            $billSales = ExitWork::where('returned_bill_id' , '=' , $w -> id) -> first();
            $w -> salesNo = $billSales -> bill_number ?? 0;
        }

        foreach ($old as $o){
            $o -> type = 0 ;
            $client = Company::find($o -> supplier_id );
            $o -> vendor_name = $client ? $client -> name : '--';
            $billSales = ExitOld::where('returned_bill_id' , '=' , $o -> id) -> first();
            $o -> salesNo = $billSales -> bill_number ?? 0;
        }

        $data = $work -> mergeRecursive($old);
        $branches = Branch::all();   

        if ($request->ajax()) {  
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('type', function($row){ 
                    if(empty($row->bill_type)){
                        $span = 'مردود مبيعات ذهب مشغول'; 
                    }else{
                        $span = 'مردود مبيعات ذهب كسر';
                    }  
                    return $span; 
                }) 
                ->addColumn('action', function($row){ 
                    if(auth()->user()->can('عرض مرتجع فاتورة مبيعات')){ 
                        if($row -> type == 1){ 
                            $btn = '<a href='.route('workReturnPreview',$row->id).' class="btn btn-info editBtn" 
                                        value="'.$row->id.'" role="button" data-bs-toggle="button" target="_blank" >
                                        <i class="fa fa-eye"></i>معاينة
                                    </a>';
                        }else{
                            $btn = '<a href='.route('oldReturnPreview',$row->id).' class="btn btn-info editBtn" 
                                        value="'.$row->id.'" role="button" data-bs-toggle="button" target="_blank" >
                                        <i class="fa fa-eye"></i>معاينة
                                    </a>'; 
                        }
                    }
                     
                    return $btn; 
                }) 
                ->rawColumns(['type','action']) 
                ->make(true);
        } 

        return view ('admin.pos.salesReturn' , compact('branches' ));
    }

    public function return_old($id){ 

        if (!empty(Auth::user()->branch_id)) {

            $bill = DB::table('exit_olds')
                -> leftJoin('companies' , 'companies.id' , '=' , 'exit_olds.supplier_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_olds.branch_id')
                -> select('exit_olds.*' , 'companies.name as vendor_name', 'branches.branch_name' , 'companies.vat_no as vendor_vat_no')
                -> where('exit_olds.id' , '=' , $id)
                -> where('exit_olds.branch_id' ,Auth::user()->branch_id)
                -> first();

            if(!$bill) return ;
        }else{

            $bill = DB::table('exit_olds')
                -> leftJoin('companies' , 'companies.id' , '=' , 'exit_olds.supplier_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_olds.branch_id')
                -> select('exit_olds.*' , 'companies.name as vendor_name', 'branches.branch_name' , 'companies.vat_no as vendor_vat_no')
                -> where('exit_olds.id' , '=' , $id) 
                -> first();
        }


        $details =  DB::table('exit_old_details')
            -> join('karats' , 'karats.id' , '=' , 'exit_old_details.karat_id')
            -> select('exit_old_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor as transform_factor')
            -> where('exit_old_details.bill_id' , '=' , $id)
            -> get(); 

        return view ('admin.pos.oldReturn' , compact( 'bill' , 'details' ));
    }

    public function return_old_post(Request $request){

        $bill = ExitOld::find($request -> bill_id);
        $data = ExitOldDetails::where('bill_id' , '=' , $request -> bill_id) -> get();

        $details = [] ;
        $total = 0 ;
        $tax = 0 ;
        $total_weight21 = 0 ;
        
        foreach ($data as $detail){

            if(in_array($detail -> id , $request -> checkDetail)){

                array_push($details , $detail);
                $total += $detail -> net_money - $detail ->gram_tax; 
                $karat = Karat::find($detail -> karat_id);
                $total_weight21 += ($detail -> weight * $karat ->transform_factor)  ;
                $tax += $detail ->gram_tax;
            }
        }

        $discountOld = $bill -> discount ;
        $discountPer = 1 - ($bill ->total_money - $discountOld) /($bill ->total_money) ;
        $discount = $discountPer * $total ;
        $net = $total + $tax - $discount ;
        
        $bill_number = $this -> GetWorkOldReturnNo($bill -> branch_id);

        $id =  ExitOld::create([
            'uuid' => Str::uuid(),
            'branch_id' => $bill -> branch_id,
            'bill_number' => $bill_number,
            'bill_type' =>  $bill ->bill_type,
            'date' => Carbon::now(),
            'supplier_id' => $bill -> supplier_id,
            'total_money' => $total * -1,
            'total21_gold' => $total_weight21 * -1 ,
            'paid_money' => 0,
            'remain_money' => 0,
            'paid_gold' => 0,
            'remain_gold' => 0,
            'discount' => $discount * -1,
            'tax' => $tax * -1,
            'net_money' =>  $net * -1,
            'bill_client_name' => $bill -> bill_client_name ?? '',
            'pos' => 1,
            'notes'=> $bill -> notes ?? '',
            'user_id' => Auth::user() -> id
        ]) -> id;

        $bill -> returned_bill_id = $id ;
        $bill -> update ();

        foreach ($details as $detail){
            ExitOldDetails::create([
                'bill_id' => $id,
                'karat_id' => $detail -> karat_id,
                'weight' => $detail -> weight,
                'weight21' => $detail -> weight21,
                'made_money'=> $detail -> made_money,
                'net_weight'=> $detail -> net_weight,
                'net_money'=> $detail -> net_money,
                'gram_manufacture' => $detail -> gram_manufacture,
                'gram_tax' =>  $detail -> gram_tax,
                'gram_price' =>  $detail -> gram_price,
            ]);

            $this -> syncQnt(0, $detail -> karat_id, 0, $id, $detail -> karat_id, 1, $bill -> branch_id);

            $detail -> returned = 1;
            $detail -> update();
        }

        $this -> syncVendorAccount($bill -> supplier_id , $net ,0 , -1 ,
            $id ,  'R'.$bill -> bill_number , 'Return Old Exit Bill',$bill -> branch_id);

        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        if($auto_accounting == 1){
            $systemController = new SystemController();
            $systemController -> ReturnExitOldAccounting($id);
        }

        return redirect() -> route('pos_sales') ->with('success' ,  __('main.created'));

    }

    public function workReturnPreview($id){ 
        return $this -> workReturnPrint($id);
    }

    public function oldReturnPreview($id){ 
        return $this -> oldReturnPrint($id);
    }

    public function workReturnPrint($id){

        if (!empty(Auth::user()->branch_id)) {
            $bill = DB::table('exit_works')
                -> join('companies' , 'companies.id' , '=' , 'exit_works.client_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_works.branch_id')
                -> Join('exit_works as original' , 'exit_works.id' , '=' , 'original.returned_bill_id')
                -> select('exit_works.*' , 'companies.name as vendor_name', 'branches.branch_name' , 'companies.vat_no as vendor_vat_no' , 'original.bill_number as ref_number')
                -> where('exit_works.id' , '=' , $id)
                -> where('exit_works.branch_id' , Auth::user()->branch_id)
                -> first(); 

            if(!$bill)
                return ;
        }else{
            $bill = DB::table('exit_works')
                -> join('companies' , 'companies.id' , '=' , 'exit_works.client_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_works.branch_id')
                -> Join('exit_works as original' , 'exit_works.id' , '=' , 'original.returned_bill_id')
                -> select('exit_works.*' , 'companies.name as vendor_name', 'branches.branch_name' , 'companies.vat_no as vendor_vat_no' , 'original.bill_number as ref_number')
                -> where('exit_works.id' , '=' , $id) 
                -> first(); 
        }

        $details   =  DB::table('exit_work_details')
            -> join('items' , 'items.id' , '=' , 'exit_work_details.item_id')
            -> join('karats' , 'karats.id' , '=' , 'exit_work_details.karat_id')
            -> select('exit_work_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor as transform_factor',
                'items.name_ar as item_ar' , 'items.name_en as item_en' , 'items.no_metal' , 'items.no_metal_type' , 'items.code as item_code')
            -> where('exit_work_details.bill_id' , '=' , $id)
            -> get();

        $karats = Karat::all();
        $grouped_ar = $details   -> groupBy('karat_ar');
        $pos = \Illuminate\Support\Env::get('PROGRAMME_TYPE');
       // $amar = Tafqeet::inArabic($bill -> net_money,'sar');

        $amar ='';
        $payments = EnterMoney::where('based_on_bill_number' , '=' , $bill -> bill_number) -> get();
        $company = CompanyInfo::first() ;
        $bill_Return = ExitWork::findOrFail($id);

        // return $payments ;
        if($pos == 1) {//A4
            return view('admin.pos.printSalesReturn' , compact('bill' ,'bill_Return', 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments' , 'company' ));
        } else { //A5
            return view('admin.pos.printA5' , compact('bill' ,'bill_Return', 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments', 'company' ));
        }
    }


    public function oldReturnPrint($id){ 

        if (!empty(Auth::user()->branch_id)) {
            $bill = DB::table('exit_olds')
                -> join('companies' , 'companies.id' , '=' , 'exit_olds.supplier_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_olds.branch_id')
                -> Join('exit_olds as original' , 'exit_olds.id' , '=' , 'original.returned_bill_id')
                -> select('exit_olds.*' , 'companies.name as vendor_name', 'branches.branch_name', 'companies.vat_no as vendor_vat_no' , 'original.bill_number as ref_number')
                -> where('exit_olds.id' , '=' , $id)
                -> where('exit_olds.branch_id' , Auth::user()->branch_id)
                -> first();  

            if(!$bill)
                return ;
        }else{
            $bill = DB::table('exit_olds')
            -> join('companies' , 'companies.id' , '=' , 'exit_olds.supplier_id')
            -> join('branches' , 'branches.id' , '=' , 'exit_olds.branch_id')
            -> Join('exit_olds as original' , 'exit_olds.id' , '=' , 'original.returned_bill_id')
            -> select('exit_olds.*' , 'companies.name as vendor_name', 'branches.branch_name', 'companies.vat_no as vendor_vat_no' , 'original.bill_number as ref_number')
            -> where('exit_olds.id' , '=' , $id) 
            -> first();  
        }
        
        $details   =  DB::table('exit_old_details')
            -> join('karats' , 'karats.id' , '=' , 'exit_old_details.karat_id')
            -> select('exit_old_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor')
            -> where('exit_old_details.bill_id' , '=' , $id)
            -> get(); 

        $vendors = Company::where('group_id' , '=' , 4) -> get();
        $grouped_ar = $details   -> groupBy('karat_ar');
        $karats = Karat::all();
        $pos = \Illuminate\Support\Env::get('PROGRAMME_TYPE');
        $payments = EnterMoney::where('based_on_bill_number' , '=' , $bill -> bill_number) -> get();
        $company = CompanyInfo::first() ;
        $bill_Return = ExitOld::findOrFail($id);
        // $amar = Tafqeet::inArabic($bill -> net_money,'sar');
        $amar ='';

        if($pos == 0) {//A4 
            return view('admin.Old.Exit.print' , compact('bill' ,'bill_Return', 'details' , 'vendors' , 'karats' , 'grouped_ar' , 'payments' , 'amar', 'company'));
        } else { //A5
            return view('admin.pos.printSalesOldReturn' , compact('bill' ,'bill_Return', 'details' , 'vendors' , 'karats' , 'grouped_ar' , 'payments' , 'amar', 'company'));
        }
    }


    public function print($id){

        if (!empty(Auth::user()->branch_id)) {

           $bill = ExitWork::with('cash:id,based_on_bill_number,amount','visa:id,based_on_bill_number,amount')
               ->join('companies' , 'companies.id' , '=' , 'exit_works.client_id')
               -> join('branches' , 'branches.id' , '=' , 'exit_works.branch_id')
               -> select('exit_works.*' , 'companies.name as vendor_name' , 'branches.branch_name','companies.phone as vendor_phone' , 'companies.vat_no as vendor_vat_no' )
               -> where('exit_works.id' , '=' , $id)
               -> where('exit_works.branch_id' ,Auth::user()->branch_id)
               -> first();

           if(!$bill)
               return ;
        }else{
           $bill = ExitWork::with('cash:id,based_on_bill_number,amount','visa:id,based_on_bill_number,amount')
               ->join('companies' , 'companies.id' , '=' , 'exit_works.client_id')
               -> join('branches' , 'branches.id' , '=' , 'exit_works.branch_id')
               -> select('exit_works.*' , 'companies.name as vendor_name' , 'branches.branch_name','companies.phone as vendor_phone' , 'companies.vat_no as vendor_vat_no' )
               -> where('exit_works.id' , '=' , $id) 
               -> first();
        } 

       $details   =  DB::table('exit_work_details')
           -> join('items' , 'items.id' , '=' , 'exit_work_details.item_id')
           -> join('karats' , 'karats.id' , '=' , 'exit_work_details.karat_id')
           -> select('exit_work_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor as transform_factor',
               'items.name_ar as item_ar' , 'items.name_en as item_en' , 'items.no_metal' , 'items.no_metal_type' , 'items.code as item_code')
           -> where('exit_work_details.bill_id' , '=' , $id)
           -> get();

       $karats = Karat::all();
       $grouped_ar = $details   -> groupBy('karat_ar');
       $pos = \Illuminate\Support\Env::get('PROGRAMME_TYPE'); 
       //$amar = Tafqeet::inArabic($bill -> net_money,'sar');
       $amar = '';
       $payments = EnterMoney::where('based_on_bill_number' , '=' , $bill -> bill_number) -> get();
       $company = CompanyInfo::first() ;
      
       if($pos == 0) {//A4
           return view('admin.Work.Exit.print' , compact('bill' , 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments' , 'company' ));
       } else { //A5
           return view('admin.pos.printA5' , compact('bill' , 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments', 'company'));
       }
   }

   public function send_invoice_whatsapp($id){

       $bill = ExitWork::join('companies' , 'companies.id' , '=' , 'exit_works.client_id')
           -> join('branches' , 'branches.id' , '=' , 'exit_works.branch_id')
           -> select('exit_works.*' , 'companies.name as vendor_name' , 'branches.branch_name','companies.phone as vendor_phone' , 'companies.vat_no as vendor_vat_no' )
           -> where('exit_works.id' , '=' , $id) 
           -> first();

       $details =  DB::table('exit_work_details')
           -> join('items' , 'items.id' , '=' , 'exit_work_details.item_id')
           -> join('karats' , 'karats.id' , '=' , 'exit_work_details.karat_id')
           -> select('exit_work_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor as transform_factor',
               'items.name_ar as item_ar' , 'items.name_en as item_en' , 'items.no_metal' , 'items.no_metal_type' , 'items.code as item_code')
           -> where('exit_work_details.bill_id' , '=' , $id)
           -> get();


           $karats = Karat::all();
           $grouped_ar = $details   -> groupBy('karat_ar');  
           $payments = EnterMoney::where('based_on_bill_number' , '=' , $bill -> bill_number) -> get();
           $company = CompanyInfo::first() ;
           $amar = '';
           
          /*
           $reportHtml = view('admin.Work.Exit.printA4_pdf' , compact('bill' , 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments' , 'company' ))->render();
           
           $arabic = new Arabic();
           $p = $arabic->arIdentify($reportHtml);
   
           for ($i = count($p)-1; $i >= 0; $i-=2) {
               $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
               $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
           }
   
           $pdf = PDF::loadHTML($reportHtml);
           return $pdf->download('report.pdf');
           */
          
/*
           $reportHtml = view('admin.Work.Exit.printA4_pdf' , compact('bill' , 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments' , 'company' ), [])->render();
           
           $arabic = new Arabic();
           $p = $arabic->arIdentify($reportHtml);
   
           for ($i = count($p)-1; $i >= 0; $i-=2) {
               $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
               $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
           }
           $pdf = PDF::loadHTML($reportHtml);
           return $pdf->download('report.pdf');
           */

           $pdf = PDF::setOptions(['fontDir'=>'rtl','defaultFont'=>'DINNextLTArabic-Regular-3']);
           $pdf = PDF::loadView('admin.Work.Exit.printA4_pdf' , compact('bill' , 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments' , 'company' ))->save('./uploads/pdf/'.$bill ->bill_number.'.pdf')->stream('download.pdf');
           
           NotificationWahtsapp::create([
               'bill_number' => $bill -> bill_number,
               'client_phone' => $bill -> client_phone,
               'user_id' => Auth::user() -> id
           ]);

           //return redirect()->intended('http://heera.it');
          // return Redirect::to('/')->with(['type' => 'error','message' => 'Your message'])->withInput(Input::except('password'));
          $redirectUrl = 'https://wa.me/'.$bill ->client_phone.'/?text='.env('APP_URL').'/uploads/pdf/'.$bill ->bill_number.'.pdf';

          return redirect()->away($redirectUrl);
          //return Redirect::to('https://wa.me/{{$bill ->client_phone}}/?text=urlencodedtext');
           //return redirect()->back()->with('success', 'تم ارسال الرسالة بنجاح');
   } 

}
