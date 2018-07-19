<?php

namespace App\Http\Controllers;

use Session;
use Request;
use Response;
use App\Propert;
use View;
use Redirect;
use Validator;
use Cookie;
use Input;
use DB;
use Mail;
use Carbon;

class HomeController extends BaseController {
    /*
     * 
     * 
     */

    protected $layout = 'layouts.default_front';    //Default front layout for controller functions

    public function showWelcome() {     //Homepage Function
        //return Redirect::to('/admin');
        $layout = 'layout';
        $this->layout->title = TITLE_FOR_PAGES . 'Welcome';
        $this->layout->content = View::make('home.index');
    }

    // generate captcha code
    public function showCapcha() {

        $this->layout = false;
        /*
         *
         * this code is based on captcha code by Simon Jarvis 
         * http://www.white-hat-web-design.co.uk/articles/php-captcha.php
         *
         * This program is free software; you can redistribute it and/or 
         * modify it under the terms of the GNU General Public License 
         * as published by the Free Software Foundation
         *
         * This program is distributed in the hope that it will be useful, 
         * but WITHOUT ANY WARRANTY; without even the implied warranty of 
         * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
         * GNU General Public License for more details: 
         * http://www.gnu.org/licenses/gpl.html
         */

//Settings: You can customize the captcha here
        $image_width = 120;
        $image_height = 40;
        $characters_on_image = 6;
        $font = 'public/img/monofont.ttf';

//The characters that can be used in the CAPTCHA code.
//avoid confusing characters (l 1 and i for example)
        $possible_letters = '23456789bcdfghjkmnpqrstvwxyz';
        $random_dots = 0;
        $random_lines = 20;
        $captcha_text_color = "0x1cd67c";
        $captcha_noice_color = "0x1cd67c";

        $code = '';

        $i = 0;
        while ($i < $characters_on_image) {
            $code .= substr($possible_letters, mt_rand(0, strlen($possible_letters) - 1), 1);
            $i++;
        }

        $font_size = $image_height * 0.75;
        $image = @imagecreate($image_width, $image_height);


        /* setting the background, text and noise colours here */
        $background_color = imagecolorallocate($image, 255, 255, 255);

        $arr_text_color = $this->hexrgb($captcha_text_color);
        $text_color = imagecolorallocate($image, $arr_text_color['red'], $arr_text_color['green'], $arr_text_color['blue']);

        $arr_noice_color = $this->hexrgb($captcha_noice_color);
        $image_noise_color = imagecolorallocate($image, $arr_noice_color['red'], $arr_noice_color['green'], $arr_noice_color['blue']);


        /* generating the dots randomly in background */
        for ($i = 0; $i < $random_dots; $i++) {
            imagefilledellipse($image, mt_rand(0, $image_width), mt_rand(0, $image_height), 2, 3, $image_noise_color);
        }


        /* generating lines randomly in background of image */
        for ($i = 0; $i < $random_lines; $i++) {
            imageline($image, mt_rand(0, $image_width), mt_rand(0, $image_height), mt_rand(0, $image_width), mt_rand(0, $image_height), $image_noise_color);
        }


        /* create a text box and add 6 letters code in it */
        $textbox = imagettfbbox($font_size, 0, $font, $code);
        $x = ($image_width - $textbox[4]) / 2;
        $y = ($image_height - $textbox[5]) / 2;
        imagettftext($image, $font_size, 0, $x, $y, $text_color, $font, $code);


        /* Show captcha image in the page html page */
        header('Content-Type: image/jpeg'); // defining the image type to be shown in browser widow
        imagejpeg($image); //showing the image
        imagedestroy($image); //destroying the image instance
        Session::put('security_number', $code);
        Session::save();
    }

    function hexrgb($hexstr) {
        $int = hexdec($hexstr);

        return array("red" => 0xFF & ($int >> 0x10),
            "green" => 0xFF & ($int >> 0x8),
            "blue" => 0xFF & $int);
    }

