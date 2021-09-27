<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select ads_id from tbl_mobile_advertisement where ads_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$ads_id    = $select_arr['ads_id'];
	if($ads_id=="")
	{
		echo 'Error';
	}
	else
	{
		$del_qry="Delete from tbl_mobile_advertisement where ads_id='".$ads_id."'";
		$db->query($del_qry);
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>