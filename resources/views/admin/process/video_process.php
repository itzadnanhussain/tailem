<?php
include("../includes/top.php");
include(dirname(dirname(__FILE__))."/common/thumbnail.class.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$video_title      = trim($_REQUEST['video_title']);
	$video_code       = trim($_REQUEST['video_code']);
	$video_cat_id     = trim($_REQUEST['video_cat_id']);
	$update_id        = trim($_REQUEST['update_id']);
	
	if($video_cat_id!='')
	{
		if($update_id=='')
		{
			$chk_rembed_code_qry ='select video_id as chk_embed_code from tbl_videos where 
			video_cat_id="'.$video_cat_id.'"';
		}
		else
		{
			$chk_rembed_code_qry ='select video_id as chk_embed_code from tbl_videos where 
			video_cat_id="'.$video_cat_id.'" and video_id!="'.$update_id.'" ';
		}
		$chk_rembed_code_arr = $db->get_row($chk_rembed_code_qry, ARRAY_A);
		$chk_embed_code   = $chk_rembed_code_arr['chk_embed_code'];
	}
	
	if($video_cat_id=='')
	{
		$errorstr .="Please Select Review Topic First\n";
		$case = 0;
	}
	elseif($video_cat_id!='' && $chk_embed_code!='')
	{
		$errorstr .="You have already add embed code for this review topic\n";
		$case = 0;
	}
	elseif($chk_embed_code=='')
	{
		if($video_title == "")
		{
			$errorstr .="Please Enter Title\n";
			$case = 0;
		}
	
		if($video_code == "")
		{
			$errorstr .="Please Enter Embed Code\n";
			$case = 0;
		}
	}
	if($case==1)
	{
		if($update_id=="")
		{
			 $insert_qry="INSERT INTO tbl_videos SET video_title='".mysqli_escape_string($db->dbh, stripslashes($video_title))."', video_code='".mysqli_escape_string($db->dbh, stripslashes($video_code))."',video_cat_id='".$video_cat_id."',date_added='".time()."', status='1' ";
			$db->query($insert_qry);
		}
		else
		{
			$update_qry ="UPDATE tbl_videos SET video_title='".mysqli_escape_string($db->dbh, stripslashes($video_title))."', video_code='".mysqli_escape_string($db->dbh, stripslashes($video_code))."',video_cat_id='".$video_cat_id."' where video_id='".$update_id."' ";
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

