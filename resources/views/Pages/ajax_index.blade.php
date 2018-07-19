<?php
if (!$pages->isEmpty()) {
    ?>

    {{ Form::open(array('url' => 'admin/page/pagelist', 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"form-inline form")) }}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Pages List<div class="add_page_link pull-right"></div>
                </header>
                
                <div class="panel-body">
                    <section id="no-more-tables">
                        <table class="table table-bordered table-striped table-condensed cf">
                            <thead class="cf">
                                <tr>
<!--                                    <th></th>-->
                                    <th class=" enable-sort" sort_type="" field="tbl_pages.id">Serial Number</th>
                                    <th class=" enable-sort" sort_type="" field="tbl_pages.first_name">Name</th>
                                    <th class="enable-sort" sort_type=""  field="tbl_pages.created">Created</th>
                                    <th class="bjhuh">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($pages as $page) {
                                    if ($i % 2 == 0) {
                                        $class = 'colr1';
                                    } else {
                                        $class = '';
                                    }
                                    ?>
                                    <tr>
<!--                                        <td data-title="Select">
                                            <?php if ($page->category != 'Main') { ?>
                                                {{ Form::checkbox('id', $page->id,null, array("onclick"=>"javascript:isAllSelect(this.form);",'name'=>"chkRecordId[]")) }}
                                            <?php } ?>
                                        </td>-->
                           
                                        <td data-title="Serial No.">
                                           {{$i}}
                                        </td>
                                        <td data-title="Name">
                                            {{ ucwords($page->name); }}
                                        </td>
                                        
                                        <td data-title="Created">
                                            {{  date("d M, Y h:i A", strtotime($page->created)) }}</td>

                                        <td data-title="Action">
                                            <?php
                                             if ($page->category != 'Main') { 
                                                if (!$page->status)
                                                    echo html_entity_decode(Html::link('admin/page/Admin_activepage/' . $page->slug, '<i class="fa fa-check"></i>', array('class' => 'btn btn-danger btn-xs action-list', 'title' => "Active",'onclick'=>"return confirmAction('active');")));
                                                else
                                                    echo html_entity_decode(Html::link('admin/page/Admin_deactivepage/' . $page->slug, '<i class="fa fa-check"></i>', array('class' => 'btn btn-success btn-xs action-list', 'title' => "Deactive",'onclick'=>"return confirmAction('deactivate');")));
                                            }

                                            echo html_entity_decode(Html::link('admin/page/Admin_editpage/' . $page->slug, '<i class="fa fa-pencil"></i>', array('class' => 'btn btn-primary btn-xs', 'title' => 'Edit')));
                                            if ($page->category != 'Main') {
                                                //echo html_entity_decode(Html::link('admin/page/Admin_deletepage/' . $page->slug, '<i class="fa fa-trash-o"></i>', array('title' => 'Delete', 'class' => 'btn btn-danger btn-xs action-list delete-list', 'escape' => false,'onclick'=>"return confirmAction('delete');")));
                                            }
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

    <!--                    Number of pages <span class="badge-gray"> </span> - <span class="badge-gray"> </span> out of <span class="badge-gray"></span>-->

                    <div class="dataTables_paginate paging_bootstrap pagination">
                        {{ $pages->appends(Request::only('search','from_date','to_date'))->render() }}
                    </div>
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
                    pages List
                </header>
                <div class="panel-body">
                    <section id="no-more-tables">There are no page added on site yet.</section>
                </div>
            </section>
        </div>
    </div>  
<?php }
?>