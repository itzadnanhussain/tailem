@include("admin.includes.top")
@include("admin.common.security")
<?php
 

if (isset($edit_id) && ($edit_id != "")) {

	$edit_id = base64_decode($edit_id);
	$qry  =  "select user_id,user_name,fname,lname,gender,email, about_me, country_id, region, 
	profile_image from tbl_users where user_id='" . $edit_id . "'";
	$row = \App\Models\Songs::GetRawData($qry);
	$row = (array)$row[0];
	$user_id 	     = $row['user_id'];
	$db_country_id   = $row['country_id'];
	$user_name 	     = stripslashes(html_entity_decode($row['user_name']));
	$fname   	     = stripslashes(html_entity_decode($row['fname']));
	$lname  	     = stripslashes(html_entity_decode($row['lname']));
	$gender          = $row['gender'];
	$user_email 	 = stripslashes(html_entity_decode($row['email']));
	$region   	     = stripslashes(html_entity_decode($row['region']));
	$about_me   	 = stripslashes(html_entity_decode($row['about_me']));
	$profile_image   = stripslashes(html_entity_decode($row['profile_image']));
	$addedit = 'Edit';
} else {

	$addedit = 'Add';
}
?>
<html>

<head>
	<title><?php echo $addedit; ?> Users</title>
	<script language="javascript" type="text/javascript">
		function toggleChecked(status) {

			$(".check-all").each(function() {
				$(this).attr("checked", status);
			})
		}
	</script>
	<style>
		.pie {
			behavior: url(PIE.htc);
		}
	</style>
	<script type="text/javascript">
		function delete_image_user(id) // for changing multiple status or multiple delete 
		{
			var conBox = confirm("Are you sure,you want to delete this image?");
			if (conBox) {
				window.location.href = "<?php echo SERVER_ADMIN_PATH; ?>addedit_user?del_id=" + id;
			}
		}
	</script>

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
													<td class="heading1"><?php echo $addedit; ?> Users</td>
												</tr>

												<tr>
													<td class="body">
														<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
															<tbody>
																<tr>
																	<td align="left">
																		<a href="<?php echo SERVER_ADMIN_PATH; ?>/index">Home</a>
																		&raquo; <a href="<?php echo SERVER_ADMIN_PATH; ?>users_list">Users Listing</a>
																		&raquo; <a><?php echo $addedit; ?> Users</a>

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
																		<form name="user_form" id="user_form" action="" method="post" enctype="multipart/form-data">
																			@csrf
																			<table class="Panel">
																				<tbody>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Display Name:</td>
																						<td width="88%">
																							<input type="text" name="user_name" id="user_name" value="<?php echo $user_name; ?>" class="fields" />
																							<span class="Required">*</span>
																						</td>
																					</tr>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">&nbsp;</td>
																						<td width="88%">
																							<span class="Required"><strong>Display name will appear on all of contributions.</strong></span>
																						</td>
																					</tr>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Email:</td>
																						<td width="88%">
																							<input type="text" name="user_email" id="user_email" value="<?php echo $user_email; ?>" class="fields" />
																							<span class="Required">*</span>
																						</td>
																					</tr>
																					<!--<tr>
                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Confirm Email:</td>
                    <td width="88%">
                    <input type="text" name="confirm_email" id="confirm_email" value="<?php echo $user_email; ?>" 
                    class="fields" /> 
                   
                    <span class="Required">*</span>
                    </td>
                  </tr>-->
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Password:</td>
																						<td width="88%">
																							<input type="password" name="simple_password" id="simple_password" class="fields" autocomplete="off" />
																							<span class="Required">*</span>
																						</td>
																					</tr>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">&nbsp;</td>
																						<td width="88%">
																							<span class="Required"><strong>Password must be a minimum of 6 characters.</strong></span>
																						</td>
																					</tr>
																					<!--<tr>
                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Country:</td>
                    <td width="88%">
                    <select name="country_id" id="country_id" class="Field300" style="width:251px;">
                     	<option value=""> ------ Please Select Country ------</option>
                     <?php
						$select_qry = "select country_id,name from tbl_countries order by name asc";
						$select_arr = \App\Models\Songs::GetRawData($select_qry);
						if ($select_arr) {
							foreach ($select_arr as $val) {
								$val = (array)$val;
								$country_id = $val['country_id'];
								$name	    = html_entity_decode(stripslashes($val['name']));
								if ($db_country_id == $country_id) {
									$selected = "selected='selected'";
								} else {
									$selected = "";
								}
						?>
                        <option value="<?php echo $country_id; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
						<?php
							}
						?>
                     
					 <?php
						}
						?>
                     </select>
                     <span class="Required">*</span>
                    </td>
                  </tr>
                  <tr>
                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">State/Region:</td>
                    <td width="88%">
                    <input type="text" name="region" id="region" value="<?php echo $region; ?>" class="fields" />
                    <span class="Required">*</span>
                    </td>
                  </tr>-->
																					<tr>
																						<td colspan="2">
																							<table width="905" border="0">
																								<tr>
																									<!--<td width="16%" nowrap="nowrap" class="SmallFieldLabel2">About Me:</td>
                                <td width="83%">-->
																									<?php
																									/*include_once 'ckeditor/ckeditor';  
                                $ckeditor = new CKEditor();
                                $ckeditor->basePath = '';
                                $ckeditor->config['filebrowserBrowseUrl'] = '/ckfinder/ckfinder.html';
                                $ckeditor->config['filebrowserImageBrowseUrl'] =	
                                'ckeditor/ckfinder/ckfinder.html?type=Images';
                                $ckeditor->config['filebrowserFlashBrowseUrl'] = 
                                'ckeditor/ckfinder/ckfinder.html?type=Flash';
                                $ckeditor->editor('about_me',$about_me);*/
																									?>
																									<!-- <textarea name="about_me" id="about_me" style="width:501px;height:221px;"><?php echo $about_me; ?></textarea>
                            </td>-->
																									<td width="3%" style="text-align:left;"></td>
																								</tr>
																							</table>
																						</td>

																					</tr>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Upload Profile Picture:</td>
																						<td width="88%">
																							<input type="file" name="image_name" id="image_name" />
																							</br>
																							<span class="Required" />
																							<strong>Profile picture is optional. JPG,GIF or PNG format</strong>
																							</span>
																							<?php
																							if ($profile_image != "") {
																							?>
																								</br></br>
																								<img src="<?php echo SERVER_ROOTPATH; ?>site_upload/user_images/<?php echo 'small_thumb_' . $profile_image; ?>" border="0" />
																								&nbsp;
																								<a href="javascript:;" onClick="delete_image_user('<?php echo $_REQUEST['edit_id']; ?>')"><img src="images/delet.gif" border="0" title="Delete Artist" class="Action"></a>
																							<?php
																							}
																							?>
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
																							if (isset($edit_id) && $edit_id != '') {
																							?>
																								<input type="hidden" name="update_id" id="update_id" value="<?php echo $edit_id; ?>">
																								<input name="update_user" id="update_user" value="Update" class="FormButton" type="submit" onClick="validate_user();" />
																							<?php
																							} else {
																							?>
																								<input name="add_user" id="add_user" value="Add" class="FormButton" type="submit" onClick="validate_user();" />
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