<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pricings = Pricing::all();  
        return  view('admin.Pricing.index' , compact('pricings'))  ;
    }

    public function pricing(){

        $pricings = Pricing::all();
        if(count($pricings) == 0){
            return $this -> updatePricng() ;
        }
        $pricings = $pricings -> first();

        return  view('admin.welcome' , compact('pricings'))  ;

    }
    
    public function updatePricng(){

        $apiURL = 'https://gold-price-live.p.rapidapi.com/get_metal_prices';
        $client = new \GuzzleHttp\Client([ 'verify' => false , 'headers' => ['X-RapidAPI-Key' => '9e8093f608msh0f02470f904a42bp1b7dc1jsn58dcc8e943fb' , 'X-RapidAPI-Host' => 'gold-price-live.p.rapidapi.com']]);
        $response = $client->request('GET', $apiURL);
        $responseBody = json_decode($response->getBody(), true);
        $price21 = $responseBody['gold'] ;
        $price24 = (24/21) * $price21 ; // / 31.1035 ;
        $price = $price24 * 31.1035;

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        Pricing::create([
            'last_Update' => Carbon::now(),
            'user_update' => Auth::user() ? Auth::user() -> id : 0,
            'price' => $price,
            'price_21' => $price21,
            'price_22' => (22/21) * $price21,
            'price_24' => $price24,
            'price_18' => (18/21) * $price21,
            'price_14' => (14/21) * $price21,
            'currency' =>  file_get_contents('https://ipapi.co/currency/' , false , stream_context_create($arrContextOptions))

            ]);

        $pricings = Pricing::all() -> first();

        return  view('admin.welcome' , compact('pricings'))  ;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function show(Pricing $pricing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        /*
        $apiURL = 'https://gold-price-live.p.rapidapi.com/get_metal_prices';

        $client = new \GuzzleHttp\Client(['headers' => ['X-RapidAPI-Key' => '9e8093f608msh0f02470f904a42bp1b7dc1jsn58dcc8e943fb' , 'X-RapidAPI-Host' => 'gold-price-live.p.rapidapi.com']]);
        $response = $client->request('GET', $apiURL);
        $responseBody = json_decode($response->getBody(), true);
        $price21 = $responseBody['gold'] ;
        */ 
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://gold-price-live.p.rapidapi.com/get_metal_prices',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'X-RapidAPI-Key: 9e8093f608msh0f02470f904a42bp1b7dc1jsn58dcc8e943fb',
            'X-RapidAPI-Host: gold-price-live.p.rapidapi.com'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        $responseBody = json_decode($response);

        if(isset($responseBody)){

            $price21 = $responseBody->gold / 8;
            $price24 = (24/21) * $price21 ; // / 31.1035 ;
            $price = $price24 * 31.1035;
            $pricings = Pricing::all();

            foreach ($pricings as $pricing){
                $pricing -> delete();
            }

            Pricing::create([
                'last_Update' => Carbon::now(),
                'user_id' => Auth::user() -> id,
                'price' => $price,
                'price_21' => $price21,
                'price_22' => (22/21) * $price21,
                'price_24' => $price24,
                'price_18' => (18/21) * $price21,
                'price_14' => (14/21) * $price21,
                'currency' =>  file_get_contents('https://ipapi.co/currency/' , false , stream_context_create($arrContextOptions))
    
            ]);
            
            return redirect() -> route('prices')->with('success' , __('main.price_updated')) ;

        }else{
            
            return redirect() -> route('prices')->with('success' , 'هناك مشكلة في الربط بسبب شهادة ssl') ;
        }

       // return  view('Pricing.index' , compact('pricings')) ->with('success' , __('main.price_updated')) ;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $price21 = $request -> price21 ;
        $price24 = (24/21) *  $request -> price21 ;
        $price = $price24 * 31.1035;

        $pricings = Pricing::all();
        foreach ($pricings as $pricing){
            $pricing -> delete();
        }

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        Pricing::create([
            'last_Update' => Carbon::now(),
            'user_id' => Auth::user() -> id,
            'price' => $price,
            'price_21' => $price21,
            'price_22' => (22/21) * $price21,
            'price_24' => $price24,
            'price_18' => (18/21) * $price21,
            'price_14' => (14/21) * $price21,
            //'currency' =>  file_get_contents('https://ipapi.co/currency/' , false , stream_context_create($arrContextOptions))
            'currency' => 'SAR'

        ]);

        return redirect() -> route('prices')->with('success' , __('main.price_updated')) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pricing $pricing)
    {
        //
    }

}
