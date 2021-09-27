<?php 
include("../includes/top.php");
include("../common/security.php"); 


if(!empty($_POST['del_id']))
{
	 $select_qry = "select id from tbl_artist_album where id='".$_POST['del_id']."' AND album_artist_id ='".base64_decode($_POST['artist_id'])."'";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$id     = $select_arr['id'];
	$path			= '../../site_upload/album_images/';
	if($id=="")
	{
		echo 'Error';
	}
	else
	{
		
		$select_img ="select album_picture from tbl_artist_album where id='".$_POST['del_id']."' ";
		$result = $db->get_row($select_img, ARRAY_A);
		
		$old_image  = $result['album_picture'];
		if($old_image!="")
		{
			$imgfile =$path.$old_image;
			$thumbfile =$path.'thumb_'.$old_image;
			$thumbfile_small =$path.'small_thumb_'.$old_image;
			@unlink($imgfile);
			@unlink($thumbfile);
			@unlink($thumbfile_small);
		}
						
		$del_qry="Delete from tbl_artist_album where id='".$id."'";
		$db->query($del_qry);
		
		$sql = "DELETE from tbl_songs_artist_album where album_id = '".$id."' ";
		$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($mysqli));
				
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>