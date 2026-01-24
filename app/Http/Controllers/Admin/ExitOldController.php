<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Alkoumi\LaravelArabicTafqeet\Tafqeet;
use App\Models\Company;
use App\Models\EnterMoney;
use App\Models\EnterWork;
use App\Models\ExitOld;
use App\Models\ExitOldDetails;
use App\Models\Karat;
use App\Models\Pricing;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExitOldController extends WarehouseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('exit_olds')
            -> join('companies' , 'companies.id' , '=' , 'exit_olds.supplier_id')
            -> select('exit_olds.*' , 'companies.name as vendor_name')
            -> orderBy('id', 'DESC')
            -> get();

        if (!empty(Auth::user()->branch_id)) {
            $data = $data->where('branch_id', Auth::user()->branch_id); 
        }  

        return view('admin.Old.Exit.index' , compact('data' ));
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
        return view('admin.Old.Exit.Create' , compact('vendors' , 'karats' ));
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
            'bill_number' => 'required|unique:exit_olds',
            'supplier_id' => 'required'
        ]);
        $items = array();
        if(count($request -> karat_id)){
            //store header
            $total21_gold = 0 ;
            for($i = 0 ; $i < count($request -> karat_id) ; $i++ ){
                $item =[
                    'bill_id' => 0,
                    'karat_id' => $request -> karat_id[$i],
                    'weight' => $request -> weight[$i],
                    'weight21'=> $request -> weight21[$i],
                    'made_money'=> 0,
                    'net_weight' => $request -> weight [$i],
                    'net_money' => 0,
                ];
                $total21_gold += $request -> weight21[$i];
                $items[] = $item ;
            }

            $val = $total21_gold ;

            $id =  ExitOld::create([
                'bill_number' => $request -> bill_number,
                'date' => $request -> date,
                'supplier_id' => $request -> supplier_id,
                'total_money' => 0,
                'total21_gold' => $total21_gold,
                'paid_money' => 0,
                'remain_money' => $total21_gold,
                'paid_gold' => 0,
                'remain_gold' => 0,
                'discount' => 0,
                'net_money' => 0,
                'bill_client_name' => $request -> bill_client_name,
                'pos' => 0,
                'notes'=> $request -> notes ?? '',
                'user_id' => Auth::user() -> id

            ]) -> id;
            $auto_accounting =  env("AUTO_ACCOUNTING", 1);
            if($auto_accounting == 1){
                $systemController = new SystemController();
                $systemController -> ExitOldAccounting($id);
            }

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

            foreach ($items as $product){
                $product['bill_id'] = $id;
                ExitOldDetails::create($product) ;

                $this -> syncQnt(0 , $product['karat_id'], $id , $product['weight'] , -1 );
            }
            $this -> syncVendorAccount($request -> supplier_id , 0 ,$total21_gold , 1 ,
                $id , $request -> bill_number , 'Old Exit Bill');

            return redirect()->route('oldExitAll')->with('success' ,  __('main.created'));
        } else {
            return redirect()->route('oldExitAll')->with('error' ,  __('main.nodetails'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExitOld  $exitOld
     * @return \Illuminate\Http\Response
     */
 
    public function print($id){

        if (!empty(Auth::user()->branch_id)) {
            $bill = DB::table('exit_olds')
                -> join('companies' , 'companies.id' , '=' , 'exit_olds.supplier_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_olds.branch_id')
                -> select('exit_olds.*' , 'companies.name as vendor_name' , 'branches.branch_name' , 'companies.vat_no as vendor_vat_no')
                -> where('exit_olds.id' , '=' , $id)  
                -> where('exit_olds.branch_id' ,Auth::user()->branch_id)
                -> first();

            if(!$bill)
                return ;
         }else{
            $bill = DB::table('exit_olds')
                -> join('companies' , 'companies.id' , '=' , 'exit_olds.supplier_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_olds.branch_id')
                -> select('exit_olds.*' , 'companies.name as vendor_name' , 'branches.branch_name' , 'companies.vat_no as vendor_vat_no')
                -> where('exit_olds.id' , '=' , $id) 
                -> first();
         } 

        $details   =  DB::table('exit_old_details')
            -> join('karats' , 'karats.id' , '=' , 'exit_old_details.karat_id')
            -> select('exit_old_details.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' , 'karats.transform_factor')
            -> where('exit_old_details.bill_id' , '=' , $bill->id)
            -> get();


        $vendors = Company::where('group_id' , '=' , 4) -> get();
        $grouped_ar = $details   -> groupBy('karat_ar');
        $karats = Karat::all();
        $pos = \Illuminate\Support\Env::get('PROGRAMME_TYPE');
        $payments = EnterMoney::where('based_on_bill_number' , '=' , $bill -> bill_number) -> get();
        //$amar = Tafqeet::inArabic($bill -> net_money,'sar');
        $amar = '';
        $company = CompanyInfo::first();

        if($pos == 0) {//A4
            return view('admin.Old.Exit.print' , compact('bill' , 'details' , 'vendors' , 'karats' , 'grouped_ar' , 'payments' , 'amar','company'));
        } else { //A5
            return view('admin.Old.Exit.printA5' , compact('bill' , 'details' , 'vendors' , 'karats' , 'grouped_ar' , 'payments' , 'amar','company'));
        } 
    }


    public function print_tax($id){
        if (!empty(Auth::user()->branch_id)) {
            $bill = DB::table('exit_olds_tax')
                -> join('companies' , 'companies.id' , '=' , 'exit_olds_tax.supplier_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_olds_tax.branch_id')
                -> select('exit_olds_tax.*' , 'companies.name as vendor_name', 'branches.branch_name', 'companies.vat_no as vendor_vat_no')
                -> where('exit_olds_tax.id' , '=' , $id)
                -> where('exit_olds_tax.branch_id' ,Auth::user()->branch_id)
                -> first();

            if(!$bill)
                return ;
        }else{
            $bill = DB::table('exit_olds_tax')
                -> join('companies' , 'companies.id' , '=' , 'exit_olds_tax.supplier_id')
                -> join('branches' , 'branches.id' , '=' , 'exit_olds_tax.branch_id')
                -> select('exit_olds_tax.*' , 'companies.name as vendor_name', 'branches.branch_name', 'companies.vat_no as vendor_vat_no')
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
        //$amar = Tafqeet::inArabic($bill -> net_money,'sar');
        $amar = '';
        $company = CompanyInfo::first();

        if($pos == 0) {//A4
            return view('admin.OldTax.Exit.print' , compact('bill' , 'details' , 'vendors' , 'karats' , 'grouped_ar' , 'payments' , 'amar','company'));
        } else { //A5
            return view('admin.OldTax.Exit.printA5' , compact('bill' , 'details' , 'vendors' , 'karats' , 'grouped_ar' , 'payments' , 'amar','company'));
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExitOld  $exitOld
     * @return \Illuminate\Http\Response
     */
    public function edit(ExitOld $exitOld)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExitOld  $exitOld
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExitOld $exitOld)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExitOld  $exitOld
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bill = ExitOld::find($id);
        if($bill){
            $details = ExitOldDetails::where('bill_id' , '=' , $id) -> get();
            $this -> deleteQnt($id);
            $this -> deleteVendorMove($bill -> supplier_id , $id , 0 , $bill -> total21_gold , 'Old Exit Bill');
            foreach ($details as $detail){
                $detail -> delete();
            }
            $bill -> delete();
            return redirect()->route('oldEntryAll')->with('success' ,  __('main.deleted'));
        }
    }

    public function get_old_exit_no($branch_id){
        $bills = ExitOld::where('branch_id', $branch_id)->count();

        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        }
            
        $prefix = "OEX-".$branch_id."-";
        $no = json_encode($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
        echo $no ;
        exit;
    }
}
