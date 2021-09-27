<?php 
include("../includes/top.php");
include("../common/security.php"); 
$path= '../../site_upload/user_images/';
if(!empty($_POST['del_id']))
{
	$select_qry = "select user_id from tbl_users where user_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$user_id    = $select_arr['user_id'];
	if($user_id=="")
	{
		echo 'Error';
	}
	else
	{
		$select_img = "select profile_image from tbl_users where user_id='".$user_id."'";
		$result = $db->get_row($select_img, ARRAY_A);
		if($result)
		{
				$old_image  = $result['profile_image'];
				$imgfile    = $path.$old_image;
				$thumbfile  =  $path.'thumb_'.$old_image;
				$thumbfile_small =$path.'small_thumb_'.$old_image;
				@unlink($imgfile);
				@unlink($thumbfile);
				@unlink($thumbfile_small);
				
				$del_qry="Delete from tbl_users where user_id='".$user_id."'";
				$db->query($del_qry);
				
				$del_qry="Delete from tbl_likes where like_from_user_id='".$user_id."'";
				$db->query($del_qry);
				
				$del_qry="Delete from tbl_reviews where review_user_id='".$user_id."'";
				$db->query($del_qry);
				
				$del_qry="Delete from tbl_review_report where r_report_user_id='".$user_id."'";
				$db->query($del_qry);
				
				$del_qry="Delete from tbl_comments where comment_user_id='".$user_id."'";
				$db->query($del_qry);
		}
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>