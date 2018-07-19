<div class="containers text-center" style="margin-top: 0px; padding-top: 0px;">
    <div class="list_br list_br_new">
        <div class="containerdf row no-margin" id="boards_container" style=''>
            <?php
            if ($boards) {
                foreach ($boards as $board) {
                    //echo $board->board_name;
                    ?>
                    <div class="board-wrap" id="board_<?php echo $board->id; ?>">
                        <div id="board_content_show{{ $board->id }}">


                            <h3 class="board-title" id="test_name_board_data{{ $board->id }}" ><?php echo $board->board_name; ?></h3>

                        </div>

                        <div class="new_tasl_s">
                            <ul class="task-items" ondrop="" ondragover="" id="task-ul<?php echo $board->id; ?>">

                                <?php $tasksLists = DB::table('admintasks')->where('board_id', $board->id)->orderBy('admintasks.id', 'ASC')->get(); ?>

                                <?php
                                if ($tasksLists) {
                                    foreach ($tasksLists as $tasksList) {
                                        ?>
                                        <li class="task" id="task_li_section{{ $tasksList->id }}" data-index="0" data-board-index="0" draggable="true" ondragstart="">
                                            <div id="task_content_show{{ $tasksList->id }}" class="task_contact_sw">

                                                <a href="{{ HTTP_PATH.'adminboards/displayProjectTaskSection/'.$tasksList->slug }}" rel ='facebox'>
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

                        </div>

                        {{ Form::open(array('url' => 'board/grabAdminProjectBoard','id' => 'grabboard'.$board->id, 'files' => true,'class'=>"")) }}
                        <input type="hidden" id="" name="board_id" value="<?php echo $board->id ?>" >
                        <input type="hidden" id="" name="project_id" value="<?php echo $project->id ?>" >
                        <button id="task_grr_add_section<?php echo $board->id ?>"  class="btn btn-sm btn-success add-task">Grab This Board</button>

                        {{ Form::close() }}


                    </div>
                    <?php
                }
            }
            ?>
        </div>
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
    
  
</script>