
<script>
    $(document).ready(function ($) {
        $('.close_image').hide();
        $('a[rel*=facebox]').facebox({
            loadingImage: "<?php echo HTTP_PATH; ?>public/img/loading.gif",
            closeImage: "<?php echo HTTP_PATH; ?>public/img/close.png"
        });
    });
</script>
<?php $tasksList = DB::table('admintasks')->where('id', $adminTasks)->first(); ?>
<!--<li class="task" data-index="0" data-board-index="0" draggable="true" ondragstart="">
    <div class="task-actions">
        <button class="btn btn-xs edit-task">Edit</button>
        <button class="btn btn-xs delete-task">Delete</button>
    </div>
    <p>{{ $tasksList->task_name }}</p>
</li>-->
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
        <input type="hidden" id="" name="board_id" value="<?php echo $tasksList->board_id ?>" >
        <input type="hidden" id="" name="id" value="<?php echo $tasksList->id ?>" >
        {{ Form::close() }}
    </div>
</li>
