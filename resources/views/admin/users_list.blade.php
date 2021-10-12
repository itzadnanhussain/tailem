@include("admin.includes.top")
@include("admin.common.security")
<?php


error_reporting(0);

$session_where = session()->get('sess_users');

/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch ($sortby) {
	case "user_name_desc":
		$orderby	= " ORDER BY user_name desc";
		break;

	case "user_name_asc":
		$orderby	= " ORDER BY user_name asc";
		break;

	case "user_email_desc":
		$orderby	= " ORDER BY user_email desc";
		break;

	case "user_email_asc":
		$orderby	= " ORDER BY user_email asc";
		break;

	case "country_desc":
		$orderby	= " ORDER BY country_id desc";
		break;

	case "country_asc":
		$orderby	= " ORDER BY country_id asc";
		break;

	case "region_desc":
		$orderby	= " ORDER BY region desc";
		break;

	case "region_asc":
		$orderby	= " ORDER BY region asc";
		break;

	case "statusdesc":
		$orderby	= " ORDER BY status desc";
		break;

	case "statusasc":
		$orderby	= " ORDER BY status asc";
		break;

	default:
		$orderby = "ORDER BY user_id desc";
		break;
}


if (isset($status) && !empty($status)) {
	$status		=	base64_decode($status);

	$status_id	=	base64_decode($status_id);

	if ($status == 1) {
		$sqlquery	=	"update tbl_users set status='$status' where user_id='$status_id'";
	} else {
		$sqlquery	=	"update tbl_users set status='$status',is_top_member='0' where user_id='$status_id'";
	}

	\App\Models\Songs::GetRawData($sqlquery);
	$update_ok_msg = base64_encode("Status has been changed Successfully!");
	$url = "users_list?msg=$update_ok_msg&case=1";
	echo '<script>window.location = "' . $url . '";</script>';
	exit;
}

?>
<html>

