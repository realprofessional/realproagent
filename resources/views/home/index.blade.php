
@section('content')
<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>
<script>
    $("#sign_form").validate();
</script>

<?php
if (Session::has('user_id')) {
    $cls = 'newww_clss_hovv';
}else{
    $cls = '';
}
?>
<section class="tack_srs">
    <div class="wrapper">
        <div class="task_slect">
            <h1>Welcome To Real Pro Agent</h1>
            <h4>Please enter your e-mail address so we can create a personal demo site <br>
                ( you'll get a mail- please wait for a minute or two)</h4>
            <div class="task_search">
                <form action="{{ HTTP_PATH }}signup" method="GET" id="sign_form" >
                    <input type="text" placeholder="Enter your email" name="email_address" class="required">
                    <?php
                    echo Form::submit('Create Free Account', array('class' => $cls));
                    ?>
                </form>
            </div>
            <div class="myser_img">  
                <div class="ser_img_desktop">
                    {{ Html::image('public/img/front/my_search235.png','search',array('class'=>"")) }}
                </div>
                <div class="ser_img_mobile">
                    {{ Html::image('public/img/front/my_search2.png','search',array('class'=>"")) }}
                </div>
            </div>
        </div>
    </div>
</section>

@stop