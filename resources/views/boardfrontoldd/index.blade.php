@section('title', ''.TITLE_FOR_PAGES.'User List')
@extends('layouts/default_front_project')
@section('content')
<!--<script src="{{ URL::asset('public/assets/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>-->
<script src="{{ URL::asset('public/js/datepicker/jquery-ui.js') }}"></script>
<script src="{{ URL::asset('public/js/datepicker/jquery.timepicker.min.js') }}"></script>
{{ Html::style('public/js/datepicker/jquery-ui.css'); }}
{{ Html::style('public/js/datepicker/jquery.timepicker.css'); }}

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

{{ Html::style('public/css/lightbox.css'); }}
{{ Html::script('public/js/lightbox.js'); }}


{{ Html::style('public/css/style_drag.css'); }}
<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>
<!--<script type="text/javascript" src="{{ URL::asset('public/js/script_drag.js') }}"></script>-->


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $( function() {
        $( ".task-items").sortable({
            connectWith: ".task-items",
            
            start: function(event, ui) {
                //                event.stopImmediatePropagation();

                //                var idd = ui.item.attr("id");
                //
                //                 $('#'+idd).find(".task_contact_sw").find('a').bind("click.prevent",
                //                function(event) { event.preventDefault(); })
            },
            stop: function(event, ui) {
                //setTimeout(function(){ui.item.find('div a').unbind("click.prevent");}, 300);
                
                var idd = ui.item.attr("id");
                var task_id = ui.item.attr("data-task-index");
                var board_id = ui.item.attr("data-board-id");
                var position = ui.item.attr("data-task-position");
                var destId = ui.item.parent().attr("data-ul-board-id");
                var destBoardDtId = ui.item.parent().attr("id");
                var destPosition = ui.item.index();
                
                //alert(destId);
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>board/dragProjectTask/',
                    data: {
                        old_task_id : task_id,
                        old_board_id : board_id,
                        old_position : position,
                        board_id : destId,
                        position : destPosition
                    },
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");
                        //                    $("#comment_loader" + id).show();
                        //                    $("#postcomm" + id).hide();
                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        //alert('a');
                        
                        if(result == 'error'){
                            alert('An Error Occured');
                        }else{
                            $("#" + destBoardDtId).html(result);
                        
                        
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo HTTP_PATH; ?>board/updatePreviousBoard/',
                                data: {
                                    old_board_id : board_id
                                },
                                beforeSend: function () {
                                },
                                success: function (result) { 
                                    if(result == 'error'){
                                        alert('An Error Occured');
                                    }else{
                                        $("#task-ul" + board_id).html(result);
                                        updateAllActivity(<?php echo $project->id ?>);   
                                    }
                                    //$("#" + destBoardDtId).html(result);
                                    //alert('success');
                                }
                            });
                        }
                        
                        
                        
                        //alert('success');
                    }
                });
            },
            update: function(event, ui) {
           
            }
        }).disableSelection();
    } );
</script>

<script>
    $( function() {
        $( ".containerdf" ).sortable({
            connectWith: ".containerdf",
            placeholder: "ui-state-highlight",
            helper:'clone',
             
            start: function(event, ui) {
                ui.item.bind("click.prevent",
                function(event) { event.preventDefault(); });
            },
            stop: function(event, ui) {
                setTimeout(function(){ui.item.unbind("click.prevent");}, 300);
                
                
                var board_id = ui.item.attr("data-board-id");
                var project_id = <?php echo $project->id; ?>;
                var position = ui.item.attr("data-board-position");
                var destPosition = ui.item.index();
                
                //alert(destPosition);
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>board/dragProjectBoard/',
                    data: {
                        old_board_id : board_id,
                        old_position : position,
                        project_id : project_id,
                        position : destPosition
                    },
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");
                        //                    $("#comment_loader" + id).show();
                        //                    $("#postcomm" + id).hide();
                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        updateAllActivity(<?php echo $project->id ?>);   
                        //alert('success');
                    }
                });
            },
            update: function(event, ui) {
           
            }
        }).disableSelection();
    } );
</script>

<script src="{{ URL::asset('public/js/facebox.js') }}"></script>
{{ Html::style('public/css/facebox.css'); }}

