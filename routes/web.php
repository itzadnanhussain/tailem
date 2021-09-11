<?php

use App\Http\Controllers\InfoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SongsController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route; 
 

//index
Route::get('/', [SongsController::class , 'GetLoadHomePage']); 



///top-songs-page routes
Route::get('/top-songs',[SongsController::class, 'GetTopSongs']) 
->name('top-songs.GetTopSongs');

Route::get('/add-playlist',[SongsController::class, 'GetAddPlayList']) 
->name('add-playlist.GetAddPlayList');

Route::get('/insert-playlist',[SongsController::class, 'InsertPlayList']) 
->name('insert-playlist.InsertPlayList');

///songs write-a-review
Route::get('/write-a-review/{slug}',[SongsController::class , 'SongWriteReview']);

///songs detail
Route::get('/song-detail/{slug}',[SongsController::class , 'GetSongDetail']);


///top-albums
Route::get('/top-albums',[SongsController::class, 'GetTopAlbums']) 
->name('top-albums.GetTopAlbums');
 

///latest-songs
Route::get('/latest-songs',[SongsController::class, 'GetLatestSongs']) 
->name('latest-songs.GetLatestSongs');
 
///artist_page
Route::get('/artist/{slug}/{sort?}',[SongsController::class , 'GetArtistSongs']); 
// Route::get('/{artist_seo}-artist-songs',[SongsController::class , 'GetArtistSongs']); 
// Route::get('/Walter-Melrose-artist-songs',[UserController::class , 'GetArtistSongs']);


///top-artists
Route::get('/top-artists',[SongsController::class, 'GetTopArtist']) 
->name('top-artists.GetTopArtist');
 
 

require __DIR__.'/auth.php';
require __DIR__.'/facebook.php';
require __DIR__.'/process.php';

 
///LoadCMS Footer Link
Route::get('/contact-us', [InfoController::class,'ContactUsPage']);
Route::post('/contact-us', [InfoController::class,'ContactFormSubmit']);  
Route::get('/terms-of-use',[InfoController::class,'LoadCMS']);
Route::get('/privacy-policy',[InfoController::class,'LoadCMS']);
Route::get('/about-us',[InfoController::class,'LoadCMS']);


 ///User Controller///

//review_artist.php
// RewriteRule ^(.*)-profile-review-artists-(.*)-genre-(.*)-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2&alpha=$3&page=$4 [PT]
// RewriteRule ^(.*)-profile-review-artists-(.*)-genre-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2&alpha=$3 [PT]
// RewriteRule ^(.*)-profile-review-artists-(.*)-(.*)$ review_artist.php?user_seo=$1&alpha=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-review-artists-(.*)$ review_artist.php?user_seo=$1&alpha=$2 [PT]
// RewriteRule ^(.*)-profile-review-artist-genres-(.*)-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-review-artist-genre-(.*)-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-review-artist-genre-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2 [PT]

Route::get('/{user_seo}-profile-review-artist',[UserController::class , 'GetReviewArtistPage']);
// Route::get('/{user_seo}-profile-review-song-{}',[UserController::class , 'GetReviewArtistPage']);




//welcome
Route::get('/welcome-{user_name}',[UserController::class, 'UserWelcome'])->middleware('guest');














 