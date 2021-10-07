<?php

/*
|----------------------------------------------------
|                ModerateManagement Controller
|----------------------------------------------------
*/ 

///Load_Moderate_List
Route::any('admin/album_list', [ModerateManagement::class, 'Load_Moderate_List']);
Route::post('admin/process/album_actions', [ModerateManagement::class, 'Moderate_Actions']);


///Add_Moderate
Route::any('admin/addedit_album', [ModerateManagement::class, 'Add_Moderate']);
Route::post('admin/process/album_process', [ModerateManagement::class, 'Moderate_Process']);

///Delete_Process
Route::post('admin/process/delete_album', [ModerateManagement::class, 'Moderate_Delete']);
