<?php

use App\Http\Controllers\ProcessController; 
use Illuminate\Support\Facades\Route; 
 

 

///process/add_playlist_process
Route::post('process/add_playlist_process',[ProcessController::class, 'AddPlaylistProcess']) 
->name('process/add_playlist_process.AddPlaylistProcess');
 
///add_songto_playlist_process
Route::post('process/add_songto_playlist_process',[ProcessController::class, 'AddSongToPlayList']) 
->name('process/add_songto_playlist_process.AddSongToPlayList');
 
 
 
 












 