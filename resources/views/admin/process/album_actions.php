<?php 
include("../includes/top.php");
include("../common/security.php"); 
$path			= '../../site_upload/album_images/';

if(!empty($_POST['ids']))
{
 	if($_POST['dropdown']=='Delete') // from button name="delete"
	{
	 	$checkbox = $_POST['ids']; //from name="checkbox[]"
	 	$countCheck = count($_POST['ids']);
		$artist_id  = base64_decode($_REQUEST['artist_id']); 
		 
		 
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_id    = base64_decode($checkbox[$i]);
			
			$select_img ="select album_picture from tbl_artist_album where id='".$del_id."' AND album_artist_id = '$artist_id'";
			$result = $db->get_row($select_img, ARRAY_A);
			
			$old_image  = $result['album_picture'];
			if($old_image!="")
			{
				$imgfile =$path.$old_image;
				$thumbfile =$path.'thumb_'.$old_image;
				$thumbfile_small =$path.'small_thumb_'.$old_image;
				@unlink($imgfile);
				@unlink($thumbfile);
				@unlink($thumbfile_small);
			}
			
			 $sql = "DELETE from tbl_artist_album where id = '".$del_id."' ";
			 $result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($mysqli));
			 
			 
		}
		
	    if($result)
		{		
			 $okmsg = base64_encode("Deletion Successfully Done.");
			 header('Location:'.SERVER_ADMIN_PATH."artist_album_list.php?artist_id=".$_REQUEST['artist_id']."&msg=$okmsg&case=1");
		}
		else
		{ 
			 echo "Error: ".mysqli_error($db->dbh);
		}
	}
	   
	
	if($_POST['dropdown']=='Active') // from button name="delete"
	{
		 $checkbox = $_POST['ids']; //from name="checkbox[]"
		 $countCheck = count($_POST['ids']);
		
		 for($i=0;$i<$countCheck;$i++)
		 {
			 $del_id  = base64_decode($checkbox[$i]);
			 $qry = "select album_status from tbl_artist_album where id='".$del_id."' ";
			 $res = mysqli_query($db->dbh, $qry);
			 $resul=mysqli_fetch_assoc($res);
			 $status = $resul['album_status'];
			 if($status==0)
			 {
			   $status=1;
			 }
		 	 $del_id  = base64_decode($checkbox[$i]);
		     $sql = "update tbl_artist_album set album_status=$status where id='".$del_id."' ";
		     $result = mysqli_query($db->dbh, $sql) or die(mysqli_error($mysqli));
		
		 }
		 if($result)
		 {			
			 $okmsg = base64_encode("status changed successfully.");
			 header('Location:'.SERVER_ADMIN_PATH."artist_album_list.php?artist_id=".$_REQUEST['artist_id']."&msg=$okmsg&case=1");
		 }
		 else
		 {
		 	echo "Error: ".mysqli_error($db->dbh);
		 }
	}
	 
	if($_POST['dropdown']=='Inactive') // from button name="delete"
	{
		$checkbox = $_POST['ids']; // from name="checkbox[]"
	 	$countCheck = count($_POST['ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_id  = base64_decode($checkbox[$i]);
			$qry     = "select album_status from tbl_artist_album where id='".$del_id."' "; 
			$res     = mysqli_query($db->dbh, $qry);
			$resul   = mysqli_fetch_assoc($res);
			$status  = $resul['album_status'];
			
			if($status == 1)
			{
				$status=0;
			}
	 		$del_id  = base64_decode($checkbox[$i]);
	 		$sql = "update tbl_artist_album set album_status=$status where id='".$del_id."'"; 
	 		$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));
	   }
	   
	   if($result)
	   {		
			$okmsg = base64_encode('status changed successfully.');
			header('Location:'.SERVER_ADMIN_PATH."artist_album_list.php?artist_id=".$_REQUEST['artist_id']."&msg=$okmsg&case=1");
	   }
	   else
	   {
	   		echo "Error: ".mysqli_error($db->dbh);
	   }
	}
	
	
	if($_POST['dropdown']=='popular_album') // from button name="delete"
	{
		 $checkbox = $_POST['ids']; //from name="checkbox[]"
		 $countCheck = count($_POST['ids']);
		
		 for($i=0;$i<$countCheck;$i++)
		 {
			 $del_id  = base64_decode($checkbox[$i]);
			 $qry = "select popular_album from tbl_artist_album where id='".$del_id."' ";
			 $res = mysqli_query($db->dbh, $qry);
			 $resul=mysqli_fetch_assoc($res);
			 $status = $resul['popular_album'];
			 if($status==0)
			 {
			   $status=1;
			 }
		 	 $del_id  = base64_decode($checkbox[$i]);
		     $sql = "update tbl_artist_album set popular_album=$status where id='".$del_id."' ";
		     $result = mysqli_query($db->dbh, $sql) or die(mysqli_error($mysqli));
		
		 }
		 if($result)
		 {			
			 $okmsg = base64_encode("Popular album status changed successfully.");
			 header('Location:'.SERVER_ADMIN_PATH."artist_album_list.php?artist_id=".$_REQUEST['artist_id']."&msg=$okmsg&case=1");
		 }
		 else
		 {
		 	echo "Error: ".mysqli_error($db->dbh);
		 }
	}
	
	
	if($_POST['dropdown']=='not_popular_album') // from button name="delete"
	{
		$checkbox = $_POST['ids']; // from name="checkbox[]"
	 	$countCheck = count($_POST['ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_id  = base64_decode($checkbox[$i]);
			$qry     = "select popular_album from tbl_artist_album where id='".$del_id."' "; 
			$res     = mysqli_query($db->dbh, $qry);
			$resul   = mysqli_fetch_assoc($res);
			$status  = $resul['popular_album'];
			
			if($status == 1)
			{
				$status=0;
			}
	 		$del_id  = base64_decode($checkbox[$i]);
	 		$sql = "update tbl_artist_album set popular_album=$status where id='".$del_id."'"; 
	 		$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));
	   }
	   
	   if($result)
	   {		
			$okmsg = base64_encode('Popular album status changed successfully.');
			header('Location:'.SERVER_ADMIN_PATH."artist_album_list.php?artist_id=".$_REQUEST['artist_id']."&msg=$okmsg&case=1");
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
	header('Location:'.SERVER_ADMIN_PATH."artist_album_list.php?artist_id=".$_REQUEST['artist_id']."&msg=$errormsg&case=2");
}
