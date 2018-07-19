<!doctype html>
<html>
    <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="format-detection" content="telephone=no"> 
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
   
    
     {{ Html::style('public/css/front/style.css'); }}
     {{ Html::style('public/css/front/styles.css'); }}
     {{ Html::style('public/css/front/font-awesome.css'); }}
     {{ Html::style('public/css/front/media.css'); }}
     {{ Html::style('public/css/front/animate.css'); }}
     <link rel='stylesheet prefetch' href='https://cdn.rawgit.com/michalsnik/aos/2.0.4/dist/aos.css'>




<!--<link rel="shortcut icon" type="image/x-icon" href="img/front/favicon.ico"  />-->
<link rel="icon" type="image/png" href="{{ asset('public/img/front/favicon.ico') }}"/>



{{ Html::script('public/js/front/jquery.min.js'); }}

</head>
    <?php 
    $array_path = explode('/', $_SERVER['REQUEST_URI']); 
   $count = count($array_path);
    $class = explode('?',$array_path[$count-1]);
    
     $class[0];
    
    ?>
    <body class="body_top_fixed">
<div id="toTop">TOP</div>
    
    <div class="main_wrapper">
       
            @include('elements.header')
            @yield('content')
            @include('elements.footer')
    </div>
{{ Html::script('public/js/front/script.js'); }}
<script type="text/javascript"> 

$(window).scroll(function () {
	    if ($(this).scrollTop() > 0) {
	        $('#toTop').fadeIn(); 
	    } else {
	        $('#toTop').fadeOut();
	    }
	});

	$('#toTop').click(function () {
	    $('body,html').animate({ scrollTop: 0 }, 800);
	});
	
        
         $(function () {
    var top = 1;
    $(window).scroll(function (event) {
        // what the y position of the scroll is
        var y = $(this).scrollTop();

        // whether that's below the form
        if (y >= top) {
            // if so, ad the fixed class
          
            $('.header, .body_top_fixed').addClass('fixed-header');
        } else {
            // otherwise remove it
            $('.header, .body_top_fixed').removeClass('fixed-header');
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

    </body>
</html>
