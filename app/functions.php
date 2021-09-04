<?php

///files use
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


///CheckDatabaseConnection
if (!function_exists('CheckDatabaseConnection')) {
    function CheckDatabaseConnection()
    {
        try {
            DB::connection();
            echo "Connected successfully to: " . DB::connection()->getDatabaseName();
        } catch (\Exception $e) {
            die("Could not connect to the database. Please check your configuration. error:" . $e);
        }
    }
}


///ads_info
if (!function_exists('ads_info')) {
    function ads_info($place)
    {

        $cache_result = array();
        if ($cache_result) {
            return $cache_result;
        } else {

            $ads_list = "SELECT ad_script as sss FROM tbl_advertisement where status =1 and ad_place = '$place' order by rand() limit 1";

            // $ads_list_arr    =    $db->get_row($ads_list, ARRAY_A);
            $ads_list_arr = \App\Models\Songs::GetRawData($ads_list);
            $ads_list_arr =  (array)$ads_list_arr[0];

            $ads_detail   =   stripslashes($ads_list_arr['sss']);
            return  $ads_detail;
        }

        return '';
    }
}


///CheckNumberFormate
if (!function_exists('CheckNumberFormate')) {
    function CheckNumberFormate($number)
    { 
        if ((int) $number == $number) {
            
            $number = $number . '.0';
        }
        else
        {
            $number = $number;
        } 
        return $number;
    }
}


///StringReplace
if (!function_exists('StringReplace')) {
    function StringReplace($string) {
        $string = str_replace(' ', '-', $string);  
        $string =  preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        $string =  str_replace('-', ' ', $string);
        return $string;
     }
}


///artist_album_song_func
if (!function_exists('artist_album_song_func')) {
    function artist_album_song_func($artistname, $song_title)
    {
        /****************** LASTFM CALL********/

        ini_set('allow_url_fopen ', 'ON');

        $artistname = urlencode($artistname);

        $track = urlencode($song_title);

        $temp = file_get_contents("http://ws.audioscrobbler.com/2.0/?method=track.getInfo&artist=" . $artistname . "&track=" . $track . "&api_key=979650ff4905a23bb01e312145761ebb");

        $XmlObj = simplexml_load_string($temp);

        $song_url_fm = $XmlObj->track->url;

        $song_summary_fm = $XmlObj->track->wiki->summary;

        $song_image_fm = $XmlObj->track->album->image[2];
        $song_image_fm3 = $XmlObj->track->album->image[3];



        $song_array['song_array']['image4'] = $song_image_fm;
        $song_array['song_array']['image5'] = $song_image_fm3;
        return $song_array;
    }
}


///contact-email
if (!function_exists('ContactEmail')) {
    ///sendEmail
    function ContactEmail($input, $request)
    {
        //  Send mail to admin
        Mail::send('contact-us', array(
            'name' => $input['name'],
            'email' => $input['email'],
            'subject' => 'Tailem.com',
            'message' => $input['message'],
        ), function ($message) use ($request) {
            $message->from($request->email);
            $message->to('itzadnanhussain@gmail.com', 'Admin')->subject($request->get('subject'));
        });
    }
}


///get_page_name
if (!function_exists('get_page_name')) {
    function get_page_name()
    {
        return Str::of(url()->current())->basename();
    }
}


///album_img_api
if (!function_exists('album_img_api')) {
    function album_img_api($val)
    {

        $result = substr($val, 0, 4);
        if ($result == 'http' || $result == 'https') {
            $val = str_replace("is1.mzstatic.com", "is4.mzstatic.com", $val);
            $val = str_replace("is2.mzstatic.com", "is4.mzstatic.com", $val);
            $val = str_replace("is3.mzstatic.com", "is4.mzstatic.com", $val);
            $val = str_replace("is5.mzstatic.com", "is4.mzstatic.com", $val);
            return $val;
        }
    }
}

