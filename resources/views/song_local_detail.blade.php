@include('common.header')
<!-- ./Header end -->
<?php

//include_once("common/signin_modal_header.php");
error_reporting(0);
$song_list_arr = (array)$song_list_arr[0];
$id      = $song_list_arr['id'];
$song_id      = $song_list_arr['id'];

$album_title = stripslashes(html_entity_decode($song_list_arr['album_title']));
$album_id = stripslashes(html_entity_decode($song_list_arr['album_id']));
$artist_name = stripslashes(html_entity_decode($song_list_arr['artist_name']));
$album_picture   = stripslashes(html_entity_decode($song_list_arr['album_picture']));
$song_title = stripslashes(html_entity_decode($song_list_arr['song_title']));

$itunes_url = stripslashes(html_entity_decode($song_list_arr['itunes_url']));
$amazon_url = stripslashes(html_entity_decode($song_list_arr['amazon_url']));

$google_url = stripslashes(html_entity_decode($song_list_arr['google_url']));

$lastfm_url = stripslashes(html_entity_decode($song_list_arr['lastfm_url']));
$artist_seo = stripslashes(html_entity_decode($song_list_arr['artist_seo']));
$song_seo   = stripslashes(html_entity_decode($song_list_arr['song_seo']));
$picture   = stripslashes(html_entity_decode($song_list_arr['picture']));

$description   = stripslashes(html_entity_decode($song_list_arr['description']));
$album_seo  = stripslashes(html_entity_decode($song_list_arr['album_seo']));

$song_url_fm = $lastfm_url;
$song_summary_fm = $description;
$song_image_fm = $picture;
/****************** LASTFM CALL********/
if ($lastfm_url = "") {
    ini_set('allow_url_fopen ', 'ON');

    $artistname = urlencode($artist_name);

    $track = urlencode($song_title);

    $temp = file_get_contents("http://ws.audioscrobbler.com/2.0/?method=track.getInfo&artist=" . $artistname . "&track=" . $track . "&api_key=979650ff4905a23bb01e312145761ebb");

    $XmlObj = simplexml_load_string($temp);

    if ($XmlObj->attributes()->status == 'ok') {
        $song_url_fm = $XmlObj->track->url;
        $song_summary_fm = $XmlObj->track->wiki->summary;
        $song_image_fm = $XmlObj->track->album->image[2];
    } else {
        $song_url_fm = '';
        $song_summary_fm = '';
        $song_image_fm = '';
    }
}
/****************** LASTFM CALL********/
$artist_id    =    stripslashes(html_entity_decode($song_list_arr['artist_id']));

$album_title = wordwrap($album_title, 100, " ", true);
$artist_name = wordwrap($artist_name, 100, " ", true);

$album_artist_id = stripslashes(html_entity_decode($song_list_arr['album_artist_id']));



// $counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'artist' AND like_id = '$artist_id'"));
$counter_main = array();
$counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'artist' AND like_id = '$artist_id'");
if ($counter_main) {
    $counter_main = count($counter_main);
} else {
    $counter_main = 0;
}






$discussion_list_qry = "select u.user_name,u.profile_image, c.* from tbl_users u, tbl_comments c where u.user_id = c.comment_user_id AND c.comment_review_id = $song_id order by comment_id desc";

// $discussion_list_arr    =    $db->get_results($discussion_list_qry, ARRAY_A);
$discussion_list_arr = \App\Models\Songs::GetRawData($discussion_list_qry);
if (isset($discussion_list_arr)) {
    $count_discussion  = count($discussion_list_arr);
} else {
    $count_discussion  = 0;
}



$sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter, sum(review_rating>=8) as excellent, sum(review_rating>=7 && review_rating<8) as verygood, sum(review_rating>=4 && review_rating<7) as good,sum(review_rating>=2 && review_rating<4) as poor,sum(review_rating>0 && review_rating<2) as terrible from tbl_reviews where song_id = $song_id AND status = 1";
$rate_arr = array();
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

    if ($counter > 0 && $sum_rate > 0) {
        $excellent_per = ($excellent / $counter) * 100;
        $verygood_per  = ($verygood / $counter) * 100;
        $good_per        = ($good / $counter) * 100;
        $poor_per        = ($poor / $counter) * 100;
        $terrible_per = ($terrible / $counter) * 100;
    } else {
        $excellent_per =  0;
        $verygood_per  =  0;
        $good_per        = 0;
        $poor_per        = 0;
        $terrible_per =  0;
    }
} else {
    $sum_rate = 0;
    $counter = 0;
    $all_avg = 0;
    $excellent = 0;
    $verygood = 0;
    $good = 0;
    $poor = 0;
    $terrible = 0;
    $excellent_per = 0;
    $verygood_per  = 0;
    $good_per        = 0;
    $poor_per        = 0;
    $terrible_per =  0;
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
if ($all_avg >= 4 && $all_avg <= 6) {
    $color_pick = "#e06d21";
}
if ($all_avg >= 0 && $all_avg <= 3) {
    $color_pick = "#dd554e";
}
$all_avg = number_format($all_avg, 1);

$call_song_seo = SEO($song_title);
$call_artist_seo = SEO($artist_name);

$img_qry1 = "select store_img from tbl_store_img where store_id=1";
$img_arr1 = \App\Models\Songs::GetRawData($img_qry1);
$img_arr1 = (array)$img_arr1[0];

$img_qry2 = "select store_img from tbl_store_img where store_id=2";
$img_arr2 = \App\Models\Songs::GetRawData($img_qry2);
$img_arr2 = (array)$img_arr2[0];

$img_qry3 = "select store_img from tbl_store_img where store_id=3";
$img_arr3 = \App\Models\Songs::GetRawData($img_qry3);
$img_arr3 = (array)$img_arr3[0];

?>
<style>
    a.under_line {
        text-decoration: none !important;
    }

    a.under_line:hover {
        text-decoration: underline !important;
    }
</style>
<script type="text/javascript">
    function sort_area(val) {
        window.location.href =
            "<?php echo SERVER_ROOTPATH .  Slug($song_seo) ?>/reviews/<?php echo Slug($artist_seo); ?>-sort-" +
            val;
    }

    function show_detail_reveiw(rid, pass) {
        if (pass == 'more') {
            $("#show_more_" + rid).show();
            $("#show_less_" + rid).hide();
        } else
        if (pass == 'less') {
            $("#show_more_" + rid).hide();
            $("#show_less_" + rid).show();
        }
    }
</script>


<!-- Middle Section -->
<section class="middle_sec">
    <div class="topRwHead-bodyPan">
        <div class="container" style="padding:0;">
            <?php
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
                    $val_feature = (array) $val_feature;
                    if ($num == $count) {
                        $feature_artists .= " <a style='color:#D73B3B' href='" . SERVER_ROOTPATH .   Slug($val_feature['f_artist_seo']) . "/artist-songs' >" . $val_feature['feature_artist'] . "</a>";
                    } else {
                        $feature_artists .= " <a style='color:#D73B3B' href='" . SERVER_ROOTPATH .   Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $val_feature['feature_artist'] . "</a>,";
                    }
                    $num++;
                }
            } ?>
            <?php if ($mobile_view == 0) { ?>
            <div class="topRwHead-panel" style="margin:12px 0 !important; padding-bottom:0; padding-top:10px;">
                <div class="col-lg-8 col-md-8" style="margin-bottom:0px">
                    <div class="col-sm-5 artist-img-panel" style="padding:0;">
                        <!--<p>10</p>
						<img src="images/img-1.jpg" class="img-responsive  artist-img">-->
                        <div class="latestsongssec">
                            <div class="list_item">
                                <div class="album_cover" style="border-radius:0px;">
                                    <a
                                        href="<?php echo SERVER_ROOTPATH .  Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>">
                                        <?php
                                                                                                                                        if ($picture != "") {
                                                                                                                                            $song_pic = SERVER_ROOTPATH . "site_upload/song_images/thumb_" . $picture;
                                                                                                                                            $img_api_link = album_img_api($picture);
                                                                                                                                            if ($img_api_link != '') {
                                                                                                                                                ?>
                                        <img src="<?php echo $img_api_link; ?>"
                                            class="img-responsive  artist-img" style="max-height:250px;" />
                                        <?php
                                                                                                                                            } else { ?>
                                        <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>"
                                            class="img-responsive  artist-img" style="max-height:250px;" />
                                        <?php
                                                                                                                                            }
                                                                                                                                        } elseif ($song_image_fm != "") {
                                                                                                                                            ?>
                                        <img src="<?php echo $song_image_fm; ?>"
                                            class="img-responsive  artist-img" style="max-height:250px;" />
                                        <?php
                                                                                                                                        } elseif ($album_picture != "") {
                                                                                                                                            $song_pic = SERVER_ROOTPATH . "site_upload/album_images/thumb_" . $album_picture;
                                                                                                                                            //$song_pic = $album_picture;?>
                                        <img src="<?php echo $song_pic; ?>"
                                            class="img-responsive  artist-img" style="max-height:250px;" />
                                        <?php
                                                                                                                                        } else {
                                                                                                                                            $song_pic = SERVER_ROOTPATH . "assets/images/no_image4.png"; ?>
                                        <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png"
                                            class="img-responsive  artist-img" style="max-height:250px;" />
                                        <?php
                                                                                                                                        }
                                            ?>
                                    </a>
                                    <cite
                                        style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg == 10) {
                                                echo number_format($all_avg, 0);
                                            } else {
                                                echo $all_avg;
                                            } ?>
                                    </cite>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 desc-panel">
                        <p class="title"><a style='color:#000000;'
                                href="<?php echo SERVER_ROOTPATH .  Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><?php echo $song_title; ?></a></p>
                        <p class="sub-title" style="font-size:14px;"> <a style='color:#D73B3B;'
                                href="<?php echo SERVER_ROOTPATH .   Slug($artist_seo) . "/artist-songs"; ?>"><?php echo $artist_name; ?></a>
                            <?php
                                if ($feature_artists != "") {
                                    ?>
                            <strong style="color:#000000;">ft.</strong> <?php echo $feature_artists; ?>
                            <?php
                                }
                                ?>
                            <label class="likes" style="float:right; margin-top:-5px;">
                                <?php
                                    if ($user_id != "") {
                                        // $counter1 =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$artist_id'"));
                                        $counter1 = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$artist_id'");
                                        if ($counter1) {
                                            $counter1 = count($counter1);
                                        } else {
                                            $counter1 = 0;
                                        }
                                        if ($counter1 == 0) { ?>
                                <span
                                    id="other_dis_sub_<?php echo $artist_id; ?>"><a
                                        href="javascript:;"
                                        onClick="add_in_favourite_list_rev('<?php echo $artist_id; ?>','<?php echo $artist_seo; ?>')"><i
                                            class="fa fa-heart-o heart_color heart_size"></i> </a><span><?php echo $counter_main; ?></span><a
                                        href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                        data-toggle="modal" data-target="#artist_modal" data-title=""
                                        style="color:#000; font-weight:normal;" class="link-disable"><?php if ($counter_main < 2) {
                                            echo " Like";
                                        } else {
                                            echo " Likes";
                                        } ?>
                                    </a></span>
                                <span
                                    id="myStyle_sub_<?php echo $artist_id; ?>"></span>

                                <?php } else { ?>
                                <span
                                    id="other_dis_sub_<?php echo $artist_id; ?>"><a
                                        href="javascript:;"
                                        onClick="add_in_favourite_list_rev('<?php echo $artist_id; ?>','<?php echo $artist_seo; ?>')"
                                        class="like"><i class="fa fa-heart heart_color heart_size"></i></a>
                                    <span><?php echo $counter_main; ?></span>
                                    <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                        data-toggle="modal" data-target="#artist_modal" data-title=""
                                        style="color:#000; font-weight:normal;" class="link-disable"><?php if ($counter_main < 2) {
                                            echo " Like";
                                        } else {
                                            echo " Likes";
                                        } ?>
                                    </a></span>

                                <span
                                    id="myStyle_sub_<?php echo $artist_id; ?>"
                                    class="text_grey"></span>
                                <?php }
                                    } else {
                                        ?>
                                <span
                                    id="other_dis_sub_<?php echo $artist_id; ?>">
                                    <?php
                                            if ($user_id == "") {
                                                ?>
                                    <a href="#" data-toggle="modal" data-target="#signin_form"><i
                                            class="fa fa-heart-o heart_color heart_size"></i></a>
                                    <?php
                                            } else {
                                                ?>
                                    <a href="javascript:;"
                                        onClick="add_in_favourite_list_rev('<?php echo $artist_id; ?>','<?php echo $artist_seo; ?>')"><i
                                            class="fa fa-heart-o heart_color heart_size"></i></a>
                                    <?php
                                            } ?>
                                    <span class="red-text"><?php echo $counter_main; ?></span>
                                    <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                        data-toggle="modal" data-target="#artist_modal" data-title=""
                                        style="color:#000; font-weight:normal;" class="link-disable"><?php if ($counter_main < 2) {
                                                echo " Like";
                                            } else {
                                                echo " Likes";
                                            } ?>
                                    </a>
                                </span>
                                <span
                                    id="myStyle_sub_<?php echo $artist_id; ?>"></span>
                                <?php
                                    }
                                    ?>
                            </label>
                        </p>

                        <div class="activity-panel">
                            <label class="likes"><img
                                    src="<?php echo SERVER_ROOTPATH; ?>images/review-book.png">
                                <a style="color:#000000; font-weight:normal;"><span class="red-text"> <?php echo $counter; ?> </span>
                                    Reviews</a></label>
                            <label class="likes"><img
                                    src="<?php echo SERVER_ROOTPATH; ?>images/icon_post.png">
                                <a style="color:#000000; font-weight:normal;"><span class="red-text"> <?php echo $count_discussion; ?>
                                    </span> Posts</a></label>

                            <?php
                                if ($user_id == "") {
                                    ?>
                            <a href="#" data-toggle="modal" data-target="#signin_form"
                                style="padding:0; float:right; margin-right:6px; margin-top:-10px;"><img
                                    src="<?php echo addtoplaylist_icon(); ?>"
                                    title="Add to Playlist" /></a>
                            <?php
                                } else {
                                    ?>
                            <a data-title="" data-target="#show_playlist" data-toggle="modal"
                                href="<?php echo SERVER_ROOTPATH; ?>add-playlist?song_id=<?php echo $song_id; ?>&art_id=<?php echo $album_artist_id; ?>"
                                style="padding:0; float:right; margin-right:6px; margin-top:-10px;"><img
                                    src="<?php echo addtoplaylist_icon(); ?>"
                                    title="Add to Playlist" /></a>
                            <?php
                                }
                                ?>
                        </div>
                        <p style="min-height:110px;">
                            <?php if ($song_summary_fm != "" && $description == "") {
                                    $song_summary_fm = strip_tags($song_summary_fm);

                                    $rev_desc_length  = strlen($song_summary_fm);
                                    echo substr($song_summary_fm, 0, 200);
                                    if ($rev_desc_length > 200) {
                                        echo " ....";
                                    } ?> <br><a href="<?php if ($lastfm_url != "") {
                                        echo $lastfm_url;
                                    } else {
                                        echo $song_url_fm;
                                    } ?>">Read more on Last.fm
                                <!--<img border="0" src="<?php echo SERVER_ROOTPATH; ?>images/fm.png">-->
                            </a><?php
                                } else {
                                    //echo substr(strip_tags($description),0, 250);}
                                    $rev_desc_length  = strlen($description);
                                    if ($rev_desc_length > 200) {
                                        ?>
                            <span
                                id="show_less_<?php echo $song_id; ?>"><?php echo  substr(strip_tags($description), 0, 200) . "..."; ?>
                                <a href="javascript:;"
                                    onclick="show_detail_reveiw(<?php echo $song_id; ?>, 'more')">View
                                    more</a>
                            </span>

                            <span
                                id="show_more_<?php echo $song_id; ?>"
                                style="display:none;"><?php echo strip_tags($description); ?>
                                <a href="javascript:;"
                                    onclick="show_detail_reveiw(<?php echo $song_id; ?>, 'less')">View
                                    Less</a>
                            </span>

                            <?php
                                    } else {
                                        echo strip_tags($description);
                                    }
                                } ?>
                        </p>
                        <?php $data = song_adds($song_id, 'adds');
                            if (is_array($data)) {
                                echo $data['ad_code'];
                            } else {
                                echo $data;
                            } ?>

                        <p class="buyFromPan" style="margin-bottom:15px; font-size:13px;">Buy from:
                            <a target="_blank"
                                href="<?php echo $itunes_url; ?>"><img
                                    src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $img_arr1['store_img'] ?>"></a>
                            |
                            <a target="_blank"
                                href="<?php echo $amazon_url; ?>"><img
                                    src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $img_arr2['store_img'] ?>"></a>
                            <!--|
							<a target="_blank" href="<?php echo $google_url; ?>"><img
                                src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $img_arr3['store_img'] ?>"></a>-->
                        </p>

                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <!--<img src="images/video.jpg" class="img-responsive">-->
                    <?php $data = song_adds($song_id, 'video');
                        if (is_array($data)) {
                            echo $data['video_code'];
                        } else {
                            echo $data;
                        } ?>
                    <?php //echo ads_info('right');
                        ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php
            } elseif ($mobile_view == 1) { ?>
            <div class="topRwHead-panel" style="margin:12px 0 !important; padding-bottom:0; padding-top:5px;">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:0; padding:0;">
                    <!--<p>10</p>
						<img src="images/img-1.jpg" class="img-responsive  artist-img">-->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding:0px; padding-left:10px;">
                            <div class="latestsongssec artist-img-panel">
                                <div class="list_item">
                                    <div class="album_cover" style="border-radius:0;">
                                        <a
                                            href="<?php echo SERVER_ROOTPATH .  Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>">
                                            <?php
                                                                                                                                            if ($picture != "") {
                                                                                                                                                $song_pic = SERVER_ROOTPATH . "site_upload/song_images/thumb_" . $picture;
                                                                                                                                                $img_api_link = album_img_api($picture);
                                                                                                                                                if ($img_api_link != '') {
                                                                                                                                                    ?>
                                            <img src="<?php echo $img_api_link; ?>"
                                                class="img-responsive  artist-img" />
                                            <?php
                                                                                                                                                } else { ?>
                                            <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>"
                                                class="img-responsive  artist-img" />
                                            <?php
                                                                                                                                                }
                                                                                                                                            } elseif ($song_image_fm != "") {
                                                                                                                                                ?>
                                            <img src="<?php echo $song_image_fm; ?>"
                                                class="img-responsive  artist-img" />
                                            <?php
                                                                                                                                            } elseif ($album_picture != "") {
                                                                                                                                                $song_pic = SERVER_ROOTPATH . "site_upload/album_images/thumb_" . $album_picture; ?>
                                            <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>"
                                                class="img-responsive  artist-img" />
                                            <?php
                                                                                                                                            } else {
                                                                                                                                                $song_pic = SERVER_ROOTPATH . "assets/images/no_image4.png"; ?>
                                            <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png"
                                                class="img-responsive  artist-img" />
                                            <?php
                                                                                                                                            }
                                                ?>
                                        </a>
                                        <cite
                                            style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg == 10) {
                                                    echo number_format($all_avg, 0);
                                                } else {
                                                    echo $all_avg;
                                                } ?>
                                        </cite>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding:5px;">
                            <p class="title" style="font-weight:bold; font-size:20px; margin-bottom:5px;"><a
                                    style='color:#000000;'
                                    href="<?php echo SERVER_ROOTPATH .  Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><?php echo $song_title; ?></a></p>
                            <p class="sub-title"
                                style="color:#dd554e; font-size:18px; margin-bottom:4px; min-height:30px;"><a
                                    style='color:#D73B3B;'
                                    href="<?php echo SERVER_ROOTPATH .   Slug($artist_seo) . "/artist-songs"; ?>"><?php echo $artist_name; ?></a>
                                <?php
                                    if ($feature_artists != "") {
                                        ?>
                                <strong style="color:#000000;">ft.</strong> <?php echo $feature_artists; ?>
                                <?php
                                    }
                                    ?>
                            </p>
                            <label class="likes">
                                <?php
                                    if ($user_id != "") {
                                        $counter1 = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$artist_id'");
                                        if ($counter1) {
                                            $counter1 = count($counter1);
                                        } else {
                                            $counter1 = 0;
                                        }
                                        if ($counter1 == 0) { ?>
                                <span
                                    id="other_dis_sub_<?php echo $artist_id; ?>"><a
                                        href="javascript:;"
                                        onClick="add_in_favourite_list_rev('<?php echo $artist_id; ?>','<?php echo $artist_seo; ?>')"><i
                                            class="fa fa-heart-o heart_color heart_size"></i> </a><span
                                        class="red-text"><?php echo $counter_main; ?></span><a
                                        href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                        data-toggle="modal" data-target="#artist_modal" data-title=""
                                        style="color:#000; font-weight:normal;" class="link-disable"><?php if ($counter_main < 2) {
                                            echo " Like";
                                        } else {
                                            echo " Likes";
                                        } ?>
                                    </a></span>

                                <span
                                    id="myStyle_sub_<?php echo $artist_id; ?>"></span>

                                <?php } else { ?>
                                <span
                                    id="other_dis_sub_<?php echo $artist_id; ?>"><a
                                        href="javascript:;"
                                        onClick="add_in_favourite_list_rev('<?php echo $artist_id; ?>','<?php echo $artist_seo; ?>')"
                                        class="like"><i class="fa fa-heart heart_color heart_size"></i></a> <span
                                        class="red-text"><?php echo $counter_main; ?></span>
                                    <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                        data-toggle="modal" data-target="#artist_modal" data-title=""
                                        style="color:#000; font-weight:normal;" class="link-disable"><?php if ($counter_main < 2) {
                                            echo " Like";
                                        } else {
                                            echo " Likes";
                                        } ?>
                                    </a></span>

                                <span
                                    id="myStyle_sub_<?php echo $artist_id; ?>"
                                    class="text_grey"></span>
                                <?php }
                                    } else {
                                        ?>
                                <span
                                    id="other_dis_sub_<?php echo $artist_id; ?>">
                                    <?php
                                            if ($user_id == "") {
                                                ?>
                                    <a href="#" data-toggle="modal" data-target="#signin_form"><i
                                            class="fa fa-heart-o heart_color heart_size"></i></a>
                                    <?php
                                            } else {
                                                ?>
                                    <a href="javascript:;"
                                        onClick="add_in_favourite_list_rev('<?php echo $artist_id; ?>','<?php echo $artist_seo; ?>')"><i
                                            class="fa fa-heart-o heart_color heart_size"></i></a>
                                    <?php
                                            } ?>

                                    <span class="red-text"><?php echo $counter_main; ?></span>
                                    <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1"
                                        data-toggle="modal" data-target="#artist_modal" data-title=""
                                        style="color:#000; font-weight:normal;" class="link-disable"><?php if ($counter_main < 2) {
                                                echo " Like";
                                            } else {
                                                echo " Likes";
                                            } ?>
                                    </a>
                                </span>
                                <span
                                    id="myStyle_sub_<?php echo $artist_id; ?>"></span>
                                <?php
                                    }
                                    ?>
                            </label>

                            <?php
                                if ($user_id == "") {
                                    ?>
                            <a href="#" data-toggle="modal" data-target="#signin_form"
                                style="padding:0; float:right; margin-right:6px; margin-top:-10px;"><img
                                    src="<?php echo addtoplaylist_icon(); ?>"
                                    title="Add to Playlist" /></a>
                            <?php
                                } else {
                                    ?>
                            <a data-title="" data-target="#show_playlist" data-toggle="modal"
                                href="<?php echo SERVER_ROOTPATH; ?>add-playlist?song_id=<?php echo $song_id; ?>&art_id=<?php echo $album_artist_id; ?>"
                                style="padding:0; float:right; margin-right:6px; margin-top:-10px;"><img
                                    src="<?php echo addtoplaylist_icon(); ?>"
                                    title="Add to Playlist" /></a>
                            <?php
                                }
                                ?>


                            <div class="clearfix"></div>
                            <div class="activity-panel">

                                <label class="likes"><img
                                        src="<?php echo SERVER_ROOTPATH; ?>images/review-book.png">
                                    <a style="color:#000000; font-weight:normal;"><span class="red-text"><?php echo $counter; ?> </span>
                                        Reviews</a></label>
                                <label class="likes"><img
                                        src="<?php echo SERVER_ROOTPATH; ?>images/icon_post.png">
                                    <a style="color:#000000; font-weight:normal;"><span class="red-text"> <?php echo $count_discussion; ?>
                                        </span> Posts</a></label>



                            </div>
                        </div>
                    </div>
                    <div class="desc-panel" style="padding:10px; text-align:justify;">
                        <p style="min-height:110px;">
                            <?php if ($song_summary_fm != "" && $description == "") {
                                    $song_summary_fm = strip_tags($song_summary_fm);
                                    $rev_desc_length  = strlen($song_summary_fm);
                                    echo substr($song_summary_fm, 0, 250);
                                    if ($rev_desc_length > 200) {
                                        echo " ....";
                                    } ?> <br><a href="<?php if ($lastfm_url != "") {
                                        echo $lastfm_url;
                                    } else {
                                        echo $song_url_fm;
                                    } ?>">Read more on Last.fm
                                <!--<img border="0" src="<?php echo SERVER_ROOTPATH; ?>images/fm.png">-->
                            </a><?php
                                } else {
                                    //echo substr(strip_tags($description),0, 250);}
                                    $rev_desc_length  = strlen($description);

                                    if ($rev_desc_length > 200) {
                                        ?>
                            <span
                                id="show_less_<?php echo $song_id; ?>"><?php echo  substr(strip_tags($description), 0, 200) . "..."; ?>
                                <a href="javascript:;"
                                    onclick="show_detail_reveiw(<?php echo $song_id; ?>, 'more')">View
                                    more</a>
                            </span>

                            <span
                                id="show_more_<?php echo $song_id; ?>"
                                style="display:none;"><?php echo strip_tags($description); ?>
                                <a href="javascript:;"
                                    onclick="show_detail_reveiw(<?php echo $song_id; ?>, 'less')">View
                                    Less</a>
                            </span>

                            <?php
                                    } else {
                                        echo strip_tags($description);
                                    }
                                } ?>
                        </p>
                        <?php

                            //echo song_adds($song_id,'adds');
                            ?>

                        <p class="buyFromPan" style="font-size:13px;">Buy from: <a target="_blank"
                                href="<?php echo $itunes_url; ?>"><img
                                    src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $img_arr1['store_img'] ?>"></a>
                            | <a target="_blank"
                                href="<?php echo $amazon_url; ?>"><img
                                    src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $img_arr2['store_img'] ?>"></a>
                        </p>

                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="col-sm-12 col-xs-12" style="float:left; margin-left:-5px;">
                    <?php $data = song_adds($song_id, 'video');
                        if (is_array($data)) {
                            echo $data['video_code'];
                        } else {
                            echo $data;
                        } ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php } ?>

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
            <div class="topRwContent-panel" style="margin-bottom:15px;">
                <div class="col-sm-8 " style="padding-left: 0; padding-right:0;">

                    <div class="rating-bar-panel">

                        <div class="clearfix"></div>
                        <h5>Review rating:</h5>
                        <?php

                        if ($sort == "recent_review") {
                            $order_by = " r.review_id desc";
                        } elseif ($sort == "highest_rating") {
                            $order_by = " r.review_rating desc";
                        } elseif ($sort == "lowest_rating") {
                            $order_by = " r.review_rating asc";
                        } elseif ($sort == "most_popular") {
                            $order_by = " r.like_count desc";
                        } else {
                            $order_by = " r.review_id desc";
                        }

                        $rating_where  = "";
                        if ($rate == "excellent") {
                            $rating_where  = " AND (r.review_rating>=8)";
                        } elseif ($rate == "verygood") {
                            $rating_where  = " AND (r.review_rating>=6 AND r.review_rating<8)";
                        } elseif ($rate == "average") {
                            $rating_where  = " AND (r.review_rating>=4 AND r.review_rating<6)";
                        } elseif ($rate == "poor") {
                            $rating_where  = " AND (r.review_rating>=2 AND r.review_rating<4)";
                        } elseif ($rate == "terrible") {
                            $rating_where  = " AND (r.review_rating>=0 AND r.review_rating<2)";
                        }


                        $review_list_qry = "select u.user_name,u.profile_image, r.* from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.song_id = $song_id $rating_where order by $order_by";

                        // $review_list_arr    =    $db->get_results($review_list_qry, ARRAY_A);
                        $review_list_arr = \App\Models\Songs::GetRawData($review_list_qry);
                        ?>

                        <div class="col-sm-12">
                            <div class="row rating-panel">
                                <div class="col-lg-2 col-sm-4 col-xs-3 progressLabel"
                                    style="text-align:left; color:#5ebd5e; padding:0;">
                                    Excellent
                                </div>
                                <div class="col-lg-4 col-sm-6 col-xs-8 progress-panel">
                                    <a
                                        href="<?php echo SERVER_ROOTPATH . Slug($song_seo) ?>/reviews/<?php echo Slug($artist_seo); ?>-rating-excellent">
                                        <div class="progress" style="cursor:pointer;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="88"
                                                aria-valuemin="0" aria-valuemax="100"
                                                style="width:<?php echo $excellent_per; ?>%;  cursor:pointer; background-color:#5ebd5e;">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-1 progressVal" style="color:#5ebd5e;">
                                    <?php echo $excellent; ?>
                                </div>
                            </div>
                            <div class="row rating-panel">
                                <div class="col-lg-2 col-sm-4 col-xs-3 progressLabel"
                                    style="text-align:left; color:#5ebd5e; padding:0;">
                                    Very Good
                                </div>
                                <div class="col-lg-4 col-sm-6 col-xs-8 progress-panel">
                                    <a
                                        href="<?php echo SERVER_ROOTPATH . Slug($song_seo) ?>/reviews/<?php echo Slug($artist_seo); ?>-rating-verygood">
                                        <div class="progress" style="cursor:pointer;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="11"
                                                aria-valuemin="0" aria-valuemax="100"
                                                style="width:<?php echo $verygood_per; ?>%; cursor:pointer; background-color:#5ebd5e;">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-1 progressVal" style="color:#5ebd5e;">
                                    <?php echo $verygood; ?>
                                </div>
                            </div>
                            <div class="row rating-panel">
                                <div class="col-lg-2 col-sm-4 col-xs-3 progressLabel"
                                    style="color:#e06d21; text-align:left; padding:0;">
                                    Average
                                </div>
                                <div class="col-lg-4 col-sm-6 col-xs-8 progress-panel">
                                    <a
                                        href="<?php echo SERVER_ROOTPATH . Slug($song_seo) ?>/reviews/<?php echo Slug($artist_seo); ?>-rating-average">
                                        <div class="progress" style="cursor:pointer;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="33"
                                                aria-valuemin="0" aria-valuemax="100"
                                                style="width:<?php echo $good_per; ?>%; cursor:pointer; background-color:#e06d21;">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-1 progressVal" style="color:#e06d21;">
                                    <?php echo $good; ?>
                                </div>
                            </div>
                            <div class="row rating-panel">
                                <div class="col-lg-2 col-sm-4 col-xs-3 progressLabel"
                                    style="color:#dd554e; text-align:left; padding:0;">
                                    Poor
                                </div>
                                <div class="col-lg-4 col-sm-6 col-xs-8 progress-panel">
                                    <a
                                        href="<?php echo SERVER_ROOTPATH . Slug($song_seo) ?>/reviews/<?php echo Slug($artist_seo); ?>-rating-poor">
                                        <div class="progress" style="cursor:pointer;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="12"
                                                aria-valuemin="0" aria-valuemax="100"
                                                style="width:<?php echo $poor_per; ?>%; cursor:pointer; background-color:#dd554e;">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-1 progressVal" style="color:#dd554e;">
                                    <?php echo $poor; ?>
                                </div>
                            </div>
                            <div class="row rating-panel">
                                <div class="col-lg-2 col-sm-4 col-xs-3 progressLabel"
                                    style="color:#dd554e; text-align:left;padding:0;">
                                    Terrible
                                </div>
                                <div class="col-lg-4 col-sm-6 col-xs-8 progress-panel">
                                    <a
                                        href="<?php echo SERVER_ROOTPATH . Slug($song_seo) ?>/reviews/<?php echo Slug($artist_seo); ?>-rating-terrible">
                                        <div class="progress" style="cursor:pointer;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="2"
                                                aria-valuemin="0" aria-valuemax="100"
                                                style="width:<?php echo $terrible_per; ?>%; background-color:#dd554e;">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-1 progressVal" style="color:#dd554e;">
                                    <?php echo $terrible; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="heading">
                        Write a Review
                    </div>
                    <div class="write-rew-pan" style="width:96%; margin-left:10px;">
                        <!-- <form name="api-readonly" id="api-readonly"  action="" class="form-horizontal"> -->
                        <form action="{{url('process/write_a_review')}}" id="api-readonly" class="form-horizontal">
                            <div>
                                <p class="starLabel">How would you rate?</p>


                                <div class="star-panel">



                                    <input id="input-21b" name="api-readonly-test" value="" type="number"
                                        class="rating test" min=0 max=10 step=0.1 data-size="xs" data-stars="10">


                                    @csrf
                                    <input type="hidden" name="song_seo_name"
                                        value="<?php echo $song_seo; ?>">
                                    <input type="hidden" name="artist_seo_name"
                                        value="<?php echo $artist_seo; ?>">

                                </div>
                                <input type="number" id="manual-rating-score" min=0 max=10 value="0" step="0.1"
                                    style="margin-left: 15px;">




                                <div class="form-group">

                                    <!--<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Review Title">-->
                                    <input type="text" name="review_title" id="review_title" class="form-control"
                                        placeholder="Review Title" value="" autofocus>
                                </div>
                                <div class="form-group">

                                    <textarea class="form-control" rows="4" placeholder="Your Review" id="review_detail"
                                        name="review_detail"></textarea>
                                    <input type="hidden" name="song_id"
                                        value="<?php echo $song_id; ?>">
                                    <input type="hidden" name="artist_id"
                                        value="<?php echo $artist_id; ?>">
                                    <input type="hidden" name="album_id"
                                        value="<?php echo $album_id; ?>">
                                </div>
                                <p class="form-control-static">By posting a review, I accept Tailem.com's
                                    <!--<a href="#"> Posting Guidelines</a> and <a href="#"> Privacy Policy</a>-->
                                    <?php
                                    $get_all_pages_qry = "SELECT page_seo_name,page_name  FROM tbl_pages where page_id = 8 OR page_id = 2 ORDER BY page_id desc";
                                    // $get_all_pages     = $db->get_results($get_all_pages_qry, ARRAY_A);
                                    $get_all_pages = \App\Models\Songs::GetRawData($get_all_pages_qry);
                                    if ($get_all_pages) {
                                        $count_pages = count($get_all_pages);
                                    } else {
                                        $count_pages = 0;
                                    }

                                    if ($get_all_pages) {
                                        $kk = 1;
                                        foreach ($get_all_pages as $page_info) {
                                            $page_info = (array) $page_info; ?>

                                    <a href="<?php echo SERVER_ROOTPATH . "process/detail_cms?seo_url=" . $page_info['page_seo_name']; ?>"
                                        data-toggle="modal"
                                        data-target="#cms_<?php echo $kk; ?>"
                                        data-title=""><?php echo stripslashes($page_info['page_name']); ?></a>
                                    <?php
                                            if ($kk == 1) {
                                                echo "and";
                                            } ?>


                                    <?php
                                            $kk++;
                                        }
                                    }
                                    ?>
                                </p>
                                <p class="error"></p>
                                <button type="submit" class="btn btn-default btn-red">Post Review</button>
                                <!-- <input type="submit" value="Post Review" onClick="return write_a_review_validation_new();" class="btn btn-default btn-red" /> -->


                        </form>
                    </div>
                </div>
                <div style="clear: both"></div>
            </div>
            <div class="col-sm-4 rightRwContPan" style="padding:0;">

                <div class="heading pull-left" style="padding: 10px 5px;">
                    Discussions
                </div>
                <div class="DescPan" style="padding:10px;">
                    <div class="form-group"><br />
                        <textarea class="form-control" name="detail" id="atextarea" rows="5"
                            placehlder="Share your thoughts here..." style="resize: none; color:#000000"></textarea>
                        <input type="hidden" name="song_id"
                            value="<?php echo $song_id; ?>">
                        <input type="hidden" name="artist_id"
                            value="<?php echo $artist_id; ?>">
                        <input type="hidden" name="album_id"
                            value="<?php echo $album_id; ?>">

                    </div>
                    <input id="submit_btn" class="btn btn-default btn-green btn-block" type="submit"
                        onClick="return discussion_post();" value="Post" name="submit_btn">
                    <!--<button type="button" class="btn btn-default btn-green btn-block">Post</button>-->
                </div>
                <div id="pagination" cellspacing="0">

                </div>

            </div>
            <div style="clear: both"></div>
            <div class="heading">
                Related Songs
            </div>


            @include ("common.related_songs")

            <?php //include "common/latest_songs.php";
            ?>

            <div class="clearfix"></div>
        </div>
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

    </div>
    </div>
