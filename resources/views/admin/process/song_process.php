<?php
include("../includes/top.php");
include(dirname(dirname(__FILE__))."/common/thumbnail.class.php");

	$backtopage =  $_SESSION['backtopage'];

if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
		
	function SEO($input)
	{ 
	
	Global $db;
	
		$input = str_replace("&nbsp;", " ", $input);
		$input = str_replace(array("'"), "", $input); //remove single quote and dash
		$input = mb_convert_case($input, MB_CASE_LOWER, "UTF-8"); //convert to lowercase
		$input = preg_replace("#[^a-zA-Z0-9]+#", "-", $input); //replace everything non an with dashes
		$input = preg_replace("#(-){}#", "$1", $input); //replace multiple dashes with one
		$input = trim($input, "-"); //trim dashes from beginning and end of string if any
		$song_id=$_REQUEST['update_id'];
		if($song_id!=""){
			
			$select_url ="select song_seo from tbl_songs where song_seo='$input' and id !='$song_id'";
				
		}else{
			
			$select_url ="select song_seo from tbl_songs where song_seo='$input'";
			
		}
		$result = $db->get_results($select_url, ARRAY_A);
		if(count($result)>0){
		 $input=$input."-".uniqid();	
			
		}
		return $input; 
	}
	
	
	$song_title		= trim($_REQUEST['song_title']);
	$song_seo		= trim($_REQUEST['song_seo']);
	$keywords		= trim($_REQUEST['key_words_value']);
	$itunes_url		=  trim($_REQUEST['itunes_url']);
	$amazon_url		=  trim($_REQUEST['amazon_url']);
	$google_url		=  trim($_REQUEST['google_url']);
	$lastfm_url		=  trim($_REQUEST['lastfm_url']);
	$description	= trim($_REQUEST['description']);
	$sizeofarray 	= sizeof($_REQUEST['artist']);
	$ad_code		= trim($_REQUEST['ad_code']);
	$video_code		= trim($_REQUEST['video_code']);
	$years			= trim($_REQUEST['years']);
	$path			= '../../site_upload/song_images/';

	$ranking_order =      $_REQUEST['song_ranking'];
	

			if(MEMCACHE_IS_ENABALED){
					$key = md5("artist_list_arr_top_songs_list"); // Unique Words
					$memcache->delete($key);
		    }

	
	if($ranking_order=="")
	{
		$ranking_order=0;
	} 
	
	
	$update_id = $_REQUEST['update_id'];
	if($song_title == "")
	{
		$errorstr .="Please Enter Song Name\n";
		$case = 0;
	}

	/*else
	{
	  if($update_id!="")
	  {
	  	$artist_list		=	"select * from tbl_songs where 1=1 AND song_title = '$song_title' AND id != '$update_id'";	
	  }
	  else
	  {	
		$artist_list		=	"select * from tbl_songs where 1=1 AND song_title = '$song_title'";	
	  }	
		$artist_list_arr	=	$db->get_results($artist_list,ARRAY_A);
		if($artist_list_arr)
		{
			$errorstr .="Song name already exist\n";
			$case = 0;
		}
		
	}*/
	
 
	
	if($sizeofarray==0)
	{
		$errorstr .= "Please select at least one artist\n";
		$case = 0;
	}
	if($_FILES["image_name"]['name']!="")
	{
		$filename = $_FILES["image_name"]['name'];
		$TmpExt   = strtolower(substr($filename, strrpos($filename, '.')+1));
		$ext = array('jpg', 'png', 'gif','JPEG','jpeg');
		if(!in_array($TmpExt,$ext))
		{
			$errorstr .= "Invalid Picture Format\n";
			$case = 0;
		}
	}

	if($case==1)
	{
		if($update_id != '')
		{
		   
				$db->query("update tbl_songs set ranking_order ='".$ranking_order."', song_title='".mysqli_escape_string($db->dbh, stripslashes($song_title))."',itunes_url='".mysqli_escape_string($db->dbh, stripslashes($itunes_url))."',amazon_url='".mysqli_escape_string($db->dbh, stripslashes($amazon_url))."',google_url='".mysqli_escape_string($db->dbh, stripslashes($google_url))."',lastfm_url='".mysqli_escape_string($db->dbh, stripslashes($lastfm_url))."',keywords='".mysqli_escape_string($db->dbh, stripslashes($keywords))."',song_seo='".mysqli_escape_string($db->dbh, stripslashes(SEO($song_seo)))."', description ='".mysqli_escape_string($db->dbh, stripslashes($description))."', ad_code='".mysqli_escape_string($db->dbh, stripslashes($ad_code))."', video_code='".mysqli_escape_string($db->dbh, stripslashes($video_code))."', song_year ='".$years."' where id = '$update_id'");
			
			$arr  = $_REQUEST['artist'];
			
			mysqli_query($db->dbh, "delete from tbl_songs_artist where song_id = $update_id");
			
			for($m=0;$m<$sizeofarray;$m++)
			{
				//$full_array = explode(",".$array);
				
				$artist_nn ="select id from tbl_artists where artist_name='".trim(mysql_real_escape_string($arr[$m]))."' ";
				$artist_nn_arr = $db->get_row($artist_nn, ARRAY_A);
				
				$db->query("insert into tbl_songs_artist set song_id='".mysqli_escape_string($db->dbh, stripslashes($update_id))."',artist_id='".$arr[$m]."', posted_date='".time()."'");
				/* 20-10-16
				
				$artist_nn ="select id from tbl_artists where artist_name='".trim(mysql_real_escape_string($arr[$m]))."' ";
				$artist_nn_arr = $db->get_row($artist_nn, ARRAY_A);
				
				$db->query("insert into tbl_songs_artist set song_id='".mysqli_escape_string($db->dbh, stripslashes($update_id))."',artist_id='".$artist_nn_arr['id']."', posted_date='".time()."'");*/
			}
			
			if($_FILES["image_name"]['name']!="")
			{
				$select_img ="select picture from tbl_songs where id='".$update_id."' ";
				$result = $db->get_row($select_img, ARRAY_A);
				$old_image  = $result['picture'];
				$imgfile =$path.$old_image;
				$thumbfile =$path.'thumb_'.$old_image;
				$thumbfile_small =$path.'small_thumb_'.$old_image;
				@unlink($imgfile);
				@unlink($thumbfile);
				@unlink($thumbfile_small);
				
				$icon_array = $_FILES["image_name"]['name'];
				$img_formats = array("jpeg", "gif", "png", "jpg","JPEG", "GIF", "PNG", "JPG");
				$allowed_size = 2; // Allowed Photo Size in MB			
				$file_temp = $_FILES["image_name"]['tmp_name'];
				$h_image_size = filesize($_FILES["image_name"]['tmp_name']);
				$h_image_size = ($h_image_size/1024)/1024;
				$h_file_name_array 	= $_FILES["user_image"];
				$h_file_ext = ltrim(strtolower(strrchr($_FILES["image_name"]['name'],'.')),'.'); 
				
				$icon_orgname = rand()."_".$_FILES["image_name"]['name'];
				$h_newthumb_name = 'thumb_'.$icon_orgname;	
				$h_small_thumb_name = 'small_thumb_'.$icon_orgname;			
				$h_photo_path = $path.$icon_orgname;
				$h_photothumb_path = $path.$h_newthumb_name;
				$h_dir = $path;
				
				if($h_image_size < $allowed_size)
				{
					copy($file_temp,$h_photo_path);	
					$a = new Thumbnail($_FILES["image_name"]['tmp_name'],241,'238',$h_dir.$h_newthumb_name);
					// creating thumbnail
					$a->create();
					
					$b = new Thumbnail($_FILES["image_name"]['tmp_name'],50,'50',$h_dir.$h_small_thumb_name);
					// creating thumbnail
					$b->create();
					
					$img_qry="UPDATE tbl_songs SET picture='".$icon_orgname."' where id='".$update_id."'";
					$db->query($img_qry);
				}
		  }
		
		}
		else
		{

 

			$db->query("insert into tbl_songs set  ranking_order ='".$ranking_order."',song_title='".mysqli_escape_string($db->dbh, stripslashes($song_title))."',keywords='".mysqli_escape_string($db->dbh, stripslashes($keywords))."',song_seo='".mysqli_escape_string($db->dbh, stripslashes(SEO($song_title)))."', description ='".mysqli_escape_string($db->dbh, stripslashes($description))."', song_status = '1',itunes_url='".mysqli_escape_string($db->dbh, stripslashes($itunes_url))."',amazon_url='".mysqli_escape_string($db->dbh, stripslashes($amazon_url))."',google_url='".mysqli_escape_string($db->dbh, stripslashes($google_url))."',lastfm_url='".mysqli_escape_string($db->dbh, stripslashes($lastfm_url))."', posted_date='".time()."', ad_code='".mysqli_escape_string($db->dbh, stripslashes($ad_code))."', video_code='".mysqli_escape_string($db->dbh, stripslashes($video_code))."', song_year ='".$years."'");
			
			$last_record  =  mysqli_insert_id($db->dbh);
			$arr  = $_REQUEST['artist'];
			
			for($m=0;$m<$sizeofarray;$m++)
			{
				/*
				Not required 26-07-16
				if($m==0)
				{
					$first_artist = mysqli_escape_string($db->dbh, stripslashes($arr[$m]));
				}*/
				
				/*$artist_nn ="select id from tbl_artists where artist_name='".trim(mysql_real_escape_string($arr[$m]))."' ";
				$artist_nn_arr = $db->get_row($artist_nn, ARRAY_A);
			
				$db->query("insert into tbl_songs_artist set song_id='".mysqli_escape_string($db->dbh, stripslashes($last_record))."',artist_id='".$artist_nn_arr['id']."', posted_date='".time()."'");*/
			
			$artist_nn ="select id from tbl_artists where artist_name='".trim(mysql_real_escape_string($arr[$m]))."' ";
				$artist_nn_arr = $db->get_row($artist_nn, ARRAY_A);
				if($update_id==""){
					
					$update_id=$last_record;
				}
				$db->query("insert into tbl_songs_artist set song_id='".mysqli_escape_string($db->dbh, stripslashes($update_id))."',artist_id='".$arr[$m]."', posted_date='".time()."'");
			}
			
			/* Not required 26-07-16
			if($first_artist!="")
			{
			   $get_artist_query_list		=	"select artist_name from tbl_artists where id = $first_artist";	
			   $artist_list_arr	=	$db->get_row($get_artist_query_list,ARRAY_A);
 			   $artist_name_arr  =   $artist_list_arr['artist_name'];
			}*/			
			
			if($_FILES["image_name"]['name']!="")
			{
				$icon_array = $_FILES["image_name"]['name'];
				$img_formats = array("jpeg", "gif", "png", "jpg","JPEG", "GIF", "PNG", "JPG");
				$allowed_size = 2; // Allowed Photo Size in MB			
				$file_temp = $_FILES["image_name"]['tmp_name'];
				$h_image_size = filesize($_FILES["image_name"]['tmp_name']);
				$h_image_size = ($h_image_size/1024)/1024;
				$h_file_name_array 	= $_FILES["user_image"];
				$h_file_ext = ltrim(strtolower(strrchr($_FILES["image_name"]['name'],'.')),'.'); 
				
				$icon_orgname = rand()."_".$_FILES["image_name"]['name'];
				$h_newthumb_name = 'thumb_'.$icon_orgname;	
				$h_small_thumb_name = 'small_thumb_'.$icon_orgname;			
				$h_photo_path = $path.$icon_orgname;
				$h_photothumb_path = $path.$h_newthumb_name;
				$h_dir = $path;
				
				
				if($h_image_size < $allowed_size)
				{
					copy($file_temp,$h_photo_path);	
					$a = new Thumbnail($_FILES["image_name"]['tmp_name'],241,'238',$h_dir.$h_newthumb_name);
					// creating thumbnail
					$a->create();
					
					$b = new Thumbnail($_FILES["image_name"]['tmp_name'],50,'50',$h_dir.$h_small_thumb_name);
					// creating thumbnail
					$b->create();
					
					$img_qry="UPDATE tbl_songs SET picture='".$icon_orgname."' where id='".$last_record."'";
					$db->query($img_qry);
				}
		  }
	}
		///// 
		    
	 		 
		
		
		
		echo 'done-SEPARATOR-'.$backtopage;
	}
	else
	{
		echo $errorstr;
	}
}
function add_kewords($keyrds,$type){
$arr=explode(',',$keyrds);
echo '<pre>';
print_r($arr);
die;
}
