<!DOCTYPE html>
<html>
<head>
    <title>
         فاتورة ضريبية مبسطة رقم  {{$bill -> bill_number}}
    </title>
    <meta charset="utf-8"/>
    <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <style type="text/css" media="screen">
        @font-face {
            font-family: 'Almarai';
            src: url("{{asset('fonts/Almarai.ttf')}}");
        } 
        * {
            color: #000 !important;
        }

        body, html {
            color: #000;
            font-family: 'Almarai' !important;
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
            display: none;
        }
        .sales-policy {
            width: 72%;
            margin: 16px 0 10px auto;
            text-align: right;
            line-height: 1.7;
            font-size: 11px !important;
            font-weight: 400 !important;
        }
        .sales-policy * {
            font-weight: 400 !important;
        }
        .sales-policy-title {
            font-size: 12px !important;
            font-weight: 700 !important;
            margin-bottom: 4px;
        }
        .sales-policy-subtitle {
            font-size: 11px !important;
            font-weight: 700 !important;
            margin-bottom: 4px;
        }
        .sales-policy-list {
            margin: 0;
            padding-right: 18px;
        }
        .sales-policy-list li {
            margin-bottom: 4px;
        }
        .sales-policy-note {
            margin-top: 6px;
        }
    </style>
    <style type="text/css" media="print">
        .above-table {
            width: 100% !important;
        }

        table {
            text-align: center;
            width: 100% !important;
            margin-top: 10px !important;
        }

        table thead tr, table tbody tr {
            border-bottom: 1px solid #aaa;
        }

        * {
            color: #000 !important;
        }

        body, html {
            color: #000;
            padding: 0px;
            margin: 0;
            font-family: 'Almarai' !important;
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
        }

        .no-print {
            display: none;
        }
        div#sales-header {
            display: none;
        }
        .sales-policy {
            width: 72%;
            margin: 14px 0 10px auto;
            text-align: right;
            line-height: 1.7;
            font-size: 11px !important;
            font-weight: 400 !important;
        }
        .sales-policy * {
            font-weight: 400 !important;
        }
        .sales-policy-title {
            font-size: 12px !important;
            font-weight: 700 !important;
            margin-bottom: 4px;
        }
        .sales-policy-subtitle {
            font-size: 11px !important;
            font-weight: 700 !important;
            margin-bottom: 4px;
        }
        .sales-policy-list {
            margin: 0;
            padding-right: 18px;
        }
        .sales-policy-list li {
            margin-bottom: 4px;
        }
        .sales-policy-note {
            margin-top: 6px;
        }
    </style>
</head>
<body dir="rtl" style="background: #fff;
    page-break-before: avoid;
    page-break-after: avoid;
    page-break-inside: avoid;" class="text-center">
          
