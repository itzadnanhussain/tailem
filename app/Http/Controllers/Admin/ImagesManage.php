<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\libraries\thumb\Thumbnail;


class ImagesManage extends Controller
{

    ///Load_Images_List
    public function Load_Images_List()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['status_id'] = null;
        $data['sr_no'] = null;


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
        $data['currentFile'] = 'images_list';
        $data['targetpage'] = 'images_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.images_list', $data);
    }

    ///Store_Image_Process
    public function Store_Image_Process()
    {
        error_reporting(0);
        if (isset($_FILES)) {
            $errorstr = "";
            $case = 1;
            $image1 = $_FILES['itune_img']['name'];
            $image2 = $_FILES['amazon_img']['name'];
            $image3 = $_FILES['google_img']['name'];

            $path            = 'site_upload/artist_images/';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $update_id = $_REQUEST['update_id'];


            if ($case == 1) {
                if ($update_id != '') {

                    if ($image1 != '') {
                        $allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
                        $temp = explode(".", $_FILES['itune_img']['name']);
                        $extension = end($temp);

                        if (!in_array($extension, $allowedExts)) {
                            echo "You have selected an invalid file\n" . "Valid files are gif, png, jpg, jpeg\n";
                            $case = 0;
                            exit;
                        }
                        if ($_FILES['itune_img']['size'] > 5000000) {
                            echo "Selected image too large\n" . "Max size allowed is 5MB\n";
                            $case = 0;
                            exit;
                        } else {
                            $new_file_name = rand() . '_' . $_FILES['itune_img']['name'];
                            move_uploaded_file($_FILES['itune_img']['tmp_name'], "site_upload/artist_images/" . $new_file_name);
                            $case = 1;
                            \App\Models\Songs::GetRawData("update tbl_store_img set store_img='" . $new_file_name . "'where store_id='" . $update_id . "'");
                        }
                    }
                    if ($image2 != '') {
                        $allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
                        $temp = explode(".", $_FILES['amazon_img']['name']);
                        $extension = end($temp);

                        if (!in_array($extension, $allowedExts)) {
                            echo "You have selected an invalid file\n" . "Valid files are gif, png, jpg, jpeg\n";
                            $case = 0;
                            exit;
                        }
                        if ($_FILES['amazon_img']['size'] > 5000000) {
                            echo "Selected image too large\n" . "Max size allowed is 5MB\n";
                            $case = 0;
                            exit;
                        } else {
                            $new_file_name = rand() . '_' . $_FILES['amazon_img']['name'];
                            move_uploaded_file($_FILES['amazon_img']['tmp_name'], "site_upload/artist_images/" . $new_file_name);
                            $case = 1;
                            \App\Models\Songs::GetRawData("update tbl_store_img set store_img='" . $new_file_name . "'where store_id='" . $update_id . "'");
                        }
                    }
                    if ($image3 != '') {
                        $allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
                        $temp = explode(".", $_FILES['google_img']['name']);
                        $extension = end($temp);

                        if (!in_array($extension, $allowedExts)) {
                            echo "You have selected an invalid file\n" . "Valid files are gif, png, jpg, jpeg\n";
                            $case = 0;
                            exit;
                        }
                        if ($_FILES['google_img']['size'] > 5000000) {
                            echo "Selected image too large\n" . "Max size allowed is 5MB\n";
                            $case = 0;
                            exit;
                        } else {
                            $new_file_name = rand() . '_' . $_FILES['itune_img']['name'];
                            move_uploaded_file($_FILES['google_img']['tmp_name'], "site_upload/artist_images/" . $new_file_name);
                            $case = 1;
                            \App\Models\Songs::GetRawData("update tbl_store_img set store_img='" . $new_file_name . "'where store_id='" . $update_id . "'");
                        }
                    }
                }


                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Store_Image
    public function Store_Image()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['edit_id'] = null;


        ///edit_id
        if (isset($_GET['edit_id'])) {
            $data['edit_id'] = $_GET['edit_id'];
        }

        ///common  lines
        $data['currentFile'] = 'store_images';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.store_images', $data);
    }

    ///Images_Delete
    public function Images_Delete()
    {
        if (!empty($_POST['del_id'])) {
            $qry = "select ad_id from tbl_advertisement where ad_id='" . $_POST['del_id'] . "' ";
            $select_arr = \App\Models\Songs::GetRawDataAdmin($qry);
            $ad_id    = $select_arr['ad_id'];
            if ($ad_id == "") {
                echo 'Error';
            } else {
                $del_qry = "Delete from tbl_advertisement where ad_id='" . $ad_id . "'";
                \App\Models\Songs::GetRawData($del_qry);
                echo 'done';
            }
        } else {
            echo 'Error';
        }
    }

    ///Images_Actions
    public function Images_Actions()
    {
        $path = 'site_upload/category_images/';
        $icon_folder = 'site_upload/categories_icons/';
        if (!empty($_POST['ad_ids'])) {
            if ($_POST['dropdown'] == 'Delete') // from button name="delete"
            {
                $checkbox = $_POST['ad_ids']; //from name="checkbox[]"
                $countCheck = count($_POST['ad_ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id     = base64_decode($checkbox[$i]);
                    $sql = "DELETE from tbl_advertisement where ad_id = '" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawData($sql);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("Deletion Successfully Done.");
                    $url = "admin/ads_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/ads_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }


            if ($_POST['dropdown'] == 'Active') // from button name="delete"
            {
                $checkbox = $_POST['ad_ids']; //from name="checkbox[]"
                $countCheck = count($_POST['ad_ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry = "select status from tbl_advertisement where ad_id='" . $del_id . "'";

                    $resul = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status = $resul['status'];
                    if ($status == 0) {
                        $status = 1;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_advertisement set status=$status where ad_id='" . $del_id . "'";
                    $result = \App\Models\Songs::GetRawData($sql);
                }
                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/ads_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/ads_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }

            if ($_POST['dropdown'] == 'Inactive') // from button name="delete"
            {
                $checkbox = $_POST['ad_ids']; // from name="checkbox[]"
                $countCheck = count($_POST['ad_ids']);

                for ($i = 0; $i < $countCheck; $i++) {
                    $del_id  = base64_decode($checkbox[$i]);
                    $qry     = "select status from tbl_advertisement where ad_id='" . $del_id . "'";
                    $resul   = \App\Models\Songs::GetRawDataAdmin($qry);
                    $status  = $resul['status'];
                    if ($status == 1) {
                        $status = 0;
                    }
                    $del_id  = base64_decode($checkbox[$i]);
                    $sql = "update tbl_advertisement set status=$status where ad_id='" . $del_id . "'";
                    $result =  \App\Models\Songs::GetRawData($sql);
                }

                if (empty($result)) {
                    $okmsg = base64_encode("status changed successfully.");
                    $url = "admin/ads_list?msg=$okmsg&case=1";
                    return  redirect($url);
                } else {
                    $errormsg = base64_encode('There are something wrong');
                    $url = "admin/ads_list?msg=$errormsg&case=2";
                    return redirect($url);
                }
            }
        } else {

            $errormsg = base64_encode('First select a record to perform some action');
            $url = "admin/ads_list?msg=$errormsg&case=2";
            return redirect($url);
        }
    }
}
