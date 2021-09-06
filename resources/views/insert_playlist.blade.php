<?php
// include("common/topfile.php");
//include("common/top_script_files.php");

$like_review_query = "select song_title, song_seo from tbl_songs
							where 1=1 
							AND id = '" . $song_id . "'  
							";


$review_like_info = \App\Models\Songs::GetRawData($like_review_query);
$review_like_info = (array)$review_like_info[0];
// echo '<pre>';
// print_r($review_like_info);
// echo '</pre>';
// die;

$song_seo            = $review_like_info['song_seo'];
$song_title      = $review_like_info['song_title'];

$mobile_view = 0;


?>
<html>

<head>

    <style>
        .desktop_width {
            width: 50%;
        }

        .caption {
            display: none !important;
        }

        @media(max-width:768px) {
            .desktop_width {
                width: 70%;
            }
        }
    </style>
</head>

<body>

    <?php if ($mobile_view == 1) { ?>
        <div class="modal-dialog modal-lg" style="width:95%;  margin-top:20%;">
        <?php } elseif ($mobile_view == 0) { ?>
            <div class="modal-dialog modal-lg desktop_width" style="margin-top:10%;">
            <?php } ?>
            <div class="modal-content">
                <div class="modal-header" style="padding:0; border-bottom:none; min-height:0;">
                </div>
                <div class="modal-body" style="padding:0; border:2px solid #666;">

                    <img onClick="close_review_popup();" data-dismiss="modal" src="<?php echo SERVER_ROOTPATH; ?>images/crosspng.png" style="float:right; cursor:pointer; margin-top:10px; margin-right:10px;">

                    <div style="margin-top:0;">

                        <form name="add_playlist" id="add_playlist" method="post" style="padding:10px; padding-top:20px;">

                            <h4 style="font-size:20px; font-weight:normal; margin-bottom:20px;">
                                <?php
                                if (!$review_like_info) {
                                    echo "Invalid song.";
                                    exit;
                                }
                                ?>
                                Create New Playlist
                            </h4>

                            <div class="row error">
                                <div class="col-lg-12" id="error_list" style="display:none;">&nbsp;</div>

                            </div>
                           
                            <input type="hidden" name="song_id" value="<?php echo $song_id; ?>">
                            @csrf
                            <input type="hidden" name="art_id" value="<?php echo $art_id; ?>">

                            <input style="margin-top:10px;" type="text" name="playlist_title" class="form-control" placeholder="Your playlist name" value="" autofocus>

                            <a class="playlist_icon" data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add-playlist?song_id=<?php echo $song_id; ?>&art_id=<?php echo $art_id; ?>" id="autoclick"></a>

                            <button id="submit_btn" name="submit" style="margin-top:15px; display:inline; width:40%;" class="btn btn-lg btn-primary btn-block" type="submit" onClick="return add_playlist_validations_new();">Create</button>



                            <span style="margin-top:15px; display:inline; width:40%; float:right; background-color:#D73B3B; border-color:#D73B3B;" class="btn btn-lg btn-primary btn-block" type="button" data-dismiss="modal">Cancel</span>
                        </form>
                    </div>
                </div>
            </div>
            </div>
</body>

</html>