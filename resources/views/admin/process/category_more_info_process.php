<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$sub_cat_id     = trim($_REQUEST['sub_cat_id']);
	$more_info_data = trim($_REQUEST['more_info_data']);
	$update_id      = trim($_REQUEST['update_id']);
	
	if($sub_cat_id!='')
	{
		if($update_id=='')
		{
			$chk_rembed_code_qry ='select more_info_id as chk_more_info from tbl_categories_more_info where 
			sub_cat_id="'.$sub_cat_id.'"';
		}
		else
		{
			$chk_rembed_code_qry ='select more_info_id as chk_more_info from tbl_categories_more_info where 
			sub_cat_id="'.$sub_cat_id.'" and more_info_id!="'.$update_id.'" ';
		}
		$chk_rembed_code_arr = $db->get_row($chk_rembed_code_qry, ARRAY_A);
		$chk_more_info   = $chk_rembed_code_arr['chk_more_info'];
	}
	
	if($sub_cat_id=='')
	{
		$errorstr .="Please Select Review Topic First\n";
		$case = 0;
	}
	elseif($sub_cat_id!='' && $chk_more_info!='')
	{
		$errorstr .="You have already add Category Info for this review topic\n";
		$case = 0;
	}
	elseif($chk_more_info=='')
	{		
	
		if($sub_cat_id == "")
		{
			$errorstr .="Please Select Review Topic\n";
			$case = 0;
		}
		else
		{
			//check category is valid
			$chk_review_topic_qry ='select cat_id as chk_review_topic from tbl_categories where 
			cat_id="'.$sub_cat_id.'" and level=5';
			$chk_review_topic_arr = $db->get_row($chk_review_topic_qry, ARRAY_A);
			$chk_review_topic     = $chk_review_topic_arr['chk_review_topic'];	
			if($chk_review_topic=="")
			{
				$errorstr .="Invalid Review Topic is selected\n";
				$case = 0;
			}
		}
		if($more_info_data == "")
		{
			$errorstr .="Please Enter More Info Data\n";
			$case = 0;
		}
	}
	
	
	if($case==1)
	{
		if($update_id=="")
		{
			$insert_qry="INSERT INTO tbl_categories_more_info SET sub_cat_id='".$sub_cat_id."',more_info_data='".mysqli_escape_string($db->dbh, stripslashes($more_info_data))."',status='1' ";
			$db->query($insert_qry);
		}
		else
		{
			$update_qry ="UPDATE tbl_categories_more_info SET sub_cat_id='".$sub_cat_id."',more_info_data='".mysqli_escape_string($db->dbh, stripslashes($more_info_data))."' where more_info_id='".$update_id."' ";
			$db->query($update_qry);
		}
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}

?>

