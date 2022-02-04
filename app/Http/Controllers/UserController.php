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
    public function UserWelcome($user_seo)
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

        if (isset($user_seo)) {
            $get_user_content_qry = "SELECT user_name FROM tbl_users WHERE user_seo = '" . $user_seo . "'";
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
        $data['title'] = GetTitle();

        return view('welcome', $data);
    }


    ///*************************Review Artist Page **************************** */
    //GetReviewArtistPage_One
    public function GetReviewArtistPage_One($user_seo, $alpha = null, $page = null)
    {



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }





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
            if (empty($result_image)) {
                return redirect('/');
            }
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
        $data['title'] = GetTitle();
        return view('review_artist', $data);
    }


    //GetReviewArtistPage_Two
    public function GetReviewArtistPage_Two($user_seo, $genere_seo, $alpha = null, $page = null)
    {



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('review_artist', $data);
    }


    //GetReviewArtistPage_Three
    public function GetReviewArtistPage_Three($user_seo, $genere_seo, $page = null)
    {



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('review_artist', $data);
    }

    //GetReviewArtistPage_Four
    public function GetReviewArtistPage_Four($page = null)
    {



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['currentFile'] = 'review-artist';
        $data['title'] = GetTitle();


        return view('review_artist', $data);
    }


    ///*****************************My Review Page ****************************** */
    ///GetMyReviewsPage_One
    public function GetMyReviewsPage_One($user_seo, $rate, $alpha = null, $page = null)
    {




        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('my_reviews', $data);
    }

    ///GetMyReviewsPage_Two
    public function GetMyReviewsPage_Two($user_seo, $sort = null, $page = null)
    {


        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Three
    public function GetMyReviewsPage_Three($user_seo, $album_seo, $artseo, $sort = null, $page = null)
    {




        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Four
    public function GetMyReviewsPage_Four($user_seo, $album_seo, $artseo = null, $page = null)
    {




        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Five
    public function GetMyReviewsPage_Five($user_seo, $page = null)
    {




        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Six
    public function GetMyReviewsPage_Six($artseo, $album_seo, $sort, $page = null)
    {




        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();

        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Seven
    public function GetMyReviewsPage_Seven($artseo, $album_seo, $page = null)
    {




        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Eight
    public function GetMyReviewsPage_Eight($album_seo)
    {




        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('my_reviews', $data);
    }
    ///GetMyReviewsPage_Eight_One
    public function GetMyReviewsPage_Eight_One($artseo, $album_seo)
    {




        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
        $data['user_seo'] = null;
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = $artseo;
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
        $data['title'] = GetTitle();
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Nine
    public function GetMyReviewsPage_Nine($user_seo)
    {




        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Ten
    public function GetMyReviewsPage_Ten($rate, $sort, $page = null)
    {




        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Eleven
    public function GetMyReviewsPage_Eleven($rate, $page = null)
    {




        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Twelve
    public function GetMyReviewsPage_Twelve($sort, $page = null)
    {
        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Thirteen
    public function GetMyReviewsPage_Thirteen($page = null)
    {




        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
        return view('my_reviews', $data);
    }


    ///GetMyReviewsPage_Fourteen
    public function GetMyReviewsPage_Fourteen($user_seo, $rate, $page = null)
    {




        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
        $data['title'] = GetTitle();
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
        $data['title'] = GetTitle();
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
        $data['title'] = GetTitle();
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
        $data['title'] = GetTitle();
        return view('edit_username', $data);
    }


    ///UpdateProfileSocialIcon
    public function UpdateProfileSocialIcon()
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
        $data['currentFile'] = 'edit_social_icons';
        $data['title'] = GetTitle();
        return view('edit_social_icons', $data);
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



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
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
        $data['currentFile'] = 'my_account_profile';
        $data['title'] = GetTitle();

        return view('my_account_profile', $data);
    }


    ///GetLikeArtistsGenre
    public function GetLikeArtistsGenre($genere_seo)
    {

        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
        $data['user_seo'] = null;
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['album_seo'] = null;
        $data['sr_no'] = '';
        $data['page'] = $page;
        $data['genere_seo'] = $genere_seo;


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


    ///GetProfileLike_One
    public function GetProfileLike_One($user_seo, $alpha = null)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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


    ///LikeArtist
    public function LikeArtist()
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
        $data['user_seo'] = null;
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
        $data['currentFile'] = 'like_artist';
        $data['title'] = GetTitle();
        return view('like_artist', $data);
    }
    ///LikeArtistByAlpha
    public function LikeArtistByAlpha($alpha)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
        $data['user_seo'] = null;
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



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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

    ///GetProfileLikePlaylist
    public function GetProfileLikePlaylist($user_seo = null)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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

    ///GetProfileDiscussion
    public function GetProfileDiscussion($user_seo = null)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
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
            if (empty($result_image)) {
                return redirect('/');
            }
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
        $data['currentFile'] = 'my_discussion';
        $data['title'] = GetTitle();
        return view('my_discussion', $data);
    }

    ///GetProfilePlaylist
    public function GetProfilePlaylist($user_seo = null, $seo_playlist = null)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
        $data['user_seo'] = strtolower($user_seo);
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['seo_playlist'] = $seo_playlist;
        $data['album_seo'] = null;
        $data['sr_no'] = '';
        $data['page'] = $page;
        $data['genere_seo'] = null;


        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        $data['page'] = $page;
        if (isset($user_seo) && !empty($user_seo)) {
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
        $data['currentFile'] = 'my_playlist';
        $data['title'] = GetTitle();

        return view('my_playlist', $data);
    }

    ///GetProfilePlaylist_1
    public function GetProfilePlaylist_1($seo_playlist = null)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
        $data['user_seo'] = null;
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['seo_playlist'] = $seo_playlist;
        $data['album_seo'] = null;
        $data['sr_no'] = '';
        $data['page'] = $page;
        $data['genere_seo'] = null;


        ///common header
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        $data['page'] = $page;
        if (isset($user_seo) && !empty($user_seo)) {
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
        $data['currentFile'] = 'my_playlist';
        $data['title'] = GetTitle();

        return view('my_playlist', $data);
    }

    ///GetLikeReview
    public function GetLikeReview()
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }



        ///admin
        $data = array();

        ///admin
        if (isset($_GET['user_type'])) {
            $data['user_type'] = $_GET['user_type'];
            $data = top_file_data($data);
        }
        $data['user_seo'] = null;
        $data['alpha'] = null;
        $data['rate'] = null;
        $data['sort'] = null;
        $data['artseo'] = null;
        $data['seo_playlist'] = null;
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

        if ($data['user_profile'] == "") {
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
        $data['currentFile'] = 'my_account';
        $data['title'] = GetTitle();
        return view('my_account', $data);
    }

    ///DeleteUserProfile
    public function DeleteUserProfile()
    {
        if ($_POST) {
            extract($_POST);
            $delete_profile = false;
            ///Delete Process
            $path = 'site_upload/user_images/';
            $select_qry = "select user_id from tbl_users where user_id='" . $_POST['user_id'] . "' ";
            $select_arr = \App\Models\Songs::GetRawDataAdmin($select_qry);
            $user_id    = $select_arr['user_id'];
            if ($user_id == "") {
                $delete_profile = false;
            } else {
                $select_img = "select profile_image from tbl_users where user_id='" . $user_id . "'";
                $result = \App\Models\Songs::GetRawDataAdmin($select_img);

                ///delete profile
                if ($result) {
                    $old_image  = $result['profile_image'];
                    $imgfile    = $path . $old_image;
                    $thumbfile  =  $path . 'thumb_' . $old_image;
                    $thumbfile_small = $path . 'small_thumb_' . $old_image;
                    @unlink($imgfile);
                    @unlink($thumbfile);
                    @unlink($thumbfile_small);
                }

                ///delete other user data
                $del_qry = "Delete from tbl_users where user_id='" . $user_id . "'";
                \App\Models\Songs::GetRawData($del_qry);

                $del_qry = "Delete from tbl_likes where like_from_user_id='" . $user_id . "'";
                \App\Models\Songs::GetRawData($del_qry);

                $del_qry = "Delete from tbl_reviews where review_user_id='" . $user_id . "'";
                \App\Models\Songs::GetRawData($del_qry);


                $del_qry = "Delete from tbl_review_report where r_report_user_id='" . $user_id . "'";
                \App\Models\Songs::GetRawData($del_qry);


                $del_qry = "Delete from tbl_comments where comment_user_id='" . $user_id . "'";
                \App\Models\Songs::GetRawData($del_qry);

                $delete_profile = true;
            }


            ///After Successfully delete profile
            if ($delete_profile == true) {
                session()->invalidate();
                session()->regenerateToken();
                $redirect_uri = SERVER_ROOTPATH;
                $response = array("code" => 'success', 'redirect_uri' => $redirect_uri);
                return response()->json($response);
            } else {

                ///After Not Successfully delete profile
                $response = array("code" => 'warning', 'message' => 'Something Wrong Here!');
                return response()->json($response);
            }
        }
    }

    public function UploadProfileSocialIcon(Request $request)
    {
        $data = array();
        extract($_POST);
        $validator = Validator::make($request->all(), [
            'icon_type' => 'required',
            'icon_link' => 'required',
            // 'icon_image' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:2048',
        ]);
        if ($validator->fails()) {
            $response = array("code" => 'warning', 'message' => $validator->errors()->first());
            return response()->json($response);
        } else {
            $data['user_id'] = $user_id;
            $data['icon_type'] = $icon_type;
            $data['social_link'] = $icon_link;
            // $data['icon_image'] = $filename;
            $where = array('user_id' => $user_id, 'icon_type' => $icon_type);
            $check_record = GetByWhere('user_social_profile', $where);
            if ($check_record) {
                UpdateRecord('user_social_profile', $where, $data);
            } else {
                addNew('user_social_profile', $data);
            }

            $response = array("code" => 'success', 'message' => 'Link Updated!');
            return response()->json($response);
            // if ($request->file('icon_image')) {
            //     $file = $request->file('icon_image');
            //     $filename = $file->getClientOriginalName();
            //     // File extension
            //     // $extension = $file->getClientOriginalExtension();

            //     // File upload location
            //     $location = 'profile_icon/'.$user_id;
            //     if (!file_exists($location)) {
            //         mkdir($location, 0777, true);
            //     }
            //     // Upload file
            //     $file->move($location, $filename);
            // // File path
            //     // $filepath = url('profile_icon/' . $filename);
            // } else {
            //     $response = array("code" => 'warning', 'message' => 'icon not uploaded!');
            //     return response()->json($response);
            // }
        }
    }
}
