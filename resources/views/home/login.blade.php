
@section('content')
<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
    $("#login-form").validate();
    $("#password-recovery").validate();
       $(".butnclose").click(function() {
    $("#password-recovery").validate().resetForm();
    $('.alert-danger').hide();
    
});
});
</script>

<?php 
        $cookie_username = Cookie::get('admin_username'); 
        $cookie_password = Cookie::get('admin_password'); 
        $cookie_rem = Cookie::get('admin_rem'); 
    ?>
<section class="tack_srs">
    <div class="wrapper_login">
        <?php echo Form::open(array('url' => '/login', 'method' => 'post', 'id' => 'login-form', 'class' => '')); ?>
        <div class="login_bx">
            <h2>Login Now</h2>
            {{ View::make('elements.actionMessage')->render() }}
            <div class="login_form">
<!--                <p>User Name</p>-->
                
                <?php
                if (isset($_GET['invid']) && !empty($_GET['invid'])) {
                    $invid = $_GET['invid'];
                } else {
                    $invid = 0;
                }
                
                if (isset($_GET['email_address']) && !empty($_GET['email_address'])) {
                    $getEmail = str_replace(" ", "+", $_GET['email_address']);
                    
                } else {
                    $getEmail = '';
                }
                
                if(!empty($cookie_username)){
                    $cookie_username = $getEmail;
                }
                
                echo $cookie_username;
                
                ?>
                
                <div class="input_type">
                    <?php echo Form::text('emailaddress', !empty($getEmail) ? $getEmail : $cookie_username , array('id' => 'login', 'autofocus' => true, 'class' => "required email", 'placeholder' => 'Enter Email Address')); ?>
                </div>
                <div class="input_type">
                    <?php
                    echo Form::input('password','password', !empty($getEmail) ? "" : $cookie_password,array('id' => 'pass', 'class' => "required form-control", 'placeholder' => 'Password'));
                    // check captcha code here
                    if (Session::has('captcha')) {
                        $class = "";
                    } else {
                        $class = "captcha_show";
                    }
                    ?>
                </div>
                <style>
                .captcha_show{display: none !important;}
                .captcha-section{display: block}

                </style> 
                <div class="<?php echo $class; ?> input_type">
                    <img src="<?php echo HTTP_PATH; ?>captcha?rand=<?php echo rand(); ?>" id='captchaimg' >
                    <a href='javascript: refreshCaptcha();'>
                        <img src="{{ URL::asset('public/img') }}/captcha_refresh.gif" width="35" height="35" alt="">
                    </a>
                    <?php
                    echo Form::text('captcha', null, array('id' => 'captcha', 'autofocus' => true, 'class' => "required ", 'placeholder' => 'Enter Above Image Text'));
                    ?>
                </div>
                <div class="form__remember">
        
                    <input type="checkbox" name="remember" id="remember-in-inline" class="in-checkbox"  <?php if($cookie_rem=='1'){ echo 'Checked'; } ?> value="1"> <label for="remember-in-inline" class="in-label"><?php echo trans('Remember Me'); ?></label>

               </div>
                
                
                <input type="hidden" name="invid" value="{{$invid}}">         
                <input type="hidden" name="getEmail" value="{{$getEmail}}">

                <div class="input_type input_submit">
                    <?php
                    echo Form::submit('Login', array('class' => ''));
                    ?>
                </div>
                <div class="for_got_pass"><a href="{{HTTP_PATH}}user/forgotpassword">Forgot/Reset Password</a></div>
                <div class="register_link">Don't have account? <a href="{{HTTP_PATH}}signup">Sign Up Now</a></div>
            </div>
        </div>
    </div>
    
</section>

   

<script>

    function refreshCaptcha()
    {

        var img = document.images['captchaimg'];
        var img_reset = document.images['captchaimg_reset'];
        img_reset.src = img.src = img.src.substring(0, img.src.lastIndexOf("?")) + "?rand=" + Math.random() * 1000;

    }
</script> 


@stop