</section>
<!-- ./Middle Section -->






<style>
    body {
        overflow-x: hidden;
    }

    .form-control {
        height: auto;
    }
</style>

<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
</div>

<?php
for ($u = 1; $u <= $kk; $u++) {
                ?>
<div class="modal fade" id="cms_<?php echo $u; ?>" tabindex="-1"
    role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
            }

for ($us = 1; $us <= $k; $us++) {
    ?>
<div class="modal fade"
    id="missing_store_detail_Modal2_<?php echo $us; ?>" tabindex="-1"
    role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

<div class="modal fade" id="model_review_likes_<?php echo $us; ?>"
    tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}

for ($g = 1; $g <= $k; $g++) {
    ?>
<div class="modal fade" id="report_Modal4_<?php echo $g; ?>"
    tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}

for ($g = 1; $g <= 20; $g++) {
    ?>
<div class="modal fade" id="edit_Modal4_<?php echo $g; ?>"
    tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

<?php
}

for ($g = 1; $g <= 20; $g++) {
    ?>
<div class="modal fade" id="edit_Modal4s_<?php echo $g; ?>"
    tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

<?php
}



?>
@include('common.signin_modal')

<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
</div>
<div class="modal fade" id="profile_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
</div>
<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
</div>
<div class="modal fade" id="discussion_popup" style="display:none" tabindex="-1" role="dialog"
    aria-labelledby="basicModal">
    <div class="modal-dialog" style="margin-top:10%;">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#3276b1;"> Thank you for your post <img data-dismiss="modal"
                        onclick="discussion_popup_close()" style="cursor:pointer; float:right;"
                        src="data:image/webp;base64,UklGRg4BAABXRUJQVlA4TAIBAAAvFUAFEE+hkI0kqAqrcP6Sr4OCtm0Y7/PnNVACgRSnsMJq2khyoyNdDu1R+eoVtm2DdMy7wwMOWQ3Bh2BH40FwEAgKBUFB9pdU1E06UpGKjl4fHEa2rTQPd3duDE1e/w0i70NKiOh/kjD9OOu3LPZNutDDBkoT6iStFJepRadd4qa0addS3KYabSH+CMmocQ7riG1Z3zhrw4V4/Pg58ALpx5ADz19+Q8YFlC9vM5SqgTLw9oTSNVDWH09Q2gJy4PnLL8gihnj8+DnwAhl7EBNP2L78gfCNBuKB4wHRGBTij5A2LcNtptNuV7ipbDqdFJepQ1KPGihNpNOFGSQ5tjwJTBI="
                        data-pagespeed-url-hash="3119113509"
                        onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                </h4>
            </div>
            <div class="modal-body" style="overflow-y:auto; min-height:250px;">
                <p>
                    Your post will appear shortly. Thank you for sharing your thoughts and we value your contributions
                    to our site. <br /><br /><br />

                    Warmest Regards,<br />
                    Team at Tailem.com
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript
================================================== -->

