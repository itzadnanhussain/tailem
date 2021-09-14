<?php

use App\Http\Controllers\ArtistController;
use Illuminate\Support\Facades\Route;

///page is artist_page

// RewriteRule ^(.*)/artist-songs-(.*)$ artist_page.php?artist_seo=$1&page=$2 [PT]
// RewriteRule ^(.*)/artist-songs$ artist_page.php?artist_seo=$1 [PT]
// RewriteRule ^(.*)-artist.html$ artist_page.php?artist_seo=$1 [PT]

// RewriteRule ^(.*)-artist-sort-(.*)-(.*)$ artist_page.php?artist_seo=$1&sort=$2&page=$3 [PT]
// RewriteRule ^(.*)-artist-sort-(.*)$ artist_page.php?artist_seo=$1&sort=$2 [PT]

Route::get('/{artist_seo}/artist-songs/{sort?}/{page?}',[ArtistController::class , 'GetArtistSongs']); 
 