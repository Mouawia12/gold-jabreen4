<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DOMDocument;
use Illuminate\Http\Request;

class EGSController extends Controller
{
    private $egs_info;
    private $api;
    public bool $production = false;

    public function __construct(array $egs_info)
    { 
        $this->egs_info = $egs_info;
        $this->api = new ApiController();
    }

    public function get_CSR()
    {
        $csr ="-----BEGIN CERTIFICATE REQUEST-----
        MIIDKDCCAs4CAQAwggF7MXgwdgYDVQQDDG/DmMKxw5nCiMOYwqfDmMKmw5jCuSDD
        mMKnw5nChMOZwoXDmMKnw5jCs8OZworDmMKpIMOZwoTDmcKEw5jCsMOZwofDmMKo
        IMOZwojDmMKnw5nChMOZwoXDmMKsw5nCiMOZwofDmMKxw5jCp8OYwqoxCzAJBgNV
        BAYTAlNBMXgwdgYDVQQLDG/DmMKxw5nCiMOYwqfDmMKmw5jCuSDDmMKnw5nChMOZ
        woXDmMKnw5jCs8OZworDmMKpIMOZwoTDmcKEw5jCsMOZwofDmMKoIMOZwojDmMKn
        w5nChMOZwoXDmMKsw5nCiMOZwofDmMKxw5jCp8OYwqoxeDB2BgNVBAoMb8OYwrHD
        mcKIw5jCp8OYwqbDmMK5IMOYwqfDmcKEw5nChcOYwqfDmMKzw5nCisOYwqkgw5nC
        hMOZwoTDmMKww5nCh8OYwqggw5nCiMOYwqfDmcKEw5nChcOYwqzDmcKIw5nCh8OY
        wrHDmMKnw5jCqjBWMBAGByqGSM49AgEGBSuBBAAKA0IABKhx+uOzLXXYrI8+0y++
        I7ozXtBRoayjZ3O+NqsPP5iPY+SqwxpYKQnUolvud6chuQPxyli8N9FN0Cs/w1Fh
        zcOggfEwge4GCSqGSIb3DQEJDjGB4DCB3TAhBgkrBgEEAYI3FAIEFBMSWkFUQ0Et
        Q29kZS1TaWduaW5nMIG3BgNVHREEga8wgaykgakwgaYxITAfBgNVBAQMGDEtQVND
        fDItVjAxfDMtMTIzNDU2Nzg5MDEfMB0GCgmSJomT8ixkAQEMDzMxMTQ3NDI3NDgw
        MDAwMzENMAsGA1UEDAwEMTEwMDE/MD0GA1UEGgw2w5jCp8OZwoTDmMKxw5nCisOY
        wqfDmMK2IMOYwrPDmcKIw5nCgiDDmMK3w5nCisOYwqjDmMKpMRAwDgYDVQQPDAdK
        ZXdlbHJ5MAoGCCqGSM49BAMCA0gAMEUCIQDC07XV1uWTazZCxiUSXj7GSG80QNx3
        QbEKjs5xX1GbtwIgCsFCWeUZvyDQq/pICf7saZWe7OBgHd6ULxz7DgOnjAI=
        -----END CERTIFICATE REQUEST-----";

        return $csr;
    }

    public function get_PrivateKey()
    {
        $PrivateKey ="-----BEGIN EC PRIVATE KEY-----
        MHQCAQEEIM4KxjiABRosCVLYFSdDhtECaGAOK8RCkyM0ImBJ/yZkoAcGBSuBBAAK
        oUQDQgAEqHH647Mtddisjz7TL74jujNe0FGhrKNnc742qw8/mI9j5KrDGlgpCdSi
        W+53pyG5A/HKWLw30U3QKz/DUWHNww==
        -----END EC PRIVATE KEY-----";

        return $PrivateKey;
    }

    public function get_PublickKey()
    {
        $PublickKey ="-----BEGIN PUBLIC KEY-----
        MFYwEAYHKoZIzj0CAQYFK4EEAAoDQgAEqHH647Mtddisjz7TL74jujNe0FGhrKNn
        c742qw8/mI9j5KrDGlgpCdSiW+53pyG5A/HKWLw30U3QKz/DUWHNww==
        -----END PUBLIC KEY-----";

        return $PublickKey;
    }

