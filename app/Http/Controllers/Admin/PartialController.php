<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\libraries\thumb\Thumbnail;


class PartialController extends Controller
{

    ///User_Name_Fetch
    public function User_Name_Fetch()
    {
        $keyword = $_POST['data'];
        $sql = "select user_name from tbl_users where user_name like '".$keyword."%' limit 0,20";
        //$sql = "select name from ".$db_table."";
        $result = \App\Models\Songs::GetRawData($sql);
    
        if($result)
        {
            echo '<ul class="list">';
            foreach($result as $row)
            {
                $row = (array)$row;
                $str = stripslashes($row['user_name']);
                $start = strpos($str,$keyword); 
                $end   = similar_text($str,$keyword); 
                $last = substr($str,$end,strlen($str));
                $first = substr($str,$start,$end);
                
                $final = '<span class="bold">'.$first.'</span>'.$last;
            
                echo '<li><a href=\'javascript:void(0);\'>'.$final.'</a></li>';
            }
            echo "</ul>";
        }
        else
            echo 0;
    }


}