<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use App\Models\CompanyInfo;
use App\Models\ExchangeRate; 
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
        $stock_market = $this->Gold_Price_Api();
        $exchange = $this->exchange_rates_all();
 
        return  view('admin.Pricing.index' , compact('pricings','stock_market','exchange'))  ;
  
    }

    public function get_gold_stock_market_prices()
    {
        $pricings = Pricing::all();  
        $stock_market = $this->Gold_Price_Api();
        $exchange = $this->exchange_rates_all();
 
        return  view('admin.Pricing.StockMarket' , compact('pricings','stock_market','exchange'))  ;
  
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

    public function edit()
    {
        //$apiKey = "goldapi-2gvmslws3qxw2-io";
        $apiKey = "goldapi-3qf9kslxkzs02r-io";
        $symbol = "XAU";
        $curr = "USD";
        $date = "";
        
        $myHeaders = array(
            'x-access-token: ' . $apiKey,
            'Content-Type: application/json'
        );
        
        $curl = curl_init();
        
        $url = "https://www.goldapi.io/api/{$symbol}/{$curr}{$date}";
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => $myHeaders
        ));
        
        $response = curl_exec($curl);
        $error = curl_error($curl);
        
        curl_close($curl);
        
        if ($error) {
            echo 'Error: ' . $error;
        } else {
            $responseBody = json_decode($response);
        }

        $company = CompanyInfo::first();
        $exchange = $this->exchange_rates_api($company->currency_en);
        
        if(isset($responseBody->price)){  

            $price = $responseBody->price * $exchange; 

            $pricings = Pricing::all();
            foreach ($pricings as $pricing){
                $pricing -> delete();
            }
    
            Pricing::create([
                'last_Update' => Carbon::now(),
                'user_id' => Auth::user() -> id,
                'price' => $price,
                'price_24' => $responseBody->price_gram_24k  * $exchange ,
                'price_22' => $responseBody->price_gram_22k  * $exchange ,
                'price_21' => $responseBody->price_gram_21k  * $exchange ,  
                'price_18' => $responseBody->price_gram_18k  * $exchange ,
                'price_14' => $responseBody->price_gram_14k  * $exchange ,
                'currency' => $company->currency_en
            ]);
            
            return redirect() -> route('prices')->with('success' , __('main.price_updated'));

        }else{
            return redirect() -> route('prices')->with('success' , 'error open_ssl') ;
        }
 
    }

    public function edit_old()
    {

        $company = CompanyInfo::first();

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
 
        $currency_en = $this->exchange_rates_api($company->currency_en);
        
        if(isset($responseBody->gold)){  

            $price = $responseBody->gold * $currency_en;
            $price24 =  round((($responseBody->gold / 31.1035) * $currency_en), 2);

            $pricings = Pricing::all();
            foreach ($pricings as $pricing){
                $pricing -> delete();
            }
    
            Pricing::create([
                'last_Update' => Carbon::now(),
                'user_id' => Auth::user() -> id,
                'price' => $price,
                'price_24' => $price24,
                'price_22' => (22/24) * $price24,
                'price_21' => (21/24) * $price24,  
                'price_18' => (18/24) * $price24,
                'price_14' => (14/24) * $price24,
                'currency' => $company->currency_en
            ]);
            
            return redirect() -> route('prices')->with('success' , __('main.price_updated'));
        }else{ 
            return redirect() -> route('prices')->with('success' , 'لقد تجاوزت الحد المسموح لتحديث الاسعار عبر api') ;
        } 
 
    } 

    public function Gold_Price_Api()
    {
        //$apiKey = "goldapi-2gvmslws3qxw2-io";
        $apiKey = "goldapi-3qf9kslxkzs02r-io";
        $symbol = "XAU";
        $curr = "USD";
        $date = "";
        
        $myHeaders = array(
            'x-access-token: ' . $apiKey,
            'Content-Type: application/json'
        );
        
        $curl = curl_init();
        
        $url = "https://www.goldapi.io/api/{$symbol}/{$curr}{$date}";
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => $myHeaders
        ));
        
        $response = curl_exec($curl);
        $error = curl_error($curl);
        
        curl_close($curl);
        
        if ($error) {
            echo 'Error: ' . $error;
        } else {
            return json_decode($response); 
        }
 
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


    public function exchange_rates_api($currency)
    {
        
        // Fetching JSON
        $req_url = 'https://v6.exchangerate-api.com/v6/9660b3a5898caeedceffa427/latest/USD';
        $response_json = file_get_contents($req_url);
        
        // Continuing if we got a result
        if(false !== $response_json) {
        
            // Try/catch for json_decode operation
            try {
        
        		// Decoding
        		$response = json_decode($response_json);
        
        		// Check for success
        		if('success' === $response->result) {
        
        			// YOUR APPLICATION CODE HERE, e.g.
        			//$base_price = 12; // Your price in USD
        			//$EUR_price = round(($base_price * $response->conversion_rates->EUR), 2);
                    //
                    if($currency === 'SAR'){
                        return $response->conversion_rates->SAR;
                    }else if($currency === 'USD'){
                        return $response->conversion_rates->USD;
                    }else if($currency === 'YER'){
                        $exchange = ExchangeRate::orderBy('id', 'DESC')->limit(1)->first();
                        if(isset($exchange)){
                            return $exchange->conversion_rates;
                        }else{
                            return $response->conversion_rates->YER;
                        }
                        
                    }else{
                        return $response->conversion_rates->$currency;
                    } 
        		}
        
            }
            catch(Exception $e) {
                // Handle JSON parse error...
            }
        
        }
	
    }

  

    public function exchange_rates_all()
    {
        // Fetching JSON
        $req_url = 'https://v6.exchangerate-api.com/v6/9660b3a5898caeedceffa427/latest/USD';
        $response_json = file_get_contents($req_url);
        
        // Continuing if we got a result
        if(false !== $response_json) {
        
            // Try/catch for json_decode operation
            try {
        
        		// Decoding
        		$response = json_decode($response_json);
        
        		// Check for success
        		if('success' === $response->result) {
                    return $response ;
        		}
        
            }
            catch(Exception $e) {
                // Handle JSON parse error...
            }
        
        }

   }
}