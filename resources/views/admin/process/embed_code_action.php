<?php 

include("../includes/top.php");

include("../common/security.php"); 


if(!empty($_POST['embed_code_ids']))

{

 	if($_POST['dropdown']=='Delete') // from button name="delete"

	{

	 	$checkbox = $_POST['embed_code_ids']; //from name="checkbox[]"

	 	$countCheck = count($_POST['embed_code_ids']);

	

	 	for($i=0;$i<$countCheck;$i++)

		{

			$del_id     = base64_decode($checkbox[$i]);
			$sql = "DELETE from tbl_product_embed_code where embed_code_id = '".$del_id."'";

			$result = mysqli_query($db->dbh, $sql);	

		}

		

		if($result)

		{		

			 $okmsg = base64_encode("Deletion Successfully Done.");

			 header('Location:'.SERVER_ADMIN_PATH."embed_code_list.php?msg=$okmsg&case=1");

		}

		else

		{ 

			 echo "Error: ".mysqli_error($db->dbh);

		}

	}

	   

	

	if($_POST['dropdown']=='Active') // from button name="delete"

	{

		 $checkbox = $_POST['embed_code_ids']; //from name="checkbox[]"

		 $countCheck = count($_POST['embed_code_ids']);

		

		 for($i=0;$i<$countCheck;$i++)

		 {

			 $del_id  = base64_decode($checkbox[$i]);

			 $qry = "select status from tbl_product_embed_code where embed_code_id='".$del_id."'";

			 $res = mysqli_query($db->dbh, $qry);

			 $resul=mysqli_fetch_assoc($res);

			 $status = $resul['status'];

			 if($status==0)

			 {

			   $status=1;

			 }

		 	 $del_id  = base64_decode($checkbox[$i]);

		     $sql = "update tbl_product_embed_code set status=$status where embed_code_id='".$del_id."'";

		     $result = mysqli_query($db->dbh, $sql) or die(mysqli_error($mysqli));

		

		 }

		 if($result)

		 {			

			 $okmsg = base64_encode("status changed successfully.");

			 header('Location:'.SERVER_ADMIN_PATH."embed_code_list.php?msg=$okmsg&case=1");

		 }

		 else

		 {

		 	echo "Error: ".mysqli_error($db->dbh);

		 }

	}

	 

	if($_POST['dropdown']=='Inactive') // from button name="delete"

	{

		$checkbox = $_POST['embed_code_ids']; // from name="checkbox[]"

	 	$countCheck = count($_POST['embed_code_ids']);

	

	 	for($i=0;$i<$countCheck;$i++)

		{

			 $del_id  = base64_decode($checkbox[$i]);

			$qry     = "select status from tbl_product_embed_code where embed_code_id='".$del_id."'"; 

			$res     = mysqli_query($db->dbh, $qry);

			$resul   = mysqli_fetch_assoc($res);

			$status  = $resul['status'];

			if($status == 1)

			{

				$status=0;

			}

	 		$del_id  = base64_decode($checkbox[$i]);

	 		$sql = "update tbl_product_embed_code set status=$status where embed_code_id='".$del_id."'"; 

	 		$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));

	   }

	   

	   if($result)

	   {		

			$okmsg = base64_encode('status changed successfully.');

			header('Location:'.SERVER_ADMIN_PATH."embed_code_list.php?msg=$okmsg&case=1");

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

	header('Location:'.SERVER_ADMIN_PATH."embed_code_list.php?msg=$errormsg&case=2");

}

?>