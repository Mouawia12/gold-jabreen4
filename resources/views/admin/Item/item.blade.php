@extends('admin.layouts.master')
@can('عرض صنف')
@section('css')    
    <style>
        table.display.w-100.text-nowrap.table-bordered.dataTable.dtr-inline {
            direction: rtl;
            text-align:center;
        }
        body{
            direction: rtl; 
        }

        .hoverable-table tbody .btn {
            margin-left: 2% !important; 
        }
    </style>  
@endsection
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
                <div class="card-header pb-0" id="head-right" >
                    <div class="col-lg-12 margin-tb">
                        <h4  class="alert alert-primary text-center">
                        {{__('main.item_list')}}
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div>  
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="card shadow mb-4"> 
                        <div class="card-body">
                            <div class="table-responsive hoverable-table"> 
                                <table class="display w-100 text-nowrap table-bordered" id="ItemTable" 
                                   style="text-align: center;">
                                    <thead>
                                        <tr class="bg-light">
                                            <th> # </th>  
                                            <th> {{__('main.code')}} </th>
                                            <th> {{__(' الصنف')}} </th>  
                                            <th> {{__('المجموعة')}} </th>
                                            <th> {{__('العيار')}} </th>
                                            <th> {{__('الوزن جرام')}} </th>
                                            <th> {{__('المصنعية / جرام')}} </th> 
                                            <th> {{__('الحالة')}} </th>
                                            <th> {{__('main.actions')}} </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody> 
                                </table> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <!--/div-->

