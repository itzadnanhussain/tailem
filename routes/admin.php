<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController; 


///login page
Route::get('admin/login', [LoginController::class, 'Load_Sign_Up_Page']);
Route::post('admin/login', [LoginController::class, 'Login_Process']);

///index page
Route::get('admin/index', [DashboardController::class, 'Load_Dashboard']);

//logout
Route::get('admin/logout', [LoginController::class, 'Logout_Process']);


 