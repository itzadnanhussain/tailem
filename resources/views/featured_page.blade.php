@include("common.header")
<?php
error_reporting(0);

$artist_id_db             = stripslashes(html_entity_decode($row_artist['id']));
$artist_seo             = stripslashes(html_entity_decode($row_artist['artist_seo']));
$db_artist_name             = stripslashes(html_entity_decode($row_artist['artist_name']));
$artist_description     = stripslashes(html_entity_decode($row_artist['artist_description']));
$artist_img             = stripslashes(html_entity_decode($row_artist['artist_img']));
$lastfm_url             = stripslashes($row_artist['lastfm_url']);

$artistname = urlencode($db_artist_name);
ini_set('allow_url_fopen ', 'ON');
$temp = file_get_contents("http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=" . $artistname . "&api_key=979650ff4905a23bb01e312145761ebb");
$XmlObj = simplexml_load_string($temp);
$info = $XmlObj->artist->bio->summary;
$image4 = $XmlObj->artist->image[3];
$name = $XmlObj->artist->name;
$url = $XmlObj->artist->url;

$val = '<a href="http://www.last.fm/music/Justin+Bieber">Read more about Justin Bieber on Last.fm</a>';
$val = $info;
$val =  str_replace($url, "#", $val);
$val =  str_replace("Read more about " . $name . " on Last.fm", "", $val);
$val1 = '<a href="#"></a>.';
$info1 =  str_replace($val1, "", $val);
$val2 = '<a href="#"></a>';
$info =   strip_tags(str_replace($val2, "", $info1));

?>
<style>
    body {
        overflow-x: hidden;
    }

    .artistSongspic .topsonglistsec .songlistings .album_cover {
        width: 100%;
    }

    iframe {
        max-height: 230px;
    }

    .select_year {
        border: 2px solid #d9d9d9;
        border-radius: 3px;
        bottom: -8px;
        color: #2b2b2b;
        display: block;
        float: right;
        font-size: 14px;
        padding: 13px 0 13px 10px;
        position: absolute;
        right: 5px;
        text-align: left;
        vertical-align: bottom;
        width: 150px;
        background: #f6f6f6 no-repeat scroll 93% center;
    }

    .album_year {
        padding-top: 25px;
        margin-left: 10px;
        font-size: 18px;


    }

    .alb_heading {
        margin-left: 0px;
    }

    .ft_size {
        font-size: 14px !important;
    }
</style>
<!-- ./Header end -->

