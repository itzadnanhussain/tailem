<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Mail\ContactMail;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class InfoController extends Controller
{
    ///contact-us
    public function ContactUsPage()
    {
        $arr_social = GetAllRecords('social_links');
        $setting_arr = GetByWhere('general_setting', array('setting_id' => 1));
        $result_notification_count = GetByWhere('general_setting', array('setting_id' => 1));
        return view('contact-us', compact('setting_arr', 'arr_social'));
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

        
        // $receiver = "testadnan073@gmail.com";
        // Mail::to($receiver)->send(new ContactMail($msg));



        //  Send mail to admin
        Mail::send('emails.contactMail', array(
            'name' => $name,
            'email' => $email, 
            'subject' => 'Tailem.com',
            'message' => $msg,
        ), function($message) use ($request){
            $message->from($request->email);
            $message->to('testadnan073@gmail.com', 'Admin')->subject($request->get('subject'));
        });  
        return response()->json(['code' => 200, 'msg' => 'We will contact you soon.']);
    }

    ///LoadCMS
    public function LoadCMS()
    {
        $page_name = Str::of(url()->current())->basename();

        $arr_social = GetAllRecords('social_links');
        $setting_arr = GetByWhere('general_setting', array('setting_id' => 1));

        $get_page_content = GetByWhere('pages', array('page_seo_name' => $page_name));
        // $get_page_content = GetByWhere('pages', array('page_seo_name' => 'test'));
        // echo '<pre>';
        // print_r($get_page_content);
        // echo '</pre>';
        // die;
        if (($get_page_content) && !empty($get_page_content)) {
            $get_page_content = (array)$get_page_content[0];
            return view($page_name, compact('arr_social', 'setting_arr', 'get_page_content'));
        } else {
            return Redirect::to('/');
        }
    }
}