///img_api_link
if (!function_exists('img_api_link')) {
    function img_api_link($val)
    {

        $result = substr($val, 0, 4);
        if ($result == 'http' || $result == 'https') {
            $val = str_replace("is1.mzstatic.com", "is4.mzstatic.com", $val);
            $val = str_replace("is2.mzstatic.com", "is4.mzstatic.com", $val);
            $val = str_replace("is3.mzstatic.com", "is4.mzstatic.com", $val);
            $val = str_replace("is5.mzstatic.com", "is4.mzstatic.com", $val);
            return $val;
        }
    }
}


///review_count_position
if (!function_exists('review_count_position')) {
    function review_count_position($reviewid, $song_id)
    {

        $query_position = "select r.review_id from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.song_id = $song_id order by r.review_id desc";
        // $data_arr    =    $db->get_results($query_position, ARRAY_A);
        $data_arr    =    \App\Models\Songs::GetRawData($query_position);
        $count_number  = count($data_arr);
        $s = 1;
        $u = 0;
        if ($count_number > 10) {
            foreach ($data_arr as $arr_list) {
                $u++;

                $id  =  $arr_list['review_id'];
                if ($reviewid == $id) {
                    $position =  $s;
                    break;
                }


                if ($u % 10 == 0) {
                    $s++;
                }
            }
        } else {
            $position =  1;
        }

        return $position;
    }
}


///get_user_detail 
if (!function_exists('get_user_detail')) {
    function get_user_detail($un)
    {

        $query    =    "select * from tbl_users where user_name = '$un'";
        $arr     =  \App\Models\Songs::GetRawData($query);
        if ($arr) {
            $arr = (array)$arr[0];
            $user_seo         = stripslashes($arr['user_seo']);
        } else {
            $user_seo = '';
        }
        return $user_seo;
    }
}


///addtoplaylist_icon 
if (!function_exists('addtoplaylist_icon')) {
    function addtoplaylist_icon()
    {
        $image_url  = SERVER_ROOTPATH . "images/playlist.png";
        return $image_url;
    }
}

///popular_review 
if (!function_exists('popular_review')) {
    function popular_review()
    {

        $reviews_list_arr = array();
        if (empty($reviews_list_arr)) {
            $reviews_list = "select b.album_seo, b.album_picture,a.artist_seo,a.artist_seo, a.artist_name,s.song_seo, s.song_title,s.updated_by_itunes,s.picture,r.* 
					 from tbl_reviews r,tbl_artists a,tbl_songs s,  tbl_artist_album b , tbl_songs_artist_album saa  
					 where 1=1 
					 AND r.song_id = s.id
					 AND r.artist_id = a.id
					 AND r.album_id = b.id
					 AND s.ranking_order != 0
					 AND s.id = saa.song_id 
					 AND s.song_status = 1 
					 AND saa.display_status = 1
					 group by saa.song_id
					 order by r.review_id desc					
					 limit 3
					 ";
            // $reviews_list_arr    =    $db->get_results($reviews_list, ARRAY_A);
            $reviews_list_arr = \App\Models\Songs::GetRawData($reviews_list);
        }
        return  $reviews_list_arr;
    }
}


