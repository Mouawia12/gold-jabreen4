<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\AccountsTree;
use App\Models\Storehouse;
use App\Models\AccountSetting;
use App\Http\Requests\StoreJournalRequest;
use App\Http\Requests\UpdateJournalRequest;
use App\Models\Pricing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyInfo;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
    public function incoming_list(){ 
        return view('admin.Report.incoming_list');
    }

    public function incoming_list_new(){ 
        return view('admin.Report.incoming_list_new');
    }

    public function search_incoming_list(Request $request){
        
        $startDate = Carbon::now()->addYears(-5);
        $endDate = Carbon::now() -> addDays(1);
        $period = 'Period : ';
        $period_ar = 'الفترة  :';

        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ;
            $period_ar .= $startDate ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
            $period .= ' - '  . $endDate ;
            $period_ar .= ' - '  .Carbon::parse($endDate) -> addDay(-1)  -> format('d-m-Y');
        } else {
            $period .= ' - '  . 'Today' ;
            $period_ar .= ' - '  . 'حتي اليوم' ;
        }

        $accounts = DB::table('accounts_trees')
            ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
            ->select('accounts_trees.id as idd','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level',
                DB::raw('SUM(CASE WHEN account_movements.notes = "" THEN account_movements.credit END) credit'),
                DB::raw('SUM(CASE WHEN account_movements.notes = "" THEN account_movements.debit END) debit'),
                DB::raw('(CASE WHEN accounts_trees.parent_id = account_movements.account_id THEN accounts_trees.name END) childs'),
            )
            ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level' , 'account_movements.account_id')
            ->where('accounts_trees.department','=',2) 
            ->where('account_movements.date','>=',$startDate)
            ->where('account_movements.date','<=',$endDate)
            ->get();

        $accounts1 =  $accounts -> where('level' , '=' , 1) ; 

        foreach ($accounts1 as $account){
            $list = $accounts -> where('parent_id' , '=' ,$account -> idd );
            $account -> childs =  $list ? $list  : [] ;

            foreach($account -> childs as $child){
                $list2 = $accounts -> where('parent_id' , '=' ,$child -> idd );
                $child -> childs = $list2 ? $list2 : [];
                
                foreach($child -> childs as $subChild){
                    $list22 = $accounts -> where('parent_id' , '=' ,$subChild -> idd );
                    $subChild -> childs = $list22 ? $list22  : [];
                }
            }
        }

        //return  $accounts1 ;
        $company = CompanyInfo::all() -> first();

        return view('admin.Report.incoming_list_report',compact('accounts1' ,  'period' , 'period_ar' , 'company'));
        
    } 

    public function search_incoming_list_new(Request $request){

        $company = CompanyInfo::all() -> first();
        $pricings = Pricing::all() -> first();
        $account_settings = AccountSetting::get()->first();

        $startDate = Carbon::now()->addYears(-5);
        $endDate = Carbon::now() -> addDays(1);
        $Date1 = Carbon::parse($request->StartDate) -> addDay(-1); 
        $Date2 = Carbon::parse($request->EndDate) -> addDay(2); 

        $period = 'Period : ';
        $period_ar = 'الفترة  : ';

        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate ;
            $period_ar .= Carbon::parse($startDate) -> format('d-m-Y') ;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية' ;
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay()  ;
            $period .= ' - '  . $endDate ;
            $period_ar .= ' - '  .Carbon::parse($endDate) -> addDay(-1)  -> format('d-m-Y');
        } else {
            $period .= ' - '  . 'Today' ;
            $period_ar .= ' - '  . 'حتي اليوم' ;
        }

        $sales = DB::table('accounts_trees')
                    ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                    ->select('accounts_trees.id as idd','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level',
                        DB::raw('SUM(CASE WHEN account_movements.notes = "" THEN account_movements.credit END) credit'),
                        DB::raw('SUM(CASE WHEN account_movements.notes = "" THEN account_movements.debit END) debit'),
                        DB::raw('(CASE WHEN accounts_trees.parent_id = account_movements.account_id THEN accounts_trees.name END) childs'),
                    )
                    ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level' , 'account_movements.account_id')
                    ->where('accounts_trees.department','=',2) 
                    ->where('account_movements.date','>=',$startDate)
                    ->where('account_movements.date','<=',$endDate)
                    ->where('accounts_trees.id', $account_settings->sales_account)
                    ->first();

        $return_sales = DB::table('accounts_trees')
                    ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                    ->select('accounts_trees.id as idd','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level',
                        DB::raw('SUM(CASE WHEN account_movements.notes = "" THEN account_movements.credit END) credit'),
                        DB::raw('SUM(CASE WHEN account_movements.notes = "" THEN account_movements.debit END) debit'),
                        DB::raw('(CASE WHEN accounts_trees.parent_id = account_movements.account_id THEN accounts_trees.name END) childs'),
                    )
                    ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level' , 'account_movements.account_id')
                    ->where('accounts_trees.department','=',2) 
                    ->where('account_movements.date','>=',$startDate)
                    ->where('account_movements.date','<=',$endDate)
                    ->where('accounts_trees.id', $account_settings->return_sales_account)
                    ->first();

        $irad = DB::table('accounts_trees')
                    ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                    ->select('accounts_trees.id as idd','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level',
                        DB::raw('SUM(CASE WHEN account_movements.notes = "" THEN account_movements.credit END) credit'),
                        DB::raw('SUM(CASE WHEN account_movements.notes = "" THEN account_movements.debit END) debit'),
                        DB::raw('(CASE WHEN accounts_trees.parent_id = account_movements.account_id THEN accounts_trees.name END) childs'),
                    )
                    ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level' , 'account_movements.account_id')
                    ->where('accounts_trees.department','=',2) 
                    ->where('account_movements.date','>=',$startDate)
                    ->where('account_movements.date','<=',$endDate)
                    ->where('accounts_trees.parent_code', 4)
                    ->where('accounts_trees.id','<>', 56)
                    ->first();

        $masrof = DB::table('accounts_trees')
                    ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                    ->select('accounts_trees.id as idd','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level',
                        DB::raw('SUM(CASE WHEN account_movements.notes = "" THEN account_movements.credit END) credit'),
                        DB::raw('SUM(CASE WHEN account_movements.notes = "" THEN account_movements.debit END) debit'),
                        DB::raw('(CASE WHEN accounts_trees.parent_id = account_movements.account_id THEN accounts_trees.name END) childs'),
                    )
                    ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level' , 'account_movements.account_id')
                    ->where('accounts_trees.department','=',2) 
                    ->where('account_movements.date','>=',$startDate)
                    ->where('account_movements.date','<=',$endDate)
                    ->where('accounts_trees.parent_code', 5) 
                    ->first();
 
        $period_start_old = DB::table('accounts_trees')
                    ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                    ->select('accounts_trees.id as idd','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level',
                        DB::raw('SUM(account_movements.credit) credit'),
                        DB::raw('SUM(account_movements.debit) debit'),
                        DB::raw('(CASE WHEN accounts_trees.parent_id = account_movements.account_id THEN accounts_trees.name END) childs'),
                    )
                    ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level' , 'account_movements.account_id')
                    //->where('account_movements.date','>=',$Date1)
                    ->where('account_movements.date','<',$startDate)
                    ->where('accounts_trees.code', 11080102) 
                    ->first();


        $period_start_Pure = DB::table('accounts_trees')
                    ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                    ->select('accounts_trees.id as idd','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level',
                        DB::raw('SUM(account_movements.credit) credit'),
                        DB::raw('SUM(account_movements.debit) debit'),
                        DB::raw('(CASE WHEN accounts_trees.parent_id = account_movements.account_id THEN accounts_trees.name END) childs'),
                    )
                    ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level' , 'account_movements.account_id')
                    //->where('account_movements.date','>=',$Date1)
                    ->where('account_movements.date','<',$startDate)
                    ->where('accounts_trees.code', 11080103) 
                    ->first();

 

        $cost_old = DB::table('accounts_trees')
                        ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                        ->select('accounts_trees.id as idd','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level',
                            DB::raw('SUM(account_movements.credit) credit'),
                            DB::raw('SUM(account_movements.debit) debit'),
                            DB::raw('(CASE WHEN accounts_trees.parent_id = account_movements.account_id THEN accounts_trees.name END) childs'),
                        )
                        ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level' , 'account_movements.account_id')
                        ->where('account_movements.date','>=',$startDate)
                        ->where('account_movements.date','<=',$endDate)
                        ->where('accounts_trees.code', 11080102)  
                        //->whereIn('accounts_trees.code', [11080102, 11080103])
                        ->first();

        $cost_pure = DB::table('accounts_trees')
                        ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                        ->select('accounts_trees.id as idd','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level',
                            DB::raw('SUM(account_movements.credit) credit'),
                            DB::raw('SUM(account_movements.debit) debit'),
                            DB::raw('(CASE WHEN accounts_trees.parent_id = account_movements.account_id THEN accounts_trees.name END) childs'),
                        )
                        ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level' , 'account_movements.account_id')
                        ->where('account_movements.date','>=',$startDate)
                        ->where('account_movements.date','<=',$endDate) 
                        ->where('accounts_trees.code',11080103)  
                        //->whereIn('accounts_trees.code', [11080102, 11080103])
                        ->first();

        $purchase = DB::table('accounts_trees')
                        ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                        ->select('accounts_trees.id as idd','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level',
                            DB::raw('SUM(account_movements.credit) credit'),
                            DB::raw('SUM(account_movements.debit) debit'),
                            DB::raw('(CASE WHEN accounts_trees.parent_id = account_movements.account_id THEN accounts_trees.name END) childs'),
                        )
                        ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level' , 'account_movements.account_id')
                        ->where('account_movements.date','>=',$startDate)
                        ->where('account_movements.date','<=',$endDate) 
                        ->where('accounts_trees.id', 68)  
                        ->first(); 

        $cost_sale = DB::table('accounts_trees')
                        ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                        ->select('accounts_trees.id as idd','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level',
                            DB::raw('SUM(account_movements.credit) credit'),
                            DB::raw('SUM(account_movements.debit) debit'),
                            DB::raw('(CASE WHEN accounts_trees.parent_id = account_movements.account_id THEN accounts_trees.name END) childs'),
                        )
                        ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level' , 'account_movements.account_id')
                        //->where('account_movements.date','>=',$Date1)
                        ->where('account_movements.date','<',$startDate) 
                        ->where('accounts_trees.code', 5201)  
                        ->first(); 

        $sale_weight = DB::table('accounts_trees')
                        ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
                        ->select('accounts_trees.id as idd','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level',
                            DB::raw('SUM(account_movements.credit) credit'),
                            DB::raw('SUM(account_movements.debit) debit'),
                            DB::raw('(CASE WHEN accounts_trees.parent_id = account_movements.account_id THEN accounts_trees.name END) childs'),
                        )
                        ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level' , 'account_movements.account_id')
                        ->where('account_movements.date','>=',$startDate)
                        ->where('account_movements.date','<=',$endDate)
                        ->where('accounts_trees.code', 5201)  
                        ->first(); 

        $period_start_old = isset($period_start_old->debit)   ? $period_start_old->debit : 0 ;
        $period_start_Pure = isset($period_start_Pure ->debit)   ? $period_start_Pure ->debit :0 ;
        $period_start = $period_start_old +  $period_start_Pure ;

        $cost_old = isset($cost_old->debit) ? $cost_old->debit :0;
        $cost_pure = isset($cost_pure->debit) ? $cost_pure->debit :0;
        $cost = $cost_old + $cost_pure;

        $sale_weight = isset($sale_weight->debit) ? $sale_weight->debit :0;
        $cost_sale = isset($cost_sale->debit) ? $cost_sale->debit :0;

        $purchase = isset($purchase -> debit) ? $purchase -> debit :0;
        
        return view('admin.Report.incoming_list_report_new',compact('sale_weight','cost_sale','purchase','pricings','sales','return_sales','irad','masrof','period_start','cost' ,  'period' , 'period_ar' , 'company'));
        
    }

    public function balance_sheet(){
        return view('admin.Report.balance_sheet');
    }

    public function search_balance_sheet(Request $request){

        $startDate = Carbon::now()->addYears(-5);
        $endDate = Carbon::now() -> addDays(1);
        $period = 'Period : ';
        $period_ar = 'الفترة  :';

        if($request -> has('isStartDate')){
            $startDate = $request->StartDate;
            $period .= $startDate;
            $period_ar .= $startDate;
        } else {
            $period .= 'Starting Date';
            $period_ar .= 'من البداية';
        }

        if($request -> has('isEndDate')){
            $endDate =  Carbon::parse($request->EndDate) -> addDay();
            $period .= ' - '  . $endDate;
            $period_ar .= ' - '  . $endDate ;
        } else {
            $period .= ' - '  . 'Today';
            $period_ar .= ' - '  . 'حتي اليوم';
        }

        $accounts = DB::table('accounts_trees')
            ->join('account_movements','accounts_trees.id','=','account_movements.account_id')
            ->select('accounts_trees.id as idd','accounts_trees.code','accounts_trees.name',  'accounts_trees.parent_id' , 'accounts_trees.level',
                DB::raw('sum(account_movements.credit) as credit'),
                DB::raw('sum(account_movements.debit) as debit'))
            ->groupBy('accounts_trees.id','accounts_trees.code','accounts_trees.name' , 'accounts_trees.parent_id' , 'accounts_trees.level' )
            ->where('accounts_trees.department',1)
            ->get();

        $accounts1 =  $accounts -> where('level' , '=' ,1); 
 
        foreach ($accounts1 as $account){
            $list = $accounts -> where('parent_id' , '=' ,$account -> idd );
            $account -> childs =  $list ? $list  : [] ;

            foreach($account -> childs as $child){
                $list2 = $accounts -> where('parent_id' , '=' ,$child -> idd );
                $child -> childs = $list2 ? $list2 : [];

                foreach($child -> childs as $subChild){
                    $list22 = $accounts -> where('parent_id' , '=' ,$subChild -> idd );
                    $subChild -> childs = $list22 ? $list22  : [];
                }
            }

        }
   
        $company = CompanyInfo::all() -> first();
      
        return view('admin.Report.balance_sheet_report',compact('accounts1' , 'period' , 'period_ar' , 'company'));
    }


    public function create(){ 
        return view('admin.accounts.manual');
    }

    public function create_basic(){ 
        $faccounts = AccountsTree::whereIn('parent_code',[2101,1107])->get();
        $accounts = AccountsTree::whereIn('parent_code',[2101,1107])->get();  
        return view('admin.accounts.basic', compact('accounts','faccounts'));
    }

    public function store(Request $request){

        $siteController = new SystemController();

        $header =[
            'date' => Carbon::parse($request -> date),
            'basedon_no' => '',
            'basedon_id' => 0,
            'baseon_text' => 'سند قيد يدوي',
            'total_credit' => 0,
            'total_debit' => 0,
            'notes' => $request->notes ? $request->notes : ''
        ];


        $details = [];
        foreach ($request->account_id as $index=>$account_id){
            $accountId = $account_id;
            $credit = $request->credit[$index];
            $debit = $request->debit[$index];
            $ledger = 0;
            //$notes = $request->note[$index] ? $request->note[$index] : '';

            $details[] = [
                'account_id' => $accountId,
                'debit' => $debit,
                'credit' => $credit,
                'ledger_id' => $ledger,
                'notes' => ''
            ];
        }

        $siteController->insertJournal($header,$details,1);
        return redirect()->route('journals' , '0');
    }

    public function store_basic(Request $request){
        
        $siteController = new SystemController();

        $header =[
            'date' => Carbon::parse($request -> date),
            'basedon_no' => '',
            'basedon_id' => 0,
            'baseon_text' => 'سند قيد يدوي',
            'total_credit' => 0,
            'total_debit' => 0,
            'notes' => $request->notes ? $request->notes : ''
        ];


        $details = [];  

        $details[] = [
            'account_id' => $request->from_account,
            'debit' => $request->amount,
            'credit' => 0,
            'ledger_id' => 0,
            'notes' => ''
        ]; 

        $details[] = [
            'account_id' => $request->to_account,
            'debit' => 0,
            'credit' => $request->amount,
            'ledger_id' => 0,
            'notes' => ''
        ]; 

        $siteController->insertJournal($header,$details,1);
        return redirect()->route('journals' , '0');
    }

    public function delete($id){

        $header = [
            'date' => '',
            'basedon_no' => '',
            'basedon_id' => '',
            'baseon_text' => 'سند قيد يدوي رقم '.$id,
            'total_credit' => 0,
            'total_debit' => 0,
            'notes' => ''
        ];
        $siteController = new SystemController();
        $siteController->deleteJournal($header);

        return redirect()->route('journals' , '0');
    }

    public function manual_number(){
        $bills = Journal::orderBy('id', 'ASC') ->get();
        if(count($bills) > 0){
            $id = $bills[count($bills) -1] -> id ;
        } else{
            $id = 0 ;
        }
            
        $no = json_encode (str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
        echo $no ;
        exit;
    }

}
