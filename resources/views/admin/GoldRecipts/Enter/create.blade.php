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
 
    .row.d-flex.justify-content-center.karat {
        background-color: #ecf0fa;
        padding: 5px;
        border-radius: 10px;
    }
</style>
<div class="row row-sm"> 
    <div class="card col-12">  
        <div class="card-body px-0 pt-0 pb-2">
            <form id="form_recipt" method="POST" action="{{ route('admin.CatchGoldRecipts.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row"> 
                    <div class="card shadow mb-4"> 
                        <div class="card-header pb-0">
                            <div class="col-lg-12 margin-tb">
                               <h4  class="alert alert-primary text-center">
                                 سند قبض (نقد و ذهب)
                                </h4>
                            </div> 
                        </div> 
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-2">
                                     <div class="form-group">
                                        <label>{{ __('رقم السند') }} <span style="color:red;">*</span> </label>
                                        <input type="text"  required=""   id="docNumber" name="docNumber"
                                                    class="form-control" placeholder="bill_no" readonly
                                         />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{ __('main.date') }} <span style="color:red;">*</span> </label>
                                        <input  required=""  type="datetime-local"  id="date" name="date"
                                               class="form-control"  readonly/>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="d-block">
                                             الفرع
                                        </label>
                                        @if(empty(Auth::user()->branch_id))
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
                                <div class="col-md-2" >
                                    <div class="form-group">
                                        <label>{{ __('main.payment_method') }} <span style="color:red;">*</span> </label>
                                        <select class="form-control" name="payment_type" id="payment_type">
                                            <option value="0"> {{__('main.cash')}} </option>
                                            <option value="1"> {{__('main.visa')}} </option> 
                                        </select> 
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>المورد / العميل<span style="color:red;">*</span> </label>
                                        <select required="" class="js-example-basic-single w-100" id="account_id" name="account_id">
                                            <option value="">حدد الاختيار</option>
                                            @foreach($accounts as $account)
                                                <option value="{{$account -> id}}" @if($account -> id == 1) selected @endif>
                                                    {{$account -> name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-2">
                                     <div class="form-group">
                                        <label>{{ __('مبلغ النقدية') }} <span style="color:red;">*</span> </label>
                                        <input type="number" id="amount" name="amount"
                                                    class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-md-10"> 
                                    <div class="form-group">  
                                        <label>{{ __('البيان') }}</label> 
                                        <input type="text" id="notes" name="notes"
                                                    class="form-control"/>
                                    </div>
                                </div> 
                            </div> 
    
                            <div class="row d-flex justify-content-center karat"> 
                                <div class="col-md-10" id="sticker">
                                    <div class="well well-sm"> 
                                        <div class="input-group text-center">
                                            <div class="search-box input-group" > 
                                            <i class="fa fa-3x fa-barcode addIcon"></i>
                                                <select  class="form-control" id="karat_select" name="karat_select"> 
                                                    <option value="">حدد الاختيار</option>
                                                    @foreach($karats as $karat)
                                                        <option value="{{$karat -> id}}">
                                                            {{$karat -> name_ar}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div> 
                                        </div>  
                                    </div> 
                                </div>
                                <div class="col-lg-2 text-center"> 
                                    <button type="button"  
                                        class="btn btn-labeled btn-info"
                                        id="createButton">
                                        <i class="fa fa-plus"></i>
                                        اضافة الى السند 
                                    </button>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="control-group table-group"> 
                                        <div class="card-header pb-0">
                                            <h4   class="alert alert-info text-center">
                                                <i class="fa fa-gem" aria-hidden="true"></i> 
                                                تفاصيل الذهب  
                                            </h4>
                                        </div>
                                        <div class="table-responsive hoverable-table">
                                            <table  id="sTable" class="display w-100 text-center table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th hidden>id</th> 
                                                        <th class="text-center">{{__('main.karat')}}</th>
                                                        <th class="text-center">{{__('main.weight')}}</th>
                                                        <th class="text-center">{{__('main.total_weight21')}} </th>
                                                        <th class="text-center">{{__('النوع')}}</th> 
                                                        <th ></th>  
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody"></tbody>
                                                <tfoot>
                                                    <tr class="text-white bg-secondary">
                                                        <th>{{__('الاجمالي')}}</th>
                                                        <th><input id="total_actual_weight" type="text" class="form-control text-center" readonly></th>
                                                        <th><input id="gold21" name="gold21" type="text" class="form-control text-center" readonly></th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                         </div>
                     </div>
                     <div class="col-md-12 text-center">   
                        <button type="button"  
                            class="btn btn-labeled btn-primary"
                            id="save_invoice">
                            <i class="fa fa-save"></i>
                             حفظ  
                        </button> 
                     </div> 
                </div> 
            </form> 
                </div> 
            </div> 
        </div>
        <!-- End of Main Content -->  
    </div>
    <!-- End of Content Wrapper --> 
</div>
<!-- End of Page Wrapper --> 
@endsection 
@section('js') 
<script type="text/javascript">
$(document).ready(function (){
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    now.setMilliseconds(null);
    now.setSeconds(null); 

    document.getElementById('total_actual_weight').value = 0 ;
    document.getElementById('gold21').value = 0 ; 
    document.getElementById('date').value = now.toISOString().slice(0, -1);

    $(document).on('click', '#save_invoice', function () {

        var rows =  0 ;  
        var gold21 = $('#gold21').val(); 
        var amount = $('#amount').val(); 

        rows = ($('#sTable tbody tr').length);
        console.log(rows); 
       
        if(amount > 0 && gold21 > 0) {
            if (rows > 0){  
                document.getElementById('form_recipt').submit();
            } else {
                alert($('<div>{{trans('main.no_bill_details')}}</div>').text());
            }
        } else {
            alert($('<div>{{trans('يجب تحديد مبلغ النقدية السند')}}</div>').text());
        }

    });

    getBillNo();
    $(document).on('change','#branch_id',function () {
        getBillNo();
    });

    $('#createButton').click(function (){

        const karat_select = document.getElementById('karat_select').value; 
        let route = "{{route('getKarat',':id')}}";
        route = route.replace(':id', karat_select);

        $.ajax({
            type:'get',
            url:route,
            dataType: 'json',
            success:function(response){
                AddRowToTable(response);
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
          const factor = row[0].cells[5].firstChild.value;
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
          const factor = row[0].cells[5].firstChild.value;
          const weight21 = $(this).val() * factor ;
          row[0].cells[3].firstChild.value = weight21.toFixed(2) ; 
          calcTotals();
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

        let docNumber = document.getElementById('docNumber');
        let branch_id = document.getElementById('branch_id').value;

        let route = "{{route('get.gold.recipts.no',':id')}}"
        route = route.replace(':id', branch_id);

        $.ajax({
            type:'get', 
            url: route,
            dataType: 'json',
            success:function(response){
                console.log(response);
                if(response){
                    docNumber.value = response ;
                } else {
                    docNumber.value = '' ;
                }
            }
        });
    }

    function AddRowToTable(karat){ 

        const table = document.getElementById('tbody');
        var repeate = document.getElementById( 'tbody-tr' + karat.id);

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

            cell0.hidden = true ;
            cell5.hidden = true ;

            cell1.className = 'text-center';
            cell2.className = 'text-center';
            cell3.className = 'text-center';
            cell4.className = 'text-center'; 
            cell5.className = 'text-center'; 


            cell0.innerHTML = '<input name="karat_id[]" value="'+karat.id+'" hidden>';
            cell1.innerHTML =  karat.name_ar;
            cell2.innerHTML = `<td><input class="form-control text-center iQuantity" type="text" step="any" name="weight[]"  required=""/> </td>`;
            cell3.innerHTML = `<td><input class="form-control text-center" type="number" step="any" name="weight21[]"  readonly/> </td>`;
            cell4.innerHTML = `<td> 
                                    <select required="" class="form-control"
                                        name="type[]" id="type"> 

                                        <option value="0">ذهب كسر </option> 
                                        <option value="1" >ذهب مشغول</option>  
                                        <option value="2">ذهب صافي</option> 

                                    </select>
                                </td>`;
            cell5.innerHTML = '<input name="factor[]" value="'+karat.transform_factor+'" hidden>';
            cell6.innerHTML = `<td> <button type="button" class="btn btn-danger deleteBtn" value=" '+karat.id+' ">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>`; 
          
        } else {
             alert('تنبية , هذا الصنف او العيار موجود فعلاً');
        }

    }

    function calcTotals(){
      var weight = 0 ;
      var weight21 = 0;  

        $( "#sTable tbody tr ").each( function( index ) {
            var row = $(this).closest('tr');
            weight += Number(row[0].cells[2].firstChild.value);
            weight21 += Number(row[0].cells[3].firstChild.value);  
        });

        document.getElementById('total_actual_weight').value = weight.toFixed(2) ;
        document.getElementById('gold21').value = weight21.toFixed(2) ;

    }
</script>
@endsection 
 