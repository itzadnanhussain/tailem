<?php
//include("common/top_script_files.php");

$qry = "select rev.review_title, rev.review_id, rev.review_detail,rev.review_rating,rev.review_post_date , s.song_seo,a.artist_seo
							from tbl_artist_album b, tbl_artists a, tbl_songs s, tbl_reviews rev, tbl_users u 
							where 1=1 
							AND s.id = rev.song_id 
							AND a.id = rev.artist_id 
							AND b.id = rev.album_id 
							AND u.user_id = rev.review_user_id 
							AND rev.review_user_id = '" . $user_id . "'  
							AND rev.review_id = '" . $rev_id . "'  
							
							order by rev.review_id desc";


$review_like_info    =    \App\Models\Songs::GetRawData($qry);

$review_like_info = (array)$review_like_info[0];

$review_id            = $review_like_info['review_id'];
$review_title      = $review_like_info['review_title'];
$review_detail      = $review_like_info['review_detail'];
$review_rating      = $review_like_info['review_rating'];
$song_seo_name      = $review_like_info['song_seo'];
$artist_seo_name  = $review_like_info['artist_seo'];

?>
<html>

<head>
    <!--<link rel="stylesheet" type="text/css" href="css/form.css">-->
    <!-- <link rel="stylesheet" href="css/star-rating.css" media="all" type="text/css"/>-->
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

                    <img onClick="close_popup();" data-dismiss="modal"
                        src="<?php echo SERVER_ROOTPATH; ?>images/crosspng.png"
                        style="float:right; cursor:pointer; margin-top:10px; margin-right:10px;">

                    <div style="margin-top:0;">
                        <form id="api-readonlys" method="post"
                            action="<?php echo SERVER_ROOTPATH ?>process/write_a_review"
                            style="padding:10px; padding-top:20px;" novalidate>
                            <h4 style="font-size:20px; font-weight:normal; margin-bottom:20px;"> Edit your Review
                                <?php
                                if (!$review_like_info) {
                                    echo "Please update your own Review.";
                                    exit;
                                }
                                ?>
                            </h4>
                            @csrf
                            <input name="api-readonly-test" style="font-size: 1.3em;" id="input-21b"
                                value="<?php echo $review_rating; ?>"
                                type="number" class="rating" min=0 max=10 step=0.5 data-size="xs" data-stars="10">
                            <input type="hidden" name="song_seo_name"
                                value="<?php echo $song_seo_name; ?>">
                            <input type="hidden" name="artist_seo_name"
                                value="<?php echo $artist_seo_name; ?>">

                            <input style="margin-top:10px;" type="text" name="review_title" class="form-control"
                                placeholder="Review Title" id="review_title"
                                value="<?php echo $review_title; ?>"
                                autofocus>

                            <input type="hidden" name="reviewsid" id="reviewsid"
                                value="<?php echo $rev_id; ?>" />
                            <input type="hidden" name="num" id="num"
                                value="<?php echo $num; ?>" />
                            <textarea style="margin-top:10px;" class="form-control" id="review_detail"
                                name="review_detail" placeholder="Review Detail"
                                rows="6"><?php echo $review_detail; ?></textarea>

                            <input type="hidden" name="edit_id"
                                value="<?php echo $review_id; ?>" />

                            <!-- <button id="submit_btn" name="submit" style="margin-top:15px; display:inline; width:40%;" class="btn btn-lg btn-primary btn-block" type="submit" onClick="return write_a_review_validations_new();">Update</button> -->
                            <button id="submit_btn" name="submit" style="margin-top:15px; display:inline; width:40%;"
                                class="btn btn-lg btn-primary btn-block" type="submit">Update</button>
                            <!--   
                <button id="delete_btn" name="delete_btn" style="margin-top:15px; display:inline; width:40%; float:right; background-color:#D73B3B; border-color:#D73B3B;" onClick="return review_delete(<?php echo $review_id; ?>);"
                            class="btn btn-lg btn-primary btn-block" type="button">Delete</button>
                            -->

                            <a href="<?php echo SERVER_ROOTPATH; ?>delete_review?review_id=<?php echo $review_id; ?>&num=<?php echo $num; ?>&critaria=1"
                                data-toggle="modal"
                                data-target="#delete_review_<?php echo $num; ?>"
                                data-title="" data-dismiss="modal" class="link-disable">
                                <span
                                    style="margin-top:15px; display:inline; width:40%; float:right; background-color:#D73B3B; border-color:#D73B3B;"
                                    class="btn btn-lg btn-primary btn-block" type="button">Delete</span>
                            </a>

                        </form>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>

