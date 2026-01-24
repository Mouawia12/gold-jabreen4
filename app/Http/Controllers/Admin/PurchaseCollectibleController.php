<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyInfo; 
use App\Models\PurchasesCollectible;
use App\Models\PurchaseCollectibleDetails;
use App\Models\Journal;
use App\Models\JournalDetails;
use App\Models\Karat;
use App\Models\Pricing;
use App\Models\ItemsCollectible;
use App\Models\TaxSettings;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseCollectibleController extends WarehouseItemController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('purchases_collectibles')
            -> join('companies' , 'companies.id' , '=' , 'purchases_collectibles.supplier_id')
            -> join('branches' , 'branches.id' , '=' , 'purchases_collectibles.branch_id')
            -> select('purchases_collectibles.*' , 'companies.name as vendor_name','branches.branch_name')
            -> orderBy('id', 'DESC')
            -> get(); 

        if (!empty(Auth::user()->branch_id)) {
            $data = $data->where('branch_id', Auth::user()->branch_id); 
        }  
        return view('admin.Collectibles.Enter.index' , compact('data'));
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
        $Items = ItemsCollectible::where('state' , -1) -> get();
        $setting = TaxSettings::all() -> first(); 
        $branches = Branch::where('status',1)->get();

        if (!empty(Auth::user()->branch_id)) {
            $Items = $Items->where('branch_id', Auth::user()->branch_id); 
        }  

        return view('admin.Collectibles.Enter.Create' , compact( 'Items','vendors', 'karats', 'setting', 'branches'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required',
            'bill_number' => 'required|unique:purchases_collectibles',
            'supplier_id' => 'required',
            'branch_id' => 'required',
        ]);

        $items = array();
        if(count($request -> Item_id)){
            //store header
            $total_money = 0 ;
            $total_weight = 0; 
            for($i = 0 ; $i < count($request -> Item_id) ; $i++ ){
                    $item =[
                        'bill_id' => 0,
                        'karat_id' => $request -> karat_id[$i],
                        'item_id' => $request -> Item_id[$i],
                        'weight' => $request -> weight[$i], 
                        'made_money'=> $request -> made_money[$i],
                        'net_weight' => $request -> weight [$i],
                        'net_money' => $request -> made_money[$i],
                    ];
                    $total_money += $request -> made_money[$i];
                    $total_weight += $request -> weight[$i];
                    $items[] = $item ;
            }

           $id =  PurchasesCollectible::create([
                'branch_id' => $request -> branch_id,
                'bill_number' => $request -> bill_number,
                'date' => $request -> date,
                'supplier_id' => $request -> supplier_id,
                'total_money' => $total_money, 
                'paid_money' => 0,
                'remain_money' => $request -> net_after_discount,
                'paid_gold' => 0,
                'remain_gold' => 0,
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
                PurchaseCollectibleDetails::create($product); 
                $this -> syncQnt(1 , $product['item_id'], $id , $product['weight'] , 1 , $request -> branch_id);
                $this -> makeItemsCollectibleOkPurchase($product['item_id'] );
            }

            $this -> syncVendorAccount($request -> supplier_id , $request -> net_after_discount ,$total_weight , -1 ,
            $id , $request -> bill_number , 'Purchase Collectible Entry Bill', $request -> branch_id); 

           $auto_accounting =  env("AUTO_ACCOUNTING", 1);
           if($auto_accounting == 1){
               $systemController = new SystemController(); 
               $systemController -> PurchaseCollectibleAccounting($id);
           }

           return redirect()->route('Purchase.Entry.All')->with('success' ,  __('main.created'));

        } else {
           return redirect()->route('Purchase.Entry.All')->with('error' ,  __('main.nodetails'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EnterWork  $enterWork
     * @return \Illuminate\Http\Response
     */
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

    
        return view('admin.Collectibles.Enter.Preview' , compact('bill' , 'details' , 'vendors' ));
    }

    public function print($id){
        $bill = DB::table('purchases_collectibles')
            -> join('companies' , 'companies.id' , '=' , 'purchases_collectibles.supplier_id')
            -> select('purchases_collectibles.*' , 'companies.name as vendor_name' , 'companies.vat_no as vendor_vat_no')
            -> where('purchases_collectibles.id' , '=' , $id)
            -> get() -> first();


        $karats = Karat::all();
        $details   =  DB::table('purchase_collectible_details')
            -> join('items_collectibles' , 'items_collectibles.id' , '=' , 'purchase_collectible_details.item_id')
            -> select('purchase_collectible_details.*' , 'items_collectibles.name_ar as item_ar' , 'items_collectibles.name_en as item_en' )
            -> where('purchase_collectible_details.bill_id' , '=' , $id)
            -> get();

        $grouped_ar = $details -> groupBy('item_ar');
        $suppliers =  Company::get(); 
        $company = CompanyInfo::first() ;
        $pos = \Illuminate\Support\Env::get('PROGRAMME_TYPE');
        if($pos == 0) {//A4
            return view('admin.Collectibles.Enter.print' , compact('bill' , 'details' , 'karats' , 'grouped_ar','company'));
        } else { //A5
            return view('admin.Collectibles.Enter.printA5 ' , compact('bill' , 'details' , 'karats' , 'grouped_ar','company'));
        }



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EnterWork  $enterWork
     * @return \Illuminate\Http\Response
     */
    public function edit(EnterWork $enterWork)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EnterWork  $enterWork
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EnterWork $enterWork)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EnterWork  $enterWork
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bill = PurchasesCollectible::find($id);
        if($bill){
            $details = PurchaseCollectibleDetails::where('bill_id' , '=' , $id) -> get();
            $this -> deleteQnt($id);
            $this -> deleteVendorMove($bill -> supplier_id , $id , $bill -> total_money , $bill -> total21_gold , 'Work Entry Bill');
            $this -> deleteAccountingData($id , $bill -> bill_number , 'شراء ذهب مشغول');


            foreach ($details as $detail){
                $detail -> delete();
            }
            $bill -> delete();
            return redirect()->route('PurchaseEntryAll')->with('success' ,  __('main.deleted'));
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

    public function get_work_purchase_no($branch_id){ 
        $bills = PurchasesCollectible::where('branch_id', $branch_id)->count();

        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        }

        $i = 0;
        do { 
            $i++;
            $prefix = "WEC-".$branch_id."-";
            $no = json_encode($prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT)) ;
        } while (PurchasesCollectible::where("bill_number","=",$prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT))->exists());
     
        echo $no ;
        exit;
    } 

}
