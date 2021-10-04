<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\Thumbnail;
use Illuminate\Support\Facades\Hash;


class ManageGeneralSetting extends Controller
{

    ///General_Setting_Page
    public function General_Setting_Page()
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
        $data['currentFile'] = 'general_setting';
        $data['targetpage'] = 'general_setting';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.general_setting', $data);
    }

    ///Social_Links
    public function Social_Links()
    {

        $data = array();
        $data['sortby'] = null;
        $data['msg'] = null;
        $data['case'] = null;

        ///sortby
        if (isset($_GET['sortby'])) {
            $data['sortby'] = $_GET['sortby'];
        }

        ///msg
        if (isset($_GET['msg'])) {
            $data['msg'] = $_GET['msg'];
        }


        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }


        ///common  lines
        $data['currentFile'] = 'social_links';
        $data['targetpage'] = 'social_links';
        $data = top_file_data($data);
        $data['title'] = GetTitle();
        return view('admin.social_links', $data);
    }

    ///Social_Links_Process
    public function Social_Links_Process()
    {
        if (isset($_POST)) {
            $errorstr = "";
            $case = 1;
            $facebook  = trim($_REQUEST['facebook']);
            $twitter   = trim($_REQUEST['twitter']);
            $pinterest = trim($_REQUEST['pinterest']);
            $linkedin  = trim($_REQUEST['linkedin']);
            $google    = trim($_REQUEST['google']);

            if ($facebook == "") {
                $errorstr .= "Please enter facebook url.\n";
                $case = 0;
            }

            if ($twitter == "") {
                $errorstr .= "Please enter twitter url.\n";
                $case = 0;
            }
            if ($google == "") {
                $errorstr .= "Please enter Google+ url.\n";
                $case = 0;
            }

            if ($case == 1) {
                $update_qry = "UPDATE tbl_social_links set facebook = '" .   $facebook . "',twitter = '" .   $twitter . "',pinterest = '" .   $pinterest . "',linkedin = '" .  $linkedin . "',google = '" .  $google . "' ";
                \App\Models\Songs::GetRawData($update_qry);
                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Page_List
    public function Page_List()
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
        $data['currentFile'] = 'page_list';
        $data['targetpage'] = 'page_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.page_list', $data);
    }

    ///Edit_Page
    public function Edit_Page()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
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

        ///edit_id
        if (isset($_GET['edit_id'])) {
            $data['edit_id'] = $_GET['edit_id'];
        }

        ///case
        if (isset($_GET['case'])) {
            $data['case'] = $_GET['case'];
        }


        ///common  lines
        $data['currentFile'] = 'edit_page';
        $data['targetpage'] = 'edit_page';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.edit_page', $data);
    }

    ///Edit_Page_Update
    public function Edit_Page_Update()
    {
        error_reporting(0);
        if (isset($_POST)) {
            $errorstr = "";
            $case = 1;
            $page_name        = trim($_REQUEST['page_name']);
            $page_headertitle = trim($_REQUEST['page_headertitle']);
            $page_content     = trim($_REQUEST['page_content']);
            $update_id        = $_REQUEST['update_id'];

            $chk_qry = "select page_id from tbl_pages where page_id='" . $update_id . "' ";
            $chk_arr = \App\Models\Songs::GetRawDataAdmin($chk_qry);
            $page_id = $chk_arr['page_id'];

            if ($page_id == "" || $update_id == "") {
                $errorstr .= "Invalid page is selected\n";
                $case = 0;
            }
            if ($page_name == "") {
                $errorstr .= "Please Enter Page Title\n";
                $case = 0;
            }
            if ($page_headertitle == "") {
                $errorstr .= "Please Enter Page Header Title\n";
                $case = 0;
            }
            if ($page_content == "") {
                $errorstr .= "Please Enter Page Data\n";
                $case = 0;
            }


            if ($case == 1) {
                $page_name_seo = Slug($page_name);
                if ($update_id != '') {
                    $qry = "update tbl_pages set page_name ='" .  stripcslashes($page_name) . "', page_seo_name ='" .  stripcslashes($page_name_seo) . "', page_content ='" .  stripcslashes($page_content) . "' , page_headertitle ='" .  stripcslashes($page_headertitle) . "',page_status='1' where page_id='" . $update_id . "'";
                    \App\Models\Songs::GetRawData($qry);
                    echo 'done';
                } else {
                    echo 'Some Error has Occured';
                }
            } else {
                echo $errorstr;
            }
        }
    }
}
