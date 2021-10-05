<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\libraries\thumb\Thumbnail;


class ManageCategories extends Controller
{

    ///Load_Category_List
    public function Load_Category_List()
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
        $data['currentFile'] = 'main_cat_list';
        $data['targetpage'] = 'main_cat_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.main_cat_list', $data);
    }

    ///Category_Actions
    public function Category_Actions()
    {
        $path = 'site_upload/category_images/';
        $icon_folder = 'site_upload/categories_icons/';
        if (!empty($_POST['cat_ids'])) {
            if ($_POST['dropdown'] == 'Delete') // from button name="delete"
            {
                $checkbox = $_POST['cat_ids']; //from name="checkbox[]"
                $countCheck = count($_POST['cat_ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id     = base64_decode($checkbox[$i]);
                    $select_img = "select image_name,icon_name from tbl_categories where cat_id='" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawDataAdmin($select_img);

                    //delete image
                    $old_image  = $result['image_name'];
                    $imgfile = $path . $old_image;
                    $thumbfile = $path . 'thumb_' . $old_image;
                    $thumbfile_small = $path . 'small_thumb_' . $old_image;
                    @unlink($imgfile);
                    @unlink($thumbfile);
                    @unlink($thumbfile_small);

                    //delete Icon
                    $old_icon     = $result['icon_name'];
                    $icon_file    = $icon_folder . $old_icon;
                    $thumb_icon   =  $icon_folder . 'thumb_' . $old_icon;
                    $small_thumb_icon = $icon_folder . 'small_thumb_' . $old_icon;
                    @unlink($icon_file);
                    @unlink($thumb_icon);
                    @unlink($small_thumb_icon);

                    $sql = "DELETE from tbl_categories where parent_id = '" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawData($sql);

                    $select_images = "select image_name from tbl_categories where parent_id='" . $del_id . "'";
                    $result_images = \App\Models\Songs::GetRawData($select_images);
                    if ($result_images) {
                        foreach ($result_images as $values) {
                            $values = (array)$values;
                            $old_image  = $values['image_name'];
                            $imgfile = $path . $old_image;
                            $thumbfile = $path . 'thumb_' . $old_image;
                            $thumbfile_small = $path . 'small_thumb_' . $old_image;
                            @unlink($imgfile);
                            @unlink($thumbfile);
                            @unlink($thumbfile_small);
                        }
                    }
                    $sql = "DELETE from tbl_categories where cat_id = '" . $del_id . "' OR parent_id = '" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawData($sql);
                }

                $sql = "DELETE from tbl_categories where cat_id = '" . $del_id . "' OR parent_id = '" . $del_id . "'";
                $result = \App\Models\Songs::GetRawData($sql);

                if (empty($result)) {
                    $okmsg = base64_encode("Deletion Successfully Done.");
                    $url = "admin/main_cat_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/main_cat_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'Active') // from button name="delete"
            {
                $checkbox = $_POST['cat_ids']; //from name="checkbox[]"
                $countCheck = count($_POST['cat_ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry = "select status from tbl_categories where cat_id='" . $del_id . "' ";
                    $resul = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status = $resul['status'];
                    if ($status == 0) {
                        $status = 1;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_categories set status=$status where cat_id='" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawData($sql);
                }
                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/main_cat_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/main_cat_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }

            if ($_POST['dropdown'] == 'Inactive') // from button name="delete"
            {
                $checkbox = $_POST['cat_ids']; // from name="checkbox[]"
                $countCheck = count($_POST['cat_ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    //$qry     = "select status from tbl_categories where cat_id='".$del_id."' OR parent_id = '".$del_id."'"; 
                    $qry     = "select status from tbl_categories where cat_id='" . $del_id . "' ";

                    $resul = \App\Models\Songs::GetRawDataAdmin($qry);

                    $status  = $resul['status'];
                    if ($status == 1) {
                        $status = 0;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    //$sql = "update tbl_categories set status=$status where cat_id='".$del_id."' OR parent_id = '".$del_id."'"; 
                    $sql = "update tbl_categories set status=$status where cat_id='" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawData($sql);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/main_cat_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/main_cat_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }
        } else {
            $errormsg = base64_encode('First select a record to perform some action');
            $url = "admin/main_cat_list?msg=$errormsg&case=2";
            return redirect($url);
        }
    }

    ///Add_Category
    public function Add_Category()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['edit_id'] = null;
        $data['cat_name'] = null;
        $data['cat_id'] = null;


        ///edit_id
        if (isset($_GET['edit_id'])) {
            $data['edit_id'] = $_GET['edit_id'];
        }

        ///common  lines
        $data['currentFile'] = 'addedit_main_cat';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.addedit_main_cat', $data);
    }

    ///Category_Process
    public function Category_Process()
    {
        error_reporting(0);
        if (isset($_POST)) {

            $errorstr = "";
            $case = 1;
            $cat_name        = trim($_REQUEST['cat_name']);

            $update_id = trim($_REQUEST['update_id']);
            if ($cat_name == "") {
                $errorstr .= "Please Enter Category Name\n";
                $case = 0;
            } else {
                if ($update_id == "") {
                    $chk_name_qry = 'select cat_name as chk_name from tbl_categories where cat_name  = \'' . $cat_name . '\'';
                } else {
                    $chk_name_qry = 'select cat_name as chk_name from tbl_categories where cat_name  = \'' . $cat_name . '\' and cat_id!="' . $update_id . '" ';
                }
                $chk_name_arr = \App\Models\Songs::GetRawDataAdmin($chk_name_qry);
                $chk_name     = $chk_name_arr['chk_name'];
                if ($chk_name != "") {
                    $errorstr .= "This Category Name already Exsist\n";
                    $case = 0;
                }
            }

            if ($case == 1) {
              

                $cat_seo_name = Slug($cat_name);

                if ($update_id == "") {


                    $post_data = array();
                    $post_data['cat_name'] = $cat_name;
                    $post_data['cat_seo_name'] = $cat_seo_name;
                    $last_record = addNew('categories', $post_data);
                } else {
                    $update_qry = "UPDATE tbl_categories SET cat_name='" .  stripslashes($cat_name) . "',cat_seo_name='" . stripslashes($cat_seo_name) . "' where cat_id='" . $update_id . "' ";
                    \App\Models\Songs::GetRawData($update_qry);
                    $last_record = $update_id;
                }

                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }
}
