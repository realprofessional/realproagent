<?php

namespace App\Http\Controllers;

use App\User;
use App\AdminBoard;
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

class AdminBoardController extends BaseController {
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

    public function showproject() {   //Admin Default Project Listing

        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

       
        $this->layout = View::make('layouts.adminlayout');
        
        $projects = DB::table('adminprojects')
                ->where('status', 1)
                ->orderby('id', 'desc')
                ->paginate(20);
        //dump($projects);
        $this->layout->content = View::make('AdminBoards.project')->with('project', $projects);
        $this->layout->title = TITLE_FOR_PAGES . 'Admin Default Projects';
    }

    public function showaddproject() {  //Admin Add Default Project 
        $input = Input::all();
        if (!empty($input)) {
            $rules = array(
                'project_name' => 'required', // make sure the first name field is not empty
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {
                return Redirect::to('/adminboards/project')->withErrors($validator)->withInput(Input::all());
            } else {
                $slug = $this->createUniqueSlug($input['project_name'], 'adminprojects');
                $saveUser = array(
                    'project_name' => $input['project_name'],
                    'status' => '1',
                    'slug' => $slug,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                );
                DB::table('adminprojects')->insert(
                        $saveUser
                );


                $id = DB::getPdo()->lastInsertId();

               $projectInfo = DB::table('adminprojects')
                                ->where('id', $id)->first();

                return Redirect::to('/admin/adminboards/list/' . $projectInfo->slug)->with('success_message', 'Project saved successfully.');
            }
        }
    }

    public function showAdmin_index($slug = null) {     //Admin Default Project Board Listing
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        //echo $slug; exit;
        
        $project = DB::table('adminprojects')
                        ->where('slug', $slug)->first();

        if (empty($project)) {
            return Redirect::to('/admin/admindashboard');
        }
        $project_id = $project->id;
        
        
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
        $query = AdminBoard::sortable()
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

//        $query->join('admintasks', 'adminboards.id', '=', 'admintasks.board_id')
//        ->select('adminboards.*','admintasks.task_name');

        $separator = implode("/", $separator);

        // Get all the users
        $adminboards = $query->orderBy('id', 'desc')->sortable()->paginate(200);


//        $comments = AdminBoard::find(5)->admintasks;
        //echo "<pre>"; print_r($comments); exit;
        // Show the page
        return View::make('AdminBoards/adminindex', compact('adminboards'))->with('search_keyword', $search_keyword)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('searchByDateTo', $searchByDateTo)
                        ->with('project', $project);
    }

    function showAdmin_saveAdminBoard() {   //Admin Add Default Project -> Board
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        $input = Input::all();
        if (!empty($input)) {
            $boardName = $input['board_name'];
            $projectId = $input['project_id'];
            $slug = $this->createUniqueSlug($boardName, 'adminboards');
        }

        $saveList = array(
            'board_name' => $boardName,
            'project_id' => $projectId,
            'status' => '1',
            'slug' => $slug,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        );

        $adminBoards = DB::table('adminboards')
                ->insert(
                $saveList
        );
        echo '1';
        exit;
    }

    function showAdmin_saveAdminTask() {        //Admin Add Default Project -> Board -> Task
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        $taskId = 0;

        $input = Input::all();
        if (!empty($input)) {
            $taskName = $input['task_name'];
            $slug = $this->createUniqueSlug($taskName, 'admintasks');
            $boardId = $input['board_id'];
        } else {
            return Redirect::to('/');
        }


        $saveList = array(
            'task_name' => $taskName,
            'board_id' => $boardId,
            'status' => '1',
            'slug' => $slug,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        );

        $adminTasks = DB::table('admintasks')
                ->insertGetId(
                $saveList
        );

        return View::make('AdminBoards.ajax_add_task')->with('adminTasks', $adminTasks)->render();
        exit;
    }

    function showAdmin_updateAdminTask() {       //Admin Update Default Project -> Board -> Task
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


        $adminBoards = DB::table('admintasks')
                ->where('id', $taskId)
                ->update($saveList);

        echo 1;
        exit;
    }

    function showAdmin_updateAdminBoard() {     //Admin Update Default Project -> Board
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


        $adminTasks = DB::table('adminboards')
                ->where('id', $boardId)
                ->update($saveList);

        echo 1;
        exit;
    }

    function showAdmin_deleteAdminTask() {      //Admin Delete Default Project -> Board -> Task
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

        DB::table('admintasks')->where('id', $taskId)->delete();

        echo 1;
        exit;
    }

    function showAdmin_deleteAdminBoard() {     //Admin Delete Default Project -> Board
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

        DB::table('adminboards')->where('id', $boardId)->delete();
        DB::table('admintasks')->where('board_id', $boardId)->delete();

        echo 1;
        exit;
    }
    
    
    function showAdmin_displayProjectTaskSection($slug = null) {        //Admin View Default Project -> Board -> Task Pop Up Data

        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }
        $input = Input::all();

        $taskDetail = DB::table('admintasks')
                        ->join('adminboards', 'adminboards.id', '=', 'admintasks.board_id')
                        ->join('adminprojects', 'adminprojects.id', '=', 'adminboards.project_id')
                        ->select('admintasks.*', 'adminboards.board_name as board_name', 'adminboards.slug as board_slug', 'adminboards.status as board_status', 'adminprojects.project_name as project_name', 'adminprojects.slug as project_slug', 'adminprojects.status as project_status')
                        ->where('admintasks.slug', $slug)->first();


        if (empty($taskDetail)) {
            return Redirect::to('/admin/adminboards/projects');
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
            return View::make('/AdminBoards/admin_displayProjectTaskSection')->with('taskDetail', $taskDetail);
        }
    }
    
    
    function addTaskChecklist() {           //Admin Add Task Checklist for Admin Boards
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        $taskId = 0;

        $input = Input::all();

        //dd($input); exit;
        if (!empty($input)) {
            $checkboxTitle = $input['checkbox_title'];
            $slug = $this->createUniqueSlug($checkboxTitle, 'adminchecklists');
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

        $checklists = DB::table('adminchecklists')
                ->insertGetId(
                $saveList
        );

        return View::make('AdminBoards.ajax_add_checklist')->with('checklists', $checklists)->render();
        exit;
    }

    function addTaskChecklistValue() {          //Admin Add Task Checklist Values for Admin Boards
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        $taskId = 0;

        $input = Input::all();

        //dd($input); exit;
        if (!empty($input)) {
            $checkboxValue = $input['checkbox_value'];
            $slug = $this->createUniqueSlug($checkboxValue, 'adminchecklistvalues');
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

        $checklistvalues = DB::table('adminchecklistvalues')
                ->insertGetId(
                $saveList
        );


        $checkBoxListValueDatas = DB::table('adminchecklistvalues')->where('checklist_id', $checklistId)->get();

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

        return View::make('AdminBoards.ajax_add_checklistvalue')->with('checklistvalues', $checklistvalues)->with('percentage', $percentage)->render();
        exit;
    }

    function updateTaskChecklistValueBox() {        //Admin Update Task Checklist Values for Admin Boards
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

        $updatechecklistvalues = DB::table('adminchecklistvalues')
                ->where('id', $checklistValueId)
                ->update($saveList);

        $checkBoxListValueDatas = DB::table('adminchecklistvalues')->where('checklist_id', $checkedListId)->get();

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

    function deleteProjectBoardTaskChecklist() {        //Admin Delete Task Checklist for Admin Boards
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

        $mainDetail = DB::table('adminchecklists')
                ->where('adminchecklists.id', $checkListId)
                ->first();

        $taskId = $mainDetail->task_id;

        DB::table('adminchecklists')->where('id', $checkListId)->delete();
        DB::table('adminchecklistvalues')->where('checklist_id', $checkListId)->delete();

        echo 1;
        exit;
    }

    function addTaskDueDate() {     //Admin Add Task Due Date for Admin Boards
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


        $boards = DB::table('admintasks')
                ->where('id', $taskId)
                ->update($saveList);

        $due_date_text = date("M d \a\\t H:i A", strtotime($due_date));

        echo "<div class='due-dttt'> <span class='due_head'>Due Date </span>
                <span class='due-date_text'>" . $due_date_text . "</span>
              </div>";
        exit;
    }

    function removeTaskDueDate() {      //Admin Remove Task Due Date for Admin Boards
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


        $boards = DB::table('admintasks')
                ->where('id', $taskId)
                ->update($saveList);

        echo "1";
        exit;
    }
    
    function showAdmin_updateAdminTaskDescriptionData() {       //Admin Update Task Description for Admin Boards
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


        $boards = DB::table('admintasks')
                ->where('id', $taskId)
                ->update($saveList);

        echo 1;
        exit;
    }
    
    function displayProjectTaskSection($slug = null) {      //Admin Display Project Task Section for Front End while Grabbing

        
        $input = Input::all();

        $taskDetail = DB::table('admintasks')
                        ->join('adminboards', 'adminboards.id', '=', 'admintasks.board_id')
                        ->join('adminprojects', 'adminprojects.id', '=', 'adminboards.project_id')
                        ->select('admintasks.*', 'adminboards.board_name as board_name', 'adminboards.slug as board_slug', 'adminboards.status as board_status', 'adminprojects.project_name as project_name', 'adminprojects.slug as project_slug', 'adminprojects.status as project_status')
                        ->where('admintasks.slug', $slug)->first();


        if (empty($taskDetail)) {
            return Redirect::to('/admin/adminboards/projects');
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
            return View::make('/AdminBoards/displayProjectTaskSection')->with('taskDetail', $taskDetail);
        }
    }
    
    
    function updateAdminProjectSection() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }
        
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


        $adminTasks = DB::table('adminprojects')
                ->where('id', $projectId)
                ->update($saveList);

        echo 1;
        exit;
    }
    
    public function showAdmin_deleteproject($slug = null) {     //Admin Delete Default Project 
        if (!empty($slug)) {
            DB::table('adminprojects')->where('slug', $slug)->delete();
            return Redirect::to('/admin/adminboards/project')->with('success_message', 'Project deleted successfully');
        }
    }

}
