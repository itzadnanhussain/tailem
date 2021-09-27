<?php 
include("../includes/top.php");
include("../common/security.php"); 
$path= '../../site_upload/slideshow_images/';
if(!empty($_POST['slideshow_ids']))
{
 	if($_POST['dropdown']=='Delete') // from button name="delete"
	{
		if($top_slider_module_delete!="Yes")
		{
			$errormsg = base64_encode('You have no right to delete these records');
			header('Location:'.SERVER_ADMIN_PATH."slide_show_list.php?msg=$errormsg&case=2");
		}
	 	$checkbox = $_POST['slideshow_ids']; //from name="checkbox[]"
	 	$countCheck = count($_POST['slideshow_ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			$del_id     = base64_decode($checkbox[$i]);
			$select_img = "select slideshow_image from tbl_slideshow where slideshow_id='".$del_id."'";
			$result = $db->get_row($select_img, ARRAY_A);
			$old_image  = $result['slideshow_image'];
			$imgfile =$path.$old_image;
			$thumbfile =$path.'thumb_'.$old_image;
			$thumbfile_small =$path.'small_thumb_'.$old_image;
			@unlink($imgfile);
			@unlink($thumbfile);
			@unlink($thumbfile_small);
			$sql = "DELETE from tbl_slideshow where slideshow_id = '".$del_id."'";
			$result = mysqli_query($db->dbh, $sql);	
		}
		
		if($result)
		{		
			 $okmsg = base64_encode("Deletion Successfully Done.");
			 header('Location:'.SERVER_ADMIN_PATH."slide_show_list.php?msg=$okmsg&case=1");
		}
		else
		{ 
			 echo "Error: ".mysqli_error($db->dbh);
		}
	}
	   
	
	if($_POST['dropdown']=='Active') // from button name="delete"
	{
		 $checkbox = $_POST['slideshow_ids']; //from name="checkbox[]"
		 $countCheck = count($_POST['slideshow_ids']);
		
		 for($i=0;$i<$countCheck;$i++)
		 {
			 $del_id  = base64_decode($checkbox[$i]);
			 $qry = "select slideshow_status from tbl_slideshow where slideshow_id='".$del_id."'";
			 $res = mysqli_query($db->dbh, $qry);
			 $resul=mysqli_fetch_assoc($res);
			 $slideshow_status = $resul['slideshow_status'];
			 if($slideshow_status==0)
			 {
			   $slideshow_status=1;
			 }
		 	 $del_id  = base64_decode($checkbox[$i]);
		     $sql = "update tbl_slideshow set slideshow_status=$slideshow_status where slideshow_id='".$del_id."'";
		     $result = mysqli_query($db->dbh, $sql) or die(mysqli_error($mysqli));
		
		 }
		 if($result)
		 {			
			 $okmsg = base64_encode("status changed successfully.");
			 header('Location:'.SERVER_ADMIN_PATH."slide_show_list.php?msg=$okmsg&case=1");
		 }
		 else
		 {
		 	echo "Error: ".mysqli_error($db->dbh);
		 }
	}
	 
	if($_POST['dropdown']=='Inactive') // from button name="delete"
	{
		$checkbox = $_POST['slideshow_ids']; // from name="checkbox[]"
	 	$countCheck = count($_POST['slideshow_ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_id  = base64_decode($checkbox[$i]);
			$qry     = "select slideshow_status from tbl_slideshow where slideshow_id='".$del_id."'"; 
			$res     = mysqli_query($db->dbh, $qry);
			$resul   = mysqli_fetch_assoc($res);
			$slideshow_status  = $resul['slideshow_status'];
			if($slideshow_status == 1)
			{
				$slideshow_status=0;
			}
	 		$del_id  = base64_decode($checkbox[$i]);
	 		$sql = "update tbl_slideshow set slideshow_status=$slideshow_status where slideshow_id='".$del_id."'"; 
	 		$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));
	   }
	   
	   if($result)
	   {		
			$okmsg = base64_encode('status changed successfully.');
			header('Location:'.SERVER_ADMIN_PATH."slide_show_list.php?msg=$okmsg&case=1");
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
	header('Location:'.SERVER_ADMIN_PATH."slide_show_list.php?msg=$errormsg&case=2");
}
?>