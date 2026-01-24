@extends('admin.layouts.master')
@section('content')
@can('اضافة صنف')
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
            <div class="card-header py-3">
                <div class="row">
                   <div class="col-12"> 
                        <h4  class="alert alert-primary text-center">
                         تجميع طقم 
                        </h4> 
                    </div> 
                </div>  
            </div>
            <div class="card-body"> 
                <form method="POST" action="{{ route('compineItem') }}"
                      enctype="multipart/form-data" id="modal_form_compine">
                    @csrf
                    <input type="hidden" id="branch_id" name="branch_id" value="{{ $item -> branch_id }}">
                    <input type="hidden" id="karat_id" name="karat_id"  value="{{ $item -> karat_id }}"/>
                    <input type="hidden" id="parent_id" name="parent_id" value="{{ $item -> id }}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{__('main.code')}} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span></label>
                                <input type="text" id="item_code" name="item_code" required
                                       class="form-control" readonly
                                       value="{{ $item->code }}"/>
                               
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>{{ __('main.compine_item') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span></label>
                                <input type="text" id="parent_name" name="parent_name" required
                                       class="form-control" readonly
                                       value="{{Config::get('app.locale') == 'ar' ?  $item -> name_ar : $item -> name_en}}"/>
                               
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>{{ __('main.karat') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="text" id="karat" name="karat"
                                       class="form-control" readonly
                                       value="{{Config::get('app.locale') == 'ar' ? $item -> karat -> name_ar : $item -> karat -> name_en}}"/>
                            </div>
                        </div>
                    </div>
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="sTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{__('main.code')}}</th>
                                <th class="text-center">{{__('main.name_ar')}}</th>  
                                <th class="text-center"> {{__('main.karat')}} </th>
                                <th class="text-center"> {{__('main.weight')}} </th>
                                <th class="text-center"> {{__('main.made_Value')}} </th> 
                                <th class="text-center">{{__('main.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody  id="tbody">
                        @foreach($data as $item)
                            <tr data-item-id="{{$item->id}}">
                                <td class="text-center">{{$loop -> index + 1}}</td>
                                <td class="text-center">{{$item -> code}}</td>
                                <td class="text-center">{{$item -> name_ar}}</td>  
                                <td class="text-center">{{Config::get('app.locale') == 'ar' ? $item -> karat_name_ar : $item -> karat_name_en}}</td>
                                <td class="text-center">{{$item -> weight}}</td> 
                                <td class="text-center">{{$item -> made_Value}}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-labeled btn-danger deleteCombineBtn"
                                            value="{{$item -> id}}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody> 
                    </table> 
                </div>
                <div class="row">
                    <div class="col-6" style="display: block; margin: 20px auto; text-align: center;">
                        <button type="submit" class="btn btn-labeled btn-primary" id="btn_modal_compine">
                            {{__('main.save_btn')}}
                        </button>
                    </div>
                </div>  
                <div class="show_modal">

                </div>
                </form>
            </div> 
        </div>
    </div> 
</div> 
<div class="modal fade" id="deleteModal2" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modelTitle"> {{__('main.deleteModal')}}</label>
                <button type="button" class="close-deleteModal2" data-bs-dismiss="modal" aria-label="Close"
                        style="color: red; font-size: 20px; font-weight: bold;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody"> 
                <label class="alertTitle">{{__('main.delete_alert')}}</label>
                <br> <label class="alertSubTitle" id="modal_table_bill"></label>
                <div class="row">
                    <div class="col-12 text-center">
                        <input type="text" id="itemCode" name="itemCode" 
                                       class="form-control" readonly
                                       value=""/>
                    </div>
                </div>        
                <div class="row">
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-labeled btn-primary" onclick="confirmDelete(2)">
                            <span class="btn-label" style="margin-right: 10px;"><i
                                    class="fa fa-check"></i></span>{{__('main.confirm_btn')}}
                        </button>
                    </div>
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-labeled btn-secondary cancel-modal">
                            <span class="btn-label" style="margin-right: 10px;"><i
                                    class="fa fa-close"></i></span>{{__('main.cancel_btn')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<audio id="mysoundclip1" preload="auto">
    <source src="{{URL::asset('assets/sound/beep/beep-timber.mp3')}}"></source>
</audio>
<audio id="mysoundclip2" preload="auto">
    <source src="{{URL::asset('assets/sound/beep/beep-07.mp3')}}"></source>
</audio>
@endcan 
@endsection 
@section('js')  

<script type="text/javascript"> 

    var suggestionItems = {};
    var sItems = {};
    var count = 1; 
    var IsRow = 0;
    document.title = "تجميع طقم";

    $(document).ready(function () {  
        
        $(document).on('click', '.deleteBtn', function (event) { 
            id = event.currentTarget.value;
            var row1 = $(this).parent().parent().index(); 
            var row = $(this).closest('tr');
            var item_id = row.attr('data-item-id');
            delete sItems[item_id];  
            var table = document.getElementById('tbody');
            table.deleteRow(row1);
            var audio = $("#mysoundclip2")[0];
            audio.play();
           
        });

        $(document).on('click', '.deleteCombineBtn', function (event) { 
            id = event.currentTarget.value;
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function () {
                    $('#loader').show();
                },
                // return the result
                success: function (result) { 
                    $('#deleteModal2').modal("show");
                    $('#deleteModal2 #itemCode').val(id);
                },
                complete: function () {
                    $('#loader').hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 30000
            })
        
        });

        calcTotals();

        $('#add_item').focus();
        $('#add_item').on('input', function (e) { 
            searchProduct($('#add_item').val());
        }); 
        function searchProduct(code) {  

            const branch_id = $('#branch_id').val(); 
            const karat_id = $('#karat_id').val();
            const parent_id = $('#parent_id').val();
            var route = '{{route('getProduct',[":code",":branch_id"])}}'; 
            
            route = route.replace(":code",code);
            route = route.replace(":branch_id",branch_id);

            $.ajax({
                type: 'get',
                url: route,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    document.getElementById('products_suggestions').innerHTML = '';
                    if (response) {
                        if (response.length == 1) {  
                            if (response[0].state == 1 && response[0].isChild == 0 && response[0].karat_id == karat_id && response[0].id != parent_id) {
                                 addItemToTable(response[0]);  
                            } 
                        } else if (response.length > 1) { 
                            showSuggestions(response);
                        } else if (response.id) {
                            showSuggestions(response);
                        } else {  
                            document.getElementById('add_item').value = '';
                        }
                    } else {  
                        document.getElementById('add_item').value = '';
                    }
                },
                error: function (err){
                    console.log( JSON.parse(JSON.stringify(err.responseText)) );
                }
            });
        }

        $(document).on('click', '.select_product', function () {

            var row = $(this).closest('li');
            var item_id = row.attr('data-item-id'); 

            if(suggestionItems[item_id].isChild == 0){
                addItemToTable(suggestionItems[item_id]); 
                var audio = $("#mysoundclip1")[0];
                audio.play();
            } 

        });

       
        function showSuggestions(response) {

            const karat_id = $('#karat_id').val();
            console.log(response);
            $data = '';

            $.each(response, function (i, item) {
                if (item.item_type == 1 && item.karat_id == karat_id) {
                    if (item.state == 1 && item.isChild == 0) {
                        suggestionItems[item.id] = item; 
                        $data += '<li class="select_product" data-item-id="' + item.id + '"><a herf="#">' + item.name_ar + ' -- ' + item.karat.name_ar + ' [ ' + item.code +' ] * وزن  ' + item.weight + '</a></li>';
                    }
                }
            });

            document.getElementById('products_suggestions').innerHTML = $data;
        }

        function addItemToTable(item) {
    
            suggestionItems = {};
            $('#products_suggestions').empty();
            suggestionItems = {};
            
            if (count == 1) {
                sItems = {};
            }
            
            if (sItems[item.id]) {
                alert('هذا الصنف موجود فعلاً');
                return;
            } else {  
                sItems[item.id] = item;
                var audio = $("#mysoundclip2")[0];
                audio.play();
                loadItems(item);
            }
            count++; 
            document.getElementById('add_item').value = '';
            $('#add_item').focus();
        }

        function loadItems(item) {  

                IsRow += 1;
                var newTr = $('<tr data-item-id="' + item.id + '">');
                var tr_html = '<td class="text-center">' + IsRow + '</td>';
                tr_html += '<td hidden><input type="hidden" name="item_id[]" value="' + item.id + '"></td>'; 
                tr_html += '<td class="text-center">' + item.code  + '</td>';   
                tr_html += '<td class="text-center">' + item.name_ar + '</td>';  
                tr_html += '<td class="text-center">' + item.karat.name_ar + '</td>'; 
                tr_html += '<td class="text-center">' + item.weight + '</td>'; 
                tr_html += '<td class="text-center">' + item.made_Value + '</td>'; 
                tr_html += `<td class="text-center">
                               <button type="button" class="btn btn-danger deleteBtn" value=" '+item.id+' ">
                                  <i class="fa fa-close"></i>
                                </button> 
                            </td>`;
            
                newTr.html(tr_html);
                newTr.appendTo('#sTable');     
        }

        function calcTotals(){ 

            $( "#sTable tbody tr ").each( function( index ) {
                var row = $(this).closest('tr');
                IsRow += 1;
            });
            
        }

        $(document).on('click', '#btn_modal_compine', function (event){ 
            const item_id = document.getElementById('item_id').value ;   
            if(item_id ){
                document.getElementById('modal_form_compine').submit();     
            } else {
                alert($('<div>{{trans('main.fill_data')}}</div>').text());
            }
        });

        $(document).on('click', '.cancel-modal', function (event) {
            $('#deleteModal2').modal("hide");
            id = 0;
        });

        $(document).on('click', '.close-deleteModal2', function (event) {
            $('#deleteModal2').modal("hide");
            id = 0;
        });

});

function confirmDelete(index) {
    let url = "" ;
    if(index == 1){
        url = "{{ route('deleteItem', ':id') }}";
    } else {
        url = "{{ route('deleteItemMaterial', ':id') }}";
    }
    url = url.replace(':id', id);
    document.location.href = url;
}

</script>
@endsection 
