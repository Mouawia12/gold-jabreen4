@extends('admin.layouts.master')
@section('content')
    @if (session('success'))
        <div class="alert alert-success  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
        <!-- row opened -->
        <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-lg-12 margin-tb">
                        <h4  class="alert alert-primary text-center">
                        {{__('main.enter_work_preview')}}
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div> 
                <div class="card-body px-0 pt-0 pb-2">

                    <div class="row">
                        <div class="card shadow mb-4 col-9">
                            <div class="card-header py-3">
                               <a href="{{route('workEnterPrint' , $bill -> id)}}" class="btn btn-primary" role="button" data-bs-toggle="button">
                                   Print
                                </a>  
                            </div>
                            <div class="card-body">


                                <div class="row">

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ __('main.date') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                            <input type="datetime-local"  id="date" name="date"
                                                   class="form-control" value="{{$bill -> date}}" readonly
                                            />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ __('main.bill_no') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                            <input type="text"  id="bill_number" name="bill_number"
                                                   class="form-control" placeholder="bill_no" value="{{$bill -> bill_number}}" readonly
                                            />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ __('main.supplier') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                            <select class="form-control" id="supplier_id" name="supplier_id" disabled>

                                                @foreach($vendors as $vendor)
                                                    <option value="{{$vendor -> id}}" @if($vendor -> id == $bill -> supplier_id) selected @endif >{{$vendor -> name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ __('main.supplier_bill_number') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                            <input type="text"  id="supplier_bill_number" name="supplier_bill_number"
                                                   class="form-control" placeholder="{{__('main.supplier_bill_number')}}"  value="{{$bill -> supplier_bill_number}}" readonly
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.notes') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                            <textarea name="notes" id="notes" rows="3" placeholder="{{ __('main.notes') }}" class="form-control-lg" style="width: 100%" disabled>{{$bill ->notes }}</textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="control-group table-group">
                                            <label class="table-label">{{__('main.items')}} </label>

                                            <div class="controls table-controls">
                                                <table id="sTable" class="table items table-striped table-bordered table-condensed table-hover">
                                                    <thead>
                                                    <tr>

                                                        <th>{{__('main.karat')}}</th>
                                                        <th class="col-md-2 text-center">{{__('main.weight')}}</th>
                                                        <th class="col-md-2 text-center">{{__('main.total_weight21')}} </th>
                                                        <th class="col-md-2 text-center">{{__('main.total_money')}}</th>
                                                        <th class="col-md-2 text-center">{{__('main.net_money')}}</th>
                                                        <th class="col-md-2 text-center">{{__('main.net_weight')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="tbody">
                                                    @foreach($details as $detail)
                                                        <tr>
                                                            <td class="text-center"> {{Config::get('app.locale') == 'ar' ? $detail -> karat_ar : $detail ->  karat_en}} </td>
                                                            <td class="text-center"> {{$detail -> weight}} </td>
                                                            <td class="text-center"> {{$detail -> weight21}} </td>
                                                            <td class="text-center"> {{$detail -> made_money}} </td>
                                                            <td class="text-center"> {{$detail -> net_money}} </td>
                                                            <td class="text-center"> {{$detail -> net_weight}} </td>

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                    <tfoot></tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card shadow mb-4 col-3">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary no-print">{{__('main.totals')}}</h6>
                            </div>
                            <div class="card-body">
                                <div class="row" style="align-items: center; margin-bottom: 10px;">
                                    <div class="col-6">
                                        <label
                                            style="text-align: right;float: right;"> {{__('main.total_actual_weight')}} </label>
                                    </div>
                                    <div class="col-6">
                                        <?php $sum_weight = 0 ?>
                                            @foreach($details as $item)
                                                <?php $sum_weight +=  $item -> weight ?>
                                            @endforeach

                                        <input type="text" readonly class="form-control"
                                               id="total_actual_weight" value="{{$sum_weight}}">
                                    </div>
                                </div>
                                <div class="row" style="align-items: center; margin-bottom: 10px;">
                                    <div class="col-6">
                                        <label
                                            style="text-align: right;float: right;"> {{__('main.total_weight21')}} </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" readonly class="form-control"
                                               id="total_weight21" value="{{$bill -> total21_gold}}">
                                    </div>
                                </div>

                                <div class="row" style="align-items: center; margin-bottom: 10px;">
                                    <div class="col-6">
                                        <label
                                            style="text-align: right;float: right;"> {{__('main.made_Value_t')}} </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" readonly class="form-control" id="made_Value_t" value="{{$bill -> total_money}}">
                                    </div>
                                </div>

                                <div class="row" style="align-items: center; margin-bottom: 10px;">
                                    <div class="col-6">
                                        <label
                                            style="text-align: right;float: right;"> {{__('main.total_tax')}} </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" readonly class="form-control" id="tax" value="{{$bill -> tax}}">
                                    </div>
                                </div>

                                <hr class="sidebar-divider d-none d-md-block">
                                <div class="row" style="align-items: baseline; margin-bottom: 10px;">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label
                                                style="text-align: right;float: right;"> {{__('main.discount')}} </label>
                                            <input type="number" step="any"  class="form-control" id="discount" name="discount" placeholder="0" readonly
                                            value="{{$bill -> discount}}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label
                                                style="text-align: right;float: right;"> {{__('main.net_after_discount')}} </label>
                                            <input type="text" readonly  class="form-control" id="net_after_discount" name="net_after_discount" placeholder="0"
                                                   value="{{$bill -> net_money}}">
                                        </div>
                                    </div>
                                </div>


                                <hr class="sidebar-divider d-none d-md-block">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper --> 
  
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>

<script>
    $(document).ready(function () {


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
 