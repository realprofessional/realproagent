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
    <body class="login-body">
        @yield('content')
    </body>
</html>


