<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
        <meta name="viewport" content="width=320,user-scalable=false, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title> 
            <?php
            if (isset($title)) {
                echo $title;
            }else
            {
            ?>
            @yield('title')
            <?php } ?>
        </title>
        <link rel="icon" type="image/png" href="{{ asset('public/img/front/favicon-16x16.png') }}"/>
        <link rel="icon" type="image/png" href="{{ asset('public/img/front/favicon.ico') }}"/>
        {{ Html::style('public/css/front/reset.css') }}
        {{ Html::style('public/css/front/style.css'); }}
        {{ Html::style('public/css/front/font/css/font-awesome.css'); }}
        {{ Html::style('public/css/front/slimmenu.css'); }}
        {{ Html::style('public/css/front/flexslider.css'); }}
        {{ Html::style('public/css/front/owl.carousel.css'); }}
        {{ Html::style('public/css/front/owl.theme.css'); }}
        {{ Html::style('public/css/front/responsive.css'); }}

        {{ Html::script('public/js/jquery-1.8.2.min.js'); }}
        
        {{ Html::script('public/js/front/jquery-customselect.js'); }}

        {{ Html::script('public/js/front/common.js'); }}
        {{ Html::script('public/js/cssua.min.js'); }}
        {{ Html::script('public/js/front/jquery.easing.1.3.js'); }}
        {{ Html::script('public/js/front/jquery.bpopup.min.js'); }}
        {{ Html::script('public/js/front/jquery.validate.js'); }}
        
        {{ Html::script('public/css/front/lib/sweet-alert.min.js'); }}

        {{ Html::style('public/css/front/lib/sweet-alert.css'); }}
        {{ Html::style('public/css/front/jquery-customselect.css'); }}
        
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css' />


        <!--<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>-->
        <script type="text/javascript">
            $(document).ready(function() {
                $(".menu_device").click(function() {
                    $(".menu").toggle(300);
                });
                $("button.close").click(function() {
                    $(this).parent(".alert").fadeOut("slow");
                })
                
            });
        </script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    </head>
    <body>
        <span id="MenuId" style="display:none;">home</span>
        <div id="toTop">TOP</div>
        <div class="mainwrapper">
            @include('elements.header_social')
            @yield('content')
            @include('elements.footer_social')
        </div>
        
        {{ Html::script('public/js/front/slimmenu.js'); }}
        {{ Html::script('public/js/front/jquery.flexslider.js'); }}
        {{ Html::script('public/js/front/owl.carousel.js'); }}
        {{ Html::script('public/js/front/pinterest_grid.js'); }}
        {{ Html::script('public/js/front/css_browser_selector.js'); }}
        {{ Html::script('public/js/front/pageScript.js'); }}
        {{ Html::script('public/js/front/oauthpopup.js'); }}

        <script type="text/javascript">
                $(document).ready(function() {
                        //$(".menu_button").click(function() {
//                $(".menushow_div").slideToggle("slow");
//        });

                });
        //For Facebook	
            $('#facebook').oauthpopup({
                path: '<?php echo HTTP_PATH; ?>user/login?facebook&type=Service Provider&code=',
                width: 600,
                height: 300
            });
            //For Google	
            $('#google').oauthpopup({
                path: '<?php echo HTTP_PATH; ?>user/login?google&type=Service Provider',
                width: 650,
                height: 350
            }); 
        //For Facebook	
            $('#facebook1').oauthpopup({
                path: '<?php echo HTTP_PATH; ?>user/login?facebook&type=Service Provider&code=',
                width: 600,
                height: 300
            });
            //For Google	
            $('#google1').oauthpopup({
                path: '<?php echo HTTP_PATH; ?>user/login?google&type=Service Provider',
                width: 650,
                height: 350
            }); 
            //For Facebook	
            $('#facebookc').oauthpopup({
                path: '<?php echo HTTP_PATH; ?>user/login?facebook&type=Customer&code=',
                width: 600,
                height: 300
            });
            //For Google	
            $('#googlec').oauthpopup({
                path: '<?php echo HTTP_PATH; ?>user/login?google&type=Customer',
                width: 650,
                height: 350
            });
            //For Facebook	
            $('#facebookd').oauthpopup({
                path: '<?php echo HTTP_PATH; ?>user/login?facebook&type=Customer&code=',
                width: 600,
                height: 300
            });
            //For Google	
            $('#googled').oauthpopup({
                path: '<?php echo HTTP_PATH; ?>user/login?google&type=Customer',
                width: 650,
                height: 350
            });
        </script>
    </body>
</html>
