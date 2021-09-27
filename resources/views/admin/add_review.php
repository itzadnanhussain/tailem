<?php 

include("includes/top.php");

include("common/security.php");

?>

<html>

<head>

<title>Add Review</title>



<style>

 .pie{

	 behavior:url(PIE.htc);

 }

 

</style>



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

									<table border="0" cellpadding="0" cellspacing="0" width="100%">

									  <tbody>

									  <tr>

										<td class="heading1">Add Review</td>

									  </tr>

										

									  <tr>

										<td class="body">

											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">

											  <tbody>

												<tr>

												  <td align="left">

												  <a href="<?php echo SERVER_ADMIN_PATH;?>/index.php">Home</a>

												  &raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>reviews_list.php">Review Listing</a>

												  &raquo; <a>Add Review</a>

													

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

          <form name="add_review_form" id="add_review_form" action="" method="post" enctype="multipart/form-data"> 

              <table class="Panel">

                <tbody>

                  <tr>

                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Rating:</td>

                    <td width="88%">

                    <select name="review_rating" id="review_rating" style="padding:4px 1px;width:150px;">

                    	<option value="">---  Select Rating --- </option>

                    	<?php

						for($i=1;$i<=10;$i=$i+0.5)

						{

						?>

                        	<option value="<?php echo $i;?>"><?php echo $i;?></option>

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

                    <textarea name="review_title" id="review_title" style="width:650px;height:93px;"></textarea>	

                    <span class="Required">*</span>

                    </td>

                  </tr>

                  <tr>

                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Review Details:</td>

                    <td width="88%">

                    <textarea name="review_detail" id="review_detail" style="width:651px;height:197px;"></textarea>		

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

                            if($_REQUEST['review_user_id']==$user_id)

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

                    	<input name="add_review" id="add_review" value="Add" class="FormButton" type="submit" onClick="validate_add_review();"/>

                    </td>

                  </tr>

                </tbody>

              </table>						  

          </form>

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