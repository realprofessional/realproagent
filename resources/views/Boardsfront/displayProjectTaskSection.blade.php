<style>
    .content{width: 100% !important; padding: 0px !important;    display: inherit !important;}   
    .popup, #facebox .content{background:#edeff0}
</style>
<script src="{{ URL::asset('public/assets/ckeditor/ckeditor.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function () {
        $.validator.addMethod("pass", function (value, element) {
            return  this.optional(element) || (/.{8,}/.test(value) && /([0-9].*[a-z])|([a-z].*[0-9])/.test(value));
        }, "Password minimum length must be 8 characters and contain atleast 1 number.");
        $.validator.addMethod("contact", function (value, element) {
            return  this.optional(element) || (/^[0-9-]+$/.test(value));
        }, "Contact Number is not valid.");
        $.validator.addMethod("noSpace", function (value, element) {
            return value.indexOf(" ") < 0 && value != "";
        }, "No space please and don't leave it empty");
        $("#addReminder").validate();
        
//        $('#type_reminder').on('change', function(){
//            var valll = $('#type_reminder').val();
//            if(valll == 2){
//                alert('dsa');
//                $('#chng_txt').html('Message');
//                $('#ckedit_section').hide();
//                $('#email_subject_reminder').attr("placeholder", "Message");
//            }else{
//                $('#chng_txt').html('Email Subject');
//                $('#ckedit_section').show();
//                $('#email_subject_reminder').attr("placeholder", "Email Subject");
//            }
//        });
        
        $('#addReminder').submit(function (event)
        {
            
            var serializedReturn = $(this).find('input[name!=email_content]').serialize(); 
            var desc = CKEDITOR.instances.email_content.getData();
            var typee = $(this).find('#type_reminder').val();
            
            serializedReturn += "&type=" + encodeURIComponent(typee);
            serializedReturn += "&email_content=" + encodeURIComponent(desc);
            
            
//            alert(serializedReturn); return false;
            var form = $('#addReminder');
            // Stop full page load
            if (form.valid()) {
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>board/saveTaskReminder',
                    data: serializedReturn,
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");
                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        if(result != 2){
                            $('#reminders_list_ii').html(result);
                            $('#closeebt').click();
                            $('#addReminder')[0].reset();
                            window.location.reload();
                        }else{
                            alert("Invalid Request");
                        }
                    }
                });
            }else{
                event.preventDefault();
            }
            
        });
        
    });
    
    function typeReminderChange(id, scndid, thrdid, valuee){
        if(valuee == 2){
                $('#'+thrdid).html('Message');
                $('#'+id).hide();
                $('#'+scndid).attr("placeholder", "Message");
            }else{
                $('#'+thrdid).html('Email Subject');
                $('#'+id).show();
                $('#'+scndid).attr("placeholder", "Email Subject");
            }
    }
    
    function updateRemindersection(id){
                        
            var idww = "updateReminder"+id;
            var emailcontid = "email_content" + id;
                    
                    
            var serializedReturn = $('#'+idww).find('input[name!='+emailcontid+']').serialize(); 
            //            var desc = CKEDITOR.instances.email_content.getData();
            var desc = CKEDITOR.instances['email_content'+id].getData();
            var typee = $('#'+idww).find('#type_reminder'+id).val();
                
            serializedReturn += "&type=" + encodeURIComponent(typee);
            serializedReturn += "&email_content=" + encodeURIComponent(desc);
                    
//            alert(serializedReturn); return false;
                    
            
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>board/updateTaskReminder',
                    data: serializedReturn,
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");
                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        if(result != 2){
                            $('#closeebt'+id).click();
                            window.location.reload();

                            //                                $('#reminders_list_ii').html(result);
                                            
                            //                                window.location.reload();
                            //                                $('.modal-backdrop').hide();
                            //                              
                            //   $('#myModalupdate<?php //echo $listOfReminder->id;   ?>').modal().hide();
                                            
                        }else{
                            alert("Invalid Request");
                        }
                    }
                });
            
                 
        }


