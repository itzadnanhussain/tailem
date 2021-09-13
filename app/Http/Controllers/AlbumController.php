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

        ///screen char
        $data['screen_chr'] = 15;
        $data['ipad_chr'] = 15;
        $data['mobile_chr'] = 15;
        $data['screen_rev'] = 15;
        $data['ipad_rev'] = 15;
        $data['mobile_rev'] = 15;

        //page View
        $data['currentFile'] = 'album';
        return view('album', $data);
    }


    //GetAlbumDetail
    public function GetAlbumDetail($artist_seo, $album_seo = null, $page = null)
    {
        $data = array();
        $data['artist_seo'] = $artist_seo;
        $data['album_seo'] = $album_seo;
        ///common header
        $data['currentFile'] = get_page_name();
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;
        $data['page'] = $page;

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


         ///screen char
         $data['screen_chr'] = 15;
         $data['ipad_chr'] = 15;
         $data['mobile_chr'] = 15;
         $data['screen_rev'] = 15;
         $data['ipad_rev'] = 15;
         $data['mobile_rev'] = 15;



        ///file code
        $row_artist = array();
        $qry = "select id,artist_seo,artist_name,artist_description,artist_img,lastfm_url from tbl_artists where artist_seo='".$data['artist_seo']."' and artist_description!=''";
        $row_artist = \App\Models\Songs::GetRawData($qry);
        if (isset($row_artist) && !empty($row_artist)) {
            $data['row_artist'] =(array) $row_artist[0];
        } else {
            return redirect('/');
        }


        //page View
        $data['currentFile'] = 'albums_page';
        return view('albums_page', $data);
    }
}