///featured_screen 
if (!function_exists('featured_screen')) {
    function featured_screen($db_song_id, $artist_name, $artist_seo)
    {

        $artist_seo = strtolower($artist_seo);
        $qry_feature_arr = array();

        if (empty($qry_feature_arr)) {

            $qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '" . $db_song_id . "'";
            // $qry_feature_arr = $db->get_results($qry_top_feature_artist, ARRAY_A);
            $qry_feature_arr = \App\Models\Songs::GetRawData($qry_top_feature_artist);

            if ($qry_feature_arr) {
                $count  = count($qry_feature_arr);
            } else {
                $count = 0;
            }
        }



        $num = 1;

        $featured_screen = "<a class='featured_art' href='" . SERVER_ROOTPATH . $artist_seo . "-artist-songs'>" . $artist_name . "</a>";

        if ($qry_feature_arr) {
            $sum_len = 0;

            $string_art = strlen($artist_name);

            $maxString = 28;
            $minString = 15;
            if ($string_art > $maxString) {
                echo '...';
            } elseif ($string_art < $maxString) {

                $totval = ($maxString - $string_art) - 5;


                $featured_screen .= "<a class='featured_art'> ft. </a>";

                foreach ($qry_feature_arr as $val_feature) {

                    $val_feature = (array) $val_feature;
                    $val_feature['f_artist_seo'] = strtolower($val_feature['f_artist_seo']);

                    //	$num==$count means those loops have only one featured artists											 
                    if ($num == $count) {
                        $str_length = strlen($val_feature['feature_artist']);
                        $sum_len = $sum_len + $str_length;
                        if ($sum_len > $minString) {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval);
                            if (strlen($val_feature['feature_artist']) > $totval) {
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";
                            } else {
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";
                            }
                            break;
                        } else {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval);
                            if (strlen($val_feature['feature_artist']) > $totval) {
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";
                            }
                            break;
                        }
                    } else {   // for those loops having more than one featured artists
                        $str_length = strlen($val_feature['feature_artist']);
                        $sum_len = $sum_len + $str_length;
                        if ($sum_len > $minString) {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval);
                            if (strlen($val_feature['feature_artist']) > $totval) {

                                //echo $remaing_space = strlen($val_feature['feature_artist']) - $totval;
                                //echo $remaining_feature_art  = substr($val_feature['feature_artist'],0,$remaing_space);
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {

                                $remaing_space =  28 - $sum_len - 5;
                                $remaing_feature_art  = substr($val_feature['feature_artist'], 0, $remaing_space);
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $remaing_feature_art . "..</a>";
                            }
                            break;
                        } else {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval);
                            if (strlen($val_feature['feature_artist']) > $totval) {
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>, ";
                            } else {
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>, ";
                            }
                        }
                    }
                    $num++;
                }
            }
        }

        return  $featured_screen;
    }
}


///featured_ipad 
if (!function_exists('featured_ipad')) {
    function featured_ipad($db_song_id, $artist_name, $artist_seo)
    {

        $qry_feature_arr = array();
        $artist_seo = strtolower($artist_seo);

        if (empty($qry_feature_arr)) {

            $qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '" . $db_song_id . "'";
            // $qry_feature_arr = $db->get_results($qry_top_feature_artist, ARRAY_A);
            $qry_feature_arr = \App\Models\Songs::GetRawData($qry_top_feature_artist);
            if ($qry_feature_arr) {
                $count  = count($qry_feature_arr);
            } else {
                $count = 0;
            }
        }



        $num = 1;
        $featured_ipad = "<a class='featured_art' href='" . SERVER_ROOTPATH . $artist_seo . "-artist-songs'>" . $artist_name . "</a>";
        if ($qry_feature_arr) {
            $sum_len = 0;

            $string_art = strlen($artist_name);

            if ($string_art > 18) {
                echo '...';
            } elseif ($string_art < 18) {

                $totval_pad = (18 - $string_art) - 5;


                $featured_ipad .= "<a class='featured_art'> ft. </a>";

                foreach ($qry_feature_arr as $val_feature) {
                    $val_feature = (array)$val_feature;


                    $val_feature['f_artist_seo'] = strtolower($val_feature['f_artist_seo']);
                    if ($num == $count) {
                        $str_length = strlen($val_feature['feature_artist']);
                        $sum_len = $sum_len + $str_length;
                        if ($sum_len > 15) {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval_pad);
                            if (strlen($val_feature['feature_artist']) > $totval_pad) {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";
                            }
                            break;
                        } else {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval_pad);
                            if (strlen($val_feature['feature_artist']) > $totval_pad) {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";
                            }
                        }
                    } else {
                        $str_length = strlen($val_feature['feature_artist']);
                        $sum_len = $sum_len + $str_length;
                        if ($sum_len > 15) {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval_pad);
                            if (strlen($val_feature['feature_artist']) > $totval_pad) {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";
                            }
                            break;
                        } else {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval_pad);
                            if (strlen($val_feature['feature_artist']) > $totval_pad) {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>,";
                            } else {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>,";
                            }
                        }
                    }
                    $num++;
                }
            }
        }

        return  $featured_ipad;
    }
}



