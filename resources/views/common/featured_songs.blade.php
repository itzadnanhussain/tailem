<style>
    .ad-feature-img {
        height: 408px !important;
    }

    .topsongssec .list_item .album_cover {
        height: 467px !important;
    }

    /* .owl-item {
        height: 470px !important;
    } */
</style>
<div id="owl-carousel2" class="owl-carousel">


    <?php
    $artist_list_arr = array();
    $artist_list_arr    =   App\Models\Songs::GetArtistListArray();
    // echo '<pre>';
    // print_r($artist_list_arr);
    // echo '</pre>';
    // die;


    if (isset($artist_list_arr) && !empty($artist_list_arr)) {
        $c = 0;
        $sno_val = 0;
        foreach ($artist_list_arr as $val) {
            $val = (array)$val;
            // echo '<pre>';
            // print_r($val);
            // echo '</pre>';
            // die;

            if ($val['artist_id'] != "") {
                $artist_info    =    App\Models\Songs::GetRawQuery('artists', 'artist_name,artist_seo', array('id' => $val['artist_id']));
                if ($artist_info) {
                    $sno_val++;
                    $id                = $val['id'];
                    $song_id        = $val['song_id'];
                    $song_title     = stripslashes(html_entity_decode($val['song_title']));
                    $main_artist    = stripslashes(html_entity_decode($val['artist_id']));
                    $album_id         = stripslashes(html_entity_decode($val['album_id']));
                    $song_rating    = stripslashes(html_entity_decode($val['rate_song']));
                    $artist_seo     = strtolower(stripslashes(html_entity_decode($artist_info[0]->artist_seo)));
                    $album_artist_id = stripslashes(html_entity_decode($val['artist_id']));
                    $song_seo         = strtolower(stripslashes(html_entity_decode($val['song_seo'])));
                    $album_title     = stripslashes(html_entity_decode($val['album_title']));
                    $picture              = stripslashes(html_entity_decode($val['picture']));
                    $album_picture     = stripslashes(html_entity_decode($val['album_picture']));
                    // $artist_name    = stripslashes(mysqli_escape_string($db->dbh, $artist_info[0]->artist_name));
                    $artist_name    = stripslashes($artist_info[0]->artist_name);


                    // $counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'artist' AND like_id = '$main_artist'"));
                    $counter_main    =    App\Models\Songs::GetRawQuery('likes', 'id', array('like_type' => 'artist', 'like_id' => $main_artist));
                    if ($counter_main) {
                        $counter_main = count($counter_main);
                    } else {
                        $counter_main = 0;
                    }

                    $qry_top_feature_artist = array();

                    if (empty($qry_top_feature_artist)) {
                        $qry_feature_arr    =    App\Models\Songs::GetFeatureArr($song_id);
                    }


                    $count  = count($qry_feature_arr);
                    $num = 1;
                    $feature_artists = "";
                    if (isset($qry_feature_arr) && !empty($qry_feature_arr)) {
                        $feature_artists .= "<a style='display: inline;'>ft. </a>";
                        $sum_len = 0;
                        foreach ($qry_feature_arr as $val_feature) {
                            $val_feature = (array)$val_feature;
                            if ($num == $count) {
                                $str_length = strlen($val_feature['feature_artist']);
                                $sum_len = $sum_len + $str_length;
                                if ($sum_len > 25) {
                                    $feature_art  = substr($val_feature['feature_artist'], 0, 1) . "...";
                                    $feature_artists .= " <a style='display: inline;' href='" . SERVER_ROOTPATH .   Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $feature_art . "</a>";
                                    break;
                                } else {
                                    $feature_art  = $val_feature['feature_artist'];
                                    $feature_artists .= "<a style='display: inline;' href='" . SERVER_ROOTPATH .   Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $feature_art . "</a>";
                                }
                            } else {
                                $str_length = strlen($val_feature['feature_artist']);
                                $sum_len = $sum_len + $str_length;
                                if ($sum_len > 25) {
                                    $feature_art  = substr($val_feature['feature_artist'], 0, 1) . "...";
                                    $feature_artists .= " <a style='display: inline;' href='" . SERVER_ROOTPATH .   Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $feature_art . "</a>";
                                    break;
                                } else {
                                    $feature_art  = $val_feature['feature_artist'];
                                    $feature_artists .= " <a style='display: inline;' href='" . SERVER_ROOTPATH .   Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $feature_art . "</a>,";
                                }
                            }
                            $num++;
                        }
                    }
                    /***************** For Song picture ************/
                    $image_get = "";
                    if ($picture != "") {
                        $image_get = $picture;
                        $image_get_new = album_img_api($image_get);
                    } elseif ($picture == "") {
                        $req_song  =  artist_album_song_func($artist_name, $song_title);
                        if ($req_song['song_array']['image5'] != "") {
                            $image_get = $req_song['song_array']['image5'];
                            $image_get_new = album_img_api($image_get);
                        } elseif ($album_picture != "") {
                            $image_get = $album_picture;
                            $image_get_new = album_img_api($image_get);
                            $image_get_new = "/site_upload/song_images/" . $image_get_new;
                        } else {
                            $image_get = COOKIE_FREE_ROOTPATH . 'assets/images/no_image.png';
                        }
                    }



                    if ($image_get_new != "") {
                        $image_get = $image_get_new;
                    }

                    $pos = strpos($image_get, 'http');
                    if ($pos === false) {
                        $image_get = "/site_upload/song_images/" . $image_get;
                    }

                    /******* For song name *****/
                    if (strlen($val['song_title']) >= '30') {
                        $song_title = substr($val['song_title'], 0, 30) . ' ...';
                    } else {
                        $song_title = $val['song_title'];
                    }
                    /**** For artist name *****/
                    if (strlen($artist_info[0]->artist_name) >= '20') {
                        $artist_name = substr($artist_info[0]->artist_name, 0, 20) . ' ...';
                    } else {
                        $artist_name = $artist_info[0]->artist_name;
                    }
                    $rate_arr = array();

                    if (empty($rate_arr)) {
                        $rate_arr = App\Models\Songs::GetRawQuery('reviews', 'sum(review_rating) as sum_rate, count(*) as counter, sum(review_rating>=8) as excellent, sum(review_rating>=7 && review_rating<8) as verygood, sum(review_rating>=4 && review_rating<7) as good,sum(review_rating>=2 && review_rating<4) as poor,sum(review_rating>0 && review_rating<2) as terrible', array('song_id' => $song_id, 'status' => 1));
                        $rate_arr = (array)$rate_arr[0];
                    }

                    $sum_rate = $rate_arr['sum_rate'];
                    $counter = $rate_arr['counter'];
                        
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
                    // echo $all_avg;
                    } elseif ($all_avg == "10") {
                        $all_avg = 10;
                    } else {
                        $all_avg = CheckNumberFormate($all_avg);
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

                    if ($song_rating >= 7) {
                        $color_picker = "#5ebd5e";
                    } elseif ($song_rating >= 4 && $song_rating <= 6.9) {
                        $color_picker = "#e06d21";
                    } elseif ($song_rating >= 0 && $song_rating <= 3.9) {
                        $color_picker = "#dd554e";
                    }
                    $all_avg = number_format($all_avg, 1);
                    /*end calculating songs reviews*/ ?>
    <div>
        <div class="list_item">
            <div class="album_cover">
                <?php
                                if (isset($mobile_view) && ($mobile_view == 1)) {
                                    ?>
                <a
                    href="<?php echo SERVER_ROOTPATH  . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>">
                    <img src="<?php echo $image_get; ?>"
                        style="height:300px;"></a>
                <?php
                                } else {
                                    ?>
                <a
                    href="<?php echo SERVER_ROOTPATH  . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>">
                    <img class="ad-feature-img"
                        src="<?php echo $image_get; ?>"></a>
                <?php
                                } ?>

                <cite
                    style="left:10px !important; background:none !important; text-transform: capitalize !important;">Featured
                    Song</cite>
                <?php
                                $all_avg = $all_avg;
                    //         echo $all_avg;
                    // die;?>

                <cite
                    style="background-color:<?php echo $color_pick; ?>"><?php echo ($all_avg < 10) ? $all_avg : $all_avg ?></cite>
                <div class="list_bottom">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <p><a
                                    href="<?php echo SERVER_ROOTPATH  . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><?php echo $song_title; ?></a><a
                                    class="artist-name"
                                    href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo $artist_name; ?></a><span><?php echo $feature_artists;
                    $sum_len  = 0; ?>
                                </span></p>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <?php
                                            if ($user_id != "") {
                                                // $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND like_type = 'artist' AND like_id = '$album_artist_id'"));
                                                $counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND like_type = 'artist' AND like_id = '$album_artist_id'");
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
                                id="other_dis_sub_popular_<?php echo $album_artist_id; ?>"><a
                                    href="javascript:;"
                                    onClick="add_in_favourite_list_sub_artist_popular('<?php echo $album_artist_id; ?>','<?php echo $sno_val; ?>','<?php echo $artist_seo; ?>')"><i
                                        class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i> </a>
                                <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                    data-toggle="modal" data-target="#missing_popular_review_Modal2_5000" data-title=""
                                    class="link-disable" style="color:#fff;"> <?php echo $counter_main; ?><?php if ($counter_main < 2) {
                                                        echo " Like";
                                                    } else {
                                                        echo " Likes";
                                                    } ?>
                                </a>
                            </span>
                            <span style="float:right;" class="like-group liked"
                                id="myStyle_sub_popular_<?php echo $album_artist_id; ?>"></span>
                            <?php
                                                } else { ?>
                            <span style="float:right;"
                                class="<?php echo $class; ?>"
                                id="other_dis_sub_popular_<?php echo $album_artist_id; ?>">
                                <a href="javascript:;"
                                    onClick="add_in_favourite_list_sub_artist_popular('<?php echo $album_artist_id; ?>','<?php echo $sno_val; ?>','<?php echo $artist_seo; ?>')"><i
                                        class="fa fa-heart" style="font-size:24px;"></i></a>
                                <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                    data-toggle="modal" data-target="#missing_popular_review_Modal2_5000" data-title=""
                                    class="link-disable" style="color:#fff;"> <?php echo $counter_main; ?><?php if ($counter_main < 2) {
                                                    echo " Like";
                                                } else {
                                                    echo " Likes";
                                                } ?>
                                </a></span>
                            <span style="float:right;" class="like-group liked"
                                id="myStyle_sub_popular_<?php echo $album_artist_id; ?>"></span>
                            <?php
                                                }
                                            } else {
                                                ?>
                            <span class="like-group" style="float:right;">
                                <?php
                                                    if ($user_id == "") {
                                                        ?>
                                <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o"
                                        style="font-size:24px; color:#D73B3B;"></i></a>

                                <?php
                                                    } else {
                                                        ?>
                                <a href="javascript:;"
                                    onClick="add_in_favourite_list_sub_artist_popular('<?php echo $album_artist_id; ?>','5000','<?php echo $artist_seo; ?>')"><i
                                        class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i> </a>
                                <?php
                                                    } ?>


                                <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                    data-toggle="modal" data-target="#missing_popular_review_Modal2_5000" data-title=""
                                    class="like link-disable" style="margin-left:4px;color:#fff;"> <?php echo $counter_main; ?><?php echo ($counter_main < 2) ? " Like" : " Likes" ?></a>
                            </span>
                            <?php
                                            } ?>
                        </div>
                    </div>

                </div>
                <div class="gradientoverlay"></div>
            </div>
        </div>
    </div>
    <?php
                }
            }
        }
    }
    ?>
</div>
<a href="javascript:void(0)" class="prev"><i class="sprite sprite-owl_prev"></i></a>
<a href="javascript:void(0)" class="next"><i class="sprite sprite-owl_next"></i></a>