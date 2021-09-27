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
			
			$sql = "DELETE from tbl_songs_artist where song_id = '".$del_id."' ";
			$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($mysqli));
			 
			$del_qry="Delete from  tbl_reviews where song_id='".$del_id."'";
			$db->query($del_qry);
			 
			 $sql = "DELETE from tbl_songs where id = '".$del_id."' ";
   			 $result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($mysqli));
			 
			 
		}
		
	    if($result)
		{		
			 $okmsg = base64_encode("Deletion Successfully Done.");
			 header('Location:'.SERVER_ADMIN_PATH."song_list.php?msg=$okmsg&case=1");
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
			 $qry = "select song_status from tbl_songs where id='".$del_id."' ";
			 $res = mysqli_query($db->dbh, $qry);
			 $resul=mysqli_fetch_assoc($res);
			 $status = $resul['song_status'];
			 if($status==0)
			 {
			   $status=1;
			 }
		 	 $del_id  = base64_decode($checkbox[$i]);
		     $sql = "update tbl_songs set song_status=$status where id='".$del_id."' ";
		     $result = mysqli_query($db->dbh, $sql) or die(mysqli_error($mysqli));
		
		 }
		 if($result)
		 {			
			 $okmsg = base64_encode("status changed successfully.");
			 header('Location:'.SERVER_ADMIN_PATH."song_list.php?msg=$okmsg&case=1");
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
			$qry     = "select song_status from tbl_songs where id='".$del_id."' "; 
			$res     = mysqli_query($db->dbh, $qry);
			$resul   = mysqli_fetch_assoc($res);
			$status  = $resul['song_status'];
			if($status == 1)
			{
				$status=0;
			}
	 		$del_id  = base64_decode($checkbox[$i]);
	 		 $sql = "update tbl_songs set song_status=$status where id='".$del_id."'"; 
	 		$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));
	   }
	   
	   if($result)
	   {		
			$okmsg = base64_encode('status changed successfully.');
			header('Location:'.SERVER_ADMIN_PATH."song_list.php?msg=$okmsg&case=1");
	   }
	   else
	   {
	   		echo "Error: ".mysqli_error($db->dbh);
	   }
	}
	
	if($_POST['dropdown']=='sort_ranking') // from button name="delete"
	{
		
	
		$checkbox = $_POST['ids']; // from name="checkbox[]"
	 	$countCheck = count($_POST['ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			$del_id    = base64_decode($checkbox[$i]);
			$order_num = $_REQUEST['order_'.$del_id];
			
			/*if($order_num!="" && $order_num!=0)
			{ */
	 		   $sql = "update tbl_songs_artist_album set ranking_order = '$order_num' where id='".$del_id."'"; 

	 		  $result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));
			/*} */
		}
		
		 if($result)
		 {		
			$okmsg = base64_encode('Ranking order changed successfully.');
			header('Location:'.SERVER_ADMIN_PATH."song_list_ranking.php?msg=$okmsg&case=1");
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
	header('Location:'.SERVER_ADMIN_PATH."song_list.php?msg=$errormsg&case=2");
}
?>