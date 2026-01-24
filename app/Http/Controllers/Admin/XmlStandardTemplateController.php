<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class XmlStandardTemplateController extends Controller
{
    public function csr_template(){
        // 2.2.2 Profile specification of the Cryptographic Stamp identifiers. & CSR field contents / RDNs.
        return <<<TEXT
        # ------------------------------------------------------------------
        # Default section for "req" command options
        # ------------------------------------------------------------------
        [req]
        
        # Password for reading in existing private key file
        # input_password = SET_PRIVATE_KEY_PASS
        
        # Prompt for DN field values and CSR attributes in ASCII
        prompt = no
        utf8 = no
        
        # Section pointer for DN field options
        distinguished_name = my_req_dn_prompt
        
        # Extensions
        req_extensions = v3_req
        
        [ v3_req ]
        #basicConstraints=CA:FALSE
        #keyUsage = digitalSignature, keyEncipherment
        # Production or Testing Template (TSTZATCA-Code-Signing - ZATCA-Code-Signing)
        1.3.6.1.4.1.311.20.2 = ASN1:UTF8String:SET_PRODUCTION_VALUE
        subjectAltName=dirName:dir_sect
        
        [ dir_sect ]
        # EGS Serial number (1-SolutionName|2-ModelOrVersion|3-serialNumber)
        SN = SET_EGS_SERIAL_NUMBER
        # VAT Registration number of TaxPayer (Organization identifier [15 digits begins with 3 and ends with 3])
        UID = SET_VAT_REGISTRATION_NUMBER
        # Invoice type (TSCZ)(1 = supported, 0 not supported) (Tax, Simplified, future use, future use)
        title = 0100
        # Location (branch address or website)
        registeredAddress = SET_BRANCH_LOCATION
        # Industry (industry sector name)
        businessCategory = SET_BRANCH_INDUSTRY
        
        # ------------------------------------------------------------------
        # Section for prompting DN field values to create "subject"
        # ------------------------------------------------------------------
        [my_req_dn_prompt]
        # Common name (EGS TaxPayer PROVIDED ID [FREE TEXT])
        commonName = SET_COMMON_NAME
        
        # Organization Unit (Branch name)
        organizationalUnitName = SET_BRANCH_NAME
        
        # Organization name (Tax payer name)
        organizationName = SET_TAXPAYER_NAME
        
        # ISO2 country code is required with US as default
        countryName = SA
        TEXT;

    }

    public function invoice_billing_reference_template(){
        return <<<XML
            <cac:BillingReference>
            <cac:InvoiceDocumentReference>
               <cbc:ID>Invoice Number: SET_INVOICE_NUMBER; Invoice Issue Date: SET_INVOICE_DATE</cbc:ID>
            </cac:InvoiceDocumentReference>
            </cac:BillingReference>
            XML;
    }

    public function invoice_billing_reference_Instruction_Note_template(){
        return <<<XML
            <cbc:InstructionNote>Returned items</cbc:InstructionNote>
            XML;
    }

    public function invoice_billing_reference_Debit_Instruction_Note_template(){
        return <<<XML
            <cbc:InstructionNote>Returned items</cbc:InstructionNote>
            XML;
    }

    public function tax_exemption_reason(){
        return <<<XML
            <cbc:TaxExemptionReasonCode>VATEX-SA-OOS</cbc:TaxExemptionReasonCode>
            <cbc:TaxExemptionReason>Services outside scope of tax / Not subject to VAT | التوريدات الغير خاضعة للضريبة</cbc:TaxExemptionReason>
            XML;
    }

    public function invoice_line_template(){
        $invoice_line = <<<XML
        
            <cac:InvoiceLine>
                <cbc:ID>__ID</cbc:ID>
                <cbc:InvoicedQuantity unitCode="PCE">__InvoicedQuantity</cbc:InvoicedQuantity>
                <cbc:LineExtensionAmount currencyID="SAR">__LineExtensionAmount</cbc:LineExtensionAmount>
                <cac:TaxTotal>
                    <cbc:TaxAmount currencyID="SAR">__TaxAmount</cbc:TaxAmount>
                    <cbc:RoundingAmount currencyID="SAR">__RoundingAmount</cbc:RoundingAmount>
                </cac:TaxTotal>
                <cac:Item>
                    <cbc:Name>__Name</cbc:Name>ClassifiedTaxCategory
                </cac:Item>
                <cac:Price>
                    <cbc:PriceAmount currencyID="SAR">__PriceAmount</cbc:PriceAmount>AllowanceCharge
                </cac:Price>
            </cac:InvoiceLine>
        XML;
        
        $invoice_item = <<<XML
        
                    <cac:ClassifiedTaxCategory>
                        <cbc:ID>___S</cbc:ID>
                        <cbc:Percent>___Percent</cbc:Percent>
                        <cac:TaxScheme>
                            <cbc:ID>VAT</cbc:ID>
                        </cac:TaxScheme>
                    </cac:ClassifiedTaxCategory>
        XML;
        
        $invoice_price = <<<XML
        
                    <cac:AllowanceCharge>
                        <cbc:ChargeIndicator>true</cbc:ChargeIndicator>
                        <cbc:AllowanceChargeReason>___AllowanceChargeReason</cbc:AllowanceChargeReason>
                        <cbc:Amount currencyID="SAR">___Amount</cbc:Amount>
                    </cac:AllowanceCharge>
        XML;
        
        
        return [
            'invoice_line' => $invoice_line,
            'invoice_item' => $invoice_item,
            'invoice_price' => $invoice_price,
        ];
    }

    public function legal_monetary_total_template(){
        return <<<XML

            <cac:LegalMonetaryTotal>
                <cbc:LineExtensionAmount currencyID="SAR">_LineExtensionAmount</cbc:LineExtensionAmount>
                <cbc:TaxExclusiveAmount currencyID="SAR">_TaxExclusiveAmount</cbc:TaxExclusiveAmount>
                <cbc:TaxInclusiveAmount currencyID="SAR">_TaxInclusiveAmount</cbc:TaxInclusiveAmount>
                <cbc:PayableAmount currencyID="SAR">_PayableAmount</cbc:PayableAmount>
            </cac:LegalMonetaryTotal>
        XML;
    }

    public function simplified_tax_invoice_template(){
        /**
         * Maybe use a templating engine instead of str replace.
         * This works for now though
         *
         * cbc:InvoiceTypeCode: 388: BR-KSA-05 Tax Invoice according to UN/CEFACT codelist 1001, D.16B for KSA.
         *  name="0211010": BR-KSA-06 starts with "02" Simplified Tax Invoice. Also explains other positions.
         * cac:AdditionalDocumentReference: ICV: KSA-16, BR-KSA-33 (Invoice Counter number)
         */
        
        return /* XML */
        <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
        <ext:UBLExtensions>SET_UBL_EXTENSIONS_STRING
        </ext:UBLExtensions>
        <cbc:ProfileID>reporting:1.0</cbc:ProfileID>
        <cbc:ID>SET_INVOICE_SERIAL_NUMBER</cbc:ID>
        <cbc:UUID>SET_TERMINAL_UUID</cbc:UUID>
        <cbc:IssueDate>SET_ISSUE_DATE</cbc:IssueDate>
        <cbc:IssueTime>SET_ISSUE_TIME</cbc:IssueTime>
        <cbc:InvoiceTypeCode name="0100000">SET_INVOICE_TYPE</cbc:InvoiceTypeCode>
        <cbc:Note languageID="ar">ABC</cbc:Note>
        <cbc:DocumentCurrencyCode>SAR</cbc:DocumentCurrencyCode>
        <cbc:TaxCurrencyCode>SAR</cbc:TaxCurrencyCode>SET_BILLING_REFERENCE
        <cac:AdditionalDocumentReference>
            <cbc:ID>ICV</cbc:ID>
            <cbc:UUID>SET_INVOICE_COUNTER_NUMBER</cbc:UUID>
        </cac:AdditionalDocumentReference>
        <cac:AdditionalDocumentReference>
            <cbc:ID>PIH</cbc:ID>
            <cac:Attachment>
                <cbc:EmbeddedDocumentBinaryObject mimeCode="text/plain">SET_PREVIOUS_INVOICE_HASH</cbc:EmbeddedDocumentBinaryObject>
            </cac:Attachment>
        </cac:AdditionalDocumentReference>
        <cac:AdditionalDocumentReference>
            <cbc:ID>QR</cbc:ID>
            <cac:Attachment>
                <cbc:EmbeddedDocumentBinaryObject mimeCode="text/plain">SET_QR_CODE_DATA</cbc:EmbeddedDocumentBinaryObject>
            </cac:Attachment>
        </cac:AdditionalDocumentReference>
        <cac:Signature>
          <cbc:ID>urn:oasis:names:specification:ubl:signature:Invoice</cbc:ID>
          <cbc:SignatureMethod>urn:oasis:names:specification:ubl:dsig:enveloped:xades</cbc:SignatureMethod>
        </cac:Signature>
        <cac:AccountingSupplierParty>
            <cac:Party>
                <cac:PartyIdentification>
                    <cbc:ID schemeID="CRN">SET_COMMERCIAL_REGISTRATION_NUMBER</cbc:ID>
                </cac:PartyIdentification>
                <cac:PostalAddress>
                    <cbc:StreetName>SET_STREET_NAME</cbc:StreetName>
                    <cbc:BuildingNumber>SET_BUILDING_NUMBER</cbc:BuildingNumber>
                    <cbc:PlotIdentification>SET_PLOT_IDENTIFICATION</cbc:PlotIdentification>
                    <cbc:CitySubdivisionName>SET_CITY_SUBDIVISION</cbc:CitySubdivisionName>
                    <cbc:CityName>SET_CITY</cbc:CityName>
                    <cbc:PostalZone>SET_POSTAL_NUMBER</cbc:PostalZone>
                    <cac:Country>
                        <cbc:IdentificationCode>SA</cbc:IdentificationCode>
                    </cac:Country>
                </cac:PostalAddress>
                <cac:PartyTaxScheme>
                    <cbc:CompanyID>SET_VAT_NUMBER</cbc:CompanyID>
                    <cac:TaxScheme>
                        <cbc:ID>VAT</cbc:ID>
                    </cac:TaxScheme>
                </cac:PartyTaxScheme>
                <cac:PartyLegalEntity>
                    <cbc:RegistrationName>SET_VAT_NAME</cbc:RegistrationName>
                </cac:PartyLegalEntity>
            </cac:Party>
        </cac:AccountingSupplierParty>
        <cac:AccountingCustomerParty>
            <cac:Party>
                <cac:PostalAddress>
                    <cbc:StreetName>SET_CUSTOMER_STREET</cbc:StreetName>
                    <cbc:BuildingNumber>SET_CUSTOMER_BUILDING</cbc:BuildingNumber>
                    <cbc:CitySubdivisionName>SET_CUSTOMER_CITY_SUB</cbc:CitySubdivisionName>
                    <cbc:CityName>SET_CUSTOMER_CITY</cbc:CityName>
                    <cbc:PostalZone>SET_CUSTOMER_POSTAL</cbc:PostalZone>
                    <cac:Country>
                        <cbc:IdentificationCode>SA</cbc:IdentificationCode>
                    </cac:Country>
                </cac:PostalAddress>
                <cac:PartyTaxScheme>
                    <cbc:CompanyID>SET_CUSTOMER_VAT</cbc:CompanyID>
                    <cac:TaxScheme>
                        <cbc:ID>VAT</cbc:ID>
                    </cac:TaxScheme>
                </cac:PartyTaxScheme>
                <cac:PartyLegalEntity>
                    <cbc:RegistrationName>SET_CUSTOMER_NAME</cbc:RegistrationName>
                </cac:PartyLegalEntity>
            </cac:Party>
        </cac:AccountingCustomerParty>
        <cac:Delivery>
        <cbc:ActualDeliveryDate>2022-09-07</cbc:ActualDeliveryDate>
        </cac:Delivery>
        <cac:PaymentMeans> 
            <cbc:PaymentMeansCode>SET_PAYMENT_METHODS</cbc:PaymentMeansCode>SET_INSTRUCTION_NOTE
        </cac:PaymentMeans> 
        PARSE_LINE_ITEMS
        </Invoice>
        XML;
    }

    public function tax_total_template(){
        $tax_total = <<<XML
        <cac:TaxTotal>
                <cbc:TaxAmount currencyID="SAR">__158.67</cbc:TaxAmount>__TaxSubtotal
            </cac:TaxTotal>
            <cac:TaxTotal>
                <cbc:TaxAmount currencyID="SAR">___tax_amount</cbc:TaxAmount>
            </cac:TaxTotal>
        XML;
        
        $tax_sub_total = <<<XML
        
                <cac:TaxSubtotal>
                    <cbc:TaxableAmount currencyID="SAR">46.00</cbc:TaxableAmount>
                    <cbc:TaxAmount currencyID="SAR">_6.89</cbc:TaxAmount>
                    <cac:TaxCategory>
                        <cbc:ID schemeAgencyID="6" schemeID="UN/ECE 5305">__S</cbc:ID>
                        <cbc:Percent>15.00</cbc:Percent>
                        SET_TAX_EXEMPTION_REASON_CODE
                        <cac:TaxScheme>
                            <cbc:ID schemeAgencyID="6" schemeID="UN/ECE 5153">VAT</cbc:ID>
                        </cac:TaxScheme>
                    </cac:TaxCategory>
                </cac:TaxSubtotal>
        XML;
        
        return [
            'tax_total' => $tax_total,
            'tax_sub_total' => $tax_sub_total,
        ];
    }

    public function ubl_signature(){

        return <<<XML

        <ext:UBLExtension>
            <ext:ExtensionURI>urn:oasis:names:specification:ubl:dsig:enveloped:xades</ext:ExtensionURI>
            <ext:ExtensionContent>
                <sig:UBLDocumentSignatures
                        xmlns:sac="urn:oasis:names:specification:ubl:schema:xsd:SignatureAggregateComponents-2"
                        xmlns:sbc="urn:oasis:names:specification:ubl:schema:xsd:SignatureBasicComponents-2"
                        xmlns:sig="urn:oasis:names:specification:ubl:schema:xsd:CommonSignatureComponents-2">
                    <sac:SignatureInformation>
                        <cbc:ID>urn:oasis:names:specification:ubl:signature:1</cbc:ID>
                        <sbc:ReferencedSignatureID>urn:oasis:names:specification:ubl:signature:Invoice</sbc:ReferencedSignatureID>
                        <ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" Id="signature">
                            <ds:SignedInfo>
                                <ds:CanonicalizationMethod
                                        Algorithm="http://www.w3.org/2006/12/xml-c14n11"/>
                                <ds:SignatureMethod
                                        Algorithm="http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha256"/>
                                <ds:Reference Id="invoiceSignedData" URI="">
                                    <ds:Transforms>
                                        <ds:Transform
                                                Algorithm="http://www.w3.org/TR/1999/REC-xpath-19991116">
                                            <ds:XPath>not(//ancestor-or-self::ext:UBLExtensions)</ds:XPath>
                                        </ds:Transform>
                                        <ds:Transform
                                                Algorithm="http://www.w3.org/TR/1999/REC-xpath-19991116">
                                            <ds:XPath>not(//ancestor-or-self::cac:Signature)</ds:XPath>
                                        </ds:Transform>
                                        <ds:Transform
                                                Algorithm="http://www.w3.org/TR/1999/REC-xpath-19991116">
                                            <ds:XPath>not(//ancestor-or-self::cac:AdditionalDocumentReference[cbc:ID='QR'])</ds:XPath>
                                        </ds:Transform>
                                        <ds:Transform
                                                Algorithm="http://www.w3.org/2006/12/xml-c14n11"/>
                                    </ds:Transforms>
                                    <ds:DigestMethod
                                            Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"/>
                                    <ds:DigestValue>SET_INVOICE_HASH</ds:DigestValue>
                                </ds:Reference>
                                <ds:Reference
                                        Type="http://www.w3.org/2000/09/xmldsig#SignatureProperties"
                                        URI="#xadesSignedProperties">
                                    <ds:DigestMethod
                                            Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"/>
                                    <ds:DigestValue>SET_SIGNED_PROPERTIES_HASH</ds:DigestValue>
                                </ds:Reference>
                            </ds:SignedInfo>
                            <ds:SignatureValue>SET_DIGITAL_SIGNATURE</ds:SignatureValue>
                            <ds:KeyInfo>
                                <ds:X509Data>
                                    <ds:X509Certificate>SET_CERTIFICATE</ds:X509Certificate>
                                </ds:X509Data>
                            </ds:KeyInfo>
                            <ds:Object>
                                <xades:QualifyingProperties Target="signature"
                                                            xmlns:xades="http://uri.etsi.org/01903/v1.3.2#">
                                    SET_SIGNED_PROPERTIES_XML
                                </xades:QualifyingProperties>
                            </ds:Object>
                        </ds:Signature>
                    </sac:SignatureInformation>
                </sig:UBLDocumentSignatures>
            </ext:ExtensionContent>
        </ext:UBLExtension>
        XML;
    }

    public function ubl_signature_signed_properties_for_signing_template(){
        return <<<XML
        <xades:SignedProperties xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" Id="xadesSignedProperties">
            <xades:SignedSignatureProperties>
                <xades:SigningTime>SET_SIGN_TIMESTAMP</xades:SigningTime>
                <xades:SigningCertificate>
                    <xades:Cert>
                        <xades:CertDigest>
                            <ds:DigestMethod xmlns:ds="http://www.w3.org/2000/09/xmldsig#" Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"/>
                            <ds:DigestValue xmlns:ds="http://www.w3.org/2000/09/xmldsig#">SET_CERTIFICATE_HASH</ds:DigestValue>
                        </xades:CertDigest>
                        <xades:IssuerSerial>
                            <ds:X509IssuerName xmlns:ds="http://www.w3.org/2000/09/xmldsig#">SET_CERTIFICATE_ISSUER</ds:X509IssuerName>
                            <ds:X509SerialNumber xmlns:ds="http://www.w3.org/2000/09/xmldsig#">SET_CERTIFICATE_SERIAL_NUMBER</ds:X509SerialNumber>
                        </xades:IssuerSerial>
                    </xades:Cert>
                </xades:SigningCertificate>
            </xades:SignedSignatureProperties>
        </xades:SignedProperties>
        XML;
    }

    public function ubl_signature_signed_properties_template(){
        return <<<XML
        <xades:SignedProperties  Id="xadesSignedProperties">
                <xades:SignedSignatureProperties>
                    <xades:SigningTime>SET_SIGN_TIMESTAMP</xades:SigningTime>
                    <xades:SigningCertificate>
                        <xades:Cert>
                            <xades:CertDigest>
                                <ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></ds:DigestMethod>
                                <ds:DigestValue>SET_CERTIFICATE_HASH</ds:DigestValue>
                            </xades:CertDigest>
                            <xades:IssuerSerial>
                                <ds:X509IssuerName>SET_CERTIFICATE_ISSUER</ds:X509IssuerName>
                                <ds:X509SerialNumber>SET_CERTIFICATE_SERIAL_NUMBER</ds:X509SerialNumber>
                            </xades:IssuerSerial>
                        </xades:Cert>
                    </xades:SigningCertificate>
                </xades:SignedSignatureProperties>
            </xades:SignedProperties>
        XML;
    }
	
}
