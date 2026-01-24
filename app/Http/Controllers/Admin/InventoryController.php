<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\TaxSettings;
use App\Models\CompanyInfo;
use App\Models\ExitWorkDetails;
use App\Models\Item;
use App\Models\Branch;
use App\Models\ItemMaterials;
use App\Models\Karat;
use App\Models\Pricing; 
use App\Models\Inventory; 
use App\Models\InventoryDetails; 
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InventoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $inventorys = Inventory::orderBy('id', 'desc')
                        ->where('state',1)
                        ->get();                 
 
        return view('admin.inventory.index' , compact('inventorys'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Company::where('group_id' , '=' , 3) -> get();
        $suppliers = Company::where('group_id' , '=' , 4) -> get();
        $karats = Karat::all();
        $setting = TaxSettings::all()->first();
        $pricings = Pricing::all(); 
        $inventorys = Inventory::where('state',0) -> first();
        $branches = Branch::where('status',1)->get();

        if(!isset($inventorys)){
            $inventorys = Inventory::create([
                'date' => date('Y-m-d'), 
                'user_id' => Auth::user() -> id
            ]);
        }  

        return view('admin.inventory.create' , compact('inventorys', 'karats', 'setting','branches'));
    }

 

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        if ($item) {
            echo json_encode($item);
            exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customers =  Company::where('group_id' , '=' , 3) -> get();
        $suppliers =  Company::where('group_id' , '=' , 4) -> get();
        $karats = Karat::all();
        $setting = TaxSettings::all() -> first();
        $pricings = Pricing::all(); 
        $inventory = Inventory::where('id',$id) -> first();
        $inventory_details = InventoryDetails::where('inventory_id',$id) -> get();

        return view('admin.inventory.edite' , compact('inventory' , 'inventory_details', 'karats', 'setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       
    }

    public function inventory_state($id)
    {  
        $inventory = Inventory::where('id',$id) -> first();  
        $details = DB::table('inventory_details')->select('item_id')->where('inventory_id', $id);
 
        $items = Item::with('karat') 
                    ->whereNotIn('id', $details)
                    ->where('branch_id', $inventory->branch_id)
                    ->where('state', 1)
                    ->get();
  
        echo json_encode($items);
        exit;
    }

    public function inventory_weight_item(Request $request)
    {
 
        $item = Item::where('id',$request->id)
                    ->first();
        $inventorys = Inventory::where('state',0) -> first();   
            
        if(isset($item))  { 
            InventoryDetails::create([ 
                'inventory_id' =>  $request->inventory_id ?? 0, 
                'karat_id' => $request->karat ?? 0,
                'item_id' => $request->id ?? 0,
                'weight' => $request->weigth ?? 0,
                'new_weight' => 0,
                'state' => 1, 
                'user_id' => Auth::user() -> id
            ]);

            if($inventorys){
                $inventorys->update([ 
                    'branch_id' => $request->branch_id,
                    'state' => 1, 
                ]);
            }
        
        }          
   
    }

    public function update_weight_item(Request $request)
    {
        $item = Item::where('id',$request->id)
                    ->first();
        $inventory_details = InventoryDetails::where('inventory_id',$request->inventory_id)
                                ->where('item_id',$request->id)
                                ->first();
        if(isset($item) and $request->weigth_new>0)  {
             
            $item->update([
                'weight' => $request->weigth_new,
            ]);
          
            $inventory_details->update([  
                'new_weight' => $request->weigth_new ?? 0,
            ]);
        }          

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $inventorys = Inventory::where('id',$request->inventory_id) -> first();
        $inventory_details = InventoryDetails::where('inventory_id',$request->inventory_id)->where('new_weight',0) -> get();
 
        if($inventorys){ 
            
            if($inventory_details){
                foreach ($inventory_details as $inventory_detail) {
                    $detail = InventoryDetails::FindOrFail($inventory_detail->id);
                    $detail->delete();
                }
            }

            $inventorys->delete(); 

            return redirect()->route('admin.inventory.index')
                ->with('success', 'تم حذف الجرد بنجاح');
        } 
   
    }

    public function getProduct($branch_id,$code)
    {
        $inventory = Inventory::orderBy('id', 'ASC')->first();
        $price = Pricing::all()->first();
        $single = $this->getSingleProduct($branch_id,$code);

        if ($single) { 

            $trans = $single->karat->transform_factor ; 
            $single->price = ($price->price_21 * $trans )+ $single->made_Value;
            $materials = ItemMaterials::where('item_id', '=', $single->id)->get();
            if (count($materials) == 0) {
                $single -> isChild = 0 ;
            } else {
                $single -> isChild = 1 ;
            }
             
            echo json_encode([$single]);
            exit;

        } else {
             
            $product = Item::with('karat')
            ->where('branch_id',$branch_id)
            ->where('code', 'like', '%' . $code . '%')
            ->where('state', 1) 
            ->orWhere(function($query)use ($code,$branch_id) {
                $query->where('name_ar', 'like', '%' . $code . '%')
                  ->where('branch_id', $branch_id);
            }) 
            ->limit(5)
            ->get();
            
            $data = [];

            foreach ($product as $item) {
                if ($item->karat_id > 0) {
                    $trans = $item->karat->transform_factor ; 
                    $item->price = ($price->price_21 * $trans) + $item->made_Value; 
                }
                $materials = ItemMaterials::where('item_id', '=', $item->id)->get();
                if (count($materials) == 0) {
                    $item -> isChild = 0 ;
                } else {
                    $item -> isChild = 1 ;
                }
 
                
                array_push($data, $item);
            }

            echo json_encode($data) ;
            exit;
        }

    }

    private function getSingleProduct($branch_id,$code)
    {
        return Item::with('karat')
        ->where('branch_id', $branch_id)
        ->where('code', '=', $code)
        ->where('state', 1) 
        ->orWhere(function($query)use ($code,$branch_id) {
            $query->where('name_ar', '=', $code)
                  ->orWhere('name_en', '=', $code) 
                  ->where('branch_id', $branch_id);
        }) 
        ->first();
    }
 
}
