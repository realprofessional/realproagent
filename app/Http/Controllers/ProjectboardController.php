<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use App\Projectboard;
use App\AdminBoard;
use App\Board;
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
use Response;
use App\Classes\ImageManipulator;
use App\Classes\facebook\facebook;
use App\Classes\google\Google_Client;
use App\Classes\google\Google_Oauth2Service;
use Illuminate\Http\Request;

class ProjectboardController extends BaseController {
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

    protected $layout = 'layouts.default_front_project';
    
    
    
    public function sendSMSTwi($toNumber = null, $message = null) {
//        require('vendor/Twilio.php');
        $account_sid = SMS_ACCOUNT_SID;
        $auth_token = SMS_AUTH_TOKEN;
//        $client = new Services_Twilio($account_sid, $auth_token);

        $id = "$account_sid";
        $token = "$auth_token";
        $url = "https://api.twilio.com/2010-04-01/Accounts/$id/SMS/Messages.json";
        $fromNumber = "+18054158520";
//        $toNumber = $toNumber; // twilio trial verified number
//        $message = "This is a test. Time is " . date('h:i.s') . "";
        $data = array(
            'From' => $fromNumber,
            'To' => $toNumber,
            'Body' => $message,
        );

//        $client->account->messages->sendMessage('+12525721542', $toNumber, $message);


        $post = http_build_query($data);
        $x = curl_init($url);
        curl_setopt($x, CURLOPT_POST, true);
        curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($x, CURLOPT_USERPWD, "$id:$token");
        curl_setopt($x, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($x);
        curl_close($x);
        $explodeData = json_decode($result);
        
//        echo "<pre>"; print_r($explodeData); exit;
        if (isset($explodeData->status) && $explodeData->status == '400') {
            $errormsg = $explodeData->message; 
//            echo '{"message":"error","description":"' . $errormsg . '"}';
//            exit;
////        } else {
//            $client->account->messages->create(array(
//                'To' => "+91 9887506525",
//                'From' => "+15005550006",
//                'Body' => "Hey Anubhav! Good luck!!!",
//                    //'MediaUrl' => "http://shoppycart.com/raydaar/",
//            ));
//            // Display a confirmation message on the screen
//            echo "An SMS message was sent to $toNumber";
        }

        echo "1";
//        exit;
    }

    public function sendEmail($notiId) {

        $type = DB::table('notifications')
                        ->leftjoin('users', 'users.id', '=', 'notifications.user_id')
                        ->leftjoin('projects', 'projects.id', '=', 'notifications.project_id')
                        ->leftjoin('boards', 'boards.id', '=', 'notifications.board_id')
                        ->leftjoin('tasks', 'tasks.id', '=', 'notifications.task_id')
                        ->select('notifications.*', 'users.status as user_status', 'users.slug as user_slug', 'users.first_name as first_name', 'users.last_name as last_name', 'users.email_address as email_address', 'projects.slug as project_slug', 'projects.project_name as project_name', 'boards.slug as board_slug', 'boards.board_name as board_name', 'tasks.slug as task_slug', 'tasks.task_name as task_name')
                        ->where('notifications.id', $notiId)->first();

        switch ($type->type) {
            case "add_board":
                $url = "<a href=" . HTTP_PATH . "board/" . $type->project_slug . ">A Board <b>" . $type->board_name . "</b> has been added into project <b>" . $type->project_name . "</b>.</a>";
                break;
            case "delete_board":
                $url = "<a href=" . HTTP_PATH . "board/" . $type->project_slug . ">A Board has been deleted from project <b>" . $type->project_name . "</b>.</a>";
                break;
            case "add_task":
                $url = "<a href=" . HTTP_PATH . "board/" . $type->project_slug . ">A Task <b>" . $type->task_name . "</b> has been added under board <b>" . $type->board_name . "</b> to project <b>" . $type->project_name . "</b>.</a>";
                break;
            case "delete_task":
                $url = "<a href=" . HTTP_PATH . "board/" . $type->project_slug . ">A Task has been deleted under board <b>" . $type->board_name . "</b> from project <b>" . $type->project_name . "</b>.</a>";
                break;
            case "add_comment":
                $url = "<a href=" . HTTP_PATH . "board/" . $type->project_slug . "/" . $type->board_slug . "/" . $type->task_slug . ">A Comment has been added in Task <b>" . $type->task_name . "</b> under board <b>" . $type->board_name . "</b> to project <b>" . $type->project_name . "</b>.</a>";
                break;
            default:
                $url = "";
        }

        // send email to administrator
        $username = $type->first_name . " " . $type->last_name;
        $emailAddress = $type->email_address;
        $mail_data = array(
            'firstname' => $username,
            'email_addr' => $emailAddress,
            'text' => 'There is new notification on Real Pro Agent. Please check below information and visit Task Board.',
            'resetLink' => $url
        );

//        return View::make('emails.template')->with($mail_data);  exit;// to check mail template data to view
        Mail::send('emails.template', $mail_data, function($message) use ($mail_data) {
                    $message->setSender(array(MAIL_FROM => SITE_TITLE));
                    $message->setFrom(array(MAIL_FROM => SITE_TITLE));
                    $message->to($mail_data['email_addr'], '')->subject('New Notification from ' . SITE_TITLE);
                });
    }

    public function showproject($slug = null) {         //Project Listing in Front Panel
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
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

        $array_transaction = array();
        $array_boardd = array();

        $transactions = DB::table('transactions')
                ->where('status', 1)
                ->orderby('type', 'ASC')
                ->get();
        foreach ($transactions as $transaction) {
            $array_transaction[$transaction->id] = ucwords($transaction->type);
        }


        $preAddedBoardLists = DB::table('adminprojects')
                ->where('status', 1)
                ->orderby('project_name', 'DESC')
                ->get();
        $array_boardd[null] = "Select Project";
        foreach ($preAddedBoardLists as $preAddedBoardList) {
            $array_boardd[$preAddedBoardList->id] = $preAddedBoardList->project_name;
        }


        $invitedProjects = DB::table('projectinvites')
                ->join('projects', 'projects.id', '=', 'projectinvites.project_id')
                ->select('projectinvites.*', 'projects.project_name as project_name', 'projects.slug as project_slug')
                ->where('projectinvites.user_id', $user_id)
                ->groupBy('projectinvites.project_id', 'projectinvites.user_id')
                ->get();

        //dd($invitedProjects);

        if ($slug == 'buyer') {
            $projects = DB::table('projects')
                    ->where('user_id', $user_id)
                    ->where('status', 1)
                    ->where('transaction', 0)
                    ->orderby('id', 'desc')
                    ->paginate(20);
        } elseif ($slug == 'seller') {
            $projects = DB::table('projects')
                    ->where('user_id', $user_id)
                    ->where('status', 1)
                    ->where('transaction', 1)
                    ->orderby('id', 'desc')
                    ->paginate(20);
        } else {
            $projects = DB::table('projects')
                    ->where('user_id', $user_id)
                    ->where('status', 1)
                    ->orderby('id', 'desc')
                    ->paginate(20);
        }

        $this->layout->title = TITLE_FOR_PAGES . 'My Projects';
        $this->layout->content = View::make('Projectboard.board')->with('project', $projects)->with('array_boardd', $array_boardd)->with('invitedProjects', $invitedProjects)->with('transactionsArr', $array_transaction);
    }

    public function showaddproject() {      //Add Project in Front Panel
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $input = Input::all();
        if (!empty($input)) {
            // dd($input); exit;


            $rules = array(
                'project_name' => 'required', // make sure the first name field is not empty
                'admin_project_id' => 'required', // make sure the last name field is not empty
                'transaction' => 'required', // make sure the last name field is not empty
                'transaction_amount' => 'required', // make sure the last name field is not empty
                'transaction_type' => 'required', // make sure the last name field is not empty
                'start_date' => 'required', // make sure the last name field is not empty
                'end_date' => 'required', // make sure the last name field is not empty
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {
                return Redirect::to('/projectboard/projects')->withErrors($validator)->withInput(Input::all());
            } else {
                $slug = $this->createUniqueSlug($input['project_name'], 'projects');
                $saveUser = array(
                    'project_name' => $input['project_name'],
                    'admin_project_id' => $input['admin_project_id'],
                    'transaction' => $input['transaction'],
                    'transaction_amount' => $input['transaction_amount'],
                    'transaction_type' => $input['transaction_type'],
                    'start_date' => date("Y-m-d", strtotime($input['start_date'])),
                    'end_date' => date("Y-m-d", strtotime($input['end_date'])),
                    'user_id' => $user_id,
                    'status' => '1',
                    'slug' => $slug,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                );
                DB::table('projects')->insert(
                        $saveUser
                );

                $id = DB::getPdo()->lastInsertId();
                $projectId = $id;

                if ($input['additional']) {
                    foreach ($input['additional'] as $key => $value) {
                        $slug = $this->createUniqueSlug(time() . rand(9999, 99999), 'additionals');
                        $dataAdditional = array(
                            'project_id' => $projectId,
                            'key_data' => $key,
                            'value_data' => $value,
                            'slug' => $slug,
                            'created' => date('Y-m-d H:i:s'),
                        );

                        DB::table('additionals')->insert(
                                $dataAdditional
                        );
                    }
                }

                $saveListActivity = array(
                    'user_id' => $user_id,
                    'project_id' => $id,
                    'type' => 'create_project',
                    'message' => 'created this project',
                    'status' => '1',
                    'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                );

                DB::table('activities')->insert(
                        $saveListActivity
                );

                $projectInfo = DB::table('projects')
                                ->where('id', $id)->first();

                $preAddedProjectList = DB::table('adminprojects')
                        ->where('id', $input['admin_project_id'])
                        ->first();

                $preAddedBoardListsData = DB::table('adminboards')
                        ->where('project_id', $input['admin_project_id'])
                        ->get();

                //dd($preAddedBoardListsData); exit;

                if ($preAddedBoardListsData) {
                    foreach ($preAddedBoardListsData as $preAddedBoardLists) {
                        $adminBoardId = $preAddedBoardLists->id;

                        $preAddedBoardTaskLists = DB::table('admintasks')
                                ->where('board_id', $adminBoardId)
                                ->get();

                        $boardName = $preAddedBoardLists->board_name;
                        $slug = $slug = $this->createUniqueSlug($boardName, 'boards');


                        $toBeUpdateBoardIds = DB::select("SELECT GROUP_CONCAT(id) as board_ids from tbl_boards where project_id = $projectId order by board_position asc");
                        $idds = $toBeUpdateBoardIds[0]->board_ids;
                        if (!empty($idds)) {
                            DB::update('Update tbl_boards SET board_position = board_position + 1 where id IN ( ' . $idds . ' )');
                        }

                        $lastBoardId = 1;

                        $saveList = array(
                            'board_name' => $boardName,
                            'project_id' => $projectId,
                            'board_position' => $lastBoardId,
                            'status' => '1',
                            'slug' => $slug,
                            'created' => date('Y-m-d H:i:s'),
                            'modified' => date('Y-m-d H:i:s')
                        );

                        $boards = DB::table('boards')
                                ->insertGetId(
                                $saveList
                        );

                        $lastTaskId = 1;
                        if ($preAddedBoardTaskLists) {
                            foreach ($preAddedBoardTaskLists as $preAddedBoardTaskList) {
                                $taskName = $preAddedBoardTaskList->task_name;
                                $taskDesc = $preAddedBoardTaskList->task_description;
                                $taskDueDate = $preAddedBoardTaskList->due_date;
                                $slug = $this->createUniqueSlug($taskName, 'tasks');
                                $boardId = $boards;
                                $adminTaskId = $preAddedBoardTaskList->id;


                                $saveListTask = array(
                                    'task_name' => $taskName,
                                    'task_description' => $taskDesc,
                                    'due_date' => $taskDueDate,
                                    'board_id' => $boardId,
                                    'task_position' => $lastTaskId,
                                    'status' => '1',
                                    'slug' => $slug,
                                    'created' => date('Y-m-d H:i:s'),
                                    'modified' => date('Y-m-d H:i:s')
                                );

                                $tasks = DB::table('tasks')
                                        ->insertGetId(
                                        $saveListTask
                                );


                                $preAddedTaskCheckboxLists = DB::table('adminchecklists')
                                        ->where('task_id', $adminTaskId)
                                        ->get();

                                if ($preAddedTaskCheckboxLists) {
                                    foreach ($preAddedTaskCheckboxLists as $preAddedTaskCheckboxList) {
                                        $checkboxTitle = $preAddedTaskCheckboxList->checkbox_title;
                                        $adminChecklistId = $preAddedTaskCheckboxList->id;
                                        $slug = $this->createUniqueSlug($checkboxTitle, 'checklists');

                                        $saveList = array(
                                            'checkbox_title' => $checkboxTitle,
                                            'task_id' => $tasks,
                                            'board_id' => $boardId,
                                            'status' => '1',
                                            'slug' => $slug,
                                            'created' => date('Y-m-d H:i:s'),
                                            'modified' => date('Y-m-d H:i:s')
                                        );

                                        $checklists = DB::table('checklists')
                                                ->insertGetId(
                                                $saveList
                                        );

                                        $preAddedTaskCheckboxListValues = DB::table('adminchecklistvalues')
                                                ->where('checklist_id', $adminChecklistId)
                                                ->get();

                                        if ($preAddedTaskCheckboxListValues) {
                                            foreach ($preAddedTaskCheckboxListValues as $preAddedTaskCheckboxListValue) {
                                                $checkboxValue = $preAddedTaskCheckboxListValue->checkbox_value;
                                                $isChecked = $preAddedTaskCheckboxListValue->is_checked;
                                                $slug = $this->createUniqueSlug($checkboxValue, 'checklistvalues');


                                                $saveList = array(
                                                    'checkbox_value' => $checkboxValue,
                                                    'is_checked' => $isChecked,
                                                    'task_id' => $tasks,
                                                    'board_id' => $boardId,
                                                    'checklist_id' => $checklists,
                                                    'status' => '1',
                                                    'slug' => $slug,
                                                    'created' => date('Y-m-d H:i:s'),
                                                    'modified' => date('Y-m-d H:i:s')
                                                );

                                                $checklistvalues = DB::table('checklistvalues')
                                                        ->insertGetId(
                                                        $saveList
                                                );
                                            }
                                        }
                                    }
                                }
                                ++$lastTaskId;
                            }
                        }

                        $boardData = DB::table('boards')
                                ->where('id', $boards)
                                ->first();

                        $projectData = DB::table('projects')
                                ->where('id', $projectId)
                                ->first();

                        $allProjectLists = DB::table('projects')
                                ->where('status', 1)
                                ->where('user_id', $projectData->user_id)
                                ->orderby('id', 'DESC')
                                ->get();


                        $saveListActivity = array(
                            'user_id' => $projectData->user_id,
                            'project_id' => $projectId,
                            'board_id' => $boards,
                            'type' => 'create_board',
                            'message' => 'created board into project',
                            'status' => '1',
                            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
                            'created' => date('Y-m-d H:i:s'),
                            'modified' => date('Y-m-d H:i:s'),
                        );

                        DB::table('activities')->insert(
                                $saveListActivity
                        );
                    }
                }

                return Redirect::to('/board/' . $projectInfo->slug)->with('success_message', 'Project saved successfully.');
            }
        }
    }

    public function showAdmin_editproject($slug = null) {

        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }
        $user_id = Session::get('user_id');
        $input = Input::all();

        $users = DB::table('users')
                ->where('activation_status', 1)
                ->where('status', 1)
                ->orderby('first_name', 'ASC')
                ->get();
        foreach ($users as $user) {
            $array_user[$user->id] = ucwords($user->first_name) . ' ' . ucwords($user->last_name);
        }

        $project = DB::table('projects')
                        ->where('slug', $slug)->first();

        if (empty($project)) {
            return Redirect::to('/admin/user/userlist');
        }
        $project_id = $project->id;


        if (!empty($input)) {
            $rules = array(
                'project_name' => 'required', // make sure the first name field is not empty
                'user_id' => 'required', // make sure the last name field is not empty
            );


            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/admin/projects/Admin_editproject/' . $user->slug)
                                ->withErrors($validator) // send back all errors
                                ->withInput(Input::all());
            } else {
                $data = array(
                    'project_name' => $input['project_name'],
                    'user_id' => $input['user_id'],
                    'modified' => date('Y-m-d H:i:s'),
                );

                DB::table('projects')
                        ->where('id', $project_id)
                        ->update($data);

                return Redirect::to('/admin/projects/list')->with('success_message', 'Project details updated successfully.');
            }
        } else {

            return View::make('/Projects/admin_editproject')->with('detail', $project)->with('users', $array_user);
        }
    }

    public function showAdmin_activeproject($slug = null) {
        if (!empty($slug)) {
            DB::table('projects')
            ->where('slug', $slug)
            ->update(['status' => 1]);

            return Redirect::back()->with('success_message', 'Project deactivated successfully');
        }
    }

    public function showAdmin_deactiveproject($slug = null) {
        if (!empty($slug)) {
            DB::table('projects')
            ->where('slug', $slug)
            ->update(['status' => 0]);

            return Redirect::back()->with('success_message', 'Project deactivated successfully');
        }
    }

    public function showAdmin_deleteproject($slug = null) {
        if (!empty($slug)) {
            DB::table('projects')->where('slug', $slug)->delete();
            return Redirect::to('/admin/projects/list')->with('success_message', 'Project deleted successfully');
        }
    }

    public function boardlist($slug = null, $slug2 = null, $slug3 = null) {      //Board Listing inside Project Front Panel
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $project = DB::table('projects')
                        ->where('slug', $slug)->first();

        $projectUser = DB::table('users')
                        ->where('id', $project->user_id)->first();

        //dd($projectUser); exit;

        if (empty($project)) {
            return Redirect::to('/account');
        }
        $project_id = $project->id;


        $invitedProjectUsers = array();
        $inviteData = DB::table('projectinvites')
                ->where('project_id', $project_id)
                ->where('user_id', $user_id)
                ->first();

        //dd($inviteData); exit;

        $boardData = array();
        $taskDataArr = array();

        $array_transaction = array();

        $transactions = DB::table('transactions')
                ->where('status', 1)
                ->orderby('type', 'ASC')
                ->get();

        foreach ($transactions as $transaction) {
            $array_transaction[$transaction->id] = ucwords($transaction->type);
        }

        if (!empty($slug2)) {
            $boardData = DB::table('boards')
                    ->where('project_id', $project_id)
                    ->where('slug', $slug2)
                    ->first();
            //dd($boardData);
            if ($boardData) {
                $taskDataArr = DB::table('tasks')
                        ->where('board_id', $boardData->id)
                        ->get();
            } else {
                return Redirect::to('/account');
            }



            $invitedProjectUsers = DB::table('projectinvites')
                    ->join('users', 'users.id', '=', 'projectinvites.user_id')
                    ->where('project_id', $project_id)
                    ->where('board_id', $boardData->id)
                    ->where('user_id', "!=", $user_id)
                    ->get();

            $isInvited = DB::table('projectinvites')
                    ->join('users', 'users.id', '=', 'projectinvites.user_id')
                    ->where('project_id', $project_id)
                    ->where('board_id', $boardData->id)
                    ->where('user_id', $user_id)
                    ->first();

            // dd($isInvited); exit;

            if ($user_id == $project->user_id || !empty($isInvited)) {
                
            } else {
                return Redirect::to('/account');
            }



            //dd($invitedProjectUsers);
        }

        if ($user_id == $project->user_id || !empty($inviteData)) {
            
        } else {
            return Redirect::to('/account');
        }


        $preAddedBoardLists = DB::table('adminprojects')
                ->where('status', 1)
                ->orderby('project_name', 'DESC')
                ->get();
        $array_boardd[null] = "Select Project";
        foreach ($preAddedBoardLists as $preAddedBoardList) {
            $array_boardd[$preAddedBoardList->id] = $preAddedBoardList->project_name;
        }

        //dd($preAddedBoardLists); 

        $allProjectLists = DB::table('projects')
                ->where('status', 1)
                ->where('user_id', $project->user_id)
                ->orderby('id', 'DESC')
                ->get();
        $array_project[null] = "Select Project";
        foreach ($allProjectLists as $allProjectList) {
            $array_project[$allProjectList->id] = $allProjectList->project_name;
        }
        //print_r($array_project); exit;
        $input = Input::all();

        if (!empty($input)) {
            $saveProjectData = array(
                'project_name' => $input['project_name'],
                'transaction' => $input['transaction'],
                'transaction_amount' => $input['transaction_amount'],
                'transaction_type' => $input['transaction_type'],
                'start_date' => date("Y-m-d", strtotime($input['start_date'])),
                'end_date' => date("Y-m-d", strtotime($input['end_date'])),
                'modified' => date('Y-m-d H:i:s')
            );


            $adminTasks = DB::table('projects')
                    ->where('id', $project_id)
                    ->update($saveProjectData);

            if (!empty($input['additional'])) {
                //   dd($input['additional']);
                foreach ($input['additional'] as $kk => $vv) {
                    $varrr = DB::table('additionals')
                            ->where('project_id', $project_id)
                            ->where('key_data', $kk)
                            ->update(array('value_data' => $vv));
                }
            }

            return Redirect::to('/board/' . $project->slug)->with('success_message', 'project details updated successfully.');
        }

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


        $query = Board::sortable()
                ->where(function ($query) use ($search_keyword) {
                    $query->where('board_name', 'LIKE', '%' . $search_keyword . '%');
                });

        $query = $query->where('project_id', '=', $project_id);


        if ($user_id != $project->user_id && !empty($inviteData)) {
            $fetchBoardIdss = DB::table('projectinvites')
                    ->select('board_id')
                    ->where('project_id', $project_id)
                    ->where('user_id', $user_id)
                    ->get();
            $fetchBoardIds = json_decode(json_encode($fetchBoardIdss, true), true);
            $arrayData = array_map('current', $fetchBoardIds);
            $query = $query->whereIn('id', $arrayData);
        }



        if (!empty($input['from_date'])) {
            $query = $query->whereDate('created', '>=', date('Y-m-d H:i:s', strtotime($searchByDateFrom)));
        }

        if (!empty($input['to_date'])) {
            $query = $query->whereDate('created', '<=', date('Y-m-d H:i:s', strtotime($searchByDateTo)));
        }


        if (!empty($input['action'])) {
            $action = $input['action'];
            $idList = $input['chkRecordId'];
        }

//        $query->join('admintasks', 'boards.id', '=', 'admintasks.board_id')
//        ->select('boards.*','admintasks.task_name');

        $separator = implode("/", $separator);

        // Get all the users
        $boards = $query->orderBy('board_position', 'asc')->orderBy('id', 'desc')->sortable()->paginate(200);


//        $comments = Board::find(5)->admintasks;
        //echo "<pre>"; print_r($comments); exit;
        // Show the page


        return View::make('Boardsfront/index', compact('boards'))
                        ->with('search_keyword', $search_keyword)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('array_project', $array_project)
                        ->with('array_boardd', $array_boardd)
                        ->with('invitedProjectUsers', $invitedProjectUsers)
                        ->with('projectUser', $projectUser)
                        ->with('slug', $slug)
                        ->with('slug2', $slug2)
                        ->with('slug3', $slug3)
                        ->with('boardData', $boardData)
                        ->with('taskDataArr', $taskDataArr)
                        ->with('transactionsArr', $array_transaction)
                        ->with('project', $project);
    }

    public function viewDefaultBoards() {           //View Default Boards Front fro Grab
        $input = Input::all();
        if (!empty($input)) {
            $projectId = $input['project_id'];
            $adminProjectId = $input['admin_project_id'];

            $adminProjectDet = DB::table('adminprojects')
                    ->where('id', $adminProjectId)
                    ->first();

            $boardData = DB::table('adminboards')
                    ->where('project_id', $adminProjectId)
                    ->get();

            $projectData = DB::table('projects')
                    ->where('id', $projectId)
                    ->first();

            //dump($adminProjectDet); exit;

            if (!empty($adminProjectDet) && !empty($projectData)) {
                return View::make('Boardsfront.view_default_boards')->with('boards', $boardData)->with('project', $projectData)->render();
            } else {
                return Redirect::to('/projectboard/projects');
            }
        } else {
            return Redirect::to('/projectboard/projects');
        }
    }

    function grabAdminProjectBoard() {           //Grab Admin Boards Front fro Grab
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $input = Input::all();

        if (!empty($input)) {
            $adminBoardId = $input['board_id'];
            $projectId = $input['project_id'];
        } else {
            return Redirect::to('/projectboard/projects');
        }

        $preAddedBoardLists = DB::table('adminboards')
                ->where('id', $adminBoardId)
                ->first();

        $preAddedBoardTaskLists = DB::table('admintasks')
                ->where('board_id', $adminBoardId)
                ->get();

//        dd($preAddedBoardTaskLists); exit;

        $boardName = $preAddedBoardLists->board_name;
        $slug = $slug = $this->createUniqueSlug($boardName, 'boards');


        $toBeUpdateBoardIds = DB::select("SELECT GROUP_CONCAT(id) as board_ids from tbl_boards where project_id = $projectId order by board_position asc");
        $idds = $toBeUpdateBoardIds[0]->board_ids;
        if (!empty($idds)) {
            DB::update('Update tbl_boards SET board_position = board_position + 1 where id IN ( ' . $idds . ' )');
        }

        $lastBoardId = 1;

        $saveList = array(
            'board_name' => $boardName,
            'project_id' => $projectId,
            'board_position' => $lastBoardId,
            'status' => '1',
            'slug' => $slug,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        );

        $boards = DB::table('boards')
                ->insertGetId(
                $saveList
        );

        $lastTaskId = 1;
        if ($preAddedBoardTaskLists) {
            foreach ($preAddedBoardTaskLists as $preAddedBoardTaskList) {
                $taskName = $preAddedBoardTaskList->task_name;
                $taskDesc = $preAddedBoardTaskList->task_description;
                $taskDueDate = $preAddedBoardTaskList->due_date;
                $slug = $this->createUniqueSlug($taskName, 'tasks');
                $boardId = $boards;
                $adminTaskId = $preAddedBoardTaskList->id;


                $saveListTask = array(
                    'task_name' => $taskName,
                    'task_description' => $taskDesc,
                    'due_date' => $taskDueDate,
                    'board_id' => $boardId,
                    'task_position' => $lastTaskId,
                    'status' => '1',
                    'slug' => $slug,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s')
                );

                $tasks = DB::table('tasks')
                        ->insertGetId(
                        $saveListTask
                );


                $preAddedTaskCheckboxLists = DB::table('adminchecklists')
                        ->where('task_id', $adminTaskId)
                        ->get();

                if ($preAddedTaskCheckboxLists) {
                    foreach ($preAddedTaskCheckboxLists as $preAddedTaskCheckboxList) {
                        $checkboxTitle = $preAddedTaskCheckboxList->checkbox_title;
                        $adminChecklistId = $preAddedTaskCheckboxList->id;
                        $slug = $this->createUniqueSlug($checkboxTitle, 'checklists');

                        $saveList = array(
                            'checkbox_title' => $checkboxTitle,
                            'task_id' => $tasks,
                            'board_id' => $boardId,
                            'status' => '1',
                            'slug' => $slug,
                            'created' => date('Y-m-d H:i:s'),
                            'modified' => date('Y-m-d H:i:s')
                        );

                        $checklists = DB::table('checklists')
                                ->insertGetId(
                                $saveList
                        );

                        $preAddedTaskCheckboxListValues = DB::table('adminchecklistvalues')
                                ->where('checklist_id', $adminChecklistId)
                                ->get();

                        if ($preAddedTaskCheckboxListValues) {
                            foreach ($preAddedTaskCheckboxListValues as $preAddedTaskCheckboxListValue) {
                                $checkboxValue = $preAddedTaskCheckboxListValue->checkbox_value;
                                $isChecked = $preAddedTaskCheckboxListValue->is_checked;
                                $slug = $this->createUniqueSlug($checkboxValue, 'checklistvalues');


                                $saveList = array(
                                    'checkbox_value' => $checkboxValue,
                                    'is_checked' => $isChecked,
                                    'task_id' => $tasks,
                                    'board_id' => $boardId,
                                    'checklist_id' => $checklists,
                                    'status' => '1',
                                    'slug' => $slug,
                                    'created' => date('Y-m-d H:i:s'),
                                    'modified' => date('Y-m-d H:i:s')
                                );

                                $checklistvalues = DB::table('checklistvalues')
                                        ->insertGetId(
                                        $saveList
                                );
                            }
                        }
                    }
                }
                ++$lastTaskId;
            }
        }

        $boardData = DB::table('boards')
                ->where('id', $boards)
                ->first();

        $projectData = DB::table('projects')
                ->where('id', $projectId)
                ->first();

        $allProjectLists = DB::table('projects')
                ->where('status', 1)
                ->where('user_id', $projectData->user_id)
                ->orderby('id', 'DESC')
                ->get();


        $saveListActivity = array(
            'user_id' => $projectData->user_id,
            'project_id' => $projectId,
            'board_id' => $boards,
            'type' => 'create_board',
            'message' => 'created board into project',
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );

        $array_project[null] = "Select Project";
        foreach ($allProjectLists as $allProjectList) {
            $array_project[$allProjectList->id] = $allProjectList->project_name;
        }

        return Redirect::to('/board/' . $projectData->slug);

        //return View::make('Boardsfront.ajax_update_add_board')->with('board', $boardData)->with('project', $projectData)->with('array_project', $array_project)->render();
        //echo '1';
        //exit;
    }

    function saveAdminProjectBoard() {      //Add Admin Project Boards Front Panel
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $input = Input::all();

        if (!empty($input)) {
            $boardName = $input['board_name'];
            $projectId = $input['project_id'];
            $slug = $this->createUniqueSlug($boardName, 'boards');
        }

//        $lastBoardDetail = DB::table('boards')
//                ->where('boards.project_id', $projectId)
//                ->orderBy('boards.id', 'desc')
//                ->first();
//        if (empty($lastBoardDetail)) {
//            $lastBoardId = 1;
//        } else {
//            $lastBoardId = $lastBoardDetail->board_position + 1;
//        }


        $toBeUpdateBoardIds = DB::select("SELECT GROUP_CONCAT(id) as board_ids from tbl_boards where project_id = $projectId order by board_position asc");
        $idds = $toBeUpdateBoardIds[0]->board_ids;
        if (!empty($idds)) {
            DB::update('Update tbl_boards SET board_position = board_position + 1 where id IN ( ' . $idds . ' )');
        }

        $lastBoardId = 1;

        $saveList = array(
            'board_name' => $boardName,
            'project_id' => $projectId,
            'board_position' => $lastBoardId,
            'status' => '1',
            'slug' => $slug,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        );

        $boards = DB::table('boards')
                ->insertGetId(
                $saveList
        );

        $boardData = DB::table('boards')
                ->where('id', $boards)
                ->first();

        $projectData = DB::table('projects')
                ->where('id', $projectId)
                ->first();

        $allProjectLists = DB::table('projects')
                ->where('status', 1)
                ->where('user_id', $projectData->user_id)
                ->orderby('id', 'DESC')
                ->get();



        $saveListActivity = array(
            'user_id' => $projectData->user_id,
            'project_id' => $projectId,
            'board_id' => $boards,
            'type' => 'create_board',
            'message' => 'created board into project',
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );


        $invitedProjectUsers = DB::table('projectinvites')
                ->join('users', 'users.id', '=', 'projectinvites.user_id')
                ->where('project_id', $projectId)
                ->select('users.*')
                ->get();

        $newKey = sizeof($invitedProjectUsers);

        $userssInfoo = DB::table('users')
                ->where('id', $projectData->user_id)
                ->first();

        $invitedProjectUsers[$newKey] = $userssInfoo;


//        if ($invitedProjectUsers) {
//            foreach ($invitedProjectUsers as $userssInfo) {
//                if ($userssInfo->turn_off_notification == 0) {
//                    $saveListNotification = array(
//                        'user_id' => $userssInfo->id,
//                        'project_id' => $projectId,
//                        'board_id' => $boards,
//                        'type' => 'add_board',
//                        'status' => '1',
//                        'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
//                        'created' => date('Y-m-d H:i:s'),
//                        'modified' => date('Y-m-d H:i:s'),
//                    );
//
//
//                    $notiId = DB::table('notifications')->insertGetId(
//                            $saveListNotification
//                    );
//
//                    $this->sendEmail($notiId);
//                }
//            }
//        }




        $array_project[null] = "Select Project";
        foreach ($allProjectLists as $allProjectList) {
            $array_project[$allProjectList->id] = $allProjectList->project_name;
        }


        return View::make('Boardsfront.ajax_update_add_board')->with('board', $boardData)->with('project', $projectData)->with('array_project', $array_project)->render();
        //echo '1';
        exit;
    }

    function saveAdminProjectTask() {       //Add  Project -> Boards -> Task Front Panel
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();
        if (!empty($input)) {
            $taskName = $input['task_name'];
            $slug = $this->createUniqueSlug($taskName, 'tasks');
            $boardId = $input['board_id'];
        } else {
            return Redirect::to('/');
        }


        $lastTaskDetail = DB::table('tasks')
                ->where('tasks.board_id', $boardId)
                ->orderBy('tasks.id', 'desc')
                ->first();

        if (empty($lastTaskDetail)) {
            $lastTaskId = 1;
        } else {
            $lastTaskId = $lastTaskDetail->task_position + 1;
        }


        $saveList = array(
            'task_name' => $taskName,
            'board_id' => $boardId,
            'task_position' => $lastTaskId,
            'status' => '1',
            'slug' => $slug,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        );

        $tasks = DB::table('tasks')
                ->insertGetId(
                $saveList
        );

        $boardData = DB::table('boards')
                ->join('projects', 'projects.id', '=', 'boards.project_id')
                ->select('boards.*', 'projects.user_id as user_id')
                ->where('boards.id', $boardId)
                ->first();


        $saveListActivity = array(
            'user_id' => $boardData->user_id,
            'project_id' => $boardData->project_id,
            'board_id' => $boardData->id,
            'task_id' => $tasks,
            'type' => 'create_task',
            'message' => 'created task into board',
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );



        $invitedProjectUsers = DB::table('projectinvites')
                ->join('users', 'users.id', '=', 'projectinvites.user_id')
                ->where('project_id', $boardData->project_id)
                ->where('board_id', $boardData->id)
                ->select('users.*')
                ->get();

        $newKey = sizeof($invitedProjectUsers);

        $userssInfoo = DB::table('users')
                ->where('id', $boardData->user_id)
                ->first();

        $invitedProjectUsers[$newKey] = $userssInfoo;


        if ($invitedProjectUsers) {
            foreach ($invitedProjectUsers as $userssInfo) {


                if ($userssInfo->turn_off_notification == 0) {

                    $saveListNotification = array(
                        'user_id' => $userssInfo->id,
                        'project_id' => $boardData->project_id,
                        'board_id' => $boardData->id,
                        'task_id' => $tasks,
                        'type' => 'add_task',
                        'status' => '1',
                        'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
                        'created' => date('Y-m-d H:i:s'),
                        'modified' => date('Y-m-d H:i:s'),
                    );

                    $notiId = DB::table('notifications')->insertGetId(
                            $saveListNotification
                    );

                    $this->sendEmail($notiId);
                }
            }
        }



        $allProjectLists = DB::table('projects')
                ->where('status', 1)
                ->where('user_id', $boardData->user_id)
                ->orderby('id', 'DESC')
                ->get();
        $array_project[null] = "Select Project";
        foreach ($allProjectLists as $allProjectList) {
            $array_project[$allProjectList->id] = $allProjectList->project_name;
        }

        $project = DB::table('projects')
                        ->where('id', $boardData->project_id)->first();

        return View::make('Boardsfront.ajax_add_task')->with('tasks', $tasks)->with('board', $boardData)->with('array_project', $array_project)->with('project', $project)->render();
        exit;
    }

    function updateAdminProjectTask() {         //Update  Project -> Boards -> Task Front Panel
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();
        if (!empty($input)) {
            $taskName = $input['task_name'];
            $boardId = $input['board_id'];
            $taskId = $input['id'];
        } else {
            return Redirect::to('/');
        }

        if (empty($taskId)) {
            echo '2';
            exit;
        }

        $saveList = array(
            'task_name' => $taskName,
            'modified' => date('Y-m-d H:i:s')
        );


        $boards = DB::table('tasks')
                ->where('id', $taskId)
                ->update($saveList);

        echo 1;
        exit;
    }

    function updateAdminProjectBoard() {        //Update  Project -> Boards Front Panel
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();
        if (!empty($input)) {
            $boardName = $input['board_name'];
            $boardId = $input['id'];
        } else {
            return Redirect::to('/');
        }

        if (empty($boardId)) {
            echo '2';
            exit;
        }

        $saveList = array(
            'board_name' => $boardName,
            'modified' => date('Y-m-d H:i:s')
        );


        $adminTasks = DB::table('boards')
                ->where('id', $boardId)
                ->update($saveList);

        echo 1;
        exit;
    }

    function deleteAdminProjectTask() {     // Delete Project -> Boards -> Task Front Panel
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();
        if (!empty($input)) {
            $taskId = $input['id'];
            $taskSlug = $input['slug'];
        } else {
            return Redirect::to('/');
        }

        if (empty($taskId) || empty($taskSlug)) {
            echo '2';
            exit;
        }


        $mainTaskDetail = DB::table('tasks')
                ->where('tasks.id', $taskId)
                ->first();

        $boardId = $mainTaskDetail->board_id;

        $lastTaskDetail = DB::table('tasks')
                ->where('tasks.board_id', $boardId)
                ->orderBy('tasks.task_position', 'desc')
                ->first();


        if ($mainTaskDetail->task_position < $lastTaskDetail->task_position) {
            $toBeUpdateTaskIds = DB::select("SELECT GROUP_CONCAT(id) as task_ids from tbl_tasks where task_position > $mainTaskDetail->task_position AND board_id = $boardId order by task_position asc");

            $idds = $toBeUpdateTaskIds[0]->task_ids;

            DB::update('Update tbl_tasks SET task_position = task_position - 1 where id IN ( ' . $idds . ' )');
        }

        DB::table('tasks')->where('id', $taskId)->delete();


        $boardProjectDetail = DB::table('boards')
                ->join('projects', 'projects.id', '=', 'boards.project_id')
                ->select('boards.*', 'projects.user_id as user_id')
                ->where('boards.id', $boardId)
                ->first();


        $saveListActivity = array(
            'user_id' => $boardProjectDetail->user_id,
            'project_id' => $boardProjectDetail->project_id,
            'board_id' => $boardProjectDetail->id,
            'type' => 'delete_task',
            'message' => $mainTaskDetail->task_name,
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );




        $invitedProjectUsers = DB::table('projectinvites')
                ->join('users', 'users.id', '=', 'projectinvites.user_id')
                ->where('project_id', $boardProjectDetail->project_id)
                ->where('board_id', $boardProjectDetail->id)
                ->select('users.*')
                ->get();

        $newKey = sizeof($invitedProjectUsers);

        $userssInfoo = DB::table('users')
                ->where('id', $boardProjectDetail->user_id)
                ->first();

        $invitedProjectUsers[$newKey] = $userssInfoo;


        if ($invitedProjectUsers) {
            foreach ($invitedProjectUsers as $userssInfo) {

                if ($userssInfo->turn_off_notification == 0) {

                    $saveListNotification = array(
                        'user_id' => $userssInfo->id,
                        'project_id' => $boardProjectDetail->project_id,
                        'board_id' => $boardProjectDetail->id,
                        'type' => 'delete_task',
                        'status' => '1',
                        'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
                        'created' => date('Y-m-d H:i:s'),
                        'modified' => date('Y-m-d H:i:s'),
                    );

                    $notiId = DB::table('notifications')->insertGetId(
                            $saveListNotification
                    );

                    $this->sendEmail($notiId);
                }
            }
        }

        echo 1;
        exit;
    }

    function deleteAdminProjectBoard() {    //Delete Project -> Boards Front Panel
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $boardId = 0;

        $input = Input::all();
        if (!empty($input)) {
            $boardId = $input['id'];
            $boardSlug = $input['slug'];
        } else {
            return Redirect::to('/');
        }

        if (empty($boardId) || empty($boardSlug)) {
            echo '2';
            exit;
        }

        $mainBoardDetail = DB::table('boards')
                ->where('boards.id', $boardId)
                ->first();

        $projectId = $mainBoardDetail->project_id;

        $lastBoardDetail = DB::table('boards')
                ->where('boards.project_id', $projectId)
                ->orderBy('boards.board_position', 'desc')
                ->first();


        if ($mainBoardDetail->board_position < $lastBoardDetail->board_position) {
            $toBeUpdateBoardIds = DB::select("SELECT GROUP_CONCAT(id) as board_ids from tbl_boards where board_position > $mainBoardDetail->board_position AND project_id = $projectId order by board_position asc");

            $iddss = $toBeUpdateBoardIds[0]->board_ids;

            DB::update('Update tbl_boards SET board_position = board_position - 1 where id IN ( ' . $iddss . ' )');
        }


        DB::table('boards')->where('id', $boardId)->delete();
        DB::table('tasks')->where('board_id', $boardId)->delete();


        $boardProjectDetail = DB::table('projects')
                ->where('projects.id', $projectId)
                ->first();

        $saveListActivity = array(
            'user_id' => $boardProjectDetail->user_id,
            'project_id' => $projectId,
            'type' => 'delete_board',
            'message' => $mainBoardDetail->board_name,
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );


        $invitedProjectUsers = DB::table('projectinvites')
                ->join('users', 'users.id', '=', 'projectinvites.user_id')
                ->where('project_id', $boardProjectDetail->id)
                ->select('users.*')
                ->get();

        $newKey = sizeof($invitedProjectUsers);

        $userssInfoo = DB::table('users')
                ->where('id', $boardProjectDetail->user_id)
                ->first();

        $invitedProjectUsers[$newKey] = $userssInfoo;


//        if ($invitedProjectUsers) {
//            foreach ($invitedProjectUsers as $userssInfo) {
//
//
//
//                if ($userssInfo->turn_off_notification == 0) {
//
//                    $saveListNotifications = array(
//                        'user_id' => $boardProjectDetail->user_id,
//                        'project_id' => $projectId,
//                        'type' => 'delete_board',
//                        'status' => '1',
//                        'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
//                        'created' => date('Y-m-d H:i:s'),
//                        'modified' => date('Y-m-d H:i:s'),
//                    );
//
//
//
//
//                    $notiId = DB::table('notifications')->insertGetId(
//                            $saveListNotifications
//                    );
//
//                    $this->sendEmail($notiId);
//                }
//            }
//        }

        echo 1;
        exit;
    }

    function displayProjectTaskSection($slug = null) {  //Display Project Board task in Front Panel Pop Up
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');
        $input = Input::all();

        $taskDetail = DB::table('tasks')
                        ->join('boards', 'boards.id', '=', 'tasks.board_id')
                        ->join('projects', 'projects.id', '=', 'boards.project_id')
                        ->select('tasks.*', 'boards.board_name as board_name', 'boards.slug as board_slug', 'boards.status as board_status', 'boards.board_position as board_position', 'projects.id as project_id', 'projects.user_id as project_user_id', 'projects.project_name as project_name', 'projects.slug as project_slug', 'projects.status as project_status')
                        ->where('tasks.slug', $slug)->first();

        if (empty($taskDetail)) {
            
        }
        $task_id = $taskDetail->id;

        if (!empty($input)) {
            $rules = array(
                'project_name' => 'required', // make sure the first name field is not empty
                'user_id' => 'required', // make sure the last name field is not empty
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/admin/projects/Admin_editproject/' . $user->slug)
                                ->withErrors($validator) // send back all errors
                                ->withInput(Input::all());
            } else {


                $data = array(
                    'project_name' => $input['project_name'],
                    'user_id' => $input['user_id'],
                    'modified' => date('Y-m-d H:i:s'),
                );


                DB::table('projects')
                        ->where('id', $project_id)
                        ->update($data);

                return Redirect::to('/admin/projects/list')->with('success_message', 'Project details updated successfully.');
            }
        } else {
            return View::make('/Boardsfront/displayProjectTaskSection')->with('taskDetail', $taskDetail);
        }
    }

    function updateAdminTaskDescriptionData() {     //Update  Project -> Boards -> Task -> Description Data Front Panel
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();
        if (!empty($input)) {
            $taskDesc = $input['task_description'];
            $taskId = $input['task_id'];
        } else {
            return Redirect::to('/');
        }

        if (empty($taskId)) {
            echo '2';
            exit;
        }

        $saveList = array(
            'task_description' => $taskDesc,
            'modified' => date('Y-m-d H:i:s')
        );


        $boards = DB::table('tasks')
                ->where('id', $taskId)
                ->update($saveList);

        echo 1;
        exit;
    }

    function copyAdminProjectTask() {       //Copy Project -> Boards -> Task -> Description Data Front Panel
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();
        if (!empty($input)) {
            $oldTaskId = $input['old_task_id'];
            $oldBoardId = $input['old_board_id'];
            $oldTaskName = $input['old_task_name'];
            $oldProjectId = $input['old_project_id'];
            $userId = $input['user_id'];
            $slug = $this->createUniqueSlug($oldTaskName, 'tasks');
            $boardId = $input['board_id'];
            $position = $input['position'];
        } else {
            return Redirect::to('/');
        }


        $lastTaskDetail = DB::table('tasks')
                ->where('tasks.board_id', $boardId)
                ->orderBy('tasks.task_position', 'desc')
                ->first();

        if (empty($lastTaskDetail)) {
            $lastTaskId = 1;
        } else {
            if ($lastTaskDetail->task_position >= $position) {
                $toBeUpdateTaskIds = DB::select("SELECT GROUP_CONCAT(id) as task_ids from tbl_tasks where task_position >= $position AND board_id = $boardId order by task_position asc");

                $idds = $toBeUpdateTaskIds[0]->task_ids;

                DB::update('Update tbl_tasks SET task_position = task_position + 1 where id IN ( ' . $idds . ' )');
                $lastTaskId = $position;
            } else {
                $lastTaskId = $position;
            }
        }


        $newSaveList = array(
            'task_name' => $oldTaskName,
            'board_id' => $boardId,
            'task_position' => $lastTaskId,
            'status' => '1',
            'slug' => $slug,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        );

        $tasks = DB::table('tasks')
                ->insertGetId(
                $newSaveList
        );


        $boardData = DB::table('boards')
                ->where('id', $input['board_id'])
                ->first();

        $allProjectLists = DB::table('projects')
                ->where('status', 1)
                ->where('user_id', $userId)
                ->orderby('id', 'DESC')
                ->get();
        $array_project[null] = "Select Project";
        foreach ($allProjectLists as $allProjectList) {
            $array_project[$allProjectList->id] = $allProjectList->project_name;
        }


        $boardProjectDetail = DB::table('projects')
                ->where('projects.id', $boardData->project_id)
                ->first();

        $saveListActivity = array(
            'user_id' => $boardProjectDetail->user_id,
            'project_id' => $boardData->project_id,
            'board_id' => $boardData->id,
            'task_id' => $oldTaskId,
            'new_task_id' => $tasks,
            'type' => 'copy_task',
            'message' => 'board copied',
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );

        return View::make('Boardsfront.ajax_update_copied_board')->with('board', $boardData)->with('project', $boardProjectDetail)->with('array_project', $array_project)->render();
        exit;
    }

    function getAdminUserProjects() {       //get Project for User for select options
        $input = Input::all();
        if (!empty($input)) {
            $id = $input['id'];
            $task_id = $input['task_id'];
        }

        $allProjectBoardLists = DB::table('boards')
                ->where('status', 1)
                ->where('project_id', $id)
                ->orderby('board_name', 'ASC')
                ->get();
        $array_board[null] = "Select Board";
        foreach ($allProjectBoardLists as $allProjectBoardList) {
            $array_board[$allProjectBoardList->id] = $allProjectBoardList->board_name;
        }

        return View::make('Boardsfront.ajax_get_board')->with('array_board', $array_board)->with('task_id', $task_id)->render();
    }

    function getAdminUserTaskPosition() {       //get Task Positions inside board for select options
        $input = Input::all();
        if (!empty($input)) {
            $id = $input['id'];
            $task_id = $input['task_id'];
        }

        $allProjectBoardLists = DB::table('tasks')
                ->where('status', 1)
                ->where('board_id', $id)
                ->orderby('task_position', 'ASC')
                ->get();
        $array_position[null] = "Select Position";
        $i = 1;
        foreach ($allProjectBoardLists as $allProjectBoardList) {
            $array_position[$allProjectBoardList->task_position] = $allProjectBoardList->task_position;
            $i++;
        }
        $array_position[$i] = $i;

        return View::make('Boardsfront.ajax_get_position')->with('array_position', $array_position)->with('task_id', $task_id)->render();
    }

    function moveAdminProjectTask() {    //move Project task 
        if (!Session::has('user_id')) {
            echo "error";
            exit;
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();

        //dd($input);exit;

        if (!empty($input)) {
            $oldTaskId = $input['old_task_id'];
            $oldBoardId = $input['old_board_id'];
            $oldTaskName = $input['old_task_name'];
            $oldPosition = $input['old_position'];
            $oldProjectId = $input['old_project_id'];
            $userId = $input['user_id'];
            //$slug = $this->createUniqueSlug($oldTaskName, 'tasks');
            $boardId = $input['board_id'];
            $position = $input['position'];
        } else {
            echo "error";
            exit;
        }


        //for the board from which task will be moved
        $lastTaskDetailNew = DB::table('tasks')
                ->where('tasks.board_id', $oldBoardId)
                ->orderBy('tasks.task_position', 'desc')
                ->first();

        if (empty($lastTaskDetailNew)) {
            $lastTaskIdNew = 1;
        } else {
            if ($lastTaskDetailNew->task_position >= $oldPosition) {
                $toBeUpdateTaskIdsNew = DB::select("SELECT GROUP_CONCAT(id) as task_ids from tbl_tasks where task_position >= $oldPosition AND board_id = $oldBoardId order by task_position asc");

                $idds = $toBeUpdateTaskIdsNew[0]->task_ids;

                DB::update('Update tbl_tasks SET task_position = task_position - 1 where id IN ( ' . $idds . ' )');
                $lastTaskIdNew = $oldPosition;
            } else {
                $lastTaskIdNew = $oldPosition;
            }
        }


        //for the board in which task will be moved
        $lastTaskDetail = DB::table('tasks')
                ->where('tasks.board_id', $boardId)
                ->orderBy('tasks.task_position', 'desc')
                ->first();

        if (empty($lastTaskDetail)) {
            $lastTaskId = 1;
        } else {
            if ($lastTaskDetail->task_position >= $position) {
                if ($oldBoardId == $boardId) {
                    $toBeUpdateTaskIds = DB::select("SELECT GROUP_CONCAT(id) as task_ids from tbl_tasks where task_position > $position AND board_id = $boardId order by task_position asc");
                } else {
                    $toBeUpdateTaskIds = DB::select("SELECT GROUP_CONCAT(id) as task_ids from tbl_tasks where task_position >= $position AND board_id = $boardId order by task_position asc");
                }

                //$toBeUpdateTaskIds = DB::select("SELECT GROUP_CONCAT(id) as task_ids from tbl_tasks where task_position >= $position AND board_id = $boardId order by task_position asc");

                $iddsNew = $toBeUpdateTaskIds[0]->task_ids;

                DB::update('Update tbl_tasks SET task_position = task_position + 1 where id IN ( ' . $iddsNew . ' )');
                $lastTaskId = $position;
            } else {
                $lastTaskId = $position;
            }
        }




        $dataa = array(
            'board_id' => $boardId,
            'task_position' => $lastTaskId,
            'modified' => date('Y-m-d H:i:s'),
        );


        DB::table('tasks')
                ->where('id', $oldTaskId)
                ->update($dataa);




        $boardData = DB::table('boards')
                ->where('id', $input['board_id'])
                ->first();

        $allProjectLists = DB::table('projects')
                ->where('status', 1)
                ->where('user_id', $userId)
                ->orderby('id', 'DESC')
                ->get();
        $array_project[null] = "Select Project";
        foreach ($allProjectLists as $allProjectList) {
            $array_project[$allProjectList->id] = $allProjectList->project_name;
        }


        $boardProjectDetail = DB::table('projects')
                ->where('projects.id', $boardData->project_id)
                ->first();

        $saveListActivity = array(
            'user_id' => $boardProjectDetail->user_id,
            'project_id' => $boardData->project_id,
            'board_id' => $boardData->id,
            'task_id' => $oldTaskId,
            'new_task_id' => $oldTaskId,
            'type' => 'move_task',
            'message' => 'board copied',
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );



        return View::make('Boardsfront.ajax_update_copied_board')->with('board', $boardData)->with('project', $boardProjectDetail)->with('array_project', $array_project)->render();
        exit;
    }

    function getAdminUserMoveProjects() {
        $input = Input::all();
        if (!empty($input)) {
            $id = $input['id'];
            $task_id = $input['task_id'];
        }

        $allProjectBoardLists = DB::table('boards')
                ->where('status', 1)
                ->where('project_id', $id)
                ->orderby('board_name', 'ASC')
                ->get();
        $array_board[null] = "Select Board";
        foreach ($allProjectBoardLists as $allProjectBoardList) {
            $array_board[$allProjectBoardList->id] = $allProjectBoardList->board_name;
        }

        return View::make('Boardsfront.ajax_get_board_for_move')->with('array_board', $array_board)->with('task_id', $task_id)->render();
    }

    function getAdminUserMoveTaskPosition() {
        $input = Input::all();
        if (!empty($input)) {
            $id = $input['id'];
            $task_id = $input['task_id'];
        }

        $allProjectBoardLists = DB::table('tasks')
                ->where('status', 1)
                ->where('board_id', $id)
                ->orderby('task_position', 'ASC')
                ->get();
        $array_position[null] = "Select Position";
        $i = 1;
        foreach ($allProjectBoardLists as $allProjectBoardList) {
            $array_position[$allProjectBoardList->task_position] = $allProjectBoardList->task_position;
            $i++;
        }
        $array_position[$i] = $i;

        return View::make('Boardsfront.ajax_get_position_for_move')->with('array_position', $array_position)->with('task_id', $task_id)->render();
    }

    function copyAdminProjectBoard() {      //Copy Project Board
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();
        if (!empty($input)) {
            $oldBoardId = $input['old_board_id'];
            $oldProjectId = $input['old_project_id'];
            $userId = $input['user_id'];
            $boardTitle = $input['new_board_title'];
            $slug = $this->createUniqueSlug($boardTitle, 'boards');
            $projectId = $input['project_id'];
            $position = $input['position'];
        } else {
            return Redirect::to('/');
        }




        $lastBoardDetail = DB::table('boards')
                ->where('boards.project_id', $projectId)
                ->orderBy('boards.board_position', 'desc')
                ->first();

        if (empty($lastBoardDetail)) {
            $lastBoardId = 1;
        } else {
            if ($lastBoardDetail->board_position >= $position) {
                $toBeUpdateBoardIds = DB::select("SELECT GROUP_CONCAT(id) as task_ids from tbl_boards where board_position >= $position AND project_id = $projectId order by board_position asc");
                $idds = $toBeUpdateBoardIds[0]->task_ids;
                DB::update('Update tbl_boards SET board_position = board_position + 1 where id IN ( ' . $idds . ' )');
                $lastBoardId = $position;
            } else {
                $lastBoardId = $position;
            }
        }

        $newSaveList = array(
            'board_name' => $boardTitle,
            'project_id' => $projectId,
            'board_position' => $lastBoardId,
            'status' => '1',
            'slug' => $slug,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        );

        $boards = DB::table('boards')
                ->insertGetId(
                $newSaveList
        );


        $preAddedBoardTaskLists = DB::table('tasks')
                ->where('board_id', $oldBoardId)
                ->get();


        $lastTaskId = 1;
        if ($preAddedBoardTaskLists) {
            foreach ($preAddedBoardTaskLists as $preAddedBoardTaskList) {
                $taskName = $preAddedBoardTaskList->task_name;
                $taskDesc = $preAddedBoardTaskList->task_description;
                $taskDueDate = $preAddedBoardTaskList->due_date;
                $slug = $this->createUniqueSlug($taskName, 'tasks');
                $boardId = $boards;
                $adminTaskId = $preAddedBoardTaskList->id;


                $saveListTask = array(
                    'task_name' => $taskName,
                    'task_description' => $taskDesc,
                    'due_date' => $taskDueDate,
                    'board_id' => $boardId,
                    'task_position' => $lastTaskId,
                    'status' => '1',
                    'slug' => $slug,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s')
                );

                $tasks = DB::table('tasks')
                        ->insertGetId(
                        $saveListTask
                );


                $preAddedTaskCheckboxLists = DB::table('checklists')
                        ->where('task_id', $adminTaskId)
                        ->get();

                if ($preAddedTaskCheckboxLists) {
                    foreach ($preAddedTaskCheckboxLists as $preAddedTaskCheckboxList) {
                        $checkboxTitle = $preAddedTaskCheckboxList->checkbox_title;
                        $adminChecklistId = $preAddedTaskCheckboxList->id;
                        $slug = $this->createUniqueSlug($checkboxTitle, 'checklists');

                        $saveList = array(
                            'checkbox_title' => $checkboxTitle,
                            'task_id' => $tasks,
                            'board_id' => $boardId,
                            'status' => '1',
                            'slug' => $slug,
                            'created' => date('Y-m-d H:i:s'),
                            'modified' => date('Y-m-d H:i:s')
                        );

                        $checklists = DB::table('checklists')
                                ->insertGetId(
                                $saveList
                        );

                        $preAddedTaskCheckboxListValues = DB::table('checklistvalues')
                                ->where('checklist_id', $adminChecklistId)
                                ->get();

                        if ($preAddedTaskCheckboxListValues) {
                            foreach ($preAddedTaskCheckboxListValues as $preAddedTaskCheckboxListValue) {
                                $checkboxValue = $preAddedTaskCheckboxListValue->checkbox_value;
                                $isChecked = $preAddedTaskCheckboxListValue->is_checked;
                                $slug = $this->createUniqueSlug($checkboxValue, 'checklistvalues');


                                $saveList = array(
                                    'checkbox_value' => $checkboxValue,
                                    'is_checked' => $isChecked,
                                    'task_id' => $tasks,
                                    'board_id' => $boardId,
                                    'checklist_id' => $checklists,
                                    'status' => '1',
                                    'slug' => $slug,
                                    'created' => date('Y-m-d H:i:s'),
                                    'modified' => date('Y-m-d H:i:s')
                                );

                                $checklistvalues = DB::table('checklistvalues')
                                        ->insertGetId(
                                        $saveList
                                );
                            }
                        }
                    }
                }
                ++$lastTaskId;
            }
        }



        $boardData = DB::table('boards')
                ->where('id', $boards)
                ->first();

        $allProjectLists = DB::table('projects')
                ->where('status', 1)
                ->where('user_id', $userId)
                ->orderby('id', 'DESC')
                ->get();
        $array_project[null] = "Select Project";
        foreach ($allProjectLists as $allProjectList) {
            $array_project[$allProjectList->id] = $allProjectList->project_name;
        }


        $boardProjectDetail = DB::table('projects')
                ->where('projects.id', $boardData->project_id)
                ->first();

        $saveListActivity = array(
            'user_id' => $boardProjectDetail->user_id,
            'project_id' => $boardData->project_id,
            'board_id' => $oldBoardId,
            'new_board_id' => $boards,
            'type' => 'copy_board',
            'message' => $boardTitle,
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );

        return View::make('Boardsfront.ajax_update_add_board')->with('board', $boardData)->with('project', $boardProjectDetail)->with('array_project', $array_project)->render();
        exit;
    }

    function getAdminUserMoveBoardPositionForCopy() {
        $input = Input::all();
        if (!empty($input)) {
            $id = $input['id'];
            $board_id = $input['board_id'];
        }

        $allProjectBoardLists = DB::table('boards')
                ->where('status', 1)
                ->where('project_id', $id)
                ->orderby('board_position', 'ASC')
                ->get();
        $array_position[null] = "Select Position";
        $i = 1;
        foreach ($allProjectBoardLists as $allProjectBoardList) {
            $array_position[$allProjectBoardList->board_position] = $allProjectBoardList->board_position;
            $i++;
        }
        $array_position[$i] = $i;
        //dd($array_position);

        return View::make('Boardsfront.ajax_get_position_for_copy_board')->with('array_position', $array_position)->with('board_id', $board_id)->render();
    }

    function getAdminUserMoveBoardPositionForMove() {
        $input = Input::all();
        if (!empty($input)) {
            $id = $input['id'];
            $board_id = $input['board_id'];
        }

        $allProjectBoardLists = DB::table('boards')
                ->where('status', 1)
                ->where('project_id', $id)
                ->orderby('board_position', 'ASC')
                ->get();
        $array_position[null] = "Select Position";
        $i = 1;
        foreach ($allProjectBoardLists as $allProjectBoardList) {
            $array_position[$allProjectBoardList->board_position] = $allProjectBoardList->board_position;
            $i++;
        }
        $array_position[$i] = $i;
        //dd($array_position);

        return View::make('Boardsfront.ajax_get_position_for_move_board')->with('array_position', $array_position)->with('board_id', $board_id)->render();
    }

    function moveAdminProjectBoard() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();

        //dd($input);exit;

        if (!empty($input)) {
            $oldBoardId = $input['old_board_id'];
            $oldPosition = $input['old_position'];
            $oldProjectId = $input['old_project_id'];
            $userId = $input['user_id'];
            $projectId = $input['project_id'];
            $position = $input['position'];
        } else {
            return Redirect::to('/');
        }


        //for the board from which task will be moved
        $lastBoardDetailNew = DB::table('boards')
                ->where('boards.project_id', $oldProjectId)
                ->orderBy('boards.board_position', 'desc')
                ->first();



        if (empty($lastBoardDetailNew)) {
            $lastBoardIdNew = 1;
        } else {
            if ($lastBoardDetailNew->board_position >= $oldPosition) {
                $toBeUpdateBoardIdsNew = DB::select("SELECT GROUP_CONCAT(id) as board_ids from tbl_boards where board_position >= $oldPosition AND project_id = $oldProjectId order by board_position asc");

                $idds = $toBeUpdateBoardIdsNew[0]->board_ids;

                DB::update('Update tbl_boards SET board_position = board_position - 1 where id IN ( ' . $idds . ' )');
                $lastBoardIdNew = $oldPosition;
            } else {
                $lastBoardIdNew = $oldPosition;
            }
        }


        //for the board in which task will be moved
        $lastBoardDetail = DB::table('boards')
                ->where('boards.project_id', $projectId)
                ->orderBy('boards.board_position', 'desc')
                ->first();

        if (empty($lastBoardDetail)) {
            $lastBoardId = 1;
        } else {
            if ($lastBoardDetail->board_position >= $position) {
                $toBeUpdateBoardIds = DB::select("SELECT GROUP_CONCAT(id) as board_ids from tbl_boards where board_position >= $position AND project_id = $projectId order by board_position asc");

                $iddsNew = $toBeUpdateBoardIds[0]->board_ids;

                DB::update('Update tbl_boards SET board_position = board_position + 1 where id IN ( ' . $iddsNew . ' )');
                $lastBoardId = $position;
            } else {
                $lastBoardId = $position;
            }
        }

        if ($lastBoardId > $lastBoardDetailNew->board_position) {
            $lastBoardId = $lastBoardDetailNew->board_position;
        }

        $dataa = array(
            'project_id' => $projectId,
            'board_position' => $lastBoardId,
            'modified' => date('Y-m-d H:i:s'),
        );


        DB::table('boards')
                ->where('id', $oldBoardId)
                ->update($dataa);


        $boardData = DB::table('boards')
                ->where('id', $oldBoardId)
                ->first();

        $allProjectLists = DB::table('projects')
                ->where('status', 1)
                ->where('user_id', $userId)
                ->orderby('id', 'DESC')
                ->get();
        $array_project[null] = "Select Project";
        foreach ($allProjectLists as $allProjectList) {
            $array_project[$allProjectList->id] = $allProjectList->project_name;
        }


        $boardProjectDetail = DB::table('projects')
                ->where('projects.id', $boardData->project_id)
                ->first();

        $saveListActivity = array(
            'user_id' => $boardProjectDetail->user_id,
            'project_id' => $boardData->project_id,
            'board_id' => $oldBoardId,
            'new_board_id' => $oldBoardId,
            'type' => 'move_board',
            'message' => 'move_board',
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );



        return View::make('Boardsfront.ajax_update_add_board')->with('board', $boardData)->with('project', $boardProjectDetail)->with('array_project', $array_project)->render();
        exit;
    }

    function addTaskChecklist() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();

        //dd($input); exit;
        if (!empty($input)) {
            $checkboxTitle = $input['checkbox_title'];
            $slug = $this->createUniqueSlug($checkboxTitle, 'checklists');
            $taskId = $input['task_id'];
            $boardId = $input['board_id'];
        } else {
            return Redirect::to('/');
        }


        $saveList = array(
            'checkbox_title' => $checkboxTitle,
            'task_id' => $taskId,
            'board_id' => $boardId,
            'status' => '1',
            'slug' => $slug,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        );

        $checklists = DB::table('checklists')
                ->insertGetId(
                $saveList
        );

        return View::make('Boardsfront.ajax_add_checklist')->with('checklists', $checklists)->render();
        exit;
    }

