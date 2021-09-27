<?php 
include("includes/top.php");
include("common/security.php");
$setting_qry = "select * from tbl_general_setting where setting_id='1'";
$setting_arr	=	$db->get_row($setting_qry,ARRAY_A);
$facebook_right_script  = stripslashes(html_entity_decode($setting_arr['facebook_right_script']));
$facebook_bottom_script	= stripslashes(html_entity_decode($setting_arr['facebook_bottom_script']));

$rate_review	= stripslashes(html_entity_decode($setting_arr['rate_review']));
$discuss	= stripslashes(html_entity_decode($setting_arr['discuss']));
$profile	= stripslashes(html_entity_decode($setting_arr['profile']));
$rhyming_larics	= stripslashes(html_entity_decode($setting_arr['rhyming_larics']));

$desktop_version_logo	= $setting_arr['desktop_version_logo'];
$mobile_version_logo	= $setting_arr['mobile_version_logo'];
?>
<html>
<head>
<?php include("common/header.php");?>
</head>
<body>
<table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">
	<tbody>
    <tr>
        <td style="background:#1F3C5C; background-repeat:repeat-x; height:60px;" height="60">
        	<?php include("common/top_right_menu.php");?>
        </td>
    </tr>
	
	<tr>
		<td valign="top">
		
<table border="0" width="100%"><tbody><tr>
<td width="10">&nbsp;</td>
<td>
	<div class="BodyContainer">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr>
	
			<td class="heading1">General Setting</td>
		  </tr>
			
		  <tr>
			<td class="body">
					<table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tbody>
						<tr>
						  <td align="left"><a href="<?php echo SERVER_ADMIN_PATH;?>index.php">Home</a> &raquo; <a>General Setting</a></td>
	  				    </tr>
						<?php if(isset($msg) && $msg!=""){ ?>
						<tr>
							<td>
								<table border="0" cellpadding="0" cellspacing="0" class="Message">
								<tbody>
									<tr>
										<td width="20">
											<?php if($case==1){ ?>
											<img src="images/success_icon.png" vspace="5" width="18" height="18" hspace="10">
											<?php } ?>
											<?php if($case==2){ ?>
											<img src="images/warning_icon.png" vspace="5" width="18" height="18" hspace="10">
											<?php } ?>
											<?php if($case==3){ ?>
											<img src="images/error_icon.png" vspace="5" width="18" height="18" hspace="10">
											<?php } ?>										</td>
										<td width="100%"><?php echo base64_decode($msg);?></td>
									</tr>
								</tbody>
								</table>							</td>
						</tr>
						<?php } ?>
						<tr>
						  <td>
						  <form name="setting_form" id="setting_form" action="" method="post" enctype="application/x-www-form-urlencoded"> 
							  <table class="Panel" style="width:1300px;">
								<tbody>
								  <tr>
									<td class="Heading2" colspan="2"><strong>General Setting</strong></td>
								  </tr>
                                  <tr><td colspan="2">&nbsp;</td></tr>
								  <!--<tr>
									<td width="15%" nowrap="nowrap" class="SmallFieldLabel2">facebook Right Script :</td>
									<td width="85%">
                                        <textarea name="facebook_right_script" id="facebook_right_script" style="width: 775px;height:157px;"><?php echo $facebook_right_script;?></textarea>                        			
                                    </td>
								  </tr>
                                  <tr>
									<td width="15%" nowrap="nowrap" class="SmallFieldLabel2">facebook Bottom Script:</td>
									<td width="85%">
                                    	<textarea name="facebook_bottom_script" id="facebook_bottom_script" style="width:775px;height:157px;"><?php echo $facebook_bottom_script;?></textarea>          			
                                    </td>
								  </tr>-->
                                  <tr>
									<td width="15%" nowrap="nowrap" class="SmallFieldLabel2">Upload Logo for Desktop version:</td>
									<td width="85%">
                                    	<input type="file" name="desktop_version_logo" id="desktop_version_logo" /><br />
                                        <span class="required"><strong>Only JPG,GIF or PNG format of size: 286X44</strong></span>
                                        <?php
										if($desktop_version_logo!='')
										{
											$desktop_version_logo_path =  SERVER_ROOTPATH.'assets/phpthumb/phpThumb.php?src='.SERVER_ROOTPATH.'site_upload/general_setting/'.$desktop_version_logo.'&w=286&h=44&zc=1';
										?>
                                        	<br /><br />
                                            <img src="<?php echo $desktop_version_logo_path;?>" border="0" />
                                            <br /><br />
                                        <?php
										
										}
										?>      			
                                    </td>
								  </tr>
                                  
                                   <!--<tr>
									<td width="15%" nowrap="nowrap" class="SmallFieldLabel2">Rate & Review:</td>
									<td width="85%">
                                    	<textarea name="rate_review" id="rate_review" style="width:775px;height:100px;"><?php echo $rate_review;?></textarea>          			
                                    </td>
								  </tr>
                                  
                                   <tr>
									<td width="15%" nowrap="nowrap" class="SmallFieldLabel2">DISCUSS:</td>
									<td width="85%">
                                    	<textarea name="discuss" id="discuss" style="width:775px;height:100px;"><?php echo $discuss;?></textarea>          			
                                    </td>
								  </tr>
                                  
                                   <tr>
									<td width="15%" nowrap="nowrap" class="SmallFieldLabel2">PROFILE:</td>
									<td width="85%">
                                    	<textarea name="profile" id="profile" style="width:775px;height:100px;"><?php echo $profile;?></textarea>          			
                                    </td>
								  </tr>
                                  
                                   <tr>
									<td width="15%" nowrap="nowrap" class="SmallFieldLabel2">RHYMING LARICS:</td>
									<td width="85%">
                                    	<textarea name="rhyming_larics" id="rhyming_larics" style="width:775px;height:100px;"><?php echo $rhyming_larics;?></textarea>          			
                                    </td>
								  </tr>-->
                                 <!-- <tr>
									<td width="15%" nowrap="nowrap" class="SmallFieldLabel2">Upload Logo for Mobile version :</td>
									<td width="85%">
                                    	<input type="file" name="mobile_version_logo" id="mobile_version_logo" /><br />
                                        <span class="required"><strong>Only JPG,GIF or PNG format of size: 252X39</strong></span>
                                        <?php
										if($mobile_version_logo!='')
										{
											$mobile_version_logo_path =  SERVER_ROOTPATH.'assets/phpthumb/phpThumb.php?src='.SERVER_ROOTPATH.'site_upload/general_setting/'.$mobile_version_logo.'&w=252&h=39&zc=1';
										?>
                                        	<br /><br />
                                            <img src="<?php echo $mobile_version_logo_path;?>" border="0" />
                                            <br /><br />
                                        <?php
										}
										?>      			
                                    </td>
								  </tr>-->
								  <tr>
									<td>&nbsp;</td>
									<td>
                                    	<input name="update_record" id="update_record" value="Update" class="FormButton" type="submit" onClick="validate_general_setting();">                        
                                    </td>
								  </tr>
								</tbody>
							  </table>						  
						  </form>						  </td>
						  </tr>
						<tr>
						</tr> 
						</tbody>
					  </table>			</td>
		  </tr>
		</tbody></table>
</div></td><td width="10">&nbsp;</td></tr></tbody></table>		</td>
	</tr>
	<tr>
		<td height="20">
		<?php include("common/footer.php");?>		</td>
	</tr>
</tbody></table>
</body>
</html>