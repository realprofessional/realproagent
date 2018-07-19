<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@showWelcome');

Route::any('/content/{slug}', 'PageController@showPageData');
Route::any('/captcha', 'HomeController@showCapcha');
Route::any('/login', 'HomeController@showLogin');

Route::any('/register', 'HomeController@register_user');

Route::any('/cronTaskReminder', 'ProjectboardController@cronTaskReminder');
Route::any('/activateprofile/{id}', 'HomeController@activate_user');



/*Admin Default Routing Functions */
Route::group(array('prefix' => 'admin'), function() {
    $adminId = Session::get('adminid');

    Route::any('/login/', 'AdminController@showAdminlogin');
});

Route::any('/admin/logout', 'AdminController@showAdminlogout');
Route::any('/admin/admindashboard', 'AdminController@showAdmindashboard');
Route::any('/admin/forgotpassword', 'AdminController@showForgotpassword');
Route::any('/admin/changepassword', 'AdminController@showChangepassword');
Route::any('/admin/editprofile', 'AdminController@showEditprofile');
Route::any('/admin/changeusername', 'AdminController@showChangeusername');
Route::any('/admin', 'AdminController@showAdmindashboard');

/*Page Front End */
Route::any('/pages/{slug}', 'PageController@showdata');

/*Page Admin Function Routing */
Route::any('/admin/page/pagelist', 'PageController@showAdmin_index');
Route::any('/admin/page/admin_add', 'PageController@showAdmin_add');
Route::any('/admin/page/pagelist', 'PageController@showAdmin_index');
Route::any('/admin/page/Admin_activepage/{id}', 'PageController@showAdmin_activepage');
Route::any('/admin/page/Admin_deactivepage/{id}', 'PageController@showAdmin_deactivepage');
Route::any('/admin/page/Admin_deletepage/{id}', 'PageController@showAdmin_deletepage');
Route::any('/admin/page/Admin_editpage/{id}', 'PageController@showAdmin_editpage');
Route::any('/admin/page/admindeletepage/{id}', 'PageController@showAdmindeletepage');

/*Admin Boards Function Routing */
Route::any('/admin/adminboards/project', 'AdminBoardController@showproject');
Route::any('/admin/adminboards/createProject', 'AdminBoardController@showaddproject');
Route::any('/admin/adminboards/list/{id}', 'AdminBoardController@showAdmin_index');
Route::any('/admin/adminboards/list', 'AdminBoardController@showAdmin_index');
Route::any('/admin/adminboards/displayProjectTaskSection/{id}', 'AdminBoardController@showAdmin_displayProjectTaskSection');
Route::any('/adminboards/updateAdminTaskDescriptionData', 'AdminBoardController@showAdmin_updateAdminTaskDescriptionData');
Route::any('/adminboards/displayProjectTaskSection/{id}', 'AdminBoardController@displayProjectTaskSection');
Route::any('/adminboards/addTaskChecklist', 'AdminBoardController@addTaskChecklist');
Route::any('/adminboards/addTaskChecklistValue', 'AdminBoardController@addTaskChecklistValue');
Route::any('/adminboards/updateTaskChecklistValueBox', 'AdminBoardController@updateTaskChecklistValueBox');
Route::any('/adminboards/deleteProjectBoardTaskChecklist', 'AdminBoardController@deleteProjectBoardTaskChecklist');
Route::any('/adminboards/addTaskDueDate', 'AdminBoardController@addTaskDueDate');
Route::any('/adminboards/removeTaskDueDate', 'AdminBoardController@removeTaskDueDate');
Route::any('/adminboards/updateAdminProjectSection', 'AdminBoardController@updateAdminProjectSection');
Route::any('/admin/adminboards/deleteproject/{id}', 'AdminBoardController@showAdmin_deleteproject');

Route::any('/admin/projects/list', 'ProjectController@showAdmin_index');
Route::any('/admin/projects/add', 'ProjectController@showAdmin_add');
Route::any('/admin/projects/Admin_activeproject/{id}', 'ProjectController@showAdmin_activeproject');
Route::any('/admin/projects/Admin_deactiveproject/{id}', 'ProjectController@showAdmin_deactiveproject');
Route::any('/admin/projects/Admin_deleteproject/{id}', 'ProjectController@showAdmin_deleteproject');
Route::any('/admin/projects/Admin_editproject/{id}', 'ProjectController@showAdmin_editproject');
Route::any('/admin/projects/board/{id}', 'ProjectController@showAdmin_board');

