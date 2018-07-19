<?php //dd($taskDetail);              ?>

<style>
    .content{width: 100% !important; padding: 0px !important;    display: inherit !important;}   
    .popup, #facebox .content{background:#edeff0}
</style>
<script>
    
    var id = <?php echo $taskDetail->id ?>;
    $(function() {
        var date=new Date();
        $("#due_date_title"+id).datepicker({
            //defaultDate: "+1w",
            changeMonth: true,
            format: 'dd-mm-yyyy',
            numberOfMonths: 1,
            minDate: 'dd-mm-yyyy',
            //maxDate: new Date(),
            changeYear: true
        });
                
        $("#due_date_tm"+id).timepicker();
    });
    
</script>



<div class="text_filedpop_up"> 
    <div class="left_sction">

        <div class="pop_up_task_name">
            <i class="fa fa-credit-card" aria-hidden="true"></i>
            <label> <?php echo $taskDetail->task_name; ?></label>
        </div>
        <div class="pop_up_board_detail">
            in Board: <?php echo $taskDetail->board_name; ?> 
        </div>


        <?php
        $ttxt = "";
        if (!empty($taskDetail->due_date)) {
            $due_date_text = date("M d \a\\t H:i A", strtotime($taskDetail->due_date));
            if (!empty($due_date_text)) {
                $ttxt = "<div class='due-dttt'> <span class='due_head'>Due Date </span>
                <span class='due-date_text'>" . $due_date_text . "</span>
              </div>";
            }
        }
        ?>
        <div id="due_dt_pp">
            <?php echo $ttxt; ?>
        </div>


        <div class="before_show_pop_up_task_desc"  onclick="showUpdateDescription();">
            <i class="fa fa-list" aria-hidden="true"></i>
            Edit the description
        </div>
        <div class="pop_up_task_desc">

            <div class="after_show_pop_up_task_desc" style="display: none">
                {{ Form::open(array('id' => 'updatetask'.$taskDetail->id, 'files' => true,'class'=>" pop_form")) }}
                <div class="textareaa">
                    {{ Form::textarea('task_description', $taskDetail->task_description,  array('rows'=> '2', 'class' => 'required form-control noSpace',  "placeholder"=>"Task Description", "id"=> "update_task_descc".$taskDetail->id)) }}
                    <input type="hidden" id="" name="task_id" value="<?php echo $taskDetail->id ?>" >
                    <div class="pop_bnt">
                        <input type="button" class="btn btn-primary" name="comment" id="task_description<?php echo $taskDetail->id ?>" value="Save" onclick="updateTaskDescriptionData(<?php echo $taskDetail->id ?>);"/>
                        <button type="button" onclick="hideUpdateDescription();" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                    </div>
                </div>

                {{ Form::close() }}
            </div>

            <?php $checkBoxesLists = DB::table('adminchecklists')->where('task_id', $taskDetail->id)->orderBy('adminchecklists.id', 'ASC')->get(); ?>



            <div id="checklist_sectionn" class="checklist_section_main">
                <?php
                if ($checkBoxesLists) {
                    foreach ($checkBoxesLists as $checkBoxesList) {
                        $percentage = 0;
                        ?>
                        <div id="main-check-sectionb-ppp{{ $checkBoxesList->id }}">
                            <div class="check-list-first-section">
                                <div class="check-list-first-section-inner">
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                    {{ $checkBoxesList->checkbox_title  }}
                                </div>
                                <div class="check-list-first-section-inner-two">
                                    <a href="javascript:void(0)"  onclick="deleteTaskCheckboxSection({{ $checkBoxesList->id }}, '{{ $checkBoxesList->slug }} ');"> Delete </a>
                                </div>
                            </div>

                            <?php $checkBoxesValueLists = DB::table('adminchecklistvalues')->where('checklist_id', $checkBoxesList->id)->orderBy('adminchecklistvalues.id', 'ASC')->get(); ?>

                            <?php
                            if ($checkBoxesValueLists) {
                                $checked = 0;
                                $unchecked = 0;
                                $total = 0;
                                foreach ($checkBoxesValueLists as $checkBoxListValueData) {
                                    if ($checkBoxListValueData->is_checked == 0) {
                                        ++$unchecked;
                                    } else {
                                        ++$checked;
                                    }
                                    ++$total;
                                }

                                $finalPercent = ($checked / $total) * 100;
                                $percentage = round($finalPercent);
                            } else {
                                $percentage = 0;
                            }
                            ?>

                            <div class="check-first-second-section">
                                <span class="checkbox-perr" id="checkbox-perr-val{{ $checkBoxesList->id }}"> {{ $percentage }}% </span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $percentage }}" 
                                         aria-valuemin="0" aria-valuemax="100" style="width:{{ $percentage }}%" id="checkbox-perr-valinbar{{ $checkBoxesList->id }}">
                                    </div>
                                </div>
                            </div>
                            <?php $checkBoxesValueLists = DB::table('adminchecklistvalues')->where('checklist_id', $checkBoxesList->id)->orderBy('adminchecklistvalues.id', 'ASC')->get(); ?>

                            <div class="check-first-third-section">
                                <div id="update-section-checbox-value-info{{ $checkBoxesList->id }}">
                                    <?php
                                    if ($checkBoxesValueLists) {
                                        foreach ($checkBoxesValueLists as $checkBoxesValueList) {
                                            $varVal = $checkBoxesValueList->is_checked == 0 ? null : true;
                                            ?>

                                            {{ Form::open(array('id' => 'checkboxTick'.$checkBoxesValueList->id, 'files' => true,'class'=>"")) }}
                                            {{Form::checkbox('is_checked', '1', $varVal, array('class'=>'required checkbox_clss','id'=>'checkbox_idd_ppup'.$checkBoxesValueList->id,'onchange'=>"submitChecboxValueData($checkBoxesValueList->id);"))}}
                                            <input type="hidden" id="" name="checked_by" value="0" >
                                            <input type="hidden" id="" name="checboxvalue_id" value="{{ $checkBoxesValueList->id }}" >
                                            <input type="hidden" name="checkbox_fr_bar" id="checkbox_fr_bar{{ $checkBoxesValueList->id }}" value="{{ $checkBoxesValueList->checklist_id }}" >
                                            {{ $checkBoxesValueList->checkbox_value  }}   
                                            {{ Form::close() }}

                                            <?php
                                        }
                                    } else {
                                        $percentage = 0;
                                    }
                                    ?>
                                </div>

                                <div class="add_an_item_ppup" id="task_checkbox_additem_ppup{{ $checkBoxesList->id }}">
                                    <a href="javascript:void(0)"  onclick="showTaskCheckboxvalueSection({{ $checkBoxesList->id }});">
                                        Add an item
                                    </a>
                                </div>

                                <div class="add_an_item_ppup_form_dt" id="task_checkbox_valuee_form_ppup{{ $checkBoxesList->id }}" style="display:none">
                                    {{ Form::open(array('id' => 'addcheckboxitem'.$checkBoxesList->id, 'files' => true,'class'=>"")) }}
                                    {{ Form::textarea('checkbox_value', Input::old('checkbox_value'),   array('rows'=> '2', 'class' => 'required form-control noSpace',  "placeholder"=>"Checkbox Value", "id"=> "add_checkbox_value".$checkBoxesList->id)) }}
                                    <input type="hidden" id="" name="task_id" value="<?php echo $checkBoxesList->task_id ?>" >
                                    <input type="hidden" id="" name="board_id" value="<?php echo $checkBoxesList->board_id ?>" >
                                    <input type="hidden" id="" name="checklist_id" value="<?php echo $checkBoxesList->id ?>" >
                                    <input type="button" class="btn btn-primary" name="comment" id="submit_checkbox<?php echo $checkBoxesList->id ?>" value="Add" onclick="addTaskChecklistValue(<?php echo $checkBoxesList->id ?>);"/>
                                    <button type="button" onclick="hideTaskCheckboxvalueSection(<?php echo $checkBoxesList->id ?>);" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    {{ Form::close() }}
                                </div>         
                            </div>
                        </div>

                        <?php
                    }
                }
                ?>

            </div>










        </div>




        <div class="col-xs-3"></div>
    </div>

    <div class="right_sction">
        <div class="right_sction_add_section">
            Add
            <div class="new_link_on_popupp">
                <ul>
                    <li>
                        <a href="javascript:void(0)"  onclick="showTaskCheckboxSection({{ $taskDetail->id }});">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i> Checklist 
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0)"  onclick="showTaskDueDateSection({{ $taskDetail->id }});">
                            <i class="fa fa-clock-o" aria-hidden="true"></i> Due Date 
                        </a>

                    </li>
                </ul>


                <div class="checklist_taskk_show " id="checklist_taskk_show{{ $taskDetail->id }}" style="display:none">
                    <div class="copy_heading_task">
                        <div class="copy_heading_task_one">Add Checklist</div>
                        <div class="copy_heading_task_two"><button type="button" onclick="hideTaskCheckboxSection({{ $taskDetail->id }});" class="close_new" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                    </div>
                    <div class="copy_content_task" id="checklist_taskk_content_show{{ $taskDetail->id }}">
                        <div class="loaderr">{{ Html::image('public/img/loading.gif','search',array('class'=>"")) }}</div> 
                        <!--                                                        <div class="textarea">
                                                                                    <label>Title</label>
                                                                                    <textarea></textarea>
                                                                                    
                                                                                </div>-->
                        {{ Form::open(array('id' => 'addtaskchecklist'.$taskDetail->id, 'files' => true,'class'=>"")) }}
                        <div class="copy_text">Title </div>
                        <div class="selectt" id="checklist_task_board_section{{$taskDetail->id}}">
                            {{ Form::text('checkbox_title', '', array('class' => 'required form-control noSpace','id'=>'checkbox_title'.$taskDetail->id, "placeholder"=>"Checkbox Title")) }}
                        </div>

                        <input type="hidden" id="" name="task_id" value="<?php echo $taskDetail->id ?>" >
                        <input type="hidden" id="" name="board_id" value="<?php echo $taskDetail->board_id ?>" >

                        <div class="submit_new_btn">
                            <input type="button" class="submit_new" name="add_checklist" id="add_checklist<?php echo $taskDetail->id ?>" value="Add" onclick="addTaskChecklist(<?php echo $taskDetail->id ?>);"/>
                        </div> 
                        {{ Form::close() }}
                    </div>

                </div>

                <?php
                if (!empty($taskDetail->due_date)) {
                    $dtt = date("m/d/Y", strtotime($taskDetail->due_date));
                    $tim = date("g:ia", strtotime($taskDetail->due_date));
                } else {
                    $dtt = date("m/d/Y");
                    $tim = "12:00pm";
                }
                ?>

                <div class="duedate_taskk_show " id="duedate_taskk_show{{ $taskDetail->id }}" style="display:none">
                    <div class="copy_heading_task">
                        <div class="copy_heading_task_one">Add Due Date</div>
                        <div class="copy_heading_task_two"><button type="button" onclick="hideTaskDueDateSection({{ $taskDetail->id }});" class="close_new" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                    </div>
                    <div class="copy_content_task" id="duedate_taskk_content_show{{ $taskDetail->id }}">
                        <div class="loaderr">{{ Html::image('public/img/loading.gif','search',array('class'=>"")) }}</div> 
                        <!--                                                        <div class="textarea">
                                                                                    <label>Title</label>
                                                                                    <textarea></textarea>
                                                                                    
                                                                                </div>-->
                        {{ Form::open(array('id' => 'addtaskduedate'.$taskDetail->id, 'files' => true,'class'=>"")) }}
                        <div class="copy_text">Title </div>
                        <div class="selectt" id="duedate_task_board_section{{$taskDetail->id}}">
                            {{ Form::text('due_date_dt', $dtt , array('class' => 'required form-control noSpace', 'readonly' => 'readonly',  'id'=>'due_date_title'.$taskDetail->id, "placeholder"=>"Select Date")) }}
                            {{ Form::text('due_date_tm', $tim , array('class' => 'required form-control noSpace', 'id'=>'due_date_tm'.$taskDetail->id, "placeholder"=>"Select Time")) }}
                        </div>
                        <div id="datetimepicker12"></div>

                        <input type="hidden" id="" name="task_id" value="<?php echo $taskDetail->id ?>" >
                        <input type="hidden" id="" name="board_id" value="<?php echo $taskDetail->board_id ?>" >

                        <div class="submit_new_btn">
                            <input type="button" class="submit_new" name="add_duedate" id="add_duedate<?php echo $taskDetail->id ?>" value="Add" onclick="addTaskDueDate(<?php echo $taskDetail->id ?>);"/>
                            <input type="button" class="submit_new submit_new_remove" name="remove_duedate" id="remove_duedate<?php echo $taskDetail->id ?>" value="Remove" onclick="removeTaskDueDate(<?php echo $taskDetail->id ?>);"/>
                        </div> 
                        {{ Form::close() }}
                    </div>

                </div>


            </div>
        </div>
    </div>





    <!--        <h2 class="add-board-form-title">Add New Board</h2>
            {{ Form::open(array('url' => 'admin/projects/board', 'method' => 'post', 'id' => 'add_board_form', 'files' => true,'class'=>"active")) }}
            <input type="hidden" id="" name="project_id" value="<?php //echo $project->id                             ?>" >
            <div class="form-group">
                <label for="add_board_name">Add Board Name</label>
                {{ Form::text('board_name', Input::old('board_name'),   array('class' => 'required form-control noSpace',"placeholder"=>"Board Name", "id"=> "add_board_name")) }}
            </div>
            <button type="submit" class="btn btn-primary">Add Board</button>
            {{ Form::close() }}-->

