<?php
$setting_qry = "select * from tbl_general_setting where setting_id='1'";
$setting_arr	=	$db->get_row($setting_qry,ARRAY_A);
$facebook_right_script  = stripslashes(html_entity_decode($setting_arr['facebook_right_script']));
$facebook_bottom_script	= stripslashes(html_entity_decode($setting_arr['facebook_bottom_script']));
$desktop_version_logo	= $setting_arr['desktop_version_logo'];

$rate_review	= stripslashes(html_entity_decode($setting_arr['rate_review']));
$discuss	= stripslashes(html_entity_decode($setting_arr['discuss']));
$profile	= stripslashes(html_entity_decode($setting_arr['profile']));
$rhyming_larics	= stripslashes(html_entity_decode($setting_arr['rhyming_larics']));
if($user_seo!="")
{
	
 	$select_img ="select user_id,date_added,user_name  from  tbl_users where user_seo='".$user_seo."' ";
	$result_image = $db->get_row($select_img, ARRAY_A);
	$user_name = $result_image['user_name'];
	$user_profile = $result_image['user_id'];
	$date_added_db = $result_image['date_added'];
	$USER_NAME = $user_name;
	
	$main_link = get_user_detail($USER_NAME)."-profile-";
}
else
{
	$user_profile = $_SESSION[USER_SESSION_ARRAY]['USER_ID'];
	$USER_NAME = $_SESSION[USER_SESSION_ARRAY]['USER_NAME'];
	$main_link = "";
}

if($_SESSION[USER_SESSION_ARRAY]['USER_ID']!="")
{
	$select_notification_count ="select u.user_name,l.like_type,u.profile_image, l.like_id  from  tbl_likes l, tbl_users u  where l.like_from_user_id = u.user_id  AND (l.like_type = 'review_song' OR l.like_type = 'profile' OR l.like_type = 'playlist' OR l.like_type = 'delete_review_song' OR l.like_type = 'admin_review') AND l.like_receive_user = '".$_SESSION[USER_SESSION_ARRAY]['USER_ID']."' AND l.read_status = 1";
	$result_notification_count = count($db->get_results($select_notification_count, ARRAY_A));
}


$social_query  = "Select * from tbl_social_links ";
$arr_social    = $db->get_row($social_query, ARRAY_A);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9869744050959987"
     crossorigin="anonymous"></script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="google-site-verification" content="bTEn7HDhG7Kcx4pW3zDeFu-PwgLzlE1GDLc1bzj3Wbs" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>
<?php
if($currentFile=='song_local_detail.php')
{
	$artist_name	=	$_REQUEST['artist_seo'];
	$song_seo		=	$_REQUEST['song_seo']; 
	echo ucwords(str_replace('-', ' ',$artist_name))." - ". ucwords(str_replace('-', ' ',$song_seo))." - Write a Review | Tailem";
}
else
{

 $title=str_replace(array("-",'/')," ",$_SERVER['REQUEST_URI']);
 $title= str_replace("  t","'t",$title);
 $output = preg_replace('!\s+!', ' ', $title);

 $output=explode(".html",$output);
 $output=ucfirst(trim($output[0]));
 $output=explode("reviews",$output);
 if($output[1]!=""){ 
	$output=trim($output[1])." - ".trim($output[0])." reviews"; 
 }else{
	 $output=$output[0];
	 $output=preg_replace('/[0-9]+/', '', $output);
 }
 $title = basename($_SERVER['SCRIPT_FILENAME'], '.php');
 // replace dashes with whitespace
 $title = str_replace('_', ' ', $title);
 // check if the file is index, if so assign 'home' to the title instead of index
 if (strtolower($title) == 'index') {
  echo $title = 'Music Reviews | Tailem';
 }else{
 // capitalize all words
  $title = ucwords($output);
  $title = str_replace("Cms",'',$title);
   echo str_replace("_", " ", $title)." | Tailem";
 }
} 
 
?>
</title>
<?php include("top_script_files.php");?>

<?php 
$setting_qry = "select * from tbl_setting where setting_id='1'";
$setting_arr	=	$db->get_row($setting_qry,ARRAY_A);
echo $analaytic	=	$setting_arr['analaytic'];

?>
<script type="text/javascript">
	function show_notification()
		{	
			
			$.ajax
			({
				type: "POST",
				url: JS_SERVER_PATHROOT+'process/notification_display.php',
				data: '',
				before: gotonew(),
				success: function(msg)
				{
					
					$('#loader_new').html('');
					$('#notify_list2').html(msg);
					$('#notify_list2').show();
					
					
					
				}
			});
		
			
		}
		
			function gotonew()
			{ 
				$('#loader_new').html('<img src="<?php echo SERVER_ROOTPATH;?>images/load.gif" />');
				$('#loader_new').show();
			}
