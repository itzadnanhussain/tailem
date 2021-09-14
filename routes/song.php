<?php

use App\Http\Controllers\SongsController;
use Illuminate\Support\Facades\Route;

///top-songs-page routes
Route::get('/top-songs',[SongsController::class, 'GetTopSongs']) 
->name('top-songs.GetTopSongs');

Route::get('/add-playlist',[SongsController::class, 'GetAddPlayList']) 
->name('add-playlist.GetAddPlayList');

Route::get('/insert-playlist',[SongsController::class, 'InsertPlayList']) 
->name('insert-playlist.InsertPlayList');

 

// song_like/detail
// RewriteRule ^(.*)-reviews-(.*)-sort-(.*)-(.*)$ song_like/detail?song_seo=$1&artist_seo=$2&sort=$3&page=$4 [PT]
// RewriteRule ^(.*)-reviews-(.*)-sort-(.*)$ song_like/detail?song_seo=$1&artist_seo=$2&sort=$3 [PT]
// RewriteRule ^(.*)-reviews-(.*)-rating-(.*)$ song_like/detail?song_seo=$1&artist_seo=$2&rate=$3 [PT]
// RewriteRule ^(.*)-reviews-(.*)$ song_like/detail?song_seo=$1&artist_seo=$2 [PT]

Route::get('/{song_seo}/reviews/{artist_seo}/',[SongsController::class , 'GetSongDetail']); 
Route::get('/{song_seo}/reviews/{artist_seo}/rating/{value?}',[SongsController::class , 'GetSongDetail']); 
Route::get('/{song_seo}/reviews/{artist_seo}/sort/{value?}',[SongsController::class , 'GetSongDetail']); 



///latest-songs
Route::get('/latest-songs',[SongsController::class, 'GetLatestSongs']) 
->name('latest-songs.GetLatestSongs');


 



