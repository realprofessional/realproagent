@section('title', TITLE_FOR_PAGES.' Join Project')
@extends('layouts/adminlayout')
@section('content')

<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script> 

<script type="text/javascript">
    $(document).ready(function() {
        $.validator.addMethod("pass", function(value, element) {
            return  this.optional(element) || (/.{8,}/.test(value) && /([0-9].*[a-z])|([a-z].*[0-9])/.test(value));
        }, "Password minimum length must be 8 characters and contain atleast 1 number."); 
        $.validator.addMethod("contact", function(value, element) {
            return  this.optional(element) || (/^[0-9-]+$/.test(value));
        }, "Contact Number is not valid.");
        $.validator.addMethod("noSpace", function(value, element) { 
            return value.indexOf(" ") < 0 && value != ""; 
        }, "No space allowed.");
        $("#adminAdd").validate(
        {
            rules: {
                account_type: {
                    required: true
                },
                contact: {
                    required: true,
                    maxlength: 16
                    
                }
            }
        }
    );
    });
</script>

<script src="{{ URL::asset('public/js/front/datepicker/jquery.ui.core.js') }}"></script>
<script src="{{ URL::asset('public/js/front/datepicker/jquery.ui.widget.js') }}"></script>
<script src="{{ URL::asset('public/js/front/datepicker/jquery.ui.position.js') }}"></script>
<script src="{{ URL::asset('public/js/front/datepicker/jquery.ui.datepicker.js') }}"></script>
{{ Html::style('public/css/front/front/themes/ui-lightness/jquery.ui.all.css') }} 
<script>
    $(function() {
        $("#searchByDateFrom").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: 'yy-mm-dd',
            numberOfMonths: 1,
            //minDate: 'mm-dd-yyyy',
            maxDate:'yyy-mm-dd',
            changeYear: true,
        });
    });
</script>

<!--<script type="text/javascript">
    $(document).ready(function() {
        $("#city").change(function() {
            $("#area").load("<?php //echo HTTP_PATH . "customer/loadarea/"   ?>"+$(this).val()+"/0");
        })
    });
</script>-->
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <ul id="breadcrumb" class="breadcrumb">
                    <li>
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/admindashboard', "<i class='fa fa-dashboard'></i> Dashboard", array('id' => ''), true)) }}
                    </li>
                    <li>
                        <i class="fa fa-user"></i> 
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/projects/list', "Projects", array('id' => ''), true)) }}
                    </li>
                    <li class="active">Invite Users </li>
                </ul>
                <section class="panel">
                    <header class="panel-heading">
                        Invite Users on {{ $detail->project_name }}
                    </header>

                    <div class="panel-body">
                        {{ View::make('elements.actionMessage')->render() }}
                        <span class="require_sign">Please note that all fields that have an asterisk (*) are required. </span>
                        {{ Form::model($detail, array('url' => '/admin/projects/inviteUser/'.$detail->slug, 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"cmxform form-horizontal tasi-form form")) }}
                        <div class="form-group">
                            {{ Html::decode(Form::label('type', "Choose Invite Method <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-2 new_s" >
                                {{ Form::radio('type', '1', false, array('class'=>'required', 'id'=>'task_board_users', "onchange"=>"show_user(this.value);")) }}
                                {{ Form::label('task_board_users', 'Task Board Users') }}
                            </div>
                            <div class="col-lg-8 new_s">
                                {{ Form::radio('type', '2', false, array('class'=>'required', 'id'=>'email_addresses', "onchange"=>"show_user(this.value);")) }}
                                {{ Form::label('email_addresses', 'Invite User By Email Address') }}
                            </div>
                        </div>


                        <div class="form-group" id="select_pm" style="display:none">
                            {{ Html::decode(Form::label('user_id', "Select Project Manager <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{Form::select('user_id', [null=>'Select Project Manager'] + $users,Input::old('user_id'),array('class'=>'required form-control','id'=>'user_id','onchange'=>"checkuser(this.options[this.selectedIndex].value);"))}}
                            </div>
                        </div>

                        <div class="form-group" id="select_nm" style="display:none">
                            {{ Html::decode(Form::label('project_name', "Email Address <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('email_address', Input::old('email_address'), array('class' => 'required form-control email ',"placeholder"=>"Email Address")) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                {{ Form::submit('Invite', array('class' => "btn btn-success",'onclick' => 'return imageValidation();')) }}
                                {{ html_entity_decode(Html::link(HTTP_PATH.'admin/projects/list', "Cancel", array('class' => 'btn btn-default'), true)) }}
                            </div>
                        </div>

                        {{ Form::close() }}

                    </div>


                </section>
            </div>

        </div>
    </section>
</section>
<script>
    function in_array(needle, haystack) {
        for (var i = 0, j = haystack.length; i < j; i++) {
            if (needle == haystack[i])
                return true;
        }
        return false;
    }

    function getExt(filename) {
        var dot_pos = filename.lastIndexOf(".");
        if (dot_pos == -1)
            return "";
        return filename.substr(dot_pos + 1).toLowerCase();
    }



    function imageValidation() {

        var filename = document.getElementById("profile_image").value;

        var filetype = ['jpeg', 'png', 'jpg', 'gif'];
        if (filename != '') {
            var ext = getExt(filename);
            ext = ext.toLowerCase();
            var checktype = in_array(ext, filetype);
            if (!checktype) {
                alert(ext + " file not allowed for Profile Image.");
                document.getElementById("profile_image").value = "";
                return false;
            } else {
                var fi = document.getElementById('profile_image');
                var filesize = fi.files[0].size;
                if (filesize > 2097152) {
                    alert('Maximum 2MB file size allowed for Profile Image.');
                    document.getElementById("profile_image").value = "";
                    return false;
                }
            }
        }
        return true;
    }

</script>
<script type="text/javascript">
    function show_user(value) {
        if (value == '2') {
            $("#select_pm").hide();
            $("#select_nm").show();
        } else {
            $("#select_pm").show();
            $("#select_nm").hide();
        }
    }
</script>

@stop