<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Models\Branch; 
use App\Models\Pricing; 
use App\Models\ExitWork;
use App\Models\ExitOld;
use App\Models\ExitOldTax;
use App\Models\SaleCollectible;
use App\Models\ExitWorkTax;
use App\Models\EnterWork;
use App\Models\EnterOld;
use App\Models\PurchasesCollectible;
use App\Models\Company;
use App\Models\Item;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin-web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $auth_id = Auth::user()->id;
        $user = User::findOrFail($auth_id);
        $roles = Role::where('guard_name', 'admin-web')->get();
        $Admins = User::all();
        $branches = Branch::all(); 
        $pricings = Pricing::all();  
        $day = date("Y-m-d"); 

        //$Price_Api = new PricingController();
        //$stock_market = $Price_Api->Gold_Price_Api();
        //$stock_market = $stock_market->price;
        $stock_market ='';
     
        if(empty($user->branch_id)){

            $Admins = User::all();
            $branches = Branch::all();
            $items = Item::count(); 

            $sales1 = ExitWork::where('returned_bill_id' , 0 )->whereDate('created_at',$day)->sum('net_money');
            $sales2 = ExitOld::where('returned_bill_id' , 0 )->whereDate('created_at',$day)->sum('net_money');
            $sales3 = ExitOldTax::where('returned_bill_id' , 0 )->whereDate('created_at',$day)->sum('net_money');
            $sales4 = SaleCollectible::where('returned_bill_id' , 0 )->whereDate('created_at',$day)->sum('net_money');
          
            $sales_return1 = ExitWork::where('returned_bill_id' ,'>', 0 )->whereDate('created_at',$day)->sum('net_money');
            $sales_return2 = ExitOld::where('returned_bill_id' ,'>', 0 )->whereDate('created_at',$day)->sum('net_money');
            $sales_return3 = ExitOldTax::where('returned_bill_id' ,'>', 0 )->whereDate('created_at',$day)->sum('net_money');
            $sales_return4 = SaleCollectible::where('returned_bill_id' ,'>', 0 )->whereDate('created_at',$day)->sum('net_money');
            
            $sales_all1 = ExitWork::where('returned_bill_id' , 0 )->sum('net_money');
            $sales_all2 = ExitWorkTax::where('returned_bill_id' , 0 )->sum('net_money');
            $sales_all3 = ExitOld::where('returned_bill_id' , 0 )->sum('net_money');
            $sales_all4 = ExitOldTax::where('returned_bill_id' , 0 )->sum('net_money');
            $sales_all5 = SaleCollectible::where('returned_bill_id' , 0 )->sum('net_money');

            $sales_return_all1 = ExitWork::where('returned_bill_id' ,'>', 0 )->sum('net_money');
            $sales_return_all2 = ExitWorkTax::where('returned_bill_id' ,'>', 0 )->sum('net_money');
            $sales_return_all3 = ExitOld::where('returned_bill_id' ,'>', 0 )->sum('net_money');
            $sales_return_all4 = ExitOldTax::where('returned_bill_id' ,'>', 0 )->sum('net_money');
            $sales_return_all5 = SaleCollectible::where('returned_bill_id' ,'>', 0 )->sum('net_money');

            $purchases1 = EnterWork::whereDate('created_at',$day)->sum('net_money');
            $purchases2 = EnterOld::whereDate('created_at',$day)->sum('net_money');
            $purchases3 = PurchasesCollectible::whereDate('created_at',$day)->sum('net_money');
          
            $purchases_all1 = EnterWork::sum('net_money');
            $purchases_all2 = EnterOld::sum('net_money');
            $purchases_all3 = PurchasesCollectible::sum('net_money');  

            $clients = Company::where('group_id',3)->get();
            $suppliers = Company::where('group_id',4)->get();
            
        }else{
            $Admins = User::where('branch_id',$user->branch_id)->get();
            $branches = Branch::where('id',$user->branch_id)->get();
            $items = Item::where('branch_id',$user->branch_id)->count();

            $sales1 = ExitWork::where('returned_bill_id' , 0 )->where('branch_id',$user->branch_id)->whereDate('created_at',$day)->sum('net_money');
            $sales2 = ExitOld::where('returned_bill_id' , 0 )->where('branch_id',$user->branch_id)->whereDate('created_at',$day)->sum('net_money');
            $sales3 = ExitOldTax::where('returned_bill_id' , 0 )->where('branch_id',$user->branch_id)->whereDate('created_at',$day)->sum('net_money');
            $sales4 = SaleCollectible::where('returned_bill_id' , 0 )->where('branch_id',$user->branch_id)->whereDate('created_at',$day)->sum('net_money');
          
            $sales_return1 = ExitWork::where('returned_bill_id' ,'>', 0 )->where('branch_id',$user->branch_id)->whereDate('created_at',$day)->sum('net_money');
            $sales_return2 = ExitOld::where('returned_bill_id' ,'>', 0 )->where('branch_id',$user->branch_id)->whereDate('created_at',$day)->sum('net_money');
            $sales_return3 = ExitOldTax::where('returned_bill_id' ,'>', 0 )->where('branch_id',$user->branch_id)->whereDate('created_at',$day)->sum('net_money');
            $sales_return4 = SaleCollectible::where('returned_bill_id' ,'>', 0 )->where('branch_id',$user->branch_id)->whereDate('created_at',$day)->sum('net_money');
            
            $sales_all1 = ExitWork::where('returned_bill_id' , 0 )->where('branch_id',$user->branch_id)->sum('net_money');
            $sales_all2 = ExitWorkTax::where('returned_bill_id' , 0 )->where('branch_id',$user->branch_id)->sum('net_money');
            $sales_all3 = ExitOld::where('returned_bill_id' , 0 )->where('branch_id',$user->branch_id)->sum('net_money');
            $sales_all4 = ExitOldTax::where('returned_bill_id' , 0 )->where('branch_id',$user->branch_id)->sum('net_money');
            $sales_all5 = SaleCollectible::where('returned_bill_id' , 0 )->where('branch_id',$user->branch_id)->sum('net_money');

            $sales_return_all1 = ExitWork::where('returned_bill_id' ,'>', 0 )->where('branch_id',$user->branch_id)->sum('net_money');
            $sales_return_all2 = ExitWorkTax::where('returned_bill_id' ,'>', 0 )->where('branch_id',$user->branch_id)->sum('net_money');
            $sales_return_all3 = ExitOld::where('returned_bill_id' ,'>', 0 )->where('branch_id',$user->branch_id)->sum('net_money');
            $sales_return_all4 = ExitOldTax::where('returned_bill_id' ,'>', 0 )->where('branch_id',$user->branch_id)->sum('net_money');
            $sales_return_all5 = SaleCollectible::where('returned_bill_id' ,'>', 0 )->where('branch_id',$user->branch_id)->sum('net_money');

            $purchases1 = EnterWork::whereDate('created_at',$day)->where('branch_id',$user->branch_id)->sum('net_money');
            $purchases2 = EnterOld::whereDate('created_at',$day)->where('branch_id',$user->branch_id)->sum('net_money');
            $purchases3 = PurchasesCollectible::whereDate('created_at',$day)->where('branch_id',$user->branch_id)->sum('net_money');
          
            $purchases_all1 = EnterWork::where('branch_id',$user->branch_id)->sum('net_money');
            $purchases_all2 = EnterOld::where('branch_id',$user->branch_id)->sum('net_money');
            $purchases_all3 = PurchasesCollectible::where('branch_id',$user->branch_id)->sum('net_money');  

            $clients = Company::where('group_id',3)->get();
            $suppliers = Company::where('group_id',4)->get();
        }

        return view('admin.home', compact('user','pricings','Admins','branches','sales1','sales2','sales3','sales4'
            ,'sales_return1','sales_return2','sales_return3','sales_return4'
            ,'sales_all1','sales_all2','sales_all3','sales_all4','sales_all5'
            ,'sales_return_all1','sales_return_all2','sales_return_all3','sales_return_all4','sales_return_all5'
            ,'purchases1','purchases2','purchases3'
            ,'purchases_all1','purchases_all2','purchases_all3'
            ,'clients','suppliers','items','stock_market'));
 
	}

    public function lock_screen()
    {
        return view('admin.lockscreen');
    } 
}
