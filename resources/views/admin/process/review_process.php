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
	$cat_id           = trim($_REQUEST['cat_id']);
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
	if($cat_id == "")
	{
		$errorstr .= "Please Select Level5 Category\n";
		$case = 0;
	}
	else
	{
		$chk_cat_qry ="select count(cat_id) as chk_cat from tbl_categories where cat_id=\"".$cat_id."\" and level='5'";
		$chk_cat_arr = $db->get_row($chk_cat_qry,ARRAY_A);
		$chk_cat     = $chk_cat_arr['chk_cat'];
		if($chk_cat=="" || $chk_cat<1)
		{
			$errorstr .= "This category doest't Exist\n";
			$case = 0;
		}
	}
		
	
	if($case==1)
	{
		if($update_id != '')
		{
		
			/*$db->query("update tbl_reviews set review_title ='".mysqli_escape_string($db->dbh, stripslashes($review_title))."', review_detail ='".mysqli_escape_string($db->dbh, stripslashes($review_detail))."', review_rating ='".mysqli_escape_string($db->dbh, stripslashes($review_rating))."', review_user_id ='".mysqli_escape_string($db->dbh, stripslashes($review_user_id))."',category_id='".mysqli_escape_string($db->dbh, stripslashes($cat_id))."' where review_id='".$update_id."'");*/
		}
		else
		{
			$db->query("insert into tbl_reviews set review_title ='".mysqli_escape_string($db->dbh, stripslashes($review_title))."', review_detail ='".mysqli_escape_string($db->dbh, stripslashes($review_detail))."', review_rating ='".mysqli_escape_string($db->dbh, stripslashes($review_rating))."', review_user_id ='".mysqli_escape_string($db->dbh, stripslashes($review_user_id))."',review_ip ='".mysqli_escape_string($db->dbh, stripslashes($_SERVER['REMOTE_ADDR']))."',category_id='".mysqli_escape_string($db->dbh, stripslashes($cat_id))."',review_post_date='".time()."',status='1' ");
		}
		
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
