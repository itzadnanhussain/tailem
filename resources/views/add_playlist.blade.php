<?php
// include("common/topfile.php");
// include("common/function.php");
$mobile_view = 0;

$review_like_info = "select song_title, song_seo from tbl_songs
							where 1=1 
							AND id = '" . $song_id . "'  
							";


// $review_like_info	=	$db->get_row($like_review_query,ARRAY_A);
$review_like_info = \App\Models\Songs::GetRawData($review_like_info);
$review_like_info = (array)$review_like_info[0];

$song_seo            = $review_like_info['song_seo'];
$song_title      = $review_like_info['song_title'];


?>
<html>

<head>
    <!--<link rel="stylesheet" type="text/css" href="css/form.css">-->
    <link rel="stylesheet" href="css/star-rating.css" media="all" type="text/css" />
    <style>
        .desktop_width {
            width: 50%;

        }

        .caption {
            display: none !important;
        }

        .create_playlist {
            float: left;
            width: 32% !important;
            margin-bottom: 10px;
            background-color: green;
            color: #FFFFFF;
        }

        .btn:hover {
            color: #FFFFFF;
        }

        @media(max-width:768px) {
            .desktop_width {
                width: 70%;
            }

            .create_playlist {
                float: left;
                width: 48% !important;
                margin-bottom: 10px;
                background-color: green;
                color: #FFFFFF;
            }

            .btn:hover {
                color: #FFFFFF;
            }
        }
    </style>
</head>

