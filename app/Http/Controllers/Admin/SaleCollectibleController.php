<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyInfo;
use App\Models\EnterMoney;  
use App\Models\ExitMoney; 
use App\Models\SaleCollectible;
use App\Models\SaleCollectibleDetails;
use App\Models\PurchasesCollectible;
use App\Models\ItemsCollectible;
use App\Models\Karat; 
use App\Models\Pricing;
use App\Models\TaxSettings;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
 

class SaleCollectibleController extends WarehouseItemController
{
     //
     public function index(){ 
    
        $data = DB::table('sale_collectibles')
                    -> join('companies' , 'companies.id' , '=' , 'sale_collectibles.client_id')
                    -> join('branches' , 'branches.id' , '=' , 'sale_collectibles.branch_id')
                    -> select('sale_collectibles.*' , 'companies.name as vendor_name','branches.branch_name')
                    ->where('sale_collectibles.net_money' , '>=' , 0)
                    ->where('sale_collectibles.pos' , 1) 
                    -> orderBy('id', 'DESC')
                    -> get();  

        if (!empty(Auth::user()->branch_id)) {
            $data = $data->where('branch_id', Auth::user()->branch_id); 
        }  

        return view('admin.Collectibles.Exit.index' , compact('data'));
    }

    public function pos_create(){

        $customers =  Company::where('group_id' , '=' , 3) -> get();
        $suppliers =  Company::where('group_id' , '=' , 4) -> get();
        $karats = Karat::all();
        $setting = TaxSettings::all() -> first();
        $pricings = Pricing::all(); 
        $branches = Branch::where('status',1)->get();

        return view('admin.Collectibles.Exit.create' , compact( 'branches','suppliers' ,'customers' ,'karats' , 'setting' ));
    }

    public function store_pos(Request $request){ 

        $validated = $request->validate([
            'bill_date' => 'required',
            'bill_number' => 'required|unique:sale_collectibles',
            'customer_id' => 'required'
        ]);

        $items = array();
        if(count($request -> item_id )){
            //store header
            $total = 0 ;
            $total_weight = 0; 
            for($i = 0 ; $i < count($request -> item_id) ; $i++ ){
                $item =[
                    'bill_id' => 0,
                    'item_id' => $request -> item_id[$i],
                    'karat_id' => $request -> karat_id[$i],
                    'weight' => $request -> weight[$i],
                    'gram_price' => $request -> gram_price[$i], 
                    'gram_manufacture' => 0,
                    'gram_tax' => $request -> item_tax[$i],
                    'net_money'=> $request -> net_money[$i],
                ];
                $total += ($request -> net_money[$i] - $request -> item_tax[$i]);
                $total_weight += $request -> weight[$i];
                $items[] = $item ;
            }
            if($request -> customer_id == 39){
                $vat_no = 0;
                $customers_name = $request ->bill_client_name;
            }else{
                $customers =  Company::where('id' ,$request -> customer_id) -> first();
                $vat_no = $customers->vat_no ;
                $customers_name = $customers->name ;
            }

            $id =  SaleCollectible::create([
                'branch_id' => $request -> branch_id,
                'bill_number' => $request -> bill_number,
                'date' => $request -> bill_date,
                'client_id' => $request -> customer_id,
                'client_tax_number' => $vat_no,
                'total_money' => $total,
                'total21_gold' => $request -> total_weight21,
                'paid_money' => $request -> paid,
                'remain_money' => $request -> net_after_discount - $request -> paid,
                'paid_gold' => 0,
                'remain_gold' => 0,
                'discount' => $request -> discount,
                'tax' => $request ->tax ,
                'net_money' => $request -> net_after_discount,
                'bill_client_name' =>  $customers_name,
                'pos' => 1,
                'notes'=> $request -> notes ?? '',
                'user_id' => Auth::user() -> id
            ]) -> id;
 
            foreach ($items as $product){
                $product['bill_id'] = $id;
                SaleCollectibleDetails::create($product) ;
                $this -> syncQnt(1 , $product['item_id'], $id , $product['weight'] , -1 ,$request -> branch_id);
                $this -> makeItemsCollectibleUnAvailable($product['item_id'] );

            }
            $this -> syncVendorAccount($request -> customer_id , $request -> net_after_discount ,$total_weight, 1 ,
                $id , $request -> bill_number , 'Sale Collectible Bill',$request -> branch_id);

            if($request -> cash > 0){
                $this -> MakePayment($request , $request -> cash , 0 , $id ,1 , $request -> bill_number);
            }
            if($request -> visa > 0){
                $this -> MakePayment($request , $request -> visa , 1 , $id , 1 , $request -> bill_number);
            }

            $auto_accounting =  env("AUTO_ACCOUNTING", 1);
            if($auto_accounting == 1){
                $systemController = new SystemController();
                $systemController -> SaleCollectibleAccounting($id);
            } 

            return redirect()->route('Sale.Preview' , $id)->with('success' ,  __('main.created'));
        } else {
            return redirect()->route('pos.collectible.create')->with('error' ,  __('main.nodetails'));
        }
     
    }

