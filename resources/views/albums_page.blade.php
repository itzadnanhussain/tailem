@include("common.header")
<?php

error_reporting(0);
if ($album_seo != "") {
    $where_condition = " AND b.album_seo = '$album_seo'";
}
else
{
    $where_condition = '';
}

$artist_id_db             = stripslashes(html_entity_decode($row_artist['id']));
$artist_seo             = strtolower(stripslashes(html_entity_decode($row_artist['artist_seo'])));
$db_artist_name         = stripslashes(html_entity_decode($row_artist['artist_name']));
$artist_description     = stripslashes(html_entity_decode($row_artist['artist_description']));
$artist_img             = stripslashes(html_entity_decode($row_artist['artist_img']));
$lastfm_url             = stripslashes($row_artist['lastfm_url']);

$artistname = urlencode($db_artist_name);
if ($lastfm_url == "") {
    ini_set('allow_url_fopen ', 'ON');
    $temp = file_get_contents("http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=" . $artistname . "&api_key=979650ff4905a23bb01e312145761ebb");
    $XmlObj = simplexml_load_string($temp);
    $info = $XmlObj->artist->bio->summary;
    $image4 = $XmlObj->artist->image[3];
    $name    = $XmlObj->artist->name;
    $url     = $XmlObj->artist->url;

    $val     = '<a href="http://www.last.fm/music/Justin+Bieber">Read more about Justin Bieber on Last.fm</a>';
    $val     = $info;
    $val     =  str_replace($url, "#", $val);
    $val     =  str_replace("Read more on Last.fm", "", $val);
    $val1    = '<a href="#"></a>.';
    $info1  =  str_replace($val1, "", $val);
    $val2    = '<a href="#"></a>';
    $info   =  strip_tags(str_replace($val2, "", $info1));
    if ($info != "" || $image4 != "") {
        $SQL = "UPDATE `tbl_artists` SET `artist_name` = '" . remove_spl_char($artist_update_data['updated_by_itunes']) . "',
				`artist_img` = '" . $image4 . "',
				`lastfm_url` = '" . $url . "',
				`artist_description` = '" . remove_spl_char($info) . "'
								`updated_by_itunes` = '" . date("Y-m-d H:i:s") . "' WHERE  `tbl_artists`.`id` ='" . $artist_id_db . "'";
        mysqli_query($db->dbh, $SQL);
    }
} else {

    $image4 = $artist_img;
    $name    = $artistname;
    $url     = $lastfm_url;

    $val     = $artist_description;
    $val     =  str_replace($url, "#", $val);
    $val     =  str_replace("Read more on Last.fm", "", $val);
    $val1    = '<a href="#"></a>.';
    $info1  =  str_replace($val1, "", $val);
    $val2    = '<a href="#"></a>';
    $info   =  strip_tags(str_replace($val2, "", $info1));
}




?>

