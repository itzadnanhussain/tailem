@include('common.header')
<!-- ./Header end -->
<style>
	body {
		overflow-x: hidden;
	}

	.modal {
		overflow-y: auto;
	}

	.modal-open {
		overflow: auto;
	}
</style>
<!-- Middle Section -->
<section class="middle_sec" style="overflow-x : hidden;">

	<div class="banner">
		<div class="banner_body">
			<h1 class="bnr_heading">Discover Music</h1>
			<div class="banner-search">
				<form action="<?php echo SERVER_ROOTPATH; ?>searcher" method="POST">
					<div class="form-group">
						<label for="search">All</label>
						@csrf
						<input type="text" class="form-control" id="skills" name="search" placeholder="Search for an Artist, Album or Song" required>
						<button name="submitbtn" value="Search" type="submit" class="btn"><i class="sprite-new sprite-new-xsearch-icon-png-pagespeed-ic-XjnYgjYQAr"></i></button>
					</div>
				</form>
			</div><!-- banner-search -->
		</div>
	</div>


	<!-- ///Latest songs -->
	@include('common.latest_songs')


	<!-- Advertisement Banner Start-->
	<div class="container" style="padding:20px 0 20px 0;">
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-0 col-xs-0 review_screen_txt">&nbsp;</div>
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="text-align:center;">
				<?php echo ads_info('Top'); ?>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-0 col-xs-0 review_screen_txt">&nbsp;</div>
		</div>
	</div>
	<!--Advertisement Banner End-->
	<div class="container">
		<div class="topsongssec" style="padding-top:0;">
			<div class="row">
				<div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
					<div class="listslider" id="featured-songs">
						@include('common.featured_songs')
					</div>
				</div>
				<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
					<h3>Top Songs</h3>
					<p class="songsubhead" style="text-transform: none;">Best collections of the month</p>
					<table class="song_list">
						@include('common.top_songs_list')
					</table>
					<a href="top-songs"><button>
							<div style="width:300px;margin-left:auto;margin-right:auto;">view more top songs<i class="sprite sprite-icon_music_white" style="float:right"></i></div>
						</button></a>
				</div>
			</div>
		</div>

		@include('common.popular_reviews_home')

		<!-- Advertisement Banner Start-->

		<div class="container" style="padding-bottom:10px;">

			<div class="row">

				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">&nbsp;</div>

				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="margin-left:auto; margin-right:auto; vertical-align:middle;">

					<?php echo ads_info('Bottom'); ?>

				</div>

				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">&nbsp;</div>

			</div>

		</div>

		<!--Advertisement Banner End-->
	</div>

</section>




<div style="clear:both;">
	<?php
	//include_once("common/popular_review"); 
	?>


	<!--- Data modal for featured song section -->
	<div class="modal fade" id="feature_Modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
	<script type="text/javascript">
		$(window).load(function() {
			$('#owl-carousel1').owlCarousel({
				loop: false,
				margin: 10,
				responsiveClass: true,
				nav: true,
				responsive: {
					0: {
						items: 1,

					},
					700: {
						items: 2,

					},
					1000: {
						items: 3,

						loop: false,
						margin: 20
					}
				}
			})
			$('#owl-carousel2').owlCarousel({
				loop: false,
				margin: 10,
				autoHeight: true,
				responsiveClass: true,
				dot: false,
				responsive: {
					0: {
						items: 1,
						nav: true
					},

				}
			})
		})
	</script>
	<script type="text/javascript">
		$(function() {
			/*	
			$.ajax({
				url: "<?php echo SERVER_ROOTPATH; ?>ajax_calls/featured_songs",
				beforeSend: function( xhr ) {
					$("#featured-songs").html("Loading...");
				}
			})
			.done(function( data ) {
				
				
				$("#featured-songs").html(data);
				
				$('#owl-carousel2').owlCarousel({
			    loop:false,
			    margin:10,
			    responsiveClass:true,
			    responsive:{
					0:{
			            items:1,
			            nav:false
			        },
			        700:{
						items:2,
			            nav:false
			        },
			        1000:{
						items:3,
			            nav: false,
	                    loop: false,
	                    margin: 20
			        }
			    }
			})
			
			
			
		});
			*/


			$('.topsongssec .next').on('click', function() {
				$('.topsongssec .owl-next').click();
			})
			$('.topsongssec .prev').on('click', function() {
				$('.topsongssec .owl-prev').click();
			})
		})
	</script>


	@include("common.signin_modal")
	<?php
	//include "common/popular_reviews_home"; 
	?>

	<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
	@include('common.footer')

	