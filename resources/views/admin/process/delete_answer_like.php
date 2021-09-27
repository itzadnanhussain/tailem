<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select answer_like_id from tbl_answer_likes where answer_like_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$answer_like_id     = $select_arr['answer_like_id'];
	if($answer_like_id=="")
	{
		echo 'Error';
	}
	else
	{
		 $del_like = "DELETE from tbl_answer_likes where answer_id = '".$del_id."' ";
		 $db->query($del_like);
				
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>