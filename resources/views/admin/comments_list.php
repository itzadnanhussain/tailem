<?php 
include("includes/top.php");
include("common/security.php"); 
/*================== Search Filter Start Here=================*/
if(isset($_POST['filter']))
{
	$sess_where = "";
	if($_REQUEST['comment_details']!="")
	{
		 $sess_where .= " and comment_details  like \"%".trim($_REQUEST['comment_details'])."%\" ";
		 $_SESSION['comment_details_sess'] = trim($_REQUEST['comment_details']);
	}
	else
	{
		unset($_SESSION['comment_details_sess']);
	}
	
	if($_REQUEST['comment_user_id'] != "")
	{
		$sess_where .= " and comment_user_id = '".$_REQUEST['comment_user_id']."'";
		$_SESSION['comment_user_id_sess'] = $_REQUEST['comment_user_id'];
	}
	else
	{
		unset($_SESSION['comment_user_id_sess']);
	}
	$_SESSION['sess_comments'] = $sess_where;
}
 $session_where = $_SESSION['sess_comments'];
if(isset($_POST['Reset']))
{
	unset($_SESSION['comment_details_sess']);
	$_SESSION['comment_details_sess']="";
	
	unset($_SESSION['comment_user_id_sess']);
	$_SESSION['comment_user_id_sess']="";

	unset($_SESSION['sess_comments']);
	$_SESSION['sess_comments']="";
	
	header("Location:comments_list.php");
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch($sortby)
{
	case "user_desc":
		$orderby	= " ORDER BY comment_user_id desc";
	break;
	
	case "user_asc":
		$orderby	= " ORDER BY comment_user_id asc";
	break;
	
	default:
		$orderby = "ORDER BY comment_id desc";
	break;
}?>
<html>
<head>
<title>Review Comments Listing</title>
<?php include("common/header.php");?>
<script language="javascript" type="text/javascript">
// check boxess submit code
function toggleChecked(comment_status)
{
	$(".check-all").each( function() {
		$(this).attr("checked",comment_status);
	})
}

function multiple_action(frm_id) // for changing multiple comment_status or multiple delete 
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
                        <td class="heading1">Review Comments Listing</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a>Review Comments Listing</a></td>
                              </tr>
                              <tr>
                                <td>
                                	<form name="search_form" id="search_form" method="post" action="">
                                    <table border="0" cellpadding="0" cellspacing="0" align="center" width="500" 
                                    style="border:1px solid #000000; padding:10px;">
                                        <tbody>
                                            <tr>
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    Search Review Comments
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Details
                                                </td>
                                                <td align="center">
                                                <input name="comment_details" id="comment_details" class="Field300" 
                                                value="<?php echo $_SESSION['comment_details_sess'];?>" type="text"/>
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Report User
                                                </td>
                                                <td align="center">
                                               	<select name="comment_user_id" id="comment_user_id" 
                                                style="width:300px;padding:4px 1px;">
                                                   <option value=""> ------ Please Select User ------</option>
                                                     <?php
                                                     $users_qry ="select user_id,user_name from tbl_users where status=1
                                                     order by user_name asc";
                                                     $users_arr = $db->get_results($users_qry,ARRAY_A);
                                                     if($users_arr)
                                                     {
                                                        foreach($users_arr as $val)
                                                        {
                                                            $user_id   = $val['user_id'];
                                                            $user_name = $val['user_name'];
															$user_name = html_entity_decode(stripslashes($user_name));
                                                            if($_SESSION['comment_user_id_sess']==$user_id)
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
                                        <td colspan="5">
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
									  <tr><td colspan="5">&nbsp;</td></tr>
                                      <tr>
                                        <td width="30" id="Heading_list">Sr #</td>
                                        <td width="200" id="Heading_list">
                                        <?php if($sortby == 'user_desc'){?>
                                        <a href="comments_list.php?sortby=user_asc&page=<?php echo $page;?>&key=<?php echo $key;?>" class="link_class">Comment User</a>
                                        <?php }else{?>
                                        <a href="comments_list.php?sortby=user_desc&page=<?php echo $page;?>&key=<?php echo $key;?>" class="link_class">Comment User</a>
                                        <?php }?>
                                        </td>
                                        <td width="300" id="Heading_list">Details</td>
                                        <td width="60" id="Heading_list">Like/Report</td>
                                        <?php
										if($top_reviews_module_delete=="Yes")
										{
										?>
                                        <td width="70" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                        <?php
										}
										?>
                                      </tr>
									  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/review_comment_actions.php" method="post" id="comment_form">
									  <?php
											//============================================================
											//PAGGING CODE STARTS HERE
											$qry_count_mypro = "SELECT comment_id FROM tbl_comments where 1=1
											$session_where $orderby";
											$res_count_mypro = mysqli_query($db->dbh, $qry_count_mypro);
												
											$targetpage = "comments_list.php"; //your file name  (the name of this file)
											
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
											$comment_qry="select * from tbl_comments where 1=1 $session_where $orderby LIMIT $start, $limit";	
											$comment_arr	=	$db->get_results($comment_qry,ARRAY_A);
											if(isset($comment_arr))
											{
												foreach($comment_arr as $val)
												{
												$comment_id	  = $val['comment_id'];	
												$comment_user_id = $val['comment_user_id'];
												$comment_details = $val['comment_details'];
												$comment_status   = $val['comment_status'];
												$details  = stripslashes(html_entity_decode($comment_details));
												$details   = wordwrap($details,100," ",true);
												
												$select_qry ="select user_name from tbl_users where 
												user_id='".$comment_user_id."' ";
                                                $select_ar  = $db->get_row($select_qry,ARRAY_A);
												$user_name = stripslashes(html_entity_decode($select_ar['user_name']));
												$user_name = wordwrap($user_name,100," ",true);
												
												$like_qry ="select count(comment_like_id) as total_likes from 
												tbl_comments_likes where comment_like_comment_id='".$comment_id."' ";
                                                $like_arr  = $db->get_row($like_qry,ARRAY_A);
												$total_likes = $like_arr['total_likes'];
												
												$report_qry ="select count(c_report_id) as total_reports from 
												tbl_comment_report where c_report_comment_id='".$comment_id."' ";
                                                $report_arr  = $db->get_row($report_qry,ARRAY_A);
												$total_reports = $report_arr['total_reports'];
												
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
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $comment_id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $comment_id;?>')" id="row<?php echo $comment_id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no;?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
											<?php echo $user_name;?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="300">
                                            <div id="before_details_div_<?php echo $comment_id;?>"> 
                                            <?php
											if(strlen($details)<=100)
											{
												echo substr($details,0,100);
											}
											else
											{
												echo '<a href="javascript:;" onClick="show_detail('.$comment_id.');" style="text-decoration:none;">'.substr($details,0,100).'</a>&nbsp';
												echo '<a href="javascript:;" onClick="show_detail('.$comment_id.');" style="color:#0000FF;"> <strong>&raquo; More</strong></a>';
											}?>
                                            </div>
                                            <div id="after_details_div_<?php echo $comment_id;?>" style="display:none;"> 
                                            	<?php
													echo '<a href="javascript:;" onClick="show_detail('.$comment_id.');" style="text-decoration:none;">'.$details.'</a>&nbsp;';
													echo '<a href="javascript:;" onClick="show_detail('.$comment_id.');" style="color:#0000FF;"><strong>&raquo; Close </strong></a>';
												?>
                                            </div>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="60">
											likes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= <a href="<?php echo SERVER_ADMIN_PATH;?>comments_likes.php?key=<?php echo base64_encode($comment_id);?><?php echo $url_path?>" style="text-decoration:none;color:#0000FF;"><strong><?php echo $total_likes;?></strong></a><br />
                                            Reports = <a href="<?php echo SERVER_ADMIN_PATH;?>comments_reports.php?key=<?php echo base64_encode($comment_id);?><?php echo $url_path?>" style="text-decoration:none;color:#0000FF;"><strong><?php echo $total_reports;?></strong></a>
                                        </td>
                                    	<input type="hidden" id="reviewsid" name="reviewsid" value="<?php echo $key;?>"/>
                                        <?php
										if($top_reviews_module_delete=="Yes")
										{?>
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70"> 
    &nbsp;&nbsp; <input type="checkbox" class="check-all" name="comment_ids[]" id="comment_ids[]" value="<?php echo base64_encode($comment_id);?>" style="margin-top:-5px;" />&nbsp; &nbsp;
                                         
                                        <a href="edit_comment?edit_id=<?php echo base64_encode($comment_id);?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>&nbsp; &nbsp;
                                        <a href="javascript:;" onClick="delete_review_comment('<?php echo $comment_id;?>')"><img src="images/delet.gif" border="0" title="Delete Comment" class="Action" ></a>
                                        </td>
                                        <?php
										} ?>
                                      </tr>
                                      <?php
											}
										}
										else
										{?>
                                      <tr>
                                        <td colspan="5" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
                                      </tr>
                                      <?php }
									  if($total_pages > 0)
									  {
									  ?>
									  <tr>
                                        <?php
										if($top_reviews_module_delete=="Yes")
										{
										?>
                                        <td colspan="5" nowrap="nowrap" class="SmallFieldLabel righttd_border">
                                        <span style="float:right; padding-bottom:10px; margin-right:8px;">
                                            <select name="dropdown" onChange="multiple_action('comment_form');">
                                                <option value="">Choose an action...</option>
                                                <option value="Delete">Delete</option>
                                            </select>
                                        </span>
                                        </td>
                                        <?php
										}
										?>
                                      </tr>
                                      <?php
									  }
									  ?>
									  <tr>
                                        <td colspan="5" align="center" valign="middle">
											<?php include("common/paging-playlist.php"); ?>
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