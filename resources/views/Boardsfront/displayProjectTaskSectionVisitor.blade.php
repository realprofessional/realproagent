@section('title', ''.TITLE_FOR_PAGES.' Task Details')
@section('content')
<link href="{{ URL::asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('public/css/front/style.css') }}" rel="stylesheet">
<link href="{{ URL::asset('public/css/style_drag.css') }}" rel="stylesheet">
<link href="{{ URL::asset('public/css/font-awesome.css') }}" rel="stylesheet">

<div id="facebox" class="facebox_project">
<div class="popup newpopup">
<div class="content">


<style>
    *{box-sizing: border-box; padding: 0; margin: 0;}
    ul, li, teble{ list-style: none}
    .content{width: 100% !important; padding: 0px !important;    display: inherit !important;}   
    .popup, #facebox .content{}
    a {
    color: #337ab7;
    text-decoration: none;
}
a:focus, a:hover {
    text-decoration: underline;
}
.text_filedpop_up {
	font-size: 14px;
}
.facebox_project {
 float: left; width: 100%; background: #fff;
}
.popup.newpopup {
	width: 800px;
	margin: 0 auto;
	border: none;
	background: none;
	padding: 0;
	top: 0;
}
.text_filedpop_up{
	width: 100%;
	margin: 0;
	float: left;
	border: 1px #ddd solid;
	border-radius: 7px;
	overflow: hidden;
	padding: 15px;
	box-shadow: 2px 2px 0px 0 #ccc;
	margin: 30px 0;
        background:#edeff0  
}

.left_sction {
	width: 70%;
	float: left;
}
.pop_up_task_name {
	font-size: 20px;
	line-height: 1.42857143;
	color: #333;
	text-align: left;
	font-weight: 600;
}
.pop_up_board_detail {
	padding-left: 41px;
	font-size: 15px;
	color: #5d5858;
}
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
    
    //    $(document).ready(function ($) {
    //        $("#addtaskattachment{{ $taskDetail->id }}").validate({
    //            
    //        });
    //    });
    
