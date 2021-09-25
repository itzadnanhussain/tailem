<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Songs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    ///SongWriteReview
    public function SongWriteReview($song_seo, $artist_seo, $sort = null)
    {
        $data = array();
        $data['song_seo'] = $song_seo;
        $data['artist_seo'] = $artist_seo;
        $data['sort'] = $sort;
        $data['rate'] = '';

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


        ///song list arr
        $song_list_arr = array();
        $song_list = "select a.id as artist_id,b.album_seo,b.album_artist_id, s.itunes_url,s.amazon_url, s.google_url, s.lastfm_url, s.song_title, s.picture, s.song_seo, a.artist_seo, a.artist_name,b.album_title, b.album_picture, s.id,s.description, b.id as album_id from tbl_artist_album b, tbl_artists a, tbl_songs_artist_album saa, tbl_songs s where 1=1 AND s.id = saa.song_id AND a.id = saa.artist_id AND b.id = saa.album_id AND s.song_seo = '$data[song_seo]' AND saa.display_status = 1 AND a.artist_seo = '$data[artist_seo]' AND s.song_status = 1";
        $song_list_arr = \App\Models\Songs::GetRawData($song_list);
        if (isset($song_list_arr) && !empty($song_list_arr)) {
            $data['song_list_arr'] = $song_list_arr;
        } else {
            return redirect('/');
        }


        ///load view
        $data['currentFile'] = 'song_local_detail';
        $data['title'] =  GetTitle();
        return view('song_local_detail', $data);
    }



    ///GetReport
    public function GetReport($rev_id = null, $num = null)
    {
        $data = array();
        $data['rev_id'] = $rev_id;
        $data['num'] = $num;

        ///common header 
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        //  if (isset($user_seo) && ($user_seo != "")) {
        //      $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
        //      $result_image = \App\Models\Songs::GetRawData($qry);
        //      $data['user_name'] = $result_image[0]->user_name;
        //      $data['user_profile'] = $result_image[0]->user_id;
        //      $data['date_added_db'] = $result_image[0]->date_added;
        //      $data['main_link'] = get_user_detail($data['user_name']) . "-profile-";
        //  } else {
        //      $data['user_name'] = session()->get('user_name');
        //      $data['user_profile'] = session()->get('user_id');
        //      $data['main_link'] = '';
        //  } 

        ///load view
        $data['currentFile'] = 'report';
        //   $data['title'] =  GetTitle();
        return view('report', $data);
    }


    ///Review_Edit
    public function Review_Edit()
    {
        $data = array();
        if(isset($_GET['rev_id']))
        {
            $data['rev_id'] = $_GET['rev_id'];
            $data['num'] = $_GET['num'];  
        }

        ///common header 
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        //  if (isset($user_seo) && ($user_seo != "")) {
        //      $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
        //      $result_image = \App\Models\Songs::GetRawData($qry);
        //      $data['user_name'] = $result_image[0]->user_name;
        //      $data['user_profile'] = $result_image[0]->user_id;
        //      $data['date_added_db'] = $result_image[0]->date_added;
        //      $data['main_link'] = get_user_detail($data['user_name']) . "-profile-";
        //  } else {
        //      $data['user_name'] = session()->get('user_name');
        //      $data['user_profile'] = session()->get('user_id');
        //      $data['main_link'] = '';
        //  } 

        ///load view
        $data['currentFile'] = 'edit_review';
        
        //   $data['title'] =  GetTitle();
        return view('edit_review', $data);
    }
    ///Review_Delete
    public function Review_Delete()
    {
        $data = array();
        if(isset($_GET['review_id']))
        {
            $data['review_id'] = $_GET['review_id'];
            $data['num'] = $_GET['num'];  
            $data['critaria'] = $_GET['critaria'];  
        }

        ///common header 
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        //  if (isset($user_seo) && ($user_seo != "")) {
        //      $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
        //      $result_image = \App\Models\Songs::GetRawData($qry);
        //      $data['user_name'] = $result_image[0]->user_name;
        //      $data['user_profile'] = $result_image[0]->user_id;
        //      $data['date_added_db'] = $result_image[0]->date_added;
        //      $data['main_link'] = get_user_detail($data['user_name']) . "-profile-";
        //  } else {
        //      $data['user_name'] = session()->get('user_name');
        //      $data['user_profile'] = session()->get('user_id');
        //      $data['main_link'] = '';
        //  } 

        ///load view
        $data['currentFile'] = 'delete_review'; 
        $data['title'] =  GetTitle();
        return view('delete_review', $data);
    }
}
