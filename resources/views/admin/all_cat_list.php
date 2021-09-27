<?php 
include("includes/top.php");
include("common/security.php"); 
/*================== Search Filter Start Here=================*/
if(isset($_POST['filter']))
{
	$sess_where = "";
	if($_REQUEST['cat_name']!="")
	{
		 $sess_where .= " and cat_name like \"%".trim($_REQUEST['cat_name'])."%\" ";
		 $_SESSION['sub_cat_name_sess'] = trim($_REQUEST['cat_name']);
	}
	else
	{
		unset($_SESSION['sub_cat_name_sess']);
	}
	if($_REQUEST['level1_id']!="")
	{
		 $sess_where .= " and root_parent_id = '".$_REQUEST['level1_id']."' ";
		 $_SESSION['level1_id_session'] = trim($_REQUEST['level1_id']);
	}
	else
	{
		unset($_SESSION['level1_id_session']);
	}
	
	if($_REQUEST['level2_id']!="")
	{
		 $sess_where .= " and plevel2 = '".$_REQUEST['level2_id']."' ";
		 $_SESSION['level2_id_session'] = trim($_REQUEST['level2_id']);
	}
	else
	{
		unset($_SESSION['level2_id_session']);
	}
	
	if($_REQUEST['level3_id']!="")
	{
		 $sess_where .= " and plevel3 = '".$_REQUEST['level3_id']."' ";
		 $_SESSION['level3_id_session'] = trim($_REQUEST['level3_id']);
	}
	else
	{
		unset($_SESSION['level3_id_session']);
	}
	
	if($_REQUEST['level4_id']!="")
	{
		$sess_where .= " and cat_id = '".$_REQUEST['level4_id']."' ";
		 $_SESSION['level4_id_session'] = trim($_REQUEST['level4_id']);
	}
	else
	{
		unset($_SESSION['level4_id_session']);
	}
	
	if($_REQUEST['search_label']!="")
	{
		 $sess_where .= " and search_label like \"%".trim($_REQUEST['search_label'])."%\" ";
		 $_SESSION['sub_search_label_sess'] = trim($_REQUEST['search_label']);
	}
	else
	{
		unset($_SESSION['sub_search_label_sess']);
	}
	
	
	if($_REQUEST['search_name']!="")
	{
		 $sess_where .= " and search_name like \"%".trim($_REQUEST['search_name'])."%\" ";
		 $_SESSION['sub_search_name_sess'] = trim($_REQUEST['search_name']);
	}
	else
	{
		unset($_SESSION['sub_search_name_sess']);
	}
	
	if($_REQUEST['sub_cat_name_status'] != "")
	{
		$sess_where .= " and status = '".$_REQUEST['sub_cat_name_status']."'";
		$_SESSION['sub_cat_name_status'] = $_REQUEST['sub_cat_name_status'];
	}
	else
	{
		unset($_SESSION['sub_cat_name_status']);
	}
	$_SESSION['sub_category_sess'] = $sess_where;
	
	header("Location:all_cat_list.php");
}
 $session_where = $_SESSION['sub_category_sess'];
