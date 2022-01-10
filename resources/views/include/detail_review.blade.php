<?php

$user_detail = get_user_detail($user_seo);
if ($user_detail != '') {
    $user_seo = $user_detail;
}


$qry      =  "select user_name, user_id from tbl_users where user_seo='" . $user_seo . "'";
$row_userinfo = \App\Models\Songs::GetRawData($qry);
if ($row_userinfo) {
    $row_userinfo = (array)$row_userinfo[0];
    $user_id             = stripslashes(html_entity_decode($row_userinfo['user_id']));
    $user_name             = stripslashes(html_entity_decode($row_userinfo['user_name']));
}


$qry      =  "select s.song_seo, a.artist_seo from  tbl_songs s, tbl_reviews r,tbl_artists a where r.song_id = s.id AND a.id = r.artist_id AND r.review_id = $rev_id";
$row_songseo = \App\Models\Songs::GetRawData($qry);
if ($row_songseo) {
    $row_songseo = (array)$row_songseo[0];
    $seo_song  = $row_songseo['song_seo'];
    $artist_seo  = $row_songseo['artist_seo'];
} else {
    $seo_song  =  '';
    $artist_seo  =  '';
}
?>
<style>
    /*.album_details label {font-size:14px !important;}*/
    .label_class {
        font-weight: 300;
        font-size: 14px !important;
    }

    body {
        overflow-x: hidden;
    }

    .screen-pp {
        display: block !important;
    }

    .mobile-pp {
        display: none !important;
    }

    .popularreviews .album_details img {
        margin-right: 0;
    }

    @media (max-width: 430px) {
        .screen-pp {
            display: none !important;
        }

        .mobile-pp {
            display: block !important;
        }

        .popup_position {
            height: 26px !important;
            margin-top: -9px !important;
            float: right !important;
            padding: 0 !important;
        }
    }
