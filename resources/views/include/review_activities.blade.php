<?php

///
if (isset($user_seo) && ($user_seo != "")) {
    $select_img = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
    $result_image = $db->get_row($select_img, ARRAY_A);
    $user_name = $result_image['user_name'];
    $user_profile = $result_image['user_id'];
    $date_added_db = $result_image['date_added'];
    $USER_NAME = $user_name;
    $main_link = get_user_detail($USER_NAME) . "-profile-";
} else {
    //session set temporary
    $_SESSION[USER_SESSION_ARRAY]['USER_ID'] = session()->get('user_id');

    $_SESSION[USER_SESSION_ARRAY]['USER_NAME'] = session()->get('user_name');

    $main_link = '';
    $_SESSION[main_search]['search'] = 'test';
    $user_profile = $_SESSION[USER_SESSION_ARRAY]['USER_ID'];
    $USER_NAME = $_SESSION[USER_SESSION_ARRAY]['USER_NAME'];
}


///
$like_list_qry = "select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '" . $user_profile . "' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1";
$like_list_arr = \App\Models\Songs::GetRawData($like_list_qry);
$like_list_arr = (array)$like_list_arr[0];


///
$review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $user_profile . "' order by r.review_id desc limit 1";
$review_list_arr_top = \App\Models\Songs::GetRawData($review_list_qry);
$review_list_arr_top = (array)$review_list_arr_top[0];

///
$comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_user_id = '" . $user_profile . "' order by comment_id desc limit 1";
$comment_list_arr = \App\Models\Songs::GetRawData($comment_list_qry);
$comment_list_arr = (array)$comment_list_arr[0];


///
$counter_main_profile_like = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'profile' AND like_id = '$user_profile'");
if ($counter_main_profile_like) {
    $counter_main_profile_like = count($counter_main_profile_like);
} else {
    $counter_main_profile_like = 0;
}

///
$counter_main_playlist_like = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'playlist' AND like_receive_user = '$user_profile'");
if ($counter_main_playlist_like) {
    $counter_main_playlist_like = count($counter_main_playlist_like);
} else {
    $counter_main_playlist_like = 0;
}

$sum_likes = $like_list_arr['count_likes'] + $counter_main_profile_like + $counter_main_playlist_like;
if ($mobile_view == 0) {

?>
    <label class="likes" style="font-weight:normal;"><i class="fa fa-heart-o" style="font-size:20px;"></i><span class="red-text"> <?php echo $sum_likes; ?> </span> <?php if ($sum_likes <= 1) {
                                                                                                                                                                        echo "Like";
                                                                                                                                                                    } else {
                                                                                                                                                                        echo "Likes";
                                                                                                                                                                    } ?></label>
    <label class="likes" style="font-weight:normal;"><img src="<?php echo SERVER_ROOTPATH; ?>static/images/review-book.png" style="margin-bottom:5px;"><span class="red-text"> <?php echo $review_list_arr_top['count_reviews']; ?> </span> Reviews</label>
    <label class="likes" style="font-weight:normal;"><img src="<?php echo SERVER_ROOTPATH; ?>static/images/icon_post.png" style="margin-top:-9px;"><span class="red-text"> <?php echo $comment_list_arr['count_discussion']; ?> </span> Posts</label>
<?php
} elseif ($mobile_view == 1) { ?>
    <label class="likes" style="margin-right:5px; font-weight:normal;"><i class="fa fa-heart-o heart_size"></i><span class="red-text"> <?php echo $sum_likes; ?> </span> <?php if ($sum_likes <= 1) {
                                                                                                                                                                                echo "Like";
                                                                                                                                                                            } else {
                                                                                                                                                                                echo "Likes";
                                                                                                                                                                            } ?></label>
    <label class="likes" style="margin-right:5px; font-weight:normal;"><img src="<?php echo SERVER_ROOTPATH; ?>static/images/review-book.png" style="margin-bottom:5px;"><span class="red-text"> <?php echo $review_list_arr_top['count_reviews']; ?> </span> Reviews</label>
    <label class="likes" style="margin-right:5px; font-weight:normal;"><img src="<?php echo SERVER_ROOTPATH; ?>static/images/icon_post.png" style="margin-top:-8px;"><span class="red-text"> <?php echo $comment_list_arr['count_discussion']; ?> </span> Posts</label>


<?php } ?>