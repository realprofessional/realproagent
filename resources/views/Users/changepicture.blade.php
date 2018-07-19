<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
@section('content')
<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#profile-edit-form").validate();
    });
</script>
<div class="acc_deack">
    <div class="wrapper">
        <nav class="breadcrumbs">
          <div class="container">
            <ul>
              <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>">Home</a></li>
              <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>account">Account</a></li>
              <li class="breadcrumbs__item">Change Picture</li>
              
            </ul>
          </div>
        </nav>
        <div class="space">

        <div class="panel-body"><div class="container">

                @include('elements/user_account_sidebar')
                <div class="main_container">
<div class="widget__header">
                                        <h1 class="widget__title">Change Picture</h1> 
                                      </div>     
                    <div class="profile">
                        {{ Form::model($user,array('url' => '/user/changepicture', 'files' => true, 'id'=>'profile-edit-form')) }}
                        {{ View::make('elements.actionMessage')->render() }}
                        <div class="register_fields">
                            <label>&nbsp;</label>
                            <div class="input_ty">
                                <div class="old_profile_pic">
                            <?php if (file_exists(UPLOAD_FULL_PROFILE_IMAGE_PATH . '/' . $user->profile_image) && $user->profile_image != "") { ?>
                                    {{ Html::image(DISPLAY_FULL_PROFILE_IMAGE_PATH.$user->profile_image, '', array('alt'=>'User Img')) }}
                                   <div class="delete_profile"><a href="{{HTTP_PATH}}user/deletepicture"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>
                            <?php }else{
                                    ?>
                                
                                <img src="{{HTTP_PATH}}public/img/front/man-user.svg" alt="User Img">
                                <?php
                                    
                                    
                                } ?> 
                                   
                                </div>
                        </div>
                        
                    </div>
                        
                    <div class="register_fields">
                            <label>New Profile Picture<span class="require">*</span></label>
                        <div class="input_ty">
                            {{ Form::file('profile_image',array('class'=>'required','onchange' => 'return imageValidation();')); }}
                            <p class="help-block">Supported File Types: gif, jpg, jpeg, png. Max size 2MB.</p>
                        </div>
                        
                    </div>
                    <div class="register_fields">
                            <label>&nbsp;</label>
                            <div class="input_ty">
                                {{ Form::submit('Update', array('class' => "btn btn-danger",'onclick' => 'return imageValidation();')) }}
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