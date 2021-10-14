@include("admin.includes.top")
@include("admin.common.security")
<?php
error_reporting(0);

/*================== Search Filter Start Here=================*/
$dec_id  = base64_decode($song_id);
$song_list	=	"select song_title from tbl_songs where 1=1 AND id = $dec_id";

$song_list_arr	=	\App\Models\Songs::GetRawDataAdmin($song_list);


if (isset($_POST['filter'])) {
	$sess_where = "";


	if ($_REQUEST['song_title'] != "") {
		$sess_where .= " and song_title  like \"%" . trim($_REQUEST['song_title']) . "%\" ";
		$_SESSION['song_title_sess'] = trim($_REQUEST['song_title']);
	} else {
		unset($_SESSION['song_title_sess']);
	}

	if ($_REQUEST['song_status'] != "") {
		$sess_where .= " and song_status = '" . $_REQUEST['song_status'] . "'";
		$_SESSION['song_status'] = $_REQUEST['song_status'];
	} else {
		unset($_SESSION['song_status']);
	}
	$_SESSION['sess_faq'] = $sess_where;
}
// $session_where = $_SESSION['sess_faq'];
if (isset($_POST['Reset'])) {
	unset($_SESSION['song_title_sess']);
	$_SESSION['song_title_sess'] = "";

	unset($_SESSION['song_status']);
	$_SESSION['song_status'] = "";

	unset($_SESSION['sess_faq']);
	$_SESSION['sess_faq'] = "";

	// header("Location:song_list");
	$url = "song_list";
	echo '<script>window.location = "' . $url . '";</script>';
	exit;
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch ($sortby) {
	case "artist_desc":
		$orderby	= " ORDER BY song_title desc";
		break;

	case "song_title_asc":
		$orderby	= " ORDER BY song_title asc";
		break;

	case "statusdesc":
		$orderby	= " ORDER BY song_status desc";
		break;

	case "statusasc":
		$orderby	= " ORDER BY song_status asc";
		break;

	default:
		$orderby = "ORDER BY sa.id desc";
		break;
}


if (isset($status) && !empty($status)) {
	$status		=	base64_decode($status);

	$status_id	=	base64_decode($status_id);

	if ($status == 1) {
		$sqlquery	=	"update tbl_songs set song_status='$status' where id='$status_id'";
	} else {
		$sqlquery	=	"update tbl_songs set song_status='$status' where id='$status_id'";
	}



	\App\Models\Songs::GetRawData($sqlquery);



	$update_ok_msg = base64_encode("Status has been changed Successfully!");
	$url = "song_list?msg=$update_ok_msg&case=1";
	echo '<script>window.location = "' . $url . '";</script>';
	exit;
}
?>
<html>

<head>
	<title>Artist against Song <?php echo stripslashes($song_list_arr['song_title']); ?> Listing</title>
	<?php
	if ($top_artist_module == 'No') {
		$target	= SERVER_ADMIN_PATH;

	?>
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
			<td style="background:#1F3C5C; background-repeat:repeat-x; height:60px;" height="60">
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
										<td class="heading1"><?php echo stripslashes($song_list_arr['song_title']); ?></td>
									</tr>
									<tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td><a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a> &raquo; <a href="<?php echo SERVER_ADMIN_PATH; ?>song_list">Songs Listing</a>&raquo; <a><?php echo stripslashes($song_list_arr['song_title']); ?></a></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" class="Panel">
															<tbody>
																<?php if (isset($msg) && $msg != "") { ?>
																	<tr>
																		<td colspan="6">
																			<table border="0" cellpadding="0" cellspacing="0" class="Message">
																				<tbody>

																					<tr>
																						<td width="20"><?php if ($case == 1) { ?>
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
																	<td colspan="7">&nbsp;</td>
																</tr>
																<tr>
																	<td width="30" id="Heading_list">Sr #</td>
																	<td width="200" id="Heading_list">Artist</td>
																	<td width="200" id="Heading_list">Artist Name</td>

																	<td width="106" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
																</tr>

																<form action="<?php echo SERVER_ADMIN_PATH; ?>process/artist_song_actions" method="post" id="faq_form">
																@csrf	
																<input type="hidden" name="song_id" value="<?php echo $dec_id; ?>">
																	<?php

																	//============================================================
																	//PAGGING CODE STARTS HERE




																	$qry_count_mypro = "SELECT a.id FROM tbl_songs s, tbl_songs_artist sa, tbl_artists a where 1=1 AND a.id = sa.artist_id AND sa.song_id = s.id AND sa.song_id = '$dec_id'
											$session_where  group BY a.id  $orderby";

																	$res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
																	if ($res_count_mypro) {
																		$total_pages = count($res_count_mypro);
																	} else {
																		$total_pages = 0;
																	}


																	$targetpage = "song_list"; //your file name  (the name of this file)


																	$limit = 15; 					//how many items to show per page
																 
																	if ($page)
																		$start = ($page - 1) * $limit; //first item to display on this page
																	else
																		$start = 0;					//if no page var is given, set start to 0
																	//PAGGING CODE ENDS HERE	
																	//============================================================

																	if (isset($page) && $page != "") {
																		$sr_no = ($page * $limit) - $limit;
																	} else {
																		$sr_no = 0;
																	}

																	$c = 1;

																	$song_list = "SELECT sa.id,a.artist_img,a.artist_name, sa.song_id, sa.artist_id FROM tbl_songs s, tbl_songs_artist sa, tbl_artists a where 1=1 AND a.id = sa.artist_id AND sa.song_id = s.id AND sa.song_id = '$dec_id' $session_where  GROUP BY a.id  $orderby 
										LIMIT $start, $limit";

																	$song_list_arr	=	\App\Models\Songs::GetRawData($song_list);

																	if (isset($song_list_arr) &&  !empty($song_list_arr)) {
																		foreach ($song_list_arr as $val) {
																			$val = (array)$val;
																			$id	  = $val['id'];
																			$song_id	  = $val['song_id'];
																			$artist_name = stripslashes(html_entity_decode($val['artist_name']));
																			$artist_id   = stripslashes(html_entity_decode($val['artist_id']));
																			$artist_img   = stripslashes(html_entity_decode($val['artist_img']));

																			if ($c % 2 == 0) {
																				$bgcolor = "#FEFEE4";
																			} else {
																				$bgcolor = "#FFFFFF";
																			}

																			$c++;
																			$sr_no++;
																	?>

																			<tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $id; ?>')" onMouseOut="changebackcolor_blur('row<?php echo $id; ?>')" id="row<?php echo $id; ?>">
																				<td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no; ?></td>

																				<td nowrap="nowrap" class="SmallFieldLabel" width="200">
																					<?php
																					if ($artist_img != "") {
																						$img_artist = album_img_api($artist_img);
																						if ($img_artist != '') { ?>
																							<img src="<?php echo $img_artist; ?>" border="0" width="50" height="50" />
																						<?php } else { ?>
																							<img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo 'small_thumb_' . $artist_img; ?>" border="0" width="50" height="50" />
																						<?php }
																					} else {
																						?>
																						<img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image.png" border="0" width="50" height="50" />
																					<?php
																					} ?>
																				</td>

																				<td nowrap="nowrap" class="SmallFieldLabel" width="200">
																					<?php echo $artist_name; ?>
																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70">
																					&nbsp;&nbsp; <input type="checkbox" class="check-all" name="ids[]" id="ids[]" value="<?php echo base64_encode($id); ?>" style="margin-top:-5px;" />
																					<?php
																					if ($top_artist_module_delete == 'Yes') {
																					?>
																						&nbsp; &nbsp;
																						<a href="javascript:;" onClick="delete_artist_song('<?php echo $id; ?>','<?php echo $song_id; ?>')"><img src="images/delet.gif" border="0" title="Delete" class="Action"></a>
																					<?php
																					}

																					if ($top_album_module_add == 'Yes') {
																					?>
																						&nbsp; &nbsp;
																						<a href="<?php echo SERVER_ADMIN_PATH; ?>artist_list_album_song?song_id=<?php echo base64_encode($song_id); ?>&artist_id=<?php echo base64_encode($artist_id); ?>">Album</a>
																					<?php
																					}
																					?>
																				</td>
																			</tr>
																		<?php
																		}
																	} else {
																		?>

																		<tr>
																			<td colspan="6" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
																		</tr>
																	<?php
																	}
																	?>
																	<?php
																	if ($total_pages > 0) {
																	?>
																		<tr>
																			<td colspan="6" nowrap="nowrap" class="SmallFieldLabel righttd_border">
																				<span style="float:right; padding-bottom:10px; margin-right:8px;">
																					<select name="dropdown" onChange="multiple_action('faq_form');">
																						<option value="">Choose an action...</option>
																						<option value="Delete">Delete</option>
																					</select>
																				</span>
																			</td>
																		</tr>
																	<?php
																	}
																	?>
																	<tr>
																		<td colspan="6" align="center" valign="middle">
																			 @include("admin.common.paging-playlist")</td>
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
			<td height="20"> @include("admin.common.footer") </td>
		</tr>
		</tbody>
	</table>
	<!-- End pagefooter -->
</body>

</html>