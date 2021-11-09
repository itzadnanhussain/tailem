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
use App\Http\Controllers\Admin\ReviewManagement;
use App\Http\Controllers\Admin\PartialController;
use App\Http\Controllers\Admin\AlbumsManagement;
use App\Http\Controllers\Admin\ImagesManage;
use App\Http\Controllers\Admin\ModerateManagement;


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

/*
|----------------------------------------------------
|                ManageArtists Controller
|----------------------------------------------------
*/ 

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
Route::get('admin/addedit_featured_artist', [ManageArtist::class, 'Addedit_Featured_Artist']);
Route::post('admin/process/featured_artist_album_assocs', [ManageArtist::class, 'Featured_Artist_Album_Assocs']);


///Single_Artist_View
Route::get('admin/view_artist', [ManageArtist::class, 'Single_Artist_View']);

///artist_song_actions
Route::post('admin/process/artist_song_actions', [ManageArtist::class, 'Artist_Song_Actions']);

///delete_artist_songs
Route::post('admin/process/delete_artist_songs', [ManageArtist::class, 'Delete_Artist_Songs']);


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

///Artist_Song_List
Route::any('admin/artist_list_song', [ManageSong::class, 'Artist_Song_List']);

///artist_list_album_song
Route::any('admin/artist_list_album_song', [ManageSong::class, 'Artist_List_Album_Song']);


///addedit_song_artist_album
Route::any('admin/addedit_song_artist_album', [ManageSong::class, 'Addedit_Song_Artist_Album']);

///song_artist_album_process
Route::post('admin/process/song_artist_album_process', [ManageSong::class, 'Song_Artist_Album_Process']);

///**********************ManageSetting Controller**************************/

///Load_Setting
Route::any('admin/setting', [ManageSetting::class, 'Load_Setting']);
Route::post('admin/process/admin_change_password_process', [ManageSetting::class, 'Change_Admin_Password']);
Route::post('admin/process/admin_email_process', [ManageSetting::class, 'Change_Admin_Email']);
Route::post('admin/process/update_copyright_text', [ManageSetting::class, 'Update_Copy_Right_text']);
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
Route::post('admin/process/general_setting_process', [ManageGeneralSetting::class, 'General_Setting_Process']);

///social_links
Route::any('admin/social_links', [ManageGeneralSetting::class, 'Social_Links']);
Route::post('admin/process/social_link_process', [ManageGeneralSetting::class, 'Social_Links_Process']);


///page_list
Route::any('admin/page_list', [ManageGeneralSetting::class, 'Page_List']);
Route::any('admin/edit_page', [ManageGeneralSetting::class, 'Edit_Page']);
Route::any('admin/process/pages_process', [ManageGeneralSetting::class, 'Edit_Page_Update']);

///email_templates_list
Route::any('admin/email_templates_list', [ManageGeneralSetting::class, 'Email_Templates_List']);
Route::any('admin/edit_email_template', [ManageGeneralSetting::class, 'Edit_Email_Template']);
Route::any('admin/process/email_templates_process', [ManageGeneralSetting::class, 'Edit_Email_Template_Update']);

///Social_Icon
Route::any('admin/social_icons', [ManageGeneralSetting::class, 'Social_Icon']);
Route::post('admin/process/social_icons_process', [ManageGeneralSetting::class, 'Social_Icons_Process']);

/*
|----------------------------------------------------
|                ReviewManagement Controller
|----------------------------------------------------
*/

///Add_New_Review
Route::any('admin/review_add', [ReviewManagement::class, 'Add_New_Review']);
Route::post('admin/process/add_review_process', [ReviewManagement::class, 'Review_Process']);

///Edit_Review
Route::any('admin/edit_review', [ReviewManagement::class, 'Edit_Review']);
Route::post('admin/process/edit_review_process', [ReviewManagement::class, 'Edit_Review_Process']);


///Review_List
Route::any('admin/reviews_list', [ReviewManagement::class, 'Review_List']);

///Delete_Process
Route::post('admin/process/delete_review', [ReviewManagement::class, 'Review_Delete']);

///Review_Actions
Route::post('admin/process/reviews_actions', [ReviewManagement::class, 'Review_Actions']);

///Set_Review_Popular_Or_Unpopular
Route::post('admin/process/set_popular', [ReviewManagement::class, 'Set_Review_Popular_Or_Unpopular']);

///Featured_Review_Process
Route::post('admin/process/featured_review_process', [ReviewManagement::class, 'Featured_Review_Process']);


///Review_Likes
Route::any('admin/review_likes', [ReviewManagement::class, 'Review_Likes']);

