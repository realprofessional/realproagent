<!DOCTYPE HTML>
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
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title')</title>
        <meta name="description" content="">
        <meta name="author" content="">
         <link rel="icon" type="image/png" href="{{ asset('public/img/front/favicon-16x16.png') }}"/>
        <link rel="icon" type="image/png" href="{{ asset('public/img/front/favicon.ico') }}"/>
        
        <link href="{{ URL::asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/css/bootstrap-reset.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/css/style.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/css/style-responsive.css') }}" rel="stylesheet">

        <script src="{{ URL::asset('public/js/jquery.js') }}"></script>
        <script src="{{ URL::asset('public/js/bootstrap.min.js') }}"></script>
    </head>
    <body class="body_top">
        <div id="toTop">TOP</div>
        <div class="header_img">
<header>
<div class="header"> 
<div class="wrapper">
<div class="top_head">
<div class="logo"><a href="#">Logo will here</a></div>

<div class="top_menu">
<div class="my_accmenus"><a href="javascript:void(0)" class="showhide2">Menu</a></div>
<ul class="slidediv2"> 
<li><a href="#">Our Teams</a></li>
<li><a href="#">Buy</a></li>
<li><a href="#">Sell </a></li>
<li><a href="#">Partners</a></li>
<li><a href="#">Mortgage</a></li>
<li><a href="#">Advice</a></li>
<li><a href="#">Sign In</a></li>
<li><a href="#">Join</a></li>


</ul>

</div>


</div>
</div>
</div>
<div class="wrapper">
<div class="slider_con">
<h1>Taking You Home</h1> 
<h4>Find Great Homes And Agents In A Few Clicks </h4>

</div>


<div class="head_search">
<div class="search_con">
<div class="sel_head">
<span><select class="required" id="SearchCity">
<option value="">Sell</option>
<option value="kota">Purchase</option>
</select></span>


</div>
<div class="ser_first">
<input placeholder="Where do you need to sell?" type="text"><input type="submit"></div>

</div>
</div>
</div>
</header>
</div> 
        @yield('content')
    </body>
</html>


