<?php 
 
 



if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] != "") {
    $select_notification_count = "select u.user_name,l.like_type,u.profile_image, l.like_id  from  tbl_likes l, tbl_users u  where l.like_from_user_id = u.user_id  AND (l.like_type = 'review_song' OR l.like_type = 'profile' OR l.like_type = 'playlist' OR l.like_type = 'delete_review_song' OR l.like_type = 'admin_review') AND l.like_receive_user = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND l.read_status = 1";
    $result_notification_count = count($db->get_results($select_notification_count, ARRAY_A));
}


 

?>
<!DOCTYPE html>
<html lang="en">

<head>
      
    <?php include("top_script_files.php"); ?>

    <?php
    $setting_qry = "select * from tbl_setting where setting_id='1'";
    $setting_arr    =    $db->get_row($setting_qry, ARRAY_A);
    echo $analaytic    =    $setting_arr['analaytic'];

    ?>
</head>
<!-- <div id="loading">
<img id="loading-image" src="assets/common/ajax-loader.gif" alt="Loading..."  style="left: 39.7%;"/>
</div> -->

<body>

    <?php //$user_profile = $_SESSION[USER_SESSION_ARRAY]['USER_ID']; 
    ?>
    <!-- Header start -->
    @include('template.nav');
    <!-- ./Header end -->
    <?php
    
    // latest comment date
    if ($user_profile != "") {
        $comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_user_id = '" . $user_profile . "' order by comment_id desc limit 1";
        $comment_list_arr    =    $db->get_row($comment_list_qry, ARRAY_A);

        // recent like pick query
        $like_list_qry = "select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '" . $user_profile . "' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1";
        $like_list_arr    =    $db->get_row($like_list_qry, ARRAY_A);

        // recent review pick query
        $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $user_profile . "' order by r.review_id desc limit 1";
        $review_list_arr_top    =    $db->get_row($review_list_qry, ARRAY_A);
    }
    ?>
   
    