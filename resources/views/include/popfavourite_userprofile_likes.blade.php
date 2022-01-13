<?php
     

    if ($user_id=="") {
        echo "Please sign in first";
        exit;
    }

    if ($user_id==$prod_id) {
        echo "aa";
        exit;
    }

    $qry =   "select id from tbl_likes where like_type = 'profile' AND like_id = '$prod_id'";
    $counter_main = array();
    $counter_main = \App\Models\Songs::GetRawData($qry);
    
    if ($counter_main) {
        $counter_main = count($counter_main);
    } else {
        $counter_main = 0;
    }
     
    $qry =   "select id from tbl_likes where like_from_user_id = '".$user_id."' AND like_type = 'profile' AND like_id = '$prod_id'";
    $counter = array();
    $counter = \App\Models\Songs::GetRawData($qry);
    if ($counter) {
        $counter = count($counter);
    } else {
        $counter = 0;
    }
    if ($counter==0) {
        $date = date("Y-m-d");
        $user_id  =  $user_id;
        $sql = "INSERT INTO tbl_likes (like_id, like_type, date, like_from_user_id, like_receive_user) VALUES ($prod_id, 'profile', '$date', $user_id,$prod_id)";
        $rsd =\App\Models\Songs::GetRawData($sql); ?>
<a href="javascript:;"
    onClick="add_in_favourite_user_profile_popup(<?php echo $prod_id; ?>,<?php echo $sr_no; ?>)"
    class="like"><i class="fa fa-heart" style="font-size:24px; color:#D73B3B;"></i></a> <span style="color:#D73B3B;">
    <?php echo $counter_main + 1; ?></span><a
    style="text-decoration:none; color:#000000;"><?php if (($counter_main + 1)<2) {
            echo " Like";
        } else {
            echo " Likes";
        } ?>
</a>

<?php
    } else {
        \App\Models\Songs::GetRawData("Delete from tbl_likes where like_from_user_id = '".$user_id."' AND like_id = $prod_id AND like_type = 'profile'"); ?>

<a href="javascript:;"
    onClick="add_in_favourite_user_profile_popup(<?php echo $prod_id; ?>,<?php echo $sr_no; ?>)"
    class="like"><i class="fa fa-heart-o" style="font-size:24px; color:#D73B3B;"></i></a> <span style="color:#D73B3B;">
    <?php echo $counter_main - 1; ?></span><a
    style="text-decoration:none; color:#000000;"><?php if (($counter_main - 1)<2) {
            echo " Like";
        } else {
            echo " Likes";
        } ?>
</a>

<?php
    }