</script>
<?php //dd($taskDetail); ?>
<div class="text_filedpop_up sd"> 
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

        <?php
        $attachmentData = DB::table('attachments')
                        ->join('tasks', 'tasks.id', '=', 'attachments.task_id')
                        ->join('users', 'users.id', '=', 'attachments.user_id')
                        ->select('attachments.*', 'users.first_name', 'users.last_name', 'users.last_name')
                        ->where('attachments.task_id', $taskDetail->id)
                        ->orderBy('attachments.id', 'DESC')->get()
        ?>
        <div class="attachment_mn_sec" id="attachment_mn_sec">
            <?php if (!empty($attachmentData)) { ?>

                @include('Boardsfront/ajax_attachments_share')

            <?php } ?>
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

            <?php $checkBoxesLists = DB::table('checklists')->where('task_id', $taskDetail->id)->orderBy('checklists.id', 'ASC')->get(); ?>



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
<!--                                    <a href="javascript:void(0)"  onclick="deleteTaskCheckboxSection({{ $checkBoxesList->id }}, '{{ $checkBoxesList->slug }} ');"> Delete </a>-->
                                </div>
                            </div>

                            <?php $checkBoxesValueLists = DB::table('checklistvalues')->where('checklist_id', $checkBoxesList->id)->orderBy('checklistvalues.id', 'ASC')->get(); ?>

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
                            <?php $checkBoxesValueLists = DB::table('checklistvalues')->where('checklist_id', $checkBoxesList->id)->orderBy('checklistvalues.id', 'ASC')->get(); ?>

                            <div class="check-first-third-section">
                                <div id="update-section-checbox-value-info{{ $checkBoxesList->id }}">
                                    <?php
                                    if ($checkBoxesValueLists) {
                                        foreach ($checkBoxesValueLists as $checkBoxesValueList) {
                                            $varVal = $checkBoxesValueList->is_checked == 0 ? null : true;
                                            ?>

                                            {{ Form::open(array('id' => 'checkboxTick'.$checkBoxesValueList->id, 'files' => true,'class'=>"")) }}
                                            {{Form::checkbox('is_checked', '1', $varVal, array('class'=>'required checkbox_clss','id'=>'checkbox_idd_ppup'.$checkBoxesValueList->id,'onchange'=>"submitChecboxValueData($checkBoxesValueList->id);"))}}
                                            <input type="hidden" id="" name="checked_by" value="{{ Session::get('user_id') }}" >
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


            <?php
            $boardData = DB::table('boards')
                    ->join('projects', 'projects.id', '=', 'boards.project_id')
                    ->select('boards.*', 'projects.user_id as user_id')
                    ->where('boards.id', $taskDetail->project_id)
                    ->first();

            //dd($boardData);

            $user_id = Session::get('user_id');

            $user = DB::table('users')
                    ->where('id', $user_id)
                    ->where('status', '1')
                    ->first();

            //dd($user);
           /* ?>           


<!--                <div class="pop_up_task_name">
                <i class="fa fa-comment-o" aria-hidden="true"></i>
                <label> Add Comment</label>
            </div>
        <div class="comment_wrap new_comm">
                <div class="com_am"><?php echo substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1) ?></div>
                <div class="coment_text">
                    {{ Form::open(array('id' => 'addcomment'.$taskDetail->id, 'files' => true,'class'=>"")) }}
                    {{ Form::textarea('comment', Input::old('comment'),   array('rows'=> '2', 'class' => 'required',  "placeholder"=>"Write a comment", "id"=> "add_comment_value".$taskDetail->id)) }}
                    <input type="hidden" id="" name="user_id" value="<?php echo $user_id ?>" >
                    <input type="hidden" id="" name="task_id" value="<?php echo $taskDetail->id ?>" >
                    <input type="hidden" id="" name="board_id" value="<?php echo $taskDetail->board_id ?>" >
                    <input type="button" class="btn btn-primary" name="comment" id="submit_comment<?php echo $taskDetail->id ?>" value="Add" onclick="addTaskCommentValue(<?php echo $taskDetail->id ?>);"/>
                    <input type="button" class="btn btn-primary" name="mention" id="show_members<?php echo $taskDetail->id ?>" value="@" onclick="showProjectMembersList(<?php echo $taskDetail->id ?>);"/>
                    {{ Form::close() }}
                </div>
            </div>-->



            <?php */
            // dd($taskDetail);

            if ($taskDetail->project_user_id == $user_id) {
                $projectInviteData = DB::table('projectinvites')
                        ->join('projects', 'projects.id', '=', 'projectinvites.project_id')
                        ->join('users', 'users.id', '=', 'projectinvites.user_id')
                        ->select('projectinvites.*', 'users.slug as user_slug', 'users.first_name as first_name', 'users.last_name as last_name')
                        ->where('projectinvites.project_id', $taskDetail->project_id)
                        ->get();
            } else {
                $projectInviteData = DB::table('projectinvites')
                        ->join('projects', 'projects.id', '=', 'projectinvites.project_id')
                        ->join('users', 'users.id', '=', 'projectinvites.user_id')
                        ->select('projectinvites.*', 'users.slug as user_slug', 'users.first_name as first_name', 'users.last_name as last_name')
                        ->where('projectinvites.project_id', $taskDetail->project_id)
                        ->get();
            }
            ?>


            <div class="duedate_taskk_show show_members_ppup" id="show_members_ppup{{ $taskDetail->id }}" style="display:none">
                <div class="copy_heading_task">
                    <div class="copy_heading_task_one">Mention Project Members</div>
                    <div class="copy_heading_task_two"><button type="button" onclick="hideProjectMembersList({{ $taskDetail->id }});" class="close_new" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                </div>
                <div class="copy_content_task" id="members_taskk_content_show{{ $taskDetail->id }}">
                    <?php
                    if ($projectInviteData) {
                        ?>
                        <ul>
                            <?php foreach ($projectInviteData as $projectInvite) {
                                ?>
                                <li onClick="selectMentionMember('{{ $projectInvite->user_slug }}', {{ $taskDetail->id }});"><?php echo $projectInvite->first_name . " " . $projectInvite->last_name . " (" . $projectInvite->user_slug . ")"; ?></li>
                            <?php } ?>
                        </ul>
                        <?php
                    } else {
                        echo "No Members Found";
                    }
                    ?>

                </div>

            </div>


            <div id="comment_sectionn" class="checklist_section_main">
                <?php
                $commentLists = DB::table('comments')
                                ->join('tasks', 'tasks.id', '=', 'comments.task_id')
                                ->join('users', 'users.id', '=', 'comments.user_id')
                                ->select('comments.*', 'users.first_name', 'users.last_name', 'users.last_name')
                                ->where('comments.task_id', $taskDetail->id)
                                ->orderBy('comments.id', 'DESC')->get()
                ?>

                <div class="check-first-third-section" id="comment_overall_sectionss">
                    <?php
                    if ($commentLists) {

                        foreach ($commentLists as $commentList) {
                            ?>
                            <div class = "comment_wrap new_ft" id="comment_big_sec_whole{{ $commentList->id }}">
                                <div class = "com_am"><?php echo substr($commentList->first_name, 0, 1) . substr($commentList->last_name, 0, 1)
                            ?></div>

                                <div class="coment_text" id="comment_text_show{{ $commentList->id }}">
                                    <div class="comment_full_sec" id="comment_full_sec{{ $commentList->id }}">
                                        {{ nl2br($commentList->comment) }}
                                    </div>
                                    <div class="comment_full_sec_later">
                                        <div class="comment_full_sec_time">
                                            {{  date("d M, h:i A", strtotime($commentList->created)) }}
                                        </div>


                                        <div class="comment_full_sec_links">
                                            <button class="btn_newdd btn-xs edit-task nnee-board-button" onclick="showEditCommentSection({{ $commentList->id }});">Edit</button>
<!--                                            <button class="btn_newdd btn-xs edit-task nnee-board-button" onclick="deleteTaskComment({{ $commentList->id }}, '{{ $commentList->slug }}');">Delete</button>-->
                                        </div>
                                    </div>
                                </div>


                                <div class="coment_text" id="comment_edit_show{{ $commentList->id }}" style="display:none;">
                                    {{ Form::open(array('id' => 'editcomment'.$commentList->id, 'files' => true,'class'=>"")) }}
                                    {{ Form::textarea('comment', $commentList->comment,   array('rows'=> '2', 'class' => 'required',  "placeholder"=>"Write a comment", "id"=> "edit_comment_value".$commentList->id)) }}
                                    <input type="hidden" id="" name="comment_id" value="<?php echo $commentList->id ?>" >

                                    <div class="pop_bnt">
                                        <input type="button" class="btn btn-primary" name="Update" id="update_comment<?php echo $commentList->id ?>" value="Update" onclick="editTaskCommentValue(<?php echo $commentList->id ?>);"/>
                                        <button class="close" type="button" onclick="hideEditCommentSection({{ $commentList->id }});" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>


                                    {{ Form::close() }}
                                </div>
                            </div>


                            <?php
                        }
                    }
                    ?>

                </div>


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
                                       <li>
                                            <a href="javascript:void(0)"  onclick="showTaskFileUploadSection({{ $taskDetail->id }});">
                                                <i class="fa fa-paperclip" aria-hidden="true"></i> Attachment
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


                <div class="attachment_popup_show duedate_taskk_show" id="attachment_popup{{ $taskDetail->id }}" style="display:none">
                    <div class="copy_heading_task">
                        <div class="copy_heading_task_one">Add Attachment</div>
                        <div class="copy_heading_task_two"><button type="button" onclick="hideTaskFileUploadSection({{ $taskDetail->id }});" class="close_new" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                    </div>
                    <div class="copy_content_task" id="attachment_popup_content_show{{ $taskDetail->id }}">
                        <div class="loaderr">{{ Html::image('public/img/loading.gif','search',array('class'=>"")) }}</div> 

                        {{ Form::open(array('id' => 'addtaskattachment'.$taskDetail->id, 'files' => true,'class'=>"")) }}
                        <div class="copy_text">Choose File </div>
                        <div class="selectt" id="task_attchement_section{{$taskDetail->id}}">
                            {{ Form::file('attachment',array('id'=>'attachment_nm', 'class'=>'required','onchange' => 'return imageValidation();')); }}
                        </div>
                        <div id="datetimepicker12"></div>

                        <input type="hidden" id="" name="task_id" value="<?php echo $taskDetail->id ?>" >
                        <input type="hidden" id="" name="board_id" value="<?php echo $taskDetail->board_id ?>" >

                        <div class="submit_new_btn">
                            <input type="button" class="submit_new" name="add_attachment" id="add_attachment<?php echo $taskDetail->id ?>" value="Add" onclick="addTaskAttachment(<?php echo $taskDetail->id ?>);"/>
                        </div> 
                        {{ Form::close() }}
                    </div>
                </div>


            </div>
        </div>
    </div>


</div>
</div>
</div>
</div>