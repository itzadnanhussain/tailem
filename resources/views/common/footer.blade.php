<?php
///setting arr new query
$arr_setting = GetByWhere('setting', array('setting_id' => 1));
$arr_setting = (array)$arr_setting[0];
$itune_url	=	$arr_setting['itune_url'];
$copy_right_text	=	$arr_setting['copy_right_text'];

///old query
// $social_query  = "Select * from tbl_social_links ";
// $arr_social    = $db->get_row($social_query, ARRAY_A);

///new query
$arr_social = GetAllRecords('social_links');
$arr_social = (array) $arr_social[0];

$social_icons = GetByWhere('social_icons');
// echo '<pre>';
// print_r($social_icons);
// echo '</pre>';
// die;

?>
<?php
$currentFile = get_page_name();
// $currentFile = 'sign_up';
?>

<?php
for ($popular_review = 1; $popular_review <= 10; $popular_review++) {
    ?>
<div class="modal fade"
	id="missing_popular_review_Modal2_5000<?php echo $popular_review; ?>"
	role="dialog"></div>
<div class="modal fade"
	id="missing_popular_review_Modal2_latest_<?php echo $popular_review; ?>"
	role="dialog"></div>
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
<div class="modal fade" id="delete_all_notification" tabindex="-1" role="dialog" aria-labelledby="basicModal"
	aria-hidden="true"></div>
<?php
for ($u = 1; $u <= 15; $u++) {
    ?>
<div class="modal fade" id="delete_review_<?php echo $u; ?>"
	tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<div class="modal fade" id="delete_comment_<?php echo $u; ?>"
	tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}
// $currentFile = $_SERVER["SCRIPT_NAME"];
if ($currentFile == 'artists' || $currentFile == 'search' || $currentFile == 'search_artist' || $currentFile == 'search_song' || $currentFile == 'search_albumlist' || $currentFile == 'song_detail' || $currentFile == 'song_local_detail' || $currentFile == 'welcome' || $currentFile == 'review_artist' || $currentFile == 'review_album' || $currentFile == 'my_reviews' || $currentFile == 'likes_profile' || $currentFile == 'like_artist' || $currentFile == 'my_account_profile' || $currentFile == 'my_account' || $currentFile == 'my_discussion' || $currentFile == 'my_playlist' || $currentFile == 'likes_playlist') { ?>
<link rel="stylesheet" type="text/css"
	href="<?php echo COOKIE_FREE_ROOTPATH; ?>css/style-update.css?id=<?php echo rand(111111, 9999999); ?>">
<?php } ?>
<?php
if ($currentFile == 'like_artist' || $currentFile == 'review_artist' || $currentFile == 'artists') {
    ?>
<link rel="stylesheet"
	href="<?php echo COOKIE_FREE_ROOTPATH; ?>assets/search/jquery-ui.css">
<script src="<?php echo COOKIE_FREE_ROOTPATH; ?>assets/search/jquery-1.10.2.js">
</script>
<script src="<?php echo COOKIE_FREE_ROOTPATH; ?>assets/search/jquery-ui.js">
</script>
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
<!-- Header start -->
<?php if (isset($user_type) && ($user_type == 'admin')) { ?>
<footer>
	<div class="ftrcontainer" style="background: white;">
		<div class="container">
			<a target="_blank" href="http://www.evsoft.pk/" style="font-size: 11px;
    color: #000000; float:right;text-decoration: underline;">Powered By eVISION Softwares </a>


		</div>
	</div>
</footer>



<?php  } else { ?>
<footer>
	<div class="ftrcontainer">
		<div class="container">
			<div class="row">
				<div class="col-sm-12" style="display: contents;">
					<ul class="bottom_nav">
						<li><a
								href="<?php echo SERVER_ROOTPATH; ?>top-songs">Top
								Songs</a></li>
						<li><a
								href="<?php echo SERVER_ROOTPATH; ?>top-albums">Top
								Albums</a></li>
						<li><a
								href="<?php echo SERVER_ROOTPATH; ?>top-artists">Artists</a>
						</li>
						<li><a
								href="<?php echo SERVER_ROOTPATH; ?>our-community">Community</a>
						</li>
						<li><a
								href="<?php echo SERVER_ROOTPATH; ?>about-us">About
								Us</a></li>
						<li><a
								href="<?php echo SERVER_ROOTPATH; ?>privacy-policy">Privacy
								Policy</a></li>
						<li><a
								href="<?php echo SERVER_ROOTPATH; ?>terms-of-use">Terms
								of Use</a></li>
						<li><a
								href="<?php echo SERVER_ROOTPATH; ?>contact-us">Contact
								Us</a></li>
					</ul>
					<ul class="bottom_nav" style="float:right">

						<?php
                    if ($itune_url != '') {
                        ?>
						<li><a href="<?php echo $itune_url; ?>"
								class="itune" target="_blank"><img
									src="<?php echo SERVER_ROOTPATH; ?>images/ituneimg.png"></a>
						</li>
						<?php
                    }
                    ?>
						<li><label>Connect with us</label></li>
						<!-- <li> <a href="<?php echo $arr_social['facebook']; ?>"
						target="_blank"> <i class="sprite sprite-icon_fb"></i></a></li> -->
						<li> <a href="<?php echo $arr_social['facebook']; ?>"
								target="_blank"><img class="sprite-icon_fb"
									src="<?php echo SERVER_ROOTPATH . $social_icons[0]->large_screen_icon ?>"
									alt=""></a></li>
						<!-- <li><a href="<?php echo $arr_social['twitter']; ?>"
						target="_blank"><i class="sprite sprite-icon_tw"></i></a></li> -->
						<li><a href="<?php echo $arr_social['twitter']; ?>"
								target="_blank"><img class="sprite-icon_tw"
									src="<?php echo SERVER_ROOTPATH . $social_icons[2]->large_screen_icon ?>"
									alt=""></a></li>
						<!-- <li><a href="<?php echo $arr_social['google']; ?>"
						target="_blank"> <i class="sprite sprite-icon_ggl"></i></a></li> -->
						<li><a href="<?php echo $arr_social['google']; ?>"
								target="_blank"><img class="sprite-icon_ggl"
									src="<?php echo SERVER_ROOTPATH . $social_icons[3]->large_screen_icon ?>"
									alt=""></a></li>
						<li><a href="<?php echo $arr_social['google']; ?>"
								target="_blank"> <img
									src="<?php echo SERVER_ROOTPATH . $social_icons[5]->large_screen_icon ?>"
									width="34" alt=""></a></li>
					</ul>

				</div>
			</div>
		</div>
	</div>
	<script type='text/javascript'>
		var _merchantSettings = _merchantSettings || [];
		_merchantSettings.push(['AT', '1000l6dT']);
		(function() {
			var autolink = document.createElement('script');
			autolink.type = 'text/javascript';
			autolink.async = true;
			autolink.src = ('https:' == document.location.protocol) ?
				'https://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js' :
				'http://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(autolink, s);
		})();
	</script>
	<p>&copy; <a href="<?php echo SERVER_ROOTPATH; ?>"><?php echo $copy_right_text; ?> </a></p>
</footer>

<?php } ?>




</body>

</html>
<div class="modal fade" id="review_modal" role="dialog"></div>
<div class="modal fade in" id="add_report_request" tabindex="-1" role="dialog" aria-labelledby="basicModal"
	aria-hidden="false">

	<div class="modal-dialog" style="margin-top:10%;">
		<div class="modal-content" style="border-radius:0px;">
			<div class="modal-header">
				<h4 class="modal-title" style="color:#3276b1;"> Thank you for using the report feature <img
						data-dismiss="modal" style="cursor:pointer; float:right;"
						src="data:image/webp;base64,UklGRg4BAABXRUJQVlA4TAIBAAAvFUAFEE+hkI0kqAqrcP6Sr4OCtm0Y7/PnNVACgRSnsMJq2khyoyNdDu1R+eoVtm2DdMy7wwMOWQ3Bh2BH40FwEAgKBUFB9pdU1E06UpGKjl4fHEa2rTQPd3duDE1e/w0i70NKiOh/kjD9OOu3LPZNutDDBkoT6iStFJepRadd4qa0addS3KYabSH+CMmocQ7riG1Z3zhrw4V4/Pg58ALpx5ADz19+Q8YFlC9vM5SqgTLw9oTSNVDWH09Q2gJy4PnLL8gihnj8+DnwAhl7EBNP2L78gfCNBuKB4wHRGBTij5A2LcNtptNuV7ipbDqdFJepQ1KPGihNpNOFGSQ5tjwJTBI="
						data-pagespeed-url-hash="3119113509"
						onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
				</h4>
			</div>
			<div class="modal-body" style="overflow-y:auto; min-height:250px;">
				<p>
					We will review your request with in 24 hours and take action accordingly.<br><br><br>

					Warmest Regards,<br>
					Team at Tailem.com
				</p>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="report_already_message" style="display:none" tabindex="-1" role="dialog"
	aria-labelledby="basicModal">
	<div class="modal-dialog" style="margin-top:10%;">
		<div class="modal-content" style="border-radius:0px;">
			<div class="modal-header">
				<h4 class="modal-title" style="color:#3276b1;"> Thank you for using the report feature <img
						data-dismiss="modal" style="cursor:pointer; float:right;"
						src="<?php echo  SERVER_ROOTPATH; ?>images/crosspng.png"
						data-pagespeed-url-hash="3119113509"
						onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
				</h4>
			</div>
			<div class="modal-body" style="overflow-y:auto; min-height:250px;">
				<p>
					We are still in the process of reviewing your request and will take action accordingly.
					<br /><br /><br />

					Warmest Regards,<br />
					Team at Tailem.com
				</p>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="post_edit_success" style="display:none" tabindex="-1" role="dialog"
	aria-labelledby="basicModal">
	<div class="modal-dialog" style="margin-top:10%;">
		<div class="modal-content" style="border-radius:0px;">
			<div class="modal-header">
				<h4 class="modal-title" style="color:#3276b1;"> Thank you for updating your post <img
						data-dismiss="modal" onclick="close_popup()" style="cursor:pointer; float:right;"
						src="<?php echo  SERVER_ROOTPATH; ?>images/crosspng.png"
						data-pagespeed-url-hash="3119113509"
						onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
				</h4>
			</div>
			<div class="modal-body" style="overflow-y:auto; min-height:250px;">
				<p>
					Your post has been updated and will appear shortly. Thank you for sharing your thoughts and we value
					your contributions to our site. <br /><br /><br />

					Warmest Regards,<br />
					Team at Tailem.com
				</p>
			</div>
		</div>
	</div>
</div>


<!-- Cannot like your own profile-->
<div class="modal fade " id="your_own_profile" style="display:none" tabindex="-1" role="dialog"
	aria-labelledby="basicModal">
	<div class="modal-dialog" style="margin-top:10%;">
		<div class="modal-content" style="border-radius:0px;">
			<div class="modal-header">
				<h4 class="modal-title" style="color:#3276b1;"> Thank you <img data-dismiss="modal"
						style="cursor:pointer; float:right;"
						src="data:image/webp;base64,UklGRg4BAABXRUJQVlA4TAIBAAAvFUAFEE+hkI0kqAqrcP6Sr4OCtm0Y7/PnNVACgRSnsMJq2khyoyNdDu1R+eoVtm2DdMy7wwMOWQ3Bh2BH40FwEAgKBUFB9pdU1E06UpGKjl4fHEa2rTQPd3duDE1e/w0i70NKiOh/kjD9OOu3LPZNutDDBkoT6iStFJepRadd4qa0addS3KYabSH+CMmocQ7riG1Z3zhrw4V4/Pg58ALpx5ADz19+Q8YFlC9vM5SqgTLw9oTSNVDWH09Q2gJy4PnLL8gihnj8+DnwAhl7EBNP2L78gfCNBuKB4wHRGBTij5A2LcNtptNuV7ipbDqdFJepQ1KPGihNpNOFGSQ5tjwJTBI="
						data-pagespeed-url-hash="3119113509"
						onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
				</h4>
			</div>
			<div class="modal-body" style="overflow-y:auto; min-height:250px;">
				<p>
					Unfortunately, you cannot like your own profile. <br /><br /><br />

					Warmest Regards,<br />
					Team at Tailem.com
				</p>
			</div>
		</div>
	</div>
</div>

<div class="modal fade in" id="your_own_review" style="display: none;" tabindex="-1" role="dialog"
	aria-labelledby="basicModal" aria-hidden="false">
	<div class="modal-dialog" style="margin-top:10%;">
		<div class="modal-content" style="border-radius:0px;">
			<div class="modal-header">
				<h4 class="modal-title" style="color:#3276b1;"> Thank you <img data-dismiss="modal"
						style="cursor:pointer; float:right;"
						src="data:image/webp;base64,UklGRg4BAABXRUJQVlA4TAIBAAAvFUAFEE+hkI0kqAqrcP6Sr4OCtm0Y7/PnNVACgRSnsMJq2khyoyNdDu1R+eoVtm2DdMy7wwMOWQ3Bh2BH40FwEAgKBUFB9pdU1E06UpGKjl4fHEa2rTQPd3duDE1e/w0i70NKiOh/kjD9OOu3LPZNutDDBkoT6iStFJepRadd4qa0addS3KYabSH+CMmocQ7riG1Z3zhrw4V4/Pg58ALpx5ADz19+Q8YFlC9vM5SqgTLw9oTSNVDWH09Q2gJy4PnLL8gihnj8+DnwAhl7EBNP2L78gfCNBuKB4wHRGBTij5A2LcNtptNuV7ipbDqdFJepQ1KPGihNpNOFGSQ5tjwJTBI="
						data-pagespeed-url-hash="3119113509"
						onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
				</h4>
			</div>
			<div class="modal-body" style="overflow-y:auto; min-height:250px;">
				<p>
					Unfortunately, you cannot like your own review. <br><br><br>

					Warmest Regards,<br>
					Team at Tailem.com
				</p>
			</div>
		</div>
	</div>
</div>


<script>
	///add_in_favourite_list_review_song_detail
	function add_in_favourite_list_review_song_detail(a, b, c) {
		let url = JS_SERVER_PATHROOT +
			"process/favourite_like_review_song_like_detail?prod_id=" +
			a +
			"&user_name=" +
			b +
			"&r_fav=" +
			c;
		$.ajax({
			type: 'POST',
			data: {
				"_token": "{{ csrf_token() }}",
			},
			url: url,
			dataType: 'html',
			success: function(b) {
				if (b == "Please sign in first") {
					$("#signin_form").modal("show");
				} else if (b.search("You cannot like your own review") != -1) {
					$("#your_own_review").modal("show");
				} else {
					$("#myStyle_sub_" + a).html(b);
					$("#myStyle_sub_" + a).show();
					$("#other_dis_sub_" + a).hide();

				}
			}
		});

	}


	///add_in_favourite_list_rev
	function add_in_favourite_list_rev(t, e) {

		let url = JS_SERVER_PATHROOT +
			"process/favourite_like_review?prod_id=" +
			t +
			"&artist_seo=" +
			e;
		$.ajax({
			type: 'POST',
			data: {
				"_token": "{{ csrf_token() }}",
			},
			url: url,
			dataType: 'html',
			success: function(e) {
				"Please sign in first" == e
					?
					alert(e) :
					($("#myStyle_sub_" + t).html(e),
						$("#myStyle_sub_" + t).show(),
						$("#other_dis_sub_" + t).hide());

			}
		});



	}
</script>

<script type="text/javascript">
	function close_popup() {

		window.location.reload();

	}
</script>


<!-- delete user Profile script -->
<script>
	function Delete_User(user_id) {
		var r = confirm(
			"Are you sure you wish to delete your account?\nPlease note that deleted account can never be recovered. ");
		var csrf_token = $('meta[name=csrf-token]').attr('content');

		if (r == true) {
			$.ajax({
				type: 'POST',
				url: '<?php echo SERVER_ROOTPATH.'delete-user-profile' ?>',
				data: {
					"_token": csrf_token,
					'user_id': user_id,
				},
				dataType: 'html',
				success: function(replay) {
					var replay = JSON.parse(replay);
					window.location.replace(replay.redirect_uri);
				}
			});

		}


	}
</script>

<div class="modal fade in" id="comment_delete" style="display: none;" tabindex="-1" role="dialog"
	aria-labelledby="basicModal" aria-hidden="false">
	<div class="modal-dialog" style="margin-top:10%;">
		<div class="modal-content" style="border-radius:0px;">
			<div class="modal-header">
				<h4 class="modal-title" style="color:#3276b1;"> Thank you <img data-dismiss="modal"
						style="cursor:pointer; float:right;" src="https://www.tailem.com/images/crosspng.png"
						data-pagespeed-url-hash="3119113509"
						onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
				</h4>
			</div>
			<div class="modal-body" style="overflow-y:auto; min-height:250px;">
				<p>
					Your post has been deleted. <br><br><br>

					Warmest Regards,<br>
					Team at Tailem.com
				</p>
			</div>
		</div>
	</div>
</div>