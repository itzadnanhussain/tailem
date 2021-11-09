<style>
	.review_tablet_txt {
		display: none !important;
	}

	@media (min-width:820px) and (max-width: 1120px) {
		.review_tablet_txt {
			display: block !important;
		}

		.review_screen_txt {
			display: none !important;
		}

		.revtitle_wd {
			width: 85% !important;
		}
	}
</style>
<div class="popularreviews">
	<div>
		<h2 class="sec_heading marginbot30"><span>Popular Reviews</span></h2>
		<div class="row">
			<?php
			$reviews_list_arr = array();

			if (empty($reviews_list_arr)) {
				$reviews_list = "select b.album_seo,b.album_picture,a.artist_seo,a.artist_seo,a.artist_name,s.song_seo,s.picture,s.updated_by_itunes, s.song_title,r.* from tbl_reviews r,tbl_artists a,tbl_songs s,  tbl_artist_album b where r.song_id = s.id AND r.artist_id = a.id AND r.album_id = b.id AND r.is_popular = 1 AND s.song_status = 1 order by r.review_id limit 6";
				$reviews_list_arr	=	App\Models\Songs::GetRawData($reviews_list, array());
			}




			if (isset($reviews_list_arr)) {
				$g = 0;
				$r_fav = 0;
				$sr_no = 0;

				foreach ($reviews_list_arr as $val) {
					$val = (array) $val;

					$sr_no++;
					$g++;
					$r_fav++;
					$review_id	   = $val['review_id'];
					// echo $review_id;
					// die;
					$db_review_id   = $val['review_id'];
					$artist_seo	= strtolower(stripslashes(html_entity_decode($val['artist_seo'])));
					$song_seo	= strtolower(stripslashes(html_entity_decode($val['song_seo'])));
					$picture	= $val['picture'];
					if ($picture == '' &&  $val['updated_by_itunes'] == '0000-00-00 00:00:00') {
						$req_song  =  artist_album_song_func($artist_name, $song_title);
					}
					$album_picture   = stripslashes(html_entity_decode($val['album_picture']));
					$review_title  = stripslashes(html_entity_decode($val['review_title']));
					$review_title = StringReplace($review_title);
					$review_rating = $val['review_rating'];
					$review_detail = stripslashes(html_entity_decode($val['review_detail']));
					$review_detail = StringReplace($review_detail);
					// echo '<pre>';
					// print_r($review_detail);
					// echo '</pre>';
					// die;
					$review_user_id = $val['review_user_id'];
					$status     	= $val['status'];
					$is_popular     = $val['is_popular'];
					$album_id     = $val['album_id'];
					$db_song_id	= $val['song_id'];
					$artist_id     = $val['artist_id'];
					$is_featured    = $val['is_featured'];
					$review_post_date  = $val['review_post_date'];
					$review_title  = wordwrap($review_title, 100, " ", true);
					$artist_name = stripslashes($val['artist_name']);
					$song_title	=	stripslashes($val['song_title']);

					$select_qry = "select user_name from tbl_users where user_id='" . $review_user_id . "' ";
					//$select_ar  = $db->get_row($select_qry,ARRAY_A);
					$select_ar  = App\Models\Songs::GetRawData($select_qry, array());

					$select_ar  = (array) $select_ar[0];

					$user_name = stripslashes(html_entity_decode($select_ar['user_name']));
					$user_name = wordwrap($user_name, 100, " ", true);
					//313091
					$counter_mains = "select count(id) as likes_val from tbl_likes where like_type = 'artist' AND like_id = '$artist_id'";
					$counter_maines =  App\Models\Songs::GetRawData($counter_mains, array());
					$counter_maines  = (array) $counter_maines[0];

					$counter_main = $counter_maines['likes_val'];
					// $counter_main_review = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'review_song' AND like_id = '$review_id'"));
					$counter_main_review = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'review_song' AND like_id = '$review_id'");

					$position_find   = review_count_position($review_id, $db_song_id);

					$sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = $db_song_id AND status = 1";

					// $rate_arr	=	$db->get_row($sum_rating,ARRAY_A);
					$rate_arr	=	\App\Models\Songs::GetRawData($sum_rating);
					if ($rate_arr) {
						$rate_arr = (array) $rate_arr[0];
						$sum_rate = $rate_arr['sum_rate'];
						$counter = $rate_arr['counter'];
					} else {
						$sum_rate = 0;
						$counter = 0;
						$all_avg = 0;
					}


					if ($sum_rate == "" || $sum_rate == 0 || $counter == '' || $counter == 0) {
						$sum_rate = 0;
						$counter = 0;
						$all_avg = 0;
					} else {

						$all_avg  =  $sum_rate / $counter;
					}



					if ($all_avg == "") {
						$all_avg = 0;
					}

					if ($all_avg >= 7) {
						$color_pick = "#5ebd5e";
					}
					if ($all_avg >= 4 && $all_avg <= 6.9) {
						$color_pick = "#e06d21";
					}
					if ($all_avg >= 0 && $all_avg <= 3.9) {
						$color_pick = "#dd554e";
					}
					//End
					if ($review_rating >= 7) {
						$color_picker = "#5ebd5e";
					}
					if ($review_rating >= 4 && $review_rating <= 6.9) {
						$color_picker = "#e06d21";
					}
					if ($review_rating >= 0 && $review_rating <= 3.9) {
						$color_picker = "#dd554e";
					}


					$qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '" . $db_song_id . "'";
					// $qry_feature_arr = $db->get_results($qry_top_feature_artist,ARRAY_A);
					$qry_feature_arr = \App\Models\Songs::GetRawData($qry_top_feature_artist);
					$count  = count($qry_feature_arr);
					$num = 1;
					$feature_artists = "";
					if ($qry_feature_arr) {
						$sum_len = 0;
						$feature_artists .= "<a> ft.  </a>";
						foreach ($qry_feature_arr as $val_feature) {
							if ($num == $count) {
								$str_length = strlen($val_feature['feature_artist']);
								$sum_len = $sum_len + $str_length;
								if ($sum_len > 15) {
									$feature_art  = substr($val_feature['feature_artist'], 0, 1) . "...";
									$feature_artists .= " <a href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $feature_art . "</a>";
									break;
								} else {
									$feature_art  = $val_feature['feature_artist'];
									$feature_artists .= " <a href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $feature_art . "</a>";
								}
							} else {
								$str_length = strlen($val_feature['feature_artist']);
								$sum_len = $sum_len + $str_length;
								if ($sum_len > 15) {
									$feature_art  = substr($val_feature['feature_artist'], 0, 1) . "...";
									$feature_artists .= " <a href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $feature_art . "</a>";
									break;
								} else {
									$feature_art  = $val_feature['feature_artist'];
									$feature_artists .= " <a href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $feature_art . "</a>,";
								}
							}
							$num++;
						}
					}

					/***************** For Song picture ************/
					if ($picture != "") {

						$img_api_link = album_img_api($picture);

						if ($img_api_link != '') {
							$image_get = $img_api_link;
							//$image_get = $picture;
						} else {
							$image_get = SERVER_ROOTPATH . 'site_upload/song_images/' . $picture;
						}
					} elseif ($picture == "") {

						if ($req_song['song_array']['image5'] != "") {
							$image_get = $req_song['song_array']['image5'];
						} elseif ($album_picture != "") {

							$img_api_link = album_img_api($album_picture);

							if ($img_api_link != '') {
								$image_get = $img_api_link;
								//$image_get = $album_picture;
							} else {
								$image_get = SERVER_ROOTPATH . 'site_upload/album_images/' . $album_picture;
							}
						} else {
							$image_get = COOKIE_FREE_ROOTPATH . 'assets/images/no_image4.png';
						}
					}

					/**************** For Song Rating **************/
					if ($review_rating == 10) {
						$srating = number_format($review_rating, 0);
					} else {
						$srating = $review_rating;
					}

			?>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
						<div class="pop_sec">
							<div class="sec_cover topsongssecs">
								<a href="<?php echo SERVER_ROOTPATH  . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><img src="<?php echo $image_get; ?>"></a>
								<div class="bottom_sec" style="bottom:150px !important; background:none !important; padding:0 10px !important;">
									<div class="row">
										<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">

										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 txtalnright">
											<?php if ($all_avg != 0) { ?><span class="score" style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
																																						echo number_format($all_avg, 1);
																																					} else {
																																						echo $all_avg;
																																					} ?></span><?php } else { ?> <span class="score_big mt-10">5.0</span><?php } ?>
										</div>
									</div>
								</div>
								<div class="bottom_sec">
									<div class="row">
										<div class="col-lg-8 col-md-7 col-sm-7 col-xs-7 pad_right">
											<!--Desktop-->
											<label class="review_screen_txt"><a href="<?php echo SERVER_ROOTPATH  . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><?php echo substr($song_title, 0, 25);
																																								if (strlen($song_title) > 25) {
																																									echo "..";
																																								} ?></a></label>
											<!--Tablet-->
											<label class="review_tablet_txt"><a href="<?php echo SERVER_ROOTPATH  . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><?php echo substr($song_title, 0, 25);
																																								if (strlen($song_title) > 25) {
																																									echo "..";
																																								} ?></a></label>
											<!--Ipad-->
											<label class="review_ipad_txt"><a href="<?php echo SERVER_ROOTPATH  . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><?php echo substr($song_title, 0, 22);
																																								if (strlen($song_title) > 22) {
																																									echo "..";
																																								} ?></a></label>
											<!--Mobile-->
											<label class="review_mobile_txt" style="white-space:nowrap;"><a href="<?php echo SERVER_ROOTPATH  . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><?php echo substr($song_title, 0, 18);
																																															if (strlen($song_title) > 18) {
																																																echo "..";
																																															} ?></a></label>


											<cite style="white-space:nowrap"><a href="<?php echo SERVER_ROOTPATH  . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 25);
																																						if (strlen($artist_name) > 25) {
																																							echo "..";
																																						} ?></a><?php echo $feature_artists;
																																							$sum_len = 0; ?></cite>
										</div>
										<div class="col-lg-4 col-md-5 col-sm-5 col-xs-5 pad_left">
											<?php if ($user_id != "") {
												// $like_counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  like_type = 'artist' AND like_id = '$artist_id'"));
												$like_counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  like_type = 'artist' AND like_id = '$artist_id'");
												if($like_counter)
												{
													$like_counter = count($like_counter);
												}
												else
												{
													$like_counter = 0;
												}
												if ($like_counter > 0) {
													$class = "like-group liked";
												} else {
													$class = "like-group";
												}
												if ($like_counter == 0) {
											?>
													<span style="float:right;" class="<?php echo $class; ?>" id="other_dis_sub_popular_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>"><a href="javascript:;" onClick="reviews_artist_popular_likes('<?php echo $artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>')"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>
														<a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="link-disable" style="color:#fff;"> <?php echo $counter_main; ?><?php if ($counter_main < 2) {
																																																																									echo " Like";
																																																																								} else {
																																																																									echo " Likes";
																																																																								} ?></a>
													</span>
													<span style="float:right;" class="like-group liked" id="myStyle_sub_popular_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>"></span>
												<?php } else {
												?>
													<span style="float:right;" class="<?php echo $class; ?>" id="other_dis_sub_popular_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>">
														<a href="javascript:;" onClick="reviews_artist_popular_likes('<?php echo $artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>')"><i class="fa fa-heart" style="font-size:24px; color:#D73B3B;"></i></a>
														<a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="link-disable" style="color:#fff;"> <?php echo $counter_main; ?><?php if ($counter_main < 2) {
																																																																									echo " Like";
																																																																								} else {
																																																																									echo " Likes";
																																																																								} ?></a></span>
													<span style="float:right;" class="like-group liked" id="myStyle_sub_popular_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>"></span>
												<?php
												}
											} else {
												?>
												<span style="float:right;" class="like-group">
													<?php
													if ($user_id == "") {
													?>
														<a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>

													<?php
													} else {
													?>
														<a href="javascript:;" onClick="reviews_artist_popular_likes('<?php echo $artist_id; ?>','5000','<?php echo $artist_seo; ?>')"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>
													<?php
													}
													?>

													<a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="margin-left:4px;color:#fff;"> <?php echo $counter_main; ?><?php if ($counter_main < 2) {
																																																																													echo " Like";
																																																																												} else {
																																																																													echo " Likes";
																																																																												} ?></a></span>
											<?php
											}
											?>

										</div>
									</div>
								</div>
								<div class="gradientoverlay"></div>
							</div>
							<div class="album_details">
								<!--Screen View-->
								<label class="review_screen_txt"><span class="review_title white_space" style="cursor:pointer; font-size:sans-serif !important;" onclick="window.location.href='<?php echo SERVER_ROOTPATH . $song_seo . "/reviewslist/" . $artist_seo . "/" . $position_find . "#review_" . $review_id; ?>'"><?php echo substr($review_title, 0, 28);

																																																																																if (strlen($review_title) > 31) {
																																																																																	echo "...";
																																																																																}


																																																																																?></span> <cite style="background-color:<?php echo $color_picker; ?>"><?php echo $srating; ?></cite></label>
								<!--Tablet View-->
								<label class="review_tablet_txt"><span class="review_title white_space revtitle_wd" style="cursor:pointer;" onclick="window.location.href='<?php echo SERVER_ROOTPATH . $song_seo . "/reviewslist/" . $artist_seo . "/" . $position_find . "#review_" . $review_id; ?>'"><?php echo substr($review_title, 0, 24);

																																																																											if (strlen($review_title) > 24) {
																																																																												echo "...";
																																																																											}


																																																																											?></span> <cite style="background-color:<?php echo $color_picker; ?>"><?php echo $srating; ?></cite></label>
								<!--Ipad View-->
								<label class="review_ipad_txt"><span class="review_title white_space revtitle_wd" style="cursor:pointer;" onclick="window.location.href='<?php echo SERVER_ROOTPATH . $song_seo . "/reviewslist/" . $artist_seo . "/" . $position_find . "#review_" . $review_id; ?>'"><?php echo substr($review_title, 0, 29);

																																																																										if (strlen($review_title) > 29) {
																																																																											echo "...";
																																																																										}


																																																																										?></span> <cite style="background-color:<?php echo $color_picker; ?>"><?php echo $srating; ?></cite></label>
								<!--Mobile View-->
								<label class="review_mobile_txt"><span class="review_title white_space revtitle_wd" style="cursor:pointer;" onclick="window.location.href='<?php echo SERVER_ROOTPATH . $song_seo . "/reviewslist/" . $artist_seo . "/" . $position_find . "#review_" . $review_id; ?>'"><?php echo substr($review_title, 0, 20);

																																																																											if (strlen($review_title) > 20) {
																																																																												echo "...";
																																																																											}


																																																																											?></span> <cite style="background-color:<?php echo $color_picker; ?>"><?php echo $srating; ?></cite></label>


								<p><span class="review_detail" style="white-space:normal; cursor:pointer; width:100%;" onclick="window.location.href='<?php echo SERVER_ROOTPATH . $song_seo . "/reviewslist/" . $artist_seo . "/" . $position_find . "#review_" . $review_id; ?>'">
										<?php
										$rev_desc_length  = strlen(wordwrap($review_detail, 20, " ", true));
										echo substr(wordwrap($review_detail, 22, " ", true), 0, 130);
										if ($rev_desc_length > 130) {
											echo " ....";
										}
										?></span></p>
								<div class="row" style=" margin-right:0px;">
									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" style="text-overflow: ellipsis; white-space: nowrap; overflow:hidden;">
										<span class="usrname"><i class="sprite-new sprite-new-icon_user"></i><a href="<?php echo SERVER_ROOTPATH . get_user_detail($user_name) . "/profile-review-artist"; ?>"><?php
																																																				echo substr($user_name, 0, 15);
																																																				if (strlen($user_name) > 15) {
																																																					echo "..";
																																																				}
																																																				?></a></span>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-2 col-xs-2" style="padding-left:0px !important; text-overflow: ellipsis; white-space: nowrap; text-align:center;">
										<span class="usrdetails review_screen_txt" style="color:#000000;">
											<!--<i class="sprite-new sprite-new-icon_time"></i>--><?php echo date("d M Y", $review_post_date); ?>
										</span>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pad_left" style="text-align:right;">
										<?php
										// $counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'review_song' AND like_id = '$db_review_id'"));
										$counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'review_song' AND like_id = '$db_review_id'");
										if ($counter_main) {
											$counter_main = count($counter_main);
										} else {
											$counter_main = 0;
										}
										// $counter_main =  5;
										if ($user_id != "") {
											// $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'review_song' AND like_id = '$db_review_id'"));
											$counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'review_song' AND like_id = '$db_review_id'");
											if($counter)
											{
												$counter = count($counter);
											}else
											{
												$counter = 0;
											}
											if ($counter > 0) {
												$class = "like-group liked";
											} else {
												$class = "like-group";
											}
											if ($counter == 0) {
												if ($review_user_id == $user_id) {
										?>
													<span class="<?php echo $class; ?>" id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" title="your own review" onClick="alert('You cannot like your own review.')"><i class="fa fa-heart-o" style="font-size:24px;color:#c63937;"></i> </a>
													<?php
												} else {
													?>
														<span class="<?php echo $class; ?>" id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_review_song('<?php echo $db_review_id; ?>','<?php echo $user_name; ?>','<?php echo $r_fav; ?>')"><i class="fa fa-heart-o" style="font-size:24px;color:#c63937;"></i></a>
														<?php
													}
														?>
														<a href="<?php echo SERVER_ROOTPATH; ?>process/detail_review?user=<?php echo urlencode($user_name); ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable" style="color:#444;"> <?php echo $counter_main; ?><?php if ($counter_main < 2) {
																																																																																							echo " Like";
																																																																																						} else {
																																																																																							echo " Likes";
																																																																																						} ?></a></span>
														<span class="like-group liked" id="myStyle_sub_<?php echo $db_review_id; ?>"></span>
													<?php
												} else {
													?>
														<span class="like-group liked" id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_review_song('<?php echo $db_review_id; ?>','<?php echo $user_name; ?>','<?php echo $r_fav; ?>')" class="like"><i class="fa fa-heart" style="font-size:24px; color:#c63937;"></i></a>
															<a href="<?php echo SERVER_ROOTPATH; ?>process/detail_review?user=<?php echo urlencode($user_name); ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable" style="color:#444;"> <?php echo $counter_main; ?><?php if ($counter_main < 2) {
																																																																																								echo " Like";
																																																																																							} else {
																																																																																								echo " Likes";
																																																																																							} ?></a></span>
														<span class="like-group liked" id="myStyle_sub_<?php echo $db_review_id; ?>"></span>
													<?php
												}
											} else {
													?>
													<span class="like-group" id="other_dis_sub_<?php echo $review_user_id; ?>">
														<?php
														if ($user_id == "") {
														?>
															<a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>

														<?php
														} else {
														?>
															<a href="javascript:;" onClick="add_in_favourite_list_review_song('<?php echo $db_review_id; ?>','<?php echo $user_name; ?>','<?php echo $r_fav; ?>')" class="text_grey"><i class="fa fa-heart-o" style="font-size:24px;color:#c63937;"></i></a>
														<?php
														}
														?>

														<a href="<?php echo SERVER_ROOTPATH; ?>process/detail_review?user=<?php echo urlencode($user_name); ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable" style="color:#444;"> <?php echo $counter_main; ?><?php if ($counter_main < 2) {
																																																																																							echo " Like";
																																																																																						} else {
																																																																																							echo " Likes";
																																																																																						} ?></a></span>
													<span id="myStyle_sub_<?php echo $db_review_id; ?>"></span>
												<?php
											}
												?>
									</div>
								</div>
							</div>
						</div>

						
					</div>
			<?php
				}
			}
			?>
		</div>
	</div>
</div>