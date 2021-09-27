<?php
error_reporting(0);
include("../includes/top.php");
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$ads_script    = trim($_REQUEST['ads_script']);
	$ads_place     = 'Bottom';//trim($_REQUEST['ads_place']);
	$update_id    = $_REQUEST['update_id'];

	if($ads_script=="" || $ads_script=="&nbsp;")
	{
		$errorstr .="Please Enter Google Adsense Code\n";
		$case = 0;
	}
	if($ads_place == "")
	{
		$errorstr .="Please Select Ads Place\n";
		$case = 0;
	}
	else
	{
		$place_arr = array('Top', 'Bottom');
		if(!in_array($ads_place,$place_arr))
		{
			$errorstr .= "Invalid Ads Place is selected\n";
			$case = 0;
		}
	}
	
	if($case==1)
	{
		if($update_id != '')
		{
			$db->query("update tbl_mobile_advertisement set ads_place='".mysqli_escape_string($db->dbh, $ads_place)."',ads_script ='".mysqli_escape_string($db->dbh, $ads_script)."' where ads_id='".$update_id."'");
		}
		else
		{
			$db->query("insert into tbl_mobile_advertisement set ads_script ='".mysqli_escape_string($db->dbh, $ads_script)."',ads_place='".mysqli_escape_string($db->dbh, $ads_place)."',status='1' ");
		}
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
