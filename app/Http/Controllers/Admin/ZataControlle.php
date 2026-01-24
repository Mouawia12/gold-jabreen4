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

class ZataControlle extends Controller
{ 
    public function simplified_tax_invoice($id){ 

        $simplified_invoice = ExitWork::find($id);
        $simplified_invoice_details = ExitWorkDetails::where('bill_id',$simplified_invoice->id)->get();

        $items = array();
        $i = 0;
        foreach($simplified_invoice_details as $simplified_invoice_detaile){
            $i++;
            $line_item = [
                'id' => $i,
                'name' => $simplified_invoice_detaile->item->name_ar,
                'quantity' => $simplified_invoice_detaile->weight,
                'tax_exclusive_price' => $simplified_invoice_detaile->gram_price,
                'VAT_percent' => $simplified_invoice_detaile->item->tax / 100,
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
            'uuid' => $simplified_invoice->uuid,
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
            'branch_name' => $simplified_invoice->branch->branch_name,
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
            $InvoiceHash = ExitWork::find($previous)->invoice_hash;
        }

        $invoice = [
            'invoice_counter_number' => $simplified_invoice->id,
            'invoice_serial_number' => $simplified_invoice->bill_number, 
            'issue_date' => date('Y-m-d'),
            'issue_time' => date('H:i:s'),
            'customer_name' => $simplified_invoice->company->name,
            'previous_invoice_hash' => $InvoiceHash ?? 'NWZlY2ViNjZmZmM4NmYzOGQ5NTI3ODZjNmQ2OTZjNzljMmRiYzIzOWRkNGU5MWI0NjcyOWQ3M2EyN2ZiNTdlOQ==', // AdditionalDocumentReference/PIH
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
        list($signed_invoice_string, $invoice_hash, $qr) = $egs->signInvoice($invoice, $egs_unit, $binarySecurityToken, $private_key, 1);

        // Check invoice compliance
        #التحقق من امتثال الفاتورة
        $response = $egs->checkInvoiceCompliance($signed_invoice_string, $invoice_hash, $binarySecurityToken, $secret);
 
        $simplified_invoice->qr = $qr;
        $simplified_invoice->response = $response;
        $simplified_invoice->invoice_hash = $invoice_hash;
        $simplified_invoice->update();
    }

    public function simplified_debit($id){ 

        $simplified_invoice = SimplifiedDebit::find($id);
        $simplified_invoice_details = SimplifiedDebitDetails::where('bill_id',$simplified_invoice->id)->get();

        $items = array();
        $i = 0;
        foreach($simplified_invoice_details as $simplified_invoice_detaile){
            $i++;
            $line_item = [
                'id' => $i,
                'name' => $simplified_invoice_detaile->item->name_ar,
                'quantity' => $simplified_invoice_detaile->weight,
                'tax_exclusive_price' => $simplified_invoice_detaile->gram_price,
                'VAT_percent' => $simplified_invoice_detaile->item->tax / 100,
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
            'uuid' => $simplified_invoice->uuid,
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
            'branch_name' => $simplified_invoice->branch->branch_name,
            'branch_industry' => 'Jewelry',
            'invoice_type_code' =>'0211010',
            'cancelation' => [
                'cancelation_type' => 'DEBIT_NOTE',
                'canceled_invoice_number' =>  $simplified_invoice->reference_id,
                'canceled_invoice_date' =>  date('Y-m-d',strtotime($simplified_invoice->invoice->date)),
            ],
            'payment_methods' => [
                'methods1' => 'CASH', 
            ],
        ];
    
        $previous = $id-1;
        if($previous>0){
            $InvoiceHash = SimplifiedDebit::find($previous)->invoice_hash;
        }

        $invoice = [
            'invoice_counter_number' => $simplified_invoice->id,
            'invoice_serial_number' => $simplified_invoice->serial_number, 
            'issue_date' => date('Y-m-d'),
            'issue_time' => date('H:i:s'),
            'customer_name' => $simplified_invoice->company->name,
            'previous_invoice_hash' => $InvoiceHash ?? 'NWZlY2ViNjZmZmM4NmYzOGQ5NTI3ODZjNmQ2OTZjNzljMmRiYzIzOWRkNGU5MWI0NjcyOWQ3M2EyN2ZiNTdlOQ==', // AdditionalDocumentReference/PIH
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
        list($signed_invoice_string, $invoice_hash, $qr) = $egs->signInvoice($invoice, $egs_unit, $binarySecurityToken, $private_key ,1);

        // Check invoice compliance
        #التحقق من امتثال الفاتورة
        $response = $egs->checkInvoiceCompliance($signed_invoice_string, $invoice_hash, $binarySecurityToken, $secret);
 
        $simplified_invoice->qr = $qr;
        $simplified_invoice->response = $response;
        $simplified_invoice->invoice_hash = $invoice_hash;
        $simplified_invoice->update();
        
    }


    public function simplified_credit( $id, $previous_invoice_hash ){ 

        $simplified_invoice = ExitWork::find($id);
        $simplified_invoice_details = ExitWorkDetails::where('bill_id',$simplified_invoice->id)->get();
        $simplified_invoice_returned = ExitWork::where('returned_bill_id',$id)->first();

        $items = array();
        $i = 0;

        foreach($simplified_invoice_details as $simplified_invoice_detaile){
            $i++;
            $line_item = [
                'id' => $i,
                'name' => $simplified_invoice_detaile->item->name_ar,
                'quantity' => $simplified_invoice_detaile->weight,
                'tax_exclusive_price' => $simplified_invoice_detaile->gram_price,
                'VAT_percent' => $simplified_invoice_detaile->item->tax / 100,
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
            'uuid' => $simplified_invoice->uuid ,
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
            'branch_name' => $simplified_invoice->branch->branch_name,
            'branch_industry' => 'Jewelry',
            'invoice_type_code' =>'0211010',
            'cancelation' => [
                'cancelation_type' => 'CREDIT_NOTE',
                'canceled_invoice_number' =>  $simplified_invoice_returned->id,
                'canceled_invoice_date' =>  date('Y-m-d',strtotime($simplified_invoice_returned->date)),
            ],
            'payment_methods' => [
                'methods1' => 'CASH', 
            ],
        ];
  
        $invoice = [
            'invoice_counter_number' => $simplified_invoice->id,
            'invoice_serial_number' => $simplified_invoice->bill_number, 
            'issue_date' => date('Y-m-d'),
            'issue_time' => date('H:i:s'),
            'customer_name' => $simplified_invoice->company->name,
            'previous_invoice_hash' => $previous_invoice_hash ?? 'NWZlY2ViNjZmZmM4NmYzOGQ5NTI3ODZjNmQ2OTZjNzljMmRiYzIzOWRkNGU5MWI0NjcyOWQ3M2EyN2ZiNTdlOQ==', // AdditionalDocumentReference/PIH
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
        list($signed_invoice_string, $invoice_hash, $qr) = $egs->signInvoice($invoice, $egs_unit, $binarySecurityToken, $private_key ,1);

        // Check invoice compliance
        #التحقق من امتثال الفاتورة
        $response = $egs->checkInvoiceCompliance($signed_invoice_string, $invoice_hash, $binarySecurityToken, $secret);
 
        $simplified_invoice->qr = $qr;
        $simplified_invoice->response = $response;
        $simplified_invoice->invoice_hash = $invoice_hash;
        $simplified_invoice->update();
     
    }
	
  
}
