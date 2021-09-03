<?php
///covert object to array
$setting_arr = (array)$setting_arr[0];

///other code
$facebook_right_script  = stripslashes(html_entity_decode($setting_arr['facebook_right_script']));
$facebook_bottom_script    = stripslashes(html_entity_decode($setting_arr['facebook_bottom_script']));
$desktop_version_logo    = $setting_arr['desktop_version_logo'];

$rate_review    = stripslashes(html_entity_decode($setting_arr['rate_review']));
$discuss    = stripslashes(html_entity_decode($setting_arr['discuss']));
$profile    = stripslashes(html_entity_decode($setting_arr['profile']));
$rhyming_larics    = stripslashes(html_entity_decode($setting_arr['rhyming_larics']));



///query 2
// if (isset($user_seo) && ($user_seo != "")) {
//     $select_img = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
//     $result_image = $db->get_row($select_img, ARRAY_A);
//     $user_name = $result_image['user_name'];
//     $user_profile = $result_image['user_id'];
//     $date_added_db = $result_image['date_added'];
//     $USER_NAME = $user_name;

//     $main_link = get_user_detail($USER_NAME) . "-profile-";
// } else {

//     $user_profile = session()->get('user_id');
//     $USER_NAME = session()->get('username');
//     $main_link = "";
// }


///query 3
// if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] != "") {
//     $select_notification_count = "select u.user_name,l.like_type,u.profile_image, l.like_id  from  tbl_likes l, tbl_users u  where l.like_from_user_id = u.user_id  AND (l.like_type = 'review_song' OR l.like_type = 'profile' OR l.like_type = 'playlist' OR l.like_type = 'delete_review_song' OR l.like_type = 'admin_review') AND l.like_receive_user = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND l.read_status = 1";
//     $result_notification_count = count($db->get_results($select_notification_count, ARRAY_A));
// }



///query 4
// $setting_qry = "select * from tbl_setting where setting_id='1'";
// $setting_arr    =    $db->get_row($setting_qry, ARRAY_A);
// echo $analaytic    =    $setting_arr['analaytic'];



///query 5
// if ($user_profile != "") {
//     $comment_list_qry = "select count(*) as count_discussion from tbl_comments where comment_user_id = '" . $user_profile . "' order by comment_id desc limit 1";
//     $comment_list_arr    =    $db->get_row($comment_list_qry, ARRAY_A);

//     // recent like pick query
//     $like_list_qry = "select count(*) as count_likes from tbl_likes l, tbl_users u, tbl_reviews r where r.review_user_id = '" . $user_profile . "' AND u.user_id = r.review_user_id AND r.review_id = l.like_id  AND (l.like_type = 'review_song') order by l.id desc limit 1";
//     $like_list_arr    =    $db->get_row($like_list_qry, ARRAY_A);

//     // recent review pick query
//     $review_list_qry = "select count(*) as count_reviews from tbl_users u, tbl_reviews r where u.user_id = r.review_user_id AND r.review_user_id = '" . $user_profile . "' order by r.review_id desc limit 1";
//     $review_list_arr_top    =    $db->get_row($review_list_qry, ARRAY_A);
// }

?>

<header>
    <div class="container pad_left" style="padding-right:8px;"> <a href="" class="logo" style="float:left;"> <img src="images/logo.png" style="margin-bottom:2px;"> </a>
        <div class="mob_elements">
            <p class="mob_search" id="mob_search"> <a href="javascript:void(0)"><i class="fa fa-search" aria-hidden="true"></i></a> </p>
            <p class="mob_navigat" style="margin-right:0; font-size:32px;"> <a href="javascript:void(0)"><i class="fa fa-bars" aria-hidden="true"></i></a> </p>
        </div>
        <div class="head_left" style="float:right;">
            <ul class="topnav" id="nav">
                <li><a href="top-songs">Top Songs</a></li>
                <li><a href="top-albums">Top Albums</a></li>
                <li><a href="latest-songs">Latest Songs</a></li>
                <li><a href="top-artists">Artists</a></li>

            </ul>
            <span class="search_container" id="search_bar">
                <form action="searcher" method="POST">
                    <input class="searcharea" placeholder="Search" name="search" value="" required>
                    <input type="hidden" name="submitbtn" value="Search">
                    <button><i class="sprite sprite-icon_search"></i></button>
                </form>
            </span>
            <ul class="account_nav">
                @if(Auth::check())
                <li><a href="review-artist" class="my-account">MY ACCOUNT</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link href="{{ route('logout') }}" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Logout') }}
                        </x-responsive-nav-link>
                    </form>
                </li>
                <!-- <li id="notification_li" style="text-transform:none;">
                    <?php if (isset($result_notification_count) && ($result_notification_count != 0)) { ?> 
                        <span id="notification_count">
                            <?php
                            echo $result_notification_count;
                            ?>
                        </span>
                    <?php } ?>
                    

                   <?php if (isset($mobile_view) && ($mobile_view == 0)) { ?> 
                        <a href="javascript:;" id="notificationLink" onClick="show_notification()" style="padding-left:0 !important;"><span id="shownotification"> <img src="images/icon_post6.png" style="height:18px; margin:4px 0;" border="0" title="Notification" class="ipad_float"> <b class="mobile-only" style="font-weight: normal; float: left; margin-left: 5px;">NOTIFICATIONS</b></span> </a>
                    <?php } else { ?> 
                        <a href="javascript:;" id="notificationLink" onClick="show_notification()"><span id="shownotification"> <img src="images/icon_post6.png" style="height:18px; margin:4px 0; float:left;" border="0" title="Notification"><b class="mobile-only" style="font-weight: normal; float: left; margin-left: 5px;">NOTIFICATIONS</b></span> </a>
                    <?php } ?>
                    




                    <div id="notificationContainer" style="z-index:999999">
                        <div id="notificationTitle">Notifications <a style="float:right; font-size:10px; font-family:Arial, Helvetica, sans-serif; cursor:pointer;" onClick="remove_all_notifications()" id="removeall">Remove All</a> </div>
                        <div id="notificationsBody" class="notifications" style="float:left; overflow-y: auto; overflow-x: hidden; width:100%; height: 302px;">
                            <div id="loader_new"></div>
                            <div id="notify_list2" class="notification_outer"></div>
                        </div>
                    </div>
                    <div style="clear:both;"></div>
                </li> -->
                @else
                <li> <a href="sign_in" class="signin"> <i class="sprite-new sprite-new-xicon_signin-png-pagespeed-ic-d7QTJCwNDt"></i> Sign In</a> </li>
                <li> <a href="sign_up" class="signup"><i class="sprite-new sprite-new-icon_signup"></i> <span style="margin-left:1px;">Sign UP</span></a> </li>
                @endif
                <li class="mobile_only"> <a href="top-songs">Top Songs</a> </li>
                <li class="mobile_only"> <a href="top-albums">Top Albums</a> </li>
                <li class="mobile_only"><a href="latest-songs">Latest Songs</a> </li>
            </ul>
        </div>
    </div>
</header>