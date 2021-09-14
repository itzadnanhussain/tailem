<?php

if ($user_id == "") {
    echo "Please sign in first";
    exit;
}



$qry = "select id from tbl_likes where like_type = 'artist' AND like_id = '$prod_id'";
$counter_main = array();
$counter_main = \App\Models\Songs::GetRawData($qry);
if ($counter_main) {
    $counter_main = count($counter_main);
} else {
    $counter_main = 0;
}

$qry1 = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND like_type = 'artist' AND like_id = '$prod_id'";
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
    $sql = "INSERT INTO tbl_likes (like_id, like_type, date, like_from_user_id) VALUES ($prod_id, 'artist', '$date', $user_id)";

    $rsd = \App\Models\Songs::GetRawData($sql);
?>
    <a href="javascript:;" onClick="add_in_favourite_list_rev('<?php echo $prod_id; ?>','<?php echo $artist_seo; ?>')" class="text_grey"><i class="fa fa-heart heart_size heart_color"></i> </a><span class="text_red"><?php echo $counter_main + 1; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if (($counter_main + 1) < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a>

<?php } else {
    $qry3 = "Delete from tbl_likes where like_from_user_id = '" . $user_id . "' AND like_id = $prod_id AND like_type = 'artist'";
    \App\Models\Songs::GetRawData($qry3);
?>
    <a href="javascript:;" onClick="add_in_favourite_list_rev('<?php echo $prod_id; ?>','<?php echo $artist_seo; ?>')"><i class="fa fa-heart-o heart_size heart_color"></i> </a><span class="text_red"><?php echo $counter_main - 1; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if (($counter_main - 1) < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a>

<?php
}
?>