<head>
	<title>Users Listing</title>
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
			// alert(frm_id);
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
				@include("admin.common.top_right_menu")>
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
										<td class="heading1">Users Listing</td>
									</tr>
									<tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td><a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a> &raquo; <a>Users Listing</a></td>
												</tr>
												<tr>
													<td>
														<form name="search_form" id="search_form" method="post" action="">
															@csrf
															<table border="0" cellpadding="0" cellspacing="0" align="center" width="500" style="border:1px solid #000000; padding:10px;">
																<tbody>
																	<tr>
																		<td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
																			Search Users
																		</td>
																	</tr>
																	<tr height="30">


																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Display Name
																		</td>

																		<td align="center">
																			<input name="user_name" id="user_name" type="text" class="Field300" value="<?php echo session()->get('user_name_sess'); ?>" />
																		</td>
																	</tr>
																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Email
																		</td>
																		<td align="center">
																			<input name="user_email" id="user_email" class="Field300" value="<?php echo session()->get('user_email_sess'); ?>" type="text" />
																		</td>
																	</tr>

																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Status
																		</td>
																		<td align="center">
																			<select name="user_status" id="user_status" class="Field300">
																				<option value=""> ------- Please Select Status ------- </option>
																				<option value="1" <?php if (session()->get('user_status_sess') == '1') {
																										echo 'selected="selected"';
																									} ?>>Active</option>
																				<option value="0" <?php if (session()->get('user_status_sess') == '0') {
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
																		<a href="<?php echo SERVER_ADMIN_PATH; ?>addedit_user"><img src="images/add.png" border="0" title="Add New Subject"></a>
																	</td>
																</tr>

																<tr>
																	<td colspan="8">&nbsp;</td>
																</tr>
																<tr>
																	<td width="25" id="Heading_list">Sr #</td>
																	<td width="150" id="Heading_list">
																		<?php if ($sortby == 'user_name_desc') { ?>
																			<a href="users_list?sortby=user_name_asc&page=<?php echo $page; ?>" class="link_class">Username</a>
																		<?php } else { ?>
																			<a href="users_list?sortby=user_name_desc&page=<?php echo $page; ?>" class="link_class">Username</a>
																		<?php } ?>
																	</td>

																	<td width="150" id="Heading_list">
																		Display Name
																	</td>


																	<td width="150" id="Heading_list">
																		<?php if ($sortby == 'user_email_desc') { ?>
																			<a href="users_list?sortby=user_email_asc&page=<?php echo $page; ?>" class="link_class">User Email</a>
																		<?php } else { ?>
																			<a href="users_list?sortby=user_email_desc&page=<?php echo $page; ?>" class="link_class">User Email</a>
																		<?php } ?>
																	</td>


																	<td width="50" id="Heading_list">
																		<?php if ($sortby == 'statusdesc') { ?>
																			<a href="users_list?sortby=statusasc&page=<?php echo $page; ?>" class="link_class">Status</a>
																		<?php } else { ?>
																			<a href="users_list?sortby=statusdesc&page=<?php echo $page; ?>" class="link_class">Status</a>
																		<?php } ?>
																	</td>
																	<td width="70" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
																</tr>

																<form action="<?php echo SERVER_ADMIN_PATH; ?>process/users_actions" method="post" id="user_form">
																	@csrf
																	<?php
																	//============================================================
																	//PAGGING CODE STARTS HERE
																	$qry_count_mypro = "SELECT user_id FROM tbl_users where 1=1 $session_where  $orderby";
																	$res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
																	if ($res_count_mypro) {
																		$total_pages = count($res_count_mypro);
																	} else {
																		$total_pages = 0;
																	}
																	$targetpage = "users_list"; //your file name  (the name of this file)


																						//how many items to show per page
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

																	$user_list = "select * from tbl_users where 1=1 $session_where $orderby LIMIT $start, $limit";

																	$user_list_arr	=	\App\Models\Songs::GetRawData($user_list);


																	if (isset($user_list_arr) && !empty($user_list_arr)) {
																		foreach ($user_list_arr as $val) {
																			$val = (array)$val;
																			$user_id	= $val['user_id'];
																			$user_name  = stripslashes(html_entity_decode($val['user_name']));
																			$gender 	= $val['gender'];
																			$user_email = stripslashes(html_entity_decode($val['email']));
																			$region     = stripslashes(html_entity_decode($val['region']));
																			$country_id = $val['country_id'];
																			$status     = $val['status'];
																			$is_top_member = $val['is_top_member'];
																			$user_name  = wordwrap($user_name, 100, " ", true);

																			$select_qry = "select name as country_name from tbl_countries where country_id='" . $country_id . "' ";
																			$select_ar  = \App\Models\Songs::GetRawData($select_qry);
																			$select_ar = (array)$select_ar[0];
																			$country_name = stripslashes(html_entity_decode($select_ar['country_name']));
																			$country_name = wordwrap($country_name, 100, " ", true);
																			if ($c % 2 == 0) {
																				$bgcolor = "#FEFEE4";
																			} else {
																				$bgcolor = "#FFFFFF";
																			}

																			$c++;
																			$sr_no++;
																	?>

																			<tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $user_id; ?>')" onMouseOut="changebackcolor_blur('row<?php echo $user_id; ?>')" id="row<?php echo $user_id; ?>">
																				<td nowrap="nowrap" class="SmallFieldLabel" width="25"><?php echo $sr_no; ?></td>
																				<td nowrap="nowrap" class="SmallFieldLabel" width="150">
																					<?php echo $user_name; ?></br></br>
																				 
																				</td>

																				<td nowrap="nowrap" class="SmallFieldLabel" width="150">
																					<?php
																					echo $user_name;
																				 
																					?>
																				</td>

																				<td nowrap="nowrap" class="SmallFieldLabel" width="150">
																					<?php echo $user_email; ?>
																				</td>
																			 
																				<td nowrap="nowrap" class="SmallFieldLabel" width="50">
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
																						echo '<a href="users_list?status=' . base64_encode(1) . '&status_id=' . base64_encode($user_id) . '"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>';
																					}
																					if ($status == 1) {
																						echo '<a href="users_list?status=' . base64_encode(0) . '&status_id=' . base64_encode($user_id) . '"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>';
																					}

																					 
																					?>

																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70">
																					&nbsp;&nbsp; <input type="checkbox" class="check-all" name="user_ids[]" id="user_ids[]" value="<?php echo base64_encode($user_id); ?>" style="margin-top:-5px;" />
																					&nbsp;&nbsp;
																					<?php
																					if ($top_users_module_add == 'Yes') {
																					?>
																						<a href="addedit_user?edit_id=<?php echo base64_encode($user_id); ?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>
																					<?php
																					}
																					?>
																					&nbsp; &nbsp;
																					<?php
																					if ($top_users_module_delete == 'Yes') {
																					?>
																						<a href="javascript:;" onClick="delete_user('<?php echo $user_id; ?>')"><img src="images/delet.gif" border="0" title="Delete User" class="Action"></a>
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
																					<select name="dropdown" onChange="multiple_action('user_form');">
																						<option value="">Choose an action...</option>
																						<option value="Active">Active</option>
																						<option value="Inactive">Inactive</option>
																						<?php
																						if ($top_users_module_delete == 'Yes') {
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
			<td height="20">
				@include("admin.common.footer")
			</td>
		</tr>
		</tbody>
	</table>
	<!-- End pagefooter -->
</body>

</html>