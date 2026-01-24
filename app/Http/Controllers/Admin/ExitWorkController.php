<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyInfo;
use App\Models\EnterMoney;
use App\Models\ExitOld;
use App\Models\ExitWork;
use App\Models\ExitWorkDetails;
use App\Models\Karat;
use App\Models\Pricing;
use App\Models\NotificationWahtsapp;
use http\Env;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Barryvdh\DomPDF\Facade\Pdf;     
use ArPHP\I18N\Arabic;

class ExitWorkController extends WarehouseController
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
     * @param  \App\Models\ExitWork  $exitWork
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    
    public function Qrcode($id){
        $bill = DB::table('exit_works')
            -> join('companies' , 'companies.id' , '=' , 'exit_works.client_id')
            -> select('exit_works.*' , 'companies.name as vendor_name' , 'companies.vat_no as vendor_vat_no')
            -> where('exit_works.id' , '=' , $id)
            -> first();

      //  return $bill ;
        return view('admin.Work.Exit.Qrcode' , compact('bill' ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExitWork  $exitWork
     * @return \Illuminate\Http\Response
     */
    public function edit(ExitWork $exitWork)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExitWork  $exitWork
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExitWork $exitWork)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExitWork  $exitWork
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExitWork $exitWork)
    {
        //
    }

    public function get_work_exit_no($branch_id){ 
        
        $bills = ExitWork::where('branch_id', $branch_id) 
            ->where('returned_bill_id' , '>' , 0)
            ->count(); 

        if($bills > 0){
            $id = $bills ;
        } else{
            $id = 0 ;
        }

        $prefix = "WEX-".$branch_id."-";
        $no = json_encode($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
        echo $no ;
        exit;
    }

}
