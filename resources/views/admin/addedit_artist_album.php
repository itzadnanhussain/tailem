<?php 
include("includes/top.php");
include("common/security.php");



$dec_id 				= base64_decode($artist_id);

$row_artist  			=  $db->get_row("select * from tbl_artists where id='".$dec_id."'",ARRAY_A);

if($row_artist)
{
	$artist_id_db 			= stripslashes(html_entity_decode($row_artist['id']));
	$artist_seo 			= stripslashes(html_entity_decode($row_artist['artist_seo']));
	$artist_name 			= stripslashes(html_entity_decode($row_artist['artist_name']));
	$artist_description 	= stripslashes(html_entity_decode($row_artist['artist_description']));
	$artist_img 			= stripslashes(html_entity_decode($row_artist['artist_img']));
	
}
	
if($edit_id!="")
{
	$edit_id = base64_decode($edit_id);

	$row  =  $db->get_row("select * from tbl_artist_album where id='".$edit_id."' AND album_artist_id = '".$dec_id."'",ARRAY_A);
	$album_title 	= stripslashes(html_entity_decode($row['album_title']));
	$album_seo  = $row['album_seo'];
	$ranking_order  = $row['ranking_order'];
	$album_picture  = $row['album_picture'];
	$keywords 				= stripslashes(html_entity_decode($row['keywords']));
	$years 	= stripslashes(html_entity_decode($row['years']));
	
	$addedit = 'Edit';
}
else
{
	$addedit = 'Add';
}
?>
<html>
<head>
<title>Artist Album</title>
<?php
if($top_album_module_add=='No')
{
	$target	= SERVER_ADMIN_PATH;
		
?>
<script language="javascript" type="text/javascript">
	window.location = '<?php echo $target;?>';
</script>
<?php
exit;
}
?>
<style>
 .pie{
	 behavior:url(PIE.htc);
 }
</style>

<?php include("common/header.php");?>
</head>
<body>

<table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">
	<tbody>
		<tr>
            <td style="background:#1F3C5C; background-repeat:repeat-x; height:60px;" height="60">
                <?php include("common/top_right_menu.php"); ?>
            </td>
        </tr>
	
		<tr>
			<td valign="top">
				<table border="0" width="100%">
					<tbody>
						<tr>
							<td width="10">&nbsp;</td>
							<td>
								<div class="BodyContainer">
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
									  <tbody>
									  <tr>
										<td class="heading1"><?php echo $addedit;?> <?php echo $artist_name;?> Album </td>
									  </tr>
										
									  <tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
											  <tbody>
												<tr>
												  <td align="left">
												  <a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a>
													&raquo;<a href="<?php echo SERVER_ADMIN_PATH;?>artist_list.php">Artist Listing</a>&raquo;
                                                  <a href="<?php echo SERVER_ADMIN_PATH;?>artist_album_list.php?artist_id=<?php echo $artist_id;?>">Artist <?php echo $artist_name;?> Album Listing</a>
                                                 &raquo;
                                                  <a>Add Album</a>
													
												  
												  </td>
												</tr>
												
												<?php if(isset($errorstr) && $errorstr!=""){ ?>
												<tr>
												  <td colspan="8">
													<table border="0" cellpadding="0" cellspacing="0" class="Message">
														<tbody>
															<tr>
																<td width="20" valign="top">
																<?php if($case==1){ ?>
																<img src="images/success_icon.png" vspace="5" width="18" height="18" hspace="10">
																<?php } ?>
																<?php if($case==2){ ?>
																<img src="images/warning_icon.png" vspace="5" width="18" height="18" hspace="10">
																<?php } ?>
																<?php if($case==0){ ?>
																<img src="images/error_icon.png" vspace="5" width="18" height="18" hspace="10">
																<?php } ?>											</td>
																<td width="100%"><?php echo $errorstr; ?></td>
															</tr>
														</tbody>
													</table>
												  </td>
												</tr>
												<?php } ?>
												
												
												<tr>
												  <td>
													  <form name="album_form" id="album_form" action="" method="post" enctype="multipart/form-data"> 
														  <table class="Panel">
															<tbody>
                                                              
															  <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Album:</td>
																<td width="88%">
																<input type="text" name="album_title" id="album_title" value="<?php echo $album_title;?>" class="fields"> <span class="Required" /> *</span>																</td>
															  </tr>
                                                              
                                                               <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Keywords:</td>
																<td width="88%">
																<input type="text" name="keywords" id="keywords" value="<?php echo $keywords;?>" class="fields"> <span class="Required" /> *</span>																</td>
															  </tr>
                                                              
															  <tr>
															              <td nowrap="nowrap" class="SmallFieldLabel2">Year</td>
															              <td>
                              <select name="years">
                                <option value="">Year</option>
                                <?php
                                    for($k=date("Y")+5;$k>=1900;$k--)
                                    {
                                    $sel='';
                                    if($k==$years){ $sel="selected='selected'";}
                                    ?>
                                    <option value="<?php echo $k;?>" <?php echo $sel;?>><?php echo $k;?></option>
                                    <?php      }     ?>
                     </select>
                                                                
                                                                          </td>
															              </tr>
                                                              <input type="hidden" name="artist_id" id="artist_id" value="<?php echo $artist_id_db;?>">
                                                              
                                                            <!--  <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Summary:</td>
																<td width="88%">
																<textarea name="artist_desc" id="artist_desc" rows="6" cols="80"></textarea>
																</td>
															  </tr>-->
                                                              
                                                               <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Picture:</td>
																<td width="88%">
																 <input type="file" name="image_name" id="image_name" />
                    </br>
                     <span class="Required"/>
                      <strong>Profile picture is optional. JPG,GIF or PNG format</strong>
                    </span>
                    <?php
                    if($picture!="")
                    {
                    ?>
                    </br></br>
                    <img src="<?php echo SERVER_ROOTPATH;?>site_upload/album_images/<?php echo 'small_thumb_'.$picture;?>"  border="0"/>
                    <?php
                    }
                    ?>
																</td>
															  </tr>
                                                              
                                                             
                                                              
                                                                <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Song Ranking :</td>
																<td width="88%">
																<input class="fields" id="song_ranking" name="song_ranking" value="<?php echo $ranking_order;?>" type="number">
                                                                </td>
															  </tr>
                                                              
                                                               <tr>
																<td class="SmallFieldLabel2">&nbsp;</td>
																<td>&nbsp;</td>
															  </tr>
                                                              
                                                              
                                                              <tr>
																<td>&nbsp;</td>
																<td>
																<?php
																if(isset($edit_id) && $edit_id != '')
																{
																?>
																<input type="hidden" name="update_id" id="update_id" value="<?php echo $edit_id; ?>">
																<input name="save" id="save" value="Update" class="FormButton" type="submit" onClick="validate_album();" />
																<?php
																}
																else
																{
																?>
																<input name="add_cat" id="add" value="Add" class="FormButton" type="submit" onClick="validate_album();" />
																<?php
																}
																?>
                                                                <div id="loader"></div>
																</td>
															  </tr>
															</tbody>
														  </table>						  
													  </form>
												  </td>
												</tr>
												
												<tr>
												  <td>&nbsp;</td>
												</tr>
											  </tbody>
											</table>
										</td>
									  </tr>
									  </tbody>
									</table>
								</div>
							</td>
							<td width="10">&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr><td height="20"><?php include("common/footer.php");?></td></tr>
	</tbody>
</table>
<!-- End pagefooter -->
</body>

</html>