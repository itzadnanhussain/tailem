<?php 
include("../includes/top.php");
include("../common/security.php"); 
$path= '../../site_upload/user_images/';
if(!empty($_POST['user_ids']))
{
 	if($_POST['dropdown']=='Delete') // from button name="delete"
	{
	 	$checkbox = $_POST['user_ids']; //from name="checkbox[]"
	 	$countCheck = count($_POST['user_ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			$del_id     = base64_decode($checkbox[$i]);
			$select_img = "select profile_image from tbl_users where user_id='".$del_id."'";
			$result = $db->get_row($select_img, ARRAY_A);
			$old_image  = $result['profile_image'];
			$imgfile =$path.$old_image;
			$thumbfile =$path.'thumb_'.$old_image;
			$thumbfile_small =$path.'small_thumb_'.$old_image;
			@unlink($imgfile);
			@unlink($thumbfile);
			@unlink($thumbfile_small);
			
			$sql = "DELETE from tbl_users where user_id = '".$del_id."'";
			$result = mysqli_query($db->dbh, $sql);	
			
			$del_qry="Delete from tbl_likes where like_from_user_id='".$del_id."'";
			$db->query($del_qry);
			
			$del_qry="Delete from tbl_reviews where review_user_id='".$del_id."'";
			$db->query($del_qry);
			
			$del_qry="Delete from tbl_review_report where r_report_user_id='".$del_id."'";
			$db->query($del_qry);
			
			$del_qry="Delete from tbl_comments where comment_user_id='".$del_id."'";
			$db->query($del_qry);
			
			
			
		}
		
		if($result)
		{		
			 $okmsg = base64_encode("Deletion Successfully Done.");
			 header('Location:'.SERVER_ADMIN_PATH."users_list?msg=$okmsg&case=1");
		}
		else
		{ 
			 echo "Error: ".mysqli_error($db->dbh);
		}
	}
	   
	
	if($_POST['dropdown']=='Active') // from button name="delete"
	{
		 $checkbox = $_POST['user_ids']; //from name="checkbox[]"
		 $countCheck = count($_POST['user_ids']);
		
		 for($i=0;$i<$countCheck;$i++)
		 {
			 $del_id  = base64_decode($checkbox[$i]);
			 $qry = "select status from tbl_users where user_id='".$del_id."'";
			 $res = mysqli_query($db->dbh, $qry);
			 $resul=mysqli_fetch_assoc($res);
			 $status = $resul['status'];
			 if($status==0)
			 {
			   $status=1;
			 }
		 	 $del_id  = base64_decode($checkbox[$i]);
		     $sql = "update tbl_users set status=$status where user_id='".$del_id."'";
		     $result = mysqli_query($db->dbh, $sql) or die(mysqli_error($mysqli));
		
		 }
		 if($result)
		 {			
			 $okmsg = base64_encode("status changed successfully.");
			 header('Location:'.SERVER_ADMIN_PATH."users_list?msg=$okmsg&case=1");
		 }
		 else
		 {
		 	echo "Error: ".mysqli_error($db->dbh);
		 }
	}
	 
	if($_POST['dropdown']=='Inactive') // from button name="delete"
	{
		$checkbox = $_POST['user_ids']; // from name="checkbox[]"
	 	$countCheck = count($_POST['user_ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_id  = base64_decode($checkbox[$i]);
			$qry     = "select status from tbl_users where user_id='".$del_id."'"; 
			$res     = mysqli_query($db->dbh, $qry);
			$resul   = mysqli_fetch_assoc($res);
			$status  = $resul['status'];
			if($status == 1)
			{
				$status=0;
			}
	 		$del_id  = base64_decode($checkbox[$i]);
	 		$sql = "update tbl_users set status=$status where user_id='".$del_id."'"; 
	 		$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));
	   }
	   
	   if($result)
	   {		
			$okmsg = base64_encode('status changed successfully.');
			header('Location:'.SERVER_ADMIN_PATH."users_list?msg=$okmsg&case=1");
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
	header('Location:'.SERVER_ADMIN_PATH."users_list?msg=$errormsg&case=2");
}
?>