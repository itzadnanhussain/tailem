<?php 
include("../includes/top.php");
include("../common/security.php"); 
$path= '../../site_upload/category_images/';
$icon_folder= '../../site_upload/categories_icons/';
if(!empty($_POST['cat_ids']))
{
 	if($_POST['dropdown']=='Delete') // from button name="delete"
	{
	 	$checkbox = $_POST['cat_ids']; //from name="checkbox[]"
	 	$countCheck = count($_POST['cat_ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			$del_id     = base64_decode($checkbox[$i]);
			$select_img = "select image_name,icon_name from tbl_categories where cat_id='".$del_id."'";
			$result = $db->get_row($select_img, ARRAY_A);

			//delete image
			$old_image  = $result['image_name'];
			$imgfile =$path.$old_image;
			$thumbfile =$path.'thumb_'.$old_image;
			$thumbfile_small =$path.'small_thumb_'.$old_image;
			@unlink($imgfile);
			@unlink($thumbfile);
			@unlink($thumbfile_small);
			
			//delete Icon
			$old_icon     = $result['icon_name'];
			$icon_file    = $icon_folder.$old_icon;
			$thumb_icon   =  $icon_folder.'thumb_'.$old_icon;
			$small_thumb_icon =$icon_folder.'small_thumb_'.$old_icon;
			@unlink($icon_file);
			@unlink($thumb_icon);
			@unlink($small_thumb_icon);
			
			$sql = "DELETE from tbl_categories where parent_id = '".$del_id."'";
			$result = mysqli_query($db->dbh, $sql);
			
			$select_images = "select image_name from tbl_categories where parent_id='".$del_id."'";
			$result_images = $db->get_results($select_images, ARRAY_A);
			if($result_images)
			{
				foreach($result_images as $values)
				{
					$old_image  = $values['image_name'];
					$imgfile =$path.$old_image;
					$thumbfile =$path.'thumb_'.$old_image;
					$thumbfile_small =$path.'small_thumb_'.$old_image;
					@unlink($imgfile);
					@unlink($thumbfile);
					@unlink($thumbfile_small);
					
				}
			}
			$sql = "DELETE from tbl_categories where cat_id = '".$del_id."' OR parent_id = '".$del_id."'";
			$result = mysqli_query($db->dbh, $sql);
		}
		
		$sql = "DELETE from tbl_categories where cat_id = '".$del_id."' OR parent_id = '".$del_id."'";
		$result = mysqli_query($db->dbh, $sql);
	    
		if($result)
		{		
			 $okmsg = base64_encode("Deletion Successfully Done.");
			 header('Location:'.SERVER_ADMIN_PATH."main_cat_list.php?msg=$okmsg&case=1");
		}
		else
		{ 
			 echo "Error: ".mysqli_error($db->dbh);
		}
	}
	   
	
	if($_POST['dropdown']=='Active') // from button name="delete"
	{
		 $checkbox = $_POST['cat_ids']; //from name="checkbox[]"
		 $countCheck = count($_POST['cat_ids']);
		
		 for($i=0;$i<$countCheck;$i++)
		 {
			 $del_id  = base64_decode($checkbox[$i]);
			 $qry = "select status from tbl_categories where cat_id='".$del_id."' ";
			 $res = mysqli_query($db->dbh, $qry);
			 $resul=mysqli_fetch_assoc($res);
			 $status = $resul['status'];
			 if($status==0)
			 {
			   $status=1;
			 }
		 	 $del_id  = base64_decode($checkbox[$i]);
		     $sql = "update tbl_categories set status=$status where cat_id='".$del_id."'";
		     $result = mysqli_query($db->dbh, $sql) or die(mysqli_error($mysqli));
		
		 }
		 if($result)
		 {			
			 $okmsg = base64_encode("status changed successfully.");
			 header('Location:'.SERVER_ADMIN_PATH."main_cat_list.php?msg=$okmsg&case=1");
		 }
		 else
		 {
		 	echo "Error: ".mysqli_error($db->dbh);
		 }
	}
	 
	if($_POST['dropdown']=='Inactive') // from button name="delete"
	{
		$checkbox = $_POST['cat_ids']; // from name="checkbox[]"
	 	$countCheck = count($_POST['cat_ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			$del_id  = base64_decode($checkbox[$i]);
		 	//$qry     = "select status from tbl_categories where cat_id='".$del_id."' OR parent_id = '".$del_id."'"; 
			$qry     = "select status from tbl_categories where cat_id='".$del_id."' "; 
			$res     = mysqli_query($db->dbh, $qry);
			$resul   = mysqli_fetch_assoc($res);
			$status  = $resul['status'];
			if($status == 1)
			{
				$status=0;
			}
	 		$del_id  = base64_decode($checkbox[$i]);
	 		//$sql = "update tbl_categories set status=$status where cat_id='".$del_id."' OR parent_id = '".$del_id."'"; 
	 		$sql = "update tbl_categories set status=$status where cat_id='".$del_id."'";
			$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));
	   }
	   
	   if($result)
	   {		
			$okmsg = base64_encode('status changed successfully.');
			header('Location:'.SERVER_ADMIN_PATH."main_cat_list.php?msg=$okmsg&case=1");
	   }
	   else
	   {
	   		echo "Error: ".mysqli_error($db->dbh);
	   }
	}
}
else
{
	$errormsg = base64_encode('First select a record to perform some action');
	header('Location:'.SERVER_ADMIN_PATH."main_cat_list.php?msg=$errormsg&case=2");
}
?>