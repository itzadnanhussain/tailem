@include("admin.includes.top")
@include("admin.common.security")
<?php 
 error_reporting(0);
/*================== Search Filter Start Here=================*/
$keys  = $_REQUEST['key'];
$gcommentsid = base64_decode($keys);
if(isset($_POST['filter']))
{
	$sess_where = "";
	
		
	if($_REQUEST['gc_report_deatil']!="")
	{
		 $sess_where .= " and r.r_report_details  like \"%".trim($_REQUEST['gc_report_deatil'])."%\" ";
		 $_SESSION['gc_report_user_id_sess'] = trim($_REQUEST['gc_report_deatil']);
	}
	else
	{
		unset($_SESSION['gc_report_deatil_sess']);
	}
	
	if($_REQUEST['gc_report_user_id'] != "")
	{
		$sess_where .= " and r_report_user_id = '".$_REQUEST['gc_report_user_id']."'";
		$_SESSION['gc_report_user_id_sess'] = $_REQUEST['gc_report_user_id'];
	}
	else
	{
		unset($_SESSION['gc_report_user_id_sess']);
	}
	$_SESSION['sess_rreport'] = $sess_where;
}
 $session_where = $_SESSION['sess_rreport'];
if(isset($_POST['Reset']))
{
	unset($_SESSION['gc_report_deatil_sess']);
	$_SESSION['gc_report_deatil_sess']="";
	
	unset($_SESSION['gc_report_user_id_sess']);
	$_SESSION['gc_report_user_id_sess']="";

	unset($_SESSION['sess_rreport']);
	$_SESSION['sess_rreport']="";
	
	header("Location:gcomments_reports?key=".$_REQUEST['key']."&review=".$_REQUEST['review']);
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch($sortby)
{
	case "user_desc":
		$orderby	= " ORDER BY r_report_user_id desc";
	break;
	
	case "user_asc":
		$orderby	= " ORDER BY r_report_user_id asc";
	break;
	
	
	default:
		$orderby = "ORDER BY r.r_report_id desc";
	break;
}
	
	

?>
<html>
<head>
<title>Comments Reports Listing</title>
 @include("admin.common.header") 
<script language="javascript" type="text/javascript">
// check boxess submit code
function toggleChecked(c_report_status)
{
	$(".check-all").each( function() {
		$(this).attr("checked",c_report_status);
	})
}

function multiple_action(frm_id) // for changing multiple c_report_status or multiple delete 
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
          @include("admin.common.top_right_menu") 
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
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index">Home</a> &raquo; <a>&raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>gcomments">Discussions Listing</a>&raquo; <a>Comments Report Listing</a></td>
                              </tr>
							  <?php
                              $comments_qry="select * from tbl_comments where 
							  comment_id='".$gcommentsid."' ";
                              $comment_arr	=	\App\Models\Songs::GetRawDataAdmin($comments_qry);
                              if($comment_arr)
                              {
                              ?>
                              <tr>
                                <td>
                                	<form name="search_form" id="search_form" method="post" action="">
                                  @csrf 
                                  <table border="0" cellpadding="0" cellspacing="0" align="center" width="500" 
                                    style="border:1px solid #000000; padding:10px;">
                                        <tbody>
                                            <tr>
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    Search Comment Report
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Details
                                                </td>
                                                <td align="center">
                                                <input name="gc_report_deatil" id="gc_report_deatil" class="Field300" 
                                                value="<?php echo $_SESSION['gc_report_deatil_sess'];?>" type="text"/>
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Report User
                                                </td>
                                                <td align="center">
                                               	<select name="gc_report_user_id" id="gc_report_user_id" 
                                                style="width:300px;padding:4px 1px;">
                                                   <option value=""> ------ Please Select User ------</option>
                                                     <?php
                                                     $users_qry ="select u.user_id,u.user_name from tbl_users u, tbl_review_report r where u.status=1 AND u.user_id = r.r_report_user_id AND r.status = 1 group by r.r_report_user_id
                                                     order by user_name asc";
                                                     $users_arr = \App\Models\Songs::GetRawData($users_qry);;
                                                     if($users_arr)
                                                     {
                                                        foreach($users_arr as $val)
                                                        {
                                                          $val = (array)$val;
                                                            $user_id   = $val['user_id'];
                                                            $user_name = $val['user_name'];
															$user_name = html_entity_decode(stripslashes($user_name));
                                                            if($_SESSION['gc_report_user_id_sess']==$user_id)
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
								
									$gcomment_detail=stripslashes(html_entity_decode($comment_arr['comment_details']));
									$gcomment_user_id = $comment_arr['comment_user_id'];
									$status     	= $comment_arr['comment_status'];
									$gcomment_post_date  = $comment_arr['comment_post_date'];
									$gcomment_detail  = wordwrap($gcomment_detail,100," ",true);
									
									$select_qry ="select user_name from tbl_users where 
									user_id='".$gcomment_user_id."' ";
									$select_ar  = \App\Models\Songs::GetRawDataAdmin($select_qry);
									$user_name = stripslashes(html_entity_decode($select_ar['user_name']));
									$user_name = wordwrap($user_name,100," ",true);
									
									$cat_qry ="select cat_name from tbl_categories where 
									cat_id='".$gcomment_cat_id."' ";
									$cat_arr  = \App\Models\Songs::GetRawData($cat_qry);;
									$cat_name = stripslashes(html_entity_decode($cat_arr['cat_name']));
									$cat_name = wordwrap($cat_name,100," ",true);
								?>
                                <table border="0" cellpadding="0" cellspacing="0" align="center" class="report_table">
                                        <tbody>
                                            <tr height="50">
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    General Comment Details
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Comment Details
                                                </td>
                                                <td align="left"><?php echo $gcomment_detail;?> </td>
                                            </tr>
                                            
                                            
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Comment User Name
                                                </td>
                                                <td align="left"><?php echo $user_name;?> </td>
                                            </tr>
                                            
                                           
                                            <tr height="30" class="last">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Post Date
                                                </td>
                                                <td align="left"><?php echo date("d M Y",$gcomment_post_date);?>
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
                                        <a href="gcomments_reports?sortby=user_asc&page=<?php echo $page;?>&key=<?php echo $key;?>" class="link_class">Report User</a>
                                        <?php }else{?>
                                        <a href="gcomments_reports?sortby=user_desc&page=<?php echo $page;?>&key=<?php echo $key;?>" class="link_class">Report User</a>
                                        <?php }?>
                                        </td>
                                        
                                        <td width="150" id="Heading_list">
                                        <?php if($sortby == 'issue_desc'){?>
                                        <a href="review_reports?sortby=issue_asc&page=<?php echo $page;?>&key=<?php echo $key;?>" class="link_class">Issue</a>
                                        <?php }else{?>
                                        <a href="review_reports?sortby=issue_desc&page=<?php echo $page;?>&key=<?php echo $key;?>" class="link_class">Issue</a>
                                        <?php }?>
                                        </td>
                                        
                                        <td width="300" id="Heading_list">Details</td>
                                        
                                        <?php
										if($top_reviews_module_delete=="Yes")
										{
										?>
                                        <td width="70" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                        <?php
										}
										?>
                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/gcomment_report_actions" method="post" id="gc_report_form">
									 @csrf
                   <?php
									  		
											//============================================================
											//PAGGING CODE STARTS HERE
											$qry_count_mypro = "select r.r_report_id from tbl_review_report r, tbl_reports_checkbox c  where 1=1 and 
										r.r_report_review_id='".$gcommentsid."' AND r.status = 1 AND r.r_report_option = c.report_chk_box_id $session_where $orderby";
										
                    $res_count_mypro = array();
                    $res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
                    if ($res_count_mypro) {
                      $total_pages = count($res_count_mypro);
                    } else {
                      $total_pages = 0;
                    }
											$targetpage = "gcomments_reports"; 
											$limit = 10; 					//how many items to show per page
										 
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

										$report_query="select * from tbl_review_report r, tbl_reports_checkbox c  where 1=1 and 
										r.r_report_review_id='".$gcommentsid."' AND r.status = 1 AND r.r_report_option = c.report_chk_box_id $session_where $orderby 
										LIMIT $start, $limit";	
											
										$report_arr	=	\App\Models\Songs::GetRawData($report_query);
										
										if(isset($report_arr))
										{
											foreach($report_arr as $val)
											{
                        $val = (array)$val;
												$gc_report_id	  = $val['r_report_id'];	
												$gc_report_user_id = $val['r_report_user_id'];
												$gc_report_deatil = $val['r_report_details'];
												$gc_report_status   = $val['r_report_status'];
												$gc_report_date    = $val['r_report_date'];
												$report_chk_box_name = $val['report_chk_box_name']; 
												$details  = stripslashes(html_entity_decode($gc_report_deatil));
												$details   = wordwrap($details,100," ",true);
												
												$select_qry ="select user_name from tbl_users where 
												user_id='".$gc_report_user_id."' ";
                                                $select_ar  = \App\Models\Songs::GetRawData($select_qry);;
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
									  
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $gc_report_id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $gc_report_id;?>')" id="row<?php echo $gc_report_id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no;?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
											<?php echo $user_name;?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="150">
											<?php echo $report_chk_box_name;?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="300">
                                            <div id="before_details_div_<?php echo $gc_report_id;?>"> 
                                            <?php
											if(strlen($details)<=100)
											{
												echo substr($details,0,100);
											}
											else
											{
												echo '<a href="javascript:;" onClick="show_detail('.$gc_report_id.');" style="text-decoration:none;">'.substr($details,0,100).'</a>&nbsp';
												
												echo '<a href="javascript:;" onClick="show_detail('.$gc_report_id.');" style="color:#0000FF;"> <strong>&raquo; More</strong></a>';
											}
											?>
                                            </div>
                                            <div id="after_details_div_<?php echo $gc_report_id;?>" style="display:none;"> 
                                            	<?php
													echo '<a href="javascript:;" onClick="show_detail('.$gc_report_id.');" style="text-decoration:none;">'.$details.'</a>&nbsp;';
													
													echo '<a href="javascript:;" onClick="show_detail('.$gc_report_id.');" style="color:#0000FF;"><strong>&raquo; Close </strong></a>';
												?>
                                            </div>
                                        </td>
                                        <input type="hidden" id="gcommentids" name="gcommentids" value="<?php echo $keys;?>"/>
                                        <?php
										if($top_reviews_module_delete=="Yes")
										{
										?>
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70"> 
    &nbsp;&nbsp; <input type="checkbox" class="check-all" name="gc_report_ids[]" id="gc_report_ids[]" value="<?php echo base64_encode($gc_report_id);?>" style="margin-top:-5px;" />
    							
										&nbsp; &nbsp;
                                        <a href="javascript:;" onClick="delete_gcomment_report('<?php echo $gc_report_id;?>')"><img src="images/delet.gif" border="0" title="Delete Report" class="Action" ></a>
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
                                        <td colspan="5" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
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
                                        <td colspan="5" nowrap="nowrap" class="SmallFieldLabel righttd_border">
                                        <span style="float:right; padding-bottom:10px; margin-right:8px;">
                                            <select name="dropdown" onChange="multiple_action('gc_report_form');">
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
                                           @include("admin.common.comment_paging") </td>
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
      <td height="20">
         @include("admin.common.footer") </td>
    </tr>
  </tbody>
</table>
<!-- End pagefooter -->
</body>
</html>
