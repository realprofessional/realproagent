<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
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
use App\Classes\ImageManipulator;
use App\Classes\facebook\facebook;
use App\Classes\google\Google_Client;
use App\Classes\google\Google_Oauth2Service;
use Illuminate\Http\Request;

class ProjectController extends BaseController {
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

    public function showAdmin_index() {
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
        $query = Project::sortable()
                ->where(function ($query) use ($search_keyword) {
                    $query->where('projects.project_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('users.first_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('users.last_name', 'LIKE', '%' . $search_keyword . '%')
                    ->orwhere('users.email_address', 'LIKE', '%' . $search_keyword . '%');
                });


        if (!empty($input['from_date'])) {
            $query = $query->whereDate('projects.created', '>=', date('Y-m-d H:i:s', strtotime($searchByDateFrom)));
        }

        if (!empty($input['to_date'])) {
            $query = $query->whereDate('projects.created', '<=', date('Y-m-d H:i:s', strtotime($searchByDateTo)));
        }


        if (!empty($input['action'])) {
            $action = $input['action'];
            $idList = $input['chkRecordId'];
            switch ($action) {
                case "Activate":
                    DB::table('projects')
                            ->whereIn('projects.id', $idList)
                            ->update(array('status' => 1));

                    Session::put('success_message', 'Project(s) activated successfully');
                    break;
                case "Deactivate":
                    DB::table('projects')
                            ->whereIn('projects.id', $idList)
                            ->update(array('status' => 0));
                    Session::put('success_message', 'Project (s) deactivated successfully');
                    break;
                case "Delete":
                    DB::table('projects')
                            ->whereIn('projects.id', $idList)
                            ->delete();
                    Session::put('success_message', 'Project (s) deleted successfully');
                    break;
            }
        }

        $separator = implode("/", $separator);
        // print_r($query); exit;
        // Get all the projects
        $projects = $query->join('users', 'users.id', '=', 'projects.user_id')->select('projects.*', 'users.status as user_status', 'users.slug as user_slug', 'users.id as user_tbid', 'users.first_name as first_name', 'users.last_name as last_name', 'users.email_address as email_address')->orderBy('projects.id', 'desc')->sortable()->paginate(10);

        //echo "<pre>"; print_r($projects); exit;
        // Show the page
        return View::make('Projects/adminindex', compact('projects'))->with('search_keyword', $search_keyword)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('searchByDateTo', $searchByDateTo);
    }

    public function showAdmin_add() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        $users = DB::table('users')
                ->where('activation_status', 1)
                ->where('status', 1)
                ->orderby('first_name', 'ASC')
                ->get();
        foreach ($users as $user) {
            $array_user[$user->id] = ucwords($user->first_name) . ' ' . ucwords($user->last_name);
        }
        
        $transactions = DB::table('transactions')
                ->where('status', 1)
                ->orderby('type', 'ASC')
                ->get();
        foreach ($transactions as $transaction) {
            $array_transaction[$transaction->id] = ucwords($transaction->type);
        }

        $input = Input::all();
        if (!empty($input)) {
            $rules = array(
                'project_name' => 'required', // make sure the first name field is not empty
                'user_id' => 'required', // make sure the last name field is not empty
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
                return Redirect::to('/admin/projects/adduser')->withErrors($validator)->withInput(Input::all());
            } else {
                $slug = $this->createUniqueSlug($input['project_name'], 'projects');
                $saveUser = array(
                    'project_name' => $input['project_name'],
                    'user_id' => $input['user_id'],
                    'transaction' => $input['transaction'],
                    'transaction_amount' => $input['transaction_amount'],
                    'transaction_type' => $input['transaction_type'],
                    'status' => '1',
                    'slug' => $slug,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                );
                DB::table('projects')->insert(
                        $saveUser
                );
                $id = DB::getPdo()->lastInsertId();

                return Redirect::to('/admin/projects/list')->with('success_message', 'Project saved successfully.');
            }
        } else {
            return View::make('/Projects/admin_add')->with('users', $array_user)->with('transactionsArr', $array_transaction);
        }
    }

    public function showAdmin_editproject($slug = null) {

        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }
        $input = Input::all();

        $users = DB::table('users')
                ->where('activation_status', 1)
                ->where('status', 1)
                ->orderby('first_name', 'ASC')
                ->get();
        foreach ($users as $user) {
            $array_user[$user->id] = ucwords($user->first_name) . ' ' . ucwords($user->last_name);
        }
        
         $transactions = DB::table('transactions')
                ->where('status', 1)
                ->orderby('type', 'ASC')
                ->get();
        foreach ($transactions as $transaction) {
            $array_transaction[$transaction->id] = ucwords($transaction->type);
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
                'transaction' => 'required', // make sure the last name field is not empty
                'transaction_amount' => 'required', // make sure the last name field is not empty
                'transaction_type' => 'required', // make sure the last name field is not empty
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
                    'transaction' => $input['transaction'],
                    'transaction_amount' => $input['transaction_amount'],
                    'transaction_type' => $input['transaction_type'],
                    'modified' => date('Y-m-d H:i:s'),
                );


