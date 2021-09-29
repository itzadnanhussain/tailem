<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ManageUsers;
use App\Http\Controllers\Admin\ManageArtist;


///**********************Login Controller**************************/

///login page
Route::get('admin/login', [LoginController::class, 'Load_Sign_Up_Page']);
Route::post('admin/login', [LoginController::class, 'Login_Process']);

///logout
Route::get('admin/logout', [LoginController::class, 'Logout_Process']);

///**********************Dashboard Controller**************************/

///index page
Route::get('admin/index', [DashboardController::class, 'Load_Dashboard']);

///**********************ManageUsers Controller**************************/

///Users List
Route::any('admin/users_list', [ManageUsers::class, 'Load_Users_List']);

///User Add
Route::any('admin/addedit_user', [ManageUsers::class, 'Load_User_Add']);
Route::post('admin/process/user_process', [ManageUsers::class, 'Add_User_Database']);

///User Delete
Route::post('admin/process/delete_user', [ManageUsers::class, 'Delete_User_Database']);

///User Actions
Route::post('admin/process/users_actions', [ManageUsers::class, 'User_Actions']);

///**********************ManageArtists Controller**************************/

///Artist List
Route::any('admin/artist_list', [ManageArtist::class, 'Load_Artist_List']);

///Artist Add
Route::any('admin/addedit_artist', [ManageArtist::class, 'Load_Artist_Add']);
Route::post('admin/process/artist_process', [ManageArtist::class, 'Artist_Process']);


///Artist Delete
Route::post('admin/process/delete_artist', [ManageArtist::class, 'Delete_Artist']);

///Artist Actions
Route::post('admin/process/artist_actions', [ManageArtist::class, 'Artist_Actions']);


///Artist Actions
Route::get('admin/artist_featured_songs_list', [ManageArtist::class, 'Artist_Featured_Songs_List']);







 


 