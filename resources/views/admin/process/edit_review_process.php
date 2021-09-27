<?php
error_reporting(0);
include("../includes/top.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$review_rating    = trim($_REQUEST['review_rating']);
	$review_title     = trim($_REQUEST['review_title']);
	$review_detail    = trim($_REQUEST['review_detail']);
	$review_user_id   = trim($_REQUEST['review_user_id']);
	$level1_cat_id    = trim($_REQUEST['level1_cat_id']);
	$level2_cat_id    = trim($_REQUEST['level2_cat_id']);
	$level3_cat_id    = trim($_REQUEST['level3_cat_id']);
	$level4_cat_id    = trim($_REQUEST['level4_cat_id']);
	$level5_cat_id    = trim($_REQUEST['level5_cat_id']);
	$update_id        = trim($_REQUEST['update_id']);
	if($review_rating == "")
	{
		$errorstr .="Please Select Review Rating\n";
		$case = 0;
	}
	elseif($review_rating<1 || $review_rating>10)
	{
		$errorstr .="Please Select Valid Review Rating\n";
		$case = 0;
	}
	
	if($review_title == "")
	{
		$errorstr .="Please Enter Review Title\n";
		$case = 0;
	}
	
	if($review_detail == "")
	{
		$errorstr .="Please Enter Review Details\n";
		$case = 0;
	}
	
	if($review_user_id == "")
	{
		$errorstr .="Please Select User\n";
		$case = 0;
	}
	else
	{
		$chk_user_qry = "select count(user_id) as chk_user from tbl_users where user_id=\"".$review_user_id."\" ";
		$chk_user_arr = $db->get_row($chk_user_qry,ARRAY_A);
		$chk_user = $chk_user_arr['chk_user'];
		if($chk_user== "" || $chk_user<1)
		{
			$errorstr .= "This User Name does't Exist\n";
			$case = 0;
		}
	}
	
		
	
	if($case==1)
	{
			//review_user_id ='".mysqli_escape_string($db->dbh, stripslashes($review_user_id))."'	
			$update_query = $db->query("Update tbl_reviews set review_title ='".mysqli_escape_string($db->dbh, stripslashes($review_title))."', review_detail ='".mysqli_escape_string($db->dbh, stripslashes($review_detail))."', review_rating ='".mysqli_escape_string($db->dbh, stripslashes($review_rating))."' where review_id='".$update_id."' ");

		//Insert Notification
		$insert_notification_qry="INSERT INTO tbl_notifications set 
		notification_sent_user_id='".$_SESSION['reviewsite_cpadmin_id']."', notification_receive_user_id='".$review_user_id."' ,type='Moderator Edit Review',read_status='unread', status='1', date_added='".time()."' ";
		$db->query($insert_notification_qry);
		
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