///featured_mobile 
if (!function_exists('featured_mobile')) {

    function featured_mobile($db_song_id, $artist_name, $artist_seo)
    {
        $artist_seo = strtolower($artist_seo);
        $qry_feature_arr = array();
        $featured_mobile = '';

        if (empty($qry_feature_arr)) {

            $qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '" . $db_song_id . "'";
            $qry_feature_arr = \App\Models\Songs::GetRawData($qry_top_feature_artist);
            if ($qry_feature_arr) {
                $count  = count($qry_feature_arr);
            } else {
                $count = 0;
            }
        }


        $num = 1;
        $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $artist_seo . "-artist-songs'>" . $artist_name . "</a>";
        if ($qry_feature_arr) {
            $sum_len = 0;

            $string_art = strlen($artist_name);

            if ($string_art > 18) {
                echo '...';
            } elseif ($string_art < 18) {

                $totval = (18 - $string_art) - 5;


                $featured_mobile .= "<a class='featured_art'> ft. </a>";

                foreach ($qry_feature_arr as $val_feature) {
                    $val_feature = (array)$val_feature;



                    $val_feature['f_artist_seo'] = strtolower($val_feature['f_artist_seo']);
                    if ($num == $count) {
                        $str_length = strlen($val_feature['feature_artist']);
                        $sum_len = $sum_len + $str_length;
                        if ($sum_len > 15) {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval);
                            if (strlen($val_feature['feature_artist']) > $totval) {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";
                            }
                            break;
                        } else {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval);
                            if (strlen($val_feature['feature_artist']) > $totval) {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";
                            }
                        }
                    } else {
                        $str_length = strlen($val_feature['feature_artist']);
                        $sum_len = $sum_len + $str_length;
                        if ($sum_len > 15) {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval);
                            if (strlen($val_feature['feature_artist']) > $totval) {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";
                            }
                            break;
                        } else {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval);
                            if (strlen($val_feature['feature_artist']) > $totval) {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>,";
                            } else {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>,";
                            }
                        }
                    }
                    $num++;
                }
            }
        }

        return  $featured_mobile;
    }
}



///feature_songs 
if (!function_exists('feature_songs')) {

    function feature_songs($db_song_id)
    {

        $qry_feature_arr = array();

        if (empty($qry_feature_arr)) {

            $qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '" . $db_song_id . "'";
            $qry_feature_arr = \App\Models\Songs::GetRawData($qry_top_feature_artist);
            if ($qry_feature_arr) {
                $count  = count($qry_feature_arr);
            } else {
                $count = 0;
            }
        }

        $num = 1;
        $feature_artists = "";
        if ($qry_feature_arr) {
            $sum_len = 0;
            $feature_artists .= "<a class='featured_art'> ft. </a>";

            foreach ($qry_feature_arr as $val_feature) {
                $val_feature = (array)$val_feature;

                $val_feature['f_artist_seo'] = strtolower($val_feature['f_artist_seo']);
                if ($num == $count) {
                    $str_length = strlen($val_feature['feature_artist']);
                    $sum_len = $sum_len + $str_length;
                    if ($sum_len > 15) {
                        $feature_art  = substr($val_feature['feature_artist'], 0, 10);
                        if (strlen($val_feature['feature_artist']) > 10) {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>";
                        } else {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";
                        }
                        break;
                    } else {
                        $feature_art  = substr($val_feature['feature_artist'], 0, 10);
                        if (strlen($val_feature['feature_artist']) > 10) {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>";
                        } else {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";
                        }
                    }
                } else {
                    $str_length = strlen($val_feature['feature_artist']);
                    $sum_len = $sum_len + $str_length;
                    if ($sum_len > 15) {
                        $feature_art  = substr($val_feature['feature_artist'], 0, 10);
                        if (strlen($val_feature['feature_artist']) > 10) {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>";
                        } else {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";
                        }
                        break;
                    } else {
                        $feature_art  = substr($val_feature['feature_artist'], 0, 10);
                        if (strlen($val_feature['feature_artist']) > 10) {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . '..' . "</a>,";
                        } else {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>,";
                        }
                    }
                }
                $num++;
            }
        }

        return  $feature_artists;
    }
}


