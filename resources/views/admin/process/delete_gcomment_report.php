<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select r_report_id from tbl_review_report where r_report_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$gc_report_id     = $select_arr['r_report_id'];
	if($gc_report_id=="")
	{
		echo 'Error';
	}
	else
	{
		$del_qry="Delete from tbl_review_report where r_report_id='".$gc_report_id."'";
		$db->query($del_qry);
				
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>