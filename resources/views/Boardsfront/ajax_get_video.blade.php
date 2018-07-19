<?php
if ($attachmentInfo) {

    $filePath = UPLOAD_FULL_ATTACHMENT_IMAGE_PATH . "/" . $attachmentInfo->attachment;
    if (file_exists($filePath) && $attachmentInfo->attachment != "") { 
        ?>
        <video width="100%" controls>
            <source src="<?php echo "../" . DISPLAY_FULL_ATTACHMENT_IMAGE_PATH . $attachmentInfo->attachment ?>" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>     
        <?php
    }
}