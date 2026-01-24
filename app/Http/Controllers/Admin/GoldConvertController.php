<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoldConvertItems;
use App\Models\GoldConvert;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CompanyInfo;


class GoldConvertController extends WarehouseController
{

    public function index()
    {
        $data = GoldConvert::all();
  
        return view('admin.GoldConvert.index' , compact('data' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.GoldConvert.Create');
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
            'doc_number' => 'required|unique:gold_converts',
        ]);
        $items = array();
        if(count($request -> item_id)){
            $total = 0 ;
            for($i = 0 ; $i < count($request -> item_id) ; $i++ ){
                $item =[
                    'docId' => 0,
                    'item_id' => $request -> item_id[$i],
                    'karat_id' => $request -> karat_id[$i],
                    'weight' => $request -> weight[$i],
                    'weight21' => $request -> weight21[$i]
                ];
                $total += $request -> weight21[$i] ;
                $items[] = $item ;
            }

            $id =  GoldConvert::create([
                'doc_number' => $request -> doc_number,
                'date' => $request -> date,
                'total21weight' => $total,
                'notes' => $request -> notes ?? '',
                'user_id' => Auth::user() -> id
            ]) -> id;

            foreach ($items as $product){
                $product['docId'] = $id;
                GoldConvertItems::create($product) ;
                $this -> syncQnt(1 , $product['karat_id'], $id , $product['weight'] , -1 );
                $this -> syncQnt(0 , $product['karat_id'], $id , $product['weight'] , 1 );
                $item = Item::find($product['item_id']);
                $item -> state == 2 ;
                $item -> update();
            }
            return redirect()->route('gold_convert_doc')->with('success' ,  __('main.created'));


        } else {
            return redirect()->route('gold_convert_doc')->with('error' ,  __('main.nodetails'));

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GoldConvert  $goldConvert
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = GoldConvert::find($id);
        $details = GoldConvertItems::where('item_id' , '=' , $id) -> get();


        $details   =  DB::table('gold_convert_items')
            -> join('items' , 'items.id' , '=' , 'gold_convert_items.item_id')
            -> join('karats' , 'karats.id' , '=' , 'gold_convert_items.karat_id')
            -> select('gold_convert_items.*' , 'karats.name_ar as karat_ar' , 'karats.name_en as karat_en' ,   'items.name_ar as item_ar' , 'items.name_en as item_en')
            -> where('gold_convert_items.docId' , '=' , $id)
           -> get();


         $company = CompanyInfo::all() -> first();

        return view('admin.GoldConvert.view' , compact( 'data' , 'details' , 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GoldConvert  $goldConvert
     * @return \Illuminate\Http\Response
     */
    public function edit(GoldConvert $goldConvert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GoldConvert  $goldConvert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoldConvert $goldConvert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GoldConvert  $goldConvert
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoldConvert $goldConvert)
    {
        //
    }

    public function get_gold_convert_no(){
        $bills = GoldConvert::orderBy('id', 'ASC')->get();
        if(count($bills) > 0){
            $id = $bills[count($bills) -1] -> id ;
        } else
            $id = 0 ;
        $prefix = "GC-";
        $no = json_encode($prefix . str_pad($id + 1, 6 , '0' , STR_PAD_LEFT)) ;
        echo $no ;
        exit;
    }
}
