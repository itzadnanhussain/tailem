@include('common.header')
<!-- ./Header end -->

<?php
 
ini_set('max_execution_time', '300');
$mobile_view = 0;

?>

<!-- Middle Section -->
<section class="middle_sec">
    <div class="banner topsongbanner">
        <div class="banner_body">
            <h1 class="bnr_heading">Top <span>50</span> Songs</h1>
        </div>
    </div>
    <div class="topsonglistsec" style="padding-top:0;">
        <!-- Advertisement Banner Start-->
        <div class="container" style="padding:20px 0 20px 0;">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-0 col-xs-0 review_screen_txt">&nbsp;</div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="text-align:center;">
                    <?php echo ads_info('Top'); ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-0 col-xs-0 review_screen_txt">&nbsp;</div>
            </div>
        </div>
        <!--Advertisement Banner End-->
        <div class="container tablet-view" style="padding:0;">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <ul class="songlistings">
                        <?php
                        //============================================================
                        //PAGGING CODE STARTS HERE


                        $artist_list_arr = array();
                        // $key = md5("artist_list_arr_top_songs_list");
                        if (empty($artist_list_arr)) {
                            $artist_list = "SELECT  saa.artist_id,s.id, 
									s.song_title, 
									s.song_seo, 
									s.updated_by_itunes,
									s.picture, 
									b.album_title, 
									b.album_picture,a.artist_seo, 
      								a.artist_name 
								FROM tbl_songs s 
									   INNER JOIN tbl_songs_artist_album saa
											   ON saa.song_id = s.id 
									   INNER JOIN tbl_artist_album b 
											   ON saa.album_id = b.id 
                                                INNER JOIN tbl_artists a 
											   ON saa.artist_id = a.id 
								WHERE  (saa.display_status = 1 AND s.song_status=1) and s.ranking_order>0 
								group by s.id order by
							    s.ranking_order desc                                
								LIMIT  50";

                            // $artist_list_arr    =    $db->get_results($artist_list, ARRAY_A);
                            $artist_list_arr = \App\Models\Songs::GetRawData($artist_list);

                            if ($artist_list_arr) {
                                $total_pages = count($artist_list_arr);
                            } else {
                                $total_pages =  0;
                            }
                        }



                        $limit = 10;
                        if ($page) {
                            $start = ($page - 1) * $limit;
                        } //first item to display on this page
                        else {
                            $start = 0;                    //if no page var is given, set start to 0
                        }
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
                            foreach ($artist_list_arr as $val) {
                                $val = (array)$val;

                                $id      = $val['id'];

                                $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.song_id = '" . $id . "' order by r.review_id desc limit 1";

                                // $review_list_arr_top    =    $db->get_row($review_list_qry, ARRAY_A);
                                $review_list_arr_top = array();
                                $review_list_arr_top = \App\Models\Songs::GetRawDataAdmin($review_list_qry);
                                // echo '<pre>';
                                // print_r($review_list_arr_top);
                                // echo '</pre>';
                                


                                // if ($review_list_arr_top) {
                                //     $review_list_arr_top['count_reviews'] = count($review_list_arr_top);
                                // } else {
                                //     $review_list_arr_top['count_reviews'] = 0;
                                // }

                                $comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_review_id = '" . $id . "' order by comment_id desc limit 1";


                                //                                $comment_list_qry = "select u.user_name,u.profile_image, c.* from tbl_users u, tbl_comments c where u.user_id = c.comment_user_id AND c.comment_review_id = $id order by comment_id desc";


                                // $discussion_list_arr    =    $db->get_results($comment_list_qry, ARRAY_A);
                                $comment_list_arr = array();
                                $comment_list_arr = \App\Models\Songs::GetRawDataAdmin($comment_list_qry);
                                
                                
                            
                                // if (isset($discussion_list_arr) && !empty($discussion_list_arr)) {
                                //     $comment_list_arr['count_discussion'] = count($discussion_list_arr);
                                // } else {
                                //     $comment_list_arr['count_discussion'] =  0;
                                // }



                                $album_title = stripslashes(html_entity_decode($val['album_title']));
                                $artist_name = stripslashes(html_entity_decode($val['artist_name']));
                                $album_picture   = stripslashes(html_entity_decode($val['album_picture']));
                                $song_title = stripslashes(html_entity_decode($val['song_title']));
                                $artist_seo = strtolower(stripslashes(html_entity_decode($val['artist_seo'])));

                                $song_seo   = strtolower(stripslashes(html_entity_decode($val['song_seo'])));
                                $picture   = stripslashes(html_entity_decode($val['picture']));

                                if ($picture == '' &&  $review_like_info['updated_by_itunes'] == '0000-00-00 00:00:00') {
                                    $req_song  =  artist_album_song_func($artist_name, $song_title);
                                }

                                $album_title = wordwrap($album_title, 100, " ", true);
                                $artist_name = wordwrap($artist_name, 100, " ", true);

                                $album_artist_id = stripslashes(html_entity_decode($val['artist_id']));

                                // $counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'artist' AND like_id = '$album_artist_id'"));
                                $counter_main = array();
                                $counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'artist' AND like_id = '$album_artist_id'");
                                if ($counter_main) {
                                    $counter_main = count($counter_main);
                                } else {
                                    $counter_main = 0;
                                }

                                $qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '" . $id . "'";
                                // $qry_feature_arr = $db->get_results($qry_top_feature_artist, ARRAY_A);
                                $qry_feature_arr = array();
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
                                            $feature_artt  = substr($val_feature['feature_artist'], 0, 50);
                                            if (strlen($val_feature['feature_artist']) > 50) {
                                                $feature_artists .= " <a style='color:#d73b3b' href='" . SERVER_ROOTPATH . strtolower($val_feature['f_artist_seo']) . "/artist-songs'>" . $feature_artt . '..' . "</a>";
                                            } else {
                                                $feature_artists .= " <a style='color:#d73b3b' href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $feature_artt . "</a>";
                                            }
                                        } else {
                                            $feature_artt  = substr($val_feature['feature_artist'], 0, 50);
                                            if (strlen($val_feature['feature_artist']) > 50) {
                                                $feature_artists .= " <a style='color:#d73b3b' href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $feature_artt . '..' . "</a>,";
                                            } else {
                                                $feature_artists .= " <a style='color:#d73b3b' href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $feature_artt . "</a>,";
                                            }
                                        }
                                        $num++;
                                    }
                                }



                                $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = $id AND status = 1";
                                $rate_arr = array();
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
                                $sr_no++; ?>
                        <li <?php if ($sr_no % 2 == 0) { ?>
                            style="background-color:#f3f3f3;" <?php } ?>>
                            <?php if ($mobile_view == 0) { ?>
                            <div class="row">
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                    <span class="list_no"><?php if (strlen($sr_no) == 1) {
                                    echo "0";
                                } else {
                                }; ?><?php echo $sr_no; ?>
                                    </span>
                                </div>
                                <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
                                    <div class="album_cover">
                                        <a href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"
                                            class="text_blck"> <?php
                                                                                                                                                        if ($picture != "") {
                                                                                                                                                            $img_api_linka = album_img_api($picture);
                                                                                                                                                           

                                                                                                                                                            if ($img_api_linka != '') {
                                                                                                                                                                ?>

                                            <img src="<?php echo $img_api_linka; ?>"
                                                border="0" width="120" />
                                            <?php
                                                                                                                                                            } else { ?>
                                            <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>"
                                                border="0" width="120" />
                                            <?php
                                                                                                                                                            }
                                                                                                                                                        } else {
                                                                                                                                                            if ($req_song['song_array']['image4'] != "") {
                                                                                                                                                                $img_api_linkaa = album_img_api($req_song['song_array']['image4']);

                                                                                                                                                                if ($img_api_linkaa != '') {
                                                                                                                                                                    ?>
                                            <img class="img-responsive"
                                                src="<?php echo $img_api_linkaa; ?>"
                                                border="0" width="120" /> <?php
                                                                                                                                                                } else { ?>
                                            <img class="img-responsive"
                                                src="<?php echo $req_song['song_array']['image4']; ?>"
                                                border="0" width="120" />
                                            <?php
                                                                                                                                                                }
                                                                                                                                                            } elseif ($album_picture != "") {
                                                                                                                                                                $img_api_aa = album_img_api($album_picture);

                                                                                                                                                                if ($img_api_aa != '') {
                                                                                                                                                                    ?>
                                            <img class="img-responsive"
                                                src="<?php echo $img_api_aa; ?>"
                                                border="0" width="120" /> <?php
                                                                                                                                                                } else { ?>
                                            <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>"
                                                border="0" width="120" />
                                            <?php
                                                                                                                                                                }
                                                                                                                                                            } else { ?>
                                            <img src="<?php echo COOKIE_FREE_ROOTPATH; ?>assets/images/no_image4.png"
                                                border="0" width="120" />
                                            <?php }
                                                                                                                                                        } ?>
                                        </a>
                                        <!--	<cite class="yellow">5.0</cite>-->
                                        <?php if ($all_avg != 0) {
                                                                                                                                                            ?><cite
                                            style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                                                                echo number_format($all_avg, 1);
                                                                                                                                                            } else {
                                                                                                                                                                echo $all_avg;
                                                                                                                                                            } ?>
                                        </cite><?php
                                                                                                                                                        } else { ?>
                                        <cite style="background-color:#dd554e;">0.0</cite><?php } ?>

                                    </div>
                                    <div class="album_details">

                                        <label class="title"><a
                                                href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>">
                                                <?php echo substr($song_title, 0, 45);
                                                            if (strlen($song_title) > 45) {
                                                                echo "...";
                                                            } ?>

                                            </a></label>
                                        <label class="author"><a
                                                href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 30);
                                                                                                                                                    if (strlen($artist_name) > 30) {
                                                                                                                                                        echo "...";
                                                                                                                                                    } ?>
                                            </a></label>
                                        <label class="likes"
                                            style="height:26px; margin-top:-9px; vertical-align: middle;">
                                            <!--<img src="images/icon_heart.png"><a href="#"><span>0</span> Likes</a>-->
                                            <?php
                                                        if ($user_id != "") {
                                                            // $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$album_artist_id'"));
                                                            $counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$album_artist_id'");
                                                            if ($counter) {
                                                                $counter = count($counter);
                                                            } else {
                                                                $counter = 0;
                                                            }
                                                            if ($counter == 0) {
                                                                ?>
                                            <span
                                                id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $album_artist_id; ?>"><a
                                                    href="javascript:;"
                                                    onClick="add_in_favourite_list_sub_artist_new('<?php echo $album_artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"
                                                    class="text_grey"><i class="fa fa-heart-o"
                                                        style="font-size:24px; color:#D73B3B;"></i> </a><span
                                                    class="text_red"><?php echo $counter_main; ?></span>
                                                <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                                    data-toggle="modal" data-target="#artist_modal" data-title=""
                                                    class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                    echo " Like";
                                                                } else {
                                                                    echo " Likes";
                                                                } ?>
                                                </a></span>
                                            <span
                                                id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $album_artist_id; ?>"></span>
                                            <?php
                                                            } else { ?>
                                            <span
                                                id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $album_artist_id; ?>"><a
                                                    href="javascript:;"
                                                    onClick="add_in_favourite_list_sub_artist_new('<?php echo $album_artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"
                                                    class="like"><i class="fa fa-heart"
                                                        style="font-size:24px; color:#D73B3B;"></i></a> <span
                                                    class="text_red"><?php echo $counter_main; ?></span>
                                                <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                                    data-toggle="modal" data-target="#artist_modal" data-title=""
                                                    class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                echo " Like";
                                                            } else {
                                                                echo " Likes";
                                                            } ?>
                                                </a></span>
                                            <span
                                                id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $album_artist_id; ?>"></span>
                                            <?php
                                                            }
                                                        } else {
                                                            ?>
                                            <span
                                                id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $album_artist_id; ?>">
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
                                                    onClick="add_in_favourite_list_sub_artist_new('<?php echo $album_artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"
                                                    class="text_grey"><i class="fa fa-heart-o"
                                                        style="font-size:24px; color:#D73B3B;"></i></a>
                                                <?php
                                                                } ?>
                                                <span class="text_red"><?php echo $counter_main; ?></span>
                                                <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                                    data-toggle="modal" data-target="#artist_modal" data-title=""
                                                    class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                    echo " Like";
                                                                } else {
                                                                    echo " Likes";
                                                                } ?>
                                                </a>
                                            </span>
                                            <span
                                                id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $album_artist_id; ?>"></span>
                                            <?php
                                                        }
                                                        ?>
                                        </label>

                                        <div style="clear:both;"></div>
                                        <?php if ($feature_artists != "") { ?>
                                        <p><label class="reviews"><?php echo "ft. " . $feature_artists; ?></label>
                                        </p><?php } ?>
                                        <div style="clear:both;"></div>
                                        <p>
                                            <label class="reviews">
                                                <img
                                                    src="<?php echo COOKIE_FREE_ROOTPATH; ?>images/review-book.png"><a
                                                    style="opacity:1;">Reviews <span><?php echo $review_list_arr_top['count_reviews']; ?></span></a>
                                            </label>
                                            <label class="reviews"><img
                                                    src="<?php echo COOKIE_FREE_ROOTPATH; ?>images/icon_post.png"><a
                                                    style="opacity:1;"><?php if ($comment_list_arr['count_discussion'] < 2) {
                                                            echo "Posts ";
                                                        } else {
                                                            echo "Posts ";
                                                        } ?><span><?php echo $comment_list_arr['count_discussion']; ?></span></label>
                                        </p>
                                    </div>

                                    <?php
                                                if ($user_id == "") {
                                                    ?>
                                    <a href="#" data-toggle="modal" data-target="#signin_form"
                                        class="playlist_icon"><img
                                            src="<?php echo addtoplaylist_icon(); ?>"
                                            title="Add to Playlist" /></a>
                                    <?php
                                                } else {
                                                    ?>
                                    <a class="playlist_icon" data-title="" data-target="#show_playlist"
                                        data-toggle="modal"
                                        href="<?php echo SERVER_ROOTPATH; ?>add-playlist?song_id=<?php echo $id; ?>&art_id=<?php echo $album_artist_id; ?>"><img
                                            src="<?php echo addtoplaylist_icon(); ?>"
                                            title="Add to Playlist" /></a>
                                    <?php
                                                }
                                                ?>



                                    <button
                                        onclick="window.location.href='<?php echo SERVER_ROOTPATH . Slug($song_seo) . '/write-a-review/' . Slug($artist_seo); ?>'">Write
                                        a review</button>
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
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 album-outer-coontainer"
                                    style="padding:0px !important;">
                                    <div class="album_cover">
                                        <a href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"
                                            class="text_blck"> <?php
                                                                                                                                                            if ($picture != "") {
                                                                                                                                                                $img_api_linka = album_img_api($picture);
                                                                                                                                                                if ($img_api_linka != '') {
                                                                                                                                                                    ?>
                                            <img class="fixed-hgt-img"
                                                src="<?php echo $img_api_linka; ?>"
                                                border="0" width="120" />
                                            <?php
                                                                                                                                                                } else { ?>
                                            <img class="fixed-hgt-img"
                                                src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>"
                                                border="0" width="120" />
                                            <?php
                                                                                                                                                                }
                                                                                                                                                            } else {
                                                                                                                                                                if ($req_song['song_array']['image4'] != "") { ?>
                                            <img class="img-responsive"
                                                src="<?php echo $req_song['song_array']['image4']; ?>"
                                                border="0" width="120" style=" height:80px !important;" />
                                            <?php } elseif ($album_picture != "") { ?>
                                            <img class="fixed-hgt-img"
                                                src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>"
                                                border="0" width="120" />
                                            <?php } else { ?>
                                            <img class="fixed-hgt-img"
                                                src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png"
                                                border="0" width="120" />
                                            <?php }
                                                                                                                                                            } ?>
                                        </a>
                                        <?php if ($all_avg != 0) {
                                                                                                                                                                ?><cite
                                            style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                                                                    echo number_format($all_avg, 1);
                                                                                                                                                                } else {
                                                                                                                                                                    echo $all_avg;
                                                                                                                                                                } ?>
                                        </cite><?php
                                                                                                                                                            } else { ?>
                                        <cite style="background-color:#dd554e;">0.0</cite><?php } ?>

                                        <div
                                            style="position:inherit; z-index:10; float:right; color:#FFFFFF; margin-top:-20px; margin-right:3px;">
                                            <?php echo $sr_no; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 album-detail-container"
                                    style="padding:0px !important;">
                                    <div class="album_details">
                                        <label class="title"><a
                                                href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><?php echo substr($song_title, 0, 50);
                                                                                                                                                                if (strlen($song_title) > 50) {
                                                                                                                                                                    echo "...";
                                                                                                                                                                } ?>
                                            </a></label>
                                        <label class="author"><a
                                                href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 30);
                                                                                                                                                        if (strlen($artist_name) > 30) {
                                                                                                                                                            echo "...";
                                                                                                                                                        } ?>
                                            </a></label>
                                        <div style="clear:both;"></div>
                                        <?php if ($feature_artists != "") { ?>
                                        <p><label class="reviews" style="float:left !important;"><?php echo "ft. " . $feature_artists; ?></label>
                                        </p><?php } ?>
                                        <div style="clear:both;"></div>
                                        <label class="likes"
                                            style="height:26px; margin-left:0px; padding-left:0px; vertical-align: middle;">
                                            <?php
                                                            if ($user_id != "") {
                                                                // $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$album_artist_id'"));
                                                                $counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$album_artist_id'");
                                                                if ($counter) {
                                                                    $counter = count($counter);
                                                                } else {
                                                                    $counter = 0;
                                                                }

                                                                
                                                                if ($counter == 0) {
                                                                    ?>
                                            <span
                                                id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $album_artist_id; ?>"><a
                                                    href="javascript:;"
                                                    onClick="add_in_favourite_list_sub_artist_new('<?php echo $album_artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"
                                                    class="text_grey"><i class="fa fa-heart-o"
                                                        style="font-size:24px; color:#D73B3B;"></i> </a><span
                                                    class="text_red"><?php echo $counter_main; ?></span>
                                                <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                                    data-toggle="modal" data-target="#artist_modal" data-title=""
                                                    class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                        echo " Like";
                                                                    } else {
                                                                        echo " Likes";
                                                                    } ?>
                                                </a></span>
                                            <span
                                                id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $album_artist_id; ?>"></span>
                                            <?php
                                                                } else { ?>
                                            <span
                                                id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $album_artist_id; ?>"><a
                                                    href="javascript:;"
                                                    onClick="add_in_favourite_list_sub_artist_new('<?php echo $album_artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"
                                                    class="like"><i class="fa fa-heart"
                                                        style="font-size:24px; color:#D73B3B;"></i></a> <span
                                                    class="text_red"><?php echo $counter_main; ?></span>
                                                <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                                    data-toggle="modal" data-target="#artist_modal" data-title=""
                                                    class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                    echo " Like";
                                                                } else {
                                                                    echo " Likes";
                                                                } ?>
                                                </a></span>
                                            <span
                                                id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $album_artist_id; ?>"></span>
                                            <?php
                                                                }
                                                            } else {
                                                                ?>
                                            <span
                                                id="other_dis_sub_<?php echo $sr_no; ?>_<?php echo $album_artist_id; ?>">
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
                                                    onClick="add_in_favourite_list_sub_artist_new('<?php echo $album_artist_id; ?>','<?php echo $sr_no; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"
                                                    class="text_grey"><i class="fa fa-heart-o"
                                                        style="font-size:24px; color:#D73B3B;"></i></a>
                                                <?php
                                                                    } ?>
                                                <span class="text_red"><?php echo $counter_main; ?></span>
                                                <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                                    data-toggle="modal" data-target="#artist_modal" data-title=""
                                                    class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                        echo " Like";
                                                                    } else {
                                                                        echo " Likes";
                                                                    } ?>
                                                </a>
                                            </span>
                                            <span
                                                id="myStyle_sub_<?php echo $sr_no; ?>_<?php echo $album_artist_id; ?>"></span>
                                            <?php
                                                            }
                                                            ?>
                                        </label>
                                        <div class="hidden-phone" style="clear:both;"></div>
                                        <p class="inline-mobile"><label class="reviews"><img
                                                    src="<?php echo COOKIE_FREE_ROOTPATH; ?>images/review-book.png"><a>Reviews
                                                    <span><?php echo $review_list_arr_top['count_reviews']; ?></span></a></label>
                                            <label class="reviews"><img
                                                    src="<?php echo COOKIE_FREE_ROOTPATH; ?>images/icon_post.png"><a><?php if ($comment_list_arr['count_discussion'] < 2) {
                                                                echo "Posts ";
                                                            } else {
                                                                echo "Posts ";
                                                            } ?><span><?php echo $comment_list_arr['count_discussion']; ?></span>
                                                </a></label>
                                        </p>
                                    </div>


                                </div>

                                <div class="clear"></div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-right:0">
                                    <div class="col-sm-5 col-xs-5">
                                        <?php
                                                        if ($user_id == "") {
                                                            ?>
                                        <a href="#" data-toggle="modal" data-target="#signin_form"
                                            style="padding:0; float:left; margin-right:6px;"><img
                                                src="<?php echo addtoplaylist_icon(); ?>"
                                                title="Add to Playlist" /></a>
                                        <?php
                                                        } else {
                                                            ?>
                                        <a data-title="" data-target="#show_playlist" data-toggle="modal"
                                            href="<?php echo SERVER_ROOTPATH; ?>add-playlist?song_id=<?php echo $id; ?>&art_id=<?php echo $album_artist_id; ?>"
                                            style="padding:0; float:left; margin-right:6px;"><img
                                                src="<?php echo addtoplaylist_icon(); ?>"
                                                title="Add to Playlist" /></a>
                                        <?php
                                                        }
                                                        ?>
                                    </div>

                                    <div class="col-sm-7 col-xs-7" style="padding-right:20px; float:right;">
                                        <a
                                            href="<?php echo SERVER_ROOTPATH  . Slug($song_seo) . "/write-a-review/" . Slug($artist_seo); ?>"><button>Write
                                                a review</button></a>
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
                        @include("common.paging-playlist")
                    </ul>
                </div>
                <?php } ?>
            </div>

            @include("include.song_reviews_sidebar")
            <!-- Advertisement Banner Start-->

            <div class="clear"></div>
            <div class="container" style="padding-top:10px;">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <?php echo ads_info('Bottom'); ?>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
                </div>
            </div>
            <!--Advertisement Banner End-->

        </div>
    </div>
    </div>
