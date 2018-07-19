@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Admin Login')
@extends('adminloginlayout')
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

<div class="container">
    <?php 
        $cookie_username = Cookie::get('admin_username'); 
        $cookie_password = Cookie::get('admin_password'); 
        $cookie_rem = Cookie::get('admin_rem'); 
    ?>
    <?php echo Form::open(array('url' => 'admin/login', 'method' => 'post', 'id' => 'login-form', 'class' => 'form form-signin')); ?>
    <div class="website-logos">
        <div class="weblogo-in" >
   {{ html_entity_decode(link_to('', Html::image("public/img/front/logo.png", ""), array('escape' => false,'class'=>"logos"))) }}


        </div>
    </div>
    <h2 class="form-signin-heading">Admin Login</h2>
      <title>@yield('title')</title>
    <div class="login-wrap">
        <div id="login-block"></div>
        {{ View::make('elements.actionMessage')->render() }}
        <?php echo Form::text('username', $cookie_username, array('id' => 'login', 'autofocus' => true, 'class' => "required form-control", 'placeholder' => 'Username')); ?>
        <?php
        echo Form::input('password','password',$cookie_password,array('id' => 'pass', 'class' => "required form-control", 'placeholder' => 'Password'));

        // check captcha code here
        if (Session::has('captcha')) {
            $class = "";
        } else {
            $class = "captcha_show";
        }
        ?>
        <div class="<?php echo $class; ?> captcha-section">
            <label for="pass"><span class="big">Security code</span></label>
            <img src="<?php echo HTTP_PATH; ?>captcha?rand=<?php echo rand(); ?>" id='captchaimg' >
            <a href='javascript: refreshCaptcha();'>
                <img src="{{ URL::asset('public/img') }}/captcha_refresh.gif" width="35" height="35" alt="">
            </a>
            <?php
            echo Form::text('captcha', null, array('id' => 'login', 'autofocus' => true, 'class' => "required form-control", 'placeholder' => 'Type security code shown above'));
            ?>
        </div>
        <label class="checkbox">
            <input type="checkbox" name="remember" <?php if($cookie_rem=='1'){ echo 'Checked'; } ?> value="1"> Remember me
            <span class="pull-right">
                <a data-toggle="modal" href="#myModal"> Forgot Password?</a>
            </span>
        </label>
        <?php
        echo Form::submit('Login', array('class' => 'btn btn-lg btn-login btn-block'));
        ?>
    </div>
    <?php
    echo Form::close();
    ?>
    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo Form::open(array('url' => 'admin/forgotpassword', 'method' => 'post', 'id' => 'password-recovery', 'class' => 'form')); ?>

                <div class="modal-header">
                    <button type="button" class="close butnclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Forgot Password ?</h4>
                </div>
                <div class="modal-body">
                    <p>Enter your e-mail address below to reset your password.</p>
                    <div id="forgotpass-block"></div>
                    <input type="text" name="recovery-mail" id="recovery-mail"  placeholder="Email" autocomplete="off" class="required email form-control placeholder-no-fix">
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default butnclose" type="button">Cancel</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
                <?php
                echo Form::close();
                ?>
            </div>
        </div>
    </div>
</div>

<!-- modal -->

<!-- js placed at the end of the document so the pages load faster -->

{{ Html::script('public/js/jquery.js') }}
{{ Html::script('public/js/bootstrap.min.js') }}
{{ Html::script('public/js/jquery.validate.min.js') }}
<!-- example login script -->
<script>

    $(document).ready(function()
    {
        // CSRF protection
       $.ajaxSetup(
       {
           headers:
           {
               'X-CSRF-Token': $('input[name="_token"]').val()
           }
       });
        function error(message) {
            return '<div class="alert alert-block alert-danger fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>' + message + '</div>'
        }
        function success(message) {
            return '<div class="alert alert-success alert-block fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button><p>' + message + '</p></div>'
        }

        function loading(message) {
            return '<div class="alert alert-info fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button> <img src="{{ URL::asset("public/img/front") }}/input-spinner.gif"/> ' + message + ' </div>'
        }

        $('#password-recovery').submit(function(event)
        {
            // Stop full page load
            event.preventDefault();

            // Check fields
            var login = $('#recovery-mail').val();
            var emailRegex = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
            var valid = emailRegex.test(login);
            if (!login || login.length == 0)
            {
                $('#forgotpass-block').html(error('Please enter your email address'));
            }
            else if (!valid) {
                $('#forgotpass-block').html(error('Please enter correct email address'));
            }
            else
            {

                // Target url
                var target = $(this).attr('action');
                if (!target || target == '')
                {
                    // Page url without hash
                    target = document.location.href.match(/^([^#]+)/)[1];
                }

                var captcha = $('#captcha_reset').val();
                // Request
                var data = {
                    a: $('#a').val(),
                    email: login,
                },
                        redirect = $('#redirect'),
                        sendTimer = new Date().getTime();

                if (redirect.length > 0)
                {
                    data.redirect = redirect.val();
                }

                // Send
                $.ajax({
                    url: target,
                    dataType: 'json',
                    type: 'POST',
                    data: data,
                    success: function(data, textStatus, XMLHttpRequest)
                    {
                        if (data.valid)
                        {
                            // Small timer to allow the 'checking login' message to show when server is too fast
                            var receiveTimer = new Date().getTime();
                            if (receiveTimer - sendTimer < 500)
                            {
                                setTimeout(function()
                                {
                                    $('#forgotpass-block').html(success(data.message) || success('Please check your email account'));

                                }, 500 - (receiveTimer - sendTimer));
                            }
                            else
                            {
                                $('#forgotpass-block').html(success(data.message) || success('Please check your email account'));
                            }
                            $('#recovery-mail').val('');
                        }
                        else
                        {
                            // Message
                            $('#forgotpass-block').html(error(data.message) || success('An unexpected error occured, please try again'));

                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        // Message
                        $('#forgotpass-block').html(error('Error while contacting server, please try again'));

                    }
                });

                // Message
                $('#forgotpass-block').html(loading('Please wait, checking email...'));
            }
            return false;
        });
    });
    function refreshCaptcha()
    {

        var img = document.images['captchaimg'];
        var img_reset = document.images['captchaimg_reset'];
        img_reset.src = img.src = img.src.substring(0, img.src.lastIndexOf("?")) + "?rand=" + Math.random() * 1000;

    }
</script> 
@stop