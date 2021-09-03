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
            <h1 class="bnr_heading">Top <span>50</span> Albums</h1>
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
        <div class="container" style="padding:0;">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <ul class="songlistings">
                        <?php
                        //============================================================
                        //PAGGING CODE STARTS HERE


                        $artist_list_arr = array();
                        if (empty($artist_list_arr)) {
                            $artist_list = "select b.album_seo, b.album_artist_id,b.updated_by_itunes, a.artist_seo,a.artist_name,b.album_title, b.album_picture, b.id, a.artist_seo from tbl_artist_album b, tbl_artists a where 1=1 AND b.album_status = 1  AND a.id = b.album_artist_id AND b.ranking_order!=0 order by b.ranking_order asc limit 50";
                            // $artist_list_arr	=	$db->get_results($artist_list, ARRAY_A);
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

                                $id                 = $val['id'];
                                $album_title     = stripslashes(html_entity_decode($val['album_title']));
                                $artist_name     = stripslashes(html_entity_decode($val['artist_name']));
                                $album_picture   = stripslashes(html_entity_decode($val['album_picture']));
                                $album_artist_id = stripslashes(html_entity_decode($val['album_artist_id']));
                                $artist_seo = strtolower(stripslashes(html_entity_decode($val['artist_seo'])));
                                $album_seo  = strtolower(stripslashes(html_entity_decode($val['album_seo'])));
                                $album_title = wordwrap($album_title, 100, " ", true);
                                $artist_name = wordwrap($artist_name, 100, " ", true);

                                if ($album_picture == '' &&  $val['updated_by_itunes'] == '0000-00-00 00:00:00') {

                                    $req_artist  =  artist_album_func("$artist_name", stripslashes(html_entity_decode($val['album_title'])));
                                }


                                // $counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'artist' AND like_id = '$album_artist_id'"));
                                $counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'artist' AND like_id = '$album_artist_id'");
                                if ($counter_main) {
                                    $counter_main = count($counter_main);
                                } else {
                                    $counter_main = 0;
                                }

                                // $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where album_id = $id AND status = 1";
                                // $rate_arr    =    $db->get_row($sum_rating, ARRAY_A);

                                // $sum_rate = $rate_arr['sum_rate'];
                                // $counter = $rate_arr['counter'];

                                // if ($sum_rate == "" || $sum_rate == 0) {
                                //     $sum_rate = 0;
                                // }

                                //$all_avg  =  $sum_rate / $counter;
                               
                                $rating_avg = calculate_rating_main($id, $album_artist_id, $album_seo);
                                echo 'wait';
                                die;
                                $all_avg  =  $rating_avg;

                                if ($all_avg == "") {
                                    $all_avg = 0;
                                }

                                if ($all_avg >= 8) {
                                    $color_pick = "#5cb85c";
                                }

                                if ($all_avg >= 6 && $all_avg < 8) {
                                    $color_pick = "#5cb85c";
                                }

                                if ($all_avg >= 4 && $all_avg < 6) {
                                    $color_pick = "#e06d21";
                                }

                                if ($all_avg >= 2 && $all_avg < 4) {
                                    $color_pick = "#d9534f";
                                }

                                if ($all_avg > 0 && $all_avg < 2) {
                                    $color_pick = "#d9534f";
                                }

                                if ($all_avg >= 7) {
                                    $color_pick = "#5ebd5e";
                                } elseif ($all_avg >= 4 && $all_avg <= 6.9) {
                                    $color_pick = "#e06d21";
                                } elseif ($all_avg >= 0 && $all_avg <= 3.9) {
                                    $color_pick = "#dd554e";
                                }

                                $c++;
                                $sr_no++;
                        ?>
                                <li>
                                    <?php if ($mobile_view == 0) { ?>
                                        <div class="row">
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                <span class="list_no"><?php if (strlen($sr_no) == 1) {
                                                                            echo "0";
                                                                        } else {
                                                                        }; ?><?php echo $sr_no; ?></span>
                                            </div>
                                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
                                                <div class="album_cover">
                                                    <!--<img src="images/slideimg1.png">-->
                                                    <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-album-" . $album_seo; ?>" class="text_grey"><?php
                                                                                                                                                        if ($album_picture != "") {
                                                                                                                                                            $img_api_link = album_img_api($album_picture);
                                                                                                                                                            if ($img_api_link != '') {
                                                                                                                                                        ?>
                                                                <img src="<?php echo $img_api_link; ?>" border="0" width="120" />
                                                            <?php } else {  ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="120" />
                                                            <?php
                                                                                                                                                            }
                                                                                                                                                        } else
													if ($album_picture == "") {

                                                                                                                                                            if ($req_artist['album_array']['image4'] != "") {
                                                            ?>
                                                                <img src="<?php echo img_api_link($req_artist['album_array']['image4']); ?>" border="0" width="120" />
                                                            <?php
                                                                                                                                                            } else {
                                                            ?>
                                                                <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="120" />
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
                                                                                                                } ?></cite><?php } else { ?>
                                                        <cite style="background-color:<?php echo $color_pick; ?>">0.0</cite>
                                                    <?php } ?>
                                                </div>
                                                <div class="album_details">
                                                    <label class="title"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-album-" . $album_seo; ?>"><?php echo substr($album_title, 0, 50);
                                                                                                                                                            if (strlen($album_title) > 50) {
                                                                                                                                                                echo "...";
                                                                                                                                                            } ?></a></label>
                                                    <label class="author"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><?php echo substr($artist_name, 0, 30);
                                                                                                                                                    if (strlen($artist_name) > 30) {
                                                                                                                                                        echo "...";
                                                                                                                                                    } ?></a></label>
                                                    <!--<label class="author"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . '-artist-songs'; ?>" class="display_width_inner"><h4 style="margin-top:-10px;"><?php echo $artist_name; ?></h4></a></label>
                                            -->
                                                    <label class="likes" style="height:26px; margin-top:-7px; vertical-align: middle;">
                                                        <?php
                                                        if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] != "") {
                                                            $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$album_artist_id'"));
                                                            if ($counter == 0) {
                                                        ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i> </a><span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                                <span style="overflow:visible;" id="myStyle_sub_<?php echo $album_artist_id; ?>"></span>
                                                            <?php
                                                            } else { ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="like link-disable"><i class="fa fa-heart heart_color heart_size"></i></a> <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
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
                                                                if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                                                                ?>
                                                                    <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_size heart_color"></i></i></a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                            <span style="overflow:visible;" id="myStyle_sub_<?php echo $album_artist_id; ?>"></span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </label>
                                                </div>
                                                <!--<button>Write a review</button>-->
                                            </div>
                                        </div>
                                    <?php } elseif ($mobile_view == 1) { ?>
                                        <div class="row">
                                            <!--<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                    <span class="list_no"><?php if (strlen($sr_no) == 1) {
                                                                echo "0";
                                                            } else {
                                                            }; ?><?php echo $sr_no; ?></span>
 									</div>-->
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-3" style="padding:0px !important;">
                                                    <div class="album_cover">
                                                        <!--<img src="images/slideimg1.png">-->
                                                        <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-album-" . $album_seo; ?>" class="text_grey"><?php
                                                                                                                                                            if ($album_picture != "") {
                                                                                                                                                                $img_api_link = album_img_api($album_picture);
                                                                                                                                                                if ($img_api_link != '') {
                                                                                                                                                            ?>
                                                                    <img src="<?php echo $album_picture; ?>" border="0" width="120" />
                                                                <?php } else {  ?>
                                                                    <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/album_images/<?php echo 'thumb_' . $album_picture; ?>" border="0" width="120" />
                                                                <?php
                                                                                                                                                                }
                                                                                                                                                            } else
													if ($album_picture == "") {

                                                                                                                                                                if ($req_artist['album_array']['image4'] != "") {
                                                                ?>
                                                                    <img src="<?php echo $req_artist['album_array']['image4']; ?>" border="0" width="120" />
                                                                <?php
                                                                                                                                                                } else {
                                                                ?>
                                                                    <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="120" />
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
                                                                                                                    } ?></cite><?php } else { ?>
                                                            <cite style="background-color:<?php echo $color_pick; ?>">0.0</cite>
                                                        <?php } ?>
                                                        <div style="position:inherit; z-index:10; float:right; color:#FFFFFF; margin-top:-20px; margin-right:3px;"><?php echo $sr_no; ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-9" style="padding:0px !important;">
                                                    <div class="album_details">
                                                        <label class="title"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-album-" . $album_seo; ?>"><?php echo substr($album_title, 0, 50);
                                                                                                                                                                if (strlen($album_title) > 50) {
                                                                                                                                                                    echo "...";
                                                                                                                                                                } ?></a></label>
                                                        <label class="author"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "-artist-songs"; ?>"><?php echo substr($artist_name, 0, 30);
                                                                                                                                                        if (strlen($artist_name) > 30) {
                                                                                                                                                            echo "...";
                                                                                                                                                        } ?></a></label>
                                                        <!--<label class="author"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . '-artist-songs'; ?>" class="display_width_inner"><h4 style="margin-top:-10px;"><?php echo $artist_name; ?></h4></a></label>
                                            -->
                                                        <div style="clear:both;"></div>
                                                        <label class="likes" style="float:left; height:26px; margin-left:0px; padding-left:0px;">
                                                            <?php
                                                            if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] != "") {
                                                                $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$album_artist_id'"));
                                                                if ($counter == 0) {
                                                            ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i> </a><span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                                    <span style="overflow:visible;" id="myStyle_sub_<?php echo $album_artist_id; ?>"></span>
                                                                <?php
                                                                } else { ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="like link-disable"><i class="fa fa-heart heart_color heart_size"></i></a> <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
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
                                                                    if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                                                                    ?>
                                                                        <a href="#" data-toggle="modal" data-target="#signin_form" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i></i></a>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                                                <span style="overflow:visible;" id="myStyle_sub_<?php echo $album_artist_id; ?>"></span>
                                                            <?php
                                                            }
                                                            ?>
                                                        </label>
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
                <?php 
                //include("include/album_reviews_sidebar.php"); ?>
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
<!-- ./Middle Section -->
<style>
    body {
        overflow-x: hidden !important;
    }

    @media (max-width: 350px) {
        .banner.topsongbanner {
            background: rgba(0, 0, 0, 0) url("images/banner_topsongs_mobile.png") no-repeat scroll 0 0 / cover !important;
            height: 236px;
        }
    }

    @media (max-width: 465px) {
        .banner.topsongbanner {
            background: rgba(0, 0, 0, 0) url("images/banner_topsongs_mobile.png") no-repeat scroll 0 0 / cover !important;
            height: 236px;
        }
    }

    @media (max-width: 640px) {
        .banner.topsongbanner {
            background: rgba(0, 0, 0, 0) url("images/banner_topsongs_mobile.png") no-repeat scroll 0 0 / cover !important;
            height: 236px;
        }
    }
</style>


<?php
// include("common/signin_modal.php");
// include_once("common/popular_review.php");
?>
<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
@include("common.footer")