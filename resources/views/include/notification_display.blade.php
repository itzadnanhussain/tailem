<?php
error_reporting(0);
$qry = "select l.notification_click,l.read_status,l.id,u.user_name,l.like_type,l.description,l.date,u.profile_image, l.like_id, l.like_receive_user, l.like_from_user_id  from  tbl_likes l, tbl_users u  where l.like_from_user_id = u.user_id  AND (l.like_type = 'review_song' OR l.like_type = 'profile' OR l.like_type = 'delete_review_song' OR l.like_type = 'playlist' OR l.like_type = 'admin_review') AND l.like_receive_user = '" . $user_id . "' AND l.del_notification = 0 order by l.id desc";

$result_notification = \App\Models\Songs::GetRawData($qry);
 
if ($result_notification) {
    $notify = 0;
    foreach ($result_notification as $notif) {
        $notif = (array)$notif;
        $notify++;
        $db_like_id  = $notif['id'];
        $db_like_type  = $notif['like_type'];

        $user_name_notif  = $notif['user_name'];
        $like_id_notif  = $notif['like_id'];
        $profile_image  = $notif['profile_image'];
        $read_status  = $notif['read_status'];
        $notification_click    = $notif['notification_click'];
        if ($read_status == 1) {
           \App\Models\Songs::GetRawData("update tbl_likes set read_status = 0 where id = $db_like_id");
        }

        if ($profile_image != "") {
            $prof_image_get = SERVER_ROOTPATH . "assets/phpthumb/phpThumb.php?src=" . SERVER_ROOTPATH . "site_upload/user_images/" . $profile_image . "&w=54&h=51&zc=0";
        } else {
            $prof_image_get = SERVER_ROOTPATH . "assets/phpthumb/phpThumb.php?src=" . SERVER_ROOTPATH . "assets/images/no_image4.png&w=46&h=46&zc=0";
        }
        if ($notification_click == 1) {
            $color_code = "#F6F6F7";
        } else {
            $color_code = "#fff";
        }
?>

        <div class="row" onclick="tab_click('<?php echo $notification_click; ?>', <?php echo $db_like_id; ?>)" style="min-height: 62px;
    padding: 6px 0; min-height:15px; margin:0; border-bottom:1px solid #d2d2d2; background-color:<?php echo $color_code; ?>;" id="notify_<?php echo $db_like_id; ?>">
            <div class="col-md-2 col-xs-2 profile_image">
                <?php
                if ($db_like_type != 'delete_review_song') {
                ?>
                    <img src="<?php echo $prof_image_get; ?>" />
                <?php
                }
                ?>
            </div>

            <div class="col-md-8 col-xs-8 mobile_left" style="line-height:15px;">
                <?php
                if ($db_like_type == 'delete_review_song') {
                    $description   = $notif['description'];
                    echo $description . "<br>" . $notif['date'];
                } else
							if ($db_like_type == 'playlist') {
                    $qry = "select u.user_name, p.title_playlist, p.title_playlist_seo from tbl_users u, tbl_user_playlist p where   u.user_id = '" . $notif['like_receive_user'] . "' AND p.id = '" . $notif['like_id'] . "' ";

                    $get_info_arr    =    \App\Models\Songs::GetRawData($qry);

                    $user_name_db  =  mysqli_escape_string($db->dbh, $get_info_arr['user_name']);
                    $db_title  =  mysqli_escape_string($db->dbh, $get_info_arr['title_playlist']);
                    $db_title_playlist_seo  =  mysqli_escape_string($db->dbh, $get_info_arr['title_playlist_seo']);


                    $db_link    =  SERVER_ROOTPATH . get_user_detail($user_name_notif) . "-profile-review-artist";
                    $db_link_playlist  = SERVER_ROOTPATH . get_user_detail($user_name_db) . "-profile-playlists-" . $db_title_playlist_seo;
                ?>
                    <a class='user_pnl_col' href="javascript:;" onclick="gotolink('<?php echo $db_link; ?>', '<?php echo $notification_click; ?>', <?php echo $db_like_id; ?>)" style='display:inline;  font-size:11px;  padding:5px 0 !important;'><?php echo $user_name_notif; ?></a> likes your playlist <a class='user_pnl_col' href="javascript:;" onclick="gotolink('<?php echo $db_link_playlist; ?>', '<?php echo $notification_click; ?>', <?php echo $db_like_id; ?>)" style='display:inline; font-size:11px; padding:5px 0 !important;'><?php echo $db_title; ?></a>
                <?php


                } else
							if ($db_like_type == 'profile') {
                ?>
                    <a href="javascript:;" onclick="gotolink('<?php echo SERVER_ROOTPATH . get_user_detail($user_name_notif) . '-profile-review-artist'; ?>', '<?php echo $notification_click; ?>', <?php echo $db_like_id; ?>)" class="user_pnl_col" style="display:inline;  font-size:11px;  padding:5px 0 !important;"><?php echo $user_name_notif; ?></a> likes your profile
                <?php
                } else
							if ($db_like_type == 'admin_review') {
                ?>
                    <a href="javascript:;" onclick="gotolink('<?php echo SERVER_ROOTPATH . get_user_detail($user_name_notif) . '-profile-review-artist'; ?>', '<?php echo $notification_click; ?>', <?php echo $db_like_id; ?>)" class="user_pnl_col" style="display:inline;  font-size:11px;  padding:5px 0 !important;"><?php echo $user_name_notif; ?></a> Admin add a review
                <?php
                } else
							if ($db_like_type == 'review_song') {
                    $song_notification =
                        "select s.song_title, s.song_seo, a.artist_seo  
						   from  tbl_reviews r, tbl_songs s, tbl_artists a  
						   where r.review_id = $like_id_notif 
						   AND r.song_id = s.id
						   AND r.artist_id = a.id 
						   AND s.song_status = 1
						   ";

                    $song_result_notification = \App\Models\Songs::GetRawData($song_notification);
                ?>
                    <a href="javascript:;" onclick="gotolink('<?php echo SERVER_ROOTPATH . get_user_detail($user_name_notif) . '-profile-review-artist'; ?>', '<?php echo $notification_click; ?>', <?php echo $db_like_id; ?>)" class="user_pnl_col" style="display:inline;  font-size:11px;  padding:5px 0 !important;"><?php echo $user_name_notif; ?></a>
                    likes your review on
                    <a href="javascript:;" onclick="gotolink('<?php echo SERVER_ROOTPATH . $song_result_notification['song_seo'] . "-reviews-" . $song_result_notification['artist_seo']; ?>#review_<?php echo $like_id_notif; ?>', '<?php echo $notification_click; ?>', <?php echo $db_like_id; ?>)" class="user_pnl_col" style="display:inline; font-size:11px; padding:5px 0 !important;"><?php echo wordwrap(stripslashes($song_result_notification['song_title']), 100, " ", true); ?></a>
                <?php
                }
                ?>
            </div>
            <div class="col-md-2 col-xs-2" style="padding-left: 0px; font-size: 11px;  min-height:50px;">
                <a href="javascript:;" onclick="delete_notification(<?php echo $db_like_id; ?>)" class="remove_noti" style="position:absolute; bottom:0;">Remove</a>
            </div>

        </div>




    <?php
    }
} else {
    ?>
    <div class="row" style="margin-bottom:5px;" id="notify_<?php echo $db_like_id; ?>">
        <div class="col-md-12" style="color:#333; margin: 0; padding: 0; text-align: center; font-size: 12px;">&nbsp;</div>
    </div>
    <script type="text/javascript">
        $("#removeall").hide();
    </script>
<?php

}

