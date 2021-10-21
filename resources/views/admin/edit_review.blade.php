@include("admin.includes.top")
@include("admin.common.security")

<html>

<head>

	<title>Edit Review</title>



	<style>
		.pie {
			behavior: url(PIE.htc);
		}
	</style>

	<?php
	error_reporting(0);
	if ($edit_id != "") {
		$edit_id = base64_decode($edit_id);
		$qry  = "select review_id, review_title, review_detail, review_rating, review_user_id from tbl_reviews where review_id='" . $edit_id . "' ";
		$row  = \App\Models\Songs::GetRawDataAdmin($qry);
		 
		$db_review_id   = $row['review_id'];
		$review_rating  = $row['review_rating'];
		$review_user_id = $row['review_user_id'];
		$review_title 	= stripslashes(html_entity_decode($row['review_title']));
		$review_detail  = stripslashes(html_entity_decode($row['review_detail']));
	}
	if ($db_review_id != "") {
		$addedit = 'Edit';
	} else {

	?>
		<script>
			window.location.href = '<?php echo SERVER_ADMIN_PATH; ?>reviews_list';
		</script>
	<?php
	}

	?>
	@include("admin.common.header")

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

														<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">

															<tbody>

																<tr>

																	<td align="left">

																		<a href="<?php echo SERVER_ADMIN_PATH; ?>/index">Home</a>

																		&raquo; <a href="<?php echo SERVER_ADMIN_PATH; ?>reviews_list">Review Listing</a>

																		&raquo; <a>Edit Review</a>
																	</td>

																</tr>



																<?php if (isset($errorstr) && $errorstr != "") { ?>

																	<tr>

																		<td colspan="8">

																			<table border="0" cellpadding="0" cellspacing="0" class="Message">

																				<tbody>

																					<tr>

																						<td width="20" valign="top">

																							<?php if ($case == 1) { ?>

																								<img src="images/success_icon.png" vspace="5" width="18" height="18" hspace="10">

																							<?php } ?>

																							<?php if ($case == 2) { ?>

																								<img src="images/warning_icon.png" vspace="5" width="18" height="18" hspace="10">

																							<?php } ?>

																							<?php if ($case == 0) { ?>

																								<img src="images/error_icon.png" vspace="5" width="18" height="18" hspace="10">

																							<?php } ?>
																						</td>

																						<td width="100%"><?php echo $errorstr; ?></td>

																					</tr>

																				</tbody>

																			</table>

																		</td>

																	</tr>

																<?php } ?>



																<tr>

																	<td>

																		<form name="edit_review_form" id="edit_review_form" action="" method="post" enctype="multipart/form-data">
																			@csrf
																			<table class="Panel">

																				<tbody>

																					<tr>

																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Rating:</td>

																						<td width="88%">

																							<select name="review_rating" id="review_rating" style="padding:4px 1px;width:150px;">

																								<option value="">--- Select Rating --- </option>

																								<?php

																								for ($i = 1; $i <= 10; $i = $i + 0.5) {
																									if ($review_rating == $i) {
																										$rating_selectet = 'selected="selected"';
																									} else {
																										$rating_selectet = '';
																									}
																								?>
																									<option value="<?php echo $i; ?>" <?php echo $rating_selectet; ?>><?php echo $i; ?></option>
																								<?php
																								}
																								?>

																							</select>

																							<span class="Required">*</span>

																						</td>

																					</tr>

																					<tr>

																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Review Title:</td>

																						<td width="88%">

																							<textarea name="review_title" id="review_title" style="width:650px;height:93px;"><?php echo $review_title; ?></textarea>

																							<span class="Required">*</span>

																						</td>

																					</tr>

																					<tr>

																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Review Details:</td>

																						<td width="88%">

																							<textarea name="review_detail" id="review_detail" style="width:651px;height:197px;"><?php echo $review_detail; ?></textarea>

																							<span class="Required">*</span>

																						</td>

																					</tr>



																					<tr>

																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">User:</td>

																						<td width="88%">
																							<?php
																							$users_qry = "select user_name from tbl_users where user_id='" . $review_user_id . "' ";
																							$users_arr = \App\Models\Songs::GetRawDataAdmin($users_qry);
																							 
																							echo '<strong>' . $user_name = html_entity_decode(stripslashes($users_arr['user_name'])) . '</strong>';
																							?>
																							<select name="review_user_id" id="review_user_id" style="width:300px;padding:4px 1px;display:none;">

																								<option value=""> ------ Please Select User ------</option>

																								<?php
																								$users_qry = "select user_id,user_name from tbl_users where status=1
                     order by user_name asc";
																								$users_arr = \App\Models\Songs::GetRawData($users_qry);
																							 
																								 
																								if ($users_arr) {
																									foreach ($users_arr as $val) {
																										$val = (array)$val;

																										$user_id   = $val['user_id'];
																										$user_name = html_entity_decode(stripslashes($val['user_name']));
																										if ($review_user_id == $user_id) {
																											$selected = "selected='selected'";
																										} else {
																											$selected = "";
																										}
																								?>

																										<option value="<?php echo $user_id; ?>" <?php echo $selected; ?>><?php echo $user_name; ?></option>
																									<?php
																									}
																									?>
																								<?php

																								}

																								?>

																							</select>

																							<!--<span class="Required">*</span>-->

																						</td>

																					</tr>




																					<tr>
																						<td id="load_level2_id" colspan="2"></td>
																					</tr>
																					<tr>
																						<td id="load_level3_id" colspan="2"></td>
																					</tr>
																					<tr>
																						<td id="load_level4_id" colspan="2"></td>
																					</tr>
																					<tr>
																						<td id="load_level5_id" colspan="2"></td>
																					</tr>
																					<tr>

																						<td class="SmallFieldLabel2">&nbsp;</td>

																						<td>&nbsp;</td>

																					</tr>

																					<tr>

																						<td>&nbsp;</td>

																						<td>
																							<?php
																							if ($db_review_id != "") {
																							?>
																								<input type="hidden" name="update_id" id="update_id" value="<?php echo $db_review_id; ?>" />
																								<input name="edit_review" id="edit_review" value="Save" class="FormButton" type="submit" onClick="validate_edit_review();" />
																							<?php
																							}
																							?>
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
					edit_category_level2_review('<?php echo $cat_level1; ?>', '<?php echo $db_review_id; ?>');
					edit_category_level3_review('<?php echo $cat_level2; ?>', '<?php echo $db_review_id; ?>');
					edit_category_level4_review('<?php echo $cat_level3; ?>', '<?php echo $db_review_id; ?>');
					edit_category_level5_review('<?php echo $cat_level4; ?>', '<?php echo $db_review_id; ?>');
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



</html>