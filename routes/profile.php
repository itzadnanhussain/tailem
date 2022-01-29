<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// file name review_artist.php
///Clear routes

// RewriteRule ^(.*)-profile-review-artists-(.*)-(.*)$ review_artist.php?user_seo=$1&alpha=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-review-artists-(.*)$ review_artist.php?user_seo=$1&alpha=$2 [PT]
Route::any('/{user_seo}/profile-review-artist/{alpha?}/{page?}', [UserController::class, 'GetReviewArtistPage_One']);
Route::any('/{user_seo}/profile-review-artists/{alpha?}/{page?}', [UserController::class, 'GetReviewArtistPage_One']);
Route::any('/{user_seo}/profile-review-artists-{alpha?}/{page?}', [UserController::class, 'GetReviewArtistPage_One']);


// RewriteRule ^(.*)-profile-review-artists-(.*)-genre-(.*)-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2&alpha=$3&page=$4 [PT]
// RewriteRule ^(.*)-profile-review-artists-(.*)-genre-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2&alpha=$3 [PT]
Route::any('/{user_seo}/profile-review-artist/{genere_seo}/genre/{alpha?}/{page?}', [UserController::class, 'GetReviewArtistPage_Two']);
Route::any('/{user_seo}/profile-review-artists/{genere_seo}/genre/{alpha?}/{page?}', [UserController::class, 'GetReviewArtistPage_Two']);



// RewriteRule ^(.*)-profile-review-artist-genres-(.*)-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-review-artist-genre-(.*)-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-review-artist-genre-(.*)$ review_artist.php?user_seo=$1&genere_seo=$2 [PT]
Route::any('/{user_seo}/profile-review-artist-genres/{genere_seo}/{page?}', [UserController::class, 'GetReviewArtistPage_Three']);
Route::any('/{user_seo}/profile-review-artist-genre/{genere_seo}/{page?}', [UserController::class, 'GetReviewArtistPage_Three']);
Route::any('/{user_seo}/review-artist-genre/{genere_seo}/{page?}', [UserController::class, 'GetReviewArtistPage_Three']);

// RewriteRule ^review-artist-(.*)$ review_artist.php?page=$1 [PT]
// RewriteRule ^review-artist$ review_artist.php [PT]
Route::any('/review-artist/{page?}', [UserController::class, 'GetReviewArtistPage_Four']);



//file name my_reviews.php


///Clear routes
// RewriteRule ^(.*)-profile-review-song-rating-(.*)-sort-(.*)-(.*)$ my_reviews.php?user_seo=$1&rate=$2&sort=$3&page=$4 [PT]
// RewriteRule ^(.*)-profile-review-song-rating-(.*)-sort-(.*)$ my_reviews.php?user_seo=$1&rate=$2&sort=$3 [PT]
// RewriteRule ^(.*)-profile-review-song-rating-(.*)$ my_reviews.php?user_seo=$1&rate=$2 [PT]
Route::any('/{user_seo}/profile-review-song-rating/{rate}/sort/{sort?}/{page?}', [UserController::class, 'GetMyReviewsPage_One']);
Route::any('/{user_seo}/profile-review-song-rating/{rate}', [UserController::class, 'GetMyReviewsPage_One']);



// RewriteRule ^(.*)-profile-review-song-sort-(.*)-(.*)$ my_reviews.php?user_seo=$1&sort=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-review-song-sort-(.*)$ my_reviews.php?user_seo=$1&sort=$2 [PT]
Route::any('/{user_seo}/profile-review-song-sort/{sort?}/{page?}', [UserController::class, 'GetMyReviewsPage_Two']);


// RewriteRule ^(.*)-profile-review-song-sort-(.*)-(.*)$ my_reviews.php?user_seo=$1&album_seo=$2&artseo=$3 [PT]
Route::any('/{user_seo}/profile-review-song-sort/{album_seo}/{artseo}', [UserController::class, 'GetMyReviewsPage_Three']);

// RewriteRule ^(.*)-profile-review-song-(.*)_(.*)-sort-(.*)-(.*)$ my_reviews.php?user_seo=$1&album_seo=$2&artseo=$3&sort=$4&page=$5 [PT]
// RewriteRule ^(.*)-profile-review-song-(.*)_(.*)-sort-(.*)$ my_reviews.php?user_seo=$1&album_seo=$2&artseo=$3&sort=$4 [PT]
Route::any('/{user_seo}/profile-review-song/{album_seo}/{artseo}/sort/{sort?}/{page?}', [UserController::class, 'GetMyReviewsPage_Three']);