<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript">
    var jq = jQuery.noConflict();
    jq(window).load(function() {
        $('#owl-carousel1').owlCarousel({
            loop: false,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                700: {
                    items: 2,
                    nav: false
                },
                1000: {
                    items: 3,
                    nav: false,
                    loop: false,
                    margin: 20
                }
            }
        })
        $('#owl-carousel2').owlCarousel({
            loop: false,
            margin: 10,
            responsiveClass: true,
            dot: false,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },

            }
        })
    })
</script>
<script type="text/javascript">
    $(function() {
        $('.topsongssec .next').on('click', function() {
            $('.topsongssec .owl-next').click();
        })
        $('.topsongssec .prev').on('click', function() {
            $('.topsongssec .owl-prev').click();
        })
    })
</script>

<!-- <script type="text/javascript" src="<?php echo SERVER_ROOTPATH; ?>script.js">
</script> -->
<div class="modal fade" id="show_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
</div>
<div class="modal fade" id="create_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal"
    aria-hidden="true"></div>


<?php
// include("include/thankyou_messages.php");
?>

@include('common.footer')


<!-----------Clean Code------------------>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript"
    src="<?php echo SERVER_ROOTPATH; ?>js/bootstrap.js"></script>
<script src="<?php echo SERVER_ROOTPATH; ?>js/star-rating.js"
    type="text/javascript"></script>

