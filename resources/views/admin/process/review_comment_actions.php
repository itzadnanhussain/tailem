<?php 
include("../includes/top.php");
include("../common/security.php"); 

if(!empty($_POST['comment_ids']) && !empty($_POST['reviewsid']))
{
 	if($_POST['dropdown']=='Delete') // from button name="delete"
	{
	 	$checkbox = $_POST['comment_ids']; //from name="checkbox[]"
	 	$countCheck = count($_POST['comment_ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_id    = base64_decode($checkbox[$i]);
			 $del_report = "DELETE from tbl_comment_report where c_report_comment_id = '".$del_id."' ";
			 mysqli_query($db->dbh, $del_report);
			 
			 $del_like = "DELETE from tbl_comments_likes where comment_like_comment_id = '".$del_id."' ";
			 mysqli_query($db->dbh, $del_like);
			 
			 $del_comment = "DELETE from tbl_comments where comment_id = '".$del_id."' ";
			 $result = mysqli_query($db->dbh, $del_comment); 
		}
		
	    if($result)
		{		
			 $okmsg = base64_encode("Deletion Successfully Done.");
			 header('Location:'.SERVER_ADMIN_PATH."review_comments.php?key=".$_POST['reviesid']."&msg=$okmsg&case=1");
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