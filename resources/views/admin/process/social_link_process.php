<?php
include("../includes/top.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$facebook  = trim($_REQUEST['facebook']);
	$twitter   = trim($_REQUEST['twitter']);
	$pinterest = trim($_REQUEST['pinterest']);
	$linkedin  = trim($_REQUEST['linkedin']);
	$google    = trim($_REQUEST['google']);

	if($facebook == "")
	{
		$errorstr .= "Please enter facebook url.\n";
		$case = 0;
	}
	/*if($linkedin == "")
	{
		$errorstr .= "Please enter Linkedin url.\n";
		$case = 0;
	}*/
	if($twitter == "")
	{
		$errorstr .= "Please enter twitter url.\n";
		$case = 0;
	}
	if($google == "")
	{
		$errorstr .= "Please enter Google+ url.\n";
		$case = 0;
	}
	/*if($pinterest == "")
	{
		$errorstr .= "Please enter pinterest url.\n";
		$case = 0;
	}*/
	if($case==1)
	{
		$update_qry = "UPDATE tbl_social_links set facebook = '".mysqli_escape_string($db->dbh, $facebook)."',twitter = '".mysqli_escape_string($db->dbh, $twitter)."',pinterest = '".mysqli_escape_string($db->dbh, $pinterest)."',linkedin = '".mysqli_escape_string($db->dbh, $linkedin)."',google = '".mysqli_escape_string($db->dbh, $google)."' ";
		$db->query($update_qry);
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
