<?php

use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

///song_local_detail.php
// RewriteRule ^(.*)-write-a-review-(.*)-sort-(.*)$ song_local_detail.php?song_seo=$1&artist_seo=$2&sort=$3 [PT]
// RewriteRule ^(.*)-write-a-review-(.*)$ song_local_detail.php?song_seo=$1&artist_seo=$2 [PT]
Route::get('/{song_seo}/write-a-review/{artist_seo}/{sort?}',[ReviewController::class , 'SongWriteReview']);
 