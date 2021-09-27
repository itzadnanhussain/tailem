<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_POST)) 
{
	
	$errorstr="";
	$case = 1;
	$cat_name  	  = trim($_REQUEST['cat_name']);
	
	$update_id = trim($_REQUEST['update_id']);
	if($cat_name == "")
	{
		$errorstr .="Please Enter Category Name\n";
		$case = 0;
	}
	else
	{
		if($update_id=="")
		{
			$chk_name_qry ='select cat_name as chk_name from tbl_categories where cat_name  = \''.$cat_name.'\'';
		}
		else
		{
			$chk_name_qry ='select cat_name as chk_name from tbl_categories where cat_name  = \''.$cat_name.'\' and cat_id!="'.$update_id.'" ';
		}
		$chk_name_arr = $db->get_row($chk_name_qry, ARRAY_A);
		$chk_name     = $chk_name_arr['chk_name'];	
		if($chk_name!="")
		{
			$errorstr .="This Category Name already Exsist\n";
			$case = 0;
		}
	}
	
	if($case==1)
	{
		$cat_seo_name = clean_url_seo($cat_name);
		
		$cat_seo_name = str_replace("-","",$cat_seo_name);
		
		if($update_id=="")
		{
			
			
			$insert_qry="INSERT INTO tbl_categories SET cat_name='".mysqli_escape_string($db->dbh, stripslashes($cat_name))."',cat_seo_name='".mysqli_escape_string($db->dbh, stripslashes($cat_seo_name))."'";
			$db->query($insert_qry);
			$last_record = mysqli_insert_id($db->dbh);
		}
		else
		{
			$update_qry ="UPDATE tbl_categories SET cat_name='".mysqli_escape_string($db->dbh, stripslashes($cat_name))."',cat_seo_name='".mysqli_escape_string($db->dbh, stripslashes($cat_seo_name))."' where cat_id='".$update_id."' ";
			$db->query($update_qry);
			$last_record = $update_id;
		}
		
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
