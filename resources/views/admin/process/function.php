<?php
function get_small_thumb($img){
	
	$output=str_replace('300x300','174s',$img);
	if($output!=""){
		
	return $output; 	
	}
return $img;
}
	function artist_func($artistname)
{
		ini_set('allow_url_fopen ','ON');
		$temp = file_get_contents("http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=".trim($artistname)."&api_key=979650ff4905a23bb01e312145761ebb");
		$XmlObj = simplexml_load_string($temp);
		$info = $XmlObj->artist->bio->summary;
		$image4 = $XmlObj->artist->image[3];
		$name = $XmlObj->artist->name; 
		$url = $XmlObj->artist->url; 
		

		$val = '<a href="http://www.last.fm/music/Justin+Bieber">Read more about Justin Bieber on Last.fm</a>';
		$val = $info;
		$val =  str_replace($url,"#",$val);
		$val =  str_replace("Read more about ".$name." on Last.fm","",$val);
		$val1='<a href="#"></a>.';
		$info1 =  str_replace($val1,"",$val);
		$val2='<a href="#"></a>';
		$info =   strip_tags(str_replace($val2,"",$info1));
		
		$artist_array['artist_array']['name'] = $name;
		$artist_array['artist_array']['image4'] = $image4;
		$artist_array['artist_array']['url'] = $url;
		$artist_array['artist_array']['info'] = $info;
		return $artist_array;
	}

function artist_album_func($artistname,$albumname)
{
	
	 
		ini_set('allow_url_fopen ','ON');

		$artistname = urlencode($artistname);

		$albumname = urlencode($albumname);

		
		$temp = file_get_contents("http://ws.audioscrobbler.com/2.0/?method=album.getinfo&album=".$albumname."&artist=".$artistname."&api_key=979650ff4905a23bb01e312145761ebb");
$XmlObj = simplexml_load_string($temp);
		
		$img3 = $XmlObj->album->image[2];
			
		$album_array['album_array']['image4'] = $img3;
			return $album_array;
			

}

function artist_album_song_func($artistname,$song_title)
{
	 /****************** LASTFM CALL********/
	 
		ini_set('allow_url_fopen ','ON');

		$artistname = urlencode($artistname);

		$track = urlencode($song_title);

		$temp = file_get_contents("http://ws.audioscrobbler.com/2.0/?method=track.getInfo&artist=".$artistname."&track=".$track."&api_key=979650ff4905a23bb01e312145761ebb");

		$XmlObj = simplexml_load_string($temp);

		$song_url_fm = $XmlObj->track->url;
		
		$song_summary_fm = $XmlObj->track->wiki->summary;
		
		$song_image_fm = $XmlObj->track->album->image[2];
		$song_image_fm3 = $XmlObj->track->album->image[3];
		
		
			
		$song_array['song_array']['image4'] = $song_image_fm;
		$song_array['song_array']['image5'] = $song_image_fm3;
			return $song_array;
			
}

