@include('common.header');
<!-- ./Header end -->
<!-- Middle Section -->
<section class="middle_sec">

    <div class="container" style="min-height:500px;">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="account-wall">
                    <h4 class="account_hd"> Sign in to Tailem.com </h4>
                    <form class="form-signin" id="login-form" method="post" action="sign-in">
                        <a href="{{ url('auth/facebook') }}"><span><img src="images/fb10.png"
                                    style="border-radius:5px" /></span></a>
                        <a href="{{ url('auth/google') }}"><img src="images/g9.png"
                                style="margin-top:5px; border-radius:5px;" alt="" /></a>

                        <div class="error"></div>
                        <span><img src="images/line.png" /> </span>
                        @csrf
                        <input type="text" name="email" id="email" class="form-control" placeholder="Username or Email"
                            required autofocus>

                        <input id="password" name="password" type="password" class="form-control" placeholder="Password"
                            required>

                        <button style="margin-top:10px;" class="btn btn-lg btn-primary btn-block" type="submit">Sign
                            in</button>

                        <a href="<?php echo SERVER_ROOTPATH; ?>forgot-password"
                            style="text-align:center; color:#3276B1; display:block; margin-left:auto; margin-right:auto; margin-top:10px; vertical-align:middle;">Forgot
                            Password? </a><span class="clearfix"></span>
                    </form>
                </div>
                <p style="text-align:center; margin:20px;">Not a member? Please<a style="color:#3276B1;"
                        href="<?php echo SERVER_ROOTPATH; ?>sign-up">
                        Sign up </a>now.</p>
            </div>
        </div>
    </div>

</section>
<!-- ./Middle Section -->

<div class="modal fade" id="missing_store_detail_Modal2_5000" tabindex="-1" role="dialog" aria-labelledby="basicModal"
    aria-hidden="true"></div>
@include('common.footer');


<script>
    $('#login-form').submit(function(e) {
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
                        $('.error').append(res.message);

                }
            }
        });

    })
</script>