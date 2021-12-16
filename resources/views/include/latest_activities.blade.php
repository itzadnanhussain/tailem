<p class="title" style="font-size:18px !important;">Latest Activity</p>
<?php

//define some arrays
error_reporting(0);
$discussion_date_check = '';
$like_date_check  = '';
$like_review_date_check  = '';

if ($review_list_arr_top) {
    $song_list = "select r.review_post_date,s.song_title, s.song_seo,a.artist_seo, s.song_title from tbl_artist_album b, tbl_artists a, tbl_reviews r, tbl_songs s where 1=1 AND s.id = r.song_id AND a.id = r.artist_id AND b.id = r.album_id AND s.id = r.song_id AND r.review_user_id = '" . $user_profile . "' AND s.song_status = 1 order by r.review_id desc limit 5";

    $song_list_arr_data = \App\Models\Songs::GetRawData($song_list);

    if ($song_list_arr_data) {
        foreach ($song_list_arr_data as $song_list_arr) {
            $song_list_arr = (array)$song_list_arr;
            $review_date_check =  date("Y-m-d", $song_list_arr['review_post_date']);
            $review_date_check2 =  date("Y-m-d H:i:s", $song_list_arr['review_post_date']);


            $length_of_username  = strlen($user_name);

            $song_get_name        =   $song_list_arr['song_title'];

            $total_lenth    =    strlen($song_get_name);
            if ($total_lenth > 25) {
                $find  = 25 - $length_of_username;
                $song_get_name    =    substr($song_get_name, 0, $find) . "..";
            }

            $song_get_name    =    stripslashes($song_get_name);

            $messages  = "<a class='user_pnl_col' href='" . SERVER_ROOTPATH . get_user_detail($user_name) . "/profile-review-artist'>$user_name</a> has posted a review on <a class='user_pnl_col' href='" . SERVER_ROOTPATH . Slug($song_list_arr['song_seo']) . "/reviews/" . Slug($song_list_arr['artist_seo']) . "'>$song_get_name</a>";

            $datadataarray[] = array("name" => "review_date_check", "date" => "$review_date_check", "date2" => "$review_date_check2", "messages" => "$messages");
        }
    }
}
if ($comment_list_arr) {
    $c_song_list = "select c.comment_post_date, s.song_title, s.song_seo,a.artist_seo, s.song_title from tbl_artist_album b, tbl_artists a, tbl_comments c, tbl_songs s where 1=1 AND s.id = c.comment_review_id AND a.id = c.comment_artist_id AND b.id = c.comment_album_id  AND c.comment_user_id = '" . $user_profile . "' AND s.song_status = 1  order by c.comment_id desc limit 5";

    $c_song_list_arr_array = \App\Models\Songs::GetRawData($c_song_list);


    if ($c_song_list_arr_array) {
        foreach ($c_song_list_arr_array as $c_song_list_arr) {
            $c_song_list_arr = (array) $c_song_list_arr;
            $discussion_date_check =  date("Y-m-d", $c_song_list_arr['comment_post_date']);

            $discussion_date_check2 =  date("Y-m-d H:i:s", $c_song_list_arr['comment_post_date']);



            $length_of_username  = strlen($user_name);

            $song_get_name        =      $c_song_list_arr['song_title'];
            $total_lenth  = strlen($song_get_name);
            if ($total_lenth > 40) {
                $find  = 40 - $length_of_username;
                $song_get_name    =    substr($song_get_name, 0, $find) . "..";
            }

            $song_get_name    =    stripslashes($song_get_name);

            $messages  = "<a class='user_pnl_col' href='" . SERVER_ROOTPATH . get_user_detail($user_name) . "/profile-review-artist'>$user_name</a>  has posted on <a class='user_pnl_col' href='" . SERVER_ROOTPATH . Slug($c_song_list_arr['song_seo']) . "/reviews/" . Slug($c_song_list_arr['artist_seo']) . "'>$song_get_name</a>";

            $datadataarray[] =    array("name" => "discussion_date_check", "date" => "$discussion_date_check", "date2" => "$discussion_date_check2", "messages" => "$messages");
        }
    }
}


