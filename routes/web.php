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

Route::get('/test',function(){
    echo 'test';
    die;
});

///top-songs
Route::get('/top-songs',[SongsController::class, 'GetTopSongs']) 
->name('top-songs.GetTopSongs');

///top-albums
Route::get('/top-albums',[SongsController::class, 'GetTopAlbums']) 
->name('top-albums.GetTopAlbums');
 
 

require __DIR__.'/auth.php';
require __DIR__.'/facebook.php';

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

 
















Route::post('/test', function(){
    echo 'test';
    die;
});