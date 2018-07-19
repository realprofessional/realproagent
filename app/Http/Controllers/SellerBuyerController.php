<?php

namespace App\Http\Controllers;

use Session;
use Request;
use Response;
use View;
use Redirect;
use Validator;
use Cookie;
use Input;
use DB;
use Mail;
use Carbon;

class SellerBuyerController extends BaseController {
    /*
     * 
     * 
     */

    protected $layout = 'layouts.default_front';

    function editProfile() {
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

        $input = Input::all();
        if (!empty($input)) {

//            $user_email =  DB::table('users')
//                     ->where('email_address', $input['email_address'])
//                ->get();
//            
//            foreach($user_email as $email){
//                
//            if($email->id!=$user_id){
//                
//                return Redirect::to('/user/editprofile')->with('error_message','The email address has already been taken.');
//            }    
//            }


            $password = md5($input['password']);
            //$email_address = $input['email_address'];
            $rules = array(
                'first_name' => 'required', // make sure the first name field is not empty
                'last_name' => 'required', // make sure the last name field is not empty
                'address1' => 'required',
                    //'account_type' => 'required', 
            );



            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {

                // Session::forget('captcha');
                return Redirect::to('/user/editprofile')
                                ->withErrors($validator) // send back all errors to the login form
                                ->withInput(Input::except('password'))
                                ->withInput(Input::except('cpassword')); // send back the input (not the password) so that we can repopulate the form
            } else {
                if (Input::hasFile('profile_image')) {
                    $file = Input::file('profile_image');
                    $profileImageName = time() . $file->getClientOriginalName();
                    $file->move(UPLOAD_FULL_PROFILE_IMAGE_PATH, time() . $file->getClientOriginalName());
                } else {
                    $profileImageName = $user->profile_image;
                }

                $saveUser = array(
                    'first_name' => $input['first_name'],
                    'last_name' => $input['last_name'],
                    'title' => $input['title'],
                    'contact' => $input['contact'],
                    'address' => $input['address1'],
                    'address2' => $input['address2'],
                    'company_name' => $input['company_name'],
                    'turn_off_notification' => isset($input['turn_off_notification']) ? $input['turn_off_notification'] : 0,
                    'profile_image' => $profileImageName,
                    'modified' => date('Y-m-d H:i:s'),
                );
                DB::table('users')
                        ->where('id', $user_id)
                        ->update(
                                $saveUser
                );

                if (isset($_REQUEST['password']) && $_REQUEST['password'] != '') {
                    DB::table('users')
                            ->where('id', $user_id)
                            ->update(
                                    array(
                                        'password' => md5($input['password']),
                                    )
                    );
                }


                return Redirect::to('/account')->with('success_message', 'Profile updated successfully.');
            }
        }
        $this->layout->title = TITLE_FOR_PAGES . 'Edit Profile';
        $this->layout->content = View::make('SellerBuyer.editProfile')->with('user', $user);
    }

