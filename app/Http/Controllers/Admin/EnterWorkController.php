<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Category;
use App\Models\Item;
use App\Models\CompanyInfo;
use App\Models\EnterOld;
use App\Models\EnterWork;
use App\Models\EnterWorkDetails;
use App\Models\ExitOld;
use App\Models\ExitOldDetails;
use App\Models\Journal;
use App\Models\JournalDetails;
use App\Models\Karat;
use App\Models\Pricing;
use App\Models\TaxSettings;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

class EnterWorkController extends WarehouseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){   

        $data = DB::table('enter_works')
            -> join('companies' , 'companies.id' , '=' , 'enter_works.supplier_id')
            -> join('branches' , 'branches.id' , '=' , 'enter_works.branch_id')
            -> select('enter_works.*' , 'companies.name as vendor_name','branches.branch_name')
            ->whereNull('enter_works.returned_bill_id')
            -> orderBy('id', 'DESC')  
            -> get(); 

        if (!empty(Auth::user()->branch_id)) {
            $data = $data->where('branch_id', Auth::user()->branch_id); 
        }  
        
        if ($request->ajax()) {  
            return Datatables::of($data)->addIndexColumn() 
                ->addColumn('bill_type', function($row){
                    if($row->bill_type == 0){
                        $span = 'خصم من رصيد الكسر '; 
                    }elseif($row->bill_type == 1){
                        $span = 'فاتورة عادية '; 
                    }else{
                        $span = 'خصم من رصيد الصافي ';  
                    }

                    return $span; 
                })  
                ->addColumn('action', function($row){
                    if(auth()->user()->can('عرض اوامر التوريد')){    
                        $btn = '<a href='.route('workEnterPrint',$row->id).' class="btn btn-info editBtn" role="button" target="_blank">
                                    <i class="fa fa-print"></i>
                                </a>'; 
                    }

                    if(auth()->user()->can('اضافة مردود مشتريات')){    
                        $btn =  $btn.'<a href='.route('create.return.purchase',$row->id).' class="btn btn-warning" role="button" target="_blank">
                                    <i class="fa fa-retweet"></i> عمل مردود مشتريات
                                </a>'; 
                    }

                    if(auth()->user()->can('حذف فاتورة مشتريات') ){   
                        $btn = $btn.'<button type="button" class="btn btn-labeled btn-danger deleteBtn "
                                        value="'.$row->id.'">
                                        <i class="fa fa-trash"></i>
                                    </button>';
                    }
                    return $btn; 
                }) 
                ->rawColumns(['bill_type','action']) 
                ->make(true);
        } 

