<?php

use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

// RewriteRule ^top-albums-(.*)$ album.php?page=$1 [PT]
// RewriteRule ^top-albums$ album.php [PT]
Route::get('/top-albums/{page?}',[AlbumController::class, 'GetTopAlbums']) 
->name('top-albums.GetTopAlbums');
 


// RewriteRule ^(.*)-profile-review-album-(.*)$ review_album.php?user_seo=$1&page=$2 [PT]
// RewriteRule ^review-album-(.*)$ review_album.php?page=$1 [PT]
// RewriteRule ^(.*)-album-(.*)$ albums_page.php?artist_seo=$1&album_seo=$2 [PT]
// RewriteRule ^(.*)-albums-(.*)$ albums_page.php?artist_seo=$1&page=$2 [PT]  
Route::get('/{artist_seo}/album/{album_seo?}',[AlbumController::class , 'GetAlbumDetail']);
Route::get('/{artist_seo}/artist-albums/{album_seo?}/{page?}',[AlbumController::class , 'GetAlbumDetail']);


///page review_album.php

///on working
// RewriteRule ^(.*)-profile-(.*)-review-albums-(.*)$ review_album.php?user_seo=$1&artist_seo=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-(.*)-review-albums$ review_album.php?user_seo=$1&artist_seo=$2 [PT]
Route::get('/{user_seo}/profile/{artist_seo}/review-albums',[AlbumController::class , 'GetAlbumProfileDetail_One']);


// RewriteRule ^(.*)-(.*)-review-albums$ review_album.php?user_seo=$1&artist_seo=$2 [PT]
Route::get('/{user_seo}/{artist_seo}/review-albums',[AlbumController::class , 'GetAlbumProfileDetail_One']);


// RewriteRule ^(.*)-review-albums-(.*)$ review_album.php?artist_seo=$1&page=$2 [PT]
// RewriteRule ^(.*)-review-albums$ review_album.php?artist_seo=$1 [PT]
Route::get('/{artist_seo}/review-albums',[AlbumController::class , 'GetAlbumProfileDetail_Two']);


// RewriteRule ^(.*)-profile-review-album-(.*)$ review_album.php?user_seo=$1&page=$2 [PT]
// RewriteRule ^(.*)-profile-review-album$ review_album.php?user_seo=$1
Route::get('/{user_seo}/profile-review-album',[AlbumController::class , 'GetAlbumProfileDetail_Three']);


// RewriteRule ^review-album-(.*)$ review_album.php?page=$1 [PT]
// RewriteRule ^review-album-(.*)$ review_album.php?page=$1 [PT]
// RewriteRule ^review-album$ review_album.php [PT]
Route::get('/review-album',[AlbumController::class , 'GetAlbumProfileDetail_Four']);

