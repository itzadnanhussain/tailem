<?php 
include("includes/top.php");
include("common/security.php"); 
/*================== Search Filter Start Here=================*/
if($_REQUEST['key']!="")
{
	$keys  = $_REQUEST['key'];
    $catsid = base64_decode($keys);
	$key_where  = " and category_id='".$catsid."'";
	$pagination = 'general_key_paging.php';
	$path       = 'reviews_list_category.php?key='.$_REQUEST['key'].'';
	$sort_path  = 'reviews_list_category.php?key='.$_REQUEST['key'].'&';
	$url_path   = '&review='.$keys;
}
else
{
	$key_where  = "";
	$pagination = 'paging-playlist.php';
	$path       = 'reviews_list_category.php';
	$sort_path  = 'reviews_list_category.php?';
	$url_path   = '';
}

if(isset($_POST['filter']))
{
	$sess_where = "";
	
	if($_REQUEST['review_title']!="")
	{
		 $sess_where .= " and review_title like \"%".trim($_REQUEST['review_title'])."%\" ";
		 $_SESSION['review_title_sess'] = trim($_REQUEST['review_title']);
	}
	else
	{
		unset($_SESSION['review_title_sess']);
	}
	
	if($_REQUEST['review_rating']!="")
	{
		 $sess_where .= " and review_rating = '".trim($_REQUEST['review_rating'])."' ";
		 $_SESSION['review_rating_sess'] = trim($_REQUEST['review_rating']);
	}
	else
	{
		unset($_SESSION['review_rating_sess']);
	}
	
	if($_REQUEST['user_id']!="")
	{
		 $sess_where .= " and review_user_id  = '".trim($_REQUEST['user_id'])."' ";
		 $_SESSION['review_user_id_sess'] = trim($_REQUEST['user_id']);
	}
	else
	{
		unset($_SESSION['review_user_id_sess']);
	}
	
	if($_REQUEST['review_status'] != "")
	{
		$sess_where .= " and status = '".$_REQUEST['review_status']."'";
		$_SESSION['reviews_status_sess'] = $_REQUEST['review_status'];
	}
	else
	{
		unset($_SESSION['reviews_status_sess']);
	}
	
	if($_REQUEST['is_popular']!="")
	{
		 $sess_where .= " and is_popular = '".trim($_REQUEST['is_popular'])."' ";
		 $_SESSION['is_popular_sess'] = trim($_REQUEST['is_popular']);
	}
	else
	{
		unset($_SESSION['is_popular_sess']);
	}
	
	$_SESSION['review_sess'] = $sess_where;
}
 $session_where = $_SESSION['review_sess'];
