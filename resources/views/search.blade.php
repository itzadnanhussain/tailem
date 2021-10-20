@include("common.header")
<?php

error_reporting(0);
$srch_search_sess   =  session()->get('main_search');
$srch_sess          =  session()->get('main_result');
$srch_sess_song     =  session()->get('main_result_song');
$srch_sess_album      =  session()->get('main_result_album');
if ($srch_search_sess == "") {

    $srch_search_sess = "Alonzo Pennington";
}
?>

<style type="text/css">
    .myClass {
        background-color: #FFFD00;
    }

    .author {
        margin-right: 10px;
    }
</style>

<!-- Middle Section -->
<section class="middle_sec">
    <div class="banner">
        <div class="banner_body">
            <h1 class="bnr_heading">Search results</h1>
            <div class="banner-search">
                <form action="" method="post">
                    <div class="form-group">
                        @csrf
                        <label for="search" onClick="unset_all()" style="cursor:pointer;">All</label>
                        <input type="text" class="form-control" value="<?php echo stripslashes(session()->get('main_search')); ?>" id="search" name="search" placeholder="Search for an Artist, Album or Song" required>
                        <!--<button type="submit" type="submit" name="submit_ba" id="submit_ba" class="btn">Submit</button>-->


                        <button class="btn" type="submit" value="Search" name="submitbtn"><i class="sprite-new sprite-new-xsearch-icon-png-pagespeed-ic-XjnYgjYQAr"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="topsonglistsec" style="padding:0;">
        <div class="container" style="padding:0; <?php if ($mobile_view == 1) { ?> margin-right:0; <?php } else { ?> <?php } ?>">

            <!-- Advertisement Banner Start-->
            <div class="container" style="padding:20px 0 10px 0;">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-0 col-xs-0 review_screen_txt">&nbsp;</div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="text-align:center;">
                        <?php echo ads_info('Top'); ?>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-0 col-xs-0 review_screen_txt">&nbsp;</div>
                </div>
            </div>
            <!--Advertisement Banner End-->

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0;">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="brows-label-penel" style="background-color:#FFFFFF;">
                            <ul class="list-inline">
                                <li>
                                    <a class="active" href="<?php echo SERVER_ROOTPATH; ?>searcher">ALL RESULTS</a> |
                                    <a href="<?php echo SERVER_ROOTPATH; ?>searcher-results-song">SONGS</a> |
                                    <a href="<?php echo SERVER_ROOTPATH; ?>searcher-results-artist">ARTISTS</a> |
                                    <a href="<?php echo SERVER_ROOTPATH; ?>searcher-results-album">ALBUMS</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <!--SONGS-->
                    <div class="brows-label-penel search_bread_crumb">
                        <div class="row">
                            <?php


                            $artist_list_arr = array();
                            $temp = explode(" ", trim($srch_search_sess));
                            $first_word = $temp[0];
                            $update_status =    table_last_updated("tbl_artists");




                            if (empty($artist_list_arr) || !$update_status) {
                                if (!$artist_list_arr) {
                                    $artist_list = "select * FROM tbl_songs where song_title like '%$srch_search_sess%' order by song_title = '$srch_search_sess' desc limit 50";

                                    $artist_list_arr = \App\Models\Songs::GetRawData($artist_list);

                                    if ($artist_list_arr) {
                                        $song_count  = count($artist_list_arr);
                                    } else {
                                        $song_count  = 0;
                                    }
                                }
                            }

                            ?>
                            <div class="col-xs-6">
                                <ul class="list-inline">
                                    <li>SONGS <span class="active">(<?php echo $song_count; ?>)</span></li>
                                </ul>
                            </div>
                            <div class="col-xs-6 search_see_all">
                                <ul class="list-inline">
                                    <li><a href="<?php echo SERVER_ROOTPATH; ?>searcher-results-song" aria-controls="song" class="active">See All</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <ul class="songlistings">
                        <?php

                        $artist_list_arr = array_slice($artist_list_arr, 0, 5);
                        if (isset($artist_list_arr)) {
                            $k_song = 1;
                            foreach ($artist_list_arr as $val) {
                                $val = (array)$val;
                                $id      = $val['id'];
                                // $db_art_id      = $val['art_id'];
                                $db_art_id      = null;

                                // $album_title = stripslashes(html_entity_decode($val['album_title']));
                                $album_title = null;
                                // $artist_name = utf8_decode(stripslashes(html_entity_decode($val['artist_name'])));
                                $artist_name = null;
                                // $album_picture   = stripslashes(html_entity_decode($val['album_picture']));
                                $album_picture   = null;
                                $song_title = stripslashes(html_entity_decode($val['song_title']));
                                // $artist_seo = strtolower(stripslashes(html_entity_decode($val['artist_seo'])));
                                $artist_data = GetArtistBySongId($id);

                                $artist_seo = strtolower($artist_data['artist_seo']);
                                $artist_name = strtolower($artist_data['artist_name']);


                                $song_seo   = strtolower(stripslashes(html_entity_decode($val['song_seo'])));
                                //$req_song  =  artist_album_song_func($artist_name,$song_title);

                                // $album_title = wordwrap($album_title, 100, " ", true);
                                // $artist_name = wordwrap($artist_name, 100, " ", true);
                                $picture   = stripslashes(html_entity_decode($val['picture']));

                                // $album_artist_id = stripslashes(html_entity_decode($val['album_artist_id']));
                                $album_artist_id =  null;

                                $review_list_arr_top = array();

                                if (empty($review_list_arr_top)) {

                                    $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.song_id = '" . $id . "' order by r.review_id desc limit 1";
                                    $review_list_arr_top = \App\Models\Songs::GetRawData($review_list_qry);
                                }

                                $comment_list_arr = array();

                                if (empty($comment_list_arr)) {

                                    $comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_review_id = '" . $id . "' order by comment_id desc limit 1";

                                    $comment_list_arr = \App\Models\Songs::GetRawData($comment_list_qry);
                                }






                                $qry = "select id from tbl_likes where like_type = 'artist' AND like_id = '$db_art_id'";
                                $counter_main = array();
                                $counter_main = \App\Models\Songs::GetRawData($qry);
                                if ($counter_main) {
                                    $counter_main = count($counter_main);
                                } else {
                                    $counter_main = 0;
                                }

                                $qry_feature_arr = array();

                                if (empty($qry_feature_arr)) {
                                    $qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '" . $id . "'";
                                    // $qry_feature_arr = $db->get_results($qry_top_feature_artist, ARRAY_A);
                                    $qry_feature_arr = \App\Models\Songs::GetRawData($qry_top_feature_artist);
                                    if ($qry_feature_arr) {
                                        $count  = count($qry_feature_arr);
                                    } else {
                                        $count = 0;
                                    }
                                }
                                $num = 1;
                                $feature_artists = "";
                                if ($qry_feature_arr) {



                                    foreach ($qry_feature_arr as $val_feature) {
                                        $val_feature = (array)$val_feature;
                                        $val_feature['f_artist_seo'] = strtolower($val_feature['f_artist_seo']);
                                        if ($num == $count) {
                                            $feature_artists .= " <a style='color:#d73b3b;' href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $val_feature['feature_artist'] . "</a>";
                                        } else {
                                            $feature_artists .= " <a style='color:#d73b3b;' href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $val_feature['feature_artist'] . "</a>,";
                                        }
                                        $num++;
                                    }
                                }




                                $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = $id AND status = 1";
                                $rate_arr    =    \App\Models\Songs::GetRawData($sum_rating);
                                if ($rate_arr) {
                                    $rate_arr = (array) $rate_arr[0];
                                    $sum_rate = $rate_arr['sum_rate'];
                                    $counter = $rate_arr['counter'];
                                } else {
                                    $sum_rate = 0;
                                    $counter = 0;
                                    $all_avg = 0;
                                }


                                if ($sum_rate == "" || $sum_rate == 0 || $counter == '' || $counter == 0) {
                                    $sum_rate = 0;
                                    $counter = 0;
                                    $all_avg = 0;
                                } else {

                                    $all_avg  =  $sum_rate / $counter;
                                }





                                if ($all_avg == "") {
                                    $all_avg = 0;
                                }

                                if ($all_avg >= 8) {
                                    $color_pick = "#5cb85c";
                                }

                                if ($all_avg >= 6 && $all_avg < 8) {
                                    $color_pick = "#5cb85c";
                                }

                                if ($all_avg >= 4 && $all_avg < 6) {
                                    $color_pick = "#e06d21";
                                }

                                if ($all_avg >= 2 && $all_avg < 4) {
                                    $color_pick = "#d9534f";
                                }

                                if ($all_avg > 0 && $all_avg < 2) {
                                    $color_pick = "#d9534f";
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

                                $c++;
                                $sr_no++;

                        ?>
                                <li>
                                    <?php if ($mobile_view == 0) { ?>

                                        <div class="row mobileview0">
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                <span class="list_no"><?php if (strlen($k_song) == 1) {
                                                                            echo "0";
                                                                        } else {
                                                                        }; ?><?php echo $k_song; ?></span>
                                            </div>
                                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
                                                <div class="album_cover">

                                                    <a href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>" class="text_blck"> <?php
                                                                                                                                                                    if ($picture != "") {
                                                                                                                                                                        $img_api_linka = album_img_api($picture);
                                                                                                                                                                        if ($img_api_linka != '') {
                                                                                                                                                                    ?>
                                                                <img src="<?php echo album_img_api($picture); ?>" border="0" width="120" />
                                                            <?php } else { ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>" border="0" width="120" />
                                                            <?php
                                                                                                                                                                        }
                                                                                                                                                                    } else
													if ($req_song['song_array']['image4'] != "") {
                                                            ?>
                                                            <img src="<?php echo album_img_api($req_song['song_array']['image4']); ?>" border="0" width="120" />
                                                        <?php
                                                                                                                                                                    } else
													if ($album_picture != "") {
                                                        ?>
                                                            <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="120" />
                                                        <?php
                                                                                                                                                                    } else {
                                                        ?>
                                                            <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="120" />
                                                        <?php
                                                                                                                                                                    }
                                                        ?>
                                                    </a>
                                                    <!--<cite style="background-color:#e06d21">6.0</cite> -->
                                                    <?php
                                                    if ($all_avg != 0) {
                                                    ?><cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                    echo number_format($all_avg, 1);
                                                                                                                } else {
                                                                                                                    echo $all_avg;
                                                                                                                } ?></cite><?php } else { ?>

                                                        <cite style="background-color:#dd554e">0.0</cite>
                                                    <?php } ?>

                                                </div>
                                                <div class="album_details" style="margin-top:0; padding: 2% 0 0 4%;">

                                                    <label class="review_screen_txt title" style="margin-bottom:5px;"><a href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><?php echo substr($song_title, 0, 45);
                                                                                                                                                                                                                    if (strlen($song_title) > 45) {
                                                                                                                                                                                                                        echo "...";
                                                                                                                                                                                                                    } ?></a></label>

                                                    <label class="review_ipad_txt title" style="margin-bottom:5px;"><a href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><?php echo substr($song_title, 0, 32);
                                                                                                                                                                                                                    if (strlen($song_title) > 32) {
                                                                                                                                                                                                                        echo "...";
                                                                                                                                                                                                                    } ?></a></label>

                                                    <label class="author"><a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 32);
                                                                                                                                                            if (strlen($artist_name) > 32) {
                                                                                                                                                                echo "...";
                                                                                                                                                            } ?></a></label>
                                                    <label class="likes" style="float:right; height:26px; margin-top:-9px;">
                                                        <?php
                                                        if ($user_id != "") {


                                                            $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$db_art_id'";
                                                            $counter = array();
                                                            $counter = \App\Models\Songs::GetRawData($qry);
                                                            if ($counter) {
                                                                $counter = count($counter);
                                                            } else {
                                                                $counter = 0;
                                                            }

                                                            if ($counter == 0) {
                                                        ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $db_art_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $db_art_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k_song; ?>')" class="text_grey"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i> </a><span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>

                                                                <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $db_art_id; ?>"></span>
                                                            <?php } else { ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $db_art_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $db_art_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k_song; ?>')" class="like"><i class="fa fa-heart" style="font-size:24px; color:#D73B3B;"></i></a> <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>

                                                                <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $db_art_id; ?>"></span>
                                                            <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <span style="overflow:visible;" id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $db_art_id; ?>">
                                                                <?php
                                                                if ($user_id == "") {
                                                                ?>
                                                                    <a href="#" data-toggle="modal" data-target="#signin_form" class="text_grey"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $db_art_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k_song; ?>')" class="text_grey"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                        } ?></a></span>

                                                            <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $db_art_id; ?>"></span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </label>
                                                    <?php
                                                    if ($feature_artists != "") { ?>

                                                        <p><label class="reviews">ft. <?php echo $feature_artists; ?></label></p> <?php } ?> <div style="clear:both;"></div>
                                                    <p><label class="reviews"><img src="images/review-book.png"><a>Reviews <span><?php echo $review_list_arr_top['count_reviews']; ?></span></a></label>
                                                        <label class="reviews"><img src="<?php echo SERVER_ROOTPATH; ?>
images/icon_post.png"><a>Posts <span><?php echo $comment_list_arr['count_discussion']; ?></span></a></label>
                                                    </p>
                                                </div>
                                                <?php
                                                if ($user_id == "") {
                                                ?>
                                                    <a href="#" data-toggle="modal" data-target="#signin_form" class="playlist_icon"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                <?php
                                                } else {
                                                ?>
                                                    <a class="playlist_icon" data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add-playlist?song_id=<?php echo $id; ?>&art_id=<?php echo $db_art_id; ?>"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                <?php
                                                }
                                                ?>

                                                <a href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/write-a-review/" . Slug($artist_seo); ?>"><button>Write a review</button></a>
                                            </div>
                                        </div>

                                    <?php } else if ($mobile_view == 1) { ?>

                                        <div class="row mobileview1">
                                            <!--<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
 										<span class="list_no"><?php if (strlen($k_song) == 1) {
                                                                    echo "0";
                                                                } else {
                                                                }; ?><?php echo $k_song; ?></span>
 									</div>-->
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-right:2px !important;">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 album-outer-coontainer" style="padding:0px !important;">
                                                    <div class="album_cover">
                                                        <a href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>" class="text_blck"> <?php
                                                                                                                                                                        if ($picture != "") {
                                                                                                                                                                            $img_api_linka = album_img_api($picture);
                                                                                                                                                                            if ($img_api_linka != '') {
                                                                                                                                                                        ?>
                                                                    <img src="<?php echo album_img_api($picture); ?>" border="0" class="fixed-hgt-img" style="max-width:inherit; height:80px !important;" />
                                                                <?php } else { ?>
                                                                    <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>" class="fixed-hgt-img" border="0" />
                                                                <?php
                                                                                                                                                                            }
                                                                                                                                                                        } else
													if ($req_song['song_array']['image4'] != "") {
                                                                ?>
                                                                <img src="<?php echo album_img_api($req_song['song_array']['image4']); ?>" class="img-responsive" border="0" style="max-width:inherit; " />
                                                            <?php
                                                                                                                                                                        } else
													if ($album_picture != "") {
                                                            ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" class="fixed-hgt-img" border="0" />
                                                            <?php
                                                                                                                                                                        } else {
                                                            ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" class="fixed-hgt-img" border="0" style="max-width:inherit; " />
                                                            <?php
                                                                                                                                                                        }
                                                            ?>
                                                        </a>
                                                        <?php
                                                        if ($all_avg != 0) { ?><cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                                                echo number_format($all_avg, 1);
                                                                                                                                            } else {
                                                                                                                                                echo $all_avg;
                                                                                                                                            } ?></cite><?php } else { ?> <cite style="background-color:#dd554e">0.0</cite><?php } ?>

                                                        <div style="position:inherit; z-index:10; float:right; color:#FFFFFF; margin-top:-20px; margin-right:3px;"><?php echo $k_song; ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 album-detail-container" style="padding:0px !important;">
                                                    <div class="album_details" style="margin-top:0;">
                                                        <label class="title"><a href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><?php echo substr($song_title, 0, 22);
                                                                                                                                                                            if (strlen($song_title) > 22) {
                                                                                                                                                                                echo "...";
                                                                                                                                                                            } ?></a></label>
                                                        <label class="author"><a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 20);
                                                                                                                                                                if (strlen($artist_name) > 20) {
                                                                                                                                                                    echo "...";
                                                                                                                                                                } ?></a></label>
                                                        <div style="clear:both;"></div>
                                                        <?php
                                                        if ($feature_artists != "") { ?>

                                                            <p><label class="reviews" style="float:left;">ft. <?php echo $feature_artists; ?></label></p> <?php } ?> <div style="clear:both;"></div>
                                                        <p><label class="likes" style="float:left; height:26px;">
                                                                <?php
                                                                if ($user_id != "") {
                                                                    $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$db_art_id'";
                                                                    $counter = array();
                                                                    $counter = \App\Models\Songs::GetRawData($qry);
                                                                    if ($counter) {
                                                                        $counter = count($counter);
                                                                    } else {
                                                                        $counter = 0;
                                                                    }
                                                                    if ($counter == 0) {
                                                                ?>
                                                                        <span style="overflow:visible;" id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $db_art_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $db_art_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k_song; ?>')" class="text_grey"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i> </a><span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>

                                                                        <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $db_art_id; ?>"></span>
                                                                    <?php } else { ?>
                                                                        <span style="overflow:visible;" id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $db_art_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $db_art_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k_song; ?>')" class="like"><i class="fa fa-heart" style="font-size:24px; color:#D73B3B;"></i></a> <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>

                                                                        <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $db_art_id; ?>"></span>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $db_art_id; ?>">
                                                                        <?php
                                                                        if ($user_id == "") {
                                                                        ?>
                                                                            <a href="#" data-toggle="modal" data-target="#signin_form" class="text_grey"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $db_art_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k_song; ?>')" class="text_grey"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                } ?></a></span>

                                                                    <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $db_art_id; ?>"></span>
                                                                <?php
                                                                }
                                                                ?>
                                                            </label></p>
                                                        <div style="clear:both;"></div>


                                                        <p><label class="reviews"><img src="images/review-book.png"><a>Reviews <span> <?php echo $review_list_arr_top['count_reviews']; ?></span></a></label><label class="reviews"><img src="<?php echo SERVER_ROOTPATH; ?>
images/icon_post.png"><a><?php if ($comment_list_arr['count_discussion'] < 2) {
                                            echo "Posts ";
                                        } else {
                                            echo "Posts ";
                                        } ?><span><?php echo $comment_list_arr['count_discussion']; ?></span></a></label></p>

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
                                                            <a data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add-playlist?song_id=<?php echo $id; ?>&art_id=<?php echo $db_art_id; ?>" style="padding:0; float:left; margin-right:6px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-7 col-xs-7" style="padding-right:20px; float:right;">
                                                        <a href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/write-a-review/" . Slug($artist_seo); ?>"><button>Write a review</button></a>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                    <?php } ?>
                                </li>

                            <?php
                                $k_song++;
                            }
                        } else { ?> <p style="color:#333; padding:5px;"> No records found.</p><?php } ?>
                    </ul>
                    <!--ARTIST-->
                    <div class="brows-label-penel search_bread_crumb_bottom">
                        <div class="row">
                            <?php


                            $artist_list_arr = array();



                            if ($srch_search_sess != '') {

                                $orderby = "CASE 
												   WHEN artist_name LIKE '" . $srch_search_sess . "' THEN 1 
												   WHEN artist_name LIKE '" . $srch_search_sess . "%' THEN 2 
												   ELSE 3 
												   END, CHAR_LENGTH(artist_name)";
                            }




                            $artist_list = "select * FROM   tbl_artists  where 1=1 $srch_sess order by $orderby limit 50";

                            $artist_list_arr = \App\Models\Songs::GetRawData($artist_list);
                            if ($artist_list_arr) {
                                $artist_count  = count($artist_list_arr);
                            } else {
                                $artist_count  =  0;
                            }

                            ?>
                            <div class="col-xs-6">
                                <ul class="list-inline">
                                    <li>ARTISTS <span class="active">(<?php echo $artist_count; ?>)</span></li>
                                </ul>
                            </div>
                            <div class="col-xs-6 search_see_all">
                                <ul class="list-inline">
                                    <li><a class="active" href="<?php echo SERVER_ROOTPATH; ?>searcher-results-artist" aria-controls="artist">See All</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <ul class="songlistings">
                        <?php



                        $artist_list_arr = array_slice($artist_list_arr, 0, 5);
                        if (isset($artist_list_arr)) {
                            $k_artist = 1;
                            foreach ($artist_list_arr as $val) {
                                $val = (array)$val;

                                $id      = $val['id'];
                                $artist_name = stripslashes(html_entity_decode($val['artist_name']));
                                $artist_seo = strtolower(stripslashes(html_entity_decode($val['artist_seo'])));
                                $artist_img   = stripslashes(html_entity_decode($val['artist_img']));
                                $cat_name   = stripslashes(html_entity_decode($val['cat_name']));
                                $cat_seo_name   = stripslashes(html_entity_decode($val['cat_seo_name']));


                                $artist_name = wordwrap($artist_name, 100, " ", true);

                                $qry = "select id from tbl_likes where like_type = 'artist' AND like_id = '$id'";
                                $counter_main = array();
                                $counter_main = \App\Models\Songs::GetRawData($qry);
                                if ($counter_main) {
                                    $counter_main = count($counter_main);
                                } else {
                                    $counter_main = 0;
                                }
                                if ($c % 2 == 0) {
                                    $bgcolor = "#FEFEE4";
                                } else {
                                    $bgcolor = "#FFFFFF";
                                }
                                $rate_arr = array();

                                $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where artist_id = $id AND status = 1";
                                // $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = $id AND status = 1";


                                $rate_arr    =    \App\Models\Songs::GetRawData($sum_rating);


                                if ($rate_arr) {
                                    $rate_arr = (array) $rate_arr[0];
                                    $sum_rate = $rate_arr['sum_rate'];
                                    $counter = $rate_arr['counter'];
                                } else {
                                    $sum_rate = 0;
                                    $counter = 0;
                                    $all_avg = 0;
                                }


                                if ($sum_rate == "" || $sum_rate == 0 || $counter == '' || $counter == 0) {
                                    $sum_rate = 0;
                                    $counter = 0;
                                    $all_avg = 0;
                                } else {

                                    $all_avg  =  $sum_rate / $counter;
                                }




                                if ($all_avg == "") {
                                    $all_avg = 0;
                                }

                                if ($all_avg >= 8) {
                                    $color_pick = "#5cb85c";
                                }

                                if ($all_avg >= 6 && $all_avg < 8) {
                                    $color_pick = "#5cb85c";
                                }

                                if ($all_avg >= 4 && $all_avg < 6) {
                                    $color_pick = "#e06d21";
                                }

                                if ($all_avg >= 2 && $all_avg < 4) {
                                    $color_pick = "#d9534f";
                                }

                                if ($all_avg > 0 && $all_avg < 2) {
                                    $color_pick = "#d9534f";
                                }


                                if ($all_avg >= 7) {
                                    $color_pick = "#5ebd5e";
                                }
                                if ($all_avg >= 4 && $all_avg <= 6) {
                                    $color_pick = "#e06d21";
                                }
                                if ($all_avg >= 0 && $all_avg <= 3) {
                                    $color_pick = "#dd554e";
                                }

                                $c++;
                                $sr_no++;

                                //$req_artist  =  artist_func(urlencode("$artist_name"));

                        ?>
                                <li>
                                    <?php if ($mobile_view == 0) { ?>

                                        <div class="row mobileview0">
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                <span class="list_no"><?php if (strlen($k_artist) == 1) {
                                                                            echo "0";
                                                                        } else {
                                                                        }; ?><?php echo $k_artist; ?></span>
                                            </div>
                                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
                                                <div class="album_cover">
                                                    <!--<a href="#"><img  src="http://is2.mzstatic.com/image/thumb/Music/d2/56/9a/mzi.ydkjvvma.jpg/170x170bb-85.jpg" border="0" width="100" ></a>-->
                                                    <?php
                                                    if ($artist_img != "") {
                                                        $img_api_linka = album_img_api($artist_img);
                                                        if ($img_api_linka != '') { ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><img src="<?php echo get_small_thumb($artist_img); ?>" border="0" width="120" title="<?php echo $artist_name; ?>" /></a>
                                                        <?php } else { ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo '' . $artist_img; ?>" border="0" width="120" title="<?php echo $artist_name; ?>" /></a>
                                                        <?php
                                                        }
                                                    } else
											if ($artist_img == "") {
                                                        $req_artist  =  artist_func(urlencode("$artist_name"));
                                                        if ($req_artist['artist_array']['image4'] != "") {
                                                        ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><img src="<?php echo get_small_thumb($req_artist['artist_array']['image4']); ?>" border="0" width="120" /></a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="120" title="<?php echo $artist_name; ?>" /></a>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                    <?php if ($all_avg != 0) {    ?>
                                                        <cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                        echo number_format($all_avg, 1);
                                                                                                                    } else {
                                                                                                                        echo $all_avg;
                                                                                                                    } ?></cite><?php } else { ?>
                                                        <cite style="background-color:#dd554e">0.0</cite>
                                                    <?php } ?>
                                                </div>
                                                <div class="album_details" style="margin-top:0; padding: 2% 0 0 4%;">
                                                    <!--Desktop-->
                                                    <label class="review_screen_txt title"><a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 50);
                                                                                                                                                                            if (strlen($artist_name) > 50) {
                                                                                                                                                                                echo "...";
                                                                                                                                                                            } ?></a></label>
                                                    <!-- Ipad-->
                                                    <label class="review_ipad_txt title"><a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 20);
                                                                                                                                                                        if (strlen($artist_name) > 20) {
                                                                                                                                                                            echo "...";
                                                                                                                                                                        } ?></a></label>

                                                    <label class="likes">
                                                        <?php
                                                        if ($user_id != "") {
                                                            $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$id'";
                                                            $counter = array();
                                                            $counter = \App\Models\Songs::GetRawData($qry);
                                                            if ($counter) {
                                                                $counter = count($counter);
                                                            } else {
                                                                $counter = 0;
                                                            }
                                                            if ($counter == 0) {
                                                        ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_artist; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>
                                                                <span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>

                                                            <?php
                                                            } else {
                                                            ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_artist; ?>')" class="like"><i class="fa fa-heart heart_color heart_size"></i></a> <span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                                                <span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>
                                                            <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>">
                                                                <?php
                                                                if ($user_id == "") {
                                                                ?>
                                                                    <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_artist; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                            <span style="overflow:visible; display:none" id="myStyle_sub_<?php echo $id; ?>"></span>
                                                        <?php } ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else if ($mobile_view == 1) { ?>

                                        <div class="row mobileview1">
                                            <!--<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
 										<span class="list_no"><?php if (strlen($k_artist) == 1) {
                                                                    echo "0";
                                                                } else {
                                                                }; ?><?php echo $k_artist; ?></span>
 									</div>-->
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 album-outer-coontainer" style="padding:0px !important;">
                                                    <div class="album_cover">
                                                        <?php
                                                        if ($artist_img != "") {
                                                            $img_api_linka = album_img_api($artist_img);

                                                            if ($img_api_linka != '') { ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><img src="<?php echo get_small_thumb($artist_img); ?>" border="0" width="120" title="<?php echo $artist_name; ?>" /></a>

                                                            <?php } else { ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo 'thumb_' . $artist_img; ?>" border="0" width="120" /></a>

                                                            <?php
                                                            }
                                                        } else
											if ($req_artist) {
                                                            ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><img src="<?php echo $req_artist['artist_array']['image4']; ?>" border="0" width="100" /></a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="120" /></a>
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php if ($all_avg != 0) {
                                                        ?><cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                        echo number_format($all_avg, 1);
                                                                                                                    } else {
                                                                                                                        echo $all_avg;
                                                                                                                    } ?></cite><?php } else { ?> <cite style="background-color:#dd554e;">0.0</cite><?php } ?>
                                                        <div style="position:inherit; z-index:10; float:right; color:#FFFFFF; margin-top:-20px; margin-right:3px;"><?php echo $k_artist; ?></div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 album-detail-container" style="padding:0px !important;">
                                                    <div class="album_details" style="margin-top:0;">
                                                        <label class="title"><a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 20);
                                                                                                                                                            if (strlen($artist_name) > 20) {
                                                                                                                                                                echo "...";
                                                                                                                                                            } ?><?php //echo $artist_name;
                                                                                                                                                            ?></a></label>
                                                        <p><label class="likes" style=" float:left;">
                                                                <?php
                                                                if ($user_id != "") {
                                                                    $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$id'";
                                                                    $counter = array();
                                                                    $counter = \App\Models\Songs::GetRawData($qry);
                                                                    if ($counter) {
                                                                        $counter = count($counter);
                                                                    } else {
                                                                        $counter = 0;
                                                                    }
                                                                    if ($counter == 0) { ?>
                                                                        <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_artist; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                                        <span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_artist; ?>')" class="like"><i class="fa fa-heart heart_color heart_size"></i></a> <span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                                        <span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>">
                                                                        <?php
                                                                        if ($user_id == "") {
                                                                        ?>
                                                                            <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_artist; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                } ?></a></span>
                                                                    <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>
                                                                <?php } ?>
                                                            </label></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </li>
                            <?php
                                $k_artist++;
                            }
                        } else { ?> <p style="color:#333; padding:5px;"> No records found.</p><?php } ?>
                    </ul>
                    <!--ALBUMS-->
                    <div class="brows-label-penel search_bread_crumb_bottom">
                        <div class="row">
                            <?php
                            $artist_list_arr = array();

                            $artist_list = "select * FROM   tbl_artist_album  where 1=1 AND album_title LIKE '%$srch_search_sess%' AND  (CONCAT(album_title) LIKE '%$srch_search_sess%') group by album_title order by album_title = '$srch_search_sess' desc, album_title = '$first_word' desc limit 50";

                            $artist_list_arr = \App\Models\Songs::GetRawData($artist_list);
                            if ($artist_list_arr) {

                                $album_count  = count($artist_list_arr);
                            } else {
                                $album_count = 0;
                            }

                            //echo "album count => $album_count </br>";		
                            ?>
                            <div class="col-xs-6">
                                <ul class="list-inline">
                                    <li>ALBUMS <span class="active">(<?php echo $album_count; ?>)</span></li>
                                </ul>
                            </div>
                            <div class="col-xs-6 search_see_all">
                                <ul class="list-inline">
                                    <li><a href="<?php echo SERVER_ROOTPATH; ?>searcher-results-album" aria-controls="album" class="active">See All</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <ul class="songlistings">
                        <?php
                        $artist_list_arr = array_slice($artist_list_arr, 0, 5);

                        if (isset($artist_list_arr)) {
                            $k_album = 1;
                            foreach ($artist_list_arr as $val) {
                                $val = (array)$val;
                                
                                $id      = $val['id'];
                                $db_art_id    =     $val['art_id'];
                                $album_title = stripslashes(html_entity_decode($val['album_title']));
                                $artist_name = stripslashes(html_entity_decode($val['artist_name']));
                                $album_picture   = stripslashes(html_entity_decode($val['album_picture']));
                                $album_artist_id = stripslashes(html_entity_decode($val['album_artist_id']));
                                 $album_seo  = strtolower(stripslashes(html_entity_decode($val['album_seo'])));

                                //	$req_artist  =  artist_album_func("$artist_name",stripslashes(html_entity_decode($val['album_title'])));
                                $album_title = wordwrap($album_title, 100, " ", true);
 
                                $artist_data = GetArtistByAlbumId($id);

                                $artist_seo = strtolower($artist_data['artist_seo']);
                                $artist_name = strtolower($artist_data['artist_name']);

                                $qry =  "select id from tbl_likes where like_type = 'artist' AND like_id = '$db_art_id'";
                                $counter_main = array();
                                $counter_main = \App\Models\Songs::GetRawData($qry);
                                if ($counter_main) {
                                    $counter_main = count($counter_main);
                                } else {
                                    $counter_main = 0;
                                }

                                $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where album_id = $id AND status = 1";
                                $rate_arr    =    \App\Models\Songs::GetRawData($sum_rating);
                                if ($rate_arr) {
                                    $rate_arr = (array) $rate_arr[0];
                                    $sum_rate = $rate_arr['sum_rate'];
                                    $counter = $rate_arr['counter'];
                                } else {
                                    $sum_rate = 0;
                                    $counter = 0;
                                    $all_avg = 0;
                                }


                                if ($sum_rate == "" || $sum_rate == 0 || $counter == '' || $counter == 0) {
                                    $sum_rate = 0;
                                    $counter = 0;
                                    $all_avg = 0;
                                } else {

                                    $all_avg  =  $sum_rate / $counter;
                                }


                                if ($all_avg == "") {
                                    $all_avg = 0;
                                }

                                if ($all_avg >= 8) {
                                    $color_pick = "#5cb85c";
                                }

                                if ($all_avg >= 6 && $all_avg < 8) {
                                    $color_pick = "#5cb85c";
                                }

                                if ($all_avg >= 4 && $all_avg < 6) {
                                    $color_pick = "#e06d21";
                                }

                                if ($all_avg >= 2 && $all_avg < 4) {
                                    $color_pick = "#d9534f";
                                }

                                if ($all_avg > 0 && $all_avg < 2) {
                                    $color_pick = "#d9534f";
                                }


                                if ($all_avg >= 7) {
                                    $color_pick = "#5ebd5e";
                                }
                                if ($all_avg >= 4 && $all_avg <= 6) {
                                    $color_pick = "#e06d21";
                                }
                                if ($all_avg >= 0 && $all_avg <= 3) {
                                    $color_pick = "#dd554e";
                                }

                                $c++;
                                $sr_no++;


                                $songs_list = "select a.artist_seo,a.artist_name from  tbl_artist_album b,tbl_songs_artist_album saa, tbl_artists a where 1=1 AND saa.album_id = b.id AND  b.album_title = '" .  $album_title . "' AND a.id = saa.artist_id AND saa.display_status = 1";


                                $various = \App\Models\Songs::GetRawDataAdmin($songs_list);
                              


                        ?>

                                <li>
                                    <?php if ($mobile_view == 0) { ?>

                                        <div class="row mobileview0">
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                <span class="list_no"><?php if (strlen($k_album) == 1) {
                                                                            echo "0";
                                                                        } else {
                                                                        }; ?><?php echo $k_album; ?></span>
                                            </div>
                                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
                                                <div class="album_cover">
                                                    <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>" class="text_grey"><?php
                                                                                                                                                        if ($album_picture != "") {
                                                                                                                                                            $img_api_link = album_img_api($album_picture);
                                                                                                                                                            if ($img_api_link != '') {
                                                                                                                                                        ?>
                                                                <img src="<?php echo $album_picture; ?>" border="0" width="120" />
                                                            <?php } else {  ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="120" />
                                                            <?php
                                                                                                                                                            }
                                                                                                                                                        } else
													if ($album_picture == "") {
                                                                                                                                                            $req_artist  =  artist_album_func("$artist_name", stripslashes(html_entity_decode($val['album_title'])));
                                                                                                                                                            if ($req_artist['album_array']['image4'] != "") {
                                                            ?>
                                                                <img src="<?php echo $req_artist['album_array']['image4']; ?>" border="0" width="120" />
                                                            <?php
                                                                                                                                                            } else {
                                                            ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="120" />
                                                        <?php
                                                                                                                                                            }
                                                                                                                                                        }
                                                        ?>
                                                    </a>
                                                    <!--<cite style="background-color:#5ebd5e">8.0</cite>-->
                                                    <?php if ($all_avg != 0) { ?><cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                                                echo number_format($all_avg, 1);
                                                                                                                                            } else {
                                                                                                                                                echo $all_avg;
                                                                                                                                            } ?></cite><?php } else { ?>
                                                        <cite style="background-color:#dd554e">0.0</cite>
                                                    <?php } ?>
                                                </div>
                                                <div class="album_details" style="margin-top:0; padding: 2% 0 0 4%;">
                                                    <!--Desktop-->
                                                    <label class="review_screen_txt title" style="margin-bottom:5px;"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><?php echo substr($album_title, 0, 50);
                                                                                                                                                                                                        if (strlen($album_title) > 50) {
                                                                                                                                                                                                            echo "...";
                                                                                                                                                                                                        } ?></a></label>
                                                    <!--Ipad-->
                                                    <label class="review_ipad_txt title" style="margin-bottom:5px;"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><?php echo substr($album_title, 0, 14);
                                                                                                                                                                                                    if (strlen($album_title) > 14) {
                                                                                                                                                                                                        echo $album_title . "...";
                                                                                                                                                                                                    } ?></a></label>

                                                    <div>
                                                        <label class="author" style=" float:left;"><?php
                                                                                                    if ($various['artist_name'] != "") {
                                                                                                    ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . Slug($various['artist_seo']) . "/artist-songs"; ?>"><?php echo substr($various['artist_name'], 0, 32);
                                                                                                                                                            if (strlen($various['artist_name']) > 32) {
                                                                                                                                                                echo $various['artist_name'] . "...";
                                                                                                                                                            } ?><?php //echo $various['artist_name'];
                                                                                                                                                        ?></a>
                                                            <?php
                                                                                                    } else {
                                                            ?> <a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 32);
                                                                                                                                                if (strlen($artist_name) > 32) {
                                                                                                                                                    echo "...";
                                                                                                                                                } ?><?php //echo $artist_name;
                                                                                                                                            ?></a>
                                                            <?php
                                                                                                    }
                                                            ?></label>
                                                        <label class="likes" style="margin-top:-9px;">
                                                            <?php
                                                            if ($user_id != "") {
                                                                $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$db_art_id'";
                                                                $counter = array();
                                                                $counter = \App\Models\Songs::GetRawData($qry);
                                                                if ($counter) {
                                                                    $counter = count($counter);
                                                                } else {
                                                                    $counter = 0;
                                                                }
                                                                if ($counter == 0) {
                                                            ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $db_art_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $db_art_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_album; ?>')" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i> </a><span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                                    <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $db_art_id; ?>"></span>

                                                                <?php
                                                                } else { ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $db_art_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $db_art_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_album; ?>')" class="like link-disable"><i class="fa fa-heart heart_color heart_size"></i></a> <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                                    <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $db_art_id; ?>"></span>
                                                                <?php
                                                                }
                                                            } else { ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $db_art_id; ?>">
                                                                    <?php
                                                                    if ($user_id == "") {
                                                                    ?>
                                                                        <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $db_art_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_album; ?>')" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                                                <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $db_art_id; ?>"></span>
                                                            <?php
                                                            } ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } else if ($mobile_view == 1) { ?>

                                        <div class="row mobileview1">
                                            <!--<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
 										<span class="list_no"><?php if (strlen($k_album) == 1) {
                                                                    echo "0";
                                                                } else {
                                                                }; ?><?php echo $k_album; ?></span>
 									</div>-->
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 album-outer-coontainer" style="padding:0px !important;">
                                                    <div class="album_cover">
                                                        <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>" class="text_grey"><?php
                                                                                                                                                            if ($album_picture != "") {
                                                                                                                                                                $img_api_link = album_img_api($album_picture);
                                                                                                                                                                if ($img_api_link != '') {
                                                                                                                                                            ?>
                                                                    <img src="<?php echo $album_picture; ?>" border="0" width="120" />
                                                                <?php } else {  ?>
                                                                    <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="120" />
                                                                <?php
                                                                                                                                                                }
                                                                                                                                                            } else
													if ($album_picture == "") {
                                                                                                                                                                $req_artist  =  artist_album_func("$artist_name", stripslashes(html_entity_decode($val['album_title'])));
                                                                                                                                                                if ($req_artist['album_array']['image4'] != "") {
                                                                ?>
                                                                    <img src="<?php echo $req_artist['album_array']['image4']; ?>" border="0" width="120" />
                                                                <?php
                                                                                                                                                                } else {
                                                                ?>
                                                                    <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="120" />
                                                            <?php
                                                                                                                                                                }
                                                                                                                                                            }
                                                            ?>
                                                        </a>
                                                        <?php
                                                        if ($all_avg != 0) {
                                                        ?><cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                        echo number_format($all_avg, 1);
                                                                                                                    } else {
                                                                                                                        echo $all_avg;
                                                                                                                    } ?></cite><?php } else { ?>
                                                            <cite style="background-color:#dd554e">0.0</cite>
                                                        <?php } ?>
                                                        <div style="position:inherit; z-index:10; float:right; color:#FFFFFF; margin-top:-20px; margin-right:3px;"><?php echo $k_album; ?></div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 album-detail-container" style="padding:0px !important;">
                                                    <div class="album_details" style="margin-top:0;">
                                                        <label class="title"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><?php echo substr($album_title, 0, 32);
                                                                                                                                                                if (strlen($album_title) > 32) {
                                                                                                                                                                    echo "...";
                                                                                                                                                                } ?></a></label>
                                                        <label class="author"><?php
                                                                                if ($various['artist_name']) {
                                                                                ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . Slug($various['artist_seo']) . "/artist-songs"; ?>"><?php echo substr($various['artist_name'], 0, 32);
                                                                                                                                                            if (strlen($various['artist_name']) > 32) {
                                                                                                                                                                echo "..";
                                                                                                                                                            } ?><?php //echo $various['artist_name'];
                                                                                                                                                        ?></a>
                                                            <?php
                                                                                } else {
                                                            ?> <a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 32);
                                                                                                                                                if (strlen($artist_name) > 32) {
                                                                                                                                                    echo "..";
                                                                                                                                                } ?><?php //echo $artist_name;
                                                                                                                                            ?></a>
                                                            <?php
                                                                                }
                                                            ?></label><br>
                                                        <label class="likes" style="float:left; height:26px;">
                                                            <?php
                                                            if ($user_id != "") {
                                                                $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$db_art_id'";
                                                                $counter = array();
                                                                $counter = \App\Models\Songs::GetRawData($qry);
                                                                if ($counter) {
                                                                    $counter = count($counter);
                                                                } else {
                                                                    $counter = 0;
                                                                }
                                                                if ($counter == 0) {
                                                            ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $db_art_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $db_art_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_album; ?>')" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i> </a><span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                                    <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $db_art_id; ?>"></span>

                                                                <?php
                                                                } else { ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $db_art_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $db_art_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_album; ?>')" class="like link-disable"><i class="fa fa-heart heart_color heart_size"></i></a> <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                                    <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $db_art_id; ?>"></span>
                                                                <?php
                                                                }
                                                            } else { ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $db_art_id; ?>">
                                                                    <?php
                                                                    if ($user_id == "") {
                                                                    ?>
                                                                        <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $db_art_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_album; ?>')" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                                                <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $db_art_id; ?>"></span>
                                                            <?php
                                                            } ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </li>
                            <?php
                                $k_album++;
                            }
                        } else { ?> <p style="color:#333; padding:5px;"> No records found.</p><?php } ?>
                    </ul>
                </div>


                @include("common.common_popular_review")

                <!-- Advertisement Banner Start-->
                <div class="clear"></div>
                <div class="container" style="padding:20px 0 20px 0;">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-0 col-xs-0 artist_screen">&nbsp;</div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="text-align:center;">
                            <?php echo ads_info('Bottom'); ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-0 col-xs-0 artist_screen">&nbsp;</div>
                    </div>
                </div>
                <!--Advertisement Banner End-->
            </div>
        </div>
    </div>
</section>
@include("common.signin_modal")
<?php


//include_once("common/popular_review.php");
?>
<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo SERVER_ROOTPATH; ?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
    var jq = jQuery.noConflict();
</script>
<script type="text/javascript" src="<?php echo SERVER_ROOTPATH; ?>js/bootstrap.js"></script>
<style type="text/css">
    body {
        overflow-x: hidden;
    }
</style>
</body>


<script>
    jQuery('h3').each(function() {

        var h3 = $(this);

        h3.html(
            h3.text().replace(
                '<?php echo  session()->get('main_search'); ?>',
                '<span class="myClass"><?php echo session()->get('main_search'); ?></span>'
            )
        );

    });
</script>
<script type="text/javascript">
    function unset_all() {
        $.ajax({
            type: "POST",
            url: 'process/destroysession.php',
            data: 'sure=1',


            success: function(msg) {
                if (msg.search('done') != -1) {
                    window.location.href = 'search';
                } else {
                    alert(msg);
                }
            },
            error: function() {}
        });
        /* 	location.reload(true);	*/
    }
</script>


</html>

<div class="modal fade" id="show_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<div class="modal fade" id="create_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
@include("common.footer")