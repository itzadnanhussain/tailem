@include('common.header')
<!-- ./Header end -->

<?php
ini_set('max_execution_time', '300');
$mobile_view = 0;

$_SESSION[search]['artist_names'] = 'test-artist';
$_SESSION[search]['result'] = ' ';

if (isset($alpha) && ($alpha == "unset")) {
	// unset($_SESSION[search]['artist_names']);
	// unset($_SESSION[search]['result']);
}



if (isset($_REQUEST['submit_b']) && $_REQUEST['submit_b'] != "") {
	if ($artist_name != "") {
		$artist_name = mysqli_escape_string($db->dbh, $artist_name);
		$search_where .= " AND (artist_name like '%$artist_name%')";

		$_SESSION[search]['artist_names'] = $artist_name;
		$_SESSION[search]['result'] = $search_where;
	} else {
		unset($_SESSION[search]['artist_names']);
		unset($_SESSION[search]['result']);
	}
}

?>


<!-- Middle Section -->
<section class="middle_sec" style="overflow-x : hidden;">
	<div class="banner">
		<div class="banner_body">
			<h1 class="bnr_heading">Artist browse</h1>
			<!-- <p class="bnr_subject">Share & Promote your music online</p>
            <button class="banner_btn">Learn More</button> -->
			<div class="banner-search">
				<form action="<?php echo SERVER_ROOTPATH; ?>top-artists" method="post">
					<div class="form-group">
						<label for="search" onClick="unset_all()" style="cursor:pointer;">All</label>
						<input type="text" class="form-control" name="artist_name" id="skills" placeholder="Search for an Artist" <?php if ($_SESSION[search]['artist_names'] != '') { ?>value="<?php echo $_SESSION[search]['artist_names']; ?>" <?php } ?> required>
						<!--<button type="submit" type="submit" name="submit_ba" id="submit_ba" class="btn">Submit</button>-->
						<button class="btn" type="submit" value="Search" name="submit_b"><i class="sprite-new sprite-new-xsearch-icon-png-pagespeed-ic-XjnYgjYQAr"></i></button>
					</div>
				</form>
			</div><!-- banner-search -->
			<?php

			if (isset($genere_seo)) { 
				$genere_seo = strtolower($genere_seo);
			}else
			{
				$genere_seo = '';
			}



			if (isset($genere_seo) && ($genere_seo != "")) {
				$urls = "-" . $genere_seo . "-genre";
			} else {
				$urls = "";
			}
			?>
			<div class="col-sm-12 alpha-panel text-center">
				<ul class="list-inline">
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-number" <?php if ($alpha == "number") { ?>class="active" <?php } ?>>#</a></li> -
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-a" <?php if ($alpha == "a") { ?>class="active" <?php } ?>>A</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-b" <?php if ($alpha == "b") { ?>class="active" <?php } ?>>B</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-c" <?php if ($alpha == "c") { ?>class="active" <?php } ?>>C</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-d" <?php if ($alpha == "d") { ?>class="active" <?php } ?>>D</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-e" <?php if ($alpha == "e") { ?>class="active" <?php } ?>>E</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-f" <?php if ($alpha == "f") { ?>class="active" <?php } ?>>F</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-g" <?php if ($alpha == "g") { ?>class="active" <?php } ?>>G</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-h" <?php if ($alpha == "h") { ?>class="active" <?php } ?>>H</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-i" <?php if ($alpha == "i") { ?>class="active" <?php } ?>>I</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-j" <?php if ($alpha == "j") { ?>class="active" <?php } ?>>J</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-k" <?php if ($alpha == "k") { ?>class="active" <?php } ?>>K</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-l" <?php if ($alpha == "l") { ?>class="active" <?php } ?>>L</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-m" <?php if ($alpha == "m") { ?>class="active" <?php } ?>>M</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-n" <?php if ($alpha == "n") { ?>class="active" <?php } ?>>N</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-o" <?php if ($alpha == "o") { ?>class="active" <?php } ?>>O</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-p" <?php if ($alpha == "p") { ?>class="active" <?php } ?>>P</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-q" <?php if ($alpha == "q") { ?>class="active" <?php } ?>>Q</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-r" <?php if ($alpha == "r") { ?>class="active" <?php } ?>>R</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-s" <?php if ($alpha == "s") { ?>class="active" <?php } ?>>S</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-t" <?php if ($alpha == "t") { ?>class="active" <?php } ?>>T</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-u" <?php if ($alpha == "u") { ?>class="active" <?php } ?>>U</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-v" <?php if ($alpha == "v") { ?>class="active" <?php } ?>>V</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-w" <?php if ($alpha == "w") { ?>class="active" <?php } ?>>W</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-x" <?php if ($alpha == "x") { ?>class="active" <?php } ?>>X</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-y" <?php if ($alpha == "y") { ?>class="active" <?php } ?>>Y</a> </li>-
					<li><a href="<?php echo SERVER_ROOTPATH; ?>artist<?php echo $urls; ?>-z" <?php if ($alpha == "z") { ?>class="active" <?php } ?>>Z</a> </li>
				</ul>
			</div>
		</div>
	</div>
	<?php
	$cat_list_arr = array(); 
	 
		$cat_list = "SELECT * FROM `tbl_categories`";
		//$cat_list="select c.cat_id, c.cat_name, c.cat_seo_name from tbl_categories c, tbl_artists a where c.status = 1 AND a.genere_cat = c.cat_id group by c.cat_name";
		// $cat_list_arr	=	$db->get_results($cat_list, ARRAY_A);
		$cat_list_arr = \App\Models\Songs::GetRawData($cat_list);
		if($cat_list_arr)
		{
			$count  = count($cat_list_arr);

		}
		else
		{
			$count = 0;
		}
	 
	 

	?>
	<div class="topsonglistsec">
		<div class="container" style="padding:0;">
			<?php if (isset($cat_list_arr)) {
				// echo '<pre>';
				// print_r($cat_list_arr);
				// echo '</pre>';
				// die;
				$v = 1; ?>
				<div class="row">
					<div class="col-sm-12 ">
						<div class="brows-label-penel" style="background-color:#FFFFFF; margin:10px 0;">
							<p class="pull-left" style="line-height:27px;">BROWSE BY GENRE: &nbsp;</p>
							<ul class="list-inline">
								<li>
									<?php
									foreach ($cat_list_arr as $val) {
										$val = (array)$val;
										$cat_id	  = $val['cat_id'];
										$cat_name = stripslashes(html_entity_decode($val['cat_name']));
										$cat_seo_name = strtolower(stripslashes(html_entity_decode($val['cat_seo_name'])));
									?>
										<a href="<?php echo SERVER_ROOTPATH; ?>artists-genre-<?php echo $cat_seo_name; ?>" class="active"><?php echo $cat_name; ?> </a> <?php if ($v != sizeof($cat_list_arr)) {
																																											echo '|';
																																										} ?>
									<?php $v++;
									}
									?>

								</li>
							</ul>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="row">
				<!-- Advertisement Banner Start-->
				<div class="container" style="padding:10px 0 20px 0;">
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-0 col-xs-0 review_screen_txt">&nbsp;</div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="text-align:center;">
							<?php echo ads_info('Top'); ?>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-0 col-xs-0 review_screen_txt">&nbsp;</div>
					</div>
				</div>
				<!--Advertisement Banner End-->
				<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
					<div>
						<div class="latestsongssec">
							<div class="listslider">
								<div id="owl-carousel1" class="owl-carousel">
									<?php
									$artist_list = "select * from tbl_artists where artist_status = 1 AND popular_artist = 1 order by rand() limit 3";
									$artist_list_arr = \App\Models\Songs::GetRawData($artist_list);
 									echo '<pre>';
									 print_r($artist_list_arr);
									 echo '</pre>';
									 die;
									if (isset($artist_list_arr)) {
										$m = 1;
										foreach ($artist_list_arr as $val) {
											$val = (array) $val;
											$id	  		 		  = $val['id'];
											$artist_name 		  = stripslashes(html_entity_decode($val['artist_name']));
											$artist_seo			  = strtolower(stripslashes(html_entity_decode($val['artist_seo'])));
											$artist_img  		  = stripslashes(html_entity_decode($val['artist_img']));
											$artist_description   = stripslashes(html_entity_decode($val['artist_description']));
											$status   			  = $val['artist_status'];
											$posted_date   		  = $val['posted_date'];
											$artist_name = wordwrap($artist_name, 100, " ", true);
											if ($artist_img == '' &&  $val['updated_by_itunes'] == '0000-00-00 00:00:00') {
												$req_artist  =  artist_func(urlencode("$artist_name"));
											}

											// $counter_main =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'artist' AND like_id = '$id'"));

											$counter_main = array();
											$counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'artist' AND like_id = '$id'");
											if ($counter_main) {
												$counter_main = count($counter_main);
											} else {
												$counter_main = 0;
											}

											$sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where artist_id = $id AND status = 1";
											$rate_arr = array();
											$rate_arr    =    \App\Models\Songs::GetRawData($sum_rating);
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

											if ($all_avg >= 8) {
												$color_pick = "#5cb85c";
											}

											if ($all_avg >= 6 && $all_avg < 8) {
												$color_pick = "#5cb85c";
											}

											if ($all_avg >= 4 && $all_avg < 6) {
												$color_pick = "#e06d21";
											}

											if ($all_avg >= 2 && $all_avg < 4) {
												$color_pick = "#d9534f";
											}

											if ($all_avg > 0 && $all_avg < 2) {
												$color_pick = "#d9534f";
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

									?>
											<div>
												<div class="list_item">
													<div class="album_cover">
														<!--	<img src="images/slideimg2.png">-->
														<?php
														if ($artist_img != "") {
															$img_api_linka = album_img_api($artist_img);
															if ($img_api_linka != '') { ?>
																<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><img src="<?php echo get_small_thumb($img_api_linka); ?>" border="0" style="height:300px" title="<?php echo $artist_name; ?>" /></a>
															<?php } else { ?>
																<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $artist_img; ?>" border="0" style="height:300px" title="<?php echo $artist_name; ?>" /></a>
															<?php
															}
														} else
											if ($artist_img == "") {

															if ($req_artist['artist_array']['image4'] != "") {
															?>
																<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><img src="<?php echo get_small_thumb($req_artist['artist_array']['image4']); ?>" style="height:300px" border="0" /></a>
															<?php
															} else {
															?>
																<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" style="height:300px" title="<?php echo $artist_name; ?>" /></a>
															<?php
															}
														}

														if ($all_avg != 0) {
															?><cite class="score" style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
																																			echo number_format($all_avg, 1);
																																		} else {
																																			echo $all_avg;
																																		} ?></cite><?php } else { ?> <cite style="background-color:#dd554e;">0.0</cite><?php } ?>
													</div>
													<div class="list_bottom" style="padding-bottom:0;">
														<div class="row">
															<div class="col-lg-8 col-md-8 col-sm-7 col-xs-7">
																<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>">
																	<cite2 style="margin:2px;"><?php echo $artist_name; ?></cite2>
																</a>
															</div>
															<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5" style="bottom:4px;">
																<!--<span class="like-group" style="float:right;"><a href="#"><i class="fa fa-heart-o heart_color heart_size"></i> </a><a href="#" class="like link-disable" style="margin-left:4px;color:#fff;">1 Likes</a></span>-->
																<?php
																if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] != "") {
																	// $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$id'"));
																	$counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$id'");
																	if ($counter) {
																		$counter = count($counter);
																	} else {
																		$counter = 0;
																	}
																	if ($counter == 0) { ?>
																		<span id="other_dis_<?php echo $id; ?>" class="like-group" style="float:right;"><a href="javascript:;" onClick="add_in_favourite_list('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $m; ?>')" class="like"><i class="fa fa-heart-o heart_color heart_size"></i></a><span style="color:#FFFFFF;"> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="margin-left:4px; color:#FFFFFF;"><?php if ($counter_main < 2) {
																																																																																																																																																																echo "Like";
																																																																																																																																																															} else {
																																																																																																																																																																echo "Likes";
																																																																																																																																																															} ?></a></span>
																		<span class="like-group" style="float:right;" id="myStyle_<?php echo $id; ?>"></span> <?php } else { ?>
																		<span id="other_dis_<?php echo $id; ?>" class="like-group" style="float:right;"><a href="javascript:;" onClick="add_in_favourite_list('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $m; ?>')" class="like"><i class="fa fa-heart" style="font-size:24px; color:#D73B3B;"></i></a><span style="color:#FFFFFF;"> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="margin-left:4px; color:#FFFFFF;"><?php if ($counter_main < 2) {
																																																																																																																																																																				echo "Like";
																																																																																																																																																																			} else {
																																																																																																																																																																				echo "Likes";
																																																																																																																																																																			} ?></a></span>
																		<span class="like-group" style="float:right;" id="myStyle_<?php echo $id; ?>"></span>
																	<?php
																																							}
																																						} else { ?>
																	<span id="other_dis_<?php echo $id; ?>" class="like-group" style="float:right;">
																		<?php
																																							if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
																		?>
																			<a href="#" data-toggle="modal" data-target="#signin_form" class="like"><i class="fa fa-heart-o heart_color heart_size"></i> </a>
																		<?php
																																							} else {
																		?>
																			<a href="javascript:;" onClick="add_in_favourite_list('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $m; ?>')" class="like"><i class="fa fa-heart-o heart_color heart_size"></i> </a>
																		<?php
																																							}
																		?>
																		<span style="color:#FFFFFF;"> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="margin-left:4px; color:#FFFFFF;"><?php if ($counter_main < 2) {
																																																																																												echo "Like";
																																																																																											} else {
																																																																																												echo "Likes";
																																																																																											} ?></a></span>
																	<span class="like-group" style="float:right;" id="myStyle_<?php echo $id; ?>"></span> <?php
																																						}
																																							?>
															</div>
														</div>
													</div>
												</div>
											</div>
									<?php
											$m++;
										}
									} else {
										echo "No Record Found";
									}
									?>
								</div>
							</div>
						</div>
					</div>

					<ul class="songlistings" style="margin-top: 28px;">
						<?php
						$artist_page = "artists";
						$where_condition = "";

						if (isset($genere_seo) && ($genere_seo != "")) {
							$get_cat_array = "select cat_id from tbl_categories where cat_seo_name = '$genere_seo' AND status = 1";
							// $get_cat_array	=	$db->get_row($get_cat_array, ARRAY_A);
							$get_cat_array = \App\Models\Songs::GetRawData($get_cat_array);
							$cat_genere_id  = $get_cat_array['cat_id']; 
							$where_condition .= " AND cat_seo_name = '$genere_seo'";
							$artist_page = "artists-genres-" . $genere_seo;
						}

						if ($_SESSION[search]['result'] != "") {
							$where_condition .= $_SESSION[search]['result'];
						}

						if ($alpha != "" && $alpha != "unset") {
							if ($alpha == 'number') {
								$where_condition .= " AND artist_name REGEXP '^[0-9]'";
							} else {
								$where_condition .= " AND artist_name like '$alpha%' ";
							}


							$artist_page = "artist-" . $alpha;
						}

						if ($genere_seo != "" && $alpha != '') {

							$artist_page = "artists-" . $genere_seo . "-genre-" . $alpha;
						}

						//============================================================
						//PAGGING CODE STARTS HERE

						$artist_list_arr = array();
						 

						if (empty($artist_list_arr)) {
							if ($where_condition == '') {

								// $artist_list = "select * from topArtist where 1=1  $where_condition limit 50";



								$artist_list = "select a.artist_seo,a.artist_name, a.artist_img,a.updated_by_itunes, a.id, c.cat_name, c.cat_seo_name from tbl_artists a, tbl_categories c where 1=1 AND a.artist_status = 1 AND a.genere_cat = c.cat_id AND a.popular_artist =1  $where_condition limit 50";
							} else {
								//echo "2loop";
								if ($_SESSION[search]['result'] != '') {
									$orderby = "CASE 
												   WHEN artist_name LIKE '" . $_SESSION[search]['artist_names'] . "' THEN 1 
												   WHEN artist_name LIKE '" . $_SESSION[search]['artist_names'] . "%' THEN 2 
												   ELSE 3 
												   END, CHAR_LENGTH(artist_name)";
								} else {
									$orderby = " artist_name asc";
								}

								// $artist_list = "select * from topArtistSearch where 1=1 AND $where_condition order by $orderby";

								$artist_list = "select a.artist_seo,a.artist_name, a.artist_img, a.id, c.cat_name, c.cat_seo_name from tbl_artists a, tbl_categories c where 1=1 AND a.artist_status = 1 AND a.genere_cat = c.cat_id  $where_condition order by $orderby";
							}

							//echo $artist_list ;
							// $artist_list_arr	=	$db->get_results($artist_list, ARRAY_A);
							// echo '<pre>';
							// print_r($artist_list);
							// echo '</pre>';
							// die;
							$artist_list_arr = \App\Models\Songs::GetRawData($artist_list);
							if ($artist_list_arr) {
                                $total_pages = count($artist_list_arr);
                            } else {
                                $total_pages =  0;
                            }
							 
						} 
 
						$limit = 10; 					//how many items to show per page
 						if ($page)
							$start = ($page - 1) * $limit; //first item to display on this page
						else
							$start = 0;					//if no page var is given, set start to 0
						//PAGGING CODE ENDS HERE	
						//============================================================

						if (isset($page) && $page != "") {
							$sr_no = ($page * $limit) - $limit;
						} else {
							$sr_no = 0;
						}

						$c = 1;



						$artist_list_arr = array_slice($artist_list_arr, $start, 10);
						if (isset($artist_list_arr)) {
							$k = 1;
							foreach ($artist_list_arr as $val) {
								$val = (array)$val;
								$id	  = $val['id'];
								$artist_name = stripslashes(html_entity_decode($val['artist_name']));
								$artist_seo = strtolower(stripslashes(html_entity_decode($val['artist_seo'])));
								$artist_img   = stripslashes(html_entity_decode($val['artist_img']));
								$cat_name   = stripslashes(html_entity_decode($val['cat_name']));
								$cat_seo_name   = stripslashes(html_entity_decode($val['cat_seo_name']));

								if ($artist_img == '' &&  $val['updated_by_itunes'] == '0000-00-00 00:00:00') {
									$req_artist  =  artist_func(urlencode("$artist_name"));
								}


								$artist_name = wordwrap($artist_name, 100, " ", true);

								// $counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'artist' AND like_id = '$id'"));
								$counter_main = array();
                                $counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'artist' AND like_id = '$id'");
                                if ($counter_main) {
                                    $counter_main = count($counter_main);
                                } else {
                                    $counter_main = 0;
                                }
								if ($c % 2 == 0) {
									$bgcolor = "#FEFEE4";
								} else {
									$bgcolor = "#FFFFFF";
								}
								$sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where artist_id = $id AND status = 1";
								$rate_arr = array();
                                $rate_arr    =    \App\Models\Songs::GetRawData($sum_rating);
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

								if ($all_avg >= 8) {
									$color_pick = "#5cb85c";
								}

								if ($all_avg >= 6 && $all_avg < 8) {
									$color_pick = "#5cb85c";
								}

								if ($all_avg >= 4 && $all_avg < 6) {
									$color_pick = "#e06d21";
								}

								if ($all_avg >= 2 && $all_avg < 4) {
									$color_pick = "#d9534f";
								}

								if ($all_avg > 0 && $all_avg < 2) {
									$color_pick = "#d9534f";
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

								$c++;
								$sr_no++;


						?>
								<li>
									<?php if ($mobile_view == 0) { ?>
										<div class="row">
											<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
												<span class="list_no"><?php if (strlen($sr_no) == 1) {
																			echo "0";
																		} else {
																		}; ?><?php echo $sr_no; ?></span>
											</div>
											<div class="col-lg-8 col-md-8 col-sm-11 col-xs-12">
												<div class="album_cover">
													<?php
													if ($artist_img != "") {

														$img_api_linkaa = album_img_api($artist_img);
														if ($img_api_linkaa != '') { ?>
															<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><img src="<?php echo get_small_thumb($img_api_linkaa); ?>" border="0" width="120" /></a>
														<?php } else { ?>
															<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $artist_img; ?>" border="0" width="120" /></a>
														<?php
														}
													} else
													if ($artist_img == "") {

														if ($req_artist['artist_array']['image4'] != "") {
														?>
															<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><img src="<?php echo get_small_thumb($req_artist['artist_array']['image4']); ?>" border="0" width="120" /></a>
														<?php
														} else {
														?>
															<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="120" /></a>
													<?php
														}
													}
													?>
													<!-- <img src="images/slideimg1.png">-->
													<!--			<cite class="yellow">5.0</cite>-->
													<?php
													if ($all_avg != 0) {
													?><cite class="score_big mt-10" style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
																																			echo number_format($all_avg, 1);
																																		} else {
																																			echo $all_avg;
																																		} ?></cite><?php } else { ?> <cite style="background-color:#dd554e;">0.0</cite> <?php } ?>
												</div>
												<div class="album_details" style="margin-top:0;">
													<label class="title"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><?php echo substr($artist_name, 0, 24);
																																					if (strlen($artist_name) > 24) {
																																						echo "...";
																																					} ?></a></label>
													<label class="likes">
														<!--<i class="fa fa-heart-o heart_color heart_size"></i> <a href="#"><span> 0 </span> Likes</a>-->
														<?php
														if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] != "") {
															// $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$id'"));
															$counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$id'");
                                                            if ($counter) {
                                                                $counter = count($counter);
                                                            } else {
                                                                $counter = 0;
                                                            }
															if ($counter == 0) {
														?>
																<span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
																																																																																																																																															echo " Like";
																																																																																																																																														} else {
																																																																																																																																															echo " Likes";
																																																																																																																																														} ?></a></span>
																<span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>

															<?php
															} else {
															?>
																<span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="like"><i class="fa fa-heart heart_color heart_size"></i></a> <span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
																																																																																																																																																		echo " Like";
																																																																																																																																																	} else {
																																																																																																																																																		echo " Likes";
																																																																																																																																																	} ?></a></span>
																<span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>
															<?php
															}
														} else {
															?>
															<span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>">
																<?php
																if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
																?>
																	<a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i> </a>
																<?php
																} else {
																?>
																	<a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
																<?php
																}
																?>
																<span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
																																																																															echo " Like";
																																																																														} else {
																																																																															echo " Likes";
																																																																														} ?></a></span>
															<span style="overflow:visible;" id="myStyle_sub_<?php echo $id; ?>"></span>
														<?php } ?>
													</label>
													<div style="clear:both;"></div>
													<p class="mobile-only" style="margin-top:-16px !important;">
														<label class="reviews"><a style="color:#D73B3B;" href="<?php echo SERVER_ROOTPATH; ?>artists-genre-<?php echo $cat_seo_name; ?>"><?php echo substr($cat_name, 0, 20);

																																															if (strlen($cat_name) > 20) {
																																																echo "..";
																																															}


																																															?></a></label>
													</p>
												</div>
												<!--<button>Write a review</button>-->
											</div>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 artist_type red-text screen-only" style="text-align:right;">
												<a href="<?php echo SERVER_ROOTPATH; ?>artists-genre-<?php echo $cat_seo_name; ?>" class="red-text"><?php echo "" . substr($cat_name, 0, 25);

																																					if (strlen($cat_name) > 25) {
																																						echo "..";
																																					}


																																					?> </a>
											</div>
										</div>
									<?php } elseif ($mobile_view == 1) { ?>
										<div class="row">
											<!--<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                    <span class="list_no"><?php if (strlen($sr_no) == 1) {
																echo "0";
															} else {
															}; ?><?php echo $sr_no; ?></span>
 									</div>-->
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding:0px !important;">
													<div class="album_cover">
														<?php
														if ($artist_img != "") {
															$img_api_linkaa = album_img_api($artist_img);
															if ($img_api_linkaa != '') { ?>
																<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><img src="<?php echo get_small_thumb($img_api_linkaa); ?>" border="0" width="120" /></a>
															<?php } else { ?>
																<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $artist_img; ?>" border="0" width="120" /></a>
															<?php
															}
														} else
													if ($artist_img == "") {

															if ($req_artist['artist_array']['image4'] != "") {
															?>
																<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><img src="<?php echo get_small_thumb($req_artist['artist_array']['image4']); ?>" border="0" width="120" /></a>
															<?php
															} else {
															?>
																<a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="120" /></a>
														<?php
															}
														}
														?>
														<?php
														if ($all_avg != 0) {
														?><cite class="score_big mt-10" style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
																																				echo number_format($all_avg, 1);
																																			} else {
																																				echo $all_avg;
																																			} ?></cite><?php } else { ?> <cite style="background-color:#dd554e;">0.0</cite> <?php } ?>

														<div style="position:absolute; z-index:10; margin-left:88%; color:#FFFFFF; margin-top:-20px;" class="review_screen_txt"><?php echo $sr_no; ?></div>

													</div>
												</div>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding:0px !important;">
													<div class="album_details">
														<label class="title"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><?php echo substr($artist_name, 0, 24);
																																						if (strlen($artist_name) > 24) {
																																							echo "...";
																																						} ?></a></label>
														<label class="likes" style="float:left; height:26px; margin-left:0px; padding-left:0px;">
															<!--<i class="fa fa-heart-o heart_color heart_size"></i> <a href="#"><span> 0 </span> Likes</a>-->
															<?php
															if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] != "") {
																// $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$id'"));
																$counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$id'");
																if ($counter) {
																	$counter = count($counter);
																} else {
																	$counter = 0;
																}
																if ($counter == 0) {
															?>
																	<span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
																																																																																																																																																echo " Like";
																																																																																																																																															} else {
																																																																																																																																																echo " Likes";
																																																																																																																																															} ?></a></span>
																	<span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>
																<?php
																} else {
																?>
																	<span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="like"><i class="fa fa-heart heart_color heart_size"></i></a> <span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
																																																																																																																																																			echo " Like";
																																																																																																																																																		} else {
																																																																																																																																																			echo " Likes";
																																																																																																																																																		} ?></a></span>
																	<span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>
																<?php
																}
															} else {
																?>
																<span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a><span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
																																																																																																																																															echo " Like";
																																																																																																																																														} else {
																																																																																																																																															echo " Likes";
																																																																																																																																														} ?></a></span>
																<span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>
															<?php	} ?>
														</label>
														<div style="clear:both;"></div>
														<p>
															<label class="reviews"><a style="color:#D73B3B;" href="<?php echo SERVER_ROOTPATH; ?>artists-genre-<?php echo $cat_seo_name; ?>"><?php echo $cat_name;




																																																?></a></label>
														</p>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
								</li>
							<?php
								$k++;
							}
						} else { ?>
							<p style="padding:10px; color:#333;">No records found.</p>
						<?php }
						$kval = $k;
						?>
					</ul>

					<?php if ($total_pages > $limit) { ?>
						<div class="page-navigation">
							<ul>
								  @include("common.paging-playlist") 
							</ul>
						</div>
					<?php } ?>
				</div>
				<?php 
				//include "common/artists_common_review.php";
				 ?>
				<!-- Advertisement Banner Start-->
				<div class="clear"></div>
				<div class="container" style="padding-top:10px;">
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<?php echo ads_info('Bottom'); ?>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
					</div>
				</div>
				<!--Advertisement Banner End-->
			</div>



		</div>
	</div>
</section>




<style>
	body {
		overflow-x: hidden;
	}
</style>
<script type="text/javascript">
	$(window).load(function() {
		$('#owl-carousel1').owlCarousel({
			loop: false,
			margin: 10,
			responsiveClass: true,
			responsive: {
				0: {
					items: 1,
					nav: false
				},

				1000: {
					items: 2,
					nav: false,
					loop: false,
					margin: 20
				}
			}
		})
		$('#owl-carousel2').owlCarousel({
			loop: false,
			margin: 10,
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
		$('.topsongssec .next').on('click', function() {
			$('.topsongssec .owl-next').click();
		})
		$('.topsongssec .prev').on('click', function() {
			$('.topsongssec .owl-prev').click();
		})

	})
</script>


<?php
// include("common/signin_modal.php");
// include_once("common/popular_review.php");
?>
<?php
for ($u = 1; $u <= $m; $u++) {
?>
	<div class="modal fade" id="missing_store_detail_Modal_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}

?>
<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>



@include("common.footer")