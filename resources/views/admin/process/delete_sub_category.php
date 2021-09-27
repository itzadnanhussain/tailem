<?php 
include("../includes/top.php");
include("../common/security.php"); 
$path= '../../site_upload/category_images/';
if(!empty($_POST['del_id']))
{
	$select_qry = "select cat_id from tbl_categories where cat_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$cat_id     = $select_arr['cat_id'];
	if($cat_id=="")
	{
		echo 'Error';
	}
	else
	{
		$select_img = "select image_name from tbl_categories where cat_id='".$cat_id."' OR parent_id='".$cat_id."'";
		$result = $db->get_results($select_img, ARRAY_A);
		if($result)
		{
			foreach($result as $values)
			{
				$old_image  = $values['image_name'];
				$imgfile    = $path.$old_image;
				$thumbfile  =  $path.'thumb_'.$old_image;
				$thumbfile_small =$path.'small_thumb_'.$old_image;
				@unlink($imgfile);
				@unlink($thumbfile);
				@unlink($thumbfile_small);
				
				$del_qry="Delete from tbl_categories where parent_id='".$cat_id."'";
				$db->query($del_qry);
			}
		}
		$del_qry="Delete from tbl_categories where cat_id='".$cat_id."'";
		$db->query($del_qry);
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>