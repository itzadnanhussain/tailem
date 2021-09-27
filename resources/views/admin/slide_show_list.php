<?php 
include("includes/top.php");
include("common/security.php"); 
//---------- Ordering ----------//
switch($sortby)
{
	case "title_desc":
		$orderby	= " ORDER BY slideshow_title desc";
	break;
	
	case "title_asc":
		$orderby	= " ORDER BY slideshow_title asc";
	break;
	
	case "position_desc":
		$orderby	= " ORDER BY slideshow_position desc";
	break;
	
	case "position_asc":
		$orderby	= " ORDER BY slideshow_position asc";
	break;
	
	case "statusasc":
		$orderby	= " ORDER BY slideshow_status asc";
	break;		
	
	default:
		$orderby = "ORDER BY slideshow_id desc";
	break;
}
	
	
if(isset($slideshow_status) && !empty($slideshow_status))
{
	$slideshow_status		=	base64_decode($slideshow_status);
	
	$status_id	=	base64_decode($status_id);
	
	if($status == 1)
	{
		$sqlquery	=	"update tbl_slideshow set status='$slideshow_status' where slideshow_id='$status_id'";
	}
	else
	{
		$sqlquery	=	"update tbl_slideshow set status='$slideshow_status' where slideshow_id='$status_id'";
	}
	
	$db->query($sqlquery);
	header("Location:slide_show_list.php?msg=$update_ok_msg&case=1");
	exit;
}
?>
<html>
<head>
<title>Slide Show Listing</title>
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
                        <td class="heading1">Slide Show Listing</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a>Slide Show Listing</a></td>
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
											<a href="<?php echo SERVER_ADMIN_PATH; ?>addedit_slideshow.php"><img src="images/add.png" border="0" title="Add New Subject"></a>
                                          </td>
									  </tr>
									  
									  <tr><td colspan="6">&nbsp;</td></tr>
                                      <tr>
                                        <td width="25" id="Heading_list">Sr #</td>
                                        <td width="150" id="Heading_list">
                                        <?php if($sortby == 'title_desc'){?>
                                        <a href="slide_show_list.php?sortby=title_asc&page=<?php echo $page;?>" class="link_class">Title</a>
                                        <?php }else{?>
                                        <a href="slide_show_list.php?sortby=title_desc&page=<?php echo $page;?>" class="link_class">Title</a>
                                        <?php }?>
                                        </td>
                                        <td width="80" id="Heading_list">
                                        <?php if($sortby == 'position_desc'){?>
                                        <a href="slide_show_list.php?sortby=position_asc&page=<?php echo $page;?>" class="link_class">Position</a>
                                        <?php }else{?>
                                        <a href="slide_show_list.php?sortby=position_desc&page=<?php echo $page;?>" class="link_class">Position</a>
                                        <?php }?>
                                        </td>
                                        <td width="450" id="Heading_list">Image</td>
                                        <td width="80" id="Heading_list">
                                        <?php if($sortby == 'statusdesc'){?>
                                        <a href="slide_show_list.php?sortby=statusasc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }else{?>
                                        <a href="slide_show_list.php?sortby=statusdesc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }?>
                                        </td>
                                        <td width="70" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/slide_show_actions.php" method="post" id="slide_img_form">
									  <?php
											
										//============================================================
										//PAGGING CODE STARTS HERE
										$qry_count_mypro = "SELECT slideshow_id FROM tbl_slideshow $orderby";
										$res_count_mypro = mysqli_query($db->dbh, $qry_count_mypro);
											
										$targetpage = "slide_show_list.php"; 											
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

										$img_list="select slideshow_id,slideshow_title,slideshow_image,slideshow_status
										,slideshow_position from tbl_slideshow $orderby LIMIT $start, $limit";	
											
										$img_list_arr	=	$db->get_results($img_list,ARRAY_A);
										
										if(isset($img_list_arr))
										{
											foreach($img_list_arr as $val)
											{
												$slideshow_id	  = $val['slideshow_id'];	
												$slideshow_title  = $val['slideshow_title'];
												$slideshow_title  = stripslashes(html_entity_decode($slideshow_title));
												$slideshow_status = $val['slideshow_status'];
												$slideshow_title  = wordwrap($slideshow_title,100," ",true);
												$slideshow_image  = $val['slideshow_image'];
												$slideshow_position	  = $val['slideshow_position'];
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
									  
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $slideshow_id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $slideshow_id;?>')" id="row<?php echo $slideshow_id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="25"><?php echo $sr_no;?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="150">
											<?php echo $slideshow_title;?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="70">
											<?php echo $slideshow_position;?>
                                        </td>
                                        
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="450">
                                           <img src="<?php echo SERVER_ROOTPATH;?>site_upload/slideshow_images/<?php echo 'small_thumb_'.$slideshow_image;?>" />
                                        </td>
                                        
                                        
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="80">
										<?php 
										if($slideshow_status==0)
										{
											echo "Blocked"; 
										}
										if($slideshow_status==1)
										{
											echo "Active"; 
										}?>
										  &nbsp;&nbsp;&nbsp;
										  <?php
											if($slideshow_status==0)
											{
												echo '<a href="slide_show_list.php?status='.base64_encode(1).'&status_id='.base64_encode($slideshow_id).'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
											}
											if($slideshow_status==1)
											{
												echo '<a href="slide_show_list.php?status='.base64_encode(0).'&status_id='.base64_encode($slideshow_id).'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
											}
										  ?>
                                         <!-- <br />
                                           <strong>Set At Home Page</strong><input type="radio" name="slide_default" />--> 
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70"> 
    &nbsp;&nbsp; <input type="checkbox" class="check-all" name="slideshow_ids[]" id="slideshow_ids[]" value="<?php echo base64_encode($slideshow_id);?>" style="margin-top:-5px;" />
										&nbsp;&nbsp;
                                        <?php
										if($top_slider_module_add=='Yes')
										{
										?>	
                                        <a href="addedit_slideshow.php?edit_id=<?php echo base64_encode($slideshow_id);?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>
										&nbsp; &nbsp;
                                        <?php
										}
										?>
                                        <?php
										if($top_slider_module_delete=='Yes')
										{
										?>
                                        	<a href="javascript:;" onClick="delete_slideshow('<?php echo $slideshow_id;?>')"><img src="images/delet.gif" border="0" title="Delete Image" class="Action" ></a>
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
                                            <select name="dropdown" onChange="multiple_action('slide_img_form');">
                                                <option value="">Choose an action...</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <?php
												if($top_slider_module_delete=='Yes')
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
