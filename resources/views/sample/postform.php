<form class="process-form" action="<?php echo SERVER_ROOTPATH ?>process/delete_review_process" method="POST">
    @csrf
    <input type="hidden" name="review_id" value="<?php echo $review_id ?>">
    <input type="hidden" name="num" value="<?php echo $num ?>">
    <button style="margin-top:15px; display:inline; width:40%; float:left; background-color:#D73B3B; border-color:#D73B3B;" class="btn btn-lg btn-primary btn-block" type="submit">Delete</button>


</form>


<?php
$response = array("a" => 'done', 'b' => $num);
return response()->json($response);
?>


<script>
      $('.process-form').submit(function(e) {
        e.preventDefault();
        e.stopPropagation();
        let form = $(this).serialize();
        let url = $(this).attr('action');
        $.ajax({
            type: 'POST',
            url: url,
            data: form,
            dataType: 'html',
            success: function(data) {
                let res = JSON.parse(data);

                if (res.a == "Please sign in first") {
                    $("#signin_form").modal("show");
                } else {
                    if (res.a.search("done") != -1) {
                        $("#delete_review_" + res.b).hide();
                        $("#review_delete").modal("show");
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500)
                    } else {
                        alert(res.a);
                    }
                }

            }
        });

    })
</script>