?>
<script type="text/javascript">
    function gotolink(url, status, id) {
        var csrf_token = $('meta[name=csrf-token]').attr('content');  
        if (status == 1) {
            $.ajax({
                type: "POST",
                url: '<?php echo SERVER_ROOTPATH; ?>process/update_notification_click',
                data: {
                    'id':id,
                    "_token": csrf_token,
                },
                beforeSend: function() {},
                success: function(data) {
                    window.location.href = url;
                },
                error: function() {

                }
            });
        } else {
            window.location.href = url;
        }
    }

    function tab_click(status, id) {
        var csrf_token = $('meta[name=csrf-token]').attr('content');  

        if (status == 1) {
            $.ajax({
                type: "POST",
                url: '<?php echo SERVER_ROOTPATH; ?>process/update_notification_click',
                data: {
                    'id':id,
                    "_token": csrf_token,
                },
                beforeSend: function() {},
                success: function(data) {

                    $("#notify_" + id).css("background-color", "#fff");
                },
                error: function() {

                }
            });
        }
    }

    function remove_all_notifications() {
        var csrf_token = $('meta[name=csrf-token]').attr('content');  
        $.ajax({
            type: "POST",
            url: '<?php echo SERVER_ROOTPATH; ?>process/update_notification_click',
            
            data: {
                    'delete':'all',
                    "_token": csrf_token,
                },
            beforeSend: function() {},
            success: function(data) {

                window.location.reload();
            },
            error: function() {

            }
        });
    }
</script>