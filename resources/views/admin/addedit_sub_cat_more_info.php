<?php 
include("includes/top.php");
include("common/security.php");
if($edit_id!="")
{
    $edit_id = base64_decode($edit_id);
	$row = $db->get_row("select more_info_id, sub_cat_id, more_info_data from tbl_categories_more_info 
	where more_info_id='".$edit_id."' ",ARRAY_A);
	$more_info_id    = $row['more_info_id'];
	$sub_cat_id      = $row['sub_cat_id'];
	$more_info_data  = stripslashes(html_entity_decode($row['more_info_data']));
}
if($db_cat_id!="")
{

	$addedit = 'Edit';
}
else
{
	$addedit = 'Add';
}
?>

<html>

<head>

<title><?php echo $addedit;?> Category More Info</title>



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

            <td style="background:#1F3C5C; background-repeat:repeat-x; height:60px;" height="60">

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

										<td class="heading1"><?php echo $addedit;?> Category More Info</td>

									  </tr>

										

									  <tr>

										<td class="body">

											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">

											  <tbody>

												<tr>

												  <td align="left">

												  <a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a>

													&raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>sub_cat_more_info_list.php">Category More Info Listing</a>

													<?php

													if($edit_id != '')

													{

													?>

													&raquo; <a>Edit Category More Info</a>

													<?php

													}

													?>

												  

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

													  <form name="more_info_form" id="more_info_form" action="" method="post" enctype="multipart/form-data"> 

														  <table class="Panel">

															<tbody>
                                                              <tr>

																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Review Topic:</td>

																<td width="88%">

																<select name="sub_cat_id" id="sub_cat_id" class="Field300" style="width:580px;">

                                                                  <option value=""> ---------------- Please Select Review Topic ---------------- </option>

                                                                  <?php

                                                                    $sql_qry="Select cat_id,cat_name,parent_id from tbl_categories where status='1' and level='5'";

                                                                    $sql_arr = $db->get_results($sql_qry,ARRAY_A);

                                                                    if($sql_arr)

                                                                    {

                                                                        foreach($sql_arr as $val)

                                                                        {

																			$cat_id = $val['cat_id'];
																			$parent_id = $val['parent_id'];

																			$cat_name = stripcslashes(html_entity_decode($val['cat_name']));														
																			include("cat_hierarchy.php");

																			if($sub_cat_id==$cat_id)

																			{

																				$selected= "selected='selected'";

																			}

																			else

																			{

																				$selected= "";

																			}
																			

																	?>

                                                                  <option value="<?php echo $cat_id;?>" <?php echo $selected;?>><?php echo $level1_name;?> -> <?php echo $level2_name;?> -> <?php echo $level3_name;?> -> <?php echo $level4_name;?> -> <?php echo $cat_name;?></option>

                                                                  <?php

																	  }

																  }

																?>

                                                                </select>

															    <span class="Required"> *</span>																</td>

															  </tr>

															  <tr>

																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">More Info Data:</td>

																<td width="88%">

																<?php
																include_once 'ckeditor/ckeditor.php';  
																$more_info_data = stripslashes(html_entity_decode($rowpointchk['more_info_data']));
																$ckeditor = new CKEditor();
																$ckeditor->basePath = '';
																$ckeditor->config['filebrowserBrowseUrl'] = '/ckfinder/ckfinder.html';
																$ckeditor->config['filebrowserImageBrowseUrl'] =	
																'ckeditor/ckfinder/ckfinder.html?type=Images';
																$ckeditor->config['filebrowserFlashBrowseUrl'] = 
																'ckeditor/ckfinder/ckfinder.html?type=Flash';
																$ckeditor->editor('more_info_data',$more_info_data);
																?>
																
															
                                                           
                                                            </td>

															  </tr>
                                                              <tr>

																<td>&nbsp;</td>

																<td>

																<?php

																if(isset($edit_id) && $edit_id != '')

																{

																?>

																<input type="hidden" name="update_id" id="update_id" value="<?php echo $edit_id;?>"/>

																<input name="save" id="save" value="Update" class="FormButton" type="submit" onClick="validate_category_more_info();"/>

																<?php

																}

																else

																{

																?>

																<input name="add" id="add" value="Add" class="FormButton" type="submit" onClick="validate_category_more_info();" />

																<?php

																}

																?>																

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