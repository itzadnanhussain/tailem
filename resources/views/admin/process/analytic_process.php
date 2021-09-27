<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$analaytic  = trim($_REQUEST['analaytic']);

	if($analaytic == "")
	{
		$errorstr .= "Please enter google google Analytic  code.\n";
		$case = 0;
	}

	if($case==1)
	{
		if($_SESSION['reviewsite_cpadmin_type']=='admin')
		{
			$update_qry = "UPDATE tbl_setting set analaytic = '".mysqli_escape_string($db->dbh, $analaytic)."' where setting_id='1'";
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
