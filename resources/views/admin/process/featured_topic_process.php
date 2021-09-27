<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['review_topic_id']))
{
	$cat_id = base64_decode($_POST['review_topic_id']);
	$count_qry = "select count(cat_id) as check_category from tbl_categories where cat_id='".$cat_id."' and level='5'";	
	$count_arr = $db->get_row($count_qry,ARRAY_A);
	$check_category = $count_arr['check_category'];
	
	if($check_category=="" || $check_category==0)
	{
		echo 'Error';
	}
	else
	{
		$set_qry  = "select is_featured_topic from tbl_categories where cat_id='".$cat_id."' ";	
		$set_arr  = $db->get_row($set_qry,ARRAY_A);
		$is_featured_topic = $set_arr['is_featured_topic'];
	
		if($is_featured_topic=='No')
		{
			$set_status = 'Yes';
		}
		else
		{
			$set_status = 'No';
		}
		
		$del_qry="update tbl_categories set is_featured_topic='".$set_status."' where cat_id='".$cat_id."'";
		$db->query($del_qry);
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>