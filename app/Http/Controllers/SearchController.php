<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Songs;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    ///PostHomePageSearch
    public function PostHomePageSearch($page = null)
    {

        if (isset($_REQUEST['submitbtn']) && $_REQUEST['submitbtn'] != "") {
            extract($_POST);
            $data = array();
 
            if ($search != "" || session()->get('main_search') != '') {
                $search = trim($search);
                $word_array = explode(" ", $search);
                $search_where = '';
                $search_where_album = '';
                $search_where_song = '';
                $size_array  = sizeof($word_array);
                for ($k = 0; $k < $size_array; $k++) {

                    if ($k == 0 && ($size_array - 1) == $k) {
                        $search_where .= "AND (";
                        $search_where .= " artist_name Like '%" . $word_array[$k] . "%')";
                    } else
                        if ($k == 0) {
                        $search_where .= "AND (";
                        $search_where .= " artist_name Like '%" . $word_array[$k] . "%'";
                    } else
                        if (($size_array - 1) == $k) {
                        $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%')";
                    } else {
                        $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%' ";
                    }
                }

                //select b.album_seo, b.db_art_id, a.artist_seo,a.artist_name,b.album_title, b.album_picture, b.id, a.artist_seo from tbl_artist_album b, tbl_artists a where 1=1 AND b.album_status = 1  AND a.id = b.db_art_id AND b.ranking_order!=0 order by b.ranking_order asc
                for ($k = 0; $k < $size_array; $k++) {

                    if ($k == 0 && ($size_array - 1) == $k) {
                        $search_where_album .= "AND (";
                        $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%'))";
                    } else
                        if ($k == 0) {
                        $search_where_album .= "AND (";
                        $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%')";
                    } else
                        if (($size_array - 1) == $k) {
                        $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%'))";
                    } else {
                        $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%') ";
                    }
                }



                // $data['main_search'] = $search;
                // $data['main_result'] = $search_where;
                // $data['main_result_song'] = $search_where_song;
                // $data['main_result_album'] = $search_where_album; 

                session()->put('main_search', $search);
                session()->put('main_result', $search_where);
                session()->put('main_result_song', $search_where_song);
                session()->put('main_result_album', $search_where_album);

                $data['c'] = null;
                $data['sr_no'] = null;
            } else {
                
                redirect('/');
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
                $data['main_link'] = get_user_detail($data['user_name']) . "-profile-";
            } else {
                $data['user_name'] = session()->get('user_name');
                $data['user_profile'] = session()->get('user_id');
                $data['main_link'] = '';
            }

            ///load view
            $data['currentFile'] = 'search';
            $data['title'] = GetTitle();
            return view('search', $data);
        }
    }

    ///GetHomePageSearch
    public function GetHomePageSearch($page = null)
    {

        $data = array(); 
        $search = session()->get('main_search');
        if ($search != "") {
            $search = trim($search);
            $word_array = explode(" ", $search);
            $search_where = '';
            $search_where_album = '';
            $search_where_song = '';
            $size_array  = sizeof($word_array);


            for ($k = 0; $k < $size_array; $k++) {

                if ($k == 0 && ($size_array - 1) == $k) {
                    $search_where .= "AND (";
                    $search_where .= " artist_name Like '%" . $word_array[$k] . "%')";
                } else
                    if ($k == 0) {
                    $search_where .= "AND (";
                    $search_where .= " artist_name Like '%" . $word_array[$k] . "%'";
                } else
                    if (($size_array - 1) == $k) {
                    $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%')";
                } else {
                    $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%' ";
                }
            }

            //select b.album_seo, b.db_art_id, a.artist_seo,a.artist_name,b.album_title, b.album_picture, b.id, a.artist_seo from tbl_artist_album b, tbl_artists a where 1=1 AND b.album_status = 1  AND a.id = b.db_art_id AND b.ranking_order!=0 order by b.ranking_order asc
            for ($k = 0; $k < $size_array; $k++) {

                if ($k == 0 && ($size_array - 1) == $k) {
                    $search_where_album .= "AND (";
                    $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%'))";
                } else
                    if ($k == 0) {
                    $search_where_album .= "AND (";
                    $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%')";
                } else
                    if (($size_array - 1) == $k) {
                    $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%'))";
                } else {
                    $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%') ";
                }
            }


            session()->put('main_search', $search);
            session()->put('main_result', $search_where);
            session()->put('main_result_song', $search_where_song);
            session()->put('main_result_album', $search_where_album);


            $data['c'] = null;
            $data['sr_no'] = null;
        } else {
            
            redirect('/');
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
            $data['main_link'] = get_user_detail($data['user_name']) . "-profile-";
        } else {
            $data['user_name'] = session()->get('user_name');
            $data['user_profile'] = session()->get('user_id');
            $data['main_link'] = '';
        }

        ///load view
        $data['currentFile'] = 'search';
        $data['title'] = GetTitle();
        return view('search', $data);
    }


    ///PostSearchResultSongs
    public function PostSearchResultSongs($page = null)
    {

        if (isset($_REQUEST['submitbtn']) && $_REQUEST['submitbtn'] != "") {
            extract($_POST);
            $data = array(); 
            if ($search != "" || session()->get('main_search') != '') {
                $search = trim($search);
                $word_array = explode(" ", $search);
                $search_where = '';
                $search_where_album = '';
                $search_where_song = '';
                $size_array  = sizeof($word_array);
                for ($k = 0; $k < $size_array; $k++) {

                    if ($k == 0 && ($size_array - 1) == $k) {
                        $search_where .= "AND (";
                        $search_where .= " artist_name Like '%" . $word_array[$k] . "%')";
                    } else
                        if ($k == 0) {
                        $search_where .= "AND (";
                        $search_where .= " artist_name Like '%" . $word_array[$k] . "%'";
                    } else
                        if (($size_array - 1) == $k) {
                        $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%')";
                    } else {
                        $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%' ";
                    }
                }

                //select b.album_seo, b.db_art_id, a.artist_seo,a.artist_name,b.album_title, b.album_picture, b.id, a.artist_seo from tbl_artist_album b, tbl_artists a where 1=1 AND b.album_status = 1  AND a.id = b.db_art_id AND b.ranking_order!=0 order by b.ranking_order asc
                for ($k = 0; $k < $size_array; $k++) {

                    if ($k == 0 && ($size_array - 1) == $k) {
                        $search_where_album .= "AND (";
                        $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%'))";
                    } else
                        if ($k == 0) {
                        $search_where_album .= "AND (";
                        $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%')";
                    } else
                        if (($size_array - 1) == $k) {
                        $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%'))";
                    } else {
                        $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%') ";
                    }
                }



                // $data['main_search'] = $search;
                // $data['main_result'] = $search_where;
                // $data['main_result_song'] = $search_where_song;
                // $data['main_result_album'] = $search_where_album; 

                session()->put('main_search', $search);
                session()->put('main_result', $search_where);
                session()->put('main_result_song', $search_where_song);
                session()->put('main_result_album', $search_where_album);

                $data['c'] = null;
                $data['sr_no'] = null;
            } else {
                
                redirect('/');
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
                $data['main_link'] = get_user_detail($data['user_name']) . "-profile-";
            } else {
                $data['user_name'] = session()->get('user_name');
                $data['user_profile'] = session()->get('user_id');
                $data['main_link'] = '';
            }

            ///load view
            $data['currentFile'] = 'search-songs';
            $data['title'] = GetTitle();
            return view('search_song', $data);
        }
    }


    ///GetSearchResultSongs
    public function GetSearchResultSongs($page = null)
    {

        $data = array(); 
        $search = session()->get('main_search');
        if ($search != "") {
            $search = trim($search);
            $word_array = explode(" ", $search);
            $search_where = '';
            $search_where_album = '';
            $search_where_song = '';
            $size_array  = sizeof($word_array);

            for ($k = 0; $k < $size_array; $k++) {

                if ($k == 0 && ($size_array - 1) == $k) {
                    $search_where .= "AND (";
                    $search_where .= " artist_name Like '%" . $word_array[$k] . "%')";
                } else
                        if ($k == 0) {
                    $search_where .= "AND (";
                    $search_where .= " artist_name Like '%" . $word_array[$k] . "%'";
                } else
                        if (($size_array - 1) == $k) {
                    $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%')";
                } else {
                    $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%' ";
                }
            }

            //select b.album_seo, b.db_art_id, a.artist_seo,a.artist_name,b.album_title, b.album_picture, b.id, a.artist_seo from tbl_artist_album b, tbl_artists a where 1=1 AND b.album_status = 1  AND a.id = b.db_art_id AND b.ranking_order!=0 order by b.ranking_order asc
            for ($k = 0; $k < $size_array; $k++) {

                if ($k == 0 && ($size_array - 1) == $k) {
                    $search_where_album .= "AND (";
                    $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%'))";
                } else
                        if ($k == 0) {
                    $search_where_album .= "AND (";
                    $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%')";
                } else
                        if (($size_array - 1) == $k) {
                    $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%'))";
                } else {
                    $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%') ";
                }
            }



            session()->put('main_search', $search);
            session()->put('main_result', $search_where);
            session()->put('main_result_song', $search_where_song);
            session()->put('main_result_album', $search_where_album);


            $data['c'] = null;
            $data['sr_no'] = null;
        } else {
            
            redirect('/');
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
            $data['main_link'] = get_user_detail($data['user_name']) . "-profile-";
        } else {
            $data['user_name'] = session()->get('user_name');
            $data['user_profile'] = session()->get('user_id');
            $data['main_link'] = '';
        }

        ///load view
        $data['currentFile'] = 'search-songs';
        $data['title'] = GetTitle();
        return view('search_song', $data);
    }

    ///GetSearchResultArtist
    public function GetSearchResultArtist($page = null)
    {

        $data = array(); 
        $search = session()->get('main_search');
        if ($search != "") {
            $search = trim($search);
            $word_array = explode(" ", $search);
            $search_where = '';
            $search_where_album = '';
            $search_where_song = '';
            $size_array  = sizeof($word_array);

            for ($k = 0; $k < $size_array; $k++) {

                if ($k == 0 && ($size_array - 1) == $k) {
                    $search_where .= "AND (";
                    $search_where .= " artist_name Like '%" . $word_array[$k] . "%')";
                } else
				if ($k == 0) {
                    $search_where .= "AND (";
                    $search_where .= " artist_name Like '%" . $word_array[$k] . "%'";
                } else
				if (($size_array - 1) == $k) {
                    $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%')";
                } else {
                    $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%' ";
                }
            }


            for ($k = 0; $k < $size_array; $k++) {

                if ($k == 0 && ($size_array - 1) == $k) {
                    $search_where_song .= "AND (";
                    $search_where_song .= " (song_title Like '%" . $word_array[$k] . "%'))";
                } else
				if ($k == 0) {
                    $search_where_song .= "AND (";
                    $search_where_song .= " (song_title Like '%" . $word_array[$k] . "%')";
                } else
				if (($size_array - 1) == $k) {
                    $search_where_song .= " OR (song_title Like '%" . $word_array[$k] . "%'))";
                } else {
                    $search_where_song .= " OR (song_title Like '%" . $word_array[$k] . "%') ";
                }
            }

            for ($k = 0; $k < $size_array; $k++) {

                if ($k == 0 && ($size_array - 1) == $k) {
                    $search_where_album .= "AND (";
                    $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%'))";
                } else
				if ($k == 0) {
                    $search_where_album .= "AND (";
                    $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%')";
                } else
				if (($size_array - 1) == $k) {
                    $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%'))";
                } else {
                    $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%') ";
                }
            }



            session()->put('main_search', $search);
            session()->put('main_result', $search_where);
            session()->put('main_result_song', $search_where_song);
            session()->put('main_result_album', $search_where_album);


            $data['c'] = null;
            $data['sr_no'] = null;
        } else {
            
            redirect('/');
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
            $data['main_link'] = get_user_detail($data['user_name']) . "-profile-";
        } else {
            $data['user_name'] = session()->get('user_name');
            $data['user_profile'] = session()->get('user_id');
            $data['main_link'] = '';
        }

        ///load view
        $data['currentFile'] = 'search-artists';
        $data['title'] = GetTitle();
        return view('search_artist', $data);
    }

    ///PostSearchResultArtist
    public function PostSearchResultArtist($page = null)
    {

        if (isset($_REQUEST['submitbtn']) && $_REQUEST['submitbtn'] != "") {
            extract($_POST);
            $data = array();
            
            $data['page'] = $page;

            if ($search != "" || session()->get('main_search') != '') {
                $search = trim($search);
                $word_array = explode(" ", $search);
                $search_where = '';
                $search_where_album = '';
                $search_where_song = '';
                $size_array  = sizeof($word_array);

                for ($k = 0; $k < $size_array; $k++) {

                    if ($k == 0 && ($size_array - 1) == $k) {
                        $search_where .= "AND (";
                        $search_where .= " artist_name Like '%" . $word_array[$k] . "%')";
                    } else
				if ($k == 0) {
                        $search_where .= "AND (";
                        $search_where .= " artist_name Like '%" . $word_array[$k] . "%'";
                    } else
				if (($size_array - 1) == $k) {
                        $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%')";
                    } else {
                        $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%' ";
                    }
                }


                for ($k = 0; $k < $size_array; $k++) {

                    if ($k == 0 && ($size_array - 1) == $k) {
                        $search_where_song .= "AND (";
                        $search_where_song .= " (song_title Like '%" . $word_array[$k] . "%'))";
                    } else
				if ($k == 0) {
                        $search_where_song .= "AND (";
                        $search_where_song .= " (song_title Like '%" . $word_array[$k] . "%')";
                    } else
				if (($size_array - 1) == $k) {
                        $search_where_song .= " OR (song_title Like '%" . $word_array[$k] . "%'))";
                    } else {
                        $search_where_song .= " OR (song_title Like '%" . $word_array[$k] . "%') ";
                    }
                }

                for ($k = 0; $k < $size_array; $k++) {

                    if ($k == 0 && ($size_array - 1) == $k) {
                        $search_where_album .= "AND (";
                        $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%'))";
                    } else
				if ($k == 0) {
                        $search_where_album .= "AND (";
                        $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%')";
                    } else
				if (($size_array - 1) == $k) {
                        $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%'))";
                    } else {
                        $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%') ";
                    }
                }


                // $data['main_search'] = $search;
                // $data['main_result'] = $search_where;
                // $data['main_result_song'] = $search_where_song;
                // $data['main_result_album'] = $search_where_album; 

                session()->put('main_search', $search);
                session()->put('main_result', $search_where);
                session()->put('main_result_song', $search_where_song);
                session()->put('main_result_album', $search_where_album);

                $data['c'] = null;
                $data['sr_no'] = null;
            } else {
                
                redirect('/');
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

            ///load view
            $data['currentFile'] = 'search-songs';
            $data['title'] = GetTitle();
            return view('search_artist', $data);
        }
    }

    ///GetSearchResultAlbum
    public function GetSearchResultAlbum($page = null)
    {

        $data = array();
        
        $data['page'] = $page;
        $search = session()->get('main_search');
        if ($search != "") {
            $search = trim($search);
            $word_array = explode(" ", $search);
            $search_where = '';
            $search_where_album = '';
            $search_where_song = '';
            $size_array  = sizeof($word_array);

            for ($k = 0; $k < $size_array; $k++) {

                if ($k == 0 && ($size_array - 1) == $k) {
                    $search_where .= "AND (";
                    $search_where .= " artist_name Like '%" . $word_array[$k] . "%')";
                } else
				if ($k == 0) {
                    $search_where .= "AND (";
                    $search_where .= " artist_name Like '%" . $word_array[$k] . "%'";
                } else
				if (($size_array - 1) == $k) {
                    $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%')";
                } else {
                    $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%' ";
                }
            }


            for ($k = 0; $k < $size_array; $k++) {

                if ($k == 0 && ($size_array - 1) == $k) {
                    $search_where_song .= "AND (";
                    $search_where_song .= " (song_title Like '%" . $word_array[$k] . "%'))";
                } else
				if ($k == 0) {
                    $search_where_song .= "AND (";
                    $search_where_song .= " (song_title Like '%" . $word_array[$k] . "%')";
                } else
				if (($size_array - 1) == $k) {
                    $search_where_song .= " OR (song_title Like '%" . $word_array[$k] . "%'))";
                } else {
                    $search_where_song .= " OR (song_title Like '%" . $word_array[$k] . "%') ";
                }
            }

            //select b.album_seo, b.album_artist_id, a.artist_seo,a.artist_name,b.album_title, b.album_picture, b.id, a.artist_seo from tbl_artist_album b, tbl_artists a where 1=1 AND b.album_status = 1  AND a.id = b.album_artist_id AND b.ranking_order!=0 order by b.ranking_order asc
            for ($k = 0; $k < $size_array; $k++) {

                if ($k == 0 && ($size_array - 1) == $k) {
                    $search_where_album .= "AND (";
                    $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%'))";
                } else
				if ($k == 0) {
                    $search_where_album .= "AND (";
                    $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%')";
                } else
				if (($size_array - 1) == $k) {
                    $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%'))";
                } else {
                    $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%') ";
                }
            }


            session()->put('main_search', $search);
            session()->put('main_result', $search_where);
            session()->put('main_result_song', $search_where_song);
            session()->put('main_result_album', $search_where_album);


            $data['c'] = null;
            $data['sr_no'] = null;
        } else {
            
            redirect('/');
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

        ///load view
        $data['currentFile'] = 'search-artists';
        $data['title'] = GetTitle();
        return view('search_albumlist', $data);
    }

    ///PostSearchResultAlbum
    public function PostSearchResultAlbum($page = null)
    {

        if (isset($_REQUEST['submitbtn']) && $_REQUEST['submitbtn'] != "") {
            extract($_POST);
            $data = array();
            
            $data['page'] = $page;

            if ($search != "" || session()->get('main_search') != '') {
                $search = trim($search);
                $word_array = explode(" ", $search);
                $search_where = '';
                $search_where_album = '';
                $search_where_song = '';
                $size_array  = sizeof($word_array);

                for ($k = 0; $k < $size_array; $k++) {

                    if ($k == 0 && ($size_array - 1) == $k) {
                        $search_where .= "AND (";
                        $search_where .= " artist_name Like '%" . $word_array[$k] . "%')";
                    } else
                    if ($k == 0) {
                        $search_where .= "AND (";
                        $search_where .= " artist_name Like '%" . $word_array[$k] . "%'";
                    } else
                    if (($size_array - 1) == $k) {
                        $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%')";
                    } else {
                        $search_where .= " OR artist_name Like '%" . $word_array[$k] . "%' ";
                    }
                }


                for ($k = 0; $k < $size_array; $k++) {

                    if ($k == 0 && ($size_array - 1) == $k) {
                        $search_where_song .= "AND (";
                        $search_where_song .= " (song_title Like '%" . $word_array[$k] . "%'))";
                    } else
                    if ($k == 0) {
                        $search_where_song .= "AND (";
                        $search_where_song .= " (song_title Like '%" . $word_array[$k] . "%')";
                    } else
                    if (($size_array - 1) == $k) {
                        $search_where_song .= " OR (song_title Like '%" . $word_array[$k] . "%'))";
                    } else {
                        $search_where_song .= " OR (song_title Like '%" . $word_array[$k] . "%') ";
                    }
                }

                //select b.album_seo, b.album_artist_id, a.artist_seo,a.artist_name,b.album_title, b.album_picture, b.id, a.artist_seo from tbl_artist_album b, tbl_artists a where 1=1 AND b.album_status = 1  AND a.id = b.album_artist_id AND b.ranking_order!=0 order by b.ranking_order asc
                for ($k = 0; $k < $size_array; $k++) {

                    if ($k == 0 && ($size_array - 1) == $k) {
                        $search_where_album .= "AND (";
                        $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%'))";
                    } else
                    if ($k == 0) {
                        $search_where_album .= "AND (";
                        $search_where_album .= " (album_title Like '%" . $word_array[$k] . "%')";
                    } else
                    if (($size_array - 1) == $k) {
                        $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%'))";
                    } else {
                        $search_where_album .= " OR (album_title Like '%" . $word_array[$k] . "%') ";
                    }
                }


                // $data['main_search'] = $search;
                // $data['main_result'] = $search_where;
                // $data['main_result_song'] = $search_where_song;
                // $data['main_result_album'] = $search_where_album; 

                session()->put('main_search', $search);
                session()->put('main_result', $search_where);
                session()->put('main_result_song', $search_where_song);
                session()->put('main_result_album', $search_where_album);

                $data['c'] = null;
                $data['sr_no'] = null;
            } else {
                
                redirect('/');
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

            ///load view
            $data['currentFile'] = 'search-songs';
            $data['title'] = GetTitle();
            return view('search_albumlist', $data);
        }
    }
}
