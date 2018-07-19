<!DOCTYPE Html>

<html> 
    <!--[if lt IE 7 ]><html class="no-js ie6" dir="ltr" lang="en-US"><![endif]-->
    <!--[if IE 7 ]><html class="no-js ie7" dir="ltr" lang="en-US"><![endif]-->
    <!--[if IE 8 ]><html class="no-js ie8" dir="ltr" lang="en-US"><![endif]-->
    <!--[if IE 9 ]><html class="no-js ie9" dir="ltr" lang="en-US"><![endif]-->
    <!--[if (gte IE 9)|!(IE)]><!-->
    <!--[if !IE]><!-->
    <!--<![endif]-->
    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>@yield('title')</title>
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" href="{{ asset('public/img/front/favicon-16x16.png') }}"/>
        <link rel="icon" type="image/png" href="{{ asset('public/img/front/favicon.ico') }}"/>

        <link href="{{ URL::asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/css/bootstrap-reset.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/css/style.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/css/table-responsive.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/css/owl.carousel.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/css/font-awesome.css') }}" rel="stylesheet">
        


        <!--right slidebar-->
        <link href="{{ URL::asset('public/css/slidebars.css') }}" rel="stylesheet">

        <script src="{{ URL::asset('public/js/jquery.js') }}"></script>

        <script src="{{ URL::asset('public/js/listing.js') }}"></script>
        <script src="{{ URL::asset('public/js/bootstrap.min.js') }}"></script>



    <body>
        <section id="container" >
            <!--header start-->
            <header class="header white-bg">
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars toggle-left-menu tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
                </div>
                <!--logo start-->
<!--                {{ html_entity_decode(link_to('/admin/admindashboard', Html::image("public/img/front/logo.png", 'Logo', ['height'=>49]), array('escape' => false,'class'=>"logo"))) }}-->

Logo will here
                <!--logo end-->
<?php
$user_id = Session::get('user_id');
$type = Session::get('type');

$users =DB::table('users')
         ->where('id','=', $user_id)
        ->first();




?>
                <div class="top-nav ">
                    <!--search & user info start-->
                    <ul class="nav pull-right top-menu">
                        <!-- user login dropdown start-->
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle " href="#">
                                <span class="username">{{$users->user_name}}</span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu extended logout dropss">
                                <div class="log-arrow-up"></div>
                                <li class="dropss">
                                    {{ link_to('/user/editprofile', "Edit Profile", array('escape' => false,'class'=>"")) }}
                                <li class="dropss">
                                    {{ link_to('/user/changepassword', "Change Password", array('escape' => false,'class'=>"")) }}
                                </li>
                                
                                <li>
                                    {{ html_entity_decode(link_to('/user/logout', '<i class="fa fa-key"></i> Log Out', array('escape' => false,'class'=>""))) }}
                                </li>
                            </ul>
                        </li>
                        <!-- user login dropdown end -->
                    </ul>
                    <!--search & user info end-->
                </div>
            </header>
            <!--header end-->
            <!--sidebar start-->
            @include('elements/user_dashboard_left_menu')
            @yield('content')

            <!--footer start-->
            <footer class="site-footer">
                <div class="text-center">
                    <?php echo date('Y'); ?> &copy; <?php echo SITE_TITLE; ?>
                    <a href="#" class="go-top">
                        <i class="fa fa-angle-up"></i>
                    </a>
                </div>
            </footer>
            <!--footer end-->
        </section>
    </body>
 <!-- js placed at the end of the document so the pages load faster -->
        <script class="include" type="text/javascript" src="{{ URL::asset('public/js/jquery.dcjqaccordion.2.7.js') }}"></script>
        <script src="{{ URL::asset('public/js/jquery.scrollTo.min.js') }}"></script>
        <script src="{{ URL::asset('public/js/jquery.nicescroll.js') }}"></script>
        <script src="{{ URL::asset('public/js/jquery.sparkline.js') }}"></script>
        <script src="{{ URL::asset('public/js/owl.carousel.js') }}"></script>
        <script src="{{ URL::asset('public/js/jquery.customSelect.min.js') }}"></script>
        <script src="{{ URL::asset('public/js/respond.min.js') }}"></script>
        <script src="{{ URL::asset('public/js/cssua.min.js') }}"></script>
        <!--right slidebar-->
        <script src="{{ URL::asset('public/js/slidebars.min.js') }}"></script>

        <!--common script for all pages-->
        <script src="{{ URL::asset('public/js/common-scripts.js') }}"></script>

        <!--script for this page-->
        <script src="{{ URL::asset('public/js/sparkline-chart.js') }}"></script>

    <script>

//owl carousel
$(document).ready(function () {
    $("#owl-demo").owlCarousel({
        navigation: true,
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true,
        autoPlay: true

    });
});

//custom select box
$(function () {
    $('select.styled').customSelect();
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
    

</html>
