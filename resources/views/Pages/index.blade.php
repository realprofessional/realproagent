@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Add Service Provider')
@section('content')
<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.validator.addMethod("pass", function(value, element) {
            return  this.optional(element) || (/.{8,}/.test(value) && /([0-9].*[a-z])|([a-z].*[0-9])/.test(value));
        }, "Password minimum length must be 8 charaters and contain atleast 1 number.");
        $("#myform").validate({
            submitHandler: function(form) {
                this.checkForm();

                if (this.valid()) { // checks form for validity
                    $('#formloader').show();
                    this.submit();
                } else {
                    return false;
                }
            }
        });
    });

</script>
<section>
    <div class="bodybg">
		<div class="wrapper">
            <div class="body_area">
                <div class="form_area">
                    <div class="login_bx">
                        <div class="signup_bx">
                            <div id="formloader" class="formloader" style="display: none;">
                                {{ Html::image('public/img/loader_large_blue.gif','', array()) }}
                            </div>
                            <div class="signup_tops"></div>
                            <div class="form_headind">
                                {{ $pageDetail->name; }}
                            </div>
        
                            {{ View::make('elements.frontEndActionMessage')->render() }}
                            <?php if (!empty($pageDetail)) { ?>
           
                                <div class="input_area">
                                    {{ $pageDetail->description; }}
                                </div>
                            <?php } ?>
                            
                               
                            
                        </div>
        
        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

@stop