<!-- Logout Modal-->
<div class="modal fade" id="createModal"  role="dialog" aria-labelledby="paymentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modelTitle">  <span id="item-name"></span> {{__('صنف')}}</label>
                <button type="button" class="close modal-close-btn close-create" data-bs-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="paymentBody">
                <form method="POST" action="{{ route('storeItem') }}"
                      enctype="multipart/form-data" id="modal_form"  class="needs-validation" novalidate >
                      @csrf
                      @method('POST')  
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('main.code') }} <span style="color:red; ">*</span>
                                </label>
                                <input type="text" id="code" name="code"
                                       class="form-control" readonly/>
                                <input type="text" id="id" name="id"
                                       class="form-control" hidden=""/>
                            </div>
                        </div>
                        <div class="col-md-2" hidden>
                            <div class="form-group">
                                <label class="d-block">
                                     الفرع
                                </label>
                                @if(empty(Auth::user()->branch_id))
                                    <select   class="js-example-basic-single w-100" name="branch_id" id="branch_id">
                                        <option value=""></option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input class="form-control" type="text" readonly
                                           value="{{Auth::user()->branch->branch_name}}"/>
                                    <input  class="form-control" type="hidden" id="branch_id"
                                           name="branch_id"
                                           value="{{Auth::user()->branch_id}}"/>
                                @endif
                    
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('main.item_type') }} <span
                                        style="color:red; ">*</span> </label>
                                <select class="form-control" id="item_type" name="item_type" >
                                    <option value="1">{{__('main.item_type1')}}</option> 
                                    <option value="3">{{__('main.item_type3')}}</option>
                                </select>
                            </div>
                        </div> 
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>{{ __('main.name_ar') }} <span
                                        style="color:red; ">*</span> </label>
                                <input type="text" id="name_ar" name="name_ar"
                                       class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3" hidden>
                            <div class="form-group">
                                <label>{{ __('main.name_en') }}  </label>
                                <input type="text" id="name_en" name="name_en"
                                       class="form-control"  />
                            </div>
                        </div> 
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('main.category') }} <span
                                        style="color:red; ">*</span> </label>
                                <select class="js-example-basic-single w-100" id="category_id" name="category_id" >
                                    <option value=""> select...</option>
                                    @foreach($categories as $category)
                                        <option
                                            value="{{$category -> id}}">{{Config::get('app.locale') == 'ar' ? $category -> name_ar : $category -> name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('main.karat') }} <span
                                        style="color:red; ">*</span> </label>
                                <select class="form-control" id="karat_id" name="karat_id" >
                                    <option value=""> select...</option>
                                    @foreach($karats as $karat)
                                        <option
                                            value="{{$karat -> id}}">{{Config::get('app.locale') == 'ar' ? $karat -> name_ar : $karat -> name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>المورد <span  style="color:red; "></span> </label>
                                <select required="" class="js-example-basic-single w-100" id="supplier_id" name="supplier_id">
                                        <option value="0" selected>حدد الاختيار...</option>
                                        @foreach($vendors as $vendor)
                                            <option value="{{$vendor -> id}}">{{$vendor -> name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>                                         
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>رقم فاتورة المورد </label>
                                <input type="number"  step="any" id="supplier_bill_number" name="supplier_bill_number"
                                       class="form-control"
                                       placeholder="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('طريقة البيع') }}</label>
                                <select class="form-control" id="multi" name="multi">
                                    <option value="1" >بيع الصنف اكثر من مره</option> 
                                    <option value="0" >بيع الصنف مره واحدة</option> 
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row type1">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('main.weight') }} <span
                                        style="color:red; ">*</span> </label>
                                <input type="number"  step="any" id="weight" name="weight"
                                       class="form-control"
                                       placeholder="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('main.no_metal') }}  </label>
                                <input type="number" step="any" id="no_metal" name="no_metal"
                                       class="form-control"
                                       placeholder="0" value="0"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('main.no_metal_type') }} </label>
                                <select class="form-control" id="no_metal_type" name="no_metal_type">
                                    <option value="1" selected>{{__('main.no_metal_type1')}}</option>
                                    <option value="2">{{__('main.no_metal_type2')}}</option>
                                </select>
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('main.stamp_value') }} <span
                                        style="color:red; ">*</span> </label>
                                <input type="number" step="any" id="tax" name="tax"
                                       class="form-control"
                                       placeholder="0" readonly/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('main.made_Value') }} <span
                                        style="color:red; ">*</span> </label>
                                <input type="number" step="any" id="made_Value" name="made_Value"
                                       class="form-control"
                                       placeholder="0" value="0" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('main.state') }}</label>
                                <select class="form-control" id="state" name="state">
                                    <option value="-1" >وارد جديد</option>
                                    <option value="1" selected>{{__('main.state1')}}</option>
                                    <option value="2">{{__('main.state2')}}</option>
                                </select>
                            </div>
                        </div>
  
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('main.cost') }} / جرام<span style="color:red; ">*</span> </label>
                                <input type="number" step="any" id="cost" name="cost"
                                       class="form-control"
                                       placeholder="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('main.price') }} / جرام <span
                                        style="color:red; ">*</span> </label>
                                <input type="number" step="any" id="price" name="price"
                                       class="form-control"
                                       placeholder="0" />
                            </div>
                        </div> 
                    </div>

                    <div class="row type2"> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('main.tax') }} <span
                                        style="color:red; ">*</span> </label>
                                <input type="number" step="any" id="taxx" name="taxx"
                                       class="form-control"
                                       placeholder="0" />
                            </div>
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{ __('main.img') }}</label>
                            <div class="row"> 
                                <div class="col-md-6">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="img" name="img"
                                               accept="image/png, image/jpeg" >
                                        <label class="custom-file-label" for="img"
                                               id="path">{{__('main.img_choose')}} 
                                        </label>
                                    </div>
                                    <br> 
                                    <span style="font-size: 9pt ; color:gray;">{{ __('main.img_hint') }}</span>

                                </div>
                                <div class="col-md-6 text-right">
                                
                                    <img src="{{asset('assets/img/photo.png')}}" id="profile-img-tag" width="150px"
                                         height="150px" class="profile-img"/>
                                </div>
                            </div>
                            @error('printer')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-md-6 text-left" style="display: block; margin: 20px auto; text-align: center;">
                            <button type="button" class="btn btn-labeled btn-primary" id="submit_modal_btn">
                                {{__('main.save_btn')}}
                            </button>
                        </div>
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="smallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modelTitle"> {{__('main.deleteModal')}}</label>
                <button type="button" class="close cancel-modal" data-bs-dismiss="modal" aria-label="Close"
                        style="color: red; font-size: 20px; font-weight: bold;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody"> 
                <label class="alertTitle">{{__('main.delete_alert')}}</label>
                <br> <label class="alertSubTitle" id="modal_table_bill"></label>
                <div class="row">
                   <div class="col-12 text-center">
                        <input type="number" step="any" id="id" name="id"
                                       class="form-control" readonly/>
                    </div>
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-labeled btn-primary" onclick="confirmDelete(1)">
                            <span class="btn-label" style="margin-right: 10px;"><i
                                    class="fa fa-check"></i></span>{{__('main.confirm_btn')}}
                        </button>
                    </div>
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-labeled btn-danger cancel-modal">
                            <span class="btn-label" style="margin-right: 10px;"><i
                                    class="fa fa-close"></i></span>{{__('main.cancel_btn')}}
                        </button>
                    </div>
                </div>
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
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: red; font-size: 20px; font-weight: bold;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody">
                <img src="../assets/img/warning.png" class="alertImage">
                <label class="alertTitle">{{__('main.delete_alert')}}</label>
                <br> <label class="alertSubTitle" id="modal_table_bill"></label>
                <div class="row">
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-labeled btn-primary" onclick="confirmDelete(2)">
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
<div class="show_modal">

