@include("admin.includes.top")
@include("admin.common.security")
<?php
// include("../common/thumbnail.class");

error_reporting(0);

function get_data($url)
{
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}


function clean($string)
{

	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	return preg_replace('/[^A-Za-z0-9\-]/', '-', $string); // Removes special chars.

}
// function remove_spl_char($string)
// {

// 	$string = str_replace("'", '&#39;', $string); // Replaces all spaces with hyphens.
// 	$string = str_replace('"', '&#34;', $string);
// 	return utf8_encode($string);
// }


function check_content_exist($artist_name)
{
	ini_set('allow_url_fopen ', 'ON');
	$artist_url = "http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=" . ($artist_name) . "&api_key=36cd9613641f2d9868a85377850aced5&format=json";

	$artistdata = get_data($artist_url);
	$artist_data = json_decode($artistdata);

	if (!$artist_data->error && $artist_data->artist) {
		return true;
	}
}




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
		$orderby = "ORDER BY id ASC ";
		break;
}

/*================== Search Filter Start Here=================*/
if (isset($_POST['filter'])) {


	$sess_where = "";

	//$_SESSION['artist_itunesid_sess']

	if ($_REQUEST['artist_itunesid'] != "") {

		$sess_where .= " and id  = " . $_REQUEST['artist_itunesid'] . "";
		//$sess_where .= " and artist_name  like \"".trim($_REQUEST['artist_name'])."%\" ";
		session()->put('artist_itunesid_sess', $_REQUEST['artist_itunesid']);

		//New code
		// $where_search = "where id ".$_REQUEST['artist_name']."";
		//	 session()->get('where_query') = $where_search;

	} else {
		session()->put('artist_itunesid_sess', null);
	}

	if ($_REQUEST['artist_name'] != "") {
		//$sess_where .= " and artist_name  like \"%".trim($_REQUEST['artist_name'])."%\" ";
		$sess_where .= " and  MATCH (artist_name) AGAINST ('*" . trim($_REQUEST['artist_name']) . "*' IN BOOLEAN MODE) ";
		session()->put('artist_name_sess', trim($_REQUEST['artist_name']));


		//New code
		// $where_search = "where artist_name  like \"%".trim($_REQUEST['artist_name'])."%\"";
		// session()->get('where_query') = $where_search;
	} else {
		session()->put('artist_name_sess', null);
	}

	if ($_REQUEST['artist_status'] != "") {
		$sess_where .= " and artist_status = '" . $_REQUEST['artist_status'] . "'";
		session()->put('artist_status', ($_REQUEST['artist_status']));
	} else {
		session()->put('artist_status', null);
	}


	$limit = 20; 					//how many items to show per page
	$start = 0;
	$sr_no = 0;

	//$sess_where .= " and ids > $start $orderby  limit $limit ";
	//session()->get('sess_song_query') = $sess_where;
	//echo "ram1";
	//echo $session_where = session()->get('sess_song_query');



	$sess_where_total = $sess_where;

	$qry_count_mypro = "SELECT id FROM tbl_artists where 1=1 $sess_where_total ";
	$res_count_mypro = array();
	$res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
	if ($res_count_mypro) {
	$total_pages = count($res_count_mypro);
	} else {
	$total_pages = 0;
	} 

	 //your file name  (the name of this file)

	//$orderby = " ORDER BY   artist_status desc , LOCATE('".session()->get('artist_name_sess')."', artist_name) desc ";

	$orderby = "  ORDER BY artist_status desc , CASE WHEN artist_name = '" . session()->get('artist_name_sess') . "' THEN 0  
              WHEN artist_name LIKE '" . session()->get('artist_name_sess') . "%' THEN 1  
              WHEN artist_name LIKE '%" . session()->get('artist_name_sess') . "%' THEN 2  
              WHEN artist_name LIKE '%" . session()->get('artist_name_sess') . "' THEN 3  
              ELSE 4
         END, artist_name ASC ";



	$sess_where .= " and id > $start $orderby limit $limit ";
	session()->put('sess_song_query', $sess_where);
	$_SESSION['sess_song_query_total'] = $sess_where_total;


	$artist_list = "select * from tbl_artists where 1=1 $sess_where";
	// echo " list count count"; echo "</br>";


	$session_where = session()->get('sess_song_query');



	//header("Location:artist_list");

} elseif (isset($page) && !empty($page)) {
	

	$limit = 20;  
	if ($page)
		$start = ($page - 1) * $limit; //first item to display on this page
	else
		$start = 0;


	if (isset($page) && $page != "") {
		$sr_no = ($page * $limit) - $limit;
	} else {
		$sr_no = 0;
	}
	 





	if (session()->get('artist_name_sess') != "") {
		// $sess_artist_name_query .= " and artist_name  like \"%".trim(session()->get('artist_name_sess'))."%\" ";
		$sess_artist_name_query = " and  MATCH (artist_name) AGAINST ('*" . trim(session()->get('artist_name_sess')) . "*' IN BOOLEAN MODE) ";

		//$sess_where .= " and artist_name  like \"".trim($_REQUEST['artist_name'])."%\" ";
		//session()->get('artist_name_sess') = trim($_REQUEST['artist_name']);

		$orderby = "  ORDER BY artist_status desc , CASE WHEN artist_name = '" . session()->get('artist_name_sess') . "' THEN 0  
              WHEN artist_name LIKE '" . session()->get('artist_name_sess') . "%' THEN 1  
              WHEN artist_name LIKE '%" . session()->get('artist_name_sess') . "%' THEN 2  
              WHEN artist_name LIKE '%" . session()->get('artist_name_sess') . "' THEN 3  
              ELSE 4
         END, artist_name ASC ";
	}


	if (session()->get('artist_status') != "") {
		$sess_artist_status_query .= " and artist_status = '" . session()->get('artist_status') . "'";
		//session()->get('artist_status') = $_REQUEST['artist_status'];
	}

	 



	$session_where  = $sess_artist_name_query . $sess_artist_status_query;
	//echo "</br>";

	$qry_count_mypro = "SELECT id FROM tbl_artists where 1=1 $session_where $orderby";
	$res_count_mypro = array();
	$res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
	 
	if ($res_count_mypro) {
		$total_pages = count($res_count_mypro);
	} else {
		$total_pages = 0;
	}
	 //your file name  (the name of this file)




	if (session()->get('artist_name_sess') != "" || session()->get('artist_status') != "") {
		$session_where .= "  $orderby limit $start, $limit ";
	} else {

		$session_where .= " and id > $start $orderby limit $limit ";
	}
	session()->put('sess_song_query', $session_where);
	//echo "ram2";
	$session_where = session()->get('sess_song_query');
	//echo "</br>";
	$artist_list = "select * from tbl_artists where 1=1 $session_where";
	//echo " list count count"; echo "</br>";

} else {

	$limit = 20; 					//how many items to show per page
	$start = 0;
	$sr_no = 0;

	//echo "ram3";
	//$orderby = "ORDER BY ids ASC";
	$sess_where = " $orderby limit $start , $limit ";
	session()->put('sess_song_query', $sess_where);
	$session_where = session()->get('sess_song_query');


	$qry_count_mypro = "SELECT id FROM tbl_artists where 1=1 $orderby";
	$res_count_mypro = array();
	$res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
	if ($res_count_mypro) {
		$total_pages = count($res_count_mypro);
	} else {
		$total_pages = 0;
	}

	 //your file name  (the name of this file)

	$artist_list = "select * from tbl_artists where 1=1 $sess_where";
	//echo " list count count"; echo "</br>";
	//if no page var is given, set start to 0
	//PAGGING CODE ENDS HERE	

}




