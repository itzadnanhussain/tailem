<!-- <h2 class="mt-0 pull-left display_dekstop">  
     
<?php if ($main_link != "") {
} else {
    echo "Welcome";
} ?>
 <?php echo $user_name; ?></h2>  -->
<?php

if ($main_link == "") {
    if ($mobile_view == 0) {
?>
        <div class="text_12 review_ipad" style="margin-top:5px;">
            <a href="<?php echo SERVER_ROOTPATH; ?>change-picture" style="color:#000000;"><i class="fa fa-camera text_red"></i> Edit Picture</a>
            <?php if ($mobile_view == 1) { ?> &nbsp;&nbsp; | &nbsp;&nbsp; <?php } else { ?> <br> <?php } ?>
            <a href="<?php echo SERVER_ROOTPATH; ?>change-password" style="color:#000000;"><i class="fa fa-key text_red"></i> Edit Password</a>

            <?php if ($mobile_view == 1) { ?> &nbsp;&nbsp; | &nbsp;&nbsp; <?php } else { ?> <br> <?php } ?>
            <a href="<?php echo SERVER_ROOTPATH; ?>change-username" style="color:#000000; float:left;"> <i class="fa fa-user text_red" style="margin-right:3px;"></i>&nbsp;Edit Username</a>
            <?php if ($mobile_view == 1) { ?> &nbsp;&nbsp; | &nbsp;&nbsp; <?php } else { ?> <br> <?php } ?>
            <a href="<?php echo SERVER_ROOTPATH;?>update-profile-social-icon" style="color:#000000; float:left;"><i class="fa fa-arrow-circle-right text_red" style="margin-right:3px;"></i>&nbsp;Edit Social Media</a>
            <?php if ($mobile_view == 1) { ?> &nbsp;&nbsp; | &nbsp;&nbsp; <?php } else { ?> <br> <?php } ?>
            <a href="javascript:void(0)" onclick="Delete_User('<?php echo session()->get('user_id') ?>')" style="color:#000000; float:left;color: #d73b3b;"><i class="fa fa-trash-o text_red" style="margin-right:3px;color: #d73b3b;"></i>&nbsp;Delete Account</a>

        </div>


    <?php
    } else
					if ($mobile_view == 1) {
    ?>
        <div class="text_12" style="margin-top:5px; float:left;">
            <a href="<?php echo SERVER_ROOTPATH; ?>change-picture" style="color:#000000;"><i class="fa fa-camera text_red"></i> Edit Picture</a>
            &nbsp;&nbsp; | &nbsp;&nbsp;
            <a href="<?php echo SERVER_ROOTPATH; ?>change-password" style="color:#000000;"><i class="fa fa-key text_red"></i> Edit Password</a>
            &nbsp;&nbsp; | &nbsp;&nbsp;
            <a href="<?php echo SERVER_ROOTPATH; ?>change-username" style="color:#000000; margin-top:-3px;"> <i class="fa fa-user text_red" style="margin-right:3px;"></i>&nbsp;Edit Username</a>
            <a href="<?php echo SERVER_ROOTPATH; ?>update-profile-social-icon" style="color:#000000; margin-top:-3px;"> <i class="fa fa-arrow-circle-right text_red" style="margin-right:3px;"></i>&nbsp;Edit Social Media</a>
            <a href="javascript:void(0)" onclick="Delete_User('<?php echo session()->get('user_id') ?>')" style="color:#000000; margin-top:-3px;color: #d73b3b;"> <i class="fa fa-trash-o text_red" style="margin-right:3px;color: #d73b3b;"></i>&nbsp;Delete Account</a>

        </div>
    <?php
    }
    ?>

<?php
}
?>