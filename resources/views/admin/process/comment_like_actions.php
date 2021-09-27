<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['comment_like_ids']) && !empty($_POST['commentids']) && !empty($_POST['reviewsid']))
{
 	if($_POST['dropdown']=='Delete') // from button name="delete"
	{
	 	$checkbox = $_POST['comment_like_ids']; //from name="checkbox[]"
	 	$countCheck = count($_POST['comment_like_ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_id    = base64_decode($checkbox[$i]);
			 $sql = "DELETE from tbl_comments_likes where comment_like_id = '".$del_id."' ";
			 $result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($mysqli));
		}
	    if($result)
		{		
			 $okmsg = base64_encode("Deletion Successfully Done.");
			 header('Location:'.SERVER_ADMIN_PATH."comments_likes.php?key=".$_POST['commentids']."&review=".$_POST['reviewsid']."");
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