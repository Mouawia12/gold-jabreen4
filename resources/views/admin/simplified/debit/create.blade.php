@extends('admin.layouts.master')
@section('content')
    @if (session('success'))
        <div class="alert alert-success  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
  
 
 
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0"  id="head-right" >
                        <div class="col-lg-12 margin-tb">
                            <h4  class="alert alert-primary text-center">
                            [ {{ __('اضافة اشعار مدين لفاتورة مبسطة') }} ]
                            </h4>
                        </div>
                        <div class="clearfix"></div>
                    </div> 
                    <div class="card-body pt-0 pb-2">
                        <form id="formSales" method="POST" action="{{ route('store.simplified.dept',$id) }}"
                                enctype="multipart/form-data" >
                            @csrf
                            <input type="hidden" name="mount" id="mount" value="0"> 
                            <input type="hidden" name="uuid" id="uuid" value=""/>
                            <input type="hidden" name="reference_id" id="reference_id" value="{{$sale->id}}"/>
                            <div class="row"> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('رقم الاشعار') }} <span class="text-danger">*</span> </label>
                                        <input type="text"  id="invoice_no" name="invoice_no"
                                               class="form-control" placeholder="bill_number" readonly
                                        />
                                    </div>
                                </div>
                                
                                <div class="col-md-3" >
                                    <div class="form-group">
                                    <label>{{ __('رقم فاتورة البيع') }} <span class="text-danger">*</span> </label>
                                        <input type="text"  id="bill_number" name="bill_number"
                                               class="form-control" value="{{$sale->bill_number}}" readonly
                                        />
                                    </div>
                                </div>
                                <div class="col-md-3" >
                                    <div class="form-group">
                                        <label>{{ __('الفرع') }} <span class="text-danger">*</span> </label>
                                        <select class="js-example-basic-single w-100" readonly="readonly"
                                                name="branch_id" id="branch_id"> 
                                            @foreach ($branches as $branche)
                                                @if($branche->id == $sale->branch_id)
                                                <option value="{{$branche -> id}}">{{ $branche -> branch_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3" >
                                    <div class="form-group">
                                        <label>{{ __('main.clients') }} <span class="text-danger">*</span> </label>
                                        <select class="js-example-basic-single w-100"  readonly="readonly"
                                                name="customer_id" id="customer_id"> 
                                            @foreach ($customers as $customer)
                                                @if($customer->id == $sale->client_id) 
                                                    <option value="{{$customer -> id}}"> {{ $customer -> name}}</option>
                                                @endif 
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="control-group table-group"> 
                                        <div class="card-header pb-0">
                                            <h4  class="alert alert-info text-center">{{__('main.items')}} </h4>
                                        </div> 
                                        <div class="table-responsive hoverable-table">
                                            <table class="display w-100 table-bordered" id="sTable" 
                                                   style="text-align: center;">  
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-3">{{__('main.item_name_code')}}</th>
                                                        <th class="col-md-1">{{__('العيار')}}</th>
                                                        <th class="col-md-1">{{__('سعر الجرام')}}</th>
                                                        <th class="col-md-1">{{__('الوزن')}} </th>
                                                        <th class="col-md-1">{{__('فارق القيمة')}} </th>
                                                        <th class="col-md-2">{{__('المبلغ')}}</th>
                                                        <th class="col-md-2">{{__('main.tax')}}</th>
                                                        <th class="col-md-2">{{__('الاجمالي')}}</th> 
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody"></tbody>  
                                                <tfoot></tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"><hr></div> 
                            <div class="row">
                                <div class="col-md-12 text-center">
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

 
@endsection 
@section('js')
<script type="text/javascript">

    var suggestionItems = {};
    var sItems = {};
    var count = 1;

    $(document).ready(function() {
        var string = "{{$saleItems}}";

        var allsItems = JSON.parse(string.replace(/&quot;/g,'"'));
        $.each(allsItems,function (i,item) {
            sItems[item.item_id] = item;
        });

        loadItems(); 

        $(document).on('click', '#primary', function () {
            var rows = 0; 
            var mount = $('#mount').val();

            rows = ($('#sTable tbody tr').length);
            console.log(rows);    

            if(rows > 0 && mount>0){  
                document.getElementById('formSales').submit(); 
            } else {
                alert($('<div>{{trans('يجب تحديد كميات واصناف الفاتورة')}}</div>').text());
            } 
        });

        getBillNo();  
 
        function getBillNo(){
          let invoice_no = document.getElementById('invoice_no');
          $.ajax({
                type:'get', 
                url:'{{route('get.simplified.debit.no',[2,$sale->branch_id])}}',
                dataType: 'json',
                success:function(response){
                    console.log(response); 
                    if(response){
                        invoice_no.value = response ; 
                    } else {
                        invoice_no.value = '' ;
                    }
                }
            });
        }

    });

  var old_row_weight=0;
  var old_row_price = 0;
  var old_row_w_price = 0;

  $(document)
    .on('focus','.imount',function () {
        old_row_mount = $(this).val();
    })
    .on('change','.imount',function () {
        var row = $(this).closest('tr');
        if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
            $(this).val(old_row_mount);
            alert('wrong value');
            return;
        }
      
        var newmount = parseFloat($(this).val()),
            item_id = row.attr('data-item-id');
            old_row_mount = $(this).val();
         
        var weight = sItems[item_id].weight; 
        var gram_price = sItems[item_id].gram_price; 
        var gram_tax = sItems[item_id].gram_tax; 
        gram_tax = parseFloat(gram_tax / (gram_price * weight)).toFixed(2);
        var total = 0;
        var tax = 0;
        var net = 0;
        
        if(newmount > 0){
            total = (Number(newmount) * Number(weight)).toFixed(2);
            tax = (Number(total) * Number(gram_tax)).toFixed(2);
            net = (Number(total) + Number(tax)).toFixed(2);   
        }
        
        sItems[item_id].mount= old_row_mount; 
        sItems[item_id].total= total; 
        sItems[item_id].tax= tax; 
        sItems[item_id].net= net;  
        $('#mount').val(newmount);
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

                if (!item.mount) {
                    item.mount = 0;
                }
  
                console.log(item);
  
                var newTr = $('<tr data-item-id="' + item.item_id + '">');
                var tr_html = '<td><input type="hidden" name="item_id[]" value="' + item.item_id + '"> <span>' + item.product_name + '</span> </td>';
                tr_html += '<td hidden><input type="hidden" class="form-control" readonly name="simplified_detail_id[]" value="' + item.id + '"></td>';
                tr_html += '<td hidden><input type="hidden" class="form-control" readonly name="karat_id[]" value="' + item.karat_id+ '"></td>';
                tr_html += '<td><input type="text" class="form-control" readonly name="karat_name[]" value="' + item.karat_name+ '"></td>';
                tr_html += '<td><input type="text" class="form-control iprice"" readonly name="gram_price[]" value="' + parseFloat(item.gram_price).toFixed(2) + '"></td>';
                tr_html += '<td hidden><input type="hidden" class="form-control igram_tax" readonly name="gram_tax[]" value="' + parseFloat(item.gram_tax / (item.gram_price * item.weight)).toFixed(2)+ '"></td>';
                tr_html += '<td><input type="text" readonly="readonly" class="form-control iweight" name="weight[]" value="' + parseFloat(item.weight) + '"></td>';
                tr_html += '<td><input type="number" class="form-control imount" name="mount[]" value="' +  parseFloat(item.mount).toFixed(2) + '"></td>';
                tr_html += '<td><input type="text" readonly="readonly" class="form-control itotal" name="total[]" value="' +  parseFloat(item.total).toFixed(2) + '"></td>';
                tr_html += '<td><input type="text" readonly="readonly" class="form-control itax" name="tax[]" value="' + parseFloat(item.tax).toFixed(2) + '"></td>'; 
                tr_html += '<td><input type="text" readonly="readonly" class="form-control inet" name="net[]" value="' + parseFloat(item.net).toFixed(2) + '"></td>';
          
                
                newTr.html(tr_html);
                newTr.appendTo('#sTable');
          } 
      });

  }
</script>
<script type="module">
  import { v4 as uuidv4 } from 'https://jspm.dev/uuid';
  console.log(uuidv4()); // ⇨ '1b9d6bcd-bbfd-4b2d-9b5d-ab8dfbbd4bed'
  $("#uuid").val(uuidv4());
</script>
@endsection 