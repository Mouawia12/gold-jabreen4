@extends('admin.layouts.master')
<style>
</style>
@section('content')

    <!-- main-content closed -->
    @if (session('success'))
        <div class="alert alert-success  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    @if (session('danger'))
        <div class="alert alert-danger  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('danger') }}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Errors :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="alert alert-primary  text-center">
                        رفع ملف جديد
                    </h4>
                </div>
                <div class="card-body" style="padding:5%;">
                    <form action="{{route('admin.uploads.store')}}" method="post"
                          enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row m-t-3 mb-3"> 
                            <div class="col-md-12">
                                <label> الملف <span class="text-danger"> </span></label>
                                <input type="file"  name="import_excel"  id="import_excel" accept=".csv, .xls, .xlsx,application/excel,application/vnd.ms-excel,application/vnd.msexcel" class="form-control"  required>
                            </div>
                             
                            <div class="col-md-12">
                                <label> نوع الملف <span class="text-danger"> </span></label>
                                <select required  class="form-control" name="type" id="type">
                                            <option value=""></option>
                                            @foreach($data as $file)
                                                <option 
                                                    value="{{$file->id}}">{{$file->name}}
                                                </option>
                                            @endforeach
                                 </select>
                            </div> 
                        </div> 
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">
                                <i class="fa fa-cloud-upload"></i> رفع
                            </button>
                        </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
 
@endsection
