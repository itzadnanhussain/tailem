<?php 
include("includes/top.php");
include("common/security.php"); 
/*================== Search Filter Start Here=================*/

if($_REQUEST['artist_id']!="")
{
	$dec_id = base64_decode($_REQUEST['artist_id']);
	
	$row  =  $db->get_row("select * from tbl_artists where id='".$dec_id."'",ARRAY_A);
	$artist_seo 	= stripslashes(html_entity_decode($row['artist_seo']));
	$artist_name 	= stripslashes(html_entity_decode($row['artist_name']));
	$artist_description 	= stripslashes(html_entity_decode($row['artist_description']));
	$artist_img 	= stripslashes(html_entity_decode($row['artist_img']));
	
}

if(isset($_POST['filter']))
{
	$sess_where = "";
	
		
	if($_REQUEST['album_title']!="")
	{
		 $sess_where .= " and album_title  like \"%".trim($_REQUEST['album_title'])."%\" ";
		 $_SESSION['album_title_sess'] = trim($_REQUEST['album_title']);
	}
	else
	{
		unset($_SESSION['album_title_sess']);
	}
	
	if($_REQUEST['artist_status'] != "")
	{
		$sess_where .= " and artist_status = '".$_REQUEST['artist_status']."'";
		$_SESSION['artist_status'] = $_REQUEST['artist_status'];
	}
	else
	{
		unset($_SESSION['artist_status']);
	}
	$_SESSION['sess_faq'] = $sess_where;
}
 $session_where = $_SESSION['sess_faq'];
