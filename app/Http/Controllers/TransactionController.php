<?php

namespace App\Http\Controllers;

use App\User;
use App\Transaction;
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

class TransactionController extends BaseController {
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
        $query = Transaction::sortable()
                ->where(function ($query) use ($search_keyword) {
                    $query->where('type', 'LIKE', '%' . $search_keyword . '%');
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
                    DB::table('transactions')
                            ->whereIn('id', $idList)
                            ->update(array('status' => 1));

                    Session::put('success_message', 'Transaction Type(s) activated successfully');
                    break;

                case "Deactivate":
                    DB::table('transactions')
                            ->whereIn('id', $idList)
                            ->update(array('status' => 0));
                    Session::put('success_message', 'Transaction Type(s) deactivated successfully');
                    break;
            }
        }

        $separator = implode("/", $separator);

        // Get all the users
        $transactions = $query->orderBy('id', 'desc')->sortable()->paginate(10);

        // Show the page
        return View::make('Transaction/adminindex', compact('transactions'))->with('search_keyword', $search_keyword)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('searchByDateTo', $searchByDateTo);
    }

    public function showAdmin_add() {       //Add User in Admin Panel
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        $input = Input::all();
        if (!empty($input)) {
            $rules = array(
                'type' => 'required|unique:transactions', // make sure the first name field is not empty
            );


            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/admin/transaction/addType')->withErrors($validator)->withInput(Input::all());
            } else {
                $slug = $this->createUniqueSlug($input['type'], 'transactions');
                $saveTransaction = array(
                    'type' => $input['type'],
                    'status' => '1',
                    'slug' => $slug,
                    'created' => date('Y-m-d H:i:s'),
                );
                DB::table('transactions')->insert(
                        $saveTransaction
                );
                $id = DB::getPdo()->lastInsertId();


                return Redirect::to('/admin/transaction/list')->with('success_message', 'Transaction Type saved successfully.');
            }
        } else {
            return View::make('/Transaction/admin_add');
        }
    }

    public function showAdmin_edit($slug = null) {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }
        $input = Input::all();

        $transaction = DB::table('transactions')
                        ->where('slug', $slug)->first();

        if (empty($transaction)) {
            return Redirect::to('/admin/transaction/list');
        }
        $transaction_id = $transaction->id;


        if (!empty($input)) {
            $rules = array(
                'type' => 'required|unique:transactions', // make sure the first name field is not empty
            );


            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/admin/transaction/editType/' . $transaction->slug)
                                ->withErrors($validator) // send back all errors
                                ->withInput(Input::all());
            } else {

                $data = array(
                    'type' => $input['type'],
                    'modified' => date('Y-m-d H:i:s'),
                );

                DB::table('transactions')
                        ->where('id', $transaction_id)
                        ->update($data);

                return Redirect::to('/admin/transaction/list')->with('success_message', 'Transaction Type updated successfully.');
            }
        } else {



            return View::make('/Transaction/admin_edit')->with('detail', $transaction);
        }
    }

    public function showAdmin_active($slug = null) {        //Activate User from Admin Panel
        if (!empty($slug)) {

            DB::table('transactions')
            ->where('slug', $slug)
            ->update(['status' => 1]);

            return Redirect::back()->with('success_message', 'Transaction Type activated successfully');
        }
    }

    public function showAdmin_deactive($slug = null) {       //Dectivate User from Admin Panel
        if (!empty($slug)) {
            DB::table('transactions')
            ->where('slug', $slug)
            ->update(['status' => 0]);

            return Redirect::back()->with('success_message', 'Transaction Type deactivated successfully');
        }
    }


  

}
