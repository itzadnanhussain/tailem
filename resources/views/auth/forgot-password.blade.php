@include("common.header")
<!-- ./Header end -->

<!-- Middle Section -->
<section class="middle_sec">

    <div class="container" style="min-height:350px;">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="account-wall" style="min-height:268px; min-height: 268px;">


                    <form class="form-signin" name="forgot_password_frm" id="forgot_password_frm" method="post" action="" style="margin-top:0; padding-top:0; min-height:160px;">

                        <h4 class="account_hd"> Forgot your password? </h4>
                        <span><img src="<?php SERVER_ROOTPATH ?>images/sline.png" /> </span>
@csrf
                        <label class="terms_txt" style="margin-top:10px; padding-top:0; margin-bottom:20px;">
                            Please enter your email address below and we will send you a link to reset your password.
                        </label>
                        <div class="error" style="color:red;"></div>
                        <div class="success" style="color:#00CC00;"></div>
                        <input type="text" class="form-control" id="user_email" name="user_email" placeholder="Your email address" required autofocus>

                        <button style="float:left;" class="btn btn-lg btn-primary" type="submit" onClick="return forgot_pass_validation();" name="submit_btn" id="submit_btn">Send link</button>
                        <label class="terms_txt" style="cursor:pointer; color:#3276B1; font-size:20px; margin-left:112px;" onClick="window.location.href='<?php echo SERVER_ROOTPATH; ?>sign-in'">Cancel</label>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ./Middle Section -->
@include("common.footer")