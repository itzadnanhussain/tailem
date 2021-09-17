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
                <form action="<?php echo SERVER_ROOTPATH; ?>searcher-results-album" method="post">
                    <div class="form-group">
                        @csrf
                        <label for="search" onClick="unset_all()" style="cursor:pointer;">All</label>
                        <input type="text" class="form-control" value="<?php echo stripslashes(session()->get('main_search')); ?>" placeholder="Search for a Album" id="search" name="search" required>
                        <!--<button type="submit" type="submit" name="submit_ba" id="submit_ba" class="btn">Submit</button>-->
                        <button class="btn" type="submit" value="Search" name="submitbtn"><i class="sprite-new sprite-new-xsearch-icon-png-pagespeed-ic-XjnYgjYQAr"></i></button>
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
                                    <a href="<?php echo SERVER_ROOTPATH; ?>searcher-results-artist">ARTISTS</a> |
                                    <a class="active" href="<?php echo SERVER_ROOTPATH; ?>searcher-results-album">ALBUMS</a>
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
                        <div class="row">
                            <?php
                            $artist_list_arr = array();
                            $temp = explode(" ", trim($srch_search_sess));
                            $first_word = $temp[0];

                            if (empty($artist_list_arr)) {
                                //$artist_list="select b.album_seo, b.album_artist_id, a.artist_seo,a.artist_name,b.album_title, b.album_picture, b.id, a.artist_seo from tbl_artist_album b, tbl_artists a where 1=1 AND b.album_status = 1  AND a.id = b.album_artist_id AND ( MATCH (b.album_title) AGAINST ('$srch_search_sess*' IN BOOLEAN MODE)) AND  (CONCAT(b.album_title) LIKE '%$srch_search_sess%') group by b.album_title order by  b.album_title = '$srch_search_sess' desc,b.album_title = '$first_word'  desc limit 50";	

                                $artist_list = "select * FROM   tbl_artist_album  where 1=1 AND album_title LIKE '%$srch_search_sess%' AND  (CONCAT(album_title) LIKE '%$srch_search_sess%') group by album_title order by album_title = '$srch_search_sess' desc, album_title = '$first_word' desc limit 50";

                                $artist_list_arr = \App\Models\Songs::GetRawData($artist_list);

                                if ($artist_list_arr) {
                                    $album_count  = count($artist_list_arr);
                                } else {
                                    $album_count  = 0;
                                }
                            }

                            $total_pages =   $album_count;
                            ?>
                            <div class="col-xs-6">
                                <ul class="list-inline">
                                    <li>ALBUMS <span class="active">(<?php echo $album_count; ?>)</span></li>
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


                        $targetpage = SERVER_ROOTPATH . 'searcher-albumlist'; //your file name  (the name of this file)



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
                            $k_album = 1;
                            foreach ($artist_list_arr as $val) {
                                $val = (array)$val;

                                $id      = $val['id'];
                                $album_title1 = $val['album_title'];
                                $album_title = stripslashes(html_entity_decode($val['album_title']));
                                $artist_name = stripslashes(html_entity_decode($val['artist_name']));
                                $album_picture   = stripslashes(html_entity_decode($val['album_picture']));
                                $album_artist_id = stripslashes(html_entity_decode($val['album_artist_id']));
                                $artist_data = GetArtistByAlbumId($id); 
                                $artist_seo = strtolower($artist_data['artist_seo']);
                                // $db_art_id      = $artist_data['id'];
                               
                                $album_seo  = strtolower(stripslashes(html_entity_decode($val['album_seo'])));
                                $db_album_title = $album_title1;
                                $album_title = wordwrap($album_title, 100, " ", true);
                                $artist_name = wordwrap($artist_name, 100, " ", true);

                                //	$req_artist  =  artist_album_func("$artist_name",stripslashes(html_entity_decode($val['album_title'])));

                                $qry = "select id from tbl_likes where like_type = 'artist' AND like_id = '$album_artist_id'";
                                $counter_main = array();
                                $counter_main = \App\Models\Songs::GetRawData($qry);
                                if ($counter_main) {
                                    $counter_main = count($counter_main);
                                } else {
                                    $counter_main = 0;
                                }


                                // $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where album_id = $id AND status = 1";
                                // $rate_arr    =    $db->get_row($sum_rating, ARRAY_A);



                                //$all_avg  =  $sum_rate / $counter;
                                $rating_avg = calculate_rating_main($id, $album_artist_id, $album_seo);
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
                                }
                                if ($all_avg >= 4 && $all_avg <= 6.9) {
                                    $color_pick = "#e06d21";
                                }
                                if ($all_avg >= 0 && $all_avg <= 3.9) {
                                    $color_pick = "#dd554e";
                                }


                                $c++;
                                $sr_no++;


                                $songs_list = "select a.artist_seo,a.artist_name from  tbl_artist_album b,tbl_songs_artist_album saa, tbl_artists a where 1=1 AND saa.album_id = b.id   AND b.album_title = '" . $db_album_title . "' AND a.id = saa.artist_id AND saa.display_status = 1";

                                $various = \App\Models\Songs::GetRawData($songs_list);
                                $various['artist_seo'] = strtolower($various[0]->artist_seo);
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
                                                    <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>" class="text_grey"><?php
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
                                                                                                                                                            $req_artist  =  artist_album_func("$artist_name", stripslashes(html_entity_decode($val['album_title'])));
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


                                                    <?php
                                                    if ($all_avg != 0) {
                                                    ?><cite style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                    echo number_format($all_avg, 1);
                                                                                                                } else {
                                                                                                                    echo $all_avg;
                                                                                                                } ?></cite><?php } else { ?>
                                                        <cite style="background-color:#dd554e">0.0</cite>
                                                    <?php } ?>
                                                </div>
                                                <div class="album_details" style="margin-top:0; padding: 2% 0 0 4%;">
                                                    <label class="title review_screen_txt " style="margin-bottom:5px;"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><?php echo substr($album_title, 0, 50);
                                                                                                                                                                                                        if (strlen($album_title) > 50) {
                                                                                                                                                                                                            echo "...";
                                                                                                                                                                                                        } ?></a></label>
                                                    <label class="review_ipad_txt title" style="margin-bottom:5px;"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><?php echo substr($album_title, 0, 20);
                                                                                                                                                                                                    if (strlen($album_title) > 20) {
                                                                                                                                                                                                        echo "...";
                                                                                                                                                                                                    } ?></a></label>
                                                    <div style="clear:both;"></div>
                                                    <div>
                                                        <label class="author" style="width:215px; float:left;">
                                                            <?php


                                                            if ($various) {

                                                            ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . $various['artist_seo'] . "/artist-songs"; ?>"><?php echo substr($various['artist_name'], 0, 25);
                                                                                                                                                    if (strlen($various['artist_name']) > 25) {
                                                                                                                                                        echo "...";
                                                                                                                                                    } ?></a>
                                                            <?php
                                                            } else {
                                                            ?> <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 20);
                                                                                                                                        if (strlen($artist_name) > 20) {
                                                                                                                                            echo "...";
                                                                                                                                        } ?></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </label>
                                                        <label class="likes">
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
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_album; ?>')" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i> </a><span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>
                                                                    <span style="overflow:visible;" id="myStyle_sub_<?php echo $album_artist_id; ?>"></span>

                                                                <?php
                                                                } else { ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_album; ?>')" class="like link-disable"><i class="fa fa-heart heart_color heart_size"></i></a> <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
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
                                                                        <a href="#" data-toggle="modal" data-target="#signin_form" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i></a>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_album; ?>')" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                                                <span style="overflow:visible;" id="myStyle_sub_<?php echo $album_artist_id; ?>"></span>
                                                            <?php
                                                            } ?>
                                                        </label>
                                                    </div>
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
                                                        <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>" class="text_grey"><?php
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
                                                                                                                                                                $req_artist  =  artist_album_func("$artist_name", stripslashes(html_entity_decode($val['album_title'])));
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


                                                        <?php
                                                        if ($all_avg != 0) {
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
                                                        <label class="title"><a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/album/" . $album_seo; ?>"><?php echo substr($album_title, 0, 25);
                                                                                                                                                                if (strlen($album_title) > 25) {
                                                                                                                                                                    echo "...";
                                                                                                                                                                } ?></a></label>
                                                        <label class="author">
                                                            <?php
                                                            if ($various) {
                                                            ?>
                                                                <a href="<?php echo SERVER_ROOTPATH . $various['artist_seo'] . "/artist-songs"; ?>"><?php echo substr($various['artist_name'], 0, 20);
                                                                                                                                                    if (strlen($various['artist_name']) > 20) {
                                                                                                                                                        echo "...";
                                                                                                                                                    } ?></a>
                                                            <?php
                                                            } else {
                                                            ?> <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><?php echo substr($artist_name, 0, 20);
                                                                                                                                        if (strlen($artist_name) > 20) {
                                                                                                                                            echo "...";
                                                                                                                                        } ?></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </label>
                                                        <div style="clear:both;"></div>
                                                        <label class="likes" style="float:left !important; height:26px;">
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
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_album; ?>')" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i> </a><span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>
                                                                    <span style="overflow:visible;" id="myStyle_sub_<?php echo $album_artist_id; ?>"></span>

                                                                <?php
                                                                } else { ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $album_artist_id; ?>"><a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_album; ?>')" class="like link-disable"><i class="fa fa-heart heart_color heart_size"></i></a> <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
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
                                                                        <a href="#" data-toggle="modal" data-target="#signin_form" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i></a>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $album_artist_id; ?>','<?php echo $artist_seo; ?>','<?php echo $k_album; ?>')" class="text_grey"><i class="fa fa-heart-o heart_size heart_color"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <span class="text_red"><?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                                                <span style="overflow:visible;" id="myStyle_sub_<?php echo $album_artist_id; ?>"></span>
                                                            <?php
                                                            } ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </li>
                            <?php
                                $k_album++;
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

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo SERVER_ROOTPATH; ?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
    var jq = jQuery.noConflict();

    jq().ready(function() {
        jq("#search_text").autocomplete("<?php echo SERVER_ROOTPATH; ?>get_item.php", {
            width: 300,
            matchContains: true,

            selectFirst: false
        });
    });
</script>

<script type="text/javascript" src="<?php echo SERVER_ROOTPATH; ?>js/bootstrap.js"></script>
</body>

</html>
<script>
    jQuery('h3').each(function() {

        var h3 = $(this);

        h3.html(
            h3.text().replace(
                '<?php echo  session()->get('main_search'); ?>',
                '<span class="myClass"><?php echo session()->get('main_search'); ?></span>'
            )
        );
    });
</script>

<script type="text/javascript">
    function unset_all() {
        $.ajax({
            type: "POST",
            url: 'process/destroysession.php',
            data: 'sure=1',
            success: function(msg) {
                if (msg.search('done') != -1) {
                    window.location.href = 'searcher-results-album';
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