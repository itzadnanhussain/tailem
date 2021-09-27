<div id="owl-carousel2" class="owl-carousel">
								
<?php
$artist_list_arr = array();
if(MEMCACHE_IS_ENABALED){
	$key = md5("featured-songs-home"); // Unique Words
	$artist_list_arr = $memcache->get($key); // Memcached object  
  }
if(empty($artist_list_arr)){
echo  $artist_list="select tbl_songs.song_seo,tbl_songs.song_title,  tbl_songs.rate_song,tbl_songs.picture,tbl_songs.id,`tbl_songs_artist_album`.`artist_id`, `tbl_songs_artist_album`.`album_id`,`tbl_songs_artist_album`.`song_id`,tbl_artist_album.album_picture, tbl_artist_album.id,tbl_artist_album.album_title from 
tbl_songs inner join tbl_songs_artist_album ON `tbl_songs_artist_album`.`song_id`=tbl_songs.id 
inner join tbl_artist_album on tbl_artist_album.id = tbl_songs_artist_album.album_id
where  tbl_songs.popularity = 1 and tbl_songs_artist_album.display_status =1 order by tbl_songs.id desc limit 300";


$artist_list_arr	=	$db->get_results($artist_list,ARRAY_A);
if(MEMCACHE_IS_ENABALED){
	$memcache->set($key, $artist_list_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
}
}
/*echo "<pre>";
print_r($artist_list_arr);
echo "</pre>";*/
$artist_list_arr_new[0]=$artist_list_arr[rand(0,count($artist_list_arr))];
$artist_list_arr_new[1]=$artist_list_arr[rand(0,count($artist_list_arr))];
$artist_list_arr_new[2]=$artist_list_arr[rand(0,count($artist_list_arr))];
if(isset($artist_list_arr_new)){

	$c=0; $sno_val=0;
	foreach($artist_list_arr as $val){
	if($val['artist_id']!=""){	
	
	$SQL="Select artist_name,artist_seo from `tbl_artists` WHERE `id` = ".$val['artist_id']."";
	
	$artist_info	=	$db->get_results($SQL,ARRAY_A);
	
	
	$sno_val++;
	$id	    		= $val['id'];	
	$song_id	    = $val['song_id'];	
	$song_title 	= stripslashes(html_entity_decode($val['song_title']));
	$main_artist    = stripslashes(html_entity_decode($val['artist_id']));
	$album_id 		= stripslashes(html_entity_decode($val['album_id']));
	$song_rating    = stripslashes(html_entity_decode($val['rate_song']));
	$artist_seo 	= strtolower(stripslashes(html_entity_decode($artist_info[0]['artist_seo'])));
	$album_artist_id= stripslashes(html_entity_decode($val['artist_id']));
	$song_seo 		= strtolower(stripslashes(html_entity_decode($val['song_seo'])));
	$album_title 	= stripslashes(html_entity_decode($val['album_title']));
	$picture  			= stripslashes(html_entity_decode($val['picture']));
	$album_picture 	= stripslashes(html_entity_decode($val['album_picture']));
	$artist_name	= stripslashes(mysqli_escape_string($db->dbh, $artist_info[0]['artist_name']));
	
	
	$counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'artist' AND like_id = '$main_artist'"));
	 $qry_top_feature_artist = array();
	if(MEMCACHE_IS_ENABALED){
		$key = md5("qry_top_feature_artist".$song_id); // Unique Words
	 	$qry_top_feature_artist = $memcache->get($key); // Memcached object 
	}
	if(empty($qry_top_feature_artist_N)){
		 $qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '".$song_id."'";
		$qry_feature_arr = $db->get_results($qry_top_feature_artist,ARRAY_A);
		if(MEMCACHE_IS_ENABALED){
			$memcache->set($key, $artist_list_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
		}
	}
	
	
	$count  = count($qry_feature_arr);
	$num = 1;
	$feature_artists = "";
	if($qry_feature_arr){
	$feature_artists .= "<a style='display: inline;'>ft. </a>";
	$sum_len = 0;
	foreach($qry_feature_arr as $val_feature){		
	if($num==$count){
	$str_length = strlen($val_feature['feature_artist']);
	$sum_len = $sum_len + $str_length;
	if($sum_len>25)	{
		$feature_art  = substr($val_feature['feature_artist'],0,1)."...";
		$feature_artists .= " <a style='display: inline;' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";
		break;
	}
else{
$feature_art  = $val_feature['feature_artist'];
$feature_artists .= "<a style='display: inline;' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";
	}	
	}else{
	$str_length = strlen($val_feature['feature_artist']);
	$sum_len = $sum_len + $str_length;
	if($sum_len>25){
	$feature_art  = substr($val_feature['feature_artist'],0,1)."...";
	$feature_artists .= " <a style='display: inline;' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>";
	break;
	}else{
	$feature_art  = $val_feature['feature_artist'];
	$feature_artists .= " <a style='display: inline;' href='".SERVER_ROOTPATH.$val_feature['f_artist_seo']."-artist-songs'>".$feature_art."</a>,";
	}
	}
	$num++;
	}
	}
	/***************** For Song picture ************/
	$image_get="";
	if($picture!=""){
		 $image_get = $picture;
		 $image_get_new=album_img_api($image_get);
	}elseif($picture==""){
		$req_song  =  artist_album_song_func($artist_name,$song_title);
		if($req_song['song_array']['image5']!=""){	
			$image_get = $req_song['song_array']['image5'];
			$image_get_new=album_img_api($image_get);
		}elseif($album_picture!=""){
			$image_get = $album_picture;
			$image_get_new=album_img_api($image_get);
			$image_get_new="/site_upload/song_images/".$image_get_new;
			
		}else{
			$image_get = COOKIE_FREE_ROOTPATH.'assets/images/no_image.png';
		}													
	}
	
	
	
	if($image_get_new!=""){
		
		$image_get=$image_get_new;
		
	}
	
	$pos = strpos($image_get, 'http');
	if ($pos === false) {
		$image_get="/site_upload/song_images/".$image_get;
	}
	
	/******* For song name *****/
	if(strlen($val['song_title']) >= '30'){ $song_title = substr($val['song_title'],0,30).' ...';}
	else{ $song_title = $val['song_title']; }
	/**** For artist name *****/
	if(strlen($artist_info[0]['artist_name']) >= '20'){ $artist_name = substr($artist_info[0]['artist_name'],0,20).' ...';}else{ $artist_name = $artist_info[0]['artist_name']; }	
		$rate_arr = array();
		if(MEMCACHE_IS_ENABALED){
			$key = md5("tbl_reviews_sum_arating".$song_id); // Unique Words
			
			$rate_arr = $memcache->get($key); // Memcached object 
		}
	if(empty($rate_arr)){
		$sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = ".$song_id." AND status = 1";
		$rate_arr	=	$db->get_row($sum_rating,ARRAY_A);
		if(MEMCACHE_IS_ENABALED){
		$memcache->set($key, $rate_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
		}
	}
	$sum_rate = $rate_arr['sum_rate'];
	$counter = $rate_arr['counter'];
	if($sum_rate=="" || $sum_rate==0)
	{
	$sum_rate = 0;
	}
	$all_avg  =  $sum_rate / $counter;
	if($all_avg==""){ $all_avg = 0;}elseif($all_avg == "10"){$all_avg= 10;}else{$all_avg = $all_avg.'.0';}
	if($all_avg >=7){$color_pick = "#5ebd5e";}
	if($all_avg >=4 && $all_avg <=6.9){$color_pick = "#e06d21";}
	if($all_avg >=0 && $all_avg <=3.9){$color_pick = "#dd554e";}
	
	if($song_rating >=7){
	$color_picker = "#5ebd5e";
	} elseif($song_rating >=4 && $song_rating <=6.9){
	$color_picker = "#e06d21";
	} elseif($song_rating >=0 && $song_rating <=3.9){
	$color_picker = "#dd554e";
	}
	?>
	<div>
			<div class="list_item">
				<div class="album_cover">
					<?php
                    if($mobile_view == 1)
					{
						?>
                        <img src="<?php echo $image_get; ?>" style="height:300px;">
                        <?php
					}
					else
					{
						?>
                        <img src="<?php echo $image_get; ?>">
                        <?php
					}
					?>
					
					 <cite style="left:10px !important; background:none !important; text-transform: capitalize !important;">Featured Song</cite>
					<cite style="background-color:<?php echo $color_pick;?>"><?php if($all_avg<10){echo number_format($all_avg,1);}else { echo $all_avg;}?></cite>
					<div class="list_bottom">
						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<p><a href="<?php echo SERVER_ROOTPATH.$song_seo."-reviews-".$artist_seo;?>"><?php echo $song_title; ?></a><a class="artist-name" href="<?php echo SERVER_ROOTPATH.$artist_seo."-artist-songs";?>"><?php echo $artist_name;?></a><span><?php echo $feature_artists; $sum_len  = 0;?></span></p>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
							<?php
							if($_SESSION[USER_SESSION_ARRAY]['USER_ID']!=""){
							$counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '".$_SESSION[USER_SESSION_ARRAY]['USER_ID']."' AND like_type = 'artist' AND like_id = '$album_artist_id'"));
							if($counter > 0){ $class="like-group liked"; }else{ $class = "like-group";}
							if($counter==0){
							?>
							<span style="float:right;" class="<?php echo $class; ?>" id="other_dis_sub_popular_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_popular('<?php echo $album_artist_id;?>','<?php echo $sno_val;?>','<?php echo $artist_seo;?>')"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i> </a>
							<a  href="<?php echo SERVER_ROOTPATH;?>detail.php?artist=<?php echo $artist_seo;?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_5000" data-title="" class="link-disable" style="color:#fff;"> <?php echo $counter_main;?><?php if($counter_main<2){ echo " Like";} else {  echo " Likes"; }?></a>
							</span>
							<span style="float:right;" class="like-group liked" id="myStyle_sub_popular_<?php echo $album_artist_id; ?>"></span>
							<?php }else{?>
							<span style="float:right;" class="<?php echo $class; ?>" id="other_dis_sub_popular_<?php echo $album_artist_id; ?>">
							<a href="javascript:;" onClick="add_in_favourite_list_sub_artist_popular('<?php echo $album_artist_id;?>','<?php echo $sno_val;?>','<?php echo $artist_seo;?>')"><i class="fa fa-heart" style="font-size:24px;"></i></a>
							<a href="<?php echo SERVER_ROOTPATH;?>detail.php?artist=<?php echo $artist_seo;?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_5000" data-title="" class="link-disable" style="color:#fff;"> <?php echo $counter_main;?><?php if($counter_main<2){ echo " Like";} else {  echo " Likes"; }?></a></span>
							<span style="float:right;" class="like-group liked" id="myStyle_sub_popular_<?php echo $album_artist_id; ?>"></span>
							<?php
							  }
							}else{
							?>
							<span class="like-group" style="float:right;">
                                <?php
                              if($_SESSION[USER_SESSION_ARRAY]['USER_ID']=="")
							  {
							  	?>
                                <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;" ></i></a>
                                
                                <?php
							  }
							  else
							  {
							  	?>
                              <a href="javascript:;" onClick="add_in_favourite_list_sub_artist_popular('<?php echo $album_artist_id;?>','5000','<?php echo $artist_seo;?>')" ><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i> </a>
                                <?php
							  }
							  ?>
                              
                              
							<a href="<?php echo SERVER_ROOTPATH;?>detail.php?artist=<?php echo $artist_seo;?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_5000" data-title=""  class="like link-disable" style="margin-left:4px;color:#fff;"> <?php echo $counter_main;?><?php if($counter_main<2){ echo " Like";} else {  echo " Likes"; }?></a></span>
							<?php
							}
							?>
							</div>
						</div>

					</div>
					<div class="gradientoverlay"></div>
				</div>
			</div>
		</div>
	<?php } }
	}
	?>
</div>
						<a href="javascript:void(0)" class="prev"><i class="sprite sprite-owl_prev"></i></a>
						<a href="javascript:void(0)" class="next"><i class="sprite sprite-owl_next"></i></a>