if ($like_list_arr) {
    $like_list_qry_inner = "select l.* from tbl_likes l, tbl_users u where l.like_from_user_id = '" . $user_profile . "' AND u.user_id = l.like_from_user_id AND (l.like_type = 'artist' OR l.like_type = 'album' OR l.like_type = 'profile' OR l.like_type = 'review_song' OR l.like_type = 'review_song' OR l.like_type = 'playlist') order by l.id desc limit 5";

    $like_list_arr_inners = \App\Models\Songs::GetRawData($like_list_qry_inner);

    if ($like_list_arr_inners) {
        foreach ($like_list_arr_inners as $like_list_arr_inner) {
            $like_list_arr_inner = (array)$like_list_arr_inner;
            $like_type = $like_list_arr_inner['like_type'];
            if ($like_type == "artist") {
                $query_info = "select artist_seo, artist_name from tbl_artists where id = '" . $like_list_arr_inner['like_id'] . "'";

                $get_info_arr = \App\Models\Songs::GetRawData($query_info);
                $get_info_arr = (array)$get_info_arr[0];

                $db_title  =  $get_info_arr['artist_name'];
                $db_link  =  $get_info_arr['artist_seo'];
                $date_db  =  strtotime(date($like_list_arr_inner['date']));
                $date_db2  =  strtotime(date($like_list_arr_inner['display_date']));
                $db_link  = SERVER_ROOTPATH . $db_link . "/artist-songs";

                $messages  = "<a class='user_pnl_col' href='" . SERVER_ROOTPATH . get_user_detail($user_name) . "/profile-review-artist'>$user_name</a> likes <a class='user_pnl_col' href='$db_link'>$db_title</a>";

                $like_date_check =  date("Y-m-d", $date_db);
                $like_date_check2 =  date("Y-m-d H:i:s", $date_db2);


                $datadataarray[] =    array("name" => "like_date_check", "date" => "$like_date_check", "date2" => "$like_date_check2", "messages" => "$messages");
            } elseif ($like_type == "profile") {
                $query_info = "select user_name from tbl_users where user_id = '" . $like_list_arr_inner['like_id'] . "'";

                $get_info_arr = \App\Models\Songs::GetRawData($query_info);
                $get_info_arr = (array)$get_info_arr[0];

                $user_name_db  =   $get_info_arr['user_name'];
                $db_title  =   $get_info_arr['user_name'];
                $date_db  =  strtotime(date($like_list_arr_inner['date']));
                $date_db2  =  strtotime(date($like_list_arr_inner['display_date']));
                $db_link  = SERVER_ROOTPATH . get_user_detail($user_name_db) . "/profile-review-artist";
                $messages  = "<a class='user_pnl_col' href='" . SERVER_ROOTPATH . get_user_detail($user_name) . "/profile-review-artist'>$user_name</a> likes <a class='user_pnl_col' href='$db_link'>$db_title</a>";

                $like_date_check =  date("Y-m-d", $date_db);
                $like_date_check2 =  date("Y-m-d H:i:s", $date_db2);


                $datadataarray[] =    array("name" => "like_date_check", "date" => "$like_date_check", "date2" => "$like_date_check2", "messages" => "$messages");
            } elseif ($like_type == "playlist") {
                $query_info = "select u.user_name, p.title_playlist, p.title_playlist_seo from tbl_users u, tbl_user_playlist p where   u.user_id = '" . $like_list_arr_inner['like_receive_user'] . "' AND p.id = '" . $like_list_arr_inner['like_id'] . "' ";


                $get_info_arr = \App\Models\Songs::GetRawData($query_info);
                $get_info_arr = (array)$get_info_arr[0];


                $user_name_db  =   $get_info_arr['user_name'];
                $db_title  =   $get_info_arr['title_playlist'];

                $db_title_playlist_seo  =   $get_info_arr['title_playlist_seo'];

                $date_db      =  strtotime(date($like_list_arr_inner['date']));
                $date_db2  =  strtotime(date($like_list_arr_inner['display_date']));
                $db_link    =  SERVER_ROOTPATH . get_user_detail($user_name_db) . "/profile-review-artist";
                $db_link_playlist  = SERVER_ROOTPATH . get_user_detail($user_name_db) . "-profile-playlists/" . $db_title_playlist_seo;
                $messages  = "<a class='user_pnl_col' href='" . SERVER_ROOTPATH . get_user_detail($user_name) . "/profile-review-artist'>$user_name</a> likes  <a class='user_pnl_col' href='$db_link_playlist'>$db_title</a> playlist by <a class='user_pnl_col' href='$db_link'>$user_name_db</a> ";

                $like_date_check =  date("Y-m-d", $date_db);
                $like_date_check2 =  date("Y-m-d H:i:s", $date_db2);


                $datadataarray[] =    array("name" => "like_date_check", "date" => "$like_date_check", "date2" => "$like_date_check2", "messages" => "$messages");
            } elseif ($like_type == "album") {
                $query_info = "select b.album_seo, b.album_title, a.artist_seo from tbl_artist_album b,  tbl_artists a  where b.id = '" . $like_list_arr_inner['like_id'] . "' AND b.album_artist_id  = a.id";

                $get_info_arr = \App\Models\Songs::GetRawData($query_info);
                $get_info_arr = (array)$get_info_arr[0];

                $db_title  =   $get_info_arr['album_title'];
                $db_artist_seo  =   $get_info_arr['artist_seo'];
                $date_db  =  strtotime(date($like_list_arr_inner['date']));
                $date_db2  =  strtotime(date($like_list_arr_inner['display_date']));
                $db_link  =  $db_artist_seo . "/album/" .  $get_info_arr['album_seo'];
                $db_link  = SERVER_ROOTPATH . $db_link . "/artist-songs";
                $messages  = "<a class='user_pnl_col' href='" . SERVER_ROOTPATH . get_user_detail($user_name) . "/profile-review-artist'>$user_name</a> likes <a class='user_pnl_col' href='$db_link'>$db_title</a>";

                $like_date_check =  date("Y-m-d", $date_db);
                $like_date_check2 =  date("Y-m-d H:i:s", $date_db2);


                $datadataarray[] =    array("name" => "like_date_check", "date" => "$like_date_check", "date2" => "$like_date_check2", "messages" => "$messages");
            }
        }
    }
}


