@extends('admin.layouts.master')
@section('content')
@can('عرض جرد')
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
        <!-- row opened -->
        <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0" id="head-right" >
                    <div class="col-lg-12 margin-tb">
                        <h4  class="alert alert-primary text-center">
                           قائمة محاضر الجرد  
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="row mt-1 mb-1 text-center justify-content-center align-content-center"> 
                @can('اضافة جرد')
                <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="{{ route('admin.inventory.create')}}" role="button"  style="border-radius: 10px; margin:5px;">
                    <i style="margin: 5px ; padding: 5px;" class="fas fa-plus-circle fa-sm text-white-50"></i> {{__('main.add_new')}}
                </a> 
                @endcan      
                </div>
                <div class="card-body px-0 pt-0 pb-2">

                    <div class="card shadow mb-4"> 
                        <div class="card-body">
                            <div class="table-responsive hoverable-table">
                                <table class="display w-100  text-nowrap table-bordered" id="example1" 
                                   style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>التاريخ</th>
                                            <th>رقم محضر الجرد</th> 
                                            <th>الفرع</th> 
                                            <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">{{__('main.actions')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($inventorys as $inventory)
                                        <tr>
                                            <td class="text-center">{{$loop -> index + 1}}</td>
                                            <td class="text-center">{{$inventory -> date}}</td>  
                                            <td class="text-center">{{$inventory -> id}}</td>
                                            <td class="text-center">{{$inventory -> branch->branch_name}}</td>
                                            <td class="text-center"> 
                                            @can('عرض جرد')   
                                                <a class="btn btn-info" href="{{ route('inventory.report', $inventory-> id)}}" role="button"><i class="fa fa-print"></i></a>  
                                            @endcan
                                            @can('تعديل جرد')   
                                                <a class="btn btn-warning" href="{{ route('admin.inventory.edit', $inventory-> id)}}" role="button"><i class="fa fa-edit"></i></a>  
                                            @endcan
                                            @can('حذف جرد') 
                                                <a class="btn btn-danger delete_inventory"
                                                   inventory_id="{{$inventory-> id}}" data-toggle="modal"
                                                   href="#modaldemo8">
                                                    <i class="fa fa-trash"></i>
                                                   
                                                </a>
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
     <!--/div-->

     <div class="modal" id="modaldemo8">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Almarai'; ">حذف جرد</h6>
                        <button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form id="dl-form" action="{{ route('admin.inventory.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد انك تريد الحذف ؟</p><br>
                            <input type="hidden" name="inventory_id" id="inventory_id" value="">
                         
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 
<div class="show_modal">

</div>

<div class="barcode_modal">

</div>

