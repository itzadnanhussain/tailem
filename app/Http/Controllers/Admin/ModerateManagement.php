<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\libraries\thumb\Thumbnail;


class ModerateManagement extends Controller
{

    ///Load_Moderate_List 
    public function Load_Moderate_List()
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
        $data['currentFile'] = 'moderator_list';
        $data['targetpage'] = 'moderator_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.moderator_list', $data);
    }


    ///Delete_Moderate
    public function Delete_Moderate()
    {
        if (!empty($_POST['del_id'])) {
            $select_qry = "select id from tbl_admin where id='" . $_POST['del_id'] . "' ";
            $select_arr = \App\Models\Songs::GetRawDataAdmin($select_qry);
            $id     = $select_arr['id'];
            if ($id == "") {
                echo 'Error';
            } elseif ($id == '1') {
                echo 'This user can not be deleted';
            } else {
                $del_qry = "Delete from tbl_admin where id='" . $id . "' and id!='1' ";
                \App\Models\Songs::GetRawData($del_qry);

                $del_moderator_qry = "Delete from tbl_moderator_rights where moderator_id='" . $id . "' and id!='1' ";
                \App\Models\Songs::GetRawData($del_moderator_qry);
                echo 'done';
            }
        } else {
            echo 'Error';
        }
    }



    ///Change_Moderate_Status
    public function Change_Moderate_Status()
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

    ///Add_Edit_Artist_Moderate
    public function Add_Edit_Artist_Moderate()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;
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
        $data['currentFile'] = 'addedit_moderator';
        $data['targetpage'] = 'addedit_moderator';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.addedit_moderator', $data);
    }

    ///Moderate_Process
    public function Moderate_Process()
    {
        if (isset($_POST)) {
            error_reporting(0);
            extract($_POST);
            $errorstr = "";
            $case = 1;
            $username         = trim($_REQUEST['username']);
            $email            = trim($_REQUEST['email']);
            $confirm_email       = trim($_REQUEST['confirm_email']);
            $simple_password  = trim($_REQUEST['simple_password']);

            if ($username == "") {
                $errorstr .= "Please Enter User Name\n";
                $case = 0;
            } elseif (!ctype_alnum($username)) {
                $errorstr .= "User Name must be Number or Character\n";
                $case = 0;
            } else {
                if ($update_id != '') {
                    $chk_user_qry = "select count(id) as chk_user from tbl_admin where username=\"" . $username . "\" 
                    and id!='" . $update_id . "'";
                } else {
                    $chk_user_qry = "select count(id) as chk_user from tbl_admin where username=\"" . $username . "\" ";
                }
                $chk_user_arr = \App\Models\Songs::GetRawDataAdmin($chk_user_qry);
                $chk_user = $chk_user_arr['chk_user'];
                if ($chk_user > 0) {
                    $errorstr .= "This User Name Already Exsist\n";
                    $case = 0;
                }
            }

            if ($email == "") {
                $errorstr .= "Please Enter Email\n";
                $case = 0;
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorstr .= "Please Enter Valid Email\n";
                $case = 0;
            } else {
                if ($update_id != '') {
                    $chk_user_qry = "select count(id) as chk_user from tbl_admin where email=\"" . $email . "\" 
                    and id!='" . $update_id . "'";
                } else {
                    $chk_user_qry = "select count(id) as chk_user from tbl_admin where email=\"" . $email . "\" ";
                }
                $chk_user_arr = \App\Models\Songs::GetRawDataAdmin($chk_user_qry);
                $chk_user  = $chk_user_arr['chk_user'];
                if ($chk_user > 0) {
                    $errorstr .= "This Email Already Exsist\n";
                    $case = 0;
                } elseif ($email != "" && $confirm_email == "") {
                    $errorstr .= "Please Enter Confirm Email\n";
                    $case = 0;
                } elseif ($email != "" && $confirm_email != "") {
                    if ($email != $confirm_email) {
                        $errorstr .= "Email and Confirm Email not match\n";
                        $case = 0;
                    }
                }
            }
            if ($simple_password == "" && $update_id == '') {
                $errorstr .= "Please Enter Password\n";
                $case = 0;
            } elseif ((strlen($simple_password) < 6) && $simple_password != "") {
                $errorstr .= "Password must be a minimum of 6 characters\n";
                $case = 0;
            }
            if ($case == 1) {
                if ($update_id != '') {

                    $qry = "update tbl_admin set username ='" .  stripslashes($username) . "',email ='" .   stripslashes($email) . "' where id='" . $update_id . "'";
                    \App\Models\Songs::GetRawData($qry);

                    $last_record = $update_id;
                    if ($simple_password != "") {
                        $qry = "update tbl_admin set password_simple ='" .  $simple_password . "',password ='" . md5($simple_password) . "',modified_user_id='" . session()->get('reviewsite_cpadmin_id') . "',modified_date='" . time() . "' where id='" . $update_id . "'";
                        \App\Models\Songs::GetRawData($qry);
                    }
                } else {
                    $post_data = array();
                    $post_data['username'] = $username;
                    $post_data['email'] = $email;
                    $post_data['password_simple'] = $simple_password;
                    $post_data['password'] = md5($simple_password);
                    $post_data['admin_status'] = 1;
                    $post_data['modified_user_id'] = session()->get('reviewsite_cpadmin_id');
                    $post_data['modified_date'] =  time();

                    $last_insert_id =  addNew('admin', $post_data);
                    \App\Models\Songs::GetRawData("insert into tbl_moderator_rights set moderator_id='" . $last_insert_id . "'");
                }
                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Artist_Moderate_List
    public function Artist_Moderate_List()
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

    ///Moderate_Actions
    public function Moderate_Actions()
    {

        if (!empty($_POST['ids'])) {
            if ($_POST['dropdown'] == 'Delete') // from button name="delete"
            {
                $checkbox = $_POST['ids']; //from name="checkbox[]"
                $countCheck = count($_POST['ids']);
                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "DELETE from tbl_admin where id = '" . $del_id . "' and id!='1'";
                    $result = \App\Models\Songs::GetRawData($sql);

                    $del_moderator_qry = "Delete from tbl_moderator_rights where moderator_id='" . $del_id . "' and id!='1' ";
                    \App\Models\Songs::GetRawData($del_moderator_qry);
                }


                if (empty($result)) {
                    $okmsg = base64_encode("Deletion Successfully Done.");
                    $url = "admin/moderator_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/moderator_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'Active') // from button name="delete"
            {
                $checkbox = $_POST['ids']; //from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry = "select admin_status from tbl_admin where id='" . $del_id . "' and id!='1'";

                    $resul = \App\Models\Songs::GetRawDataAdmin($qry);
                    $admin_status = $resul['admin_status'];
                    if ($admin_status == 0) {
                        $admin_status = 1;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_admin set admin_status=$admin_status where id='" . $del_id . "'  and id!='1'";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/moderator_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/moderator_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }

            if ($_POST['dropdown'] == 'Inactive') // from button name="delete"
            {
                $checkbox = $_POST['ids']; // from name="checkbox[]"
                $countCheck = count($_POST['ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry     = "select admin_status from tbl_admin where id='" . $del_id . "' and id!='1' ";

                    $resul   = \App\Models\Songs::GetRawDataAdmin($qry);
                    $admin_status  = $resul['admin_status'];
                    if ($admin_status == 1) {
                        $admin_status = 0;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_admin set admin_status=$admin_status where id='" . $del_id . "' and id!='1'";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/moderator_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/moderator_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }
        } else {

            $errormsg = base64_encode('First select a record to perform some action');
            $url = "admin/moderator_list?msg=$errormsg&case=2";
            return redirect($url);
        }
    }

    ///Moderate_Rights
    public function Moderate_Rights()
    {

        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;
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

        ///status
        if (isset($_GET['status'])) {
            $data['status'] = $_GET['status'];
            $data['status_id'] = $_GET['status_id'];
        }



        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }
        ///edit_id
        if (isset($_GET['edit_id'])) {
            $data['edit_id'] = $_GET['edit_id'];
        }



        ///common  lines
        $data['currentFile'] = 'moderator_rights';
        $data['targetpage'] = 'moderator_rights';
        $data = top_file_data($data);
        $data['title'] = GetTitle();


        return view('admin.moderator_rights', $data);
    }


    ///Moderate_Right_Process
    public function Moderate_Right_Process()
    {
        if (isset($_POST)) {
           extract($_POST);

            error_reporting(0);
            $errorstr = "";
            $case = 1;
            $moderator_id                 = trim($_REQUEST['moderator_id']);

            $artist_module                = trim($_REQUEST['artist_module']);
            $artist_module_add           = trim($_REQUEST['artist_module_add']);
            $artist_module_delete        = trim($_REQUEST['artist_module_delete']);

            $album_module                = trim($_REQUEST['album_module']);
            $album_module_add           = trim($_REQUEST['album_module_add']);
            $album_module_delete        = trim($_REQUEST['album_module_delete']);

            $song_module                = trim($_REQUEST['song_module']);
            $song_module_add           = trim($_REQUEST['song_module_add']);
            $song_module_delete        = trim($_REQUEST['song_module_delete']);


            $slider_module                = trim($_REQUEST['slider_module']);
            $users_module                   = trim($_REQUEST['users_module']);
            $faq_module                  = trim($_REQUEST['faq_module']);

            $categories_module             = trim($_REQUEST['categories_module']);
            $advertisement_module          = trim($_REQUEST['advertisement_module']);
            $social_link_module           = trim($_REQUEST['social_link_module']);
            $content_module              = trim($_REQUEST['content_module']);

            $email_template_module      = trim($_REQUEST['email_template_module']);
            $country_module             = trim($_REQUEST['country_module']);
            $reviews_module               = trim($_REQUEST['reviews_module']);
            $slider_module_add          = trim($_REQUEST['slider_module_add']);
            $slider_module_delete         = trim($_REQUEST['slider_module_delete']);
            $users_module_add            = trim($_REQUEST['users_module_add']);
            $users_module_delete         = trim($_REQUEST['users_module_delete']);
            $faq_module_add              = trim($_REQUEST['faq_module_add']);
            $faq_module_delete           = trim($_REQUEST['faq_module_delete']);
            $categories_module_add        = trim($_REQUEST['categories_module_add']);
            $categories_module_delete    = trim($_REQUEST['categories_module_delete']);
            $email_template_module_edit    = trim($_REQUEST['email_template_module_edit']);
            $country_module_add            = trim($_REQUEST['country_module_add']);
            $country_module_delete        = trim($_REQUEST['country_module_delete']);
            $reviews_module_add            = trim($_REQUEST['reviews_module_add']);
            $reviews_module_delete         = trim($_REQUEST['reviews_module_delete']);
            $advertisement_module_add   = trim($_REQUEST['advertisement_module_add']);
            $advertisement_module_delete = trim($_REQUEST['advertisement_module_delete']);

            $video_module               = trim($_REQUEST['video_module']);
            $video_module_add           = trim($_REQUEST['video_module_add']);
            $video_module_delete        = trim($_REQUEST['video_module_delete']);

            if ($moderator_id == "" || $moderator_id == '1') {
                $errorstr .= "Invalid Moderator is selected\n";
                $case = 0;
            } else {
                $chk_modrator_qry = "select count(id) as chk_moderator from tbl_admin where id=\"" . $moderator_id . "\" and id!='1'";
                $chk_moderator_arr = \App\Models\Songs::GetRawDataAdmin($chk_modrator_qry);
                $chk_moderator     = $chk_moderator_arr['chk_moderator'];
                if ($chk_moderator == 0  || $chk_moderator == "") {
                    $errorstr .= "There is some error ocuur.please relaod page \n";
                    $case = 0;
                } else {

                    if ($users_module == "") {
                        $errorstr .= "Please select user option\n";
                        $case = 0;
                    } elseif ($users_module != "No" && $users_module != "Yes") {
                        $errorstr .= "The user option you seleted is invalid\n";
                        $case = 0;
                    }



                    if ($categories_module == "") {
                        $errorstr .= "Please select categories option\n";
                        $case = 0;
                    } elseif ($categories_module != "No" && $categories_module != "Yes") {
                        $errorstr .= "The categories option you seleted is invalid\n";
                        $case = 0;
                    }


                    if ($advertisement_module == "") {
                        $errorstr .= "Please select advertisement option\n";
                        $case = 0;
                    } elseif ($advertisement_module != "No" && $advertisement_module != "Yes") {
                        $errorstr .= "The advertisement option you seleted is invalid\n";
                        $case = 0;
                    }


                    if ($country_module == "") {
                        $errorstr .= "Please select country option\n";
                        $case = 0;
                    } elseif ($country_module != "No" && $country_module != "Yes") {
                        $errorstr .= "The country option you seleted is invalid\n";
                        $case = 0;
                    }


                    if ($reviews_module == "") {
                        $errorstr .= "Please select reviews option\n";
                        $case = 0;
                    } elseif ($reviews_module != "No" && $reviews_module != "Yes") {
                        $errorstr .= "The reviews option you seleted is invalid\n";
                        $case = 0;
                    }


                    if ($social_link_module == "") {
                        $errorstr .= "Please select social link option\n";
                        $case = 0;
                    } elseif ($social_link_module != "No" && $social_link_module != "Yes") {
                        $errorstr .= "The social link option you seleted is invalid\n";
                        $case = 0;
                    }

                    if ($content_module == "") {
                        $errorstr .= "Please select content option\n";
                        $case = 0;
                    } elseif ($content_module != "No" && $content_module != "Yes") {
                        $errorstr .= "The content option you seleted is invalid\n";
                        $case = 0;
                    }

                    if ($email_template_module == "") {
                        $errorstr .= "Please select email template option\n";
                        $case = 0;
                    } elseif ($email_template_module != "No" && $email_template_module != "Yes") {
                        $errorstr .= "The email template option you seleted is invalid\n";
                        $case = 0;
                    }

                    if ($slider_module != "" && $slider_module_add != '') {
                        if ($slider_module_add != 'Yes') {
                            $errorstr .= "Please select valid slider Add option\n";
                            $case = 0;
                        }
                    }


                    if ($slider_module != "" && $slider_module_delete != '') {
                        if ($slider_module_delete != 'Yes') {
                            $errorstr .= "Please select valid slider Delete option\n";
                            $case = 0;
                        }
                    }

                    if ($users_module != "" && $users_module_add != '') {
                        if ($users_module_add != 'Yes') {
                            $errorstr .= "Please select valid user Add option\n";
                            $case = 0;
                        }
                    }


                    if ($users_module != "" && $users_module_delete != '') {
                        if ($users_module_delete != 'Yes') {
                            $errorstr .= "Please select valid user Delete option\n";
                            $case = 0;
                        }
                    }





                    if ($categories_module != "" && $categories_module_add != '') {
                        if ($categories_module_add != 'Yes') {
                            $errorstr .= "Please select valid categories Add option\n";
                            $case = 0;
                        }
                    }


                    if ($categories_module != "" && $categories_module_delete != '') {
                        if ($categories_module_delete != 'Yes') {
                            $errorstr .= "Please select valid categories Delete option\n";
                            $case = 0;
                        }
                    }

                    if ($advertisement_module != "" && $advertisement_module_add != '') {
                        if ($advertisement_module_add != 'Yes') {
                            $errorstr .= "Please select valid advertisement Add option\n";
                            $case = 0;
                        }
                    }


                    if ($advertisement_module != "" && $advertisement_module_delete != '') {
                        if ($advertisement_module_delete != 'Yes') {
                            $errorstr .= "Please select valid advertisement Delete option\n";
                            $case = 0;
                        }
                    }

                    if ($country_module != "" && $country_module_add != '') {
                        if ($country_module_add != 'Yes') {
                            $errorstr .= "Please select valid country Add option\n";
                            $case = 0;
                        }
                    }


                    if ($country_module != "" && $country_module_delete != '') {
                        if ($country_module_delete != 'Yes') {
                            $errorstr .= "Please select valid country Delete option\n";
                            $case = 0;
                        }
                    }

                    if ($reviews_module != "" && $reviews_module_add != '') {
                        if ($reviews_module_add != 'Yes') {
                            $errorstr .= "Please select valid reviews Add option\n";
                            $case = 0;
                        }
                    }


                    if ($reviews_module != "" && $reviews_module_delete != '') {
                        if ($reviews_module_delete != 'Yes') {
                            $errorstr .= "Please select valid reviews Delete option\n";
                            $case = 0;
                        }
                    }


                    if ($content_module != "" && $content_module_edit != '') {
                        if ($content_module_edit != 'Yes') {
                            $errorstr .= "Please select valid content Edit option\n";
                            $case = 0;
                        }
                    }

                    if ($email_template_module_edit != "" && $email_template_module_edit != '') {
                        if ($email_template_module_edit != 'Yes') {
                            $errorstr .= "Please select valid email template Edit option\n";
                            $case = 0;
                        }
                    }

                    if ($video_module != "" && $video_module_add != '') {
                        if ($video_module_add != 'Yes') {
                            $errorstr .= "Please select valid Video Add option\n";
                            $case = 0;
                        }
                    }


                    if ($video_module != "" && $video_module_delete != '') {
                        if ($video_module_delete != 'Yes') {
                            $errorstr .= "Please select valid Video Delete option\n";
                            $case = 0;
                        }
                    }
                }
            }

            if ($case == 1) {
                if ($slider_module_add == '' || $slider_module != 'Yes') {
                    $slider_module_add = 'No';
                }
                if ($slider_module_delete == '' || $slider_module != 'Yes') {
                    $slider_module_delete = 'No';
                }

                if ($artist_module_add == '' || $artist_module != 'Yes') {
                    $artist_module_add = 'No';
                }
                if ($artist_module_delete == '' || $artist_module != 'Yes') {
                    $artist_module_delete = 'No';
                }

                if ($album_module_add == '' || $album_module != 'Yes') {
                    $album_module_add = 'No';
                }
                if ($album_module_delete == '' || $album_module != 'Yes') {
                    $album_module_delete = 'No';
                }

                if ($song_module_add == '' || $song_module != 'Yes') {
                    $song_module_add = 'No';
                }
                if ($song_module_delete == '' || $song_module != 'Yes') {
                    $song_module_delete = 'No';
                }

                if ($users_module_add == '' || $users_module != 'Yes') {
                    $users_module_add = 'No';
                }
                if ($users_module_delete == ''  || $users_module != 'Yes') {
                    $users_module_delete = 'No';
                }

                if ($faq_module_add == ''  || $faq_module != 'Yes') {
                    $faq_module_add = 'No';
                }
                if ($faq_module_delete == ''  || $faq_module != 'Yes') {
                    $faq_module_delete = 'No';
                }

                if ($categories_module_add == ''  || $categories_module != 'Yes') {
                    $categories_module_add = 'No';
                }
                if ($categories_module_delete == '' || $categories_module != 'Yes') {
                    $categories_module_delete = 'No';
                }

                if ($advertisement_module_add == ''  || $advertisement_module != 'Yes') {
                    $advertisement_module_add = 'No';
                }
                if ($advertisement_module_delete == '' || $advertisement_module != 'Yes') {
                    $advertisement_module_delete = 'No';
                }

                if ($country_module_add == '' || $country_module != 'Yes') {
                    $country_module_add = 'No';
                }
                if ($country_module_delete == '' || $country_module != 'Yes') {
                    $country_module_delete = 'No';
                }

                if ($reviews_module_add == '' || $reviews_module != 'Yes') {
                    $reviews_module_add = 'No';
                }
                if ($reviews_module_delete == '' || $reviews_module != 'Yes') {
                    $reviews_module_delete = 'No';
                }


                if ($content_module_edit == '' || $content_module != 'Yes') {
                    $content_module_edit = 'No';
                }

                if ($email_template_module_edit == ''  || $email_template_module != 'Yes') {
                    $email_template_module_edit = 'No';
                }

                if ($video_module_add == '' || $video_module != 'Yes') {
                    $video_module_add = 'No';
                }
                if ($video_module_delete == '' || $video_module != 'Yes') {
                    $video_module_delete = 'No';
                }
                $check_mod = GetByWhere('moderator_rights', array('moderator_id' => $moderator_id));
                if ($check_mod) {
                    $query = "update tbl_moderator_rights set slider_module='" . $slider_module . "',artist_module='" . $artist_module . "',album_module='" . $album_module . "',song_module='" . $song_module . "', users_module='" . $users_module . "', categories_module='" . $categories_module . "', advertisement_module='" . $advertisement_module . "', social_link_module='" . $social_link_module . "', content_module='" . $content_module . "', email_template_module='" . $email_template_module . "', country_module='" . $country_module . "', reviews_module='" . $reviews_module . "', slider_module_add='" . $slider_module_add . "', slider_module_delete='" . $slider_module_delete . "', artist_module_add='" . $artist_module_add . "', artist_module_delete='" . $artist_module_delete . "', album_module_add='" . $album_module_add . "', album_module_delete='" . $album_module_delete . "', song_module_add='" . $song_module_add . "', song_module_delete='" . $song_module_delete . "', users_module_add='" . $users_module_add . "', users_module_delete='" . $users_module_delete . "', categories_module_add='" . $categories_module_add . "',  categories_module_delete='" . $categories_module_delete . "',content_module_edit='" . $content_module_edit . "', email_template_module_edit='" . $email_template_module_edit . "', country_module_add='" . $country_module_add . "',  country_module_delete='" . $country_module_delete . "', reviews_module_add='" . $reviews_module_add . "', reviews_module_delete='" . $reviews_module_delete . "',advertisement_module_add='" . $advertisement_module_add . "',  advertisement_module_delete='" . $advertisement_module_delete . "',video_module='" . $video_module . "',video_module_add='" . $video_module_add . "',  video_module_delete='" . $video_module_delete . "' where moderator_id='" . $moderator_id . "'";
                    \App\Models\Songs::GetRawData($query);

                } else {
                    $query = "insert into tbl_moderator_rights set moderator_id='" . $moderator_id . "',slider_module='" . $slider_module . "',artist_module='" . $artist_module . "',album_module='" . $album_module . "',song_module='" . $song_module . "', users_module='" . $users_module . "', categories_module='" . $categories_module . "', advertisement_module='" . $advertisement_module . "', social_link_module='" . $social_link_module . "', content_module='" . $content_module . "', email_template_module='" . $email_template_module . "', country_module='" . $country_module . "', reviews_module='" . $reviews_module . "', slider_module_add='" . $slider_module_add . "', slider_module_delete='" . $slider_module_delete . "', artist_module_add='" . $artist_module_add . "', artist_module_delete='" . $artist_module_delete . "', album_module_add='" . $album_module_add . "', album_module_delete='" . $album_module_delete . "', song_module_add='" . $song_module_add . "', song_module_delete='" . $song_module_delete . "', users_module_add='" . $users_module_add . "', users_module_delete='" . $users_module_delete . "', categories_module_add='" . $categories_module_add . "',  categories_module_delete='" . $categories_module_delete . "',content_module_edit='" . $content_module_edit . "', email_template_module_edit='" . $email_template_module_edit . "', country_module_add='" . $country_module_add . "',  country_module_delete='" . $country_module_delete . "', reviews_module_add='" . $reviews_module_add . "', reviews_module_delete='" . $reviews_module_delete . "',advertisement_module_add='" . $advertisement_module_add . "',  advertisement_module_delete='" . $advertisement_module_delete . "',video_module='" . $video_module . "',video_module_add='" . $video_module_add . "',  video_module_delete='" . $video_module_delete . "'";

                    \App\Models\Songs::GetRawData($query);
                }
                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }
}
