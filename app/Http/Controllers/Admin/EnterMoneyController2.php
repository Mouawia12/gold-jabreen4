<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnterMoney;
use App\Models\ExitWork;
use App\Models\Pricing;
use App\Models\Company; 
use App\Models\ExitWorkDetails;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EnterMoneyController2 extends WarehouseController
{
 

    public function insert_enter_Money_privet()
    {
        $Exit_Works = ExitWork::get();
        foreach ($Exit_Works as $Exit_Work){
            if (EnterMoney::where('based_on_bill_number', $Exit_Work->bill_number)->exists()) {
                $Enter_Moneys = EnterMoney::where('based_on_bill_number', $Exit_Work->bill_number)->get();
                foreach ($Enter_Moneys as $Enter_Money){
                    $Exit_Work->paid_money += $Enter_Money->amount;
                    $Exit_Work->remain_money = $Exit_Work->net_money -  $Exit_Work->paid_money;
                    $Exit_Work->save();
                }

            }
        }
    }
    

    public function insert_enter_movment_Money_privet()
    {
        $Enter_Moneys = EnterMoney::get();

        foreach ($Enter_Moneys as $Enter_Money){
            if (Journal::where('basedon_no', $Enter_Money->doc_number)->doesntExist()) {
                $this-> store($Enter_Money);
            }
        }
    }


    public function store($request)
    {
 
 
        $this -> syncVendorAccount($request -> client_id , $request -> amount ,0 , -1 ,
        $request->id , $request -> based_on_bill_number , 'Enter Money Bill');

        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        if($auto_accounting == 1){
            $systemController = new SystemController();
            $systemController -> EnterMoneyAccounting($request->id);
        }
 
        if($request -> based_on > 0){
            $bill = ExitWork::find($request -> based_on);
            if($bill ){
                $bill -> remain_money -= $request -> amount ;
                $bill -> paid_money += $request -> amount ;
                $bill -> update();
            }
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EnterMoney  $enterMoney
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clients = Company::where('group_id' , '=' , 3) -> get();
        $bill = DB::table('enter_money')
            ->join('companies' , 'enter_money.client_id' , '=' , 'companies.id')
            ->join('exit_works' , 'enter_money.based_on' , 'exit_works.id')
            ->select('enter_money.*' , 'companies.name as vendor_name' , 'exit_works.bill_number as invoice_number')
            ->where('enter_money.id' , '=' ,$id )
            -> get() -> first();

     //   return $bill ;

        $html = view('admin.Money.Enter.view' , compact('bill', 'clients')) -> render();
        return $html ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EnterMoney  $enterMoney
     * @return \Illuminate\Http\Response
     */
    public function edit(EnterMoney $enterMoney)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EnterMoney  $enterMoney
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EnterMoney $enterMoney)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EnterMoney  $enterMoney
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bill = EnterMoney::find($id);
        if ($bill) {
            $this->deleteVendorMove($bill->client_id, $id, $bill->amount, 0, 'Enter Money Bill');
            if ($bill->based_on > 0) {
                $exit = ExitWork::find($bill->based_on);
                if ($exit) {
                    $exit->remain_money += $bill->amount;
                    $exit->paid_money -= $bill->amount;
                    $exit->update();
                }
            }
            $bill ->delete();
            return redirect() -> route('money_entry_list') -> with('success' , __('main.deleted'));
        }
    }
    public function getBillNo(){
        $bills = EnterMoney::orderBy('id', 'ASC')->get();
        if(count($bills) > 0){
            $id = $bills[count($bills) -1] -> id ;
        } else
            $id = 0 ;
        $prefix = "ME-";
        $no = ($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
        return $no ;
    }
    public function getClientExitWorks($id){
        $bills = ExitWork::where('client_id' , '=' , $id)->get();
        echo json_encode($bills);
        exit();
    }
}
