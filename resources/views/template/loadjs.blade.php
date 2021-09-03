<script src="{{ url('/js/jquery.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{ url('/js/merged.min.js') }}" async></script>
<script type="text/javascript" src="{{ url('/js/ourjs14.js')}}"></script>
<script type='text/javascript' src="{{ url('/js/jquery.autocomplete.min.js')}}"></script>
<script type='text/javascript' src="{{ url('/js/utility.js')}}"></script>
<script type="text/javascript">
    function unset_all() {
        window.location.href = "artist-unset";
    }
</script>
<script type="text/javascript">
    $().ready(function() {
        $("#search_text").autocomplete("get_artist_list.php", {
            width: 300,
            matchContains: true,
            selectFirst: false
        });
    });
</script>
<script src="{{ url('/js/jquery.MetaData.js')}}" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
    function show_notification() {
        $.ajax({
            type: "POST",
            url: JS_SERVER_PATHROOT + 'process/notification_display.php',
            data: '',
            before: gotonew(),
            success: function(msg) {

                $('#loader_new').html('');
                $('#notify_list2').html(msg);
                $('#notify_list2').show();



            }
        });


    }

    function gotonew() {

        $('#loader_new').html('<img src="images/load.gif" />');
        $('#loader_new').show();
    }
</script>
<script>
    //function search_bar(){ 
    $("#mob_search").click(function() {
        $("#search_bar").toggle();
    });
    //}
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#notificationLink").click(function() {
            $("#notificationContainer").fadeToggle(300);
            $("#notification_count").fadeOut("slow");
            return false;
        });

        //Document Click
        $(document).click(function() {
            $("#notificationContainer").hide();
        });
        //Popup Click
        $("#notificationContainer").click(function() {
            return false
        });

    });
</script>

<!-- sweet alert cdn -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function call_swal(title, text, icon, button) {
        swal({
            title: title,
            text: text,
            icon: icon,
            button: button,
            timer: 4000,
        });
    }
</script>