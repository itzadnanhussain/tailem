<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();
            
            $user = $user->user;
            $post = array();
            $post['google_id'] = $user['id'];
            $post['user_name'] = $user['name'];
            $post['fname'] = $user['given_name'];
            $post['lname'] = $user['family_name'];
            $post['user_seo'] = Slug($user['name']);
            $post['oauth_provider'] =  'google';
            $post['email'] = $user['email'];
            $post['password'] = Hash::make('admin123456');

            ///profile image
            if (!empty($user['picture'])) {
                $ch = curl_init($user['picture']);
                $google_img = $user['given_name'] . "_" . time() . ".png";
                $fp = fopen('site_upload/user_images/' . $google_img, 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);
                $user['picture'] = $google_img;
            }

            $post['profile_image'] =  $user['picture'];

            // $finduser = User::where('google_id', $user->id)->first();
            $finduser = getByWhere('users', array('email' => $user['email']));

            if ($finduser) {

                if($finduser[0]->profile_image != ""){ 
                    error_reporting(0);
                    unlink('/site_upload/user_images/'.$finduser[0]->profile_image);
                } 

                UpdateRecord('users', array('email' => $user['email']) , $post);
                session()->put('user_id', $finduser[0]->user_id);
                session()->put('user_name', $finduser[0]->user_name);
                $string_url = '/review-artist';
                return redirect()->intended('review-artist');



               
            } else {  
                $insert_id = addNew('users', $post);
                if ($insert_id) {
                    ///set session
                    session()->put('user_id', $insert_id);
                    session()->put('user_name', $user['name']);
                    $string_url = '/welcome/' . $post['user_seo'];
                    return redirect()->intended($string_url);
                }
                return redirect('sign-in');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
