@include("admin.includes.top")
@include("admin.common.security")
<html>

<head>

	<title>ADD New Review</title>



	<style>
		.pie {
			behavior: url(PIE.htc);
		}
	</style>

	<?php
    if ($song_id != "" && $art_id != "") {
        // $edit_id = base64_decode($edit_id);
        $song_list = "select a.id as artist_id, s.song_title, s.song_seo, a.artist_seo, a.artist_name, s.id, b.id as album_id from tbl_artist_album b, tbl_artists a, tbl_songs_artist_album saa, tbl_songs s where 1=1 AND s.id = saa.song_id AND a.id = saa.artist_id AND b.id = saa.album_id AND s.id = '$song_id'  AND a.id = '$art_id'";

        $song_list_arr	=	\App\Models\Songs::GetRawDataAdmin($song_list);

        if ($song_list_arr) {
            $id	  = $song_list_arr['id'];
            $artist_id	  = $song_list_arr['artist_id'];
            $song_id	  = $song_list_arr['id'];
            $album_id	  = $song_list_arr['album_id'];

            $artist_name = stripslashes(html_entity_decode($song_list_arr['artist_name']));
            $song_title = stripslashes(html_entity_decode($song_list_arr['song_title']));
        } else {
            ?>
	<script type="text/javascript">
		window.location.href = "song_list";
	</script>
	<?php
            exit;
        }
    } else {
        ?>
	<script type="text/javascript">
		window.location.href = "song_list";
	</script>
	<?php
        exit;
    }

    ?>
	@include("admin.common.header")
	<link href="css/style.css?id=<?php echo rand(9999, 999999); ?>"
		rel="stylesheet" type="text/css">

	<SCRIPT LANGUAGE="JavaScript" src="js/script.js"></SCRIPT>

</head>