$like_review_query = "select rev.review_user_id, s.song_title,s.song_seo,a.artist_seo, l.date , l.display_date
							from tbl_artist_album b, tbl_artists a, tbl_songs s, tbl_likes l, tbl_reviews rev, tbl_users u 
							where 1=1 
							AND s.id = rev.song_id 
							AND a.id = rev.artist_id 
							AND b.id = rev.album_id 
							AND u.user_id = rev.review_user_id 
							AND l.like_type = 'review_song' 
							AND l.like_id = rev.review_id 
							AND l.like_from_user_id = '" . $user_profile . "' 
							AND s.song_status = 1
							order by l.id desc limit 5";

$review_list_arrs = \App\Models\Songs::GetRawData($like_review_query);

if ($review_list_arrs) {
    foreach ($review_list_arrs as $review_list_arr) {
        $review_list_arr = (array)$review_list_arr;
        $review_user_id  =  $review_list_arr['review_user_id'];

        $user_query = "select user_name
									from tbl_users 
									where 1=1 
									AND user_id = '" . $review_user_id . "'";

        $user_arr = \App\Models\Songs::GetRawDataAdmin($user_query);


        $like_review_date_check =  date("Y-m-d", strtotime(date($review_list_arr['date'])));
        $like_review_date_check2 =  date("Y-m-d H:i:s", strtotime(date($review_list_arr['display_date'])));



        $length_of_username  = strlen($user_name);

        $song_get_name        =    stripslashes($review_list_arr['song_title']);
        $total_lenth  = strlen($song_get_name);
        if ($total_lenth > 20) {
            $find  = 20 - $length_of_username;
            $song_get_name    =    substr($song_get_name, 0, $find) . "..";
        }


        $messages  = "<a class='user_pnl_col' href='" . SERVER_ROOTPATH . get_user_detail($user_name) . "/profile-review-artist'>$user_name</a> likes a review on  <a class='user_pnl_col' href='" . SERVER_ROOTPATH . Slug($review_list_arr['song_seo']) . "/reviews/" . Slug($review_list_arr['artist_seo']) . "'>$song_get_name</a> by <a class='user_pnl_col' href='" . SERVER_ROOTPATH . get_user_detail($user_arr['user_name']) . "/profile-review-artist'>" . substr($user_arr['user_name'], 0, 10) . "</a>";

        $datadataarray[] = array("name" => "like_review_date_check", "date" => "$like_review_date_check", "date2" => "$like_review_date_check2", "messages" => "$messages");
    }
}