</div>


<script>
    function showUpdateDescription() {
        $('.after_show_pop_up_task_desc').show();
        $('.before_show_pop_up_task_desc').hide();
    }
    
    function hideUpdateDescription() {
        $('.after_show_pop_up_task_desc').hide();
        $('.before_show_pop_up_task_desc').show();
    }
        
        
    function updateTaskDescriptionData(id) {
        if ($.trim($('#update_task_descc' + id).val()) == '') {
            hideUpdateDescription();
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>adminboards/updateAdminTaskDescriptionData/',
                data: $('#updatetask' + id).serialize(),
                beforeSend: function () {
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    hideUpdateDescription();
                }
            });
        }
    }
        
        
        
    function showTaskCheckboxSection(id) {
        //$( "#task_li_section"+id ).wrap( "<div class='new_li_parent'></div>" );
        $('.checklist_taskk_show').hide();
        $('.duedate_taskk_show').hide();
        $('#checklist_taskk_show'+id).show();
    }

    function hideTaskCheckboxSection(id) {
        $('#checklist_taskk_show'+id).hide();
    }
        
        
    function addTaskChecklist(id) {
        if ($.trim($('#checkbox_title' + id).val()) == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("Please fill checkbox title before submitting.");
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>adminboards/addTaskChecklist/',
                data: $('#addtaskchecklist' + id).serialize(),
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    hideTaskCheckboxSection(id);
                    $('html, body').css("cursor", "auto");
                    $("#checkbox_title"+id).val("");
                    $("#checklist_sectionn").append(result);
                        
                    //alert(result);
                    
                    //                    $('html, body').css("cursor", "auto");
                    //                    var valll = $('#boardd_id' + id).val();
                    //                    $('.copy_taskk_show').hide();
                    //                    $('.edit_show').hide();
                    //                    $('#projectt_id' + id).val('');
                    //                    $('#boardd_id' + id).empty();
                    //                    //$('#boardd_id' + id).val('');
                    //                    $('#position' + id).empty('');
                    //                    //$('#position' + id).val('');
                    //                    $("#board_"+valll).html(result);
                }
            });
        }
    }
        
        
    function showTaskCheckboxvalueSection(id) {
        //$( "#task_li_section"+id ).wrap( "<div class='new_li_parent'></div>" );
        $('.add_an_item_ppup_form_dt').hide();
        $('#task_checkbox_additem_ppup'+id).hide();
        $('#task_checkbox_valuee_form_ppup'+id).show();
            
    }

    function hideTaskCheckboxvalueSection(id) {
        $('#task_checkbox_valuee_form_ppup'+id).hide();
        $('#task_checkbox_additem_ppup'+id).show();
    }
        
    function addTaskChecklistValue(id) {
        if ($.trim($('#add_checkbox_value' + id).val()) == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("Please fill checkbox value before submitting.");
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>adminboards/addTaskChecklistValue/',
                data: $('#addcheckboxitem' + id).serialize(),
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    hideTaskCheckboxvalueSection(id);
                    $('html, body').css("cursor", "auto");
                    $("#add_checkbox_value"+id).val('');
                    $("#update-section-checbox-value-info"+id).append(result);
                        
                    var dttt = $(".checkbox_percentage"+id).last().val();
                    $("#checkbox-perr-val"+id).html(dttt + '%');
                    $("#checkbox-perr-valinbar"+id).attr('aria-valuenow', dttt);
                    $("#checkbox-perr-valinbar"+id).css('width', dttt+ '%');
                    
                }
            });
        }
    }
        
    function submitChecboxValueData(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>adminboards/updateTaskChecklistValueBox/',
            data: $('#checkboxTick' + id).serialize(),
            beforeSend: function () {
                $('html, body').css("cursor", "wait");
                //                    $("#comment_loader" + id).show();
                //                    $("#postcomm" + id).hide();
            },
            success: function (result) {
                var checklistidd = $("#checkbox_fr_bar"+id).val();
                $("#checkbox-perr-val"+checklistidd).html(result + '%');
                $("#checkbox-perr-valinbar"+checklistidd).attr('aria-valuenow', result);
                $("#checkbox-perr-valinbar"+checklistidd).css('width', result+ '%');
                $('html, body').css("cursor", "auto");
            
            }
        });
        
           
    }
        
        
    function deleteTaskCheckboxSection(id, slug) {
        var cnfrmm = confirm("Are you sure, You Want to delete?");
        if (cnfrmm) {
            if (id == '' || slug == "") {
                alert("Invalid Request");
                return;
            } else {
                var data = {
                    id: id,
                    slug: slug
                };
            
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>adminboards/deleteProjectBoardTaskChecklist/',
                    data: data,
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");
                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        if(result == 1){
                            $("#main-check-sectionb-ppp" + id).fadeOut(1000);
                        }else{
                            alert("An Error Occurred")
                        }
                    
                    }
                });
            }
        }
    }
        
        
        
    function showTaskDueDateSection(id) {
        //$( "#task_li_section"+id ).wrap( "<div class='new_li_parent'></div>" );
        $('.checklist_taskk_show').hide();
        $('.duedate_taskk_show').hide();
        $('#duedate_taskk_show'+id).show();
        $('#due_date_title'+id).focus();
            
            

    }

    function hideTaskDueDateSection(id) {
        $('#duedate_taskk_show'+id).hide();
    }
        
        
    function addTaskDueDate(id) {
        if ($.trim($('#due_date_title' + id).val()) == '' || $.trim($('#due_date_tm' + id).val()) == '' ) {
            //$('#txtara_comm' + id).addClass('error');
            alert("Please fill date and time information before submitting.");
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>adminboards/addTaskDueDate/',
                data: $('#addtaskduedate' + id).serialize(),
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    hideTaskDueDateSection(id);
                    $('html, body').css("cursor", "auto");
                    $("#due_dt_pp").html(result);
                        
                }
            });
        }
    }
        
    function removeTaskDueDate(id) {
            
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>adminboards/removeTaskDueDate/',
            data: $('#addtaskduedate' + id).serialize(),
            beforeSend: function () {
                $('html, body').css("cursor", "wait");
                //                    $("#comment_loader" + id).show();
                //                    $("#postcomm" + id).hide();
            },
            success: function (result) {
                hideTaskDueDateSection(id);
                $('html, body').css("cursor", "auto");
                $("#due_dt_pp").html("");
                alert('Due Date removed successfully from this Task.')
                        
            }
        });
           
    }
        
  
        
        
</script>