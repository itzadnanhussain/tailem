@include("common.header")
<?php
$USER_NAME = ucfirst($user_name);
// $request_url_check	=	str_replace("/", '', $_SERVER['REQUEST_URI']); 
error_reporting(0);



function get_artist_id($artistseo)
{

    $artist_list = "Select id from tbl_artists where artist_seo = '$artistseo'";
    $artist_list_arr    =   \App\Models\Songs::GetRawData($artist_list);
    $artist_id        =    $artist_list_arr[0]->id;
    return $artist_id;
}

function get_album_id($albumseo, $artid)
{

    $artist_list = "Select id from tbl_artist_album where album_seo = '$albumseo' AND  `album_artist_id` = '$artid' AND album_status = 1";

    $artist_list_arr    =   \App\Models\Songs::GetRawData($artist_list);
    $album_id        =    $artist_list_arr[0]->id;
    return $album_id;
}

function get_listof_songs($artist_seo, $album_seo)
{

    $artist_id    =    get_artist_id($artist_seo);
    $album_id    =    get_album_id($album_seo, $artist_id);
    $info    =    $artist_id . " " . $album_id;
    $list_arr['artist_id']    =    $artist_id;
    $list_arr['album_id']    =    $album_id;

    return  $list_arr;
}

function get_listof_songs_ids($album_id, $artid)
{

    $artist_list = "select b.album_title, b.album_seo, saa.song_id, saa.artist_id from tbl_songs_artist_album saa, tbl_artist_album b where saa.album_id = b.id AND saa.artist_id = '$artid' AND saa.album_id = '$album_id' AND saa.display_status = 1 ";


    $artist_list_arr    =   \App\Models\Songs::GetRawData($artist_list);
    if ($artist_list_arr) {
        $total_result    =    count($artist_list_arr);
    } else {
        $total_result = 0;
    }
    $u = 1;
    $list  = '';
    if ($artist_list_arr) {

        foreach ($artist_list_arr as $arr) {
            $arr = (array)$arr;
            if ($u == $total_result) {
                $list .=  $arr['song_id'];
            } else {
                $list .=  $arr['song_id'] . ", ";
            }
            $u++;
        }
    }


    return $list;
}



$fff    =    get_listof_songs($artseo, $album_seo);

$fetch_art_id    =    $fff['artist_id'];
$fetch_alb_id    =    $fff['album_id'];

$listof_ids  =    get_listof_songs_ids($fetch_alb_id, $fetch_art_id);
?>
<script type="text/javascript">
    function sort_area(val, user, rateing) {

        if (user != "") {
            user = user + "/profile-";
        }

        if (rateing != "") {
            rateing = "-rating-" + rateing;
        }

        window.location.href = "<?php echo SERVER_ROOTPATH ?>" + user + "review-song" + rateing + "-sort-" + val;

    }

    function sort_area_2(val, user, artist, album) {

        if (user != "") {
            jumpto = "<?php echo SERVER_ROOTPATH ?>" + user + "-profile-review-song-" + album + "_" + artist + "-sort-" + val;
        } else {
            jumpto = "<?php echo SERVER_ROOTPATH ?>" + artist + "-review-songs-" + album + "-sort-" + val;
        }
        window.location.href = jumpto;

    }
</script>
<style>
    a.under_line {
        text-decoration: none !important;
    }

    a.under_line:hover {
        text-decoration: underline !important;
    }

    .album_details label>span,
    .album_details p>span {
        width: 100%;
    }
</style>
<!-- ./Header end -->
<!-- Middle Section -->

