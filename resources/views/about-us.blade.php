@include('common.header');
<!-- ./Header end -->
<!-- Middle Section -->
<section class="middle_sec">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
				<div class="account-wall" style="border: 1px solid rgb(210, 210, 210); padding: 15px; margin-top: 12px;">
					<h4 class="account_hd"> <?php echo $get_page_content['page_name']; ?> </h4>
					<form name="contat_us_frm" id="contat_us_frm" method="post" action="" class="form-signin cms_wid">
						<label class="terms_txt">
							<?php echo html_entity_decode($get_page_content['page_content']); ?>
						</label>
					</form>

				</div>
			</div>
		</div>
	</div>
	<div style="background-color:F5F5F5; min-height:10px;"></div>
</section>

<!-- ./Middle Section -->  
@include('common.footer');