<?php $checkBoxesValueList = DB::table('checklistvalues')->where('id', $checklistvalues)->first(); ?>
<?php $varVal = $checkBoxesValueList->is_checked == 0 ? null : true;
?>
{{ Form::open(array('id' => 'checkboxTick'.$checkBoxesValueList->id, 'files' => true,'class'=>"")) }}
{{Form::checkbox('is_checked', '1', $varVal, array('class'=>'required checkbox_clss','id'=>'checkbox_idd_ppup'.$checkBoxesValueList->id,'onchange'=>"submitChecboxValueData($checkBoxesValueList->id);"))}}
<input type="hidden" id="" name="checked_by" value="{{ Session::get('user_id') }}" >
<input type="hidden" id="" name="checboxvalue_id" value="{{ $checkBoxesValueList->id }}" >
<input type="hidden" name="checkbox_fr_bar" id="checkbox_fr_bar{{ $checkBoxesValueList->id }}" value="{{ $checkBoxesValueList->checklist_id }}" >
<input type="hidden" name="testtt" class="checkbox_percentage{{ $checkBoxesValueList->checklist_id }}" value="{{ $percentage }}" >
{{ $checkBoxesValueList->checkbox_value  }}   
{{ Form::close() }}

