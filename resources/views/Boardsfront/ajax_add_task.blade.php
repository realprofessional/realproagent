
<script>
    $(document).ready(function ($) {
        $('.close_image').hide();
        $('a[rel*=facebox]').facebox({
            loadingImage: "<?php echo HTTP_PATH; ?>public/img/loading.gif",
            closeImage: "<?php echo HTTP_PATH; ?>public/img/close.png"
        });
    });
</script>
<?php $tasksList = DB::table('tasks')->where('id', $tasks)->first(); ?>
<li class="task" id="task_li_section{{ $tasksList->id }}" data-index="0" data-board-index="0" draggable="true" ondragstart="">
    <div id="task_content_show{{ $tasksList->id }}" class="task_contact_sw">
        <div class="task-actions">
            <button class="btn btn-xs dots-task" onclick="showBoardTaskMenu({{ $tasksList->id }});" ></button>
            <div class="edit_show" id="task_menuu_show{{ $tasksList->id }}">
                <button type="button" onclick="closeBoardTaskMenu({{ $tasksList->id }});" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <button class="btn btn-xs edit-task" onclick="showEditTaskSection({{ $tasksList->id }});">Edit</button>
                <button class="btn btn-xs delete-task" onclick="deleteTaskSection({{ $tasksList->id }}, '{{ $tasksList->slug }}');">Delete</button>
                <!--                <button class="btn btn-xs edit-task" onclick="showCopyTaskSection({{ $tasksList->id }});">Copy</button>
                                <button class="btn btn-xs edit-task" onclick="showMoveTaskSection({{ $tasksList->id }});">Move</button>-->
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
                    <input type="hidden" id="" name="user_id" value="<?php echo $project->user_id ?>" >
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

        <?php $varVal = $tasksList->is_checked == 0 ? null : true; ?>

        {{ Form::open(array('id' => 'checkboxTaskTick'.$tasksList->id, 'files' => true,'class'=>"")) }}

        <div class="form__remember">
            {{Form::checkbox('is_checked', '1', $varVal, array('class'=>'required checkbox_clss','id'=>'checkbox_idd_ppup_task'.$tasksList->id,'onchange'=>"submitTaskChecboxValueData($tasksList->id);"))}}
            <label class="in-label" for="checkbox_idd_ppup_task<?php echo $tasksList->id; ?>"></label>
        </div>
        <input type="hidden" id="" name="checked_by" value="{{ Session::get('user_id') }}" >
        <input type="hidden" id="" name="task_id" value="{{ $tasksList->id }}" >
        {{ Form::close() }}


        <!--        <a href="{{ HTTP_PATH.'board/displayProjectTaskSection/'.$tasksList->slug }}" rel ='facebox'>-->

        <div class="combine_asp">
            <a href="javascript:void(0);" onclick="fetchTaskDetails('{{  $tasksList->slug  }}');" >
                <p id="test_name_data{{ $tasksList->id }}">{{ $tasksList->task_name }}</p>
            </a>
            <span class="due_on_txt" id="due_on_txt_{{ $tasksList->id }}">
                <?php
                if (!empty($tasksList->due_date)) {
                    echo "Due on " . date("d-M-Y", strtotime($tasksList->due_date));
                }
                ?>
            </span>
        </div>
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
