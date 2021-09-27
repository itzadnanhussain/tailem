<?php
error_reporting(0);
include("../includes/top.php");
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$ad_script    = trim($_REQUEST['ad_script']);
	$ad_place     = trim($_REQUEST['ad_place']);
	$update_id    = $_REQUEST['update_id'];

	if($ad_script=="" || $ad_script=="&nbsp;")
	{
		$errorstr .="Please Enter Google Adsense Code\n";
		$case = 0;
	}
	if($ad_place == "")
	{
		$errorstr .="Please Select Ads Place\n";
		$case = 0;
	}
	else
	{
		$place_arr = array('Top', 'Right','Bottom');
		if(!in_array($ad_place,$place_arr))
		{
			$errorstr .= "Invalid Ads Place is selected\n";
			$case = 0;
		}
	}
	
	
	if($case==1)
	{
		if($update_id != '')
		{
			$db->query("update tbl_advertisement set ad_place='".mysqli_escape_string($db->dbh, $ad_place)."',ad_script ='".mysqli_escape_string($db->dbh, $ad_script)."' where ad_id='".$update_id."'");
		}
		else
		{
			$db->query("insert into tbl_advertisement set  ad_script ='".mysqli_escape_string($db->dbh, $ad_script)."',ad_place='".mysqli_escape_string($db->dbh, $ad_place)."',status='1' ");
		}
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