/*Front End Ajax Functions Routing */
Route::any('/ajax/saveAdminBoard', 'AdminBoardController@showAdmin_saveAdminBoard');
Route::any('/ajax/saveAdminTask', 'AdminBoardController@showAdmin_saveAdminTask');
Route::any('/ajax/updateAdminTask', 'AdminBoardController@showAdmin_updateAdminTask');
Route::any('/ajax/deleteAdminTask', 'AdminBoardController@showAdmin_deleteAdminTask');
Route::any('/ajax/updateAdminBoard', 'AdminBoardController@showAdmin_updateAdminBoard');
Route::any('/ajax/deleteAdminBoard', 'AdminBoardController@showAdmin_deleteAdminBoard');

Route::any('/ajax/saveAdminProjectBoard', 'ProjectController@showAdmin_saveAdminProjectBoard');
Route::any('/ajax/saveAdminProjectTask', 'ProjectController@showAdmin_saveAdminProjectTask');
Route::any('/ajax/updateAdminProjectTask', 'ProjectController@showAdmin_updateAdminProjectTask');
Route::any('/ajax/deleteAdminProjectTask', 'ProjectController@showAdmin_deleteAdminProjectTask');
Route::any('/ajax/updateAdminProjectBoard', 'ProjectController@showAdmin_updateAdminProjectBoard');
Route::any('/ajax/deleteAdminProjectBoard', 'ProjectController@showAdmin_deleteAdminProjectBoard');

Route::any('/admin/projects/displayProjectTaskSection/{id}', 'ProjectController@showAdmin_displayProjectTaskSection');
Route::any('/ajax/updateAdminTaskDescriptionData', 'ProjectController@showAdmin_updateAdminTaskDescriptionData');

//To Copy Task in Admin 
Route::any('/ajax/getAdminUserProjects', 'ProjectController@showAdmin_getAdminUserProjects');
Route::any('/ajax/getAdminUserTaskPosition', 'ProjectController@showAdmin_getAdminUserTaskPosition');
Route::any('/ajax/copyAdminProjectTask', 'ProjectController@showAdmin_copyAdminProjectTask');

//To Move Task in Admin
Route::any('/ajax/getAdminUserMoveProjects', 'ProjectController@showAdmin_getAdminUserMoveProjects');
Route::any('/ajax/getAdminUserMoveTaskPosition', 'ProjectController@showAdmin_getAdminUserMoveTaskPosition');
Route::any('/ajax/moveAdminProjectTask', 'ProjectController@showAdmin_moveAdminProjectTask');

Route::any('/ajax/getAdminUserMoveBoardPositionForCopy', 'ProjectController@showAdmin_getAdminUserMoveBoardPositionForCopy');
Route::any('/ajax/copyAdminProjectBoard', 'ProjectController@showAdmin_copyAdminProjectBoard');

Route::any('/ajax/getAdminUserMoveBoardPositionForMove', 'ProjectController@showAdmin_getAdminUserMoveBoardPositionForMove');
Route::any('/ajax/moveAdminProjectBoard', 'ProjectController@showAdmin_moveAdminProjectBoard');


Route::any('/ajax/addTaskChecklist', 'ProjectController@addTaskChecklist');
Route::any('/ajax/addTaskChecklistValue', 'ProjectController@addTaskChecklistValue');
Route::any('/ajax/updateTaskChecklistValueBox', 'ProjectController@updateTaskChecklistValueBox');
Route::any('/ajax/deleteProjectBoardTaskChecklist', 'ProjectController@deleteProjectBoardTaskChecklist');

Route::any('/ajax/addTaskDueDate', 'ProjectController@addTaskDueDate');
Route::any('/ajax/removeTaskDueDate', 'ProjectController@removeTaskDueDate');

//Comment Task in Admin
Route::any('/ajax/addTaskCommentValue', 'ProjectController@addTaskCommentValue');
Route::any('/ajax/editTaskCommentValue', 'ProjectController@editTaskCommentValue');
Route::any('/ajax/deleteTaskComment', 'ProjectController@deleteTaskComment');

Route::any('/admin/projects/inviteUser/{id}', 'ProjectController@inviteUser');

Route::any('/ajax/addAttachment', 'ProjectController@addAttachment');
Route::any('/ajax/deleteAttachment', 'ProjectController@deleteAttachment');


