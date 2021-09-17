@include("common.header")
<?php
error_reporting(0);
$srch_search_sess   =  session()->get('main_search');
$srch_sess          =  session()->get('main_result');
$srch_sess_song     =  session()->get('main_result_song');
$srch_sess_album      =  session()->get('main_result_album');

if ($srch_search_sess == "") {

    $srch_search_sess = "Alonzo Pennington";
}
?>
<!-- Middle Section -->
<section class="middle_sec">
    <div class="banner">
        <div class="banner_body">
            <h1 class="bnr_heading">Search results</h1>
            <div class="banner-search">
                <form action="<?php echo SERVER_ROOTPATH; ?>searcher-results-artist" method="post">
                    <div class="form-group">
                        @csrf
                        <label for="search" onClick="unset_all()" style="cursor:pointer;">All</label>
                        <input type="text" class="form-control" value="<?php echo session()->get('main_search'); ?>" id="search" name="search" placeholder="Search for an Artist" required>
                        <!--<button type="submit" type="submit" name="submit_ba" id="submit_ba" class="btn">Submit</button>-->

                        <button name="submitbtn" value="Search" type="submit" class="btn"><i class="sprite-new sprite-new-xsearch-icon-png-pagespeed-ic-XjnYgjYQAr"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="topsonglistsec" style="padding:0;">
        <div class="container" style="padding:0;">

            <!-- Advertisement Banner Start-->
            <div class="container" style="padding:20px 0 10px 0;">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-0 col-xs-0 review_screen_txt">&nbsp;</div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="text-align:center;">
                        <?php echo ads_info('Top'); ?>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-0 col-xs-0 review_screen_txt">&nbsp;</div>
                </div>
            </div>
            <!--Advertisement Banner End-->

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0;">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="brows-label-penel" style="background-color:#FFFFFF;">
                            <ul class="list-inline">
                                <li>
                                    <a href="<?php echo SERVER_ROOTPATH; ?>searcher">ALL RESULTS</a> |
                                    <a href="<?php echo SERVER_ROOTPATH; ?>searcher-results-song">SONGS</a> |
                                    <a class="active" href="<?php echo SERVER_ROOTPATH; ?>searcher-results-artist">ARTISTS</a> |
                                    <a href="<?php echo SERVER_ROOTPATH; ?>searcher-results-album">ALBUMS</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <div class="brows-label-penel search_bread_crumb">
                        <?php
                        if ($srch_search_sess != '') {
                            $orderby = "CASE 
												   WHEN artist_name LIKE '" . $srch_search_sess . "' THEN 1 
												   WHEN artist_name LIKE '" . $srch_search_sess . "%' THEN 2 
												   ELSE 3 
												   END, CHAR_LENGTH(artist_name)";
                        }
                        $artist_list_arr = array();

                        if (empty($artist_list_arr)) {


                            $artist_list = "select * FROM   tbl_artists  where 1=1 $srch_sess order by $orderby limit 50";

                            $artist_list_arr = \App\Models\Songs::GetRawData($artist_list);

                            if ($artist_list_arr) {
                                $artist_count  = count($artist_list_arr);
                            } else {
                                $artist_count  = 0;
                            }
                        }

                        $total_pages = $artist_count;



                        ?>
                        <div class="row">
                            <div class="col-xs-6">
                                <ul class="list-inline">
                                    <li>ARTISTS <span class="active">(<?php echo $artist_count; ?>)</span></li>
                                </ul>
                            </div>
                            <div class="col-xs-6 search_see_all">
                                <ul class="list-inline">
                                    <li>
                                        <!--<a class="active">See All</a>-->
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <ul class="songlistings">
                        <?php

                        $targetpage = SERVER_ROOTPATH . 'searcher-artistlist'; //your file name  (the name of this file)



                        $limit = 10;                     //how many items to show per page

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
                            $k_artist = 1;
                            foreach ($artist_list_arr as $val) {
                                $val = (array)$val;
                                $id      = $val['id'];
                                $artist_name = stripslashes(html_entity_decode($val['artist_name']));
                                $artist_seo = strtolower(stripslashes(html_entity_decode($val['artist_seo'])));
                                $artist_img   = stripslashes(html_entity_decode($val['artist_img']));
                                if ($artist_img == '' &&  $val['updated_by_itunes'] == '0000-00-00 00:00:00') {
                                    $req_artist  =  artist_func(urlencode("$artist_name"));
                                }
                                $cat_name   = stripslashes(html_entity_decode($val['cat_name']));
                                $cat_seo_name   = strtolower(stripslashes(html_entity_decode($val['cat_seo_name'])));


                                $artist_name = wordwrap($artist_name, 100, " ", true);

                                $qry = "select id from tbl_likes where like_type = 'artist' AND like_id = '$id'";
                                $counter_main = array();
                                $counter_main = \App\Models\Songs::GetRawData($qry);
                                if ($counter_main) {
                                    $counter_main = count($counter_main);
                                } else {
                                    $counter_main = 0;
                                }
                                if ($c % 2 == 0) {
                                    $bgcolor = "#FEFEE4";
                                } else {
                                    $bgcolor = "#FFFFFF";
                                }
                                $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where artist_id = $id AND status = 1";


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
                                }
                                if ($all_avg >= 4 && $all_avg <= 6.9) {
                                    $color_pick = "#e06d21";
                                }
                                if ($all_avg >= 0 && $all_avg <= 3.9) {
                                    $color_pick = "#dd554e";
                                }

                                $c++;
                                $sr_no++;
                                //	$req_artist  =  artist_func(urlencode("$artist_name"));
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
                                                    <?php
                                                    if ($artist_img != "") {
                                                        $img_api_linka = album_img_api($artist_img);
                                                        if ($img_api_linka != '') { ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><img src="<?php echo get_small_thumb($artist_img); ?>" border="0" title="<?php echo $artist_name; ?>" /></a>
                                                        <?php } else { ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo '' . $artist_img; ?>" border="0" title="<?php echo $artist_name; ?>" /></a>
                                                        <?php
                                                        }
                                                    } else
											if ($artist_img == "") {

                                                        if ($req_artist['artist_array']['image4'] != "") {
                                                        ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><img src="<?php echo get_small_thumb($req_artist['artist_array']['image4']); ?>" border="0" /></a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" title="<?php echo $artist_name; ?>" /></a>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                    <?php if ($all_avg != 0) {
                                                    ?><cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                    echo number_format($all_avg, 1);
                                                                                                                } else {
                                                                                                                    echo $all_avg;
                                                                                                                } ?></cite><?php } else { ?>
                                                        <cite style="background-color:#dd554e">0.0</cite>
                                                    <?php } ?>


                                                </div>
                                                <div class="album_details" style="margin-top:0; padding: 2% 0 0 4%;">
                                                    <label class="review_screen_txt title"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 20);
                                                                                                                                                                    if (strlen($artist_name) > 20) {
                                                                                                                                                                        echo "...";
                                                                                                                                                                    } ?></a></label>

                                                    <label class="review_ipad_txt title"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 16);
                                                                                                                                                                    if (strlen($artist_name) > 16) {
                                                                                                                                                                        echo "...";
                                                                                                                                                                    } ?></a></label>
                                                    <label class="likes">
                                                        <?php
                                                        if ($user_id != "") {
                                                            $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'artist' AND like_id = '$id'";
                                                            $counter = array();
                                                            $counter = \App\Models\Songs::GetRawData($qry);
                                                            if ($counter) {
                                                                $counter = count($counter);
                                                            } else {
                                                                $counter = 0;
                                                            }
                                                            if ($counter == 0) {
                                                        ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_artist; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>
                                                                <span style="overflow:visible;" id="myStyle_sub_<?php echo $id; ?>"></span>

                                                            <?php
                                                            } else {
                                                            ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_artist; ?>')" class="like"><i class="fa fa-heart heart_color heart_size"></i></a> <span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                                                <span style="overflow:visible;" id="myStyle_sub_<?php echo $id; ?>"></span>
                                                            <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>">
                                                                <?php
                                                                if ($user_id == "") {
                                                                ?>
                                                                    <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_artist; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                            <span style="overflow:visible;" id="myStyle_sub_<?php echo $id; ?>"></span>
                                                        <?php } ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } else if ($mobile_view == 1) { ?>
                                        <div class="row">
                                            <!--<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
 										<span class="list_no"><?php if (strlen($sr_no) == 1) {
                                                                    echo "0";
                                                                } else {
                                                                }; ?><?php echo $sr_no; ?></span>
 									</div>-->
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding:0px !important;">
                                                    <div class="album_cover">

                                                        <?php
                                                        if ($artist_img != "") {
                                                            $img_api_linka = album_img_api($artist_img);
                                                            if ($img_api_linka != '') {
                                                        ?>

                                                                <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><img src="<?php echo get_small_thumb($img_api_linka); ?>" border="0" width="120" /></a>
                                                            <?php } else { ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo 'thumb_' . $artist_img; ?>" border="0" width="120" /></a>
                                                            <?php     }
                                                        } else
													if ($req_artist) {
                                                            ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><img src="<?php echo get_small_thumb($req_artist['artist_array']['image4']); ?>" border="0" width="100" /></a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="120" /></a>
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php if ($all_avg != 0) {
                                                        ?><cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                        echo number_format($all_avg, 1);
                                                                                                                    } else {
                                                                                                                        echo $all_avg;
                                                                                                                    } ?></cite><?php } else { ?>
                                                            <cite style="background-color:#dd554e">0.0</cite>
                                                        <?php } ?>
                                                        <div style="position:inherit; z-index:10; float:right; color:#FFFFFF; margin-top:-22px; margin-right:6px;"><?php echo $sr_no; ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding:0px !important;">
                                                    <div class="album_details" style="margin-top:0;">
                                                        <label class="title"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 22);
                                                                                                                                                        if (strlen($artist_name) > 22) {
                                                                                                                                                            echo "...";
                                                                                                                                                        } ?></a></label>
                                                        <p><label class="likes">
                                                                <?php
                                                                if ($user_id != "") {
                                                                    $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  like_type = 'artist' AND like_id = '$id'";
                                                                    $counter = array();
                                                                    $counter = \App\Models\Songs::GetRawData($qry);
                                                                    if ($counter) {
                                                                        $counter = count($counter);
                                                                    } else {
                                                                        $counter = 0;
                                                                    }

                                                                    if ($counter == 0) {
                                                                ?>
                                                                        <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_artist; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                                        <span style="overflow:visible;" id="myStyle_sub_<?php echo $id; ?>"></span>

                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_artist; ?>')" class="like"><i class="fa fa-heart heart_color heart_size"></i></a> <span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                                        <span style="overflow:visible;" id="myStyle_sub_<?php echo $id; ?>"></span>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>">
                                                                        <?php
                                                                        if ($user_id == "") {
                                                                        ?>
                                                                            <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_artist; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <span> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                } ?></a></span>
                                                                    <span style="overflow:visible;" id="myStyle_sub_<?php echo $id; ?>"></span>
                                                                <?php } ?>
                                                            </label></p>
                                                        <!--  <a href="#" class="red-text">French Pop</a>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </li>

                            <?php $k_artist++;
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

                 
                @include ("common.artists_common_review")
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
<?php 
//include_once("common/popular_review.php"); ?>
<!-- ./Middle Section -->
<style type="text/css">
    body {
        overflow-x: hidden;
    }
</style>
 

@include("common.signin_modal")
 

<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<script type="text/javascript">
    function unset_all() {
        $.ajax({
            type: "POST",
            url: 'process/destroysession.php',
            data: 'sure=1',


            success: function(msg) {
                if (msg.search('done') != -1) {
                    window.location.href = 'searcher-results-artist';
                } else {
                    alert(msg);
                }
            },
            error: function() {}
        });
        /* 	location.reload(true);	*/
    }
</script>

@include("common.footer")