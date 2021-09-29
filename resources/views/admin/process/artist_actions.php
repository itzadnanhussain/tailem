<?php 
include("../includes/top.php");
include("../common/security.php"); 

$path			= '../../site_upload/artist_images/'; 
if(!empty($_POST['ids']))
{
 	if($_POST['dropdown']=='Delete') // from button name="delete"
	{
	 	$checkbox = $_POST['ids']; //from name="checkbox[]"
	 	$countCheck = count($_POST['ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_id    = base64_decode($checkbox[$i]);
			
			$select_img ="select artist_img from tbl_artists where id='".$del_id."' ";
			$result = $db->get_row($select_img, ARRAY_A);
			
			$old_image  = $result['artist_img'];
			if($old_image!="")
			{
				$imgfile =$path.$old_image;
				$thumbfile =$path.'thumb_'.$old_image;
				$thumbfile_small =$path.'small_thumb_'.$old_image;
				@unlink($imgfile);
				@unlink($thumbfile);
				@unlink($thumbfile_small);
			}
			
			 $sql = "DELETE from tbl_artists where id = '".$del_id."' ";
			 $result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($mysqli));
			 
	
		
		$del_qry="Delete from tbl_songs_artist_album where artist_id='".$del_id."'";
		$db->query($del_qry);
		
		$del_qry="Delete from  tbl_songs_artist where artist_id='".$del_id."'";
		$db->query($del_qry);
		
		$del_qry="Delete from  tbl_artist_album where album_artist_id='".$del_id."'";
		$db->query($del_qry);
		
		$del_qry="Delete from tbl_likes where like_id='".$del_id."' AND like_type = 'artist'";
		$db->query($del_qry);
		
		$del_qry="Delete from tbl_reviews where artist_id='".$del_id."'";
		$db->query($del_qry);
		
		$del_qry="Delete from tbl_comments where comment_artist_id='".$del_id."'";
		$db->query($del_qry);
		
		$del_qry="Delete from  tbl_songs_artist where artist_id='".$del_id."'";
		$db->query($del_qry);
		
	
			 
			 
		}
		
	    if($result)
		{		
			 $okmsg = base64_encode("Deletion Successfully Done.");
			 header('Location:'.SERVER_ADMIN_PATH."artist_list?msg=$okmsg&case=1");
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
			 $qry = "select artist_status from tbl_artists where id='".$del_id."' ";
			 $res = mysqli_query($db->dbh, $qry);
			 $resul=mysqli_fetch_assoc($res);
			 $status = $resul['artist_status'];
			 if($status==0)
			 {
			   $status=1;
			 }
		 	 $del_id  = base64_decode($checkbox[$i]);
		     $sql = "update tbl_artists set artist_status=$status where id='".$del_id."' ";
		     $result = mysqli_query($db->dbh, $sql) or die(mysqli_error($mysqli));
		
		 }
		 if($result)
		 {			
			 $okmsg = base64_encode("status changed successfully.");
			 header('Location:'.SERVER_ADMIN_PATH."artist_list?msg=$okmsg&case=1");
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
			$qry     = "select artist_status from tbl_artists where id='".$del_id."' "; 
			$res     = mysqli_query($db->dbh, $qry);
			$resul   = mysqli_fetch_assoc($res);
			$status  = $resul['artist_status'];
			if($status == 1)
			{
				$status=0;
			}
	 		$del_id  = base64_decode($checkbox[$i]);
	 		 $sql = "update tbl_artists set artist_status=$status where id='".$del_id."'"; 
	 		$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));
	   }
	   
	   if($result)
	   {		
			$okmsg = base64_encode('status changed successfully.');
			header('Location:'.SERVER_ADMIN_PATH."artist_list?msg=$okmsg&case=1");
	   }
	   else
	   {
	   		echo "Error: ".mysqli_error($db->dbh);
	   }
	}
	
	if($_POST['dropdown']=='popular_artist') // from button name="delete"
	{
		 $checkbox = $_POST['ids']; //from name="checkbox[]"
		 $countCheck = count($_POST['ids']);
		
		 for($i=0;$i<$countCheck;$i++)
		 {
			 $del_id  = base64_decode($checkbox[$i]);
			 $qry = "select popular_artist from tbl_artists where id='".$del_id."' ";
			 $res = mysqli_query($db->dbh, $qry);
			 $resul=mysqli_fetch_assoc($res);
			 $status = $resul['popular_artist'];
			 if($status==0)
			 {
			   $status=1;
			 }
		 	 $del_id  = base64_decode($checkbox[$i]);
		     $sql = "update tbl_artists set popular_artist=$status where id='".$del_id."' ";
		     $result = mysqli_query($db->dbh, $sql) or die(mysqli_error($mysqli));
		
		 }
		 if($result)
		 {			
			 $okmsg = base64_encode("Popular artist status changed successfully.");
			 header('Location:'.SERVER_ADMIN_PATH."artist_list?msg=$okmsg&case=1");
		 }
		 else
		 {
		 	echo "Error: ".mysqli_error($db->dbh);
		 }
	}
	
	
	if($_POST['dropdown']=='not_popular_artist') // from button name="delete"
	{
		$checkbox = $_POST['ids']; // from name="checkbox[]"
	 	$countCheck = count($_POST['ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_id  = base64_decode($checkbox[$i]);
			$qry     = "select popular_artist from tbl_artists where id='".$del_id."' "; 
			$res     = mysqli_query($db->dbh, $qry);
			$resul   = mysqli_fetch_assoc($res);
			$status  = $resul['popular_artist'];
			if($status == 1)
			{
				$status=0;
			}
	 		$del_id  = base64_decode($checkbox[$i]);
	 		$sql = "update tbl_artists set popular_artist=$status where id='".$del_id."'"; 
	 		$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));
	   }
	   
	   if($result)
	   {		
			$okmsg = base64_encode('Popular artist status changed successfully.');
			header('Location:'.SERVER_ADMIN_PATH."artist_list?msg=$okmsg&case=1");
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
	header('Location:'.SERVER_ADMIN_PATH."artist_list?msg=$errormsg&case=2");
}
?>