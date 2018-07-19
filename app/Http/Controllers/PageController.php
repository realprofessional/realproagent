<?php
namespace App\Http\Controllers;
//use Moltin\Cart\Cart;
//use Moltin\Cart\Storage\CartSession;
//use Moltin\Cart\Identifier\Cookie;

use App\Page;
use App\Listing;
use Session;
use Redirect;
use View;
use Input;
use Validator;
use DB;
use Mail;
class PageController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Page Controller
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

    //protected $page;
    public function showAdmin_index() {     //Admin Static Pages listing
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        $input = Input::all();
        $search_keyword = "";
        $searchByDateFrom = "";
        $searchByDateTo = "";
        $separator = array();
        // $pages = Page::where('first_name', '');
        $query = DB::table('pages');
        if (!empty($input['search'])) {
            $search_keyword = trim($input['search']);
        }
        if (!empty($input['from_date'])) {
            $searchByDateFrom = $input['from_date'];
        }
        if (!empty($input['to_date'])) {
            $searchByDateTo = $input['to_date'];
        }

        if (!empty($input['action'])) {
            $action = $input['action'];
            $idList = $input['chkRecordId'];
            switch ($action) {
                case "Activate":
                    DB::table('pages')
                            ->whereIn('id', $idList)
                            ->update(array('status' => 1));
                    return Redirect::back()->with('success_message', 'Page(s) activated successfully');
                    break;
                case "Deactivate":
                    DB::table('pages')
                            ->whereIn('id', $idList)
                            ->update(array('status' => 0));
                    return Redirect::back()->with('success_message', 'Page(s) deactivated successfully');
                    break;
                case "Delete":
                    DB::table('pages')
                            ->whereIn('id', $idList)
                            ->delete();
                    return Redirect::back()->with('success_message', 'Page(s) deleted successfully');
                    break;
            }
        }

        if (isset($search_keyword) && $search_keyword != '') {
            $search_keyword = strip_tags($search_keyword);
            $separator[] = 'search_keyword:' . urlencode($search_keyword);
            $pageName = str_replace('_', '\_', $search_keyword);
            $query->orwhere('name', 'LIKE', '%' . $search_keyword . '%');
            $search_keyword = str_replace('\_', '_', $search_keyword);
        }

        if (isset($searchByDateFrom) && $searchByDateFrom != '') {
            $separator[] = 'searchByDateFrom:' . urlencode($searchByDateFrom);
            $searchByDateFrom = str_replace('_', '\_', $searchByDateFrom);
            $searchByDate_con1 = date('Y-m-d', strtotime($searchByDateFrom));
            $query->where('created', '>=', $searchByDateFrom);
            $searchByDateFrom = str_replace('\_', '_', $searchByDateFrom);
        }

        if (isset($searchByDateTo) && $searchByDateTo != '') {
            $separator[] = 'searchByDateTo:' . urlencode($searchByDateTo);
            $searchByDateTo = str_replace('_', '\_', $searchByDateTo);
            $searchByDate_con2 = date('Y-m-d', strtotime($searchByDateTo));
            $query->where('created', '<=', $searchByDateTo);
            $searchByDateTo = str_replace('\_', '_', $searchByDateTo);
        }
//            echo $query->toSql();
//            exit;

        $separator = implode("/", $separator);
        // Get all the pages
        $pages = $query->orderBy('id', 'desc')->paginate(30);
        // Show the page

        return View::make('Pages/adminindex', compact('pages'))->with('search_keyword', $search_keyword)
                        ->with('searchByDateFrom', $searchByDateFrom)
                        ->with('searchByDateTo', $searchByDateTo);
    }

    public function showAdmin_add() {       //Admin Add Static Pages
        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }

        $input = Input::all();
        if (!empty($input)) {
            $name = trim($input['name']);
            $rules = array(
                'name' => 'required|unique:pages', // make sure the first name field is not empty
                'description' => 'required', // make sure the description field is not empty
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/admin/page/admin_add')->withErrors($validator)->withInput(Input::all());
            } else {


                $slug = $this->createUniqueSlug($name, 'pages');
                $savePage = array(
                    'name' => $name,
                    'description' => $input['description'],
                    'status' => '1',
                    'slug' => $slug,
                    'created' => date('Y-m-d H:i:s'),
                );
                DB::table('pages')->insert(
                        $savePage
                );

                return Redirect::to('/admin/page/pagelist')->with('success_message', 'Page saved successfully.');
            }
        } else {
            return View::make('/Pages/admin_add');
        }
    }

    public function showAdmin_editpage($slug = null) {  //Admin Edit Static Pages

        if (!Session::has('adminid')) {
            return Redirect::to('/admin/login');
        }
        $input = Input::all();

        $page = DB::table('pages')
                        ->where('slug', $slug)->first();
        $page_id = $page->id;


        if (!empty($input)) {
            $rules = array(
                'name' => 'required|unique:pages,name,' . $page_id, // make sure the first name field is not empty
                'description' => 'required', // make sure the first name field is not empty
            );


            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                return Redirect::to('/admin/page/Admin_editpage/' . $page->slug)
                                ->withErrors($validator)->withInput(Input::all());
            } else {


                $data = array(
                    'name' => $input['name'],
                    'description' => $input['description'],
                    'status' => '1',
                    'created' => date('Y-m-d H:i:s'),
                );
                DB::table('pages')
                        ->where('id', $page_id)
                        ->update($data);


                return Redirect::to('/admin/page/pagelist')->with('success_message', 'Page updated successfully.');
            }
        } else {



            return View::make('/Pages/admin_editpage')->with('detail', $page);
        }
    }

    public function showAdmin_activepage($slug = null) {    //Admin Activate Static Pages
        if (!empty($slug)) {
            DB::table('pages')
                    ->where('slug', $slug)
                    ->update(['status' => 1]);

            return Redirect::back()->with('success_message', 'Page activated successfully');
        }
    }

    public function showAdmin_deactivepage($slug = null) {  //Admin Dectivate Static Pages
        if (!empty($slug)) {
            DB::table('pages')
                    ->where('slug', $slug)
                    ->update(['status' => 0]);

            return Redirect::back()->with('success_message', 'Page deactivated successfully');
        }
    }

    public function showAdmin_deletepage($slug = null) {    //Admin Delete Static Pages
        if (!empty($slug)) {
            DB::table('pages')->where('slug', $slug)->delete();
            return Redirect::to('/admin/page/pagelist')->with('success_message', 'Page deleted successfully');
        }
    }

    public function showIndex($slug = null) {

        if (!empty($slug)) {
            $pageDetail = DB::table('pages')
                    ->where('slug', $slug)
                    ->first();
            //$this->layout->content = View::make('page.index')->with('pageDetail',$pageDetail);


            if (empty($pageDetail))
                return Redirect::to('/');
            $this->layout->title = TITLE_FOR_PAGES . $pageDetail->name;
            $this->layout->content = View::make('/Pages/index')->with('pageDetail', $pageDetail);
        }
    }

   

    public function showData($slug = null) {

        if (!empty($slug)) {
            $pageDetail = DB::table('pages')
                    ->where('slug', $slug)
                    ->first();
  
            if (empty($pageDetail))
                return Redirect::to('/');

            //$this->layout->content = View::make('page.index')->with('pageDetail',$pageDetail);
            return View::make('/Pages/data')->with('pageDetail', $pageDetail);
        }
    }
    
    public function showPageData($slug = null) {
        
       // $this->layout = 'default_front';
        
        if (!empty($slug)) {
            $pageDetail = DB::table('pages')
                    ->where('slug', $slug)
                    ->first();
            
        //print_r($pageDetail); exit;
            if (empty($pageDetail)){
                return Redirect::to('/');
            }
            
            $this->layout->title = TITLE_FOR_PAGES . $pageDetail->name;
            $this->layout->content = View::make('Pages.pagedata')->with('pageDetail',$pageDetail);
            //return View::make('/Pages/pagedata')->with('pageDetail', $pageDetail);
        }
    }
	
	public function addlisting() {
           $this->layout->title = TITLE_FOR_PAGES . 'Start Listing';
        $this->layout->content = View::make('/Pages/addlisting');
    }
	
	
    public function overview() {
           $this->layout->title = TITLE_FOR_PAGES . 'Overview';
        $this->layout->content = View::make('/Pages/overview');
    }
    
    public function uploadImage() {
        
    if(isset($_FILES['image'])){
        //Get the image array of details
        $img = $_FILES['image'];       
        //The new path of the uploaded image, rand is just used for the sake of it
        $path = "uploads/nicedit/" . rand().$img["name"];
        //Move the file to our new path
        move_uploaded_file($img['tmp_name'],$path);
        //Get image info, reuiqred to biuld the JSON object
        $data = getimagesize($path);
        //The direct link to the uploaded image, this might varyu depending on your script location    
        if($_SERVER[HTTP_HOST]=='192.168.0.251'){
        $link = "http://$_SERVER[HTTP_HOST]"."/comp84/catch_hotels/site/".$path;
        }else{
            $link = "http://$_SERVER[HTTP_HOST]"."/catch_hotels/".$path;
        }
        //Here we are constructing the JSON Object
        $res = array("upload" => array(
                                "links" => array("original" => $link),
                                "image" => array("width" => $data[0],
                                                 "height" => $data[1]
                                                )                              
                    ), 'valid' => false);
        echo json_encode($res);
        die;
    }
    }
    
    
    
    
     
}
