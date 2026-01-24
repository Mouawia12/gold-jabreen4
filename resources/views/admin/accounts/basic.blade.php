@extends('admin.layouts.master')
@section('content')
@can('اضافة حسابات')   
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
                <div class="card-header pb-0 text-center">
                    <div class="col-lg-12 margin-tb ">
                        <h4  class="alert alert-primary text-center"> 
                          [ {{__(' قيد بسيط - تحويل بين الحسابات')}} ]
                        </h4>
                    </div> 
                </div>   
                <div class="card-body px-0 pt-0 pb-2">
                   <div class="card shadow mb-4">  
                   <div class="card-body">
                    <form   method="POST" action="{{ route('store.manual.basic') }}"
                            enctype="multipart/form-data" >
                        @csrf

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>رقم القيد <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                    <input id="bill_number" readonly class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>{{ __('main.date') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="datetime-local"  id="date" name="date"
                                       class="form-control"/> 
                            </div>  
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('البيان') }} <span style="color:#fff; font-size:20px; font-weight:bold;">.</span></label>
                                    <input type="text" id="notes" name="notes"
                                       class="form-control"/> 
                                   
                                </div>
                            </div>
                            <div class="col-md-6 " >
                                <div class="form-group">
                                    <label>{{ __('main.from') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                    <select id="from_account" name="from_account" class="js-example-basic-single w-100" required>
                                        <option value="">حدد الاختيار</option>
                                        @foreach($faccounts as $account)
                                            <option value="{{$account -> id}}">{{$account -> name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" >
                                <div class="form-group">
                                    <label>{{ __('main.to') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                    <select id="to_account" name="to_account" class="js-example-basic-single w-100" required>
                                        <option value="">حدد الاختيار</option>
                                        @foreach($accounts as $account)
                                            <option value="{{$account -> id}}">{{$account -> name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('المبلغ') }}<span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                    <input type="number" id="amount" name="amount"
                                       class="form-control" required/> 
                                   
                                </div>
                            </div>   
                        </div> 

                        <div class="row">
                            <div class="col-md-12 text-center"> 
                                <button type="submit" class="btn btn-md btn-info w-25" 
                                    id="primary" 
                                    value="{{__('main.save_btn')}}">
                                    اضافة 
                                </button>  
                            </div>
                        </div> 
                    </form> 
                </div> 
            </div>
            <!-- /.container-fluid --> 
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
    function getDocNo(){

        let bill_number = document.getElementById('bill_number');
        $.ajax({
            type:'get',
            url:'{{route('manual_number')}}',
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


 
    $(document).ready(function() {
        var now = new Date(); 
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        now.setMilliseconds(null);
        now.setSeconds(null);

        document.getElementById('date').value = now.toISOString().slice(0, -1);
        getDocNo();    
    });


    function getBillNo(){

        {{--let bill_number = document.getElementById('bill_number');--}}
        {{--$.ajax({--}}
        {{--    type:'get',--}}
        {{--    url:'{{route('get_sale_no')}}',--}}
        {{--    dataType: 'json',--}}

        {{--    success:function(response){--}}
        {{--        console.log(response);--}}

        {{--        if(response){--}}
        {{--            bill_number.value = response ;--}}
        {{--        } else {--}}
        {{--            bill_number.value = '' ;--}}
        {{--        }--}}
        {{--    }--}}
        {{--});--}}
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


    function is_numeric(mixed_var) {
        var whitespace = ' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
        return (
            (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -1)) &&
            mixed_var !== '' &&
            !isNaN(mixed_var)
        );
    }

     
 </script>
@endsection 
 
 





