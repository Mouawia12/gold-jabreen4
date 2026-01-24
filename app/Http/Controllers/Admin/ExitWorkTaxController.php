<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyInfo;
use App\Models\EnterMoney;
use App\Models\ExitOldTax;
use App\Models\ExitWorkTax; 
use App\Models\ExitWorkTaxDetails;
use App\Models\SaleCollectible;
use App\Models\Karat;
use App\Models\Pricing;
use App\Models\Branch;
use http\Env;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 

class ExitWorkTaxController extends WarehouseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
    } 
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExitWorkTax  $exitWork
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        return $this -> print($id);   
    }
    


    public function Qrcode($id){ 
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExitWorkTax  $exitWork
     * @return \Illuminate\Http\Response
     */
    public function edit(ExitWorkTax $exitWork)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExitWorkTax  $exitWork
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExitWorkTax $exitWork)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExitWorkTax  $exitWork
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExitWorkTax $exitWork)
    {
        //
    }

    public function get_work_exit_no(){ 
        $bills = ExitWorkTax::where('branch_id', $branch_id) 
            -> where('returned_bill_id' , '>' , 0)
            ->count(); 

        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        }
       
        $prefix = "WETAX-".$branch_id."-";
        $no = json_encode($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
        echo $no ;
        exit;
    }

}
