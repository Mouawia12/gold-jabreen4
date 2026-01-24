@extends('admin.layouts.master')
@section('content')
    @if (session('success'))
        <div class="alert alert-success  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
<!-- row opened -->
<style>
    input.form-control {
        padding: 0;
        width: 100%;
        text-align:center;
    }
</style>
<div class="row"> 
            <div class="card">
                <div class="card-header"> 
                    <div class="col-12"> 
                        <h4  class="alert alert-primary text-center">
                          انشاء  فاتورة مشتريات ضريبية
                        </h4> 
                    </div> 
                </div>    
                <div class="card-body px-0 pt-0 pb-2">
                    <form   method="POST" action="{{ route('storeWorkEntry') }}"
                            enctype="multipart/form-data" >
                        @csrf
                   <div class="row">
                     <div class="card shadow mb-4 col-9"> 
                        <div class="card-body"> 
                            <input type="hidden"  id="notes" name="notes" value=""/>
                        
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ __('main.bill_no') }} <span style="color:red;">*</span> </label>
                                            <input type="text"  id="bill_number" name="bill_number"
                                                   class="form-control" placeholder="bill_no" readonly
                                            />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ __('main.date') }} <span style="color:red;">*</span> </label>
                                            <input type="datetime-local"  id="date" name="date"
                                                   class="form-control"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ __('main.supplier') }} <span style="color:red;">*</span> </label>
                                            <select required="" class="js-example-basic-single w-100" id="supplier_id" name="supplier_id">
                                                <option value="" selected>حدد الاختيار</option>
                                                @foreach($vendors as $vendor)
                                                    <option value="{{$vendor -> id}}">{{$vendor -> name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>{{ __('main.supplier_bill_number') }} <span style="color:red;">*</span> </label>
                                            <input type="text"  id="supplier_bill_number" name="supplier_bill_number"
                                                   class="form-control" placeholder="{{__('main.supplier_bill_number')}}"
                                            />
                                        </div>
                                    </div> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>{{ __('main.karat') }} <span style="color:red;">*</span> </label>
                                            <select class="form-control" id="karat_id" name="karat_id">
                                                <option value="" selected>حدد الاختيار</option>
                                            </select>
                                        </div>
                                    </div> 
                                </div> 
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-md-12" id="sticker">
                                            <div class="well well-sm">
                                                <div class="form-group" style="border: 1px solid #eee;padding: 1%;border-radius: 10px; background: #fbfbfb;width: 100%;">
                                                    <div class="input-group text-center">
                                                        <div class="search-box input-group" > 
                                                            <i class="fa fa-barcode" style="font-size:40px;"></i> 
                                                            <select class="form-control" id="category_id" name="category_id">
                                                                <option value="" selected>حدد الاختيار</option>
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
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="control-group table-group">
                                            
                                            <div class="card-header pb-0">
                                                    <h4   class="alert alert-info text-center">
                                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> 
                                                        اصناف الفاتورة
                                                    </h4>
                                            </div>
                                            <div class="controls table-controls">
                                                <table id="sTable" class="table items table-striped table-bordered table-condensed table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th hidden>id</th>
                                                       <th class="text-center">{{__('الصنـــــــــــــــــــف')}}</th>
                                                        <th class="text-center">{{__('main.weight')}}</th>
                                                        <th class="text-center">{{__('مايعادل 21')}} </th>
                                                        <th class="text-center">{{__('main.total_money')}}</th>
                                                        <th class="text-center">{{__('اجور التصنيع')}} </th>
                                                        <th >{{__('main.net_money')}}</th>
                                                        <th hidden>{{__('main.net_weight')}}</th>
                                                        <th >
                                                            
                                                        </th>
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
                                        <input type="submit" class="btn btn-primary" id="primary" tabindex="-1"
                                               style="width: 150px;
                                        margin: 30px auto;" value="{{__('حفظ')}}"></input>

                                    </div>
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
        </div>
        <!-- End of Main Content --> 

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
   
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script> 
  

<script type="text/javascript">
  $(document).ready(function (){
      var now = new Date();
      now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
      now.setMilliseconds(null);
      now.setSeconds(null); 
      document.getElementById('total_actual_weight').value = 0 ;
      document.getElementById('total_weight21').value = 0 ;
      document.getElementById('made_Value_t').value = 0 ;
      document.getElementById('net_after_discount').value = 0 ;
      document.getElementById('discount').value = 0 ;
      document.getElementById('tax').value = 0 ;
      document.getElementById('date').value = now.toISOString().slice(0, -1);
     getBillNo();
     $('#createButton').click(function (){
         const category_id = document.getElementById('category_id').value ;
         const karat_id = document.getElementById('karat_id').value ;
         const supplier_id = document.getElementById('supplier_id').value ;
         const bill_number = document.getElementById('supplier_bill_number').value ;
         $.ajax({
             type:'get',
            // url:'getKarat/' + category_id,
            url:'getClientSupplierKarat/'+  supplier_id + '/'  + bill_number + '/' + karat_id + '/' + category_id, 
             dataType: 'json', 
             success:function(response){ 
                 AddRowToTable(response);
                 calcTotals();
             }
         });
     });

     $('#supplier_id').change(function (){ 
        const val = this.value ; 
        $('#karat_id').empty(); 
        console.log(val);
        $('#karat_id').append('<option value="">حدد الاختيار...</option>');

            $.ajax({
                type: 'get',
                url: 'getSupplierKarat' + '/' + val,
                dataType: 'json',

                success: function (response) {
                    console.log(response);
                    if (response) {
                        for (let i = 0; i < response.length; i++){
                            $('#karat_id').append('<option value="'+response[i].karat_id+'">'+response[i].karat.name_ar + '</option>');
                        }
                    }
                }
            }); 
    }); 

    $('#karat_id').change(function (){ 
        const val = this.value ; 
        const supplier_id = document.getElementById('supplier_id').value ;
        $('#category_id').empty(); 
        console.log(val);
        $('#category_id').append('<option value="">حدد الاختيار...</option>');

            $.ajax({
                type: 'get',
                url: 'getSupplierItem' + '/' + supplier_id + '/' + val,
                dataType: 'json',

                success: function (response) {
                    console.log(response);
                    if (response) {
                        for (let i = 0; i < response.length; i++){
                            $('#category_id').append('<option value="'+response[i].category_id+'">'+response[i].category.name_ar + '</option>');
                        }
                    }
                }
            }); 
    }); 

    $('#supplier_bill_number').change(function (){ 
        const val = this.value ; 
        const supplier_id = document.getElementById('supplier_id').value ; 
         
        $('#karat_id').empty(); 
        $('#category_id').empty(); 
        $('#karat_id').append('<option value="">حدد الاختيار...</option>');
        $('#category_id').append('<option value="">حدد الاختيار...</option>');
        console.log(val);

            $.ajax({
                type: 'get',
                url: 'getSupplierBill' + '/' + supplier_id + '/' + val  ,
                dataType: 'json',

                success: function (response) {
                    console.log(response);
                    if (response) {
                        for (let i = 0; i < response.length; i++){
                            $('#karat_id').append('<option value="'+response[i].karat_id+'">'+response[i].karat.name_ar + '</option>');
                        }
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

      $(document).on('change','.iQuantity',function () {
          var row = $(this).closest('tr');
          if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
              $(this).val(0);
              alert('wrong value');
              return;
          }
          const factor = row[0].cells[9].firstChild.value;
          const weight21 = $(this).val() * factor ;
          row[0].cells[3].firstChild.value = weight21.toFixed(2) ; 
          calcTotals();

      });
      $(document).on('keyup','.iQuantity',function () {
          var row = $(this).closest('tr');
          if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
              $(this).val(0);
              alert('wrong value');
              return;
          }
          console.log($(this).val());
          const factor = row[0].cells[9].firstChild.value;
          const weight21 = $(this).val() * factor ;
          row[0].cells[3].firstChild.value = weight21.toFixed(2) ; 
          calcTotals();
      });

      $(document).on('change','.iMoney',function () {
          var row = $(this).closest('tr');
          if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
              $(this).val(0);
              alert('wrong value');
              return;
          } 
          row[0].cells[6].firstChild.value = (Number($(this).val()) + Number(row[0].cells[5].firstChild.value)).toFixed(2) ;
          calcTotals();
      });
      $(document).on('keyup','.iMoney',function () {
          var row = $(this).closest('tr');
          if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
              $(this).val(0);
              alert('wrong value');
              return;
          } 
          row[0].cells[6].firstChild.value = (Number($(this).val()) + Number(row[0].cells[5].firstChild.value)).toFixed(2) ;
          calcTotals();
      });
      $(document).on('change','.iMade',function () {
          var row = $(this).closest('tr');
          if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
              $(this).val(0);
              alert('wrong value');
              return;
          } 
          row[0].cells[6].firstChild.value = (Number($(this).val()) + Number(row[0].cells[4].firstChild.value)).toFixed(2) ;
          calcTotals();
      });
      $(document).on('keyup','.iMade',function () {
          var row = $(this).closest('tr');
          if(!is_numeric($(this).val()) || parseFloat($(this).val()) < 0){
              $(this).val(0);
              alert('wrong value');
              return;
          } 
          row[0].cells[6].firstChild.value = (Number($(this).val()) + Number(row[0].cells[4].firstChild.value)).toFixed(2);
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
        $.ajax({
            type:'get',
            url:'{{route('get_work_entry_no')}}',
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
        var repeate = document.getElementById( 'tbody-tr' +  karat.id + karat.karat_id);
        if(!repeate) {
            var row = table.insertRow(-1);
            row.id = 'tbody-tr' + karat.id + karat.karat_id;
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
            cell7.hidden = true ;
            cell9.hidden = true ;
            cell10.hidden = true ;
            cell11.hidden = true ;
            cell12.hidden = true ;
            cell1.className = 'text-center';
            cell2.className = 'text-center';
            cell3.className = 'text-center';
            cell4.className = 'text-center';
            cell5.className = 'text-center';
            cell6.className = 'text-center';
            cell7.className = 'text-center';

            cell0.innerHTML = '<input name="karat_id[]" value="'+karat.karat_id+'" hidden>'; 
            cell1.innerHTML =  karat.name_ar + ' * ' + karat.karat_name ;
            cell2.innerHTML = '<td><input class="form-control iQuantity" value="'+(karat.weight).toFixed(2)+'" type="text" step="any" name="weight[]"  /> </td>';
            cell3.innerHTML = '<td><input class="form-control" type="number" value="'+(karat.weight * karat.transform_factor).toFixed(2)+'" step="any" name="weight21[]"  readonly/> </td>';
            cell4.innerHTML = '<td><input class="form-control iMoney" type="text" value="'+(karat.weight * karat.cost ).toFixed(2)+'" step="any" name="made_money[]"  /> </td>';
            cell5.innerHTML = '<td><input class="form-control iMade" type="number" step="any" value="'+(karat.made_Value).toFixed(2) +'" name="made_Value[]"/> </td>';
            cell6.innerHTML = '<td><input class="form-control  iNet" type="number" step="any" value="'+((karat.weight * karat.cost ) + (karat.made_Value)).toFixed(2)  +'" name="net_money[]"  readonly/> </td>';
            cell7.innerHTML = '<td hidden><input class="form-control" type="number" step="any" value="'+karat.weight+'" name="net_weight[]"  readonly/> </td>';
           
            cell8.innerHTML = `<td>      <button type="button" class="btn btn-outline-danger deleteBtn " value=" '+item.id+' ">
                                             <i class="fa fa-close"></i></button> </td>`;
            cell9.innerHTML = '<input name="factor[]" value="'+karat.transform_factor+'" hidden>';
            cell10.innerHTML = '<input name="stamp[]" value="'+karat.stamp_value+'" hidden>';
            cell11.innerHTML = '<input name="tax_item[]" value="'+((karat.weight * karat.cost + karat.made_Value) * (karat.stamp_value / 100)).toFixed(2) +'" hidden>';
            cell12.innerHTML = '<input name="category_id[]" value="'+karat.category_id+'" hidden>';
        } else {
             alert('عفواً , هذا الصنف موجود فعلاً في الفاتورة!');
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
            weight21 += Number(row[0].cells[3].firstChild.value);
            made += Number(row[0].cells[5].firstChild.value);
            money += Number(row[0].cells[4].firstChild.value) ; 
            net += Number(row[0].cells[4].firstChild.value) + Number(row[0].cells[5].firstChild.value); 
            tax += (Number(row[0].cells[4].firstChild.value) + Number(row[0].cells[5].firstChild.value) ) * (Number(row[0].cells[10].firstChild.value)/ 100);
        });
        document.getElementById('total_actual_weight').value = weight.toFixed(2);
        document.getElementById('total_weight21').value = weight21.toFixed(2) ;
        document.getElementById('made_Value_t').value = made.toFixed(2) ; 
        document.getElementById('total_mony_t').value = money.toFixed(2) ;  
        document.getElementById('net_mony_t').value = net.toFixed(2) ;   
        document.getElementById('discount').value = 0 ; 
        document.getElementById('tax').value = tax.toFixed(2) ;
        document.getElementById('net_after_discount').value =  (Number(net.toFixed(2)) + Number(tax.toFixed(2))).toFixed(2) ;


    }


</script>
 