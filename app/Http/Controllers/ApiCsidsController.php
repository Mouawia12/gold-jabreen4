<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use stdClass;
use Illuminate\Http\Request;

class ApiCsidsController extends Controller
{
    private string $sandbox_url = 'https://gw-fatoora.zatca.gov.sa/e-invoicing/developer-portal';
    //private string $sandbox_url = 'https://gw-fatoora.zatca.gov.sa/e-invoicing/simulation';
    private string $version = 'V2';

    private function getAuthHeaders($certificate, $secret): array
    {
        if ($certificate && $secret) {

            $certificate_stripped = $this->cleanUpCertificateString($certificate);
            $certificate_stripped = base64_encode($certificate_stripped);
            $basic = base64_encode($certificate_stripped . ':' . $secret);

            return [
                "Authorization: Basic $basic",
            ];
        }
        return [];
    }

    public function compliance($certificate = NULL, $secret = NULL)
    {
        $auth_headers = $this->getAuthHeaders($certificate, $secret);

        $issueCertificate = function (string $csr, string $otp): stdClass {
            $headers = [
                'Accept-Version: ' . $this->version,
                'OTP: ' . $otp,
                'Content-Type: application/json'
            ];

            $curl = curl_init($this->sandbox_url . '/compliance');

            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode(['csr' => base64_encode($csr)]),
                CURLOPT_HTTPHEADER => $headers,
            ));

            $response = curl_exec($curl);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            $response = json_decode($response);
            if ($http_code != 200) throw new Exception('Error issuing a compliance certificate.');

            $issued_certificate = base64_decode($response->binarySecurityToken);
            $response->binarySecurityToken = "-----BEGIN CERTIFICATE-----\n{$issued_certificate}\n-----END CERTIFICATE-----";

            return $response;
        };

        
		$productionCsids = function (string $compliance_request_id) use ($auth_headers): stdClass {

            $headers = [
                'Accept-Version: ' . $this->version,
                'Accept-Language: en',
                'Content-Type: application/json',
            ];

            $curl = curl_init($this->sandbox_url . '/production/csids'); 

            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode([
                    'compliance_request_id' => $compliance_request_id, 
                ]),
                CURLOPT_HTTPHEADER => [...$headers, ...$auth_headers],
            ));

            $response = curl_exec($curl);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            $response = json_decode($response);

            //if ($http_code != 200) throw new Exception('Error in compliance check.');
            return $response;
        };

        return [$issueCertificate, $productionCsids];
    }

    public static function cleanUpCertificateString(string $certificate): string
    {
        $certificate = str_replace('-----BEGIN CERTIFICATE-----', '', $certificate);
        $certificate = str_replace('-----END CERTIFICATE-----', '', $certificate);

        return trim($certificate);
    }
}
