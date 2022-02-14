<?php

use App\Http\Controllers\SongsController;
use Illuminate\Support\Facades\Route;

///top-songs-page routes
Route::get('/top-songs/{page?}', [SongsController::class, 'GetTopSongs'])
    ->name('top-songs.GetTopSongs');

Route::get('/add-playlist', [SongsController::class, 'GetAddPlayList'])
    ->name('add-playlist.GetAddPlayList');

Route::get('/insert-playlist', [SongsController::class, 'InsertPlayList'])
    ->name('insert-playlist.InsertPlayList');



// song_detail.php
// RewriteRule ^(.*)/reviews/(.*)-sort-(.*)-(.*)$ song_detail.php?song_seo=$1&artist_seo=$2&sort=$3&page=$4 [PT]
// RewriteRule ^(.*)/reviews/(.*)-sort-(.*)$ song_detail.php?song_seo=$1&artist_seo=$2&sort=$3 [PT]
Route::get('/{song_seo}/reviews/{artist_seo}/sort/{sort?}/{page?}', [SongsController::class, 'GetSongDetailBySort']);

// RewriteRule ^(.*)/reviews/(.*)$ song_detail.php?song_seo=$1&artist_seo=$2 [PT]
Route::get('/{song_seo}/reviews/{artist_seo}/', [SongsController::class, 'GetSongDetailBySort']);

// RewriteRule ^(.*)/reviews/(.*)-rating-(.*)$ song_detail.php?song_seo=$1&artist_seo=$2&rate=$3 [PT]
Route::get('/{song_seo}/reviews/{artist_seo}/rating/{rate?}', [SongsController::class, 'GetSongDetailByRating']);

// RewriteRule ^(.*)-reviewslist-(.*)-rating-(.*)-(.*)$ song_detail.php?song_seo=$1&artist_seo=$2&rate=$3&page=$4 [PT]
Route::get('/{song_seo}/reviewslist/{artist_seo}/rating/{rate?}/{page?}', [SongsController::class, 'GetSongDetailByRating']);

// RewriteRule ^(.*)-reviewslist-(.*)-(.*)$ song_detail.php?song_seo=$1&artist_seo=$2&page=$3 [PT]
Route::get('/{song_seo}/reviewslist/{artist_seo}/{page?}', [SongsController::class, 'GetSongDetailReviewsList']);





///latest-songs
Route::get('/latest-songs', [SongsController::class, 'GetLatestSongs'])
    ->name('latest-songs.GetLatestSongs');
