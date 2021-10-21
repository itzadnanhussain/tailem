<?php


if ($user_id == "") {
	echo "Please sign in first";
	exit;
}




$query_list =  "select user_id_playlist from tbl_user_playlist where id = '$prod_id'";

$row_playlistinfo	=	\App\Models\Songs::GetRawDataAdmin($query_list);
if ($row_playlistinfo['user_id_playlist'] == $user_id) {
	echo "aa";
	exit;
}

$qry =  "select id from tbl_likes where like_type = 'playlist' AND like_id = '$prod_id'";
$counter_main = array();
$counter_main = \App\Models\Songs::GetRawData($qry);
if ($counter_main) {
	$counter_main = count($counter_main);
} else {
	$counter_main = 0;
}

$qry =   "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND like_type = 'playlist' AND like_id = '$prod_id'";
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
	$sql = "INSERT INTO tbl_likes (like_id, like_type, date, like_from_user_id, like_receive_user) VALUES ($prod_id, 'playlist', '$date', $user_id, '" . $row_playlistinfo['user_id_playlist'] . "')";
	$rsd = \App\Models\Songs::GetRawData($sql);

?>
	<a href="javascript:;" onClick="add_in_playlist('<?php echo $prod_id; ?>')"><i class="fa fa-heart" style="font-size:24px; color:#D73B3B;"></i></a><a href="<?php echo SERVER_ROOTPATH; ?>detail_playlist?artist=<?php echo $prod_id; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="link-disable" style="color:#444;"> <?php echo $counter_main + 1; ?><?php if (($counter_main + 1) < 2) {
																																																																																																	echo " Like";
																																																																																																} else {
																																																																																																	echo " Likes";
																																																																																																} ?></a>


<?php } else {

	\App\Models\Songs::GetRawData("Delete from tbl_likes where like_from_user_id = '" . $user_id . "' AND like_id = $prod_id AND like_type = 'playlist'");
?>

	<a href="javascript:;" onClick="add_in_playlist('<?php echo $prod_id; ?>')"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a><a href="<?php echo SERVER_ROOTPATH; ?>detail_playlist?artist=<?php echo $prod_id; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="link-disable" style="color:#444;"> <?php echo $counter_main - 1; ?><?php if (($counter_main - 1) < 2) {
																																																																																																		echo " Like";
																																																																																																	} else {
																																																																																																		echo " Likes";
																																																																																																	} ?></a>
<?php
} ?>


