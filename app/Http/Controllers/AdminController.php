<?php

namespace App\Http\Controllers;

use App\News;
use App\City;
use Session;
use Redirect;
use View;
use Input;
use Validator;
use DB;
use Cookie;
use Mail;


class AdminController extends BaseController {

    public function __construct() {
        $adminId = Session::get('adminid');

        if ($adminId == '') {
            return Redirect::to('/admin/login');
        }
    }

    // initialize admin layout
    protected $layout = 'adminloginlayout';

    // admin login page
    public function showAdminlogin() {  //Admin Login
        if (Session::has('adminid')) {
            return Redirect::to('/admin/admindashboard');
        }
        $this->layout->content = View::make('admin.adminlogin');
        $input = Input::all();
        if (!empty($input)) {
            $username = $input['username'];
            $password = md5($input['password']);
            $rules = array(
                'username' => 'required', // make sure the username field is not empty
                'password' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
            );
            if (Session::has('captcha'))
                $rules['captcha'] = 'required|checkcaptcha';

            //captcha custom validation rule
            Validator::extend('checkcaptcha', function($attribute, $value, $parameters) {
                        if (Session::get('security_number') <> $value) {
                            return false;
                        }
                        return true;
                    });

            // captcha custom message
            $messages = array(
                'checkcaptcha' => 'Please enter valid security code.'
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make($input, $rules, $messages);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/admin/login')
                                ->withErrors($validator) // send back all errors to the login form
                                ->withInput(Input::except('password'))
                                ->withInput(Input::except('captcha')); // send back the input (not the password) so that we can repopulate the form
            } else {

                // create our user data for the authentication
                $adminuser = DB::table('admins')
                        ->where('username', $username)
                        ->where('password', $password)
                        ->first();

                if (!empty($adminuser)) {

                    // destroy captcha from login
                    Session::forget('captcha');
                    
                    if(isset($input['remember']) && $input['remember']=='1')
                    {
                        Cookie::queue('admin_username', $input['username'], time() + 60 * 60 * 24 * 100, "/");
                        Cookie::queue('admin_password', $input['password'], time() + 60 * 60 * 24 * 100, "/");
                        Cookie::queue('admin_rem', '1', time() + 60 * 60 * 24 * 100, "/");
                    }
                    else
                    {
                        Cookie::queue('admin_username', '', time() + 60 * 60 * 24 * 100, "/");
                        Cookie::queue('admin_password', '', time() + 60 * 60 * 24 * 100, "/");
                        Cookie::queue('admin_rem', '', time() + 60 * 60 * 24 * 100, "/");
                    }
                    // return to dashboard page
                    Session::put('adminid', $adminuser->id);
                    Session::put('username', $adminuser->username);
                    Session::put('usertype', 'Administrator');
                    return Redirect::to('/admin/admindashboard');
                } else {

                    // return error message
                    Session::put('captcha', 1);
                    Session::put('error_message', "Invalid username or password");
                    return Redirect::to('/admin/login');
                }
            }
        } else {
            return $this->layout->content = View::make('admin.adminlogin');
        }
    }

    // admin dashboard page
    public function showAdmindashboard() {      //Admin Dashboard

        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }
        // count all users
        $dates = array();
        $year = date('Y');
        for ($i = 1; $i <= date("m"); $i++) {
            $results = DB::select('select count(tbl_users.id) as counter from tbl_users where  DATE_FORMAT(tbl_users.created, "%Y-%m") = "' . $year . '-' . str_pad($i, 2, 0, STR_PAD_LEFT) . '"');
            $dates[] = $results[0]->counter;
        }

        $results = DB::select('select count(tbl_users.id) as counter from tbl_users where  date_sub(curdate(), INTERVAL 7 DAY) <= tbl_users.created  AND NOW() >= UNIX_TIMESTAMP(tbl_users.created)');
        $last_seven_days = $results[0]->counter;

