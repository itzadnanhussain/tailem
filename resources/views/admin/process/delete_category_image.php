<?php 

include("../includes/top.php");

include("../common/security.php"); 

$path= '../../site_upload/category_slider_images/';

if(!empty($_POST['del_id']))

{

	$select_qry = "select cat_img_id from tbl_category_images where cat_img_id='".$_POST['del_id']."' ";	

	$select_arr = $db->get_row($select_qry,ARRAY_A);

	$cat_img_id     = $select_arr['cat_img_id'];

	if($cat_img_id=="")

	{

		echo 'Error';

	}

	else

	{

		$select_img = "select cat_img_name from tbl_category_images where cat_img_id='".$cat_img_id."'";

		$result = $db->get_row($select_img, ARRAY_A);

		if($result)

		{

				$old_image  = $result['cat_img_name'];

				$imgfile    = $path.$old_image;

				$thumbfile  =  $path.'thumb_'.$old_image;

				$thumbfile_small =$path.'small_thumb_'.$old_image;

				@unlink($imgfile);

				@unlink($thumbfile);

				@unlink($thumbfile_small);

				

				$del_qry="Delete from tbl_category_images where cat_img_id='".$cat_img_id."'";

				$db->query($del_qry);

		}

				

		echo 'done';

	}

}

else

{

	echo 'Error';

}

?>