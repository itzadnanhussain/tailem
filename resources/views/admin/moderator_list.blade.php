@include("admin.includes.top")
@include("admin.common.security")
<?php

error_reporting(0);
/*================== Search Filter Start Here=================*/
if (isset($_POST['filter'])) {
	$sess_where = "";

	if ($_REQUEST['username'] != "") {
		$sess_where .= " and username like \"%" . trim($_REQUEST['username']) . "%\" ";
		$_SESSION['moderator_name_sess'] = trim($_REQUEST['username']);
	} else {
		unset($_SESSION['moderator_name_sess']);
	}



	if ($_REQUEST['country_id'] != "") {
		$sess_where .= " and country_id  = '" . trim($_REQUEST['country_id']) . "' ";
		$_SESSION['country_id_sess'] = trim($_REQUEST['country_id']);
	} else {
		unset($_SESSION['country_id_sess']);
	}

	if ($_REQUEST['email'] != "") {

		$sess_where .= " and email  = \"" . trim($_REQUEST['email']) . "\" ";
		$_SESSION['moderator_email_sess'] = trim($_REQUEST['email']);
	} else {
		unset($_SESSION['moderator_email_sess']);
	}
	if ($_REQUEST['moderator_status'] != "") {
		$sess_where .= " and admin_status = '" . $_REQUEST['moderator_status'] . "'";
		$_SESSION['moderator_status_sess'] = $_REQUEST['moderator_status'];
	} else {
		unset($_SESSION['moderator_status_sess']);
	}



	$_SESSION['sess_moderator'] = $sess_where;
}

