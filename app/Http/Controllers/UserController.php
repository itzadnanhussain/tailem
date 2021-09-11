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
    public function UserWelcome($user_name)
    {

       ///common header
       $data['user_id'] = session()->get('user_id');
       $data['mobile_view'] = 0;
       $data['page'] = 0; 
       $data['main_search'] = 'test';
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

        ///file data
        $data['get_user_content'] = $get_user_content;
        $data['currentFile']='welcome';

        return view('welcome', $data);
    }

    //GetReviewArtistPage
    public function GetReviewArtistPage($user_seo)
    {
        $data = array();
        $data['user_seo'] = strtolower($user_seo);
        $data['alpha'] = '';



        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        $data['page'] = 0; 
        $data['main_search'] = 'test';
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


        ///page code
        ///like_list_arr
        $user_profile =  $data['user_profile'];
        $like_list_qry = "select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '" . $user_profile . "' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1";
        $like_list_arr = \App\Models\Songs::GetRawData($like_list_qry);
        if($like_list_arr)
        {
            $data['like_list_arr'] = (array)$like_list_arr[0];
        }
        else
        {
            $data['like_list_arr'] = array();

        }


        ///search banner
        $data['genere_seo'] = '';
       


        ///review_list_arr_top
        $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $user_profile . "' order by r.review_id desc limit 1";
        $review_list_arr_top = \App\Models\Songs::GetRawData($review_list_qry);
        if($review_list_arr_top)
        {
            $data['review_list_arr_top'] = (array)$review_list_arr_top[0];
        }
        else
        {
            $data['review_list_arr_top'] = array();

        }
 
        ///comment_list_arr
        $comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_user_id = '" . $user_profile . "' order by comment_id desc limit 1";
        $comment_list_arr = \App\Models\Songs::GetRawData($comment_list_qry);
        if($comment_list_arr)
        {
            $data['comment_list_arr'] = (array)$comment_list_arr[0];
        }
        else
        {
            $data['comment_list_arr'] = array();

        }
 




        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }


        //loadview
        $data['currentFile']='review_artist';
        return view('review_artist', $data);
    }

   
}
