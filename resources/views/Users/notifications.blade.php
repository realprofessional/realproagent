<?php ?>
@section('title', ''.TITLE_FOR_PAGES.' Notification List')
@extends('layouts/default_front_project')
@section('content')

<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.validator.addMethod("pass", function(value, element) {
            return  this.optional(element) || (/.{8,}/.test(value) && /([0-9].*[a-z])|([a-z].*[0-9])/.test(value));
        }, "Password minimum length must be 8 characters and contain atleast 1 number.");
        $.validator.addMethod("contact", function(value, element) {
            return  this.optional(element) || (/^[0-9-]+$/.test(value));
        }, "Contact Number is not valid.");
        $.validator.addMethod("noSpace", function(value, element) { 
            return value.indexOf(" ") < 0 && value != ""; 
        }, "No space allowed.");
        $("#profile-edit-form").validate({
            rules: {
                account_type: {
                    required: true
                },
                contact: {
                    required: true,
                    maxlength: 16
                    
                }
            }
        });
    });
</script>

{{ Html::script('public/js/front/jquery.bpopup.js') }}

<div class="acc_deack">
    <div class="wrapper">
        <nav class="breadcrumbs">
            <div class="container">
                <ul>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>">Home</a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>account">Account</a></li>
                    <li class="breadcrumbs__item">Edit Profile</li>

                </ul>
            </div>
        </nav>
        <div class="space">

            <div class="panel-body"><div class="container">

                    @include('elements/user_account_sidebar')
                    <div class="main_container">
                        <div class="widget__header">
                            <h1 class="widget__title">Notifications</h1> 
                        </div>     

                        <div class="profile">
                            <div class="fillter_form">     
                                <?php
                                if (!$notifications->isEmpty()) {
                                    ?>

                                    {{ Form::open(array('url' => 'users/notifications', 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"form-inline form")) }}
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <section class="panel">
                                                <header class="panel-heading">

                                                </header>
                                                <div class="form_fillter_body">
                                                    <section id="no-more-tables" class="notification_bx">
                                                        <table class="table table-bordered table-striped table-condensed cf notification-table">
                                                            <thead class="cf">
                                                                <tr>

                                                                    <th> Notification</th>
                                                                    <th>@sortablelink('created', 'Created')</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;
                                                                foreach ($notifications as $type) {
                                                                   // echo "<pre>"; print_r($type);
                                                                    
                                                                    if ($i % 2 == 0) {
                                                                        $class = 'colr1';
                                                                    } else {
                                                                        $class = '';
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td data-title="Notification">
                                                                            <?php //
                                                                         /*   if ($type->project_id != 0) {
                                                                                $project = DB::table('projects')
                                                                                        ->where('projects.id', $type->project_id)
                                                                                        ->first();
                                                                            }

                                                                            if ($type->board_id != 0) {
                                                                                $boardd = DB::table('boards')
                                                                                        ->join('projects', 'projects.id', '=', 'boards.project_id')
                                                                                        ->where('boards.id', $type->board_id)
                                                                                        ->select('boards.*', 'projects.project_name as project_name', 'projects.slug as project_slug')
                                                                                        ->first();
                                                                            }
                                                                            if ($type->task_id != 0) {
                                                                                $taskk = DB::table('tasks')
                                                                                        ->where('tasks.id', $type->task_id)
                                                                                        ->first();
                                                                            }
*/
//                                                                             echo "<pre>";     print_r($type);die;


                                                                            switch ($type->type) {
                                                                                case "memeber_mention":
                                                                                    echo "<a href=" . HTTP_PATH . "board/" . $type->project_slug . ">You have been mentioned on a Task <b>" . $type->task_name . "</b> under board <b>" . $type->board_name . "</b>  </a>";
                                                                                    break;
                                                                                case "membor_invite":
                                                                                    echo "<a href=" . $type->url . ">You have been invited to a project. Please go on this link link to Join.</a>";
                                                                                    break;
                                                                                case "add_board":
                                                                                    echo "<a href=" . HTTP_PATH . "board/" . $type->project_slug . ">A Board <b>" . $type->board_name . "</b> has been added into project <b>" . $type->project_name . "</b>.</a>";
                                                                                    break;
                                                                                case "delete_board":
                                                                                    echo "<a href=" . HTTP_PATH . "board/" . $type->project_slug . ">A Board has been deleted from project <b>" . $type->project_name . "</b>.</a>";
                                                                                    break;
                                                                                case "add_task":
                                                                                    echo "<a href=" . HTTP_PATH . "board/" . $type->project_slug . "/" .$type->board_slug . "/" . $type->task_slug .">A Task <b>" . $type->task_name . "</b> has been added under board <b>" . $type->board_name . "</b> to project <b>" . $type->project_name . "</b>.</a>";
                                                                                    break;
                                                                                case "delete_task":
                                                                                    echo "<a href=" . HTTP_PATH . "board/" . $type->project_slug . ">A Task has been deleted under board <b>" . $type->board_name . "</b> from project <b>" . $type->project_name . "</b>.</a>";
                                                                                    break;
                                                                                case "add_comment":
                                                                                    echo "<a href=" . HTTP_PATH . "board/" . $type->project_slug . "/" . $type->board_slug . "/" . $type->task_slug . ">A Comment has been added in Task <b>" . $type->task_name . "</b> under board <b>" . $type->board_name . "</b> to project <b>" . $type->project_name . "</b>.</a>";
                                                                                    break;
                                                                                default:
                                                                                    echo "";
                                                                            }
                                                                            ?> 
                                                                        </td>


                                                                        <td data-title="Created">
                                                                            {{  date("d M, Y h:i A", strtotime($type->created)) }}</td>



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


                                                <div class="dataTables_paginate paging_bootstrap pagination custom_stye_pagination">
                                                    <?php
                                                    $pageination = $notifications->perPage();
                                                    if ($pageination > $notifications->total()) {
                                                        $pageination = $notifications->total();
                                                    }

                                                    $count = $pageination;
                                                    $main_count = 1;
                                                    $counts = $notifications->total() - $notifications->count();
                                                    $count = ($notifications->total() - $counts) + $count;

                                                    if (isset($_REQUEST['page']) && $_REQUEST['page'] != '') {

                                                        if ($_REQUEST['page'] == '1') {
                                                            $count = $pageination;
                                                            $main_count = 1;
                                                        } else {

                                                            $main_count = ($_REQUEST['page'] - 1) * $notifications->perPage() + 1;
                                                            $count = ($_REQUEST['page'] - 1) * $notifications->perPage() + $pageination;
                                                            $count = $notifications->perPage() * $_REQUEST['page'];
                                                            if ($count > $notifications->total()) {

                                                                $count = $notifications->total();
                                                            }
                                                        }
                                                    } else {

                                                        $count = $pageination;
                                                    }
                                                    ?>
                                                    <div class="left_shift_area">No. of Records {{$main_count}} - {{$count}} of {{$notifications->total()}}</div>
                                                    <div class="pagination_area">    {{ $notifications->appends(Input::except('page'))->render() }}</div>
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

                                                <div class="panel-body">
                                                    <section id="no-more-tables">There are no notifications.</section>
                                                </div>
                                            </section>
                                        </div>
                                    </div>  
                                <?php }
                                ?></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //echo "sdaasdasd"; exit;  ?>

@stop









