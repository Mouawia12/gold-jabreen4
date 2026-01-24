@extends('admin.layouts.master')
@section('content')
    @if (session('success'))
        <div class="alert alert-success  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif 
    <style>
        table.display.w-100.text-nowrap.table-bordered.dataTable.dtr-inline {
            direction: rtl;
            text-align:center;
        }
        body{
            direction: rtl; 
        } 
    </style>  
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0" id="head-right" >
                    <div class="col-lg-12 margin-tb">
                        <h4  class="alert alert-primary text-center">
                        {{__('main.item_list')}} - المقتنيات الثمينة
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="row mt-1 mb-1 text-center justify-content-center align-content-center"> 
                @can('اضافة صنف')
                   <a id="createButton" href="javascript:;"
                       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                       style="border-radius: 10px; margin:5px;">
                       <i style="margin: 5px ; padding: 5px;" class="fas fa-plus-circle fa-sm text-white-50"></i> {{__('main.add_new')}}
                    </a>
                @endcan      
                </div>
                <div class="card-body px-0 pt-0 pb-2"> 
                    <div class="card shadow mb-4"> 
                        <div class="card-body">
                            <div class="table-responsive hoverable-table">
                                <table class="display w-100  text-nowrap table-bordered" id="example1" 
                                   style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th>#</th> 
                                            <th>{{__('main.code')}}</th>
                                            <th>{{__('main.name_ar')}}</th>
                                            <th> {{__('main.name_en')}} </th>
                                            <th> صورة المنتج</th>
                                            <th> {{__('main.category')}} </th> 
                                            <th> {{__('main.weight')}} </th>
                                            <th> الماركة </th>
                                            <th> نوع الحجر</th>
                                            <th> نقاوة الحجر </th>
                                            <th> لون الحجر</th>
                                            <th> المقاس </th>
                                            <th> العيار </th>
                                            <th> وزن المشغول </th>
                                            <th> خصائص اخرى </th>
                                            <th> {{__('main.state')}} </th>
                                            <th>{{__('main.actions')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $item)
                                        <tr>
                                            <td class="text-center">{{$loop -> index + 1}}</td> 
                                            <td class="text-center">{{$item -> code}}</td>
                                            <td class="text-center">{{$item -> name_ar}}</td>
                                            <td class="text-center">{{$item -> name_en}}</td>
                                            <td class="text-center"> 
                                                <img data-toggle="modal" href="#modaldemo9"
                                                        src="{{env('APP_URL').'/uploads/items/images/'.$item -> img}}"
                                                        style="width: 50px!important;cursor: pointer; height: 50px!important;
                                                        border-radius: 100%; padding: 1px; border: 1px solid #aaa;">
                                            </td> 
                                            <td class="text-center">{{Config::get('app.locale') == 'ar' ? $item -> category_name_ar : $item -> category_name_en }}</td> 
                                            <td class="text-center">{{$item -> weight}}</td>
                                            <td class="text-center">{{$item -> 	brand}}</td>
                                            <td class="text-center">{{$item -> stone_type}}</td>
                                            <td class="text-center">{{$item -> stone_purity}}</td>
                                            <td class="text-center" >{{$item -> stone_color }}</td>
                                            <td class="text-center">{{$item -> stone_size}}</td>
                                            <td class="text-center">{{Config::get('app.locale') == 'ar' ? $item -> karat_name_ar : $item -> karat_name_en}}</td>
                                            <td class="text-center">{{$item -> metal_weight}}</td>
                                            <td class="text-center">{{$item -> other_properties1}}</td>
                                            <td class="text-center">{{$item -> state}}</td>
                                            <td class="text-center"> 
                                            @can('تعديل صنف')
                                                <button type="button" class="btn btn-labeled btn-secondary editBtn"
                                                        value="{{$item -> id}}">
                                                    <span class="btn-label" style="margin-right: 10px;"><i
                                                            class="fa fa-pen"></i></span>{{__('main.edit')}}
                                                </button>
                                            @endcan 
                                            @can('حذف صنف')
                                                <button type="button" class="btn btn-labeled btn-danger deleteBtn "
                                                        value="{{$item -> id}}">
                                                    <span class="btn-label" style="margin-right: 10px;"><i
                                                            class="fa fa-trash"></i></span>{{__('main.delete')}}
                                                </button>
                                            @endcan
                                                <br> <br>
                                            @can('عرض صنف')    
                                                <a href="{{route('printBarcode' , $item -> id)}}" target="_blank" >
                                                <button type="button" class="btn btn-labeled btn-warning printBTN" value="{{$item -> id}}">
                                                    <span class="btn-label" style="margin-right: 10px;"><i
                                                            class="fa fa-barcode" style="margin-left: 5px;
                                                            margin-right: 5px;"></i></span>{{__('main.print_barcode')}}
                                                </button>
                                                </a>
                                            @endcan
                                            @if($item -> item_type == 3 )
                                                    <br> <br>
                                                @can('عرض صنف')           
                                                    <button type="button" class="btn btn-labeled btn-info compined"
                                                            value="{{$item -> id}}">
                                                        <span class="btn-label" style="margin-right: 10px;"><i
                                                                class="fa fa-cloud"></i></span>{{__('main.compine')}}
                                                    </button>
                                                @endcan  
                                             @endif
                                                  
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
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modelTitle"> {{__('main.add_item')}}</label>
                <button type="button" class="close modal-close-btn close-create" data-bs-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="paymentBody">
                <form method="POST" action="{{ route('storeItem.collectibles') }}"
                      enctype="multipart/form-data" id="modal_form">
                    @csrf

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>{{ __('main.code') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span>
                                </label>
                                <input type="text" id="code" name="code"
                                       class="form-control"
                                       placeholder="{{ __('main.code') }}"  readonly/>
                                <input type="text" id="id" name="id"
                                       class="form-control"
                                       placeholder="{{ __('main.code') }}" hidden=""/>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="d-block">
                                     الفرع <span style="color:red; font-size:20px; font-weight:bold;">*</span>
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
                        <div class="col-6">
                            <div class="form-group">
                                <label>{{ __('main.item_type') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <select class="form-control" id="item_type" name="item_type" > 
                                    <option value="2">{{__('main.item_type2')}}</option>
                                    <option value="3">{{__('main.item_type3')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>{{ __('main.name_ar') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="text" id="name_ar" name="name_ar"
                                       class="form-control"
                                       placeholder="{{ __('main.name_ar') }}" required/>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>{{ __('main.name_en') }}  </label>
                                <input type="text" id="name_en" name="name_en"
                                       class="form-control"
                                       placeholder="{{ __('main.name_en') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>{{ __('main.category') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <select class="form-control" id="category_id" name="category_id" required >
                                    <option value=""> select...</option>
                                    @foreach($categories as $category)
                                        <option
                                            value="{{$category -> id}}">{{Config::get('app.locale') == 'ar' ? $category -> name_ar : $category -> name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                        <div class="col-4">
                            <div class="form-group">
                                <label>الماركة <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>  
                                <input type="text" step="any" id="brand" name="brand"
                                       class="form-control"
                                       />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>{{ __('main.weight') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="number"  step="any" id="weight" name="weight"
                                       class="form-control"
                                       placeholder="0" required/>
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-4" hidden>
                            <div class="form-group">
                                <label>نوع الحجر<span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="text" step="any" id="stone_type" name="stone_type"
                                       class="form-control"
                                        />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>نقاوة الحجر<span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>

                                <input type="text" step="any" id="stone_purity" name="stone_purity"
                                       class="form-control" />
                            </div>
                        </div> 
                        <div class="col-4">
                            <div class="form-group">
                                <label>لون الحجر<span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="text" step="any" id="stone_color" name="stone_color"
                                       class="form-control" />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>مقاس الحجر<span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="text" step="any" id="stone_size" name="stone_size"
                                       class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>وزن المشغول<span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="number" step="any" id="metal_weight" name="metal_weight"
                                       class="form-control"
                                       placeholder="0" value=0 />
                            </div>
                        </div>
                        <div class="col-6 type1">
                            <div class="form-group">
                                <label>العيار<span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <select class="form-control" id="karat_id" name="karat_id" >
                                    <option value=""> select...</option>
                                    @foreach($karats as $karat)
                                        <option
                                            value="{{$karat -> id}}">{{Config::get('app.locale') == 'ar' ? $karat -> name_ar : $karat -> name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>خصائص اخرى - 1<span
                                        style="color:red; font-size:20px; font-weight:bold;"></span> </label>
                                <input type="text" step="any" id="other_properties1" name="other_properties1"
                                       class="form-control"
                                        />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>خصائص اخرى - 2<span
                                        style="color:red; font-size:20px; font-weight:bold;"></span> </label>
                                <input type="text" step="any" id="other_properties2" name="other_properties2"
                                       class="form-control"
                                        />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>خصائص اخرى - 3<span
                                        style="color:red; font-size:20px; font-weight:bold;"></span> </label>
                                <input type="text" step="any" id="other_properties3" name="other_properties3"
                                       class="form-control"
                                        />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>{{ __('main.tax') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="number" step="any" id="taxx" name="taxx" value="15"
                                       class="form-control"
                                       placeholder="0" />
                            </div>
                        </div>
                        <div class="col-4" hidden>
                            <div class="form-group">
                                <label>{{ __('main.state') }}</label>
                                <select class="form-control" id="state" name="state">
                                    <option value="1" selected>{{__('main.state1')}}</option>
                                    <option value="2">{{__('main.state2')}}</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">  
                        <div class="col-lg-3 mb-2">
                            <label for=""> إرفاق صورة المنتج</label>
                            <input accept="image/*" type="file"
                                    oninput="img.src=window.URL.createObjectURL(this.files[0])" id="img"
                                    required name="img" class="form-control">         
                        </div>
                        <div class="col-lg-3 mb-2">
                             <img  src="" id="profile-img-tag"  
                             width="150px" height="150px" class="profile-img"/>
                        </div> 
                        <div class="col-3">
                            <div class="custom-file">
                            <label for=""> إرفاق شهادة المنشاء</label>
                                <input type="file"   id="att_file" name="att_file"
                                       accept="application/pdf" class="form-control">  
                            </div> 
                        </div>
                        <div class="col-3 text-right">
                            <label for=""><br></label>
                                <a href="" class="profile-pdf" id="profile-pdf-tag" target="_blank">
                                <i class="fas fa-file-pdf"></i> شهادة المنشاء
                                </a> 
                        </div>
                         @error('printer')
                        <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                         @enderror 
                    </div> 
                    <div class="row">
                        <hr>
                        <div class="col-12" style="display: block; margin: 20px auto; text-align: center;">
                            <button type="button" class="btn btn-labeled btn-primary" id="submit_modal_btn">
                                {{__('main.save_btn')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
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
                        <button type="button" class="btn btn-labeled btn-primary" onclick="confirmDelete(1)">
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
                        <button type="button" class="btn btn-labeled btn-primary" onclick="confirmDelete(1)">
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

        <!-- Modal effects -->
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100"
                            style="font-family: 'Almarai'; ">عرض صورة المنتج</h6>
                        <button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <img id="image_larger" alt="image" style="width: 100%;height: auto!important;  "/>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-md btn-danger"><i class="fa fa-colse"></i> اغلاق
                        </button>
                    </div>
                </div>
            </div>
        </div>

<div class="show_modal">

</div>

<div class="barcode_modal">

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
        $(document).on('click', '#createButton', function (event) {
            console.log('clicked');
            id = 0;
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function () {
                    $('#loader').show();
                },
                // return the result
                success: function (result) {
                    $.ajax({
                        type: 'get',
                        url: 'getItemCode-collectibles',
                        dataType: 'json',

                        success: function (response) {
                            $('#createModal').modal("show");
                            $(".modal-body #code").val(response);
                            $(".modal-body #name_ar").val("");
                            $(".modal-body #name_en").val("");
                            $(".modal-body #item_type").val(2);
                            $(".modal-body #category_id").val(""); 
                            $(".modal-body #weight").val(0); 
                            $(".modal-body #tax").val(""); 
                            $(".modal-body #state").val(1);
                            $(".modal-body #id").val(0);

                            @if(empty(Auth::user()->branch_id))
                                $(".modal-body #branch_id").val(0).trigger("change");  
                            @endif

                            setTimeout(() =>{
                                $(".modal-body .type1").slideDown();
                                $(".modal-body .type2").slideUp();
                            } , 500);


                            $(".modal-body #item_type").change(function (){
                                console.log(this.value);
                              if(this.value == 2){
                                    $(".modal-body .type2").slideDown();
                                    $(".modal-body .type1").slideUp();
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
                    $('#loader').hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                 timeout: 8000
            })
        });

        $(document).on('click', '#submit_modal_btn', function (event){

            const name_ar = document.getElementById('name_ar').value ;
            const category_id = document.getElementById('category_id').value ;   
            const type = document.getElementById('item_type').value ;
            const weight = document.getElementById('weight').value ; 
            
            if(name_ar && category_id && weight > 0 ){
                document.getElementById('modal_form').submit();
            } else {
                alert($('<div>{{trans('main.fill_data')}}</div>').text());
            }
            
        });

        $(document).on('click', '.editBtn', function (event) {

            id = event.currentTarget.value;
            event.preventDefault();
            $.ajax({
                type: 'get',
                url: 'getItem-collectibles' + '/' + id,
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
                                    var img = '{{env('APP_URL')}}/uploads/items/images/' + response.img;
                                    var pdf = '{{env('APP_URL')}}/uploads/items/files/' + response.att_file;
                                    $(".modal-body #profile-img-tag").attr('src', img); 
                                    $(".modal-body #profile-pdf-tag").attr('href', pdf); 
                                }

                                $('#createModal').modal("show");
                                $(".modal-body #code").val(response.code);
                                $(".modal-body #name_ar").val(response.name_ar);
                                $(".modal-body #name_en").val(response.name_en);
                                $(".modal-body #item_type").val(response.item_type);
                                $(".modal-body #category_id").val(response.category_id); 
                                $(".modal-body #brand").val(response.brand);
                                $(".modal-body #stone_type").val(response.stone_type);
                                $(".modal-body #stone_purity").val(response.stone_purity);
                                $(".modal-body #stone_color").val(response.stone_color);
                                $(".modal-body #stone_size").val(response.stone_size);
                                $(".modal-body #metal_weight").val(response.metal_weight);
                                $(".modal-body #other_properties1").val(response.other_properties1);
                                $(".modal-body #other_properties2").val(response.other_properties2);
                                $(".modal-body #other_properties3").val(response.other_properties3); 
                                $(".modal-body #weight").val(response.weight); 
                                $(".modal-body #taxx").val(response.tax); 
                                $(".modal-body #state").val(response.state);
                                $(".modal-body #branch_id").val(response.branch_id).trigger("change");
                                $(".modal-body #id").val(response.id);
                                

                                if(response.item_type == 3){
                                    $(".modal-body .type1").slideDown();
                                    $(".modal-body .type2").slideUp(); 
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
                             timeout: 8000
                        })
                    } else {

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
                 timeout: 8000
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

        $('img').on('click', function () {
            var image_larger = $('#image_larger');
            var path = $(this).attr('src');
            $(image_larger).prop('src', path);
        });

    });

    function confirmDelete(index) {
        let url = "" ;
        if(index == 1){
            url = "{{ route('deleteItemCollectibles', ':id') }}";
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
                            $(".modal-body #isGold").prop('checked', response.isGold);


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
                    })
                } else {

                }
            }
        });
    }
</script>
<script>
    $(document).ready(function () {
        document.title = "قائمة الأصناف - المقتنيات الثمينة";
    });
 
</script>

