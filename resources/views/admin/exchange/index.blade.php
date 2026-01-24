@extends('admin.layouts.master')
@section('content')
@can('عرض اسعار الصرف')        
    @if (session('success'))
        <div class="alert alert-success  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
<!-- row opened -->
<style>
    table.display.w-100.text-nowrap.table-bordered.dataTable.dtr-inline {
        direction: rtl;
        text-align:center;
    }
    body{
        direction: rtl; 
    }
  
</style> 

<div class="row row-sm">
    <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0 text-center" id="head-right" >
                    <div class="col-lg-12 margin-tb ">
                        <h4  class="alert alert-primary text-center">
                           [ {{__('اسعار الصرف')}} ]
                        </h4>

                    </div> 
                </div>   
                <div class="col-lg-12 margin-tb text-center">
                    @can('اضافة اسعار الصرف')     
                    <button type="button" class="btn btn-labeled btn-info " id="createButton">
                        <span class="btn-label" style="margin-right: 10px;">
                        <i class="fa fa-plus"></i></span>
                        {{__('main.add_new')}}
                    </button> 
                    @endcan 
                </div>        
                <div class="card-body px-0 pt-0 pb-2">

                    <div class="card shadow mb-4"> 
                        <div class="card-body">
                            <div class="table-responsive">
                               <table class="display w-100  text-nowrap table-bordered" id="example1" 
                                   style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{__('main.date')}}</th>
                                            <th> {{__('سعر الصرف')}} </th>   
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($bills as $bill) 
                                        <tr>
                                            <td class="text-center">{{$loop->index+1}}</td>
                                            <td class="text-center">{{$bill -> created_at}}</td>
                                            <td class="text-center">{{$bill -> conversion_rates}}</td> 
                                        </tr>
                                    @endforeach
                                    </tbody> 
                                </table>
                            </div>
                        </div>
                    </div> 
                </div> 
            </div>
            <!-- /.container-fluid --> 
        </div>
        <!-- End of Main Content -->  
    </div>
    <!-- End of Content Wrapper --> 
</div>
<!-- End of Page Wrapper --> 

<div class="modal fade" id="createModal" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modelTitle"> {{__('تحديث سعر الصرف')}}</label>
                <button type="button" class="close modal-close-btn close-create"  data-bs-dismiss="modal"  aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="paymentBody">
                <form  method="POST" action="{{ route('admin.exchange.store') }}"
                        enctype="multipart/form-data" >
                    @csrf  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ __('سعر الصرف') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input class="form-control" id="conversion_rates" name="conversion_rates" type="number">
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-6" style="display: block; margin: 20px auto; text-align: center;">
                            <button type="submit" class="btn btn-labeled btn-primary" id="submitBtn" >
                                {{__('main.save_btn')}}
                            </button>   
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modelTitle"> {{__('main.deleteModal')}}</label>
                <button type="button" class="close"  data-bs-dismiss="modal"  aria-label="Close" style="color: red; font-size: 20px; font-weight: bold;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody">
                <img src="{{asset('assets/img/warning.png')}}" class="alertImage">
                <label class="alertTitle">{{__('main.delete_alert')}}</label>
                <br> <label  class="alertSubTitle" id="modal_table_bill"></label>
                <div class="row">
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-labeled btn-primary" onclick="confirmDelete()">
                            <span class="btn-label" style="margin-right: 10px;"><i class="fa fa-check"></i></span>{{__('main.confirm_btn')}}</button>
                    </div>
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-labeled btn-secondary cancel-modal"  >
                            <span class="btn-label" style="margin-right: 10px;"><i class="fa fa-close"></i></span>{{__('main.cancel_btn')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan 
@endsection 
@section('js')
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader(); 
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image_url").change(function(){
        readURL(this);
    });
</script>

<script type="text/javascript">
    let id = 0 ;
    $(document).ready(function()
    {
        var now = new Date(); 
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2); 
        var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

        id = 0 ;
        document.title = "{{__('اسعار الصرف')}}"; 

        $(document).on('click', '#createButton', function(event) {   
                id = 0 ;  
                $('#createModal').modal("show"); 
                $(".modal-body #id").val( 0 ); 
                $(".modal-body #conversion_rates").val(0);  
                $(".modal-body #submitBtn").show();
                $(".modal-body #printtBtn").hide();  
            
        });

 
        $(document).on('click', '.deleteBtn', function(event) {
            id = event.currentTarget.value ;
            event.preventDefault();
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
        });

        $(document).on('click' , '.cancel-modal' , function (event) {
            $('#deleteModal').modal("hide");
            id = 0 ;
        });
        $(document).on('click' , '.close-create' , function (event) {
            $('#createModal').modal("hide");
            id = 0 ;
        });
 

    }); 
</script> 
@endsection 
 










