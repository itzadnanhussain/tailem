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
		$set_qry     = "select is_featured from tbl_reviews where review_id='".$review_id."' ";	
		$set_arr     = $db->get_row($set_qry,ARRAY_A);
		$is_featured = $set_arr['is_featured'];
		
		
		$count_feture_qry         = "select count(review_id) as feature_counter from tbl_reviews where 
		review_id='".$review_id."' and is_featured='Yes'";	
		$count_feture_arr         = $db->get_row($count_feture_qry,ARRAY_A);
		$feature_counter		  = $count_feture_arr['feature_counter'];
		if($feature_counter>0 && $is_featured=='No')
		{
			echo 'Exist';
		}
		else
		{
			if($is_featured=='No')
			{
				$set_status = 'Yes';
			}
			else
			{
				$set_status = 'No';
			}
			
			$del_qry="update tbl_reviews set is_featured='".$set_status."' where review_id='".$review_id."'";
			$db->query($del_qry);
			echo 'done';
		}
	}
}
else
{
	echo 'Error';
}
?>