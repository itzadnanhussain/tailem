@include("admin.includes.top")
@include("admin.common.security")
<?php




// function get_data($url)
// {
// 	$ch = curl_init();
// 	$timeout = 5;
// 	curl_setopt($ch, CURLOPT_URL, $url);
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
// 	$data = curl_exec($ch);
// 	curl_close($ch);
// 	return $data;
// }


// function clean($string)
// {

// 	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
// 	return preg_replace('/[^A-Za-z0-9\-]/', '-', $string); // Removes special chars.

// }


// function artist_func($artistname)
// {
// 	ini_set('allow_url_fopen ', 'ON');
// 	$temp = file_get_contents("http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=" . trim($artistname) . "&api_key=979650ff4905a23bb01e312145761ebb");
// 	$XmlObj = simplexml_load_string($temp);
// 	$info = $XmlObj->artist->bio->summary;
// 	$image4 = $XmlObj->artist->image[3];
// 	$name = $XmlObj->artist->name;
// 	$url = $XmlObj->artist->url;


// 	$val = '<a href="http://www.last.fm/music/Justin+Bieber">Read more about Justin Bieber on Last.fm</a>';
// 	$val = $info;
// 	$val =  str_replace($url, "#", $val);
// 	$val =  str_replace("Read more about " . $name . " on Last.fm", "", $val);
// 	$val1 = '<a href="#"></a>.';
// 	$info1 =  str_replace($val1, "", $val);
// 	$val2 = '<a href="#"></a>';
// 	$info =   strip_tags(str_replace($val2, "", $info1));

// 	$artist_array['artist_array']['name'] 	= $name;
// 	$artist_array['artist_array']['image4'] = $image4;
// 	$artist_array['artist_array']['url'] 	= $url;
// 	$artist_array['artist_array']['info'] 	= $info;
// 	return $artist_array;
// }




if (isset($status) && !empty($status)) {
    $status		=	base64_decode($status);

    $status_id	=	base64_decode($status_id);

    if ($status == 1) {
        $sqlquery	=	"update tbl_artists set artist_status='$status' where id='$status_id'";
    } else {
        $sqlquery	=	"update tbl_artists set artist_status='$status' where id='$status_id'";
    }

    \App\Models\Songs::GetRawData($sqlquery);
    $update_ok_msg = base64_encode("Status has been changed Successfully!");
    $url = "view_artist?iTunesid=$status_id&msg=$update_ok_msg&case=1";
    echo '<script>window.location = "' . $url . '";</script>';
    exit;
}



