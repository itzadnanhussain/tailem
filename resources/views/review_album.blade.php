@include("common.header")
<?php



$USER_NAME = ucfirst($user_name);
$request_url_check    =    str_replace("/", '', $_SERVER['REQUEST_URI']);




function get_listof_songs_ids($album_id, $artid)
{
    $artist_list = "select b.album_title, b.album_seo, saa.song_id, saa.artist_id from tbl_songs_artist_album saa, tbl_artist_album b where saa.album_id = b.id AND saa.artist_id = '$artid' AND saa.album_id = '$album_id' AND saa.display_status = 1 ";


    $artist_list_arr = \App\Models\Songs::GetRawData($artist_list);
    if ($artist_list_arr) {
        $total_result    =    count($artist_list_arr);
    } else {
        $total_result = 0;
    }
    $u = 1;
    $list  = '';
    if ($artist_list_arr) {

        foreach ($artist_list_arr as $arr) {
            $arr = (array)$arr;
            if ($u == $total_result) {
                $list .=  $arr['song_id'];
            } else {
                $list .=  $arr['song_id'] . ", ";
            }
            $u++;
        }
    }


    return $list;
}
function calculate_rating($user_id, $album_id, $artist_id, $albseo)
{


    $listof_ids  =    get_listof_songs_ids($album_id, $artist_id);
    // if ($listof_ids == '') {
    //     $pass_where = '';
    // } else {
    //     $pass_where = " OR (rev.song_id IN ($listof_ids))";
    // }

    // $where_condition .= " AND (b.album_seo = '$albseo' $pass_where)";


    $sum_rating_query    = "select Sum(rev.review_rating) as total_sum, Count(*) as number_count
							from tbl_artist_album b, tbl_artists a, tbl_songs s, tbl_reviews rev, tbl_users u 
							where 1=1 
							AND s.id = rev.song_id 
							AND a.id = rev.artist_id 
							AND b.id = rev.album_id 
							AND u.user_id = rev.review_user_id  
							AND rev.review_user_id = '" . $user_id . "'
							AND s.song_status = 1
                            AND (b.album_seo = '$albseo' OR (rev.song_id IN ('$listof_ids'))) 

							  LIMIT 50";

    $rate_list_arr = \App\Models\Songs::GetRawData($sum_rating_query);

    if ($rate_list_arr) {
        $total_sum_rating    =     $rate_list_arr[0]->total_sum;
        $number_count        =    $rate_list_arr[0]->number_count;
        $total_Rating    =    $total_sum_rating / $number_count;
    } else {
        $total_Rating    =   0;
    }

    return $total_Rating;
}



