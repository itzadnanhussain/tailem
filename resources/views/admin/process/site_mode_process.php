<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$site_mode  = trim($_REQUEST['site_mode']);//1 for live, 2 for maintance

	if($site_mode == "")
	{
		$errorstr .= "Please select site mode.\n";
		$case = 0;
	}
	elseif($site_mode!=1 && $site_mode!=2)
	{	
		$errorstr .="Please select valid site mode.\n";
		$case = 0;
	}
	if($case==1)
	{
		if($_SESSION['reviewsite_cpadmin_type']=='admin')
		{
		 	$update_qry = "UPDATE tbl_setting set site_mode = '".mysqli_escape_string($db->dbh, $site_mode)."' where setting_id=1";

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

