<?php 

include("../includes/top.php");

include("../common/security.php"); 

$path= '../../site_upload/product_images/';

if(!empty($_POST['product_ids']))

{

 	if($_POST['dropdown']=='Delete') // from button name="delete"

	{

	 	$checkbox = $_POST['product_ids']; //from name="checkbox[]"

	 	$countCheck = count($_POST['product_ids']);

	

	 	for($i=0;$i<$countCheck;$i++)

		{

			$del_id     = base64_decode($checkbox[$i]);

			$select_img = "select product_image from tbl_products where product_id='".$del_id."'";

			$result = $db->get_row($select_img, ARRAY_A);

			$old_image  = $result['product_image'];

			$imgfile =$path.$old_image;

			$thumbfile =$path.'thumb_'.$old_image;

			$thumbfile_small =$path.'small_thumb_'.$old_image;

			@unlink($imgfile);

			@unlink($thumbfile);

			@unlink($thumbfile_small);

			$sql = "DELETE from tbl_products where product_id = '".$del_id."'";

			$result = mysqli_query($db->dbh, $sql);	

		}

		

		if($result)

		{		

			 $okmsg = base64_encode("Deletion Successfully Done.");

			 header('Location:'.SERVER_ADMIN_PATH."product_list.php?msg=$okmsg&case=1");

		}

		else

		{ 

			 echo "Error: ".mysqli_error($db->dbh);

		}

	}

	   

	

	if($_POST['dropdown']=='Active') // from button name="delete"

	{

		 $checkbox = $_POST['product_ids']; //from name="checkbox[]"

		 $countCheck = count($_POST['product_ids']);

		

		 for($i=0;$i<$countCheck;$i++)

		 {

			 $del_id  = base64_decode($checkbox[$i]);

			 $qry = "select status from tbl_products where product_id='".$del_id."'";

			 $res = mysqli_query($db->dbh, $qry);

			 $resul=mysqli_fetch_assoc($res);

			 $status = $resul['status'];

			 if($status==0)

			 {

			   $status=1;

			 }

		 	 $del_id  = base64_decode($checkbox[$i]);

		     $sql = "update tbl_products set status=$status where product_id='".$del_id."'";

		     $result = mysqli_query($db->dbh, $sql) or die(mysqli_error($mysqli));

		

		 }

		 if($result)

		 {			

			 $okmsg = base64_encode("status changed successfully.");

			 header('Location:'.SERVER_ADMIN_PATH."product_list.php?msg=$okmsg&case=1");

		 }

		 else

		 {

		 	echo "Error: ".mysqli_error($db->dbh);

		 }

	}

	 

	if($_POST['dropdown']=='Inactive') // from button name="delete"

	{

		$checkbox = $_POST['product_ids']; // from name="checkbox[]"

	 	$countCheck = count($_POST['product_ids']);

	

	 	for($i=0;$i<$countCheck;$i++)

		{

			 $del_id  = base64_decode($checkbox[$i]);

			$qry     = "select status from tbl_products where product_id='".$del_id."'"; 

			$res     = mysqli_query($db->dbh, $qry);

			$resul   = mysqli_fetch_assoc($res);

			$status  = $resul['status'];

			if($status == 1)

			{

				$status=0;

			}

	 		$del_id  = base64_decode($checkbox[$i]);

	 		$sql = "update tbl_products set status=$status where product_id='".$del_id."'"; 

	 		$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));

	   }

	   

	   if($result)

	   {		

			$okmsg = base64_encode('status changed successfully.');

			header('Location:'.SERVER_ADMIN_PATH."product_list.php?msg=$okmsg&case=1");

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

	header('Location:'.SERVER_ADMIN_PATH."product_list.php?msg=$errormsg&case=2");

}

?>