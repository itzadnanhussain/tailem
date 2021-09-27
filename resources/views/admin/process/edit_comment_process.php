<?php
error_reporting(0);
include("../includes/top.php");
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$comment_details  = trim($_REQUEST['comment_details']);
	$update_id        = trim($_REQUEST['update_id']);
	if($update_id == "")
	{
		$errorstr .="Please Select Valid comment for Edit\n";
		$case = 0;
	}
	elseif($update_id!="")
	{	//comment_cat_id
		$chk_discussion_qry="select comment_id as chk_comment_id, comment_user_id from tbl_comments where comment_id='".$update_id."' ";
		$chk_discussion_arr = $db->get_row($chk_discussion_qry, ARRAY_A);
		$chk_comment_id  = $chk_discussion_arr['chk_comment_id'];	
		$comment_user_id = $chk_discussion_arr['comment_user_id'];	
		//$comment_cat_id  = $chk_discussion_arr['comment_cat_id'];	
		if($chk_comment_id=="")
		{
			$errorstr .="Please Select valid comment for Edit\n";
			$case = 0;
		}
		else
		{	if($comment_details == "")
			{
				$errorstr .="Please Enter comment Details\n";
				$case = 0;
			}
		}
	}	
	if($case==1)
	{
		$update_query = $db->query("Update tbl_comments set comment_details ='".mysqli_escape_string($db->dbh, stripslashes($comment_details))."' where comment_id='".$update_id."' ");
		//Insert Notification
		$insert_notification_qry="INSERT INTO tbl_notifications set 
		notification_sent_user_id='".$_SESSION['reviewsite_cpadmin_id']."', notification_receive_user_id='".$comment_user_id."', common_notification_id='".$chk_comment_id."' ,type='Moderator Edit Comment', read_status='unread', status='1', date_added='".time()."' ";
		$db->query($insert_notification_qry);
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}?>