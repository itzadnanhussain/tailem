<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select video_id from tbl_videos where video_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$video_id     = $select_arr['video_id'];
	if($video_id=="")
	{
		echo 'Error';

	}
	else
	{
		$del_qry="Delete from tbl_videos where video_id='".$video_id."'";
		$db->query($del_qry);
		echo 'done';
	}
}
else

{

	echo 'Error';

}
?>