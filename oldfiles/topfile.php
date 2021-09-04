<?php
	@session_start();

    error_reporting(0);
    //error_reporting(E_ALL);
    //ini_set("display_errors", 1);


	// FIND THE CURRENT PAGE NAME //
	if($_SESSION['latestRequestTime']=='')
	{
		session_write_close();
		@session_start();
	}
	$_SESSION['latestRequestTime'] = time();
	// close the session
	
	$currentFile = $_SERVER["SCRIPT_NAME"];
	$parts = Explode('/', $currentFile);
	$currentFile = $parts[count($parts) - 1];
 
	//echo 'Current File:'.$currentFile; 
	
	$screen_chr = 28;
	$ipad_chr 	= 19;
	$mobile_chr	= 22;
	
	$screen_rev = 28;
	$ipad_rev 	= 19;
	$mobile_rev	= 19;
	
//die();
	if(isset($_SESSION['USER_SESSION_ARRAY'])&&$_SESSION['USER_SESSION_ARRAY']['USER_ID']=="")
	{
		$check_login_var = 'data-toggle="modal" data-target="#signin_form"';  
	}
	else
	{
		$check_login_var = '';
	}
	
	if (get_magic_quotes_gpc()) 
	{
		foreach($_POST as $key => $value)
		{
			if(is_array($value))
			{
				foreach($value as $inner_value)
				{
					$$key = trim(htmlentities($inner_value));
				}
			}
			else
			{
				$$key = trim(htmlentities($value));
			}
		}
		
		foreach($_GET as $key => $value)
		{
			if(is_array($value))
			{
				foreach($value as $inner_value)
				{
					$$key = trim(htmlentities($inner_value));
				}
			}
			else
			{
				$$key = trim(htmlentities($value));
			}
		}
	}
	else
	{
		foreach($_POST as $key => $value)
		{
			if(is_array($value))
			{
				foreach($value as $inner_value)
				{
					$$key = trim(htmlentities(addslashes($inner_value)));
				}
			}
			else
			{
				$$key = trim(htmlentities(addslashes($value)));
			}
		}
		
		foreach($_GET as $key => $value)
		{
			if(is_array($value))
			{
				foreach($value as $inner_value)
				{
					$$key = trim(htmlentities(addslashes($inner_value)));
				}
			}
			else
			{
				$$key = trim(htmlentities(addslashes($value)));
			}
		}
	}
	
	include("config.php");
	include("conn.php");
	include("common/common_functions.php");
	
	if($currentFile!="like_artist.php")
	{
		/*unset($_SESSION[search_like]['artist_names']);
		unset($_SESSION[search_like]['result']);*/
	}
	
	if($currentFile!="artists.php")
	{
		//unset($_SESSION[search]['artist_names']);
		//unset($_SESSION[search]['result']);
	}
	
	if($currentFile!="search.php" && $currentFile!="search_artist.php" && $currentFile!="search_song.php" && $currentFile!="search_albumlist.php" && $currentFile!="detail.php" && $currentFile!="favourite_like_sub_artist.php" && $currentFile!="favourite_like_sub_artist2.php" && $currentFile!="detail_review.php" && $currentFile!="favourite_like_sub_artist_popular.php" && $currentFile!="favourite_like_review_song.php" && $currentFile!="favourite_like_sub.php")
	{
		//echo "aaaa===" . $currentFile; //exit;
		//unset($_SESSION[main_search]);
	}
	
	function ads_info($place)
	{
		global $db;
		global $memcache;
		$cache_result = array();
		
		if($cache_result)
		{
			return $cache_result;
		}else{
			
			$ads_list = "SELECT ad_script as sss FROM tbl_advertisement where status =1 and ad_place = '$place' order by rand() limit 1";	
												
			$ads_list_arr	=	$db->get_row($ads_list,ARRAY_A);
			
			$ads_detail   =   stripslashes($ads_list_arr['sss']);
			
			return  $ads_detail;
				
		}
				
		
		
		
		
	}

		function get_user_detail($un)
	{
		global $db;
		$query	=	"select * from tbl_users where user_name = '$un'";
		$arr 	= $db->get_row($query,ARRAY_A);
		 $user_seo   	  = stripslashes($arr['user_seo']);	
		
		return $user_seo;
	}
	
	 function imageResizer($url, $width, $height) {

		//header('Content-type: image/jpeg');

		list($width_orig, $height_orig) = getimagesize($url);

		$ratio_orig = $width_orig/$height_orig;

		if ($width/$height > $ratio_orig) {
		  $width = $height*$ratio_orig;
		} else {
		  $height = $width/$ratio_orig;
		}

		// This resamples the image
		$image_p = imagecreatetruecolor($width, $height);
		$image = imagecreatefromjpeg($url);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

		// Output the image
		imagejpeg($image_p, null, 100);
		
	}

	function table_last_updated($table){
	  	 global $db;
		 $last_updated="SELECT (now()-UPDATE_TIME) as last_updated from information_schema.tables WHERE TABLE_SCHEMA = 'exceed13_music_site' AND TABLE_NAME = '$table'";
		$updated_on	=	$db->get_row($last_updated,ARRAY_A);
		$mins=($updated_on['last_updated']/60);
	if($mins<2){
		return false;
		
	}else{
				return true;
	}
	}
	
	
	function song_adds($id,$type)
	{
		if($id!=""){
		global $db;
		
		global $memcache;
		$ads_list_arr = array();
		if(MEMCACHE_IS_ENABALED){
			$key = md5("song_adds-".$id."_".$type); // Unique Words
			$ads_list_arr = $memcache->get($key); // Memcached object 
		}
		if(!empty($ads_list_arr))
		{
			return $ads_list_arr;
		
		}else{
			$ads_list = "SELECT ad_code, video_code FROM tbl_songs where id = $id AND song_status = 1";	
											
			$ads_list_arr	=	$db->get_row($ads_list,ARRAY_A);
			
			if(MEMCACHE_IS_ENABALED){
				$memcache->set($key, $ads_list_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
			}
		}
		 $ad_code   =   stripslashes($ads_list_arr['ad_code']);

		 
		  $video_code   =   stripslashes($ads_list_arr['video_code']);
		  
		  if($type=='video')
		  {
		  	return  $video_code;
		  }
		  
		  if($type=='adds')
		  {
		  	return  $ad_code;
		  }
		}	  
	}
	
	function popular_review()
	{
		global $db;
		global $memcache;
		$reviews_list_arr = array();
		/*if(MEMCACHE_IS_ENABALED){
			$key = md5("popular_review_function"); // Unique Words
			$reviews_list_arr = $memcache->get($key); // Memcached object 
		}*/
		if(empty($reviews_list_arr)){
		  $reviews_list="select b.album_seo, b.album_picture,a.artist_seo,a.artist_seo, a.artist_name,s.song_seo, s.song_title,s.updated_by_itunes,s.picture,r.* 
					 from tbl_reviews r,tbl_artists a,tbl_songs s,  tbl_artist_album b , tbl_songs_artist_album saa  
					 where 1=1 
					 AND r.song_id = s.id
					 AND r.artist_id = a.id
					 AND r.album_id = b.id
					 AND s.ranking_order != 0
					 AND s.id = saa.song_id 
					 AND s.song_status = 1 
					 AND saa.display_status = 1
					 group by saa.song_id
					 order by r.review_id desc					
					 limit 3
					 ";
					$reviews_list_arr	=	$db->get_results($reviews_list,ARRAY_A);
					
			if(MEMCACHE_IS_ENABALED){
				$memcache->set($key, $reviews_list_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
			}
		}		
			return  $reviews_list_arr;		
					
	}
	
	function artist_popular_review($artist_id_db)
	{
		global $db;
		global $memcache;
		$reviews_list_arr = array();
		/*if(MEMCACHE_IS_ENABALED){
			$key = md5("artist_popular_review_function_".$artist_id_db); // Unique Words
			$reviews_list_arr = $memcache->get($key); // Memcached object 
		}*/
		if(empty($reviews_list_arr)){
			
		 	$reviews_list="select b.album_seo, b.album_picture,a.artist_seo,a.artist_seo, a.artist_name,s.song_seo,s.picture,s.updated_by_itunes, s.song_title,r.* 
					 from tbl_reviews r,tbl_artists a,tbl_songs s,  tbl_artist_album b , tbl_songs_artist_album saa  
					 where 1=1 
					 AND r.song_id = s.id
					 AND r.artist_id = a.id
					 AND r.album_id = b.id
					 AND s.ranking_order != 0
					 AND s.id = saa.song_id
					 AND saa.display_status = 1 
					 AND s.song_status = 1
					  group by saa.song_id
					 order by r.artist_id = $artist_id_db desc,r.review_id desc
					 limit 3
					 ";
			$reviews_list_arr	=	$db->get_results($reviews_list,ARRAY_A);
			if(MEMCACHE_IS_ENABALED){
				$memcache->set($key, $reviews_list_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
			}	

		}			
			return  $reviews_list_arr;		
					
	}
	
	function artist_popular_review_data($artist_id_db)
	{
		global $db;
		global $memcache;
		$reviews_list_arr = array();
		/*if(MEMCACHE_IS_ENABALED){
			$key = md5("artist_popular_review_function_".$artist_id_db); // Unique Words
			$reviews_list_arr = $memcache->get($key); // Memcached object 
		}*/
		if(empty($reviews_list_arr)){
			
		  	$reviews_list="select b.album_seo, b.album_picture,a.artist_seo,a.artist_seo, a.artist_name,s.song_seo,s.picture,s.updated_by_itunes, s.song_title,r.* 
					 from tbl_reviews r,tbl_artists a,tbl_songs s,  tbl_artist_album b , tbl_songs_artist_album saa  
					 where 1=1 
					 AND r.song_id = s.id
					 AND r.artist_id = a.id
					 AND r.album_id = b.id
				     AND r.artist_id = '$artist_id_db'
					 AND s.id = saa.song_id 
					 AND s.song_status = 1
					 group by saa.song_id
					 order by  r.review_id desc
					 limit 3
					 ";
			$reviews_list_arr	=	$db->get_results($reviews_list,ARRAY_A);
			if(MEMCACHE_IS_ENABALED){
				$memcache->set($key, $reviews_list_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
			}	

		}			
			return  $reviews_list_arr;		
					
	}
	
	function popular_review_artist()
	{
		global $db;
		global $memcache;
		$reviews_list_arr = array();
		/*if(MEMCACHE_IS_ENABALED){
			$key = md5("popular_review_artist_function"); // Unique Words
			$reviews_list_arr = $memcache->get($key); // Memcached object 
		}*/
		if(empty($reviews_list_arr)){
		
		 $reviews_list="select b.album_seo,s.picture,s.updated_by_itunes,b.album_picture,a.artist_seo,a.artist_seo, a.artist_name,s.song_seo, s.song_title,r.* 
					 from tbl_reviews r,tbl_artists a,tbl_songs s,  tbl_artist_album b  
					 where 1=1 
					 AND r.song_id = s.id
					 AND r.artist_id = a.id
					 AND r.album_id = b.id
					 AND a.id = r.artist_id 
					 AND s.song_status = 1 
					 order by r.review_id desc
					 limit 3
					 ";
					$reviews_list_arr	=	$db->get_results($reviews_list,ARRAY_A);
					if(MEMCACHE_IS_ENABALED){
						$memcache->set($key, $reviews_list_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
					}
		}
					
			return  $reviews_list_arr;		
					
	}
	
	function popular_album()
	{
		global $db;
		global $memcache;
		$reviews_list_arr = array();
		/*if(MEMCACHE_IS_ENABALED){
			$key = md5("popular_review_artist_function"); // Unique Words
			$reviews_list_arr = $memcache->get($key); // Memcached object 
		}*/
		if(empty($reviews_list_arr)){
		
					$reviews_list="select b.album_seo,s.picture, b.album_picture,a.artist_seo,a.artist_seo, a.artist_name,s.song_seo, s.song_title, s.updated_by_itunes,r.* 
					 from tbl_reviews r,tbl_artists a,tbl_songs s,  tbl_artist_album b , tbl_songs_artist_album saa  
					 where 1=1 
					 AND r.song_id = s.id
					 AND r.artist_id = a.id
					 AND r.album_id = b.id
					 AND b.ranking_order != 0
					 AND b.id = saa.album_id
					 AND saa.display_status = 1 
					 AND s.song_status = 1
					 group by r.review_id
					 order by r.review_id desc
					  limit 3
					 ";
					$reviews_list_arr	=	$db->get_results($reviews_list,ARRAY_A);
					if(MEMCACHE_IS_ENABALED){
						$memcache->set($key, $reviews_list_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
					}
					
		}		
			return  $reviews_list_arr;		
					
	}
	
////Recent Reviewa
	function featured_screen($db_song_id,$artist_name,$artist_seo)
	{
		global $db;
		global $memcache;
		$artist_seo=strtolower($artist_seo);
		$qry_feature_arr = array();
		if(MEMCACHE_IS_ENABALED){
			$key = md5("featured_screen_".$db_song_id.'_'.$artist_name.'_'.$artist_seo); // Unique Words
			$qry_feature_arr = $memcache->get($key); // Memcached object 
		}
		if(empty($qry_feature_arr)){
		
			$qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '".$db_song_id."'";
			$qry_feature_arr = $db->get_results($qry_top_feature_artist,ARRAY_A);
			if(MEMCACHE_IS_ENABALED){
						$memcache->set($key, $qry_feature_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
			}
			
		}



	$count  = count($qry_feature_arr);
	$num = 1;
									  
  $featured_screen = "<a class='featured_art' href='".SERVER_ROOTPATH.$artist_seo."-artist-songs'>".$artist_name."</a>";							
  
  if($qry_feature_arr)
  {
	 $sum_len = 0;
	
	$string_art = strlen($artist_name);
	
	$maxString = 28;
	$minString = 15;
	if($string_art > $maxString){ echo '...';}elseif($string_art < $maxString){
	 
	$totval = ($maxString - $string_art)-5;
	
	
	$featured_screen .= "<a class='featured_art'> ft. </a>";
	 
	 foreach($qry_feature_arr as $val_feature)
	 {	
		$val_feature['f_artist_seo']=strtolower($val_feature['f_artist_seo']);	

		//	$num==$count means those loops have only one featured artists											 
		if($num==$count)
		{
			$str_length = strlen($val_feature['feature_artist']);
			$sum_len = $sum_len + $str_length;
			if($sum_len>$minString)
			{
				$feature_art  = substr($val_feature['feature_artist'],0,$totval);
				if(strlen($val_feature['feature_artist'])>$totval){
				$featured_screen .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";						}else{
				$featured_screen .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";							}
				break;
			}
			else
			{
				$feature_art  = substr($val_feature['feature_artist'],0,$totval);
				if(strlen($val_feature['feature_artist'])>$totval){
				$featured_screen .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>";						}else{
				$featured_screen .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";
				}break;
			}	
			
			
		}
		
		else
		{   // for those loops having more than one featured artists
			$str_length = strlen($val_feature['feature_artist']);
			$sum_len = $sum_len + $str_length;
			if($sum_len>$minString)
			{
				$feature_art  = substr($val_feature['feature_artist'],0,$totval);
				if(strlen($val_feature['feature_artist'])>$totval){

					//echo $remaing_space = strlen($val_feature['feature_artist']) - $totval;
					//echo $remaining_feature_art  = substr($val_feature['feature_artist'],0,$remaing_space);
				$featured_screen .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>";
				}else{

				$remaing_space =  28 - $sum_len -5;
				$remaing_feature_art  = substr($val_feature['feature_artist'],0,$remaing_space);
				$featured_screen .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$remaing_feature_art."..</a>";
				}break;
			}
			else
			{
				$feature_art  = substr($val_feature['feature_artist'],0,$totval);
				if(strlen($val_feature['feature_artist'])>$totval){
				$featured_screen .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>, ";
				}else{
				$featured_screen .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>, ";							}
			}	
		}
		$num++;
	 }
}
  }

return  $featured_screen;		

}

	function featured_ipad($db_song_id,$artist_name,$artist_seo)
	{
		global $db;
		global $memcache;
		$qry_feature_arr = array();
		$artist_seo=strtolower($artist_seo);
		if(MEMCACHE_IS_ENABALED){
			$key = md5("featured_ipad_".$db_song_id.'_'.$artist_name.'_'.$artist_seo); // Unique Words
			$qry_feature_arr = $memcache->get($key); // Memcached object 
		}
						if(empty($qry_feature_arr)){
						
							$qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '".$db_song_id."'";
							$qry_feature_arr = $db->get_results($qry_top_feature_artist,ARRAY_A);
							if(MEMCACHE_IS_ENABALED){
										$memcache->set($key, $qry_feature_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
							}
																  
						}
												  $count  = count($qry_feature_arr);
												  $num = 1;
												  $featured_ipad = "<a class='featured_art' href='".SERVER_ROOTPATH.$artist_seo."-artist-songs'>".$artist_name."</a>";							
												  if($qry_feature_arr)
												  {
													 $sum_len = 0;
													
													$string_art = strlen($artist_name);
													
													if($string_art > 18){ echo '...';}elseif($string_art < 18){
													 
													$totval_pad = (18 - $string_art) -5;
													
													
													$featured_ipad .= "<a class='featured_art'> ft. </a>";
													 
													 foreach($qry_feature_arr as $val_feature)
													 {		
													 
													 $val_feature['f_artist_seo']=strtolower($val_feature['f_artist_seo']);
														if($num==$count)
														{
															$str_length = strlen($val_feature['feature_artist']);
															$sum_len = $sum_len + $str_length;
															if($sum_len>15)
															{
																$feature_art  = substr($val_feature['feature_artist'],0,$totval_pad);
																if(strlen($val_feature['feature_artist'])>$totval_pad){
																$featured_ipad .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>";						}else{
																$featured_ipad .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";							}
																break;
															}
															else
															{
																$feature_art  = substr($val_feature['feature_artist'],0,$totval_pad);
																if(strlen($val_feature['feature_artist'])>$totval_pad){
																$featured_ipad .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>";						}else{
																$featured_ipad .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";
																}
															}	
															
															
														}
														
														else
														{
															$str_length = strlen($val_feature['feature_artist']);
															$sum_len = $sum_len + $str_length;
															if($sum_len>15)
															{
																$feature_art  = substr($val_feature['feature_artist'],0,$totval_pad);
																if(strlen($val_feature['feature_artist'])>$totval_pad){
																$featured_ipad .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>";
																}else{
																$featured_ipad .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";
																}break;
															}
															else
															{
																$feature_art  = substr($val_feature['feature_artist'],0,$totval_pad);
																if(strlen($val_feature['feature_artist'])>$totval_pad){
																$featured_ipad .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>,";
																}else{
																$featured_ipad .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>,";							}
															}	
														}
														$num++;
													 }
												}
												  }
					
			return  $featured_ipad;		
					
	}
	
	function featured_mobile($db_song_id,$artist_name,$artist_seo)
	{
		global $db;
		global $memcache;
		$artist_seo=strtolower($artist_seo);
		$qry_feature_arr = array();
		if(MEMCACHE_IS_ENABALED){
			$key = md5("featured_mobile_".$db_song_id.'_'.$artist_name.'_'.$artist_seo); // Unique Words
			$qry_feature_arr = $memcache->get($key); // Memcached object 
		}
		if(empty($qry_feature_arr)){
			
			$qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '".$db_song_id."'";
			$qry_feature_arr = $db->get_results($qry_top_feature_artist,ARRAY_A);
			
						if(MEMCACHE_IS_ENABALED){
											$memcache->set($key, $qry_feature_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
						}
			 
		 
		}
												  $count  = count($qry_feature_arr);
												  $num = 1;
												  $featured_mobile .= "<a class='featured_art' href='".SERVER_ROOTPATH.$artist_seo."-artist-songs'>".$artist_name."</a>";							
												  if($qry_feature_arr)
												  {
													 $sum_len = 0;
													
													$string_art = strlen($artist_name);
													
													if($string_art > 18){ echo '...';}elseif($string_art < 18){
													 
													$totval = (18 - $string_art) -5;
													
													
													$featured_mobile .= "<a class='featured_art'> ft. </a>";
													 
													 foreach($qry_feature_arr as $val_feature)
													 {		
														
														
													 $val_feature['f_artist_seo']=strtolower($val_feature['f_artist_seo']);
														if($num==$count)
														{
															$str_length = strlen($val_feature['feature_artist']);
															$sum_len = $sum_len + $str_length;
															if($sum_len>15)
															{
																$feature_art  = substr($val_feature['feature_artist'],0,$totval);
																if(strlen($val_feature['feature_artist'])>$totval){
																$featured_mobile .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>";						}else{
																$featured_mobile .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";							}
																break;
															}
															else
															{
																$feature_art  = substr($val_feature['feature_artist'],0,$totval);
																if(strlen($val_feature['feature_artist'])>$totval){
																$featured_mobile .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>";						}else{
																$featured_mobile .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";
																}
															}	
															
															
														}
														
														else
														{
															$str_length = strlen($val_feature['feature_artist']);
															$sum_len = $sum_len + $str_length;
															if($sum_len>15)
															{
																$feature_art  = substr($val_feature['feature_artist'],0,$totval);
																if(strlen($val_feature['feature_artist'])>$totval){
																$featured_mobile .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>";
																}else{
																$featured_mobile .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";
																}break;
															}
															else
															{
																$feature_art  = substr($val_feature['feature_artist'],0,$totval);
																if(strlen($val_feature['feature_artist'])>$totval){
																$featured_mobile .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>,";
																}else{
																$featured_mobile .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>,";							}
															}	
														}
														$num++;
													 }
												}
												  }
					
			return  $featured_mobile;		
					
	}


////	
	function feature_songs($db_song_id)
	{
		global $db;
		global $memcache;
		$qry_feature_arr = array();
		if(MEMCACHE_IS_ENABALED){
			$key = md5("feature_songs_".$db_song_id); // Unique Words
			$qry_feature_arr = $memcache->get($key); // Memcached object 
		}
		if(empty($qry_feature_arr)){
		
					$qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '".$db_song_id."'";
                    $qry_feature_arr = $db->get_results($qry_top_feature_artist,ARRAY_A);
					if(MEMCACHE_IS_ENABALED){
											$memcache->set($key, $qry_feature_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
					
					}
															  
		}
												  $count  = count($qry_feature_arr);
												  $num = 1;
												  $feature_artists = "";
												  if($qry_feature_arr)
												  {
													 $sum_len = 0;
													 $feature_artists .= "<a class='featured_art'> ft. </a>";
													 
													 foreach($qry_feature_arr as $val_feature)
													 {		
													 
													 $val_feature['f_artist_seo']=strtolower($val_feature['f_artist_seo']);
														if($num==$count)
														{
															$str_length = strlen($val_feature['feature_artist']);
															$sum_len = $sum_len + $str_length;
															if($sum_len>15)
															{
																$feature_art  = substr($val_feature['feature_artist'],0,10);
																if(strlen($val_feature['feature_artist'])>10){
																$feature_artists .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>";						}else{
																$feature_artists .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";							}
																break;
															}
															else
															{
																$feature_art  = substr($val_feature['feature_artist'],0,10);
																if(strlen($val_feature['feature_artist'])>10){
																$feature_artists .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>";						}else{
																$feature_artists .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";
																}
															}	
															
															
														}
														
														else
														{
															$str_length = strlen($val_feature['feature_artist']);
															$sum_len = $sum_len + $str_length;
															if($sum_len>15)
															{
																$feature_art  = substr($val_feature['feature_artist'],0,10);
																if(strlen($val_feature['feature_artist'])>10){
																$feature_artists .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>";
																}else{
																$feature_artists .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";
																}break;
															}
															else
															{
																$feature_art  = substr($val_feature['feature_artist'],0,10);
																if(strlen($val_feature['feature_artist'])>10){
																$feature_artists .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>,";
																}else{
																$feature_artists .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>,";							}
															}	
														}
														$num++;
													 }
												  }
					
			return  $feature_artists;		
					
	}
	
	function feature_responsive($db_song_id)
	{
		global $db;
		global $memcache;
		$qry_feature_arr = array();
		if(MEMCACHE_IS_ENABALED){
			$key = md5("feature_responsive_".$db_song_id); // Unique Words
			$qry_feature_arr = $memcache->get($key); // Memcached object 
		}
		if(empty($qry_feature_arr)){
				$qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '".$db_song_id."'";
			    $qry_feature_arr = $db->get_results($qry_top_feature_artist,ARRAY_A);
				if(MEMCACHE_IS_ENABALED){
					$memcache->set($key, $qry_feature_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
					
				}
					
				
		}
												  $count  = count($qry_feature_arr);
												  $num = 1;
												  $feature_responsive = "";
												  if($qry_feature_arr)
												  {
													 $sum_len = 0;
													 $feature_responsive .= "<a class='featured_art'> ft. </a>";
													 
													 foreach($qry_feature_arr as $val_feature)
													 {		
													 $val_feature['f_artist_seo']=strtolower($val_feature['f_artist_seo']);
														if($num==$count)
														{
															$str_length = strlen($val_feature['feature_artist']);
															$sum_len = $sum_len + $str_length;
															if($sum_len>15)
															{
																$feature_art  = substr($val_feature['feature_artist'],0,4);
																if(strlen($val_feature['feature_artist'])>4){
																$feature_responsive .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>";
																}else{
																$feature_responsive .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";}
																break;
															}
															else
															{
																$feature_art  = substr($val_feature['feature_artist'],0,4);
																if(strlen($val_feature['feature_artist'])>4){
																$feature_responsive .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>"; }else{
																$feature_responsive .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>"; }
															}	
															
															
														}
														
														else
														{
															$str_length = strlen($val_feature['feature_artist']);
															$sum_len = $sum_len + $str_length;
															if($sum_len>15)
															{
																$feature_art  = substr($val_feature['feature_artist'],0,4);
																if(strlen($val_feature['feature_artist'])>4){
																$feature_responsive .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>";}else{
																$feature_responsive .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";}
																break;
															}
															else
															{
																$feature_art  = substr($val_feature['feature_artist'],0,4);
																if(strlen($val_feature['feature_artist'])>4){
																$feature_responsive .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art.'..'."</a>,";}else{
																$feature_responsive .= "<a class='featured_art' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>,";}
															}	
														}
														$num++;
													 }
												  }
					
			return  $feature_responsive;		
					
	}
	
$setting_data_qry = "select site_mode, analaytic from tbl_setting where setting_id='1'";
$setting_data_arr = $db->get_row($setting_data_qry,ARRAY_A);
$site_mode   	  = $setting_data_arr['site_mode'];	


function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 $pos = strpos($pageURL, 'www');
 if($pos==false)
 {
 	 $pageURL = 'http';
	 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://www.";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
 }
 
 return $pageURL;
}

 $string = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

 $posfind = strpos($string,'www'); 


if (strpos($string,'www') !== false) {
    //echo 'true';
}
else
{
	$redirect = curPageURL();
	?>
	<script type="text/javascript">
		window.location.href = "<?php echo $redirect;?>";
	</script>
	<?php
	exit;
}

if(($site_mode==2 && $currentFile!="maintance.php") && ($_SESSION['reviewsite_cpadmin_id']==''))
{
	?>
	<script type="text/javascript">
		window.location.href = "<?php echo SERVER_ROOTPATH;?>maintance.php";
	</script>
	<?php
	exit;
}
?>
<?php
$tablet_browser = 0;
$mobile_browser = 0;
 
if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
}
 
if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
}
 
if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
}
 
$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
    'newt','noki','palm','pana','pant','phil','play','port','prox',
    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
    'wapr','webc','winw','winw','xda ','xda-');
 
if (in_array($mobile_ua,$mobile_agents)) {
    $mobile_browser++;
}
 
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
    $mobile_browser++;
    //Check for tablets on opera mini alternative headers
    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
      $tablet_browser++;
    }
}
 
if ($tablet_browser > 0) {
   $mobile_view = 0; //mobile_view =1 (16-09-16)
}
else if ($mobile_browser > 0) {
   $mobile_view = 1;
}
else {
   $mobile_view = 0;
}   
 
 $ipad_view = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
?>
<?php
/*$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
$mobile_view = 1; }else{ $mobile_view =0;}*/

//require 'mobile_decter.php';
?>