if (isset($fetch_details) && !empty($fetch_details)) {
    //$status		=	base64_decode($status);

    //$iTunesid	=	base64_decode($iTunesid);

    if ($fetch_details == 1) {
        ini_set('allow_url_fopen ', 'ON');
        $artist_url = "http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=" . ($artist_name) . "&api_key=36cd9613641f2d9868a85377850aced5&format=json";

        $artistdata = get_data($artist_url);
        $artist_data = json_decode($artistdata);
        if (isset($artist_data) && !empty($artist_data)) {
            if (!$artist_data->error && $artist_data->artist) {
                $artist_pic = (array)$artist_data->artist->image[3];
                $ARTIST_SQL =	"UPDATE `tbl_artists` SET ";

                //if($artist_data->artist->url!=""){
                $artist_update_data['lastfm_url'] = remove_spl_char(htmlspecialchars($artist_data->artist->url));
                $lastfm_url = htmlspecialchars(remove_spl_char($artist_data->artist->url));
                $ARTIST_SQL .= " `lastfm_url`='" . $lastfm_url . "'";
                //}
                //if($artist_pic['#text']!=""){
                $artist_update_data['artist_img'] = $artist_pic['#text'];
                $ARTIST_SQL .= ",`artist_img`='" . $artist_update_data['artist_img'] . "'";
                //}
                //if($artist_data->artist->bio->content!=""){
                $artist_update_data['artist_description'] = $artist_data->artist->bio->content;
                $artist_description = htmlspecialchars(remove_spl_char($artist_data->artist->bio->content));

                $ARTIST_SQL .= ",`artist_description`='" . $artist_description . "'";
                //}

                //if($artist_data->artist->bio->summary!=""){
                $artist_update_data['summary'] = $artist_data->artist->bio->summary;
                $summary = htmlspecialchars(remove_spl_char($artist_update_data['summary']));
                $ARTIST_SQL .= ",`summary`='" . $summary . "'";


                $ARTIST_SQL .= " WHERE `tbl_artists`.`id` ='" . $iTunesid . "'";

                //echo $ARTIST_SQL;
                //$ARTIST_SQL = mysql_real_escape_string($ARTIST_SQL);
                $db->query($ARTIST_SQL);
                //echo $ARTIST_SQL;
                header("Location:view_artist?iTunesid=$iTunesid&msg=$update_ok_msg&case=1");
                exit;
            }
        } else {
            $content_not_found = base64_encode("No data found");
            $url = "view_artist?iTunesid=$iTunesid&msg=$content_not_found&case=3";
            echo '<script>window.location = "' . $url . '";</script>';

            exit;
        }
    }
    //$db->query($sqlquery);
    //header("Location:view_artist?iTunesid=$iTunesid&msg=$update_ok_msg&case=1");
    //exit;
}


?>

<html>

<head>
	<title>Artist Listing</title>
	<?php
    if ($top_artist_module == 'No') {
        $target	= SERVER_ADMIN_PATH; ?>
	<script language="javascript" type="text/javascript">
		window.location = '<?php echo $target; ?>';
	</script>
	<?php
        exit;
    }
    ?>
	@include("admin.common.header")
	<script language="javascript" type="text/javascript">
		// check boxess submit code
		function toggleChecked(status) {
			$(".check-all").each(function() {
				$(this).attr("checked", status);
			})
		}

		function multiple_action(frm_id) // for changing multiple status or multiple delete 
		{
			var conBox = confirm("Are you sure,you want to Perform this Action?");
			if (conBox) {
				document.forms[frm_id].submit();
			} else {
				return false;
			}
		}

		function show_detail(id) {
			$("#before_details_div_" + id).toggle();
			$("#after_details_div_" + id).toggle();
		}
	</script>
</head>

