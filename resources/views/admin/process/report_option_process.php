<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$report_chk_box_name  = trim($_REQUEST['report_chk_box_name']);
	$update_id = $_REQUEST['update_id'];
	if($report_chk_box_name == "")
	{
		$errorstr .="Please Enter Report Option Label\n";
		$case = 0;
	}
	else
	{   
		if($update_id != '')
		{
			$chk_cat_qry = "select count(report_chk_box_id) as chk_report from tbl_reports_checkbox where report_chk_box_name=\"".$report_chk_box_name."\" 
			and report_chk_box_id!='".$update_id."'";
		}
		else
		{
			$chk_cat_qry = "select count(report_chk_box_id) as chk_report from tbl_reports_checkbox where report_chk_box_name=\"".$report_chk_box_name."\" ";
		}
		$chk_cat_arr = $db->get_row($chk_cat_qry,ARRAY_A);
		$chk_report = $chk_cat_arr['chk_report'];
		if($chk_report>0)
		{
			$errorstr .= "This Report Option Label Already Exsist\n";
			$case = 0;
		}
	}

	if($case==1)
	{
		if($update_id != '')
		{
		
			$db->query("update tbl_reports_checkbox set report_chk_box_name ='".mysqli_escape_string($db->dbh, stripcslashes($report_chk_box_name))."' where report_chk_box_id='".$update_id."'");
		}
		else
		{
			$db->query("insert into tbl_reports_checkbox set report_chk_box_name ='".mysqli_escape_string($db->dbh, stripcslashes($report_chk_box_name))."'");
		}
		
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