// RewriteRule ^(.*)-profile-review-song-(.*)$ my_reviews.php?user_seo=$1&album_seo=$2 [PT]
// RewriteRule ^(.*)-profile-review-song-(.*)_(.*)_(.*)$ my_reviews.php?user_seo=$1&album_seo=$2&artseo=$3&page=$4 [PT]
// RewriteRule ^(.*)-profile-review-song-(.*)_(.*)$ my_reviews.php?user_seo=$1&album_seo=$2&artseo=$3 [PT]
// RewriteRule ^(.*)-profile-review-song-(.*)-(.*)$ my_reviews.php?user_seo=$1&album_seo=$2&artseo=$3 [PT]
Route::any('/{user_seo}/profile-review-song/{album_seo}/{artseo?}/{page?}', [UserController::class, 'GetMyReviewsPage_Four']);


// RewriteRule ^(.*)-profile-review-songs-(.*)$ my_reviews.php?user_seo=$1&page=$2 [PT]
Route::any('/{user_seo}/profile-review-songs/{page?}', [UserController::class, 'GetMyReviewsPage_Five']);



// RewriteRule ^(.*)-review-songslist-(.*)-sort-(.*)-(.*)$ my_reviews.php?artseo=$1&album_seo=$2&sort=$3&page=$4 [PT]
Route::any('/{artseo}/review-songslist/{album_seo}/sort/{sort}/{page?}', [UserController::class, 'GetMyReviewsPage_Six']);

// RewriteRule ^(.*)-review-songs-(.*)-sort-(.*)$ my_reviews.php?artseo=$1&album_seo=$2&sort=$3 [PT]
Route::any('/{artseo}/review-songs/{album_seo}/sort/{sort}', [UserController::class, 'GetMyReviewsPage_Six']);


// RewriteRule ^(.*)-review-songslist-(.*)-(.*)$ my_reviews.php?artseo=$1&album_seo=$2&page=$3 [PT]
// RewriteRule ^(.*)-review-songs-(.*)$ my_reviews.php?artseo=$1&album_seo=$2 [PT]
Route::any('/{artseo}/review-songslist/{album_seo}/{page?}', [UserController::class, 'GetMyReviewsPage_Seven']);


// RewriteRule ^review-songs-(.*)$ my_reviews.php?album_seo=$1 [PT]
Route::any('/review-songs/{album_seo}', [UserController::class, 'GetMyReviewsPage_Eight']);
Route::any('/{artseo}/review-songs/{album_seo}', [UserController::class, 'GetMyReviewsPage_Eight_One']);


// RewriteRule ^(.*)-profile-review-song$ my_reviews.php?user_seo=$1 [PT]
Route::any('/{user_seo}/profile-review-song', [UserController::class, 'GetMyReviewsPage_Nine']);

// RewriteRule ^review-song-rating-(.*)-sort-(.*)-(.*)$ my_reviews.php?rate=$1&sort=$2&page=$3 [PT]
// RewriteRule ^review-song-rating-(.*)-sort-(.*)$ my_reviews.php?rate=$1&sort=$2 [PT]
Route::any('/review-song-rating/{rate}/sort/{sort}/{page?}', [UserController::class, 'GetMyReviewsPage_Ten']);

// RewriteRule ^review-song-rating-(.*)$ my_reviews.php?rate=$1 [PT]
Route::any('/review-song-rating/{rate}', [UserController::class, 'GetMyReviewsPage_Eleven']);

// RewriteRule ^review-song-ratings-(.*)-(.*)$ my_reviews.php?rate=$1&page=$2 [PT]
Route::any('/review-song-ratings/{rate}/{page?}', [UserController::class, 'GetMyReviewsPage_Eleven']);

// RewriteRule ^review-song-sort-(.*)-(.*)$ my_reviews.php?sort=$1&page=$2 [PT]
// RewriteRule ^review-song-sort-(.*)$ my_reviews.php?sort=$1 [PT]
Route::any('/review-song-sort/{sort}/{page?}', [UserController::class, 'GetMyReviewsPage_Twelve']);

