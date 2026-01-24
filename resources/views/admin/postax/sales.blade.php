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
@can('عرض فاتورة ضريبية')  
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0" id="head-right" >
                    <div class="col-lg-12 margin-tb">
                        <h4  class="alert alert-primary text-center">
                         [ {{__('المبيعات الضريبية للشركات والمؤسسات')}} ]
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div> 
                <div class="card-body px-0 pt-0 pb-2">

                    <div class="card shadow mb-4"> 
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display w-100  text-nowrap table-bordered" id="example1" 
                                   style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{__('main.bill_no')}}</th>
                                            <th>{{__('main.date')}}</th> 
                                            <th> {{__('الفرع')}} </th>
                                            <th> {{__('main.client')}} </th>
                                            <th> {{__('الاجمالي')}} </th>
                                            <th> {{__('المبلغ')}} </th> 
                                            <th> {{__('الضريبة')}} </th> 
                                            <th> <strong>{{__('نقد (cash)')}}</strong> </th>
                                            <th> <strong>{{__('شبكة (visa)')}}</strong> </th>
                                            <th> <strong>{{__('ذهب21(جرام)')}}</strong> </th>
                                            <th>{{__('main.actions')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $bill)
                                        <tr>
                                            <td class="text-center">{{$loop -> index + 1}}</td>
                                            <td class="text-center">{{$bill -> bill_number}}</td>
                                            <td class="text-center">{{$bill -> date}}</td> 
                                            <td class="text-center">{{$bill -> branch ->branch_name}}</td> 
                                            <td class="text-center">{{$bill -> vendor_name}}</td>
                                            <td class="text-center">{{$bill -> net_money}}</td>
                                            <td class="text-center">{{$bill -> total_money }}</td>  
                                            <td class="text-center">{{$bill -> tax}}</td> 
                                            <td class="text-center">{{$bill -> cash_amount}}</td> 
                                            <td class="text-center">{{$bill -> visa_amount}}</td> 
                                            <td class="text-center">{{$bill -> total21_gold}}</td> 
                                            <td class="text-center">  
                                                @if($bill -> type == 1)

                                                    @can('عرض فاتورة ضريبية')  
                                                        <a href="{{route('workExitPreviewTax' , $bill -> id)}}" class="btn btn-primary" role="button" data-bs-toggle="button">
                                                           <i class="fa fa-eye"></i>{{__('main.preview')}} 
                                                        </a> 
                                                    @endcan  

                                                    @if($bill -> returned_bill_id == 0 && $bill -> net_money > 0)
                                                        @can(['اضافة مرتجع فاتورة مبيعات','عرض مرتجع فاتورة مبيعات'])
                                                            <a href="{{route('return_work_tax' , $bill -> id)}}" class="btn btn-info" role="button" data-bs-toggle="button">
                                                               <i class="fa fa-retweet" aria-hidden="true"></i> {{__('main.return_bill')}}
                                                            </a>  
                                                        @endcan 
                                                    @endif

                                                @else
                                                    @can('عرض فاتورة ضريبية')  
                                                        <a href="{{route('oldExitTaxPreview' , $bill -> id)}}" class="btn btn-primary" role="button" data-bs-toggle="button">
                                                            <i class="fa fa-eye"></i>{{__('main.preview')}}
                                                        </a>   
                                                    @endcan  

                                                    @if($bill -> returned_bill_id == 0 && $bill -> net_money > 0)
                                                       @can(['اضافة مرتجع فاتورة مبيعات','عرض مرتجع فاتورة مبيعات'])   
                                                        <a href="{{route('return_old_tax' , $bill -> id)}}" class="btn btn-info" role="button" data-bs-toggle="button">
                                                           <i class="fa fa-retweet" aria-hidden="true"></i> {{__('main.return_bill')}}
                                                        </a>   
                                                        @endcan  
                                                    @endif

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
            </div>
            <!-- /.container-fluid --> 
        </div>
        <!-- End of Main Content --> 
    </div>
    <!-- End of Content Wrapper --> 
</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modelTitle"> {{__('main.deleteModal')}}</label>

            </div>
            <div class="modal-body" id="smallBody">
                <img src="../assets/img/warning.png" class="alertImage">
                <label class="alertTitle">{{__('main.delete_alert')}}</label>
                <br> <label class="alertSubTitle" id="modal_table_bill"></label>
                <div class="row">
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-labeled btn-primary" onclick="confirmDelete()">
                            <span class="btn-label" style="margin-right: 10px;"><i
                                    class="fa fa-check"></i></span>
                            {{__('main.confirm_btn')}}
                        </button>
                    </div>
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-labeled btn-secondary cancel-modal">
                            <span class="btn-label" style="margin-right: 10px;"><i
                                class="fa fa-close"></i>
                            </span>{{__('main.cancel_btn')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endcan 
@endsection 
@section('js') 
<script type="text/javascript"> 
    let id = 0;
    document.title = "{{__('main.pos_sales_list')}}"; 
</script> 
@endsection 
 