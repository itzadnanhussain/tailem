<?php 
include("includes/top.php");
include("common/security.php"); 
/*================== Search Filter Start Here=================*/
if(isset($_POST['filter']))
{
	$sess_where = "";
	
	if($_REQUEST['user_name']!="")
	{
		 $sess_where .= " and user_name like \"%".trim($_REQUEST['user_name'])."%\" ";
		 $_SESSION['user_name_sess'] = trim($_REQUEST['user_name']);
	}
	else
	{
		unset($_SESSION['user_name_sess']);
	}
	
	
	
	if($_REQUEST['country_id']!="")
	{
		 $sess_where .= " and country_id  = '".trim($_REQUEST['country_id'])."' ";
		 $_SESSION['country_id_sess'] = trim($_REQUEST['country_id']);
	}
	else
	{
		unset($_SESSION['country_id_sess']);
	}
	
	if($_REQUEST['user_email']!="")
	{
		
		 $sess_where .= " and user_email  = \"".trim($_REQUEST['user_email'])."\" ";
		 $_SESSION['user_email_sess'] = trim($_REQUEST['user_email']);
	}
	else
	{
		unset($_SESSION['user_email_sess']);
	}
	if($_REQUEST['region']!="")
	{
		 $sess_where .= " and region  like \"%".trim($_REQUEST['region'])."%\" ";
		 $_SESSION['region_sess'] = trim($_REQUEST['region']);
	}
	else
	{
		unset($_SESSION['region_sess']);
	}
	if($_REQUEST['user_status'] != "")
	{
		$sess_where .= " and status = '".$_REQUEST['user_status']."'";
		$_SESSION['user_status_sess'] = $_REQUEST['user_status'];
	}
	else
	{
		unset($_SESSION['user_status_sess']);
	}
	
	if($_REQUEST['is_top_member'] != "")
	{
		$sess_where .= " and is_top_member = '".$_REQUEST['is_top_member']."'";
		$_SESSION['is_top_member_sess'] = $_REQUEST['is_top_member'];
	}
	else
	{
		unset($_SESSION['is_top_member_sess']);
	}
	
	$_SESSION['sess_users'] = $sess_where;
}
 $session_where = $_SESSION['sess_users'];
