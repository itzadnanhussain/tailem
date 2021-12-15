@include("common.header")

<!-- Middle Section -->
<section class="middle_sec">

    <div class="container" style="min-height:500px;">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="account-wall">
                    <h4 class="account_hd"> You can update social links here </h4>
                    <form class="form-social-icon form-signin">
                        <div class="error" style="display:none;margin-bottom:11px;"></div>
                        @csrf

                        <select name="icon_type" id="icon-type" style="margin-bottom: 10px;" class="form-control"
                            onchange="icon_change_div(this.value)">

                            <option value="">Select Link Name</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Twitter">Twitter</option>
                            <option value="Instagram">Instagram</option>
                        </select>
                        <input type="text" name="icon_link" class="form-control" placeholder="Social link">
                        <!-- <input type="file" name="icon_image" class="form-control"> -->
                        <input type="hidden" name="user_id"
                            value="<?php echo session()->get('user_id') ?>"
                            class="form-control">




                        <button style="margin-top:10px;" class="btn btn-lg btn-primary btn-block" type="submit"
                            name="submit_btn" id="submit_btn" value="Submit">Update Social links</button>
                    </form>
                </div>
                <p style="text-align:center; margin:20px;"><a style="color:#3276B1;"
                        href="<?php echo SERVER_ROOTPATH; ?>change-picture">
                        Change Picture </a> | <a style="color:#3276B1;"
                        href="<?php echo SERVER_ROOTPATH; ?>change-password">
                        Change Password </a> | <a style="color:#3276B1; cursor:pointer;" onclick="goBack()"> Cancel </a>
                </p>
            </div>
        </div>
    </div>

</section>
<!-- ./Middle Section -->
@include("common.footer")
<script>
    function icon_change_div(value) {
        ///project type
        // if (value == 'Facebook') {
        //     $('#project-type').css('display', 'block');
        //     $('#project-type select[name="project_type"]').attr('disabled', false);

        //     $('#completed-tasks-link').css('display', 'none');
        //     $('#completed-tasks-link input').attr('disabled', true);

        //     $('#estimation_link').css('display', 'none');
        //     $('#estimation_link input').attr('disabled', true);
        // }
    }

    $('.form-social-icon').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $('.error').html('');
        $('.error').hide();
        $.ajax({
            type: 'POST',
            url: '<?php echo SERVER_ROOTPATH . 'process-update-profile-social-icon' ?>',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                switch (res.code) {
                    case 'success':
                        alert(res.message);
                        window.location.href =
                            "<?php echo SERVER_ROOTPATH.'review-artist' ?>";

                        break;
                    case 'warning':
                        $('.error').css('display', 'block');
                        $('.error').html(res.message);
                        break;
                }
            }
        });
    });
</script>