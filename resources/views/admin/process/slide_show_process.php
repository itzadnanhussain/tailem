<?php
error_reporting(0);
include("../includes/top.php");
include(dirname(dirname(__FILE__))."/common/thumbnail.class.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$path= '../../site_upload/slideshow_images/';
	$slideshow_title    = trim($_REQUEST['slideshow_title']);
	$slideshow_position = trim($_REQUEST['slideshow_position']);
	$update_id        = $_REQUEST['update_id'];
	if($slideshow_title == "")
	{
		$errorstr .="Please Enter Title\n";
		$case = 0;
	}
	
	if($slideshow_position == "")
	{
		$errorstr .="Please Select Position\n";
		$case = 0;
	}
	else
	{
		$position_arr = array('Top', 'Bottom');
		if(!in_array($slideshow_position,$position_arr))
		{
			$errorstr .= "Please Select Valid Position\n";
			$case = 0;
		}
	}
	
	if($_FILES["image_name"]['name']=="" && $update_id=="")
	{
		$errorstr .= "Please Upload Image\n";
		$case = 0;
	}
	elseif($_FILES["image_name"]['name']!="")
	{
		$filename = $_FILES["image_name"]['name'];
		$TmpExt   = strtolower(substr($filename, strrpos($filename, '.')+1));
		$ext = array('jpg', 'png', 'gif','JPEG','jpeg');
		if(!in_array($TmpExt,$ext))
		{
			$errorstr .= "Invalid Image Format\n";
			$case = 0;
		}
	}
	if($case==1)
	{
		if($update_id != '')
		{
		
	       $db->query("update tbl_slideshow set slideshow_title ='".mysqli_escape_string($db->dbh, stripslashes($slideshow_title))."', slideshow_position='".$slideshow_position."' where slideshow_id='".$update_id."' ");
			$last_record = $update_id;
		}
		else
		{
			$db->query("insert into tbl_slideshow set slideshow_title ='".mysqli_escape_string($db->dbh, stripslashes($slideshow_title))."',slideshow_status='1',slideshow_position='".$slideshow_position."' ");
			$last_record = mysqli_insert_id($db->dbh);
		}
		
		if($_FILES["image_name"]['name']!="")
		{
			$select_img ="select slideshow_image from tbl_slideshow where slideshow_id='".$last_record."' ";
			$result = $db->get_row($select_img, ARRAY_A);
			$old_image  = $result['slideshow_image'];
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
				$a = new Thumbnail($_FILES["image_name"]['tmp_name'],555,'326',$h_dir.$h_newthumb_name);
				// creating thumbnail
				$a->create();
				
				$b = new Thumbnail($_FILES["image_name"]['tmp_name'],80,'80',$h_dir.$h_small_thumb_name);
				// creating thumbnail
				$b->create();
				
				$img_qry="UPDATE tbl_slideshow SET slideshow_image='".$icon_orgname."' where slideshow_id='".$last_record."' ";
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
