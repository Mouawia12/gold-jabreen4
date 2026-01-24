<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CompanyInfo;
use App\Models\ExitWorkDetails;
use App\Models\ItemsCollectible; 
use App\Models\ItemMaterials;
use App\Models\Karat;
use App\Models\Pricing;  
use App\Models\Storehouse;
use App\Models\WarehouseProducts;
use App\Models\SaleCollectibleDetails;
use App\Models\PurchaseCollectibleDetails;
use App\Models\ProgramSetting;
use App\Models\Branch;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ItemCollectibleController extends Controller
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
        $categories = Category::all();
        $karats = Karat::all();
        $data = DB::table('items_collectibles')
            ->join('categories', 'categories.id', '=', 'items_collectibles.category_id')
            ->leftJoin('karats', 'karats.id', '=', 'items_collectibles.karat_id')
            ->select('items_collectibles.*', 'categories.name_ar as category_name_ar', 'categories.name_en as category_name_en'
            ,'karats.name_ar as karat_name_ar', 'karats.name_en as karat_name_en')
            ->orderByDesc('id')
            ->get();

        if (!empty(Auth::user()->branch_id)) {
            $data = $data->where('branch_id', Auth::user()->branch_id); 
        }  
    
 
        $branches = Branch::where('status',1)->get(); 

        return view('admin.ItemsCollectible.index', compact('data', 'categories', 'karats','branches'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->id == 0) {
       
            $validated = $request->validate([
                'code' => 'required|unique:items_collectibles',
                'name_ar' => 'required',
                'category_id' => 'required', 
                'branch_id' => 'required',
                'weight' => 'required',
                'taxx' => 'required',

            ]);

            if ($request->has('img')) {
                if ($request->file('img')->getSize() / 1000 > 2000) {
                    return redirect()->route('items.collectibles')->with('error', __('main.img_big'));
                }
                $imageName = time() . '.' . $request->img->extension();
                $request->img->move(('uploads/items/images'), $imageName);
            } else {
                $imageName = '';
            }

            if ($request->has('att_file')) {
                if ($request->file('att_file')->getSize() / 1000 > 2000) {
                    return redirect()->route('items.collectibles')->with('error', __('main.img_big'));
                }
                $fileName = time() . '.' . $request->att_file->extension();
                $request->att_file->move(('uploads/items/files'), $fileName);
            } else {
                $fileName = '';
            }
 
            try {

                $product = ItemsCollectible::create([
                    'code' => $request->code,
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en != null ? $request->name_en : ' ',
                    'category_id' => $request->category_id,
                    'branch_id' => $request->branch_id,
                    'karat_id' => $request->karat_id ?? 0,
                    'weight' => $request->weight,
                    'no_metal' => $request->no_metal ?? 0,
                    'no_metal_type' => $request->no_metal_type ?? 0,
                    'made_Value' => $request->made_Value ?? 0,
                    'item_type' => $request->item_type ?? 1,
                    'brand' => $request->brand ?? '',
                    'stone_type' => $request->stone_type ?? '',
                    'stone_purity' => $request->stone_purity ?? '',
                    'stone_color' => $request->stone_color ?? '',
                    'stone_size' => $request->stone_size ?? 0,
                    'metal_weight' => $request->metal_weight ?? 0,
                    'other_properties1' => $request->other_properties1 ?? '',
                    'other_properties2' => $request->other_properties2 ?? '',
                    'other_properties3' => $request->other_properties3 ?? '',
                    'tax' => $request->taxx ?? 0, 
                    'img' => $imageName ?? ' ',
                    'att_file' => $fileName ?? ' ',
                    'price' => $request->price ?? 0,
                    'cost' => $request->cost ?? 0,
                    'user_id' => Auth::user() -> id
                ]);
     

                if ($request->item_type == 2) {
                    $warehouses = Storehouse::all();
                    foreach ($warehouses as $warehouse) {
                        WarehouseProducts::create([ 
                            'warehouse_id' => $warehouse->id,
                            'branch_id' => $warehouse->branch_id,
                            'product_id' => $product->id,
                            'cost' => $product->cost,
                            'quantity' => 0
                        ]);
                    }
                }


                return redirect()->route('items.collectibles')->with('success', __('main.created'));

            } catch (QueryException $ex) { 
                return redirect()->route('items.collectibles')->with('error', $ex->getMessage());
            }
        } else {  
            return $this->update($request);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = ItemsCollectible::find($id);
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
    public function edit(Item $item)
    {
        //
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
        $item = ItemsCollectible::find($request->id);
        if ($item) {
            $old_weight = $item->weight;
            if ($item->item_type == 3) {
                $validated = $request->validate([
                    'code' => ['required', Rule::unique('items_collectibles')->ignore($request->id)],
                    'name_ar' => 'required',
                    'category_id' => 'required', 
                    'branch_id' => 'required', 
                    'weight' => 'required', 
                    'taxx' => 'required',
                ]);
            } 

            if ($request->img) {
                if ($request->file('img')->getSize() / 1000 < 2000) {
                    $imageName = time() . '.' . $request->img->extension();
                    $request->img->move(('uploads/items/images/'), $imageName);

                } else {
                    return redirect()->route('items.collectibles')->with('error', __('main.img_big'));
                }

            } else {
                $imageName = $item->img;
            }

            try {
                $item->update([
                    'code' => $request->code,
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en != null ? $request->name_en : ' ',
                    'category_id' => $request->category_id,
                    'branch_id' => $request->branch_id,
                    'karat_id' => $request->karat_id ?? 0, 
                    'made_Value' => $request->made_Value ?? 0,
                    'item_type' => $request->item_type ?? 3,
                    'brand' => $request->brand ?? '',
                    'stone_type' => $request->stone_type ?? '',
                    'stone_purity' => $request->stone_purity ?? '',
                    'stone_color' => $request->stone_color ?? '',
                    'stone_size' => $request->stone_size ?? '', 
                    'other_properties1' => $request->other_properties1 ?? '',
                    'other_properties2' => $request->other_properties2 ?? '',
                    'other_properties3' => $request->other_properties3 ?? '',   
                    'img' => $imageName,
                    'user_id' => Auth::user() -> id
                ]);
 
                return redirect()->route('items.collectibles')->with('success', __('main.updated'));

            } catch (QueryException $ex) {
                return redirect()->route('items.collectibles')->with('error', $ex->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = ItemsCollectible::find($id);
        if ($item) {
            $sales = SaleCollectibleDetails::where('item_id', '=', $id)-> get();
            $purchase = PurchaseCollectibleDetails::where('item_id', '=', $id)-> get();  

            if (count($sales) == 0 && count($purchase) == 0) {
                $item->delete();
                return redirect()->route('items.collectibles')->with('success', __('main.deleted'));
            } else {
                return redirect()->route('items.collectibles')->with('success', __('لايمكن حذف صنف مرتبط بحركة مشتريات او مبيعات'));
            }

        } else {
            return redirect()->route('items.collectibles')->with('success', __('main.can_not_delete_item'));
        }

    } 

    public function getItemPro($code)
    {
        $single = $this->getSingleItem($code);

        if ($single) { 
            echo response()->json([$single]);
            exit; 
        } else {
            $product = ItemsCollectible::where('item_type', '=', 2)
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
        return ItemsCollectible::where('item_type', '=', 2)
            ->where('code', '=', $code)
            ->orWhere('name_ar', '=', $code)
            ->get()->first();
    }

    public function getProduct($code,$branch_id)
    {
        $price = Pricing::all()->first();
        $setting = ProgramSetting::first();
        $single = $this->getSingleProduct($code,$branch_id,$setting->items);

        if ($single) {
            $trans = $single->karat->transform_factor ; 
            $single->price = 0;
            $materials = ItemMaterials::where('item_id', '=', $single->id)->get();
            if (count($materials) == 0) {
                $single -> isChild = 0 ;
                echo json_encode([$single]);
                exit;
            } else {
                $single -> isChild = 1 ;
                echo json_encode([$single]);
                exit;
            }


        } else {
            if ($setting-> items == 1) {
                $product = ItemsCollectible::with('karat')
                    ->where('branch_id',$branch_id)
                    ->where('code', 'like', '%' . $code . '%')
                    ->where('state', 1)
                    ->orWhere(function($query)use ($code,$branch_id) {
                        $query->where('name_ar', 'like', '%' . $code . '%')
                          ->where('branch_id', $branch_id);
                    }) 
                    ->limit(5)
                    ->get();

            }else{
                $product = ItemsCollectible::with('karat')
                    ->where('code', 'like', '%' . $code . '%')
                    ->where('state', 1)
                    ->orWhere('name_ar', 'like', '%' . $code . '%')
                    ->orWhere('name_en', 'like', '%' . $code . '%')
                    ->limit(5)
                    ->get();
            }

            
            $data = [];

            foreach ($product as $item) {
                if ($item->karat_id > 0) {
                    $trans = $item->karat->transform_factor ; 
                    $item->price = 0; 
                }
                $materials = ItemMaterials::where('item_id', '=', $item->id)->get();
                if (count($materials) == 0) {
                    $item -> isChild = 0 ;
                    array_push($data, $item);
                } else {
                    $item -> isChild = 1 ;
                    array_push($data, $item);
                }
            }


            echo   json_encode($data) ;
            exit;
        }

    }

    private function getSingleProduct($code,$branch_id,$type)
    {
        if ($type == 1) {
            return ItemsCollectible::with('karat')
                ->where('branch_id', $branch_id)
                ->where('code', '=', $code)
                ->where('state', 1) 
                ->orWhere(function($query)use ($code,$branch_id) {
                    $query->where('name_ar', '=', $code)
                          ->orWhere('name_en', '=', $code) 
                          ->where('branch_id', $branch_id);
                }) 
                ->first();
        }else{
            return ItemsCollectible::with('karat')
                ->where('code', '=', $code)
                ->orWhere('name_ar', '=', $code)
                ->orWhere('name_en', '=', $code)
                ->get()->first();

        }

    }

    public function getParentItem($id)
    {
        $item = ItemsCollectible::with('karat', 'category')->find($id);
        $allItems = ItemsCollectible::where('item_type', '=', 1)
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

        $html = view('admin.ItemsCollectible.compineItem', compact('data', 'items', 'item'))->render();
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
        $child =  ItemsCollectible::find($request->item_id);
        $parent = ItemsCollectible::find($request->parent_id);


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

        return redirect()->route('items.collectibles')->with('success', __('main.created'));;
    }

    public function print_barcode()
    {

        return view('admin.ItemsCollectible.print_barcode');
    }

    public function do_print_barcode(Request $request)
    {

        $data = [];
        foreach ($request->product_id as $index => $id) {
            $product = ItemsCollectible::with('karat')->find($id);
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

        return view('admin.ItemsCollectible.print_barcode', compact('data'));
    }

    public function print_qrcode()
    {

        return view('admin.ItemsCollectible.print_qr');
    }


    public function do_print_qr(Request $request)
    {

        $data = [];
        foreach ($request->product_id as $index => $id) {
            $product = ItemsCollectible::with('karat')->find($id);
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

        return view('admin.ItemsCollectible.print_qr', compact('data'));
    }

    public function printBarcode($id)
    {
        $item = ItemsCollectible::with('karat')->find($id);
        $company = CompanyInfo::all() -> first();
        $html = view('admin.ItemsCollectible.barcode', compact('item' , 'company'));

        return $html;
    }

    public function getItemCode()
    {
        $items = ItemsCollectible::orderBy('id', 'ASC')->get();
        if (count($items) > 0) {
            $id = (int)$items[count($items) - 1]->code;
        } else{
            $id = 0;
        }
            
        $no = json_encode(str_pad($id + 1, 6, '0', STR_PAD_LEFT));
        echo $no;
        exit;
    }

    public function deleteItemMaterial($id)
    {
        $material = ItemMaterials::where('item_id', '=', $id)->get()->first();
        $item = ItemsCollectible::find($material->parent_id);
        if ($item->state == 1) {
            $child = ItemsCollectible::find($id);
            $item->weight -= $child->weight;
            $item->made_Value -= $child->made_Value;
            $item->update();
            $material->delete();
        }

        return redirect()->route('items.collectibles')->with('success', __('main.deleted'));
    }

    public function deletePosItemMaterial($item_code){
        $item = ItemsCollectible::where('code' , '=' , $item_code) -> first();
        if($item){
            $material = ItemMaterials::where('item_id', '=', $item -> id)->get()->first();
            if($material){
                $material -> delete();
                echo json_encode('deleted');

                exit();
            }
        }

    }



    public function fixItems()
    {
        $parents = ItemsCollectible::where('item_type', '=', 3)->get();
        $parents_toFix = [];

        foreach ($parents as $parent) {
            $childs = DB::table('items')
                ->join('item_materials', 'item_materials.item_id', '=', 'items.id')
                ->select('items.*')
                ->where('items.item_type', '=', 1)
                ->where('item_materials.parent_id', '=', $parent -> id)
                ->get();
            $parent -> childs =  $childs ;

        }


        foreach ($parents as $p){

            $mt = 0 ;
            $wt = 0 ;
            foreach ($p -> childs as $child) {
                $mt += ( $child -> made_Value  * $child -> weight  );
                $wt = $p -> weight ;
            }

               // array_push($parents_toFix , $p);
                $par = ItemsCollectible::find($p -> id);
                $par -> made_Value = ($mt / $wt) ;
                $par -> update();



        }

        //$parents = ItemsCollectible::where('item_type', '=', 3)->get();
        return $parents;



    }

    public function lost_barcode(){
 
        return view('admin.ItemsCollectible.lostBarcode');
    }

    public function lost_barcode_search($weight){
        $items = DB::table('items')
            ->join('categories', 'categories.id', '=', 'items.category_id')
            ->leftJoin('karats', 'karats.id', '=', 'items.karat_id')
            ->select('items.*', 'categories.name_ar as category_name_ar', 'categories.name_en as category_name_en',
                'karats.name_ar as karat_name_ar', 'karats.name_en as karat_name_en')
             -> where('items.weight' , '=' ,$weight )
            ->orderByDesc('id')->get();

        echo json_encode($items);
        exit();
    }
}
