
@section('content')
<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>

<script>
    jQuery(document).ready(function(){
        jQuery('.reset_button').click(function(){
            document.getElementById('join_form').reset();
        });
         
        $('#join_form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                return false;
            }
        });
    });
</script>
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
        $("#join_form").validate({ 
            rules: {
                account_type: {
                    required: true
                },
                first_name: {
                    required: true,
                    maxlength: 20
                },
                last_name: {
                    required: true,
                    maxlength: 20
                },
                contact: {
                    required: true,
                    maxlength: 16
                    
                }
            }
        });
    });
</script>

<section class="tack_srs">
    <div class="wrapper_login">
        <div class="signup_bx">
            <h2>Don't have account? <span>Sign Up Now</span></h2>
            <div class="login_form">
                {{ View::make('elements.actionMessage')->render() }}
                {{ Form::open(array('url' => '/signup', 'files' => true, 'id'=>'join_form')) }}
                <div class="input_type">
                    {{ Form::text('first_name',Input::old('first_name'),array('id' => 'first_name', 'placeholder'=>"Enter First Name", 'class' => 'required noSpace')) }}
                </div>
                <div class="input_type">
                    {{ Form::text('last_name',Input::old('last_name'),array('id' => 'last_name', 'placeholder'=>"Enter Last Name", 'class' => 'required noSpace')) }}
                </div>
                <div class="input_type">
                    <?php if (isset($_POST['email_address'])) { ?>
                        {{ Form::text('email_address',Input::old('email_address'),array('id' => 'email_address', 'class' => 'required email','placeholder'=>'Enter Email Address')) }}
                        <?php
                    } elseif (isset($_GET['email_address']) && !empty($_GET['email_address'])) {
                        $email_addr = str_replace(" ", "+", $_GET['email_address']);
                        ?>
                        {{ Form::text('email_address',$email_addr,array('id' => 'email_address', 'class' => 'required email','placeholder'=>'Enter Email Address')) }}
                    <?php } else { ?>
                        {{ Form::text('email_address',null,array('id' => 'email_address', 'class' => 'required email','placeholder'=>'Enter Email Address')) }}
                    <?php } ?>
                </div>
                <div class="input_type">
                    {{  Form::password('password',  array('type'=>'password','class' => 'required ','minlength' => 8, 'maxlength' => '40','id'=>"password",'placeholder'=>"Enter Password"))}}
                </div>
                <div class="input_type">
                    {{ Form::password('cpassword',  array('type'=>'password','class' => 'required form-control','maxlength' => '40', 'equalTo' => '#password','placeholder'=>"Enter Confirm Password")) }}
                </div>
                <div class="input_type input_ckeck">
                    <input type="checkbox" name="terms" id="terms-n-cond" class="required in-checkbox" value="1"> <label for="" > I agree to the <a href="javascript:void(0);" onclick="window.open('<?php echo HTTP_PATH ?>pages/terms_conditions', 'term', 'width=900,height=400,scrollbars=1')" > Terms and Conditions</a> of the Real Pro Agent Service Agreement </label>
                </div>
                <?php
                if (isset($_GET['invid']) && !empty($_GET['invid'])) {
                    $invid = $_GET['invid'];
                } else {
                    $invid = 0;
                }
                ?>
                <input type="hidden" name="invid" value="{{$invid}}">
                <div class="input_type input_submit">
                    {{ Form::submit('Submit', array('class' => "",'onclick' => 'return imageValidation();')) }}
                </div>

            </div>
        </div>
    </div>
</section>
@stop