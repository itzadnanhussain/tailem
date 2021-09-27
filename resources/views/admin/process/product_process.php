<?php

include("../includes/top.php");

include(dirname(dirname(__FILE__))."/common/thumbnail.class.php");

error_reporting(0);

if(isset($_POST)) 

{

	$path= '../../site_upload/product_images/';

	$errorstr="";

	$case = 1;

	$product_title     = trim($_REQUEST['product_title']);

	$product_cat_id    = trim($_REQUEST['product_cat_id']);

	$product_from      = trim($_REQUEST['product_from']);

	$product_url       = trim($_REQUEST['product_url']);

	$product_price     = trim($_REQUEST['product_price']);

	$product_image     = $_FILES["product_image"]['name'];

	$update_id         = trim($_REQUEST['update_id']);

	if($product_title == "")

	{

		$errorstr .="Please Enter Title\n";

		$case = 0;

	}

	if($product_cat_id == "")

	{

		$errorstr .="Please Enter Review Topic\n";

		$case = 0;

	}

	else

	{

		//check category is valid

		$chk_review_topic_qry ='select cat_id as chk_review_topic from tbl_categories where cat_id="'.$product_cat_id.'" and level=5';

		$chk_review_topic_arr = $db->get_row($chk_review_topic_qry, ARRAY_A);

		$chk_review_topic     = $chk_review_topic_arr['chk_review_topic'];	

		if($chk_review_topic=="")

		{

			$errorstr .="Invalid Review Topic is selected\n";

			$case = 0;

		}

	}

	if($product_url == "")

	{

		$errorstr .="Please Enter URL\n";

		$case = 0;

	}

	if($product_price == "")

	{

		$errorstr .="Please Enter Price\n";

		$case = 0;

	}

	else

	{

		if(!is_numeric($product_price))

		{

			$errorstr .="Please Enter Numeric Value for Price\n";

			$case = 0;

		}

	}



	if($_FILES["product_image"]['name']!="")

	{

		$filename = $_FILES["product_image"]['name'];

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
			$insert_qry="INSERT INTO tbl_products SET product_cat_id='".mysqli_escape_string($db->dbh, stripslashes($product_cat_id))."',product_title='".mysqli_escape_string($db->dbh, stripslashes($product_title))."', product_from='".mysqli_escape_string($db->dbh, stripslashes($product_from))."',product_url='".mysqli_escape_string($db->dbh, stripslashes($product_url))."' ,product_price='".mysqli_escape_string($db->dbh, stripslashes($product_price))."',product_add_date='".time()."',status='1' ";

			$db->query($insert_qry);

			$last_record = mysqli_insert_id($db->dbh);

		}

		else

		{

			$update_qry ="UPDATE tbl_products SET product_cat_id='".mysqli_escape_string($db->dbh, stripslashes($product_cat_id))."',product_title='".mysqli_escape_string($db->dbh, stripslashes($product_title))."', product_from='".mysqli_escape_string($db->dbh, stripslashes($product_from))."',product_url='".mysqli_escape_string($db->dbh, stripslashes($product_url))."' ,product_price='".mysqli_escape_string($db->dbh, stripslashes($product_price))."' where product_id='".$update_id."' ";

			$db->query($update_qry);

			$last_record = $update_id;

		}

		

		if($_FILES["product_image"]['name']!="")

		{

			$select_img ="select product_image from tbl_products where product_id='".$last_record."' ";

			$result = $db->get_row($select_img, ARRAY_A);

			$old_image  = $result['product_image'];

			$imgfile =$path.$old_image;

			$thumbfile =$path.'thumb_'.$old_image;

			$thumbfile_small =$path.'small_thumb_'.$old_image;

			@unlink($imgfile);

			@unlink($thumbfile);

			@unlink($thumbfile_small);

			

			$icon_array = $_FILES["product_image"]['name'];

			$img_formats = array("jpeg", "gif", "png", "jpg","JPEG", "GIF", "PNG", "JPG");

			$allowed_size = 2; // Allowed Photo Size in MB			

			$file_temp = $_FILES["product_image"]['tmp_name'];

			$h_image_size = filesize($_FILES["product_image"]['tmp_name']);

			$h_image_size = ($h_image_size/1024)/1024;

			$h_file_name_array 	= $_FILES["user_image"];

			$h_file_ext = ltrim(strtolower(strrchr($_FILES["product_image"]['name'],'.')),'.'); 

			

			$icon_orgname = rand()."_".$_FILES["product_image"]['name'];

			$h_newthumb_name = 'thumb_'.$icon_orgname;	

			$h_small_thumb_name = 'small_thumb_'.$icon_orgname;			

			$h_photo_path = $path.$icon_orgname;

			$h_photothumb_path = $path.$h_newthumb_name;

			$h_dir = $path;

			

			if($h_image_size < $allowed_size)

			{

				copy($file_temp,$h_photo_path);	

				$a = new Thumbnail($_FILES["product_image"]['tmp_name'],241,'238',$h_dir.$h_newthumb_name);

				// creating thumbnail

				$a->create();

				

				$b = new Thumbnail($_FILES["product_image"]['tmp_name'],51,'40',$h_dir.$h_small_thumb_name);

				// creating thumbnail

				$b->create();

				

				$img_qry="UPDATE tbl_products SET product_image='".$icon_orgname."' where product_id='".$last_record."' ";

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

