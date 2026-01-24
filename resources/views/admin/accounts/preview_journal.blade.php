
<div class="modal fade" id="paymentsModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document"  style="min-width: 700px">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close modal-close-btn close-create" data-bs-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody">
            <h3 class="alert alert-primary text-center">دفتر اليومية</h3>
                <table  id="sTable" class="table items table-striped table-bordered table-condensed table-hover text-center">
                    <thead>
                        <tr>
                            <th>{{__('رقم اليومية')}}</th>
                            <th>{{__('main.code')}}</th>
                            <th>{{__('main.name')}}</th>
                            <th>{{__('main.Debit')}}</th>
                            <th>{{__('main.Credit')}}</th>
                            <th class="col-md-3">{{__('main.notes')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                       <?php
                          $debit = 0;
                          $credit = 0;
                       ?> 
                        @foreach($payments as $payment)
                            <tr>
                               <td>{{$payment->journal_id}}</td>
                                <td>{{$payment->code}}</td>
                                <td>@if($payment->ledger_name <> '') {{ $payment->ledger_name }} @else {{$payment->name}}  @endif</td>
                                <td>{{$payment->debit}}</td>
                                <td>{{$payment->credit}}</td>
                                <td>{{$payment->notes}}</td>
                                <?php
                                   $debit += $payment->debit;
                                   $credit += $payment->credit;
                                ?>

                            </tr>
                        @endforeach 
                           <tr class="bg-primary text-white"> 
                                <td colspan="3">الاجمالي</td>
                                <td>{{$debit}}</td>
                                <td>{{$credit}}</td>
                                <td></td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
