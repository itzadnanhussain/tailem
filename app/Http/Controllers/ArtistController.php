<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Songs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    ///GetArtistSongs
    public function GetArtistSongs($artist_seo, $sort = null,  $page = null)
    {

        $data = array();
        $data['artist_seo'] =  strtolower($artist_seo);


        ///handle sorting and paging
        $data['sort'] = $sort;
        $data['page'] = $page;
        if (is_numeric($sort)) {
            $data['sort'] = '';
            $data['page'] = $sort;
        }




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

        ///screen char
        $data['screen_chr'] = 15;
        $data['ipad_chr'] = 15;
        $data['mobile_chr'] = 15;
        $data['screen_rev'] = 15;
        $data['ipad_rev'] = 15;
        $data['mobile_rev'] = 15;

        ///row_artist
        $row_artist = array();
        $qry = "select id, artist_seo, artist_name, artist_description, artist_img, lastfm_url   from tbl_artists where artist_seo='" . $data['artist_seo'] . "' and artist_description!=''";

        $row_artist = \App\Models\Songs::GetRawData($qry);
        if (isset($row_artist) && !empty($row_artist)) {
            $data['row_artist'] = (array)$row_artist[0];
        } else {
            return redirect('/');
        }

        $data['currentFile'] = 'artist_page';
        return view('artist_page', $data);
    }

    ///GetTopArtistsPage
    public function GetTopArtistsPage($alpha = null, $page = null)
    {
        $data = array();
        $data['alpha'] = $alpha;
        $data['page'] = $page;
        $data['genere_seo'] = '';
        $data['search_artist_names'] = '';
        $data['search_result'] = '';




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



        //loadview
        $data['currentFile'] = 'artists';
        if(!empty($alpha))
        {
            $title = str_replace('-', ' ', ('artists '.$alpha));

        }else{

            $title = str_replace('-', ' ', ('top artists'));
        }
        $data['title'] = ucwords($title);

        return view('artists', $data);
    }
}
