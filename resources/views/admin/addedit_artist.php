<?php 
include("includes/top.php");
include("common/security.php");
if($_REQUEST['del_id']!="")
{

	$select_img ="select artist_img from tbl_artists where id='".base64_decode($_REQUEST['del_id'])."'";
	$result = $db->get_row($select_img, ARRAY_A);
	
	$old_image  = $result['artist_img'];

	if($old_image!="")
	{
		$path			= '../site_upload/artist_images/';
		$imgfile =$path.$old_image;
		$thumbfile =$path.'thumb_'.$old_image;
		$thumbfile_small =$path.'small_thumb_'.$old_image;
		unlink($thumbfile_small);
		unlink($imgfile);
		unlink($thumbfile);
		
		mysqli_query($db->dbh, "update tbl_artists set artist_img = '' where id='".base64_decode($_REQUEST['del_id'])."'");
		
	}
	header('Location: '.SERVER_ADMIN_PATH.'addedit_artist.php?edit_id='.$_REQUEST['del_id']);
}

if($edit_id!="")
{
	$edit_id = base64_decode($edit_id);

	$row  =  $db->get_row("select * from tbl_artists where id='".$edit_id."'",ARRAY_A);
	$artist_seo 	= stripslashes(html_entity_decode($row['artist_seo']));
	$artist_name 	= $row['artist_name'];
	$genere_cat		= $row['genere_cat'];
	$keywords  		= $row['keywords'];
	$artist_seo		= $row['artist_seo'];
	$lastfm_url		= stripslashes($row['lastfm_url']);
	$artist_description  = $row['artist_description'];
	$artist_img     = stripslashes(html_entity_decode($row['artist_img']));
	$addedit 		= 'Edit';
}
else
{
	$addedit = 'Add';
}
?>
<html>
<head>
<title>Add Artist</title>
<?php
if($top_artist_module_add=='No')
{
	$target	= SERVER_ADMIN_PATH;
		
?>
<script language="javascript" type="text/javascript">
window.location.href = "<?php echo SERVER_ADMIN_PATH;?>"
	
</script>
<?php
}
?>
<script type="text/javascript">
	function delete_artist_image(id) // for changing multiple status or multiple delete 
	{
		var conBox = confirm("Are you sure,you want to delete this image?");
		if(conBox)
		{
			window.location.href = "<?php echo SERVER_ADMIN_PATH;?>addedit_artist.php?del_id="+id;	
		}			  
	}
</script>
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
										<td class="heading1"><?php echo $addedit;?> Artist</td>
									  </tr>
										
									  <tr>
										<td class="body">
											<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
											  <tbody>
												<tr>
												  <td align="left">
												  <a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a>
													&raquo;<a href="<?php echo SERVER_ADMIN_PATH;?>artist_list.php">Artist Listing</a>
													<?php
													if($edit_id != '')
													{
													?>
													&raquo; <a>Edit Artist</a>
													<?php
													}
													?>
												  
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
													  <form name="artist_form" id="artist_form" action="" method="post" enctype="multipart/form-data"> 
														  <table class="Panel">
															<tbody>
                                                              
															  <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Artist:</td>
																<td width="88%">
																<input type="text" name="artist_name" id="artist_name" value="<?php echo $artist_name;?>" class="fields"> <span class="Required" /> *</span>
																</td>
															  </tr>
                                                              
                                                              <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Genere:</td>
																<td width="88%">
																<?php
															$cat_list="select cat_name, cat_id from tbl_categories";	
															$cat_list_arr	=	$db->get_results($cat_list,ARRAY_A);
															?>		
															<select name="category">
																<option value="">Select Genere</option>
																<?php
																	if(isset($cat_list_arr))
																	{
																		foreach($cat_list_arr as $val)
																		{
																			$cat_id	  = $val['cat_id'];	
																			$cat_name = stripslashes(html_entity_decode($val['cat_name']));
																			?>
																			<option value="<?php echo $cat_id;?>" <?php if($genere_cat==$cat_id){?> selected<?php }?>><?php echo $cat_name;?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                                                 <span class="Required" /> *</span>
																</td>
															  </tr>
                                                              
                                                              <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Keywords:</td>
																<td width="88%">
																<input type="text" name="keywords" id="keywords" value="<?php echo $keywords;?>" class="fields"> <span class="Required" /> *</span>
																</td>
																
															  </tr>
															  <?php
																if(isset($edit_id) && $edit_id != '')
																{
																?>
															  <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Artist SEO:</td>
																 <td width="88%">
																<input type="text" name="artist_seo" id="artist_seo" value="<?php echo $artist_seo;?>" class="fields">
																</td>
																
															  </tr>
																<?php }?>
                                                             
                                                             
                                                   <tr>
													<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Lastfm URL:</td>
													<td width="88%">
													<input type="text" name="lastfm_url" id="lastfm_url" value="<?php echo $lastfm_url;?>" class="fields"> 	</td>
															  </tr>             
                                                              
                                                              <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Summary:</td>
																<td width="88%">
																<textarea name="artist_desc" id="artist_desc" rows="6" cols="80"><?php echo $artist_description;?></textarea>
																</td>
															  </tr>
                                                              
                                                               <tr>
																<td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Picture:</td>
																<td width="88%">
																 <input type="file" name="image_name" id="image_name" />
                    </br>
                     <span class="Required"/>
                      <strong>Profile picture is optional. JPG,GIF or PNG format</strong>
                    </span>
                    <?php
                    if($artist_img!="")
                    {
						$img_artist = album_img_api($artist_img);
					 	if($img_artist != '')
							{?>
							<img src="<?php echo $img_artist;?>" border="0" width="50" height="50" />
						<?php }else{ ?>
                        	</br></br>
                            <img src="<?php echo SERVER_ROOTPATH;?>site_upload/artist_images/<?php echo 'small_thumb_'.$artist_img;?>"  border="0" width="50" height="50" />&nbsp;
                        <?php } ?>
                    	<a href="javascript:;" onClick="delete_artist_image('<?php echo $_REQUEST['edit_id'];?>')"><img src="images/delet.gif" border="0" title="Delete Artist" class="Action" ></a>
                    <?php
                    }
                    ?>
                    
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
																<input name="save" id="save" value="Update" class="FormButton" type="submit" onClick="validate_artist();" />
																<?php
																}
																else
																{
																?>
																<input name="add_cat" id="add" value="Add" class="FormButton" type="submit" onClick="validate_artist();" />
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