        return view('admin.Work.Enter.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $vendors = Company::where('group_id' , '=' , 4) -> get();
        $karats = Karat::all();
        $setting = TaxSettings::all() -> first(); 
        $branches = Branch::where('status',1)->get();
        
        return view('admin.Work.Enter.Create' , compact('vendors' , 'karats' , 'setting', 'branches' ));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request -> bill_type == 1 ){
            return  $this -> store1($request);
        } else if($request -> bill_type == 2){
            return $this-> store3($request);
        }else {
            return $this-> store2($request);
        }
    }

    public function store1($request)
    {
        $request['bill_number'] = $this->get_work_entry_no(1,$request -> branch_id); 
        
        $validated = $request->validate([
            'date' => 'required',
            'bill_number' => 'required|unique:enter_works',
            'supplier_id' => 'required',
            'branch_id' => 'required'
        ]);

        $items = array();
        
        if(count($request -> karat_id)){
            //store header
            $total_money = 0 ;
            $total21_gold = 0 ;
            $made_total = 0;
            for($i = 0 ; $i < count($request -> karat_id) ; $i++ ){
                    $item =[
                        'bill_id' => 0,
                        'karat_id' => $request -> karat_id[$i],
                        'category_id' => $request -> category_id[$i] ?? 0, 
                        'weight' => $request -> weight[$i],
                        'weight21'=> $request -> weight21[$i],
                        'made_money'=> $request -> made_money[$i] ?? 0,
                        'made_value'=> $request -> made_Value[$i] ?? 0,
                        'net_weight' => $request -> weight [$i],
                        'tax' => $request -> tax_item[$i],
                        'net_money' => $request -> made_money[$i] + $request -> made_Value[$i],
                    ];
                    $total_money += $request -> made_money[$i];
                    $total21_gold += $request -> weight21[$i];
                    $made_total += $request -> made_Value[$i];
                    $items[] = $item ;
            }

           $id =  EnterWork::create([
                'branch_id' => $request -> branch_id,
                'bill_number' => $request -> bill_number,
                'bill_type'=> $request -> bill_type,
                'date' => $request -> date,
                'supplier_id' => $request -> supplier_id,
                'total_money' => $total_money,
                'total21_gold' => $total21_gold,
                'paid_money' => 0,
                'remain_money' => $request -> net_after_discount,
                'paid_gold' => 0,
                'remain_gold' => $total21_gold,
                'made_total'=> $made_total,
                'discount' => $request -> discount,
                'tax' => $request -> tax,
                'net_money' => $request -> net_after_discount,
                'supplier_bill_number' => $request -> supplier_bill_number,
                'pos' => 0,
                'notes'=> $request -> notes ?? '',
                'user_id' => Auth::user() -> id

            ]) -> id;

            foreach ($items as $product){
                $product['bill_id'] = $id;
                EnterWorkDetails::create($product) ; 
                $this -> syncQnt(1 , $product['karat_id'],0, $id , $product['weight'] , 1 , $request -> branch_id);
                /*
                //new code
                $this -> syncQnt(1 , $product['karat_id'],$product['category_id'], $id , $product['weight'] , 1 );
                $enter_Work_items = Item::where('category_id',$product['category_id']) 
                                        ->where('supplier_id',$request -> supplier_id)
                                        ->where('supplier_bill_number',$request -> supplier_bill_number)
                                        ->where('karat_id',$product['karat_id'])
                                        ->get(); 
                foreach ($enter_Work_items as $enter_Work_item){ 
                    $this -> makeItemsPurchase($enter_Work_item['id'] );
                }
                */
            }

            $this -> syncVendorAccount($request -> supplier_id , $request -> net_after_discount ,$total21_gold , -1 ,
                $id , $request -> bill_number , 'Work Entry Bill', $request -> branch_id); 

           $auto_accounting =  env("AUTO_ACCOUNTING", 1);
           if($auto_accounting == 1){
               $systemController = new SystemController(); 
               $systemController -> EnterWorkAccounting($id);
           }

           return redirect()->route('workEntryAll')->with('success' ,  __('main.created'));

        } else {
           return redirect()->route('workEntryAll')->with('error' ,  __('main.nodetails'));
        }
    }

    public function store2($request)
    {
        $validated = $request->validate([
            'date' => 'required',
            'bill_number' => 'required|unique:enter_works',
            'supplier_id' => 'required',
            'branch_id' => 'required'
        ]);

        $items = array();
        $items2 = array();
        if(count($request -> karat_id)){
            //enterwork
            $total_money = 0 ;
            $total21_gold = 0 ;
            $made_total = 0;

            //exitold 
            $total21_old_gold = 0 ; 

            for($i = 0 ; $i < count($request -> karat_id) ; $i++ ){
                    $item =[
                        'bill_id' => 0,
                        'karat_id' => $request -> karat_id[$i],
                        'category_id' => $request -> category_id[$i] ?? 0, 
                        'weight' => $request -> weight[$i],
                        'weight21'=> $request -> weight21[$i],
                        'made_money'=> $request -> made_money[$i] ?? 0,
                        'made_value'=> $request -> made_Value[$i] ?? 0,
                        'net_weight' => $request -> weight[$i],
                        'tax' => $request -> tax_item[$i],
                        'net_money' => $request -> made_money[$i] + $request -> made_Value[$i],
                    ];
                    $total_money += $request -> made_money[$i];
                    $total21_gold += $request -> weight21[$i];
                    $made_total += $request -> made_Value[$i];
                    $items[] = $item ;

                    //exitold
                    //if( $request ->weight_type[$i] >= $request -> weight[$i] ){ 
                        $item2 =[
                            'bill_id' => 0,
                            'karat_id' => $request -> karat_id[$i], 
                            'weight' => $request -> weight[$i], 
                            'weight21'=>  $request -> weight21[$i], 
                            'made_money'=> 0, 
                            'net_weight' => $request -> weight[$i], 
                            'net_money' => 0,
                        ]; 
                        
                        $items2[] = $item2 ;

                    //}   
            }

           $id =  EnterWork::create([
                'branch_id' => $request -> branch_id,
                'bill_number' => $request -> bill_number,
                'bill_type'=> $request -> bill_type,
                'date' => $request -> date,
                'supplier_id' => $request -> supplier_id,
                'total_money' => $total_money,
                'total21_gold' => $total21_gold,
                'paid_money' => 0,
                'remain_money' => $request -> net_after_discount,
                'paid_gold' => 0,
                'remain_gold' => $total21_gold,
                'made_total'=> $made_total,
                'discount' => $request -> discount,
                'tax' => $request -> tax,
                'net_money' => $request -> net_after_discount,
                'supplier_bill_number' => $request -> supplier_bill_number,
                'pos' => 0,
                'notes'=> $request -> notes ?? '',
                'user_id' => Auth::user() -> id

            ]) -> id;

            foreach ($items as $product){
                $product['bill_id'] = $id;
                EnterWorkDetails::create($product) ; 
                $this -> syncQnt(1 , $product['karat_id'],0, $id , $product['weight'] , 1 , $request -> branch_id);
            }
            $this -> syncVendorAccount($request -> supplier_id , $request -> net_after_discount ,$total21_gold , -1 ,
            $id , $request -> bill_number , 'Work Entry Bill', $request -> branch_id); 

           $auto_accounting =  env("AUTO_ACCOUNTING", 1);
           if($auto_accounting == 1){
               $systemController = new SystemController(); 
               $systemController -> EnterWorkAccounting($id);
           }

           //exieold
           $val = $total21_gold ;
           $bill_number2 = $this ->get_old_exit_no($request -> branch_id);
           $id2 =  ExitOld::create([
               'branch_id' => $request -> branch_id,
               'bill_number' => $bill_number2,
               'bill_type' => 0,
               'date' => $request -> date,
               'supplier_id' => $request -> supplier_id,
               'total_money' => 0,
               'total21_gold' => $total21_gold ,
               'paid_money' => 0,
               'remain_money' => $total21_gold ,
               'paid_gold' => 0,
               'remain_gold' => 0,
               'discount' => 0,
               'net_money' => 0,
               'bill_client_name' => $request -> bill_number,
               'pos' => 0,
               'notes'=> $request -> notes ?? '',
               'user_id' => Auth::user() -> id

           ]) -> id;
           /*
           $auto_accounting =  env("AUTO_ACCOUNTING", 1);
           if($auto_accounting == 1){
               $systemController = new SystemController();
               $systemController -> ExitOldAccounting($id2);
           }
           */
           $enterWorkToPay = EnterWork::where('supplier_id' , '=' , $request -> supplier_id)
               ->where('remain_gold' , '>' , 0)-> get();

           foreach ($enterWorkToPay as $bill){
               if($val > 0){
                   if($bill -> remain_gold <=  $val){
                       $bill -> paid_gold += $bill -> remain_gold ;
                       $val -= $bill -> remain_gold ;
                       $bill -> remain_gold = 0 ; 
                       $bill -> update();

                   } else {
                       $bill -> remain_gold -= $val ;
                       $bill -> paid_gold += $val  ;
                       $val = 0 ;
                       $bill -> update();
                       break;
                   }
               } else {
                   break;
               }
           }

           foreach ($items2 as $product2){
               $product2['bill_id'] = $id2;
               ExitOldDetails::create($product2) ;

               $this -> syncQnt(0 , $product2['karat_id'],0, $id2 , $product2['weight'] , -1 , $request -> branch_id);
           }
           $this -> syncVendorAccount($request -> supplier_id , 0 ,$total21_gold , 1 ,
               $id2 , $request -> bill_number , 'Old Exit Bill', $request -> branch_id);

           return redirect()->route('workEntryAll')->with('success' ,  __('main.created'));

        } else {
           return redirect()->route('workEntryAll')->with('error' ,  __('main.nodetails'));
        }
    }
 
    
    public function store3($request)
    {
        $validated = $request->validate([
            'date' => 'required',
            'bill_number' => 'required|unique:enter_works',
            'supplier_id' => 'required',
            'branch_id' => 'required'
        ]);

        $items = array();
        $items2 = array();

        if(count($request -> karat_id)){

            //enterwork
            $total_money = 0 ;
            $total21_gold = 0 ;
            $made_total = 0;

            //exitold 
            $total21_old_gold = 0 ; 
            $k24 = Karat::where('label','K24')->first();

            for($i = 0 ; $i < count($request -> karat_id) ; $i++ ){
                $item =[
                    'bill_id' => 0,
                    'karat_id' => $request -> karat_id[$i],
                    'category_id' => $request -> category_id[$i] ?? 0, 
                    'weight' => $request -> weight[$i],
                    'weight21'=> $request -> weight21[$i],
                    'made_money'=> $request -> made_money[$i] ?? 0,
                    'made_value'=> $request -> made_Value[$i] ?? 0,
                    'net_weight' => $request -> weight[$i],
                    'tax' => $request -> tax_item[$i],
                    'net_money' => $request -> made_money[$i] + $request -> made_Value[$i],
                ];
                $total_money += $request -> made_money[$i];
                $total21_gold += $request -> weight21[$i];
                $made_total += $request -> made_Value[$i];
                $items[] = $item ;

                //exitPure
                //if( $request ->weight_type[$i] >0 ){ 
                    $item2 =[
                        'bill_id' => 0,
                        'karat_id' => $k24->id , 
                        'weight' => $request ->weight21[$i]  / 1.1428, 
                        'weight21'=>  $request ->weight21[$i], 
                        'made_money'=> 0, 
                        'net_weight' => $request ->weight21[$i]  / 1.1428, 
                        'net_money' => 0,
                    ]; 
                    
                    $items2[] = $item2 ;
                //}  
            }

           $id =  EnterWork::create([
                'branch_id' => $request -> branch_id,
                'bill_number' => $request -> bill_number,
                'bill_type'=> $request -> bill_type,
                'date' => $request -> date,
                'supplier_id' => $request -> supplier_id,
                'total_money' => $total_money,
                'total21_gold' => $total21_gold,
                'paid_money' => 0,
                'remain_money' => $request -> net_after_discount,
                'paid_gold' => 0,
                'remain_gold' => $total21_gold,
                'made_total'=> $made_total,
                'discount' => $request -> discount,
                'tax' => $request -> tax,
                'net_money' => $request -> net_after_discount,
                'supplier_bill_number' => $request -> supplier_bill_number,
                'pos' => 0,
                'notes'=> $request -> notes ?? '',
                'user_id' => Auth::user() -> id

            ]) -> id;

            foreach ($items as $product){
                $product['bill_id'] = $id;
                EnterWorkDetails::create($product) ; 
                $this -> syncQnt(1 , $product['karat_id'],0, $id , $product['weight'] , 1 , $request -> branch_id);
            }

            $this -> syncVendorAccount($request -> supplier_id , $request -> net_after_discount ,$total21_gold , -1 ,
                $id , $request -> bill_number , 'Work Entry Bill', $request -> branch_id); 

           $auto_accounting =  env("AUTO_ACCOUNTING", 1);
           if($auto_accounting == 1){
               $systemController = new SystemController(); 
               $systemController -> EnterWorkAccounting($id);
           }

           //exiePure
           $val = $total21_gold ;
           $bill_number2 = $this ->get_old_exit_no($request -> branch_id);
           $id2 =  ExitOld::create([
               'branch_id' => $request -> branch_id,
               'bill_number' => $bill_number2,
               'bill_type' => 2,
               'date' => $request -> date,
               'supplier_id' => $request -> supplier_id,
               'total_money' => 0,
               'total21_gold' => $total21_gold ,
               'paid_money' => 0,
               'remain_money' => $total21_gold ,
               'paid_gold' => 0,
               'remain_gold' => 0,
               'discount' => 0,
               'net_money' => 0,
               'bill_client_name' => $request -> bill_number,
               'pos' => 0,
               'notes'=> $request -> notes ?? '',
               'user_id' => Auth::user() -> id

           ]) -> id;
           /*
           $auto_accounting =  env("AUTO_ACCOUNTING", 1);
           if($auto_accounting == 1){
               $systemController = new SystemController();
               $systemController -> ExitOldAccounting($id2);
           }
           */

           $enterWorkToPay = EnterWork::where('supplier_id' , '=' , $request -> supplier_id)
               ->where('remain_gold' , '>' , 0)-> get();

           foreach ($enterWorkToPay as $bill){
               if($val > 0){
                   if($bill -> remain_gold <=  $val){
                       $bill -> paid_gold += $bill -> remain_gold ;
                       $val -= $bill -> remain_gold ;
                       $bill -> remain_gold = 0 ; 
                       $bill -> update();

                   } else {
                       $bill -> remain_gold -= $val ;
                       $bill -> paid_gold += $val  ;
                       $val = 0 ;
                       $bill -> update();
                       break;
                   }
               } else {
                   break;
               }
            }

            foreach ($items2 as $product2){
                $product2['bill_id'] = $id2;
                ExitOldDetails::create($product2) ;

                $this -> syncQnt(2 , $k24->id,0, $id2 , $product2['weight'] , -1 , $request -> branch_id);
            }
            $this -> syncVendorAccount($request -> supplier_id , 0 ,$total21_gold , 1 ,
                $id2 , $request -> bill_number , 'Pure Exit Bill', $request -> branch_id);

            return redirect()->route('workEntryAll')->with('success' ,  __('main.created'));

        } else {
           return redirect()->route('workEntryAll')->with('error' ,  __('main.nodetails'));
        }
    }
   

    public function edit($id)
    {
        $purchase = EnterWork::find($id);

        if($purchase->net_money < 0){
            return redirect()->back();
        } 

        $purchaseItems = EnterWorkDetails::join('karats','karats.id','=','enter_work_details.karat_id')
            ->select('enter_work_details.*','karats.name_ar as karat_name')
            ->where('bill_id',$id)
            ->get();
   
        $zeroItems = 0;

        foreach ($purchaseItems as $purchaseItem){ 
            $returnedQnt = $this->getAllProductReturnForSameInvoice($id,$purchaseItem->karat_id);
            $purchaseItem->weightItem = $purchaseItem->weight;
            $purchaseItem->weight = $purchaseItem->weight + $returnedQnt;

            if($purchaseItem->weight <= 0){
                $zeroItems +=1;
            }

        }

        if($zeroItems >= count($purchaseItems)){
            return redirect()->back();
        } 

        $purchase->supplier_name = Company::find($purchase->supplier_id)->name; 

        return view('admin.Work.Return.create',compact('purchaseItems','id','purchase'));

    }


    public function purchase_return(){

        $data = EnterWork::where('returned_bill_id' , '>' , 0 ) ->get();
        
        if(!empty(Auth::user()->branch_id)) {
            $data = $data->where('branch_id', Auth::user()->branch_id); 
        }  

        return view('admin.Work.Return.index',compact('data'));
    }

    private function getAllProductReturnForSameInvoice($invoiceId,$karatId){

        $totalQnt = 0; 
        $allOtherPurchaseItems = EnterWorkDetails::join('enter_works','enter_works.id','=','enter_work_details.bill_id')
            ->select('enter_work_details.*')
            ->where('enter_works.returned_bill_id',$invoiceId)
            ->where('enter_work_details.karat_id',$karatId)
            ->get();

        foreach ($allOtherPurchaseItems as $item){
            $totalQnt += $item->weight;
        }

        return $totalQnt;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePurchaseRequest  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request  $request, $billid)
    {
        $request['bill_number'] = $this->get_return_purchases_no( 1 ,$request -> branch_id); 

        $validated = $request->validate([
            'bill_number' => 'required|unique:enter_works', 
            'supplier_id' => 'required', 
        ]);
        
        $siteController = new SystemController();

        $total = 0;
        $total21_gold = 0;
        $made_total = 0;
        $tax = 0;
        $discount = 0;
        $net = 0; 

        $items = array();
        $weightKarats = array();

        for($i = 0 ; $i < count($request -> karat_id) ; $i++ ){
            $item = [
                'bill_id' => 0,
                'karat_id' => $request->karat_id[$i],
                'category_id' => 0,
                'weight' => $request->weight[$i]* -1,
                'weight21' => $request->weight21[$i]* -1,
                'total_money' => $request->total_all[$i]* -1,
                'made_money' => $request->total[$i]* -1,
                'made_value' => $request->made_value[$i]* -1,
                'net_weight' => $request->weight[$i]* -1,
                'tax' => $request->tax[$i]* -1,
                'net_money' => ( $request->total[$i]* -1) + ($request->made_value[$i]* -1) , 
            ];
           
            $total += $request->total_all[$i];
            $total21_gold += $request->weight21[$i];
            $tax += $request->tax[$i]; 
            $made_total += $request->made_value[$i];
            $net += ($request->net[$i]); 

            $items[] = $item ;
        } 

        $invoice = EnterWork::find($billid);

        $return = EnterWork::create([
            'returned_bill_id' => $invoice->id,
            'branch_id' => $request->branch_id,
            'date' => $request->bill_date,
            'bill_number' => $request-> bill_number,
            'bill_type' => $invoice->bill_type,
            'supplier_bill_number' => $invoice->supplier_bill_number,
            'supplier_id' => $request->supplier_id, 
            'total_money' => $total * -1,
            'total21_gold'=> $total21_gold * -1,
            'paid_money'=> 0,
            'remain_money' => 0,
            'paid_gold' => 0,
            'remain_gold' => 0,
            'made_total' => $made_total * -1,
            'discount' => 0,
            'tax' => $tax * -1,
            'net_money' => $net * -1,
            'notes' => $request->notes ?? '',
            'user_id'=> Auth::user()->id
        ]);

        foreach ($items as $product){
            $product['bill_id'] = $return->id;
            EnterWorkDetails::create($product);
            $this -> syncQnt(1 , $product['karat_id'],0, $return->id, $product['weight'] * -1 , -1, $request -> branch_id);
        }

        $this -> syncVendorAccount($request -> supplier_id , $net , $total21_gold, 1 ,
            $return->id , $request -> bill_number , 'Return Work Enter Bill',$request -> branch_id);

        $auto_accounting =  env("AUTO_ACCOUNTING", 1);

        if($auto_accounting == 1){
            $systemController = new SystemController();
            $systemController -> ReturnEnterWorkAccounting($return->id);
        }

        return redirect()->route('purchase.return');
    }

    public function get_work_entry_no($type ,$branch_id){

        $bills = EnterWork::where('branch_id',$branch_id)
            ->where('returned_bill_id','>',0)
            ->count(); 

        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        } 

        $i = 0;
        do { 
            $i++;
            $prefix = "WE-".$branch_id."-";
            $no = json_encode($prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT)) ;
            $no2 = $prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT) ;
        } while (EnterWork::where("bill_number","=",$prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT))->exists());
        
        if($type > 0){
            return $no2;
        }else{
            echo $no ;
            exit;
        }
   
    }

    public function get_purchase_pos_no($branch_id){

        $bills = EnterOld::where('branch_id', $branch_id)->count();

        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        }
  
        $i = 0;
        do { 
            $i++;
            $prefix = "SPOI-".$branch_id."-";
            $no = json_encode($prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT)) ;
        } while (EnterOld::where("bill_number","=",$prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT))->exists());
     
        echo $no ;
        exit;
    }

    public function get_old_exit_no($branch_id){

        $bills = ExitOld::where('branch_id', $branch_id)->count();
        
        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        }

        $i = 0;
        do { 
            $i++;
            $prefix = "SOSI-".$branch_id."-";
            $no = $prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT);
        } while (ExitOld::where("bill_number","=",$prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT))->exists());
     
        return $no;
    }

    public function get_return_purchases_no($type,$branch_id){ 

        $bills = EnterWork::where('branch_id',$branch_id)
            ->where('returned_bill_id','>',0)
            ->count(); 
       
        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        } 

        $prefix = "RWE" .'-'.$branch_id.'-';
 
        if($type == 1){
            $no = $prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT);
            return $no ; 
        }else{
            $no = json_encode($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
            echo $no ;
            exit;
        }

    }

    public function show($id)
    {
        $bill = DB::table('enter_works')
            -> join('companies' , 'companies.id' , '=' , 'enter_works.supplier_id')
            -> select('enter_works.*' , 'companies.name as vendor_name')
            -> where('enter_works.id' , '=' , $id)
            -> get() -> first();

        $vendors = Company::where('group_id' , '=' , 4) -> get();

        $details   =  DB::table('enter_work_details')
            -> join('karats' , 'karats.id' , '=' , 'enter_work_details.karat_id')
            -> select('enter_work_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor')
            -> where('enter_work_details.bill_id' , '=' , $id)
            -> get();

    
        return view('admin.Work.Enter.Preview' , compact('bill' , 'details' , 'vendors' ));
    }

    public function print($id){
        $bill = DB::table('enter_works')
            -> join('companies' , 'companies.id' , '=' , 'enter_works.supplier_id')
            -> join('branches' , 'branches.id' , '=' , 'enter_works.branch_id')
            -> select('enter_works.*' , 'companies.name as vendor_name', 'branches.branch_name','companies.vat_no as vendor_vat_no')
            -> where('enter_works.id' , '=' , $id)
            -> first();


        $karats = Karat::all();
        $details   =  DB::table('enter_work_details')
            -> join('karats' , 'karats.id' , '=' , 'enter_work_details.karat_id')
            -> select('enter_work_details.*' , 'karats.name_ar as karat_ar', 'karats.name_en as karat_en' , 'karats.transform_factor')
            -> where('enter_work_details.bill_id' , '=' , $id)
            -> get();

        $grouped_ar = $details -> groupBy('karat_ar');
        $suppliers =  Company::where('group_id' , '=' , 4) -> get(); 
        $company = CompanyInfo::first() ;
        $pos = \Illuminate\Support\Env::get('PROGRAMME_TYPE');
        if($pos == 0) {//A4
            return view('admin.Work.Enter.print' , compact('bill' , 'details' , 'karats' , 'grouped_ar','company'));
        } else { //A5
            return view('admin.Work.Enter.printA5 ' , compact('bill' , 'details' , 'karats' , 'grouped_ar','company'));
        } 
    }

    
    public function getSupplierKarat($supplier_id){ 

        $karats  = Item::select('karat_id')
            ->with('karat')
            ->where('supplier_id' , $supplier_id)
            ->where('state',-1)
            ->groupBy('karat_id')
            ->get();   

        echo json_encode($karats);
        exit();
    } 

    public function getSupplierItem($supplier_id,$karat_id){ 

        $karats  = Item::select('category_id')
            ->with('category')
            ->where('supplier_id' , $supplier_id)
            ->where('karat_id' , $karat_id)
            ->where('state',-1)
            ->groupBy('category_id')
            ->get();    

        echo json_encode($karats);
        exit();
    } 

    public function getSupplierBill($supplier_id,$bill_no){ 

        $karats  = Item::select('karat_id')
            ->with('karat','category')
            ->where('supplier_id' , $supplier_id)
            ->where('supplier_bill_number' , $bill_no) 
            ->where('state',-1) 
            ->groupBy('karat_id')
            ->get();      
 
        echo json_encode($karats);
        exit();
    } 


    public function getClientSupplierKarat($supplier_id,$bill_no,$karat_id,$category_id){  

        $category = Category::FindOrFail($category_id);
        $category -> supplier_id = $supplier_id;
        $category -> supplier_bill_number = $bill_no;

        $itmes = Item::with('karat')
            ->where('category_id' , $category_id)
            ->where('supplier_id' , $supplier_id)
            ->where('supplier_bill_number' , $bill_no)
            ->where('karat_id' , $karat_id)
            ->where('state',-1)
            ->get();

        $made_Value = 0; 
        $price =0;
        $cost = 0; 
        $weight = 0;

        foreach ($itmes as $itme){ 
            $category -> karat_name = $itme->karat->name_ar;
            $category -> karat_id = $itme->karat_id;
            $category -> category_id = $itme->category_id;
            $category -> transform_factor = $itme->karat->transform_factor;
            $category -> stamp_value = $itme->karat->stamp_value;
            $made_Value += $itme->made_Value * $itme->weight;
            $price += $itme->price;
            $cost += $itme->cost;
            $weight +=$itme->weight;
        } 
        
        if($category){  
            $category -> made_Value = $made_Value;
            $category -> price = $price;
            $category -> cost = $cost;
            $category -> weight = $weight;
            echo json_encode($category);
            exit;
        } 
    } 

    public function destroy($id)
    {
        $bill = EnterWork::find($id);
        if($bill){
            $details = EnterWorkDetails::where('bill_id' , '=' , $id) -> get();
            $this -> deleteQnt($id);
            $this -> deleteVendorMove($bill -> supplier_id , $id , $bill -> total_money , $bill -> total21_gold , 'Work Entry Bill');
            $this -> deleteAccountingData($id , $bill -> bill_number , 'شراء ذهب مشغول');


            foreach ($details as $detail){
                $detail -> delete();
            }
            $bill -> delete();
            return redirect()->route('workEntryAll')->with('success' ,  __('main.deleted'));
        }


    }

    function deleteAccountingData($bill_id , $bill_number , $basedon_txt){
        $journal = Journal::where('basedon_no' , '=' , $bill_number)
            ->where('basedon_id' , '=' , $bill_id)
            ->where('baseon_text' , '=' , $basedon_txt) -> get() -> first();
        if($journal){
            $details = JournalDetails::where('journal_id' , '=' , $journal -> id) -> get();
            $movements = AccountMovement::where('journal_id' , '=' , $journal -> id) -> get();
            foreach ($movements as $movement){
                $movement -> delete();
            }
            foreach ($details as $detail){
                $detail -> delete();
            }
            $journal -> delete();
        }
    }

}
