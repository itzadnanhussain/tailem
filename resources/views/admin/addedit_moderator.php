<?php 
include("includes/top.php");
include("common/security.php");
if($edit_id!=""){
	
	$edit_id  = base64_decode($edit_id);
	$row      =  $db->get_row("select id,username,email from tbl_admin where id='".$edit_id."' and id!='1' ",ARRAY_A);
	$id 	  = $row['id'];
	$username = stripslashes(html_entity_decode($row['username']));
	$email    = stripslashes(html_entity_decode($row['email']));
	$addedit  = 'Edit';
}else{
	$id      = '';
	$addedit = 'Add';
}
if($id=="1")
{
?>
<script language="javascript" type="text/javascript"> window.location.href = '<?php echo SERVER_ADMIN_PATH.'moderator_list.php';?>'</script>
<?php
exit;
}
?>
<html>
<head>
<title><?php echo $addedit;?> Moderator</title>
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
            <tr>
                <td width="10">&nbsp;</td>
                <td>
                    <div class="BodyContainer">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                          <tbody>
                          <tr>
                            <td class="heading1"><?php echo $addedit;?> Moderator</td>
                          </tr>
                            
                          <tr>
                            <td class="body">
                                <table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                                  <tbody>
                                    <tr>
                                      <td align="left">
                                      <a href="<?php echo SERVER_ADMIN_PATH;?>/index.php">Home</a>
                                      &raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>moderator_list.php">Moderator Listing</a>
                                      &raquo; <a><?php echo $addedit;?> Moderator</a>
                                        
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
<form name="moderator_form" id="moderator_form" action="" method="post"> 	
<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
    <tr>
      <td>
          <table class="Panel">
            <tbody>
              <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">User Name : </td>
                <td width="88%"> 
                <input name="username" type="text" class="fields" id="username" value="<?php echo $username;?>" size="10" /> 	
                <span class="asterik">*</span>
                </td>
                
              </tr>
              
              <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Email : </td>
                <td width="88%">
                	<input name="email" type="text" class="fields" id="email" value="<?php echo $email;?>" size="10"  />
                    <span class="asterik">*</span>
               </td>
              </tr>
              
               <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Confirm Email : </td>
                <td width="88%">
                	<input name="confirm_email" type="text" class="fields" id="confirm_email" value="<?php echo $email;?>" size="10" />
                    <span class="asterik">*</span>
               </td>
              </tr>
              
              <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Password : 
                </td>
                <td width="88%">
                <input name="simple_password" type="password" class="fields" id="simple_password" value="" size="10" autocomplete="off"/>
                <span class="asterik">*</span>
               </td>
                
              </tr>
              
              <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">&nbsp;</td>
                <td width="88%">&nbsp;</td>
              </tr> 
              <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">&nbsp;</td>
                <td width="88%">
                <?php 
                    if(isset($edit_id) && $edit_id != '')
                    {
                    ?>
                        <input type="hidden" name="update_id" id="update_id" value="<?php echo $id;?>" />
                        <input name="update_moderator" id="update_moderator" value="Update" class="FormButton" type="submit" onClick="validate_moderator();"/>
                    <?php
                    }
                    else
                    {
                    ?>
                    	<input name="add_moderator" id="add_moderator" value="Add" class="FormButton" type="submit" onClick="validate_moderator();"/>
                    <?php
                    }
                    ?>
                </td>
              </tr>
            </tbody>
          </table>
          </td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
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
        </table>
        </td>
		</tr>
		<tr><td height="20"><?php include("common/footer.php");?></td></tr>
	</tbody>
</table>
<!-- End pagefooter -->
</body>

</html>