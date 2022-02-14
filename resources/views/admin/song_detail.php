<?php
include("common/topfile.php");
$song_list = "select a.id as artist_id,b.album_seo,b.album_artist_id,s.song_title,s.picture,s.song_seo,a.artist_seo,a.artist_name,b.album_title, b.album_picture, s.id,s.description, b.id as album_id from tbl_artist_album b, tbl_artists a, tbl_songs_artist_album saa, tbl_songs s where 1=1 AND s.id = saa.song_id AND a.id = saa.artist_id AND b.id = saa.album_id AND s.song_seo = '$song_seo' AND a.artist_seo = '$artist_seo'";

$song_list_arr	=	$db->get_row($song_list, ARRAY_A);

if ($song_list_arr) {
	$id	  = $song_list_arr['id'];
	$song_id	  = $song_list_arr['id'];

	$album_title = stripslashes(html_entity_decode($song_list_arr['album_title']));
	$album_id = stripslashes(html_entity_decode($song_list_arr['album_id']));
	$artist_name = stripslashes(html_entity_decode($song_list_arr['artist_name']));
	$album_picture   = stripslashes(html_entity_decode($song_list_arr['album_picture']));
	$song_title = stripslashes(html_entity_decode($song_list_arr['song_title']));
	$artist_seo = stripslashes(html_entity_decode($song_list_arr['artist_seo']));

	$song_seo   = stripslashes(html_entity_decode($song_list_arr['song_seo']));
	$picture   = stripslashes(html_entity_decode($song_list_arr['picture']));

	$description   = stripslashes(html_entity_decode($song_list_arr['description']));
	$album_seo  = stripslashes(html_entity_decode($song_list_arr['album_seo']));
	/****************** LASTFM CALL********/
	ini_set('allow_url_fopen ', 'ON');

	$artistname = urlencode($artist_name);

	$track = urlencode($song_title);

	$temp = file_get_contents("http://ws.audioscrobbler.com/2.0/?method=track.getInfo&artist=" . $artistname . "&track=" . $track . "&api_key=979650ff4905a23bb01e312145761ebb");

	$XmlObj = simplexml_load_string($temp);

	$song_url_fm = $XmlObj->track->url;

	$song_summary_fm = $XmlObj->track->wiki->summary;

	$song_image_fm = $XmlObj->track->album->image[2];
	/****************** LASTFM CALL********/

	$artist_id	=	stripslashes(html_entity_decode($song_list_arr['artist_id']));

	$album_title = wordwrap($album_title, 100, " ", true);
	$artist_name = wordwrap($artist_name, 100, " ", true);

	$album_artist_id = stripslashes(html_entity_decode($song_list_arr['album_artist_id']));

	$counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'artist' AND like_id = '$artist_id'"));

	$discussion_list_qry = "select u.user_name,u.profile_image, c.* from tbl_users u, tbl_comments c where u.user_id = c.comment_user_id AND c.comment_review_id = $song_id order by comment_id desc";

	$discussion_list_arr	=	$db->get_results($discussion_list_qry, ARRAY_A);

	$count_discussion  = count($discussion_list_arr);


	$sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter, sum(review_rating>=8) as excellent, sum(review_rating>=6 && review_rating<8) as verygood, sum(review_rating>=4 && review_rating<6) as good,sum(review_rating>=2 && review_rating<4) as poor,sum(review_rating>0 && review_rating<2) as terrible from tbl_reviews where song_id = $song_id AND status = 1";
	$rate_arr	=	$db->get_row($sum_rating, ARRAY_A);

	$sum_rate = $rate_arr['sum_rate'];
	$counter = $rate_arr['counter'];

	$excellent = $rate_arr['excellent'];
	$verygood = $rate_arr['verygood'];
	$good = $rate_arr['good'];
	$poor = $rate_arr['poor'];
	$terrible = $rate_arr['terrible'];

	$excellent_per = ($excellent / $counter) * 100;
	$verygood_per  = ($verygood / $counter) * 100;
	$good_per 	   = ($good / $counter) * 100;
	$poor_per 	   = ($poor / $counter) * 100;
	$terrible_per = ($terrible / $counter) * 100;
}

if ($sum_rate == "" || $sum_rate == 0) {
	$sum_rate = 0;
}


$all_avg  =  $sum_rate / $counter;

if ($all_avg == "") {
	$all_avg = 5.0;
}

if ($all_avg >= 8) {
	$color_pick = "#5cb85c";
}

if ($all_avg >= 6 && $all_avg < 8) {
	$color_pick = "#5cb85c";
}

if ($all_avg >= 4 && $all_avg < 6) {
	$color_pick = "#ff0";
}

if ($all_avg >= 2 && $all_avg < 4) {
	$color_pick = "#d9534f";
}

if ($all_avg > 0 && $all_avg < 2) {
	$color_pick = "#d9534f";
}