    public function get_Certificate()
    {
        $Certificate ="MIIDTzCCAvWgAwIBAgIGAY9oYULbMAoGCCqGSM49BAMCMBUxEzARBgNVBAMMCmVJbnZvaWNpbmcwHhcNMjQwNTExMTU1OTEwWhcNMjkwNTEwMjEwMDAwWjCCAXsxeDB2BgNVBAMMb8OYwrHDmcKIw5jCp8OYwqbDmMK5IMOYwqfDmcKEw5nChcOYwqfDmMKzw5nCisOYwqkgw5nChMOZwoTDmMKww5nCh8OYwqggw5nCiMOYwqfDmcKEw5nChcOYwqzDmcKIw5nCh8OYwrHDmMKnw5jCqjELMAkGA1UEBhMCU0ExeDB2BgNVBAsMb8OYwrHDmcKIw5jCp8OYwqbDmMK5IMOYwqfDmcKEw5nChcOYwqfDmMKzw5nCisOYwqkgw5nChMOZwoTDmMKww5nCh8OYwqggw5nCiMOYwqfDmcKEw5nChcOYwqzDmcKIw5nCh8OYwrHDmMKnw5jCqjF4MHYGA1UECgxvw5jCscOZwojDmMKnw5jCpsOYwrkgw5jCp8OZwoTDmcKFw5jCp8OYwrPDmcKKw5jCqSDDmcKEw5nChMOYwrDDmcKHw5jCqCDDmcKIw5jCp8OZwoTDmcKFw5jCrMOZwojDmcKHw5jCscOYwqfDmMKqMFYwEAYHKoZIzj0CAQYFK4EEAAoDQgAEqHH647Mtddisjz7TL74jujNe0FGhrKNnc742qw8/mI9j5KrDGlgpCdSiW+53pyG5A/HKWLw30U3QKz/DUWHNw6OByzCByDAMBgNVHRMBAf8EAjAAMIG3BgNVHREEga8wgaykgakwgaYxITAfBgNVBAQMGDEtQVNDfDItVjAxfDMtMTIzNDU2Nzg5MDEfMB0GCgmSJomT8ixkAQEMDzMxMTQ3NDI3NDgwMDAwMzENMAsGA1UEDAwEMTEwMDE/MD0GA1UEGgw2w5jCp8OZwoTDmMKxw5nCisOYwqfDmMK2IMOYwrPDmcKIw5nCgiDDmMK3w5nCisOYwqjDmMKpMRAwDgYDVQQPDAdKZXdlbHJ5MAoGCCqGSM49BAMCA0gAMEUCIQDaBc285QiyQpce86SkNmNp7lhQYq+TIt7slOPOxT+AVAIgZUYgOe3GD/yRJD3GPVJshwKo9rOBqFP83W0YIml7atE=";
        
        return $Certificate;
    }

    public function get_secret()
    {
        $Certificate ="In3BsdUEGKCzHK6o/r+RDQSxnLKXQMvd56ed8Lh/QzQ=";
        
        return $Certificate;
    }

    public function generateNewKeysAndCSR(string $solution_name)
    {
        $private_key = $this->generateSecp256k1KeyPair();

        return [$private_key, $this->generateCSR($solution_name, $private_key)];
    }

    private function generateSecp256k1KeyPair()
    {
        $private_key = $this->get_PrivateKey(); 
        
        return trim($private_key);
    }

    private function generateCSR(string $solution_name, $private_key)
    {
        $csr = $this->get_CSR();  
        
        return $csr;
    }

