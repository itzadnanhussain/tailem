@include('common.header')
<!-- ./Header end -->

<?php
error_reporting(0);
if (isset($get_user_content) && !empty($get_user_content)) {
    $artist_list = "select * from tbl_artists where artist_status = 1 AND popular_artist = 1 order by rand() limit 3";
    $artist_list_arr = \App\Models\Songs::GetRawData($artist_list);
    
    $qry_welcome = "SELECT * FROM  tbl_pages WHERE page_id ='9'";
    $get_welcome = \App\Models\Songs::GetRawData($qry_welcome);

    if ($get_welcome) {
        $get_welcome = (array) $get_welcome[0];
        $temp_subject = html_entity_decode(stripslashes($get_welcome['page_headertitle']));
        $msg_body = html_entity_decode(stripslashes($get_welcome['page_content']));
    }

    $link = "<a href=\"" . SERVER_ROOTPATH . "contact-us.html\">" . "link</a>";

    $msg_body = str_replace('{USERNAME}', $get_user_content['user_name'], $msg_body);
    $msg_body = str_replace('{LINK}', $link, $msg_body);
}  ?>


<!-- Middle Section -->
<style>
    section.middle_sec { 
    top: 58px !important;
}
</style>
<section class="middle_sec">
    <div class="topRwHead-bodyPan">
        <div class="container" style="padding:0;">

            <div class="topRwHead-panel" style="margin:12px 0 !important; padding-bottom:0; padding-top:10px;">
                <div class="col-lg-8 col-md-6" style="margin-bottom:0px">
                    <div class="col-sm-6 artist-img-panel" style="padding:0;">

                    </div>
                    <div class="col-lg-12 col-sm-12 desc-panel">
                        <h1 style="text-transform:none;" class="h1"><span class="text_grey"><?php echo $temp_subject; ?></span> to Tailem.com</h1>
                        <p></p>

                        <!--<p style="min-height:110px;">"See You Again" is a hip hop song recorded by American rapper Wiz Khalifa featuring American singer Charlie Puth for the soundtrack of the 2015 action film, Furious </p>-->
                        <p style="width:100%;">
                            <?php echo $msg_body; ?>
                            <!-- Thank you <a> <?php echo $get_user_content['user_name']; ?> </a> for becoming a member of Tailem.com, one of the fastestgrowing music review websites in the world. We hope you enjoy your experience with us and within our community. We wouod love for you to share your thoughts on the music that matters most to you.</p> 
                        
                        <p>Also, your feedback is very important to us. Please use this <a href="<?php echo SERVER_ROOTPATH; ?>contact-us">link </a> to voice your concerns.-->
                        </p>
                        <div class="clearfix"></div>
                        <br>
                        <div class="heading" style="padding: 0px 20px; margin-left:-31px;">
                            <p><strong class="Oswald mr-30">&nbsp;&nbsp;Please also find us on</strong>
                                <?php
                                $social_query  = "Select * from tbl_social_links ";
                                $arr_social = \App\Models\Songs::GetRawData($social_query);
                                $arr_social = (array)$arr_social[0];
                                ?>
                                <a href="<?php echo $arr_social['facebook']; ?>"> <img src="<?php echo SERVER_ROOTPATH; ?>images/icon_fb.png"></a>
                                <a href="<?php echo $arr_social['twitter']; ?>"> <img src="<?php echo SERVER_ROOTPATH; ?>images/tww.png"></a>
                                <a href="<?php echo $arr_social['google']; ?>"> <img src="<?php echo SERVER_ROOTPATH; ?>images/gplus.png"></a>
                            </p>

                        </div>
                        <br><br>
                        <p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; letter-spacing: 0.5px; line-height: 1.5em; word-spacing: 0.5px; text-align: justify; font-size: 13px; color: rgb(68, 68, 68); font-family: Montserrat, sans-serif;">Warmest regards,<br>Team at Tailem.com</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-lg-4 col-md-6 ">

                    <?php echo ads_info('Right'); ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php


            if (isset($artist_list_arr)) {
                $m = 1; ?>
                <div class="topRwContent-panel" style="margin-bottom:15px;">
                    <div style="clear: both"></div>
                    <div class="heading">
                        Top Artists
                    </div>
                    <div class="related-song-pan">
                        <?php
                        foreach ($artist_list_arr as $val) {
                            $val = (array)$val;
                            $id                         = $val['id'];
                            $artist_name           = stripslashes(html_entity_decode($val['artist_name']));
                            $artist_seo              = stripslashes(html_entity_decode($val['artist_seo']));
                            $artist_img            = stripslashes(html_entity_decode($val['artist_img']));
                            $artist_description   = stripslashes(html_entity_decode($val['artist_description']));
                            $status                 = $val['artist_status'];
                            $posted_date             = $val['posted_date'];
                            $artist_name = wordwrap($artist_name, 100, " ", true);

                            // $counter_main =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'artist' AND like_id = '$id'"));

                            $counter_main = array();
                            $counter_main = \App\Models\Songs::GetRawData("select id from tbl_likes where like_type = 'artist' AND like_id = '$id'");
                            if ($counter_main) {
                                $counter_main = count($counter_main);
                            } else {
                                $counter_main = 0;
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
                            if ($all_avg >= 4 && $all_avg <= 6) {
                                $color_pick = "#e06d21";
                            }
                            if ($all_avg >= 0 && $all_avg <= 3) {
                                $color_pick = "#dd554e";
                            }

                        ?>
                            <div class="col-sm-4">
                                <div class="song-img-banner">
                                    <div class="latestsongssec" style="width:100%;">
                                        <div class="list_item">
                                            <div class="album_cover">
                                                <!-- <a href="#"><img src="<?php echo SERVER_ROOTPATH; ?>images/img-1.jpg" class="img-responsive  artist-img"></a>-->
                                                <?php if ($artist_img != "") {
                                                    $img_api_linka = album_img_api($artist_img);
                                                    if ($img_api_linka != '') { ?>
                                                        <img src="<?php echo $artist_img; ?>" border="0" title="<?php echo $artist_name; ?>" />
                                                    <?php } else { ?>
                                                        <img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo '' . $artist_img; ?>" border="0" title="<?php echo $artist_name; ?>" />
                                                    <?php
                                                    }
                                                } else
											if ($artist_img == "") {
                                                    $req_artist  =  artist_func(urlencode("$artist_name"));
                                                    if ($req_artist['artist_array']['image4'] != "") {
                                                    ?>
                                                        <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>"><img class="img-responsive" src="<?php echo $req_artist['artist_array']['image4']; ?>" border="0" /></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" class="img-responsive" border="0" title="<?php echo $artist_name; ?>" />
                                                <?php
                                                    }
                                                } ?>
                                                <!-- <cite style="background-color:#dd554e">0.5</cite>
                                                 -->

                                                <?php if ($all_avg != 0) {
                                                ?><cite class="score" style="background-color:<?php echo $color_pick; ?>"><?php if ($all_avg < 10) {
                                                                                                                                echo number_format($all_avg, 1);
                                                                                                                            } else {
                                                                                                                                echo $all_avg;
                                                                                                                            } ?></cite><?php } else { ?> <cite style="background-color:#dd554e;">0.0</cite><?php } ?>
                                            </div>
                                            <div class="list_bottom" style="padding-bottom:0;">
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-8 col-sm-6 col-xs-7">
                                                        <a href="<?php echo SERVER_ROOTPATH . $artist_seo . "/artist-songs"; ?>">
                                                            <cite2 style="margin:2px;"><?php echo $artist_name; ?></cite>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-5 col-md-4 col-sm-6 col-xs-5" style="bottom:4px;">
                                                        <!--<span class="like-group" style="float:right;"><a href="#"><i class="fa fa-heart-o heart_color heart_size"></i> </a><a href="#" class="like link-disable" style="margin-left:4px;color:#fff;">1 Likes</a></span>-->
                                                        <?php
                                                        if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] != "") {
                                                            // $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$id'"));
                                                            $counter = \App\Models\Songs::GetRawData("select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$id'");
                                                            if ($counter) {
                                                                $counter = count($counter);
                                                            } else {
                                                                $counter = 0;
                                                            }
                                                            if ($counter == 0) { ?>
                                                                <span id="other_dis_<?php echo $id; ?>" class="like-group" style="float:right;"><a href="javascript:;" onClick="add_in_favourite_list('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $m; ?>')" class="like"><i class="fa fa-heart-o heart_color heart_size"></i></a><span style="color:#FFFFFF;"> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="margin-left:4px; color:#FFFFFF;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo "Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo "Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                                <span class="like-group" style="float:right;" id="myStyle_<?php echo $id; ?>"></span> <?php } else { ?>
                                                                <span id="other_dis_<?php echo $id; ?>" class="like-group" style="float:right;"><a href="javascript:;" onClick="add_in_favourite_list('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $m; ?>')" class="like"><i class="fa fa-heart" style="font-size:24px; color:#D73B3B;"></i></a><span style="color:#FFFFFF;"> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="margin-left:4px; color:#FFFFFF;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo "Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo "Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                                <span class="like-group" style="float:right;" id="myStyle_<?php echo $id; ?>"></span>
                                                            <?php
                                                                                                                                                    }
                                                                                                                                                } else { ?>
                                                            <span id="other_dis_<?php echo $id; ?>" class="like-group" style="float:right;"><a href="javascript:;" onClick="add_in_favourite_list('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $m; ?>')" class="like"><i class="fa fa-heart-o heart_color heart_size"></i> </a><span style="color:#FFFFFF;"> <?php echo $counter_main; ?></span><a href="<?php echo SERVER_ROOTPATH; ?>like/detail?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="margin-left:4px; color:#FFFFFF;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo "Like";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo "Likes";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?></a></span>
                                                            <span class="like-group" style="float:right;" id="myStyle_<?php echo $id; ?>"></span> <?php
                                                                                                                                                }
                                                                                                                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                    <?php
                            $m++;
                        }
                    } else {
                        echo "No Record Found";
                    }
                    ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
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
        </div>
    </div>
