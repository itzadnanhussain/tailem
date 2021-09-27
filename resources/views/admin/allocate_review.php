<?php 

include("includes/top.php");

include("common/security.php");

?>

<html>

<head>

<title>Allocate Review</title>



<style>

 .pie{

	 behavior:url(PIE.htc);

 }

 

</style>
<?php
$greview_id   = base64_decode($_REQUEST['key']);
$reviews_list = "select g_review_title,g_review_detail,g_review_rating,g_review_user_id,g_review_ip,g_review_post_date, 
g_status,g_review_suggestion,g_review_category	from tbl_general_review where g_review_id=\"".$greview_id."\" and g_review_allocated='No'";
$general_review_val = $db->get_row($reviews_list,ARRAY_A);
if($general_review_val)
{
	$g_review_title  = stripslashes(html_entity_decode($general_review_val['g_review_title']));
	$g_review_rating = $general_review_val['g_review_rating'];
	$g_review_detail =stripslashes(html_entity_decode($general_review_val['g_review_detail']));
	$g_review_user_id = $general_review_val['g_review_user_id'];
	$g_status     	= $general_review_val['g_status'];
	$g_review_category = $general_review_val['g_review_category'];
	$g_review_category=stripslashes(html_entity_decode($g_review_category));
	$g_review_suggestion = $general_review_val['g_review_suggestion'];
	$suggestion = stripslashes(html_entity_decode($g_review_suggestion));
	$suggestion = wordwrap($suggestion,100," ",true);
	$g_review_category = wordwrap($g_review_category,100," ",true);
	$is_popular     = $general_review_val['is_popular'];
	$g_review_post_date  = $general_review_val['g_review_post_date'];
	$g_review_title  = wordwrap($g_review_title,100," ",true);
	
	$user_select_qry ="select user_name as g_review_user from tbl_users where user_id='".$g_review_user_id."' ";
	$user_select_arr  = $db->get_row($user_select_qry,ARRAY_A);
	$g_review_user = stripslashes(html_entity_decode($user_select_arr['g_review_user']));
	$g_review_user = wordwrap($g_review_user,100," ",true);
}
else
{
?>
	<script>
		window.location.href='<?php echo SERVER_ADMIN_PATH;?>reviews_list_general.php'; 
	</script>	
<?php
}
?>
<?php include("common/header.php");?>

</head>

<body>



