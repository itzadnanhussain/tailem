<?php
error_reporting(0);
$like_review_query = "select *
							from tbl_comments
							where 1=1 
							AND comment_id = $comment_id
							AND comment_user_id = '" . $user_id . "'";

$review_like_info  =  \App\Models\Songs::GetRawDataAdmin($like_review_query);

$comment_details    = $review_like_info['comment_details'];

?>
<style>
  .desktop_width {
    width: 50%;
  }

  @media(max-width:768px) {
    .desktop_width {
      width: 70%;
    }
  }
</style>

<?php if ($mobile_view == 1) { ?>
<div class="modal-dialog modal-lg" style="width:95%; margin-top:20%;">
  <?php } elseif ($mobile_view == 0) { ?>
  <div class="modal-dialog modal-lg desktop_width" style="margin-top:10%;">
    <?php } ?>
    <div class="modal-content">
      <div class="modal-header" style="padding:0; border-bottom:none; min-height:0;">
      </div>
      <div class="modal-body" style="padding:0; border:2px solid #666;">

        <img onclick="close_comment_popup();" data-dismiss="modal"
          src="<?php echo SERVER_ROOTPATH; ?>images/crosspng.png"
          style="float:right; cursor:pointer; margin-top:10px; margin-right:10px;">

        <div style="margin-top:0;">
          <form name="discussion_form" class="discussion_form" method="POST" style="padding:10px; padding-top:20px;">
            <h4 style="font-size:20px; font-weight:normal; margin-bottom:20px;">Edit your Post <?php
                                                                                                if (!$review_like_info) {
                                                                                                    echo ", Post does not exist.";
                                                                                                    exit;
                                                                                                }
                                                                                                ?>
            </h4>
            <!-- <input type="hidden" name="reviewsid" id="reviewsid" value="<?php echo $rev_id; ?>"
            /> -->

            <textarea style="margin-top:10px;" class="form-control" id="discussion_detail" name="discussion_detail"
              placeholder="Edit discussion"
              rows="4"><?php echo $comment_details; ?></textarea>
            @csrf
            <input type="hidden" name="edit_id"
              value="<?php echo $comment_id; ?>" />
            <input type="hidden" name="num"
              value="<?php echo $num; ?>" />

            <!-- <button id="button" name="submit_btn" style="margin-top:10px; display:inline; width:40%;"
              class="btn btn-lg btn-primary btn-block" type="submit"
              onClick="return discussion_validation_new()">Update</button> -->
            <input id="button" name="submit_btn" style="margin-top:10px; display:inline; width:40%;"
              class="btn btn-lg btn-primary btn-block" type="submit" value="Update">

            <a href="<?php echo SERVER_ROOTPATH; ?>delete_comment?comment_id=<?php echo $comment_id; ?>&num=<?php echo $num; ?>&critaria=1"
              data-toggle="modal"
              data-target="#delete_comment_<?php echo $num; ?>"
              data-title="" data-dismiss="modal" class="link-disable">
              <span
                style="margin-top:15px; display:inline; width:40%; float:right; background-color:#D73B3B; border-color:#D73B3B;"
                class="btn btn-lg btn-primary btn-block" type="button">Delete</span>
            </a>

            <!--  <button id="delete_btn" name="delete_btn" style="display:inline; width:40%; float:right; margin-top:10px; background-color:#D73B3B; border-color:#D73B3B;" onClick="return discussion_delete(<?php echo $comment_id; ?>);"
            class="btn btn-lg btn-primary btn-block" type="button">Delete</button>-->
          </form>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function close_comment_popup() {
      $(document).on('hidden.bs.modal', function(e) {
        $(e.target).removeData('bs.modal');
        window.location.reload();

      });
    }

    ///simple submit form
    $('.discussion_form').submit(function(e) {
      e.preventDefault();
      e.stopPropagation();
      var form = $(this).serialize();
      var url = JS_SERVER_PATHROOT + "process/discussion_update_process_test";
      $.ajax({
        type: 'POST',
        url: url,
        data: form,
        dataType: 'html',
        success: function(data) {
          let res = JSON.parse(data);
          switch (res.code) {
            case 'success':
              $("#edit_Modal4_" + res.num).modal("hide");
              $("#post_edit_success").modal("show");
              window.location.reload();
              break;
            case 'error':
              alert(res.message)

          }
        },
      });
    })
  </script>