    function addTaskChecklistValue() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();

        //dd($input); exit;
        if (!empty($input)) {
            $checkboxValue = $input['checkbox_value'];
            $slug = $this->createUniqueSlug($checkboxValue, 'checklistvalues');
            $taskId = $input['task_id'];
            $boardId = $input['board_id'];
            $checklistId = $input['checklist_id'];
        } else {
            return Redirect::to('/');
        }


        $saveList = array(
            'checkbox_value' => $checkboxValue,
            'task_id' => $taskId,
            'board_id' => $boardId,
            'checklist_id' => $checklistId,
            'status' => '1',
            'slug' => $slug,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        );

        $checklistvalues = DB::table('checklistvalues')
                ->insertGetId(
                $saveList
        );


        $checkBoxListValueDatas = DB::table('checklistvalues')->where('checklist_id', $checklistId)->get();

        if ($checkBoxListValueDatas) {
            $checked = 0;
            $unchecked = 0;
            $total = 0;
            foreach ($checkBoxListValueDatas as $checkBoxListValueData) {
                if ($checkBoxListValueData->is_checked == 0) {
                    ++$unchecked;
                } else {
                    ++$checked;
                }
                ++$total;
            }
        }

        $finalPercent = ($checked / $total) * 100;
        $percentage = round($finalPercent);

