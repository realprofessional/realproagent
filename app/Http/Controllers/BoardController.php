<?php

namespace App\Http\Controllers;
//use Moltin\Cart\Cart;
//use Moltin\Cart\Storage\CartSession;
//use Moltin\Cart\Identifier\Cookie;

use App\User;
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

class BoardController extends BaseController {
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

    public function showAdmin_index() {             //Admin User Boards
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
        $query = Board::sortable()
                ->where(function ($query) use ($search_keyword) {
                    $query->where('board_name', 'LIKE', '%' . $search_keyword . '%');
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
        }

        $separator = implode("/", $separator);

        // Get all the users
        $users = $query->orderBy('id', 'desc')->sortable()->paginate(10);

        // Show the page
        return View::make('AdminBoards/adminindex', compact('users'))->with('search_keyword', $search_keyword)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('searchByDateTo', $searchByDateTo);
    }

    function showAdmin_saveAdminBoard() {        //Admin Save User Board
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        $input = Input::all();
        if (!empty($input)) {
            $boardName = $input['board_name'];
            $slug = $this->createUniqueSlug($boardName, 'adminboards');
        }

        $saveList = array(
            'board_name' => $boardName,
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
    
   

}
