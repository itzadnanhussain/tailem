<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select ans_id from tbl_answers where ans_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$ans_id     = $select_arr['ans_id'];
	if($ans_id=="")
	{
		echo 'Error';
	}
	else
	{
		
		$del_report = "DELETE from tbl_answer_report where answerid = '".$del_id."' ";
		$db->query($del_report);
			 
		 $del_like = "DELETE from tbl_answer_likes where answer_id = '".$del_id."' ";
		 $db->query($del_like);
			 
	     $del_answer = "DELETE from tbl_answers where ans_id = '".$del_id."' ";
		 $db->query($del_answer);
				
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>