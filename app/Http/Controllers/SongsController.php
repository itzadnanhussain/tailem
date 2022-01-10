<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Songs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class SongsController extends Controller
{
    ///GetLoadHomePage
    public function GetLoadHomePage()
    {
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }



        ///screen char
        $data['screen_chr'] = 15;
        $data['ipad_chr'] = 15;
        $data['mobile_chr'] = 15;
        $data['screen_rev'] = 15;
        $data['ipad_rev'] = 15;
        $data['mobile_rev'] = 15;

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


        //page View
        $data['title'] = "Music Reviews";
        $data['currentFile'] = 'home';
        return view('index', $data);
    }


    ///GetTopSongs
    public function GetTopSongs()
    {
        $data = array();
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
        $data['currentFile'] = 'top-songs';
        $data['title'] = GetTitle();
        return view('top_songs', $data);
    }

    ///GetLatestSongs
    public function GetLatestSongs()
    {

        ///song artist
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


        ///Review Song
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
        $data['title'] = GetTitle();
 
        //page View
        return view('latest_songs', $data);
    }

    ///GetAddPlayList
    public function GetAddPlayList()
    {
        $song_id = $_GET['song_id'];
        $art_id = $_GET['art_id'];
        return view('add_playlist', compact('song_id', 'art_id'));
    }


    ///InsertPlayList
    public function InsertPlayList()
    {
        $song_id = $_GET['song_id'];
        $art_id = $_GET['art_id'];
        return view('insert_playlist', compact('song_id', 'art_id'));
    }
 
    ///GetSongDetailBySort
    public function GetSongDetailBySort($song_seo, $artist_seo, $sort = null, $page = null)
    {
        $data = array();
        $data['song_seo'] =  $song_seo;
        $data['artist_seo'] = $artist_seo;
        $data['sort'] = $sort;
        $data['rate'] = null;
        $data['page'] = $page;

        

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
        // $song_list = "select a.id as artist_id,b.album_seo,b.album_artist_id, s.itunes_url,s.amazon_url, s.google_url, s.lastfm_url, s.song_title, s.picture, s.song_seo, a.artist_seo, a.artist_name,b.album_title, b.album_picture, s.id,s.description, b.id as album_id from tbl_artist_album b, tbl_artists a, tbl_songs_artist_album saa, tbl_songs s where s.id = saa.song_id AND a.id = saa.artist_id AND b.id = saa.album_id AND s.song_seo = '".$data['song_seo']."' AND saa.display_status = 1 AND a.artist_seo = '".$data['artist_seo']."' AND s.song_status = 1";
        $song_list = "select a.id as artist_id,b.album_seo,b.years,b.album_artist_id, s.itunes_url,s.amazon_url, s.google_url, s.lastfm_url, s.song_title, s.picture, s.song_seo, a.artist_seo, a.artist_name,b.album_title, b.album_picture, s.id,s.description, b.id as album_id from tbl_artist_album b, tbl_artists a, tbl_songs_artist_album saa, tbl_songs s where s.id = saa.song_id AND a.id = saa.artist_id AND b.id = saa.album_id AND s.song_seo = '".$data['song_seo']."' AND a.artist_seo = '".$data['artist_seo']."' AND s.song_status = 1";
        $song_list_arr = \App\Models\Songs::GetRawDataAdmin($song_list);
        // echo '<pre>';
        // print_r($song_list_arr);
        // echo '</pre>';
        // die;
        
     
        if (isset($song_list_arr) && !empty($song_list_arr)) {
            $data['song_list_arr'] = $song_list_arr;
        // $data['song_id'] = $song_list_arr[0]->id;
        } else {
            return redirect('/');
        }

        $data['currentFile'] = 'song_detail';
        $data['title'] = GetTitle();
        return view('song_detail', $data);
    }


    ///GetSongDetailByRating
    public function GetSongDetailByRating($song_seo, $artist_seo, $rate = null, $page = null)
    {
        $data = array();
        $data['song_seo'] =  $song_seo;
        $data['artist_seo'] = $artist_seo;
        $data['sort'] = null;
        $data['rate'] = $rate;
        $data['page'] = $page;

        

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

        $data['currentFile'] = 'song_detail';
        $data['title'] = GetTitle();
        return view('song_detail', $data);
    }

    
    ///GetSongDetailReviewsList
    public function GetSongDetailReviewsList($song_seo, $artist_seo, $page = null)
    {
        $data = array();
        $data['song_seo'] =  $song_seo;
        $data['artist_seo'] = $artist_seo;
        $data['sort'] = null;
        $data['rate'] = null;
        $data['page'] = $page;

        

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

        $data['currentFile'] = 'song_detail';
        $data['title'] =GetTitle();
         
        return view('song_detail', $data);
    }
}
