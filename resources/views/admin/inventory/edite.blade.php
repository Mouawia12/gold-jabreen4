@extends('admin.layouts.master')
@section('content')
@can('تعديل جرد') 
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

</style> 
 
                  
    <form method="POST" action="{{ route('store_pos') }}"
          enctype="multipart/form-data" id="pos_sales_form">
        @csrf
        @method('POST')
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
        <input type="hidden" name="inventory_id" id="inventory_id" value="{{$inventory->id}}"/>
        <input type="hidden" name="branch_id" id="branch_id" value="{{$inventory->branch_id}}"/>
        <div class="row">
            <div class="card shadow mb-4 col-12">
                <div class="card-header py-3">
                    <div class="row">
                       <div class="col-12"> 
                            <h4  class="alert alert-primary text-center">
                               استكمال محضر جرد   &nbsp&nbsp&nbsp&nbsp
                               <a class="btn btn-primary" href="{{ route('inventory.report',$inventory->id) }}" target="_blank" role="button"><i class="fa fa-print"></i></a>
                            </h4>  
                        </div> 
                    </div> 
                </div>
                <div class="card-body">  
                    <div class="row">  
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('رقم المحضر') }} <span class="text-danger">*</span> </label>
                                <input type="number" name="inventory_id" id="inventory_id"  class="form-control"  value="{{$inventory->id}}" readonly/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('تاريخ المحضر') }} <span class="text-danger">*</span> </label>
                                <input type="date"  id="bill_date" name="bill_date"
                                       class="form-control"  value="{{$inventory->date}}"
                                       readonly/>
                            </div>
                        </div> 
                        <div class="col-md-6" >
                            <div class="form-group">
                                <label>{{ __('main.branche') }} <span class="text-danger">*</span> </label>
                                <input type="text" name="branch" id="branch" value="{{$inventory->branch->branch_name}}"  class="form-control"  readonly/>
                            </div>
                        </div> 
                    </div>
                    <div class="document_type1">
                        <div class="row">
                            <div class="col-12">
                                <div class="col-md-12" id="sticker"> 
                                         <div class="form-group" style="border: 1px solid #eee;padding: 1%;border-radius: 10px; background: #fbfbfb;width: 100%;">
                                            <div class="input-group wide-tip">
                                                <div class="input-group-addon"
                                                     style="padding-left: 10px; padding-right: 10px;">
                                                    <i class="fa fa-2x fa-barcode addIcon"></i>
                                                </div>
                                                <input
                                                    style="border-radius: 0 !important;padding-left: 10px;padding-right: 10px;"
                                                    type="text" name="add_item" value=""
                                                    class="form-control input-lg ui-autocomplete-input"
                                                    id="add_item"
                                                    placeholder="{{__('main.add_item_hint')}}"
                                                    autocomplete="off">

                                            </div> 
                                        <ul class="suggestions" id="products_suggestions"
                                            style="display: block">
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                   <div class="card-header pb-0">
                                        <h4   class="alert alert-info text-center">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> 
                                            {{__('main.items')}} 
                                        </h4>
                                    </div>
                                    <div class="card-body px-0 pt-0 pb-2">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home"
                                                        type="button" role="tab" aria-controls="home"
                                                        aria-selected="true">المجرود
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button"
                                                        role="tab" aria-controls="profile" aria-selected="false">الغير مجرود
                                                </button>
                                            </li>
                        
                                        </ul> 
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                <div class="table-responsive p-0">
                                                    <table id="sTable"
                                                           class="display w-100  text-nowrap table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                            <th class="text-center">{{__('main.item')}}</th>
                                                            <th class="text-center">{{__('main.karat')}}</th>
                                                            <th class="text-center">{{__('main.weight')}}</th>
                                                            <th hidden>{{__('main.price_gram')}} </th>
                                                            <th hidden>{{__('main.total_money')}}</th>
                                                            <th hidden>{{__('main.total_tax')}}</th>
                                                            <th hidden>{{__('main.total_with_tax')}}</th>
                                                            <th class="text-center">تعديل الوزن</th>
                                                            <th></th>
                                                            <th></th>
                                                            
                                                        </tr>
                                                        </thead>
                                                        <tbody id="tbody">
                                                             
                                                            @foreach($inventory_details as $inventory_detaile)
                                                                <tr data-item-id="{{$inventory_detaile->item->id}}">
                                                                    <td class="text-center">{{$loop -> index + 1}}</td> 
                                                                    <td class="text-center"><input type="hidden" name="item_id[]" value="{{$inventory_detaile->item->id}}"><span>{{$inventory_detaile->item->name_ar .' - '. $inventory_detaile->item->code}}</span> </td> 
                                                                    <td class="text-center"><input type="hidden" name="karat_id[]" value="{{$inventory_detaile->karat_id}}"> <span>{{$inventory_detaile->karat->name_ar}}</span> </td> 
                                                                    <td class="text-center"><input type="text"   readonly="readonly" class="form-control text-center iNewWeight" name="weight[]" value="{{$inventory_detaile->weight}}" ></td> 
                                                                    <td class="text-center"><input type="text" readonly="readonly"  class="form-control text-center iNewWeight2" name="weight2[]" id="weight2[{{$inventory_detaile->item->id}}]"  value="{{$inventory_detaile->new_weight}}" ></td> 
                                                                    <td class="text-center"><input type="checkbox"   name="item[]" class="cb_items" value="{{$inventory_detaile->item->id}}"/> تعديل</td> 
                                                                    <td class="text-center">
                                                                        <button type="button" class="btn btn-primary btn-update-inventory">
                                                                            <span name="msg[{{$inventory_detaile->item->id}}]" id="msg[{{$inventory_detaile->item->id}}]"></span>حفظ
                                                                        </button>
                                                                        <span class="ss" id="ss"></span>
                                                                    </td> 
                                                                </tr> 
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot></tfoot>
                                                    </table> 
                                                </div>

                                            </div>
                                            <div class="tab-pane fade show " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                <div class="table-responsive p-0">
                                                    <table id="example1" 
                                                           class="display w-100  text-nowrap table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                            <th class="text-center">{{__('main.item')}}</th>
                                                            <th class="text-center">{{__('main.karat')}}</th>
                                                            <th class="text-center">{{__('main.weight')}}</th>  
                                                            <th>غير مجرود
                                                                <button type="button" class="btn btn-primary btn-show-inventory-none">
                                                                    <i class="fa fa-refresh"></i>
                                                                </button>
                                                            </th> 
                                                             
                                                            
                                                        </tr>
                                                        </thead>
                                                        <tbody id="Ktbody"> 
                                                        </tbody>
                                                        <tfoot></tfoot>
                                                    </table> 

                                                </div>
                                           
                                            </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h6>
                                        <span class="text-danger">*</span>
                                        &nbsp&nbsp سيتم تعديل الوزن للصنف بمجرد تحديد  خيار تعديل وادخال الوزن الجديد .
                                    </h6>
                                </div>   
                            </div>
                        </div>
                    </div> 

                </div>
            </div>   
        </div> 
    </form>  


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
            <input id="taxPer" value="{{$setting -> enabled == 1 ? $setting -> value : 0}}" hidden>

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

    var suggestionItems = {};
    var sItems = {}; 
    var count = 1;
    document.title = "جرد المخزون";

    $(document).ready(function () { 

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
        });

        $(document).on('click', '.btn-show-inventory-none', function (event){
            $('#Ktbody').empty();
            StateItemToTable();
        });
        

        $(document).on('click', '.select_product', function () {
            var row = $(this).closest('li');
            var item_id = row.attr('data-item-id');
            if(suggestionItems[item_id].isChild == 0){
                addItemToTable(suggestionItems[item_id]);
            } else {
                $('#add_item').val(suggestionItems[item_id].code);
                showItemMaterialModalDialog();
            }
        });
 
        $(document).on('click', ".cb_items", function () {
            const item_id = $(this).val();
            document.getElementById('weight2['+ item_id +']').readOnly = true; 
            if ($(this).is(':checked')) { 
                //$('#weight2['+ item_id +']').prop('readonly', false);
                document.getElementById('weight2['+ item_id +']').readOnly = false; 
            } 
        });

        $('#sTable').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
        });
 
    });

    function showItemMaterialModalDialog(){
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href,
            beforeSend: function () {
                $('#loader').show();
            }, 
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
 
    function is_numeric(mixed_var) {
        var whitespace = ' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
        return (
            (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -1)) &&
            mixed_var !== '' &&
            !isNaN(mixed_var)
        );
    }

    function searchProduct(code) {

        var url = '{{route('getItems',[":branch_id",":id"])}}';
        var branch_id = $('#branch_id').val();
        url = url.replace(":id", code);
        url = url.replace(":branch_id",branch_id); 

        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                document.getElementById('products_suggestions').innerHTML = '';
                if (response) {
                    if (response.length == 1) {
                        //addItemToTable
                        if (response[0].state == 1) {
                            if(response[0].isChild == 0){
                                addItemToTable(response[0]);
                                var audio = $("#mysoundclip2")[0];
                                audio.play();
                            } else {
                                //showItemMaterialDialog
                                showItemMaterialModalDialog();
                            } 
                        }

                    } else if (response.length > 1) { 
                        showSuggestions(response);
                    } else if (response.id) {
                        showSuggestions(response);
                    } else {
                        //showNotFoundAlert
                        openDialog();
                        document.getElementById('add_item').value = '';
                    }
                } else {
                    //showNotFoundAlert
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
                    if (local == 'ar') {
                        $data += '<li class="select_product" data-item-id="' + item.id + '">' + item.name_ar + '--' + item.code + '</li>';
                    } else {
                        $data +='<li class="select_product" data-item-id="'+item.id+'">'+item.name_ar + '--' + item.code  +'</li>';
                    }
                }

            }
        });
        document.getElementById('products_suggestions').innerHTML = $data;
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
        if(count == 1) {
            $( "#sTable tbody tr ").each( function( index ) {
              var row = $(this).closest('tr'); 
              count +=1;
            });
        }

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

            const inventory_id = $('#inventory_id').val(); 
            const branch_id = $('#branch_id').val();   

            $.post("{{route('admin.inventory.add')}}", {
                    id: item.id, 
                    karat: item.karat_id, 
                    weigth: item.weight, 
                    inventory_id: inventory_id,
                    branch_id: branch_id,
                    "_token": "{{ csrf_token() }}"
                });

        }

            var newTr = $('<tr data-item-id="' + item.id + '">');
            tr_html = '<td class="text-center">' + count + '</span> </td>'; 
            tr_html += '<td class="text-center"><input type="hidden" name="item_id[]" value="' + item.id + '"><span>' + item.name_ar + ' [ ' + (item.code) +  ' ] ' +'</span> </td>';
            tr_html += '<td class="text-center"><input type="hidden" name="karat_id[]" value="' + item.karat_id + '"> <span>' + item.karat.name_ar + '</span> </td>';
            tr_html += '<td class="text-center"><input type="text" readonly="readonly" class="form-control text-center iNewWeight" name="weight[]" value="' + item.weight + '" ></td>';
            tr_html += '<td class="text-center"><input type="text" readonly="readonly"  class="form-control text-center iNewWeight2" name="weight2[]" id="weight2[' + item.id + ']"  value="" ></td>';
            tr_html += '<td class="text-center"><input type="checkbox"   name="item[]" class="cb_items" value="' + item.id + '"/> تعديل</td>';
            tr_html += '<td class="text-center"><button type="button" class="btn btn-primary btn-update-inventory"><span name="msg[' + item.id + ']" id="msg[' + item.id + ']"></span>حفظ</button></td>';
 
            newTr.html(tr_html);
            newTr.appendTo('#sTable'); 

            count++; 

            document.getElementById('add_item').value = '';
            $('#add_item').focus();
    }


    //start
    function StateItemToTable() {
        
        const inventory_id = $('#inventory_id').val(); 
        var url = '{{route('inventory.state',":id")}}'; 
            url = url.replace(":id",inventory_id); 

            $.ajax({
                type: 'get',
                url: url ,
                dataType: 'json',

                success: function (response) {
                    console.log(response);
                    if (response) {
                        var count =1;
                        for (let i = 0; i < response.length; i++){
                            var newTr = $('<tr data-item-id="' + response[i].id + '">');
                            tr_html = '<td class="text-center">' + count + '</span> </td>';  
                            tr_html += '<td class="text-center"><span>' + response[i].name_ar + ' [ ' + (response[i].code) +  ' ] ' +'</span> </td>';
                            tr_html += '<td class="text-center"><span>' + response[i].karat.name_ar + '</span> </td>';
                            tr_html += '<td class="text-center">' + response[i].weight + '</td>';
                            
                            newTr.html(tr_html);
                            newTr.appendTo('#example1'); 
                
                            count++;  
                             
                        }
                    }else{
                        alert('no');
                    }
                }
            });

    }


    //end
 

    $(document).on('click','.btn-update-inventory',function () {
        var row = $(this).closest('tr');
        const item_id = row[0].cells[1].firstChild.value;
        const karat = row[0].cells[2].firstChild.value; 
        const weigth =  row[0].cells[3].firstChild.value;
        const weigth_new =  row[0].cells[4].firstChild.value;
        const inventory_id = document.getElementById('inventory_id').value;
         
        if(weigth_new>0){
            $.post("{{route('admin.inventory.update')}}", {
                    id: item_id, 
                    karat: karat, 
                    weigth: weigth,
                    weigth_new: weigth_new,
                    inventory_id: inventory_id,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    document.getElementById('msg['+ item_id +']').innerHTML = '<i class="fa fa-check"></i>';
            });

        } 

    });

    $(document).on('click', '.deleteBtn2', function (event) {
        var row = $(this).parent().parent().index();
        console.log(row);
        var table = document.getElementById('tbody2');
        table.deleteRow(row); 
    });

 
    function is_numeric(mixed_var) {
        var whitespace = ' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
        return (
            (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -1)) &&
            mixed_var !== '' &&
            !isNaN(mixed_var)
        );
    }

    function calcTotals(){
            var count = 0 ; 
            $( "#sTable tbody tr ").each( function( index ) {
              var row = $(this).closest('tr'); 
              count +=1;
            });
    }
    function loadItems() { 
        var num = 0 ;
        //$('#sTable tbody').empty();
        $.each(sItems, function (i, item) {
            console.log(item);
            num += 1; 
            var newTr = $('<tr data-item-id="' + item.id + '">');
            tr_html ='<td class="text-right">' + count + '</span> </td>'; 
            tr_html +='<td class="text-right"><input type="hidden" name="item_id[]" value="' + item.id + '"><span>' + item.name_ar + ' [ ' + (item.code) +  ' ] ' +'</span> </td>';
            tr_html +='<td class="text-center"><input type="hidden" name="karat_id[]" value="' + item.karat_id + '"> <span>' + item.karat.name_ar + '</span> </td>';
            tr_html += '<td><input type="text"   readonly="readonly" class="form-control iNewWeight" name="weight[]" value="' + item.weight + '" ></td>';
            tr_html += '<td hidden><input type="text"   class="form-control iNewPrice" name="gram_price[]" value="' + item.price.toFixed(2) + '" ></td>';
            tr_html += '<td hidden><input type="text" readonly="readonly" class="form-control iNewTotal" name="ItemTotalVal[]" value="' + (item.weight * item.price).toFixed(2) +  '"    ></td>';
            tr_html += '<td hidden><input type="text" readonly="readonly" class="form-control iNewTax" name="item_tax[]" value="' + (item.weight * item.price  * (item.tax / 100) ).toFixed(2)  +  '" ></td>';
            tr_html += '<td hidden><input type="text"   class="form-control iNewTotalWithTax" name="net_money[]" value=" ' +  ((item.weight * item.price) +  (item.weight * item.price  * (item.tax  / 100) )).toFixed(2)  +' " ></td>';
            tr_html += '<th><input type="text" readonly="readonly"  class="form-control iNewWeight2" name="weight2[]" id="weight2[' + item.id + ']"  value="" ></th>';
            tr_html += '<td hidden><input type="text"   class="form-control" name="newKaratTransferFactor[]" value=" ' + item.karat.transform_factor   +   '  " ></td>';
            tr_html += '<td><input type="checkbox"   name="item[]" class="cb_items" value="' + item.id + '"/> تعديل</td>';
            tr_html += '<td><a class="btn btn-primary" href="#" role="button"><span name="msg[' + item.id + ']" id="msg[' + item.id + ']"></span>حفظ</a></td>';
 

            newTr.html(tr_html);
            newTr.appendTo('#sTable'); 
        });
   
        $('#products_suggestions').empty();
    }
 
</script> 
@endsection 
 