//-------------------------- Front Panel Normal Functions Start---------------------------------------------------------------------------------
Route::any('/projectboard/projects', 'ProjectboardController@showproject');
Route::any('/projectboard/projects/{slug}', 'ProjectboardController@showproject');
Route::any('/projectboard/createProject', 'ProjectboardController@showaddproject');

Route::any('/board/grabAdminProjectBoard', 'ProjectboardController@grabAdminProjectBoard');
Route::any('/board/viewDefaultBoards', 'ProjectboardController@viewDefaultBoards');

Route::any('/board/updateAdminProjectSection', 'ProjectboardController@updateAdminProjectSection');


Route::any('/board/saveAdminProjectBoard', 'ProjectboardController@saveAdminProjectBoard');
Route::any('/board/saveAdminProjectTask', 'ProjectboardController@saveAdminProjectTask');
Route::any('/board/updateAdminProjectTask', 'ProjectboardController@updateAdminProjectTask');
Route::any('/board/deleteAdminProjectTask', 'ProjectboardController@deleteAdminProjectTask');
Route::any('/board/updateAdminProjectBoard', 'ProjectboardController@updateAdminProjectBoard');
Route::any('/board/deleteAdminProjectBoard', 'ProjectboardController@deleteAdminProjectBoard');

Route::any('/board/displayProjectTaskSection/{id}', 'ProjectboardController@displayProjectTaskSection');
Route::any('/board/updateAdminTaskDescriptionData', 'ProjectboardController@updateAdminTaskDescriptionData');

//To Copy Task in Front 
Route::any('/board/getAdminUserProjects', 'ProjectboardController@getAdminUserProjects');
Route::any('/board/getAdminUserTaskPosition', 'ProjectboardController@getAdminUserTaskPosition');
Route::any('/board/copyAdminProjectTask', 'ProjectboardController@copyAdminProjectTask');

//To Move Task in Front
Route::any('/board/getAdminUserMoveProjects', 'ProjectboardController@getAdminUserMoveProjects');
Route::any('/board/getAdminUserMoveTaskPosition', 'ProjectboardController@getAdminUserMoveTaskPosition');
Route::any('/board/moveAdminProjectTask', 'ProjectboardController@moveAdminProjectTask');

Route::any('/board/dragProjectTask', 'ProjectboardController@dragProjectTask');
Route::any('/board/updatePreviousBoard', 'ProjectboardController@updatePreviousBoard');

Route::any('/board/dragProjectBoard', 'ProjectboardController@dragProjectBoard');

Route::any('/board/getAdminUserMoveBoardPositionForCopy', 'ProjectboardController@getAdminUserMoveBoardPositionForCopy');
Route::any('/board/copyAdminProjectBoard', 'ProjectboardController@copyAdminProjectBoard');

Route::any('/board/getAdminUserMoveBoardPositionForMove', 'ProjectboardController@getAdminUserMoveBoardPositionForMove');
Route::any('/board/moveAdminProjectBoard', 'ProjectboardController@moveAdminProjectBoard');

//Checkbox Section in Front

Route::any('/board/addTaskChecklist', 'ProjectboardController@addTaskChecklist');
Route::any('/board/addTaskChecklistValue', 'ProjectboardController@addTaskChecklistValue');
Route::any('/board/updateTaskChecklistValueBox', 'ProjectboardController@updateTaskChecklistValueBox');
Route::any('/board/deleteProjectBoardTaskChecklist', 'ProjectboardController@deleteProjectBoardTaskChecklist');


Route::any('/board/addTaskDueDate', 'ProjectboardController@addTaskDueDate');
Route::any('/board/removeTaskDueDate', 'ProjectboardController@removeTaskDueDate');

//Comment Task in Front

Route::any('/board/addTaskCommentValue', 'ProjectboardController@addTaskCommentValue');
Route::any('/board/editTaskCommentValue', 'ProjectboardController@editTaskCommentValue');
Route::any('/board/deleteTaskComment', 'ProjectboardController@deleteTaskComment');

Route::any('/board/getEmailListOfSite', 'ProjectboardController@getEmailListOfSite');
Route::any('/board/sendInvite', 'ProjectboardController@sendInvite');

Route::any('/board/addAttachment', 'ProjectboardController@addAttachment');
Route::any('/board/deleteAttachment', 'ProjectboardController@deleteAttachment');

Route::any('/board/removeInvitedUser', 'ProjectboardController@removeInvitedUser');

