<?php

use App\Http\Controllers\InfoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SongsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ManageCommunity;
use App\Models\User;
use Illuminate\Support\Facades\Route;

//index
Route::get('/', [SongsController::class , 'GetLoadHomePage']);

///maintenance
Route::get('/maintenance', [GeneralController::class , 'Maintenance']);

require __DIR__.'/auth.php';
require __DIR__.'/facebook.php';
require __DIR__.'/google.php';
require __DIR__.'/process.php';
require __DIR__.'/album.php';
require __DIR__.'/song.php';
require __DIR__.'/artist.php';
require __DIR__.'/review.php';
require __DIR__.'/profile.php';
require __DIR__.'/search.php';
require __DIR__.'/admin.php';
require __DIR__.'/itunes.php';
require __DIR__.'/mail.php';

 
///LoadCMS Footer Link
Route::get('/contact-us', [InfoController::class,'ContactUsPage']);
Route::post('/contact-us', [InfoController::class,'ContactFormSubmit']);
Route::get('/terms-of-use', [InfoController::class,'LoadCMS']);
Route::get('/privacy-policy', [InfoController::class,'LoadCMS']);
Route::get('/about-us', [InfoController::class,'LoadCMS']);

///Community Pages
Route::get('/our-community/{sort?}', [ManageCommunity::class,'LoadCommunityPage']);
Route::post('/sort-community-update', [ManageCommunity::class,'UpdateCommunityPage']);


///update_column
Route::get('/update-column', [InfoController::class,'update_column']);
 

 



//welcome
Route::get('/welcome/{user_seo}', [UserController::class, 'UserWelcome'])->middleware('guest');