        return View::make('Boardsfront.ajax_add_checklistvalue')->with('checklistvalues', $checklistvalues)->with('percentage', $percentage)->render();
        exit;
    }

    function updateTaskChecklistValueBox() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $input = Input::all();

        //dd($input); exit;
        if (!empty($input)) {
            $isChecked = isset($input['is_checked']) ? '1' : '0';
            $checklistValueId = $input['checboxvalue_id'];
            $checkedBy = $input['checked_by'];
            $checkedListId = $input['checkbox_fr_bar'];
        } else {
            return Redirect::to('/');
        }


        $saveList = array(
            'is_checked' => $isChecked,
            'checked_by' => $checkedBy,
            'modified' => date('Y-m-d H:i:s')
        );

        $updatechecklistvalues = DB::table('checklistvalues')
                ->where('id', $checklistValueId)
                ->update($saveList);

        $checkBoxListValueDatas = DB::table('checklistvalues')->where('checklist_id', $checkedListId)->get();

        if ($checkBoxListValueDatas) {
            $checked = 0;
            $unchecked = 0;
            $total = 0;
            foreach ($checkBoxListValueDatas as $checkBoxListValueData) {
                if ($checkBoxListValueData->is_checked == 0) {
                    ++$unchecked;
                } else {
                    ++$checked;
                }
                ++$total;
            }
        }

        $finalPercent = ($checked / $total) * 100;

        echo round($finalPercent);
        exit;
    }

    function deleteProjectBoardTaskChecklist() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $boardId = 0;

        $input = Input::all();
        if (!empty($input)) {
            $checkListId = $input['id'];
            $checkListSlug = $input['slug'];
        } else {
            return Redirect::to('/');
        }

        if (empty($checkListId) || empty($checkListSlug)) {
            echo '2';
            exit;
        }

        $mainDetail = DB::table('checklists')
                ->where('checklists.id', $checkListId)
                ->first();

        $taskId = $mainDetail->task_id;

        DB::table('checklists')->where('id', $checkListId)->delete();
        DB::table('checklistvalues')->where('checklist_id', $checkListId)->delete();

        echo 1;
        exit;
    }

    function updateActivity($id = null) {
        
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $input = Input::all();
        if (!empty($input)) {
            $pid = $input['id'];
            $id2 = $input['id2'];
        } else {
            return Redirect::to('/');
        }
        
        

        if($id2 != 0){
            $activities = DB::table('activities')
                ->leftjoin('users', 'users.id', '=', 'activities.user_id')
                ->leftjoin('projects', 'projects.id', '=', 'activities.project_id')
                ->leftjoin('boards', 'boards.id', '=', 'activities.board_id')
                ->leftjoin('tasks', 'tasks.id', '=', 'activities.task_id')
                ->select('activities.*'
                        , 'users.status as user_status', 'users.slug as user_slug', 'users.profile_image as profile_image', 'users.first_name as first_name', 'users.last_name as last_name', 'users.email_address as email_address', 'projects.slug as project_slug', 'projects.project_name as project_name', 'boards.slug as board_slug', 'boards.board_name as board_name', 'tasks.slug as task_slug', 'tasks.task_name as task_name'
                )
                    ->where('activities.project_id', $pid)
                ->where('activities.board_id', $id2)
                ->orderBy('activities.id', 'desc')
                ->get();
        }else{
            $activities = DB::table('activities')
                ->leftjoin('users', 'users.id', '=', 'activities.user_id')
                ->leftjoin('projects', 'projects.id', '=', 'activities.project_id')
                ->leftjoin('boards', 'boards.id', '=', 'activities.board_id')
                ->leftjoin('tasks', 'tasks.id', '=', 'activities.task_id')
                ->select('activities.*'
                        , 'users.status as user_status', 'users.slug as user_slug', 'users.profile_image as profile_image', 'users.first_name as first_name', 'users.last_name as last_name', 'users.email_address as email_address', 'projects.slug as project_slug', 'projects.project_name as project_name', 'boards.slug as board_slug', 'boards.board_name as board_name', 'tasks.slug as task_slug', 'tasks.task_name as task_name'
                )
                ->where('activities.project_id', $pid)
                ->orderBy('activities.id', 'desc')
                ->get();
        }
        


        // dd($activities);

        if (empty($activities)) {
            $activityArray = array();
        } else {
            $activityArray = $activities;
        }


        return View::make('Boardsfront.update_activity')->with('activityArray', $activityArray)->render();
        exit;
    }

    function updateAdminProjectSection() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();

        //dump($input); exit;
        if (!empty($input)) {
            $projectName = $input['project_name'];
            $projectId = $input['id'];
        } else {
            return Redirect::to('/');
        }

        if (empty($projectId)) {
            echo '2';
            exit;
        }

        $saveList = array(
            'project_name' => $projectName,
            'modified' => date('Y-m-d H:i:s')
        );


        $adminTasks = DB::table('projects')
                ->where('id', $projectId)
                ->update($saveList);

        echo 1;
        exit;
    }

    public function joinproject($inviteid = null, $email = null, $projectslug = null, $boardslug = null) {
        //echo $boardslug; exit;

        if (empty($inviteid) || empty($email) || empty($projectslug) || empty($boardslug)) {
            return Redirect::to('/');
        }

        $inviteData = DB::table('invites')
                ->join('projects', 'projects.id', '=', 'invites.project_id')
                ->join('boards', 'boards.id', '=', 'invites.board_id')
                ->select('invites.*', 'boards.board_name as board_name', 'boards.slug as board_slug', 'projects.project_name as project_name', 'projects.slug as project_slug')
                ->where('invites.id', $inviteid)
                ->first();
        //dd($inviteData); exit;

        if (empty($inviteData)) {
            return Redirect::to('/');
        } else {
            if ($inviteData->email_address != $email) {
                return Redirect::to('/');
            }
            if (Session::has('user_id')) {
                $userId = Session::get('user_id');
                $userData = DB::table('users')
                        ->select('users.*')
                        ->where('users.id', $userId)
                        ->first();
                if ($inviteData->email_address != $userData->email_address) {
                    return Redirect::to('/');
                }
            }

            if ($inviteData->join_status == 1) {
                return Redirect::to('/board/' . $inviteData->project_slug);
            }

            return View::make('Projectboard/joinproject')->with('inviteid', $inviteid)
                            ->with('email', $email)
                            ->with('projectslug', $projectslug)
                            ->with('inviteData', $inviteData);

            exit;
        }
    }

    public function join($email_address = null, $invid = null) {
        $input['invid'] = $invid;
        $input['getEmail'] = $email_address;

        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        } else {
            $userId = Session::get('user_id');
        }

        if (empty($input['invid']) || empty($input['invid'])) {
            return Redirect::to('/login');
        }

        if (isset($input['invid']) && !empty($input['invid'])) {
            $invid = $input['invid'];
            $inviteData = DB::table('invites')
                    ->join('projects', 'projects.id', '=', 'invites.project_id')
                    ->join('boards', 'boards.id', '=', 'invites.board_id')
                    ->select('invites.*', 'projects.project_name as project_name', 'projects.slug as project_slug', 'boards.board_name as board_name', 'boards.slug as board_slug')
                    ->where('invites.id', $invid)
                    ->first();

            //dd($inviteData); exit;

            if ($inviteData->email_address == $input['getEmail']) {
                if ($inviteData->join_status == 0) {
                    $dataInvite = array(
                        'join_status' => 1,
                        'user_id' => $userId,
                        'modified' => date('Y-m-d H:i:s'),
                    );

                    DB::table('invites')
                            ->where('id', $invid)
                            ->update($dataInvite);

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
                } else {
                    return Redirect::to('/board/' . $inviteData->project_slug);
                }
            }
        } else {
            $invid = 0;
        }

        return Redirect::to('/projectboard/projects');
    }

    function addTaskDueDate() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();

        //dd($input); exit;
        if (!empty($input)) {
            $dt = $input['due_date_dt'];
            $tm = $input['due_date_tm'];
            $taskId = $input['task_id'];
            $boardId = $input['board_id'];
        } else {
            return Redirect::to('/');
        }

        $dt_formatted = date("Y-m-d", strtotime($dt));
        $tm_formatted = date("H:i:s", strtotime($tm));
        $due_date = $dt_formatted . " " . $tm_formatted;

        $saveList = array(
            'due_date' => $due_date,
            'modified' => date('Y-m-d H:i:s')
        );


        $boards = DB::table('tasks')
                ->where('id', $taskId)
                ->update($saveList);

        $due_date_text = date("M d \a\\t H:i A", strtotime($due_date));

        echo "<div class='due-dttt'> <span class='due_head'>Due Date </span>
                <span class='due-date_text'>" . $due_date_text . "</span>
              </div>";
        exit;
    }

    function removeTaskDueDate() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();

        //dd($input); exit;
        if (!empty($input)) {
            $taskId = $input['task_id'];
            $boardId = $input['board_id'];
        } else {
            return Redirect::to('/');
        }



        $saveList = array(
            'due_date' => null,
            'modified' => date('Y-m-d H:i:s')
        );


        $boards = DB::table('tasks')
                ->where('id', $taskId)
                ->update($saveList);

        echo "1";
        exit;
    }

    function addTaskCommentValue() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();

        //dd($input); exit;
        if (!empty($input)) {
            $comment = $input['comment'];
            $userId = $input['user_id'];
            $taskId = $input['task_id'];
            $boardId = $input['board_id'];
            $slug = time() . mt_rand(9999, 99999);
        } else {
            echo "error";
            exit;
        }

        $matchArray = array();
        preg_match_all("/@[\._a-zA-Z0-9-]+/i", $comment, $matches);
        //echo '<pre>';
        $matchArray = $matches['0'];

        //dd($matchArray); exit;

        if ($matchArray) {
            foreach ($matchArray as $matchA) {
                $matchA = substr($matchA, 1);
                $userData = DB::table('users')
                        ->select('users.*')
                        ->where('users.slug', $matchA)
                        ->first();

                //dd($userData);

                if ($userData) {
                    $saveListComment = array(
                        'user_id' => $userData->id,
                        'type' => 'memeber_mention',
                        'task_id' => $taskId,
                        'board_id' => $boardId,
                        'status' => 1,
                        'slug' => time() . mt_rand(999999, 9999999),
                        'created' => date('Y-m-d H:i:s')
                    );



                    if ($userData->turn_off_notification == 0) {
                        $noti = DB::table('notifications')
                                ->insertGetId(
                                $saveListComment
                        );
                    }
                }
            }
        }

        //exit;



        $saveList = array(
            'comment' => $comment,
            'user_id' => $userId,
            'task_id' => $taskId,
            'status' => 1,
            'slug' => $slug,
            'created' => date('Y-m-d H:i:s')
        );

        $comments = DB::table('comments')
                ->insertGetId(
                $saveList
        );

        $commentData = DB::table('comments')
                ->join('tasks', 'tasks.id', '=', 'comments.task_id')
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->select('comments.*', 'users.first_name', 'users.last_name', 'users.last_name')
                ->where('comments.id', $comments)
                ->first();





        $taskDetail = DB::table('tasks')
                        ->join('boards', 'boards.id', '=', 'tasks.board_id')
                        ->join('projects', 'projects.id', '=', 'boards.project_id')
                        ->select('tasks.*', 'boards.board_name as board_name', 'boards.slug as board_slug', 'boards.status as board_status', 'boards.board_position as board_position', 'projects.id as project_id', 'projects.user_id as project_user_id', 'projects.project_name as project_name', 'projects.slug as project_slug', 'projects.status as project_status')
                        ->where('tasks.id', $taskId)->first();

        //dd($taskDetail);

        $saveListActivity = array(
            'user_id' => $user_id,
            'project_id' => $taskDetail->project_id,
            'board_id' => $taskDetail->board_id,
            'task_id' => $taskDetail->id,
            'type' => 'add_comment',
            'message' => 'comment added into task',
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );


        $userssInfo = DB::table('users')
                ->where('id', $taskDetail->project_user_id)
                ->first();

        $invitedProjectUsers = DB::table('projectinvites')
                ->join('users', 'users.id', '=', 'projectinvites.user_id')
                ->where('project_id', $taskDetail->project_id)
                ->where('board_id', $taskDetail->board_id)
                ->select('users.*')
                ->get();

        $newKey = sizeof($invitedProjectUsers);

        $userssInfoo = DB::table('users')
                ->where('id', $taskDetail->project_user_id)
                ->first();

        $invitedProjectUsers[$newKey] = $userssInfoo;


        if ($invitedProjectUsers) {
            foreach ($invitedProjectUsers as $userssInfo) {

                if ($userssInfo->turn_off_notification == 0) {

                    $saveListNotification = array(
                        'user_id' => $userssInfo->id,
                        'project_id' => $taskDetail->project_id,
                        'board_id' => $taskDetail->board_id,
                        'task_id' => $taskDetail->id,
                        'type' => 'add_comment',
                        'status' => '1',
                        'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
                        'created' => date('Y-m-d H:i:s'),
                        'modified' => date('Y-m-d H:i:s'),
                    );

                    $notiId = DB::table('notifications')->insertGetId(
                            $saveListNotification
                    );

                    $this->sendEmail($notiId);
                }
            }
        }




        return View::make('Boardsfront.ajax_add_comment')->with('commentList', $commentData)->render();
        exit;
    }

    function editTaskCommentValue() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();

        //dd($input); exit;
        if (!empty($input)) {
            $comment = $input['comment'];
            $commentId = $input['comment_id'];
        } else {
            echo "error";
            exit;
        }


        $saveList = array(
            'comment' => $comment,
            'modified' => date('Y-m-d H:i:s')
        );


        $boards = DB::table('comments')
                ->where('id', $commentId)
                ->update($saveList);

        echo "1";
        exit;
    }

    function deleteTaskComment() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');


        $input = Input::all();
        if (!empty($input)) {
            $commentId = $input['id'];
            $commentSlug = $input['slug'];
        } else {
            return Redirect::to('/');
        }

        if (empty($commentId) || empty($commentSlug)) {
            echo '2';
            exit;
        }

        DB::table('comments')->where('id', $commentId)->delete();

        echo 1;
        exit;
    }

    function getEmailListOfSite() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');
        $input = Input::all();


        if (!empty($input)) {
            $keyword = $input['keyword'];
            $prj_id = $input['prj_id'];
        }

        $project = DB::table('projects')
                        ->where('id', $prj_id)->first();

        if (!empty($keyword)) {
            $users = DB::table('users')
                    ->where('activation_status', 1)
                    ->where('status', 1)
                    ->where('id', "!=", $user_id)
                    ->where('id', "!=", $project->user_id)
                    ->where('email_address', 'LIKE', '%' . $keyword . '%')
                    ->orderby('first_name', 'ASC')
                    ->get();

            if ($users) {
                ?>

                <ul id ="country-list">
                    <?php
                    foreach ($users as $user) {
                        ?>
                        <li onClick="selectEmail('<?php echo $user->email_address; ?>');">
                            <span class="user_pic new_user_pic">

                                <?php
                                if (!empty($user->profile_image)) {
                                    echo '<img src="' . HTTP_PATH . DISPLAY_FULL_PROFILE_IMAGE_PATH . $user->profile_image . '" alt="user img">';
                                } else {
                                    echo '<img src="' . HTTP_PATH . 'public/img/front/man-user.svg" alt="user img">';
                                }
                                ?>
                            </span>
                            <?php echo $user->email_address; ?>
                        </li>
                    <?php } ?>
                </ul>
                <?php
            }
        }

        exit;
    }

    function sendInvite() {
        $input = Input::all();
        if (!empty($input)) {
            //dd($input); exit;

            $userId = $input['user_id'];
            $project_id = $input['project_id'];
            $board_id = $input['board_id'];
            $emailAddressData = $input['email_address'];

            if (isset($input['user_type'])) {
                $userType = $input['user_type'];
            } else {
                $userType = 0;
            }

            $projectDetail = DB::table('projects')
                    ->where('id', $project_id)
                    ->first();
            $slug = $projectDetail->slug;


            $boardDetail = DB::table('boards')
                    ->where('id', $board_id)
                    ->first();

            $boardslug = $boardDetail->slug;



            $emailAddresses = explode(",", $emailAddressData);
            if ($emailAddresses) {
                foreach ($emailAddresses as $emailAddress) {
                    $emailAddress = trim($emailAddress);

                    $checkInviteUser = DB::table('invites')
                            ->where('email_address', $emailAddress)
                            ->where('project_id', $project_id)
                            ->first();

                    $checkUser = DB::table('users')
                            ->where('email_address', $emailAddress)
                            ->first();


                    if (!empty($checkUser)) {
                        $userId = $checkUser->id;
                        $username = $checkUser->first_name . " " . $checkUser->last_name;
                    } else {
                        $userId = 0;
                        $usernameArr = explode('@', $emailAddress);
                        $username = $usernameArr[0];
                    }

                    if (empty($checkInviteUser)) {
                        $data = array(
                            'user_id' => $userId,
                            'project_id' => $project_id,
                            'board_id' => $board_id,
                            'email_address' => $emailAddress,
                            'status' => 1,
                            'join_status' => 0,
                            'user_type' => $userType,
                            'created' => date('Y-m-d H:i:s'),
                        );

                        $invitess = DB::table('invites')
                                ->insertGetId(
                                $data
                        );


                        $reset_link = HTTP_PATH . "joinproject/" . $invitess . "/" . $emailAddress . "/" . $slug . "/" . $boardslug;

                        if ($userId != 0) {
                            $data1 = array(
                                'user_id' => $userId,
                                'task_id' => 0,
                                'type' => "membor_invite",
                                'url' => $reset_link,
                                'status' => 1,
                                'slug' => time(),
                                'created' => date('Y-m-d H:i:s'),
                            );

                            $userssInfo = DB::table('users')
                                    ->where('id', $userId)
                                    ->first();

                            if ($userssInfo->turn_off_notification == 0) {

                                $notii = DB::table('notifications')
                                        ->insertGetId(
                                        $data1
                                );
                            }
                        }


                        // send email to administrator
                        $mail_data = array(
                            'firstname' => $username,
                            'email_addr' => $emailAddress,
                            'text' => 'You have been invited to a Project on Taskboard. Please join project from below link.',
                            'resetLink' => '<a href="' . $reset_link . '">Click here<a> to Join.'
                        );

                        // return View::make('emails.template')->with($mail_data); // to check mail template data to view
                        Mail::send('emails.template', $mail_data, function($message) use ($mail_data) {
                                    $message->setSender(array(MAIL_FROM => SITE_TITLE));
                                    $message->setFrom(array(MAIL_FROM => SITE_TITLE));
                                    $message->to($mail_data['email_addr'], '')->subject('You are Invited to Join ' . SITE_TITLE);
                                });
                    }
                }
            }

            echo "Invited Successfully.";
            exit;
        }
    }

    function dragProjectTask() {
        if (!Session::has('user_id')) {
            echo "error";
            exit;
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();

        //dd($input);exit;

        if (!empty($input)) {
            $oldTaskId = $input['old_task_id'];
            $oldBoardId = $input['old_board_id'];
            $oldPosition = $input['old_position'];
            $boardId = $input['board_id'];
            $position = $input['position'] + 1;
        } else {
            echo "error";
            exit;
        }


        //for the board from which task will be moved
        $lastTaskDetailNew = DB::table('tasks')
                ->where('tasks.board_id', $oldBoardId)
                ->orderBy('tasks.task_position', 'desc')
                ->first();

        if (empty($lastTaskDetailNew)) {
            $lastTaskIdNew = 1;
        } else {
            if ($lastTaskDetailNew->task_position >= $oldPosition) {
                $toBeUpdateTaskIdsNew = DB::select("SELECT GROUP_CONCAT(id) as task_ids from tbl_tasks where task_position >= $oldPosition AND board_id = $oldBoardId order by task_position asc");

                $idds = $toBeUpdateTaskIdsNew[0]->task_ids;
                //echo $idds; exit;

                DB::update('Update tbl_tasks SET task_position = task_position - 1 where id IN ( ' . $idds . ' )');
                $lastTaskIdNew = $oldPosition;
            } else {
                $lastTaskIdNew = $oldPosition;
            }
        }



        //for the board in which task will be moved
        $lastTaskDetail = DB::table('tasks')
                ->where('tasks.board_id', $boardId)
                ->orderBy('tasks.task_position', 'desc')
                ->first();

        if (empty($lastTaskDetail)) {
            $lastTaskId = 1;
        } else {
            if ($lastTaskDetail->task_position >= $position) {
                $toBeUpdateTaskIds = DB::select("SELECT GROUP_CONCAT(id) as task_ids from tbl_tasks where task_position >= $position AND board_id = $boardId order by task_position asc");
                //dd($toBeUpdateTaskIds); exit;

                $iddsNew = $toBeUpdateTaskIds[0]->task_ids;
                //echo $iddsNew;

                DB::update('Update tbl_tasks SET task_position = task_position + 1 where id IN ( ' . $iddsNew . ' )');
                $lastTaskId = $position;
            } else {
                $lastTaskId = $position;
            }
        }





        $dataa = array(
            'board_id' => $boardId,
            'task_position' => $lastTaskId,
            'modified' => date('Y-m-d H:i:s'),
        );


        DB::table('tasks')
                ->where('id', $oldTaskId)
                ->update($dataa);




        $boardData = DB::table('boards')
                ->where('id', $input['board_id'])
                ->first();




        $boardProjectDetail = DB::table('projects')
                ->where('projects.id', $boardData->project_id)
                ->first();

        $saveListActivity = array(
            'user_id' => $boardProjectDetail->user_id,
            'project_id' => $boardData->project_id,
            'board_id' => $boardData->id,
            'task_id' => $oldTaskId,
            'new_task_id' => $oldTaskId,
            'type' => 'move_task',
            'message' => 'board copied',
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );


        $allProjectLists = DB::table('projects')
                ->where('status', 1)
                ->where('user_id', $boardProjectDetail->user_id)
                ->orderby('id', 'DESC')
                ->get();
        $array_project[null] = "Select Project";
        foreach ($allProjectLists as $allProjectList) {
            $array_project[$allProjectList->id] = $allProjectList->project_name;
        }


        return View::make('Boardsfront.ajax_task_listing')->with('board', $boardData)->with('array_project', $array_project)->with('project', $boardProjectDetail)->render();

//          $returnData = array(
//              'boardId' => $boardId,
//              'position' => $position
//              );
//          
//          echo json_encode($returnData);

        exit;
    }

    function dragProjectBoard() {
        if (!Session::has('user_id')) {
            echo "error";
            exit;
        }
        $user_id = Session::get('user_id');


        $input = Input::all();

        //dd($input);exit;

        if (!empty($input)) {
            $oldBoardId = $input['old_board_id'];
            $oldPosition = $input['old_position'];
            $projectId = $input['project_id'];
            $oldProjectId = $input['project_id'];
            $position = $input['position'] + 1;
        } else {
            echo "error";
            exit;
        }





        //for the board from which task will be moved
        $lastBoardDetailNew = DB::table('boards')
                ->where('boards.project_id', $oldProjectId)
                ->orderBy('boards.board_position', 'desc')
                ->first();



        if (empty($lastBoardDetailNew)) {
            $lastBoardIdNew = 1;
        } else {
            if ($lastBoardDetailNew->board_position >= $oldPosition) {
                $toBeUpdateBoardIdsNew = DB::select("SELECT GROUP_CONCAT(id) as board_ids from tbl_boards where board_position >= $oldPosition AND project_id = $oldProjectId order by board_position asc");

                $idds = $toBeUpdateBoardIdsNew[0]->board_ids;

                DB::update('Update tbl_boards SET board_position = board_position - 1 where id IN ( ' . $idds . ' )');
                $lastBoardIdNew = $oldPosition;
            } else {
                $lastBoardIdNew = $oldPosition;
            }
        }


        //for the board in which task will be moved
        $lastBoardDetail = DB::table('boards')
                ->where('boards.project_id', $projectId)
                ->orderBy('boards.board_position', 'desc')
                ->first();

        if (empty($lastBoardDetail)) {
            $lastBoardId = 1;
        } else {
            if ($lastBoardDetail->board_position >= $position) {
                $toBeUpdateBoardIds = DB::select("SELECT GROUP_CONCAT(id) as board_ids from tbl_boards where board_position >= $position AND project_id = $projectId order by board_position asc");

                $iddsNew = $toBeUpdateBoardIds[0]->board_ids;

                DB::update('Update tbl_boards SET board_position = board_position + 1 where id IN ( ' . $iddsNew . ' )');
                $lastBoardId = $position;
            } else {
                $lastBoardId = $position;
            }
        }

        if ($lastBoardId > $lastBoardDetailNew->board_position) {
            $lastBoardId = $lastBoardDetailNew->board_position;
        }

        $dataa = array(
            'project_id' => $projectId,
            'board_position' => $lastBoardId,
            'modified' => date('Y-m-d H:i:s'),
        );


        DB::table('boards')
                ->where('id', $oldBoardId)
                ->update($dataa);


        $boardData = DB::table('boards')
                ->where('id', $oldBoardId)
                ->first();


        $boardProjectDetail = DB::table('projects')
                ->where('projects.id', $boardData->project_id)
                ->first();

        $saveListActivity = array(
            'user_id' => $boardProjectDetail->user_id,
            'project_id' => $boardData->project_id,
            'board_id' => $oldBoardId,
            'new_board_id' => $oldBoardId,
            'type' => 'move_board',
            'message' => 'move_board',
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );



        echo "success";
        exit;
    }

    function updatePreviousBoard() {
        if (!Session::has('user_id')) {
            echo "error";
            exit;
        }
        $user_id = Session::get('user_id');
        $taskId = 0;

        $input = Input::all();

        //dd($input);exit;

        if (!empty($input)) {
            $boardId = $input['old_board_id'];
        } else {
            echo "error";
            exit;
        }






        $boardData = DB::table('boards')
                ->where('id', $boardId)
                ->first();




        $boardProjectDetail = DB::table('projects')
                ->where('projects.id', $boardData->project_id)
                ->first();




        $allProjectLists = DB::table('projects')
                ->where('status', 1)
                ->where('user_id', $boardProjectDetail->user_id)
                ->orderby('id', 'DESC')
                ->get();
        $array_project[null] = "Select Project";
        foreach ($allProjectLists as $allProjectList) {
            $array_project[$allProjectList->id] = $allProjectList->project_name;
        }

        return View::make('Boardsfront.ajax_task_listing')->with('board', $boardData)->with('array_project', $array_project)->with('project', $boardProjectDetail)->render();

//          $returnData = array(
//              'boardId' => $boardId,
//              'position' => $position
//              );
//          
//          echo json_encode($returnData);

        exit;
    }

    public function content($slug = null) {

        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $project = DB::table('projects')
                        ->where('slug', $slug)->first();

        if (empty($project)) {
            return Redirect::to('/account');
        }
        $project_id = $project->id;


        $inviteData = DB::table('projectinvites')
                ->where('project_id', $project_id)
                ->where('user_id', $user_id)
                ->first();


        //dd($inviteData); exit;


        if ($user_id == $project->user_id || !empty($inviteData)) {
            
        } else {
            return Redirect::to('/account');
        }


        $preAddedBoardLists = DB::table('adminprojects')
                ->where('status', 1)
                ->orderby('project_name', 'DESC')
                ->get();
        $array_boardd[null] = "Select Project";
        foreach ($preAddedBoardLists as $preAddedBoardList) {
            $array_boardd[$preAddedBoardList->id] = $preAddedBoardList->project_name;
        }


        $allProjectLists = DB::table('projects')
                ->where('status', 1)
                ->where('user_id', $project->user_id)
                ->orderby('id', 'DESC')
                ->get();
        $array_project[null] = "Select Project";
        foreach ($allProjectLists as $allProjectList) {
            $array_project[$allProjectList->id] = $allProjectList->project_name;
        }

        //print_r($array_project); exit;




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


        $query = Board::sortable()
                ->where(function ($query) use ($search_keyword) {
                    $query->where('board_name', 'LIKE', '%' . $search_keyword . '%');
                });

        $query = $query->where('project_id', '=', $project_id);


        if (!empty($input['from_date'])) {
            $query = $query->whereDate('created', '>=', date('Y-m-d H:i:s', strtotime($searchByDateFrom)));
        }

        if (!empty($input['to_date'])) {
            $query = $query->whereDate('created', '<=', date('Y-m-d H:i:s', strtotime($searchByDateTo)));
        }


        if (!empty($input['action'])) {
            $action = $input['action'];
            $idList = $input['chkRecordId'];
        }

//        $query->join('admintasks', 'boards.id', '=', 'admintasks.board_id')
//        ->select('boards.*','admintasks.task_name');

        $separator = implode("/", $separator);

        // Get all the users
        $boards = $query->orderBy('board_position', 'asc')->orderBy('id', 'desc')->sortable()->paginate(200);


//        $comments = Board::find(5)->admintasks;
        //echo "<pre>"; print_r($comments); exit;
        // Show the page
        return View::make('Boardsfront/ajax_index', compact('boards'))->with('search_keyword', $search_keyword)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('array_project', $array_project)
                        ->with('array_boardd', $array_boardd)
                        ->with('project', $project);
    }

    public function invite($slug = null, $boardSlug = null) {

        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }

        $input = Input::all();
        $search_keyword = "";
        $searchByDateFrom = "";
        $searchByDateTo = "";
        $separator = array();
        if (!empty($input['search'])) {
            $search_keyword = trim($input['search']);
        }

        $user_id = Session::get('user_id');

        $project = DB::table('projects')
                        ->where('slug', $slug)->first();

        $projectUser = DB::table('users')
                        ->where('id', $project->user_id)->first();

        $boardData = DB::table('boards')
                        ->where('slug', $boardSlug)->first();

        if (empty($project) || empty($boardData)) {
            return Redirect::to('/account');
        }
        $project_id = $project->id;

        $user = DB::table('users')
                ->where('id', $user_id)
                ->where('status', '1')
                ->first();

        if (empty($user)) {
            Session::forget('user_id');
            return Redirect::to('/login')->with('error_message', 'Your account might have been temporarily disabled.');
        }


        $invitedProjects = DB::table('projectinvites')
                ->join('projects', 'projects.id', '=', 'projectinvites.project_id')
                ->select('projectinvites.*', 'projects.project_name as project_name', 'projects.slug as project_slug')
                ->where('projectinvites.user_id', $user_id)
                ->get();

        //dd($invitedProjects);

        $this->layout->title = TITLE_FOR_PAGES . 'User List for Invitation';

        $query = User::sortable()
                ->where(function ($query) use ($search_keyword) {
                    $query->where('first_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('last_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('email_address', 'LIKE', '%' . $search_keyword . '%');
                });

        $users = $query->where('activation_status', 1)
                        ->where('users.status', 1)
                        ->where('users.id', "!=", $project->user_id)->orderBy('users.id', 'desc')->sortable()->paginate(20);

//        $users = DB::table('users')
//                ->where('activation_status', 1)
//                ->where('status', 1)
//                ->where('id', "!=", $project->user_id)
//                ->orderby('id', 'desc')
//                ->paginate(20);
        $this->layout->content = View::make('Projectboard.invite')->with('users', $users)
                ->with('project', $project)
                ->with('boardData', $boardData)
                ->with('invitedProjects', $invitedProjects);
    }

    function removeInvitedUser() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');


        $input = Input::all();
        if (!empty($input)) {
            $userId = $input['user_id'];
            $projectId = $input['project_id'];
        } else {
            echo "2";
        }

        if (empty($userId) || empty($projectId)) {
            echo '2';
            exit;
        }

//        DB::table('invites')
//        ->where('user_id', $userId)
//        ->where('project_id', $projectId)
//        ->update(['join_status' => 0]);

        DB::table('projectinvites')->where('user_id', $userId)->where('project_id', $projectId)->delete();
        DB::table('invites')->where('user_id', $userId)->where('project_id', $projectId)->delete();

        echo 1;
        exit;
    }

    public function usertypeinvite($usertypes = null, $slug = null, $boardSlug = null) {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }


        $usertypesData = DB::table('usertypes')
                ->where('status', 1)
                ->where('slug', $usertypes)
                ->first();
        if (empty($usertypesData)) {
            return Redirect::to('/account');
        }



        $input = Input::all();
        $search_keyword = "";
        $searchByDateFrom = "";
        $searchByDateTo = "";
        $separator = array();
        if (!empty($input['search'])) {
            $search_keyword = trim($input['search']);
        }

        $user_id = Session::get('user_id');

        $project = DB::table('projects')
                        ->where('slug', $slug)->first();

        $projectUser = DB::table('users')
                        ->where('id', $project->user_id)->first();

        //dd($projectUser); exit;

        $boardData = DB::table('boards')
                        ->where('slug', $boardSlug)->first();

        if (empty($project) || empty($boardData)) {
            return Redirect::to('/account');
        }
        $project_id = $project->id;

        $user = DB::table('users')
                ->where('id', $user_id)
                ->where('status', '1')
                ->first();

        if (empty($user)) {
            Session::forget('user_id');
            return Redirect::to('/login')->with('error_message', 'Your account might have been temporarily disabled.');
        }


        $invitedProjects = DB::table('projectinvites')
                ->join('projects', 'projects.id', '=', 'projectinvites.project_id')
                ->select('projectinvites.*', 'projects.project_name as project_name', 'projects.slug as project_slug')
                ->where('projectinvites.user_id', $user_id)
                ->get();

        //dd($invitedProjects);

        $this->layout->title = TITLE_FOR_PAGES . 'User List for Invitation';

        $query = User::sortable()
                ->where(function ($query) use ($search_keyword) {
                    $query->where('first_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('last_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('email_address', 'LIKE', '%' . $search_keyword . '%');
                });

        $users = $query->where('activation_status', 1)
                        ->where('status', 1)
                        ->where('user_type', $usertypesData->id)
                        ->where('id', "!=", $project->user_id)->orderBy('id', 'desc')->sortable()->paginate(20);


//        $users = DB::table('users')
//                ->where('activation_status', 1)
//                ->where('status', 1)
//                ->where('user_type', 0)
//                ->where('id', "!=", $project->user_id)
//                ->orderby('id', 'desc')
//                ->paginate(20);
        $this->layout->content = View::make('Projectboard.usertypeinvite')->with('users', $users)
                        ->with('boardData', $boardData)
                        ->with('usertypesData', $usertypesData)
                        ->with('project', $project)->with('invitedProjects', $invitedProjects);
    }

    public function agent($slug = null, $boardSlug = null) {

        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }

        $input = Input::all();
        $search_keyword = "";
        $searchByDateFrom = "";
        $searchByDateTo = "";
        $separator = array();
        if (!empty($input['search'])) {
            $search_keyword = trim($input['search']);
        }

        $user_id = Session::get('user_id');

        $project = DB::table('projects')
                        ->where('slug', $slug)->first();

        $projectUser = DB::table('users')
                        ->where('id', $project->user_id)->first();

        //dd($projectUser); exit;

        $boardData = DB::table('boards')
                        ->where('slug', $boardSlug)->first();

        if (empty($project) || empty($boardData)) {
            return Redirect::to('/account');
        }
        $project_id = $project->id;

        $user = DB::table('users')
                ->where('id', $user_id)
                ->where('status', '1')
                ->first();

        if (empty($user)) {
            Session::forget('user_id');
            return Redirect::to('/login')->with('error_message', 'Your account might have been temporarily disabled.');
        }


        $invitedProjects = DB::table('projectinvites')
                ->join('projects', 'projects.id', '=', 'projectinvites.project_id')
                ->select('projectinvites.*', 'projects.project_name as project_name', 'projects.slug as project_slug')
                ->where('projectinvites.user_id', $user_id)
                ->get();

        //dd($invitedProjects);

        $this->layout->title = TITLE_FOR_PAGES . 'User List for Invitation';

        $query = User::sortable()
                ->where(function ($query) use ($search_keyword) {
                    $query->where('first_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('last_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('email_address', 'LIKE', '%' . $search_keyword . '%');
                });

        $users = $query->where('activation_status', 1)
                        ->where('status', 1)
                        ->where('user_type', 0)
                        ->where('id', "!=", $project->user_id)->orderBy('id', 'desc')->sortable()->paginate(20);


//        $users = DB::table('users')
//                ->where('activation_status', 1)
//                ->where('status', 1)
//                ->where('user_type', 0)
//                ->where('id', "!=", $project->user_id)
//                ->orderby('id', 'desc')
//                ->paginate(20);
        $this->layout->content = View::make('Projectboard.agent')->with('users', $users)
                        ->with('boardData', $boardData)->with('project', $project)->with('invitedProjects', $invitedProjects);
    }

    public function lender($slug = null, $boardSlug = null) {

        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }

        $input = Input::all();
        $search_keyword = "";
        $searchByDateFrom = "";
        $searchByDateTo = "";
        $separator = array();
        if (!empty($input['search'])) {
            $search_keyword = trim($input['search']);
        }

        $user_id = Session::get('user_id');

        $project = DB::table('projects')
                        ->where('slug', $slug)->first();

        $projectUser = DB::table('users')
                        ->where('id', $project->user_id)->first();

        //dd($projectUser); exit;

        $boardData = DB::table('boards')
                        ->where('slug', $boardSlug)->first();

        if (empty($project) || empty($boardData)) {
            return Redirect::to('/account');
        }

        $project_id = $project->id;

        $user = DB::table('users')
                ->where('id', $user_id)
                ->where('status', '1')
                ->first();

        if (empty($user)) {
            Session::forget('user_id');
            return Redirect::to('/login')->with('error_message', 'Your account might have been temporarily disabled.');
        }


        $invitedProjects = DB::table('projectinvites')
                ->join('projects', 'projects.id', '=', 'projectinvites.project_id')
                ->select('projectinvites.*', 'projects.project_name as project_name', 'projects.slug as project_slug')
                ->where('projectinvites.user_id', $user_id)
                ->get();

        //dd($invitedProjects);

        $this->layout->title = TITLE_FOR_PAGES . 'User List for Invitation';

        $query = User::sortable()
                ->where(function ($query) use ($search_keyword) {
                    $query->where('first_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('last_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('email_address', 'LIKE', '%' . $search_keyword . '%');
                });

        $users = $query->where('activation_status', 1)
                        ->where('status', 1)
                        ->where('user_type', 1)
                        ->where('id', "!=", $project->user_id)->orderBy('id', 'desc')->sortable()->paginate(20);


//        $users = DB::table('users')
//                ->where('activation_status', 1)
//                ->where('status', 1)
//                ->where('user_type', 1)
//                ->where('id', "!=", $project->user_id)
//                ->orderby('id', 'desc')
//                ->paginate(20);
        $this->layout->content = View::make('Projectboard.lender')->with('users', $users)->with('boardData', $boardData)->with('project', $project)->with('invitedProjects', $invitedProjects);
    }

    public function title($slug = null, $boardSlug = null) {

        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }

        $input = Input::all();
        $search_keyword = "";
        $searchByDateFrom = "";
        $searchByDateTo = "";
        $separator = array();
        if (!empty($input['search'])) {
            $search_keyword = trim($input['search']);
        }

        $user_id = Session::get('user_id');

        $project = DB::table('projects')
                        ->where('slug', $slug)->first();

        $projectUser = DB::table('users')
                        ->where('id', $project->user_id)->first();

        //dd($projectUser); exit;

        $boardData = DB::table('boards')
                        ->where('slug', $boardSlug)->first();

        if (empty($project) || empty($boardData)) {
            return Redirect::to('/account');
        }
        $project_id = $project->id;

        $user = DB::table('users')
                ->where('id', $user_id)
                ->where('status', '1')
                ->first();

        if (empty($user)) {
            Session::forget('user_id');
            return Redirect::to('/login')->with('error_message', 'Your account might have been temporarily disabled.');
        }


        $invitedProjects = DB::table('projectinvites')
                ->join('projects', 'projects.id', '=', 'projectinvites.project_id')
                ->select('projectinvites.*', 'projects.project_name as project_name', 'projects.slug as project_slug')
                ->where('projectinvites.user_id', $user_id)
                ->get();

        //dd($invitedProjects);

        $this->layout->title = TITLE_FOR_PAGES . 'User List for Invitation';

        $query = User::sortable()
                ->where(function ($query) use ($search_keyword) {
                    $query->where('first_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('last_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('email_address', 'LIKE', '%' . $search_keyword . '%');
                });

        $users = $query->where('activation_status', 1)
                        ->where('status', 1)
                        ->where('user_type', 2)
                        ->where('id', "!=", $project->user_id)->orderBy('id', 'desc')->sortable()->paginate(20);

//        $users = DB::table('users')
//                ->where('activation_status', 1)
//                ->where('status', 1)
//                ->where('user_type', 2)
//                ->where('id', "!=", $project->user_id)
//                ->orderby('id', 'desc')
//                ->paginate(20);
        $this->layout->content = View::make('Projectboard.titles')->with('users', $users)->with('boardData', $boardData)->with('project', $project)->with('invitedProjects', $invitedProjects);
    }

    public function client($slug = null, $boardSlug = null) {

        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }

        $input = Input::all();
        $search_keyword = "";
        $searchByDateFrom = "";
        $searchByDateTo = "";
        $separator = array();
        if (!empty($input['search'])) {
            $search_keyword = trim($input['search']);
        }

        $user_id = Session::get('user_id');

        $project = DB::table('projects')
                        ->where('slug', $slug)->first();

        $projectUser = DB::table('users')
                        ->where('id', $project->user_id)->first();

        //dd($projectUser); exit;

        $boardData = DB::table('boards')
                        ->where('slug', $boardSlug)->first();

        if (empty($project) || empty($boardData)) {
            return Redirect::to('/account');
        }

        $project_id = $project->id;

        $user = DB::table('users')
                ->where('id', $user_id)
                ->where('status', '1')
                ->first();

        if (empty($user)) {
            Session::forget('user_id');
            return Redirect::to('/login')->with('error_message', 'Your account might have been temporarily disabled.');
        }


        $invitedProjects = DB::table('projectinvites')
                ->join('projects', 'projects.id', '=', 'projectinvites.project_id')
                ->select('projectinvites.*', 'projects.project_name as project_name', 'projects.slug as project_slug')
                ->where('projectinvites.user_id', $user_id)
                ->get();

        //dd($invitedProjects);

        $this->layout->title = TITLE_FOR_PAGES . 'User List for Invitation';

        $query = User::sortable()
                ->where(function ($query) use ($search_keyword) {
                    $query->where('first_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('last_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('email_address', 'LIKE', '%' . $search_keyword . '%');
                });

        $users = $query->where('activation_status', 1)
                        ->where('status', 1)
                        ->where('user_type', 3)
                        ->where('id', "!=", $project->user_id)->orderBy('id', 'desc')->sortable()->paginate(20);

//        $users = DB::table('users')
//                ->where('activation_status', 1)
//                ->where('status', 1)
//                ->where('user_type', 0)
//                ->where('id', "!=", $project->user_id)
//                ->orderby('id', 'desc')
//                ->paginate(20);
        $this->layout->content = View::make('Projectboard.client')->with('users', $users)->with('boardData', $boardData)->with('project', $project)->with('invitedProjects', $invitedProjects);
    }

    function addAttachment() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $taskId = 0;

        $input = Input::all();

        //dd($input); exit;
        if (!empty($input)) {
            $attachment = $input['attachment'];
            $userId = $input['user_id'];
            $taskId = $input['task_id'];
            $boardId = $input['board_id'];
            $slug = time() . mt_rand(9999, 99999);
        } else {
            echo "error";
            exit;
        }

        if (Input::hasFile('attachment')) {
            $file = Input::file('attachment');
            $attachmentName = time() . $file->getClientOriginalName();
            $file->move(UPLOAD_FULL_ATTACHMENT_IMAGE_PATH, time() . $file->getClientOriginalName());
        } else {
            $attachmentName = $user->attachment;
        }





        $saveList = array(
            'attachment' => $attachmentName,
            'user_id' => $userId,
            'task_id' => $taskId,
            'status' => 1,
            'slug' => $slug,
            'created' => date('Y-m-d H:i:s')
        );

        $comments = DB::table('attachments')
                ->insertGetId(
                $saveList
        );



        $taskDetail = DB::table('tasks')
                        ->join('boards', 'boards.id', '=', 'tasks.board_id')
                        ->join('projects', 'projects.id', '=', 'boards.project_id')
                        ->select('tasks.*', 'boards.board_name as board_name', 'boards.slug as board_slug', 'boards.status as board_status', 'boards.board_position as board_position', 'projects.id as project_id', 'projects.user_id as project_user_id', 'projects.project_name as project_name', 'projects.slug as project_slug', 'projects.status as project_status')
                        ->where('tasks.id', $taskId)->first();



        $saveListActivity = array(
            'user_id' => $user_id,
            'project_id' => $taskDetail->project_id,
            'board_id' => $taskDetail->board_id,
            'task_id' => $taskDetail->id,
            'type' => 'add_attachment',
            'message' => 'attachment added into task',
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );


        $attachmentData = DB::table('attachments')
                ->join('tasks', 'tasks.id', '=', 'attachments.task_id')
                ->join('users', 'users.id', '=', 'attachments.user_id')
                ->select('attachments.*', 'users.first_name', 'users.last_name', 'users.last_name')
                ->where('attachments.task_id', $taskId)
                ->get();

        return View::make('Boardsfront.ajax_attachments')->with('attachmentData', $attachmentData)->render();
        exit;
    }

    function downloadAttachment($filename = null) {
        set_time_limit(0);
        $file_path = UPLOAD_FULL_ATTACHMENT_IMAGE_PATH . "/" . $filename;

        return Response::download($file_path);
        exit;
    }

    function getVideo($id = null) {
        $attachmentInfo = DB::table('attachments')
                ->join('tasks', 'tasks.id', '=', 'attachments.task_id')
                ->join('users', 'users.id', '=', 'attachments.user_id')
                ->select('attachments.*', 'users.first_name', 'users.last_name', 'users.last_name')
                ->where('attachments.id', $id)
                ->first();

        //dd($attachmentInfo);

        return View::make('Boardsfront.ajax_get_video')->with('attachmentInfo', $attachmentInfo)->render();
        exit;
    }

    public function testwater() {
//   exec('/usr/bin/ffmpeg -i /home/securitas/public_html/img/uploads/temp/05e288db18015af97404bb32c0209bec.mp4 -i /home/securitas/public_html/img/front/logo.png -filter_complex "overlay" /home/securitas/public_html/img/uploads/water/outputpraveen.mp4');
//echo exec('/usr/bin/ffmpeg -y -i /home/securitas/public_html/img/uploads/temp/87f6d11d96eaab6b5a97e129bd65a8a2.mp4 -i /home/securitas/public_html/img/front/logo.png -filter_complex "overlay=10:10" /home/securitas/public_html/img/uploads/videos/test155.mp4 2>&1',$out,$ret);  print_r($out); exit;
        exec('/usr/bin/ffmpeg -i /home/securitas/public_html/img/uploads/temp/c9daba296d0ab43e18fe4be60877ccd8.mp4 -vcodec libx264 /home/securitas/public_html/img/uploads/water/pravefn.mp4 2>&1', $out, $ret);
//            exec('/usr/bin/ffmpeg -i /home/securitas/public_html/img/uploads/water/' . $video . ' -i /home/securitas/public_html/img/front/logo.png -filter_complex "overlay=10:10" /home/securitas/public_html/img/uploads/videos/' . $video . ' 2>&1', $out, $ret);
//        echo $ffmpeg_path = shell_exec('which ffmpeg');
//echo exec('/usr/bin/ffmpeg -y -i /home/securitas/public_html/img/uploads/videos/c9daba296d0ab43e18fe4be60877ccd8.mp4 -i /home/securitas/public_html/img/front/googleplay_logo.png -c:v libx264 -preset:v fast -profile:v baseline -filter_complex "overlay=10:10" /home/securitas/public_html/img/uploads/videos/test12.mp4 2>&1',$out,$ret); 
//        echo $ffmpeg_path = shell_exec('which ffmpeg');
//echo exec('/usr/bin/ffmpeg -y -i /home/securitas/public_html/img/uploads/videos/7f8f8dd2f1e159c6060d1d495e21748d.mp4 -i /home/securitas/public_html/img/front/googleplay_logo.png -c:v libx264 -preset:v fast -profile:v baseline -filter_complex "overlay=10:10" /home/securitas/public_html/img/uploads/videos/test12.mp4 2>&1',$out,$ret);  print_r($out); exit;
    }

    function deleteAttachment() {
        if (!Session::has('user_id')) {
            echo "error";
            exit;
        }
        $user_id = Session::get('user_id');


        $input = Input::all();
        if (!empty($input)) {
            $attachmentId = $input['id'];
        } else {
            return Redirect::to('/');
        }

        if (empty($attachmentId)) {
            echo '2';
            exit;
        }

        DB::table('attachments')->where('id', $attachmentId)->delete();

        echo 1;
        exit;
    }

    function displayProjectTaskSectionVisitor($slug = null) {  //Display Project Board task in Front Panel Pop Up
        $this->layout = View::make('layouts.default_front_project');
        $this->layout->title = TITLE_FOR_PAGES . ' Task Detail';

        $taskDetail = DB::table('tasks')
                        ->join('boards', 'boards.id', '=', 'tasks.board_id')
                        ->join('projects', 'projects.id', '=', 'boards.project_id')
                        ->select('tasks.*', 'boards.board_name as board_name', 'boards.slug as board_slug', 'boards.status as board_status', 'boards.board_position as board_position', 'projects.id as project_id', 'projects.user_id as project_user_id', 'projects.project_name as project_name', 'projects.slug as project_slug', 'projects.status as project_status')
                        ->where('tasks.slug', $slug)->first();

        if (empty($taskDetail)) {
            return Redirect::to('/');
        }
        $task_id = $taskDetail->id;


        return View::make('/Boardsfront/displayProjectTaskSectionVisitor')->with('taskDetail', $taskDetail);
    }

    function updateProjectInfo() {
        if (!Session::has('user_id')) {
            echo '2';
            exit;
        }
        $user_id = Session::get('user_id');

        $input = Input::all();
        if (!empty($input)) {
            $projectTransaction = $input['transaction'];
            $projectTransactionAmount = $input['transaction_amount'];
            $projectTransactionType = $input['transaction_type'];
            $projectId = $input['project_id'];
        } else {
            return Redirect::to('/');
        }

        if (empty($projectId)) {
            echo '2';
            exit;
        }

        $saveList = array(
            'transaction' => $projectTransaction,
            'transaction_amount' => $projectTransactionAmount,
            'transaction_type' => $projectTransactionType,
            'modified' => date('Y-m-d H:i:s')
        );


        $adminTasks = DB::table('projects')
                ->where('id', $projectId)
                ->update($saveList);

        $project = DB::table('projects')
                        ->where('id', $projectId)->first();

        return View::make('Boardsfront.ajax_project_info')->with('project', $project)->render();


        exit;
    }

    function updateTaskCheckBox() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');

        $input = Input::all();

        //dd($input); exit;
        if (!empty($input)) {
            $isChecked = isset($input['is_checked']) ? '1' : '0';
            $taskId = $input['task_id'];
            $checkedBy = $input['checked_by'];
        } else {
            return Redirect::to('/');
        }

        $saveList = array(
            'is_checked' => $isChecked,
//            'checked_by' => $checkedBy,
            'modified' => date('Y-m-d H:i:s')
        );

        $updatechecklistvalues = DB::table('tasks')
                ->where('id', $taskId)
                ->update($saveList);

        echo "1";
        exit;
    }

    function saveTaskReminder() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }

        $user_id = Session::get('user_id');
        $taskId = 0;
        $email_content = "";

        $input = Input::all();