Route::any('/board/saveTaskReminder', 'ProjectboardController@saveTaskReminder');

Route::any('/board/updateTaskReminder', 'ProjectboardController@updateTaskReminder');
Route::any('/board/deleteTaskReminder', 'ProjectboardController@deleteTaskReminder');

Route::any('/board/updateTaskCheckBox', 'ProjectboardController@updateTaskCheckBox');

Route::any('/board/c/{id}', 'ProjectboardController@displayProjectTaskSectionVisitor');
Route::any('/user/updateNotification', 'UserController@updateNotification');



//Update Activity

Route::any('/board/updateActivity', 'ProjectboardController@updateActivity');
Route::any('/board/updateProjectInfo', 'ProjectboardController@updateProjectInfo');

Route::any('/board/content/{id}', 'ProjectboardController@content');
Route::any('/board/{id}', 'ProjectboardController@boardlist');

Route::any('/board/invite/{id}/{id2}', 'ProjectboardController@invite');
Route::any('/boards/{type}/{id}/{id2}', 'ProjectboardController@usertypeinvite');


Route::any('/board/agent/{id}/{id2}', 'ProjectboardController@agent');
Route::any('/board/lender/{id}/{id2}', 'ProjectboardController@lender');
Route::any('/board/title/{id}/{id2}', 'ProjectboardController@title');
Route::any('/board/client/{id}/{id2}', 'ProjectboardController@client');



Route::any('/attachment/download/{id}', 'ProjectboardController@downloadAttachment');
Route::any('/attachment/getVideo/{id}', 'ProjectboardController@getVideo');



Route::any('/admin/boards/list', 'BoardController@showAdmin_index');
Route::any('/admin/admintasks/list', 'AdminTaskController@showAdmin_index');



Route::get('/admin/categories/admin_index', array('as' => 'admin.admin_index', 'uses' => 'CategoryController@all'));
Route::any('/admin/categories/admin_index', 'CategoryController@showAdmin_index');
Route::get('/admin/categories/admin_index', array('as' => 'admin.categories', 'uses' => 'CategoryController@showAdmin_index'));
Route::post('/admin/categories/admin_index', array('as' => 'admin.categories', 'uses' => 'CategoryController@showAdmin_index'));
Route::any('/admin/categories/admin_add', 'CategoryController@showAdmin_add');
Route::get('/admin/categories/Admin_activecategory/{id}', 'CategoryController@showAdmin_activecategory');
Route::get('/admin/categories/Admin_deactivecategory/{id}', 'CategoryController@showAdmin_deactivecategory');
Route::get('/admin/categories/Admin_deletecategory/{id}', 'CategoryController@showAdmin_deletecategory');
Route::get('/admin/categories/Admin_editcategory/{id}', 'CategoryController@showAdmin_editcategory');
Route::post('/admin/categories/Admin_editcategory/{id}', 'CategoryController@showAdmin_editcategory');
Route::get('/admin/categories/admindeletecategory/{id}', 'CategoryController@showAdmindeletecategory');



Route::get('/admin/customer/admin_index', array('as' => 'admin.customers', 'uses' => 'CustomerController@showAdmin_index'));
Route::post('/admin/customer/admin_index', array('as' => 'admin.customers', 'uses' => 'CustomerController@showAdmin_index'));
Route::any('/admin/customer/admin_add', 'CustomerController@showAdmin_add');
Route::any('/admin/customer/Admin_activeuser/{id}', 'CustomerController@showAdmin_activeuser');
Route::any('/admin/customer/Admin_deactiveuser/{id}', 'CustomerController@showAdmin_deactiveuser');
Route::any('/admin/customer/Admin_deleteuser/{id}', 'CustomerController@showAdmin_deleteuser');
Route::any('/admin/customer/Admin_edituser/{id}', 'CustomerController@showAdmin_edituser');
Route::any('/admin/customer/admindeleteuser/{id}', 'CustomerController@showAdmindeleteuser');


Route::get('/admin/user/userlist', array('as' => 'admin.admin_index', 'uses' => 'UserController@all'));
Route::get('/admin/user/userlist', array('as' => 'admin.users', 'uses' => 'UserController@showAdmin_index'));
Route::post('/admin/user/userlist', array('as' => 'admin.users', 'uses' => 'UserController@showAdmin_index'));