    function showLogin() {      //Login Function
        if (Session::has('user_id')) {
            return Redirect::to('/account');
            exit;
        }

        if (Request::method() == 'POST') {
            $input = Input::all();
            //print_r($input);exit;
            if (!empty($input)) {

                $username = $input['emailaddress'];
                $password = md5($input['password']);
                $rules = array(
                    'emailaddress' => 'required', // make sure the username field is not empty
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
                if ($validator->fails()) {
                    return Redirect::to('/login')
                                    ->withErrors($validator) // send back all errors to the login form
                                    ->withInput(Input::except('password'))
                                    ->withInput(Input::except('captcha')); // send back the input (not the password) so that we can repopulate the form
                } else {
                    // create our user data for the authentication
                    $userData = DB::table('users')
                            ->where('email_address', $username)
                            ->where('password', $password)
                            ->first();

                    if (!empty($userData)) {
                        // check activation status
                        if ($userData->activation_status == 0) {
                            Session::put('error_message', "Your account is not activated yet. Please check your email for verification link.");
                            return Redirect::to('/login');
                        }

                        // check activation status
                        if ($userData->status == 0) {
                            Session::put('error_message', "Your account might have been temporarily disabled.");
                            return Redirect::to('/login');
                        }

                        if (isset($input['remember']) && $input['remember'] == 1) {
                            Cookie::queue('admin_username', $input['emailaddress'], time() + 60 * 60 * 24 * 100, "/");
                            Cookie::queue('admin_password', $input['password'], time() + 60 * 60 * 24 * 100, "/");
                            Cookie::queue('admin_rem', '1', time() + 60 * 60 * 24 * 100, "/");


//                        Session::put('email_address', $email_address); // 30 days
//                        Session::put('planPass', $planPass); // 30 days
//                        Session::put('remember', '1'); // 30 days
                        } elseif (isset($input['remember']) && $input['remember'] == 0) {
//                        Session::put('email_address', ''); // 30 days
//                        Session::put('planPass', ''); // 30 days
//                        Session::put('remember', ''); // 30 days
                            Cookie::queue('admin_username', '', time() + 60 * 60 * 24 * 100, "/");
                            Cookie::queue('admin_password', '', time() + 60 * 60 * 24 * 100, "/");
                            Cookie::queue('admin_rem', '', time() + 60 * 60 * 24 * 100, "/");
                        }

                        // return to dashboard page
                        Session::put('user_id', $userData->id);
                        Session::forget('captcha');


                        if (isset($input['invid']) && !empty($input['invid'])) {
                            $invid = $input['invid'];
                            $inviteData = DB::table('invites')
                                    ->join('projects', 'projects.id', '=', 'invites.project_id')
                                    ->select('invites.*', 'projects.project_name as project_name', 'projects.slug as project_slug')
                                    ->where('invites.id', $invid)
                                    ->first();

                            if ($inviteData->email_address == $input['getEmail']) {
                                if ($inviteData->join_status == 0) {

                                    $dataInvite = array(
                                        'join_status' => 1,
                                        'user_id' => $userData->id,
                                        'modified' => date('Y-m-d H:i:s'),
                                    );

                                    DB::table('invites')
                                            ->where('id', $invid)
                                            ->update($dataInvite);

                                    $dataProjectInvite = array(
                                        'project_id' => $inviteData->project_id,
                                        'board_id' => $inviteData->board_id,
                                        'user_id' => $userData->id,
                                        'status' => 1,
                                        'created' => date('Y-m-d H:i:s'),
                                        'modified' => date('Y-m-d H:i:s'),
                                    );

                                    $projectInvite = DB::table('projectinvites')->insertGetId(
                                            $dataProjectInvite
                                    );

                                    return Redirect::to('/board/' . $inviteData->project_slug);
                                } else {
                                    return Redirect::to('/board/' . $inviteData->project_slug);
                                }
                            }
                        } else {
                            $invid = 0;
                        }

                        return Redirect::to('/dashboard');
                    } else {
                        // return error message
                        Session::put('captcha', 1);
                        Session::put('error_message', "Invalid Email Address or password");
                        return Redirect::to('/login');
                    }
                }
            }
        }
        $this->layout->title = TITLE_FOR_PAGES . 'Sign In';
        $this->layout->content = View::make('home.login');
    }

    function signup() {     //Signup Function
        if (Session::has('user_id')) {
            return Redirect::to('/');
        }

        if (Request::method() == 'POST') {
            $input = Input::all();
            if (!empty($input)) {


                $rules = array(
                    'first_name' => 'required', // make sure the first name field is not empty
                    'last_name' => 'required', // make sure the last name field is not empty
                    'email_address' => 'required|unique:users', // make sure the email address field is not empty
                    'password' => 'required', // password can only be alphanumeric and has to be greater than 3 characters
                        //'profile_image' => 'required',
                );

                $validator = Validator::make($input, $rules);
                if ($validator->fails()) {

                    // Session::forget('captcha');
                    return Redirect::to('/signup')
                                    ->withErrors($validator) // send back all errors to the login form
                                    ->withInput(Input::except('password'))
                                    ->withInput(Input::except('cpassword')); // send back the input (not the password) so that we can repopulate the form
                } else {
//                $password = md5($input['password']);
//                $email_address = $input['email_address'];
                    $slug = $this->createUniqueSlug($input['first_name'] . ' ' . $input['last_name'], 'users');
                    $saveUser = array(
                        'first_name' => $input['first_name'],
                        'last_name' => $input['last_name'],
                        //'tell_us_about_yourself' => $input['tell_us_about_yourself'],
                        'email_address' => $input['email_address'],
                        'password' => md5($input['password']),
                        'activation_status' => 0,
                        'status' => '1',
                        'slug' => $slug,
                        'created' => date('Y-m-d H:i:s'),
                    );
                    $userId = DB::table('users')->insertGetId(
                            $saveUser
                    );

                    $reset_link = HTTP_PATH . "activateprofile/" . $slug;

                    // send email to administrator
                    $mail_data = array(
                        'firstname' => $input['first_name'],
                        'text' => 'Your account has been created successfully on Taskboard. Please activate your account with below link.',
                        'email' => $input['email_address'],
                        'password' => $input['password'],
                        'resetLink' => '<a href="' . $reset_link . '">Click here<a> to verify your account.'
                    );

                    // return View::make('emails.template')->with($mail_data); // to check mail template data to view
                    Mail::send('emails.template', $mail_data, function($message) use ($mail_data) {
                                $message->setSender(array(MAIL_FROM => SITE_TITLE));
                                $message->setFrom(array(MAIL_FROM => SITE_TITLE));
                                $message->to($mail_data['email'], '')->subject('Welcome to ' . SITE_TITLE);
                            });

                    if (isset($input['invid']) && !empty($input['invid'])) {
                        $invid = $input['invid'];
                        $inviteData = DB::table('invites')
                                ->join('projects', 'projects.id', '=', 'invites.project_id')
                                ->select('invites.*', 'projects.project_name as project_name', 'projects.slug as project_slug')
                                ->where('invites.id', $invid)
                                ->first();

                        if ($inviteData->email_address == $input['email_address']) {
                            $dataInvite = array(
                                'join_status' => 1,
                                'user_id' => $userId,
                                'modified' => date('Y-m-d H:i:s'),
                            );

                            DB::table('invites')
                                    ->where('id', $invid)
                                    ->update($dataInvite);

                            $dataUser = array(
                                'user_type' => $inviteData->user_type,
                                'modified' => date('Y-m-d H:i:s'),
                            );

                            DB::table('users')
                                    ->where('id', $userId)
                                    ->update($dataUser);


                            $dataProjectInvite = array(
                                'project_id' => $inviteData->project_id,
                                'board_id' => $inviteData->board_id,
                                'user_id' => $userId,
                                'status' => 1,
                                'created' => date('Y-m-d H:i:s'),
                                'modified' => date('Y-m-d H:i:s'),
                            );

                            $projectInvite = DB::table('projectinvites')->insertGetId(
                                    $dataProjectInvite
                            );
                        }
                    } else {
                        $invid = 0;
                    }

                    if ($invid == 0) {
                        return Redirect::to('/login')->with('success_message', 'Your account has been created successfully. Please check your email for verification link.');
                    } else {
                        return Redirect::to('/login?email_address=' . $input['email_address'] . '&invid=' . $invid)->with('success_message', 'Your account has been created successfully. Please check your email for verification link.');
                    }
                }
            }
        }

        $this->layout->title = TITLE_FOR_PAGES . 'Signup';
        $this->layout->content = View::make('home.signup');
    }

    //Activate Account
    function activate_user($slug = "") {        //Activate User
        $this->layout = false;
        $Data = DB::table('users')
                ->where('users.slug', $slug)
                ->first();
        if (!empty($Data)) {
            $upData = array(
                'activation_status' => 1,
                'status' => 1
            );
            DB::table('users')
                    ->where('id', $Data->id)
                    ->update($upData);
            Session::put('success_message', "Your account has been successfully activated. Please login!");
            $user_log = Session::get('user_id');
            if (!empty($user_log)) {
                return Redirect::to('/account');
            } else {
                return Redirect::to('/login');
            }
        } else {

            // return error message
            Session::put('error_message', "You have already used this link.");
            return Redirect::to('/login');
        }
    }

    // forgotpassword page
    public function showForgotpassword() {      //Forgot Password Function
        $input = Input::all();
        if (!empty($input)) {
            $email = $input['email'];
            $rules = array(
                'email' => 'required'
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make($input, $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {
                $errors->first('email');
                return Redirect::to('/user/forgotpassword')->with('error_message', 'Email You entered system do not found.');
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
                        //'username' => $users->user_name,
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
                                $message->to($users->email_address, 'User')->subject('Forgot Password');
                            });

                    if (count(Mail::failures()) > 0) {
                        echo $errors = 'Failed to send password reset email, please try again.';
                        foreach (Mail::failures() as $email_address) {
                            echo " - $email_address <br />";
                        }
                    }
                    // end mail script

                    return Redirect::to('/login')->with('success_message', 'Your password has been sent on your email id.');
                } else {
                    // return error message
                    return Redirect::to('/user/forgotpassword')->with('error_message', 'Email You entered system do not found.');
                }
            }
        }
        $this->layout->title = TITLE_FOR_PAGES . 'Forget';
        $this->layout->content = View::make('home.forget');
    }

