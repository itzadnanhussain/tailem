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
		Global $db;
		$input = str_replace("&nbsp;", " ", $input);
		$input = str_replace(array("'"), "", $input); //remove single quote and dash
		$input = mb_convert_case($input, MB_CASE_LOWER, "UTF-8"); //convert to lowercase
		$input = preg_replace("#[^a-zA-Z0-9]+#", "-", $input); //replace everything non an with dashes
		$input = preg_replace("#(-){}#", "$1", $input); //replace multiple dashes with one
		$input = trim($input, "-"); //trim dashes from beginning and end of string if any
		
		$song_id=$_REQUEST['update_id'];
		if($song_id!=""){
			
			$select_url ="select artist_seo from tbl_artists where artist_seo='$input' and id !='$song_id'";
				
		}else{
			
			$select_url ="select artist_seo from tbl_artists where artist_seo='$input'";
			
		}
		$result = $db->get_results($select_url, ARRAY_A);
		if(count($result)>0){
		 $input=$input."-".uniqid();	
			
		}
		
		
		return $input; 
	}
	
	$artist_name    = trim($_REQUEST['artist_name']);
	$lastfm_url    =  trim($_REQUEST['lastfm_url']);
	$category       = trim($_REQUEST['category']);
	$artist_desc    = trim($_REQUEST['artist_desc']);
	$keywords	    = trim($_REQUEST['keywords']);
	$artist_seo	    = trim($_REQUEST['artist_seo']);
	$path			= '../../site_upload/artist_images/';

	$update_id = $_REQUEST['update_id'];
	

	if($artist_name == "")
	{
		$errorstr .="Please Enter Artist Name\n";
		$case = 0;
	}
	
	if($category == "")
	{
		$errorstr .="Please select genere category\n";
		$case = 0;
	}
	
	/*if($artist_desc == "")
	{
		$errorstr .= "Please Enter Description\n";
		$case = 0;
	}*/
	
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
		
			/*$db->query("update tbl_artists set artist_name ='".mysqli_real_escape_string($db->dbh, stripcslashes($artist_name))."',artist_description 	 ='".mysqli_real_escape_string($db->dbh, stripcslashes($artist_description))."' where faq_id='".$update_id."'");
*/		

		if($_FILES["image_name"]['name']!="")
			{
				$select_img ="select artist_img from tbl_artists where id='".$update_id."' ";
				$result = $db->get_row($select_img, ARRAY_A);
				$old_image  = $result['artist_img'];
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
					
					$img_qry="UPDATE tbl_artists SET artist_img='".$icon_orgname."' where id = '".$update_id."'";
					$db->query($img_qry);
				}
		  }

		$db->query("update tbl_artists set artist_name='".mysqli_escape_string($db->dbh, stripslashes($artist_name))."',genere_cat='".mysqli_escape_string($db->dbh, stripslashes($category))."',artist_seo='".mysqli_escape_string($db->dbh, stripslashes(SEO($artist_seo)))."',lastfm_url='".mysqli_escape_string($db->dbh, stripslashes($lastfm_url))."',keywords='".mysqli_escape_string($db->dbh, stripslashes($keywords))."',artist_description ='".mysqli_escape_string($db->dbh, stripslashes($artist_desc))."' where id ='".$update_id."' ");
		
		}
		else
		{
		
			
			
			$db->query("insert into tbl_artists set artist_name='".mysqli_escape_string($db->dbh, stripslashes($artist_name))."',genere_cat='".mysqli_escape_string($db->dbh, stripslashes($category))."',artist_seo='".mysqli_escape_string($db->dbh, stripslashes(SEO($artist_name)))."',keywords='".mysqli_escape_string($db->dbh, stripslashes($keywords))."',lastfm_url='".mysqli_escape_string($db->dbh, stripslashes($lastfm_url))."', artist_description ='".mysqli_escape_string($db->dbh, stripslashes($artist_desc))."', artist_status = '1', posted_date='".time()."'");
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
						
						$img_qry="UPDATE tbl_artists SET artist_img='".$icon_orgname."' where id='".$last_record."'";
						$db->query($img_qry);
					}
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
