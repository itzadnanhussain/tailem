 <?php if ($mobile_view == 1) { ?>
 	<div class="modal-dialog" style="margin-top:30%;">
 	<?php } elseif ($mobile_view == 0) { ?>
 		<div class="modal-dialog" style="margin-top:10%;">
 		<?php } ?>

 		<div class="modal-content" style="border-radius:0px;">
 			<div class="modal-header">
 				<h4 class="modal-title" style="color:#3276b1;"><?php echo $get_page_content['page_name']; ?>
 					<img data-dismiss="modal" onclick="close_likes_popup();" style="cursor:pointer; float:right;" src="<?php echo SERVER_ROOTPATH; ?>images/crosspng.png">
 				</h4>
 			</div>
 			<div class="modal-body" style="overflow-y:auto; height:400px;">
 				<p><?php echo html_entity_decode($get_page_content['page_content']);   ?></p>
 			</div>
 		</div>
 		</div>