<?php
include("includes/top.php");

$likeString = '%' . trim($_GET['val']) . '%';
/*echo $sql = "select id, artist_name from tbl_artists where artist_status = 1 AND artist_name  LIKE '$likeString' order by rand()";
$rsd = mysql_query($sql);*/


$artist_list = "select id, artist_name from tbl_artists where artist_status = 1 AND artist_name  LIKE '$likeString' order by rand() limit 10";
$artist_list_arr	=	$db->get_results($artist_list,ARRAY_A);

//echo mysql_num_rows($rsd);
$artist_array = array();
foreach ($artist_list_arr as $row ) {
	 $artist_name = $row['artist_name'];
	array_push($artist_array, $artist_name);	
}

//print_r($artist_array);
$json = json_encode($artist_array);
echo $json;          
?>