<!-- End Custom css -->
<style>
    body {
        overflow-x: hidden;
    }

    iframe {
        max-height: 230px;
    }

    .artistSongspic .topsonglistsec .songlistings .album_cover {
        width: 100%;
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


        if (empty($counter_main)) {
            $qry = "select l.id from tbl_likes l, tbl_artists a where l.like_type = 'artist' AND l.like_id = a.id AND a.id = $artist_id_db";
            $counter_main = array();
            $counter_main = \App\Models\Songs::GetRawData($qry);
            if ($counter_main) {
                $counter_main = count($counter_main);
            } else {
                $counter_main = 0;
            }
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
                                        } ?>
                                        <small style="color:#000000; font-size:14px;">
                                            <?php if ($user_id != "") {

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
                                        <a class="heart_color" href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-albums"; ?>">Albums</a> -
                                        <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-featured"; ?>">Featured</a>
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
                                        ?><cite class="score_big mt-10" style="left:3px;  background-color:<?php echo $array_score['color_pick']; ?>"><?php echo $array_score['rating_avg']; ?></cite><?php } else { ?> <cite style="background-color:#dd554e;">0.0</cite> <?php } ?>
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
                                                echo  $artist_description;
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
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="bottom:12px; padding-left:0px;">
                                <h3 class="alb_heading headingmedium" style="font-size: 22px;">Albums <?php if ($album_seo != "") {
                                                                                    $show = str_replace("-", " ", $album_seo);
                                                                                ?><span style="text-transform:capitalize;"><?php echo ucfirst($show);
                                                                                                                        } ?></span></h3>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <!--<label>Sort by:</label>
                                    	<select class="button_position select_year">
                                        	<option value="">Year Released</option>
                                        	<option value="highest"> Highest Rating </option>
                                        	<option value="lowest"> Lowest Rating </option>
                                        	<option value="popular"> Most Popular </option>
                                    	</select>-->
                            </div>
                        </div>
                    </div>



                    <ul class="songlistings">
                        <?php


                        $artist_list_arr = array();
                        


                        if (empty($artist_list_arr1)) {
                            $artist_list = "SELECT b.album_seo, b.years, b.album_title, b.album_picture, b.id, b.album_artist_id, b.album_seo, saa.song_id, tbl_songs.song_title FROM tbl_artist_album b, tbl_songs_artist_album saa , tbl_songs WHERE 1 = 1 AND saa.artist_id = $artist_id_db AND b.album_artist_id = $artist_id_db AND tbl_songs.id= saa.song_id AND tbl_songs.song_status=1 AND b.id = saa.album_id AND saa.display_status = 1 AND b.album_status = 1 $where_condition  GROUP BY saa.album_id ORDER BY saa.id DESC LIMIT 1000";

                            $artist_list_arr = \App\Models\Songs::GetRawData($artist_list);
                          

                            if ($artist_list_arr) {
                                $total_pages = count($artist_list_arr);
                            } else {
                                $total_pages =  0;
                            }
                        }

                        // echo 'cleared';
                        // die;

                        $limit = 10;
                        if ($page)
                            $start = ($page - 1) * $limit; //first item to display on this page
                        else {
                            $start = 0;                    //if no page var is given, set start to 0

                        }                  //if no page var is given, set start to 0
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
                            $sr_num = 0;
                            foreach ($artist_list_arr as $val) {
                                $val = (array)$val;
                                


                                $id      = $val['id'];
                                $album_title = stripslashes(html_entity_decode($val['album_title']));
                                // $artist_name = stripslashes(html_entity_decode($val['artist_name']));
                                $album_picture   = stripslashes(html_entity_decode($val['album_picture']));
                                $song_title = stripslashes(html_entity_decode($val['song_title']));
                                $db_song_id = stripslashes(html_entity_decode($val['song_id']));
                                // $artist_name = wordwrap($artist_name, 100, " ", true);

                                $album_artist_id    =    $val['album_artist_id'];
                                $album_seo    =    stripslashes(html_entity_decode($val['album_seo']));

                                $years = stripslashes(html_entity_decode($val['years']));
                                $album_seo  = strtolower(stripslashes(html_entity_decode($val['album_seo'])));

                                $key = md5("sum_rating_" . $id); // Unique Words
                                $rate_arr = array();
                                //$rate_arr = $memcache->get($key); // Memcached object 

                                // if (empty($rate_arr)) {

                                //     $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where album_id = $id AND status = 1";
                                //     $rate_arr    =    $db->get_row($sum_rating, ARRAY_A);
                                //     $memcache->set($key, $rate_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME);
                                // }
                                // $sum_rate = $rate_arr['sum_rate'];
                                // $counter = $rate_arr['counter'];

                                // if ($sum_rate == "" || $sum_rate == 0) {
                                //     $sum_rate = 0;
                                // }



                                // $all_avg_album  =  $sum_rate / $counter;
                                $rating_avg = calculate_rating_main($id, $album_artist_id, $album_seo);
                                $all_avg_album  =  $rating_avg;

                                if ($all_avg_album == "") {
                                    $all_avg_album = 0;
                                }

                                if ($all_avg_album >= 8) {
                                    $color_pick_album = "#5cb85c";
                                }

                                if ($all_avg_album >= 7 && $all_avg_album < 8) {
                                    $color_pick_album = "#5cb85c";
                                }

                                if ($all_avg_album >= 4 && $all_avg_album < 6.9) {
                                    $color_pick_album = "#ff0";
                                }

                                if ($all_avg_album >= 2 && $all_avg_album < 3.9) {
                                    $color_pick_album = "#d9534f";
                                }

                                if ($all_avg_album > 0 && $all_avg_album < 2) {
                                    $color_pick_album = "#d9534f";
                                }

                                if ($all_avg_album >= 7) {
                                    $color_pick_album = "#5ebd5e";
                                } elseif ($all_avg_album >= 4 && $all_avg_album <= 6.9) {
                                    $color_pick_album = "#e06d21";
                                } elseif ($all_avg_album >= 0 && $all_avg_album <= 3.9) {
                                    $color_pick_album = "#dd554e";
                                }

                                $sr_num++;
                                if ($val['album_picture'] != "") {
                                    $req_album['album_array']['image4']    = album_img_api($val['album_picture']);
                                } else {
                                    $req_album  =  artist_album_func("$db_artist_name", stripslashes(html_entity_decode($val['album_title'])));
                                }


                                // ajax code to fetch songs


                                if ($artist_id_db != 67) {
                                    $songs_list =    "SELECT a.artist_seo, 
												a.artist_name 
												FROM  tbl_songs_artist_album saa
												inner join tbl_songs s on saa.song_id = s.id
												inner join tbl_artists a on saa.artist_id=a.id
												where saa.artist_id != '$artist_id_db' 
												AND saa.album_id = '$id'
																							
												AND saa.display_status = 1 
												AND s.song_status = 1";
                                    //print_r($songs_list);
                                    //die;
                                    // $various    = $db->get_row($songs_list, ARRAY_A);
                                    $various = \App\Models\Songs::GetRawData($songs_list);
                                    //AND saa.`artist_id`=$artist_id_db 	condition to show only artist songs and alblum we are want to see

                                }
                                $songs_list = "select  s.song_title,
														 s.id,
														 s.song_seo,
														 a.artist_seo,
														 a.artist_name,
														 s.picture
														 from tbl_songs_artist_album saa
														 inner join tbl_songs s on saa.song_id = s.id
														 inner join tbl_artists a on saa.artist_id=a.id
														 inner join tbl_artist_album b on saa.album_id=b.id
														 where saa.artist_id != 67  AND b.id = '$id'
														 AND saa.`artist_id`=$artist_id_db 
														 AND saa.display_status = 1
														 AND s.song_status = 1
														 group by s.id ";
                                // $sings_list_arr    = $db->get_results($songs_list, ARRAY_A);
                                $sings_list_arr = \App\Models\Songs::GetRawData($songs_list);
                                
                                if ($sings_list_arr) {
                                    $counter_rows  = count($sings_list_arr);
                                } else {
                                    $counter_rows  = 0;
                                }
                                $sum_review_rate = 0;
                                $arr_index = 0;
                                if (isset($sings_list_arr)) {
                                    foreach ($sings_list_arr as $val) {
                                        $val = (array)$val;
                                        $id_song      = $val['id'];
                                        $s_picture      =  stripslashes($val['picture']);

                                        $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.song_id = '" . $id_song . "' order by r.review_id desc limit 1";

                                        $review_list_arr_top = \App\Models\Songs::GetRawData($review_list_qry);
                                        $review_list_arr_top = (array)$review_list_arr_top[0];
                                        $comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_review_id = '" . $id_song . "' order by comment_id desc limit 1";

                                        $comment_list_arr = \App\Models\Songs::GetRawData($review_list_qry);
                                        $comment_list_arr = (array)$comment_list_arr[0];

                                        // $song_title = stripslashes(html_entity_decode($val['song_title']));
                                        $artist_seo = strtolower(stripslashes(html_entity_decode($val['artist_seo'])));
                                        // $artist_name = stripslashes(html_entity_decode($val['artist_name']));
                                        $song_seo   = strtolower(stripslashes(html_entity_decode($val['song_seo'])));


                                        $mainartist_arr    =    mainartist_detail($album_artist_id);
                                        
                                        $artist_name = stripslashes($mainartist_arr['artist_name']);
                                        $artist_seo     = stripslashes($mainartist_arr['artist_seo']);




                                        $qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '" . $id_song . "'";
                                        $qry_feature_arr = \App\Models\Songs::GetRawData($qry_top_feature_artist);
                                        if ($qry_feature_arr) {
                                            $count  = count($qry_feature_arr);
                                        } else {
                                            $count  = 0;
                                        }
                                        $num = 1;


                                        $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = $id_song AND status = 1";
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
                                        } elseif ($all_avg >= 4 && $all_avg <= 6.9) {
                                            $color_pick = "#e06d21";
                                        } elseif ($all_avg >= 0 && $all_avg <= 3.9) {
                                            $color_pick = "#dd554e";
                                        }

                                        $sum_review_rate = $sum_review_rate + $all_avg;
                                        $feature_artists = "";
                                        if ($qry_feature_arr) {
                                            foreach ($qry_feature_arr as $val_feature) {
                                                $val_feature = (array)$val_feature;
                                                if ($num == $count) {
                                                    $feature_artists .= " <a class='ft_size' href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $val_feature['feature_artist'] . "</a>";
                                                } else {
                                                    $feature_artists .= " <a class='ft_size' href='" . SERVER_ROOTPATH . Slug($val_feature['f_artist_seo']) . "/artist-songs'>" . $val_feature['feature_artist'] . "</a>,";
                                                }
                                                $num++;
                                            }
                                        }
                                        $arr_song_seo[$arr_index] = $song_seo;
                                        $arr_artist_seo[$arr_index] = $artist_seo;
                                        $arr_song_title[$arr_index] = $song_title;
                                        $arr_db_song_id[$arr_index] = $id_song;

                                        $arr_db_artist_name[$arr_index] = $artist_name;
                                        $arr_feature_artists[$arr_index] = $feature_artists;
                                        $arr_all_avg[$arr_index] = $all_avg;
                                        $arr_color_pick[$arr_index] = $color_pick;
                                        $arr_count_reviews[$arr_index] = $review_list_arr_top['count_reviews'];
                                        $arr_count_discussion[$arr_index] = $comment_list_arr['count_discussion'];
                                        $arr_song_picture[$arr_index] = $s_picture;


                                        $arr_index++;
                                    }
                                }



                        ?>
                                <li>
                                    <!--Desktop View-->
                                    <div class="row artist_screen">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="cursor:pointer;">
                                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                                <div class="album_cover">
                                                    <?php
                                                    if ($album_picture != "") {
                                                        $img_api_link = album_img_api($album_picture);
                                                        if ($img_api_link != '') {
                                                    ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><img src="<?php echo $img_api_link; ?>" border="0" width="170" height="170" /></a>
                                                        <?php } else { ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="100" /></a>
                                                        <?php
                                                        }
                                                    } else
													if ($req_album['album_array']['image4'] != "") {
                                                        ?>
                                                        <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><img src="<?php echo $req_album['album_array']['image4']; ?>" border="0" width="100" /></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="100" /></a>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php if ($all_avg_album != 0) { ?>
                                                        <cite style="background-color:<?php echo $color_pick_album; ?>"> <?php echo number_format(($rating_avg), 1); ?></cite><?php } else { ?><cite class="score_big mt-10" style="background-color:#dd554e; left:3px;">0.0</cite>
                                                    <?php  } ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-8 ">
                                                <div class="album_details" style="width:100%;">
                                                    <label class="title">
                                                        <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><?php echo $album_title; ?></a>
                                                    </label>
                                                    <label class="author">
                                                        <?php
                                                        if ($various) {
                                                        ?><a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo $db_artist_name; ?></a>
                                                        <?php } else {
                                                        ?><a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo $db_artist_name; ?></a>
                                                        <?php
                                                        } ?>
                                                    </label>
                                                    <p>Album Songs <a id="show_songs_<?php echo $id; ?>" title="Album Songs" style="color:#DE6161;" href="javascript:;" onClick="view_album_songs('<?php echo $id; ?>');">( + )</a><a id="hide_songs_<?php echo $id; ?>" title="Album Songs" style="display:none; color:#DE6161;" href="javascript:;" onClick="hide_album_songs('<?php echo $id; ?>');">( - )</a></p>
                                                </div>
                                            </div>
                                            <p class="album_year" style="text-align:right; margin-right:10%;"><?php echo $years; ?></p>
                                        </div>
                                    </div>
                                    <div class="row" style="display:none;" id="view_songs_<?php echo $id; ?>">
                                        <?php
                                        for ($s = 0; $s < $arr_index; $s++) {

                                        ?>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                <span class="list_no"><?php if ($s < 9) {
                                                                            echo "0";
                                                                        } else {
                                                                        };
                                                                        echo $s + 1; ?></span>
                                            </div>
                                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12" style="margin-top:10px; margin-bottom:10px; background-color:#F8F8F8;">
                                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 pad_right pad_left">
                                                    <div class="album_cover">
                                                        <?php
                                                        if ($arr_song_picture[$s] != '') {
                                                            $pos = strpos($arr_song_picture[$s], 'http');
                                                            if ($pos !== false) {
                                                        ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><img src="<?php echo $arr_song_picture[$s]; ?>" border="0" width="100" /></a>
                                                            <?php

                                                            } else {
                                                            ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo $arr_song_picture[$s]; ?>" border="0" width="100" /></a>
                                                            <?php
                                                            }
                                                        } else
												   if ($album_picture != "") {
                                                            $img_api_link = album_img_api($album_picture);
                                                            if ($img_api_link != '') {
                                                            ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><img src="<?php echo $img_api_link; ?>" border="0" width="170" height="170" /></a>
                                                            <?php } else { ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="100" /></a>
                                                            <?php
                                                            }
                                                        } else
													if ($req_album['album_array']['image4'] != "") {
                                                            ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><img src="<?php echo $req_album['album_array']['image4']; ?>" border="0" width="100" /></a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="100" /></a>
                                                        <?php
                                                        }
                                                        if ($arr_all_avg[$s] != 0) {
                                                        ?><cite style="background-color:<?php echo $arr_color_pick[$s]; ?>"><?php if ($arr_all_avg[$s] < 10) {
                                                                                                                                echo number_format($arr_all_avg[$s], 1);
                                                                                                                            } else {
                                                                                                                                echo $arr_all_avg[$s];
                                                                                                                            } ?></cite><?php } else {
                                                                                                                                        ?><cite style="background-color:#dd554e">0.0</cite><?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 col-md-7 col-sm-8 col-xs-8 pad_right">
                                                    <div class="album_details" style="width:100%;">
                                                        <label class="title"><a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><?php echo  $arr_song_title[$s]; ?></a></label>
                                                        <label class="author"><a href="<?php echo SERVER_ROOTPATH . Slug($arr_artist_seo[$s]) . "/artist-songs"; ?>"><?php echo $arr_db_artist_name[$s]; ?></a></label><br>
                                                        <?php if ($arr_feature_artists[$s] != "") { ?>
                                                            <label class="author"><strong>ft. </strong><?php echo $arr_feature_artists[$s]; ?></label><?php } ?>
                                                        <p><label class="reviews"><img src="<?php echo SERVER_ROOTPATH; ?>images/review-book.png"><a>Reviews <span><?php echo $arr_count_reviews[$s]; ?></span></a></label><label class="reviews" style="margin-left:10px;"><img src="<?php echo SERVER_ROOTPATH; ?>
images/icon_post.png"><a>Posts <span><?php echo $arr_count_discussion[$s]; ?></span></a></label></p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-3">
                                                    <?php
                                                    if ($user_id == "") {
                                                    ?>
                                                        <a href="#" data-toggle="modal" data-target="#signin_form" style="padding:0; float:right; margin-right:6px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" style="padding:0;" /></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add-playlist?song_id=<?php echo $arr_db_song_id[$s]; ?>&art_id=<?php echo $album_artist_id; ?>" style="padding:0; float:right; margin-right:6px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                    <?php
                                                    }
                                                    ?>
                                                    <br />
                                                    <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo) . "/write-a-review/" . Slug($arr_artist_seo); ?>"><button class="btn_rev marginright" style="bottom:0px; position:static;">Write a review</button></a>
                                                </div>
                                                <!-- <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo) . "/write-a-review/" . Slug($arr_artist_seo); ?>"><button class="btn_rev">Write a review</button></a>-->
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <!--Mobile View-->
                                    <div class="row artist_mobile">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" style="padding:0px !important;">
                                                <div class="album_cover">
                                                    <?php
                                                    if ($album_picture != "") {
                                                        $img_api_link = album_img_api($album_picture);
                                                        if ($img_api_link != '') {
                                                    ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><img src="<?php echo $img_api_link; ?>" border="0" width="170" height="170" /></a>
                                                        <?php } else { ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="100" /></a>
                                                        <?php
                                                        }
                                                    } else
													if ($req_album['album_array']['image4'] != "") {
                                                        ?>
                                                        <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><img src="<?php echo $req_album['album_array']['image4']; ?>" border="0" width="100" /></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="100" /></a>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php if ($all_avg_album != 0) { ?>
                                                        <cite style="background-color:<?php echo $color_pick_album; ?>"> <?php echo number_format(($rating_avg), 1); ?></cite><?php } else { ?><cite style="background-color:#dd554e;">0.0</cite>

                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" style="padding:0px !important;">
                                                <div class="album_details">
                                                    <label class="title"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><?php echo $album_title; ?></a></label>
                                                    <label class="author"><?php
                                                                            if ($various) {
                                                                            ?><a href="<?php echo SERVER_ROOTPATH . Slug($various['artist_seo']) . "/artist-songs"; ?>"><?php echo $db_artist_name; ?></a>
                                                        <?php } else {
                                                        ?><a href="<?php echo SERVER_ROOTPATH . Slug($artist_seo) . "/artist-songs"; ?>"><?php echo $db_artist_name; ?></a>
                                                        <?php
                                                                            } ?></label>
                                                    <p>Album Songs <a id="show_song_<?php echo $id; ?>" title="Album Songs" style="color:#DE6161;" href="javascript:;" onClick="view_album_song('<?php echo $id; ?>');">( + )</a><a id="hide_song_<?php echo $id; ?>" title="Album Songs" style="display:none; color:#DE6161;" href="javascript:;" onClick="hide_album_song('<?php echo $id; ?>');">( - )</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="display:none;" id="view_song_<?php echo $id; ?>">
                                        <?php
                                        for ($s = 0; $s < $arr_index; $s++) {
                                        ?>

                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="background-color:#F8F8F8;">
                                                <span class="list_no"></span>
                                            </div>

                                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11" style="margin-top:10px; margin-bottom:10px; background-color:#F8F8F8; padding-right:0;">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" style="padding:0px !important;">
                                                    <div class="album_cover">
                                                        <?php
                                                        if ($arr_song_picture[$s] != '') {
                                                            $pos = strpos($arr_song_picture[$s], 'http');
                                                            if ($pos !== false) {
                                                        ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><img src="<?php echo $arr_song_picture[$s]; ?>" border="0" width="100" /></a>
                                                            <?php

                                                            } else {
                                                            ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/song_images/<?php echo $arr_song_picture[$s]; ?>" border="0" width="100" /></a>
                                                            <?php
                                                            }
                                                        } else
												   if ($album_picture != "") {
                                                            $img_api_link = album_img_api($album_picture);
                                                            if ($img_api_link != '') {
                                                            ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><img src="<?php echo $img_api_link; ?>" border="0" width="170" height="170" /></a>
                                                            <?php } else { ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="100" /></a>
                                                            <?php
                                                            }
                                                        } else
													if ($req_album['album_array']['image4'] != "") {
                                                            ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><img src="<?php echo $req_album['album_array']['image4']; ?>" border="0" width="100" /></a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="100" /></a>
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php

                                                        if ($arr_all_avg[$s] != 0) {
                                                        ?><cite style="background-color:<?php echo $arr_color_pick[$s]; ?>"><?php if ($arr_all_avg[$s] < 10) {
                                                                                                                                echo number_format($arr_all_avg[$s], 1);
                                                                                                                            } else {
                                                                                                                                echo $arr_all_avg[$s];
                                                                                                                            } ?></cite><?php } else { ?> <cite style="background-color:#dd554e;">0.0</cite><?php } ?>

                                                        <div style="position:absolute; z-index:10; margin-left:84%; color:#FFFFFF; margin-top:-20px;" class="review_screen_txt"><?php echo $s + 1; ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" style="padding:0px !important;  padding-right:0;">
                                                    <div class="album_details">
                                                        <label class="title"><a href="<?php echo SERVER_ROOTPATH . Slug($arr_song_seo[$s]) . "/reviews/" . Slug($arr_artist_seo[$s]); ?>"><?php echo  $arr_song_title[$s]; ?></a></label>
                                                        <label class="author"><a href="<?php echo SERVER_ROOTPATH . Slug($arr_artist_seo[$s]) . "/artist-songs"; ?>"><?php echo $arr_db_artist_name[$s]; ?></a></label><br>
                                                        <?php if ($arr_feature_artists[$s] != "") { ?>
                                                            <label class="author"><strong>ft. </strong><?php echo $arr_feature_artists[$s]; ?></label><?php } ?>
                                                        <p><label class="reviews"><img src="images/review-book.png"><a>Reviews <span><?php echo $arr_count_reviews[$s]; ?></span></a></label><label class="reviews"><img src="<?php echo SERVER_ROOTPATH; ?>
images/icon_post.png"><a>Posts <span><?php echo $arr_count_discussion[$s]; ?></span></a></label></p>
                                                        <!-- <p class="album_year">Year <b>2016</b></p>-->
                                                    </div>


                                                </div>

                                                <div class="clear"></div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-right:2px !important;">
                                                    <div class="col-sm-5 col-xs-5">
                                                        <?php
                                                        if ($user_id == "") {
                                                        ?>
                                                            <a href="#" data-toggle="modal" data-target="#signin_form" style="padding:0; float:left; margin-right:6px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add-playlist?song_id=<?php echo $arr_db_song_id[$s]; ?>&art_id=<?php echo $album_artist_id; ?>" style="padding:0; float:left; margin-right:6px;"><img src="<?php echo addtoplaylist_icon(); ?>" title="Add to Playlist" /></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-7 col-xs-7" style="padding-right:20px; float:right;">
                                                        <a href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/write-a-review/" . Slug($artist_seo); ?>" style="margin-top:-2px;"><button>Write a review</button></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </li>
                            <?php
                            }
                        } else { ?> <p style="color:#333; padding:5px;"> No records found.</p><?php } ?>
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
                    <div class="row">
                        <div class="review_item artist_mobile" style="margin-top:5px;">
                            <?php echo ads_info('right'); ?>
                        </div>
                    </div>

                    
                    @include("include.artist_common_popular_review") 
                    
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

<script>
    function view_album_songs(id) {
        $("#show_songs_" + id).hide();
        $("#hide_songs_" + id).show();
        $("#view_songs_" + id).show();

        $("#view_song_" + id).hide();
    }

    function hide_album_songs(id) {
        $("#show_songs_" + id).show();
        $("#hide_songs_" + id).hide();
        $("#view_songs_" + id).hide();

        $("#view_song_" + id).hide();
    }

    function view_album_song(id) {
        $("#show_song_" + id).hide();
        $("#hide_song_" + id).show();
        $("#view_song_" + id).show();

        $("#view_songs_" + id).hide();

    }

    function hide_album_song(id) {
        $("#show_song_" + id).show();
        $("#hide_song_" + id).hide();
        $("#view_song_" + id).hide();

        $("#view_songs_" + id).hide();
    }
</script>
@include("common.signin_modal")
@include("common.footer")
<?php
//include_once("common/popular_review.php");
?>
<div class="modal fade" id="show_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<div class="modal fade" id="create_playlist" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>