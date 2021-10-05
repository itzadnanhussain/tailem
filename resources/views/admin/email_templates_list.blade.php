@include("admin.includes.top")
@include("admin.common.security")

<html>

<head>
  @include("admin.common.header")
  <title> Email Templates Listing</title>
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
                <td>
                  <div class="BodyContainer">

                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <?php ?>
                      <tbody>
                        <tr>
                          <td class="heading1" style="padding-left:8px;">Email Templates</td>
                        </tr>
                        <tr>
                          <td class="body">
                          @csrf 
                          <form name="setting_frm" id="setting_frm" action="" onSubmit="return chk_setting_frm();">
                              <table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="padding-left:8px;"><a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a> &raquo; <a>Email Templates Listing</a></td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <table cellpadding="0" cellspacing="0" class="Panel">
                                        <tbody>
                                          <?php if (isset($msg) && $msg != "") { ?>
                                            <tr>
                                              <td colspan="5">
                                                <table border="0" cellpadding="0" cellspacing="0" class="Message">
                                                  <tbody>
                                                    <tr>
                                                      <td width="20"><?php if ($case == 1) { ?>
                                                          <img src="images/success_icon.png" vspace="5" width="18" height="18" hspace="10">
                                                        <?php } ?>
                                                        <?php if ($case == 2) { ?>
                                                          <img src="images/warning_icon.png" vspace="5" width="18" height="18" hspace="10">
                                                        <?php } ?>
                                                        <?php if ($case == 3) { ?>
                                                          <img src="images/error_icon.png" vspace="5" width="18" height="18" hspace="10">
                                                        <?php } ?>
                                                      </td>
                                                      <td width="100%"><?php echo base64_decode($msg); ?></td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                              </td>
                                            </tr>
                                          <?php } ?>
                                          <!-- -->

                                          <tr>

                                            <td width="8%" id="Heading_list">ID</td>
                                            <td width="15%" id="Heading_list">Template Name</td>
                                            <td width="30%" id="Heading_list">Subject</td>
                                            <?php
                                            if ($top_email_template_module_edit == 'Yes') {
                                            ?>
                                              <td width="5%" id="Heading_list" class="righttd_border">Action</td>
                                            <?php
                                            }
                                            ?>
                                          </tr>
                                          <?php
                                          $sr_no = 0;
                                          $c = 1;
                                          $faqgroup  =  "Select etemp_id, etemp_name, etemp_data, etemp_subject from tbl_emailtemplets ORDER BY  etemp_id asc ";
                                          $faqgroup_arr  =   \App\Models\Songs::GetRawData($faqgroup);

                                          if (isset($faqgroup_arr)) {
                                            foreach ($faqgroup_arr as $arr_faqgroup) {
                                              $arr_faqgroup = (array)$arr_faqgroup;
                                              $etemp_id    =  $arr_faqgroup['etemp_id'];
                                              $etemp_name    =  $arr_faqgroup['etemp_name'];
                                              $etemp_data  =  $arr_faqgroup['etemp_data'];
                                              $etemp_subject  =  $arr_faqgroup['etemp_subject'];

                                              if ($c % 2 == 0) {
                                                $bgcolor = "#FEFEE4";
                                              } else {
                                                $bgcolor = "#FFFFFF";
                                              }

                                              $c++;
                                              $sr_no++;
                                          ?>
                                              <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $etemp_id; ?>')" onMouseOut="changebackcolor_blur('row<?php echo $etemp_id; ?>')" id="row<?php echo $etemp_id; ?>">
                                                <td nowrap="nowrap" class="SmallFieldLabel"><?php echo $sr_no; ?></td>
                                                <td nowrap="nowrap" class="SmallFieldLabel"><?php echo $etemp_name; ?></td>
                                                <td nowrap="nowrap" class="SmallFieldLabel"><?php echo $etemp_subject; ?>&nbsp;</td>
                                                <?php
                                                if ($top_email_template_module_edit == 'Yes') {
                                                ?>
                                                  <td nowrap="nowrap" class="SmallFieldLabel righttd_border">
                                                    &nbsp; <a href="edit_email_template?edit_id=<?php echo base64_encode($etemp_id); ?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a></td>
                                                <?php
                                                }
                                                ?>
                                              </tr>
                                          <?php
                                            }
                                          }
                                          ?>
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