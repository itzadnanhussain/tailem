<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ManageUsers;
use App\Http\Controllers\Admin\ManageArtist;
use App\Http\Controllers\Admin\ManageCategories;
use App\Http\Controllers\Admin\ManageSetting;
use App\Http\Controllers\Admin\ManageAdvertisement;
use App\Http\Controllers\Admin\ManageSong;
use App\Http\Controllers\Admin\ManageGeneralSetting;


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


///Single_Artist_View
Route::get('admin/view_artist', [ManageArtist::class, 'Single_Artist_View']);

///**********************ManageCategories Controller**************************/

///Category List
Route::any('admin/main_cat_list', [ManageCategories::class, 'Load_Category_List']);
Route::post('admin/process/main_cat_actions', [ManageCategories::class, 'Category_Actions']);


///Add_Category
Route::any('admin/addedit_main_cat', [ManageCategories::class, 'Add_Category']);
Route::post('admin/process/main_cat_process', [ManageCategories::class, 'Category_Process']);



///**********************ManageAdvertisement Controller**************************/

///Load_Advertisement_List
Route::any('admin/ads_list', [ManageAdvertisement::class, 'Load_Advertisement_List']);
Route::post('admin/process/ads_actions', [ManageAdvertisement::class, 'Advertisement_Actions']);


///Add_Advertisement
Route::any('admin/addedit_ads', [ManageAdvertisement::class, 'Add_Advertisement']);
Route::post('admin/process/ads_process', [ManageAdvertisement::class, 'Advertisement_Process']);

///Delete_Process
Route::post('admin/process/delete_ads', [ManageAdvertisement::class, 'Advertisement_Delete']);

/*
|----------------------------------------------------
|                ManageSong Controller
|----------------------------------------------------
*/ 

///Load_Song_List
Route::any('admin/song_list', [ManageSong::class, 'Load_Song_List']);
Route::post('admin/process/songs_actions', [ManageSong::class, 'Song_Actions']);


///Add_Song
Route::any('admin/addedit_song', [ManageSong::class, 'Add_Song']);
Route::post('admin/process/song_process', [ManageSong::class, 'Song_Process']);

///Delete_Process
Route::post('admin/process/delete_song', [ManageSong::class, 'Song_Delete']);

///Change Song Status
Route::any('admin/process/song_status', [ManageSong::class, 'Change_Song_Status']);

///Load Artist
Route::any('admin/loadartists', [ManageSong::class, 'Load_Artist']);

///**********************ManageSetting Controller**************************/

///Load_Setting
Route::any('admin/setting', [ManageSetting::class, 'Load_Setting']);
Route::post('admin/process/admin_change_password_process', [ManageSetting::class, 'Change_Admin_Password']);
Route::post('admin/process/admin_email_process', [ManageSetting::class, 'Change_Admin_Email']);
Route::post('admin/process/itune_process', [ManageSetting::class, 'Change_ITune_Url']);
Route::post('admin/process/site_mode_process', [ManageSetting::class, 'Change_Site_Mode']);
Route::post('admin/process/analytic_process', [ManageSetting::class, 'Update_Analytic']);


/*
|----------------------------------------------------
|                ManageGeneralSetting Controller
|----------------------------------------------------
*/ 

///General_Setting_Page
Route::any('admin/general_setting', [ManageGeneralSetting::class, 'General_Setting_Page']);

///social_links
Route::any('admin/social_links', [ManageGeneralSetting::class, 'Social_Links']);
Route::post('admin/process/social_link_process', [ManageGeneralSetting::class, 'Social_Links_Process']);


///page_list
Route::any('admin/page_list', [ManageGeneralSetting::class, 'Page_List']);
Route::any('admin/edit_page', [ManageGeneralSetting::class, 'Edit_Page']);
Route::any('admin/process/pages_process', [ManageGeneralSetting::class, 'Edit_Page_Update']);




 