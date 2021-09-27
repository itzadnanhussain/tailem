<?php 
include("includes/top.php");
include("common/security.php"); 
/*================== Search Filter Start Here=================*/
if(isset($_POST['filter']))
{
	$sess_where = "";
	
	if($_REQUEST['g_review_title']!="")
	{
		 $sess_where .= " and g_review_title like \"%".trim($_REQUEST['g_review_title'])."%\" ";
		 $_SESSION['g_review_title_sess'] = trim($_REQUEST['g_review_title']);
	}
	else
	{
		unset($_SESSION['g_review_title_sess']);
	}
	
	if($_REQUEST['suggestion']!="")
	{
		 $sess_where .= " and g_review_suggestion like \"%".trim($_REQUEST['suggestion'])."%\" ";
		 $_SESSION['g_review_suggestion_sess'] = trim($_REQUEST['suggestion']);
	}
	else
	{
		unset($_SESSION['g_review_suggestion_sess']);
	}
	
	if($_REQUEST['g_review_rating']!="")
	{
		 $sess_where .= " and g_review_rating like \"%".trim($_REQUEST['g_review_rating'])."%\" ";
		 $_SESSION['g_review_rating_sess'] = trim($_REQUEST['g_review_rating']);
	}
	else
	{
		unset($_SESSION['g_review_rating_sess']);
	}
	
	if($_REQUEST['g_review_user_id']!="")
	{
		 $sess_where .= " and g_review_user_id  = '".trim($_REQUEST['g_review_user_id'])."' ";
		 $_SESSION['g_review_user_id_sess'] = trim($_REQUEST['g_review_user_id']);
	}
	else
	{
		unset($_SESSION['g_review_user_id_sess']);
	}
	
	if($_REQUEST['g_review_category']!="")
	{
		 $sess_where .= " and g_review_category like \"%".trim($_REQUEST['g_review_category'])."%\" ";
		 $_SESSION['g_review_category_sess'] = trim($_REQUEST['g_review_category']);
	}
	else
	{
		unset($_SESSION['g_review_category_sess']);
	}

	if($_REQUEST['review_g_status'] != "")
	{
		$sess_where .= " and g_status = '".$_REQUEST['review_g_status']."'";
		$_SESSION['reviews_g_status_sess'] = $_REQUEST['review_g_status'];
	}
	else
	{
		unset($_SESSION['reviews_g_status_sess']);
	}
	
	
	$_SESSION['general_review_sess'] = $sess_where;
}
 $session_where = $_SESSION['general_review_sess'];
