<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$itune_url  = trim($_REQUEST['itune_url']);//1 for live, 2 for maintance

	
	if($case==1)
	{
		if($_SESSION['reviewsite_cpadmin_type']=='admin')
		{
		 	 $update_qry = "UPDATE tbl_setting set itune_url = '".addslashes($itune_url)."' where setting_id=1";


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

