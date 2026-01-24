<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\CatchGoldRecipts;
use App\Models\CatchGoldReciptsDetails;
use App\Models\AccountsTree;
use App\Models\AccountSetting;
use App\Models\Karat;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CatchGoldReciptController extends WarehouseController
{
    public function index(Request $request)
    {
        $bills = CatchGoldRecipts::join('accounts_trees as from_account' , 'from_account.id' , '=' , 'catch_gold_recipts.from_account')
            -> join('accounts_trees as to_account' , 'to_account.id' , '=' , 'catch_gold_recipts.to_account') 
            -> select('catch_gold_recipts.*'  , 'from_account.name as from_account_name' , 'to_account.name as to_account_name')
            -> orderBy('id', 'DESC')
            -> get(); 
    
        if (!empty(Auth::user()->branch_id)) {
            $bills = $bills  -> where('branch_id', Auth::user()->branch_id);
        }  

 
        foreach ($bills as $bill){ 

            $accountkarats = CatchGoldReciptsDetails::join('karats','catch_gold_recipts_details.karat_id','=','karats.id')
                ->select('catch_gold_recipts_details.id','karats.name_ar', 
                    DB::raw('SUM(CASE WHEN karats.label="K24" THEN catch_gold_recipts_details.weight END) K24'),
                    DB::raw('SUM(CASE WHEN karats.label="K21" THEN catch_gold_recipts_details.weight END) K21'),
                    DB::raw('SUM(CASE WHEN karats.label="K18" THEN catch_gold_recipts_details.weight END) K18') )
                ->groupBy('catch_gold_recipts_details.id','karats.name_ar' )
                ->where('catch_gold_recipts_details.bill_id',$bill->id) 
                ->get();


           if($accountkarats){

               foreach($accountkarats as $accountkarat){
                   
                    if( $accountkarat->K24 > 0 ){
                       $bill->credit_K24 = $accountkarat->K24;
                    }
                   
                    if( $accountkarat->K21 > 0 ){ 
                        $bill->credit_K21 = $accountkarat->K21;
                    }

                    if( $accountkarat->K18 > 0 ){
                       $bill->credit_K18 = $accountkarat->K18;
                    } 

               }
           } 
        }
    
        $branches = Branch::where('status',1)->get();
        $accounts = AccountsTree::where('parent_code',2101)->get();
        
        return view('admin.GoldRecipts.enter.index' , compact( 'bills','accounts','branches' ));
    }

    public function create()
    {
        $accounts = AccountsTree::whereIn('parent_code',[2101,1107])->get();
        $branches = Branch::where('status',1)->get();
        $karats = Karat::all();

        return view('admin.GoldRecipts.Enter.create', compact('accounts','branches','karats'));

    }

    public function store(Request $request)
    {
        $validated = $request->validate([ 
            'docNumber' => 'required|unique:catch_gold_recipts',
            'date' => 'required',
            'account_id' => 'required',
            'branch_id' => 'required',
            'amount' => 'required',
            'gold21' => 'required'
        ]);

        $items = array();

        if(count($request -> karat_id)){

            $total21_gold = 0 ; 

            for($i = 0 ; $i < count($request -> karat_id) ; $i++ ){

                $item =[
                    'bill_id' => 0,
                    'karat_id' => $request -> karat_id[$i], 
                    'weight' => $request -> weight[$i],
                    'weight21'=> $request -> weight21[$i],
                    'type'=> $request -> type[$i],
                ];

                $total21_gold += $request -> weight21[$i]; 
                $items[] = $item ;

            }

           $supplier_id = Company::where('account_id',$request -> account_id)->first()->id;
           $settings = AccountSetting::where('branch_id',$request->branch_id)->first();

           if($request ->payment_type == 0){
               $from_account = $settings->safe_account; 
           }else{
               $from_account = $settings->bank_account;
           }
           
           $id =  CatchGoldRecipts::create([
                'branch_id' => $request -> branch_id,
                'docNumber' => $request -> docNumber, 
                'date' => $request -> date,
                'payment_type' => $request -> payment_type,
                'from_account' => $from_account,
                'to_account' => $request -> account_id,
                'supplier_id' => $supplier_id,
                'amount' =>  $request ->amount ,
                'gold21' => $total21_gold, 
                'sale_id' => 0,
                'notes'=> $request -> notes ?? '',
                'user_id' => Auth::user() -> id

            ]) -> id;

            foreach ($items as $product){
                $product['bill_id'] = $id;
                CatchGoldReciptsDetails::create($product) ; 
                $this -> syncQnt($product['type'], $product['karat_id'], 0, $id, $product['weight'], 1, $request -> branch_id);
            }

            $this -> syncVendorAccount($supplier_id , $request ->amount, $total21_gold, -1,
                $id, $request -> docNumber, 'catch_gold_recipts', $request -> branch_id); 

           $auto_accounting =  env("AUTO_ACCOUNTING", 1);

           if($auto_accounting == 1){
               $systemController = new SystemController(); 
               $systemController -> CatchGoldReciptAccounting($id);
           }

           return redirect()->route('admin.CatchGoldRecipts.index')->with('success' ,  __('main.created'));

        } else {
           return redirect()->route('admin.CatchGoldRecipts.index')->with('error' ,  __('main.nodetails'));
        }
    }

    public function get_gold_recipts_no($branch_id){ 
        $bills = CatchGoldRecipts::where('branch_id', $branch_id)->count();
        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        }

        $i = 0;
        do { 
            $i++;
            $prefix = "ETSG-".$branch_id."-";
            $no = json_encode($prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT)) ;
        } while (CatchGoldRecipts::where("docNumber","=",$prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT))->exists());
     
        echo $no ;
        exit;
    }
}
