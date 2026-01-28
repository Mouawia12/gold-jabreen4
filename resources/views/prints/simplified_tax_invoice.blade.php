<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>فاتورة ضريبية مبسطة</title>
    @php
        $fontPath = str_replace('\\', '/', public_path('fonts/Tajawal-Regular.ttf'));
    @endphp
    <style>
        @page { margin: 8mm 8mm 22mm 8mm; }
        @font-face {
            font-family: 'Tajawal';
            src: url("file:///{{ $fontPath }}") format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        html, body { height: 100%; }
        * { box-sizing: border-box; font-family: 'Tajawal'; }
        body {
            direction: rtl;
            font-family: 'Tajawal';
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
        }
        table, th, td { direction: rtl; }
        th, td { vertical-align: middle; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .muted { color: #444; }
        .small { font-size: 11px; }
        .title { font-size: 16px; font-weight: bold; margin: 4px 0; }
        .subtitle { font-size: 13px; font-weight: bold; margin: 2px 0; }
        .hr { border-top: 1px solid #555; margin: 6px 0 8px; }
        table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: top; }
        .header-table .block { line-height: 1.6; }
        .header-table .logo img { max-width: 110px; max-height: 110px; }
        .meta-table, .items-table, .summary-table, .weights-table, .payments-table { border: 1px solid #999; }
        .meta-table th, .meta-table td,
        .items-table th, .items-table td,
        .summary-table th, .summary-table td,
        .weights-table th, .weights-table td,
        .payments-table th, .payments-table td {
            border: 1px solid #999;
            padding: 4px;
        }
        .items-table th { background: #e0e0e0; }
        .qr-box {
            border: 1px solid #999;
            width: 150px;
            height: 150px;
            margin: 0 auto;
        }
        .qr-box table { width: 100%; height: 100%; }
        .qr-box td { text-align: center; vertical-align: middle; }
        .qr-box img { max-width: 135px; max-height: 135px; }
        .section-gap { margin-top: 8px; }
        .page { min-height: 100%; }
        .page-content { padding-bottom: 26mm; }
        .footer {
            border-top: 1px solid #555;
            padding: 6px 0 0;
            position: fixed;
            left: 8mm;
            right: 8mm;
            bottom: 8mm;
            background: #fff;
        }
        .ltr { direction: ltr; unicode-bidi: bidi-override; }
        .meta-grid td { vertical-align: top; }
        .meta-details-table td { padding: 2px 6px; }
    </style>
</head>
<body>
<div class="page">
<div class="page-content">
@php
    $fmt = function ($value) {
        return number_format((float) $value, 2, '.', ',');
    };
@endphp

<table class="header-table">
    <tr>
        <td class="text-right" style="width: 33%;">
            <div class="block">
                <strong>{{ $company['company_ar'] }}</strong><br>
                الرقم الضريبي: {{ $company['tax_number'] }}<br>
                السجل التجاري: {{ $company['commercial_registry'] }}<br>
                @if($company['mineral_license'])
                    رخصة المعادن: {{ $company['mineral_license'] }}<br>
                @endif
                {{ $branch['branch_ar'] }}<br>
            </div>
        </td>
        <td class="text-center" style="width: 34%;">
            <div class="logo">
                @if($company['logo_path'])
                    @php $logoPath = str_replace('\\', '/', $company['logo_path']); @endphp
                    <img src="file:///{{ $logoPath }}" alt="Logo">
                @endif
            </div>
            <div class="title">فاتورة ضريبية مبسطة</div>
            <div class="subtitle">Simplified Tax Invoice</div>
        </td>
        <td class="text-left ltr" style="width: 33%;">
            <div class="block">
                <strong>{{ $company['company_en'] }}</strong><br>
                Tax Number: {{ $company['tax_number'] }}<br>
                Commercial Registry: {{ $company['commercial_registry'] }}<br>
                @if($company['mineral_license'])
                    Mineral License: {{ $company['mineral_license'] }}<br>
                @endif
                {{ $branch['branch_en'] }}<br>
            </div>
        </td>
    </tr>
</table>

<div class="hr"></div>

<table class="meta-grid">
    <tr>
        <td style="width: 70%; vertical-align: top;">
            <table class="meta-details-table">
                <tr>
                    <td class="text-right">التاريخ: <span class="ltr">{{ $invoice['date'] }}</span></td>
                    <td class="text-right">الرقم: <span class="ltr">{{ $invoice['invoice_no'] }}</span></td>
                </tr>
                <tr>
                    <td class="text-right">الوقت: <span class="ltr">{{ $invoice['time'] }}</span></td>
                    <td class="text-right">النوع: {{ $invoice['type'] }}</td>
                </tr>
                <tr>
                    <td class="text-right">العميل: {{ $invoice['customer_name'] ?: '-' }}</td>
                    <td class="text-right">التليفون: <span class="ltr">{{ $invoice['customer_phone'] ?: '-' }}</span></td>
                </tr>
                <tr>
                    <td class="text-right">أمر البيع: <span class="ltr">{{ $invoice['sale_order_ref'] }}</span></td>
                    <td class="text-right">&nbsp;</td>
                </tr>
            </table>
        </td>
        <td style="width: 30%; vertical-align: top;">
            <div class="qr-box">
                <table>
                    <tr>
                        <td>
                            @if($qr_image_data_uri)
                                <img src="{{ $qr_image_data_uri }}" alt="QR">
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>

<div class="section-gap"></div>

<table class="items-table">
    <thead>
        <tr>
            <th>مسلسل</th>
            <th>الوصف</th>
            <th>العيار</th>
            <th>الوزن</th>
            <th>ما خلا المعدن</th>
            <th>سعر الجرام</th>
            <th>العدد</th>
            <th>الإجمالي</th>
            <th>VAT</th>
            <th>نسبة الضريبة</th>
            <th>الإجمالي شامل الضريبة</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <td class="text-center">{{ $item['line_no'] }}</td>
                <td class="text-center">{{ $item['description'] }}</td>
                <td class="text-center">{{ $item['karat'] }}</td>
                <td class="text-center">{{ $fmt($item['weight']) }}</td>
                <td class="text-center">{{ $fmt($item['metal_extra']) }}</td>
                <td class="text-center">{{ $fmt($item['gram_price']) }}</td>
                <td class="text-center">{{ $fmt($item['qty']) }}</td>
                <td class="text-center">{{ $fmt($item['subtotal_excl_vat']) }}</td>
                <td class="text-center">{{ $fmt($item['vat_amount']) }}</td>
                <td class="text-center">{{ $item['vat_rate'] }}%</td>
                <td class="text-center">{{ $fmt($item['total_incl_vat']) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="section-gap"></div>

<table>
    <tr>
        <td style="width: 50%; vertical-align: top;">
            <table class="payments-table">
                <tr>
                    <th colspan="2" class="text-center">طرق الدفع</th>
                </tr>
                <tr>
                    <th>نقدي</th>
                    <td class="text-left ltr">{{ $fmt($payments['cash_amount']) }} {{ $invoice['currency'] }}</td>
                </tr>
                <tr>
                    <th>شبكة</th>
                    <td class="text-left ltr">{{ $fmt($payments['card_amount']) }} {{ $invoice['currency'] }}</td>
                </tr>
            </table>
        </td>
        <td style="width: 50%; vertical-align: top;">
            <table class="summary-table">
                <tr>
                    <th>صافي الفاتورة قبل الخصم</th>
                    <td class="text-left ltr">{{ $fmt($summary['net_before_discount']) }} {{ $invoice['currency'] }}</td>
                </tr>
                <tr>
                    <th>إجمالي الخصم</th>
                    <td class="text-left ltr">{{ $fmt($summary['discount_total']) }} {{ $invoice['currency'] }}</td>
                </tr>
                <tr>
                    <th>صافي الفاتورة بعد الخصم</th>
                    <td class="text-left ltr">{{ $fmt($summary['net_after_discount']) }} {{ $invoice['currency'] }}</td>
                </tr>
                <tr>
                    <th>إجمالي الضريبة المضافة</th>
                    <td class="text-left ltr">{{ $fmt($summary['vat_total']) }} {{ $invoice['currency'] }}</td>
                </tr>
                <tr>
                    <th>الصافي شامل الضريبة</th>
                    <td class="text-left ltr">{{ $fmt($summary['grand_total']) }} {{ $invoice['currency'] }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div class="section-gap"></div>

<div class="text-right">البائع: {{ $seller['seller_name'] }}</div>

</div>
<div class="footer">
    <table>
        <tr>
            <td class="text-right">{{ $footer['footer_ar'] }}</td>
            <td class="text-left ltr">{{ $footer['footer_en'] }}</td>
        </tr>
    </table>
</div>
</div>
</body>
</html>
