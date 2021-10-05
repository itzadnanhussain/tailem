<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\libraries\thumb\Thumbnail;
use Illuminate\Support\Facades\Hash;




class ManageUsers extends Controller
{

    ///Load_Users_List
    public function Load_Users_List()
    {

        $data = array();
        $data['sortby'] = null;
        $data['user_name'] = null;
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

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }



        /*================== Search Filter Start Here=================*/
        if (isset($_POST['filter'])) {

            extract($_POST);
            $sess_where = "";
            if (isset($user_name) && !empty($user_name)) {
                $sess_where .= " and user_name like \"%" . trim($user_name) . "%\" ";
                session()->put('user_name_sess', $user_name);
            } else {
                session()->put('user_name_sess', '');
            }
            if (isset($country_id) && !empty($country_id)) {
                $sess_where .= " and country_id  = '" . trim($country_id) . "' ";
                session()->put('country_id_sess', trim($country_id));
            } else {
                session()->put('country_id_sess', null);
            }

            if (isset($user_email) && !empty($user_email)) {

                $sess_where .= " and email  = \"" . trim($user_email) . "\" ";
                session()->put('user_email_sess', trim($user_email));
            } else {
                session()->put('user_email_sess', null);
            }
            if (isset($region) && !empty($region)) {
                $sess_where .= " and region  like \"%" . trim($region) . "%\" ";
                session()->put('region_sess', trim($region));
            } else {
                session()->put('region_sess', null);
            }
            if (isset($user_status) && $user_status != '') {
                $sess_where .= " and status = '" . $user_status . "'";
                session()->put('user_status_sess', trim($user_status));
            } else {
                session()->put('user_status_sess', null);
            }

            if (isset($is_top_member) && !empty($is_top_member)) {
                $sess_where .= " and is_top_member = '" . $is_top_member . "'";
                session()->put('is_top_member_sess', trim($is_top_member));
            } else {
                session()->put('is_top_member_sess', null);
            }
            session()->put('sess_users', $sess_where);
        }


        ///Reset
        if (isset($_POST['Reset'])) {
            session()->put('user_name_sess', null);
            session()->put('user_email_sess', null);
            session()->put('country_id_sess', null);
            session()->put('user_status_sess', null);
            session()->put('is_top_member_sess', null);
            session()->put('sess_users', null);
            session()->put('region_sess', null);
        }


