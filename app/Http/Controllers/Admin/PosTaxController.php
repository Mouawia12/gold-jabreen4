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
use App\Models\ExitOldTax;
use App\Models\ExitOldTaxDetails;
use App\Models\ExitWorkTax;
use App\Models\ExitWorkTaxDetails;
use App\Models\Item;
use App\Models\Karat;
use App\Models\Pricing;
use App\Models\TaxSettings;
use App\Models\AccountsTree;
use App\Models\Branch;
use App\Models\CatchGoldRecipts;
use Carbon\Carbon;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
 

class PosTaxController extends WarehouseController
{
 
    public function pos_sales(){

        $work = ExitWorkTax::with('branch:id,branch_name','cash:id,based_on_bill_number,amount','visa:id,based_on_bill_number,amount')
            ->where('pos' , 1) 
            ->where('net_money' , '>=' , 0)
            ->orderBy('id', 'DESC')
            -> get();

        $old = ExitOldTax::with('branch:id,branch_name','cash:id,based_on_bill_number,amount','visa:id,based_on_bill_number,amount')
            ->where('pos' , 1) 
            ->where('net_money' , '>=' , 0) 
            ->orderBy('id', 'DESC')
            -> get();

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
        //return $data->all();
        return view ('admin.postax.sales' , compact('data' ));

    }
 
    public function pos_create(){

        $customers =  Company::where('group_id' , '=' , 3)->where('vat_no' , '>' , 1) -> get();
        $suppliers =  Company::where('group_id' , '=' , 4) -> get();
        $karats = Karat::all();
        $setting = TaxSettings::all() -> first();
        $pricings = Pricing::all(); 
        $type = 3;
        $accounts = AccountsTree::all() ;
        $branches = Branch::where('status',1)->get();
        
        return view('admin.postax.create' , compact( 'branches','suppliers' ,'type','accounts','customers' ,'karats' , 'setting' ));
    }

    public function pos_create_gold_recipts($id){

        $catch_gold_recipt = CatchGoldRecipts::find($id);
        $customers =  Company::where('id' ,$catch_gold_recipt->supplier_id) -> get(); 
        $karats = Karat::all();
        $setting = TaxSettings::all() -> first();  
        $accounts = AccountsTree::all() ;
        $branches = Branch::where('status',1)->get();
        
        return view('admin.postax.create_catch_gold' , compact( 'branches','accounts','customers'
            ,'karats' , 'setting', 'catch_gold_recipt'));
    }

    public function store_pos(Request $request){ 
        
          if($request -> document_type == 1 ){ 
            return  $this -> sellNewGold($request);
          } else if($request -> document_type == 0 or $request -> document_type == 2){
              return $this-> sellOldGold($request);
          }
    }

    public function MakePayment($request , $money , $type , $based_on , $doc_type ,$based_on_num){
        
        $bill_number = $this -> getpaymentNo($request -> branch_id) ;

        $id =  EnterMoney::create([
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
                $bill = ExitWorkTax::find($based_on);
            } else {
                $bill = ExitOldTax::find($based_on);
            }

            if($bill ){
                $bill -> remain_money -= $money ;
                $bill -> paid_money += $money ;
                $bill -> update();
            }
        }
    }

    public function MakePaymentOut($request , $money , $type , $based_on ){

        $bill_number = $this -> getpaymentOutNo($request -> branch_id);

        $id = ExitMoney::create([
            'branch_id' => $request -> branch_id ,
            'doc_number' => $bill_number ,
            'date' => $request -> bill_date2,
            'supplier_id' => $request -> customer_id2,
            'type' => 1 ,
            'based_on' => $based_on,
            'amount' => $money,
            'payment_method' => $type,
            'price_gram' => 0,
            'based_on_bill_number' => $request -> bill_number2, 
            'notes' =>  '',
            'user_id' => Auth::user() -> id
        ]) -> id   ;


        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        if($auto_accounting == 1){
            $systemController = new SystemController();
            $systemController -> ExitMoneyAccounting($id);
        }

        if($request -> customer_id2 > 0){
            $moneyout = $money ;
            $gold = 0;
            $this->syncVendorAccount($request->customer_id2, $moneyout, $gold, 1,
                $id, $bill_number, 'Exit Money Bill',$request -> branch_id);
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
            $bills = ExitWorkTax::where('branch_id', $branch_id)
                ->where('returned_bill_id',0)
                ->count();

            $prefix = "SWSIX-".$branch_id."-";

        } else { 

            $bills = ExitOldTax::where('branch_id', $branch_id)
                ->where('returned_bill_id',0)
                ->count();

            $prefix = "SOSIX-".$branch_id."-";
        }

        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        }
 
