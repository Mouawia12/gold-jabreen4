@extends('admin.layouts.master')
@section('content')
@can('تعديل حسابات')   
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
                        {{__('main.account_settings')}} / {{__('main.account_settings_create')}}
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div>  
                <div class="card-body px-0 pt-0 pb-2">
                    <form   method="POST" action="{{ route('update_account_settings' , $setting -> id) }}">
                        @csrf

                        <div class="row" style="padding: 20px">
                            <div class="col-md-12 col-sm-12 row">

                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('الفرع') }} </label>
                                            <select class="js-example-basic-single w-100" id="branch_id" name="branch_id">
                                                @foreach($branchs as $brand)
                                                    <option value="{{$brand->id}}" @if($brand -> id == $setting -> branch_id) selected @endif>{{$brand->branch_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>



                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.safe_account') }} </label>
                                            <select class="js-example-basic-single w-100 @error('brand') is-invalid @enderror" id="safe_account" name="safe_account">

                                                @foreach($accounts as $brand)
                                                    <option value="{{$brand->id}}" @if($brand -> id == $setting -> safe_account) selected @endif>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.sales_account') }} </label>
                                            <select class="js-example-basic-single w-100 @error('brand') is-invalid @enderror" id="sales_account" name="sales_account">

                                                @foreach($accounts as $brand)
                                                    <option value="{{$brand->id}}" @if($brand -> id == $setting -> sales_account) selected @endif>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.purchase_account') }} </label>
                                            <select class="js-example-basic-single w-100 @error('brand') is-invalid @enderror" id="purchase_account" name="purchase_account">

                                                @foreach($accounts as $brand)
                                                    <option value="{{$brand->id}}"  @if($brand -> id == $setting -> purchase_account) selected @endif>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.return_sales_account') }} </label>
                                            <select class="js-example-basic-single w-100 @error('brand') is-invalid @enderror" id="return_sales_account" name="return_sales_account">

                                                @foreach($accounts as $brand)
                                                    <option value="{{$brand->id}}" @if($brand -> id == $setting -> return_sales_account) selected @endif>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.return_purchase_account') }} </label>
                                            <select class="js-example-basic-single w-100 @error('brand') is-invalid @enderror" id="return_purchase_account" name="return_purchase_account">

                                                @foreach($accounts as $brand)
                                                    <option value="{{$brand->id}}" @if($brand -> id == $setting -> return_purchase_account) selected @endif>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.stock_account') }} </label>
                                            <select class="js-example-basic-single w-100 @error('brand') is-invalid @enderror" id="stock_account" name="stock_account">

                                                @foreach($accounts as $brand)
                                                    <option value="{{$brand->id}}" @if($brand -> id == $setting -> stock_account) selected @endif>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.sales_discount_account') }} </label>
                                            <select class="js-example-basic-single w-100 @error('brand') is-invalid @enderror" id="sales_discount_account" name="sales_discount_account">

                                                @foreach($accounts as $brand)
                                                    <option value="{{$brand->id}}" @if($brand -> id == $setting -> sales_discount_account) selected @endif>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.sales_tax_account') }} </label>
                                            <select class="js-example-basic-single w-100 @error('brand') is-invalid @enderror" id="sales_tax_account" name="sales_tax_account">

                                                @foreach($accounts as $brand)
                                                    <option value="{{$brand->id}}" @if($brand -> id == $setting -> sales_tax_account) selected @endif>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.purchase_discount_account') }} </label>
                                            <select class="js-example-basic-single w-100 @error('brand') is-invalid @enderror" id="purchase_discount_account" name="purchase_discount_account">

                                                @foreach($accounts as $brand)
                                                    <option value="{{$brand->id}}" @if($brand -> id == $setting -> purchase_discount_account) selected @endif>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.purchase_tax_account') }} </label>
                                            <select class="js-example-basic-single w-100 @error('brand') is-invalid @enderror" id="purchase_tax_account" name="purchase_tax_account">

                                                @foreach($accounts as $brand)
                                                    <option value="{{$brand->id}}" @if($brand -> id == $setting -> purchase_tax_account) selected @endif>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.cost_account') }} </label>
                                            <select class="js-example-basic-single w-100 @error('brand') is-invalid @enderror" id="cost_account" name="cost_account">

                                                @foreach($accounts as $brand)
                                                    <option value="{{$brand->id}}" @if($brand -> id == $setting -> cost_account) selected @endif>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.profit_account') }} </label>
                                            <select class="js-example-basic-single w-100 @error('brand') is-invalid @enderror" id="profit_account" name="profit_account">

                                                @foreach($accounts as $brand)
                                                    <option value="{{$brand->id}}" @if($brand -> id == $setting -> profit_account) selected @endif>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div> 
                                <div class="row col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('main.reverse_profit_account') }} </label>
                                            <select class="js-example-basic-single w-100 @error('brand') is-invalid @enderror" id="reverse_profit_account" name="reverse_profit_account">

                                                @foreach($accounts as $brand)
                                                    <option value="{{$brand->id}}" @if($brand -> id == $setting -> reverse_profit_account) selected @endif>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col-6" style="display: block; margin: 20px auto; text-align: center;">
                                <button type="submit" class="btn btn-labeled btn-primary"  >
                                    {{__('main.save_btn')}}
                                </button>
                            </div>
                        </div>
                    </form> 
                </div> 

            </div>
            <!-- /.container-fluid -->
            <input id="local" value="{{Config::get('app.locale')}}" hidden>
        </div>
        <!-- End of Main Content -->
 
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
@endcan 
@endsection 
@section('js') 
<!-- Page level custom scripts --> 
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }


    $('#account_type').change(function () {
        var t = $(this).val();
        $('#parent_id').val(0).trigger('change');
        $('#account_level').val(1);
        if (t == 0) {
            $('#parent_id').attr('disabled', true);
        }
        else if (t == 1) {
            $('#parent_id').attr('disabled', false);
        }
        else if (t == 2) {
            $('#parent_id').attr('disabled', false);
        }
        else if (t == 3) {
            $('#parent_id').attr('disabled', false);
        }
    });


    $('#parent_id').change(function () {
        var parent = $(this).val();
        if(parent == 0)
            return;
        var url = '{{route('get_account_level',":id")}}';
        url = url.replace(":id",parent);
        $.ajax({
            type: "get", async: false,
            url: url,
            dataType: "json",
            success: function (data) {
                $('#level').val(+data['account']['level']+1);
                $('#list').val(+data['account']['list']).trigger('change');
                $('#department').val(+data['account']['department']).trigger('change');

            }
        });


    }); 
</script>
@endsection 
