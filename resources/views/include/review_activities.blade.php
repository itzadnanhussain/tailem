<?php 


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
    <label class="likes" style="font-weight:normal;"><img src="<?php echo SERVER_ROOTPATH; ?>images/review-book.png" style="margin-bottom:5px;"><span class="red-text"> <?php echo $review_list_arr_top['count_reviews']; ?> </span> Reviews</label>
    <label class="likes" style="font-weight:normal;"><img src="<?php echo SERVER_ROOTPATH; ?>images/icon_post.png" style="margin-top:-9px;"><span class="red-text"> <?php echo $comment_list_arr['count_discussion']; ?> </span> Posts</label>
<?php
} elseif ($mobile_view == 1) { ?>
    <label class="likes" style="margin-right:5px; font-weight:normal;"><i class="fa fa-heart-o heart_size"></i><span class="red-text"> <?php echo $sum_likes; ?> </span> <?php if ($sum_likes <= 1) {
                                                                                                                                                                                echo "Like";
                                                                                                                                                                            } else {
                                                                                                                                                                                echo "Likes";
                                                                                                                                                                            } ?></label>
    <label class="likes" style="margin-right:5px; font-weight:normal;"><img src="<?php echo SERVER_ROOTPATH; ?>images/review-book.png" style="margin-bottom:5px;"><span class="red-text"> <?php echo $review_list_arr_top['count_reviews']; ?> </span> Reviews</label>
    <label class="likes" style="margin-right:5px; font-weight:normal;"><img src="<?php echo SERVER_ROOTPATH; ?>images/icon_post.png" style="margin-top:-8px;"><span class="red-text"> <?php echo $comment_list_arr['count_discussion']; ?> </span> Posts</label>


<?php } ?>