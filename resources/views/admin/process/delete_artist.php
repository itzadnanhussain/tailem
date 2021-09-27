<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select id from tbl_artists where id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$id     = $select_arr['id'];
	$path			= '../../site_upload/artist_images/';
	if($id=="")
	{
		echo 'Error';
	}
	else
	{
		
		$select_img ="select artist_img from tbl_artists where id='".$_POST['del_id']."' ";
		$result = $db->get_row($select_img, ARRAY_A);
		
		$old_image  = $result['artist_img'];
		if($old_image!="")
		{
			$imgfile =$path.$old_image;
			$thumbfile =$path.'thumb_'.$old_image;
			$thumbfile_small =$path.'small_thumb_'.$old_image;
			@unlink($imgfile);
			@unlink($thumbfile);
			@unlink($thumbfile_small);
		}
						
		$del_qry="Delete from tbl_artists where id='".$id."'";
		$db->query($del_qry);
		
		$del_qry="Delete from tbl_songs_artist_album where artist_id='".$id."'";
		$db->query($del_qry);
		
		$del_qry="Delete from tbl_songs_artist where artist_id='".$id."'";
		$db->query($del_qry);
		
		$del_qry="Delete from tbl_artist_album where album_artist_id='".$id."'";
		$db->query($del_qry);
		
		$del_qry="Delete from tbl_likes where like_id='".$id."' AND like_type = 'artist'";
		$db->query($del_qry);
		
		$del_qry="Delete from tbl_reviews where artist_id='".$id."'";
		$db->query($del_qry);
		
		$del_qry="Delete from tbl_comments where comment_artist_id='".$id."'";
		$db->query($del_qry);
		
		$del_qry="Delete from tbl_songs_artist where artist_id='".$id."'";
		$db->query($del_qry);
		
				
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>