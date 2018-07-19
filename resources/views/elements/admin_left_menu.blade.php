<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <li>
                <a class="{{ Request::is('admin/admindashboard*') ? 'active' : '' }}" href="{{ URL::to( 'admin/admindashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" class="{{( Request::is('admin/editprofile*') or  Request::is('admin/changepassword*')  or  Request::is('admin/changeusername*') ) ? 'active' : '' }}">
                    <i class="fa fa-cogs"></i>
                    <span>Configuration</span>
                </a>
                <ul class="sub" style="{{( Request::is('admin/editprofile*') or  Request::is('admin/changepassword*') or  Request::is('admin/changeusername*') )? 'display: block;' : '' }}">
                    <li class="{{ Request::is('admin/changepassword*') ? 'active' : '' }}">
                        <a class="{{ Request::is('admin/changepassword*') ? 'active' : '' }}" href="{{ URL::to( 'admin/changepassword') }}">
                            <i class="fa fa-circle-o"></i>
                            Change Password
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/editprofile*') ? 'active' : '' }}"> 
                        <a class="{{ Request::is('admin/editprofile*') ? 'active' : '' }}" href="{{ URL::to( 'admin/editprofile') }}">
                            <i class="fa fa-circle-o"></i>
                            Edit Profile
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/changeusername*') ? 'active' : '' }}"> 
                        <a class="{{ Request::is('admin/changeusername*') ? 'active' : '' }}" href="{{ URL::to( 'admin/changeusername') }}">
                            <i class="fa fa-circle-o"></i>
                            Edit Username
                        </a>
                    </li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" class="{{Request::is('admin/user/*') ? 'active' : '' }}" >
                    <i class="fa fa-user"></i>
                    <span>User management</span>
                </a>
                <ul class="sub" style="{{(Request::is('admin/user*')) ? 'display: block;' : '' }}">
                    <li class="{{ (Request::is('admin/user/userlist') OR Request::is('admin/user/Admin_edituser*')) ? 'active' : '' }}">{{ HTML::decode(link_to('/admin/user/userlist', '<i class="fa fa-circle-o"></i>User List', ['escape' => false])); }}</li>
                    <li class="{{ Request::is('admin/user/adduser') ? 'active' : '' }}">{{ HTML::decode(link_to('/admin/user/adduser', '<i class="fa fa-circle-o"></i>Add User', ['escape' => false])); }}</li>

                </ul>
            </li>
            
            <li class="sub-menu">
                <a href="javascript:;" class="{{Request::is('admin/adminboards*') ? 'active' : '' }}" >
                    <i class="fa fa-random"></i>
                    <span>Default Projects</span>
                </a>
                <ul class="sub" style="{{(Request::is('admin/adminboards*')) ? 'display: block;' : '' }}">
                    <li class="{{ (Request::is('admin/adminboards/project')) ? 'active' : '' }}">{{ HTML::decode(link_to('/admin/adminboards/project', '<i class="fa fa-circle-o"></i>Default Projects ', ['escape' => false])); }}</li>
                </ul>
            </li>
            
            <li class="sub-menu">
                <a href="javascript:;" class="{{Request::is('admin/projects*') ? 'active' : '' }}" >
                    <i class="fa fa-tasks"></i>
                    <span>Project management</span>
                </a>
                <ul class="sub" style="{{(Request::is('admin/projects*')) ? 'display: block;' : '' }}">
                    <li class="{{ (Request::is('admin/projects/list')) ? 'active' : '' }}">{{ HTML::decode(link_to('/admin/projects/list', '<i class="fa fa-circle-o"></i>Project List', ['escape' => false])); }}</li>
                    <li class="{{ Request::is('admin/projects/add') ? 'active' : '' }}">{{ HTML::decode(link_to('/admin/projects/add', '<i class="fa fa-circle-o"></i>Add Project', ['escape' => false])); }}</li>
                </ul>
            </li>
            
            <li class="sub-menu">
                <a href="javascript:;" class="{{Request::is('admin/transaction*') ? 'active' : '' }}" >
                    <i class="fa fa-credit-card"></i>
                    <span>Transaction Type </span>
                </a>
                <ul class="sub" style="{{(Request::is('admin/transaction*')) ? 'display: block;' : '' }}">
                    <li class="{{ (Request::is('admin/transaction/list')) ? 'active' : '' }}">{{ HTML::decode(link_to('/admin/transaction/list', '<i class="fa fa-circle-o"></i>Transaction Type List', ['escape' => false])); }}</li>
                    <li class="{{ Request::is('admin/transaction/addType') ? 'active' : '' }}">{{ HTML::decode(link_to('/admin/transaction/addType', '<i class="fa fa-circle-o"></i>Add Transaction Type', ['escape' => false])); }}</li>
                </ul>
            </li>
            
            <li class="sub-menu">
                <a href="javascript:;" class="{{Request::is('admin/usertype*') ? 'active' : '' }}" >
                    <i class="fa fa-credit-card"></i>
                    <span>User Type </span>
                </a>
                <ul class="sub" style="{{(Request::is('admin/usertype*')) ? 'display: block;' : '' }}">
                    <li class="{{ (Request::is('admin/usertype/list')) ? 'active' : '' }}">{{ HTML::decode(link_to('/admin/usertype/list', '<i class="fa fa-circle-o"></i>User Type List', ['escape' => false])); }}</li>
                    <li class="{{ Request::is('admin/usertype/addType') ? 'active' : '' }}">{{ HTML::decode(link_to('/admin/usertype/addType', '<i class="fa fa-circle-o"></i>Add User Type', ['escape' => false])); }}</li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;"   class="{{Request::is('admin/page*') ? 'active' : '' }}">
                    <i class="fa  fa-files-o"></i>
                    <span>Content management</span>
                </a>
                <ul class="sub" style="{{Request::is('admin/page*') ? 'display: block;' : '' }}">
                    <li class="{{ (Request::is('admin/page/pagelist') OR Request::is('admin/page/Admin_editpage*')) ? 'active' : '' }}">{{ HTML::decode(link_to('/admin/page/pagelist', '<i class="fa fa-circle-o"></i>Pages List', ['escape' => false])) }}</li>
                    <!--<li class="{{ Request::is('admin/page/admin_add') ? 'active' : '' }}">{{ link_to('/admin/page/admin_add', 'Add Page', ['escape' => false]) }}</li>-->

                </ul>
            </li>

        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>