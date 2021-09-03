<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    ///home page load
    public function index(Request $request)
    {
        // $data = $request->session()->all();
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // die;
        $arr_social = GetAllRecords('social_links');
        $setting_arr = GetByWhere('general_setting', array('setting_id' => 1));
        $result_notification_count = GetByWhere('general_setting', array('setting_id' => 1));
        return view('index', compact('setting_arr'));
    }
}
