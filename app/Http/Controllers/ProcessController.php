<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcessController extends Controller
{
    //AddPlaylistProcess
    public function AddPlaylistProcess()
    {
        if (isset($_POST)) {
            extract($_POST);
            // echo '<pre>';
            // print_r($_POST);
            // echo '</pre>';
            // die;
            $_SESSION[USER_SESSION_ARRAY]['USER_ID'] = session()->get('user_id');
            $errorstr = "";
            $case = 1;


            // $playlist_title   =     mysqli_escape_string($db->dbh, stripslashes(trim($_REQUEST['playlist_title'])));
            // $playlist_title   =     mysqli_escape_string($db->dbh, stripslashes(trim($_REQUEST['playlist_title'])));
            // $song_id          =     mysqli_escape_string($db->dbh, stripslashes(trim($_REQUEST['song_id'])));
            $artist_id          =    $art_id;

            if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {

                $errorstr = "Please sign in first.";
                $response = array("code" => 'warning', 'message' => $errorstr);
                return response()->json($response);
            }

            if ($playlist_title == '') {
                $response = array("code" => 'warning', 'message' => 'Please enter a name for your playlist..');
                return response()->json($response);
            } else {
                $query_check  = "select id from tbl_user_playlist where title_playlist  = '" . $playlist_title . "' AND user_id_playlist  = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "'";
                // $artist_list_arr    =    $db->get_results($query_check, ARRAY_A);
                $artist_list_arr = \App\Models\Songs::GetRawData($query_check);
                if (isset($artist_list_arr) && !empty($artist_list_arr)) {
                    $errorstr = "Sorry, this playlist name has already been used, please try again.";
                    $response = array("code" => 'warning', 'message' => $errorstr);
                    return response()->json($response);
                }
            }

            $artist_list = "SELECT  saa.artist_id,s.id, 
					s.song_title, 
					s.song_seo, 
					s.updated_by_itunes,
					s.picture, 
					b.album_title, 
					b.album_picture,a.artist_seo, 
					a.artist_name 
				FROM tbl_songs s 
					   INNER JOIN tbl_songs_artist_album saa
							   ON saa.song_id = s.id 
					   INNER JOIN tbl_artist_album b 
							   ON saa.album_id = b.id 
								INNER JOIN tbl_artists a 
							   ON saa.artist_id = a.id 
				WHERE  (saa.display_status = 1 AND s.song_status=1) and s.id = '$song_id' and a.id = '$artist_id' 
				group by s.id order by
				s.ranking_order asc                                
				LIMIT  50";

            // $artist_list_arr    =    $db->get_results($artist_list, ARRAY_A);
            $artist_list_arr = \App\Models\Songs::GetRawData($artist_list);

            if (!isset($artist_list_arr)) {
                $errorstr = "Invalid Song.";
                $response = array("code" => 'warning', 'message' => $errorstr);
                return response()->json($response);
            }



            if ($case == 1) {

                $update_qry = "insert into tbl_user_playlist set title_playlist  = '" . $playlist_title . "', title_playlist_seo  = '" . SEO($playlist_title) . "', song_id  = '" . $song_id . "', 	user_id_playlist  = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "', artist_id = '" . $artist_id . "', posted_date  = '" . date("Y-m-d H:i:s") . "'";
                // $db->query($update_qry);
                \App\Models\Songs::GetRawData($update_qry);

                $response = array("success" => 'warning', 'message' => 'done');
                return response()->json($response);
            } else {
                $errorstr;
                $response = array("code" => 'warning', 'message' => $errorstr);
                return response()->json($response);
            }
        }
    }


    //AddSongToPlayList
    public function AddSongToPlayList()
    {
        if (isset($_POST)) {
            extract($_POST);


            $errorstr = "";
            $case = 1;
            $_SESSION[USER_SESSION_ARRAY]['USER_ID'] = session()->get('user_id');
            $result_match = array();

            $playlist_title   =     '';
            $artist_id          =    $art_id;
            if (isset($playlist_arr)) {
                $size_ofplaylist_arr = sizeof($playlist_arr);
            } else {
                $size_ofplaylist_arr = 0;
            }



            if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {

                $errorstr .= "Please sign in first.";
                $response = array("code" => 'warning', 'message' => $errorstr);
                return response()->json($response);
            }

            $query_check  = "select playlist_id from tbl_user_playlist_songs where  user_id  = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND song_id  = '" . $song_id . "'";
            $artist_list_arr = \App\Models\Songs::GetRawData($query_check);



            if ($artist_list_arr) {
                $p = 0;
                foreach ($artist_list_arr as $pickids) {
                    $pickids = (array)$pickids;
                    $arr_ids[$p]  = $pickids['playlist_id'];
                    $p++;
                }

                $db_count_playlist  =  count($artist_list_arr);
            } else {
                $db_count_playlist  =  0;
            }


            if ($size_ofplaylist_arr == 0 && $db_count_playlist == 0) {
                $errorstr .= "Please select at least one playlist.";
                $response = array("code" => 'warning', 'message' => $errorstr);
                return response()->json($response);
            } else {

                $query_check  = "select id from tbl_user_playlist where title_playlist  = '" . $playlist_title . "' AND user_id_playlist  = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "'";

                $artist_list_arr = \App\Models\Songs::GetRawData($query_check);
                if (isset($artist_list_arr) && !empty($artist_list_arr)) {
                    $errorstr = "Sorry, this playlist name has already been used, please try again.";
                    $response = array("code" => 'warning', 'message' => $errorstr);
                    return response()->json($response);
                }
            }

            $artist_list = "SELECT  saa.artist_id,s.id, 
                            s.song_title, 
                            s.song_seo, 
                            s.updated_by_itunes,
                            s.picture, 
                            b.album_title, 
                            b.album_picture,a.artist_seo, 
                            a.artist_name 
                        FROM tbl_songs s 
                               INNER JOIN tbl_songs_artist_album saa
                                       ON saa.song_id = s.id 
                               INNER JOIN tbl_artist_album b 
                                       ON saa.album_id = b.id 
                                        INNER JOIN tbl_artists a 
                                       ON saa.artist_id = a.id 
                        WHERE  (saa.display_status = 1 AND s.song_status=1) and s.id = '$song_id' and a.id = '$artist_id' 
                        group by s.id order by
                        s.ranking_order asc                                
                        LIMIT  50";

            // $artist_list_arr    =    $db->get_results($artist_list, ARRAY_A);
            $artist_list_arr = \App\Models\Songs::GetRawData($artist_list);
            if (isset($artist_list_arr) && empty($artist_list_arr)) {
                $errorstr = "Invalid Song.";
                $response = array("code" => 'warning', 'message' => $errorstr);
                return response()->json($response);
            }


            if ($case == 1) {

                if ($db_count_playlist != 0 && $size_ofplaylist_arr == 0) {
                    $show_message  = "Song has been successfully removed from playlist.";
                } else {
                    $show_message  = "Song successfully updated to playlist.";
                }


                if (isset($arr_ids) && isset($playlist_arr)) {
                    $result_match = array_intersect($arr_ids, $playlist_arr);
                }

                if (isset($result_match) && !empty($result_match)) {

                    $wher_new = " playlist_id NOT IN ( '" . implode("','", $result_match) . "' ) AND ";
                    $delete_qry = "Delete from tbl_user_playlist_songs where   $wher_new song_id  = '" . $song_id . "' AND 	user_id   = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND artist_id = '" . $artist_id . "'";
                    \App\Models\Songs::GetRawData($delete_qry);
                } else {
                    $wher_new = '';
                }


                for ($t = 0; $t < $size_ofplaylist_arr; $t++) {
                    if (!in_array($playlist_arr[$t], $result_match)) {
                        $update_qry = "insert into tbl_user_playlist_songs set playlist_id   = '" . $playlist_arr[$t] . "', song_id  = '" . $song_id . "', 	user_id   = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "', artist_id = '" . $artist_id . "', p_date = '" . date("Y-m-d H:i:s") . "'";
                        \App\Models\Songs::GetRawData($update_qry);
                    }
                }

                if ($size_ofplaylist_arr == 0) {
                    $delete_qry = "Delete from tbl_user_playlist_songs where   song_id  = '" . $song_id . "' AND 	user_id   = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND artist_id = '" . $artist_id . "'";
                    \App\Models\Songs::GetRawData($delete_qry);
                }


                $response = array("code" => 'success', 'message' => $show_message);
                return response()->json($response);
            } else {
                $errorstr;
                $response = array("code" => 'warning', 'message' => $errorstr);
                return response()->json($response);
            }
        }
    }


    ///WriteReview
    public function WriteReview(Request $request)
    {
        if (isset($_POST)) {
            extract($_POST);

            $user_id = session()->get('user_id');

            $rating            =   trim($_REQUEST['api-readonly-test']);
            $review_title   =     trim($_REQUEST['review_title']);
            $review_detail  =     trim($_REQUEST['review_detail']);
            $song_id        =     trim($_REQUEST['song_id']);
            $artist_id        =    trim($_REQUEST['artist_id']);
            $album_id        =     trim($_REQUEST['album_id']);
            $song_seo_name  =     trim($_REQUEST['song_seo_name']);
            $artist_seo_name  =     trim($_REQUEST['artist_seo_name']);

            if (isset($edit_id)) {
                $edit_id = $edit_id;
            } else {

                $edit_id = '';
            }

            if ($user_id == "") {
                $_SESSION['store']['rating'] = $rating;
                $_SESSION['store']['review_title'] = $review_title;
                $_SESSION['store']['review_detail'] = $review_detail;

                $response = array("code" => 'warning', 'message' => 'Please sign in first.');
                return response()->json($response);
            }



            if ($edit_id == "") {
                if ($song_id != "") {
                    $count = \App\Models\Songs::GetRawData("select review_id from tbl_reviews where song_id = $song_id AND review_user_id = '" . $user_id . "'");

                    if ($count) {
                        $count = 1;
                    } else {
                        $count = 0;
                    }
                }
            }

            if ($edit_id == "") {
                if ($song_id == "" || $album_id == "" || $artist_id == "") {
                    $response = array("code" => 'warning', 'message' => 'This is a invalid song');
                    return response()->json($response);
                }
            }


            if ($count != 0) {
                $response = array("code" => 'warning', 'message' => 'You have already posted a review on this song. Please use the EDIT function to revise your review.');
                return response()->json($response);
            }

            if ($rating == "" || $rating == 0) {
                $response = array("code" => 'warning', 'message' => 'Unfortunately, you have not selected a star rating.');
                return response()->json($response);
            }

            if ($review_title == "") {
                $response = array("code" => 'warning', 'message' => 'Unfortunately, you have not entered a review title.');
                return response()->json($response);
            }

            if ($review_detail == "") {
                $response = array("code" => 'warning', 'message' => 'Unfortunately, you have not entered a review.');
                return response()->json($response);
            }

            if ($edit_id != "") {
                $song_query = "select song_id from tbl_reviews where review_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND review_id = '$edit_id'";
                $song_arr = \App\Models\Songs::GetRawData($song_query);
                $song_arr = (array)$song_arr[0];
                $song_id    = $song_arr['song_id'];

                $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = $song_id";
                $rate_arr = \App\Models\Songs::GetRawData($sum_rating);
                if ($rate_arr) {
                    $rate_arr = (array)$rate_arr[0];
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

                if ($counter == 0) {
                    $counter = 1;
                    $rev_counter  =  $counter;
                } else {
                    $rev_counter  =  $counter;
                }

                if ($all_avg == 0) {
                    $all_avg  =  $rating + $all_avg;
                }


                $update_qry = "update tbl_reviews set review_title = '" . $review_title . "', 	review_rating = '" . $rating . "', review_detail = '" . $review_detail . "', review_ip = '" . $_SERVER['REMOTE_ADDR'] . "' where  	review_user_id = '" . $user_id . "' AND review_id = '$edit_id'";
                \App\Models\Songs::GetRawData($update_qry);
                \App\Models\Songs::GetRawData("update tbl_songs set rate_song = '$all_avg',review_count = $rev_counter where id = '$song_id'");
                $slug = SERVER_ROOTPATH . $song_seo_name . "/reviews/" . $artist_seo_name . ".html-SEPARATOR-" . $_REQUEST['num'];
                $response = array("code" => 'success', 'url' => $slug);
                return response()->json($response);

                // echo 'done-SEPARATOR-' . SERVER_ROOTPATH . $song_seo_name . "/reviews/" . $artist_seo_name . ".html-SEPARATOR-" . $_REQUEST['num'];
                // exit;
            } else {

                $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = $song_id";

                $rate_arr = \App\Models\Songs::GetRawData($sum_rating);
                if ($rate_arr) {
                    $rate_arr = (array)$rate_arr[0];
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

                if ($counter == 0) {
                    $counter = 1;
                    $rev_counter  =  $counter + 1;
                } else {
                    $rev_counter  =  $counter + 1;
                }



                if ($all_avg == 0) {
                    $all_avg  =  $rating + $all_avg;
                } else {
                    $all_avg  =  ($rating + $all_avg) / 2;
                }



                $update_qry = "insert into tbl_reviews set review_title = '" . $review_title . "', 	review_rating = '" . $rating . "', 	review_user_id = '" . $user_id . "', review_detail = '" . $review_detail . "', review_ip = '" . $_SERVER['REMOTE_ADDR'] . "', review_post_date = '" . time() . "', song_id = '" . $song_id . "', album_id = '" . $album_id . "',  	artist_id = '" . $artist_id . "'";
                \App\Models\Songs::GetRawData($update_qry);
                $rev_counter  =  $counter + 1;
                \App\Models\Songs::GetRawData("update tbl_songs set rate_song = '$all_avg', review_count = review_count + 1 where id = '$song_id'");

                // unset($_SESSION['store']);
                $slug = SERVER_ROOTPATH . $song_seo_name . "/reviews/" . $artist_seo_name;
                $response = array("code" => 'success', 'url' => $slug);
                return response()->json($response);

                // echo 'done-SEPARATOR-' . SERVER_ROOTPATH . $song_seo_name . "/reviews/" . $artist_seo_name;
                // exit;
            }
        }
    }

    ///GetLikeDetail
    public function GetLikeDetail()
    {
        $data = array();
        $data['artist_seo'] = $_GET['artist'];
        $data['criteria'] = $_GET['critaria'];
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;


        ///row_artist
        $row_artist = array();
        // $row_artist = \App\Models\Songs::GetRawData("select * from tbl_artists where (artist_seo='" . $data['artist_seo'] . "' and artist_description!='') || id='" . $data['artist_seo'] . "'");
        $row_artist = \App\Models\Songs::GetRawData("select * from tbl_artists where (artist_seo='" . $data['artist_seo'] . "') || id='" . $data['artist_seo'] . "'");
        if ($row_artist) {
            $data['row_artist'] = (array)$row_artist[0];
        }

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // die;

        return view('include.detail', $data);
    }


    ///ReviewsArtistPopularLikes
    public function ReviewsArtistPopularLikes()
    {
        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['sr_no'] = $_GET['sr_no'];
        $data['artist_seo'] = $_GET['artist_seo'];
        $data['user_id'] = session()->get('user_id');

        return view('include.reviews_artist_popular_likes', $data);
    }


    ///FavouriteLike
    public function FavouriteLike()
    {

        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['artist_seo'] = $_GET['artist_seo'];
        $data['m'] = $_GET['m'];
        $data['user_id'] = session()->get('user_id');

        return view('include.favourite_like', $data);
    }
    ///FavouriteLikeSubArtist2
    public function FavouriteLikeSubArtist2()
    {

        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['sr_no'] = $_GET['sr_no'];
        $data['artist_seo'] = $_GET['artist_seo'];
        $data['k'] = $_GET['k'];
        $data['user_id'] = session()->get('user_id');

        return view('include.favourite_like_sub_artist2', $data);
    }


    ///FavouriteLikeSubArtistPopularLatest
    public function FavouriteLikeSubArtistPopularLatest()
    {

        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['sr_no'] = $_GET['sr_no'];
        $data['artist_seo'] = $_GET['artist_seo']; 
        $data['user_id'] = session()->get('user_id');

        return view('include.favourite_like_sub_artist_popular_latest', $data);
    }

    ///FavouriteLikeSubArtistPopular
    public function FavouriteLikeSubArtistPopular()
    {

        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['sr_no'] = $_GET['sr_no'];
        $data['artist_seo'] = $_GET['artist_seo']; 
        $data['user_id'] = session()->get('user_id'); 
        return view('include.favourite_like_sub_artist_popular', $data);
    }


    ///FavouriteLikeReview
    public function FavouriteLikeReview()
    {

        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['artist_seo'] = $_GET['artist_seo'];
        $data['user_id'] = session()->get('user_id');

        return view('include.favourite_like_review', $data);
    }
   
   
    ///FavouriteLikeReviewSong
    public function FavouriteLikeReviewSong()
    {

        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['user_name'] = $_GET['user_name'];
        $data['r_fav'] = $_GET['r_fav'];
        $data['user_id'] = session()->get('user_id');

        return view('include.favourite_like_review_song', $data);
    }


    ///likeArtistRecentReviews
    public function likeArtistRecentReviews()
    { 
        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['artist_seo'] = $_GET['artist_seo'];
        $data['sr_no'] = $_GET['sr_no'];
        $data['user_id'] = session()->get('user_id');

        return view('include.like_artist_recent_reviews', $data);
    }


    ///FavouriteLikeSub
    public function FavouriteLikeSub()
    {

        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['artist_seo'] = $_GET['artist_seo'];
        $data['k'] = $_GET['k'];
        $data['user_id'] = session()->get('user_id');

        return view('include.favourite_like_sub', $data);
    }

    ///DetailReview
    public function DetailReview()
    {

        $data = array();
        $data['user_seo'] = $_GET['user'];
        $data['rev_id'] = $_GET['review_id'];
        $data['critaria'] = $_GET['critaria'];
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        return view('include.detail_review', $data);
    }


    ///Discussion
    public function Discussion()
    {
        if (isset($_POST)) {


            $errorstr = "";
            $case = 1;
            $song_id        =      trim($_REQUEST['song_id']);
            $artist_id        =    trim($_REQUEST['artist_id']);
            $album_id        =     trim($_REQUEST['album_id']);

            $detail        =       trim($_REQUEST['detail']);

            $_SESSION[USER_SESSION_ARRAY]['USER_ID'] = session()->get('user_id');


            if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                echo $errorstr .= "Please sign in first";
                $case = 0;
                exit;
            }

            if ($song_id != "") {
                $qry   = "select comment_id from tbl_comments where comment_review_id = $song_id AND comment_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "'";
                $count = array();
                $count = \App\Models\Songs::GetRawData($qry);
                if ($count) {
                    $count = count($count);
                } else {
                    $count = 0;
                }
            }


            if ($song_id == "") {
                $errorstr .= "Invalid song.\n";
                $case = 0;
            }





            if ($detail == "") {
                $errorstr .= "Unfortunately, you have not entered your message.";
                $case = 0;
            }


            if ($case == 1) {

                $update_qry = "insert into tbl_comments set comment_details = '" . $detail . "', comment_artist_id = '" . $artist_id . "', comment_album_id  = '" . $album_id . "', comment_review_id = '" . $song_id . "', 	comment_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "', comment_post_date = '" . time() . "', comment_status = '1', comment_ip = '" . $_SERVER['REMOTE_ADDR'] . "'";

                \App\Models\Songs::GetRawData($update_qry);
                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }


    ///DetailCMS
    public function DetailCMS()
    {
        $data = array();
        $data['seo_url'] = $_GET['seo_url'];
        $data['mobile_view'] = 0;
        $get_page_content_qry = "SELECT * FROM tbl_pages WHERE page_seo_name = '" . $data['seo_url'] . "'";
        $get_page_content = \App\Models\Songs::GetRawData($get_page_content_qry);

        if (!$get_page_content) { 
            redirect('/');
  
        }
        else
        {
            $data['get_page_content'] = (array)$get_page_content[0];
        }

        return view('include.detail_cms', $data);
    }
}