<body>



	<table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">

		<tbody>

			<tr>

				<td style="background-image:URL('images/topbg.png');background-repeat:repeat;height:50px;" height="50">

					@include("admin.common.top_right_menu")

				</td>

			</tr>



			<tr>

				<td valign="top">

					<table border="0" width="100%">

						<tbody>

							<tr>

								<td width="10">&nbsp;</td>

								<td>

									<div class="BodyContainer">

										<table border="0" cellpadding="0" cellspacing="0" width="100%">

											<tbody>

												<tr>

													<td class="heading1">Edit Review</td>

												</tr>



												<tr>

													<td class="body">

														<table id="Table1" border="0" cellpadding="0" cellspacing="0"
															width="100%">

															<tbody>

																<tr>

																	<td align="left">

																		<a
																			href="<?php echo SERVER_ADMIN_PATH; ?>/index">Home</a>

																		&raquo; <a
																			href="<?php echo SERVER_ADMIN_PATH; ?>song_list">Song
																			Listing</a>

																		&raquo; <a><strong>Song</strong> <?php echo $song_title; ?></a>

																		&raquo; <a><strong>Artist</strong> <?php echo $artist_name; ?></a>



																		&raquo; <a>ADD Review</a>
																	</td>

																</tr>



																<?php if (isset($errorstr) && $errorstr != "") { ?>

																<tr>

																	<td colspan="8">

																		<table border="0" cellpadding="0"
																			cellspacing="0" class="Message">

																			<tbody>

																				<tr>

																					<td width="20" valign="top">

																						<?php if ($case == 1) { ?>

																						<img src="images/success_icon.png"
																							vspace="5" width="18"
																							height="18" hspace="10">

																						<?php } ?>

																						<?php if ($case == 2) { ?>

																						<img src="images/warning_icon.png"
																							vspace="5" width="18"
																							height="18" hspace="10">

																						<?php } ?>

																						<?php if ($case == 0) { ?>

																						<img src="images/error_icon.png"
																							vspace="5" width="18"
																							height="18" hspace="10">

																						<?php } ?>
																					</td>

																					<td width="100%"><?php echo $errorstr; ?>
																					</td>

																				</tr>

																			</tbody>

																		</table>

																	</td>

																</tr>

																<?php } ?>



																<tr>

																	<td>

																		<form name="add_review_form"
																			id="add_review_form" action="" method="post"
																			enctype="multipart/form-data">
																			@csrf
																			<input type="hidden" name="song_id"
																				value="<?php echo $song_id; ?>">
																			<input type="hidden" name="artist_id"
																				value="<?php echo $artist_id; ?>">
																			<input type="hidden" name="album_id"
																				value="<?php echo $album_id; ?>">


																			<table class="Panel">

																				<tbody>

																					<tr>

																						<td width="12%" nowrap="nowrap"
																							class="SmallFieldLabel2">
																							Rating:</td>

																						<td width="88%">

																							<select name="review_rating"
																								id="review_rating"
																								style="padding:4px 1px;width:150px;">

																								<option value="">---
																									Select Rating ---
																								</option>

																								<?php

                                                                                                for ($i = 1; $i <= 10; $i = $i + 0.5) {
                                                                                                    if ($review_rating == $i) {
                                                                                                        $rating_selectet = 'selected="selected"';
                                                                                                    } else {
                                                                                                        $rating_selectet = '';
                                                                                                    } ?>
																								<option
																									value="<?php echo $i; ?>"
																									<?php echo $rating_selectet; ?>><?php echo $i; ?>
																								</option>
																								<?php
                                                                                                }
                                                                                                ?>

																							</select>

																							<span
																								class="Required">*</span>

																						</td>

																					</tr>

																					<tr>

																						<td width="12%" nowrap="nowrap"
																							class="SmallFieldLabel2">
																							Review Title:</td>

																						<td width="88%">

																							<textarea
																								name="review_title"
																								id="review_title"
																								style="width:650px;height:93px;"><?php echo $review_title; ?></textarea>

																							<span
																								class="Required">*</span>

																						</td>

																					</tr>

																					<tr>

																						<td width="12%" nowrap="nowrap"
																							class="SmallFieldLabel2">
																							Review Details:</td>

																						<td width="88%">

																							<textarea
																								name="review_detail"
																								id="review_detail"
																								style="width:651px;height:197px;"><?php echo $review_detail; ?></textarea>

																							<span
																								class="Required">*</span>

																						</td>

																					</tr>



																					<tr>

																						<td width="12%" nowrap="nowrap"
																							class="SmallFieldLabel2">
																							User:</td>

																						<td width="88%">


																							<div id="holder">
																								<input type="text"
																									id="keyword"
																									name="review_user_id"
																									tabindex="0"
																									class="fields"><img
																									src="images/load.gif"
																									id="loading">
																							</div>
																							<div id="ajax_response">
																							</div>
																							<!--<span class="Required">*</span>-->

																						</td>

																					</tr>




																					<tr>
																						<td id="load_level2_id"
																							colspan="2"></td>
																					</tr>
																					<tr>
																						<td id="load_level3_id"
																							colspan="2"></td>
																					</tr>
																					<tr>
																						<td id="load_level4_id"
																							colspan="2"></td>
																					</tr>
																					<tr>
																						<td id="load_level5_id"
																							colspan="2"></td>
																					</tr>
																					<tr>

																						<td class="SmallFieldLabel2">
																							&nbsp;</td>

																						<td>&nbsp;</td>

																					</tr>

																					<tr>

																						<td>&nbsp;</td>

																						<td>

																							<input name="edit_review"
																								id="edit_review"
																								value="Save"
																								class="FormButton"
																								type="submit"
																								onClick="validate_add_review();" />

																						</td>

																					</tr>

																				</tbody>

																			</table>

																		</form>

																	</td>

																</tr>

																<tr>

																	<td>&nbsp;</td>

																</tr>

															</tbody>

														</table>

													</td>

												</tr>

											</tbody>

										</table>

									</div>

								</td>

								<td width="10">&nbsp;</td>

							</tr>

						</tbody>

					</table>

				</td>

			</tr>
			<?php
            if ($db_review_id != "") {
                ?>
			<script>
				edit_category_level2_review('<?php echo $cat_level1; ?>',
					'<?php echo $db_review_id; ?>');
				edit_category_level3_review('<?php echo $cat_level2; ?>',
					'<?php echo $db_review_id; ?>');
				edit_category_level4_review('<?php echo $cat_level3; ?>',
					'<?php echo $db_review_id; ?>');
				edit_category_level5_review('<?php echo $cat_level4; ?>',
					'<?php echo $db_review_id; ?>');
			</script>
			<?php
            }
            ?>
			<tr>
				<td height="20">
					@include("admin.common.footer")</td>
			</tr>

		</tbody>

	</table>

	<!-- End pagefooter -->

</body>

<script type="text/javascript">
	/*===================Validate Edit Review ====================*/

	function validate_add_review() {



		$('#add_review_form').unbind('submit');

		var options = {

			target: '',

			beforeSubmit: validate_add_review_Request,

			success: validate_add_review_Response,

			url: JS_ADMIN_SERVER_PATHROOT + 'process/add_review_process'



		};



		// bind to the form's submit event

		$('#add_review_form').submit(function() {

			$(this).ajaxSubmit(options);

			return false;

		});

	}



	// pre-submit callback

	function validate_add_review_Request(formData, jqForm, options)

	{

		var queryString = $.param(formData);

		return true;



	}



	function validate_add_review_Response(responseText, statusText)

	{

		if (responseText.search('done') != -1)

		{



			alert("Record Save Successfully");

			window.location.href = JS_ADMIN_SERVER_PATHROOT + "reviews_list";

		} else

		{

			alert(responseText);

		}

	}
</script>

</html>