if (isset($_POST['Reset'])) {
	session()->put('artist_itunesid_sess', null);
	session()->put('artist_name_sess', null);
	session()->put('artist_status', null);
	session()->put('sess_song_query', null);
	session()->put('where_query', null);
	echo '<script>window.location = "/admin/artist_list";</script>';
	// return redirect('admin/artist_list');
}
/*================== Search Filter End Here=================*/





//============================================================
//PAGGING CODE STARTS HERE

//============================================================




$c = 1;

//echo $artist_list="select * from tbl_artists where 1=1 $session_where";	 echo " list count count"; echo "</br>";

// $artist_list_arr	=	$db->get_results($artist_list, ARRAY_A);
$artist_list_arr	=	\App\Models\Songs::GetRawData($artist_list);
// echo '<pre>';
// print_r($artist_list_arr);
// echo '</pre>';
// die;

//============================================================




if (isset($status) && !empty($status)) {
	$status		=	base64_decode($status);

	$status_id	=	base64_decode($status_id);

	if ($status == 1) {
		$sqlquery	=	"update tbl_artists set artist_status='$status' where id='$status_id'";
	} else {
		$sqlquery	=	"update tbl_artists set artist_status='$status' where id='$status_id'";
	}

	$db->query($sqlquery);
	header("Location:artist_list?msg=$update_ok_msg&case=1");
	exit;
}
?>
<html>

