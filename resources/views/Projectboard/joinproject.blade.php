@section('title', ''.TITLE_FOR_PAGES.' Invite User over Project')
@extends('layouts/default_front_project')
@section('content')

<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>
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
        $("#addproject").validate();


    });

    function createproject() {
        $('#create_popup').toggle();
    }
</script>
<?php
?>
<div class="acc_deack_new_">
    <div class="wrapper_new">
        <nav class="breadcrumbs new_bdcrubs"> 
            <div class="container">
                <ul>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>">Account</a></li>
                    <li class="breadcrumbs__item">My Transactions</li>
                </ul>
            </div>
        </nav>
        <div class="space">
            <div class="container two_part3">
                <!--<div class="main_container">-->

                <div class="widget__header">
                    <h1 class="widget__title"> Project Name : {{ $inviteData->project_name }}</h1> 
                </div>

                <div class="profile">
                    <div class="project_list">
                        <div class="projects_section">
                            <div class="project_sec new__pcc_up">
                                <div class='brd_nmm'>
                                    Board: {{ $inviteData->board_name }}
                                </div>
                                
                                <div class="project_name create_pro new__pcc">

                                    <?php
                                    if (Session::has('user_id')) {
                                        $userId = Session::get('user_id');
                                    } else {
                                        $userId = 0;
                                    }
                                    ?>
                                    <?php
                                    if ($userId == 0) {
                                        if (!empty($inviteData->user_id)) {
                                            ?>
                                            <a id="create_project" class="new_prjbtnnn" href="{{HTTP_PATH}}login?email_address={{$email}}&invid={{$inviteData->id}}"><span><i class="fa fa-plus"></i></span>Join Project Board</a>
                                        <?php } else { ?>
                                            <a id="create_project" class="new_prjbtnnn" href="{{HTTP_PATH}}signup?email_address={{$email}}&invid={{$inviteData->id}}"><span><i class="fa fa-plus"></i></span>Join Project Board</a>
                                        <?php } ?>
                                    <?php } else { ?> 
                                        <a id="create_project" class="new_prjbtnnn" href="{{HTTP_PATH}}join/{{$email}}/{{$inviteData->id}}"><span><i class="fa fa-plus"></i></span>Join Project Board</a>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>


        </div>
    </div>
</div>

@stop