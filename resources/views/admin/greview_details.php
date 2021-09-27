<?php 
include("includes/top.php");
include("common/security.php"); 
?>
<html>
<head>
<title>General Review Details</title>
<?php include("common/header.php");?>

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
                        <td class="heading1">Review Details</td>
                      </tr>
                      <tr>
                        <td class="body">&nbsp; </td>
                      </tr>
                      <tr>
                        <td>
                        	<a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo;<a> <a href="<?php echo SERVER_ADMIN_PATH;?>reviews_list_general.php">General Review</a> &raquo;<a>General Review Details</a>
                        </td>
                      </tr>
                  </table>
                  <?php
				  	$greview_id = base64_decode($_REQUEST['key']);
					$reviews_list="select g_review_title,g_review_detail, 
					g_review_rating,g_review_user_id, g_review_ip,g_review_post_date, 
					g_status,g_review_suggestion,g_review_category	from tbl_general_review
					where g_review_id=\"".$greview_id."\"  ";
					$val	=	$db->get_row($reviews_list,ARRAY_A);
					
					if($val)
					{
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
				  ?>
                  <table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:20px;">
                              
                              <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" class="review_detail_table">
                                        <tbody>
                                            <tr height="70">
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    Review Details
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Suggestion
                                                </td>
                                                <td align="left"><?php echo $g_review_suggestion;?>
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Categories
                                                </td>
                                                <td align="left"><?php echo $g_review_category;?>
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Rating
                                                </td>
                                                <td align="left"><?php echo $g_review_rating;?>
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Review Title
                                                </td>
                                                <td align="left"><?php echo $g_review_title;?>
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Review Details
                                                </td>
                                                <td align="left"><?php echo $g_review_detail;?>
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                User Name
                                                </td>
                                                <td align="left"><?php echo $user_name;?>
                                                </td>
                                            </tr>
                                            <tr height="30" class="last">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Post date
                                                </td>
                                                <td align="left"><?php echo date("d M Y",$g_review_post_date);?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                
                                
                                </td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                          </table>
                  <?php
				  }
				  else
				  {
				  	echo '<table border="0" cellpadding="0" cellspacing="0" class="no_review">
							<tr><td> No Record Found</td></tr></table>';
				  }
				  ?>
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