if(isset($_POST['Reset']))
{
	unset($_SESSION['sub_cat_name_sess']);
	$_SESSION['sub_cat_name_sess']="";
	
	unset($_SESSION['level1_id_session']);
	$_SESSION['level1_id_session']="";
	
	unset($_SESSION['level2_id_session']);
	$_SESSION['level2_id_session']="";
	
	unset($_SESSION['level3_id_session']);
	$_SESSION['level3_id_session']="";
	
	unset($_SESSION['level4_id_session']);
	$_SESSION['level4_id_session']="";
	
	unset($_SESSION['sub_search_label_sess']);
	$_SESSION['sub_search_label_sess']="";
	
	unset($_SESSION['sub_search_name_sess']);
	$_SESSION['sub_search_name_sess']="";
	
	unset($_SESSION['sub_cat_name_status']);
	$_SESSION['sub_cat_name_status']="";

	unset($_SESSION['sub_category_sess']);
	$_SESSION['sub_category_sess']="";
	
	header("Location:all_cat_list.php");
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch($sortby)
{
	case "cat_name_desc":
		$orderby	= " ORDER BY cat_name desc";
	break;
	
	case "cat_name_asc":
		$orderby	= " ORDER BY cat_name asc";
	break;
	
	case "parent_id_desc":
		$orderby	= " ORDER BY parent_id desc";
	break;
	
	case "parent_id_asc":
		$orderby	= " ORDER BY parent_id asc";
	break;
	
	case "search_label_desc":
		$orderby	= " ORDER BY search_label desc";
	break;
	
	case "search_label_asc":
		$orderby	= " ORDER BY search_label asc";
	break;
	
	case "search_name_desc":
		$orderby	= " ORDER BY search_name desc";
	break;
	
	case "search_name_asc":
		$orderby	= " ORDER BY search_name asc";
	break;
	
	case "statusdesc":
		$orderby	= " ORDER BY status desc";
	break;
	
	case "statusasc":
		$orderby	= " ORDER BY status asc";
	break;		
	
	default:
		$orderby = "ORDER BY cat_name asc";
	break;
}
	
	
if(isset($status) && !empty($status))
{
	$status		=	base64_decode($status);
	
	$status_id	=	base64_decode($status_id);
	
	if($status == 1)
	{
		$sqlquery	=	"update tbl_categories set status='$status' where cat_id='$status_id'";
	}
	else
	{
		$sqlquery	=	"update tbl_categories set status='$status' where cat_id='$status_id'";
	}
	
	$db->query($sqlquery);
	header("Location:all_cat_list.php?msg=$update_ok_msg&case=1");
	exit;
}
?>
<html>
<head>
<title>Sub Category Listing</title>
<?php include("common/header.php");?>
<script language="javascript" type="text/javascript">
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
                        <td class="heading1">Sub Category Listing</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a>Sub Category Listing</a></td>
                              </tr>
                              <tr>
                                <td>
                                	<form name="search_form" id="search_form" method="post" action="">
                                    <table border="0" cellpadding="0" cellspacing="0" align="center" width="500" 
                                    style="border:1px solid #000000; padding:10px;">
                                        <tbody>
                                            <tr>
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    Search Sub Category
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Category Name
                                                </td>
                                                <td align="center">
                                                    <input name="cat_name" id="cat_name" type="text" class="Field300" 
                                                    value="<?php echo $_SESSION['sub_cat_name_sess']; ?>" />
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Level1 Category
                                                </td>
                                                <td align="center">
                                                    <select name="level1_id" id="level1_id" class="Field300">
                                                    <option value="">--Please Select Level1 Category--</option>	
                                                    <?php															
													$sql_qry="Select cat_id,cat_name from tbl_categories
													where level='1' ";
													$sql_arr = $db->get_results($sql_qry,ARRAY_A);
													if($sql_arr)
													{
														foreach($sql_arr as $val)
														{
															$cat_id = $val['cat_id'];
															$cat_name = stripcslashes(html_entity_decode($val['cat_name']));	
																if($_SESSION['level1_id_session']==$cat_id)
																{
																	$selected= "selected='selected'";
																}
																else
																{
																	$selected= "";
																}
														?>
														<option value="<?php echo $cat_id;?>" <?php echo $selected;?>><?php echo $cat_name;?></option>
															<?php
															}
														}
                                                        ?>
                                                 </select>
                                                </td>
                                            </tr>
                                            
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Level2 Category
                                                </td>
                                                <td align="center">
                                                    <select name="level2_id" id="level2_id" class="Field300">
                                                    <option value="">--Please Select Level2 Category--</option>	
                                                    <?php															
													$sql_qry2="Select cat_id,cat_name from tbl_categories
													where level='2' ";
													$sql_arr2 = $db->get_results($sql_qry2,ARRAY_A);
													if($sql_arr2)
													{
														foreach($sql_arr2 as $val2)
														{
															$cat_id = $val2['cat_id'];
															$cat_name = stripcslashes(html_entity_decode($val2['cat_name']));	
																if($_SESSION['level2_id_session']==$cat_id)
																{
																	$selected= "selected='selected'";
																}
																else
																{
																	$selected= "";
																}
														?>
														<option value="<?php echo $cat_id;?>" <?php echo $selected;?>><?php echo $cat_name;?></option>
															<?php
															}
														}
                                                        ?>
                                                 </select>
                                                </td>
                                            </tr>
                                            
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Level3 Category
                                                </td>
                                                <td align="center">
                                                    <select name="level3_id" id="level3_id" class="Field300">
                                                    <option value="">--Please Select Level3 Category--</option>	
                                                    <?php															
													$sql_qry3="Select cat_id,cat_name from tbl_categories
													where level='3' ";
													$sql_arr3 = $db->get_results($sql_qry3,ARRAY_A);
													if($sql_arr3)
													{
														foreach($sql_arr3 as $val3)
														{
															$cat_id = $val3['cat_id'];
															$cat_name = stripcslashes(html_entity_decode($val3['cat_name']));	
																if($_SESSION['level3_id_session']==$cat_id)
																{
																	$selected= "selected='selected'";
																}
																else
																{
																	$selected= "";
																}
														?>
														<option value="<?php echo $cat_id;?>" <?php echo $selected;?>><?php echo $cat_name;?></option>
															<?php
															}
														}
                                                        ?>
                                                 </select>
                                                </td>
                                            </tr>
                                            
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Level4 Category
                                                </td>
                                                <td align="center">
                                                    <select name="level4_id" id="level4_id" class="Field300">
                                                    <option value="">--Please Select Level 4 Category--</option>	
                                                    <?php															
													$sql_qry3="Select cat_id,cat_name from tbl_categories
													where level='4' ";
													$sql_arr3 = $db->get_results($sql_qry3,ARRAY_A);
													if($sql_arr3)
													{
														foreach($sql_arr3 as $val3)
														{
															$cat_id = $val3['cat_id'];
															$cat_name = stripcslashes(html_entity_decode($val3['cat_name']));	
																if($_SESSION['level4_id_session']==$cat_id)
																{
																	$selected= "selected='selected'";
																}
																else
																{
																	$selected= "";
																}
														?>
														<option value="<?php echo $cat_id;?>" <?php echo $selected;?>><?php echo $cat_name;?></option>
															<?php
															}
														}
                                                        ?>
                                                 </select>
                                                </td>
                                            </tr>
                                            
                                            
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Status
                                                </td>
                                                <td align="center">
                                                <select name="sub_cat_name_status" id="sub_cat_name_status" class="Field300">
                                                    <option value=""> ------- Please Select Status ------- </option>
                                                    <option value="1" <?php if($_SESSION['sub_cat_name_status'] == '1'){ echo 'selected="selected"';}?>>Active</option>
                                                    <option value="0" <?php if($_SESSION['sub_cat_name_status'] == '0'){ echo 'selected="selected"';}?>>Block</option>	
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
                                        <td colspan="8">
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
										  <td colspan="8" width="105" align="right" valign="middle" id="addsymbol" >
											<a href="<?php echo SERVER_ADMIN_PATH; ?>add_sub_cat.php"><img src="images/add.png" border="0" title="Add New Subject"></a>
                                          </td>
									  </tr>
									  
									  <tr><td colspan="8">&nbsp;</td></tr>
                                      <tr>
                                        <td width="30" id="Heading_list">Sr #</td>
                                        <td width="300" id="Heading_list">
                                        <?php if($sortby == 'cat_name_desc'){?>
                                        <a href="all_cat_list.php?sortby=cat_name_asc&page=<?php echo $page;?>" class="link_class">Category Name</a>
                                        <?php }else{?>
                                        <a href="all_cat_list.php?sortby=cat_name_desc&page=<?php echo $page;?>" class="link_class">Category Name</a>
                                        <?php }?>
                                        </td>
                                        <td width="70" id="Heading_list">
                                        <?php if($sortby == 'statusdesc'){?>
                                        <a href="all_cat_list.php?sortby=statusasc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }else{?>
                                        <a href="all_cat_list.php?sortby=statusdesc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }?>
                                        </td>
                                        <td width="97" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH;?>process/sub_cat_actions.php" method="post" id="sub_categories_form">
									  <?php
											
											//============================================================
											//PAGGING CODE STARTS HERE
											$qry_count_mypro = "SELECT cat_id FROM tbl_categories where 1=1 and 
											(level=2 or level=3 or level=4)  $session_where  $orderby";
											$res_count_mypro = mysqli_query($db->dbh, $qry_count_mypro);
												
											$targetpage = "all_cat_list.php"; //your file name  (the name of this file)
											
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

										$cat_list="select * from tbl_categories where 1=1 and (level=2 or level=3 
										or level=4) $session_where $orderby LIMIT $start, $limit";	
											
										$cat_list_arr	=	$db->get_results($cat_list,ARRAY_A);
										
										if(isset($cat_list_arr))
										{
											foreach($cat_list_arr as $val)
											{
												$cat_id	   	   = $val['cat_id'];	
												$parent_id 	   = $val['parent_id'];	
												$cat_name      = stripslashes(html_entity_decode($val['cat_name']));
												$search_label  = stripslashes(html_entity_decode($val['search_label']));
												$search_name   = stripslashes(html_entity_decode($val['search_name']));				
												$status            = $val['status'];
												$is_featured_topic = $val['is_featured_topic'];
												$cat_name     = wordwrap($cat_name,100," ",true);
												$search_label = wordwrap($search_label,100," ",true);
												$search_name  = wordwrap($search_name,100," ",true);
												if($c%2==0)
												{
													$bgcolor = "#FEFEE4";
												}
												else
												{
													$bgcolor = "#FFFFFF";	
												}
												
												include("cat_hierarchy.php");
												$subcat_qry  = "select cat_name as parent_name from tbl_categories 
												where cat_id='".$parent_id."' ";	
												$catval		 = $db->get_row($subcat_qry,ARRAY_A);
												$parent_name = stripslashes(html_entity_decode($catval['parent_name']));
												$parent_name = wordwrap($parent_name,100," ",true);
												$c++;
												$sr_no++;
										?>
									  
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $cat_id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $cat_id;?>')" id="row<?php echo $cat_id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no;?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="300">
											<strong><?php echo $cat_name;?></strong>
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
												echo '<a href="all_cat_list.php?status='.base64_encode(1).'&status_id='.base64_encode($cat_id).'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
											}
											if($status==1)
											{
												echo '<a href="all_cat_list.php?status='.base64_encode(0).'&status_id='.base64_encode($cat_id).'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
											}
										  ?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="97"> 
    &nbsp;&nbsp; <input type="checkbox" class="check-all" name="cat_ids[]" id="cat_ids[]" value="<?php echo base64_encode($cat_id);?>" style="margin-top:-5px;" />
										&nbsp;&nbsp;
                                        <?php
										if($top_categories_module_add=='Yes')
										{
										?>	
                                        <a href="edit_sub_category.php?edit_id=<?php echo base64_encode($cat_id);?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>
                                        <?php
										}
										?>
										<?php
										if($top_categories_module_delete=='Yes')
										{
										?>
                                        &nbsp; &nbsp;
                                        <a href="javascript:;" onClick="delete_sub_cat('<?php echo $cat_id;?>')"><img src="images/delet.gif" border="0" title="Delete User" class="Action" ></a>
                                        <?php
										}
										?>
                                        </td>
                                      </tr>
                                      <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $cat_id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $cat_id;?>')" id="row<?php echo $cat_id;?>">
                                        </tr>
                                      <?php
											}
										}
										else
										{
									?>
                                      
									  <tr>
                                        <td colspan="8" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
                                      </tr>
                                      <?php	
										}
									  ?>
                                      <?php
									  if($total_pages > 0)
									  {
									  ?>
									  <tr>
                                        <td colspan="8" nowrap="nowrap" class="SmallFieldLabel righttd_border">
                                        <span style="float:right; padding-bottom:10px; margin-right:8px;">
                                            <select name="dropdown" onChange="multiple_action('sub_cat_frm');">
                                                <option value="">Choose an action...</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <?php
												if($top_categories_module_delete=='Yes')
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
                                        <td colspan="8" align="center" valign="middle"><?php include("common/paging-playlist.php"); ?></td>
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
