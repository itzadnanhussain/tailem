@include("admin.includes.top")
@include("admin.common.security")
<?php
error_reporting(0);
/*================== Search Filter Start Here=================*/
$dec_id  = base64_decode($song_id);
$dec_artist_id  = base64_decode($artist_id);
$song_list  =  "select song_title from tbl_songs where 1=1 AND id = $dec_id";

$song_list = "SELECT sa.id,a.artist_img,s.song_title,a.artist_name, sa.song_id, sa.artist_id FROM tbl_songs s, tbl_songs_artist sa, tbl_artists a where 1=1 AND a.id = sa.artist_id AND sa.song_id = s.id AND sa.song_id = '$dec_id' AND a.id = '$dec_artist_id'";


$song_list_arr  =  \App\Models\Songs::GetRawData($song_list);


if (isset($_POST['filter'])) {
  $sess_where = "";


  if ($_REQUEST['song_title'] != "") {
    $sess_where .= " and song_title  like \"%" . trim($_REQUEST['song_title']) . "%\" ";
    $_SESSION['song_title_sess'] = trim($_REQUEST['song_title']);
  } else {
    unset($_SESSION['song_title_sess']);
  }

  if ($_REQUEST['song_status'] != "") {
    $sess_where .= " and song_status = '" . $_REQUEST['song_status'] . "'";
    $_SESSION['song_status'] = $_REQUEST['song_status'];
  } else {
    unset($_SESSION['song_status']);
  }
  $_SESSION['sess_faq'] = $sess_where;
}
$session_where = $_SESSION['sess_faq'];
if (isset($_POST['Reset'])) {
  unset($_SESSION['song_title_sess']);
  $_SESSION['song_title_sess'] = "";

  unset($_SESSION['song_status']);
  $_SESSION['song_status'] = "";

  unset($_SESSION['sess_faq']);
  $_SESSION['sess_faq'] = "";

  header("Location:song_list");
}

?>
<html>

