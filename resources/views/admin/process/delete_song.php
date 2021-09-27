<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$del_qry="Delete from tbl_songs_artist_album where song_id='".$del_id."'";
	$db->query($del_qry);
	
	$del_qry="Delete from tbl_reviews where song_id='".$del_id."'";
	$db->query($del_qry);
		
	$sql = "DELETE from tbl_songs where id = '".$del_id."'";
	$db->query($sql);
	//$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($mysqli));
	echo 'done';
}
else
{
	echo 'Error';
}


/* if(!empty($_POST['delete_song_id']))
{
	
	$song_id   = $_POST['delete_song_id']
	$artist_id = $_POST['artist_id']
	$album_id  = $_POST['album_id']

	echo "update `tbl_songs_artist_album` SET `deletion`= 1 where `song_id`= $song_id  and `artist_id`= $artist_id and `album_id`= $album_id"; exit;
	$del_qry="update `tbl_songs_artist_album` SET `deletion`= 1 where `song_id`= $song_id  and `artist_id`= $artist_id and `album_id`= $album_id";
	$db->query($del_qry);
	echo 'done';
}
else
{
	echo 'Error';
} */



?>