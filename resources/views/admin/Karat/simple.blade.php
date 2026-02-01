@extends('admin.layouts.master')
@section('content')
    <div class="row row-sm">
        <div class="col-xl-6 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-lg-12 margin-tb text-center">
                        <h4 class="alert alert-primary text-center">
                            إضافة عيار
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('storeKarat') }}">
                        @csrf
                        <input type="hidden" name="id" value="0">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('main.name_ar') }} <span style="color:red;">*</span></label>
                                    <input type="text" name="name_ar" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('main.name_en') }} <span style="color:red;">*</span></label>
                                    <input type="text" name="name_en" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('main.label') }} <span style="color:red;">*</span></label>
                                    <input type="text" name="label" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('main.stamp_value') }}</label>
                                    <input type="number" step="any" name="stamp_value" class="form-control" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('main.transform_factor') }} <span style="color:red;">*</span></label>
                                    <input type="number" step="0.0001" name="transform_factor" class="form-control" value="1" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-6 text-center">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                            </div>
                            <div class="col-6 text-center">
                                <a href="{{ route('karats') }}" class="btn btn-secondary">رجوع</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
