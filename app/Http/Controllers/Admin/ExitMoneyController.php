<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnterOld;
use App\Models\EnterWork;
use App\Models\PurchasesCollectible;
use App\Models\ExitMoney;
use App\Models\ExitWork;
use App\Models\Pricing;
use App\Models\Company;
use App\Models\Journal;
use App\Models\JournalDetails;
use App\Models\AccountMovement;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

class ExitMoneyController extends WarehouseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){  

        $data = DB::table('exit_money')
            ->join('companies' , 'exit_money.supplier_id' , '=' , 'companies.id')
            ->leftJoin('enter_works' , 'exit_money.based_on' , 'enter_works.id')
            ->leftJoin('enter_olds' , 'exit_money.based_on' , 'enter_olds.id')
            ->leftJoin('purchases_collectibles' , 'exit_money.based_on' , 'purchases_collectibles.id')
            ->join('branches' , 'exit_money.branch_id' , '=' , 'branches.id') 
            ->select(
                'exit_money.*' , 
                'companies.name as vendor_name' , 
                'enter_works.bill_number as invoice_number0' , 
                'enter_olds.bill_number as invoice_number1' , 
                'purchases_collectibles.bill_number as invoice_number2',
                'branches.branch_name'
                )
            -> orderBy('id', 'DESC')
            ->get();

        if (!empty(Auth::user()->branch_id)) {
            $data = $data->where('branch_id', Auth::user()->branch_id); 
        }  