</div>

<div class="barcode_modal">

</div>


@endsection 
@endcan 
@section('js')
    <!-- validation JS --> 
    <script src="{{asset('assets/js/validation.js')}}"></script> 
    <script type="text/javascript">
          $(document).ready(function () {
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
            var table = $('#ItemTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,

                ajax: "{{ route('items') }}",
                columns: [
                    {
                        data: 'id', 
                        name: 'id'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name_ar',
                        name: 'name_ar'
                    },
                    {
                        data: 'category_name_ar',
                        name: 'category_name_ar'
                    },
                    {
                        data: 'karat_name_ar',
                        name: 'karat_name_ar'
                    },
                    {
                        data: 'weight',
                        name: 'weight'
                    },
                    {
                        data: 'made_Value',
                        name: 'made_Value'
                    }, 
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    }, 
                    {
                        @can(['تعديل صنف','حذف صنف'])
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        @endcan
                    },
                ],
                dom: 'lBfrtip',
                
                buttons: [
                    {  
                        text: '@can('اضافة صنف')<a id="createButton" href="javascript:;" class="text-white"><i class="fa fa-plus"></i></a>  @endcan ',
                    }, 
                    {
                        extend: 'excel',
                        text: '<i title="export to excel" class="fa fa-file-excel"></i>',
                    }, 
                    {
                        extend: 'print',
                        text: '<i title="print" class="fa fa-print"></i>',
                    },
                    {
                        extend: 'colvis',
                        text: '<i title="column visibility" class="fa fa-eye"></i>',
                    },  
                ],
         
                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                order: [[0, 'desc']]
            }).buttons().container().appendTo('#ItemTable_wrapper .col-md-6:eq(0)');
        });
</script> 
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            document.getElementById('path').innerHTML = input.files[0].name;
        }
    }

    $("#img").change(function () {
        readURL(this);
    });
</script>

