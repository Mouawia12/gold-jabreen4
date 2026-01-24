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
                <div class="card-body px-0 pt-0 pb-2"> 
                    <div class="card shadow mb-3 ">
                        <div class="card-header py-3 " id="head-right"  style="direction: rtl;border:solid 1px gray"> 
                          <div class="row">
                            <div class="col-3" > 
                                {{$company ? $company -> name_ar : ''}}
                               <br>  س.ت : {{$company ? $company -> taxNumber : ''}}
                               <br>  ر.ض :  {{$company ? $company -> registrationNumber : ''}}
                               <br>  تليفون :   {{$company ? $company -> phone : ''}}  
                            </div> 
                            <div class="col-6 title text-center"> 
                                <h4  class="alert alert-primary text-center">
                                {{__('تقرير مردود المشتريات')}}
                                </h4>
                                @if(isset($branch))
                                 <h5 class="text-center"> [ {{$branch->branch_name}} ] </h5>
                                 @else
                                 <h5 class="text-center"> [ جميع الفروع ] </h5> 
                                 @endif
                                <strong class="m-4">{{ $type ?? 'N/A'}} </strong>
                                <h5 class="text-center">  {{Config::get('app.locale') == 'ar' ? $period_ar : $period}} </h5>
                            </div>
                            <div class="col-3 text-left"> 
                                <img src="{{  $company ?  $company -> logo ?   asset('uploads/CompanyInfo' . '/' . $company -> logo)   : URL::asset('assets/img/logo-new.png') : URL::asset('assets/img/logo-new.png')}}"   id="profile-img-tag" width="120px" height="70px" class="profile-img"/>
                            </div>   
                          </div>
                        </div>   
                        <div class="card-body"> 
                            <div class="table-responsive hoverable-table"id="d-table"   style="direction: rtl;"> 
                                <table class="display w-100  text-nowrap table-bordered" id="example1" 
                                   style="text-align: center;direction: rtl;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{__('main.bill_no')}}</th>
                                            <th>{{__('main.date')}}</th>
                                            <th>{{__('main.document_type')}}</th>
                                            <th>{{__('main.supplier')}}</th>  
                                            <th>{{__('main.karat')}} </th>
                                            <th>{{__('الوزن(جرام)')}} </th>
                                            <th>{{__('main.total_weight21')}} </th>
                                            <th>{{__('main.net_money')}} </th>
                                            <th>{{__('الضريبة')}} </th>
                                            <th>{{__('main.made_Value_t')}}</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $sum_weight = 0 ?>
                                    <?php $sum_total = 0 ?>
                                    <?php $sum_tax = 0 ?>
                                    <?php $sum_made = 0 ?>
                                    <?php $sum_net = 0 ?>
                                    <?php $sum_weight21 = 0 ?>
                                    
                                    @foreach($bills as $item)
                                        <tr>
                                            <td class="text-center">{{$loop -> index + 1}}</td>
                                            <td class="text-center">
                                               @if($item -> type == 1 )
                                                <a href="{{route('workEntryPreview' , $item -> id)}}" target="_blank">{{$item -> bill_number}}</a>
                                                @else
                                                <a href="{{route('oldEntryPreview' , $item -> id)}}" target="_blank">{{$item -> bill_number}}</a>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($item -> date) -> format('d-m-Y')  }}</td>
                                            <td class="text-center">
                                                @if($item -> type == 1) 
                                                    {{__('main.new_gold')}}
                                                @elseif($item -> type == 2)    
                                                    {{__('ذهب صافي')}}
                                                @elseif($item -> type == 0)       
                                                    {{__('ذهب كسر')}}
                                                @endif

                                               
                                            </td>
                                            <td class="text-center">{{ $item -> supplier  }}</td>  
                                            <td class="text-center">{{ $item -> karat_name_ar }}</td>
                                            <td class="text-center">{{$item -> weight < 0 ? $item -> weight *-1 : $item -> weight}}</td>
                                            <td class="text-center">{{$item -> weight21 < 0 ? $item -> weight21 *-1 : $item -> weight21}}</td>  
                                            <td class="text-center">{{$item -> net_money < 0 ? $item -> net_money *-1 : $item -> net_money}}</td>
                                            <td class="text-center">{{$item -> tax < 0 ? $item -> tax *-1 :$item -> tax}}</td> 
                                            @if($item -> net_money > 0)
                                                <td class="text-center">{{($item -> net_money + $item -> tax) - ($item -> made_money+ $item -> tax) }}</td> 
                                            @else
                                                <td class="text-center">{{(($item -> net_money * -1) + ($item -> tax * -1)) - (($item -> made_money *-1)+ ($item -> tax*-1)) }}</td> 
                                            @endif
                                        </tr>
                                        <?php $sum_weight += $item -> weight < 0 ? $item -> weight *-1 : $item -> weight ?> 
                                        <?php 
                                            if($item -> net_money > 0){
                                                $sum_made += ($item -> net_money + $item -> tax) - ($item -> made_money+ $item -> tax);
                                            }else{
                                                $sum_made += (($item -> net_money *-1) + ($item -> tax*-1)) - (($item -> made_money*-1)+ ($item -> tax*-1)); 
                                            } 
                                        ?>
                                        <?php $sum_weight21 += $item -> weight21 < 0 ? $item -> weight21 *-1 : $item -> weight21?>
                                        <?php $sum_tax += $item -> tax < 0 ? $item -> tax *-1 :$item -> tax ?>
                                        <?php $sum_net += $item -> net_money < 0 ? $item -> net_money *-1 : $item -> net_money?>
                                    @endforeach 
                                    </tbody>  
                                    <tfoot>
                                        <tr class="bg-primary text-white font-weight-bolder">
                                            <td colspan="5"></td> 
                                            <td class="text-center">الإجمالي</td>
                                            <td class="text-center">{{$sum_weight}}</td>
                                            <td class="text-center">{{$sum_weight21}}</td>
                                            <td class="text-center">{{$sum_net}}</td>
                                            <td class="text-center">{{$sum_tax}}</td>  
                                            <td class="text-center">{{$sum_made}}</td>  
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>    
                            <div class="table-responsive hoverable-table" style="direction: rtl;"> 
                                <hr>
                                <h2 class="text-center">الإجماليات حسب العيار</h2>
                                <table class="display w-100  text-nowrap table-bordered" id="example1" 
                                   style="text-align: center;direction: rtl;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> {{__('main.karat')}} </th>
                                            <th>{{__('main.net_weight')}}</th>
                                            <th>{{__('main.total_weight21')}}</th>
                                            <th> {{__('main.net_money')}} </th>
    
                                        </tr>
                                    </thead>
                                    <tbody> 
                                    @foreach(Config::get('app.locale') == 'ar' ? $grouped_ar : $grouped_en as $group => $items)
                                        <?php $sum_weight_group = 0 ?>
                                        <?php $sum_made_g = 0 ?>
                                        <?php $sum_net_g = 0 ?>
                                        <?php $weight21 = 0 ?>
                                        @foreach($items as $item)
                                            <?php $sum_weight_group += $item -> weight < 0 ? $item -> weight*-1:$item -> weight?>
                                            <?php $sum_made_g += $item -> made_money < 0 ? $item -> made_money*-1:$item -> made_money ?>
                                            <?php $sum_net_g += $item -> net_money < 0 ? $item -> made_money*-1:$item -> made_money ?>
                                            <?php $weight21 += $item -> weight21 < 0 ? $item -> weight21*-1:$item -> weight21 ?>
                                        @endforeach
                                        <tr>
                                            <td class="text-center">{{$loop -> index + 1}}</td>
                                            <td class="text-center">{{$group}}</td>
                                            <td class="text-center">{{$sum_weight_group}} </td>
                                            <td class="text-center">{{$weight21}} </td> 
                                            <td class="text-center">{{$sum_net_g}} </td>
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
        document.getElementById("main-header").style.display = 'none';
        document.getElementById("main-footer").style.display = 'none'; 
        document.getElementById("back-to-top").style.display = 'none';
        document.getElementById("example1").style.display = 'none';
        document.getElementById("d-table").style.display = 'none';
        window.print();
        document.getElementById("main-header").style.display = 'block';
        document.getElementById("main-footer").style.display = 'block'; 
        document.getElementById("back-to-top").style.display = 'block';
        document.getElementById("example1").style.display = 'block';
        document.getElementById("d-table").style.display = 'block';
    }
</script>
<script>
    $(document).ready(function () {
        document.title = " {{__('تقرير مردود المشتريات')}}";
    });
</script>
 