@endcan 
@endsection 
@section('js') 
<script type="text/javascript">
    document.title = "قائمة محاضر الجرد";
    $(document).ready(function () { 
        $('.delete_inventory').on('click', function () {
            var inventory_id = $(this).attr('inventory_id'); 
            $('.modal-body #inventory_id').val(inventory_id); 
        }); 
    }); 
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);

            }
            reader.readAsDataURL(input.files[0]);
            document.getElementById('path').innerHTML = input.files[0].name;
        }
    }

    $("#img").change(function () {
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
                    $.ajax({
                        type: 'get',
                        url: 'getItemCode',
                        dataType: 'json',

                        success: function (response) {
                            $('#createModal').modal("show");
                            $(".modal-body #code").val(response);
                            $(".modal-body #name_ar").val("");
                            $(".modal-body #name_en").val("");
                            $(".modal-body #item_type").val(1);
                            $(".modal-body #category_id").val("");
                            $(".modal-body #karat_id").val("");
                            $(".modal-body #weight").val(0);
                            $(".modal-body #no_metal").val(0);
                            $(".modal-body #no_metal_type").val(1);
                            $(".modal-body #tax").val("");
                            $(".modal-body #made_Value").val(0);
                            $(".modal-body #state").val(1);
                            $(".modal-body #id").val(0);

                            setTimeout(() =>{
                                $(".modal-body .type1").slideDown();
                                $(".modal-body .type2").slideUp();
                            } , 500);


                            $(".modal-body #item_type").change(function (){
                                console.log(this.value);
                                if(this.value == 1  ){
                                    $(".modal-body .type1").slideDown();
                                    $(".modal-body .type2").slideUp();
                                    $(".modal-body #weight").prop('readonly', false);
                                    $(".modal-body #made_Value").prop('readonly', false);
                                } else if(this.value == 2){
                                    $(".modal-body .type2").slideDown();
                                    $(".modal-body .type1").slideUp();
                                } else if(this.value == 3){
                                    $(".modal-body .type1").slideDown();
                                    $(".modal-body .type2").slideUp();
                                    $(".modal-body #weight").prop('readonly', true);
                                    $(".modal-body #made_Value").prop('readonly', true);
                                }
                            });

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
                        }
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
                 timeout: 500000
            })
        });

        $(document).on('click', '#submit_modal_btn', function (event){

            const name_ar = document.getElementById('name_ar').value ;
            const category_id = document.getElementById('category_id').value ;
            const karat_id = document.getElementById('karat_id').value ;
            const weight = document.getElementById('weight').value ;
            const made_Value = document.getElementById('made_Value').value ;
            const type = document.getElementById('item_type').value ;

            if(type == 1){
                if(name_ar && category_id && karat_id &&   weight > 0 && made_Value > 0){
                    document.getElementById('modal_form').submit();
                } else {
                    alert($('<div>{{trans('main.fill_data')}}</div>').text());
                }
            } else if(type == 2){
                if(name_ar && category_id ){
                    document.getElementById('modal_form').submit();
                } else {
                    alert($('<div>{{trans('main.fill_data')}}</div>').text());
                }
            }
            else if(type == 3){
                if(name_ar && category_id && karat_id ){
                    document.getElementById('modal_form').submit();
                } else {
                    alert($('<div>{{trans('main.fill_data')}}</div>').text());
                }
            }





        });




        $(document).on('click', '.editBtn', function (event) {

            id = event.currentTarget.value;
            event.preventDefault();
            $.ajax({
                type: 'get',
                url: 'getItem' + '/' + id,
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
                                if (response.img) {
                                    var img = '../images/Items/' + response.img;

                                    $(".modal-body #profile-img-tag").attr('src', img);
                                }

                                $('#createModal').modal("show");
                                $(".modal-body #code").val(response.code);
                                $(".modal-body #name_ar").val(response.name_ar);
                                $(".modal-body #name_en").val(response.name_en);
                                $(".modal-body #item_type").val(response.item_type);
                                $(".modal-body #category_id").val(response.category_id);
                                $(".modal-body #karat_id").val(response.karat_id);
                                $(".modal-body #weight").val(response.weight);
                                $(".modal-body #no_metal").val(response.no_metal);
                                $(".modal-body #no_metal_type").val(response.no_metal_type);
                                $(".modal-body #tax").val(response.tax);
                                $(".modal-body #made_Value").val(response.made_Value);
                                $(".modal-body #state").val(response.state);
                                $(".modal-body #id").val(response.id);

                                if(response.item_type == 1 ){
                                    $(".modal-body .type1").slideDown();
                                    $(".modal-body .type2").slideUp();
                                    $(".modal-body #weight").prop('readonly', false);
                                    $(".modal-body #made_Value").prop('readonly', false);
                                } else if(response.item_type == 3){
                                    $(".modal-body .type1").slideDown();
                                    $(".modal-body .type2").slideUp();
                                    $(".modal-body #weight").prop('readonly', true);
                                    $(".modal-body #made_Value").prop('readonly', true);
                                }

                                else if(response.item_type == 2){
                                    $(".modal-body .type2").slideDown();
                                    $(".modal-body .type1").slideUp();
                                }


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
                             timeout: 500000
                        })
                    } else {

                    }
                }
            });

        });
        $(document).on('click', '.deleteBtn', function (event) {
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
                 timeout: 500000
            })
        });
        $(document).on('click', '.compined', function (event) {
            var route = '{{route('getParentItem',":id")}}';
            var val = event.currentTarget.value;
            route = route.replace(":id",val);

            $.get( route, function( data ) {
                $( ".show_modal" ).html( data );
                $('#compineModal').modal('show');
            });

        });
        $(document).on('click', '.deleteCombineBtn', function (event) {
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
                    $('#compineModal').modal("hide");
                    $('#deleteModal2').modal("show");
                },
                complete: function () {
                    $('#loader').hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                 timeout: 500000
            })
        });



        $(document).on('click' , '.printBTN' , function (event) {
            {{--const id = event.currentTarget.value;--}}
            {{--var route = '{{route('printBarcode',":id")}}';--}}
            {{--route = route.replace(":id", id);--}}

            {{--document.location.href = route ;--}}



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

    function confirmDelete(index) {
        $('.modal-body #inventory_id').val(inventory_id);
        const const name_ar = document.getElementById('name_ar').value ; = document.getElementById('name_ar').value ; 
        if(index == 1){
            url   = "{{ route('deleteItem', ':id') }}";
        } else {
            url = "{{ route('deleteItemMaterial', ':id') }}";
        }

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
                        timeout: 500000
                    })
                } else {

                }
            }
        });
    }
</script> 
@endsection 

