<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountSetting;
use App\Http\Requests\StoreAccountSettingRequest;
use App\Http\Requests\UpdateAccountSettingRequest;
use App\Models\AccountsTree;
use App\Models\Pricing;
use App\Models\Storehouse;
use App\Models\Warehouse;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = AccountSetting::all();
        foreach ($accounts as $account){
            $account->branch_name = Branch::find($account->branch_id)->branch_name;
            $account->warehouse_name = Storehouse::find($account->warehouse_id)->name;
            $account->safe_account_name = AccountsTree::find($account->safe_account)->name;
            $account->sales_account_name = AccountsTree::find($account->sales_account)->name;
            $account->purchase_account_name = AccountsTree::find($account->purchase_account)->name;
            $account->return_sales_account_name = AccountsTree::find($account->return_sales_account)->name;
            $account->return_purchase_account_name = AccountsTree::find($account->return_purchase_account)->name;
            $account->stock_account_name = AccountsTree::find($account->stock_account)->name;
            $account->sales_discount_account_name = AccountsTree::find($account->sales_discount_account)->name;
            $account->sales_tax_account_name = AccountsTree::find($account->sales_tax_account)->name;
            $account->purchase_discount_account_name = AccountsTree::find($account->purchase_discount_account)->name;
            $account->purchase_tax_account_name = AccountsTree::find($account->purchase_tax_account)->name;
            $account->cost_account_name = AccountsTree::find($account->cost_account)->name;
            $account->profit_account_name = AccountsTree::find($account->profit_account)->name;
            $account->reverse_profit_account_name = AccountsTree::find($account->reverse_profit_account)->name;
            $account->bank_account_name = AccountsTree::find($account->bank_account)->name; 
            $account->made_account_name = AccountsTree::find($account->made_account)->name; 
        }

        $pricings = Pricing::all();

        return view('admin.accounts.settings',compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = AccountsTree::query()->where('type','>',1)->get();
        $warehouses = Storehouse::all(); 
        $branchs = Branch::all();

        return view('admin.accounts.create_settings',compact('accounts','warehouses','branchs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAccountSettingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountSettingRequest $request)
    {
        AccountSetting::create($request->all());
        return redirect()->route('account_settings_list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountSetting  $accountSetting
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountSetting  $accountSetting
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $accounts = AccountsTree::query()->where('type','>',1)->get();
        $warehouses = Storehouse::all();
        $setting = AccountSetting::find($id); 
        $branchs = Branch::all();

        return view('admin.accounts.update_settings',compact('accounts','warehouses' , 'branchs', 'setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAccountSettingRequest  $request
     * @param  \App\Models\AccountSetting  $accountSetting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountSettingRequest $request, $id)
    {
        $setting = AccountSetting::find($id);
        if($setting){
            $setting -> update($request->all());
            return redirect()->route('account_settings_list');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountSetting  $accountSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountSetting $accountSetting)
    {
        //
    }
}
