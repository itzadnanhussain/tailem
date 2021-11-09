<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\libraries\thumb\Thumbnail;
use Illuminate\Support\Facades\Hash;


class ManageSetting extends Controller
{

    ///Load_Setting Page
    public function Load_Setting()
    {
        $data = array();

        ///common  lines
        $data['currentFile'] = 'setting';
        $data['targetpage'] = 'setting';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.setting', $data);
    }

    ///Change_Admin_Password
    public function Change_Admin_Password()
    {
        error_reporting(0);
        if (isset($_POST)) {
            extract($_POST);

            $errorstr = "";
            $case = 1;
            // $old_password          = trim($_REQUEST['old_password']);
            // $new_password          = trim($_REQUEST['new_password']);
            // $confirm_new_password = trim($_REQUEST['confirm_new_password']);

            if (empty($old_password)) {
                $errorstr = "Please Enter Old/Current Password.\n";
                $case = 0;
            } else {
                $chk_pass_qry = 'select password_simple as chk_password from tbl_admin where 
                 password_simple  = \'' . $old_password . '\' and id="' . session()->get('reviewsite_cpadmin_id') . '" ';
                $chk_pass_arr = \App\Models\Songs::GetRawDataAdmin($chk_pass_qry);
                $chk_password    = $chk_pass_arr['chk_password'];
                if ($chk_password == "") {
                    $errorstr .= "Please Enter Valid Old/Current Password.\n";
                    $case = 0;
                } else {
                    if ($new_password == "") {
                        $errorstr .= "Please Enter New Password.\n";
                        $case = 0;
                    } elseif ($confirm_new_password == "") {
                        $errorstr .= "Please Enter Confirm New Password.\n";
                        $case = 0;
                    } elseif ($new_password != $confirm_new_password) {
                        $errorstr .= "New Password and Confirm New Password not match.\n";
                        $case = 0;
                    }
                }
            }

            if ($case == 1) {
                $password_simple = $new_password;
                $password        = md5($new_password);

                $update_qry = "UPDATE tbl_admin set password_simple = '" . $password_simple . "',password = '" . $password . "' 
                ,modified_user_id='" . session()->get('reviewsite_cpadmin_id') . "',modified_date='" . time() . "' where id='" . session()->get('reviewsite_cpadmin_id') . "'";
                \App\Models\Songs::GetRawDataAdmin($update_qry);

                if ($_SESSION['reviewsite_cpadmin_type'] == 'user') {
                    $qry = "insert into tbl_moderator_logs set moderator_id='" . session()->get('reviewsite_cpadmin_id') . "', activity ='change password',activity_table ='tbl_admin',date_added='" . time() . "' ";
                    \App\Models\Songs::GetRawData($qry);
                }
                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Change_Admin_Email
    public function Change_Admin_Email()
    {
        error_reporting(0);
        if (isset($_POST)) {
            $errorstr = "";
            $case = 1;
            $admin_email  = trim($_REQUEST['admin_email']);

            if ($admin_email == "") {
                $errorstr .= "Please enter Email.\n";
                $case = 0;
            } else {
                if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
                    $errorstr .= "Please Enter Valid Email.\n";
                    $case = 0;
                } else {
                    $chk_user_qry = "select count(id) as chk_user from tbl_admin where email=\"" . $admin_email . "\" and id!='" . session()->get('reviewsite_cpadmin_id') . "' ";
                    $chk_user_arr = \App\Models\Songs::GetRawDataAdmin($chk_user_qry);
                    $chk_user  = $chk_user_arr['chk_user'];
                    if ($chk_user > 0) {
                        $errorstr .= "This Email Already Exsist\n";
                        $case = 0;
                    }
                }
            }
            if ($case == 1) {
                $update_qry = "UPDATE tbl_admin set email = '" .  $admin_email . "',modified_user_id='" . session()->get('reviewsite_cpadmin_id') . "',modified_date='" . time() . "' where id='" . session()->get('reviewsite_cpadmin_id') . "'";
                \App\Models\Songs::GetRawData($update_qry);

                if (session()->get('reviewsite_cpadmin_type') == 'user') {
                    $qry = "insert into tbl_moderator_logs set moderator_id='" . session()->get('reviewsite_cpadmin_id') . "', activity ='change email',activity_table ='tbl_admin',date_added='" . time() . "' ";
                    \App\Models\Songs::GetRawData($qry);
                }
                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }
    ///Update_Copy_Right_text
    public function Update_Copy_Right_text()
    {
        error_reporting(0);
        if (isset($_POST)) { 
            $errorstr = "";
            $case = 1;
            $copy_right_text  = trim($_REQUEST['copy_right_text']);

            if ($copy_right_text == "") {
                $errorstr .= "Please enter Text.\n";
                $case = 0;
            } 
            if ($case == 1) {
                $update_qry = "UPDATE tbl_setting set copy_right_text = '" .  $copy_right_text . "'";
                \App\Models\Songs::GetRawData($update_qry); 
                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Change_ITune_Url
    public function Change_ITune_Url()
    {
        if (isset($_POST)) {
            $errorstr = "";
            $case = 1;
            $itune_url  = trim($_REQUEST['itune_url']); //1 for live, 2 for maintance


            if ($case == 1) {
                if (session()->get('reviewsite_cpadmin_type') == 'admin') {
                    $update_qry = "UPDATE tbl_setting set itune_url = '" . addslashes($itune_url) . "' where setting_id=1";


                    \App\Models\Songs::GetRawData($update_qry);
                }
                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Change_Site_Mode
    public function Change_Site_Mode()
    {
        error_reporting(0);
        if (isset($_POST)) {
            $errorstr = "";
            $case = 1;
            $site_mode  = trim($_REQUEST['site_mode']); //1 for live, 2 for maintance

            if ($site_mode == "") {
                $errorstr .= "Please select site mode.\n";
                $case = 0;
            } elseif ($site_mode != 1 && $site_mode != 2) {
                $errorstr .= "Please select valid site mode.\n";
                $case = 0;
            }
            if ($case == 1) {
                if (session()->get('reviewsite_cpadmin_type') == 'admin') {
                    $update_qry = "UPDATE tbl_setting set site_mode = '" .   $site_mode . "' where setting_id=1";

                    \App\Models\Songs::GetRawData($update_qry);
                }
                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Update_Analytic
    public function Update_Analytic()
    {
        error_reporting(0);
        if (isset($_POST)) {
            
            $errorstr = "";
            $case = 1;
            $analaytic  = trim($_REQUEST['analaytic']);

            if ($analaytic == "") {
                $errorstr .= "Please enter google google Analytic  code.\n";
                $case = 0;
            }

            if ($case == 1) {
                
                if (session()->get('reviewsite_cpadmin_type') == 'admin') {
                    $update_qry = "UPDATE tbl_setting set analaytic = '" . $analaytic . "' where setting_id='1'";
                    \App\Models\Songs::GetRawData($update_qry);
                }
                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }
}
