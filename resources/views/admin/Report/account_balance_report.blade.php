@extends('admin.layouts.master')
@section('content')
@can('التقارير المحاسبية')  
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
                    <div class="card shadow mb-3 ">
                        <div class="card-header py-3 " id="head-right"  style="direction: rtl;border:solid 1px gray"> 
                          <div class="row">
                            <div class="col-3"> 
                                {{$company ? $company -> name_ar : ''}}
                               <br>  س.ت : {{$company ? $company -> taxNumber : ''}}
                               <br>  ر.ض :  {{$company ? $company -> registrationNumber : ''}}
                               <br>  تليفون :   {{$company ? $company -> phone : ''}}  
                            </div>   
                            <div class="col-6 title text-center">   
                                <h4  class="alert alert-primary text-center">
                                   {{__('main.balance_report')}}
                                </h4>
                                <h4 class="text-center"> [ {{Config::get('app.locale') == 'ar' ? $period_ar : $period}} ] </h4>
                            </div>
                            <div class="col-3 text-left">  
                                 <img src="{{  $company ?  $company -> logo ?   asset('uploads/CompanyInfo' . '/' . $company -> logo)   : URL::asset('assets/img/logo-new.png') : URL::asset('assets/img/logo-new.png')}}"   id="profile-img-tag" width="120px" height="70px" class="profile-img"/>
                            </div>
                          </div>
                        </div> 
                    </div>
                </div>  
                <div class="card-body"> 
                    <div class="table-responsive hoverable-table" style="direction: rtl;"> 
                        <table class="display w-100 table-bordered  caption-top" id="example1" 
                           style="text-align: center;direction: rtl;"> 
                            <thead> 
                                <tr>
                                    <th rowspan="2" data-dt-order="disable">{{__('main.account_name')}}</th>
                                    <th rowspan="1" colspan="2" data-dt-order="disable">{{__('main.Before_Debit')}}</th>
                                    <th rowspan="1" colspan="2" data-dt-order="disable">{{__('main.movement')}}</th>
                                    <th rowspan="1" colspan="2" data-dt-order="disable"> {{__('main.After_Debit')}}</th>
                                    <th rowspan="1" colspan="2" data-dt-order="disable"> {{__('main.balance')}}</th>
                                </tr>
                                <tr> 
                                    <th rowspan="1" >{{__('main.Debit')}}</th>
                                    <th rowspan="1" >{{__('main.Credit')}}</th>
                                    <th rowspan="1" >{{__('main.Debit')}}</th>
                                    <th rowspan="1" >{{__('main.Credit')}}</th>
                                    <th rowspan="1" >{{__('main.Debit')}}</th>
                                    <th rowspan="1" >{{__('main.Credit')}}</th>
                                    <th rowspan="1" >{{__('main.Debit')}}</th>
                                    <th rowspan="1" >{{__('main.Credit')}}</th>
    
                                </tr>
                            </thead>
                            <tbody>
                            <?php  
                            $before_credit = 0 ;
                            $before_debit = 0 ;
                            $credit = 0 ;
                            $debit = 0 ;
                            $total_credit = 0 ;
                            $total_debit = 0 ;
                            $balance_credit = 0 ;
                            $balance_debit = 0 ;
                            ?>

                            @foreach($accounts as $index=>$unit)
                                <tr>
                                    <td class="text-center">{{$unit->name}}</td>
                                    <td class="text-center">{{$unit->before_debit}}</td> 
                                    <td class="text-center">{{$unit->before_credit}}</td>
                                    <td class="text-center">{{$unit->debit}}</td>
                                    <td class="text-center">{{$unit->credit}}</td> 
                                    <td class="text-center">{{$unit->before_debit + $unit->debit}}</td>
                                    <td class="text-center">{{$unit->before_credit + $unit->credit}}</td>  
                                    <td class="text-center">{{ number_format(((($unit->before_debit + $unit->debit) - ($unit->before_credit + $unit->credit))  > 0 ? (($unit->before_debit + $unit->debit) - ($unit->before_credit + $unit->credit))  : 0 ),2)}}</td>
                                    <td class="text-center">{{ number_format(((($unit->before_debit + $unit->debit) - ($unit->before_credit + $unit->credit))  < 0 ? (($unit->before_debit + $unit->debit) - ($unit->before_credit + $unit->credit)) * - 1  : 0 ),2)}}</td>
                                </tr> 
                                <?php  
                                $before_credit += $unit->before_credit ;
                                $before_debit += $unit->before_debit ;
                                $credit += $unit->credit ;
                                $debit += $unit->debit ;
                                $total_credit += $unit->before_credit + $unit->credit ;
                                $total_debit += $unit->before_debit + $unit->debit ;
                                $balance_credit += (($unit->before_debit + $unit->debit) - ($unit->before_credit + $unit->credit))  > 0 ? (($unit->before_debit + $unit->debit) - ($unit->before_credit + $unit->credit))  : 0 ;
                                $balance_debit += (($unit->before_debit + $unit->debit) - ($unit->before_credit + $unit->credit))  < 0 ? (($unit->before_debit + $unit->debit) - ($unit->before_credit + $unit->credit)) * - 1  : 0 ;
                                ?>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-primary text-white">
                                    <td class="text-center"> اجمالي الميزان  </td>
                                    <td class="text-center">{{$before_debit}}  </td>
                                    <td class="text-center">{{$before_credit}}  </td>
                                    <td class="text-center">{{$debit}}  </td>
                                    <td class="text-center">{{$credit}}  </td>
                                    <td class="text-center">{{$total_debit}}  </td>
                                    <td class="text-center">{{$total_credit}}  </td>
                                    <td class="text-center">{{$balance_debit}}  </td>
                                    <td class="text-center">{{$balance_credit}}  </td> 
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div> 
            </div> 
        </div> 
         <!-- End of Main Content --> 
    </div>
    <!-- End of Page Wrapper --> 

@endcan 
@endsection 
@section('js') 
<script type="text/javascript">
    document.title = "{{__('main.balance_report')}}";
    $(document).ready(function () {
        $(document).on('click', '#btnPrint', function (event) {
            window.print(); 
        }); 
    }); 
</script> 
@endsection 

