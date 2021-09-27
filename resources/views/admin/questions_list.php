<?php 
include("includes/top.php");
include("common/security.php");

if($_REQUEST['key']!="")
{
	$key_id = base64_decode($_REQUEST['key']);
	$question_qry ="select cat_name as category_name from tbl_categories where cat_id='".$key_id."' ";
    $question_arr  = $db->get_row($question_qry,ARRAY_A);
	$category_name = html_entity_decode(stripslashes($question_arr['category_name']));
	$category_name = wordwrap($category_name,"50"," ",true);
} 
else
{
	$category_name = 'N/A';
}
$url_path = SERVER_ADMIN_PATH."questions_list.php?key=".$_REQUEST['key'];
/*================== Search Filter Start Here=================*/
if(isset($_POST['filter']))
{
	$sess_where = "";
	
		
	if($_REQUEST['question']!="")
	{
		 $sess_where .= " and question_details  like \"%".trim($_REQUEST['question'])."%\" ";
		 $_SESSION['ques_sess'] = trim($_REQUEST['question']);
	}
	else
	{
		unset($_SESSION['ques_sess']);
	}

	if($_REQUEST['question_user_id'] != "")
	{
		$sess_where .= " and question_user_id = '".$_REQUEST['question_user_id']."'";
		$_SESSION['question_user_id_sess'] = $_REQUEST['question_user_id'];
	}
	else
	{
		unset($_SESSION['question_user_id_sess']);
	}
	
	if($_REQUEST['ques_status'] != "")
	{
		$sess_where .= " and status = '".$_REQUEST['ques_status']."'";
		$_SESSION['ques_status'] = $_REQUEST['ques_status'];
	}
	else
	{
		unset($_SESSION['ques_status']);
	}
	$_SESSION['sess_question'] = $sess_where;
}
 $session_where = $_SESSION['sess_question'];
