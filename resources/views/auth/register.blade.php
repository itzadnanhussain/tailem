@include('common.header');
<!-- ./Header end -->
<!-- Middle Section -->
<section class="middle_sec">
    <div class="container" style="min-height:550px;">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="account-wall">
                    <h4 class="account_hd"> Sign up with Tailem.com </h4>

                    <form id="register-form" method="POST" action="{{ url('sign-up') }}" class="form-signin">
                        <span><a onClick="custFBLog();" href="javascript:;"><img src="images/fb8signup.png"
                                    style="width:100%;" /></a></span>
                        <a href="{{ url('auth/google') }}"><img src="images/g8_signup.png" alt=""
                                style="margin-top:5px; max-width:100%;" /></a>
                        <div class="error"></div>
                        <span><img src="images/line.png" /> </span>

                        <div id="error_div" class="error_class"></div>
                        @csrf
                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Username"
                            required autofocus>

                        <input type="text" class="form-control" name="email" id="user_email" placeholder="Email"
                            required>

                        <input type="password" class="form-control" placeholder="Password" name="password"
                            id="simple_password" required>
                        <!-- <input type="password" class="form-control" placeholder="Password" name="password_confirmation" id="simple_password" required> -->
                        <!-- <input type="file" class="form-control" placeholder="Profile Picture" required>-->
                        <!-- <input style="margin-top:10px;" class="btn btn-lg btn-primary btn-block" type="submit" name="submit_btn" id="submit_btn" onClick="return register_validation6();" value="Sign Up"> -->
                        <input style="margin-top:10px;" class="btn btn-lg btn-primary btn-block" type="submit"
                            name="submit_btn" value="Sign Up">

                        <label class="terms_txt">
                            By creating an account, I accept Tailem.com's <a style="color:#3276B1;"
                                href="<?php echo SERVER_ROOTPATH; ?>signup_popup/privacy-policy"
                                data-toggle="modal" data-target="#missing_popular_review_Modal2_5000"
                                data-title="">Privacy Policy </a>and <a style="color:#3276B1;"
                                href="<?php echo SERVER_ROOTPATH; ?>signup_popup/terms-of-use"
                                data-toggle="modal" data-target="#missing_popular_review_Modal2_5000"
                                data-title="">Terms of Use</a>.

                        </label>
                    </form>
                </div>
                <p style="text-align:center; margin:20px;">Already a member? Please <a style="color:#3276B1;"
                        href="<?php echo SERVER_ROOTPATH; ?>sign-in">Sign
                        in</a> now</p><span class="clearfix"></span>
            </div>
        </div>
    </div>
</section>
<!-- ./Middle Section -->

<div class="modal fade" id="missing_store_detail_Modal2_5000" tabindex="-1" role="dialog" aria-labelledby="basicModal"
    aria-hidden="true"></div>
@include('common.footer');


<script>
    $('#register-form').submit(function(e) {
        e.preventDefault();
        e.stopPropagation();
        let form = $(this).serialize();
        let url = $(this).attr('action');
        $('.error').html('');

        $.ajax({
            type: 'POST',
            url: url,
            data: form,
            dataType: 'html',
            success: function(data) {
                let res = JSON.parse(data);
                switch (res.code) {
                    case 'success':
                        ///redirect to dashboard
                        setTimeout(function() {
                            window.location.replace(res.url);
                        }, 500)

                        break;
                    case 'warning':
                        // $('.alert').addClass('alert-fill-warning');
                        $('.error').append(res.message);
                        // $('.alert').show();




                    case 'error':
                        // $('.alert').addClass('alert-fill-danger');
                        $('.error').append(res.message);
                        // $('.alert').show();
                        // res.message.forEach(function(error) {
                        //     $('[name=' + error[0] + ']').parent().append('<span>' + error[1] + '</span>');
                        // })
                        break;
                }
            }
        });

    })
</script>