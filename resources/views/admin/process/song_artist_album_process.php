<?php
include("../includes/top.php");
include(dirname(dirname(__FILE__))."/common/thumbnail.class.php");
error_reporting(0);
if(isset($_POST)) 
{

	
	$errorstr="";
	$case = 1;
	
	function SEO($input)
	{ 
		$input = str_replace("&nbsp;", " ", $input);
		$input = str_replace(array("'", "-"), "", $input); //remove single quote and dash
		$input = mb_convert_case($input, MB_CASE_LOWER, "UTF-8"); //convert to lowercase
		$input = preg_replace("#[^a-zA-Z]+#", "-", $input); //replace everything non an with dashes
		$input = preg_replace("#(-){2,}#", "$1", $input); //replace multiple dashes with one
		$input = trim($input, "-"); //trim dashes from beginning and end of string if any
		return $input; 
	}
	
	
	$artist_id    = trim($_REQUEST['artist_id']);
	$song_id    = trim($_REQUEST['song_id']);
	$album   =  sizeof($_REQUEST['album']);
	
	$dec_artist_id    = base64_decode(trim($_REQUEST['artist_id']));
	$dec_id    = base64_decode(trim($_REQUEST['song_id']));
	

	$song_list="SELECT sa.id,a.artist_img,s.song_title,a.artist_name, sa.song_id, sa.artist_id FROM tbl_songs s, tbl_songs_artist sa, tbl_artists a where 1=1 AND a.id = sa.artist_id AND sa.song_id = s.id AND sa.song_id = '$dec_id'";	
	$multi_artist = $db->get_results($song_list,ARRAY_A);
	$count_num = count($multi_artist);
												
	$song_list_arr	=	$db->get_row($song_list,ARRAY_A);
	
	$sizeofalbum  = sizeof($_REQUEST['album']);
	
	
	$update_id = $_REQUEST['update_id'];
 
	
	if(!$song_list_arr)
	{
		$errorstr .="Invalid song and artist ID\n";
		$case = 0;
	}
	
	
	
	if($case==1)
	{
		
			
			
			$arr  = $_REQUEST['album'];
			
			$db->query("update tbl_songs_artist_album set display_status = 0 where song_id='".mysqli_escape_string($db->dbh, stripslashes($dec_id))."' AND artist_id='".mysqli_escape_string($db->dbh, stripslashes($dec_artist_id))."'");
			
			$check_count = 0;
			for($m=0;$m<=$sizeofalbum;$m++)
			{
				
				if($count_num>1)
				{
					
					foreach($multi_artist as $multi_artist)
					{
						$artist_get_id  =  $multi_artist['artist_id'];
						
						 $query_list="select display_status from tbl_songs_artist_album where song_id = $dec_id AND artist_id = $artist_get_id  AND album_id = '".$arr[$m]."'";	
											
						$album_list_arr	=	$db->get_row($query_list,ARRAY_A);
						
						//echo $album_list_arr['display_status'];	
						
						
						if($album_list_arr)
						{	
							if($album_list_arr['display_status']==0)
							{
									$db->query("update tbl_songs_artist_album set display_status = 1 where song_id='".mysqli_escape_string($db->dbh, stripslashes($dec_id))."' AND artist_id='".mysqli_escape_string($db->dbh, stripslashes($artist_get_id))."' AND album_id = '".$arr[$m]."'");
									
									
									
							}
							
						}
						else
						{
							$check_count++;
							
							 if($arr[$m]!="" && $arr[$m]!=0)
							{
								
							$db->query("insert into tbl_songs_artist_album set song_id='".mysqli_escape_string($db->dbh, stripslashes($dec_id))."',artist_id='".mysqli_escape_string($db->dbh, stripslashes($artist_get_id))."',status='1', 	display_status='1', posted_date='".time()."', album_id = '".$arr[$m]."'");
							}
						}
					}
				}
				
				else
				{
					 $query_list="select display_status from tbl_songs_artist_album where song_id = $dec_id AND artist_id = $dec_artist_id  AND album_id = '".$arr[$m]."'";	
												
					$album_list_arr	=	$db->get_row($query_list,ARRAY_A);
					
					
					if($album_list_arr)
					{	
						if($album_list_arr['display_status']==0)
						{
						
								$db->query("update tbl_songs_artist_album set display_status = 1 where song_id='".mysqli_escape_string($db->dbh, stripslashes($dec_id))."' AND artist_id='".mysqli_escape_string($db->dbh, stripslashes($dec_artist_id))."' AND album_id = '".$arr[$m]."'");
						}
						
					}
					else
					{
						$check_count++;
						
						 if($arr[$m]!="" && $arr[$m]!=0)
						{
						
						
						$db->query("insert into tbl_songs_artist_album set song_id='".mysqli_escape_string($db->dbh, stripslashes($dec_id))."',artist_id='".mysqli_escape_string($db->dbh, stripslashes($dec_artist_id))."',status='1', 	display_status='1', posted_date='".time()."', album_id = '".$arr[$m]."'");
						}
					}
				}
			}

		echo 'done-SEPARATOR-'.SERVER_ADMIN_PATH."artist_list_album_song.php?song_id=$song_id&artist_id=$artist_id";
	}
	else
	{
		echo $errorstr;
	}
}
