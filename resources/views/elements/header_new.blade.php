
<?php
$home_page = false;
if (HTTP_PATH == "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']) {

    $home_page = true;
} elseif (HTTP_PATH == "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']) {
    $home_page = true;
}

$userId = Session::get('user_id');
$allNotifications = DB::table('notifications')
                ->select('notifications.*')
                ->where('notifications.read_status', 0)
                ->where('notifications.user_id', $userId)->get();

if (!empty($allNotifications)) {
    $notiCount = sizeof($allNotifications);
} else {
    $notiCount = 0;
}

$user_id = Session::get('user_id');
$userData = DB::table('users')
        ->where('id', $user_id)
        ->first();
?>

<script>
    function createproject() {
        $('#create_popup').toggle();
    }
</script>

<?php /* ?>
  <div class="main_banners">
  <header class="header">
  <div class="headers">
  <div class="wrapper_new">
  <div class="logo">
  <a href="{{HTTP_PATH}}"><img src="{{HTTP_PATH}}public/img/front/logo.png" alt="logo" onmousedown="event.preventDefault ? event.preventDefault() : event.returnValue = false"></a>
  </div>
  <div class="hed_right">
  <?php if (Session::has('user_id')) { ?>

  <div class="new_ionc">
  <a class="new_ionc_a" href="{{HTTP_PATH}}projectboard/projects/buyer">Buyer Transaction</a>
  <a class="new_ionc_a" href="{{HTTP_PATH}}projectboard/projects/seller">Seller Transaction</a>
  </div>


  <?php
  if (!empty($userData->profile_image)) {
  ?>
  <div class="user_pic"><a href="{{HTTP_PATH}}account" class="user_img_pic"><img src="{{HTTP_PATH.DISPLAY_FULL_PROFILE_IMAGE_PATH.$userData->profile_image}}" alt="user img"></a>
  <div class="chang_pic_icon"><a href="{{HTTP_PATH}}user/notifications"><span class="noti_icc"><?php echo $notiCount; ?></span></a></div>
  </div>
  <?php } else { ?>
  <div class="user_pic"><a href="{{HTTP_PATH}}account" class="user_img_pic"><img src="{{HTTP_PATH}}public/img/front/man-user.svg" alt="user img"></a>
  <div class="chang_pic_icon"><a href="{{HTTP_PATH}}user/notifications"><span class="noti_icc"><?php echo $notiCount; ?></span></a></div>
  </div>
  <?php } ?>
  <!--            <div class="login_but login_but_acco"><a href="{{HTTP_PATH}}account">Account</a></div>
  <div class="login_but signh_but logouts"><a href="{{HTTP_PATH}}logout">Logout</a></div>-->

  <div class="nav">
  <div id='cssmenu'>
  <ul>
  <li><a href="{{HTTP_PATH}}dashboard">Dashboard</a></li>
  <li><a href="{{HTTP_PATH}}account">Account</a></li>
  <li><a href="{{HTTP_PATH}}projectboard/projects">My Transactions</a></li>
  <li><a href="{{HTTP_PATH}}user/notifications">Notification <span class="noti_icc_1"><?php echo $notiCount; ?></span></a></li>
  <?php if (Session::has('user_id')) { ?>
  <li class="nevi_bx"><a href="{{HTTP_PATH}}logout">Logout</a></li>
  <?php } ?>
  </ul>
  </div>
  </div>



  <?php } else { ?>
  <div class="login_but"><a href="{{HTTP_PATH}}login">Log in</a></div>
  <div class="login_but signh_but"><a href="{{HTTP_PATH}}signup">Sign up</a></div>
  <?php } ?>

  </div>
  </div>
  </div>

  </header>
  </div>
  <?php */ ?>