<style>
    /* NZ Web Hosting - www.nzwhost.com 
     * Fieldset Alternative Demo
    */
    .popup {
        width: 800px;
    }

</style>


<script>
    $(document).ready(function () {
        $.ajaxSetup(
        {
            headers:
                {
                'X-CSRF-Token': $('input[name="_token"]').val()
            }
        });
    });
</script> 

<script>
    
    $(document).ready(function ($) {
        
        $('.close_image').hide();
        $('a[rel*=facebox]').facebox({
            loadingImage: "<?php echo HTTP_PATH; ?>public/img/loading.gif",
            closeImage: "<?php echo HTTP_PATH; ?>public/img/close.png"
        });
        
<?php if (isset($slug2) && $slug2 != "") { ?>
                    $.facebox(function() {
                        $.ajax({
                            error: function() {
                                $.facebox();
                            },
                            success: function(data) {
                                $.facebox(data);
                            },
                            type: 'post',
                            url: "{{ HTTP_PATH.'board/displayProjectTaskSection/'.$slug2 }}"
                        });
           
                    });
            
<?php } ?>
        
        
        
      
            });
    
    
            $(function() {
                var date=new Date();
                $("#searchByDateFrom").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    format: 'dd-mm-yyyy',
                    numberOfMonths: 1,
            
                    //minDate: 'mm-dd-yyyy',
                    maxDate: new Date(),
            
                    changeYear: true,
                    onClose: function(selectedDate) {
                        $("#searchByDateTo").datepicker("option", "minDate", selectedDate);
                    }
                });
                $("#searchByDateTo").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    format: 'dd-mm-yyyy',
                    numberOfMonths: 1,
                    maxDate: new Date(),
                    changeYear: true,
                    onClose: function(selectedDate) {
                        $("#searchByDateFrom").datepicker("option", "maxDate", selectedDate);
                    }
                });

            });
</script>
<?php
if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
    $search = $_REQUEST['search'];
} else {
    $search = "";
}
if (isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])) {
    $_REQUEST['from_date'];

    $from_date = $_REQUEST['from_date'];
} else {
    $from_date = "";
}
if (isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])) {
    $to_date = $_REQUEST['to_date'];
} else {
    $to_date = "";
}
?>

