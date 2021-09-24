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


///playlist_for_user
if (!function_exists('playlist_for_user')) {
    function playlist_for_user($user_id)
    {

        $main_play_list = "select * from tbl_user_playlist where user_id_playlist = '" . $user_id . "' order by id asc";
        // $playlist_arr	=	$db->get_results($main_play_list,ARRAY_A);
        $playlist_arr = \App\Models\Songs::GetRawData($main_play_list);
        return $playlist_arr;
    }
}


///CheckNumberFormate
if (!function_exists('CheckNumberFormate')) {
    function CheckNumberFormate($number)
    {
        if ((int) $number == $number) {

            $number = $number . '.0';
        } else {
            $number = $number;
        }
        return $number;
    }
}


///StringReplace
if (!function_exists('StringReplace')) {
    function StringReplace($string)
    {
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
            if (empty($user_seo)) {
                $user_seo = Slug($arr['user_name']);
            }
        } else {
            $user_seo = '';
        }
        return $user_seo;
    }
}


///Slug 
if (!function_exists('Slug')) {
    function Slug($string)
    {
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
    }
}


///song_info 
if (!function_exists('song_info')) {
    function song_info($songid)
    {

        $query_list        =    "select  song_title, song_seo from tbl_songs where id = '$songid'";
        $artist_list_arr = \App\Models\Songs::GetRawData($query_list);
        $artist_list_arr = (array)$artist_list_arr[0];

        return $artist_list_arr;
    }
}


///artist_info 
if (!function_exists('artist_info')) {
    function artist_info($artistid)
    {
        global $db;
        $query_list        =    "select  artist_seo from tbl_artists where id = '$artistid'";
        $artist_list_arr = \App\Models\Songs::GetRawData($query_list);
        $artist_list_arr = (array)$artist_list_arr[0];
        return $artist_list_arr;
    }
}


