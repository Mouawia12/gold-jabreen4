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
use App\Models\Journal;
use App\Models\JournalDetails;
use App\Models\Karat;
use App\Models\Pricing;
use App\Models\ExitOld;
use App\Models\ExitOldDetails; 
use App\Models\TaxSettings;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EnterWorkController2 extends WarehouseController
{
   
    public function insert_enter_work_privet()
    {
        $systemController = new SystemController(); 
        $enter_works = EnterWork::get();
        foreach ($enter_works as $enter_work){
            /*
            $this -> syncVendorAccount($enter_work -> supplier_id , $enter_work -> net_money ,$enter_work ->total21_gold , -1 ,
            $enter_work->id , $enter_work -> bill_number , 'Work Entry Bill'); 

            $systemController -> EnterWorkAccounting($enter_work->id);
            echo '<br>'.$enter_work->id;
            */

            if($enter_work -> bill_type == 1 ){
                $this -> store1($enter_work);
            } else if($enter_work -> bill_type  == 2){
                $this-> store3($enter_work);
            }else {
                $this-> store2($enter_work);
            }
        }

    }

    
    public function store1($request)
    {
        $Enter_Work_Details = EnterWorkDetails::where('bill_id',$request->id)->get();
     
        foreach ($Enter_Work_Details as $Enter_Work_Detail){ 
             $this -> syncQnt(1 , $Enter_Work_Detail->karat_id ,0, $request->id, $Enter_Work_Detail->weight , 1 );
        }

        $this -> syncVendorAccount($request -> supplier_id , $request -> net_money ,$request -> total21_gold , -1 ,
         $request->id, $request -> bill_number , 'Work Entry Bill'); 

        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        if($auto_accounting == 1){
            $systemController = new SystemController(); 
            $systemController -> EnterWorkAccounting($request->id);
        }
  
    }

    public function store2($request)
    {
        $Enter_Work_Details = EnterWorkDetails::where('bill_id',$request->id)->get();

        foreach ($Enter_Work_Details as $Enter_Work_Detail){ 
            $this -> syncQnt(1 , $Enter_Work_Detail->karat_id ,0, $request->id, $Enter_Work_Detail->weight , 1 );
        }
        
        $this -> syncVendorAccount($request -> supplier_id , $request -> net_money ,$request -> total21_gold , -1 ,
         $request->id, $request -> bill_number , 'Work Entry Bill'); 

        $auto_accounting =  env("AUTO_ACCOUNTING", 1);

        if($auto_accounting == 1){
            $systemController = new SystemController(); 
            $systemController -> EnterWorkAccounting($request->id);
        }

        if(ExitOld::where('bill_client_name',$request -> bill_number)->exists()) {
            $Exit_Old = ExitOld::where('bill_client_name',$request -> bill_number)->first();
            $Exit_Old_Details = ExitOldDetails::where('bill_id',$Exit_Old->id)->get();
            foreach ($Exit_Old_Details as $Exit_Old_Detail){ 
                $this -> syncQnt(0 , $Exit_Old_Detail->karat_id ,0, $Exit_Old->id, $Exit_Old_Detail->weight , -1 );
            }

            $this -> syncVendorAccount($Exit_Old -> supplier_id , 0 ,$Exit_Old ->total21_gold , 1 ,
            $Exit_Old ->id , $Exit_Old -> bill_number , 'Old Exit Bill');
        }

    }
 
    
    public function store3($request)
    {
        $Enter_Work_Details = EnterWorkDetails::where('bill_id',$request->id)->get();
    
        foreach ($Enter_Work_Details as $Enter_Work_Detail){ 
            $this -> syncQnt(1 , $Enter_Work_Detail->karat_id ,0, $request->id, $Enter_Work_Detail->weight , 1 );
        }
        
        $this -> syncVendorAccount($request -> supplier_id , $request -> net_money ,$request -> total21_gold , -1 ,
         $request->id, $request -> bill_number , 'Work Entry Bill'); 

        $auto_accounting =  env("AUTO_ACCOUNTING", 1);

        if($auto_accounting == 1){
            $systemController = new SystemController(); 
            $systemController -> EnterWorkAccounting($request->id);
        }

        if(ExitOld::where('bill_client_name',$request -> bill_number)->exists()) {
            $Exit_Old = ExitOld::where('bill_client_name',$request -> bill_number)->first();
            $Exit_Old_Details = ExitOldDetails::where('bill_id',$Exit_Old->id)->get();
            foreach ($Exit_Old_Details as $Exit_Old_Detail){ 
                $this -> syncQnt(2 ,  $Exit_Old_Detail->karat_id ,0, $Exit_Old->id, $Exit_Old_Detail->weight , -1 );
            }

            $this -> syncVendorAccount($Exit_Old -> supplier_id , 0 ,$Exit_Old ->total21_gold , 1 ,
            $Exit_Old ->id , $Exit_Old -> bill_number , 'Old Exit Bill');
        }
 
    
    }
 
        
 
}