    public static function uuid(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public function issueComplianceCertificate(string $otp, $csr): array
    {
        if (!$csr) throw new Exception('EGS needs to generate a CSR first.');

        list($issueCertificate, $checkInvoiceCompliance) = $this->api->compliance();
        $issued_data = $issueCertificate($csr, $otp);

        return [$issued_data->requestID, $issued_data->binarySecurityToken, $issued_data->secret];
    }

    public function signInvoice(array $invoice, array $egs_unit, string $certificate, string $private_key, $type): array
    {
        
        if($type == 1){
            $zatca_simplified_tax_invoice = new ZATCASimplifiedTaxInvoiceController();
        }else{
            $zatca_simplified_tax_invoice = new ZATCAStandardTaxInvoiceController(); 
        }
      
        //1- تعبئة بيانات الفاتورة
        $invoice_xml = $zatca_simplified_tax_invoice->simplifiedTaxInvoice($invoice, $egs_unit);
		
        //2- عمل hash لمعلومات الفاتورة
        $invoice_hash = $zatca_simplified_tax_invoice->getInvoiceHash($invoice_xml);
		
        //3-اضافة الشهادة
        list($hash, $issuer, $serialNumber, $public_key, $signature)
            = $zatca_simplified_tax_invoice->getCertificateInfo($certificate);

        $digital_signature = $zatca_simplified_tax_invoice->createInvoiceDigitalSignature($invoice_hash, $private_key);

        $qr = $zatca_simplified_tax_invoice->generateQR(
            $invoice_xml,
            $digital_signature,
            $public_key,
            $signature,
            $invoice_hash
        );

        $signed_properties_props = [
            'sign_timestamp' => date('Y-m-d\TH:i:s'),
            'certificate_hash' => $hash, // SignedSignatureProperties/SigningCertificate/CertDigest/<ds:DigestValue>SET_CERTIFICATE_HASH</ds:DigestValue>
            'certificate_issuer' => $issuer,
            'certificate_serial_number' => $serialNumber
        ];
		
        $ubl_signature_signed_properties_xml_string_for_signing = $zatca_simplified_tax_invoice->defaultUBLExtensionsSignedPropertiesForSigning($signed_properties_props);
        $ubl_signature_signed_properties_xml_string = $zatca_simplified_tax_invoice->defaultUBLExtensionsSignedProperties($signed_properties_props);

        $signed_properties_hash = base64_encode(openssl_digest($ubl_signature_signed_properties_xml_string_for_signing, 'sha256'));

        // UBL Extensions
            $ubl_signature_xml_string = $zatca_simplified_tax_invoice->defaultUBLExtensions(
            $invoice_hash, // <ds:DigestValue>SET_INVOICE_HASH</ds:DigestValue>
            $signed_properties_hash, // SignatureInformation/Signature/SignedInfo/Reference/<ds:DigestValue>SET_SIGNED_PROPERTIES_HASH</ds:DigestValue>
            $digital_signature,
            $certificate,
            $ubl_signature_signed_properties_xml_string
        );
        // Set signing elements
        $unsigned_invoice_str = $invoice_xml->saveXML();

        $unsigned_invoice_str = str_replace('SET_UBL_EXTENSIONS_STRING', $ubl_signature_xml_string, $unsigned_invoice_str);
        $unsigned_invoice_str = str_replace('SET_QR_CODE_DATA', $qr, $unsigned_invoice_str);

        $signed_invoice = new DOMDocument();
        $signed_invoice->loadXML($unsigned_invoice_str);

        $signed_invoice_string = $signed_invoice->saveXML();
        //$signed_invoice_string = $zatca_simplified_tax_invoice->signedPropertiesIndentationFix($signed_invoice_string);

        $signed_invoice->save('uploads/invoice/simplified/'.$invoice['invoice_serial_number'].'.xml'); // save as file

        return [$signed_invoice_string, $invoice_hash, $qr];
	 
    }

    public function checkInvoiceCompliance(string $signed_invoice_string, string $invoice_hash, string $certificate, string $secret): string
    {
        if (!$certificate || !$secret)
            throw new Exception('EGS is missing a certificate/private key/api secret to check the invoice compliance.');

        list($issueCertificate, $checkInvoiceCompliance) = $this->api->compliance($certificate, $secret);
        $issued_data = $checkInvoiceCompliance($signed_invoice_string, $invoice_hash, $this->egs_info['uuid']);

        return json_encode($issued_data);
    }
	
}
