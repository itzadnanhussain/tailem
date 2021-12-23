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
            $post['google_oauth_uid'] = $user['id'];
            $post['user_name'] = $user['name'];
            $post['fname'] = $user['given_name'];
            $post['lname'] = $user['family_name'];
            $post['user_seo'] = Slug($user['name']);
            $post['oauth_provider'] =  'google';
            $post['email'] = $user['email'];
            $post['password'] = Hash::make('admin123456');


            ///profile image
            if (!empty($user['picture'])) {
                $image_name = $user['given_name'] . "_" . time() . ".png";
                copy($user['picture'], 'site_upload/user_images/' . $image_name, );
                $user['picture'] = $image_name;
            }

            $post['profile_image'] =  $user['picture'];
            $finduser = getByWhere('users', array('email' => $user['email']));

            if ($finduser) {
                if ($finduser[0]->profile_image != "") {
                    error_reporting(0);
                    unlink('/site_upload/user_images/'.$finduser[0]->profile_image);
                }

                UpdateRecord('users', array('email' => $user['email']), $post);
                session()->put('user_id', $finduser[0]->user_id);
                session()->put('user_name', $finduser[0]->user_name);
                return redirect('/review-artist');
            } else {
                $insert_id = addNew('users', $post);
                if ($insert_id) {
                    ///set session
                    session()->put('user_id', $insert_id);
                    session()->put('user_name', $user['name']);
                    $string_url = '/welcome/' . $post['user_seo'];
                    return redirect($string_url);
                }
                return redirect('sign-in');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
