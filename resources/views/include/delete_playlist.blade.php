<?php
error_reporting(0);
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
                <img onClick="close_review_popup();" data-dismiss="modal" src="<?php echo SERVER_ROOTPATH; ?>images/crosspng.png" style="float:right; cursor:pointer; margin-top:10px; margin-right:10px;">
                <h4 style="font-size:20px; font-weight:normal; margin-bottom:20px;">Thank you</h4>
                <p>Would you like to delete your playlist? <br /><br /><br /><br />

                </p>

                <?php
                if ($p != '') {
                } else {
                    $p = 'n';
                }
                ?>

                <button id="delete_btn" name="delete_btn" style="margin-top:15px; display:inline; width:40%; float:left; background-color:#D73B3B; border-color:#D73B3B;" onClick="return playlist_delete(<?php echo $_REQUEST['edit_id']; ?>, '<?php echo $p; ?>');" class="btn btn-lg btn-primary btn-block" type="button">Delete</button>

                <span id="delete_btn" name="delete_btn" style="margin-top:15px; display:inline; width:40%; float:right;" data-dismiss="modal" class="btn btn-lg btn-primary" type="button">Cancel</span>



            </div>
          
</body>

</html>