<div class="acc_deack_new_ sdfwe">
    <div class="wrapper_new">
        <div class="df_ty">
            <nav class="breadcrumbs">
                <div class="container1">
                    <ul>
                        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>account">Account</a></li>
                        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>projectboard/projects">My Transactions</a></li>
                        <li class="breadcrumbs__item">
                            <span id="test_name_project_data{{ $project->id }}" onclick="showEditProjectSection({{ $project->id }});">{{ $project->project_name }}</span>
                        </li>
                    </ul>
                </div>
            </nav>
            <div id="project_content_edit{{ $project->id }}" class="project_content_edit_clss" style="display: none">
                <script>
                    $(document).ready(function () {
                        $("#projectboard{{ $project->id }}").validate({
                        });
                    });
                </script>
                <span> Update Project Name </span>
                {{ Form::open(array('id' => 'projectboard'.$project->id, 'files' => true,'class'=>"")) }}
                {{ Form::textarea('project_name', $project->project_name, array('rows'=> '1', 'class' => 'required form-control noSpace', 'onblur'=>"updateProjectData($project->id);", "placeholder"=>"Project Name", "id"=> "edit_project_name".$project->id)) }}
                <input type="hidden" id="" name="id" value="<?php echo $project->id ?>" >
                {{ Form::close() }}
            </div>
            <div class="dd_showmenu"><a href="javascript:void(0)" class="showhidemenu">Show Menu</a>
                <div class="dd_shomenus slidedivmenu">
                    <div class="activity_menu">Menu</div>
                    <div class="close_menu">{{ Html::image('public/img/front/cancel-music.svg','search',array('class'=>"")) }}</div>


                    <div class="act_task new_invite_cls">
                        <a  href="javascript:void();"><i class="fa fa-users" aria-hidden="true"></i>Project Members </a>
                        <ul class="prj_member_lst">
                            <?php if (!empty($invitedProjectUsers)) { ?>
                                <?php foreach ($invitedProjectUsers as $user) { ?>
                                    <li>
                                        <span class="user_pic new_user_pic front_nww" id="inv_user_{{ $user->user_id }}">
                                            <?php
                                            if (!empty($user->profile_image)) {
                                                echo '<img title="' . $user->first_name . '" "' . $user->last_name . '"  src="' . HTTP_PATH . DISPLAY_FULL_PROFILE_IMAGE_PATH . $user->profile_image . '" alt="user img">';
                                            } else {
                                                echo '<img title="' . $user->first_name . '" "' . $user->last_name . '" src="' . HTTP_PATH . 'public/img/front/man-user.svg" alt="user img">';
                                            }
                                            ?>
                                            <button type="button" onclick="removeInvitedUser({{ $user->user_id }},{{ $user->project_id }});" class="close_new" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </span>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                            <?php
                            $user_id = Session::get('user_id');
                            if ($user_id != $project->user_id) {
                                ?>
                                <li>
                                    <span class="user_pic new_user_pic front_nww">
                                        <?php
                                        if (!empty($projectUser->profile_image)) {
                                            echo '<img title="' . $projectUser->first_name . '" "' . $projectUser->last_name . '"  src="' . HTTP_PATH . DISPLAY_FULL_PROFILE_IMAGE_PATH . $projectUser->profile_image . '" alt="user img">';
                                        } else {
                                            echo '<img title="' . $projectUser->first_name . '" "' . $projectUser->last_name . '" src="' . HTTP_PATH . 'public/img/front/man-user.svg" alt="user img">';
                                        }
                                        ?>
                                    </span>
                                </li>

                                <?php
                            }
                            ?>

                        </ul>
                    </div>

                    <?php if ($user_id == $project->user_id) { ?>
                        <div class="act_task new_invite_cls"><a  href="<?php echo HTTP_PATH; ?>board/invite/<?php echo $project->slug; ?>"><i class="fa fa-user" aria-hidden="true"></i>Invite Users </a></div>
                    <?php } ?>
                    <!--                    onclick="showInviteUserSection();"-->
                    <div class="invite_pop_up copy_boardd_show " id="invite_pop_up" style="display:none; left: 1%; margin-top: 100  px;">
                        <div class="copy_heading_task copy_heading_board">
                            <div class="copy_heading_task_one copy_heading_board_one">Update Project Info</div>
                            <div class="copy_heading_task_two copy_heading_board_two"><button type="button" onclick="hideEditProjectInfo();" class="close_new" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                        </div>
                        <div class="copy_content_task invite_user_inner edi_pinfo" id="invite_user_inner">
                            <div class="loaderr">{{ Html::image('public/img/loading.gif','search',array('class'=>"")) }}</div> 

                            {{ Form::open(array('id' => 'projectinfo', 'files' => true,'class'=>"")) }}
                            <div class="textarea">
                                <?php
                                global $transactionTypeArray;
                                $array_transaction = array();
                                $transactions = DB::table('transactions')
                                        ->where('status', 1)
                                        ->orderby('type', 'ASC')
                                        ->get();
                                foreach ($transactions as $transaction) {
                                    $array_transaction[$transaction->id] = ucwords($transaction->type);
                                }
                                ?>
                                <label>Transaction</label>
                                {{Form::select('transaction', [null=>'Select Transaction'] + $transactionTypeArray,$project->transaction,array('class'=>'required form-control','id'=>'transaction'))}}
                                <div id="suggesstion-box"></div>
                            </div>
                            <div class="textarea">
                                <label>Transaction Amount</label>
                                {{ Form::text('transaction_amount', $project->transaction_amount, array('min' => 1, 'class' => 'required form-control ',"placeholder"=>"Transaction Amount", "id" => 'transaction_amount')) }}
                                <div id="suggesstion-box"></div>
                            </div>
                            <div class="textarea">
                                {{ Html::decode(Form::label('transaction_type', "Select Transaction Type<span class='require'>*</span>",array('class'=>""))) }}

                                {{Form::select('transaction_type', [null=>'Select Transaction Type'] + $array_transaction,$project->transaction_type,array('class'=>'required form-control','id'=>'transaction_type'))}}

                            </div>


                            <input type="hidden" id="" name="project_id" value="<?php echo $project->id ?>">

                            <div class="submit_new_btn new_sud_new">
                                <input type="button" class="submit_new" name="copy board" id="send_invite" value="Update Info" onclick="editProjectInfo();"/>
                            </div> 
                            {{ Form::close() }}
                        </div>
                    </div>

                    <div class="act_task new_act_task edi_opt_dvv"><a href="javascript:void();"><i class="fa fa-info-circle" aria-hidden="true"></i>Project Info</a>

                        <p class="pull-right edi_opt_"> 
                            <a  onclick="showInviteUserSection();" href="javascript:void(0);"><i class="fa fa-pencil" aria-hidden="true"></i>Edit </a>
                        </p>
                    </div>

                    <div class="project_info" id="update_edit_info_sec">

                        @include('Boardsfront/ajax_project_info')


                    </div>

                    <div class="act_task"><a href="javascript:void();"><i class="fa fa-align-center" aria-hidden="true"></i>Activity</a></div>

                    <div class="activity_inner_update">


                    </div>


                </div>
            </div>
        </div>

        <div class="space spacce_">
            <div class="container1 two_part3" id="containerDt">
                @include('Boardsfront/ajax_index')
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $(function () {
            updateAllActivity(<?php echo $project->id ?>);  
            //setInterval(getBoardContent, 10000);
        });
    });
   
    
    function updateAllActivity(id) {
        var data = { id: id };
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>board/updateActivity',
            data: data,
            beforeSend: function () {
            },
            success: function (result) {
                $(".activity_inner_update").html(result);
            }
        });
    }
    
    
    function getBoardContent() {
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>board/content/<?php echo $project->slug ?>',
            data: {},
            beforeSend: function () {
            },
            success: function (result) {
                $("#containerDt").html(result);
                $( ".task-items").sortable('refresh');
                $( ".containerdf").sortable('refresh');
            }
        });
    }
    
    
    jQuery(document).ready(function(){
   
        
        jQuery('.reset_form').click(function(){
            window.location.href= '<?php echo HTTP_PATH; ?>admin/projects/list'; 
        
        });
    
    });


    function saveData(id) {
        if ($.trim($('#add_task_name' + id).val()) == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("You can't add a blank task.");
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>board/saveAdminProjectTask/',
                data: $('#addtask' + id).serialize(),
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    $('html, body').css("cursor", "auto");
                    hideAddTaskSection(id);
                    $("#add_task_name"+id).val('');
                    $("#task-ul"+id).append(result);
                    $( ".task-items").sortable('refresh');
                    
                    updateAllActivity(<?php echo $project->id ?>);   
                    
                    
                    // $( ".task-items li :nth-child").append(result);
                    
                    
                    //                    $("#comment_loader" + id).hide();
                    //                    $("#postcomm" + id).show();
                    //                    $('#txtara_comm' + id).val('');
                    //                    //$('.precommsect' + id).append(result).fadeIn(5000);
                    //                    $(result).hide().appendTo('.precommsect' + id).fadeIn(1000);
                }
            });
        }
    }
    
    
    function updateData(id) {
        
        if ($.trim($('#edit_task_name' + id).val()) == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("You can't add a blank task.");
            hideEditTaskSection(id);
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>board/updateAdminProjectTask/',
                data: $('#edittask' + id).serialize(),
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    $('html, body').css("cursor", "auto");
                    $('.edit_show').hide();
                    if(result == 1){
                        var dtt = $.trim($('#edit_task_name' + id).val());
                        $('#test_name_data' + id).html(dtt);
                        hideEditTaskSection(id);
                    }else{
                        hideEditTaskSection(id);
                    }
                },
                error: function(){
                    $('html, body').css("cursor", "auto");
                    hideEditTaskSection(id);
                }
            });
        }
    }
    
    function updateBoardData(id) {
        
        if ($.trim($('#edit_board_name' + id).val()) == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("You can't update board with blank name.");
            hideEditBoardSection(id);
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>board/updateAdminProjectBoard/',
                data: $('#editboard' + id).serialize(),
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    if(result == 1){
                        $('html, body').css("cursor", "auto");
                        var dtt = $.trim($('#edit_board_name' + id).val());
                        $('#test_name_board_data' + id).html(dtt);
                        hideEditBoardSection(id);
                    }else{
                        hideEditBoardSection(id);
                    }
                },
                error: function(){
                    hideEditBoardSection(id);
                }
            });
        }
    }
    
    
    function showAddTaskSection(id) {
        $('#task_comment_section'+id).show();
        $('#task_add_section'+id).hide();
    }
    
    function hideAddTaskSection(id) {
        $('#task_comment_section'+id).hide();
        $('#task_add_section'+id).show();
    }
    
    
    function showEditTaskSection(id) {
        $('#task_content_show'+id).hide();
        $('#task_content_edit'+id).show();
        $('#edit_task_name'+id).focus();
    }
    
    function hideEditTaskSection(id) {
        $('#task_content_show'+id).show();
        $('#task_content_edit'+id).hide();
    }
    
    function showEditBoardSection(id) {
        $('#board_content_show'+id).hide();
        $('#board_content_edit'+id).show();
        $('#edit_board_name'+id).focus();
    }
    
    function hideEditBoardSection(id) {
        $('#board_content_show'+id).show();
        $('#board_content_edit'+id).hide();
    }
    
    function hideBoardSection() {
        $(".overlay").removeClass('open');
        $(".add-board-form-title").removeClass('active');
        $("#add_board_form").removeClass('active');
        $(".grab-board-form-title").removeClass('active');
        $("#grab_board_form").removeClass('active');
    }
    
    function deleteTaskSection(id, slug) {
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
                    url: '<?php echo HTTP_PATH; ?>board/deleteAdminProjectTask/',
                    data: data,
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");

                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        if(result == 1){
                            $("#task_li_section" + id).fadeOut(1000);
                            updateAllActivity(<?php echo $project->id ?>);   
                        }else{
                            alert("An Error Occurred")
                        }
                    
                    }
                });
            }
        }
    }
    function deleteBoardSection(id, slug) {
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
                    url: '<?php echo HTTP_PATH; ?>board/deleteAdminProjectBoard/',
                    data: data,
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");
                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        if(result == 1){
                            $("#board_" + id).fadeOut(1000);
                            updateAllActivity(<?php echo $project->id ?>);   
                        }else{
                            alert("An Error Occurred")
                        }
                    
                    }
                });
            }
        }
    }
    
    
    function openTaskFormDetailSection(id){
        $(".overlay").addClass('open');
        $(".add-board-form-title").addClass('active');
        $("#add_board_form").addClass('active');
    }
    
 
    
    function getProjectBoards(id, task_id) {
        var data = {
            id: id,
            task_id: task_id,
        };            
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>board/getAdminUserProjects',
            data: data,
            beforeSend: function () {
                $('html, body').css("cursor", "wait");

            },
            success: function (result) {
                $('html, body').css("cursor", "auto");
                if(result){
                    $("#copy_task_board_section" + task_id).html(result);
                }
                    
            }
        });
    }
    
    
    function getBoardTasks(id, task_id) {
        var data = {
            id: id,
            task_id: task_id,
        };            
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>board/getAdminUserTaskPosition',
            data: data,
            beforeSend: function () {
                $('html, body').css("cursor", "wait");
            },
            success: function (result) {
                $('html, body').css("cursor", "auto");
                if(result){
                    $("#copy_task_position_section" + task_id).html(result);
                }
                    
            }
        });
    }
    
    function copyTaskData(id) {
        if ($.trim($('#projectt_id' + id).val()) == '' || $.trim($('#boardd_id' + id).val()) == '' || $.trim($('#position' + id).val()) == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("Please select project, board and task position before submitting.");
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>board/copyAdminProjectTask/',
                data: $('#copytask' + id).serialize(),
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    $('html, body').css("cursor", "auto");
                    var valll = $('#boardd_id' + id).val();
                    $('.copy_taskk_show').hide();
                    $('.edit_show').hide();
                    $('#projectt_id' + id).val('');
                    $('#boardd_id' + id).empty();
                    //$('#boardd_id' + id).val('');
                    $('#position' + id).empty('');
                    //$('#position' + id).val('');
                    $("#board_"+valll).html(result);
                }
            });
        }
    }
    

    
    function getProjectMoveBoards(id, task_id) {
        var data = {
            id: id,
            task_id: task_id,
        };            
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>board/getAdminUserMoveProjects',
            data: data,
            beforeSend: function () {
                $('html, body').css("cursor", "wait");

            },
            success: function (result) {
                $('html, body').css("cursor", "auto");
                if(result){
                    $("#move_task_board_section" + task_id).html(result);
                }
                    
            }
        });
    }
    
    
    function getBoardMoveTasks(id, task_id) {
        var data = {
            id: id,
            task_id: task_id,
        };            
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>board/getAdminUserMoveTaskPosition',
            data: data,
            beforeSend: function () {
                $('html, body').css("cursor", "wait");
            },
            success: function (result) {
                $('html, body').css("cursor", "auto");
                if(result){
                    $("#move_task_position_section" + task_id).html(result);
                }
                    
            }
        });
    }
    
    
    function moveTaskData(id) {
        if ($.trim($('#move_projectt_id' + id).val()) == '' || $.trim($('#move_boardd_id' + id).val()) == '' || $.trim($('#move_position' + id).val()) == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("Please select project, board and task position before submitting.");
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>board/moveAdminProjectTask/',
                data: $('#movetask' + id).serialize(),
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    $('html, body').css("cursor", "auto");
                    var valll = $('#move_boardd_id' + id).val();
                    $('.move_taskk_show').hide();
                    $('.copy_taskk_show').hide();
                    $('.edit_show').hide();
                    $('#move_projectt_id' + id).val('');
                    $('#move_boardd_id' + id).empty();
                    $('#move_position' + id).empty();
                    $('#task_li_section' + id).remove();
                    
                    
                    $("#board_"+valll).html(result);
                }
            });
        }
    }
    
    
    

    
    function getPositionForCopyBoard(id, board_id) {
        var data = {
            id: id,
            board_id: board_id,
        };            
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>board/getAdminUserMoveBoardPositionForCopy',
            data: data,
            beforeSend: function () {
                $('html, body').css("cursor", "wait");

            },
            success: function (result) {
                $('html, body').css("cursor", "auto");
                if(result){
                    $("#copy_board_position_section" + board_id).html(result);
                }
                    
            }
        });
    }
    
    
    function copyBoardData(id) {
        if ($.trim($('#board_projectt_id' + id).val()) == '' || $.trim($('#board_position' + id).val()) == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("Please select project, board position before submitting.");
            return;
        }else if($.trim($('#copy_boardd_name_dt' + id).val()) == ''){
            alert("Please enter board name.");
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>board/copyAdminProjectBoard/',
                data: $('#copyboard' + id).serialize(),
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    $('html, body').css("cursor", "auto");
                    var valll = $('#board_position' + id).val();
                    var valllPro = $('#board_projectt_id' + id).val();
                    var valllOld = $('#old_project_id' + id).val();
                    $('.copy_taskk_show').hide();
                    $('.copy_boardd_show').hide();
                    $('.edit_show').hide();
                    $('#board_projectt_id' + id).val('');
                    $('#board_position' + id).val('');
                    //$("#board_"+valll).html(result);
                    //alert(result);
                    var valllnn = valll - 1;
                    
                    if(valllPro == valllOld){
                        if($('#boards_container').find('.board-wrap:eq(' + valllnn + ')').html() === undefined){
                            $('#boards_container').append(result);
                        }else{
                            $('#boards_container').find('.board-wrap:eq(' + valllnn + ')').before(result);
                        }
                         
                    }
                }
            });
        }
    }
    
    

    
    
    function getPositionForMoveBoard(id, board_id) {
        var data = {
            id: id,
            board_id: board_id,
        };            
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>board/getAdminUserMoveBoardPositionForMove',
            data: data,
            beforeSend: function () {
                $('html, body').css("cursor", "wait");

            },
            success: function (result) {
                $('html, body').css("cursor", "auto");
                if(result){
                    $("#move_board_position_section" + board_id).html(result);
                }
                    
            }
        });
    }
    
    function moveBoardData(id) {
        if ($.trim($('#move_board_projectt_id' + id).val()) == '' || $.trim($('#move_board_position' + id).val()) == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("Please select project, board position before submitting.");
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>board/moveAdminProjectBoard/',
                data: $('#moveboard' + id).serialize(),
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    $('html, body').css("cursor", "auto");
                    var valll = $('#move_board_position' + id).val();
                    var valllPro = $('#move_board_projectt_id' + id).val();
                    var valllOld = $('#move_old_project_id' + id).val();
                    $('.move_taskk_show').hide();
                    $('.move_boardd_show').hide();
                    $('.edit_show').hide();
                    $('#move_board_projectt_id' + id).val('');
                    $('#move_board_position' + id).val('');
                    //$("#board_"+valll).html(result);
                    //alert(result);
                    var valllnn = valll - 1;
                    
                    //alert(valllnn);
                    
                    if(valllPro == valllOld){
                        if($('#boards_container').find('.board-wrap:eq(' + valllnn + ')').html() === undefined){
                            alert('dasd');
                            $('#boards_container').append(result);
                            $("#board_" + id).remove();
                        }else{
                            $('#boards_container').find('.board-wrap:eq(' + valllnn + ')').before(result);
                            $("#board_" + id).remove();
                        }
                    }else{
                        $("#board_" + id).remove();
                    }
                }
            });
        }
    }
    
    
    
    function showMoveBoardSection(id) {
        //$( "#task_li_section"+id ).wrap( "<div class='new_li_parent'></div>" );
        $('.edit_show').hide();
        $('.move_boardd_show').hide();
        $('.copy_boardd_show').hide();
        $('.move_taskk_show').hide();
        $('.copy_taskk_show').hide();
        $('#move_boardd_show'+id).show();
        hideCopyBoardSection(id);
    }
    
    function hideMoveBoardSection(id) {
        $('#move_boardd_show'+id).hide();
    }
    
    function showCopyBoardSection(id) {
        $('.edit_show').hide();
        //$( "#task_li_section"+id ).wrap( "<div class='new_li_parent'></div>" );
        $('.copy_taskk_show').hide();
        $('.move_taskk_show').hide();
        $('.copy_boardd_show').hide();
        $('.move_boardd_show').hide();
        $('#copy_boardd_show'+id).show();
        hideMoveBoardSection(id);
    }
    
    function hideCopyBoardSection(id) {
        $('#copy_boardd_show'+id).hide();
        
    }
    
       
    function showBoardTaskMenu(id) {
        $('.edit_show').hide();
        $('.copy_taskk_show').hide();
        $('.move_boardd_show').hide();
        $('.copy_boardd_show').hide();
        $('.copy_taskk_show').hide();
        $('.move_taskk_show').hide();
        $('#task_menuu_show'+id).show();
    }
    
    function closeBoardTaskMenu(id) {
        $('.copy_taskk_show').hide();
        $('.move_taskk_show').hide();
        $('#task_menuu_show'+id).hide();
    }
    
    function showCopyTaskSection(id) {
        //$( "#task_li_section"+id ).wrap( "<div class='new_li_parent'></div>" );
        hideMoveTaskSection(id)
        $('.move_taskk_show').hide();
        $('.copy_taskk_show').hide();
        $('.move_boardd_show').hide();
        $('.copy_boardd_show').hide();
        $('#copy_taskk_show'+id).show();
    }
    
    function hideCopyTaskSection(id) {
        $('#copy_taskk_show'+id).hide();
    }
    
           
    function showMoveTaskSection(id) {
        //$( "#task_li_section"+id ).wrap( "<div class='new_li_parent'></div>" );
        hideCopyTaskSection(id)
        $('.move_taskk_show').hide();
        $('.copy_taskk_show').hide();
        $('#move_taskk_show'+id).show();
    }
    
    function hideMoveTaskSection(id) {
        $('#move_taskk_show'+id).hide();
    }
    
    
    
    function showEditProjectSection(id) {
        $('#project_content_edit'+id).show();
        $('#edit_project_name'+id).focus();
    }
    
    function hideEditProjectSection(id) {
        $('#project_content_edit'+id).hide();
    }
    
    function updateProjectData(id) {
        
        if ($.trim($('#edit_project_name' + id).val()) == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("You can't update project with blank name.");
            hideEditProjectSection(id);
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo HTTP_PATH; ?>board/updateAdminProjectSection/',
                data: $('#projectboard' + id).serialize(),
                beforeSend: function () {
                    $('html, body').css("cursor", "wait");
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    if(result == 1){
                        $('html, body').css("cursor", "auto");
                        var dtt = $.trim($('#edit_project_name' + id).val());
                        $('#test_name_project_data' + id).html(dtt);
                        hideEditProjectSection(id);
                    }else{
                        hideEditProjectSection(id);
                    }
                },
                error: function(){
                    hideEditProjectSection(id);
                }
            });
        }
    }
    
    
    
    function showInviteUserSection() {
        $('#invite_pop_up').show();
    }
    
    function hideInviteUserSection() {
        $('#invite_pop_up').hide();
    }
    
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    };
    
    function sendInvite() {
        var email = $.trim($('#search-box').val());
        if (email == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("Please enter an email before submitting.");
            return;
        }else if(email != ''){
            var res = email.split(",");
            res.forEach(function(mail) {
                var maill = mail.trim()
                //alert(maill);
                if(!isValidEmailAddress(maill)){
                    alert("Please enter an valid emails address before submitting.");
                    return;
                }
            });
        }
            
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>board/sendInvite/',
            data: $('#inviteuser').serialize(),
            beforeSend: function () {
                $('html, body').css("cursor", "wait");
            },
            success: function (result) {
                $('html, body').css("cursor", "auto");
                $("#search-box").val('');
                hideInviteUserSection();
                alert(result);
            }
        });
        
    }
    
    
    function showEditProjectInfo() {
        $('#invite_pop_up').show();
    }
    
    function hideEditProjectInfo() {
        $('#invite_pop_up').hide();
    }
    
    function editProjectInfo() {
        var tr = $.trim($('#transaction').val());
        var tr_am = $.trim($('#transaction_amount').val());
        var tr_ty = $.trim($('#transaction_type').val());
        if (tr == '') {
            alert("Please select transaction.");
            return;
        }else if(tr_am == ''){
            alert("Please fill transaction amount.");
            return;
        }else if(tr_am < 0){
            alert("Please fill transaction amount greate than 0.");
            return;
        }else if(tr_ty == ''){
            alert("Please select transaction type.");
            return;
        }
        
        // alert($('#projectinfo').serialize());
            
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>board/updateProjectInfo/',
            data: $('#projectinfo').serialize(),
            beforeSend: function () {
                $('html, body').css("cursor", "wait");
            },
            success: function (result) {
                $('html, body').css("cursor", "auto");
                $("#search-box").val('');
                hideEditProjectInfo();
                if(result != 2){
                    $("#update_edit_info_sec").html(result);
                }
            }
        });
        
    }
    
    
    
    
    
    

