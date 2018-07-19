@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'User List')
@extends('layouts/adminlayout')
@section('content')
<!--<script src="{{ URL::asset('public/assets/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>-->
<script src="{{ URL::asset('public/js/datepicker/jquery-ui.js') }}"></script>
<script src="{{ URL::asset('public/js/datepicker/jquery.timepicker.min.js') }}"></script>
{{ Html::style('public/js/datepicker/jquery-ui.css'); }}
{{ Html::style('public/js/datepicker/jquery.timepicker.css'); }}

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

{{ Html::style('public/css/style_drag.css'); }}
<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>
<!--<script src="{{ URL::asset('public/js/script_drag.js') }}"></script>-->


<script src="{{ URL::asset('public/js/facebox.js') }}"></script>
{{ Html::style('public/css/facebox.css'); }}


<!--<script
    src="https://code.jquery.com/jquery-1.9.0.min.js"
    integrity="sha256-f6DVw/U4x2+HjgEqw5BZf67Kq/5vudRZuRkljnbF344="
crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.js" type="text/javascript"></script>-->

<style>
    /* NZ Web Hosting - www.nzwhost.com 
     * Fieldset Alternative Demo
    */
    .popup {
        width: 800px;
    }
    
    
     .tilt.right {
        transform: rotate(3deg);
        -moz-transform: rotate(3deg);
        -webkit-transform: rotate(3deg);
    }
    .tilt.left {
        transform: rotate(-3deg);
        -moz-transform: rotate(-3deg);
        -webkit-transform: rotate(-3deg);
    }

</style>


<script>
    
    $(document).ready(function ($) {
        
        $('.close_image').hide();
        $('a[rel*=facebox]').facebox({
            loadingImage: "<?php echo HTTP_PATH; ?>public/img/loading.gif",
            closeImage: "<?php echo HTTP_PATH; ?>public/img/close.png"
        });
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
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <ul id="breadcrumb" class="breadcrumb">
                    <li>
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/admindashboard', '<i class="fa fa-dashboard"></i> Dashboard' , array('id' => ''), true)) }}
                    </li>
                    <li>
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/projects/list', '<i class="fa fa-tasks"></i> Projects' , array('id' => ''), true)) }}
                    </li>
                    <li>
                        <i class="fa fa-user"></i> Board
                    </li>
                    <li class="active">Board List</li>
                </ul>
             <!--   <section class="panel">
                      <header class="panel-heading">
                         Search User
                     </header>
                                        <div class="panel-body">
                                             {{ View::make('elements.actionMessage')->render() }}
                                             {{ Form::open(array('url' => 'admin/user/userlist', 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>'form-inline')) }}
                                             <div class="form-group align_box">
                                                 <label class="sr-only" for="search">Your Keyword</label>
                                                 {{ Form::text('search', $search, array('class' => 'required search_fields form-control','placeholder'=>"Your Keyword")) }}
                                             </div>
                                             <div class="form-group align_box">
                                                 <label class="" for="searchByDateFrom"> Search By Date:-  From</label>
                                                 {{ Form::text('from_date', $from_date, array('class' => 'required search_fields form-control', 'id'=>'searchByDateFrom','placeholder'=>"From")) }}
                                             </div>
                                             <div class="form-group align_box">
                                                 <label class="" for="searchByDateTo">To</label>
                                                 {{ Form::text('to_date', $to_date, array('class' => 'required search_fields form-control', 'id'=>'searchByDateTo','placeholder'=>"To")) }}
                                             </div>
                                             <span class="hint" style="margin:5px 0">Search User by typing their first name, last name and email</span>
                                             {{ Form::submit('Search', array('class' => "btn btn-success")) }}
                                             {{ Form::reset('Clear Filter', array('class' => "btn btn-success reset_form")) }}
                                             {{ Form::close() }}
                                         </div>

                </section>-->
            </div>
        </div>
        <div id="middle-content">
            @include('Boards/ajax_index')
        </div>
    </section>
</section>

<script>
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
                url: '<?php echo HTTP_PATH; ?>ajax/saveAdminProjectTask/',
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
                url: '<?php echo HTTP_PATH; ?>ajax/updateAdminProjectTask/',
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
                url: '<?php echo HTTP_PATH; ?>ajax/updateAdminProjectBoard/',
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
                    url: '<?php echo HTTP_PATH; ?>ajax/deleteAdminProjectTask/',
                    data: data,
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");

                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        if(result == 1){
                            $("#task_li_section" + id).fadeOut(1000);
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
                    url: '<?php echo HTTP_PATH; ?>ajax/deleteAdminProjectBoard/',
                    data: data,
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");
                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        if(result == 1){
                            $("#board_" + id).fadeOut(1000);
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
            url: '<?php echo HTTP_PATH; ?>ajax/getAdminUserProjects',
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
            url: '<?php echo HTTP_PATH; ?>ajax/getAdminUserTaskPosition',
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
                url: '<?php echo HTTP_PATH; ?>ajax/copyAdminProjectTask/',
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
            url: '<?php echo HTTP_PATH; ?>ajax/getAdminUserMoveProjects',
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
            url: '<?php echo HTTP_PATH; ?>ajax/getAdminUserMoveTaskPosition',
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
                url: '<?php echo HTTP_PATH; ?>ajax/moveAdminProjectTask/',
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
            url: '<?php echo HTTP_PATH; ?>ajax/getAdminUserMoveBoardPositionForCopy',
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
                url: '<?php echo HTTP_PATH; ?>ajax/copyAdminProjectBoard/',
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
    
 
    
    
    
    function getPositionForMoveBoard(id, board_id) {
        var data = {
            id: id,
            board_id: board_id,
        };            
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>ajax/getAdminUserMoveBoardPositionForMove',
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
                url: '<?php echo HTTP_PATH; ?>ajax/moveAdminProjectBoard/',
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
                            alert("adas");
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
    
    
    
    
    
    
//    function taskDragStart(id) {
//        //alert(id);
//        event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
//    }

</script>


<!--<script>
    $( ".task-items" ).sortable({
        connectWith: ".task",
        handle: ".task",
        cancel: ".portlet-toggle",
        start: function (event, ui) {
            ui.item.addClass('tilt');
            tilt_direction(ui.item);
        },
        stop: function (event, ui) {
            ui.item.removeClass("tilt");
            $("html").unbind('mousemove', ui.item.data("move_handler"));
            ui.item.removeData("move_handler");
        }
    });

    function tilt_direction(item) {
        var left_pos = item.position().left,
        move_handler = function (e) {
            if (e.pageX >= left_pos) {
                item.addClass("right");
                item.removeClass("left");
            } else {
                item.addClass("left");
                item.removeClass("right");
            }
            left_pos = e.pageX;
        };
        $("html").bind("mousemove", move_handler);
        item.data("move_handler", move_handler);
    }  

</script>-->


@stop
