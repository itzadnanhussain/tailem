<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    ///GetTopAlbums
    public function GetTopAlbums()
    {
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        ///common header
        $data['currentFile'] = get_page_name();
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        $data['page'] = $page;


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

        ///screen char
        $data['screen_chr'] = 15;
        $data['ipad_chr'] = 15;
        $data['mobile_chr'] = 15;
        $data['screen_rev'] = 15;
        $data['ipad_rev'] = 15;
        $data['mobile_rev'] = 15;

        
        //page View
        $data['currentFile'] = 'album';
        $data['title'] = GetTitle();
        return view('album', $data);
    }


    //GetAlbumDetail
    public function GetAlbumDetail($artist_seo, $album_seo = null, $page = null)
    {
         $data = array();

        ///admin
        if(isset($_GET['user_type']))
        {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);

        }
        $data['artist_seo'] = $artist_seo;
        $data['album_seo'] = $album_seo;
        ///common header 
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        $data['page'] = $page;


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


        ///screen char
        $data['screen_chr'] = 15;
        $data['ipad_chr'] = 15;
        $data['mobile_chr'] = 15;
        $data['screen_rev'] = 15;
        $data['ipad_rev'] = 15;
        $data['mobile_rev'] = 15;



        ///file code
        $row_artist = array();
        $qry = "select id,artist_seo,artist_name,artist_description,artist_img,lastfm_url from tbl_artists where artist_seo='" . $data['artist_seo'] . "' ";
        $row_artist = \App\Models\Songs::GetRawData($qry);
        if (isset($row_artist) && !empty($row_artist)) {
            $data['row_artist'] = (array) $row_artist[0];
        } else {
            return redirect('/');
        }


        //page View
        $data['currentFile'] = 'albums_page';
        $data['title'] = GetTitle();

        return view('albums_page', $data);
    }


    //GetAlbumProfileDetail_One
    public function GetAlbumProfileDetail_One($user_seo, $artist_seo)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

         $data = array();

        ///admin
        if(isset($_GET['user_type']))
        {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);

        }
        $data['artist_seo'] = $artist_seo;
        $data['album_seo'] = null;


        ///common header 
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        $data['page'] = $page;
        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['user_seo'] = $user_seo;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
        } else {
            $data['user_name'] = session()->get('user_name');
            $data['user_profile'] = session()->get('user_id');
            $data['main_link'] = '';
            $data['user_seo'] = '';
        }


        ///screen char
        $data['screen_chr'] = 15;
        $data['ipad_chr'] = 15;
        $data['mobile_chr'] = 15;
        $data['screen_rev'] = 15;
        $data['ipad_rev'] = 15;
        $data['mobile_rev'] = 15;

        if ($data['user_profile'] == "" && $data['user_seo'] == "") {
            return redirect('/');
        }

        ///like_list_arr
        $user_profile =  $data['user_profile'];
        $like_list_qry = "select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '" . $user_profile . "' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1";
        $like_list_arr = \App\Models\Songs::GetRawData($like_list_qry);
        if ($like_list_arr) {
            $data['like_list_arr'] = (array)$like_list_arr[0];
        } else {
            $data['like_list_arr'] = array();
        }

        ///review_list_arr_top
        $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $user_profile . "' order by r.review_id desc limit 1";
        $review_list_arr_top = \App\Models\Songs::GetRawData($review_list_qry);
        if ($review_list_arr_top) {
            $data['review_list_arr_top'] = (array)$review_list_arr_top[0];
        } else {
            $data['review_list_arr_top'] = array();
        }

        ///comment_list_arr
        $comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_user_id = '" . $user_profile . "' order by comment_id desc limit 1";
        $comment_list_arr = \App\Models\Songs::GetRawData($comment_list_qry);
        if ($comment_list_arr) {
            $data['comment_list_arr'] = (array)$comment_list_arr[0];
        } else {
            $data['comment_list_arr'] = array();
        }
 

        //page View
        $data['currentFile'] = 'review_album'; 
        $data['title'] = GetTitle();
        return view('review_album', $data);
    }


    //GetAlbumProfileDetail_Three
    public function GetAlbumProfileDetail_Three($user_seo)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

         $data = array();

        ///admin
        if(isset($_GET['user_type']))
        {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);

        }
        $data['artist_seo'] = null;
        $data['album_seo'] = null;


        ///common header 
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        $data['page'] = $page;
        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['user_seo'] = $user_seo;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
        } else {
            $data['user_name'] = session()->get('user_name');
            $data['user_profile'] = session()->get('user_id');
            $data['main_link'] = '';
            $data['user_seo'] = '';
        }


        ///screen char
        $data['screen_chr'] = 15;
        $data['ipad_chr'] = 15;
        $data['mobile_chr'] = 15;
        $data['screen_rev'] = 15;
        $data['ipad_rev'] = 15;
        $data['mobile_rev'] = 15;

        if ($data['user_profile'] == "" && $data['user_seo'] == "") {
            return redirect('/');
        }

        ///like_list_arr
        $user_profile =  $data['user_profile'];
        $like_list_qry = "select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '" . $user_profile . "' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1";
        $like_list_arr = \App\Models\Songs::GetRawData($like_list_qry);
        if ($like_list_arr) {
            $data['like_list_arr'] = (array)$like_list_arr[0];
        } else {
            $data['like_list_arr'] = array();
        }

        ///review_list_arr_top
        $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $user_profile . "' order by r.review_id desc limit 1";
        $review_list_arr_top = \App\Models\Songs::GetRawData($review_list_qry);
        if ($review_list_arr_top) {
            $data['review_list_arr_top'] = (array)$review_list_arr_top[0];
        } else {
            $data['review_list_arr_top'] = array();
        }

        ///comment_list_arr
        $comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_user_id = '" . $user_profile . "' order by comment_id desc limit 1";
        $comment_list_arr = \App\Models\Songs::GetRawData($comment_list_qry);
        if ($comment_list_arr) {
            $data['comment_list_arr'] = (array)$comment_list_arr[0];
        } else {
            $data['comment_list_arr'] = array();
        }
 

        //page View
        $data['currentFile'] = 'review_album'; 
        $data['title'] = GetTitle();
        return view('review_album', $data);
    }


    //GetAlbumProfileDetail_Two
    public function GetAlbumProfileDetail_Two($artist_seo)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

         $data = array();

        ///admin
        if(isset($_GET['user_type']))
        {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);

        }
        $data['artist_seo'] = $artist_seo;
        $data['album_seo'] = null;


        ///common header 
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        $data['page'] = $page;
        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['user_seo'] = $user_seo;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
        } else {
            $data['user_name'] = session()->get('user_name');
            $data['user_profile'] = session()->get('user_id');
            $data['main_link'] = '';
            $data['user_seo'] = '';
        }


        ///screen char
        $data['screen_chr'] = 15;
        $data['ipad_chr'] = 15;
        $data['mobile_chr'] = 15;
        $data['screen_rev'] = 15;
        $data['ipad_rev'] = 15;
        $data['mobile_rev'] = 15;

        if ($data['user_profile'] == "" && $data['user_seo'] == "") {
            return redirect('/');
        }

        ///like_list_arr
        $user_profile =  $data['user_profile'];
        $like_list_qry = "select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '" . $user_profile . "' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1";
        $like_list_arr = \App\Models\Songs::GetRawData($like_list_qry);
        if ($like_list_arr) {
            $data['like_list_arr'] = (array)$like_list_arr[0];
        } else {
            $data['like_list_arr'] = array();
        }

        ///review_list_arr_top
        $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $user_profile . "' order by r.review_id desc limit 1";
        $review_list_arr_top = \App\Models\Songs::GetRawData($review_list_qry);
        if ($review_list_arr_top) {
            $data['review_list_arr_top'] = (array)$review_list_arr_top[0];
        } else {
            $data['review_list_arr_top'] = array();
        }

        ///comment_list_arr
        $comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_user_id = '" . $user_profile . "' order by comment_id desc limit 1";
        $comment_list_arr = \App\Models\Songs::GetRawData($comment_list_qry);
        if ($comment_list_arr) {
            $data['comment_list_arr'] = (array)$comment_list_arr[0];
        } else {
            $data['comment_list_arr'] = array();
        }
 

        //page View
        $data['currentFile'] = 'review_album'; 
        $data['title'] = GetTitle();
        return view('review_album', $data);
    }

     //GetAlbumProfileDetail_Four
     public function GetAlbumProfileDetail_Four()
     {
         ///page
         if (isset($_GET['page'])) {
             $page = $_GET['page'];
         } else {
             $page = 1;
         }
 
          $data = array();
 
         ///admin
         if(isset($_GET['user_type']))
         {
             $data['user_type'] = $_GET['user_type'];
             $data = top_file_data($data);
 
         }
         $data['artist_seo'] = null;
         $data['album_seo'] = null;
 
 
         ///common header 
         $data['user_id'] = session()->get('user_id');
         $data['mobile_view'] = 0;
         $data['page'] = $page;
         if (isset($user_seo) && ($user_seo != "")) {
             $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
             $result_image = \App\Models\Songs::GetRawData($qry);
             $data['user_name'] = $result_image[0]->user_name;
             $data['user_profile'] = $result_image[0]->user_id;
             $data['date_added_db'] = $result_image[0]->date_added;
             $data['user_seo'] = $user_seo;
             $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
         } else {
             $data['user_name'] = session()->get('user_name');
             $data['user_profile'] = session()->get('user_id');
             $data['main_link'] = '';
             $data['user_seo'] = '';
         }
 
 
         ///screen char
         $data['screen_chr'] = 15;
         $data['ipad_chr'] = 15;
         $data['mobile_chr'] = 15;
         $data['screen_rev'] = 15;
         $data['ipad_rev'] = 15;
         $data['mobile_rev'] = 15;
 
         if ($data['user_profile'] == "" && $data['user_seo'] == "") {
             return redirect('/');
         }
 
         ///like_list_arr
         $user_profile =  $data['user_profile'];
         $like_list_qry = "select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '" . $user_profile . "' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1";
         $like_list_arr = \App\Models\Songs::GetRawData($like_list_qry);
         if ($like_list_arr) {
             $data['like_list_arr'] = (array)$like_list_arr[0];
         } else {
             $data['like_list_arr'] = array();
         }
 
         ///review_list_arr_top
         $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $user_profile . "' order by r.review_id desc limit 1";
         $review_list_arr_top = \App\Models\Songs::GetRawData($review_list_qry);
         if ($review_list_arr_top) {
             $data['review_list_arr_top'] = (array)$review_list_arr_top[0];
         } else {
             $data['review_list_arr_top'] = array();
         }
 
         ///comment_list_arr
         $comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_user_id = '" . $user_profile . "' order by comment_id desc limit 1";
         $comment_list_arr = \App\Models\Songs::GetRawData($comment_list_qry);
         if ($comment_list_arr) {
             $data['comment_list_arr'] = (array)$comment_list_arr[0];
         } else {
             $data['comment_list_arr'] = array();
         }
  
 
         //page View
         $data['currentFile'] = 'review_album'; 
         $data['title'] = GetTitle();
         return view('review_album', $data);
     }


    
}
