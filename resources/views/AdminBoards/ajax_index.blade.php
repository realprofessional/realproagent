<div class="containers text-center" style="margin-top: 0px; padding-top: 0px;">
    <div class="row">
        <div class="col-lg-6">
            <span class='admin_def_ed' id="test_name_project_data{{ $project->id }}" onclick="showEditProjectSection({{ $project->id }});">Edit Project {{ $project->project_name }}</span>
            <span class="admin_def_del"><?php echo html_entity_decode(Html::link('admin/adminboards/deleteproject/' . $project->slug, 'Delete Project', array('title' => 'Delete', 'class' => 'list delete-list', 'escape' => false, 'onclick' => "return confirmAction('delete');")));
?></span>
        </div>
        <div class="col-lg-6">
            <button class="btn btn-primary pull-right" id="add_new_board">Add Board</button>
        </div>
    </div>

    <div id="project_content_edit{{ $project->id }}" class="project_content_edit_clss" style="display: none">
        <script>
            $(document).ready(function () {
                $("#projectboard{{ $project->id }}").validate({
                });
            });
        </script>
        <span> Update Project Name </span>
        {{ Form::open(array('id' => 'projectboard'.$project->id, 'files' => true,'class'=>"")) }}
        {{ Form::textarea('project_name', $project->project_name, array('rows'=> '1', 'class' => 'required form-control noSpace', 'onblur'=>"updateProjectData($project->id);", "placeholder"=>"Project Name", "id"=> "edit_project_name".$project->id)) }}
        <input type="hidden" id="" name="id" value="<?php echo $project->id ?>" >
        {{ Form::close() }}
    </div>

    <div class="list_br">
        <div class="containerdf row no-margin" id="boards_container" style=''>

            <?php
            if ($adminboards) {
                foreach ($adminboards as $adminboard) {
                    //echo $adminboard->board_name;
                    ?>
                    <div class="board-wrap" id="board_<?php echo $adminboard->id; ?>">
                        <div id="board_content_show{{ $adminboard->id }}">
                            <button type="button" onclick="deleteBoardSection({{ $adminboard->id }}, '{{ $adminboard->slug }}');" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="board-title" id="test_name_board_data{{ $adminboard->id }}" onclick="showEditBoardSection({{ $adminboard->id }});"><?php echo $adminboard->board_name; ?></h3>

                        </div>
                        <div id="board_content_edit{{ $adminboard->id }}" class="board_content_edit_clss" style="display: none">
                            <script>
                                $(document).ready(function () {
                                    $("#editboard{{ $adminboard->id }}").validate({
                                    });
                                });
                            </script>
                            {{ Form::open(array('id' => 'editboard'.$adminboard->id, 'files' => true,'class'=>"")) }}
                            {{ Form::textarea('board_name', $adminboard->board_name, array('rows'=> '1', 'class' => 'required form-control noSpace', 'onblur'=>"updateBoardData($adminboard->id);", "placeholder"=>"Board Name", "id"=> "edit_board_name".$adminboard->id)) }}
                            <input type="hidden" id="" name="id" value="<?php echo $adminboard->id ?>" >
                            {{ Form::close() }}

                        </div>

                        <ul class="task-items" ondrop="" ondragover="" id="task-ul<?php echo $adminboard->id; ?>">

                            <?php $tasksLists = DB::table('admintasks')->where('board_id', $adminboard->id)->get(); ?>

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
                                                </div>


                                            </div>
                                            <a href="{{ HTTP_PATH.'admin/adminboards/displayProjectTaskSection/'.$tasksList->slug }}" rel ='facebox'>
                                                <p id="test_name_data{{ $tasksList->id }}"class="top_space_field">{{ $tasksList->task_name }}</p>
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
                                            <input type="hidden" id="" name="board_id" value="<?php echo $adminboard->id ?>" >
                                            <input type="hidden" id="" name="id" value="<?php echo $tasksList->id ?>" >
                                            {{ Form::close() }}
                                        </div>
                                    </li>
                                    <?php
                                }
                            }
                            ?>

                        </ul>


                        <div class="task_neww" style="display: none;" id="task_comment_section<?php echo $adminboard->id ?>" data-index="0" data-board-index="0" draggable="true" ondragstart="">
            <!--                            <div class="btm_loader1" id="comment_loader<?php echo $adminboard->id; ?>"> </div>-->
                            <script>
                                $(document).ready(function () {
                                    $("#addtask<?php echo $adminboard->id ?>").validate({
                                    });
                                });
                            </script>
                            {{ Form::open(array('id' => 'addtask'.$adminboard->id, 'files' => true,'class'=>"")) }}
                            {{ Form::textarea('task_name', Input::old('task_name'),   array('rows'=> '2', 'class' => 'required form-control noSpace',  "placeholder"=>"Task Name", "id"=> "add_task_name".$adminboard->id)) }}
                            <input type="hidden" id="" name="board_id" value="<?php echo $adminboard->id ?>" >

                            <input type="button" class="btn btn-primary" name="comment" id="postcomm<?php echo $adminboard->id ?>" value="Add Task" onclick="saveData(<?php echo $adminboard->id ?>);"/>
                            <button type="button" onclick="hideAddTaskSection(<?php echo $adminboard->id ?>);" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                            {{ Form::close() }}
                        </div>

                        <button id="task_add_section<?php echo $adminboard->id ?>" onclick="showAddTaskSection(<?php echo $adminboard->id ?>);" class="btn btn-sm btn-success add-task">Add Task</button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<div class="overlay ">
    <div class="popup">
        <button id="close_popup" onclick="hideBoardSection();" class="btn btn-xs">x</button>
        <h2 class="add-board-form-title inactive">Add New Board</h2>
        {{ Form::open(array('url' => 'admin/adminboards/list', 'method' => 'post', 'id' => 'add_board_form', 'files' => true,'class'=>"inactive")) }}
        <input type="hidden" id="" name="project_id" value="<?php echo $project->id ?>" >
        <div class="form-group">
            <label for="add_board_name">Add Board Name</label>
            {{ Form::text('board_name', Input::old('board_name'),   array('class' => 'required form-control noSpace',"placeholder"=>"Board Name", "id"=> "add_board_name")) }}
        </div>
        <button type="submit" class="btn btn-primary">Add Board</button>

        {{ Form::close() }}


        <!--        <h2 class="add-task-form-title inactive">Add New Task</h2>
                <form id="add_task_form" class="inactive">
                    <div class="form-group">
                        <label for="add_task_name">Add Task Name</label>
                        <input type="text" class="form-control" id="add_task_name" placeholder="Task Name">
                    </div>
                    <div class="form-group">
                        <label for="add_task_desc">Add Task Description</label>
                        <textarea type="text" class="form-control" id="add_task_desc" placeholder="Task Description"></textarea>
                    </div>
                    <input type="hidden" id="parent_board" />
                    <input type="hidden" id="edit_task" value="false" />
                    <input type="hidden" id="edit_task_index" />
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </form>-->
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
                    url: '<?php echo HTTP_PATH; ?>ajax/saveAdminBoard',
                    data: $('#add_board_form').serialize(),
                    beforeSend: function () {
                        $("#loaderId").show();
                    },
                    success: function (result) {
                        $("#loaderId").hide();
                        if (result == 1) {
                            $(".overlay").removeClass('open');
                            $(".add-board-form-title").removeClass('active');
                            $("#add_board_form").removeClass('active');
                            window.location.reload();
                        } else {
                            alert('An error occured while adding board');
                        }
                    }
                });
            }
        }    
    );
   
    });    
    
    function openBoardForm(){
        $(".overlay").addClass('open');
        $(".add-board-form-title").addClass('active');
        $("#add_board_form").addClass('active');
    }
    
    
    $(document).ready(function(){
        $("#add_new_board").click(function () {
            openBoardForm(); 
        });
    
    
    });
    
    //    window.onload = function () {
    //        MyApp.init();
    //        document.getElementById('add_new_board').addEventListener('click', MyApp.openBoardForm);
    //        document.addEventListener('click', function(e) {
    //            var button = e.target;
    //            if(button.classList.contains("add-task")) {
    //                MyApp.openTaskForm(e);
    //            }
    //            if(button.classList.contains("delete-task")) {
    //                MyApp.deleteItem(e);
    //            }
    //            if(button.classList.contains("edit-task")) {
    //                var index ={
    //                    taskIndex : button.parentNode.parentNode.getAttribute('data-index'),
    //                    boardIndex : button.parentNode.parentNode.getAttribute('data-board-index')
    //                }
    //                MyApp.openTaskForm(e, index);
    //            }
    //        });
    //        document.getElementById('close_popup').addEventListener('click', MyApp.closePopup);
    //        document.getElementById('add_board_form').addEventListener('submit', function(event) {
    //            event.preventDefault();
    //            var boardData = { 
    //                name : document.getElementById('add_board_name').value, 
    //                type :"board" }
    //            document.getElementById('add_board_name').value = "";
    //            MyApp.addItem(boardData)
    //            MyApp.closePopup();
    //        });
    //        document.getElementById('add_task_form').addEventListener('submit', function(event) {
    //            event.preventDefault();
    //            var taskData = { 
    //                name : document.getElementById('add_task_name').value,
    //                desc : document.getElementById('add_task_desc').value,
    //                parent : document.getElementById('parent_board').value,
    //                taskIndex : document.getElementById('edit_task_index').value,
    //                type : "task" }
    //            if(document.getElementById('edit_task').value == "true") {
    //                MyApp.editItem(taskData);
    //            }
    //            else {
    //                MyApp.addItem(taskData);
    //            }
    //            document.getElementById('add_task_name').value = "";
    //            document.getElementById('add_task_desc').value = "";
    //            document.getElementById('parent_board').value = "";
    //            document.getElementById('edit_task').value = "false";
    //            document.getElementById('edit_task_index').value = "";
    //            MyApp.closePopup();
    //        });
    //    }

</script>