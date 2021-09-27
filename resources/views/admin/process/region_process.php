<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$region_name = trim($_REQUEST['region_name']);
	$country_id  = trim($_REQUEST['country_id']);
	$update_id   = trim($_REQUEST['update_id']);
	if($region_name == "")
	{
		$errorstr .="Please Enter Region Name\n";
		$case = 0;
	}
	else
	{
		if($update_id=="")
		{
			$chk_name_qry ='select name as chk_name from tbl_regions where region_name  = \''.$region_name.'\' and 
			country_id="'.$country_id.'"';
		}
		else
		{
			$chk_name_qry ='select name as chk_name from tbl_regions where region_name  = \''.$region_name.'\' and 
			country_id="'.$country_id.'" and region_id!="'.$update_id.'"';
		}
		$chk_name_arr = $db->get_row($chk_name_qry, ARRAY_A);
		$chk_name     = $chk_name_arr['chk_name'];	
		if($chk_name!="")
		{
			$errorstr .="This Region Name already Exsist\n";
			$case = 0;
		}
	}
	
	if($country_id == "")
	{
		$errorstr .="Please Select Country\n";
		$case = 0;
	}
	else
	{
		$chk_country_qry ='select name as chk_country from tbl_countries where country_id  = \''.$country_id.'\'';
		$chk_country_arr = $db->get_row($chk_country_qry, ARRAY_A);
		$chk_country     = $chk_country_arr['chk_country'];	
		if($chk_country=="")
		{
			$errorstr .="Invalid country is selected\n";
			$case = 0;
		}
	}

	if($case==1)
	{
		if($update_id=="")
		{
			$insert_qry = "INSERT INTO tbl_regions SET region_name='".$region_name."',country_id='".$country_id."' ";
			$db->query($insert_qry);
		}
		else
		{
			$update_qry ="UPDATE tbl_regions SET region_name='".$region_name."',country_id='".$country_id."' where region_id='".$update_id."'";
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
