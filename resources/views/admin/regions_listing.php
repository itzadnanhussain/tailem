<?php 
include("includes/top.php");
include("common/security.php"); 
/*================== Search Filter Start Here=================*/
if(isset($_POST['filter']))
{
	$sess_where = "";
	
		
	if($_REQUEST['region_name']!="")
	{
		 $sess_where .= " and region_name  like '%".trim($_REQUEST['country_name'])."%' ";
		 $_SESSION['region_name_sess'] = trim($_REQUEST['region_name']);
	}
	else
	{
		unset($_SESSION['region_name_sess']);
	}
	
	if($_REQUEST['country_id']!="")
	{
		 $sess_where .= " and country_id='".trim($_REQUEST['country_id'])."' ";
		 $_SESSION['region_country'] = trim($_REQUEST['country_id']);
	}
	else
	{
		unset($_SESSION['region_country']);
	}
	
	
	if($_REQUEST['region_status'] != "")
	{
		$sess_where .= " and status = '".$_REQUEST['region_status']."'";
		$_SESSION['region_status'] = $_REQUEST['region_status'];
	}
	else
	{
		unset($_SESSION['region_status']);
	}
	$_SESSION['sess_regions'] = $sess_where;
}
 $session_where = $_SESSION['sess_regions'];
if(isset($_POST['Reset']))
{
	unset($_SESSION['region_name_sess']);
	$_SESSION['region_name_sess']="";
	
	unset($_SESSION['region_country']);
	$_SESSION['region_country']="";
	
	unset($_SESSION['region_status']);
	$_SESSION['region_status']="";

	unset($_SESSION['sess_regions']);
	$_SESSION['sess_regions']="";
	
	header("Location:regions_listing.php");
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch($sortby)
{
	case "region_name_desc":
		$orderby	= " ORDER BY region_name desc";
	break;
	
	case "region_name_asc":
		$orderby	= " ORDER BY region_name asc";
	break;

	case "country_desc":
		$orderby	= " ORDER BY country_id desc";
	break;
	
	case "country_asc":
		$orderby	= " ORDER BY country_id asc";
	break;
	
	case "statusdesc":
		$orderby	= " ORDER BY status desc";
	break;
	
	case "statusasc":
		$orderby	= " ORDER BY status asc";
	break;		
	
	default:
		$orderby = "ORDER BY region_id desc";
	break;
}
	
	
if(isset($status) && !empty($status))
{
	$status		=	base64_decode($status);
	
	$status_id	=	base64_decode($status_id);
	
	if($status == 1)
	{
		$sqlquery	=	"update tbl_regions set status='$status' where region_id='$status_id'";
	}
	else
	{
		$sqlquery	=	"update tbl_regions set status='$status' where region_id='$status_id'";
	}
	
	$db->query($sqlquery);
	header("Location:regions_listing.php?msg=$update_ok_msg&case=1");
	exit;
}
?>
<html>
<head>
<title>Regions Listing</title>
<?php include("common/header.php");?>
<script language="javascript" type="text/javascript">
  function delete_2(id)
  {

	var cd;
	cd=confirm("Are you sure to delete?");
	if(cd){
		window.location.href = "regions_listing.php?delete="+id;
	}
}

// check boxess submit code
function toggleChecked(status)
{
	$(".check-all").each( function() {
		$(this).attr("checked",status);
	})
}

function multiple_action(frm_id) // for changing multiple status or multiple delete 
{
	document.forms[frm_id].submit();		  
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
                        <td class="heading1">Regions Listing</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a>Regions Listing</a></td>
                              </tr>
                              <tr>
                                <td>
                                	<form name="search_form" id="search_form" method="post" action="">
                                    <table border="0" cellpadding="0" cellspacing="0" align="center" width="500" 
                                    style="border:1px solid #000000; padding:10px;">
                                        <tbody>
                                            <tr>
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    Search Regions
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Region Name
                                                </td>
                                                <td align="center">
                                              		<input name="region_name" id="region_name"class="Field300" 
                                                    type="text" value="<?php echo $_SESSION['region_name_sess'];?>"/>
                                                </td>
                                            </tr>
                                            <?php
											if($_REQUEST['country_key']=="")
											{
											?>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Country
                                                </td>
                                                <td align="center">
                                              		<?php
													 $select_qry="select country_id,name from tbl_countries 
													 order by name asc";
													 $select_arr = $db->get_results($select_qry,ARRAY_A);
													 if($select_arr)
													 {
													 ?>
													 <select name="country_id" id="country_id" class="Field300">
														<option value="">---Please Select Country----</option
														><?php
														foreach($select_arr as $val)
														{
															$country_id = $val['country_id'];
															$name	= html_entity_decode(stripslashes($val['name']));
															if($country_id==$_SESSION['region_country'])
															{
																$selected = "selected='selected'";
															}
															else
															{
																$selected = "";
															}
														?>
														<option value="<?php echo $country_id;?>" <?php echo $selected;?>><?php echo $name;?></option>
														<?php
														}
														?>
													 </select>
													 <?php	
													 }
													 ?>
                                                </td>
                                            </tr>
                                            <?php
											}
											?>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Status
                                                </td>
                                                <td align="center">
                                                <select name="region_status" id="region_status" class="Field300">
                                                    <option value=""> ------- Please Select Status ------- </option>
                                                    <option value="1" <?php if($_SESSION['region_status'] == '1'){ echo 'selected="selected"';}?>>Active</option>
                                                    <option value="0" <?php if($_SESSION['region_status'] == '0'){ echo 'selected="selected"';}?>>Block</option>	
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
											<a href="<?php echo SERVER_ADMIN_PATH; ?>addedit_region.php"><img src="images/add.png" border="0" title="Add New Subject"></a>
                                          </td>
									  </tr>
									  
									  <tr><td colspan="7">&nbsp;</td></tr>
                                      <tr>
                                        <td width="30" id="Heading_list">Sr #</td>
                                        <td width="200" id="Heading_list">
                                        <?php if($sortby == 'region_name_desc'){?>
                                        <a href="regions_listing.php?sortby=region_name_asc&page=<?php echo $page;?>" class="link_class">Region Name</a>
                                        <?php }else{?>
                                        <a href="regions_listing.php?sortby=region_name_desc&page=<?php echo $page;?>" class="link_class">Region Name</a>
                                        <?php }?>
                                        </td>
                                        <td width="200" id="Heading_list">
                                        <?php if($sortby == 'country_desc'){?>
                                        <a href="regions_listing.php?sortby=country_asc&page=<?php echo $page;?>" class="link_class">Country Name</a>
                                        <?php }else{?>
                                        <a href="regions_listing.php?sortby=country_desc&page=<?php echo $page;?>" class="link_class">Country Name</a>
                                        <?php }?>
                                        </td>
                                        <td width="70" id="Heading_list">
                                        <?php if($sortby == 'statusdesc'){?>
                                        <a href="regions_listing.php?sortby=statusasc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }else{?>
                                        <a href="regions_listing.php?sortby=statusdesc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }?>
                                        </td>
                                        <td width="70" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/country_actions.php" method="post" id="country_form">
									  <?php
											
											//============================================================
											//PAGGING CODE STARTS HERE
											if($_REQUEST['country_key']!="")
											{
												$get_country_id = base64_decode($_REQUEST['country_key']);
												$qry_count_mypro="SELECT region_id FROM tbl_regions where 
												country_id='".$get_country_id."' and 1=1 $session_where $orderby";
											}
											else
											{
												$qry_count_mypro  = "SELECT region_id FROM tbl_regions where 1=1
											    $session_where  $orderby";
											}

											$res_count_mypro = mysqli_query($db->dbh, $qry_count_mypro);
												
											$targetpage = "regions_listing.php"; 
											
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
										if($_REQUEST['country_key']!="")
										{
											$get_country_id = base64_decode($_REQUEST['country_key']);
											
											$region_list="select region_id,region_name,country_id,status 
											from tbl_regions where country_id='".$get_country_id."' and 1=1 
											$session_where $orderby LIMIT $start, $limit";
										}
										else
										{
											$region_list="select region_id,region_name,country_id,status 
											from tbl_regions where 1=1 $session_where $orderby LIMIT $start, $limit";
										}
										$region_list_arr	=	$db->get_results($region_list,ARRAY_A);
										if(isset($region_list_arr))
										{
											foreach($region_list_arr as $val)
											{
												$region_id	 = $val['region_id'];	
												$region_name = stripslashes(html_entity_decode($val['region_name']));
												$status      = $val['status'];
												$region_name = wordwrap($region_name,200," ",true);
												$country_id	 = $val['country_id'];
												
												$country_qry="select name from tbl_countries where 
												country_id='".$country_id."' ";	
												$country_arr = $db->get_row($country_qry,ARRAY_A);
												$name = stripslashes(html_entity_decode($country_arr['name'])); 
												$name = wordwrap($name,200," ",true);        
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
									  
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $region_id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $region_id;?>')" id="row<?php echo $region_id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no;?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
											<?php echo $region_name;?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
											<?php echo $name;?>
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
										}
										?>
										  &nbsp;&nbsp;&nbsp;
										  <?php
                                            if($status==0)
                                            {
                                                echo '<a href="regions_listing.php?status='.base64_encode(1).'&status_id='.base64_encode($region_id).'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
                                            }
                                            if($status==1)
                                            {
                                                echo '<a href="regions_listing.php?status='.base64_encode(0).'&status_id='.base64_encode($region_id).'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
                                            }
                                          ?>
                                      	</td>
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70"> 
    &nbsp;&nbsp; <input type="checkbox" class="check-all" name="region_ids[]" id="region_ids[]" value="<?php echo base64_encode($region_id);?>" style="margin-top:-5px;" />
										&nbsp;&nbsp;	
                                        <a href="addedit_region.php?edit_id=<?php echo base64_encode($region_id);?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>
										&nbsp; &nbsp;
                                        <a href="javascript:;" onClick="delete_region('<?php echo $region_id;?>')"><img src="images/delet.gif" border="0" title="Delete Record" class="Action" ></a>
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
                                            <select name="dropdown" onChange="multiple_action('country_form');">
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
                                        <td colspan="6" align="center" valign="middle"><?php include("common/region_paging.php"); ?></td>
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
