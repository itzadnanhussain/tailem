<?php

use App\Http\Controllers\ProcessController; 
use Illuminate\Support\Facades\Route; 
 

 

///process/add_playlist_process
Route::post('process/add_playlist_process',[ProcessController::class, 'AddPlaylistProcess']) 
->name('process/add_playlist_process.AddPlaylistProcess');
 
///add_songto_playlist_process
Route::post('process/add_songto_playlist_process',[ProcessController::class, 'AddSongToPlayList']) 
->name('process/add_songto_playlist_process.AddSongToPlayList');
 
///write a review process
Route::post('process/write_a_review',[ProcessController::class, 'WriteReview']) 
->name('process/write_a_review.WriteReview');


///write a review process
Route::post('process/reviews_artist_popular_likes',[ProcessController::class, 'ReviewsArtistPopularLikes']);


///favourite_like_sub_artist2s
Route::post('process/favourite_like_sub_artist2',[ProcessController::class, 'FavouriteLikeSubArtist2']);


///favourite_like_sub_artist_popular_latest
Route::post('process/favourite_like_sub_artist_popular_latest',[ProcessController::class, 'FavouriteLikeSubArtistPopularLatest']);


///favourite_like_sub_artist_popular
Route::post('process/favourite_like_sub_artist_popular',[ProcessController::class, 'FavouriteLikeSubArtistPopular']);


///favourite_like_review_song
Route::post('process/favourite_like_review_song',[ProcessController::class, 'FavouriteLikeReviewSong']);


///favourite_like_review
Route::post('process/favourite_like_review',[ProcessController::class, 'FavouriteLikeReview']);


///like_artist_recent_reviews
Route::post('process/like_artist_recent_reviews',[ProcessController::class, 'likeArtistRecentReviews']);


///favourite_like_sub
Route::post('process/favourite_like_sub',[ProcessController::class, 'FavouriteLikeSub']);


///detail_review
Route::get('process/detail_review',[ProcessController::class, 'DetailReview']);


///like detail
Route::get('like/detail',[ProcessController::class, 'GetLikeDetail']) 
->name('like/detail.GetLikeDetail');

///discussion_process
Route::post('process/discussion_process' , [ProcessController::class , 'Discussion']);

///detail_cms
Route::get('process/detail_cms' , [ProcessController::class , 'DetailCMS']);
 
 
 
 












 