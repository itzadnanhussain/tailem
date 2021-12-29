@include("admin.includes.top")
@include("admin.common.security")
<?php

$dec_main_artist   = base64_decode($main_artist);
$dec_album_id   = base64_decode($album_id);
$dec_song_id    = base64_decode($song_id);
$dec_artist_id = $dec_main_artist;


$song_list_arr  =  \App\Models\Songs::GetRawDataAdmin("select song_title from tbl_songs where id='" . $dec_song_id . "'");
$song_title 	= stripslashes(html_entity_decode($song_list_arr['song_title']));

$song_list_arr  =  \App\Models\Songs::GetRawDataAdmin("select artist_name from tbl_artists where id='" . $dec_artist_id . "'");
$artist_name 	= stripslashes(html_entity_decode($song_list_arr['artist_name']));

$queryz = "select featured_artist,`tbl_artists`.artist_name from tbl_featured_artist_assocs inner join tbl_artists on `tbl_featured_artist_assocs`.`featured_artist`= tbl_artists.id where  main_artist = '$dec_main_artist' and album_id='$dec_album_id' and song_id='$dec_song_id'";
/* show association*/
$row_result  =  \App\Models\Songs::GetRawData($queryz);


$counter  = count($row_result);

if (isset($row_result)) {
    $selected_artists_value = "";
    foreach ($row_result as $arr_val) {
        $arr_val = (array)$arr_val;
        $artist_id = $arr_val['featured_artist'];
        $artist_name = $arr_val['artist_name'];
        $selected_artists_value .= "<option value='$artist_id' selected> $artist_name </option>";
    }
}


?>
<html>

<head>
	<title>ADD Featured Artist</title>

	<style>
		.pie {
			behavior: url(PIE.htc);
		}
	</style>

	@include("admin.common.header")
	<?php
    $suggestbox = 1;
    ?>
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
														<table id="Table1" border="0" cellpadding="0" cellspacing="0"
															width="100%">
															<tbody>
																<tr>
																	<td align="left">
																		<a
																			href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a>
																		&raquo;
																		<a
																			href="<?php echo SERVER_ADMIN_PATH; ?>song_list">Songs
																			Listing</a>&raquo;
																		<a
																			href="<?php echo SERVER_ADMIN_PATH; ?>artist_list_song?song_id=<?php echo $song_id; ?>"><?php echo stripslashes($song_title); ?></a>

																		&raquo; <a
																			href="artist_album_songs_list?artist_id=<?php echo $main_artist; ?>&album_id=<?php echo $album_id; ?>"><?php echo stripslashes($artist_name); ?></a>



																		&raquo; <a>Add/Edit Featured artist</a></a>

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
																		<form name="featured_song_form"
																			id="featured_song_form" action=""
																			method="post" enctype="multipart/form-data">
																			@csrf
																			<input type="hidden" name="song_id"
																				value="<?php echo $song_id; ?>">
																			<input type="hidden" name="main_artist"
																				value="<?php echo $main_artist; ?>">
																			<input type="hidden" name="album_id"
																				value="<?php echo $album_id; ?>">
																			<input type="hidden" name="page"
																				value="<?php echo $page; ?>">
																			<table class="Panel">
																				<tbody>


																					<tr>
																						<td width="12%" nowrap="nowrap"
																							class="SmallFieldLabel2">
																							Album:</td>
																						<td width="88%">

																							<?php

                                                                                            // limit applied on below query // 08 -08 - 2016 // ali

                                                                                            $artist_list = "Select artist_name, id from tbl_artists where artist_status = 1 and id<>$dec_artist_id order by artist_name asc limit 5000";

                                                                                            $artist_list_arr	=	\App\Models\Songs::GetRawData($artist_list);
                                                                                            //print_r($artist_list_arr);
                                                                                            //exit;
                                                                                            ?>
																							<select id="featured_artist"
																								style="width: 661px; height: 120px; overflow-y: scroll;"
																								multiple="multiple"
																								onkeyup=""
																								class="tokenize-sample"
																								name="featured_artist[]">
																								<?php
                                                                                                echo $selected_artists_value;

                                                                                                ?>
																							</select>
																							<script
																								type="text/javascript">
																								$('#featured_artist').tokenize({
																									datas: "loadartists",
																									searchMaxLength: 30,
																									searchMinLength: 3
																								});
																							</script>



																						</td>
																					</tr>



																					<tr>
																						<td class="SmallFieldLabel2">
																							&nbsp;</td>
																						<td>&nbsp;</td>
																					</tr>
																					<tr>
																						<td>&nbsp;</td>
																						<td>

																							<input name="add_cat"
																								id="add" value="Save"
																								class="FormButton"
																								type="submit"
																								onClick="validate_featured_atritst_assocs();" />

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
					@include("admin.common.footer")
				</td>
			</tr>
		</tbody>
	</table>
	<!-- End pagefooter -->
</body>

</html>