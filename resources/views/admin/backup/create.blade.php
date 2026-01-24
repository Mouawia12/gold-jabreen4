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

    @if (session('error'))
        <div class="alert alert-danger  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('error') }}
        </div>
    @endif
   
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="alert alert-primary  text-center">
                        النسخ الاحتياطي
                    </h4>
                </div>
                <div class="card-body" style="padding:5%;">
                    <form action="{{route('admin.backup.store')}}" method="post"
                          enctype="multipart/form-data">
                        {{csrf_field()}} 
                        <input type="hidden" name="status" value="1"/> 
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button class="btn btn-info pd-x-20" type="submit">
                                    <i class="fa fa-plus"></i> انشاء نسخة احتياطية
                                </button>
                            </div>
                        </div>  

                    </form>
                </div>
            </div>
        </div>
    </div>
 
@endsection  
