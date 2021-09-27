<?php
include("../includes/top.php");
include(dirname(dirname(__FILE__))."/common/thumbnail.class.php");
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$path= '../../site_upload/general_setting/';
	$facebook_right_script  = trim($_REQUEST['facebook_right_script']);
	$facebook_bottom_script = trim($_REQUEST['facebook_bottom_script']);
	$rate_review = trim($_REQUEST['rate_review']);
	$discuss = trim($_REQUEST['discuss']);
	$profile = trim($_REQUEST['profile']);
	$rhyming_larics = trim($_REQUEST['rhyming_larics']);
	$desktop_version_logo              = $_FILES["desktop_version_logo"]['name'];

	/*if($facebook_right_script == "")
	{
		$errorstr .= "Please enter facebook right script.\n";
		$case = 0;
	}
	if($facebook_bottom_script == "")
	{
		$errorstr .= "Please enter facebook bottom script.\n";
		$case = 0;
	}*/
	if($_FILES["desktop_version_logo"]['name']!="")
	{
		$filename = $_FILES["desktop_version_logo"]['name'];
		$TmpExt   = strtolower(substr($filename, strrpos($filename, '.')+1));
		$ext = array('jpg', 'png', 'gif','JPEG','jpeg');
		if(!in_array($TmpExt,$ext))
		{
			$errorstr .= "Please upload Upload Logo for Desktop version\n";
			$case = 0;
		}
	}
	/*if($_FILES["mobile_version_logo"]['name']!="")
	{
		$filename = $_FILES["mobile_version_logo"]['name'];
		$TmpExt   = strtolower(substr($filename, strrpos($filename, '.')+1));
		$ext = array('jpg', 'png', 'gif','JPEG','jpeg');
		if(!in_array($TmpExt,$ext))
		{
			$errorstr .= "Please upload Upload Logo for Mobile version\n";
			$case = 0;
		}
	}*/
	
	/*if($rate_review == "")
	{
		$errorstr .= "Please enter Rate & Review description.\n";
		$case = 0;
	}
	
	if($discuss == "")
	{
		$errorstr .= "Please enter discuss detail.\n";
		$case = 0;
	}
	
	if($profile == "")
	{
		$errorstr .= "Please enter profile detail.\n";
		$case = 0;
	}
	
	if($rhyming_larics == "")
	{
		$errorstr .= "Please enter rhyming larics detail.\n";
		$case = 0;
	}
	*/
	if($case==1)
	{
		$update_qry = "UPDATE tbl_general_setting set facebook_right_script = '".mysqli_escape_string($db->dbh, $facebook_right_script)."', facebook_bottom_script = '".mysqli_escape_string($db->dbh, $facebook_bottom_script)."', rate_review = '".mysqli_escape_string($db->dbh, $rate_review)."', discuss = '".mysqli_escape_string($db->dbh, $discuss)."', profile = '".mysqli_escape_string($db->dbh, $profile)."', rhyming_larics = '".mysqli_escape_string($db->dbh, $rhyming_larics)."' where setting_id='1' ";
		$db->query($update_qry);
		
		if($_FILES["desktop_version_logo"]['name']!="")
		{
			$select_img ="select desktop_version_logo from tbl_general_setting where setting_id='1' ";
			$result = $db->get_row($select_img, ARRAY_A);
			$old_image  = $result['desktop_version_logo'];
			$imgfile =$path.$old_image;
			$thumbfile =$path.'thumb_'.$old_image;
			$thumbfile_small =$path.'small_thumb_'.$old_image;
			@unlink($imgfile);
			@unlink($thumbfile);
			@unlink($thumbfile_small);
			
			$icon_array = $_FILES["desktop_version_logo"]['name'];
			$img_formats = array("jpeg", "gif", "png", "jpg","JPEG", "GIF", "PNG", "JPG");
			$allowed_size = 2; // Allowed Photo Size in MB			
			$file_temp = $_FILES["desktop_version_logo"]['tmp_name'];
			$h_image_size = filesize($_FILES["desktop_version_logo"]['tmp_name']);
			$h_image_size = ($h_image_size/1024)/1024;
			$h_file_name_array 	= $_FILES["user_image"];
			$h_file_ext = ltrim(strtolower(strrchr($_FILES["desktop_version_logo"]['name'],'.')),'.'); 
			
			$icon_orgname = rand()."_".$_FILES["desktop_version_logo"]['name'];
			$h_newthumb_name = 'thumb_'.$icon_orgname;	
			$h_small_thumb_name = 'small_thumb_'.$icon_orgname;	
			$h_mobile_thumb_name = 'mobile_thumb_'.$icon_orgname;		
			$h_photo_path = $path.$icon_orgname;
			$h_photothumb_path = $path.$h_newthumb_name;
			$h_mobile_thumb_path = $path.$h_mobile_thumb_name;
			$h_dir = $path;
			
			if($h_image_size < $allowed_size)
			{
				copy($file_temp,$h_photo_path);	
				$a = new Thumbnail($_FILES["desktop_version_logo"]['tmp_name'],286,'44',$h_dir.$h_newthumb_name);
				// creating thumbnail
				$a->create();
				
				$b = new Thumbnail($_FILES["desktop_version_logo"]['tmp_name'],50,'50',$h_dir.$h_small_thumb_name);
				// creating thumbnail
				$b->create();
				
				$img_qry="UPDATE tbl_general_setting SET desktop_version_logo='".$icon_orgname."' where setting_id='1'";
				$db->query($img_qry);
			}
		}
		
		if($_FILES["mobile_version_logo"]['name']!="")
		{
			$select_img ="select mobile_version_logo from tbl_general_setting where setting_id='1' ";
			$result = $db->get_row($select_img, ARRAY_A);
			$old_image  = $result['mobile_version_logo'];
			$imgfile =$path.$old_image;
			$thumbfile =$path.'thumb_'.$old_image;
			$thumbfile_small =$path.'small_thumb_'.$old_image;
			@unlink($imgfile);
			@unlink($thumbfile);
			@unlink($thumbfile_small);
			
			$icon_array = $_FILES["mobile_version_logo"]['name'];
			$img_formats = array("jpeg", "gif", "png", "jpg","JPEG", "GIF", "PNG", "JPG");
			$allowed_size = 2; // Allowed Photo Size in MB			
			$file_temp = $_FILES["mobile_version_logo"]['tmp_name'];
			$h_image_size = filesize($_FILES["mobile_version_logo"]['tmp_name']);
			$h_image_size = ($h_image_size/1024)/1024;
			$h_file_name_array 	= $_FILES["user_image"];
			$h_file_ext = ltrim(strtolower(strrchr($_FILES["mobile_version_logo"]['name'],'.')),'.'); 
			
			$icon_orgname = rand()."_".$_FILES["mobile_version_logo"]['name'];
			$h_newthumb_name = 'thumb_'.$icon_orgname;	
			$h_small_thumb_name = 'small_thumb_'.$icon_orgname;	
			$h_mobile_thumb_name = 'mobile_thumb_'.$icon_orgname;		
			$h_photo_path = $path.$icon_orgname;
			$h_photothumb_path = $path.$h_newthumb_name;
			$h_mobile_thumb_path = $path.$h_mobile_thumb_name;
			$h_dir = $path;
			
			if($h_image_size < $allowed_size)
			{
				copy($file_temp,$h_photo_path);	
				$a = new Thumbnail($_FILES["mobile_version_logo"]['tmp_name'],252,'39',$h_dir.$h_newthumb_name);
				// creating thumbnail
				$a->create();
				
				$b = new Thumbnail($_FILES["mobile_version_logo"]['tmp_name'],50,'50',$h_dir.$h_small_thumb_name);
				// creating thumbnail
				$b->create();
				
				$img_qry="UPDATE tbl_general_setting SET mobile_version_logo='".$icon_orgname."' where setting_id='1' ";
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
