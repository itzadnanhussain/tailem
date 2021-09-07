<!--<h2 class="mt-0 pull-left display_dekstop">
<?php if($main_link!=""){ } else {echo "Welcome";}?>
 <?php echo $USER_NAME;?></h2>-->
                <?php
				if($main_link=="")
	 			{
					if($mobile_view == 0)
					{
						?>
                        <div class="text_12 review_ipad" style="margin-top:5px;">
                            <a href="<?php echo SERVER_ROOTPATH;?>change-picture" style="color:#000000;"><i class="fa fa-camera text_red"></i> Change Picture</a>
                             <?php if($mobile_view==1){?>  &nbsp;&nbsp; | &nbsp;&nbsp;  <?php }else{?> <br> <?php }?>
                            <a href="<?php echo SERVER_ROOTPATH;?>change-password" style="color:#000000;"><i class="fa fa-key text_red"></i> Change Password</a>
                            
                            <?php if($mobile_view==1){?>  &nbsp;&nbsp; | &nbsp;&nbsp;  <?php }else{?> <br> <?php }?>
                            <a href="<?php echo SERVER_ROOTPATH;?>change-username" style="color:#000000; float:left;"> <i class="fa fa-user text_red" style="margin-right:3px;"></i>&nbsp;Change Username</a>
                            
                        </div>
                        
                        
                        <?php	
					}
					else
					if($mobile_view == 1)
					{
							?>
                            <div class="text_12" style="margin-top:5px; float:left;">
                	<a href="<?php echo SERVER_ROOTPATH;?>change-picture" style="color:#000000;"><i class="fa fa-camera text_red"></i> Change Picture</a>
                   	 &nbsp;&nbsp; | &nbsp;&nbsp;
                    <a href="<?php echo SERVER_ROOTPATH;?>change-password" style="color:#000000;"><i class="fa fa-key text_red"></i> Change Password</a>
                    &nbsp;&nbsp; | &nbsp;&nbsp;
                    <a href="<?php echo SERVER_ROOTPATH;?>change-username" style="color:#000000; margin-top:-3px;"> <i class="fa fa-user text_red" style="margin-right:3px;"></i>&nbsp;Change Username</a>
                    
                </div>
                            <?php
					}
				?>
                
                <?php
				}
				?>