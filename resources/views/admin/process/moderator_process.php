<?php
error_reporting(0);
include("../includes/top.php");
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$username         = trim($_REQUEST['username']);
	$email            = trim($_REQUEST['email']);
	$confirm_email 	  = trim($_REQUEST['confirm_email']);
	$simple_password  = trim($_REQUEST['simple_password']);

	if($username == "")
	{
		$errorstr .="Please Enter User Name\n";
		$case = 0;
	}
	elseif(!ctype_alnum($username))
	{
		$errorstr .="User Name must be Number or Character\n";
		$case = 0;
	}
	else
	{
		if($update_id != '')
		{
			$chk_user_qry = "select count(id) as chk_user from tbl_admin where username=\"".$username."\" 
			and id!='".$update_id."'";
		}
		else
		{
			$chk_user_qry = "select count(id) as chk_user from tbl_admin where username=\"".$username."\" ";
		}
		$chk_user_arr = $db->get_row($chk_user_qry,ARRAY_A);
		$chk_user = $chk_user_arr['chk_user'];
		if($chk_user>0)
		{
			$errorstr .= "This User Name Already Exsist\n";
			$case = 0;
		}
	}
	
	if($email == "")
	{
		$errorstr .= "Please Enter Email\n";
		$case = 0;
	}
	elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
	{
		$errorstr .= "Please Enter Valid Email\n";
		$case = 0;
	}
	else
	{
		if($update_id != '')
		{
			$chk_user_qry = "select count(id) as chk_user from tbl_admin where email=\"".$email."\" 
			and id!='".$update_id."'";
		}
		else
		{
			$chk_user_qry = "select count(id) as chk_user from tbl_admin where email=\"".$email."\" ";
		}
		$chk_user_arr = $db->get_row($chk_user_qry,ARRAY_A);
		$chk_user  = $chk_user_arr['chk_user'];
		if($chk_user>0)
		{
			$errorstr .= "This Email Already Exsist\n";
			$case = 0;
		}
		elseif($email!="" && $confirm_email== "")
		{
			$errorstr .= "Please Enter Confirm Email\n";
			$case = 0;
		}
		elseif($email!= "" && $confirm_email!="")
		{
			if($email !=$confirm_email)
			{
				$errorstr .= "Email and Confirm Email not match\n";
				$case = 0;
			}
		}
	}
	if($simple_password == "" && $update_id== '')
	{
		$errorstr .= "Please Enter Password\n";
		$case = 0;
	}
	elseif((strlen($simple_password)<6) && $simple_password!="")
	{
		$errorstr .= "Password must be a minimum of 6 characters\n";
		$case = 0;
	}
	if($case==1)
	{
		if($update_id != '')
		{
		
			$db->query("update tbl_admin set username ='".mysqli_escape_string($db->dbh, stripslashes($username))."',email ='".mysqli_escape_string($db->dbh, stripslashes($email))."' where id='".$update_id."'");
			
			$last_record = $update_id;
			if($simple_password!="")
			{
				$db->query("update tbl_admin set password_simple ='".mysqli_escape_string($db->dbh, $simple_password)."',password ='".md5($simple_password)."',modified_user_id='".$_SESSION['reviewsite_cpadmin_id']."',modified_date='".time()."' where id='".$update_id."'");
			}
		}
		else
		{
			$db->query("insert into tbl_admin set username='".mysqli_escape_string($db->dbh, stripslashes($username))."', email ='".mysqli_escape_string($db->dbh, stripslashes($email))."', password_simple ='".mysqli_escape_string($db->dbh, $simple_password)."',password ='".md5($simple_password)."',admin_status='1',modified_user_id='".$_SESSION['reviewsite_cpadmin_id']."',modified_date='".time()."' ");
			$last_insert_id =  mysqli_insert_id($db->dbh);
			$db->query("insert into tbl_moderator_rights set moderator_id='".$last_insert_id."'");
		}
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
