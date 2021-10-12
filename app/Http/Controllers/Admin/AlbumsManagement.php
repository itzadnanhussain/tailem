<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\libraries\thumb\Thumbnail;


class AlbumsManagement extends Controller
{

    ///Album_List_Page
    public function Album_List_Page()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;

        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }



        ///common  lines
        $data['currentFile'] = 'album_list';
        $data['targetpage'] = 'album_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.album_list', $data);
    }


    ///Album_Delete
    public function Album_Delete()
    {
        if (!empty($_POST['del_id'])) {
            $select_qry = "select id from tbl_artist_album where id='" . $_POST['del_id'] . "' AND album_artist_id ='" . base64_decode($_POST['artist_id']) . "'";
            $select_arr = \App\Models\Songs::GetRawDataAdmin($select_qry);
            $id     = $select_arr['id'];
            $path            = 'site_upload/album_images/';
            if ($id == "") {
                echo 'Error';
            } else {

                $select_img = "select album_picture from tbl_artist_album where id='" . $_POST['del_id'] . "' ";
                $result = \App\Models\Songs::GetRawDataAdmin($select_img);

                $old_image  = $result['album_picture'];
                if ($old_image != "") {
                    $imgfile = $path . $old_image;
                    $thumbfile = $path . 'thumb_' . $old_image;
                    $thumbfile_small = $path . 'small_thumb_' . $old_image;
                    @unlink($imgfile);
                    @unlink($thumbfile);
                    @unlink($thumbfile_small);
                }

                $del_qry = "Delete from tbl_artist_album where id='" . $id . "'";
                \App\Models\Songs::GetRawData($del_qry);

                $sql = "DELETE from tbl_songs_artist_album where album_id = '" . $id . "' ";
                $result = \App\Models\Songs::GetRawData($sql);

                echo 'done';
            }
        } else {
            echo 'Error';
        }
    }

    ///Album_Actions_2
    public function Album_Actions_2()
    {
        $path = 'site_upload/album_images/';
        if (!empty($_POST['ids'])) {
            if ($_POST['dropdown'] == 'Delete') // from button name="delete"
            {
                $checkbox = $_POST['ids']; //from name="checkbox[]"
                $countCheck = count($_POST['ids']);
                $artist_id  = base64_decode($_REQUEST['artist_id']);


                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id    = base64_decode($checkbox[$i]);

                    $select_img = "select album_picture from tbl_artist_album where id='" . $del_id . "' AND album_artist_id = '$artist_id'";
                    $result = \App\Models\Songs::GetRawDataAdmin($select_img);

                    $old_image  = $result['album_picture'];
                    if ($old_image != "") {
                        $imgfile = $path . $old_image;
                        $thumbfile = $path . 'thumb_' . $old_image;
                        $thumbfile_small = $path . 'small_thumb_' . $old_image;
                        @unlink($imgfile);
                        @unlink($thumbfile);
                        @unlink($thumbfile_small);
                    }

                    $sql = "DELETE from tbl_artist_album where id = '" . $del_id . "' ";
                    $result = \App\Models\Songs::GetRawData($sql);

                    $sql = "DELETE from tbl_songs_artist_album where album_id = '" . $del_id . "' ";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }
                if (empty($result)) {
                    $okmsg = base64_encode("Deletion Successfully Done.");
                    $url = "admin/album_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/album_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'Active') // from button name="delete"
            {
                $checkbox = $_POST['ids']; //from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry = "select album_status from tbl_artist_album where id='" . $del_id . "' ";

                    $resul = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status = $resul['album_status'];
                    if ($status == 0) {
                        $status = 1;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_artist_album set album_status=$status where id='" . $del_id . "' ";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }
                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/album_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/album_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }

            if ($_POST['dropdown'] == 'Inactive') // from button name="delete"
            {
                $checkbox = $_POST['ids']; // from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry     = "select album_status from tbl_artist_album where id='" . $del_id . "' ";

                    $resul   = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status  = $resul['album_status'];

                    if ($status == 1) {
                        $status = 0;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_artist_album set album_status=$status where id='" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawData($sql);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/album_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/album_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'popular_album') // from button name="delete"
            {
                $checkbox = $_POST['ids']; //from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry = "select popular_album from tbl_artist_album where id='" . $del_id . "' ";

                    $resul = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status = $resul['popular_album'];
                    if ($status == 0) {
                        $status = 1;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_artist_album set popular_album=$status where id='" . $del_id . "' ";
                    $result = \App\Models\Songs::GetRawData($sql);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("Popular album status changed successfully.");
                    $url = "admin/album_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/album_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'not_popular_album') // from button name="delete"
            {
                $checkbox = $_POST['ids']; // from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry     = "select popular_album from tbl_artist_album where id='" . $del_id . "' ";

                    $resul   = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status  = $resul['popular_album'];

                    if ($status == 1) {
                        $status = 0;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_artist_album set popular_album=$status where id='" . $del_id . "'";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("Popular album status changed successfully.");
                    $url = "admin/album_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/album_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'sort_ranking') // from button name="delete"
            {


                $checkbox = $_POST['ids']; // from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id    = base64_decode($checkbox[$i]);
                    $order_num = $_REQUEST['order_' . $del_id];

                    if ($order_num == "") {
                        $order_num = 0;
                    }
                    $sql = "update tbl_artist_album set ranking_order = $order_num where id='" . $del_id . "'";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }


                if (empty($result)) {
                    $okmsg = base64_encode("Ranking order changed successfully.");
                    $url = "admin/album_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/album_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }
        } else {

            $errormsg = base64_encode('First select a record to perform some action');
            $url = "admin/album_list?msg=$errormsg&case=2";
            return redirect($url);
        }
    }

    ///Change_Album_Status
    public function Change_Album_Status()
    {
        if ($_POST) {
            extract($_POST);

            $del_qry = "update tbl_artist_album set album_status='" . $status . "' where id='" . $album_id . "'";

            \App\Models\Songs::GetRawData($del_qry);



            if ($status == 0) {
                //echo '<a href="song_list?status='.base64_encode(1).'&status_id='.base64_encode($id).'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
                echo '<a href="javascript:;" onclick = "change_status(' . $album_id . ', 1)" id = "remove_album_' . $album_id . '"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>';
            }
            if ($status == 1) {
                //echo '<a href="song_list?status='.base64_encode(0).'&status_id='.base64_encode($id).'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
                echo '<a href="javascript:;" onclick = "change_status(' . $album_id . ', 0)" id = "remove_album_' . $album_id . '"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>';
            }
        }
    }

    ///Add_Edit_Artist_Album
    public function Add_Edit_Artist_Album()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;
        $data['artist_id'] = null;
        $data['edit_id'] = null;

        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }
        ///artist_id
        if (isset($_GET['artist_id'])) {
            $data['artist_id'] = $_GET['artist_id'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }

        ///edit_id
        if (isset($_GET['edit_id'])) {
            $data['edit_id'] = $_GET['edit_id'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }



        ///common  lines
        $data['currentFile'] = 'addedit_artist_album';
        $data['targetpage'] = 'addedit_artist_album';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.addedit_artist_album', $data);
    }

    ///Album_Process
    public function Album_Process()
    {
        if (isset($_POST)) {
            extract($_POST);
            error_reporting(0);
            $errorstr = "";
            $case = 1;

            $album_title    = trim($_REQUEST['album_title']);
            $artist_id    = trim($_REQUEST['artist_id']);
            $path            = 'site_upload/album_images/';
            $years           = trim($_REQUEST['years']);


            $update_id = $_REQUEST['update_id'];
            if ($album_title == "") {
                $errorstr .= "Please Enter Artist Name\n";
                $case = 0;
            }

            if ($_FILES["image_name"]['name'] != "") {
                $filename = $_FILES["image_name"]['name'];
                $TmpExt   = strtolower(substr($filename, strrpos($filename, '.') + 1));
                $ext = array('jpg', 'png', 'gif', 'JPEG', 'jpeg');
                if (!in_array($TmpExt, $ext)) {
                    $errorstr .= "Invalid Picture Format\n";
                    $case = 0;
                }
            }



            if ($case == 1) {
                if ($update_id != '') {

                    if ($_FILES["image_name"]['name'] != "") {
                        $select_img = "select album_picture from tbl_artist_album where id='" . $update_id . "' ";
                        $result = \App\Models\Songs::GetRawDataAdmin($select_img);
                        $old_image  = $result['album_picture'];
                        $imgfile = $path . $old_image;
                        $thumbfile = $path . 'thumb_' . $old_image;
                        $thumbfile_small = $path . 'small_thumb_' . $old_image;
                        @unlink($imgfile);
                        @unlink($thumbfile);
                        @unlink($thumbfile_small);

                        $icon_array = $_FILES["image_name"]['name'];
                        $img_formats = array("jpeg", "gif", "png", "jpg", "JPEG", "GIF", "PNG", "JPG");
                        $allowed_size = 2; // Allowed Photo Size in MB			
                        $file_temp = $_FILES["image_name"]['tmp_name'];
                        $h_image_size = filesize($_FILES["image_name"]['tmp_name']);
                        $h_image_size = ($h_image_size / 1024) / 1024;
                        $h_file_name_array     = $_FILES["user_image"];
                        $h_file_ext = ltrim(strtolower(strrchr($_FILES["image_name"]['name'], '.')), '.');

                        $icon_orgname = rand() . "_" . $_FILES["image_name"]['name'];
                        $h_newthumb_name = 'thumb_' . $icon_orgname;
                        $h_small_thumb_name = 'small_thumb_' . $icon_orgname;
                        $h_photo_path = $path . $icon_orgname;
                        $h_photothumb_path = $path . $h_newthumb_name;
                        $h_dir = $path;

                        if ($h_image_size < $allowed_size) {
                            copy($file_temp, $h_photo_path);
                            $a = new Thumbnail();
                            // creating thumbnail
                            $a->create($_FILES["image_name"]['tmp_name'], 241, '238', $h_dir . $h_newthumb_name);

                            $b = new Thumbnail();
                            // creating thumbnail
                            $b->create($_FILES["image_name"]['tmp_name'], 50, '50', $h_dir . $h_small_thumb_name);

                            $img_qry = "UPDATE tbl_artist_album SET album_picture='" . $icon_orgname . "' where id = '" . $update_id . "'";
                            \App\Models\Songs::GetRawData($img_qry);
                        }
                    }

                    $qry = "update tbl_artist_album set album_title='" .  stripslashes($album_title) . "',years=" .  stripslashes($years) . ",keywords='" .  stripslashes($keywords) . "',album_seo='" .  stripslashes(SEO($album_title)) . "', ranking_order = '$song_ranking' where id ='" . $update_id . "' ";
                    \App\Models\Songs::GetRawData($qry);
                    //echo 'done-SEPARATOR-'.SERVER_ADMIN_PATH."artist_album_list?artist_id=".base64_encode($artist_id);

                } else {

                    $select_max = "select MAX(id) as maxid from tbl_artist_album";
                    $result_row = \App\Models\Songs::GetRawDataAdmin($select_max);

                    $max_id  =  $result_row['maxid'];

                    $max_id  =  $max_id + 1;


                    $post_data = array();
                    $post_data['id'] = $max_id;
                    $post_data['album_title'] = $album_title;
                    $post_data['years'] = $years;
                    $post_data['keywords'] = $keywords;
                    $post_data['album_artist_id'] = $artist_id;
                    $post_data['ranking_order'] = $song_ranking;
                    $post_data['album_status'] = 1;
                    $post_data['posted_date'] = time();
                    $post_data['album_seo'] = Slug($album_title);
                    $last_record  =  addNew('artist_album', $post_data);

                    if ($_FILES["image_name"]['name'] != "") {
                        $icon_array = $_FILES["image_name"]['name'];
                        $img_formats = array("jpeg", "gif", "png", "jpg", "JPEG", "GIF", "PNG", "JPG");
                        $allowed_size = 2; // Allowed Photo Size in MB			
                        $file_temp = $_FILES["image_name"]['tmp_name'];
                        $h_image_size = filesize($_FILES["image_name"]['tmp_name']);
                        $h_image_size = ($h_image_size / 1024) / 1024;
                        $h_file_name_array     = $_FILES["user_image"];
                        $h_file_ext = ltrim(strtolower(strrchr($_FILES["image_name"]['name'], '.')), '.');

                        $icon_orgname = rand() . "_" . $_FILES["image_name"]['name'];
                        $h_newthumb_name = 'thumb_' . $icon_orgname;
                        $h_small_thumb_name = 'small_thumb_' . $icon_orgname;
                        $h_photo_path = $path . $icon_orgname;
                        $h_photothumb_path = $path . $h_newthumb_name;
                        $h_dir = $path;

                        if ($h_image_size < $allowed_size) {
                            copy($file_temp, $h_photo_path);
                            $a = new Thumbnail();
                            // creating thumbnail
                            $a->create($_FILES["image_name"]['tmp_name'], 241, '238', $h_dir . $h_newthumb_name);

                            $b = new Thumbnail();
                            // creating thumbnail
                            $b->create($_FILES["image_name"]['tmp_name'], 50, '50', $h_dir . $h_small_thumb_name);

                            $img_qry = "UPDATE tbl_artist_album SET album_picture='" . $icon_orgname . "' where id='" . $last_record . "'";
                            \App\Models\Songs::GetRawData($img_qry);
                        }
                    }
                }

                echo 'done-SEPARATOR-' . SERVER_ADMIN_PATH . "artist_album_list?artist_id=" . base64_encode($artist_id);
            } else {
                echo $errorstr;
            }
        }
    }

    ///Artist_Album_List
    public function Artist_Album_List()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;
        $data['artist_seo'] = null;
        $data['artist_id'] = null;

        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }
        ///artist_id
        if (isset($_GET['artist_id'])) {
            $data['artist_id'] = $_GET['artist_id'];
        }


        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }



        ///common  lines
        $data['currentFile'] = 'artist_album_list';
        $data['targetpage'] = 'artist_album_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();


        return view('admin.artist_album_list', $data);
    }

    ///Album_Actions
    public function Album_Actions()
    {
        $path = 'site_upload/album_images/';
        if (!empty($_POST['ids'])) {
            if ($_POST['dropdown'] == 'Delete') // from button name="delete"
            {
                $checkbox = $_POST['ids']; //from name="checkbox[]"
                $countCheck = count($_POST['ids']);
                $artist_id  = base64_decode($_REQUEST['artist_id']);


                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id    = base64_decode($checkbox[$i]);

                    $select_img = "select album_picture from tbl_artist_album where id='" . $del_id . "' AND album_artist_id = '$artist_id'";
                    $result = \App\Models\Songs::GetRawDataAdmin($select_img);

                    $old_image  = $result['album_picture'];
                    if ($old_image != "") {
                        $imgfile = $path . $old_image;
                        $thumbfile = $path . 'thumb_' . $old_image;
                        $thumbfile_small = $path . 'small_thumb_' . $old_image;
                        @unlink($imgfile);
                        @unlink($thumbfile);
                        @unlink($thumbfile_small);
                    }

                    $sql = "DELETE from tbl_artist_album where id = '" . $del_id . "' ";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }


                if (empty($result)) {
                    $okmsg = base64_encode("Deletion Successfully Done.");
                    $url = "admin/artist_album_list?artist_id=" . $_REQUEST['artist_id'] . "&msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/artist_album_list?artist_id=" . $_REQUEST['artist_id'] . "&msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'Active') // from button name="delete"
            {
                $checkbox = $_POST['ids']; //from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry = "select album_status from tbl_artist_album where id='" . $del_id . "' ";

                    $resul = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status = $resul['album_status'];
                    if ($status == 0) {
                        $status = 1;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_artist_album set album_status=$status where id='" . $del_id . "' ";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }


                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/artist_album_list?artist_id=" . $_REQUEST['artist_id'] . "&msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/artist_album_list?artist_id=" . $_REQUEST['artist_id'] . "&msg=$errormsg&case=2";
                    return redirect($url);
                }
            }

            if ($_POST['dropdown'] == 'Inactive') // from button name="delete"
            {
                $checkbox = $_POST['ids']; // from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry     = "select album_status from tbl_artist_album where id='" . $del_id . "' ";

                    $resul   = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status  = $resul['album_status'];

                    if ($status == 1) {
                        $status = 0;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_artist_album set album_status=$status where id='" . $del_id . "'";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/artist_album_list?artist_id=" . $_REQUEST['artist_id'] . "&msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/artist_album_list?artist_id=" . $_REQUEST['artist_id'] . "&msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'popular_album') // from button name="delete"
            {
                $checkbox = $_POST['ids']; //from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry = "select popular_album from tbl_artist_album where id='" . $del_id . "' ";

                    $resul = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status = $resul['popular_album'];
                    if ($status == 0) {
                        $status = 1;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_artist_album set popular_album=$status where id='" . $del_id . "' ";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }
                if (empty($result)) {
                    $okmsg = base64_encode("Popular album status changed successfully.");
                    $url = "admin/artist_album_list?artist_id=" . $_REQUEST['artist_id'] . "&msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/artist_album_list?artist_id=" . $_REQUEST['artist_id'] . "&msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'not_popular_album') // from button name="delete"
            {
                $checkbox = $_POST['ids']; // from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry     = "select popular_album from tbl_artist_album where id='" . $del_id . "' ";

                    $resul   = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status  = $resul['popular_album'];

                    if ($status == 1) {
                        $status = 0;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_artist_album set popular_album=$status where id='" . $del_id . "'";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("Popular album status changed successfully.");
                    $url = "admin/album_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/album_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'sort_ranking') // from button name="delete"
            {


                $checkbox = $_POST['ids']; // from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry     = "select popular_album from tbl_artist_album where id='" . $del_id . "' ";

                    $resul   = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status  = $resul['popular_album'];

                    if ($status == 1) {
                        $status = 0;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_artist_album set popular_album=$status where id='" . $del_id . "'";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }


                if (empty($result)) {
                    $okmsg = base64_encode("Popular album status changed successfully.");
                    $url = "admin/album_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/album_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }
        } else {

            $errormsg = base64_encode('First select a record to perform some action');
            $url = "admin/artist_album_list?artist_id=".$_REQUEST['artist_id']."&msg=$errormsg&case=2";
            return redirect($url);
        }
    }

    ///Artist_Album_Songs_List
    public function Artist_Album_Songs_List()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;
        $data['artist_seo'] = null;
        $data['artist_id'] = null;
        $data['album_id'] = null;

        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }
        ///artist_id
        if (isset($_GET['artist_id'])) {
            $data['artist_id'] = $_GET['artist_id'];
        }
        ///album_id
        if (isset($_GET['album_id'])) {
            $data['album_id'] = $_GET['album_id'];
        }


        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }



        ///common  lines
        $data['currentFile'] = 'artist_album_songs_list';
        $data['targetpage'] = 'artist_album_songs_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();


        return view('admin.artist_album_songs_list', $data);
    }
}
