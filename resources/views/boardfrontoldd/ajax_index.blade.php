<div class="containers text-center" style="margin-top: 0px; padding-top: 0px;">
    <button class="btn_board_" id="add_new_board">Add Board</button> 
    <button class="btn_board_" id="grab_new_board">Grab Board</button>
    <div class="list_br list_br_new">
        <div class="containerdf row no-margin" id="boards_container" style=''>
            <?php
            if ($boards) {
                foreach ($boards as $board) {
                    //echo $board->board_name;
                    ?>
                    <div class="board-wrap" id="board_<?php echo $board->id; ?>" data-board-id="<?php echo $board->id; ?>"  data-board-position="<?php echo $board->board_position; ?>" >
                        <div id="board_content_show{{ $board->id }}">
                            <div class="edit_board_show" id="edit_board_menuu_show{{ $board->id }}">
                                <button title="Copy Board" class="btn btn-xs edit-task nnee-board-button" onclick="showCopyBoardSection({{ $board->id }});"><i class="fa fa-files-o" aria-hidden="true"></i></button>
                                <button title="Move Board" class="btn btn-xs edit-task nnee-board-button" onclick="showMoveBoardSection({{ $board->id }});"><i class="fa fa-arrows" aria-hidden="true"></i></button>
                            </div>

                            <div class="copy_boardd_show " id="copy_boardd_show{{ $board->id }}" style="display:none">
                                <div class="copy_heading_task copy_heading_board">
                                    <div class="copy_heading_task_one copy_heading_board_one">Copy Board</div>
                                    <div class="copy_heading_task_two copy_heading_board_two"><button type="button" onclick="hideCopyBoardSection({{ $board->id }});" class="close_new" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                                </div>
                                <div class="copy_content_task copy_content_board" id="copy_boardd_content_show{{ $board->id }}">
                                    <div class="loaderr">{{ Html::image('public/img/loading.gif','search',array('class'=>"")) }}</div> 

                                    {{ Form::open(array('id' => 'copyboard'.$board->id, 'files' => true,'class'=>"")) }}
                                    <div class="textarea">
                                        <label>Board Name</label>
                                        <textarea name="new_board_title" id="copy_boardd_name_dt{{ $board->id }}">{{ $board->board_name }}</textarea>
                                    </div>
                                    <div class="copy_text">Copy to…</div>
                                    <div class="selectt">
                                        {{Form::select('project_id', $array_project,  Input::old('project_id'), array('class'=>'required','id'=>'board_projectt_id'.$board->id ,'onchange'=>"getPositionForCopyBoard(this.options[this.selectedIndex].value, $board->id);"))}}
                                    </div>
                                    <div class="selectt" id="copy_board_position_section{{$board->id}}">
                                        {{Form::select('position', [null=>'Select Position'], Input::old('position'),array('class'=>'required','id'=>'board_position'.$board->id)) }}
                                    </div>

                                    <input type="hidden" id="" name="old_board_id" value="<?php echo $board->id ?>" >
                                    <input type="hidden" id="old_project_id{{ $board->id }}" name="old_project_id" value="<?php echo $board->project_id ?>" >
                                    <input type="hidden" id="" name="user_id" value="<?php echo $project->user_id ?>">

                                    <div class="submit_new_btn">
                                        <input type="button" class="submit_new" name="copy board" id="copy_board<?php echo $board->id ?>" value="Copy Board" onclick="copyBoardData(<?php echo $board->id ?>);"/>
                                    </div> 
                                    {{ Form::close() }}
                                </div>
                            </div>


                            <div class="move_boardd_show " id="move_boardd_show{{ $board->id }}" style="display:none">
                                <div class="copy_heading_task move_heading_board">
                                    <div class="copy_heading_task_one move_heading_board_one">Move Board</div>
                                    <div class="copy_heading_task_two move_heading_board_two"><button type="button" onclick="hideMoveBoardSection({{ $board->id }});" class="close_new" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                                </div>
                                <div class="move_content_task move_content_board" id="move_boardd_content_show{{ $board->id }}">
                                    <div class="loaderr">{{ Html::image('public/img/loading.gif','search',array('class'=>"")) }}</div> 

                                    {{ Form::open(array('id' => 'moveboard'.$board->id, 'files' => true,'class'=>"")) }}
                                    <div class="copy_text">Move to…</div>
                                    <div class="selectt">
                                        {{Form::select('project_id', $array_project,  Input::old('project_id'), array('class'=>'required','id'=>'move_board_projectt_id'.$board->id ,'onchange'=>"getPositionForMoveBoard(this.options[this.selectedIndex].value, $board->id);"))}}
                                    </div>
                                    <div class="selectt" id="move_board_position_section{{$board->id}}">
                                        {{Form::select('position', [null=>'Select Position'], Input::old('position'),array('class'=>'required','id'=>'move_board_position'.$board->id)) }}
                                    </div>

                                    <input type="hidden" id="" name="old_board_id" value="<?php echo $board->id ?>" >
                                    <input type="hidden" id="move_old_project_id{{ $board->id }}" name="old_project_id" value="<?php echo $board->project_id ?>" >
                                    <input type="hidden" id="" name="user_id" value="<?php echo $project->user_id ?>">
                                    <input type="hidden" id="" name="old_position" value="<?php echo $board->board_position ?>" >

                                    <div class="submit_new_btn">
                                        <input type="button" class="submit_new" name="move board" id="move_board<?php echo $board->id ?>" value="Move Board" onclick="moveBoardData(<?php echo $board->id ?>);"/>
                                    </div> 
                                    {{ Form::close() }}
                                </div>
                            </div>


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
                        <div class="new_tasl_s">
                            <ul class="task-items"  id="task-ul<?php echo $board->id; ?>" data-ul-board-id="<?php echo $board->id; ?>">

                               @include('Boardsfront/ajax_task_listing')

                            </ul>

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

                            <button id="task_add_section<?php echo $board->id ?>" onclick="showAddTaskSection(<?php echo $board->id ?>);" class="btn btn-sm btn-success add-task">Add Task</button>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
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
                            //window.location.reload();
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