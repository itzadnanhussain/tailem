@include("admin.includes.top")
@include("admin.common.security")

<?php
error_reporting(0);

/*================== Search Filter Start Here=================*/
if (isset($_POST['filter'])) {
	$sess_where = "";

	if ($_REQUEST['review_title'] != "") {
		$sess_where .= " and r.review_title like \"%" . trim($_REQUEST['review_title']) . "%\" ";
		session()->put('review_title_sess', trim($_REQUEST['review_title']));
	} else {
		session()->put('review_title_sess', null);
	}

	if ($_REQUEST['review_rating'] != "") {
		$sess_where .= " and r.review_rating = '" . trim($_REQUEST['review_rating']) . "' ";
		session()->put('review_rating_sess', trim($_REQUEST['review_rating']));
	} else {
		session()->put('review_rating_sess', null);
	}

	if ($_REQUEST['user_id'] != "") {
		$sess_where .= " and r.review_user_id  = '" . trim($_REQUEST['user_id']) . "' ";
		session()->get('review_user_id_sess', trim($_REQUEST['user_id']));
	} else {
		session()->get('review_user_id_sess', null);
	}


	if ($_REQUEST['review_status'] != "") {
		$sess_where .= " and r.status = '" . $_REQUEST['review_status'] . "'";
		session()->put('reviews_status_sess', $_REQUEST['review_status']);
	} else {
		session()->put('reviews_status_sess', null);
	}

	if ($_REQUEST['is_popular'] != "") {
		$sess_where .= " and r.is_popular = '" . trim($_REQUEST['is_popular']) . "' ";
		session()->put('is_popular_sess', trim($_REQUEST['is_popular']));
	} else {
		session()->put('is_popular_sess', null);
	}

	session()->put('review_sess', $sess_where);
}

$session_where = session()->get('review_sess');
if (isset($_POST['Reset'])) {

	session()->put('review_title_sess', null);
	session()->put('review_rating_sess', null);
	session()->put('review_user_id_sess', null);
	session()->put('review_level5_cat_id_sess', null);
	session()->put('reviews_status_sess', null);
	session()->put('is_popular_sess', null);
	session()->put('review_sess', null);
	echo '<script>window.location = "reviews_list";</script>';
}

/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch ($sortby) {
	case "title_desc":
		$orderby	= " ORDER BY r.review_title desc";
		break;

	case "title_asc":
		$orderby	= " ORDER BY r.review_title asc";
		break;

	case "rating_desc":
		$orderby	= " ORDER BY r.review_rating desc";
		break;

	case "rating_asc":
		$orderby	= " ORDER BY r.review_rating asc";
		break;

	case "user_id_desc":
		$orderby	= " ORDER BY r.review_user_id desc";
		break;

	case "user_id_asc":
		$orderby	= " ORDER BY r.review_user_id asc";
		break;

	case "date_desc":
		$orderby	= " ORDER BY r.review_post_date desc";
		break;

	case "date_asc":
		$orderby	= " ORDER BY r.review_post_date asc";
		break;

	case "statusdesc":
		$orderby	= " ORDER BY r.status desc";
		break;
	case "statusasc":
		$orderby	= " ORDER BY r.status asc";
		break;

	default:
		$orderby = "ORDER BY r.review_id desc";
		break;
}


if (isset($status) && !empty($status)) {
	$status		=	base64_decode($status);

	$status_id	=	base64_decode($status_id);

	if ($status == 1) {
		$sqlquery	=	"update tbl_reviews set status='$status' where review_id='$status_id'";
	} else {
		$sqlquery	=	"update tbl_reviews set status='$status',is_popular='0' where review_id='$status_id'";
	}


	\App\Models\Songs::GetRawData($sqlquery);
	$update_ok_msg = base64_encode("Status has been changed Successfully!");
	$url = "reviews_list?msg=$update_ok_msg&case=1";
	echo '<script>window.location = "' . $url . '";</script>';
	exit;
}

?>
<html>

