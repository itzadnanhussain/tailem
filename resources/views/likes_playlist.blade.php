@include("common.header")
<?php
$USER_NAME = ucfirst($user_name);
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
            <?php //include("include.latest_activities") 
            ?>
        </div>

        <div class="col-lg-4 col-md-4 ">
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
    <div class="topRwContent-panel pad_zero" style="margin-bottom:15px;">
        <div class="topsonglistsec col-lg-8 col-md-9 col-sm-9 col-xs-12 pad_zero" style="background:none;">

            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 pad_zero">
                <ul class="songlistings" <?php if ($mobile_view == 0) { ?> style=" border-right:1px solid #ccc;" <?php } ?>>

                    <?php


                    $where_condition = "";
                    $like_page = "";

                    if ($album_page == "") {
                        $like_page = $main_link . "like-playlist";
                    }
                    $artist_list_arr = array();
                    if (empty($artist_list_arr)) {


                        $artist_list = "select u.user_id, u.user_seo, u.user_name, u.profile_image, l.like_id, l.like_receive_user  from tbl_likes l, tbl_users u where u.user_id = l.like_receive_user AND l.like_from_user_id = $user_profile AND l.like_type = 'playlist'  order by l.id desc LIMIT 50";

                        $artist_list_arr = \App\Models\Songs::GetRawData($artist_list);
                        if ($artist_list_arr) {
                            $total_pages = count($artist_list_arr);
                        } else {
                            $total_pages = 0;
                        }
                    }



                    $targetpage = SERVER_ROOTPATH . $like_page; //your file name  (the name of this file)


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


                    $row_artist = array_slice($artist_list_arr, $start, 10);


                    if ($row_artist) {
                        $y = 0;
                        $p_fav = 0;
                        foreach ($row_artist as $val) {
                            $val = (array)$val;

                            $sr_no++;
                            $p_fav++;
                            $user_ids = stripslashes($val['user_id']);
                            $db_profile_image = stripslashes($val['profile_image']);
                            $db_user_name  = stripslashes($val['user_name']);
                            $user_name_get_db = stripslashes($val['user_name']);
                            $user_seo    = stripslashes($val['user_seo']);
                            $like_id        =    stripslashes($val['like_id']);
                            $like_receive_user    =    stripslashes($val['like_receive_user']);

                            $query_list =  "select * from tbl_user_playlist where id = '$like_id'";

                            $row_playlistinfo    =     \App\Models\Songs::GetRawData($query_list);




                            if ($db_profile_image != "") {
                                $prof_image = SERVER_ROOTPATH . "assets/phpthumb/phpThumb.php?src=" . SERVER_ROOTPATH . "site_upload/user_images/" . $db_profile_image . "&w=100&h=75&zc=0";
                            } else {
                                $prof_image = SERVER_ROOTPATH . "assets/phpthumb/phpThumb.php?src=" . SERVER_ROOTPATH . "assets/images/no_image4.png&w=101&h=75&zc=0";
                            }

                            $qry      =  "select u.user_name, u.profile_image from tbl_likes l, tbl_users u where u.user_id = l.like_from_user_id AND l.like_from_user_id = $user_profile AND l.like_type = 'profile'";
                            $query_likes_count = array();
                            $query_likes_count = \App\Models\Songs::GetRawData($qry);
                            if ($query_likes_count) {
                                $query_likes_count = count($query_likes_count);
                            } else {
                                $query_likes_count = 0;
                            }

                            // recent like pick query
                            $like_list_user_qry = "select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '" . $user_ids . "' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1 
										 ";

                            $like_list_arr_user    =    \App\Models\Songs::GetRawData($like_list_user_qry);

                            $qry =  "select id from tbl_likes where like_type = 'profile' AND like_id = '$user_ids'";
                            $counter_main_profile_like2 = array();
                            $counter_main_profile_like2 = \App\Models\Songs::GetRawData($qry);
                            if ($counter_main_profile_like2) {
                                $counter_main_profile_like2 = count($counter_main_profile_like2);
                            } else {
                                $counter_main_profile_like2 = 0;
                            }

                            $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $user_ids . "' order by r.review_id desc limit 1";
                            $review_list_arr_top    =   \App\Models\Songs::GetRawData($review_list_qry);


                            $like_playlist_count    =    get_playlist_like_counter($user_ids);

                            $comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_user_id = '" . $user_ids . "' order by comment_id desc limit 1";

                            $comment_list_arr    =    \App\Models\Songs::GetRawData($comment_list_qry);

                    ?>
                            <?php if ($mobile_view == 0) { ?>
                                <li style="padding:12px 15px;">
                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12" style="padding:5px;">
                                            <span class="list_no"><?php if (strlen($sr_no) == 1) {
                                                                        echo "0";
                                                                    } else {
                                                                    }; ?><?php echo $sr_no; ?></span>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 pad_zero">

                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                <div class="latestsongssec">
                                                    <div class="list_item">
                                                        <a href="<?php echo SERVER_ROOTPATH . get_user_detail($user_name_get_db) . "/profile-review-artist"; ?>"><img src="<?php echo get_small_thumb($prof_image); ?>" border="0" style="width:100%;"></a>
                                                        <div class="list_bottom likeprofileimg" style="padding:2px; width:100% !important;">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:14px; padding-right:2px;">
                                                                    <a href="<?php echo SERVER_ROOTPATH . $user_seo; ?>/profile-review-artist"><cite style="margin:2px; color:#FFFFFF;"><?php echo $user_name_get_db; ?></cite></a>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:0px; padding-right:15px;">
                                                                    <?php
                                                                    $qry =  "select id from tbl_likes where like_type = 'profile' AND like_id = '$user_ids'";
                                                                    $counter_main = array();
                                                                    $counter_main = \App\Models\Songs::GetRawData($qry);
                                                                    if ($counter_main) {
                                                                        $counter_main = count($counter_main);
                                                                    } else {
                                                                        $counter_main = 0;
                                                                    }
                                                                    if ($user_id != "") {
                                                                        $qry =  "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'profile' AND like_id = '$user_ids'";
                                                                        $counter = array();
                                                                        $counter = \App\Models\Songs::GetRawData($qry);
                                                                        if ($counter) {
                                                                            $counter = count($counter);
                                                                        } else {
                                                                            $counter = 0;
                                                                        }
                                                                        if ($counter == 0) { ?>
                                                                            <span class="like-group" style="float:right; line-height:20px !important;" id="other_dis_sub_profile_<?php echo $p_fav; ?>"><a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist_new('<?php echo $user_ids; ?>','<?php echo $p_fav; ?>','<?php echo $db_user_name; ?>')"><i class="fa fa-heart-o heart_color" style="font-size:20px; margin-top:5px;"></i> </a><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($db_user_name); ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_<?php echo $p_fav; ?>" data-title="" class="like link-disable" style="color:#FFFFFF;"> <?php echo $counter_main; ?></a></span>

                                                                            <span class="like-group" style="float:right; line-height:20px !important; display:none; margin-top:5px;" id="myStyle_sub_profile_<?php echo $p_fav; ?>"></span>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <span class="like-group" style="float:right; line-height:20px !important;" id="other_dis_sub_profile_<?php echo $p_fav; ?>"><a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist_new('<?php echo $user_ids; ?>','<?php echo $p_fav; ?>','<?php echo $db_user_name; ?>')"><i class="fa fa-heart" style="color:#d73b3b !important; font-size:20px; margin-top:5px;"></i> </a><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($db_user_name); ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_<?php echo $p_fav; ?>" data-title="" class="like link-disable" style="color:#FFFFFF;"> <?php echo $counter_main; ?></a></span>
                                                                            <span class="like-group" style="float:right; line-height:20px !important; display:none; margin-top:5px;" id="myStyle_sub_profile_<?php echo $p_fav; ?>"></span>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <span class="like-group" style="float:right; line-height:20px !important;" id="other_dis_sub_profile_<?php echo $p_fav; ?>">
                                                                            <?php
                                                                            if ($user_id == "") {
                                                                            ?>
                                                                                <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color" style="font-size:20px; margin-top:5px;"></i></a>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist_new('<?php echo $user_ids; ?>','<?php echo $p_fav; ?>','<?php echo $db_user_name; ?>')"><i class="fa fa-heart-o heart_color" style="font-size:20px; margin-top:5px;"></i></a>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            <a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($db_user_name); ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_<?php echo $p_fav; ?>" data-title="" class="like link-disable" style="color:#FFFFFF;"> <?php echo $counter_main; ?></a></span>
                                                                        <span class="like-group" style="float:right; line-height:20px !important; display:none;" id="myStyle_sub_profile_<?php echo $p_fav; ?>"></span>

                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                                <div class="album_details" style="padding-left:10px; margin-top:-10px; width:auto;">
                                                    <label class="author pad_zero" style="width:215px; float:left; margin-top:3px;"><a href="<?php echo SERVER_ROOTPATH . stripslashes($user_seo) . "/profile-playlists/" . stripslashes($row_playlistinfo['title_playlist_seo']); ?>"><?php echo stripslashes($row_playlistinfo['title_playlist']); ?> </a>
                                                        <span id="nam_<?php echo $p_fav; ?>"></span>
                                                    </label>
                                                    <label class="likes pad_zero">
                                                        <!--<span style="overflow:visible; margin-top:-10px;"><a href="#"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span> 3</span><a class="like link-disable darkgrey_rev" href="#"> Likes</a></span>-->
                                                        <?php
                                                        $qry = "select id from tbl_likes where like_type = 'playlist' AND like_id = '" . $row_playlistinfo['id'] . "'";
                                                        $counter_main_playlist = array();
                                                        $counter_main_playlist = \App\Models\Songs::GetRawData($qry);
                                                        if ($counter_main_playlist) {
                                                            $counter_main_playlist = count($counter_main_playlist);
                                                        } else {
                                                            $counter_main_playlist = 0;
                                                        }
                                                        if ($user_id != "") {
                                                            $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'playlist' AND like_id = '" . $row_playlistinfo['id'] . "'";
                                                            $counter = array();
                                                            $counter = \App\Models\Songs::GetRawData($qry);
                                                            if ($counter) {
                                                                $counter = count($counter);
                                                            } else {
                                                                $counter = 0;
                                                            }
                                                            if ($counter == 0) {
                                                        ?>
                                                                <span style="overflow:visible;" id="show_playlist_likes_<?php echo $row_playlistinfo['id']; ?>"><a href="javascript:;" onClick="add_in_playlist('<?php echo $row_playlistinfo['id']; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span><?php echo $counter_main_playlist; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail_playlist.php?artist=<?php echo $row_playlistinfo['id']; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main_playlist < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                                <span style="overflow:visible; display:none;" id="myStyle_profile_<?php echo $row_playlistinfo['id']; ?>"></span>

                                                            <?php
                                                            } else {
                                                            ?>
                                                                <span style="overflow:visible;" id="show_playlist_likes_<?php echo $row_playlistinfo['id']; ?>"><a href="javascript:;" onClick="add_in_playlist('<?php echo $row_playlistinfo['id']; ?>')"><i class="fa fa-heart heart_color heart_size"></i> </a><span><?php echo $counter_main_playlist; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail_playlist.php?artist=<?php echo $row_playlistinfo['id']; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main_playlist < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                                <span style="overflow:visible; display:none;" id="myStyle_profile_<?php echo $row_playlistinfo['id']; ?>"></span>
                                                            <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <span style="overflow:visible;" id="other_dis_sub_<?php echo $row_playlistinfo['id']; ?>">
                                                                <?php
                                                                if ($user_id == "") {
                                                                ?>
                                                                    <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a href="javascript:;" onClick="add_in_playlist('<?php echo $row_playlistinfo['id']; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <span><?php echo $counter_main_playlist; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail_playlist.php?artist=<?php echo $row_playlistinfo['id']; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main_playlist < 2) {
                                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                            <span style="overflow:visible; display:none;" id="myStyle_profile_<?php echo $row_playlistinfo['id']; ?>"></span>


                                                        <?php
                                                        }


                                                        ?>
                                                    </label>
                                                    <div class="clearfix"></div>
                                                    <div class="activity-panel">

                                                        <label class="likes darkgrey_rev"><i class="fa fa-heart-o heart_size ft_20"></i> Likes <text class="heart_color"> <?php echo $like_list_arr_user['count_likes'] + $counter_main_profile_like2 + $like_playlist_count; ?></text></label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class="likes darkgrey_rev"><img src="<?php echo SERVER_ROOTPATH; ?>images/review-book.png">Reviews <text class="heart_color"> <?php echo $review_list_arr_top['count_reviews']; ?></text></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class="likes darkgrey_rev"><img src="<?php echo SERVER_ROOTPATH; ?>images/icon_post.png">Posts <text class="heart_color"> <?php echo $comment_list_arr['count_discussion']; ?></text></label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </li>
                            <?php
                            } elseif ($mobile_view == 1) { ?>
                                <li>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pad_zero">
                                                <div class="latestsongssec">
                                                    <div class="list_item">

                                                        <a href="<?php echo SERVER_ROOTPATH . get_user_detail($user_name_get_db) . "/profile-review-artist"; ?>"><img src="<?php echo get_small_thumb($prof_image); ?>" border="0" width="100%" class="img-responsive artist-img"></a>
                                                        <div class="list_bottom" style="padding:2px;">
                                                            <div class="row">

                                                                <div class="col-lg-6" style="padding-left:2px; padding-right:16px;">
                                                                    <?php
                                                                    $qry = "select id from tbl_likes where like_type = 'profile' AND like_id = '$user_ids'";
                                                                    $counter_main = array();
                                                                    $counter_main = \App\Models\Songs::GetRawData($qry);
                                                                    if ($counter_main) {
                                                                        $counter_main = count($counter_main);
                                                                    } else {
                                                                        $counter_main = 0;
                                                                    }

                                                                    if ($user_id != "") {
                                                                        $qry =  "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'profile' AND like_id = '$user_ids'";
                                                                        $counter = array();
                                                                        $counter = \App\Models\Songs::GetRawData($qry);
                                                                        if ($counter) {
                                                                            $counter = count($counter);
                                                                        } else {
                                                                            $counter = 0;
                                                                        }
                                                                        if ($counter == 0) { ?>
                                                                            <span class="like-group" style="float:right; line-height:20px !important;" id="other_dis_sub_profile_<?php echo $p_fav; ?>"><a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist_new('<?php echo $user_ids; ?>','<?php echo $p_fav; ?>','<?php echo $db_user_name; ?>')"><i class="fa fa-heart-o heart_color" style="font-size:20px;"></i> </a><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($db_user_name); ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_<?php echo $p_fav; ?>" data-title="" class="like link-disable" style="color:#FFFFFF;"> <?php echo $counter_main; ?></a></span>

                                                                            <span class="like-group" style="float:right; line-height:20px !important; display:none;" id="myStyle_sub_profile_<?php echo $p_fav; ?>"></span>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <span class="like-group" style="float:right; line-height:20px !important;" id="other_dis_sub_profile_<?php echo $p_fav; ?>"><a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist_new('<?php echo $user_ids; ?>','<?php echo $p_fav; ?>','<?php echo $db_user_name; ?>')"><i class="fa fa-heart" style="color:#d73b3b !important; font-size:20px;"></i> </a><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($db_user_name); ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_<?php echo $p_fav; ?>" data-title="" class="like link-disable" style="color:#FFFFFF;"> <?php echo $counter_main; ?></a></span>
                                                                            <span class="like-group" style="float:right; line-height:20px !important; display:none;" id="myStyle_sub_profile_<?php echo $p_fav; ?>"></span>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <span class="like-group" style="float:right; line-height:20px !important;" id="other_dis_sub_profile_<?php echo $p_fav; ?>">
                                                                            <?php
                                                                            if ($user_id == "") {
                                                                            ?>
                                                                                <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color" style="font-size:20px;"></i></a>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <a href="javascript:;" onClick="add_in_favourite_user_profile_mainlist_new('<?php echo $user_ids; ?>','<?php echo $p_fav; ?>','<?php echo $db_user_name; ?>')"><i class="fa fa-heart-o heart_color" style="font-size:20px;"></i></a>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            <a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($db_user_name); ?>&critaria=1" data-toggle="modal" data-target="#missing_popular_review_Modal2_<?php echo $p_fav; ?>" data-title="" class="like link-disable" style="color:#FFFFFF;"> <?php echo $counter_main; ?></a></span>
                                                                        <span class="like-group" style="float:right; display:none; line-height:20px !important;" id="myStyle_sub_profile_<?php echo $p_fav; ?>"></span>

                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" style="padding:0px !important;">
                                                <div class="album_details" style="margin-top:-5px;">

                                                    <p><label class="author" style="float:left; width:auto;">
                                                            <a class="darkgrey_rev" href="<?php echo SERVER_ROOTPATH . stripslashes($user_seo) . "/profile-playlists/" . stripslashes($row_playlistinfo['title_playlist_seo']); ?>"><?php echo stripslashes($row_playlistinfo['title_playlist']); ?> </a>
                                                        </label>
                                                        <label class="likes" style="margin-left:5px; float:right;">
                                                            <!--<span style="overflow:visible; margin-top:-10px;"><a href="#"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span> 3</span><a href="#" class="like link-disable" style="color:#444;"> Likes</a></span>-->
                                                            <?php
                                                            $qry = "select id from tbl_likes where like_type = 'playlist' AND like_id = '" . $row_playlistinfo['id'] . "'";
                                                            $counter_main_playlist = array();
                                                            $counter_main_playlist = \App\Models\Songs::GetRawData($qry);
                                                            if ($counter_main_playlist) {
                                                                $counter_main_playlist = count($counter_main_playlist);
                                                            } else {
                                                                $counter_main_playlist = 0;
                                                            }

                                                            if ($user_id != "") {


                                                                $query = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  like_type = 'playlist' AND like_id = '" . $row_playlistinfo['id'] . "'";

                                                                $artist_list_arr = \App\Models\Songs::GetRawData($query);
                                                                if ($artist_list_arr) {
                                                                    $counter  = count($artist_list_arr);
                                                                } else {
                                                                    $counter  = 0;
                                                                }





                                                                if ($counter == 0) {
                                                            ?>
                                                                    <span style="overflow:visible;" id="show_playlist_likes_<?php echo $row_playlistinfo['id']; ?>"><a href="javascript:;" onClick="add_in_playlist('<?php echo $row_playlistinfo['id']; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span><?php echo $counter_main_playlist; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail_playlist.php?artist=<?php echo $row_playlistinfo['id']; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main_playlist < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                                                    <span style="overflow:visible; display:none;" id="myStyle_profile_<?php echo $row_playlistinfo['id']; ?>"></span>

                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <span style="overflow:visible;" id="show_playlist_likes_<?php echo $row_playlistinfo['id']; ?>"><a href="javascript:;" onClick="add_in_playlist('<?php echo $row_playlistinfo['id']; ?>')"><i class="fa fa-heart heart_color heart_size"></i> </a><span><?php echo $counter_main_playlist; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail_playlist.php?artist=<?php echo $row_playlistinfo['id']; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main_playlist < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                                                                    <span style="overflow:visible; display:none;" id="myStyle_profile_<?php echo $row_playlistinfo['id']; ?>"></span>
                                                                <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $row_playlistinfo['id']; ?>">
                                                                    <?php
                                                                    if ($user_id == "") {
                                                                    ?>
                                                                        <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <a href="javascript:;" onClick="add_in_playlist('<?php echo $row_playlistinfo['id']; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <span><?php echo $counter_main_playlist; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>detail_playlist.php?artist=<?php echo $row_playlistinfo['id']; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main_playlist < 2) {
                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                                                <span style="overflow:visible; display:none;" id="myStyle_profile_<?php echo $row_playlistinfo['id']; ?>"></span>


                                                            <?php
                                                            }
                                                            ?>
                                                        </label>
                                                    </p>
                                                    <div class="clearfix"></div>
                                                    <div class="activity-panel">
                                                        <label class="likes darkgrey_rev"><i class="fa fa-heart-o heart_size ft_20"></i> Likes <text class="heart_color"><?php echo $like_list_arr_user['count_likes'] + $counter_main_profile_like2 + $like_playlist_count; ?></text></label><br>
                                                        <label class="likes darkgrey_rev" style="margin-bottom:0;"><img src="<?php echo SERVER_ROOTPATH; ?>images/review-book.png" style="margin-bottom:10px; margin-top:7px;"> Reviews <text class="heart_color"><?php echo $review_list_arr_top['count_reviews']; ?></text></label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;<label class="likes darkgrey_rev"><img src="<?php echo SERVER_ROOTPATH; ?>images/icon_post.png" style="margin-bottom:5px;"> Posts <text class="heart_color"><?php echo $comment_list_arr['count_discussion']; ?></text></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            <?php } ?>
                    <?php
                            $y++;
                        }
                    }

                    ?>
                </ul>
            </div>

        </div>

        <?php if ($total_pages > $limit) { ?>
            <div class="page-navigation" style="border:none;">
                <div class="clearfix"></div>
                <ul>
                    @include("common.paging-playlist")
                </ul>
            </div>
        <?php } ?>
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
                            @csrf
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
// include("include.thankyou_messages.php");


for ($u = 1; $u <= $sr_no; $u++) {
?>
    <div class="modal fade" id="missing_popular_review_Modal2_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}

?><div class="modal fade" id="profile_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

@include("common.footer")
<style>
    body {
        overflow-x: hidden;
    }
</style>
<script>
    function name_space(id) {

        $("#nam_" + id).hide();
    }
</script>
<!--</body>
</html>-->