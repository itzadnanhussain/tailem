<?php
   
    if ($user_id=="") {
        echo "Please sign in first";
        exit;
    }

    
    
    
    

    $qry = "select id from tbl_likes where like_type = 'profile' AND like_id = '$prod_id'";
    $counter_main = array();
    $counter_main = \App\Models\Songs::GetRawData($qry);
    if ($counter_main) {
        $counter_main = count($counter_main);
    } else {
        $counter_main = 0;
    }
    if ($prod_id==$user_id) {
        echo "aa";
        //echo "You cannot like your own profile";
        exit;
    }
    
     
    $qry = "select id from tbl_likes where like_from_user_id = '".$user_id."' AND like_type = 'profile' AND like_id = '$prod_id'";
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
        $sql = "INSERT INTO tbl_likes (like_id, like_type, date, like_from_user_id,like_receive_user) VALUES ($prod_id, 'profile', '$date', $user_id,$prod_id)";
        $rsd = \App\Models\Songs::GetRawData($sql); ?>
<a href="javascript:;"
    onClick="add_in_favourite_user_profile_mainlist_discussion_new('<?php echo $prod_id; ?>','<?php echo $sr_no; ?>','<?php echo $db_user_name; ?>')"
    class="like"><i class="fa fa-heart heart_color"></i></a><span class="like"
    style="color:#fff; margin-left:2px;"></span><a
    href="<?php echo SERVER_ROOTPATH."detail_profile.php?user=".urlencode($db_user_name)."&critaria=1"; ?>"
    data-toggle="modal" data-target="#profile_modal" data-title="" style="color:#fff;font-size:10px;"><span class="like"
        style=" margin-right:5px; color:#fff"> <?php echo $counter_main + 1; ?></span></a>


<?php
    } else {
        $qry = "Delete from tbl_likes where like_from_user_id = '".$user_id."' AND like_id = $prod_id AND like_type = 'profile'";
        $rsd = \App\Models\Songs::GetRawData($qry); ?>

<a href="javascript:;"
    onClick="add_in_favourite_user_profile_mainlist_discussion_new('<?php echo $prod_id; ?>','<?php echo $sr_no; ?>','<?php echo $db_user_name; ?>')"
    class="like"><i class="fa fa-heart-o heart_color"></i></a><span class="like"
    style="color:#fff; margin-left:2px;"></span><a
    href="<?php echo SERVER_ROOTPATH."detail_profile.php?user=".urlencode($db_user_name)."&critaria=1"; ?>"
    data-toggle="modal" data-target="#profile_modal" data-title="" style="color:#fff; font-size:10px;"><span
        class="like" style=" margin-right:5px; color:#fff"> <?php echo $counter_main - 1; ?></span></a>
<?php
    }
