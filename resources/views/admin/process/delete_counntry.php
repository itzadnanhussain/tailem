<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select country_id from tbl_countries where country_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$country_id  = $select_arr['country_id'];
	if($country_id=="")
	{
		echo 'Error';
	}
	else
	{
		$del_qry="Delete from tbl_countries where country_id='".$country_id."'";
		$db->query($del_qry);
		
		$del_qry="Delete from tbl_regions where country_id='".$country_id."'";
		$db->query($del_qry);
		
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>