</style>
<div class="modal-dialog popup_display">
    <div class="modal-content" style="border-radius:0px;">
        <div class="modal-header" style="padding:5px;">
            <button type="button" class="close" data-dismiss="modal" onclick="close_likes_popup();"
                aria-label="Close"><span aria-hidden="true"><img
                        src="<?php echo SERVER_ROOTPATH; ?>images/crosspng.png"></span></button>
            <h4 style="width:90%;" class="modal-title text_blck">Who likes <a style="color:#d73b3b;"
                    href="<?php echo SERVER_ROOTPATH . Slug($seo_song) . "/reviews/" . Slug($artist_seo); ?>#review_<?php echo $rev_id; ?>"><?php echo $user_name; ?></a> review?</h4>

        </div>
        <div class="modal-body" style="padding:5px; overflow-x:hidden; overflow-y:auto; height:auto; max-height:300px;">

            <ul class="songlistings">
                <?php
                $qry      =  "select u.user_id, u.user_name, u.profile_image from tbl_likes l, tbl_users u where u.user_id = l.like_from_user_id AND l.like_id = $rev_id AND l.like_type = 'review_song' order by l.id desc";
                $row_artist = \App\Models\Songs::GetRawData($qry);
                $sr_no = 0;
                $k = 0;
                $c = 0;
                if ($row_artist) {
                    foreach ($row_artist as $val) {
                        $val = (array) $val;

                        $sr_no++;
                        $k++;
                        $profile_image = stripslashes($val['profile_image']);
                        $user_ids = stripslashes($val['user_id']);
                        $user_name_get_db = stripslashes($val['user_name']);
                        if ($profile_image != "") {
                            $prof_image = SERVER_ROOTPATH . "site_upload/user_images/" . $profile_image;
                        } else {
                            $prof_image = SERVER_ROOTPATH . "assets/images/no_image4.png";
                        }

                        if ($c % 2 == 0) {
                            $bgcolor = "#ffffff";
                        } else {
                            $bgcolor = "#f7f7f7";
                        }
                        $c++;

                        $qry      = "select u.user_name, u.profile_image from tbl_likes l, tbl_users u where u.user_id = l.like_id AND l.like_id = $user_ids AND l.like_type = 'profile'";
                        $query_likes_count = array();
                        $query_likes_count = \App\Models\Songs::GetRawData($qry);
                        if ($query_likes_count) {
                            $query_likes_count = count($query_likes_count);
                        } else {
                            $query_likes_count = 0;
                        }


                        $count_like_review  = count_likes($user_ids);

                        $like_playlist_count    =    get_playlist_like_counter($user_ids);

                        $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $user_ids . "' order by r.review_id desc limit 1";

                        $review_list_arr_top = \App\Models\Songs::GetRawDataAdmin($review_list_qry);

                        $comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_user_id = '" . $user_ids . "' order by comment_id desc limit 1";

                        $comment_list_arr = \App\Models\Songs::GetRawDataAdmin($comment_list_qry); ?>


                <li
                    style="background-color:<?php echo $bgcolor; ?>; border-bottom:1px solid #ccc;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                            style="padding:0; margin-bottom:15px; margin-top:15px;">
                            <div class="album_cover col-lg-3 col-md-3 col-sm-3 col-xs-3" style="padding:0;">
                                <a
                                    href="<?php echo SERVER_ROOTPATH . get_user_detail($user_name_get_db) . "/profile-review-artist"; ?>"><img
                                        class="img-responsive"
                                        src="<?php echo $prof_image; ?>"
                                        style="max-height:76px; width:100px; margin-left:15px;"></a>
                            </div>
                            <div class="album_details col-lg-9 col-md-9 col-sm-9 col-xs-9"
                                style="padding:0; margin-top:0;">
                                <div class="row" style="margin-top:4px; margin-left:4px;">

                                    <?php if ($mobile_view == 1) { ?>
                                    <label class="label_class title col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                        <?php } elseif ($mobile_view == 0) { ?>
                                        <label class="label_class title col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                            <?php } ?>
                                            <a style="color:#000000; font-size:18px;"
                                                href="<?php echo SERVER_ROOTPATH . get_user_detail($user_name_get_db) . "/profile-review-artist"; ?>"><?php echo $val['user_name']; ?></a></label>


                                        <?php if ($mobile_view == 1) { ?>
                                        <label
                                            class="label_class likes popup_position col-lg-7 col-md-7 col-sm-7 col-xs-6">
                                            <?php } elseif ($mobile_view == 0) { ?>
                                            <label
                                                class="label_class likes popup_position col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <?php } ?>

                                                <?php
                                                            if ($user_id == $user_ids) { ?>
                                                <i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i><a
                                                    style="text-decoration:none; color:#000000;"><span
                                                        style="color:#D73B3B;"> <?php echo $query_likes_count; ?>
                                                    </span> Likes</a>
                                                <?php
                                                            } else {
                                                                if ($user_id != "") {
                                                                    $qry = "select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'profile' AND like_id = '$user_id'";
                                                                    $counter = array();
                                                                    $counter = \App\Models\Songs::GetRawData($qry);
                                                                    
                                                                    if ($counter) {
                                                                        $counter = count($counter);
                                                                    } else {
                                                                        $counter = 0;
                                                                    }

                                                                    if ($counter == 0) {
                                                                        ?>
                                                <span
                                                    id="popother_dis_sub_profile_<?php echo $sr_no; ?>"><a
                                                        href="javascript:;"
                                                        onClick="add_in_favourite_user_profile_popup(<?php echo $user_ids; ?>,<?php echo $sr_no; ?>)"><i
                                                            class="fa fa-heart-o"
                                                            style="font-size:24px; color:#D73B3B;"></i></a><span
                                                        style="color:#D73B3B;"> <?php echo $query_likes_count; ?></span><a
                                                        style="text-decoration:none; color:#000000;"><?php if ($query_likes_count < 2) {
                                                                            echo " Like";
                                                                        } else {
                                                                            echo " Likes";
                                                                        } ?>
                                                    </a></span>
                                                <span
                                                    id="popmyStyle_sub_profile_<?php echo $sr_no; ?>"></span>

                                                <?php
                                                                    } else {
                                                                        ?>
                                                <span
                                                    id="popother_dis_sub_profile_<?php echo $sr_no; ?>"><a
                                                        href="javascript:;"
                                                        onClick="add_in_favourite_user_profile_popup(<?php echo $user_ids; ?>,<?php echo $sr_no; ?>)"
                                                        class="like"><i class="fa fa-heart"
                                                            style="font-size:24px; color:#D73B3B;"></i></a> <span
                                                        style="color:#D73B3B;"> <?php echo $query_likes_count; ?></span><a
                                                        style="text-decoration:none; color:#000000;"><?php if ($query_likes_count < 2) {
                                                                            echo " Like";
                                                                        } else {
                                                                            echo " Likes";
                                                                        } ?>
                                                    </a></span>
                                                <span
                                                    id="popmyStyle_sub_profile_<?php echo $sr_no; ?>"></span>
                                                <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                <span
                                                    id="popother_dis_sub_profile_<?php echo $sr_no; ?>">
                                                    <?php
                                                                        if ($user_id == "") {
                                                                            ?>
                                                    <a href="#" data-toggle="modal" data-target="#signin_form"
                                                        class="text_grey" data-dismiss="modal"><i class="fa fa-heart-o"
                                                            style="font-size:24px; color:#D73B3B;"></i></a>
                                                    <?php
                                                                        } else {
                                                                            ?>
                                                    <a href="javascript:;"
                                                        onClick="add_in_favourite_user_profile_popup(<?php echo $user_ids; ?>,<?php echo $sr_no; ?>)"
                                                        class="text_grey"><i class="fa fa-heart-o"
                                                            style="font-size:24px; color:#D73B3B;"></i></a>
                                                    <?php
                                                                        } ?>
                                                    <span style="color:#D73B3B;"> <?php echo $query_likes_count; ?></span><a
                                                        style="text-decoration:none; color:#000000;"><?php if ($query_likes_count < 2) {
                                                                            echo " Like";
                                                                        } else {
                                                                            echo " Likes";
                                                                        } ?>
                                                    </a>
                                                </span>
                                                <span
                                                    id="popmyStyle_sub_profile_<?php echo $sr_no; ?>"></span>

                                                <?php
                                                                }
                                                            } ?>
                                            </label>
                                            <div style="clear:both;"></div>
                                            <p class="screen-pp" style="margin-top:15px;">
                                                <label class="label_class likes col-lg-3 col-md-3 col-sm-3 col-xs-3"
                                                    style="margin-right:5px; margin-left:14px; padding:0;"><i
                                                        class="fa fa-heart-o" style="font-size:20px;"></i><a
                                                        style="color:#000000;"> Likes<span style="color:#D73B3B;">
                                                            <?php echo $count_like_review + $like_playlist_count; ?></span></a></label>

                                                <label class="label_class reviews col-lg-4 col-md-4 col-sm-4 col-xs-4"
                                                    style="padding:0;"><img
                                                        src="<?php echo SERVER_ROOTPATH; ?>images/review-book.png"
                                                        style="margin-bottom:2px;"><a style="color:#000000;">
                                                        Reviews<span style="color:#D73B3B;"> <?php echo $review_list_arr_top['count_reviews']; ?></span></a></label>
                                                <label class="label_class reviews col-lg-4 col-md-4 col-sm-4 col-xs-4"
                                                    style="padding:0;"> <img
                                                        src="<?php echo SERVER_ROOTPATH; ?>images/icon_post.png"
                                                        style="margin-bottom:6px;"><a style="color:#000000;"> Posts<span
                                                            style="color:#D73B3B;"> <?php echo $comment_list_arr['count_discussion']; ?></span></a></label>
                                            </p>
                                            <p class="mobile-pp" style="margin-top:5px;">
                                                <label class="label_class likes col-lg-3 col-md-3 col-sm-3 col-xs-12"
                                                    style="margin-right:5px; margin-left:14px; padding:0;"><i
                                                        class="fa fa-heart-o"
                                                        style="font-size:20px; margin-bottom:5px;"></i><a
                                                        style="color:#000000;"> Likes<span style="color:#D73B3B;">
                                                            <?php echo $count_like_review + $like_playlist_count; ?></span></a></label>

                                                <label class="label_class reviews col-lg-4 col-md-4 col-sm-4 col-xs-6"
                                                    style="padding-right:0;"><img
                                                        src="<?php echo SERVER_ROOTPATH; ?>images/review-book.png"
                                                        style="margin-bottom:2px;"><a style="color:#000000;">
                                                        Reviews<span style="color:#D73B3B;"> <?php echo $review_list_arr_top['count_reviews']; ?></span></a></label>
                                                <label class="label_class reviews col-lg-3 col-md-3 col-sm-3 col-xs-6"
                                                    style="padding:0;"> <img
                                                        src="<?php echo SERVER_ROOTPATH; ?>images/icon_post.png"
                                                        style="margin-bottom:7px;"><a style="color:#000000;"> Posts<span
                                                            style="color:#D73B3B;"> <?php echo $comment_list_arr['count_discussion']; ?></span></a></label>
                                            </p>
                                </div>
                            </div>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                </li>
                <?php
                    }
                }

                ?>

            </ul>
        </div>
    </div>
</div>