///artist_album_func 
if (!function_exists('artist_album_func')) {

    function artist_album_func($artistname, $albumname)
    {


        ini_set('allow_url_fopen ', 'ON');

        $artistname = urlencode($artistname);

        $albumname = urlencode($albumname);


        $temp = file_get_contents("http://ws.audioscrobbler.com/2.0/?method=album.getinfo&album=" . $albumname . "&artist=" . $artistname . "&api_key=979650ff4905a23bb01e312145761ebb");
        $XmlObj = simplexml_load_string($temp);

        $img3 = $XmlObj->album->image[2];

        $album_array['album_array']['image4'] = $img3;
        return $album_array;
    }
}


///calculate_rating_main 
if (!function_exists('calculate_rating_main')) {

    function calculate_rating_main($album_id, $artist_id, $albseo)
    {




        $listof_ids  =    get_listof_songs_ids_main($album_id, $artist_id);
        
        
        if ($listof_ids == '') {
            $pass_where = '';
        } else {
            $pass_where = " OR (rev.song_id IN ($listof_ids))";
        }

        $where_condition = " AND (rev.album_id = '$album_id' $pass_where)"; 

        $sum_rating_query    = "select avg(rev.review_rating) as total_sum, Count(*) as number_count
							from tbl_artist_album b, tbl_artists a, tbl_songs s, tbl_reviews rev, tbl_users u 
							where 1=1 
							AND s.id = rev.song_id 
							AND a.id = rev.artist_id 
							AND b.id = rev.album_id 
							AND u.user_id = rev.review_user_id 
                            AND (rev.album_id = '932694528' OR (rev.song_id IN (12345))) 
 							group by song_id
							  LIMIT 50";


        // $rate_list_arr    =    $db->get_results($sum_rating_query, ARRAY_A);
        $rate_list_arr = \App\Models\Songs::GetRawData($sum_rating_query);
        echo '<pre>';
        print_r($rate_list_arr);
        echo '</pre>';
        die;
        $sum = 0;
        
        if ($rate_list_arr) {
            $total_count    =    count($rate_list_arr);
            foreach ($rate_list_arr as $get_avg) {
                $get_avg = (array)$get_avg;
                $sum_rates  = $get_avg['total_sum'];
                $sum    =    $sum + $sum_rates;
            }
        }
        else
        {
            $total_count = 0;
        }

        /*
	 $total_sum_rating	=	 $rate_list_arr['total_sum'];
		 
		 $number_count		=	$rate_list_arr['number_count'];			
		 */
        $total_Rating    =    $sum / $total_count;

        return $total_Rating;
    }
}


///get_listof_songs_ids_main 
if (!function_exists('get_listof_songs_ids_main')) {

    function get_listof_songs_ids_main($album_id, $artid)
    {

        $artist_list_arr = "select b.album_title, b.album_seo, saa.song_id, saa.artist_id from tbl_songs_artist_album saa, tbl_artist_album b where saa.album_id = b.id AND saa.artist_id = '$artid' AND saa.album_id = '$album_id' AND saa.display_status = 1 ";


        // $artist_list_arr	=	$db->get_results($artist_list,ARRAY_A);
        $artist_list_arr = \App\Models\Songs::GetRawData($artist_list_arr);
        if ($artist_list_arr) {
            $total_result = 0;
        } else {

            $total_result    =    count($artist_list_arr);
        }
        $u = 1;
        $list  = '';
        if ($artist_list_arr) {  
            foreach ($artist_list_arr as $arr) {
                $arr = (array)$arr;
                if ($u == $total_result) {
                    $list .=  $arr['song_id'];
                } else {
                    $list .=  $arr['song_id'] . ", ";
                }
                $u++;
            }
        }


        return $list;
    }
}
