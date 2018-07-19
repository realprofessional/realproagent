<style>
    .modal {
        bottom: 0;
        display: none;
        left: 22% !important;
        outline: 0 none;
        overflow: visible !important;
        position: absolute !important;
        right: 0;
        top: 0;
        width: 510px;
        z-index: 1050;
    }

</style>

<div class="pop_up_task_name attachment_in_sec" >
    <i class="fa fa-paperclip" aria-hidden="true"></i>
    <label> Attachments</label>
</div>
<div class="attach_control">
    <?php
    if ($attachmentData) {
        foreach ($attachmentData as $attachment) {
            ?>
            <div class="attachment_main" id="attachment_main_<?php echo $attachment->id; ?>">
                <div class="attachment_left">
                    <?php
                    $tmpp = explode('.', $attachment->attachment);
                    $file_ext = strtolower(end($tmpp));

                    if ($file_ext == "png" || $file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "gif") {

                        if (file_exists(UPLOAD_FULL_ATTACHMENT_IMAGE_PATH . '/' . $attachment->attachment) && $attachment->attachment != "") {
                            ?>

                            <a href="{{HTTP_PATH.DISPLAY_FULL_ATTACHMENT_IMAGE_PATH.$attachment->attachment}}" data-lightbox="images">
                                {{ Html::image(DISPLAY_FULL_ATTACHMENT_IMAGE_PATH.$attachment->attachment, '', array('alt'=>'Attachment', 'class'=>'attachment-thumbnail size-thumbnail')) }}
                            </a>



                        <?php } else {
                            ?>
                            <img src="{{HTTP_PATH}}public/img/front/man-user.svg" alt="User Img">
                            <?php
                        }
                    } elseif ($file_ext == "doc") {
                        ?>
                        <img src="{{HTTP_PATH}}public/img/front/doc.png" alt="User Img" width="80" hright="60">
                        <?php
                    } elseif ($file_ext == "docx") {
                        ?>
                        <img src="{{HTTP_PATH}}public/img/front/docx.png" alt="User Img" width="80" hright="60">
                        <?php
                    } elseif ($file_ext == "pdf") {
                        ?>
                        <img src="{{HTTP_PATH}}public/img/front/pdf.png" alt="User Img" width="80" hright="60">
                        <?php
                    } elseif ($file_ext == "mp4") {
                        $fieldSlug = $attachment->attachment;
                        $fieldid = $attachment->id;
                        ?>
                        <a href="javascript:void(0);" onclick="getVideo({{$fieldid}})">
                            <img src="{{HTTP_PATH}}public/img/front/mp4.png" alt="User Img" width="80" hright="60">
                        </a>

                        <div id="myModal<?php echo $fieldid; ?>" class="modal" >
                            <div class="modal-content butsmall">
                                <span onclick="closeBox('<?php echo $fieldid; ?>')" class="close">&times;</span>
                                <div class="maindivVideo" id="videoBox<?php echo $fieldid; ?>"><div id="loaderID" style="display: block" class="searchloader"></div></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>



                <div class="attachment_right">
                    <div class="attachment_in_on">
                        <?php
                        if (file_exists(UPLOAD_FULL_ATTACHMENT_IMAGE_PATH . '/' . $attachment->attachment) && $attachment->attachment != "") {
                            echo $attachment->attachment;
                        }
                        ?>
                        <a href="{{HTTP_PATH}}attachment/download/{{$attachment->attachment}}">Download <i class="fa fa-external-link " aria-hidden="true"></i></a>

                    </div>
                    <div class="attachment_in_tw">
                        <span class="__at1">
                            <?php echo date('F d, Y H:i a', strtotime($attachment->created)); ?>
                        </span>
                        <span class="__at2">
                            <a href="javascript:void(0)"  onclick="deleteAttachment({{ $attachment->id }});"> Delete </a>
                        </span>
                    </div>

                </div>
            </div>

            <?php
        }
    }
    ?>
</div>

<script>
    function getVideo(value) { 
        $('.modal').hide();
        $('#myModal'+value).show();
        $.ajax({
            type: 'POST',
            url: "<?php echo HTTP_PATH; ?>attachment/getVideo/" + value,
            cache: false,
            success: function (result) {
                $('#videoBox'+value).html(result);
                //                $('html, body').animate({ scrollTop: $('#myModal'+value).offset().top-10 }, 'slow');
            },
            error: function () {
                console.log('there was a problem checking the fields');
            }
        });
    }
    function closeBox(value) {
        $('#myModal'+value).hide();
    }
    
    
    function deleteAttachment(id) {
        var cnfrmm = confirm("Are you sure, You Want to delete?");
        if (cnfrmm) {
            if (id == '' || slug == "") {
                alert("Invalid Request");
                return;
            } else {
                var data = {
                    id: id
                };
            
                $.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_PATH; ?>board/deleteAttachment/',
                    data: data,
                    beforeSend: function () {
                        $('html, body').css("cursor", "wait");
                    },
                    success: function (result) {
                        $('html, body').css("cursor", "auto");
                        if(result == 1){
                            $("#main-check-sectionb-ppp" + id).fadeOut(1000);
                        }else{
                            alert("An Error Occurred")
                        }
                    
                    }
                });
            }
        }
    }
            
          

</script>