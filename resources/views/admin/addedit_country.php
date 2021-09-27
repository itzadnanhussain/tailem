<?php 
include("includes/top.php");
include("common/security.php");
if($edit_id!=""){
	
	$edit_id = base64_decode($edit_id);
	$row  =  $db->get_row("select name from tbl_countries where country_id='".$edit_id."'",ARRAY_A);
	$name 	= stripslashes($row['name']);
	$addedit = 'Edit';
}else{
	
	$addedit = 'Add';
}
?>
<html>
<head>
<title>Add/Edit Country</title>
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
										<td class="heading1"><?php echo $addedit;?> Country</td>
									  </tr>
										
									  <tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
											  <tbody>
												<tr>
												  <td align="left">
												  <a href="<?php echo SERVER_ADMIN_PATH;?>/index.php">Home</a>
												  &raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>countries_listing.php">Countries Listing</a>
												  &raquo; <a><?php echo $addedit;?> Country</a>
													
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
          <form name="Country_frm" id="Country_frm" action="" method="post" enctype="multipart/form-data"> 
              <table class="Panel">
                <tbody>
                  <tr>
                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Country Name:</td>
                    <td width="88%">
                    <input type="text" name="name" id="name" value="<?php echo $name;?>" class="fields"><span class="Required">*</span>
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
                        <input name="UpdateCountry" id="UpdateCountry" value="Update" class="FormButton" type="submit" onClick="validate_country();"/>
                    <?php
                    }
                    else
                    {
                    ?>
                    	<input name="AddCountry" id="AddCountry" value="Add" class="FormButton" type="submit" onClick="validate_country();"/>
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