?>
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
            <?php //include("include/latest_activities.php");
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
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div style="background-color:#FFFFFF; padding:10px;" class="brows-label-penel">
                @include("include.artist_review_like_menu")
            </div>
        </div>
    </div>

    <!--</div>-->


    <div class="topRwContent-panel pad_zero" style="margin-bottom:15px;">

        <div class="topsonglistsec col-lg-8 col-md-12 col-sm-12 col-xs-12 pad_zero" style="background:none;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad_zero">
                <ul class="songlistings" style=" border-right:1px solid #ccc;">
                    <?php
                    //$where_condition = "";
                    //$album_page ="";

                    //if($album_page=="")
                    //{
                    //$album_page = $main_link."review-album";
                    //}
                    $last_value = 0;


                    $where_condition = "";
                    if ($artist_seo != "") {
                        $get_artist = $artist_seo;
                        $where_condition .= " AND a.artist_seo = '$get_artist'";
                    }
                    //============================================================
                    //PAGGING CODE STARTS HERE



                    $artist_list = "SELECT  a.id as artid, b.id as albid, a.artist_seo,a.artist_name,b.album_seo,b.years, b.album_artist_id,b.album_title, b.album_picture,b.updated_by_itunes, b.id,r.review_user_id FROM tbl_reviews r, tbl_songs_artist_album s, tbl_artist_album b, tbl_artists a WHERE  r.song_id = s.song_id AND r.artist_id = s.artist_id AND b.id = s.album_id AND a.id = b.album_artist_id AND r.review_user_id = '" . $user_profile . "' AND b.album_status = 1 $where_condition group by b.album_title order by r.review_id desc limit 50";
                    $artist_list_arr = array();
                    $artist_list_arr = \App\Models\Songs::GetRawData($artist_list);

                    if ($rate_list_arr) {
                        $total_pages = count($artist_list_arr);
                    } else {
                        $total_pages = 0;
                    }



                    if (isset($get_artist) && ($get_artist != "")) {
                        if ($user_seo == '') {
                            $targetpage = SERVER_ROOTPATH . $artist_seo . "/review-albums"; //your file name  (the name of this file)
                        } else {
                            $targetpage = SERVER_ROOTPATH . get_user_detail($USER_NAME) . "/profile/" . $artist_seo . "/review-albums"; //your file name  (the name of this file)
                        }
                    } else
											if ($main_link != "") {
                        $targetpage = $main_link . "review-album"; //your file name  (the name of this file)
                    } else {
                        $targetpage = SERVER_ROOTPATH . "review-album"; //your file name  (the name of this file)
                    }



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




                    $artist_list_arr = array_slice($artist_list_arr, $start, 10);
                    if (isset($artist_list_arr)) {
                        $k = 1;
                        foreach ($artist_list_arr as $val) {
                            $val = (array)$val;
                            $id      = $val['id'];
                            $album_title = stripslashes(html_entity_decode($val['album_title']));
                            $review_user_id = stripslashes(html_entity_decode($val['review_user_id']));
                            $artist_name = stripslashes(html_entity_decode($val['artist_name']));
                            $album_picture   = stripslashes(html_entity_decode($val['album_picture']));
                            $years = stripslashes(html_entity_decode($val['years']));

                            $album_artist_id = stripslashes(html_entity_decode($val['album_artist_id']));
                            $artist_seo = strtolower(stripslashes(html_entity_decode($val['artist_seo'])));
                            $album_seo  = strtolower(stripslashes(html_entity_decode($val['album_seo'])));
                            $album_title = wordwrap($album_title, 100, " ", true);
                            $artist_name = wordwrap($artist_name, 100, " ", true);

                            $artid    =    $val['artid'];
                            $albid    =    $val['albid'];

                            $qry =  "select id from tbl_likes where like_type = 'artist' AND like_id = '$album_artist_id'";
                            $counter_main = array();
                            $counter_main = \App\Models\Songs::GetRawData($qry);
                            if ($counter_main) {
                                $counter_main = count($counter_main);
                            } else {
                                $counter_main = 0;
                            }



                            //$all_avg  =  $sum_rate / $counter;
                            $rating_avg = calculate_rating_main($id, $artid, $album_seo);
                            $all_avg  =  $rating_avg;

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

                            $aaa = calculate_rating($review_user_id, $albid, $artid, $album_seo);

                            /*rating current users right side*/
                            $sum_rating_user = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where album_id = $id  AND status = 1 and review_user_id = '$review_user_id'";
                            $rate_user_arr = \App\Models\Songs::GetRawData($sum_rating_user);
                            if ($rate_user_arr) {
                                $rate_user_arr = (array)$rate_user_arr[0];
                                $sum_user_rate = $rate_user_arr['sum_rate'];
                                $counter_user = $rate_user_arr['counter'];
                            } else {
                                $sum_user_rate = 0;
                                $counter_user =  0;
                            }

                            if ($sum_rate == "" || $sum_user_rate == 0) {
                                $sum_user_rate = 0;
                            }

                            $all_user_avg  =  $aaa;

                            if ($all_user_avg == "") {
                                $all_user_avg = 0;
                            }

                            if ($all_user_avg >= 8) {
                                $color_pick_user = "#5ebd5e";
                            }

                            if ($all_user_avg >= 7 && $all_user_avg < 8) {
                                $color_pick_user = "#5ebd5e";
                            }

                            if ($all_user_avg >= 4 && $all_user_avg < 6.9) {
                                $color_pick_user = "#e06d21";
                            }

                            if ($all_user_avg >= 2 && $all_user_avg < 3.9) {
                                $color_pick_user = "#dd554e";
                            }

                            if ($all_user_avg > 0 && $all_user_avg < 2) {
                                $color_pick_user = "#dd554e";
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
                            $sr_no++;
                            if ($album_picture == '' &&  $val['updated_by_itunes'] == '0000-00-00 00:00:00') {
                                $req_artist  =  artist_album_func(stripslashes(html_entity_decode($val['artist_name'])), stripslashes(html_entity_decode($val['album_title'])));
                            }

                            if (strpos($request_url_check, 'profile') !== false) {
                                $url_gen    =    SERVER_ROOTPATH . get_user_detail($USER_NAME) . "/profile-review-song/" . $album_seo . "/" . $artist_seo;
                                $url_gen2    =    SERVER_ROOTPATH . get_user_detail($USER_NAME) . "/profile/" . $artist_seo . "/review-albums";
                            } else {
                                $url_gen    =    SERVER_ROOTPATH . $artist_seo . "/review-songs/" . $album_seo;
                                $url_gen2    =    SERVER_ROOTPATH . $artist_seo . "/review-albums";
                            }


                    ?>

                            <?php if ($mobile_view == 0) { ?>
                                <li>
                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                            <span class="list_no"><?php if (strlen($sr_no) == 1) {
                                                                        echo "0";
                                                                    } else {
                                                                    }; ?><?php echo $sr_no; ?></span>
                                        </div>
                                        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                            <div class="album_cover">
                                                <?php

                                                if ($album_picture != "") {

                                                    $img_api_linka = album_img_api($album_picture);
                                                    if ($img_api_linka != '') {
                                                ?>
                                                        <a href="<?php echo $url_gen; ?>"><img src="<?php echo $img_api_linka; ?>" border="0" width="100" /></a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo $url_gen; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="100" /></a>
                                                    <?php
                                                    }
                                                } else
													if ($req_artist['album_array']['image4'] != "") {
                                                    ?>
                                                    <a href="<?php echo $url_gen; ?>"><img src="<?php echo $req_artist['album_array']['image4']; ?>" border="0" width="100" /></a>
                                                <?php
                                                } else {
                                                ?>
                                                    <a href="<?php echo $url_gen; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="100" /></a>
                                                <?php
                                                }

                                                if ($all_avg < 10) {
                                                    $avg_total = number_format($all_avg, 1);
                                                } else {
                                                    echo $avg_total;
                                                }

                                                ?>

                                                <cite class="score_big mt-10" style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {

                                                                                                                                        echo $avg_total;
                                                                                                                                    } else {
                                                                                                                                        echo $all_avg;
                                                                                                                                    } ?></cite>
                                            </div>
                                            <div class="album_details" style="margin-top:-3px; width:63%;">
                                                <label class="title one_line"><a href="<?php echo $url_gen; ?>"><?php


                                                                                                                echo substr($album_title, 0, 36); ?></a></label>



                                                <label class="author col-lg-7 col-md-7 col-sm-7 pad_left" style="vertical-align:top; margin-top:4px;"><a href="<?php echo $url_gen2; ?>"><?php echo $artist_name; ?></a>

                                                    <br>
                                                    <!-- <p style="margin-top:10px; font-weight:normal"><?php echo $years; ?></p>-->
                                                </label>

                                                <label class="likes col-lg-5 col-md-5 col-sm-5" style="margin-top:-4px;">
                                                    <?php
                                                    if ($user_id != "") {

                                                        $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$album_artist_id'";
                                                        $counter = array();
                                                        $counter = \App\Models\Songs::GetRawData($qry);
                                                        if ($counter) {
                                                            $counter = count($counter);
                                                        } else {
                                                            $counter = 0;
                                                        }
                                                        if ($counter == 0) {
                                                    ?>
                                                            <span style="overflow:visible;" id="other_dis_sub_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>
                                                            <span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $album_artist_id; ?>"></span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span style="overflow:visible;" id="other_dis_sub_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart heart_color heart_size"></i> </a><span><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                                            <span style="overflow:visible;" id="myStyle_sub_<?php echo $album_artist_id; ?>"></span>
                                                        <?php
                                                        }
                                                    } else { ?>
                                                        <span style="overflow:visible; display:none;" id="other_dis_sub_<?php echo $album_artist_id; ?>">
                                                            <?php
                                                            if ($user_id == "") {
                                                            ?>
                                                                <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a>
                                                            <?php
                                                            }
                                                            ?>
                                                            <span><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                        <span style="overflow:visible;" id="myStyle_sub_<?php echo $k; ?>"></span>
                                                    <?php
                                                    }
                                                    ?>


                                                </label>
                                            </div>

                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12 artist_type red-text">
                                            <?php
                                            $all_user_avg = $aaa;
                                            if ($all_user_avg != 0) {
                                            ?><cite class="score_big mt-10" style="background-color:<?php echo $color_pick_user; ?>; color:#FFFFFF; padding:8px;"><?php if ($all_user_avg < 10) {
                                                                                                                                                                        echo number_format($all_user_avg, 1);
                                                                                                                                                                        $last_value = number_format($all_user_avg, 1);
                                                                                                                                                                    } else {
                                                                                                                                                                        echo $all_user_avg;
                                                                                                                                                                        $last_value = $all_user_avg;
                                                                                                                                                                    } ?></cite><?php
                                                                                                                                                                            } else { ?> <cite style="background-color:#e06d21; color:#FFFFFF; padding:8px;"><?php echo $last_value; ?></cite><?php } ?>
                                        </div>
                                    </div>
                                </li>

                            <?php
                            } elseif ($mobile_view == 1) { ?>
                                <li>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pad_zero">
                                                <div class="album_cover">
                                                    <?php
                                                    if ($album_picture != "") {

                                                        $img_api_linka = album_img_api($album_picture);
                                                        if ($img_api_linka != '') {
                                                    ?>
                                                            <a href="<?php echo $url_gen; ?>"><img src="<?php echo $img_api_linka; ?>" border="0" style="width:100px; height:100px;" /></a>
                                                        <?php } else { ?>
                                                            <a href="<?php echo $url_gen; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" style="width:100px; height:100px;" /></a>
                                                        <?php
                                                        }
                                                    } else
													if ($req_artist['album_array']['image4'] != "") {
                                                        ?>
                                                        <a href="<?php echo $url_gen; ?>"><img src="<?php echo $req_artist['album_array']['image4']; ?>" border="0" style="width:100px; height:100px;" /></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a href="<?php echo $url_gen; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" style="width:100px; height:100px;" /></a>
                                                    <?php
                                                    }



                                                    if ($all_avg < 10) {
                                                        $avg_total = number_format($all_avg, 1);
                                                    } else {
                                                        $all_avg = $all_avg;
                                                    }
                                                    ?>
                                                    <cite class="score_big mt-10" style="background-color:<?php echo $color_pick; ?>"><?php if ($avg_total < 10) {
                                                                                                                                            echo number_format($avg_total, 1);
                                                                                                                                        } else {
                                                                                                                                            echo $avg_total;
                                                                                                                                        } ?></cite>
                                                    <div style="position:absolute; z-index:10; margin-left:82%; color:#FFFFFF; margin-top:-20px;" class="review_screen_txt"><?php echo $sr_no; ?></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 pad_zero">
                                                <div class="album_details" style="display:block; margin-top:-3px;">
                                                    <label class="title one_line"><a href="<?php echo $url_gen; ?>"><?php echo substr($album_title, 0, 26); ?></a></label>
                                                    <label class="author mrg_btm">
                                                        <!--<a href="<?php echo SERVER_ROOTPATH . get_user_detail($USER_NAME) . "/" . $artist_seo . "/review-albums"; ?>">--><a href="<?php echo $url_gen2; ?>"><?php echo $artist_name; ?></a>
                                                    </label>
                                                    <p><label class="likes" style="float:left; height:26px; margin-left:0; padding-left:0;">
                                                            <?php
                                                            if ($user_id != "") {

                                                                $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$album_artist_id'";
                                                                $counter = array();
                                                                $counter = \App\Models\Songs::GetRawData($qry);
                                                                if ($counter) {
                                                                    $counter = count($counter);
                                                                } else {
                                                                    $counter = 0;
                                                                }
                                                                if ($counter == 0) {
                                                            ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                                    <span style="overflow:visible;" id="myStyle_sub_<?php echo $album_artist_id; ?>"></span>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart heart_color heart_size"></i> </a><span><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                                    <span style="overflow:visible;" id="myStyle_sub_<?php echo $album_artist_id; ?>"></span>
                                                                <?php
                                                                }
                                                            } else { ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $album_artist_id; ?>">
                                                                    <?php
                                                                    if ($user_id == "") {
                                                                    ?>
                                                                        <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <span><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                                                <span style="overflow:visible;" id="myStyle_sub_<?php echo $k; ?>"></span>
                                                            <?php
                                                            }
                                                            ?></label>
                                                        <?php
                                                        $all_user_avg = $aaa;
                                                        if ($all_user_avg != 0) {


                                                        ?><cite class="score_big mt-10 pad_8" style="background-color:<?php echo $color_pick_user; ?>; float:right;"><?php if ($all_user_avg < 10) {
                                                                                                                                                                            echo number_format($all_user_avg, 1);
                                                                                                                                                                            $last_value = number_format($all_user_avg, 1);
                                                                                                                                                                        } else {
                                                                                                                                                                            echo $all_user_avg;
                                                                                                                                                                            $last_value = $all_user_avg;
                                                                                                                                                                        } ?></cite><?php } else { ?>
                                                            <cite class="score_big mt-10" style="background-color:#e06d21; float:right; padding:8px;"><?php echo $last_value; ?></cite>

                                                            <!--<cite class="score_big mt-10 pad_8" style="background-color:#e06d21;">5.0</cite>--><?php } ?>
                                                    </p>
                                                    <div style="clear:both;"></div>
                                                    <!-- <p>&nbsp;<?php echo $years; ?></p>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            <?php } ?>
                    <?php

                            $k++;
                        }
                    }

                    $kval = $k;

                    ?>
                </ul>
            </div>
            <?php if ($total_pages > $limit) { ?>
                <div class="page-navigation">
                    <ul>
                        include("common.paging-playlist")
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
    <?php } ?>
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
<!-- ./Middle Section -->
@include("common.signin_modal")
<?php
//include("include/thankyou_messages.php");


?>
<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<div class="modal fade" id="#profile_Modal2_99999999" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<style>
    body {
        overflow-x: hidden;
    }
</style>
@include("common.footer")