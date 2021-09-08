<div class="modal fade" id="signin_form" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-sm widht_half" style="margin-top:10%;">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#3276b1;"> Sign in to Tailem.com <img data-dismiss="modal" onclick="close_likes_popup();" style="cursor:pointer; float:right;" src="<?php echo SERVER_ROOTPATH; ?>images/crosspng.png">
                </h4>
            </div>
            <div class="modal-body" style="overflow-y:auto; min-height:250px;">
                <?php $currentFile = url()->current(); ?>
                <div class="row mobile_display">

                    <div class="col-lg-12">
                        <div class="account-wall">
                            <form class="form-signin" name="user_signin" id="login-form" method="post" action="{{url('sign-in')}}">

                                <a href="#"><span><img src="<?php echo SERVER_ROOTPATH ?>images/fb10.png" style="border-radius:5px" /></span></a>
                                <a href="#"><img src="<?php echo SERVER_ROOTPATH ?>images/g9.png" style="margin-top:5px; border-radius:5px;" alt="" /></a>
                                <span><img src="<?php echo SERVER_ROOTPATH ?>images/line.png" /> </span>
                                <div class="error"></div> 
                                <input type="hidden" name="redirect_url" value="<?php echo url()->current(); ?>">
                                @csrf 
                                <input type="text" name="email" id="email" class="form-control" placeholder="Username or Email" required autofocus>
                                <div class="mrgin_bootom">&nbsp;</div>
                                <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                                <input type="hidden" name="current_page" value="<?php echo $currentFile; ?>">

                                <button style="margin-top:10px;" class="btn btn-lg btn-primary btn-block" name="submit_btn" id="submit_btn" type="submit">Sign in</button>

                                <a href="<?php echo SERVER_ROOTPATH; ?>forgot-password" style="text-align:center; color:#3276B1; display:block; margin-left:auto; margin-right:auto; margin-top:10px; vertical-align:middle;">Forgot Password? </a><span class="clearfix"></span>
                            </form>
                        </div>
                        <p style="text-align:center; margin-top:8px;">Not a member? Please<a style="color:#3276B1;" href="<?php echo SERVER_ROOTPATH; ?>sign-up"> Sign up </a>now.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


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
                        setTimeout(function() { 
                            if(res.location == 'others')
                            {
                                location.reload(); 
                            }else
                            {
                                window.location.replace(res.url);

                            }
                        }, 500) 
                        break;
                    case 'warning': 
                        $('.error').append(res.message); 
                    
                }
            }
        });

    })
</script>