function limit_text($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
    }
	
	
	
		function get_listof_songs_ids_main($album_id, $artid)
	{
		global $db;
		  $artist_list="select b.album_title, b.album_seo, saa.song_id, saa.artist_id from tbl_songs_artist_album saa, tbl_artist_album b where saa.album_id = b.id AND saa.artist_id = '$artid' AND saa.album_id = '$album_id' AND saa.display_status = 1 ";
		
	 
		$artist_list_arr	=	$db->get_results($artist_list,ARRAY_A);
		$total_result	=	count($artist_list_arr);
		$u=1;
		$list  = '';
		if($artist_list_arr)
		{
		
			foreach($artist_list_arr as $arr)
			{
				if($u==$total_result)
				{
					$list .=  $arr['song_id'];
				}
				else
				{
					$list .=  $arr['song_id'].", ";
				}
				$u++;	
			}
		}
		
	
		return $list;
	}
	 function calculate_rating_main($album_id, $artist_id, $albseo)
	{
		
		global $db;
		
		 
		$listof_ids  =	get_listof_songs_ids_main($album_id, $artist_id);
		if($listof_ids=='')
		{
			$pass_where = '';
		}
		else
		{
			$pass_where = " OR (rev.song_id IN ($listof_ids))";
		}
		
	$where_condition .= " AND (rev.album_id = '$album_id' $pass_where)";

		
		$sum_rating_query	="select avg(rev.review_rating) as total_sum, Count(*) as number_count
							from tbl_artist_album b, tbl_artists a, tbl_songs s, tbl_reviews rev, tbl_users u 
							where 1=1 
							AND s.id = rev.song_id 
							AND a.id = rev.artist_id 
							AND b.id = rev.album_id 
							AND u.user_id = rev.review_user_id  
							
							$where_condition
							group by song_id
							  LIMIT 50";
							 
							
		 $rate_list_arr	=	$db->get_results($sum_rating_query,ARRAY_A);	
		 $sum = 0;
		 $total_count	=	count($rate_list_arr);
		 if($rate_list_arr)
		 {
		 	
		 	foreach($rate_list_arr as $get_avg)
			{
				$sum_rates  = $get_avg['total_sum'];
				$sum	=	$sum + $sum_rates;
			}	
		 }	
		 
		 /*
	 $total_sum_rating	=	 $rate_list_arr['total_sum'];
		 
		 $number_count		=	$rate_list_arr['number_count'];			
		 */
		 $total_Rating	=	$sum/$total_count;
							 
		 return $total_Rating;
	}
	
	function check_report_review($review_id)
	{
			global $db;
			$report_query = "select r_report_id  from tbl_review_report where r_report_user_id = '".$_SESSION[USER_SESSION_ARRAY]['USER_ID']."' AND r_report_review_id = '$review_id'";
			$chk_report_arr = $db->get_row($report_query, ARRAY_A);
			
			return $chk_report_arr;
			
	}
	
	function check_report_discussion($review_id)
	{
			global $db;
			 $report_query = "select r_report_id  from tbl_review_report where r_report_user_id = '".$_SESSION[USER_SESSION_ARRAY]['USER_ID']."' AND r_report_review_id = '$review_id' AND status = 1";
 
			$chk_report_arr = $db->get_row($report_query, ARRAY_A);
			
			return $chk_report_arr;
			
	}
	
	function count_likes($user_id)
	{
			global $db;
			
			$query ="select count(*) as count_total from tbl_likes where like_type = 'profile' AND like_id = '$user_id'";	
			$like_list_arr2	=	$db->get_row($query,ARRAY_A);
			
			$counter_main_profile_like	=	$like_list_arr2['count_total'];
			
				$like_list_qry ="select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '".$user_id."' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1";	
		$like_list_arr	=	$db->get_row($like_list_qry,ARRAY_A);
		
				$sum_likes = $like_list_arr['count_likes'] + $counter_main_profile_like;
			
				return $sum_likes;
			
	}
	
	function sum_of_artist_rating($artistid)
	{
		global $db;
	 	$sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where artist_id = $artistid AND status = 1";
	
		$rate_arr	=	$db->get_row($sum_rating,ARRAY_A);
		
		$sum_rate = $rate_arr['sum_rate'];
		$counter = $rate_arr['counter'];
		
		if($sum_rate=="" || $sum_rate==0)
		{
			$sum_rate = 0;
		}
		
		$all_avg  =  $sum_rate / $counter;

		if($all_avg==""){ $all_avg = 0;}
		
		if($all_avg >=8)
		{
			$color_pick = "#5cb85c";
		}
		
		if($all_avg >=6 && $all_avg <8)
		{
			$color_pick = "#5cb85c";
		}
		
		if($all_avg >=4 && $all_avg <6)
		{
			$color_pick = "#e06d21";
		}
		
		if($all_avg >=2 && $all_avg <4)
		{
			$color_pick = "#d9534f";
		}
		
		if($all_avg >0 && $all_avg <2)
		{
			$color_pick = "#d9534f";
		}
		
		$array_rating['rating_avg']	=	numberformat($all_avg);
		$array_rating['color_pick']	=	$color_pick;
		return $array_rating;
	}
	
	function numberformat($number)
	{
		$number_val =  number_format($number,1);
		return $number_val;
	}
	
	function review_count_position($reviewid, $song_id)
	{
		global $db;
	 	$query_position = "select r.review_id from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.song_id = $song_id order by r.review_id desc";	
		$data_arr	=	$db->get_results($query_position,ARRAY_A);
		$count_number  = count($data_arr);
		$s = 1;
		$u=0;
		if($count_number>10)
		{
			foreach($data_arr as $arr_list)
			{	
			$u++;
			
				$id  =  $arr_list['review_id'];
				if($reviewid==$id)
				{
					$position =  $s;
					break;
				}
				
				
				if($u%10==0)
				{
					$s++;
				}
			}
		}
		else
		{
			$position =  1;
		}
		
		return $position;	
	}
	
	// Main Artist Information
	function mainartist_detail($artistid)
	{
		global $db;
	 	$main_artist_list="select id, artist_seo, artist_name from tbl_artists where id = '$artistid'"; 
		$mainartist_arr	=	$db->get_row($main_artist_list,ARRAY_A);
		return $mainartist_arr;
	}	
	
	function addtoplaylist_icon()
	{
		$image_url  = SERVER_ROOTPATH."images/playlist.png";
		return $image_url;
	}
	
	
	function playlist_for_user()
	{
		global $db;
	 	$main_play_list="select * from tbl_user_playlist where user_id_playlist = '".$_SESSION[USER_SESSION_ARRAY]['USER_ID']."' order by id asc"; 
		$playlist_arr	=	$db->get_results($main_play_list,ARRAY_A);
		return $playlist_arr;
	}	
	
	function get_first_playlist_record($user_id)
	{
		global $db;
	 	$main_play_list="select title_playlist_seo  from tbl_user_playlist where user_id_playlist = '".$user_id."'"; 
		$playlist_arr	=	$db->get_row($main_play_list,ARRAY_A);
		return $playlist_arr;
	}
?>