<!-- Middle Section -->
<section class="middle_sec artistSongspic">
    <div class="topsonglistsec" style="padding-top:0px !important; padding-bottom:0px !important;">
        <!-- Advertisement Banner Start-->
        <div class="clear"></div>
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
        <?php
        $qry = "select l.id from tbl_likes l, tbl_artists a where l.like_type = 'artist' AND l.like_id = a.id AND a.id = $artist_id_db";
        $counter_main = array();
        $counter_main = \App\Models\Songs::GetRawData($qry);
        if ($counter_main) {
            $counter_main = count($counter_main);
        } else {
            $counter_main = 0;
        }
        ?>
        <div class="container" style="padding:0;">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <ul class="songlistings">
                        <li>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h2>
                                        <?php echo $db_artist_name; ?>&nbsp;
                                        <?php if ($mobile_view == 1) {
                                            echo '<br>';
                                        } else {
                                        } ?>
                                        <small style="color:#000000; font-size:14px;"><?php if ($user_id != "") {

                                                                                            $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$artist_id_db'";
                                                                                            $counter = array();
                                                                                            $counter = \App\Models\Songs::GetRawData($qry);
                                                                                            if ($counter) {
                                                                                                $counter = count($counter);
                                                                                            } else {
                                                                                                $counter = 0;
                                                                                            }
                                                                                            if ($counter == 0) { ?>
                                                    <span id="other_dis_sub_<?php echo $artist_id_db; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $artist_id_db; ?>','<?php echo $artist_seo; ?>','<?php echo $artist_id_db; ?>')"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i> </a> <span class="text_red"><?php echo $counter_main; ?></span> <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" style="color:#444;" class="link-disable"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>

                                                    <span id="myStyle_sub_<?php echo $artist_id_db; ?>"></span>
                                                <?php
                                                                                            } else {
                                                ?>
                                                    <span id="other_dis_sub_<?php echo $artist_id_db; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $artist_id_db; ?>','<?php echo $artist_seo; ?>','<?php echo $artist_id_db; ?>')" class="like"><i class="fa fa-heart" style="font-size:24px; color:#D73B3B;"></i></a> <span class="text_red"><?php echo $counter_main; ?></span> <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" style="color:#444;" class="link-disable"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>

                                                    <span id="myStyle_sub_<?php echo $artist_id_db; ?>" class="text_grey"></span>
                                                <?php
                                                                                            }
                                                                                        } else {
                                                ?>
                                                <span id="other_dis_sub_<?php echo $artist_id_db; ?>">
                                                    <?php
                                                                                            if ($user_id == "") {
                                                    ?>
                                                        <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>
                                                    <?php
                                                                                            } else {
                                                    ?>
                                                        <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $artist_id_db; ?>','<?php echo $artist_seo; ?>','<?php echo $artist_id_db; ?>')"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a>
                                                    <?php
                                                                                            }
                                                    ?>
                                                    <span class="text_red"><?php echo $counter_main; ?></span> <a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" style="color:#444;" class="link-disable"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                <span id="myStyle_sub_<?php echo $artist_id_db; ?>" class="text_grey"></span>
                                            <?php
                                                                                        }
                                            ?>
                                        </small>
                                    </h2>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <p style="padding:5px;">
                                        <a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>" aria-controls="song">Songs</a> -
                                        <a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-albums"; ?>">Albums</a> -
                                        <a class="heart_color" href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-featured"; ?>">Featured</a>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0 26px;">
                                    <!--<img src="images/slideimg1.png" align="left" style="margin:5px 10px; width:100px;">-->
                                    <div class="album_cover" style="float:left; padding: 0 5px 0 0; width:auto;">
                                        <!--<img src="images/slideimg3.png" align="left" style="margin:5px 10px; width:100px;">-->
                                        <?php
                                        $array_score = sum_of_artist_rating($artist_id_db);

                                        ?>
                                        <a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>" class="pull-left mr-15" target="_blank">
                                            <?php
                                            if ($artist_img != "") {
                                                $img_api_link = album_img_api($artist_img);
                                                if ($img_api_link != '') {
                                            ?>
                                                    <img src="<?php echo get_small_thumb($img_api_link); ?>" align="left" style="margin:5px 10px 0 0; width:100px;" />
                                                <?php } else { ?>
                                                    <img align="left" style="margin:5px 10px 0 0; width:100px;" src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo 'thumb_' . $artist_img; ?>" border="0" width="100" />

                                                <?php
                                                }
                                            } else
                                        if ($image4 != "") {
                                                ?>
                                                <img src="<?php echo get_small_thumb($image4); ?>" align="left" style="margin:5px 10px 0 0; width:100px;" />
                                            <?php
                                            } else {
                                            ?>
                                                <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" align="left" style="margin:5px 10px 0 0; width:100px;" />
                                            <?php
                                            }
                                            ?>
                                        </a>
                                        <?php
                                        if ($array_score['rating_avg'] != 0) {
                                        ?><cite class="score_big mt-10" style="left:3px;  background-color:<?php echo $array_score['color_pick']; ?>"><?php echo $array_score['rating_avg']; ?></cite><?php } else { ?> <cite class="score_big mt-10" style="background-color:#dd554e; left:3px;">0.0</cite> <?php } ?>
                                    </div>

                                    <p style="text-align:justify; font-family: 'Montserrat', sans-serif; font-size:12px;">
                                        <?php
                                        if ($artist_description != "") {
                                            $count_words =  str_word_count($artist_description);

                                            if ($count_words > 50) {
                                        ?>
                                                <span id="show_less_info"><?php echo limit_text($artist_description, 50); ?>
                                                    <a href="javascript:;" onclick="show_detail_artist('more')">View more</a>
                                                </span>

                                                <span id="show_more_info" style="display:none;"><?php echo $artist_description; ?>
                                                    <a href="javascript:;" onclick="show_detail_artist('less')">View Less</a>
                                                </span>

                                            <?php
                                            } else {
                                                echo $artist_description;
                                            }

                                            if ($lastfm_url != "") {
                                            ?>
                                                <a href="<?php echo $lastfm_url; ?>" target="_blank" style="color:#E2605A;">Read more on Last.fm
                                                    <!--<img border="0" src="<?php echo SERVER_ROOTPATH; ?>images/fm.png">-->
                                                </a>
                                            <?php
                                            }
                                        } else
                                            if ($info != "") {
                                            //echo substr($info,0,300); 
                                            echo limit_text($info, 50);
                                            ?>
                                            <br>
                                            <a href="<?php if ($lastfm_url != "") {
                                                            echo $lastfm_url;
                                                        } else {
                                                            echo $url;
                                                        } ?>" target="_blank" style="color:#E2605A;">Read more on Last.fm
                                                <!--<img border="0" src="<?php echo SERVER_ROOTPATH; ?>images/fm.png">-->
                                            </a>
                                        <?php
                                        }
                                        ?>


                                    </p>


                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12" style="max-height:200px;">
                    <!-- Advertisement Right Side Start-->
                    <div class="review_item artist_screen">
                        <?php echo ads_info('right'); ?>
                    </div>
                    <!-- Advertisement Right Side End-->
                </div>


            </div>
        </div>
    </div>

    </div>
    </div>

    <div class="topsonglistsec" style="padding:20px 0 0 0;">
        <div class="container" style="padding:0;">
            <div class="row">
                <?php
                $qry_count_mypro = "select s.song_seo,b.years,s.song_title,b.album_title, b.album_picture,s.picture, s.id, a.artist_name, a.artist_seo from tbl_artist_album b,  tbl_songs s,  tbl_artists a, tbl_featured_artist_assocs f 
										  where 1=1 AND b.id = f.album_id AND f.main_artist = a.id AND  f.featured_artist = $artist_id_db  AND s.id = f.song_id AND s.song_status = 1 group by f.song_id order by s.id desc";
                $res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
                if ($res_count_mypro) {
                    $total_pages = count($res_count_mypro);
                } else {
                    $total_pages = 0;
                }

                $targetpage = SERVER_ROOTPATH . $artist_seo . "-featured"; //your file name  (the name of this file)


                $limit = 10;
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

                $qry = "select a.id as dbart_id,s.song_seo,b.years,s.song_title,b.album_title, b.album_picture,s.picture, s.id, a.artist_name, a.artist_seo from tbl_artist_album b,  tbl_songs s,  tbl_artists a, tbl_featured_artist_assocs f 
										  where 1=1 AND b.id = f.album_id AND f.main_artist = a.id AND  f.featured_artist = $artist_id_db  AND s.id = f.song_id AND s.song_status = 1 group by f.song_id order by s.id desc
										LIMIT $start, $limit";

                $artist_list_arr    =    \App\Models\Songs::GetRawData($qry);



                ?>
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="alb_heading headingmedium">Songs Featuring <?php echo $db_artist_name; ?></h3>
                        </div>
                    </div>

                    <ul class="songlistings">
                        <?php

                        if (isset($artist_list_arr)) {
                        ?>

                            <?php
                            $sr_num = 0;
                            foreach ($artist_list_arr as $val) {
                                $val = (array)$val;
                                $id      = $val['id'];
                                $dbart_id    = $val['dbart_id'];
                                $dbsong_id  = $id;
                                $qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.song_id = '" . $id . "' order by r.review_id desc limit 1";

                                $review_list_arr_top    =    \App\Models\Songs::GetRawData($qry);

                                $qry = "select count(*) as count_discussion from tbl_comments where comment_review_id = '" . $id . "' order by comment_id desc limit 1";

                                $comment_list_arr    =    \App\Models\Songs::GetRawData($qry);
                                $album_title = stripslashes(html_entity_decode($val['album_title']));
                                $artist_name = stripslashes(html_entity_decode($val['artist_name']));
                                $album_picture   = stripslashes(html_entity_decode($val['album_picture']));
                                $song_title = stripslashes(html_entity_decode($val['song_title']));
                                $album_title = wordwrap($album_title, 100, " ", true);
                                $artist_name = wordwrap($artist_name, 100, " ", true);

                                $artist_seo = stripslashes(html_entity_decode($val['artist_seo']));
                                $song_seo    = stripslashes(html_entity_decode($val['song_seo']));
                                $picture   = stripslashes(html_entity_decode($val['picture']));



                                $years = stripslashes(html_entity_decode($val['years']));

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



                                if ($all_avg == "") {
                                    $all_avg = 0;
                                }

                                if ($all_avg >= 8) {
                                    $color_pick = "#5ebd5e";
                                }

                                if ($all_avg >= 6 && $all_avg < 8) {
                                    $color_pick = "#5ebd5e";
                                }

                                if ($all_avg >= 4 && $all_avg < 6) {
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
                                } elseif ($all_avg >= 4 && $all_avg <= 6.9) {
                                    $color_pick = "#e06d21";
                                } elseif ($all_avg >= 0 && $all_avg <= 3.9) {
                                    $color_pick = "#dd554e";
                                }


                                $sr_num++;
                                $qry_feature_arr = array();

                                $qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '" . $id . "'";

                                $qry_feature_arr = \App\Models\Songs::GetRawData($qry_top_feature_artist);
                                if ($qry_feature_arr) {
                                    $count = count($qry_feature_arr);
                                } else {
                                    $count = 0;
                                }


                                $num = 1;
                                $feature_artists = "";
                                if ($qry_feature_arr) {



                                    foreach ($qry_feature_arr as $val_feature) {
                                        $val_feature = (array)$val_feature;
                                        if ($num == $count) {
                                            $feature_artists .= " <a class='ft_size' style='color:#d73b3b;' href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $val_feature['feature_artist'] . "</a>";
                                        } else {
                                            $feature_artists .= " <a class='ft_size' style='color:#d73b3b;' href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $val_feature['feature_artist'] . "</a>,";
                                        }
                                        $num++;
                                    }
                                }


                                $song_list_query = "SELECT sa.id,a.artist_img,a.artist_seo,a.artist_name, sa.song_id, sa.artist_id FROM tbl_songs s, tbl_songs_artist sa, tbl_artists a where 1=1 AND a.id = sa.artist_id AND sa.song_id = s.id AND sa.song_id = '$id' AND s.song_status = 1 AND sa.artist_id!=67";
                                $multi_artist = \App\Models\Songs::GetRawData($song_list_query);
                                if ($multi_artist) {
                                    $multi_artist = (array)$multi_artist;
                                    $artist_name = stripslashes(html_entity_decode($multi_artist['artist_name']));
                                    $artist_seo = stripslashes(html_entity_decode($multi_artist['artist_seo']));
                                }
                            ?>
                                <li>
                                    <?php //if ($mobile_view == 0){
                                    //$recent_style = "margin-top:-100px;";
                                    ?>
                                    <div class="row artist_screen">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                            <span class="list_no"><?php if (strlen($sr_num) == 1) {
                                                                        echo "0";
                                                                    } else {
                                                                    }; ?><?php echo $sr_num; ?></span>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12" style="padding-left:0px;">
                                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                                <div class="album_cover">
                                                    <a href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>" class="text_blck">
                                                        <?php
                                                        if ($picture != "") {
                                                            $img_api_link = album_img_api($picture);
                                                            if ($img_api_link != '') {
                                                        ?>
                                                                <img src="<?php echo $img_api_link; ?>" border="0" width="120" />
                                                            <?php } else { ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>" border="0" width="120" />
                                                            <?php
                                                            }
                                                        } else {
                                                            $req_song  =  artist_album_song_func($db_artist_name, stripslashes(html_entity_decode($val['song_title'])));
                                                            if ($req_song['song_array']['image4'] != "") {
                                                            ?>
                                                                <img src="<?php echo $req_song['song_array']['image4']; ?>" border="0" width="120" />
                                                            <?php
                                                            } else
													if ($album_picture != "") {
                                                            ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="100" />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="100" />
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </a>
                                                    <!--<cite class="yellow">5.0</cite>-->
                                                    <?php
                                                    if ($all_avg != 0) {
                                                    ?><cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                    echo number_format($all_avg, 1);
                                                                                                                } else {
                                                                                                                    echo $all_avg;
                                                                                                                } ?></cite><?php } else { ?><cite class="score_big mt-10">5.0</cite><?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-8">
                                                <div class="album_details" style="width:100%;">
                                                    <label class="title"><a href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>"><?php echo $song_title; ?></a></label>
                                                    <label class="author"><a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo); ?>/artist-songs"><?php echo $artist_name; ?></a></label>
                                                    <p><label class="author"><?php if ($feature_artists != "") { ?> <strong>ft.</strong> <?php echo $feature_artists;
                                                                                                                                        } ?></label></p>
                                                    <p><label class="reviews"><img src="<?php echo SERVER_ROOTPATH; ?>images/review-book.png"><a>Reviews <span><?php echo $review_list_arr_top['count_reviews']; ?></span></a></label>
                                                        <label class="reviews" style="margin-left:10px;"><img src="<?php echo SERVER_ROOTPATH; ?>images/icon_post.png"><a>Posts <span><?php echo $comment_list_arr['count_discussion']; ?></span></a></label>
                                                    </p>
                                                </div>
                                            </div>

                                            <p style="text-align:right; margin-right:10%;" class="album_year"> <?php echo $years; ?></p>

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ipad_show_div" style="padding-right:0">

                                                <?php
                                                if ($user_id == "") {
                                                ?>
                                                    <a href="#" data-toggle="modal" data-target="#signin_form" style="padding:0; float:right; margin-right:6px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                <?php
                                                } else {
                                                ?>
                                                    <a data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add_playlist.php?song_id=<?php echo $id; ?>&art_id=<?php echo $dbart_id; ?>" style="padding:0; float:right; margin-right:6px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                <?php
                                                }
                                                ?>



                                                <a href="<?php echo SERVER_ROOTPATH . $song_seo . "/write-a-review/" . $artist_seo; ?>" style="float:right; margin-right:26px;"><button style="margin-left:0">Write a Review</button></a>

                                            </div>
                                            <div class="show_default">
                                                <?php
                                                if ($user_id == "") {
                                                ?>
                                                    <a href="#" data-toggle="modal" data-target="#signin_form" class="playlist_icon"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                <?php
                                                } else {
                                                ?>
                                                    <a class="playlist_icon" data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add_playlist.php?song_id=<?php echo $id; ?>&art_id=<?php echo $dbart_id; ?>"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                <?php
                                                }
                                                ?>
                                                <div class="clear"></div>
                                                <a href="<?php echo SERVER_ROOTPATH . $song_seo . "/write-a-review/" . $artist_seo; ?>" style="margin-top:17px; float:right;"><button>Write a review</button></a>
                                            </div>
                                        </div>
                                    </div>


                                    <?php //}elseif($mobile_view == 1){ 
                                    //$recent_style = "";
                                    ?>

                                    <div class="row artist_mobile">
                                        <!--<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
 										<span class="list_no"><?php if (strlen($sr_num) == 1) {
                                                                    echo "0";
                                                                } else {
                                                                }; ?><?php echo $sr_num; ?></span>
 									</div>-->
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-right:2px !important;">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" style="padding:0px !important;">
                                                <div class="album_cover">
                                                    <a href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>" class="text_blck">
                                                        <?php
                                                        if ($picture != "") {
                                                            $img_api_link = album_img_api($picture);
                                                            if ($img_api_link != '') {
                                                        ?>
                                                                <img src="<?php echo $img_api_link; ?>" border="0" width="120" style="max-width:inherit; " />
                                                            <?php } else { ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo 'thumb_' . $picture; ?>" border="0" width="120" style="max-width:inherit; " />
                                                            <?php
                                                            }
                                                        } else {
                                                            $req_song  =  artist_album_song_func($db_artist_name, stripslashes(html_entity_decode($val['song_title'])));
                                                            if ($req_song['song_array']['image4'] != "") {
                                                            ?>
                                                                <img src="<?php echo $req_song['song_array']['image4']; ?>" border="0" width="120" style="max-width:inherit; " />
                                                            <?php
                                                            } else
													if ($album_picture != "") {
                                                            ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="100" style="max-width:inherit; " />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="100" style="max-width:inherit; " />
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </a>
                                                    <?php
                                                    if ($all_avg != 0) { ?>
                                                        <cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                        echo number_format($all_avg, 1);
                                                                                                                    } else {
                                                                                                                        echo $all_avg;
                                                                                                                    } ?></cite><?php } else { ?><cite class="score_big mt-10">5.0</cite><?php } ?>

                                                    <div style="position:absolute; z-index:10; margin-left:84%; color:#FFFFFF; margin-top:-20px;" class="review_screen_txt"><?php echo $sr_num; ?></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" style="padding:0px !important;">
                                                <div class="album_details" style="width:100%;">
                                                    <label class="title"><a href="<?php echo SERVER_ROOTPATH . $song_seo . "-reviews-" . $artist_seo; ?>"><?php echo $song_title; ?></a></label>
                                                    <label class="author"><a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo); ?>/artist-songs"><?php echo $artist_name; ?></a></label>
                                                    <p>
                                                        <label class="reviews" style="float:left !important;"><?php echo "ft. " . $feature_artists; ?></label>

                                                    </p>
                                                    <div style="clear:both;"></div>

                                                    <p><label class="reviews"><img src="<?php echo SERVER_ROOTPATH; ?>images/review-book.png"><a href="#">Reviews <span><?php echo $review_list_arr_top['count_reviews']; ?></span></a></label><label class="reviews"><img src="<?php echo SERVER_ROOTPATH; ?>images/icon_post.png"><a href="#">Posts <span><?php echo $comment_list_arr['count_discussion']; ?></span></a></label></p>
                                                    <p style="float:left; margin-left:0; font-size: 18px;"><?php echo $years; ?>
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
                                                        <a data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add_playlist.php?song_id=<?php echo $id; ?>&art_id=<?php echo $dbart_id; ?>" style="padding:0; float:left; margin-right:6px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
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
                                    <?php //}
                                    ?>
                                </li>
                            <?php
                            }
                        } else { ?> <p style="color:#FF0000; padding:5px; color:#333;"> No records found.</p><?php } ?>
                    </ul>
                    <?php if ($total_pages > $limit) { ?>
                        <div class="page-navigation">
                            <ul>
                                @include("common.paging-playlist")
                            </ul>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">


                    <?php 
                    //include("common.artist_common_popular_review")
                    ?>
                </div>
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
<!-- ./Middle Section -->
<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

@include("common.signin_modal")
@include("common.footer")
<?php
//include_once("common/popular_review.php"); 
?>
<div class="modal fade" id="show_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<div class="modal fade" id="create_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>