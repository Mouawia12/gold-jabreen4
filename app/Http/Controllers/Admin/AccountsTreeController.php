<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountsTree;
use App\Http\Requests\StoreAccountsTreeRequest;
use App\Http\Requests\UpdateAccountsTreeRequest;
use App\Models\Journal;
use App\Models\Payment;
use App\Models\Pricing;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use DataTables; 

class AccountsTreeController extends Controller
{
 
    public function index()
    {
        $top_level = AccountsTree::where('level' , '>' , 0) -> orderBy('level' , 'desc') -> first() -> level;
        $accounts = AccountsTree::where('level' , '>' , 0) -> orderBy('level') -> get();
        $roots = AccountsTree::where('level' , '=' , 1 ) -> orderBy('id') -> get();

        return view('admin.accounts.index',compact('accounts' , 'top_level' , 'roots'));
    }
	
    public function index2()
    {
        $accounts = AccountsTree::where('level' , '=' , 1) -> get();
        foreach ($accounts as $account){
            $childs = AccountsTree::where('parent_id' , '=' , $account -> id) -> get();
            $account -> childs = $childs ;
        }
        return view('accounts.tree',compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = AccountsTree::all();
        return view('admin.accounts.create',compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAccountsTreeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountsTreeRequest $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:accounts_trees',
            'name' => 'required|unique:accounts_trees',
        ]);

        if(!$request->has('parent_id')){
            $request->parent_id = 0;
        }

        $parentId = $request->parent_id;
        $parentCode = '';
        if($parentId > 0){
            $parentCode = AccountsTree::find($parentId)->code;
        }

        AccountsTree::create([
            'code' => $request->code,
            'name' => $request->name,
            'type' => $request->type,
            'parent_id' => $parentId,
            'parent_code' => $parentCode,
            'level' => $request->level,
            'list' => $request->list,
            'department' => $request->department,
            'side' => $request->side
        ]);

        return redirect()->route('accounts_list');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountsTree  $accountsTree
     * @return \Illuminate\Http\Response
     */
    public function show(AccountsTree $accountsTree)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountsTree  $accountsTree
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $accounts = AccountsTree::all();
        $account = AccountsTree::find($id); 

        return view('admin.accounts.update',compact('accounts','account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAccountsTreeRequest  $request
     * @param  \App\Models\AccountsTree  $accountsTree
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountsTreeRequest $request, $id)
    {
        $validated = $request->validate([
            'code' => ['required' , Rule::unique('accounts_trees')->ignore($id)],
            'name' => ['required' , Rule::unique('accounts_trees')->ignore($id)],
        ]);

        $account =AccountsTree::find($id);

        if(!$request->has('parent_id')){ 
            $request->parent_id = $account -> parent_id;
        }

        $parentId = $request->parent_id;
        $parentCode = '';
        if($parentId > 0){
            $parentCode = AccountsTree::find($parentId)->code;
        } 

        $account->update([
          'code' => $request->code,
          'name' => $request->name,
          'type' => $request->type,
          'parent_id' => $parentId,
          'parent_code' => $parentCode,
          'level' => $request->level,
          'list' => $request->list,
          'department' => $request->department,
          'side' => $request->side
        ]);

        return redirect()->route('accounts_list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountsTree  $accountsTree
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountsTree $accountsTree)
    {
        //
    }

    public function getLevel($parent){
        $account = AccountsTree::find($parent);
        return response()->json(['account' => $account]);
    }


    public function journals_manual(Request $request){

        $data = DB::table('journals')
            ->join('journal_details','journals.id','=','journal_details.journal_id')
            ->select('journals.id','journals.date','journals.basedon_no',
                'journals.basedon_id',
                'journals.baseon_text',
                DB::raw('SUM(CASE WHEN journal_details.notes <>"جرام ذهب عيار 21" THEN journal_details.credit END) credit_total'),
                DB::raw('SUM(CASE WHEN journal_details.notes <>"جرام ذهب عيار 21" THEN journal_details.debit END) debit_total'),
                DB::raw('SUM(CASE WHEN journal_details.notes = "جرام ذهب عيار 21" THEN journal_details.credit END) credit_totalg'),
                DB::raw('SUM(CASE WHEN journal_details.notes = "جرام ذهب عيار 21" THEN journal_details.debit END) debit_totalg'),
                )
            ->groupBy('journals.id','journals.date','journals.basedon_no',
                'journals.basedon_id',
                'journals.baseon_text')
            ->orderByDesc('journals.id')
            ->where('journals.basedon_no','')
            ->get(); 

            if ($request->ajax()) {  

                return Datatables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){  

                             $btn = '<button type="button" class="btn btn-labeled btn-success" onclick="showPayments('.$row->id.')">
                                        <i class="fa fa-eye"></i> 
                                     </button>  ';
                             $btn .= '<button type="button" class="btn btn-labeled btn-info"  onclick="previewMovements('.$row->id.')">
                                        <i class="fa fa-list"></i>
                                    </button> ';
                           
                            if($row -> basedon_no == ''){
                                $btn .= '<button type="button" class="btn btn-labeled btn-danger deleteBtn" id="'.$row->id.'"> 
                                        <i class="fa fa-trash"></i> 
                                    </button>';
                            } 
                        return $btn; 
                    }) 
                    ->rawColumns(['action']) 
                    ->make(true);
            } 

            $type = 0;

        return view('admin.accounts.journals_manual',compact( 'type'));

    }

    public function journals_movment(Request $request){

        $data = DB::table('journals')
            ->join('journal_details','journals.id','=','journal_details.journal_id')
            ->select('journals.id','journals.date','journals.basedon_no',
                'journals.basedon_id',
                'journals.baseon_text',
                DB::raw('SUM(CASE WHEN journal_details.notes <>"جرام ذهب عيار 21" THEN journal_details.credit END) credit_total'),
                DB::raw('SUM(CASE WHEN journal_details.notes <>"جرام ذهب عيار 21" THEN journal_details.debit END) debit_total'),
                DB::raw('SUM(CASE WHEN journal_details.notes = "جرام ذهب عيار 21" THEN journal_details.credit END) credit_totalg'),
                DB::raw('SUM(CASE WHEN journal_details.notes = "جرام ذهب عيار 21" THEN journal_details.debit END) debit_totalg'),
                )
            ->groupBy('journals.id','journals.date','journals.basedon_no',
                'journals.basedon_id',
                'journals.baseon_text')
            ->orderByDesc('journals.id')
            ->where('journals.basedon_no','<>','')
            ->get(); 

            if ($request->ajax()) {  

                return Datatables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){  

                             $btn = '<button type="button" class="btn btn-labeled btn-success" onclick="showPayments('.$row->id.')">
                                        <i class="fa fa-eye"></i> 
                                     </button>  ';
                             $btn .= '<button type="button" class="btn btn-labeled btn-info"  onclick="previewMovements('.$row->id.')">
                                        <i class="fa fa-list"></i>
                                    </button> ';
                           
                            if($row -> basedon_no == ''){
                                $btn .= '<button type="button" class="btn btn-labeled btn-danger deleteBtn" id="'.$row->id.'"> 
                                        <i class="fa fa-trash"></i> 
                                    </button>';
                            } 
                        return $btn; 
                    }) 
                    ->rawColumns(['action']) 
                    ->make(true);
            } 

