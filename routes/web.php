<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SongsController;
use Illuminate\Support\Facades\Route;

 
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');



 
/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
|
*/

//before login
Route::get('/',[DashboardController::class,'index'])
->name('home.index');

///after login
Route::get('/home',[DashboardController::class,'index'])
->middleware(['auth'])
->name('home.index');

/*
|--------------------------------------------------------------------------
| Songs
|--------------------------------------------------------------------------
|
*/

 

///top-songs-page routes
Route::get('/top-songs',[SongsController::class, 'GetTopSongs']) 
->name('top-songs.GetTopSongs');

Route::get('/add-playlist',[SongsController::class, 'GetAddPlayList']) 
->name('add-playlist.GetAddPlayList');

Route::get('/insert-playlist',[SongsController::class, 'InsertPlayList']) 
->name('insert-playlist.InsertPlayList');


///top-albums
Route::get('/top-albums',[SongsController::class, 'GetTopAlbums']) 
->name('top-albums.GetTopAlbums');
 

///latest-songs
Route::get('/latest-songs',[SongsController::class, 'GetLatestSongs']) 
->name('latest-songs.GetLatestSongs');
 


///top-artists
Route::get('/top-artists',[SongsController::class, 'GetTopArtist']) 
->name('top-artists.GetTopArtist');
 
 

require __DIR__.'/auth.php';
require __DIR__.'/facebook.php';
require __DIR__.'/process.php';

/*
|--------------------------------------------------------------------------
| Others
|--------------------------------------------------------------------------
|
*/

///Contact Us
Route::get('/contact-us', [InfoController::class,'ContactUsPage']);
Route::post('/contact-us', [InfoController::class,'ContactFormSubmit']);
// Route::resource('contact-form', App\Http\Controllers\ContactController::class);



///LoadCMS
Route::get('/terms-of-use',[InfoController::class,'LoadCMS']);
Route::get('/privacy-policy',[InfoController::class,'LoadCMS']);
Route::get('/about-us',[InfoController::class,'LoadCMS']);


Route::get('/process', [TestController::class, 'process']); 












 