<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ManageUsers;

///login page
Route::get('admin/login', [LoginController::class, 'Load_Sign_Up_Page']);
Route::post('admin/login', [LoginController::class, 'Login_Process']);

///index page
Route::get('admin/index', [DashboardController::class, 'Load_Dashboard']);

///Users List
Route::any('admin/users_list', [ManageUsers::class, 'Load_Users_List']);

///User Add
Route::any('admin/addedit_user', [ManageUsers::class, 'Load_User_Add']);
Route::post('admin/process/user_process', [ManageUsers::class, 'Add_User_Database']);

///User Delete
Route::post('admin/process/delete_user', [ManageUsers::class, 'Delete_User_Database']);

///User Actions
Route::post('admin/process/users_actions', [ManageUsers::class, 'User_Actions']);


//logout
Route::get('admin/logout', [LoginController::class, 'Logout_Process']);


 