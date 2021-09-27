<?php

include("../includes/top.php");

include(dirname(dirname(__FILE__))."/common/thumbnail.class.php");

error_reporting(0);

if(isset($_POST)) 

{

	$path= '../../site_upload/category_slider_images/';

	$errorstr="";

	$case = 1;

	$cat_img_title     = trim($_REQUEST['cat_img_title']);

	$category_level5_id    = trim($_REQUEST['category_level5_id']);

	$cat_img_name     = $_FILES["cat_img_name"]['name'];

	$update_id         = trim($_REQUEST['update_id']);

	if($cat_img_title == "")

	{

		$errorstr .="Please Enter Title\n";

		$case = 0;

	}

	if($category_level5_id == "")

	{

		$errorstr .="Please Enter Review Topic\n";

		$case = 0;

	}

	else

	{

		//check category is valid

		$chk_review_topic_qry ='select cat_id as chk_review_topic from tbl_categories where cat_id="'.$category_level5_id.'" and level=5';

		$chk_review_topic_arr = $db->get_row($chk_review_topic_qry, ARRAY_A);

		$chk_review_topic     = $chk_review_topic_arr['chk_review_topic'];	

		if($chk_review_topic=="")

		{

			$errorstr .="Invalid Review Topic is selected\n";

			$case = 0;

		}

	}



	if($_FILES["cat_img_name"]['name']=="" && $update_id=="")
	{
		$errorstr .= "Please upload Image\n";
		$case = 0;
	}
	elseif($_FILES["cat_img_name"]['name']!="")
	{
		
		$filename = $_FILES["cat_img_name"]['name'];

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
		$http_url_char  = substr($product_url, 0, 4);
		if($http_url_char!='http' && $http_url_char!='HTTP')
		{
			$product_url = 'http://'.$product_url;
		}
		if($update_id=="")
		{
			$insert_qry="INSERT INTO tbl_category_images SET category_level5_id='".mysqli_escape_string($db->dbh, stripslashes($category_level5_id))."',cat_img_title='".mysqli_escape_string($db->dbh, stripslashes($cat_img_title))."',status='1' ";

			$db->query($insert_qry);

			$last_record = mysqli_insert_id($db->dbh);

		}

		else

		{

			$update_qry ="UPDATE tbl_category_images SET category_level5_id='".mysqli_escape_string($db->dbh, stripslashes($category_level5_id))."',cat_img_title='".mysqli_escape_string($db->dbh, stripslashes($cat_img_title))."' where cat_img_id='".$update_id."' ";

			$db->query($update_qry);

			$last_record = $update_id;

		}

		

		if($_FILES["cat_img_name"]['name']!="")

		{

			$select_img ="select cat_img_name from tbl_category_images where cat_img_id='".$last_record."' ";

			$result = $db->get_row($select_img, ARRAY_A);

			$old_image  = $result['cat_img_name'];

			$imgfile =$path.$old_image;

			$thumbfile =$path.'thumb_'.$old_image;

			$thumbfile_small =$path.'small_thumb_'.$old_image;

			@unlink($imgfile);

			@unlink($thumbfile);

			@unlink($thumbfile_small);

			

			$icon_array = $_FILES["cat_img_name"]['name'];

			$img_formats = array("jpeg", "gif", "png", "jpg","JPEG", "GIF", "PNG", "JPG");

			$allowed_size = 2; // Allowed Photo Size in MB			

			$file_temp = $_FILES["cat_img_name"]['tmp_name'];

			$h_image_size = filesize($_FILES["cat_img_name"]['tmp_name']);

			$h_image_size = ($h_image_size/1024)/1024;

			$h_file_name_array 	= $_FILES["user_image"];

			$h_file_ext = ltrim(strtolower(strrchr($_FILES["cat_img_name"]['name'],'.')),'.'); 

			

			$icon_orgname = rand()."_".$_FILES["cat_img_name"]['name'];

			$h_newthumb_name = 'thumb_'.$icon_orgname;	

			$h_small_thumb_name = 'small_thumb_'.$icon_orgname;			

			$h_photo_path = $path.$icon_orgname;

			$h_photothumb_path = $path.$h_newthumb_name;

			$h_dir = $path;

			

			if($h_image_size < $allowed_size)

			{

				copy($file_temp,$h_photo_path);	

				$a = new Thumbnail($_FILES["cat_img_name"]['tmp_name'],150,'90',$h_dir.$h_newthumb_name);

				// creating thumbnail

				$a->create();

				

				$b = new Thumbnail($_FILES["cat_img_name"]['tmp_name'],20,'20',$h_dir.$h_small_thumb_name);

				// creating thumbnail

				$b->create();

				

				$img_qry="UPDATE tbl_category_images SET cat_img_name='".$icon_orgname."' where cat_img_id='".$last_record."' ";

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

