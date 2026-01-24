<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Storehouse;
use App\Models\Branch;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StorehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storehouses = Storehouse::all(); 
        $branches = Branch::all();
        return view('admin.storehouses.index' , compact('storehouses','branches'));

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request -> id == 0){
            $validated = $request->validate([
                'code' => 'required|unique:storehouses',
                'name' => 'required',
            ]);
            try {
                Storehouse::create([
                    'code' => $request->code,
                    'name' => $request->name,
                    'phone' => $request->phone ? $request->phone : ' ' ,
                    'email' => $request->email ? $request->email : ' ',
                    'address' => $request->address ? $request->address : ' ',
                    'tax_number' => $request->tax_number ?? ' ',
                    'commercial_registration' => $request->commercial_registration ??  ' ',
                    'serial_prefix' => $request->serial_prefix ?? ' ',
                ]);
                return redirect()->route('warehouses')->with('success' , __('main.created'));
            } catch(QueryException $ex){

                return redirect()->route('warehouses')->with('error' ,  $ex->getMessage());
            }
        } else {
            return  $this -> update($request);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Storehouse  $storehouse
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehouse = Storehouse::find($id );
        echo json_encode ($warehouse);
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Storehouse  $storehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Storehouse $storehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Storehouse  $storehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $warehouse = Storehouse::find($request -> id);
        if($warehouse){
            $validated = $request->validate([
                'code' => ['required' , Rule::unique('storehouses')->ignore($request -> id)],
                'name' => 'required',
            ]);
            try {
                $warehouse -> update([
                    'code' => $request->code,
                    'name' => $request->name,
                    'phone' => $request->phone ? $request->phone : ' ' ,
                    'email' => $request->email ? $request->email : ' ',
                    'address' => $request->address ? $request->address : ' ',
                    'tax_number' => $request->tax_number ?? ' ',
                    'commercial_registration' => $request->commercial_registration ??  ' ',
                    'serial_prefix' => $request->serial_prefix ?? ' ',
                ]);
                return redirect()->route('warehouses')->with('success' , __('main.updated'));
            } catch(QueryException $ex){

                return redirect()->route('warehouses')->with('error' ,  $ex->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Storehouse  $storehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Storehouse $storehouse)
    {
        //
    }
}
