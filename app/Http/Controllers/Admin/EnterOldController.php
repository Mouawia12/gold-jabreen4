<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyMovement;
use App\Models\Category;
use App\Models\Item;
use App\Models\CompanyInfo;
use App\Models\EnterOld; 
use App\Models\EnterOldDetails;
use App\Models\Journal;
use App\Models\JournalDetails;
use App\Models\Karat;
use App\Models\Pricing;
use App\Models\ExitMoney;
use App\Models\TaxSettings;
use App\Models\AccountMovement;
use App\Models\Warehouse;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

class EnterOldController extends WarehouseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){   

        $data = DB::table('enter_olds')
            -> join('companies' , 'companies.id' , '=' , 'enter_olds.supplier_id')
            -> join('branches' , 'branches.id' , '=' , 'enter_olds.branch_id')
            -> select('enter_olds.*' , 'companies.name as vendor_name','branches.branch_name')
            ->whereNull('returned_bill_id')
            -> orderBy('id', 'DESC')
            -> get(); 

        if (!empty(Auth::user()->branch_id)) {
            $data = $data->where('branch_id', Auth::user()->branch_id); 
        }  
        
        if ($request->ajax()) {  
            return Datatables::of($data)->addIndexColumn() 
                ->addColumn('bill_type', function($row){
                    if($row->bill_type == 0){
                        $span = 'ذهب كسر';  
                    }else{
                        $span = 'ذهب صافي';  
                    }

                    return $span; 
                })  
                ->addColumn('action', function($row){
                    if(auth()->user()->can('عرض فاتورة مشتريات')){    
                        $btn = '<a href='.route('oldEnterPrint',$row->id).' class="btn btn-info editBtn" role="button" target="_blank">
                                    <i class="fa fa-print"></i>
                                </a>'; 
                    }
                    
                    if(auth()->user()->can('اضافة مردود مشتريات')){    
                        $btn =  $btn.'<a href='.route('create.return.purchase.old',$row->id).' class="btn btn-warning" role="button" target="_blank">
                                    <i class="fa fa-retweet"></i> عمل مردود مشتريات
                                </a>'; 
                    } 

                    return $btn; 
                }) 
                ->rawColumns(['bill_type','action']) 
                ->make(true);
        } 

        return view('admin.Old.Enter.index');
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

        return view('admin.Old.Enter.Create' , compact('vendors' , 'karats' , 'setting','branches' ));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['bill_number'] = $this->get_old_entry_no(1,$request -> branch_id); 

        $validated = $request->validate([
            'date' => 'required',
            'bill_number' => 'required|unique:enter_olds',
            'supplier_id' => 'required', 
            'branch_id' => 'required', 
        ]);

