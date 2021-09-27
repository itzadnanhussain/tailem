<?php 
include("../includes/top.php");
include("../common/security.php"); 
$path= '../../site_upload/slideshow_images/';
if($top_slider_module_delete!="Yes")
{
	echo 'Right-Error';
	exit;
}
if(!empty($_POST['del_id']))
{
	$select_qry = "select slideshow_id from tbl_slideshow where slideshow_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$slideshow_id    = $select_arr['slideshow_id'];
	if($slideshow_id=="")
	{
		echo 'Error';
	}
	else
	{
		$select_img = "select slideshow_image from tbl_slideshow where slideshow_id='".$slideshow_id."'";
		$result = $db->get_row($select_img, ARRAY_A);
		if($result)
		{
				$old_image  = $result['slideshow_image'];
				$imgfile    = $path.$old_image;
				$thumbfile  =  $path.'thumb_'.$old_image;
				$thumbfile_small =$path.'small_thumb_'.$old_image;
				@unlink($imgfile);
				@unlink($thumbfile);
				@unlink($thumbfile_small);
				
				$del_qry="Delete from tbl_slideshow where slideshow_id='".$slideshow_id."'";
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