<script type="text/javascript">
    let id = 0; 
    $(document).ready(function () {

        id = 0;
        document.title = "{{__('main.item_list')}}";
        $(document).on('click', '#createItem', function (event) {
            window.location = "{{route('items.create')}}";
        });
		
        $(document).on('click', '#createButton', function (event) {
			
            console.log('clicked');
            id = 0;
            event.preventDefault();
			
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function () {
                    $('#global-loader').show();
                },
                // return the result
                success: function (result) {
					
                    var route = '{{route('getItemCode',":id")}}';  
                    route = route.replace(":id",1); 
                    
                    $.ajax({
                        type: 'get',
                        url: route ,
                        dataType: 'json',

                        success: function (response) {
                            $('#createModal').modal("show");
                            $(".modal-body #code").val(response);
                            $(".modal-body #name_ar").val("");
                            $(".modal-body #name_en").val("");
                            $(".modal-body #item_type").val(1);
                            $(".modal-body #category_id").val("");
                            $(".modal-body #karat_id").val("");
                            $(".modal-body #weight").val(0);
                            $(".modal-body #no_metal").val(0);
                            $(".modal-body #no_metal_type").val(1);
                            $(".modal-body #tax").val("");
                            $(".modal-body #made_Value").val(0);
                            $(".modal-body #state").val(1);
                            $(".modal-body #price").val(0);
                            $(".modal-body #cost").val(0);
                            $(".modal-body #multi").val(1);
                            $(".modal-body #supplier_id").val(0).trigger("change"); 
                            $(".modal-body #supplier_bill_number").val(0);  
                            document.getElementById('item-name').innerHTML=' اضافة';
                            @if(empty(Auth::user()->branch_id))
                                $(".modal-body #branch_id").val(1).trigger("change");  
                            @endif
                            $(".modal-body #id").val(0);

                            setTimeout(() =>{
                                $(".modal-body .type1").slideDown();
                                $(".modal-body .type2").slideUp();
                            } , 500);


                            $(".modal-body #item_type").change(function (){
                                console.log(this.value);
                                if(this.value == 1  ){
                                    $(".modal-body .type1").slideDown();
                                    $(".modal-body .type2").slideUp();
                                    $(".modal-body #weight").prop('readonly', false);
                                    $(".modal-body #made_Value").prop('readonly', false);
                                   
                                } else if(this.value == 2){
                                    $(".modal-body .type2").slideDown();
                                    $(".modal-body .type1").slideUp();
                                } else if(this.value == 3){ 
                                    $(".modal-body .type1").slideUp();
                                    $(".modal-body #weight").prop('readonly', true);
                                    $(".modal-body #made_Value").prop('readonly', true);
                                }
                            });

                            $(".modal-body #karat_id").change(function (){
                                $.ajax({
                                    type: 'get',
                                    url: 'getKarat' + '/' + this.value,
                                    dataType: 'json', 
                                    success: function (response) { 
                                        $(".modal-body #tax").val(response.stamp_value);
                                    }
                                });
                            });
                        }
                    });
                },
                complete: function () {
                    $('#global-loader').hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#global-loader').hide();
                },
                 timeout:300000
            })
        });

        $(document).on('click', '#submit_modal_btn', function (event){

            const name_ar = document.getElementById('name_ar').value ;
            const category_id = document.getElementById('category_id').value ;
            const karat_id = document.getElementById('karat_id').value ;
            const weight = document.getElementById('weight').value ;
            const made_Value = document.getElementById('made_Value').value ;
            const type = document.getElementById('item_type').value ;
            const supplier_id = document.getElementById('supplier_id').value ;
            
            if(type == 1){
                if(name_ar && category_id && karat_id){
                    document.getElementById('modal_form').submit();
                } else {
                    alert($('<div>{{trans('main.fill_data')}}</div>').text());
                }
            } else if(type == 2){
                if(name_ar && category_id ){
                    document.getElementById('modal_form').submit();
                } else {
                    alert($('<div>{{trans('main.fill_data')}}</div>').text());
                }
            }
            else if(type == 3){
                if(name_ar && category_id && karat_id ){
                    document.getElementById('modal_form').submit();
                } else {
                    alert($('<div>{{trans('main.fill_data')}}</div>').text());
                }
            }
        });

        $(document).on('click', '.editBtn', function (event) {

            id = event.currentTarget.value;
            event.preventDefault();
            $.ajax({
                type: 'get',
                url: 'getItem' + '/' + id,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response) {
                        let href = $(this).attr('data-attr');
                        $.ajax({
                            url: href,
                            beforeSend: function () {
                                $('#loader').show();
                            },
                            // return the result
                            success: function (result) {
                                $('#createModal').modal("show");
                                if (response.img) {
                                    var img = '../images/Items/' + response.img; 
                                    $(".modal-body #profile-img-tag").attr('src', img);
                                }

                                $('#createModal').modal("show");
                                $(".modal-body #code").val(response.code);
                                $(".modal-body #name_ar").val(response.name_ar);
                                $(".modal-body #name_en").val(response.name_en);
                                $(".modal-body #item_type").val(response.item_type);
                                $(".modal-body #category_id").val(response.category_id).trigger("change");;
                                $(".modal-body #karat_id").val(response.karat_id);
                                $(".modal-body #weight").val(response.weight);
                                $(".modal-body #no_metal").val(response.no_metal);
                                $(".modal-body #no_metal_type").val(response.no_metal_type);
                                $(".modal-body #tax").val(response.tax);
                                $(".modal-body #made_Value").val(response.made_Value);
                                $(".modal-body #state").val(response.state);
                                $(".modal-body #cost").val(response.cost);
                                $(".modal-body #price").val(response.price);
                                $(".modal-body #multi").val(response.multi);
                                $(".modal-body #supplier_id").val(response.supplier_id).trigger("change");
                                $(".modal-body #supplier_bill_number").val(response.supplier_bill_number);
                                $(".modal-body #branch_id").val(response.branch_id).trigger("change");   
                                document.getElementById('item-name').innerHTML=' تعديل';
                                $(".modal-body #id").val(response.id);

                                if(response.item_type == 1 ){
                                    $(".modal-body .type1").slideDown();
                                    $(".modal-body .type2").slideUp();
                                    $(".modal-body #weight").prop('readonly', false);
                                    $(".modal-body #made_Value").prop('readonly', false);
                                } else if(response.item_type == 3){
                                    $(".modal-body .type1").slideDown();
                                    $(".modal-body .type2").slideUp();
                                    $(".modal-body #weight").prop('readonly', true);
                                    $(".modal-body #made_Value").prop('readonly', true);
                                } else if(response.item_type == 2){
                                    $(".modal-body .type2").slideDown();
                                    $(".modal-body .type1").slideUp();
                                }

                                $(".modal-body #karat_id").change(function (){
                                    $.ajax({
                                        type: 'get',
                                        url: 'getKarat' + '/' + this.value,
                                        dataType: 'json', 
                                        success: function (response) { 
                                            $(".modal-body #tax").val(response.stamp_value);
                                        }
                                    });
                                });
                            },
                            complete: function () {
                                $('#loader').hide();
                            },
                            error: function (jqXHR, testStatus, error) {
                                console.log(error);
                                alert("Page " + href + " cannot open. Error:" + error);
                                $('#loader').hide();
                            },
                             timeout: 2000000
                        })
                    } 
                }
            }); 
        });

        $(document).on('click', '.deleteBtn', function (event) {
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
                    $('#deleteModal #id').val(id);
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
                 timeout: 30000
            })
        });
        $(document).on('click', '.compined', function (event) {
            var route = '{{route('getParentItem',":id")}}';
            var val = event.currentTarget.value;
            route = route.replace(":id",val);

            $.get( route, function( data ) {
                $( ".show_modal" ).html( data );
                $('#compineModal').modal('show');
            });

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
                    $('#compineModal').modal("hide");
                    $('#deleteModal2').modal("show");
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

        
        $(document).on('click' , '.printBTN' , function (event) {
            {{--const id = event.currentTarget.value;--}}
            {{--var route = '{{route('printBarcode',":id")}}';--}}
            {{--route = route.replace(":id", id);--}}
            {{--document.location.href = route ;--}}
        });

        $(document).on('click', '.cancel-modal', function (event) {
            $('#deleteModal').modal("hide");
            id = 0;
        });
        $(document).on('click', '.close-create', function (event) {
            $('#createModal').modal("hide");
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

    function EditModal(id) {
        $.ajax({
            type: 'get',
            url: 'getCategory' + '/' + id,
            dataType: 'json',

            success: function (response) {
                console.log(response);
                if (response) {
                    let href = $(this).attr('data-attr');
                    $.ajax({
                        url: href,
                        beforeSend: function () {
                            $('#loader').show();
                        },
                        // return the result
                        success: function (result) {
                            $('#createModal').modal("show");
                            var img = '../images/Category/' + response.image_url;
                            $(".modal-body #profile-img-tag").attr('src', img);
                            $(".modal-body #name").val(response.name);
                            $(".modal-body #code").val(response.code);
                            $(".modal-body #slug").val(response.slug);
                            $(".modal-body #description").val(response.description);
                            $(".modal-body #parent_id").val(response.parent_id);
                            $(".modal-body #id").val(response.id); 
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
                } 
            }
        });
    }
</script> 
@endsection