<head>
	<title>Artist Listing</title>
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
													<td><a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a> &raquo; <a>Artist Listing</a></td>
												</tr>
												<tr>
													<td>
														<form name="search_form" id="search_form" method="post" action="">
															@csrf
															<table border="0" cellpadding="0" cellspacing="0" align="center" width="500" style="border:1px solid #000000; padding:10px;">
																<tbody>
																	<tr>
																		<td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
																			Search Artist</td>
																	</tr>


																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Artist iTunes id
																		</td>
																		<td align="center">
																			<input name="artist_itunesid" id="artist_itunesid" type="text" class="Field300" value="<?php echo session()->get('artist_itunesid_sess'); ?>" />
																		</td>
																	</tr>


																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Artist
																		</td>
																		<td align="center">
																			<input name="artist_name" id="artist_name" type="text" class="Field300" value="<?php echo session()->get('artist_name_sess'); ?>" />
																		</td>
																	</tr>
																	<tr height="30">
																		<td class="SmallFieldLabelnew font_bold" align="left" width="150">
																			Status
																		</td>
																		<td align="center">
																			<select name="artist_status" id="artist_status" class="Field300">
																				<option value=""> ------- Please Select Status ------- </option>
																				<option value="1" <?php if (session()->get('artist_status') == '1') {
																										echo 'selected="selected"';
																									} ?>>Active</option>
																				<option value="0" <?php if (session()->get('artist_status') == '0') {
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
																	<td colspan="7" width="105" align="right" valign="middle" id="addsymbol">
																		<?php
																		if ($top_artist_module_add == 'Yes' || $_SESSION['reviewsite_cpadmin_type'] == 'admin') {
																		?>
																			<a href="<?php echo SERVER_ADMIN_PATH; ?>addedit_artist"><img src="images/add.png" border="0" title="Add New"></a>
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
																	<td width="30" id="Heading_list">Artist iTunes id</td>
																	<td width="200" id="Heading_list">Image</td>
																	<td width="200" id="Heading_list">
																		<?php if ($sortby == 'artist_desc') { ?>
																			<a href="artist_list?sortby=artist_name_asc&page=<?php echo $page; ?>" class="link_class">Artist</a>
																		<?php } else { ?>
																			<a href="artist_list?sortby=artist_desc&page=<?php echo $page; ?>" class="link_class">Artist</a>
																		<?php } ?>
																	</td>



																	<td width="300" id="Heading_list">Summary</td>

																	<td width="70" id="Heading_list">Popular artist</td>
																	<td width="70" id="Heading_list">
																		<?php if ($sortby == 'statusdesc') { ?>
																			<a href="artist_list?sortby=statusasc&page=<?php echo $page; ?>" class="link_class">Status</a>
																		<?php } else { ?>
																			<a href="artist_list?sortby=statusdesc&page=<?php echo $page; ?>" class="link_class">Status</a>
																		<?php } ?>
																	</td>


																	<td width="200" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
																</tr>

																<form action="<?php echo SERVER_ADMIN_PATH; ?>process/artist_actions" method="post" id="faq_form">
																	@csrf
																	<?php


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


																					/*$req_artist  =  artist_func(urlencode("$artist_name"));
									if($req_artist['artist_array']['image4']!="")
									{
									?>
									 <a href="<?php echo SERVER_ROOTPATH.$artist_seo."-artist.html";?>"><img class="img-responsive" src="<?php echo $req_artist['artist_array']['image4'];?>"  border="0"/></a>
									<?php
										
										
										if($req_artist['artist_array']['image4']!="")
												{
													$image	=	$req_artist['artist_array']['image4'];
													$path			= '../site_upload/artist_images/';
													$time = $sr_no.time();
													$newname = $time.".jpg";	
													
													copy($image,$path.$newname);	
													$icon_orgname = $newname;
													$h_newthumb_name = 'thumb_'.$icon_orgname;	
													$h_small_thumb_name = 'small_thumb_'.$icon_orgname;			
													$h_photo_path = $path.$icon_orgname;
													$h_photothumb_path = $path.$h_newthumb_name;
													$h_dir = $path;
													
													
													$a = new Thumbnail($path.$newname,241,'238',$h_dir.$h_newthumb_name);
													$a->create();
													
													$b = new Thumbnail($path.$newname,50,'50',$h_dir.$h_small_thumb_name);
													// creating thumbnail
													$b->create();
												}
												else
												{
													$newname = "";	
												}
											
										 mysqli_query($db->dbh, "update tbl_artists set artist_img = '$newname' where id = '$id'");		
										 }*/

																					if ($artist_img != "") {
																						$img_artist = album_img_api($artist_img);
																						if ($img_artist != '') { ?>
																							<img src="<?php echo $img_artist; ?>" border="0" width="50" height="50" />
																						<?php } else {
																							//$cacheThumbnail = "/assets/phpthumb/phpThumb?src=".$artist_img."&w=50&h=50&zc=1";
																						?>
																							<!--<img src="<?php echo $cacheThumbnail; ?>" border="0" width="50" height="50" />-->


																							<img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo 'small_thumb_' . $artist_img; ?>" border="0" width="50" height="50" />
																						<?php }
																					} else {
																						?>
																						<img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image.png" border="0" width="50" height="50" />
																					<?php
																					}




																					?>



																				</td>

																				<td nowrap="nowrap" class="SmallFieldLabel" width="200">
																					<a href="view_artist?iTunesid=<?php echo $id; ?>"><?php echo $artist_name; ?></a>
																					&raquo;
																					<a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/preview-artist"; ?>" target="blank">Preview</a>
																				</td>

																				<td nowrap="nowrap" class="SmallFieldLabel" width="300">

																					<?php

																					echo substr($artist_description, 0, 200);

																					?>

																				</td>
																				<td nowrap="nowrap" class="SmallFieldLabel" width="70">
																					<?php
																					if ($popular_artist == 0) {
																						echo "No";
																					}
																					if ($popular_artist == 1) {
																						echo "Yes";
																					} ?>
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
																						echo '<a href="artist_list?status=' . base64_encode(1) . '&status_id=' . base64_encode($id) . '"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>';
																					}
																					if ($status == 1) {
																						echo '<a href="artist_list?status=' . base64_encode(0) . '&status_id=' . base64_encode($id) . '"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>';
																					}
																					?></td>


																				<td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70">
																					&nbsp;&nbsp; <input type="checkbox" class="check-all" name="ids[]" id="ids[]" value="<?php echo base64_encode($id); ?>" style="margin-top:-5px;" />
																					&nbsp;&nbsp;
																					<?php
																					if ($top_artist_module_add == 'Yes' || $_SESSION['reviewsite_cpadmin_type'] == 'admin') {
																					?>
																						<a href="addedit_artist?edit_id=<?php echo base64_encode($id); ?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>
																					<?php
																					}
																					?>

																					<?php
																					if ($top_album_module == 'Yes' || $_SESSION['reviewsite_cpadmin_type'] == 'admin') {
																					?>
																						<a href="artist_album_list?artist_id=<?php echo base64_encode($id); ?>">Album</a>
																					<?php
																					}
																					?>
																					&nbsp;
																					<a href="artist_featured_songs_list?artist_id=<?php echo base64_encode($id); ?>"><img src="images/featured_in.jpg" border="0" title="Artist Featured In" class="Action"></a>

																					<?php
																					if ($top_artist_module_delete == 'Yes') {
																					?>
																						&nbsp; &nbsp;
																						<a href="javascript:;" onClick="delete_artist('<?php echo $id; ?>')"><img src="images/delet.gif" border="0" title="Delete Artist" class="Action"></a>
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
																			<td colspan="7" nowrap="nowrap" class="SmallFieldLabel righttd_border">
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
																						}
																						?>
																						<option value="popular_artist">Popular Artist</option>
																						<option value="not_popular_artist">Not Popular Artist</option>
																					</select>
																				</span>
																			</td>
																		</tr>
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