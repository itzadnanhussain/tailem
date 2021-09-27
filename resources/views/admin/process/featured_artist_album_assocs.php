<?php
include("../includes/top.php");
include(dirname(dirname(__FILE__))."/common/thumbnail.class.php");
error_reporting(0);

if(isset($_POST)) 
{

	$errorstr="";
	$case = 1;
	
	
	$song_id = trim($_REQUEST['song_id']);
    $main_artist = trim($_REQUEST['main_artist']);
    $album_id = trim($_REQUEST['album_id']);
	$sizeofarray   =  sizeof($_REQUEST['featured_artist']);

	
	$dec_main_artist   = base64_decode($main_artist);
	$dec_album_id   = base64_decode($album_id);
	$dec_song_id    = base64_decode($song_id);
	$link	=	"artist_id=".$main_artist."&album_id=".$album_id;
	
	/*if($sizeofarray==0)
	{
		$errorstr .= "Please select at least one artist\n";
		$case = 0;
	}*/
	

	if($case==1)
	{
	   
		$arr  = $_REQUEST['featured_artist'];
		$del_qry="delete from tbl_featured_artist_assocs where  main_artist = '$dec_main_artist' and album_id='$dec_album_id' and song_id='$dec_song_id'";

		mysqli_query($db->dbh, $del_qry);
		
		for($m=0;$m<$sizeofarray;$m++)
		{
		 $query="insert into 
		 tbl_featured_artist_assocs
		 set 
		 main_artist='$dec_main_artist',
		 featured_artist='".mysqli_escape_string($db->dbh, stripslashes($arr[$m]))."',
		 album_id='$dec_album_id',
		 song_id='$dec_song_id',
		 add_date=NOW()";
		$db->query($query);
		}
		echo 'done-SEPARATOR-'.$link;
	}
	else
	{
		echo $errorstr;
	}
}
?>
