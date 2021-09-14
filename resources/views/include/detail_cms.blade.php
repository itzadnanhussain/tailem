<?php if($mobile_view == 1){?> 
<div class="modal-dialog" style="margin-top:30%;">
<?php }elseif($mobile_view == 0){?>
<div class="modal-dialog" style="margin-top:10%;">
<?php }?>

<div class="modal-content" style="border-radius:0px;">
<div class="modal-header">



<!--<div class="modal-dialog modal-lg" style="width:35%;">
<div class="modal-content">
<div class="modal-header">-->
        		<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SERVER_ROOTPATH;?>images/crosspng.png"></span></button>
        		<h4 class="modal-title text_blck"><?php echo stripslashes($get_page_content['page_name']);?></h4>
            -->
            
            <h4 class="modal-title" style="color:#3276b1;"><?php echo stripslashes($get_page_content['page_name']);?>
                <img data-dismiss="modal" onclick="close_likes_popup();" style="cursor:pointer; float:right;" src="<?php echo SERVER_ROOTPATH;?>images/crosspng.png">
                </h4>
            
            
            </div>
<!--<div class="modal-body" style="padding-top:0">-->
<div class="modal-body" style="overflow-y:auto; height:350px; overflow-x:hidden;">
            	 
                 <p><?php echo html_entity_decode($get_page_content['page_content']);?></p>
                
            </div>
</div>
</div>