</section>


<style>
    body {
        overflow-x: hidden;
    }

    .album_details label>span {
        overflow: visible;
    }

    @media (max-width: 350px) {
        .topsonglistsec .songlistings li {
            padding: 5px 15px;
        }

        .banner.topsongbanner {
            background: rgba(0, 0, 0, 0) url("<?php echo COOKIE_FREE_ROOTPATH; ?>images/banner_topsongs_mobile.png") no-repeat scroll 0 0 / cover !important;
            height: 236px;
        }
    }

    @media (max-width: 465px) {
        .banner.topsongbanner {
            background: rgba(0, 0, 0, 0) url("<?php echo COOKIE_FREE_ROOTPATH; ?>images/banner_topsongs_mobile.png") no-repeat scroll 0 0 / cover !important;
            height: 236px;
        }
    }

    @media (max-width: 640px) {
        .banner.topsongbanner {
            background: rgba(0, 0, 0, 0) url("<?php echo COOKIE_FREE_ROOTPATH; ?>images/banner_topsongs_mobile.png") no-repeat scroll 0 0 / cover !important;
            height: 236px;
        }
    }
</style>
<!-- ./Middle Section -->


@include("common.signin_modal")
<?php
// include("include/thankyou_messages.php");
// include_once("common/popular_review.php");
?>
<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
</div>
<div class="modal fade" id="show_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
</div>
<div class="modal fade" id="create_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal"
    aria-hidden="true"></div>

@include('common.footer')