    function propertyAdd() {
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
        $input = Input::all();
        if (!empty($input)) {






            $rules = array(
                'property_category' => 'required',
                'property_type' => 'required', // make sure the first name field is not empty
                'price' => 'required', // make sure the last name field is not empty
                'image-upload1' => 'required', // make sure the last name field is not empty

                'area' => 'required', // make sure the last name field is not empty
                'built_up' => 'required', // make sure the last name field is not empty
                'number_of_bedrooms' => 'required', // make sure the last name field is not empty
                'number_of_beds' => 'required', // make sure the last name field is not empty
                'number_of_bathrooms' => 'required', // make sure the last name field is not empty
                'description' => 'required',
                'address1' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'postcode' => 'required',
            );



            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {

                // Session::forget('captcha');
                return Redirect::to('/users/propertyAdd')
                                ->withErrors($validator) // send back all errors to the login form
                                ->withInput(Input::except('password'))
                                ->withInput(Input::except('cpassword')); // send back the input (not the password) so that we can repopulate the form
            } else {
                if (Input::hasFile('image-upload1')) {
                    $file = Input::file('image-upload1');
                    $img_up_1 = time() . str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move(UPLOAD_FULL_PROPERTY_IMAGE_PATH, time() . str_replace(' ', '_', $file->getClientOriginalName()));
                } else {
                    $img_up_1 = '';
                }
                if (Input::hasFile('image-upload2')) {
                    $file = Input::file('image-upload2');
                    $img_up_2 = time() . str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move(UPLOAD_FULL_PROPERTY_IMAGE_PATH, time() . str_replace(' ', '_', $file->getClientOriginalName()));
                } else {
                    $img_up_2 = '';
                }
                if (Input::hasFile('image-upload3')) {
                    $file = Input::file('image-upload3');
                    $img_up_3 = time() . str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move(UPLOAD_FULL_PROPERTY_IMAGE_PATH, time() . str_replace(' ', '_', $file->getClientOriginalName()));
                } else {
                    $img_up_3 = '';
                }
                if (Input::hasFile('image-upload4')) {
                    $file = Input::file('image-upload4');
                    $img_up_4 = time() . str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move(UPLOAD_FULL_PROPERTY_IMAGE_PATH, time() . str_replace(' ', '_', $file->getClientOriginalName()));
                } else {
                    $img_up_4 = '';
                }
                $slug = $this->createUniqueSlug('property', 'property');
                $saveUser = array(
                    'property_type' => $input['property_type'],
                    'price' => $input['price'],
                    'area' => $input['area'],
                    'built_up' => $input['built_up'],
                    'number_of_bathrooms' => $input['number_of_bathrooms'],
                    'number_of_bedrooms' => $input['number_of_bedrooms'],
                    'number_of_beds' => $input['number_of_beds'],
                    'description' => $input['description'],
                    'latitude' => $input['latitude'],
                    'longitude' => $input['longitude'],
                    'status' => 1,
                    'address1' => $input['address1'],
                    'address2' => $input['address2'],
                    'city' => $input['city'],
                    'state' => $input['state'],
                    'country' => $input['country'],
                    'postcode' => $input['postcode'],
                    'image1' => $img_up_1,
                    'image2' => $img_up_2,
                    'image3' => $img_up_3,
                    'image4' => $img_up_4,
                    'created' => date('Y-m-d H:i:s'),
                    'user_id' => $user_id,
                    'property_category' => $input['property_category'],
                    'slug' => $slug,
                );
                DB::table('property')
                        ->insert(
                                $saveUser
                );




                return Redirect::to('/users/propertyList')->with('success_message', 'Property updated successfully.');
            }
        }


        $this->layout->title = TITLE_FOR_PAGES . 'Add Property';
        $this->layout->content = View::make('SellerBuyer.addProperty');
    }

    function propertyList() {
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
        $properties = DB::table('property')
                ->where('user_id', $user_id)
                ->where('status', 1)
                ->orderby('id', 'desc')
                ->paginate(10);


        $this->layout->title = TITLE_FOR_PAGES . 'Property List';
        $this->layout->content = View::make('SellerBuyer.propertyList')->with('properties', $properties);
    }

    function propertyEdit($slug = null) {
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

        $property = DB::table('property')
                ->where('slug', $slug)
                ->first();

        $user_id = Session::get('user_id');

        $input = Input::all();
        if (!empty($input)) {






            $rules = array(
                'property_category' => 'required',
                'property_type' => 'required', // make sure the first name field is not empty
                'price' => 'required', // make sure the last name field is not empty
                'area' => 'required', // make sure the last name field is not empty
                'built_up' => 'required',
                'number_of_bedrooms' => 'required', // make sure the last name field is not empty
                'number_of_beds' => 'required', // make sure the last name field is not empty
                'number_of_bathrooms' => 'required', // make sure the last name field is not empty
                'description' => 'required',
                'address1' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'postcode' => 'required',
                    //'account_type' => 'required',
            );



            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {

                // Session::forget('captcha');
                return Redirect::to('/users/propertyAdd')
                                ->withErrors($validator) // send back all errors to the login form
                                ->withInput(Input::except('password'))
                                ->withInput(Input::except('cpassword')); // send back the input (not the password) so that we can repopulate the form
            } else {
                if (Input::hasFile('image-upload1')) {
                    $file = Input::file('image-upload1');
                    $img_up_1 = time() . str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move(UPLOAD_FULL_PROPERTY_IMAGE_PATH, time() . str_replace(' ', '_', $file->getClientOriginalName()));
                } else {
                    $img_up_1 = $property->image1;
                }
                if (Input::hasFile('image-upload2')) {
                    $file = Input::file('image-upload2');
                    $img_up_2 = time() . str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move(UPLOAD_FULL_PROPERTY_IMAGE_PATH, time() . str_replace(' ', '_', $file->getClientOriginalName()));
                } else {
                    $img_up_2 = $property->image2;
                }
                if (Input::hasFile('image-upload3')) {
                    $file = Input::file('image-upload3');
                    $img_up_3 = time() . str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move(UPLOAD_FULL_PROPERTY_IMAGE_PATH, time() . str_replace(' ', '_', $file->getClientOriginalName()));
                } else {
                    $img_up_3 = $property->image3;
                }
                if (Input::hasFile('image-upload4')) {
                    $file = Input::file('image-upload4');
                    $img_up_4 = time() . str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move(UPLOAD_FULL_PROPERTY_IMAGE_PATH, time() . str_replace(' ', '_', $file->getClientOriginalName()));
                } else {
                    $img_up_4 = $property->image4;
                }

                $saveUser = array(
                    'property_type' => $input['property_type'],
                    'price' => $input['price'],
                    'area' => $input['area'],
                    'built_up' => $input['built_up'],
                    'number_of_bathrooms' => $input['number_of_bathrooms'],
                    'number_of_bedrooms' => $input['number_of_bedrooms'],
                    'number_of_beds' => $input['number_of_beds'],
                    'description' => $input['description'],
                    'latitude' => $input['latitude'],
                    'longitude' => $input['longitude'],
                    'status' => 1,
                    'address1' => $input['address1'],
                    'address2' => $input['address2'],
                    'city' => $input['city'],
                    'state' => $input['state'],
                    'country' => $input['country'],
                    'postcode' => $input['postcode'],
                    'image1' => $img_up_1,
                    'image2' => $img_up_2,
                    'image3' => $img_up_3,
                    'image4' => $img_up_4,
                    'modified' => date('Y-m-d H:i:s'),
                    'property_category' => $input['property_category'],
                );
                DB::table('property')
                        ->where('slug', $slug)
                        ->update(
                                $saveUser
                );




                return Redirect::to('/users/propertyList')->with('success_message', 'Property updated successfully.');
            }
        }
        $this->layout->title = TITLE_FOR_PAGES . 'Property List';
        $this->layout->content = View::make('SellerBuyer.editProperty')->with('property', $property);
    }

