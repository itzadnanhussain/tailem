<?php 
include("includes/top.php");
include("common/security.php"); 
/*================== Search Filter Start Here=================*/
$keys  = $_REQUEST['key'];
$commentsid = base64_decode($keys);
$review = $_REQUEST['review'];
if(isset($_POST['filter']))
{
	$sess_where = "";
	
	if($_REQUEST['comment_like_user_id'] != "")
	{
		$sess_where .= " and comment_like_user_id = '".$_REQUEST['comment_like_user_id']."'";
		$_SESSION['comment_like_user_id_sess'] = $_REQUEST['comment_like_user_id'];
	}
	else
	{
		unset($_SESSION['comment_like_user_id_sess']);
	}
	$_SESSION['sess_comment_likes'] = $sess_where;
}
 $session_where = $_SESSION['sess_comment_likes'];
if(isset($_POST['Reset']))
{
	unset($_SESSION['comment_like_user_id_sess']);
	$_SESSION['comment_like_user_id_sess']="";

	unset($_SESSION['sess_comment_likes']);
	$_SESSION['sess_comment_likes']="";
	
	header("Location:comments_likes.php?key=".$_REQUEST['key']."&review=".$_REQUEST['review']);
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch($sortby)
{
	case "user_desc":
		$orderby	= " ORDER BY comment_like_user_id desc";
	break;
	
	case "user_asc":
		$orderby	= " ORDER BY comment_like_user_id asc";
	break;
	
	case "date_desc":
		$orderby	= " ORDER BY comment_like_date desc";
	break;
	
	case "date_asc":
		$orderby	= " ORDER BY comment_like_date asc";
	break;
	
	default:
		$orderby = "ORDER BY comment_like_id desc";
	break;
}
	
	

?>
<html>
<head>
<title>Comments Reports Listing</title>
<?php include("common/header.php");?>
<script language="javascript" type="text/javascript">
// check boxess submit code
function toggleChecked(comment_like_status)
{
	$(".check-all").each( function() {
		$(this).attr("checked",comment_like_status);
	})
}

function multiple_action(frm_id) // for changing multiple comment_like_status or multiple delete 
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
                        <td class="heading1">Comments Report Listing</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a>&raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>review_comments.php?key=<?php echo $review;?>">Comments Listing</a>&raquo; <a>Comments Report Listing</a></td>
                              </tr>
							  <?php
                              $comments_qry="select comment_details, comment_user_id, comment_cat_id,comment_review_id, 
							  comment_post_date, comment_status, comment_ip from tbl_comments where 
							  comment_id='".$commentsid."' ";
                              $comment_arr	=	$db->get_row($comments_qry,ARRAY_A);
                              if($comment_arr)
                              {
                              ?>
                              <tr>
                                <td>
                                	<form name="search_form" id="search_form" method="post" action="">
                                    <table border="0" cellpadding="0" cellspacing="0" align="center" width="500" 
                                    style="border:1px solid #000000; padding:10px;">
                                        <tbody>
                                            <tr>
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    Search Comment Report
                                                </td>
                                            </tr>
                                            
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Like User
                                                </td>
                                                <td align="center">
                                               	<select name="comment_like_user_id" id="comment_like_user_id" 
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
                                                            if($_SESSION['comment_like_user_id_sess']==$user_id)
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
                                <?php
								
									$comment_details=stripslashes(html_entity_decode($comment_arr['comment_details']));
									$comment_user_id = $comment_arr['comment_user_id'];
									$status     	= $comment_arr['status'];
									$comment_cat_id    = $comment_arr['comment_cat_id'];
									$is_popular     = $comment_arr['is_popular'];
									$comment_post_date  = $comment_arr['comment_post_date'];
									$comment_details  = wordwrap($comment_details,100," ",true);
									
									$select_qry ="select user_name from tbl_users where 
									user_id='".$comment_user_id."' ";
									$select_ar  = $db->get_row($select_qry,ARRAY_A);
									$user_name = stripslashes(html_entity_decode($select_ar['user_name']));
									$user_name = wordwrap($user_name,100," ",true);
									
									$cat_qry ="select cat_name from tbl_categories where 
									cat_id='".$comment_cat_id."' ";
									$cat_arr  = $db->get_row($cat_qry,ARRAY_A);
									$cat_name = stripslashes(html_entity_decode($cat_arr['cat_name']));
									$cat_name = wordwrap($cat_name,100," ",true);
								?>
                                <table border="0" cellpadding="0" cellspacing="0" align="center" class="report_table">
                                        <tbody>
                                            <tr height="50">
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    Comment Details
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Comment Details
                                                </td>
                                                <td align="left"><?php echo $comment_details;?> </td>
                                            </tr>
                                            
                                            
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Review User Name
                                                </td>
                                                <td align="left"><?php echo $user_name;?> </td>
                                            </tr>
                                            
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Category
                                                </td>
                                                <td align="left"><?php echo $cat_name;?> </td>
                                            </tr>
                                            <tr height="30" class="last">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Post Date
                                                </td>
                                                <td align="left"><?php echo date("d M Y",$comment_post_date);?>
                                            </tr>
                                             	
                                            
                                        </tbody>
                                    </table>
                                
                                </td>
                              	
                              </tr>
                              <?php
							  }
							  ?>
                              <tr>
                                <td>
                                <table cellpadding="0" cellspacing="0" class="Panel">
                                    <tbody>
                                      <?php if(isset($msg) && $msg!=""){ ?>
                                      <tr>
                                        <td colspan="4">
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
                                      
									  
									  
									  <tr><td colspan="4">&nbsp;</td></tr>
                                      <tr>
                                        <td width="30" id="Heading_list">Sr #</td>
                                        <td width="200" id="Heading_list">
                                        <?php if($sortby == 'user_desc'){?>
                                        <a href="comments_likes.php?sortby=user_asc&page=<?php echo $page;?>&key=<?php echo $key;?>" class="link_class">Report User</a>
                                        <?php }else{?>
                                        <a href="comments_likes.php?sortby=user_desc&page=<?php echo $page;?>&key=<?php echo $key;?>" class="link_class">Report User</a>
                                        <?php }?>
                                        </td>
                                        <td width="100" id="Heading_list">
                                        <?php if($sortby == 'date_desc'){?>
                                        <a href="comments_likes.php?sortby=date_asc&page=<?php echo $page;?>&key=<?php echo $key;?>" class="link_class">Like Date</a>
                                        <?php }else{?>
                                        <a href="comments_likes.php?sortby=date_desc&page=<?php echo $page;?>&key=<?php echo $key;?>" class="link_class">Like Date</a>
                                        <?php }?>
                                        </td>
                                        
                                        
                                        <?php
										if($top_reviews_module_delete=="Yes")
										{
										?>
                                        <td width="70" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                        <?php
										}
										?>
                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/comment_like_actions.php" method="post" id="comment_like_form">
									  <?php
									  		
											//============================================================
											//PAGGING CODE STARTS HERE
											$qry_count_mypro = "SELECT comment_like_id FROM tbl_comments_likes where 1=1
											and comment_like_comment_id='".$commentsid."' $session_where $orderby";
											$res_count_mypro = mysqli_query($db->dbh, $qry_count_mypro);
												
											$targetpage = "comments_likes.php"; 
											
											$total_pages = mysqli_num_rows($res_count_mypro);
											
											$limit = 10; 					//how many items to show per page
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

										$report_query="select * from tbl_comments_likes where 1=1 and 
										comment_like_comment_id='".$commentsid."' $session_where $orderby 
										LIMIT $start, $limit";	
											
										$report_arr	=	$db->get_results($report_query,ARRAY_A);
										
										if(isset($report_arr))
										{
											foreach($report_arr as $val)
											{
												$comment_like_id	  = $val['comment_like_id'];	
												$comment_like_user_id = $val['comment_like_user_id'];
												$comment_like_status  = $val['comment_like_status'];
												$comment_like_date    = $val['comment_like_date'];
												
												$select_qry ="select user_name from tbl_users where 
												user_id='".$comment_like_user_id."' ";
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
									  
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $comment_like_id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $comment_like_id;?>')" id="row<?php echo $comment_like_id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no;?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
											<?php echo $user_name;?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
											<?php echo date("d M Y",$comment_like_date);?>
                                        </td>
                                    <input type="hidden" id="commentids" name="commentids" value="<?php echo $keys;?>"/>
                                    <input type="hidden" id="reviewsid" name="reviewsid" value="<?php echo $review;?>"/>
                                        <?php
										if($top_reviews_module_delete=="Yes")
										{
										?>
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70"> 
    &nbsp;&nbsp; <input type="checkbox" class="check-all" name="comment_like_ids[]" id="comment_like_ids[]" value="<?php echo base64_encode($comment_like_id);?>" style="margin-top:-5px;" />
    								
										&nbsp; &nbsp;
                                        <a href="javascript:;" onClick="delete_comment_like('<?php echo $comment_like_id;?>')"><img src="images/delet.gif" border="0" title="Delete Report" class="Action" ></a>
                                        </td>
                                        <?php
										}
										?>
                                      </tr>
                                      <?php
											}
										}
										else
										{
									?>
                                      
									  <tr>
                                        <td colspan="4" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
                                      </tr>
                                      <?php	
										}
									  ?>
                                      <?php
									  if($total_pages > 0)
									  {
									  ?>
									  <tr>
                                      	<?php
										if($top_reviews_module_delete=="Yes")
										{
										?>
                                        <td colspan="4" nowrap="nowrap" class="SmallFieldLabel righttd_border">
                                        <span style="float:right; padding-bottom:10px; margin-right:8px;">
                                            <select name="dropdown" onChange="multiple_action('comment_like_form');">
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
                                        <td colspan="4" align="center" valign="middle"><?php include("common/comment_paging.php"); ?></td>
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
