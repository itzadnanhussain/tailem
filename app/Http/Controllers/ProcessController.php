<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\libraries\thumb\Thumbnail;
// use App\Classes\Mail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

                $response = array("code" => 'success', 'message' => 'done');
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
            error_reporting(0);

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
                $url = SERVER_ROOTPATH . Slug($song_seo_name) . '/reviews/' . Slug($artist_seo_name);
                $response = array("code" => 'warning', 'message' => 'You have already posted a review on this song. Please use the EDIT function to revise your review.', 'redirect_uri' => $url);
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
                // echo 'wait';
                // die;
                $song_query = "select song_id from tbl_reviews where review_user_id = '" . $user_id . "' AND review_id = '$edit_id'";
                $song_arr = \App\Models\Songs::GetRawDataAdmin($song_query);



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
                $review_detail = StringReplace($review_detail);


                // $update_qry = "update tbl_reviews set review_title = '" . $review_title . "', 	review_rating = '" . $rating . "', review_detail = '" . $review_detail . "', review_ip = '" . $_SERVER['REMOTE_ADDR'] . "' where  	review_user_id = '" . $user_id . "' AND review_id = '$edit_id'";
                $update_qry = "update tbl_reviews set review_title = '" . $review_title . "', 	review_rating = '" . $rating . "', review_detail = '" . $review_detail . "', review_ip = '" . $_SERVER['REMOTE_ADDR'] . "' where  	review_user_id = '" . $user_id . "' AND review_id = '$edit_id'";
                //   echo '<pre>';
                //   print_r($update_qry);
                //   echo '</pre>';
                //   die;
                \App\Models\Songs::GetRawData($update_qry);

                // echo 'wait';
                // die;
                \App\Models\Songs::GetRawData("update tbl_songs set rate_song = '$all_avg',review_count = $rev_counter where id = '$song_id'");
                $slug = SERVER_ROOTPATH . Slug($song_seo_name) . "/reviews/" . Slug($artist_seo_name);
                $response = array("code" => 'success', 'url' => $slug);
                return response()->json($response);

                // echo 'done-SEPARATOR-' . SERVER_ROOTPATH . Slug($song_seo_name) . "/reviews/" . Slug($artist_seo_name) . ".html-SEPARATOR-" . $_REQUEST['num'];
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



                $update_qry = "insert into tbl_reviews set review_title = '" . $review_title . "', 	review_rating = '" . $rating . "', 	review_user_id = '" . $user_id . "', review_detail = '" . StringReplace($review_detail) . "', review_ip = '" . $_SERVER['REMOTE_ADDR'] . "', review_post_date = '" . time() . "', song_id = '" . $song_id . "', album_id = '" . $album_id . "',  	artist_id = '" . $artist_id . "'";
                \App\Models\Songs::GetRawData($update_qry);

                $rev_counter  =  $counter + 1;
                \App\Models\Songs::GetRawData("update tbl_songs set rate_song = '$all_avg', review_count = review_count + 1 where id = '$song_id'");

                // unset($_SESSION['store']);
                $slug = SERVER_ROOTPATH . Slug($song_seo_name) . "/reviews/" . Slug($artist_seo_name);
                $response = array("code" => 'success', 'url' => $slug);
                return response()->json($response);

                // echo 'done-SEPARATOR-' . SERVER_ROOTPATH . Slug($song_seo_name) . "/reviews/" . Slug($artist_seo_name);
                // exit;
            }
        }
    }





    ///DeleteReview
    public function DeleteReview()
    {
        if (isset($_POST)) {
            extract($_POST);

            $errorstr = "";
            $case = 1;
            $reviewid  = $review_id;
            $_SESSION[USER_SESSION_ARRAY]['USER_ID'] = session()->get('user_id');

            if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                $errorstr .= "Please sign in first.\n";
                $response = array('a' => $errorstr);
                return response()->json($response);
                $case = 0;
                exit;
            }

            if ($reviewid == "") {
                $errorstr .= "This review doesn't exist.\n";
                $case = 0;
            } else {
                $qry   = "select review_id, song_id from tbl_reviews where review_id = $reviewid AND review_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "'";
                $Query = array();
                $Query = \App\Models\Songs::GetRawData($qry);
                if ($Query) {
                    $count = count($Query);
                } else {
                    $count = 0;
                }


                if ($count == 0) {
                    $errorstr .= "This review doesn't exist.\n";
                    $case = 0;
                } else {
                    $row_song  =     \App\Models\Songs::GetRawData($qry);
                    $song_id   =    $row_song[0]->song_id;
                }
            }



            if ($case == 1) {
                $qry = "Delete from tbl_reviews where review_id = $reviewid";
                \App\Models\Songs::GetRawData($qry);

                $qry = "Delete from tbl_likes where like_id = $reviewid AND like_type = 'review_song'";
                \App\Models\Songs::GetRawData($qry);

                $qry = "Delete from tbl_comments where comment_review_id = $reviewid";
                \App\Models\Songs::GetRawData($qry);

                $qry = "Delete from tbl_review_report where r_report_review_id = $reviewid";
                \App\Models\Songs::GetRawData($qry);



                $main_query = "SELECT avg(r.review_rating) as sum, s.song_title, s.id, count(*) as counter FROM `tbl_reviews` r, tbl_songs s WHERE s.id = r.song_id AND r.song_id = '$song_id' group by r.song_id ";
                $query_arr    =    \App\Models\Songs::GetRawData($main_query);

                if ($query_arr) {
                    foreach ($query_arr as $info) {
                        $info = (array)$info;
                        $average  =  number_format($info['sum'], 1);
                        $sid  = $info['id'];

                        $updatequeryA = "update `tbl_songs` set rate_song = '$average', review_count = review_count - 1 where id = '$song_id'";
                        \App\Models\Songs::GetRawData($updatequeryA);
                    }
                } else {
                    $updatequeryA = "update `tbl_songs` set rate_song = '0.0', review_count = review_count - 1 where id = '$song_id'";
                    \App\Models\Songs::GetRawData($updatequeryA);
                }

                $response = array("a" => 'done', 'b' => $num);
                return response()->json($response);


                // echo 'done-'.$num;
                // exit;
            } else {
                echo $errorstr;
                $response = array('a' => $errorstr);
                return response()->json($response);
            }
        }
    }

    ///favourite_userprofile_likes_discussion
    public function favourite_userprofile_likes_discussion()
    {
        $data = array();
        $data['prod_id'] = $_REQUEST['prod_id'];
        $data['sr_no']    = $_REQUEST['sr_no'];
        $data['db_user_name'] = $_REQUEST['db_user_name'];
        $data['user_id'] = session()->get('user_id');
        return view('include.favourite_userprofile_likes_discussion', $data);
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


    ///edit_comment
    public function edit_comment()
    {
        $data = array();
        $data['comment_id'] = $_GET['comment_id'];
        $data['num'] = $_GET['num'];
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        return view('include.edit_comment', $data);
    }

    ///discussion_update_process
    public function discussion_update_process()
    {
        error_reporting(0);
        if (isset($_POST)) {
            extract($_POST);

            $errorstr = "";
            $case = 1;



            if (session()->get('user_id') == "") {
                echo $errorstr .= "Please sign in first.\n";
                $case = 0;
                exit;
            }

            if ($discussion_detail == "") {
                $errorstr .= "Please enter discussion detail.\n";
                $case = 0;
            }






            if ($case == 1) {
                if ($edit_id != "") {
                    $update_qry = "update tbl_comments set comment_details = '" . $discussion_detail . "' where  	comment_user_id = '" . session()->get('user_id') . "' AND comment_id = '$edit_id'";

                    \App\Models\Songs::GetRawData($update_qry);
                }
                $data = array('code' => 'success', 'num' => $_POST['num']);
                echo json_encode($data);
                die;

                // echo 'done-SEPARATOR-' . $_POST['num'];
                // die;
            } else {
                echo $errorstr;
                $data = array('code' => 'error', 'message' => $errorstr);
                echo json_encode($data);
                die;
            }
        }
    }
    ///delete_comment
    public function delete_comment()
    {
        $data = array();
        $data['comment_id'] = $_GET['comment_id'];
        $data['num'] = $_GET['num'];
        $data['critaria'] = $_GET['critaria'];
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        return view('include.delete_comment', $data);
    }

    ///delete_comment_process
    public function delete_comment_process()
    {
        if (isset($_POST)) {
            extract($_POST);
            $errorstr = "";
            $case = 1;
            $comment_id  = $_REQUEST['id'];
            $num    =    $_REQUEST['num'];
            $_SESSION[USER_SESSION_ARRAY]['USER_ID'] = session()->get('user_id');

            if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                echo $errorstr .= "Please sign in first.\n";
                $case = 0;
                exit;
            }

            if ($comment_id == "") {
                $errorstr .= "This discussion doesn't exist.\n";
                $case = 0;
            } else {
                $qry   =   "select comment_id from tbl_comments where comment_id = $comment_id AND comment_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "'";
                $count    =      \App\Models\Songs::GetRawData($qry);
                if (empty($count)) {
                    $errorstr .= "This discussion doesn't exist.\n";
                    $case = 0;
                }
            }

            if ($detail == "") {
                $errorstr .= "Please enter discussion detail.\n";
                $case = 0;
            }




            if ($case == 1) {
                $qry = "Delete from tbl_comments where comment_id = $comment_id";
                \App\Models\Songs::GetRawData($qry);
                $qry = "Delete from tbl_review_report where r_report_review_id = $comment_id And status = 1";
                \App\Models\Songs::GetRawData($qry);

                echo 'done-SEPARATOR-' . $num;
            } else {
                echo $errorstr;
            }
        }
    }

    ///update_playlist
    public function update_playlist()
    {
        $data = array();
        $data['song_id'] = $_GET['song_id'];
        $data['art_id'] = $_GET['art_id'];
        $data['edit_id'] = $_GET['edit_id'];
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        return view('include.update_playlist', $data);
    }

    ///update_playlist_process
    public function update_playlist_process()
    {
        if (isset($_POST)) {
            extract($_POST);
            error_reporting(0);

            function SEO($input)
            {
                $input = str_replace("&nbsp;", " ", $input);
                $input = str_replace(array("'", "-"), "", $input); //remove single quote and dash
                $input = mb_convert_case($input, MB_CASE_LOWER, "UTF-8"); //convert to lowercase
                $input = preg_replace("#[^a-zA-Z0-9]+#", "-", $input); //replace everything non an with dashes
                $input = preg_replace("#(-){}#", "$1", $input); //replace multiple dashes with one
                $input = trim($input, "-"); //trim dashes from beginning and end of string if any
                return $input;
            }
            $errorstr = "";
            $case = 1;


            // $playlist_title   =     mysqli_escape_string($db->dbh, stripslashes(trim($_REQUEST['playlist_title'])));
            // $song_id          =     mysqli_escape_string($db->dbh, stripslashes(trim($_REQUEST['song_id'])));
            // $artist_id          =     mysqli_escape_string($db->dbh, stripslashes(trim($_REQUEST['art_id'])));

            // $edit_id          =     mysqli_escape_string($db->dbh, stripslashes(trim($_REQUEST['edit_id'])));

            if (session()->get('user_id') == "") {
                echo $errorstr .= "Please sign in first.";
                $case = 0;
                exit;
            }

            if ($playlist_title == '') {
                echo $errorstr = "Please enter a name for your playlist..";
                $case = 0;
                exit;
            } else {
                $query_check  = "select id from tbl_user_playlist where title_playlist  = '" . $playlist_title . "' AND user_id_playlist  = '" . session()->get('user_id') . "' AND id != $edit_id";
                $artist_list_arr    =    \App\Models\Songs::GetRawData($query_check);

                if (isset($artist_list_arr) && !empty($artist_list_arr)) {
                    echo $errorstr = "Sorry, this playlist name has already been used, please try again.";
                    $case = 0;
                    exit;
                }
            }



            if ($case == 1) {
                $update_qry = "update tbl_user_playlist set title_playlist  = '" . $playlist_title . "', title_playlist_seo  = '" . SEO($playlist_title) . "' where user_id_playlist  = '" . session()->get('user_id') . "' AND id = '$edit_id'";
                \App\Models\Songs::GetRawData($update_qry);

                if ($p != '') {
                    if ($p != '') {
                        $p = $p . "/profile/";
                    }
                } else {
                    $p = '';
                }


                if (isset($p) && !empty($p)) {
                    echo 'done-SEPARATOR-' . SERVER_ROOTPATH . "playlists-" . SEO($playlist_title);
                } else {
                    echo 'done-SEPARATOR-' . SERVER_ROOTPATH . $p . "playlists-" . SEO($playlist_title);
                }
                exit;
            } else {
                echo $errorstr;
            }
        }
    }
    ///delete_playlist
    public function delete_playlist()
    {
        $data = array();
        $data['edit_id'] = $_GET['edit_id'];
        $data['critaria'] = $_GET['critaria'];
        $data['mobile_view '] = 0;
        $data['user_id'] = session()->get('user_id');


        return view('include.delete_playlist', $data);
    }

    ///delete_playlist_process
    public function delete_playlist_process()
    {
        if (isset($_REQUEST)) {
            error_reporting(0);

            $errorstr = "";
            $case = 1;
            $comment_id  = $_REQUEST['id'];
            $id  = $_REQUEST['id'];
            $num    =    $_REQUEST['num'];
            $p    =    $_REQUEST['p'];
            $_SESSION[USER_SESSION_ARRAY]['USER_ID'] = session()->get('user_id');

            if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                echo $errorstr .= "Please sign in first.\n";
                $case = 0;
                exit;
            }

            if ($id == "") {
                $errorstr .= "This Playlist doesn't exist.\n";
                $case = 0;
            } else {
                $query_check  = "select id from tbl_user_playlist where  user_id_playlist  = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND id = $id";

                $artist_list_arr    =      \App\Models\Songs::GetRawData($query_check);
                if (!isset($artist_list_arr)) {
                    echo $errorstr = "Sorry, this playlist does not exist.";
                    $case = 0;
                    exit;
                }
            }


            if ($case == 1) {
                \App\Models\Songs::GetRawData("Delete from tbl_user_playlist where id = $id AND  user_id_playlist  = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "'");

                \App\Models\Songs::GetRawData("Delete from tbl_user_playlist_songs where playlist_id = $id AND  user_id   = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "'");

                $playlist_arr =  get_first_playlist_record($_SESSION[USER_SESSION_ARRAY]['USER_ID']);

                if ($p != 'n') {
                    $p = $p . "-profile-";
                } else {
                    $p = '';
                }

                if (isset($p) && !empty($p)) {
                    echo 'done-SEPARATOR-' . SERVER_ROOTPATH . "playlists";
                } else {
                    echo 'done-SEPARATOR-' . SERVER_ROOTPATH . $p . "playlists";
                }
            } else {
                echo $errorstr;
            }
        }
    }


    ///DM_Manipulate
    public function DM_Manipulate()
    {
        $data = array();
        $data['actionfunction'] = $_POST['actionfunction'];
        $data['page'] = $_POST['page'];
        $data['song_id'] = $_POST['song_id'];
        $data['limit'] = 1;
        $data['user_id'] = session()->get('user_id');
        $data['user_name'] = session()->get('user_name');
        return view('common.dbmanupulate', $data);
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


    ///favourite_like_review_song_detail
    public function favourite_like_review_song_detail()
    {
        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['user_name'] = $_GET['user_name'];
        $data['r_fav'] = $_GET['r_fav'];
        $data['user_id'] = session()->get('user_id');

        return view('include.favourite_like_review_song_detail', $data);
    }


    ///FavouriteUserProfileLikesMainList
    public function FavouriteUserProfileLikesMainList()
    {
        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['sr_no'] = $_GET['sr_no'];
        $data['user_name'] = $_GET['username'];
        $data['user_id'] = session()->get('user_id');

        return view('include.favourite_userprofile_likes_main_list', $data);
    }
    ///favourite_userprofile_screenlikes
    public function favourite_userprofile_screenlikes()
    {
        if ($_POST) {
            $data = array();
            $data['prod_id'] = $_POST['prod_id'];
            $data['sr_no'] = $_POST['sr_no'];
            $data['user_name'] = $_POST['db_user_name'];
            $data['db_user_name'] = $_POST['db_user_name'];
            $data['user_id'] = session()->get('user_id');
            return view('include.favourite_userprofile_screenlikes', $data);
        }
    }


    ///FavouriteLikeSubArtistPop
    public function FavouriteLikeSubArtistPop()
    {
        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['artist_seo'] = $_GET['artist_seo'];
        $data['sr_no'] = $_GET['sr_no'];
        $data['user_id'] = session()->get('user_id');

        return view('include.favourite_like_sub_artist_pop', $data);
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
    ///favourite_userprofile_likes_page
    public function favourite_userprofile_likes_page()
    {
        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['sr_no'] = $_GET['sr_no'];
        $data['username'] = $_GET['username'];
        $data['user_id'] = session()->get('user_id');

        return view('include.favourite_userprofile_likes_page', $data);
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
    ///pop_favourite_user_profile_likes
    public function pop_favourite_user_profile_likes()
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


    ///FavouriteLikeReviewScreen
    public function FavouriteLikeReviewScreen()
    {
        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['user_name'] = $_GET['user_name'];
        $data['r_fav'] = $_GET['r_fav'];
        $data['tm'] = $_GET['tm'];
        $data['user_id'] = session()->get('user_id');

        return view('include.favourite_like_review_screen', $data);
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


    ///pop_favourite_userprofile_likes
    public function pop_favourite_userprofile_likes()
    {
        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['sr_no'] = $_GET['sr_no'];

        $data['user_id'] = session()->get('user_id');
        return view('include.popfavourite_userprofile_likes', $data);
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


    ///DetailProfile
    public function DetailProfile()
    {
        error_reporting(0);

        $data = array();
        $data['user_seo'] = $_GET['user'];
        // $data['rev_id'] = $_GET['review_id'];
        $data['critaria'] = $_GET['critaria'];
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        return view('include.detail_profile', $data);
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
        } else {
            $data['get_page_content'] = (array)$get_page_content[0];
        }

        return view('include.detail_cms', $data);
    }

    ///DetailCMS_One
    public function DetailCMS_One($seo_url)
    {
        $data = array();
        $data['seo_url'] = $seo_url;
        $data['mobile_view'] = 0;
        $get_page_content_qry = "SELECT * FROM tbl_pages WHERE page_seo_name = '" . $data['seo_url'] . "'";
        $get_page_content = \App\Models\Songs::GetRawData($get_page_content_qry);

        if (!$get_page_content) {
            redirect('/');
        } else {
            $data['get_page_content'] = (array)$get_page_content[0];
        }

        return view('include.signup_popup', $data);
    }

    ///ChangeProfilePicture
    public function ChangeProfilePicture()
    {
        error_reporting(0);
        $case = 1;
        $errorstr = null;
        if ($_FILES["image_name"]['name'] == "") {
            $errorstr .= "Please upload your profile image.\n";
            $case = 0;
        } elseif ($_FILES["image_name"]['name'] != "") {
            $filename = $_FILES["image_name"]['name'];
            $TmpExt   = strtolower(substr($filename, strrpos($filename, '.') + 1));
            $ext = array('jpg', 'png', 'gif', 'JPEG', 'jpeg');
            if (!in_array($TmpExt, $ext)) {
                $errorstr .= "Incorrect file format, please try again.\n";
                $case = 0;
            }
        }

        $path            = 'site_upload/user_images/';

        if ($case == 1) {
            if ($_FILES["image_name"]['name'] != "") {
                $select_img = "select profile_image from  tbl_users where user_id='" . session()->get('user_id') . "' ";
                $result = \App\Models\Songs::GetRawData($select_img);
                $result = (array)$result[0];
                $old_image  = $result['profile_image'];
                $imgfile = $path . $old_image;
                $thumbfile = $path . 'thumb_' . $old_image;
                $thumbfile_small = $path . 'small_thumb_' . $old_image;
                @unlink($imgfile);
                @unlink($thumbfile);
                @unlink($thumbfile_small);

                $icon_array = $_FILES["image_name"]['name'];
                $img_formats = array("jpeg", "gif", "png", "jpg", "JPEG", "GIF", "PNG", "JPG");
                $allowed_size = 2; // Allowed Photo Size in MB
                $file_temp = $_FILES["image_name"]['tmp_name'];
                $h_image_size = filesize($_FILES["image_name"]['tmp_name']);
                $h_image_size = ($h_image_size / 1024) / 1024;
                // $h_file_name_array     = $_FILES["user_image"];
                // $h_file_ext = ltrim(strtolower(strrchr($_FILES["image_name"]['name'], '.')), '.');

                $icon_orgname = rand() . "_" . $_FILES["image_name"]['name'];
                $h_newthumb_name = 'thumb_' . $icon_orgname;
                $h_small_thumb_name = 'small_thumb_' . $icon_orgname;
                $h_photo_path = $path . $icon_orgname;
                $h_photothumb_path = $path . $h_newthumb_name;
                $h_dir = $path;

                if ($h_image_size < $allowed_size) {
                    $t = copy($file_temp, $h_photo_path);
                    $img_qry = "UPDATE tbl_users SET profile_image='" . $icon_orgname . "' where user_id = '" . session()->get('user_id') . "'";
                    \App\Models\Songs::GetRawData($img_qry);

                    $a = new Thumbnail();
                    // creating thumbnail
                    $a->create($_FILES["image_name"]['tmp_name'], 241, '238', $h_dir . $h_newthumb_name);

                    $b = new Thumbnail();
                    // creating thumbnail
                    $b->create($_FILES["image_name"]['tmp_name'], 50, '50', $h_dir . $h_small_thumb_name);
                }
            }
            echo "Done";
        } else {
            echo $errorstr;
        }
    }


    ///ChangeUserName
    public function ChangeUserName()
    {
        error_reporting(0);
        if (isset($_POST)) {
            $errorstr = "";
            $case = 1;
            $username          = trim($_REQUEST['username']);

            if ($username == "") {
                $errorstr .= "Please enter your new username<br>";
                $case = 0;
            } else {
                $chk_pass_qry = 'select user_name  from tbl_users where 
		 user_name  = \'' . $username . '\' and user_id!="' . session()->get('user_id') . '" ';
                $chk_pass_arr = \App\Models\Songs::GetRawData($chk_pass_qry);
                $db_user_name    = $chk_pass_arr[0]->user_name;
                if ($db_user_name != "") {
                    $errorstr .= "Sorry the username is not available, please try using another one.<br>";
                    $case = 0;
                }
            }

            if ($case == 1) {
                $user_seo    =    str_replace(" ", "_", addslashes($username));

                $update_qry = "UPDATE tbl_users set user_name = '" . $username . "', user_seo = '" . $user_seo . "' where user_id='" . session()->get('user_id') . "'";
                \App\Models\Songs::GetRawData($update_qry);
                session()->put('user_name', $username);
                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }


    ///ChangeProfilePassword
    public function ChangeProfilePassword()
    {
        error_reporting(0);
        if (isset($_POST)) {
            $errorstr = "";
            $case = 1;
            $old_password          = trim($_REQUEST['old_password']);
            $new_password          = trim($_REQUEST['new_password']);
            $confirm_new_password = trim($_REQUEST['confirm_new_password']);

            if ($old_password == "") {
                $errorstr .= "Please enter your current password<br>";
                $case = 0;
            } else {
                $chk_pass_qry = 'select password as chk_password from tbl_users where user_id="' . session()->get('user_id') . '" ';
                $chk_pass_arr = \App\Models\Songs::GetRawData($chk_pass_qry);
                $chk_password    = $chk_pass_arr[0]->chk_password;


                if ($chk_password == "") {
                    $errorstr .= "Incorrect current password entered, please try again<br>";
                    $case = 0;
                } else {
                    if ($new_password == "") {
                        $errorstr .= "Please enter your new password<br>";
                        $case = 0;
                    } elseif (strlen($new_password) < 6) {
                        $errorstr .= "New password must have at least 6 characters<br>";
                        $case = 0;
                    } elseif ($confirm_new_password == "") {
                        $errorstr .= "Please confirm your new password<br>";
                        $case = 0;
                    } elseif (strlen($confirm_new_password) < 6) {
                        $errorstr .= "Confirm new password must have at least 6 characters<br>";
                        $case = 0;
                    } elseif ($new_password != $confirm_new_password) {
                        $errorstr .= "Your new password does not match, please try again<br>";
                        $case = 0;
                    }
                }
            }

            $password = Hash::make($new_password);
            // if (Hash::check($new_password, $chk_password)) {
            // } else {
            //     $errorstr .= "Your old password not correct, please try again<br>";
            //     $case = 0;
            // }

            if ($case == 1) {
                $update_qry = "UPDATE tbl_users set password = '" . $password . "' 
         where user_id='" . session()->get('user_id') . "'";
                \App\Models\Songs::GetRawData($update_qry);
                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///PasswordForgot
    public function PasswordForgot()
    {
        if ($_POST) {
            extract($_POST);
            error_reporting(0);
            $case = 1;
            $error_str = '';
            if ($user_email == '') {
                $error_str .= "Please enter email address <br>";
                $case = 0;
            } else {
                if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                    $error_str .= "Please enter valid email address <br>";
                    $case = 0;
                } else {
                    $qry = "select password, email, user_id, user_name,status from tbl_users where email='" . trim($user_email) . "'";
                    $chk_email_exist = \App\Models\Songs::GetRawData($qry);
                    // echo '<pre>';
                    // print_r($chk_email_exist);
                    // echo '</pre>';
                    // die;


                    if ($chk_email_exist) {
                        $chk_email_exist = (array)$chk_email_exist[0];
                        $db_email_address  = $chk_email_exist['email'];

                        $user_id  = $chk_email_exist['user_id'];
                        $user_name    = $chk_email_exist['user_name'];
                        $simple_password    = $chk_email_exist['password'];
                        $status  = $chk_email_exist['status'];

                        $activation_code = base64_encode($user_id . rand());

                        if ($status == 0) {
                            $error_str .= "Your account is not active <br>";
                            $case = 0;
                        }
                    } else {
                        $error_str .= "This email is not registered <br>";
                        $case = 0;
                    }
                }
            }


            if ($case == 1) {
                $qry = "update tbl_users set activation_code = '$activation_code' where user_id = '$user_id'";
                \App\Models\Songs::GetRawData($qry);
                $adminemail  = "Select email from tbl_admin ";
                $arradmin    = \App\Models\Songs::GetRawData($adminemail);
                $admin_email = stripslashes($arradmin[0]->email);

                $qry = "SELECT * FROM  tbl_emailtemplets WHERE etemp_id ='2'";
                $get_mail_temp     = \App\Models\Songs::GetRawData($qry);

                if ($get_mail_temp) {
                    $get_mail_temp = (array)$get_mail_temp[0];
                    $temp_subject = html_entity_decode(stripslashes($get_mail_temp['etemp_subject']));
                    $msg_body = html_entity_decode(stripslashes($get_mail_temp['etemp_data']));
                }

                $link = "<a href=\"" . SERVER_ROOTPATH . "reset-password-" . $activation_code . "\">" . "Reset Password</a>";

                $msg_body = str_replace('{USERNAME}', $user_name, $msg_body);
                $msg_body = str_replace('{LINK}', $link, $msg_body);



                sendemail($user_email, $cc, $admin_email, $temp_subject, $msg_body, $filename, $filepath);

                echo "done-SEPARATOR-An email has been sent to your email address. Please follow the instructions in your email to recover your password.";
            } else {
                echo $error_str;
                exit;
            }
        }
    }


    ///ReportProcess
    public function ReportProcess()
    {
        if (isset($_POST)) {
            extract($_POST);
            error_reporting(0);

            $errorstr = "";
            $case = 1;
            $reviewsid          = trim($_REQUEST['reviewsid']);
            $reviews_id          = trim($_REQUEST['reviewsid']);
            $num          = trim($_REQUEST['num']);
            $_SESSION[USER_SESSION_ARRAY]['USER_ID'] = session()->get('user_id');
            $review_detail          = trim($_REQUEST['review_detail']);
            $report_option = trim($_REQUEST['report_option']);

            if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                echo "Please sign in first";
                exit;
            }


            if ($reviews_id == '') {
                $errorstr .= "No review found.\n";
                $case = 0;
            } else {
                $qry = "select r_report_id  from tbl_review_report where r_report_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND r_report_review_id = '$reviewsid'";
                $chk_report_arr = \App\Models\Songs::GetRawData($qry);


                $qry = "select review_id, review_user_id from tbl_reviews where review_id = '$reviewsid'";
                $chk_review_arr = \App\Models\Songs::GetRawData($qry);



                if (!$chk_review_arr) {
                    $errorstr .= "No review found.\n";
                    $case = 0;
                }
            }

            if ($chk_review_arr) {
                $chk_review_arr = (array)$chk_review_arr[0];
                if ($chk_review_arr['review_user_id'] == $_SESSION[USER_SESSION_ARRAY]['USER_ID']) {
                    echo $errorstr .= "You can't report your own post.\n";
                    exit;
                    $case = 0;
                }
            }

            if ($chk_report_arr) {
                echo $errorstr .= "Msg-SEPARATOR-We are still in the process of reviewing your request and will take action accordingly.-SEPARATOR-$num";
                exit;
                $case = 0;
            }

            if ($report_option == "") {
                $errorstr .=  "Please select a report option from the list\n";
                $case = 0;
            }

            if ($case == 1) {
                $post = array();
                $post['r_report_review_id'] = $reviewsid;
                $post['r_report_user_id'] = $_SESSION[USER_SESSION_ARRAY]['USER_ID'];
                $post['r_report_date'] = time();
                $post['r_report_status'] = 1;
                $post['r_report_ip'] = $_SERVER['REMOTE_ADDR'];
                $post['r_report_details'] = $review_detail;
                $post['r_report_option'] = $report_option;
                $insert_id = addNew('review_report', $post);
                if ($insert_id) {
                    echo 'done-SEPARATOR-' . $num;
                } else {
                    echo 'Record not added';
                    exit;
                }
            } else {
                echo $errorstr;
            }
        }
    }

    ///notification_display
    public function notification_display()
    {
        $data = array();
        $data['user_id'] = session()->get('user_id');


        ///load view
        $data['currentFile'] = 'notification_display';
        $data['title'] =  GetTitle();
        return view('include.notification_display', $data);
    }


    ///delete_notification
    public function delete_notification()
    {
        error_reporting(0);
        if (isset($_REQUEST)) {
            $user_id = session()->get('user_id');

            $errorstr = "";
            $case = 1;
            $reviewid  = $_REQUEST['id'];

            if ($user_id == "") {
                echo $errorstr .= "Please sign in first.\n";
                $case = 0;
                exit;
            }

            if ($reviewid == "") {
                $errorstr .= "This notification doesn't exist.\n";
                $case = 0;
            }

            if ($case == 1) {
                \App\Models\Songs::GetRawData("update tbl_likes set del_notification = '1' where like_receive_user = '" . $user_id . "' AND id = $reviewid");

                echo 'done-SEPARATOR-' . $reviewid;
            } else {
                echo $errorstr;
            }
        }
    }

    ///update_notification_click
    public function update_notification_click()
    {
        error_reporting(0);
        if (isset($_REQUEST)) {
            extract($_REQUEST);
            $errorstr = "";
            $case = 1;
            $user_id = session()->get('user_id');


            if ($user_id == "") {
                echo $errorstr = "Please sign in first.";
                $case = 0;
                exit;
            }


            if ($case == 1) {
                if ($_REQUEST['delete'] == 'all') {
                    \App\Models\Songs::GetRawData("update tbl_likes set del_notification = '1' where  like_receive_user = '" . $user_id . "'");
                } else {
                    $id  = $_REQUEST['id'];
                    \App\Models\Songs::GetRawData("update tbl_likes set notification_click = '0' where like_receive_user = '" . $user_id . "' AND id = $id");
                }

                //echo 'done-SEPARATOR-'.$reviewid;
            } else {
                echo $errorstr;
            }
        }
    }

    ///detail_playlist
    public function detail_playlist()
    {
        $data = array();
        $data['user_id'] = session()->get('user_id');

        ///artist
        if (isset($_GET['artist'])) {
            $data['artist'] = $_GET['artist'];
        }

        ///critaria
        if (isset($_GET['critaria'])) {
            $data['critaria'] = $_GET['critaria'];
        }


        ///load view
        $data['currentFile'] = 'detail_playlist';
        $data['title'] =  GetTitle();
        return view('include.detail_playlist', $data);
    }


    ///favourite_playlist
    public function favourite_playlist()
    {
        $data = array();
        $data['prod_id'] = $_GET['prod_id'];
        $data['user_id'] = session()->get('user_id');

        return view('include.favourite_playlist', $data);
    }
}
