<?php 
include("includes/top.php");
include("common/security.php");
if($edit_id!="")
{
	$edit_id = base64_decode($edit_id);

	$row  =  $db->get_row("select faq_id,question,answer from tbl_faq where faq_id='".$edit_id."'",ARRAY_A);
	$question 	= stripslashes(html_entity_decode($row['question']));
	$db_cat_id  = $row['cat_id'];
	$answer     = stripslashes(html_entity_decode($row['answer']));
	$addedit = 'Edit';
}
else
{
	$addedit = 'Add';
}
?>
<html>
<head>
<title>Add Faq</title>

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
										<td class="heading1"><?php echo $addedit;?> Faq</td>
									  </tr>
										
									  <tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
											  <tbody>
												<tr>
												  <td align="left">
												  <a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a>
													&raquo;<a href="<?php echo SERVER_ADMIN_PATH;?>faq_list.php">Faq Listing</a>
													<?php
													if($edit_id != '')
													{
													?>
													&raquo; <a>Edit Faq</a>
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
													  <form name="faq_form" id="faq_form" action="" method="post" enctype="multipart/form-data"> 
														  <table class="Panel">
															<tbody>
                                                              
															  <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Question:</td>
																<td width="88%">
																<input type="text" name="question" id="question" value="<?php echo $question;?>" class="fields"> <span class="Required" /> *</span>
																</td>
															  </tr>
                                                              <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Answer:</td>
																<td width="88%">
																<textarea name="answer" id="answer" style="width:250px; height:87px;"><?php echo $answer;?></textarea> <span class="Required"> *</span>
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
																<input name="save" id="save" value="Update" class="FormButton" type="submit" onClick="validate_faq();" />
																<?php
																}
																else
																{
																?>
																<input name="add_cat" id="add_faq" value="Add" class="FormButton" type="submit" onClick="validate_faq();" />
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