//      echo "<pre>"; print_r($input); exit;

        if (!empty($input)) {
            $type = $input['type'];
            $title = $input['title'];
            $reminder_date = $input['reminder_date'];
            $reminder_time = $input['reminder_time'];
            $email_subject = $input['email_subject'];
            $email_content = $input['email_content'];
            $taskId = $input['task_id'];
            $userId = $input['user_id'];
        } else {
            echo "2";
            exit;
        }

        $finaldate = date('Y-m-d H:i:s', strtotime($input['reminder_date'] . " " . $input['reminder_time']));
        $todaydate = date('Y-m-d H:i:s');


        $saveList = array(
            'type' => $type,
            'title' => $title,
            'email_subject' => $email_subject,
            'email_content' => $email_content,
            'datetime' => $finaldate,
            'task_id' => $taskId,
            'user_id' => $userId,
            'status' => 1,
            'created' => date('Y-m-d H:i:s')
        );

        $reminderId = DB::table('reminders')
                ->insertGetId(
                $saveList
        );

        $listOfReminders = DB::table('reminders')
                ->where('task_id', $input['task_id'])
//                ->where('datetime', '>', $todaydate)
                ->select('reminders.*')
                ->orderBy('reminders.datetime', 'asc')
                ->limit(20)
                ->get();

         
         $taskDetail = DB::table('tasks')
                        ->select('tasks.*')
                        ->where('tasks.id', $taskId)->first();

        return View::make('Boardsfront.reminders_list')->with('tasks', $taskId)->with('listOfReminders', $listOfReminders)->with('taskDetail', $taskDetail)->render();
      
        exit;
    }
    
    
    function updateTaskReminder() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }

        $user_id = Session::get('user_id');
        $taskId = 0;
        $email_content = "";

        $input = Input::all();
