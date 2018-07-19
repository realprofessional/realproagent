<?php
global $arrayType;
foreach ($listOfReminders as $listOfReminder) {
    ?>

    <div class="listt" id="main_remin_ll{{ $listOfReminder->id }}">

        <span class="contt_title">
            <?php
            echo $listOfReminder->title;
            ?>
        </span>
        <span class="content_seccc">
            <?php
            echo $arrayType[$listOfReminder->type];
            echo " " . date('F d, Y h:i A', strtotime($listOfReminder->datetime));
            ?>
        </span> 

        <span class="action_seccc">
            <a  href="javascript:void(0);" data-toggle="modal" data-target="#myModalupdate{{ $listOfReminder->id }}">Edit</a>
            <a  href="javascript:void(0);" onclick="deleteTaskReminder({{ $listOfReminder->id }});">Delete</a>

        </span>
    </div>


    <div class="modal  fade" id="myModalupdate{{ $listOfReminder->id }}" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content reminder_pop">
                <div class="modal-header">
                    <button type="button" id="closeebt{{ $listOfReminder->id }}" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Reminders</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => 'projectboard/updateReminder', 'method' => 'post', 'id' => 'updateReminder'.$listOfReminder->id, 'files' => true,'class'=>"form-inline form")) }}
                    <?php
                    global $arrayType;
                    if ($listOfReminder->type == 2) {
                        $txtMess = 'Message';
                        $style = " style=display:none ";
                    } else {
                        $txtMess = 'Email Subject';
                        $style = " style=display:block ";
                    }
                    ?>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="selectbasic">Type</label>
                        <div class="col-md-12">
                            {{Form::select('type', [null=>'Select Type'] + $arrayType, $listOfReminder->type,array('class'=>'required form-control','id'=>'type_reminder'.$listOfReminder->id,'onchange'=>"typeReminderChange('ckedit_section'.$listOfReminder->id, 'email_subject_reminder'.$listOfReminder->id,'chng_txt'.$listOfReminder->id,this.value);"))}}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Html::decode(Form::label('title', "Campaign Title <span class='require'>*</span>",array('class'=>"control-label col-md-12"))) }}
                        <div class="col-md-12">
                            {{ Form::text('title', $listOfReminder->title, array('class' => 'required form-control ',"placeholder"=>"Campaign Title ")) }}
                        </div>
                    </div>

                    <?php
                    $remdt = date('m/d/Y', strtotime($listOfReminder->datetime));
                    $remtim = date('H:ia', strtotime($listOfReminder->datetime));
                    ?>

                    <div class="form-group">
                        {{ Html::decode(Form::label('title', "Reminder Date and Time <span class='require'>*</span>",array('class'=>"control-label col-md-12"))) }}
                        <div class="col-md-12">
                            {{ Form::text('reminder_date', $remdt , array('class' => 'required form-control noSpace reminder_date', 'readonly' => 'readonly',  'id'=>'reminder_date'.$listOfReminder->id, "placeholder"=>"Select Date")) }}
                            {{ Form::text('reminder_time', $remtim , array('class' => 'required form-control noSpace reminder_time', 'id'=>'reminder_time1'.$listOfReminder->id, "placeholder"=>"Select Time")) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Html::decode(Form::label('email_subject', "<span id='chng_txt$listOfReminder->id'> $txtMess </span><span class='require'>*</span>",array('class'=>"control-label col-md-12"))) }}
                        <div class="col-md-12">
                            {{ Form::text('email_subject', $listOfReminder->email_subject, array('id' => 'email_subject_reminder'.$listOfReminder->id ,'class' => 'required form-control ',"placeholder"=>$txtMess)) }}
                        </div>
                    </div>


                    <div class="form-group" id="ckedit_section{{ $listOfReminder->id }}" <?php echo $style; ?>>
                        {{ Html::decode(Form::label('email_content', "Email Content<span class='require'>*</span>",array(   'class'=>"control-label col-md-12"))) }}
                        <div class="col-md-12">
                            {{ Form::textarea('email_content', $listOfReminder->email_content, array('id' => 'email_content'.$listOfReminder->id, 'rows'=> '2', 'class' => 'required form-control ckeditor',  "placeholder"=>"Email Content")) }}
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-12 pull-right sub_mitt">
                            <input type="hidden" id="" name="reminder_id" value="<?php echo $listOfReminder->id ?>" >
                            <input type="hidden" id="" name="task_id" value="<?php echo $taskDetail->id ?>" >
                            {{ Form::button('Submit', array('class' => "btn btn-primary", 'onclick'=> "updateRemindersection($listOfReminder->id)")) }}
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
                <div class="modal-footer">
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
                    
        
                    
        $(document).ready(function () {
            var idww = "updateReminder<?php echo $listOfReminder->id; ?>";
            $("#"+idww).validate();
        });
                    
                    
    </script>

<?php } ?>