if(isset($_POST['Reset']))
{
	unset($_SESSION['review_title_sess']);
	$_SESSION['review_title_sess']="";
	
	unset($_SESSION['review_rating_sess']);
	$_SESSION['review_rating_sess']="";
	
	unset($_SESSION['review_user_id_sess']);
	$_SESSION['review_user_id_sess']="";
	
	unset($_SESSION['reviews_status_sess']);
	$_SESSION['reviews_status_sess']="";

	unset($_SESSION['is_popular_sess']);
	$_SESSION['is_popular_sess']="";
	
	unset($_SESSION['review_sess']);
	$_SESSION['review_sess']="";
	
	header("Location:".$path."");
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch($sortby)
{
	case "title_desc":
		$orderby	= " ORDER BY review_title desc";
	break;
	
	case "title_asc":
		$orderby	= " ORDER BY review_title asc";
	break;
	
	case "rating_desc":
		$orderby	= " ORDER BY review_rating desc";
	break;
	
	case "rating_asc":
		$orderby	= " ORDER BY review_rating asc";
	break;
	
	case "user_id_desc":
		$orderby	= " ORDER BY review_user_id desc";
	break;
	
	case "user_id_asc":
		$orderby	= " ORDER BY review_user_id asc";
	break;
	
	
	case "cat_id_desc":
		$orderby	= " ORDER BY category_id desc";
	break;
	
	case "cat_id_asc":
		$orderby	= " ORDER BY category_id asc";
	break;
	
	case "date_desc":
		$orderby	= " ORDER BY review_post_date desc";
	break;
	
	case "date_asc":
		$orderby	= " ORDER BY review_post_date asc";
	break;
	
	case "statusdesc":
		$orderby	= " ORDER BY status desc";
	break;
	case "statusasc":
		$orderby	= " ORDER BY status asc";
	break;		
	
	default:
		$orderby = "ORDER BY review_id desc";
	break;
}
	
	
if(isset($status) && !empty($status))
{
	$status		=	base64_decode($status);
	
	$status_id	=	base64_decode($status_id);
	
	if($status == 1)
	{
		$sqlquery	=	"update tbl_reviews set status='$status' where review_id='$status_id'";
	}
	else
	{
		$sqlquery	=	"update tbl_reviews set status='$status',is_popular='0' where review_id='$status_id'";
	}
	
	$db->query($sqlquery);
	header("Location:".$path."msg=$update_ok_msg&case=1");
	exit;
}
?>
<html>
<head>
<title>Reviews Listing</title>
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
                        <td class="heading1">Reviews Listing</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>sub_cat_list.php">Sub Category Listing</a> &raquo; <a>Reviews Listing</a></td>
                              </tr>
                              <tr>
                                <td>
                                	<form name="search_form" id="search_form" method="post" action="">
                                    <table border="0" cellpadding="0" cellspacing="0" align="center" width="500" 
                                    style="border:1px solid #000000; padding:10px;">
                                        <tbody>
                                            <tr>
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    Search Reviews
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Review Title
                                                </td>
                                                <td align="center">
                                                    <input name="review_title" id="review_title"  class="Field300" 
                                                    value="<?php echo $_SESSION['review_title_sess'];?>" type="text" />
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Review Rating
                                                </td>
                                                <td align="center">
                                                <input name="review_rating" id="review_rating" class="Field300"
                                                value="<?php echo $_SESSION['review_rating_sess'];?>" type="text" />
                                                </td>
                                            </tr>
                                             
                                            
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                User Name
                                                </td>
                                                <td align="center">
                                                  <select name="user_id" id="user_id" class="Field300">
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
                                                        if($_SESSION['review_user_id_sess']==$user_id)
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
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Status
                                                </td>
                                                <td align="center">
                                                <select name="review_status" id="review_status" class="Field300">
                                                    <option value=""> ------- Please Select Status ------- </option>
                                                    <option value="1" <?php if($_SESSION['reviews_status_sess'] == '1'){ echo 'selected="selected"';}?>>Active</option>
                                                    <option value="0" <?php if($_SESSION['reviews_status_sess'] == '0'){ echo 'selected="selected"';}?>>Block</option>	
                                                 </select>
                                                 </td>
                                            </tr>
                                            
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Popular
                                                </td>
                                                <td align="center">
                                                <select name="is_popular" id="is_popular" class="Field300">
                                                    <option value=""> ------- Please Select ------- </option>
                                                    <option value="1" <?php if($_SESSION['is_popular_sess'] == '1'){ echo 'selected="selected"';}?>>Popular</option>
                                                    <option value="0" <?php if($_SESSION['is_popular_sess'] == '0'){ echo 'selected="selected"';}?>>Non Popular</option>	
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
                                        <td colspan="9">
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
										  <td colspan="9" width="105" align="right" valign="middle" id="addsymbol" >
											<a href="<?php echo SERVER_ADMIN_PATH; ?>add_review.php"><img src="images/add.png" border="0" title="Add New Review"></a>
                                          </td>
									  </tr>
									  <tr><td colspan="9">&nbsp;</td></tr>
                                      <tr>
                                        <td width="25" id="Heading_list">Sr #</td>
                                        <td width="150" id="Heading_list">
                                        <?php if($sortby == 'title_desc'){?>
                                        <a href="<?php echo $sort_path;?>sortby=title_asc&page=<?php echo $page;?>" class="link_class">Review Title</a>
                                        <?php }else{?>
                                        <a href="<?php echo $sort_path;?>sortby=title_desc&page=<?php echo $page;?>" class="link_class">Review Title</a>
                                        <?php }?>
                                        </td>
                                        <td width="65" id="Heading_list">
                                        <?php if($sortby == 'rating_desc'){?>
                                        <a href="<?php echo $sort_path;?>sortby=rating_asc&page=<?php echo $page;?>" class="link_class">Review Rating</a>
                                        <?php }else{?>
                                        <a href="<?php echo $sort_path;?>sortby=rating_desc&page=<?php echo $page;?>" class="link_class">Review Rating</a>
                                        <?php }?>
                                        </td>
                                        <td width="150" id="Heading_list">
                                        <?php if($sortby == 'user_id_desc'){?>
                                        <a href="<?php echo $sort_path;?>sortby=user_id_asc&page=<?php echo $page;?>" class="link_class">User Name</a>
                                        <?php }else{?>
                                        <a href="<?php echo $sort_path;?>sortby=user_id_desc&page=<?php echo $page;?>" class="link_class">User Name</a>
                                        <?php }?>
                                        </td>
                                        
                                        <td width="150" id="Heading_list">
                                        <?php if($sortby == 'cat_id_desc'){?>
                                        <a href="<?php echo $sort_path;?>sortby=cat_id_asc&page=<?php echo $page;?>" class="link_class">Category</a>
                                        <?php }else{?>
                                        <a href="<?php echo $sort_path;?>sortby=cat_id_desc&page=<?php echo $page;?>" class="link_class">Category</a>
                                        <?php }?>
                                        </td>
                                        <td width="50" id="Heading_list">
                                        <?php if($sortby == 'date_desc'){?>
                                        <a href="<?php echo $sort_path;?>sortby=date_asc&page=<?php echo $page;?>" class="link_class">Post Date</a>
                                        <?php }else{?>
                                        <a href="<?php echo $sort_path;?>sortby=date_desc&page=<?php echo $page;?>" class="link_class">Post Date</a>
                                        <?php }?>
                                        </td>
                                        <td width="50" id="Heading_list">Likes<br>Comments<br> Reports</td>
                                        <td width="70" id="Heading_list">
                                        <?php if($sortby == 'statusdesc'){?>
                                        <a href="<?php echo $sort_path;?>sortby=statusasc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }else{?>
                                        <a href="<?php echo $sort_path;?>sortby=statusdesc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }?>
                                        </td>
                                        <td width="50" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/reviews_actions.php" method="post" id="reviews_form">
									  <?php
											
											//============================================================
											//PAGGING CODE STARTS HERE
											$qry_count_mypro = "SELECT review_id FROM tbl_reviews where 1=1
											$key_where $session_where  $orderby";
											$res_count_mypro = mysqli_query($db->dbh, $qry_count_mypro);
												
											$targetpage = "reviews_list_category.php"; //your file name  (the name of this file)
											
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

										$reviews_list="select review_id, review_title, review_detail, review_rating, 
										review_user_id, review_ip, category_id, review_post_date, status, is_popular 
										,is_featured from tbl_reviews where 1=1 $session_where $key_where $orderby 
										LIMIT $start, $limit";
										$reviews_list_arr	=	$db->get_results($reviews_list,ARRAY_A);
										
										if(isset($reviews_list_arr))
										{
											foreach($reviews_list_arr as $val)
											{
												$review_id	   = $val['review_id'];	
												$review_title  = stripslashes(html_entity_decode($val['review_title']));
												$review_rating = $val['review_rating'];
												$review_detail =stripslashes(html_entity_decode($val['review_detail']));
												$review_user_id = $val['review_user_id'];
												$status     	= $val['status'];
												$category_id    = $val['category_id'];
												$is_popular     = $val['is_popular'];
												$is_featured    = $val['is_featured'];
												$review_post_date  = $val['review_post_date'];
												$review_title  = wordwrap($review_title,100," ",true);
												
												$select_qry ="select user_name from tbl_users where 
												user_id='".$review_user_id."' ";
                                                $select_ar  = $db->get_row($select_qry,ARRAY_A);
												$user_name = stripslashes(html_entity_decode($select_ar['user_name']));
												$user_name = wordwrap($user_name,100," ",true);
												
												$cat_qry ="select cat_name from tbl_categories where 
												cat_id='".$category_id."' ";
                                                $cat_arr  = $db->get_row($cat_qry,ARRAY_A);
												$cat_name = stripslashes(html_entity_decode($cat_arr['cat_name']));
												$cat_name = wordwrap($cat_name,100," ",true);
												
												$like_qry ="select count(review_like_id) as total_likes from 
												tbl_review_likes where review_id_like='".$review_id."' ";
                                                $like_arr  = $db->get_row($like_qry,ARRAY_A);
												$total_likes = $like_arr['total_likes'];
												
												$comment_qry ="select count(comment_id) as total_comments from 
												tbl_comments where comment_review_id='".$review_id."' ";
                                                $comment_arr  = $db->get_row($comment_qry,ARRAY_A);
												$total_comments = $comment_arr['total_comments'];
												
												$report_qry ="select count(r_report_id) as total_reports from 
												tbl_review_report where r_report_review_id='".$review_id."' ";
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
									  
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $review_id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $review_id;?>')" id="row<?php echo $review_id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="25"><?php echo $sr_no;?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="150">
											<a href="<?php echo SERVER_ADMIN_PATH;?>review_details.php?key=<?php echo base64_encode($review_id);?>" style="text-decoration:none;"><?php echo substr($review_title,0,100);?></a></br></br>
                                            <?php
											if($is_popular==0 && $status==1)
											{
											?>
                                           	 <a href="javascript:;" onClick="set_popular('<?php echo base64_encode($review_id);?>')">Set as Popular</a>
                                            <?php
											}
											elseif($is_popular==1)
											{
											?>
                                           	 <a href="javascript:;" onClick="unset_popular('<?php echo base64_encode($review_id);?>')">UnSet as Popular</a>
                                            <?php
											}
											?> 
                                            <?php
											if($is_featured=='No' && $status==1)
											{
												echo '<strong> | </strong>';
											?>
                                           	 <a href="javascript:;" onClick="set_featured('<?php echo base64_encode($review_id);?>')">Set as Featured</a>
                                            <?php
											}
											elseif($is_featured=='Yes' )
											{
												echo '<strong> | </strong>';
											?>
                                           	 <a href="javascript:;" onClick="unset_featured('<?php echo base64_encode($review_id);?>')">UnSet as Featured</a>
                                            <?php
											}
											?> 
                                            
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="65">
											<?php echo $review_rating;?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="150">
                                           <?php echo substr($user_name,0,80);?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="150">
                                           <?php echo substr($cat_name,0,80);?>
                                        </td>
                                        
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="50">
                                           <?php echo date("d M Y",$review_post_date);?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="50">
                                           Likes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=  
                                           <a href="<?php echo SERVER_ADMIN_PATH;?>review_likes.php?key=<?php echo base64_encode($review_id);?>" style="text-decoration:none;color:#0000FF;"><strong><?php echo $total_likes;?></strong></a><br />
                                           Comments&nbsp;&nbsp;= <a href="<?php echo SERVER_ADMIN_PATH;?>review_comments.php?key=<?php echo base64_encode($review_id);?>" style="text-decoration:none;color:#0000FF;"><strong><?php echo $total_comments;?></strong></a><br/>
                                           Reports&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=  
                                           <a href="<?php echo SERVER_ADMIN_PATH;?>review_reports.php?key=<?php echo base64_encode($review_id);?>" style="text-decoration:none;color:#0000FF;"><strong><?php echo $total_reports;?></strong><br/></a>
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
												echo '<a href="'.$sort_path.'status='.base64_encode(1).'&status_id='.base64_encode($review_id).'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
											}
											if($status==1)
											{
												echo '<a href="'.$sort_path.'status='.base64_encode(0).'&status_id='.base64_encode($review_id).'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
											}
											
											if($is_popular==1)
											{
												echo '<br><br><strong>Popular Review</strong>';
											}
											if($is_featured=='Yes')
											{
												echo '<br><br><strong>Featured Review</strong>';
											}
										  ?>
                                          
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="50"> 
    &nbsp;&nbsp; <input type="checkbox" class="check-all" name="review_ids[]" id="review_ids[]" value="<?php echo base64_encode($review_id);?>" style="margin-top:-5px;" />
										&nbsp;&nbsp;	
                                        <?php
										if($top_reviews_module_delete=="Yes")
										{
										?>
                                        	<a href="javascript:;" onClick="delete_review('<?php echo base64_encode($review_id);?>')"><img src="images/delet.gif" border="0" title="Delete Review" class="Action" ></a>
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
                                        <td colspan="9" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
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
                                            <select name="dropdown" onChange="multiple_action('reviews_form');">
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
                                        <td colspan="9" align="center" valign="middle">
										<?php include("common/".$pagination.""); ?>
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
