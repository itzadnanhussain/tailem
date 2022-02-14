@include("common.header")
<?php
$USER_NAME = ucfirst($user_name);
$root = SERVER_ROOTPATH;
$request_url_check    =    str_replace($root, '', url()->current());
$request_url_check    =    str_replace("/", '', $request_url_check);
$request_url  =  str_replace($root, "", url()->current());
$request_url  =  str_replace(".html", "", $request_url);
if ($page != "") {
    $request_url  =  str_replace("-$page", "", $request_url);
}
?>
<style>
    a.under_line {
        text-decoration: none !important;
    }

    a.under_line:hover {
        text-decoration: underline !important;
    }

    @media (min-width:500px) and (max-width: 750px) {
        .belw_info {
            display: none !important;
        }
    }
</style>
<!-- ./Header end -->
<!-- Middle Section -->

<section class="middle_sec">
    <div class="topRwHead-bodyPan">
        <div class="container pad_zero">

            <div class="topRwHead-panel" style="margin:12px 0 !important; padding-bottom:0; padding-top:10px;">

                <?php if ($mobile_view == 0) { ?>

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
            <?php //include("include/latest_activities")
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
            <div style="background-color:#FFFFFF; padding:10px;" class="brows-label-penel">
                @include("include.artist_review_like_menu")
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="topRwContent-panel pad_zero" style="margin-bottom:15px;">
        <div class="topsonglistsec col-lg-12 col-md-12 col-sm-12 col-xs-12 pad_zero" style="background:none;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad_zero">
                <ul class="songlistings">
                    <?php
                    $review_list_arr = array();
                    if (empty($review_list_arr)) {
                        $like_review_query = "select c.comment_user_id,c.comment_id,u.user_name, u.profile_image,a.id as artist_id,b.album_seo,b.album_artist_id,b.years,s.picture,s.song_title,s.song_seo,a.artist_seo,a.artist_name,b.album_title, b.album_picture, s.id,s.description, b.id as album_id, c.comment_details, c.comment_post_date
								from tbl_artist_album b, tbl_artists a, tbl_songs s, tbl_likes l, tbl_comments c, tbl_users u 
								where 1=1 
								AND s.id = c.comment_review_id 
								AND a.id = c.comment_artist_id 
								AND b.id = c.comment_album_id 
								AND u.user_id = c.comment_user_id 
								AND c.comment_user_id = '" . $user_profile . "'  
								AND s.song_status = 1
								group by c.comment_review_id
								order by c.comment_id desc LIMIT 50";

                        $review_list_arr    =     \App\Models\Songs::GetRawData($like_review_query);
                        if ($review_list_arr) {
                            $total_pages = count($review_list_arr);
                        } else {
                            $total_pages =  0;
                        }
                    }
                    // $res_count_mypro = mysqli_query($db->dbh, $qry_count_mypro);

                    $targetpage = SERVER_ROOTPATH . $request_url; //your file name  (the name of this file)


                    $limit = 10;                     //how many items to show per page

                    if ($page) {
                        $start = ($page - 1) * $limit;
                    } //first item to display on this page
                    else {
                        $start = 0;
                    }                    //if no page var is given, set start to 0
                    //PAGGING CODE ENDS HERE
                    //============================================================

                    if (isset($page) && $page != "") {
                        $sr_no = ($page * $limit) - $limit;
                    } else {
                        $sr_no = 0;
                    }

                    $c = 1;

                    /*AND c.comment_id = (select max(cs.comment_id) from tbl_comments cs, tbl_songs ss where cs.comment_user_id = '".$user_profile."' AND ss.id = cs.comment_review_id)*/

                    $review_list_arr = array_slice($review_list_arr, $start, 10);
                    $k = 0;
                    if ($review_list_arr) {
                        foreach ($review_list_arr as $review_like_info) {
                            $review_like_info = (array)$review_like_info;
                            $sr_no++;
                            $k++;
                            $id                    = $review_like_info['id'];
                            $comment_id     = $review_like_info['comment_id'];
                            $review_id        = $review_like_info['review_id'];
                            $song_id        = $review_like_info['id'];
                            $comment_user_id = $review_like_info['comment_user_id'];
                            $album_title    = stripslashes(html_entity_decode($review_like_info['album_title']));
                            $album_id       = stripslashes(html_entity_decode($review_like_info['album_id']));
                            $artist_name    = stripslashes(html_entity_decode($review_like_info['artist_name']));
                            $album_picture  = stripslashes(html_entity_decode($review_like_info['album_picture']));
                            $song_title     = stripslashes(html_entity_decode($review_like_info['song_title']));
                            $artist_seo     = stripslashes(html_entity_decode($review_like_info['artist_seo']));
                            $years            = $review_like_info['years'];
                            $picture   = stripslashes(html_entity_decode($review_like_info['picture']));
                            $song_seo       = stripslashes(html_entity_decode($review_like_info['song_seo']));
                            $comment_details = stripslashes(html_entity_decode($review_like_info['comment_details']));

                            if ($user_id != '') {
                                $report_status_info = check_report_discussion($comment_id);
                                //print_r($report_status_info);
                            }

                            $user_name = stripslashes(html_entity_decode($review_like_info['user_name']));
                            $db_profile_image = stripslashes(html_entity_decode($review_like_info['profile_image']));
                            if ($db_profile_image != "") {
                                $prof_image = SERVER_ROOTPATH . "assets/phpthumb/phpThumb.php?src=" . SERVER_ROOTPATH . "site_upload/user_images/" . $db_profile_image . "&w=101&h=75&zc=0";
                            } else {
                                $prof_image = SERVER_ROOTPATH . "assets/phpthumb/phpThumb.php?src=" . SERVER_ROOTPATH . "assets/images/no_image4.png&w=101&h=75&zc=1";
                            }



                            $db_comment_post_date = date("d M Y", stripslashes($review_like_info['comment_post_date']));


                            $description   = stripslashes(html_entity_decode($review_like_info['description']));
                            $album_seo  = stripslashes(html_entity_decode($review_like_info['album_seo']));

                            $artist_id    =    stripslashes(html_entity_decode($review_like_info['artist_id']));

                            $album_title = wordwrap($album_title, 100, " ", true);
                            $artist_name = wordwrap($artist_name, 100, " ", true);

                            $qry = "select id from tbl_likes where like_type = 'artist' AND like_id = '$artist_id'";
                            $counter_main = array();
                            $counter_main = \App\Models\Songs::GetRawData($qry);
                            if (!empty($counter_main)) {
                                $counter_main = count($counter_main);
                            } else {
                                $counter_main = 0;
                            }


                            $counter_main2 = $counter_main;


                            $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter, sum(review_rating>=8) as excellent, sum(review_rating>=6 && review_rating<8) as verygood, sum(review_rating>=4 && review_rating<6) as good,sum(review_rating>=2 && review_rating<4) as poor,sum(review_rating>0 && review_rating<2) as terrible from tbl_reviews where song_id = $song_id AND status = 1";

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

                            $qry = "select id from tbl_likes where like_type = 'review_song' AND like_id = '$review_id'";
                            $counter_main_rev = array();
                            $counter_main_rev = \App\Models\Songs::GetRawData($qry);
                            if ($counter_main_rev) {
                                $counter_main_rev = count($counter_main_rev);
                            } else {
                                $counter_main_rev = 0;
                            }
                            //$req_song  =  artist_album_song_func($artist_name,$song_title);

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
                                    if ($num == $count) {
                                        $feature_art  = substr($val_feature['feature_artist'], 0, 9);
                                        if (strlen($val_feature['feature_artist']) > 9) {
                                            $feature_artists .= " <a href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs' style='color:#d73b3b; font-size: 16px;  font-weight: 500;'>" . $feature_art . '..' . "</a>";
                                        } else {
                                            $feature_artists .= " <a href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs' style='color:#d73b3b; font-size: 16px;  font-weight: 500;'>" . $val_feature['feature_artist'] . "</a>";
                                        }
                                    } else {
                                        $feature_art  = substr($val_feature['feature_artist'], 0, 6);
                                        if (strlen($val_feature['feature_artist']) > 6) {
                                            $feature_artists .= " <a href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs' style='color:#d73b3b; font-size: 16px;  font-weight: 500;'> " . $feature_art . '..' . "</a>";
                                        } else {
                                            $feature_artists .= " <a href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs' style='color:#d73b3b; font-size: 16px;  font-weight: 500;'>" . $val_feature['feature_artist'] . "</a>";
                                        }
                                    }
                                    $num++;
                                }
                            } ?>

                            <li class="review_rev_sng" style="min-height:150px;">
                                <!--Desktop-->
                                <text class="col-lg-5 col-md-5 col-sm-6 col-xs-5 review_screen_txt">
                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                            <span class="list_no"><?php if (strlen($sr_no) == 1) {
                                                                        echo "0";
                                                                    } else {
                                                                    }; ?><?php echo $sr_no; ?>
                                            </span>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-11 pad_zero">
                                            <div class="album_cover">
                                                <a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>">
                                                    <?php
                                                    if ($picture != "") {
                                                        $img_api_linka = album_img_api($picture);
                                                        if ($img_api_linka != '') {
                                                    ?>
                                                            <img src="<?php echo $img_api_linka; ?>" border="0" width="100" />
                                                        <?php
                                                        } else { ?>
                                                            <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>" border="0" width="100" />
                                                        <?php
                                                        }
                                                    } elseif ($req_song['song_array']['image4'] != "") {
                                                        ?>
                                                        <img src="<?php echo $req_song['song_array']['image4']; ?>" border="0" width="100" />
                                                    <?php
                                                    } elseif ($album_picture != "") {
                                                    ?>
                                                        <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="100" />
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="100" />
                                                    <?php
                                                    } ?>
                                                </a>
                                                <cite class="score_big mt-10" style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg == 10) {
                                                                                                                                        echo number_format($all_avg, 0);
                                                                                                                                    } else {
                                                                                                                                        echo $all_avg;
                                                                                                                                    } ?>
                                                </cite>
                                            </div>
                                            <div class="album_details" style="margin-top:-3px;">
                                                <label class="title"><a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>">
                                                        <?php echo substr($song_title, 0, 19);
                                                        if (strlen($song_title) > 19) {
                                                            echo "..";
                                                        } ?>
                                                    </a></label>
                                                <label class="author pad_left"><a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 19);
                                                                                                                                                                if (strlen($artist_name) > 19) {
                                                                                                                                                                    echo "..";
                                                                                                                                                                } ?>
                                                    </a></label>
                                                <!-- <label class="author pad_left ft_vall"><?php if ($feature_artists != "") { ?>
                                            <strong class="heart_color"
                                                style="font-size:16px; font-weight:500; ">ft.</strong> <?php echo $feature_artists;
                                                                                                    } ?>
                                        </label> -->
                                                <br>
                                                <label class="likes">
                                                    <?php

                                                    if ($user_id != "") {
                                                        $counter = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$artist_id'";
                                                        $counter = array();
                                                        $counter = \App\Models\Songs::GetRawData($qry);


                                                        if (!empty($counter)) {
                                                            $counter = count($counter);
                                                        } else {
                                                            $counter = 0;
                                                        }
                                                        if ($counter == 0) {
                                                    ?>
                                                            <span style="overflow:visible;" id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $sr_no; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i>
                                                                </a><span><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                            } ?>
                                                                </a></span>
                                                            <span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>"></span>

                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span style="overflow:visible;" id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $sr_no; ?>')"><i class="fa fa-heart heart_color heart_size"></i>
                                                                </a><span><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                            } ?>
                                                                </a></span>
                                                            <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>"></span>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <span style="overflow:visible;" id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>">

                                                            <?php
                                                            if ($user_id == "") {
                                                            ?>
                                                                <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $sr_no; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                            <?php
                                                            } ?>
                                                            <span><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                    } ?>
                                                            </a>
                                                        </span>
                                                        <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>"></span>



                                                    <?php
                                                    } ?>
                                                </label>
                                            </div>

                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 artist_type">
                                            <label class="author" style="font-size:16px; font-weight:normal;"><?php echo $years; ?></label>
                                        </div>
                                    </div>
                                </text>
                                <!--Ipad-->
                                <div class="review_sng_mrg review_ipad_txt">
                                    <!--<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 pad_zero">
                                    <span class="list_no"><br /><?php /*if(strlen($sr_no)==1){echo "0";}else{};?><?php echo $sr_no;*/ ?></span>
                        </div>-->
                                    <div class="col-lg-5 col-md-4 col-sm-4 col-xs-5 pad_zero">
                                        <div class="album_cover">
                                            <a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>">
                                                <?php
                                                if ($picture != "") {
                                                    $img_api_linka = album_img_api($picture);
                                                    if ($img_api_linka != '') {
                                                ?>
                                                        <img src="<?php echo $img_api_linka; ?>" border="0" width="100" style="padding:0 8px;" />
                                                    <?php
                                                    } else { ?>
                                                        <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>" border="0" width="100" style="padding:0 8px;" />
                                                    <?php
                                                    }
                                                } elseif ($req_song['song_array']['image4'] != "") {
                                                    ?>
                                                    <img src="<?php echo $req_song['song_array']['image4']; ?>" border="0" width="100" style="padding:0 8px;" />
                                                <?php
                                                } elseif ($album_picture != "") {
                                                ?>
                                                    <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="100" style="padding:0 8px;" />
                                                <?php
                                                } else {
                                                ?>
                                                    <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="100" style="padding:0 8px;" />
                                                <?php
                                                } ?>
                                            </a>
                                            <cite class="score_big mt-10" style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg == 10) {
                                                                                                                                    echo number_format($all_avg, 0);
                                                                                                                                } else {
                                                                                                                                    echo $all_avg;
                                                                                                                                } ?>
                                            </cite>
                                        </div>
                                        <div class="album_details mrg_top">
                                            <label class="title"><a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>">
                                                    <?php echo substr($song_title, 0, 9);
                                                    if (strlen($song_title) > 9) {
                                                        echo "..";
                                                    } ?>
                                                </a></label>
                                            <label class="author mrg_btm"><a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 10);
                                                                                                                                                            if (strlen($artist_name) > 10) {
                                                                                                                                                                echo "..";
                                                                                                                                                            } ?>
                                                </a></label><br>
                                            <?php if ($feature_artists != "") { ?>
                                                <label class="author pad_left"><strong class="heart_color" style="font-size:16px; font-weight:500; ">ft.</strong> <?php echo $feature_artists; ?></label><br>
                                            <?php } ?>
                                            <label class="likes mrg_btm" style="min-height:50px !important;">
                                                <?php
                                                if ($user_id != "") {
                                                    $srr_no = $sr_no + time();
                                                    $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  like_type = 'artist' AND like_id = '$artist_id'";
                                                    $counter = array();
                                                    $counter = \App\Models\Songs::GetRawData($qry);
                                                    if ($counter) {
                                                        $counter = count($counter);
                                                    } else {
                                                        $counter = 0;
                                                    }
                                                    if ($counter == 0) {
                                                ?>
                                                        <span style="overflow:visible;" id="other_dis_sub_<?php echo $srr_no; ?>_<?php echo $artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $artist_id; ?>','<?php echo $srr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $sr_no; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?>
                                                            </a></span>
                                                        <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $srr_no; ?>_<?php echo $artist_id; ?>"></span>

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span style="overflow:visible;" id="other_dis_sub_<?php echo $srr_no; ?>_<?php echo $artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $artist_id; ?>','<?php echo $srr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $sr_no; ?>')"><i class="fa fa-heart heart_color heart_size"></i> </a><span><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?>
                                                            </a></span>
                                                        <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $srr_no; ?>_<?php echo $artist_id; ?>"></span>
                                                    <?php
                                                    }
                                                } else {
                                                    $srr_no = $sr_no + time(); ?>
                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $srr_no; ?>_<?php echo $artist_id; ?>">
                                                        <?php
                                                        if ($user_id == "") {
                                                        ?>
                                                            <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="javascript:;" onClick="add_in_favourite_list_sub_artist_new('<?php echo $artist_id; ?>','<?php echo $srr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $sr_no; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                        <?php
                                                        } ?>
                                                        <span><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                } ?>
                                                        </a>
                                                    </span>
                                                    <span style="overflow:visible;  display:none;" id="myStyle_sub_<?php echo $srr_no; ?>_<?php echo $artist_id; ?>"></span>


                                                <?php
                                                } ?>

                                            </label>
                                            <!--<p style="margin-top:-22px;"><?php echo $years; ?>
                                </p>-->
                                        </div>

                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 pad_zero rew_item">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 pad_zero">
                                            <div class="latestsongssec">
                                                <div class="list_item">
                                                    <a href="<?php echo SERVER_ROOTPATH . get_user_detail($user_name) . '/profile-review-artist'; ?>"><img src="<?php echo $prof_image; ?>" width="100" border="0"></a>
                                                    <div class="list_bottom" style="padding:2px; width:100px;">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:14px; padding-right:2px;">
                                                                <a href="<?php echo SERVER_ROOTPATH . get_user_detail($USER_NAME); ?>/profile-review-artist"><cite style="margin:2px; font-size:12px; color:#FFFFFF;"><?php echo $user_name; ?></cite></a>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:2px; padding-right:16px;">
                                                                <?php
                                                                $qry = "select id from tbl_likes where like_type = 'profile' AND like_id = '$comment_user_id'";
                                                                $counter_main = array();
                                                                $counter_main = \App\Models\Songs::GetRawData($qry);
                                                                if ($counter_main) {
                                                                    $counter_main = count($counter_main);
                                                                } else {
                                                                    $counter_main = 0;
                                                                }
                                                                if ($user_id != "") {
                                                                    $qry =  "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'profile' AND like_id = '$comment_user_id'";
                                                                    $counter = array();
                                                                    $counter = \App\Models\Songs::GetRawData($qry);
                                                                    if ($counter) {
                                                                        $counter = count($counter);
                                                                    } else {
                                                                        $counter = 0;
                                                                    }

                                                                    if ($counter == 0) { ?>

                                                                        <span class="like-group" style="float:right; line-height:20px !important;" id="other_dis_sub_profile_<?php echo $sr_no; ?>"><a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist_new('<?php echo $comment_user_id; ?>','<?php echo $sr_no; ?>','<?php echo $user_name; ?>')"><i class="fa fa-heart-o heart_color" style="font-size:20px;"></i> </a><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" class="like link-disable" style="color:#FFFFFF;"> <?php echo $counter_main; ?></a></span>

                                                                        <span class="like-group" style="float:right; line-height:20px !important;" id="myStyle_sub_profile_<?php echo $sr_no; ?>"></span>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <span class="like-group" style="float:right; line-height:20px !important;" id="other_dis_sub_profile_<?php echo $sr_no; ?>"><a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist_new('<?php echo $comment_user_id; ?>','<?php echo $sr_no; ?>','<?php echo $user_name; ?>')"><i class="fa fa-heart" style="color:#d73b3b !important; font-size:20px;"></i>
                                                                            </a><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" class="like link-disable" style="color:#FFFFFF;"> <?php echo $counter_main; ?></a></span>
                                                                        <span class="like-group" style="float:right; line-height:20px !important;" id="myStyle_sub_profile_<?php echo $sr_no; ?>"></span>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <span class="like-group" style="float:right; line-height:20px !important;" id="other_dis_sub_profile_<?php echo $sr_no; ?>">
                                                                        <?php
                                                                        if ($user_id == "") {
                                                                        ?>
                                                                            <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color" style="font-size:20px;"></i></a>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist_new('<?php echo $comment_user_id; ?>','<?php echo $sr_no; ?>','<?php echo $user_name; ?>')"><i class="fa fa-heart-o heart_color" style="font-size:20px;"></i></a>
                                                                        <?php
                                                                        } ?>
                                                                        <a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" class="like link-disable" style="color:#FFFFFF;"> <?php echo $counter_main; ?></a>
                                                                    </span>
                                                                    <span class="like-group" style="float:right; line-height:20px !important;" id="myStyle_sub_profile_<?php echo $sr_no; ?>"></span>

                                                                <?php
                                                                } ?>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8 desc_pan pad_zero">
                                            <p style="min-height:70px;"><?php echo $comment_details; ?>
                                            </p>

                                            <div class="list-inline col-lg-12 col-md-12 col-sm-12 col-xs-12 pad_zero">
                                                <p class="dateVale col-lg-8 col-md-8 col-sm-8 col-xs-8 pad_left" style="font-size:12px;"><?php echo $db_comment_post_date; ?>
                                                </p>
                                                <p class="col-lg-4 col-md-4 col-sm-4 col-xs-4 ">
                                                    <?php
                                                    if ($user_profile != $user_id) {
                                                        if ($user_id == "") {
                                                    ?>
                                                            <a href="#" class="linktag_new under_line" data-toggle="modal" data-target="#signin_form">Report</a>
                                                            <?php
                                                        } else {
                                                            if (isset($report_status_info)) {
                                                            ?>
                                                                <a class="linktag_new under_line" href="#" data-toggle="modal" data-target="#report_already_message" data-title="">Report</a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="linktag_new under_line" href="<?php echo SERVER_ROOTPATH; ?>report_discussion_new.php?rev_id=<?php echo $comment_id; ?>&num=<?php echo $sr_no; ?>" data-toggle="modal" data-target="#report_Modal4_<?php echo $sr_no; ?>" data-title="">Report</a>
                                                        <?php
                                                            }
                                                        }
                                                    }

                                                    if ($user_profile == $user_id) {
                                                        ?>
                                                        <a class="linkTag under_line" data-title="" data-target="#edit_Modal4_<?php echo $sr_no; ?>" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>edit_comment?comment_id=<?php echo $comment_id; ?>&num=<?php echo $sr_no; ?>">Edit</a>
                                                    <?php
                                                    } ?>
                                                    <span id="myStyle_report_<?php echo $sr_no; ?>"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <!--Desktop-->
                                <text class="col-lg-7 col-md-7 col-sm-6 col-xs-7 review_screen_txt">
                                    <div class="rew_item">
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-3 ">

                                            <div class="latestsongssec">
                                                <div class="list_item">
                                                    <a href="<?php echo SERVER_ROOTPATH . get_user_detail($user_name) . '/profile-review-artist'; ?>"><img src="<?php echo $prof_image; ?>" width="100" border="0" class="img-responsive"></a>
                                                    <div class="list_bottom" style="padding:2px; width:100px;">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:14px; padding-right:2px;">
                                                                <a href="<?php echo SERVER_ROOTPATH . get_user_detail($USER_NAME); ?>/profile-review-artist"><cite style="margin:2px; font-size:12px; color:#FFFFFF;"><?php echo $user_name; ?></cite></a>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:2px; padding-right:16px; margin-top:5px;">
                                                                <?php
                                                                $qry = "select id from tbl_likes where like_type = 'profile' AND like_id = '$comment_user_id'";
                                                                $counter_main = array();
                                                                $counter_main = \App\Models\Songs::GetRawData($qry);
                                                                if ($counter_main) {
                                                                    $counter_main = count($counter_main);
                                                                } else {
                                                                    $counter_main = 0;
                                                                }
                                                                if ($user_id != "") {
                                                                    $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'profile' AND like_id = '$comment_user_id'";
                                                                    $counter = array();
                                                                    $counter = \App\Models\Songs::GetRawData($qry);
                                                                    if ($counter) {
                                                                        $counter = count($counter);
                                                                    } else {
                                                                        $counter = 0;
                                                                    }

                                                                    if ($counter == 0) { ?>

                                                                        <span class="like-group" style="float:right; line-height:20px !important;" id="other_dis_sub_profile_sc_<?php echo $sr_no; ?>"><a href="javascript:;" onClick="add_in_favourite_user_profile_screen_new('<?php echo $comment_user_id; ?>','<?php echo $sr_no; ?>','<?php echo $user_name; ?>')"><i class="fa fa-heart-o heart_color" style="font-size:20px;"></i>
                                                                            </a><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" class="like link-disable" style="color:#FFFFFF;"> <?php echo $counter_main; ?></a></span>

                                                                        <span class="like-group" style="float:right; line-height:20px !important;" id="myStyle_sub_profile_sc_<?php echo $sr_no; ?>"></span>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <span class="like-group" style="float:right; line-height:20px !important;" id="other_dis_sub_profile_sc_<?php echo $sr_no; ?>"><a href="javascript:;" onClick="add_in_favourite_user_profile_screen_new('<?php echo $comment_user_id; ?>','<?php echo $sr_no; ?>','<?php echo $user_name; ?>')"><i class="fa fa-heart" style="color:#d73b3b !important; font-size:20px;"></i> </a><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" class="like link-disable" style="color:#FFFFFF;"> <?php echo $counter_main; ?></a></span>
                                                                        <span class="like-group" style="float:right; line-height:20px !important;" id="myStyle_sub_profile_sc_<?php echo $sr_no; ?>"></span>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <!--onClick="add_in_favourite_user_profile_list(<?php echo $comment_user_id; ?>,<?php echo $sr_no; ?>)"-->
                                                                    <span class="like-group" style="float:right; line-height:20px !important;" id="other_dis_sub_profile_sc_<?php echo $sr_no; ?>">
                                                                        <?php
                                                                        if ($user_id == "") {
                                                                        ?>
                                                                            <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color" style="font-size:20px;"></i></a>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a href="javascript:;" onClick="add_in_favourite_user_profile_screen_new('<?php echo $comment_user_id; ?>','<?php echo $sr_no; ?>','<?php echo $user_name; ?>')"><i class="fa fa-heart-o heart_color" style="font-size:20px;"></i></a>
                                                                        <?php
                                                                        } ?>
                                                                        <a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" class="like link-disable" style="color:#FFFFFF;"> <?php echo $counter_main; ?></a>
                                                                    </span>
                                                                    <span class="like-group" style="float:right; line-height:20px !important;" id="myStyle_sub_profile_sc_<?php echo $sr_no; ?>"></span>

                                                                <?php
                                                                } ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-9 desc_pan pad_zero mrg_15" style="float:right;">
                                            <p style="min-height:70px;"><?php echo $comment_details; ?>
                                            </p>

                                            <div class="list-inline col-lg-12 col-md-12 col-sm-12 col-xs-12 pad_zero">
                                                <p class="dateVale col-lg-8 col-md-8 col-sm-8 col-xs-8 pad_left" style="font-size:12px;">
                                                    <?php echo $db_comment_post_date; ?>
                                                </p>
                                                <p class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php
                                                                                                /*if($user_profile == $user_id && $user_id!="")
                                    {
                                    ?>
                                    (<a data-title="" data-target="#edit_Modal4_<?php echo $sr_no;?>" data-toggle="modal" href="<?php echo SERVER_ROOTPATH;?>edit_comment?comment_id=<?php echo $comment_id;?>">Edit</a>)
                                    </p>
                                    <?php
                                    }*/
                                                                                                ?>


                                                    <?php
                                                    if ($user_profile != $user_id) {
                                                        if ($user_id == "") {
                                                    ?>
                                                            <a href="#" class="linktag_new under_line" data-toggle="modal" data-target="#signin_form">Report</a>
                                                            <?php
                                                        } else {
                                                            if (isset($report_status_info)) {
                                                            ?>
                                                                <a class="linktag_new under_line" href="#" data-toggle="modal" data-target="#report_already_message" data-title="">Report</a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="linktag_new under_line" href="<?php echo SERVER_ROOTPATH; ?>report_discussion_new.php?rev_id=<?php echo $comment_id; ?>&num=<?php echo $sr_no; ?>" data-toggle="modal" data-target="#report_Modal4_<?php echo $sr_no; ?>" data-title="">Report</a>
                                                    <?php
                                                            }
                                                        }
                                                    } ?>

                                                    <?php
                                                    if ($user_profile == $user_id) {
                                                    ?>
                                                        <a class="linkTag under_line" data-title="" data-target="#edit_Modal4_<?php echo $sr_no; ?>" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>edit_comment?comment_id=<?php echo $comment_id; ?>&num=<?php echo $sr_no; ?>">Edit</a>
                                                    <?php
                                                    } ?>

                                                    <span id="myStyle_report_<?php echo $sr_no; ?>"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </text>
                                <!--Mobile-->
                                <div style="padding-bottom:0px;" class="review_mobile_txt">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pad_zero">
                                                <div class="album_cover">
                                                    <a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>">
                                                        <?php
                                                        if ($picture != "") {
                                                            $img_api_linka = album_img_api($picture);
                                                            if ($img_api_linka != '') {
                                                        ?>
                                                                <img src="<?php echo $img_api_linka; ?>" border="0" style="height:120px;" />
                                                            <?php
                                                            } else { ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>" border="0" style="height:120px;" />
                                                            <?php
                                                            }
                                                        } elseif ($req_song['song_array']['image4'] != "") {
                                                            ?>
                                                            <img class="img-responsive" src="<?php echo $req_song['song_array']['image4']; ?>" border="0" style="height:120px;" />
                                                        <?php
                                                        } elseif ($album_picture != "") {
                                                        ?>
                                                            <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" style="height:120px;" />
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" style="height:120px;" />
                                                        <?php
                                                        } ?>
                                                    </a>
                                                    <cite class="score_big mt-10" style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg == 10) {
                                                                                                                                            echo number_format($all_avg, 0);
                                                                                                                                        } else {
                                                                                                                                            echo $all_avg;
                                                                                                                                        } ?>
                                                    </cite>

                                                    <div style="position:absolute; z-index:10; margin-left:88%; color:#FFFFFF; margin-top:-20px;" class="review_screen_txt"><?php echo $sr_no; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 pad_zero mobile-responsive">
                                                <div class="album_details" style="display:block; margin-top:-3px;">
                                                    <label class="title"><a href="<?php echo SERVER_ROOTPATH . $song_seo . "/reviews/" . $artist_seo; ?>">
                                                            <?php echo substr($song_title, 0, 20);
                                                            if (strlen($song_title) > 20) {
                                                                echo "...";
                                                            } ?>
                                                        </a></label>
                                                    <label class="author mrg_btm"><a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo $artist_name; ?></a>


                                                        <?php /*if($feature_artists!="") {?>
                                        <label class="author pad_left"><strong class="heart_color">ft.</strong> <?php echo $feature_artists;?></label>
                                        <?php  }*/ ?>

                                                    </label>

                                                    <div style="clear:both;"></div>
                                                    <?php if ($feature_artists != "") { ?>
                                                        <p><label class="reviews" style="float:left !important;"><?php echo "ft. " . $feature_artists; ?></label>
                                                        </p><?php } ?>
                                                    <div style="clear:both;"></div>

                                                    <?php /*if($feature_artists!="") {?>
                                        <label class="author pad_left"><strong class="heart_color">ft.</strong> <?php echo $feature_artists;?></label>
                                        <?php  }*/ ?>
                                                    <p><label class="likes" style="float:left; height:26px; margin-left:0px; padding-left:0px;">

                                                            <?php

                                                            if ($user_id != "") {
                                                                $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$artist_id'";
                                                                $counter = array();
                                                                $counter = \App\Models\Songs::GetRawData($qry);
                                                                if ($counter) {
                                                                    $counter = count($counter);
                                                                } else {
                                                                    $counter = 0;
                                                                }
                                                                if ($counter == 0) {
                                                            ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_mob_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_mob_new('<?php echo $artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $sr_no; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span><?php echo $counter_main2; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main2 < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?>
                                                                        </a></span>
                                                                    <span style="overflow:visible;" id="myStyle_sub_mob_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>"></span>

                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_mob_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub_artist_mob_new('<?php echo $artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $sr_no; ?>')"><i class="fa fa-heart heart_color heart_size"></i> </a><span><?php echo $counter_main2; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main2 < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?>
                                                                        </a></span>
                                                                    <span style="overflow:visible;" id="myStyle_sub_mob_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>"></span>
                                                                <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_mob_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>">
                                                                    <?php
                                                                    if ($user_id == "") {
                                                                    ?>
                                                                        <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <a href="javascript:;" onClick="add_in_favourite_list_sub_artist_mob_new('<?php echo $artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $sr_no; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                    <?php
                                                                    } ?>
                                                                    <span><?php echo $counter_main2; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main2 < 2) {
                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                            } ?>
                                                                    </a>
                                                                </span>
                                                                <span style="overflow:visible;" id="myStyle_sub_mob_<?php echo $sr_no; ?>_<?php echo $artist_id; ?>"></span>


                                                            <?php
                                                            } ?>
                                                        </label></p>
                                                    <div style="clear:both;"></div>
                                                    <!--<p>Year <?php echo $years; ?>
                                </p>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="rew_list-panel pad_zero mrg_top">
                                        <div class="rew_item" style="border:none; ">

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad_zero darkgrey_rev">
                                                <p style="min-height:40px;" class="review_detail"><?php echo $comment_details; ?>
                                                </p>


                                                <p class="dateVale" style="margin-top:12px; font-size:12px; float:left;"><?php echo $db_comment_post_date; ?>
                                                </p>
                                                <p class="like_right" style="margin-top:12px;"> <?php
                                                                                                if ($user_profile != $user_id) {
                                                                                                    if ($user_id == "") {
                                                                                                ?>
                                                            <a href="#" class="linktag_new under_line" data-toggle="modal" data-target="#signin_form">Report</a>
                                                            <?php
                                                                                                    } else {
                                                                                                        if (isset($report_status_info)) {
                                                            ?>
                                                                <a class="linktag_new under_line" href="#" data-toggle="modal" data-target="#report_already_message" data-title="">Report</a>
                                                            <?php
                                                                                                        } else {
                                                            ?>

                                                                <a class="linktag_new under_line" data-title="" data-target="#report_Modal4_<?php echo $sr_no; ?>" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>report_discussion_new.php?rev_id=<?php echo $comment_id; ?>&num=<?php echo $sr_no; ?>">Report</a>
                                                    <?php
                                                                                                        }
                                                                                                    }
                                                                                                } ?>

                                                    <?php
                                                    if ($user_profile == $user_id) {
                                                    ?>
                                                        <a class="linkTag under_line" data-title="" data-target="#edit_Modal4_<?php echo $sr_no; ?>" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>edit_comment?comment_id=<?php echo $comment_id; ?>&num=<?php echo $sr_no; ?>">Edit</a>
                                                    <?php
                                                    } ?>

                                                    <span id="myStyle_report_<?php echo $sr_no; ?>"></span>
                                                </p>
                                            </div>

                                        </div>

                                    </div>


                                    <!--</li>-->
                                </div>

                                <div style="clear:both;"></div>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>

            </div>
            <?php if ($total_pages > $limit) { ?>
                <div class="page-navigation">
                    <ul>
                        @include("common.paging-playlist.php"); ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <div class="clearfix"></div>
    </div>
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
    <?php
    } ?>
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
                                @csrf
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



@include("common.footer")
@include("common.signin_modal")
<?php
//  include("include/thankyou_messages.php");

if ($k) {
    for ($u = 1; $u <= $sr_no; $u++) {
?>
        <div class="modal fade" id="model_review_likes_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
    }
}

?>
<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
</div>
<?php



for ($u = 1; $u <= $sr_no; $u++) {
?>
    <div class="modal fade" id="missing_popular_review_Modal2_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}


?>
<div class="modal fade" id="profile_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
</div>
<?php

for ($g = 1; $g <= $sr_no; $g++) {
?>
    <div class="modal fade" id="edit_Modal4_<?php echo $g; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}
for ($g = 1; $g <= $sr_no; $g++) {
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