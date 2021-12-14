<?php

use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//****************************Queries*********************************** */
///Get All Records
if (!function_exists('GetAllRecords')) {
    function GetAllRecords($table = null)
    {
        $records = DB::table($table)->get();
        return $records->toArray();
    }
}


///Get Single Record
if (!function_exists('GetSingleRecord')) {
    function GetSingleRecord($table = null, $where = array())
    {
        $records = DB::table($table)->where($where)->first();
        return $records->toArray();
    }
}


///GetByWhere
if (!function_exists('GetByWhere')) {
    function GetByWhere($table = null, $where = array())
    {
        $records = DB::table($table)->where($where)->get();
        return $records->toArray();
    }
}

///LastQuery
if (!function_exists('GetLastQuery')) {
    function GetLastQuery()
    {
        $query = DB::getQueryLog();
        dd($query);
    }
}

if (!function_exists('addNew')) {
    function addNew($table, $data)
    {
        $id = DB::table($table)->insertGetId(
            $data
        );

        return $id;
    }
}


///UpdateRecord
if (!function_exists('UpdateRecord')) {
    function UpdateRecord($table = null, $where = array(), $data = array())
    {
        $affected = DB::table($table)
            ->where($where)
            ->update($data);
        return $affected;
    }
}

///EnableQueryLog
if (!function_exists('EnableQueryLog')) {
    function EnableQueryLog()
    {
        ///Query Logs
        DB::enableQueryLog();
    }
}



///top_file_data
if (!function_exists('top_file_data')) {
    function top_file_data($data = array())
    {
        if ((session()->get('reviewsite_cpadmin_type')) == 'user') {
            $qry = "SELECT * from tbl_moderator_rights WHERE moderator_id='" . session()->get('reviewsite_cpadmin_id') . "'";
            $tops_arrs    =    \App\Models\Songs::GetRawData($qry);
            // echo '<pre>';
            // print_r($tops_arrs);
            // echo '</pre>';
            // die;
            $tops_arrs = (array)$tops_arrs[0];
            $data['top_slider_module']                = $tops_arrs['slider_module'];
            $data['top_users_module']                   = $tops_arrs['users_module'];
            $data['top_faq_module']                 = $tops_arrs['faq_module'];
            $data['top_categories_module']             = $tops_arrs['categories_module'];
            $data['top_advertisement_module']          = $tops_arrs['advertisement_module'];
            $data['top_social_link_module']           = $tops_arrs['social_link_module'];
            $data['top_content_module']              = $tops_arrs['content_module'];
            $data['top_email_template_module']      = $tops_arrs['email_template_module'];
            $data['top_country_module']             = $tops_arrs['country_module'];
            $data['top_reviews_module']               = $tops_arrs['reviews_module'];

            $data['top_artist_module']                = $tops_arrs['artist_module'];
            $data['top_artist_module_add']          = $tops_arrs['artist_module_add'];
            $data['top_artist_module_delete']         = $tops_arrs['artist_module_delete'];

            $data['top_album_module']                = $tops_arrs['album_module'];
            $data['top_album_module_add']          = $tops_arrs['album_module_add'];
            $data['top_album_module_delete']         = $tops_arrs['album_module_delete'];

            $data['top_song_module']                = $tops_arrs['song_module'];
            $data['top_song_module_add']          = $tops_arrs['song_module_add'];
            $data['top_song_module_delete']         = $tops_arrs['song_module_delete'];

            $data['top_slider_module_add']          = $tops_arrs['slider_module_add'];
            $data['top_slider_module_delete']         = $tops_arrs['slider_module_delete'];

            $data['top_users_module_add']            = $tops_arrs['users_module_add'];
            $data['top_users_module_delete']         = $tops_arrs['users_module_delete'];

            $data['top_faq_module_add']              = $tops_arrs['faq_module_add'];
            $data['top_faq_module_delete']           = $tops_arrs['faq_module_delete'];

            $data['top_categories_module_add']        = $tops_arrs['categories_module_add'];
            $data['top_categories_module_delete']    = $tops_arrs['categories_module_delete'];

            $data['top_content_module_edit']        = $tops_arrs['content_module_edit'];
            $data['top_email_template_module_edit']    = $tops_arrs['email_template_module_edit'];

            $data['top_country_module_add']            = $tops_arrs['country_module_add'];
            $data['top_country_module_delete']        = $tops_arrs['country_module_delete'];

            $data['top_reviews_module_add']            = $tops_arrs['reviews_module_add'];
            $data['top_reviews_module_delete']         = $tops_arrs['reviews_module_delete'];

            $data['top_advertisement_module_add']   = $tops_arrs['advertisement_module_add'];
            $data['top_advertisement_module_delete'] = $tops_arrs['advertisement_module_delete'];


            $data['top_video_module']         = $tops_arrs['video_module'];
            $data['top_video_module_add']   = $tops_arrs['video_module_add'];
            $data['top_video_module_delete'] = $tops_arrs['video_module_delete'];
        } else {
            $data['top_slider_module']                = 'Yes';
            $data['top_users_module']                   = 'Yes';
            $data['top_faq_module']                  = 'Yes';
            $data['top_categories_module']             = 'Yes';
            $data['top_advertisement_module']          = 'Yes';
            $data['top_social_link_module']           = 'Yes';
            $data['top_content_module']              = 'Yes';
            $data['top_email_template_module']      = 'Yes';
            $data['top_country_module']             = 'Yes';
            $data['top_reviews_module']               = 'Yes';

            $data['top_slider_module_add']          = 'Yes';
            $data['top_slider_module_delete']         = 'Yes';
            $data['top_users_module_add']            = 'Yes';
            $data['top_users_module_delete']         = 'Yes';
            $data['top_faq_module_add']              = 'Yes';
            $data['top_faq_module_delete']           = 'Yes';
            $data['top_categories_module_add']        = 'Yes';
            $data['top_categories_module_delete']    = 'Yes';
            $data['top_content_module_edit']        = 'Yes';
            $data['top_email_template_module_edit']    = 'Yes';
            $data['top_country_module_add']            = 'Yes';
            $data['top_country_module_delete']        = 'Yes';
            $data['top_reviews_module_add']            = 'Yes';
            $data['top_reviews_module_delete']         = 'Yes';
            $data['top_advertisement_module_add']   = 'Yes';
            $data['top_advertisement_module_delete'] = 'Yes';

            $data['top_video_module']         = 'Yes';
            $data['top_video_module_add']   = 'Yes';
            $data['top_video_module_delete'] = 'Yes';

            $data['top_artist_module']                = "Yes";
            $data['top_artist_module_add']          = "Yes";
            $data['top_artist_module_delete']         = "Yes";

            $data['top_album_module']                = "Yes";
            $data['top_album_module_add']              = "Yes";
            $data['top_album_module_delete']         = "Yes";

            $data['top_song_module']                = "Yes";
            $data['top_song_module_add']              = "Yes";
            $data['top_song_module_delete']         = "Yes";
        }
        return $data;
    }
}

///curPageURL
if (!function_exists('curPageURL')) {
    function curPageURL()
    {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }

        $pos = strpos($pageURL, 'www');
        $pos1 = strpos($pageURL, 'https');

        if ($pos1 == true) {
            $pageURL = 'http';
            $pageURL .= "://www.";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            } else {
                $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            }
        } elseif ($pos == false) {
            $pageURL = 'http';
            $pageURL .= "://www.";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            } else {
                $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            }
        }

        return $pageURL;
    }
}