<table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">

	<tbody>

		<tr>

			<td style="background-image:URL('images/topbg.png');background-repeat:repeat;height:50px;" height="50">

				<?php include("common/top_right_menu.php"); ?>

			</td>

		</tr>

	

		<tr>

			<td valign="top">

				<table border="0" width="100%">

					<tbody>

						<tr>

							<td width="10">&nbsp;</td>

							<td>

								<div class="BodyContainer">

									<table border="0" cellpadding="0" cellspacing="0" width="550">

									  <tbody>

									  <tr>

										<td class="heading1">Allocate Review</td>

									  </tr>

										

									  <tr>

										<td class="body">

											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="550">

											  <tbody>

												<tr>

												  <td align="left">

												  <a href="<?php echo SERVER_ADMIN_PATH;?>/index.php">Home</a>

												  &raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>reviews_list_general.php">General Review Listing</a>

												  &raquo; <a>Allocate Review</a>

													

												  </td>

												</tr>

												

												<?php if(isset($errorstr) && $errorstr!=""){ ?>

												<tr>

												  <td colspan="8">

													<table border="0" cellpadding="0" cellspacing="0" class="Message">

														<tbody>

															<tr>

																<td width="20" valign="top">

																<?php if($case==1){ ?>

																<img src="images/success_icon.png" vspace="5" width="18" height="18" hspace="10">

																<?php } ?>

																<?php if($case==2){ ?>

																<img src="images/warning_icon.png" vspace="5" width="18" height="18" hspace="10">

																<?php } ?>

																<?php if($case==0){ ?>

																<img src="images/error_icon.png" vspace="5" width="18" height="18" hspace="10">

																<?php } ?>											</td>

																<td width="100%"><?php echo $errorstr; ?></td>

															</tr>

														</tbody>

													</table>

												  </td>

												</tr>

												<?php } ?>

																								

    <tr>

      <td>
		 
          <form name="allocate_review_form" id="allocate_review_form" action="" method="post" enctype="multipart/form-data"> 
          	<?php
			if($general_review_val)
			{
			?>
          		<input type="hidden" name="greview_id" id="greview_id" value="<?php echo $greview_id;?>" />
			<?php
			}
			?>
              <table width="500" class="add_allocate_tabel">

                <tbody>

                  <tr>

                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Rating:</td>

                    <td width="88%">

                    <select name="review_rating" id="review_rating" style="padding:4px 1px;width:150px;">

                    	<option value="">---  Select Rating --- </option>

                    	<?php

						for($i=1;$i<=10;$i=$i+0.5)

						{
							if($i==$g_review_rating)
							{
								$select_rating = 'selected="selected"';
							}
							else
							{
								$select_rating = '';
							}
						?>

                        	<option value="<?php echo $i;?>" <?php echo $select_rating;?>><?php echo $i;?></option>

                        <?php

						}

						?>

                    </select>	

                    <span class="Required">*</span>

                    </td>

                  </tr>

                  <tr>

                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Review Title:</td>

                    <td width="88%">

                    <textarea name="review_title" id="review_title" style="width:650px;height:93px;"><?php echo $g_review_title;?></textarea>	

                    <span class="Required">*</span>

                    </td>

                  </tr>

                  <tr>

                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Review Details:</td>

                    <td width="88%">

                    <textarea name="review_detail" id="review_detail" style="width:649px;height:130px;"><?php echo $g_review_detail;?></textarea>		

                    <span class="Required">*</span>

                    </td>

                  </tr>

                  

                  <tr>

                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">User:</td>

                    <td width="88%">

                    <select name="review_user_id" id="review_user_id" style="width:300px;padding:4px 1px;">

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

                            if($g_review_user_id==$user_id)

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

                    <span class="Required">*</span>

                    </td>

                  </tr>

                  

                  <tr>
                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Levle1 Category:</td>
                    <td width="88%">
                    
                    <select name="level1_cat_id" id="level1_cat_id" style="width:300px;padding:4px 1px;" onChange="category_level2_review(this.value)">
                      <option value="">--Please Select Levle1 Category--</option>																		
                        <?php
                        $sql_qry="Select cat_id,cat_name from tbl_categories
                        where status='1' and parent_id='0' and level='1'";
                        $sql_arr = $db->get_results($sql_qry,ARRAY_A);
                        if($sql_arr)
                        {
                            foreach($sql_arr as $val)
                            {
                                $cat_id = $val['cat_id'];
                                $cat_name = stripcslashes(html_entity_decode($val['cat_name']));														
                        ?>
                        <option value="<?php echo $cat_id;?>"><?php echo $cat_name;?></option>							
            <?php
                          }
                      }
                    ?>
                    </select>
                    <span class="Required"> *</span>
                    </td>
                  </tr>
                  <tr><td id="load_level2_id" colspan="2"></td></tr>
                  <tr><td id="load_level3_id" colspan="2"></td></tr>
                  <tr><td id="load_level4_id" colspan="2"></td></tr>
				  <tr><td id="load_level5_id" colspan="2"></td></tr>
                  <tr>

                    <td class="SmallFieldLabel2">&nbsp;</td>

                    <td>&nbsp;</td>

                  </tr>

                  <tr>

                    <td>&nbsp;</td>

                    <td>

                    	<input name="add_review" id="add_review" value="Add" class="FormButton" type="submit" onClick="validate_allocate_review();"/>

                    </td>

                  </tr>

                </tbody>

              </table>						  

          </form>

      </td>
	  <td>
       <?php
	  if($general_review_val)
	  {
	  ?>
        <table border="0" cellpadding="0" cellspacing="0" class="allocate_review_table">
            <tr height="70">
                <td class="SmallFieldLabelnew font_bold" align="center" colspan="2">
                    General Review Details
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
                <td align="left"><?php echo $g_review_user;?>
                </td>
            </tr>
            <tr height="30">
                <td class="SmallFieldLabelnew font_bold" align="left" width="150">
                Post date
                </td>
                <td align="left"><?php echo date("d M Y",$g_review_post_date);?>
                </td>
            </tr>
            <tr class="last">
              <td colspan="2">&nbsp;</td>
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
      </td>
    </tr>

												<tr>

												  <td>&nbsp;</td>

												</tr>

											  </tbody>

											</table>

										</td>

									  </tr>

									  </tbody>

									</table>

								</div>

							</td>

							<td width="10">&nbsp;</td>

						</tr>

					</tbody>

				</table>

			</td>

		</tr>

		<tr><td height="20"><?php include("common/footer.php");?></td></tr>

	</tbody>

</table>

<!-- End pagefooter -->

</body>



</html>