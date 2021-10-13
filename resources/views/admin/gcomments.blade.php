@include("admin.includes.top")
@include("admin.common.security")
<?php
error_reporting(0);
/*================== Search Filter Start Here=================*/
if (isset($_POST['filter'])) {
  $sess_where = "";
  if ($_REQUEST['gcomment_detail'] != "") {
    $sess_where .= " and comment_detail  like \"%" . trim($_REQUEST['gcomment_detail']) . "%\" ";
    $_SESSION['gcomment_detail_sess'] = trim($_REQUEST['gcomment_detail']);
  } else {
    unset($_SESSION['gcomment_detail_sess']);
  }

  if ($_REQUEST['gcomment_user_id'] != "") {
    $sess_where .= " and comment_user_id = '" . $_REQUEST['gcomment_user_id'] . "'";
    $_SESSION['gcomment_user_id_sess'] = $_REQUEST['gcomment_user_id'];
  } else {
    unset($_SESSION['gcomment_user_id_sess']);
  }
  $_SESSION['sess_comments'] = $sess_where;
}
$session_where = $_SESSION['sess_comments'];
if (isset($_POST['Reset'])) {
  unset($_SESSION['gcomment_detail_sess']);
  $_SESSION['gcomment_detail_sess'] = "";

  unset($_SESSION['gcomment_user_id_sess']);
  $_SESSION['gcomment_user_id_sess'] = "";

  unset($_SESSION['sess_comments']);
  $_SESSION['sess_comments'] = "";

  header("Location:" . $path . "");
}
/*================== Search Filter End Here=================*/
//---------- Ordering ----------//
switch ($sortby) {
  case "user_desc":
    $orderby  = " ORDER BY comment_user_id desc";
    break;

  case "user_asc":
    $orderby  = " ORDER BY comment_user_id asc";
    break;

  default:
    $orderby = "ORDER BY comment_id desc";
    break;
}
?>
<html>