if(isset($_POST['Reset']))
{
	unset($_SESSION['ques_sess']);
	$_SESSION['ques_sess']="";
	
	unset($_SESSION['ques_status']);
	$_SESSION['ques_status']="";

	unset($_SESSION['sess_question']);
	$_SESSION['sess_question']="";
	
	unset($_SESSION['question_user_id_sess']);
	$_SESSION['question_user_id_sess']="";
	
	header("Location:".$url_path);
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch($sortby)
{
	case "question_desc":
		$orderby	= " ORDER BY question desc";
	break;
	
	case "question_asc":
		$orderby	= " ORDER BY question asc";
	break;

	case "statusdesc":
		$orderby	= " ORDER BY status desc";
	break;
	
	case "statusasc":
		$orderby	= " ORDER BY status asc";
	break;		
	
	default:
		$orderby = "ORDER BY question_id desc";
	break;
}
	
	
if(isset($status) && !empty($status))
{
	$status		=	base64_decode($status);
	
	$status_id	=	base64_decode($status_id);
	
	if($status == 1)
	{
		$sqlquery	=	"update tbl_questions set status='$status' where question_id='$status_id'";
	}
	else
	{
		$sqlquery	=	"update tbl_questions set status='$status' where question_id='$status_id'";
	}
	
	$db->query($sqlquery);
	header("Location:".$url_path."&msg=$update_ok_msg&case=1");
	exit;
}
?>
<html>
<head>
<title>Question Listing : <?php echo $category_name;?></title>
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
                        <td class="heading1">Question Listing : <?php echo $category_name;?></td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>sub_cat_list.php">Sub Category Listing</a> &raquo; <a>Question Listing : <strong><?php echo $category_name;?></strong></a></td>
                              </tr>
                              <tr>
                                <td>
                                	<form name="search_form" id="search_form" method="post" action="">
                                    <table border="0" cellpadding="0" cellspacing="0" align="center" width="500" 
                                    style="border:1px solid #000000; padding:10px;">
                                        <tbody>
                                            <tr>
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    Search Question
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Question
                                                </td>
                                                <td align="center">
                                                    <input name="question" id="question" type="text" class="Field300" 
                                                    value="<?php echo $_SESSION['ques_sess']; ?>" />
                                                </td>
                                            </tr>
											
											<tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150"> User Name</td>
                                                <td align="center">
                                                 <select name="question_user_id" id="question_user_id" class="Field300">
                                                    <option value=""> ------ Please Select User ------</option>
                                                 <?php
                                                 $users_qry ="select user_id,user_name from tbl_users where status='1' order by user_name asc";
                                                 $users_arr = $db->get_results($users_qry,ARRAY_A);
                                                 if($users_arr)
                                                 {
                                                    foreach($users_arr as $val)
                                                    {
                                                        $user_id = $val['user_id'];
                                                        $user_name =html_entity_decode(stripslashes($val['user_name']));
                                                        if($_SESSION['question_user_id_sess']==$user_id)
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
                                                <select name="ques_status" id="ques_status" class="Field300">
                                                    <option value=""> ------- Please Select Status ------- </option>
                                                    <option value="1" <?php if($_SESSION['ques_status'] == '1'){ echo 'selected="selected"';}?>>Active</option>
                                                    <option value="0" <?php if($_SESSION['ques_status'] == '0'){ echo 'selected="selected"';}?>>Block</option>	
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
                                      
									  <tr><td colspan="6">&nbsp;</td></tr>
                                      <tr>
                                        <td width="30" id="Heading_list">Sr #</td>
                                        <td width="300" id="Heading_list">Question</td>
                                        <td width="150" id="Heading_list">Review Topic</td>
                                        <td width="150" id="Heading_list">User Name</td>
                                        <td width="70" id="Heading_list">
                                        <?php if($sortby == 'statusdesc'){?>
                                        <a href="<?php echo $url_path;?>&sortby=statusasc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }else{?>
                                        <a href="<?php echo $url_path;?>&sortby=statusdesc&page=<?php echo $page;?>" class="link_class">Status</a>
                                        <?php }?>
                                        </td>
                                        <td width="70" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/question_actions.php" method="post" id="question_form" name="question_form">
									  <?php
										    $where_clasue= " and question_cat_id='".base64_decode($_REQUEST['key'])."'";
											//============================================================
											//PAGGING CODE STARTS HERE
											$qry_count_mypro = "SELECT question_id FROM tbl_questions where 1=1 
											$where_clasue $session_where  $orderby";
											$res_count_mypro = mysqli_query($db->dbh, $qry_count_mypro);
												
											$targetpage = "".$url_path.""; //your file name  (the name of this file)
											
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

										$question_qry="select * from tbl_questions where 1=1 $where_clasue $session_where $orderby LIMIT $start, $limit";	
										$question_list_arr	=	$db->get_results($question_qry,ARRAY_A);
										
										if(isset($question_list_arr))
										{
											foreach($question_list_arr as $val)
											{
												$question_id	    = $val['question_id'];	
												$question_details   = stripslashes(html_entity_decode($val['question_details']));
												$question_user_id   = $val['question_user_id'];
												$question_cat_id    = $val['question_cat_id'];
												$status             = $val['status'];
												$question_details   = wordwrap($question_details,100," ",true);
												
												$review_topic_qry ="Select cat_name from tbl_categories where cat_id='".$question_cat_id."' ";
												$review_topic_arr = $db->get_row($review_topic_qry,ARRAY_A);
												$cat_name         = stripslashes(html_entity_decode($review_topic_arr['cat_name']));
												$cat_name         = wordwrap($cat_name,100," ",true);
												
												$users_qry ="select user_name from tbl_users where user_id='".$question_user_id."'";
                                                $users_arr = $db->get_row($users_qry,ARRAY_A);
												$user_name = stripslashes(html_entity_decode($users_arr['user_name']));
												$user_name = wordwrap($user_name,100," ",true);
												 
												if($c%2==0)
												{
													$bgcolor = "#FEFEE4";
												}
												else
												{
													$bgcolor = "#FFFFFF";	
												}
												$count_ans_qry = "SELECT count(ans_id) as total_answer FROM tbl_answers where ques_id='".$question_id."' ";
												$count_ans_arr = $db->get_row($count_ans_qry,ARRAY_A);
												$total_answer  = $count_ans_arr['total_answer'];
												$c++;
												$sr_no++;
										?>
									  
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $question_id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $question_id;?>')" id="row<?php echo $question_id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no;?></td>
										<td nowrap="nowrap" class="SmallFieldLabel" width="300">
                                            <div id="before_details_div_<?php echo $question_id;?>"> 
                                            <?php
											if(strlen($question_details)<=100)
											{
												echo substr($question_details,0,100);
											}
											else
											{
												echo '<a href="javascript:;" onClick="show_detail('.$question_id.');" style="text-decoration:none;">'.substr($question_details,0,100).'</a>&nbsp';
												
												echo '<a href="javascript:;" onClick="show_detail('.$question_id.');" style="color:#0000FF;"> <strong>&raquo; More</strong></a>';
											}
											?>
                                            </div>
                                            <div id="after_details_div_<?php echo $question_id;?>" style="display:none;"> 
                                            	<?php
													echo '<a href="javascript:;" onClick="show_detail('.$question_id.');" style="text-decoration:none;">'.$question_details.'</a>&nbsp;';
													
													echo '<a href="javascript:;" onClick="show_detail('.$question_id.');" style="color:#0000FF;"><strong>&raquo; Close </strong></a>';
												?>
                                            </div>
											<?php
										if($total_answer>0)
										{
										?>
									  <a href="<?php echo SERVER_ADMIN_PATH;?>question_answers.php?key=<?php echo base64_encode($question_id);?>"><strong style="color:#0000FF;">View <?php echo $total_answer;?> Answers</strong></a>
									  <?php
									   }
									  ?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="150"><?php echo $cat_name;?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="150"><?php echo $user_name;?></td>
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
												echo '<a href="'.$url_path.'&status='.base64_encode(1).'&status_id='.base64_encode($question_id).'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
											}
											if($status==1)
											{
												echo '<a href="'.$url_path.'&status='.base64_encode(0).'&status_id='.base64_encode($question_id).'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
											}
										  ?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70"> 
    &nbsp;&nbsp; <input type="checkbox" class="check-all" name="question_ids[]" id="question_ids[]" value="<?php echo base64_encode($question_id);?>" style="margin-top:-5px;" />
										&nbsp;&nbsp;	
										<?php
										if($top_categories_module_delete=='Yes')
										{
										?>
                                        &nbsp; &nbsp;
                                        <a href="edit_question.php?edit_id=<?php echo base64_encode($question_id);?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>&nbsp; &nbsp;
                                        <a href="javascript:;" onClick="delete_question('<?php echo $question_id;?>')"><img src="images/delet.gif" border="0" title="Delete Question" class="Action" ></a>
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
                                            <select name="dropdown" onChange="multiple_action('question_form');">
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
                                        <td colspan="6" align="center" valign="middle"><?php include("common/cat_details_paging.php"); ?></td>
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