$all_avg = number_format($all_avg, 1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Song <?php echo $song_title; ?> :: Tailem.com</title>
	<script src='<?php echo SERVER_ROOTPATH; ?>jquery.js' type="text/javascript"></script>
	<script src='<?php echo SERVER_ROOTPATH; ?>jquery.MetaData.js' type="text/javascript" language="javascript"></script>
	<script src='<?php echo SERVER_ROOTPATH; ?>jquery.rating.js' type="text/javascript" language="javascript"></script>
	<link href='<?php echo SERVER_ROOTPATH; ?>jquery.rating.css' type="text/css" rel="stylesheet" />

	<link rel="stylesheet" type="text/css" href="<?php echo SERVER_ROOTPATH; ?>style.css" />



	<?php include_once("common/top_script_files.php"); ?>

	<script type="text/javascript">
		function sort_area(val) {
			window.location.href = "<?php echo SERVER_ROOTPATH . $song_seo ?>/reviews/<?php echo $artist_seo; ?>-sort-" + val + ".html";
		}
	</script>

</head>

<body>
	<style>
		.loader {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url('<?php echo SERVER_ROOTPATH; ?>assets/images/Preloader_21.gif') 50% 50% no-repeat rgb(249, 249, 249);
		}
	</style>
	<script type="text/javascript">
		$(window).load(function() {
			$(".loader").fadeOut("slow");
		})
	</script>

	<div class="loader"></div>


	<?php include_once("common/header.php"); ?>
	<div class="clear"></div>
	<div class="container">
		<div class="contents clearfix">

			<?php

			$qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '" . $song_id . "'";
			$qry_feature_arr = $db->get_results($qry_top_feature_artist, ARRAY_A);
			$count  = count($qry_feature_arr);
			$num = 1;
			$feature_artists = "";
			if ($qry_feature_arr) {



				foreach ($qry_feature_arr as $val_feature) {
					if ($num == $count) {
						$feature_artists .= " <a href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist.html' class='text_grey'>" . $val_feature['feature_artist'] . "</a>";
					} else {
						$feature_artists .= " <a href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist.html' class='text_grey'>" . $val_feature['feature_artist'] . "</a>,";
					}
					$num++;
				}
			}



			?>

			<div class="row">
				<div class="col-md-9">
					<div class="row">
						<div class="col-sm-3">
							<div class="clearfix display_mobile">
								<div class="pull-right text-right">
									<span class="score_big mb-10" style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg == 10) {
																															echo number_format($all_avg, 0);
																														} else {
																															echo $all_avg;
																														} ?></span><br>
									<?php
									if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] != "") {


										$counter1 =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$artist_id'"));

										if ($counter1 == 0) {
									?>
											<span id="other_dis_sub_<?php echo $artist_id; ?>" class="text_grey"><a href="javascript:;" onClick="add_in_favourite_list_sub(<?php echo $artist_id; ?>)" class="text_grey"><i class="fa fa-heart"></i> </a><span class="text_red"><?php echo $counter_main; ?></span>
												<a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#missing_store_detail_Modal3_<?php echo $artist_id; ?>" data-title="" style="color:#444;" class="text_blck link-disable"><?php if ($counter_main < 2) {
																																																																												echo " Like";
																																																																											} else {
																																																																												echo " Likes";
																																																																											} ?></a></span>

											<span id="myStyle_sub_<?php echo $artist_id; ?>" class="text_grey"></span>

										<?php
										} else {
										?>
											<span id="other_dis_sub_<?php echo $artist_id; ?>" class="text_grey"><a href="javascript:;" onClick="add_in_favourite_list_sub(<?php echo $artist_id; ?>)" class="like"><i class="fa fa-heart"></i></a> <span class="text_red"><?php echo $counter_main; ?></span> <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#missing_store_detail_Modal3_<?php echo $artist_id; ?>" data-title="" style="color:#444;" class="text_blck link-disable"><?php if ($counter_main < 2) {
																																																																																																																																												echo " Like";
																																																																																																																																											} else {
																																																																																																																																												echo " Likes";
																																																																																																																																											} ?></a></span></span>

											<span id="myStyle_sub_<?php echo $artist_id; ?>" class="text_grey"></span>
										<?php
										}
									} else {
										?>
										<span id="other_dis_sub_<?php echo $artist_id; ?>" class="text_grey"><a href="javascript:;" onClick="add_in_favourite_list_sub(<?php echo $artist_id; ?>)" class="text_grey"><i class="fa fa-heart"></i></a> <span class="text_red"><?php echo $counter_main; ?></span> <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#missing_store_detail_Modal3_<?php echo $artist_id; ?>" data-title="" style="color:#444;" class="text_blck link-disable"><?php if ($counter_main < 2) {
																																																																																																																																												echo " Like";
																																																																																																																																											} else {
																																																																																																																																												echo " Likes";
																																																																																																																																											} ?></a></span></span>
									<?php
									}
									?>

								</div>
								<a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo . ".html"; ?>" style="text-decoration:none;">
									<h2 class="mt-0"><?php echo $song_title; ?></h2>
								</a>
								<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist.html"; ?>" class="text_grey">
									<h2 class="text_grey"><?php echo $artist_name; ?></h2>
								</a>
								<div class="clear"></div>

							</div>
							<a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo . ".html"; ?>" target="_blank"> <?php
																																		if ($song_image_fm != "") {
																																		?>
									<img src="<?php echo $song_image_fm; ?>" border="0" class="img-responsive" />
								<?php
																																		} elseif ($picture != "") {
																																			$song_pic = SERVER_ROOTPATH . "site_upload/song_images/thumb_" . $picture;
								?>
									<img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>" border="0" class="img-responsive" />
								<?php
																																		} else if ($album_picture != "") {
																																			$song_pic = SERVER_ROOTPATH . "site_upload/album_images/thumb_" . $album_picture;
								?>
									<img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" class="img-responsive" />
								<?php
																																		} else {
																																			$song_pic = SERVER_ROOTPATH . "assets/images/no_image.png";
								?>
									<img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image.png" border="0" class="img-responsive" width="100" />
								<?php
																																		}
								?></a>
							<div class="clear pad-5"></div>
							<h4>Review Distribution</h4>
							<table class="Oswald" width="100%" border="0" cellpadding="3" cellspacing="0">
								<tbody>
									<tr style="height:10px;">
										<td width="70">Excellent</td>
										<td>
											<a href="<?php echo SERVER_ROOTPATH . $song_seo ?>/reviews/<?php echo $artist_seo; ?>-rating-excellent.html">
												<div class="progress mb-0" style="cursor:pointer;">
													<div class="progress-bar progress-bar-success" style="width:<?php echo $excellent_per; ?>%;  cursor:pointer;"></div>
												</div>
											</a>
										</td>
										<td style="color:#78ff00;" width="10"><a style="color:#91B23D;"><?php echo $excellent; ?></a></td>
									</tr>
									<tr>
										<td>Very Good</td>
										<td>
											<a href="<?php echo SERVER_ROOTPATH . $song_seo ?>/reviews/<?php echo $artist_seo; ?>-rating-verygood.html">
												<div class="progress mb-0" style="cursor:pointer;">
													<div class="progress-bar progress-bar-success" style="width:<?php echo $verygood_per; ?>%;  cursor:pointer;"></div>
												</div>
											</a>
										</td>
										<td class="text-success"><a style="color:#91B23D;"><?php echo $verygood; ?></a></td>
									</tr>
									<tr>
										<td>Average</td>
										<td>
											<a href="<?php echo SERVER_ROOTPATH . $song_seo ?>/reviews/<?php echo $artist_seo; ?>-rating-average.html">
												<div class="progress mb-0" style="cursor:pointer;">
													<div class="progress-bar progress-bar-warning" style="width:<?php echo $good_per; ?>%;  background-color:#FF0; cursor:pointer;"></div>
												</div>
											</a>
										</td>
										<td class="text-warning"><a style="color:#FF0;"><?php echo $good; ?></a></td>
									</tr>
									<tr>
										<td>Poor</td>
										<td>
											<a href="<?php echo SERVER_ROOTPATH . $song_seo ?>/reviews/<?php echo $artist_seo; ?>-rating-poor.html">
												<div class="progress mb-0" style="cursor:pointer;">
													<div class="progress-bar progress-bar-danger" style="width:<?php echo $poor_per; ?>%; cursor:pointer;"></div>
												</div>
											</a>
										</td>
										<td style="color:#e90101;"><a style="color:#e90101;"><?php echo $poor; ?></a></td>
									</tr>
									<tr>
										<td>Terrible</td>
										<td>
											<a href="<?php echo SERVER_ROOTPATH . $song_seo ?>/reviews/<?php echo $artist_seo; ?>-rating-terrible.html">
												<div class="progress mb-0" style="cursor:pointer;">
													<div class="progress-bar progress-bar-danger" style="width:<?php echo $terrible_per; ?>%;"></div>
												</div>
											</a>
										</td>
										<td class="text-success"><a style="color:#e90101;"><?php echo $terrible; ?></a></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-sm-9">
							<div class="display_dekstop">
								<div class="pull-right text-right">
									<span class="score_big mb-10" style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg == 10) {
																															echo number_format($all_avg, 0);
																														} else {
																															echo $all_avg;
																														} ?></span><br>
									<?php
									if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] != "") {


										$counter1 =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$artist_id'"));

										if ($counter1 == 0) {
									?>
											<span id="other_dis_sub_<?php echo $artist_id; ?>" class="text_grey"><a href="javascript:;" onClick="add_in_favourite_list_sub(<?php echo $artist_id; ?>)" class="text_grey"><i class="fa fa-heart"></i> </a><span class="text_red"><?php echo $counter_main; ?></span>
												<a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#missing_store_detail_Modal3_<?php echo $artist_id; ?>" data-title="" style="color:#444;" class="text_blck link-disable"><?php if ($counter_main < 2) {
																																																																												echo " Like";
																																																																											} else {
																																																																												echo " Likes";
																																																																											} ?></a></span>

											<span id="myStyle_sub_<?php echo $artist_id; ?>" class="text_grey"></span>

										<?php
										} else {
										?>
											<span id="other_dis_sub_<?php echo $artist_id; ?>" class="text_grey"><a href="javascript:;" onClick="add_in_favourite_list_sub(<?php echo $artist_id; ?>)" class="like "><i class="fa fa-heart"></i></a> <span class="text_red"><?php echo $counter_main; ?></span> <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#missing_store_detail_Modal3_<?php echo $artist_id; ?>" data-title="" style="color:#444;" class="text_blck link-disable"><?php if ($counter_main < 2) {
																																																																																																																																												echo " Like";
																																																																																																																																											} else {
																																																																																																																																												echo " Likes";
																																																																																																																																											} ?></a></span></span>

											<span id="myStyle_sub_<?php echo $artist_id; ?>" class="text_grey"></span>
										<?php
										}
									} else {
										?>
										<span id="other_dis_sub_<?php echo $artist_id; ?>" class="text_grey"><a href="javascript:;" onClick="add_in_favourite_list_sub(<?php echo $artist_id; ?>)" class="text_grey"><i class="fa fa-heart"></i></a> <span class="text_red"><?php echo $counter_main; ?></span> <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#missing_store_detail_Modal3_<?php echo $artist_id; ?>" data-title="" style="color:#444;" class="text_blck link-disable"><?php if ($counter_main < 2) {
																																																																																																																																												echo " Like";
																																																																																																																																											} else {
																																																																																																																																												echo " Likes";
																																																																																																																																											} ?></a></span></span>
									<?php
									}
									?>


								</div>

								<a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo . ".html"; ?>" style="text-decoration:none;">
									<h2 class="mt-0"><?php echo $song_title; ?></h2>
								</a>

								<div class="col-sm-9" style="padding:0;">
									<h3 class="text_grey"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist.html"; ?>" class="text_grey"><?php echo $artist_name; ?></a>

										<?php if ($feature_artists != "") { ?> <strong>ft.</strong> <?php echo $feature_artists;
																								} ?></h3>
								</div>

								<div class="clear"></div>
								<p><?php if ($song_summary_fm != "") {
										echo substr(strip_tags($song_summary_fm), 0, 160);
										if (strlen(strip_tags($song_summary_fm)) > 160) {
											echo "...";
										}
									?> <br><a href="<?php echo $song_url_fm; ?>"><img border="0" src="<?php echo SERVER_ROOTPATH; ?>images/fm.png"></a><?php } else {
																																						echo $description;
																																					} ?></p>
							</div>
							<?php

							echo song_adds($song_id, 'adds');
							?>
							<div class="clear pad-15"></div>
							<div class="row">
								<div class="col-xs-4 text_16 Oswald"><a style="text-decoration:none;" href="#review_focus"><?php echo $counter; ?> Reviews</a></div>
								<div class="col-xs-4 text_16 Oswald text-center"><a href="<?php echo SERVER_ROOTPATH . $song_seo . "-write-a-review-" . $artist_seo . ".html"; ?>" class="text_blue">Write a Review</a></div>
								<div class="col-xs-4 text-right text_16 Oswald"><a style="text-decoration:none;" href="#discussion"><?php echo $count_discussion; ?> Discussions</a></div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row" id="review_focus">
						<div class="col-sm-6">
							<h2>REVIEWS </h2>
						</div>
						<div class="col-sm-3">&nbsp;</div>
						<div class="col-sm-3 text-right">

							<div class="form-group mobile_width">
								<label for="sort">Sort By:</label>
								<select class="form-control" id="sort" onChange="sort_area(this.value)">
									<option value="recent_review" <?php if ($sort == "recent_review") { ?> selected<?php } ?>>Recent</option>
									<option value="highest_rating" <?php if ($sort == "highest_rating") { ?> selected<?php } ?>>Highest Rating</option>
									<option value="lowest_rating" <?php if ($sort == "lowest_rating") { ?> selected<?php } ?>>Lowest Rating</option>
									<option value="most_popular" <?php if ($sort == "most_popular") { ?> selected<?php } ?>>Most Popular</option>
								</select>
							</div>

						</div>
					</div>
					<?php

					if ($sort == "recent_review") {
						$order_by = " r.review_id desc";
					} else
				if ($sort == "highest_rating") {
						$order_by = " r.review_rating desc";
					} else
				if ($sort == "lowest_rating") {
						$order_by = " r.review_rating asc";
					} else
				if ($sort == "most_popular") {
						$order_by = " r.like_count desc";
					} else {
						$order_by = " r.review_id desc";
					}

					$rating_where  = "";
					if ($rate == "excellent") {
						$rating_where  = " AND (r.review_rating>=8)";
					} else
				if ($rate == "verygood") {
						$rating_where  = " AND (r.review_rating>=6 AND r.review_rating<8)";
					} else
				if ($rate == "average") {
						$rating_where  = " AND (r.review_rating>=4 AND r.review_rating<6)";
					} else
				if ($rate == "poor") {
						$rating_where  = " AND (r.review_rating>=2 AND r.review_rating<4)";
					} else
				if ($rate == "terrible") {
						$rating_where  = " AND (r.review_rating>=0 AND r.review_rating<2)";
					}


					$review_list_qry = "select u.user_name,u.profile_image, r.* from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.song_id = $song_id $rating_where order by $order_by";

					$review_list_arr	=	$db->get_results($review_list_qry, ARRAY_A);
					?>

					<div class="table-responsive mobile_width">
						<table class="table table_no_border">
							<tbody>

								<?php
								if ($review_list_arr) {
									$rep = 0;
									$k = 0;
									$prof_counter = 0;
									foreach ($review_list_arr as $val_review) {
										$k++;
										$rep++;
										$prof_counter++;
										$db_review_id   = $val_review['review_id'];
										$db_user_name     = stripslashes($val_review['user_name']);
										$db_review_title  = stripslashes($val_review['review_title']);
										$review_user_id  = stripslashes($val_review['review_user_id']);


										$query_likes_count  	=  count($db->get_results("select u.user_name, u.profile_image from tbl_likes l, tbl_users u where u.user_id = l.like_from_user_id AND l.like_from_user_id = $review_user_id AND l.like_type = 'profile'", ARRAY_A));


										// recent like pick query
										$like_list_user_qry = "select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '" . $review_user_id . "' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1";

										$like_list_arr_user	=	$db->get_row($like_list_user_qry, ARRAY_A);

										$review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $review_user_id . "' order by r.review_id desc limit 1";

										$review_list_arr_top	=	$db->get_row($review_list_qry, ARRAY_A);

										$comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_user_id = '" . $review_user_id . "' order by comment_id desc limit 1";

										$comment_list_arr	=	$db->get_row($comment_list_qry, ARRAY_A);


										$query_likes_count_all  	=  count($db->get_results("select u.user_name, u.profile_image from tbl_likes l, tbl_users u where u.user_id = l.like_id AND l.like_id = $review_user_id AND l.like_type = 'profile'", ARRAY_A));


										$db_review_detail = stripslashes($val_review['review_detail']);
										$db_review_post_date     = stripslashes($val_review['review_post_date']);
										$db_review_rating     = stripslashes($val_review['review_rating']);
										$db_profile_image     = stripslashes($val_review['profile_image']);
										$db_review_post_date  = date("d M Y", stripslashes($val_review['review_post_date']));

										if ($db_profile_image != "") {
											$prof_image = SERVER_ROOTPATH . "assets/phpthumb/phpThumb.php?src=" . SERVER_ROOTPATH . "site_upload/user_images/" . $db_profile_image . "&w=101&h=75&zc=1";
										} else {
											$prof_image = SERVER_ROOTPATH . "assets/phpthumb/phpThumb.php?src=" . SERVER_ROOTPATH . "assets/images/no_image.png&w=101&h=75&zc=1";
										}

										$counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'review_song' AND like_id = '$db_review_id'"));

										if ($db_review_rating >= 8) {
											$color_pick = "#5cb85c";
										}

										if ($db_review_rating >= 6 && $db_review_rating < 8) {
											$color_pick = "#5cb85c";
										}

										if ($db_review_rating >= 4 && $db_review_rating < 6) {
											$color_pick = "#ff0";
										}

										if ($db_review_rating >= 2 && $db_review_rating < 4) {
											$color_pick = "#d9534f";
										}

										if ($db_review_rating > 0 && $db_review_rating < 2) {
											$color_pick = "#d9534f";
										}

								?>
										<tr id="review_<?php echo $db_review_id; ?>">

											<td width="100" class="display_dekstop">
												<div class="img_cont">
													<a href="<?php echo SERVER_ROOTPATH . $db_user_name . "/profile-review-artist.html"; ?>"><img src="<?php echo $prof_image; ?>" width="100" alt=""></a>
													<div class="title">

														<?php
														$counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'profile' AND like_id = '$review_user_id'"));

														if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] != "") {

															$counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  like_type = 'profile' AND like_id = '$review_user_id'"));

															if ($counter == 0) {
														?>


																<a href="<?php echo SERVER_ROOTPATH; ?>detail_profile.php?user=<?php echo $db_user_name; ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_profile_<?php echo $prof_counter; ?>" data-title="" class="like text_grey link-disable" style="color:#ccc;margin-left:2px;"><?php if ($counter_main < 2) {
																																																																																							echo " Like";
																																																																																						} else {
																																																																																							echo " Likes";
																																																																																						} ?></a></span>

																<span id="myStyle_sub_profile_<?php echo $prof_counter; ?>"></span>



																<span id="other_dis_sub_profile_<?php echo $prof_counter; ?>">
																	<span class="like pull-right" style="margin-left:2px;"><?php echo $counter_main; ?></span>
																	<a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist(<?php echo $review_user_id; ?>,<?php echo $prof_counter; ?>)" class="like"><i class="fa fa-heart"></i></a>
																</span>


															<?php
															} else {
															?>

																<a href="<?php echo SERVER_ROOTPATH; ?>detail_profile.php?user=<?php echo $db_user_name; ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_profile_<?php echo $prof_counter; ?>" data-title="" class="like text_grey link-disable" style="color:#ccc;margin-left:2px;"><?php if ($counter_main < 2) {
																																																																																							echo " Like";
																																																																																						} else {
																																																																																							echo " Likes";
																																																																																						} ?></a></span>

																<span id="myStyle_sub_profile_<?php echo $prof_counter; ?>"></span>



																<span id="other_dis_sub_profile_<?php echo $prof_counter; ?>">
																	<span class="like pull-right" style="margin-left:2px;"><?php echo $counter_main; ?></span>

																	<a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist(<?php echo $review_user_id; ?>,<?php echo $prof_counter; ?>)" class="like pull-right link-disable"><i class="fa fa-heart" style="color:red;"></i></a>
																</span>
															<?php
															}
														} else {
															?>
															<a href="<?php echo SERVER_ROOTPATH; ?>detail_profile.php?user=<?php echo $db_user_name; ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_profile_<?php echo $prof_counter; ?>" data-title="" class="like text_grey link-disable" style="color:#ccc;margin-left:2px;"><?php if ($counter_main < 2) {
																																																																																						echo " Like";
																																																																																					} else {
																																																																																						echo " Likes";
																																																																																					} ?></a></span>

															<span id="myStyle_sub_profile_<?php echo $prof_counter; ?>"></span>



															<span id="other_dis_sub_profile_<?php echo $prof_counter; ?>">
																<span class="like pull-right" style="margin-left:2px;"><?php echo $counter_main; ?></span>
																<a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist(<?php echo $review_user_id; ?>,<?php echo $prof_counter; ?>)" class="like"><i class="fa fa-heart"></i></a>
															</span>

														<?php
														}
														?>
													</div>
												</div>
												<div class="mt-5 text_12">
													<a href="<?php echo SERVER_ROOTPATH . $db_user_name . "/profile-review-artist.html"; ?>" class="text_blck"><i class="fa fa-user"></i> <?php echo $db_user_name; ?></a><br>
													<a style="text-decoration:none;" class="text_blck"><i class="fa fa-heart"></i> <?php if ($like_list_arr_user['count_likes'] <= 1) {
																																		echo "Like";
																																	} else {
																																		echo "Likes";
																																	} ?> <font color="#CC0000"><?php echo $like_list_arr_user['count_likes']; ?></font></a><br>
													<a style="text-decoration:none;" class="text_blck"><i class="fa fa-clipboard"></i> Reviews <font color="#CC0000"><?php echo $review_list_arr_top['count_reviews']; ?></font></a><br>
													<a style="text-decoration:none;" class="text_blck"><i class="fa fa-comment"></i> Discussions <font color="#CC0000"><?php echo $comment_list_arr['count_discussion']; ?></font></a>
												</div>
											</td>
											<td>
												<a href="<?php echo SERVER_ROOTPATH . $db_user_name . "/profile-review-artist.html"; ?>" class="text_blck display_mobile"><i class="fa fa-user"></i> <?php echo $db_user_name; ?></a>
												<div class="row" style="margin:0;">
													<h3 class="mt-0" style="float:left;"><?php echo $db_review_title; ?></h3>
													<span class="pull-right" style="float:left;">


														<?php
														$counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'review_song' AND like_id = '$db_review_id'"));


														if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] != "") {

															$counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'review_song' AND like_id = '$db_review_id'"));

															if ($counter == 0) {
																if ($review_user_id == $_SESSION[USER_SESSION_ARRAY]['USER_ID']) {
														?>
																	<span id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" class="text_grey" title="your own review"><i class="fa fa-heart"></i> </a> <span class="text_red"><?php echo $counter_main; ?></span>
																	<?php
																} else {
																	?>
																		<span id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_review_song(<?php echo $db_review_id; ?>)" class="text_grey"><i class="fa fa-heart"></i> </a> <span class="text_red"><?php echo $counter_main; ?></span>
																		<?php
																	}
																		?>

																		<a href="<?php echo SERVER_ROOTPATH; ?>process/detail_review?user=<?php echo $db_user_name; ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#model_review_likes_<?php echo $k; ?>" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
																																																																																									echo " Like";
																																																																																								} else {
																																																																																									echo " Likes";
																																																																																								} ?></a></span>

																		<span id="myStyle_sub_<?php echo $db_review_id; ?>"></span>

																	<?php
																} else {
																	?>
																		<span id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_review_song(<?php echo $db_review_id; ?>)" class="like"><i class="fa fa-heart"></i></a> <span class="text_red"><?php echo $counter_main; ?></span>
																			<a href="<?php echo SERVER_ROOTPATH; ?>process/detail_review?user=<?php echo $db_user_name; ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#model_review_likes_<?php echo $k; ?>" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
																																																																																										echo " Like";
																																																																																									} else {
																																																																																										echo " Likes";
																																																																																									} ?></a></span>


																		<span id="myStyle_sub_<?php echo $db_review_id; ?>"></span>
																	<?php
																}
															} else {
																	?>
																	<span id="other_dis_sub_<?php echo $review_user_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_review_song(<?php echo $db_review_id; ?>)" class="text_grey"><i class="fa fa-heart"></i></a> <span class="text_red"><?php echo $counter_main; ?></span>

																		<a href="<?php echo SERVER_ROOTPATH; ?>process/detail_review?user=<?php echo $db_user_name; ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#model_review_likes_<?php echo $k; ?>" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
																																																																																									echo " Like";
																																																																																								} else {
																																																																																									echo " Likes";
																																																																																								} ?></a></span>
																	<span id="myStyle_sub_<?php echo $db_review_id; ?>"></span>

																<?php
															}
																?>
																<span class="scors" style="background-color:<?php echo $color_pick; ?>"><?php if ($db_review_rating == 10) {
																																			echo number_format($db_review_rating, 0);
																																		} else {
																																			echo $db_review_rating;
																																		} ?></span>
																	</span>
													</span>
												</div>

												<div class="row" style="margin:0;">
													<p class="display_width">
														<?php echo wordwrap($db_review_detail, 20, " ", true); ?>
													</p>
												</div>


												<div class="clear pad-5"></div>
												<div class="row">
													<div class="col-sm-6 display_dekstop">
														<?php
														$title_db = urlencode("$song_title");
														$url_db = urlencode(SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo . ".html#review_" . $db_review_id);
														$summary = urlencode("$db_review_detail");
														$image_fb = urlencode($song_pic);
														?>


														<a onClick="popupWindow('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title_db; ?>&amp;p[summary]=<?php echo $summary; ?>&amp;p[url]=<?php echo $url_db; ?>&amp;&p[images][0]=<?php echo $image_fb; ?>', 'sharer', 'toolbar=0,status=0,width=620,height=280');" href="javascript: void(0)"><img src="<?php echo SERVER_ROOTPATH; ?>images/ico_fb.png"></a>

														&nbsp;

														<a href="javascript: popupWindow('http://twitter.com/share?url=<?php echo $url_db; ?>&source=<?php echo mysqli_real_escape_string($db->dbh, $db_review_title); ?>&text=<?php echo mysqli_real_escape_string($db->dbh, substr($db_review_detail, 0, 110)); ?>')"><img src="<?php echo SERVER_ROOTPATH; ?>images/ico_tw.png"></a>


														&nbsp;
														<a href="https://plus.google.com/share?url={<?php echo $url_db; ?>&source=<?php echo mysqli_real_escape_string($db->dbh, $db_review_title); ?>}" onClick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=1000');return false;" target="_blank"><img src="<?php echo SERVER_ROOTPATH; ?>images/ico_gplus.png"></a>

													</div>
													<div class="col-sm-6 text-right">
														<span class="text_grey mr-10" style="float:left;"><?php echo $db_review_post_date; ?></span>
														<?php
														if ($review_user_id != $_SESSION[USER_SESSION_ARRAY]['USER_ID']) {
														?>
															<a href="<?php echo SERVER_ROOTPATH; ?>report.php?rev_id=<?php echo $db_review_id; ?>" data-toggle="modal" data-target="#report_Modal4_<?php echo $rep; ?>" data-title="">Report</a>
														<?php
														}
														?>

														<?php
														if ($review_user_id == $_SESSION[USER_SESSION_ARRAY]['USER_ID']) {
														?>
															<a data-title="" data-target="#edit_Modal4_<?php echo $rep; ?>" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>edit_review.php?rev_id=<?php echo $db_review_id; ?>">Edit</a>
														<?php
														}
														?>

														<span id="myStyle_report_<?php echo $rep; ?>"></span>


													</div>
												</div>

											</td>
										</tr>
								<?php
									}
								}
								?>




							</tbody>
						</table>
					</div>

					<div class="clear"></div>
					<h2 id="writereview">WRITE A REVIEW</h2>
					<div class="well">
						<form name="api-readonly" id="api-readonly" method="post" action="" class="form-horizontal">

							<div class="form-group text-right">

							</div>


							<div class="col-md-12" style="float:right; margin-bottom:10px;">
								<div class="col-md-5"> &nbsp;</div>
								<div class="col-md-3 text-right"><span class="Oswald text_16 mr-10">What is your rating?
									</span></div>
								<div class="col-md-4 text-left" style="margin-top:5px;">
									<input type="radio" class="star {split:2}" name="api-readonly-test" value=".5" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="1" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="1.5" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="2" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="2.5" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="3" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="3.5" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="4" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="4.5" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="5" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="5.5" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="6" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="6.5" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="7" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="7.5" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="8" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="8.5" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="9" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="9.5" />
									<input type="radio" class="star {split:2}" name="api-readonly-test" value="10" />
								</div>
							</div>
							<input type="hidden" name="song_seo_name" value="<?php echo $song_seo; ?>">
							<input type="hidden" name="artist_seo_name" value="<?php echo $artist_seo; ?>">

							<div style="clear:both;"></div>
							<div class="form-group">
								<input type="text" name="review_title" id="review_title" class="form-control" placeholder="Review Title">
							</div>
							<div class="form-group">
								<textarea class="form-control" rows="9" placeholder="Your Review" id="review_detail" name="review_detail"></textarea>
								<input type="hidden" name="song_id" value="<?php echo $song_id; ?>">
								<input type="hidden" name="artist_id" value="<?php echo $artist_id; ?>">
								<input type="hidden" name="album_id" value="<?php echo $album_id; ?>">

							</div>
							<p class="pull-left">By posting a review, I accept Tailem.com`s

								<?php
								$get_all_pages_qry = "SELECT page_seo_name,page_name  FROM tbl_pages where page_id = 8 OR page_id = 2 ORDER BY page_id desc";
								$get_all_pages     = $db->get_results($get_all_pages_qry, ARRAY_A);
								$count_pages = count($get_all_pages);

								if ($get_all_pages) {
									$k = 1;
									foreach ($get_all_pages as $page_info) {
								?>

										<a href="<?php echo SERVER_ROOTPATH . "detail_cms.php?seo_url=" . $page_info['page_seo_name']; ?>" data-toggle="modal" data-target="#cms_<?php echo $k; ?>" data-title="" class="text_red" style="color:#444;"><?php echo stripslashes($page_info['page_name']); ?></a>
										<?php
										if ($k == 1) {
											echo "and";
										}
										?>


								<?php
										$k++;
									}
								}
								?>
							</p>
							<input type="submit" name="submit_btn" id="submit_btn" value="Post Review" onClick="return write_a_review_validation();" class="btn btn-danger text_18 Oswald pull-right" />

						</form>
						<div class="clear"></div>
					</div>

					<div class="clear"></div>
					<h2>RELATED SONGS</h2>

					<div class="row">
						<?php

						$related_song_list = "select b.album_artist_id,s.song_title,s.picture,s.song_seo,a.artist_seo,a.artist_name,b.album_title, b.album_picture, s.id,s.description from tbl_artist_album b, tbl_artists a, tbl_songs_artist_album saa, tbl_songs s where 1=1 AND s.id = saa.song_id AND a.id = saa.artist_id AND b.id = saa.album_id AND saa.album_id = '$album_id' AND saa.song_id != $id order by rand() limit 3";
						$song_list_arr	=	$db->get_results($related_song_list, ARRAY_A);
						if (!$song_list_arr) {
							$related_song_list = "select b.album_artist_id,s.song_title,s.song_seo,a.artist_seo,a.artist_name,s.picture,b.album_title, b.album_picture, s.id,s.description from tbl_artist_album b, tbl_artists a, tbl_songs_artist_album saa, tbl_songs s where 1=1 AND s.id = saa.song_id AND a.id = saa.artist_id AND b.id = saa.album_id AND saa.artist_id = $album_artist_id AND saa.song_id != $id order by rand() limit 3";
							$song_list_arr	=	$db->get_results($related_song_list, ARRAY_A);

							if (!$song_list_arr) {
								$related_song_list = "select b.album_artist_id,s.song_title,s.song_seo,a.artist_seo,s.picture,a.artist_name,b.album_title, b.album_picture, s.id,s.description from tbl_artist_album b, tbl_artists a, tbl_songs_artist_album saa, tbl_songs s where 1=1 AND s.id = saa.song_id AND a.id = saa.artist_id AND b.id = saa.album_id AND saa.song_id != $id order by rand() limit 3";
								$song_list_arr	=	$db->get_results($related_song_list, ARRAY_A);
							}
						}
						// Related songs query first check album songs


						if (isset($song_list_arr)) {
							$rep = 0;
							$g = 0;
							$p_fav = 0;
							$sr_no = 0;
							$k = 1;
							foreach ($song_list_arr as $val) {
								$sr_no++;
								$g++;
								$p_fav++;
								$rep++;
								$id	  = $val['id'];
								$album_title = stripslashes(html_entity_decode($val['album_title']));
								$artist_name = stripslashes(html_entity_decode($val['artist_name']));
								$album_picture   = stripslashes(html_entity_decode($val['album_picture']));
								$picture   = stripslashes(html_entity_decode($val['picture']));
								$song_title = stripslashes(html_entity_decode($val['song_title']));
								$artist_seo = stripslashes(html_entity_decode($val['artist_seo']));
								$song_seo   = stripslashes(html_entity_decode($val['song_seo']));
								$album_title = wordwrap($album_title, 100, " ", true);
								$artist_name = wordwrap($artist_name, 100, " ", true);
								$album_artist_id = stripslashes(html_entity_decode($val['album_artist_id']));

								$sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = $id AND status = 1";
								$rate_arr	=	$db->get_row($sum_rating, ARRAY_A);

								$sum_rate = $rate_arr['sum_rate'];
								$counter = $rate_arr['counter'];

								if ($sum_rate == "" || $sum_rate == 0) {
									$sum_rate = 0;
								}


								$all_avg  =  $sum_rate / $counter;

								if ($all_avg == "") {
									$all_avg = 0;
								}

								if ($all_avg >= 8) {
									$color_pick = "#5cb85c";
								}

								if ($all_avg >= 6 && $all_avg < 8) {
									$color_pick = "#5cb85c";
								}

								if ($all_avg >= 4 && $all_avg < 6) {
									$color_pick = "#ff0";
								}

								if ($all_avg >= 2 && $all_avg < 4) {
									$color_pick = "#d9534f";
								}

								if ($all_avg > 0 && $all_avg < 2) {
									$color_pick = "#d9534f";
								}

								$counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'artist' AND like_id = '$album_artist_id'"));

						?>
								<div class="col-sm-4">
									<div class="img_cont">
										<a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo . ".html"; ?>"> <?php
																																	if ($picture != "") {
																																	?>
												<img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo $picture; ?>" border="0" class="img-responsive" style="max-height:200px; width:100%;" />
											<?php
																																	} else
													if ($album_picture != "") {
											?>
												<img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo $album_picture; ?>" border="0" class="img-responsive" style="max-height:200px;; width:100%;" />
											<?php
																																	} else {
											?>
												<img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image.png" border="0" class="img-responsive" style="max-height:200px; width:100%;" />
											<?php
																																	}
											?>
										</a>
										<?php
										if ($all_avg != 0) {
										?><span class="score" style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
																														echo number_format($all_avg, 1);
																													} else {
																														echo $all_avg;
																													} ?></span><?php } else { ?> <span class="score">5.0</span><?php } ?>
										<div class="title">
											<a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo . ".html"; ?>" class="text_wht"><?php echo $song_title ?></a><br><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist.html"; ?>"><?php echo $artist_name; ?></a>

											<span class="like">
												<?php
												if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] != "") {

													$counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$album_artist_id'"));

													if ($counter == 0) {
												?>
														<span id="other_dis_sub_popular_<?php echo $p_fav; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_popular(<?php echo $album_artist_id; ?>,<?php echo $p_fav; ?>)"><i class="fa fa-heart"></i> </a><span><?php echo $counter_main; ?></span>
															<a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_<?php echo $p_fav; ?>" data-title="" class="link-disable"><?php if ($counter_main < 2) {
																																																																							echo " Like";
																																																																						} else {
																																																																							echo " Likes";
																																																																						} ?></a>
														</span>

														<span id="myStyle_sub_popular_<?php echo $p_fav; ?>"></span>

													<?php
													} else {
													?>
														<span id="other_dis_sub_popular_<?php echo $p_fav; ?>">
															<a href="javascript:;" onClick="add_in_favourite_list_sub_artist_popular(<?php echo $album_artist_id; ?>,<?php echo $sr_no; ?>)" style="color:red"><i class="fa fa-heart"></i></a> <span><?php echo $counter_main; ?></span>
															<a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_<?php echo $p_fav; ?>" data-title=""><?php if ($counter_main < 2) {
																																																																		echo " Like";
																																																																	} else {
																																																																		echo " Likes";
																																																																	} ?></a></span>


														<span id="myStyle_sub_popular_<?php echo $p_fav; ?>"></span>
													<?php
													}
												} else {
													?>
													<a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_<?php echo $p_fav; ?>" data-title="" class="like link-disable" style="margin-left:4px;"> <span><?php echo $counter_main; ?></span> <?php if ($counter_main < 2) {
																																																																																							echo " Like";
																																																																																						} else {
																																																																																							echo " Likes";
																																																																																						} ?></a>

													<a href="javascript:;" onClick="add_in_favourite_list_sub_artist_popular(<?php echo $album_artist_id; ?>,<?php echo $p_fav; ?>)"><i class="fa fa-heart"></i> </a>




												<?php
												}
												?>
											</span>
										</div>
									</div>
								</div>
						<?php

							}
						}
						?>





					</div>
				</div>
				<div class="col-md-3">
					<?php echo song_adds($song_id, 'video'); ?>
					<?php echo ads_info('right'); ?>
					<!--<img src="images/addvertizement.jpg" class="img-responsive">-->
					<div class="clear"></div>
					<div id="discussion">
						<h4>Discussions</h4>


						<textarea class="form-control" name="detail" id="atextarea" rows="3" placehlder="Share your thoughts here..." style="resize: none;"></textarea>
						<input type="hidden" name="song_id" value="<?php echo $song_id; ?>">
						<input type="hidden" name="artist_id" value="<?php echo $artist_id; ?>">
						<input type="hidden" name="album_id" value="<?php echo $album_id; ?>">


						<input id="submit_btn" class="btn btn-danger text_18 Oswald pull-right" type="submit" onClick="return discussion_post();" value="Submit" name="submit_btn" style="padding:0">



						<div class="clear pad-5"></div>


						<table class="table table_no_border">
							<tbody>
								<div id="pagination" cellspacing="0"></div>

							</tbody>
						</table>


						<div class="clear pad-5"></div>

					</div>
				</div>
			</div>
			<div class="clear pad-10"></div>
		</div>
		<?php include_once("common/footer.php");
		include_once("common/popular_review.php"); ?>
	</div>
	<div class="modal fade" id="missing_store_detail_Modal3_<?php echo $artist_id; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

	<?php
	for ($u = 1; $u <= $k; $u++) {
	?>
		<div class="modal fade" id="cms_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
	<?php
	}

	for ($u = 1; $u <= $k; $u++) {
	?>
		<div class="modal fade" id="missing_store_detail_Modal2_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

		<div class="modal fade" id="model_review_likes_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
	<?php
	}

	for ($g = 1; $g <= $k; $g++) {
	?>
		<div class="modal fade" id="report_Modal4_<?php echo $g; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
	<?php
	}

	for ($g = 1; $g <= 20; $g++) {
	?>
		<div class="modal fade" id="edit_Modal4_<?php echo $g; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

	<?php
	}


	for ($u = 1; $u <= $prof_counter; $u++) {
	?>
		<div class="modal fade" id="missing_popular_profile_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
	<?php
	}

	for ($u = 1; $u <= 20; $u++) {
	?>
		<div class="modal fade" id="missing_popular_profile_discussion_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
	<?php
	}
	?>

	<div class="modal fade" id="missing_store_detail_Modal3_<?php echo $artist_id; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

	<!-- Bootstrap core JavaScript
================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo SERVER_ROOTPATH; ?>js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript">
		var jq = jQuery.noConflict();

		function discussion_post() {


			valu = jq('#atextarea').val();

			jq.post(
				JS_SERVER_PATHROOT + 'process/discussion_process.php?artist_id=<?php echo $artist_id; ?>&album_id=<?php echo $album_id; ?>&song_id=<?php echo $song_id; ?>&detail=' + valu,


				function(html) {


					if (html == "Please sign in first") {
						alert(html);
					} else
					if (html == "done") {
						$('#atextarea').val('');

						window.location.reload();

					} else {
						alert(html);
					}

				}
			);
		}

		song_id = <?php echo $song_id; ?>;
	</script>
	<script type="text/javascript" src="<?php echo SERVER_ROOTPATH; ?>script.js"></script>
	<script src="<?php echo SERVER_ROOTPATH; ?>js/bootstrap.js"></script>
</body>

</html>