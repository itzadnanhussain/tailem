<?php 
include("includes/top.php");
include("common/security.php");
if($edit_id!=""){
	
	$edit_id = base64_decode($edit_id);
	$row  =  $db->get_row("select slideshow_id,slideshow_title,slideshow_image,slideshow_position from tbl_slideshow 
	where slideshow_id='".$edit_id."'",ARRAY_A);
	$slideshow_id    = $row['slideshow_id'];
	$slideshow_title = stripslashes(html_entity_decode($row['slideshow_title']));
	$slideshow_image = stripslashes(html_entity_decode($row['slideshow_image']));
	$slideshow_position = $row['slideshow_position'];
	$addedit = 'Edit';
}else{
	
	$addedit = 'Add';
}
?>
<html>
<head>
<title><?php echo $addedit;?> Slide Show</title>
<script language="javascript" type="text/javascript">

function toggleChecked(status)
{
	
	$(".check-all").each( function() {
		$(this).attr("checked",status);
	})
}



</script>
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
										<td class="heading1"><?php echo $addedit;?> Slide Show</td>
									  </tr>
										
									  <tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
											  <tbody>
												<tr>
												  <td align="left">
												  <a href="<?php echo SERVER_ADMIN_PATH;?>/index.php">Home</a>
												  &raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>slide_show_list.php">Slide Show Listing</a>
												  &raquo; <a><?php echo $addedit;?> Slide Show</a>
													
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
          <form name="slide_show_form" id="slide_show_form" action="" method="post" enctype="multipart/form-data"> 
              <table class="Panel">
                <tbody>
                  <tr>
                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Title:</td>
                    <td width="88%">
                    <input type="text" name="slideshow_title" id="slideshow_title" value="<?php echo $slideshow_title;?>" class="fields"/>	
                    <span class="Required">*</span>
                    </td>
                  </tr>
                  <tr>
                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Position:</td>
                    <td width="88%">
                    <select name="slideshow_position" id="slideshow_position" class="fields">
                    	<option value="">.....Please Select Position.....</option>
                        <option value="Top" <?php if($slideshow_position=='Top'){ echo "selected='selected'";} ?>>Top</option>
                        <option value="Bottom" <?php if($slideshow_position=='Bottom'){ echo "selected='selected'";} ?>>Bottom</option>
                    </select>
                    <span class="Required">*</span>
                    </td>
                  </tr>
                  <tr>
                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Upload Image:</td>
                    <td width="88%">
                    <input type="file" name="image_name" id="image_name" />
                    </br>
                     <span class="Required"/>
                      <strong>Please Upload image of size 704px X 332pxpx.<br/> 
                      Upload only JPG,GIF or PNG format</strong>
                    </span>
                    <?php
                    if($slideshow_image!="")
                    {
                    ?>
                    </br></br>
                    <img src="<?php echo SERVER_ROOTPATH;?>site_upload/slideshow_images/<?php echo 'small_thumb_'.$slideshow_image;?>" border="0" />
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
                        <input type="hidden" name="update_id" id="update_id" value="<?php echo $edit_id; ?>">
                        <input name="update_record" id="update_record" value="Update" class="FormButton" type="submit" onClick="validate_slide_show();"/>
                    <?php
                    }
                    else
                    {
                    ?>
                    	<input name="add_slide" id="add_slide" value="Add" class="FormButton" type="submit" onClick="validate_slide_show();"/>
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