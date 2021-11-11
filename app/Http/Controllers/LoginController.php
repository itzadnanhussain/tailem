<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    ///LoadSignUpPage
    public function LoadSignUpPage()
    {
        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        $data['page'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "-profile-";
        } else {
            $data['user_name'] = session()->get('user_name');
            $data['user_profile'] = session()->get('user_id');
            $data['main_link'] = '';
        }

        //loadview
        $data['currentFile'] = 'sign-up';
        $data['title'] = GetTitle();
        return view('auth.register', $data);
    }

    ///LoadSignUpPage
    public function LoadSignInPage()
    {
        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        $data['page'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "-profile-";
        } else {
            $data['user_name'] = session()->get('user_name');
            $data['user_profile'] = session()->get('user_id');
            $data['main_link'] = '';
        }

        //loadview
        $data['currentFile'] = 'sign-in';
        $data['title'] = GetTitle();
        return view('auth.login', $data);
    }

    //RegisterUser
    public function RegisterUser(Request $request)
    {


        $validation = Validator::make($request->all(), [
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password_confirmation' => 'required',
            'password' => 'required|min:6'
        ],['email' => 'Incorrect email address entered, please try again','password' => 'Your password must be at least 6 characters long']);

        if ($validation->fails()) {
            error_reporting(0);
            $user_name = $validation->errors()->toArray()['user_name'][0];
            $email_error = $validation->errors()->toArray()['email'][0];
            $password = $validation->errors()->toArray()['password'][0];
             $string = $user_name .'<br>'.$email_error.'<br>'.$password;
            return response()->json(['code' => "error", 'message' => $string]);
        } else {
            ///post data to database
            $post = array();
            $post['user_name'] = $request->user_name;
            $post['user_seo'] = Slug($request->user_name);
            $post['email'] = $request->email;
            $post['password'] = Hash::make($request->password);
            $insert_id = addNew('users', $post);
           
            if ($insert_id) {
              
                ///set session
                $request->session()->put('user_id', $insert_id);
                $request->session()->put('user_name', $request->user_name);
                $string_url = 'welcome/' . $post['user_name'];
                return response()->json(['code' => "success", 'url' => $string_url]);
                die;
            }
        }
    }


    //login_user
    public function LoginUser(Request $request)
    {

        $validation = Validator::make($request->all(), [

            'email' => 'required|string|email|max:255',
            'password' => 'required',

        ]);

        if ($validation->fails()) {
            return response()->json(['code' => "warning", 'message' => $validation->errors()->first()]);
        } else {

            ///check user
            $check_user = getByWhere('users', array('email' => $request->email));
            

            if ($check_user) {
                if (Hash::check($request->password, $check_user[0]->password)) {
                   
                    ///set session
                    $request->session()->put('user_id', $check_user[0]->user_id);
                    $request->session()->put('user_name', $check_user[0]->user_name);
                    if (isset($request->redirect_url)) {
                        $string_url = $request->redirect_url;
                        $location = 'others';
                    } else {
                        $string_url = '/review-artist';
                        $location = 'index';
                    }
                    $response = array("code" => 'success', 'url' => $string_url, 'location' => $location);
                    return response()->json($response);
                }
                

                return response()->json(['code' => 'warning', 'message' => 'Password Not Match']);
            }

            return response()->json(['code' => "warning", 'message' => 'Incorrect login details entered, please try again.']);
        }
    }


    ///ForgotPassword
    public function ForgotPassword()
    {
        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        $data['page'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "-profile-";
        } else {
            $data['user_name'] = session()->get('user_name');
            $data['user_profile'] = session()->get('user_id');
            $data['main_link'] = '';
        }

        //loadview
        $data['currentFile'] = 'sign-up';
        $data['title'] = GetTitle();
        return view('auth.forgot-password', $data);
    }



    ///logout_user
    public function destroy(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
