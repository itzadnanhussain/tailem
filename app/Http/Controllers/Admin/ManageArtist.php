<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\libraries\thumb\Thumbnail;


class ManageArtist extends Controller
{

    ///Load_Artist_List 
    public function Load_Artist_List()
    {
        $data = array();
        $data['sortby'] = null;
        $data['limit'] = 15;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;
        $data['artist_name'] = null;
        $data['sess_artist_name_query'] = null;
        $data['sess_artist_status_query'] = null;

        ///session variables
        $data['sess_where '] = null;

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

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }

        ///artist_name
        if (isset($_GET['artist_name'])) {
            $data['artist_name'] = $_GET['artist_name'];
        }

        ///common  lines
        $data['currentFile'] = 'artist_list';
        $data['targetpage'] = 'artist_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.artist_list', $data);
    }

    ///Load_Artist_Add
    public function Load_Artist_Add()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['edit_id'] = null;
        $data['del_id'] = null;

        ///edit_id
        if (isset($_GET['edit_id'])) {
            $data['edit_id'] = $_GET['edit_id'];
        }

        ///common  lines
        $data['currentFile'] = 'addedit_artist';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.addedit_artist', $data);
    }

    ///Artist_Process
    public function Artist_Process()
    {
        if (isset($_POST)) {
            error_reporting(0);

            $errorstr = "";
            $case = 1;

            function SEO($input)
            {

                $input = str_replace("&nbsp;", " ", $input);
                $input = str_replace(array("'"), "", $input); //remove single quote and dash
                $input = mb_convert_case($input, MB_CASE_LOWER, "UTF-8"); //convert to lowercase
                $input = preg_replace("#[^a-zA-Z0-9]+#", "-", $input); //replace everything non an with dashes
                $input = preg_replace("#(-){}#", "$1", $input); //replace multiple dashes with one
                $input = trim($input, "-"); //trim dashes from beginning and end of string if any

                $song_id = $_REQUEST['update_id'];
                if ($song_id != "") {

                    $select_url = "select artist_seo from tbl_artists where artist_seo='$input' and id !='$song_id'";
                } else {

                    $select_url = "select artist_seo from tbl_artists where artist_seo='$input'";
                }
                $result = \App\Models\Songs::GetRawData($select_url);
                if (count($result) > 0) {
                    $input = $input . "-" . uniqid();
                }


                return $input;
            }

            $artist_name    = trim($_REQUEST['artist_name']);
            $lastfm_url    =  trim($_REQUEST['lastfm_url']);
            $category       = trim($_REQUEST['category']);
            $artist_desc    = trim($_REQUEST['artist_desc']);
            $keywords        = trim($_REQUEST['keywords']);
            $artist_seo        = trim($_REQUEST['artist_seo']);
            $path            = 'site_upload/artist_images/';

            $update_id = $_REQUEST['update_id'];


            if ($artist_name == "") {
                $errorstr .= "Please Enter Artist Name\n";
                $case = 0;
            }

            if ($category == "") {
                $errorstr .= "Please select genere category\n";
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
                        $select_img = "select artist_img from tbl_artists where id='" . $update_id . "' ";
                        $result = \App\Models\Songs::GetRawDataAdmin($select_img);
                        $old_image  = $result['artist_img'];
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

                            $img_qry = "UPDATE tbl_artists SET artist_img='" . $icon_orgname . "' where id = '" . $update_id . "'";
                            \App\Models\Songs::GetRawData($img_qry);
                        }
                    }

                    $qry = "update tbl_artists set artist_name='" . stripslashes($artist_name) . "',genere_cat='" . stripslashes($category) . "',artist_seo='" .  stripslashes(SEO($artist_seo) . "',lastfm_url='" . stripslashes($lastfm_url) . "',keywords='" . stripslashes($keywords) . "',artist_description ='" . stripslashes($artist_desc) . "' where id ='" . $update_id . "' ");
                    \App\Models\Songs::GetRawData($qry);
                } else {
                    $post_data = array();
                    $post_data['artist_name'] = $artist_name;
                    $post_data['genere_cat'] = $category;
                    $post_data['artist_seo'] = SEO($artist_name);
                    $post_data['keywords'] = $keywords;
                    $post_data['lastfm_url'] = $lastfm_url;
                    $post_data['artist_description'] = $artist_desc;
                    $post_data['artist_status'] = 1;
                    $post_data['posted_date'] = time();

                    $last_record  =  addNew('artists', $post_data);



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

                            $img_qry = "UPDATE tbl_artists SET artist_img='" . $icon_orgname . "' where id='" . $last_record . "'";
                            \App\Models\Songs::GetRawData($img_qry);
                        }
                    }
                }

                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Delete_Artist
    public function Delete_Artist()
    {
        if (!empty($_POST['del_id'])) {
            $select_qry = "select id from tbl_artists where id='" . $_POST['del_id'] . "' ";
            $select_arr = \App\Models\Songs::GetRawDataAdmin($select_qry);
            $id     = $select_arr['id'];
            $path            = 'site_upload/artist_images/';
            if ($id == "") {
                echo 'Error';
            } else {

                $select_img = "select artist_img from tbl_artists where id='" . $_POST['del_id'] . "' ";
                $result = \App\Models\Songs::GetRawDataAdmin($select_img);

                $old_image  = $result['artist_img'];
                if ($old_image != "") {
                    $imgfile = $path . $old_image;
                    $thumbfile = $path . 'thumb_' . $old_image;
                    $thumbfile_small = $path . 'small_thumb_' . $old_image;
                    @unlink($imgfile);
                    @unlink($thumbfile);
                    @unlink($thumbfile_small);
                }

                $del_qry = "Delete from tbl_artists where id='" . $id . "'";
                \App\Models\Songs::GetRawData($del_qry);

                $del_qry = "Delete from tbl_songs_artist_album where artist_id='" . $id . "'";
                \App\Models\Songs::GetRawData($del_qry);


                $del_qry = "Delete from tbl_songs_artist where artist_id='" . $id . "'";
                \App\Models\Songs::GetRawData($del_qry);


                $del_qry = "Delete from tbl_artist_album where album_artist_id='" . $id . "'";
                \App\Models\Songs::GetRawData($del_qry);


                $del_qry = "Delete from tbl_likes where like_id='" . $id . "' AND like_type = 'artist'";
                \App\Models\Songs::GetRawData($del_qry);

                $del_qry = "Delete from tbl_reviews where artist_id='" . $id . "'";
                \App\Models\Songs::GetRawData($del_qry);

                $del_qry = "Delete from tbl_comments where comment_artist_id='" . $id . "'";
                \App\Models\Songs::GetRawData($del_qry);


                $del_qry = "Delete from tbl_songs_artist where artist_id='" . $id . "'";
                \App\Models\Songs::GetRawData($del_qry);



                echo 'done';
            }
        } else {
            echo 'Error';
        }
    }

    ///Artist_Actions
    public function Artist_Actions()
    {
        $path            = 'site_upload/artist_images/';
        if (!empty($_POST['ids'])) {
            error_reporting(0);

            if ($_POST['dropdown'] == 'Delete') // from button name="delete"
            {
                $checkbox = $_POST['ids']; //from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id    = base64_decode($checkbox[$i]);

                    $select_img = "select artist_img from tbl_artists where id='" . $del_id . "' ";
                    $result = \App\Models\Songs::GetRawDataAdmin($select_img);

                    $old_image  = $result['artist_img'];
                    if ($old_image != "") {
                        $imgfile = $path . $old_image;
                        $thumbfile = $path . 'thumb_' . $old_image;
                        $thumbfile_small = $path . 'small_thumb_' . $old_image;
                        @unlink($imgfile);
                        @unlink($thumbfile);
                        @unlink($thumbfile_small);
                    }

                    $sql = "DELETE from tbl_artists where id = '" . $del_id . "' ";
                    $result = \App\Models\Songs::GetRawData($sql); //or die(mysqli_error($mysqli));



                    $del_qry = "Delete from tbl_songs_artist_album where artist_id='" . $del_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);

                    $del_qry = "Delete from  tbl_songs_artist where artist_id='" . $del_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);


                    $del_qry = "Delete from  tbl_artist_album where album_artist_id='" . $del_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);


                    $del_qry = "Delete from tbl_likes where like_id='" . $del_id . "' AND like_type = 'artist'";
                    \App\Models\Songs::GetRawData($del_qry);


                    $del_qry = "Delete from tbl_reviews where artist_id='" . $del_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);


                    $del_qry = "Delete from tbl_comments where comment_artist_id='" . $del_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);


                    $del_qry = "Delete from  tbl_songs_artist where artist_id='" . $del_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);
                }

                // if ($result) {
                //     $okmsg = base64_encode("Deletion Successfully Done.");
                //     header('Location:' . SERVER_ADMIN_PATH . "artist_list?msg=$okmsg&case=1");
                // } else {
                //     echo "Error: " . mysqli_error($db->dbh);
                // }

                if (empty($result)) {
                    $okmsg = base64_encode("Deletion Successfully Done.");
                    $url = "admin/artist_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/artist_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'Active') // from button name="delete"
            {
                $checkbox = $_POST['ids']; //from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry = "select artist_status from tbl_artists where id='" . $del_id . "' ";

                    $resul = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status = $resul['artist_status'];
                    if ($status == 0) {
                        $status = 1;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_artists set artist_status=$status where id='" . $del_id . "' ";
                    $result = \App\Models\Songs::GetRawData($sql);
                }
                // if ($result) {
                //     $okmsg = base64_encode("status changed successfully.");
                //     header('Location:' . SERVER_ADMIN_PATH . "artist_list?msg=$okmsg&case=1");
                // } else {
                //     echo "Error: " . mysqli_error($db->dbh);
                // }
                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/artist_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/artist_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }

            if ($_POST['dropdown'] == 'Inactive') // from button name="delete"
            {
                $checkbox = $_POST['ids']; // from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry     = "select artist_status from tbl_artists where id='" . $del_id . "' ";

                    $resul   = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status  = $resul['artist_status'];
                    if ($status == 1) {
                        $status = 0;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_artists set artist_status=$status where id='" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawData($sql);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/artist_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/artist_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }

            if ($_POST['dropdown'] == 'popular_artist') // from button name="delete"
            {
                $checkbox = $_POST['ids']; //from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry = "select popular_artist from tbl_artists where id='" . $del_id . "' ";

                    $resul =  \App\Models\Songs::GetRawData($qry);
                    $status = $resul['popular_artist'];
                    if ($status == 0) {
                        $status = 1;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_artists set popular_artist=$status where id='" . $del_id . "' ";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }
                if (empty($result)) {
                    $okmsg = base64_encode("Papular artist status changed successfully.");
                    $url = "admin/artist_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/artist_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'not_popular_artist') // from button name="delete"
            {
                $checkbox = $_POST['ids']; // from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry     = "select popular_artist from tbl_artists where id='" . $del_id . "' ";

                    $resul   = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status  = $resul['popular_artist'];
                    if ($status == 1) {
                        $status = 0;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_artists set popular_artist=$status where id='" . $del_id . "'";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("Papular artist status changed successfully.");
                    $url = "admin/artist_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/artist_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }
        } else {
            $errormsg = base64_encode('First select a record to perform some action');
            $url = "admin/artist_list?msg=$errormsg&case=2";
            return  redirect($url);
        }
    }

    ///Artist_Featured_Songs_List
    public function Artist_Featured_Songs_List()
    {
        $data = array();
        $data['artist_id'] = null;
        $data['album_id '] = null;
        $data['msg '] = null;
        $data['case '] = null;
        $data['page '] = null;





        ///artist_id
        if (isset($_GET['artist_id'])) {
            $data['artist_id'] = $_GET['artist_id'];
        }

        ///album_id 
        if (isset($_GET['album_id '])) {
            $data['album_id '] = $_GET['album_id '];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }



        ///common  lines
        $data['currentFile'] = 'artist_featured_songs_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.artist_featured_songs_list', $data);
    }


    ///Addedit_Featured_Artist
    public function Addedit_Featured_Artist()
    {
        $data = array();
        $data['artist_id'] = null;
        $data['album_id '] = null;
        $data['song_id '] = null;
        $data['msg '] = null;
        $data['case '] = null;
        $data['page '] = null;





        ///artist_id
        if (isset($_GET['artist_id'])) {
            $data['main_artist'] = $_GET['artist_id'];
        }

        ///album_id 
        if (isset($_GET['album_id'])) {
            $data['album_id'] = $_GET['album_id'];
        }


        ///song_id 
        if (isset($_GET['song_id'])) {
            $data['song_id'] = $_GET['song_id'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }



        ///common  lines
        $data['currentFile'] = 'addedit_featured_artist';
        $data = top_file_data($data);
        $data['title'] = GetTitle();


        return view('admin.addedit_featured_artist', $data);
    }

    ///Featured_Artist_Album_Assocs
    public function Featured_Artist_Album_Assocs()
    {
        if (isset($_POST)) {
            extract($_POST);
            error_reporting(0);
            $errorstr = "";
            $case = 1;


            // $song_id = trim($_REQUEST['song_id']);
            // $main_artist = trim($_REQUEST['main_artist']);
            // $album_id = trim($_REQUEST['album_id']);
            if(isset($featured_artist) && !empty($featured_artist))
            {
                $sizeofarray   =  sizeof($_REQUEST['featured_artist']);

            }else{
                $sizeofarray = 0;
            }


            $dec_main_artist   = base64_decode($main_artist);
            $dec_album_id   = base64_decode($album_id);
            $dec_song_id    = base64_decode($song_id);
            $link    =    "artist_id=" . $main_artist . "&album_id=" . $album_id;




            if ($case == 1) {

                $arr  = $_REQUEST['featured_artist'];
                $del_qry = "delete from tbl_featured_artist_assocs where  main_artist = '$dec_main_artist' and album_id='$dec_album_id' and song_id='$dec_song_id'";

                \App\Models\Songs::GetRawData($del_qry);

                for ($m = 0; $m < $sizeofarray; $m++) {
                    $query = "insert into 
		 tbl_featured_artist_assocs
		 set 
		 main_artist='$dec_main_artist',
		 featured_artist='" . stripslashes($arr[$m]) . "',
		 album_id='$dec_album_id',
		 song_id='$dec_song_id',
		 add_date=NOW()";
                    \App\Models\Songs::GetRawData($query);
                }
                echo 'done-SEPARATOR-' . $link;
            } else {
                echo $errorstr;
            }
        }
    }

    ///Single_Artist_View 
    public function Single_Artist_View()
    {
        $data = array();
        $data['sortby'] = null;
        $data['orderby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['iTunesid'] = null;
        $data['status'] = null;
        $data['status_id'] = null;
        $data['artist_name'] = null;
        $data['fetch_details'] = null;


        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///orderby
        if (isset($_GET['orderby'])) {
            $data['orderby'] = $_GET['orderby'];
        }

        ///page
        if (isset($_GET['page'])) {
            $data['page'] = $_GET['page'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///iTunesid
        if (isset($_GET['iTunesid'])) {
            $data['iTunesid'] = $_GET['iTunesid'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }

        ///artist_name
        if (isset($_GET['artist_name'])) {
            $data['artist_name'] = $_GET['artist_name'];
        }

        ///fetch_details
        if (isset($_GET['fetch_details'])) {
            $data['fetch_details'] = $_GET['fetch_details'];
        }

        ///common  lines
        $data['currentFile'] = 'view_artist';
        $data['targetpage'] = 'view_artist';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.view_artist', $data);
    }
}
