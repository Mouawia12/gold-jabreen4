@extends('admin.layouts.master')
@section('content')
@can('عرض فاتورة مشتريات')    
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
                           [ {{__('مشتريات ذهب كسر / صافي')}} ] 
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
                                            <th> {{__('نوع الفاتورة')}} </th> 
                                            <th> {{__('المورد / العميل')}} </th>
                                            <th> {{__('main.total_money')}} </th>
                                            <th> {{__('main.total_tax')}} </th>
                                            <th> {{__('main.total_weight21')}} </th> 
                                            <th> {{__('main.paid_weight21')}} </th> 
                                            <th> {{__('main.remain_weight21')}} </th>
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
    
        document.title = "قائمة مشتريات ذهب الكسر ";

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

                ajax: "{{ route('oldEntryAll') }}",
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
                        
                        data: 'bill_type',
                        name: 'bill_type',
                        orderable: false,
                        searchable: false 
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
                        data: 'tax',
                        name: 'tax'
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false 
                    },
                ],
                dom: 'lBfrtip', 
                         
                buttons: [
                    {   
                        text: '@can('اضافة فاتورة مشتريات') <a id="createButton" href="javascript:;" class="text-white"><i class="fa fa-plus"></i> </a>  @endcan ',
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
                window.location = "{{route('oldEntryCreate')}}";
            });
            
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
        id = 0;
        $(document).on('click', '#createButton', function (event) {
            console.log('clicked');
            id = 0;
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function () {
                    $('#loader').show();
                },
                // return the result
                success: function (result) {
                    $('#createModal').modal("show");
                    $(".modal-body #code").val("");
                    $(".modal-body #name_ar").val("");
                    $(".modal-body #name_en").val("");
                    $(".modal-body #item_type").val("");
                    $(".modal-body #category_id").val("");
                    $(".modal-body #karat_id").val("");
                    $(".modal-body #weight").val("");
                    $(".modal-body #no_metal").val("");
                    $(".modal-body #no_metal_type").val("");
                    $(".modal-body #tax").val("");
                    $(".modal-body #made_Value").val("");
                    $(".modal-body #state").val("");
                    $(".modal-body #id").val(0);

                    $(".modal-body #karat_id").change(function (){
                        $.ajax({
                            type: 'get',
                            url: 'getKarat' + '/' + this.value,
                            dataType: 'json',

                            success: function (response) {

                                $(".modal-body #tax").val(response.stamp_value);
                            }
                        });
                    });

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
        let url = "{{ route('oldEntryDelete', ':id') }}";
        url = url.replace(':id', id);
        document.location.href = url;
    }

    function EditModal(id) {
        $.ajax({
            type: 'get',
            url: 'getCategory' + '/' + id,
            dataType: 'json',

            success: function (response) {
                console.log(response);
                if (response) {
                    let href = $(this).attr('data-attr');
                    $.ajax({
                        url: href,
                        beforeSend: function () {
                            $('#loader').show();
                        },
                        // return the result
                        success: function (result) {
                            $('#createModal').modal("show");
                            var img = '../images/Category/' + response.image_url;
                            $(".modal-body #profile-img-tag").attr('src', img);
                            $(".modal-body #name").val(response.name);
                            $(".modal-body #code").val(response.code);
                            $(".modal-body #slug").val(response.slug);
                            $(".modal-body #description").val(response.description);
                            $(".modal-body #parent_id").val(response.parent_id);
                            $(".modal-body #id").val(response.id);
                            $(".modal-body #isGold").prop('checked', response.isGold);
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
                } 
            }
        });
    }
</script>
@endsection
 