    public function MakePayment($request , $money , $type , $based_on , $doc_type ,$based_on_num){

        $bill_number = $this -> getpaymentNo($request -> branch_id);

        $id =  EnterMoney::create([
            'branch_id' => $request -> branch_id,
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
                $bill = SaleCollectible::find($based_on);
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
        $bill_number = $this -> getpaymentOutNo($request -> branch_id) ;
        $id =  ExitMoney::create([
            'branch_id' => $request -> branch_id,
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
        ]) -> id;

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
                $bill = PurchasesCollectible::find($based_on);
            if($bill ){
                $bill -> remain_money -= $money ;
                $bill -> paid_money += $money ;
                $bill -> update();
            }
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
            $prefix = "MEC-".$branch_id."-";
            $no = $prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT) ;
        } while (ExitMoney::where("doc_number","=",$prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT))->exists());
     
        return $no ;
    }

    public function GetWorkReturnNo($branch_id){
        $bills = SaleCollectible::where('branch_id', $branch_id)  
            ->where('returned_bill_id','>',0)
            ->count(); 

        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        }
            
        $prefix = "RSWSIC-".$branch_id."-";
        $no = ($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
        return $no ;
    }
 
    public function pos_payment_show($money , $type){
        $html = view('admin.postax.payment' , compact('money' , 'type')) -> render();
        return $html ;
    }

    public function pos_payment_show2($money){
        $html = view('admin.postax.payment2' , compact('money')) -> render();
        return $html ;
    }

    public function sellNewGold($request){
     //
    }


    public function sellOldGold($request){
        //
    }

  
 
    public function test_print(){
        return view ('pos.print_sales');
    }

    public function return_pos($id){

        $bill = DB::table('sale_collectibles')
            -> leftJoin('companies' , 'companies.id' , '=' , 'sale_collectibles.client_id')
            -> join('branches' , 'branches.id' , '=' , 'sale_collectibles.branch_id')
            -> select('sale_collectibles.*' , 'companies.name as vendor_name' , 'companies.vat_no as vendor_vat_no')
            -> where('sale_collectibles.id' , '=' , $id)
            -> where('sale_collectibles.branch_id' ,Auth::user()->branch_id)
            -> first();

        $details   =  DB::table('sale_collectibles_details')
            -> join('items_collectibles' , 'items_collectibles.id' , '=' , 'sale_collectibles_details.item_id') 
            -> select('sale_collectibles_details.*' , 'items_collectibles.name_ar as item_ar' , 'items_collectibles.name_en as item_en')
            -> where('sale_collectibles_details.bill_id' , '=' , $id)
            -> get(); 

        return view ('admin.Collectibles.Exit.invoiceReturn' , compact('bill' , 'details'));
    }

    public function return_sale_post(Request $request){
        $bill = SaleCollectible::find($request -> bill_id);
        $data = SaleCollectibleDetails::where('bill_id' , '=' , $request -> bill_id) -> get();
        $details = [] ;
        $total = 0 ;
        $money = 0 ;
        $tax = 0 ;
        $total_weight = 0 ;
        foreach ($data as $detail){
            if(in_array($detail -> id , $request -> checkDetail)){
                array_push($details , $detail); 
                $total += $detail -> net_money - $detail ->gram_tax;
                $karat = Karat::find($detail -> karat_id);
                $Item = ItemsCollectible::find($detail -> item_id);
                $total_weight +=  $detail -> weight;
                $tax += $detail->gram_tax; 
            }
        }

        $discountOld = $bill -> discount ;
        $discountPer = 1 - ($bill ->total_money - $discountOld) /($bill ->total_money) ;
        $discount = $discountPer * $total ; 
        $net = $total + $tax - $discount ;
        $bill_number = $this -> GetWorkReturnNo($bill -> branch_id);
 
        $id =  SaleCollectible::create([
            'branch_id' => $bill -> branch_id,
            'bill_number' => $bill_number,
            'date' => Carbon::now(),
            'client_id' => $bill -> client_id,
            'client_tax_number'=> $bill -> client_tax_number,
            'total_money' => $total * -1, 
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
            $item = ItemsCollectible::find($detail -> item_id) ;
            if($item){
                $item -> state = 1 ;
                $item -> update(); 
                $this -> syncQnt(1 , $detail -> item_id, $id , $item -> weight , 1,$bill -> branch_id );
            }

            SaleCollectibleDetails::create([
                'bill_id' => $id,
                'karat_id' => $detail -> karat_id,
                'item_id' => $detail -> item_id, 
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
            $id ,  $bill_number , 'Return Sale Collectible Bill',$bill -> branch_id);
      
        //update 15-10-2023
        $request['bill_date2'] =  Carbon::now();
        $request['customer_id2'] =  $bill -> client_id ;
        $request['bill_number2'] = $request -> bill_number; 
        $request['branch_id'] = $bill -> branch_id; 
        
        $this -> MakePaymentOut($request , $net , 0 , $id );    
  
        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        if($auto_accounting == 1){
            $systemController = new SystemController();
            $systemController -> ReturnSaleCollectibleAccounting($id);
        }

        return redirect() -> route('pos.collectible') ->with('success' ,  __('main.created'));

    }

    public function return_sales(){ 
       
        if (!empty(Auth::user()->branch_id)) { 
            $data = SaleCollectible::with('branch:id,branch_name')
            ->where('pos' , '=' , 1) 
            -> where('net_money' , '<' , 0)
            ->where('branch_id', Auth::user()->branch_id)
            -> get(); 
        }else{
            $data = SaleCollectible::with('branch:id,branch_name')
            ->where('pos' , '=' , 1) 
            -> where('net_money' , '<' , 0) 
            -> get(); 
        }

        foreach ($data as $w){
            $w -> type = 1 ;
            $client = Company::find($w -> client_id );
            $w -> vendor_name = $client ? $client -> name : '--';
            $billSales = SaleCollectible::where('returned_bill_id' , $w -> id)-> first();
            if($billSales){
                $w -> salesNo = $billSales -> bill_number;
            }
            
        } 
        return view ('admin.Collectibles.Exit.salesReturn' , compact('data' ));
    }
  
  

    public function sale_return_print($id){
        if (!empty(Auth::user()->branch_id)) {
            $bill = DB::table('sale_collectibles')
                -> join('companies' , 'companies.id' , '=' , 'sale_collectibles.client_id')
                -> join('branches' , 'branches.id' , '=' , 'sale_collectibles.branch_id')
                -> Join('sale_collectibles as original' , 'sale_collectibles.id' , '=' , 'original.returned_bill_id')
                -> select('sale_collectibles.*' , 'companies.name as vendor_name', 'branches.branch_name' , 'companies.vat_no as vendor_vat_no' , 'original.bill_number as ref_number')
                -> where('sale_collectibles.id' , '=' , $id)
                -> where('sale_collectibles.branch_id' ,Auth::user()->branch_id)
                -> first();

            if(!$bill)
                return ;
        }else{
            $bill = DB::table('sale_collectibles')
                -> join('companies' , 'companies.id' , '=' , 'sale_collectibles.client_id')
                -> join('branches' , 'branches.id' , '=' , 'sale_collectibles.branch_id')
                -> Join('sale_collectibles as original' , 'sale_collectibles.id' , '=' , 'original.returned_bill_id')
                -> select('sale_collectibles.*' , 'companies.name as vendor_name'  , 'branches.branch_name', 'companies.vat_no as vendor_vat_no' , 'original.bill_number as ref_number')
                -> where('sale_collectibles.id' , '=' , $id) 
                -> first();
        }

 

        $details   =  DB::table('sale_collectibles_details')
            -> join('items_collectibles' , 'items_collectibles.id' , '=' , 'sale_collectibles_details.item_id') 
            -> select('sale_collectibles_details.*' ,'items_collectibles.name_ar as item_ar' , 'items_collectibles.name_en as item_en' 
                    , 'items_collectibles.no_metal' , 'items_collectibles.no_metal_type' , 'items_collectibles.code as item_code')
            -> where('sale_collectibles_details.bill_id' , '=' , $id)
            -> get();

        $karats = Karat::all();
        $grouped_ar = $details   -> groupBy('item_ar');
        $pos = \Illuminate\Support\Env::get('PROGRAMME_TYPE');
       // $amar = Tafqeet::inArabic($bill -> net_money,'sar');

        $amar ='';
        $payments = EnterMoney::where('based_on_bill_number' , '=' , $bill -> bill_number) -> get();
        $company = CompanyInfo::first() ;
        $bill_Return = SaleCollectible::findOrFail($id);
        // return $payments ;
        if($pos == 1) {//A4
             return view('admin.Collectibles.Exit.printSalesReturn' , compact('bill' ,'bill_Return', 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments' , 'company' ));
        } else { //A5
            return view('admin.Collectibles.Exit.printA5' , compact('bill' ,'bill_Return', 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments', 'company' ));
        }
    }


    public function oldReturnPrint($id){ 
        $bill = DB::table('exit_olds')
            -> join('companies' , 'companies.id' , '=' , 'exit_olds.supplier_id')
            -> Join('exit_olds as original' , 'exit_olds.id' , '=' , 'original.returned_bill_id')
            -> select('exit_olds.*' , 'companies.name as vendor_name' , 'companies.vat_no as vendor_vat_no' , 'original.bill_number as ref_number')
            -> where('exit_olds.id' , '=' , $id)
            -> first();    

        if (!empty(Auth::user()->branch_id)) {
            $bill = $bill->where('branch_id', Auth::user()->branch_id); 
            $id = $bill->id;
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
            $bill = DB::table('sale_collectibles')
                -> join('companies' , 'companies.id' , '=' , 'sale_collectibles.client_id')
                -> join('branches' , 'branches.id' , '=' , 'sale_collectibles.branch_id')
                -> select('sale_collectibles.*' , 'companies.name as vendor_name', 'branches.branch_name', 'companies.phone as vendor_phone' , 'companies.vat_no as vendor_vat_no' )
                -> where('sale_collectibles.id' , '=' , $id)
                -> where('sale_collectibles.branch_id' ,Auth::user()->branch_id)
                -> first();
        } else{
            $bill = DB::table('sale_collectibles')
                -> join('companies' , 'companies.id' , '=' , 'sale_collectibles.client_id')
                -> join('branches' , 'branches.id' , '=' , 'sale_collectibles.branch_id')
                -> select('sale_collectibles.*' , 'companies.name as vendor_name', 'branches.branch_name', 'companies.phone as vendor_phone' , 'companies.vat_no as vendor_vat_no' )
                -> where('sale_collectibles.id' , '=' , $id) 
                -> first();
        }

        $details   =  DB::table('sale_collectibles_details')
            -> join('items_collectibles' , 'items_collectibles.id' , '=' , 'sale_collectibles_details.item_id')
            -> join('karats' , 'karats.id' , '=' , 'sale_collectibles_details.karat_id')
            -> select('sale_collectibles_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor as transform_factor',
                'items_collectibles.name_ar as item_ar' , 'items_collectibles.name_en as item_en' , 'items_collectibles.no_metal' , 'items_collectibles.no_metal_type' , 'items_collectibles.code as item_code')
            -> where('sale_collectibles_details.bill_id' , '=' , $id)
            -> get();

        $karats = Karat::all();
        $grouped_ar = $details   -> groupBy('karat_ar'); 
        $pos = \Illuminate\Support\Env::get('PROGRAMME_TYPE'); 
        $amar = '';
        $payments = EnterMoney::where('based_on_bill_number' , '=' , $bill -> bill_number) -> get();
        $company = CompanyInfo::first() ; 

        if($pos == 0) {
            return view('admin.Collectibles.Exit.print' , compact('bill' , 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments' , 'company' ));
        } else { 
            return view('admin.Collectibles.Exit.printA5' , compact('bill' , 'details' , 'karats' , 'grouped_ar' , 'amar' , 'payments', 'company'));
        }

    }

    
    public function get_sale_collectible_no($type,$branch_id){
        $bills = SaleCollectible::where('branch_id', $branch_id)
            -> where('returned_bill_id' , 0)
            ->count(); 
    
        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        }

        $prefix = "SWSIC-".$branch_id."-";
        $no = json_encode($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
        echo $no ;
        exit;
    }

}
