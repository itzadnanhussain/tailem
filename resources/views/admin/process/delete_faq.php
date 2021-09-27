<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select faq_id from tbl_faq where faq_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$faq_id     = $select_arr['faq_id'];
	if($faq_id=="")
	{
		echo 'Error';
	}
	else
	{
		$del_qry="Delete from tbl_faq where faq_id='".$faq_id."'";
		$db->query($del_qry);
				
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>