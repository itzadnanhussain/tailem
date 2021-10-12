@include("admin.includes.top")
@include("admin.common.security")
<?php
error_reporting(0);
$setting_qry = "select * from tbl_general_setting where setting_id='1'";
$setting_arr	=	\App\Models\Songs::GetRawDataAdmin($setting_qry);
// echo '<pre>';
// print_r($setting_arr);
// echo '</pre>';
// die;
$facebook_right_script  = stripslashes(html_entity_decode($setting_arr['facebook_right_script']));
$facebook_bottom_script	= stripslashes(html_entity_decode($setting_arr['facebook_bottom_script']));

$rate_review	= stripslashes(html_entity_decode($setting_arr['rate_review']));
$discuss	= stripslashes(html_entity_decode($setting_arr['discuss']));
$profile	= stripslashes(html_entity_decode($setting_arr['profile']));
$rhyming_larics	= stripslashes(html_entity_decode($setting_arr['rhyming_larics']));

$desktop_version_logo	= $setting_arr['desktop_version_logo'];
$mobile_version_logo	= $setting_arr['mobile_version_logo'];
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

													<td class="heading1">Social Icons Setting</td>
												</tr>

												<tr>
													<td class="body">
														<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
															<tbody>
																<tr>
																	<td align="left"><a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a> &raquo; <a>Social Icons Setting</a></td>
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
																 
																<?php foreach ($icon_data as  $value) { ?>  
																<tr>
																	<td>
																		<form class="social_icons" action="" method="post" enctype="application/x-www-form-urlencoded">
																			@csrf
																			<input type="hidden" name="icon_id" value="<?php echo $value->icon_id ?>" />
																			<input type="hidden" name="icon_name" value="<?php echo $value->icon_name ?>" />

																			<table class="Panel" style="width:1300px;">
																				<tbody>
																					<tr>
																						<td class="Heading2" colspan="2"><strong>Social Icons <?php echo $value->icon_name ?></strong></td>
																					</tr>
																					<tr>
																						<td colspan="2">&nbsp;</td>
																					</tr>

																					<tr>
																						<td width="15%" nowrap="nowrap" class="SmallFieldLabel2">Upload Icon for <?php echo $value->icon_name ?>:</td>
																						<td width="85%">
																							<input type="file" name="large_screen_icon" id="social_icon" />
																							<br />
																							<!-- <span class="required"><strong>Only JPG,GIF or PNG format of size: 286X44</strong></span> -->
																							 
                                                                                            <br /><br />
																							<img src="<?php echo  SERVER_ROOTPATH .$value->large_screen_icon ?>" alt="">
                                                                                            <br /><br />
																							 
																						</td>
																					</tr>


																					<tr>
																						<td>&nbsp;</td>
																						<td>
																							<input name="update_icon" id="update_record" value="Update" class="FormButton" type="submit" onClick="validate_social_icon();">
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</form>
																	</td>
																</tr>
																<tr>
																</tr>
																<?php  } ?>

															 
																
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