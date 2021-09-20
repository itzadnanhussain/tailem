<?php  
 
	if($user_id=="")
	{
		echo "Please sign in first";
		exit;
	}
	
	if($prod_id==$user_id)
	{
		
		echo "aa";
		exit;
	}

	
	
	// $prod_id = $_REQUEST['prod_id'];
	// $sr_no	= $_REQUEST['sr_no'];
	// $user_name	= $_REQUEST['username'];
	

	$qry = "select id from tbl_likes where like_type = 'profile' AND like_id = '$prod_id'";
	$counter_main = array();
    $counter_main = \App\Models\Songs::GetRawData($qry);
    if ($counter_main) {
    $counter_main = count($counter_main);
    } else {
    $counter_main = 0;
    }
	 
	$qry = "select id from tbl_likes where like_from_user_id = '".$user_id."' AND like_type = 'profile' AND like_id = '$prod_id'";
	$counter = array();
    $counter = \App\Models\Songs::GetRawData($qry);
    if ($counter) {
    $counter = count($counter);
    } else {
    $counter = 0;
    }
	if($counter==0)
	{
		$date = date("Y-m-d");
		$user_id  =  $user_id;
	 	$sql = "INSERT INTO tbl_likes (like_id, like_type, date, like_from_user_id,like_receive_user) VALUES ($prod_id, 'profile', '$date', $user_id,$prod_id)";
	 	$rsd  = \App\Models\Songs::GetRawData($sql);;
		
		?>
        <a href="javascript:;" onClick="add_in_favourite_main_profile_list_new('<?php echo $prod_id;?>','<?php echo $sr_no;?>','<?php echo urlencode($user_name);?>')"><i class="fa fa-heart heart_color heart_size"></i></a><span style="font-weight:normal; font-size:14px;"> <?php echo $counter_main + 1;?></span><a href="<?php echo SERVER_ROOTPATH;?>detail_profile.php?user=<?php echo urlencode($user_name);?>&critaria=1" data-toggle="modal" data-target="#profile_Modal2_<?php echo $sr_no;?>" data-title="" class="like link-disable" style="color:#000; font-weight:normal !important; font-size:14px; margin-right:40px;"><?php if(($counter_main + 1)<2){ echo " Like";} else {  echo " Likes"; }?></a>
        
        <?php
	}
else
{
	$qry = "Delete from tbl_likes where like_from_user_id = '".$user_id."' AND like_id = $prod_id AND like_type = 'profile'";
	$rsd = \App\Models\Songs::GetRawData($qry);
    ?>

        <a href="javascript:;" onClick="add_in_favourite_main_profile_list_new('<?php echo $prod_id;?>','<?php echo $sr_no;?>','<?php  echo urlencode($user_name);?>')"><i class="fa fa-heart-o heart_color heart_size"></i></a><span style="font-weight:normal; font-size:14px;"> <?php echo $counter_main - 1;?></span><a href="<?php echo SERVER_ROOTPATH;?>detail_profile.php?user=<?php echo urlencode($user_name);?>&critaria=1" data-toggle="modal" data-target="#profile_Modal2_<?php echo $sr_no;?>" data-title="" class="like link-disable" style="color:#000; font-weight:normal !important; font-size:14px; margin-right:40px;"><?php if(($counter_main - 1)<2){ echo " Like";} else {  echo " Likes"; }?></a>
    <?php
}
?>

<div class="modal fade in" id="your_own_profile" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="false">
	<div class="modal-dialog" style="margin-top:10%;">
		<div class="modal-content" style="border-radius:0px;">
			<div class="modal-header">
				<h4 class="modal-title" style="color:#3276b1;"> Thank you <img data-dismiss="modal" style="cursor:pointer; float:right;" src="https://www.tailem.com/images/xcrosspng.png.pagespeed.ic.x-7sR0qk1S.webp" data-pagespeed-url-hash="3119113509" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
				</h4>
			</div>
			<div class="modal-body" style="overflow-y:auto; min-height:250px;">
				<p>
					Unfortunately, you cannot like your own profile. <br><br><br>

					Warmest Regards,<br>
					Team at Tailem.com
				</p>
			</div>
		</div>
	</div>
</div>
