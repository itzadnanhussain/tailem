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
							AND rev.review_id = '" . $review_id . "'  
							
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

        @media(max-width:768px) {
            .desktop_width {
                width: 70%;
            }
        }
    </style>
</head>

<body>


    <?php if ($mobile_view == 1) { ?>
        <div class="modal-dialog modal-lg" style="width:95%;  margin-top:20%; background-color:#FFFFFF;">
        <?php } elseif ($mobile_view == 0) { ?>
            <div class="modal-dialog modal-lg desktop_width" style="margin-top:10%;  background-color:#FFFFFF;">
            <?php } ?>
            <div class="modal-content">
                <div class="modal-header" style="padding:0; border-bottom:none; min-height:0;"></div>
            </div>

            <div class="modal-body" style="overflow-y:auto; min-height:250px;">
                <img onClick="close_popup();" data-dismiss="modal" src="<?php echo SERVER_ROOTPATH; ?>images/crosspng.png" style="float:right; cursor:pointer; margin-top:10px; margin-right:10px;">
                <h4 style="font-size:20px; font-weight:normal; margin-bottom:20px;">Thank you</h4>
                <p>Would you like to delete your review? <br /><br /><br /><br />

                </p>

                <form class="process-form" action="<?php echo SERVER_ROOTPATH ?>process/delete_review_process" method="POST">
                    @csrf
                    <input type="hidden" name="review_id" value="<?php echo $review_id ?>">
                    <input type="hidden" name="num" value="<?php echo $num ?>">
                    <button style="margin-top:15px; display:inline; width:40%; float:left; background-color:#D73B3B; border-color:#D73B3B;" class="btn btn-lg btn-primary btn-block" type="submit">Delete</button>


                </form>

                <!-- <button id="delete_btn" name="delete_btn" style="margin-top:15px; display:inline; width:40%; float:left; background-color:#D73B3B; border-color:#D73B3B;" onClick="return review_delete_new(<?php echo $review_id; ?>, <?php echo $num; ?>);" class="btn btn-lg btn-primary btn-block" type="button">Delete</button> -->

                <span id="delete_btn" name="delete_btn" style="margin-top:15px; display:inline; width:40%; float:right;" data-dismiss="modal" class="btn btn-lg btn-primary" type="button">Cancel</span>



            </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $('.process-form').submit(function(e) {
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

                if (res.a == "Please sign in first") {
                    $("#signin_form").modal("show");
                } else {
                    if (res.a.search("done") != -1) {
                        $("#delete_review_" + res.b).hide();
                        // $("#review_delete").modal("show");
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500)
                    } else {
                        alert(res.a);
                    }
                }

            }
        });

    })

     
</script>
<div class="modal fade" id="review_delete" style="display:none" tabindex="-1" role="dialog" aria-labelledby="basicModal">
    <div class="modal-dialog" style="margin-top:10%;">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#3276b1;"> Thank you <img data-dismiss="modal" style="cursor:pointer; float:right;" src="data:image/webp;base64,UklGRg4BAABXRUJQVlA4TAIBAAAvFUAFEE+hkI0kqAqrcP6Sr4OCtm0Y7/PnNVACgRSnsMJq2khyoyNdDu1R+eoVtm2DdMy7wwMOWQ3Bh2BH40FwEAgKBUFB9pdU1E06UpGKjl4fHEa2rTQPd3duDE1e/w0i70NKiOh/kjD9OOu3LPZNutDDBkoT6iStFJepRadd4qa0addS3KYabSH+CMmocQ7riG1Z3zhrw4V4/Pg58ALpx5ADz19+Q8YFlC9vM5SqgTLw9oTSNVDWH09Q2gJy4PnLL8gihnj8+DnwAhl7EBNP2L78gfCNBuKB4wHRGBTij5A2LcNtptNuV7ipbDqdFJepQ1KPGihNpNOFGSQ5tjwJTBI=" data-pagespeed-url-hash="3119113509" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                </h4>
            </div>
            <div class="modal-body" style="overflow-y:auto; min-height:250px;">
                <p>
                    Your review has been deleted. <br /><br /><br />

                    Warmest Regards,<br />
                    Team at Tailem.com
                </p>
            </div>
        </div>
    </div>
</div>

</html>