                DB::table('projects')
                        ->where('id', $project_id)
                        ->update($data);

                return Redirect::to('/admin/projects/list')->with('success_message', 'Project details updated successfully.');
            }
        } else {

            return View::make('/Projects/admin_editproject')->with('detail', $project)->with('users', $array_user)->with('transactionsArr', $array_transaction);
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

    public function showAdmin_board($slug = null) {

        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        $project = DB::table('projects')
                        ->where('slug', $slug)->first();

        if (empty($project)) {
            return Redirect::to('/admin/user/userlist');
        }
        $project_id = $project->id;


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
        $boards = $query->orderBy('board_position', 'asc')->sortable()->paginate(200);


//        $comments = Board::find(5)->admintasks;
        //echo "<pre>"; print_r($comments); exit;
        // Show the page
        return View::make('Boards/adminindex', compact('boards'))->with('search_keyword', $search_keyword)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('array_project', $array_project)
                        ->with('project', $project);
    }

    function showAdmin_saveAdminProjectBoard() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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
        $array_project[null] = "Select Project";
        foreach ($allProjectLists as $allProjectList) {
            $array_project[$allProjectList->id] = $allProjectList->project_name;
        }


        return View::make('Boards.ajax_update_add_board')->with('board', $boardData)->with('project', $projectData)->with('array_project', $array_project)->render();
        //echo '1';
        exit;
    }

    function showAdmin_saveAdminProjectTask() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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

        return View::make('Boards.ajax_add_task')->with('tasks', $tasks)->with('board', $boardData)->with('array_project', $array_project)->with('project', $project)->render();
        exit;
    }

    function showAdmin_updateAdminProjectTask() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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

    function showAdmin_updateAdminProjectBoard() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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

    function showAdmin_deleteAdminProjectTask() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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

        echo 1;
        exit;
    }

    function showAdmin_deleteAdminProjectBoard() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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

        echo 1;
        exit;
    }

    function showAdmin_displayProjectTaskSection($slug = null) {

        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }
        $input = Input::all();

        $taskDetail = DB::table('tasks')
                        ->join('boards', 'boards.id', '=', 'tasks.board_id')
                        ->join('projects', 'projects.id', '=', 'boards.project_id')
                        ->select('tasks.*', 'boards.board_name as board_name', 'boards.slug as board_slug', 'boards.status as board_status', 'boards.board_position as board_position', 'projects.project_name as project_name', 'projects.user_id as user_id', 'projects.slug as project_slug', 'projects.status as project_status')
                        ->where('tasks.slug', $slug)->first();

        if (empty($taskDetail)) {
            return Redirect::to('/admin/projects/list');
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
            return View::make('/Boards/admin_displayProjectTaskSection')->with('taskDetail', $taskDetail);
        }
    }

    function showAdmin_updateAdminTaskDescriptionData() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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

    function showAdmin_copyAdminProjectTask() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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



        return View::make('Boards.ajax_update_copied_board')->with('board', $boardData)->with('project', $boardProjectDetail)->with('array_project', $array_project)->render();
        exit;
    }

    function showAdmin_getAdminUserProjects() {
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

        return View::make('Boards.ajax_get_board')->with('array_board', $array_board)->with('task_id', $task_id)->render();
    }

    function showAdmin_getAdminUserTaskPosition() {
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

        return View::make('Boards.ajax_get_position')->with('array_position', $array_position)->with('task_id', $task_id)->render();
    }

    function showAdmin_moveAdminProjectTask() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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
            return Redirect::to('/');
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



        return View::make('Boards.ajax_update_copied_board')->with('board', $boardData)->with('project', $boardProjectDetail)->with('array_project', $array_project)->render();
        exit;
    }

    function showAdmin_getAdminUserMoveProjects() {
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

        return View::make('Boards.ajax_get_board_for_move')->with('array_board', $array_board)->with('task_id', $task_id)->render();
    }

    function showAdmin_getAdminUserMoveTaskPosition() {
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

        return View::make('Boards.ajax_get_position_for_move')->with('array_position', $array_position)->with('task_id', $task_id)->render();
    }

    function showAdmin_copyAdminProjectBoard() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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

        return View::make('Boards.ajax_update_add_board')->with('board', $boardData)->with('project', $boardProjectDetail)->with('array_project', $array_project)->render();
        exit;
    }

    function showAdmin_getAdminUserMoveBoardPositionForCopy() {
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

        return View::make('Boards.ajax_get_position_for_copy_board')->with('array_position', $array_position)->with('board_id', $board_id)->render();
    }

    function showAdmin_getAdminUserMoveBoardPositionForMove() {
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

        return View::make('Boards.ajax_get_position_for_move_board')->with('array_position', $array_position)->with('board_id', $board_id)->render();
    }

    function showAdmin_moveAdminProjectBoard() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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


        return View::make('Boards.ajax_update_add_board')->with('board', $boardData)->with('project', $boardProjectDetail)->with('array_project', $array_project)->render();
        exit;
    }

    function addTaskChecklist() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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

    function addTaskDueDate() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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

        return View::make('Boards.ajax_add_comment')->with('commentList', $commentData)->render();
        exit;
    }

    function editTaskCommentValue() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }


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

    public function inviteUser($slug = null) {

        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }
        $input = Input::all();

        $project = DB::table('projects')
                        ->where('slug', $slug)->first();

        $users = DB::table('users')
                ->where('activation_status', 1)
                ->where('status', 1)
                ->where('id', '!=', $project->user_id)
                ->orderby('first_name', 'ASC')
                ->get();
        foreach ($users as $user) {
            $array_user[$user->id] = ucwords($user->first_name) . ' ' . ucwords($user->last_name) . ' (' . $user->email_address . ') ';
        }



        if (empty($project)) {
            return Redirect::to('/admin/user/userlist');
        }
        $project_id = $project->id;


        if (!empty($input)) {
            //dd($input); exit;

            $rules = array(
                'type' => 'required', // make sure the first name field is not empty
            );


            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/admin/projects/Admin_editproject/' . $project->slug)
                                ->withErrors($validator) // send back all errors
                                ->withInput(Input::all());
            } else {

                $type = $input['type'];
                $userId = $input['user_id'];
                $emailAddress = $input['email_address'];



                if ($type == '2') {
                    $checkInviteUser = DB::table('invites')
                            ->where('email_address', $emailAddress)
                            ->where('project_id', $project_id)
                            ->first();

                    $checkUser = DB::table('users')
                            ->where('email_address', $input['email_address'])
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
                            'email_address' => $emailAddress,
                            'status' => 1,
                            'join_status' => 0,
                            'created' => date('Y-m-d H:i:s'),
                        );

                        $invitess = DB::table('invites')
                                ->insertGetId(
                                $data
                        );


                        $reset_link = HTTP_PATH . "joinproject/" . $invitess . "/" . $emailAddress . "/" . $slug;


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

                        return Redirect::to('/admin/projects/inviteUser/' . $project->slug)->with('success_message', 'User Invited Succesfully.');
                    } else {
                        return Redirect::to('/admin/projects/inviteUser/' . $project->slug)->with('error_message', 'User already invited for this project.');
                    }
                } else {
                    $checkUser = DB::table('users')
                            ->where('id', $userId)
                            ->first();

                    if (!empty($checkUser)) {
                        $emailAddress = $checkUser->email_address;
                        $username = $checkUser->first_name . " " . $checkUser->last_name;
                    } else {
                        $emailAddress = $input['email_address'];
                        $usernameArr = explode('@', $emailAddress);
                        $username = $usernameArr[0];
                    }

                    $checkInviteUser = DB::table('invites')
                            ->where('email_address', $emailAddress)
                            ->orwhere('id', $userId)
                            ->where('project_id', $project_id)
                            ->first();

                    if (empty($checkInviteUser)) {
                        $data = array(
                            'user_id' => $userId,
                            'project_id' => $project_id,
                            'email_address' => $emailAddress,
                            'status' => 1,
                            'join_status' => 0,
                            'created' => date('Y-m-d H:i:s'),
                        );

                        $invitess = DB::table('invites')
                                ->insertGetId(
                                $data
                        );


                        $reset_link = HTTP_PATH . "joinproject/" . $invitess . "/" . $emailAddress . "/" . $slug;

                        // send email to administrator
                        $mail_data = array(
                            'firstname' => $username,
                            'email_addr' => $emailAddress,
                            'text' => 'Your have been invited to a Project on Taskboard. Please join project from below link.',
                            'resetLink' => '<a href="' . $reset_link . '">Click here<a> to Join.'
                        );

                        // return View::make('emails.template')->with($mail_data); // to check mail template data to view
                        Mail::send('emails.template', $mail_data, function($message) use ($mail_data) {
                                    $message->setSender(array(MAIL_FROM => SITE_TITLE));
                                    $message->setFrom(array(MAIL_FROM => SITE_TITLE));
                                    $message->to($mail_data['email_addr'], '')->subject('You are Invited to Join' . SITE_TITLE);
                                });

                        return Redirect::to('/admin/projects/inviteUser/' . $project->slug)->with('success_message', 'User Invited Succesfully.');
                    } else {
                        return Redirect::to('/admin/projects/inviteUser/' . $project->slug)->with('error_message', 'User already invited for this project.');
                    }
                }
            }
        } else {

            return View::make('/Projects/inviteuser')->with('detail', $project)->with('users', $array_user);
        }
    }

    function addAttachment() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

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

        $attachmentData = DB::table('attachments')
                ->join('tasks', 'tasks.id', '=', 'attachments.task_id')
                ->join('users', 'users.id', '=', 'attachments.user_id')
                ->select('attachments.*', 'users.first_name', 'users.last_name', 'users.last_name')
                ->where('attachments.task_id', $taskId)
                ->get();
        
        //dd($attachmentData); exit;

        return View::make('Boards.ajax_attachments')->with('attachmentData', $attachmentData)->render();
        exit;
    }
    
    function deleteAttachment() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }


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

}
