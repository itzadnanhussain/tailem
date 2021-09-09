@include('common.header')
<!-- ./Header end -->
<?php
// include("common/topfile.php");
// include("common/function.php");
// include_once("common/header.php");

$_SESSION['store']['rating'] = 5;
$_SESSION['store']['review_title'] = 'test';
$_SESSION['store']['review_detail'] = 'test detail';
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
$artist_seo = strtolower(stripslashes(html_entity_decode($song_list_arr['artist_seo'])));
$song_seo   = strtolower(stripslashes(html_entity_decode($song_list_arr['song_seo'])));
$picture   = stripslashes(html_entity_decode($song_list_arr['picture']));
$album_artist_id   =  stripslashes(html_entity_decode($song_list_arr['album_artist_id']));
$description = stripslashes(html_entity_decode($song_list_arr['description']));
$album_seo  = strtolower(stripslashes(html_entity_decode($song_list_arr['album_seo'])));




$mainartist_arr    =    mainartist_detail($album_artist_id);


$artist_name = stripslashes($mainartist_arr['artist_name']);
$artist_seo     = stripslashes($mainartist_arr['artist_seo']);

$song_url_fm = $lastfm_url;
$song_summary_fm = $description;
$song_image_fm = $picture;


if ($lastfm_url = "") {
    /****************** LASTFM CALL********/
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

    /****************** LASTFM CALL********/
}

$artist_id    =    stripslashes(html_entity_decode($song_list_arr['artist_id']));

$album_title = wordwrap($album_title, 100, " ", true);
$artist_name = wordwrap($artist_name, 100, " ", true);

$album_artist_id = stripslashes(html_entity_decode($song_list_arr['album_artist_id']));




///
$counter_main = array();
$counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'artist' AND like_id = '$artist_id'");
if ($counter_main) {
    $counter_main = count($counter_main);
} else {
    $counter_main = 0;
}







$discussion_list_qry = "select u.user_name,u.profile_image, c.* from tbl_users u, tbl_comments c where u.user_id = c.comment_user_id AND c.comment_review_id = $song_id order by comment_id desc";
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
<style type="text/css">
    a.under_line {
        text-decoration: none !important;
    }

    a.under_line:hover {
        text-decoration: underline !important;
    }
</style>
<?php
// include_once("common/header.php");
// include_once("common/signin_modal_header.php");

?>


