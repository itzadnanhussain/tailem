<?php

/*
|----------------------------------------------------
|                ManageSong Controller
|----------------------------------------------------
*/ 

///Load_Song_List
Route::any('admin/song_list', [ManageSong::class, 'Load_Song_List']);
Route::post('admin/process/song_actions', [ManageSong::class, 'Song_Actions']);


///Add_Song
Route::any('admin/addedit_song', [ManageSong::class, 'Add_Song']);
Route::post('admin/process/song_process', [ManageSong::class, 'Song_Process']);

///Delete_Process
Route::post('admin/process/delete_song', [ManageSong::class, 'Song_Delete']);