<div class="modal fade" id="show_success_message_song" style="display:none" tabindex="-1" role="dialog"
    aria-labelledby="basicModal">
    <div class="modal-dialog" style="margin-top:10%;">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#3276b1;"> Thank you for your review <img data-dismiss="modal"
                        style="cursor:pointer; float:right;"
                        src="data:image/webp;base64,UklGRg4BAABXRUJQVlA4TAIBAAAvFUAFEE+hkI0kqAqrcP6Sr4OCtm0Y7/PnNVACgRSnsMJq2khyoyNdDu1R+eoVtm2DdMy7wwMOWQ3Bh2BH40FwEAgKBUFB9pdU1E06UpGKjl4fHEa2rTQPd3duDE1e/w0i70NKiOh/kjD9OOu3LPZNutDDBkoT6iStFJepRadd4qa0addS3KYabSH+CMmocQ7riG1Z3zhrw4V4/Pg58ALpx5ADz19+Q8YFlC9vM5SqgTLw9oTSNVDWH09Q2gJy4PnLL8gihnj8+DnwAhl7EBNP2L78gfCNBuKB4wHRGBTij5A2LcNtptNuV7ipbDqdFJepQ1KPGihNpNOFGSQ5tjwJTBI="
                        data-pagespeed-url-hash="3119113509"
                        onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                </h4>
            </div>
            <div class="modal-body" style="overflow-y:auto; min-height:250px;">
                <p>
                    Your review has been posted and will appear shortly. Thank you for sharing your thoughts and we
                    value your contributions to our site. <br /><br /><br />

                    Warmest Regards,<br />
                    Team at Tailem.com
                </p>
            </div>
        </div>
    </div>
</div>





<script src="<?php echo SERVER_ROOTPATH ?>js/star-rating.js"
    type="text/javascript"></script>
<script type="text/javascript">
    // function close_popup() {
    //     $(document).on('hidden.bs.modal', function(e) {
    //         $(e.target).removeData('bs.modal');

    //     });
    // }
</script>
<script>
    $('#api-readonlys').submit(function(e) {


        e.preventDefault();
        e.stopPropagation();
        let form = $(this).serialize();
        let url = $(this).attr('action');

        $.ajax({
            type: 'POST',
            url: url,
            data: form,
            dataType: 'html',
            success: function(data) {
                let res = JSON.parse(data);
                $("#edit_Modal4_1").modal('hide');
                switch (res.code) {
                    case 'success':
                        // this.modal("hide"); 
                        $("#report_edit_success").modal('show');
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                        $("#api-readonly").each(function() {
                            this.reset();
                        });


                        break;
                    case 'warning':
                        if (res.message == "Please sign in first.") {
                            $("#signin_form").modal("show");
                        } else if (
                            res.message ==
                            "You have already posted a review on this song. Please use the EDIT function to revise your review."
                        ) {
                            $("#already_review").modal("show");
                        } else {
                            $("#error_popup").modal("show");
                            $("#modal_title_error").html("Thank you");
                            responseText = res.message.replace(/\n/g, "<br />");
                            $("#modal_body_error").html(responseText);
                        }

                }
            }
        });

    })
</script>