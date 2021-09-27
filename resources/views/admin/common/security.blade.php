<?php 
if((!session()->get('reviewsite_cpadmin_type')))
{
?>
	<script language="javascript">
		window.location.href="login";
	</script>
<?php
	exit;
}
else
{
	// session()->get('reviewsite_cpadmin_type')
	if(session()->get('reviewsite_cpadmin_type')=='user')
	{
			if($currentFile=='users_list' || $currentFile=='addedit_user')
			{	
				if($top_users_module!='Yes')
				{
				?>
					<script language="javascript">
						window.location.href="index";
					</script>
				<?php
				exit;
	
				}
				
				if($top_users_module_add!='Yes' && $currentFile=="addedit_user")
				{
				?>
					<script language="javascript">
						window.location.href="users_list";
					</script>
				<?php
				exit;
				}
			}
			if($currentFile=='slide_show_list' || $currentFile=='addedit_slideshow')
			{	
				if($top_slider_module!='Yes')
				{
				?>
					<script language="javascript">
						window.location.href="index";
					</script>
				<?php
				exit;
				}
				
				if($top_slider_module_add!='Yes' && $currentFile=="addedit_slideshow")
				{
				?>
					<script language="javascript">
						window.location.href="faq_list";
					</script>
				<?php
				exit;
				}
			}
			
			if($currentFile=='faq_list' || $currentFile=='addedit_faq')
			{	
				if($top_faq_module!='Yes')
				{
				?>
					<script language="javascript">
						window.location.href="index";
					</script>
				<?php
				exit;
	
				}
				
				if($top_faq_module_add!='Yes' && $currentFile=="addedit_faq")
				{
				?>
					<script language="javascript">
						window.location.href="faq_list";
					</script>
				<?php
				exit;
				}
			}
			
			if($currentFile=='main_cat_list' || $currentFile=='sub_cat_list' || $currentFile=='addedit_main_cat' || $currentFile=='addedit_sub_cat')
			{	
				if($top_categories_module!='Yes')
				{
				?>
					<script language="javascript">
						window.location.href="index";
					</script>
				<?php
				exit;
	
				}
				
				if($top_categories_module_add!='Yes' && ($currentFile=="add_sub_cat" || $currentFile=="edit_sub_cat" || $currentFile=='addedit_main_cat'))
				{
				?>
					<script language="javascript">
						window.location.href="main_cat_list";
					</script>
				<?php
				exit;
				}
			}
			
			if($currentFile=='ads_list' || $currentFile=='addedit_ads')
			{	
				if($top_advertisement_module!='Yes')
				{
				?>
					<script language="javascript">
						window.location.href="index";
					</script>
				<?php
				exit;
	
				}
				
				if($top_advertisement_module_add!='Yes' && $currentFile=="addedit_ads")
				{
				?>
					<script language="javascript">
						window.location.href="ads_list";
					</script>
				<?php
				exit;
				}

			}
			if($currentFile=='video_list' || $currentFile=='addedit_video')
			{	
				if($top_video_module!='Yes')
				{
				?>
					<script language="javascript">
						window.location.href="index";
					</script>
				<?php
				exit;
			
				}
				
				if($top_video_module_add!='Yes' && $currentFile=="addedit_ads")
				{
				?>
					<script language="javascript">
						window.location.href="video_list";
					</script>
				<?php
				exit;
				}
			
			}
			if($currentFile=='social_links')
			{	
				if($top_social_link_module!='Yes')
				{
				?>
					<script language="javascript">
						window.location.href="index";
					</script>
				<?php
				exit;
	
				}
			}
			
			if($currentFile=='page_list' || $currentFile=="edit_page")
			{	
				if($top_content_module!='Yes')
				{
				?>
					<script language="javascript">
						window.location.href="index";
					</script>
				<?php
				exit;
	
				}
				if($top_content_module_edit!='Yes' && $currentFile=="edit_page")
				{
				?>
					<script language="javascript">
						window.location.href="page_list";
					</script>
				<?php
				exit;
				}
			}
			
			if($currentFile=='email_templates_list' || $currentFile=="edit_email_template")
			{	
				if($top_email_template_module!='Yes')
				{
				?>
					<script language="javascript">
						window.location.href="index";
					</script>
				<?php
				exit;
				}
				
				if($top_email_template_module_edit!='Yes' && $currentFile=="edit_email_template")
				{
				?>
					<script language="javascript">
						window.location.href="email_templates_list";
					</script>
				<?php
				exit;
				}
			}
			
			if($currentFile=='countries_listing' || $currentFile=="addedit_country")
			{	
				if($top_country_module!='Yes')
				{
				?>
					<script language="javascript">
						window.location.href="index";
					</script>
				<?php
				exit;
				}
				
				if($top_country_module_add!='Yes' && $currentFile=="addedit_country")
				{
				?>
					<script language="javascript">
						window.location.href="countries_listing";
					</script>
				<?php
				exit;
				}
			}
			
			if($currentFile=='reviews_list' ||  $currentFile=="reviews_list_general" || $currentFile=="review_likes" || $currentFile=="review_comments" || $currentFile=="review_reports" || $currentFile=="review_reports" || $currentFile=="add_review" || $currentFile=="report_checkbox_list" || $currentFile=="add_report_checkbox" || $currentFile=="gcomments"  || $currentFile=="gcomments_likes" || $currentFile=="gcomments_reports" || $currentFile=="greview_details")
			{	
				if($top_reviews_module!='Yes')
				{
				?>
					<script language="javascript">
						window.location.href="index";
					</script>
				<?php
				exit;
				}
				
				if($top_reviews_module_add!='Yes' && ($currentFile=="add_review" || $currentFile=="add_report_checkbox"))
				{
				?>
					<script language="javascript">
						window.location.href="reviews_list";
					</script>
				<?php
				exit;
				}
			}
			
			
			if($currentFile=='moderator_list' ||  $currentFile=="moderator_rights" || $currentFile=="addedit_moderator")
			{
				if(session()->get('reviewsite_cpadmin_type')!='admin')
				{
					?>
					<script language="javascript">
						window.location.href="countries_listing";
					</script>
				<?php
				exit;
				}
			}			
			
	}
		
}
?>
