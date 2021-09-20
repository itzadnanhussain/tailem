<?php
///setting arr new query 
$arr_setting = GetByWhere('setting', array('setting_id' => 1));
$arr_setting = (array)$arr_setting[0];
$itune_url	=	$arr_setting['itune_url'];

///old query
// $social_query  = "Select * from tbl_social_links ";
// $arr_social    = $db->get_row($social_query, ARRAY_A);

///new query
$arr_social = GetAllRecords('social_links');
$arr_social = (array) $arr_social[0];

?>
<?php
$currentFile = get_page_name();
// $currentFile = 'sign_up';
?>
<footer>
	<div class="ftrcontainer">
		<div class="container">
			<ul class="bottom_nav">
				<li><a href="<?php echo SERVER_ROOTPATH; ?>top-songs">Top Songs</a></li>
				<li><a href="<?php echo SERVER_ROOTPATH; ?>top-albums">Top Albums</a></li>
				<li><a href="<?php echo SERVER_ROOTPATH; ?>top-artists">Artists</a></li>
				<li><a href="<?php echo SERVER_ROOTPATH; ?>about-us">About Us</a></li>
				<li><a href="<?php echo SERVER_ROOTPATH; ?>privacy-policy">Privacy Policy</a></li>
				<li><a href="<?php echo SERVER_ROOTPATH; ?>terms-of-use">Terms of Use</a></li>
				<li><a href="<?php echo SERVER_ROOTPATH; ?>contact-us">Contact Us</a></li>
			</ul>
			<ul class="bottom_nav" style="float:right">

				<?php
				if ($itune_url != '') {
				?>
					<li><a href="<?php echo $itune_url; ?>" class="itune" target="_blank"><img src="<?php echo SERVER_ROOTPATH; ?>images/ituneimg.png"></a></li>
				<?php
				}
				?>
				<li><label>Connect with us</label></li>
				<li> <a href="<?php echo $arr_social['facebook']; ?>" target="_blank"> <i class="sprite sprite-icon_fb"></i></a></li>
				<li><a href="<?php echo $arr_social['twitter']; ?>" target="_blank"><i class="sprite sprite-icon_tw"></i></a></li>
				<li><a href="<?php echo $arr_social['google']; ?>" target="_blank"> <i class="sprite sprite-icon_ggl"></i></a></li>
			</ul>
		</div>
	</div>
	<script type='text/javascript'>
		var _merchantSettings = _merchantSettings || [];
		_merchantSettings.push(['AT', '1000l6dT']);
		(function() {
			var autolink = document.createElement('script');
			autolink.type = 'text/javascript';
			autolink.async = true;
			autolink.src = ('https:' == document.location.protocol) ? 'https://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js' : 'http://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(autolink, s);
		})();
	</script>
	<p>&copy; 2017 <a href="<?php echo SERVER_ROOTPATH; ?>">Tailem</a>.com All Rights Reserved</p>
</footer>
<?php
for ($popular_review = 1; $popular_review <= 10; $popular_review++) {
?>
	<div class="modal fade" id="missing_popular_review_Modal2_5000<?php echo $popular_review; ?>" role="dialog"></div>
	<div class="modal fade" id="missing_popular_review_Modal2_latest_<?php echo $popular_review; ?>" role="dialog"></div>
<?php
}
?>




<script language="javascript" type="text/javascript">
	$(window).load(function() {
		//$('#loading').hide();
	});
</script>
<div class="modal fade" id="missing_popular_review_Modal2_5000" role="dialog"></div>
<script type="text/javascript">
	function close_likes_popup() {
		$(document).on('hidden.bs.modal', function(e) {
			$(e.target).removeData('bs.modal');
		});
	}

	function goBack() {
		window.history.back();
	}
	/*
	$(window).bind("load", function() {
	  $('link').each(function(){
	  $(this).attr('media','all');
	  });
	});	*/
</script>
<div class="modal fade" id="delete_all_notification" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
for ($u = 1; $u <= 15; $u++) {
?>
	<div class="modal fade" id="delete_review_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
	<div class="modal fade" id="delete_comment_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}
// $currentFile = $_SERVER["SCRIPT_NAME"];
if ($currentFile == 'artists' || $currentFile == 'search' || $currentFile == 'search_artist' || $currentFile == 'search_song' || $currentFile == 'search_albumlist' || $currentFile == 'song_detail' || $currentFile == 'song_local_detail' || $currentFile == 'welcome' || $currentFile == 'review_artist' || $currentFile == 'review_album' || $currentFile == 'my_reviews' || $currentFile == 'likes_profile' || $currentFile == 'like_artist' || $currentFile == 'my_account_profile' || $currentFile == 'my_account' || $currentFile == 'my_discussion' || $currentFile == 'my_playlist' || $currentFile == 'likes_playlist') { ?>
	<link rel="stylesheet" type="text/css" href="<?php echo COOKIE_FREE_ROOTPATH; ?>css/style-update.css?id=<?php echo rand(111111, 9999999); ?>">
<?php } ?>
<?php
if ($currentFile == 'like_artist' || $currentFile == 'review_artist' || $currentFile == 'artists') {
?>
	<link rel="stylesheet" href="<?php echo COOKIE_FREE_ROOTPATH; ?>assets/search/jquery-ui.css">
	<script src="<?php echo COOKIE_FREE_ROOTPATH; ?>assets/search/jquery-1.10.2.js"></script>
	<script src="<?php echo COOKIE_FREE_ROOTPATH; ?>assets/search/jquery-ui.js"></script>
	<script>
		var jq = jQuery.noConflict();
		jq(function() {
			jq("#skills").autocomplete({
				source: '<?php echo SERVER_ROOTPATH; ?>get_artist_list'
			});
		});
	</script>
<?php
}
//$this->_mysqli->close();
?>



</body>

</html>
<div class="modal fade" id="review_modal" role="dialog"></div>
