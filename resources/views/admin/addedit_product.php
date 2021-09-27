<?php 

include("includes/top.php");

include("common/security.php");

if($edit_id!="")

{

    $edit_id = base64_decode($edit_id);

	$row = $db->get_row("select product_id, product_cat_id, product_title, product_from, product_url, product_price, product_image from tbl_products where product_id='".$edit_id."'  ",ARRAY_A);

	

	$product_id     = $row['product_id'];

	$product_cat_id = $row['product_cat_id'];

	$product_price  = $row['product_price'];

	$product_title  = stripslashes(html_entity_decode($row['product_title']));

	$product_from   = stripslashes(html_entity_decode($row['product_from']));

	$product_url    = stripslashes(html_entity_decode($row['product_url']));

	$product_image  = stripslashes(html_entity_decode($row['product_image']));

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

<title><?php echo $addedit;?> Product</title>



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

										<td class="heading1"><?php echo $addedit;?> Products</td>

									  </tr>

										

									  <tr>

										<td class="body">

											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">

											  <tbody>

												<tr>

												  <td align="left">

												  <a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a>

													&raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>product_list.php">Products Listing</a>

													<?php

													if($edit_id != '')

													{

													?>

													&raquo; <a>Edit Product</a>

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

													  <form name="product_form" id="product_form" action="" method="post" enctype="multipart/form-data"> 

														  <table class="Panel">

															<tbody>

                                                              

															  <tr>

																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Title:</td>

																<td width="88%">

																<input type="text" name="product_title" id="product_title" value="<?php echo $product_title;?>" class="fields" />

																<span class="Required" /> *</span>																

																</td>

															  </tr>

                                                              <tr>

																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Review Topic:</td>

																<td width="88%">

																<select name="product_cat_id" id="product_cat_id" class="Field300" style="width:320px;">

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

																			if($product_cat_id==$cat_id)

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

																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">From:</td>

																<td width="88%">

																 <input type="text" name="product_from" id="product_from" value="<?php echo $product_from;?>" class="fields"/>		

															   </td>

															  </tr>

															  <tr>

																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">URL:</td>

																<td width="88%">

																 <input type="text" name="product_url" id="product_url" value="<?php echo $product_url;?>" class="fields"/>		
																 <span class="Required"> *</span><br />
                                                                   <span class="Required"> 
                                                                    <strong>like: http://www.google.com/</strong>
                                                                 </span><br />

															   </td>

															  </tr>

															  <tr>

																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Price:</td>

																<td width="88%">

																 <input type="text" name="product_price" id="product_price" value="<?php echo $product_price;?>" class="fields"/> <strong>$	</strong>	

																 <span class="Required"> *</span>

															   </td>

															  </tr>

                                                              <tr>

																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Upload Image:</td>

																<td width="88%">

																<input type="file" name="product_image" id="product_image" />

                                                                </br><span class="Required"/>

                                                                  <strong>Upload only jpg, jpeg,png,gif images</strong>

                                                                </span>

                                                                <?php

																if($product_image!="")

																{

																?>

                                                                </br></br><img src="../site_upload/product_images/<?php echo 'small_thumb_'.$product_image;?>"  border="0"/>

                                                                <?php

																}

																?>																

															   </td>

															  </tr>

                                                              

                                                              <tr>

																<td class="SmallFieldLabel2">&nbsp;</td>

																<td>&nbsp;</td>

															  </tr>

                                                              <tr>

																<td>&nbsp;</td>

																<td>

																<?php

																if(isset($edit_id) && $edit_id != '')

																{

																?>

																<input type="hidden" name="update_id" id="update_id" value="<?php echo $edit_id;?>"/>

																<input name="save" id="save" value="Update" class="FormButton" type="submit" onClick="validate_product();"/>

																<?php

																}

																else

																{

																?>

																<input name="add_product" id="add_product" value="Add" class="FormButton" type="submit" onClick="validate_product();" />

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