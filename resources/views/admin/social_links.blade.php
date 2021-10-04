@include("admin.includes.top")
@include("admin.common.security")
<?php 
$get_lnks_qry	=	"select facebook,twitter,pinterest,google,linkedin from tbl_social_links where links_id='1'";
$get_lnks_arr	=	\App\Models\Songs::GetRawDataAdmin($get_lnks_qry);
 
$facebook		=	stripslashes(html_entity_decode($get_lnks_arr['facebook']));
$twitter		=	stripslashes(html_entity_decode($get_lnks_arr['twitter']));
$pinterest		=	stripslashes(html_entity_decode($get_lnks_arr['pinterest']));
$google  		=	stripslashes(html_entity_decode($get_lnks_arr['google']));
$linkedin		=	stripslashes(html_entity_decode($get_lnks_arr['linkedin']));
?>
<html>

<head>
	@include("admin.common.header")
</head>

<body>
	<table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">
		<tbody>
			<tr>
				<td style="background:#1F3C5C; background-repeat:repeat-x; height:60px;" height="60">
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

													<td class="heading1">Follow Us</td>
												</tr>

												<tr>
													<td class="body">
														<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
															<tbody>
																<tr>
																	<td align="left"><a href="<?php echo SERVER_ADMIN_PATH; ?>index.php">Home</a> &raquo; <a>Follow Us</a></td>
																</tr>
																<?php if (isset($msg) && $msg != "") { ?>
																	<tr>
																		<td>
																			<table border="0" cellpadding="0" cellspacing="0" class="Message">
																				<tbody>
																					<tr>
																						<td width="20">
																							<?php if ($case == 1) { ?>
																								<img src="images/success_icon.png" vspace="5" width="18" height="18" hspace="10">
																							<?php } ?>
																							<?php if ($case == 2) { ?>
																								<img src="images/warning_icon.png" vspace="5" width="18" height="18" hspace="10">
																							<?php } ?>
																							<?php if ($case == 3) { ?>
																								<img src="images/error_icon.png" vspace="5" width="18" height="18" hspace="10">
																							<?php } ?>
																						</td>
																						<td width="100%"><?php echo base64_decode($msg); ?></td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																<?php } ?>
																<tr>
																	<td>
																		<form name="social_link_form" id="social_link_form" action="" method="post">
																			@csrf
																			<table class="Panel" style="width:1300px;">
																				<tbody>
																					<tr>
																						<td class="Heading2" colspan="2"><strong>Follow us</strong></td>
																					</tr>
																					<tr>
																						<td colspan="2">&nbsp;</td>
																					</tr>
																					<tr>
																						<td width="15%" nowrap="nowrap" class="SmallFieldLabel2">FaceBook url:</td>
																						<td width="85%">
																							<input name="facebook" id="facebook" class="Field300" value="<?php echo $facebook; ?>" type="text">
																						</td>
																					</tr>
																					<tr>
																						<td width="15%" nowrap="nowrap" class="SmallFieldLabel2">Linkedin url:</td>
																						<td width="85%">
																							<input name="linkedin" id="linkedin" class="Field300" value="<?php echo $linkedin; ?>" type="text">
																						</td>
																					</tr>

																					<tr>
																						<td class="SmallFieldLabel2" nowrap="nowrap">Twitter Url:</td>
																						<td>
																							<input name="twitter" id="twitter" class="Field300" value="<?php echo $twitter; ?>" type="text" />
																						</td>
																					</tr>
																					<tr>
																						<td class="SmallFieldLabel2" nowrap="nowrap">Google+ Url:</td>
																						<td>
																							<input name="google" id="google" class="Field300" value="<?php echo $google; ?>" type="text" />
																						</td>
																					</tr>

																					<tr>
																						<td class="SmallFieldLabel2" nowrap="nowrap">Pinterest Url:</td>
																						<td>
																							<input name="pinterest" id="pinterest" class="Field300" value="<?php echo $pinterest; ?>" type="text" />
																						</td>
																					</tr>
																					<tr>
																						<td>&nbsp;</td>
																						<td>
																							<input name="update_links" id="update_links" value="Update" class="FormButton" type="submit" onClick="validate_social_links();">
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</form>
																	</td>
																</tr>
																<tr>

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
</body>

</html>