///sortArray 
if (!function_exists('sortArray')) {
    function sortArray($data = array(), $field)
    {
        error_reporting(0);
        $field = (array) $field;
        if ($data) {
            uasort($data, function ($a, $b) use ($field) {
                $retval = 0;
                foreach ($field as $fieldname) {
                    if ($retval == 0) $retval = strnatcmp($a[$fieldname], $b[$fieldname]);
                }
                return $retval;
            });
        }


        return $data;
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


///remove_spl_char 
if (!function_exists('remove_spl_char')) {
    function remove_spl_char($string)
    {

        $string = str_replace("'", '&#39;', $string); // Replaces all spaces with hyphens.
        $string = str_replace('"', '&#34;', $string);
        return utf8_encode($string);
    }
}

///get_first_playlist_record 
if (!function_exists('get_first_playlist_record')) {
    function get_first_playlist_record($user_id)
    {

        $main_play_list = "select title_playlist_seo  from tbl_user_playlist where user_id_playlist = '" . $user_id . "'";
        $playlist_arr = \App\Models\Songs::GetRawData($main_play_list);

        return $playlist_arr;
    }
}
 

///check user data
if (!function_exists('checkUser_profile')) {
    function checkUser($userData = array())
    {

        if (!empty($userData)) {


            $get_email  = $userData['email'];
            $generate_username  = $userData['first_name'];
            $lname  = $userData['last_name'];
            if ($lname != '') {
                $generate_username  .= " " . $lname;;
            }

            $useremail  = $get_email;


            //Check whether user data already exists in database
            $prevQuery = "SELECT * FROM  tbl_users WHERE  user_email='" . $userData['email'] . "'";
            $prevResult = $this->db->query($prevQuery);

            $results = $prevResult->fetch_assoc();
            if (!empty($userData['picture'])) {
                $ch = curl_init($userData['picture']);
                $google_img = $userData['first_name'] . "_" . time() . ".png";
                $fp = fopen('site_upload/user_images/' . $google_img, 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);
                $userData['picture'] = $google_img;
                if ($results['profile_image'] != "") {

                    unlink('/site_upload/user_images/' . $results['profile_image']);
                }
            }

            if ($prevResult->num_rows > 0) {
                //Update user data if already exists

                $query = "SELECT user_email,user_name, user_id, status, activation_code, date_added FROM tbl_users where user_email='" . $useremail . "' ";
                $result_facebook = $this->db->query($query);
                $results_Fb = $result_facebook->fetch_assoc();






                $update = $this->db->query($query);

                $generate_username   =  stripslashes($results_Fb['user_name']);
            } else {
                $rand  = rand(1, 999);
                $user_name  = strtolower($userData['first_name']) . $rand;

                $check_user  =  "select user_name from tbl_users where user_name = '$generate_username' and user_name!=''";
                $Result_query = $this->db->query($check_user);
                $count  = $Result_query->num_rows;
                if ($count == 0) {
                    $generate_username  = ($generate_username);
                } else {
                    $rand  = rand(444, 9999);
                    $generate_username  = ($generate_username) . $rand;
                }



                $simple_password  = rand(111111, 99999999);
                $encrypt  = md5($simple_password);

                $seo_username  = str_replace(" ", "_", $generate_username);

                //Insert user data
                $query = "INSERT INTO " . $this->userTbl . " SET user_name = '" . $generate_username . "', user_seo = '" . addslashes($seo_username) . "', 	simple_password  = '" . $simple_password . "',encrypted_password = '" . $encrypt . "', oauth_provider = '" . $userData['oauth_provider'] . "', google_oauth_uid = '" . $userData['oauth_uid'] . "', fname = '" . $userData['first_name'] . "', lname = '" . $userData['last_name'] . "', user_email = '" . $userData['email'] . "', gender = '" . $userData['gender'] . "', profile_image = '" . $userData['picture'] . "', link = '" . $userData['link'] . "', status = '1',created_on = '" . date("Y-m-d H:i:s") . "',date_added = '" . time() . "',modified_on = '" . date("Y-m-d H:i:s") . "'";
                $insert = $this->db->query($query);


                $query = "SELECT user_email,user_name, user_id, status, activation_code, date_added FROM tbl_users where user_email='" . $useremail . "' ";
                $result_facebook = $this->db->query($query);
                $results_Fb = $result_facebook->fetch_assoc();


                if (isset($results_Fb)) {

                    $query = "UPDATE " . $this->userTbl . " SET user_name = '" . $generate_username . "', user_seo = '" . addslashes($seo_username) . "' WHERE user_email = '" . $get_email . "'";
                } else {
                    $generate_username  = $generate_username . rand(100, 999);
                    $seo_username  = str_replace(" ", "_", $generate_username);
                    $query = "UPDATE " . $this->userTbl . " SET user_name = '" . $generate_username . "', user_seo = '" . addslashes($seo_username) . "' WHERE user_email = '" . $get_email . "'";
                }



                $update = $this->db->query($query);

                /*echo $insert_qry_names = "INSERT INTO tbl_social_username SET  fullname = '".addslashes(userData['first_name'])." ".addslashes($userData['last_name'])."',network = 'gmail',user_id= '".$insert."'";
				exit;*/
                //$this->db->query($insert_qry_names);


            }

            //Get user data from the database
            $prevQuery = "SELECT * FROM " . $this->userTbl . " WHERE  user_email='" . $userData['email'] . "'";
            $result = $this->db->query($prevQuery);
            $userData = $result->fetch_assoc();
        }

        //Return user data
        return $userData;
    }
}

///popular_review_artist 
if (!function_exists('popular_review_artist')) {
    function popular_review_artist()
    {

        $reviews_list_arr = array();


        $reviews_list = "select b.album_seo,s.picture,s.updated_by_itunes,b.album_picture,a.artist_seo,a.artist_seo, a.artist_name,s.song_seo, s.song_title,r.* 
					 from tbl_reviews r,tbl_artists a,tbl_songs s,  tbl_artist_album b  
					 where 1=1 
					 AND r.song_id = s.id
					 AND r.artist_id = a.id
					 AND r.album_id = b.id
					 AND a.id = r.artist_id 
					 AND s.song_status = 1 
					 order by r.review_id desc
					 limit 3
					 ";
        $reviews_list_arr = \App\Models\Songs::GetRawData($reviews_list);
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

        $featured_screen = "<a class='featured_art' href='" . SERVER_ROOTPATH .  $artist_seo . "/artist-songs'>" . $artist_name . "</a>";

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
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>";
                            } else {
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>";
                            }
                            break;
                        } else {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval);
                            if (strlen($val_feature['feature_artist']) > $totval) {
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>";
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
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {

                                $remaing_space =  28 - $sum_len - 5;
                                $remaing_feature_art  = substr($val_feature['feature_artist'], 0, $remaing_space);
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $remaing_feature_art . "..</a>";
                            }
                            break;
                        } else {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval);
                            if (strlen($val_feature['feature_artist']) > $totval) {
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>, ";
                            } else {
                                $featured_screen .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>, ";
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

///table_last_updated 
if (!function_exists('table_last_updated')) {
    function table_last_updated($table)
    {
        $last_updated = "SELECT (now()-UPDATE_TIME) as last_updated from information_schema.tables WHERE TABLE_SCHEMA = 'exceed13_music_site' AND TABLE_NAME = '$table'";
        $updated_on = \App\Models\Songs::GetRawData($last_updated);
        if ($updated_on) {
            $updated_on = (array)$updated_on[0];
            $mins = ($updated_on['last_updated'] / 60);
            if ($mins < 2) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}


///GetArtistBySongId 
if (!function_exists('GetArtistBySongId')) {
    function GetArtistBySongId($song_id)
    {
        $data = array();
        $qry = "select artist_id FROM tbl_songs_artist_album where song_id = '$song_id'";
        $data1 = \App\Models\Songs::GetRawData($qry);
        if ($data1) {
            $artist_id = $data1[0]->artist_id;
            $qry = "select * FROM tbl_artists where id = '$artist_id'";
            $data = \App\Models\Songs::GetRawData($qry);
            $data = (array)$data[0];
        }
        return $data;
    }
}

///GetArtistByAlbumId 
if (!function_exists('GetArtistByAlbumId')) {
    function GetArtistByAlbumId($album_id)
    {
        $data = array();
        $qry = "select artist_id FROM tbl_songs_artist_album where album_id = '$album_id'";
        $data1 = \App\Models\Songs::GetRawData($qry);
        if ($data1) {
            $artist_id = $data1[0]->artist_id;
            $qry = "select * FROM tbl_artists where id = '$artist_id'";
            $data = \App\Models\Songs::GetRawData($qry);
            $data = (array)$data[0];
        }
        return $data;
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
        $featured_ipad = "<a class='featured_art' href='" . SERVER_ROOTPATH .  $artist_seo . "/artist-songs'>" . $artist_name . "</a>";
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
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>";
                            }
                            break;
                        } else {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval_pad);
                            if (strlen($val_feature['feature_artist']) > $totval_pad) {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>";
                            }
                        }
                    } else {
                        $str_length = strlen($val_feature['feature_artist']);
                        $sum_len = $sum_len + $str_length;
                        if ($sum_len > 15) {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval_pad);
                            if (strlen($val_feature['feature_artist']) > $totval_pad) {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>";
                            }
                            break;
                        } else {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval_pad);
                            if (strlen($val_feature['feature_artist']) > $totval_pad) {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>,";
                            } else {
                                $featured_ipad .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>,";
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
        $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH .  $artist_seo . "/artist-songs'>" . $artist_name . "</a>";
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
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>";
                            }
                            break;
                        } else {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval);
                            if (strlen($val_feature['feature_artist']) > $totval) {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>";
                            }
                        }
                    } else {
                        $str_length = strlen($val_feature['feature_artist']);
                        $sum_len = $sum_len + $str_length;
                        if ($sum_len > 15) {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval);
                            if (strlen($val_feature['feature_artist']) > $totval) {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>";
                            } else {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>";
                            }
                            break;
                        } else {
                            $feature_art  = substr($val_feature['feature_artist'], 0, $totval);
                            if (strlen($val_feature['feature_artist']) > $totval) {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>,";
                            } else {
                                $featured_mobile .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>,";
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
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>";
                        } else {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>";
                        }
                        break;
                    } else {
                        $feature_art  = substr($val_feature['feature_artist'], 0, 10);
                        if (strlen($val_feature['feature_artist']) > 10) {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>";
                        } else {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>";
                        }
                    }
                } else {
                    $str_length = strlen($val_feature['feature_artist']);
                    $sum_len = $sum_len + $str_length;
                    if ($sum_len > 15) {
                        $feature_art  = substr($val_feature['feature_artist'], 0, 10);
                        if (strlen($val_feature['feature_artist']) > 10) {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>";
                        } else {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>";
                        }
                        break;
                    } else {
                        $feature_art  = substr($val_feature['feature_artist'], 0, 10);
                        if (strlen($val_feature['feature_artist']) > 10) {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . '..' . "</a>,";
                        } else {
                            $feature_artists .= "<a class='featured_art' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "/artist-songs'>" . $feature_art . "</a>,";
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
        $sum_rating_query    = "select avg(rev.review_rating) as total_sum, Count(*) as number_count
							from tbl_artist_album b, tbl_artists a, tbl_songs s, tbl_reviews rev, tbl_users u 
							where 1=1 
							AND s.id = rev.song_id 
							AND a.id = rev.artist_id 
							AND b.id = rev.album_id 
							AND u.user_id = rev.review_user_id 
                            AND (rev.album_id = '$album_id' OR (rev.song_id IN ('$listof_ids'))) 
 							group by song_id
							  LIMIT 50";

        $rate_list_arr = \App\Models\Songs::GetRawData($sum_rating_query);
        $sum = 0;
        if ($rate_list_arr) {
            $total_count    =    count($rate_list_arr);
            foreach ($rate_list_arr as $get_avg) {
                $get_avg = (array)$get_avg;
                $sum_rates  = $get_avg['total_sum'];
                $sum    =    $sum + $sum_rates;
            }
            $total_Rating    =    $sum / $total_count;
        } else {
            $total_count = 0;
            $total_Rating    =   0;
        }

        return $total_Rating;
    }
}

///GetTitle
if (!function_exists('GetTitle')) {
    function GetTitle()
    {
        $url = Str::of(url()->current())->after(SERVER_ROOTPATH);
        $find = array("/", "-");
        $replace = array(" ", " ");
        return ucwords(str_replace($find, $replace, $url));
    }
}


///check_report_discussion
if (!function_exists('check_report_discussion')) {
    function check_report_discussion($review_id)
    {
        global $db;
        $report_query = "select r_report_id  from tbl_review_report where r_report_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND r_report_review_id = '$review_id' AND status = 1";

        $chk_report_arr = \App\Models\Songs::GetRawData($report_query);
        return $chk_report_arr;
    }
}


///get_playlist_info
if (!function_exists('get_playlist_info')) {
    function get_playlist_info($user_id, $id)
    {
        $main_play_list = "select *  from tbl_user_playlist where user_id_playlist = '" . $user_id . "' AND title_playlist_seo = '$id'";
        $playlist_arr    =    \App\Models\Songs::GetRawData($main_play_list);;
        return $playlist_arr;
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


///popular_album 
if (!function_exists('popular_album')) {
    function popular_album()
    {
        $reviews_list_arr = array();
        $reviews_list = "select b.album_seo,s.picture, b.album_picture,a.artist_seo,a.artist_seo, a.artist_name,s.song_seo, s.song_title, s.updated_by_itunes,r.* 
					 from tbl_reviews r,tbl_artists a,tbl_songs s,  tbl_artist_album b , tbl_songs_artist_album saa  
					 where 1=1 
					 AND r.song_id = s.id
					 AND r.artist_id = a.id
					 AND r.album_id = b.id
					 AND b.ranking_order != 0
					 AND b.id = saa.album_id
					 AND saa.display_status = 1 
					 AND s.song_status = 1
					 group by r.review_id
					 order by r.review_id desc
					  limit 3
					 ";
        // $reviews_list_arr    =    $db->get_results($reviews_list, ARRAY_A);
        $reviews_list_arr = \App\Models\Songs::GetRawData($reviews_list);
        return  $reviews_list_arr;
    }
}
///artist_func 
if (!function_exists('artist_func')) {
    function artist_func($artistname)
    {
        ini_set('allow_url_fopen ', 'ON');
        $temp = file_get_contents("http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=" . trim($artistname) . "&api_key=979650ff4905a23bb01e312145761ebb");
        $XmlObj = simplexml_load_string($temp);
        $info = $XmlObj->artist->bio->summary;
        $image4 = $XmlObj->artist->image[3];
        $name = $XmlObj->artist->name;
        $url = $XmlObj->artist->url;


        $val = '<a href="http://www.last.fm/music/Justin+Bieber">Read more about Justin Bieber on Last.fm</a>';
        $val = $info;
        $val =  str_replace($url, "#", $val);
        $val =  str_replace("Read more about " . $name . " on Last.fm", "", $val);
        $val1 = '<a href="#"></a>.';
        $info1 =  str_replace($val1, "", $val);
        $val2 = '<a href="#"></a>';
        $info =   strip_tags(str_replace($val2, "", $info1));

        $artist_array['artist_array']['name'] = $name;
        $artist_array['artist_array']['image4'] = $image4;
        $artist_array['artist_array']['url'] = $url;
        $artist_array['artist_array']['info'] = $info;
        return $artist_array;
    }
}


///SEO 
if (!function_exists('SEO')) {
    function SEO($input)
    {
        $input = str_replace("&nbsp;", "amp", $input);
        $input = str_replace(array("'", ""), "-", $input); //remove single quote and dash
        $input = mb_convert_case($input, MB_CASE_LOWER, "UTF-8"); //convert to lowercase
        $input = preg_replace("#[^a-zA-Z]+#", "-", $input); //replace everything non an with dashes
        $input = preg_replace("#(-){2,}#", "$1", $input); //replace multiple dashes with one
        $input = trim($input, ""); //trim dashes from beginning and end of string if any
        return $input;
    }
}


///song_adds 
if (!function_exists('song_adds')) {
    function song_adds($id, $type)
    {
        if ($id != "") {
            $ads_list_arr = array();
            if (!empty($ads_list_arr)) {
                return $ads_list_arr;
            } else {
                $ads_list = "SELECT ad_code, video_code FROM tbl_songs where id = $id AND song_status = 1";
                $ads_list_arr = \App\Models\Songs::GetRawData($ads_list);
                if ($ads_list_arr) {
                    $ads_list_arr = (array)$ads_list_arr[0];
                    $ad_code   =   stripslashes($ads_list_arr['ad_code']);
                    $video_code   =   stripslashes($ads_list_arr['video_code']);
                } else {
                    $ad_code   =   '';
                    $video_code   = '';
                }
            }

            if ($type == 'video') {
                return  $video_code;
            }

            if ($type == 'adds') {
                return  $ad_code;
            }
        }
    }
}


///mainartist_detail 
if (!function_exists('mainartist_detail')) {
    // Main Artist Information
    function mainartist_detail($artistid)
    {

        $main_artist_list = "select id, artist_seo, artist_name from tbl_artists where id = '$artistid'";
        // $mainartist_arr	=	$db->get_row($main_artist_list,ARRAY_A);
        $mainartist_arr = \App\Models\Songs::GetRawData($main_artist_list);
        if ($mainartist_arr) {
            $mainartist_arr = (array)$mainartist_arr[0];
        } else {
            $mainartist_arr = array();
        }
        return $mainartist_arr;
    }
}


///check_report_review 
if (!function_exists('check_report_review')) {
    function check_report_review($review_id)
    {

        $report_query = "select r_report_id  from tbl_review_report where r_report_user_id = '" . session()->get('user_id') . "' AND r_report_review_id = '$review_id'";
        // $chk_report_arr = $db->get_row($report_query, ARRAY_A);
        $chk_report_arr = \App\Models\Songs::GetRawData($report_query);
        return $chk_report_arr;
    }
}


///get_playlist_like_counter 
if (!function_exists('get_playlist_like_counter')) {
    function get_playlist_like_counter($id)
    {

        $counter_main_playlist_like = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'playlist' AND like_receive_user = '$id'");
        if ($counter_main_playlist_like) {
            $counter_main_playlist_like = count($counter_main_playlist_like);
        } else {
            $counter_main_playlist_like = 0;
        }
        return $counter_main_playlist_like;
    }
}


///remove_spl_char 
if (!function_exists('remove_spl_char')) {
    function remove_spl_char($string)
    {

        $string = str_replace("'", '&#39;', $string); // Replaces all spaces with hyphens.
        $string = str_replace('"', '&#34;', $string);
        return utf8_encode($string);
    }
}

///sum_of_artist_rating 
if (!function_exists('sum_of_artist_rating')) {
    function sum_of_artist_rating($artistid)
    {

        $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where artist_id = $artistid AND status = 1";

        $rate_arr = array();
        $rate_arr    =    \App\Models\Songs::GetRawData($sum_rating);
        if ($rate_arr) {
            $rate_arr = (array) $rate_arr[0];
            $sum_rate = $rate_arr['sum_rate'];
            $counter = $rate_arr['counter'];
        } else {
            $sum_rate = 0;
            $counter = 0;
            $all_avg = 0;
        }


        if ($sum_rate == "" || $sum_rate == 0 || $counter == '' || $counter == 0) {
            $sum_rate = 0;
            $counter = 0;
            $all_avg = 0;
        } else {

            $all_avg  =  $sum_rate / $counter;
        }




        if ($all_avg == "") {
            $all_avg = 0;
        }

        if ($all_avg >= 8) {
            $color_pick = "#5cb85c";
        }

        if ($all_avg >= 6 && $all_avg < 8) {
            $color_pick = "#5cb85c";
        }

        if ($all_avg >= 4 && $all_avg < 6) {
            $color_pick = "#e06d21";
        }

        if ($all_avg >= 2 && $all_avg < 4) {
            $color_pick = "#d9534f";
        }

        if ($all_avg > 0 && $all_avg < 2) {
            $color_pick = "#d9534f";
        }

        $array_rating = array();
        $array_rating['rating_avg']    =    numberformat($all_avg);
        $array_rating['color_pick']    =    $color_pick;
        return $array_rating;
    }
}

///numberformat
if (!function_exists('numberformat')) {
    function numberformat($number)
    {
        $number_val =  number_format($number, 1);
        return $number_val;
    }
}


///get_small_thumb
if (!function_exists('get_small_thumb')) {
    function get_small_thumb($img)
    {

        $output = str_replace('300x300', '174s', $img);
        if ($output != "") {

            return $output;
        }
        return $img;
    }
}


///limit_text
if (!function_exists('limit_text')) {
    function limit_text($text, $limit)
    {
        $total_words  = str_word_count($text);
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]);
            if ($total_words > $limit) {
                $text .= '...';
            }
        }
        return $text;
    }
}


