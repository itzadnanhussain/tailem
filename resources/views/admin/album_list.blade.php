@include("admin.includes.top")
@include("admin.common.security")
<?php

///my snips
error_reporting(0);



//---------- Ordering ----------//
switch ($sortby) {
	case "artist_desc":
		$orderby	= " ORDER BY artist_name desc";
		break;

	case "artist_name_asc":
		$orderby	= " ORDER BY artist_name asc";
		break;

	case "statusdesc":
		$orderby	= " ORDER BY artist_status desc";
		break;

	case "statusasc":
		$orderby	= " ORDER BY artist_status asc";
		break;

	default:
		$orderby = "ORDER BY b.id ASC ";
		break;
}


/*================== Search Filter Start Here=================*/


//PAGGING CODE STARTS HERE
if ($_SESSION['All_total_pages'] == "") {
	$qry_count_mypro = "SELECT b.album_artist_id FROM tbl_artist_album b, tbl_artists a where b.album_artist_id = a.id";
	 
	$res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
	if ($res_count_mypro) {
		$total_pages = count($res_count_mypro);
	} else {
		$total_pages = 0;
	}

	$targetpage = "album_list"; //your file name  (the name of this file)

	$_SESSION['All_total_pages'] = $total_pages;
} else {
	$total_pages = $_SESSION['All_total_pages'];
}





if (isset($_POST['filter'])) {
	$sess_where = "";


	if ($_REQUEST['album_itunesid'] != "") {
		$sess_where .= " and b.id  = " . $_REQUEST['album_itunesid'] . "";
		$_SESSION['album_itunesid_sess'] = $_REQUEST['album_itunesid'];
	} else {
		unset($_SESSION['album_itunesid_sess']);
	}


	if ($_REQUEST['album_title'] != "") {
		//$sess_where .= " and b.album_title  like \"%".trim($_REQUEST['album_title'])."%\" ";
		$sess_where .= " and  MATCH (b.album_title) AGAINST ('*" . trim($_REQUEST['album_title']) . "*' IN BOOLEAN MODE) ";
		$_SESSION['album_title_sess'] = trim($_REQUEST['album_title']);
	} else {
		unset($_SESSION['album_title_sess']);
	}

	if ($_REQUEST['artist_title'] != "") {
		// $sess_where .= " and a.artist_name  like \"%".trim($_REQUEST['artist_title'])."%\" ";
		$sess_where .= " and  MATCH (a.artist_name) AGAINST ('*" . trim($_REQUEST['artist_title']) . "*' IN BOOLEAN MODE) ";
		$_SESSION['artist_title_sess'] = trim($_REQUEST['artist_title']);
	} else {
		unset($_SESSION['artist_title_sess']);
	}

	if ($_REQUEST['album_status'] != "") {
		$sess_where .= " and b.album_status = '" . $_REQUEST['album_status'] . "'";
		$_SESSION['album_status'] = $_REQUEST['album_status'];
	} else {
		unset($_SESSION['album_status']);
	}
	$_SESSION['sess_album'] = $sess_where;


	$session_where = $_SESSION['sess_album'];

	$limit = 15; 					//how many items to show per page
	$start = 0;
	$sr_no = 0;
	//PAGGING CODE STARTS HERE





	$qry_count_mypro = "SELECT b.album_artist_id FROM tbl_artist_album b, tbl_artists a where 1=1 AND b.album_artist_id = a.id $session_where $orderby ";
	$res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
	if ($res_count_mypro) {
		$total_pages = count($res_count_mypro);
	} else {
		$total_pages = 0;
	}

	$targetpage = "album_list"; //your file name  (the name of this file)

	$_SESSION['total_pages'] = $total_pages;





	$c = 1;
	$artist_list = "select b.id, b.id, b.album_title, b.album_picture, b.popular_album, a.artist_name, b.album_status, b.album_artist_id FROM tbl_artist_album b, tbl_artists a where 1=1 AND b.album_artist_id = a.id $session_where $orderby LIMIT $start, $limit";
} elseif (isset($_GET['page'])) {

	$limit = 15; 					//how many items to show per page
	$page = $_GET['page'];
	if ($page)
		$start = ($page - 1) * $limit; //first item to display on this page
	else
		$start = 0;


	if (isset($page) && $page != "") {
		$sr_no = ($page * $limit) - $limit;
	} else {
		$sr_no = 0;
	}





	if ($_SESSION['album_title_sess'] != "") {
		//$sess_where .= " and b.album_title  like \"%".trim($_REQUEST['album_title'])."%\" ";
		$sess_album_title_query .= " and  MATCH (b.album_title) AGAINST ('*" . trim($_SESSION['album_title_sess']) . "*' IN BOOLEAN MODE) ";
		// $_SESSION['album_title_sess'] = trim($_REQUEST['album_title']);
	}


	if ($_SESSION['artist_title_sess'] != "") {
		// $sess_where .= " and a.artist_name  like \"%".trim($_REQUEST['artist_title'])."%\" ";
		$sess_artist_title_query .= " and  MATCH (a.artist_name) AGAINST ('*" . trim($_SESSION['artist_title_sess']) . "*' IN BOOLEAN MODE) ";
		// $_SESSION['artist_title_sess'] = trim($_REQUEST['artist_title']);
	}


	if ($_SESSION['album_status'] != "") {
		$sess_album_status_query .= " and b.album_status = '" . $_SESSION['album_status'] . "'";
		//$_SESSION['album_status'] = $_REQUEST['album_status'];
	}



	$session_where =  $sess_album_title_query . $sess_artist_title_query . $sess_album_status_query;
	echo "</br>";


	if ($_SESSION['total_pages'] == "") {
		//PAGGING CODE STARTS HERE
		$qry_count_mypro = "SELECT b.album_artist_id  FROM tbl_artist_album b, tbl_artists a where 1=1 AND b.album_artist_id = a.id $session_where";
		$res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
		if ($res_count_mypro) {
			$total_pages = count($res_count_mypro);
		} else {
			$total_pages = 0;
		}

		$targetpage = "album_list"; //your file name  (the name of this file)
		$_SESSION['total_pages'] = $total_pages;
	} else {
		$targetpage = "album_list"; //your file name  (the name of this file)
		$total_pages = $_SESSION['total_pages'];
	}



	if ($_SESSION['album_title_sess'] != "" || $_SESSION['artist_title_sess'] != "" || $_SESSION['album_status'] != "") {
		$session_where .= "  $orderby limit $start, $limit ";
	} else {

		$session_where .= " and b.id > $start $orderby limit $limit ";
	}

	$_SESSION['sess_album'] = $session_where;
	//echo "ram2";
	$session_where = $_SESSION['sess_album'];


	$c = 1;
	$artist_list = "select b.id, b.id, b.album_title, b.album_picture, b.popular_album, a.artist_name, b.album_status, b.album_artist_id FROM tbl_artist_album b, tbl_artists a where 1=1 AND b.album_artist_id = a.id $session_where";
} else {

	$limit = 15; 					//how many items to show per page
	$start = 0;
	$sr_no = 0;

	$session_where = '';



	$total_pages = $_SESSION['All_total_pages'];

	$c = 1;
	$artist_list = "select b.id, b.id, b.album_title, b.album_picture, b.popular_album, a.artist_name, b.album_status, b.album_artist_id FROM tbl_artist_album b, tbl_artists a where b.album_artist_id = a.id LIMIT $start, $limit";
}

 


