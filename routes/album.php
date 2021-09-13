<?php

use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

// RewriteRule ^top-albums-(.*)$ album.php?page=$1 [PT]
// RewriteRule ^top-albums$ album.php [PT]
Route::get('/top-albums',[AlbumController::class, 'GetTopAlbums']) 
->name('top-albums.GetTopAlbums');
 


// RewriteRule ^(.*)-profile-review-album-(.*)$ review_album.php?user_seo=$1&page=$2 [PT]
// RewriteRule ^review-album-(.*)$ review_album.php?page=$1 [PT]
// RewriteRule ^(.*)-album-(.*)$ albums_page.php?artist_seo=$1&album_seo=$2 [PT]
// RewriteRule ^(.*)-albums-(.*)$ albums_page.php?artist_seo=$1&page=$2 [PT]  
Route::get('/{artist_seo}/album/{album_seo?}',[AlbumController::class , 'GetAlbumDetail']);
Route::get('/{artist_seo}/artist-albums/{album_seo?}/{page?}',[AlbumController::class , 'GetAlbumDetail']);
