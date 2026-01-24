<!DOCTYPE html>
<html>
<head>
    <title>
        فاتورة مشتريات - ذهب مشغول  {{$bill -> bill_number}}
    </title>
    <meta charset="utf-8"/>
    <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
	<link href="{{asset('css/all.min.css')}}" rel="stylesheet" />
    <style type="text/css" media="screen">
  

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
    </style>
</head>
<body dir="rtl" style="background: #fff;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;" class="text-center">
          
<div class="pos_details  justify-content-center text-center"> 
    <div class="above-table w-50 text-center mt-3  justify-content-center" style="margin: 10px auto!important;">
            <!-- Main content -->
            <section class="invoice">
              <!-- title row -->
              <div class="row">

                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-4 invoice-col">  
                  <address>
                    <h5><strong>{{$company -> name_ar }}</strong></h5>
                    العنوان: {{$company -> address}}<br> 
                    الهاتف: {{$company -> phone}}<br> 
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-4 invoice-col">  
                    <h5>فاتورة نقدية </h5> 
                </div>
                <!-- /.col -->
                <div class="col-4 invoice-col text-left">
                  <b>فاتورة رقم : {{$bill -> bill_number}}</b><br> 
                  <b>تاريخ :</b> {{\Carbon\Carbon::parse($bill -> date) -> format('d- m -Y') }}<br>
                  <b>الرقم الضريبى :</b>  {{$company ->taxNumber}}<br>
                  <b> س . ت :</b>  {{$company ->registrationNumber}}<br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="col-12">
                  <hr>
                  <h2 class="page-header">
                     فاتورة شراء ذهب مشغول 
                  </h2>
                  <hr>
                  <h5><strong>المورد : </strong>{{$bill -> vendor_name}}</h5>
      
                </div>
          </section>
        <!-- /.content -->   
 
        <table style="width: 100% ; direction: rtl" class="table-bordered"> 
                <thead>
                <tr>
                    <th class="text-center" style="width: 10%">م</th>
                    <th class="text-center " style="width: 20%">العيار
                        <br>(Karat)</th>
                    <th class="text-center " style="width: 20%">الوزن
                        <br>(Weight)</th>
                    <th class="text-center " style="width: 20%">وزن ما يعادل 21
                        <br>(Weight*21)</th>
                    <th class="text-center " style="width: 20%">اجمالي الأجور
                         <br>(Sub Total)</th>
                </tr>
                </thead>
                <tbody id="tbody">
                <?php $sum_total = 0 ?>
                <?php $sum_21 = 0 ?>
                <?php $sum_weight = 0 ?>
                @foreach($details as $detail)
                    <tr>
                        <td class="text-center">{{$loop -> index + 1}}</td>
                        <td class="text-center"> {{Config::get('app.locale') == 'ar' ? $detail -> karat_ar : $detail -> karat_en}} </td>
                        <td class="text-center"> {{$detail -> weight}} </td>
                        <td class="text-center"> {{$detail -> weight21}} </td>
                        <td class="text-center"> {{$detail -> net_money}} </td>
                    </tr>
                    <?php $sum_weight += $detail -> weight ?>
                    <?php $sum_total += $detail -> net_money ?>
                    <?php $sum_21 += $detail -> weight21 ?>
                @endforeach
                  <tr >
                      <td class="text-center" colspan="2"> اجمالي الفاتورة</td>
                      <td class="text-center">{{$sum_weight}}</td>
                      <td class="text-center">{{$sum_21}}</td>
                      <td class="text-center">{{$sum_total}}</td>
                  </tr>
                <tr>
                    <td class="text-center" colspan="4"> اجمالي الخصم</td>
                    <td class="text-center">{{$bill -> discount}}</td>
                </tr>
                <tr>
                    <td class="text-center" colspan="4"> اجمالي الضريبة</td>
                    <td class="text-center">{{$bill -> tax}}</td>
                </tr>
                <tr>
                    <td class="text-center" colspan="2">  صافي النقدية</td>
                    <td class="text-center" colspan="2">  فقط لاغير  </td>
                    <td class="text-center">{{$bill -> net_money}}</td>
                </tr> 
                </tbody>
            </table>
            <br>
        <div class="row" style="direction:rtl">

            <div class="col-6 text-center">
                <span> المختص</span> <br>
                <span>........</span>
            </div>
            <div class="col-6 text-center">
                <span>  مدير الفرع</span> <br>
                <span>........</span>
            </div>
        </div> 
    </div>    

</div>
<button onclick="window.print();" class="no-print btn btn-md btn-success">اضغط للطباعة</button>
<a href="{{route('admin.home')}}" class="no-print btn btn-md btn-danger"
   style="left:150px!important;">
    العودة الى النظام
</a>

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        window.print();
    });
</script>
</body>
</html> 
