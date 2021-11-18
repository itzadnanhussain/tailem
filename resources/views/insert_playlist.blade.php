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

                    <img onClick="close_popup();" data-dismiss="modal" src="<?php echo SERVER_ROOTPATH; ?>images/crosspng.png" style="float:right; cursor:pointer; margin-top:10px; margin-right:10px;">

                    <div style="margin-top:0;">

                        <!-- <form name="add-playlist" id="add-playlist" method="post" style="padding:10px; padding-top:20px;"> -->
                        <form class="add-playlist" style="padding:10px; padding-top:20px;" action="{{url('process/add_playlist_process')}}">

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
                                <div class="col-lg-12 error_list" id="" style="display:none;">&nbsp;</div>

                            </div>

                            <input type="hidden" name="song_id" value="<?php echo $song_id; ?>">
                            @csrf
                            <input type="hidden" name="art_id" value="<?php echo $art_id; ?>">

                            <input style="margin-top:10px;" type="text" name="playlist_title" class="form-control" placeholder="Your playlist name" value="" autofocus>

                            <a class="playlist_icon" data-title="" data-target="#show_playlist" data-toggle="modal" href="<?php echo SERVER_ROOTPATH; ?>add-playlist?song_id=<?php echo $song_id; ?>&art_id=<?php echo $art_id; ?>" id="autoclick"></a>

                            <button style="margin-top:15px; display:inline; width:40%;" class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
                            <!-- <button id="submit_btn" name="submit" style="margin-top:15px; display:inline; width:40%;" class="btn btn-lg btn-primary btn-block" type="submit" onClick="return add-playlist_validations_new();">Create</button> -->



                            <span style="margin-top:15px; display:inline; width:40%; float:right; background-color:#D73B3B; border-color:#D73B3B;" class="btn btn-lg btn-primary btn-block" type="button" data-dismiss="modal">Cancel</span>
                        </form>
                    </div>
                </div>
            </div>
            </div>
</body>

</html>

<!-- <script type="text/javascript" src="<?php echo COOKIE_FREE_ROOTPATH; ?>js/form_ajax.js"></script> -->
<script>
    $(".add-playlist").submit(function(e) {
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
                        $("#create_playlist").modal("hide");
                        $("#autoclick").trigger("click");
                        break;
                    case "warning":
                        $(".error_list").html(res.message);
                        $(".error_list").show();
                        $(".error_list").fadeOut(10000);
                }
            },
        });
    });
</script>

<script>
    // function add-playlist_validations_new() {

    //     $("#add-playlist").unbind("submit");
    //     var options = {
    //         target: "",
    //         beforeSubmit: validate_playlist_new_Request,
    //         success: validate_playlist_new_Response,
    //         url: JS_SERVER_PATHROOT + "process/add_playlist_process",
    //     };
    //     $("#add-playlist").submit(function() {
    //         $(this).ajaxSubmit(options);
    //         return false;
    //     });
    // }

    // function validate_playlist_new_Request(formData, jqForm, options) {
    //     var queryString = $.param(formData);
    //     return true;
    // }

    // function validate_playlist_new_Response(responseText, statusText) {
    //     if (responseText.search("done") != -1) {
    //         $("#create_playlist").modal("hide");
    //         $("#autoclick").trigger("click");
    //     } else {
    //         $(".error_list").html(responseText);
    //         $(".error_list").show();
    //         $(".error_list").fadeOut(10000);
    //     }
    // }
</script>