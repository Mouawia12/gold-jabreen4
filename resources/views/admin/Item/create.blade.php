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
                         اضافة صنف جديد
                        </h4> 
                    </div> 
                </div>  
            </div>
            <div class="card-body">  
                <form method="POST" action="{{ route('storeItem') }}"
                      enctype="multipart/form-data" id="modal_form">
                    <input type="hidden" id="form_type" name="form_type" value="1">
                    <input type="hidden" id="id" name="id" value="0">
                    @csrf

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('main.code') }} <span style="color:red; ">*</span>
                                </label>
                                <input type="text" id="code" name="code"
                                       class="form-control" required readonly/> 
                            </div>
                        </div>
                        <div class="col-md-2" hidden>
                            <div class="form-group">
                                <label class="d-block">
                                     الفرع
                                </label>
                                <option value="0">بدون</option>
                                @if(empty(Auth::user()->branch_id))
                                    <select   class="js-example-basic-single w-100" name="branch_id" id="branch_id"> 
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
                                <select class="form-control" id="item_type" name="item_type" required="" >
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
                                       class="form-control" required />
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
                                <select class="js-example-basic-single w-100" id="category_id" name="category_id" required="" >
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
                                <select class="form-control" id="karat_id" name="karat_id" required="" >
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
                                <select class="js-example-basic-single w-100" id="supplier_id" name="supplier_id">
                                        <option value="" selected>حدد الاختيار...</option>
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
                                <select class="form-control" id="multi" name="multi" required>
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
                                        style="color:red; "></span> </label>
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
                                <label>{{ __('main.cost') }} / جرام </label>
                                <input type="number" step="any" id="cost" name="cost"
                                       class="form-control"
                                       placeholder="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('main.price') }} / جرام   </label>
                                <input type="number" step="any" id="price" name="price"
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
                            <button type="submit" class="btn btn-labeled btn-primary" id="submit_modal_btn">
                                {{__('main.save_btn')}}
                            </button>
                        </div>
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div>

@endcan 
@endsection 
@section('js')  

<script type="text/javascript"> 
id = 0;
document.title = "{{__('اضافة صنف جديد')}}";

$(document).ready(function () { 
    var route = '{{route('getItemCode',":id")}}';  
    route = route.replace(":id",1); 
    $.ajax({
        type: 'get',
        url: route,
        dataType: 'json',

        success: function (response) { 
            $("#code").val(response);
        }
    });

    $("#karat_id").change(function (){
        $.ajax({
            type: 'get',
            url: 'getKarat' + '/' + this.value,
            dataType: 'json', 
            success: function (response) { 
                $("#tax").val(response.stamp_value); 
            }
        });
    });

    $("#item_type").change(function (){ 
        if(this.value == 1  ){
            $(".type1").slideDown();
            $(".type2").slideUp();
            $("#weight").prop('readonly', false);
            $("#made_Value").prop('readonly', false);
           
        } else if(this.value == 2){
            $(".type2").slideDown();
            $(".type1").slideUp();
        } else if(this.value == 3){ 
            $(".type1").slideUp();
            $("#weight").prop('readonly', true);
            $("#made_Value").prop('readonly', true);
        }
    });

    @if(empty(Auth::user()->branch_id))
        $("#branch_id").val(1).trigger("change");  
    @endif
});
    
    
    
</script> 
@endsection
