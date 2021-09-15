<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

 

// file name review_artist.php
///Clear routes

// RewriteRule ^(.*)-profile-review-artists-(.*)-(.*)$ review_artist.php?user_seo=$1&alpha=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-review-artists-(.*)$ review_artist.php?user_seo=$1&alpha=$2 [PT] 
Route::get('/{user_seo}/profile-review-artist/{alpha?}/{page?}',[UserController::class , 'GetReviewArtistPage_One']);


// RewriteRule ^(.*)-profile-review-artists-(.*)-genre-(.*)-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2&alpha=$3&page=$4 [PT]
// RewriteRule ^(.*)-profile-review-artists-(.*)-genre-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2&alpha=$3 [PT]
Route::get('/{user_seo}/profile-review-artist/{genere_seo}/genre/{alpha?}/{page?}',[UserController::class , 'GetReviewArtistPage_Two']);



// RewriteRule ^(.*)-profile-review-artist-genres-(.*)-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-review-artist-genre-(.*)-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-review-artist-genre-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2 [PT]
Route::get('/{user_seo}/profile-review-artist-genres/{genere_seo}/{page?}',[UserController::class , 'GetReviewArtistPage_Three']);
Route::get('/{user_seo}/profile-review-artist-genre/{genere_seo}/{page?}',[UserController::class , 'GetReviewArtistPage_Three']);





//file name my_reviews.php


///Clear routes
// RewriteRule ^(.*)-profile-review-song-rating-(.*)-sort-(.*)-(.*)$ my_reviews.php?user_seo=$1&rate=$2&sort=$3&page=$4 [PT]
// RewriteRule ^(.*)-profile-review-song-rating-(.*)-sort-(.*)$ my_reviews.php?user_seo=$1&rate=$2&sort=$3 [PT]
// RewriteRule ^(.*)-profile-review-song-rating-(.*)$ my_reviews.php?user_seo=$1&rate=$2 [PT]
Route::get('/{user_seo}/profile-review-song-rating/{rate}/sort/{sort?}/{page?}',[UserController::class , 'GetMyReviewsPage_One']);
Route::get('/{user_seo}/profile-review-song-rating/{rate}',[UserController::class , 'GetMyReviewsPage_One']);
 


// RewriteRule ^(.*)-profile-review-song-sort-(.*)-(.*)$ my_reviews.php?user_seo=$1&sort=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-review-song-sort-(.*)$ my_reviews.php?user_seo=$1&sort=$2 [PT]
Route::get('/{user_seo}/profile-review-song-sort/{sort?}/{page?}',[UserController::class , 'GetMyReviewsPage_Two']);


// RewriteRule ^(.*)-profile-review-song-sort-(.*)-(.*)$ my_reviews.php?user_seo=$1&album_seo=$2&artseo=$3 [PT]
Route::get('/{user_seo}/profile-review-song-sort/{album_seo}/{artseo}',[UserController::class , 'GetMyReviewsPage_Three']);

// RewriteRule ^(.*)-profile-review-song-(.*)_(.*)-sort-(.*)-(.*)$ my_reviews.php?user_seo=$1&album_seo=$2&artseo=$3&sort=$4&page=$5 [PT]
// RewriteRule ^(.*)-profile-review-song-(.*)_(.*)-sort-(.*)$ my_reviews.php?user_seo=$1&album_seo=$2&artseo=$3&sort=$4 [PT]
Route::get('/{user_seo}/profile-review-song/{album_seo}/{artseo}/sort/{sort?}/{page?}',[UserController::class , 'GetMyReviewsPage_Three']);


// RewriteRule ^(.*)-profile-review-song-(.*)$ my_reviews.php?user_seo=$1&album_seo=$2 [PT]
// RewriteRule ^(.*)-profile-review-song-(.*)_(.*)_(.*)$ my_reviews.php?user_seo=$1&album_seo=$2&artseo=$3&page=$4 [PT]
// RewriteRule ^(.*)-profile-review-song-(.*)_(.*)$ my_reviews.php?user_seo=$1&album_seo=$2&artseo=$3 [PT]
// RewriteRule ^(.*)-profile-review-song-(.*)-(.*)$ my_reviews.php?user_seo=$1&album_seo=$2&artseo=$3 [PT]
Route::get('/{user_seo}/profile-review-song/{album_seo}/{artseo?}/{page?}',[UserController::class , 'GetMyReviewsPage_Four']);


