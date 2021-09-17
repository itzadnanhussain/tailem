<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

 


// RewriteRule ^searcher$ search.php [PT]
Route::post('/searcher',[SearchController::class , 'PostHomePageSearch']);
Route::get('/searcher',[SearchController::class , 'GetHomePageSearch']);


// RewriteRule ^searcher-song-(.*)$ search_song.php?page=$1 [PT]
// RewriteRule ^searcher-results-song$ search_song.php [PT]
Route::get('/searcher-results-song',[SearchController::class , 'GetSearchResultSongs']);
Route::post('/searcher-results-song',[SearchController::class , 'PostSearchResultSongs']);
Route::get('/searcher-song/{get?}',[SearchController::class , 'GetSearchResultSongs']);


// RewriteRule ^searcher-artistlist-(.*)$ search_artist.php?page=$1 [PT]
// RewriteRule ^searcher-results-artist$ search_artist.php [PT]
Route::get('/searcher-results-artist',[SearchController::class , 'GetSearchResultArtist']);
Route::post('/searcher-results-artist',[SearchController::class , 'PostSearchResultArtist']);
Route::get('/searcher-artistlist/{page?}',[SearchController::class , 'GetSearchResultArtist']);



// RewriteRule ^searcher-albumlist-(.*)$ search_albumlist.php?page=$1 [PT]
// RewriteRule ^searcher-results-album$ search_albumlist.php [PT]
Route::get('/searcher-results-album',[SearchController::class , 'GetSearchResultAlbum']);
Route::post('/searcher-results-album',[SearchController::class , 'PostSearchResultAlbum']);
Route::get('/searcher-albumlist/{page?}',[SearchController::class , 'GetSearchResultAlbum']);
