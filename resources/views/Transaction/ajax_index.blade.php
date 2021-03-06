
<?php

if (!$transactions->isEmpty()) {
    ?>

    {{ Form::open(array('url' => 'admin/transaction/list', 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"form-inline form")) }}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Transaction Type List
                </header>
                <div class="panel-body">
                    <section id="no-more-tables">
                        <table class="table table-bordered table-striped table-condensed cf">
                            <thead class="cf">
                                <tr>
                                    <th></th>
                                    <th>@sortablelink('type', 'Transactions Type')</th>
                                    <th>@sortablelink('created', 'Created')</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($transactions as $transaction) {
                                    if ($i % 2 == 0) {
                                        $class = 'colr1';
                                    } else {
                                        $class = '';
                                    }
                                    ?>
                                    <tr>
                                        <td data-title="Select">
                                            {{ Form::checkbox('id', $transaction->id,null, array("onclick"=>"javascript:isAllSelect(this.form);",'name'=>"chkRecordId[]")) }}
                                        </td>
                                        
                                        <td data-title="Transactions Type">
                                            {{ ucwords($transaction->type); }}
                                        </td>
                                        <td data-title="Created">
                                            {{  date("d M, Y h:i A", strtotime($transaction->created)) }}</td>

                                        <td data-title="Action">
                                            <?php
                                            if (!$transaction->status)
                                                echo html_entity_decode(Html::link('admin/transaction/Admin_active/' . $transaction->slug, '<i class="fa fa-check"></i>', array('class' => 'btn btn-danger btn-xs action-list', 'title' => "Activate", 'onclick' => "return confirmAction('activate');")));
                                            else
                                                echo html_entity_decode(Html::link('admin/transaction/Admin_deactive/' . $transaction->slug, '<i class="fa fa-check"></i>', array('class' => 'btn btn-success btn-xs action-list', 'title' => "Deactivate", 'onclick' => "return confirmAction('deactivate');")));

                                            echo html_entity_decode(Html::link('admin/transaction/editType/' . $transaction->slug, '<i class="fa fa-pencil"></i>', array('class' => 'btn btn-primary btn-xs', 'title' => 'Edit')));
                                            ?>
                                        </td>	
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body border-bottom">
                    <div class="dataTables_paginate paging_bootstrap pagination">
                        {{ $transactions->appends(Input::except('page'))->render() }}
                    </div>
                </div>
                <div class="panel-body">
                    <button type="button" name="chkRecordId" onclick="checkAll(true);"  class="btn btn-success">Select All</button>
                    <button type="button" name="chkRecordId" onclick="checkAll(false);" class="btn btn-success">Unselect All</button>
                    <?php
                    $arr = array(
                        "" => "Action for selected...",
                        'Activate' => "Activate",
                        'Deactivate' => "Deactivate",
                    );
                    ?>
                    {{ Form::select('action', $arr, null, array('class'=>"small form-control",'id'=>'action')) }}
                    {{ Form::hidden('search', $search, array('id' => '')) }}

                    <button type="submit" class="small btn btn-success btn-cons" onclick=" return isAnySelect();" id="submit_action">Ok</button>
                </div>
            </section>
        </div>
    </div>
    {{ Form::close() }} 

<?php } else {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Transaction Type Listing
                </header>
                <div class="panel-body">
                    <section id="no-more-tables">No Transaction Type.</section>
                </div>
            </section>
        </div>
    </div>  
<?php }
?>