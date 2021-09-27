<?php
include("../includes/top.php");
include(dirname(dirname(__FILE__))."/common/thumbnail.class.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	
	function SEO($input)
	{ 
		$input = str_replace("&nbsp;", " ", $input);
		$input = str_replace(array("'", "-"), "", $input); //remove single quote and dash
		$input = mb_convert_case($input, MB_CASE_LOWER, "UTF-8"); //convert to lowercase
		$input = preg_replace("#[^a-zA-Z0-9]+#", "-", $input); //replace everything non an with dashes
		$input = preg_replace("#(-){2,}#", "$1", $input); //replace multiple dashes with one
		$input = trim($input, "-"); //trim dashes from beginning and end of string if any
		return $input; 
	}
	

	
	$album_title    = trim($_REQUEST['album_title']);
	$artist_id    = trim($_REQUEST['artist_id']);
	$path			= '../../site_upload/album_images/';
	$years		   = trim($_REQUEST['years']); 
 
 
	$update_id = $_REQUEST['update_id'];
	if($album_title == "")
	{
		$errorstr .="Please Enter Artist Name\n";
		$case = 0;
	}
	
	if($_FILES["image_name"]['name']!="")
	{
		$filename = $_FILES["image_name"]['name'];
		$TmpExt   = strtolower(substr($filename, strrpos($filename, '.')+1));
		$ext = array('jpg', 'png', 'gif','JPEG','jpeg');
		if(!in_array($TmpExt,$ext))
		{
			$errorstr .= "Invalid Picture Format\n";
			$case = 0;
		}
	}
	
	

	if($case==1)
	{
		if($update_id != '')
		{
		
		if($_FILES["image_name"]['name']!="")
			{
				$select_img ="select album_picture from tbl_artist_album where id='".$update_id."' ";
				$result = $db->get_row($select_img, ARRAY_A);
				$old_image  = $result['album_picture'];
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
					
					$img_qry="UPDATE tbl_artist_album SET album_picture='".$icon_orgname."' where id = '".$update_id."'";
					$db->query($img_qry);
				}
		  }

		$db->query("update tbl_artist_album set album_title='".mysqli_escape_string($db->dbh, stripslashes($album_title))."',years=".mysqli_escape_string($db->dbh, stripslashes($years)).",keywords='".mysqli_escape_string($db->dbh, stripslashes($keywords))."',album_seo='".mysqli_escape_string($db->dbh, stripslashes(SEO($album_title)))."', ranking_order = '$song_ranking' where id ='".$update_id."' ");
		
		//echo 'done-SEPARATOR-'.SERVER_ADMIN_PATH."artist_album_list.php?artist_id=".base64_encode($artist_id);
		
		}
		else
		{
		
		$select_max ="select MAX(id) as maxid from tbl_artist_album";
		$result_row = $db->get_row($select_max, ARRAY_A);
		
		$max_id  =  $result_row['maxid'];
		 
		 $max_id  =  $max_id + 1;
		
		
			$db->query("insert into tbl_artist_album set  	id = '$max_id', album_title='".mysqli_escape_string($db->dbh, stripslashes($album_title))."',years='".mysqli_escape_string($db->dbh, stripslashes($years))."',keywords='".mysqli_escape_string($db->dbh, stripslashes($keywords))."',album_seo='".mysqli_escape_string($db->dbh, stripslashes(SEO($album_title)))."',album_artist_id='".mysqli_escape_string($db->dbh, stripslashes($artist_id))."', album_status = '1', ranking_order = '$song_ranking', posted_date='".time()."'");
			$last_record  =  mysqli_insert_id($db->dbh);
			
			if($_FILES["image_name"]['name']!="")
			{
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
					
				 $img_qry="UPDATE tbl_artist_album SET album_picture='".$icon_orgname."' where id='".$last_record."'";
					$db->query($img_qry);
				}
		  }
		
		
		
		}
		
		echo 'done-SEPARATOR-'.SERVER_ADMIN_PATH."artist_album_list.php?artist_id=".base64_encode($artist_id);
	}
	else
	{
		echo $errorstr;
	}
}
?>
