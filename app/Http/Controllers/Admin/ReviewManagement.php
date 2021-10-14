<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\libraries\thumb\Thumbnail;


class ReviewManagement extends Controller
{

    ///Add_New_Review
    public function Add_New_Review()
    {
        $data = array();
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['art_id'] = null;
        $data['song_id'] = null;
        $data['album_id'] = null;
        $data['review_rating'] = null;
        $data['review_title'] = null;
        $data['review_detail'] = null;
        $data['db_review_id'] = null;



        ///edit_id
        if (isset($_GET['song_id'])) {
            $data['song_id'] = $_GET['song_id'];
        }

        ///art_id
        if (isset($_GET['art_id'])) {
            $data['art_id'] = $_GET['art_id'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }



        ///common  lines
        $data['currentFile'] = 'review_add';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.review_add', $data);
    }

    ///Edit_Review
    public function Edit_Review()
    {
        $data = array();
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['art_id'] = null;
        $data['edit_id'] = null;
        $data['album_id'] = null;
        $data['review_rating'] = null;
        $data['review_title'] = null;
        $data['review_detail'] = null;
        $data['db_review_id'] = null;
        $data['level1_cat_id'] = null;
        $data['level2_cat_id'] = null;
        $data['level3_cat_id'] = null;
        $data['level4_cat_id'] = null;



        ///edit_id
        if (isset($_GET['edit_id'])) {
            $data['edit_id'] = $_GET['edit_id'];
        }



        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }



        ///common  lines
        $data['currentFile'] = 'edit_review';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.edit_review', $data);
    }

