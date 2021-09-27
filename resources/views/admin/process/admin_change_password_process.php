<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$old_password    	  = trim($_REQUEST['old_password']);
	$new_password    	  = trim($_REQUEST['new_password']);
	$confirm_new_password = trim($_REQUEST['confirm_new_password']);
	
	if($old_password == "")
	{
		$errorstr .="Please Enter Old/Current Password.\n";
		$case = 0;
	}
	else
	{
		 $chk_pass_qry ='select password_simple as chk_password from tbl_admin where 
		 password_simple  = \''.$old_password.'\' and id="'.$_SESSION['reviewsite_cpadmin_id'].'" ';
		$chk_pass_arr = $db->get_row($chk_pass_qry, ARRAY_A);
		$chk_password    = $chk_pass_arr['chk_password'];	
		if($chk_password=="")
		{
			$errorstr .="Please Enter Valid Old/Current Password.\n";
			$case = 0;
		}
		else
		{
			if($new_password == "")
			{
				$errorstr .="Please Enter New Password.\n";
				$case = 0;
			}
			elseif($confirm_new_password == "")
			{
				$errorstr .="Please Enter Confirm New Password.\n";
				$case = 0;
			}
			elseif($new_password != $confirm_new_password)
			{
				$errorstr.="New Password and Confirm New Password not match.\n";
				$case = 0;
			}
		}
		
	}

	if($case==1)
	{
		$password_simple = $new_password;
		$password        = md5($new_password);
		
		$update_qry = "UPDATE tbl_admin set password_simple = '".$password_simple."',password = '".$password."' 
		,modified_user_id='".$_SESSION['reviewsite_cpadmin_id']."',modified_date='".time()."' where id='".$_SESSION['reviewsite_cpadmin_id']."'";
		$db->query($update_qry);
		
		if($_SESSION['reviewsite_cpadmin_type']=='user')
		{
			$db->query("insert into tbl_moderator_logs set moderator_id='".$_SESSION['reviewsite_cpadmin_id']."', activity ='change password',activity_table ='tbl_admin',date_added='".time()."' ");
		}
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
