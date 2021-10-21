<?php 
error_reporting(0);

if(isset($_REQUEST)) 
{
	$errorstr="";
	$case = 1;
	$reviewid  = $_REQUEST['id'];
	
	if($_SESSION[USER_SESSION_ARRAY]['USER_ID']=="")
	{
		echo $errorstr .="Please sign in first.\n";
		$case = 0;
		exit;
	}
	
	if($reviewid=="")
	{
		$errorstr .="This notification doesn't exist.\n";
		$case = 0;
	}

	if($case==1)
	{
			 mysqli_query($db->dbh, "update tbl_likes set del_notification = '1' where like_receive_user = '".$_SESSION[USER_SESSION_ARRAY]['USER_ID']."' AND id = $reviewid");	
			
			echo 'done-SEPARATOR-'.$reviewid;
	}
	else
	{
		echo $errorstr;
	}
}
?>
