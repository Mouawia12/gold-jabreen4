@extends('admin.layouts.master')
@section('content')
@can('اضافة فاتورة ضريبية')  
    @if (session('success'))
        <div class="alert alert-success  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
<!-- row opened -->
<style>
 
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
  color: #ffffff;
  background-color: #E5B80B;
  border-color: #E5B80B;
}
 
    select option {
        font-size: 15px !important;
    }
    .select2-container{
        width:100% !important;
    }
    span.select2-selection.select2-selection--single{
        padding:2px;
    }
 
    input.form-control {
        padding: 0;
        width: 100%;
        text-align:center;
    } 
</style> 


    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card"> 
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form method="POST" action="{{ route('store_pos_tax') }}"
                                  enctype="multipart/form-data" id="pos_sales_form">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                                <input type="hidden" class="form-control" name="bill_client_name" >
                                <input type="hidden" class="form-control" name="notes" > 
                                <input type="hidden" name="uuid" id="uuid" value=""/>
                                <input type="hidden" id="catch_id" name="catch_id" value="{{$catch_gold_recipt->id}}" >
                                <input type="hidden" name="document_type" id="document_type" value="1" >
                                <input type="hidden" name="bill_type" id="bill_type" value="1" >

                                <div class="row">
                                    <div class="card shadow mb-4 col-9">
                                        <div class="card-header py-3">
                                            <div class="row">
                                               <div class="col-12"> 
                                                    <h4  class="alert alert-primary text-center">
                                                    فاتورة مبيعات ضريبية (ذهب تحت التصنيع)
                                                    </h4> 
                                                </div> 
                                            </div>  
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label style="float: right;">{{ __('main.bill_number') }}</label>
                                                        <input type="text" id="bill_number" name="bill_number"
                                                               class="form-control" placeholder="bill_number" readonly />
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label style="float: right;">{{ __('main.bill_date') }}  
                                                        </label>
                                                        <input type="datetime-local" id="bill_date" name="bill_date"
                                                               class="form-control" readonly/> 
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="d-block">
                                                             الفرع
                                                        </label>
                                                        @if(empty(Auth::user()->branch_id) || Auth::user()->hasRole('Admin'))
                                                            <select required  class="js-example-basic-single w-100" name="branch_id" id="branch_id">
                                                                <option value=""></option>
                                                                @foreach($branches as $branch)
                                                                    <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <input class="form-control" type="text" readonly
                                                                   value="{{Auth::user()->branch->branch_name}}"/>
                                                            <input required class="form-control" type="hidden" id="branch_id"
                                                                   name="branch_id"
                                                                   value="{{Auth::user()->branch_id}}"/>
                                                        @endif
                    
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="row"> 
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label  >{{ __('main.clients') }}  
                                                        </label>
                                                        <select class="js-example-basic-single"
                                                                name="customer_id" id="customer_id"> 
                                                            @foreach ($customers as $customer) 
                                                                <option value="{{$customer -> id}}"> {{ $customer -> name .' - '. $customer -> vat_no  }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> 
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>{{ __('سند القبض') }}</label>  
                                                        <input value="{{$catch_gold_recipt->docNumber}}" id="catch_docNumber" name="catch_docNumber"
                                                             type="text"  class="form-control" placeholder="catch_docNumber" readonly>

                                                    </div>
                                                </div> 
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>{{ __('تاريخ سند القبض') }}</label>  
                                                        <input value="{{$catch_gold_recipt->date}}" id="catch_date" name="catch_date"
                                                             type="text"  class="form-control" placeholder="catch_date" readonly>
                                                    </div>
                                                </div> 
                                            </div>  
                                            <div class="document_type1">
                                                <div class="row"> 
                                                    <div class="col-md-12" id="sticker">
                                                        <div class="well well-sm"
                                                             @if(Config::get('app.locale') == 'ar')style="direction: rtl;" @endif>
                                                             <div class="form-group" style="border: 1px solid #eee;padding: 1%;border-radius: 10px; background: #fbfbfb;width: 100%;">
                                                                <div class="input-group wide-tip">
                                                                    <div class="input-group-addon"
                                                                         style="padding-left: 10px; padding-right: 10px;">
                                                                        <i class="fa fa-2x fa-barcode addIcon"></i>
                                                                    </div>
                                                                    <input
                                                                        style="border-radius: 0 !important;padding-left: 10px;padding-right: 10px;"
                                                                        type="text" name="add_item" value=""
                                                                        class="form-control text-right input-lg ui-autocomplete-input"
                                                                        id="add_item"
                                                                        placeholder="{{__('main.add_item_hint')}}"
                                                                        autocomplete="off"> 
                                                                </div> 
                                                              </div>
                                                            <ul class="suggestions"
                                                                id="products_suggestions"
                                                                style="display: block">
                                                            </ul>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card mb-4">
                                                           <div class="card-header pb-0">
                                                                <h4   class="alert alert-info text-center">
                                                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> 
                                                                    {{__('اصناف الفاتورة')}} 
                                                                </h4>
                                                            </div>
                                                            <div class="card-body px-0 pt-0 pb-2"> 
                                                                <div class="table-responsive hoverable-table">
                                                                    <table class="display w-100 table-bordered" id="sTable" 
                                                                           style="text-align: center;">
                                                                        <thead>
                                                                        <tr> 
                                                                            <th class="col-md-3">{{__('main.item')}}</th>
                                                                            <th class="col-md-1">{{__('العيار')}}</th>
                                                                            <th >{{__('الوزن')}}</th>                                                                            <th class="text-center">{{__('main.price_gram')}} </th>
                                                                            <th class="text-center">{{__('المبلغ')}}</th>
                                                                            <th class="text-center">{{__('الضريبة')}}</th>
                                                                            <th class="col-md-2">{{__('الاجمالي')}}</th>
                                                                            <th hidden>weigh21</th>
                                                                            <th hidden>factor</th>
                                                                            <th></th> 
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody id="tbody"></tbody>
                                                                        <tfoot></tfoot>
                                                                    </table>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="document_type2">
                                                <div class="row"> 
                                                    <div class="col-md-12" id="sticker">
                                                     <div class="well well-sm">
                                                        <div class="form-group" style="border: 1px solid #eee;padding: 1%;border-radius: 10px; background: #fbfbfb;width: 100%;">
                                                            <div class="input-group text-center">
                                                               <div class="input-group input-group-addon" > 
                                                                    <i class="fa fa-barcode" style="font-size:40px;"></i> 
                                                                    <select class="form-control" id="karat_select0" name="karat_select0"> 
                                                                    @foreach($karats as $karat)
                                                                        <option value="{{$karat -> id}}">{{ Config::get('app.locale') == 'en' ?$karat -> name_en : $karat -> name_ar}}</option>
                                                                    @endforeach
                                                                    </select> 
                                                                </div> 
                                                            </div> 
                                                            <div class="col-lg-12 text-center">
                                                               <br> 
                                                                <button type="button"  
                                                                    class="btn btn-labeled btn-info"
                                                                     id="createButton0">
                                                                     <i class="fa fa-plus"></i>
                                                                     {{__('main.items.add.invoice')}} 
                                                                </button>
                                                            </div>
                                                         </div>
                                                         <div class="clearfix"></div>
                                                     </div>
                                                 </div> 
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="control-group table-group">
                                                            <h4 class="alert alert-info text-center">
                                                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> 
                                                                {{__('main.items.invoice')}} 
                                                            </h4>
                                                            <div class="table-responsive hoverable-table">
                                                                <table class="display w-100  text-nowrap table-bordered" id="sTable0" 
                                                                       style="text-align: center;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th hidden>id</th>
                                                                            <th class="col-md-1" >{{__('main.item_karat')}}</th>
                                                                            <th class="col-md-2" >{{__('main.item_weight')}}</th>
                                                                            <th class="text-center" >{{__('main.item_gold21')}} </th>
                                                                            <th class="text-center" >{{__('main.price_gram')}}</th>
                                                                            <th class="text-center" > {{__('main.item_amount')}}</th>
                                                                            <th class="text-center" > {{__('main.item_tax')}}</th>
                                                                            <th class="col-md-2" > {{__('main.item_total')}}</th>
                                                                            <th class="text-center" hidden>{{__('main.net_weight')}}</th>
                                                                            <th >
                                                                                <i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                                                            </th>
                                                                            <th hidden>factor</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="tbody0"></tbody>
                                                                    <tfoot></tfoot>
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
                                            <h5 class="alert alert-info text-center">{{__('main.sales_invoice_total')}}</h6>
                                        </div>
                                        <div class="card-body ">
                                            <div class="row document_type1" style="align-items: center; margin-bottom: 10px;">
                                                <div class="col-6">
                                                    <label
                                                        style="text-align: right;float: right;"> {{__('main.items_count')}} </label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" readonly class="form-control" id="items_count">
                                                </div>
                                            </div>
                                            <div class="row" style="align-items: center; margin-bottom: 10px;">
                                                <div class="col-6">
                                                    <label
                                                        style="text-align: right;float: right;"> {{__('main.total_actual_weight')}} </label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" readonly class="form-control"
                                                           id="total_actual_weight">
                                                </div>
                                            </div>
                                            <div class="row" style="align-items: center; margin-bottom: 10px;">
                                                <div class="col-6">
                                                    <label
                                                        style="text-align: right;float: right;"> {{__('main.total_weight21')}} </label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" readonly class="form-control"
                                                           id="total_weight21" name="total_weight21">
                                                </div>
                                            </div>

                                            <div class="row" style="align-items: center; margin-bottom: 10px;">
                                                <div class="col-6">
                                                    <label
                                                        style="text-align: right;float: right;"> {{__('main.total_without_tax')}} </label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" readonly class="form-control" id="first_total">
                                                </div>
                                            </div>
                                            <div class="row" style="align-items: center; margin-bottom: 10px;" hidden>
                                                <div class="col-6">
                                                    <label
                                                        style="text-align: right;float: right;"> {{__('main.made_Value_t')}} </label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" readonly class="form-control" id="made_Value_t">
                                                </div>
                                            </div>
                                            <div class="row" style="align-items: center; margin-bottom: 10px;" hidden>
                                                <div class="col-6">
                                                    <label
                                                        style="text-align: right;float: right;"> {{__('main.taxgold')  }} </label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" readonly class="form-control" id="tax_total">
                                                </div>
                                            </div>
                                            <div class="row" style="align-items: center; margin-bottom: 10px;">
                                                <div class="col-6">
                                                    <label
                                                        style="text-align: right;float: right;"> {{__('main.additional_tax')  }} </label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" readonly class="form-control" id="tax" name="tax">
                                                </div>
                                            </div>

                                            <div class="row" hidden>
                                                <div class="col-6">
                                                    <label style="text-align: right;float: right;"
                                                          > {{__('main.total_with_tax')}} </label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" readonly class="form-control"  id="net_sales">
                                                </div>
                                            </div>
                                            <hr class="sidebar-divider d-none d-md-block">
                                            <div class="row" style="align-items: baseline; margin-bottom: 10px;">
                                                <div class="col-6" hidden>
                                                    <div class="form-group">
                                                        <label
                                                            style="text-align: right;float: right;"> {{__('main.discount')}} </label>
                                                        <input type="number" step="any" readonly class="form-control" id="discount" name="discount" placeholder="0">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ __('وزن 21 ج (المستلم)') }} </label>  
                                                        <input value="{{$catch_gold_recipt->gold21}}" type="text" step="any" readonly class="form-control" id="catch_gold21" name="catch_gold21">
                                                    </div>
                                                </div>  
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ __('النقدية (المسددة)') }} </label>  
                                                        <input value="{{$catch_gold_recipt->amount}}" type="text" step="any" readonly class="form-control" id="catch_amount" name="catch_amount">
                                                    </div>
                                                </div>  
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label
                                                            style="text-align: right;float: right;"> {{__('اجمالي قيمة الفاتورة')}} </label>
                                                        <input type="text" readonly  class="form-control" id="net_after_discount" name="net_after_discount" placeholder="0">
                                                    </div>
                                                </div>
                                                @can('اضافة فاتورة ضريبية')
                                                <div class="col-md-12 text-center" style="display: block; margin: auto;">
                                                    <button type="button" 
                                                        class="btn btn-md btn-info w-100" 
                                                        id="pos_sales_btn" 
                                                        name="pos_sales_btn" 
                                                        value="{{__('main.pay')}}">
                                                        حفظ ودفع
                                                    </button>  
                                                </div>
                                                @endcan 
                                            </div>

                                            <div class="row" hidden style="align-items: center; margin-bottom: 10px;">
                                                <div class="form-group">
                                                    <label
                                                        style="text-align: right;float: right;"> {{__('main.paid')}} </label>
                                                    <input type="number" step="any"  class="form-control" id="paid" name="paid" placeholder="0">
                                                </div>
                                            </div> 
                                            <div class="show_modal1">

                                            </div> 
                                        </div>  
                                        <div class="row">

                                        </div>
                                    </div> 
                                </div> 
                            </form>
                        </div>  
                        <!--purchase TAB--> 
                    </div>
                </div>


                <div class="modal fade" id="ItemMaterialModalDialog" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <label class="modelTitle"> {{__('main.warning')}}</label>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                                        style="color: red; font-size: 20px; font-weight: bold;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="smallBody">
                                <img src="{{asset('assets/img/warning.png')}}" class="alertImage">
                                <label class="alertTitle">{{__('main.ItemMaterialModalDialog')}}</label>
                                <br> <label class="alertSubTitle" id="modal_table_bill"></label>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <button type="button" class="btn btn-labeled btn-primary" onclick="dealWithItemMaterial()">
                            <span class="btn-label" style="margin-right: 10px;"><i
                                    class="fa fa-check"></i></span>{{__('main.confirm_btn')}}</button>
                                    </div>
                                    <div class="col-6 text-center">
                                        <button type="button" class="btn btn-labeled btn-secondary cancel-modal">
                            <span class="btn-label" style="margin-right: 10px;"><i
                                    class="fa fa-close"></i></span>{{__('main.cancel_btn')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- /.container-fluid -->
            <input id="local" value="{{Config::get('app.locale')}}" hidden>
            <input id="taxPer" value="{{($setting && $setting->enabled == 1) ? $setting->value : 0}}" hidden>
        </div>
        <!-- End of Main Content --> 
    </div>
    <!-- End of Content Wrapper --> 
</div>
 
<audio id="mysoundclip1" preload="auto">
    <source src="{{URL::asset('assets/sound/beep/beep-timber.mp3')}}"></source>
</audio>
<audio id="mysoundclip2" preload="auto">
    <source src="{{URL::asset('assets/sound/beep/beep-07.mp3')}}"></source>
</audio>
<!-- End of Page Wrapper -->

@endcan 
@endsection 
@section('js')  

<script type="text/javascript">

    document.title = "فاتورة مبيعات ضريبية (ذهب تحت التصنيع)";
    var suggestionItems = {};
    var sItems = {};
    var count = 1; 
    var catch_gold21 =  $('#catch_gold21').val(); 
    var catch_amount =  $('#catch_amount').val(); 
    

    $(document).ready(function () { 

        if($('#customer_id').prop('selectedIndex') == 1){
            $('#bill_client_name').slideDown();
        } else {
            $('#bill_client_name').slideUp();
        }

        $('#customer_id').change(function (){
            if(this.selectedIndex == 1){
                $('#bill_client_name').slideDown();
            } else {
                $('#bill_client_name').slideUp();
            }
        });

        $(document).on('click' , '.close-create' , function (event) {
            $('#createModal').modal("hide");
        });

        $(document).on('click', '#payment_btn', function () {

            console.log($('#home-tab').classList);
            console.log($('#profile-tab').classList);
            const money = document.getElementById('money').value;
            const cash = document.getElementById('cash').value;
            const visa = document.getElementById('visa').value;
            const type = document.getElementById('type').value;
 
            if(Number(money) == (Number(cash) + Number(visa)).toFixed(2) ){ 
                if(type == '1'){
                    document.getElementById('pos_sales_form').submit();
                } 
            } else {
                alert($('<div>{{trans('main.paid_must_equal_net')}}</div>').text());
            }
        });

        $(document).on('change', '#branch_id', function () {
            getBillNo();
            $('#products_suggestions').empty();
            $('#sTable tbody').empty();
            suggestionItems = {};
            sItems = {};
            count = 1; 
        });

        $(document).on('change', '#cash', function () {

            const money = document.getElementById('money').value;   
            var visa = Number(money) - Number(this.value);
            document.getElementById('visa').value = visa.toFixed(2);

        });

        $(document).on('keyup', '#cash', function () {

            const money = document.getElementById('money').value;   
            var visa = Number(money) - Number(this.value);
            document.getElementById('visa').value = visa.toFixed(2);
        });

        document.getElementById('document_type').value = 1 ;
        $('.document_type1').slideDown();
        $('.document_type2').slideUp();

        $(document).on('change', '#document_type', function () {
            getBillNo();
           if(this.value == 1){
               $('.document_type1').slideDown();
               $('.document_type2').slideUp();
               $('#sTable0 tbody').empty();
               document.getElementById('items_count').value = 0  ;
               document.getElementById('total_actual_weight').value = 0;
               document.getElementById('total_weight21').value = 0;
               document.getElementById('first_total').value = 0;
               document.getElementById('made_Value_t').value = 0;
               document.getElementById('tax_total').value = 0;
               document.getElementById('net_sales').value = 0;
               document.getElementById('discount').value = 0;
               document.getElementById('net_after_discount').value = 0;
               document.getElementById('tax').value = 0;
           }  else {
               $('.document_type2').slideDown();
               $('.document_type1').slideUp();
               $('#sTable tbody').empty();
               document.getElementById('items_count').value = 0  ;
               document.getElementById('total_actual_weight').value = 0;
               document.getElementById('total_weight21').value = 0;
               document.getElementById('first_total').value = 0;
               document.getElementById('made_Value_t').value = 0;
               document.getElementById('tax_total').value = 0;
               document.getElementById('net_sales').value = 0;
               document.getElementById('discount').value = 0;
               document.getElementById('net_after_discount').value = 0;
               document.getElementById('tax').value = 0;
 
           }
        });

        document.getElementById('items_count').value = 0  ;
        document.getElementById('total_actual_weight').value = 0;
        document.getElementById('total_weight21').value = 0;
        document.getElementById('first_total').value = 0;
        document.getElementById('made_Value_t').value = 0;
        document.getElementById('tax_total').value = 0;
        document.getElementById('net_sales').value = 0;
        document.getElementById('discount').value = 0; 
        document.getElementById('net_after_discount').value = 0;
        document.getElementById('tax').value = 0;
        document.getElementById('paid').value = 0;

        $(document).on('change', '#discount', function () {
            var net = document.getElementById('net_sales').value; 
            var tax = 0 ;
            var net_after_discount = Number(net) - Number(this.value) + Number(tax);
            document.getElementById('net_after_discount').value = net_after_discount.toFixed(2);
        });

        $(document).on('keyup', '#discount', function () {
            var net = document.getElementById('net_sales').value; 
            var tax = 0 ;
            var net_after_discount = Number(net) - Number(this.value) + Number(tax);
            document.getElementById('net_after_discount').value = net_after_discount.toFixed(2) ;
        });
 
        $(document).on('click', '#pos_sales_btn', function () {

            var rows =  0 ;
            var document_type = document.getElementById('document_type').value ;
            var net_after_discount = document.getElementById('net_after_discount').value;
            var client = document.getElementById('customer_id').value ;
            rows = document_type == 1 ? ($('#sTable tbody tr').length) : ($('#tbody0 tr').length);
            console.log(rows);
    
            if(client > 0) {
                if (rows > 0){
                    if (/*Number(paid) - Number(net_after_discount) == 0*/ true) {
                        openPaymentModal(net_after_discount , 1, catch_amount); 
                        localStorage.setItem('openModal', net_after_discount);
                    } else {
                        alert($('<div>{{trans('main.paid_must_equal_net')}}</div>').text());
                    }
            } else {
                    alert($('<div>{{trans('main.no_bill_details')}}</div>').text());
                }
            } else {
                alert($('<div>{{trans('main.select_client')}}</div>').text());
            } 
        });
  
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        now.setMilliseconds(null);
        now.setSeconds(null);
        document.getElementById('bill_date').value = now.toISOString().slice(0, -1);

        getBillNo();
        $('#warehouse_id').change(function () {
            getBillNo();
        });

        $('#add_item').focus();
        $('#add_item').on('input', function (e) { 
            searchProduct($('#add_item').val());
        });

        $(document).on('click', '.cancel-modal', function (event) {
            $('#deleteModal').modal("hide");
            $('#ItemMaterialModalDialog').modal("hide");
            id = 0;
        });

        $(document).on('click', '.deleteBtn', function (event) {
            var row = $(this).parent().parent().index(); 
            var row1 = $(this).closest('tr');
            var item_id = row1.attr('data-item-id');
            delete sItems[item_id];
            loadItems();
            var audio = $("#mysoundclip2")[0];
            audio.play();
        });

        $(document).on('click', '.select_product', function () {
            var row = $(this).closest('li');
            var item_id = row.attr('data-item-id');
            if(suggestionItems[item_id].isChild == 0){
                addItemToTable(suggestionItems[item_id]);
                var audio = $("#mysoundclip1")[0];
                audio.play();
            } else {
                $('#add_item').val(suggestionItems[item_id].code);
                showItemMaterialModalDialog();
            }  
        });

        $('#createButton0').click(function () {
            const karat_select = document.getElementById('karat_select0').value;
            $.ajax({
                type: 'get',
                url: 'getKarat/' + karat_select,
                dataType: 'json',

                success: function (response) { 
                    AddRowToTable(response , 'tbody0');
                }
            });
        }); 
    });

    function showItemMaterialModalDialog(){
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href,
            beforeSend: function () {
                $('#loader').show();
            },
            // return the result
            success: function (result) {
                $('#ItemMaterialModalDialog').modal("show");
            },
            complete: function () {
                $('#loader').hide();
            },
            error: function (jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            },
            timeout: 8000
        });
    }

    function dealWithItemMaterial(){
        var code = $('#add_item').val();
        $.ajax({
            type: 'get',
            url: 'deletePosItemMaterial' + '/' + code,
            dataType: 'json',

            success: function (response) {
                console.log(response);
                if (response == 'deleted') {
                    searchProduct(code);
                    $('#ItemMaterialModalDialog').modal("hide");
                } 
            }
        });
    }

    function AddRowToTable(karat , id ) {

        const local = document.getElementById('local').value;
        const table = document.getElementById(id);
        var repeate = document.getElementById( id + '-tr' + karat.id);
        
        if(!repeate) {

            var row = table.insertRow(-1);
            row.id = id + '-tr' + karat.id;
            row.className = "text-center";

            var cell0 = row.insertCell(0);
            var cell1 = row.insertCell(1);
            var cell2 = row.insertCell(2);
            var cell3 = row.insertCell(3);
            var cell4 = row.insertCell(4);
            var cell5 = row.insertCell(5);
            var cell6 = row.insertCell(6);
            var cell7 = row.insertCell(7);
            var cell8 = row.insertCell(8);

            if(id == 'tbody0'){
                var cell9 = row.insertCell(9);
                var cell10 = row.insertCell(10);
                var cell11 = row.insertCell(11);
                cell0.hidden = true ;
                cell8.hidden = true ;
                cell10.hidden = true ;
                cell11.hidden = true ;
            } else {
                cell0.hidden = true ;
                cell8.hidden = true ;
            }

            cell1.className = 'text-center';
            cell2.className = 'text-center';
            cell3.className = 'text-center';
            cell4.className = 'text-center';
            cell5.className = 'text-center';
            cell6.className = 'text-center';
            cell7.className = 'text-center';
            cell8.className = 'text-center';

            if(id == 'tbody0'){
                cell9.className = 'text-center';
                cell10.className = 'text-center';
                cell11.className = 'text-center';
            }

            if(id == 'tbody0'){

                cell0.innerHTML = '<input name="karat_id_old[]" value="'+karat.id+'" hidden>';
                cell1.innerHTML = local == 'ar' ?  karat.name_ar : karat.name_en;
                cell2.innerHTML = `<td><input class="form-control iQuantity" type="text" step="any" name="weight_old[]"  /> </td>`;
                cell3.innerHTML = `<td><input class="form-control" type="number" step="any" name="weight21_old[]"  readonly/> </td>`;
                cell4.innerHTML = '<td><input class="form-control iPriceOldd" type="text"  name="gram_price_old[]"  value="'+ karat.price.toFixed(2) +'" /> </td>';
                cell5.innerHTML = '<td><input class="form-control " type="text" step="any" name="total_money_without_tax[]"  value="0" readonly /> </td>';
                cell6.innerHTML = '<td><input class="form-control iTax" type="text" step="any" name="gram_tax_old[]"  value="0" readonly/> </td>';
                cell7.innerHTML = `<td><input class="form-control  iOldTotalWithtax" type="text"  name="net_money_old[]"   value="0" /> </td>`;
                cell8.innerHTML = `<td hidden><input class="form-control" type="number" step="any" name="net_weight_old[]"  readonly/> </td>`;
                cell9.innerHTML = `<td>
                                        <button type="button" class="btn btn-outline-danger deleteBtn0" value=" '+item.id+' ">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>`;
                cell10.innerHTML = '<input name="factor[]" value="'+karat.transform_factor+'" hidden>';
                cell11.innerHTML = '<input name="stamp[]" value="'+karat.stamp_value+'" hidden>';
               
            } else {
                cell0.innerHTML = '<input name="karat_id_old2[]" value="'+karat.id+'" hidden>';
                cell1.innerHTML = local == 'ar' ?  karat.name_ar : karat.name_en;
                cell2.innerHTML = `<td><input class="form-control iWeight" type="text" step="any" name="weight_old2[]"  /> </td>`;
                cell3.innerHTML = `<td><input class="form-control" type="number" step="any" name="weight21_old2[]"  readonly/> </td>`;
                cell4.innerHTML = '<td><input class="form-control iPriceOld" type="text"  name="gram_price_old[]"  value="0" /> </td>';
                cell5.innerHTML = `<td><input class="form-control" type="number" step="any" name="net_money_old2[]"  readonly value="0" /> </td>`;
                cell6.innerHTML = `<td><input class="form-control" type="number" step="any" name="net_weight_old2[]"  readonly/> </td>`;
                cell7.innerHTML = `<td>
                                        <button type="button" class="btn btn-outline-danger  deleteBtn2 " value=" '+item.id+' ">
                                           <i class="fa fa-trash"></i>
                                        </button>
                                    </td>`;
                cell8.innerHTML = '<input name="factor[]" value="'+karat.transform_factor+'" hidden>'; 

            }

        } else {
            alert('تنبية , هذا الصنف موجود فعلاً في الفاتورة !');
        }

    }

    function is_numeric(mixed_var) {
        var whitespace = ' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
        return (
            (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -1)) &&
            mixed_var !== '' &&
            !isNaN(mixed_var)
        );
    }

    function getBillNo() {

        let bill_number = document.getElementById('bill_number'); 
        let type = document.getElementById('document_type').value;
        let branch_id = document.getElementById('branch_id').value;
        var url = '{{route('get_sales_pos_tax_no',[":id",":type",":branch_id"])}}';
            url = url.replace(":id",1);
            url = url.replace(":type",type);
            url = url.replace(":branch_id",branch_id);

        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) { 
                if (response) {
                    bill_number.value = response;
                } else {
                    bill_number.value = '';
                }
            }
        });
   
    }

    function searchProduct(code) { 

        let branch_id = document.getElementById('branch_id').value; 
        var url = '{{route('getProduct',[":code",":branch_id"])}}'; 
            url = url.replace(":code",code);
            url = url.replace(":branch_id",branch_id);

        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) { 
                document.getElementById('products_suggestions').innerHTML = '';
                if (response) {
                    if (response.length == 1) { 
                        if (response[0].state == 1) {
                            if(response[0].isChild == 0){
                                addItemToTable(response[0]);
                                var audio = $("#mysoundclip2")[0];
                                    audio.play();
                            } else { 
                                showItemMaterialModalDialog(); 
                            } 
                        }

                    } else if (response.length > 1) {

                        showSuggestions(response);
                    } else if (response.id) {
                        showSuggestions(response);
                    } else { 
                        openDialog();
                        document.getElementById('add_item').value = '';
                    }
                } else { 
                    openDialog();
                    document.getElementById('add_item').value = '';
                }
            },
            error: function (err){
                console.log( JSON.parse(JSON.stringify(err.responseText)) );
            }
        });
    }

    function showSuggestions(response) {

        console.log(response);
        $data = '';
        $.each(response, function (i, item) {
            if (item.item_type == 1 || item.item_type == 3) {
                if (item.state == 1) {
                    suggestionItems[item.id] = item; 
                    $data += '<li class="select_product" data-item-id="' + item.id + '">' + item.name_ar + ' -- ' + item.karat.name_ar + ' [ ' + item.code +' ] * وزن  ' + item.weight + '</li>';
                } 
            }
        });
        document.getElementById('products_suggestions').innerHTML = $data;
    }


    function openPaymentModal(id , type, amount){
        console.log('money modal');
        let url = "{{ route('pos.payment.catch.gold', [':id' , ':type' , ':amount']) }}";
        url = url.replace(':id', id);
        url = url.replace(':type', type);
        url = url.replace(':amount', amount);

        $.get( url, function( data ) {
            if(type == 1){
                $( ".show_modal1" ).html( data );
            } else {
                $( ".show_modal2" ).html( data );
            }

            $('#paymentsModal').modal({backdrop: 'static', keyboard: false} ,'show');
        });
    }

    function openDialog() {
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href,
            beforeSend: function () {
                $('#loader').show();
            },
            // return the result
            success: function (result) {
                $('#deleteModal').modal("show");
            },
            complete: function () {
                $('#loader').hide();
            },
            error: function (jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            },
            timeout: 8000
        });
    }

    function addItemToTable(item) {

        suggestionItems = {};
        $('#products_suggestions').empty();
        suggestionItems = {};

        if (count == 1) {
            sItems = {};
        }

        if (sItems[item.id]) {
            alert('This Item Entry has Already been made');
            return;
        } else {
            var price = item.price;
            var taxType = item.tax_method;
            var taxRate = item.tax_rate == 1 ? 0 : 15;
            var itemTax = 0;
            var priceWithoutTax = 0;
            var priceWithTax = 0;
            var itemQnt = item.weight;

            if (taxType == 1) {
                //included
                priceWithTax = price;
                priceWithoutTax = (price / (1 + (taxRate / 100)));
                itemTax = priceWithTax - priceWithoutTax;
            } else {
                //excluded
                itemTax = price * (taxRate / 100);
                priceWithoutTax = price;
                priceWithTax = price + itemTax;
            }

            sItems[item.id] = item;
            console.log(sItems);

        }
        count++;
        loadItems();

        document.getElementById('add_item').value = '';
        $('#add_item').focus();
    }

    var old_row_qty = 0;
    var old_row_price = 0;
    var old_row_w_price = 0;

    $(document).on('change','.iQuantity',function () {

        var row = $(this).closest('tr');

        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }

        const factor = row[0].cells[10].firstChild.value;
        const weight = $(this).val() ;
        const price =  row[0].cells[4].firstChild.value;
        const total = (weight * price).toFixed(2);
        const weight21 = (weight * factor).toFixed(2); 
        const Stamp = row[0].cells[11].firstChild.value; 
        const tax =  (total *  (Stamp / 100 )).toFixed(2); 
        const net = ( Number(total) + Number(tax)).toFixed(2);

        row[0].cells[3].firstChild.value = weight21 ;
        row[0].cells[5].firstChild.value = total ;
        row[0].cells[6].firstChild.value = tax ;
        row[0].cells[7].firstChild.value = net ;
        row[0].cells[8].firstChild.value = weight ;

        calcTotals();
    });

    $(document).on('keyup','.iQuantity',function () {

        var row = $(this).closest('tr');

        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }

        const factor = row[0].cells[10].firstChild.value;
        const weight = $(this).val() ;
        const price =  row[0].cells[4].firstChild.value;
        const total = (weight * price).toFixed(2);
        const weight21 = (weight * factor).toFixed(2); 
        const Stamp = row[0].cells[11].firstChild.value; 
        const tax =  (total *  (Stamp / 100 )).toFixed(2); 
        const net = ( Number(total) + Number(tax)).toFixed(2);

        row[0].cells[3].firstChild.value = weight21 ;
        row[0].cells[5].firstChild.value = total ;
        row[0].cells[6].firstChild.value = tax ;
        row[0].cells[7].firstChild.value = net ;
        row[0].cells[8].firstChild.value = weight;

        calcTotals();

    });

    $(document).on('change','.iOldTotalWithtax',function () {

        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }

        const totalWithTax = $(this).val() ; 
        const weight = row[0].cells[2].firstChild.value ;
        var total = 0 ; 
        const Stamp = row[0].cells[11].firstChild.value;  
        total = (totalWithTax / (1 + (Stamp /100) )).toFixed(2); 
        const tax = (Number(totalWithTax) - Number(total)).toFixed(2);
        const price = (total / weight).toFixed(2) ;

        row[0].cells[5].firstChild.value = total ;
        row[0].cells[6].firstChild.value = tax ;
        row[0].cells[4].firstChild.value = price ;

        calcTotals(); 

    });

    $(document).on('keyup','.iOldTotalWithtax',function () {

        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }

        const totalWithTax = $(this).val() ;
        const weight = row[0].cells[2].firstChild.value ;
        var total = 0 ; 
        const Stamp = row[0].cells[11].firstChild.value;  
        total = (totalWithTax / (1 + (Stamp /100) )).toFixed(2); 
        const tax = (Number(totalWithTax) - Number(total)).toFixed(2);
        const price = (total / weight).toFixed(2) ;

        row[0].cells[5].firstChild.value = total ;
        row[0].cells[6].firstChild.value = tax ;
        row[0].cells[4].firstChild.value = price ;

        calcTotals();

    });

    $(document).on('change','.iNewWeight',function () {

        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }

        const price = row[0].cells[3].firstChild.value;
        console.log(price);
        const weigth =  $(this).val() ;
        const total = price * weigth ; 
        const Stamp = row[0].cells[9].firstChild.value;
        const tax = total * (Stamp / 100) ; 
        row[0].cells[4].firstChild.value = total.toFixed(2);
        row[0].cells[5].firstChild.value = tax.toFixed(2);
        row[0].cells[6].firstChild.value = Number( Number(total) + Number(tax)).toFixed(2);

        calcTotals0();

    });

    $(document).on('keyup','.iNewWeight',function () {

        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }

        const price = row[0].cells[3].firstChild.value;
        console.log(price);
        const weigth =  $(this).val();
        const total = price * weigth ; 
        const Stamp = row[0].cells[9].firstChild.value;
        const tax = total * (Stamp / 100) ; 
        const factor = row[0].cells[8].firstChild.value;
        const weight21 = weigth * factor ;

        row[0].cells[7].firstChild.value = weight21.toFixed(2) ;
        row[0].cells[4].firstChild.value = total.toFixed(2) ;
        row[0].cells[5].firstChild.value = tax.toFixed(2) ;
        row[0].cells[6].firstChild.value = Number( Number(total) + Number(tax)).toFixed(2) ;

        calcTotals0();
    });

    $(document).on('change','.iNewPrice',function () {

        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }

        const price = $(this).val()  ;
        console.log(price);
        const weigth =  row[0].cells[2].firstChild.value; ;
        const total = price * weigth; 
        const Stamp = row[0].cells[9].firstChild.value;
        const tax = total * (Stamp / 100) ; 
        row[0].cells[4].firstChild.value = total.toFixed(2) ;
        row[0].cells[5].firstChild.value = tax.toFixed(2) ;
        row[0].cells[6].firstChild.value = Number( Number(total) + Number(tax)).toFixed(2);

        calcTotals0();

    });

    $(document).on('keyup','.iNewPrice',function () {

        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }

        const price = $(this).val()  ;
        console.log(price);
        const weigth =  row[0].cells[2].firstChild.value; ;
        const total = price * weigth ; 
        const Stamp = row[0].cells[9].firstChild.value;
        const tax = total * (Stamp / 100) ; 
        row[0].cells[4].firstChild.value = total.toFixed(2) ;
        row[0].cells[5].firstChild.value = tax.toFixed(2) ;
        row[0].cells[6].firstChild.value = Number( Number(total) + Number(tax)).toFixed(2) ;

        calcTotals0();

    });

    $(document).on('change','.iNewTotalWithTax',function () {

        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }

        const totalWithTax = $(this).val(); 
        const Stamp = row[0].cells[9].firstChild.value; 
        const total = totalWithTax /  (1 + (Stamp / 100)) ; 
        const tax = totalWithTax -  total;
        const weigth =  row[0].cells[2].firstChild.value; ;
        const price = total /  weigth;

        row[0].cells[3].firstChild.value = price.toFixed(2) ;
        row[0].cells[4].firstChild.value = total.toFixed(2) ;
        row[0].cells[5].firstChild.value = tax.toFixed(2) ;

        calcTotals0();

    });

    $(document).on('keyup','.iNewTotalWithTax',function () {
        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }

        const totalWithTax = $(this).val(); 
        const Stamp = row[0].cells[9].firstChild.value; 
        const total = totalWithTax /  (1 + (Stamp / 100)) ; 
        const tax = totalWithTax -  total;
        const weigth =  row[0].cells[2].firstChild.value; ;
        const price = total /  weigth;

        row[0].cells[3].firstChild.value = price.toFixed(2) ;
        row[0].cells[4].firstChild.value = total.toFixed(2) ;
        row[0].cells[5].firstChild.value = tax.toFixed(2) ;

        calcTotals0();
    });

    $(document).on('change','.iMadeValue',function () {
        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }
        const weight = row[0].cells[2].firstChild.value;
        const tax = row[0].cells[6].firstChild.value;
        const price = row[0].cells[4].firstChild.value;
        const total = Number(weight) * (Number(tax) + Number(price) + Number(this.value))

        row[0].cells[7].firstChild.value = total.toFixed(2) ;

        calcTotals();

    });

    $(document).on('keyup','.iMadeValue',function () {
        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }
        const weight = row[0].cells[2].firstChild.value;
        const tax = row[0].cells[6].firstChild.value;
        const price = row[0].cells[4].firstChild.value;
        const total = Number(weight) * (Number(tax) + Number(price) + Number(this.value))

        row[0].cells[7].firstChild.value = total.toFixed(2) ;

        calcTotals();

    });


    $(document).on('change','.iTax',function () {
        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }
        const weight = row[0].cells[2].firstChild.value;
        const made = row[0].cells[5].firstChild.value;
        const price = row[0].cells[4].firstChild.value;
        const total = Number(weight) * (Number(made) + Number(price) + Number(this.value))

        row[0].cells[7].firstChild.value = total.toFixed(2) ;

        calcTotals();

    });

    $(document).on('keyup','.iTax',function () {
        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }
        const weight = row[0].cells[2].firstChild.value;
        const made = row[0].cells[5].firstChild.value;
        const price = row[0].cells[4].firstChild.value;
        const total = Number(weight) * (Number(made) + Number(price) + Number(this.value))

        row[0].cells[7].firstChild.value = total.toFixed(2) ;

        calcTotals();
    });

    $(document).on('keyup', '.iWeight', function () {
        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }
        const factor = row[0].cells[8].firstChild.value;
        const weight21 = $(this).val() * factor ;
        const price = row[0].cells[4].firstChild.value;
        const total = Number(this.value) * (Number(price) );

        row[0].cells[5].firstChild.value = total.toFixed(2);
        row[0].cells[3].firstChild.value = weight21.toFixed(2);
        row[0].cells[6].firstChild.value = $(this).val();

        calcTotals2();

    });

    $(document).on('changer', '.iWeight', function () {
        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(0);
            alert('wrong value');
            return;
        }
        const factor = row[0].cells[8].firstChild.value;
        const weight21 = $(this).val() * factor ;
        const price = row[0].cells[4].firstChild.value;
        const total = Number(this.value) * (Number(price) );

        row[0].cells[5].firstChild.value = total.toFixed(2) ;
        row[0].cells[3].firstChild.value = weight21.toFixed(2) ;
        row[0].cells[6].firstChild.value = $(this).val();
        calcTotals2();
    });

    $(document).on('change', '.iMoney', function () {
        var row = $(this).closest('tr');
        if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
            $(this).val(0);
            alert('wrong value');
            return;
        }

        row[0].cells[5].firstChild.value = $(this).val();
    });

    $(document).on('keyup', '.iMoney', function () {
        var row = $(this).closest('tr');
        if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
            $(this).val(0);
            alert('wrong value');
            return;
        }

        row[0].cells[5].firstChild.value = $(this).val();

    });

    $(document).on('click', '.deleteBtn2', function (event) {
        var row = $(this).parent().parent().index();
        console.log(row);
        var table = document.getElementById('tbody2');
        table.deleteRow(row);
    });


    $(document).on('click', '.deleteBtn0', function (event) {
        var row = $(this).parent().parent().index();
        console.log(row);
        var table = document.getElementById('tbody0');
        table.deleteRow(row);
        calcTotals();
    }); 

    $(document).on('change', '.iPriceOldd', function () {
        if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
            $(this).val(0);
            alert('wrong value');
            return;
        }

        var row = $(this).closest('tr');
        const weight = row[0].cells[2].firstChild.value;
        const price = $(this).val() ;
        const total = (Number(weight) * Number(price)).toFixed(2); 
        const Stamp = row[0].cells[11].firstChild.value; 
        const tax = (total * (Stamp/100)).toFixed(2); 

        const net = (Number(tax)  + Number(total)).toFixed(2);

        row[0].cells[5].firstChild.value = total;
        row[0].cells[6].firstChild.value = tax;
        row[0].cells[7].firstChild.value = net;

        calcTotals();

    });

    $(document).on('keyup', '.iPriceOldd', function () {

        if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
            $(this).val(0);
            alert('wrong value');
            return;
        }

        var row = $(this).closest('tr');

        const weight = row[0].cells[2].firstChild.value;
        const price = $(this).val() ;
        const total = (Number(weight) * Number(price)).toFixed(2); 
        const Stamp = row[0].cells[11].firstChild.value; 
        const tax = (total * (Stamp/100)).toFixed(2);  
        const net = (Number(tax)  + Number(total)).toFixed(2);

        row[0].cells[5].firstChild.value = total;
        row[0].cells[6].firstChild.value = tax ;
        row[0].cells[7].firstChild.value = net ;

        calcTotals();
    });

    $(document)
        .on('focus', '.iPriceWTax', function () {
            old_row_w_price = $(this).val();
        })
        .on('change', '.iPriceWTax', function () {
            var row = $(this).closest('tr');
            if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
                $(this).val(old_row_w_price);
                alert('wrong value');
                return;
            }

            var newQty = parseFloat($(this).val()),
                item_id = row.attr('data-item-id');

            var item_tax = sItems[item_id].item_tax;
            var priceWithoutTax = newQty;
            if (item_tax > 0) {
                priceWithoutTax = newQty / 1.15;
                item_tax = priceWithoutTax * 0.15;
            }
            sItems[item_id].price_withoute_tax = priceWithoutTax;
            sItems[item_id].price_with_tax = newQty;
            sItems[item_id].item_tax = item_tax;

            loadItems();
        });

    function is_numeric(mixed_var) {
        var whitespace = ' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
        return (
            (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -1)) &&
            mixed_var !== '' &&
            !isNaN(mixed_var)
        );
    }


    function loadItems() {

        var items_count_val = 0 ;
        var is_gold21_val = 0;
        var total_actual_weight_val = 0 ;
        var total_weight21_val = 0 ;
        var first_total_val = 0 ;
        var made_Value_t_val = 0 ;
        var tax_val = 0;
        var tax_total_val =0 ;
        var net_sales_val = 0 ;
        var discount_val = 0 ;
        var net_after_discount_val =0 ;
        var paid_val = 0 ; 
        var taxPer = document.getElementById('taxPer').value ;

        $('#sTable tbody').empty();

        $.each(sItems, function (i, item) { 

            is_gold21_val += (Number(item.weight) * Number(item.karat.transform_factor));

            if(is_gold21_val <= catch_gold21){ 

                var newTr = $('<tr data-item-id="' + item.id + '">');
                var tr_html = '<td class="text-center"><input type="hidden" name="item_id[]" value="' + item.id + '"> <strong>' + item.name_ar + '</strong> <br>' + (item.code) + '</td>';
                tr_html += '<td class="text-center"><input type="hidden"  class="form-control iNewkarat" name="karat_id[]" value="' + item.karat_id + '"> <span>' + item.karat.name_ar + '</span> </td>';
                tr_html += '<td><input type="number" class="form-control iNewWeight" name="weight[]" value="' + item.weight + '" ></td>';
                tr_html += '<td><input type="number" class="form-control iNewPrice" name="gram_price[]" value="' + item.price.toFixed(2) + '" ></td>';
                tr_html += '<td><input type="text" readonly="readonly" class="form-control iNewTotal" name="ItemTotalVal[]" value="' + (item.weight * item.price).toFixed(2) +  '"    ></td>';
                tr_html += '<td><input type="text" readonly="readonly" class="form-control iNewTax" name="item_tax[]" value="' + (item.weight * item.price  * (item.tax / 100) ).toFixed(2)  +  '" ></td>';
                tr_html += '<td><input type="text" class="form-control iNewTotalWithTax" name="net_money[]" value=" ' +  ((item.weight * item.price) +  (item.weight * item.price  * (item.tax  / 100) )).toFixed(2)  +' " ></td>';
                tr_html += '<td hidden><input type="text"   class="form-control" name="newWeight21[]" value=" ' + item.weight *  item.karat.transform_factor   +   '  " ></td>';
                tr_html += '<td hidden><input type="text"   class="form-control" name="newKaratTransferFactor[]" value=" ' + item.karat.transform_factor   +   '  " ></td>';
                tr_html += '<td hidden><input type="text"   class="form-control" name="stamp[]" value=" ' + item.karat.stamp_value   +   '  " ></td>';
                tr_html += `<td><button type="button" class="btn btn-danger deleteBtn" value=" '+item.id+' ">
                                <i class="fa fa-close"></i>
                                </button> 
                            </td>`;
    
                newTr.html(tr_html);
                newTr.appendTo('#sTable'); 
    
                items_count_val += 1 ;
                total_actual_weight_val += Number(item.weight);
                total_weight21_val += Number(item.weight) * Number(item.karat.transform_factor);
                first_total_val += Number(item.weight) * Number(item.price);
                made_Value_t_val += Number(item.weight) * Number(item.made_Value);
                tax_total_val += Number(item.weight) * Number(item.karat.stamp_value);
                //27-08-2023
                tax_val += (Number(item.weight)  * Number(item.price)) * (Number(item.karat.stamp_value) /100);
                //net_sales_val += (Number(item.weight) * (Number(item.made_Value) + Number(item.karat.stamp_value) + Number(item.price)));
                net_sales_val += (Number(item.weight) * Number(item.price)) + ((Number(item.weight) * Number(item.price) ) * (Number(item.karat.stamp_value) /100));
                discount_val = document.getElementById('discount').value;

                if(!discount_val) discount_val = 0 ;
                net_after_discount_val = net_sales_val - discount_val ;
                paid_val = 0 ;

                if(is_gold21_val.toFixed(2) == catch_gold21){  
                    $('#pos_sales_btn').attr({disabled:false});
                }else{
                    $('#pos_sales_btn').attr({disabled:true});
                }
            }

        });

        document.getElementById('items_count').value =items_count_val.toFixed(2) ;
        document.getElementById('total_actual_weight').value = total_actual_weight_val.toFixed(2);
        document.getElementById('total_weight21').value = total_weight21_val.toFixed(2);
        document.getElementById('first_total').value = first_total_val.toFixed(2);
        document.getElementById('made_Value_t').value = made_Value_t_val.toFixed(2);
        document.getElementById('tax_total').value = tax_total_val.toFixed(2);
        document.getElementById('net_sales').value = net_sales_val.toFixed(2);
        document.getElementById('discount').value = discount_val; 
        document.getElementById('paid').value = paid_val.toFixed(2);  
        document.getElementById('tax').value = tax_val.toFixed(2);
        console.log(taxPer); 
        document.getElementById('net_after_discount').value = (Number(net_sales_val) - Number (discount_val) ).toFixed(2);

        $('#products_suggestions').empty(); 
    }
        
 
    function calcTotals(){

        var weight = 0 ;
        var weight21 = 0;
        var made = 0 ;
        var tax = 0 ;
        var first_total_val = 0 ;
        var net = 0 ;
        var discount_val = 0 ;

        $( "#sTable0 tbody tr ").each( function( index ) {

            var row = $(this).closest('tr');

            weight += Number(row[0].cells[2].firstChild.value);
            weight21 += Number(row[0].cells[3].firstChild.value);
            made += Number(row[0].cells[5].firstChild.value);
            tax += Number(row[0].cells[6].firstChild.value);
            first_total_val += Number(row[0].cells[2].firstChild.value) * Number(row[0].cells[4].firstChild.value);
            net += Number(row[0].cells[7].firstChild.value);
            discount_val = document.getElementById('discount').value;

        });

        document.getElementById('total_actual_weight').value = weight.toFixed(2) ;
        document.getElementById('total_weight21').value = weight21.toFixed(2) ;

        document.getElementById('first_total').value = first_total_val.toFixed(2);
        document.getElementById('made_Value_t').value = ( Number(made) * Number(weight)).toFixed(2);
        document.getElementById('tax_total').value = ( Number(tax) ).toFixed(2);
        document.getElementById('net_sales').value = net.toFixed(2);
        document.getElementById('discount').value = discount_val;

        document.getElementById('paid').value = 0;
        document.getElementById('tax').value = tax ;
        document.getElementById('net_after_discount').value = (Number(net) - Number(discount_val) ).toFixed(2);
    }

    function calcTotals0(){

        var weight = 0 ;
        var weight21 = 0;
        var made = 0 ;
        var tax = 0 ;
        var first_total_val = 0 ;
        var net = 0 ;
        var discount_val = 0 ;

        $( "#sTable tbody tr ").each( function( index ) {

            var row = $(this).closest('tr');
            weight += Number(row[0].cells[2].firstChild.value);
            weight21 += Number(row[0].cells[7].firstChild.value);
            first_total_val += Number(row[0].cells[2].firstChild.value) * Number(row[0].cells[3].firstChild.value);
            tax += Number(row[0].cells[5].firstChild.value);
            net += Number(row[0].cells[6].firstChild.value);
            discount_val = document.getElementById('discount').value;

        });

        document.getElementById('total_actual_weight').value = weight.toFixed(2) ;
        document.getElementById('total_weight21').value = weight21.toFixed(2) ;
        document.getElementById('first_total').value = first_total_val.toFixed(2);
        document.getElementById('tax').value = tax.toFixed(2);
        document.getElementById('net_sales').value = net.toFixed(2);
        document.getElementById('discount').value = discount_val;
        document.getElementById('paid').value = 0;
        document.getElementById('net_after_discount').value = (Number(net) - Number(discount_val)).toFixed(2);
    }
 
</script>
<script type="module">
  import { v4 as uuidv4 } from 'https://jspm.dev/uuid';
  console.log(uuidv4()); // ⇨ '1b9d6bcd-bbfd-4b2d-9b5d-ab8dfbbd4bed'
  $("#uuid").val(uuidv4());
</script>
@endsection 



