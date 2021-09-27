<?php
include("includes/top.php");
include("common/security.php");
if(isset($edit_id) && !empty($edit_id))
{
	$edit_id	 =	base64_decode($edit_id);
	$pointchk	 =	"SELECT * from tbl_emailtemplets WHERE etemp_id='".$edit_id."'";
	$rowpointchk =	$db->get_row($pointchk,ARRAY_A);
}
?>
<html>
<head>
<?php include("common/header.php");?>
<?php
if($rowpointchk['etemp_id']=="")
{
?>
	<script>
        window.location.href = JS_ADMIN_SERVER_PATHROOT+ "email_templates_list.php";
    </script>
<?php
}
?>
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
      <td valign="top"><table border="0" width="100%">
          <tbody>
            <tr>
              <td width="10">&nbsp;</td>
              <td>
			  	<!-- End page header -->
                <div class="BodyContainer">
                  <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                      <tr>
                        <td class="heading1">Edit Email Template</td>
                      </tr>
                      <tr>
                        <td class="body">
                        	<form name="email_templates_form" id="email_templates_form" action="" method="post">
                            <table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tbody>
                                <tr>
                                  <td><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a href="<?php echo SERVER_ADMIN_PATH;?>email_templates_list.php">Email Templates Listing</a> &raquo; <a>Edit Email Template</a></td>
                                </tr>
                                <tr>
                                  <td><table class="Panel">
                                      <tbody>
                                        
                                        <tr>
                                          <td width="146" align="left" valign="top" nowrap="nowrap" class="SmallFieldLabel2">Templates Name  :</td>
                                          <td colspan="2" align="left" valign="top"><input name="etemp_name" type="text"  class="Field300" id="etemp_name" value="<?php echo $rowpointchk['etemp_name'];?>" size="10" maxlength="100">
                                            <span class="asterik">*</span></td>
                                        </tr>
										

                                        <tr>
                                          <td align="left" valign="top" nowrap="nowrap" class="SmallFieldLabel2">Subject :</td>
                                          <td colspan="2" align="left" valign="top"><input name="etemp_subject" type="text" class="Field300" id="etemp_subject" value="<?php echo $rowpointchk['etemp_subject'];?>" size="10">
                                            <span class="asterik">*</span></td>
                                        </tr>
                                        <tr>
                                          <td align="left" valign="top" nowrap="nowrap" class="SmallFieldLabel2">Message  : </td>
                                          <td width="869" align="left" valign="top">
										<?php
										include_once 'ckeditor/ckeditor.php';  
										$etemp_data = stripslashes(html_entity_decode($rowpointchk['etemp_data']));
										$ckeditor = new CKEditor();
										$ckeditor->basePath = '';
										$ckeditor->config['filebrowserBrowseUrl'] = '/ckfinder/ckfinder.html';
										$ckeditor->config['filebrowserImageBrowseUrl'] =	
										'ckeditor/ckfinder/ckfinder.html?type=Images';
										$ckeditor->config['filebrowserFlashBrowseUrl'] = 
										'ckeditor/ckfinder/ckfinder.html?type=Flash';
										$ckeditor->editor('etemp_data',$etemp_data);
										?>
										</td>
                                          <td width="165" align="left" valign="top">&nbsp;</td>
										</tr>
                                        
											
                                        <tr>
                                          <td>&nbsp;</td>
                                          <td colspan="2"><?php
											if(isset($edit_id) && !empty($edit_id))
											{
											?>
                                            <input type="hidden" name="update_id" id="update_id" value="<?php echo $edit_id; ?>">
                                            <input name="update" id="update" value="Update" class="FormButton" type="submit" onClick="validate_email_templates();">
                                            <?php
											}
											else
											{
											?>
                                            <input name="Add" id="Add" value="ADD" class="FormButton" type="submit" onClick="validate_email_templates();" />
                                            <?php
											}
											?>                                          </td>
                                        </tr>
                                      </tbody>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                              </tbody>
                            </table>
                          </form></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- End home -->
                <!-- Start pagefooter -->              </td>
              <td width="10">&nbsp;</td>
            </tr>
          </tbody>
        </table></td>
    </tr>
    <tr>
      <td height="20"><?php include("common/footer.php");?>      </td>
    </tr>
  </tbody>
</table>
<!-- End pagefooter -->
</body>
</html>