///Review_Report
Route::any('admin/review_reports', [ReviewManagement::class, 'Review_Report']);

///Discussion_List
Route::any('admin/gcomments', [ReviewManagement::class, 'Discussion_List']);

///Report_Checkbox_List
Route::any('admin/report_checkbox_list', [ReviewManagement::class, 'Report_Checkbox_List']);

///Add_Report_Checkbox
Route::any('admin/add_report_checkbox', [ReviewManagement::class, 'Add_Report_Checkbox']);
Route::post('admin/process/report_option_process', [ReviewManagement::class, 'Report_Option_Process']);

///Delete_Report_Option
Route::post('admin/process/delete_report_option', [ReviewManagement::class, 'Delete_Report_Option']);

///review_details
Route::any('admin/review_details', [ReviewManagement::class, 'Review_Details']);

///Edit_Discussion
Route::any('admin/edit_discussion', [ReviewManagement::class, 'Edit_Discussion']);
Route::post('admin/process/edit_discussion_process', [ReviewManagement::class, 'Edit_Discussion_Process']);
Route::any('admin/gcomments_reports', [ReviewManagement::class, 'Gcomments_Reports']);
Route::any('admin/process/delete_review_comment', [ReviewManagement::class, 'Delete_Review_Comment']);
Route::any('admin/process/review_comment_actions', [ReviewManagement::class, 'Review_Comment_Actions']);

/*
|----------------------------------------------------
|                AlbumsManagement Controller
|----------------------------------------------------
*/ 

///Album_List_Page
Route::any('admin/album_list', [AlbumsManagement::class, 'Album_List_Page']);

///Change_Album_Status
Route::post('admin/process/album_status', [AlbumsManagement::class, 'Change_Album_Status']);

///Album_Actions
Route::post('admin/process/album_actions2', [AlbumsManagement::class, 'Album_Actions_2']);


///Add_Album
Route::any('admin/addedit_album', [AlbumsManagement::class, 'Add_Album']);
Route::post('admin/process/album_process', [AlbumsManagement::class, 'Album_Process']);

///Delete_Process
Route::post('admin/process/delete_album', [AlbumsManagement::class, 'Album_Delete']);

///Add_Edit_Artist_Album
Route::any('admin/addedit_artist_album', [AlbumsManagement::class, 'Add_Edit_Artist_Album']);

///Album_Process
Route::any('admin/process/album_process', [AlbumsManagement::class, 'Album_Process']);


///Artist_Album_List
Route::any('admin/artist_album_list', [AlbumsManagement::class, 'Artist_Album_List']);
Route::post('admin/process/album_actions', [AlbumsManagement::class, 'Album_Actions']);


///Artist_Album_Songs_List
Route::any('admin/artist_album_songs_list', [AlbumsManagement::class, 'Artist_Album_Songs_List']);


/*
|----------------------------------------------------
|                ModerateManagement Controller
|----------------------------------------------------
*/ 

///Load_Moderate_List
Route::any('admin/moderator_list', [ModerateManagement::class, 'Load_Moderate_List']);

///Moderate_Actions
Route::any('admin/process/moderator_actions', [ModerateManagement::class, 'Moderate_Actions']);


///Add_Edit_Artist_Moderate
Route::any('admin/addedit_moderator', [ModerateManagement::class, 'Add_Edit_Artist_Moderate']);

///Moderate_Process
Route::post('admin/process/moderator_process', [ModerateManagement::class, 'Moderate_Process']);


///Delete_Moderate
Route::post('admin/process/delete_moderator_process', [ModerateManagement::class, 'Delete_Moderate']);

///Moderate_Rights
Route::any('admin/moderator_rights', [ModerateManagement::class, 'Moderate_Rights']);

///Moderate_Right_Process
Route::post('admin/process/moderator_right_process', [ModerateManagement::class, 'Moderate_Right_Process']);


/*
|----------------------------------------------------
|                ImagesManage Controller
|----------------------------------------------------
*/ 

///Load_Images_List
Route::any('admin/images_list', [ImagesManage::class, 'Load_Images_List']);


///Edit_Image
Route::any('admin/store_images', [ImagesManage::class, 'Store_Image']);

///Store_Image_Process
Route::post('admin/process/store_images_process', [ImagesManage::class, 'Store_Image_Process']);


/*
|----------------------------------------------------
|                Partial  Controller
|----------------------------------------------------
*/

///User_Name_Fetch
Route::any('admin/name_fetch', [PartialController::class, 'User_Name_Fetch']);


 