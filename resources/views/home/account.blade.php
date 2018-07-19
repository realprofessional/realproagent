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

<script>
    $(document).ready(function () {
        $.ajaxSetup(
        {
            headers:
                {
                'X-CSRF-Token': $('input[name="_token"]').val()
            }
        });
    });
</script> 


<?php
$user_id = Session::get('user_id');
$user = DB::table('users')
        ->where('id', $user_id)
        ->first();

//print_r($user); exit;
?>
{{ Html::script('public/js/front/jquery.bpopup.js') }}
<div class="acc_deack">
    <div class="wrapper">
        <nav class="breadcrumbs">
            <div class="container">
                <ul>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>">Home</a></li>

                    <li class="breadcrumbs__item">Account</li>

                </ul>
            </div>
        </nav>
        <div class="space">


            <div class="container">

                @include('elements/user_account_sidebar')
                <div class="main_container">

                    <div class="widget__header">
                        <h1 class="widget__title">Account</h1> 
                    </div>
                    <div class="profile">
                        {{ View::make('elements.actionMessage')->render() }}
                        <div class="widget js-widget widget--dashboard">

                            <div class="widget__content">
                                <div class="worker worker--profile">
                                    <div class="worker__item">
                                        <div class="work_ll">
                                            @if ($user->profile_image!='')
                                            <div class="worker__photo"><a class="item-photo item-photo--static" href="<?php echo HTTP_PATH; ?>user/changepicture"><img alt="" src="{{HTTP_PATH}}{{DISPLAY_FULL_PROFILE_IMAGE_PATH}}{{$user->profile_image}}"></a>
                                                @else
                                                <div class="worker__photo"><a class="item-photo item-photo--static" href="<?php echo HTTP_PATH; ?>user/changepicture"><img alt="" src="{{HTTP_PATH}}public/img/front/man-user.svg">
                                                        @endif       
                                                    </a></div>
                                                <h3 class="worker__name fn">{{ucwords($user->first_name)}} {{ucwords($user->last_name)}}</h3>
                                            </div>
                                            <div class="worker__intro">

                                                <div class="worker__post"></div>

                                                <div class="clearfix"></div>
                                                <div class="worker__contacts">
                                                    <div class="worker__intro-col">
                                                        <div class="tel"><span class="type new_type">Contact Number</span><a class="uri value" href="tel:{{$user->contact}}">@if($user->contact =='') {{ 'N/A' }} @else +{{$user->contact}} @endif</a></div>
                                                    </div>
                                                    <div class="worker__intro-col">
                                                        <div class="email"><span class="type new_type">Email</span><a class="uri value" href="mailto:{{$user->email_address}}">{{$user->email_address}}</a></div>
                                                    </div>
                                                    <div class="worker__intro-col">
                                                        <div class="email"><span class="type new_type">Address 1</span>@if($user->address =='') {{ 'N/A' }} @else {{$user->address}} @endif</div>
                                                    </div>
                                                    <div class="worker__intro-col">
                                                        <div class="email"><span class="type new_type">Address 2</span>@if($user->address2 =='') {{ 'N/A' }} @else {{$user->address2}} @endif</div>
                                                    </div>
                                                    <!-- end of block .worker__contacts-->
                                                </div>
  <!--                                              <div class="social social--worker"><a class="social__item" href="#"><i class="fa fa-facebook"></i></a><a class="social__item" href="#"><i class="fa fa-linkedin"></i></a><a class="social__item" href="#"><i class="fa fa-twitter"></i></a><a class="social__item" href="#"><i class="fa fa-google-plus"></i></a></div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>              

                        </div>


                        <div class="property_list">

                        </div>
                    </div> 

                </div>
            </div>


        </div>
    </div>
</div>


@stop