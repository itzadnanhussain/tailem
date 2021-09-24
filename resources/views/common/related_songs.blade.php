<div class="latestsongssec">
    <div class="container topsongssecs">
        <div class="listslider">
            <div id="owl-carousel1" class="owl-carousel">
                <?php
                error_reporting(0);
                $song_list_arr  = array();

                if (empty($song_list_arr)) {
                    $qry = "select b.album_artist_id,s.song_title,s.updated_by_itunes,s.picture,s.song_seo,a.artist_seo,a.artist_name,a.id as artistid,b.album_title, b.album_picture, s.id,s.description from tbl_artist_album b, tbl_artists a, tbl_songs_artist_album saa, tbl_songs s where 1=1 AND s.id = saa.song_id AND a.id = saa.artist_id AND saa.display_status = 1 AND b.id = saa.album_id AND saa.album_id = '$album_id' AND saa.song_id != $id AND saa.artist_id != 67 AND s.song_status = 1   group by s.id order by rand() limit 3";
                    $song_list_arr    =    \App\Models\Songs::GetRawData($qry);




                    if (empty($song_list_arr)) {
                        $related_song_list = "select b.album_artist_id,s.song_title,s.updated_by_itunes,s.song_seo,a.artist_seo,a.artist_name,a.id as artistid,s.picture,b.album_title, b.album_picture, s.id,s.description from tbl_artist_album b, tbl_artists a, tbl_songs_artist_album saa, tbl_songs s where 1=1 AND s.id = saa.song_id AND a.id = saa.artist_id AND b.id = saa.album_id AND saa.artist_id = $album_artist_id AND saa.song_id != $id AND saa.artist_id != 67 AND saa.display_status = 1 AND s.song_status = 1 group by s.id order by  rand() limit 3";
                        $song_list_arr    =    \App\Models\Songs::GetRawData($related_song_list);


                        if (empty($song_list_arr)) {
                            $related_song_list = "select b.album_artist_id,s.song_title,s.updated_by_itunes,s.song_seo,a.artist_seo,s.picture,a.artist_name,a.id as artistid,b.album_title, b.album_picture, s.id,s.description from tbl_artist_album b, tbl_artists a, tbl_songs_artist_album saa, tbl_songs s where 1=1 AND s.id = saa.song_id AND a.id = saa.artist_id AND b.id = saa.album_id AND saa.song_id != $id AND saa.artist_id != 67 AND saa.display_status = 1 AND s.song_status = 1 group by s.id order by  rand() limit 3";
                            $song_list_arr    =    \App\Models\Songs::GetRawData($related_song_list);
                        }
                    }
                }

                if (!empty($song_list_arr)) {
                    $song_list_arr = (array)$song_list_arr[0];
                    $max =    count($song_list_arr) - 1;

                    for ($vv = 0; $vv <= $max; $vv++) {
                        $song_list_arr_new[$vv] = $song_list_arr[$vv];
                    }

                    unset($song_list_arr);
                    $song_list_arr = $song_list_arr_new;
                }
                if (isset($song_list_arr)) {
                    $rep = 0;
                    $g = 0;
                    $p_fav = 0;
                    $sr_no = 0;
                    $k_s = 1;
                    foreach ($song_list_arr as $val) {

                        $sr_no++;
                        $k_s++;
                        $g++;
                        $p_fav++;
                        $rep++;
                        $id      = $val['id'];
                        $album_title = stripslashes(html_entity_decode($val['album_title']));
                        $artist_name = stripslashes(html_entity_decode($val['artist_name']));
                        $artistid    = stripslashes(html_entity_decode($val['artistid']));
                        $album_picture   = stripslashes(html_entity_decode($val['album_picture']));
                        $picture   = stripslashes(html_entity_decode($val['picture']));
                        $song_title = stripslashes(html_entity_decode($val['song_title']));
                        $artist_seo = strtolower(stripslashes(html_entity_decode($val['artist_seo'])));
                        $song_seo   = strtolower(stripslashes(html_entity_decode($val['song_seo'])));
                        $db_album_artist_id   = strtolower(stripslashes(html_entity_decode($val['album_artist_id'])));
                        if ($picture == '' &&  $val['updated_by_itunes'] == '0000-00-00 00:00:00') {
                            $req_song  =  artist_album_song_func($artist_name, $song_title);
                        }
                        $album_title = wordwrap($album_title, 100, " ", true);
                        $artist_name = wordwrap($artist_name, 100, " ", true);


                        $mainartist_arr    =    mainartist_detail($db_album_artist_id);
                        $artist_name = stripslashes($mainartist_arr['artist_name']);
                        $artist_seo     = stripslashes($mainartist_arr['artist_seo']);

                        $rate_arr  = array();


                        if (isset($id)) {

                            $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = $id AND status = 1";
                            $rate_arr    =    \App\Models\Songs::GetRawData($sum_rating);
                        }

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


                        $qry = "select id from tbl_likes where like_type = 'artist' AND like_id = '$album_artist_id'";
                        $counter_main = array();
                        $counter_main = \App\Models\Songs::GetRawData($qry);
                        if ($counter_main) {
                            $counter_main = count($counter_main);
                        } else {
                            $counter_main = 0;
                        }


                        $qry_top_feature_artist  = array();
                        $qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '" . $id . "'";

                        $qry_feature_arr = \App\Models\Songs::GetRawData($qry_top_feature_artist);
                        if ($qry_top_feature_artist) {
                            $count  = count($qry_feature_arr);
                        } else {
                            $count  = 0;
                        }



                        $num = 1;

                        $feature_artists = "";

                        if ($qry_feature_arr) {



                            $feature_artists .= "ft.";



                            $sum_len = 0;

                            foreach ($qry_feature_arr as $val_feature) {
                                $val_feature = (array)$val_feature;

                                $val_feature['f_artist_seo'] = strtolower($val_feature['f_artist_seo']);

                                if ($num == $count) {

                                    $str_length = strlen($val_feature['feature_artist']);

                                    $sum_len = $sum_len + $str_length;

                                    if ($sum_len > 13) {

                                        $feature_art  = substr($val_feature['feature_artist'], 0, 1) . "...";

                                        $feature_artists .= " <a style='color:#d73b3b' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";

                                        break;
                                    } else {

                                        $feature_art  = $val_feature['feature_artist'];

                                        $feature_artists .= " <a style='color:#d73b3b' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";
                                    }
                                } else {

                                    $str_length = strlen($val_feature['feature_artist']);

                                    $sum_len = $sum_len + $str_length;



                                    if ($sum_len > 13) {

                                        $feature_art  = substr($val_feature['feature_artist'], 0, 4) . "...";

                                        $feature_artists .= " <a style='color:#d73b3b' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>";

                                        break;
                                    } else {

                                        $feature_art  = $val_feature['feature_artist'];

                                        $feature_artists .= " <a style='color:#d73b3b' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $feature_art . "</a>, ";
                                    }
                                }

                                $num++;
                            }
                        }

                ?>

                        <div>
                            <div class="list_item">
                                <div class="album_cover">
                                    <a href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>"> <?php
                                                                                                                        if ($picture != "") {

                                                                                                                            $song_pic = SERVER_ROOTPATH . "site_upload/song_images/thumb_" . $picture;
                                                                                                                            $img_api_link = album_img_api($picture);
                                                                                                                            if ($img_api_link != '') {
                                                                                                                        ?>
                                                <img src="<?php echo $img_api_link; ?>" class="img-responsive" style="height:262px;" />
                                            <?php } else { ?>
                                                <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo $picture; ?>" class="img-responsive" style="height:262px;" />
                                            <?php
                                                                                                                            }
                                                                                                                        } else
											if ($picture == "") {

                                                                                                                            if ($req_song['song_array']['image4'] != "") {
                                            ?>
                                                <img class="img-responsive" src="<?php echo $req_song['song_array']['image4']; ?>" border="0" style="height:262px;" />
                                            <?php
                                                                                                                            } else
												if ($album_picture != "") {
                                            ?>
                                                <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo $album_picture; ?>" border="0" class="img-responsive" style="height:262px;" />
                                            <?php
                                                                                                                            } else {
                                            ?>
                                                <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" class="img-responsive" style="height:262px;" />
                                        <?php
                                                                                                                            }
                                                                                                                        }
                                        ?>
                                    </a>

                                    <?php
                                    if ($all_avg != 0) {
                                    ?><cite class="score" style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                    echo number_format($all_avg, 1);
                                                                                                                } else {
                                                                                                                    echo $all_avg;
                                                                                                                } ?></cite><?php } else { ?> <cite style="background-color:#dd554e">5.0</cite><?php } ?>
                                </div>
                                <div class="list_bottom">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-7 col-xs-7 pad_right">
                                            <a href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>">
                                                <p><?php echo $song_title; ?></p>
                                            </a>
                                            <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>">
                                                <cite2 style="margin-top:0;"><?php echo $artist_name; ?> </cite2>
                                            </a>

                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 pad_left txtalnright">
                                            <?php
                                            if ($user_id != "") {

                                                $qry =  "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$album_artist_id'";
                                                $counter = array();
                                                $counter = \App\Models\Songs::GetRawData($qry);
                                                if ($counter) {
                                                    $counter = count($counter);
                                                } else {
                                                    $counter = 0;
                                                }
                                                if ($counter == 0) {
                                            ?>
                                                    <span id="other_dis_sub_popular_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_popular('<?php echo $album_artist_id; ?>','<?php echo $p_fav; ?>','<?php echo $artist_seo; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="margin-left:4px;color:#fff;"><span> <?php echo $counter_main; ?></span><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                    <span id="myStyle_sub_popular_<?php echo $album_artist_id; ?>"></span>
                                                <?php
                                                } else {
                                                ?>
                                                    <span id="other_dis_sub_popular_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_popular('<?php echo $album_artist_id; ?>','<?php echo $p_fav; ?>','<?php echo $artist_seo; ?>')"><i class="fa fa-heart" style="color:#d73b3b; font-size:24px;;"></i></a><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" style="margin-left:4px; color:#fff;"><span> <?php echo $counter_main; ?></span><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                                    <span id="myStyle_sub_popular_<?php echo $album_artist_id; ?>"></span>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <span id="other_dis_sub_popular_<?php echo $album_artist_id; ?>">
                                                    <?php
                                                    if ($user_id == "") {
                                                    ?>
                                                        <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i> </a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a href="javascript:;" onClick="add_in_favourite_list_sub_artist_popular('<?php echo $album_artist_id; ?>','<?php echo $p_fav; ?>','<?php echo $artist_seo; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a>
                                                    <?php
                                                    }
                                                    ?>
                                                    <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="margin-left:4px; color:#fff;"><span> <?php echo $counter_main; ?></span><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                                <span id="myStyle_sub_popular_<?php echo $album_artist_id; ?>"></span>

                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php }
                }
                ?>
            </div>
        </div>
    </div>

</div>
<style>
    .topsongssecs .owl-controls {

        display: none !important;

    }
</style>