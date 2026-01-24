@extends('admin.layouts.master') 
@section('content')
@can('عرض نسخة احتياطية')       
    @if (session('success'))
        <div class="alert alert-success  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

    .btn-md {
        height: 40px !important;
        min-width: 100px !important;
        padding: 10px !important;
        text-align: center !important;
    }

    input[type="checkbox"] {
        width: 20px;
        height: 20px;
    }

    span.badge {
        padding: 10px !important;
    }
</style>
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0"  id="head-right" >
                    <div class="col-lg-12 margin-tb text-center">
                        <h4  class="alert alert-info text-center">
                            النسخ الاحتياطية
                        </h4>

                    </div> 
                </div>  
                <div class="col-lg-12 margin-tb text-center">
                    @can('اضافة نسخة احتياطية')     
                    <a href="{{route('admin.backup.create')}}" type="button" class="btn btn-labeled btn-info " id="createButton">
                        <span class="btn-label" style="margin-right: 10px;">
                        <i class="fa fa-plus"></i></span>
                        {{__('main.add_new')}}
                    </a> 
                    @endcan 
                </div> 
                <div class="card-body">
                    <table
                        class="table table-condensed table-striped table-hover display w-100 table-bordered text-center"
                        id="example1">
                        <thead>
                            <tr> 
                                <th class="border-bottom-0 text-center">#</th>
                                <th class="border-bottom-0 text-center">النسخة</th>
                                <th class="border-bottom-0 text-center"> الحجم</th> 
                            </tr>
                        </thead>
                        <tbody> 
                        @foreach ($data as $key => $file)
                            <tr> 
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $file['name']}} <a href={{url('/storage/app/'.$file['name'])}}> <i class="fa fa-download"></i></a></td>
                                <td>{{ $file['size'] }}</td>  
                            </tr>
                        @endforeach
                        </tbody> 
                    </table>
                </div>
            </div>
        </div>
    <!--/div--> 
@endcan 
@endsection  
 