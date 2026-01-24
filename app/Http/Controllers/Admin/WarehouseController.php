<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyInfo;
use App\Models\CompanyMovement;
use App\Models\Item;
use App\Models\ItemMaterials;
use App\Models\Karat;
use App\Models\VendorMovement;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
  /* $type => new or old
   * $karat_id => karat id
   * $weight => actual weight
   * $direction => +1 or -1 (enter or out)
   * $bill_id => Bill Id
   * */
    public function syncQnt($type , $karat_id, $category_id, $bill_id, $weight, $direction, $branch_id){
        
        Warehouse::create([ 
            'branch_id' => $branch_id,
            'type' => $type,
            'karat_id' => $karat_id,
            'category_id'=> $category_id,
            'enter_weight' => $direction > 0 ? $weight : 0,
            'out_weight' => $direction < 0 ? $weight : 0 ,
            'bill_id' => $bill_id,
            'date' => Carbon::now(),
            'user_id' => Auth::user() -> id,
        ]);
    }

    public function deleteQnt($bill_id){
        $items = Warehouse::where('bill_id' , '=' , $bill_id) -> get();
        foreach ($items as $item){
            $item -> delete();
        }
    }

    public function syncVendorAccount($vendor_id , $money, $gold, $direction, $bill_id, $bill_number, $type, $branch_id){
        
        $vebdor = Company::find($vendor_id);

        if($direction > 0){
            $vebdor -> credit_amount += $money ;
            $vebdor -> credit_gold += $gold ; 
        } else {
            $vebdor -> deposit_amount += $money ;
            $vebdor -> deposit_gold += $gold ;
        }

        $vebdor -> update();
        
        CompanyMovement::create([
            'branch_id' => $branch_id,
            'company_id' => $vendor_id,
            'paid_money' => 0,
            'credit_money' => $direction < 0 ? $money : 0,
            'debit_money'  => $direction > 0 ? $money : 0,
            'paid_gold' => 0 ,
            'credit_gold' => $direction < 0 ? $gold : 0,
            'debit_gold' => $direction > 0 ? $gold : 0,
            'date' => Carbon::now(),
            'invoice_type' => $type,
            'bill_id' => $bill_id,
            'bill_number' => $bill_number,
            'user_id' => Auth::user() -> id 
        ]);
    }

    public function deleteVendorMove($vendor_id , $bill_id ,$money ,$gold , $type){
        $supplier = Company::find($vendor_id);
        $movement = CompanyMovement::where('company_id' , '=' , $vendor_id) -> where('bill_id' , '=' , $bill_id)
            ->where('invoice_type' , '=' , $type) -> get() -> first();
        if($movement){

            $supplier -> deposit_amount -= $movement -> debit_money ;
            $supplier -> deposit_gold  -= $movement -> debit_gold ;

            if($supplier->credit_amount > 0){
                $supplier -> credit_amount -= $movement -> debit_money ;
            }
            if($supplier->credit_gold > 0){
                $supplier -> credit_gold -= $movement -> debit_gold ;
            }
           
            $supplier -> update();
            $movement -> delete();
        }
    }

    public function gold_stock(){


        if (!empty(Auth::user()->branch_id)) {
            $workWarehouses = Warehouse::where('type' , '=' , 1)->where('branch_id', Auth::user()->branch_id) ->get() -> groupBy('karat_id');
            $oldWarehouses = Warehouse::where('type' , '=' , 0)->where('branch_id', Auth::user()->branch_id) -> get() -> groupBy('karat_id');
            $pureWarehouses = Warehouse::where('type' , '=' , 2)->where('branch_id', Auth::user()->branch_id) -> get() -> groupBy('karat_id');
        }else{
            $workWarehouses = Warehouse::where('type' , '=' , 1) ->get() -> groupBy('karat_id');
            $oldWarehouses = Warehouse::where('type' , '=' , 0) -> get() -> groupBy('karat_id');
            $pureWarehouses = Warehouse::where('type' , '=' , 2) -> get() -> groupBy('karat_id');
        }  

        $karats = Karat::all();
        $work = $workWarehouses -> map(function ($item) {
            return [
                'enter_weight' => $item -> sum('enter_weight'),
                'out_weight'=> $item -> sum('out_weight'),
            ];
        });
        $old = $oldWarehouses -> map(function ($item) {
            return [
                'enter_weight' => $item -> sum('enter_weight'),
                'out_weight'=> $item -> sum('out_weight'),
            ];
        });
        $pure = $pureWarehouses -> map(function ($item) {
            return [
                'enter_weight' => $item -> sum('enter_weight'),
                'out_weight'=> $item -> sum('out_weight'),
            ];
        });
      // return $work ;
        $slag = 3 ;
        $subSlag = 13 ;
        $company = CompanyInfo::all() -> first();

        $period = 'Period : ';
        $period_ar = 'الفترة  :';

        $period .= 'Starting Date';
        $period_ar .= 'من البداية' ;

        $period .= ' -- '  . 'Today' ;
        $period_ar .= ' -- '  . 'حتي اليوم' ;

        return view('admin.Item.gold_stock' , compact('work' , 'old' , 'pure','karats' , 'slag' , 'subSlag' ,'company' , 'period_ar' , 'period')) ;
    }

    public function makeItemUnAvailable($id){
        $item = Item::find($id);
        if($item){
            if($item -> item_type == 1){
                $item -> state = 0 ;
                $item -> update();
            } else if($item -> item_type == 3){
                $materials = ItemMaterials::where('parent_id' , '=' , $id) -> get();
                foreach ($materials as $material){
                    $sub = Item::find($material -> item_id);
                    $sub -> state = 0 ;
                    $sub -> update();
                }
                $item -> state = 0 ;
                $item -> update();
            } else if($item -> item_type == 2){
                if($item -> quantity == 0){
                    $item -> state = 0 ;
                    $item -> update();
                }
            }

        }
    }

    public function makeItemsPurchase($id){
        $item = Item::find($id);
        if($item){  
            $item -> state = 1 ;
            $item -> update();
        }
    }
}
