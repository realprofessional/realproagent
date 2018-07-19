<?php

namespace App\Http\Controllers;

use App\User;
use App\Notification;
use App\Listing;
use App\PropertType;
use App\Propert;
use Session;
use Redirect;
use View;
use Input;
use Validator;
use DB;
use Mail;
use App\Classes\ImageManipulator;
use App\Classes\facebook\facebook;
use App\Classes\google\Google_Client;
use App\Classes\google\Google_Oauth2Service;
use Illuminate\Http\Request;

class UserController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default User Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    protected $layout = 'layouts.default_front';

    public function logincheck($url) {          //Login Check Function
        if (!Session::has('user_id')) {
            Session::put('return', $url);
            return Redirect::to('/login')->with('error_message', 'You must login to see this page.');
        } else {

            $user_id = Session::get('user_id');
            $userData = DB::table('users')
                    ->where('id', $user_id)
                    ->first();
            if (empty($userData)) {
                Session::forget('user_id');
                return Redirect::to('/');
            }
        }
    }

    public function showAdmin_index() {         //User listing in Admin Panel
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        $input = Input::all();
        $search_keyword = "";
        $searchByDateFrom = "";
        $searchByDateTo = "";
        $separator = array();
        if (!empty($input['search'])) {
            $search_keyword = trim($input['search']);
        }
        if (!empty($input['from_date'])) {
            $searchByDateFrom = trim($input['from_date']);
        }
        if (!empty($input['to_date'])) {
            $searchByDateTo = trim($input['to_date']);
        }
        $query = User::sortable()
                ->where(function ($query) use ($search_keyword) {
                    $query->where('first_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('last_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('email_address', 'LIKE', '%' . $search_keyword . '%');
                });


        if (!empty($input['from_date'])) {
            $query = $query->whereDate('created', '>=', date('Y-m-d H:i:s', strtotime($searchByDateFrom)));
        }

        if (!empty($input['to_date'])) {
            $query = $query->whereDate('created', '<=', date('Y-m-d H:i:s', strtotime($searchByDateTo)));
        }


        if (!empty($input['action'])) {
            $action = $input['action'];
            $idList = $input['chkRecordId'];
            switch ($action) {
                case "Activate":
                    DB::table('users')
                            ->whereIn('id', $idList)
                            ->update(array('status' => 1));

                    Session::put('success_message', 'User(s) activated successfully');
                    break;
                case "Approve":

                    foreach ($idList as $id) {
                        $Data = DB::table('users')
                                ->select("approve_status", "email_address", "first_name", "user_name")
                                ->where('id', $id)
                                ->first();
                        if (!$Data->approve_status) {
                            // send email to user for account varification
                            $userEmail = $Data->email_address;
                            $userName = $Data->user_name;

                            // send email to administrator
                            $mail_data = array(
                                'text' => 'Your account has been successfully confirmed by ' . SITE_TITLE . ' as User .',
                                'email' => $userEmail,
                                'username' => $userName,
                                'firstname' => $Data->first_name
                            );

//                return View::make('emails.template')->with($mail_data); // to check mail template data to view
                            Mail::send('emails.template', $mail_data, function($message) use ($mail_data) {
                                        $message->setSender(array(MAIL_FROM => SITE_TITLE));
                                        $message->setFrom(array(MAIL_FROM => SITE_TITLE));
                                        $message->to($mail_data['email'], $mail_data['firstname'])->subject('Your account successfully approved by ' . SITE_TITLE);
                                    });
                        }
                    }
                    DB::table('users')
                            ->whereIn('id', $idList)
                            ->update(array('approve_status' => 1, 'status' => '1', 'activation_status' => 1));




                    Session::put('success_message', 'User (s) approved successfully');
                    break;
                case "Deactivate":
                    DB::table('users')
                            ->whereIn('id', $idList)
                            ->update(array('status' => 0));
                    Session::put('success_message', 'User (s) deactivated successfully');
                    break;
                case "Delete":
                    DB::table('users')
                            ->whereIn('id', $idList)
                            ->delete();
                    Session::put('success_message', 'User (s) deleted successfully');
                    break;
            }
        }

        $separator = implode("/", $separator);

        // Get all the users
        $users = $query->orderBy('id', 'desc')->sortable()->paginate(10);

        // Show the page
        return View::make('Users/adminindex', compact('users'))->with('search_keyword', $search_keyword)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('searchByDateTo', $searchByDateTo);
    }

    public function showAdmin_add() {       //Add User in Admin Panel
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        $input = Input::all();
        if (!empty($input)) {


            $email_address = trim($input['email_address']);
            $rules = array(
                'user_type' => 'required', // make sure the first name field is not empty
                'first_name' => 'required', // make sure the first name field is not empty
                'last_name' => 'required', // make sure the last name field is not empty
                'email_address' => 'required|unique:users|email', // make sure the email address field is not empty
                'password' => 'required|min:8', // password can only be alphanumeric and has to be greater than 3 characters
                'cpassword' => 'required|min:8', // password can only be alphanumeric and has to be greater than 3 characters
                'profile_image' => 'mimes:jpeg,png,jpg',
                'contact' => 'required',
                'address' => 'required',
                    // 'country' => 'required',
                    //'profile_image' => 'required|mimes:jpeg,png,jpg',
            );


            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/admin/user/adduser')->withErrors($validator)->withInput(Input::all());
            } else {

                if (Input::hasFile('profile_image')) {
                    $file = Input::file('profile_image');
                    $profileImageName = time() . $file->getClientOriginalName();
                    $file->move(UPLOAD_FULL_PROFILE_IMAGE_PATH, time() . $file->getClientOriginalName());
                } else {
                    $profileImageName = "";
                }
                $address2 = '';
                if (isset($input['address2'])) {
                    $address2 = $input['address2'];
                }
                $slug = $this->createUniqueSlug($input['first_name'], 'users');
                $saveUser = array(
                    'first_name' => $input['first_name'],
                    'last_name' => $input['last_name'],
                    'user_type' => $input['user_type'],
                    //  'user_name' => $input['user_name'],
                    //  'gender' => $input['gender'],
                    'contact' => $input['contact'],
                    'address' => $input['address'],
                    'address2' => $address2,
                    //'country' => 'us',
                    //'tell_us_about_yourself' => $input['tell_us_about_yourself'],
                    'email_address' => $input['email_address'],
                    'password' => md5($input['password']),
                    'profile_image' => $profileImageName,
                    'activation_status' => 1,
                    'status' => '1',
                    'approve_status' => '1',
                    'slug' => $slug,
                    'created' => date('Y-m-d H:i:s'),
                );
                DB::table('users')->insert(
                        $saveUser
                );
                $id = DB::getPdo()->lastInsertId();


                $userEmail = $input['email_address'];

                // send email to administrator
                $mail_data = array(
                    'text' => 'Your account is successfully created by admin as User . Below are your login credentials.',
                    'email' => $input['email_address'],
                    'password' => $input['password'],
                    'firstname' => $input['first_name'] . ' ' . $input['last_name'],
                );

//                return View::make('emails.template')->with($mail_data); // to check mail template data to view
                Mail::send('emails.template', $mail_data, function($message) use ($mail_data) {
                            $message->setSender(array(MAIL_FROM => SITE_TITLE));
                            $message->setFrom(array(MAIL_FROM => SITE_TITLE));
                            $message->to($mail_data['email'], $mail_data['firstname'])->subject('Your account successfully created by admin');
                        });

                return Redirect::to('/admin/user/userlist')->with('success_message', 'User saved successfully.');
            }
        } else {
            return View::make('/Users/admin_add');
        }
    }

    public function showAdmin_edituser($slug = null) {      //Edit User in Admin Panel
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }
        $input = Input::all();

        $user = DB::table('users')
                        ->where('slug', $slug)->first();

        if (empty($user)) {
            return Redirect::to('/admin/user/userlist');
        }
        $user_id = $user->id;


        if (!empty($input)) {
            $old_profile_image = $input['old_profile_image'];
            $rules = array(
                'first_name' => 'required', // make sure the first name field is not empty
                'last_name' => 'required', // make sure the last name field is not empty
                'profile_image' => 'mimes:jpeg,png,jpg',
                'contact' => 'required',
                'address' => 'required',
                    // 'country' => 'required',
            );


            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/admin/user/Admin_edituser/' . $user->slug)
                                ->withErrors($validator) // send back all errors
                                ->withInput(Input::all());
            } else {

                if (Input::hasFile('profile_image')) {
                    $file = Input::file('profile_image');
                    $profileImageName = time() . $file->getClientOriginalName();
                    $file->move(UPLOAD_FULL_PROFILE_IMAGE_PATH, time() . $file->getClientOriginalName());

                    @unlink(UPLOAD_FULL_PROFILE_IMAGE_PATH . $old_profile_image);
                } else {
                    $profileImageName = $old_profile_image;
                }


                if (!empty($input['password'])) {
                    $data = array(
                        'first_name' => $input['first_name'],
                        'last_name' => $input['last_name'],
                        'user_type' => $input['user_type'],
                        //  'gender' => $input['gender'],
                        'contact' => $input['contact'],
                        'address' => $input['address'],
                        'address2' => $input['address2'],
                        //   'country' => $input['country'],
                        'user_type' => $input['user_type'],
                        'password' => md5($input['password']),
                        //'tell_us_about_yourself' => $input['tell_us_about_yourself'],
                        'profile_image' => $profileImageName,
                        'status' => '1',
                        //'tell_us_about_yourself' => $input['tell_us_about_yourself'],
                        'modified' => date('Y-m-d H:i:s'),
                    );
                } else {
                    $data = array(
                        'first_name' => $input['first_name'],
                        'last_name' => $input['last_name'],
                        //   'gender' => $input['gender'],
                        'contact' => $input['contact'],
                        'address' => $input['address'],
                        'address2' => $input['address2'],
                        'user_type' => $input['user_type'],
                        //   'country' => $input['country'],
                        //'tell_us_about_yourself' => $input['tell_us_about_yourself'],
                        'profile_image' => $profileImageName,
                        'status' => '1',
                        //'tell_us_about_yourself' => $input['tell_us_about_yourself'],
                        'modified' => date('Y-m-d H:i:s'),
                    );
                }

                DB::table('users')
                        ->where('id', $user_id)
                        ->update($data);

                if (!empty($input['password']) && !empty($input['cpassword'])) {
                    $data['password'] = md5($input['password']);

                    // send email to administrator
                    $mail_data = array(
                        'text' => 'Your account password successfully updated by admin as User . Below are your login credentials.',
                        'email' => $user->email_address,
                        'password' => $input['password'],
                        'firstname' => $input['first_name'] . ' ' . $input['last_name'],
                    );
                    //                return View::make('emails.template')->with($mail_data); // to check mail template data to view
                    Mail::send('emails.template', $mail_data, function($message) use ($mail_data) {
                                $message->setSender(array(MAIL_FROM => SITE_TITLE));
                                $message->setFrom(array(MAIL_FROM => SITE_TITLE));
                                $message->to($mail_data['email'], $mail_data['firstname'])->subject('Your account password successfully updated by admin.');
                            });
                }
                return Redirect::to('/admin/user/userlist')->with('success_message', 'User profile details updated successfully.');
            }
        } else {



            return View::make('/Users/admin_edituser')->with('detail', $user);
        }
    }

    public function showAdmin_activeuser($slug = null) {        //Activate User from Admin Panel
        if (!empty($slug)) {

            // check admin approval
            $Data = DB::table('users')
                    ->select("approve_status", "email_address", "first_name")
                    ->where('slug', $slug)
                    ->first();
            if (!$Data->approve_status) {
                // send email to user for account varification
                $userEmail = $Data->email_address;

                // send email to administrator
                $mail_data = array(
                    'text' => 'Your account has been successfully confirmed by ' . SITE_TITLE . ' as User .',
                    'email' => $userEmail,
                    'firstname' => $Data->first_name
                );

//                return View::make('emails.template')->with($mail_data); // to check mail template data to view
                Mail::send('emails.template', $mail_data, function($message) use ($mail_data) {
                            $message->setSender(array(MAIL_FROM => SITE_TITLE));
                            $message->setFrom(array(MAIL_FROM => SITE_TITLE));
                            $message->to($mail_data['email'], $mail_data['firstname'])->subject('Your account successfully approved by ' . SITE_TITLE);
                        });
            }

            DB::table('users')
            ->where('slug', $slug)
            ->update(['status' => 1]);

            return Redirect::back()->with('success_message', 'User activated successfully');
        }
    }

    public function showAdmin_deactiveuser($slug = null) {       //Dectivate User from Admin Panel
        if (!empty($slug)) {
            DB::table('users')
            ->where('slug', $slug)
            ->update(['status' => 0]);

            return Redirect::back()->with('success_message', 'User deactivated successfully');
        }
    }

    public function showAdmin_deleteuser($slug = null) {        //Delete User from Admin Panel
        if (!empty($slug)) {
            DB::table('users')->where('slug', $slug)->delete();
            return Redirect::to('/admin/user/userlist')->with('success_message', 'User deleted successfully');
        }
    }

    public function showAdmin_approveuser($slug = null) {       //Approve User from Admin Panel
        if (!empty($slug)) {

            // check admin approval
            $Data = DB::table('users')
                    ->select("approve_status", "email_address", "first_name", "user_name")
                    ->where('slug', $slug)
                    ->first();
            if (!$Data->approve_status) {
                // send email to user for account varification
                $userEmail = $Data->email_address;
                $userName = $Data->user_name;
                // send email to administrator
                $mail_data = array(
                    'text' => 'Your account has been successfully confirmed by ' . SITE_TITLE . ' as User .',
                    'email' => $userEmail,
                    'username' => $userName,
                    'firstname' => $Data->first_name
                );

//                return View::make('emails.template')->with($mail_data); // to check mail template data to view
                Mail::send('emails.template', $mail_data, function($message) use ($mail_data) {
                            $message->setSender(array(MAIL_FROM => SITE_TITLE));
                            $message->setFrom(array(MAIL_FROM => SITE_TITLE));
                            $message->to($mail_data['email'], $mail_data['firstname'])->subject('Your account successfully approved by ' . SITE_TITLE);
                        });
            }

            DB::table('users')
            ->where('slug', $slug)
            ->update(['approve_status' => 1, 'status' => '1', 'activation_status' => 1]);


            return Redirect::back()->with('success_message', 'Property Owner (s) Approved successfully');
        }
    }

    // User functions for admin   
    function showuserdashboard() {

        if (Session::has('user_id')) {

            //Session::forget('user_id');
            //Session::forget('type');
            $layout = 'default';
            $this->layout->title = TITLE_FOR_PAGES . 'User ';



            $dates = array();
            $year = date('Y');
            for ($i = 1; $i <= date("m"); $i++) {
                $results = DB::select('select count(tbl_users.id) as counter from tbl_users where user_type = "Hotel owner" and DATE_FORMAT(tbl_users.created, "%Y-%m") = "' . $year . '-' . str_pad($i, 2, 0, STR_PAD_LEFT) . '"');
                $dates[] = 0;
            }

            $results = DB::select('select count(tbl_users.id) as counter from tbl_users where user_type = "Hotel owner" and date_sub(curdate(), INTERVAL 7 DAY) <= tbl_users.created  AND NOW() >= UNIX_TIMESTAMP(tbl_users.created)');
            $last_seven_days = 0;
            $this->layout->content = View::make('Users.userdashboard', array('last_seven_days' => $last_seven_days))->with('dates', $dates);
            //return View::make('admin/admindashboard', array('last_seven_days' => $last_seven_days))->with('dates', $dates);
        } else {

            return Redirect::to('/');
        }
    }

    function showUser_editprofile() {

        if (!Session::has('user_id')) {
            return Redirect::to('/');
        }

        // create our user data for the authentication
        $users = DB::table('users')
                ->where('id', Session::get('user_id'))
                ->first();

        $input = Input::all();
        if (!empty($input)) {

            // set validatin rules
            $rules = array(
                'contact' => 'required',
                'address' => 'required',
            );
            // run the validation rules on the inputs from the form
            $validator = Validator::make($input, $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {
                return Redirect::to('/user/editprofile')
                                ->withErrors($validator)->withInput(Input::all());
            } else {

                // update admin profile
                $data = array(
                    'contact' => $input['contact'],
                    'address' => $input['address'],
                );
                DB::table('users')
                        ->where('id', Session::get("user_id"))
                        ->update($data);
                Session::put('success_message', "Profile Information is successfully updated.");
                return Redirect::to('/user/editprofile');
            }
        } else {
            return View::make('Users.usereditprofile')->with('detail', $users);
        }
    }

    public function showUser_changepassword() {
        if (!Session::has('user_id')) {
            return Redirect::to('/');
        }
        $input = Input::all();
        if (!empty($input)) {
            $opassword = md5($input['opassword']);
            $password = md5($input['password']);
            $rules = array(
                'opassword' => 'required',
                'password' => 'required', // make sure the username field is not empty
                'cpassword' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make($input, $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/user/changepassword')
                                ->withErrors($validator) // send back all errors to the login form
                                ->withInput(Input::except('opassword'))
                                ->withInput(Input::except('password'))
                                ->withInput(Input::except('cpassword')); // send back the input (not the password) so that we can repopulate the form
            } else {
                // create our user data for the authentication
                $adminuser = DB::table('users')
                        ->where('password', $opassword)
                        ->first();

                if (!empty($adminuser)) {

                    // check new password with old password
                    if ($password == $opassword) {

                        // return error message
                        Session::put('error_message', "You cannot put your old password for the new password!");
                        return Redirect::to('/user/changepassword');
                    }

                    // update admin password
                    DB::table('users')
                            ->where('id', Session::get("user_id"))
                            ->update(array('password' => $password));
                    Session::put('success_message', "Password successfully changed");
                    return Redirect::to('/user/changepassword');
                } else {

                    // return error message
                    Session::put('error_message', "Please enter correct old password");
                    return Redirect::to('/user/changepassword');
                }
            }
        } else {

            $this->layout->content = View::make('Users.userchangepassword');
        }
    }

    public function showUser_changepicture() {

        $this->layout = View::make('layouts.default_front_project');
        if (!Session::has('user_id')) {
            return Redirect::to('/');
        }
        $user_id = Session::get('user_id');
        $user = DB::table('users')
                ->where('id', $user_id)
                ->where('status', '1')
                ->first();

        $input = Input::all();
        if (!empty($input)) {
            $rules = array(
                'profile_image' => 'required'
            );
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return Redirect::to('/user/changepicture')
                                ->withErrors($validator);
            } else {
                if (Input::hasFile('profile_image')) {
                    $file = Input::file('profile_image');
                    $profileImageName = time() . $file->getClientOriginalName();
                    $file->move(UPLOAD_FULL_PROFILE_IMAGE_PATH, time() . $file->getClientOriginalName());
                } else {
                    $profileImageName = $user->profile_image;
                }

                $saveUser = array(
                    'profile_image' => $profileImageName
                );
                DB::table('users')
                        ->where('id', $user_id)
                        ->update(
                                $saveUser
                );
                return Redirect::to('/user/changepicture')->with('success_message', 'Picture updated successfully.');
            }
        }
        $layout = 'layouts.default_front';
        $this->layout->title = TITLE_FOR_PAGES . 'User Change Picture';
        $this->layout->content = View::make('Users.changepicture')->with('user', $user);
    }

    public function showUser_deletepicture() {
        if (!Session::has('user_id')) {
            return Redirect::to('/');
        }
        $user_id = Session::get('user_id');
        $user = DB::table('users')
                ->where('id', $user_id)
                ->where('status', '1')
                ->first();
        //echo UPLOAD_FULL_PROFILE_IMAGE_PATH . '/' . $user->profile_image; exit;

        @unlink(UPLOAD_FULL_PROFILE_IMAGE_PATH . '/' . $user->profile_image);

        $saveUser = array(
            'profile_image' => ''
        );
        DB::table('users')
                ->where('id', $user_id)
                ->update(
                        $saveUser
        );

        return Redirect::to('/user/changepicture')->with('success_message', 'Picture deleted successfully.');
    }

    // goto user hotel owner logout page

    public function showUser_logout() {
        Session::forget('user_id');
        Session::forget('type');
        return Redirect::to('/')->with('success_message', 'You are logout successfully.');
    }

    // forgotpassword page
    public function showForgotpassword() {
        //$this->layout = false;
        $input = Input::all();
        $email = $input['email'];
        $rules = array(
            'email' => 'required'
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make($input, $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            $errors->first('email');
            return json_encode(array('message' => $errors, 'valid' => 0));

            exit;
        } else {

            // create our user data for the authentication
            $users = DB::table('users')
                    ->where('email_address', $email)
                    ->first();

            if (!empty($users)) {
                // generate random password
                $password = rand(18973824, 989721389);

                // send email to administrator
                $mail_data = array(
                    'text' => 'Your password has been retrived successfully.',
                    'email' => $users->email_address,
                    'username' => $users->user_name,
                    'new_password' => $password,
                    'firstname' => $users->first_name . ' ' . $users->last_name,
                );

                // update admin password
                DB::table('users')
                        ->where('id', $users->id)
                        ->update(array('password' => md5($password)));


//                return View::make('emails.template')->with($mail_data); // to check mail template data to view
                Mail::send('emails.template', $mail_data, function($message) use ($users) {
                            $message->setSender(array(MAIL_FROM => SITE_TITLE));
                            $message->setFrom(array(MAIL_FROM => SITE_TITLE));
                            $message->to($users->email_address, 'Hotel Owner')->subject('Forgot Password');
                        });

                if (count(Mail::failures()) > 0) {

                    echo $errors = 'Failed to send password reset email, please try again.';
                    foreach (Mail::failures() as $email_address) {
                        echo " - $email_address <br />";
                    }
                }
                // end mail script

                return json_encode(array('message' => 'Your password has been sent on your email id.', 'valid' => 1));
                exit;
            } else {

                // return error message
                return json_encode(array('message' => 'You have entered wrong email address please re-enter.', 'valid' => 0));
                exit;
            }
        }
    }

    public function notifications() {         //User listing in Admin Panel
        if (!Session::has('user_id')) {
            return Redirect::to('/account');
        }


        $userId = Session::get('user_id');

        $saveList = array(
            'read_status' => 1,
            'modified' => date('Y-m-d H:i:s')
        );

        $notiUpdate = DB::table('notifications')
                ->where('notifications.user_id', $userId)
                ->update($saveList);

        $input = Input::all();
        $search_keyword = "";
        $searchByDateFrom = "";
        $searchByDateTo = "";
        $separator = array();
        if (!empty($input['search'])) {
            $search_keyword = trim($input['search']);
        }
        if (!empty($input['from_date'])) {
            $searchByDateFrom = trim($input['from_date']);
        }
        if (!empty($input['to_date'])) {
            $searchByDateTo = trim($input['to_date']);
        }
        $query = Notification::sortable()
                ->where(function ($query) use ($userId) {
                    $query->where('notifications.user_id', 'LIKE', '' . $userId . '');
                });


        if (!empty($input['from_date'])) {
            $query = $query->whereDate('created', '>=', date('Y-m-d H:i:s', strtotime($searchByDateFrom)));
        }

        if (!empty($input['to_date'])) {
            $query = $query->whereDate('created', '<=', date('Y-m-d H:i:s', strtotime($searchByDateTo)));
        }



        $separator = implode("/", $separator);

        // Get all the users
        $notifications = $query->leftjoin('users', 'users.id', '=', 'notifications.user_id')
                        ->leftjoin('projects', 'projects.id', '=', 'notifications.project_id')
                        ->leftjoin('boards', 'boards.id', '=', 'notifications.board_id')
                        ->leftjoin('tasks', 'tasks.id', '=', 'notifications.task_id')
                        ->select('notifications.*', 'users.status as user_status', 'users.slug as user_slug', 'users.first_name as first_name', 'users.last_name as last_name', 'users.email_address as email_address', 'projects.slug as project_slug', 'projects.project_name as project_name', 'boards.slug as board_slug', 'boards.board_name as board_name', 'tasks.slug as task_slug', 'tasks.task_name as task_name')
                        ->orderBy('notifications.id', 'desc')->sortable()->paginate(10);
        // Show the page 
        // echo "adasd"; exit;
        //$this->layout = "default_front";
        return View::make('Users/notifications', compact('notifications'))->with('search_keyword', $search_keyword);
    }

    function updateNotification() {
        if (!Session::has('user_id')) {
            echo "0";
            exit;
        } else {
            $userId = Session::get('user_id');
        }


        $allNotifications = DB::table('notifications')
                        ->select('notifications.*')
                        ->where('notifications.read_status', 0)
                        ->where('notifications.user_id', $userId)->get();
        
//        dd($allNotifications);

        if (!empty($allNotifications)) {
            echo sizeof($allNotifications);
        } else {
            echo "0";
        }

        exit;
    }

}