if (isset($_POST['Reset'])) {
	unset($_SESSION['album_itunesid_sess']);
	$_SESSION['album_itunesid_sess'] = "";

	unset($_SESSION['album_title_sess']);
	$_SESSION['album_title_sess'] = "";

	unset($_SESSION['album_status']);
	$_SESSION['album_status'] = "";

	unset($_SESSION['artist_title_sess']);
	$_SESSION['artist_title_sess'] = "";

	unset($_SESSION['sess_album']);
	$_SESSION['sess_album'] = "";


	unset($_SESSION['total_pages']);
	$_SESSION['total_pages'] = "";
	
	$url = "album_list";
	echo '<script>window.location = "' . $url . '";</script>';
	exit;

	header("Location:album_list");
}

if (isset($status) && !empty($status)) {
	$status		=	base64_decode($status);

	$status_id	=	base64_decode($status_id);

	if ($status == 1) {
		$sqlquery	=	"update tbl_artist_album set album_status='$status' where id='$status_id'";
	} else {
		$sqlquery	=	"update tbl_artist_album set album_status='$status' where id='$status_id'";
	}

	\App\Models\Songs::GetRawData($sqlquery);
	$update_ok_msg = base64_encode("Status has been changed Successfully!");
	$url = "album_list?artist_id=$artist_id&msg=$update_ok_msg&case=1";
	echo '<script>window.location = "' . $url . '";</script>';
	exit;

	 
}
?>
<html>