<!-- Alread review added message-->
<div class="modal fade" id="already_review" style="display:none" tabindex="-1" role="dialog"
    aria-labelledby="basicModal">
    <div class="modal-dialog" style="margin-top:10%;">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#3276b1;"> Thank you for posting a review <img data-dismiss="modal"
                        style="cursor:pointer; float:right;"
                        src="data:image/webp;base64,UklGRg4BAABXRUJQVlA4TAIBAAAvFUAFEE+hkI0kqAqrcP6Sr4OCtm0Y7/PnNVACgRSnsMJq2khyoyNdDu1R+eoVtm2DdMy7wwMOWQ3Bh2BH40FwEAgKBUFB9pdU1E06UpGKjl4fHEa2rTQPd3duDE1e/w0i70NKiOh/kjD9OOu3LPZNutDDBkoT6iStFJepRadd4qa0addS3KYabSH+CMmocQ7riG1Z3zhrw4V4/Pg58ALpx5ADz19+Q8YFlC9vM5SqgTLw9oTSNVDWH09Q2gJy4PnLL8gihnj8+DnwAhl7EBNP2L78gfCNBuKB4wHRGBTij5A2LcNtptNuV7ipbDqdFJepQ1KPGihNpNOFGSQ5tjwJTBI="
                        data-pagespeed-url-hash="3119113509"
                        onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                </h4>
            </div>
            <div class="modal-body" style="overflow-y:auto; min-height:250px;">
                <p>
                    It seems you have already posted a review on this song. <br />
                    Please use the edit function to revise your review.<br /><br /><br />

                    Warmest Regards,<br />
                    Team at Tailem.com
                </p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="error_popup" style="display:none" tabindex="-1" role="dialog" aria-labelledby="basicModal">
    <div class="modal-dialog" style="margin-top:10%;">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#3276b1;"> <span id="modal_title_error"></span> <img
                        data-dismiss="modal" style="cursor:pointer; float:right;"
                        src="data:image/webp;base64,UklGRg4BAABXRUJQVlA4TAIBAAAvFUAFEE+hkI0kqAqrcP6Sr4OCtm0Y7/PnNVACgRSnsMJq2khyoyNdDu1R+eoVtm2DdMy7wwMOWQ3Bh2BH40FwEAgKBUFB9pdU1E06UpGKjl4fHEa2rTQPd3duDE1e/w0i70NKiOh/kjD9OOu3LPZNutDDBkoT6iStFJepRadd4qa0addS3KYabSH+CMmocQ7riG1Z3zhrw4V4/Pg58ALpx5ADz19+Q8YFlC9vM5SqgTLw9oTSNVDWH09Q2gJy4PnLL8gihnj8+DnwAhl7EBNP2L78gfCNBuKB4wHRGBTij5A2LcNtptNuV7ipbDqdFJepQ1KPGihNpNOFGSQ5tjwJTBI="
                        data-pagespeed-url-hash="3119113509"
                        onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                </h4>
            </div>
            <div class="modal-body" style="overflow-y:auto; min-height:250px;">
                <p>
                    <span id="modal_body_error"></span> <br /><br /><br />

                    Warmest Regards,<br />
                    Team at Tailem.com
                </p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="show_success_message_song" style="display:none" tabindex="-1" role="dialog"
    aria-labelledby="basicModal">
    <div class="modal-dialog" style="margin-top:10%;">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#3276b1;"> Thank you for your review <img data-dismiss="modal"
                        style="cursor:pointer; float:right;"
                        src="data:image/webp;base64,UklGRg4BAABXRUJQVlA4TAIBAAAvFUAFEE+hkI0kqAqrcP6Sr4OCtm0Y7/PnNVACgRSnsMJq2khyoyNdDu1R+eoVtm2DdMy7wwMOWQ3Bh2BH40FwEAgKBUFB9pdU1E06UpGKjl4fHEa2rTQPd3duDE1e/w0i70NKiOh/kjD9OOu3LPZNutDDBkoT6iStFJepRadd4qa0addS3KYabSH+CMmocQ7riG1Z3zhrw4V4/Pg58ALpx5ADz19+Q8YFlC9vM5SqgTLw9oTSNVDWH09Q2gJy4PnLL8gihnj8+DnwAhl7EBNP2L78gfCNBuKB4wHRGBTij5A2LcNtptNuV7ipbDqdFJepQ1KPGihNpNOFGSQ5tjwJTBI="
                        data-pagespeed-url-hash="3119113509"
                        onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                </h4>
            </div>
            <div class="modal-body" style="overflow-y:auto; min-height:250px;">
                <p>
                    Your review has been posted and will appear shortly. Thank you for sharing your thoughts and we
                    value your contributions to our site. <br /><br /><br />

                    Warmest Regards,<br />
                    Team at Tailem.com
                </p>
            </div>
        </div>
    </div>
