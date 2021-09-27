<?php 
include("../includes/top.php");
include("../common/security.php"); 
$path= '../../site_upload/product_images/';
if(!empty($_POST['del_id']))
{
	$select_qry = "select product_id from tbl_products where product_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$product_id     = $select_arr['product_id'];
	if($product_id=="")
	{
		echo 'Error';
	}
	else
	{
		$select_img = "select product_image from tbl_products where product_id='".$product_id."'";
		$result = $db->get_row($select_img, ARRAY_A);
		if($result)
		{
				$old_image  = $result['product_image'];
				$imgfile    = $path.$old_image;
				$thumbfile  =  $path.'thumb_'.$old_image;
				$thumbfile_small =$path.'small_thumb_'.$old_image;
				@unlink($imgfile);
				@unlink($thumbfile);
				@unlink($thumbfile_small);
				
				$del_qry="Delete from tbl_products where product_id='".$product_id."'";
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