    function show_account() {   //Front User Account Page
        $this->layout = View::make('layouts.default_front_project');


        if (!Session::has('user_id')) {
            return Redirect::to('/');
        }

        $user_id = Session::get('user_id');

        $user = DB::table('users')
                ->where('id', $user_id)
                ->where('status', '1')
                ->first();

        if (empty($user)) {
            Session::forget('user_id');
            return Redirect::to('/login')->with('error_message', 'Your account might have been temporarily disabled.');
        }


        $projects = DB::table('projects')
                ->join('transactions', 'transactions.id', '=', 'projects.transaction_type')
                ->where('user_id', $user_id)
                ->where('projects.status', 1)
                ->where('transaction_type', ">", 0)
                ->select('transaction_type', 'type', DB::raw('COUNT(transaction_type) as count'))
                ->groupby('transaction_type')
                ->orderby('type', 'asc')
                ->get();

        //  dd($projects);

        $pieChartArray = array();
        $finalArray = array();
        $k = 0;

        foreach ($projects as $project) {
            $pieChartArray[$project->type] = $project->count;
        }



        if (!empty($pieChartArray)) {
            foreach ($pieChartArray as $key => $val) {
                $finalArray[$k]['title'] = $key;
                $finalArray[$k]['value'] = $val;
                ++$k;
            }
        } else {
            $finalArray[$k]['title'] = 'No Project';
            $finalArray[$k]['value'] = 100;
        }

        $jsonFinalArray = json_encode($finalArray);

        //dd($jsonFinalArray);

        $this->layout->title = TITLE_FOR_PAGES . 'Account';
        $this->layout->content = View::make('home.account')->with('jsonFinalArray', $jsonFinalArray);

        // $this->layout->title = TITLE_FOR_PAGES . 'Account';
        // $this->layout->content = View::make('home.account');
    }

