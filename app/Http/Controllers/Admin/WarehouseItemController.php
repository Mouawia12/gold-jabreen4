<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyInfo;
use App\Models\CompanyMovement;
use App\Models\ItemsCollectible;
use App\Models\VendorMovement;
use App\Models\WarehouseItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarehouseItemController extends Controller
{
  /* $type => new or old
   * $karat_id => karat id
   * $weight => actual weight
   * $direction => +1 or -1 (enter or out)
   * $bill_id => Bill Id
   * */
    public function syncQnt($type , $Item_id , $bill_id , $weight , $direction,$branch_id){
        WarehouseItem::create([
            'branch_id' => $branch_id,
            'type' => $type,
            'item_id' => $Item_id,
            'enter' => $direction > 0 ? $weight : 0,
            'out' => $direction < 0 ? $weight : 0 ,
            'bill_id' => $bill_id,
            'date' => Carbon::now(),
            'user_id' => Auth::user() -> id,
        ]);
    }


    public function deleteQnt($bill_id){
        $items = WarehouseItem::where('bill_id' , '=' , $bill_id) -> get();
        foreach ($items as $item){
            $item -> delete();
        }
    }

    public function syncVendorAccount($vendor_id , $money , $gold , $direction , $bill_id , $bill_number , $type,$branch_id){
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
            'credit_money' => $direction > 0 ? $money : 0,
            'debit_money'  => $direction < 0 ? $money : 0,
            'paid_gold' => 0 ,
            'credit_gold' => 0,
            'debit_gold' =>  0,
            'date' => Carbon::now(),
            'invoice_type' => $type,
            'bill_id' => $bill_id,
            'bill_number' => $bill_number,
            'user_id' => Auth::user() -> id 
        ]);
    }

    public function deleteVendorMove($vendor_id , $bill_id ,$money ,$gold , $type){

         //    $vebdor -> deposit_amount += $money ;
        //     $vebdor -> deposit_gold += $gold ;
        $supplier = Company::find($vendor_id);
        $movement = CompanyMovement::where('company_id' , '=' , $vendor_id) -> where('bill_id' , '=' , $bill_id)
            ->where('invoice_type' , '=' , $type) -> get() -> first();
        if($movement){
            $supplier -> deposit_amount -= $movement -> debit_money ;
            $supplier -> deposit_gold  -= $movement -> debit_gold ;
            $supplier -> update();
            $movement -> delete();
        }
    }

    public function item_stock(){
        $workWarehouses = WarehouseItem::where('type' , '=' , 1) ->get() -> groupBy('item_id') ;
        $oldWarehouses = WarehouseItem::where('type' , '=' , 0) -> get() -> groupBy('item_id') ;
  
        $work = $workWarehouses -> map(function ($item) {
            return [
                'enter' => $item -> sum('enter'),
                'out'=> $item -> sum('out'),
            ];
        });
        $old = $oldWarehouses -> map(function ($item) {
            return [
                'enter' => $item -> sum('enter'),
                'out'=> $item -> sum('out'),
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

        return view('admin.ItemsCollectible.item_stock' , compact('work' , 'old' , 'karats' , 'slag' , 'subSlag' ,'company' , 'period_ar' , 'period')) ;
    }

    public function makeItemsCollectibleUnAvailable($id){
        $item = ItemsCollectible::find($id);
        if($item){  
            $item -> state = 0 ;
            $item -> update();
         
        }
    }

    public function makeItemsCollectibleOkPurchase($id){
        $item = ItemsCollectible::find($id);
        if($item){  
            $item -> state = 1 ;
            $item -> update();
         
        }
    }
}
