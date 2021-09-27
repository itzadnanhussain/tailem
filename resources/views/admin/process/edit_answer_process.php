<?php
error_reporting(0);
include("../includes/top.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$answer_details  = trim($_REQUEST['answer_details']);
	$update_id        = trim($_REQUEST['update_id']);
	if($update_id == "")
	{
		$errorstr .="Please Select Valid answer for Edit\n";
		$case = 0;
	}
	elseif($update_id!="")
	{
		$chk_answer_qry="select ans_id as chk_ans_id, ans_user_id_receive from tbl_answers where 
		ans_id='".$update_id."' ";
		$chk_answer_arr = $db->get_row($chk_answer_qry, ARRAY_A);
		$chk_ans_id  = $chk_answer_arr['chk_ans_id'];	
		$ans_user_id_receive = $chk_answer_arr['ans_user_id_receive'];	
		
		if($chk_ans_id=="")
		{
			$errorstr .="Please Select valid answer for Edit\n";
			$case = 0;
		}
		else
		{	if($answer_details == "")
			{
				$errorstr .="Please Enter answer Details\n";
				$case = 0;
			}
		}
	}
	
		
	if($case==1)
	{
		$update_query = $db->query("Update tbl_answers set answer_details ='".mysqli_escape_string($db->dbh, stripslashes($answer_details))."' where ans_id='".$update_id."' ");
		
		//Insert Notification
		$insert_notification_qry="INSERT INTO tbl_notifications set 
		notification_sent_user_id='".$_SESSION['reviewsite_cpadmin_id']."', notification_receive_user_id='".$ans_user_id_receive."', common_notification_id='".$chk_ans_id."' ,type='Moderator Edit Answer', read_status='unread', status='1', date_added='".time()."' ";
		$db->query($insert_notification_qry);
		
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
