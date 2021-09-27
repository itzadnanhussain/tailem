<?php 
include("includes/top.php");
include("common/security.php");
if($edit_id!="")
{
	$edit_id = base64_decode($edit_id);
	$row  =  $db->get_row("select cat_id,parent_id,cat_name, description, image_name,level from tbl_categories where cat_id='".$edit_id."' and parent_id!='0' ",ARRAY_A);
	$db_cat_id    = $row['cat_id'];
	$db_parent_id = $row['parent_id'];
	$db_level    = $row['level'];
	$cat_name 	  = stripslashes(html_entity_decode($row['cat_name']));
	$description = stripslashes(html_entity_decode($row['description']));
	$image_name   = stripslashes(html_entity_decode($row['image_name']));
}
if($db_cat_id!="")
{
	$addedit = 'Edit';
}
else
{
	$addedit = 'Add';
	$db_cat_id = 'a';
	$db_parent_id = 'b';
}

function hasChild($parent_id,$db)
{
	$count_qry = "SELECT COUNT(cat_id) as count FROM tbl_categories WHERE parent_id = '".$parent_id ."'";
	$count_arr = $db->get_row($count_qry,ARRAY_A);
	return $count     = $count_arr['count'];
}
function CategoryTree($cat_id,$db_cat_id,$db_parent_id,$db)
{
	$sql_qry="Select cat_id,cat_name,level from tbl_categories where status='1' and parent_id='".$cat_id."' and cat_id!='".$db_cat_id."' and level<=4";
	$sql_arr = $db->get_results($sql_qry,ARRAY_A);
	if($sql_arr)
	{
		foreach($sql_arr as $val)
		{
			$cat_id   = $val['cat_id'];
			$level    = $val['level'];
			$cat_name = stripcslashes(html_entity_decode($val['cat_name']));
			$dash="";
			$double_level = $level * 2;
			for($i=1;$i<=$double_level;$i++)
			{
				$dash .= '- ';
				if($i==$double_level)
				{
					$dash .='&nbsp;';
				}
			}
			if($db_parent_id==$cat_id)
			{
				$selected1= "selected='selected'";
			}
			else
			{
				$selected1= "";
			}
			?>
			<option value="<?php echo $cat_id;?>" <?php echo $selected1;?>><?php echo $dash.$cat_name;?></option>							
			<?php
			CategoryTree($cat_id,$db_cat_id,$db_parent_id,$db);
		}
	}
}
?>
<html>
<head>
<title><?php echo $addedit;?> Sub Category</title>

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
										<td class="heading1"><?php echo $addedit;?> Sub Category</td>
									  </tr>
										
									  <tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
											  <tbody>
												<tr>
												  <td align="left">
												  <a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a>
													&raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>sub_cat_list.php">Sub Category Listing</a>
													<?php
													if($edit_id != '')
													{
													?>
													&raquo; <a>Edit Sub Category</a>
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
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Parent Category:</td>
																<td width="88%">
                                                                <?php
																if($db_level==5 && $db_cat_id!='')
																{
																	$record_id = $db_cat_id;
																}
																else
																{
																	$record_id = 'none';
																}
																?>
                                        <select name="parent_id" id="parent_id" class="Field300" style="width:251px;" onChange="get_category_level5_attributes(this.value,'<?php echo $record_id;?>')">
                                                   <option value="">--Please Select Parent Category--</option>																		
                                                                    <?php
                                                                    $sql_qry="Select cat_id,cat_name from tbl_categories
                                                                    where status='1' and parent_id='0'";
                                                                    $sql_arr = $db->get_results($sql_qry,ARRAY_A);
                                                                    if($sql_arr)
                                                                    {
                                                                        foreach($sql_arr as $val)
                                                                        {
																			$cat_id = $val['cat_id'];
																			$cat_name = stripcslashes(html_entity_decode($val['cat_name']));														
																			if($db_parent_id==$cat_id)
																			{
																				$selected= "selected='selected'";
																			}
																			else
																			{
																				$selected= "";
																			}
																	?>
																	<option value="<?php echo $cat_id;?>" <?php echo $selected;?>><?php echo $cat_name;?></option>							
														<?php
																     CategoryTree($cat_id,$db_cat_id,$db_parent_id,$db);
																	  }
																  }
																?>
                                                                </select>
                                                                <span class="Required"> *</span>
																</td>
															  </tr>
                                                              <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Description:</td>
																<td width="88%">
															  <textarea name="description" id="description" style="width:590px;height:182px;"><?php echo $description;?></textarea> 
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
																<?php
																if(isset($edit_id) && $edit_id != '' && $db_cat_id!="")
																{
																?>
																<input type="hidden" name="update_id" id="update_id" value="<?php echo $edit_id; ?>">
																<input name="save" id="save" value="Update" class="FormButton" type="submit" onClick="validate_sub_cat();"/>
																<?php
																}
																else
																{
																?>
																<input name="add_cat" id="add_cat" value="Add" class="FormButton" type="submit" onClick="validate_sub_cat();" />
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
        <?php
		if($db_cat_id!="" && $db_level=='5')
		{
		?>
			<script>
                get_category_level5_attributes('<?php echo $db_cat_id;?>','<?php echo $record_id;?>');
            </script>
        <?php
		}
		?>
		<tr><td height="20"><?php include("common/footer.php");?></td></tr>
	</tbody>
</table>
<!-- End pagefooter -->
</body>

</html>