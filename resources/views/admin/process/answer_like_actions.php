<?php 
include("../includes/top.php");
include("../common/security.php"); 

if(!empty($_POST['answer_like_ids']) && !empty($_POST['ansid']))
{
 	if($_POST['dropdown']=='Delete') // from button name="delete"
	{
	 	$checkbox = $_POST['answer_like_ids']; //from name="checkbox[]"
	 	$countCheck = count($_POST['answer_like_ids']);
		
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_like = "DELETE from tbl_answer_likes where answer_like_id = '".$del_id."' ";
			 mysqli_query($db->dbh, $del_like);
		}
		
	    if($result)
		{		
			 $okmsg = base64_encode("Deletion Successfully Done.");
			 header('Location:'.SERVER_ADMIN_PATH."answer_likes.php?key=".$_POST['ansid']."&msg=$okmsg&case=1");
		}
		else
		{ 
			  "Error: ".mysqli_error($db->dbh);
			 header('Location:'.SERVER_ADMIN_PATH."questions.php");
		}
	}
	   
	 
}
else
{

	$errormsg = base64_encode('First select a record to perform some action');
	header('Location:'.SERVER_ADMIN_PATH."answer_likes.php?key=".$_POST['ansid']."&msg=$errormsg&case=2");
}
?>