<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select question_id from tbl_questions where question_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$question_id     = $select_arr['question_id'];
	if($question_id=="")
	{
		echo 'Error';
	}
	else
	{
		$del_qry="Delete from tbl_questions where question_id='".$question_id."'";
		$db->query($del_qry);
		
		$select_ques_qry = "select ans_id from tbl_answers where ques_id='".$question_id."'";
		$select_ques_arr = $db->get_results($select_ques_qry, ARRAY_A);
		if($select_ques_arr)
		{
			foreach($select_ques_arr as $val)
			{	
				$ans_id = $val['ans_id'];
				
				$del_report = "DELETE from tbl_answer_report where answerid = '".$del_id."' ";
				$db->query($del_report);
					 
				 $del_like = "DELETE from tbl_answer_likes where answer_id = '".$del_id."' ";
				 $db->query($del_like);
					 
				 $del_answer = "DELETE from tbl_answers where ans_id = '".$del_id."' ";
				 $db->query($del_answer);
			}
		}
		
				
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>