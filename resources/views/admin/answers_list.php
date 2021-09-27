<?php 
include("includes/top.php");
include("common/security.php"); 
/*================== Search Filter Start Here=================*/
if($_REQUEST['key']!="")
{
	$keys  = $_REQUEST['key'];
    $catedory_id = base64_decode($keys);
	$pagination = 'report_paging.php';
	$path       = 'answers_list.php?key='.$_REQUEST['key'].'';
	$sort_path  = 'answers_list.php?key='.$_REQUEST['key'].'&';
	
	 $question_qry="SELECT b.* FROM tbl_questions as a inner join tbl_answers as b on a.question_id=b.ques_id where a.question_cat_id='".$catedory_id."' "; 
	
	 $qry_count_mypro = "SELECT b.ans_id FROM tbl_questions as a inner join tbl_answers as b on a.question_id=b.ques_id where a.question_cat_id='".$catedory_id."' "; 
	
	 $answers_qry="select b.* FROM tbl_questions as a inner join tbl_answers as b on a.question_id=b.ques_id where a.question_cat_id='".$catedory_id."' ";	 
}
else
{
	$question_qry="SELECT * FROM tbl_answers"; 
	$qry_count_mypro = "SELECT b.ans_id FROM tbl_answers as b where 1=1 ";
	$answers_qry     = "select b.* FROM tbl_answers as b where 1=1  ";	    
	$key_where  = "";
	$pagination = 'paging-playlist.php';
	$path       = 'answers_list.php';
	$sort_path  = 'answers_list.php?';
}

if(isset($_POST['filter']))
{
	$sess_where = "";
	
		
	if($_REQUEST['answer_details']!="")
	{
		 $sess_where .= " and b.answer_details  like \"%".trim($_REQUEST['answer_details'])."%\" ";
		 $_SESSION['answer_details_sess'] = trim($_REQUEST['answer_details']);
	}
	else
	{
		unset($_SESSION['answer_details_sess']);
	}
	
	if($_REQUEST['answer_user_id'] != "")
	{
		$sess_where .= " and b.ans_user_id_receive = '".$_REQUEST['answer_user_id']."'";
		$_SESSION['ans_user_id_receive_sess'] = $_REQUEST['answer_user_id'];
	}
	else
	{
		unset($_SESSION['ans_user_id_receive_sess']);
	}
	
	
	$_SESSION['sess_answer'] = $sess_where;
}
 $session_where = $_SESSION['sess_answer'];