    function logout() {      //Front User Logout Function
        if (Session::has('user_id')) {
            Session::forget('user_id');
            return Redirect::to('/login')->with('success_message', 'You are Signed out successfully.');
        } else {
            return Redirect::to('/login')->with('success_message', 'You are already Signed out.');
        }
    }

    function show_dashboard() {   
//        echo date('Y-m-d H:i:s'); 

        //Front User Account Page
        $this->layout = View::make('layouts.default_front_project');
        if (!Session::has('user_id')) {
            return Redirect::to('/');
        }

        $user_id = Session::get('user_id');

        $user = DB::table('users')
                ->where('id', $user_id)
                ->where('status', '1')
                ->first();

        if (empty($user)) {
            Session::forget('user_id');
            return Redirect::to('/login')->with('error_message', 'Your account might have been temporarily disabled.');
        }

        $projects = DB::table('projects')
                ->join('transactions', 'transactions.id', '=', 'projects.transaction_type')
                ->where('user_id', $user_id)
                ->where('projects.status', 1)
                ->where('transaction_type', ">", 0)
                ->select('transaction_type', 'type', DB::raw('COUNT(transaction_type) as count'))
                ->groupby('transaction_type')
                ->orderby('type', 'asc')
                ->get();

        //  dd($projects);

        $pieChartArray = array();
        $finalArray = array();
        $k = 0;

        foreach ($projects as $project) {
            $pieChartArray[$project->type] = $project->count;
        }



        if (!empty($pieChartArray)) {
            foreach ($pieChartArray as $key => $val) {
                $finalArray[$k]['title'] = $key;
                $finalArray[$k]['value'] = $val;
                ++$k;
            }
        } else {
            $finalArray[$k]['title'] = 'No Project';
            $finalArray[$k]['value'] = 100;
        }

        $jsonFinalArray = json_encode($finalArray);


        $projectsTransactionCount = DB::table('projects')
                ->where('user_id', $user_id)
                ->where('projects.status', 1)
                ->where('transaction_amount', ">", 0)
                ->select(DB::raw('SUM(transaction_amount) as count'))
                ->orderby('id', 'dasc')
                ->first();

        $projectsTransaction = DB::table('projects')
                ->where('user_id', $user_id)
                ->where('projects.status', 1)
                ->where('transaction_amount', ">", 0)
                ->select('transaction_type', "transaction_amount", "project_name", 'slug')
                ->groupby('id')
                ->limit('5')
                ->orderby('id', 'dasc')
                ->get();

        $stDt = date('Y-m-d') . " 00:00:00";
        $enDt = date('Y-m-d') . " 23:59:59";
        
        
        $enDtUse = date('Y-m-d') . " 00:00:00";
        
        $date = strtotime("-7 day");
        $sdaDt = date('Y-m-d', $date) . " 23:59:59";

        $dueTaskData = DB::table('tasks')
                ->join('boards', 'boards.id', '=', 'tasks.board_id')
                ->join('projects', 'projects.id', '=', 'boards.project_id')
                ->where('projects.user_id', $user_id)
                ->where('tasks.is_checked', 0)
                ->whereNotNull('tasks.due_date')
                ->whereBetween('tasks.due_date', array($stDt, $enDt))
                ->select('tasks.*', 'projects.slug as project_slug', 'projects.project_name as project_name', 'boards.slug as board_slug', 'boards.board_name as board_name', 'tasks.slug as task_slug')
                ->orderby('tasks.due_date', 'asc')
                ->limit(20)
                ->get();
        
//        echo $enDt;
//        echo '<pre>';        print_r($dueTaskData); exit;

        $upcomingTaskData = DB::table('tasks')
                ->join('boards', 'boards.id', '=', 'tasks.board_id')
                ->join('projects', 'projects.id', '=', 'boards.project_id')
                ->where('projects.user_id', $user_id)
                ->where('tasks.is_checked', 0)
                ->whereNotNull('tasks.due_date')
                ->where('tasks.due_date', '>', $enDt)
                ->select('tasks.*', 'projects.slug as project_slug', 'projects.project_name as project_name', 'boards.slug as board_slug', 'boards.board_name as board_name', 'tasks.slug as task_slug')
                ->orderby('tasks.due_date', 'asc')
                ->limit(20)
                ->get();

        $previousTaskData = DB::table('tasks')
                ->join('boards', 'boards.id', '=', 'tasks.board_id')
                ->join('projects', 'projects.id', '=', 'boards.project_id')
                ->where('projects.user_id', $user_id)
                ->where('tasks.is_checked', 0)
                ->whereNotNull('tasks.due_date')
                ->where('tasks.due_date', '<', $enDtUse)
                ->where('tasks.due_date', '!=', '0000-00-00 00:00:00')
                ->select('tasks.*', 'projects.slug as project_slug', 'projects.project_name as project_name', 'boards.slug as board_slug', 'boards.board_name as board_name', 'tasks.slug as task_slug')
                ->orderby('tasks.due_date', 'desc')
                ->limit(20)
                ->get();


        $reminderActivities = DB::table('reminders')
                ->join('tasks', 'tasks.id', '=', 'reminders.task_id')
                ->where('reminders.user_id', $user_id)
                ->where('reminders.status', 2)
                ->whereBetween('reminders.datetime', array($sdaDt, $stDt))
                ->select('reminders.*', 'tasks.task_name')
                ->orderby('reminders.datetime', 'desc')
                ->limit(4)
                ->get();
        
        
        
$dueTaskDataCalender = DB::table('tasks')
                ->join('boards', 'boards.id', '=', 'tasks.board_id')
                ->join('projects', 'projects.id', '=', 'boards.project_id')
                ->where('projects.user_id', $user_id)
                ->where('tasks.is_checked', 0)
                ->where('tasks.due_date', "!=" , '0000-00-00 00:00:00')
                ->whereNotNull('tasks.due_date')
                ->select('tasks.*', DB::raw('DATE(due_date) as dtt'), 'projects.slug as project_slug', 'projects.project_name as project_name', 'boards.slug as board_slug', 'boards.board_name as board_name')
                ->orderby('tasks.due_date', 'asc')
//                ->groupBy('dtt')
                ->get();
//
//echo "<pre>"; print_r($dueTaskDataCalender); exit;
        
        

//        echo "<pre>"; print_r($reminderActivities); exit;

        $this->layout->title = TITLE_FOR_PAGES . ' Dashboard';
        $this->layout->content = View::make('home.dashboard')
                ->with('jsonFinalArray', $jsonFinalArray)
                ->with('projectsTransactionCount', $projectsTransactionCount)
                ->with('projectsTransaction', $projectsTransaction)
                ->with('dueTaskData', $dueTaskData)
                ->with('upcomingTaskData', $upcomingTaskData)
                ->with('previousTaskData', $previousTaskData)
                ->with('reminderActivities', $reminderActivities)
                ->with('dueTaskDataCalender', $dueTaskDataCalender)
        ;

        // $this->layout->title = TITLE_FOR_PAGES . 'Account';
        // $this->layout->content = View::make('home.account');
    }

}