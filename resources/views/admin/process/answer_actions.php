<?php 
include("../includes/top.php");
include("../common/security.php"); 

if(!empty($_POST['ans_ids']) && !empty($_POST['questionid']))
{
 	if($_POST['dropdown']=='Delete') // from button name="delete"
	{
	 	$checkbox = $_POST['ans_ids']; //from name="checkbox[]"
	 	$countCheck = count($_POST['ans_ids']);
	
	 	for($i=0;$i<$countCheck;$i++)
		{
			 $del_id    = base64_decode($checkbox[$i]);
			 $del_report = "DELETE from tbl_answer_report where answerid = '".$del_id."' ";
			 mysqli_query($db->dbh, $del_report);
			 
			 $del_like = "DELETE from tbl_answer_likes where answer_id = '".$del_id."' ";
			 mysqli_query($db->dbh, $del_like);
			 
			 $del_answer = "DELETE from tbl_answers where ans_id = '".$del_id."' ";
			 
			 $result = mysqli_query($db->dbh, $del_answer); 
		}
		
	    if($result)
		{		
			 $okmsg = base64_encode("Deletion Successfully Done.");
			 header('Location:'.SERVER_ADMIN_PATH."question_answers.php?key=".$_POST['questionid']."&msg=$okmsg&case=1");
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
	header('Location:'.SERVER_ADMIN_PATH."question_answers.php?key=".$_POST['questionid']."&msg=$errormsg&case=2");
}
?>