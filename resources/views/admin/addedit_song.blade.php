@include("admin.includes.top")
@include("admin.common.security")
<?php
//include("../db");
error_reporting(0);

session()->get('backtopage', $_SERVER['HTTP_REFERER']);
if (isset($_REQUEST['del_id'])) {

	$select_img = "select picture from tbl_songs where id='" . base64_decode($_REQUEST['del_id']) . "'";
	$result = \App\Models\Songs::GetRawDataAdmin($select_img);
	$old_image  = $result['picture'];



	if ($old_image != "") {
		$path			= 'site_upload/song_images/';
		$imgfile = $path . $old_image;
		$thumbfile = $path . 'thumb_' . $old_image;
		$thumbfile_small = $path . 'small_thumb_' . $old_image;
		unlink($thumbfile_small);
		unlink($imgfile);
		unlink($thumbfile);

		$qry = "update tbl_songs set picture = '' where id='" . base64_decode($_REQUEST['del_id']) . "'";
		\App\Models\Songs::GetRawData($qry);
	}
	$url = 'addedit_song?edit_id=' . $_REQUEST['del_id'];
	echo '<script>window.location = "' . $url .  '"</script>';
	die;
}

if (isset($edit_id)) {
	$edit_id = base64_decode($edit_id);

	$qry  =  "select * from tbl_songs where id='" . $edit_id . "'";
	$row = \App\Models\Songs::GetRawDataAdmin($qry);
	$song_title 	= stripslashes(html_entity_decode($row['song_title']));
	$song_seo 	= stripslashes(html_entity_decode($row['song_seo']));
	$itunes_url	= stripslashes($row['itunes_url']);
	$amazon_url	= stripslashes($row['amazon_url']);
	$google_url	= stripslashes($row['google_url']);

	$lastfm_url	= stripslashes($row['lastfm_url']);
	$years 	= stripslashes(html_entity_decode($row['song_year']));

	$picture  = $row['picture'];
	$key_words_value = stripslashes(html_entity_decode($row['keywords']));



	$ad_code	= stripslashes($row['ad_code']);
	$video_code	= stripslashes($row['video_code']);
	$ranking_order	= stripslashes($row['ranking_order']);

	$description     = stripslashes(html_entity_decode($row['description']));





	$qry  = "select `tbl_songs_artist`.artist_id,`tbl_artists`.artist_name from tbl_songs_artist inner join tbl_artists on `tbl_songs_artist`.`artist_id`= tbl_artists.id where song_id='" . $edit_id . "'";
	$row_result = \App\Models\Songs::GetRawData($qry);

	if ($row_result) {
		$counter  = count($row_result);
	} else {
		$counter = 0;
	}

	if (isset($row_result) && !empty($row_result)) {

		$selected_artists_value = "";
		foreach ($row_result as $arr_val) {
			$arr_val = (array)$arr_val;
			$artist_id = $arr_val['artist_id'];
			$artist_name = $arr_val['artist_name'];
			$selected_artists_value .= "<option value='$artist_id' selected> $artist_name </option>";
		}
		$artist_name = $row_result[0]->artist_name;
	}
	if ($description == "") {
		/****************** LASTFM CALL********/
		ini_set('allow_url_fopen ', 'ON');

		$artistname = urlencode($artist_name);

		$track = urlencode($song_title);

		$temp = file_get_contents("http://ws.audioscrobbler.com/2.0/?method=track.getInfo&artist=" . $artistname . "&track=" . $track . "&api_key=979650ff4905a23bb01e312145761ebb");

		$XmlObj = simplexml_load_string($temp);


		//	$song_url_fm = $XmlObj->track->url;

		$description1 =	$description = $XmlObj->track->wiki->summary;

		//	$song_image_fm = $XmlObj->track->album->image[2];
		/****************** LASTFM CALL********/
		if ($description1 == "") {

			$description1 = 'N/A';
		}
		$description1 =   stripslashes($description1);
		$ARTIST_SQL =	"UPDATE `tbl_songs` SET `description` = '" . $description1 . "' WHERE  `tbl_songs`.`id` ='" . $edit_id . "'";
		\App\Models\Songs::GetRawData($ARTIST_SQL);
	}


	$addedit = 'Edit';
} else {
	$addedit  = 'Add';
	$artist_id = $_REQUEST['artist_id'];
	$album_id  = $_REQUEST['album_id'];
}
?>
<html>

