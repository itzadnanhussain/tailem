@include("admin.includes.top")
@include("admin.common.security")

<html>
<head>
@include("admin.common.header")
<script language="javascript" type="text/javascript">
	function overdivfunc(did){
		var divid 		= did;
		var innerdiv	= did+'MidHeading';	
		document.getElementById(divid).className = 'childdivhover';
		document.getElementById(innerdiv).className = 'MidHeadingover';
	
	}
	
	function outdivfun(did){
		var divid 		= did;
		var innerdiv	= did+'MidHeading';	
		document.getElementById(divid).className = 'childdiv';
		document.getElementById(innerdiv).className = 'MidHeading';
	}
</script>
</head>
<body>
<table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">
  <tbody>
    <tr>
     <td style="background:#1F3C5C; background-repeat:repeat-x; height:60px;" height="60">
	  	@include("admin.common.top_right_menu")
     </td>
    </tr>
   
    <tr>
      <td valign="top"><table border="0" width="100%">
          <tbody>
            <tr>
              <td width="10">&nbsp;</td>
              <td valign="top"><!-- End page header -->
                <!-- End pageheader -->
                <!-- Start home -->
                <div class="BodyContainer">
                  <table border="0" cellpadding="0" cellspacing="0" width="100%" >
                    <tbody>
                      <tr>
                        <td class="heading1"><?php echo $title;?></td>
                      </tr>
                      <tr>
                        <td class="">
							<div class="parentdiv">
                            <!-- Start Of COLUMN 1 -->
                            <div class="colum1">
                            	<!--<?php
								if($top_slider_module=='Yes')
								{
								?>
                                <div class="childdiv" onMouseOver="overdivfunc(this.id);" onMouseOut="outdivfun(this.id);" id="slider">
                                    <div class="MidHeading" id="sliderMidHeading"><img src="images/video2.png" align="absmiddle" width="16" height="16">&nbsp;Manage Slider</div>
                                    <ul>
                                    <li><a href="<?php echo SERVER_ADMIN_PATH;?>slide_show_list">Manage Slider List</a></li>
                                    <?php
									if($top_slider_module_add=='Yes')
									{
									?>
                                    	<li><a href="<?php echo SERVER_ADMIN_PATH;?>addedit_slideshow">Add Slider</a></li>
                                    <?php
									}
									?>
                                    </ul>
                                </div>
                                <?php
								}
								?>-->
                                <?php
								if($top_users_module=='Yes')
								{
								?>
                                <div class="childdiv" onMouseOver="overdivfunc(this.id);" onMouseOut="outdivfun(this.id);" id="users">
                                    <div class="MidHeading" id="usersMidHeading"><img src="images/user.gif" align="absmiddle" width="16" height="16">&nbsp;Manage Users</div>
                                    <ul>
                                    <li><a href="<?php echo SERVER_ADMIN_PATH;?>users_list">Manage Users</a></li>
                                    <?php
									if($top_users_module_add=='Yes')
									{
									?>
                                    	<li><a href="<?php echo SERVER_ADMIN_PATH;?>addedit_user">Add User</a></li>
                                    <?php
									}
									?>
                                    </ul>
                                </div>
                                <?php
								}
								/*?>
                                <?php
								if($top_faq_module=='Yes')
								{
								?>
                                <div class="childdiv" onMouseOver="overdivfunc(this.id);" onMouseOut="outdivfun(this.id);" id="faq">
                                    <div class="MidHeading" id="faqMidHeading"><img src="images/faq.gif" align="absmiddle" width="16" height="16">&nbsp;Manage Faq</div>
                                    <ul>
                                    <li><a href="<?php echo SERVER_ADMIN_PATH;?>faq_list">Manage FAQ</a></li>
                                    <?php
									if($top_faq_module_add=='Yes')
									{
									?>
                                    	<li><a href="<?php echo SERVER_ADMIN_PATH;?>addedit_faq">Add FAQ</a></li>
                                    <?php
									}
									?>
                                    </ul>
                                </div>
                                <?php
								}*/
								?>
                                
                                 <?php
								if($top_faq_module=='Yes')
								{
								?>
                                <div class="childdiv" onMouseOver="overdivfunc(this.id);" onMouseOut="outdivfun(this.id);" id="artist">
                                    <div class="MidHeading" id="artistMidHeading"><img src="images/faq.gif" align="absmiddle" width="16" height="16">&nbsp;Manage Artists</div>
                                    <ul>
                                    <li><a href="<?php echo SERVER_ADMIN_PATH;?>artist_list">Manage Artists</a></li>
                                    <?php
									if($top_faq_module_add=='Yes')
									{
									?>
                                    	<li><a href="<?php echo SERVER_ADMIN_PATH;?>addedit_artist">Add Artists</a></li>
                                    <?php
									}
									?>
                                    </ul>
                                </div>
                                <?php
								}
								?>
                                
                                <?php
								/*if($top_categories_module=='Yes')
								{
								?>
                                <div class="childdiv" onMouseOver="overdivfunc(this.id);" onMouseOut="outdivfun(this.id);" id="categories">
                                    <div class="MidHeading" id="categoriesMidHeading"><img src="images/object.png" align="absmiddle" width="16" height="16">&nbsp;Manage Categories</div>
                                    <ul>
                                    <li>
                                   <a href="<?php echo SERVER_ADMIN_PATH;?>main_cat_list">Manage Main Categories</a>
                                    </li>
                                    <?php
									if($top_categories_module_add=='Yes')
									{
									?>
                                    <li>
                                    <a href="<?php echo SERVER_ADMIN_PATH;?>addedit_main_cat">Add Main Category</a>
                                    </li>
                                    <?php
									}
									?>
                                    <br />
                                    <li>
                                    <a href="<?php echo SERVER_ADMIN_PATH;?>all_cat_list">Manage Sub Categories</a>
                                    </li>
                                    <li>
                                    <a href="<?php echo SERVER_ADMIN_PATH;?>sub_cat_list">Manage Review Topics</a>
                                    </li>
                                    
                                    <?php
									if($top_categories_module_add=='Yes')
									{
									?>
                                        <li>
                                       <a href="<?php echo SERVER_ADMIN_PATH;?>add_sub_cat">Add Sub Category</a>
                                        </li>
                                    <?php
									}
									?>
                                    <!--<br />
                                    <li>
                                    <a href="<?php echo SERVER_ADMIN_PATH;?>embed_code_list">Manage Products Embed Code </a>
                                    </li>-->
                                    <?php
									if($top_categories_module_add=='Yes')
									{
									?>
                                       <!-- <li>
                                       <a href="<?php echo SERVER_ADMIN_PATH;?>addedit_embed_code">Add Product Embed Code</a>
                                        </li>-->
                                    <?php
									}
									?>
                                   <!-- <br />
                                      <li><a href="<?php echo SERVER_ADMIN_PATH;?>category_image_list">Manage Category Images List </a>
                                    </li>-->
                                    <?php
									if($top_categories_module_add=='Yes')
									{
									?>
                                       <!-- <br /><li>
                                       <a href="<?php echo SERVER_ADMIN_PATH;?>addedit_category_image">Add Category Images</a>
                                        </li>-->
                                    <?php
									}
									?>
                                   <!-- <?php
									if($top_categories_module=='Yes')
									{
									?>
                                      <br />
                                      <li><a href="<?php echo SERVER_ADMIN_PATH;?>questions">Questions List</a></li>
                                    <?php
									}
									?>-->
                                    </ul>
                                </div>
                                <?php
								}*/
								?>
                                <?php
								if($top_advertisement_module=='Yes')
								{
								?>
                                <div class="childdiv" onMouseOver="overdivfunc(this.id);" onMouseOut="outdivfun(this.id);" id="ads">
                                    <div class="MidHeading" id="adsMidHeading"><img src="images/services.png" align="absmiddle" width="16" height="16">&nbsp;Manage Advertisement</div>
                                    <ul>
                                    <li>
                                   <a href="<?php echo SERVER_ADMIN_PATH;?>ads_list">Manage Advertisement</a>
                                    </li>
                                    <?php
									if($top_advertisement_module_add=='Yes')
									{
									?>
                                    <li>
                                    <a href="<?php echo SERVER_ADMIN_PATH;?>addedit_ads">Add Advertisement</a>
                                    </li>
                                    <?php
									}
									?>
                                   <!-- <br/>
                                     <li>
                                   		<a href="<?php echo SERVER_ADMIN_PATH;?>ads_mobile_list">Manage Mobile Advertisement</a>
                                    </li>
                                    <?php
									if($top_advertisement_module_add=='Yes')
									{
									?>
                                        <li>
                                        <a href="<?php echo SERVER_ADMIN_PATH;?>addedit_mobile_ads">Add Mobile Advertisement</a>
                                        </li>
                                    <?php
									}
									?>-->
                                    </ul>
                                </div>
                                <?php
								}
								?>
                                <?php
	if($top_social_link_module=='Yes' || $top_content_module=='Yes' || $top_email_template_module=='Yes' || $top_country_module=='Yes')
								{
								?>	
                                <div class="childdiv" onMouseOver="overdivfunc(this.id);" onMouseOut="outdivfun(this.id);" id="general">
                                    <div class="MidHeading" id="generalMidHeading"><img src="images/setting.png" align="absmiddle" width="16" height="16">&nbsp;General Setting</div>
                                    <ul>
                                    	<?php
										if($top_social_link_module=='Yes')
										{
										?>
                                        <li><a href="<?php echo SERVER_ADMIN_PATH;?>general_setting">Manage General Setting</a></li>							
                                    	<li><a href="<?php echo SERVER_ADMIN_PATH;?>social_links">Manage Follow Us</a></li>							
                                        <?php
										}
										?>
                                        <?php
										if($top_content_module=='Yes')
										{
										?>
                                        <li><a href="<?php echo SERVER_ADMIN_PATH;?>page_list">Manage Contents</a></li>										
                                        <?php
										}
										?>
                                        <?php
										if($top_email_template_module=='Yes')
										{
										?>

                                         <li><a href="<?php echo SERVER_ADMIN_PATH;?>email_templates_list">Manage Email Templates</a></li>				<?php
										}
										?>
                                 		<a href="<?php echo SERVER_ADMIN_PATH;?>images_list">Manage Stores Images</a>
                                         <?php
										/* if($top_country_module=='Yes')
										 {
										 ?>
                                        	<li><a href="<?php echo SERVER_ADMIN_PATH;?>countries_listing">Manage Countries</a></li>						
											<?php
                                            if($top_country_module_add=='Yes')
                                            {
                                            ?>
                                            	<li>
                                            		<a href="<?php echo SERVER_ADMIN_PATH;?>addedit_country">Add Country</a>
                                            	</li>
										   <?php
                                            }
                                            ?>
                                        <?php
										}*/
										?>
                                       
                                    </ul>
                                </div>
                                <?php
								}
								?>
                                <?php
								if($top_reviews_module=='Yes')
								{
								?>
                                <div class="childdiv" onMouseOver="overdivfunc(this.id);" onMouseOut="outdivfun(this.id);" id="reviews">                                
                                    <div class="MidHeading" id="reviewsMidHeading"><img src="images/language.png" align="absmiddle" width="16" height="16">&nbsp;Manage Reviews</div>
                                    <ul>
                                    <li><a href="<?php echo SERVER_ADMIN_PATH;?>reviews_list">Local Reviews Listing</a></li>
                                    <?php
                                    if($top_reviews_module_add=='Yes')
                                    {
                                    ?>
                                       <!-- 20-10-2016 artist_id, song_id, album_id<li><a href="<?php echo SERVER_ADMIN_PATH; ?>add_review">Add Review</a></li>-->
                                    <?php
                                    }
                                    ?>
                                   
                                   <li><a href="<?php echo SERVER_ADMIN_PATH; ?>gcomments">Discussions Listing</a></li>
                                  <!-- <li><a href="<?php echo SERVER_ADMIN_PATH; ?>comments_list">Comments Listing</a></li>-->
                                   
                                   <li><a href="<?php echo SERVER_ADMIN_PATH;?>report_checkbox_list">Report Option List</a></li>
                                   
                                    </ul>
                                </div>
                                <?php
								}
								?>
                                <?php
								/*if($top_video_module=='Yes')
								{
								?>
								<div class="childdiv" onMouseOver="overdivfunc(this.id);" onMouseOut="outdivfun(this.id);" id="slider">
									<div class="MidHeading" id="sliderMidHeading"><img src="images/video2.png" align="absmiddle" width="16" height="16">&nbsp;Manage Videos</div>
									<ul>
									<li><a href="<?php echo SERVER_ADMIN_PATH;?>video_list">Manage Video List</a></li>
									<?php
									if($top_video_module_add=='Yes')
									{
									?>
										<li><a href="<?php echo SERVER_ADMIN_PATH;?>addedit_video">Add Video</a></li>
									<?php
									}
									?>
									</ul>
								</div>
								<?php
								}*/
								?>
                                <?php
								if(session()->get('reviewsite_cpadmin_type')=='admin')
								{
								?>
                                <div class="childdiv" onMouseOver="overdivfunc(this.id);" onMouseOut="outdivfun(this.id);" id="moderator">
                                    <div class="MidHeading" id="moderatorMidHeading"><img src="images/moderator.png" align="absmiddle" width="16" height="16">&nbsp;Manage Moderator</div>
                                    <ul>
                                    	<li><a href="<?php echo SERVER_ADMIN_PATH;?>moderator_list">Manage Moderator List</a></li>
                                        <li><a href="<?php echo SERVER_ADMIN_PATH;?>addedit_moderator">Add Moderator</a></li>
                                    </ul>
                                </div>
                                <?php
								}
								?>
							</div>
                            
                            
							</div>
                        </td>

                      </tr>

                    </tbody>

                  </table>

                </div>

                <!-- End home -->

                <!-- Start pagefooter -->

              </td>

              <td width="10">&nbsp;</td>

            </tr>

          </tbody>

        </table></td>

    </tr>

    <tr>

      <td height="20" align="center">
          @include("admin.common.footer")

      </td>

    </tr>

  </tbody>

</table>

<!-- End pagefooter -->

</body>

</html>

