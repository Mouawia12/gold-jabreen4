
<div class="modal fade" id="movmentModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"  style="min-width: 700px">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close modal-close-btn close-create" data-bs-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody">
                <h3 class="alert alert-primary text-center">القيود المحاسبية</h3>
                <table  id="sTable" class="table items table-striped table-bordered table-condensed table-hover text-center">
                    <thead>
                        <tr>
                            <th>{{__('id')}}</th> 
                            <th>{{__('رقم اليومية')}}</th>
                            <th>{{__('رقم الحساب')}}</th> 
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
                        @foreach($data as $row)
                            <tr>
                               <td>{{$row->id}}</td>
                               <td>{{$row->journal_id}}</td>
                               <td>{{$row->account_id}}</td> 
                                <td>{{$row->name}}[<strong>{{$row->code}}</strong>]</td>
                                <td>{{$row->debit}}</td>
                                <td>{{$row->credit}}</td>
                                <td>{{$row->notes}}</td>
                                <?php
                                   $debit += $row->debit;
                                   $credit += $row->credit;
                                ?>
                            </tr>
                        @endforeach
                        
                            <tr class="bg-primary text-white"> 
                                <td colspan="4">الاجمالي</td>
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