$playlist_query = "select p.*, u.user_name, u.user_seo from tbl_user_playlist p, tbl_users u where p.user_id_playlist = '$user_profile' AND u.user_id = p.user_id_playlist order by p.id desc limit 5";

$playlist_list_arrs = \App\Models\Songs::GetRawData($playlist_query);

if ($playlist_list_arrs) {
    foreach ($playlist_list_arrs as $myplaylist_arr) {
        $myplaylist_arr = (array)$myplaylist_arr;
        $title_playlist  =  $myplaylist_arr['title_playlist'];
        $title_playlist_seo  =  $myplaylist_arr['title_playlist_seo'];
        $posted_date   =  $myplaylist_arr['posted_date'];
        $get_username   =  $myplaylist_arr['user_name'];
        $get_user_seo   =  $myplaylist_arr['user_seo'];
        $db_link_playlist  = SERVER_ROOTPATH . $get_user_seo . "-profile-playlists/" . $title_playlist_seo;

        $messages  = "<a class='user_pnl_col' href='" . SERVER_ROOTPATH . $get_user_seo . "/profile-review-artist'>$get_username</a> has created <a class='user_pnl_col' href='" . $db_link_playlist . "'>$title_playlist</a> playlist.";


        $addplaylist_date_check =  date("Y-m-d", strtotime($posted_date));
        $addplaylist_date_check2 =  date("Y-m-d H:i:s", strtotime($posted_date));


        $datadataarray[] =    array("name" => "addplaylist_date_check", "date" => "$addplaylist_date_check", "date2" => "$addplaylist_date_check2", "messages" => "$messages");
    }
}

$playlist_query = "select p.title_playlist, p.title_playlist_seo , u.user_name, u.user_seo, pl.p_date, pl.song_id, pl.artist_id from tbl_user_playlist p, tbl_users u, tbl_user_playlist_songs pl where p.user_id_playlist = '$user_profile' AND u.user_id = p.user_id_playlist AND p.id = pl.playlist_id  order by pl.id desc limit 5";

$playlist_list_arrs = \App\Models\Songs::GetRawData($playlist_query);


