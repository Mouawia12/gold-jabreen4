@extends('admin.layouts.master')
@section('content')
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
                <div class="card-header pb-0">
                    <div class="col-lg-12 margin-tb">
                        <h4  class="alert alert-primary text-center">
                        {{__('main.warehouses')}}
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="row mt-1 mb-1 text-center justify-content-center align-content-center">  
                @can('اضافة الاعدادات')
                        <a  id="createButton" href="javascript:;" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="border-radius: 10px; margin:5px;"><i style="margin: 5px ; padding: 5px;"
                            class="fas fa-plus-circle fa-sm text-white-50"></i>  {{__('main.add_new')}}</a>
                @endcan 
                </div>
                        <div class="card-body">
                           <div class="table-responsive hoverable-table">
                                <table class="display w-100  text-nowrap table-bordered" id="example1" 
                                   style="text-align: center;">
                                    <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">#</th>
                                        <th class="text-uppercase text-secondary text-md-center font-weight-bolder opacity-7 ps-2">{{__('main.code')}}</th>
                                        <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">{{__('main.name')}}</th>
                                        <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.phone')}} </th>
                                        <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('الفرع')}} </th>
                                        <th class="text-end text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">{{__('main.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($storehouses as $storehouse)
                                        <tr>
                                            <td class="text-center">{{$loop -> index + 1}}</td>
                                            <td class="text-center">{{$storehouse -> id}}</td>
                                            <td class="text-center">{{$storehouse -> name}}</td>
                                            <td class="text-center">{{$storehouse -> phone}}</td>
                                            <td class="text-center">{{$storehouse -> branch_id}}</td>
                                            <td class="text-center">
                                            @can('تعديل الاعدادات')
                                                <button type="button" class="btn btn-labeled btn-info editBtn" value="{{$storehouse -> id}}">
                                                    <span class="btn-label" style="margin-right: 10px;"><i class="fa fa-pen"></i></span> {{__('main.edit')}}</button>
                                            @endcan 
                                            @can('حذف الاعدات')
                                                <button type="button" class="btn btn-labeled btn-danger deleteBtn"  value="{{$storehouse -> id}}">
                                                    <span class="btn-label" style="margin-right: 10px;"><i class="fa fa-trash"></i></span> {{__('main.delete')}}</button>
                                            @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                         
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>
     <!--/div-->
<!-- Logout Modal-->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modelTitle"> {{__('main.create_warehouse')}}</label>
                    <button type="button" class="close modal-close-btn close-create"  data-bs-dismiss="modal"  aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="paymentBody">
                    <form   method="POST" action="{{ route('storeWarehouse') }}"
                            enctype="multipart/form-data" >
                        @csrf

                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>{{ __('main.code') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                    <input type="text"  id="code" name="code"
                                           class="form-control"
                                           placeholder="{{ __('main.code') }}"  />
                                    <input type="text"  id="id" name="id"
                                           class="form-control"
                                           placeholder="{{ __('main.code') }}"  hidden=""/>
                                </div>
                            </div>
                            <div class="col-4 " >
                                <div class="form-group">
                                    <label>{{ __('الفرع') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                    @if(empty(Auth::user()->branch_id) || Auth::user()->hasRole('Admin'))
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
                            <div class="col-6 " >
                                <div class="form-group">
                                    <label>{{ __('main.name') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                    <input type="text"  id="name" name="name"
                                           class="form-control"
                                           placeholder="{{ __('main.name') }}"  />
                                </div>
                            </div>
                    
                        </div>

                        <div class="row">
                            <div class="col-6 " >
                                <div class="form-group">
                                    <label>{{ __('main.phone') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                    <input type="text"  id="phone" name="phone"
                                           class="form-control"
                                           placeholder="{{ __('main.phone') }}"  />
                                </div>
                            </div>
                            <div class="col-6 " >
                                <div class="form-group">
                                    <label>{{ __('main.email') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                    <input type="text"  id="email" name="email"
                                           class="form-control"
                                           placeholder="{{ __('main.email') }}"  />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 " >
                                <div class="form-group">
                                    <label>{{ __('main.vat_no') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                    <input type="text"  id="tax_number" name="tax_number"
                                           class="form-control"
                                           placeholder="{{ __('main.vat_no') }}"  />
                                </div>
                            </div>
                            <div class="col-6 " >
                                <div class="form-group">
                                    <label>{{ __('main.commercial_register') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                    <input type="text"  id="commercial_registration" name="commercial_registration"
                                           class="form-control"
                                           placeholder="{{ __('main.commercial_register') }}"  />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 " >
                                <div class="form-group">
                                    <label>{{ __('main.serial_prefix') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                    <input type="text"  id="serial_prefix" name="serial_prefix"
                                           class="form-control"
                                           placeholder="{{ __('main.serial_prefix') }}"  />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 " >
                                <div class="form-group">
                                    <label>{{ __('main.address') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                    <textarea type="text"  id="address" name="address" class="form-control" placeholder="{{ __('main.address') }}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6" style="display: block; margin: 20px auto; text-align: center;">
                                <button type="submit" class="btn btn-labeled btn-primary"  >
                                    {{__('main.save_btn')}}</button>
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
                <img src="../assets/img/warning.png" class="alertImage">
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


@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>

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
        id = 0 ;
        $(document).on('click', '#createButton', function(event) {
            console.log('clicked');
            id = 0 ;
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#createModal').modal("show");
                    $(".modal-body #name").val( "" );
                    $(".modal-body #code").val( "" );
                    $(".modal-body #phone").val( "" );
                    $(".modal-body #email").val( "" );
                    $(".modal-body #address").val( "" );
                    $(".modal-body #tax_number").val( "" );
                    $(".modal-body #commercial_registration").val( "" );
                    $(".modal-body #serial_prefix").val( "" );
                    $(".modal-body #branch_id").val(0).trigger("change");
                    $(".modal-body #id").val( 0 );

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



        $(document).on('click', '.editBtn', function(event) {

            id = event.currentTarget.value ;
            event.preventDefault();
            $.ajax({
                type:'get',
                url:'getWarehouse' + '/' + id,
                dataType: 'json',

                success:function(response){
                    console.log(response);
                    if(response){
                        let href = $(this).attr('data-attr');
                        $.ajax({
                            url: href,
                            beforeSend: function() {
                                $('#loader').show();
                            },
                            // return the result
                            success: function(result) {
                                $('#createModal').modal("show");
                                $(".modal-body #name").val( response.name );
                                $(".modal-body #code").val( response.code );
                                $(".modal-body #symbol").val( response.symbol);
                                $(".modal-body #phone").val( response.phone );
                                $(".modal-body #email").val(  response.email );
                                $(".modal-body #address").val(  response.address);
                                $(".modal-body #tax_number").val( response.tax_number );
                                $(".modal-body #commercial_registration").val( response.commercial_registration );
                                $(".modal-body #serial_prefix").val( response.serial_prefix );
                                $(".modal-body #branch_id").val( response.branch_id ).trigger("change");
                                $(".modal-body #id").val( response.id );

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
                    } else {

                    }
                }
            });

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
    function confirmDelete(){
        let url = "{{ route('deleteCategory', ':id') }}";
        url = url.replace(':id', id);
        document.location.href=url;
    }
    function EditModal(id){
        $.ajax({
            type:'get',
            url:'getCategory' + '/' + id,
            dataType: 'json',

            success:function(response){
                console.log(response);
                if(response){
                    let href = $(this).attr('data-attr');
                    $.ajax({
                        url: href,
                        beforeSend: function() {
                            $('#loader').show();
                        },
                        // return the result
                        success: function(result) {
                            $('#createModal').modal("show");
                            var img =  '../images/Category/' + response.image_url ;
                            $(".modal-body #profile-img-tag").attr('src' , img );
                            $(".modal-body #name").val( response.name );
                            $(".modal-body #code").val( response.code );
                            $(".modal-body #slug").val(response.slug);
                            $(".modal-body #description").val(response.description);
                            $(".modal-body #parent_id").val(response.parent_id);
                            $(".modal-body #id").val( response.id );
                            $(".modal-body #isGold").prop('checked' , response.isGold);


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
                } else {

                }
            }
        });
    }
</script>

 