<head>
  <title>Artist against Song <?php echo stripslashes($song_list_arr['song_title']); ?> Listing</title>
  <?php
  if ($top_album_module_add == 'No') {
    $target  = SERVER_ADMIN_PATH;

  ?>
    <script language="javascript" type="text/javascript">
      window.location = '<?php echo $target; ?>';
    </script>
  <?php
    exit;
  }
  ?>
  @include("admin.common.header")
  <script language="javascript" type="text/javascript">
    // check boxess submit code
    function toggleChecked(status) {
      $(".check-all").each(function() {
        $(this).attr("checked", status);
      })
    }

    function multiple_action(frm_id) // for changing multiple status or multiple delete 
    {
      var conBox = confirm("Are you sure,you want to Perform this Action?");
      if (conBox) {
        document.forms[frm_id].submit();
      } else {
        return false;
      }
    }

    function show_detail(id) {
      $("#before_details_div_" + id).toggle();
      $("#after_details_div_" + id).toggle();
    }
  </script>
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
                    <td class="heading1">Artist against Song <?php echo stripslashes($song_list_arr['song_title']); ?> Listing</td>
                  </tr>
                  <tr>
                    <td class="body">
                      <table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                          <td><a href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a> &raquo; <a href="<?php echo SERVER_ADMIN_PATH; ?>song_list">Songs Listing</a>&raquo; <a href="<?php echo SERVER_ADMIN_PATH; ?>artist_list_song?song_id=<?php echo $song_id; ?>"><?php echo stripslashes($song_list_arr['song_title']); ?></a>

                            &raquo; <a><?php echo stripslashes($song_list_arr['artist_name']); ?>
                              &raquo; <a>Album</a>
                            </a>
                          </td>
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
                                  <td colspan="6" width="105" align="right" valign="middle" id="addsymbol">
                                    <a href="<?php echo SERVER_ADMIN_PATH; ?>addedit_song_artist_album?song_id=<?php echo $song_id; ?>&artist_id=<?php echo $artist_id; ?>"><img src="images/add.png" border="0" title="Add/Edit Album"></a>
                                  </td>
                                </tr>


                                <tr>
                                  <td colspan="7">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="30" id="Heading_list">Sr #</td>
                                  <td width="200" id="Heading_list">Album</td>
                                  <td width="200" id="Heading_list" class="righttd_border">Album Title</td>

                                  <!-- <td width="106" id="Heading_list" class="righttd_border">&nbsp;&nbsp;&nbsp;<input class="check-all" type="checkbox" onClick="toggleChecked(this.checked);" /> Action</td>-->
                                </tr>

                                <form action="<?php echo SERVER_ADMIN_PATH; ?>process/artist_song_actions" method="post" id="faq_form">
                                  <input type="hidden" name="song_id" value="<?php echo $dec_id; ?>">
                                  <?php

                                  //============================================================
                                  //PAGGING CODE STARTS HERE
                                  $qry_count_mypro = "select album_art_song.* from  tbl_artist_album a, tbl_songs_artist_album album_art_song 
										where 1=1 AND album_art_song.display_status = 1 AND a.id =  album_art_song.album_id AND album_art_song.song_id = $dec_id AND album_art_song.artist_id = $dec_artist_id order by album_art_song.id desc";

                                  $res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
                                  if ($res_count_mypro) {
                                    $total_pages = count($res_count_mypro);
                                  } else {
                                    $total_pages = 0;
                                  }



                                  $targetpage = "song_list"; //your file name  (the name of this file)


                                  $limit = 15;           //how many items to show per page

                                  if ($page)
                                    $start = ($page - 1) * $limit; //first item to display on this page
                                  else
                                    $start = 0;          //if no page var is given, set start to 0
                                  //PAGGING CODE ENDS HERE	
                                  //============================================================

                                  if (isset($page) && $page != "") {
                                    $sr_no = ($page * $limit) - $limit;
                                  } else {
                                    $sr_no = 0;
                                  }

                                  $c = 1;

                                  $song_list = "select album_art_song.*, a.album_title, a.album_picture from  tbl_artist_album a, 
									  tbl_songs_artist_album album_art_song 
										where 1=1 AND album_art_song.display_status = 1 AND a.id =  album_art_song.album_id AND album_art_song.song_id = $dec_id AND album_art_song.artist_id = $dec_artist_id order by album_art_song.id desc 
										LIMIT $start, $limit";

                                  $song_list_arr  =  \App\Models\Songs::GetRawData($song_list);;

                                  if (isset($song_list_arr)) {

                                    foreach ($song_list_arr as $val) {
                                      $val = (array)$val;

                                      $id    = $val['id'];
                                      $song_id    = $val['song_id'];
                                      $album_title = stripslashes(html_entity_decode($val['album_title']));
                                      $artist_id   = stripslashes(html_entity_decode($val['artist_id']));
                                      $album_picture   = stripslashes(html_entity_decode($val['album_picture']));
                                      $album_id = stripslashes(html_entity_decode($val['album_id']));

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

                                        <td nowrap="nowrap" class="SmallFieldLabel" width="200">
                                          <?php
                                          if ($album_picture != "") {
                                            $img_album = album_img_api($album_picture);
                                            if ($img_album != '') { ?>
                                              <img src="<?php echo $img_album; ?>" border="0" width="50" height="50" />
                                            <?php } else { ?>
                                              <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'small_thumb_' . $album_picture; ?>" border="0" width="50" height="50" />
                                            <?php }
                                          } else {
                                            ?>
                                            <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image.png" border="0" width="50" height="50" />
                                          <?php
                                          }
                                          ?>

                                        </td>

                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="200">
                                          <?php echo $album_title; ?>
                                          &nbsp;&nbsp;
                                        </td>




                                      </tr>
                                    <?php
                                    }
                                  } else {
                                    ?>

                                    <tr>
                                      <td colspan="6" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;">No Record Found</td>
                                    </tr>
                                  <?php
                                  }
                                  ?>

                                  <tr>
                                    <td colspan="6" align="center" valign="middle"><?php @include("admin.common.paging-playlist"); ?></td>
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
        @include("admin.common.footer")
      </td>
    </tr>
    </tbody>
  </table>
  <!-- End pagefooter -->
</body>

</html>