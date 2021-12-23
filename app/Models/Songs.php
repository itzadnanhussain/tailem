<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Songs extends Model
{
    use HasFactory;

    ///GetArtistListArray
    public static function GetArtistListArray()
    {
        // $joins = array("one" => "'songs_artist_album', 'songs_artist_album.song_id', '=', 'songs.id'");
        $result = DB::table('songs')
            ->join('songs_artist_album', 'songs_artist_album.song_id', '=', 'songs.id')
            ->join('artist_album', 'artist_album.id', '=', 'songs_artist_album.album_id')
            ->select(
                'songs.song_seo',
                'songs.song_title',
                'songs.rate_song',
                'songs.picture',
                'songs.id',
                'songs_artist_album.artist_id',
                'songs_artist_album.album_id',
                'songs_artist_album.song_id',
                'artist_album.album_picture',
                'artist_album.id',
                'artist_album.album_title'
            )
            ->where([
                ['songs.popularity', '=', 1],
                ['songs_artist_album.display_status', '=', 1],
            ])
            ->groupBy('songs.id')
            ->orderBy('songs.id', 'DESC')
            ->limit(4)
            ->get()->toArray();





        return $result;
    }

    ///GetArtistListArray
    public static function GetArtistListArray_2()
    {
        $result = DB::table('songs as s')
            ->join('songs_artist_album as saa', 'saa.song_id', '=', 's.id')
            ->join('artist_album as b', 'b.id', '=', 'saa.album_id')
            ->join('artists as a', 'saa.artist_id', '=', 'a.id')
            ->select(
                'saa.artist_id',
                's.song_title',
                's.song_seo',
                's.updated_by_itunes',
                's.picture',
                's.id',
                'b.album_title',
                'b.album_picture',
                'a.artist_seo',
                'a.artist_name',
            )
            ->where([
                ['saa.display_status', '=', 1],
                ['s.song_status', '=', 1],
                ['s.ranking_order', '>', 0],
            ])
            ->groupBy('s.id')
            ->orderBy('s.ranking_order', 'desc')
            ->limit(10)
            ->get()->toArray();
        return $result;
    }

    ///GetRawQuery
    public static function GetRawQuery($table, $expression, $where = array())
    {
        $res = DB::table($table)
            ->select(DB::raw($expression))
            ->where($where)
            // ->groupBy('status')
            ->get()->toArray();

        return $res;
    }


    ///GetRawData
    public static function GetRawData($expression, $where = array())
    {
        $results = DB::select(DB::raw($expression), $where);
 
        return $results;
    }
    ///GetRawDataAdmin
    public static function GetRawDataAdmin($expression, $where = array())
    {
        $results = array();
        $results = DB::select(DB::raw($expression), $where);
        if ($results) {
            $results = (array)$results[0];
        }

        return $results ;
    }

    ///GetFeatureArr
    public static function GetFeatureArr($id)
    {
        $result = DB::table('featured_artist_assocs as f')
            ->join('artists as a', 'a.id', '=', 'f.featured_artist')
            ->select('a.artist_seo as f_artist_seo', 'a.artist_name as feature_artist', 'a.id as feature_artist_id')
            ->where([
                ['f.song_id', '=', $id],
            ])
            ->get()->toArray();
        return $result;
    }

    ///GetLatestSongsArray
    public static function GetLatestSongsArray()
    {
        ///Query
        $latest_songs = DB::table('latest_songs as s')
            ->select(
                's.id as songid',
                's.song_title',
                's.picture',
                's.rate_song',
                's.song_seo'
            )
            ->where([
                ['s.latest', '=', '1'],
            ])
            // ->groupBy('s.id')
            ->orderBy('s.timeupdated', 'desc')
            ->limit(10)
            ->get()->toArray();
        return $latest_songs;
    }


    ///GetOtherDetails
    public static function GetOtherDetails($song_id)
    {
        $result = DB::table('artist_album as b')
            ->join('songs_artist_album as saa', 'b.id', '=', 'saa.album_id')
            ->join('artists as a', 'a.id', '=', 'saa.artist_id')
            ->select('b.album_artist_id', 'b.album_title', 'b.album_picture', 'a.id as artist_id', 'a.artist_seo', 'a.artist_name')
            ->where([
                ['saa.song_id', '=', $song_id],
            ])
            ->get()->toArray();
        return $result;
    }

    ///artist_list top songs page
    public function artist_list()
    {

        ///Query
        $users = DB::table('songs as s')
            ->join('songs_artist_album as saa', 'saa.song_id', '=', 's.id')
            ->join('artist_album as b', 'saa.album_id', '=', 'b.id')
            ->join('artists as a', 'saa.artist_id', '=', 'a.id')
            ->select('s.song_title', 'saa.*', 'b.*', 'a.*')
            ->where([
                ['saa.display_status', '=', '1'],
                ['s.song_status', '=', '1'],
                ['s.ranking_order', '>', '0'],
            ])
            // ->groupBy('s.id')
            ->orderBy('s.timeupdated', 'asc')
            ->limit(50)
            ->get()->toArray();
        return $users;
    }


    ///test view function
    public function review_list_arr_top($id)
    {
        ///Query
        $count_review = DB::table('users as u')
            ->join('reviews as r', 'r.review_user_id', '=', 'u.id')
            ->select('u.*', 'r.*')
            ->where([
                ['r.song_id', '=', $id],
            ])->count();
        //   ->get()->toArray();
        return $count_review;
    }


    ///discussion_list_arr
    public function discussion_list_arr($id)
    {
        ///Query
        $result = DB::table('users as u')
            ->join('comments as c', 'c.comment_user_id', '=', 'u.id')
            ->select('u.*', 'c.*')
            ->where([
                ['c.comment_review_id', '=', $id],
            ])
            ->orderBy('c.comment_id', 'desc')
            ->get()->toArray();
        return $result;
    }


    ///main_counter
    public function main_counter($id)
    {
        $result = DB::table('likes')
            ->select('id')
            ->where(
                ['like_type' => 'artist'],
                ['like_id' => $id]
            )
            ->count();
        return $result;
    }


    ///qry_feature_arr
    public function qry_feature_arr($id)
    {
        $qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from featured_artist_assocs f, artists a where a.id = f.featured_artist AND f.song_id = '" . $id . "'";

        $result = DB::table('artists as a')
            ->join('featured_artist_assocs as f', 'a.id', '=', 'f.featured_artist')
            ->select('a.artist_seo as f_artist_seo,a.artist_name as feature_artist,a.id as feature_artist_id', 'f.phone')
            ->where([
                ['f.song_id', '=', $id],
            ])
            ->get();

        return $result;
    }


    ///sum_rate
    public static function sum_rate($id)
    {
        $where = array('song_id' => $id, 'status' => '1');
        $result = DB::table('reviews')
            ->select('*')
            ->where($where)
            ->sum('review_rating');
        return $result;
    }


    ///count_rate
    public function count_rate($id)
    {
        $where = array('song_id' => $id, 'status' => '1');
        $result = DB::table('reviews')
            ->select('*')
            ->where($where)
            ->count('*');
        return $result;
    }
}