Route::any('/admin/user/adduser', 'UserController@showAdmin_add');
Route::any('/admin/user/Admin_activeuser/{id}', 'UserController@showAdmin_activeuser');
Route::any('/admin/user/Admin_approveuser/{id}', 'UserController@showAdmin_approveuser');
Route::any('/admin/user/Admin_deactiveuser/{id}', 'UserController@showAdmin_deactiveuser');
Route::any('/admin/user/Admin_deleteuser/{id}', 'UserController@showAdmin_deleteuser');
Route::any('/admin/user/Admin_edituser/{id}', 'UserController@showAdmin_edituser');
Route::any('/admin/user/admindeleteuser/{id}', 'UserController@showAdmindeleteuser');


Route::get('/admin/transaction/list', array('as' => 'admin.transactions.admin_index', 'uses' => 'TransactionController@all'));
Route::get('/admin/transaction/list', array('as' => 'admin.transactions', 'uses' => 'TransactionController@showAdmin_index'));
Route::post('/admin/transaction/list', array('as' => 'admin.transactions', 'uses' => 'TransactionController@showAdmin_index'));
Route::any('/admin/transaction/addType', 'TransactionController@showAdmin_add');
Route::any('/admin/transaction/Admin_active/{id}', 'TransactionController@showAdmin_active');
Route::any('/admin/transaction/Admin_deactive/{id}', 'TransactionController@showAdmin_deactive');
Route::any('/admin/transaction/editType/{id}', 'TransactionController@showAdmin_edit');


//Route::get('/admin/usertypes/list', array('as' => 'admin.usertypes.admin_index', 'uses' => 'UsertypeController@all'));
Route::get('/admin/usertype/list', array('as' => 'admin.usertypes', 'uses' => 'UsertypeController@showAdmin_index'));
Route::post('/admin/usertype/list', array('as' => 'admin.usertypes', 'uses' => 'UsertypeController@showAdmin_index'));
Route::any('/admin/usertype/addType', 'UsertypeController@showAdmin_add');
Route::any('/admin/usertype/Admin_active/{id}', 'UsertypeController@showAdmin_active');
Route::any('/admin/usertype/Admin_deactive/{id}', 'UsertypeController@showAdmin_deactive');
Route::any('/admin/usertype/editType/{id}', 'UsertypeController@showAdmin_edit');



Route::any('/user/dashboard', 'UserController@showuserdashboard');
//Route::any('/user/editprofile', 'UserController@showUser_editprofile');
Route::any('/user/changepassword', 'UserController@showUser_changepassword');
Route::any('/user/changepicture', 'UserController@showUser_changepicture');
Route::any('/user/deletepicture', 'UserController@showUser_deletepicture');
Route::any('/user/logout', 'UserController@showUser_logout');


Route::any('/user/categories/admin_index', 'CategoryController@showUser_index');
Route::any('/user/categories/admin_add', 'CategoryController@showUser_add');
Route::any('/user/categories/Admin_editcategory/{id}', 'CategoryController@showUser_editcategory');
Route::any('/user/categories/Admin_activecategory/{id}', 'CategoryController@showUser_activecategory');
Route::any('/user/categories/Admin_deactivecategory/{id}', 'CategoryController@showUser_deactivecategory');
Route::any('/user/categories/Admin_deletecategory/{id}', 'CategoryController@showUser_deletecategory');


//Route::any('/user/forgotpassword', 'UserController@showForgotpassword');
Route::any('/user/forgotpassword', 'HomeController@showForgotpassword');
Route::any('/user/notifications', 'UserController@notifications');



//Route for front page menus
Route::any('/signup', 'HomeController@signup');
Route::any('/logout', 'HomeController@logout');
Route::any('/account', 'HomeController@show_account');
Route::any('/dashboard', 'HomeController@show_dashboard');

Route::any('/joinproject/{id}/{id2}/{id3}/{id4}', 'ProjectboardController@joinproject');
Route::any('/join/{id}/{id2}', 'ProjectboardController@join');


Route::any('/board/{id}/{id2}', 'ProjectboardController@boardlist');
Route::any('/board/{id}/{id2}/{id3}', 'ProjectboardController@boardlist');

//Route For Seller/Buyer Controller
Route::any('/user/editprofile', 'SellerBuyerController@editProfile');
Route::any('/user/showprofile', 'SellerBuyerController@showProfile');





Route::any('/ajax/deleteListing', 'SellerBuyerController@deleteListing');


;
