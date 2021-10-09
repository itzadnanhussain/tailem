@include("admin.includes.top")
@include("admin.common.security")
<?php 
 error_reporting(0);
if($edit_id!="")
{
	$edit_id = base64_decode($edit_id);

	$row  =  \App\Models\Songs::GetRawDataAdmin("select * from tbl_store_img where store_id='".$edit_id."'");
	$store_id  		= $row['store_id'];
	$store_title  	= $row['store_title'];
	$store_img  	= $row['store_img'];
	$addedit 		= 'Edit';
}
else
{
	$addedit = 'Add';
}
?>
<html>
<head>
    <title>Add Stores Images</title>
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
										<td class="heading1"><?php echo $addedit;?> Stores Image</td>
									  </tr>
										
									  <tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
											  <tbody>
												<tr>
												  <td align="left">
												  <a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a>
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
													  <form name="store_images_form" id="store_images_form" action="" method="post" enctype="multipart/form-data"> 
														  <table class="Panel">
															<tbody>
                                                            <?php if($store_id == 1){?>
                                                             <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Itunes Image:</td>
																<td width="88%">
																 <input type="file" name="itune_img" id="itune_img"/>
                                                                 
                   <?php
									if($store_img!="")
											{ ?>
												
                                                  <img src="<?php echo SERVER_ROOTPATH;?>site_upload/artist_images/<?php echo $store_img;?>"  border="0" width="50" height="50" />
                                                <?php }
											else
											{
												?>
                                                 <img src="<?php echo SERVER_ROOTPATH;?>assets/images/no_image.png"  border="0" width="50" height="50" />
                                                <?php
											}
										?>	
                    
																</td>
															  </tr>
                                                             <?php } if($store_id ==2){?>
                                                              <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Amazon Image:</td>
																<td width="88%">
																 <input type="file" name="amazon_img" id="amazon_img" />
                   <?php
									if($store_img!="")
											{ ?>
												
                                                  <img src="<?php echo SERVER_ROOTPATH;?>site_upload/artist_images/<?php echo $store_img;?>"  border="0" width="50" height="50" />
                                                <?php }
											else
											{
												?>
                                                 <img src="<?php echo SERVER_ROOTPATH;?>assets/images/no_image.png"  border="0" width="50" height="50" />
                                                <?php
											}
										?>	
                   												</td>
															  </tr>
                                                               <?php } if($store_id ==3){?>
                                                              <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Google Image:</td>
																<td width="88%">
																 <input type="file" name="google_img" id="google_img" />
                   <?php
									if($store_img!="")
											{ ?>
												
                                                  <img src="<?php echo SERVER_ROOTPATH;?>site_upload/artist_images/<?php echo $store_img;?>"  border="0" width="50" height="50" />
                                                <?php }
											else
											{
												?>
                                                 <img src="<?php echo SERVER_ROOTPATH;?>assets/images/no_image.png"  border="0" width="50" height="50" />
                                                <?php
											}
										?>								</td>
															  </tr>
                                                              <?php }?>
                                                              
                                                              
                                                              <tr>
																<td>&nbsp;</td>
																<td>
																<?php
																if(isset($edit_id) && $edit_id != '')
																{
																?>
																<input type="hidden" name="update_id" id="update_id" value="<?php echo $edit_id; ?>">
																<input name="save" id="save" value="Update" class="FormButton" type="submit" onClick="validate_store_images();" />
																<?php
																}
																else
																{
																?>
																<input name="add_cat" id="add" value="Add" class="FormButton" type="submit" onClick="validate_store_images();" />
																<?php
																}
																?>
                                                                <div id="loader"></div>
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
			@include("admin.common.footer") </td></tr>
	</tbody>
</table>
<!-- End pagefooter -->
</body>

</html>