@extends('admin.layouts.master')
@section('content')
    @if (session('success'))
        <div class="alert alert-success  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
<style>  
.modal-content{
    border: unset !important;
} 
.modal-header {
    border-bottom: 0 !important;
}
</style>  
 
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"  id="head-right" > 
                        <h4 class="alert alert-primary text-center">
                            [ {{ __(' اشعار مدين لفاتورة ضريبية') }} ]
                        </h4>  
                    </div> 
                    <div class="card-body"> 
                        <form method="POST" action="#" id="return_sale">
                            @csrf   
                            <div class="row"> 
                                <div class="col-md-12" id="sticker">
                                    <div class="well well-sm" @if(Config::get('app.locale') == 'ar')style="direction: rtl;" @endif>
                                        <div class="form-group">
                                            <div class="input-group wide-tip">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-3x fa-barcode addIcon"></i>
                                                </div>
                                                <input type="text" name="add_item" id="add_item" value="" class="form-control input-lg ui-autocomplete-input" placeholder="{{__('الرجاء كتابة رقم الفاتورة')}}" autocomplete="off">
                                            </div> 
                                        </div>
                                        <ul class="suggestions" id="products_suggestions" style="display: block">
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>  
                            </div> 
                            <div class="row"> 
                                <div class="col-md-12"> 
                                    <div class="card mb-4">
                                        <div class="card-header pb-0">
                                            <h4 class="alert alert-info text-center"> 
                                                {{__('تفاصيل الفاتورة')}} 
                                            </h4>
                                        </div>  
                                        <div class="card-body px-0 pt-0 pb-2">
                                            <div class="table-responsive hoverable-table">
                                                <table class="display w-100 text-nowrap table-bordered" id="sTable" 
                                                       style="text-align: center;">  
                                                    <thead> 
                                                        <tr> 
                                                            <th>{{__('رقم الفاتورة')}}</th>
                                                            <th>{{__('تاريخها')}}</th>  
                                                            <th>{{__('اجمالي الفاتورة')}}</th> 
                                                            <th>{{__('الضريبة')}}</th>
                                                            <th>{{__('المبلغ')}}</th> 
                                                            <th>{{__('ادوات')}}</th>
                                                        </tr> 
                                                    </thead>
                                                    <tbody id="tbody"></tbody> 
                                                </table>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="show_modal"> 
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
        //document.getElementById('bill_date').valueAsDate = new Date();
        $('input[name=add_item]').change(function() {
            console.log($('#add_item').val());
        });

        $('#add_item').on('input',function(e){
            searchProduct($('#add_item').val());
        });
   
        $(document).on('click', '.select_product', function () {
            var row = $(this).closest('li');
            var item_id = row.attr('data-item-id');
            addItemToTable(suggestionItems[item_id]);
            document.getElementById('products_suggestions').innerHTML = '';
            suggestionItems = {};
        });
 

    });


    function searchProduct(code){ 
        var url = '{{route('get.standard.sales',[":id"])}}'; 
        url = url.replace(":id",code); 

        $.ajax({
            type:'get',
            url:url,
            dataType: 'json', 
            success:function(response){ 
                document.getElementById('products_suggestions').innerHTML = '';
                if(response){
                    if(response.length == 1){
                        //addItemToTable 
                        addItemToTable(response[0]);
                    }else if(response.length > 1){ 
                        showSuggestions(response); 
                    } else if(response.id){
                        showSuggestions(response);
                    } else {
                        //showNotFoundAlert
                        openDialog();
                        document.getElementById('add_item').value = '' ;
                    }
                } else {
                    //showNotFoundAlert
                    openDialog();
                    document.getElementById('add_item').value = '' ;
                }
            }
        });
    }

    function showSuggestions(response) { 
        $data = '';
        $.each(response,function (i,item) {
            suggestionItems[item.id] = item;
            $data +='<li class="select_product" data-item-id="'+item.id+'">'+item.bill_number+'</li>';
        });
        document.getElementById('products_suggestions').innerHTML = $data;
    }

    function openDialog(){
      let href = $(this).attr('data-attr');
      $.ajax({
          url: href,
          beforeSend: function() {
              $('#loader').show();
          },
          // return the result
          success: function(result) {
              $('#deleteModal').modal("show");
          },
          complete: function() {
              $('#loader').hide();
          },
          error: function(jqXHR, testStatus, error) {
              console.log(error);
              alert("Page " + href + " cannot open. Error:" + error);
              $('#loader').hide();
          },
          timeout: 8000
      })
    }

    function addItemToTable(item){
        if(count == 1){
            sItems = {};
        }

        if(sItems[item.id]){ 
            alert('هذه الفاتورة موجودة')
        }else{ 
            sItems[item.id] = item;  
        }
        count++;
        loadItems(); 
        document.getElementById('add_item').value = '' ;
    }

  
     
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
            console.log(item);
            var url = '{{route('add.standard.dept',":id")}}';
            url = url.replace(":id",item.id);
            var newTr = $('<tr data-item-id="'+item.id+'">');
            var tr_html ='<td><input type="hidden" name="sale_id[]" value="'+item.id+'"> <span>'+item.bill_number +'</span> </td>';
                tr_html +='<td><input type="text" readonly="readonly" class="form-control" name="bill_date[]" value="'+item.date+'"></td>'; 
                tr_html +='<td><input type="text" readonly="readonly" class="form-control" name="net_money[]" value="'+(item.net_money)+'"></td>';
                tr_html +='<td><input type="text" readonly="readonly" class="form-control" name="tax[]" value="'+(item.tax)+'"></td>';
                tr_html +='<td><input type="text" readonly="readonly" class="form-control" name="total_money[]" value="'+(item.total_money)+'"></td>'; 
                tr_html +='<td><a href="'+url+'" type="button" class="btn btn-labeled btn-warning showBtn"><i class="fa fa-retweet"></i> اضافة اشعار دائن للفاتورة </a> </td>';                                   
                               
            newTr.html(tr_html);
            newTr.appendTo('#sTable');
        });
 
    }
 

</script>

@endsection 
