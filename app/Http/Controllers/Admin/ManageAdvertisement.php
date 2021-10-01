<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\Thumbnail;


class ManageAdvertisement extends Controller
{

    ///Load_Advertisement_List
    public function Load_Advertisement_List()
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
        $data['currentFile'] = 'ads_list';
        $data['targetpage'] = 'ads_list';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.ads_list', $data);
    }



    ///Advertisement_Process
    public function Advertisement_Process()
    {
        error_reporting(0);
        // include("../includes/top.php");
        if (isset($_POST)) {
            $errorstr = "";
            $case = 1;
            $ad_script    = trim($_REQUEST['ad_script']);
            $ad_place     = trim($_REQUEST['ad_place']);
            $update_id    = $_REQUEST['update_id'];

            if ($ad_script == "" || $ad_script == "&nbsp;") {
                $errorstr .= "Please Enter Google Adsense Code\n";
                $case = 0;
            }
            if ($ad_place == "") {
                $errorstr .= "Please Select Ads Place\n";
                $case = 0;
            } else {
                $place_arr = array('Top', 'Right', 'Bottom');
                if (!in_array($ad_place, $place_arr)) {
                    $errorstr .= "Invalid Ads Place is selected\n";
                    $case = 0;
                }
            }


            if ($case == 1) {
                if ($update_id != '') {
                    $qry = "update tbl_advertisement set ad_place='" .  $ad_place . "',ad_script ='" . $ad_script . "' where ad_id='" . $update_id . "'";
                    \App\Models\Songs::GetRawData($qry);
                } else {
                    $qry = "insert into tbl_advertisement set  ad_script ='" . $ad_script . "',ad_place='" . $ad_place . "',status='1' ";
                    \App\Models\Songs::GetRawData($qry);
                }
                echo 'done';
            } else {
                echo $errorstr;
            }
        }
    }

    ///Add_Advertisement
    public function Add_Advertisement()
    {
        $data = array();
        $data['sortby'] = null;
        $data['page'] = null;
        $data['msg'] = null;
        $data['case'] = null;
        $data['status'] = null;
        $data['edit_id'] = null;
        $data['ad_script'] = null;
        $data['ad_place'] = null;


        ///edit_id
        if (isset($_GET['edit_id'])) {
            $data['edit_id'] = $_GET['edit_id'];
        }

        ///common  lines
        $data['currentFile'] = 'addedit_ads';
        $data = top_file_data($data);
        $data['title'] = GetTitle();

        return view('admin.addedit_ads', $data);
    }

    ///Advertisement_Delete
    public function Advertisement_Delete()
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

    ///Advertisement_Actions
    public function Advertisement_Actions()
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
