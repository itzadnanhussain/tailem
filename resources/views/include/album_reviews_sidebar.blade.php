<style>
    @media (max-width: 350px) {
        .rev_position {
            padding: 15px;
        }
    }

    @media (max-width: 465px) {
        .rev_position {
            padding: 15px;
        }
    }

    @media (max-width: 640px) {
        .rev_position {
            padding: 15px;
        }
    }

    .artist_rev {
        margin-top: -10px !important;
    }

    .recent_style {
        margin-top: -100px !important;
    }

    @media (max-width: 1000px) {
        .recent_style {
            margin-top: 0px !important;
        }
    }

    @media (min-width:700px) and (max-width: 1000px) {
        .rev_right_position {
            padding-right: 30px !important;
        }
    }
</style>
 <?php error_reporting(0); ?>
<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 rev_right_position">
    <div class="recentreviewsec rev_position">
        <!-- Advertisement Right Side Start-->
        <div class="review_item" style="margin-top:0px;">
            <?php echo ads_info('Right'); ?>
        </div>
        <!-- Advertisement Right Side End-->

        <h3 class="headingmedium">Recent Reviews</h3>
        <?php
        $popular_review_array = popular_album();

        if ($popular_review_array) {
            $g = 0;
            $sr_no = 0;
            $r_fav = 0;
            $p_fav = 0;

            foreach ($popular_review_array as $val) {
                $val = (array)$val;
                $sr_no++;
                $g++;
                $r_fav++;
                $p_fav++;
                $review_id        = $val['review_id'];
                $db_review_id   = $val['review_id'];
                $db_review_id   = $val['review_id'];

                $artist_seo        = strtolower(stripslashes(html_entity_decode($val['artist_seo'])));
                $song_seo        = strtolower(stripslashes(html_entity_decode($val['song_seo'])));
                $album_picture  = stripslashes(html_entity_decode($val['album_picture']));
                $picture           = stripslashes(html_entity_decode($val['picture']));
                if ($picture == "" && $val['updated_by_itunes'] == '0000-00-00 00:00:00') {
                    $req_song  =  artist_album_song_func($artist_name, $song_title);
                }
                $review_title   = stripslashes(html_entity_decode($val['review_title']));
                $review_title = StringReplace($review_title);
                $review_rating  = $val['review_rating'];
                $review_detail  = stripslashes(html_entity_decode($val['review_detail']));
                $review_detail = StringReplace($review_detail);
                $review_user_id = $val['review_user_id'];
                $status         = $val['status'];

                $is_popular     = $val['is_popular'];
                $album_id       = $val['album_id'];
                $db_song_id        = $val['song_id'];
                $artist_id         = $val['artist_id'];
                $is_featured    = $val['is_featured'];
                $review_post_date  = $val['review_post_date'];
                $review_title   = wordwrap($review_title, 100, " ", true);

                $artist_name     = stripslashes($val['artist_name']);
                $song_title        =    stripslashes($val['song_title']);

                $select_qry     = "select user_name from tbl_users where user_id='" . $review_user_id . "' ";
                $select_ar = \App\Models\Songs::GetRawData($select_qry);
                $select_ar = (array)$select_ar[0];



                $user_name         = stripslashes(html_entity_decode($select_ar['user_name']));
                $user_name         = wordwrap($user_name, 100, " ", true);

                $position_find   = review_count_position($review_id, $db_song_id);


                // $counter_main   = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'artist' AND like_id = '$artist_id'"));

                $counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'artist' AND like_id = '$artist_id'");
                if ($counter_main) {
                    $counter_main = count($counter_main);
                } else {
                    $counter_main = 0;
                }

                $sum_rating     = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = $db_song_id AND status = 1";
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
                    $color_pick_main = "#5cb85c";
                }

                if ($all_avg >= 6 && $all_avg < 8) {
                    $color_pick_main = "#5cb85c";
                }

                if ($all_avg >= 4 && $all_avg < 6) {
                    $color_pick_main = "#ff0";
                }

                if ($all_avg >= 2 && $all_avg < 4) {
                    $color_pick_main = "#d9534f";
                }

                if ($all_avg > 0 && $all_avg < 2) {
                    $color_pick_main = "#d9534f";
                }


                if ($all_avg >= 7) {
                    $color_pick_main = "#5ebd5e";
                } elseif ($all_avg >= 4 && $all_avg <= 6.9) {
                    $color_pick_main = "#e06d21";
                } elseif ($all_avg >= 0 && $all_avg <= 3.9) {
                    $color_pick_main = "#dd554e";
                }


                // $counter_main_review = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'review_song' AND like_id = '$review_id'"));
                $counter_main_review = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'review_song' AND like_id = '$review_id'");
                // if ($counter_main_review) {
                //     $counter_main = count($counter_main);
                // } else {
                //     $counter_main_review = 0;
                // }



                if ($review_rating >= 8) {
                    $color_pick = "#5cb85c";
                }

                if ($review_rating >= 6 && $review_rating < 8) {
                    $color_pick = "#5cb85c";
                }

                if ($review_rating >= 4 && $review_rating < 6) {
                    $color_pick = "#ff0";
                }

                if ($review_rating >= 2 && $review_rating < 4) {
                    $color_pick = "#d9534f";
                }

                if ($review_rating > 0 && $review_rating < 2) {
                    $color_pick = "#d9534f";
                }


                if ($review_rating >= 7) {
                    $color_pick = "#5ebd5e";
                } elseif ($review_rating >= 4 && $review_rating <= 6) {
                    $color_pick = "#e06d21";
                } elseif ($review_rating >= 0 && $review_rating <= 3) {
                    $color_pick = "#dd554e";
                }

                $feature_artists  =  feature_songs($db_song_id);


                $featured_screen  =  featured_screen($db_song_id, $artist_name, $artist_seo);
                $featured_ipad  =  featured_ipad($db_song_id, $artist_name, $artist_seo);
                $featured_mobile  =  featured_mobile($db_song_id, $artist_name, $artist_seo);
        ?>


                <div class="review_item">
                    <div class="album_cover">
                        <div class="bottom_sec rev_top_val">
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10"></div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 txtalnright" style="padding-right:10px;">
                                    <?php if ($all_avg != 0) { ?>
                                        <cite style="background-color:<?php echo $color_pick_main; ?>"><?php if ($all_avg < 10) {
                                                                                                            echo number_format($all_avg, 1);
                                                                                                        } else {
                                                                                                            echo $all_avg;
                                                                                                        } ?></cite><?php } else { ?> <cite style="background-color: red;">0.0</cite><?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($picture != "") {
                            $img_api_linka = album_img_api($picture);
                            if ($img_api_linka != '') { ?>

                                <a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>"><img src="<?php echo $img_api_linka; ?>" border="0" class="img-responsive" style="width:100%; max-height:150px;" /></a>
                            <?php } else {

                            ?>
                                <a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>" border="0" class="img-responsive" style="width:100%; max-height:150px;" /></a>
                            <?php
                            }
                        } else
						if ($req_song['song_array']['image4'] != "") {
                            ?>
                            <a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>"> <img class="img-responsive" src="<?php echo album_img_api($req_song['song_array']['image4']); ?>" border="0" style="width:100%; max-height:150px;" /></a>
                        <?php
                        } else
						if ($album_picture != "") {
                        ?>
                            <a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" class="img-responsive" style="width:100%; max-height:150px;" /></a>
                        <?php
                        } else {
                        ?>
                            <a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" class="img-responsive" style="max-width:inherit;" /></a>
                        <?php
                        }
                        ?>

                        <div class="bottom_sec" style="padding-bottom:0;">
                            <div class="row">
                                <!--Desktop-->
                                <div class="review_screen_txt col-lg-9 col-md-8 col-sm-8 col-xs-8 pad_right">
                                    <label class="mrg_btm font_wgt"><a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>" style="font-size: 16px; color: #fff; font-family: 'Montserrat', sans-serif; font-weight:normal;"> <?php echo substr($song_title, 0, $screen_chr);
                                                                                                                                                                                                                                                        if (strlen($song_title) > $screen_chr) {
                                                                                                                                                                                                                                                            echo "..";
                                                                                                                                                                                                                                                        } ?></a></label><br>
                                    <label class="font_wgt mrgin_top"><?php echo $featured_screen; ?></label>
                                </div>
                                <!--Ipad-->
                                <div class="review_ipad_txt col-lg-9 col-md-9 col-sm-8 col-xs-8 pad_right">
                                    <label class="mrg_btm font_wgt"><a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>" style="font-size: 16px; color: #fff; font-family: 'Montserrat', sans-serif; font-weight:normal;"> <?php echo substr($song_title, 0, $ipad_chr);
                                                                                                                                                                                                                                                        if (strlen($song_title) > $ipad_chr) {
                                                                                                                                                                                                                                                            echo "..";
                                                                                                                                                                                                                                                        } ?></a></label><br>

                                    <label class="font_wgt mrgin_top"><?php echo $featured_ipad; ?></label>

                                </div>
                                <!--Mobile-->
                                <div class="review_mobile_txt col-lg-9 col-md-9 col-sm-8 col-xs-8 pad_right">
                                    <label class="mrg_btm font_wgt"><a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>" style="font-size: 16px; color: #fff; font-family: 'Montserrat', sans-serif; font-weight:normal;"><?php echo substr($song_title, 0, $mobile_chr);
                                                                                                                                                                                                                                                        if (strlen($song_title) > $mobile_chr) {
                                                                                                                                                                                                                                                            echo "..";
                                                                                                                                                                                                                                                        } ?></a></label><br>
                                    <label class="font_wgt mrgin_top"><?php echo $featured_mobile; ?></label>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4 pad_zero">
                                    <span style="float:right; margin-right:8px;" class="like-group">
                                        <?php
                                        if ($user_id != "") {
                                            // $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$artist_id'"));
                                            $counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$artist_id'");
                                            if ($counter) {
                                                $counter = count($counter);
                                            } else {
                                                $counter = 0;
                                            }
                                            if ($counter == 0) { ?>

                                                <span id="other_dis_sub_popular_<?php echo $artist_id; ?>_<?php echo $p_fav; ?>"><a href="javascript:;" onClick="like_artist_recent_reviews('<?php echo $artist_id; ?>','<?php echo $p_fav; ?>','<?php echo $artist_seo; ?>')"><i class="fa fa-heart-o heart_size heart_color"></i></a><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_id; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="link-disable" style="color:#fff;"> <?php echo $counter_main; ?><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a>
                                                </span>
                                                <span id="myStyle_sub_popular_<?php echo $artist_id; ?>_<?php echo $p_fav; ?>"></span>

                                            <?php
                                            } else {
                                            ?>
                                                <span id="other_dis_sub_popular_<?php echo $artist_id; ?>_<?php echo $p_fav; ?>"><a href="javascript:;" onClick="like_artist_recent_reviews('<?php echo $artist_id; ?>','<?php echo $p_fav; ?>','<?php echo $artist_seo; ?>')"><i class="fa fa-heart" style="color:#D73B3B; font-size:24px;"></i></a><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_id; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" style="color:#fff;" class="link-disable"> <?php echo $counter_main; ?><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                <span id="myStyle_sub_popular_<?php echo $artist_id; ?>_<?php echo $p_fav; ?>"></span>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <span id="other_dis_sub_popular_<?php echo $artist_id; ?>_<?php echo $p_fav; ?>">
                                                <?php
                                                if ($user_id == "") {
                                                ?>
                                                    <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_size heart_color"></i></a>

                                                <?php
                                                } else {
                                                ?>
                                                    <a href="javascript:;" onClick="like_artist_recent_reviews('<?php echo $artist_id; ?>','<?php echo $p_fav; ?>','<?php echo $artist_seo; ?>')"><i class="fa fa-heart-o heart_size heart_color"></i> </a>
                                                <?php
                                                }
                                                ?>

                                                <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_id; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="margin-left:4px; color:#FFFFFF;"> <?php echo $counter_main; ?><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                            <span id="myStyle_sub_popular_<?php echo $artist_id; ?>_<?php echo $p_fav; ?>"></span>
                                        <?php
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="gradientoverlay"></div>
                    </div>
                    <div class="album_detail">
                        <!--Desktop-->
                        <p class="review_screen_txt" style="margin-top:5px; margin-bottom:4px;"><label><a class="rec_review_title" href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviewslist/" . $artist_seo . "/" . $position_find . "#review_" . $review_id; ?>"><?php echo substr($review_title, 0, $screen_rev);

                                                                                                                                                                                                                                                                        if (strlen($review_title) > $screen_rev) {
                                                                                                                                                                                                                                                                            echo "...";
                                                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                                                        ?></a></label>
                            <cite style="background-color:<?php echo $color_pick; ?>"><?php if ($review_rating == 10) {
                                                                                            echo number_format($review_rating, 0);
                                                                                        } else {
                                                                                            echo $review_rating;
                                                                                        } ?></cite>
                        </p>
                        <!--Ipad-->
                        <p class="review_ipad_txt" style="margin-top:5px; margin-bottom:4px;"><label><a class="rec_review_title" href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviewslist/" . $artist_seo . "/" . $position_find . "#review_" . $review_id; ?>"><?php echo substr($review_title, 0, $ipad_rev);

                                                                                                                                                                                                                                                                    if (strlen($review_title) > $ipad_rev) {
                                                                                                                                                                                                                                                                        echo "...";
                                                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                                                    ?></a></label>
                            <cite style="background-color:<?php echo $color_pick; ?>"><?php if ($review_rating == 10) {
                                                                                            echo number_format($review_rating, 0);
                                                                                        } else {
                                                                                            echo $review_rating;
                                                                                        } ?></cite>
                        </p>
                        <!--Mobile-->
                        <p class="review_mobile_txt" style="margin-top:5px; margin-bottom:4px;"><label><a class="rec_review_title" href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviewslist/" . $artist_seo . "/" . $position_find . "#review_" . $review_id; ?>"><?php echo substr($review_title, 0, $mobile_rev);

                                                                                                                                                                                                                                                                        if (strlen($review_title) > $mobile_rev) {
                                                                                                                                                                                                                                                                            echo "...";
                                                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                                                        ?></a></label>
                            <cite style="background-color:<?php echo $color_pick; ?>"><?php if ($review_rating == 10) {
                                                                                            echo number_format($review_rating, 0);
                                                                                        } else {
                                                                                            echo $review_rating;
                                                                                        } ?></cite>
                        </p>


                        <p style="margin-bottom:16px;"><span style=" white-space:normal;"><a class="review_detail darkgrey_rev" href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviewslist/" . $artist_seo . "/" . $position_find . "#review_" . $review_id; ?>">
                                    <?php $detail_rev  = substr($review_detail, 0, 128);
                                    echo wordwrap($detail_rev, 15, " ", true);
                                    if (strlen($review_detail) > 128) {
                                        echo "...";
                                    } ?></a></span></p>

                        <div class="row">
                            <!--Desktop-->
                            <div class="review_screen_txt col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <span class="usrname"><img src="images/icon_user.png"><a class="darkgrey_rev" href="<?php echo SERVER_ROOTPATH . get_user_detail($user_name) . "/profile-review-artist"; ?>"><?php echo substr($user_name, 0, 12);
                                                                                                                                                                                                                if (strlen($user_name) > 12) {
                                                                                                                                                                                                                    echo "..";
                                                                                                                                                                                                                }
                                                                                                                                                                                                                ?>
                                    </a></span>
                            </div>
                            <div class="review_screen_txt col-lg-4 col-md-4 col-sm-4 col-xs-4 rev_pad_left" style="text-align:center;">
                                <span class="usrdetails darkgrey_rev" style="overflow:visible !important; font-size:12px;">
                                    <!--<img src="images/icon_time.png">--><?php echo date("d M Y", $review_post_date); ?>
                                </span>
                            </div>
                            <!--Ipad-->
                            <div class="review_ipad_txt white_space col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <span class="usrname"><img src="images/icon_user.png"><a class="darkgrey_rev" href="<?php echo SERVER_ROOTPATH . get_user_detail($user_name) . "/profile-review-artist"; ?>"><?php echo substr($user_name, 0, 30);
                                                                                                                                                                                                                if (strlen($user_name) > 30) {
                                                                                                                                                                                                                    echo "..";
                                                                                                                                                                                                                }
                                                                                                                                                                                                                ?>
                                    </a></span>
                            </div>
                            <!--Mobile-->
                            <div class="review_mobile_txt col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                <span class="usrname"><img src="images/icon_user.png"><a class="darkgrey_rev" href="<?php echo SERVER_ROOTPATH . get_user_detail($user_name) . "/profile-review-artist"; ?>"><?php echo substr($user_name, 0, 16);
                                                                                                                                                                                                                if (strlen($user_name) > 16) {
                                                                                                                                                                                                                    echo "..";
                                                                                                                                                                                                                }
                                                                                                                                                                                                                ?>
                                    </a></span>
                            </div>
                            <div class="review_mobile_txt col-lg-4 col-md-4 col-sm-2 col-xs-2 rev_pad_left" style="text-align:center;">
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="text-align:right;">
                                <span class="usrdetails" style="margin-top:-3px;">
                                    <?php
                                    // $counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'review_song' AND like_id = '$db_review_id'"));
                                    ///counter main
                                    $counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'review_song' AND like_id = '$db_review_id'");
                                    if ($counter_main) {
                                        $counter_main = count($counter_main);
                                    } else {
                                        $counter_main = 0;
                                    }


                                    if ($user_id != "") {

                                        // $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'review_song' AND like_id = '$db_review_id'"));
                                        $counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'review_song' AND like_id = '$db_review_id'");
                                        if ($counter) {
                                            $counter = count($counter);
                                        } else {
                                            $counter = 0;
                                        }
                                        if ($counter == 0) {
                                            if ($review_user_id == $user_id) {
                                    ?>
                                                <span class="darkgrey_rev" id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" title="your own review"><i class="fa fa-heart-o heart_size heart_color text_grey"></i> </a><?php echo $counter_main;
                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                ?>
                                                    <span class="darkgrey_rev" id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_review_song('<?php echo $db_review_id; ?>','<?php echo $user_name; ?>','<?php echo $r_fav; ?>')"><i class="fa fa-heart-o heart_size heart_color text_grey"></i> </a><?php echo $counter_main;
                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                            ?>
                                                    <a href="process/detail_review?user=<?php echo get_user_detail($user_name); ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable darkgrey_rev"> <?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                    <span class="darkgrey_rev" id="myStyle_sub_<?php echo $db_review_id; ?>"></span>
                                                <?php
                                            } else { ?>
                                                    <span class="darkgrey_rev" id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_review_song('<?php echo $db_review_id; ?>','<?php echo $user_name; ?>','<?php echo $r_fav; ?>')" class="like"><i class="fa fa-heart heart_size heart_color text_grey"></i></a> <?php echo $counter_main; ?><a href="process/detail_review?user=<?php echo get_user_detail($user_name); ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable darkgrey_rev"> <?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo "Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo "Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                    <span class="darkgrey_rev" id="myStyle_sub_<?php echo $db_review_id; ?>"></span>
                                                <?php
                                            }
                                        } else {
                                                ?>
                                                <span class="darkgrey_rev" id="other_dis_sub_<?php echo $db_review_id; ?>">
                                                    <?php
                                                    if ($user_id == "") {
                                                    ?>
                                                        <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_size heart_color text_grey"></i></i></a>

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a href="javascript:;" onClick="add_in_favourite_list_review_song('<?php echo $db_review_id; ?>','<?php echo $user_name; ?>','<?php echo $r_fav; ?>')"><i class="fa fa-heart-o heart_size heart_color text_grey"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php echo $counter_main; ?><a href="process/detail_review?user=<?php echo get_user_detail($user_name); ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable darkgrey_rev"> <?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                        echo "Like";
                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                        echo "Likes";
                                                                                                                                                                                                                                                                                                                    } ?></a></span>

                                                <span class="darkgrey_rev" id="myStyle_sub_<?php echo $db_review_id; ?>"></span>
                                            <?php
                                        }
                                            ?>
                                                </span>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>