    function deleteListing() {


        $property = DB::table('property')
                ->where('id', $_REQUEST['id'])
                ->first();
        if (!empty($property)) {
            DB::table('property')
                    ->where('id', $_REQUEST['id'])
                    ->delete();
            return json_encode(array('message' => 'success'));
            exit;
        } else {

            return json_encode(array('message' => 'error'));
            exit;
        }
    }

    public function loadmore() {
        $_REQUEST['data2'];
        $pagination = 6;
        $user_id = Session::get('user_id');
        $properties_append = DB::table('property')
                ->where('user_id', $user_id)
                ->whereNotIn('id', explode(',', $_REQUEST['data2']))
                ->where('status', 1)
                ->orderby('id', 'desc')
                ->paginate($pagination);


        if ($properties_append->total() != 0) {


            view()->share('properties_append', $properties_append);
            view()->share('data', $_REQUEST['data']);

            if (Request::ajax()) {
                //print_r($properties_append); exit;
                return Response::json(View::make('SellerBuyer/ajax_property_load_more', array('properties_append' => $properties_append))->render());
                exit;
            }
        } else {
            exit;
        }
    }

    public function loadmore2() {
        $_REQUEST['data2'];
        $user_id = Session::get('user_id');

        $pagination = 6;
        $properties_append = DB::table('property')
                ->where('user_id', $user_id)
                ->whereNotIn('id', explode(',', $_REQUEST['data2']))
                ->where('status', 1)
                ->orderby('id', 'desc')
                ->paginate($pagination);


        $array_append = array();

        if ($properties_append->total() != 0) {
            unset($array_append);
            foreach ($properties_append as $properties) {
                $array_append[] = $properties->id;
            }
            $array1 = explode(',', $_REQUEST['data2']);

            $array_final = array_merge($array1, $array_append);
            $array_imploded = implode(',', $array_final);


            if (Request::ajax()) {
                //print_r($properties_append); exit;
                $pagination = $pagination + $_REQUEST['data'];

                return json_encode(array('message' => $array_imploded, 'pageination' => $pagination));
                exit;
            }
        } else {
            return json_encode(array('message' => 'hide'));
            exit;
        }
    }

    function showProfile() {
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



        $this->layout->title = TITLE_FOR_PAGES . 'View Profile';
        $this->layout->content = View::make('SellerBuyer.showProfile')->with('user', $user);
    }

    function showpostBid() {
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



        $this->layout->title = TITLE_FOR_PAGES . 'Post Bid';
        $this->layout->content = View::make('SellerBuyer.PostBid_Property')->with('user', $user);
    }

}