// RewriteRule ^review-song-(.*)$ my_reviews.php?page=$1 [PT] [PT]
// RewriteRule ^review-song$ my_reviews.php [PT]
Route::any('/review-song/{page?}', [UserController::class, 'GetMyReviewsPage_Thirteen']);

// RewriteRule ^(.*)-profile-review-song-ratings-(.*)-(.*)$ my_reviews.php?user_seo=$1&rate=$2&page=$3 [PT]
Route::any('{user_seo}/profile-review-song-ratings/{rate}/{page?}', [UserController::class, 'GetMyReviewsPage_Fourteen']);

// RewriteRule ^(.*)-profile-like-review$ my_account_profile.php?user_seo=$1 [PT]
// RewriteRule ^(.*)-profile-like-review-(.*)$ my_account_profile.php?user_seo=$1&page=$2 [PT]
Route::any('{user_seo}/profile-like-review', [UserController::class, 'GetMyAccountProfile']);




// RewriteRule ^logout$ logout.php [PT]
// RewriteRule ^sign-up$ sign_up.php [PT]
// RewriteRule ^cms/(.*)$ CMS.php?seo_url=$1 [PT]
// RewriteRule ^cms.php/(.*)$ cms.php?seo_url=$1 [PT]
// RewriteRule ^signup_popup/(.*)$ signup_popup.php?seo_url=$1 [PT]
// RewriteRule ^signup_popup.php/(.*)$ signup_popup.php?seo_url=$1 [PT]
// RewriteRule ^change-password$ change_password.php [PT]
Route::any('change-password', [UserController::class, 'ChangePasswordProcess']);
// RewriteRule ^change-username$ edit_username.php [PT]
Route::any('change-username', [UserController::class, 'ChangeUsernameProcess']);
Route::any('update-profile-social-icon', [UserController::class, 'UpdateProfileSocialIcon']);
Route::post('process-update-profile-social-icon', [UserController::class, 'UploadProfileSocialIcon']);
// RewriteRule ^change-picture$ change_picture.php [PT]
Route::any('change-picture', [UserController::class, 'ChangePictureProcess']);
Route::any('delete-user-profile', [UserController::class, 'DeleteUserProfile']);

// RewriteRule ^forgot-password$ forgot_password.php [PT]
// RewriteRule ^maintance$ maintance.php [PT]
// RewriteRule ^reset-password-(.*)$ reset_password.php?code=$1 [PT]
// RewriteRule ^new-password-(.*)$ new_password.php?code=$1 [PT]

///***********************************like_artist


// RewriteRule ^(.*)-profile-like-artist-genres-(.*)-(.*)$ like_artist.php?user_seo=$1&genere_seo=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-like-artist-genre-(.*)$ like_artist.php?user_seo=$1&genere_seo=$2 [PT]


// RewriteRule ^like-artists-(.*)-genre-(.*)$ like_artist.php?genere_seo=$1&alpha=$2 [PT]
// RewriteRule ^like-artists-(.*)-(.*)$ like_artist.php?alpha=$1&page=$2 [PT]
// RewriteRule ^like-artists-(.*)$ like_artist.php?alpha=$1 [PT]
// RewriteRule ^like-artist-genre-(.*)-(.*)$ like_artist.php?genere_seo=$1&page=$2 [PT]
// RewriteRule ^like-artist-genre-(.*)$ like_artist.php?genere_seo=$1 [PT]
// RewriteRule ^(.*)-profile-like-artists-(.*)-genre-(.*)$ like_artist.php?user_seo=$1&genere_seo=$2&alpha=$3 [PT]
// RewriteRule ^(.*)-profile-like-artists-(.*)-genre-(.*)$ like_artist.php?user_seo=$1&genere_seo=$2&alpha=$3 [PT]
Route::any('like-artist-genre-{genere_seo?}', [UserController::class, 'GetLikeArtistsGenre']);


