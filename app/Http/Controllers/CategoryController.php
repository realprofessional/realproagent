<?php
namespace App\Http\Controllers;
use Moltin\Cart\Cart;
use Moltin\Cart\Storage\CartSession;
use Moltin\Cart\Identifier\Cookie;

use App\Category;
use Session;
use Redirect;
use View;
use Input;
use Validator;
use DB;
use Mail;


class CategoryController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Category Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'CategoryController@showWelcome');
      |
     */
    
    protected $layout = 'layouts.default';
    
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
        $query = Category::sortable()
                ->where(function ($query) use ($search_keyword) {
            $query->where('name', 'LIKE', '%' . $search_keyword . '%');
        });
        if (!empty($input['action'])) {
            $action = $input['action'];
            $idList = $input['chkRecordId'];
            switch ($action) {
                case "Activate":
                    DB::table('categories')
                            ->whereIn('id', $idList)
                            ->update(array('status' => 1));

                    Session::put('success_message', 'Category(s) activated successfully');
                    break;
                case "Deactivate":
                    DB::table('categories')
                            ->whereIn('id', $idList)
                            ->update(array('status' => 0));
                    Session::put('success_message', 'Category(s) deactivated successfully');
                    break;
                case "Delete":
                    DB::table('categories')
                            ->whereIn('id', $idList)
                            ->delete();
                    Session::put('success_message', 'Category(s) deleted successfully');
                    break;
            }
        }

        $separator = implode("/", $separator);

        // Get all the users
        $categories = $query->orderBy('id', 'desc')->sortable()->paginate(10);
        
        // Show the page
        return View::make('Categories/adminindex', compact('categories'))->with('search_keyword', $search_keyword)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('searchByDateTo', $searchByDateTo);
    }
    
    public function showAdmin_add() {
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        $input = Input::all();
        if (!empty($input)) {
            $name = trim($input['name']);
            $rules = array(
                'name' => 'required|unique:categories', // make sure the first name field is not empty
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/admin/categories/admin_add')->withErrors($validator)->withInput(Input::all());
            } else {

                $slug = $this->createUniqueSlug($name, 'categories');
                $saveCities = array(
                    'name' => $name,
                    'parent_id' => '0',
                    'slug' => $slug,
                    'status' => '1',
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                );
                DB::table('categories')->insert(
                        $saveCities
                );

                return Redirect::to('/admin/categories/admin_index')->with('success_message', 'Category saved successfully.');
            }
        } else {
            return View::make('/Categories/admin_add');
        }
    }

    public function showAdmin_editcategory($slug = null) {

        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }
        $input = Input::all();

        $category = DB::table('categories')
                        ->where('slug', $slug)->first();
        $category_id = $category->id;


        if (!empty($input)) {
            $rules = array(
                'name' => "required|unique:categories,name," . $category_id, // make sure the first name field is not empty
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/admin/categories/Admin_editcity/' . $category->slug)
                                ->withErrors($validator)->withInput(Input::all());
            } else {

                $data = array(
                    'name' => $input['name'],
                    'status' => '1',
                    'created' => date('Y-m-d H:i:s'),
                );
                DB::table('categories')
                        ->where('id', $category_id)
                        ->update($data);

                return Redirect::to('/admin/categories/admin_index')->with('success_message', 'Category updated successfully.');
            }
        } else {
            return View::make('/Categories/admin_editcategory')->with('detail', $category);
        }
    }
    
    public function showAdmin_activecategory($slug = null) {
        if (!empty($slug)) {
            DB::table('categories')
                    ->where('slug', $slug)
                    ->update(['status' => 1]);

            return Redirect::back()->with('success_message', 'Category activated successfully');
        }
    }

    public function showAdmin_deactivecategory($slug = null) {
        if (!empty($slug)) {
            DB::table('categories')
                    ->where('slug', $slug)
                    ->update(['status' => 0]);

            return Redirect::back()->with('success_message', 'Category deactivated successfully');
        }
    }

    public function showAdmin_deletecategory($slug = null) {
        if (!empty($slug)) {
            DB::table('categories')->where('slug', $slug)->delete();
            return Redirect::to('/admin/categories/admin_index')->with('success_message', 'Category deleted successfully');
        } else {
            return Redirect::to('/admin/categories/admin_index');
        }
    }
    
    
    
    
    public function showUser_index() {
        
        if (!Session::has('user_id')) {
            return Redirect::to('/');
        }

       $user_id = Session::get('user_id');
        
        $input = Input::all();
        $search_keyword = "";
        $searchByDateFrom = "";
        $searchByDateTo = "";
        $separator = array();
        if (!empty($input['search'])) {
            $search_keyword = trim($input['search']);
        }
        $query = Category::sortable()
                ->where(function ($query) use ($search_keyword,$user_id) {
            $query->where('name', 'LIKE', '%' . $search_keyword . '%');
             $query->where('category_auther','=', $user_id);
            
        });
        
        if (!empty($input['action'])) {
            $action = $input['action'];
            $idList = $input['chkRecordId'];
            switch ($action) {
                case "Activate":
                    DB::table('categories')
                        
                            ->where('category_auther', $user_id)
                            ->whereIn('id', $idList)
                            ->update(array('status' => 1));

                    Session::put('success_message', 'Category(s) activated successfully');
                    break;
                case "Deactivate":
                    DB::table('categories')
                        ->where('category_auther', $user_id)
                            ->whereIn('id', $idList)
                            ->update(array('status' => 0));
                    Session::put('success_message', 'Category(s) deactivated successfully');
                    break;
                case "Delete":
                    DB::table('categories')
                        ->where('category_auther', $user_id)
                            ->whereIn('id', $idList)
                            ->delete();
                    Session::put('success_message', 'Category(s) deleted successfully');
                    break;
            }
        }

        $separator = implode("/", $separator);

        // Get all the users
        $categories = $query->orderBy('id', 'desc')->sortable()->paginate(10);
        
        // Show the page
        return View::make('Categories/userindex', compact('categories'))->with('search_keyword', $search_keyword)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('searchByDateTo', $searchByDateTo);
    }
    
    
    public function showUser_add() {
        if (!Session::has('user_id')) {
            return Redirect::to('/');
        }
        
$user_id = Session::get('user_id');
        $input = Input::all();
        
        if (!empty($input)) {
            
            $name = trim($input['name']);
            $rules = array(
                'name' => 'required|unique:categories', // make sure the first name field is not empty
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/user/categories/admin_add')->withErrors($validator)->withInput(Input::all());
            } else {

                $slug = $this->createUniqueSlug($name, 'categories');
                $saveCities = array(
                    'name' => $name,
                    'parent_id' => '0',
                    'slug' => $slug,
                    'status' => '1',
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                    'category_auther' => $user_id,
                    
                );
                DB::table('categories')
                        ->insert(
                        $saveCities
                );

                return Redirect::to('/user/categories/admin_index')->with('success_message', 'Category saved successfully.');
            }
        } else {
            return View::make('/Categories/user_add_category');
        }
    }
    
    
    public function showUser_editcategory($slug = null) {

        if (!Session::has('user_id')) {
            return Redirect::to('/');
        }
        $user_id = Session::get('user_id');
        $input = Input::all();

        $category = DB::table('categories')
                ->where('category_auther', $user_id)
                        ->where('slug', $slug)->first();
        $category_id = $category->id;


        if (!empty($input)) {
            $rules = array(
                'name' => "required|unique:categories,name," . $category_id, // make sure the first name field is not empty
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/user/categories/Admin_editcity/' . $category->slug)
                                ->withErrors($validator)->withInput(Input::all());
            } else {

                $data = array(
                    'name' => $input['name'],
                    'status' => '1',
                    'created' => date('Y-m-d H:i:s'),
                );
                DB::table('categories')
                        ->where('id', $category_id)
                        ->update($data);

                return Redirect::to('/user/categories/admin_index')->with('success_message', 'Category updated successfully.');
            }
        } else {
            return View::make('/Categories/user_editcategory')->with('detail', $category);
        }
    }
    
    
     public function showUser_activecategory($slug = null) {
        if (!empty($slug)) {
            DB::table('categories')
                    ->where('slug', $slug)
                    ->update(['status' => 1]);

            return Redirect::back()->with('success_message', 'Category activated successfully');
        }
    }
    
    public function showUser_deactivecategory($slug = null) {
        if (!empty($slug)) {
            DB::table('categories')
                    ->where('slug', $slug)
                    ->update(['status' => 0]);

            return Redirect::back()->with('success_message', 'Category deactivated successfully');
        }
    }
    public function showUser_deletecategory($slug = null) {
        if (!empty($slug)) {
            DB::table('categories')->where('slug', $slug)->delete();
            return Redirect::to('/user/categories/admin_index')->with('success_message', 'Category deleted successfully');
        } else {
            return Redirect::to('/user/categories/admin_index');
        }
    }
}

