<?php 
include("includes/top.php");
if(isset($edit_id) && !empty($edit_id))
{
	$edit_id	=	base64_decode($edit_id);
	$edit_qry	=	"SELECT * from tbl_admin WHERE id='$edit_id' and id!='1'";
	$edit_arr	=	$db->get_row($edit_qry,ARRAY_A);
	$id         =   $edit_arr['id'];
	
	$righs_qry	=	"SELECT * from  tbl_moderator_rights WHERE moderator_id ='$id' ";
	$righs_arr	=	$db->get_row($righs_qry,ARRAY_A);
	
	$slider_module            	= $righs_arr['slider_module'];
	$artist_module            	= $righs_arr['artist_module'];
	$album_module            	= $righs_arr['album_module'];
	$song_module            	= $righs_arr['song_module'];
	$users_module 	  			= $righs_arr['users_module'];
	$faq_module  				= $righs_arr['faq_module'];
	$categories_module         	= $righs_arr['categories_module'];
	$advertisement_module      	= $righs_arr['advertisement_module'];
	$social_link_module 	  	= $righs_arr['social_link_module'];
	$content_module  			= $righs_arr['content_module'];
	$email_template_module      = $righs_arr['email_template_module'];
	$country_module             = $righs_arr['country_module'];
	$reviews_module 	  		= $righs_arr['reviews_module'];
	$video_module            	= $righs_arr['video_module'];
	
	$slider_module_add  		= $righs_arr['slider_module_add'];
	$slider_module_delete 		= $righs_arr['slider_module_delete']; 
	
	$artist_module_add  		= $righs_arr['artist_module_add'];
	$artist_module_delete 		= $righs_arr['artist_module_delete']; 
	
	$album_module_add  		= $righs_arr['album_module_add'];
	$album_module_delete 		= $righs_arr['album_module_delete']; 
	
	$song_module_add  		= $righs_arr['song_module_add'];
	$song_module_delete 		= $righs_arr['song_module_delete']; 
	
	$users_module_add    		= $righs_arr['users_module_add']; 
	$users_module_delete 		= $righs_arr['users_module_delete'];  
	
	$faq_module_add      		= $righs_arr['faq_module_add']; 
	$faq_module_delete   		= $righs_arr['faq_module_delete'];  
	
	$categories_module_add		= $righs_arr['categories_module_add'];  
	$categories_module_delete	= $righs_arr['categories_module_delete'];  
	
	$country_module_add			= $righs_arr['country_module_add'];  
	$country_module_delete		= $righs_arr['country_module_delete'];
	
	$reviews_module_add			= $righs_arr['reviews_module_add'];  
	$reviews_module_delete 		= $righs_arr['reviews_module_delete'];  
	
	$advertisement_module_add   = $righs_arr['advertisement_module_add'];  
	$advertisement_module_delete= $righs_arr['advertisement_module_delete'];  
	
	$content_module_edit		= $righs_arr['content_module_edit'];  
	$email_template_module_edit	= $righs_arr['email_template_module_edit'];  
	
	$video_module_add           = $righs_arr['video_module_add'];
	$video_module_delete        = $righs_arr['video_module_delete'];
}
if($id=='' || $id=='1')
{
	$target	= SERVER_ADMIN_PATH.'moderator_list.php';
		
?>
<script language="javascript" type="text/javascript">
	window.location = '<?php echo $target;?>';
</script>
<?php
}
?>
<html>
<head>
<?php include("common/header.php");?>
</head>
<body>
<table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">
	<tbody><tr>
		<td style="background-image:URL('images/topbg.png'); background-repeat:repeat-x; height:50px;" height="50">
		<?php include("common/top_right_menu.php"); ?>		</td>
	</tr>
	
	<tr>
		<td valign="top">
