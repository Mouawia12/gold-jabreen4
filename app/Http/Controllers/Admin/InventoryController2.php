<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\TaxSettings;
use App\Models\CompanyInfo;
use App\Models\ExitWorkDetails;
use App\Models\Item;
use App\Models\Item2;
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

class InventoryController2 extends Controller
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
    public function insert_private_inventory()
    { 
        $inventorys = Inventory::create([
            'date' => date('Y-m-d'),
            'state' => 1,
            'user_id' => Auth::user() -> id
        ])->id;  

        if($inventorys){
            
            $inventory_details = InventoryDetails::all();
 
            foreach($inventory_details as $inventory_detail){
                if(InventoryDetails::where('inventory_id',$inventorys)->where('item_id',$inventory_detail->item_id)->doesntExist()) {
                    if(Item::where('id',$inventory_detail->item_id)->where('weight','=',$inventory_detail->weight)->exists()) {
                        InventoryDetails::create([ 
                            'inventory_id' => $inventorys, 
                            'karat_id' => $inventory_detail->karat_id,
                            'item_id' => $inventory_detail->item_id,
                            'weight' => $inventory_detail->weight,
                            'new_weight' => $inventory_detail->new_weight ?? 0,
                            'state' => 1, 
                            'user_id' => Auth::user() -> id
                        ]);
                    }

                } 
               
            }
 
        }else{
            return 'not create Inventory';
        }
       
  

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventorys = Inventory::create([
            'date' => date('Y-m-d'),
            'state' => 1,
            'user_id' => Auth::user() -> id
        ])->id;  

        if($inventorys){
            
            $inventory_details = InventoryDetails::all();
 
            foreach($inventory_details as $inventory_detail){
                if(InventoryDetails::where('inventory_id',$inventorys)->where('item_id',$inventory_detail->item_id)->doesntExist()) {
                    InventoryDetails::create([ 
                        'inventory_id' => $inventorys, 
                        'karat_id' => $inventory_detail->karat_id,
                        'item_id' => $inventory_detail->item_id,
                        'weight' => $inventory_detail->weight,
                        'new_weight' => $inventory_detail->new_weight ?? 0,
                        'state' => 1, 
                        'user_id' => Auth::user() -> id
                    ]);
                }else{
                    $detail = InventoryDetails::where('inventory_id',$inventorys)->where('item_id',$inventory_detail->item_id)->first();
                    if(Item::where('id',$detail->item_id)->where('weight','=',$detail->weight)->exists()) {
                        $detail-> weight =  $inventory_detail->weight;
                        $detail-> new_weight = $inventory_detail->new_weight ?? 0;
                        $detail-> save();
                    }

                }
               
            }
 
        }else{
            return 'not create Inventory';
        }
       
  
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
        $inventorys = Inventory::where('id',$id) -> first();
        $inventory_details = InventoryDetails::where('inventory_id',$id) -> get();
        return view('admin.inventory.edite' , compact('inventorys' , 'inventory_details', 'karats' , 'setting' ));
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
        $inventorys = DB::table('inventory_details')->select('item_id')->where('inventory_id', $id);
 
        $items = Item::with('karat')
                            //->whereIn('user_id', $activeUsers)
                            ->whereNotIn('id', $inventorys)
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


    public function getItemPro($code)
    {
        $single = $this->getSingleItem($code);

        if ($single) {
            echo response()->json([$single]);
            exit;
        } else {
            $product = Item::where('item_type', '=', 2)
                ->where('code', 'like', '%' . $code . '%')
                ->orWhere('name_ar', 'like', '%' . $code . '%')
                ->limit(5)
                ->get();

            echo json_encode($product);
            exit;
        }

    }

    private function getSingleItem($code)
    {
        return Item::where('item_type', '=', 2)
            ->where('code', '=', $code)
            ->orWhere('name_ar', '=', $code)
            ->get()->first();
    }

    public function getProduct($code)
    {
        $inventory = Inventory::orderBy('id', 'ASC')->first();
        $price = Pricing::all()->first();
        $single = $this->getSingleProduct($code);
        if ($single) {
 
            $trans = $single->karat->transform_factor ; 
            $single->price = ($price->price_21 * $trans )+ $single->made_Value;
 
            $materials = ItemMaterials::where('item_id', '=', $single->id)->get();
            if (count($materials) == 0) {
                $single -> isChild = 0 ;
            } else {
                $single -> isChild = 1 ;
            }
            /*
            InventoryDetails::create([ 
                'inventory_id' =>  $inventory->id,
                'date' => date('Y-m-d'),
                'karat_id' => $single->karat_id,
                'item_id' => $single->id,
                'weight' => $single->weight,
                'new_weight' => 0,
                'state' => 1, 
                'user_id' => Auth::user() -> id
            ]);
            */
            echo json_encode([$single]);
            exit;

        } else {
             
            $product = Item::with('karat')
                ->where('code', 'like', '%' . $code . '%')
                ->where('state', 1)
                ->orWhere('name_ar', 'like', '%' . $code . '%')
                ->orWhere('name_en', 'like', '%' . $code . '%')
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

            echo   json_encode($data) ;
            exit;
        }

    }

    private function getSingleProduct($code)
    {
        return Item::with('karat')
            ->where('code', '=', $code)
            ->orWhere('name_ar', '=', $code)
            ->orWhere('name_en', '=', $code)
            ->get()->first();
    }

    public function getParentItem($id)
    {
        $item = Item::with('karat', 'category')->find($id);
        $allItems = Item::where('item_type', '=', 1)
            ->where('karat_id', '=', $item->karat_id)->get();
        $items = [];
        foreach ($allItems as $dd) {
            $materisal = ItemMaterials::where('item_id', '=', $dd->id)->get();
            if (count($materisal) == 0) {
                array_push($items, $dd);
            }
        }

        $data = DB::table('items')
            ->join('item_materials', 'item_materials.item_id', '=', 'items.id')
            ->join('categories', 'categories.id', '=', 'items.category_id')
            ->leftJoin('karats', 'karats.id', '=', 'items.karat_id')
            ->select('items.*', 'categories.name_ar as category_name_ar', 'categories.name_en as category_name_en',
                'karats.name_ar as karat_name_ar', 'karats.name_en as karat_name_en')
            ->where('item_materials.parent_id', '=', $id)
            ->orderByDesc('id')->get();

        $html = view('admin.Item.compineItem', compact('data', 'items', 'item'))->render();
        return $html;

    }

    public function compineItem(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'required',
            'item_id' => 'required',
        ]);

        ItemMaterials::create([
            'parent_id' => $request->parent_id,
            'item_id' => $request->item_id
        ]);
        $child =  Item::find($request->item_id);
        $parent = Item::find($request->parent_id);


        if($parent -> weight > 0){
            $oldWeight = $parent->weight ;
            $oldMade = $parent->made_Value;
            $totalMade = $oldWeight * $oldMade ;
            $parent->weight += $child->weight;
            $newMade = $totalMade + ($child->weight * $child->made_Value);
            $madeVal = $newMade / $parent->weight ;
          //  return $madeVal ;
            $parent->made_Value = $madeVal;
        } else {
            $parent->weight += $child->weight;
            $parent->made_Value += $child->made_Value;
        }

        $parent->update();

        return redirect()->route('items')->with('success', __('main.created'));;
    }

    public function print_barcode()
    {

        return view('admin.Item.print_barcode');
    }

    public function do_print_barcode(Request $request)
    {

        $data = [];
        foreach ($request->product_id as $index => $id) {
            $product = Item::with('karat')->find($id);
            $qnt = $request->qnt[$index];
            $item = [
                'quantity' => $qnt,
                'weight' => $request->weight == 1 ? $product->weight : false,
                'karat' => $request->karat == 1 ? $product->karat->label : false,
                'barcode' => $product->code,
                'name_ar' => $product->name_ar,
                'name_en' => $product->name_en

            ];

            $data[] = $item;
        }

        return view('admin.Item.print_barcode', compact('data'));
    }

    public function print_qrcode()
    {

        return view('admin.Item.print_qr');
    }


    public function do_print_qr(Request $request)
    {

        $data = [];
        foreach ($request->product_id as $index => $id) {
            $product = Item::with('karat')->find($id);
            $qnt = $request->qnt[$index];

            $text = $request->weight == 1 ? $product->weight . "\n" : '';
            $text .= $request->karat == 1 ? $product->karat . "\n" : '';
            $text .= $product->code;

            $item = [
                'quantity' => $qnt,
                'data' => $text,
                'name_ar' => $product->name_ar,
                'name_en' => $product->name_en,
            ];

            $data[] = $item;
        }

        return view('admin.Item.print_qr', compact('data'));
    }
 
    public function getItemCode()
    {
        $items = Item::orderBy('id', 'ASC')->get();
        if (count($items) > 0) {
            $id = (int)$items[count($items) - 1]->code;
        } else{
            $id = 0;
        }
            
        $no = json_encode(str_pad($id + 1, 6, '0', STR_PAD_LEFT));
        echo $no;
        exit;
    }
 
}