// RewriteRule ^(.*)-profile-like-artists-(.*)-(.*)$ like_artist.php?user_seo=$1&alpha=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-like-artists-(.*)$ like_artist.php?user_seo=$1&alpha=$2 [PT]
// RewriteRule ^(.*)-profile-like-artists-(.*)-(.*)$ like_artist.php?user_seo=$1&alpha=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-like-artists-(.*)$ like_artist.php?user_seo=$1&alpha=$2 [PT]
// RewriteRule ^(.*)-profile-like-artist-(.*)$ like_artist.php?user_seo=$1&page=$2 [PT]
// RewriteRule ^(.*)-profile-like-artist$ like_artist.php?user_seo=$1 [PT]
Route::any('{user_seo}/profile-like-review/{alpha?}', [UserController::class, 'GetProfileLike_One']);
Route::any('{user_seo}/profile-like-artists/{alpha?}', [UserController::class, 'GetProfileLike_One']);
Route::any('{user_seo}/profile-like-artist/{alpha?}', [UserController::class, 'GetProfileLike_One']);


// RewriteRule ^like-artist-(.*)$ like_artist.php?page=$1 [PT]
// RewriteRule ^like-artist$ like_artist.php [PT]
Route::any('like-artist/', [UserController::class, 'LikeArtist']);
Route::any('like-artists-{alpha}/', [UserController::class, 'LikeArtistByAlpha']);



///***************************************likes_profile.php */

// RewriteRule ^(.*)-profile-like-profile-(.*)$ likes_profile.php?user_seo=$1&page=$2 [PT]
// RewriteRule ^(.*)-profile-like-profile$ likes_profile.php?user_seo=$1 [PT]
// RewriteRule ^like-profile-(.*)$ likes_profile.php?page=$1 [PT]
// RewriteRule ^like-profile$ likes_profile.php [PT]
Route::any('{user_seo?}/profile-like-profile/', [UserController::class, 'GetProfileLikesProfile']);
Route::any('like-profile/', [UserController::class, 'GetProfileLikesProfile']);


///***************************************likes_playlist.php */


// RewriteRule ^(.*)-profile-like-playlist-(.*)$ likes_playlist.php?user_seo=$1&page=$2 [PT]
// RewriteRule ^(.*)-profile-like-playlist$ likes_playlist.php?user_seo=$1 [PT]
// RewriteRule ^like-playlist-(.*)$ likes_playlist.php?page=$1 [PT]
// RewriteRule ^like-playlist$ likes_playlist.php [PT]

Route::any('{user_seo?}/profile-like-playlist/', [UserController::class, 'GetProfileLikePlaylist']);
Route::any('like-playlist/', [UserController::class, 'GetProfileLikePlaylist']);



///*******************************************my_discussion.php */

// RewriteRule ^(.*)-profile-discussions-(.*)$ my_discussion.php?user_seo=$1&page=$2 [PT]
// RewriteRule ^(.*)-profile-discussions$ my_discussion.php?user_seo=$1 [PT]
// RewriteRule ^profile-discussions-(.*)$ my_discussion.php?page=$1 [PT]
// RewriteRule ^discussions-(.*)$ my_discussion.php?page=$1 [PT]
// RewriteRule ^discussions$ my_discussion.php [PT]

Route::any('{user_seo?}/profile-discussions/', [UserController::class, 'GetProfileDiscussion']);
Route::any('discussions/', [UserController::class, 'GetProfileDiscussion']);


///********************************************my_playlist.php */
// RewriteRule ^playlists-(.*)_(.*)$ my_playlist.php?seo_playlist=$1&page=$2 [PT]
// RewriteRule ^playlists-(.*)$ my_playlist.php?seo_playlist=$1 [PT]
Route::any('/playlists/{seo_playlist?}', [UserController::class, 'GetProfilePlaylist_1']);

// RewriteRule ^playlists$ my_playlist.php [PT]
Route::any('/playlists', [UserController::class, 'GetProfilePlaylist']);


// RewriteRule ^(.*)-profile-playlists/(.*)_(.*)$ my_playlist.php?user_seo=$1&seo_playlist=$2&page=$3 [PT]
// RewriteRule ^(.*)-profile-playlists/(.*)$ my_playlist.php?user_seo=$1&seo_playlist=$2 [PT]
// RewriteRule ^(.*)-profile-playlists$ my_playlist.php?user_seo=$1 [PT]
Route::any('{user_seo?}/profile-playlists/{seo_playlist?}', [UserController::class, 'GetProfilePlaylist']);


///******************************* my_account.php */
// RewriteRule ^like-review-(.*)$ my_account.php?page=$1 [PT]
// RewriteRule ^like-review$ my_account.php [PT]
Route::any('/like-review', [UserController::class, 'GetLikeReview']);
