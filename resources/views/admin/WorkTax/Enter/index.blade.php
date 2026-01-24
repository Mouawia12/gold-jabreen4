@extends('admin.layouts.master')
@section('content')
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
                <div class="card-header pb-0" id="head-right" >
                    <div class="col-lg-12 margin-tb">
                        <h4  class="alert alert-primary text-center">
                           {{__('main.enter_work_list')}}
                        </h4>
                    </div>
                    <div class="row mt-1 mb-1 text-center justify-content-center align-content-center">
                        @can('اضافة امر توريد')  
                            <a  href="{{route('workEntryCreate')}}"
                               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                               style="border-radius: 10px; margin:5px;">
                               <i style="margin: 5px ; padding: 5px;" class="fas fa-plus-circle fa-sm text-white-50"></i> {{__('main.add_new')}}
                            </a> 
                        @endcan  
                    </div> 
                    <div class="clearfix"></div>
                </div> 
            </div>    
                <div class="card-body px-0 pt-0 pb-2">

                    <div class="card shadow mb-4"> 
                        <div class="card-body">
                            <div class="table-responsive hoverable-table" style="direction: rtl;"> 
                                <table class="display w-100  text-nowrap table-bordered" id="example1" 
                                   style="text-align: center;direction: rtl;">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">
                                                #
                                            </th>
                                            <th class="text-uppercase text-secondary text-md-center font-weight-bolder opacity-7 ps-2">{{__('main.date')}}</th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">{{__('main.bill_no')}}</th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.supplier')}} </th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.total_money')}} </th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.discount')}} </th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.total_tax')}} </th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.paid_money')}} </th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.remain_money')}} </th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.total_weight21')}} </th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.paid_weight21')}} </th>
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.remain_weight21')}} </th>
                                            <th class="text-end text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">{{__('main.actions')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $bill)
                                        <tr>
                                            <td class="text-center">{{$loop -> index + 1}}</td>
                                            <td class="text-center">{{$bill -> date}}</td>
                                            <td class="text-center">{{$bill -> bill_number}}</td>
                                            <td class="text-center">{{$bill -> vendor_name}}</td>
                                            <td class="text-center">{{$bill -> total_money }}</td>
                                            <td class="text-center">{{$bill -> discount }}</td>
                                            <td class="text-center">{{$bill -> tax }}</td>
                                            <td class="text-center">{{$bill -> paid_money}}</td>
                                            <td class="text-center">{{$bill -> remain_money}}</td>
                                            <td class="text-center">{{$bill -> total21_gold}}</td>
                                            <td class="text-center">{{$bill -> paid_gold}}</td>
                                            <td class="text-center">{{$bill -> remain_gold}}</td>
                                            <td class="text-center">
                                            @can('دفتر الشغل')
                                                <a class="btn btn-info editBtn" href="{{route('workEntryPreview' , $bill -> id)}}" role="button">
                                                    <i class="fa fa-eye"></i>{{__('main.preview')}}
                                                </a> 
                                            @endcan 
                                            @can('حذف فاتورة مشتريات')
                                                <button type="button" class="btn btn-labeled btn-danger deleteBtn "
                                                        value="{{$bill -> id}}">
                                                    <span class="btn-label" style="margin-right: 10px;"><i
                                                            class="fa fa-trash"></i></span>{{__('main.delete')}}
                                                </button>
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


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content --> 

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper --> 


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
                        <button type="button" class="btn btn-labeled btn-primary" onclick="confirmDelete()">
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
  
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script> 
 
<script>
    $(document).ready(function () {
        document.title = "{{__('main.enter_work_list')}}";
    });
</script>
 
