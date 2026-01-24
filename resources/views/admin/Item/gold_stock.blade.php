@extends('admin.layouts.master')
@section('content')
@can('ميزان رصيد الذهب')
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
                
                <div class="card shadow mb-4">
                    <div class="card-body px-0 pt-0 pb-2"> 
                        <div class="card-header py-3 " style="border:solid 1px gray">
                            <header>
                                <div class="row" style="direction: ltr;">
                                    <div class="col-4 text-left">   
                                        <br> 
                                        <button type="button" class="btn btn-primary btnPrint" id="btnPrint"><i class="fa fa-print"></i></button>
                                    </div>
                                    <div class="col-4 c"  id="card-header">
                                        <h4  class="alert alert-primary text-center"> 
                                            {{__('ميزان مراجعة مخزون ورصيد الذهب ')}} 
                                        </h4> 
                                        @if(isset($branch))
                                        <h5 class="text-center"> [ {{$branch->branch_name}} ] </h5>
                                        @elseif(empty(Auth::user()->branch_id))
                                        <h5 class="text-center"> [ جميع الفروع ] </h5>
                                        @else
                                        <h5 class="text-center">[<strong> {{Auth::user()->branch->branch_name}} </strong> ]</h5>
                                        @endif
                                        
                                        <h5 class="text-center"> [ {{Config::get('app.locale') == 'ar' ? $period_ar : $period}} ]</h5>
                                    </div>
                                    <div class="col-4 c">
                                        <span style="text-align: right;">
                                            {{$company ? $company -> name_ar : ''}}
                                         <br>  س.ت : {{$company ? $company -> registrationNumber : ''}}
                                         <br>  ر.ض :  {{$company ? $company -> taxNumber : ''}}
                                         <br>  تليفون :   {{$company ? $company -> phone : ''}}
                                        </span>
                                    </div>
                                </div>
                            </header> 
                        </div>
                    </div> 
 
                        <div class="card-body"> 
                            <div class="table-responsive">
                                <h5 class="text-center"><b>[ {{__('main.gold_stock_by_karat')}} ]</b></h5>
                                <table class="display w-100  text-nowrap table-bordered" id="dataTable" 
                                   style="text-align: center;">
                                    <thead>
                                    <tr>
                                        <th class="text-center text-white text-uppercase text-md-center font-weight-bolder opacity-7 ps-2 bg-info" colspan="{{count($karats) * 2}}">{{__('main.new_gold')}}</th>
                                        <th class="text-center text-white text-uppercase text-md-center font-weight-bolder opacity-7 ps-2 bg-primary" colspan="{{count($karats) * 2}}">{{__('main.old_gold')}}</th>
                                        <th class="text-center text-white text-uppercase text-md-center font-weight-bolder opacity-7 ps-2 bg-info" colspan="{{count($karats) * 2}}">{{__('ذهب صافي')}}</th>
                                    </tr>
                                    <tr>
                                        @foreach($karats as $karat)
                                            <th class="text-center" colspan="2">
                                                {{Config::get('app.locale') == 'ar' ?$karat -> name_ar : $karat -> name_en}}
                                            </th>
                                        @endforeach
                                        @foreach($karats as $karat)
                                            <th class="text-center" colspan="2">
                                                {{Config::get('app.locale') == 'ar' ?$karat -> name_ar : $karat -> name_en}}
                                            </th>
                                        @endforeach 
                                            <th class="text-center" colspan="2">
                                               عيار 24
                                            </th>
                                    </tr>
                                    <tr>
                                        @foreach($karats as $karat)
                                            <th  class="text-center  success">{{__('main.enter')}}</th>
                                            <th  class="text-center  danger">{{__('main.exit')}}</th>
                                        @endforeach
                                        @foreach($karats as $karat)
                                            <th  class="text-center success">{{__('main.enter')}}</th>
                                            <th  class="text-center danger">{{__('main.exit')}}</th>
                                        @endforeach
                                            <th  class="text-center success">{{__('main.enter')}}</th>
                                            <th  class="text-center danger">{{__('main.exit')}}</th>
                                    </tr> 
                                    </thead>
                                    <tbody>
                                    @foreach($karats as $karat)
                                        @if( isset($work[$karat -> id]) )
                                            @if( isset($workR[$karat -> id]) )
                                                <td class="text-center" style="color: green">{{number_format($work[$karat -> id]['enter_weight'],2) }}</td>
                                                <td class="text-center" style="color: red">{{number_format($work[$karat-> id]['out_weight'],2) }}</td>
                                            @else
                                                <td class="text-center" style="color: green">{{number_format($work[$karat -> id]['enter_weight'],2) }}</td>
                                                <td class="text-center" style="color: red">{{number_format($work[$karat-> id]['out_weight'],2) }}</td>
                                            @endif  
                                        @else
                                            <td class="text-center" style="color: green">0.0</td>
                                            <td class="text-center" style="color: red">0.0</td>
                                        @endif 
                                    @endforeach 

                                    @foreach($karats as $karat)
                                        @if(isset($old[$karat -> id]))
                                            @if(isset($oldR[$karat -> id]))
                                                <td class="text-center" style="color: green">{{number_format($old[$karat -> id]['enter_weight']  -  $oldR[$karat -> id]['RWeight'],2) }}</td>
                                                <td class="text-center" style="color: red">{{number_format($old[$karat-> id]['out_weight']  +  $oldR[$karat -> id]['RWeight'],2) }}</td>
                                            @else
                                                <td class="text-center" style="color: green">{{number_format($old[$karat -> id]['enter_weight'],2) }}</td>
                                                <td class="text-center" style="color: red">{{number_format($old[$karat-> id]['out_weight'],2) }}</td>
                                            @endif 
                                        @else
                                            <td class="text-center" style="color: green"> 0.0</td>
                                            <td class="text-center" style="color: red">0.0</td>
                                        @endif

                                    @endforeach 

                                    @foreach($karats as $karat)
                                        @if(isset($pure[$karat -> id]))
                                            @if(isset($pureR[$karat -> id]))
                                                <td class="text-center" style="color: green">{{number_format($pure[$karat -> id]['enter_weight']  -  $pureR[$karat -> id]['RWeight'],2) }}</td>
                                                <td class="text-center" style="color: red">{{number_format($pure[$karat-> id]['out_weight']  +  $pureR[$karat -> id]['RWeight'],2) }}</td>
                                            @else
                                                <td class="text-center" style="color: green">{{number_format($pure[$karat -> id]['enter_weight'],2) }}</td>
                                                <td class="text-center" style="color: red">{{number_format($pure[$karat-> id]['out_weight'],2) }}</td>
                                            @endif  
                                        @endif

                                    @endforeach  

                                    <tr style="background: antiquewhite;">
                                        @foreach($karats as $karat)
                                            @if( isset($work[$karat -> id]) )
                                                <td colspan="2" class="text-center"
                                                @if($work[$karat -> id]['enter_weight'] - $work[$karat -> id]['out_weight'] >= 0) style="color: green; font-weight: bold; font-size: 20px;"
                                            @else style="color: red; font-weight: bold; font-size: 20px;" @endif
                                                >{{number_format($work[$karat -> id]['enter_weight'] - $work[$karat -> id]['out_weight'],2) }}</td>
                                            @else
                                                <td class="text-center" colspan="2" style="color: green">0.0</td>
                                            @endif
                                        @endforeach
                                            @foreach($karats as $karat)
                                                @if( isset($old[$karat -> id]) )
                                                    <td colspan="2" class="text-center"
                                                        @if($old[$karat -> id]['enter_weight'] - $old[$karat -> id]['out_weight'] >= 0) style="color: green; font-weight: bold; font-size: 20px;"
                                                        @else style="color: red; font-weight: bold; font-size: 20px;" @endif
                                                    >{{number_format($old[$karat -> id]['enter_weight'] - $old[$karat -> id]['out_weight'],2) }}</td>
                                                @else
                                                    <td class="text-center" colspan="2" style="color: green">0.0</td>
                                                @endif

                                            @endforeach
                                                @foreach($karats as $karat)
                                                    @if(isset($pure[$karat -> id]) )
                                                        <td colspan="2" class="text-center"
                                                            @if($pure[$karat -> id]['enter_weight'] - $pure[$karat -> id]['out_weight'] >= 0) style="color: green; font-weight: bold; font-size: 20px;"
                                                            @else style="color: red; font-weight: bold; font-size: 20px;" @endif
                                                        >{{number_format($pure[$karat -> id]['enter_weight'] - $pure[$karat -> id]['out_weight'],2) }}</td>
                                                    @endif
    
                                                @endforeach
                                    </tr> 
                                    </tbody>

                                </table>
                                <hr>
                                <h5 class="text-center"><b>[ {{__('main.gold_stock_by_21')}} ]</b></h5>
                                <table class="display w-100  text-nowrap table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    
                                    <thead>
                                    <tr>
                                        <th class="text-center text-white text-uppercase text-md-center font-weight-bolder opacity-7 ps-2 bg-info" colspan="2">{{__('main.new_gold')}}</th>
                                        <th class="text-center text-white text-uppercase text-md-center font-weight-bolder opacity-7 ps-2 bg-primary" colspan="2">{{__('main.old_gold')}}</th>
                                        <th class="text-center text-white text-uppercase text-md-center font-weight-bolder opacity-7 ps-2 bg-info" colspan="2">{{__('ذهب صافي')}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center info" colspan="2">{{Config::get('app.locale') == 'ar' ? 'عيار 21' : 'Karat 21'}}</th>
                                        <th class="text-center info" colspan="2">{{Config::get('app.locale') == 'ar' ? 'عيار 21' : 'Karat 21'}}</th>
                                        <th class="text-center info" colspan="2">{{Config::get('app.locale') == 'ar' ? 'عيار 21' : 'Karat 21'}}</th>
                                    </tr>
                                    <tr>
                                        <th  class="text-center success">{{__('main.enter')}}</th>
                                        <th  class="text-center danger">{{__('main.exit')}}</th>
                                        <th  class="text-center success">{{__('main.enter')}}</th>
                                        <th  class="text-center danger">{{__('main.exit')}}</th>
                                        <th  class="text-center success">{{__('main.enter')}}</th>
                                        <th  class="text-center danger">{{__('main.exit')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php  
                                    $in_work_gold = 0 ;
                                    $out_work_gold = 0 ;
                                    $in_old_gold = 0 ;
                                    $out_old_gold = 0 ;
                                    $in_pure_gold = 0 ;
                                    $out_pure_gold = 0 ;

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
                                        @if( isset($pure[$karat -> id]) )
                                            @php
                                            $in_pure_gold += $pure[$karat -> id]['enter_weight']  * $karat -> transform_factor ;
                                            $out_pure_gold += $pure[$karat -> id]['out_weight']  * $karat -> transform_factor ;
                                            @endphp
                                        @endif 
                                    @endforeach
                                    <tr>
                                        <td class="text-center"  style="color: green">{{ round($in_work_gold , 2) }}</td>
                                        <td class="text-center" style="color: red">{{round($out_work_gold  , 2)}}</td>
                                        <td class="text-center"  style="color: green">{{round($in_old_gold , 2)}}</td>
                                        <td class="text-center" style="color: red">{{round($out_old_gold  , 2)}}</td>
                                        <td class="text-center"  style="color: green">{{round($in_pure_gold , 2)}}</td>
                                        <td class="text-center" style="color: red">{{round($out_pure_gold  , 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-center"
                                            @if($in_work_gold - $out_work_gold >= 0) style="color: green; font-weight: bold; font-size: 20px;"
                                            @else style="color: red; font-weight: bold; font-size: 20px;" @endif
                                        >{{ round($in_work_gold - $out_work_gold , 2) }}</td>
                                        <td colspan="2" class="text-center"
                                            @if($in_old_gold - $out_old_gold >= 0) style="color: green; font-weight: bold; font-size: 20px;"
                                            @else style="color: red; font-weight: bold; font-size: 20px;" @endif
                                        >{{round($in_old_gold - $out_old_gold , 2)}}</td>
                                        <td colspan="2" class="text-center"
                                            @if($in_pure_gold - $out_pure_gold >= 0) style="color: green; font-weight: bold; font-size: 20px;"
                                            @else style="color: red; font-weight: bold; font-size: 20px;" @endif
                                        >{{round($in_pure_gold - $out_pure_gold , 2)}}</td>
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

@endcan 
@endsection 
@section('js') 
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
        document.getElementById("back-to-top").style.display = 'none';
        window.print();
        document.getElementById("main-header").style.display = 'block';
        document.getElementById("main-footer").style.display = 'block'; 
        document.getElementById("back-to-top").style.display = 'block';
    } 
</script>
@endsection 

 