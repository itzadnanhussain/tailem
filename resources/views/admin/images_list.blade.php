@include("admin.includes.top")
@include("admin.common.security")

<html>

<head>
  <title>Image Listing</title>
  @include("admin.common.header")

</head>

<body>

  <table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">

    <tr>
      <td style="background: #1F3C5C repeat-x;height:60px;" height="60">
        @include("admin.common.top_right_menu")
      </td>
    </tr>
    <tr>
      <td valign="top">
        <table border="0" width="100%">
          <tr>
            <td width="10">&nbsp;</td>
            <td>
              <!-- End page header -->
              <!-- End pageheader -->
              <!-- Start home -->
              <div class="BodyContainer">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td class="heading1">Image Listing</td>
                  </tr>
                  <tr>
                    <td class="body">
                      <table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                          <td><a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a> &raquo; <a>Image Listing</a></td>
                        </tr>

                        <tr>
                          <td colspan="7" width="105" align="right" valign="middle" id="addsymbol">

                            <!-- <a href="<?php echo SERVER_ADMIN_PATH; ?>store_images"><img src="images/add.png" border="0" title="Add New"></a>-->

                          </td>
                        </tr>
                        <tr>
                          <td>
                            <table cellpadding="0" cellspacing="0" class="Panel">
                              <tbody>
                                <tr>
                                  <td colspan="7">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="30" id="Heading_list">Sr #</td>
                                  <td width="50" id="Heading_list">Title</td>
                                  <td width="200" id="Heading_list" class="righttd_border">Image</td>
                                  <td width="30" id="Heading_list" class="righttd_border">Action</td>
                                </tr>

                                <form>
                                  @csrf
                                  <?php
                                  $c = 1;

                                  $img_list = "select * from tbl_store_img where 1=1";

                                  $img_list_arr  =  \App\Models\Songs::GetRawData($img_list);;

                                  if (isset($img_list_arr)) {
                                    foreach ($img_list_arr as $val) {
                                      $val = (array)$val;
                                      $store_id    = $val['store_id'];
                                      $store_title = stripslashes(html_entity_decode($val['store_title']));
                                      $store_img   = stripslashes(html_entity_decode($val['store_img']));

                                      if ($c % 2 == 0) {
                                        $bgcolor = "#FEFEE4";
                                      } else {
                                        $bgcolor = "#FFFFFF";
                                      }

                                      $c++;
                                      $sr_no++;


                                  ?>

                                      <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $store_id; ?>')" onMouseOut="changebackcolor_blur('row<?php echo $store_id; ?>')" id="row<?php echo $store_id; ?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no; ?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200"><?php echo $store_title; ?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="300">
                                          <?php
                                          if ($store_img != "") { ?>

                                            <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $store_img; ?>" border="0" width="50" height="50" />
                                          <?php } else {
                                          ?>
                                            <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image.png" border="0" width="50" height="50" />
                                          <?php
                                          }
                                          ?>
                                        </td>
                                        <td class="SmallFieldLabel righttd_border" width="30">
                                          <a href="store_images?edit_id=<?php echo base64_encode($store_id); ?>"><img src="images/edit.gif" border="0" title="Edit"></a>
                                        </td>

                                      </tr>
                                    <?php
                                    }
                                  } else {
                                    ?>

                                    <tr>
                                      <td colspan="6" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
                                    </tr>
                                  <?php
                                  }
                                  ?>
                                </form>
                            </table>

                          </td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
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