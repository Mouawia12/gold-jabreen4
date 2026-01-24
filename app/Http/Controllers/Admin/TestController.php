<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyMovement;
use App\Models\Category;
use App\Models\Item;
use App\Models\CompanyInfo;
use App\Models\EnterWork;
use App\Models\EnterWorkDetails;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 
use Barryvdh\DomPDF\Facade\Pdf;

class TestController extends Controller
{

    public function generatePdf()
    {
        try {
            $pdf = Pdf::loadView('pdf'); // Your Blade view
            return $pdf->stream('document.pdf'); // Or use `->download('document.pdf')`
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function TestPdf()
    {
 
        return view('pdf');
    }

    public function test(){  
        return date("m-d");
    }
  
    public function delet_bill_old($id){ 

        if (EnterOld::where('bill_number', $id)->exists()) { 

            $bills = EnterOld::where('bill_number', $id)->first();
            $journal_id = Journal::where('basedon_no', $bills->bill_number)->first()->id; 
            EnterOldDetails::where('bill_id', $bills->id)->delete();
            JournalDetails::where('journal_id', $journal_id)->delete();
            Journal::where('basedon_no', $bills->bill_number)->delete();
            AccountMovement::where('journal_id', $journal_id)->delete();
            Warehouse::where('bill_id', $bills->id)->where('type',$bills->bill_type)->delete(); 
            CompanyMovement::where('bill_number', $bills->bill_number)->delete();
            $company = Company::where('id', $bills->supplier_id)->first();
            $bills -> delete();
              
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

        } 
        return redirect()->route('oldEntryAll')->with('success' ,  __('main.deleted')); 
    }

    public function delet_bill_work($id){
        $bills = EnterWork::where('bill_number', $id)->first();
        if(isset($bills) and $bills->id >0 ){

            $journal_id = Journal::where('basedon_no', $bills->bill_number)->first()->id;
            
            EnterWork::where('id', $bills->id)->delete();
            EnterWorkDetails::where('bill_id', $bills->id)->delete();
            JournalDetails::where('journal_id', $journal_id)->delete();
            Journal::where('basedon_no', $bills->bill_number)->delete();
            AccountMovement::where('journal_id', $journal_id)->delete();
            Warehouse::where('bill_id', $bills->id)->where('type',$bills->bill_type)->where('enter_weight','>',0)->delete(); 
            CompanyMovement::where('bill_number', $bills->bill_number)->delete();
            $company = Company::where('id', $bills->supplier_id)->first();
              
            $company->update([
                'deposit_amount' => $company->deposit_amount - $bills->net_money, 
                'deposit_gold' => $company->deposit_gold - $bills->total21_gold,
            
            ]);

            if (ExitMoney::where('based_on', $bills->id)->where('supplier_id',$bills->supplier_id)->exists()) {

                $mony = ExitMoney::where('based_on', $bills->id)->where('supplier_id',$bills->supplier_id)->first();
                
                if($company->credit_amount > 0){
                    $company->update([ 
                        'credit_amount' => $company->credit_amount - $mony->amount , 
                    ]); 
                }
                
                if($company->credit_gold > 0){
                    $company->update([ 
                        'credit_gold' =>  $company->credit_gold - ($mony->amount / $mony->price_gram),
                    ]); 
                }

                $journal_id2 = Journal::where('basedon_no', $mony->doc_number)->first()->id;
                JournalDetails::where('journal_id', $journal_id2)->delete();
                Journal::where('basedon_no', $mony->doc_number)->delete();
                AccountMovement::where('journal_id', $journal_id2)->delete();
                CompanyMovement::where('bill_number', $mony->doc_number)->delete();
                 
                ExitMoney::where('based_on', $bills->id)->where('supplier_id',$bills->supplier_id)->delete();
            }

        }  
    }

    public function delet_clear_bill_work($id){
        
        if (ExitMoney::where('doc_number', $id)->exists()) {

            $mony = ExitMoney::where('doc_number', $id)->first();
            $company = Company::where('id', $mony->supplier_id)->first();
            
            if($company->credit_amount > 0){
                $company->update([ 
                    'credit_amount' => $company->credit_amount - $mony->amount , 
                ]); 
            }
            
            if($company->credit_gold > 0){
                $company->update([ 
                    'credit_gold' =>  $company->credit_gold - ($mony->amount / $mony->price_gram),
                ]); 
            }
            CompanyMovement::where('bill_number', $mony->doc_number)->delete();
            ExitMoney::where('doc_number', $id)->delete();
            $journal_id2 = Journal::where('basedon_no', $mony->doc_number)->first()->id;
            JournalDetails::where('journal_id', $journal_id2)->delete();
            Journal::where('basedon_no', $mony->doc_number)->delete();
            AccountMovement::where('journal_id', $journal_id2)->delete();
 
            echo '<br>ok delete : '.$id;
        }
    }

    
    public function update_bill_work($id){
        $bills = EnterWork::where('bill_number', $id)->first();
        $company = Company::where('id', $bills->supplier_id)->first();
        if(isset($bills) and $bills->id >0 ){

            $journal_id = Journal::where('basedon_no', $bills->bill_number)->first()->id;
        
            JournalDetails::where('journal_id', $journal_id)->where('account_id',104)->update(['account_id' => $company->account_id]); 
            AccountMovement::where('journal_id', $journal_id)->where('account_id',104)->update(['account_id' => $company->account_id]);  
 
            if (ExitMoney::where('supplier_id',$bills->supplier_id)->where('based_on',$bills->id)->exists()) {
                $bill_exit_mony = ExitMoney::where('supplier_id',$bills->supplier_id)->where('based_on',$bills->id)->first();
                $journal_id = Journal::where('basedon_no', $bill_exit_mony->doc_number)->first()->id;
                JournalDetails::where('journal_id', $journal_id)->where('account_id',104)->update(['account_id' => $company->account_id]); 
                AccountMovement::where('journal_id', $journal_id)->where('account_id',104)->update(['account_id' => $company->account_id]);  
            }

        }  
    }


    public function update_bill_exit_mony_Company(){
        $monys = ExitMoney::all();
        foreach ($monys as $mony){
            if (CompanyMovement::where('company_id',$mony->supplier_id)->where('bill_number',$mony->doc_number)->where('debit_money',0)->where('credit_money',0)->exists()) {
                
                
                $Company_Movement = CompanyMovement::where('company_id',$mony->supplier_id)->where('bill_number',$mony->doc_number)->where('debit_money',0)->where('credit_money',0)->first();
                $Company_Movement->debit_money = $mony->amount ;
                $Company_Movement-> update();

                $vebdor = Company::find($mony->supplier_id);
                $vebdor -> credit_amount += $mony->amount ; 
                $vebdor -> update();

            }
       
        }
    }
    
    public function fixEnterJournal(){

        foreach (EnterWork::get() as $enter){ 
            
            Journal::where('baseon_text','شراء ذهب مشغول')
                ->where('basedon_id',$enter->id)
                ->update([
                    'basedon_no' => $enter->bill_number
                ]);   
        }
    }

    public function fixOldJournal(){ 

        foreach (EnterOld::get() as $old){ 

            Journal::where('basedon_id',$old->id)
                ->where(function($query) {
                    $query->where('baseon_text','شراء ذهب كسر')
                          ->orwhere('baseon_text','شراء ذهب صافي');
                })
                ->update([
                    'basedon_no' => $old->bill_number
                ]);   
        }

    } 

}
