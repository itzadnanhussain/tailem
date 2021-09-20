@include("common.header")
<!-- Middle Section -->
<section class="middle_sec">

    <div class="container" style="min-height:500px;">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="account-wall">
                    <h4 class="account_hd"> Welcome <?php echo $user_name; ?> </h4>
                    <form name="profile_pic" id="profile_pic" method="post" action="" class="form-signin" enctype="multipart/form-data">
                        <a style="color:#3276B1;">Change Profile Picture<br><br></a>
                        @csrf
                        <div class="error"></div>
                        <input type="file" name="image_name" id="image_name" class="form-control" placeholder="Choose Image">

                        <br>
                        <span>File types: JPG, PNG, GIF, JPEG</span>
                        <br>



                        <button style="margin-top:10px;" class="btn btn-lg btn-primary btn-block" type="submit" name="submit_btn" id="submit_btn" value="Submit" onClick="return changeimage_validation_new();">Update Profile Image</button>
                    </form>
                </div>
                <p style="text-align:center; margin:10px;"><a style="color:#3276B1;" href="<?php echo SERVER_ROOTPATH; ?>change-password"> Change Password </a> | <a style="color:#3276B1;" href="<?php echo SERVER_ROOTPATH; ?>change-username"> Change Username </a> | <a style="color:#3276B1; cursor:pointer;" onclick="goBack()"> Cancel </a></p>
            </div>
        </div>
    </div>

</section>
<!-- ./Middle Section -->
@include("common.footer")