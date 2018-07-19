
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
        $("#profile-edit-form").validate({
            rules: {
                account_type: {
                    required: true
                },
                contact: {
                    required: true,
                    maxlength: 16
                    
                }
            }
        });
    });
</script>

{{ Html::script('public/js/front/jquery.bpopup.js') }}

<?php echo Input::old('first_name') ?>

<div class="acc_deack">
    <div class="wrapper">
        <nav class="breadcrumbs">
            <div class="container">
                <ul>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>">Home</a></li>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>account">Account</a></li>
                    <li class="breadcrumbs__item">Edit Profile</li>

                </ul>
            </div>
        </nav>
        <div class="space">

            <div class="panel-body"><div class="container">

                    @include('elements/user_account_sidebar')
                    <div class="main_container">
                        <div class="widget__header">
                            <h1 class="widget__title">Edit Profile</h1> 
                        </div>     

                        <div class="profile">
                            {{ View::make('elements.actionMessage')->render() }}
                            <span class="require_sign">Please note that all fields that have an asterisk (*) are required. </span>
                            {{ Form::model($user,array('url' => '/user/editprofile', 'files' => true, 'id'=>'profile-edit-form')) }}

                            <div class="register_fields">

                                {{ Html::decode(Form::label('first_name', "First Name <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                <div class="input_ty">
                                    {{ Form::text('first_name',Input::old('first_name'),array('id' => 'first_name', 'class' => 'required form-control noSpace', 'placeholder' => 'First Name')) }}
                                </div>
                            </div>
                            <div class="register_fields">
                                {{ Html::decode(Form::label('last_name', "Last Name <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                <div class="input_ty">
                                    {{ Form::text('last_name',Input::old('last_name'),array('id' => 'last_name', 'class' => 'required form-control noSpace' , 'placeholder' => 'Last Name')) }}
                                </div>
                            </div>
                            <div class="register_fields">
                                {{ Html::decode(Form::label('title', "Title <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                <div class="input_ty">
                                    {{ Form::text('title',Input::old('title'),array('id' => 'title', 'class' => 'form-control noSpace' , 'placeholder' => 'Title')) }}
                                </div>
                            </div>
                            <div class="register_fields">

                                {{ Html::decode(Form::label('email_address', "Email <span class='require'></span>",array('class'=>"control-label col-lg-2"))) }}
                                <div class="input_ty email_typ">   
                                    {{ $user->email_address }}
                                </div>
                            </div>
                            <div class="register_fields">

                                {{ Html::decode(Form::label('contact', "Contact Number <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                <div class="input_ty">
                                    {{ Form::text('contact',Input::old('contact'),array('id' => 'contact', 'minlength' => 10, 'maxlength' => '16', 'class' => 'required form-control contact' , 'placeholder' => 'Contact Number')) }}
                                </div>
                            </div>

                            <div class="register_fields"> 

                                {{ Html::decode(Form::label('address1  ', "Address  1 <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                <div class="input_ty">
                                    {{ Form::text('address1',$user->address,array('id' => 'address1', 'class' => 'required form-control', 'placeholder' => 'Address 1')) }}
                                </div>
                            </div>
                            <div class="register_fields">

                                {{ Html::decode(Form::label('address  2', "Address  2",array('class'=>"control-label col-lg-2"))) }}
                                <div class="input_ty">
                                    {{ Form::text('address2',Input::old('address2'),array('id' => 'address2', 'class' => 'form-control', 'placeholder' => 'Address 2')) }}
                                </div>
                            </div>
                            
                             <div class="register_fields">

                                {{ Html::decode(Form::label('company_name', "Company Name",array('class'=>"control-label col-lg-2"))) }}
                                <div class="input_ty">
                                    {{ Form::text('company_name',Input::old('company_name'),array('id' => 'company_name', 'class' => 'form-control', 'placeholder' => 'Company Name')) }}
                                </div>
                            </div>

                            <div class="register_fields">
                                {{ Html::decode(Form::label('address  2', "Turn Off Notification ",array('class'=>"control-label col-lg-2"))) }}
                                <div class="input_ty input_ty_chhu">
                                    <input type="checkbox" name="turn_off_notification" id="turn_off_notification" class="in-checkbox"  <?php if ($user->turn_off_notification == '1') { echo 'Checked'; } ?> value="1"> 
                                </div>
                            </div>



                            <div class="register_fields make_field_wide">
                                <label for="account_type" class="control-label col-lg-2" style="width: 100%;">Fill password & confirm password only when you want to change password.</label>
                                <div class="radio_area">

                                </div>
                            </div>


                            <div class="register_fields">
                                {{ Html::decode(Form::label('password', "Password <span class='require'></span>",array('class'=>"control-label col-lg-2"))) }}
                                <div class="input_ty">
                                    {{  Form::password('password',  array('type'=>'password','class' => 'form-control','minlength' => 8, 'maxlength' => '40','id'=>"password", 'placeholder' => 'Password'))}}
                                </div>
                            </div>
                            <div class="register_fields"> 
                                {{ Html::decode(Form::label('cpassword', "Confirm Password <span class='require'></span>",array('class'=>"control-label col-lg-2"))) }}
                                <div class="input_ty">    
                                    {{ Form::password('cpassword',  array('type'=>'password','class' => 'form-control','maxlength' => '40', 'equalTo' => '#password', 'placeholder' => 'Confirm Password')) }}
                                </div>
                            </div>

                            <div class="register_fields">
                                <label>&nbsp;</label>
                                <div class="input_ty">
                                    {{ Form::submit('Update', array('class' => "btn btn-danger",'onclick' => 'return imageValidation();')) }}
                                    <a class=" cancel_bttn" href="{{HTTP_PATH}}account">Cancel</a>
                                </div>

                            </div>

                            {{ Form::close() }}



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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