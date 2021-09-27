<?php 
include("includes/top.php");
include("common/security.php"); 
/*================== Search Filter Start Here=================*/
if(isset($_POST['filter']))
{
	$sess_where = "";
	
		
	if($_REQUEST['song_title']!="")
	{
		 //$sess_where .= " and song_title  like \"%".trim($_REQUEST['song_title'])."%\" ";
		 //$_SESSION['song_title_sess'] = trim($_REQUEST['song_title']);
		 
		 //New code
		 $search_var = trim($_REQUEST['song_title']);
		 $sess_where .= " and song_title  like \"".$search_var."%\" ";
		 $where_search = "where song_title  like \"".$search_var."%\"";
		 $_SESSION['where_cond'] = $where_search;
	}
	else
	{
		unset($_SESSION['song_title_sess']);
	}
	
	if($_REQUEST['song_status'] != "")
	{
		$sess_where .= " and song_status = '".$_REQUEST['song_status']."'";
		$_SESSION['song_status'] = $_REQUEST['song_status'];
	}
	else
	{
		unset($_SESSION['song_status']);
	}
	$_SESSION['sess_faq'] = $sess_where;
}
 $session_where = $_SESSION['sess_faq'];
if(isset($_POST['Reset']))
{
	unset($_SESSION['song_title_sess']);
	$_SESSION['song_title_sess']="";
	
	unset($_SESSION['song_status']);
	$_SESSION['song_status']="";

	unset($_SESSION['sess_faq']);
	$_SESSION['sess_faq']="";
	
	//New code
	unset($_SESSION['where_cond']);
	$_SESSION['where_cond'] = "";
	
	header("Location:song_list.php");
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch($sortby)
{
	case "latestdesc":
		$orderby	= " ORDER BY latest desc";
	break;
	
	case "latestasc":
		$orderby	= " ORDER BY latest asc";
	break;	

	case "popularitydesc":
		$orderby	= " ORDER BY popularity desc";
	break;
	
	case "popularityasc":
		$orderby	= " ORDER BY popularity asc";
	break;	
	
	case "ranking_order_asc":
		$orderby	= " ORDER BY ranking_order asc";	
	break;
	
	case "ranking_order_desc":
		$orderby	= " ORDER BY ranking_order desc";	
	break;

	case "statusdesc":
		$orderby	= " ORDER BY song_status desc";
	break;
	
	case "statusasc":
		$orderby	= " ORDER BY song_status asc";
	break;		
	
	default:
		$orderby = "ORDER BY id desc";
	break;
}
	
	
if(isset($status) && !empty($status))
{
	$status		=	base64_decode($status);
	
	$status_id	=	base64_decode($status_id);
	
	if($status == 1)
	{
		$sqlquery	=	"update tbl_songs set song_status='$status' where id='$status_id'";
	}
	else
	{
		$sqlquery	=	"update tbl_songs set song_status='$status' where id='$status_id'";
	}
	
	$db->query($sqlquery);
	header("Location:song_list.php?msg=$update_ok_msg&case=1");
	exit;
}

if(isset($popular) && !empty($popular))
{
	$popular		=	base64_decode($popular);
	
	$status_id	=	base64_decode($status_id);
	
	
	
	if($popular == 1)
	{
		 $count  = mysqli_num_rows(mysqli_query($db->dbh, "select popularity from tbl_songs where popularity = 1"));
		if($count>2)
		{
			header("Location:song_list.php?msg=$popular_error_msg&case=1");
			exit;
		}
		else
		{
			$sqlquery	=	"update tbl_songs set popularity='$popular' where id='$status_id'";
		}
		
	}
	else
	{
		$sqlquery	=	"update tbl_songs set popularity='$popular' where id='$status_id'";
	}
	
	$db->query($sqlquery);
	header("Location:song_list.php?msg=$update_ok_msg&case=1");
	exit;
}
if(isset($latest) && !empty($latest))
{
	$latest		=	base64_decode($latest);
	$status_id	=	base64_decode($status_id);
	$time = time();
	
	if($latest == 1)
	{
		//$count  = mysqli_num_rows(mysqli_query($db->dbh, "select latest from tbl_songs where latest = 1"));
		//if($count>2)
		//{
			//header("Location:song_list.php?msg=$popular_error_msg&case=1");
			//exit;
		//}
		//else
		//{
			//$sqlquery	=	"update tbl_songs set latest='$popular' where id='$status_id'";
		//}
			$sqlquery	=	"update tbl_songs set latest='$latest',timeupdated='".$time."' where id='$status_id'";
		
	}
	else
	{ 	
		$sqlquery	=	"update tbl_songs set latest='$latest',timeupdated='".$time."' where id='$status_id'";
	}
	$db->query($sqlquery);
	header("Location:song_list.php?msg=$update_ok_msg&case=1");
	exit;
}

?>
<html>
<head>
<title>Song Listing</title>
<?php
if($top_song_module=='No')
{
	$target	= SERVER_ADMIN_PATH;
		
?>
<script language="javascript" type="text/javascript">
	window.location = '<?php echo $target;?>';
</script>
<?php
exit;
}
?>
<?php include("common/header.php");?>
<script language="javascript" type="text/javascript">
// check boxess submit code
function toggleChecked(status)
{
	$(".check-all").each( function() {
		$(this).attr("checked",status);
	})
}

function multiple_action(frm_id) // for changing multiple status or multiple delete 
{
	var conBox = confirm("Are you sure,you want to Perform this Action?");
	if(conBox)
	{
		document.forms[frm_id].submit();
	}
	else
	{
		return false;
	}				  
}
function show_detail(id)
{
	$("#before_details_div_"+id).toggle();
	$("#after_details_div_"+id).toggle();
}
</script>
</head>
<body>
<table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">
    <tr>
        <td style="background: #1F3C5C repeat-x;height:60px;" height="60">
            <?php include("common/top_right_menu.php"); ?>
        </td>
    </tr>
    <tr>
      <td valign="top"><table border="0" width="100%">
            <tr>
              <td width="10">&nbsp;</td>
              <td><!-- End page header -->
                <!-- End pageheader -->
                <!-- Start home -->
                <div class="BodyContainer">
                  <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="heading1">Song Listing</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a>Song Listing</a></td>
                              </tr>
                              <tr>
                                <td>
                                	<form name="search_form" id="search_form" method="post" action="">
                                    <table border="0" cellpadding="0" cellspacing="0" align="center" width="500" 
                                    style="border:1px solid #000000; padding:10px;">
                                        <tbody>
                                            <tr>
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    Search Song</td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Song
                                                </td>
                                                <td align="center">
                                                    <input name="song_title" id="song_title" type="text" class="Field300" 
                                                    value="<?php echo $_SESSION['song_title_sess']; ?>" />
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Status
                                                </td>
                                                <td align="center">
                                                <select name="song_status" id="song_status" class="Field300">
                                                    <option value=""> ------- Please Select Status ------- </option>
                                                    <option value="1" <?php if($_SESSION['song_status'] == '1'){ echo 'selected="selected"';}?>>Active</option>
                                                    <option value="0" <?php if($_SESSION['song_status'] == '0'){ echo 'selected="selected"';}?>>Block</option>	
                                                 </select>
                                                 </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150">&nbsp;</td>
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
                                      <?php if(isset($msg) && $msg!=""){ ?>
                                      <tr>
                                        <td colspan="6">
                                            <table border="0" cellpadding="0" cellspacing="0" class="Message">
                                              <tbody>
		                                        <tr>
                                                  <td width="20"><?php if($case==1){ ?>
                                                    <img src="images/success_icon.png" vspace="5" width="18" height="18" hspace="10">
                                                    <?php } ?>
                                                    <?php if($case==2){ ?>
                                                    <img src="images/warning_icon.png" vspace="5" width="18" height="18" hspace="10">
                                                    <?php } ?>
                                                    <?php if($case==3){ ?>
                                                    <img src="images/error_icon.png" vspace="5" width="18" height="18" hspace="10">
                                                    <?php } ?>                                                  </td>
                                                  <td width="100%"><?php echo base64_decode($msg); ?></td>
                                                </tr>
                                              </tbody>
                                            </table>
										</td>
                                      </tr>
                                      <?php } ?>
        							 <?php
									 	if($top_song_module_add=="Yes")
										{
									 ?>
									  <tr>
										  <td colspan="10" width="105" align="right" valign="middle" id="addsymbol" >
											<a href="<?php echo SERVER_ADMIN_PATH; ?>addedit_song.php"><img src="images/add.png" border="0" title="Add New"></a>
                                          </td>
									  </tr>
									  <?php
									  }
									  ?>
									  <tr><td colspan="7">&nbsp;</td></tr>
                                      <tr>
                                        <td width="30" id="Heading_list">Sr #</td>
                                        <!--<td width="200" id="Heading_list">Image</td>-->
                                        <td width="170" id="Heading_list">Song</td>
                                        <td width="100" id="Heading_list">Artist</td>
                                        <td width="140" id="Heading_list">Artist Featured in</td>
                                        <td width="100" id="Heading_list">Albums</td>
                                        <td width="200" id="Heading_list">Summary</td>
									   <td width="100" id="Heading_list">
                                        <?php if($sortby == 'latestdesc'){?>
                                        <a href="song_list.php?sortby=latestasc&page=<?php echo $page;?>" class="link_class">Latest</a>
                                        <?php }else{?>
                                        <a href="song_list.php?sortby=latestdesc&page=<?php echo $page;?>" class="link_class">Latest</a>
                                        <?php }?>
                                        </td>
                                        <td width="100" id="Heading_list">
                                        <?php if($sortby == 'popularitydesc'){?>
                                        <a href="song_list.php?sortby=popularityasc&page=<?php echo $page;?>" class="link_class">Popularity</a>
                                        <?php }else{?>
                                        <a href="song_list.php?sortby=popularitydesc&page=<?php echo $page;?>" class="link_class">Popularity</a>
                                        <?php }?>
                                        </td>
										<td width="70" id="Heading_list">
                                        <?php if($sortby == 'statusdesc'){?>
                                        <a href="song_list.php?sortby=statusasc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }else{?>
                                        <a href="song_list.php?sortby=statusdesc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }?>
                                        </td>
                                        <td width="130" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                      </tr>
        							  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/songs_actions.php" method="post" id="faq_form">
									  <?php
											//============================================================
											//PAGGING CODE STARTS HERE
											if(isset($_SESSION['where_cond']))
											{
											$where = $_SESSION['where_cond'];
											$qry_count_mypro = "SELECT id FROM tbl_songs $where";
											}
											else
											{
											$qry_count_mypro = "SELECT id FROM tbl_songs where 1=1
											$session_where  $orderby";
											}
											$res_count_mypro = mysqli_query($db->dbh, $qry_count_mypro);
												
											$targetpage = "song_list.php"; //your file name  (the name of this file)
											$total_pages = mysqli_num_rows($res_count_mypro);
											
											$limit = 15; 					//how many items to show per page
											$page = $_GET['page'];
											if($page) 
												$start = ($page - 1) * $limit;//first item to display on this page
											else
												$start = 0;					//if no page var is given, set start to 0
											//PAGGING CODE ENDS HERE	
											//============================================================
											if(isset($page) && $page!="")
											{
												$sr_no = ($page*$limit)-$limit;
											}
											else
											{
												$sr_no = 0;
											}
											
											$c=1;
		
										$song_list="select * from tbl_songs where 1=1 $session_where $orderby 
										LIMIT $start, $limit";	
										$song_list_arr	=	$db->get_results($song_list,ARRAY_A);
										
										if(isset($song_list_arr))
										{
											foreach($song_list_arr as $val)
											{
												$id	  = $val['id'];	
												$song_title = stripslashes(html_entity_decode($val['song_title']));
												$picture   = stripslashes(html_entity_decode($val['picture']));
												$description   = stripslashes(html_entity_decode($val['description']));
												$status   = $val['song_status'];
												$latest   = $val['latest'];
												$popularity   = $val['popularity'];
												$posted_date   = $val['posted_date'];
												$ranking_order   = $val['ranking_order'];
												$song_title = wordwrap($song_title,100," ",true);
												if($c%2==0)
												{
													$bgcolor = "#FEFEE4";
												}
												else
												{
													$bgcolor = "#FFFFFF";	
												}
												
												$c++;
												$sr_no++;
											// Get artist list
											$artist_list	=	"select a.id as db_art_id,a.artist_name, a.artist_seo from tbl_artists a, tbl_songs_artist sa where 1=1 AND a.id = sa.artist_id AND sa.song_id = $id order by sa.id asc";	
											$artist_list_arr	=	$db->get_results($artist_list,ARRAY_A);
											
											$qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '".$id."'";
												  $qry_feature_arr = $db->get_results($qry_top_feature_artist,ARRAY_A);
												  $count  = count($qry_feature_arr);
												  $num = 1;
												  $feature_artists = "";
												  if($qry_feature_arr)
												  {
													 foreach($qry_feature_arr as $val_feature)
													 {		
														if($num==$count)
														{
															$feature_artists .= $val_feature['feature_artist'];
														}
														
														else
														{
															$feature_artists .= $val_feature['feature_artist'].", ";
														}
														$num++;
													 }
												  }
										?>
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $id;?>')" id="row<?php echo $id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no;?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="170">
											<?php echo $song_title;?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="100">
                                        <?php
										$counter_art = count($artist_list_arr);
                                        if(isset($artist_list_arr))
											{
												$cr = 0;
												foreach($artist_list_arr as $val_artist)
												{
													$cr++;
													$db_art_id	  = $val_artist['db_art_id'];
													$db_artist_name	  = $val_artist['artist_name'];
													$db_artist_seo	  = $val_artist['artist_seo'];	
													
													if($cr!=$counter_art)
													{
														echo mysqli_escape_string($db->dbh, $db_artist_name).", ";
													}
													else
													{
														echo mysqli_escape_string($db->dbh, $db_artist_name);
													}
												}
											}		
                                          ?>  
                                            </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="100">
										<?php echo $feature_artists;?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="100">
                                        <?php
											  $albums_list="select b.album_title, b.album_seo from   tbl_songs_artist_album saa, tbl_artist_album b where 1=1 AND saa.album_id = b.id AND saa.artist_id = '$db_art_id' AND saa.song_id = '$id' AND saa.display_status = 1";	
											
										$albums_list_arr	= $db->get_results($albums_list,ARRAY_A);
										
										if(isset($albums_list_arr))
										{
										 $g=1;
										  $count_album  = count($albums_list_arr);
										  $album_title = "";
										  foreach($albums_list_arr as $val_album)
										 {
											if($g==$count_album)
											{
												$album_title .= $val_album['album_title'];
											}
											else
											{
												$album_title .= $val_album['album_title'].",";
											}
											$g++;
										 }
										}
										echo $album_title;
										?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
                                          <?php echo substr(strip_tags($description),0,60);?>
                                        </td>
                                        
										<td nowrap="nowrap" class="SmallFieldLabel" width="100">
										  <?php
										  /***** For latest song */
											if($latest==0)
											{
												echo '<a href="song_list.php?latest='.base64_encode(1).'&status_id='.base64_encode($id).'" style="text-decoration:none;">Set as latest</a>'; 
											}
											if($latest==1)
											{
												echo '<a href="song_list.php?latest='.base64_encode(0).'&status_id='.base64_encode($id).'" style="text-decoration:none;">Unset latest</a>'; 
											}
										  ?>
                                       </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="100">
										  <?php
											if($popularity==0)
											{
												echo '<a href="song_list.php?popular='.base64_encode(1).'&status_id='.base64_encode($id).'" style="text-decoration:none;">Set popular</a>'; 
											}
											if($popularity==1)
											{
												echo '<a href="song_list.php?popular='.base64_encode(0).'&status_id='.base64_encode($id).'" style="text-decoration:none;">Unset popular</a>'; 
											}
										  ?></td>
										   <td nowrap="nowrap" class="SmallFieldLabel" width="70">
										<?php 
										if($status==0)
										{
											echo "Blocked"; 
										}
										if($status==1)
										{
											echo "Active"; 
										}?>
										  &nbsp;&nbsp;&nbsp;
										  <?php
											if($status==0)
											{
												echo '<a href="song_list.php?status='.base64_encode(1).'&status_id='.base64_encode($id).'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
											}
											if($status==1)
											{
												echo '<a href="song_list.php?status='.base64_encode(0).'&status_id='.base64_encode($id).'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
											}
										  ?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="130"> 
    	&nbsp;&nbsp; <input type="checkbox" class="check-all" name="ids[]" id="ids[]" value="<?php echo base64_encode($id);?>" style="margin-top:-5px;" />
										&nbsp;&nbsp;	
                                        <?php
										if($top_song_module_add=='Yes')
										{
										?>
                                        <a href="addedit_song.php?edit_id=<?php echo base64_encode($id);?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>
                                         <?php
										}
										if($top_artist_module=='Yes')
										{
											?>
                                            <a href="artist_list_song.php?song_id=<?php echo base64_encode($id);?>" title="Artists against song <?php echo $song_title;?>">Artists</a>
                                            <?php
										}
										?>
                                       <?php
									   	if($top_song_module_delete=='Yes')
										{
											?>
                                             &nbsp; &nbsp;
                                        <a href="javascript:;" onClick="delete_song('<?php echo $id;?>')"><img src="images/delet.gif" border="0" title="Delete Song" class="Action" ></a>
                                            <?php
										}
									   ?>
                                        </td>
                                      </tr>
                                      <?php
											}
										}
										else
										{
									?>
    								  <tr>
                                        <td colspan="10" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
                                      </tr>
                                      <?php	
										}
									  ?>
                                      <?php
									  if($total_pages > 0)
									  {
									  ?>
									  <tr>
                                        <td colspan="10" nowrap="nowrap" class="SmallFieldLabel righttd_border">
                                        <span style="float:right; padding-bottom:10px; margin-right:8px;">
                                            <select name="dropdown" onChange="multiple_action('faq_form');">
                                                <option value="">Choose an action...</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <?php
												if($top_song_module_delete=='Yes')
												{
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
                                        <td colspan="6" align="center" valign="middle"><?php include("common/paging-playlist.php"); ?></td>
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
                          </table></td>
                      </tr>
                  </table>
                </div>
                <!-- End home -->
                <!-- Start pagefooter -->
              </td>
              <td width="10">&nbsp;</td>
            </tr>
          </tbody>
        </table></td>
    </tr>
	<tr>
      <td height="20"><?php include("common/footer.php");?></td>
    </tr>
  </tbody>
</table>
<!-- End pagefooter -->
</body>
</html>