<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$page_name  	  = trim($_REQUEST['page_name']);
	$page_headertitle = trim($_REQUEST['page_headertitle']);
	$page_content     = trim($_REQUEST['page_content']);
	$update_id        = $_REQUEST['update_id'];
	
	$chk_qry = "select page_id from tbl_pages where page_id='".$update_id."' ";
	$chk_arr = $db->get_row($chk_qry,ARRAY_A);
	$page_id = $chk_arr['page_id'];
	
	if($page_id=="" || $update_id=="")
	{
		$errorstr .= "Invalid page is selected\n";
		$case = 0;
	}
	if($page_name == "")
	{
		$errorstr .="Please Enter Page Title\n";
		$case = 0;
	}
	if($page_headertitle == "")
	{
		$errorstr .= "Please Enter Page Header Title\n";
		$case = 0;
	}
	if($page_content == "")
	{
		$errorstr .= "Please Enter Page Data\n";
		$case = 0;
	}
	 

	if($case==1)
	{
		$page_name_seo = clean_url_seo($page_name);
		if($update_id != '')
		{
			$db->query("update tbl_pages set page_name ='".mysqli_escape_string($db->dbh, stripcslashes($page_name))."', page_seo_name ='".mysqli_escape_string($db->dbh, stripcslashes($page_name_seo))."', page_content ='".mysqli_escape_string($db->dbh, stripcslashes($page_content))."' , page_headertitle ='".mysqli_escape_string($db->dbh, stripcslashes($page_headertitle))."',page_status='1' where page_id='".$update_id."'");
			
			echo 'done';
		}
		else
		{
			echo 'Some Error has Occured';
		}
	}
	else
	{
		echo $errorstr;
	}
}
?>