            $type = 1;

        return view('admin.accounts.journals_movment',compact( 'type'));

    }

    public function journals_search(Request $request){

        $journals = DB::table('journals')
            ->join('journal_details','journals.id','=','journal_details.journal_id')
            ->select('journals.id','journals.date','journals.basedon_no',
                'journals.basedon_id',
                'journals.baseon_text',
                DB::raw('SUM(CASE WHEN journal_details.notes = "" THEN journal_details.credit END) credit_total'),
                DB::raw('SUM(CASE WHEN journal_details.notes = "" THEN journal_details.debit END) debit_total'),
                DB::raw('SUM(CASE WHEN journal_details.notes != "" THEN journal_details.credit END) credit_totalg'),
                DB::raw('SUM(CASE WHEN journal_details.notes != "" THEN journal_details.debit END) debit_totalg'),
            )
            ->groupBy('journals.id','journals.date','journals.basedon_no',
                'journals.basedon_id',
                'journals.baseon_text')
            ->orderByDesc('journals.id');

        if($request -> has('isStartDate')) $journals = $journals -> where('date' , '>=' , Carbon::parse($request -> StartDate) );
        if($request -> has('isEndDate'))   $journals = $journals -> where('date' , '<=' , Carbon::parse($request -> EndDate) -> addDay());
        if($request -> has('isCode')) $journals = $journals -> where('journals.id' , '=' , (int)$request -> code );

        $journals =  $journals -> get() ; 
        $type = $request -> type ;

        return view('admin.accounts.journals',compact('journals' ,'type'));
    }

    public function previewJournal($id){

        $payments = DB::table('journal_details')
            ->join('accounts_trees','journal_details.account_id','=','accounts_trees.id')
            ->leftJoin('companies','companies.id','=','journal_details.ledger_id')
            ->select('accounts_trees.code','accounts_trees.name','journal_details.journal_id','journal_details.credit','journal_details.debit',
                'companies.name as ledger_name' , 'journal_details.notes')
            ->where('journal_details.journal_id','=',$id)
            ->get();
        $html = view('admin.accounts.preview_journal',compact('payments'))->render();

        return $html;
    }

    public function previewMovements($id){

        $data = DB::table('account_movements')
            ->join('accounts_trees','account_movements.account_id','=','accounts_trees.id') 
            ->select('accounts_trees.code','accounts_trees.name','account_movements.journal_id','account_movements.account_id','account_movements.id','account_movements.credit','account_movements.debit' , 'account_movements.notes')
            ->where('account_movements.journal_id',$id)
            ->get();

        $html = view('admin.accounts.preview_movment',compact('data'))->render();
        
        return $html;
    }

    public function getAccount($code)
    {
        $single = $this->getSingleAccount($code);

        if($single){
            echo response()->json([$single]);
            exit;
        }else{
            $data = AccountsTree::where('code' , 'like' , '%'.$code.'%')
                ->orWhere('name','like' , '%'.$code.'%')
                ->limit(5)
                -> get();
            echo json_encode ($data);
            exit;
        }

    }

    private function getSingleAccount($code){
        
        return AccountsTree::where('code' ,$code)
            ->orWhere('name',$code)
            ->first();
    }
    
}
