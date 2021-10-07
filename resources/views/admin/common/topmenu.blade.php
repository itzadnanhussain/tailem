<div id="slidemenu" class="slidetabsmenu" style="margin:0px;">

  <ul>    

  	

  	<li>

    	<?php

		if($top_slider_module=='Yes')

		{

		?>

        	<a href="<?php echo SERVER_ADMIN_PATH;?>index" title="Home Page" ><span>Home </span></a>

        <?php

		}

		else

		{

		?>

        	<a href="javascript:;" title="Home Page" onclick="window.location='<?php echo SERVER_ADMIN_PATH;?>index'"><span>Home </span></a>

        <?php

		

		}

		?>

    </li>

    <?php

	if($top_users_module=='Yes')

	{

	?>

    	<li><a href="javascript:;" title="Users" rel="users_links"><span>Manage Users</span></a></li>

    <?php

	}

	if($top_artist_module=='Yes' || session()->get('reviewsite_cpadmin_type')=='admin')
	{
	?>

    	<li><a href="javascript:;" title="Artist" rel="artist_div"><span>Manage Artists </span></a></li>
    <?php
	}
	if($top_song_module=='Yes' || session()->get('reviewsite_cpadmin_type')=='admin')
	{
	?>

    	 <li><a href="javascript:;" title="Songs" rel="songs_div"><span>Manage Songs </span></a></li>
    <?php
	}	
	if($top_album_module=='Yes' || session()->get('reviewsite_cpadmin_type')=='admin')
	{
	?>

    	 <li><a href="javascript:;" title="Albums" rel="albums_div"><span>Manage Albums </span></a></li>
    <?php
	}
	?>    
       
        
         

   

    <?php

	if($top_categories_module=='Yes' || session()->get('reviewsite_cpadmin_type')=='admin')

	{

	?>

    	<li><a href="javascript:;" title="Categories" rel="category_links"><span>Manage Categories</span></a></li>

    <?php

	}

	?>

    <?php

	if($top_advertisement_module=='Yes')

	{

	?>

    	<li><a href="javascript:;" title="Advertisement" rel="ads_links"><span>Advertisement Management</span></a></li>

    <?php

	}

	?>

    <?php

	if($top_social_link_module=='Yes' || $top_content_module=='Yes' || $top_email_template_module=='Yes' || $top_country_module=='Yes')

	{

	?>

   		<li><a href="javascript:;" title="General Setting" rel="general_links"><span>General Setting</span></a></li>

    <?php

	}

	?>

    <?php

	if($top_reviews_module=='Yes')

	{

	?>

    	<li><a href="javascript:;" title="Reviews" rel="Comment_links"><span>Reviews Management</span></a></li>

    <?php

	}

	?>
    
    

    <?php

	if(session()->get('reviewsite_cpadmin_type')=='admin')

	{

	?>

    	<li><a href="javascript:;" title="Moderator" rel="Moderator_links"><span>Moderator Management</span></a></li>

    <?php

	}

	?>

  </ul>