///artist_popular_review_data
if (!function_exists('artist_popular_review_data')) {
    function artist_popular_review_data($artist_id_db)
    {

        $reviews_list_arr = array();
        if (empty($reviews_list_arr)) {
            $reviews_list = "select b.album_seo, b.album_picture,a.artist_seo,a.artist_seo, a.artist_name,s.song_seo,s.picture,s.updated_by_itunes, s.song_title,r.* 
					 from tbl_reviews r,tbl_artists a,tbl_songs s,  tbl_artist_album b , tbl_songs_artist_album saa  
					 where 1=1 
					 AND r.song_id = s.id
					 AND r.artist_id = a.id
					 AND r.album_id = b.id
				     AND r.artist_id = '$artist_id_db'
					 AND s.id = saa.song_id 
					 AND s.song_status = 1
					 group by saa.song_id
					 order by  r.review_id desc
					 limit 3
					 ";
            $reviews_list_arr = \App\Models\Songs::GetRawData($reviews_list);
        }
        return  $reviews_list_arr;
    }
}


///count_likes
if (!function_exists('count_likes')) {
    function count_likes($user_id)
    {

        $query = "select count(*) as count_total from tbl_likes where like_type = 'profile' AND like_id = '$user_id'";
        $like_list_arr2 = \App\Models\Songs::GetRawData($query);
        if ($like_list_arr2) {
            $counter_main_profile_like = $like_list_arr2[0]->count_total;
        } else {
            $counter_main_profile_like    =   0;
        }


        $like_list_qry = "select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '" . $user_id . "' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1";
        $like_list_arr = \App\Models\Songs::GetRawData($like_list_qry);
        if ($like_list_arr) {
            $sum_likes = $like_list_arr[0]->count_likes + $counter_main_profile_like;
        } else {
            $sum_likes    =   0;
        }

        return $sum_likes;
    }
}
