<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyInfo;
use App\Models\Item;
use App\Models\Karat;
use App\Models\Branch;
use App\Models\ExitWork;
use App\Models\ExitWorkDetails;
use App\Models\SimplifiedDebit;
use App\Models\SimplifiedDebitDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ZataCsidsControlle extends Controller
{ 
    public function index(){ 

        
        $egs = new EGSCsidsController();
        $egs->production = false; 

        $binary_security_token = $egs->get_Certificate();
        $private_key = $egs->get_PrivateKey();
        $secret = $egs->get_secret();
        
        $binarySecurityToken = "-----BEGIN CERTIFICATE-----\r\n{$binary_security_token}\r\n-----END CERTIFICATE-----";
        $compliance_request_id = '1234567890123' ;
      
        // Check invoice compliance
        #التحقق من امتثال الفاتورة
        $response = $egs->productionCsids($compliance_request_id, $binarySecurityToken, $secret);
        
		return $response;
    }
 
  
}
