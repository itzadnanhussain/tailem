@include("common.header")

<!-- Middle Section -->
<section class="middle_sec">

    <div class="container" style="min-height:500px;">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="account-wall">
                    <h4 class="account_hd"> Welcome <?php echo $user_name; ?> </h4>
                    <form class="form-signin" name="user_name" id="user_name" method="post" action="">
                        <a style="color:#3276B1;">Change Username <br><br></a>
                        @csrf
                        <div class="error" style="display:none; margin-bottom:11px;"></div>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Please enter your new username">

                        <button style="margin-top:10px;" class="btn btn-lg btn-primary btn-block" type="submit" name="submit_btn" id="submit_btn" value="Submit" onClick="return changeusername_validation();">Update Username</button>
                    </form>
                </div>
                <p style="text-align:center; margin:20px;"><a style="color:#3276B1;" href="<?php echo SERVER_ROOTPATH; ?>change-picture"> Change Picture </a> | <a style="color:#3276B1;" href="<?php echo SERVER_ROOTPATH; ?>change-password"> Change Password </a> | <a style="color:#3276B1; cursor:pointer;" onclick="goBack()"> Cancel </a></p>
            </div>
        </div>
    </div>

</section>
<!-- ./Middle Section -->
@include("common.footer")