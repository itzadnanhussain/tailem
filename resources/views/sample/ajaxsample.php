<script>
    $('#review_report_form').submit(function(e) {
        e.preventDefault();
        e.stopPropagation();
        let form = $(this).serialize();
        let url = $(this).attr('action');
        $.ajax({
            type: 'POST',
            url: url,
            data: form,
            dataType: 'html',
            success: function(responseText) {
                myarray = new Array();
                myarray = responseText.split("-SEPARATOR-");

                if (responseText.search("done") != -1) {
                    alert('here');
                    $("#report_Modal4_" + myarray[1]).modal("hide");
                    $("#add_report_request").modal("show");
                } else {
                    if (responseText.search("Msg") != -1) {
                        myarray1 = new Array();
                        myarray1 = responseText.split("-SEPARATOR-");

                        $("#report_Modal4_" + myarray1[2]).modal("hide");
                        $("#report_success").modal("show");
                    } else {
                        alert(responseText);
                    }
                }

            }
        });

    })
</script>