        if($type == 1){
            $no = json_encode($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
            echo $no ;
            exit;

        }else{
            $no = $prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT);
            return $no ; 
        }
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
        $no = ($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
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
     
        return $no ;
    }

    public function GetWorkReturnNo($branch_id){

        $bills = ExitWorkTax::where('branch_id', $branch_id)
            ->where('returned_bill_id','>',0)
            ->count(); 

        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        }
            
        $prefix = "RSWSIX-".$branch_id."-";
        $no = ($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
        return $no ;
    }

    public function GetWorkOldReturnNo($branch_id){

        $bills = ExitOldTax::where('branch_id', $branch_id)
            ->where('returned_bill_id','>',0)
            ->count(); 

        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        }
            
        $prefix = "RSOSIX-".$branch_id."-";
        $no = ($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
        return $no ;
    }
 
    public function pos_payment_show($money , $type){
        $html = view('admin.postax.payment' , compact('money' , 'type')) -> render();
        return $html ;
    }

    public function pos_payment_catch_gold_show($money , $type , $amount){
        $html = view('admin.postax.payment2' , compact('money' , 'type', 'amount')) -> render();
        return $html ;
    }

    public function sellNewGold($request){

        try { 

            $request['bill_number'] = $this->get_sales_pos_no(2, 1 ,$request -> branch_id); 

            $validated = $request->validate([
                'bill_date' => 'required',
                'bill_number' => 'required|unique:exit_works_tax',
                'customer_id' => 'required',
                'branch_id' => 'required',
            ]);
    
            $items = array();
            if(count($request -> item_id )){ 

                $total = 0 ;
                for($i = 0 ; $i < count($request -> item_id) ; $i++ ){
                    $item =[
                        'bill_id' => 0,
                        'item_id' => $request -> item_id[$i],
                        'karat_id' => $request -> karat_id[$i],
                        'weight' => $request -> weight[$i],
                        'gram_price' => $request -> gram_price[$i],
                        //'gram_manufacture' => $request -> gram_manufacture[$i],
                        'gram_manufacture' => 0,
                        'gram_tax' => $request -> item_tax[$i],
                        'net_money'=> $request -> net_money[$i],
                    ];
                    $total += ($request -> net_money[$i] - $request -> item_tax[$i]);
                    $items[] = $item ;
                }

                $customers =  Company::where('id' ,$request -> customer_id) -> first();
    
                $id =  ExitWorkTax::create([
                    'uuid' => Str::uuid(),
                    'branch_id' => $request -> branch_id,
                    'bill_number' => $request -> bill_number,
                    'date' => $request -> bill_date, 
                    'type' => $request -> bill_type ?? 0, 
                    'client_id' => $request -> customer_id,
                    'client_tax_number' => $customers->vat_no,
                    'total_money' => $total,
                    'total21_gold' => $request -> total_weight21,
                    'paid_money' => $request -> paid,
                    'remain_money' => $request -> net_after_discount - $request -> paid,
                    'paid_gold' => 0,
                    'remain_gold' => 0,
                    'discount' => $request -> discount,
                    'tax' => $request ->tax ,
                    'net_money' => $request -> net_after_discount,
                    'bill_client_name' =>  $customers->name,
                    'pos' => 1,
                    'notes'=> $request -> notes ?? '',
                    'user_id' => Auth::user() -> id
                ]) -> id;
     
                foreach ($items as $product){
                    $product['bill_id'] = $id;
                    ExitWorkTaxDetails::create($product) ;
                    $this -> syncQnt(1 , $product['karat_id'],0, $id , $product['weight'] , -1, $request -> branch_id);
                    $this -> makeItemUnAvailable($product['item_id'] );
                }

                $this -> syncVendorAccount($request -> customer_id , $request -> net_after_discount ,0 , 1 ,
                    $id , $request -> bill_number , 'Work Exit Bill',$request -> branch_id);
    
                if($request -> cash > 0){
                    $this -> MakePayment($request , $request -> cash , 0 , $id ,1 , $request -> bill_number);
                }

                if($request -> visa > 0){
                    $this -> MakePayment($request , $request -> visa , 1 , $id , 1 , $request -> bill_number);
                }

                if(isset($request ->catch_id)){
                    $catch_gold_recipt = CatchGoldRecipts::find($request ->catch_id);
                    $catch_gold_recipt -> sale_id = $id;
                    $catch_gold_recipt -> update();
                }
    
                $auto_accounting =  env("AUTO_ACCOUNTING", 1);
                if($auto_accounting == 1){
                    $systemController = new SystemController();
                    $systemController -> ExitWorkTaxAccounting($id);
                }

                //$Standard_invoice = new ZataStandardControlle();
                //$Standard_invoice->Standard_tax_invoice($id);
    
                return redirect()->route('workExitPreviewTax' , $id)
                    ->with('success' ,  __('main.created'));
            
            } else {
                return redirect()->route('pos_tax_create')
                    ->with('error' ,  __('main.nodetails'));
            }

        } catch (QueryException $ex) {
            return redirect()->route('pos_tax_create')
                ->with('error', $ex->getMessage());
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

                for($i = 0 ; $i < count($request -> karat_id_old) ; $i++ ){

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
    
                $customers =  Company::where('id' ,$request -> customer_id) -> first();
    
                $id =  ExitOldTax::create([
                    'uuid' => Str::uuid(),
                    'branch_id' => $request -> branch_id,
                    'bill_number' => $request -> bill_number,
                    'date' => $request -> bill_date,
                    'bill_type' => $request -> document_type,
                    'supplier_id' => $request -> customer_id,
                    'client_tax_number' => $customers->vat_no,
                    'total_money' => $total_money,
                    'total21_gold' => $total21_gold,
                    'paid_money' => 0,
                    'remain_money' => $request -> net_after_discount,
                    'paid_gold' => 0,
                    'remain_gold' => 0,
                    'discount' => $request -> discount,
                    'tax' => $request -> tax ,
                    'net_money' => $request -> net_after_discount,
                    'bill_client_name' =>  $customers->name,
                    'pos' => 1,
                    'notes'=> $request -> notes ?? '',
                    'user_id' => Auth::user() -> id
    
                ]) -> id;
    
                foreach ($items as $product){
                    $product['bill_id'] = $id;
                    ExitOldTaxDetails::create($product) ;
                    $this -> syncQnt(0 , $product['karat_id'],0, $id , $product['weight'] , -1, $request -> branch_id);
                }
    
                $this -> syncVendorAccount($request -> customer_id , $request -> net_after_discount , 0 , 1 ,
                    $id , $request -> bill_number , 'Old Exit Bill', $request -> branch_id);
    
                if($request -> cash > 0){
                    $this -> MakePayment($request , $request -> cash , 0 , $id , 2 , $request -> bill_number);
                }
                if($request -> visa > 0){
                    $this -> MakePayment($request , $request -> visa , 1 , $id , 2 , $request -> bill_number);
                }
    
                $auto_accounting = env("AUTO_ACCOUNTING", 1);
                if($auto_accounting == 1){
                    $systemController = new SystemController();
                    $systemController -> ExitOldTaxAccounting($id);
                }
                //   return $this -> pos_payment_show( $request -> net_after_discount);
                return redirect()->route('oldExitTaxPreview' ,$id )->with('success' ,  __('main.created'));
            } else {
                return redirect()->route('pos_tax_create')->with('error' ,  __('main.nodetails'));
            }

        } catch (QueryException $ex) {
            return redirect()->route('pos_tax_create')->with('error', $ex->getMessage());
        }
       
    }

 
    public function test_print(){
        return view ('pos.print_sales');
    }