<head>
	<title><?php echo $addedit; ?> Song</title>
	<?php
	if ($top_song_module_add == 'No') {
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

		.div_width {
			width: 100%;
		}

		.div_width a {
			font-weight: bold;
			padding: 6px;
			text-decoration: none;
		}

		.div_width a:hover {
			font-weight: bold;
			padding: 6px;
			text-decoration: underline;
			color: #0000FF;
		}
	</style>
	<script type="text/javascript">
		function delete_song_image(id) // for changing multiple status or multiple delete 
		{
			var conBox = confirm("Are you sure,you want to delete this image?");
			if (conBox) {
				window.location.href = "<?php echo SERVER_ADMIN_PATH; ?>addedit_song?del_id=" + id;
			}
		}
	</script>
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
													<td class="heading1"><?php echo $addedit; ?> Song</td>
												</tr>
												<tr>
													<td class="body">
														<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
															<tbody>
																<tr>
																	<td align="left">
																		<a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a>
																		&raquo;<a href="<?php echo SERVER_ADMIN_PATH; ?>song_list">Song Listing</a>
																		<?php
																		if ($edit_id != '') {
																		?>
																			&raquo; <a>Edit Song</a>
																		<?php
																		}
																		?>
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
																			@csrf
																			<table class="Panel">
																				<tbody>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Song Title:</td>
																						<td width="88%">
																							<input type="text" name="song_title" id="song_title" value="<?php echo $song_title; ?>" class="fields"> <span class="Required" /> *</span>
																						</td>
																					</tr>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Keywords(It sould be comma seprated):</td>
																						<td width="88%">
																							<input type="text" name="key_words_value" id="key_words_value" value="<?php echo $key_words_value; ?>" class="fields" required> <span class="Required" /> *</span>
																						</td>
																					</tr>

																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Summary:</td>
																						<td width="88%">
																							<textarea name="description" id="description" rows="6" cols="80"><?php echo $description; ?></textarea>
																						</td>
																					</tr>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Song SEO:</td>
																						<td width="88%">
																							<input type="text" name="song_seo" id="song_seo" value="<?php echo $song_seo; ?>" class="fields" <?php if ($edit_id != "") { ?> required <?php } ?>>
																							<span class="Required" /> *</span>
																						</td>

																					</tr>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Buy Itunes URL:</td>
																						<td width="88%">
																							<input type="text" name="itunes_url" id="itunes_url" value="<?php echo $itunes_url; ?>" class="fields">
																						</td>
																					</tr>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Buy Amazon URL:</td>
																						<td width="88%">
																							<input type="text" name="amazon_url" id="amazon_url" value="<?php echo $amazon_url; ?>" class="fields">
																						</td>
																					</tr>

																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Lastfm URL:</td>
																						<td width="88%">
																							<input type="text" name="lastfm_url" id="lastfm_url" value="<?php echo $lastfm_url; ?>" class="fields">
																						</td>
																					</tr>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Year:</td>
																						<td width="88%">
																							<select name="years">
																								<option value="">Year</option>
																								<?php for ($k = date("Y") + 5; $k >= 1900; $k--) {
																									$sel = '';
																									if ($k == $years) {
																										$sel = "selected='selected'";
																									} ?>
																									<option value="<?php echo $k; ?>" <?php echo $sel; ?>><?php echo $k; ?></option>
																								<?php } ?>
																							</select>
																						</td>
																					</tr>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Image:</td>
																						<td width="88%">
																							<input type="file" name="image_name" id="image_name" /></br>
																							<span class="Required" /><strong>Profile picture is optional. JPG,GIF or PNG format</strong></span>

																							<?php
																							$pos = strpos($picture, 'http');
																							if ($pos === false && $picture != "") {
																								$picture = SERVER_ROOTPATH . "/site_upload/song_images/" . $picture;
																							}
																							?>
																							<?php if ($picture != "") { ?> </br></br>


																								<img src="<?php echo $picture; ?>" border="0" width="200px" />&nbsp;
																								<a href="javascript:;" onClick="delete_song_image('<?php echo $_REQUEST['edit_id']; ?>')"><img src="images/delet.gif" border="0" title="Delete Artist" class="Action"></a>
																							<?php } ?>
																						</td>
																					</tr>
																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Artists:</td>
																						<td width="88%">

																							<select id="artist" style="width: 761px; height: 120px; overflow-y: scroll;" multiple="multiple" onkeyup="" class="tokenize-sample" name="artist[]">
																								<?php
																								echo $selected_artists_value;

																								?>
																							</select>

																							<div id="jump_div"></div>
																							<!-- <select name="artist[]" multiple style="width:400px; min-height:120px;">-->
																							<?php
																							/* if(isset($artist_list_arr))
										{
											foreach($artist_list_arr as $val)
											{
												$id	  = $val['id'];	
												$artist_name = stripslashes(html_entity_decode($val['artist_name']));
												if(in_array($id,$sep_arr))
												{
													$selected = "selected";
												}
												else
												{
													$selected = "";
												}
												?>
                                                <option value="<?php echo $id;?>" <?php echo $selected;?>><?php echo $artist_name.$selected;?></option>
                                                <?php
											}
										}*/
																							?>

																							<!-- </select>        -->

																						</td>
																					</tr>





																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Embed Code: Video</td>
																						<td width="88%">
																							<textarea rows="6" cols="80" id="video_code" name="video_code"><?php echo $video_code; ?></textarea>
																							</br>
																							<span class="Required" />
																							<strong>Suitable Video Dimensions width="340", height="297"</strong>
																							</span>
																						</td>

																					</tr>

																					<tr>
																						<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Song Ranking :</td>
																						<td width="88%">
																							<input type="number" class="fields" id="song_ranking" name="song_ranking" value="<?php echo $ranking_order; ?>">
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
																								<input name="save" id="save" value="Update" class="FormButton" type="submit" onClick="validate_song();" />
																							<?php
																							} else {
																							?>
																								<input type="hidden" name="artist_id" id="artist_id" value="<?php echo $artist_id; ?>">
																								<input type="hidden" name="album_id" id="album_id" value="<?php echo $album_id; ?>">
																								<input name="add_cat" id="add" value="Add" class="FormButton" type="submit" onClick="validate_song();" />
																							<?php } ?>
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