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
        
        
        $.ajaxSetup(
        {
            headers:
                {
                'X-CSRF-Token': $('input[name="_token"]').val()
            }
        });
        


    });

    function createproject() {
        $('#create_popup').toggle();
    }
</script>

<script type="text/javascript">

    function sendInvite(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>board/sendInvite/',
            data: $('#inviteuser'+id).serialize(),
            beforeSend: function () {
                $('html, body').css("cursor", "wait");
            },
            success: function (result) {
                $('html, body').css("cursor", "auto");
                alert(result);
                if(result == 'Invited Successfully'){
                    window.location.href = '<?php echo HTTP_PATH; ?>board/<?php echo $project->slug; ?>'; 
                }
            }
        });
        
    }
    
    function sendInviteManual() {
        var email = $.trim($('#search-box').val());
        if (email == '') {
            //$('#txtara_comm' + id).addClass('error');
            alert("Please enter an email before submitting.");
            return;
        }else if(email != ''){
            var res = email.split(",");
            res.forEach(function(mail) {
                var maill = mail.trim()
                if(!isValidEmailAddress(maill)){
                    alert("Please enter an valid emails address before submitting.");
                    return;
                }
            });
        }
            
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>board/sendInvite/',
            data: $('#inviteusermanual').serialize(),
            beforeSend: function () {
                $('html, body').css("cursor", "wait");
            },
            success: function (result) {
                $('html, body').css("cursor", "auto");
                $("#search-box").val('');
                alert(result);
            }
        });
        
    }
    
    
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    };
    
    
</script>
<?php
if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
    $search = $_REQUEST['search'];
} else {
    $search = "";
}
?>
<?php
$user_id = Session::get('user_id');
$user = DB::table('users')
        ->where('id', $user_id)
        ->first();