    public function return_work($id){

        if (!empty(Auth::user()->branch_id)) {
            $bill = DB::table('exit_works_tax')
                -> leftJoin('companies' , 'companies.id' , '=' , 'exit_works_tax.client_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_works_tax.branch_id')
                -> select('exit_works_tax.*' , 'companies.name as vendor_name', 'branches.branch_name', 'companies.vat_no as vendor_vat_no')
                -> where('exit_works_tax.id' , '=' , $id)  
                -> where('exit_works_tax.branch_id' ,Auth::user()->branch_id)
                -> first();
                
            if(!$bill)  return ;
        }else{

            $bill = DB::table('exit_works_tax')
                -> leftJoin('companies' , 'companies.id' , '=' , 'exit_works_tax.client_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_works_tax.branch_id')
                -> select('exit_works_tax.*' , 'companies.name as vendor_name', 'branches.branch_name', 'companies.vat_no as vendor_vat_no')
                -> where('exit_works_tax.id' , '=' , $id)   
                -> first();
        } 

        $details   =  DB::table('exit_work_tax_details')
            -> join('items' , 'items.id' , '=' , 'exit_work_tax_details.item_id')
            -> join('karats' , 'karats.id' , '=' , 'exit_work_tax_details.karat_id')
            -> select('exit_work_tax_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor as transform_factor', 'items.name_ar as item_ar' , 'items.name_en as item_en')
            -> where('exit_work_tax_details.bill_id' , '=' , $id)
            -> get(); 

        return view ('admin.postax.workReturn' , compact('bill' , 'details'));
    }

