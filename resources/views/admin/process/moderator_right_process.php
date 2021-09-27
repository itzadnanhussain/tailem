<?php
error_reporting(0);
include("../includes/top.php");
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$moderator_id         		= trim($_REQUEST['moderator_id']);
	
	$artist_module            	= trim($_REQUEST['artist_module']);
	$artist_module_add           = trim($_REQUEST['artist_module_add']);  
	$artist_module_delete        = trim($_REQUEST['artist_module_delete']);
	
	$album_module            	= trim($_REQUEST['album_module']);
	$album_module_add           = trim($_REQUEST['album_module_add']);  
	$album_module_delete        = trim($_REQUEST['album_module_delete']);
	
	$song_module            	= trim($_REQUEST['song_module']);
	$song_module_add           = trim($_REQUEST['song_module_add']);  
	$song_module_delete        = trim($_REQUEST['song_module_delete']);
	
	
	$slider_module            	= trim($_REQUEST['slider_module']);
	$users_module 	  			= trim($_REQUEST['users_module']);
	$faq_module  				= trim($_REQUEST['faq_module']);
	
	$categories_module         	= trim($_REQUEST['categories_module']);
	$advertisement_module      	= trim($_REQUEST['advertisement_module']);
	$social_link_module 	  	= trim($_REQUEST['social_link_module']);
	$content_module  			= trim($_REQUEST['content_module']);
	
	$email_template_module      = trim($_REQUEST['email_template_module']);
	$country_module             = trim($_REQUEST['country_module']);
	$reviews_module 	  		= trim($_REQUEST['reviews_module']);
	$slider_module_add  		= trim($_REQUEST['slider_module_add']);
	$slider_module_delete 		= trim($_REQUEST['slider_module_delete']); 
	$users_module_add    		= trim($_REQUEST['users_module_add']); 
	$users_module_delete 		= trim($_REQUEST['users_module_delete']);  
	$faq_module_add      		= trim($_REQUEST['faq_module_add']); 
	$faq_module_delete   		= trim($_REQUEST['faq_module_delete']);  
	$categories_module_add		= trim($_REQUEST['categories_module_add']);  
	$categories_module_delete	= trim($_REQUEST['categories_module_delete']);  
	$email_template_module_edit	= trim($_REQUEST['email_template_module_edit']);  
	$country_module_add			= trim($_REQUEST['country_module_add']);  
	$country_module_delete		= trim($_REQUEST['country_module_delete']);  
	$reviews_module_add			= trim($_REQUEST['reviews_module_add']);  
	$reviews_module_delete 		= trim($_REQUEST['reviews_module_delete']); 
	$advertisement_module_add   = trim($_REQUEST['advertisement_module_add']);  
	$advertisement_module_delete= trim($_REQUEST['advertisement_module_delete']);  
	
	$video_module               = trim($_REQUEST['video_module']);
	$video_module_add           = trim($_REQUEST['video_module_add']);  
	$video_module_delete        = trim($_REQUEST['video_module_delete']);  
	
	if($moderator_id=="" || $moderator_id=='1')
	{
		$errorstr .="Invalid Moderator is selected\n";
		$case = 0;
	}
	else
	{
		$chk_modrator_qry="select count(id) as chk_moderator from tbl_admin where id=\"".$moderator_id."\" and id!='1'";
		$chk_moderator_arr = $db->get_row($chk_modrator_qry,ARRAY_A);
		$chk_moderator     = $chk_moderator_arr['chk_moderator'];
		if($chk_moderator==0  || $chk_moderator=="")
		{
			$errorstr .= "There is some error ocuur.please relaod page \n";
			$case = 0;
		}
		else
		{
		/*	if($slider_module=="")
			{
				$errorstr .="Please select slider option\n";
				$case = 0;
			}
			elseif($slider_module!="No" && $slider_module!="Yes")
			{
				$errorstr .="The slider option you seleted is invalid\n";
				$case = 0;
			}*/
			
			if($users_module=="")
			{
				$errorstr .="Please select user option\n";
				$case = 0;
			}
			elseif($users_module!="No" && $users_module!="Yes")
			{
				$errorstr .="The user option you seleted is invalid\n";
				$case = 0;
			}
			
			/*if($faq_module=="")
			{
				$errorstr .="Please select faq option\n";
				$case = 0;
			}
			elseif($faq_module!="No" && $faq_module!="Yes")
			{
				$errorstr .="The faq option you seleted is invalid\n";
				$case = 0;
			}*/
			
			if($categories_module=="")
			{
				$errorstr .="Please select categories option\n";
				$case = 0;
			}
			elseif($categories_module!="No" && $categories_module!="Yes")
			{
				$errorstr .="The categories option you seleted is invalid\n";
				$case = 0;
			}
			
			
			if($advertisement_module=="")
			{
				$errorstr .="Please select advertisement option\n";
				$case = 0;
			}
			elseif($advertisement_module!="No" && $advertisement_module!="Yes")
			{
				$errorstr .="The advertisement option you seleted is invalid\n";
				$case = 0;
			}
			
			
			if($country_module=="")
			{
				$errorstr .="Please select country option\n";
				$case = 0;
			}
			elseif($country_module!="No" && $country_module!="Yes")
			{
				$errorstr .="The country option you seleted is invalid\n";
				$case = 0;
			}
			
			
			if($reviews_module=="")
			{
				$errorstr .="Please select reviews option\n";
				$case = 0;
			}
			elseif($reviews_module!="No" && $reviews_module!="Yes")
			{
				$errorstr .="The reviews option you seleted is invalid\n";
				$case = 0;
			}
			
			
			if($social_link_module=="")
			{
				$errorstr .="Please select social link option\n";
				$case = 0;
			}
			elseif($social_link_module!="No" && $social_link_module!="Yes")
			{
				$errorstr .="The social link option you seleted is invalid\n";
				$case = 0;
			}
			
			if($content_module=="")
			{
				$errorstr .="Please select content option\n";
				$case = 0;
			}
			elseif($content_module!="No" && $content_module!="Yes")
			{
				$errorstr .="The content option you seleted is invalid\n";
				$case = 0;
			}
			
			if($email_template_module=="")
			{
				$errorstr .="Please select email template option\n";
				$case = 0;
			}
			elseif($email_template_module!="No" && $email_template_module!="Yes")
			{
				$errorstr .="The email template option you seleted is invalid\n";
				$case = 0;
			}
			
			if($slider_module!="" && $slider_module_add!='')
			{
				if($slider_module_add!='Yes')
				{
					$errorstr .="Please select valid slider Add option\n";
					$case = 0;
				}
			}
			
			
			if($slider_module!="" && $slider_module_delete!='')
			{
				if($slider_module_delete!='Yes')
				{
					$errorstr .="Please select valid slider Delete option\n";
					$case = 0;
				}
			}
			
			if($users_module!="" && $users_module_add!='')
			{
				if($users_module_add!='Yes')
				{
					$errorstr .="Please select valid user Add option\n";
					$case = 0;
				}
			}
			
			
			if($users_module!="" && $users_module_delete!='')
			{
				if($users_module_delete!='Yes')
				{
					$errorstr .="Please select valid user Delete option\n";
					$case = 0;
				}
			}
			
			/*if($faq_module!="" && $faq_module_add!='')
			{
				if($faq_module_add!='Yes')
				{
					$errorstr .="Please select valid faq Add option\n";
					$case = 0;
				}
			}*/
			
			
			/*if($faq_module!="" && $faq_module_delete!='')
			{
				if($faq_module_delete!='Yes')
				{
					$errorstr .="Please select valid faq Delete option\n";
					$case = 0;
				}
			}*/
			
			if($categories_module!="" && $categories_module_add!='')
			{
				if($categories_module_add!='Yes')
				{
					$errorstr .="Please select valid categories Add option\n";
					$case = 0;
				}
			}
			
			
			if($categories_module!="" && $categories_module_delete!='')
			{
				if($categories_module_delete!='Yes')
				{
					$errorstr .="Please select valid categories Delete option\n";
					$case = 0;
				}
			}
			
			if($advertisement_module!="" && $advertisement_module_add!='')
			{
				if($advertisement_module_add!='Yes')
				{
					$errorstr .="Please select valid advertisement Add option\n";
					$case = 0;
				}
			}
			
			
			if($advertisement_module!="" && $advertisement_module_delete!='')
			{
				if($advertisement_module_delete!='Yes')
				{
					$errorstr .="Please select valid advertisement Delete option\n";
					$case = 0;
				}
			}
			
			if($country_module!="" && $country_module_add!='')
			{
				if($country_module_add!='Yes')
				{
					$errorstr .="Please select valid country Add option\n";
					$case = 0;
				}
			}
			
			
			if($country_module!="" && $country_module_delete!='')
			{
				if($country_module_delete!='Yes')
				{
					$errorstr .="Please select valid country Delete option\n";
					$case = 0;
				}
			}
			
			if($reviews_module!="" && $reviews_module_add!='')
			{
				if($reviews_module_add!='Yes')
				{
					$errorstr .="Please select valid reviews Add option\n";
					$case = 0;
				}
			}
			
			
			if($reviews_module!="" && $reviews_module_delete!='')
			{
				if($reviews_module_delete!='Yes')
				{
					$errorstr .="Please select valid reviews Delete option\n";
					$case = 0;
				}
			}
			
			
			if($content_module!="" && $content_module_edit!='')
			{
				if($content_module_edit!='Yes')
				{
					$errorstr .="Please select valid content Edit option\n";
					$case = 0;
				}
			}
			
			if($email_template_module_edit!="" && $email_template_module_edit!='')
			{
				if($email_template_module_edit!='Yes')
				{
					$errorstr .="Please select valid email template Edit option\n";
					$case = 0;
				}
			}
			
			if($video_module!="" && $video_module_add!='')
			{
				if($video_module_add!='Yes')
				{
					$errorstr .="Please select valid Video Add option\n";
					$case = 0;
				}
			}
			
			
			if($video_module!="" && $video_module_delete!='')
			{
				if($video_module_delete!='Yes')
				{
					$errorstr .="Please select valid Video Delete option\n";
					$case = 0;
				}
			}
			
		}
	}
	
	if($case==1)
	{
		if($slider_module_add=='' || $slider_module!='Yes')
		{
			$slider_module_add='No';
		}
		if($slider_module_delete=='' || $slider_module!='Yes')
		{
			$slider_module_delete='No';
		}
		
		if($artist_module_add=='' || $artist_module!='Yes')
		{
			$artist_module_add='No';
		}
		if($artist_module_delete=='' || $artist_module!='Yes')
		{
			$artist_module_delete='No';
		}
		
		if($album_module_add=='' || $album_module!='Yes')
		{
			$album_module_add='No';
		}
		if($album_module_delete=='' || $album_module!='Yes')
		{
			$album_module_delete='No';
		}
		
		if($song_module_add=='' || $song_module!='Yes')
		{
			$song_module_add='No';
		}
		if($song_module_delete=='' || $song_module!='Yes')
		{
			$song_module_delete='No';
		}
		
		if($users_module_add=='' || $users_module!='Yes')
		{
			$users_module_add='No';
		}
		if($users_module_delete==''  || $users_module!='Yes')
		{
			$users_module_delete='No';
		}
		
		if($faq_module_add==''  || $faq_module!='Yes')
		{
			$faq_module_add='No';
		}
		if($faq_module_delete==''  || $faq_module!='Yes')
		{
			$faq_module_delete='No';
		}
		
		if($categories_module_add==''  || $categories_module!='Yes')
		{
			$categories_module_add='No';
		}
		if($categories_module_delete=='' || $categories_module!='Yes')
		{
			$categories_module_delete='No';
		}
		
		if($advertisement_module_add==''  || $advertisement_module!='Yes')
		{
			$advertisement_module_add='No';
		}
		if($advertisement_module_delete=='' || $advertisement_module!='Yes')
		{
			$advertisement_module_delete='No';
		}
		
		if($country_module_add=='' || $country_module!='Yes')
		{
			$country_module_add='No';
		}
		if($country_module_delete=='' || $country_module!='Yes')
		{
			$country_module_delete='No';
		}
		
		if($reviews_module_add=='' || $reviews_module!='Yes')
		{
			$reviews_module_add='No';
		}
		if($reviews_module_delete=='' || $reviews_module!='Yes')
		{
			$reviews_module_delete='No';
		}
		
		
		if($content_module_edit=='' || $content_module!='Yes')
		{
			$content_module_edit='No';
		}
		
		if($email_template_module_edit==''  || $email_template_module!='Yes')
		{
			$email_template_module_edit='No';
		}
		
		if($video_module_add=='' || $video_module!='Yes')
		{
			$video_module_add='No';
		}
		if($video_module_delete=='' || $video_module!='Yes')
		{
			$video_module_delete='No';
		}
		
	 	$query = "update tbl_moderator_rights set slider_module='".$slider_module."',artist_module='".$artist_module."',album_module='".$album_module."',song_module='".$song_module."', users_module='".$users_module."', categories_module='".$categories_module."', advertisement_module='".$advertisement_module."', social_link_module='".$social_link_module."', content_module='".$content_module."', email_template_module='".$email_template_module."', country_module='".$country_module."', reviews_module='".$reviews_module."', slider_module_add='".$slider_module_add."', slider_module_delete='".$slider_module_delete."', artist_module_add='".$artist_module_add."', artist_module_delete='".$artist_module_delete."', album_module_add='".$album_module_add."', album_module_delete='".$album_module_delete."', song_module_add='".$song_module_add."', song_module_delete='".$song_module_delete."', users_module_add='".$users_module_add."', users_module_delete='".$users_module_delete."', categories_module_add='".$categories_module_add."',  categories_module_delete='".$categories_module_delete."',content_module_edit='".$content_module_edit."', email_template_module_edit='".$email_template_module_edit."', country_module_add='".$country_module_add."',  country_module_delete='".$country_module_delete."', reviews_module_add='".$reviews_module_add."', reviews_module_delete='".$reviews_module_delete."',advertisement_module_add='".$advertisement_module_add."',  advertisement_module_delete='".$advertisement_module_delete."',video_module='".$video_module."',video_module_add='".$video_module_add."',  video_module_delete='".$video_module_delete."' where moderator_id='".$moderator_id."'";

		$db->query($query);
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