</div>



<script>
    $('#api-readonly').submit(function(e) {
        e.preventDefault();
        e.stopPropagation();
        let form = $(this).serialize();
        let url = $(this).attr('action');

        $.ajax({
            type: 'POST',
            url: url,
            data: form,
            dataType: 'html',
            success: function(data) {
                let res = JSON.parse(data);
                switch (res.code) {
                    case 'success':
                        $("#show_success_message_song").modal("show");
                        $("#api-readonly").each(function() {
                            this.reset();
                        });
                        setTimeout(function() {
                            window.location.replace(res.url);
                        }, 1500)
                        break;
                    case 'warning':
                        if (res.message == "Please sign in first.") {
                            $("#signin_form").modal("show");
                        } else if (
                            res.message ==
                            "You have already posted a review on this song. Please use the EDIT function to revise your review."
                        ) {
                            $("#already_review").modal("show");
                            setTimeout(function() {
                                window.location.replace(res.url);
                            }, 1500)
                        } else {
                            $("#error_popup").modal("show");
                            $("#modal_title_error").html("Thank you");
                            responseText = res.message.replace(/\n/g, "<br />");
                            $("#modal_body_error").html(responseText);
                        }

                }
            }
        });

    })
</script>


<script type="text/javascript">
    //<![CDATA[
    jq(function() {
        var csrf_token = $('meta[name=csrf-token]').attr('content');
        jq.ajax({
            url: "<?php echo SERVER_ROOTPATH; ?>process/dbmanupulate",
            type: "POST",
            // data: "actionfunction=showData&page=1&song_id=" +
            //     <?php echo $song_id ?>
            //     ,
            data: {
                'actionfunction': 'showData',
                'page': 1,
                'song_id': <?php echo $song_id ?> ,
                "_token": csrf_token,
            },
            cache: false,
            success: function(response) {
                jq('#pagination').html(response);
            }
        });
        jq('#pagination').on('click', '.page-numbers', function() {
            jqpage = jq(this).attr('href');
            jqpageind = jqpage.indexOf('page=');
            jqpage = jqpage.substring((jqpageind + 5));
            jq.ajax({
                url: "<?php echo SERVER_ROOTPATH; ?>process/dbmanupulate",
                type: "POST",
                data: {
                    'actionfunction': 'showData',
                    'page': $jqpage,
                    'song_id': <?php echo $song_id ?> ,
                    "_token": csrf_token,
                },
                cache: false,
                success: function(response) {
                    jq('#pagination').html(response);
                }
            });
            return false;
        });
    });
    //]]>
