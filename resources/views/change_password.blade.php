@include("common.header") 
<!-- Middle Section -->
<section class="middle_sec">

    <div class="container" style="min-height:500px;">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="account-wall">
                    <h4 class="account_hd"> Welcome <?php echo $user_name; ?> </h4>
                    <form class="form-signin" name="user_pass" id="user_pass" method="post" action="">
                        <a style="color:#3276B1;">Change Password <br><br></a>
                        @csrf
                        <div class="error"></div>
                        <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Old Password" required autofocus>
                        <input type="password" id="new_password" name="new_password" class="form-control" placeholder="New Password" required>
                        <input type="password" id="confirm_new_password" name="confirm_new_password" class="form-control" placeholder="Confirm New Password" required>

                        <button style="margin-top:10px;" class="btn btn-lg btn-primary btn-block" type="submit" name="submit_btn" id="submit_btn" value="Submit" onClick="return changepass_validation_new();">Update Password</button>
                    </form>
                </div>
                <p style="text-align:center; margin:10px;"><a style="color:#3276B1;" href="<?php echo SERVER_ROOTPATH; ?>change-picture"> Change Picture </a> | <a style="color:#3276B1;" href="<?php echo SERVER_ROOTPATH; ?>change-username"> Change Username </a> | <a style="color:#3276B1; cursor:pointer;" onclick="goBack()"> Cancel </a></p>
            </div>
        </div>
    </div>

</section>
<!-- ./Middle Section -->
@include("common.footer")