<body>

    <?php if ($mobile_view == 1) { ?>
    <div class="modal-dialog modal-lg" style="margin-top:20%;">
        <?php } elseif ($mobile_view == 0) { ?>
        <div class="modal-dialog modal-md" style="margin-top:10%;">
            <?php } ?>
            <div class="modal-content">
                <div class="modal-header" style="padding:0; border-bottom:none; min-height:0;">
                </div>
                <div class="modal-body"
                    style="padding:0px; overflow-x:hidden; overflow-y:auto; height:auto; max-height:550px;">

                    <img onClick="close_popup();" data-dismiss="modal"
                        src="<?php echo SERVER_ROOTPATH; ?>images/crosspng.png"
                        style="float:right; cursor:pointer; margin-top:10px; margin-right:10px;">

                    <div style="margin-top:0;">
                        <form name="add_to_playlist" id="add_to_playlist" method="post"
                            action="{{url('process/add_songto_playlist_process')}}"
                            style="padding:10px; padding-top:20px;">
                            <input type="hidden" name="song_id"
                                value="<?php echo $song_id; ?>">
                            <input type="hidden" name="art_id"
                                value="<?php echo $art_id; ?>">
                            @csrf
                            <h4 style="font-size:20px; font-weight:normal; margin-bottom:20px; width:95%;">
                                <?php
                                if (!$review_like_info) {
                                    echo "Invalid song.";
                                    exit;
                                }
                                ?>
                                Add <a style="color:#d73b3b;"><?php echo StringReplace($song_title); ?></a>
                                to Playlist
                            </h4>
                            <a data-title="" data-target="#create_playlist" data-dismiss="modal" data-toggle="modal"
                                href="<?php echo SERVER_ROOTPATH; ?>insert-playlist?song_id=<?php echo $song_id; ?>&art_id=<?php echo $art_id; ?>"
                                class="btn btn-md  btn-block create_playlist">Create new playlist</a>
                            <div class="clear"></div>
                            <div class="row error">
                                <div class="col-lg-12 error_list" style="display:none;">&nbsp;</div>
                                <div class="col-lg-12 success_list" id="" style="display:none; color:Green;">&nbsp;
                                </div>
                            </div>
                            <?php
                            $_SESSION[USER_SESSION_ARRAY]['USER_ID'] = session()->get('user_id');
                            $playlist_arr =  playlist_for_user($_SESSION[USER_SESSION_ARRAY]['USER_ID']);




                            if (isset($playlist_arr) && !empty($playlist_arr)) {
                                $query_check  = "select playlist_id from tbl_user_playlist_songs where song_id  = '" . $song_id . "' AND artist_id   = '" . $art_id . "' AND user_id  = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "'";
                                // $db_playlist_arr	=	$db->get_results($query_check,ARRAY_A);
                                $db_playlist_arr = \App\Models\Songs::GetRawData($query_check);
                                if ($db_playlist_arr) {
                                    $h = 0;
                                    foreach ($db_playlist_arr as $rowinfo) {
                                        $rowinfo = (array)$rowinfo;
                                        $my_playlist[$h] = $rowinfo['playlist_id'];
                                        $h++;
                                    }
                                }

                                foreach ($playlist_arr as $arr_playlist) {
                                    $arr_playlist = (array)$arr_playlist;
                                    // [id] => 81
                                    // [title_playlist] => adnan
                                    // [title_playlist_seo] => adnan
                                    // [user_id_playlist] => 1
                                    // [song_id] => 1091312520
                                    // [artist_id] => 313648
                                    // [posted_date] => 2021-09-06 10:55:49?>
                            <?php if (isset($my_playlist)) { ?>
                            <div class="row">
                                <div class="col-md-12" style="margin:5px 0 5px 0">
                                    <input type="checkbox" name="playlist_arr[]"
                                        value="<?php echo $arr_playlist['id']; ?>"
                                        style="margin-top:-1px;" <?php if (in_array($arr_playlist['id'], $my_playlist, true)) {
                                        ?>
                                    checked<?php
                                    }
                                                                                                                                                                                ?>>
                                    <?php echo stripslashes($arr_playlist['title_playlist']); ?>
                                    <!-- <input type="hidden" name="playlist_title" value="<?php echo stripslashes($arr_playlist['title_playlist']); ?>">
                                    -->
                                </div>
                            </div>
                            <?php } else { ?>
                            <div class="row">
                                <div class="col-md-12" style="margin:5px 0 5px 0">
                                    <input type="checkbox" name="playlist_arr[]"
                                        value="<?php echo $arr_playlist['id']; ?>"
                                        style="margin-top:-1px;">
                                    <?php echo stripslashes($arr_playlist['title_playlist']); ?>
                                    <!-- <input type="hidden" name="playlist_title" value="<?php echo stripslashes($arr_playlist['title_playlist']); ?>">
                                    -->

                                </div>
                            </div>
                            <?php } ?>


                            <?php
                                } ?>
                            <!-- <button id="submit_btn" name="submit" style="margin-top:15px; display:inline; width:40%;" class="btn btn-md btn-primary btn-block" type="submit" onClick="return add_songto_playlist_validations_new();">Add to Playlist</button> -->
                            <button style="margin-top:15px; display:inline; width:40%;"
                                class="btn btn-md btn-primary btn-block" type="submit">Add to Playlist</button>



                            <span
                                style="margin-top:15px; display:inline; width:40%; float:right; background-color:#D73B3B; border-color:#D73B3B;"
                                class="btn btn-md btn-primary btn-block" type="button"
                                data-dismiss="modal">Cancel</span>
                            <?php
                            }


                            ?>




                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
        <!-- <script src="js/star-rating.js" type="text/javascript"></script> -->
        <script type="text/javascript">
            // function close_popup() {
            //     $(document).on('hidden.bs.modal', function(e) {
            //         $(e.target).removeData('bs.modal');

            //     });
            // }
        </script>
        <script>
            $("#add_to_playlist").submit(function(e) {
                e.preventDefault();
                e.stopPropagation();
                let form = $(this).serialize();
                let url = $(this).attr("action");
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form,
                    dataType: "html",
                    success: function(data) {
                        let res = JSON.parse(data);
                        switch (res.code) {
                            case "success":
                                $(".error_list").hide();
                                $(".success_list").html(res.message);
                                $(".success_list").show();
                                myVar = setTimeout(function() {
                                    $(".success_list").fadeOut();
                                }, 5000);
                                break;
                            case "warning":
                                $(".success_list").hide();
                                $(".error_list").html(res.message);
                                $(".error_list").show();
                                myVar = setTimeout(function() {
                                    $(".error_list").fadeOut();
                                }, 5000);
                        }
                    },
                });
            });
        </script>
</body>

</html>