</script>
</head>
<!-- <div id="loading">
<img id="loading-image" src="assets/common/ajax-loader.gif" alt="Loading..."  style="left: 39.7%;"/>
</div> -->
<body>

<?php //$user_profile = $_SESSION[USER_SESSION_ARRAY]['USER_ID']; ?>
<!-- Header start -->
<header>
  <div class="container pad_left" style="padding-right:8px;"> <a href="<?php echo SERVER_ROOTPATH;?>" class="logo" style="float:left;"> <img src="<?php echo SERVER_ROOTPATH;?>images/logo11.png" style="margin-bottom:2px;"> </a>
    <div class="mob_elements">
      <p class="mob_search" id="mob_search"> <a href="javascript:void(0)"><i class="fa fa-search" aria-hidden="true"></i></a> </p>
      <p class="mob_navigat" style="margin-right:0; font-size:32px;"> <a href="javascript:void(0)"><i class="fa fa-bars" aria-hidden="true"></i></a> </p>
    </div>
    <div class="head_left" style="float:right;">
      <ul class="topnav" id="nav">
        <li><a href="<?php echo SERVER_ROOTPATH;?>top-songs">Top Songs</a></li>
        <li><a href="<?php echo SERVER_ROOTPATH;?>top-albums">Top Albums</a></li>
        <li><a href="<?php echo SERVER_ROOTPATH;?>latest-songs">Latest Songs</a></li>
        <li><a href="<?php echo SERVER_ROOTPATH;?>top-artists">Artists</a></li>
      </ul>
      <span class="search_container" id="search_bar">
      <form <?php if($mobile_view == 1){?>style="margin-bottom:8px;" <?php }?>  action="<?php echo SERVER_ROOTPATH;?>searcher" method="POST">
        <input class="searcharea" placeholder="Search"  name="search" value="<?php echo stripslashes($_SESSION[main_search]['search']);?>" required>
        <input type="hidden" name="submitbtn" value="Search">
        <button><i class="sprite sprite-icon_search"></i></button>
      </form>
      </span>
      <ul class="account_nav">
        <?php if(empty($_SESSION[USER_SESSION_ARRAY]['USER_ID'])){ ?>
        <li> <a href="<?php echo SERVER_ROOTPATH;?>sign-in" class="signin"> <i class="sprite-new sprite-new-xicon_signin-png-pagespeed-ic-d7QTJCwNDt"></i> Sign In</a> </li>
        <li> <a href="<?php echo SERVER_ROOTPATH;?>sign-up" class="signup"><i class="sprite-new sprite-new-icon_signup"></i> <span style="margin-left:1px;">Sign UP</span></a> </li>
        <?php } else { ?>
        <li><a href="<?php echo SERVER_ROOTPATH;?>review-artist" class="my-account">MY ACCOUNT</a></li>
        <li><a href="<?php echo SERVER_ROOTPATH;?>logout.php" class="logout">LOGOUT</a></li>
        <li id="notification_li" style="text-transform:none;">
          <?php  if($result_notification_count!=0)
					 {
					 ?>
          <span id="notification_count">
          <?php
					 	 echo $result_notification_count;
					 ?>
          </span>
          <?php
					}
		
		if($mobile_view == 0) 
		{
			?>
            <a href="javascript:;" id="notificationLink" onClick="show_notification()"  style="padding-left:0 !important;"><span  id="shownotification"> <img src="<?php echo SERVER_ROOTPATH;?>images/icon_post6.png" style="height:18px; margin:4px 0;" border="0" title="Notification" class="ipad_float"> <b class="mobile-only" style="font-weight: normal; float: left; margin-left: 5px;">NOTIFICATIONS</b></span> </a>
            <?php
		}
		else
		{
			?>
            <a href="javascript:;" id="notificationLink" onClick="show_notification()"><span  id="shownotification"> <img src="<?php echo SERVER_ROOTPATH;?>images/icon_post6.png" style="height:18px; margin:4px 0; float:left;" border="0" title="Notification"><b class="mobile-only" style="font-weight: normal; float: left; margin-left: 5px;">NOTIFICATIONS</b></span> </a>
            <?php
		}
		?>
					
         
         
          
          <div id="notificationContainer" style="z-index:999999">
            <div id="notificationTitle">Notifications <a style="float:right; font-size:10px; font-family:Arial, Helvetica, sans-serif; cursor:pointer;" onClick="remove_all_notifications()" id="removeall">Remove All</a> </div>
            <div id="notificationsBody" class="notifications" style="float:left; overflow-y: auto; overflow-x: hidden; width:100%; height: 302px;">
              <div id="loader_new"></div>
              <div id="notify_list2" class="notification_outer" ></div>
            </div>
          </div>
          <div style="clear:both;"></div>
        </li>
        <?php } ?>
        <li  class="mobile_only"> <a href="<?php echo SERVER_ROOTPATH;?>top-songs">Top Songs</a> </li>
        <li class="mobile_only"> <a href="<?php echo SERVER_ROOTPATH;?>top-albums">Top Albums</a> </li>
        <li class="mobile_only"><a href="<?php echo SERVER_ROOTPATH;?>latest-songs">Latest Songs</a> </li>
        <li  class="mobile_only"> <a href="<?php echo SERVER_ROOTPATH;?>top-artists">Artists</a> </li>
      </ul>
    </div>
  </div>
