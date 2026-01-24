@extends('admin.layouts.master')
@section('content')
    @if (session('success'))
        <div class="alert alert-success  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
  
    @can('اضافة مردود مشتريات')   
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0"  id="head-right" >
                        <div class="col-lg-12 margin-tb">
                            <h4  class="alert alert-primary text-center">
                                [ {{ __('main.return_purchase') }} ]
                            </h4>
                        </div>
                        <div class="clearfix"></div>
                    </div> 
                    <div class="card-body">
                        <form id="formPurchase"  method="POST" action="{{ route('return.purchase.store',$id) }}"
                                enctype="multipart/form-data" autocomplete="off"> 
                            @csrf
                            <input type="hidden" name="branch_id" id="branch_id" value="{{$purchase->branch_id}}">
                            <input type="hidden" name="weight" id="weight" value="0">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('main.bill_number') }} <span  class="text-danger">*</span> </label>
                                        <input type="text"  id="bill_number" name="bill_number"
                                               class="form-control" placeholder="bill_number" readonly/> 
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('main.bill_date') }} <span  class="text-danger">*</span> </label>
                                        <input type="datetime-local"  id="bill_date" name="bill_date"
                                               class="form-control"/> 
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('فاتورة المشتريات') }}  <span  class="text-danger">*</span> </label>
                                        <input value="{{$purchase->bill_number}}" id="invoice_purchase_no" name="invoice_purchase_no"
                                               type="text" class="form-control" placeholder="bill_number" readonly/> 
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('تاريخها') }}  <span  class="text-danger">*</span> </label>
                                        <input value="{{$purchase->date}}" id="invoice_purchase_date" name="invoice_purchase_date"
                                               type="text" class="form-control" placeholder="invoice_date" readonly/> 
                                    </div>
                                </div> 
                                <div class="col-md-4" >
                                    <div class="form-group">
                                        <label>{{ __('main.supplier') }} <span  class="text-danger">*</span> </label> 
                                        <input type="text" value="{{$purchase->supplier_name}}"  name="supplier_name" id="supplier_name" class="form-control" readonlay>
                                        <input type="hidden" value="{{$purchase->supplier_id}}"  name="supplier_id" id="supplier_id">
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="control-group table-group"> 
                                        <div class="card-header pb-0">
                                            <h4 class="alert alert-info text-center">
                                                <i class="fa fa-cart-shopping"></i>
                                                {{__('main.items_invoice')}} 
                                            </h4>
                                        </div> 
                                        <div class="table-responsive hoverable-table">
                                            <table class="display w-100 text-nowrap table-bordered" id="sTable" 
                                                    style="text-align: center;">  
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-3 text-center">{{__('main.item_karat')}}</th>
                                                        <th class="col-md-1">{{__('main.price.unit')}}</th> 
                                                        <th class="col-md-1" hidden>{{__('main.price_with_tax')}}</th>
                                                        <th class="col-md-1">{{__('main.weight')}} </th>
                                                        <th class="col-md-1">{{__('main.returned_weight')}} </th>
                                                        <th class="col-md-2">{{__('main.amount')}}</th>
                                                        <th class="col-md-2">{{__('main.tax')}}</th>
                                                        <th class="col-md-2">{{__('main.total')}}</th> 
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody"></tbody> 
                                                <tfoot></tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="row"> 
                                <div class="col-md-12 text-center">
                                    <hr>
                                    <button type="button" class="btn btn-primary btn-lg" id="primary" tabindex="-1"> 
                                       <i class="fa fa-save"></i> {{__('main.save_btn')}} 
                                    </button>  
                                </div>
                            </div> 
                        </form> 
                    </div>
                </div>
            </div>
        </div> 
    </div>  
