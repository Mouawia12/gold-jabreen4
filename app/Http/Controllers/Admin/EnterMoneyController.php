<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnterMoney;
use App\Models\ExitWork;
use App\Models\Pricing;
use App\Models\Company;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use DataTables;

class EnterMoneyController extends WarehouseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){ 
        $data = DB::table('enter_money')
            ->join('companies' , 'enter_money.client_id' , '=' , 'companies.id') 
            ->join('branches' , 'enter_money.branch_id' , '=' , 'branches.id') 
            ->select('enter_money.*' , 'companies.name as vendor_name','branches.branch_name' ) 
            ->orderBy('id', 'DESC')
            ->get();

        if (!empty(Auth::user()->branch_id)) { 
            $data = $data->where('branch_id', Auth::user()->branch_id);
        }  

        if ($request->ajax()) { 

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('payment_method', function($row){
    
                    if($row->payment_method == 0){
                        $span = 'كاش (نقدي)';
                    }else{
                        $span = 'فيزا (صراف)';
                    }

                    return $span; 
                }) 
                ->addColumn('based_on', function($row){
    
                    if($row->based_on == 0){
                        $a = "{{_('main.account_deposit')}}";
                    }else{ 
                        if(auth()->user()->can('عرض فاتورة ضريبية')){  
                            if(strstr($row->based_on_bill_number,'SWSIX')){
                                $a = '<a href='.route('workExitPreviewTax',$row->based_on).' target="_blank">
                                '.$row->based_on_bill_number.'</a>';
                            }else if(strstr($row->based_on_bill_number,'SWSI')){
                                $a = '<a href='.route('workExitPreview',$row->based_on).' target="_blank">
                                '.$row->based_on_bill_number.'</a>';
                            }else if(strstr($row->based_on_bill_number,'SOSIX')){
                                $a = '<a href='.route('oldExitTaxPreview',$row->based_on).' target="_blank">
                                '.$row->based_on_bill_number.'</a>';
                            } else if(strstr($row->based_on_bill_number,'SOSI')){
                                $a = '<a href='.route('oldExitPreview',$row->based_on).' target="_blank">
                                '.$row->based_on_bill_number.'</a>';
                            }         
                        }
                    }

                    return $a; 
                }) 
                ->addColumn('action', function($row){
                    if(auth()->user()->can('عرض فاتورة ضريبية')){   
                        $btn = '<button type="button" class="btn btn-labeled btn-info preview"
                                   value="'.$row->id.'"><i class="fa fa-eye"></i>معاينة</button>';
                    }
                   
                    return $btn; 
                }) 
                ->rawColumns(['payment_method','based_on','action']) 
                ->make(true);
        } 

        return view('admin.Money.Enter.index');
 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Company::where('group_id' , '=' , 3) -> get();
        //$bill_no = $this -> getBillNo();
        $branches = Branch::where('status',1)->get();
        $html = view('admin.Money.Enter.create' , compact('clients','branches')) -> render();
        return $html ;
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
            'doc_number' => 'required|unique:enter_money',
            'client_id' => 'required',
            'based_on' => 'required',
            'amount' => 'required',
            'branch_id' => 'required'
        ]);

        $id = EnterMoney::create([
            'branch_id' => $request -> branch_id,
            'doc_number' => $request ->doc_number ,
            'date' => $request -> date,
            'client_id' => $request -> client_id,
            'amount' => $request -> amount,
            'payment_method' => $request -> payment_method,
            'based_on' => $request -> based_on,
            'based_on_bill_number' => $request -> based_on_bill_number ,
            'notes' => $request -> notes ?? '',
            'user_id' => Auth::user() -> id
         ]) -> id   ;

        $this -> syncVendorAccount($request -> client_id , $request -> amount ,0 , -1 ,
            $id , $request -> doc_number , 'Enter Money Bill',$request ->branch_id);

        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        if($auto_accounting == 1){
            $systemController = new SystemController();
            $systemController -> EnterMoneyAccounting($id);
        }

        if($request -> based_on > 0){
            $bill = ExitWork::find($request -> based_on);
            if($bill ){
                $bill -> remain_money -= $request -> amount ;
                $bill -> paid_money += $request -> amount ;
                $bill -> update();
            }
        }

         return redirect() -> route('money_entry_list') -> with('success' , __('main.created'));
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
            -> first();

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

    public function getBillNo($type,$branch_id){
        
        $bills = EnterMoney::where('branch_id', $branch_id) 
            ->orderBy('id', 'ASC')
            ->get(); 

        if(count($bills) > 0){
            $id = $bills[count($bills) -1] -> id ;
        } else{
            $id = 0 ;
        }
 
        $prefix = "ME-".$branch_id."-";
        if($type == 1){ 
            $no = json_encode($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
            echo $no ;
            exit;
        }else{
            $no = ($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
            return $no ;
        }
    }

    public function getClientExitWorks($id,$branch_id){
        $bills = ExitWork::where('branch_id', $branch_id)->where('client_id' , '=' , $id)->get();
        echo json_encode($bills);
        exit();
    }
}
