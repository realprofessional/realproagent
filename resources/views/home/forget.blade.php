
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
        <?php echo Form::open(array('url' => '/user/forgotpassword', 'method' => 'post', 'id' => 'login-form', 'class' => '')); ?>
        <div class="login_bx">
            <h2>Forgot Password</h2>
            {{ View::make('elements.actionMessage')->render() }}
            <div class="login_form">
                <div class="input_type">
                    <?php echo Form::text('email', '', array('id' => 'login', 'autofocus' => true, 'class' => "required  email", 'placeholder' => 'Enter Email Address')); ?>
                    
                </div>
                
                
                <div class="input_type input_submit">
                    <?php
                    echo Form::submit('Reset Password', array('class' => ''));
                    ?>
                </div>
                <div class="for_got_pass"><a href="{{HTTP_PATH}}login">Login</a></div>
                <div class="register_link">Don't have account? <a href="{{HTTP_PATH}}signup">Sign Up Now</a></div>
            </div>
        </div>
    </div>
    
</section>
   


@stop