if(isset($_POST['Reset']))
{
	unset($_SESSION['g_review_title_sess']);
	$_SESSION['g_review_title_sess']="";
	
	unset($_SESSION['g_review_rating_sess']);
	$_SESSION['g_review_rating_sess']="";
	
	unset($_SESSION['g_review_user_id_sess']);
	$_SESSION['g_review_user_id_sess']="";
	
	unset($_SESSION['g_review_category_sess']);
	$_SESSION['g_review_category_sess']="";
	
	unset($_SESSION['reviews_g_status_sess']);
	$_SESSION['reviews_g_status_sess']="";

	unset($_SESSION['general_review_sess']);
	$_SESSION['general_review_sess']="";
	
	unset($_SESSION['g_review_suggestion_sess']);
	$_SESSION['g_review_suggestion_sess']="";
		
	header("Location:reviews_list_general.php");
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch($sortby)
{
	case "title_desc":
		$orderby	= " ORDER BY g_review_title desc";
	break;
	
	case "title_asc":
		$orderby	= " ORDER BY g_review_title asc";
	break;
	
	case "suggestion_desc":
		$orderby	= " ORDER BY g_review_suggestion desc";
	break;
	
	case "suggestion_asc":
		$orderby	= " ORDER BY g_review_suggestion asc";
	break;
	
	
	case "rating_desc":
		$orderby	= " ORDER BY g_review_rating desc";
	break;
	
	case "rating_asc":
		$orderby	= " ORDER BY g_review_rating asc";
	break;
	
	case "user_id_desc":
		$orderby	= " ORDER BY g_review_user_id desc";
	break;
	
	case "user_id_asc":
		$orderby	= " ORDER BY g_review_user_id asc";
	break;
	
	
	case "cat_id_desc":
		$orderby	= " ORDER BY g_review_category desc";
	break;
	
	case "cat_id_asc":
		$orderby	= " ORDER BY g_review_category asc";
	break;
	
	case "date_desc":
		$orderby	= " ORDER BY g_review_post_date desc";
	break;
	
	case "date_asc":
		$orderby	= " ORDER BY g_review_post_date asc";
	break;
	
	case "statusdesc":
		$orderby	= " ORDER BY g_status desc";
	break;
	case "statusasc":
		$orderby	= " ORDER BY g_status asc";
	break;		
	
	default:
		$orderby = "ORDER BY g_review_id desc";
	break;
}
	
	
if(isset($status) && !empty($status))
{
	$status		=	base64_decode($status);
	
	$status_id	=	base64_decode($status_id);
	
	if($status == 1)
	{
		$sqlquery	=	"update tbl_general_review set g_status='$status' where g_review_id='$status_id'";
	}
	else
	{
		$sqlquery	=	"update tbl_general_review set g_status='$status' where g_review_id='$status_id'";
	}
	
	$db->query($sqlquery);
	header("Location:reviews_list_general.php?msg=$update_ok_msg&case=1");
	exit;
}
?>
<html>
<head>
<title>General Reviews Listing</title>
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
                        <td class="heading1">General Reviews Listing</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a>General Reviews Listing</a></td>
                              </tr>
                              <tr>
                                <td>
                                	<form name="search_form" id="search_form" method="post" action="">
                                    <table border="0" cellpadding="0" cellspacing="0" align="center" width="500" 
                                    style="border:1px solid #000000; padding:10px;">
                                        <tbody>
                                            <tr>
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    Search General Reviews
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Review Title
                                                </td>
                                                <td align="center">
                                                    <input name="g_review_title" id="g_review_title"  class="Field300" 
                                                    value="<?php echo $_SESSION['g_review_title_sess'];?>" type="text" />
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Review Rating
                                                </td>
                                                <td align="center">
                                                <input name="g_review_rating" id="g_review_rating" class="Field300"
                                                value="<?php echo $_SESSION['g_review_rating_sess'];?>" type="text" />
                                                </td>
                                            </tr>
                                             
                                            
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                User Name
                                                </td>
                                                <td align="center">
                                                 <select name="g_review_user_id" id="g_review_user_id" class="Field300">
                                                    <option value=""> ------ Please Select User ------</option>
                                                 <?php
                                                 $users_qry ="select user_id,user_name from tbl_users where status=1
												 order by user_name asc";
                                                 $users_arr = $db->get_results($users_qry,ARRAY_A);
                                                 if($users_arr)
                                                 {
                                                    foreach($users_arr as $val)
                                                    {
                                                        $user_id = $val['user_id'];
                                                        $user_name =html_entity_decode(stripslashes($val['user_name']));
                                                        if($_SESSION['g_review_user_id_sess']==$user_id)
                                                        {
                                                            $selected = "selected='selected'";
                                                        }
                                                        else
                                                        {
                                                            $selected = "";
                                                        }
                                                    ?>
                                                    <option value="<?php echo $user_id;?>" <?php echo $selected;?>><?php echo $user_name;?></option>
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
                                                Suggestion
                                                </td>
                                                <td align="center">
                                                    <input name="suggestion" id="suggestion"  class="Field300" 
                                                    value="<?php echo $_SESSION['g_review_suggestion_sess'];?>" type="text" />
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Category
                                                </td>
                                                <td align="center">
                                            <input name="g_review_category" id="g_review_category" type="text" 
                                            class="Field300" value="<?php echo $_SESSION['g_review_category_sess'];?>"/>
                                                </td>
                                            </tr>
                                            
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Status
                                                </td>
                                                <td align="center">
                                                <select name="review_g_status" id="review_g_status" class="Field300">
                                                    <option value=""> ------- Please Select Status ------- </option>
                                                    <option value="1" <?php if($_SESSION['reviews_g_status_sess'] == '1'){ echo 'selected="selected"';}?>>Active</option>
                                                    <option value="0" <?php if($_SESSION['reviews_g_status_sess'] == '0'){ echo 'selected="selected"';}?>>Block</option>	
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
                                      
									  
									  
									  <tr><td colspan="8">&nbsp;</td></tr>
                                      <tr>
                                        <td width="25" id="Heading_list">Sr #</td>
                                        <td width="150" id="Heading_list">
                                        <?php if($sortby == 'title_desc'){?>
                                        <a href="reviews_list_general.php?sortby=title_asc&page=<?php echo $page;?>" class="link_class">Review Title</a>
                                        <?php }else{?>
                                        <a href="reviews_list_general.php?sortby=title_desc&page=<?php echo $page;?>" class="link_class">Review Title</a>
                                        <?php }?>
                                        </td>
                                        <td width="150" id="Heading_list">
                                        <?php if($sortby == 'suggestion_desc'){?>
                                        <a href="reviews_list_general.php?sortby=suggestion_asc&page=<?php echo $page;?>" class="link_class">Suggestion</a>
                                        <?php }else{?>
                                        <a href="reviews_list_general.php?sortby=suggestion_desc&page=<?php echo $page;?>" class="link_class">Suggestion</a>
                                        <?php }?>
                                        </td>
                                        <td width="70" id="Heading_list">
                                        <?php if($sortby == 'rating_desc'){?>
                                        <a href="reviews_list_general.php?sortby=rating_asc&page=<?php echo $page;?>" class="link_class">Review Rating</a>
                                        <?php }else{?>
                                        <a href="reviews_list_general.php?sortby=rating_desc&page=<?php echo $page;?>" class="link_class">Review Rating</a>
                                        <?php }?>
                                        </td>
                                        <td width="150" id="Heading_list">
                                        <?php if($sortby == 'user_id_desc'){?>
                                        <a href="reviews_list_general.php?sortby=user_id_asc&page=<?php echo $page;?>" class="link_class">User Name</a>
                                        <?php }else{?>
                                        <a href="reviews_list_general.php?sortby=user_id_desc&page=<?php echo $page;?>" class="link_class">User Name</a>
                                        <?php }?>
                                        </td>
                                        
                                        <td width="100" id="Heading_list">
                                        <?php if($sortby == 'cat_id_desc'){?>
                                        <a href="reviews_list_general.php?sortby=cat_id_asc&page=<?php echo $page;?>" class="link_class">Category</a>
                                        <?php }else{?>
                                        <a href="reviews_list_general.php?sortby=cat_id_desc&page=<?php echo $page;?>" class="link_class">Category</a>
                                        <?php }?>
                                        </td>
                                        <td width="100" id="Heading_list">
                                        <?php if($sortby == 'date_desc'){?>
                                        <a href="reviews_list_general.php?sortby=date_asc&page=<?php echo $page;?>" class="link_class">Post Date</a>
                                        <?php }else{?>
                                        <a href="reviews_list_general.php?sortby=date_desc&page=<?php echo $page;?>" class="link_class">Post Date</a>
                                        <?php }?>
                                        </td>
                                        <!--<td width="50" id="Heading_list">
                                        <?php if($sortby == 'statusdesc'){?>
                                        <a href="reviews_list_general.php?sortby=statusasc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }else{?>
                                        <a href="reviews_list_general.php?sortby=statusdesc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }?>
                                        </td>-->
                                        <td width="90" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/greviews_actions.php" method="post" id="greviews_form">
									  <?php
											
											//============================================================
											//PAGGING CODE STARTS HERE
											$qry_count_mypro = "SELECT g_review_id FROM tbl_general_review where 1=1
											and g_review_allocated='No' $session_where  $orderby";
											$res_count_mypro = mysqli_query($db->dbh, $qry_count_mypro);
												
											$targetpage = "reviews_list_general.php"; //your file name  (the name of this file)
											
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

										$reviews_list="select g_review_id, g_review_title,g_review_detail, 
										g_review_rating,g_review_user_id, g_review_ip,g_review_post_date, 
										g_status,g_review_suggestion,g_review_category	from tbl_general_review
										where 1=1 and g_review_allocated='No' $session_where $orderby 
										LIMIT $start, $limit";
										$reviews_list_arr	=	$db->get_results($reviews_list,ARRAY_A);
										
										if(isset($reviews_list_arr))
										{
											foreach($reviews_list_arr as $val)
											{
												$g_review_id	   = $val['g_review_id'];	
												$g_review_title  = stripslashes(html_entity_decode($val['g_review_title']));
												$g_review_rating = $val['g_review_rating'];
												$g_review_detail =stripslashes(html_entity_decode($val['g_review_detail']));
												$g_review_user_id = $val['g_review_user_id'];
												$g_status     	= $val['g_status'];
												$g_review_category = $val['g_review_category'];
												$g_review_category=stripslashes(html_entity_decode($g_review_category));
												$g_review_suggestion = $val['g_review_suggestion'];
												$suggestion = stripslashes(html_entity_decode($g_review_suggestion));
												$suggestion = wordwrap($suggestion,100," ",true);
												$g_review_category = wordwrap($g_review_category,100," ",true);
												$is_popular     = $val['is_popular'];
												$g_review_post_date  = $val['g_review_post_date'];
												$g_review_title  = wordwrap($g_review_title,100," ",true);
												
												$select_qry ="select user_name from tbl_users where 
												user_id='".$g_review_user_id."' ";
                                                $select_ar  = $db->get_row($select_qry,ARRAY_A);
												$user_name = stripslashes(html_entity_decode($select_ar['user_name']));
												$user_name = wordwrap($user_name,100," ",true);
												
												
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
									  
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $g_review_id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $g_review_id;?>')" id="row<?php echo $g_review_id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="25"><?php echo $sr_no;?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="150">
											<?php echo substr($g_review_title,0,100);?>
                                        </td>
                                         <td nowrap="nowrap" class="SmallFieldLabel" width="150">
											<?php echo substr($suggestion,0,100);?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="70">
											<?php echo $g_review_rating;?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="150">
                                           <?php echo substr($user_name,0,80);?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="100">
                                           <?php echo substr($g_review_category,0,80);?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="100">
                                           <?php echo date("d M Y",$g_review_post_date);?>
                                        </td>
                                        <!--<td nowrap="nowrap" class="SmallFieldLabel" width="50">
										<?php 
										if($g_status==0)
										{
											echo "Blocked"; 
										}
										if($g_status==1)
										{
											echo "Active"; 
										}?>
										  &nbsp;&nbsp;&nbsp;
										  <?php
											if($g_status==0)
											{
												echo '<a href="reviews_list_general.php?status='.base64_encode(1).'&status_id='.base64_encode($g_review_id).'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
											}
											if($g_status==1)
											{
												echo '<a href="reviews_list_general.php?status='.base64_encode(0).'&status_id='.base64_encode($g_review_id).'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
											}
										  ?>
                                          
                                        </td>-->
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="90"> 
    &nbsp;&nbsp; <input type="checkbox" class="check-all" name="g_review_ids[]" id="g_review_ids[]" value="<?php echo base64_encode($g_review_id);?>" style="margin-top:-5px;" />
										&nbsp;&nbsp;	
                                        <a href="greview_details.php?key=<?php echo base64_encode($g_review_id);?>"><img src="images/view.jpg" border="0" title="Add" class="Action"></a>&nbsp;
                                        <?php
										if($top_reviews_module_add=="Yes")
										{
										?>
                                        	<a href="allocate_review.php?key=<?php echo base64_encode($g_review_id);?>"><img src="images/add_icon.png" border="0" title="Allocate Review" class="Action" /></a>
                                        <?php
										}
										?>
                                        &nbsp;
                                        <?php
										if($top_reviews_module_delete=="Yes")
										{
										?>
                                        <a href="javascript:;" onClick="delete_review('<?php echo base64_encode($g_review_id);?>')"><img src="images/delet.gif" border="0" title="Delete" class="Action" ></a>
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
                                            <select name="dropdown" onChange="multiple_action('greviews_form');">
                                                <option value="">Choose an action...</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <?php
												if($top_reviews_module_delete=="Yes")
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
