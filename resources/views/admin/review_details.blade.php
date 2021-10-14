@include("admin.includes.top")
@include("admin.common.security") 
<?php
error_reporting(0);
?>

<html>
<head>
<title>Review Details</title>
 @include("admin.common.header") 

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
                        <td class="heading1">Review Details</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index">Home</a> &raquo; <a>&raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>reviews_list">Review Listing</a>&raquo; <a>Review Details</a></td>
                              </tr>
							  <?php
                              $key  = $_REQUEST['key'];
                              $reviewsid = base64_decode($key);
                              $reviews_list="select review_title, review_detail, review_rating, 
                              review_user_id, review_ip, review_post_date, status, is_popular 
                              from tbl_reviews where review_id='".$reviewsid."' ";
                              $reviews_arr	=	\App\Models\Songs::GetRawDataAdmin($reviews_list);
                              if($reviews_arr)
                              {
                              ?>
                              <tr>
                              	<td>
                                <?php
								
									$review_title  = stripslashes(html_entity_decode($reviews_arr['review_title']));
									$review_rating = $reviews_arr['review_rating'];
									$review_detail =stripslashes(html_entity_decode($reviews_arr['review_detail']));
									$review_user_id = $reviews_arr['review_user_id'];
									$status     	= $reviews_arr['status'];
									$category_id    = $reviews_arr['category_id'];
									$is_popular     = $reviews_arr['is_popular'];
									$review_post_date  = $reviews_arr['review_post_date'];
									$review_title  = wordwrap($review_title,100," ",true);
									
									$select_qry ="select user_name from tbl_users where 
									user_id='".$review_user_id."' ";
									$select_ar  = \App\Models\Songs::GetRawDataAdmin($select_qry);
									$user_name = stripslashes(html_entity_decode($select_ar['user_name']));
									$user_name = wordwrap($user_name,100," ",true);
									
									// $cat_qry ="select cat_name from tbl_categories where 
									// cat_id='".$category_id."' ";
									// $cat_arr  = \App\Models\Songs::GetRawDataAdmin($cat_arr);
									// $cat_name = stripslashes(html_entity_decode($cat_arr['cat_name']));
									// $cat_name = wordwrap($cat_name,100," ",true);
								?>
                                <table border="0" cellpadding="0" cellspacing="0" align="center" class="report_table">
                                        <tbody>
                                            <tr height="50">
                                                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                                                    Review Details
                                                </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Review Title
                                                </td>
                                                <td align="left"><?php echo $review_title;?> </td>
                                            </tr>
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Review Rating
                                                </td>
                                                <td align="left"><?php echo $review_rating;?> </td>
                                            </tr>
                                            
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Review User Name
                                                </td>
                                                <td align="left"><?php echo $user_name;?> </td>
                                            </tr>
                                       
                                            <tr height="30">
                                                <td class="SmallFieldLabelnew font_bold" align="left"  width="150"> 
                                                	Post Date
                                                </td>
                                                <td align="left"><?php echo date("d M Y",$review_post_date);?>
                                            </tr>
                                            <tr height="30" class="last">
                                                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                                                Review Details
                                                </td>
                                                <td align="left"><?php echo $review_detail;?> </td>
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