<script type="text/javascript">
    function sort_area(val) {
        window.location.href = "<?php echo SERVER_ROOTPATH . $song_seo ?>-reviews-<?php echo $artist_seo; ?>-sort-" + val;
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

    function full_review_display(val) {
        $("#half_view_review_" + val).hide();
        $("#full_view_review_" + val).show();
    }

    function full_review_sdisplay(val) {
        $("#half_sview_review_" + val).hide();
        $("#full_sview_review_" + val).show();
    }

    function full_review_ipaddisplay(val) {
        $("#half_ipadview_review_" + val).hide();
        $("#full_ipadview_review_" + val).show();
    }

    $(document).on('hide.bs.modal', '#report_edit_success', function() {
        alert('');
        //Do stuff here
    });
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
                        $feature_artists .= " <a style='color:#D73B3B' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs' >" . $val_feature['feature_artist'] . "</a>";
                    } else {
                        $feature_artists .= " <a style='color:#D73B3B' href='" . SERVER_ROOTPATH . $val_feature['f_artist_seo'] . "-artist-songs'>" . $val_feature['feature_artist'] . "</a>,";
                    }
                    $num++;
                }
            }

            ?>
            <?php if ($mobile_view == 0) { ?>
                <div class="topRwHead-panel" style="margin:12px 0 !important; padding-bottom:0; padding-top:10px;">
                    <div class="col-lg-8 col-md-8 mrg_btm">
                        <div class="col-sm-5 artist-img-panel pad_zero">
                            <!--<p>10</p>
						<img src="images/img-1.jpg" class="img-responsive  artist-img">-->
                            <div class="latestsongssec">
                                <div class="list_item">
                                    <div class="album_cover" style="border-radius:0px;">
                                        <a href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>"> <?php

                                                                                                                            if ($picture != "") {
                                                                                                                                $song_pic = SERVER_ROOTPATH . "site_upload/song_images/thumb_" . $picture;
                                                                                                                                $img_api_link = album_img_api($picture);
                                                                                                                                if ($img_api_link != '') {
                                                                                                                            ?>
                                                    <img src="<?php echo $img_api_link; ?>" class="img-responsive  artist-img" style="max-height:250px;" />
                                                <?php } else { ?>
                                                    <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>" class="img-responsive  artist-img" style="max-height:250px;" />
                                                <?php
                                                                                                                                }
                                                                                                                            } else
													 if ($song_image_fm != "") {
                                                ?>
                                                <img src="<?php echo $song_image_fm; ?>" class="img-responsive  artist-img" style="max-height:250px;" />
                                            <?php
                                                                                                                            } else
												    if ($album_picture != "") {


                                                                                                                                $song_pic = SERVER_ROOTPATH . "site_upload/album_images/thumb_" . $album_picture;
                                                                                                                                //$song_pic = $album_picture;
                                            ?>
                                                <img src="<?php echo $album_picture; ?>" class="img-responsive  artist-img" style="max-height:250px;" />
                                            <?php
                                                                                                                            } else {
                                                                                                                                $song_pic = SERVER_ROOTPATH . "assets/images/no_image4.png";
                                            ?>
                                                <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" class="img-responsive  artist-img" style="max-height:250px;" />
                                            <?php
                                                                                                                            }
                                            ?></a>
                                        <cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg == 10) {
                                                                                                        echo number_format($all_avg, 0);
                                                                                                    } else {
                                                                                                        echo $all_avg;
                                                                                                    } ?></cite>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7 desc-panel">
                            <p class="title"><a style='color:#000000;' href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>"><?php echo $song_title; ?></a></p>
                            <p class="sub-title" style="font-size:14px;"> <a style='color:#D73B3B;' href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><?php echo $artist_name; ?></a>
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
                                        $counter1 = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$artist_id'");
                                        if ($counter1) {
                                            $counter1 = count($counter1);
                                        } else {
                                            $counter1 = 0;
                                        }
                                        if ($counter1 == 0) { ?>
                                            <span id="other_dis_sub_<?php echo $artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_rev('<?php echo $artist_id; ?>','<?php echo $artist_seo; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" style="color:#000; font-weight:normal;" class="link-disable"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                            <span id="myStyle_sub_<?php echo $artist_id; ?>"></span>

                                        <?php } else { ?>
                                            <span id="other_dis_sub_<?php echo $artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_rev('<?php echo $artist_id; ?>','<?php echo $artist_seo; ?>')" class="like"><i class="fa fa-heart heart_color heart_size"></i></a> <span><?php echo $counter_main; ?></span> <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" style="color:#000; font-weight:normal;" class="link-disable"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>

                                            <span id="myStyle_sub_<?php echo $artist_id; ?>" class="text_grey"></span>
                                        <?php }
                                    } else {
                                        ?>
                                        <span id="other_dis_sub_<?php echo $artist_id; ?>">
                                            <?php
                                            if ($user_id == "") {
                                            ?>
                                                <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                            <?php
                                            } else {
                                            ?>
                                                <a href="javascript:;" onClick="add_in_favourite_list_rev('<?php echo $artist_id; ?>','<?php echo $artist_seo; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                            <?php
                                            }
                                            ?>

                                            <span class="red-text"><?php echo $counter_main; ?></span> <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" style="color:#000; font-weight:normal;" class="link-disable"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                        <span id="myStyle_sub_<?php echo $artist_id; ?>"></span>
                                    <?php
                                    }
                                    ?>
                                </label>
                            </p>

                            <div class="activity-panel">
                                <label class="likes"><img src="<?php echo SERVER_ROOTPATH; ?>static/images/review-book.png"> <a style="color:#000000; font-weight:normal;"><span class="red-text"> <?php echo $counter; ?> </span> Reviews</a></label>
                                <label class="likes"><img src="<?php echo SERVER_ROOTPATH; ?>static/images/icon_post.png"> <a style="color:#000000; font-weight:normal;"><span class="red-text"> <?php echo $count_discussion; ?> </span> Posts</a></label>

                                <?php
                                if ($user_id == "") {
                                ?>
                                    <a href="#" data-toggle="modal" data-target="#signin_form" style="padding:0; float:right; margin-right:6px; margin-top:-10px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                <?php
                                } else {
                                ?>
                                    <a data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add_playlist.php?song_id=<?php echo $song_id; ?>&art_id=<?php echo $album_artist_id; ?>" style="padding:0; float:right; margin-right:6px; margin-top:-10px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
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
                                    }

                                ?> <br><a href="<?php if ($lastfm_url != "") {
                                                    echo $lastfm_url;
                                                } else {
                                                    echo $song_url_fm;
                                                } ?>">Read more on Last.fm
                                        <!--<img border="0" src="<?php echo SERVER_ROOTPATH; ?>images/fm.png">-->
                                    </a><?php } else {
                                        //echo substr(strip_tags($description),0, 250);}
                                        $rev_desc_length  = strlen($description);
                                        //echo substr(strip_tags($description),0,200);
                                        if ($rev_desc_length > 200) {

                                        ?>
                                        <span id="show_less_<?php echo $song_id; ?>"><?php echo  substr(strip_tags($description), 0, 200) . "..."; ?>
                                            <a href="javascript:;" onclick="show_detail_reveiw(<?php echo $song_id; ?>, 'more')">View more</a>
                                        </span>

                                        <span id="show_more_<?php echo $song_id; ?>" style="display:none;"><?php echo strip_tags($description); ?>
                                            <a href="javascript:;" onclick="show_detail_reveiw(<?php echo $song_id; ?>, 'less')">View Less</a>
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

                            <a style="margin-bottom:5px; margin-top:0;" href="<?php echo SERVER_ROOTPATH . $song_seo . "-write-a-review-" . $artist_seo; ?>" class="btn btn-default btn-red"> <img src="images/pence;.png">Write a Review</a>
                            <div class="clearfix"></div>
                            <p class="buyFromPan" style="margin-bottom: 15px; font-size:13px;">Buy from:
                                <a target="_blank" href="<?php echo $itunes_url; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $img_arr1['store_img'] ?>"></a> |


                                <a target="_blank" href="<?php echo $amazon_url; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $img_arr2['store_img'] ?>"></a>

                                <!-- |
							<a target="_blank" href="<?php echo $google_url; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $img_arr3['store_img'] ?>"></a>-->
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

                    </div>






                    <div class="clearfix"></div>
                </div>
            <?php
            } elseif ($mobile_view == 1) { ?>
                <div class="topRwHead-panel" style="margin:12px 0 !important; padding-bottom:0; padding-top:5px;">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mrg_btm pad_zero" style="margin-bottom:0; padding:0;">
                        <!--<p>10</p>
						<img src="images/img-1.jpg" class="img-responsive  artist-img">-->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding:0px; padding-left:10px;">
                                <div class="latestsongssec artist-img-panel">
                                    <div class="list_item">
                                        <div class="album_cover" style="border-radius:0;">
                                            <a href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>"> <?php
                                                                                                                                if ($picture != "") {
                                                                                                                                    $song_pic = SERVER_ROOTPATH . "site_upload/song_images/thumb_" . $picture;
                                                                                                                                    $img_api_link = album_img_api($picture);
                                                                                                                                    if ($img_api_link != '') {
                                                                                                                                ?>
                                                        <img src="<?php echo $img_api_link; ?>" class="img-responsive  artist-img" />
                                                    <?php } else { ?>
                                                        <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>" class="img-responsive  artist-img" />
                                                    <?php
                                                                                                                                    }
                                                                                                                                } else
													 if ($song_image_fm != "") {
                                                    ?>
                                                    <img src="<?php echo $song_image_fm; ?>" class="img-responsive  artist-img" />
                                                <?php
                                                                                                                                } else
												    if ($album_picture != "") {
                                                                                                                                    $song_pic = SERVER_ROOTPATH . "site_upload/album_images/thumb_" . $album_picture;
                                                ?>
                                                    <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" class="img-responsive  artist-img" />
                                                <?php
                                                                                                                                } else {
                                                                                                                                    $song_pic = SERVER_ROOTPATH . "assets/images/no_image4.png";
                                                ?>
                                                    <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" class="img-responsive  artist-img" />
                                                <?php
                                                                                                                                }
                                                ?></a>
                                            <cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg == 10) {
                                                                                                            echo number_format($all_avg, 0);
                                                                                                        } else {
                                                                                                            echo $all_avg;
                                                                                                        } ?></cite>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding:5px;">
                                <p class="title" style="font-weight:bold; font-size:20px; margin-bottom:5px;"><a style='color:#000000;' href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>"><?php echo $song_title; ?></a></p>
                                <p class="sub-title" style="color:#dd554e; font-size:18px; margin-bottom:4px; min-height:30px;"><a style='color:#D73B3B;' href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><?php echo $artist_name; ?></a>
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
                                            <span id="other_dis_sub_<?php echo $artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_rev('<?php echo $artist_id; ?>','<?php echo $artist_seo; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span class="red-text"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" style="color:#000; font-weight:normal;" class="link-disable"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>

                                            <span id="myStyle_sub_<?php echo $artist_id; ?>"></span>

                                        <?php } else { ?>
                                            <span id="other_dis_sub_<?php echo $artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_rev('<?php echo $artist_id; ?>','<?php echo $artist_seo; ?>')" class="like"><i class="fa fa-heart heart_color heart_size"></i></a> <span class="red-text"><?php echo $counter_main; ?></span> <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" style="color:#000; font-weight:normal;" class="link-disable"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>

                                            <span id="myStyle_sub_<?php echo $artist_id; ?>" class="text_grey"></span>
                                        <?php }
                                    } else {
                                        ?>
                                        <span id="other_dis_sub_<?php echo $artist_id; ?>">
                                            <?php
                                            if ($user_id == "") {
                                            ?>
                                                <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                            <?php
                                            } else {
                                            ?>
                                                <a href="javascript:;" onClick="add_in_favourite_list_rev('<?php echo $artist_id; ?>','<?php echo $artist_seo; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                            <?php
                                            }
                                            ?>

                                            <span class="red-text"><?php echo $counter_main; ?></span> <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" style="color:#000; font-weight:normal;" class="link-disable"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                        <span id="myStyle_sub_<?php echo $artist_id; ?>"></span>
                                    <?php
                                    }
                                    ?>
                                </label>

                                <?php
                                if ($user_id == "") {
                                ?>
                                    <a href="#" data-toggle="modal" data-target="#signin_form" style="padding:0; float:right; margin-right:6px; margin-top:-10px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                <?php
                                } else {
                                ?>
                                    <a data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add_playlist.php?song_id=<?php echo $song_id; ?>&art_id=<?php echo $album_artist_id; ?>" style="padding:0; float:right; margin-right:6px; margin-top:-10px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                <?php
                                }
                                ?>

                                <div class="clearfix"></div>
                                <div class="activity-panel">

                                    <label class="likes"><img src="<?php echo SERVER_ROOTPATH; ?>static/images/review-book.png"> <a style="color:#000000; font-weight:normal;"><span class="red-text"><?php echo $counter; ?> </span> Reviews</a></label>
                                    <label class="likes"><img src="<?php echo SERVER_ROOTPATH; ?>static/images/icon_post.png"> <a style="color:#000000; font-weight:normal;"><span class="red-text"> <?php echo $count_discussion; ?> </span> Posts</a></label>


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
                                    }
                                ?> <br><a href="<?php if ($lastfm_url != "") {
                                                    echo $lastfm_url;
                                                } else {
                                                    echo $song_url_fm;
                                                } ?>">Read more on Last.fm
                                        <!--<img border="0" src="<?php echo SERVER_ROOTPATH; ?>images/fm.png">-->
                                    </a><?php } else {
                                        //echo substr(strip_tags($description),0, 250);}
                                        $rev_desc_length  = strlen($description);

                                        if ($rev_desc_length > 200) {

                                        ?>
                                        <span id="show_less_<?php echo $song_id; ?>"><?php echo  substr(strip_tags($description), 0, 200) . "..."; ?>
                                            <a href="javascript:;" onclick="show_detail_reveiw(<?php echo $song_id; ?>, 'more')">View more</a>
                                        </span>

                                        <span id="show_more_<?php echo $song_id; ?>" style="display:none;"><?php echo strip_tags($description); ?>
                                            <a href="javascript:;" onclick="show_detail_reveiw(<?php echo $song_id; ?>, 'less')">View Less</a>
                                        </span>

                                <?php
                                        } else {
                                            echo strip_tags($description);
                                        }
                                    } ?>
                            </p>
                            <?php

                            $list =  song_adds($song_id, 'adds');

                            ?>

                            <a href="<?php echo SERVER_ROOTPATH . $song_seo . "-write-a-review-" . $artist_seo; ?>" class="btn btn-default btn-red"> <img src="images/pence;.png" style="float:left;">Write a Review</a>
                            <div class="clearfix"></div>
                            <p class="buyFromPan" style="font-size:12px;">Buy from:
                                <a target="_blank" href="<?php echo $itunes_url; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $img_arr1['store_img'] ?>"></a> |
                                <a target="_blank" href="<?php echo $amazon_url; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $img_arr2['store_img'] ?>"></a>
                                <!-- |
							<a target="_blank" href="<?php echo $google_url; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo $img_arr3['store_img'] ?>"></a>-->
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
                <div class="col-sm-8 pad_left pad_right">
                    <div class="heading pull-left">
                        Reviews
                    </div>
                    <div class="rating-bar-panel">
                        <div class="pull-right">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label>Sort by</label>
                                    <select class="form-control" id="sort" onChange="sort_area(this.value)">
                                        <option value="recent_review" <?php if ($sort == "recent_review") { ?> selected<?php } ?>>Recent</option>
                                        <option value="highest_rating" <?php if ($sort == "highest_rating") { ?> selected<?php } ?>>Highest Rating</option>
                                        <option value="lowest_rating" <?php if ($sort == "lowest_rating") { ?> selected<?php } ?>>Lowest Rating</option>
                                        <option value="most_popular" <?php if ($sort == "most_popular") { ?> selected<?php } ?>>Most Popular</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                        <h5>Review rating:</h5>
                        <?php

                        if ($sort == "recent_review") {
                            $order_by = " r.review_id desc";
                        } else
				if ($sort == "highest_rating") {
                            $order_by = " r.review_rating desc";
                        } else
				if ($sort == "lowest_rating") {
                            $order_by = " r.review_rating asc";
                        } else
				if ($sort == "most_popular") {
                            $order_by = " r.like_count desc";
                        } else {
                            $order_by = " r.review_id desc";
                        }

                        $rating_where  = "";
                        if ($rate == "excellent") {
                            $rating_where  = " AND (r.review_rating>=8)";
                        } else
				if ($rate == "verygood") {
                            $rating_where  = " AND (r.review_rating>=7 AND r.review_rating<8)";
                        } else
				if ($rate == "average") {
                            $rating_where  = " AND (r.review_rating>=4 AND r.review_rating<7)";
                        } else
				if ($rate == "poor") {
                            $rating_where  = " AND (r.review_rating>=2 AND r.review_rating<4)";
                        } else
				if ($rate == "terrible") {
                            $rating_where  = " AND (r.review_rating>=0 AND r.review_rating<2)";
                        }


                        $review_list_arr = array();
                        if (empty($review_list_arr)) {

                            $review_list_qry = "select u.user_name,u.profile_image, r.* from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.song_id = $song_id $rating_where order by $order_by";

                            $review_list_arr = \App\Models\Songs::GetRawData($review_list_qry);
                        }




                        // if ($_REQUEST['rate'] != '') {
                        //     $targetpage = SERVER_ROOTPATH . $_REQUEST['song_seo'] . "-reviewslist-" . $_REQUEST['artist_seo'] . "-rating-" . $_REQUEST['rate'];
                        // } else
                        // 					if ($_REQUEST['sort'] != '') {
                        //     $targetpage = SERVER_ROOTPATH . $_REQUEST['song_seo'] . "-reviews-" . $_REQUEST['artist_seo'] . "-sort-" . $_REQUEST['sort']; //your file name  (the name of this file)
                        // } else {
                        //     $targetpage = SERVER_ROOTPATH . $_REQUEST['song_seo'] . "-reviewslist-" . $_REQUEST['artist_seo']; //your file name  (the name of this file)
                        // }



                        // $total_pages = count($review_list_arr);
                        // $limit = 10;
                        // if ($page)
                        //     $start = ($page - 1) * $limit; //first item to display on this page
                        // else
                        //     $start = 0;                    //if no page var is given, set start to 0
                        // //PAGGING CODE ENDS HERE	
                        // //============================================================

                        // if (isset($page) && $page != "") {
                        //     $sr_no = ($page * $limit) - $limit;
                        // } else {
                        //     $sr_no = 0;
                        // }

                        // $c = 1;
                        // $review_list_arr = array_slice($review_list_arr, $start, 10);
                        ?>

                        <div class="col-sm-12">
                            <div class="row rating-panel">
                                <div class="col-lg-2 col-sm-4 col-xs-3 progressLabel pad_zero" style="text-align:left; color:#5ebd5e;">
                                    Excellent
                                </div>
                                <div class="col-lg-4 col-sm-6 col-xs-8 progress-panel">
                                    <a href="<?php echo SERVER_ROOTPATH . $song_seo ?>-reviews-<?php echo $artist_seo; ?>-rating-excellent">
                                        <div class="progress" style="cursor:pointer;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $excellent_per; ?>%;  cursor:pointer; background-color:#5ebd5e;"></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-1 progressVal" style="color:#5ebd5e;">
                                    <?php echo $excellent; ?>
                                </div>
                            </div>
                            <div class="row rating-panel">
                                <div class="col-lg-2 col-sm-4 col-xs-3 progressLabel" style="text-align:left; color:#5ebd5e; padding:0;">
                                    Very Good
                                </div>
                                <div class="col-lg-4 col-sm-6 col-xs-8 progress-panel">
                                    <a href="<?php echo SERVER_ROOTPATH . $song_seo ?>-reviews-<?php echo $artist_seo; ?>-rating-verygood">
                                        <div class="progress" style="cursor:pointer;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $verygood_per; ?>%; cursor:pointer; background-color:#5ebd5e;"></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-1 progressVal" style="color:#5ebd5e;">
                                    <?php echo $verygood; ?>
                                </div>
                            </div>
                            <div class="row rating-panel">
                                <div class="col-lg-2 col-sm-4 col-xs-3 progressLabel" style="color:#e06d21; text-align:left; padding:0;">
                                    Average
                                </div>
                                <div class="col-lg-4 col-sm-6 col-xs-8 progress-panel">
                                    <a href="<?php echo SERVER_ROOTPATH . $song_seo ?>-reviews-<?php echo $artist_seo; ?>-rating-average">
                                        <div class="progress" style="cursor:pointer;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $good_per; ?>%; cursor:pointer; background-color:#e06d21;"></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-1 progressVal" style="color:#e06d21;">
                                    <?php echo $good; ?>
                                </div>
                            </div>
                            <div class="row rating-panel">
                                <div class="col-lg-2 col-sm-4 col-xs-3 progressLabel" style="color:#dd554e; text-align:left; padding:0;">
                                    Poor
                                </div>
                                <div class="col-lg-4 col-sm-6 col-xs-8 progress-panel">
                                    <a href="<?php echo SERVER_ROOTPATH . $song_seo ?>-reviews-<?php echo $artist_seo; ?>-rating-poor">
                                        <div class="progress" style="cursor:pointer;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $poor_per; ?>%; cursor:pointer; background-color:#dd554e;"></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-1 progressVal" style="color:#dd554e;">
                                    <?php echo $poor; ?>
                                </div>
                            </div>
                            <div class="row rating-panel">
                                <div class="col-lg-2 col-sm-4 col-xs-3 progressLabel" style="color:#dd554e; text-align:left;padding:0;">
                                    Terrible
                                </div>
                                <div class="col-lg-4 col-sm-6 col-xs-8 progress-panel">
                                    <a href="<?php echo SERVER_ROOTPATH . $song_seo ?>-reviews-<?php echo $artist_seo; ?>-rating-terrible">
                                        <div class="progress" style="cursor:pointer;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $terrible_per; ?>%; background-color:#dd554e;"></div>
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
                    <div class="rew_list-panel" style=" <?php if ($mobile_view == 0) { ?> padding:0; <?php } ?>">
                        <?php
                      
                        if ($review_list_arr) {
                            $rep = 0;
                            $k = 0;
                            $prof_counter = 0;
                            foreach ($review_list_arr as $val_review) {
                               
                                $val_review = (array)$val_review;
                                $k++;
                                $rep++;
                                $prof_counter++;
                                $db_review_id   = $val_review['review_id'];
                                $db_user_name     = stripslashes($val_review['user_name']);
                                $db_review_title  = stripslashes($val_review['review_title']);
                                $review_user_id  = stripslashes($val_review['review_user_id']);

                                if ($user_id != "") {
                                    $report_status = check_report_review($db_review_id);
                                }

                                $query_likes_count  = array();
                                $query_likes_count = \App\Models\Songs::GetRawData("select u.user_name, u.profile_image from tbl_likes l, tbl_users u where u.user_id = l.like_from_user_id AND l.like_from_user_id = $review_user_id AND l.like_type = 'profile'");
                                if ($query_likes_count) {
                                    $query_likes_count = count($query_likes_count);
                                } else {
                                    $query_likes_count = 0;
                                }



                                $like_list_user_qry  = array();
                                // recent like pick query
                                $like_list_user_qry = "select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '" . $review_user_id . "' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1";
                                $like_list_arr_user = \App\Models\Songs::GetRawData($like_list_user_qry);
                                if ($like_list_arr_user) {
                                    $like_list_arr_user = (array) $like_list_arr_user[0];
                                }





                                $review_list_arr_top  = array();
                                $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $review_user_id . "' order by r.review_id desc limit 1";
                                $review_list_arr_top = \App\Models\Songs::GetRawData($review_list_qry);




                                $comment_list_arr  = array();
                                $comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_user_id = '" . $review_user_id . "' order by comment_id desc limit 1";
                                $comment_list_arr = \App\Models\Songs::GetRawData($comment_list_qry);




                                $query_likes_count_all  = array();
                                $query_likes_count_all = \App\Models\Songs::GetRawData("select u.user_name, u.profile_image from tbl_likes l, tbl_users u where u.user_id = l.like_id AND l.like_id = $review_user_id AND l.like_type = 'profile'");
                                if ($query_likes_count_all) {
                                    $query_likes_count_all = count($query_likes_count_all);
                                } else {
                                    $query_likes_count_all = 0;
                                }

                                $db_review_detail = stripslashes($val_review['review_detail']);
                                $db_review_post_date     = stripslashes($val_review['review_post_date']);
                                $db_review_rating     = stripslashes($val_review['review_rating']);
                                $db_profile_image     = stripslashes($val_review['profile_image']);
                                $db_review_post_date  = date("d M Y", stripslashes($val_review['review_post_date']));

                                if ($db_profile_image != "") {
                                    $prof_image = SERVER_ROOTPATH . "assets/phpthumb/phpThumb.php?src=" . SERVER_ROOTPATH . "site_upload/user_images/" . $db_profile_image . "&w=101&h=75&zc=0";
                                } else {
                                    $prof_image = SERVER_ROOTPATH . "assets/phpthumb/phpThumb.php?src=" . SERVER_ROOTPATH . "assets/images/no_image4.png&w=101&h=75&zc=0";
                                }


                                $counter_main  = array();
                                $counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'review_song' AND like_id = '$db_review_id'");
                                if ($counter_main) {
                                    $counter_main = count($counter_main);
                                } else {
                                    $counter_main = 0;
                                }


                                if ($db_review_rating >= 8) {
                                    $color_pick = "#5ebd5e";
                                }

                                if ($db_review_rating >= 7 && $db_review_rating < 8) {
                                    $color_pick = "#5ebd5e";
                                }

                                if ($db_review_rating >= 4 && $db_review_rating < 7) {
                                    $color_pick = "#e06d21";
                                }

                                if ($db_review_rating >= 2 && $db_review_rating < 4) {
                                    $color_pick = "#dd554e";
                                }

                                if ($db_review_rating > 0 && $db_review_rating < 2) {
                                    $color_pick = "#dd554e";
                                }


                                if ($db_review_rating >= 7) {
                                    $color_pick = "#5ebd5e";
                                }
                                if ($db_review_rating >= 4 && $db_review_rating < 7) {
                                    $color_pick = "#e06d21";
                                }
                                if ($db_review_rating >= 0 && $db_review_rating < 4) {
                                    $color_pick = "#dd554e";
                                }

                                $counter_rev_song  = array();
                                $counter_rev_song = \App\Models\Songs::GetRawData("select r.* from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '" . $review_user_id . "' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc");
                                if ($counter_rev_song) {
                                    $counter_rev_song = count($counter_rev_song);
                                } else {
                                    $counter_rev_song = 0;
                                }



                                $counter_prf  = array();
                                $counter_prf = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'profile' AND like_id = '$review_user_id'");
                                if ($counter_prf) {
                                    $counter_prf = count($counter_prf);
                                } else {
                                    $counter_prf = 0;
                                }
                                $like_playlist_count    =    get_playlist_like_counter($review_user_id);

                        ?>

                                <?php if ($mobile_view == 0) { ?>
                                    <div id="review_<?php echo $db_review_id; ?>" class="rew_item">
                                        <div class="col-sm-3">
                                            <div class="latestsongssec" style="width:100%;">
                                                <div class="list_item">

                                                    <a href="<?php echo SERVER_ROOTPATH . get_user_detail($db_user_name) . "-profile-review-artist"; ?>"><img src="<?php echo $prof_image; ?>" width="100%" alt=""></a>
                                                    <div class="list_bottom" style="padding:2px;">
                                                        <div class="row">
                                                            <!--Desktop-->
                                                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 review_screen_txt" style="padding-left:20px; padding-right:2px;">
                                                                <a href="<?php echo SERVER_ROOTPATH . get_user_detail($db_user_name) . "-profile-review-artist"; ?>"><cite class="revleftc" style="margin:2px; font-size:12px; color:#FFFFFF;" title="<?php echo $db_user_name; ?>"><?php echo substr($db_user_name, 0, 12);
                                                                                                                                                                                                                                                                                    if (strlen($db_user_name) > 12) {
                                                                                                                                                                                                                                                                                        echo "..";
                                                                                                                                                                                                                                                                                    } ?></cite></a>
                                                            </div>
                                                            <!--Mobile-->
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 review_ipad_txt" style="padding-left:20px; padding-right:2px;">
                                                                <a href="<?php echo SERVER_ROOTPATH . get_user_detail($db_user_name) . "-profile-review-artist"; ?>"><cite class="revleftc" style="margin:2px; font-size:12px; color:#FFFFFF;" title="<?php echo $db_user_name; ?>"><?php echo substr($db_user_name, 0, 12);
                                                                                                                                                                                                                                                                                    if (strlen($db_user_name) > 12) {
                                                                                                                                                                                                                                                                                        echo "..";
                                                                                                                                                                                                                                                                                    } ?></cite></a>
                                                            </div>

                                                            <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6" style="padding-left:2px; padding-right:20px; margin-top:4px;">
                                                                <?php

                                                                $counter_main  = array();
                                                                $counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'profile' AND like_id = '$review_user_id'");
                                                                if ($counter_main) {
                                                                    $counter_main = count($counter_main);
                                                                } else {
                                                                    $counter_main = 0;
                                                                }




                                                                if ($user_id != "") {

                                                                    $counter  = array();
                                                                    $counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  like_type = 'profile' AND like_id = '$review_user_id'");
                                                                    if ($counter) {
                                                                        $counter = count($counter);
                                                                    } else {
                                                                        $counter = 0;
                                                                    }
                                                                    if ($counter == 0) { ?>

                                                                        <span id="other_dis_sub_profile_<?php echo $prof_counter; ?>" class="like-group" style="float:right; line-height:20px !important;"><a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist_new('<?php echo $review_user_id; ?>','<?php echo $prof_counter; ?>','<?php echo $db_user_name; ?>')" class="like"><i class="fa fa-heart-o heart_color" style="font-size:20px;"></i></a>
                                                                            <a href="<?php echo SERVER_ROOTPATH; ?>detail_profile.php?user=<?php echo  urlencode($db_user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" class="like link-disable" style="color:#fff; font-size:12px;"><?php echo $counter_main; ?><?php //if($counter_main<2){ echo " Like";} else {  echo " Likes"; }
                                                                                                                                                                                                                                                                                                                                                            ?></a></span>
                                                                        <span class="like-group" style="float:right;  line-height:20px !important;" id="myStyle_sub_profile_<?php echo $prof_counter; ?>"></span>
                                                                    <?php
                                                                    } else {
                                                                    ?>

                                                                        <span id="other_dis_sub_profile_<?php echo $prof_counter; ?>" class="like-group" style="float:right; line-height:20px !important;"><a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist_new('<?php echo $review_user_id; ?>','<?php echo $prof_counter; ?>','<?php echo $db_user_name; ?>')" class="like link-disable"><i class="fa fa-heart" style="font-size:20px; color:#d73b3b;"></i></a>
                                                                            <a href="<?php echo SERVER_ROOTPATH; ?>detail_profile.php?user=<?php echo  urlencode(strtolower($db_user_name)); ?>&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" class="like link-disable" style="color:#fff;margin-left:2px; font-size:12px;"><?php echo $counter_main; ?><?php //if($counter_main<2){ echo " Like";} else {  echo " Likes"; }
                                                                                                                                                                                                                                                                                                                                                                                        ?></a></span>
                                                                        <span class="like-group" style="float:right; line-height:20px !important;" id="myStyle_sub_profile_<?php echo $prof_counter; ?>"></span>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <span id="other_dis_sub_profile_<?php echo $prof_counter; ?>" class="like-group" style="float:right; line-height:20px !important;">
                                                                        <?php
                                                                        if ($user_id == "") {
                                                                        ?>
                                                                            <a href="#" data-toggle="modal" data-target="#signin_form" class="like"><i class="fa fa-heart-o heart_color" style="font-size:20px; margin-top:5px;"></i></a>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist_new('<?php echo $review_user_id; ?>','<?php echo $prof_counter; ?>','<?php echo $db_user_name; ?>')" class="like"><i class="fa fa-heart-o heart_color" style="font-size:20px; margin-top:5px;"></i></a>
                                                                        <?php
                                                                        }
                                                                        ?>

                                                                        <a href="<?php echo SERVER_ROOTPATH; ?>detail_profile.php?user=<?php echo  urlencode(strtolower($db_user_name)); ?>&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" class="like text_grey link-disable" style="color:#fff;margin-left:2px; font-size:12px;"><?php echo $counter_main; ?><?php //if($counter_main<2){ echo " Like";} else {  echo " Likes"; }
                                                                                                                                                                                                                                                                                                                                                                                            ?></a></span>
                                                                    <span class="like-group" style="float:right; line-height:20px !important;" id="myStyle_sub_profile_<?php echo $prof_counter; ?>"></span>

                                                                <?php
                                                                }
                                                                ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="icon-panel" style="margin-top:0;">
                                                <p class="darkgrey_rev" style="font-size: 13px;"><i class="fa fa-heart-o darkgrey_rev" style="font-size:16px; margin-left:4px; margin-right:2px;"></i> Likes <span style="color:#D73B3B;"><?php echo $counter_rev_song + $counter_prf + $like_playlist_count ?><?php //echo $like_list_arr_user['count_likes'];
                                                                                                                                                                                                                                                                                                                ?></span></p>
                                                <p class="darkgrey_rev" style="font-size: 13px;"><img src="<?php echo SERVER_ROOTPATH; ?>static/images/review-book.png"> Reviews <span style="color:#D73B3B;"><?php echo $review_list_arr_top['count_reviews']; ?></span></p>
                                                <p class="darkgrey_rev" style="font-size: 13px;"><img src="<?php echo SERVER_ROOTPATH; ?>static/images/icon_post.png"> Posts <span style="color:#D73B3B;"><?php echo $comment_list_arr['count_discussion']; ?></span></p>



                                            </div>


                                        </div>

                                        <div class="col-sm-9 desc_pan" style="padding:5px;">
                                            <p class="title review_screen_txt">
                                                <span style="background-color:<?php echo $color_pick; ?>; border-radius:5px;"><?php if ($db_review_rating == 10) {
                                                                                                                                    echo number_format($db_review_rating, 0);
                                                                                                                                } else {
                                                                                                                                    echo $db_review_rating;
                                                                                                                                } ?></span>

                                                <text class="rec_review_title"> <?php
                                                                                $length_of_string = strlen($db_review_title);
                                                                                if ($length_of_string > 40) {
                                                                                ?>
                                                        <ss style="color:#000; cursor:pointer; font-family:Helvetica Neue,Helvetica,Arial,sans-serif; font-size:20px;" id="half_sview_review_<?php echo $db_review_id; ?>" onclick="full_review_sdisplay(<?php echo $db_review_id; ?>)">
                                                            <?php
                                                                                    echo substr($db_review_title, 0, 40);
                                                                                    if (strlen($db_review_title) > 40) {
                                                                                        echo "..";
                                                                                    }
                                                            ?>
                                                        </ss>

                                                        <ss style="color:#000; display:none;" id="full_sview_review_<?php echo $db_review_id; ?>"><?php echo $db_review_title; ?></ss>
                                                    <?php

                                                                                } else {
                                                                                    echo $db_review_title;
                                                                                }
                                                    ?>
                                                </text>
                                            </p>

                                            <p class="title review_ipad_txt">
                                                <span style="background-color:<?php echo $color_pick; ?>; border-radius:5px;"><?php if ($db_review_rating == 10) {
                                                                                                                                    echo number_format($db_review_rating, 0);
                                                                                                                                } else {
                                                                                                                                    echo $db_review_rating;
                                                                                                                                } ?></span>

                                                <text class="rec_review_title"> <?php
                                                                                $length_of_string = strlen($db_review_title);
                                                                                if ($length_of_string > 25) {
                                                                                ?>
                                                        <ss style="color:#000; cursor:pointer;" id="half_ipadview_review_<?php echo $db_review_id; ?>" onclick="full_review_ipaddisplay(<?php echo $db_review_id; ?>)">
                                                            <?php
                                                                                    echo substr($db_review_title, 0, 25);
                                                                                    if (strlen($db_review_title) > 25) {
                                                                                        echo "..";
                                                                                    }
                                                            ?>
                                                        </ss>

                                                        <ss style="color:#000; display:none;" id="full_ipadview_review_<?php echo $db_review_id; ?>"><?php echo $db_review_title; ?></ss>
                                                    <?php

                                                                                } else {
                                                                                    echo $db_review_title;
                                                                                }
                                                    ?>
                                                </text>


                                            </p>


                                            <p class="review_detail darkgrey_rev" style="font-size:14px;"><?php
                                                                                                            $desc_review = nl2br(wordwrap($db_review_detail, 20, " ", true));

                                                                                                            $desc_length  =  strlen($desc_review);

                                                                                                            if ($desc_length > 500) {

                                                                                                            ?>

                                                    <span id="show_less_<?php echo $db_review_id; ?>"><?php echo substr($desc_review, 0, 500) . "..."; ?>
                                                        <a href="javascript:;" onclick="show_detail_reveiw(<?php echo $db_review_id; ?>, 'more')">View more</a>
                                                    </span>

                                                    <span id="show_more_<?php echo $db_review_id; ?>" style="display:none;"><?php echo $desc_review; ?>
                                                        <a href="javascript:;" onclick="show_detail_reveiw(<?php echo $db_review_id; ?>, 'less')">View Less</a>
                                                    </span>
                                                <?php

                                                                                                            } else {
                                                                                                                echo $desc_review;
                                                                                                            }




                                                ?>
                                            </p>
                                            <?php
                                            $title_db = urlencode("$song_title");
                                            $url_db = urlencode(SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo . "#review_" . $db_review_id);
                                            $summary = urlencode("$db_review_detail");
                                            $image_fb = urlencode($song_pic);
                                            ?>
                                            <ul class="list-inline">
                                                <li>
                                                    <p class="dateVale darkgrey_rev" style="font-size:12px;">
                                                        <!--<img src="images/icon_time.png" width="20" style="margin-bottom:5px;"> --><?php echo $db_review_post_date; ?>
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="likeVale" style="font-size:14px;">

                                                        <?php
                                                        $counter_main  = array();
                                                        $counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'review_song' AND like_id = '$db_review_id'");
                                                        if ($counter_main) {
                                                            $counter_main = count($counter_main);
                                                        } else {
                                                            $counter_main = 0;
                                                        }
                                                        if ($user_id != "") {

                                                            $counter  = array();
                                                            $counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  like_type = 'review_song' AND like_id = '$db_review_id'");
                                                            if ($counter) {
                                                                $counter = count($counter);
                                                            } else {
                                                                $counter = 0;
                                                            }
                                                            if ($counter == 0) {
                                                                if ($review_user_id == $user_id) {
                                                        ?>
                                                                    <span class="darkgrey_rev" id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_review_song_detail('<?php echo $db_review_id; ?>','<?php echo $db_user_name; ?>','<?php echo $k; ?>')" title="your own review"><i class="fa fa-heart-o heart_color heart_size"></i> </a> <?php
                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                ?>
                                                                        <span class="darkgrey_rev" id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_review_song_detail('<?php echo $db_review_id; ?>','<?php echo $db_user_name; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color" style="font-size:20px"></i> </a>
                                                                        <?php
                                                                                                                                                                                                                                                                                                                                                                                            }
                                                                        ?>

                                                                        <a href="<?php echo SERVER_ROOTPATH; ?>detail_review.php?user=<?php echo  urlencode(strtolower($db_user_name)); ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable darkgrey_rev" style="font-size:14px;"> <span class="red-text"><?php echo $counter_main; ?></span><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>

                                                                        <span id="myStyle_sub_<?php echo $db_review_id; ?>"></span>

                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <span class="darkgrey_rev" id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_review_song_detail('<?php echo $db_review_id; ?>','<?php echo $db_user_name; ?>','<?php echo $k; ?>')" class="like"><i class="fa fa-heart heart_color" style="font-size:20px"></i></a><a href="<?php echo SERVER_ROOTPATH; ?>detail_review.php?user=<?php echo  urlencode(strtolower($db_user_name)); ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable darkgrey_rev" style="font-size:14px;"> <span class="red-text"><?php echo $counter_main; ?></span><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>

                                                                        <span class="darkgrey_rev" id="myStyle_sub_<?php echo $db_review_id; ?>"></span>
                                                                    <?php
                                                                }
                                                            } else {
                                                                    ?>
                                                                    <span class="darkgrey_rev" id="other_dis_sub_<?php echo $review_user_id; ?>"><a href="javascript:;" <?php if ($check_login_var == "") { ?>onClick="add_in_favourite_list_review_song_detail('<?php echo $db_review_id; ?>','<?php echo $db_user_name; ?>','<?php echo $k; ?>')" <?php } ?> <?php echo $check_login_var; ?>><i class="fa fa-heart-o heart_color" style="font-size:20px"></i></a><a href="<?php echo SERVER_ROOTPATH; ?>detail_review.php?user=<?php echo  urlencode(strtolower($db_user_name)); ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable darkgrey_rev" style="font-size:14px;"> <span class="red-text"><?php echo $counter_main; ?></span><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                                    <span class="darkgrey_rev" id="myStyle_sub_<?php echo $db_review_id; ?>"></span>

                                                                <?php
                                                            }
                                                                ?>
                                                    </p>
                                                </li>
                                                <li>
                                                    <!--<a href="#" class="linkTag">Report</a>-->
                                                    <?php
                                                    if ($review_user_id != $user_id) {

                                                        if ($check_login_var) {
                                                    ?>
                                                            <a href="#" <?php echo $check_login_var; ?> class="linktag_new under_line">Report</a>
                                                            <?php
                                                        } else {


                                                            if (isset($report_status)) {
                                                            ?>
                                                                <a class="linktag_new under_line" href="#" data-toggle="modal" data-target="#report_already_message" data-title="">Report</a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="linktag_new under_line" href="<?php echo SERVER_ROOTPATH; ?>report.php?rev_id=<?php echo $db_review_id; ?>&num=<?php echo $rep; ?>" data-toggle="modal" data-target="#report_Modal4_<?php echo $rep; ?>" data-title="">Report</a>
                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($review_user_id == $user_id) {
                                                    ?>
                                                        <a class="linkTag under_line" data-title="" data-target="#edit_Modal4_<?php echo $rep; ?>" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>edit_review.php?rev_id=<?php echo $db_review_id; ?>&num=<?php echo $rep; ?>">Edit</a>
                                                    <?php
                                                    }
                                                    ?>

                                                    <span id="myStyle_report_<?php echo $rep; ?>"></span>
                                                </li>
                                                <li>
                                                    <!--<a href="#"> <img src="images/icon_fb.png"></a>
										<a href="#"> <img src="images/tww.png"></a>
										<a href="#"> <img src="images/gplus.png"></a>-->
                                                    <a onClick="popupWindow('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title_db; ?>&amp;p[summary]=<?php echo $summary; ?>&amp;p[url]=<?php echo $url_db; ?>&amp;&p[images][0]=<?php echo $image_fb; ?>', 'sharer', 'toolbar=0,status=0,width=620,height=280');" href="javascript: void(0)"><img src="<?php echo SERVER_ROOTPATH; ?>images/icon_fb.png" width="20"></a>

                                                    &nbsp;

                                                    <a href="javascript: popupWindow('http://twitter.com/share?url=<?php echo $url_db; ?>&source=<?php echo  $db_review_title ; ?>&text=<?php echo substr($db_review_detail, 0, 110); ?>')"><img src="<?php echo SERVER_ROOTPATH; ?>images/tww.png" width="20"></a>


                                                    &nbsp;
                                                    <a class="footer__shareoption__google" href="https://plusone.google.com/_/+1/confirm?hl=Hello&amp;url=<?php echo $url_db; ?>&amp;title=<?php echo $db_review_title; ?>" target="blank" title=""><img src="<?php echo SERVER_ROOTPATH; ?>images/gplus.png" width="20"></a>



                                                </li>
                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                <?php } elseif ($mobile_view == 1) { ?>
                                    <div id="review_<?php echo $db_review_id; ?>" class="rew_item">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad_zero">

                                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 desc_pan pad_zero">
                                                <p class="title"><span style="background-color:<?php echo $color_pick; ?>; border-radius:5px; font-size:12px;"><?php if ($db_review_rating == 10) {
                                                                                                                                                                    echo number_format($db_review_rating, 0);
                                                                                                                                                                } else {
                                                                                                                                                                    echo $db_review_rating;
                                                                                                                                                                } ?></span>
                                                    <text class="rec_review_title"> <?php
                                                                                    $length_of_string = strlen($db_review_title);
                                                                                    if ($length_of_string > 25) {
                                                                                    ?>
                                                            <ss style="color:#000" id="half_view_review_<?php echo $db_review_id; ?>" onclick="full_review_display(<?php echo $db_review_id; ?>)"><?php
                                                                                                                                                                                                    echo substr($db_review_title, 0, 25);
                                                                                                                                                                                                    if (strlen($db_review_title) > 25) {
                                                                                                                                                                                                        echo "..";
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?>
                                                            </ss>

                                                            <ss style="color:#000; display:none;" id="full_view_review_<?php echo $db_review_id; ?>"><?php echo $db_review_title; ?></ss>
                                                        <?php

                                                                                    } else {
                                                                                        echo $db_review_title;
                                                                                    }
                                                        ?>
                                                    </text>
                                                </p>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad_zero">
                                                <div class="col-lg-3 col-md-3 col-sm-2 col-xs-2 pad_zero">

                                                    <div class="latestsongssec">
                                                        <div class="list_item">
                                                            <a href="<?php echo SERVER_ROOTPATH . get_user_detail($db_user_name) . "-profile-review-artist"; ?>"><img src="<?php echo $prof_image; ?>" style="100%" alt="Image"></a>
                                                            <div class="list_bottom" style="width:100%; height:18px; padding:0; padding-right:6px !important;">

                                                                <?php
                                                                $counter_main  = array();
                                                                $counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'profile' AND like_id = '$review_user_id'");
                                                                if ($counter_main) {
                                                                    $counter_main = count($counter_main);
                                                                } else {
                                                                    $counter_main = 0;
                                                                }
                                                                if ($user_id != "") {

                                                                    $counter  = array();
                                                                    $counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  like_type = 'profile' AND like_id = '$review_user_id'");
                                                                    if ($counter) {
                                                                        $counter = count($counter);
                                                                    } else {
                                                                        $counter = 0;
                                                                    }
                                                                    if ($counter == 0) { ?>

                                                                        <span id="other_dis_sub_profile_<?php echo $prof_counter; ?>" class="like-group" style="float:right; line-height:20px !important;"><a href="javascript:;" onClick="add_in_favourite_user_profile_size('<?php echo $review_user_id; ?>','<?php echo $prof_counter; ?>','<?php echo $db_user_name; ?>')" class="like"><i class="fa fa-heart-o heart_color" style="font-size:12px; margin-right:3px;"></i></a><a href="<?php echo SERVER_ROOTPATH; ?>detail_profile.php?user=<?php echo  urlencode(strtolower($db_user_name)); ?>&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" class="like link-disable" style="color:#fff; font-size:12px;"> <?php echo $counter_main; ?></a></span>
                                                                        <span class="like-group" style="float:right; line-height:20px !important;" id="myStyle_sub_profile_<?php echo $prof_counter; ?>"></span>

                                                                    <?php
                                                                    } else {
                                                                    ?>

                                                                        <span id="other_dis_sub_profile_<?php echo $prof_counter; ?>" class="like-group" style="float:right; line-height:20px !important;"><a href="javascript:;" onClick="add_in_favourite_user_profile_size('<?php echo $review_user_id; ?>','<?php echo $prof_counter; ?>','<?php echo $db_user_name; ?>')" class="like link-disable"><i class="fa fa-heart" style="font-size:12px; color:#d73b3b; margin-right:3px;"></i></a><a href="<?php echo SERVER_ROOTPATH; ?>detail_profile.php?user=<?php echo  urlencode(strtolower($db_user_name)); ?>&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" class="like link-disable" style="color:#fff;margin-left:2px; font-size:12px;"><?php echo $counter_main; ?></a></span>
                                                                        <span class="like-group" style="float:right; line-height:20px !important;" id="myStyle_sub_profile_<?php echo $prof_counter; ?>"></span>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <span id="other_dis_sub_profile_<?php echo $prof_counter; ?>" class="like-group" style="float:right; line-height:20px !important;"><a href="javascript:;" onClick="add_in_favourite_user_profile_size('<?php echo $review_user_id; ?>','<?php echo $prof_counter; ?>','<?php echo $db_user_name; ?>')" class="like"><i class="fa fa-heart-o heart_color" style="font-size:12px; margin-right:3px;"></i></a><a href="<?php echo SERVER_ROOTPATH; ?>detail_profile.php?user=<?php echo  urlencode(strtolower($db_user_name)); ?>&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" class="like text_grey link-disable" style="color:#fff;margin-left:2px; font-size:12px;"><?php echo $counter_main; ?></a></span>
                                                                    <span class="like-group" style="float:right; line-height:20px !important;" id="myStyle_sub_profile_<?php echo $prof_counter; ?>"></span>

                                                                <?php
                                                                }
                                                                ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 ">
                                                    <p class="review_detail red_rev"><a class="darkgrey_rev" style="font-weight:bold;" href="<?php echo SERVER_ROOTPATH . get_user_detail($db_user_name) . "-profile-review-artist"; ?>"><?php echo substr($db_user_name, 0, 11); ?></a> (<?php echo $review_list_arr_top['count_reviews']; ?> reviews)</p>
                                                </div>
                                                <div class="clearfix"></div>
                                                <p class="review_detail darkgrey_rev" style="text-align:justify; margin:2px;">
                                                    <?php
                                                    $desc_review = nl2br(wordwrap($db_review_detail, 20, " ", true));

                                                    $desc_length  =  strlen($desc_review);

                                                    if ($desc_length > 500) {

                                                    ?>

                                                        <span id="show_less_<?php echo $db_review_id; ?>"><?php echo substr($desc_review, 0, 500) . "..."; ?>
                                                            <a href="javascript:;" onclick="show_detail_reveiw(<?php echo $db_review_id; ?>, 'more')">View more</a>
                                                        </span>

                                                        <span id="show_more_<?php echo $db_review_id; ?>" style="display:none;"><?php echo $desc_review; ?>
                                                            <a href="javascript:;" onclick="show_detail_reveiw(<?php echo $db_review_id; ?>, 'less')">View Less</a>
                                                        </span>
                                                    <?php

                                                    } else {
                                                        echo $desc_review;
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 desc_pan pad_zero">
                                                <div class="clearfix"></div>
                                                <ul class="list-inline">
                                                    <li class="col-sm-4 col-xs-4 pad_zero">
                                                        <p class="likeVale likes" style="margin-top:-4px;">
                                                            <?php
                                                            $counter_main  = array();
                                                            $counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'review_song' AND like_id = '$db_review_id'");
                                                            if ($counter_main) {
                                                                $counter_main = count($counter_main);
                                                            } else {
                                                                $counter_main = 0;
                                                            }
                                                            if ($user_id != "") {

                                                                $counter  = array();
                                                                $counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'review_song' AND like_id = '$db_review_id'");
                                                                if ($counter) {
                                                                    $counter = count($counter);
                                                                } else {
                                                                    $counter = 0;
                                                                }
                                                                if ($counter == 0) {
                                                                    if ($review_user_id == $user_id) {
                                                            ?>
                                                                        <span class="darkgrey_rev like-group" id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_review_song_detail('<?php echo $db_review_id; ?>','<?php echo $db_user_name; ?>','<?php echo $k; ?>')" class="like"><i class="fa fa-heart-o heart_color heart_size" style="font-size:20px;"></i></a> <a href="<?php echo SERVER_ROOTPATH; ?>detail_review.php?user=<?php echo  urlencode(strtolower($db_user_name)); ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable" style="color:#444;"><?php echo $counter_main; ?> <?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>


                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <span class="darkgrey_rev like-group" id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_review_song_detail('<?php echo $db_review_id; ?>','<?php echo $db_user_name; ?>','<?php echo $k; ?>')" class="like"><i class="fa fa-heart-o heart_color heart_size" style="font-size:20px;"></i></a> <a href="<?php echo SERVER_ROOTPATH; ?>detail_review.php?user=<?php echo  urlencode(strtolower($db_user_name)); ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable" style="color:#444;"><?php echo $counter_main; ?> <?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                                    <?php
                                                                    }
                                                                    ?>



                                                                    <span class="darkgrey_rev like-group" id="myStyle_sub_<?php echo $db_review_id; ?>"></span>

                                                                <?php
                                                                } else {
                                                                ?>



                                                                    <span class="darkgrey_rev like-group" id="other_dis_sub_<?php echo $db_review_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_review_song_detail('<?php echo $db_review_id; ?>','<?php echo $db_user_name; ?>','<?php echo $k; ?>')" class="like"><i class="fa fa-heart" style="font-size:20px; color:#D73B3B;"></i></a>
                                                                        <a href="<?php echo SERVER_ROOTPATH; ?>detail_review.php?user=<?php echo  urlencode(strtolower($db_user_name)); ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable" style="color:#444;"><?php echo $counter_main; ?> <?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>

                                                                    <span class="darkgrey_rev like-group" id="myStyle_sub_<?php echo $db_review_id; ?>"></span>
                                                                <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <span class="darkgrey_rev" id="other_dis_sub_<?php echo $review_user_id; ?>">
                                                                    <?php
                                                                    if ($check_login_var) {
                                                                    ?>
                                                                        <a href="#" <?php echo $check_login_var; ?> class="linkTag under_line"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <a href="javascript:;" onClick="add_in_favourite_list_review_song_detail('<?php echo $db_review_id; ?>','<?php echo $db_user_name; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                    <span class="red-text" style="font-size:14px;"><?php echo $counter_main; ?></span>

                                                                    <a href="<?php echo SERVER_ROOTPATH; ?>detail_review.php?user=<?php echo  urlencode(strtolower($db_user_name)); ?>&review_id=<?php echo $db_review_id; ?>&critaria=1" data-toggle="modal" data-target="#review_modal" data-title="" class="like link-disable darkgrey_rev" style="font-size:14px;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                                <span class="darkgrey_rev" id="myStyle_sub_<?php echo $db_review_id; ?>"></span>

                                                            <?php
                                                            }
                                                            ?>
                                                        </p>
                                                    </li>
                                                    <li class="col-sm-5 col-xs-5" style="text-align:center; padding:0;">
                                                        <p class="dateVale darkgrey_rev" style="font-size:12px; margin-top:4px;">
                                                            <!--<img src="images/icon_time.png" width="16">--> <?php echo $db_review_post_date; ?>
                                                        </p>
                                                    </li>
                                                    <li class="col-sm-3 col-xs-3" style="float:right; padding:0;"><?php
                                                                                                                    if ($review_user_id != $user_id) {

                                                                                                                        if ($check_login_var) {
                                                                                                                    ?>
                                                                <a href="#" <?php echo $check_login_var; ?> class="linktag_new under_line" style="text-decoration:none; float:right;">Report</a>
                                                                <?php
                                                                                                                        } else {
                                                                                                                            if (isset($report_status)) {
                                                                ?>
                                                                    <a class="linktag_new under_line" href="#" data-toggle="modal" data-target="#report_already_message" style="text-decoration:none; float:right;" data-title="">Report</a>
                                                                <?php
                                                                                                                            } else {
                                                                ?>
                                                                    <a style="text-decoration:none; float:right;" class="linktag_new" href="<?php echo SERVER_ROOTPATH; ?>report.php?rev_id=<?php echo $db_review_id; ?>&num=<?php echo $rep; ?>" data-toggle="modal" data-target="#report_Modal4_<?php echo $rep; ?>" data-title="">Report</a>
                                                        <?php
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                        ?>

                                                        <?php
                                                        if ($review_user_id == $user_id) {
                                                        ?>
                                                            <a style="text-decoration:none; float:right;" class="linkTag" data-title="" data-target="#edit_Modal4_<?php echo $rep; ?>" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>edit_review.php?rev_id=<?php echo $db_review_id; ?>&num=<?php echo $rep; ?>">Edit</a>
                                                        <?php
                                                        }
                                                        ?>

                                                        <span id="myStyle_report_<?php echo $rep; ?>"></span>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                    </div>

                                <?php } ?>

                        <?php
                            }
                        }
                        ?>
                    </div>

                    <?php //if ($total_pages > $limit) { ?>
                        <div class="page-navigation" style="border-top:none;">
                            <ul>
                                <?php
                                //include("common/paging-playlist.php"); 
                                ?>
                            </ul>
                        </div>
                    <?php // } ?>

                    <div style="height: 30px"></div>

                    <div class="heading">
                        Write a Review
                    </div>
                    <div class="write-rew-pan" style="width:96%; margin-left:10px;">
                        <form name="api-readonly" id="api-readonly" method="post" action="" class="form-horizontal">
                            <div>
                                <p class="starLabel">How would you rate?</p>

                                <div class="star-panel">
                                    <input id="input-21b" name="api-readonly-test" value="<?php echo $_SESSION['store']['rating']; ?>" type="number" class="rating" min=0 max=10 step=0.5 data-size="xs" data-stars="10">

                                    <input type="hidden" name="song_seo_name" value="<?php echo $song_seo; ?>">
                                    <input type="hidden" name="artist_seo_name" value="<?php echo $artist_seo; ?>">

                                </div>
                                <!--<form>-->

                                <div class="form-group">

                                    <!--<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Review Title">-->
                                    <input type="text" name="review_title" id="review_title" class="form-control" placeholder="Review Title" value="<?php echo $_SESSION['store']['review_title']; ?>">
                                </div>
                                <div class="form-group">

                                    <textarea class="form-control" rows="4" placeholder="Your Review" id="review_detail" name="review_detail"><?php echo $_SESSION['store']['review_detail']; ?></textarea>


                                    <input type="hidden" name="song_id" value="<?php echo $song_id; ?>">
                                    <input type="hidden" name="artist_id" value="<?php echo $artist_id; ?>">
                                    <input type="hidden" name="album_id" value="<?php echo $album_id; ?>">
                                </div>
                                <p class="form-control-static">By posting a review, I accept Tailem.com's
                                    <!--<a href="#"> Posting Guidelines</a> and <a href="#"> Privacy Policy</a>-->
                                    <?php
                                    $get_all_pages  = array(); 
                                    
                                        $get_all_pages_qry = "SELECT page_seo_name,page_name  FROM tbl_pages where page_id = 8 OR page_id = 2 ORDER BY page_id desc";
                                         $get_all_pages = \App\Models\Songs::GetRawData($get_all_pages_qry);
                                         if($get_all_pages)
                                         {
                                             $count_pages = count($get_all_pages);

                                         }
                                         else 
                                         {
                                            $count_pages = 0;
                                         }
                                        
                                    

                                    if ($get_all_pages) {
                                        $kk = 1;
                                        foreach ($get_all_pages as $page_info) {
                                            $page_info = (array) $page_info;
                                    ?>

                                            <a href="<?php echo SERVER_ROOTPATH . "detail_cms.php?seo_url=" . $page_info['page_seo_name']; ?>" data-toggle="modal" data-target="#cms_<?php echo $kk; ?>" data-title=""><?php echo stripslashes($page_info['page_name']); ?></a>
                                            <?php
                                            if ($kk == 1) {
                                                echo "and";
                                            }
                                            ?>


                                    <?php
                                            $kk++;
                                        }
                                    }
                                    ?>
                                </p>
                                <!--<button type="submit" class="btn btn-default btn-red">Post Review</button>
                                --><input type="submit" name="submit_btn" id="submit_btn" value="Post Review" onClick="return write_a_review_validation_new();" class="btn btn-default btn-red" />

                        </form>
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
                        <textarea class="form-control" name="detail" id="atextarea" rows="5" placehlder="Share your thoughts here..." style="resize: none; color:#000000"></textarea>

                        <input type="hidden" name="song_id" value="<?php echo $song_id; ?>">
                        <input type="hidden" name="artist_id" value="<?php echo $artist_id; ?>">
                        <input type="hidden" name="album_id" value="<?php echo $album_id; ?>">

                    </div>
                    <input id="submit_btn" class="btn btn-default btn-green btn-block" type="submit" onClick="return discussion_post();" value="Post" name="submit_btn">
                    <!--<button type="button" class="btn btn-default btn-green btn-block">Post</button>-->
                </div>
                <div id="pagination" cellspacing="0"></div>

            </div>
            <div style="clear: both"></div>
            <div class="heading">
                Related Songs
            </div>

            <?php
            //include "common/related_songs.php";
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


<script src="<?php echo SERVER_ROOTPATH; ?>js/star-rating.js" type="text/javascript"></script>


<style>
    body {
        overflow-x: hidden;
    }

    .form-control {
        height: auto;
    }
</style>



<?php
for ($u = 1; $u <= $kk; $u++) {
?>
    <div class="modal fade" id="cms_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}



for ($g = 1; $g <= $k; $g++) {
?>
    <div class="modal fade" id="report_Modal4_<?php echo $g; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}

for ($g = 1; $g <= 20; $g++) {
?>
    <div class="modal fade" id="edit_Modal4s_<?php echo $g; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

<?php
}


for ($g = 1; $g <= 20; $g++) {
?>
    <div class="modal fade" id="edit_Modal4_<?php echo $g; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

<?php
}


for ($u = 1; $u <= $prof_counter; $u++) {
?>
    <div class="modal fade" id="missing_popular_profile_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}

for ($u = 1; $u <= 20; $u++) {
?>
    <div class="modal fade" id="missing_popular_profile_discussion_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}
?>


<?php
//include("include/thankyou_messages.php");
//include("common/signin_modal.php"); 
?>

<div class="modal fade" id="profile_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function() {

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

        }, 2000);

    });


    var jq = $.noConflict();
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
<script type="text/javascript">
    function discussion_post() {
        valu = jq('#atextarea').val();
        jq.post(
            JS_SERVER_PATHROOT + 'process/discussion_process.php?artist_id=<?php echo $artist_id; ?>&album_id=<?php echo $album_id; ?>&song_id=<?php echo $song_id; ?>&detail=' + valu,


            function(html) {


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
        );
    }

    song_id = <?php echo $song_id; ?>;
</script>
<?php



//include_once("common/popular_review.php");

?>
<script type="text/javascript" src="<?php echo SERVER_ROOTPATH; ?>script.js"></script>
<div class="modal fade" id="show_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<div class="modal fade" id="create_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
@include("common.footer")