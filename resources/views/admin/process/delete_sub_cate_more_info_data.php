<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select more_info_id from tbl_categories_more_info where more_info_id='".$_POST['del_id']."' ";
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$more_info_id     = $select_arr['more_info_id']; 
	if($more_info_id == "")
	{
		echo 'Error';
	}
	else
	{
		$del_qry="Delete from tbl_categories_more_info where more_info_id='".$more_info_id."'";  
		$db->query($del_qry);
				
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>