</script>
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
        
        
        $(".reminder_date").datepicker({
            //defaultDate: "+1w",
            changeMonth: true,
            format: 'dd-mm-yyyy',
            numberOfMonths: 1,
            minDate: 'dd-mm-yyyy',
            //maxDate: new Date(),
            changeYear: true
        });
                
        $(".reminder_time").timepicker();
        
    });
    
    //    $(document).ready(function ($) {
    //        $("#addtaskattachment{{ $taskDetail->id }}").validate({
    //            
    //        });
    //    });
    
</script>
<?php //dd($taskDetail); ?>

<div class="tile_insection"><i class="fa fa-calendar"></i><?php echo $taskDetail->task_name; ?></div> 
<div class="insectopn_date">
    <a href="javascript:void(0)"  onclick="showTaskDueDateSection({{ $taskDetail->id }});">
        <i class="fa fa-clock-o" aria-hidden="true"></i> Due Date 
    </a>
    <a href="javascript:void(0)"  onclick="showTaskFileUploadSection({{ $taskDetail->id }});">
        <i class="fa fa-paperclip" aria-hidden="true"></i> Attachment
    </a>
    <a href="javascript:void(0)"  onclick="showShareTask({{ $taskDetail->id }});">
        <i class="fa fa-share-alt" aria-hidden="true"></i> Share Task
    </a>
</div>

<div class="new_link_on_popupp">





    <?php
    $remdt = date("m/d/Y");
    $remtim = "12:00 pm";


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

    <div class="share_popup_show duedate_taskk_show" id="share_popup{{ $taskDetail->id }}" style="display:none">
        <div class="copy_heading_task">
            <div class="copy_heading_task_one">Share Task</div>
            <div class="copy_heading_task_two"><button type="button" onclick="hideShareSection({{ $taskDetail->id }});" class="close_new" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
        </div>
        <div class="copy_content_task" id="attachment_popup_content_show{{ $taskDetail->id }}">
            <div class="loaderr">{{ Html::image('public/img/loading.gif','search',array('class'=>"")) }}</div> 

            <div class="selectt">
                <input type="text" id=""  value="<?php echo HTTP_PATH ?>board/c/<?php echo $taskDetail->slug ?>" >
            </div>

        </div>
    </div>


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
<div class="pop_up_board_detail">
    in Board: <?php echo $taskDetail->board_name; ?> 
</div>


<div class="before_show_pop_up_task_desc"  onclick="showUpdateDescription();">
    <i class="fa fa-list" aria-hidden="true"></i>
    Edit the description
</div>

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


<div class="reminderss">
    <div class="title_rime">Reminders
        
        <?php if ($taskDetail->is_checked != 1) { ?>
            <div class="minus">
                <a  href="javascript:void(0);" data-toggle="modal" data-target="#myModal{{ $taskDetail->id }}">+</a>
            </div>
        <?php } ?>
    </div>    
    <div class="reminders_list" id="reminders_list_ii">
        <?php
        $todaydate = date('Y-m-d H:i:s');

        $listOfReminders = DB::table('reminders')
                ->where('task_id', $taskDetail->id)
//                ->where('datetime', '>', $todaydate)
                ->select('reminders.*')
                ->orderBy('reminders.datetime', 'asc')
                ->limit(20)
                ->get();
        ?>

        @include('Boardsfront/reminders_list')
    </div>
</div>