if(isset($_POST['Reset']))
{
	unset($_SESSION['album_title_sess']);
	$_SESSION['album_title_sess']="";
	
	unset($_SESSION['artist_status']);
	$_SESSION['artist_status']="";

	unset($_SESSION['sess_faq']);
	$_SESSION['sess_faq']="";
	
	header("Location:artist_album_list.php");
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch($sortby)
{
	case "artist_desc":
		$orderby	= " ORDER BY album_title desc";
	break;
	
	case "album_title_asc":
		$orderby	= " ORDER BY album_title asc";
	break;

	case "statusdesc":
		$orderby	= " ORDER BY artist_status desc";
	break;
	
	case "statusasc":
		$orderby	= " ORDER BY artist_status asc";
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
		$sqlquery	=	"update tbl_artists set artist_status='$status' where id='$status_id'";
	}
	else
	{
		$sqlquery	=	"update tbl_artists set artist_status='$status' where id='$status_id'";
	}
	
	$db->query($sqlquery);
	header("Location:artist_album_list.php?msg=$update_ok_msg&case=1");
	exit;
}
?>
<html>
<head>
<title>Artist <?php echo $artist_name;?> Album Listing</title>
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
                        <td class="heading1">Artist <?php echo $artist_name;?> Album Listing</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> 
                                &raquo; <a href="artist_list">Artist Listing</a>
                                &raquo; <a>Artist <?php echo $artist_name;?> Album Listing</a></td>
                              </tr>
                              <tr>
                                <td>
                                	<form name="search_form" id="search_form" method="post" action="">
                                    <table border="0" cellpadding="0" cellspacing="0" align="center" width="500" 
                                    style="border:1px solid #000000; padding:10px;">
                                        <tbody>
                                            <tr>
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    Search Album</td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Album
                                                </td>
                                                <td align="center">
                                                    <input name="album_title" id="album_title" type="text" class="Field300" 
                                                    value="<?php echo $_SESSION['album_title_sess']; ?>" />
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Status
                                                </td>
                                                <td align="center">
                                                <select name="artist_status" id="artist_status" class="Field300">
                                                    <option value=""> ------- Please Select Status ------- </option>
                                                    <option value="1" <?php if($_SESSION['artist_status'] == '1'){ echo 'selected="selected"';}?>>Active</option>
                                                    <option value="0" <?php if($_SESSION['artist_status'] == '0'){ echo 'selected="selected"';}?>>Block</option>	
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
                                      
									  <tr>
										  <td colspan="6" width="105" align="right" valign="middle" id="addsymbol" >
											<a href="<?php echo SERVER_ADMIN_PATH; ?>addedit_artist_album.php?artist_id=<?php echo $_REQUEST['artist_id'];?>"><img src="images/add.png" border="0" title="Add New"></a>
                                          </td>
									  </tr>
									  
									  <tr><td colspan="7">&nbsp;</td></tr>
                                      <tr>
                                        <td width="30" id="Heading_list">Sr #</td>
                                         <td width="200" id="Heading_list">Image</td>
                                         <td width="200" id="Heading_list">
                                        <?php if($sortby == 'artist_desc'){?>
                                        <a href="artist_album_list.php?sortby=album_title_asc&page=<?php echo $page;?>" class="link_class">Album</a>
                                        <?php }else{?>
                                        <a href="artist_album_list.php?sortby=artist_desc&page=<?php echo $page;?>" class="link_class">Album</a>
                                        <?php }?>
                                        </td>
                                        
                                        
                                        
                                        <td width="300" id="Heading_list">Summary</td>
                                        
                                        <td width="70" id="Heading_list">
                                        <?php if($sortby == 'statusdesc'){?>
                                        <a href="artist_album_list.php?sortby=statusasc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }else{?>
                                        <a href="artist_album_list.php?sortby=statusdesc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }?>
                                        </td>
                                        <td width="106" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/album_actions.php" method="post" id="faq_form">
                                      <input type="hidden" name="artist_id" id="artist_id" value="<?php echo $_REQUEST['artist_id'];?>">
									  <?php
											
											//============================================================
											//PAGGING CODE STARTS HERE
											$qry_count_mypro = "SELECT id FROM tbl_artist_album where 1=1 
											$session_where  $orderby";
											$res_count_mypro = mysqli_query($db->dbh, $qry_count_mypro);
												
											$targetpage = "artist_album_list.php"; //your file name  (the name of this file)
											
											$total_pages = mysqli_num_rows($res_count_mypro);
											
											$limit = 20; 					//how many items to show per page
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

										$artist_list="select * from tbl_artist_album where 1=1 $session_where $orderby 
										LIMIT $start, $limit";	
											
										$artist_list_arr	=	$db->get_results($artist_list,ARRAY_A);
										
										if(isset($artist_list_arr))
										{
											foreach($artist_list_arr as $val)
											{
												$id	  = $val['id'];	
												$album_title = stripslashes(html_entity_decode($val['album_title']));
												$artist_img   = stripslashes(html_entity_decode($val['artist_img']));
												$artist_description   = stripslashes(html_entity_decode($val['artist_description']));
												$status   = $val['artist_status'];
												$posted_date   = $val['posted_date'];
												$album_title = wordwrap($album_title,100," ",true);
												
												
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
                                        
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
										<?php
											if($artist_img!="")
											{
												?>
                                                 <img src="<?php echo SERVER_ROOTPATH;?>site_upload/artist_images/<?php echo 'small_thumb_'.$artist_img;?>"  border="0"/>
                                                <?php
											}
											else
											{
												?>
                                                 <img src="<?php echo SERVER_ROOTPATH;?>assets/images/no_image.png"  border="0" width="50" height="50"/>
                                                <?php
											}
										?>	
                                            
                                            
                                           
                                        </td>
                                        
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
											<?php echo $album_title;?>
                                        </td>
                                         
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="300">
                                          <?php echo $artist_description;?>
                                        </td>
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
												echo '<a href="artist_album_list.php?status='.base64_encode(1).'&status_id='.base64_encode($id).'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
											}
											if($status==1)
											{
												echo '<a href="artist_album_list.php?status='.base64_encode(0).'&status_id='.base64_encode($id).'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
											}
										  ?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70"> 
    &nbsp;&nbsp; <input type="checkbox" class="check-all" name="ids[]" id="ids[]" value="<?php echo base64_encode($id);?>" style="margin-top:-5px;" />
										&nbsp;&nbsp;	
                                        <?php
										if($top_album_module_add=='Yes')
										{
										?>
                                        <a href="addedit_artist_album.php?edit_id=<?php echo base64_encode($id);?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>
										
										 <a href="addedit_artist_album.php?edit_id=<?php echo base64_encode($id);?>&artist_id=<?php echo $_REQUEST['artist_id'];?>">Album</a>
                                         <?php
										}
										?>
                                       
										<?php
										if($top_album_module_delete=='Yes')
										{
										?>
                                        &nbsp; &nbsp;
                                        <a href="javascript:;" onClick="delete_artist('<?php echo $id;?>')"><img src="images/delet.gif" border="0" title="Delete Artist" class="Action" ></a>
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
                                        <td colspan="6" nowrap="nowrap" class="SmallFieldLabel righttd_border">
                                        <span style="float:right; padding-bottom:10px; margin-right:8px;">
                                            <select name="dropdown" onChange="multiple_action('faq_form');">
                                                <option value="">Choose an action...</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <?php
												if($top_faq_module_delete=='Yes')
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