$session_where = $_SESSION['sess_moderator'];
if (isset($_POST['Reset'])) {
	unset($_SESSION['moderator_name_sess']);
	$_SESSION['moderator_name_sess'] = "";

	unset($_SESSION['moderator_email_sess']);
	$_SESSION['moderator_email_sess'] = "";


	unset($_SESSION['moderator_status_sess']);
	$_SESSION['moderator_status_sess'] = "";


	unset($_SESSION['sess_moderator']);
	$_SESSION['sess_moderator'] = "";


	header("Location:moderator_list");
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch ($sortby) {
	case "name_desc":
		$orderby	= " ORDER BY username desc";
		break;

	case "name_asc":
		$orderby	= " ORDER BY username asc";
		break;

	case "email_desc":
		$orderby	= " ORDER BY user_email desc";
		break;

	case "email_asc":
		$orderby	= " ORDER BY user_email asc";
		break;

	case "statusdesc":
		$orderby	= " ORDER BY admin_status desc";
		break;

	case "statusasc":
		$orderby	= " ORDER BY admin_status asc";
		break;

	default:
		$orderby = "ORDER BY id desc";
		break;
}


if (isset($status) && !empty($status)) {
	$status		=	base64_decode($status);

	$status_id	=	base64_decode($status_id);

	if ($status == 1) {
		$sqlquery	=	"update tbl_admin set admin_status='$status' where id='$status_id' and id!='1'";
	} else {
		$sqlquery = "update tbl_admin set admin_status='$status' where id='$status_id' and id!='1'";
	}

	\App\Models\Songs::GetRawData($sqlquery);
	$update_ok_msg = base64_encode("Status has been changed Successfully!");
	$url = "moderator_list?msg=$update_ok_msg&case=1";
	echo '<script>window.location = "' . $url . '";</script>';
}


?>
<html>

<head>
	<title>Moderator Listing</title>
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
										<td class="heading1">Moderator Listing</td>
									</tr>
									<tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td><a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a> &raquo; <a>Moderator Listing</a></td>
												</tr>
												<tr>
													<td>
														<form name="search_form" id="search_form" method="post" action="">
															@csrf
															<table border="0" cellpadding="0" cellspacing="0" align="center" width="500" style="border:1px solid #000000; padding:10px;">
																<tbody>
																	<tr>
																		<td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
																			Search Moderator
																		</td>
																	</tr>
																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			User Name
																		</td>
																		<td align="center">
																			<input name="username" id="username" type="text" class="Field300" value="<?php echo $_SESSION['moderator_name_sess']; ?>" />
																		</td>
																	</tr>
																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Email
																		</td>
																		<td align="center">
																			<input name="email" id="email" class="Field300" type="text" value="<?php echo $_SESSION['moderator_email_sess']; ?>" />
																		</td>
																	</tr>

																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Status
																		</td>
																		<td align="center">
																			<select name="moderator_status" id="moderator_status" class="Field300">
																				<option value=""> ------- Please Select Status ------- </option>
																				<option value="1" <?php if ($_SESSION['moderator_status_sess'] == '1') {
																										echo 'selected="selected"';
																									} ?>>Active</option>
																				<option value="0" <?php if ($_SESSION['moderator_status_sess'] == '0') {
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
																		<td colspan="8">
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
																	<td colspan="8" width="105" align="right" valign="middle" id="addsymbol">
																		<a href="<?php echo SERVER_ADMIN_PATH; ?>addedit_moderator"><img src="images/add.png" border="0" title="Add New Subject"></a>
																	</td>
																</tr>

																<tr>
																	<td colspan="8">&nbsp;</td>
																</tr>
																<tr>
																	<td width="25" id="Heading_list">Sr #</td>
																	<td width="150" id="Heading_list">
																		<?php if ($sortby == 'name_desc') { ?>
																			<a href="moderator_list?sortby=name_asc&page=<?php echo $page; ?>" class="link_class">User Name</a>
																		<?php } else { ?>
																			<a href="moderator_list?sortby=name_desc&page=<?php echo $page; ?>" class="link_class">User Name</a>
																		<?php } ?>
																	</td>

																	<td width="150" id="Heading_list">
																		<?php if ($sortby == 'email_desc') { ?>
																			<a href="moderator_list?sortby=email_asc&page=<?php echo $page; ?>" class="link_class">User Email</a>
																		<?php } else { ?>
																			<a href="moderator_list?sortby=email_desc&page=<?php echo $page; ?>" class="link_class">User Email</a>
																		<?php } ?>
																	</td>

																	<td width="50" id="Heading_list">
																		<?php if ($sortby == 'statusdesc') { ?>
																			<a href="moderator_list?sortby=statusasc&page=<?php echo $page; ?>" class="link_class">Status</a>
																		<?php } else { ?>
																			<a href="moderator_list?sortby=statusdesc&page=<?php echo $page; ?>" class="link_class">Status</a>
																		<?php } ?>
																	</td>
																	<td width="70" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
																</tr>

																<form action="<?php echo SERVER_ADMIN_PATH; ?>process/moderator_actions" method="post" id="moderator_form">
																	@csrf
																	<?php

																	//============================================================
																	//PAGGING CODE STARTS HERE
																	$qry_count_mypro = "SELECT id FROM tbl_admin where 1=1 and id!='1'
											$session_where  $orderby";
																	$res_count_mypro = array();
																	$res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
																	if ($res_count_mypro) {
																		$total_pages = count($res_count_mypro);
																	} else {
																		$total_pages = 0;
																	}
																	$targetpage = "moderator_list";


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

																	$moderator_qry = "select * from tbl_admin where 1=1 and id!='1' 
										$session_where $orderby LIMIT $start, $limit";

																	$moderator_arr	=	\App\Models\Songs::GetRawData($moderator_qry);

																	if (isset($moderator_arr)) {
																		foreach ($moderator_arr as $val) {
																			$val = (array)$val;
																			$id	          = $val['id'];
																			$username 	  = stripslashes(html_entity_decode($val['username']));
																			$admin_status = $val['admin_status'];
																			$email        = stripslashes(html_entity_decode($val['email']));
																			if ($c % 2 == 0) {
																				$bgcolor = "#FEFEE4";
																			} else {
																				$bgcolor = "#FFFFFF";
																			}

																			$c++;
																			$sr_no++;
																	?>

																			<tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $id; ?>')" onMouseOut="changebackcolor_blur('row<?php echo $id; ?>')" id="row<?php echo $id; ?>">
																				<td nowrap="nowrap" class="SmallFieldLabel" width="25"><?php echo $sr_no; ?></td>
																				<td nowrap="nowrap" class="SmallFieldLabel" width="150">
																					<?php echo $username; ?>
																				</td>

																				<td nowrap="nowrap" class="SmallFieldLabel" width="150">
																					<?php echo $email; ?>
																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel" width="50">
																					<?php
																					if ($admin_status == 0) {
																						echo "Blocked";
																					}
																					if ($admin_status == 1) {
																						echo "Active";
																					} ?>
																					&nbsp;&nbsp;&nbsp;
																					<?php
																					if ($admin_status == 0) {
																						echo '<a href="moderator_list?status=' . base64_encode(1) . '&status_id=' . base64_encode($id) . '"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>';
																					}
																					if ($admin_status == 1) {
																						echo '<a href="moderator_list?status=' . base64_encode(0) . '&status_id=' . base64_encode($id) . '"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>';
																					}

																					if ($is_top_member == 1) {
																						echo '<br><br><strong>Top Member</strong>';
																					}
																					?>

																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70">
																					&nbsp;&nbsp; <input type="checkbox" class="check-all" name="ids[]" id="ids[]" value="<?php echo base64_encode($id); ?>" style="margin-top:-5px;" />
																					&nbsp;&nbsp;
																					<a href="addedit_moderator?edit_id=<?php echo base64_encode($id); ?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>


																					&nbsp; &nbsp;
																					<a href="javascript:;" onClick="delete_moderator('<?php echo $id; ?>')"><img src="images/delet.gif" border="0" title="Delete Moderator" class="Action"></a>

																					&nbsp; &nbsp;
																					<a href="moderator_rights?edit_id=<?php echo base64_encode($id); ?>"><img src="images/setting.png" border="0" title="Assign Right" class="Action"></a>
																				</td>
																			</tr>
																		<?php
																		}
																	} else {
																		?>

																		<tr>
																			<td colspan="8" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
																		</tr>
																	<?php
																	}
																	?>
																	<?php
																	if ($total_pages > 0) {
																	?>
																		<tr>
																			<td colspan="8" nowrap="nowrap" class="SmallFieldLabel righttd_border">
																				<span style="float:right; padding-bottom:10px; margin-right:8px;">
																					<select name="dropdown" onChange="multiple_action('moderator_form');">
																						<option value="">Choose an action...</option>
																						<option value="Active">Active</option>
																						<option value="Inactive">Inactive</option>
																						<option value="Delete">Delete</option>
																					</select>
																				</span>
																			</td>
																		</tr>
																	<?php
																	}
																	?>
																	<tr>
																		<td colspan="8" align="center" valign="middle">
																			@include("admin.common.paging-playlist") </td>
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
				@include("admin.common.footer") </td>
		</tr>
		</tbody>
	</table>
	<!-- End pagefooter -->
</body>

</html>