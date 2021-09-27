<?php 
include("../includes/top.php");
include("../common/security.php"); 
$path			= '../../site_upload/artist_images/';
$song_id = base64_encode($song_id);
if(!empty($_POST['ids']))
{
 	if($_POST['dropdown']=='Delete') // from button name="delete"
	{
	 	$checkbox = $_POST['ids']; //from name="checkbox[]"
	 	$countCheck = count($_POST['ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_id    = base64_decode($checkbox[$i]);
			
			 $sql = "Delete from tbl_songs_artist where id='".$del_id."'";
			 $result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($mysqli));
			 
		}
		
	    if($result)
		{		
			 $okmsg = base64_encode("Deletion Successfully Done.");
			 header('Location:'.SERVER_ADMIN_PATH."artist_list_song.php?song_id=$song_id&msg=$okmsg&case=1");
		}
		else
		{ 
			 echo "Error: ".mysqli_error($db->dbh);
		}
	}
	
}
else
{
	$errormsg = base64_encode('First select a record to perform some action');
	header('Location:'.SERVER_ADMIN_PATH."artist_list_song.php?song_id=$song_id&msg=$errormsg&case=2");
}
?>