if(isset($_POST['Reset']))
{
	unset($_SESSION['answer_details_sess']);
	$_SESSION['answer_details_sess']="";
	
	unset($_SESSION['ans_user_id_receive_sess']);
	$_SESSION['ans_user_id_receive_sess']="";

	unset($_SESSION['sess_answer']);
	$_SESSION['sess_answer']="";
	
	header("Location:".$path."");
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch($sortby)
{
	case "user_desc":
		$orderby	= " ORDER BY b.ans_user_id_receive desc";
	break;
	
	case "user_asc":
		$orderby	= " ORDER BY b.ans_user_id_receive asc";
	break;
	
	default:
		$orderby = "ORDER BY b.ans_id desc";
	break;
}
	
	

?>
<html>
<head>
<title>Category Answer Listing</title>
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
                        <td class="heading1">Answer Listing</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td>
								<a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>sub_cat_list.php">Sub Category Listing </a>&raquo; <a> Category Answers Listing </a>
								</td>
                              </tr>
                              
							  <?php
                              
                              $question_arr	=	$db->get_row($question_qry,ARRAY_A);
                              if($question_arr)
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
                                                    Search Category Answers
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Answer
                                                </td>
                                                <td align="center">
                                                    <input name="answer_details" id="answer_details" type="text" class="Field300" 
                                                    value="<?php echo $_SESSION['answer_details_sess']; ?>" />
                                                </td>
                                            </tr>
											
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                 User
                                                </td>
                                                <td align="center">
                                               	<select name="answer_user_id" id="answer_user_id" style="width:300px;" class="Field300">
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
                                                            if($_SESSION['ans_user_id_receive_sess']==$user_id)
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
                                                    <?php } ?>
													
													<?php if($case==4){ ?>
                                                    <img src="images/error_icon.png" vspace="5" width="18" height="18" hspace="10">
													Some Error has occured , please try agin
                                                    <?php } ?>                                                  
												  </td>
                                                  <td width="100%"><?php echo base64_decode($msg); ?></td>
                                                </tr>
                                              </tbody>
                                            </table>
										</td>
                                      </tr>
                                      <?php } ?>
                                      
									  
									  
									  <tr><td colspan="45">&nbsp;</td></tr>
                                      <tr>
                                        <td width="30" id="Heading_list">Sr #</td>
                                        <td width="300" id="Heading_list">Answer Details</td>
                                        <td width="200" id="Heading_list">User Name</td>
                                        <td width="60" id="Heading_list">Like/Report</td>
                                        <?php
										if($top_categories_module_delete=="Yes")
										{
										?>
                                        <td width="70" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                        <?php
										}
										?>
                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/answer_actions.php" method="post" id="answer_form">
									  <?php
									  		
											//============================================================
											//PAGGING CODE STARTS HERE
											
											$qrys_count_mypro  = $qry_count_mypro." $session_where";
											$res_count_mypro = mysqli_query($db->dbh, $qrys_count_mypro);
												
											$targetpage = "answers_list.php"; 
											
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

										$answer_qry  = $answers_qry." $session_where $orderby LIMIT $start, $limit";
										$answers_arr = $db->get_results($answer_qry,ARRAY_A);
										
										if(isset($answers_arr))
										{
											foreach($answers_arr as $val)
											{
												$ans_id	    = $val['ans_id'];
												$ques_id	    = $val['ques_id'];	
												$ans_user_id_receive = $val['ans_user_id_receive'];
												$answer_details      = $val['answer_details'];
												$date_added          = $val['date_added'];
												$details  = stripslashes(html_entity_decode($answer_details));
												$details   = wordwrap($details,100," ",true);
												
												$select_qry ="select user_name from tbl_users where 
												user_id='".$ans_user_id_receive."' ";
                                                $select_arr  = $db->get_row($select_qry,ARRAY_A);
												$user_name = stripslashes(html_entity_decode($select_arr['user_name']));
												$user_name = wordwrap($user_name,100," ",true);
												
												$like_qry ="select count(answer_like_id) as total_likes from 
												tbl_answer_likes where  answer_id='".$ans_id."' ";
                                                $like_arr  = $db->get_row($like_qry,ARRAY_A);
												$total_likes = $like_arr['total_likes'];
												
												$report_qry ="select count(answer_report_id) as total_reports from 
												tbl_answer_report where answerid='".$ans_id."' ";
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
									  
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $ans_id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $ans_id;?>')" id="row<?php echo $ans_id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no;?></td>
										<td nowrap="nowrap" class="SmallFieldLabel" width="300">
                                            <div id="before_details_div_<?php echo $ans_id;?>"> 
                                            <?php
											if(strlen($details)<=100)
											{
												echo substr($details,0,100);
											}
											else
											{
												echo '<a href="javascript:;" onClick="show_detail('.$ans_id.');" style="text-decoration:none;">'.substr($details,0,100).'</a>&nbsp';
												
												echo '<a href="javascript:;" onClick="show_detail('.$ans_id.');" style="color:#0000FF;"> <strong>&raquo; More</strong></a>';
											}
											?>
                                            </div>
                                            <div id="after_details_div_<?php echo $ans_id;?>" style="display:none;"> 
                                            	<?php
													echo '<a href="javascript:;" onClick="show_detail('.$ans_id.');" style="text-decoration:none;">'.$details.'</a>&nbsp;';
													
													echo '<a href="javascript:;" onClick="show_detail('.$ans_id.');" style="color:#0000FF;"><strong>&raquo; Close </strong></a>';
												?>
                                            </div>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
											<?php echo $user_name;?>
                                        </td>
                                        
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="60">
											likes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= <a href="<?php echo SERVER_ADMIN_PATH;?>answer_likes.php?key=<?php echo base64_encode($ans_id);?>" style="text-decoration:none;color:#0000FF;"><strong><?php echo $total_likes;?></strong></a><br />
                                            Reports = <a href="<?php echo SERVER_ADMIN_PATH;?>answer_reports.php?key=<?php echo base64_encode($ans_id);?>&qkey=<?php echo base64_encode($ques_id);?>" style="text-decoration:none;color:#0000FF;"><strong><?php echo $total_reports;?></strong></a>
                                        </td>
                                       <input type="hidden" id="questionid" name="questionid" value="<?php echo $key;?>"/>
                                        <?php
										if($top_categories_module_delete=="Yes")
										{
										?>
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70"> 
    &nbsp;&nbsp; <input type="checkbox" class="check-all" name="ans_ids[]" id="ans_ids[]" value="<?php echo base64_encode($ans_id);?>" style="margin-top:-5px;" />
                                        &nbsp; &nbsp;
                                        <a href="javascript:;" onClick="delete_answer('<?php echo $ans_id;?>')"><img src="<?php echo SERVER_ADMIN_PATH;?>images/delet.gif" border="0" title="Delete Comment" class="Action" ></a>
                                        
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
										if($top_categories_module_delete=="Yes")
										{
									  ?>
                                      
									  <tr>
                                        <td colspan="5" nowrap="nowrap" class="SmallFieldLabel righttd_border">
                                        <span style="float:right; padding-bottom:10px; margin-right:8px;">
                                            <select name="dropdown" onChange="multiple_action('answer_form');">
                                                <option value="">Choose an action...</option>
                                                <option value="Delete">Delete</option>
                                            </select>
                                        </span>
                                        </td>
                                      </tr>
                                      <?php
									  	}
									  }
									  ?>
									  <tr>
                                        <td colspan="5" align="center" valign="middle">
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
