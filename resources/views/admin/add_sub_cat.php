<?php 
include("includes/top.php");
include("common/security.php");
?>
<html>
<head>
<title>Add Sub Category</title>

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
										<td class="heading1">Add Sub Category</td>
									  </tr>
										
									  <tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
											  <tbody>
												<tr>
												  <td align="left">
												  <a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a>
													&raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>sub_cat_list.php">Sub Category Listing</a> &raquo; <a>Add Sub Category</a>
												  
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
													  <form name="sub_cat_form" id="sub_cat_form" action="" method="post" enctype="multipart/form-data"> 
														  <table class="Panel">
															<tbody>
                                                              
															  <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Category Name:</td>
																<td width="88%">
																<input type="text" name="cat_name" id="cat_name" value="<?php echo $cat_name;?>" class="fields" /> <span class="Required" /> *</span>
																</td>
															  </tr>
                                                              
                                                              <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Main Category:</td>
																<td width="88%">
                                                                
                                                                <select name="parent_id" id="parent_id" class="Field300" style="width:251px;" onChange="get_category_level2_details(this.value)">
                                                                  <option value="">--Please Select Main Category--</option>																		
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
                                                              
                                                              <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Description:</td>
																<td width="88%">
															  <textarea name="description" id="description" style="width:590px;height:182px;"><?php echo $description;?></textarea> 
																</td>
															  </tr>
                                                              
                                                                <tr>
                                                                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Upload Main Image:</td>
                                                                    <td width="88%">
                                                                        <input type="file" name="image_name" id="image_name" style="vertical-align:top;"/> <br />
                                                                        <span class="Required" style="font-weight:bold;">Upload only jpg, jpeg,png,gif images</span>
                                                                        <br />
                                                                        <?php
                                                                        if($image_name!="")
                                                                        {
                                                                        ?>
                                                                            <img src="<?php echo SERVER_ROOTPATH;?>site_upload/category_images/<?php echo 'small_thumb_'.$image_name;?>"  border="0"/>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                              	<td id="level5_attributes_id" colspan="2"></td>
                                                              </tr>
                                                              
                                                              <tr>
																<td class="SmallFieldLabel2">&nbsp;</td>
																<td>&nbsp;</td>
															  </tr>
                                                              <tr>
																<td>&nbsp;</td>
																<td>
																<input name="add_cat" id="add_cat" value="Add" class="FormButton" type="submit" onClick="validate_add_sub_cat();" />
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