<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request; 

class TestController extends Controller
{


    ///process
    public function process()
    {
        return view('process');
    }
}