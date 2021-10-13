@include("admin.includes.top")
@include("admin.common.security")
<?php

$dec_id  = base64_decode($song_id);
$dec_artist_id  = base64_decode($artist_id);
$song_list	=	"select song_title from tbl_songs where 1=1 AND id = $dec_id";

$song_list = "SELECT sa.id,a.artist_img,s.song_title,a.artist_name, sa.song_id, sa.artist_id FROM tbl_songs s, tbl_songs_artist sa, tbl_artists a where 1=1 AND a.id = sa.artist_id AND sa.song_id = s.id AND sa.song_id = '$dec_id' AND a.id = '$dec_artist_id'";

$song_list_arr	=	\App\Models\Songs::GetRawDataAdmin($song_list);


?>
<html>

<head>
	<title>ADD Album</title>
	<?php
	if ($top_album_module_add == 'No') {
		$target	= SERVER_ADMIN_PATH;

	?>
		<script language="javascript" type="text/javascript">
			window.location = '<?php echo $target; ?>';
		</script>
	<?php
		exit;
	}
	?>

	<style>
		.pie {
			behavior: url(PIE.htc);
		}
	</style>

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
													<td class="heading1">ADD Album</td>
												</tr>

												<tr>
													<td class="body">
														<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
															<tbody>
																<tr>
																	<td align="left">
																		<a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a> &raquo; <a href="<?php echo SERVER_ADMIN_PATH; ?>song_list">Songs Listing</a>&raquo; <a href="<?php echo SERVER_ADMIN_PATH; ?>artist_list_song?song_id=<?php echo $song_id; ?>"><?php echo stripslashes($song_list_arr['song_title']); ?></a>

																		&raquo; <a><?php echo stripslashes($song_list_arr['artist_name']); ?>
																			&raquo; <a>Add Album (<a href="<?php echo SERVER_ADMIN_PATH; ?>artist_album_list?artist_id=<?php echo $artist_id; ?>" target="_blank" style="text-decoration:none; color:#0000CC">View <?php echo stripslashes($song_list_arr['artist_name']); ?> album</a>)</a>

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
																		<form name="song_form" id="song_form" action="" method="post" enctype="multipart/form-data">
																			<input type="hidden" name="song_id" value="<?php echo $song_id; ?>">
																			<input type="hidden" name="artist_id" value="<?php echo $artist_id; ?>">
																			<table class="Panel">
																				<tbody>


																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Album:</td>
																						<td width="88%">

																							<?php
																							$album_list = "select a.id from  tbl_artist_album a, tbl_songs_artist_album album_art_song 
										where 1=1 AND album_art_song.display_status = 1 AND a.id =  album_art_song.album_id AND album_art_song.song_id = $dec_id AND album_art_song.artist_id = $dec_artist_id order by album_art_song.id desc";



																							$album_list_arr	=	\App\Models\Songs::GetRawData($album_list);

																							if ($album_list_arr) {
																								$arr = array();
																								foreach ($album_list_arr as $val) {
																									$val = (array)$val;
																									$arr[] .=  $val['id'];
																								}
																							}
																							//print_r($arr);



																							$artist_list = "select id, album_title from  tbl_artist_album where 1=1 AND album_status = 1 AND album_artist_id = $dec_artist_id order by album_title asc";

																							$artist_list_arr	=	 \App\Models\Songs::GetRawData($artist_list);

																							if (isset($artist_list_arr)) {
																								$u = 0;
																							?>
																								<div style="width: 400px; height: 200px; overflow-y: scroll; border: solid 1px #000000;">
																									<?php
																									foreach ($artist_list_arr as $val) {
																										$val = (array)$val;
																										$id	  = $val['id'];
																										$album_title = stripslashes(html_entity_decode($val['album_title']));
																										if (in_array($id, $arr)) {
																											$selected = "checked";
																										} else {
																											$selected = "";
																										}


																									?>
																										<input type="checkbox" name="album[]" id="artist_<?php echo $u; ?>" value="<?php echo $id; ?>" <?php echo $selected; ?>> <?php echo $album_title; ?> <br>

																									<?php
																										$u++;
																									}
																									?>
																								</div>
																							<?php

																							} else {
																								echo "No record found";
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
																								<input name="save" id="save" value="Update" class="FormButton" type="submit" onClick="validate_song_artist_album();" />
																							<?php
																							} else {
																							?>
																								<input name="add_cat" id="add" value="Add" class="FormButton" type="submit" onClick="validate_song_artist_album();" />
																							<?php
																							}
																							?>
																							<div id="loader"></div>
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
					@include("admin.common.footer") </td>
			</tr>
		</tbody>
	</table>
	<!-- End pagefooter -->
</body>

</html>