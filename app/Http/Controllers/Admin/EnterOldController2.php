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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnterOldController2 extends WarehouseController
{
    public function insert_old_work_privet()
    {
        $systemController = new SystemController(); 
        $enter_olds = EnterOld::get();
        foreach ($enter_olds as $enter_old){
            $this-> store($enter_old);
        }

    }

 
    public function store($request)
    {

        $Enter_old_Details = EnterOldDetails::where('bill_id',$request->id)->get();

        if($request -> bill_type == 0)
        {
            $is_type = 'Old Entry Bill';
        }else{
            $is_type = 'Pure Entry Bill';
        }

        foreach ($Enter_old_Details as $Enter_old_Detail){ 
             $this -> syncQnt($request -> bill_type , $Enter_old_Detail->karat_id ,0, $request->id, $Enter_old_Detail->weight , 1 );
        }

        $this -> syncVendorAccount($request -> supplier_id , $request -> net_money ,$request -> total21_gold , -1 ,
         $request->id, $request -> bill_number , $is_type); 
    
        $request['bill_date2'] = Carbon::now();
        $request['customer_id2'] = $request -> supplier_id;
        $request['bill_number2'] = $request -> bill_number;   
        $request['bill_type2'] = $request -> bill_type;   

        if(Company::find($request -> supplier_id)->vat_no == 0){
            $this -> MakePaymentOut($request , $request -> net_money, 0, $request->id);
        } 
         
        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        if($auto_accounting == 1){
            $systemController = new SystemController(); 
            $systemController -> EnterOldAccounting($request->id);
        }
 
 
    }
 
    
    public function MakePaymentOut($request , $money , $type , $based_on ){

        if (ExitMoney::where('amount',$money)->where('based_on_bill_number',$request->bill_number)->exists()) {
            $Exit_Money =  ExitMoney::where('amount',$money)->where('based_on_bill_number',$request->bill_number)->first();
   
            $auto_accounting =  env("AUTO_ACCOUNTING", 1);
            if($auto_accounting == 1){
                $systemController = new SystemController();
                $systemController -> ExitMoneyAccounting( $Exit_Money->id);  
            }
    
            if($request -> customer_id2 > 0){
                $moneyout = $money ;
                $gold = 0;
                $this->syncVendorAccount($request->customer_id2, $moneyout, $gold, 1,
                $Exit_Money->id,$request->bill_number2, 'Exit Money Bill');
            }
 
        }
 
    }

    
    public function getpaymentOutNo(){
        $bills = ExitMoney::orderBy('id', 'ASC')->get();
        if(count($bills) > 0){
            $id = $bills[count($bills) -1] -> id ;
        } else
            $id = 0 ;
        $prefix = "MEx-";
        $no = ($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
        return $no ;
    }


}