<div class="pos_details  justify-content-center text-center"> 
    <div class="above-table w-50 text-center mt-3  justify-content-center" style="margin: 10px auto!important;">
        <header style="width: 95% ; display: block; margin: auto ; height: 3cm;" >
            <div class="row" id="sales-header">
                <div class="col-4 text-right">   
                    <br> {{$company ? $company -> name_ar : ''}} 
                    <br>  س.ت : {{$company ? $company -> taxNumber : ''}}
                    <br>  ر.ض :  {{$company ? $company -> registrationNumber : ''}}
                    <br>  تليفون :   {{$company ? $company -> phone : ''}} 
                </div> 
                <div class="col-4 c"> 
                    <img src="{{URL::asset('assets/img/logo.png')}}" width="100" height="100">
                </div> 
                <div class="col-4 c">
                </div>
            </div>
        </header>  
        <div class="row" id="" style="direction:rtl">
            <div class="col-4 text-right">
                <h6 class="text-right mt-1" style="font-weight: bold;">
                    رقم الفاتورة :
                    <span dir="ltr">
                        {{$bill -> bill_number}}
                    </span>
                </h6>
                <h6 class="text-right mt-1" style="font-weight: bold;">
                    التاريخ :
                    <span dir="ltr">
                         {{\Carbon\Carbon::parse($bill -> date) -> format('d- m -Y') }}
                    </span>
                </h6>
                <h6 class="text-right mt-1" style="font-weight: bold;"> 
                    الفرع :
                    <span dir="ltr">
                        {{$bill -> branch_name}}
                    </span>
                </h6>
                <h6 class="text-right mt-1" style="font-weight: bold;">
                    المباع على المكرم :
                    <span dir="ltr">
                    {{$bill -> vendor_name != 'عميل نقدي افتراضي'  ?$bill -> vendor_name : $bill  -> bill_client_name }}
                    </span>
                </h6>
            </div>
            <div class="col-4 text-center">
                <h4 class="text-center mt-1" style="font-weight: bold;">
                    <strong>فاتورة ضريبية مبسطة</strong> 
                </h4>
            </div>
            <div class="col-4 text-left">
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
                     <!--
                    
                   !-->
                    @if(!empty($bill->qr))
                        <img src="https://api.qrserver.com/v1/create-qr-code/?data={{$bill->qr}}" style="width: 120px; height: 120px;" alt="QR Code"/>
                    @else
                        <img src="{{$displayQRCodeAsBase64}}" style="width: 70px; height: 70px;" alt="QR Code"/>
                    @endif
                    
                </div>
            </div>
            <div class="clearfix"> </div> 
        </div>
         
        <table style="width: 100% ; direction: rtl" class="table-bordered">
            <thead>
            <tr> 
                <th class="text-center " >وصف الصنف
                    <br>(Item) </th>
                <th class="text-center " >العيار
                    <br>(Karat)</th>
                <th class="text-center " > وزن الذهب
                    <br>(Weight)</th>
                <th class="text-center " >ما خلا من المعدن
                    <br>(Non Metal)</th>
                <th class="text-center " > سعر الجرام
                    <br>(Gram Price) </th>
                <th class="text-center " >الإجمالي(Total)</th>
                <th class="text-center " >الضريبة
                    <br> (Vat) </th>
                <th class="text-center " >الإجمالي شامل الضريبة
                    <br>(Total With Vat)</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php $sum_total = 0 ?>
            <?php $sum_tax = 0 ?>
            <?php $sum_weight = 0 ?>
            @foreach($details as $detail)
                <tr>
                 
                    <td class="text-center" > {{$detail -> item_ar}} </td>
                    <td class="text-center"> {{ $detail -> karat_ar}} </td>
                    <td class="text-center"> {{$detail -> weight}} </td>
                    <td class="text-center"> {{ $detail -> no_metal_type == 1 ? $detail -> no_metal : $detail -> weight * ($detail -> no_metal / 100) }} </td>
                    <td class="text-center" > {{$detail -> gram_price }} </td>
                    <td class="text-center"> {{ (float)($detail -> net_money ) - (float)($detail -> gram_tax)}} </td>
                    <td class="text-center"> {{$detail -> gram_tax }} </td>
                    <td class="text-center"> {{$detail -> net_money}} </td>
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
                <td class="text-center" colspan="3" rowspan="3" >  </td>
            </tr>
            <tr>
                <td class="text-center"  colspan="2">{{$bill -> net_money}}</td>
                <td class="text-center"  colspan="3"> قيمة الفاتورة
                    <br>(Total)
                </td>   
            </tr>
            <tr>
                <td class="text-center"  colspan="8">{{$amar}}</td>
            </tr> 
            </tbody>
        </table>
        @include('partials.sales_policy')
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


<a href="{{route('pos')}}" class="no-print btn btn-md btn-danger"
   style="left:20px!important;">
    العودة الى النظام
</a>
<button onclick="window.print();" class="no-print btn btn-md btn-info"
    style="left:230px!important;">
    اضغط للطباعة
</button>
@if(!empty($bill ->client_phone))
<a href="{{route('send.invoice.whatsapp',$bill ->id)}}" class="no-print btn btn-md btn-success"
   style="left:450px!important;">
    ارسال الفاتورة واتس اب
</a>
@endif


<script src="{{asset('assets/js/jquery.min.js')}}"></script>

<script>
    $(document).ready(function () {
        window.print();
    });
</script>
</body>
</html>