<header>
    <div class="haeder_inner">
        <div class="header_wrapper">
            <div class="logo_header">
                <a href="{{HTTP_PATH}}"><img src="{{HTTP_PATH}}public/img/front/logo.png" alt="logo" onmousedown="event.preventDefault ? event.preventDefault() : event.returnValue = false"></a>
            </div>


            <div class="header_address">
                <?php if (isset($project) && !empty($project)) { ?>
                    <i class="fa fa-map-marker"></i>
                    <a href="{{HTTP_PATH}}board/{{$project->slug}}">{{ $project->project_name }}</a>
                <?php } ?>
                    
                    
            </div>

            

            <div class="btn_wrap">
                <a class="" href="{{HTTP_PATH}}projectboard/projects/buyer">Buyer Transaction</a>
                <a class="" href="{{HTTP_PATH}}projectboard/projects/seller">Seller Transaction</a>
                
            </div>
            <div class="notification">
                <a href="{{HTTP_PATH}}user/notifications">
                    <span class="digit noti_icc_1"><?php echo $notiCount; ?></span>
                    <i class="fa fa-bell"></i>
                </a>
<!--                <a href="#"><span class="digit"></span><i class="fa fa-envelope"></i></a>-->
            </div>

            <div class="profiel">
                <?php if (!empty($userData->profile_image)) { ?>
                    <a href="{{HTTP_PATH}}account" class="">
                        <img src="{{HTTP_PATH.DISPLAY_FULL_PROFILE_IMAGE_PATH.$userData->profile_image}}" alt="user img">
                    </a>
                <?php } else { ?>
                    <a href="{{HTTP_PATH}}account" class=""><img src="{{HTTP_PATH}}public/img/front/man-user.svg" alt="user img"></a>
                <?php } ?>

                <a href="{{HTTP_PATH}}account">{{ $userData->first_name . " " .  $userData->last_name }} <i class="fa fa-long-arrow-down"></i></a>
            </div>

            <div class="menu_icon" id="menu_icons__btn">
                <div class="icon_wrap">
                    <a href="#">
                        <span class="first"></span>
                        <span class="sec"></span>
                        <span class="thi"></span>
                        <span class="four"></span>
                    </a>
                </div>
            </div> 

            <ul class="menu_iconss_togg" style="display:none;">
                <li><a href="{{HTTP_PATH}}dashboard">Dashboard</a></li>
                <li><a href="{{HTTP_PATH}}account">Account</a></li>
                <li><a href="{{HTTP_PATH}}projectboard/projects">My Transactions</a></li>
                <li><a href="{{HTTP_PATH}}user/notifications">Notification <span class="noti_icc_1"><?php echo $notiCount; ?></span></a></li>
                <?php if (Session::has('user_id')) { ?>
                    <li class="nevi_bx"><a href="{{HTTP_PATH}}logout">Logout</a></li>
                <?php } ?>
            </ul>
        </div>    
</header>
<script>
    //$(document).ready(function(){
    //   $("#menu_icons__btn").on('click', function(){
    //        $("body").addClass("hide_menu");
    //        
    //    });
    //});
</script>

<script> 
    $(document).ready(function () {
        
       
         $("#menu_icons__btn").on('click', function(){
            $(".menu_iconss_togg").slideToggle();
        }); 
         $(".wrapper_new").on('click', function(){
            $(".menu_iconss_togg").hide();
        }); 
        
          $(".acc_deack").on('click', function(){
            $(".menu_iconss_togg").hide();
        }); 
        
        
        setInterval(function(){ 
            //updateNotification();
        }, 5000);
            
    });
        
        
    function updateNotification() { 
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>user/updateNotification',
            beforeSend: function () {
            },
            success: function (result) {
                if (result > 0 || result == 0) {
                    $(".noti_icc").html(result);
                    $(".noti_icc_1").html(result);
                    $(".noti_icc_2").html(result);
                }
            }
        });
    }
    
</script> 


<script type="text/javascript">
    $(document).ready(function () {
        $('.left_menu').click(function () {
            $(".left_sidebar").slideToggle();
        });
    });


</script>