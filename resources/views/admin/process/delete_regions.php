<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select region_id from tbl_regions where region_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$region_id  = $select_arr['region_id'];
	if($region_id=="")
	{
		echo 'Error';
	}
	else
	{
		$del_qry="Delete from tbl_regions where region_id='".$_POST['del_id']."'";
		$db->query($del_qry);
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>