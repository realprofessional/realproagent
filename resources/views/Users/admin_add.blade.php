@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Add User')
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

<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <ul id="breadcrumb" class="breadcrumb">
                    <li>
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/admindashboard', '<i class="fa fa-dashboard"></i> Dashboard', array('id' => ''), true)) }}
                    </li>
                    <li>
                        <i class="fa fa-user"></i> 
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/user/userlist', "User", array('id' => ''), true)) }}
                    </li>
                    <li class="active">Add User</li>
                </ul>

                <section class="panel">

                    <header class="panel-heading">
                        Add User
                    </header>

                    <div class="panel-body">
                        {{ View::make('elements.actionMessage')->render() }}
                        <span class="require_sign">Please note that all fields that have an asterisk (*) are required. </span>
                        {{ Form::open(array('url' => 'admin/user/adduser', 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"cmxform form-horizontal tasi-form form")) }}
<!--                        <div class="form-group">
                            {{ Html::decode(Form::label('user_name', "Username <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('user_name', Input::old('user_name'), array('class' => 'required form-control noSpace')) }}
                            </div>
                        </div>-->



                        <div class="form-group">
                            <?php
                                    $userTypeArray = array();
                                    $usertypes = DB::table('usertypes')
                                            ->where('status', 1)
                                            ->orderby('created', 'ASC')
                                            ->get();

                                    foreach ($usertypes as $usertypes) {
                                        $userTypeArray[$usertypes->id] = ucwords($usertypes->type);
                                    }
                                    ?>
                            {{ Html::decode(Form::label('user_type', "User Type <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{Form::select('user_type', [null=>'Select User Type'] + $userTypeArray,Input::old('user_type'),array('class'=>'required form-control','id'=>'user_type'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('first_name', "First Name <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('first_name', Input::old('first_name'), array('class' => 'required form-control noSpace',"placeholder"=>"First Name")) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('last_name', "Last Name <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('last_name',Input::old('last_name'), array('class' => 'required form-control noSpace',"placeholder"=>"Last Name")) }} 
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {{ Html::decode(Form::label('email_address', "Email Address <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('email_address', Input::old('email_address'), array('class' => 'required email form-control',"placeholder"=>"Email Address")) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('password', "Password <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{  Form::password('password',  array('type'=>'password','class' => 'required form-control','minlength' => 8, 'maxlength' => '40','id'=>"password","placeholder"=>"Password"))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('cpassword', "Confirm Password <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::password('cpassword',  array('type'=>'password','class' => 'required form-control','maxlength' => '40', 'equalTo' => '#password',"placeholder"=>"Confirm Password")) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('contact', "Contact Number <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('contact',Input::old('contact'), array('class' => 'required number form-control',"minlength"=>"10",'maxlength'=>'16',"placeholder"=>"Contact Number"))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('address', "Address1 <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('address',Input::old('address'), array('class' => 'form-control required',"placeholder"=>"Address1"))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('address2', "Address2 ",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('address2',Input::old('address2'), array('class' => 'form-control',"placeholder"=>"Address2"))}}
                            </div>
                        </div>
                        
<!--                        <div class="form-group">
                            {{ Html::decode(Form::label('country', "Country <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('country',Input::old('country'), array('class' => 'form-control required'))}}
                            </div>
                        </div>-->


                        
                        <div class="form-group">
                            
                            {{ Html::decode(  Form::label('profile_image', "Profile Image <span class='require'></span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::file('profile_image',array('class'=>'','onchange' => 'return imageValidation();')); }}
                                <p class="help-block">Supported File Types: gif, jpg, jpeg, png. Max size 2MB.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                {{ Form::submit('Save', array('class' => "btn btn-success",'onclick' => 'return imageValidation();')) }}
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