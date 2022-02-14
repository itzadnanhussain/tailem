<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$review_id  = base64_decode($_POST['del_id']);
	 $select_qry = "select review_id,review_user_id from tbl_reviews where review_id='".$review_id."' ";	

	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$review_id  = $select_arr['review_id'];
	$review_user_id  = $select_arr['review_user_id'];
	
	if($review_id=="")
	{
		$review_id  = 0;
	}
	

	if($review_id==0)
	{
		echo 'Error';
	}
	else
	{	
		
		$song_notification =
						   "select s.song_title, s.song_seo, a.artist_seo  
						   from  tbl_reviews r, tbl_songs s, tbl_artists a  
						   where r.review_id = $review_id 
						   AND r.song_id = s.id
						   AND r.artist_id = a.id";
							
		$song_result_notification = $db->get_row($song_notification, ARRAY_A);
		
		
		
			 $mesg = "Moderator has removed your review on <a class=\"text_blck\" href=\"".SERVER_ROOTPATH.$song_result_notification['song_seo']."/reviews/".$song_result_notification['artist_seo'].".html\"><strong>".wordwrap(stripslashes($song_result_notification['song_title']),100," ",true)."</strong></a>.";
			
		
		
		
		
		$insert_notification_qry="insert into tbl_likes set 
		like_type='delete_review_song',description='$mesg',read_status='1',like_id='$review_id', like_receive_user='$review_user_id', date='".date("Y-m-d")."'";
		$db->query($insert_notification_qry);

		//delete review
		$del_review_qry="Delete from tbl_reviews where review_id='".$review_id."'";
		$db->query($del_review_qry);
		
		//delete review like
		$del_review_like_qry="Delete from tbl_likes where like_id='".$review_id."' AND like_type = 'review_song'";
		$db->query($del_review_like_qry);
		
		//delete review Report
		$del_review_report_qry="Delete from tbl_review_report where r_report_review_id='".$review_id."'";
		$db->query($del_review_report_qry);
		
		echo 'done';
	}
}
else
{
	echo 'Error';
}
