
<?php
$home_page = false;
if (HTTP_PATH == "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']) {

    $home_page = true;
} elseif (HTTP_PATH == "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']) {
    $home_page = true;
}
?>

<div class="main_banners">

    <header class="header">
        <div class="headers">
            <div class="wrapper">
                <div class="logo"><a href="{{HTTP_PATH}}"><img src="{{HTTP_PATH}}public/img/front/logo.png" alt="logo" onmousedown="event.preventDefault ? event.preventDefault() : event.returnValue = false"></a></div>
                <div class="hed_right">
                    <?php if (Session::has('user_id')) { ?>
                        <?php
                        $user_id = Session::get('user_id');
                        $userData = DB::table('users')
                                ->where('id', $user_id)
                                ->first();
                        if (!empty($userData->profile_image)) {
                            ?>
                            <div class="user_pic"><a href="{{HTTP_PATH}}account" class="user_img_pic"><img src="{{HTTP_PATH.DISPLAY_FULL_PROFILE_IMAGE_PATH.$userData->profile_image}}" alt="user img"></a>
                <!--                <div class="chang_pic_icon"><a href="{{HTTP_PATH}}user/changepicture"><i class="fa fa-pencil" aria-hidden="true"></i></a></div>-->
                            </div>
                        <?php } else { ?>
                            <div class="user_pic"><a href="{{HTTP_PATH}}account" class="user_img_pic"><img src="{{HTTP_PATH}}public/img/front/man-user.svg" alt="user img"></a>
                <!--                <div class="chang_pic_icon"><a href="{{HTTP_PATH}}user/changepicture"><i class="fa fa-pencil" aria-hidden="true"></i></a></div>-->
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


<script> 
    $(document).ready(function () {
        setInterval(function(){ 
            //updateNotification();
        }, 2000);
        
          $(".main_wrapper_").on('click', function(){
            $(".menu_iconss_togg").hide();
        }); 
    });
    
    
    function updateNotification() { 
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>user/updateNotification',
            beforeSend: function () {
            },
            success: function (result) {
                if (result) {
                    $(".noti_icc").html(result);
                    $(".noti_icc_1").html(result);
                    $(".noti_icc_2").html(result);
                }
            }
        });
    }
</script> 