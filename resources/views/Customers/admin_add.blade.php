@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Add Customer')
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
        }, "No space please and don't leave it empty");
        $("#adminAdd").validate();
    });
    
    



    
</script>
<?php
//DB::setFetchMode(PDO::FETCH_ASSOC);
//$users = DB::table('users')->get();
//echo "<pre>";
//print_r($users);
//exit;
?>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <ul id="breadcrumb" class="breadcrumb">
                    <li>
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/admindashboard', '<i class="fa fa-dashboard"></i> Dashboard', array('id' => ''), true)) }}
                    </li>
                    <li>
                        <i class="fa fa-users"></i> 
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/customer/admin_index', "Customers", array('id' => ''), true)) }}
                    </li>
                    <li class="active">Add Customer</li>
                </ul>

                <section class="panel">

                    <header class="panel-heading">
                        Add Customer
                    </header>

                    <div class="panel-body">
                        {{ View::make('elements.actionMessage')->render() }}
                        <span class="require_sign">Please note that all fields that have an asterisk (*) are required. </span>
                        {{ Form::open(array('url' => 'admin/customer/admin_add', 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"cmxform form-horizontal tasi-form form")) }}
                        <div class="form-group">
                            {{ Html::decode(Form::label('user_name', "Username <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('user_name',Input::old('user_name'), array('class' => 'required form-control noSpace')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('first_name', "First Name <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('first_name',Input::old('first_name'), array('class' => 'required form-control')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('last_name', "Last Name <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('last_name',Input::old('last_name'), array('class' => 'required form-control')) }} 
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('gender', "Gender <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                <?php
                                $cities_array = array(
                                    '' => 'Please Select'
                                );
                                $cities_array['Male'] = 'Male';
                                $cities_array['Female'] = 'Female';
                                ?>
                              {{ Form::select('gender', $cities_array, Input::old('gender'), array('class' => 'required  form-control', 'id'=>'gender')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('email_address', "Email Address <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('email_address',Input::old('email_address'), array('class' => 'required email form-control')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('password', "Password <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{  Form::password('password',  array('type'=>'password','class' => 'required form-control','minlength' => 8, 'maxlength' => '40','id'=>"password"))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('confirm_password', "Confirm Password <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::password('confirm_password',  array('type'=>'password','class' => 'required form-control','maxlength' => '40', 'equalTo' => '#password')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('contact_number', "Contact Number <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('contact_number', Input::old('contact_number'), array('class' => 'required number form-control','maxlength'=>'16'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('address', "Address <span class='require'></span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::textarea('address',Input::old('address'), array('class' => 'form-control'))}}
                            </div>
                        </div> 
                        
<!--                        <div class="form-group">
                            {{ Html::decode(Form::label('tell_us_about_yourself', "Tell us About Yourself? <span class='require'></span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::textarea('tell_us_about_yourself',Input::old('tell_us_about_yourself'), array('class' => 'form-control'))}}
                            </div>
                        </div>-->
                        
                        <div class="form-group">
                            {{  Form::label('profile_image', 'Profile Image',array('class'=>"control-label col-lg-2")) }}
                            <div class="col-lg-10">
                                {{ Form::file('profile_image'); }}
                                <p class="help-block">Supported File Types: gif, jpg, jpeg, png. Max size 2MB.</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                {{ Form::submit('Save', array('class' => "btn btn-danger",'onclick' => 'return imageValidation();')) }}
                                {{ Form::reset('Reset', array('class'=>"btn btn-default")) }}
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


@stop