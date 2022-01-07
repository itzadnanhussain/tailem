<style>
    .cite-margin-top {
        margin-top: -5px;
    }
</style>
<div class="latestsongssec">
    <div class="container topsongssecs">
        <h2 class="sec_heading marginbot30" style="margin-top: 35px;">
            <div style="width:300px;margin-left:auto;margin-right:auto"> <i style="float:left"
                    class="sprite sprite-icon_musichead"></i> <a href="https://www.tailem.com/latest-songs"
                    style="color:#2b2b2b" onMouseOver="this.style.color='#70857b'"
                    onMouseOut="this.style.color='#2b2b2b'">Latest Songs</a></div>

        </h2>
        <div class="listslider">
            <div id="owl-carousel1" class="owl-carousel">
                <?php
                ///define latest song array
                $latest_song_arr = array();
                $latest_song_arr    =   App\Models\Songs::GetLatestSongsArray();
                

                if (isset($latest_song_arr) && !empty($latest_song_arr)) {
                    $c = 0;
                    $sno_val = 0;
                    foreach ($latest_song_arr as $val) {
                        $sno_val++;
                        $song_id        = $val->songid;
                        // if($song_id == 455052072) {

                        $rate_arr = array();
                        $rate_arr = App\Models\Songs::GetRawQuery('reviews', 'sum(review_rating) as sum_rate, count(*) as counter, sum(review_rating>=8) as excellent, sum(review_rating>=7 && review_rating<8) as verygood, sum(review_rating>=4 && review_rating<7) as good,sum(review_rating>=2 && review_rating<4) as poor,sum(review_rating>0 && review_rating<2) as terrible', array('song_id' => $song_id, 'status' => 1));
                        // echo '<pre>';
                        // print_r($song_id);
                        // echo '</pre>';
                        // die;
                        $rate_arr = (array)$rate_arr[0];


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
                        }
                        if ($sum_rate == "" || $sum_rate == 0) {
                            $sum_rate = 0;
                        }
                        if ($counter > 0) {
                            $all_avg  =  $sum_rate / $counter;
                        } else {
                            $all_avg = 0;
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
                        if ($all_avg >= 4 && $all_avg < 7) {
                            $color_pick = "#e06d21";
                        }
                        if ($all_avg >= 2 && $all_avg < 4) {
                            $color_pick = "#dd554e";
                        }
                        if ($all_avg > 0 && $all_avg < 2) {
                            $color_pick = "#dd554e";
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
                        $all_avg = number_format($all_avg, 1);
                        /*end calculating songs reviews*/


                        ///code one comment
                        $other_details    = App\Models\Songs::GetOtherDetails($song_id);
                        // echo '<pre>';
                        // print_r($other_details);
                        // echo '</pre>';
                        // die;
                        if (isset($other_details) && !empty($other_details)) {
                            $db_song_id = $song_id;
                            $song_title     = stripslashes(html_entity_decode($val->song_title));
                            $artist_seo     = strtolower(stripslashes(html_entity_decode($other_details[0]->artist_seo)));
                            $song_seo         = strtolower(stripslashes(html_entity_decode($val->song_seo)));
                            //$song_ratings   = stripslashes(html_entity_decode($val['rate_song']));
                            $artist_id        = stripslashes(html_entity_decode($other_details[0]->artist_id));
                            $artist_name    = stripslashes(html_entity_decode($other_details[0]->artist_name));






                            //code two comment
                            $latest_song_likes_info = App\Models\Songs::GetRawQuery('likes', 'count(id) as a_likes_count', array('like_id' => $artist_id, 'like_type' => 'artist'));
                            $latest_song_likes_info = (array)$latest_song_likes_info[0];
                            $ar_likes                 = $latest_song_likes_info['a_likes_count'];


                            //code 3 comment
                            // $db_song_id = 3;
                            $qry_feature_arr = App\Models\Songs::GetFeatureArr($db_song_id);


                            $count  = count($qry_feature_arr);
                            $num = 1;
                            $feature_artists = "";
                            if ($qry_feature_arr) {
                                $sum_len = 0;
                                $feature_artists .= "<a style='color:#08aa90'> ft.  </a>";
                                foreach ($qry_feature_arr as $val_feature) {
                                    $val_feature->f_artist_seo = strtolower($val_feature->f_artist_seo);
                                    if ($num == $count) {
                                        $str_length = strlen($val_feature->feature_artist);
                                        $sum_len = $sum_len + $str_length;
                                        if ($sum_len > 15) {
                                            $feature_art  = substr($val_feature->feature_artist, 0, 1) . "...";
                                            $feature_artists .= " <a style='color:#08aa90' href='" . SERVER_ROOTPATH . $val_feature->f_artist_seo . "/artist-songs'>" . $feature_art . "</a>";
                                            break;
                                        } else {
                                            $feature_art  = $val_feature->feature_artist;
                                            $feature_artists .= " <a style='color:#08aa90' href='" . SERVER_ROOTPATH . $val_feature->f_artist_seo . "/artist-songs'>" . $feature_art . "</a>";
                                        }
                                    } else {
                                        $str_length = strlen($val_feature->feature_artist);
                                        $sum_len = $sum_len + $str_length;
                                        if ($sum_len > 15) {
                                            $feature_art  = substr($val_feature->feature_artist, 0, 1) . "...";
                                            $feature_artists .= " <a style='color:#08aa90' href='" . SERVER_ROOTPATH . $val_feature->f_artist_seo . "/artist-songs'>" . $feature_art . "</a>";
                                            break;
                                        } else {
                                            $feature_art  = $val_feature->feature_artist;
                                            $feature_artists .= " <a style='color:#08aa90' href='" . SERVER_ROOTPATH . $val_feature->f_artist_seo . "/artist-songs'>" . $feature_art . "</a>,";
                                        }
                                    }
                                    $num++;
                                }
                            } ?>

                <div>
                    <div class="list_item ad">
                        <div class="album_cover">
                            <?php if ($val->picture != '') {
                                $img_api_link = album_img_api($val->picture);
                                if ($img_api_link != '') { ?>
                            <img src="<?php echo $img_api_link; ?>">
                            <?php } else { ?>
                            <a
                                href="<?php echo SERVER_ROOTPATH  . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>">
                                <p
                                    title="<?php echo $song_title; ?>">
                                    <img class="img-responsive"
                                        src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo $val->picture; ?>"
                                        border="0"
                                        title="<?php echo $val->picture; ?>"
                                        style="height:300px;" />
                            </a>
                            <?php
                                            }
                            } else { ?>
                            <a
                                href="<?php echo SERVER_ROOTPATH  . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>">
                                <p
                                    title="<?php echo $song_title; ?>">
                                    <img src="<?php echo COOKIE_FREE_ROOTPATH; ?>assets/images/no_image4.png"
                                        class="img-responsive" border="0" style="height:300px;" />
                            </a>
                            <?php } ?>


                            <cite class="cite-margin-top"
                                style="background-color:<?php echo $color_pick ?>"><?php if ($all_avg == 10) {
                                echo number_format($all_avg, 0);
                            } else {
                                echo $all_avg;
                            } ?>
                            </cite>
                            <!-- <a style="color:#000;font-weight:400;background:0 0;color:#fff;font-size:12px;padding:12px 5px;position:absolute;right:5px;top:50px"><span class="red-text"><i><?php echo $counter; ?></i></span>
                            Reviews</a> -->
                        </div>
                        <div class="list_bottom">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-7">
                                    <?php
                                                $length_song = strlen($song_title); ?>
                                    <a
                                        href="<?php echo SERVER_ROOTPATH  . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>">
                                        <p
                                            title="<?php echo $song_title; ?>">
                                            <?php echo substr($song_title, 0, 28);
                            if ($length_song > 28) {
                                echo "..";
                            } ?>
                                        </p>
                                    </a>
                                    <cite class="cite-margin-top">
                                        <a style="color:#08aa90"
                                            href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo  $artist_name; ?></a>
                                        <?php echo $feature_artists; ?>
                                    </cite>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                    <?php
                                                if ($user_id != "") {
                                                    // $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  like_type = 'artist' AND like_id = '$artist_id'"));
                                                    $counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  like_type = 'artist' AND like_id = '$artist_id'");
                                                    if ($counter) {
                                                        $counter = count($counter);
                                                    } else {
                                                        $counter = 0;
                                                    }

                                                    if ($counter > 0) {
                                                        $class = "like-group liked";
                                                    } else {
                                                        $class = "like-group";
                                                    }
                                                    if ($counter == 0) {
                                                        ?>
                                    <span style="float:right;"
                                        class="<?php echo $class; ?>"
                                        id="other_dis_sub_popular_<?php echo $artist_id; ?>_<?php echo $sno_val; ?>"><a
                                            href="javascript:;"
                                            onClick="add_in_favourite_list_sub_artist_popular_latest('<?php echo $artist_id; ?>','<?php echo $sno_val; ?>','<?php echo $artist_seo; ?>')"><i
                                                class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>
                                        <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                            data-toggle="modal" data-target="#artist_modal" data-title=""
                                            class="link-disable" style="color:#fff;"> <?php echo $ar_likes; ?><?php if ($ar_likes < 2) {
                                                            echo " Like";
                                                        } else {
                                                            echo " Likes";
                                                        } ?>
                                        </a>
                                    </span>
                                    <span style="float:right;" class="like-group liked"
                                        id="myStyle_sub_popular_<?php echo $artist_id; ?>_<?php echo $sno_val; ?>"></span>
                                    <?php
                                                    } else {
                                                        ?>
                                    <span style="float:right;"
                                        class="<?php echo $class; ?>"
                                        id="other_dis_sub_popular_<?php echo $artist_id; ?>_<?php echo $sno_val; ?>">
                                        <a href="javascript:;"
                                            onClick="add_in_favourite_list_sub_artist_popular_latest('<?php echo $artist_id; ?>','<?php echo $sno_val; ?>','<?php echo $artist_seo; ?>')"><i
                                                class="fa fa-heart" style="font-size:24px;"></i></a>
                                        <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                            data-toggle="modal" data-target="#artist_modal" data-title=""
                                            class="link-disable" style="color:#fff;"> <?php echo $ar_likes; ?><?php if ($ar_likes < 2) {
                                                            echo " Like";
                                                        } else {
                                                            echo " Likes";
                                                        } ?>
                                        </a></span>
                                    <span style="float:right;" class="like-group liked"
                                        id="myStyle_sub_popular_<?php echo $artist_id; ?>_<?php echo $sno_val; ?>"></span>
                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                    <span style="float:right;" class="like-group">
                                        <?php
                                                        if ($user_id == "") {
                                                            ?>
                                        <a href="#" data-toggle="modal" data-target="#signin_form"><i
                                                class="fa fa-heart-o text_grey"
                                                style="font-size:24px; color:#D73B3B;"></i></a>

                                        <?php
                                                        } else {
                                                            ?>
                                        <a href="javascript:;"
                                            onClick="add_in_favourite_list_sub_artist_popular_latest('<?php echo $artist_id; ?>','<?php echo $sno_val; ?>','<?php echo $artist_seo; ?>')"><i
                                                class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>
                                        <?php
                                                        } ?>

                                        <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                            data-toggle="modal" data-target="#artist_modal" data-title=""
                                            class="like link-disable" style="margin-left:4px;color:#fff;"> <?php echo $ar_likes; ?><?php if ($ar_likes < 2) {
                                                            echo " Like";
                                                        } else {
                                                            echo " Likes";
                                                        } ?>
                                        </a>
                                    </span>
                                    <?php
                                                } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                        }
                    }
                    // }
                } ?>

            </div>
        </div>
    </div>
</div>