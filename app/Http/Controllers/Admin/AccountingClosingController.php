<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountMovement;
use App\Models\AccountingClosing;
use App\Models\AccountSetting;
use App\Models\AccountsTree;
use App\Models\Journal;
use App\Models\JournalDetails;
use App\Models\Warehouse;
use App\Models\WarehouseProducts;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Database\Factories\JournalFactory;
use Faker\Core\Number;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;

class AccountingClosingController extends Controller
{

    public function ClosingYear(){ 
        $this->get_closing();
        $this->get_general_expenses();
        $this->get_final();
    }


    public function get_closing(){

        $accounts =  AccountingClosing::where('status',1)->get();
      
        foreach($accounts as $account){ 

            if( AccountsTree::where('parent_id',$account->account_id)->doesntExist()) { 

                $account_balance = $this->account_movement_report_search($account->account_id);
                $balance = 0;
                if($account_balance){
                    $isaccount = AccountsTree::find($account->account_id);
                    if($isaccount->side == 1){
                        $balance = $account_balance->debit - $account_balance->credit;
                    }else{
                        $balance = $account_balance->credit - $account_balance->debit;
                    }
                    
                }else{
                    $balance = 0;
                }
        
                $this->ClosingYearAccounting($account->account_from,$account->account_to,$balance);

            }else{

                $sub_accounts = AccountsTree::where('parent_id',$account->account_id)->get();
              
                foreach($sub_accounts as $sub_account){
                
                    $account_balance = $this->account_movement_report_search($sub_account->id);
                    $balance = 0;
                    if($account_balance){ 
                        if($sub_account->side == 1){
                            $balance = $account_balance->debit - $account_balance->credit;
                        }else{
                            $balance = $account_balance->credit - $account_balance->debit;
                        }
                        
                    }else{
                        $balance = 0;
                    }
        
                   if($account->account_from == $sub_account->id ) { 
                        $this->ClosingYearAccounting($sub_account->id,$account->account_to,$balance);
                   }else{
                        $this->ClosingYearAccounting($account->account_from,$sub_account->id,$balance);
                   }
              
                }
                   
            }
  
        }

    }

    public function get_general_expenses(){
        
        $accounts = AccountsTree::where('parent_id',77)->get();
        $settings = AccountSetting::first(); 

        foreach($accounts as $account){
             
             if(AccountsTree::where('parent_id',$account->id)->exists()) {
                $sub_accounts = AccountsTree::where('parent_id',$account->id)->get();
                foreach($sub_accounts as $sub_account){
                    $account_balance = $this->account_movement_report_search($sub_account->id);
                    $balance = 0;
                    if($account_balance){ 
                        if($sub_account->side == 1){
                            $balance = $account_balance->debit - $account_balance->credit;
                        }else{
                            $balance = $account_balance->credit - $account_balance->debit;
                        }
                        
                    }else{
                        $balance = 0;
                    }
        
                   $this->ClosingYearAccounting($settings->profit_account,$sub_account->id,$balance);
               }

            }else{
                $account_balance = $this->account_movement_report_search($account->id);
                $balance = 0;
                if($account_balance){ 
                    if($account->side == 1){
                        $balance = $account_balance->debit - $account_balance->credit;
                    }else{
                        $balance = $account_balance->credit - $account_balance->debit;
                    }
                    
                }else{
                    $balance = 0;
                }
    
               $this->ClosingYearAccounting($settings->profit_account,$account->id,$balance);

            }
        }

    }

    public function get_final(){  

        $settings = AccountSetting::first(); 
        $account_balance = $this->account_movement_report_search($settings->profit_account);
        $balance = 0;

        if($account_balance){
            $isaccount = AccountsTree::find($settings->profit_account);
            if($isaccount->side == 1){
                $balance = $account_balance->debit - $account_balance->credit;
            }else{
                $balance = $account_balance->credit - $account_balance->debit;
            }
            
        }else{
            $balance = 0;
        }

        //$this->ClosingYearAccounting(52,51,$balance);
        $this->ClosingYearAccounting($settings->profit_account+1,0,$balance);

    }

    public function account_movement_report_search($id){

        $year = date('Y'); 
        $startDate =  Carbon::parse($year.'-01-01') -> format('d-m-Y');
        $endDate =Carbon::parse($year.'-12-31') -> format('d-m-Y');
        $endDate =  Carbon::parse($endDate) -> addDay()  ;

        $account_balance = DB::table('accounts_trees')
                        ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                        ->select('accounts_trees.code','accounts_trees.name as account_name','accounts_trees.side',
                            DB::raw('SUM(account_movements.credit) credit'),
                            DB::raw('SUM(account_movements.debit) debit'))
                        ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name','accounts_trees.side')
                        ->where('account_movements.date','>=',$startDate)
                        ->where('account_movements.date','<=',$endDate)
                        ->where('accounts_trees.id' , '=' , $id) 
                        ->first();

        return $account_balance;
                
    }
    

