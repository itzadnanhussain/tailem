@include("admin.includes.top")
@include("admin.common.security")
<html>
	<?php
	error_reporting(0);
	?>

<head>
	<title>Edit Discussion</title>
	<style>
		.pie {
			behavior: url(PIE.htc);
		}
	</style>
	<?php
	if ($edit_id != "") {
		$editid = base64_decode($edit_id); 
		$row  =  \App\Models\Songs::GetRawDataAdmin("select comment_id, comment_user_id, comment_details from tbl_comments where comment_id='" . $editid . "' "); 
	 
		$db_gcomment_id   = $row['comment_id'];
		$gcomment_user_id = $row['comment_user_id'];
 		$gcomment_detail  =  $row['comment_details'];
	 
	}
	if ($db_gcomment_id != "") {
		$addedit = 'Edit';
	} else {
	?>
		<script>
			window.location.href = '<?php echo SERVER_ADMIN_PATH; ?>gcomments';
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
													<td class="heading1">Edit Discussion</td>
												</tr>
												<tr>
													<td class="body">
														<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
															<tbody>
																<tr>
																	<td align="left">
																		<a href="<?php echo SERVER_ADMIN_PATH; ?>/index">Home</a>
																		&raquo; <a href="<?php echo SERVER_ADMIN_PATH; ?>gcomments">Discussion Listing</a> &raquo; <a>Edit Review</a>
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
																		<form name="edit_discussion_form" id="edit_discussion_form" action="" method="post" enctype="multipart/form-data">

																			@csrf
																			<table class="Panel">
																				<tbody>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Details:</td>
																						<td width="88%">
																							<textarea name="gcomment_detail" id="gcomment_detail" style="width:650px;height:93px;"><?php echo $gcomment_detail; ?></textarea>
																							<span class="Required">*</span>
																						</td>
																					</tr>
																					<tr>
																						<td class="SmallFieldLabel2">&nbsp;</td>
																						<td>&nbsp;</td>
																					</tr>
																					<tr>
																						<td>&nbsp;</td>
																						<td>
																							<?php
																							if ($db_gcomment_id != "") {
																							?>
																								<input type="hidden" name="update_id" id="update_id" value="<?php echo $db_gcomment_id; ?>" />
																								<input name="edit_discussion" id="edit_discussion" value="Save" class="FormButton" type="submit" onClick="validate_edit_discussion();" />
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
			<tr>
				<td height="20">
					@include("admin.common.footer")
				</td>
			</tr>
		</tbody>
	</table>
	<!-- End pagefooter -->
</body>

</html>