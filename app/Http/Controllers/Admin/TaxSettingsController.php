<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaxSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaxSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = TaxSettings::all() -> first();  

        if(!isset($settings)){ 
            $settings = null ; 
        }

        return view('admin.tax.index' , compact('settings'));
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
                    'enabled' => 'required',
                    'value' => 'required',
                ]);

                TaxSettings::create([
                    'enabled' => $request -> enabled ,
                    'value' => $request -> value
                ]);

                return redirect() -> route('tax_settings') -> with('success' , __('main.created'));

            } else {
                return  $this -> update($request);
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaxSettings  $taxSettings
     * @return \Illuminate\Http\Response
     */
    public function show(TaxSettings $taxSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaxSettings  $taxSettings
     * @return \Illuminate\Http\Response
     */
    public function edit(TaxSettings $taxSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxSettings  $taxSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $setting = TaxSettings::find($request -> id);
        if($setting){
            $setting -> update([
                'enabled' => $request -> enabled ,
                'value' => $request -> value
            ]);
            return redirect() -> route('tax_settings') -> with('success' , __('main.updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaxSettings  $taxSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaxSettings $taxSettings)
    {
        //
    }
}
