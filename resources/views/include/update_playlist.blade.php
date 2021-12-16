<?php
error_reporting(0);
 
$like_review_query="select song_title, song_seo from tbl_songs
							where 1=1 
							AND id = '".$song_id."'  
							";
                            
                                            
    $review_like_info	=	\App\Models\Songs::GetRawDataAdmin($like_review_query);
    
    $song_seo	  	  = stripslashes($review_like_info['song_seo']);
    $song_title	  	  = stripslashes($review_like_info['song_title']);
    
    
     $get_playlist_data =  "select p.id, p.title_playlist, p.title_playlist_seo, u.user_name, u.user_seo  from tbl_user_playlist p, tbl_users u  where 1=1 AND p.id = '".$edit_id."' AND p.user_id_playlist = '".$user_id."' AND p.user_id_playlist = u.user_id";
     $row_infoplaylist  =  \App\Models\Songs::GetRawDataAdmin($get_playlist_data);
    

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

	<?php if ($mobile_view == 1) {?>
	<div class="modal-dialog modal-lg" style="width:95%;  margin-top:20%;">
		<?php } elseif ($mobile_view == 0) {?>
		<div class="modal-dialog modal-lg desktop_width" style="margin-top:10%;">
			<?php }?>
			<div class="modal-content">
				<div class="modal-header" style="padding:0; border-bottom:none; min-height:0;">
				</div>
				<div class="modal-body" style="padding:0; border:2px solid #666;">

					<img onClick="close_popup();" data-dismiss="modal"
						src="<?php echo SERVER_ROOTPATH;?>images/crosspng.png"
						style="float:right; cursor:pointer; margin-top:10px; margin-right:10px;">

					<div style="margin-top:0;">

						<form name="add_playlist" id="add_playlist" method="post"
							style="padding:10px; padding-top:20px;">

							<h4 style="font-size:20px; font-weight:normal; margin-bottom:20px; width:95%;">
								<?php
                    if (!isset($row_infoplaylist)) {
                        echo "Sorry you are not able to update this Playlist.";
                        exit;
                    }
                    
                    if (!$review_like_info) {
                        echo "Invalid song.";
                        exit;
                    }
                ?>
								Edit your <a style="color:#d73b3b;"
									href="<?php echo SERVER_ROOTPATH.stripslashes($row_infoplaylist['user_seo'])."-profile-playlists/".stripslashes($row_infoplaylist['title_playlist_seo']);?>"><?php echo stripslashes($row_infoplaylist['title_playlist']);?></a>
							</h4>

							<div class="row error">
								<div class="col-lg-12" id="error_list" style="display:none;">&nbsp;</div>

							</div>
							<input type="hidden" name="song_id"
								value="<?php echo $song_id;?>">
							<input type="hidden" name="art_id"
								value="<?php echo $art_id;?>">
							<input type="hidden" name="edit_id"
								value="<?php echo $edit_id;?>">
							<?php
                    if ($p!='') {
                        $newpara  = "&p=".stripslashes($row_infoplaylist['user_seo']); ?>
							<input type="hidden" name="p"
								value="<?php echo stripslashes($row_infoplaylist['user_seo']); ?>">
							<?php
                    }
                  ?>

							<input style="margin-top:10px;" type="text" name="playlist_title" class="form-control"
								placeholder="Your playlist name"
								value="<?php echo stripslashes($row_infoplaylist['title_playlist']);?>"
								autofocus>

							<a class="playlist_icon" data-title="" data-target="#show_playlist" data-toggle="modal"
								href="<?php echo SERVER_ROOTPATH;?>add_playlist.php?song_id=<?php echo $song_id;?>&art_id=<?php echo $art_id;?>"
								id="autoclick"></a>

							<button id="submit_btn" name="submit" style="margin-top:15px; display:inline; width:40%;"
								class="btn btn-lg btn-primary btn-block" type="submit"
								onClick="return update_playlist_validations_new();">Update</button>



							<a href="<?php echo SERVER_ROOTPATH;?>delete_playlist?edit_id=<?php echo $edit_id;?>&critaria=1<?php echo $newpara;?>"
								data-toggle="modal" data-target="#delete_playlist" data-title="" data-dismiss="modal"
								class="link-disable">
								<span
									style="margin-top:15px; display:inline; width:40%; float:right; background-color:#D73B3B; border-color:#D73B3B;"
									class="btn btn-lg btn-primary btn-block" type="button"
									data-dismiss="modal">Delete</span></a>
						</form>
					</div>
				</div>
			</div>
		</div>
</body>

</html>