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
@can('عرض فاتورة مشتريات')   
    <div class="row row-sm"> 
        <div class="card col-12">
                <div class="card-header pb-0" id="head-right" >
                    <div class="col-lg-12 margin-tb">
                        <h4  class="alert alert-primary text-center">
                          [ مشتريات - الذهب المشغول ]  
                        </h4>
                    </div> 
                    <div class="clearfix"></div>
                </div>     
            <div class="card-body px-0 pt-0 pb-2"> 
                    <div class="card shadow mb-4"> 
                        <div class="card-body">
                            <div class="table-responsive hoverable-table" style="direction: rtl;"> 
                                <table class="display w-100  text-nowrap table-bordered" id="ItemTable" 
                                   style="text-align: center;direction: rtl;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{__('main.bill_no')}}</th>
                                            <th>{{__('main.date')}}</th> 
                                            <th>{{__('الفرع')}}</th> 
                                            <th> {{__('main.supplier')}} </th> 
                                            <th> {{__('قيمة الفاتورة')}} </th>
                                            <th> {{__('النقدية')}} </th>
                                            <th> {{__('اجور التصنيع')}} </th> 
                                            <th> {{__('main.total_tax')}} </th>
                                            <th> {{__('main.paid_money')}} </th>
                                            <th> {{__('main.remain_money')}} </th>
                                            <th> {{__('main.total_weight21')}} </th>
                                            <th> {{__('main.paid_weight21')}} </th>
                                            <th> {{__('main.remain_weight21')}} </th>
                                            <th> {{__('نوع الفاتورة')}} </th>
                                            <th>{{__('main.actions')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>   
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
  
@endcan 
@endsection 
@section('js') 
<script type="text/javascript">

           document.title = "قائمة المشتريات الضريبية ";

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

                ajax: "{{ route('workEntryAll') }}",
                columns: [
                    {
                        data: 'id', 
                        name: 'id'
                    },
                    {
                        data: 'bill_number',
                        name: 'bill_number'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'branch_name',
                        name: 'branch_name'
                    },
                    {
                        data: 'vendor_name',
                        name: 'vendor_name'
                    },
                    {
                        data: 'net_money',
                        name: 'net_money'
                    }, 
                    {
                        data: 'total_money',
                        name: 'total_money'
                    },
                    {
                        data: 'made_total',
                        name: 'made_total'
                    }, 
                    {
                        data: 'tax',
                        name: 'tax'
                    }, 
                    {
                        data: 'paid_money',
                        name: 'paid_money'
                    }, 
                    {
                        data: 'remain_money',
                        name: 'remain_money'
                    }, 
                    {
                        data: 'total21_gold',
                        name: 'total21_gold'
                    }, 
                    {
                        data: 'paid_gold',
                        name: 'paid_gold'
                    }, 
                    {
                        data: 'remain_gold',
                        name: 'remain_gold'
                    },  
                    {
                        
                        data: 'bill_type',
                        name: 'bill_type',
                        orderable: false,
                        searchable: false 
                    },  
                    {
                        
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false 
                    },
                ], 

                dom: 'lBfrtip',
                
                buttons: [
                    {    
                        "text": `@can('اضافة امر توريد') <a id="createButton" href="javascript:;" class="text-white"><i class="fa fa-plus"></i></a>  @endcan`,
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

            $(document).on('click', '#createButton', function (event) {  
                window.location = "{{ route('workEntryCreate') }}";
            });

        });
</script> 
 
@endsection
 