if(isset($_POST['Reset']))
{
	unset($_SESSION['user_name_sess']);
	$_SESSION['user_name_sess']="";
	
	unset($_SESSION['user_email_sess']);
	$_SESSION['user_email_sess']="";
	
	unset($_SESSION['country_id_sess']);
	$_SESSION['country_id_sess']="";
	
	unset($_SESSION['user_status_sess']);
	$_SESSION['user_status_sess']="";
	
	unset($_SESSION['is_top_member_sess']);
	$_SESSION['is_top_member_sess']="";

	unset($_SESSION['sess_users']);
	$_SESSION['sess_users']="";
	
	unset($_SESSION['region_sess']);
	$_SESSION['region_sess']="";
	
	header("Location:users_list.php");
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch($sortby)
{
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
	
	
if(isset($status) && !empty($status))
{
	$status		=	base64_decode($status);
	
	$status_id	=	base64_decode($status_id);
	
	if($status == 1)
	{
		$sqlquery	=	"update tbl_users set status='$status' where user_id='$status_id'";
	}
	else
	{
		$sqlquery	=	"update tbl_users set status='$status',is_top_member='0' where user_id='$status_id'";
	}
	
	$db->query($sqlquery);
	header("Location:users_list.php?msg=$update_ok_msg&case=1");
	exit;
}

?>
<html>
<head>
<title>Users Listing</title>
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
                        <td class="heading1">Users Listing</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a>Users Listing</a></td>
                              </tr>
                              <tr>
                                <td>
                                	<form name="search_form" id="search_form" method="post" action="">
                                    <table border="0" cellpadding="0" cellspacing="0" align="center" width="500" 
                                    style="border:1px solid #000000; padding:10px;">
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
                                                    <input name="user_name" id="user_name" type="text" class="Field300" 
                                                    value="<?php echo $_SESSION['user_name_sess']; ?>" />
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Email
                                                </td>
                                                <td align="center">
                                                    <input name="user_email" id="user_email" class="Field300" 
                                                    value="<?php echo $_SESSION['user_email_sess']; ?>" type="text"/>
                                                </td>
                                            </tr>
                                           <!-- <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Country
                                                </td>
                                                <td align="center">
                                                  <select name="country_id" id="country_id" class="Field300">
                                                    <option value=""> ------ Please Select Country ------</option>
                                                 <?php
                                                 $select_qry ="select country_id,name from tbl_countries order by 
												 name asc";
                                                 $select_arr = $db->get_results($select_qry,ARRAY_A);
                                                 if($select_arr)
                                                 {
                                                    foreach($select_arr as $val)
                                                    {
                                                        $country_id = $val['country_id'];
                                                        $name	    = html_entity_decode(stripslashes($val['name']));
                                                        if($_SESSION['country_id_sess']==$country_id)
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
                                                 
                                                 <?php	
                                                 }
                                                 ?>
                                                 </select>
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                State/Region
                                                </td>
                                                <td align="center">
                                                    <input name="region" id="region" class="Field300" 
                                                    value="<?php echo $_SESSION['region_sess']; ?>" type="text"/>
                                                </td>
                                            </tr>-->
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Status
                                                </td>
                                                <td align="center">
                                                <select name="user_status" id="user_status" class="Field300">
                                                    <option value=""> ------- Please Select Status ------- </option>
                                                    <option value="1" <?php if($_SESSION['user_status_sess'] == '1'){ echo 'selected="selected"';}?>>Active</option>
                                                    <option value="0" <?php if($_SESSION['user_status_sess'] == '0'){ echo 'selected="selected"';}?>>Block</option>	
                                                 </select>
                                                 </td>
                                            </tr>
                                            
                                          <!--  <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Member Type 
                                                </td>
                                                <td align="center">
                                                <select name="is_top_member" id="is_top_member" class="Field300">
                                                    <option value=""> ------- Please Select Member Type------- </option>
                                                    <option value="1" <?php if($_SESSION['is_top_member_sess'] == '1'){ echo 'selected="selected"';}?>>Top Members</option>
                                                    <option value="0" <?php if($_SESSION['is_top_member_sess'] == '0'){ echo 'selected="selected"';}?>>Other Members</option>	
                                                 </select>
                                                 </td>
                                            </tr>-->
                                            
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
											<a href="<?php echo SERVER_ADMIN_PATH; ?>addedit_user.php"><img src="images/add.png" border="0" title="Add New Subject"></a>
                                          </td>
									  </tr>
									  
									  <tr><td colspan="8">&nbsp;</td></tr>
                                      <tr>
                                        <td width="25" id="Heading_list">Sr #</td>
                                        <td width="150" id="Heading_list">
                                        <?php if($sortby == 'user_name_desc'){?>
                                        <a href="users_list.php?sortby=user_name_asc&page=<?php echo $page;?>" class="link_class">Username</a>
                                        <?php }else{?>
                                        <a href="users_list.php?sortby=user_name_desc&page=<?php echo $page;?>" class="link_class">Username</a>
                                        <?php }?>
                                        </td>
                                        
                                         <td width="150" id="Heading_list">
	                                        Display Name
                                        </td>
                                        
                                        
                                        <td width="150" id="Heading_list">
                                        <?php if($sortby == 'user_email_desc'){?>
                                        <a href="users_list.php?sortby=user_email_asc&page=<?php echo $page;?>" class="link_class">User Email</a>
                                        <?php }else{?>
                                        <a href="users_list.php?sortby=user_email_desc&page=<?php echo $page;?>" class="link_class">User Email</a>
                                        <?php }?>
                                        </td>
                                        
                                     <!--   <td width="100" id="Heading_list">
                                        <?php if($sortby == 'country_desc'){?>
                                        <a href="users_list.php?sortby=country_asc&page=<?php echo $page;?>" class="link_class">Country</a>
                                        <?php }else{?>
                                        <a href="users_list.php?sortby=country_desc&page=<?php echo $page;?>" class="link_class">Country</a>
                                        <?php }?>
                                        </td>
                                        <td width="100" id="Heading_list">
                                        <?php if($sortby == 'region_desc'){?>
                                        <a href="users_list.php?sortby=region_asc&page=<?php echo $page;?>" class="link_class">Region</a>
                                        <?php }else{?>
                                        <a href="users_list.php?sortby=region_desc&page=<?php echo $page;?>" class="link_class">Region</a>
                                        <?php }?>
                                        </td>-->
                                        <td width="50" id="Heading_list">
                                        <?php if($sortby == 'statusdesc'){?>
                                        <a href="users_list.php?sortby=statusasc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }else{?>
                                        <a href="users_list.php?sortby=statusdesc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }?>
                                        </td>
                                        <td width="70" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH;?>process/users_actions.php" method="post" id="user_form">
									  <?php
											//============================================================
											//PAGGING CODE STARTS HERE
											$qry_count_mypro = "SELECT user_id FROM tbl_users where 1=1
											$session_where  $orderby";
											$res_count_mypro = mysqli_query($db->dbh, $qry_count_mypro);
												
											$targetpage = "users_list.php"; //your file name  (the name of this file)
											
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

										$user_list="select * from tbl_users where 1=1 $session_where $orderby 
										LIMIT $start, $limit";	
											
										$user_list_arr	=	$db->get_results($user_list,ARRAY_A);
										
										if(isset($user_list_arr))
										{
											foreach($user_list_arr as $val)
											{
												$user_id	= $val['user_id'];	
												$user_name  = stripslashes(html_entity_decode($val['user_name']));
												$gender 	= $val['gender'];
												$user_email = stripslashes(html_entity_decode($val['user_email']));
												$region     = stripslashes(html_entity_decode($val['region']));
												$country_id = $val['country_id'];
												$status     = $val['status'];
												$is_top_member = $val['is_top_member'];
												$user_name  = wordwrap($user_name,100," ",true);
												
												$select_qry ="select name as country_name from tbl_countries where 
												country_id='".$country_id."' ";
                                                $select_ar  = $db->get_row($select_qry,ARRAY_A);
												$country_name = stripslashes(html_entity_decode($select_ar['country_name']));
												$country_name = wordwrap($country_name,100," ",true);
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
									  
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $user_id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $user_id;?>')" id="row<?php echo $user_id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="25"><?php echo $sr_no;?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="150">
											<?php echo $user_name;?></br></br>
                                            <?php
											/*if($is_top_member==0 && $status==1)
											{
											?>
                                           	 <a href="javascript:;" onClick="set_top_member('<?php echo base64_encode($user_id);?>')">Set as Top Member</a>
                                            <?php
											}
											elseif($is_top_member==1)
											{
											?>
                                           	 <a href="javascript:;" onClick="unset_top_member('<?php echo base64_encode($user_id);?>')">UnSet Top Member</a>
                                            <?php
											}*/
											?> 
                                        </td>
                                        
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="150">
											<?php
												echo $user_name;
												/*$query_data ="select fullname from tbl_social_username where user_id = '$user_id'";
                                                $info_arr = $db->get_results($query_data,ARRAY_A);
												if($info_arr)
												{
													$count_names   =  count($info_arr);
													$mn=1;
													foreach($info_arr as $name_get)
													{
														echo stripslashes($name_get['fullname']);
														if($count_names!=$mn)
														{
															echo ", ";
														}
														$mn++;
													}
												}*/
											?>
                                        </td>    
                                        
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="150">
                                           <?php echo $user_email;?>
                                        </td>
                                       <!-- <td nowrap="nowrap" class="SmallFieldLabel" width="100">
                                           <?php echo $country_name;?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="100">
                                           <?php echo $region;?>
                                        </td>-->
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="50">
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
												echo '<a href="users_list.php?status='.base64_encode(1).'&status_id='.base64_encode($user_id).'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
											}
											if($status==1)
											{
												echo '<a href="users_list.php?status='.base64_encode(0).'&status_id='.base64_encode($user_id).'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
											}
											
											/*if($is_top_member==1)
											{
												echo '<br><br><strong>Top Member</strong>';
											}*/
										  ?>
                                          
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70"> 
    &nbsp;&nbsp; <input type="checkbox" class="check-all" name="user_ids[]" id="user_ids[]" value="<?php echo base64_encode($user_id);?>" style="margin-top:-5px;" />
										&nbsp;&nbsp;	
                                        <?php
										if($top_users_module_add=='Yes')
										{
										?>
                                        <a href="addedit_user.php?edit_id=<?php echo base64_encode($user_id);?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>
                                        <?php	
										}
									    ?>
										&nbsp; &nbsp;
                                        <?php
										if($top_users_module_delete=='Yes')
										{
										?>
                                        <a href="javascript:;" onClick="delete_user('<?php echo $user_id;?>')"><img src="images/delet.gif" border="0" title="Delete User" class="Action" ></a>
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
                                            <select name="dropdown" onChange="multiple_action('user_form');">
                                                <option value="">Choose an action...</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <?php
												if($top_users_module_delete=='Yes')
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
