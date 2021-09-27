<?php
error_reporting(0);
include("../includes/top.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$question_details  = trim($_REQUEST['question_details']);
	$update_id        = trim($_REQUEST['update_id']);
	if($update_id == "")
	{
		$errorstr .="Please Select Valid question for Edit\n";
		$case = 0;
	}
	elseif($update_id!="")
	{
		$chk_question_qry="select question_id as chk_question_id, question_user_id, question_cat_id from tbl_questions 
		where question_id='".$update_id."' ";
		$chk_question_arr = $db->get_row($chk_question_qry, ARRAY_A);
		$chk_question_id  = $chk_question_arr['chk_question_id'];	
		$question_user_id = $chk_question_arr['question_user_id'];	
		$question_cat_id  = $chk_question_arr['question_cat_id'];	
		if($chk_question_id=="")
		{
			$errorstr .="Please Select valid question for Edit\n";
			$case = 0;
		}
		else
		{	if($question_details == "")
			{
				$errorstr .="Please Enter question Details\n";
				$case = 0;
			}
		}
	}
	
		
	if($case==1)
	{
		$update_query = $db->query("Update tbl_questions set question_details ='".mysqli_escape_string($db->dbh, stripslashes($question_details))."' where question_id='".$update_id."' ");
		
		//Insert Notification
		$insert_notification_qry="INSERT INTO tbl_notifications set 
		notification_sent_user_id='".$_SESSION['reviewsite_cpadmin_id']."', notification_receive_user_id='".$question_user_id."', common_notification_id='".$question_cat_id."' ,type='Moderator Edit Question', read_status='unread', status='1', date_added='".time()."' ";
		$db->query($insert_notification_qry);
		
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
