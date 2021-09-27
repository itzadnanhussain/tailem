<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(isset($_REQUEST)) 
{	
	$song_id   = $_REQUEST['song_id'];
	$artist_id = $_REQUEST['artist_id'];
	
	$del_qry= "Delete from tbl_songs_artist where song_id='".$song_id."' and artist_id='".$artist_id."'";
	$db->query($del_qry);
			
	echo 'done';
}
else
{
	echo 'Error';
}
?>