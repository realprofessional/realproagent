<?php
if (!$categories->isEmpty()) {
    ?>
    {{ Form::open(array('url' => 'user/categories/admin_index', 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"form-inline form")) }}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Categories List
                </header>
                <div class="panel-body">
                    <section id="no-more-tables">
                        <table class="table table-bordered table-striped table-condensed cf">
                            <thead class="cf">
                                <tr>
                                    <th></th>
                                    <th>@sortablelink ('name',"Name")</th>
                                    <th>@sortablelink ('created',"Created")</th>
                                    <th class="bjhuh">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($categories as $category) {
                                    if ($i % 2 == 0) {
                                        $class = 'colr1';
                                    } else {
                                        $class = '';
                                    }
                                    ?>
                                    <tr>
                                        <td data-title="Select">
                                            {{ Form::checkbox('id', $category->id,null, array("onclick"=>"javascript:isAllSelect(this.form);",'name'=>"chkRecordId[]")) }}
                                        </td>
                                        <td data-title="Name">
                                            {{ ucwords($category->name); }}
                                        </td>

                                        <td data-title="Created">
                                            {{  date("d M, Y h:i A", strtotime($category->created)) }}</td>

                                        <td data-title="Action">
                                            <?php
                                            if (!$category->status)
                                                echo html_entity_decode(Html::link('user/categories/Admin_activecategory/' . $category->slug, '<i class="fa fa-check"></i>', array('class' => 'btn btn-success btn-xs action-list', 'title' => "Active", 'onclick' => "return confirmAction('active');")));
                                            else
                                                echo html_entity_decode(Html::link('user/categories/Admin_deactivecategory/' . $category->slug, '<i class="fa fa-check"></i>', array('class' => 'btn btn-danger btn-xs action-list', 'title' => "Deactive", 'onclick' => "return confirmAction('deactive');")));

                                            echo html_entity_decode(Html::link('user/categories/Admin_editcategory/' . $category->slug, '<i class="fa fa-pencil"></i>', array('class' => 'btn btn-primary btn-xs', 'title' => 'Edit')));
                                            echo html_entity_decode(Html::link('user/categories/Admin_deletecategory/' . $category->slug, '<i class="fa fa-trash-o"></i>', array('title' => 'Delete', 'class' => 'btn btn-danger btn-xs action-list delete-list', 'escape' => false, 'onclick' => "return confirmAction('delete');")));
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

        <!--                    Number of cuisines <span class="badge-gray"> </span> - <span class="badge-gray"> </span> out of <span class="badge-gray"></span>-->

                    <div class="dataTables_paginate paging_bootstrap pagination">
                        {{ $categories->appends(Request::only('search','from_date','to_date'))->render() }}
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
                        'Delete' => "Delete",
                    );
                    //  echo form_dropdown("action", $arr, '', "class='small form-control' id='table-action'");
                    ?>
                    {{ Form::select('action', $arr, null, array('class'=>"small form-control",'id'=>'action')) }}

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
                    Category List
                </header>
                <div class="panel-body">
                    <section id="no-more-tables">There are no categories added on site yet.</section>
                </div>
            </section>
        </div>
    </div>  
<?php }
?>