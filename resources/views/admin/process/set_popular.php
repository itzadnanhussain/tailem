<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['reviewid']))
{
	$review_id = base64_decode($_POST['reviewid']);
	$count_qry = "select count(review_id) as check_review from tbl_reviews where review_id='".$review_id."' ";	
	$count_arr = $db->get_row($count_qry,ARRAY_A);
	$check_review = $count_arr['check_review'];
	
	if($check_review=="" || $check_review==0)
	{
		echo 'Error';
	}
	else
	{
		$set_qry  = "select is_popular from tbl_reviews where review_id='".$review_id."' ";	
		$set_arr  = $db->get_row($set_qry,ARRAY_A);
		$is_popular = $set_arr['is_popular'];
	
		if($is_popular==0)
		{
			$set_status = 1;
		}
		else
		{
			$set_status = 0;
		}
		
		$del_qry="update tbl_reviews set is_popular='".$set_status."' where review_id='".$review_id."'";
		$db->query($del_qry);
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>