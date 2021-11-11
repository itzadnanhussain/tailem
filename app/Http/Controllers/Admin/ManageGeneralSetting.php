<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\libraries\thumb\Thumbnail;
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

    ///General_Setting_Process
    public function General_Setting_Process()
    {
        if (isset($_POST)) {
            error_reporting(0);
            
            $errorstr = "";
            $case = 1;
            $path = 'site_upload/general_setting/';
            $facebook_right_script  = trim($_REQUEST['facebook_right_script']);
            $facebook_bottom_script = trim($_REQUEST['facebook_bottom_script']);
            $rate_review = trim($_REQUEST['rate_review']);
            $discuss = trim($_REQUEST['discuss']);
            $profile = trim($_REQUEST['profile']);
            $rhyming_larics = trim($_REQUEST['rhyming_larics']);
            $desktop_version_logo              = $_FILES["desktop_version_logo"]['name'];

            if ($_FILES["desktop_version_logo"]['name'] != "") {
                $filename = $_FILES["desktop_version_logo"]['name'];
                $TmpExt   = strtolower(substr($filename, strrpos($filename, '.') + 1));
                $ext = array('jpg', 'png', 'gif', 'JPEG', 'jpeg');
                if (!in_array($TmpExt, $ext)) {
                    $errorstr .= "Please upload Upload Logo for Desktop version\n";
                    $case = 0;
                }
            }

            if ($case == 1) {
                $update_qry = "UPDATE tbl_general_setting set facebook_right_script = '" .  $facebook_right_script . "', facebook_bottom_script = '" .  $facebook_bottom_script . "', rate_review = '" .  $rate_review . "', discuss = '" .   $discuss . "', profile = '" .   $profile . "', rhyming_larics = '" .  $rhyming_larics . "' where setting_id='1' ";
               \App\Models\Songs::GetRawData($update_qry);

                if ($_FILES["desktop_version_logo"]['name'] != "") {
                    $select_img = "select desktop_version_logo from tbl_general_setting where setting_id='1' ";
                    $result = \App\Models\Songs::GetRawDataAdmin($select_img);
                    $old_image  = $result['desktop_version_logo'];
                    $imgfile = $path . $old_image;
                    $thumbfile = $path . 'thumb_' . $old_image;
                    $thumbfile_small = $path . 'small_thumb_' . $old_image;
                    @unlink($imgfile);
                    @unlink($thumbfile);
                    @unlink($thumbfile_small);

                    $icon_array = $_FILES["desktop_version_logo"]['name'];
                    $img_formats = array("jpeg", "gif", "png", "jpg", "JPEG", "GIF", "PNG", "JPG");
                    $allowed_size = 2; // Allowed Photo Size in MB			
                    $file_temp = $_FILES["desktop_version_logo"]['tmp_name'];
                    $h_image_size = filesize($_FILES["desktop_version_logo"]['tmp_name']);
                    $h_image_size = ($h_image_size / 1024) / 1024;
                    $h_file_name_array     = $_FILES["user_image"];
                    $h_file_ext = ltrim(strtolower(strrchr($_FILES["desktop_version_logo"]['name'], '.')), '.');

                    $icon_orgname = rand() . "_" . $_FILES["desktop_version_logo"]['name'];
                    $h_newthumb_name = 'thumb_' . $icon_orgname;
                    $h_small_thumb_name = 'small_thumb_' . $icon_orgname;
                    $h_mobile_thumb_name = 'mobile_thumb_' . $icon_orgname;
                    $h_photo_path = $path . $icon_orgname;
                    $h_photothumb_path = $path . $h_newthumb_name;
                    $h_mobile_thumb_path = $path . $h_mobile_thumb_name;
                    $h_dir = $path;

                    if ($h_image_size < $allowed_size) {
                        copy($file_temp, $h_photo_path);
                        $a = new Thumbnail();
                        // creating thumbnail
                        $a->create($_FILES["desktop_version_logo"]['tmp_name'], 286, '44', $h_dir . $h_newthumb_name);

                        $b = new Thumbnail();
                        // creating thumbnail
                        $b->create($_FILES["desktop_version_logo"]['tmp_name'], 50, '50', $h_dir . $h_small_thumb_name);

                        $img_qry = "UPDATE tbl_general_setting SET desktop_version_logo='" . $icon_orgname . "' where setting_id='1'";
                       \App\Models\Songs::GetRawData($img_qry);
                    }
                }

                if ($_FILES["mobile_version_logo"]['name'] != "") {
                    $select_img = "select mobile_version_logo from tbl_general_setting where setting_id='1' ";
                    $result = \App\Models\Songs::GetRawDataAdmin($select_img);
                    $old_image  = $result['mobile_version_logo'];
                    $imgfile = $path . $old_image;
                    $thumbfile = $path . 'thumb_' . $old_image;
                    $thumbfile_small = $path . 'small_thumb_' . $old_image;
                    @unlink($imgfile);
                    @unlink($thumbfile);
                    @unlink($thumbfile_small);

                    $icon_array = $_FILES["mobile_version_logo"]['name'];
                    $img_formats = array("jpeg", "gif", "png", "jpg", "JPEG", "GIF", "PNG", "JPG");
                    $allowed_size = 2; // Allowed Photo Size in MB			
                    $file_temp = $_FILES["mobile_version_logo"]['tmp_name'];
                    $h_image_size = filesize($_FILES["mobile_version_logo"]['tmp_name']);
                    $h_image_size = ($h_image_size / 1024) / 1024;
                    $h_file_name_array     = $_FILES["user_image"];
                    $h_file_ext = ltrim(strtolower(strrchr($_FILES["mobile_version_logo"]['name'], '.')), '.');

                    $icon_orgname = rand() . "_" . $_FILES["mobile_version_logo"]['name'];
                    $h_newthumb_name = 'thumb_' . $icon_orgname;
                    $h_small_thumb_name = 'small_thumb_' . $icon_orgname;
                    $h_mobile_thumb_name = 'mobile_thumb_' . $icon_orgname;
                    $h_photo_path = $path . $icon_orgname;
                    $h_photothumb_path = $path . $h_newthumb_name;
                    $h_mobile_thumb_path = $path . $h_mobile_thumb_name;
                    $h_dir = $path;

                    if ($h_image_size < $allowed_size) {
                        copy($file_temp, $h_photo_path);
                        $a = new Thumbnail();
                        // creating thumbnail
                        $a->create($_FILES["mobile_version_logo"]['tmp_name'], 252, '39', $h_dir . $h_newthumb_name);

                        $b = new Thumbnail();
                        // creating thumbnail
                        $b->create($_FILES["mobile_version_logo"]['tmp_name'], 50, '50', $h_dir . $h_small_thumb_name);

                        $img_qry = "UPDATE tbl_general_setting SET mobile_version_logo='" . $icon_orgname . "' where setting_id='1' ";
                        \App\Models\Songs::GetRawData($img_qry);
                    }
                }

                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Social_Icons_Process
    public function Social_Icons_Process()
    {
        if (isset($_POST)) {
            error_reporting(0);
            extract($_POST);
           
            
            $errorstr = "";
            $case = 1;
            $path = 'site_upload/social_icons/'; 
            if (!file_exists($path)) {
               
                mkdir($path, 0777, true); 
                
            }
        
            $large_screen_icon              = $_FILES["large_screen_icon"]['name'];

            if ($_FILES["large_screen_icon"]['name'] != "") {
                $filename = $_FILES["large_screen_icon"]['name'];
                $TmpExt   = strtolower(substr($filename, strrpos($filename, '.') + 1));
                $ext = array('jpg', 'png', 'gif', 'JPEG', 'jpeg');
                if (!in_array($TmpExt, $ext)) {
                    $errorstr .= "Please upload Upload Icon for Desktop version\n";
                    $case = 0;
                }
            }else{
                $errorstr .= "Please upload Upload Icon First\n";
                $case = 0;
            }

            if ($case == 1) {
                $update_qry = "UPDATE tbl_social_icons set icon_name = '" .  $icon_name . "', large_screen_icon = '" .  $large_screen_icon . "' where icon_id= $icon_id ";
               \App\Models\Songs::GetRawData($update_qry);

                if ($_FILES["large_screen_icon"]['name'] != "") {
                    $select_img = "select large_screen_icon from tbl_social_icons where icon_id= $icon_id ";
                    $result = \App\Models\Songs::GetRawDataAdmin($select_img);
                   
                   
                    $old_image  = $result['large_screen_icon'];
                    $imgfile = $path . $old_image;
                    // echo $imgfile;
                    // die;
                    
                    $thumbfile = $path . 'large_' . $old_image;
                    $thumbfile_small = $path . 'small_' . $old_image;
                     
                    unlink($imgfile);
                    unlink($thumbfile);
                    unlink($thumbfile_small);

                    $icon_array = $_FILES["large_screen_icon"]['name'];
                    $img_formats = array("jpeg", "gif", "png", "jpg", "JPEG", "GIF", "PNG", "JPG");
                    $allowed_size = 2; // Allowed Photo Size in MB			
                    $file_temp = $_FILES["large_screen_icon"]['tmp_name'];
                    $h_image_size = filesize($_FILES["large_screen_icon"]['tmp_name']);
                    $h_image_size = ($h_image_size / 1024) / 1024;
                    $h_file_name_array     = $_FILES["user_image"];
                    $h_file_ext = ltrim(strtolower(strrchr($_FILES["large_screen_icon"]['name'], '.')), '.');

                    $icon_orgname = $_FILES["large_screen_icon"]['name'];
                    $h_newthumb_name = 'large_' . $icon_orgname;
                    $h_small_thumb_name = 'small_' . $icon_orgname;
                     $h_photo_path = $path . $icon_orgname;
                    $h_photothumb_path = $path . $h_newthumb_name; 
                    $h_dir = $path;

                    if ($h_image_size < $allowed_size) {
                        copy($file_temp, $h_photo_path);
                        $a = new Thumbnail();
                        // creating thumbnail
                        $a->create($_FILES["large_screen_icon"]['tmp_name'], 286, '44', $h_dir . $h_newthumb_name);

                        $b = new Thumbnail();
                        // creating thumbnail
                        $b->create($_FILES["large_screen_icon"]['tmp_name'], 50, '50', $h_dir . $h_small_thumb_name);

                        $img_qry = "UPDATE tbl_social_icons SET large_screen_icon='" . $h_photo_path . "' where icon_id=$icon_id";
                       \App\Models\Songs::GetRawData($img_qry);
                    }
                }

              

                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Social_Icon
    public function Social_Icon()
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
        $data['currentFile'] = 'social_icon';
        $data['targetpage'] = 'social_icon';
        $data = top_file_data($data);
        $data['icon_data'] = GetAllRecords('social_icons');
         
        $data['title'] = GetTitle();

        return view('admin.social_icon', $data);
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

    ///Email_Templates_List
    public function Email_Templates_List()
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
        $data['currentFile'] = 'email_templates_list';
        $data['targetpage'] = 'email_templates_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();
        return view('admin.email_templates_list', $data);
    }

    ///Edit_Email_Template
    public function Edit_Email_Template()
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
        $data['currentFile'] = 'edit_email_template';
        $data['targetpage'] = 'edit_email_template';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.edit_email_template', $data);
    }


    ///Edit_Email_Template_Update
    public function Edit_Email_Template_Update()
    {
        error_reporting(0);
        if (isset($_POST)) {
            $errorstr = "";
            $case = 1;
            $etemp_name    = trim($_REQUEST['etemp_name']);
            $etemp_subject = trim($_REQUEST['etemp_subject']);
            $etemp_data    = trim($_REQUEST['etemp_data']);
            $update_id     = $_REQUEST['update_id'];

            $chk_qry = "select etemp_id from tbl_emailtemplets where etemp_id='" . $update_id . "' ";
            $chk_arr = \App\Models\Songs::GetRawDataAdmin($chk_qry);
            $etemp_id = $chk_arr['etemp_id'];

            if ($etemp_id == "" || $update_id == "") {
                $errorstr .= "Invalid Email Template is selected\n";
                $case = 0;
            }
            if ($etemp_name == "") {
                $errorstr .= "Please Enter Templates Name\n";
                $case = 0;
            }
            if ($etemp_subject == "") {
                $errorstr .= "Please Enter Subject\n";
                $case = 0;
            }
            if ($etemp_data == "") {
                $errorstr .= "Please Enter Message\n";
                $case = 0;
            }


            if ($case == 1) {
                if ($update_id != '') {
                    $qry = "update tbl_emailtemplets set etemp_name ='" . stripcslashes($etemp_name) . "',  etemp_data ='" . stripcslashes($etemp_data) . "' , etemp_subject ='" . stripcslashes($etemp_subject) . "' where etemp_id='" . $update_id . "'";
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
