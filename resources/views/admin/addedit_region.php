<?php 
include("includes/top.php");
include("common/security.php");
if($edit_id!=""){
	
	$edit_id = base64_decode($edit_id);
	$row  =  $db->get_row("select country_id,region_name from tbl_regions where region_id='".$edit_id."'",ARRAY_A);
	$region_name 	= stripslashes($row['region_name']);
	$countryid 	= stripslashes($row['country_id']);
	$addedit = 'Edit';
}
else
{
	
	$addedit = 'Add';
}
?>
<html>
<head>
<title>Add/Edit Region</title>
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
										<td class="heading1"><?php echo $addedit;?> Region</td>
									  </tr>
										
									  <tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
											  <tbody>
												<tr>
												  <td align="left">
												  <a href="<?php echo SERVER_ADMIN_PATH;?>/index.php">Home</a>
												  &raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>countries_listing.php">Region Listing</a>
												  &raquo; <a><?php echo $addedit;?> Region</a>
													
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
          <form name="region_frm" id="region_frm" action="" method="post" enctype="multipart/form-data"> 
              <table class="Panel">
                <tbody>
                  <tr>
                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Region Name:</td>
                    <td width="88%">
                    <input type="text" name="region_name" id="region_name" value="<?php echo $region_name;?>" class="fields"><span class="Required">*</span>
                    </td>
                  </tr>
                  <tr>
                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Country:</td>
                    <td width="88%">
                     <?php
					 $select_qry ="select country_id,name from tbl_countries order by name asc";
					 $select_arr = $db->get_results($select_qry,ARRAY_A);
					 if($select_arr)
					 {
					 ?>
                     <select name="country_id" id="country_id">
                     	<option value="">---Please Select Country---</option>
                     	<?php
					 	foreach($select_arr as $val)
						{
							$country_id = $val['country_id'];
							$name	    = html_entity_decode(stripslashes($val['name']));
							if($country_id==$countryid || $country_id==$_REQUEST['country_id'])
							{
								$selected = "selected='selected'";
							}
							else
							{
								$selected = "";
							}
						?>
                        <option value="<?php echo $country_id;?>" <?php echo $selected;?>><?php echo $name;?></option>
						<?php
						}
						?>
                     </select>
					 <?php	
					 }
					 ?>
                     <span class="Required">*</span>
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
                        <input name="Updateregion" id="Updateregion" value="Update" class="FormButton" type="submit" onClick="validate_region();"/>
                    <?php
                    }
                    else
                    {
                    ?>
                    	<input name="Addregion" id="Addregion" value="Add" class="FormButton" type="submit" onClick="validate_region();"/>
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