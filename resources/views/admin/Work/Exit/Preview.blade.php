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
                        {{__('main.work_exit_preview')}}
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div> 

                <div class="card-body px-0 pt-0 pb-2">
                   <div class="row">
                       <div class="card shadow mb-4 col-9">
                           <div class="card-header py-3"> 
                            <a href="{{route('workExitPrint' , $bill -> id)}}" class="btn btn-info" role="button" data-bs-toggle="button">
                               Print
                            </a> 

                           </div>
                           <div class="card-body">


                               <div class="row">
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label>{{ __('main.client') }} <span
                                                   style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                           <input type="text" readonly name="client_id" id="client_id" class="form-control"
                                           value="{{$bill ->  vendor_name ? $bill ->  vendor_name : 'لقد قمت بحذف العميل'}}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label>{{ __('main.date') }} <span
                                                   style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                           <input type="datetime-local" id="date" name="date"
                                                  class="form-control" disabled value="{{$bill -> date}}"
                                           />
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label>{{ __('main.bill_no') }} <span
                                                   style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                           <input type="text" id="bill_number" name="bill_number"
                                                  class="form-control" placeholder="bill_no" readonly value="{{$bill -> bill_number}}"
                                           />
                                       </div>
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-12">
                                       <div class="form-group">
                                           <label>{{ __('main.notes') }} <span
                                                   style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                           <textarea name="notes" id="notes" rows="3" placeholder="{{ __('main.notes') }}"
                                                     class="form-control-lg" style="width: 100%" readonly></textarea>
                                       </div>
                                   </div>
                               </div>



                               <div class="row">
                                   <div class="col-md-12">
                                       <div class="control-group table-group">
                                           <label class="table-label">{{__('main.items')}} </label>

                                           <div class="controls table-controls">
                                               <table id="sTable"
                                                      class="table items table-striped table-bordered table-condensed table-hover">
                                                   <thead>
                                                   <tr>
                                                       <th hidden>id</th>
                                                       <th class="text-center">{{__('main.item')}}</th>
                                                       <th class="text-center">{{__('main.karat')}}</th>
                                                       <th class="text-center">{{__('main.weight')}}</th>
                                                       <th class="text-center">{{__('main.price_gram')}} </th>
                                                       <th class="text-center">{{__('main.total_money')}}</th>
                                                       <th class="text-center">{{__('main.total_tax')}}</th>
                                                       <th class="text-center">{{__('main.total_with_tax')}}</th>

                                                   </tr>
                                                   </thead>
                                                   <tbody id="tbody">
                                                   @foreach($details as $detail)
                                                       <tr>
                                                           <td class="text-center"> {{Config::get('app.locale') == 'ar' ? $detail -> item_ar : $detail -> item_en}} </td>
                                                           <td class="text-center"> {{Config::get('app.locale') == 'ar' ? $detail -> karat_ar : $detail -> karat_en}} </td>
                                                           <td class="text-center"> {{$detail -> weight}} </td>
                                                           <td class="text-center" > {{$detail -> gram_price}} </td>
                                                           <td class="text-center" > {{$detail -> net_money - $detail -> gram_tax}} </td>
                                                           <td class="text-center"> {{$detail -> gram_tax}} </td>
                                                           <td class="text-center"> {{$detail -> net_money}} </td>
                                                       </tr>
                                                   @endforeach


                                                   </tbody>

                                               </table>
                                           </div>
                                       </div>
                                   </div>
                               </div>



                           </div>
                       </div>
                       <div class="card shadow mb-4 col-3">
                           <div class="card-header py-3">
                               <h6 class="m-0 font-weight-bold text-primary">{{__('main.totals')}}</h6>
                           </div>
                           <div class="card-body">
                               <div class="row" style="align-items: center; margin-bottom: 10px;">
                                   <div class="col-6">
                                       <label
                                           style="text-align: right;float: right;"> {{__('main.items_count')}} </label>
                                   </div>
                                   <div class="col-6">
                                       <?php $sum_count = 0 ?>
                                       <?php $sum_weight = 0 ?>
                                       <?php $sum_weight21 = 0 ?>
                                       <?php $sum_total = 0 ?>
                                       <?php $sum_tax = 0 ?>
                                       <?php $sum_made = 0 ?>

                                       @foreach($details as $item)
                                               <?php $sum_count += 1 ?>
                                               <?php $sum_weight += $item -> weight ?>
                                           <?php $sum_weight21 += $item -> weight * $item -> transform_factor ?>
                                           <?php $sum_total += $item -> weight * $item -> gram_price ?>
                                               <?php $sum_tax += $item -> weight * $item -> gram_tax ?>
                                               <?php $sum_made += $item -> weight * $item -> gram_manufacture ?>


                                           @endforeach

                                       <input type="text" readonly class="form-control" id="items_count" name="items_count" value="{{$sum_count}}">
                                   </div>
                               </div>
                               <div class="row" style="align-items: center; margin-bottom: 10px;">
                                   <div class="col-6">
                                       <label
                                           style="text-align: right;float: right;"> {{__('main.total_actual_weight')}} </label>
                                   </div>
                                   <div class="col-6">
                                       <input type="text" readonly class="form-control"
                                              id="total_actual_weight" value="{{$sum_weight}}">
                                   </div>
                               </div>
                               <div class="row" style="align-items: center; margin-bottom: 10px;">
                                   <div class="col-6">
                                       <label
                                           style="text-align: right;float: right;"> {{__('main.total_weight21')}} </label>
                                   </div>
                                   <div class="col-6">
                                       <input type="text" readonly class="form-control"
                                              id="total_weight21" name="total_weight21" value="{{$sum_weight21}}">
                                   </div>
                               </div>

                               <div class="row" style="align-items: center; margin-bottom: 10px;">
                                   <div class="col-6">
                                       <label
                                           style="text-align: right;float: right;"> {{__('main.first_total')}} </label>
                                   </div>
                                   <div class="col-6">
                                       <input type="text" readonly class="form-control" id="first_total" name="first_total" value="{{$sum_total}}">
                                   </div>
                               </div>
                               <div class="row" style="align-items: center; margin-bottom: 10px;">
                                   <div class="col-6">
                                       <label
                                           style="text-align: right;float: right;"> //{{__('main.made_Value_t')}} </label>
                                   </div>
                                   <div class="col-6">
                                       <input type="text" readonly class="form-control" id="made_Value_t" name="made_Value_t" value="{{$sum_made}}">
                                   </div>
                               </div>
                               <div class="row" style="align-items: center; margin-bottom: 10px;">
                                   <div class="col-6">
                                       <label
                                           style="text-align: right;float: right;"> {{__('main.taxgold')}} </label>
                                   </div>
                                   <div class="col-6">
                                       <input type="text" readonly class="form-control" id="tax_total" name="tax_total" value="{{$sum_tax}}">
                                   </div>
                               </div>

                               <div class="row" style="align-items: center; margin-bottom: 10px;">
                                   <div class="col-6">
                                       <label
                                           style="text-align: right;float: right;"> {{__('main.additional_tax')}} </label>
                                   </div>
                                   <div class="col-6">
                                       <input type="text" readonly class="form-control" id="tax" name="tax" value="{{$bill -> tax}}">
                                   </div>
                               </div>


                               <div class="row" style="align-items: center; margin-bottom: 10px;">
                                   <div class="col-6">
                                       <label style="text-align: right;float: right;"
                                       > {{__('main.net')}} </label>
                                   </div>
                                   <div class="col-6">
                                       <input type="text" readonly class="form-control"  id="net_sales" name="net_sales" value="{{$bill -> total_money}}">
                                   </div>
                               </div>
                               <hr class="sidebar-divider d-none d-md-block">
                               <div class="row" style="align-items: baseline; margin-bottom: 10px;">
                                   <div class="col-6">
                                       <div class="form-group">
                                           <label
                                               style="text-align: right;float: right;"> {{__('main.discount')}} </label>
                                           <input type="number" step="any" readonly class="form-control" id="discount" name="discount" value="{{$bill -> discount}}">
                                       </div>
                                   </div>
                                   <div class="col-6">
                                       <div class="form-group">
                                           <label
                                               style="text-align: right;float: right;"> {{__('main.net_after_discount')}} </label>
                                           <input type="text" readonly  class="form-control" id="net_after_discount" name="net_after_discount" value="{{$bill -> net_money}}">
                                       </div>
                                   </div>
                               </div>

                               <hr class="sidebar-divider d-none d-md-block"> 

                           </div>
                       </div>
                   </div> 
                </div> 

            </div>
            <!-- /.container-fluid -->
            <input id="local" value="{{Config::get('app.locale')}}" hidden>
        </div>
        <!-- End of Main Content --> 
    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>

<script>


    $(document).ready(function () {
      //  printPage();

    });

    function printPage(){
        var css = '@page { size: landscape; }',
            head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');

        style.type = 'text/css';
        style.media = 'print';

        if (style.styleSheet){
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }

        head.appendChild(style);

        window.print();
    }

</script>
 
