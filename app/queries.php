<?php

use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\DB;


//****************************Queries*********************************** */
///Get All Records
if (!function_exists('GetAllRecords')) {
    function GetAllRecords($table = null)
    { 
        $records = DB::table($table)->get();
        return $records->toArray();
    }
}


///Get Single Record
if (!function_exists('GetSingleRecord')) {
    function GetSingleRecord($table = null, $where = array())
    {  
        $records = DB::table($table)->where($where)->first();
        return $records->toArray();
    }
}


///GetByWhere
if (!function_exists('GetByWhere')) {
    function GetByWhere($table = null, $where = array())
    { 
        $records = DB::table($table)->where($where)->get();
        return $records->toArray();
    }
}

///LastQuery
if (!function_exists('GetLastQuery')) {
    function GetLastQuery()
    {
        $query = DB::getQueryLog();
        dd($query);
    }
}


///TestJoins
if (!function_exists('TestJoins')) {
    function TestJoins()
    {
        ///Query Logs
        DB::enableQueryLog();

        ///Query
        $users = DB::table('tbl_songs as s')
            ->join('tbl_songs_artist_album as saa', 'saa.song_id', '=', 's.id')
            ->join('tbl_artist_album as b', 'saa.album_id', '=', 'b.id')
            ->join('tbl_artists as a', 'saa.artist_id', '=', 'a.id')  
            ->select('s.song_title', 'saa.*' ,'b.*','a.*') 
            ->where([
                                ['saa.display_status', '=', '1'],
                                ['s.song_status', '=', '1'],
                                ['s.ranking_order', '>', '0'],
                            ])


            // ->groupBy('s.id')

            ->orderBy('s.ranking_order','asc')
            ->limit(50)  
            ->get();

        GetLastQuery();
        die;
    }
}


///EnableQueryLog 
if(!function_exists('EnableQueryLog'))
{
    function EnableQueryLog()
    {
        ///Query Logs
        DB::enableQueryLog();  
    }
}