<table border="0" width="100%"><tbody><tr>
<td width="10">&nbsp;</td>
<td>
	<div class="BodyContainer">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody>
          <tr>
			<td class="heading1"> Assign Rights To Moderator</td>
		  </tr>
		  <tr>
			<td class="body">
				<form name="moderator_right_form" id="moderator_right_form" action="" method="post"> 	
					<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tbody>
						<tr>
						  <td align="left">&nbsp;<a href="<?php echo SERVER_ADMIN_PATH;?>/index.php">Home</a> &raquo;<a href="<?php echo SERVER_ADMIN_PATH;?>moderator_list.php">Moderators</a> &raquo; <a> Assign Rights To Moderator <strong><?php echo stripslashes(html_entity_decode($edit_arr['username'])); ?></strong></a>
                          
                          </td>
	  				    </tr>
						<tr>
						  <td>
							  <table class="Panel" style="width:600px;">
								<tbody>
								 <!-- <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    Slider : </td>
								    <td align="left" valign="top" width="150"><input type="radio" name="slider_module" value="No" <?php if($slider_module=='No' || $slider_module==''){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'slider')" />  NO  
                                    <input type="radio" name="slider_module" value="Yes" <?php if($slider_module=='Yes'){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'slider')" /> Yes
                                    </td>
                                    <td align="left" id="slider_div" valign="top" width="250" style="display:none;">
                                    	<input type="checkbox" name="slider_module_add" value="Yes" <?php if($slider_module_add=='Yes'){ ?> checked="checked" <?php } ?> />  Add/Edit  
                                        <input type="checkbox" name="slider_module_delete" value="Yes" <?php if($slider_module_delete=='Yes'){ ?> checked="checked" <?php } ?> />  Delete
                                    </td>
								  </tr>-->
                                  <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    Users : </td>
								    <td align="left" valign="top"><input type="radio" name="users_module" value="No" <?php if($users_module=='No' || $users_module==''){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'users')"/>  NO  
                                    <input type="radio" name="users_module" value="Yes" <?php if($users_module=='Yes'){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'users')"/> Yes
                                    </td>
								    <td align="left" id="users_div" valign="top" width="250" style="display:none;">
                                    	<input type="checkbox" name="users_module_add" value="Yes" <?php if($users_module_add=='Yes'){ ?> checked="checked" <?php } ?> />  Add/Edit  
                                        <input type="checkbox" name="users_module_delete" value="Yes" <?php if($users_module_delete=='Yes'){ ?> checked="checked" <?php } ?> />  Delete
                                    </td>
								  </tr>
                                 <!-- <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    FAQ : </td>
								    <td align="left" valign="top">
                                    <input type="radio" name="faq_module" value="No" <?php if($faq_module=='No' || $faq_module==''){ ?> checked="checked" <?php } ?>  onClick="show_rights(this.value,'faqs')"/>  NO  
                                    <input type="radio" name="faq_module" value="Yes" <?php if($faq_module=='Yes'){ ?> checked="checked" <?php } ?>  onClick="show_rights(this.value,'faqs')"/> Yes
                                    </td>
								    <td align="left" id="faqs_div" valign="top" width="250" style="display:none;">
                                    	<input type="checkbox" name="faq_module_add" value="Yes" <?php if($faq_module_add=='Yes'){ ?> checked="checked" <?php } ?> />  Add/Edit  
                                        <input type="checkbox" name="faq_module_delete" value="Yes" <?php if($faq_module_delete=='Yes'){ ?> checked="checked" <?php } ?> />  Delete
                                    </td>
								  </tr>-->
                                  <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    Categories : </td>
								    <td align="left" valign="top"><input type="radio" name="categories_module" value="No" <?php if($categories_module=='No' || $categories_module==''){ ?> checked="checked" <?php }?>  onClick="show_rights(this.value,'categories')" />  NO  
                                    <input type="radio" name="categories_module" value="Yes" <?php if($categories_module=='Yes'){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'categories')" /> Yes
                                    </td>
								    <td align="left" id="categories_div" valign="top" width="250" style="display:none;">
                                    	<input type="checkbox" name="categories_module_add" value="Yes" <?php if($categories_module_add=='Yes'){ ?> checked="checked" <?php } ?> />  Add/Edit  
                                        <input type="checkbox" name="categories_module_delete" value="Yes" <?php if($categories_module_delete=='Yes'){ ?> checked="checked" <?php } ?> />  Delete
                                    </td>
								  </tr>
                                  <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    Advertisement : </td>
								    <td align="left" valign="top"><input type="radio" name="advertisement_module" value="No" <?php if($advertisement_module=='No' || $advertisement_module==''){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'advertisement')"/>  NO  
                                    <input type="radio" name="advertisement_module" value="Yes" <?php if($advertisement_module=='Yes'){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'advertisement')"/> Yes
                                    </td>
								 <td align="left" id="advertisement_div" valign="top" width="250" style="display:none;">
                                    	<input type="checkbox" name="advertisement_module_add" value="Yes" <?php if($advertisement_module_add=='Yes'){ ?> checked="checked" <?php } ?> />  Add/Edit  
                                        <input type="checkbox" name="advertisement_module_delete" value="Yes" <?php if($advertisement_module_delete=='Yes'){ ?> checked="checked" <?php } ?> />  Delete
                                    </td>
								  </tr>
                                  <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    Reviews : </td>
								    <td align="left" valign="top" width="150"><input type="radio" name="reviews_module" value="No" <?php if($reviews_module=='No' || $reviews_module==''){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'reviews')"/>  NO  
                                    <input type="radio" name="reviews_module" value="Yes" <?php if($reviews_module=='Yes'){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'reviews')"/> Yes
                                    </td>
								    <td align="left" id="reviews_div" valign="top" width="250" style="display:none;"  nowrap="nowrap">
                                    	<input type="checkbox" name="reviews_module_add" value="Yes" <?php if($reviews_module_add=='Yes'){ ?> checked="checked" <?php } ?> />  Add/Edit  
                                        <input type="checkbox" name="reviews_module_delete" value="Yes" <?php if($reviews_module_delete=='Yes'){ ?> checked="checked" <?php } ?> />  Delete
                                    </td>
								  </tr>
                                  <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    Videos : </td>
								    <td align="left" valign="top" width="150"><input type="radio" name="video_module" value="No" <?php if($video_module=='No' || $video_module==''){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'video')"/>  NO  
                                    <input type="radio" name="video_module" value="Yes" <?php if($video_module=='Yes'){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'video')"/> Yes
                                    </td>
								    <td align="left" id="video_div" valign="top" width="250" style="display:none;"  nowrap="nowrap">
                                    	<input type="checkbox" name="video_module_add" value="Yes" <?php if($video_module_add=='Yes'){ ?> checked="checked" <?php } ?> />  Add/Edit  
                                        <input type="checkbox" name="video_module_delete" value="Yes" <?php if($video_module_delete=='Yes'){ ?> checked="checked" <?php } ?> />  Delete
                                    </td>
								  </tr>
								  <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    Artist : </td>
								    <td align="left" valign="top" width="150"><input type="radio" name="artist_module" value="No" <?php if($artist_module=='No' || $artist_module==''){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'artistlist')" />  NO  
                                    <input type="radio" name="artist_module" value="Yes" <?php if($artist_module=='Yes'){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'artistlist')" /> Yes
                                    </td>
                                    <td align="left" id="artistlist_div" valign="top" width="250" style="display:none;">
                                    	<input type="checkbox" name="artist_module_add" value="Yes" <?php if($artist_module_add=='Yes'){ ?> checked="checked" <?php } ?> />  Add/Edit  
                                        <input type="checkbox" name="artist_module_delete" value="Yes" <?php if($artist_module_delete=='Yes'){ ?> checked="checked" <?php } ?> />  Delete
                                    </td>
								  </tr>
                                   <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    Album : </td>
								    <td align="left" valign="top" width="150"><input type="radio" name="album_module" value="No" <?php if($album_module=='No' || $album_module==''){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'albumlist')" />  NO  
                                    <input type="radio" name="album_module" value="Yes" <?php if($album_module=='Yes'){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'albumlist')" /> Yes
                                    </td>
                                    <td align="left" id="albumlist_div" valign="top" width="250" style="display:none;">
                                    	<input type="checkbox" name="album_module_add" value="Yes" <?php if($album_module_add=='Yes'){ ?> checked="checked" <?php } ?> />  Add/Edit  
                                        <input type="checkbox" name="album_module_delete" value="Yes" <?php if($album_module_delete=='Yes'){ ?> checked="checked" <?php } ?> />  Delete
                                    </td>
								  </tr>
                                  <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    Song : </td>
								    <td align="left" valign="top" width="150"><input type="radio" name="song_module" value="No" <?php if($song_module=='No' || $song_module==''){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'songlist')" />  NO  
                                    <input type="radio" name="song_module" value="Yes" <?php if($song_module=='Yes'){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'songlist')" /> Yes
                                    </td>
                                    <td align="left" id="songlist_div" valign="top" width="250" style="display:none;">
                                    	<input type="checkbox" name="song_module_add" value="Yes" <?php if($song_module_add=='Yes'){ ?> checked="checked" <?php } ?> />  Add/Edit  
                                        <input type="checkbox" name="song_module_delete" value="Yes" <?php if($song_module_delete=='Yes'){ ?> checked="checked" <?php } ?> />  Delete
                                    </td>
								  </tr>
                                  <tr><td colspan="3"><strong>General Setting:</strong></td></tr>
                                  <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    Country : </td>
								    <td align="left" valign="top"><input type="radio" name="country_module" value="No" <?php if($country_module=='No' || $country_module==''){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'country')"/>  NO  
                                    <input type="radio" name="country_module" value="Yes" <?php if($country_module=='Yes'){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'country')"/> Yes
                                    </td>
                                    <td align="left" id="country_div" valign="top" width="250" style="display:none;"  nowrap="nowrap">
                                    	<input type="checkbox" name="country_module_add" value="Yes" <?php if($country_module_add=='Yes'){ ?> checked="checked" <?php } ?> />  Add/Edit  
                                        <input type="checkbox" name="country_module_delete" value="Yes" <?php if($country_module_delete=='Yes'){ ?> checked="checked" <?php } ?> />  Delete
                                   
                                    </td>
								  </tr>
                                  <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    Edit Social Links : </td>
								    <td align="left" valign="top"><input type="radio" name="social_link_module" value="No" <?php if($social_link_module=='No' || $social_link_module==''){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'social_link')"/>  NO  
                                    <input type="radio" name="social_link_module" value="Yes" <?php if($social_link_module=='Yes'){ ?> checked="checked" <?php } ?>/> Yes
                                    </td>
								   <td align="left" id="social_link_div" valign="top" width="250">&nbsp;</td>
								  </tr>
                                  <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    Content  : </td>
								    <td align="left" valign="top"><input type="radio" name="content_module" value="No" <?php if($content_module=='No' || $content_module==''){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'content')"/>  NO  
                                    <input type="radio" name="content_module" value="Yes" <?php if($content_module=='Yes'){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'content')"/> Yes
                                    </td>
								    <td align="left" id="content_div" valign="top" width="250" style="display:none;">
                                        <input type="checkbox" name="content_module_edit" value="Yes" <?php if($content_module_edit=='Yes'){ ?> checked="checked" <?php } ?> />  Edit  
                                    </td>
								  </tr>
                                  <tr>
								    <td align="left" valign="top" width="150" class="SmallFieldLabel2_new">
                                    Email Template : </td>
								    <td align="left" valign="top"><input type="radio" name="email_template_module" value="No" <?php if($email_template_module=='No' || $email_template_module==''){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'email_template')"/>  NO  
                                    <input type="radio" name="email_template_module" value="Yes" <?php if($email_template_module=='Yes'){ ?> checked="checked" <?php } ?> onClick="show_rights(this.value,'email_template')"/> Yes
                                    </td>
								    <td align="left" id="email_template_div" valign="top" width="250" style="display:none;"  nowrap="nowrap">
                                        <input type="checkbox" name="email_template_module_edit" value="Yes" <?php if($email_template_module_edit=='Yes'){ ?> checked="checked" <?php } ?> />  Edit  
                                    </td>
								  </tr>
								  <tr>
								    <td class="SmallFieldLabel2_new" nowrap="nowrap">&nbsp;</td>
								    <td>&nbsp;</td>
								    <td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>
                                    <input name="moderator_id" type="hidden" class="Field300" id="moderator_id" value="<?php echo $id; ?>" size="10" maxlength="100">
                                    <input name="update" id="update" value="Update" class="FormButton" type="submit" onClick="moderator_rights_validatation();">
										</td>
								    <td>&nbsp;</td>
								  </tr>
								</tbody>
							  </table>
							  </td>
						  </tr>
					  </tbody>
					  </table>
				</form>			
            </td>
		  </tr>
		</tbody></table>
	<?php
	if($slider_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','slider');</script>
    <?php
	}
	
	if($artist_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','artistlist');</script>
    <?php
	}
	if($album_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','albumlist');</script>
    <?php
	}
	if($song_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','songlist');</script>
    <?php
	}
	
	if($users_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','users');</script>
    <?php
	}
	if($faq_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','faqs');</script>
    <?php
	}
	if($categories_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','categories');</script>
    <?php
	}
	if($advertisement_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','advertisement');</script>
    <?php
	}
	if($social_link_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','social_link');</script>
    <?php
	}
	if($content_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','content');</script>
    <?php
	}
	if($email_template_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','email_template');</script>
    <?php
	}
	if($country_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','country');</script>
    <?php
	}
	if($reviews_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','reviews');</script>
    <?php
	}
	if($video_module=="Yes")
	{
	?>
    	<script> show_rights('Yes','video');</script>
    <?php
	}
	?>   
</div>
<!-- End home -->
<!-- Start pagefooter --></td><td width="10">&nbsp;</td></tr></tbody></table></td>
	</tr>
	<tr>
		<td height="20">
		<?php include("common/footer.php");?>		</td>
	</tr>
</tbody></table>
<!-- End pagefooter -->
</body>
</html>