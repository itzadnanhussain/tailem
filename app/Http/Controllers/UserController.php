<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //UserWelcome
    public function UserWelcome()
    {
        $url = url()->current();
        $user_name = Str::of($url)->after('-');

        if (isset($user_name)) {
            $get_user_content_qry = "SELECT user_name FROM tbl_users WHERE user_name = '" . $user_name . "'";
            $get_user_content = \App\Models\Songs::GetRawData($get_user_content_qry);

            if (isset($get_user_content) && !empty($get_user_content)) {
                $get_user_content = (array)$get_user_content[0];
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }

        return view('welcome', compact('user_name', 'get_user_content'));
    }


    ///ReviewArtist
    public function ReviewArtist()
    {
        $alpha = 'unset';
        return view('review_artist',compact('alpha'));

    }
}
