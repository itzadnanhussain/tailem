<?php 
include("../includes/top.php");
include("../common/security.php"); 


		
		$del_qry="update tbl_artist_album set album_status='".$status."' where id='".$album_id."'";
		
		$db->query($del_qry);
		
		
		
		if($status==0)
		{
			//echo '<a href="song_list.php?status='.base64_encode(1).'&status_id='.base64_encode($id).'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
			echo '<a href="javascript:;" onclick = "change_status('.$album_id.', 1)" id = "remove_album_'.$id.'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
		}
		if($status==1)
		{
			//echo '<a href="song_list.php?status='.base64_encode(0).'&status_id='.base64_encode($id).'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
			echo '<a href="javascript:;" onclick = "change_status('.$album_id.', 0)" id = "remove_album_'.$id.'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
		}
											
		
		
?>