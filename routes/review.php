<?php

use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

///song_local_like/detail
// RewriteRule ^(.*)/write-a-review/(.*)-sort-(.*)$ song_local_like/detail?song_seo=$1&artist_seo=$2&sort=$3 [PT]
// RewriteRule ^(.*)/write-a-review/(.*)$ song_local_like/detail?song_seo=$1&artist_seo=$2 [PT]
Route::get('/{song_seo}/write-a-review/{artist_seo}/{sort?}',[ReviewController::class , 'SongWriteReview']);
 


///report.php
Route::get('/report/{rev_id?}/{num?}' , [ReviewController::class , 'GetReport']);


///Review_Edit
Route::get('/edit_review' , [ReviewController::class , 'Review_Edit']);
 

///Review_Delete
Route::get('/delete_review' , [ReviewController::class , 'Review_Delete']);
 
 