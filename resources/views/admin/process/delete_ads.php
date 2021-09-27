<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select ad_id from tbl_advertisement where ad_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$ad_id    = $select_arr['ad_id'];
	if($ad_id=="")
	{
		echo 'Error';
	}
	else
	{
		$del_qry="Delete from tbl_advertisement where ad_id='".$ad_id."'";
		$db->query($del_qry);
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>