</div>

	<?php

	if($top_slider_module=='Yes')

	{

	?>


    <?php

	}

	?>

	<?php

	if($top_users_module=='Yes')

	{

	?>

        <div id="users_links" class="dropmenudiv_c" style="width:110px;"> 

            <a href="<?php echo SERVER_ADMIN_PATH;?>users_list">Users Listing</a>

            <?php

			if($top_users_module_add=='Yes')

			{

			?>

            	<a href="<?php echo SERVER_ADMIN_PATH;?>addedit_user">Add User</a>

            <?php

			}

            ?>

        </div>

    <?php

	}

	
	if($top_artist_module=='Yes' || session()->get('reviewsite_cpadmin_type')=='admin')
	{
	?>

        <div id="artist_div" class="dropmenudiv_c" style="width:101px;"> 

            <a href="<?php echo SERVER_ADMIN_PATH;?>artist_list">Artist List</a>

            <?php

            if($top_artist_module_add=='Yes')

            {

            ?>

                <a href="<?php echo SERVER_ADMIN_PATH;?>addedit_artist">Add Artist</a>

            <?php

            }

            ?>

        </div>
   <?php
   }
   
   if($top_album_module=='Yes' || session()->get('reviewsite_cpadmin_type')=='admin')
	{
	?>

        <div id="albums_div" class="dropmenudiv_c" style="width:101px;"> 

            <a href="<?php echo SERVER_ADMIN_PATH;?>album_list">Album List</a>
        </div>
   <?php
   }
   
    if($top_song_module=='Yes' || session()->get('reviewsite_cpadmin_type')=='admin')
	{
	?>

        <div id="songs_div" class="dropmenudiv_c" style="width:101px;"> 

            <a href="<?php echo SERVER_ADMIN_PATH;?>song_list">Songs List</a>
            
           <!-- <a href="<?php echo SERVER_ADMIN_PATH;?>song_list_ranking">Songs Ranking List</a>-->

            <?php

            if($top_song_module_add=='Yes')

            {

            ?>

                <a href="<?php echo SERVER_ADMIN_PATH;?>addedit_song">Add Song</a>

            <?php

            }

            ?>

        </div>
   <?php
   }
   ?>     
        
       
        
         
        


    <?php

	if($top_categories_module=='Yes')

	{

	?>

        <div id="category_links" class="dropmenudiv_c" style="width:170px;"> 

            <a href="<?php echo SERVER_ADMIN_PATH;?>main_cat_list">Main Categories List</a>

            <?php

			if($top_categories_module_add=='Yes')

			{

			?>

            	<a href="<?php echo SERVER_ADMIN_PATH;?>addedit_main_cat">Add Main Category</a>

            <?php

			}

			?>

             
        </div>

    <?php

	}

	?>

    <div id="general_links" class="dropmenudiv_c" style="width:125px;"> 

        <?php

        if($top_social_link_module=='Yes')

        {

        ?>
            <a href="<?php echo SERVER_ADMIN_PATH; ?>general_setting" title="Manage General Setting">General Setting</a> 
            <a href="<?php echo SERVER_ADMIN_PATH; ?>social_links" title="Manage Social Links">Follow Us</a>
            <a href="<?php echo SERVER_ADMIN_PATH; ?>social_icons" title="Manage Social Icons">Social Icons</a>
            

        <?php

        }

        ?>

        <?php

        if($top_content_module=='Yes')

        {

        ?>

            <a href="<?php echo SERVER_ADMIN_PATH;?>page_list">Contents Listing</a>

        <?php

        }

        ?>

        <?php

        if($top_email_template_module=='Yes')

        {

        ?>

            <a href="<?php echo SERVER_ADMIN_PATH;?>email_templates_list">Email Templates</a>

        <?php

        }

        ?>

        

    </div>

    <?php
	if($top_advertisement_module=='Yes')
	{
	?>
        <div id="ads_links" class="dropmenudiv_c" style="width:203px;"> 
            <a href="<?php echo SERVER_ADMIN_PATH;?>ads_list">Advertisement List</a>
            <?php
			if($top_advertisement_module_add=='Yes')
			{
			?>
            	<a href="<?php echo SERVER_ADMIN_PATH;?>addedit_ads">Add Advertisement</a>
            <?php
			}
			?>
         
        </div>
    <?php
	}
	?>
	<?php
	if($top_video_module=='Yes')
	
	{
	
	?>
	
		<div id="video_links" class="dropmenudiv_c" style="width:192px;"> 
	
			<a href="<?php echo SERVER_ADMIN_PATH;?>video_list">Videos List</a>
	
			<?php
	
			if($top_video_module_add=='Yes')
	
			{
	
			?>
	
				<a href="<?php echo SERVER_ADMIN_PATH;?>addedit_video">Add Video</a>
	
			<?php
	
			}
	
			?>
	
		</div>
	
	<?php
	
	}
	
	?>
	<?php
	if($top_reviews_module=='Yes')
	{
	?>
    	<div id="Comment_links" class="dropmenudiv_c" style="width:164px;"> 
            <a href="<?php echo SERVER_ADMIN_PATH;?>reviews_list">Local Reviews Listing</a>
            <?php /*

			if($top_reviews_module_add=='Yes')
			{
			?>
           	<a href="<?php echo SERVER_ADMIN_PATH; ?>add_review">Add Review</a>
            <?php
			}*/
			?>
            <a href="<?php echo SERVER_ADMIN_PATH;?>gcomments">Discussions Listing</a>
            <!--<a href="<?php echo SERVER_ADMIN_PATH;?>comments_list">Comments Listing</a>-->
			<a href="<?php echo SERVER_ADMIN_PATH;?>report_checkbox_list">Report Option List</a>
    	</div>
<?php
	}
	if(session()->get('reviewsite_cpadmin_type')=='admin')
	{
	?>
        <div id="Moderator_links" class="dropmenudiv_c" style="width:178px;"> 
            <a href="<?php echo SERVER_ADMIN_PATH;?>moderator_list">Moderator List</a>
            <a href="<?php echo SERVER_ADMIN_PATH;?>addedit_moderator">Add Moderator</a>
        </div>
    <?php
	}
	?>
<script type="text/javascript"> 
tabdropdown.init("slidemenu");
</script>