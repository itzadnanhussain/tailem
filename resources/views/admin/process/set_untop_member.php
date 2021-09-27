<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['userid']))
{
	$select_qry = "select user_id,is_top_member from tbl_users where user_id='".base64_decode($_POST['userid'])."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$user_id    = $select_arr['user_id'];
	$is_top_member   = $select_arr['is_top_member'];
	
	
	if($user_id=="")
	{
		echo 'Error';
	}
	else
	{
		if($is_top_member==0)
		{
			$set_status = 1;
		}
		else
		{
			$set_status = 0;
		}
		
		$del_qry="update tbl_users set is_top_member='".$set_status."' where user_id='".$user_id."'";
		$db->query($del_qry);
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>