        ///common  lines
        $data['currentFile'] = 'users_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.users_list', $data);
    }


    ///Load_User_Add
    public function Load_User_Add()
    {

        $data = array();

        $data['user_email'] = null;
        $data['user_name'] = null;
        $data['db_country_id'] = null;
        $data['region'] = null;
        $data['about_me'] = null;
        $data['profile_image'] = null;
        $data['edit_id'] = null;
        $data['del_id'] = null;

        ///edit_id
        if (isset($_GET['edit_id'])) {
            $data['edit_id'] = $_GET['edit_id'];
        }

        ///del_id
        if (isset($_GET['del_id']) && ($_GET['del_id'] != "")) {

            $select_img = "select profile_image from tbl_users where user_id='" . base64_decode($_GET['del_id']) . "'";
            $result = \App\Models\Songs::GetRawData($select_img);


            $old_image  = $result[0]->profile_image;

            if ($old_image != "") {
                error_reporting(0);
                $path            = 'site_upload/user_images/';
                $imgfile = $path . $old_image;
                $thumbfile = $path . 'thumb_' . $old_image;
                $thumbfile_small = $path . 'small_thumb_' . $old_image;
                unlink($thumbfile_small);
                unlink($imgfile);
                unlink($thumbfile);

                $qry =  "update tbl_users set profile_image = '' where user_id='" . base64_decode($_REQUEST['del_id']) . "'";
                \App\Models\Songs::GetRawData($qry);
            }
            $url =  'admin/addedit_user?edit_id=' . $_GET['del_id'];
            return redirect($url);
        }

        ///common  lines
        $data['currentFile'] = 'addedit_user';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.addedit_user', $data);
    }

    ///Add_User_Database
    public function Add_User_Database()
    {
        if (isset($_POST)) {

            error_reporting(0);

            $errorstr = "";
            $case = 1;
            $path = 'site_upload/user_images/';
            $user_name        = trim($_REQUEST['user_name']);
            $user_email       = trim($_REQUEST['user_email']);
            $confirm_email       = trim($_REQUEST['confirm_email']);
            $simple_password  = trim($_REQUEST['simple_password']);
            $country_id          = trim($_REQUEST['country_id']);
            $region           = trim($_REQUEST['region']);
            $about_me          = trim($_REQUEST['about_me']);
            $update_id        = $_REQUEST['update_id'];
            $image_name       = $_FILES["image_name"]['name'];
            if ($user_name == "") {
                $errorstr .= "Please Enter Display Name\n";
                $case = 0;
            } else {
                if ($update_id != '') {
                    $chk_user_qry = "select count(user_id) as chk_user from tbl_users where user_name=\"" . $user_name . "\" 
			and user_id!='" . $update_id . "'";
                } else {
                    $chk_user_qry = "select count(user_id) as chk_user from tbl_users where user_name=\"" . $user_name . "\" ";
                }
                $chk_user_arr = \App\Models\Songs::GetRawData($chk_user_qry);
                $chk_user = $chk_user_arr[0]->chk_user;
                if ($chk_user > 0) {
                    $errorstr .= "This Display Name Already Exsist\n";
                    $case = 0;
                }
            }

            if ($user_email == "") {
                $errorstr .= "Please Enter Email\n";
                $case = 0;
            } else
            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                $errorstr .= "Please Enter Valid Email\n";
                $case = 0;
            } else {
                if ($update_id != '') {
                    $chk_user_qry = "select count(user_id) as chk_user from tbl_users where email=\"" . $user_email . "\" 
			and user_id!='" . $update_id . "'";
                } else {
                    $chk_user_qry = "select count(user_id) as chk_user from tbl_users where email=\"" . $user_email . "\" ";
                }
                $chk_user_arr = \App\Models\Songs::GetRawData($chk_user_qry);;
                $chk_user  = $chk_user_arr[0]->chk_user;
                if ($chk_user > 0) {
                    $errorstr .= "This Email Already Exsist\n";
                    $case = 0;
                }
            }
            if ($simple_password == "" && $update_id == '') {
                $errorstr .= "Please Enter Password\n";
                $case = 0;
            } elseif ((strlen($simple_password) < 6) && $simple_password != "") {
                $errorstr .= "Password must be a minimum of 6 characters\n";
                $case = 0;
            }

            if ($_FILES["image_name"]['name'] != "") {
                $filename = $_FILES["image_name"]['name'];
                $TmpExt   = strtolower(substr($filename, strrpos($filename, '.') + 1));
                $ext = array('jpg', 'png', 'gif', 'JPEG', 'jpeg');
                if (!in_array($TmpExt, $ext)) {
                    $errorstr .= "Invalid Profile Picture Format\n";
                    $case = 0;
                }
            }
            if ($case == 1) {
                $user_seo    =    str_replace(" ", "_", $user_name);

                if ($update_id != '') {
                    $qry = "update tbl_users set user_name ='" .  stripslashes($user_name) . "',user_seo ='" . stripslashes($user_seo) . "',email ='" .  stripslashes($user_email) . "',about_me='" .  stripslashes($about_me) . "',country_id='" . $country_id . "',region='" .  stripslashes($region) . "' where user_id='" . $update_id . "'";
                    \App\Models\Songs::GetRawData($qry);
                    $last_record = $update_id;
                    if ($simple_password != "") {
                        $simple_password = Hash::make($simple_password);
                        $qry = "update tbl_users set password ='" . $simple_password . "' where user_id='" . $update_id . "'";
                    }
                } else {
                    $post_data = array();
                    $post_data['user_name'] = $user_name;
                    $post_data['user_seo'] = $user_seo;
                    $post_data['email'] = $user_email;
                    $post_data['password'] = Hash::make($simple_password);
                    $post_data['about_me'] = $about_me;
                    $post_data['date_added'] =  time();
                    $post_data['status'] =  1;
                    $post_data['country_id'] =  $country_id;
                    $post_data['region'] =  $region;
                    $last_record = addNew('users', $post_data);
                }

                if ($_FILES["image_name"]['name'] != "") {

                    $select_img = "select profile_image from tbl_users where user_id='" . $last_record . "' ";
                    $result = \App\Models\Songs::GetRawData($select_img);

                    $old_image  = $result['profile_image'];
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

                    $h_file_name_array     = $_FILES["user_image"]['name'];
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
                        // $a = new Thumbnail($_FILES["image_name"]['tmp_name'], 241, '238', $h_dir . $h_newthumb_name);


                        // creating thumbnail
                        $a->create($file_temp, 241, '238', $h_dir . $h_newthumb_name);

                        $b = new Thumbnail();
                        // creating thumbnail
                        $b->create($file_temp, 50, '50', $h_dir . $h_small_thumb_name);

                        $img_qry = "UPDATE tbl_users SET profile_image='" . $icon_orgname . "' where user_id='" . $last_record . "' ";
                        \App\Models\Songs::GetRawData($img_qry);
                    }
                }

                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Delete_User_Database
    public function Delete_User_Database()
    {
        $path = 'site_upload/user_images/';
        if (!empty($_POST['del_id'])) {
            $select_qry = "select user_id from tbl_users where user_id='" . $_POST['del_id'] . "' ";
            $select_arr = \App\Models\Songs::GetRawDataAdmin($select_qry);
            $user_id    = $select_arr['user_id'];
            if ($user_id == "") {
                echo 'Error';
            } else {
                $select_img = "select profile_image from tbl_users where user_id='" . $user_id . "'";
                $result = \App\Models\Songs::GetRawDataAdmin($select_img);;
                if ($result) {
                    $old_image  = $result['profile_image'];
                    $imgfile    = $path . $old_image;
                    $thumbfile  =  $path . 'thumb_' . $old_image;
                    $thumbfile_small = $path . 'small_thumb_' . $old_image;
                    @unlink($imgfile);
                    @unlink($thumbfile);
                    @unlink($thumbfile_small);

                    $del_qry = "Delete from tbl_users where user_id='" . $user_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);

                    $del_qry = "Delete from tbl_likes where like_from_user_id='" . $user_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);

                    $del_qry = "Delete from tbl_reviews where review_user_id='" . $user_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);


                    $del_qry = "Delete from tbl_review_report where r_report_user_id='" . $user_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);


                    $del_qry = "Delete from tbl_comments where comment_user_id='" . $user_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);
                }
                echo 'done';
            }
        } else {
            echo 'Error';
        }
    }


    ///User_Actions
    public function User_Actions()
    {
        $path = '../../site_upload/user_images/';
        if (!empty($_POST['user_ids'])) {
            $result = array();
            if ($_POST['dropdown'] == 'Delete') // from button name="delete"
            {
                $checkbox = $_POST['user_ids'];

                $countCheck = count($_POST['user_ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id     = base64_decode($checkbox[$i]);
                    $select_img = "select profile_image from tbl_users where user_id='" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawDataAdmin($select_img);
                    $old_image  = $result['profile_image'];
                    $imgfile = $path . $old_image;
                    $thumbfile = $path . 'thumb_' . $old_image;
                    $thumbfile_small = $path . 'small_thumb_' . $old_image;
                    @unlink($imgfile);
                    @unlink($thumbfile);
                    @unlink($thumbfile_small);

                    $sql = "DELETE from tbl_users where user_id = '" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawData($sql);


                    $del_qry = "Delete from tbl_likes where like_from_user_id='" . $del_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);

                    $del_qry = "Delete from tbl_reviews where review_user_id='" . $del_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);

                    $del_qry = "Delete from tbl_review_report where r_report_user_id='" . $del_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);

                    $del_qry = "Delete from tbl_comments where comment_user_id='" . $del_id . "'";
                    \App\Models\Songs::GetRawData($del_qry);
                }

                if (empty($result)) {

                    $okmsg = base64_encode("Deletion Successfully Done.");
                    $url = "admin/users_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/users_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }

            if ($_POST['dropdown'] == 'Active') // from button name="delete"
            {
                $checkbox = $_POST['user_ids']; //from name="checkbox[]"
                $countCheck = count($_POST['user_ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry = "select status from tbl_users where user_id='" . $del_id . "'";
                    $resul = \App\Models\Songs::GetRawDataAdmin($qry);

                    // $resul = mysqli_fetch_assoc($res);
                    $status = $resul['status'];
                    if ($status == 0) {
                        $status = 1;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_users set status=$status where user_id='" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawData($sql);
                    // echo '<pre>';
                    // print_r($result);
                    // echo '</pre>';
                    // die;
                }

                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/users_list?msg=$okmsg&case=1";
                    return redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/users_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }

            if ($_POST['dropdown'] == 'Inactive') // from button name="delete"
            {
                $checkbox = $_POST['user_ids']; // from name="checkbox[]"
                $countCheck = count($_POST['user_ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry     = "select status from tbl_users where user_id='" . $del_id . "'";
                    $resul   = \App\Models\Songs::GetRawDataAdmin($qry);

                    $status  = $resul['status'];
                    if ($status == 1) {
                        $status = 0;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_users set status=$status where user_id='" . $del_id . "'";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }

                if (empty($result)) {
                    $okmsg = base64_encode('status changed successfully.');
                    $url = "admin/users_list?msg=$okmsg&case=1";
                    return redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/users_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }
        } else {
            $errormsg = base64_encode('First select a record to perform some action');
            $url = "admin/users_list?msg=$errormsg&case=2";
            return redirect($url);
        }
    }
}