    public function getJournal($data)
    {

        $data = Journal::query()
            ->where('basedon_no', $data['basedon_no'])
            ->where('basedon_id', $data['basedon_id'])
            ->where('baseon_text', $data['baseon_text'])
            ->first();

        if ($data) {
            return $data->id;
        }
        return 0;
    }

    private function getOldDetails($id)
    {
        return JournalDetails::query()->where('journal_id', $id)->get();
    }

    public function insertJournal($header, $details, $manual = 0)
    {

        if ($id = $this->getJournal($header)) {

            $journal = Journal::find($id);
            $journal->update($header);

            $oldDetails = $this->getOldDetails($id);
            ////log_message('error',$id);
            foreach ($oldDetails as $oldDetail) {
                $this->updateAccountBalance($oldDetail->account_id, -1 * $oldDetail->credit, -1 * $oldDetail->debit, $header['date'], $id , $oldDetail -> notes);
            }

            DB::table('journal_details')
                ->where('journal_id', $id)
                ->delete();

            DB::table('account_movements')
                ->where('journal_id', $id)
                ->delete();


            foreach ($details as $detail) {
                $detail['journal_id'] = $id;

                DB::table('journal_details')
                    ->insert($detail);

                $this->updateAccountBalance($detail['account_id'], $detail['credit'], $detail['debit'], $header['date'], $id , $detail['notes']);
            }

            return true;
        } else {
            $journal_id = DB::table('journals')
                ->insertGetId($header);
            if ($journal_id) {

                foreach ($details as $detail) {
                    $detail['journal_id'] = $journal_id;

                    DB::table('journal_details')
                        ->insert($detail);
                    $this->updateAccountBalance($detail['account_id'], $detail['credit'], $detail['debit'], $header['date'], $journal_id , $detail['notes']);
                }

                if ($manual == 1) {
                    $journal = Journal::find($journal_id);
                    $journal->update(['baseon_text' => 'سند قيد يدوي رقم ' . $journal_id]);
                }
            }
            return true;
        }

        return false;

    }

    private function updateAccountBalance($id, $credit, $debit, $date, $journalId , $notes)
    {
        $account = $this->getAccountById($id);

        if (!$account) {
            return;
        }

        if ($credit <> 0 || $debit <> 0) {
            $accountMData = [
                'journal_id' => $journalId,
                'account_id' => $id,
                'credit' => $credit,
                'debit' => $debit,
                'date' => $date,
                'notes' =>  $notes
            ];

            DB::table('account_movements')->insert($accountMData);
        }

        if ($account->parent_id > 0) {
            $this->updateAccountBalance($account->parent_id, $credit, $debit, $date, $journalId , $notes);
        }

    }

    private function getAccountById($id)
    {
        if (!$id) {
            $id = 0;
        }
        return AccountsTree::find($id);

    }

    public function ClosingYearAccounting($from,$to,$amount){
        $Y = date("Y");
        //$date = date("m-d");
        //if ($date === '12-31') {

            $settings = AccountSetting::all()->first();
            if (!$settings)
                return;

            $basedon_no = $from .'-'.$to.'-'.$Y;
            //journal header
            $headerData = [
                'date' => $Y.'-12-31 23:50:00',
                'basedon_no' => $basedon_no,
                'basedon_id' => 0,
                'baseon_text' => 'الاقفال السنوي',
                'total_credit' => 0,
                'total_debit' => 0,
                'notes' => ''
            ];

            $detailsData = [];

            if($from>0){
                $from_account = AccountsTree::find($from)->id;
                $detailsData[] = [
                    'account_id' => $from_account,
                    'debit' => $amount,
                    'credit' => 0,
                    'ledger_id' => 0,
                    'notes' => ''
                ];
            } 
            
            if($to>0){
                $to_account = AccountsTree::find($to)->id;
                $detailsData[] = [
                    'account_id' => $to_account, 
                    'debit' =>  0,
                    'credit' => $amount,
                    'ledger_id' => 0,
                    'notes' => ''
                ];

            }
            
            $this->insertJournal($headerData, $detailsData);

        //}
    }

}
