@extends('admin.layouts.master')
@section('content')
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
                        {{__('main.lost_barcode')}}
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div> 
                <div class="row mt-1 mb-1 text-center justify-content-center align-content-center">   
                        <div class="row"> 
                                <div class="form-group col-md-12">
                                  <label class="form-label">{{__('main.weight')}}</label>
                                   <input class="form-control" id="weight" name="weight" type="number" step="any">
                                </div>
                                @can('عرض صنف') 
                                <div class="form-group col-md-12">  
                                     <button type="button" class="btn btn-labeled btn-primary"  onclick="searchByweight()" style="width: 50%">
                                         {{__('main.search_btn')}}</button>
                                 </div> 
                                 @endcan  
                        </div> 
                </div> 
 
                <div class="card-body px-0 pt-0 pb-2">

                    <div class="card shadow mb-4"> 
                        <div class="card-body">
                            <div class="table-responsive hoverable-table">
                                <table class="display w-100  text-nowrap table-bordered" id="example1" 
                                   style="text-align: center;">
                                    <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">
                                            #
                                        </th>
                                        <th class="text-uppercase text-secondary text-md-center font-weight-bolder opacity-7 ps-2">{{__('main.code')}}</th>
                                        <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">{{__('main.name_ar')}}</th>
                                        <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.name_en')}} </th>
                                        <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.category')}} </th>
                                        <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.karat')}} </th>
                                        <th class="text-center text-uppercase text-secondary text-md-center font-weight-bolder opacity-7"> {{__('main.weight')}} </th>
                                        <th class="text-end text-uppercase text-secondary text-md-center font-weight-bolder opacity-7">{{__('main.actions')}}</th>
                                    </tr>
                                    </thead> 
                                <tbody id="tbody">
                                    
                                </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>
     <!--/div-->









<div class="show_modal">

</div>

<div class="barcode_modal">

</div>
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>

<script type="text/javascript">
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
        $(document).on('click', '.cancel-modal', function (event) {
            $('#deleteModal').modal("hide");
            id = 0;
        });
        $(document).on('click', '.close-create', function (event) {
            $('#createModal').modal("hide");
            id = 0;
        });

    });


    function searchByweight(){
        var weight = 0 ;
        weight = document.getElementById('weight').value ;
        $.ajax({
            type: 'get',
            url: 'lost_barcode_search' + '/' + weight,
            dataType: 'json',

            success: function (response) {
                console.log(response);
                if (response) {


                    $("#tbody").empty();
                    for(let i = 0 ; i < response.length ; i++){
                        var newTr = $('<tr data-item-id="'+response.id+'">');

                        var tr_html = '<td class="text-center">  ' + (i + 1) +'   </td>' ;
                        tr_html += '<td class="text-center">  ' + response[i].code + '   </td>';
                        tr_html += '<td class="text-center">  ' + response[i].name_ar + '   </td>';
                        tr_html += '<td class="text-center">  ' + response[i].name_en + '   </td>';
                        tr_html += '<td class="text-center">  ' + response[i].category_name_ar + '   </td>';
                        tr_html += '<td class="text-center">  ' + response[i].karat_name_ar + '   </td>';
                        tr_html += '<td class="text-center">  ' + response[i].weight + '   </td>';

                        var route = '{{route('printBarcode',":id")}}';
                        route = route.replace(":id",response[i].id);
                        tr_html += `<td>  <a href = ${route}   target="_blank" >
                            <button type="button" class="btn btn-labeled btn-warning printBTN" >
                            <span class="btn-label" style="margin-right: 10px;"><i
                        class="fa fa-barcode" style="margin-left: 5px;
                        margin-right: 5px;"></i></span>{{__('main.print_barcode')}}
                            </button>
                        </a> </td>`;

                        newTr.html(tr_html);
                        newTr.appendTo('#tbody');

                    }



                   } else {

                }
            }
        });
    }

</script>

 
