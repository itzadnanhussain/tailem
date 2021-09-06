@include('common.header');
<!-- ./Header end -->
<!-- Middle Section -->
<section class="middle_sec">

    <div class="container" style="min-height:500px;">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="account-wall">
                    <h4 class="account_hd"> Sign in to Tailem.com </h4>
                    <form class="form-signin" method="post" action="sign-in">
                        <a href="#"><span><img src="images/fb10.png" style="border-radius:5px" /></span></a>
                        <a href="#"><img src="images/g9.png" style="margin-top:5px; border-radius:5px;" alt="" /></a>
                        <span><img src="images/line.png" /> </span>

                        <div class="error"></div>
                        @csrf
                        <input type="text" name="email" id="email" class="form-control" placeholder="Username or Email" required autofocus>

                        <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>

                        <button style="margin-top:10px;" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                        
                        <a href="<?php echo SERVER_ROOTPATH; ?>forgot-password" style="text-align:center; color:#3276B1; display:block; margin-left:auto; margin-right:auto; margin-top:10px; vertical-align:middle;">Forgot Password? </a><span class="clearfix"></span>
                    </form>
                </div>
                <p style="text-align:center; margin:20px;">Not a member? Please<a style="color:#3276B1;" href="<?php echo SERVER_ROOTPATH; ?>sign-up"> Sign up </a>now.</p>
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