</script>
<script type="text/javascript">
    $(document).ready(function() { 
        $('.showhidemenu').click(function() {
            $(".slidedivmenu").toggleClass('active_show')   
        });
        $('.close_menu').click(function() {
            $(".slidedivmenu").removeClass('active_show')   
        });
        
        
        $("#search-box").keyup(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo HTTP_PATH; ?>board/getEmailListOfSite/',
                data:'keyword='+$(this).val()+'&prj_id=<?php echo $project->id ?>',
                beforeSend: function(){
                    //$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
                },
                success: function(data){
                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(data);
                    //$("#search-box").css("background","#FFF");
                }
            });
        });
    });
    
    function selectEmail(val) {
        $("#search-box").val(val);
        $("#suggesstion-box").hide();
    }
    

    
    function removeInvitedUser(user_id, project_id) {
        var cnfrmm = confirm("Are you sure, You Want to delete?");
        if (cnfrmm) {
        
            if (user_id == '' || project_id == "") {
                alert("Invalid Request");
                return;
            } else {
                var data = {
                    user_id: user_id,
                    project_id: project_id
                };
            
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>board/removeInvitedUser/',
                    data: data,
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");

                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        if(result == 1){
                            $("#inv_user_" + user_id).fadeOut(1000);
                        }else{
                            alert("An Error Occurred")
                        }
                    
                    }
                });
            }
        }
    }
    
    
    $(document).ready(function () {
        setInterval(function(){ 
            updateAllActivity(<?php echo $project->id ?>);   
        }, 2000);
        
    });
</script>
@stop

