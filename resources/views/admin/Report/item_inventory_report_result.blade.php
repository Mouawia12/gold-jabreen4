@extends('admin.layouts.master')
@section('content')
    @if (session('success'))
        <div class="alert alert-success  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
        <!-- row opened -->
    <style>
        table.display.w-100.text-nowrap.table-bordered.dataTable.dtr-inline {
            direction: rtl;
            text-align:center;
        }
        body{
            direction: rtl; 
        }
  
    </style>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">  
                <div class="card-body px-0 pt-0 pb-2"> 
                    <div class="card shadow mb-4">
                        <div class="card-header py-3"  id="head-right"  style="direction: rtl;"> 
                            <header>
                                <div class="row" style="direction: ltr;">
                                    <div class="col-4 text-left">
                                        <br> رقم الجرد (<strong> {{$inventory -> id}} </strong> ) 
                                        <br> تاريخ الجرد (<strong> {{$inventory -> date}} </strong> ) 
                                    </div>
                                    <div class="col-4 c text-center">
                                        <h4 class="alert alert-primary text-center">تقرير الجرد</h4> 
                                    </div>
                                    <div class="col-4 c">
                                        <span style="text-align: right;">
                                            {{$company ? $company -> name_ar : ''}}
                                            <br>  س.ت : {{$company ? $company -> taxNumber : ''}}
                                            <br>  ر.ض :  {{$company ? $company -> registrationNumber : ''}}
                                            <br>  تليفون :   {{$company ? $company -> phone : ''}}
                                        </span>
                                    </div>
                                </div>
                            </header> 
                        </div>
                        </div>    
                        <div class="card-body" style="direction: rtl;"> 
                            <div class="table-responsive hoverable-table" style="direction: rtl;"> 
                                <table class="display w-100  text-nowrap table-bordered" id="example1" 
                                   style="text-align: center;direction: rtl;">
                                    <thead>
                                        <tr>
                                            <th >#</th>
                                            <th >الكود</th>
                                            <th >الصنف</th>
                                            <th >العيار</th>
                                            <th > الوزن السابق</th>
                                            <th > الوزن بعد التعديل </th>
                                            <th > الحالة</th> 
    
                                        </tr>
                                    </thead>
                                    <tbody> 
                                    <?php $sum_total = 0 ?>
                                    @foreach($inventory_items as $item)
                                        <tr>
                                            <td class="text-center">{{$loop -> index + 1}}</td>
                                            <td class="text-center">{{$item -> code}}</td>
                                            <td class="text-center">{{$item -> name_ar}}</td> 
                                            <td class="text-center">{{ $item -> karat -> name_ar  }}</td>
                                            <td class="text-center">{{$item -> old_weight}}</td>
                                            <td class="text-center">{{$item -> new_weight}}</td> 
                                            <td class="text-center">{{$item -> state = 1? 'متوفر':''}}</td>
                                        <?php $sum_total = $loop -> index?> 
                                        </tr> 
                                    @endforeach 

                                    @foreach($inventory_sum as $items)
                                    
                                    <tr>
                                        <td class="text-center bg-primary  text-primary font-weight-bolder">{{ $sum_total+2  }}</td>
                                        <td class="text-center bg-primary  text-white font-weight-bolder"></td>
                                        <td class="text-center bg-primary  text-white font-weight-bolder"> <strong>الإجمالي </strong></td>
                                        <td class="text-center bg-primary  text-white font-weight-bolder"><b>{{ $items-> karat -> name_ar  }}</b></td>
                                        <td class="text-center bg-primary  text-white font-weight-bolder">{{$items->sum_weight_old}}</td> 
                                        <td class="text-center bg-primary  text-white font-weight-bolder">{{$items->sum_weight_new}}</td> 
                                        <td class="text-center bg-primary  text-white"></td> 
                                    </tr>
                                    @endforeach 
                                    </tbody>  
                                </table>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>     
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content --> 

    </div>
    <!-- End of Content Wrapper --> 
<!-- End of Page Wrapper --> 
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>

<script type="text/javascript">
    let id = 0;


    $(document).ready(function () {
        $(document).on('click', '#btnPrint', function (event) {
            print();

        });

    });
</script>
<script>
    $(document).ready(function () {
        document.title = "تقرير الجرد  - رقم: {{$inventory -> id}} - بتاريخ :{{$inventory -> date}}";
    });
</script>
 