?>
{{ Html::script('public/js/front/jquery.bpopup.js') }}
<div class="acc_deack_new_ user_deack_new_">
    <div class="wrapper_new">
        <nav class="breadcrumbs">
            <div class="container">
                <ul>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>">Account</a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>projectboard/projects">My Transactions</a></li>
                    <li class="breadcrumbs__item">
                        <span><a href="{{HTTP_PATH}}board/{{$project->slug}}">{{$project->project_name}}</a></span>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="space">
            <div class="container two_part3">
                <!--<div class="main_container">-->


                <div class="user_dashboards_top">
                    <div class="us_serh">

                        <div class="left_forms">
                            {{ Form::open(array('url' => 'board/agent/'.$project->slug, 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>'form-inline')) }}
                            <div class="form-group align_box">
                                <label class="" for="search">Your Keyword</label>
                                <div class="user_serch_input">
                                    {{ Form::text('search', $search, array('class' => 'required search_fields ','placeholder'=>"Your Keyword")) }}
                                </div>
                                <div class="left_sr_but">{{ Form::submit('Search', array('class' => "btn btn-success")) }}</div>
                            </div>
                            <span class="hint">Search User by typing their first name, last name and email</span>

                            {{ Form::close() }}

                        </div>

                        <div class="us_right_form">


                            <div class="us_serh_bx">
                                {{ Form::open(array('id' => 'inviteusermanual', 'files' => true,'class'=>"")) }}

                                <div class="user_serch_input">
                                    <input type="text" name="email_address" id="search-box" placeholder="Enter Email Address" autocomplete="off"/>
                                </div>
                                <div class="user_selecl">
                                    <?php global $userTypeArray; ?>

                                    <span>
                                        {{Form::select('user_type', [null=>'Select User Type'] + $userTypeArray,Input::old('user_type'),array('class'=>'','id'=>'user_type'))}}

                                    </span>
                                </div>

                                <input type="hidden" id="" name="project_id" value="<?php echo $project->id ?>">
                                <input type="hidden" id="" name="user_id" value="<?php echo $project->user_id ?>">
                                <div class="user_but"><input type="button" value="Send Invitation" onclick="sendInviteManual();"></div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>

                    <div class="user_dashboards_top_tab">
                        <ul>
                            <li ><a href="<?php echo HTTP_PATH; ?>board/invite/<?php echo $project->slug; ?>/<?php echo $boardData->slug; ?>">All User</a></li>
                            <li class="active"><a href="<?php echo HTTP_PATH; ?>board/agent/<?php echo $project->slug; ?>/<?php echo $boardData->slug; ?>">Agents</a></li>
                            <li ><a href="<?php echo HTTP_PATH; ?>board/lender/<?php echo $project->slug; ?>/<?php echo $boardData->slug; ?>">Lenders</a></li>
                            <li ><a href="<?php echo HTTP_PATH; ?>board/title/<?php echo $project->slug; ?>/<?php echo $boardData->slug; ?>">Title</a></li>
                            <li ><a href="<?php echo HTTP_PATH; ?>board/client/<?php echo $project->slug; ?>/<?php echo $boardData->slug; ?>">Client</a></li>
                        </ul>
                    </div>
                </div>





                @if ($users)
                <!--{{ Form::open(array('url' => 'prospect/list', 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"form-inline form")) }}-->


                <div class="profile_users">
                    {{ View::make('elements.actionMessage')->render() }}

                    <div class="project_list">
                        <div class="projects_section">
                            <div class="projects_user_list">
                                <ul>
                                    @foreach($users as $user)
                                    <li>
                                        <div class="user_list_bx">
                                            <div class="user_invaite">
                                                {{ Form::open(array('id' => 'inviteuser'.$user->id, 'files' => true,'class'=>"")) }}

                                                <input type="hidden" id="" name="project_id" value="<?php echo $project->id ?>">
                                                <input type="hidden" id="" name="user_id" value="<?php echo $user->id ?>">
                                                <input type="hidden" id="" name="email_address" value="<?php echo $user->email_address ?>">
                                                <a href="javascript:void(0)" onclick="sendInvite({{$user->id}});">Invite</a>

                                                {{ Form::close() }}

                                            </div>
                                            <div class="user_new_img">
                                                <?php
                                                if (!empty($user->profile_image)) {
                                                    echo '<img title="' . $user->first_name . ' ' . $user->last_name . '"  src="' . HTTP_PATH . DISPLAY_FULL_PROFILE_IMAGE_PATH . $user->profile_image . '" alt="user img">';
                                                } else {
                                                    echo '<img title="' . $user->first_name . ' ' . $user->last_name . '" src="' . HTTP_PATH . 'public/img/front/man-user.svg" alt="user img">';
                                                }
                                                ?>

                                            </div>
                                            <div class="user_nwe_bx">
                                                <div class="user_nwe_bx_rop">
                                                    <h3><a href="javascript:void(0)">{{ $user->first_name . ' ' . $user->last_name }}</a></h3>
                                                    <p>
                                                        <?php
                                                        if ($user->user_type == 0) {
                                                            echo "Agent";
                                                        } elseif ($user->user_type == 1) {
                                                            echo "Lender";
                                                        } else {
                                                            echo "Title";
                                                        }
                                                        ?>

                                                    </p>
                                                </div>
                                                <div class="user_nwe_bx_rop2">
                                                    <div class="send_email">
                                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                                        <span><a class="uri value" href="mailto:{{$user->email_address}}">Send Email</a></span>
                                                    </div>
                                                    <div class="contact_number">
                                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                                        <span><a class="uri value" href="tel:{{$user->contact}}">@if($user->contact =='') {{ 'N/A' }} @else {{$user->contact}} @endif</a></span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="row_pagination">



                    <div class="dataTables_paginate paging_bootstrap pagination custom_stye_pagination">
                        <?php
                        $pageination = $users->perPage();
                        if ($pageination > $users->total()) {
                            $pageination = $users->total();
                        }

                        $count = $pageination;
                        $main_count = 1;
                        $counts = $users->total() - $users->count();
                        $count = ($users->total() - $counts) + $count;

                        if (isset($_REQUEST['page']) && $_REQUEST['page'] != '') {

                            if ($_REQUEST['page'] == '1') {
                                $count = $pageination;
                                $main_count = 1;
                            } else {

                                $main_count = ($_REQUEST['page'] - 1) * $users->perPage() + 1;
                                $count = ($_REQUEST['page'] - 1) * $users->perPage() + $pageination;
                                $count = $users->perPage() * $_REQUEST['page'];
                                if ($count > $users->total()) {
                                    $count = $users->total();
                                }
                            }
                        } else {

                            $count = $pageination;
                        }
                        ?>
                        <div class="left_shift_area">No. of Records {{$main_count}} - {{$count}} of {{$users->total()}}</div>
                        <div class="pagination_area">    {{ $users->appends(Input::except('page'))->render() }}</div>
                    </div>


                </div>



                <!--{{ Form::close() }}--> 
                @else
                <div class="no_record">
                    <div>
                        No Users Available
                    </div>
                </div>
                @endif

                <!--</div>-->
            </div>


        </div>
    </div>
</div>

@stop