<head>
  <title>Discussions Listing</title>
  @include("admin.common.header")
  <script language="javascript" type="text/javascript">
    // check boxess submit code
    function toggleChecked(comment_status) {
      $(".check-all").each(function() {
        $(this).attr("checked", comment_status);
      })
    }

    function multiple_action(frm_id) // for changing multiple comment_status or multiple delete 
    {
      var conBox = confirm("Are you sure,you want to Perform this Action?");
      if (conBox) {
        document.forms[frm_id].submit();
      } else {
        return false;
      }
    }

    function show_detail(id) {
      $("#before_details_div_" + id).toggle();
      $("#after_details_div_" + id).toggle();
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
      <td valign="top">
        <table border="0" width="100%">
          <tr>
            <td width="10">&nbsp;</td>
            <td>
              <!-- End page header -->
              <!-- End pageheader -->
              <!-- Start home -->
              <div class="BodyContainer">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td class="heading1">Discussions Listing</td>
                  </tr>
                  <tr>
                    <td class="body">
                      <table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                          <td><a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a> &raquo; <a><a>Discussions Listing</a></td>
                        </tr>
                        <tr>
                          <td>
                            <form name="search_form" id="search_form" method="post" action="">
                            @csrf 
                            <table border="0" cellpadding="0" cellspacing="0" align="center" width="500" style="border:1px solid #000000; padding:10px;">
                                <tbody>
                                  <tr>
                                    <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                      Search Discussions
                                    </td>
                                  </tr>
                                  <tr height="30">
                                    <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                      Details
                                    </td>
                                    <td align="center">
                                      <input name="gcomment_detail" id="gcomment_detail" class="Field300" value="<?php echo $_SESSION['gcomment_detail_sess']; ?>" type="text" />
                                    </td>
                                  </tr>
                                  <tr height="30">
                                    <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                      Comment User
                                    </td>
                                    <td align="center">
                                      <select name="gcomment_user_id" id="gcomment_user_id" style="width:300px;padding:4px 1px;">
                                        <option value=""> ------ Please Select User ------</option>
                                        <?php
                                        $users_qry = "SELECT u.user_id, u.user_name,c.comment_id FROM tbl_comments c, tbl_users u where 1=1 AND c.comment_user_id = u.user_id group by c.comment_user_id";
                                        $users_arr = \App\Models\Songs::GetRawData($users_qry);
                                        if ($users_arr) {
                                          foreach ($users_arr as $val) {
                                            $val = (array)$val;
                                            $user_id   = $val['user_id'];
                                            $user_name = $val['user_name'];
                                            $user_name = html_entity_decode(stripslashes($user_name));
                                            if ($_SESSION['gcomment_user_id_sess'] == $user_id) {
                                              $selected = "selected='selected'";
                                            } else {
                                              $selected = "";
                                            }
                                        ?>
                                            <option value="<?php echo $user_id; ?>" <?php echo $selected; ?>><?php echo $user_name; ?></option>
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
                                    <td class="SmallFieldLabelnew font_bold" align="left" width="150">&nbsp;</td>
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
                                <?php if (isset($msg) && $msg != "") { ?>
                                  <tr>
                                    <td colspan="4">
                                      <table border="0" cellpadding="0" cellspacing="0" class="Message">
                                        <tbody>

                                          <tr>
                                            <td width="20"><?php if ($case == 1) { ?>
                                                <img src="images/success_icon.png" vspace="5" width="18" height="18" hspace="10">
                                              <?php } ?>
                                              <?php if ($case == 2) { ?>
                                                <img src="images/warning_icon.png" vspace="5" width="18" height="18" hspace="10">
                                              <?php } ?>
                                              <?php if ($case == 3) { ?>
                                                <img src="images/error_icon.png" vspace="5" width="18" height="18" hspace="10">
                                              <?php } ?>
                                            </td>
                                            <td width="100%"><?php echo base64_decode($msg); ?></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                <?php } ?>
                                <tr>
                                  <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="30" id="Heading_list">Sr #</td>
                                  <td width="200" id="Heading_list">
                                    <?php if ($sortby == 'user_desc') { ?>
                                      <a href="<?php echo $sort_path; ?>sortby=user_asc&page=<?php echo $page; ?>" class="link_class">Comment User</a>
                                    <?php } else { ?>
                                      <a href="<?php echo $sort_path; ?>sortby=user_desc&page=<?php echo $page; ?>" class="link_class">Comment User</a>
                                    <?php } ?>
                                  </td>
                                  <td width="300" id="Heading_list">Details</td>
                                  <td width="60" id="Heading_list">Report</td>
                                  <?php
                                  if ($top_reviews_module_delete == "Yes") {
                                  ?>
                                    <td width="70" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>
                                  <?php
                                  }
                                  ?>
                                </tr>
                                <form action="<?php echo SERVER_ADMIN_PATH; ?>process/review_comment_actions" method="post" id="comment_form">
                                  @csrf
                                  <?php
                                  //============================================================
                                  //PAGGING CODE STARTS HERE
                                  $qry_count_mypro = "SELECT c.*,u.user_name FROM tbl_comments c, tbl_users u where 1=1 AND c.comment_user_id = u.user_id  $key_where $session_where $orderby";
                                  $res_count_mypro = array();
																	$res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
																	if ($res_count_mypro) {
																		$total_pages = count($res_count_mypro);
																	} else {
																		$total_pages = 0;
																	}
                                  $targetpage = "gcomments"; //your file name  (the name of this file)


                                  $limit = 15;           //how many items to show per page
                                 
                                  if ($page)
                                    $start = ($page - 1) * $limit; //first item to display on this page
                                  else
                                    $start = 0;          //if no page var is given, set start to 0
                                  //PAGGING CODE ENDS HERE	
                                  //============================================================

                                  if (isset($page) && $page != "") {
                                    $sr_no = ($page * $limit) - $limit;
                                  } else {
                                    $sr_no = 0;
                                  }
                                  $c = 1;
                                  $comment_qry = "SELECT c.*,u.user_name FROM tbl_comments c, tbl_users u where 1=1 AND c.comment_user_id = u.user_id  $key_where 
										$session_where $orderby LIMIT $start, $limit";
                                  $comment_arr  =  \App\Models\Songs::GetRawData($comment_qry);
                                  if (isset($comment_arr) && !empty($comment_arr)) {
                                    foreach ($comment_arr as $val) {
                                      $val = (array)$val;
                                      $gcomment_id      = $val['comment_id'];
                                      $gcomment_user_id   = $val['gcomment_user_id'];
                                      $gcomment_detail    = $val['comment_details'];
                                      $comment_status     = $val['comment_status'];
                                      $comment_post_date = $val['comment_post_date'];
                                      $details  = stripslashes(html_entity_decode($gcomment_detail));
                                      $details   = wordwrap($details, 100, " ", true);
                                      $user_name = stripslashes(html_entity_decode($val['user_name']));
                                      $report_qry = "select count(r_report_id) as total_reports from 
												 tbl_review_report where r_report_review_id ='" . $gcomment_id . "' ";
                                      $report_arr  = \App\Models\Songs::GetRawDataAdmin($report_qry);
                                      $total_reports = $report_arr['total_reports'];

                                      if ($c % 2 == 0) {
                                        $bgcolor = "#FEFEE4";
                                      } else {
                                        $bgcolor = "#FFFFFF";
                                      }

                                      $c++;
                                      $sr_no++;
                                  ?>
                                      <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $gcomment_id; ?>')" onMouseOut="changebackcolor_blur('row<?php echo $gcomment_id; ?>')" id="row<?php echo $gcomment_id; ?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no; ?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
                                          <?php echo $user_name; ?>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="300">
                                          <div id="before_details_div_<?php echo $gcomment_id; ?>">
                                            <?php
                                            if (strlen($details) <= 100) {
                                              echo substr($details, 0, 100);
                                            } else {
                                              echo '<a href="javascript:;" onClick="show_detail(' . $gcomment_id . ');" style="text-decoration:none;">' . substr($details, 0, 100) . '</a>&nbsp';
                                              echo '<a href="javascript:;" onClick="show_detail(' . $gcomment_id . ');" style="color:#0000FF;"> <strong>&raquo; More</strong></a>';
                                            }
                                            ?>
                                          </div>
                                          <div id="after_details_div_<?php echo $gcomment_id; ?>" style="display:none;">
                                            <?php
                                            echo '<a href="javascript:;" onClick="show_detail(' . $gcomment_id . ');" style="text-decoration:none;">' . $details . '</a>&nbsp;';
                                            echo '<a href="javascript:;" onClick="show_detail(' . $gcomment_id . ');" style="color:#0000FF;"><strong>&raquo; Close </strong></a>';
                                            ?>
                                          </div>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="60">
                                          Reports = <a href="<?php echo SERVER_ADMIN_PATH; ?>gcomments_reports?key=<?php echo base64_encode($gcomment_id); ?><?php echo $url_path ?>" style="text-decoration:none;color:#0000FF;"><strong><?php echo $total_reports; ?></strong></a>
                                        </td>
                                        <input type="hidden" id="reviewsid" name="reviewsid" value="<?php echo $key; ?>" />
                                        <?php
                                        if ($top_reviews_module_delete == "Yes") {
                                        ?>
                                          <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70">
                                            &nbsp;&nbsp; <input type="checkbox" class="check-all" name="gcomment_ids[]" id="gcomment_ids[]" value="<?php echo base64_encode($gcomment_id); ?>" style="margin-top:-5px;" />
                                            &nbsp; &nbsp;
                                            <a href="edit_discussion?edit_id=<?php echo base64_encode($gcomment_id); ?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>
                                            &nbsp; &nbsp;
                                            <a href="javascript:;" onClick="delete_review_comment('<?php echo $gcomment_id; ?>')"><img src="<?php echo SERVER_ADMIN_PATH; ?>images/delet.gif" border="0" title="Delete Comment" class="Action"></a>
                                          </td>
                                        <?php
                                        }
                                        ?>
                                      </tr>
                                    <?php
                                    }
                                  } else {
                                    ?>
                                    <tr>
                                      <td colspan="5" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
                                    </tr>
                                  <?php
                                  }
                                  ?>
                                  <?php
                                  if ($total_pages > 0) {
                                    if ($top_reviews_module_delete == "Yes") {
                                  ?>
                                      <tr>
                                        <td colspan="5" nowrap="nowrap" class="SmallFieldLabel righttd_border">
                                          <span style="float:right; padding-bottom:10px; margin-right:8px;">
                                            <select name="dropdown" onChange="multiple_action('comment_form');">
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
                                        @include("admin.common.paging-playlist") 
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
                      </table>
                    </td>
                  </tr>
                </table>
              </div>
              <!-- End home -->
              <!-- Start pagefooter -->
            </td>
            <td width="10">&nbsp;</td>
          </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td height="20">
         @include("admin.common.footer")
        </td>
    </tr>
    </tbody>
  </table>
  <!-- End pagefooter -->
</body>

</html>