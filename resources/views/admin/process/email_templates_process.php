<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$etemp_name    = trim($_REQUEST['etemp_name']);
	$etemp_subject = trim($_REQUEST['etemp_subject']);
	$etemp_data    = trim($_REQUEST['etemp_data']);
	$update_id     = $_REQUEST['update_id'];
	
	$chk_qry = "select etemp_id from tbl_emailtemplets where etemp_id='".$update_id."' ";
	$chk_arr = $db->get_row($chk_qry,ARRAY_A);
	$etemp_id = $chk_arr['etemp_id'];
	
	if($etemp_id=="" || $update_id=="")
	{
		$errorstr .= "Invalid Email Template is selected\n";
		$case = 0;
	}
	if($etemp_name == "")
	{
		$errorstr .="Please Enter Templates Name\n";
		$case = 0;
	}
	if($etemp_subject == "")
	{
		$errorstr .= "Please Enter Subject\n";
		$case = 0;
	}
	if($etemp_data == "")
	{
		$errorstr .= "Please Enter Message\n";
		$case = 0;
	}
	 

	if($case==1)
	{
		if($update_id != '')
		{
			$db->query("update tbl_emailtemplets set etemp_name ='".mysqli_escape_string($db->dbh, stripcslashes($etemp_name))."',  etemp_data ='".mysqli_escape_string($db->dbh, stripcslashes($etemp_data))."' , etemp_subject ='".mysqli_escape_string($db->dbh, stripcslashes($etemp_subject))."' where etemp_id='".$update_id."'");
			
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