<div class="pop_up_task_desc">
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
    ?>       


    <div class="comment">
        <div class="comment_title"><i class="fa fa-comment"></i>Add Comment</div> 
        {{ Form::open(array('id' => 'addcomment'.$taskDetail->id, 'files' => true,'class'=>"")) }}

        <div class="comment_text new_comm">
            {{ Form::textarea('comment', Input::old('comment'),   array('rows'=> '2', 'class' => 'required',  "placeholder"=>"Write a comment", "id"=> "add_comment_value".$taskDetail->id)) }}
            <input type="hidden" id="" name="user_id" value="<?php echo $user_id ?>" >
            <input type="hidden" id="" name="task_id" value="<?php echo $taskDetail->id ?>" >
            <input type="hidden" id="" name="board_id" value="<?php echo $taskDetail->board_id ?>" >

        </div>
        <div class="btn_bomm">
            <input type="button" class="round_btn" name="comment" id="submit_comment<?php echo $taskDetail->id ?>" value="Add" onclick="addTaskCommentValue(<?php echo $taskDetail->id ?>);"/>
            <input type="button" class="circle_btn" name="mention" id="show_members<?php echo $taskDetail->id ?>" value="@" class="circle_btn" onclick="showProjectMembersList(<?php echo $taskDetail->id ?>);"/>
        </div>
        {{ Form::close() }}
    </div>






    <?php
    // dd($taskDetail);

    if ($taskDetail->project_user_id == $user_id) {
        $projectInviteData = DB::table('projectinvites')
                ->join('projects', 'projects.id', '=', 'projectinvites.project_id')
                ->join('users', 'users.id', '=', 'projectinvites.user_id')
                ->select('users.slug as user_slug', 'users.first_name as first_name', 'users.last_name as last_name')
                ->where('projectinvites.project_id', $taskDetail->project_id)
                ->where('projectinvites.board_id', $taskDetail->board_id)
                ->get();

        $projectManagerData = array();
    } else {
        $projectInviteData = DB::table('projectinvites')
                ->join('projects', 'projects.id', '=', 'projectinvites.project_id')
                ->join('users', 'users.id', '=', 'projectinvites.user_id')
                ->select('users.slug as user_slug', 'users.first_name as first_name', 'users.last_name as last_name')
                ->where('projectinvites.project_id', $taskDetail->project_id)
                ->where('projectinvites.board_id', $taskDetail->board_id)
                ->where('projectinvites.user_id', "!=", $user_id)
                ->get();

        $projectManagerData = DB::table('users')
                ->where('id', $taskDetail->project_user_id)
                ->where('status', '1')
                ->first();



        //dd($projectInviteData);
    }
    ?>


    <div class="duedate_taskk_show show_members_ppup" id="show_members_ppup{{ $taskDetail->id }}" style="display:none">
        <div class="copy_heading_task">
            <div class="copy_heading_task_one">Mention Project Members</div>
            <div class="copy_heading_task_two"><button type="button" onclick="hideProjectMembersList({{ $taskDetail->id }});" class="close_new" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
        </div>
        <div class="copy_content_task" id="members_taskk_content_show{{ $taskDetail->id }}">
            <?php
            if ($projectInviteData || $projectManagerData) {
                ?>
                <ul>
                    <?php foreach ($projectInviteData as $projectInvite) {
                        ?>
                        <li onClick="selectMentionMember('{{ $projectInvite->user_slug }}', {{ $taskDetail->id }});"><?php echo $projectInvite->first_name . " " . $projectInvite->last_name . " (" . $projectInvite->user_slug . ")"; ?></li>
                    <?php } ?>

                    <?php if (!empty($projectManagerData)) {
                        ?>
                        <li onClick="selectMentionMember('{{ $projectManagerData->slug }}', {{ $taskDetail->id }});"><?php echo $projectManagerData->first_name . " " . $projectManagerData->last_name . " (" . $projectManagerData->slug . ")"; ?></li>
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
                                    <button class="btn_newdd btn-xs edit-task nnee-board-button" onclick="deleteTaskComment({{ $commentList->id }}, '{{ $commentList->slug }}');">Delete</button>
                                </div>
                            </div>
                        </div>


                        <div class="coment_text" id="comment_edit_show{{ $commentList->id }}" style="display:none;">
                            {{ Form::open(array('id' => 'editcomment'.$commentList->id, 'files' => true,'class'=>"")) }}
                            {{ Form::textarea('comment', $commentList->comment,   array('rows'=> '2', 'class' => 'required',  "placeholder"=>"Write a comment", "id"=> "edit_comment_value".$commentList->id)) }}
                            <input type="hidden" id="" name="comment_id" value="<?php echo $commentList->id ?>" >

                            <div class="pop_bnt">
                                <input type="button" class="btn btn-primary " name="Update" id="update_comment<?php echo $commentList->id ?>" value="Update" onclick="editTaskCommentValue(<?php echo $commentList->id ?>);"/>
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
        @include('Boardsfront/ajax_attachments')
    <?php } ?>
</div>

<!--<div class="overlay">
    <div class="popup">
        <button id="close_popup" onclick="hideBoardSection();" class="btn btn-xs">x</button>
        <h2 class="add-board-form-title inactive">Add New Boarddsf</h2>
        {{ Form::open(array('url' => 'admin/projects/board', 'method' => 'post', 'id' => 'add_board_form', 'files' => true,'class'=>"inactive")) }}
        <div class="form-group">
            <label for="add_board_name">Add Board Name</label>
            {{ Form::text('board_name', Input::old('board_name'),   array('class' => 'required form-control noSpace',"placeholder"=>"Board Name", "id"=> "add_board_name")) }}
        </div>
        <button type="submit" class="btn btn-primary">Add Board</button>
        {{ Form::close() }}
    </div>
</div>-->

<!--<div class="download_list">
    <div class="download_row">
        <div class="download_img">
            {{ Html::image('public/img/front/img.png','img',array('class'=>"")) }}
        </div>   
        <div class="download_content">
            <a href="#">54554414545424512545.doc</a>    
            <a class="btn_down" href="#">download</a>
            <div class="down_con">February 23,2018 16:30 pm</div>
        </div>   

    </div> 
    <div class="download_row">
        <div class="download_img">{{ Html::image('public/img/front/img.png','img',array('class'=>"")) }}</div>   
        <div class="download_content">
            <a href="#">54554414545424512545.doc</a>    
            <a class="btn_down" href="#">download</a>
            <div class="down_con">February 23,2018 16:30 pm</div>
        </div>   

    </div> 

</div>-->




<!-- Trigger the modal with a button -->


<!-- Modal -->
<div class="modal fade" id="myModal{{ $taskDetail->id }}" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content reminder_pop">
            <div class="modal-header">
                <button type="button" id="closeebt" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Reminders</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array('url' => 'projectboard/addReminder', 'method' => 'post', 'id' => 'addReminder', 'files' => true,'class'=>"form-inline form")) }}
                <?php
                global $arrayType;
                ?>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="selectbasic">Type</label>
                    <div class="col-md-12">
                        {{Form::select('type', [null=>'Select Type'] + $arrayType,Input::old('type'),array('class'=>'required form-control','id'=>'type_reminder','onchange'=>"typeReminderChange('ckedit_section', 'email_subject_reminder','chng_txt',this.value);" ))}}
                    </div>
                </div>

                <div class="form-group">
                    {{ Html::decode(Form::label('title', "Campaign Title <span class='require'>*</span>",array('class'=>"control-label col-md-12"))) }}
                    <div class="col-md-12">
                        {{ Form::text('title', Input::old('title'), array('class' => 'required form-control ',"placeholder"=>"Campaign Title ")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Html::decode(Form::label('title', "Reminder Date and Time <span class='require'>*</span>",array('class'=>"control-label col-md-12"))) }}
                    <div class="col-md-12">
                        {{ Form::text('reminder_date', $remdt , array('class' => 'required form-control noSpace reminder_date', 'readonly' => 'readonly',  'id'=>'reminder_date', "placeholder"=>"Select Date")) }}
                        {{ Form::text('reminder_time', $remtim , array('class' => 'required form-control noSpace reminder_time', 'id'=>'reminder_time'.$taskDetail->id, "placeholder"=>"Select Time")) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Html::decode(Form::label('email_subject', "<span id='chng_txt'>Email Subject</span><span class='require'>*</span>",array('class'=>"control-label col-md-12"))) }}
                    <div class="col-md-12">
                        {{ Form::text('email_subject', Input::old('email_subject'), array('id' => 'email_subject_reminder' ,'class' => 'required form-control ',"placeholder"=>"Email Subject")) }}
                    </div>
                </div>

                <div class="form-group" id="ckedit_section">
                    {{ Html::decode(Form::label('email_content', "Email Content<span class='require'>*</span>",array('class'=>"control-label col-md-12"))) }}
                    <div class="col-md-12">
                        {{ Form::textarea('email_content', Input::old('email_content'), array('rows'=> '2', 'class' => 'required form-control ckeditor',  "placeholder"=>"Email Content")) }}
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-12 pull-right sub_mitt">
                        <input type="hidden" id="" name="user_id" value="<?php echo Session::get('user_id'); ?>" >
                        <input type="hidden" id="" name="task_id" value="<?php echo $taskDetail->id ?>" >
                        {{ Form::submit('Submit', array('class' => "btn btn-primary")) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>

    </div>
</div>


<?php ?>
<!--<div class="text_filedpop_up"> -->
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
                url: '<?php echo HTTP_PATH; ?>board/updateAdminTaskDescriptionData/',
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
                url: '<?php echo HTTP_PATH; ?>board/addTaskChecklist/',
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
                url: '<?php echo HTTP_PATH; ?>board/addTaskChecklistValue/',
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
            url: '<?php echo HTTP_PATH; ?>board/updateTaskChecklistValueBox/',
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
                    url: '<?php echo HTTP_PATH; ?>board/deleteProjectBoardTaskChecklist/',
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
                url: '<?php echo HTTP_PATH; ?>board/addTaskDueDate/',
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
                        
                    var d = new Date($('#due_date_title' + id).val());
                        
                    var months = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    var finalDate = "Due on " + d.getDate() + "-" + months[d.getMonth()] + "-" + d.getFullYear();
                    $("#due_on_txt_"+id).html(finalDate);
                        
                }
            });
        }
    }
        
    function removeTaskDueDate(id) {
            
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>board/removeTaskDueDate/',
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
        
    function addTaskCommentValue(id) {
        if ($.trim($('#add_comment_value' + id).val()) == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("Please fill comment before submitting.");
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>board/addTaskCommentValue/',
                data: $('#addcomment' + id).serialize(),
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    if(result == 'error'){
                        alert("An Error Occured. Please try again later.");   
                    }else{
                        $('html, body').css("cursor", "auto");
                        $("#add_comment_value"+id).val('');
                        $("#comment_overall_sectionss").prepend(result);

                    }
                    
                }
            });
        }
    }
        
        
    function showEditCommentSection(id) {
        $('#comment_text_show'+id).hide();
        $('#comment_edit_show'+id).show();
    }
        
    function hideEditCommentSection(id) {
        $('#comment_edit_show'+id).hide();
        $('#comment_text_show'+id).show();
    }
        
    function editTaskCommentValue(id) {
        if ($.trim($('#edit_comment_value' + id).val()) == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("Please fill comment before submitting.");
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>board/editTaskCommentValue/',
                data: $('#editcomment' + id).serialize(),
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                },
                success: function (result) {
                    if(result == 'error'){
                        alert("An Error Occured. Please try again later.");   
                    }else{
                        $('html, body').css("cursor", "auto");
                        $("#comment_full_sec"+id).html($('#edit_comment_value' + id).val());
                        hideEditCommentSection(id)
                        //$("#update-section-checbox-value-info"+id).append(result);
                    }
                    
                }
            });
        }
    }
        
    function deleteTaskComment(id, slug) {
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
                    url: '<?php echo HTTP_PATH; ?>board/deleteTaskComment',
                    data: data,
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");
                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        if(result == 1){
                            $("#comment_big_sec_whole" + id).fadeOut(1000);
                        }else{
                            alert("An Error Occurred")
                        }
                    
                    }
                });
            }
        }
    }
    
    function deleteTaskReminder(id) {
        var cnfrmm = confirm("Are you sure, You Want to delete?");
        if (cnfrmm) {
            if (id == '') {
                alert("Invalid Request");
                return;
            } else {
                var data = {
                    id: id,
                };
            
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>board/deleteTaskReminder',
                    data: data,
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");
                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        if(result == 1){
                            $("#main_remin_ll" + id).fadeOut(1000);
                        }else{
                            alert("An Error Occurred")
                        }
                    
                    }
                });
            }
        }
    }
        
        
    function showProjectMembersList(id) {
        $('#show_members_ppup'+id).show();
    }

    function hideProjectMembersList(id) {
        $('#show_members_ppup'+id).hide();
    }
        
        
    function selectMentionMember(val, id) {
        //alert('selectMentionMember');
        var commentvalue = $("#add_comment_value"+id).val();
        if(commentvalue){
            $("#add_comment_value"+id).val(commentvalue+" @"+val+" ");
        }else{
            $("#add_comment_value"+id).val("@"+val+" ");
        }
        $("#show_members_ppup"+id).hide();
            
    }
        
        
    function showTaskFileUploadSection(id) {
        //$( "#task_li_section"+id ).wrap( "<div class='new_li_parent'></div>" );
        $('.checklist_taskk_show').hide();
        $('.duedate_taskk_show').hide();
        $('.attachment_popup_show').hide();
        $('#attachment_popup'+id).show();
    }

    function hideTaskFileUploadSection  (id) {
        $('#attachment_popup'+id).hide();
        document.getElementById("attachment_nm").value = "";

    }
        
        
    function addTaskAttachment(id) {
        if ($('#attachment_nm').val() == "") {
            alert("Please attach a file before submitting.");
            return;
        } else {
            var form_data = new FormData();
            var file_data = $("#attachment_nm").prop("files")[0];
            if(file_data){
                form_data.append("attachment", file_data)  
            }
            form_data.append("task_id", <?php echo $taskDetail->id ?>)  
            form_data.append("board_id", <?php echo $taskDetail->board_id ?>)  
            form_data.append("user_id", <?php echo Session::get('user_id'); ?>)  
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>board/addAttachment/',
                data: form_data,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    hideTaskFileUploadSection(id);
                    $('html, body').css("cursor", "auto");
                    $("#attachment_mn_sec").html(result);
                        
                }
            });
        }
    }
        
    function deleteAttachment(id) {
        var cnfrmm = confirm("Are you sure, You Want to delete?");
        if (cnfrmm) {
            if (id == '') {
                alert("Invalid Request");
                return;
            } else {
                var data = {
                    id: id
                };
            
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>board/deleteAttachment/',
                    data: data,
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");
                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        if(result == 1){
                            $("#attachment_main_" + id).fadeOut(1000);
                        }else{
                            alert("An Error Occurred")
                        }
                    
                    }
                });
            }
        }
    }
        
    function showShareTask(id) {
        //$( "#task_li_section"+id ).wrap( "<div class='new_li_parent'></div>" );
        $('.checklist_taskk_show').hide();
        $('.duedate_taskk_show').hide();
        $('.attachment_popup_show').hide();
        $('.share_popup_show').hide();
        $('#share_popup'+id).show();
    }

    function hideShareSection  (id) {
        $('#share_popup'+id).hide();
    }
        
        
        
    function in_array(needle, haystack) {
        for (var i = 0, j = haystack.length; i < j; i++) {
            if (needle == haystack[i])
                return true;
        }
        return false;
    }

    function getExt(filename) {
        var dot_pos = filename.lastIndexOf(".");
        if (dot_pos == -1)
            return "";
        return filename.substr(dot_pos + 1).toLowerCase();
    }



    function imageValidation() { 

        var filename = document.getElementById("attachment_nm").value;

        var filetype = ['jpeg', 'png', 'jpg', 'gif', 'doc', 'docx', 'pdf', 'mp4'];
        if (filename != '') {
            var ext = getExt(filename);
            ext = ext.toLowerCase();
            var checktype = in_array(ext, filetype);
            if (!checktype) {
                alert(ext + " file not allowed for Attachment.");
                document.getElementById("attachment_nm").value = "";
                return false;
            } else {
                var fi = document.getElementById('attachment_nm');
                var filesize = fi.files[0].size;
                if (filesize > 2097152) {
                    alert('Maximum 2MB file size allowed for Attachment.');
                    document.getElementById("attachment_nm").value = "";
                    return false;
                }
            }
        }
        return true;
    }
        
    
        
</script>
<!--</div>-->