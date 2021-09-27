<?php
include("../includes/top.php");
include(dirname(dirname(__FILE__))."/common/thumbnail.class.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$embed_code_title = trim($_REQUEST['embed_code_title']);
	$embed_cat_id     = trim($_REQUEST['embed_cat_id']);
	$embed_code       = trim($_REQUEST['embed_code']);
	$update_id        = trim($_REQUEST['update_id']);
	
	if($embed_cat_id!='')
	{
		if($update_id=='')
		{
			$chk_rembed_code_qry ='select embed_code_id as chk_embed_code from tbl_product_embed_code where 
			embed_cat_id="'.$embed_cat_id.'"';
		}
		else
		{
			$chk_rembed_code_qry ='select embed_code_id as chk_embed_code from tbl_product_embed_code where 
			embed_cat_id="'.$embed_cat_id.'" and embed_code_id!="'.$update_id.'" ';
		}
		$chk_rembed_code_arr = $db->get_row($chk_rembed_code_qry, ARRAY_A);
		$chk_embed_code   = $chk_rembed_code_arr['chk_embed_code'];
	}
	
	if($embed_cat_id=='')
	{
		$errorstr .="Please Select Review Topic First\n";
		$case = 0;
	}
	elseif($embed_cat_id!='' && $chk_embed_code!='')
	{
		$errorstr .="You have already add embed code for this review topic\n";
		$case = 0;
	}
	elseif($chk_embed_code=='')
	{		
		if($embed_code_title == "")
		{
			$errorstr .="Please Enter Title\n";
			$case = 0;
		}
	
		if($embed_cat_id == "")
		{
			$errorstr .="Please Select Review Topic\n";
			$case = 0;
		}
		else
		{
			//check category is valid
			$chk_review_topic_qry ='select cat_id as chk_review_topic from tbl_categories where cat_id="'.$embed_cat_id.'" and level=5';
			$chk_review_topic_arr = $db->get_row($chk_review_topic_qry, ARRAY_A);
			$chk_review_topic     = $chk_review_topic_arr['chk_review_topic'];	
			if($chk_review_topic=="")
			{
				$errorstr .="Invalid Review Topic is selected\n";
				$case = 0;
			}
		}
		if($embed_code == "")
		{
			$errorstr .="Please Enter Embed Code\n";
			$case = 0;
		}
	}
	
	
	if($case==1)
	{
		if($update_id=="")
		{
			$insert_qry="INSERT INTO tbl_product_embed_code SET embed_code_title='".mysqli_escape_string($db->dbh, stripslashes($embed_code_title))."', embed_cat_id='".$embed_cat_id."',embed_code='".mysqli_escape_string($db->dbh, stripslashes($embed_code))."',date_added='".time()."',status='1' ";
			$db->query($insert_qry);
		}
		else
		{
			$update_qry ="UPDATE tbl_product_embed_code SET embed_code_title='".mysqli_escape_string($db->dbh, stripslashes($embed_code_title))."', embed_cat_id='".$embed_cat_id."',embed_code='".mysqli_escape_string($db->dbh, stripslashes($embed_code))."' where embed_code_id='".$update_id."' ";
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

