<?php 
include("includes/top.php");
include("common/security.php"); 
/*================== Search Filter Start Here=================*/
if(isset($_POST['filter']))
{
	$sess_where = "";
	
		
	if($_REQUEST['song_title']!="")
	{
		 $sess_where .= " and song_title  like \"%".trim($_REQUEST['song_title'])."%\" ";
		 $_SESSION['song_title_sess'] = trim($_REQUEST['song_title']);
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
	
	header("Location:song_list_ranking.php");
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//



switch($sortby)
{
	case "artist_desc":
		$orderby	= " ORDER BY s.song_title desc";
	break;
	
	case "song_title_asc":
		$orderby	= " ORDER BY s.song_title asc";
	break;	
	
	case "ranking_order_asc":
		$orderby	= " ORDER BY saa.ranking_order asc";	
	break;
	
	case "ranking_order_desc":
		$orderby	= " ORDER BY saa.ranking_order desc";	
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
	header("Location:song_list_ranking.php?msg=$update_ok_msg&case=1");
	exit;
}
?>
<html>
<head>
<title>Song Listing</title>
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
        <td style="background:#1F3C5C; background-repeat:repeat-x; height:60px;" height="60">
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
                        <td class="heading1">Song Rank Listing</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a>Song Rank Listing</a></td>
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
                                        <td colspan="7">
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
                                      
									
									  
									  <tr><td colspan="7">&nbsp;</td></tr>
                                      <tr>
                                        <td width="30" id="Heading_list">Sr #</td>
                                         <!--<td width="200" id="Heading_list">Image</td>-->
                                         <td width="200" id="Heading_list">
                                        <?php if($sortby == 'artist_desc'){?>
                                        <a href="song_list_ranking.php?sortby=song_title_asc&page=<?php echo $page;?>" class="link_class">Song</a>
                                        <?php }else{?>
                                        <a href="song_list_ranking.php?sortby=artist_desc&page=<?php echo $page;?>" class="link_class">Song</a>
                                        <?php }?>
                                        </td>
                                        
                                        <td width="200" id="Heading_list">Artist</td> 
                                        <td width="200" id="Heading_list">Album</td> 
                                        <td width="200" id="Heading_list">Featured in</td> 
                                        
                                        
                                        <td width="70" id="Heading_list">
                                         <?php if($sortby == 'ranking_order_asc'){?>
                                        <a href="song_list_ranking.php?sortby=ranking_order_desc&page=<?php echo $page;?>" class="link_class">Ranking</a>
                                        <?php }else{?>
                                        <a href="song_list_ranking.php?sortby=ranking_order_asc&page=<?php echo $page;?>" class="link_class">Ranking</a>
                                        <?php }?>
                                        </td>
                                        

                                        <td width="200" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/songs_actions.php" method="post" id="faq_form">
									  <?php
											
											//============================================================
											//PAGGING CODE STARTS HERE
											
											
											$song_list_arr = array();
											$song_list = "select saa.ranking_order,s.description,s.song_title,a.artist_name,b.album_title, b.album_picture, saa.song_id, saa.id from tbl_artist_album b, tbl_artists a, tbl_songs_artist_album saa, tbl_songs s where 1=1 AND s.id = saa.song_id AND a.id = saa.artist_id AND b.id = saa.album_id $session_where $orderby";
											
											$song_list_arr	=	$db->get_results($song_list,ARRAY_A);
																								
											$targetpage = "song_list_ranking.php"; //your file name  (the name of this file)
											
											$total_pages = count($song_list_arr);
											
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

										
									  $song_list_arr=array_slice($song_list_arr,$start,$limit);
										
										if(isset($song_list_arr))
										{
											foreach($song_list_arr as $val)
											{
												$id	  = $val['id'];	
												$song_id	  = $val['song_id'];	
												$song_title = stripslashes(html_entity_decode($val['song_title']));
												$picture   = stripslashes(html_entity_decode($val['picture']));
											
												$status   = $val['song_status'];
												$posted_date   = $val['posted_date'];
												$ranking_order   = $val['ranking_order'];
												$song_title = wordwrap($song_title,100," ",true);
												
												
												$album_title = stripslashes(html_entity_decode($val['album_title']));
												$artist_name = stripslashes(html_entity_decode($val['artist_name']));
												$album_picture   = stripslashes(html_entity_decode($val['album_picture']));
												$song_title = stripslashes(html_entity_decode($val['song_title']));
												$album_title = wordwrap($album_title,100," ",true);
												$artist_name = wordwrap($artist_name,100," ",true);
												
												
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
												
											
												
												
												
										
												 
										?>
									  
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $id;?>')" id="row<?php echo $id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no;?></td>
                                        
                                        <!--<td nowrap="nowrap" class="SmallFieldLabel" width="200">
										<?php
											if($picture!="")
											{
												?>
                                                 <img src="<?php echo SERVER_ROOTPATH;?>site_upload/song_images/<?php echo 'small_thumb_'.$picture;?>"  border="0"/>
                                                <?php
											}
											else
											{
												?>
                                                 <img src="<?php echo SERVER_ROOTPATH;?>assets/images/no_image.png"  border="0" width="50" height="50"/>
                                                <?php
											}
											
											
											
										?>	
                                            
                                            
                                           
                                        </td>-->
                                        
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
											<?php echo $song_title;?>
                                        </td>
                                        
                                          <td nowrap="nowrap" class="SmallFieldLabel" width="100">
											<?php echo $artist_name;?>
                                        </td>
                                        
                                          <td nowrap="nowrap" class="SmallFieldLabel" width="100">
											<?php echo $album_title;?>
                                        </td>
                                        
                                          <td nowrap="nowrap" class="SmallFieldLabel" width="100">
											<?php
												$qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '".$song_id."'";
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
												  
												  echo $feature_artists;
											?>
                                        </td>
                                         
                                        
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="70">
                                        	 <input type="text" name="order_<?php echo $id;?>" value="<?php echo $ranking_order;?>" size="3">
                                        </td>

                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="200"> 
                                        
                                       
                                        
    &nbsp;&nbsp; <input type="checkbox" class="check-all" name="ids[]" id="ids[]" value="<?php echo base64_encode($id);?>" style="margin-top:-5px;" />
								
                                        
                                        </td>
                                      </tr>
                                      <?php
											}
										}
										else
										{
									?>
                                      
									  <tr>
                                        <td colspan="6" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
                                      </tr>
                                      <?php	
										}
									  ?>
                                      <?php
									  if($total_pages > 0)
									  {
									  ?>
									  <tr>
                                        <td colspan="9" nowrap="nowrap" class="SmallFieldLabel righttd_border">
                                        <span style="float:right; padding-bottom:10px; margin-right:8px;">
                                            <select name="dropdown" onChange="multiple_action('faq_form');">
                                                <option value="">Choose an action...</option>
                                                <option value="sort_ranking">Sort Ranking</option>
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
