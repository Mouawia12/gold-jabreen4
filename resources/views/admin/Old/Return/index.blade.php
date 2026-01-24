@extends('admin.layouts.master')
@section('content')
    @if (session('success'))
        <div class="alert alert-success  fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
  
    @can('عرض مردود مشتريات')
 
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0"  id="head-right" >
                        <div class="col-lg-12 margin-tb">
                            <h4  class="alert alert-primary text-center">
                                {{ __('مردود مشتريات ذهب كسر / صافي')}}
                            </h4>
                        </div> 
                    </div>  
                    <div class="card-body">
                        <div class="table-responsive hoverable-table">
                            <table class="display w-100 text-center table-bordered" id="example1"> 
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('main.bill_no')}}</th>
                                        <th>{{__('main.date')}}</th> 
                                        <th> {{__('الفرع')}} </th>
                                        <th> {{__('main.supplier')}} </th>
                                        <th> {{__('قيمة الفاتورة')}} </th>
                                        <th> {{__('المبلغ')}} </th> 
                                        <th> {{__('main.total_tax')}} </th> 
                                        <th> {{__('main.total_weight21')}} </th>  
                                        <th>{{__('main.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $process)
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{$process->bill_number}}</td>
                                        <td>{{\Carbon\Carbon::parse($process->date)}}</td> 
                                        <td>{{$process->branch->branch_name}}</td> 
                                        <td>{{$process->supplier->name}}</td>
                                        <td>{{$process->net_money * -1}}</td>
                                        <td>{{$process->total_money * -1}}</td>  
                                        <td>{{$process->tax * -1}}</td>
                                        <td>{{$process->total21_gold * -1}}</td> 
                                        <td></td> 
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



<div class="show_modal">

</div>
 
@endcan 
@endsection 
@section('js')
<script type="text/javascript">  
    $(document).ready(function() { 
        document.title = " {{ __('main.purchase.return')}}";
    });

     
</script>
@endsection 
