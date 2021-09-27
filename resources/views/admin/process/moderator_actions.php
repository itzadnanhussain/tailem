<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['ids']))
{
 	if($_POST['dropdown']=='Delete') // from button name="delete"
	{
	 	$checkbox = $_POST['ids']; //from name="checkbox[]"
	 	$countCheck = count($_POST['ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			$del_id  = base64_decode($checkbox[$i]);
			$sql = "DELETE from tbl_admin where id = '".$del_id."' and id!='1'";
			$result = mysqli_query($db->dbh, $sql);	
			
			$del_moderator_qry="Delete from tbl_moderator_rights where moderator_id='".$del_id."' and id!='1' ";
			mysqli_query($db->dbh, $del_moderator_qry);	
		}
		
		if($result)
		{		
			 $okmsg = base64_encode("Deletion Successfully Done.");
			 header('Location:'.SERVER_ADMIN_PATH."moderator_list.php?msg=$okmsg&case=1");
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
			 $qry = "select admin_status from tbl_admin where id='".$del_id."' and id!='1'";
			 $res = mysqli_query($db->dbh, $qry);
			 $resul=mysqli_fetch_assoc($res);
			 $admin_status = $resul['admin_status'];
			 if($admin_status==0)
			 {
			   $admin_status=1;
			 }
		 	 $del_id  = base64_decode($checkbox[$i]);
		     $sql = "update tbl_admin set admin_status=$admin_status where id='".$del_id."'  and id!='1'";
		     $result = mysqli_query($db->dbh, $sql) or die(mysqli_error($mysqli));
		
		 }
		 if($result)
		 {			
			 $okmsg = base64_encode("status changed successfully.");
			 header('Location:'.SERVER_ADMIN_PATH."moderator_list.php?msg=$okmsg&case=1");
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
			$qry     = "select admin_status from tbl_admin where id='".$del_id."' and id!='1' "; 
			$res     = mysqli_query($db->dbh, $qry);
			$resul   = mysqli_fetch_assoc($res);
			$admin_status  = $resul['admin_status'];
			if($admin_status == 1)
			{
				$admin_status=0;
			}
	 		$del_id  = base64_decode($checkbox[$i]);
	 		$sql = "update tbl_admin set admin_status=$admin_status where id='".$del_id."' and id!='1'"; 
	 		$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));
	   }
	   
	   if($result)
	   {		
			$okmsg = base64_encode('status changed successfully.');
			header('Location:'.SERVER_ADMIN_PATH."moderator_list.php?msg=$okmsg&case=1");
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
	header('Location:'.SERVER_ADMIN_PATH."moderator_list.php?msg=$errormsg&case=2");
}
?>