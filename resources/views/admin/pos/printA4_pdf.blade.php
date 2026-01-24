<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <title>
         فاتورة ضريبية مبسطة رقم  {{$bill -> bill_number}}
    </title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet"/> 
    <style type="text/css" media="screen">
         @font-face {
            font-family: 'DINNextLTArabic-Medium';
            src: url('DINNextLTArabic-Regular-3.ttf') format('truetype');
                font-weight: normal;
                font-style: normal;
        }
        * {
            color: #000 !important; 
            direction:rtl !important;
        }
        @page { font-family: 'DINNextLTArabic-Medium'; }
        body, html {
            color: #000; 
            font-size: 13px !important;
            font-weight: bold;
            margin: 0;
            padding: 10px;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;
     
        }

        .no-print {
            position: fixed;
            bottom: 0;
            color: #fff !important;
            left: 30px;
            width:200px !important;
            height: 40px !important;
            border-radius: 0;
            padding-top: 10px;
            z-index: 9999;
        }

        table thead tr, table tbody tr {
            border-bottom: 1px solid #aaa;
    
        }

        table {
            text-align: center;
            width: 100% !important;
            margin-top: 10px !important;
         
        }
        div#sales-header { 
            border: 2px solid #eee;
            border-radius: 10px; 
          
        }
        .pos_details { 
            font-family: DejaVu Sans,Tajawal-Regular;  
        }
    </style>
    <style type="text/css" media="print">
        .above-table {
            width: 100% !important;
            direction:rtl !important;
        }
        @page { font-family: 'DINNextLTArabic-Medium'; }
        table {
            text-align: center;
            width: 100% !important;
            margin-top: 10px !important;
            direction:rtl !important;
        }

        table thead tr, table tbody tr {
            border-bottom: 1px solid #aaa;
            direction:rtl !important;
        }

        * {
            color: #000 !important;
                 direction:rtl !important;
        }

        body, html {
            color: #000;
            padding: 0px;
            margin: 0; 
            font-size: 11px !important;
            font-weight: bold !important;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        .pos_details {
            width: 100% !important;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;
            direction:rtl !important;
        }

        .no-print {
            display: none;
        }
        div#sales-header {
            display: none;
        }
    </style>
    <style> 
     * { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body  dir='rtl' style="background: #fff;
    page-break-before: avoid;
    page-break-after: avoid;
    page-break-inside: avoid;" class="text-center">
          
<div class="pos_details  justify-content-center text-center" dir='rtl' > 
    <div class="above-table w-100 text-center mt-3  justify-content-center" style="margin: 10px auto!important;">
       
        <table class="table-bordered" dir='rtl'>
           <tr dir='rtl'>
               <td class="col-lg-4 text-right" dir='rtl'>   
                    <br> {{$company ? $company -> name_ar : ''}} 
                    <br>  س.ت : {{$company ? $company -> taxNumber : ''}}
                    <br>  ر.ض :  {{$company ? $company -> registrationNumber : ''}}
                    <br>  تليفون :   {{$company ? $company -> phone : ''}} 
                </td>  

                <td class="col-lg-4 text-center" dir='rtl'>
                    <img src="{{URL::asset('assets/img/logo.png')}}" width="100" height="100">
                    <h6 class="text-right" > 
                        <strong>فاتورة ضريبية مبسطة</strong> 
                    </h6>
                </td>

                <td class="col-lg-4 text-right" dir='rtl'> 
                    <h6 class="text-right mt-1" style="font-weight: bold;">
                        <span dir='rtl'>
                             {{$bill -> bill_number}}  
                        </span>
                        رقم الفاتورة  
                  
                    </h6>
                    <h6 class="text-right mt-1" style="font-weight: bold;" dir='rtl'>
                        <span dir='rtl'>
                             {{\Carbon\Carbon::parse($bill -> date) -> format('d- m -Y') }}
                        </span>
                        التاريخ :
             
                    </h6>
                    <h6 class="text-right mt-1" style="font-weight: bold;" dir='rtl'> 
                        <span dir='rtl'>
                            {{$bill -> branch_name}}
                        </span>
                        الفرع :
       
                    </h6>
                    <h6 class="text-right mt-1" style="font-weight: bold;" dir='rtl'>
                        <span dir='rtl'>
                        {{$bill -> vendor_name != 'عميل نقدي افتراضي'  ?$bill -> vendor_name : $bill  -> bill_client_name }}
                        </span>
                        المباع على المكرم :
                
                    </h6>
                </td>
            </tr> 
        </table>  
        <table class="table-bordered" dir='rtl'>
            <thead dir='rtl'>
            <tr dir='rtl'> 
                <th class="text-center " >الإجمالي شامل الضريبة
                    <br>(Total With Vat)
                </th> 
                <th class="text-center " >الضريبة
                    <br> (Vat) 
                </th>
                <th class="text-center " >الإجمالي(Total)</th>
                <th class="text-center " > سعر الجرام
                    <br>(Gram Price) 
                </th> 
                <th class="text-center " >ما خلا من المعدن
                    <br>(Non Metal) 
                </th>
                <th class="text-center " > وزن الذهب
                    <br>(Weight)
                </th>
                <th class="text-center " >العيار
                    <br>(Karat)
                </th>
                <th class="text-center ">وصف الصنف
                    <br>(Item) 
                </th>
            </tr>
            </thead>
            <tbody id="tbody"  dir='rtl'>
            <?php $sum_total = 0 ?>
            <?php $sum_tax = 0 ?>
            <?php $sum_weight = 0 ?>
            @foreach($details as $detail)
                <tr  dir='rtl'>
                    <td class="text-center"> {{$detail -> net_money}} </td>
                    <td class="text-center"> {{$detail -> gram_tax }} </td>
                    <td class="text-center"> {{ (float)($detail -> net_money ) - (float)($detail -> gram_tax)}} </td>
                    <td class="text-center" > {{$detail -> gram_price }} </td>
                    <td class="text-center"> {{ $detail -> no_metal_type == 1 ? $detail -> no_metal : $detail -> weight * ($detail -> no_metal / 100) }} </td>
                    <td class="text-center"> {{$detail -> weight}} </td>
                    <td class="text-center"> {{$detail -> karat_ar}} </td> 
                    <td class="text-center" > {{$detail -> item_ar}} </td>
                    
                    
                </tr>
            @endforeach

            <tr>
                <td class="text-center" colspan="2">{{($bill -> net_money + $bill -> discount) - $bill -> tax}}</td>
                <td class="text-center" colspan="3"> الاجمالي قبل الضريبة   (Total Without Vat)</td>
                <td class="text-center" colspan="3">ملاحظات الفاتورة</td>
            </tr>
            <tr>
                <td class="text-center" colspan="2">{{$bill -> discount}}  -  </td>
                <td class="text-center" colspan="3"> الخصم (Discount Value)</td> 
            </tr>
            <tr>
                <td class="text-center" colspan="2">{{$bill -> tax}}</td>
                <td class="text-center" colspan="3"> ضريبة القيمة المضافة  (Add Value Vat)</td>
                <td class="text-center" colspan="3" rowspan="2" >
                    <div class="visible-print text-left mt-1">
                        <?php
                        use Salla\ZATCA\GenerateQrCode;
                        use Salla\ZATCA\Tags\InvoiceDate;
                        use Salla\ZATCA\Tags\InvoiceTaxAmount;
                        use Salla\ZATCA\Tags\InvoiceTotalAmount;
                        use Salla\ZATCA\Tags\Seller;
                        use Salla\ZATCA\Tags\TaxNumber;
                        $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
                            new Seller($company -> name_ar), // seller name
                            new TaxNumber($company -> taxNumber), // seller tax number
                            new InvoiceDate($bill -> date), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
                            new InvoiceTotalAmount($bill -> net_money), // invoice total amount
                            new InvoiceTaxAmount($bill -> tax) // invoice tax amount
                            // TODO :: Support others tags
                        ])->render();
                        ?>
                        <img src="{{$displayQRCodeAsBase64}}" style="width: 70px; height: 70px;" alt="QR Code"/>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-center"  colspan="2">{{$bill -> net_money}}</td>
                <td class="text-center"  colspan="3"> قيمة الفاتورة
                    <br>(Total)
                </td>   
            </tr> 
            </tbody>
        </table> 
        <div class="row" style="direction:rtl">
            <div class="col-6 text-center">
                <span> اسم البائع</span> <br>
                <span>{{auth() -> user() -> name}}</span>
            </div>
            <div class="col-6 text-center">
                <span>  مدير الفرع</span> <br>
                <span>........</span>
            </div>
        </div>
    </div>


</div> 
 
</body>
</html>