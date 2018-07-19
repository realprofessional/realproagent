@section('title', ''.TITLE_FOR_PAGES.'User List')
@extends('layouts/default_front_project')
@section('content')
<!--<script src="{{ URL::asset('public/assets/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>-->
<script src="{{ URL::asset('public/js/datepicker/jquery-ui.js') }}"></script>
{{ Html::style('public/js/datepicker/jquery-ui.css'); }}

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

<div class="acc_deack_new_ sdfwe">
    <div class="wrapper_new">
        <div class="df_ty">
            <nav class="breadcrumbs">
                <div class="container1">
                    <ul>
                        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>account">Account</a></li>
                        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>projectboard/projects">My Transactions</a></li>
                        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>board/{{$project->slug}}">Boards</a></li>
                        <li class="breadcrumbs__item">{{ $project->project_name }}</li>
                    </ul>
                </div>
            </nav>
            <div class="dd_showmenu"><a href="javascript:void(0)" class="showhidemenu">Show Menu</a>
                <div class="dd_shomenus slidedivmenu">
                    <div class="activity_menu">Menu</div>
                    <div class="close_menu">{{ Html::image('public/img/front/cancel-music.svg','search',array('class'=>"")) }}</div>
                    <div class="act_task"><a href="#"><i class="fa fa-align-center" aria-hidden="true"></i>Activity</a></div>

                    <div class="activity_inner_update">

                        <div class="tast_li_">
                            <div class="task_title_">MJ</div>
                            <div class="men_activity"><span>Madan Jangid</span> added Checklist to <a href="#">sdfsdf</a>

                                <p><a href="#">Jul 25 at 5:33 PM</a></p></div>
                        </div>

                    </div>

                    <!--                    <div class="tast_li_">
                                            <div class="task_title_">MJ</div>
                                            <div class="men_activity"><span>Madan Jangid</span> added Checklist to <a href="#">sdfsdf</a>
                    
                                                <p><a href="#">Jul 25 at 5:33 PM</a></p></div>
                                        </div>
                                        
                                        <div class="tast_li_">
                                            <div class="task_title_">MJ</div>
                                            <div class="men_activity"><span>Madan Jangid</span> added Checklist to <a href="#">sdfsdf</a>
                    
                                                <p><a href="#">Jul 25 at 5:33 PM</a></p></div>
                                        </div>
                                        
                                        <div class="tast_li_">
                                            <div class="task_title_">MJ</div>
                                            <div class="men_activity"><span>Madan Jangid</span> added Checklist to <a href="#">sdfsdf</a>
                    
                                                <p><a href="#">Jul 25 at 5:33 PM</a></p></div>
                                        </div>
                                        
                                        <div class="tast_li_">
                                            <div class="task_title_">MJ</div>
                                            <div class="men_activity"><span>Madan Jangid</span> added Checklist to <a href="#">sdfsdf</a>
                    
                                                <p><a href="#">Jul 25 at 5:33 PM</a></p></div>
                                        </div>-->
                </div>
            </div>
        </div>

        <div class="space spacce_">
            <div class="container1 two_part3">
                @include('Boardsfront/default_boards')
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $(function () {
            updateAllActivity(<?php echo $project->id ?>);   
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
    
    
    jQuery(document).ready(function(){
    
        jQuery(function () {
            updateAllActivity(<?php echo $project->id ?>);   
        });
        
        jQuery('.reset_form').click(function(){
            window.location.href= '<?php echo HTTP_PATH; ?>admin/projects/list'; 
        
        });
    
    });


    
    
    

</script>
<script type="text/javascript">
    $(document).ready(function() { 
        $('.showhidemenu').click(function() {
            $(".slidedivmenu").toggleClass('active_show')   
        });
        $('.close_menu').click(function() {
            $(".slidedivmenu").removeClass('active_show')   
        });
    });
</script>
@stop

