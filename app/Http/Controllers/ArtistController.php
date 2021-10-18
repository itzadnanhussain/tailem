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
    public function GetArtistSongs($artist_seo, $sort = null)
    {
        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }


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
        // $qry = "select id, artist_seo, artist_name, artist_description, artist_img, lastfm_url   from tbl_artists where artist_seo='" . $data['artist_seo'] . "' and artist_description!=''";
        $qry = "select id, artist_seo, artist_name, artist_description, artist_img, lastfm_url   from tbl_artists where artist_seo='" . $data['artist_seo'] ."'";

        $row_artist = \App\Models\Songs::GetRawData($qry);
        if (isset($row_artist) && !empty($row_artist)) {
            $data['row_artist'] = (array)$row_artist[0];
        } else {
            return redirect('/');
        }

        $data['currentFile'] = 'artist_page';
        $title = str_replace('-', ' ', ($artist_seo . ' artists songs'));
        $data['title'] = GetTitle();
        return view('artist_page', $data);
    }

    ///GetTopArtistsPage
    public function GetTopArtistsPage($alpha = null)
    {

        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }


        $data = array();
        ///url perameters
        $data['alpha'] = $alpha;
        $data['page'] = $page;
        $data['genere_seo'] = '';



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


        ///artist search request
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if (isset($_POST['submit_b']) && $_POST['submit_b'] != "") {
            extract($_POST);
            if ($artist_name != "") {
                $artist_name = StringReplace($artist_name);
                $search_where = " AND (artist_name like '%$artist_name%')";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }



        //loadview
        $data['currentFile'] = 'artists';
        $data['title'] = GetTitle();

        return view('artists', $data);
    }


    ///GetTopArtistsPageByGenereSoe
    public function GetTopArtistsPageByGenereSoe($genere_seo, $alpha = null)
    {

        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }


        $data = array();
        ///url perameters
        $data['alpha'] = $alpha;
        $data['page'] = $page;
        $data['genere_seo'] = $genere_seo;



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


        ///artist search request
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if (isset($_POST['submit_b']) && $_POST['submit_b'] != "") {
            extract($_POST);
            if ($artist_name != "") {
                $artist_name = StringReplace($artist_name);
                $search_where = " AND (artist_name like '%$artist_name%')";

                $data['search_artist_names'] = $artist_name;
                $data['search_result'] = $search_where;
            }
        }



        //loadview
        $data['currentFile'] = 'artists';
        $data['title'] = GetTitle();

        return view('artists', $data);
    }


    ///GetArtistsFeaturedPage
    public function GetArtistsFeaturedPage($artist_seo)
    {

        ///page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }


        $data = array();
        ///url perameters
        $data['alpha'] = null;
        $data['page'] = $page;
        $data['artist_seo'] = $artist_seo;



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


        ///artist search request
        $data['search_artist_names'] = '';
        $data['search_result'] = '';
        if (isset($_POST['submit_b']) && $_POST['submit_b'] != "") {
            extract($_POST);
            if ($artist_name != "") {
                $artist_name = StringReplace($artist_name);
                $search_where = " AND (artist_name like '%$artist_name%')";

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



        ///page code
        $qry      =  "select * from tbl_artists where artist_seo='" . $artist_seo . "'";
        $row_artist = \App\Models\Songs::GetRawData($qry);
        if ($row_artist) {
            $data['row_artist'] = (array)$row_artist[0];
        } else {
            redirect('/');
        }


        //loadview
        $data['currentFile'] = 'featured_page';
        $data['title'] = GetTitle();

        return view('featured_page', $data);
    }


    ///GetPreviewArtist
    public function GetPreviewArtist($artist_seo)
    {
        $data = array();
        $data['artist_seo'] = $artist_seo;
        $data['page'] = null;
        $data['sort'] = null;

        if(isset($_GET['page']))
        {
            $data['page'] = $_GET['page'];
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


        $data['currentFile'] = 'preview_artist';
        $data['title'] = GetTitle();
        return view('preview_artist', $data);
    }
}
