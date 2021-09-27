<?php 

include("includes/top.php");

include("common/security.php");

?>
<html>
<head>
<title>Edit Question</title>
<style>
 .pie{
	 behavior:url(PIE.htc);
 }
</style>

<?php
if($edit_id!="")
{
	$editid = base64_decode($edit_id);
	$row  =  $db->get_row("select question_id, question_user_id, question_details from  tbl_questions where question_id='".$editid."' ",ARRAY_A);
	
	$db_question_id   = $row['question_id'];
	$question_user_id = $row['question_user_id']; 
	$question_details = stripslashes(html_entity_decode($row['question_details']));
}
if($db_question_id!="")
{
	$addedit = 'Edit';
}
else
{

?>
	<script>
		window.location.href='<?php echo SERVER_ADMIN_PATH;?>question_list.php'; 
	</script>
<?php
}

?>
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
										<td class="heading1">Edit Question</td>
									  </tr>
									  <tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
											  <tbody>
												<tr>
												  <td align="left">
												  <a href="<?php echo SERVER_ADMIN_PATH;?>/index.php">Home</a>
												  &raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>question_list.php">Questions Listing</a> &raquo; <a>Edit Question</a>
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
																<?php } ?>										
                                                                </td>
														<td width="100%"><?php echo $errorstr; ?></td>

															</tr>
														</tbody>
													</table>
												  </td>
												</tr>
												<?php } ?>
    <tr>

      <td>

          <form name="edit_question_form" id="edit_question_form" action="" method="post" enctype="multipart/form-data"> 

              <table class="Panel">

                <tbody>
                  <tr>
                    <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Details:</td>
                    <td width="88%">
                    <textarea name="question_details" id="question_details" style="width:650px;height:93px;"><?php echo $question_details;?></textarea>	
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
						if($db_question_id!="")
						{
						?>
                        	<input type="hidden" name="update_id" id="update_id" value="<?php echo $db_question_id;?>" />
                    		<input name="edit_question" id="edit_question" value="Save" class="FormButton" type="submit" onClick="validate_edit_question();"/>
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