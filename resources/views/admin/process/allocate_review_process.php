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
	$level1_cat_id    = trim($_REQUEST['level1_cat_id']);
	$level2_cat_id    = trim($_REQUEST['level2_cat_id']);
	$level3_cat_id    = trim($_REQUEST['level3_cat_id']);
	$level4_cat_id    = trim($_REQUEST['level4_cat_id']);
	$level5_cat_id    = trim($_REQUEST['level5_cat_id']);
	$greview_id       = trim($_REQUEST['greview_id']);
	if($greview_id== "")
	{
		$errorstr .="Please select general review to allocate review\n";
		$case = 0;
	}
	else
	{
		$chk_review_qry = "select count(g_review_id) as chk_review_id from tbl_general_review where 
		g_review_id=\"".$greview_id."\" and g_review_allocated='No' ";
		$chk_review_arr	= $db->get_row($chk_review_qry,ARRAY_A);
		$chk_review_id  = $chk_review_arr['chk_review_id']; 			
		if($chk_review_id>0)
		{
			
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
			$chk_user_qry = "select count(user_id) as chk_user from tbl_users where user_id=\"".$review_user_id."\" ";
			$chk_user_arr = $db->get_row($chk_user_qry,ARRAY_A);
			$chk_user = $chk_user_arr['chk_user'];
			if($chk_user== "" || $chk_user<1)
			{
				$errorstr .= "This User Name does't Exist\n";
				$case = 0;
			}
		}
		if($level1_cat_id == "")
		{
			$errorstr .="Please Select Levlel1 Category\n";
			$case = 0;
		}
		else
		{
			$chk_parent_qry='select cat_id as chk_parent_id from tbl_categories where (cat_id="'.$level1_cat_id.'") and 
			level="1"';
			$chk_parent_arr = $db->get_row($chk_parent_qry, ARRAY_A);
			$chk_parent_id  = $chk_parent_arr['chk_parent_id'];	
			if($chk_parent_id=="")
			{
				$errorstr .="Invalid Levlel1 Category is selected\n";
				$case = 0;
			}
			
			if($level2_cat_id == "" && $chk_parent_id!="")
			{
				$errorstr .="Please Select Level2 Category\n";
				$case = 0;
			}
			elseif($chk_parent_id!="")
			{
				$chk_level2_cat_qry ='select cat_id as chk_level2_cat from tbl_categories where (cat_id="'.$level2_cat_id.'"  and parent_id="'.$level1_cat_id.'") and level="2" ';
				$chk_level2_cat_arr = $db->get_row($chk_level2_cat_qry, ARRAY_A);
				$chk_level2_cat  = $chk_level2_cat_arr['chk_level2_cat'];	
				if($chk_level2_cat=="" && $level2_cat_id != "")
				{
					$errorstr .="Invalid Level2 Category is selected\n";
					$case = 0;
				}
				
				if($level3_cat_id == "" && $chk_level2_cat!="")
				{
					$errorstr .="Please Select Level3 Category\n";
					$case = 0;
				}
				elseif($chk_level2_cat!="" && $level3_cat_id != "")
				{
					 $chk_level3_cat_qry ='select cat_id as chk_level3_cat from tbl_categories where (cat_id="'.$level3_cat_id.'"  and parent_id="'.$chk_level2_cat.'") and level="3" ';
					$chk_level3_cat_arr = $db->get_row($chk_level3_cat_qry, ARRAY_A);
					$chk_level3_cat  = $chk_level3_cat_arr['chk_level3_cat'];	
					if($chk_level3_cat=="")
					{
						$errorstr .="Invalid Level3 Category is selected\n";
						$case = 0;
					}
					
					if($level4_cat_id == "" && $chk_level3_cat!="")
					{
						$errorstr .="Please Select Level4 Category\n";
						$case = 0;
					}
					elseif($chk_level3_cat!="" && $level4_cat_id != "")
					{
						 $chk_level4_cat_qry ='select cat_id as chk_level4_cat from tbl_categories where (cat_id="'.$level4_cat_id.'"  and parent_id="'.$chk_level3_cat.'") and level="4" ';
						$chk_level4_cat_arr = $db->get_row($chk_level4_cat_qry, ARRAY_A);
						$chk_level4_cat  = $chk_level4_cat_arr['chk_level4_cat'];	
						if($chk_level4_cat=="")
						{
							$errorstr .="Invalid Level4 Category is selected\n";
							$case = 0;
						}
						
					}
					
					if($level5_cat_id == "" && $chk_level4_cat!="")
					{
						$errorstr .="Please Select Level5 Category\n";
						$case = 0;
					}
					elseif($chk_level4_cat!="" && $level5_cat_id != "")
					{
						 $chk_level5_cat_qry ='select cat_id as chk_level5_cat from tbl_categories where (cat_id="'.$level4_cat_id.'"  and parent_id="'.$chk_level3_cat.'") and level="5" ';
						$chk_level5_cat_arr = $db->get_row($chk_level5_cat_qry, ARRAY_A);
						$chk_level5_cat  = $chk_level5_cat_arr['chk_level5_cat'];	
						if($chk_level4_cat=="")
						{
							$errorstr .="Invalid Level5 Category is selected\n";
							$case = 0;
						}
						
					}
				}
			}
	}
	
		}
		else
		{
			$errorstr .="This general review is not found \n";
			$case = 0;
		}
	}	
	
	if($case==1)
	{
			$db->query("insert into tbl_reviews set review_title ='".mysqli_escape_string($db->dbh, stripslashes($review_title))."', review_detail ='".mysqli_escape_string($db->dbh, stripslashes($review_detail))."', review_rating ='".mysqli_escape_string($db->dbh, stripslashes($review_rating))."', review_user_id ='".mysqli_escape_string($db->dbh, stripslashes($review_user_id))."',review_ip ='".mysqli_escape_string($db->dbh, stripslashes($_SERVER['REMOTE_ADDR']))."',cat_level1='".mysqli_escape_string($db->dbh, stripslashes($level1_cat_id))."',cat_level2='".mysqli_escape_string($db->dbh, stripslashes($level2_cat_id))."',cat_level3='".mysqli_escape_string($db->dbh, stripslashes($level3_cat_id))."',cat_level4='".mysqli_escape_string($db->dbh, stripslashes($level4_cat_id))."',category_id='".mysqli_escape_string($db->dbh, stripslashes($level5_cat_id))."',review_post_date='".time()."',status='1',allocate_review_id='".$greview_id."' ");
			
		$db->query("UPDATE tbl_general_review set g_review_allocated='Yes' where g_review_id='".$greview_id."'");
		
		//Insert Notification
		$insert_notification_qry="INSERT INTO tbl_notifications set 
		notification_sent_user_id='".$_SESSION['reviewsite_cpadmin_id']."', notification_receive_user_id='".$review_user_id."', common_notification_id='".$level5_cat_id."' ,type='Moderator Allocate Review',read_status='unread', status='1', date_added='".time()."' ";
		$db->query($insert_notification_qry);
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