if ($playlist_list_arrs) {
    foreach ($playlist_list_arrs as $myplaylist_arr) {
        $myplaylist_arr = (array)$myplaylist_arr;
        $title_playlist  =  $myplaylist_arr['title_playlist'];
        $title_playlist_seo  =  $myplaylist_arr['title_playlist_seo'];
        $posted_date   =  $myplaylist_arr['p_date'];

        $get_song_id   =  $myplaylist_arr['song_id'];
        $get_artist_id   =  $myplaylist_arr['artist_id'];

        $song_info_get  = song_info($get_song_id); // get song info

        $song_name_db    =    stripslashes($song_info_get['song_title']);
        $song_seo_db    =    stripslashes($song_info_get['song_seo']);

        $artist_info_get  = artist_info($get_artist_id); // get artist info

        $get_username   =  $myplaylist_arr['user_name'];
        $get_user_seo   =  $myplaylist_arr['user_seo'];
        $db_link_playlist  = SERVER_ROOTPATH . $get_user_seo . "-profile-playlists/" . $title_playlist_seo;

        $gotosong_url  = SERVER_ROOTPATH . Slug($song_seo_db) . "/reviews/" . Slug($artist_info_get['artist_seo']);

        $messages  = "<a class='user_pnl_col' href='" . SERVER_ROOTPATH . $get_user_seo . "/profile-review-artist'>$get_username</a> has added <a class='user_pnl_col' href='" . $gotosong_url . "'>$song_name_db</a> to <a class='user_pnl_col' href='" . $db_link_playlist . "'>$title_playlist</a> playlist.";


        $addplaylistsong_date_check =  date("Y-m-d", strtotime($posted_date));
        $addplaylistsong_date_check2 =  date("Y-m-d H:i:s", strtotime($posted_date));


        $datadataarray[] =    array("name" => "addplaylistsong_date_check", "date" => "$addplaylistsong_date_check", "date2" => "$addplaylistsong_date_check2", "messages" => "$messages");
    }
}








$data = sortArray($datadataarray, 'date2');
if ($data) {
    $size_arr = sizeof($data);
} else {
    $size_arr = 0;
}



$nn = 0;
foreach ($data as $bd) {
    $bd = (array)$bd;
    $dates[$nn] =  $bd['date'];
    $names[$nn] =  $bd['name'];
    $messages_info[$nn]    =  $bd['messages'];

    $nn++;
}

if ($size_arr > 5) {
    $start_point  = $size_arr - 5;
} else {
    $start_point  = 0;
}

for ($sz = $size_arr - 1; $sz >= $start_point; $sz--) {
    if ($dates[$sz] == '') {
    } else {
        if ($dates[$sz] != '1970-01-01') {
            echo "<p style='text-overflow: ellipsis; width: 100%; overflow: hidden; white-space: nowrap;'>" . date("d M Y", strtotime($dates[$sz])) . " " . $messages_info[$sz] . "</p>";
        }
    }
}

$data = array("$review_date_check", "$discussion_date_check", "$like_date_check", "$like_review_date_check", "$addplaylist_date_check", "$addplaylistsong_date_check");

// $other = usort($data, 'date_compare');
$user_data = GetByWhere('users', array('user_id' => $user_profile));
if ($user_data) {
    $user_date = date('d M Y', strtotime($user_data[0]->created_at));
} else {
    $user_date = date("d M Y", time());
}

///get user profile social icons detail

$facebook_icon = GetByWhere('user_social_profile', array('user_id' => session()->get('user_id'), 'icon_type' => 'Facebook'));
$instagram_icon = GetByWhere('user_social_profile', array('user_id' => session()->get('user_id'), 'icon_type' => 'Instagram'));

$twitter_icon = GetByWhere('user_social_profile', array('user_id' => session()->get('user_id'), 'icon_type' => 'Twitter'));
$profile_id = session()->get('user_id');
 

