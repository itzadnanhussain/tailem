<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 

class GeneralController extends Controller
{
    ///Maintenance
    public function Maintenance()
    { 
        //page View
        $data = array();
        $data['currentFile'] = 'maintance';
        $data['title'] = GetTitle();
        return view('maintance', $data);
    }
}