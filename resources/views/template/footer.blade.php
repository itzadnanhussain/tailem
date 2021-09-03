
<footer>
	<div class="ftrcontainer">
		<div class="container">
			<ul class="bottom_nav">
				<li><a href="/top-songs">Top Songs</a></li>
				<li><a href="/top-albums">Top Albums</a></li>
				<li><a href="/top-artists">Artists</a></li>
				<li><a href="/about-us">About Us</a></li>
				<li><a href="/privacy-policy">Privacy Policy</a></li>
				<li><a href="/terms-of-use">Terms of Use</a></li>
				<li><a href="/contact-us">Contact Us</a></li>
			</ul>
			<ul class="bottom_nav" style="float:right">
				<?php
				// $setting_qry = "select * from tbl_setting where setting_id='1'";
				// $setting_arr	=	$db->get_row($setting_qry, ARRAY_A);
				// $itune_url	=	$setting_arr['itune_url'];
				?>
				<?php
				if (isset($itune_url) && ($itune_url != '')) {
				?>
					<li><a href="<?php echo $itune_url; ?>" class="itune" target="_blank"><img src="<?php echo SERVER_ROOTPATH; ?>images/ituneimg.png"></a></li>
				<?php
				}
				?>
				<li><label>Connect with us</label></li>
				<li> <a href="" target="_blank"> <i class="sprite sprite-icon_fb"></i></a></li>
				<li><a href="" target="_blank"><i class="sprite sprite-icon_tw"></i></a></li>
				<li><a href="" target="_blank"> <i class="sprite sprite-icon_ggl"></i></a></li>
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
	<p>&copy; 2017 <a href="#">Tailem</a>.com All Rights Reserved</p>
</footer>