</section>

<style>
    body {
        overflow-x: hidden;
    }
</style>
<style>
    .text_grey {
        color: #999 !important;
        text-decoration: none;
    }

    .h1 {
        font-size: 26px;
        margin-top: 0;
        text-transform: uppercase;
        /* font-family: 'Oswald', sans-serif;*/
        font-family: "Montserrat", sans-serif;
        padding: 0;
        margin-top: 2px !important;
        margin-bottom: 3px !important;
        margin-right: 0px !important;
        margin-left: 0px !important;
        color: #000;
        font-weight: 400;
    }

    p {
        /* margin: 0 0 10px;
    letter-spacing: 0.5px;
    line-height: 1.5em;
    padding: 0;
    word-spacing: 0.5px;
    
	font-size: 13px !important;*/
        text-align: justify;

    }

    .text_16 {
        font-size: 16px;
    }

    .album_cover img {
        height: 200px;
    }
</style>

@include('common.footer')

<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
$kval = 2;
for ($u = 1; $u <= $kval; $u++) {
?>
    <div class="modal fade" id="missing_store_detail_Modal2_<?php echo $u; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<?php
}
?>
	<link rel="stylesheet" type="text/css" href="<?php echo COOKIE_FREE_ROOTPATH; ?>css/style-update.css?id=<?php echo rand(111111, 9999999); ?>">
