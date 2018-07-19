<div>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <li>
                <a class="{{ Request::is('user/dashboard*') ? 'active' : '' }}" href="{{ URL::to( 'user/dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" class="{{( Request::is('user/editprofile*') or  Request::is('user/changepassword*') ) ? 'active' : '' }}">
                    <i class="fa fa-cogs"></i>
                    <span>Configuration</span>
                </a>
                <ul class="sub" style="{{( Request::is('user/editprofile*') or  Request::is('user/changepassword*') or  Request::is('user/changeusername*') )? 'display: block;' : '' }}">
                    <li class="{{ Request::is('user/changepassword*') ? 'active' : '' }}">
                        <a class="{{ Request::is('user/changepassword*') ? 'active' : '' }}" href="{{ URL::to( 'user/changepassword') }}">
                            Change Password
                            
                        </a>
                    </li>
                    <li class="{{ Request::is('user/editprofile*') ? 'active' : '' }}"> 
                        <a class="{{ Request::is('user/editprofile*') ? 'active' : '' }}" href="{{ URL::to( 'user/editprofile') }}">
                            Edit Profile
                        </a>
                    </li>
                </ul>
            </li>

           <li class="sub-menu">
                <a href="javascript:;"   class="{{(Request::is('user/categories*') OR Request::is('user/area*')) ? 'active' : '' }}">
                    <i class="fa fa-building-o"></i>
                    <span>Room Categories</span>
                </a>
                <ul class="sub" style="{{(Request::is('user/categories*')) ? 'display: block;' : '' }}">
                    <li class="{{ (Request::is('/user/categories/admin_index') ) ? 'active' : '' }}">{{ link_to('/user/categories/admin_index', 'Categories List', ['escape' => false]) }}</li>
                    <li class="{{ Request::is('user/categories/admin_add') ? 'active' : '' }}">{{ link_to('/user/categories/admin_add', 'Add Category', ['escape' => false]) }}</li>
                </ul>
            </li>
            <!-- <li class="sub-menu">
                <a href="javascript:;"   class="{{(Request::is('admin/categories*') OR Request::is('admin/area*')) ? 'active' : '' }}">
                    <i class="fa fa-building-o"></i>
                    <span>Room Amenities</span>
                </a>
                <ul class="sub" style="{{(Request::is('admin/categories*') OR Request::is('admin/area*')) ? 'display: block;' : '' }}">
                    <li class="{{ (Request::is('admin/categories/admin_index') OR Request::is('admin/categories/Admin_editcity*') OR Request::is('admin/area*')) ? 'active' : '' }}">{{ link_to('/admin/categories/admin_index', 'Categories List', ['escape' => false]) }}</li>
                    <li class="{{ Request::is('admin/categories/admin_add') ? 'active' : '' }}">{{ link_to('/admin/categories/admin_add', 'Add Category', ['escape' => false]) }}</li>
                </ul>
            </li>-->
            
        </ul>
        <!-- sidebar menu end-->
    </div>
</div>