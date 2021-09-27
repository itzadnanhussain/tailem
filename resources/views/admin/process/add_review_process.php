<?php
error_reporting(0);
include("../includes/top.php");

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$review_rating    = trim($_REQUEST['review_rating']);
	$review_title     = trim($_REQUEST['review_title']);
	$review_detail    = trim($_REQUEST['review_detail']);
	$review_user_id   = trim($_REQUEST['review_user_id']);
	
	if($review_rating == "")
	{
		$errorstr .="Please Select Review Rating\n";
		$case = 0;
	}
	elseif($review_rating<1 || $review_rating>10)
	{
		$errorstr .="Please Select Valid Review Rating\n";
		$case = 0;
	}
	
	if($review_title == "")
	{
		$errorstr .="Please Enter Review Title\n";
		$case = 0;
	}
	
	if($review_detail == "")
	{
		$errorstr .="Please Enter Review Details\n";
		$case = 0;
	}
	
	if($review_user_id == "")
	{
		$errorstr .="Please Select User\n";
		$case = 0;
	}
	else
	{
		 $chk_user_qry = "select count(user_name) as chk_user, user_id from tbl_users where user_name=\"".$review_user_id."\" ";
		
		$chk_user_arr = $db->get_row($chk_user_qry,ARRAY_A);
		$chk_user = $chk_user_arr['chk_user'];
		$user_id   =  $chk_user_arr['user_id'];
		if($chk_user== "" || $chk_user<1)
		{
			$errorstr .= "This User Name does't Exist\n";
			$case = 0;
		}
	}
	
	if($case==1)
	{
		$count   =  mysqli_num_rows(mysqli_query($db->dbh, "select review_id from tbl_reviews where song_id = $song_id AND review_user_id = '".$user_id."'"));
	
		if($count!=0)
		{
			echo $errorstr .="You have already posted a review on this song.";
			$case = 0;
			exit;
		}
	}	
	
	if($case==1)
	{
		
		
		
			
		$update_qry = "insert into tbl_reviews set review_title = '".$review_title."', 	review_rating = '".$review_rating."', 	review_user_id = '".$user_id."', review_detail = '".$review_detail."', review_ip = '".$_SERVER['REMOTE_ADDR']."', review_post_date = '".time()."', song_id = '".$song_id."', album_id = '".$album_id."',  artist_id = '".$artist_id."',  review_given  = 'admin',  review_date  = NOW()";
			
		$db->query($update_qry);
		
		
			
		$rev_counter  =  $counter + 1;
			
		$last_insert_id = mysqli_insert_id($db->dbh);
		      
		
		 $update_qry2 = "insert into tbl_likes set  	like_id  = '".$last_insert_id."', 	like_type  = 'admin_review',  	like_receive_user = '".$user_id."', like_from_user_id  = '$user_id', date  = '".date("Y-m-d")."',  display_date  = NOW()";
		
		$db->query($update_qry2);	
			
		$sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = $song_id";
		$rate_arr	=	$db->get_row($sum_rating,ARRAY_A);
		
		$sum_rate = $rate_arr['sum_rate'];
		$counter = $rate_arr['counter'];
		
		if($sum_rate=="" || $sum_rate==0)
		{
			$sum_rate = 0;
		}
		
		if($counter==0)
		{
			$counter=1;
			$rev_counter  =  $counter + 1;
		}
		else
		{
			$rev_counter  =  $counter + 1;
		}
		
		 $all_avg  =  $sum_rate / $counter;
		
		if($all_avg==0)
		{
			$all_avg  =  $rating + $all_avg;
		}
		else
		{
			$all_avg  =  ($rating + $all_avg)/2;
		}	
			
		$rev_counter  =  $counter + 1;
			
			
			
		mysqli_query($db->dbh, "update tbl_songs set rate_song = '$all_avg', review_count = $rev_counter where id = '$song_id'");
	
		
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
