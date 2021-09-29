@include("admin.includes.top")
@include("admin.common.security")

<?php
// error_reporting(0);
$dec_artist_id = base64_decode($artist_id);
// $dec_album_id = base64_decode($album_id);

$albmlist = "select artist_name from tbl_artists WHERE id = '$dec_artist_id'";

$artist_list_arr  =  \App\Models\Songs::GetRawData($albmlist);
$artist_name = $artist_list_arr[0]->artist_name;

?>

<html>

<head>
  <title>Artist <?php echo $artist_name; ?> Album Listing</title>
  @include("admin.common.header")
</head>

<body>

  <table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">

    <tr>
      <td style="background:#1F3C5C; background-repeat:repeat-x; height:60px;" height="60">
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
                    <td class="heading1">Artist:<b><?php echo $artist_name; ?></b>: Featured Songs Listing</td>
                  </tr>
                  <tr>
                    <td class="body">
                      <table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                          <td><a href="<?php echo SERVER_ADMIN_PATH; ?>index.php">Home</a>
                            &raquo; <a href="artist_list">Artist Listing</a>
                            &raquo; <a>Artist <?php echo $artist_name; ?> Album Listing</a></td>
                        </tr>

                        <tr>
                          <td>
                            <table cellpadding="0" cellspacing="0" class="Panel">
                              <tbody>
                                <?php if (isset($msg) && $msg != "") { ?>
                                  <tr>
                                    <td colspan="6">
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

                               

                                <tr>
                                  <td colspan="7">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="30" id="Heading_list">Sr #</td>
                                  <td width="100" id="Heading_list">Image</td>
                                  <td width="100" id="Heading_list">Song</td>
                                  <td width="100" id="Heading_list">Album</td>
                                  <td width="100" class="righttd_border" id="Heading_list">Main Artist</td>
                                </tr>

                                <form action="<?php echo SERVER_ADMIN_PATH; ?>process/album_actions.php" method="post" id="faq_form">
                                  <input type="hidden" name="artist_id" id="artist_id" value="<?php echo $_REQUEST['artist_id']; ?>">
                                  <?php
                                  $artist_list = "select tfa.main_artist,tfa.album_id,ts.song_title,ts.picture,tab.album_picture,tab.album_title,ta.artist_name as artists, tfa.add_date  from tbl_featured_artist_assocs tfa
inner join tbl_artists as ta on ta.id=tfa.main_artist
inner join tbl_songs ts on ts.id=tfa.song_id
inner join tbl_artist_album tab on tfa.album_id=tab.id
where tfa.featured_artist= '$dec_artist_id'";

                                  $artist_list_arr  = \App\Models\Songs::GetRawData($artist_list);

                                  if (isset($artist_list_arr)) {
                                    $c = 0;
                                    $sr_no = 0;
                                    foreach ($artist_list_arr as $val) {
                                      $val = (array)$val;
                                      $song_id    = $val['song_id'];
                                      $song_title = stripslashes(html_entity_decode($val['song_title']));
                                      $main_artist = stripslashes(html_entity_decode($val['main_artist']));
                                      $album_id = stripslashes(html_entity_decode($val['album_id']));
                                      $album_title = stripslashes(html_entity_decode($val['album_title']));
                                      $song_picture   = stripslashes(html_entity_decode($val['picture']));
                                      $album_picture = stripslashes(html_entity_decode($val['album_picture']));
                                      $artist = stripslashes(html_entity_decode($val['artists']));


                                      if ($c % 2 == 0) {
                                        $bgcolor = "#FEFEE4";
                                      } else {
                                        $bgcolor = "#FFFFFF";
                                      }

                                      $c++;
                                      $sr_no++;
                                  ?>

                                      <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $id; ?>')" onMouseOut="changebackcolor_blur('row<?php echo $id; ?>')" id="row<?php echo $id; ?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no; ?></td>

                                        <td nowrap="nowrap" class="SmallFieldLabel" width="100">
                                          <?php
                                          if ($song_picture != "") {
                                          ?>
                                            <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'small_thumb_' . $song_picture; ?>" border="0" />
                                          <?php
                                          } elseif ($album_picture) { ?>
                                            <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'small_thumb_' . $album_picture; ?>" border="0" />
                                          <?PHP } else {
                                          ?>
                                            <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image.png" border="0" width="50" height="50" />
                                          <?php
                                          }
                                          ?>



                                        </td>

                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
                                          <?php echo $song_title; ?>
                                        </td>


                                        <td nowrap="nowrap" class="SmallFieldLabel" width="70">
                                          <a href="<?php echo SERVER_ROOTPATH; ?>Admin-Cp/artist_album_songs_list.php?artist_id=<?php echo base64_encode($main_artist); ?>&album_id=<?php echo base64_encode($album_id); ?>">
                                            <?php echo $album_title; ?>
                                          </a>
                                        </td>
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70">
                                          <?php echo $artist; ?>
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
                                  <tr>
                                    <td colspan="6" align="center" valign="middle">
                                      @include("admin.common.paging-playlist")
                                    </td>
                                  </tr>
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
        @include("admin.common.footer")</td>
    </tr>
    </tbody>
  </table>
  <!-- End pagefooter -->
</body>

</html>