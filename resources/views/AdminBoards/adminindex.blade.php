@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Admin Board List')
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
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/adminboards/project', '<i class="fa fa-random"></i> Admin Projects' , array('id' => ''), true)) }}
                    </li>
                    <li>
                        <i class="fa fa-list"></i> Admin Boards
                    </li>
                    <li class="active">Admin Board List</li>
                </ul>
               <!--  <section class="panel">
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
            @include('AdminBoards/ajax_index')
        </div>
    </section>
</section>

<script>
    jQuery(document).ready(function(){
    
        jQuery('.reset_form').click(function(){
        
            window.location.href= '<?php echo HTTP_PATH; ?>admin/user/userlist'; 
        
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
                url: '<?php echo HTTP_PATH; ?>ajax/saveAdminTask/',
                data: $('#addtask' + id).serialize(),
                beforeSend: function () {
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    hideAddTaskSection(id);
                    $("#task-ul"+id).append(result);
                    $('#add_task_name' + id).val('');
                    
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
                url: '<?php echo HTTP_PATH; ?>ajax/updateAdminTask/',
                data: $('#edittask' + id).serialize(),
                beforeSend: function () {
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    if(result == 1){
                        var dtt = $.trim($('#edit_task_name' + id).val());
                        $('#test_name_data' + id).html(dtt);
                        hideEditTaskSection(id);
                    }else{
                        hideEditTaskSection(id);
                    }
                },
                error: function(){
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
                url: '<?php echo HTTP_PATH; ?>ajax/updateAdminBoard/',
                data: $('#editboard' + id).serialize(),
                beforeSend: function () {
                    //                    $("#comment_loader" + id).show();
                    //                    $("#postcomm" + id).hide();
                },
                success: function (result) {
                    if(result == 1){
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
        closeBoardTaskMenu(id);
        //$('#task_menuu_show'+id).show();

        
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
                    url: '<?php echo HTTP_PATH; ?>ajax/deleteAdminTask/',
                    data: data,
                    beforeSend: function () {

                    },
                    success: function (result) {
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
                    url: '<?php echo HTTP_PATH; ?>ajax/deleteAdminBoard/',
                    data: data,
                    beforeSend: function () {

                    },
                    success: function (result) {
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
    
    
       
    function showBoardTaskMenu(id) {
        $('.edit_show').hide();
        $('#task_menuu_show'+id).show();
    }
    
    function closeBoardTaskMenu(id) {
        $('#task_menuu_show'+id).hide();
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
                url: '<?php echo HTTP_PATH; ?>adminboards/updateAdminProjectSection/',
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
                        $('#test_name_project_data' + id).html("Edit Project "+dtt);
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


</script>
@stop
