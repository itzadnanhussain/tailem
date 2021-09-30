<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\Thumbnail;


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
}