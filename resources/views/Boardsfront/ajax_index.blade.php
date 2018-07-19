<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>
<script src="{{ URL::asset('public/js/datepicker/jquery-ui.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



{{ Html::style('public/js/datepicker/jquery-ui.css'); }}
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
<script>
    $(function() {
        var date=new Date();
        $("#searchByDateFrom").datepicker({
            //defaultDate: "+1w",
            changeMonth: true,
            format: 'yyyy-mm-dd',
            numberOfMonths: 1,
            
            //minDate: 'mm-dd-yyyy',
            // minDate: new Date(),
            
            changeYear: true,
            onClose: function(selectedDate) {
                $("#searchByDateTo").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#searchByDateTo").datepicker({
            //defaultDate: "+1w",
            changeMonth: true,
            format: 'yyyy-mm-dd',
            numberOfMonths: 1,
            //minDate: new Date(),
            changeYear: true,
            onClose: function(selectedDate) {
                //$("#searchByDateFrom").datepicker("option", "minDate", selectedDate);
            }
        });

    });
</script>

<?php $user_id = Session::get('user_id'); ?>
<div class="left_menu">Menu</div>
<div class="left_sidebar">
    <div class="left_sidebar_inner">
        <div class="add_board botom_bor">
            <div class="transaction_list_namemm">
                <?php
                if(!empty($project->admin_project_id)){
                     $adminproject = DB::table('adminprojects')
                            ->where('id', $project->admin_project_id)
                            ->first();
                     
                     echo $adminproject->project_name;
                }
                ?>
            </div>

            <?php if ($user_id == $project->user_id) { ?>
                <a href="javascript:void(0);" id="add_new_board"><span>Add Sub Tasks </span><i>+</i></a>
            <?php } ?>
        </div>

        <div class="bottom_menu">
            <ul>
                <?php
                if ($boards) {
                    foreach ($boards as $board) {
                        ?>
                        <li>
                            <a class="<?php echo $slug2 == $board->slug ? 'active' : '';   ?>" href="<?php echo HTTP_PATH . "board/" . $slug . "/" . $board->slug; ?>"> - &nbsp; <?php echo $board->board_name ?></a>
                        </li>
                        <?php
                    }
                }
                ?>   
            </ul>   

            <div class="add_board the_new_scc">
                <?php if ($user_id == $project->user_id) { ?>
                    <a href="javascript:void(0);" id="add_new_board"><span>Add Sub Tasks </span><i>+</i></a>
                <?php } ?>
            </div>
        </div>



        <div class="bottom_links_menu">
            <span style="color: white;"> <?php echo date('d M Y h:i a') ?><br></span>
            <ul>
                <li><a href="{{HTTP_PATH}}dashboard">Dashboard</a></li>
                <li><a href="{{HTTP_PATH}}account">Account</a></li>
                <li><a href="{{HTTP_PATH}}projectboard/projects">My Transactions</a></li>
                <li><a href="{{HTTP_PATH}}logout">Logout </a></li>
            </ul>

        </div>    
    </div>    
</div>
<?php
if ($boardData) {


    $board = $boardData;
    ?>

    <div class="insepteor_main_abovee">
        <div class="insepteor">
            <div class="insepteor_inner">
                <div class="insecptor_title">

                    <div id="board_content_show{{ $board->id }}">
                        <button title="Delete Board"  type="button" onclick="deleteBoardSection({{ $board->id }}, '{{ $board->slug }}');" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="board-title" id="test_name_board_data{{ $board->id }}" onclick="showEditBoardSection({{ $board->id }});"><?php echo $board->board_name; ?></h3>
                    </div>

                    <div id="board_content_edit{{ $board->id }}" class="board_content_edit_clss" style="display: none">
                        <script>
                            $(document).ready(function () {
                                $("#editboard{{ $board->id }}").validate({
                                });
                            });
                        </script>
                        {{ Form::open(array('id' => 'editboard'.$board->id, 'files' => true,'class'=>"")) }}
                        {{ Form::textarea('board_name', $board->board_name, array('rows'=> '1', 'class' => 'required form-control noSpace', 'onblur'=>"updateBoardData($board->id);", "placeholder"=>"Board Name", "id"=> "edit_board_name".$board->id)) }}
                        <input type="hidden" id="" name="id" value="<?php echo $board->id ?>" >
                        {{ Form::close() }}
                    </div>
                </div>   

                <div class="new_tasl_s_">
                    <ul class="task-items"  id="task-ul<?php echo $board->id; ?>" >
                        @include('Boardsfront/ajax_task_listing')
                    </ul>
                </div>


                <!--            <div class="date_div">
                                <div class="inputt"></div>
                                <div class="insepdate"><span>Inspection Date</span>
                                    <p>Due on 03-07-2018</p></div>
                                <div class="minus"><a href="#">-</a></div>
                            </div>
                            <div class="date_div">
                                <div class="inputt"></div>
                                <div class="insepdate"><span>Inspection Date</span>
                                    <p>Due on 03-07-2018</p></div>
                                <div class="minus"><a href="#">-</a></div>
                            </div>-->


            </div> 

            <div class="task_neww" style="display: none;" id="task_comment_section<?php echo $board->id ?>" data-index="0" data-board-index="0" draggable="true" ondragstart="">
                    <!--                            <div class="btm_loader1" id="comment_loader<?php echo $board->id; ?>"> </div>-->
                <script>
                    $(document).ready(function () {
                        $("#addtask<?php echo $board->id ?>").validate({
                        });
                    });
                </script>
                {{ Form::open(array('id' => 'addtask'.$board->id, 'files' => true,'class'=>"")) }}
                {{ Form::textarea('task_name', Input::old('task_name'),   array('rows'=> '2', 'class' => 'required form-control noSpace',  "placeholder"=>"Task Name", "id"=> "add_task_name".$board->id)) }}
                <input type="hidden" id="" name="board_id" value="<?php echo $board->id ?>" >

                <input type="button" class="btn btn-primary" name="comment" id="postcomm<?php echo $board->id ?>" value="Add Task" onclick="saveData(<?php echo $board->id ?>);"/>
                <button type="button" onclick="hideAddTaskSection(<?php echo $board->id ?>);" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                {{ Form::close() }}
            </div>

            <div class="add_task_btn">
                <a  id="task_add_section<?php echo $board->id ?>" onclick="showAddTaskSection(<?php echo $board->id ?>);" class="add-task" href="javascript:void(0);">Add Task</a>
            </div>
        </div>
        <div class="insecption">

        </div>
    </div>

    <?php
} else {
    //print_r($project);
    ?>

    <div class="mnn_prr_scc">



        <div class="project_data" id="project_data_txt">
            {{ View::make('elements.actionMessage')->render() }}

            <?php
            if ($user_id == $project->user_id) {
                ?>
                <div class="prj_ed_ln">
                    <a href="javascript:void(0);" onclick="showProjectEditSection();"> Edit </a>
                </div>
            <?php } ?>

            <div class="section_of_prj">
                <div class="project_sctt">
                    <span class="headd_ing">Assigned Agent</span>
                    <span class="remainn_ing"><?php echo ucfirst($projectUser->first_name . " " . $projectUser->last_name); ?></span>
                </div>
                
                <div class="project_sctt">
                    <span class="headd_ing">Property Address</span>
                    <span class="remainn_ing"><?php echo $project->project_name; ?></span>
                </div>
                <div class="project_sctt">
                    <span class="headd_ing">Transaction</span>
                    <span class="remainn_ing"><?php echo $project->transaction == 0 ? "Buyer" : "Seller"; ?> </span>
                </div>
                <div class="project_sctt">
                    <span class="headd_ing">Sales Price</span>
                    <span class="remainn_ing">$<?php echo $project->transaction_amount > 0 ? number_format($project->transaction_amount, 2) : "0.00"; ?></span>
                </div>

                <?php
                if ($project->transaction_type > 0) {
                    $transactions = DB::table('transactions')
                            ->where('id', $project->transaction_type)
                            ->first();
                    ?>
                    <div class="project_sctt">
                        <span class="headd_ing">Type</span>
                        <span class="remainn_ing"><?php echo $transactions->type ? $transactions->type : "N/A"; ?> </span>
                    </div>

                    <?php
                }
                ?>


                <div class="project_sctt">
                    <span class="headd_ing">Under Contact Date</span>
                    <span class="remainn_ing"><?php echo $project->start_date != "0000-00-00" ? date("m/d/Y", strtotime($project->start_date)) : "N/A"; ?></span>
                </div>
                <div class="project_sctt">
                    <span class="headd_ing">Settlement Date</span>
                    <span class="remainn_ing"><?php echo $project->end_date != "0000-00-00" ? date("m/d/Y", strtotime($project->end_date)) : "N/A"; ?></span>
                </div>

                <?php
                $additionalInformations = DB::table('additionals')
                        ->where('project_id', $project->id)
                        ->get();

                if ($additionalInformations) {
                    global $additionalField;
                    foreach ($additionalInformations as $information) {
                        ?>
                        <div class="project_sctt">
                            <span class="headd_ing"><?php echo $additionalField[$information->key_data]; ?></span>
                            <span class="remainn_ing"><?php echo $information->value_data ? $information->value_data : "N/A"; ?></span>
                        </div>

                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <div class="project_data project_data_editt" id="project_data_edit" style="display:none;">

            <span class="require_sign">Please note that all fields that have an asterisk (*) are required. </span>
            {{ Form::model($project, array('url' => '/board/'.$project->slug, 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"cmxform form-horizontal tasi-form form")) }}
            <div class="form-group">
                {{ Html::decode(Form::label('project_name', "Property Address <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                <div class="col-lg-10">
                    <?php echo Form::text('project_name', Input::old('project_name'), array('class' => 'required form-control noSpace')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php global $transactionTypeArray; ?>
                {{ Html::decode(Form::label('transaction', "Buyer or Seller Transaction <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                <div class="col-lg-10">
                    <span>
                        {{Form::select('transaction', [null=>'Select Buyer or Seller Transaction'] + $transactionTypeArray,Input::old('transaction'),array('class'=>'required form-control','id'=>'transaction'))}}
                    </span>
                </div>
            </div>

            <div class="form-group">
                {{ Html::decode(Form::label('transaction_amount', "Sales Price <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                <div class="col-lg-10">
                    <?php echo Form::text('transaction_amount', Input::old('transaction_amount'), array('class' => 'required form-control ')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php global $transactionTypeArray; ?>
                {{ Html::decode(Form::label('transaction_type', "Type of Sale <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                <div class="col-lg-10">
                    <span>
                        {{Form::select('transaction_type', [null=>'Select Type of Sale'] + $transactionsArr, $project->transaction_type, array('class'=>'required form-control','id'=>'transaction'))}}
                    </span>
                </div>
            </div>


            <div class="form-group">
                {{ Html::decode(Form::label('start_date', "Under Contact Date <span class='require'></span>",array('class'=>"control-label col-lg-2"))) }}
                <div class="col-lg-10">
                    {{ Form::text('start_date', $project->start_date, array('class' => 'required  form-control', 'id'=>'searchByDateFrom','placeholder'=>"Under Contact Date", "autocomplete" => 'off')) }}
                </div>
            </div>

            <div class="form-group">
                {{ Html::decode(Form::label('end_date', "Settlement Date <span class='require'></span>",array('class'=>"control-label col-lg-2"))) }}
                <div class="col-lg-10">
                    {{ Form::text('end_date', $project->end_date , array('class' => 'required  form-control', 'id'=>'searchByDateTo','placeholder'=>"Settlement Date", "autocomplete" => 'off')) }}
                </div>
            </div>

            <?php
            if ($additionalInformations) {

                //echo "<pre>"; print_r($additionalInformations);
                global $additionalField;
                foreach ($additionalInformations as $information) {

                    $fieldName = $additionalField[$information->key_data];
                    //print_r($information);
                    ?>


                    <div class="form-group">
                        {{ Html::decode(Form::label('additional['.$information->key_data.']', "$fieldName <span class='require'></span>",array('class'=>"control-label col-lg-2"))) }}
                        <div class="col-lg-10">
                            {{ Form::text('additional['.$information->key_data.']', $information->value_data, array('class' => 'form-control ',"placeholder"=>"")) }}
                        </div>
                    </div>


                    <?php
                }
            }
            ?>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    {{ Form::submit('Update', array('class' => "btn btn-success")) }}
                    {{ html_entity_decode(Html::link(HTTP_PATH.'board/'. $project->slug, "Cancel", array('class' => 'btn btn-default'), true)) }}
                </div>
            </div>

            {{ Form::close() }}

        </div>
    </div>
<?php }
?>






<div class="right_side_bar">
    <div class="menu_title">Menu</div>   
    <div class="board_members">
        <?php
        //pr($invitedProjectUsers); exit;

        if ($boardData) {
            ?>
            <div class="board_members_tilte">
                <i>
                    {{ Html::image('public/img/front/board-icon.png','img',array('class'=>"")) }}
                </i>
                Boards Members
            </div>

            <?php
            if ($user_id != $project->user_id) {
                ?>
                <div class="onine_row">
                    <span class="user_pic new_user_pic front_nww" id="inv_user_{{ $projectUser->id }}">
                        <?php
                        if (!empty($projectUser->profile_image)) {
                            echo '<img title="' . $projectUser->first_name . '" "' . $projectUser->last_name . '"  src="' . HTTP_PATH . DISPLAY_FULL_PROFILE_IMAGE_PATH . $projectUser->profile_image . '" alt="user img">';
                        } else {
                            echo '<img title="' . $projectUser->first_name . '" "' . $projectUser->last_name . '" src="' . HTTP_PATH . 'public/img/front/man-user.svg" alt="user img">';
                        }
                        ?>
                    </span>
                    <div class="namee"><?php echo ucfirst($projectUser->first_name . " " . $projectUser->last_name); ?>,  <i>Owner</i></div>
                </div>

                <?php
            }
            ?>

            <?php
            if ($invitedProjectUsers) {
                foreach ($invitedProjectUsers as $user) {
                    ?>
                    <div class="onine_row">
                        <span class="user_pic new_user_pic front_nww" id="inv_user_{{ $user->user_id }}">
                            <?php
                            if (!empty($user->profile_image)) {
                                echo '<img title="' . $user->first_name . '" "' . $user->last_name . '"  src="' . HTTP_PATH . DISPLAY_FULL_PROFILE_IMAGE_PATH . $user->profile_image . '" alt="user img">';
                            } else {
                                echo '<img title="' . $user->first_name . '" "' . $user->last_name . '" src="' . HTTP_PATH . 'public/img/front/man-user.svg" alt="user img">';
                            }
                            ?>
                        </span>
                        <div class="namee"><?php echo ucfirst($user->first_name . " " . $user->last_name); ?>,  
                            <i>
                                <?php
                                if ($user->user_type > 0) {
                                    $usertypes = DB::table('usertypes')
                                            ->where('id', $user->user_type)
                                            ->first();
                                    if ($usertypes) {
                                        echo $usertypes->type;
                                    } else {
                                        echo "Member";
                                    }
                                } else {
                                    echo "Member";
                                }
                                ?>
                            </i>
                        </div>
                    </div>
                <?php } ?>
                <?php
            }
        }
        ?>
    </div>
    <?php if ($user_id == $project->user_id && !empty($boardData)) { ?>
        <div class="top_title">
            <a  href="<?php echo HTTP_PATH; ?>board/invite/<?php echo $project->slug; ?>/<?php echo $boardData->slug; ?>"><i>{{ Html::image('public/img/front/user_ion.png','img',array('class'=>"")) }}</i> Invite Users </a>
        </div>
    <?php } ?>


    <div class="activity_wrap">
        <div class="top_title"><i>
                {{ Html::image('public/img/front/activity.png','img',array('class'=>"")) }}
            </i>Activity</div> 
        <div class="activity_inner_update">

        </div> 
    </div>
</div> 


<div class="overlay">
    <div class="popup">
        <button id="close_popup" onclick="hideBoardSection();" class="btn btn-xs">x</button>
        <h2 class="add-board-form-title inactive">Add New Board</h2>
        {{ Form::open(array('url' => 'admin/projects/board', 'method' => 'post', 'id' => 'add_board_form', 'files' => true,'class'=>"inactive")) }}
        <input type="hidden" id="" name="project_id" value="<?php echo $project->id ?>" >
        <div class="form-group">
            <label for="add_board_name">Add Board Name</label>
            {{ Form::text('board_name', Input::old('board_name'),   array('class' => 'required form-control noSpace',"placeholder"=>"Board Name", "id"=> "add_board_name")) }}
        </div>
        <button type="submit" class="btn btn-primary">Add Board</button>

        {{ Form::close() }}


        <h2 class="grab-board-form-title inactive">Grab Board</h2>
        {{ Form::open(array('url' => 'board/viewDefaultBoards', 'method' => 'post', 'id' => 'grab_board_form', 'files' => true,'class'=>"inactive")) }}
        <input type="hidden" id="" name="project_id" value="<?php echo $project->id ?>" >
        <div class="form-group">
            <label for="grab_board_name">Select Project to View Admin Pre Added Boards </label>
            <div class="select_board">
                <span>
                    {{Form::select('admin_project_id', $array_boardd,  Input::old('board_id'), array('id'=>'grab_board_name', 'class' => 'required '))}}
                </span>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Views Boards</button>

        {{ Form::close() }}


        <h2 class="add-task-form-title inactive">Add New Task</h2>
        {{ Form::open(array('url' => 'admin/projects/board', 'method' => 'post', 'id' => 'update_task_form', 'files' => true,'class'=>"inactive")) }}
        <div class="form-group">
            <label for="add_task_desc">Add Task Description</label>
            <textarea type="text" class="form-control" id="add_task_desc" placeholder="Task Description"></textarea>
        </div>
        <input type="hidden" id="parent_board" />
        <input type="hidden" id="edit_task" value="false" />
        <input type="hidden" id="edit_task_index" />
        <button type="submit" class="btn btn-primary">Add Task</button>
        {{ Form::close() }}
    </div>
</div>




<script>
    $(document).ready(function () {
        $.ajaxSetup(
        {
            headers:
                {
                'X-CSRF-Token': $('input[name="_token"]').val()
            }
        });
        
        $("#add_board_form").validate(
        {
            rules: {
                board_name: {
                    required: true
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>board/saveAdminProjectBoard',
                    data: $('#add_board_form').serialize(),
                    beforeSend: function () {
                        //$("#loaderId").show();
                        $('html, body').css("cursor", "wait");
                    },
                    success: function (result) {
                        //$("#loaderId").hide();
                        $('html, body').css("cursor", "auto");
                        $( ".containerdf").sortable('refresh');
                        if (result) {
                            $(".overlay").removeClass('open');
                            $(".add-board-form-title").removeClass('active');
                            $("#add_board_form").removeClass('active');
                            $('#add_board_form').removeAttr('value');
                            $("#add_board_name").val('');
                            $('#boards_container').prepend(result);
                            updateAllActivity(<?php echo $project->id ?>);   
                            window.location.reload();
                        } else {
                            alert('An error occured while adding board');
                        }
                    }
                });
            }
        }    
    );
    
        $("#grab_board_form").validate(
        {
            rules: {
                board_name: {
                    required: true
                }
            }
            //            submitHandler: function (form) {
            //                $.ajax({
            //                    type: 'POST',
            //                    url: '<?php echo HTTP_PATH; ?>board/viewDefaultBoards',
            //                    data: $('#grab_board_form').serialize(),
            //                    beforeSend: function () {
            //                        //$("#loaderId").show();
            //                        $('html, body').css("cursor", "wait");
            //                    },
            //                    success: function (result) {
            //                        //$("#loaderId").hide();
            //                        $('html, body').css("cursor", "auto");
            //                        if (result) {
            //                            $(".overlay").removeClass('open');
            //                            $(".grab-board-form-title").removeClass('active');
            //                            $("#grab_board_form").removeClass('active');
            //                            $('#grab_board_form').removeAttr('value');
            //                            $("#grab_board_name").val('');
            //                            $('#boards_container').prepend(result);
            //                            updateAllActivity(<?php echo $project->id ?>);   
            //                            //window.location.reload();
            //                        } else {
            //                            alert('An error occured while adding board');
            //                        }
            //                    }
            //                });
            //            }
        }    
    );
   
    });    
    
    function openBoardForm(){
        $(".overlay").addClass('open');
        $(".add-board-form-title").addClass('active');
        $("#add_board_form").addClass('active');
    }
    
    function showProjectEditSection(){
        $("#project_data_txt").hide();
        $("#project_data_edit").show();
    }
    
    function openGrabBoardForm(){
        $(".overlay").addClass('open');
        $(".grab-board-form-title").addClass('active');
        $("#grab_board_form").addClass('active');
    }
    
    
    $(document).ready(function(){
        $("#add_new_board").click(function () {
            openBoardForm(); 
        });
        
        $("#grab_new_board").click(function () {
            openGrabBoardForm(); 
        });
    });
    
</script>