<head>
	<title>Artist <?php echo $artist_name; ?> Album Listing</title>
	<?php
	if ($top_album_module == 'No') {
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



		function change_status(album_id, status) {
			var csrf_token = $('meta[name=csrf-token]').attr('content');


			$.ajax({

				type: "POST",

				url: 'process/album_status',

				data: {
					'album_id' : album_id,
					'status': status,
					"_token": csrf_token,
				}, 
				beforeSend: function() {
					$("#remove_album_" + album_id).hide();
					document.getElementById("loader_song_" + album_id).innerHTML = '<img src=' + JS_ADMIN_SERVER_PATHROOT + 'images/load.gif>';
				},
				success: function(msg) {
					document.getElementById("loader_song_" + album_id).innerHTML = '';
					document.getElementById("show_status_" + album_id).innerHTML = msg;

				}

			});
		}

		function delete_album_list(del_id, artist_id) {



			var conBox = confirm("Are you sure,you want to delete this Record?");
			var csrf_token = $('meta[name=csrf-token]').attr('content');



			if (conBox)

			{

				$.ajax({

					type: "POST",

					url: JS_ADMIN_SERVER_PATHROOT + 'process/delete_album',

					data: {
						 'del_id' : del_id,
						 'artist_id' : artist_id,
						 "_token": csrf_token,
					},




					beforeSend: function() {

					},



					success: function(msg) {


						myarray = msg.split('-SEPARATOR-');

						if (msg.search('done') != -1)

						{

							alert('Record Delete Successfully');

						} else

						{

							alert('Some Error occured in deleting Record');

						}



						window.location.reload();

					},

					error: function() {

					}

				});

			} else

			{

				return;

			}

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
										<td class="heading1">Album Listing</td>
									</tr>
									<tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td><a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a>
														&raquo; <a>Album Listing</a></td>
												</tr>

												<tr>
													<td>
														<form name="search_form" id="search_form" method="post" action="">
														@csrf
														<table border="0" cellpadding="0" cellspacing="0" align="center" width="500" style="border:1px solid #000000; padding:10px;">
																<tbody>
																	<tr>
																		<td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
																			Search Album</td>
																	</tr>

																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Album iTunes id
																		</td>
																		<td align="center">
																			<input name="album_itunesid" id="album_itunesid" type="text" class="Field300" value="<?php echo $_SESSION['album_itunesid_sess']; ?>" />
																		</td>
																	</tr>


																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Artist
																		</td>
																		<td align="center">
																			<input name="artist_title" id="artist_title" type="text" class="Field300" value="<?php echo $_SESSION['artist_title_sess']; ?>" />
																		</td>
																	</tr>

																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Album
																		</td>
																		<td align="center">
																			<input name="album_title" id="album_title" type="text" class="Field300" value="<?php echo $_SESSION['album_title_sess']; ?>" />
																		</td>
																	</tr>
																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Status
																		</td>
																		<td align="center">
																			<select name="album_status" id="album_status" class="Field300">
																				<option value=""> ------- Please Select Status ------- </option>
																				<option value="1" <?php if ($_SESSION['album_status'] == '1') {
																										echo 'selected="selected"';
																									} ?>>Active</option>
																				<option value="0" <?php if ($_SESSION['album_status'] == '0') {
																										echo 'selected="selected"';
																									} ?>>Block</option>
																			</select>
																		</td>
																	</tr>

																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">&nbsp;</td>
																		<td align="center">
																			<input type="submit" id="filter" name="filter" value="Search">
																			<input type="submit" id="Reset" name="Reset" value="Reset">
																		</td>
																	</tr>
																</tbody>
															</table>
														</form>
													</td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" class="Panel">
															<tbody>
																<?php if (isset($msg) && $msg != "") { ?>
																	<tr>
																		<td colspan="7">
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
																	<td width="30" id="Heading_list">Album iTunes id</td>
																	<td width="200" id="Heading_list">Image</td>
																	<td width="300" id="Heading_list">Album</td>
																	<td width="150" id="Heading_list">Popular album</td>
																	<td width="200" id="Heading_list">Artist</td>
																	<!--<td width="100" id="Heading_list"> <?php if ($sortby == 'ranking_order_asc') { ?>
                                        <a href="album_list?sortby=ranking_order_desc&page=<?php echo $page; ?>" class="link_class">Ranking</a>
                                        <?php } else { ?>
                                        <a href="album_list?sortby=ranking_order_asc&page=<?php echo $page; ?>" class="link_class">Ranking</a>
                                        <?php } ?></td>-->
																	<td width="106" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
																</tr>
																<form action="<?php echo SERVER_ADMIN_PATH; ?>process/album_actions2" method="post" id="faq_form">
																@csrf	
																<input type="hidden" name="artist_id" id="artist_id" value="<?php echo $_REQUEST['artist_id']; ?>">
																	<?php
																	//============================================================

																	$artist_list_arr	=	\App\Models\Songs::GetRawData($artist_list);
																	if (isset($artist_list_arr)) {
																		foreach ($artist_list_arr as $val) {
																			$val = (array)$val;
																			$id	  = $val['id'];
																			$album_title = stripslashes(html_entity_decode($val['album_title']));
																			$artist_name = stripslashes(html_entity_decode($val['artist_name']));
																			$popular_album	  = $val['popular_album'];
																			$album_picture   = stripslashes(html_entity_decode($val['album_picture']));
																			$artist_id  = $val['album_artist_id'];
																			$status   = $val['album_status'];
																			$album_title = wordwrap($album_title, 100, " ", true);

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
																				<td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $id; ?></td>
																				<td nowrap="nowrap" class="SmallFieldLabel" width="200">
																					<?php

																					if ($album_picture != "") {
																						$img_api_link = album_img_api($album_picture);
																						if ($img_api_link != '') { ?>
																							<img src="<?php echo $album_picture; ?>" border="0" width="50" height="50" />
																						<?php } else { ?>
																							<img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'small_thumb_' . $album_picture; ?>" border="0" width="50" height="50" />
																						<?php }
																					} else { ?>
																						<img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image.png" border="0" width="50" height="50" />
																					<?php } ?>
																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel" width="200">
																					<a href="artist_album_songs_list?artist_id=<?php echo base64_encode($artist_id); ?>&album_id=<?php echo base64_encode($id); ?>"><?php echo $album_title; ?></a>
																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel" width="70">
																					<?php
																					if ($popular_album == 0) {
																						echo "No";
																					}
																					if ($popular_album == 1) {
																						echo "Yes";
																					} ?>
																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel" width="200">
																					<a href="artist_album_list?artist_id=<?php echo base64_encode($artist_id); ?>"><?php echo $artist_name; ?></a>
																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70">
																					&nbsp;&nbsp; <input type="checkbox" class="check-all" name="ids[]" id="ids[]" value="<?php echo base64_encode($id); ?>" style="margin-top:-5px;" />
																					&nbsp;&nbsp;
																					<a href="addedit_artist_album?edit_id=<?php echo base64_encode($id); ?>&artist_id=<?php echo base64_encode($artist_id); ?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>
																					&nbsp;&nbsp;
																					<?php
																					if ($status == 0) {
																						echo '<a href="javascript:;" onclick = "change_status(' . $id . ', 1)" id = "remove_album_' . $id . '"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>';
																					}
																					if ($status == 1) {
																						echo '<a href="javascript:;" onclick = "change_status(' . $id . ', 0)" id = "remove_album_' . $id . '"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>';
																					}
																					?>
																					<span id="loader_song_<?php echo $id; ?>"></span>
																					<span id="show_status_<?php echo $id; ?>"></span>

																					&nbsp; &nbsp;
																					<a href="javascript:;" onClick="delete_album_list('<?php echo $id; ?>','<?php echo base64_encode($artist_id); ?>')"><img src="images/delet.gif" border="0" title="Delete" class="Action"></a>
																				</td>
																			</tr>
																		<?php }
																	} else { ?>
																		<tr>
																			<td colspan="6" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
																		</tr>
																	<?php }
																	if ($total_pages > 0) { ?>
																		<tr>
																			<td colspan="6" nowrap="nowrap" class="SmallFieldLabel righttd_border">
																				<span style="float:right; padding-bottom:10px; margin-right:8px;">
																					<select name="dropdown" onChange="multiple_action('faq_form');">
																						<option value="">Choose an action...</option>
																						<option value="popular_album">Popular Album</option>
																						<option value="not_popular_album">Not Popular Album</option>
																						<!-- <option value="sort_ranking">Sort Ranking</option>-->
																					</select>
																				</span>
																			</td>
																		</tr>
																	<?php } ?>
																	<tr>
																		<td colspan="6" align="center" valign="middle"> @include("admin.common.paging-playlist") </td>
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