    public function return_work_post(Request $request){

        $bill = ExitWorkTax::find($request -> bill_id);
        $data = ExitWorkTaxDetails::where('bill_id' , '=' , $request -> bill_id) -> get();
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

        $previous_invoice = ExitWorkTax::where('net_money','<',0)->orderBy('id', 'DESC')->limit(1)->first();
        
        if($previous_invoice){
            $previous_invoice_hash = $previous_invoice->invoice_hash;
        }else{
            $previous_invoice_hash = '';
        }

        $bill_number = $this -> GetWorkReturnNo($bill -> branch_id); 

        $id = ExitWorkTax::create([
            'uuid' => Str::uuid(),
            'branch_id' => $bill -> branch_id,
            'bill_number' => $bill_number,
            'date' => Carbon::now(),
            'client_id' => $bill -> client_id,
            'client_tax_number'=> $bill -> client_tax_number,
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
                $this -> syncQnt(1 , $item -> karat_id,0, $id , $item -> weight , 1,$bill -> branch_id);
            }

            ExitWorkTaxDetails::create([
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
            $id ,  $bill_number , 'Return Work Exit Tax Bill',$bill -> branch_id);
       
        //update 15-10-2023
        $request['bill_date2'] =  Carbon::now();
        $request['customer_id2'] =  $bill -> client_id ;
        $request['bill_number2'] = $request -> bill_number; 
        $request['branch_id'] = $bill -> branch_id; 
    
        $this -> MakePaymentOut($request , $net , 0 , $id );    
       
        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        if($auto_accounting == 1){
            $systemController = new SystemController();
            $systemController -> ReturnExitWorkTaxAccounting($id);
        }
 
        $Standard_invoice = new ZataStandardControlle();
        $Standard_invoice->Standard_credit($id, $previous_invoice_hash);
      
        return redirect() -> route('pos_tax_sales') ->with('success' ,  __('main.created'));

    }

    public function return_sales(){

        $work = ExitWorkTax::with('branch:id,branch_name')
            ->where('pos' , '=' , 1) 
            ->where('net_money' , '<' , 0)
            ->get();
        $old = ExitOldTax::with('branch:id,branch_name')
            ->where('pos' , '=' , 1)
            ->where('net_money' , '<' , 0)
            ->get();
        
        if (!empty(Auth::user()->branch_id)) {
            $work = $work->where('branch_id', Auth::user()->branch_id);
            $old = $old->where('branch_id', Auth::user()->branch_id);
        } 

        foreach ($work as $w){
            $w -> type = 1 ;
            $client = Company::find($w -> client_id );
            $w -> vendor_name = $client ? $client -> name : '--';
            $billSales = ExitWorkTax::where('returned_bill_id' , '=' , $w -> id) -> get() -> first();
            $w -> salesNo = $billSales -> bill_number;
        }

        foreach ($old as $o){
            $o -> type = 0 ;
            $client = Company::find($o -> supplier_id );
            $o -> vendor_name = $client ? $client -> name : '--';
            $billSales = ExitOldTax::where('returned_bill_id' , '=' , $o -> id) -> get() -> first();
            $o -> salesNo = $billSales -> bill_number;
        }

        //$data = $work -> merge($old);
        $data = $work -> mergeRecursive($old);
 
        return view ('admin.postax.salesReturn' , compact('data'));
    }

    public function return_old($id){

        if (!empty(Auth::user()->branch_id)) {

            $bill = DB::table('exit_olds_tax')
                -> leftJoin('companies' , 'companies.id' , '=' , 'exit_olds_tax.supplier_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_olds_tax.branch_id')
                -> select('exit_olds_tax.*' , 'companies.name as vendor_name', 'branches.branch_name', 'companies.vat_no as vendor_vat_no')
                -> where('exit_olds_tax.id' , '=' , $id)
                -> where('exit_olds_tax.branch_id' ,Auth::user()->branch_id)
                -> first();

            if(!$bill) return ;

        }else{

            $bill = DB::table('exit_olds_tax')
                -> leftJoin('companies' , 'companies.id' , '=' , 'exit_olds_tax.supplier_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_olds_tax.branch_id')
                -> select('exit_olds_tax.*' , 'companies.name as vendor_name', 'branches.branch_name', 'companies.vat_no as vendor_vat_no')
                -> where('exit_olds_tax.id' , '=' , $id) 
                -> first();

        } 

        $details   =  DB::table('exit_old_tax_details')
            -> join('karats' , 'karats.id' , '=' , 'exit_old_tax_details.karat_id')
            -> select('exit_old_tax_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor as transform_factor')
            -> where('exit_old_tax_details.bill_id' , '=' , $id)
            -> get();
 
        return view ('admin.postax.oldReturn' , compact( 'bill' , 'details'));
    }

    public function return_old_post(Request $request){

        $bill = ExitOldTax::find($request -> bill_id);
        $data = ExitOldTaxDetails::where('bill_id' , $request -> bill_id) -> get();

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

        $id =  ExitOldTax::create([
            'uuid' => Str::uuid(),
            'branch_id' => $bill -> branch_id,
            'bill_number' => $bill_number,
            'bill_type' =>$bill -> bill_type,
            'date' => Carbon::now(),
            'supplier_id' => $bill -> supplier_id,
            'client_tax_number'=> $bill -> client_tax_number,
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
            ExitOldTaxDetails::create([
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

            $this -> syncQnt(0 , $detail -> karat_id,0, $id , $detail -> karat_id , 1,$bill -> branch_id);

            $detail -> returned = 1;
            $detail -> update();
        }

        $this -> syncVendorAccount($bill -> supplier_id , $net ,0 , -1 ,
            $id ,  'R'.$bill -> bill_number , 'Return Old Exit Tax Bill',$bill -> branch_id);

        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        if($auto_accounting == 1){
            $systemController = new SystemController();
            $systemController -> ReturnExitOldTaxAccounting($id);
        }

        return redirect() -> route('pos_tax_sales') ->with('success' ,  __('main.created'));

    }

    public function workReturnPreview($id){
        return $this -> workReturnPrint($id);
    }


    public function oldReturnPreview($id){

        return $this -> oldReturnPrint($id);
    }


    public function workReturnPrint($id){
   
        if (!empty(Auth::user()->branch_id)) {

            $bill = DB::table('exit_works_tax')
                -> join('companies' , 'companies.id' , '=' , 'exit_works_tax.client_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_works_tax.branch_id')
                -> Join('exit_works_tax as original' , 'exit_works_tax.id' , '=' , 'original.returned_bill_id')
                -> select('exit_works_tax.*' , 'companies.name as vendor_name', 'branches.branch_name', 'companies.vat_no as vendor_vat_no' , 'original.bill_number as ref_number')
                -> where('exit_works_tax.id' , '=' , $id)
                -> where('exit_works_tax.branch_id' ,Auth::user()->branch_id)
                -> first();

            if(!$bill)
                return ;
        } else{
            $bill = DB::table('exit_works_tax')
                -> join('companies' , 'companies.id' , '=' , 'exit_works_tax.client_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_works_tax.branch_id')
                -> Join('exit_works_tax as original' , 'exit_works_tax.id' , '=' , 'original.returned_bill_id')
                -> select('exit_works_tax.*' , 'companies.name as vendor_name', 'branches.branch_name' , 'companies.vat_no as vendor_vat_no' , 'original.bill_number as ref_number')
                -> where('exit_works_tax.id' , '=' , $id) 
                -> first();
        }

        $details   =  DB::table('exit_work_tax_details')
            -> join('items' , 'items.id' , '=' , 'exit_work_tax_details.item_id')
            -> join('karats' , 'karats.id' , '=' , 'exit_work_tax_details.karat_id')
            -> select('exit_work_tax_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor as transform_factor',
                'items.name_ar as item_ar' , 'items.name_en as item_en' , 'items.no_metal' , 'items.no_metal_type' , 'items.code as item_code')
            -> where('exit_work_tax_details.bill_id' , '=' , $id)
            -> get();

        $karats = Karat::all();
        $grouped_ar = $details   -> groupBy('karat_ar');
        $pos = \Illuminate\Support\Env::get('PROGRAMME_TYPE');
       // $amar = Tafqeet::inArabic($bill -> net_money,'sar');

        $amar ='';
        $payments = EnterMoney::where('based_on_bill_number' , '=' , $bill -> bill_number) -> get();
        $company = CompanyInfo::first() ;
        $bill_Return = ExitWorkTax::findOrFail($id);
        // return $payments ;
        if($pos == 1) {//A4
            return view('admin.postax.printSalesReturn' , compact('bill' ,'bill_Return', 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments' , 'company' ));
        } else { //A5
            return view('admin.Work.Exit.printA5' , compact('bill' ,'bill_Return', 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments', 'company' ));
        }
    }


    public function oldReturnPrint($id){ 
  
        if (!empty(Auth::user()->branch_id)) {
            $bill = DB::table('exit_olds_tax')
                -> join('companies' , 'companies.id' , '=' , 'exit_olds_tax.supplier_id')
                -> Join('exit_olds_tax as original' , 'exit_olds_tax.id' , '=' , 'original.returned_bill_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_olds_tax.branch_id')
                -> select('exit_olds_tax.*' , 'companies.name as vendor_name' , 'companies.vat_no as vendor_vat_no' , 'original.bill_number as ref_number')
                -> where('exit_olds_tax.id' , '=' , $id)
                -> where('exit_olds_tax.branch_id' , Auth::user()->branch_id)
                -> first();  
          
        } else{
            $bill = DB::table('exit_olds_tax')
                -> join('companies' , 'companies.id' , '=' , 'exit_olds_tax.supplier_id')
                -> Join('exit_olds_tax as original' , 'exit_olds_tax.id' , '=' , 'original.returned_bill_id')
                -> select('exit_olds_tax.*' , 'companies.name as vendor_name' , 'companies.vat_no as vendor_vat_no' , 'original.bill_number as ref_number')
                -> where('exit_olds_tax.id' , '=' , $id) 
                -> first();  
        }
        
        $details   =  DB::table('exit_old_tax_details')
            -> join('karats' , 'karats.id' , '=' , 'exit_old_tax_details.karat_id')
            -> select('exit_old_tax_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor')
            -> where('exit_old_tax_details.bill_id' , '=' , $id)
            -> get(); 

        $vendors = Company::where('group_id' , '=' , 4) -> get();
        $grouped_ar = $details   -> groupBy('karat_ar');
        $karats = Karat::all();
        $pos = \Illuminate\Support\Env::get('PROGRAMME_TYPE');
        $payments = EnterMoney::where('based_on_bill_number' , '=' , $bill -> bill_number) -> get();
        $company = CompanyInfo::first() ;
        $bill_Return = ExitOldTax::findOrFail($id);
        // $amar = Tafqeet::inArabic($bill -> net_money,'sar');
        $amar ='';

        if($pos == 0) {//A4 
            return view('admin.Old.Exit.print' , compact('bill' ,'bill_Return', 'details' , 'vendors' , 'karats' , 'grouped_ar' , 'payments' , 'amar', 'company'));
        } else { //A5
            return view('admin.postax.printSalesOldReturn' , compact('bill' ,'bill_Return', 'details' , 'vendors' , 'karats' , 'grouped_ar' , 'payments' , 'amar', 'company'));
        }
    }


    public function print($id){

        if (!empty(Auth::user()->branch_id)) {
            $bill = ExitWorkTax::with('cash:id,based_on_bill_number,amount','visa:id,based_on_bill_number,amount')
                -> join('companies' , 'companies.id' , '=' , 'exit_works_tax.client_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_works_tax.branch_id')
                -> select('exit_works_tax.*' , 'companies.name as vendor_name' , 'branches.branch_name','companies.phone as vendor_phone' , 'companies.vat_no as vendor_vat_no' )
                -> where('exit_works_tax.id' , '=' , $id)
                -> where('exit_works_tax.branch_id' ,Auth::user()->branch_id)
                -> first();

            if(!$bill)
                return ;
        }else{
            $bill = ExitWorkTax::with('cash:id,based_on_bill_number,amount','visa:id,based_on_bill_number,amount')
                -> join('companies' , 'companies.id' , '=' , 'exit_works_tax.client_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_works_tax.branch_id')
                -> select('exit_works_tax.*' , 'companies.name as vendor_name' , 'branches.branch_name','companies.phone as vendor_phone' , 'companies.vat_no as vendor_vat_no' )
                -> where('exit_works_tax.id' , '=' , $id) 
                -> first();
        }


        $details   =  DB::table('exit_work_tax_details')
            -> join('items' , 'items.id' , '=' , 'exit_work_tax_details.item_id')
            -> join('karats' , 'karats.id' , '=' , 'exit_work_tax_details.karat_id')
            -> select('exit_work_tax_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor as transform_factor',
                'items.name_ar as item_ar' , 'items.name_en as item_en' , 'items.no_metal' , 'items.no_metal_type' , 'items.code as item_code')
            -> where('exit_work_tax_details.bill_id' , '=' , $id)
            -> get();

        $karats = Karat::all();
        $grouped_ar = $details   -> groupBy('karat_ar'); 
        $pos = \Illuminate\Support\Env::get('PROGRAMME_TYPE'); 
        $amar = '';
        $payments = EnterMoney::where('based_on_bill_number' , '=' , $bill -> bill_number) -> get();
        $company = CompanyInfo::first() ; 

        if($pos == 0) {
            return view('admin.postax.print' , compact('bill' , 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments' , 'company' ));
        } else { 
            return view('admin.postax.printA5' , compact('bill' , 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments', 'company'));
        }

    }
	

}
