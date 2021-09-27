<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;


class DashboardController extends Controller
{

    ///Load_Dashboard
    public function Load_Dashboard()
    {

        $data = array();
        ///common  lines
        $data['currentFile'] = 'index';
        $data = top_file_data($data); 
        $data['title'] = GetTitle();
        
        return view('admin.index', $data);
    }

    



   
}
