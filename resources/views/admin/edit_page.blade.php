@include("admin.includes.top")
@include("admin.common.security")

<?php
use App\libraries\ckeditor\ckeditor;
error_reporting(0);
 $rowpointchk = array();
if (isset($edit_id) && !empty($edit_id)) {
  $edit_id   =  base64_decode($edit_id);
  $pointchk   =  "SELECT * from tbl_pages WHERE page_id='" . $edit_id . "'";
  $rowpointchk =  \App\Models\Songs::GetRawDataAdmin($pointchk);
 
   
}
?>
<html>

<head>
  @include("admin.common.header")
  <?php
  if (empty($rowpointchk)) {
  ?>
    <script>
      window.location.href = JS_ADMIN_SERVER_PATHROOT + "page_list";
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
                  <!-- End page header -->
                  <div class="BodyContainer">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tbody>
                        <tr>
                          <td class="heading1">Edit Pages</td>
                        </tr>
                        <tr>
                          <td class="body">
                            <form name="page_form" id="page_form" action="" method="post">
                              @csrf
                              <table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                  <tr>
                                    <td><a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a> &raquo; <a href="<?php echo SERVER_ADMIN_PATH; ?>page_list">Pages Listing</a> &raquo; <a>Edit Pages</a></td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <table class="Panel">
                                        <tbody>

                                          <tr>
                                            <td width="146" align="left" valign="top" nowrap="nowrap" class="SmallFieldLabel2">Page Title :</td>
                                            <td colspan="2" align="left" valign="top"><input name="page_name" type="text" class="Field300" id="page_name" value="<?php echo $rowpointchk['page_name']; ?>" size="10" maxlength="100">
                                              <span class="asterik">*</span>
                                            </td>
                                          </tr>


                                          <tr>
                                            <td align="left" valign="top" nowrap="nowrap" class="SmallFieldLabel2">Page Header Title :</td>
                                            <td colspan="2" align="left" valign="top"><input name="page_headertitle" type="text" class="Field300" id="page_headertitle" value="<?php echo $rowpointchk['page_headertitle']; ?>" size="10">
                                              <span class="asterik">*</span>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="left" valign="top" nowrap="nowrap" class="SmallFieldLabel2">Page Data : </td>
                                            <td width="869" align="left" valign="top">

                                              <!--<textarea class="text-input textarea wysiwyg" id="page_content" name="page_content" cols="79" rows="15"><?php echo $rowpointchk['page_content']; ?></textarea>-->
                                              <script type="text/javascript">
                                                //CKEDITOR.replace( 'page_content' );
                                              </script>
                                              <?php
                                              // require 'ckeditor/ckeditor';
                                              $page_content = stripslashes(html_entity_decode($rowpointchk['page_content']));
                                              $ckeditor = new CKEditor();
                                              $ckeditor->basePath = '';
                                              $ckeditor->config['filebrowserBrowseUrl'] = '/ckfinder/ckfinder.html';
                                              $ckeditor->config['filebrowserImageBrowseUrl'] =
                                                'ckeditor/ckfinder/ckfinder.html?type=Images';
                                              $ckeditor->config['filebrowserFlashBrowseUrl'] =
                                                'ckeditor/ckfinder/ckfinder.html?type=Flash';
                                              $ckeditor->editor('page_content', $page_content);
                                              ?>
                                            </td>
                                            <td width="165" align="left" valign="top">&nbsp;</td>
                                          </tr>


                                          <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="2"><?php
                                                            if (isset($edit_id) && !empty($edit_id)) {
                                                            ?>
                                                <input type="hidden" name="update_id" id="update_id" value="<?php echo $edit_id; ?>">
                                                <input name="update" id="update" value="Update" class="FormButton" type="submit" onClick="validate_page();">
                                              <?php
                                                            } else {
                                              ?>
                                                <input name="Add" id="Add" value="ADD" class="FormButton" type="submit" onClick="validate_page();" />
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
                      </tbody>
                    </table>
                  </div>
                  <!-- End home -->
                  <!-- Start pagefooter -->
                </td>
                <td width="10">&nbsp;</td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td height="20">
          @include("admin.common.footer")
        </td>
      </tr>
    </tbody>
  </table>
  <!-- End pagefooter -->
</body>

</html>