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
        @media print{
    @page {
        size: A4 landscape;
        margin: 0 !important;
    }

    table {
        page-break-inside: avoid;
    }
    thead {
        display: table-header-group;
    }




}
.c{

    display: flex;
    justify-content: center;
    margin: 0;
    flex-direction: column;
    padding: 6px;
}
</style>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0" id="card-header">
                    <div class="col-lg-12 margin-tb">
                        <h4  class="alert alert-primary text-center"> 
                                {{__('main.gold_stock')}} 
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body px-0 pt-0 pb-2"> 
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 " style="border:solid 1px gray">
                            <header>
                                    <div class="row" style="direction: ltr;">
                                        <div class="col-4 text-left">   
                                            <br> 
                                            <button type="button" class="btn btn-primary btnPrint" id="btnPrint"><i class="fa fa-print"></i></button>
                                        </div>
                                        <div class="col-4 c">
                                            <label style="text-align: center; font-weight: bold"> ميزان مراجعةرصيد الذهب </label>
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
 
                        <div class="card-body">
                            <h4 class="text-center">  {{Config::get('app.locale') == 'ar' ? $period_ar : $period}} </h4>
                            <div class="table-responsive">
                                <h3 class="text-center" style="margin: 15px auto ;">{{__('main.gold_stock_by_karat')}}</h3>
                                <table class="display w-100  text-nowrap table-bordered" id="example1" 
                                   style="text-align: center;">
                                    <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-md-center font-weight-bolder opacity-7 ps-2 btn-info" colspan="{{count($karats) * 2}}">{{__('main.new_gold')}}</th>
                                        <th class="text-center text-uppercase text-md-center font-weight-bolder opacity-7 ps-2 btn-primary" colspan="{{count($karats) * 2}}">{{__('main.old_gold')}}</th>
                                    </tr>

                                    <tr>
                                        @foreach($karats as $karat)
                                            <th class="text-center btn-info" colspan="2">{{Config::get('app.locale') == 'ar' ?$karat -> name_ar : $karat -> name_en}}</th>
                                        @endforeach
                                            @foreach($karats as $karat)
                                                <th class="text-center btn-primary" colspan="2"> {{Config::get('app.locale') == 'ar' ?$karat -> name_ar : $karat -> name_en}}</th>
                                            @endforeach

                                    </tr>
                                    <tr>
                                        @foreach($karats as $karat)
                                            <th  class="text-center success">{{__('main.enter')}}</th>
                                            <th  class="text-center danger">{{__('main.exit')}}</th>
                                        @endforeach
                                            @foreach($karats as $karat)
                                                <th  class="text-center success">{{__('main.enter')}}</th>
                                                <th  class="text-center danger">{{__('main.exit')}}</th>
                                            @endforeach
                                    </tr>


                                    </thead>
                                    <tbody>
                                    @foreach($karats as $karat)
                                        @if( isset($work[$karat -> id]) )
                                            @if( isset($workR[$karat -> id]) )
                                                <td class="text-center" style="color: green">{{$work[$karat -> id]['enter_weight']  -  $workR[$karat -> id]['RWeight']  }}</td>
                                                <td class="text-center" style="color: red">{{$work[$karat-> id]['out_weight']   }}</td>
                                            @else
                                                <td class="text-center" style="color: green">{{$work[$karat -> id]['enter_weight']   }}</td>
                                                <td class="text-center" style="color: red">{{$work[$karat-> id]['out_weight'] }}</td>
                                            @endif  
                                        @else
                                            <td class="text-center" style="color: green">0.0</td>
                                            <td class="text-center" style="color: red">0.0</td>
                                        @endif

                                    @endforeach



                                    @foreach($karats as $karat)
                                        @if(isset($old[$karat -> id]))
                                            @if(isset($oldR[$karat -> id]))
                                                <td class="text-center" style="color: green">{{$old[$karat -> id]['enter_weight']  -  $oldR[$karat -> id]['RWeight']}}</td>
                                                <td class="text-center" style="color: red">{{$old[$karat-> id]['out_weight']  +  $oldR[$karat -> id]['RWeight']}}</td>
                                            @else
                                                <td class="text-center" style="color: green">{{$old[$karat -> id]['enter_weight']}}</td>
                                                <td class="text-center" style="color: red">{{$old[$karat-> id]['out_weight'] }}</td>
                                            @endif

                                        @else
                                            <td class="text-center" style="color: green"> 0.0</td>
                                            <td class="text-center" style="color: red">0.0</td>
                                        @endif

                                    @endforeach 
                                    <tr style="background: antiquewhite;">
                                        @foreach($karats as $karat)
                                            @if( isset($work[$karat -> id]) )
                                                <td colspan="2" class="text-center"
                                                @if($work[$karat -> id]['enter_weight'] - $work[$karat -> id]['out_weight'] >= 0) style="color: green; font-weight: bold; font-size: 30px;"
                                            @else style="color: red; font-weight: bold; font-size: 30px;" @endif
                                                >{{$work[$karat -> id]['enter_weight'] - $work[$karat -> id]['out_weight']}}</td>
                                            @else
                                                <td class="text-center" colspan="2" style="color: green">0.0</td>
                                            @endif
                                        @endforeach
                                            @foreach($karats as $karat)
                                                @if( isset($old[$karat -> id]) )
                                                    <td colspan="2" class="text-center"
                                                        @if($old[$karat -> id]['enter_weight'] - $old[$karat -> id]['out_weight'] >= 0) style="color: green; font-weight: bold; font-size: 30px;"
                                                        @else style="color: red; font-weight: bold; font-size: 30px;" @endif
                                                    >{{$old[$karat -> id]['enter_weight'] - $old[$karat -> id]['out_weight']}}</td>
                                                @else
                                                    <td class="text-center" colspan="2" style="color: green">0.0</td>
                                                @endif

                                            @endforeach
                                    </tr> 
                                    </tbody>

                                </table>

                                <h3 class="text-center" style="margin: 15px auto ;">{{__('main.gold_stock_by_21')}}</h3>
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-md-center font-weight-bolder opacity-7 ps-2 btn-info" colspan="2">{{__('main.new_gold')}}</th>
                                        <th class="text-center text-uppercase text-md-center font-weight-bolder opacity-7 ps-2 btn-primary" colspan="2">{{__('main.old_gold')}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center info" colspan="2">{{Config::get('app.locale') == 'ar' ? 'عيار 21' : 'Karat 21'}}</th>
                                        <th class="text-center info" colspan="2">{{Config::get('app.locale') == 'ar' ? 'عيار 21' : 'Karat 21'}}</th>
                                    </tr>
                                    <tr>
                                        <th  class="text-center success">{{__('main.enter')}}</th>
                                        <th  class="text-center danger">{{__('main.exit')}}</th>
                                        <th  class="text-center success">{{__('main.enter')}}</th>
                                        <th  class="text-center danger">{{__('main.exit')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php  $in_work_gold = 0 ;
                                    $out_work_gold = 0 ;
                                    $in_old_gold = 0 ;
                                    $out_old_gold = 0 ;

                                    ?>
                                    @foreach($karats as $karat)
                                        @if( isset($work[$karat -> id]) )
                                            <?php  $in_work_gold += $work[$karat -> id]['enter_weight']  * $karat -> transform_factor ;
                                            $out_work_gold += $work[$karat -> id]['out_weight']  * $karat -> transform_factor ;

                                            ?>
                                        @endif
                                        @if( isset($old[$karat -> id]) )
                                            <?php
                                            $in_old_gold += $old[$karat -> id]['enter_weight']  * $karat -> transform_factor ;
                                            $out_old_gold += $old[$karat -> id]['out_weight']  * $karat -> transform_factor ;
                                            ?>
                                        @endif




                                    @endforeach
                                    <tr>
                                        <td class="text-center"  style="color: green">{{ round($in_work_gold , 2) }}</td>
                                        <td class="text-center" style="color: red">{{round($out_work_gold  , 2)}}</td>
                                        <td class="text-center"  style="color: green">{{round($in_old_gold , 2)}}</td>
                                        <td class="text-center" style="color: red">{{round($out_old_gold  , 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-center"
                                            @if($in_work_gold - $out_work_gold >= 0) style="color: green; font-weight: bold; font-size: 30px;"
                                            @else style="color: red; font-weight: bold; font-size: 30px;" @endif
                                        >{{ round($in_work_gold - $out_work_gold , 2) }}</td>
                                        <td colspan="2" class="text-center"
                                            @if($in_old_gold - $out_old_gold >= 0) style="color: green; font-weight: bold; font-size: 30px;"
                                            @else style="color: red; font-weight: bold; font-size: 30px;" @endif
                                        >{{round($in_old_gold - $out_old_gold , 2)}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                 </div>
             </div>
         </div>
     </div>
 
     <!--/div-->

@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script type="text/javascript">
    let id = 0;


    $(document).ready(function () {
        $(document).on('click', '#btnPrint', function (event) {
            printPage();
        });

    });


    function printPage() {
        var css = '@page { size: landscape; }',
            head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');

        style.type = 'text/css';
        style.media = 'print';

        if (style.styleSheet) {
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }

        head.appendChild(style);
        document.getElementById("main-header").style.display = 'none';
        document.getElementById("main-footer").style.display = 'none';
        document.getElementById("card-header").style.display = 'none';
        document.getElementById("back-to-top").style.display = 'none';
        window.print();
        document.getElementById("main-header").style.display = 'block';
        document.getElementById("main-footer").style.display = 'block';
        document.getElementById("card-header").style.display = 'block';
        document.getElementById("back-to-top").style.display = 'block';
    }


</script>

 