@extends('admin.layouts.master')
@section('content')
@can('اضافة مرتجع فاتورة مبيعات')  
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
                <div class="card-header pb-0" id="head-right" >
                    <div class="col-lg-12 margin-tb">
                        <h4  class="alert alert-primary text-center">
                           {{__('main.return_sales')}}
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div> 
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form method="POST" action="{{ route('return_work_post') }}"
                                  enctype="multipart/form-data" id="pos_sales_form">
                                @csrf
                                <input type="hidden" name="uuid" id="uuid" value=""/>
                                <div class="row">
                                    <div class="card shadow mb-4 col-9"> 
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label style="float: right;">{{ __('main.bill_number') }} <span
                                                                style="color:red; font-size:20px; font-weight:bold;">*</span>
                                                        </label>
                                                        <input type="text" value="{{$bill -> bill_number}}"
                                                               class="form-control" placeholder="bill_number" readonly
                                                        />
                                                        <input type="hidden" value="{{$bill -> id}}" id="bill_id" name="bill_id"
                                                               class="form-control" placeholder="bill_id" readonly
                                                        />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label style="float: right;">{{ __('main.bill_date') }} <span
                                                                style="color:red; font-size:20px; font-weight:bold;">*</span>
                                                        </label>
                                                        <input type="text"
                                                               class="form-control" value="{{$bill -> date}}" readonly
                                                        />
                                                    </div>
                                                </div> 
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label style="float: right;">{{ __('main.clients') }} <span
                                                                style="color:red; font-size:20px; font-weight:bold;">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" name="customer_id"
                                                               id="customer_id" value="{{$bill -> vendor_name}}"
                                                               readonly>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label style="float: right;">{{ __('main.bill_client_name') }}
                                                            <span
                                                                style="color:red; font-size:20px; font-weight:bold;">*</span>
                                                        </label>
                                                        <input type="text" name="bill_client_name" id="bill_client_name"
                                                               class="form-control"
                                                               value="{{$bill -> bill_client_name}}" readonly>

                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card mb-4">
                                                        <div class="card-header pb-0">
                                                            <h4  class="alert alert-info text-center"> 
                                                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> {{__('اصناف الفاتورة')}} 
                                                            </h4>
                                                        </div> 
                                                        <div class="card-body px-0 pt-0 pb-2">
                                                            <div class="table-responsive p-0"> 
                                                                <table id="sTable"
                                                                       class="table items table-striped table-bordered table-condensed table-hover">
                                                                    <thead>
                                                                    <tr>
                                                                        <th hidden>#</th>
                                                                        <th class="col-md-3 text-center">{{__('main.item')}}</th>
                                                                        <th class="text-center">{{__('العيار')}}</th>
                                                                        <th class="text-center">{{__('main.weight')}}</th>
                                                                        <th class="text-center">{{__('main.price_gram')}} </th>
                                                                        <th class="text-center">{{__('المبلغ')}}</th>
                                                                        <th class="text-center">{{__('الضريبة')}}</th>
                                                                        <th class="text-center">{{__('الاجمالي')}}</th>
                                                                        <th class="text-center">
                                                                            <input class="form-control" id="checkAll"
                                                                                   name="checkAll" type="checkbox">
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="tbody">
                                                                    @foreach($details as $detail)
                                                                        <tr>
                                                                            <td class="text-center"
                                                                                hidden> {{$detail ->id}}</td>
                                                                            <td class="text-center">{{Config::get('app.locale') == 'ar' ? $detail ->item_ar : $detail ->item_en}}</td>
                                                                            <td class="text-center">{{Config::get('app.locale') == 'ar' ? $detail ->karat_ar : $detail ->karat_en}}</td>
                                                                            <td class="text-center">{{$detail ->weight}}</td>
                                                                            <td class="text-center">{{$detail -> gram_price}}</td>
                                                                            <td class="text-center">{{$detail -> gram_manufacture}}</td>
                                                                            <td class="text-center">{{$detail ->gram_tax}}</td>
                                                                            <td class="text-center">{{$detail ->net_money}}</td>
                                                                            <td class="text-center"><input
                                                                                    class="form-control checkDetail"
                                                                                    name="checkDetail[]" type="checkbox"
                                                                                    value="{{$detail -> id}}">
                                                                                    <span class="slider round"></span>
                                                                            </td>


                                                                        </tr> 
                                                                    @endforeach 
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="card shadow mb-4 col-3">
                                        <div class="card-header py-3">
                                            <h4 class="alert alert-info text-center">{{__('main.sales_invoice_total')}}</h4>
                                        </div>
                                        <div class="card-body ">
                                            <div class="row document_type1"
                                                 style="align-items: center; margin-bottom: 10px;">
                                                <div class="col-6">
                                                    <label
                                                        style="text-align: right;float: right;"> {{__('main.items_count')}} </label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" readonly class="form-control" id="items_count"
                                                           value="{{count($details) }}">
                                                </div>
                                            </div>
                                            <div class="row" style="align-items: center; margin-bottom: 10px;">
                                                <div class="col-6">
                                                    <label
                                                        style="text-align: right;float: right;"> {{__('main.total_weight21')}} </label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" readonly class="form-control"
                                                           id="total_weight21" name="total_weight21"
                                                           value="{{$bill -> total21_gold}}">
                                                </div>
                                            </div>
                                            <div class="row" style="align-items: center; margin-bottom: 10px;">
                                                <div class="col-6">
                                                    <label
                                                        style="text-align: right;float: right;"> {{__('main.additional_tax')  }} </label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" readonly class="form-control" id="tax" name="tax"
                                                           value="{{$bill -> tax}}">
                                                </div>
                                            </div>
                                            <div class="row" style="align-items: baseline; margin-bottom: 10px;">
                                                <div class="col-6"> 
                                                    <label
                                                        style="text-align: right;float: right;"> {{__('main.discount')}} </label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" readonly class="form-control" id="discount"
                                                           name="discount" placeholder="0"
                                                           value="{{$bill -> discount}}">
                                                </div>

                                            </div>
                                            <div class="row" style="align-items: center; margin-bottom: 10px;">
                                                <div class="col-6">
                                                    <label style="text-align: right;float: right;"
                                                    > {{__('main.net')}} </label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" readonly class="form-control" id="net_sales"
                                                           value="{{$bill -> net_money}}">
                                                </div>
                                            </div>
                                            <hr class="sidebar-divider d-none d-md-block">

                                            <div class="show_modal1">

                                            </div> 

                                            <div class="row">
                                                <div class="col-md-12 text-center" style="display: block; margin: auto;">
                                                    <input type="button" class="btn btn-info" id="return_btn"
                                                           tabindex="-1" value="{{__('main.return_bill')}}">
                                                    </input> 
                                                </div>
                                            </div> 
                                        </div>


                                    </div>

                                </div>


                            </form>
                        </div>


                    </div>
                </div>


            </div>
            <!-- /.container-fluid -->
            <input id="local" value="{{Config::get('app.locale')}}" hidden>
        </div>
        <!-- End of Main Content -->
 
    </div>
    <!-- End of Content Wrapper -->


</div>
<!-- End of Page Wrapper -->
 

@endcan 
@endsection 
@section('js')
<script type="text/javascript">
    $(document).ready(function () {
        document.title = "{{__('main.return_sales')}}";
        $('#checkAll').change(function () {
            $("input:checkbox.checkDetail").prop('checked', this.checked);

        });

        $(document).on('click', '#return_btn', function () {
            var checkList = [];
            console.log('clicked');
            $('#tbody tr').each(function (index) {
                var row = $(this).closest('tr');

                var cell = row[0].cells[8].firstChild.checked;
                if (cell) {
                    checkList.push(row[0].cells[8].firstChild.value);
                }

            });

            if (checkList.length > 0) {
                document.getElementById('pos_sales_form').submit();
            } else {
                alert('select at least one item to return');

            } 
        }); 
    });
</script>
@endsection 
 