if ($mobile_view == 0) { ?>
<div class="activity-panel col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0;">
    <p>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding:0;">Member Since<br><a class="heart_color"><?php echo $user_date; ?></a></div>
    <?php
        if ($review_list_arr_top) {
            $query = "select r.review_post_date  from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $user_profile . "' order by r.review_id desc limit 1";

            $info_query = \App\Models\Songs::GetRawData($query);
            $info_query = (array)$info_query[0];

            if ($info_query['review_post_date'] != 0) {
                ?>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding:0;">Latest Review<br><a class="heart_color"><?php echo date("d M Y", $info_query['review_post_date']); ?></a>
    </div>
    <?php
            }
        }

        if ($comment_list_arr) {
            $query = "select comment_post_date from tbl_comments where comment_user_id = '" . $user_profile . "' order by comment_id desc limit 1";
            $info_q_arr = \App\Models\Songs::GetRawData($query);

            $info_q_arr = (array)$info_q_arr[0];

            if ($info_q_arr['comment_post_date'] != '') {
                ?>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding:0;">Latest Post<br><a class="heart_color"><?php echo date("d M Y", $info_q_arr['comment_post_date']); ?></a>
    </div>
    <?php
            }
        }
        ?>
    </p>
</div>
<!-- new code by ad -->
<style>
    .ad-follow-icon-box {
        padding-left: 0px;
    }

    .bottom_nav .li label {
        color: #d73b3b;
    }
</style>
<?php
$social_icons = GetByWhere('social_icons');
 
    ?>
<div class="col-lg-12 col-md-12 col-sm-12 ad-follow-icon-box">
    <ul class="bottom_nav">

        <li class="li"><label>Follow me on: </label></li>

        <!-- Facebook icon -->

        <li><a href="<?php echo $facebook_icon[0]->social_link ?>"
                target="_blank"><img class="sprite-icon_fb"
                    src="<?php echo SERVER_ROOTPATH . $social_icons[0]->large_screen_icon ?>"
                    alt=""></a>
        </li>


        <!-- Twitter icon -->

        <li><a href="<?php echo $twitter_icon[0]->social_link ?>"
                target="_blank"><img class="sprite-icon_tw"
                    src="<?php echo SERVER_ROOTPATH . $social_icons[2]->large_screen_icon ?>"
                    alt=""></a>
        </li>


        <!-- Instagram icon -->
        <li><a href="<?php echo $instagram_icon[0]->social_link ?>"
                target="_blank"> <img
                    src="<?php echo SERVER_ROOTPATH . $social_icons[5]->large_screen_icon ?>"
                    width="34" alt="">
            </a>
        </li>

    </ul>

</div>

<?php
} elseif ($mobile_view == 1) { ?>
<div class="activity-panel col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0;">
    <p>
        <?php
            if ($review_list_arr_top) {
                $query = "select r.review_post_date  from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $user_profile . "' order by r.review_id desc limit 1";

                $info_query = \App\Models\Songs::GetRawData($query);
                $info_query = (array)$info_query[0];

                if ($info_query['review_post_date'] != 0) {
                    ?>
    <div class="col-sm-6 col-xs-6" style="padding:0;">Latest Review<br><a class="heart_color"><?php echo date("d M Y", $info_query['review_post_date']); ?></a>
    </div>
    <?php
                }
            }

            if ($comment_list_arr) {
                $query = "select comment_post_date from tbl_comments where comment_user_id = '" . $user_profile . "' order by comment_id desc limit 1";

                $info_q_arr = \App\Models\Songs::GetRawData($query);
                $info_q_arr = (array)$info_q_arr[0];

                if ($info_q_arr['comment_post_date'] != '') {
                    ?>
    <div class="col-sm-6 col-xs-6" style="padding:0; text-align:right;">Latest Post<br><a class="heart_color"><?php echo date("d M Y", $info_q_arr['comment_post_date']); ?></a>
    </div>
    <?php
                }
            }
?>
    </p>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 ad-follow-icon-box">
    <ul class="bottom_nav">

        <li><label>Follow me on: </label></li>
        <!-- Facebook icon -->
        <li><a href="<?php echo $facebook_icon[0]->social_link ?>"
                target="_blank"><img class="sprite-icon_fb"
                    src="<?php echo SERVER_ROOTPATH . $social_icons[0]->large_screen_icon ?>"
                    alt=""></a></li>


        <!-- Twitter icon -->
        <li><a href="<?php echo $twitter_icon[0]->social_link ?>"
                target="_blank"><img class="sprite-icon_tw"
                    src="<?php echo SERVER_ROOTPATH . $social_icons[2]->large_screen_icon ?>"
                    alt=""></a></li>


        <!-- Instagram icon -->
        <li><a href="<?php echo $instagram_icon[0]->social_link ?>"
                target="_blank"> <img
                    src="<?php echo SERVER_ROOTPATH . $social_icons[5]->large_screen_icon ?>"
                    width="34" alt=""></a></li>


    </ul>

</div>
<?php }
