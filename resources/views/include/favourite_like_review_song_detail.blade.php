<?php

if ($user_id == "") {
    echo "Please sign in first";
    exit;
}



$qry = "select review_user_id from tbl_reviews where review_id = $prod_id";

$info_arr    =    \App\Models\Songs::GetRawData($qry);
$info_arr = (array)$info_arr[0];

if ($info_arr['review_user_id'] == $user_id) {
    echo "You cannot like your own review";
    exit;
}


$receiver = $info_arr['review_user_id'];
$qry =  "select id from tbl_likes where like_type = 'review_song' AND like_id = '$prod_id'";
$counter_main = array();
$counter_main = \App\Models\Songs::GetRawData($qry);
if ($counter_main) {
    $counter_main = count($counter_main);
} else {
    $counter_main = 0;
}

$qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND like_type = 'review_song' AND like_id = '$prod_id'";
$counter = array();
$counter = \App\Models\Songs::GetRawData($qry);
if ($counter) {
    $counter = count($counter);
} else {
    $counter = 0;
}
if ($counter == 0) {
    $date = date("Y-m-d");
    $user_id  =  $user_id;
    $display_date  = date("Y-m-d H:i:s");
    $sql = "INSERT INTO tbl_likes (like_id, like_type, date, like_from_user_id,like_receive_user, display_date) VALUES ($prod_id, 'review_song', '$date', $user_id,$receiver, '$display_date')";
    $rsd = \App\Models\Songs::GetRawData($sql);

    $qry = "Update tbl_reviews set  like_count = like_count + 1 where review_id = $prod_id";
    \App\Models\Songs::GetRawData($qry);
?>
    <a href="javascript:;" onClick="add_in_favourite_list_review_song_detail('<?php echo $prod_id; ?>','<?php echo $user_name; ?>','<?php echo $r_fav; ?>')" class="like"><i class="fa fa-heart" style="font-size:20px; color:#D73B3B;"></i></a><a href="process/detail_review?user=<?php echo urlencode($user_name); ?>&review_id=<?php echo $prod_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable" style="color:#444;"> <?php echo $counter_main + 1; ?><?php if (($counter_main + 1) < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a>
<?php
} else {
    $qry = "Delete from tbl_likes where like_from_user_id = '" . $user_id . "' AND like_id = $prod_id AND like_type = 'review_song'";
    \App\Models\Songs::GetRawData($qry);
    $qry = "Update tbl_reviews set  like_count = like_count - 1 where review_id = $prod_id";
    \App\Models\Songs::GetRawData($qry);
?>
    <a href="javascript:;" onClick="add_in_favourite_list_review_song_detail('<?php echo $prod_id; ?>','<?php echo $user_name; ?>','<?php echo $r_fav; ?>')" class="text_grey"><i class="fa fa-heart-o" style="font-size:20px; color:#D73B3B;"></i></a><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_review?user=<?php echo urlencode($user_name); ?>&review_id=<?php echo $prod_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable" style="color:#444;"> <?php echo $counter_main - 1; ?><?php if (($counter_main - 1) < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a>
<?php
}
?>