// RewriteRule ^(.*)-profile-review-songs-(.*)$ my_reviews.php?user_seo=$1&page=$2 [PT]
Route::get('/{user_seo}/profile-review-songs/{page?}',[UserController::class , 'GetMyReviewsPage_Five']);

 

// RewriteRule ^(.*)-review-songslist-(.*)-sort-(.*)-(.*)$ my_reviews.php?artseo=$1&album_seo=$2&sort=$3&page=$4 [PT]
Route::get('/{artseo}/review-songslist/{album_seo}/sort/{sort}/{page?}',[UserController::class , 'GetMyReviewsPage_Six']);

// RewriteRule ^(.*)-review-songs-(.*)-sort-(.*)$ my_reviews.php?artseo=$1&album_seo=$2&sort=$3 [PT]
Route::get('/{artseo}/review-songs/{album_seo}/sort/{sort}',[UserController::class , 'GetMyReviewsPage_Six']);


// RewriteRule ^(.*)-review-songslist-(.*)-(.*)$ my_reviews.php?artseo=$1&album_seo=$2&page=$3 [PT]
// RewriteRule ^(.*)-review-songs-(.*)$ my_reviews.php?artseo=$1&album_seo=$2 [PT]
Route::get('/{artseo}/review-songslist/{album_seo}/{page?}',[UserController::class , 'GetMyReviewsPage_Seven']);


// RewriteRule ^review-songs-(.*)$ my_reviews.php?album_seo=$1 [PT]
Route::get('/review-songs/{album_seo}',[UserController::class , 'GetMyReviewsPage_Eight']);


// RewriteRule ^(.*)-profile-review-song$ my_reviews.php?user_seo=$1 [PT]
Route::get('/{user_seo}/profile-review-song',[UserController::class , 'GetMyReviewsPage_Nine']);

// RewriteRule ^review-song-rating-(.*)-sort-(.*)-(.*)$ my_reviews.php?rate=$1&sort=$2&page=$3 [PT]
// RewriteRule ^review-song-rating-(.*)-sort-(.*)$ my_reviews.php?rate=$1&sort=$2 [PT]
Route::get('/review-song-rating/{rate}/sort/{sort}/{page?}',[UserController::class , 'GetMyReviewsPage_Ten']);

// RewriteRule ^review-song-rating-(.*)$ my_reviews.php?rate=$1 [PT]
Route::get('/review-song-rating/{rate}',[UserController::class , 'GetMyReviewsPage_Eleven']);

// RewriteRule ^review-song-ratings-(.*)-(.*)$ my_reviews.php?rate=$1&page=$2 [PT]
Route::get('/review-song-ratings/{rate}/{page?}',[UserController::class , 'GetMyReviewsPage_Eleven']);

// RewriteRule ^review-song-sort-(.*)-(.*)$ my_reviews.php?sort=$1&page=$2 [PT]
// RewriteRule ^review-song-sort-(.*)$ my_reviews.php?sort=$1 [PT]
Route::get('/review-song-sort/{sort}/{page?}',[UserController::class , 'GetMyReviewsPage_Twelve']);

// RewriteRule ^review-song-(.*)$ my_reviews.php?page=$1 [PT] [PT]
// RewriteRule ^review-song$ my_reviews.php [PT]
Route::get('/review-song/{page?}',[UserController::class , 'GetMyReviewsPage_Thirteen']);

// RewriteRule ^(.*)-profile-review-song-ratings-(.*)-(.*)$ my_reviews.php?user_seo=$1&rate=$2&page=$3 [PT]
Route::get('{user_seo}/profile-review-song-ratings/{rate}/{page?}',[UserController::class , 'GetMyReviewsPage_Fourteen']);
