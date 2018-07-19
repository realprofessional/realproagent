
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
        $("#profile-edit-form").validate({
            rules: {
                account_type: {
                    required: true
                }
            }
        });
    });
</script>

{{ Html::script('public/js/front/jquery.bpopup.js') }}


<div class="wrapper">
    <nav class="breadcrumbs">
        <div class="container">
            <ul>
                <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>">Home</a></li>
                <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>account">Account</a></li>
                <li class="breadcrumbs__item">View Profile</li>

            </ul>
        </div>
    </nav>
    <div class="space">

        <div class="panel-body"><div class="container two_part">

                @include('elements/user_account_sidebar')
                <div class="main_container addition_css">
                    {{ View::make('elements.actionMessage')->render() }}
                    <div class="widget js-widget widget--dashboard">
                    <div class="widget__header">
                        <h2 class="widget__title">View Profile</h2> 
                        <a class="widget__btn js-widget-btn" href="{{HTTP_PATH}}user/editprofile">Edit Profile</a>
                    </div>     

                    <div class="panel-body">
<div class="profile_wrap">  
                            <div  class="title_profile"> {{ Html::decode(Form::label('profile_image', "Profile Image",array('class'=>"control-label col-lg-2"))) }}</div>
                            <div class="register_fields profile_left">


                                <?php if (file_exists(UPLOAD_FULL_PROFILE_IMAGE_PATH . '/' . $user->profile_image) && $user->profile_image != "") { ?>
                                    <div class="form-group">
                                    
                                        <div class="col-lg-10 img_sel">
                                            {{ Html::image(DISPLAY_FULL_PROFILE_IMAGE_PATH.$user->profile_image, '', array('width' => '100px')) }}
                                        </div>
                                    </div>
                                <?php }else{
                                    ?>
                                
                                <div class="form-group">
                                    
                                        <div class="col-lg-10 img_sel">
                                            {{ Html::image(HTTP_PATH.'public/img/front/profile_image.png', '', array('width' => '100px')) }}
                                        </div>
                                    </div>
                                <?php
                                    
                                    
                                } ?> 
                                
                                

                            </div>
                            



                        </div>


                        <div class="register_fields">

                            {{ Html::decode(Form::label('first_name', "First Name",array('class'=>"control-label col-lg-2"))) }}
                            <div class="section_name">
                                {{$user->first_name}}
                            </div>

                        </div>
                        <div class="register_fields">

                            {{ Html::decode(Form::label('last_name', "Last Name",array('class'=>"control-label col-lg-2"))) }}
                            <div class="section_name">
                                {{$user->last_name}}
                            </div>
                        </div>
                        <div class="register_fields make_field_wide">

                            {{ Html::decode(Form::label('account_type', "Account Type",array('class'=>"control-label col-lg-2"))) }}
                            <div class="radio_area">
                                {{$user->user_type}}    

                                <!--                                {{ Html::decode(Form::label('seller_buyer', "Seller/Buyer Account",array('class'=>"control-label col-lg-2"))) }}
                                                                @if($user->user_type=='Seller/Buyer')
                                                                {{Form::radio('account_type', 'Seller/Buyer', true, array('id'=>'seller_buyer'))}}
                                                                @else     
                                                                {{Form::radio('account_type', 'Seller/Buyer', false, array('id'=>'seller_buyer'))}}
                                                                @endif
                                                                {{ Html::decode(Form::label('team_leader', "Team Leader Account",array('class'=>"control-label col-lg-2"))) }}
                                                                @if($user->user_type=='Team Leader')
                                                                {{Form::radio('account_type', 'Team Leader', true, array('id'=>'team_leader'))}}
                                                                @else     
                                
                                                                {{Form::radio('account_type', 'Team Leader', false, array('id'=>'team_leader'))}}
                                                                @endif-->
                            </div>
                        </div>
                        <div class="register_fields">

                            {{ Html::decode(Form::label('email_address', "Email",array('class'=>"control-label col-lg-2"))) }}

                            <div class="section_name">
                                {{$user->email_address}}
                            </div>
                        </div>
                        <div class="register_fields">

                            {{ Html::decode(Form::label('contact', "Contact Number",array('class'=>"control-label col-lg-2"))) }}

                            <div class="section_name">
                                {{$user->contact}}
                            </div>
                        </div>


                        <div class="register_fields"> 

                            {{ Html::decode(Form::label('address1  ', "Address  1",array('class'=>"control-label col-lg-2"))) }}
                            <div class="section_name">
                                {{$user->address}}
                            </div>

                        </div>
                        <div class="register_fields">

                            {{ Html::decode(Form::label('address2', "Address 2",array('class'=>"control-label col-lg-2"))) }}

                            <div class="section_name">
                                {{$user->address2}}
                            </div>
                        </div>
                        <div class="register_fields">

                            {{ Html::decode(Form::label('city', "City",array('class'=>"control-label col-lg-2"))) }}

                            <div class="section_name">
                                {{$user->city}}
                            </div>
                        </div>
                        <div class="register_fields">

                            {{ Html::decode(Form::label('state', "State",array('class'=>"control-label col-lg-2"))) }}

                            <div class="section_name">
                                {{$user->state}}
                            </div>
                        </div>

                        <div class="register_fields">

                            {{ Html::decode(Form::label('country', "Country",array('class'=>"control-label col-lg-2"))) }}

                             <div class="section_name">
                                {{$user->country}}
                            </div>
                        </div>
                        <div class="register_fields">

                            {{ Html::decode(Form::label('postcode', "Post Code",array('class'=>"control-label col-lg-2"))) }}

                          <div class="section_name">
                                {{$user->postcode}}
                            </div>
                        </div>
                        





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