//      echo "<pre>"; print_r($input); exit;


        if (!empty($input)) {
            $type = $input['type'];
            $title = $input['title'];
            $taskId = $input['task_id'];
            $reminder_id = $input['reminder_id'];
            $reminder_date = $input['reminder_date'];
            $reminder_time = $input['reminder_time'];
            $email_subject = $input['email_subject'];
            $email_content = $input['email_content'];
        } else {
            echo "2";
            exit;
        }

        $finaldate = date('Y-m-d H:i:s', strtotime($input['reminder_date'] . " " . $input['reminder_time']));
        $todaydate = date('Y-m-d H:i:s');


        $saveList = array(
            'type' => $type,
            'title' => $title,
            'email_subject' => $email_subject,
            'email_content' => $email_content,
            'datetime' => $finaldate,
            'status' => 1,
            'created' => date('Y-m-d H:i:s')
        );

       
        
        $updatechecklistvalues = DB::table('reminders')
                ->where('id', $reminder_id)
                ->update($saveList);

        $listOfReminders = DB::table('reminders')
                ->where('task_id', $input['task_id'])
                ->where('datetime', '>', $todaydate)
                ->select('reminders.*')
                ->orderBy('reminders.datetime', 'asc')
                ->limit(3)
                ->get();
        
         $taskDetail = DB::table('tasks')
                        ->select('tasks.*')
                        ->where('tasks.id', $taskId)->first();

        return View::make('Boardsfront.reminders_list')->with('tasks', $taskId)->with('listOfReminders', $listOfReminders)->with('taskDetail', $taskDetail)->render();
        exit;
    }
    
    function deleteTaskReminder() {
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');


        $input = Input::all();
        if (!empty($input)) {
            $commentId = $input['id'];
        } else {
            return Redirect::to('/');
        }

        if (empty($commentId)) {
            echo '2';
            exit;
        }

        DB::table('reminders')->where('id', $commentId)->delete();

        echo 1;
        exit;
    }
    
   

    function cronTaskReminder() {
//        $this->sendSMSTwi(); exit;
        
      $addonehour = date("Y-m-d H:i:s", strtotime("+3 minutes"));
     $minusonehour = date("Y-m-d H:i:s", strtotime("-3 minutes"));
//      exit;

        $listOfReminders = DB::table('reminders')
                ->join('tasks', 'tasks.id', '=', 'reminders.task_id')
                ->join('boards', 'boards.id', '=', 'tasks.board_id')
                ->join('projects', 'projects.id', '=', 'boards.project_id')
                ->where('reminders.status', '!=', 2)
                ->whereBetween('datetime', array($minusonehour, $addonehour))
                ->select('reminders.*', 'tasks.board_id',  'projects.slug as project_slug', 'projects.project_name as project_name', 'boards.slug as board_slug', 'boards.board_name as board_name', 'tasks.slug as task_slug', 'tasks.task_name as task_name' )
                ->orderBy('reminders.datetime', 'asc')
                ->get();
        
//      echo "<pre>"; print_r($listOfReminders); exit;
     

        if (!empty($listOfReminders)) {
            foreach ($listOfReminders as $listOfReminder) {
//                echo "asd";
                $membersArray = array();
                $link = "<a href=" . HTTP_PATH . "board/" . $listOfReminder->project_slug . "/" . $listOfReminder->board_slug . "/" . $listOfReminder->task_slug . ">Project: ".$listOfReminder->project_name.",  Task: ".$listOfReminder->task_name."</a>";
               

                $userData = DB::table('users')
                        ->where('id', $listOfReminder->user_id)
                        ->select('users.*')
                        ->first();

                $i = 0;
                if (!empty($userData)) {
                    $membersArray[$i]['id'] = $userData->id;
                    $membersArray[$i]['first_name'] = $userData->first_name;
                    $membersArray[$i]['last_name'] = $userData->last_name;
                    $membersArray[$i]['email_address'] = $userData->email_address;
                    $membersArray[$i]['contact'] = $userData->contact;
                }

                $invitedProjectUsers = DB::table('projectinvites')
                        ->join('users', 'users.id', '=', 'projectinvites.user_id')
                        ->where('board_id', $listOfReminder->board_id)
                        ->select('users.*')
                        ->get();

                if (!empty($invitedProjectUsers)) {
                    foreach ($invitedProjectUsers as $invitedProjectUser) {
                        $i++;
                        $membersArray[$i]['id'] = $invitedProjectUser->id;
                        $membersArray[$i]['first_name'] = $invitedProjectUser->first_name;
                        $membersArray[$i]['last_name'] = $invitedProjectUser->last_name;
                        $membersArray[$i]['email_address'] = $invitedProjectUser->email_address;
                        $membersArray[$i]['contact'] = $invitedProjectUser->contact;
                    }
                }

                
//                echo "<pre>"; print_r($membersArray); exit;

                if (!empty($membersArray)) {
                    foreach ($membersArray as $members) {
                        
//                         echo $listOfReminder->type;
                        
                        if ($listOfReminder->type == 1) {
                   
                            $username = $members['first_name'] . " " . $members['last_name'];
                            $emailAddress = $members['email_address'];
                            $emailContent = $listOfReminder->email_content;
                            $emailSubject = $listOfReminder->email_subject;

                            $mail_data = array(
                                'firstname' => $username,
                                'email_addr' => $emailAddress,
                                'text' => $emailContent,
                                'email_subj' => $emailSubject,
                                'link' => $link,
                            );

//echo "dsa";
//                            return View::make('emails.reminder')->with($mail_data); exit;// to check mail template data to view
                            Mail::send('emails.reminder', $mail_data, function($message) use ($mail_data) {
                                        $message->setSender(array(MAIL_FROM => SITE_TITLE));
                                        $message->setFrom(array(MAIL_FROM => SITE_TITLE));
                                        $message->to($mail_data['email_addr'], '')->subject($mail_data['email_subj']);
                                    });
                        }else{
//echo$members['contact'];
                            if(!empty($members['contact'])){
                                echo "sda";
                                $this->sendSMSTwi("+".$members['contact'], $listOfReminder->email_subject);
                            }
                        }
                    }
                }
                
                
//                exit;
                  
                
                 $data = array(
                    'status' => 2,
                    'modified' => date('Y-m-d H:i:s'),
                );


                DB::table('reminders')
                        ->where('id', $listOfReminder->id)
                        ->update($data);
            }
        }

        exit;
    }

    function saveProjectTaskReminders() {       //Add  Project -> Boards -> Task Front Panel
        if (!Session::has('user_id')) {
            return Redirect::to('/login');
        }
        $user_id = Session::get('user_id');
        $taskId = 0;

        $input = Input::all();
        if (!empty($input)) {
            $taskName = $input['task_name'];
            $slug = $this->createUniqueSlug($taskName, 'tasks');
            $boardId = $input['board_id'];
        } else {
            return Redirect::to('/');
        }

        $lastTaskDetail = DB::table('tasks')
                ->where('tasks.board_id', $boardId)
                ->orderBy('tasks.id', 'desc')
                ->first();

        if (empty($lastTaskDetail)) {
            $lastTaskId = 1;
        } else {
            $lastTaskId = $lastTaskDetail->task_position + 1;
        }

        $saveList = array(
            'task_name' => $taskName,
            'board_id' => $boardId,
            'task_position' => $lastTaskId,
            'status' => '1',
            'slug' => $slug,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        );

        $tasks = DB::table('tasks')
                ->insertGetId(
                $saveList
        );

        $boardData = DB::table('boards')
                ->join('projects', 'projects.id', '=', 'boards.project_id')
                ->select('boards.*', 'projects.user_id as user_id')
                ->where('boards.id', $boardId)
                ->first();


        $saveListActivity = array(
            'user_id' => $boardData->user_id,
            'project_id' => $boardData->project_id,
            'board_id' => $boardData->id,
            'task_id' => $tasks,
            'type' => 'create_task',
            'message' => 'created task into board',
            'status' => '1',
            'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        DB::table('activities')->insert(
                $saveListActivity
        );

        $invitedProjectUsers = DB::table('projectinvites')
                ->join('users', 'users.id', '=', 'projectinvites.user_id')
                ->where('project_id', $boardData->project_id)
                ->select('users.*')
                ->get();

        $newKey = sizeof($invitedProjectUsers);
        $userssInfoo = DB::table('users')
                ->where('id', $boardData->user_id)
                ->first();

        $invitedProjectUsers[$newKey] = $userssInfoo;


        if ($invitedProjectUsers) {
            foreach ($invitedProjectUsers as $userssInfo) {
                if ($userssInfo->turn_off_notification == 0) {
                    $saveListNotification = array(
                        'user_id' => $userssInfo->id,
                        'project_id' => $boardData->project_id,
                        'board_id' => $boardData->id,
                        'task_id' => $tasks,
                        'type' => 'add_task',
                        'status' => '1',
                        'slug' => $this->createUniqueSlug(mt_rand(9999999, 99999999), 'activities'),
                        'created' => date('Y-m-d H:i:s'),
                        'modified' => date('Y-m-d H:i:s'),
                    );
                    $notiId = DB::table('notifications')->insertGetId(
                            $saveListNotification
                    );
                    $this->sendEmail($notiId);
                }
            }
        }

        $allProjectLists = DB::table('projects')
                ->where('status', 1)
                ->where('user_id', $boardData->user_id)
                ->orderby('id', 'DESC')
                ->get();

        $array_project[null] = "Select Project";
        foreach ($allProjectLists as $allProjectList) {
            $array_project[$allProjectList->id] = $allProjectList->project_name;
        }

        $project = DB::table('projects')
                        ->where('id', $boardData->project_id)->first();

        return View::make('Boardsfront.ajax_add_task')->with('tasks', $tasks)->with('board', $boardData)->with('array_project', $array_project)->with('project', $project)->render();

        exit;
    }

}

