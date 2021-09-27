<?php
error_reporting(0);
include("../includes/top.php");
include(dirname(dirname(__FILE__))."/common/thumbnail.class.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$path= '../../site_upload/user_images/';
	$user_name        = trim($_REQUEST['user_name']);
	$user_email       = trim($_REQUEST['user_email']);
	$confirm_email 	  = trim($_REQUEST['confirm_email']);
	$simple_password  = trim($_REQUEST['simple_password']);
	$country_id	      = trim($_REQUEST['country_id']);
	$region 	      = trim($_REQUEST['region']);
	$about_me	      = trim($_REQUEST['about_me']);
	$update_id        = $_REQUEST['update_id'];
	$image_name       = $_FILES["image_name"]['name'];
	if($user_name == "")
	{
		$errorstr .="Please Enter Display Name\n";
		$case = 0;
	}
	else
	{
		if($update_id != '')
		{
			$chk_user_qry = "select count(user_id) as chk_user from tbl_users where user_name=\"".$user_name."\" 
			and user_id!='".$update_id."'";
		}
		else
		{
			$chk_user_qry = "select count(user_id) as chk_user from tbl_users where user_name=\"".$user_name."\" ";
		}
		$chk_user_arr = $db->get_row($chk_user_qry,ARRAY_A);
		$chk_user = $chk_user_arr['chk_user'];
		if($chk_user>0)
		{
			$errorstr .= "This Display Name Already Exsist\n";
			$case = 0;
		}
	}
	
	if($user_email == "")
	{
		$errorstr .= "Please Enter Email\n";
		$case = 0;
	}
	elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $user_email))
	{
		$errorstr .= "Please Enter Valid Email\n";
		$case = 0;
	}
	else
	{
		if($update_id != '')
		{
			$chk_user_qry = "select count(user_id) as chk_user from tbl_users where user_email=\"".$user_email."\" 
			and user_id!='".$update_id."'";
		}
		else
		{
			$chk_user_qry = "select count(user_id) as chk_user from tbl_users where user_email=\"".$user_email."\" ";
		}
		$chk_user_arr = $db->get_row($chk_user_qry,ARRAY_A);
		$chk_user  = $chk_user_arr['chk_user'];
		if($chk_user>0)
		{
			$errorstr .= "This Email Already Exsist\n";
			$case = 0;
		}
		/*elseif($user_email!="" && $confirm_email== "")
		{
			$errorstr .= "Please Enter Confirm Email\n";
			$case = 0;
		}
		elseif($user_email!= "" && $confirm_email!="")
		{
			if($user_email !=$confirm_email)
			{
				$errorstr .= "Email and Confirm Email not match\n";
				$case = 0;
			}
		}*/
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
	/*if($country_id == "")
	{
		$errorstr .= "Please Select Country\n";
		$case = 0;
	}
	else
	{
		$country_qry = "select count(country_id) as chk_country from tbl_countries where country_id='".$country_id."'";
		$country_arr = $db->get_row($country_qry,ARRAY_A);
		$chk_country = $country_arr['chk_country'];
		if($chk_country=="")
		{
			$errorstr .= "Invalid Country is Selected\n";
			$case = 0;
		}
	}
	if($region == "")
	{
		$errorstr .= "Please Enter Region\n";
		$case = 0;
	}*/
	/*if($about_me == "")
	{
		$errorstr .= "Please Enter About me details\n";
		$case = 0;
	}
	
	if($_FILES["image_name"]['name']=="" && $update_id=="")
	{
		$errorstr .= "Please Upload Profile Picture\n";
		$case = 0;
	}
	else*/
	if($_FILES["image_name"]['name']!="")
	{
		$filename = $_FILES["image_name"]['name'];
		$TmpExt   = strtolower(substr($filename, strrpos($filename, '.')+1));
		$ext = array('jpg', 'png', 'gif','JPEG','jpeg');
		if(!in_array($TmpExt,$ext))
		{
			$errorstr .= "Invalid Profile Picture Format\n";
			$case = 0;
		}
	}
	if($case==1)
	{
		$user_seo	=	str_replace(" ","_", $user_name);
		
		if($update_id != '')
		{		
			$db->query("update tbl_users set user_name ='".mysqli_escape_string($db->dbh, stripslashes($user_name))."',user_seo ='".mysqli_escape_string($db->dbh, stripslashes($user_seo))."',user_email ='".mysqli_escape_string($db->dbh, stripslashes($user_email))."',about_me='".mysqli_escape_string($db->dbh, stripslashes($about_me))."',country_id='".$country_id."',region='".mysqli_escape_string($db->dbh, stripslashes($region))."' where user_id='".$update_id."'");
			
			$last_record = $update_id;
			if($simple_password!="")
			{
				$db->query("update tbl_users set simple_password ='".mysqli_escape_string($db->dbh, $simple_password)."',encrypted_password ='".md5($simple_password)."' where user_id='".$update_id."'");
			}
		}
		else
		{
			$db->query("insert into tbl_users set user_name='".mysqli_escape_string($db->dbh, stripslashes($user_name))."',user_seo ='".mysqli_escape_string($db->dbh, stripslashes($user_seo))."', user_email ='".mysqli_escape_string($db->dbh, stripslashes($user_email))."', simple_password ='".mysqli_escape_string($db->dbh, $simple_password)."',encrypted_password ='".md5($simple_password)."',about_me='".mysqli_escape_string($db->dbh, stripslashes($about_me))."',date_added='".time()."', status = '1', country_id='".$country_id."', region='".mysqli_escape_string($db->dbh, $region)."' ");
			$last_record = mysqli_insert_id($db->dbh);
		}
		
		if($_FILES["image_name"]['name']!="")
		{
			$select_img ="select profile_image from tbl_users where user_id='".$last_record."' ";
			$result = $db->get_row($select_img, ARRAY_A);
			$old_image  = $result['profile_image'];
			$imgfile =$path.$old_image;
			$thumbfile =$path.'thumb_'.$old_image;
			$thumbfile_small =$path.'small_thumb_'.$old_image;
			@unlink($imgfile);
			@unlink($thumbfile);
			@unlink($thumbfile_small);
			
			$icon_array = $_FILES["image_name"]['name'];
			$img_formats = array("jpeg", "gif", "png", "jpg","JPEG", "GIF", "PNG", "JPG");
			$allowed_size = 2; // Allowed Photo Size in MB			
			$file_temp = $_FILES["image_name"]['tmp_name'];
			$h_image_size = filesize($_FILES["image_name"]['tmp_name']);
			$h_image_size = ($h_image_size/1024)/1024;
			$h_file_name_array 	= $_FILES["user_image"];
			$h_file_ext = ltrim(strtolower(strrchr($_FILES["image_name"]['name'],'.')),'.'); 
			
			$icon_orgname = rand()."_".$_FILES["image_name"]['name'];
			$h_newthumb_name = 'thumb_'.$icon_orgname;	
			$h_small_thumb_name = 'small_thumb_'.$icon_orgname;			
			$h_photo_path = $path.$icon_orgname;
			$h_photothumb_path = $path.$h_newthumb_name;
			$h_dir = $path;
			
			if($h_image_size < $allowed_size)
			{
				copy($file_temp,$h_photo_path);	
				$a = new Thumbnail($_FILES["image_name"]['tmp_name'],241,'238',$h_dir.$h_newthumb_name);
				// creating thumbnail
				$a->create();
				
				$b = new Thumbnail($_FILES["image_name"]['tmp_name'],50,'50',$h_dir.$h_small_thumb_name);
				// creating thumbnail
				$b->create();
				
				$img_qry="UPDATE tbl_users SET profile_image='".$icon_orgname."' where user_id='".$last_record."' ";
				$db->query($img_qry);
			}
		}
		
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
