<?php
if (!empty($activityArray)) {
    foreach ($activityArray as $activity) {
        switch ($activity->type) {
            case "create_project":
                $msg = "created this project.";
                break;
            case "create_board":
                $msg = "added " . $activity->board_name . " in this project.";
                break;
            case "create_task":
                $msg = "added " . $activity->task_name . " in board " . $activity->board_name . ".";
                break;
            case "delete_board":
                $msg = "removed " . $activity->message . " from this project.";
                break;
            case "delete_task":
                $msg = "removed " . $activity->message . " from this board " . $activity->board_name . ".";
                break;
            case "copy_board":
                $msg = "copied " . $activity->board_name . " into this project. ";
                break;
            case "move_board":
                $msg = "transferred " . $activity->board_name . " into this project. ";
                break;
            case "copy_task":
                $msg = "copied " . $activity->task_name . " into this board " . $activity->board_name . ".";
                break;
            case "move_task":
                $msg = "transferred " . $activity->task_name . " into this board " . $activity->board_name . ".";
                break;
            case "add_comment":
                $msg = "added a comment on " . $activity->task_name . " of the board " . $activity->board_name . ".";
                break;
            case "add_attachment":
                $msg = "added a attachment on " . $activity->task_name . " of the board " . $activity->board_name . ".";
                break;
            default:
                echo "";
        }
        ?>

      <?php /* ?>  <div class="tast_li_">
            <div class="task_title_"> <?php echo substr($activity->first_name, 0, 1) . substr($activity->last_name, 0, 1) ?> </div>
            <div class="men_activity"><span><?php echo ucfirst($activity->first_name) . " " . ucfirst($activity->last_name) ?></span> <?php echo " " . $msg; ?>

                <p><a href="javascript:void(0)"><?php echo date('F d, Y H:i a', strtotime($activity->created)); ?></a></p></div>
        </div>

<?php */ ?>

        <div class="online_row">
            <span class="profile">
             <?php if(!empty($activity->profile_image)){ ?>
                <img src="{{HTTP_PATH.DISPLAY_FULL_PROFILE_IMAGE_PATH.$activity->profile_image}}" alt="user img">
                <?php }else{ ?>
                <a href="{{HTTP_PATH}}account" class=""><img src="{{HTTP_PATH}}public/img/front/man-user.svg" alt="user img"></a>
                <?php } ?>
                </span>    
            <div class="profile_content">
                <p><?php echo ucfirst($activity->first_name) . " " . ucfirst($activity->last_name) ?></p>
                <?php echo " " . $msg; ?>
            </div>
            <div class="date"><?php echo date('F d, Y H:i a', strtotime($activity->created)); ?></div>

        </div>

        <?php
    }
}
?>