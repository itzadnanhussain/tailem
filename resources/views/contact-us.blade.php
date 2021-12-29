@include('common.header');
<!-- ./Header end -->


<?php
$arr_social = (array)$arr_social[0];
?>

<!-- Middle Section -->
<section class="middle_sec">

    <div class="container" style="min-height:600px;">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="account-wall">
                    <h4 class="account_hd">Contact Us </h4>
                    <form id="contact-frm" action="{{ url('contact-us') }}" method="post" class="form-signin contact">
                        <div id="res"></div>
                        <input type="hidden" id="token" value="{{ @csrf_token() }}">

                        <input name="name" id="name" type="text" class="form-control" placeholder="Your Name" autofocus>
                        <input name="email" id="email" type="text" class="form-control"
                            placeholder="Your Email Address">
                        <textarea id="message" name="message" type="text" class="form-control"
                            placeholder="Your Message"></textarea>

                        <?php
                        $letters = '234567890abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $length  = 5;
                        $lettersLength = strlen($letters) - 1;
                        for ($z = 1; $z <= 5; $z++) {
                            $s = '';
                            for ($i = 0; $i < $length; $i++) {
                                $s .= $letters[rand(0, $lettersLength)];
                            }
                        }

                        ?>


                        <button type="submit" name="submit_btn" id="submit_btn" style="margin-top:10px;"
                            onClick="return contactus_validation();"
                            class="btn btn-lg btn-primary btn-block">Submit</button>

                        <label class="terms_txt">
                            Thank you for visiting Tailem.com. Your concerns and feedback is incredibly important to us.
                            If you have any questions or feedback please feel free to use this form to contact us. You
                            can also reach us via email or find us on social media.
                        </label>


                        <?php
                        // $social_query  = "Select * from tbl_social_links ";
                        // $arr_social    = $db->get_row($social_query, ARRAY_A);

                        ?>
                        <label class="terms_txt"> You can find us on: &nbsp;</label>
                        <?php
                        if ($arr_social['facebook'] != '') {
                            ?>
                        <a href="<?php echo $arr_social['facebook']; ?>"
                            target="_blank"><img src="images/ico_fb.png"></a> &nbsp;
                        <?php
                        }

                        if ($arr_social['linkedin'] != '') {
                            ?>
                        <a href="<?php echo $arr_social['linkedin']; ?>"
                            target="_blank"><img src="images/ico_in.png"></a> &nbsp;
                        <?php
                        }

                        if ($arr_social['twitter'] != '') {
                            ?>
                        <a href="<?php echo $arr_social['twitter']; ?>"
                            target="_blank"><img src="images/ico_tw.png"></a> &nbsp;
                        <?php
                        }

                        if ($arr_social['google'] != '') {
                            ?>
                        <a href="<?php echo $arr_social['google']; ?>"
                            target="_blank"><img src="images/ico_gplus.png"></a> &nbsp;
                        <?php
                        }

                        if ($arr_social['pinterest'] != '') {
                            ?>
                        <a href="<?php echo $arr_social['pinterest']; ?>"
                            target="_blank"><img src="images/ico_p.png"></a>
                        <?php
                        }
                        ?>





                    </form>

                </div>
            </div>
        </div>
    </div>

</section>

@include('common.footer')



<!-- Model -->
<div class="modal fade" id="show_success_message" tabindex="-1" role="dialog" aria-labelledby="basicModal"
    aria-hidden="true">
    <div class="modal-dialog" style="margin-top:10%;">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#3276b1;"> Thank You <img data-dismiss="modal"
                        onclick="close_likes_popup();" style="cursor:pointer; float:right;"
                        src="{{url('images/crosspng.png')}}">
                </h4>
            </div>
            <div class="modal-body" style="overflow-y:auto; min-height:250px;">
                <p>
                    Thank you for sending us a message at Tailem.com. Your concerns and feedback is incredibly important
                    to us. We expect to attend to your message with in 24 hours via the email address you provided.
                    <br /><br /><br />

                    Warmest Regards,<br />
                    Team at Tailem.com
                </p>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"
    integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"
    integrity="sha512-XKa9Hemdy1Ui3KSGgJdgMyYlUg1gM+QhL6cnlyTe2qzMCYm4nAZ1PsVerQzTTXzonUR+dmswHqgJPuwCq1MaAg=="
    crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {
        $("#contact-frm").submit(function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            $("#submit_btn").attr('disabled', true);
            $("#submit_btn").text('Please wait..');
            $.post(url, {
                    '_token': $("#token").val(),
                    email: $("#email").val(),
                    name: $("#name").val(),
                    message: $("#message").val()
                },
                function(response) {
                    if (response.code == 400) {
                        $("#submit_btn").attr('disabled', false);
                        swal({
                            title: "Warning",
                            text: "Try After Some Time!",
                            icon: "warning",
                            button: false,

                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);

                    } else if (response.code == 200) {
                        $("#submit_btn").attr('disabled', false);
                        swal({
                            title: "Great",
                            text: "Email Send Successfully!",
                            icon: "success",
                            button: false,
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);

                    }
                });


        })
    })
</script>