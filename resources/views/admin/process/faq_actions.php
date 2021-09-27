<?php 
include("../includes/top.php");
include("../common/security.php"); 

if(!empty($_POST['faq_ids']))
{
 	if($_POST['dropdown']=='Delete') // from button name="delete"
	{
	 	$checkbox = $_POST['faq_ids']; //from name="checkbox[]"
	 	$countCheck = count($_POST['faq_ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_id    = base64_decode($checkbox[$i]);
			 $sql = "DELETE from tbl_faq where faq_id = '".$del_id."' ";
			 $result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($mysqli));
		}
		
	    if($result)
		{		
			 $okmsg = base64_encode("Deletion Successfully Done.");
			 header('Location:'.SERVER_ADMIN_PATH."faq_list.php?msg=$okmsg&case=1");
		}
		else
		{ 
			 echo "Error: ".mysqli_error($db->dbh);
		}
	}
	   
	
	if($_POST['dropdown']=='Active') // from button name="delete"
	{
		 $checkbox = $_POST['faq_ids']; //from name="checkbox[]"
		 $countCheck = count($_POST['faq_ids']);
		
		 for($i=0;$i<$countCheck;$i++)
		 {
			 $del_id  = base64_decode($checkbox[$i]);
			 $qry = "select status from tbl_faq where faq_id='".$del_id."' ";
			 $res = mysqli_query($db->dbh, $qry);
			 $resul=mysqli_fetch_assoc($res);
			 $status = $resul['status'];
			 if($status==0)
			 {
			   $status=1;
			 }
		 	 $del_id  = base64_decode($checkbox[$i]);
		     $sql = "update tbl_faq set status=$status where faq_id='".$del_id."' ";
		     $result = mysqli_query($db->dbh, $sql) or die(mysqli_error($mysqli));
		
		 }
		 if($result)
		 {			
			 $okmsg = base64_encode("status changed successfully.");
			 header('Location:'.SERVER_ADMIN_PATH."faq_list.php?msg=$okmsg&case=1");
		 }
		 else
		 {
		 	echo "Error: ".mysqli_error($db->dbh);
		 }
	}
	 
	if($_POST['dropdown']=='Inactive') // from button name="delete"
	{
		$checkbox = $_POST['faq_ids']; // from name="checkbox[]"
	 	$countCheck = count($_POST['faq_ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_id  = base64_decode($checkbox[$i]);
			$qry     = "select status from tbl_faq where faq_id='".$del_id."' "; 
			$res     = mysqli_query($db->dbh, $qry);
			$resul   = mysqli_fetch_assoc($res);
			$status  = $resul['status'];
			if($status == 1)
			{
				$status=0;
			}
	 		$del_id  = base64_decode($checkbox[$i]);
	 		 $sql = "update tbl_faq set status=$status where faq_id='".$del_id."'"; 
	 		$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));
	   }
	   
	   if($result)
	   {		
			$okmsg = base64_encode('status changed successfully.');
			header('Location:'.SERVER_ADMIN_PATH."faq_list.php?msg=$okmsg&case=1");
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
	header('Location:'.SERVER_ADMIN_PATH."faq_list.php?msg=$errormsg&case=2");
}
?>