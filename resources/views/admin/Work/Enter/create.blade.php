@extends('admin.layouts.master')
@section('content')
@can('اضافة فاتورة مشتريات')  
    @if (session('success'))
        <div class="alert alert-success  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
<style>
    input.form-control {
        padding: 0;
        width: 100%;
        text-align:center;
    }
</style>
<!-- row opened -->
<div class="row row-sm">
    <div class="card col-12"> 
        <div class="card-body px-0 pt-0 pb-2">
            <form method="POST" action="{{ route('storeWorkEntry') }}"
                  id="formWorkEntry" enctype="multipart/form-data" >
                        @csrf
                   <div class="row">
                    <div class="card shadow mb-4 col-9"> 
                        <div class="card-header pb-0">
                            <div class="col-lg-12 margin-tb">
                               <h4  class="alert alert-primary text-center">
                                انشاء فاتورة مشتريات ذهب مشغول   
                                </h4>
                            </div>
                            <div class="clearfix"></div>
                        </div> 
                        <div class="card-body"> 
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>{{ __('main.bill_no') }} <span style="color:red;">*</span> </label>
                                            <input type="text"  id="bill_number" name="bill_number"
                                                   class="form-control" placeholder="bill_no" readonly
                                            />
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>{{ __('main.date') }} <span style="color:red;">*</span> </label>
                                            <input type="datetime-local"  id="date" name="date"
                                                   class="form-control"/>     
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="d-block">
                                                 الفرع <span style="color:red;">*</span> 
                                            </label>
                                            @if(empty(Auth::user()->branch_id))
                                                <select required  class="js-example-basic-single w-100" name="branch_id" id="branch_id"> 
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
                   
                                    <div class="col-3">
                                       <div class="form-group">
                                           <label style="float: right;">{{ __('نوع الفاتورة') }} <span
                                                   style="color:red; ">*</span>
                                           </label>
                                           <select  required=""  class="form-control"
                                                   name="bill_type" id="bill_type">
                                               <option value="" selected>حدد الاختيار...</option> 
                                               <option value="1">فاتورة عادية</option>
                                               <option value="0">خصم من رصيد الكسر</option>
                                               <option value="2"> خصم من رصيد الصافي</option>
                                            
                                           </select>
                                       </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>{{ __('main.supplier_bill_number') }}</label>
                                            <input type="text"  id="supplier_bill_number" name="supplier_bill_number"
                                                   class="form-control" placeholder="{{__('main.supplier_bill_number')}}"
                                            />
                                        </div>
                                    </div> 
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ __('main.supplier') }} <span style="color:red;">*</span> </label>
                                            <select id="supplier_id" name="supplier_id" class="js-example-basic-single w-100" required="">
                                                   <option value="">حدد الاختيار</option>
                                                @foreach($vendors as $vendor)
                                                    <option value="{{$vendor -> id}}">{{$vendor -> name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 

                                </div>
                                <div class="row" hidden>
                                    <div class="col-12">
                                        <div class="form-group"> 
                                            <textarea name="notes" id="notes" rows="3" placeholder="{{ __('main.notes') }}" class="form-control" style="width: 100%"></textarea>
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-md-12" id="sticker">
                                    <div class="well well-sm">
                                        <div class="form-group" style="border: 1px solid #eee;padding: 1%;border-radius: 10px; background: #fbfbfb;width: 100%;">
                                            <div class="input-group text-center">
                                                <div class="search-box input-group" > 
                                                    <i class="fa fa-barcode" style="font-size:40px;"></i> 
                                                    <select class="form-control" id="karat_select" name="karat_select">
                                                       <option value="">حدد الاختيار</option>
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
                                                     id="createButton">
                                                     <i class="fa fa-plus"></i>
                                                     اضافة الصنف الى الفاتورة
                                                     
                                                 </button>
                                            </div> 
                                        </div> 
                                        <div class="clearfix"></div>
                                    </div>
                                </div>   
                                <div class="col-md-12"> 
                                    <div class="card-header pb-0">
                                            <h4   class="alert alert-info text-center">
                                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> 
                                                اصناف الفاتورة
                                            </h4>
                                    </div>
                                    <div class="table-responsive hoverable-table">
                                        <table class="display w-100  text-nowrap table-bordered" id="sTable" 
                                               style="text-align: center;">
                                            <thead>
                                                <tr>
                                                   <th hidden>id</th>
                                                   <th class="text-center">{{__('عيار الذهــب')}}</th>
                                                    <th class="text-center">{{__('main.weight')}}</th>
                                                    <th class="text-center Old_or_Pure" id="Old_or_Pure">
                                                        {{__('رصيد مشغول')}}
                                                    </th>
                                                    <th class="text-center">{{__('مايعادل 21')}} </th>
                                                    <th class="text-center">{{__('اجمالي النقدية')}}</th>
                                                    <th class="text-center">{{__('اجور التصنيع')}} </th>
                                                    <th class="col-md-2">{{__('المجموع')}}</th>
                                                    <th hidden>{{__('main.net_weight')}}</th>
                                                    <th > </th> 
                                                    <th hidden>factor</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody"></tbody>
                                            <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="card shadow mb-4 col-3">
                        <div class="card-header py-3">
                            <h5 class="alert alert-info text-center">{{__('المجموع الكلي')}}</h5>
                        </div>
                        <div class="card-body">
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
                                           id="total_weight21">
                                </div>
                            </div>
                            <div class="row" style="align-items: center; margin-bottom: 10px;">
                                <div class="col-6">
                                    <label style="text-align: right;float: right;"> 
                                    اجمالي النقدية
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control" id="total_mony_t">
                                </div>
                            </div>
                            <div class="row" style="align-items: center; margin-bottom: 10px;">
                                <div class="col-6">
                                    <label style="text-align: right;float: right;"> 
                                    اجمالي المصنعية
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control" id="made_Value_t">
                                </div>
                            </div>
                            <div class="row" style="align-items: center; margin-bottom: 10px;">
                                <div class="col-6">
                                    <label style="text-align: right;float: right;"> 
                                    صافي النقدية
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control" id="net_mony_t">
                                </div>
                            </div>
                            <div class="row" style="align-items: center; margin-bottom: 10px;">
                                <div class="col-6">
                                    <label
                                        style="text-align: right;float: right;"> {{__('main.total_tax')}} </label>
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control" id="tax" name="tax">
                                </div>
                            </div>
                            <hr class="sidebar-divider d-none d-md-block">
                            <div class="row" style="align-items: baseline; margin-bottom: 10px;">
                                <div class="col-6" hidden>
                                    <div class="form-group">
                                        <label
                                            style="text-align: right;float: right;"> {{__('main.discount')}} </label>
                                        <input type="number" step="any"  class="form-control" id="discount" name="discount" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            style="text-align: right;float: right;">اجمالي الفاتورة</label>
                                        <input type="text" readonly  class="form-control" id="net_after_discount" name="net_after_discount" placeholder="0">
                                    </div>
                                </div>
                            </div> 
                            <hr class="sidebar-divider d-none d-md-block"> 
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-primary" id="save_btn" tabindex="-1">
                                        <i class="fa fa-save"></i> حفظ الفاتورة
                                    </button>
                                </div> 
                            </div>
                          </div>
                        </div> 
                    </form> 
                </div> 
            </div>
                <!-- /.container-fluid -->
                <input id="local" value="{{Config::get('app.locale')}}" hidden>
                <input id="taxPer" value="{{$setting -> enabled == 1 ? $setting -> value : 0}} " hidden>
                <input id="wightPure" value="0" hidden>
                <input id="balanceNet" value="0" hidden>
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
  $(document).ready(function (){
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    now.setMilliseconds(null);
    now.setSeconds(null);

    $(document).on('click', '#save_btn', function () {
            var rows =  0 ; 
            rows = ($('#sTable tbody tr').length);
            console.log(rows); 

            var net_after_discount = document.getElementById('net_after_discount').value;
            var supplier_id = document.getElementById('supplier_id').value;
            var bill_type = document.getElementById('bill_type').value;
            var branch_id = document.getElementById('branch_id').value;
            var total_actual_weight = document.getElementById('total_actual_weight').value;
            

            if(rows > 0 && net_after_discount > 0 && supplier_id > 0 && total_actual_weight > 0
                    && bill_type && branch_id) { 
                document.getElementById('formWorkEntry').submit();
            } else {
                alert($('<div>{{trans('main.no_bill_details')}}</div>').text());
            } 
        });

    document.getElementById('total_actual_weight').value = 0 ;
    document.getElementById('total_weight21').value = 0 ;
    document.getElementById('made_Value_t').value = 0 ;
    document.getElementById('net_mony_t').value = 0 ; 
    document.getElementById('total_mony_t').value = 0 ; 
    document.getElementById('net_after_discount').value = 0 ;
    document.getElementById('discount').value = 0 ;
    document.getElementById('tax').value = 0 ;
    document.getElementById('wightPure').value = 0 ;
    document.getElementById('balanceNet').value = 0;
    document.getElementById('date').value = now.toISOString().slice(0, -1);

    getBillNo();
    $(document).on('change','#branch_id',function () {
        getBillNo();
    });

    $('#createButton').click(function (){
         const karat_select = document.getElementById('karat_select').value ;
         const type = document.getElementById('bill_type').value ;
         var Url = '';
         if(type == 1){  
            Url = 'getKarat/' + karat_select;
        }else if(type == 2){ 
            Url = 'getKaratWithPure/' + karat_select;
        }else{
            Url = 'getKaratWithOld/' + karat_select;
        } 

        $.ajax({
            type:'get',
            url:Url,
            dataType: 'json',
   
            success:function(response){ 
                AddRowToTable(response);

                if(type == 2){ 
                    $('#wightPure').val(response.balance_net);
                }
            }
        });

     });

      $(document).on('click' , '.deleteBtn' , function (event) {
          var row = $(this).parent().parent().index();
          console.log(row);
          var table = document.getElementById('tbody');
          table.deleteRow(row);
          calcTotals();
      });

      $('#bill_type').change(function (){
        var type =  this.value ;

        if(type == 0){ 
            document.getElementById('Old_or_Pure').innerHTML = 'رصيد الكسر';  
        }else if(type == 2){
            document.getElementById('Old_or_Pure').innerHTML = 'رصيد صافي 24' ; 
        }else{
            document.getElementById('Old_or_Pure').innerHTML = 'رصيد مشغول'; 
        } 

        $( "#tbody").empty();  
        calcTotals();
        document.getElementById('total_actual_weight').value = 0 ;
        document.getElementById('total_weight21').value = 0 ;
        document.getElementById('made_Value_t').value = 0 ;
        document.getElementById('net_mony_t').value = 0 ; 
        document.getElementById('total_mony_t').value = 0 ; 
        document.getElementById('net_after_discount').value = 0 ;
        document.getElementById('discount').value = 0 ;
        document.getElementById('tax').value = 0 ;
        document.getElementById('wightPure').value = 0 ;
        document.getElementById('balanceNet').value = 0;

    });

      $(document).on('change','.iQuantity',function () {
          var row = $(this).closest('tr');
          if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
              $(this).val(0);
              alert('wrong value');
              return;
          }
          const factor = row[0].cells[10].firstChild.value;
          const weight21 = $(this).val() * factor ;

          row[0].cells[4].firstChild.value = weight21.toFixed(2) ;  
          calcTotals();

          const type = document.getElementById('bill_type').value ;
          if(type == 2){
            row[0].cells[3].firstChild.value = (Number($('#wightPure').val()) - Number($('#balanceNet').val())).toFixed(2);
          }
      });
      $(document).on('keyup','.iQuantity',function () {
          var row = $(this).closest('tr');
          if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
              $(this).val(0);
              alert('wrong value');
              return;
          }
          console.log($(this).val());
          const factor = row[0].cells[10].firstChild.value;
          const weight21 = $(this).val() * factor ; 

          row[0].cells[4].firstChild.value = weight21.toFixed(2) ; 
          calcTotals();
      });

      $(document).on('change','.iMoney',function () {
          
          var row = $(this).closest('tr');
          if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
              $(this).val(0);
              alert('wrong value');
              return;
          } 
          row[0].cells[7].firstChild.value = (Number($(this).val()) + Number(row[0].cells[6].firstChild.value)).toFixed(2) ;
          row[0].cells[12].firstChild.value  =  (Number(row[0].cells[7].firstChild.value)  * (Number(row[0].cells[11].firstChild.value) / 100)).toFixed(2)
          calcTotals();
      });
      $(document).on('keyup','.iMoney',function () {
          var row = $(this).closest('tr');
          if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
              $(this).val(0);
              alert('wrong value');
              return;
          } 
          row[0].cells[7].firstChild.value = (Number($(this).val()) + Number(row[0].cells[6].firstChild.value)).toFixed(2) ;
          row[0].cells[12].firstChild.value  =  (Number(row[0].cells[7].firstChild.value)  * (Number(row[0].cells[11].firstChild.value) / 100)).toFixed(2)
          calcTotals();
      });

      $(document).on('change','.iMade',function () {
          var row = $(this).closest('tr');
          if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
              $(this).val(0);
              alert('wrong value');
              return;
          } 
          row[0].cells[7].firstChild.value = (Number($(this).val()) + Number(row[0].cells[5].firstChild.value)).toFixed(2) ;
          row[0].cells[12].firstChild.value  =  (Number(row[0].cells[7].firstChild.value)  * (Number(row[0].cells[11].firstChild.value) / 100)).toFixed(2)
          calcTotals();
      });

      $(document).on('keyup','.iMade',function () {
          var row = $(this).closest('tr');
          if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
              $(this).val(0);
              alert('wrong value');
              return;
          } 
          row[0].cells[7].firstChild.value = (Number($(this).val()) + Number(row[0].cells[5].firstChild.value)).toFixed(2);
          row[0].cells[12].firstChild.value  =  (Number(row[0].cells[7].firstChild.value)  * (Number(row[0].cells[11].firstChild.value) / 100)).toFixed(2)
          calcTotals();
      });
 
      $(document).on('change','#discount',function () {
         var made_Value_t = document.getElementById('made_Value_t').value ;
         var discount = this.value ;
          var tax = document.getElementById('tax').value ;
         var net = Number(made_Value_t) - Number(discount) + Number(tax);
          document.getElementById('net_after_discount').value =  net.toFixed(2);
      });

      $(document).on('keyup','#discount',function () {
          var made_Value_t = document.getElementById('made_Value_t').value ;
          var discount = this.value ;
          var tax = document.getElementById('tax').value ;
          var net = Number(made_Value_t) - Number(discount) + Number(tax);
          document.getElementById('net_after_discount').value =  net.toFixed(2);
      });
  
  });

  function is_numeric(mixed_var) {
      var whitespace = ' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
      return (
          (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -1)) &&
          mixed_var !== '' &&
          !isNaN(mixed_var)
      );
  }
    function getBillNo(){

        let bill_number = document.getElementById('bill_number');
        let branch_id = document.getElementById('branch_id').value;

        $.ajax({
            type: 'get',
            url: 'get_work_entry_no/'+ 0 + '/' +branch_id, 
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
    function AddRowToTable(karat){
        const local = document.getElementById('local').value ;
        const table = document.getElementById('tbody');
        var repeate = document.getElementById( 'tbody-tr' + karat.id);
        const type = document.getElementById('bill_type').value ;
        
        if(!repeate) {
            var row = table.insertRow(-1);
            row.id = 'tbody-tr' + karat.id;
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
            var cell9 = row.insertCell(9);
            var cell10 = row.insertCell(10);
            var cell11 = row.insertCell(11); 
            var cell12 = row.insertCell(12); 

            cell0.hidden = true ;
            cell8.hidden = true ;
           // cell5.hidden = true ;
            cell10.hidden = true ;
            cell11.hidden = true ;
            cell12.hidden = true ; 
 
            cell0.innerHTML = '<input name="karat_id[]" value="'+karat.id+'" hidden>'; 
            cell1.innerHTML =  karat.name_ar ;
            cell2.innerHTML = '<td><input class="form-control iQuantity" type="text" step="any" name="weight[]"  /> </td>';
            cell3.innerHTML = '<td><input class="form-control Qty" type="text" step="any" name="weight_type[]" value="'+karat.balance_net+'"  readonly/> </td>';
            cell4.innerHTML = '<td><input class="form-control" type="number"   step="any" name="weight21[]"  readonly/> </td>';
            cell5.innerHTML = '<td><input class="form-control iMoney" type="text"  step="any" name="made_money[]" id="made_money[]" /> </td>';
            cell6.innerHTML = '<td><input class="form-control iMade" type="number" step="any"  name="made_Value[]"  /> </td>';
            cell7.innerHTML = '<td><input class="form-control  iNet" type="number" step="any"  name="net_money[]"  readonly/> </td>';
            cell8.innerHTML = '<td hidden><input class="form-control" type="number" step="any" name="net_weight[]"  readonly/> </td>';
            cell9.innerHTML = `<td>
                                    <button type="button" class="btn btn-outline-danger deleteBtn " value=" '+item.id+' ">
                                     <i class="fa fa-close"></i>
                                    </button>
                                </td>`;
            cell10.innerHTML = '<input name="factor[]" value="'+karat.transform_factor+'" hidden>';
            cell11.innerHTML = '<input name="stamp[]" value="'+karat.stamp_value+'" hidden>';
            cell12.innerHTML = '<input name="tax_item[]" hidden>';

            if(type == 0 || type == 2){   
                $('.iMoney').attr({readOnly:true});  
            }

        } else {
             alert('sorry , this item is already added to table !');
        }

    }
  function calcTotals(){
        var weight = 0 ;
        var weight21 = 0;
        var money = 0 ;
        var tax = 0 ; 
        var made = 0;
        var net = 0; 
        $( "#sTable tbody tr ").each( function( index ) {
            var row = $(this).closest('tr'); 
            weight += Number(row[0].cells[2].firstChild.value);
            weight21 += Number(row[0].cells[4].firstChild.value);
            made += Number(row[0].cells[6].firstChild.value);
            money += Number(row[0].cells[5].firstChild.value) ; 
            net += Number(row[0].cells[5].firstChild.value) + Number(row[0].cells[6].firstChild.value); 
            tax += (Number(row[0].cells[5].firstChild.value) + Number(row[0].cells[6].firstChild.value) ) * (Number(row[0].cells[11].firstChild.value)/ 100);
 
        });

        document.getElementById('total_actual_weight').value = weight.toFixed(2);
        document.getElementById('total_weight21').value = weight21.toFixed(2) ;
        document.getElementById('made_Value_t').value = made.toFixed(2) ; 
        document.getElementById('total_mony_t').value = money.toFixed(2) ;  
        document.getElementById('net_mony_t').value = net.toFixed(2) ;   
        document.getElementById('discount').value = 0 ; 
        document.getElementById('tax').value = tax.toFixed(2) ;
        document.getElementById('net_after_discount').value =  (Number(net.toFixed(2)) + Number(tax.toFixed(2))).toFixed(2) ;
        document.getElementById('balanceNet').value = (Number( weight21.toFixed(2)) / 1.1428 ) ;

    }
</script>
@endsection 
 