<?php $checkBoxesList = DB::table('checklists')->where('id', $checklists)->first(); ?>
<div id="main-check-sectionb-ppp{{ $checkBoxesList->id }}">
    <div class="check-list-first-section">
        <div class="check-list-first-section-inner">
            <i class="fa fa-check-square-o" aria-hidden="true"></i>
            {{ $checkBoxesList->checkbox_title  }}
        </div>
        <div class="check-list-first-section-inner-two">
            <a href="javascript:void(0)"  onclick="deleteTaskCheckboxSection({{ $checkBoxesList->id }}, '{{ $checkBoxesList->slug }} ');"> Delete </a>
        </div>
    </div>

    <div class="check-first-second-section">
        <span class="checkbox-perr" id="checkbox-perr-val{{ $checkBoxesList->id }}"> 0% </span>
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="0" 
                 aria-valuemin="0" aria-valuemax="100" style="width:0%" id="checkbox-perr-valinbar{{ $checkBoxesList->id }}">
            </div>
        </div>
    </div>
    <?php $checkBoxesValueLists = DB::table('checklistvalues')->where('checklist_id', $checkBoxesList->id)->orderBy('checklistvalues.id', 'ASC')->get(); ?>

    <div class="check-first-third-section">
        <div id="update-section-checbox-value-info{{ $checkBoxesList->id }}">
            <?php
            if ($checkBoxesValueLists) {
                foreach ($checkBoxesValueLists as $checkBoxesValueList) {
                    $varVal = $checkBoxesValueList->is_checked == 0 ? null : true;
                    ?>

                    {{ Form::open(array('id' => 'checkboxTick'.$checkBoxesValueList->id, 'files' => true,'class'=>"")) }}
                    {{Form::checkbox('is_checked', '1', $varVal, array('class'=>'required checkbox_clss','id'=>'checkbox_idd_ppup'.$checkBoxesValueList->id,'onchange'=>"submitChecboxValueData($checkBoxesValueList->id);"))}}
                    <input type="hidden" id="" name="checked_by" value="{{ Session::get('user_id') }}" >
                    <input type="hidden" id="" name="checboxvalue_id" value="{{ $checkBoxesValueList->id }}" >
                    {{ $checkBoxesValueList->checkbox_value  }}   
                    {{ Form::close() }}

                    <?php
                }
            }
            ?>
        </div>

        <div class="add_an_item_ppup" id="task_checkbox_additem_ppup{{ $checkBoxesList->id }}">
            <a href="javascript:void(0)"  onclick="showTaskCheckboxvalueSection({{ $checkBoxesList->id }});">
                Add an item
            </a>
        </div>

        <div class="add_an_item_ppup_form_dt" id="task_checkbox_valuee_form_ppup{{ $checkBoxesList->id }}" style="display:none">
            {{ Form::open(array('id' => 'addcheckboxitem'.$checkBoxesList->id, 'files' => true,'class'=>"")) }}
            {{ Form::textarea('checkbox_value', Input::old('checkbox_value'),   array('rows'=> '2', 'class' => 'required form-control noSpace',  "placeholder"=>"Checkbox Value", "id"=> "add_checkbox_value".$checkBoxesList->id)) }}
            <input type="hidden" id="" name="task_id" value="<?php echo $checkBoxesList->task_id ?>" >
            <input type="hidden" id="" name="board_id" value="<?php echo $checkBoxesList->board_id ?>" >
            <input type="hidden" id="" name="checklist_id" value="<?php echo $checkBoxesList->id ?>" >
            <input type="button" class="btn btn-primary" name="comment" id="submit_checkbox<?php echo $checkBoxesList->id ?>" value="Add" onclick="addTaskChecklistValue(<?php echo $checkBoxesList->id ?>);"/>
            <button type="button" onclick="hideTaskCheckboxvalueSection(<?php echo $checkBoxesList->id ?>);" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ Form::close() }}
        </div>         
    </div>
</div>