<?php
$select_img = "select profile_image, user_name, fname, lname from  tbl_users where user_id='" . $user_profile . "' ";
$result_image = \App\Models\Songs::GetRawData($select_img);
$result_image = (array)$result_image[0];
$profile_image = $result_image['profile_image'];
if ($profile_image != "") {
    $prof_image = SERVER_ROOTPATH . "site_upload/user_images/" . $profile_image;
} else {
    $prof_image = SERVER_ROOTPATH . "assets/images/no_image4.png";
}
$sr_no = 99999999;

$db_username    =    stripslashes($result_image['user_name']);
if (isset($_SESSION[USER_SESSION_ARRAY]['FBNAME'])) {
    $db_fullname    =    $_SESSION[USER_SESSION_ARRAY]['FBNAME'];
}

$counter_main_profile_like = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'profile' AND like_id = '$user_profile'");
if ($counter_main_profile_like) {
    $counter_main_profile_like = count($counter_main_profile_like);
} else {
    $counter_main_profile_like = 0;
}


$counter_main_playlist_like = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'playlist' AND like_receive_user = '$user_profile'");
if ($counter_main_playlist_like) {
    $counter_main_playlist_like = count($counter_main_playlist_like);
} else {
    $counter_main_playlist_like = 0;
}

?>
<?php if ($mobile_view == 0) { ?>
    <div class="col-sm-3  artist-img-panel pad_left">
        <div class="latestsongssec">
            <div class="list_item">
                <div class="album_cover" style="border-radius:0px; ">
                    <img src="<?php echo $prof_image; ?>" style="height:175px; display:none;" class="img-responsive artist-img show_review">
                    <img src="<?php echo $prof_image; ?>" style="height:240px;" class="img-responsive artist-img show_review_hide">
                    @include("common.my_account_header")
                </div>
            </div>
        </div>

        <?php
        if ($main_link == "") {
            if ($mobile_view == 0) {
        ?>
                <div class="text_12 show_review" style="margin-top:5px; display:none;">
                    <a href="<?php echo SERVER_ROOTPATH; ?>change-username" style="color:#000000;"> <i class="fa fa-user text_red" style="margin-right:3px;"></i>&nbsp;Edit Username</a> <br />

                    <a href="<?php echo SERVER_ROOTPATH; ?>change-picture" style="color:#000000;"><i class="fa fa-camera text_red"></i> Edit Picture</a> <br />
                    <a href="<?php echo SERVER_ROOTPATH; ?>change-password" style="color:#000000;"><i class="fa fa-key text_red"></i> Edit Password</a>

                </div>
        <?php
            }
        }
        ?>
    </div>

    <div class="col-sm-9">
        <p class="title" style="font-size:14px;">
        <div class="col-sm-12" style="padding-left:0;"><a style="color:#000000; font-weight:bold; font-size:26px;"><?php if ($main_link != "") {
                                                                                                                    } else {
                                                                                                                        echo "Welcome";
                                                                                                                    } ?> <?php
                                                                                                                            if (isset($db_fullname) && ($db_fullname != '')) {
                                                                                                                                echo $db_fullname;
                                                                                                                            } else {
                                                                                                                                echo $user_name;
                                                                                                                            } ?></a>

            <label class="likes" style=" margin-left:10px;  margin-top:-2px;">
                <?php
                if ($user_id != "") {

                    $counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'profile' AND like_id = '$user_profile'");
                    if ($counter) {
                        $counter = count($counter);
                    } else {
                        $counter = 0;
                    }

                    if ($counter == 0) {
                ?>
                        <?php if (isset($user_type) && $user_type == 'admin') { ?>

                            <span id="other_dis_sub_profile_main_<?php echo $sr_no; ?>"><a href="javascript:;"><i class="fa fa-heart-o heart_color heart_size"></i></a><span style="font-weight:normal; font-size:14px;"> <?php echo $counter_main_profile_like; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_Modal2_<?php echo $sr_no; ?>" data-title="" class="like link-disable" style="color:#000; font-weight:normal; font-size:14px; margin-right:40px;"><?php if ($counter_main_profile_like < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a></span>

                        <?php } else { ?>
                            <span id="other_dis_sub_profile_main_<?php echo $sr_no; ?>"><a href="javascript:;" onClick="add_in_favourite_main_profile_list_new('<?php echo $user_profile; ?>','<?php echo $sr_no; ?>','<?php echo $user_name; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a><span style="font-weight:normal; font-size:14px;"> <?php echo $counter_main_profile_like; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_Modal2_<?php echo $sr_no; ?>" data-title="" class="like link-disable" style="color:#000; font-weight:normal; font-size:14px; margin-right:40px;"><?php if ($counter_main_profile_like < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>

                        <?php } ?>
                        <span id="myStyle_sub_profile_main_<?php echo $sr_no; ?>"></span>
                    <?php
                    } else {
                    ?>

                        <?php if (isset($user_type) && ($user_type == 'admin')) { ?>
                            <span id="other_dis_sub_profile_main_<?php echo $sr_no; ?>"><a href="javascript:;"><i class="fa fa-heart heart_color heart_size"></i></a><span style="font-weight:normal; font-size:14px;"> <?php echo $counter_main_profile_like; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_Modal2_<?php echo $sr_no; ?>" data-title="" class="like link-disable" style="color:#000; font-weight:normal; font-size:14px; margin-right:40px;"><?php if ($counter_main_profile_like < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                        <?php } else { ?>
                            <span id="other_dis_sub_profile_main_<?php echo $sr_no; ?>"><a href="javascript:;" onClick="add_in_favourite_main_profile_list_new('<?php echo $user_profile; ?>','<?php echo $sr_no; ?>','<?php echo $user_name; ?>')"><i class="fa fa-heart heart_color heart_size"></i></a><span style="font-weight:normal; font-size:14px;"> <?php echo $counter_main_profile_like; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_Modal2_<?php echo $sr_no; ?>" data-title="" class="like link-disable" style="color:#000; font-weight:normal; font-size:14px; margin-right:40px;"><?php if ($counter_main_profile_like < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a></span>


                        <?php } ?>
                        <span id="myStyle_sub_profile_main_<?php echo $sr_no; ?>"></span>



                    <?php
                    }
                } else {
                    ?>
                    <span id="other_dis_sub_profile_main_<?php echo $sr_no; ?>">
                        <?php
                        if ($user_id == "") {
                        ?>
                            <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                        <?php
                        } else {
                        ?>
                            <?php if (isset($user_type) && ($user_type == 'admin')) { ?>
                                <a href="javascript:;"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                            <?php } else { ?>
                                <a href="javascript:;" onClick="add_in_favourite_main_profile_list_new('<?php echo $user_profile; ?>','<?php echo $sr_no; ?>','<?php echo $user_name; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                            <?php } ?>
                        <?php
                        }
                        ?>
                        <span style="font-weight:normal; font-size:14px;"> <?php echo $counter_main_profile_like; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_Modal2_<?php echo $sr_no; ?>" data-title="" class="like link-disable" style="color:#000; font-weight:normal; font-size:14px; margin-right:40px;"> <?php if ($counter_main_profile_like < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a></span>
                    <span id="myStyle_sub_profile_main_<?php echo $sr_no; ?>"></span>

                <?php
                }
                ?>
            </label>
        </div>
        </p>
        <div style="clear:both;"></div>
        <div class="col-md-8 col-lg-8  desc-panel pad_left">


        <?php
    } elseif ($mobile_view == 1) { ?>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pad_zero">
                <div class="latestsongssec artist-img-panel" style="padding-bottom:0;">
                    <div class="list_item">
                        <div class="album_cover" style="border-radius:0; ">
                            <img src="<?php echo $prof_image; ?>" class="img-responsive  artist-img">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding:5px; padding-left:10px;">
                <p class="title" style="font-weight:bold; font-size:20px;"><a style="color:#000000; padding-left:1px;"><?php if ($main_link != "") {
                                                                                                                        } else {
                                                                                                                            echo "Welcome";
                                                                                                                        } ?> <?php echo $user_name; ?></a></p>

                <label class="likes" style="font-size:14px; margin-top:4px;">

                    <?php if ($user_id != "") {


                        $counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $user_id . "' AND  	like_type = 'profile' AND like_id = '$user_profile'");
                        if ($counter) {
                            $counter = count($counter);
                        } else {
                            $counter = 0;
                        }


                        if ($counter == 0) {
                    ?>

                            <?php if (isset($user_type) && ($user_type == 'admin')) { ?>

                                <span id="other_dis_sub_profile_main_<?php echo $sr_no; ?>"><a href="javascript:;"><i class="fa fa-heart-o heart_color heart_size"></i></a><span style="font-weight:normal;" class="red-text"> <?php echo $counter_main_profile_like; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_Modal2_<?php echo $sr_no; ?>" data-title="" class="like link-disable" style="color:#000; font-weight:normal;"><?php if ($counter_main_profile_like < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?></a></span>

                            <?php } else { ?>
                                <span id="other_dis_sub_profile_main_<?php echo $sr_no; ?>"><a href="javascript:;" onClick="add_in_favourite_main_profile_list_new('<?php echo $user_profile; ?>','<?php echo $sr_no; ?>','<?php echo $user_name; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a><span style="font-weight:normal;" class="red-text"> <?php echo $counter_main_profile_like; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_Modal2_<?php echo $sr_no; ?>" data-title="" class="like link-disable" style="color:#000; font-weight:normal;"><?php if ($counter_main_profile_like < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>

                            <?php } ?>
                            <span id="myStyle_sub_profile_main_<?php echo $sr_no; ?>"></span>


                        <?php
                        } else {
                        ?>
                            <?php if (isset($user_type) && ($user_type == 'admin')) { ?>
                                <span id="other_dis_sub_profile_main_<?php echo $sr_no; ?>"><a href="javascript:;"><i class="fa fa-heart heart_color heart_size"></i></a><span class="red-text"> <?php echo $counter_main_profile_like; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_Modal2_<?php echo $sr_no; ?>" data-title="" class="like link-disable" style="color:#000; font-weight:normal;"><?php if ($counter_main_profile_like < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?></a></span>



                            <?php } else { ?>
                                <span id="other_dis_sub_profile_main_<?php echo $sr_no; ?>"><a href="javascript:;" onClick="add_in_favourite_main_profile_list_new('<?php echo $user_profile; ?>','<?php echo $sr_no; ?>','<?php echo $user_name; ?>')"><i class="fa fa-heart heart_color heart_size"></i></a><span class="red-text"> <?php echo $counter_main_profile_like; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_Modal2_<?php echo $sr_no; ?>" data-title="" class="like link-disable" style="color:#000; font-weight:normal;"><?php if ($counter_main_profile_like < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>


                            <?php } ?>
                            <span id="myStyle_sub_profile_main_<?php echo $sr_no; ?>"></span>
                        <?php
                        }
                    } else {
                        ?>
                        <span id="other_dis_sub_profile_main_<?php echo $sr_no; ?>">
                            <?php
                            if ($user_id == "") {
                            ?>
                                <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                            <?php
                            } else {
                            ?>
                                <?php if (isset($user_type) && ($user_type == 'admin')) { ?>
                                    <a href="javascript:;"><i class="fa fa-heart-o heart_color heart_size"></i></a><span class="red-text">
                                    <?php } else { ?>
                                        <a href="javascript:;" onClick="add_in_favourite_main_profile_list_new('<?php echo $user_profile; ?>','<?php echo $sr_no; ?>','<?php echo $user_name; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a><span class="red-text">
                                        <?php } ?>
                                    <?php
                                }
                                    ?>
                                    <?php echo $counter_main_profile_like; ?>
                                        </span>

                                        <a href="<?php echo SERVER_ROOTPATH; ?>process/detail_profile?user=<?php echo urlencode($user_name); ?>&critaria=1" data-toggle="modal" data-target="#profile_Modal2_<?php echo $sr_no; ?>" data-title="" class="like link-disable" style="color:#000; font-weight:normal;"> <?php if ($counter_main_profile_like < 2) {
                                                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                                                        } ?></a></span>
                                    <span id="myStyle_sub_profile_main_<?php echo $sr_no; ?>"></span>

                                <?php
                            }
                                ?>
                </label>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad_zero" style="margin-bottom:6px;">
                @include("common.my_account_header")
            </div>

        <?php } ?>
        <div class="modal fade" id="profile_Modal2_<?php echo $sr_no; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>