</header>
<!-- ./Header end -->
<?php
// latest comment date
if($user_profile!=""){
 $comment_list_qry ="select count(*) as count_discussion from tbl_comments where comment_user_id = '".$user_profile."' order by comment_id desc limit 1";	
		 $comment_list_arr	=	$db->get_row($comment_list_qry,ARRAY_A);
 
 		// recent like pick query
		$like_list_qry ="select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '".$user_profile."' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1";	
		$like_list_arr	=	$db->get_row($like_list_qry,ARRAY_A);
		
		// recent review pick query
		 $review_list_qry ="select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '".$user_profile."' order by r.review_id desc limit 1"; 	
		$review_list_arr_top	=	$db->get_row($review_list_qry,ARRAY_A);
}
?>
<script>
//function search_bar(){

$("#mob_search").click(function(){
    $("#search_bar").toggle();
});
//}
</script>
<script type="text/javascript" >
$(document).ready(function()
{
$("#notificationLink").click(function()
{
$("#notificationContainer").fadeToggle(300);
$("#notification_count").fadeOut("slow");
return false;
});

//Document Click
$(document).click(function()
{
$("#notificationContainer").hide();
});
//Popup Click
$("#notificationContainer").click(function()
{
return false
});

});
</script>
<style>
#nav{list-style:none;margin: 0px;
padding: 0px;}

#notify_list2 a
{
	font-size:11px;
	font-family: inherit;
}


#notification_li{position:relative}
#notificationContainer {
background-color: #fff;
border: 1px solid rgba(100, 100, 100, .4);
-webkit-box-shadow: 0 3px 8px rgba(0, 0, 0, .25);
overflow: visible;
position: absolute;
top: 30px;
margin-left: -405px;
width: 432px;
z-index: -1;
display: none;
}
#notificationContainer:before {
content: '';
display: block;
position: absolute;
width: 0;
height: 0;
color: transparent;
border: 11px solid black;
border-color: transparent transparent white;
margin-top: -13px;
margin-left: 410px;
}
#notificationTitle {
z-index: 1000;
font-weight: bold;
padding: 8px;
font-size: 13px;
background-color: #ffffff;
width: 430px;
border-bottom: 1px solid #dddddd;
}
#notificationsBody {
padding: 5px 0px 0px 0px !important;
min-height:300px;
}
#notificationFooter {
background-color: #e9eaed;
text-align: center;
font-weight: bold;
padding: 8px;
font-size: 11px;
border-top: 1px solid #dddddd;
}
#notification_count {
background: #c00 none repeat scroll 0 0;
    border-radius: 12px;
    color: #fff;
    font-size: 11px;
    font-weight: bold;
    margin-left: 26px;
    margin-top: 0;
    padding: 1px 7px;
    position: absolute;
}

 .remove_noti
	 {
	 	 color: #858585;
    cursor: pointer;
    display: inline;
    font-size: 11px;
   
	 }

.mobile_left
{
	font-size:11px; padding-left:0; padding-right:0; font-family:inherit; min-height:50px;
}

.profile_image
{
	text-align: center; padding: 0px;
}

@media (max-width: 700px){
	#notificationContainer {
background-color: #fff;
border: 1px solid rgba(100, 100, 100, .4);
-webkit-box-shadow: 0 3px 8px rgba(0, 0, 0, .25);
overflow: visible;
position: absolute;
top: 30px;
margin-left: -140px;
width: 315px;
z-index: -1;
display: none;
}
#notificationContainer:before {
content: '';
display: block;
position: absolute;
width: 0;
height: 0;
color: transparent;
border: 10px solid black;
border-color: transparent transparent #F6F6F7;
margin-top: -20px;
margin-left: 153px;
}

.mobile_left
{
	font-size:11px; padding-left:7px; padding-right:0; font-family:inherit; min-height:50px;
}

#notificationTitle {
z-index: 1000;
font-weight: bold;
padding: 8px;
font-size: 13px;
background-color: #ffffff;
width: 312px;
border-bottom: 1px solid #dddddd;
}
	 .remove_noti
	 {
	 	 color: #858585;
    cursor: pointer;
    display: inline;
    font-size: 11px;
    padding: 0
	 }
	 
	 
	 #notify_list2 a
	 {
	 font-size:9px;
	 }
	 
	 .account_nav li a
	 {
	 	padding: 0 !important;
	 }
	
	.profile_image
	{
		padding: 0 6px;
	}	 
}
</style>
