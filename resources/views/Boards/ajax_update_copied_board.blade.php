<div id="board_content_show{{ $board->id }}">
    
    <div class="edit_board_show" id="edit_board_menuu_show{{ $board->id }}">
                                <button class="btn btn-xs edit-task nnee-board-button" onclick="showCopyBoardSection({{ $board->id }});">Copy</button>
                                <button class="btn btn-xs edit-task nnee-board-button" onclick="showMoveBoardSection({{ $board->id }});">Move</button>
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
    
    
    <button type="button" onclick="deleteBoardSection({{ $board->id }}, '{{ $board->slug }}');" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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

<ul class="task-items" ondrop="" ondragover="" id="task-ul<?php echo $board->id; ?>">

    <?php $tasksLists = DB::table('tasks')->where('board_id', $board->id)->orderBy('tasks.task_position', 'ASC')->get(); ?>

    <?php
    if ($tasksLists) {
        foreach ($tasksLists as $tasksList) {
            ?>
            <li class="task" id="task_li_section{{ $tasksList->id }}" data-index="0" data-board-index="0" draggable="true" ondragstart="">
                <div id="task_content_show{{ $tasksList->id }}">
                    <div class="task-actions">
                        <button class="btn btn-xs dots-task" onclick="showBoardTaskMenu({{ $tasksList->id }});" ></button>
                        <div class="edit_show" id="task_menuu_show{{ $tasksList->id }}">
                            <button type="button" onclick="closeBoardTaskMenu({{ $tasksList->id }});" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <button class="btn btn-xs edit-task" onclick="showEditTaskSection({{ $tasksList->id }});">Edit</button>
                            <button class="btn btn-xs delete-task" onclick="deleteTaskSection({{ $tasksList->id }}, '{{ $tasksList->slug }}');">Delete</button>
                            <button class="btn btn-xs edit-task" onclick="showCopyTaskSection({{ $tasksList->id }});">Copy</button>
                            <button class="btn btn-xs edit-task" onclick="showMoveTaskSection({{ $tasksList->id }});">Move</button>
                        </div>

                        <div class="copy_taskk_show " id="copy_taskk_show{{ $tasksList->id }}" style="display:none">
                            <div class="copy_heading_task">
                                <div class="copy_heading_task_one">Copy Card</div>
                                <div class="copy_heading_task_two"><button type="button" onclick="hideCopyTaskSection({{ $tasksList->id }});" class="close_new" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                            </div>
                            <div class="copy_content_task" id="copy_taskk_content_show{{ $tasksList->id }}"">
                                 <div class="loaderr">{{ Html::image('public/img/loading.gif','search',array('class'=>"")) }}</div> 
                                <!--                                                        <div class="textarea">
                                                                                            <label>Title</label>
                                                                                            <textarea></textarea>
                                                                                            
                                                                                        </div>-->
                                {{ Form::open(array('id' => 'copytask'.$tasksList->id, 'files' => true,'class'=>"")) }}
                                <div class="copy_text">Copy to…</div>
                                <div class="selectt">
                                    {{Form::select('project_id', $array_project,  Input::old('project_id'), array('class'=>'required','id'=>'projectt_id'.$tasksList->id ,'onchange'=>"getProjectBoards(this.options[this.selectedIndex].value, $tasksList->id);"))}}
                                </div>
                                <div class="selectt smal_sec" id="copy_task_board_section{{$tasksList->id}}">
                                    {{Form::select('board_id', [null=>'Select Board'], Input::old('board_id'),array('class'=>'required','id'=>'boardd_id'.$tasksList->id,'onchange'=>"getBoardTasks(this.options[this.selectedIndex].value, $tasksList->id);"))}}
                                </div>
                                <div class="selectt smal_thi" id="copy_task_position_section{{$tasksList->id}}">
                                    {{Form::select('position', [null=>'Select Position'], Input::old('position'),array('class'=>'required','id'=>'position'.$tasksList->id)) }}
                                </div>
                                <input type="hidden" id="" name="old_board_id" value="<?php echo $board->id ?>" >
                                <input type="hidden" id="" name="old_project_id" value="<?php echo $board->project_id ?>" >
                                <input type="hidden" id="" name="old_task_id" value="<?php echo $tasksList->id ?>" >
                                <input type="hidden" id="" name="old_task_name" value="<?php echo $tasksList->task_name ?>" >

                                <div class="submit_new_btn">
                                    <input type="button" class="submit_new" name="copy task" id="copy_task<?php echo $tasksList->id ?>" value="Copy Task" onclick="copyTaskData(<?php echo $tasksList->id ?>);"/>
                                </div> 
                                {{ Form::close() }}
                            </div>
                        </div>
                        
                        <div class="move_taskk_show " id="move_taskk_show{{ $tasksList->id }}" style="display:none">
                                                    <div class="copy_heading_task">
                                                        <div class="copy_heading_task_one">Move Task</div>
                                                        <div class="copy_heading_task_two"><button type="button" onclick="hideMoveTaskSection({{ $tasksList->id }});" class="close_new" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                                                    </div>

                                                    <div class="move_content_task" id="move_taskk_content_show{{ $tasksList->id }}">
                                                        <div class="loaderr">{{ Html::image('public/img/loading.gif','search',array('class'=>"")) }}</div> 
                                                        <!--                                                        <div class="textarea">
                                                                                                                    <label>Title</label>
                                                                                                                    <textarea></textarea>
                                                                                                                    
                                                                                                                </div>-->
                                                        {{ Form::open(array('id' => 'movetask'.$tasksList->id, 'files' => true,'class'=>"")) }}
                                                        <div class="copy_text">Move to…</div>
                                                        <div class="selectt">
                                                            {{Form::select('project_id', $array_project,  Input::old('project_id'), array('class'=>'required','id'=>'move_projectt_id'.$tasksList->id ,'onchange'=>"getProjectMoveBoards(this.options[this.selectedIndex].value, $tasksList->id);"))}}
                                                        </div>
                                                        <div class="selectt smal_sec" id="move_task_board_section{{$tasksList->id}}">
                                                            {{Form::select('board_id', [null=>'Select Board'], Input::old('board_id'),array('class'=>'required','id'=>'move_boardd_id'.$tasksList->id,'onchange'=>"getBoardMoveTasks(this.options[this.selectedIndex].value, $tasksList->id);"))}}
                                                        </div>
                                                        <div class="selectt smal_thi" id="move_task_position_section{{$tasksList->id}}">
                                                            {{Form::select('position', [null=>'Select Position'], Input::old('position'),array('class'=>'required','id'=>'move_position'.$tasksList->id)) }}
                                                        </div>
                                                        <input type="hidden" id="" name="old_board_id" value="<?php echo $board->id ?>" >
                                                        <input type="hidden" id="" name="old_project_id" value="<?php echo $board->project_id ?>" >
                                                        <input type="hidden" id="" name="user_id" value="<?php echo $project->user_id ?>" >
                                                        <input type="hidden" id="" name="old_task_id" value="<?php echo $tasksList->id ?>" >
                                                        <input type="hidden" id="" name="old_task_name" value="<?php echo $tasksList->task_name ?>" >
                                                        <input type="hidden" id="" name="old_position" value="<?php echo $tasksList->task_position ?>" >

                                                        <div class="submit_new_btn">
                                                            <input type="button" class="submit_new" name="move task" id="copy_task<?php echo $tasksList->id ?>" value="Move Task" onclick="moveTaskData(<?php echo $tasksList->id ?>);"/>
                                                        </div> 
                                                        {{ Form::close() }}
                                                    </div>
                                                </div>

                    </div>
                    <a href="{{ HTTP_PATH.'admin/projects/displayProjectTaskSection/'.$tasksList->slug }}" rel ='facebox'>
                        <p id="test_name_data{{ $tasksList->id }}">{{ $tasksList->task_name }}</p>
                    </a>
                </div>
                <div id="task_content_edit{{ $tasksList->id }}" style="display: none">
                    <script>
                        $(document).ready(function () {
                            $("#edittask{{ $tasksList->id }}").validate({
                            });
                        });
                    </script>
                    {{ Form::open(array('id' => 'edittask'.$tasksList->id, 'files' => true,'class'=>"")) }}
                    {{ Form::textarea('task_name', $tasksList->task_name, array('rows'=> '2', 'class' => 'required form-control noSpace', 'onblur'=>"updateData($tasksList->id);", "placeholder"=>"Task Name", "id"=> "edit_task_name".$tasksList->id)) }}
                    <input type="hidden" id="" name="board_id" value="<?php echo $board->id ?>" >
                    <input type="hidden" id="" name="id" value="<?php echo $tasksList->id ?>" >
                    {{ Form::close() }}
                </div>
            </li>
            <?php
        }
    }
    ?>

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
