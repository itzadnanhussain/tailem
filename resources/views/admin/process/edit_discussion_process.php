<?php
error_reporting(0);
include("../includes/top.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$gcomment_detail  = trim($_REQUEST['gcomment_detail']);
	$update_id        = trim($_REQUEST['update_id']);
	if($update_id == "")
	{
		$errorstr .="Please Select Valid discussion for Edit\n";
		$case = 0;
	}
	elseif($update_id!="")
	{
		$chk_discussion_qry="select gcomment_id as chk_discussion_id, gcomment_user_id, gcomment_cat_id from tbl_general_comments where gcomment_id='".$update_id."' ";
		$chk_discussion_arr = $db->get_row($chk_discussion_qry, ARRAY_A);
		$chk_discussion_id  = $chk_discussion_arr['chk_discussion_id'];	
		$gcomment_user_id   = $chk_discussion_arr['gcomment_user_id'];	
		$gcomment_cat_id    = $chk_discussion_arr['gcomment_cat_id'];	
		if($chk_discussion_id=="")
		{
			$errorstr .="Please Select Valid discussion for Edit\n";
			$case = 0;
		}
		else
		{	if($gcomment_detail == "")
			{
				$errorstr .="Please Enter Discussion Details\n";
				$case = 0;
			}
		}
	}
	
		
	if($case==1)
	{
		$update_query = $db->query("Update tbl_general_comments set gcomment_detail ='".mysqli_escape_string($db->dbh, stripslashes($gcomment_detail))."' where gcomment_id='".$update_id."' ");
		
		//Insert Notification
		$insert_notification_qry="INSERT INTO tbl_notifications set 
		notification_sent_user_id='".$_SESSION['reviewsite_cpadmin_id']."', notification_receive_user_id='".$gcomment_user_id."', common_notification_id='".$gcomment_cat_id."' ,type='Moderator Edit Discussion', read_status='unread', status='1', date_added='".time()."' ";
		$db->query($insert_notification_qry);
		
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