<head>
	<title>Reviews Listing</title>
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
										<td class="heading1">Reviews Listing</td>
									</tr>
									<tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td><a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a> &raquo; <a>Reviews Listing</a></td>
												</tr>
												<tr>
													<td>
														<form name="search_form" id="search_form" method="post" action="">
															
														@csrf
														<table border="0" cellpadding="0" cellspacing="0" align="center" width="500" style="border:1px solid #000000; padding:10px;">
																<tbody>
																	<tr>
																		<td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
																			Search Reviews
																		</td>
																	</tr>
																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Review Title
																		</td>
																		<td align="center">
																			<input name="review_title" id="review_title" class="Field300" value="<?php echo session()->get('review_title_sess'); ?>" type="text" />
																		</td>
																	</tr>
																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Review Rating
																		</td>
																		<td align="center">
																			<input name="review_rating" id="review_rating" class="Field300" value="<?php echo session()->get('review_rating_sess'); ?>" type="text" />
																		</td>
																	</tr>


																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			User Name
																		</td>
																		<td align="center">
																			<select name="user_id" id="user_id" class="Field300">
																				<option value=""> ------ Please Select User ------</option>
																				<?php
																				$users_qry = "select user_id,user_name from tbl_users where status=1
												 order by user_name asc";
																				$users_arr = \App\Models\Songs::GetRawData($users_qry);
																				if ($users_arr) {
																					foreach ($users_arr as $val) {
																						$val = (array)$val;
																						$user_id = $val['user_id'];
																						$user_name = html_entity_decode(stripslashes($val['user_name']));
																						if (session()->get('review_user_id_sess') == $user_id) {
																							$selected = "selected='selected'";
																						} else {
																							$selected = "";
																						}
																				?>
																						<option value="<?php echo $user_id; ?>" <?php echo $selected; ?>><?php echo $user_name; ?></option>
																					<?php
																					}
																					?>

																				<?php
																				}
																				?>
																			</select>
																		</td>
																	</tr>

																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Status
																		</td>
																		<td align="center">
																			<select name="review_status" id="review_status" class="Field300">
																				<option value=""> ------- Please Select Status ------- </option>
																				<option value="1" <?php if (session()->get('reviews_status_sess') == '1') {
																										echo 'selected="selected"';
																									} ?>>Active</option>
																				<option value="0" <?php if (session()->get('reviews_status_sess') == '0') {
																										echo 'selected="selected"';
																									} ?>>Block</option>
																			</select>
																		</td>
																	</tr>

																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Popular
																		</td>
																		<td align="center">
																			<select name="is_popular" id="is_popular" class="Field300">
																				<option value=""> ------- Please Select ------- </option>
																				<option value="1" <?php if (session()->get('is_popular_sess') == '1') {
																										echo 'selected="selected"';
																									} ?>>Popular</option>
																				<option value="0" <?php if (session()->get('is_popular_sess') == '0') {
																										echo 'selected="selected"';
																									} ?>>Non Popular</option>
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
																		<td colspan="9">
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
																	<td colspan="9">&nbsp;</td>
																</tr>
																<tr>
																	<td width="25" id="Heading_list">Sr #</td>
																	<td width="150" id="Heading_list">
																		<?php if ($sortby == 'title_desc') { ?>
																			<a href="reviews_list?sortby=title_asc&page=<?php echo $page; ?>" class="link_class">Review Title</a>
																		<?php } else { ?>
																			<a href="reviews_list?sortby=title_desc&page=<?php echo $page; ?>" class="link_class">Review Title</a>
																		<?php } ?>
																	</td>
																	<td width="150" id="Heading_list">
																		<a style="text-decoration:none;" class="link_class">Song Title</a>
																	</td>

																	<td width="65" id="Heading_list">
																		<?php if ($sortby == 'rating_desc') { ?>
																			<a href="reviews_list?sortby=rating_asc&page=<?php echo $page; ?>" class="link_class">Review Rating</a>
																		<?php } else { ?>
																			<a href="reviews_list?sortby=rating_desc&page=<?php echo $page; ?>" class="link_class">Review Rating</a>
																		<?php } ?>
																	</td>
																	<td width="150" id="Heading_list">
																		<?php if ($sortby == 'user_id_desc') { ?>
																			<a href="reviews_list?sortby=user_id_asc&page=<?php echo $page; ?>" class="link_class">User Name</a>
																		<?php } else { ?>
																			<a href="reviews_list?sortby=user_id_desc&page=<?php echo $page; ?>" class="link_class">User Name</a>
																		<?php } ?>
																	</td>


																	<td width="50" id="Heading_list">
																		<?php if ($sortby == 'date_desc') { ?>
																			<a href="reviews_list?sortby=date_asc&page=<?php echo $page; ?>" class="link_class">Post Date</a>
																		<?php } else { ?>
																			<a href="reviews_list?sortby=date_desc&page=<?php echo $page; ?>" class="link_class">Post Date</a>
																		<?php } ?>
																	</td>
																	<td width="50" id="Heading_list">Likes<br> Reports</td>
																	<td width="70" id="Heading_list">
																		<?php if ($sortby == 'statusdesc') { ?>
																			<a href="reviews_list?sortby=statusasc&page=<?php echo $page; ?>" class="link_class">Status</a>
																		<?php } else { ?>
																			<a href="reviews_list?sortby=statusdesc&page=<?php echo $page; ?>" class="link_class">Status</a>
																		<?php } ?>
																	</td>
																	<td width="100" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
																</tr>

																<form action="<?php echo SERVER_ADMIN_PATH; ?>process/reviews_actions" method="post" id="reviews_form">
																	@csrf
																	<?php
																	//============================================================
																	//PAGGING CODE STARTS HERE
																	$qry_count_mypro = "select a.artist_seo,s.song_seo, s.song_title,r.* 
										 from tbl_reviews r,tbl_artists a,tbl_songs s   
										 where 1=1 
										 AND r.song_id = s.id
										 AND r.artist_id = a.id
										 $session_where $orderby";
 
																	$targetpage = "reviews_list"; //your file name  (the name of this file)

																	$res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
																	if ($res_count_mypro) {
																		$total_pages = count($res_count_mypro);
																	} else {
																		$total_pages = 0;
																	}

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

																	$reviews_list = "select a.artist_seo,s.song_seo, s.song_title,r.* 
										 from tbl_reviews r,tbl_artists a,tbl_songs s   
										 where 1=1 
										 AND r.song_id = s.id
										 AND r.artist_id = a.id
										 $session_where $orderby LIMIT 
										$start, $limit";
																	$reviews_list_arr	=	\App\Models\Songs::GetRawData($reviews_list);;

																	if (isset($reviews_list_arr)) {
																		foreach ($reviews_list_arr as $val) {
																			$val = (array)$val;
																			$review_id	   = $val['review_id'];

																			$artist_seo	= $val['artist_seo'];
																			$song_seo	= $val['song_seo'];

																			$review_title  = stripslashes(html_entity_decode($val['review_title']));
																			$review_rating = $val['review_rating'];
																			$review_detail = stripslashes(html_entity_decode($val['review_detail']));
																			$review_user_id = $val['review_user_id'];
																			$status     	= $val['status'];

																			$is_popular     = $val['is_popular'];
																			$is_featured    = $val['is_featured'];
																			$review_post_date  = $val['review_post_date'];
																			$review_title  = wordwrap($review_title, 100, " ", true);

																			$song_title	=	$val['song_title'];
																		 


																			$select_qry = "select user_name from tbl_users where 
												user_id='" . $review_user_id . "' ";
																			$select_ar  = \App\Models\Songs::GetRawDataAdmin($select_qry);
																			$user_name = stripslashes($select_ar['user_name']);
																			$user_name = wordwrap($user_name, 100, " ", true);

																			$like_qry = "select count(id) as total_likes from 
												tbl_likes where like_id='" . $review_id . "' AND like_type = 'review_song'";
																			$like_arr  =\App\Models\Songs::GetRawDataAdmin($like_qry);
																			$total_likes = $like_arr['total_likes'];

																			$report_qry = "select count(r_report_id) as total_reports from 
												tbl_review_report where r_report_review_id='" . $review_id . "' ";
																			$report_arr  = \App\Models\Songs::GetRawDataAdmin($report_qry);
																			$total_reports = $report_arr['total_reports'];

																			if ($c % 2 == 0) {
																				$bgcolor = "#FEFEE4";
																			} else {
																				$bgcolor = "#FFFFFF";
																			}

																			$c++;
																			$sr_no++;
																	?>

																			<tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $review_id; ?>')" onMouseOut="changebackcolor_blur('row<?php echo $review_id; ?>')" id="row<?php echo $review_id; ?>">
																				<td nowrap="nowrap" class="SmallFieldLabel" width="25"><?php echo $sr_no; ?></td>
																				<td nowrap="nowrap" class="SmallFieldLabel" width="150">
																					<a href="<?php echo SERVER_ADMIN_PATH; ?>review_details?key=<?php echo base64_encode($review_id); ?>" style="text-decoration:none;"><?php echo substr($review_title, 0, 100); ?></a></br></br>
																					<?php
																					if ($is_popular == 0 && $status == 1) {
																					?>
																						<a href="javascript:;" onClick="set_popular('<?php echo base64_encode($review_id); ?>')">Set as Popular</a>
																					<?php
																					} elseif ($is_popular == 1) {
																					?>
																						<a href="javascript:;" onClick="unset_popular('<?php echo base64_encode($review_id); ?>')">UnSet as Popular</a>
																					<?php
																					}
																					?>
																					<?php
																					if ($is_featured == 'No' && $status == 1) {
																						echo '<strong> | </strong>';
																					?>
																						<a href="javascript:;" onClick="set_featured_review('<?php echo base64_encode($review_id); ?>')">Set as Featured</a>
																					<?php
																					} elseif ($is_featured == 'Yes') {
																						echo '<strong> | </strong>';
																					?>
																						<a href="javascript:;" onClick="unset_featured_review('<?php echo base64_encode($review_id); ?>')">UnSet as Featured</a>
																					<?php
																					}
																					?>

																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel" width="65">
																					<a href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>" style="color:#0000FF; text-decoration:none;" target="_blank"><?php echo $song_title; ?></a>
																				</td>

																				<td nowrap="nowrap" class="SmallFieldLabel" width="65">
																					<?php echo $review_rating; ?>
																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel" width="150">
																					<?php echo substr($user_name, 0, 80); ?>
																				</td>


																				<td nowrap="nowrap" class="SmallFieldLabel" width="50">
																					<?php echo date("d M Y", $review_post_date); ?>
																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel" width="50">
																					Likes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=
																					<a href="<?php echo SERVER_ADMIN_PATH; ?>review_likes?key=<?php echo base64_encode($review_id); ?>" style="text-decoration:none;color:#0000FF;"><strong><?php echo $total_likes; ?></strong></a><br />
 																					Reports&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=
																					<a href="<?php echo SERVER_ADMIN_PATH; ?>review_reports?key=<?php echo base64_encode($review_id); ?>" style="text-decoration:none;color:#0000FF;"><strong><?php echo $total_reports; ?></strong><br /></a>
																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel" width="70">
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
																						echo '<a href="reviews_list?status=' . base64_encode(1) . '&status_id=' . base64_encode($review_id) . '"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>';
																					}
																					if ($status == 1) {
																						echo '<a href="reviews_list?status=' . base64_encode(0) . '&status_id=' . base64_encode($review_id) . '"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>';
																					}

																					if ($is_popular == 1) {
																						echo '<br><br><strong>Popular Review</strong>';
																					}
																					if ($is_featured == 'Yes') {
																						echo '<br><br><strong>Featured Review</strong>';
																					}
																					?>

																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70">
																					&nbsp;&nbsp; <input type="checkbox" class="check-all" name="review_ids[]" id="review_ids[]" value="<?php echo base64_encode($review_id); ?>" style="margin-top:-5px;" />
																					&nbsp;&nbsp;
																					<?php
																					if ($top_reviews_module_add == 'Yes') {
																					?>
																						<a href="edit_review?edit_id=<?php echo base64_encode($review_id); ?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>
																						<?php
																					}
																						?>&nbsp;&nbsp;
																						<?php
																						if ($top_reviews_module_delete == "Yes") {
																						?>
																							<a href="javascript:;" onClick="delete_review('<?php echo base64_encode($review_id); ?>')"><img src="images/delet.gif" border="0" title="Delete Review" class="Action"></a>
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
																			<td colspan="9" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
																		</tr>
																	<?php
																	}
																	?>
																	<?php
																	if ($total_pages > 0) {
																	?>
																		<tr>
																			<td colspan="9" nowrap="nowrap" class="SmallFieldLabel righttd_border">
																				<span style="float:right; padding-bottom:10px; margin-right:8px;">
																					<select name="dropdown" onChange="multiple_action('reviews_form');">
																						<option value="">Choose an action...</option>
																						<option value="Active">Active</option>
																						<option value="Inactive">Inactive</option>
																						<?php
																						if ($top_reviews_module_delete == "Yes") {
																						?>
																							<option value="Delete">Delete</option>
																						<?php
																						}
																						?>
																					</select>
																				</span>
																			</td>
																		</tr>
																	<?php
																	}
																	?>
																	<tr>
																		<td colspan="9" align="center" valign="middle">
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