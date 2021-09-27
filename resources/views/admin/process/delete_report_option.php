<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select report_chk_box_id from tbl_reports_checkbox where report_chk_box_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$report_chk_box_id     = $select_arr['report_chk_box_id'];
	if($report_chk_box_id=="")
	{
		echo 'Error';
	}
	else
	{
		$del_qry="Delete from tbl_reports_checkbox where report_chk_box_id='".$report_chk_box_id."'";
		$db->query($del_qry);
				
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>