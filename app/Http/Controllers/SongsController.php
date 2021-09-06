<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Models\Songs;

class SongsController extends Controller
{
    ///construct
    // function __construct()
    // {
       
    // }

    ///GetTopSongs
    public function GetTopSongs()
    { 
        if(isset($_GET['page']))
        {
            $page = $_GET['page']; 
        }else
        {
            $page = 1;
        }

        //page View
        return view('top_songs', compact('page'));
    }


    ///GetTopAlbums
    public function GetTopAlbums()
    { 
        if(isset($_GET['page']))
        {
            $page = $_GET['page']; 
        }else
        {
            $page = 1;
        }

        //page View
        return view('album', compact('page'));
    }


    ///GetLatestSongs
    public function GetLatestSongs()
    { 
        if(isset($_GET['page']))
        {
            $page = $_GET['page']; 
        }else
        {
            $page = 1;
        }

        //page View
        return view('latest_songs', compact('page'));
    }


    ///GetTopArtist
    public function GetTopArtist()
    {
        if(isset($_GET['alpha']))
        {
            $alpha = $_GET['alpha']; 
        }else
        {
            $alpha = 'unset';
        }

        if(isset($_GET['page']))
        {
            $page = $_GET['page']; 
        }else
        {
            $page = 1;
        }
        
        //page View
        return view('artists' , compact('alpha','page'));
    }


    ///GetAddPlayList
    public function GetAddPlayList()
    {
        $song_id = $_GET['song_id'];
        $art_id = $_GET['art_id'];
        return view('add_playlist',compact('song_id','art_id'));
    }


    ///InsertPlayList
    public function InsertPlayList()
    {
        $song_id = $_GET['song_id'];
        $art_id = $_GET['art_id'];
        return view('insert_playlist',compact('song_id','art_id'));
    }
}
