<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FacebookController extends Controller
{
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $user = $user->user;
            echo '<pre>';
            print_r($user);
            echo '</pre>';
            die;
            $post = array();
            $post['fb_id'] = $user['id'];
            $post['user_name'] = $user['name'];
            $post['user_seo'] = Slug($user['name']);
            $post['oauth_provider'] =  'facebook';
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
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
