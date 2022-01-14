<?php

use App\Http\Controllers\ProcessController;
use Illuminate\Support\Facades\Route;

///process/add_playlist_process
Route::post('process/add_playlist_process', [ProcessController::class, 'AddPlaylistProcess'])
->name('process/add_playlist_process.AddPlaylistProcess');
 
///add_songto_playlist_process
Route::post('process/add_songto_playlist_process', [ProcessController::class, 'AddSongToPlayList'])
->name('process/add_songto_playlist_process.AddSongToPlayList');
 
///write a review process
Route::post('process/write_a_review', [ProcessController::class, 'WriteReview'])
->name('process/write_a_review.WriteReview');

///write a review update process
Route::post('process/delete_review_process', [ProcessController::class, 'DeleteReview']);


///write a review process
Route::post('process/reviews_artist_popular_likes', [ProcessController::class, 'ReviewsArtistPopularLikes']);


///favourite_like
Route::post('process/favourite_like', [ProcessController::class, 'FavouriteLike']);


///favourite_userprofile_likes_main_list
Route::any('process/favourite_userprofile_likes_main_list', [ProcessController::class, 'FavouriteUserProfileLikesMainList']);


///favourite_like_sub_artist2s
Route::post('process/favourite_like_sub_artist2', [ProcessController::class, 'FavouriteLikeSubArtist2']);


///favourite_like_sub_artist_pop
Route::post('process/favourite_like_sub_artist_pop', [ProcessController::class, 'FavouriteLikeSubArtistPop']);


///favourite_like_sub_artist_popular_latest
Route::post('process/favourite_like_sub_artist_popular_latest', [ProcessController::class, 'FavouriteLikeSubArtistPopularLatest']);


///favourite_like_sub_artist_popular
Route::post('process/favourite_like_sub_artist_popular', [ProcessController::class, 'FavouriteLikeSubArtistPopular']);



///favourite_like_review_song_detail/detail.php
Route::post('process/favourite_like_review_song_like_detail', [ProcessController::class, 'favourite_like_review_song_detail']);


///favourite_like_review_song
Route::post('process/favourite_like_review_song', [ProcessController::class, 'FavouriteLikeReviewSong']);


///popfavourite_userprofile_likes
Route::any('process/popfavourite_userprofile_likes', [ProcessController::class, 'pop_favourite_userprofile_likes']);


///favourite_like_review
Route::post('process/favourite_like_review', [ProcessController::class, 'FavouriteLikeReview']);


///favourite_userprofile_likes_page
Route::any('process/favourite_userprofile_likes_page', [ProcessController::class, 'favourite_userprofile_likes_page']);


///like_artist_recent_reviews
Route::post('process/like_artist_recent_reviews', [ProcessController::class, 'likeArtistRecentReviews']);

///favourite_like_review_screen
Route::post('process/favourite_like_review_screen', [ProcessController::class, 'FavouriteLikeReviewScreen']);


///favourite_like_sub
Route::post('process/favourite_like_sub', [ProcessController::class, 'FavouriteLikeSub']);

///process/favourite_userprofile_mainlikes
Route::any('process/favourite_userprofile_mainlikes', [ProcessController::class, 'favourite_userprofile_mainlikes']);

///process/favourite_userprofile_mainlikes
Route::any('process/favourite_userprofile_likes_discussion', [ProcessController::class, 'favourite_userprofile_likes_discussion']);


///detail_review
Route::get('process/detail_review', [ProcessController::class, 'DetailReview']);

 
///detail_profile
Route::get('process/detail_profile', [ProcessController::class, 'DetailProfile']);


///like detail
Route::get('like/detail', [ProcessController::class, 'GetLikeDetail'])
->name('like/detail.GetLikeDetail');

///discussion_process
Route::post('process/discussion_process', [ProcessController::class , 'Discussion']);


///process/dbmanupulate
Route::post('process/dbmanupulate', [ProcessController::class , 'DM_Manipulate']);

///detail_cms
Route::get('process/detail_cms', [ProcessController::class , 'DetailCMS']);
Route::get('signup_popup/{seo_url}', [ProcessController::class , 'DetailCMS_One']);
 

///change_picture_process
Route::post('process/change_picture_process', [ProcessController::class , 'ChangeProfilePicture']);


///change_picture_process
Route::post('process/change_pass_process', [ProcessController::class , 'ChangeProfilePassword']);


///change_username_process
Route::post('process/change_username_process', [ProcessController::class , 'ChangeUserName']);


///forgot_process
Route::post('process/forgot_process', [ProcessController::class , 'PasswordForgot']);


///process/report_process
Route::post('process/report_process', [ProcessController::class , 'ReportProcess']);


///process/notification_display
Route::post('process/notification_display', [ProcessController::class , 'notification_display']);

///process/delete_notification
Route::any('process/delete_notification', [ProcessController::class , 'delete_notification']);


///process/update_notification_click
Route::post('process/update_notification_click', [ProcessController::class , 'update_notification_click']);


///process/favourite_playlist
Route::post('process/favourite_playlist', [ProcessController::class , 'favourite_playlist']);


///detail_playlist
Route::any('detail_playlist', [ProcessController::class , 'detail_playlist']);


///edit_comment
Route::any('edit_comment', [ProcessController::class , 'edit_comment']);
// Route::any('process/discussion_update_process', [ProcessController::class , 'discussion_update_process']);
Route::any('process/discussion_update_process_test', [ProcessController::class , 'discussion_update_process']);


///delete comment
Route::any('delete_comment', [ProcessController::class , 'delete_comment']);
Route::any('process/delete_comment_process', [ProcessController::class , 'delete_comment_process']);

///delete_playlist
Route::any('delete_playlist', [ProcessController::class , 'delete_playlist']);
Route::any('process/delete_playlist_process', [ProcessController::class , 'delete_playlist_process']);

///update_playlist
Route::any('update_playlist', [ProcessController::class , 'update_playlist']);
Route::any('process/update_playlist_process', [ProcessController::class , 'update_playlist_process']);

///favourite_userprofile_screenlikes
Route::any('process/favourite_userprofile_screenlikes', [ProcessController::class , 'favourite_userprofile_screenlikes']);
