<?php


if ($user_id == "") {
    echo "Please sign in first";
    exit;
}

// $prod_id	= $_REQUEST['prod_id'];
// $sr_no 		= $_REQUEST['sr_no'];
// $artist_seo = $_REQUEST['artist_seo'];


$qry = "select id from tbl_likes where like_type = 'artist' AND like_id = '$prod_id'";
$counter_main = array();
$counter_main = \App\Models\Songs::GetRawData($qry);
if ($counter_main) {
    $counter_main = count($counter_main);
} else {
    $counter_main = 0;
}

$qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND like_type = 'artist' AND like_id = '$prod_id'";
$counter = array();
$counter = \App\Models\Songs::GetRawData($qry);
if ($counter) {
    $counter = count($counter);
} else {
    $counter = 0;
}


if ($counter == 0) {
    $date = date("Y-m-d");
    $sql = "INSERT INTO tbl_likes (like_id, like_type, date, like_from_user_id) VALUES ($prod_id, 'artist', '$date', $user_id)";
    \App\Models\Songs::GetRawData($sql);
?>
    <a href="javascript:;" onClick="reviews_artist_popular_likes('<?php echo $prod_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>')" style="color:#fff;"><i class="fa fa-heart" style="font-size:24px; color:#D73B3B;"></i></a><label>&nbsp;<?php echo $counter_main + 1; ?></label>
    <!--<label><?php if (($counter_main + 1) < 2) {
                    echo " Like";
                } else {
                    echo " Likes";
                } ?> </label>--><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_5000" data-title="" class="link-disable" style="color:#fff;"><?php if (($counter_main + 1) < 2) {
                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                } ?></a>

<?php
} else {
    $qry = "Delete from tbl_likes where like_from_user_id = '" . $user_id . "' AND like_id = $prod_id AND like_type = 'artist'";
    $data = \App\Models\Songs::GetRawData($qry);
?>

    <a href="javascript:;" onClick="reviews_artist_popular_likes('<?php echo $prod_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>')" style="color:#fff;"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a><label>&nbsp;<?php echo $counter_main - 1; ?></label>
    <!--<label>&nbsp;<?php if (($counter_main - 1) < 2) {
                            echo " Like";
                        } else {
                            echo " Likes";
                        } ?></label>--><a href="<?php echo SERVER_ROOTPATH; ?>detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_5000" data-title="" class="link-disable" style="color:#fff;"><?php if (($counter_main - 1) < 2) {
                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                } ?></a>
<?php
}

?>