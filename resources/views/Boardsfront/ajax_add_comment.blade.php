<?php
if ($commentList) {
    ?>
    <div class = "comment_wrap new_ft" id="comment_big_sec_whole{{ $commentList->id }}">
        <div class = "com_am"><?php echo substr($commentList->first_name, 0, 1) . substr($commentList->last_name, 0, 1)
    ?></div>

        <div class="coment_text" id="comment_text_show{{ $commentList->id }}">
            <div class="comment_full_sec" id="comment_full_sec{{ $commentList->id }}">
                {{ nl2br($commentList->comment) }}
            </div>
            <div class="comment_full_sec_later">
                <div class="comment_full_sec_time">
                    {{  date("d M, h:i A", strtotime($commentList->created)) }}
                </div>
                <div class="comment_full_sec_links">
                    <button class="btn_newdd btn-xs edit-task nnee-board-button" onclick="showEditCommentSection({{ $commentList->id }});">Edit</button>
                    <button class="btn_newdd btn-xs edit-task nnee-board-button" onclick="deleteTaskComment({{ $commentList->id }}, '{{ $commentList->slug }}');">Delete</button>
                </div>
            </div>
        </div>


        <div class="coment_text" id="comment_edit_show{{ $commentList->id }}" style="display:none;">
            {{ Form::open(array('id' => 'editcomment'.$commentList->id, 'files' => true,'class'=>"")) }}
            {{ Form::textarea('comment', $commentList->comment,   array('rows'=> '2', 'class' => 'required',  "placeholder"=>"Write a comment", "id"=> "edit_comment_value".$commentList->id)) }}
            <input type="hidden" id="" name="comment_id" value="<?php echo $commentList->id ?>" >

            <div class="pop_bnt">
                <input type="button" class="btn btn-primary" name="Update" id="update_comment<?php echo $commentList->id ?>" value="Update" onclick="editTaskCommentValue(<?php echo $commentList->id ?>);"/>
                <button class="close" type="button" onclick="hideEditCommentSection({{ $commentList->id }});" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>


            {{ Form::close() }}
        </div>
    </div>


    <?php
}
?>