        return View::make('admin/admindashboard', array('last_seven_days' => $last_seven_days))->with('dates', $dates);
    }

    // goto admin login page
    public function showAdminlogout() {     //Admin Logout
        Session::forget('adminid');
        return Redirect::to('/admin/login')->with('success_message', 'You are logout successfully.');     
    }

    // forgotpassword page
    public function showForgotpassword() {  //Admin Forgot Password
        $this->layout = false;
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
            $adminuser = DB::table('admins')
                    ->where('email', $email)
                    ->first();

            if (!empty($adminuser)) {
                // generate random password
                $password = rand(18973824, 989721389);

                // send email to administrator
                $mail_data = array(
                    'text' => 'Your password has been retrived successfully.',
                    'email' => $adminuser->email,
                    'username' => $adminuser->username,
                    'new_password' => $password,
                    'firstname' => 'Admin',
                );
                
                // update admin password
                DB::table('admins')
                    ->where('id', $adminuser->id)
                    ->update(array('password' => md5($password)));
                
//                return View::make('emails.template')->with($mail_data); // to check mail template data to view
                Mail::send('emails.template', $mail_data, function($message) use ($adminuser) {
                            $message->setSender(array(MAIL_FROM => SITE_TITLE));
                            $message->setFrom(array(MAIL_FROM => SITE_TITLE));
                            $message->to($adminuser->email, 'Admin')->subject('Forgot Password');
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

    // admin change password page
    public function showChangepassword() {      //Admin Change Password
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
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

                return Redirect::to('/admin/changepassword')
                                ->withErrors($validator) // send back all errors to the login form
                                ->withInput(Input::except('opassword'))
                                ->withInput(Input::except('password'))
                                ->withInput(Input::except('cpassword')); // send back the input (not the password) so that we can repopulate the form
            } else {
                // create our user data for the authentication
                $adminuser = DB::table('admins')
                        ->where('password', $opassword)
                        ->first();

                if (!empty($adminuser)) {

                    // check new password with old password
                    if ($password == $opassword) {

                        // return error message
                        Session::put('error_message', "You cannot put your old password for the new password!");
                        return Redirect::to('/admin/changepassword');
                    }

                    // update admin password
                    DB::table('admins')
                            ->where('id', Session::get("adminid"))
                            ->update(array('password' => $password));
                    Session::put('success_message', "Password successfully changed");
                    return Redirect::to('/admin/changepassword');
                } else {

                    // return error message
                    Session::put('error_message', "Please enter correct old password");
                    return Redirect::to('/admin/changepassword');
                }
            }
        } else {
            return View::make('admin.changepassword');
        }
    }
    // admin change Username page
    public function showChangeusername() {       //Admin Change username
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }
        $input = Input::all();
        if (!empty($input)) {
            $ousername = $input['ousername'];
            $username = $input['username'];
            $rules = array(
                'ousername' => 'required',
                'username' => 'required', // make sure the username field is not empty
                'cusername' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make($input, $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/admin/changepassword')
                                ->withErrors($validator) // send back all errors to the login form
                                ->withInput(Input::except('ousername'))
                                ->withInput(Input::except('username'))
                                ->withInput(Input::except('cusername')); // send back the input (not the password) so that we can repopulate the form
            } else {
                // create our user data for the authentication
                $adminuser = DB::table('admins')
                        ->where('username', $ousername)
                        ->first();

                if (!empty($adminuser)) {

                    // check new password with old password
                    if ($username == $ousername) {

                        // return error message
                        Session::put('error_message', "You cannot put your old username for the new username!");
                        return Redirect::to('/admin/changeusername');
                    }

                    // update admin password
                    DB::table('admins')
                            ->where('id', Session::get("adminid"))
                            ->update(array('username' => $username));
                    Session::put('success_message', "Username successfully changed");
                    Session::put('username', $username);
                    return Redirect::to('/admin/changeusername');
                } else {

                    // return error message
                    Session::put('error_message', "Please enter correct old username");
                    return Redirect::to('/admin/changeusername');
                }
            }
        } else {
            return View::make('admin.changeusername');
        }
    }

    // admin edit profile page
    public function showEditprofile() {      //Admin Edit Profile
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        // create our user data for the authentication
        $adminuser = DB::table('admins')
                ->where('id', Session::get('adminid'))
                ->first();

        $input = Input::all();
        if (!empty($input)) {

            // set validatin rules
            $rules = array(
                'name' => 'required',
                'email' => 'required|email',
                'username' => 'required|alpha_num',
                'phone' => 'required',
                'address' => 'required',
            );
            // run the validation rules on the inputs from the form
            $validator = Validator::make($input, $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {
                return Redirect::to('/admin/editprofile')
                                ->withErrors($validator)->withInput(Input::all());
            } else {

                // update admin profile
                $data = array(
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'username' => $input['username'],
                    'phone' => $input['phone'],
                    'address' => $input['address'],
                );
                DB::table('admins')
                        ->where('id', Session::get("adminid"))
                        ->update($data);
                Session::put('success_message', "Profile Information is successfully updated.");
                return Redirect::to('/admin/editprofile');
            }
        } else {
            return View::make('admin.editprofile')->with('detail', $adminuser);
        }
    }
    
 
    

}