        $items = array();
        if(count($request -> karat_id)){
            //store header
            $total_money = 0 ;
            $total21_gold = 0 ;
            $made_total = 0;
            $tax_total = 0;
            for($i = 0 ; $i < count($request -> karat_id) ; $i++ ){
                     
                    if( $request -> supplier_id == 1){
                        $tax_item = 0;
                    }else{
                        $tax_item = $request -> made_money[$i] * $request -> stamp[$i] / 100;
                    } 

                    $item =[
                        'bill_id' => 0,
                        'karat_id' => $request -> karat_id[$i],
                        'category_id' => $request -> category_id[$i] ?? 0, 
                        'weight' => $request -> weight[$i],
                        'weight21'=> $request -> weight21[$i],
                        'made_money'=> $request -> made_money[$i] ?? 0,
                        'gram_price'=> $request -> made_money[$i] / $request -> weight[$i],
                        'net_weight' => $request -> weight [$i],
                        'tax' => $tax_item,
                        'net_money' => $request -> made_money[$i],
                    ];
                    $total_money += $request -> made_money[$i];
                    $total21_gold += $request -> weight21[$i]; 
                    $tax_total += $tax_item;
                    $items[] = $item ;
            }

           $id =  EnterOld::create([
                'branch_id' => $request -> branch_id,
                'bill_number' => $request -> bill_number,
                'bill_type' => $request -> bill_type,
                'date' => $request -> date,
                'supplier_id' => $request -> supplier_id,
                'total_money' => $total_money,
                'total21_gold' => $total21_gold,
                'paid_money' => 0,
                'remain_money' => $request -> net_after_discount,
                'paid_gold' => 0,
                'remain_gold' => $total21_gold, 
                'discount' => $request -> discount,
                'tax' => $tax_total,
                'net_money' => $request -> net_after_discount,
                'supplier_bill_number' => $request -> supplier_bill_number ?? 0,
                'bill_client_phone' => $request -> bill_client_phone ?? null,
                'bill_client_name' => $request -> bill_client_name ?? null, 
                'pos' => 0,
                'notes'=> $request -> notes ?? '',
                'user_id' => Auth::user() -> id

            ]) -> id;

            if($request -> bill_type == 0){
                $is_type = 'Old Entry Bill';
            }else{
                $is_type = 'Pure Entry Bill';
            }

            foreach ($items as $product){
                $product['bill_id'] = $id;
                EnterOldDetails::create($product) ; 
                $this -> syncQnt($request -> bill_type , $product['karat_id'],0, $id , $product['weight'] , 1 ,$request -> branch_id);
            }

            $this -> syncVendorAccount($request -> supplier_id , $request -> net_after_discount ,$total21_gold , -1 ,
                $id , $request -> bill_number , $is_type, $request -> branch_id); 
            
            $request['bill_date2'] = Carbon::now();
            $request['customer_id2'] = $request -> supplier_id;
            $request['bill_number2'] = $request -> bill_number;   
            $request['bill_type2'] = $request -> bill_type;   

            if(Company::find($request -> supplier_id)->vat_no == 0){
                $this -> MakePaymentOut($request , $request -> net_after_discount, 0, $id);
            } 
            
           $auto_accounting = env("AUTO_ACCOUNTING", 1);
           if($auto_accounting == 1){
               $systemController = new SystemController(); 
               $systemController -> EnterOldAccounting($id);
           }
           return redirect()->route('oldEntryAll')->with('success' ,  __('main.created'));
        } else {
           return redirect()->route('oldEntryAll')->with('error' ,  __('main.nodetails'));
        }

    }


    public function edit($id)
    {
        $purchase = EnterOld::find($id);

        if($purchase->net_money < 0){
            return redirect()->back();
        } 

        $purchaseItems = EnterOldDetails::join('karats','karats.id','=','enter_old_details.karat_id')
            ->select('enter_old_details.*','karats.name_ar as karat_name')
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

        return view('admin.Old.Return.create',compact('purchaseItems','id','purchase'));

    }


    public function purchase_return(){

        $data = EnterOld::where('returned_bill_id' , '>' , 0 ) ->get();
        
        if(!empty(Auth::user()->branch_id)) {
            $data = $data->where('branch_id', Auth::user()->branch_id); 
        }  

        return view('admin.Old.Return.index',compact('data'));
    }

    private function getAllProductReturnForSameInvoice($invoiceId,$karatId){

        $totalQnt = 0; 
        $allOtherPurchaseItems = EnterOldDetails::join('enter_olds','enter_olds.id','=','enter_old_details.bill_id')
            ->select('enter_old_details.*')
            ->where('enter_olds.returned_bill_id',$invoiceId)
            ->where('enter_old_details.karat_id',$karatId)
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
            'bill_number' => 'required|unique:enter_olds', 
            'supplier_id' => 'required', 
        ]);
        
        $siteController = new SystemController();

        $total = 0;
        $total21_gold = 0; 
        $tax = 0;
        $discount = 0;
        $net = 0; 

        $items = array(); 

        for($i = 0 ; $i < count($request -> karat_id) ; $i++ ){
            $item = [
                'bill_id' => 0,
                'karat_id' => $request->karat_id[$i], 
                'weight' => $request->weight[$i]* -1,
                'weight21' => $request->weight21[$i]* -1,
                'made_money' => $request->total[$i]* -1, 
                'net_weight' => $request->weight[$i]* -1,
                'tax' => $request->tax[$i]* -1,
                'net_money' => $request->total[$i]* -1 , 
            ];
           
            $total += $request->total[$i];
            $total21_gold += $request->weight21[$i];
            $tax += $request->tax[$i];  
            $net += ($request->net[$i]); 

            $items[] = $item ;
        } 

        $invoice = EnterOld::find($billid);

        $return = EnterOld::create([
            'returned_bill_id' => $invoice->id,
            'branch_id' => $request->branch_id,
            'date' => $request->bill_date,
            'bill_number' => $request-> bill_number,
            'bill_type' => $invoice->bill_type,
            'bill_client_name' => $invoice->bill_client_name,
            'supplier_id' => $request->supplier_id, 
            'total_money' => $total * -1,
            'total21_gold'=> $total21_gold * -1,
            'paid_money'=> 0,
            'remain_money' => 0,
            'paid_gold' => 0,
            'remain_gold' => 0, 
            'discount' => 0,
            'tax' => $tax * -1,
            'net_money' => $net * -1,
            'notes' => $request->notes ?? '',
            'user_id'=> Auth::user()->id
        ]);

        foreach ($items as $product){
            $product['bill_id'] = $return->id;
            EnterOldDetails::create($product);
            $this -> syncQnt( $return->bill_type , $product['karat_id'], 0, $return->id, $product['weight'] * -1 , -1, $request -> branch_id);
        }

        $this -> syncVendorAccount($request -> supplier_id, $net, $total21_gold, 1,
            $return->id, $request -> bill_number, 'Return Old Enter Bill', $request -> branch_id);

        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        if($auto_accounting == 1){
            $systemController = new SystemController();
            $systemController -> ReturnEnterOldAccounting($return->id);
        }

        return redirect()->route('purchase.old.return');
    }

    public function show($id)
    {
        $bill = DB::table('enter_olds')
            -> join('companies' , 'companies.id' , '=' , 'enter_olds.supplier_id')
            -> select('enter_olds.*' , 'companies.name as vendor_name')
            -> where('enter_olds.id' , '=' , $id)
            -> get() -> first();

        $vendors = Company::where('group_id' , '=' , 4) -> get();

        $details   =  DB::table('enter_old_details')
            -> join('karats' , 'karats.id' , '=' , 'enter_old_details.karat_id')
            -> select('enter_old_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor')
            -> where('enter_old_details.bill_id' , '=' , $id)
            -> get();

    
        return view('admin.Old.Enter.Preview' , compact('bill' , 'details' , 'vendors' ));
    }

    public function print($id){

        $bill = DB::table('enter_olds')
            -> join('companies' , 'companies.id' , '=' , 'enter_olds.supplier_id')
            -> join('branches' , 'branches.id' , '=' , 'enter_olds.branch_id')
            -> select('enter_olds.*' , 'companies.name as vendor_name' , 'branches.branch_name','companies.vat_no as vendor_vat_no')
            -> where('enter_olds.id' , '=' , $id)
            -> first();

        $karats = Karat::all();
        $details   =  DB::table('enter_old_details')
            -> join('karats' , 'karats.id' , '=' , 'enter_old_details.karat_id')
            -> select('enter_old_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor')
            -> where('enter_old_details.bill_id' , '=' , $id)
            -> get();

        $grouped_ar = $details -> groupBy('karat_ar');
        $suppliers =  Company::where('group_id' , '=' , 4) -> get(); 
        $company = CompanyInfo::first() ;
        $pos = \Illuminate\Support\Env::get('PROGRAMME_TYPE');
        
        if($pos == 0) {//A4
            return view('admin.Old.Enter.print' , compact('bill' , 'details' , 'karats' , 'grouped_ar','company'));
        } else { //A5
            return view('admin.Old.Enter.printA5 ' , compact('bill' , 'details' , 'karats' , 'grouped_ar','company'));
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
 
 

    public function get_return_purchases_no($type,$branch_id){ 

        $bills = EnterOld::where('branch_id',$branch_id)
            ->where('returned_bill_id','>',0)
            ->count(); 
       
        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        } 

        $prefix = "RWEO".'-'.$branch_id.'-';
 
        if($type == 1){
            $no = $prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT);
            return $no ; 
        }else{
            $no = json_encode($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
            echo $no ;
            exit;
        }

    }

    public function get_old_entry_no($type,$branch_id){ 

        $bills = EnterOld::where('branch_id',$branch_id)
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
            $prefix = "WEO-".$branch_id."-";
            $no = json_encode($prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT)) ;
            $no2 = $prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT);
        } while (EnterOld::where("bill_number","=",$prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT))->exists());
     
        if($type > 0){
            return $no2;
        }else{
            echo $no ;
            exit;
        }
    }

    public function get_purchase_pos_no(){

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

    
    public function MakePaymentOut($request , $money , $type , $based_on ){

        $bill_number = $this -> getpaymentOutNo($request -> branch_id);

        if($request -> bill_type2 == 0){
            $is_type = 1;
        }else{
            $is_type = 3;
        }
        $id =  ExitMoney::create([
            'branch_id' => $request -> branch_id,
            'doc_number' => $bill_number ,
            'date' => $request -> bill_date2,
            'supplier_id' => $request -> customer_id2,
            'type' => $is_type ,
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


    public function destroy($id)
    {
        if (EnterOld::where('id', $id)->exists()) { 

            $bills = EnterOld::where('id', $id)->first();
            $journal_id = Journal::where('basedon_no', $bills->bill_number)->first()->id; 
            EnterOldDetails::where('bill_id', $bills->id)->delete();
            JournalDetails::where('journal_id', $journal_id)->delete();
            Journal::where('basedon_no', $bills->bill_number)->delete();
            AccountMovement::where('journal_id', $journal_id)->delete();
            Warehouse::where('bill_id', $bills->id)->where('type',$bills->bill_type)->delete(); 
            CompanyMovement::where('bill_number', $bills->bill_number)->delete();
            $company = Company::where('id', $bills->supplier_id)->first();
            
              
            $company->update([
                'deposit_amount' => $company->deposit_amount - $bills->net_money, 
                'deposit_gold' => $company->deposit_gold - $bills->total21_gold,
            ]);

            if (ExitMoney::where('based_on_bill_number', $bills->bill_number)->exists()) {
                
                if($company->credit_amount > 0){
                    $company->update([ 
                        'credit_amount' => $company->credit_amount - $bills->net_money , 
                    ]); 
                }
    
                if($company->credit_gold > 0){
                    $company->update([ 
                        'credit_gold' =>  $company->credit_gold - $bills->total21_gold ,
                    ]); 
                }

                $mony = ExitMoney::where('based_on_bill_number', $bills->bill_number)->first();
                $journal_id2 = Journal::where('basedon_no', $mony->doc_number)->first()->id;
                JournalDetails::where('journal_id', $journal_id2)->delete();
                Journal::where('basedon_no', $mony->doc_number)->delete();
                AccountMovement::where('journal_id', $journal_id2)->delete();
                CompanyMovement::where('bill_number', $mony->doc_number)->delete();
                $mony->delete();
            }

            $bills -> delete();
            return redirect()->route('oldEntryAll')->with('success' ,  __('main.deleted')); 
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
