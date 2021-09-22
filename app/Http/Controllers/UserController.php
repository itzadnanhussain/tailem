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
        $data['currentFile'] = 'welcome';

        return view('welcome', $data);
    }


    ///*************************Review Artist Page **************************** */
    //GetReviewArtistPage_One
    public function GetReviewArtistPage_One($user_seo, $alpha = null, $page = null)
    {

        $data = array();



        $data['user_seo'] = strtolower($user_seo);
        $data['alpha'] = $alpha;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = '';
        $data['album_seo'] = '';
        $data['sr_no'] = '';
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }



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
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }


        //loadview
        $data['currentFile'] = 'review_artist';
        $title = str_replace('-', ' ', ($user_seo . ' Profile  review-artist'));
        $data['title'] = ucwords($title);
        return view('review_artist', $data);
    }


    //GetReviewArtistPage_Two
    public function GetReviewArtistPage_Two($user_seo, $genere_seo, $alpha = null, $page = null)
    {

        $data = array();
        $data['user_seo'] = strtolower($user_seo);
        $data['alpha'] = $alpha;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = '';
        $data['album_seo'] = '';
        $data['sr_no'] = '';
        $data['page'] = $page;
        $data['genere_seo'] = $genere_seo;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

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
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }


        //loadview
        $data['currentFile'] = 'review_artist';
        $title = str_replace('-', ' ', ($user_seo . ' Profile  review-artist'));
        $data['title'] = ucwords($title);
        return view('review_artist', $data);
    }


    //GetReviewArtistPage_Three
    public function GetReviewArtistPage_Three($user_seo, $genere_seo, $page = null)
    {

        $data = array();
        $data['user_seo'] = strtolower($user_seo);
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = '';
        $data['album_seo'] = '';
        $data['sr_no'] = '';
        $data['page'] = $page;
        $data['genere_seo'] = $genere_seo;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

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
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }


        //loadview
        $data['currentFile'] = 'review_artist';
        $title = str_replace('-', ' ', ($user_seo . ' Profile  review-artist'));
        $data['title'] = ucwords($title);
        return view('review_artist', $data);
    }


    //GetReviewArtistPage_Four
    public function GetReviewArtistPage_Four($page = null)
    {

        $data = array();
        $data['user_seo'] = null;
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = '';
        $data['album_seo'] = '';
        $data['sr_no'] = '';
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

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
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }


        //loadview
        $data['currentFile'] = 'review_artist';
        $title = str_replace('-', ' ', ('review-artist'));
        $data['title'] = ucwords($title);
        return view('review_artist', $data);
    }



    ///*****************************My Review Page ****************************** */
    ///GetMyReviewsPage_One
    public function GetMyReviewsPage_One($user_seo, $rate, $alpha = null, $page = null)
    {


        $data = array();
        $data['user_seo'] = strtolower($user_seo);
        $data['alpha'] = $alpha;
        $data['rate'] = $rate;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['album_seo'] = null;
        $data['sr_no'] = null;
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        $title = str_replace('-', ' ', ('review-songs-rating ' . $rate));
        $data['title'] = ucwords($title);
        return view('my_reviews', $data);
    }

    ///GetMyReviewsPage_Two
    public function GetMyReviewsPage_Two($user_seo, $sort = null, $page = null)
    {


        $data = array();
        $data['user_seo'] = strtolower($user_seo);
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = $sort;
        $data['artseo'] = null;
        $data['album_seo'] = null;
        $data['sr_no'] = null;
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        $title = str_replace('-', ' ', ($user_seo . ' Profile  review-songs-rating'));
        $data['title'] = ucwords($title);
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Three
    public function GetMyReviewsPage_Three($user_seo, $album_seo, $artseo, $sort = null, $page = null)
    {


        $data = array();
        $data['user_seo'] = strtolower($user_seo);
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = $sort;
        $data['artseo'] = $artseo;
        $data['album_seo'] = $album_seo;
        $data['sr_no'] = null;
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        $title = str_replace('-', ' ', ($user_seo . ' Profile  review-songs-rating'));
        $data['title'] = ucwords($title);
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Four
    public function GetMyReviewsPage_Four($user_seo, $album_seo, $artseo = null, $page = null)
    {


        $data = array();
        $data['user_seo'] = strtolower($user_seo);
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = $artseo;
        $data['album_seo'] = $album_seo;
        $data['sr_no'] = null;
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        $title = str_replace('-', ' ', ($user_seo . ' Profile  review-songs-rating'));
        $data['title'] = ucwords($title);
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Five
    public function GetMyReviewsPage_Five($user_seo, $page = null)
    {


        $data = array();
        $data['user_seo'] = strtolower($user_seo);
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['album_seo'] = null;
        $data['sr_no'] = null;
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        $title = str_replace('-', ' ', ($user_seo . ' Profile  review-songs-rating'));
        $data['title'] = ucwords($title);
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Six
    public function GetMyReviewsPage_Six($artseo, $album_seo, $sort, $page = null)
    {


        $data = array();
        $data['user_seo'] = null;
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = $sort;
        $data['artseo'] = $artseo;
        $data['album_seo'] = $album_seo;
        $data['sr_no'] = null;
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        // $title = str_replace('-', ' ', ($user_seo . ' Profile  review-songs-rating'));
        // $data['title'] = ucwords($title);

        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Seven
    public function GetMyReviewsPage_Seven($artseo, $album_seo, $page = null)
    {


        $data = array();
        $data['user_seo'] = null;
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = $artseo;
        $data['album_seo'] = $album_seo;
        $data['sr_no'] = null;
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        // $title = str_replace('-', ' ', ($user_seo . ' Profile  review-songs-rating'));
        // $data['title'] = ucwords($title);
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Eight
    public function GetMyReviewsPage_Eight($album_seo)
    {


        $data = array();
        $data['user_seo'] = null;
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['album_seo'] = $album_seo;
        $data['sr_no'] = null;
        $data['page'] = null;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        // $title = str_replace('-', ' ', ($user_seo . ' Profile  review-songs-rating'));
        // $data['title'] = ucwords($title);
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Nine
    public function GetMyReviewsPage_Nine($user_seo)
    {


        $data = array();
        $data['user_seo'] = $user_seo;
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['album_seo'] = null;
        $data['sr_no'] = null;
        $data['page'] = null;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        $title = str_replace('-', ' ', ($user_seo . ' Profile  review-songs-rating'));
        $data['title'] = ucwords($title);
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Ten
    public function GetMyReviewsPage_Ten($rate, $sort, $page = null)
    {


        $data = array();
        $data['user_seo'] = null;
        $data['alpha'] = null;
        $data['rate'] = $rate;
        $data['sort'] = $sort;
        $data['artseo'] = null;
        $data['album_seo'] = null;
        $data['sr_no'] = null;
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        $title = str_replace('-', ' ', ('review-songs-rating ' . $rate));
        $data['title'] = ucwords($title);
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Eleven
    public function GetMyReviewsPage_Eleven($rate, $page = null)
    {


        $data = array();
        $data['user_seo'] = null;
        $data['alpha'] = null;
        $data['rate'] = $rate;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['album_seo'] = null;
        $data['sr_no'] = null;
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        $title = str_replace('-', ' ', ('review-songs-rating ' . $rate));
        $data['title'] = ucwords($title);
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Twelve
    public function GetMyReviewsPage_Twelve($sort, $page = null)
    {


        $data = array();
        $data['user_seo'] = null;
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = $sort;
        $data['artseo'] = null;
        $data['album_seo'] = null;
        $data['sr_no'] = null;
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }


        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        // $title = str_replace('-', ' ', ($user_seo . ' Profile  review-songs-rating'));
        // $data['title'] = ucwords($title);
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Thirteen
    public function GetMyReviewsPage_Thirteen($page = null)
    {


        $data = array();
        $data['user_seo'] = null;
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['album_seo'] = null;
        $data['sr_no'] = null;
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        // $title = str_replace('-', ' ', ($user_seo . ' Profile  review-songs-rating'));
        // $data['title'] = ucwords($title);
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Fourteen
    public function GetMyReviewsPage_Fourteen($user_seo, $rate,  $page = null)
    {


        $data = array();
        $data['user_seo'] = $user_seo;
        $data['alpha'] = null;
        $data['rate'] = $rate;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['album_seo'] = null;
        $data['sr_no'] = null;
        $data['page'] = $page;
        $data['genere_seo'] = null;

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }

        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
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





        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }



        //loadview
        $data['currentFile'] = 'my_reviews';
        $title = str_replace('-', ' ', ($user_seo . ' Profile  review-songs-rating'));
        $data['title'] = ucwords($title);
        return view('my_reviews', $data);
    }


    ///ChangePictureProcess
    public function ChangePictureProcess()
    {
        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['user_profile'] = session()->get('user_id');
        $data['user_name'] = session()->get('user_name');
        $data['mobile_view'] = 0;
        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
        } else {
            $data['user_name'] = session()->get('user_name');
            $data['user_profile'] = session()->get('user_id');
            $data['main_link'] = '';
        }

        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }


        //loadview
        $data['currentFile'] = 'change_picture';
        $title = str_replace('-', ' ', ('change picture'));
        $data['title'] = ucwords($title);
        return view('change_picture', $data);
    }


    ///ChangePasswordProcess
    public function ChangePasswordProcess()
    {
        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['user_profile'] = session()->get('user_id');
        $data['user_name'] = session()->get('user_name');
        $data['mobile_view'] = 0;
        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
        } else {
            $data['user_name'] = session()->get('user_name');
            $data['user_profile'] = session()->get('user_id');
            $data['main_link'] = '';
        }

        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }


        //loadview
        $data['currentFile'] = 'change_password';
        $title = str_replace('-', ' ', ('change password'));
        $data['title'] = ucwords($title);
        return view('change_password', $data);
    }

    ///ChangeUsernameProcess
    public function ChangeUsernameProcess()
    {
        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['user_profile'] = session()->get('user_id');
        $data['user_name'] = session()->get('user_name');
        $data['mobile_view'] = 0;
        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "/profile-";
        } else {
            $data['user_name'] = session()->get('user_name');
            $data['user_profile'] = session()->get('user_id');
            $data['main_link'] = '';
        }

        ///redirect
        if (isset($user_id) && empty($user_id)) {
            return redirect('/');
        }


        //loadview
        $data['currentFile'] = 'edit_username';
        $title = str_replace('-', ' ', ('edit username'));
        $data['title'] = ucwords($title);
        return view('edit_username', $data);
    }


    ///GetMyAccountProfile
    public function GetMyAccountProfile($user_seo)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        $data = array();
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
        $data['currentFile'] = 'my_account_profile';
        $data['title'] = GetTitle();
        return view('my_account_profile', $data);
    }



    ///GetProfileLike_One
    public function GetProfileLike_One($user_seo , $alpha = null)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        $data = array(); 
        $data['user_seo'] = strtolower($user_seo);
        $data['alpha'] = $alpha;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['album_seo'] = null;
        $data['sr_no'] = '';
        $data['page'] = $page;
        $data['genere_seo'] = null;


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

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
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
        $data['currentFile'] = 'like_artist';
        $data['title'] = GetTitle();
        return view('like_artist', $data);
    }


    ///GetProfileLikesProfile
    public function GetProfileLikesProfile($user_seo = null)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        $data = array(); 
        $data['user_seo'] = strtolower($user_seo);
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['album_seo'] = null;
        $data['sr_no'] = '';
        $data['page'] = $page;
        $data['genere_seo'] = null;


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

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
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
        $data['currentFile'] = 'likes_profile';
        $data['title'] = GetTitle();
        return view('likes_profile', $data);
    }


    ///GetProfilePlaylist
    public function GetProfilePlaylist($user_seo = null)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        $data = array(); 
        $data['user_seo'] = strtolower($user_seo);
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['album_seo'] = null;
        $data['sr_no'] = '';
        $data['page'] = $page;
        $data['genere_seo'] = null;


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

        ///search code
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if ($_POST) {
            extract($_POST);
            if ($artist_name != "") {

                $artist_name = StringReplace($artist_name);
                $search_where = " AND a.artist_name like '%$artist_name%'";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
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
        $data['currentFile'] = 'likes_playlist';
        $data['title'] = GetTitle();
        return view('likes_playlist', $data);
    }
}
