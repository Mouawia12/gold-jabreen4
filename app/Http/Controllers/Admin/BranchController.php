<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Admin; 
use App\Models\AccountsTree; 
use App\Models\AccountSetting;
use App\Models\ProgramSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:اضافة فرع', ['only' => ['index']]);
        $this->middleware('permission:عرض فرع', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل فرع', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف فرع', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = Branch::orderBy('id','DESC')->get();
        return view('admin.branches.index', compact('data'));
    }

    public function create()
    {
        return view('admin.branches.create');

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'branch_name' => 'required|unique:branches',
            'branch_phone' => 'required',
            'branch_address' => 'required', 
        ]);

        if(!empty(Auth::user() ->branch_id)){
            $program_settings = ProgramSetting::first();
            $branchs = Branch::all();
            if($program_settings && $program_settings->branche == $branchs->count()){
                return ;
            }
        }

 
        $input = $request->all();
        $branch = Branch::create($input);
        $this->getAccountSetting($branch->id);
        $this->getAccountSetting_private($branch->id);
 
        return redirect()->route('admin.branches.index')
            ->with('success', 'تم اضافة فرع بنجاح');
 
 
    }
   
    public function show($id)
    {
        $branch = Branch::findorfail($id);
        return view('admin.branches.show', compact('branch'));
    }

    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'branch_name' =>  ['required', Rule::unique('branches')->ignore($id)],
            'branch_phone' => 'required',
            'branch_address' => 'required', 
        ]);

        $input = $request->all();
        if(!isset($input['status'])){
            $input['status'] = 0;
        }

        $branch = Branch::findOrFail($id);
        $branch->update($input);

        return redirect()->route('admin.branches.index')
            ->with('success', 'تم تعديل بيانات الفرع بنجاح');
    }



    public function destroy(Request $request)
    { 
        /*

       $Admin = Admin::findOrFail($request->branch_id); 
        if(empty($Admin)){ 
            Branch::findOrFail($request->branch_id)->delete();
            return redirect()->route('admin.branches.index')
                ->with('success', 'تم حذف الفرع بنجاح');
        }else{
            return redirect()->route('admin.branches.index')
            ->with('success', 'هذا الفرع مرتبط باعضاء');
        }
        */
   
    }

    public function remove_selected(Request $request)
    {
        
        /*
        $branches_id = $request->branches;
        foreach ($branches_id as $branch_id) {
            $branch = Branch::FindOrFail($branch_id);
            $branch->delete();
        }
        return redirect()->route('admin.branches.index')
            ->with('success', 'تم الحذف بنجاح');
            */
    }

    public function print_selected()
    {
        $branches = Branch::all();
        return view('admin.branches.print', compact('branches'));
    }

    public function getAccountSetting($branche_id)
    {
        try {
            $account_setting = $this->getTableColumns('account_settings');
            $setting = AccountSetting::latest('id')-> first();
            $setting_const = AccountSetting::select(
                'warehouse_id',
                'sales_tax_account',
                'purchase_tax_account',
                'sales_tax_excise_account',
                'profit_account',
                'reverse_profit_account',
                'supplier_default_account'
            )->first();

            $accountSettingColumns = array_flip($account_setting);
            $accountSettingData = [ 
                'safe_account' => 0,
                'bank_account' => 0,
                'sales_account' => 0,
                'purchase_account' => 0,
                'purchase_Jewelry_account' => 0,
                'purchase_old_account' => 0,
                'purchase_pure_account' => 0,
                'return_sales_account' => 0,
                'return_purchase_account' => 0,
                'stock_account' => 0,
                'stock_Jewelry_account' => 0,
                'stock_old_account' => 0,
                'stock_pure_account' => 0,
                'stock_under_account' => 0,
                'sales_discount_account' => 0, 
                'purchase_discount_account' => 0,  
                'made_account' => 0,
                'cost_account' => 0, 
                'reverse_profit_account' => $setting_const->reverse_profit_account ?? 0,
                'supplier_default_account' => $setting_const->supplier_default_account ?? 0,
                'profit_account' => $setting_const->profit_account ?? 0,
                'purchase_tax_account' => $setting_const->purchase_tax_account ?? 0,
                'sales_tax_account' => $setting_const->sales_tax_account ?? 0,
                'sales_tax_excise_account' => $setting_const->sales_tax_excise_account ?? 0,
                'warehouse_id' => $setting_const->warehouse_id ?? 0,
                'branch_id' => $branche_id,
            ];
            if (!isset($accountSettingColumns['purchase_Jewelry_account']) && isset($accountSettingColumns['purchase_jewelry_account'])) {
                $accountSettingData['purchase_jewelry_account'] = $accountSettingData['purchase_Jewelry_account'];
                unset($accountSettingData['purchase_Jewelry_account']);
            }
            if (!isset($accountSettingColumns['stock_Jewelry_account']) && isset($accountSettingColumns['stock_jewelry_account'])) {
                $accountSettingData['stock_jewelry_account'] = $accountSettingData['stock_Jewelry_account'];
                unset($accountSettingData['stock_Jewelry_account']);
            }

            $accountSettingData = array_intersect_key($accountSettingData, $accountSettingColumns);
            $account_setting_branch = AccountSetting::create($accountSettingData);
    
            for($i = 1; $i < count($account_setting)-10; $i++){
                
                $account_tree = AccountsTree::find($setting[$account_setting[$i]]);
                if($account_tree){
                    $name = preg_replace('/[0-9]+/', '', $account_tree->name);

                    $name .= $branche_id; 
                    $sub_accounts = AccountsTree::where('parent_id',$account_tree->id)->get();
        
                    if($sub_accounts->count()>0){ 
                        if (AccountsTree::where('name', $name)->doesntExist()) {
                            $isaaccount = AccountsTree::create([
                                'name' => $name,
                                'code' => $account_tree -> code + 1,
                                'type' => $account_tree -> type,
                                'parent_id' =>$account_tree ->parent_id,
                                'parent_code' => $account_tree -> parent_code,
                                'level' => $account_tree -> level,
                                'list' => $account_tree -> list,
                                'department' => $account_tree -> department,
                                'side' => $account_tree -> side 
                            ]);
        
                            if($account_setting_branch[$account_setting[$i]] == 0){
                                $account_setting_branch[$account_setting[$i]]= $isaaccount ->id;
                                $account_setting_branch->save();
                            }
                        } 
                        
                       
                        $j = 1;
                        foreach($sub_accounts as $sub_account){
                            $name = preg_replace('/[0-9]+/', '', $sub_account->name);
                            $name .= $branche_id;
                            $code = $isaaccount -> code;
                            $code .='0'; 
                            $code .= $j;
                            if (AccountsTree::where('name', $name)->doesntExist()) {
                                $issub = AccountsTree::create([
                                    'name' => $name,
                                    'code' => $code,
                                    'type' => $sub_account -> type,
                                    'parent_id' => $isaaccount ->id,
                                    'parent_code' => $isaaccount ->code,
                                    'level' => $sub_account -> level,
                                    'list' => $sub_account -> list,
                                    'department' => $sub_account -> department,
                                    'side' => $sub_account -> side 
                                ]);
            
                                if($account_setting_branch[$account_setting[$i+$j]] == 0){
                                    $account_setting_branch[$account_setting[$i+$j]]= $issub ->id;
                                    $account_setting_branch->save();
                                }
                            }
        
                            $j++;
                        }
        
                       
                    }else{ 
                        if (AccountsTree::where('name', $name)->doesntExist()) {
                            $isaaccount = AccountsTree::create([
                                'name' => $name,
                                'code' => $account_tree -> code + 1,
                                'type' => $account_tree -> type,
                                'parent_id' =>$account_tree ->parent_id,
                                'parent_code' => $account_tree -> parent_code,
                                'level' => $account_tree -> level,
                                'list' => $account_tree -> list,
                                'department' => $account_tree -> department,
                                'side' => $account_tree -> side 
                            ]);
                            
                            if($account_setting_branch[$account_setting[$i]] == 0){
                                $account_setting_branch[$account_setting[$i]]= $isaaccount ->id;
                                $account_setting_branch->save();
                            }
                        }
                    }
                }            
    
            }
        } catch (QueryException $ex) {
            return redirect()->route('pos')->with('error', $ex->getMessage());
        }
    }

    public function getAccountSetting_private($branche_id)
    {
        $setting = AccountSetting::where('branch_id',$branche_id)->first();
        if (!$setting) {
            return;
        }
        $account_tree = AccountsTree::where('parent_code',52)->latest('id')-> first();
        if (!$account_tree) {
            return;
        }
        $account_tree_subs = AccountsTree::where('parent_code','like','%'. $account_tree->code .'%')-> get();
  
        $name = preg_replace('/[0-9]+/', '', $account_tree->name);
        $name .= $branche_id;
        if($account_tree){

            if (AccountsTree::where('name', $name)->doesntExist()) {
                $account = AccountsTree::create([
                    'name' => $name,
                    'code' => $account_tree -> code + 1,
                    'type' => $account_tree -> type,
                    'parent_id' => $account_tree -> parent_id,
                    'parent_code' => $account_tree -> parent_code,
                    'level' => $account_tree -> level,
                    'list' => $account_tree -> list,
                    'department' => $account_tree -> department,
                    'side' => $account_tree -> side,  
                ]); 
            }

            $j = 1;
    
            foreach($account_tree_subs as $account_tree_sub){ 
                $name = preg_replace('/[0-9]+/', '', $account_tree_sub->name);
                $name .= $branche_id;
                if(isset($child)){
                    $code = $child -> code + 1; 
                    $parent_id = $child -> id;
                    $parent_code = $child ->code;
                }else{
                    $code = $account -> code;
                    $code .='0'; 
                    $code .= $j;
                    $parent_id = $account ->id;
                    $parent_code = $account ->code;
                }

                if (AccountsTree::where('name', $name)->doesntExist()) {
                    $child = AccountsTree::create([
                        'name' => $name,
                        'code' => $code,
                        'type' => $account_tree_sub -> type,
                        'parent_id' => $parent_id,
                        'parent_code' => $parent_code,
                        'level' => $account_tree -> level,
                        'list' => $account_tree -> list,
                        'department' => $account_tree -> department,
                        'side' => $account_tree -> side,  
                    ]);
                } 
            }
            $j++;

            if($child){
                $setting->cost_account = $child->id;
                $setting->save();
            }
        }
    }


    public function getTableColumns($table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);
    
        // OR
    
        //return Schema::getColumnListing($table);
    
    }
 
}
