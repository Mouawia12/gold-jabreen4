<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyInfo;
use App\Models\Item;
use App\Models\Karat;
use App\Models\Branch;
use App\Models\ExitWorkTax;
use App\Models\ExitWorkTaxDetails;
use App\Models\StandardDebit;
use App\Models\StandardDebitDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ZataStandardControlle extends Controller
{ 
    public function Standard_tax_invoice($id){ 

        $Standard_invoice = ExitWorkTax::find($id);
        $Standard_invoice_details = ExitWorkTaxDetails::where('bill_id',$Standard_invoice->id)->get();

        $items = array();
        $i = 0;

        foreach($Standard_invoice_details as $Standard_invoice_detaile){

            $i++;
            $line_item = [
                'id' => $i,
                'name' => $Standard_invoice_detaile->item->name_ar,
                'quantity' => $Standard_invoice_detaile->weight,
                'tax_exclusive_price' => $Standard_invoice_detaile->gram_price,
                'VAT_percent' => $Standard_invoice_detaile->item->tax / 100,
                'other_taxes' => [
                    ['percent_amount' => 0]
                ],
                'discounts' => [
                    ['amount' => 0, 'reason' => 'discount'], 
                ],
            ];
            $items[] = $line_item ;
        }

        $company_infos = CompanyInfo::first();

        $egs_unit = [
            'uuid' => $Standard_invoice->uuid,
            'com_name' => $company_infos->name_ar,
            'model' => 'IOS',
            'CRN_number' => $company_infos->registrationNumber,
            'VAT_name' => $company_infos->name_ar,
            'VAT_number' => $company_infos->taxNumber,
            'location' => [
                'city' => $company_infos->city,
                'city_subdivision' => 'West',
                'street' => $company_infos->address,
                'plot_identification' => '0000',
                'building' => '0000',
                'postal_zone' => '00000',
            ],
            'branch_name' => $Standard_invoice->branch->branch_name,
            'branch_industry' => 'Jewelry',
            'invoice_type_code' =>'0200000',
            'cancelation' => [
                'cancelation_type' => 'INVOICE',
                'canceled_invoice_number' => '',
                'canceled_invoice_date' => '',
            ],
            'payment_methods' => [
                'methods1' => 'CASH', 
            ],
        ];
        
        $previous = $id-1;
        if($previous>0){
            $InvoiceHash = ExitWorkTax::find($previous)->invoice_hash;
        }
        
        $invoice = [
            'invoice_counter_number' => $Standard_invoice->id,
            'invoice_serial_number' => $Standard_invoice->bill_number, 
            'issue_date' => date('Y-m-d'),
            'issue_time' => date('H:i:s'), 
            'previous_invoice_hash' => $InvoiceHash ?? 'NWZlY2ViNjZmZmM4NmYzOGQ5NTI3ODZjNmQ2OTZjNzljMmRiYzIzOWRkNGU5MWI0NjcyOWQ3M2EyN2ZiNTdlOQ==', // AdditionalDocumentReference/PIH
            'customer_street'=> $Standard_invoice->company->address,
            'customer_building' => $Standard_invoice->company->building ?? 1111,
            'customer_citySub' => $Standard_invoice->company->city_sub ?? $Standard_invoice->company->city,
            'customer_city' => $Standard_invoice->company->city,
            'customer_postal' => !empty($Standard_invoice->company->postal_code) ? $Standard_invoice->company->postal_code: 12222,
            'customer_vat' => $Standard_invoice->company->vat_no,
            'customer_name' => $Standard_invoice->company->name,
            'line_items' => [...$items],
        ];
        
   
        $egs = new EGSController($egs_unit);
        $egs->production = false; 

        $binary_security_token = $egs->get_Certificate();
        $private_key = $egs->get_PrivateKey();
        $secret = $egs->get_secret();
        
        $binarySecurityToken = "-----BEGIN CERTIFICATE-----\r\n{$binary_security_token}\r\n-----END CERTIFICATE-----";
         
        // Sign invoice
        #التوقيع على الفاتورة
        list($signed_invoice_string, $invoice_hash, $qr) = $egs->signInvoice($invoice, $egs_unit, $binarySecurityToken, $private_key , 2);

        // Check invoice compliance
        #التحقق من امتثال الفاتورة
        $response = $egs->checkInvoiceCompliance($signed_invoice_string, $invoice_hash, $binarySecurityToken, $secret);
 
        $Standard_invoice->qr = $qr;
        $Standard_invoice->response = $response;
        $Standard_invoice->invoice_hash = $invoice_hash;
        $Standard_invoice->update();
    }

    public function Standard_debit($id){ 

        $Standard_invoice = StandardDebit::find($id);
        $Standard_invoice_details = StandardDebitDetails::where('bill_id',$Standard_invoice->id)->get();

        $items = array();
        $i = 0;

        foreach($Standard_invoice_details as $Standard_invoice_detaile){
            $i++;
            $line_item = [
                'id' => $i,
                'name' => $Standard_invoice_detaile->item->name_ar,
                'quantity' => $Standard_invoice_detaile->weight,
                'tax_exclusive_price' => $Standard_invoice_detaile->gram_price,
                'VAT_percent' => $Standard_invoice_detaile->item->tax / 100,
                'other_taxes' => [
                    ['percent_amount' => 0]
                ],
                'discounts' => [
                    ['amount' => 0, 'reason' => 'discount'], 
                ],
            ];
            $items[] = $line_item ;
        }

        $company_infos = CompanyInfo::first();

        $egs_unit = [
            'uuid' => $Standard_invoice->uuid,
            'com_name' => $company_infos->name_ar,
            'model' => 'IOS',
            'CRN_number' => $company_infos->registrationNumber,
            'VAT_name' => $company_infos->name_ar,
            'VAT_number' => $company_infos->taxNumber,
            'location' => [
                'city' => $company_infos->city,
                'city_subdivision' => 'West',
                'street' => $company_infos->address,
                'plot_identification' => '0000',
                'building' => '0000',
                'postal_zone' => '00000',
            ],
            'branch_name' => $Standard_invoice->branch->branch_name,
            'branch_industry' => 'Jewelry',
            'invoice_type_code' =>'0211010',
            'cancelation' => [
                'cancelation_type' => 'DEBIT_NOTE',
                'canceled_invoice_number' =>  $Standard_invoice->reference_id,
                'canceled_invoice_date' =>  date('Y-m-d',strtotime($Standard_invoice->invoice->date)),
            ],
            'payment_methods' => [
                'methods1' => 'CASH', 
            ],
        ];
        
        $previous = $id-1;
        if($previous>0){
            $InvoiceHash = StandardDebit::find($previous)->invoice_hash;
        }
       
        $invoice = [
            'invoice_counter_number' => $Standard_invoice->id,
            'invoice_serial_number' => $Standard_invoice->serial_number, 
            'issue_date' => date('Y-m-d'),
            'issue_time' => date('H:i:s'),
            'customer_name' => $Standard_invoice->company->name,
            'previous_invoice_hash' => $InvoiceHash ?? 'NWZlY2ViNjZmZmM4NmYzOGQ5NTI3ODZjNmQ2OTZjNzljMmRiYzIzOWRkNGU5MWI0NjcyOWQ3M2EyN2ZiNTdlOQ==', // AdditionalDocumentReference/PIH
            'customer_street'=> $Standard_invoice->company->address,
            'customer_building' => $Standard_invoice->company->building ?? 1111,
            'customer_citySub' => $Standard_invoice->company->city_sub ?? $Standard_invoice->company->city,
            'customer_city' => $Standard_invoice->company->city,
            'customer_postal' => !empty($Standard_invoice->company->postal_code) ? $Standard_invoice->company->postal_code: 12222,
            'customer_vat' => $Standard_invoice->company->vat_no,
            'customer_name' => $Standard_invoice->company->name,
            'line_items' => [...$items],
        ];
      
        $egs = new EGSController($egs_unit);
        $egs->production = false; 

        $binary_security_token = $egs->get_Certificate();
        $private_key = $egs->get_PrivateKey();
        $secret = $egs->get_secret();
        
        $binarySecurityToken = "-----BEGIN CERTIFICATE-----\r\n{$binary_security_token}\r\n-----END CERTIFICATE-----";
    
        #التوقيع على الفاتورة
        list($signed_invoice_string, $invoice_hash, $qr) = $egs->signInvoice($invoice, $egs_unit, $binarySecurityToken, $private_key, 2);

        // Check invoice compliance
        #التحقق من امتثال الفاتورة
        $response = $egs->checkInvoiceCompliance($signed_invoice_string, $invoice_hash, $binarySecurityToken, $secret);
 
        $Standard_invoice->qr = $qr;
        $Standard_invoice->response = $response;
        $Standard_invoice->invoice_hash = $invoice_hash;
        $Standard_invoice->update();
        
    }


    public function Standard_credit( $id, $previous_invoice_hash ){ 

        $Standard_invoice = ExitWorkTax::find($id);
        $Standard_invoice_details = ExitWorkTaxDetails::where('bill_id',$Standard_invoice->id)->get();
        $Standard_invoice_returned = ExitWorkTax::where('returned_bill_id',$id)->first();

        $items = array();
        $i = 0;

        foreach($Standard_invoice_details as $Standard_invoice_detaile){
            $i++;
            $line_item = [
                'id' => $i,
                'name' => $Standard_invoice_detaile->item->name_ar,
                'quantity' => $Standard_invoice_detaile->weight,
                'tax_exclusive_price' => $Standard_invoice_detaile->gram_price,
                'VAT_percent' => $Standard_invoice_detaile->item->tax / 100,
                'other_taxes' => [
                    ['percent_amount' => 0]
                ],
                'discounts' => [
                    ['amount' => 0, 'reason' => 'discount'], 
                ],
            ];
            $items[] = $line_item ;
        }

        $company_infos = CompanyInfo::first();

        $egs_unit = [
            'uuid' => $Standard_invoice->uuid,
            'com_name' => $company_infos->name_ar,
            'model' => 'IOS',
            'CRN_number' => $company_infos->registrationNumber,
            'VAT_name' => $company_infos->name_ar,
            'VAT_number' => $company_infos->taxNumber,
            'location' => [
                'city' => $company_infos->city,
                'city_subdivision' => 'West',
                'street' => $company_infos->address,
                'plot_identification' => '0000',
                'building' => '0000',
                'postal_zone' => '00000',
            ],
            'branch_name' => $Standard_invoice->branch->branch_name,
            'branch_industry' => 'Jewelry',
            'invoice_type_code' =>'0211010',
            'cancelation' => [
                'cancelation_type' => 'CREDIT_NOTE',
                'canceled_invoice_number' =>  $Standard_invoice_returned->id,
                'canceled_invoice_date' =>  date('Y-m-d',strtotime($Standard_invoice_returned->date)),
            ],
            'payment_methods' => [
                'methods1' => 'CASH', 
            ],
        ];
        
        $invoice = [
            'invoice_counter_number' => $Standard_invoice->id,
            'invoice_serial_number' => $Standard_invoice->bill_number, 
            'issue_date' => date('Y-m-d'),
            'issue_time' => date('H:i:s'), 
            'previous_invoice_hash' => $previous_invoice_hash ?? 'NWZlY2ViNjZmZmM4NmYzOGQ5NTI3ODZjNmQ2OTZjNzljMmRiYzIzOWRkNGU5MWI0NjcyOWQ3M2EyN2ZiNTdlOQ==', // AdditionalDocumentReference/PIH
            'customer_street'=> $Standard_invoice->company->address,
            'customer_building' => $Standard_invoice->company->building ?? 1111,
            'customer_citySub' => $Standard_invoice->company->city_sub ?? $Standard_invoice->company->city,
            'customer_city' => $Standard_invoice->company->city,
            'customer_postal' => !empty($Standard_invoice->company->postal_code) ? $Standard_invoice->company->postal_code: 12222,
            'customer_vat' => $Standard_invoice->company->vat_no,
            'customer_name' => $Standard_invoice->company->name,
            'line_items' => [...$items],
        ];

      
        $egs = new EGSController($egs_unit);
        $egs->production = false; 

        $binary_security_token = $egs->get_Certificate();
        $private_key = $egs->get_PrivateKey();
        $secret = $egs->get_secret();
        
        $binarySecurityToken = "-----BEGIN CERTIFICATE-----\r\n{$binary_security_token}\r\n-----END CERTIFICATE-----";
         
        // Sign invoice
        #التوقيع على الفاتورة
        list($signed_invoice_string, $invoice_hash, $qr) = $egs->signInvoice($invoice, $egs_unit, $binarySecurityToken, $private_key , 2);

        // Check invoice compliance
        #التحقق من امتثال الفاتورة
        $response = $egs->checkInvoiceCompliance($signed_invoice_string, $invoice_hash, $binarySecurityToken, $secret);
 
        $Standard_invoice->qr = $qr;
        $Standard_invoice->response = $response;
        $Standard_invoice->invoice_hash = $invoice_hash;
        $Standard_invoice->update();
     
    }
	
  
}
