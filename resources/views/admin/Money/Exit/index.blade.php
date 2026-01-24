@extends('admin.layouts.master')
@section('content')
@can('عرض سند صرف')   
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
     .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
       color: #ffffff;
       background-color: #E5B80B;
       border-color: #E5B80B;
     }
 
</style> 

<div class="row row-sm">
    <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0" id="head-right" >
                    <div class="col-lg-12 margin-tb">
                        <h4  class="alert alert-primary text-center">
                            {{__('main.money_exit_list')}}
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div>  
                <div class="card-body px-0 pt-0 pb-2">

                    <div class="card shadow mb-4"> 
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display w-100  text-nowrap table-bordered" id="ItemTable" 
                                   style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{__('main.bill_no')}}</th>
                                            <th>{{__('main.date')}}</th> 
                                            <th>{{__('الفرع')}}</th> 
                                            <th> {{__('main.client')}} </th>
                                            <th> {{__('main.paid_money')}} </th>
                                            <th> {{__('main.payment_method')}} </th>
                                            <th> {{__('main.payment_type')}} </th>
                                            <th> {{__('main.based_on')}} </th>
                                            <th>{{__('main.actions')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>  
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/div-->

<div class="show_modal">

</div>


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

          $(document).ready(function () {
            document.title = "{{__('main.money_exit_list')}}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
            var table = $('#ItemTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,

                ajax: "{{ route('money_exit_list') }}",
                columns: [
                    {
                        data: 'id', 
                        name: 'id'
                    },
                    {
                        data: 'doc_number',
                        name: 'doc_number'
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
                        data: 'amount',
                        name: 'amount'
                    }, 
                    {
                        
                        data: 'payment_method',
                        name: 'payment_method',
                        orderable: false,
                        searchable: false 
                    },
                    {
                        
                        data: 'type',
                        name: 'type',
                        orderable: false,
                        searchable: false 
                    },
                    {
                        
                        data: 'based_on',
                        name: 'based_on',
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
                        text: '<a id="createButton" href="javascript:;" class="text-white"><i class="fa fa-plus"></i> </a>',
                    }, 
                    {
                        extend: 'excel',
                        text: '<i title="export to excel" class="fa fa-file-excel"></i> ',
                    }, 
                    {
                        extend: 'print',
                        text: '<i title="print" class="fa fa-print"></i>',
                    },
                    {
                        extend: 'colvis',
                        text: '<i title="column visibility" class="fa fa-eye"></i> ',
                    },  
                ],
               
                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                order: [[0, 'desc']]
            }).buttons().container().appendTo('#ItemTable_wrapper .col-md-6:eq(0)');

            
        });
</script> 

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);

            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image_url").change(function () {
        readURL(this);
    });
</script>

<script type="text/javascript">
    let id = 0;

    $(document).ready(function () { 

        $(document).on('click', '#createButton', function (event) {

            console.log('clicked');
            id = 0;

            @can('اضافة دفتر خروج النقدية')   
                addPayments();
            @endcan 
            
        });

        $(document).on('click', '.preview', function (event) {
            console.log(event.currentTarget.value , event.currentTarget.id);
            viewPayment(event.currentTarget.value , event.currentTarget.id);
        });

        $(document).on('click', '.deleteBtn', function (event) {
            console.log('clicked');
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

        $(document).on('click', '.cancel-modal', function (event) {
            $('#deleteModal').modal("hide");
            id = 0;
        });
        $(document).on('click', '.close-create', function (event) {
            $('#createModal').modal("hide");
            id = 0;
        }); 
    });

    function confirmDelete() {
        let url = "{{ route('exitMoneyDestroy', ':id') }}";
        url = url.replace(':id', id);
        document.location.href = url;
    }

    function addPayments() {
        var route = '{{route('money_exit_create')}}';
        $.get(route, function (data) {
            $(".show_modal").html(data);
            $('#paymentsModal').modal('show');
        });
    }

    function viewPayment(id , type) {
        console.log(id);
        var route = '{{route('exitMoneyPreview', [ ':id' , ':type'])}}';
        route = route.replace(':id', id);
        route = route.replace(':type', type);
        $.get(route, function (data) {
            $(".show_modal").html(data);
            $('#paymentsModal').modal('show');
        });
    } 

</script>
@endsection
 
 