</script>
<script>
    $("#manual-rating-score").bind('keyup mouseup', function() {
        let score = $('#manual-rating-score').val();
        $('#input-21b').val(score)
        let width = (score * 10) + '%';
        $('.filled-stars').css('width', width);
    });
</script>
<!-- post discussion -->
<script type="text/javascript">
    function discussion_post() {
        value = jq('#atextarea').val();
        var csrf_token = $('meta[name=csrf-token]').attr('content');
        jq.ajax({
            url: "<?php echo SERVER_ROOTPATH; ?>process/discussion_process",
            type: "POST",
            data: {
                'artist_id': <?php echo $artist_id; ?> ,
                'album_id': <?php echo $album_id; ?> ,
                'song_id': <?php echo $song_id ?> ,
                'detail': value,
                "_token": csrf_token,
            },
            cache: false,
            success: function(html) {
                if (html == "Please sign in first") {
                    $('#signin_form').modal('show');
                } else
                if (html.search('done') != -1) {
                    $('#atextarea').val('');
                    $('#discussion_popup').modal('show');


                } else {
                    $('#error_popup').modal('show');
                    $('#modal_title_error').html('Thank you');
                    $('#modal_body_error').html(html);

                }
            }
        });

    }

    song_id = <?php echo $song_id; ?> ;

    function discussion_popup_close() {
        window.location.reload();
    }
</script>