<body>

	<table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">

		<tr>
			<td style="background: #1F3C5C repeat-x;height:60px;" height="60">
				@include("admin.common.top_right_menu")
			</td>
		</tr>
		<tr>
			<td valign="top">
				<table border="0" width="100%">
					<tr>
						<td width="10">&nbsp;</td>
						<td>
							<!-- End page header -->
							<!-- End pageheader -->
							<!-- Start home -->
							<div class="BodyContainer">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td class="heading1">Artist Listing</td>
									</tr>
									<tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td><a
															href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a>
														&raquo; <a
															href="<?php echo SERVER_ADMIN_PATH; ?>artist_list">Artist
															Listing</a> &raquo; <a>Single Artist</a></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" class="Panel">
															<tbody>
																<?php if (isset($msg) && $msg != "") { ?>
																<tr>
																	<td colspan="7">
																		<table border="0" cellpadding="0"
																			cellspacing="0" class="Message">
																			<tbody>

																				<tr>
																					<td width="20"><?php if ($case == 1) { ?>
																						<img src="images/success_icon.png"
																							vspace="5" width="18"
																							height="18" hspace="10">
																						<?php } ?>
																						<?php if ($case == 2) { ?>
																						<img src="images/warning_icon.png"
																							vspace="5" width="18"
																							height="18" hspace="10">
																						<?php } ?>
																						<?php if ($case == 3) { ?>
																						<img src="images/error_icon.png"
																							vspace="5" width="18"
																							height="18" hspace="10">
																						<?php } ?>
																					</td>
																					<td width="100%"><?php echo base64_decode($msg); ?>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
																<?php } ?>

																<tr>
																	<td colspan="7" width="105" align="right"
																		valign="middle" id="addsymbol">
																		<?php
                                                                        if ($top_artist_module_add == 'Yes' || $_SESSION['reviewsite_cpadmin_type'] == 'admin') {
                                                                            ?>
																		<a
																			href="<?php echo SERVER_ADMIN_PATH; ?>addedit_artist"><img
																				src="images/add.png" border="0"
																				title="Add New"></a>
																		<?php
                                                                        }
                                                                        ?>

																	</td>
																</tr>

																<tr>
																	<td colspan="7">&nbsp;</td>
																</tr>
																<tr>
																	<td width="30" id="Heading_list">Sr #</td>
																	<td width="30" id="Heading_list">Artist iTunes id
																	</td>
																	<td width="200" id="Heading_list">Image</td>
																	<td width="200" id="Heading_list">Artist</td>
																	<td width="300" id="Heading_list">Summary</td>
																	<td width="70" id="Heading_list">Popular artist</td>
																	<td width="70" id="Heading_list">Status</td>


																	<td width="200" id="Heading_list"
																		class="righttd_border">&nbsp;&nbsp;&nbsp;<input
																			class="check-all" type="checkbox"
																			onClick="toggleChecked(this.checked);" />
																		Action</td>
																</tr>

																<form
																	action="<?php echo SERVER_ADMIN_PATH; ?>process/artist_actions"
																	method="post" id="faq_form">
																	@csrf
																	<?php
                                                                    //============================================================
                                                                    //PAGGING CODE STARTS HERE


                                                                    if ($_GET['iTunesid']) {
                                                                        $artistid =  $_GET['iTunesid'];
                                                                    } else {
                                                                        $artistid = 0;
                                                                    }

                                                                    $qry_count_mypro = "SELECT id FROM tbl_artists where 1=1 and id =  $artistid $orderby";
                                                                    $res_count_mypro = array();
                                                                    $res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
                                                                 
                                                                    if ($res_count_mypro) {
                                                                        $total_pages = count($res_count_mypro);
                                                                    } else {
                                                                        $total_pages = 0;
                                                                    }


                                                                    $targetpage = "artist_list"; //your file name  (the name of this file)


                                                                    $limit = 15;
                                                                    if ($page) {
                                                                        $start = ($page - 1) * $limit;
                                                                    } //first item to display on this page
                                                                    else {
                                                                        $start = 0;
                                                                    }					//if no page var is given, set start to 0
                                                                    //PAGGING CODE ENDS HERE
                                                                    //============================================================


                                                                    if (isset($page) && $page != "") {
                                                                        $sr_no = ($page * $limit) - $limit;
                                                                    } else {
                                                                        $sr_no = 0;
                                                                    }

                                                                    $c = 1;

                                                                    //$artistid = $_GET['id'];
                                                                    $artist_list = "select * from tbl_artists where 1=1 and tbl_artists.id = $artistid $orderby 
										LIMIT $start, $limit";

                                                                    $artist_list_arr	=	 \App\Models\Songs::GetRawData($artist_list);

                                                                    if (isset($artist_list_arr)) {
                                                                        foreach ($artist_list_arr as $val) {
                                                                            $val = (array)$val;
                                                                            $id	  = $val['id'];
                                                                            $artist_name = stripslashes(html_entity_decode($val['artist_name']));
                                                                            $artist_img   = stripslashes(html_entity_decode($val['artist_img']));
                                                                            $artist_description   = stripslashes(html_entity_decode($val['artist_description']));
                                                                            $status   = $val['artist_status'];
                                                                            $popular_artist   = $val['popular_artist'];
                                                                            $posted_date   = $val['posted_date'];
                                                                            $artist_name = wordwrap($artist_name, 100, " ", true);
                                                                            $artist_seo = $val['artist_seo'];
                                                                            $lastfm_url = $val['lastfm_url'];
                                                                            $itunes_url = $val['itunes_url'];

                                                                            if ($c % 2 == 0) {
                                                                                $bgcolor = "#FEFEE4";
                                                                            } else {
                                                                                $bgcolor = "#FFFFFF";
                                                                            }

                                                                            $c++;
                                                                            $sr_no++; ?>

																	<tr bgcolor="<?php echo $bgcolor; ?>"
																		onMouseOver="changebackcolor_hover('row<?php echo $id; ?>')"
																		onMouseOut="changebackcolor_blur('row<?php echo $id; ?>')"
																		id="row<?php echo $id; ?>">
																		<td nowrap="nowrap" class="SmallFieldLabel"
																			width="30"><?php echo "1"; ?>
																		</td>
																		<td nowrap="nowrap" class="SmallFieldLabel"
																			width="30"><?php echo $id; ?>
																		</td>
																		<td nowrap="nowrap" class="SmallFieldLabel"
																			width="200">
																			<?php



                                                                                    if ($artist_img != "") {
                                                                                        $img_artist = album_img_api($artist_img);
                                                                                        if ($img_artist != '') { ?>
																			<img src="<?php echo $img_artist; ?>"
																				border="0" width="50" height="50" />
																			<?php } else {
                                                                                            //$cacheThumbnail = "/assets/phpthumb/phpThumb?src=".$artist_img."&w=50&h=50&zc=1";?>
																			<!--<img src="<?php echo $cacheThumbnail; ?>"
																			border="0" width="50" height="50" />-->


																			<img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo 'small_thumb_' . $artist_img; ?>"
																				border="0" width="50" height="50" />
																			<?php
                                                                                        }
                                                                                    } else {
                                                                                        ?>
																			<img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image.png"
																				border="0" width="50" height="50" />
																			<?php
                                                                                    } ?>



																		</td>

																		<td nowrap="nowrap" class="SmallFieldLabel"
																			width="200">
																			<a
																				href="<?php echo SERVER_ADMIN_PATH . "view_artist?iTunesid=$id"; ?>"><?php echo $artist_name; ?></a>
																			&raquo; </br></br>
																			<a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/preview-artist"; ?>"
																				target="_blank">View on Frontend</a>


																			<?php if ($itunes_url) { ?>
																			</br></br>
																			<a href="<?php echo $itunes_url; ?>"
																				target="_blank">iTunes Url</a>
																			<?php } ?>


																			<?php if ($lastfm_url) { ?>
																			</br></br>
																			<a href="<?php echo $lastfm_url; ?>"
																				target="_blank">Lasfm Url</a>

																			<?php } ?>


																		</td>

																		<td nowrap="nowrap" class="SmallFieldLabel"
																			width="300">
																			<?php

                                                                                    if ($artist_description) {
                                                                                        echo($artist_description);
                                                                                        echo '</br></br>';
                                                                                    } ?>

																			<a
																				href="<?php echo SERVER_ADMIN_PATH . "view_artist?iTunesid=$id&artist_name=$artist_name&fetch_details=1"; ?>">Fetch
																				details</a>
																		</td>
																		<td nowrap="nowrap" class="SmallFieldLabel"
																			width="70">
																			<?php
                                                                                    if ($popular_artist == 0) {
                                                                                        echo "No";
                                                                                    }
                                                                            if ($popular_artist == 1) {
                                                                                echo "Yes";
                                                                            } ?>
																		</td>

																		<td nowrap="nowrap" class="SmallFieldLabel"
																			width="70">
																			<?php
                                                                                    if ($status == 0) {
                                                                                        echo "Blocked";
                                                                                    }
                                                                            if ($status == 1) {
                                                                                echo "Active";
                                                                            } ?>
																			&nbsp;&nbsp;&nbsp;
																			<?php
                                                                                    if ($status == 0) {
                                                                                        echo '<a href="view_artist?status=' . base64_encode(1) . '&status_id=' . base64_encode($id) . '"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>';
                                                                                    }
                                                                            if ($status == 1) {
                                                                                echo '<a href="view_artist?status=' . base64_encode(0) . '&status_id=' . base64_encode($id) . '"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>';
                                                                            } ?>
																		</td>


																		<td nowrap="nowrap"
																			class="SmallFieldLabel righttd_border"
																			width="70">
																			&nbsp;&nbsp; <input type="checkbox"
																				class="check-all" name="ids[]"
																				id="ids[]"
																				value="<?php echo base64_encode($id); ?>"
																				style="margin-top:-5px;" />
																			&nbsp;&nbsp;
																			<?php
                                                                                    if ($top_artist_module_add == 'Yes' || $_SESSION['reviewsite_cpadmin_type'] == 'admin') {
                                                                                        ?>
																			<a
																				href="addedit_artist?edit_id=<?php echo base64_encode($id); ?>"><img
																					src="images/edit.gif" border="0"
																					title="Edit" class="Action"></a>
																			<?php
                                                                                    } ?>

																			<?php
                                                                                    if ($top_album_module == 'Yes' || $_SESSION['reviewsite_cpadmin_type'] == 'admin') {
                                                                                        ?>
																			<a
																				href="artist_album_list?artist_id=<?php echo base64_encode($id); ?>">Album</a>
																			<?php
                                                                                    } ?>
																			&nbsp;
																			<a
																				href="artist_featured_songs_list?artist_id=<?php echo base64_encode($id); ?>"><img
																					src="images/featured_in.jpg"
																					border="0"
																					title="Artist Featured In"
																					class="Action"></a>

																			<?php
                                                                                    if ($top_artist_module_delete == 'Yes') {
                                                                                        ?>
																			&nbsp; &nbsp;
																			<a href="javascript:;"
																				onClick="delete_artist('<?php echo $id; ?>')"><img
																					src="images/delet.gif" border="0"
																					title="Delete Artist"
																					class="Action"></a>
																			<?php
                                                                                    } ?>
																		</td>
																	</tr>
																	<?php
                                                                        }
                                                                    } else {
                                                                        ?>

																	<tr>
																		<td colspan="6" align="center" nowrap="nowrap"
																			class="SmallFieldLabel righttd_border"
																			style="font-weight:bold; color:#FF0000;"> NO
																			RECORD FOUND!</td>
																	</tr>
																	<?php
                                                                    }
                                                                    ?>
																	<?php
                                                                    if ($total_pages > 0) {
                                                                        ?>
																	<!-- <tr>
																			<td colspan="12" nowrap="nowrap" class="SmallFieldLabel righttd_border">
																				<span style="float:right; padding-bottom:10px; margin-right:8px;">
																					<select name="dropdown" onChange="multiple_action('faq_form');">
																						<option value="">Choose an action...</option>
																						<option value="Active">Active</option>
																						<option value="Inactive">Inactive</option>
																						<?php
                                                                                        if ($top_artist_module_delete == 'Yes') {
                                                                                            ?>
																	<option value="Delete">Delete</option>
																	<?php
                                                                                        } ?>
																	<option value="popular_artist">Popular Artist
																	</option>
																	<option value="not_popular_artist">Not Popular
																		Artist</option>
																	</select>
																	</span>
													</td>
												</tr> -->
												<?php
                                                                    }
                                                                    ?>
												<tr>
													<td colspan="6" align="center" valign="middle">
														@include("admin.common.paging-playlist")
													</td>
												</tr>
												</form>

											</table>

										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
									</tr>
								</table>
						</td>
					</tr>
				</table>
				</div>
				<!-- End home -->
				<!-- Start pagefooter -->
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