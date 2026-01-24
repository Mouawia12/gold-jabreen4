<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountsTree;
use App\Models\Category;
use App\Models\Company;
use App\Models\CompanyMovement;
use App\Models\EnterMoney;
use App\Models\EnterOld;
use App\Models\EnterWork;
use App\Models\ExitMoney;
use App\Models\ExitOld;
use App\Models\ExitWork;
use App\Models\Holder;
use App\Models\Item;
use App\Models\Karat;
use App\Models\Pricing;
use App\Models\Warehouse;
use App\Models\CompanyInfo;
use App\Models\ExitWorkDetails ;
use App\Models\ExitOldDetails ;
use App\Models\EnterWorkDetails;
use App\Models\ExitWorkTax;
use App\Models\ExitWorkTaxDetails;
use App\Models\ExitOldTax;
use App\Models\ExitOldTaxDetails;
use App\Models\EnterOldDetails;
use App\Models\Inventory; 
use App\Models\InventoryDetails; 
use App\Models\SaleCollectible;
use App\Models\SaleCollectibleDetails;
use App\Models\PurchaseCollectibleDetails;
use App\Models\PurchasesCollectible;
use App\Models\Branch;
use App\Models\User;
use App\Models\CatchGoldRecipts;
use App\Models\CatchGoldReciptsDetails;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:التقارير المحاسبية');
        $this->middleware('permission:التقارير المخزون'); 
    }

    public function item_list_report(){
        $karats = Karat::all();
        $categories = Category::all();
        $pricings = Pricing::all();
        $branches = Branch::where('status',1)->get();

        return view('admin.Report.item_list_report' , compact('karats' , 'categories','branches' ));
    }

    public function item_list_report_search(Request $request){
        $items = Item::with('karat' , 'category') -> where('item_type' , '<>' , 2);

        if($request -> branch_id > 0) $items = $items -> where('branch_id' ,$request -> branch_id );
        if($request -> category > 0) $items = $items -> where('category_id' , '=' ,$request -> category );

        if($request -> karat > 0) $items = $items -> where('karat_id' , '=' ,$request -> karat ) -> get();
        if($request -> code != null ) $items = $items -> where('code' , '=' , $request ->code ) -> get();
        if($request -> name != null) $items = $items->where('name_ar' , 'like' , '%'.$request -> name .'%') -> get();
        if($request -> weight > 0) $items = $items -> where('weight' , '=' ,$request -> weight ) -> get();


        if($request -> karat == 0  && $request -> category == 0 &&
            $request -> code == null && $request -> name == null && $request -> weight == 0){
            $data = $items -> get();

        } else {
            $data = $items ;
        }

        $fcode = $request -> fcode ?? '000001';
        $tcode = $request -> tcode ?? '999999';
        $items2 = [] ;

        foreach ($data as $item){
            if((int)$item -> code  >= (int) $fcode && (int)$item -> code  <= (int) $tcode){
                array_push($items2 , $item);
            }
        }

        if(!$request -> fcode && ! $request -> tcode ){
            $items2 = $data ;
        }
 
        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        return view('admin.Report.item_list_report_result' , ['data' => $items2 ,'branch'=>$branch, 'company' => $company])  ;
    }


    public function sold_items_report(){
        $karats = Karat::all();
        $categories = Category::all(); 
        $branches = Branch::where('status',1)->get();

        return view('admin.Report.sold_item_list_report' , compact('karats' , 'categories','branches'));
    }

    public function sold_items_report_search(Request $request){ 

        $items = DB::table('exit_work_details')
            -> join('exit_works' , 'exit_work_details.bill_id' , '=' , 'exit_works.id')
            -> join('karats' , 'exit_work_details.karat_id' , '=' , 'karats.id')
            ->join('items' , 'exit_work_details.item_id' , '=' , 'items.id')
            -> select('items.*' , 'karats.name_ar as karat_name_ar' , 'karats.name_en as karat_name_en' ,
                'exit_work_details.bill_id as bill_id' , 'exit_works.date as bill_date' ,
                'exit_works.bill_number as bill_no'
                )
            -> where('exit_works.total_money' , '>' , 0) ; 

        $items_t = DB::table('exit_work_tax_details')
            -> join('exit_works_tax' , 'exit_work_tax_details.bill_id' , '=' , 'exit_works_tax.id')
            -> join('karats' , 'exit_work_tax_details.karat_id' , '=' , 'karats.id')
            ->join('items' , 'exit_work_tax_details.item_id' , '=' , 'items.id')
            -> select('items.*' , 'karats.name_ar as karat_name_ar' , 'karats.name_en as karat_name_en' ,
                'exit_work_tax_details.bill_id as bill_id' , 'exit_works_tax.date as bill_date' ,'exit_works_tax.bill_number as bill_no')
            -> where('exit_works_tax.total_money' , '>' , 0) ;  

        if($request -> branch_id > 0) $items = $items -> where('items.branch_id' ,$request -> branch_id );
        if($request -> karat > 0) $items = $items -> where('items.karat_id' , '=' ,$request -> karat ) -> get();
        if($request -> code != null ) $items = $items -> where('items.code' , '=' , $request ->code ) -> get();
        if($request -> name != null) $items = $items->where('items.name_ar' , 'like' , '%'.$request -> name .'%') -> get();
        if($request -> weight > 0) $items = $items -> where('items.weight' , '=' ,$request -> weight ) -> get();

        //if($request -> branch_id > 0) $items_t = $items_t -> where('items.branch_id' ,$request -> branch_id );
        if($request -> karat > 0) $items_t = $items_t -> where('items.karat_id' , '=' ,$request -> karat ) -> get();
        if($request -> code != null ) $items_t = $items_t -> where('items.code' , '=' , $request ->code ) -> get();
        if($request -> name != null) $items_t = $items_t->where('items.name_ar' , 'like' , '%'.$request -> name .'%') -> get();
        if($request -> weight > 0) $items_t = $items_t -> where('items.weight' , '=' ,$request -> weight ) -> get();
                
        
        if($request -> karat == 0  &&
            $request -> code == null && $request -> name == null && $request -> weight == 0){
            $data1 = $items -> get();
            $data2 = $items_t -> get();

        } else {
            $data1 = $items ;
            $data2 = $items_t ;
        }
  
        //$all = $data1  -> merge($data2);
        $all = $data1 -> mergeRecursive($data2);

        if($request -> has('isStartDate')) $all = $all -> where('bill_date' , '>=' , Carbon::parse($request -> StartDate) -> startOfDay());
        if($request -> has('isEndDate'))   $all = $all -> where('bill_date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
 
        $startDate = Carbon::now()->addYears(-5);
        $endDate = Carbon::now() -> addDays(1);

        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate; 
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;

        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ; 
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        return view('admin.Report.sold_item_list_report_result' , compact('all', 'branch', 'period', 'period_ar' , 'company'))  ;
    }

    public function sales_report(){ 
        $branches = Branch::where('status',1)->get(); 
        $users = User::with('branch')->where('status',1)->get(); 
        return view('admin.Report.sales_report', compact('branches','users'));
    }

    public function sales_report_search(Request $request){

        $data = DB::table('exit_work_details')
            -> join('exit_works' , 'exit_work_details.bill_id' , '=' , 'exit_works.id')
            ->join('items' , 'exit_work_details.item_id' , '=' , 'items.id')
            ->join('karats' , 'exit_work_details.karat_id' , '=' , 'karats.id')
            ->select('exit_works.branch_id','exit_works.bill_number' , 'exit_works.date' 
                , 'exit_works.id' ,  'exit_works.client_id as client_id'
                ,'exit_works.discount', 'items.name_ar as item_name_ar', 'items.code'
                ,'karats.name_ar as karat_name_ar' , 'exit_work_details.weight' 
                , 'exit_work_details.gram_price' ,'exit_work_details.gram_manufacture' 
                , 'exit_work_details.gram_tax','exit_work_details.net_money' 
                , 'exit_work_details.karat_id'
                ,'exit_works.user_id')
            -> where('exit_works.net_money' ,'>' , 0)
            -> orderBy('exit_works.id'); 
 

        $data2 = DB::table('exit_old_details')
            -> join('exit_olds' , 'exit_old_details.bill_id' , '=' , 'exit_olds.id')
            ->join('karats' , 'exit_old_details.karat_id' , '=' , 'karats.id')
            ->select('exit_olds.branch_id','exit_olds.bill_number' , 'exit_olds.date' 
                , 'exit_olds.discount' ,'exit_olds.id' , 'exit_olds.supplier_id as client_id'
                ,'karats.name_ar as karat_name_ar' , 'exit_old_details.weight' 
                , 'exit_old_details.gram_price' ,'exit_old_details.gram_manufacture' 
                , 'exit_old_details.gram_tax','exit_old_details.net_money' 
                , 'exit_old_details.karat_id'
                ,'exit_olds.user_id')
            -> where('exit_olds.net_money' ,'>' , 0)
            -> orderBy('exit_olds.id');
        
        $data3 = DB::table('exit_work_tax_details')
            -> join('exit_works_tax' , 'exit_work_tax_details.bill_id' , '=' , 'exit_works_tax.id')
            ->join('items' , 'exit_work_tax_details.item_id' , '=' , 'items.id')
            ->join('karats' , 'exit_work_tax_details.karat_id' , '=' , 'karats.id')
            ->select('exit_works_tax.branch_id','exit_works_tax.bill_number' , 'exit_works_tax.date' 
                , 'exit_works_tax.id' ,  'exit_works_tax.client_id as client_id'
                ,'exit_works_tax.discount', 'items.name_ar as item_name_ar' ,'items.code' 
                ,'karats.name_ar as karat_name_ar', 'exit_work_tax_details.weight' 
                , 'exit_work_tax_details.gram_price' ,'exit_work_tax_details.gram_manufacture'
                , 'exit_work_tax_details.gram_tax','exit_work_tax_details.net_money' 
                , 'exit_work_tax_details.karat_id'
                ,'exit_works_tax.user_id')
            -> where('exit_works_tax.net_money' ,'>' , 0)
            -> orderBy('exit_works_tax.id');            

        $data4 = DB::table('exit_old_tax_details')
            -> join('exit_olds_tax' , 'exit_old_tax_details.bill_id' , '=' , 'exit_olds_tax.id')
            ->join('karats' , 'exit_old_tax_details.karat_id' , '=' , 'karats.id')
            ->select('exit_olds_tax.branch_id','exit_olds_tax.bill_number' , 'exit_olds_tax.date'
                , 'exit_olds_tax.discount' ,'exit_olds_tax.id', 'exit_olds_tax.supplier_id as client_id'
                ,'karats.name_ar as karat_name_ar' , 'exit_old_tax_details.weight' 
                , 'exit_old_tax_details.gram_price' ,'exit_old_tax_details.gram_manufacture' 
                , 'exit_old_tax_details.gram_tax','exit_old_tax_details.net_money' 
                , 'exit_old_tax_details.karat_id'
                ,'exit_olds_tax.user_id') 
            -> where('exit_olds_tax.net_money' ,'>' , 0)
            -> orderBy('exit_olds_tax.id'); 

        if($request -> branch_id > 0) $data = $data -> where('exit_works.branch_id' ,$request -> branch_id );
        if($request -> has('isStartDate')) $data = $data -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))  $data = $data -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> user_id > 0)  $data = $data -> where('exit_works.user_id' ,$request -> user_id  );

        if($request -> branch_id > 0) $data2 = $data2 -> where('exit_olds.branch_id' ,$request -> branch_id );
        if($request -> has('isStartDate')) $data2 = $data2 -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $data2 = $data2 -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> user_id > 0)  $data2 = $data2 -> where('exit_olds.user_id' ,$request -> user_id  );

        if($request -> branch_id > 0) $data3 = $data3 -> where('exit_works_tax.branch_id' ,$request -> branch_id );
        if($request -> has('isStartDate')) $data3 = $data3 -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $data3 = $data3 -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> user_id > 0)  $data3 = $data3 -> where('exit_works_tax.user_id' ,$request -> user_id  );

        if($request -> branch_id > 0) $data4 = $data4 -> where('exit_olds_tax.branch_id' ,$request -> branch_id );
        if($request -> has('isStartDate')) $data4 = $data4 -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))  $data4 = $data4 -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> user_id > 0)  $data4 = $data4 -> where('exit_olds_tax.user_id' ,$request -> user_id  );


        if($request ->FromBillNumber ) {
            $fromBill = substr($request -> FromBillNumber , 5  );
            $prefix = substr($request -> FromBillNumber , 0 , 5 );
            if($prefix  == 'SWSI-'){
                $bil = ExitWork::where('bill_number' , '=' , $request -> FromBillNumber) -> first();
                if($bil){
                    $data2 = [];
                    $data = $data -> where('exit_works.id' , '>=' , $bil -> id );
                }
            }elseif($prefix  == 'SOSI-'){
                $bil = ExitOld::where('bill_number' , '=' , $request -> FromBillNumber) -> first();
                if($bil){
                    $data= [];
                    $data2 = $data2 -> where('exit_olds.id' , '>=' , $bil -> id );
                }

            }elseif($prefix  == 'SWSIX-'){
                $bil = ExitWorkTax::where('bill_number' , '=' , $request -> FromBillNumber) -> first();
                if($bil){
                    $data4 = [];
                    $data3 = $data3 -> where('exit_works_tax.id' , '>=' , $bil -> id );
                }
            }else{
                $bil = ExitOldTax::where('bill_number' , '=' , $request -> FromBillNumber) -> first();
                if($bil){
                    $data3= [];
                    $data4 = $data4 -> where('exit_olds_tax.id' , '>=' , $bil -> id );
                }

            }
        }

        if($request ->ToBillNumber ) {
            $fromBill = substr($request -> ToBillNumber , 5  );
            $prefix = substr($request -> ToBillNumber , 0 , 5 );
            if($prefix  == 'SWSI-'){
                $bil = ExitWork::where('bill_number' , '=' , $request -> ToBillNumber) -> first();
                if($bil){
                    $data2 = [];
                    $data = $data -> where('exit_works.id' , '<=' , $bil -> id );
                }

            }elseif($prefix  == 'SOSI-'){
                $bil = ExitOld::where('bill_number' , '=' , $request -> ToBillNumber) -> first();
                if($bil){
                    $data= [];
                    $data2 = $data2 -> where('exit_olds.id' , '<=' , $bil -> id );
                }

            }elseif($prefix  == 'SWSIX-'){
                $bil = ExitWorkTax::where('bill_number' , '=' , $request -> ToBillNumber) -> first();
                if($bil){
                    $data4 = [];
                    $data3 = $data3 -> where('exit_works_tax.id' , '<=' , $bil -> id );
                }
            }else{
                $bil = ExitOldTax::where('bill_number' , '=' , $request -> ToBillNumber) -> first();
                if($bil){
                    $data3= [];
                    $data4 = $data4 -> where('exit_olds_tax.id' , '<=' , $bil -> id );
                } 
            }
        }

        $bills = array();
        $data22 =[] ;

        foreach (is_array($data) ? $data   : $data -> get()  as $bill){
            $client = Company::find($bill -> client_id);
            $w = ExitWork::with('cash:id,based_on_bill_number,amount','visa:id,based_on_bill_number,amount')->find($bill->id);
            
            $bill -> cash_amount =  $w -> cash-> amount ?? 0;
            $bill -> visa_amount =  $w -> visa-> amount ?? 0;  
            $bill -> client =   $client -> name  ?? ''; 
            $bill -> type = 1 ;

            array_push($bills , $bill);
        } 

        foreach (is_array($data2) ? $data2   : $data2 -> get() as $bill){
            $client = Company::find($bill -> client_id);
            $w = ExitOld::with('cash:id,based_on_bill_number,amount','visa:id,based_on_bill_number,amount')->find($bill->id);
            
            $bill -> cash_amount =  $w -> cash-> amount ?? 0;
            $bill -> visa_amount =  $w -> visa-> amount ?? 0;   
            $bill -> client =   $client -> name ?? '';  
            $bill -> type = 0 ;
            $bill -> item_name_ar  = '--';
            $bill -> item_name_en  = '--';
            array_push($bills , $bill);
            array_push($data22 , $bill);

        } 

        $data44 =[] ;

        foreach (is_array($data3) ? $data3   : $data3 -> get()  as $bill){
            $client = Company::find($bill -> client_id); 
            $w = ExitWorkTax::with('cash:id,based_on_bill_number,amount','visa:id,based_on_bill_number,amount')->find($bill->id);
            
            $bill -> cash_amount =  $w -> cash-> amount ?? 0;
            $bill -> visa_amount =  $w -> visa-> amount ?? 0;   
            $bill -> client =   $client -> name ?? '';  

            $bill -> type = 1 ;
            array_push($bills , $bill);
        } 

        foreach (is_array($data4) ? $data4   : $data4 -> get() as $bill){
            $client = Company::find($bill -> client_id); 
            $w = ExitOldTax::with('cash:id,based_on_bill_number,amount','visa:id,based_on_bill_number,amount')->find($bill->id);
            
            $bill -> cash_amount =  $w -> cash-> amount ?? 0;
            $bill -> visa_amount =  $w -> visa-> amount ?? 0;   
            $bill -> client =   $client -> name ?? '';  
            $bill -> type = 0 ;
            $bill -> item_name_ar  = '--';
            $bill -> item_name_en  = '--';
            array_push($bills , $bill);
            array_push($data44 , $bill);

        }

        $all1 = $data -> get() -> merge($data22);
        $all2 = $data3 -> get() -> merge($data44); 

        $all = $all1 -> merge($all2);

        $grouped_ar = $all   -> groupBy('karat_name_ar');
        $grouped_en = $all   -> groupBy('karat_name_en');

        $startDate = Carbon::now()->addYears(-5);
        $endDate = Carbon::now() -> addDays(1);

        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        if($request -> user_id > 0){
            $user = User::find($request -> user_id);
            $user =  $user->name;
        }else{
            $user =  'الكل';
        }

        return view('admin.Report.sales_report_result' , compact('bills', 'branch', 'grouped_ar','grouped_en' , 'period' , 'period_ar' ,'company','user' ))  ;
    } 

    public function sales_collectible_report(){
        $branches = Branch::where('status',1)->get();  
        return view('admin.Report.sales_collectible_report', compact('branches'))  ;
    }

    public function sales_collectible_report_search(Request $request){

        $data = DB::table('sale_collectibles_details')
            -> join('sale_collectibles' , 'sale_collectibles_details.bill_id' , '=' , 'sale_collectibles.id')
            ->join('items_collectibles' , 'sale_collectibles_details.item_id' , '=' , 'items_collectibles.id')
            ->join('karats' , 'sale_collectibles_details.karat_id' , '=' , 'karats.id')
            ->select('sale_collectibles.branch_id' ,'sale_collectibles.bill_number' , 'sale_collectibles.date' , 'sale_collectibles.id' ,  'sale_collectibles.client_id as client_id',
                'sale_collectibles.discount', 'items_collectibles.name_ar as item_name_ar' , 'items_collectibles.name_en as item_name_en'
                ,'karats.name_ar as karat_name_ar' , 'karats.name_en as karat_name_en' , 'sale_collectibles_details.weight' , 'sale_collectibles_details.gram_price' ,
                'sale_collectibles_details.gram_manufacture' , 'sale_collectibles_details.gram_tax','sale_collectibles_details.net_money' , 'sale_collectibles_details.karat_id')
            -> where('sale_collectibles.net_money' ,'>' , 0)
            -> orderBy('sale_collectibles.id');

     
        if($request -> branch_id > 0) $data = $data -> where('sale_collectibles.branch_id' ,$request -> branch_id );
        if($request -> has('isStartDate')) $data = $data -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $data = $data -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
 
        if($request ->FromBillNumber ) {
            $fromBill = substr($request -> FromBillNumber , 5  );
            $prefix = substr($request -> FromBillNumber , 0 , 5 );
            if($prefix  == 'SWSIC-'){
                $bil = SaleCollectible::where('bill_number' , '=' , $request -> FromBillNumber) -> first();
                if($bil){ 
                    $data = $data -> where('sale_collectibles.id' , '>=' , $bil -> id );
                }
            } 
        }

        if($request ->ToBillNumber ) {
            $fromBill = substr($request -> ToBillNumber , 5  );
            $prefix = substr($request -> ToBillNumber , 0 , 5 );
            if($prefix  == 'SWSIC-'){
                $bil = SaleCollectible::where('bill_number' , '=' , $request -> ToBillNumber) -> first();
                if($bil){ 
                    $data = $data -> where('sale_collectibles.id' , '<=' , $bil -> id );
                }

            } 
        }

        $bills = array();
        $data22 =[] ;

        foreach (is_array($data) ? $data   : $data -> get()  as $bill){
            $client = Company::find($bill -> client_id);
            if($client)
                $bill -> client =   $client -> name ;
            else
                $bill -> client = '';
            $bill -> type = 1 ;
            array_push($bills , $bill);
        } 

        $all = $data -> get();  

        $grouped_ar = $all   -> groupBy('karat_name_ar');
        $grouped_en = $all   -> groupBy('karat_name_en');

        $startDate = Carbon::now()->addYears(-5);
        $endDate = Carbon::now() -> addDays(1);

        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);
        return view('admin.Report.sales_collectible_report_result' , compact('bills','branch','grouped_ar' ,'grouped_en' , 'period' , 'period_ar' ,'company' ))  ;
    }

    public function purchase_report(){
        $pricings = Pricing::all(); 
        $branches = Branch::where('status',1)->get(); 
        return view('admin.Report.purchase_report', compact('branches'));
    }

    public function purchase_report_search(Request $request){
        

        if($request->type == 3 or $request->type == 4){

            $work = DB::table('enter_work_details')
                -> join('enter_works' , 'enter_work_details.bill_id' , '=' , 'enter_works.id')
                ->join('karats' , 'enter_work_details.karat_id' , '=' , 'karats.id')
                ->select('enter_works.bill_number' , 'enter_works.id' ,'enter_works.branch_id'
                    ,'enter_works.date' , 'enter_works.supplier_id as supplier_id'
                    ,'karats.name_ar as karat_name_ar' , 'karats.name_en as karat_name_en' 
                    , 'enter_work_details.weight' , 'enter_work_details.made_money','enter_work_details.tax'
                    ,'enter_work_details.net_weight' , 'enter_work_details.net_money' 
                    , 'enter_work_details.karat_id' , 'enter_work_details.weight21');


        } 

        if($request->type == 2){
            $data2 = DB::table('enter_old_details')
                -> join('enter_olds' , 'enter_old_details.bill_id' , '=' , 'enter_olds.id')
                ->join('karats' , 'enter_old_details.karat_id' , '=' , 'karats.id')
                ->select('enter_olds.bill_number'  , 'enter_olds.id','enter_olds.branch_id'
                    , 'enter_olds.date' , 'enter_olds.supplier_id as supplier_id'
                    ,'karats.name_ar as karat_name_ar' , 'karats.name_en as karat_name_en' 
                    , 'enter_old_details.weight' , 'enter_old_details.made_money', 'enter_old_details.tax'
                    ,'enter_old_details.net_weight' , 'enter_old_details.net_money' 
                    , 'enter_old_details.karat_id' , 'enter_old_details.weight21'
                    ,'enter_olds.bill_type')
                ->where('enter_olds.bill_type',2);

        }else if($request->type == 0){

            $data2 = DB::table('enter_old_details')
                -> join('enter_olds' , 'enter_old_details.bill_id' , '=' , 'enter_olds.id')
                ->join('karats' , 'enter_old_details.karat_id' , '=' , 'karats.id')
                ->select('enter_olds.bill_number'  , 'enter_olds.id','enter_olds.branch_id'
                    , 'enter_olds.date' , 'enter_olds.supplier_id as supplier_id'
                    ,'karats.name_ar as karat_name_ar' , 'karats.name_en as karat_name_en' 
                    , 'enter_old_details.weight' , 'enter_old_details.made_money', 'enter_old_details.tax'
                    ,'enter_old_details.net_weight' , 'enter_old_details.net_money' 
                    , 'enter_old_details.karat_id' , 'enter_old_details.weight21'
                    ,'enter_olds.bill_type')
                ->where('enter_olds.bill_type',0);

        }else{
            $data2 = DB::table('enter_old_details')
                -> join('enter_olds' , 'enter_old_details.bill_id' , '=' , 'enter_olds.id')
                ->join('karats' , 'enter_old_details.karat_id' , '=' , 'karats.id')
                ->select('enter_olds.bill_number'  , 'enter_olds.id','enter_olds.branch_id'
                    ,'enter_olds.date' , 'enter_olds.supplier_id as supplier_id'
                    ,'karats.name_ar as karat_name_ar' , 'karats.name_en as karat_name_en' 
                    ,'enter_old_details.weight' , 'enter_old_details.made_money', 'enter_old_details.tax'
                    ,'enter_old_details.net_weight' , 'enter_old_details.net_money' 
                    ,'enter_old_details.karat_id' , 'enter_old_details.weight21'
                    ,'enter_olds.bill_type');


        }

        
        $bills = array(); 
        if($request->type == 3 or $request->type == 4){

            if($request -> branch_id > 0) $data = $work -> where('enter_works.branch_id' , $request -> branch_id);        
            if($request -> has('isStartDate')) $data = $work -> where('enter_works.date' , '>=' , Carbon::parse($request -> StartDate) );
            if($request -> has('isEndDate'))   $data = $work -> where('enter_works.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
           
            foreach ($data-> get() as $bill){
                $supplier = Company::find($bill -> supplier_id);
                if($supplier)
                    $bill -> supplier =   $supplier -> name ;
                else
                    $bill -> supplier = '';
                $bill -> type = 1 ;
                array_push($bills , $bill);
            }
        }

        if(($request->type == 0  or $request->type == 2) or $request->type == 4){ 

            if($request -> branch_id > 0) $data2 = $data2 -> where('enter_olds.branch_id' , $request -> branch_id);     
            if($request -> has('isStartDate')) $data2 = $data2 -> where('enter_olds.date' , '>=' , Carbon::parse($request -> StartDate) );
            if($request -> has('isEndDate'))   $data2 = $data2 -> where('enter_olds.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());

            foreach ($data2 -> get() as $bill){

                $supplier = Company::find($bill -> supplier_id);

                if($supplier)
                    $bill -> supplier = $supplier -> name ;
                else
                    $bill -> supplier = ''; 

                $bill -> type = $bill ->bill_type;  
                array_push($bills , $bill);
            } 
        } 

        if(isset($data) and isset($data2)){
            $all = $data -> get() -> merge($data2 -> get());
        }else if(isset($data) and !isset($data2)){
            $all = $data -> get();
        }else if(!isset($data) and isset($data2)){
            $all = $data2 -> get();
        }  

        $grouped_ar = $all   -> groupBy('karat_name_ar');
        $grouped_en = $all   -> groupBy('karat_name_en');

        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate; 
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ; 
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ; 
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        if($request->type == 4){
            $type = 'عام'; 
        }else if($request->type == 3){
            $type = 'ذهب مشغول';
        }else if($request->type == 2){
            $type = 'ذهب صافي';
        }else if($request->type == 0){
            $type = 'ذهب كسر';
        }

        return view('admin.Report.purchase_report_result' , compact('bills', 'branch','grouped_ar','grouped_en', 'period' , 'period_ar' , 'company','type'))  ;

    }
    

    public function purchase_collectible_report(){
        $pricings = Pricing::all(); 
        $branches = Branch::where('status',1)->get();

        return view('admin.Report.purchase_collectible_report', compact('branches'));
    }

    public function purchase_collectible_report_search(Request $request){
        $data = DB::table('purchase_collectible_details')
            -> join('purchases_collectibles' , 'purchase_collectible_details.bill_id' , '=' , 'purchases_collectibles.id') 
            ->join('items_collectibles' , 'purchase_collectible_details.item_id' , '=' , 'items_collectibles.id')
            ->select('purchases_collectibles.bill_number' , 'purchases_collectibles.id','purchases_collectibles.branch_id' , 'purchases_collectibles.date' , 'purchases_collectibles.supplier_id as supplier_id'
                , 'purchase_collectible_details.weight' , 'purchase_collectible_details.made_money' ,'items_collectibles.name_ar as item_ar','items_collectibles.name_en as item_en'
                ,'purchase_collectible_details.net_weight' , 'purchase_collectible_details.net_money' , 'purchase_collectible_details.karat_id') ;
 
        if($request ->branch_id > 0) $data = $data -> where('purchases_collectibles.branch_id' ,$request ->branch_id);        
        if($request -> has('isStartDate')) $data = $data -> where('purchases_collectibles.date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $data = $data -> where('purchases_collectibles.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
 
        $bills = array();
        foreach ($data-> get() as $bill){
            $supplier = Company::find($bill -> supplier_id);
            if($supplier)
                $bill -> supplier =   $supplier -> name ;
            else
                $bill -> supplier = '';
            $bill -> type = 1 ;
            array_push($bills , $bill);
        }
        

        $all = $data -> get();

        $grouped_ar = $all   -> groupBy('karat_name_ar');
        $grouped_en = $all   -> groupBy('karat_name_en');

        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;

            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;

        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;

            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        return view('admin.Report.purchase_collectible_report_result' , compact('bills', 'branch','grouped_ar' ,'grouped_en', 'period' , 'period_ar' , 'company'))  ;

    }

    public function vendor_account(){
        $vendors = Company::all(); 
        $branches = Branch::where('status',1)->get();
        return view('admin.Report.vendor_account' , compact('vendors','branches'));
    }

    public function vendor_account_search(Request $request){
        $client = Company::find($request -> vendor_id);
        $type = $client -> group_id ;
        $data = CompanyMovement::where('company_id' , '=' , $request -> vendor_id);

        if($request -> branch_id > 0) $data = $data -> where('branch_id' , $request -> branch_id);
        if($request -> has('isStartDate')) $data = $data -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate')) $data = $data -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());

        $movements = $data -> get();
        $slag =  14;
        $subSlag = 145 ;
 
        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ; 
            $period_ar .= ' - '  .Carbon::parse($startDate) -> format('d-m-Y');
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;

        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' - '  .Carbon::parse($endDate) -> addDay(-1)  -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        return view('admin.company.accountMovement' , compact('type' , 'branch', 'movements', 'slag' , 'subSlag' ,'period' , 'period_ar', 'company','client'));
    }

    public function gold_stock_report(){ 
        $branches = Branch::where('status',1)->get(); 
        return view('admin.Report.gold_stock_report', compact('branches'));
    }

    public function gold_stock_search(Request  $request){
        $workWarehouses = Warehouse::where('type' , '=' , 1); // ->get() -> groupBy('karat_id') ;
        $oldWarehouses = Warehouse::where('type' , '=' , 0) ; // -> get() -> groupBy('karat_id') ;
        $pureWarehouses = Warehouse::where('type' , '=' , 2) ;

        if($request -> branch_id > 0 ) $workWarehouses = $workWarehouses -> where('branch_id' , $request -> branch_id);
        if($request -> has('isStartDate')) $workWarehouses = $workWarehouses -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $workWarehouses = $workWarehouses -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        
        if($request -> branch_id > 0 ) $oldWarehouses = $oldWarehouses -> where('branch_id' , $request -> branch_id);
        if($request -> has('isStartDate')) $oldWarehouses = $oldWarehouses -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $oldWarehouses = $oldWarehouses -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
 
        if($request -> branch_id > 0 ) $pureWarehouses = $pureWarehouses -> where('branch_id' , $request -> branch_id);
        if($request -> has('isStartDate')) $pureWarehouses = $pureWarehouses -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $pureWarehouses = $pureWarehouses -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
 
        $karats = Karat::all();
        $work = $workWarehouses ->get() -> groupBy('karat_id') -> map(function ($item) {
            return [
                'enter_weight' => $item -> sum('enter_weight'),
                'out_weight'=> $item -> sum('out_weight'),
            ];
        });
        $old = $oldWarehouses ->get() -> groupBy('karat_id') -> map(function ($item) {
            return [
                'enter_weight' => $item -> sum('enter_weight'),
                'out_weight'=> $item -> sum('out_weight'),
            ];
        });
        $pure = $pureWarehouses ->get() -> groupBy('karat_id') -> map(function ($item) {
            return [
                'enter_weight' => $item -> sum('enter_weight'),
                'out_weight'=> $item -> sum('out_weight'),
            ];
        });

        $works = DB::table('exit_work_details')
            -> join('exit_works' , 'exit_work_details.bill_id' , '=' , 'exit_works.id')
            -> where('exit_works.total_money' , '<' , 0) 
            ->select('exit_work_details.*' , 'exit_works.date');

        $olds = DB::table('exit_old_details')
            -> join('exit_olds' , 'exit_old_details.bill_id' , '=' , 'exit_olds.id')
            -> where('exit_olds.total_money' , '<' , 0)
            -> where('exit_olds.bill_type' ,'=', 0)  
            ->select('exit_old_details.*' , 'exit_olds.date');

        $pures = DB::table('exit_old_details')
            -> join('exit_olds' , 'exit_old_details.bill_id' , '=' , 'exit_olds.id')
            -> where('exit_olds.total_money' , '<' , 0)
            -> where('exit_olds.bill_type' , 2) 
            
            ->select('exit_old_details.*' , 'exit_olds.date');

        if($request -> branch_id > 0) $works = $works-> where('exit_works.branch_id' ,$request -> branch_id);
        if($request -> branch_id > 0) $olds = $olds-> where('exit_olds.branch_id' ,$request -> branch_id);
        if($request -> branch_id > 0) $pures = $pures-> where('exit_olds.branch_id' ,$request -> branch_id);

        $workR = $works ->get() -> groupBy('karat_id') -> map(function ($item) {
            return [
                'RWeight' => $item -> sum('weight'),
            ];
        });

        $oldR = $olds ->get() -> groupBy('karat_id') -> map(function ($item) {
            return [
                'RWeight' => $item -> sum('weight'),
            ];
        });

        $pureR = $pures ->get() -> groupBy('karat_id') -> map(function ($item) {
            return [
                'RWeight' => $item -> sum('weight'),
            ];
        });

        $slag =  14;
        $subSlag = 146 ;
        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ;
            $period_ar .= Carbon::parse($startDate) -> format('d-m-Y') ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' - '  .Carbon::parse($endDate) -> addDay(-1)  -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        return view('admin.Item.gold_stock' , compact('work' , 'branch', 'old' , 'pure', 'karats' , 'slag' , 'subSlag' ,
            'period' , 'period_ar' , 'company'  , 'workR' , 'oldR','pureR')) ;
    
        }

    public function daily_all_movements(){
        $branches = Branch::where('status',1)->get(); 
        return view('admin.Report.daily_all_movements' , compact('branches'));
    }

    public function daily_all_movements_search(Request $request){

        $workWarehouses = Warehouse::where('type' , '=' , 1);
        $oldWarehouses = Warehouse::where('type' , '<>' , 1) ; 

        if($request -> branch_id > 0) $workWarehouses = $workWarehouses -> where('branch_id' ,$request -> branch_id);
        if($request -> has('isStartDate')) $workWarehouses = $workWarehouses -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $workWarehouses = $workWarehouses -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());

        if($request -> branch_id > 0) $oldWarehouses = $oldWarehouses -> where('branch_id' ,$request -> branch_id);
        if($request -> has('isStartDate')) $oldWarehouses = $oldWarehouses -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $oldWarehouses = $oldWarehouses -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());

        $work = $workWarehouses ->get() -> groupBy('karat_id') -> map(function ($item) {
            return [
                'enter_weight' => $item -> sum('enter_weight'),
                'out_weight'=> $item -> sum('out_weight'),
            ];
        });
        $old = $oldWarehouses ->get() -> groupBy('karat_id') -> map(function ($item) {
            return [
                'enter_weight' => $item -> sum('enter_weight'),
                'out_weight'=> $item -> sum('out_weight'),
            ];
        });

        $enterMoney = EnterMoney::all();
        $exitMoney = ExitMoney::all();

        if($request -> branch_id > 0) $enterMoney = $enterMoney -> where('branch_id' , $request -> branch_id);
        if($request -> has('isStartDate')) $enterMoney = $enterMoney -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $enterMoney = $enterMoney -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        
        if($request -> branch_id > 0) $exitMoney = $exitMoney -> where('branch_id' , $request -> branch_id);
        if($request -> has('isStartDate')) $exitMoney = $exitMoney -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $exitMoney = $exitMoney -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
  

        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate; 
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ; 
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $karats = Karat::all();
        $branch = Branch::find($request -> branch_id);

        return view('admin.Report.daily_all_movements_result' , compact('karats' , 'branch','work', 'old' , 'enterMoney' ,
            'exitMoney' , 'period' , 'period_ar' , 'company'));
    }
	
    public function account_balance_search(Request $request){

        $startDate = Carbon::now()->addYears(-5);
        $endDate = Carbon::now() -> addDays(1);
        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $accounts = DB::table('accounts_trees')
            ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
            ->select('accounts_trees.code','accounts_trees.name',
                //تقريب الفوارق العشرية
                //DB::raw('ROUND(sum(account_movements.credit)) as credit'),
                //DB::raw('ROUND(sum(account_movements.debit)) as debit'))
                DB::raw('sum(account_movements.credit) as credit'),
                DB::raw('sum(account_movements.debit) as debit'))
            ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name')
            ->where('account_movements.date','>=',$startDate)
            ->where('account_movements.date','<=',$endDate)
            ->where('account_movements.notes','')
            ->get();

        foreach ($accounts as $account){
 
            $accountBalance = DB::table('accounts_trees')
                ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                ->select('accounts_trees.code','accounts_trees.name',
                    DB::raw('sum(account_movements.credit) as credit'),
                    DB::raw('sum(account_movements.debit) as debit'))
                ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name')
                ->where('account_movements.notes','')
                ->where('account_movements.date','<',$startDate)  
                ->where('accounts_trees.code',$account->code)
                ->first();

            if($accountBalance){
                $account->before_credit = $accountBalance->credit;
                $account->before_debit = $accountBalance->debit;
            } else {
                $account->before_credit = 0;
                $account->before_debit = 0;
            }
        }

        $company = CompanyInfo::all() -> first();
        return view('admin.Report.account_balance_report',compact('accounts' , 'period' , 'period_ar' , 'company'));
    }

    public function account_balance(){
        return view('admin.Report.account_balance');
    }

    public function box_movement_report(){ 
        $branches = Branch::where('status',1)->get(); 
        return view('admin.Report.box_movement_report', compact('branches') );
    }

    public function box_movement_report_search(Request $request){

        $startDate = Carbon::now()->addYears(-5);
        $endDate = Carbon::now() -> addDays(1);

        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
        }

        $enterMoney = EnterMoney::where('payment_method' , '=' , 0)
            ->where('date','>=',$startDate)
            ->where('date','<=',$endDate) 
            -> get(); 

        $exitMoney = ExitMoney::where('payment_method' , '=' , 0)
            ->where('date','>=',$startDate)
            ->where('date','<=',$endDate) 
            -> get();

        $catchs = DB::table('catch_recipts')
            -> select('catch_recipts.*' )
            ->where('date','>=',$startDate)
            ->where('date','<=',$endDate)
            -> get();

        $expenses = DB::table('expenses')
            -> select('expenses.*' )
            ->where('date','>=',$startDate)
            ->where('date','<=',$endDate)
            -> get();

        if($request->branch_id > 0 ) $enterMoney = $enterMoney->where('branch_id',$request->branch_id);
        if($request->branch_id > 0 ) $exitMoney = $exitMoney->where('branch_id',$request->branch_id);
        if($request->branch_id > 0 ) $catchs = $catchs->where('branch_id',$request->branch_id);
        if($request->branch_id > 0 ) $expenses = $expenses->where('branch_id',$request->branch_id);

        $holders = [];
        foreach ($enterMoney as $em){
            $holder = new Holder();
            $holder -> id = $em -> id ;
            $holder -> docNumber =  $em -> based_on_bill_number ? $em -> based_on_bill_number  : $em -> doc_number  ;
            $holder -> date = $em -> date  ;
            $holder -> docType =  $em -> based_on_bill_number ? (str_starts_with($em -> based_on_bill_number , 'SWSI') ? 'فاتور بيع ذهب مشغول' : 'فاتورة بيع ذهب كسر')  : 'مستند دخول نقدية' ;
            $holder -> debit = $em -> amount ;
            $holder -> credit = 0; 
            array_push($holders , $holder);
        }

        foreach ($exitMoney as $em){
            $holder = new Holder();
            $holder -> id = $em -> id ;
            $holder -> docNumber =  $em -> based_on_bill_number ? $em -> based_on_bill_number  : $em -> doc_number  ;
            $holder -> date = $em -> date  ;
            $holder -> docType =  ($em -> based_on_bill_number ? (str_starts_with($em -> based_on_bill_number , 'WEO') ? 'فاتور شراء ذهب  كسر/صافي' : '')  : 'مستند خروج نقدية' );
            $holder -> debit = 0 ;
            $holder -> credit = $em -> amount ;
            array_push($holders , $holder);
        }

        foreach ($catchs as $em){
            $holder = new Holder();
            $holder -> id = $em -> id ;
            $holder -> docNumber =  $em -> docNumber ;
            $holder -> date = $em -> date  ;
            $holder -> docType =  'مستند قبض حر'  ;
            $holder -> debit = $em -> amount ;
            $holder -> credit =  0;
            array_push($holders , $holder);
        }
        foreach ($expenses as $em){
            $holder = new Holder();
            $holder -> id = $em -> id ;
            $holder -> docNumber =  $em -> docNumber ;
            $holder -> date = $em -> date  ;
            $holder -> docType =  'مستند صرف حر'  ;
            $holder -> debit = 0 ;
            $holder -> credit =  $em -> amount;
            array_push($holders , $holder);
        }

        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        return view('admin.Report.box_movement_report_result' , compact('holders', 'branch','period', 'period_ar' , 'company'));
    }

    public function bank_movement_report(){ 
        $branches = Branch::where('status',1)->get(); 
        return view('admin.Report.bank_movement_report', compact('branches'));
    }

    public function bank_movement_report_search(Request $request){
        $startDate = Carbon::now()->addYears(-5);
        $endDate = Carbon::now() -> addDays(1);

        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
        }

        $enterMoney = EnterMoney::where('payment_method' , '=' , 1)
            ->where('date','>=',$startDate)
            ->where('date','<=',$endDate)
            -> get();

        $exitMoney = ExitMoney::where('payment_method' , '=' , 1)
            ->where('date','>=',$startDate)
            ->where('date','<=',$endDate)
            -> get();


        if($request->branch_id > 0 ) $enterMoney = $enterMoney->where('branch_id',$request->branch_id);
        if($request->branch_id > 0 ) $exitMoney = $exitMoney->where('branch_id',$request->branch_id);
        
        $holders = [];
        foreach ($enterMoney as $em){
            $holder = new Holder();
            $holder -> id = $em -> id ;
            $holder -> docNumber =  $em -> based_on_bill_number ? $em -> based_on_bill_number  : $em -> doc_number  ;
            $holder -> date = $em -> date  ;
            $holder -> docType =  $em -> based_on_bill_number ? (str_starts_with($em -> based_on_bill_number , 'SWSI') ? 'فاتور بيع ذهب مشغول' : 'فاتورة بيع ذهب كسر')  : 'مستند دخول نقدية' ;
            $holder -> debit = $em -> amount ;
            $holder -> credit = 0 ;
            array_push($holders , $holder);
        }

        foreach ($exitMoney as $em){
            $holder = new Holder();
            $holder -> id = $em -> id ;
            $holder -> docNumber =  $em -> based_on_bill_number ? $em -> based_on_bill_number  : $em -> doc_number  ;
            $holder -> date = $em -> date  ;
            $holder -> docType =  $em -> based_on_bill_number ? (str_starts_with($em -> based_on_bill_number , 'WEO') ? 'فاتور شراء ذهب كسر/صافي' : '')  : 'مستند خروج نقدية' ;
            $holder -> debit = 0 ;
            $holder -> credit = $em -> amount ;
            array_push($holders , $holder);
        }

        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate; 
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ; 
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ; 
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        return view('admin.Report.bank_movement_report_result' , compact('holders' , 'branch','period', 'period_ar' , 'company'));
    }

    public function sales_total_report(){ 
        $branches = Branch::where('status',1)->get(); 
        return view('admin.Report.sales_total_report', compact('branches'));
    }

    public function sales_total_report_search(Request $request){

        $data = ExitWork::where('total21_gold','>', 0)->where('net_money' , '>' , 0);
        $data2 = ExitOld::where('total21_gold','>', 0)->where('net_money' ,'>' , 0);
        $data3 = ExitWorkTax::where('total21_gold','>', 0)->where('net_money' ,'>' , 0);
        $data4 = ExitOldTax::where('total21_gold','>', 0)->where('net_money' ,'>' , 0);    

        if($request -> branch_id > 0) $data = $data -> where('branch_id' , $request -> branch_id);
        if($request -> has('isStartDate')) $data = $data -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $data = $data -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> billNumber) $data = $data -> where('bill_number' , '=' ,$request -> billNumber );
        if($request -> netMoney) $data = $data -> where('net_money' , '=' ,$request -> netMoney );

        if($request -> branch_id > 0) $data2 = $data2 -> where('branch_id' , $request -> branch_id);
        if($request -> has('isStartDate')) $data2 = $data2 -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $data2 = $data2 -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> billNumber) $data2 = $data2 -> where('bill_number' , '=' ,$request -> billNumber );
        if($request -> netMoney) $data2 = $data2 -> where('net_money' , '=' ,$request -> netMoney );

        if($request -> branch_id > 0) $data3 = $data3 -> where('branch_id' , $request -> branch_id);
        if($request -> has('isStartDate')) $data3 = $data3 -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $data3 = $data3 -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> billNumber) $data3 = $data3 -> where('bill_number' , '=' ,$request -> billNumber );
        if($request -> netMoney) $data3 = $data3 -> where('net_money' , '=' ,$request -> netMoney );

        if($request -> branch_id > 0) $data4 = $data4 -> where('branch_id' , $request -> branch_id);
        if($request -> has('isStartDate')) $data4 = $data4 -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $data4 = $data4 -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> billNumber) $data4 = $data4 -> where('bill_number' , '=' ,$request -> billNumber );
        if($request -> netMoney) $data4 = $data4 -> where('net_money' , '=' ,$request -> netMoney );


        $bills = array();
        $data22 =[] ;
        foreach ($data-> get() as $bill){
            $client = Company::find($bill -> client_id);
            if($client)
                $bill -> client = $client -> name;
            else
                $bill -> client = '';
            $bill -> type = 1 ;
            array_push($bills , $bill);
        }
 
        foreach (is_array($data2) ? $data2   : $data2 -> get() as $bill){
            $client = Company::find($bill -> supplier_id);
            if($client)
                $bill -> client = $client -> name;
            else
                $bill -> client = '';

            $bill -> type = 0 ;
            $bill -> item_name_ar  = '--';
            $bill -> item_name_en  = '--';
 
            array_push($data22 , $bill);
        }

        $bills2 = array();
        $data44 =[] ;
        foreach ($data3-> get() as $bill){
            $client = Company::find($bill -> client_id);
            if($client)
                $bill -> client = $client -> name;
            else
                $bill -> client = '';
            $bill -> type = 1 ;
            array_push($bills2 , $bill);
        }
 
        foreach (is_array($data4) ? $data4   : $data4 -> get() as $bill){
            $client = Company::find($bill -> supplier_id);
            if($client)
                $bill -> client = $client -> name;
            else
                $bill -> client = '';

            $bill -> type = 0 ;
            $bill -> item_name_ar  = '--';
            $bill -> item_name_en  = '--';
 
            array_push($data44 , $bill);
        }        

        $all1 =  collect($bills)  -> merge($data22);
        $all2 =  collect($bills2)  -> merge($data44);

        $all = $all1 -> merge($all2); 

        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        return view('admin.Report.sales_total_report_result' , compact('all' , 'branch','period', 'period_ar' , 'company'));
    }
    
    public function sales_collectible_total_report(){ 
        $branches = Branch::where('status',1)->get();
        return view('admin.Report.sales_collectible_total_report', compact('branches'));

    }

    public function sales_collectible_total_report_search(Request $request){

        $data = SaleCollectible::where('net_money' , '>' , 0); 

        if($request -> has('isStartDate')) $data = $data -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $data = $data -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> branch_id > 0) $data = $data -> where('branch_id' ,$request -> branch_id);
        if($request -> billNumber) $data = $data -> where('bill_number' , '=' ,$request -> billNumber );
        if($request -> netMoney) $data = $data -> where('net_money' , '=' ,$request -> netMoney );
 
        $bills = array(); 
        foreach ($data-> get() as $bill){
            $client = Company::find($bill -> client_id);
            if($client)
                $bill -> client = $client -> name;
            else
                $bill -> client = '';
            $bill -> type = 1 ;
            array_push($bills , $bill);
        } 

        $all =  $bills;

        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        return view('admin.Report.sales_collectible_total_report_result' , compact('all' , 'branch','period', 'period_ar' , 'company'));
    }

    public function purchase_total_report(){ 
        $branches = Branch::where('status',1)->get(); 
        return view('admin.Report.purchase_total_report', compact('branches'));
    }

    public function purchase_total_report_search(Request $request){
    
        $data = EnterWork::where('net_money' , '>' , 0); 
        $data2 = EnterOld::where('net_money' ,'>' , 0);
        
        if($request -> branch_id > 0) $data = $data -> where('branch_id' ,$request -> branch_id );
        if($request -> has('isStartDate')) $data = $data -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $data = $data -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> billNumber) $data = $data -> where('bill_number' , '=' ,$request -> billNumber );
        if($request -> netMoney) $data = $data -> where('net_money' , '=' ,$request -> netMoney );

        if($request -> branch_id > 0) $data2 = $data2 -> where('branch_id' ,$request -> branch_id );
        if($request -> has('isStartDate')) $data2 = $data2 -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate')) $data2 = $data2 -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> billNumber) $data2 = $data2 -> where('bill_number' , '=' ,$request -> billNumber );
        if($request -> netMoney) $data2 = $data2 -> where('net_money' , '=' ,$request -> netMoney );

        $bills = array();
        $data22 =[] ;

        foreach ($data-> get() as $bill){
            $supplier = Company::find($bill -> supplier_id);
            if($supplier)
                $bill -> supplier =   $supplier -> name ;
            else
                $bill -> supplier = '';
            $bill -> type = 1 ;
            array_push($bills , $bill);
        }
        foreach ($data2 -> get() as $bill){
            $supplier = Company::find($bill -> supplier_id);
            if($supplier)
                $bill -> supplier =   $supplier -> name ;
            else
                $bill -> supplier = '';
            $bill -> type = 0 ;
            array_push($bills , $bill);
        }

        $all =  collect($bills)  -> merge($data22);
        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay(); 
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        return view('admin.Report.purchase_total_report_result' , compact('all', 'branch', 'period', 'period_ar' , 'company'));
    }


    public function purchase_collectible_total_report(){ 
        $branches = Branch::where('status',1)->get(); 
        return view('admin.Report.purchase_collectible_total_report', compact('branches'));
    }
    
    public function purchase_collectible_total_report_search(Request $request){
    
        $data = PurchasesCollectible::where('net_money' , '>' , 0); 

        if($request -> branch_id > 0) $data = $data -> where('branch_id' ,$request -> branch_id );
        if($request -> has('isStartDate')) $data = $data -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $data = $data -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> billNumber) $data = $data -> where('bill_number' , '=' ,$request -> billNumber );
        if($request -> netMoney) $data = $data -> where('net_money' , '=' ,$request -> netMoney );
 
        $bills = array(); 

        foreach ($data-> get() as $bill){
            $supplier = Company::find($bill -> supplier_id);
            if($supplier)
                $bill -> supplier =   $supplier -> name ;
            else
                $bill -> supplier = '';
            $bill -> type = 1 ;
            array_push($bills , $bill);
        }
    


        $all =   $bills ;
        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;

            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;

        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;

            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        return view('admin.Report.purchase_collectible_total_report_result' , compact('all' ,'branch', 'period' , 'period_ar' , 'company'));

    }

    public function purchase_sales_total_report(){
       
        return view('admin.Report.purchase_sales_total_report');
    }
    
  

    public function movement_report(){ 
        return view('admin.Report.movement_report');
    }

    public function movement_report_search(Request $request){ 

        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;

            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;

        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;

            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();

        $karats = Karat::all();

        $Warehouses = Warehouse::where('type' , '<>' , 2);
        if($request -> has('isStartDate')) $Warehouses = $Warehouses -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $Warehouses = $Warehouses -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        $ware = $Warehouses ->get() -> groupBy('karat_id') -> map(function ($item) {
            return [
                'enter_weight' => $item -> sum('enter_weight'),
                'out_weight'=> $item -> sum('out_weight'),
            ];
        });
        $data = collect($ware);

        $returnW = DB::table('exit_work_details')
            -> join('exit_works' , 'exit_work_details.bill_id' , '=' , 'exit_works.id')
            -> select('exit_work_details.*' , 'exit_works.date' )
            ->where('exit_works.returned_bill_id' , '>'  , 0);
        $returnO = DB::table('exit_old_details')
            -> join('exit_olds' , 'exit_old_details.bill_id' , '=' , 'exit_olds.id')
            -> select('exit_old_details.*' , 'exit_olds.date' )
            ->where('exit_olds.returned_bill_id' , '>'  , 0) ;

        if($request -> has('isStartDate')) $returnW = $returnW -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $returnW = $returnW -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> has('isStartDate')) $returnO = $returnO -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $returnO = $returnO -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        
        $reW = $returnW ->get() -> groupBy('karat_id') -> map(function ($item) {
            return [
                'weight' => $item -> sum('weight'),
            ];
        });

        $reO = $returnO ->get() -> groupBy('karat_id') -> map(function ($item) {
            return [
                'weight' => $item -> sum('weight'),
            ];
        });

        $salesW = DB::table('exit_works')
            ->where('exit_works.returned_bill_id' , '='  , 0)
            -> sum('exit_works.total_money');

        $salesO = DB::table('exit_olds')
            ->where('exit_olds.returned_bill_id' , '='  , 0)
            -> sum('exit_olds.total_money');

        $returnW = DB::table('exit_works')
            ->where('exit_works.returned_bill_id' , '<>'  , 0)
            -> sum('exit_works.total_money');

        $returnO = DB::table('exit_olds')
            ->where('exit_olds.returned_bill_id' , '<>'  , 0)
            -> sum('exit_olds.total_money');

        $purchaseW = DB::table('enter_works')
            -> sum('enter_works.total_money');

        $purchaseO = DB::table('enter_olds')
            -> sum('enter_olds.total_money');

        $salesWorkVAl = DB::table('exit_work_details')
            ->join('exit_works' , 'exit_work_details.bill_id' , '=' , 'exit_works.id')
            -> join('items' , 'exit_work_details.item_id' , '=' ,'items.id')
            ->where('exit_works.returned_bill_id' , '='  , 0)
            -> select(DB::raw('sum(items.made_Value * items.weight) as total'))->get() -> first();

        $returnWorkVAl = DB::table('exit_work_details')
            ->join('exit_works' , 'exit_work_details.bill_id' , '=' , 'exit_works.id')
            -> join('items' , 'exit_work_details.item_id' , '=' ,'items.id')
            ->where('exit_works.returned_bill_id' , '<>'  , 0)
            -> select(DB::raw('sum(items.made_Value * items.weight) as total'))->get() -> first();

        $expenses = DB::table('expenses')
            ->join('accounts_trees' , 'expenses.to_account' , '=' , 'accounts_trees.id')
            ->select('expenses.*' , 'accounts_trees.name as account_name');

        if($request -> has('isStartDate')) $expenses = $expenses -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $expenses = $expenses -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());

        $exp = $expenses ->get() -> groupBy('account_name') -> map(function ($item) {
            return [
                'total' => $item -> sum('amount'),
            ];
        });

        return view('admin.Report.movement_report_result' , compact('company' , 'routes' , 'data' , 'period' , 'period_ar' , 'karats' , 'reW' , 'reO' ,
            'salesW' , 'salesO' , 'returnW' , 'returnO' , 'purchaseW' , 'purchaseO' , 'salesWorkVAl' , 'returnWorkVAl' , 'exp'));

    }

    public function account_movement_report(){ 
        $accounts = AccountsTree::all();
        return view('admin.Report.account_movement' , compact( 'accounts'));
    }

    public function account_movement_report_search(Request $request){

        $startDate = Carbon::now()->addYears(-5);
        $endDate = Carbon::now() -> addDays(1);
        $period = 'Period : ';
        $period_ar = 'الفترة  :';

        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ;
            $period_ar .= Carbon::parse($startDate) -> format('d-m-Y') ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' - '  .Carbon::parse($endDate) -> addDay(-1)  -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $accounts = DB::table('accounts_trees')
                        ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                        ->join('journals','journals.id','=','account_movements.journal_id')
                        ->select('accounts_trees.code','accounts_trees.name','accounts_trees.side'
                            ,'journals.basedon_no','journals.baseon_text'
                            ,'account_movements.credit as credit'
                            ,'account_movements.debit as debit' , 'account_movements.notes','account_movements.date') 
                        ->where('account_movements.date','>=',$startDate)
                        ->where('account_movements.date','<=',$endDate)
                        ->where('accounts_trees.id' , '=' , $request -> account_id) 
                        ->get();

        $account_balance = DB::table('accounts_trees')
                        ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                        ->select('accounts_trees.code','accounts_trees.name as account_name','accounts_trees.side',
                            DB::raw('SUM(account_movements.credit) before_credit'),
                            DB::raw('SUM(account_movements.debit) before_debit'))
                        ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name','accounts_trees.side')
                        ->where('account_movements.date','<',$startDate)
                        ->where('accounts_trees.id' , '=' , $request -> account_id) 
                        ->first();
 
       
        $isaccount = AccountsTree::where('id',$request -> account_id) -> first();
        $account_name = $isaccount->name .' - '. $isaccount ->code;
        $company = CompanyInfo::all() -> first();
      
        return view('admin.Report.account_movement_report',compact('accounts' ,'account_balance' ,'period' , 'period_ar' , 'company','account_name'));
    }

    public function account_company_report_search($id){ 

        $period_ar = 'الفترة  :'; 
        $period_ar .= 'من البداية' ;  
        $period_ar .= ' -- '  . 'حتى اليوم' ; 

        $accounts = DB::table('accounts_trees')
                        ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                        ->join('journals','journals.id','=','account_movements.journal_id')
                        ->select('accounts_trees.code','accounts_trees.name','accounts_trees.side'
                        ,'journals.basedon_no','journals.baseon_text'
                        ,'account_movements.credit as credit'
                        ,'account_movements.debit as debit' , 'account_movements.notes','account_movements.date') 
                        ->where('accounts_trees.id',$id) 
                        ->get();

        $account_balance = DB::table('accounts_trees')
                        ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                        ->select('accounts_trees.code','accounts_trees.name as account_name','accounts_trees.side',
                            DB::raw('SUM(account_movements.credit) before_credit'),
                            DB::raw('SUM(account_movements.debit) before_debit'))
                        ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name','accounts_trees.side')
                        ->whereYear('account_movements.date','<',date("Y"))
                        ->where('accounts_trees.id', $id) 
                        ->first();
       
        $isaccount = AccountsTree::where('id',$id) -> first();
        $account_name = $isaccount->name .' - '. $isaccount ->code;
        $company = CompanyInfo::all() -> first();
      
        return view('admin.Report.account_movement_report',compact('accounts','account_balance','period_ar', 'company','account_name'));
    }

    //
    public function account_companies_details_report(){ 

        $accounts = AccountsTree::where('parent_code',2101) -> get();
        $branches = Branch::where('status',1)->get(); 
        return view('admin.Report.account_companies_details' , compact( 'accounts','branches'));

    }

    public function account_companies_details_search(Request $request){

        $startDate = Carbon::now()->addYears(-5);
        $endDate = Carbon::now() -> addDays(1);
        $period = 'Period : ';
        $period_ar = 'الفترة  :';

        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ;
            $period_ar .= Carbon::parse($startDate) -> format('d-m-Y');
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay();
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' - '  .Carbon::parse($endDate) -> addDay(-1)  -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $accounts = DB::table('accounts_trees')
                        ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                        ->join('journals','journals.id','=','account_movements.journal_id')
                        ->select('accounts_trees.code','accounts_trees.name','accounts_trees.side'
                            ,'journals.basedon_no','journals.branch_id', 'journals.basedon_id','journals.baseon_text'
                            ,'account_movements.credit as credit' ,'account_movements.debit as debit' 
                            , 'account_movements.notes','account_movements.date') 
                        ->where('account_movements.date','>=',$startDate)
                        ->where('account_movements.date','<=',$endDate)
                        ->where('accounts_trees.id' , '=' , $request -> account_id); 

        if($request -> branch_id > 0){
            $accounts = $accounts->where('journals.branch_id', $request -> branch_id)->get();
        }else{
            $accounts = $accounts->get();
        }
         
        if($request -> branch_id > 0){
            $account_balance = DB::table('accounts_trees')
                ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                ->join('journals','journals.id','=','account_movements.journal_id')
                ->select('accounts_trees.code','accounts_trees.name as account_name','accounts_trees.side',
                    DB::raw('SUM(account_movements.credit) before_credit'),
                    DB::raw('SUM(account_movements.debit) before_debit'))
                ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name','accounts_trees.side')
                ->where('account_movements.date','<',$startDate)
                ->where('accounts_trees.id' , '=' , $request -> account_id)
                ->where('journals.branch_id' , '=' , $request -> branch_id)
                ->first();
        }else{
            $account_balance = DB::table('accounts_trees')
                ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                ->join('journals','journals.id','=','account_movements.journal_id')
                ->select('accounts_trees.code','accounts_trees.name as account_name','accounts_trees.side',
                    DB::raw('SUM(account_movements.credit) before_credit'),
                    DB::raw('SUM(account_movements.debit) before_debit'))
                ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name','accounts_trees.side')
                ->where('account_movements.date','<',$startDate)
                ->where('accounts_trees.id' , '=' , $request -> account_id)
                ->first();
        }

  
        foreach ($accounts as $account){ 
    
            if (EnterOld::where('bill_number', $account->basedon_no)->exists()) {  
                $accountkarats = DB::table('enter_old_details')
                    ->join('karats','enter_old_details.karat_id','=','karats.id')
                    ->select('enter_old_details.id','karats.name_ar', 
                        DB::raw('SUM(CASE WHEN karats.label="K24"   THEN enter_old_details.weight END) K24'),
                        DB::raw('SUM(CASE WHEN karats.label="K21"  THEN enter_old_details.weight END) K21'),
                        DB::raw('SUM(CASE WHEN karats.label="K18" THEN enter_old_details.weight END) K18') )
                    ->groupBy('enter_old_details.id','karats.name_ar' )
                    ->where('enter_old_details.bill_id',$account->basedon_id) 
                    ->get();

                if($accountkarats){

                    foreach($accountkarats as $accountkarat){
                        
                        if( $accountkarat->K24 < 0 ){
                            $account->debit_K24 = $accountkarat->K24 * -1;
                        }else if( $accountkarat->K24 > 0 ){
                            $account->credit_K24 = $accountkarat->K24;
                        }

                        if( $accountkarat->K21 < 0 ){ 
                            $account->debit_K21 = $accountkarat->K21 * -1;
                        } else if( $accountkarat->K21 > 0 ){ 
                            $account->credit_K21 = $accountkarat->K21;
                        }

                        if( $accountkarat->K18 < 0 ){
                            $account->debit_K18 = $accountkarat->K18  * -1;
                        } else if( $accountkarat->K18 > 0 ){
                            $account->credit_K18 = $accountkarat->K18;
                        } 

                    }
                } 
            } 

            if (EnterWork::where('bill_number', $account->basedon_no)->exists()) {  

                $accountkarats = DB::table('enter_work_details')
                    ->join('karats','enter_work_details.karat_id','=','karats.id')
                    ->select('karats.name_ar', 
                        DB::raw('SUM(CASE WHEN karats.label="K24"  THEN enter_work_details.weight END) K24'),
                        DB::raw('SUM(CASE WHEN karats.label="K21"  THEN enter_work_details.weight END) K21'),
                        DB::raw('SUM(CASE WHEN karats.label="K18"  THEN enter_work_details.weight END) K18') )
                    ->groupBy('enter_work_details.karat_id','karats.name_ar')
                    ->where('enter_work_details.bill_id',$account->basedon_id) 
                    ->get();


                
                if($accountkarats){

                    foreach($accountkarats as $accountkarat){
                        
                        if( $accountkarat->K24 < 0 ){
                            $account->debit_K24 = $accountkarat->K24 * -1;
                        }else if( $accountkarat->K24 > 0 ){
                            $account->credit_K24 = $accountkarat->K24;
                        }
    
                        if( $accountkarat->K21 < 0 ){ 
                            $account->debit_K21 = $accountkarat->K21 * -1;
                        } else if( $accountkarat->K21 > 0 ){ 
                            $account->credit_K21 = $accountkarat->K21;
                        }
    
                        if( $accountkarat->K18 < 0 ){
                            $account->debit_K18 = $accountkarat->K18  * -1;
                        } else if( $accountkarat->K18 > 0 ){
                            $account->credit_K18 = $accountkarat->K18;
                        } 
    
                    }
                } 
            }  

            if (CatchGoldRecipts::where('docNumber', $account->basedon_no)->exists()) {  

                $accountkarats = CatchGoldReciptsDetails::join('karats','catch_gold_recipts_details.karat_id','=','karats.id')
                    ->select('catch_gold_recipts_details.id','karats.name_ar', 
                        DB::raw('SUM(CASE WHEN karats.label="K24"   THEN catch_gold_recipts_details.weight END) K24'),
                        DB::raw('SUM(CASE WHEN karats.label="K21"  THEN catch_gold_recipts_details.weight END) K21'),
                        DB::raw('SUM(CASE WHEN karats.label="K18" THEN catch_gold_recipts_details.weight END) K18') )
                    ->groupBy('catch_gold_recipts_details.id','karats.name_ar' )
                    ->where('catch_gold_recipts_details.bill_id',$account->basedon_id) 
                    ->get();

               
                if($accountkarats){

                    foreach($accountkarats as $accountkarat){
                        
                        if( $accountkarat->K24 < 0 ){
                            $account->debit_K24 = $accountkarat->K24 * -1;
                        }else if( $accountkarat->K24 > 0 ){
                            $account->credit_K24 = $accountkarat->K24;
                        }
    
                        if( $accountkarat->K21 < 0 ){ 
                            $account->debit_K21 = $accountkarat->K21 * -1;
                        } else if( $accountkarat->K21 > 0 ){ 
                            $account->credit_K21 = $accountkarat->K21;
                        }
    
                        if( $accountkarat->K18 < 0 ){
                            $account->debit_K18 = $accountkarat->K18  * -1;
                        } else if( $accountkarat->K18 > 0 ){
                            $account->credit_K18 = $accountkarat->K18;
                        } 
    
                    }
                } 
            } 
 
            if (ExitWorkTax::where('bill_number', $account->basedon_no)->exists()) {  

                $accountkarats = ExitWorkTaxDetails::join('karats','exit_work_tax_details.karat_id','=','karats.id')
                    ->select('karats.name_ar', 
                        DB::raw('SUM(CASE WHEN karats.label="K24" THEN exit_work_tax_details.weight END) K24'),
                        DB::raw('SUM(CASE WHEN karats.label="K21" THEN exit_work_tax_details.weight END) K21'),
                        DB::raw('SUM(CASE WHEN karats.label="K18" THEN exit_work_tax_details.weight END) K18') )
                    ->groupBy('karats.name_ar' )
                    ->where('exit_work_tax_details.bill_id',$account->basedon_id) 
                    ->get();

               
                if($accountkarats){

                    foreach($accountkarats as $accountkarat){
                        
                        if( $accountkarat->K24 < 0 ){
                            $account->credit_K24 = $accountkarat->K24 * -1; 
                        }else if( $accountkarat->K24 > 0 ){
                            $account->debit_K24 = $accountkarat->K24;
                        }
    
                        if( $accountkarat->K21 < 0 ){ 
                            $account->credit_K21 = $accountkarat->K21 * -1;
                        } else if( $accountkarat->K21 > 0 ){ 
                            $account->debit_K21 = $accountkarat->K21;
                        }
    
                        if( $accountkarat->K18 < 0 ){
                            $account->credit_K18 = $accountkarat->K18  * -1;
                        } else if( $accountkarat->K18 > 0 ){
                            $account->debit_K18 = $accountkarat->K18;
                        } 
    
                    }
                } 
            } 

            if (ExitMoney::where('doc_number', $account->basedon_no)->exists()) {  

                $accountkarat = CompanyMovement::select('debit_gold')
                    ->where('company_movements.bill_number',$account->basedon_no)  
                    ->where('debit_gold','>',0)
                    ->first(); 

                if($accountkarat){ 
                    $account->debit_K21 = $accountkarat->debit_gold;  
                } 
                
            } 

            if(!isset($account->debit_K24)) $account->debit_K24 = 0;
            if(!isset($account->debit_K21)) $account->debit_K21 = 0;
            if(!isset($account->debit_K18)) $account->debit_K18 = 0;

            if(!isset($account->credit_K24)) $account->credit_K24 = 0;
            if(!isset($account->credit_K21)) $account->credit_K21 = 0;
            if(!isset($account->credit_K18)) $account->credit_K18 = 0;
        
        }
         
        $isaccount = AccountsTree::where('id',$request -> account_id) -> first();
        $account_name = $isaccount->name .' - '. $isaccount ->code;
        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);
        
   
        return view('admin.Report.account_companies_details_report'
            ,compact('accounts','branch','account_balance' ,'period' , 'period_ar' 
            , 'company','account_name'));
        
    }

    public function account_companies_details_public($id){

        $period ='';
        $period_ar = 'الفترة  :'; 
        $period_ar .= 'من البداية' ;  
        $period_ar .= ' -- '  . 'حتى اليوم';  

        if(!empty(Auth::user()->branch_id)) {
            $branch_id = Auth::user()->branch_id;
        }else{
            $branch_id = 0;
        }
       
        $accounts = DB::table('accounts_trees')
            ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
            ->join('journals','journals.id','=','account_movements.journal_id')
            ->select('accounts_trees.code','accounts_trees.name','accounts_trees.side'
                ,'journals.basedon_no','journals.branch_id', 'journals.basedon_id','journals.baseon_text'
                ,'account_movements.credit as credit' ,'account_movements.debit as debit' 
                , 'account_movements.notes','account_movements.date')  
            ->where('accounts_trees.id', $id);
    
        if($branch_id > 0){
            $accounts = $accounts->where('journals.branch_id', $branch_id)->get();
        }else{
            $accounts = $accounts->get();
        }
        
        if($branch_id > 0){
            $account_balance = DB::table('accounts_trees')
                ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                ->join('journals','journals.id','=','account_movements.journal_id')
                ->select('accounts_trees.code','accounts_trees.name as account_name','accounts_trees.side',
                    DB::raw('SUM(account_movements.credit) before_credit'),
                    DB::raw('SUM(account_movements.debit) before_debit'))
                ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name','accounts_trees.side')
                ->whereYear('account_movements.date','<',date("Y"))
                ->where('accounts_trees.id' , '=' , $id)
                ->where('journals.branch_id' , '=' , $branch_id)
                ->first();
        }else{
            $account_balance = DB::table('accounts_trees')
                ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                ->join('journals','journals.id','=','account_movements.journal_id')
                ->select('accounts_trees.code','accounts_trees.name as account_name','accounts_trees.side',
                    DB::raw('SUM(account_movements.credit) before_credit'),
                    DB::raw('SUM(account_movements.debit) before_debit'))
                ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name','accounts_trees.side')
                ->whereYear('account_movements.date','<',date("Y"))
                ->where('accounts_trees.id' , '=' , $id)
                ->first();
        }
    
      
        foreach ($accounts as $account){ 
    
            if (EnterOld::where('bill_number', $account->basedon_no)->exists()) {  
                $accountkarats = DB::table('enter_old_details')
                    ->join('karats','enter_old_details.karat_id','=','karats.id')
                    ->select('enter_old_details.id','karats.name_ar', 
                        DB::raw('SUM(CASE WHEN karats.label="K24"   THEN enter_old_details.weight END) K24'),
                        DB::raw('SUM(CASE WHEN karats.label="K21"  THEN enter_old_details.weight END) K21'),
                        DB::raw('SUM(CASE WHEN karats.label="K18" THEN enter_old_details.weight END) K18') )
                    ->groupBy('enter_old_details.id','karats.name_ar' )
                    ->where('enter_old_details.bill_id',$account->basedon_id) 
                    ->get();
    
                if($accountkarats){
    
                    foreach($accountkarats as $accountkarat){
                        
                        if( $accountkarat->K24 < 0 ){
                            $account->debit_K24 = $accountkarat->K24 * -1;
                        }else if( $accountkarat->K24 > 0 ){
                            $account->credit_K24 = $accountkarat->K24;
                        }
    
                        if( $accountkarat->K21 < 0 ){ 
                            $account->debit_K21 = $accountkarat->K21 * -1;
                        } else if( $accountkarat->K21 > 0 ){ 
                            $account->credit_K21 = $accountkarat->K21;
                        }
    
                        if( $accountkarat->K18 < 0 ){
                            $account->debit_K18 = $accountkarat->K18  * -1;
                        } else if( $accountkarat->K18 > 0 ){
                            $account->credit_K18 = $accountkarat->K18;
                        } 
    
                    }
                } 
            } 
    
            if (EnterWork::where('bill_number', $account->basedon_no)->exists()) {  
    
                $accountkarats = DB::table('enter_work_details')
                    ->join('karats','enter_work_details.karat_id','=','karats.id')
                    ->select('karats.name_ar', 
                        DB::raw('SUM(CASE WHEN karats.label="K24"  THEN enter_work_details.weight END) K24'),
                        DB::raw('SUM(CASE WHEN karats.label="K21"  THEN enter_work_details.weight END) K21'),
                        DB::raw('SUM(CASE WHEN karats.label="K18"  THEN enter_work_details.weight END) K18') )
                    ->groupBy('enter_work_details.karat_id','karats.name_ar')
                    ->where('enter_work_details.bill_id',$account->basedon_id) 
                    ->get();
    
    
                
                if($accountkarats){
    
                    foreach($accountkarats as $accountkarat){
                        
                        if( $accountkarat->K24 < 0 ){
                            $account->debit_K24 = $accountkarat->K24 * -1;
                        }else if( $accountkarat->K24 > 0 ){
                            $account->credit_K24 = $accountkarat->K24;
                        }
    
                        if( $accountkarat->K21 < 0 ){ 
                            $account->debit_K21 = $accountkarat->K21 * -1;
                        } else if( $accountkarat->K21 > 0 ){ 
                            $account->credit_K21 = $accountkarat->K21;
                        }
    
                        if( $accountkarat->K18 < 0 ){
                            $account->debit_K18 = $accountkarat->K18  * -1;
                        } else if( $accountkarat->K18 > 0 ){
                            $account->credit_K18 = $accountkarat->K18;
                        } 
    
                    }
                } 
            }  
    
            if (CatchGoldRecipts::where('docNumber', $account->basedon_no)->exists()) {  
    
                $accountkarats = CatchGoldReciptsDetails::join('karats','catch_gold_recipts_details.karat_id','=','karats.id')
                    ->select('catch_gold_recipts_details.id','karats.name_ar', 
                        DB::raw('SUM(CASE WHEN karats.label="K24"   THEN catch_gold_recipts_details.weight END) K24'),
                        DB::raw('SUM(CASE WHEN karats.label="K21"  THEN catch_gold_recipts_details.weight END) K21'),
                        DB::raw('SUM(CASE WHEN karats.label="K18" THEN catch_gold_recipts_details.weight END) K18') )
                    ->groupBy('catch_gold_recipts_details.id','karats.name_ar' )
                    ->where('catch_gold_recipts_details.bill_id',$account->basedon_id) 
                    ->get();
    
               
                if($accountkarats){
    
                    foreach($accountkarats as $accountkarat){
                        
                        if( $accountkarat->K24 < 0 ){
                            $account->debit_K24 = $accountkarat->K24 * -1;
                        }else if( $accountkarat->K24 > 0 ){
                            $account->credit_K24 = $accountkarat->K24;
                        }
    
                        if( $accountkarat->K21 < 0 ){ 
                            $account->debit_K21 = $accountkarat->K21 * -1;
                        } else if( $accountkarat->K21 > 0 ){ 
                            $account->credit_K21 = $accountkarat->K21;
                        }
    
                        if( $accountkarat->K18 < 0 ){
                            $account->debit_K18 = $accountkarat->K18  * -1;
                        } else if( $accountkarat->K18 > 0 ){
                            $account->credit_K18 = $accountkarat->K18;
                        } 
    
                    }
                } 
            } 
     
            if (ExitWorkTax::where('bill_number', $account->basedon_no)->exists()) {  
    
                $accountkarats = ExitWorkTaxDetails::join('karats','exit_work_tax_details.karat_id','=','karats.id')
                    ->select('karats.name_ar', 
                        DB::raw('SUM(CASE WHEN karats.label="K24" THEN exit_work_tax_details.weight END) K24'),
                        DB::raw('SUM(CASE WHEN karats.label="K21" THEN exit_work_tax_details.weight END) K21'),
                        DB::raw('SUM(CASE WHEN karats.label="K18" THEN exit_work_tax_details.weight END) K18') )
                    ->groupBy('karats.name_ar' )
                    ->where('exit_work_tax_details.bill_id',$account->basedon_id) 
                    ->get();
    
               
                if($accountkarats){
    
                    foreach($accountkarats as $accountkarat){
                        
                        if( $accountkarat->K24 < 0 ){
                            $account->credit_K24 = $accountkarat->K24 * -1; 
                        }else if( $accountkarat->K24 > 0 ){
                            $account->debit_K24 = $accountkarat->K24;
                        }
    
                        if( $accountkarat->K21 < 0 ){ 
                            $account->credit_K21 = $accountkarat->K21 * -1;
                        } else if( $accountkarat->K21 > 0 ){ 
                            $account->debit_K21 = $accountkarat->K21;
                        }
    
                        if( $accountkarat->K18 < 0 ){
                            $account->credit_K18 = $accountkarat->K18  * -1;
                        } else if( $accountkarat->K18 > 0 ){
                            $account->debit_K18 = $accountkarat->K18;
                        } 
    
                    }
                } 
            } 
    
            if (ExitMoney::where('doc_number', $account->basedon_no)->exists()) {  
    
                $accountkarat = CompanyMovement::select('debit_gold')
                    ->where('company_movements.bill_number',$account->basedon_no)  
                    ->where('debit_gold','>',0)
                    ->first(); 
    
                if($accountkarat){ 
                    $account->debit_K21 = $accountkarat->debit_gold;  
                } 
                
            } 
    
            if(!isset($account->debit_K24)) $account->debit_K24 = 0;
            if(!isset($account->debit_K21)) $account->debit_K21 = 0;
            if(!isset($account->debit_K18)) $account->debit_K18 = 0;
    
            if(!isset($account->credit_K24)) $account->credit_K24 = 0;
            if(!isset($account->credit_K21)) $account->credit_K21 = 0;
            if(!isset($account->credit_K18)) $account->credit_K18 = 0;
        
        }
         
        $isaccount = AccountsTree::where('id',$id) -> first();
        $account_name = $isaccount->name .' - '. $isaccount ->code;
        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($branch_id);
        
   
        return view('admin.Report.account_companies_details_report'
            ,compact('accounts','branch','account_balance' ,'period' , 'period_ar' 
            , 'company','account_name'));
  
    }

 


    public function tax_declaration(){
        
        return view('admin.Report.tax_declaration_report');
    }

    public function tax_declaration_report_search(Request $request){

        $startDate = Carbon::now()->addYears(-5);
        $endDate = Carbon::now() -> addDays(1);

        $period = 'Period : ';
        $period_ar = 'الفترة  : ';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;

            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;

        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;

            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
   
        $salesW = ExitWorkDetails::join('exit_works', 'exit_work_details.bill_id', '=', 'exit_works.id')
                ->select(ExitWorkDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                ->where('exit_works.date' , '>=' , Carbon::parse($request -> StartDate) )
                ->where('exit_works.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_works.net_money' ,'>' , 0)
                ->where('exit_work_details.gram_tax' , '>'  , 0)  
                ->first();

        $salesWReturn = ExitWorkDetails::join('exit_works', 'exit_work_details.bill_id', '=', 'exit_works.id')
                ->select(ExitWorkDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_works.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_works.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_works.net_money' ,'<' , 0)
                ->where('exit_work_details.gram_tax' , '>'  , 0)   
                ->first();  
                
        $salesO = ExitOldDetails::join('exit_olds', 'exit_old_details.bill_id', '=', 'exit_olds.id')
                ->select(ExitOldDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_olds.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_olds.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_olds.net_money' ,'>' , 0)
                ->where('exit_old_details.gram_tax' , '>'  , 0)   
                ->first();

        $salesOReturn = ExitOldDetails::join('exit_olds', 'exit_old_details.bill_id', '=', 'exit_olds.id')
                ->select(ExitOldDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_olds.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_olds.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_olds.net_money' ,'<' , 0) 
                ->where('exit_old_details.gram_tax' , '>'  , 0)  
                ->first();

        //Tax
 
        $salesT = ExitWorkTaxDetails::join('exit_works_tax', 'exit_work_tax_details.bill_id', '=', 'exit_works_tax.id')
                ->select(ExitWorkTaxDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                ->where('exit_works_tax.date' , '>=' , Carbon::parse($request -> StartDate) )
                ->where('exit_works_tax.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_works_tax.net_money' ,'>' , 0)
                ->where('exit_work_tax_details.gram_tax' , '>'  , 0)  
                ->first();

        $salesTReturn = ExitWorkTaxDetails::join('exit_works_tax', 'exit_work_tax_details.bill_id', '=', 'exit_works_tax.id')
                ->select(ExitWorkTaxDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_works_tax.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_works_tax.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_works_tax.net_money' ,'<' , 0)
                ->where('exit_work_tax_details.gram_tax' , '>'  , 0)   
                ->first();  

        $salesTaxO = ExitOldTaxDetails::join('exit_olds_tax', 'exit_old_tax_details.bill_id', '=', 'exit_olds_tax.id')
                ->select(ExitOldTaxDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_olds_tax.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_olds_tax.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_olds_tax.net_money' ,'>' , 0)
                ->where('exit_old_tax_details.gram_tax' , '>'  , 0)   
                ->first();

        $salesTaxOReturn = ExitOldTaxDetails::join('exit_olds_tax', 'exit_old_tax_details.bill_id', '=', 'exit_olds_tax.id')
                ->select(ExitOldTaxDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_olds_tax.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_olds_tax.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_olds_tax.net_money' ,'<' , 0) 
                ->where('exit_old_tax_details.gram_tax' , '>'  , 0)  
                ->first();
        //end tax    
        //
        $salesC = SaleCollectibleDetails::join('sale_collectibles', 'sale_collectibles_details.bill_id', '=', 'sale_collectibles.id')
                ->select(SaleCollectibleDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                ->where('sale_collectibles.date' , '>=' , Carbon::parse($request -> StartDate) )
                ->where('sale_collectibles.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('sale_collectibles.net_money' ,'>' , 0)
                ->where('sale_collectibles_details.gram_tax' , '>'  , 0)  
                ->first();

        $salesCReturn = SaleCollectibleDetails::join('sale_collectibles', 'sale_collectibles_details.bill_id', '=', 'sale_collectibles.id')
                ->select(SaleCollectibleDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('sale_collectibles.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('sale_collectibles.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('sale_collectibles.net_money' ,'<' , 0)
                ->where('sale_collectibles_details.gram_tax' , '>'  , 0)   
                ->first();  

        //

        $salesWTaxZero = ExitWorkDetails::join('exit_works', 'exit_work_details.bill_id', '=', 'exit_works.id')
                ->select(ExitWorkDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_works.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_works.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_works.net_money' , '>'  , 0)   
                ->where('exit_work_details.gram_tax' , '='  , 0)  
                ->first();

        $salesWReturnTaxZero = ExitWorkDetails::join('exit_works', 'exit_work_details.bill_id', '=', 'exit_works.id')
                ->select(ExitWorkDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_works.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_works.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_works.net_money' , '<'  , 0)  
                ->where('exit_work_details.gram_tax' , '='  , 0)   
                ->first();  
                
        $salesOTaxZero = ExitOldDetails::join('exit_olds', 'exit_old_details.bill_id', '=', 'exit_olds.id')
                ->select(ExitOldDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_olds.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_olds.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_olds.net_money' , '>'  , 0)   
                ->where('exit_old_details.gram_tax' , '='  , 0)  
                ->first();
        
        $salesOReturnTaxZero = ExitOldDetails::join('exit_olds', 'exit_old_details.bill_id', '=', 'exit_olds.id')
                ->select(ExitOldDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_olds.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_olds.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_olds.net_money' , '<'  , 0)   
                ->where('exit_old_details.gram_tax' , '='  , 0)  
                ->first(); 

        //tax
        $salesTTaxZero = ExitWorkTaxDetails::join('exit_works_tax', 'exit_work_tax_details.bill_id', '=', 'exit_works_tax.id')
                ->select(ExitWorkTaxDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_works_tax.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_works_tax.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_works_tax.net_money' , '>'  , 0)   
                ->where('exit_work_tax_details.gram_tax' , '='  , 0)  
                ->first();

        $salesTReturnTaxZero = ExitWorkTaxDetails::join('exit_works_tax', 'exit_work_tax_details.bill_id', '=', 'exit_works_tax.id')
                ->select(ExitWorkTaxDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_works_tax.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_works_tax.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_works_tax.net_money' , '<'  , 0)  
                ->where('exit_work_tax_details.gram_tax' , '='  , 0)   
                ->first();  
                
        $salesTOTaxZero = ExitOldTaxDetails::join('exit_olds_tax', 'exit_old_tax_details.bill_id', '=', 'exit_olds_tax.id')
                ->select(ExitOldTaxDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_olds_tax.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_olds_tax.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_olds_tax.net_money' , '>'  , 0)   
                ->where('exit_old_tax_details.gram_tax' , '='  , 0)  
                ->first();

        $salesTOReturnTaxZero = ExitOldTaxDetails::join('exit_olds_tax', 'exit_old_tax_details.bill_id', '=', 'exit_olds_tax.id')
                ->select(ExitOldTaxDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('exit_olds_tax.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('exit_olds_tax.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('exit_olds_tax.net_money' , '<'  , 0)   
                ->where('exit_old_tax_details.gram_tax' , '='  , 0)  
                ->first(); 
        
       
        $salesCTaxZero = SaleCollectibleDetails::join('sale_collectibles', 'sale_collectibles_details.bill_id', '=', 'sale_collectibles.id')
                ->select(SaleCollectibleDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('sale_collectibles.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('sale_collectibles.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('sale_collectibles.net_money' , '>'  , 0)   
                ->where('sale_collectibles_details.gram_tax' , '='  , 0)  
                ->first();

        $salesCReturnTaxZero = SaleCollectibleDetails::join('sale_collectibles', 'sale_collectibles_details.bill_id', '=', 'sale_collectibles.id')
                ->select(SaleCollectibleDetails::raw('sum(weight * gram_price) as money,sum(gram_tax) as tax'))
                -> where('sale_collectibles.date' , '>=' , Carbon::parse($request -> StartDate) )
                -> where('sale_collectibles.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('sale_collectibles.net_money' , '<'  , 0)  
                ->where('sale_collectibles_details.gram_tax' , '='  , 0)   
                ->first();  
        
        //purchaseW
        
        $purchaseW = DB::table('enter_work_details')
                ->join('enter_works' , 'enter_work_details.bill_id' , '=' , 'enter_works.id')
                ->join('karats' , 'enter_work_details.karat_id' , '=' , 'karats.id')
                ->select(EnterWorkDetails::raw('sum(made_money + made_value) money,sum(enter_work_details.tax) tax'))
                ->where('enter_work_details.tax' , '>' , 0) 
                ->where('enter_works.net_money' , '>' , 0) 
                ->where('enter_works.date' , '>=' , Carbon::parse($request -> StartDate) )
                ->where('enter_works.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->first(); 
        
        $purchaseWReturn = DB::table('enter_work_details')
                ->join('enter_works' , 'enter_work_details.bill_id' , '=' , 'enter_works.id')
                ->join('karats' , 'enter_work_details.karat_id' , '=' , 'karats.id')
                ->select(EnterWorkDetails::raw('sum(made_money + made_value) money,sum(enter_work_details.tax) tax'))
                ->where('enter_work_details.tax' , '<' , 0) 
                ->where('enter_works.net_money' , '<' , 0) 
                ->where('enter_works.date' , '>=' , Carbon::parse($request -> StartDate) )
                ->where('enter_works.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->first(); 
 
        $purchaseWTaxZero =  DB::table('enter_work_details')
                ->join('enter_works' , 'enter_work_details.bill_id' , '=' , 'enter_works.id')
                ->join('karats' , 'enter_work_details.karat_id' , '=' , 'karats.id')
                ->select(EnterWorkDetails::raw('sum(made_money) money')) 
                ->where('enter_works.date' , '>=' , Carbon::parse($request -> StartDate) )
                ->where('enter_works.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('enter_works.net_money' , '>' , 0) 
                ->where('karats.stamp_value' , '='  , 0)    
                ->first();  


        $purchaseWTaxZeroReturn =  DB::table('enter_work_details')
                ->join('enter_works' , 'enter_work_details.bill_id' , '=' , 'enter_works.id')
                ->join('karats' , 'enter_work_details.karat_id' , '=' , 'karats.id')
                ->select(EnterWorkDetails::raw('sum(made_money) money')) 
                ->where('enter_works.date' , '>=' , Carbon::parse($request -> StartDate) )
                ->where('enter_works.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('enter_works.net_money' , '<' , 0) 
                ->where('karats.stamp_value' , '='  , 0)    
                ->first();  

        $purchaseO = DB::table('enter_old_details')
                ->join('enter_olds' , 'enter_old_details.bill_id' , '=' , 'enter_olds.id')
                ->join('karats' , 'enter_old_details.karat_id' , '=' , 'karats.id')
                ->select(EnterOldDetails::raw('sum(made_money) money,sum(made_money *0.15) tax')) 
                ->where('enter_old_details.tax' , '>' , 0)
                ->where('enter_olds.net_money' , '>' , 0) 
                ->where('enter_olds.date' , '>=' , Carbon::parse($request -> StartDate) )
                ->where('enter_olds.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                //->where('karats.stamp_value' , '<>'  , 0)    
                ->first(); 
                
        $purchaseOTaxZero =  DB::table('enter_old_details')
                ->join('enter_olds' , 'enter_old_details.bill_id' , '=' , 'enter_olds.id')
                ->join('karats' , 'enter_old_details.karat_id' , '=' , 'karats.id')
                ->select(EnterOldDetails::raw('sum(made_money) money')) 
                ->where('enter_old_details.tax' , 0)
                ->where('enter_olds.date' , '>=' , Carbon::parse($request -> StartDate) )
                ->where('enter_olds.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                //->where('karats.stamp_value' , '='  , 0)    
                ->first();                     
                
                
        $purchaseC = DB::table('purchase_collectible_details')
                ->join('purchases_collectibles' , 'purchase_collectible_details.bill_id' , '=' , 'purchases_collectibles.id')
                ->join('items_collectibles' , 'purchase_collectible_details.item_id' , '=' , 'items_collectibles.id')
                ->select(PurchaseCollectibleDetails::raw('sum(made_money) money,sum(made_money *0.15) tax')) 
                ->where('purchases_collectibles.date' , '>=' , Carbon::parse($request -> StartDate) )
                ->where('purchases_collectibles.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('items_collectibles.tax' , '<>'  , 0)    
                ->first(); 
 
        $purchaseCTaxZero =  DB::table('purchase_collectible_details')
                ->join('purchases_collectibles' , 'purchase_collectible_details.bill_id' , '=' , 'purchases_collectibles.id')
                ->join('items_collectibles' , 'purchase_collectible_details.item_id' , '=' , 'items_collectibles.id')
                ->select(PurchaseCollectibleDetails::raw('sum(made_money) money')) 
                ->where('purchases_collectibles.date' , '>=' , Carbon::parse($request -> StartDate) )
                ->where('purchases_collectibles.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay()) 
                ->where('items_collectibles.tax' , '='  , 0)    
                ->first();                      
        //
                
        return view('admin.Report.tax_declaration_report_result' , compact('company' , 'period' , 'period_ar'  
            ,'salesW' , 'salesO' , 'salesWReturn' , 'salesOReturn' , 'salesWTaxZero', 'salesWReturnTaxZero', 'salesOTaxZero', 'salesOReturnTaxZero'
            ,'salesT','salesTReturn','salesTaxO','salesTaxOReturn','salesC','salesCReturn','salesTTaxZero','salesTReturnTaxZero'
            ,'salesTOTaxZero','salesTOReturnTaxZero','salesCTaxZero','salesCReturnTaxZero'
            ,'purchaseC','purchaseCTaxZero','purchaseW' ,'purchaseWTaxZero','purchaseO','purchaseOTaxZero'
            ,'purchaseWReturn','purchaseWTaxZeroReturn'));
      
    }


    public function inventory_report($id){

        $inventory_sum = Item::join('inventory_details', 'items.id', '=', 'inventory_details.item_id')
                ->selectRaw('items.karat_id,sum(items.weight) sum_weight_new,sum(inventory_details.weight) sum_weight_old')
                ->where('inventory_details.inventory_id' ,$id)  
                //->where('items.state' , 1)  
                ->groupBy('karat_id')
                ->get(); 

        $inventory_items = Item::join('inventory_details', 'items.id', '=', 'inventory_details.item_id')
                ->selectRaw('items.id, items.code, items.name_ar, items.karat_id, items.weight as new_weight, inventory_details.weight as old_weight,items.state') 
                ->where('inventory_details.inventory_id' ,$id)  
                //->where('items.state' , 1)   
                ->get();    

        $inventory = Inventory::FindOrFail($id);        
        $company = CompanyInfo::all() -> first();
        return view('admin.Report.item_inventory_report_result' , compact('company','inventory_sum' , 'inventory_items','inventory'));
            
    }

    
    public function salesReturnReport(){

        $branches = Branch::where('status',1)->get();
        $users = User::with('branch')->where('status',1)->get();

        return view('admin.Report.sales_return_report', compact('branches','users'));
    }

    public function salesReturnReportSearch(Request $request){

        $data = DB::table('exit_work_details')
            -> join('exit_works' , 'exit_work_details.bill_id' , '=' , 'exit_works.id')
            ->join('items' , 'exit_work_details.item_id' , '=' , 'items.id')
            ->join('karats' , 'exit_work_details.karat_id' , '=' , 'karats.id')
            ->select('exit_works.branch_id','exit_works.bill_number' , 'exit_works.date' 
                , 'exit_works.id' ,  'exit_works.client_id as client_id','exit_works.total21_gold'
                ,'exit_works.discount', 'items.name_ar as item_name_ar', 'items.code'
                ,'karats.name_ar as karat_name_ar' , 'exit_work_details.weight' 
                , 'exit_work_details.gram_price' ,'exit_work_details.gram_manufacture' 
                , 'exit_work_details.gram_tax','exit_work_details.net_money' 
                , 'exit_work_details.karat_id'
                ,'exit_works.user_id')
            -> where('exit_works.net_money' ,'<' , 0)
            -> orderBy('exit_works.id');  

        $data2 = DB::table('exit_old_details')
            -> join('exit_olds' , 'exit_old_details.bill_id' , '=' , 'exit_olds.id')
            ->join('karats' , 'exit_old_details.karat_id' , '=' , 'karats.id')
            ->select('exit_olds.branch_id','exit_olds.bill_number' , 'exit_olds.date' 
                , 'exit_olds.discount' ,'exit_olds.id' , 'exit_olds.supplier_id as client_id','exit_olds.total21_gold'
                ,'karats.name_ar as karat_name_ar' , 'exit_old_details.weight' 
                , 'exit_old_details.gram_price' ,'exit_old_details.gram_manufacture' 
                , 'exit_old_details.gram_tax','exit_old_details.net_money' 
                , 'exit_old_details.karat_id'
                ,'exit_olds.user_id')
            -> where('exit_olds.net_money' ,'<' , 0)
            -> orderBy('exit_olds.id');
        
        $data3 = DB::table('exit_work_tax_details')
            -> join('exit_works_tax' , 'exit_work_tax_details.bill_id' , '=' , 'exit_works_tax.id')
            ->join('items' , 'exit_work_tax_details.item_id' , '=' , 'items.id')
            ->join('karats' , 'exit_work_tax_details.karat_id' , '=' , 'karats.id')
            ->select('exit_works_tax.branch_id','exit_works_tax.bill_number' , 'exit_works_tax.date' 
                , 'exit_works_tax.id', 'exit_works_tax.client_id as client_id','exit_works_tax.total21_gold'
                ,'exit_works_tax.discount', 'items.name_ar as item_name_ar' ,'items.code' 
                ,'karats.name_ar as karat_name_ar', 'exit_work_tax_details.weight' 
                , 'exit_work_tax_details.gram_price' ,'exit_work_tax_details.gram_manufacture'
                , 'exit_work_tax_details.gram_tax','exit_work_tax_details.net_money' 
                , 'exit_work_tax_details.karat_id'
                ,'exit_works_tax.user_id')
            -> where('exit_works_tax.net_money' ,'<' , 0)
            -> orderBy('exit_works_tax.id');            

        $data4 = DB::table('exit_old_tax_details')
            ->join('exit_olds_tax' , 'exit_old_tax_details.bill_id' , '=' , 'exit_olds_tax.id')
            ->join('karats' , 'exit_old_tax_details.karat_id' , '=' , 'karats.id')
            ->select('exit_olds_tax.branch_id','exit_olds_tax.bill_number' , 'exit_olds_tax.date'
                , 'exit_olds_tax.discount' ,'exit_olds_tax.id', 'exit_olds_tax.supplier_id as client_id','exit_olds_tax.total21_gold'
                ,'karats.name_ar as karat_name_ar' , 'exit_old_tax_details.weight' 
                , 'exit_old_tax_details.gram_price' ,'exit_old_tax_details.gram_manufacture' 
                , 'exit_old_tax_details.gram_tax','exit_old_tax_details.net_money' 
                , 'exit_old_tax_details.karat_id'
                ,'exit_olds_tax.user_id') 
            -> where('exit_olds_tax.net_money' ,'<' , 0)
            -> orderBy('exit_olds_tax.id');
            
    
        if($request -> branch_id > 0) $data = $data -> where('exit_works.branch_id' ,$request -> branch_id);
        if($request -> has('isStartDate')) $data = $data -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))  $data = $data -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> user_id > 0)  $data = $data -> where('exit_works.user_id' ,$request -> user_id);

        if($request -> branch_id > 0) $data2 = $data2 -> where('exit_olds.branch_id' ,$request -> branch_id);
        if($request -> has('isStartDate')) $data2 = $data2 -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $data2 = $data2 -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> user_id > 0)  $data2 = $data2 -> where('exit_olds.user_id' ,$request -> user_id);

        if($request -> branch_id > 0) $data3 = $data3 -> where('exit_works_tax.branch_id' ,$request -> branch_id);
        if($request -> has('isStartDate')) $data3 = $data3 -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $data3 = $data3 -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> user_id > 0)  $data3 = $data3 -> where('exit_works_tax.user_id' ,$request -> user_id);

        if($request -> branch_id > 0) $data4 = $data4 -> where('exit_olds_tax.branch_id' ,$request -> branch_id);
        if($request -> has('isStartDate')) $data4 = $data4 -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))  $data4 = $data4 -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> user_id > 0)  $data4 = $data4 -> where('exit_olds_tax.user_id' ,$request -> user_id);

        $data = $data->get();
        $data2 = $data2->get();
        $data3 = $data3->get();
        $data4 = $data4->get(); 

        foreach ($data as $w){
            $billSales = ExitWork::where('returned_bill_id' ,$w -> id) -> first();
            $w -> salesNo = $billSales -> bill_number ?? 0;
            
            $client = Company::find($w -> client_id);
            $w -> client =   $client -> name  ?? ''; 
            $w -> type = 1 ;
        } 

        foreach ($data2 as $o){
            $billSales = ExitOld::where('returned_bill_id' ,$o -> id) -> first();
            $o -> salesNo = $billSales -> bill_number ?? 0;
           
            $client = Company::find($o -> client_id);
            $o -> client =   $client -> name ?? '';  
            $o -> type = 0 ;
            $o -> item_name_ar  = '--';
            $o -> item_name_en  = '--';
        }

        foreach ($data3 as $wTax){
            $billSales = ExitWorkTax::where('returned_bill_id' ,$wTax -> id) -> first();
            $wTax -> salesNo = $billSales -> bill_number ?? 0;

            $client = Company::find($wTax -> client_id);
            $wTax -> client =   $client -> name ?? '';   
            $wTax -> type = 1 ;
        }
    
        foreach ($data4 as $oTax){
            $billSales = ExitOldTax::where('returned_bill_id' ,$oTax -> id) -> first();
            $oTax -> salesNo = $billSales -> bill_number ?? 0;

            $client = Company::find($oTax -> client_id);
            $oTax -> client =   $client -> name ?? '';
            $oTax -> type = 0 ;
            $oTax -> item_name_ar  = '--';
            $oTax -> item_name_en  = '--';
        }

        $all1 = $data-> merge($data2);
        $all2 = $data3-> merge($data4); 

        $bills   = $all1 -> merge($all2);

        $grouped_ar = $bills  -> groupBy('karat_name_ar');
        $grouped_en = $bills  -> groupBy('karat_name_en');

        $startDate = Carbon::now()->addYears(-5);
        $endDate = Carbon::now() -> addDays(1);

        $period = 'Period : ';
        $period_ar = 'الفترة :';

        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        if($request -> user_id > 0){
            $user = User::find($request -> user_id);
            $user =  $user->name;
        }else{
            $user =  'الكل';
        } 

        return view('admin.Report.sales_report_return_result' , compact('bills', 'branch', 'grouped_ar','grouped_en' , 'period' , 'period_ar' ,'company','user' ))  ;
    } 

    public function purchaseReturnReport(){

        $pricings = Pricing::all();
        $branches = Branch::where('status',1)->get();

        return view('admin.Report.purchase_return_report', compact('branches'));
    }

    public function purchaseReturnReportSearch(Request $request){

        if($request->type == 3 or $request->type == 4){

            $work = DB::table('enter_work_details')
                ->join('enter_works' , 'enter_work_details.bill_id' , '=' , 'enter_works.id')
                ->join('karats' , 'enter_work_details.karat_id' , '=' , 'karats.id')
                ->select('enter_works.bill_number', 'enter_works.id' ,'enter_works.branch_id'
                    ,'enter_works.date' , 'enter_works.supplier_id as supplier_id'
                    ,'karats.name_ar as karat_name_ar' , 'karats.name_en as karat_name_en' 
                    ,'enter_work_details.weight' , 'enter_work_details.made_money','enter_work_details.tax'
                    ,'enter_work_details.net_weight' , 'enter_work_details.net_money' 
                    ,'enter_work_details.karat_id' , 'enter_work_details.weight21')        
                -> where('enter_works.net_money' ,'<' , 0)
                -> orderBy('enter_works.id');
        } 

        if($request->type == 2){

            $data2 = DB::table('enter_old_details')
                ->join('enter_olds' , 'enter_old_details.bill_id' , '=' , 'enter_olds.id')
                ->join('karats' , 'enter_old_details.karat_id' , '=' , 'karats.id')
                ->select('enter_olds.bill_number' , 'enter_olds.id','enter_olds.branch_id'
                    , 'enter_olds.date', 'enter_olds.supplier_id as supplier_id'
                    ,'karats.name_ar as karat_name_ar' , 'karats.name_en as karat_name_en' 
                    , 'enter_old_details.weight' , 'enter_old_details.made_money', 'enter_old_details.tax'
                    ,'enter_old_details.net_weight' , 'enter_old_details.net_money' 
                    , 'enter_old_details.karat_id' , 'enter_old_details.weight21'
                    ,'enter_olds.bill_type')
                ->where('enter_olds.bill_type',2)
                -> where('enter_olds.net_money' ,'<' , 0)
                -> orderBy('enter_olds.id');

        }else if($request->type == 0){

            $data2 = DB::table('enter_old_details')
                -> join('enter_olds' , 'enter_old_details.bill_id' , '=' , 'enter_olds.id')
                ->join('karats' , 'enter_old_details.karat_id' , '=' , 'karats.id')
                ->select('enter_olds.bill_number'  , 'enter_olds.id','enter_olds.branch_id'
                    , 'enter_olds.date' , 'enter_olds.supplier_id as supplier_id'
                    ,'karats.name_ar as karat_name_ar' , 'karats.name_en as karat_name_en' 
                    , 'enter_old_details.weight' , 'enter_old_details.made_money', 'enter_old_details.tax'
                    ,'enter_old_details.net_weight' , 'enter_old_details.net_money' 
                    , 'enter_old_details.karat_id' , 'enter_old_details.weight21'
                    ,'enter_olds.bill_type')
                ->where('enter_olds.bill_type',0)
                -> where('enter_olds.net_money' ,'<' , 0)
                -> orderBy('enter_olds.id');

        }else{
            $data2 = DB::table('enter_old_details')
                -> join('enter_olds' , 'enter_old_details.bill_id' , '=' , 'enter_olds.id')
                ->join('karats' , 'enter_old_details.karat_id' , '=' , 'karats.id')
                ->select('enter_olds.bill_number'  , 'enter_olds.id','enter_olds.branch_id'
                    ,'enter_olds.date' , 'enter_olds.supplier_id as supplier_id'
                    ,'karats.name_ar as karat_name_ar' , 'karats.name_en as karat_name_en' 
                    ,'enter_old_details.weight' , 'enter_old_details.made_money', 'enter_old_details.tax'
                    ,'enter_old_details.net_weight' , 'enter_old_details.net_money' 
                    ,'enter_old_details.karat_id' , 'enter_old_details.weight21'
                    ,'enter_olds.bill_type')
                -> where('enter_olds.net_money' ,'<' , 0)
                -> orderBy('enter_olds.id');  
        } 
        
        $bills = array(); 

        if($request->type == 3 or $request->type == 4){

            if($request -> branch_id > 0) $data = $work -> where('enter_works.branch_id' , $request -> branch_id);        
            if($request -> has('isStartDate')) $data = $work -> where('enter_works.date' , '>=' , Carbon::parse($request -> StartDate) );
            if($request -> has('isEndDate'))   $data = $work -> where('enter_works.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
           
            foreach ($data-> get() as $bill){
                $supplier = Company::find($bill -> supplier_id);
                if($supplier)
                    $bill -> supplier =   $supplier -> name ;
                else
                    $bill -> supplier = '';
                $bill -> type = 1 ;
                array_push($bills , $bill);
            }
        }

        if(($request->type == 0  or $request->type == 2) or $request->type == 4){ 

            if($request -> branch_id > 0) $data2 = $data2 -> where('enter_olds.branch_id' , $request -> branch_id);     
            if($request -> has('isStartDate')) $data2 = $data2 -> where('enter_olds.date' , '>=' , Carbon::parse($request -> StartDate) );
            if($request -> has('isEndDate'))   $data2 = $data2 -> where('enter_olds.date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());

            foreach ($data2 -> get() as $bill){

                $supplier = Company::find($bill -> supplier_id);

                if($supplier)
                    $bill -> supplier = $supplier -> name ;
                else
                    $bill -> supplier = ''; 

                $bill -> type = $bill ->bill_type;  
                array_push($bills , $bill);
            } 
        } 

        if(isset($data) and isset($data2)){
            $all = $data -> get() -> merge($data2 -> get());
        }else if(isset($data) and !isset($data2)){
            $all = $data -> get();
        }else if(!isset($data) and isset($data2)){
            $all = $data2 -> get();
        }  

        $grouped_ar = $all   -> groupBy('karat_name_ar');
        $grouped_en = $all   -> groupBy('karat_name_en');

        $period = 'Period : ';
        $period_ar = 'الفترة  :';
        if($request -> has('isStartDate')){
            $startDate = $request->StartDate; 
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ; 
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ; 
            $period .= ' -- '  . $endDate -> format('d-m-Y') ;
            $period_ar .= ' -- '  . $endDate -> format('d-m-Y');
        } else {
            $period .= ' -- '  . 'Today' ;
            $period_ar .= ' -- '  . 'حتى اليوم' ;
        }

        $company = CompanyInfo::all() -> first();
        $branch = Branch::find($request -> branch_id);

        if($request->type == 4){
            $type = 'عام'; 
        }else if($request->type == 3){
            $type = 'ذهب مشغول';
        }else if($request->type == 2){
            $type = 'ذهب صافي';
        }else if($request->type == 0){
            $type = 'ذهب كسر';
        }

        return view('admin.Report.purchase_report_return_result' , compact('bills', 'branch','grouped_ar','grouped_en', 'period' , 'period_ar' , 'company','type'))  ;

    }

} 
