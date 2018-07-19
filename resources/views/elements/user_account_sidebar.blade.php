 
<?php
$user_id = Session::get('user_id');
$users =  DB::table('users')     
        ->where('id',$user_id)
                        ->first();


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
?>
<div class="ad_left">
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <div class="side_menu"><span class="showhide2"><i class="fa fa-navicon" aria-hidden="true"></i> Dashboard Menu</span></div>
        <ul class="sidebar-menu slidediv2" id="nav-accordion">
            <li><a class="{{ Request::is('account') ? 'active' : '' }}" href="<?php echo HTTP_PATH;?>account"><i class="fa fa-user" aria-hidden="true"></i> {{ucwords($users->first_name)}}</a></li>    
            <li class="{{ Request::is('user/editprofile') ? 'active' : '' }}"><a class="{{ Request::is('user/editprofile') ? 'active' : '' }}" href="<?php echo HTTP_PATH;?>user/editprofile"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</a></li>    
            <li class="{{ Request::is('user/changepicture') ? 'active' : '' }}"><a class="{{ Request::is('user/changepicture') ? 'active' : '' }}" href="<?php echo HTTP_PATH;?>user/changepicture"><i class="fa fa-camera-retro" aria-hidden="true"></i> Change Picture</a></li>
            <li class="{{ Request::is('projectboard/projects') ? 'active' : '' }}"><a class="{{ Request::is('projectboard/projects') ? 'active' : '' }}" href="<?php echo HTTP_PATH;?>projectboard/projects"><i class="fa fa-tasks" aria-hidden="true"></i> My Transactions</a></li>
            <li class="{{ Request::is('user/notifications') ? 'active' : '' }}"><a class="{{ Request::is('user/notifications') ? 'active' : '' }}" href="<?php echo HTTP_PATH;?>user/notifications"><i class="fa fa-bell" aria-hidden="true"></i> Notifications <span class="noti_icc"> <?php echo $notiCount; ?> </span></a></li>
        </ul>
        <!-- sidebar menu end-->
    </div> 
</div>

<script type="text/javascript">
    $(document).ready(function() { 
        $('.showhide2').click(function() {
            $(".slidediv2").slideToggle();   
        });
    });
</script> 