<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select c_report_id from tbl_comment_report where c_report_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$c_report_id     = $select_arr['c_report_id'];
	if($c_report_id=="")
	{
		echo 'Error';
	}
	else
	{
		$del_qry="Delete from tbl_comment_report where c_report_id='".$c_report_id."'";
		$db->query($del_qry);
				
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>