@endcan 
@endsection 
@section('js')
<script type="text/javascript">

    var suggestionItems = {};
    var sItems = {};
    var count = 1;

    $(document).ready(function() {

        document.title = "{{ __('main.return_purchase') }}";

        var string = "{{$purchaseItems}}"; 
        var allsItems = JSON.parse(string.replace(/&quot;/g,'"'));
        $.each(allsItems,function (i,item) {
            sItems[item.karat_id] = item;
        });

        loadItems(); 
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
 
        now.setMilliseconds(null);
        now.setSeconds(null); 
        document.getElementById('bill_date').value = now.toISOString().slice(0, -1);

        getBillNo();

        $(document).on('click', '#primary', function () {
            var rows = 0; 
            var weight = $('#weight').val();

            rows = ($('#sTable tbody tr').length);
            console.log(rows);    

            if(rows > 0 && weight>0){  
                document.getElementById('formPurchase').submit(); 
            } else {
                alert($('<div>{{trans('يجب تحديد كميات واصناف الفاتورة')}}</div>').text());
            } 
        });

    });

    function getBillNo(){ 
        let bill_number = document.getElementById('bill_number');
        $.ajax({
            type:'get',
            url:'{{route('get.return.purchase.number',[2,$purchase->branch_id])}}',
            dataType: 'json',
            success:function(response){
                console.log(response);
                if(response){
                    bill_number.value = response ;
                } else {
                    bill_number.value = '' ;
                }
            }
        });
    }
  
    var old_row_qty=0;
    var old_row_price = 0;
    var old_row_w_price = 0;

    $(document)
        .on('focus','.iWeight',function () {
            old_row_qty = $(this).val();
        })
        .on('change','.iWeight',function () {
            var row = $(this).closest('tr');
            if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
                $(this).val(old_row_qty);
                alert('wrong value');
                return;
            }

            var NewWeight = parseFloat($(this).val()),
                item_id = row.attr('data-item-id');

            if(NewWeight > sItems[item_id].weight){
                $(this).val(old_row_qty);
                alert('wrong value');
                return;
            }

            $('#weight').val(NewWeight);
            sItems[item_id].returned_weight= NewWeight; 
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

    function loadItems(){  
        $('#sTable tbody').empty();
        $.each(sItems,function (i,item) { 
            if(item.weight > 0) { 
                if (!item.returned_weight) {
                    item.returned_weight = 0;
                } 
                var newTr = $('<tr data-item-id="' + item.karat_id + '">');
                var tr_html = '<td><input type="hidden" name="karat_id[]" value="' + item.karat_id + '"> <span>' + item.karat_name  + '</span> </td>';
                    tr_html +='<td><input type="text" class="form-control" readonly name="price_without_tax[]" value="' + parseFloat(item.net_money / item.weightItem).toFixed(2) + '"></td>'; 
                    tr_html +='<td hidden><input type="hidden" name="price_with_tax[]" value="' + ((Number(item.net_money) + Number(item.tax)) / item.weightItem).toFixed(2) + '"></td>';
                    tr_html +='<td><input readonly type="text" class="form-control" name="all_weight[]" value="' + parseFloat(item.weight) + '"></td>'; 
                    tr_html +='<td hidden><input type="hidden" name="weightItem[]" value="' + item.weightItem + '"></td>';
                    tr_html +='<td><input type="number" class="form-control iWeight" name="weight[]" value="' + item.returned_weight + '"></td>';
                    tr_html +='<td hidden><input type="hidden" class="form-control weight21" name="weight21[]" value="' + (Number(item.weight21/ item.weightItem) * Number(item.returned_weight)).toFixed(2) + '"></td>';
                    tr_html +='<td><input type="text" readonly="readonly" class="form-control" name="total_all[]" value="' + (Number(item.net_money / item.weightItem) * Number(item.returned_weight)).toFixed(2) + '"></td>';
                    tr_html +='<td hidden><input type="hidden"  name="total[]" value="' + (Number(item.made_money / item.weightItem) * Number(item.returned_weight)).toFixed(2) + '"></td>';
                    tr_html +='<td hidden><input type="hidden"  name="made_value[]" value="' + (Number(item.made_value / item.weightItem) * Number(item.returned_weight)).toFixed(2) + '"></td>';
                    tr_html +='<td><input type="text" readonly="readonly" class="form-control" name="tax[]" value="' + (Number(item.tax / item.weightItem) * Number(item.returned_weight)).toFixed(2) + '"></td>';
                    tr_html +='<td><input type="text" readonly="readonly" class="form-control" name="net[]" value="' + (((Number(item.net_money) + Number(item.tax)) / item.weightItem) * Number(item.returned_weight)).toFixed(2) + '"></td>';
                
                newTr.html(tr_html);
                newTr.appendTo('#sTable');
            }
        }); 
        $('#add_item').focus();
    }
</script>
@endsection 
