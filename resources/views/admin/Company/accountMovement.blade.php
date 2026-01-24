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
        <div class="card col-12">
            <div class="card-body px-0 pt-0 pb-2"> 
                <div class="card-header py-3 " id="head-right"  style="direction: rtl;border:solid 1px gray"> 
                    <div class="row">
                        <div class="col-3" style=""> 
                            {{$company ? $company -> name_ar : ''}}
                           <br>  س.ت : {{$company ? $company -> taxNumber : ''}}
                           <br>  ر.ض :  {{$company ? $company -> registrationNumber : ''}}
                           <br>  تليفون :   {{$company ? $company -> phone : ''}}  
                        </div>   
                        <div class="col-6 title text-center"> 
                            <h4  class="alert alert-primary text-center">
                               تقرير كشف حساب عميل / مورد
                            </h4>
                            <h5>
                               [ {{$client  ? $client  -> name: ''}} ]
                            </h5>
                            @if(isset($branch))
                            <h5 class="text-center"> [ {{$branch->branch_name}} ] </h5>
                            @else
                            <h5 class="text-center"> [ جميع الفروع ] </h5>
                            @endif
                            <h6 class="text-center"> [ {{Config::get('app.locale') == 'ar' ? $period_ar : $period}} ]</h6>
                        </div>
                        <div class="col-3"> 
                        </div>
                    </div>
                </div>  
                <div class="card-body">

                    <div class="table-responsive hoverable-table">
                        <table class="display w-100  text-nowrap table-bordered" id="example1" 
                               style="text-align: center;">
                                   <thead> 
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">#</th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7 ps-2">{{__('main.date')}}</th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">{{__('main.bill_no')}}</th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">{{__('main.document_type')}}</th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7" colspan="2">{{__('main.balance_gold')}}</th> 
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7" colspan="2">{{__('main.balance')}}</th> 
                                        </tr>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"></th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"></th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"></th>                                            
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"></th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">مدين</th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">دائن</th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">مدين</th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">دائن</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sum_weight_d = 0 ;
                                    $sum_weight_c = 0 ;
                                    $sum_money_d = 0 ;
                                    $sum_money_c = 0 ;

                                    ?>
                                       @foreach($movements as $movement)
                                           <tr>
                                               <td class="text-center">{{$loop -> index + 1}}</td>
                                               <td class="text-center">{{$movement -> date}}</td>
                                               <td class="text-center">{{$movement -> bill_number}}</td>
                                               <td class="text-center">{{$movement -> invoice_type}}</td>
                                               <td class="text-center">{{ round($movement -> debit_gold , 2) }}</td>
                                               <td class="text-center">{{round($movement -> credit_gold , 2) }}</td>
                                               <td class="text-center">{{round($movement -> debit_money , 2)}}</td>
                                               <td class="text-center">{{round($movement -> credit_money , 2) }}</td>
                                           </tr>

                                           <?php
                                           $sum_weight_d += $movement ->  debit_gold;
                                           $sum_weight_c += $movement ->  credit_gold ;
                                           $sum_money_d  += $movement ->  debit_money ;
                                           $sum_money_c  += $movement ->  credit_money ;

                                           ?>
                                       @endforeach
 
                                    </tbody>
                                    <tfoot>
                                    <tr style="background: antiquewhite; font-weight: bold">
                                           <td class="text-center">الإجمالي</td>
                                           <td class="text-center"></td>
                                           <td class="text-center"></td>
                                           <td class="text-center"></td>
                                           <td class="text-center">{{round($sum_weight_d , 2) }}</td>
                                           <td class="text-center">{{round($sum_weight_c , 2) }}</td>
                                           <td class="text-center">{{round($sum_money_d , 2) }}</td>
                                           <td class="text-center">{{round($sum_money_c , 2)}}</td>

                                       </tr>
                                    <tr style="background: lightblue; font-weight: bold">
                                        <td class="text-center">الصافي</td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center" colspan="2">{{round($sum_weight_d  - $sum_weight_c, 2) }}</td>
                                        <td class="text-center" colspan="2">{{round( $sum_money_c - $sum_money_d, 2) }}</td>


                                    </tr> 
                                </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
            <!-- /.container-fluid -->

        </div>
  
    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
<!-- Page level custom scripts -->
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>

<script type="text/javascript">
    let id = 0;


    $(document).ready(function () {
        $(document).on('click', '#btnPrint', function (event) {
            printPage();

        });

    });

    function printPage(){
        var css = '@page { size: landscape; }',
            head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');

        style.type = 'text/css';
        style.media = 'print';

        if (style.styleSheet){
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }

        head.appendChild(style);

        window.print();
    }
</script>
<script>
    $(document).ready(function () {
        document.title = "تقرير كشف حساب عميل - مورد {{$client  -> name}}";
    });
</script>
 