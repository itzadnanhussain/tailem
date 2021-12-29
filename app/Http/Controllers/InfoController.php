<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Mail\ContactMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Mail\Mailable;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class InfoController extends Controller
{
    ///contact-us
    public function ContactUsPage()
    {
        $data = array();

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
         
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


        $data['arr_social'] = GetAllRecords('social_links');
        // $setting_arr = GetByWhere('general_setting', array('setting_id' => 1));
        // $result_notification_count = GetByWhere('general_setting', array('setting_id' => 1));
        $data['currentFile'] = 'contact-us';
        $data['title'] = GetTitle();
        return view('contact-us', $data);
    }


    ///ContactFormSubmit
    public function ContactFormSubmit(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:filter', 'max:255'],
            'message' => ['required', 'string']
        ]);

        if ($validation->fails()) {
            return response()->json(['code' => 400, 'msg' => $validation->errors()->first()]);
        }

        $name = $request->name;
        $email = $request->email;
        $msg = $request->message;

        $msg = "
                Name: $name \n
                Email: $email \n
                Message: $msg
        ";
        //  Send mail to admin
        Mail::send('emails.contactMail', array(
            'name' => $name,
            'email' => $email,
            'subject' => 'Tailem.com',
            'message' => $msg,
        ), function ($message) use ($request) {
            $message->from($request->email);
            $message->to('info@tailem.com', 'Admin')->subject($request->get('subject'));
        });
        return response()->json(['code' => 200, 'msg' => 'We will contact you soon.']);
    }


    ///LoadCMS
    public function LoadCMS()
    {
        $page_name = Str::of(url()->current())->basename();
        ///
        $data = array();

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        
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


        $data['arr_social'] = GetAllRecords('social_links');
        // $setting_arr = GetByWhere('general_setting', array('setting_id' => 1));
        // $result_notification_count = GetByWhere('general_setting', array('setting_id' => 1));
        $data['currentFile'] = 'contact-us';
        $data['title'] = GetTitle();



        $data['setting_arr'] = GetByWhere('general_setting', array('setting_id' => 1));
        $get_page_content = GetByWhere('pages', array('page_seo_name' => $page_name));
      


        if (($get_page_content) && !empty($get_page_content)) {
            $get_page_content = (array)$get_page_content[0];
            $data['get_page_content'] = $get_page_content;
            return view($page_name, $data);
        } else {
            return Redirect::to('/');
        }
    }


    ///UpdateColumn
    public function update_column()
    {
        UpdateRecord('artists', array('genere_cat' => 0), array('genere_cat'=>7));
        echo'done';
        die;
    }
}