        $branches = Branch::where('status',1)->get();

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
                ->addColumn('type', function($row){
    
                    if($row->type == 0){
                        $span = 'تسديد أجر إلى مصنع';
                    }elseif($row->type == 1){
                        $span = 'تسديد قيمة ذهب (كسر)';
                    }elseif($row->type == 2){
                        $span = 'تسديد قيمة ذهب (مشغول) إلى مصنع';
                    }elseif($row->type == 3){
                        $span = "تسديد قيمة ذهب (صافي) إلى  مورد";
                    }elseif($row->type == 4){
                        $span = " قيمة فاتورة مرتجع مبيعات";
                    }elseif(isset($row ->invoice_number2)){
                        $span = 'تسديد قيمة مشتريات ثمينة';  
                    }

                    return $span; 
                }) 
                ->addColumn('based_on', function($row){
    
                    if($row->based_on == 0){
                        $a = '{{_('.main.account_deposit.')}}';
                    }else{ 
                        if(auth()->user()->can('عرض فاتورة مشتريات')){  
                            if($row -> type == 0 || $row -> type == 2){ 
                                $a = '<a href='.route('workEnterPrint',$row->based_on).' target="_blank">
                                    '.$row->invoice_number0.'</a>';  
                            }elseif($row -> type == 4){ 
                                $a = '<a href='.route('workReturnPrint',$row->based_on).' target="_blank">
                                    '.$row->based_on_bill_number.'</a>';  
                            }else{
                                if(!empty($row -> invoice_number2)){
                                    $a = '<a href='.route('Purchase.Enter.Print',$row->based_on).' target="_blank">
                                        '.$row->invoice_number2.'</a>';
                                }else{
                                    $a = '<a href='.route('oldEnterPrint',$row->based_on).' target="_blank">
                                        '.$row->invoice_number1.'</a>'; 
                                }
                            }
                        }
                    }

                    return $a; 
                }) 
                ->addColumn('action', function($row){
                    if(auth()->user()->can('عرض دفتر خروج النقدية')){   
                        $btn = '<button type="button" class="btn btn-labeled btn-info preview"
                                   value="'.$row->id.'" id="'.$row->type.'">
                                   <i class="fa fa-eye"></i>
                                   </button>';
                    }
                    if(auth()->user()->can('حذف دفتر خروج النقدية') ){   
                        $btn = $btn.'<button type="button" class="btn btn-labeled btn-danger deleteBtn"
                                   value="'.$row->id.'">
                                   <i class="fa fa-trash"></i>
                                   </button>';
                    }
                    return $btn; 
                }) 
                ->rawColumns(['payment_method','type','based_on','action']) 
                ->make(true);
        } 

        return view('admin.Money.Exit.index' , compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Company::where('group_id' , 4) -> get();
        //$bill_no = $this -> getBillNo();
        $pricing = Pricing::all() -> first();
        $branches = Branch::where('status',1)->get();
        $html = view('admin.Money.Exit.create' , compact('suppliers' , 'pricing','branches')) -> render();
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
            'doc_number' => 'required|unique:exit_money',
            'supplier_id' => 'required',
            'based_on' => 'required',
            'amount' => 'required',
            'type' => 'required',
            'branch_id' => 'required'
        ]);

        $id = ExitMoney::create([
            'branch_id' => $request -> branch_id,
            'doc_number' => $request ->doc_number ,
            'date' => $request -> date,
            'supplier_id' => $request -> supplier_id,
            'type' => $request -> type ,
            'based_on' => $request -> based_on,
            'based_on_bill_number' => $request -> based_on_bill_number,
            'amount' => $request -> amount,
            'payment_method' => $request -> payment_method,
            'price_gram' => $request -> price_gram,
            'notes' => $request -> notes ?? '',
            'user_id' => Auth::user() -> id

        ]) -> id   ;

        $auto_accounting =  env("AUTO_ACCOUNTING", 1);
        if($auto_accounting == 1){
            $systemController = new SystemController();
            $systemController -> ExitMoneyAccounting($id);
        }

        if($id) {

            $money = 0 ;
            $gold = 0 ;

            if($request->type == 0 or $request->type == 5){
                $money = $request -> amount ;   //تسديد أجر للمصنع
                $gold = 0 ;

            } else if($request->type == 1 or $request->type == 3){
                //هنسدد الذهب الكسر  بنقدية
                $money = $request -> amount ; 
                $gold = ($request -> amount / $request -> price_gram);

            } else if($request->type == 2){
                //هنسدد الذهب المشغول بنقدية
                $money = $request -> amount ; 
                $gold = ($request -> amount / $request -> price_gram);
            }

            $this->syncVendorAccount($request->supplier_id, $money, $gold, 1,
                $id, $request->doc_number, 'Exit Money Bill',$request ->branch_id);

            if ($request->type == 0) {

                $bill = EnterWork::find($request->based_on);
                $bill->remain_money -= $request->amount;
                $bill->paid_money += $request->amount;
                $bill->update();

            } else if ($request->type == 2){

                $bill = EnterWork::find($request->based_on);
                //update add new 17-05-2024
                $bill->remain_money -= $request->amount;
                $bill->paid_money += $request->amount;
                //end update
                $bill->remain_gold -= $gold;
                $bill->paid_gold += $gold;
                $bill->update();

            } else if ($request->type == 5){

                $bill = PurchasesCollectible::find($request->based_on);
                $bill->remain_money -= $request->amount;
                $bill->paid_money += $request->amount;
                $bill->update(); 

            }else {
                $bill = EnterOld::find($request->based_on);
                $bill->remain_gold -= $gold;
                $bill->paid_gold += $gold;
                $bill->update();

            }

            return redirect()->route('money_exit_list')->with('success', __('main.created'));
        }
        return redirect()->route('money_exit_list')->with('error', __('something went wrong'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExitMoney  $exitMoney
     * @return \Illuminate\Http\Response
     */
    public function show($id , $type)
    {
        $clients = Company::all();
        if($type == 0 || $type == 2){
            $bill = DB::table('exit_money')
                ->join('companies' , 'exit_money.supplier_id' , '=' , 'companies.id')
                ->join('enter_works' , 'exit_money.based_on' , 'enter_works.id')
                ->select('exit_money.*' , 'companies.name as vendor_name' , 'enter_works.bill_number as invoice_number')
                ->where('exit_money.id' , '=' ,$id )
                ->first();
        } else {
            $bill = DB::table('exit_money')
                ->join('companies' , 'exit_money.supplier_id' , '=' , 'companies.id')
                ->join('enter_olds' , 'exit_money.based_on' , 'enter_olds.id')
                ->select('exit_money.*' , 'companies.name as vendor_name' , 'enter_olds.bill_number as invoice_number')
                ->where('exit_money.id' , '=' ,$id )
                ->first();
        }

        $html = view('admin.Money.Exit.view' , compact('bill', 'clients')) -> render();
        return $html ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExitMoney  $exitMoney
     * @return \Illuminate\Http\Response
     */
    public function edit(ExitMoney $exitMoney)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExitMoney  $exitMoney
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExitMoney $exitMoney)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExitMoney  $exitMoney
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(ExitMoney::where('id', $id)->exists()){
            $bill = ExitMoney::find($id); 
            $this->deleteVendorMove($bill->supplier_id, $id, $bill->amount, 1, 'Exit Money Bill');  
            $journal_id2 = Journal::where('basedon_no', $bill->doc_number)->first()->id;
            JournalDetails::where('journal_id', $journal_id2)->delete();
            Journal::where('basedon_no', $bill->doc_number)->delete();
            AccountMovement::where('journal_id', $journal_id2)->delete();  
            $bill ->delete();
        }
        return back()->with('success',__('main.deleted'));
    }

    public function getBillNo($type,$branch_id){

        $bills = ExitMoney::where('branch_id', $branch_id) 
            ->orderBy('id', 'ASC')
            ->get(); 

        if(count($bills) > 0){
            $id = $bills[count($bills) -1] -> id ;
        } else{
            $id = 0 ;
        }
            
        $i = 0;
        if($type == 1){  
            do { 
                $i++;
                $prefix = "MEx-".$branch_id."-"; 
                $no = json_encode($prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT)) ;
            } while (ExitMoney::where("doc_number","=",$prefix . str_pad($id + $i, 6 , '0' , STR_PAD_LEFT))->exists());
         
            echo $no ;
            exit;
        }else{
            $no = ($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
            return $no ;
        }
    }

    public function getClientSupplier($type){
        if($type == 0 || $type == 2){
            $purchases = EnterWork::select('supplier_id');
            $vendors = Company::whereIn('id',$purchases)->where('group_id',4)->orderBy('id', 'ASC')->get();
        }else if($type == 3){
            $purchases = EnterOld::select('supplier_id');
            $vendors = Company::whereIn('id',$purchases)->where('group_id',4)->orderBy('id', 'ASC')->get();
        }else if($type == 5){
            $purchases = PurchasesCollectible::select('supplier_id');
            $vendors = Company::whereIn('id',$purchases)->where('group_id',4)->orderBy('id', 'ASC')->get();
        } else {
            $vendors = Company::where('group_id' , '=' , 4)->where('vat_no' , '=' , 0)  -> get();
        }

        echo json_encode($vendors);
        exit();
    }

    public function getClientSupplierWorks($client_id , $type,$branch_id){
        if($type == 0 || $type == 2){
            $works = EnterWork::where('supplier_id' , '=' ,$client_id )->where('branch_id' ,$branch_id )-> get();
        } else if($type == 1) {
            $works = EnterOld::where('supplier_id' , '=' ,$client_id )->where('bill_type' , '=' ,0)->where('branch_id' ,$branch_id )-> get();
        } else if($type == 3) {
            $works = EnterOld::where('supplier_id' , '=' ,$client_id )->where('bill_type' , '=' ,2)->where('branch_id' ,$branch_id )-> get();
        }else{
            $works = PurchasesCollectible::where('supplier_id' , '=' ,$client_id )->where('branch_id' ,$branch_id )->get();
        }
 
        echo json_encode($works);
        exit();

    }

    public function getClientDocumentdata($id , $type){
        if($type == 0 || $type == 2 ){
            $document = EnterWork::find($id);
            echo json_encode($document);
            exit();
        } else if ($type == 1){
            $document = EnterOld::find($id);
            echo json_encode($document);
            exit();
        } else if ($type == 3){
            $document = EnterOld::find($id);
            echo json_encode($document);
            exit();
        } else if ($type == 4){
            $document = ExitWork::find($id);
            echo json_encode($document);
            exit();
        } else if ($type == 5){
                $document = PurchasesCollectible::find($id);
                echo json_encode($document);
                exit();
            }
    }

}