<section class="middle_sec">
    <div class="topRwHead-bodyPan">
        <div class="container pad_zero">
            <div class="topRwHead-panel" style="margin:12px 0 !important; padding-bottom:0; padding-top:10px;">

                <?php

                if ($mobile_view == 0) { ?>

                    <div class="col-lg-12 col-md-12" style="margin-bottom:0; padding-right:0;">
                        @include("common.my_account_image")
                        <div class="activity-panel">
                            @include("include.review_activities")

                        </div>
                        @include("include.latest_activities")

                        <div class="clearfix"></div>



                    </div>
                    <div class="col-lg-4 col-md-4 review_ipad">
                        <div class="col-sm-12 review_arts" style="padding:2px;">
                            @include("include.right_reviews")
                        </div>
                    </div>

            </div>
        </div>


        @include("common.ipad_data")
    <?php
                } elseif ($mobile_view == 1) { ?>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @include("common.my_account_image")
        </div>
        <div style="clear:both;"></div>
        <div class="col-sm-12 desc-panel pad_right">
            <div class="activity-panel">
                @include("include.review_activities")
            </div>
            <?php //include("include/latest_activities.php");
            ?>
        </div>

        <div class="col-lg-4 col-md-4">
            <div class="col-sm-12 review_arts" style="padding:2px;">
                @include("include.right_reviews")
            </div>
        </div>

    <?php } ?>


    <div class="clearfix"></div>
    </div>
    <?php if ($main_link != "") { ?>
        <!-- Advertisement Banner Start-->
        <div class="container" style="padding-bottom:10px;">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <?php echo ads_info('Top'); ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
            </div>
        </div>
        <!--Advertisement Banner End-->
    <?php } ?>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div style="background-color:#FFFFFF; padding:10px; margin-bottom:0px;" class="brows-label-penel">
                @include("include.artist_review_like_menu")
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px; margin-top:10px;">
                    <?php

                    if ($currentFile == "my_playlist.php") {


                        if ($seo_playlist != '') {
                            $pick_playlist = get_playlist_info($user_profile, $seo_playlist);
                            $pick_playlist = (array)$pick_playlist[0];
                            echo "<b style='margin-top: 5px; color: rgb(0, 0, 0); font-weight: bold; font-size:18px;'>&nbsp;" . stripslashes($pick_playlist['title_playlist']) . "</b>";
                            if ($user_profile == $pick_playlist['user_id_playlist']) {
                                if ($user_id == $user_profile) {
                                    if ($user_seo != '') {
                                        $newparameter  = "&p=y";
                                    } else {
                                        $newparameter  = "";
                                    }
                    ?>
                                    <span style="margin-right:20px;"></span>
                                    <a data-title="" data-target="#create_playlist" data-dismiss="modal" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>update_playlist.php?song_id=<?php echo $pick_playlist['song_id']; ?>&art_id=<?php echo $pick_playlist['artist_id']; ?>&edit_id=<?php echo $pick_playlist['id'] . $newparameter; ?>" style="font-weight:normal;">Edit</a>
                            <?php
                                }
                            }

                            ?>
                            <span style="margin-right:20px;"></span>
                            <?php
                            $qry = "select id from tbl_likes where like_type = 'playlist' AND like_id = '" . $pick_playlist['id'] . "'";
                            $counter_main_playlist = array();
                            $counter_main_playlist = \App\Models\Songs::GetRawData($qry);
                            if ($counter_main_playlist) {
                                $counter_main_playlist = count($counter_main_playlist);
                            } else {
                                $counter_main_playlist = 0;
                            }
                            if ($user_id != "") {

                                $counter = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'playlist' AND like_id = '" . $pick_playlist['id'] . "'";
                                $counter = array();
                                $counter = \App\Models\Songs::GetRawData($qry);
                                if ($counter) {
                                    $counter = count($counter);
                                } else {
                                    $counter = 0;
                                }
                                if ($counter == 0) {
                            ?>
                                    <span style="overflow:visible;" id="show_playlist_likes_<?php echo $pick_playlist['id']; ?>"><a href="javascript:;" onClick="add_in_playlist('<?php echo $pick_playlist['id']; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span><?php echo $counter_main_playlist; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail_playlist.php?artist=<?php echo $pick_playlist['id']; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main_playlist < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                    <span style="overflow:visible;" id="myStyle_profile_<?php echo $pick_playlist['id']; ?>"></span>

                                <?php
                                } else {
                                ?>
                                    <span style="overflow:visible;" id="show_playlist_likes_<?php echo $pick_playlist['id']; ?>"><a href="javascript:;" onClick="add_in_playlist('<?php echo $pick_playlist['id']; ?>')"><i class="fa fa-heart heart_color heart_size"></i></a>&nbsp;<span><?php echo $counter_main_playlist; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail_playlist.php?artist=<?php echo $pick_playlist['id']; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main_playlist < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                    <span style="overflow:visible;" id="myStyle_profile_<?php echo $pick_playlist['id']; ?>"></span>
                                <?php
                                }
                            } else {
                                ?>
                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $pick_playlist['id']; ?>">
                                    <?php
                                    if ($user_id == "") {
                                    ?>
                                        <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="javascript:;" onClick="add_in_playlist('<?php echo $pick_playlist['id']; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                    <?php
                                    }
                                    ?>
                                    <span><?php echo $counter_main_playlist; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail_playlist.php?artist=<?php echo $pick_playlist['id']; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main_playlist < 2) {
                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                <span style="overflow:visible;" id="myStyle_profile_<?php echo $pick_playlist['id']; ?>"></span>


                            <?php
                            }

                            ?>
                            <span style="margin-right:20px;"></span>
                            <?php

                            $db_title_playlist   = urlencode(stripslashes($pick_playlist['title_playlist']));
                            $playlist_summary     = urlencode("View list of favourite playlist.");
                            $playlist_url    = urlencode(SERVER_ROOTPATH . get_user_detail($USER_NAME) . "-profile-playlists-" . $seo_playlist);


                            if ($user_seo != '') {
                            ?>
                                <a onClick="popupWindow('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $db_title_playlist; ?>&amp;p[summary]=<?php echo $playlist_summary; ?>&amp;p[url]=<?php echo $playlist_url; ?>', 'sharer', 'toolbar=0,status=0,width=620,height=280');" href="javascript: void(0)"><img src="<?php echo SERVER_ROOTPATH; ?>images/icon_fb.png" width="20"></a>

                                &nbsp;

                                <a href="javascript: popupWindow('http://twitter.com/share?url=<?php echo $playlist_url; ?>&source=<?php echo mysqli_real_escape_string($db_title_playlist); ?>&text=<?php echo mysqli_real_escape_string($playlist_summary); ?>')"><img src="<?php echo SERVER_ROOTPATH; ?>images/tww.png" width="20"></a>


                                &nbsp;
                                <a class="footer__shareoption__google" href="https://plusone.google.com/_/+1/confirm?hl=Hello&amp;url=<?php echo $playlist_url; ?>&amp;title=<?php echo mysqli_real_escape_string($db_title_playlist); ?>" target="blank" title=""><img src="<?php echo SERVER_ROOTPATH; ?>images/gplus.png" width="20"></a>

                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="topsonglistsec" style="padding-top:0; background-color:#F6F6F6;">

        <div class="container tablet-view" style="padding:0;">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <ul class="songlistings" style=" border:1px solid #ccc;">
                        <?php
                        //============================================================
                        //PAGGING CODE STARTS HERE

                        $artist_list_arr = array();

                        if (empty($artist_list_arr)) {
                            $artist_list = "select a.id as artist_iddb,s.picture,s.song_title,s.song_seo,a.artist_seo,a.artist_name, s.id as songid, p.title_playlist, p.id as playlistid, p.user_id_playlist
							from tbl_artists a, tbl_songs s, tbl_user_playlist p, tbl_user_playlist_songs pls 
							where 1=1 
							AND pls.song_id = s.id 
							AND pls.user_id = '" . $user_profile . "' 
							AND p.title_playlist_seo  = '" . $seo_playlist . "' 
							AND a.id  = pls.artist_id
							AND pls.playlist_id = p.id 
							AND s.song_status = 1
							group by pls.song_id
							order by pls.id desc LIMIT 50
							";

                            $artist_list_arr    =    \App\Models\Songs::GetRawData($artist_list);;
                            if ($artist_list_arr) {
                                $total_pages = count($artist_list_arr);
                            } else {
                                $total_pages = 0;
                            }
                        }

                        if ($user_seo != '') {
                            $goto_url    =    $user_seo . "-profile-playlists-" . $_REQUEST['seo_playlist'];
                        } else {
                            $goto_url    =    "playlists-" . $_REQUEST['seo_playlist'];
                        }

                        $targetpage = SERVER_ROOTPATH . $goto_url; //your file name  (the name of this file)


                        $limit = 10;                     //how many items to show per page 

                        if ($page)
                            $start = ($page - 1) * $limit; //first item to display on this page
                        else
                            $start = 0;                    //if no page var is given, set start to 0
                        //PAGGING CODE ENDS HERE	
                        //============================================================

                        if (isset($page) && $page != "") {
                            $sr_no = ($page * $limit) - $limit;
                        } else {
                            $sr_no = 0;
                        }

                        $c = 1;

                        $artist_list_arr = array_slice($artist_list_arr, $start, 10);


                        if (isset($artist_list_arr)) {
                            $k = 1;
                            foreach ($artist_list_arr as $review_like_info) {
                                $review_like_info = (array)$review_like_info;

                                $sr_no++;
                                $k++;
                                $id      = $review_like_info['songid'];

                                $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.song_id = '" . $id . "' order by r.review_id desc limit 1";

                                $review_list_arr_top    =   \App\Models\Songs::GetRawData($review_list_qry);;


                                $comment_list_qry = "select u.user_name,u.profile_image, c.* from tbl_users u, tbl_comments c where u.user_id = c.comment_user_id AND c.comment_review_id = $id order by comment_id desc";


                                //$comment_list_arr	=	$db->get_row($comment_list_qry,ARRAY_A);
                                $discussion_list_arr    =    \App\Models\Songs::GetRawData($comment_list_qry);;
                                if ($discussion_list_arr) {
                                    $comment_list_arr['count_discussion'] = count($discussion_list_arr);
                                } else {
                                    $comment_list_arr['count_discussion'] =  0;
                                }



                                $userid    = $review_like_info['userid'];
                                $song_id      = $review_like_info['songid'];
                                $title_playlist       =  stripslashes($review_like_info['title_playlist']);
                                $id_playlist           =   stripslashes($review_like_info['playlistid']);
                                $user_id_playlist      =   stripslashes($review_like_info['user_id_playlist']);
                                $artist_id      = $review_like_info['artist_iddb'];
                                $artist_iddb      = $review_like_info['artist_iddb'];
                                $artist_name = stripslashes(html_entity_decode($review_like_info['artist_name']));
                                $song_title = stripslashes(html_entity_decode($review_like_info['song_title']));
                                $artist_seo = strtolower(stripslashes(html_entity_decode($review_like_info['artist_seo'])));
                                $picture   = stripslashes(html_entity_decode($review_like_info['picture']));
                                if ($picture == '' &&  $review_like_info['updated_by_itunes'] == '0000-00-00 00:00:00') {
                                    $req_song  =  artist_album_song_func(stripslashes(html_entity_decode($review_like_info['artist_name'])), stripslashes(html_entity_decode($review_like_info['song_title'])));
                                }



                                $song_seo   = strtolower(stripslashes(html_entity_decode($review_like_info['song_seo'])));


                                $title_db = urlencode("$song_title");
                                $url_db = urlencode(SERVER_ROOTPATH . $song_seo . "-reviewslist-" . $artist_seo . "-" . $position_find . "#review_" . $review_id);
                                $summary = urlencode("$review_detail");



                                if ($db_profile_image != "") {
                                    $prof_image = SERVER_ROOTPATH . "assets/phpthumb/phpThumb.php?src=" . SERVER_ROOTPATH . "site_upload/user_images/" . $db_profile_image . "&w=100&h=75&zc=0";
                                } else {
                                    $prof_image = SERVER_ROOTPATH . "assets/phpthumb/phpThumb.php?src=" . SERVER_ROOTPATH . "assets/images/no_image4.png&w=101&h=75&zc=0";
                                }

                                $description   = stripslashes(html_entity_decode($review_like_info['description']));

                                $artist_name = wordwrap($artist_name, 100, " ", true);

                                $counter_main = "select id from tbl_likes where like_type = 'artist' AND like_id = '$artist_id'";
                                $counter_main = array();
                                $counter_main = \App\Models\Songs::GetRawData($qry);
                                if ($counter_main) {
                                    $counter_main = count($counter_main);
                                } else {
                                    $counter_main = 0;
                                }
                                $qry =  "select id from tbl_likes where like_type = 'artist' AND like_id = '$artist_id'";
                                $counter_main2 = array();
                                $counter_main2 = \App\Models\Songs::GetRawData($qry);
                                if ($counter_main2) {
                                    $counter_main2 = count($counter_main2);
                                } else {
                                    $counter_main2 = 0;
                                }
                                $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter, sum(review_rating>=8) as excellent, sum(review_rating>=6 && review_rating<8) as verygood, sum(review_rating>=4 && review_rating<6) as good,sum(review_rating>=2 && review_rating<4) as poor,sum(review_rating>0 && review_rating<2) as terrible from tbl_reviews where song_id = $id AND status = 1";


                                $rate_arr    =    \App\Models\Songs::GetRawData($sum_rating);
                                if ($rate_arr) {
                                    $rate_arr = (array) $rate_arr[0];
                                    $sum_rate = $rate_arr['sum_rate'];
                                    $counter = $rate_arr['counter'];
                                    $excellent = $rate_arr['excellent'];
                                    $verygood = $rate_arr['verygood'];
                                    $good = $rate_arr['good'];
                                    $poor = $rate_arr['poor'];
                                    $terrible = $rate_arr['terrible'];
                                    if ($counter > 0) {
                                        $excellent_per = ($excellent / $counter) * 100;
                                        $verygood_per  = ($verygood / $counter) * 100;
                                        $good_per        = ($good / $counter) * 100;
                                        $poor_per        = ($poor / $counter) * 100;
                                        $terrible_per = ($terrible / $counter) * 100;
                                    } else {
                                        $excellent_per = 0;
                                        $verygood_per  = 0;
                                        $good_per        = 0;
                                        $poor_per        = 0;
                                        $terrible_per = 0;
                                    }
                                } else {
                                    $sum_rate = 0;
                                    $counter = 0;
                                    $all_avg = 0;
                                    $excellent_per = 0;
                                    $verygood_per  = 0;
                                    $good_per        = 0;
                                    $poor_per        = 0;
                                    $terrible_per = 0;
                                }


                                if ($sum_rate == "" || $sum_rate == 0 || $counter == '' || $counter == 0) {
                                    $sum_rate = 0;
                                    $counter = 0;
                                    $all_avg = 0;
                                } else {

                                    $all_avg  =  $sum_rate / $counter;
                                }




                                if ($all_avg == "") {
                                    $all_avg = 5.0;
                                }

                                if ($all_avg >= 8) {
                                    $color_pick = "#5ebd5e";
                                }

                                if ($all_avg >= 7 && $all_avg < 8) {
                                    $color_pick = "#5ebd5e";
                                }

                                if ($all_avg >= 4 && $all_avg < 6.9) {
                                    $color_pick = "#e06d21";
                                }

                                if ($all_avg >= 2 && $all_avg < 3.9) {
                                    $color_pick = "#dd554e";
                                }

                                if ($all_avg > 0 && $all_avg < 2) {
                                    $color_pick = "#dd554e";
                                }
                                if ($all_avg >= 7) {
                                    $color_pick = "#5ebd5e";
                                }
                                if ($all_avg >= 4 && $all_avg <= 6.9) {
                                    $color_pick = "#e06d21";
                                }
                                if ($all_avg >= 0 && $all_avg <= 3.9) {
                                    $color_pick = "#dd554e";
                                }


                                $all_avg = number_format($all_avg, 1);





                                $qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '" . $song_id . "'";
                                $qry_feature_arr = \App\Models\Songs::GetRawData($qry_top_feature_artist);
                                if ($qry_feature_arr) {
                                    $count  = count($qry_feature_arr);
                                } else {
                                    $count = 0;
                                }
                                $num = 1;
                                $feature_artists = "";
                                if ($qry_feature_arr) {



                                    foreach ($qry_feature_arr as $val_feature) {
                                        $val_feature = (array)$val_feature;
                                        $val_feature['f_artist_seo'] = strtolower($val_feature['f_artist_seo']);
                                        if ($num == $count) {

                                            $feature_art  = substr($val_feature['feature_artist'], 0, 16);
                                            if (strlen($val_feature['feature_artist']) > 16) {
                                                $feature_artists .= " <a href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs' style='color:#d73b3b; font-size: 16px;  font-weight: 500;'>" . $feature_art . '..' . "</a>";
                                            } else {
                                                $feature_artists .= " <a href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs' style='color:#d73b3b; font-size: 16px;  font-weight: 500;'>" . $val_feature['feature_artist'] . "</a>";
                                            }
                                            if ($num == 2) {
                                                break;
                                            }
                                        } else {
                                            $feature_art  = substr($val_feature['feature_artist'], 0, 16);
                                            if (strlen($val_feature['feature_artist']) > 16) {
                                                $feature_artists .= " <a href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs' style='color:#d73b3b; font-size: 16px;  font-weight: 500;' >" . $feature_art . '..' . "</a>";
                                            } else {
                                                $feature_artists .= " <a href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs' style='color:#d73b3b; font-size: 16px;  font-weight: 500;'>" . $val_feature['feature_artist'] . "</a>";
                                            }
                                            if ($num == 2) {
                                                break;
                                            }
                                        }
                                        $num++;
                                    }
                                }

                                $url_gen    =    SERVER_ROOTPATH . $artist_seo . "-artist-songs";


                        ?>
                                <li <?php if ($sr_no % 2 == 0) { ?> style="background-color:#f3f3f3;" <?php } ?>>
                                    <?php if ($mobile_view == 0) { ?>
                                        <div class="row">
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                <span class="list_no"><?php if (strlen($sr_no) == 1) {
                                                                            echo "0";
                                                                        } else {
                                                                        }; ?><?php echo $sr_no; ?></span>
                                            </div>
                                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
                                                <div class="album_cover">
                                                    <a href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>" class="text_blck"> <?php
                                                                                                                                                        if ($picture != "") {
                                                                                                                                                            $img_api_linka = album_img_api($picture);

                                                                                                                                                            if ($img_api_linka != '') {
                                                                                                                                                        ?>

                                                                <img src="<?php echo $img_api_linka; ?>" border="0" width="120" />
                                                            <?php } else { ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>" border="0" width="120" />
                                                                <?php
                                                                                                                                                            }
                                                                                                                                                        } else {

                                                                                                                                                            if ($req_song['song_array']['image4'] != "") {
                                                                                                                                                                $img_api_linkaa = album_img_api($req_song['song_array']['image4']);

                                                                                                                                                                if ($img_api_linkaa != '') {
                                                                ?>
                                                                    <img class="img-responsive" src="<?php echo $img_api_linkaa; ?>" border="0" width="120" /> <?php } else { ?>
                                                                    <img class="img-responsive" src="<?php echo $req_song['song_array']['image4']; ?>" border="0" width="120" />
                                                                <?php
                                                                                                                                                                }
                                                                                                                                                            } else if ($album_picture != "") {


                                                                                                                                                                $img_api_aa = album_img_api($album_picture);

                                                                                                                                                                if ($img_api_aa != '') {
                                                                ?>
                                                                    <img class="img-responsive" src="<?php echo $img_api_aa; ?>" border="0" width="120" /> <?php } else { ?>
                                                                    <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="120" />
                                                                <?php
                                                                                                                                                                }
                                                                                                                                                            } else { ?>
                                                                <img src="<?php echo COOKIE_FREE_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="120" />
                                                        <?php }
                                                                                                                                                        } ?>
                                                    </a>
                                                    <!--	<cite class="yellow">5.0</cite>-->
                                                    <?php if ($all_avg != 0) {
                                                    ?><cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                    echo number_format($all_avg, 1);
                                                                                                                } else {
                                                                                                                    echo $all_avg;
                                                                                                                } ?></cite><?php } else { ?> <cite style="background-color:#dd554e;">0.0</cite><?php } ?>


                                                </div>
                                                <div class="album_details" style="width:74%; padding-top:0; margin-top:0;">

                                                    <label class="title"><a href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>">
                                                            <?php echo substr($song_title, 0, 50);
                                                            if (strlen($song_title) > 50) {
                                                                echo "...";
                                                            } ?>

                                                        </a></label>
                                                    <label class="author"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><?php echo substr($artist_name, 0, 25);
                                                                                                                                                    if (strlen($artist_name) > 25) {
                                                                                                                                                        echo "...";
                                                                                                                                                    } ?></a></label>
                                                    <label class="likes playlist_auto" style="height:26px; margin-top:-9px; vertical-align: middle; margin-left:30px;">
                                                        <!--<img src="images/icon_heart.png"><a href="#"><span>0</span> Likes</a>-->
                                                        <?php
                                                        if ($user_id != "") {

                                                            $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$artist_iddb'";
                                                            $counter = array();
                                                            $counter = \App\Models\Songs::GetRawData($qry);
                                                            if ($counter) {
                                                                $counter = count($counter);
                                                            } else {
                                                                $counter = 0;
                                                            }
                                                            if ($counter == 0) {
                                                        ?>
                                                                <span id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $artist_iddb; ?>" style="display: inline-table;"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $artist_iddb; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="text_grey"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i> </a><span class="text_red"><?php echo $counter_main; ?></span>
                                                                    <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                } ?></a></span>
                                                                <span id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $artist_iddb; ?>"></span>
                                                            <?php } else { ?>
                                                                <span id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $artist_iddb; ?>" style="display: inline-table;"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $artist_iddb; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="like"><i class="fa fa-heart" style="font-size:24px; color:#D73B3B;"></i></a>&nbsp;<span class="text_red"><?php echo $counter_main; ?></span>
                                                                    <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                } ?></a></span>
                                                                <span id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $artist_iddb; ?>"></span>
                                                            <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <span id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $artist_iddb; ?>">
                                                                <?php
                                                                if ($user_id == "") {
                                                                ?>
                                                                    <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o text_grey" style="font-size:24px; color:#D73B3B;"></i></a>

                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $artist_iddb; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="text_grey"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <span class="text_red"><?php echo $counter_main; ?></span>
                                                                <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                            } ?></a></span>
                                                            <span id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $artist_iddb; ?>"></span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </label>

                                                    <div style="clear:both;"></div>
                                                    <?php if ($feature_artists != "") { ?>
                                                        <p><label class="reviews"><?php echo "ft. " . $feature_artists; ?></label></p><?php } ?>
                                                    <div style="clear:both;"></div>
                                                    <p>
                                                        <label class="reviews">
                                                            <!--<img src="images/icon_review.png">--> <img src="<?php echo COOKIE_FREE_ROOTPATH; ?>images/review-book.png"><a style="opacity:1;">Reviews <span><?php echo $review_list_arr_top['count_reviews']; ?></span></a>
                                                        </label>
                                                        <label class="reviews"><img src="<?php echo COOKIE_FREE_ROOTPATH; ?>images/icon_post.png"><a style="opacity:1;"><?php if ($comment_list_arr['count_discussion'] < 2) {
                                                                                                                                                                            echo "Posts ";
                                                                                                                                                                        } else {
                                                                                                                                                                            echo "Posts ";
                                                                                                                                                                        } ?><span><?php echo $comment_list_arr['count_discussion']; ?></span></label>
                                                    </p>
                                                </div>

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ipad_show_div" style="padding-right:0">

                                                    <?php
                                                    if ($user_id == "") {
                                                    ?>
                                                        <a href="#" data-toggle="modal" data-target="#signin_form" style="padding:0; float:right; margin-right:6px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add_playlist.php?song_id=<?php echo $id; ?>&art_id=<?php echo $artist_id; ?>" style="padding:0; float:right; margin-right:6px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                    <?php
                                                    }
                                                    ?>



                                                    <a href="<?php echo SERVER_ROOTPATH . $song_seo . "/write-a-review/" . $artist_seo; ?>" style="float:right; margin-right:26px;"><button style="margin-left:0;">Write A Review </button></a>

                                                </div>
                                                <info class="show_default">

                                                    <?php
                                                    if ($user_id == "") {
                                                    ?>

                                                        <a href="#" data-toggle="modal" data-target="#signin_form" class="playlist_icon"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                    <?php
                                                    } else {
                                                    ?>

                                                        <a class="playlist_icon" data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add_playlist.php?song_id=<?php echo $id; ?>&art_id=<?php echo $artist_id; ?>"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                    <?php
                                                    }
                                                    ?>


                                                    <button onclick="window.location.href='<?php echo SERVER_ROOTPATH . $song_seo . "/write-a-review/" . $artist_seo; ?>'">Write a review</button>
                                                </info>
                                            </div>
                                        </div>
                                    <?php } elseif ($mobile_view == 1) { ?>
                                        <div class="row">
                                            <!-- <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
 										<span class="list_no"><?php if (strlen($k_song) == 1) {
                                                                    echo "0";
                                                                } else {
                                                                }; ?><?php echo $k_song; ?></span>
 									</div>-->

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-right:2px !important;">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 album-outer-coontainer" style="padding:0px !important;">
                                                    <div class="album_cover">
                                                        <a href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>" class="text_blck"> <?php
                                                                                                                                                            if ($picture != "") {
                                                                                                                                                                $img_api_linka = album_img_api($picture);
                                                                                                                                                                if ($img_api_linka != '') {
                                                                                                                                                            ?>
                                                                    <img class="fixed-hgt-img" src="<?php echo $img_api_linka; ?>" border="0" width="120" />
                                                                <?php } else { ?>
                                                                    <img class="fixed-hgt-img" src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>" border="0" width="120" />
                                                                <?php
                                                                                                                                                                }
                                                                                                                                                            } else {

                                                                                                                                                                if ($req_song['song_array']['image4'] != "") { ?>
                                                                    <img class="img-responsive" src="<?php echo $req_song['song_array']['image4']; ?>" border="0" width="120" style=" height:80px !important;" />
                                                                <?php } else if ($album_picture != "") { ?>
                                                                    <img class="fixed-hgt-img" src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="120" />
                                                                <?php } else { ?>
                                                                    <img class="fixed-hgt-img" src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="120" />
                                                            <?php }
                                                                                                                                                            } ?>
                                                        </a>
                                                        <?php if ($all_avg != 0) {
                                                        ?><cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                        echo number_format($all_avg, 1);
                                                                                                                    } else {
                                                                                                                        echo $all_avg;
                                                                                                                    } ?></cite><?php } else { ?> <cite style="background-color:#dd554e;">0.0</cite><?php } ?>

                                                        <div style="position:inherit; z-index:10; float:right; color:#FFFFFF; margin-top:-20px; margin-right:3px;"><?php echo $sr_no; ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 album-detail-container" style="padding:0px !important;">
                                                    <div class="album_details">
                                                        <label class="title"><a href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>"><?php echo substr($song_title, 0, 50);
                                                                                                                                                                if (strlen($song_title) > 50) {
                                                                                                                                                                    echo "...";
                                                                                                                                                                } ?></a></label>
                                                        <label class="author"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><?php echo substr($artist_name, 0, 30);
                                                                                                                                                        if (strlen($artist_name) > 30) {
                                                                                                                                                            echo "...";
                                                                                                                                                        } ?></a></label>
                                                        <div style="clear:both;"></div>
                                                        <?php if ($feature_artists != "") { ?>
                                                            <p><label class="reviews" style="float:left !important;"><?php echo "ft. " . $feature_artists; ?></label></p><?php } ?>
                                                        <div style="clear:both;"></div>
                                                        <label class="likes" style="height:26px; margin-left:0px; padding-left:0px; vertical-align: middle;">
                                                            <?php
                                                            if ($user_id != "") {
                                                                $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$artist_iddb'";
                                                                $counter = array();
                                                                $counter = \App\Models\Songs::GetRawData($qry);
                                                                if ($counter) {
                                                                    $counter = count($counter);
                                                                } else {
                                                                    $counter = 0;
                                                                }
                                                                if ($counter == 0) {
                                                            ?>
                                                                    <span id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $artist_iddb; ?>" style="display: inline-table;"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $artist_iddb; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="text_grey"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i> </a><span class="text_red"><?php echo $counter_main; ?></span>
                                                                        <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                                    <span id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $artist_iddb; ?>"></span>
                                                                <?php } else { ?>
                                                                    <span id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $artist_iddb; ?>" style="display: inline-table;"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $artist_iddb; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="like"><i class="fa fa-heart" style="font-size:24px; color:#D73B3B;"></i> </a> <span class="text_red"><?php echo $counter_main; ?></span>
                                                                        <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                                    <span id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $artist_iddb; ?>"></span>
                                                                <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <span id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $artist_iddb; ?>">
                                                                    <?php
                                                                    if ($user_id == "") {
                                                                    ?>
                                                                        <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o text_grey" style="font-size:24px; color:#D73B3B;"></i></a>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $artist_iddb; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="text_grey"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <span class="text_red"><?php echo $counter_main; ?></span>
                                                                    <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                } ?></a></span>
                                                                <span id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $artist_iddb; ?>"></span>
                                                            <?php
                                                            }
                                                            ?>
                                                        </label>
                                                        <div class="hidden-phone" style="clear:both;"></div>
                                                        <p class="inline-mobile"><label class="reviews"><img src="<?php echo COOKIE_FREE_ROOTPATH; ?>images/review-book.png"><a>Reviews <span><?php echo $review_list_arr_top['count_reviews']; ?></span></a></label>
                                                            <label class="reviews"><img src="<?php echo COOKIE_FREE_ROOTPATH; ?>images/icon_post.png"><a><?php if ($comment_list_arr['count_discussion'] < 2) {
                                                                                                                                                                echo "Posts ";
                                                                                                                                                            } else {
                                                                                                                                                                echo "Posts ";
                                                                                                                                                            } ?><span><?php echo $comment_list_arr['count_discussion']; ?></span></a></label>
                                                        </p>
                                                    </div>


                                                </div>

                                                <div class="clear"></div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-right:0">
                                                    <div class="col-sm-5 col-xs-5">
                                                        <?php
                                                        if ($user_id == "") {
                                                        ?>
                                                            <a href="#" data-toggle="modal" data-target="#signin_form" style="padding:0; float:left; margin-right:6px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add_playlist.php?song_id=<?php echo $id; ?>&art_id=<?php echo $artist_id; ?>" style="padding:0; float:left; margin-right:6px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-7 col-xs-7" style="padding-right:20px; float:right;">
                                                        <a href="<?php echo SERVER_ROOTPATH . $song_seo . "/write-a-review/" . $artist_seo; ?>"><button>Write a review</button></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </li>
                        <?php
                                $k++;
                            }
                        }
                        $kval = $k;
                        ?>
                    </ul>
                    <?php if ($total_pages > $limit) { ?>
                        <div class="page-navigation">
                            <ul>
                                @include("common.paging-playlist_underscore")
                            </ul>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>

    <?php
    if ($mobile_view == 1) { ?>

    <?php } ?>

    <div class="clearfix"></div>
    <?php
    if (strpos($request_url, 'profile') !== false) {
        $bgcolors    = 'background-color:#fff';
    } else {
        $bgcolors    = 'background-color:#F6F6F6;';
    }
    ?>

    <?php
    if ($main_link != "") {
    ?>
        <!-- Advertisement Banner Start-->
        <div class="container" style="padding-bottom:15px;">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <?php echo ads_info('Bottom'); ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
            </div>
        </div>
        <div class="clear"></div>
        <!--Advertisement Banner End-->
    <?php } ?>
    </div>
    </div>
    <div class="modal fade edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="images/crosspng.png"></span></button>
                    <h4 class="modal-title text_blck">EDIT YOUR REVIEW</h4>
                </div>
                <div class="modal-body">
                    <div class="well">
                        <form>
                            <div class="form-group text-right">
                                <span class="Oswald text_16 mr-10">What is your rating?</span>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Review Title" type="text">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="5" placeholder="Your Review"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success Oswald pull-left">Update Review</button>
                            <button type="submit" class="btn btn-danger Oswald pull-right">Delete Review</button>
                            <div class="clear"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ./Middle Section -->
@include("common.signin_modal")
@include("common.footer")
<?php

// include("include/thankyou_messages.php");




?>
<div class="modal fade" id="review_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

<?php



for ($u = 1; $u <= $sr_no; $u++) {
?>
    <div class="modal fade" id="missing_popular_review_Modal2_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}

?>
<div class="modal fade" id="profile_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php


for ($g = 1; $g <= $k; $g++) {
?>
    <div class="modal fade" id="edit_Modal4_<?php echo $g; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}

for ($g = 1; $g <= $k; $g++) {
?>
    <div class="modal fade" id="report_Modal4_<?php echo $g; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}
?>
<style>
    body {
        overflow-x: hidden;
    }

    .form-control {
        height: auto;
    }
</style>
<script src='<?php echo SERVER_ROOTPATH; ?>jquery.MetaData.js' type="text/javascript" language="javascript"></script>
<link rel="stylesheet" href="css/star-rating.css" media="all" type="text/css" />
<div class="modal fade" id="show_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<div class="modal fade" id="create_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<div class="modal fade" id="delete_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>