    ///Review_List
    public function Review_List()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;


        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///common  lines
        $data['currentFile'] = 'reviews_list';
        $data['targetpage'] = 'reviews_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.reviews_list', $data);
    }


    ///Review_Process
    public function Review_Process()
    {
        if (isset($_POST)) {
            error_reporting(0);
            extract($_POST);
            $errorstr = "";
            $case = 1;
            $review_rating    = trim($_REQUEST['review_rating']);
            $review_title     = trim($_REQUEST['review_title']);
            $review_detail    = trim($_REQUEST['review_detail']);
            $review_user_id   = trim($_REQUEST['review_user_id']);

            if ($review_rating == "") {
                $errorstr .= "Please Select Review Rating\n";
                $case = 0;
            } elseif ($review_rating < 1 || $review_rating > 10) {
                $errorstr .= "Please Select Valid Review Rating\n";
                $case = 0;
            }

            if ($review_title == "") {
                $errorstr .= "Please Enter Review Title\n";
                $case = 0;
            }

            if ($review_detail == "") {
                $errorstr .= "Please Enter Review Details\n";
                $case = 0;
            }

            if ($review_user_id == "") {
                $errorstr .= "Please Select User\n";
                $case = 0;
            } else {
                $chk_user_qry = "select count(user_name) as chk_user, user_id from tbl_users where user_name=\"" . $review_user_id . "\" ";

                $chk_user_arr = \App\Models\Songs::GetRawDataAdmin($chk_user_qry);
                $chk_user = $chk_user_arr['chk_user'];
                $user_id   =  $chk_user_arr['user_id'];
                if ($chk_user == "" || $chk_user < 1) {
                    $errorstr .= "This User Name does't Exist\n";
                    $case = 0;
                }
            }

            if ($case == 1) {
                $qry   = "select review_id from tbl_reviews where song_id = $song_id AND review_user_id = '" . $user_id . "'";

                $count = array();
                $count = \App\Models\Songs::GetRawData($qry);
                if ($count) {
                    $count = count($count);
                } else {
                    $count = 0;
                }
                if ($count != 0) {
                    echo $errorstr .= "You have already posted a review on this song.";
                    $case = 0;
                    exit;
                }
            }

            if ($case == 1) {

                $post_data = array();
                $post_data['review_title'] = $review_title;
                $post_data['review_rating'] = $review_rating;
                $post_data['review_user_id'] = $user_id;
                $post_data['review_detail'] = $review_detail;
                $post_data['review_ip'] = $_SERVER['REMOTE_ADDR'];
                $post_data['review_post_date'] = time();
                $post_data['song_id'] = $song_id;
                $post_data['album_id'] = $album_id;
                $post_data['artist_id'] = $artist_id;
                $post_data['review_given'] = 'admin';
                $post_data['review_date'] = time();


                $last_insert_id =  addNew('reviews', $post_data);
                $rev_counter  =  $counter + 1;



                $update_qry2 = "insert into tbl_likes set  	like_id  = '" . $last_insert_id . "', 	like_type  = 'admin_review',  	like_receive_user = '" . $user_id . "', like_from_user_id  = '$user_id', date  = '" . date("Y-m-d") . "',  display_date  = NOW()";

                \App\Models\Songs::GetRawData($update_qry2);


                $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = $song_id";
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


                if ($all_avg == 0) {
                    $all_avg  =  $rating + $all_avg;
                } else {
                    $all_avg  =  ($rating + $all_avg) / 2;
                }

                $rev_counter  =  $counter + 1;





                $qry =  "update tbl_songs set rate_song = '$all_avg', review_count = $rev_counter where id = '$song_id'";
                \App\Models\Songs::GetRawData($qry);


                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Edit_Review_Process
    public function Edit_Review_Process()
    {
        if (isset($_POST)) {
            $errorstr = "";
            error_reporting(0);
            $case = 1;
            $review_rating    = trim($_REQUEST['review_rating']);
            $review_title     = trim($_REQUEST['review_title']);
            $review_detail    = trim($_REQUEST['review_detail']);
            $review_user_id   = trim($_REQUEST['review_user_id']);
            $level1_cat_id    = trim($_REQUEST['level1_cat_id']);
            $level2_cat_id    = trim($_REQUEST['level2_cat_id']);
            $level3_cat_id    = trim($_REQUEST['level3_cat_id']);
            $level4_cat_id    = trim($_REQUEST['level4_cat_id']);
            $level5_cat_id    = trim($_REQUEST['level5_cat_id']);
            $update_id        = trim($_REQUEST['update_id']);
            if ($review_rating == "") {
                $errorstr .= "Please Select Review Rating\n";
                $case = 0;
            } elseif ($review_rating < 1 || $review_rating > 10) {
                $errorstr .= "Please Select Valid Review Rating\n";
                $case = 0;
            }

            if ($review_title == "") {
                $errorstr .= "Please Enter Review Title\n";
                $case = 0;
            }

            if ($review_detail == "") {
                $errorstr .= "Please Enter Review Details\n";
                $case = 0;
            }

            if ($review_user_id == "") {
                $errorstr .= "Please Select User\n";
                $case = 0;
            } else {
                $chk_user_qry = "select count(user_id) as chk_user from tbl_users where user_id=\"" . $review_user_id . "\" ";
                $chk_user_arr = \App\Models\Songs::GetRawDataAdmin($chk_user_qry);
                $chk_user = $chk_user_arr['chk_user'];
                if ($chk_user == "" || $chk_user < 1) {
                    $errorstr .= "This User Name does't Exist\n";
                    $case = 0;
                }
            }



            if ($case == 1) {
                //review_user_id ='".mysqli_escape_string($db->dbh, stripslashes($review_user_id))."'	
                $qry =  "Update tbl_reviews set review_title ='" .  stripslashes($review_title) . "', review_detail ='" . stripslashes($review_detail) . "', review_rating ='" . stripslashes($review_rating) . "' where review_id='" . $update_id . "' ";
                $update_query = \App\Models\Songs::GetRawData($qry);
                //Insert Notification
                $insert_notification_qry = "INSERT INTO tbl_notifications set 
		notification_sent_user_id='" . session()->get('reviewsite_cpadmin_id') . "', notification_receive_user_id='" . $review_user_id . "' ,type='Moderator Edit Review',read_status='unread', status='1', date_added='" . time() . "' ";
                \App\Models\Songs::GetRawData($insert_notification_qry);

                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Review_Delete
    public function Review_Delete()
    {
        if (!empty($_POST['del_id'])) {
            $review_id  = base64_decode($_POST['del_id']);
            $select_qry = "select review_id,review_user_id from tbl_reviews where review_id='" . $review_id . "' ";

            $select_arr = \App\Models\Songs::GetRawDataAdmin($select_qry);
            $review_id  = $select_arr['review_id'];
            $review_user_id  = $select_arr['review_user_id'];

            if ($review_id == "") {
                $review_id  = 0;
            }


            if ($review_id == 0) {
                echo 'Error';
            } else {

                $song_notification =
                    "select s.song_title, s.song_seo, a.artist_seo  
						   from  tbl_reviews r, tbl_songs s, tbl_artists a  
						   where r.review_id = $review_id 
						   AND r.song_id = s.id
						   AND r.artist_id = a.id";

                $song_result_notification =  \App\Models\Songs::GetRawDataAdmin($song_notification);



                $mesg = "Moderator has removed your review on <a class=\"text_blck\" href=\"" . SERVER_ROOTPATH . $song_result_notification['song_seo'] . "-reviews-" . $song_result_notification['artist_seo'] . ".html\"><strong>" . wordwrap(stripslashes($song_result_notification['song_title']), 100, " ", true) . "</strong></a>.";
                $insert_notification_qry = "insert into tbl_likes set 
		like_type='delete_review_song',description='$mesg',read_status='1',like_id='$review_id', like_receive_user='$review_user_id', date='" . date("Y-m-d") . "'";
                \App\Models\Songs::GetRawData($insert_notification_qry);

                //delete review
                $del_review_qry = "Delete from tbl_reviews where review_id='" . $review_id . "'";
                \App\Models\Songs::GetRawData($del_review_qry);

                //delete review like
                $del_review_like_qry = "Delete from tbl_likes where like_id='" . $review_id . "' AND like_type = 'review_song'";
                \App\Models\Songs::GetRawData($del_review_like_qry);

                //delete review Report
                $del_review_report_qry = "Delete from tbl_review_report where r_report_review_id='" . $review_id . "'";
                \App\Models\Songs::GetRawData($del_review_report_qry);

                echo 'done';
            }
        } else {
            echo 'Error';
        }
    }

    ///Review_Actions
    public function Review_Actions()
    {
        if (!empty($_POST['review_ids'])) {
            if ($_POST['dropdown'] == 'Delete') // from button name="delete"
            {
                $checkbox = $_POST['review_ids']; //from name="checkbox[]"
                $countCheck = count($_POST['review_ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $review_id     = base64_decode($checkbox[$i]);
                    $notification_qry = "select review_user_id,review_id from tbl_reviews where review_id='" . $review_id . "'";
                    $notification_arr = \App\Models\Songs::GetRawDataAdmin($notification_qry);
                    $review_user_id   = $notification_arr['review_user_id'];
                    $review_id      = $notification_arr['review_id'];


                    $song_notification =
                        "select s.song_title, s.song_seo, a.artist_seo  
						   from  tbl_reviews r, tbl_songs s, tbl_artists a  
						   where r.review_id = $review_id 
						   AND r.song_id = s.id
						   AND r.artist_id = a.id";

                    $song_result_notification = \App\Models\Songs::GetRawDataAdmin($song_notification);



                    $mesg = "Moderator has removed your review on <a class=\"text_blck\" href=\"" . SERVER_ROOTPATH . $song_result_notification['song_seo'] . "-reviews-" . $song_result_notification['artist_seo'] . ".html\"><strong>" . wordwrap(stripslashes($song_result_notification['song_title']), 100, " ", true) . "</strong></a>.";





                    $insert_notification_qry = "insert into tbl_likes set like_type='delete_review_song',description='$mesg',read_status='1',like_id='$review_id', like_receive_user='$review_user_id', date='" . date("Y-m-d") . "'";
                    \App\Models\Songs::GetRawData($insert_notification_qry);




                    $del_review_qry = "Delete from tbl_reviews where review_id='" . $review_id . "'";
                    $result = \App\Models\Songs::GetRawData($del_review_qry);

                    //delete review like
                    $del_review_like_qry = "Delete from tbl_review_likes where review_id_like='" . $review_id . "'";
                    \App\Models\Songs::GetRawData($del_review_like_qry);

                    //delete review Report
                    $del_review_report_qry = "Delete from tbl_review_report where r_report_review_id='" . $review_id . "'";
                    \App\Models\Songs::GetRawData($del_review_report_qry);

                    $select_comment_qry = "select comment_id from tbl_comments where comment_review_id='" . $review_id . "'";
                    $comment_arr = \App\Models\Songs::GetRawData($select_comment_qry);
                    if ($comment_arr) {
                        foreach ($comment_arr as $val) {
                            $val = (array)$val;
                            $comment_id = $val['comment_id'];

                            //delete comment like
                            $del_com_like_qry = "Delete from tbl_comments_likes where comment_like_comment_id='" . $comment_id . "'";
                            \App\Models\Songs::GetRawData($del_com_like_qry);

                            //delete comment Report
                            $del_com_report_qry = "Delete from tbl_comment_report where c_report_comment_id='" . $comment_id . "'";
                            \App\Models\Songs::GetRawData($del_com_report_qry);

                            //delete comment
                            $del_comment_qry = "Delete from tbl_comments where comment_id='" . $comment_id . "'";
                            \App\Models\Songs::GetRawData($del_comment_qry);
                        }
                    }

                    //delete Notification
                    $del_notification_qry = "Delete from tbl_notifications where common_notification_id='" . $review_id . "' and type='Review Like'";
                    \App\Models\Songs::GetRawData($del_notification_qry);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("Deletion Successfully Done.");
                    $url = "admin/reviews_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/reviews_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'Active') // from button name="delete"
            {
                $checkbox = $_POST['review_ids']; //from name="checkbox[]"
                $countCheck = count($_POST['review_ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry = "select status from tbl_reviews where review_id='" . $del_id . "'";

                    $resul = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status = $resul['status'];
                    if ($status == 0) {
                        $status = 1;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_reviews set status=$status where review_id='" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawData($sql);
                }
                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/reviews_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/reviews_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }

            if ($_POST['dropdown'] == 'Inactive') // from button name="delete"
            {
                $checkbox = $_POST['review_ids']; // from name="checkbox[]"
                $countCheck = count($_POST['review_ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry     = "select status from tbl_reviews where review_id='" . $del_id . "'";

                    $resul   = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status  = $resul['status'];
                    if ($status == 1) {
                        $status = 0;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_reviews set status=$status where review_id='" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawData($sql);
                }


                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/reviews_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/reviews_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }
        } else {

            $errormsg = base64_encode('First select a record to perform some action');
            $url = "admin/ads_list?msg=$errormsg&case=2";
            return redirect($url);
        }
    }

    ///Set_Review_Popular_Or_Unpopular
    public function Set_Review_Popular_Or_Unpopular()
    {
        if (!empty($_POST['reviewid'])) {
            $review_id = base64_decode($_POST['reviewid']);
            $count_qry = "select count(review_id) as check_review from tbl_reviews where review_id='" . $review_id . "' ";
            $count_arr = \App\Models\Songs::GetRawDataAdmin($count_qry);
            $check_review = $count_arr['check_review'];

            if ($check_review == "" || $check_review == 0) {
                echo 'Error';
            } else {
                $set_qry  = "select is_popular from tbl_reviews where review_id='" . $review_id . "' ";
                $set_arr  = \App\Models\Songs::GetRawDataAdmin($set_qry);
                $is_popular = $set_arr['is_popular'];

                if ($is_popular == 0) {
                    $set_status = 1;
                } else {
                    $set_status = 0;
                }

                $del_qry = "update tbl_reviews set is_popular='" . $set_status . "' where review_id='" . $review_id . "'";
                \App\Models\Songs::GetRawData($del_qry);
                echo 'done';
            }
        } else {
            echo 'Error';
        }
    }

    ///Featured_Review_Process
    public function Featured_Review_Process()
    {
        if (!empty($_POST['reviewid'])) {
            $review_id = base64_decode($_POST['reviewid']);
            $count_qry = "select count(review_id) as check_review from tbl_reviews where review_id='" . $review_id . "' ";
            $count_arr = \App\Models\Songs::GetRawDataAdmin($count_qry);
            $check_review = $count_arr['check_review'];

            if ($check_review == "" || $check_review == 0) {
                echo 'Error';
            } else {
                $set_qry     = "select is_featured from tbl_reviews where review_id='" . $review_id . "' ";
                $set_arr     = \App\Models\Songs::GetRawDataAdmin($set_qry);
                $is_featured = $set_arr['is_featured'];


                $count_feture_qry         = "select count(review_id) as feature_counter from tbl_reviews where review_id='" . $review_id . "' and is_featured='Yes'";
                $count_feture_arr         = \App\Models\Songs::GetRawDataAdmin($count_feture_qry);
                $feature_counter          = $count_feture_arr['feature_counter'];
                if ($feature_counter > 0 && $is_featured == 'No') {
                    echo 'Exist';
                } else {
                    if ($is_featured == 'No') {
                        $set_status = 'Yes';
                    } else {
                        $set_status = 'No';
                    }

                    $del_qry = "update tbl_reviews set is_featured='" . $set_status . "' where review_id='" . $review_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);
                    echo 'done';
                }
            }
        } else {
            echo 'Error';
        }
    }

    ///Review_Likes
    public function Review_Likes()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;
        $data['key'] = null;


        ///key
        if (isset($_GET['key'])) {
            $data['key'] = $_GET['key'];
        }

        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///common  lines
        $data['currentFile'] = 'review_likes';
        $data['targetpage'] = 'review_likes';
        $data = top_file_data($data);
        $data['title'] = GetTitle();
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // die;
        return view('admin.review_likes', $data);
    }


    ///Review_Report
    public function Review_Report()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;
        $data['key'] = null;


        ///key
        if (isset($_GET['key'])) {
            $data['key'] = $_GET['key'];
        }

        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///common  lines
        $data['currentFile'] = 'review_reports';
        $data['targetpage'] = 'review_reports';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.review_reports', $data);
    }

    ///Discussion_List
    public function Discussion_List()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;


        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///common  lines
        $data['currentFile'] = 'gcomments';
        $data['targetpage'] = 'gcomments';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.gcomments', $data);
    }

    ///Report_Checkbox_List
    public function Report_Checkbox_List()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;


        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///common  lines
        $data['currentFile'] = 'report_checkbox_list';
        $data['targetpage'] = 'report_checkbox_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.report_checkbox_list', $data);
    }


    ///Add_Report_Checkbox
    public function Add_Report_Checkbox()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;
        $data['edit_id'] = null;


        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///edit_id
        if (isset($_GET['edit_id'])) {
            $data['edit_id'] = $_GET['edit_id'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///common  lines
        $data['currentFile'] = 'add_report_checkbox';
        $data['targetpage'] = 'add_report_checkbox';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.add_report_checkbox', $data);
    }

    ///Report_Option_Process
    public function Report_Option_Process()
    {
        error_reporting(0);
        if (isset($_POST)) {
            $errorstr = "";
            $case = 1;
            $report_chk_box_name  = trim($_REQUEST['report_chk_box_name']);
            $update_id = $_REQUEST['update_id'];
            if ($report_chk_box_name == "") {
                $errorstr .= "Please Enter Report Option Label\n";
                $case = 0;
            } else {
                if ($update_id != '') {
                    $chk_cat_qry = "select count(report_chk_box_id) as chk_report from tbl_reports_checkbox where report_chk_box_name=\"" . $report_chk_box_name . "\" 
			and report_chk_box_id!='" . $update_id . "'";
                } else {
                    $chk_cat_qry = "select count(report_chk_box_id) as chk_report from tbl_reports_checkbox where report_chk_box_name=\"" . $report_chk_box_name . "\" ";
                }
                $chk_cat_arr = \App\Models\Songs::GetRawDataAdmin($chk_cat_qry);
                $chk_report = $chk_cat_arr['chk_report'];
                if ($chk_report > 0) {
                    $errorstr .= "This Report Option Label Already Exsist\n";
                    $case = 0;
                }
            }

            if ($case == 1) {
                if ($update_id != '') {

                    \App\Models\Songs::GetRawData("update tbl_reports_checkbox set report_chk_box_name ='" .  stripcslashes($report_chk_box_name) . "' where report_chk_box_id='" . $update_id . "'");
                } else {
                    \App\Models\Songs::GetRawData("insert into tbl_reports_checkbox set report_chk_box_name ='" .  stripcslashes($report_chk_box_name) . "'");
                }

                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Delete_Report_Option
    public function Delete_Report_Option()
    {
        if (!empty($_POST['del_id'])) {
            $select_qry = "select report_chk_box_id from tbl_reports_checkbox where report_chk_box_id='" . $_POST['del_id'] . "' ";
            $select_arr = \App\Models\Songs::GetRawDataAdmin($select_qry);
            $report_chk_box_id     = $select_arr['report_chk_box_id'];
            if ($report_chk_box_id == "") {
                echo 'Error';
            } else {
                $del_qry = "Delete from tbl_reports_checkbox where report_chk_box_id='" . $report_chk_box_id . "'";
                \App\Models\Songs::GetRawData($del_qry);

                echo 'done';
            }
        } else {
            echo 'Error';
        }
    }

    ///Edit_Discussion
    public function Edit_Discussion()
    {
        $data = array();

        ///edit_id
        if (isset($_GET['edit_id'])) {
            $data['edit_id'] = $_GET['edit_id'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///common  lines
        $data['currentFile'] = 'edit_discussion';
        $data['targetpage'] = 'edit_discussion';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.edit_discussion', $data);
    }

    ///Edit_Discussion_Process
    public function Edit_Discussion_Process()
    {
        if (isset($_POST)) {
            extract($_POST);
            $errorstr = "";
            $case = 1;
            if ($update_id == "") {
                $errorstr .= "Please Select Valid discussion for Edit\n";
                $case = 0;
            } elseif ($update_id != "") {
                $chk_discussion_qry = "select comment_id as chk_discussion_id, comment_user_id  from tbl_comments where comment_id='" . $update_id . "' ";
                $chk_discussion_arr = \App\Models\Songs::GetRawDataAdmin($chk_discussion_qry);

                $chk_discussion_id  = $chk_discussion_arr['chk_discussion_id'];
                $gcomment_user_id   = $chk_discussion_arr['comment_user_id'];
                // $gcomment_cat_id    = $chk_discussion_arr['gcomment_cat_id'];
                if ($chk_discussion_id == "") {
                    $errorstr .= "Please Select Valid discussion for Edit\n";
                    $case = 0;
                } else {
                    if ($gcomment_detail == "") {
                        $errorstr .= "Please Enter Discussion Details\n";
                        $case = 0;
                    }
                }
            }


            if ($case == 1) {
                \App\Models\Songs::GetRawData("Update tbl_comments set comment_details ='" .  $gcomment_detail  . "' where  comment_id='" . $update_id . "' ");

                //Insert Notification
                $insert_notification_qry = "INSERT INTO tbl_notifications set 
		notification_sent_user_id='" . session()->get('reviewsite_cpadmin_id') . "', notification_receive_user_id='" . $gcomment_user_id . "',type='Moderator Edit Discussion', read_status='unread', status='1', date_added='" . time() . "' ";
                \App\Models\Songs::GetRawData($insert_notification_qry);

                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }


    ///Gcomments_Reports
    public function Gcomments_Reports()
    {
        $data = array();
        $data['key'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;


        ///key
        if (isset($_GET['key'])) {
            $data['key'] = $_GET['key'];
        }

        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///common  lines
        $data['currentFile'] = 'gcomments_reports';
        $data['targetpage'] = 'gcomments_reports';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.gcomments_reports', $data);
    }


    ///Delete_Review_Comment
    public function Delete_Review_Comment()
    {
        if (!empty($_POST['del_id'])) {
            $select_qry = "select comment_id from tbl_comments where comment_id='" . $_POST['del_id'] . "' ";
            $select_arr = \App\Models\Songs::GetRawDataAdmin($select_qry);
            $comment_id     = $select_arr['comment_id'];
            if ($comment_id == "") {
                echo 'Error';
            } else {
                $del_qry = "Delete from tbl_comments where comment_id='" . $comment_id . "'";
                \App\Models\Songs::GetRawData($del_qry);

                echo 'done';
            }
        } else {
            echo 'Error';
        }
    }

    ///Review_Comment_Actions
    public function Review_Comment_Actions()
    {
      
        if (!empty($_POST['gcomment_ids'])) {
            if ($_POST['dropdown'] == 'Delete') // from button name="delete"
            {
                $checkbox = $_POST['gcomment_ids']; //from name="checkbox[]"
                $countCheck = count($_POST['gcomment_ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id    = base64_decode($checkbox[$i]);
                    // $del_report = "DELETE from tbl_comment_report where c_report_comment_id = '" . $del_id . "' ";
                    // \App\Models\Songs::GetRawData($del_report);

                    // $del_like = "DELETE from tbl_comments_likes where comment_like_comment_id = '" . $del_id . "' ";
                    // \App\Models\Songs::GetRawData($del_like);

                    $del_comment = "DELETE from tbl_comments where comment_id = '" . $del_id . "' ";
                    $result = \App\Models\Songs::GetRawData($del_comment);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("Deletion Successfully Done.");
                    $url = "admin/gcomments?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/gcomments?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }
        } else {

            $errormsg = base64_encode('First select a record to perform some action');
            $url = "admin/gcomments?msg=$errormsg&case=2";
            return redirect($url);
        }
    }

    ///Review_Details
    public function Review_Details()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;
        $data['key'] = null;


        ///key
        if (isset($_GET['key'])) {
            $data['key'] = $_GET['key'];
        }

        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///common  lines
        $data['currentFile'] = 'review_details';
        $data['targetpage'] = 'review_details';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.review_details', $data);

    }
}
