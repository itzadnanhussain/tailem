@include("admin.includes.top")
@include("admin.common.security")
<?php 

if($edit_id!="")
{
	$edit_id = base64_decode($edit_id);

	$qry  =  "select cat_id,cat_name from tbl_categories where cat_id='".$edit_id."'";
	$row = \App\Models\Songs::GetRawDataAdmin($qry); 
	$cat_id  = $row['cat_id'];
	$cat_name 	  = stripslashes(html_entity_decode($row['cat_name']));
	
	$addedit = 'Edit';
}
else
{
	$addedit = 'Add';
}
?>
<html>
<head>
<title><?php echo $addedit;?> Main Category</title>

<style>
 .pie{
	 behavior:url(PIE.htc);
 }
</style>

@include("admin.common.header")
</head>
<body>

<table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">
	<tbody>
		<tr>
            <td style="background:#1F3C5C; background-repeat:repeat-x; height:60px;" height="60">
                @include("admin.common.top_right_menu")
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
										<td class="heading1"><?php echo $addedit;?> Main Category</td>
									  </tr>
										
									  <tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
											  <tbody>
												<tr>
												  <td align="left">
												  <a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a>
													&raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>main_cat_list.php">Main Category Listing</a>
													<?php
													if($edit_id != '')
													{
													?>
													&raquo; <a><?php echo $addedit;?> Main Category</a>
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
													  <form name="main_cat_form" id="main_cat_form" action="" method="post" enctype="multipart/form-data"> 
														  <table class="Panel">
															<tbody>
                                                              
															  <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Category Name:</td>
																<td width="88%">
																<input type="text" name="cat_name" id="cat_name" value="<?php echo $cat_name;?>" class="fields" /> <span class="Required" /> *</span>
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
																<input type="hidden" name="update_id" id="update_id" value="<?php echo $edit_id; ?>">
																<input name="save" id="save" value="Update" class="FormButton" type="submit" onClick="validate_main_cat();"/>
																<?php
																}
																else
																{
																?>
																<input name="add_cat" id="add_cat" value="Add" class="FormButton" type="submit" onClick="validate_main_cat();" />
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
		<tr><td height="20">
			@include("admin.common.footer")
		</td></tr>
	</tbody>
</table>
<!-- End pagefooter -->
</body>

</html>