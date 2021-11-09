@include("admin.includes.top")
@include("admin.common.security")
<?php
// @include("admin.includes.operations.myaccount_op");
/************************************ Get Admin email *************************************************/
$admin_id       = 	session()->get('reviewsite_cpadmin_id');
$getadmindata	=	"select email from tbl_admin where id=\"" . $admin_id . "\"";
$rowadmindata	=	\App\Models\Songs::GetRawDataAdmin($getadmindata);;
$adminemail		=	$rowadmindata['email'];

$setting_data_qry = "select site_mode, analaytic,copy_right_text, itune_url from tbl_setting where setting_id='1'";
$setting_data_arr = \App\Models\Songs::GetRawDataAdmin($setting_data_qry);
$site_mode   	  = $setting_data_arr['site_mode'];
$analaytic   	  = stripslashes($setting_data_arr['analaytic']);
$itune_url   	  = stripslashes($setting_data_arr['itune_url']);
$copy_right_text   	  = stripslashes($setting_data_arr['copy_right_text']);

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

													<td class="heading1">Setting</td>
												</tr>

												<tr>
													<td class="body">
														<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
															<tbody>
																<tr>
																	<td align="left"><a href="<?php echo SERVER_ADMIN_PATH; ?>index.php">Home</a> &raquo; <a>Setting</a></td>
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
																		<form name="change_pass_form" id="change_pass_form" action="" method="post">
																			<table class="Panel">
																				<tbody>
																					<tr>
																						<td class="Heading2" colspan="2">Change Password</td>
																					</tr>
																					<tr>
																						<td width="19%" nowrap="nowrap" class="SmallFieldLabel2">Password:</td>
																						<td width="81%">
																							<input name="old_password" id="old_password" class="Field150" value="" type="password" maxlength="20">
																						</td>
																					</tr>

																					<tr>
																						<td class="SmallFieldLabel2" nowrap="nowrap">New Password:</td>
																						<td>
																							<input name="new_password" id="new_password" class="Field150" value="" type="password" maxlength="20">
																						</td>
																					</tr>

																					<tr>
																						<td class="SmallFieldLabel2" nowrap="nowrap">Confirm New Password:</td>
																						<td>
																							<input name="confirm_new_password" id="confirm_new_password" class="Field150" value="" type="password" maxlength="20">
																						</td>
																					</tr>

																					<tr>
																						<td>&nbsp;</td>
																						<td><input name="updatemyaccountpass" id="updatemyaccountpass" value="Update" class="FormButton" type="submit" onClick="validate_admin_password();"> </td>
																					</tr>
																				</tbody>
																			</table>
																		</form>
																	</td>
																</tr>
																<tr>
																	<td>
																		<form name="email_form" id="email_form" action="" method="post">
																			<table class="Panel">
																				<tbody>
																					<tr>
																						<td class="Heading2" colspan="2">Change Email Address</td>
																					</tr>
																					<tr>
																						<td width="19%" nowrap="nowrap" class="SmallFieldLabel2">Email Address:</td>
																						<td width="81%">
																							<input name="admin_email" id="admin_email" class="Field150" value="<?php echo $adminemail; ?>" type="text" maxlength="50">
																						</td>
																					</tr>


																					<tr>
																						<td>&nbsp;</td>
																						<td>
																							<input name="updatemyaccountemail" id="updatemyaccountemail" value="Update" class="FormButton" type="submit" onClick="validate_email();">
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</form>
																	</td>
																</tr>

 																<tr>
																	<td>
																		<form name="copyright_text" id="copyright_text" action="" method="post">
																			<table class="Panel">
																				<tbody>
																					<tr>
																						<td class="Heading2" colspan="2">Change Copy Right Text</td>
																					</tr>
																					<tr>
																						<td width="19%" nowrap="nowrap" class="SmallFieldLabel2">Copy Right Text:</td>
																						<td width="81%">
																							@csrf
																							<input name="copy_right_text" id="copy_right_text" type="text" class="Field150" value="<?php echo $copy_right_text; ?>">
																						</td>
																					</tr>


																					<tr>
																						<td>&nbsp;</td>
																						<td>
																							<input value="Update" class="FormButton" type="submit" onClick="Update_copyright_text();">
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</form>
																	</td>
																</tr>




																<?php
																if (session()->get('reviewsite_cpadmin_type') == 'admin') {
																?>

																	<tr>
																		<td>
																			<form name="itune_form" id="itune_form" action="" method="post">
																				<table class="Panel">
																					<tbody>
																						<tr>
																							<td class="Heading2" colspan="2">Change Itune URL</td>
																						</tr>
																						<tr>
																							<td width="19%" nowrap="nowrap" class="SmallFieldLabel2">Itune URL:</td>
																							<td width="81%">
																								<input name="itune_url" id="itune_url" class="Field150" value="<?php echo $itune_url; ?>" type="text" size="260">
																							</td>
																						</tr>


																						<tr>
																							<td>&nbsp;</td>
																							<td>
																								<input name="updateituneurl" id="updateituneurl" value="Update" class="FormButton" type="submit" onClick="validate_itune();">
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</form>
																		</td>
																	</tr>

																	<tr>
																		<td>
																			<form name="site_mode_form" id="site_mode_form" action="" method="post">
																				<table class="Panel">
																					<tbody>
																						<tr>
																							<td class="Heading2" colspan="2">Site Mode Status</td>
																						</tr>
																						<tr>
																							<td colspan="2"></td>
																						</tr>
																						<tr>
																							<td width="19%" nowrap="nowrap" class="SmallFieldLabel2">Site Mode:</td>
																							<td width="81%">
																								<input name="site_mode" id="site_mode" value="1" type="radio" <?php if ($site_mode == 1) {
																																									echo "checked='checked'";
																																								} ?> /> <strong>Live Mode</strong>
																								<input name="site_mode" id="site_mode" value="2" type="radio" <?php if ($site_mode == 2) {
																																									echo "checked='checked'";
																																								} ?> /> <strong>Maintenance Mode</strong>
																							</td>
																						</tr>
																						<tr>
																							<td>&nbsp;</td>
																							<td>
																								<input name="site_mode" id="site_mode" value="Update" class="FormButton" type="submit" onClick="validate_site_mode();">
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</form>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<form name="analaytic_form" id="analaytic_form" action="" method="post">
																				<table class="Panel">
																					<tbody>
																						<tr>
																							<td class="Heading2" colspan="2">Google Analaytic Code</td>
																						</tr>
																						<tr>
																							<td colspan="2"></td>
																						</tr>
																						<tr>
																							<td width="19%" nowrap="nowrap" class="SmallFieldLabel2">Google Analaytic Code:</td>
																							<td width="81%">
																								<textarea name="analaytic" id="analaytic" style="width:550px; height:250px;"><?php echo $analaytic; ?></textarea>
																							</td>
																						</tr>
																						<tr>
																							<td>&nbsp;</td>
																							<td>
																								<input name="analaytic_btn" id="analaytic_btn" value="Update" class="FormButton" type="submit" onClick="validate_analytic();">
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</form>
																		</td>
																	</tr>
																<?php
																}
																?>

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

	<script type="text/javascript">
		/*here is code for validation itune url*/

		function validate_itune() {

			var csrf_token = $('meta[name=csrf-token]').attr('content');


			$('#itune_form').unbind('submit');

			var options = {

				target: '',
				data: {
					"_token": csrf_token,
				},

				beforeSubmit: validate_itune_Request,

				success: validate_itune_Response,

				url: JS_ADMIN_SERVER_PATHROOT + 'process/itune_process'



			};



			// bind to the form's submit event

			$('#itune_form').submit(function() {

				$(this).ajaxSubmit(options);

				return false;

			});

		}



		// pre-submit callback

		function validate_itune_Request(formData, jqForm, options)

		{

			var queryString = $.param(formData);

			return true;



		}



		function validate_itune_Response(responseText, statusText)

		{

			if (responseText.search('done') != -1)

			{



				alert("Record Update Successfully");

				window.location.href = JS_ADMIN_SERVER_PATHROOT + "setting";

			} else

			{

				alert(responseText);

			}

		}
	</script>
</body>

</html>