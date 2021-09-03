@include('common.header');
<!-- ./Header end --> 
<!-- Middle Section -->
<section class="middle_sec"> 
	<div class="container" style="min-height:550px;">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
				<div class="account-wall">
					<h4 class="account_hd"> Sign up with Tailem.com </h4>

					<form   method="POST" action="{{ route('register') }}" class="form-signin">
						<span><a onClick="custFBLog();" href="javascript:;"><img src="images/fb8signup.png" style="width:100%;" /></a></span>
						<a href="#"><img src="images/g8_signup.png" alt="" style="margin-top:5px; max-width:100%;"/></a>
						<span><img src="images/line.png" /> </span>

						<div id="error_div" class="error_class"></div>
						<div class="error"></div>
						@csrf
						<input type="text" name="user_name" id="user_name" class="form-control" placeholder="Username" required autofocus>

						<input type="text" class="form-control" name="email" id="user_email" placeholder="Email" required>

						<input type="password" class="form-control" placeholder="Password" name="password" id="simple_password" required>
						<input type="password" class="form-control" placeholder="Password" name="password_confirmation" id="simple_password" required>
						<!-- <input type="file" class="form-control" placeholder="Profile Picture" required>-->
						<!-- <input style="margin-top:10px;" class="btn btn-lg btn-primary btn-block" type="submit" name="submit_btn" id="submit_btn" onClick="return register_validation6();" value="Sign Up"> -->
						<input style="margin-top:10px;" class="btn btn-lg btn-primary btn-block" type="submit" name="submit_btn"  value="Sign Up">

						<label class="terms_txt">
							By creating an account, I accept Tailem.com's <a style="color:#3276B1;" href="<?php echo SERVER_ROOTPATH; ?>signup_popup.php/privacy-policy" data-toggle="modal" data-target="#missing_popular_review_Modal2_5000" data-title="">Privacy Policy </a>and <a style="color:#3276B1;" href="<?php echo SERVER_ROOTPATH; ?>signup_popup.php/terms-of-use" data-toggle="modal" data-target="#missing_popular_review_Modal2_5000" data-title="">Terms of Use</a>.

						</label>
					</form>
				</div>
				<p style="text-align:center; margin:20px;">Already a member? Please <a style="color:#3276B1;" href="<?php echo SERVER_ROOTPATH; ?>sign-in">Sign in</a> now</p><span class="clearfix"></span>
			</div>
		</div>
	</div> 
</section>
<!-- ./Middle Section -->

<div class="modal fade" id="missing_store_detail_Modal2_5000" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
@include('common.footer');  
<script type="text/javascript">
	function register_validation6() {
		$('#user_signup').unbind('submit');
		var options = {
			target: '',
			beforeSubmit: register_validationRequestb,
			success: register_validationResponsea,
			url: JS_SERVER_PATHROOT + 'process/UserRegister.php'
		};
		$('#user_signup').submit(function() {
			$(this).ajaxSubmit(options);
			return false;
		});

	}


	function register_validationRequestb(formData, jqForm, options) {
		var queryString = $.param(formData);
		return true;
	}

	function register_validationResponsea(responseText, statusText) {

		var myarray = new Array();
		myarray = responseText.split("-SEPARATOR-");

		if (myarray[0] == 'done') {
			window.location.href = JS_SERVER_PATHROOT + "welcome-" + myarray[2];
		} else {
			$('.error').html(responseText);
			$('.error').show();
			var x = $(".error").position();
			window.scrollTo(x.left, x.top);
		}

	}
</script>