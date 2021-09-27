<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$admin_email  = trim($_REQUEST['admin_email']);

	if($admin_email == "")
	{
		$errorstr .= "Please enter Email.\n";
		$case = 0;
	}
	
	else
	{
		if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $admin_email))
		{
			$errorstr .="Please Enter Valid Email.\n";
			$case = 0;
		}
		else
		{
			$chk_user_qry = "select count(id) as chk_user from tbl_admin where email=\"".$admin_email."\" and id!='".$_SESSION['reviewsite_cpadmin_id']."' ";
			$chk_user_arr = $db->get_row($chk_user_qry,ARRAY_A);
			$chk_user  = $chk_user_arr['chk_user'];
			if($chk_user>0)
			{
				$errorstr .= "This Email Already Exsist\n";
				$case = 0;
			}
		}
		
	}
	if($case==1)
	{
		$update_qry = "UPDATE tbl_admin set email = '".mysqli_escape_string($db->dbh, $admin_email)."',modified_user_id='".$_SESSION['reviewsite_cpadmin_id']."',modified_date='".time()."' where id='".$_SESSION['reviewsite_cpadmin_id']."'";
		$db->query($update_qry);
		
		if($_SESSION['reviewsite_cpadmin_type']=='user')
		{
			$db->query("insert into tbl_moderator_logs set moderator_id='".$_SESSION['reviewsite_cpadmin_id']."', activity ='change email',activity_table ='tbl_admin',date_added='".time()."' ");
		}
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
