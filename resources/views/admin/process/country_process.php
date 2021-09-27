<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$name      = trim($_REQUEST['name']);
	$update_id = trim($_REQUEST['update_id']);
	if($name == "")
	{
		$errorstr .="Please Enter Country Name\n";
		$case = 0;
	}
	else
	{
		if($update_id=="")
		{
			$chk_name_qry ='select name as chk_name from tbl_countries where name  = \''.$name.'\' ';
		}
		else
		{
			$chk_name_qry ='select name as chk_name from tbl_countries where name  = \''.$name.'\' and 
			country_id!="'.$update_id.'" ';
		}
		$chk_name_arr = $db->get_row($chk_name_qry, ARRAY_A);
		$chk_name     = $chk_name_arr['chk_name'];	
		if($chk_name!="")
		{
			$errorstr .="This Country Name already Exsist\n";
			$case = 0;
		}
	}

	if($case==1)
	{
		if($update_id=="")
		{
			$insert_qry = "INSERT INTO tbl_countries SET name='".mysqli_escape_string($db->dbh, stripslashes($name))."' ";
			$db->query($insert_qry);
		}
		else
		{
			$update_qry ="UPDATE tbl_countries SET name='".mysqli_escape_string($db->dbh, stripslashes($name))."' where country_id='".$update_id."'";
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
