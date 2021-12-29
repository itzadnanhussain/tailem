@include("admin.includes.top")
@include("admin.common.security")
<?php
error_reporting(0);
//---------- Ordering ----------//
switch ($sortby) {
    case "latestdesc":
        $orderby	= " ORDER BY latest desc";
        break;

    case "latestasc":
        $orderby	= " ORDER BY latest asc";
        break;

    case "popularitydesc":
        $orderby	= " ORDER BY popularity desc";
        break;

    case "popularityasc":
        $orderby	= " ORDER BY popularity asc";
        break;

    case "ranking_order_asc":
        $orderby	= " ORDER BY ranking_order asc";
        break;

    case "ranking_order_desc":
        $orderby	= " ORDER BY ranking_order desc";
        break;

    case "statusdesc":
        $orderby	= " ORDER BY song_status desc";
        break;

    case "statusasc":
        $orderby	= " ORDER BY song_status asc";
        break;

    default:
        $orderby = "ORDER BY tbl_songs.id ASC";
        break;
}

/*================== Search Filter Start Here=================*/
if (isset($_POST['filter'])) {
    $sess_where = "";
    if ($_REQUEST['song_itunesid'] != "") {
        $sess_where = " and tbl_songs.id  = " . $_REQUEST['song_itunesid'] . "";
        session()->put('song_itunesid_sess', trim($_REQUEST['song_itunesid']));
    } else {
        session()->put('song_itunesid_sess', null);
    }


    if ($_REQUEST['song_title'] != "") {
        //$sess_where .= " and song_title  like \"%".trim($_REQUEST['song_title'])."%\" ";
        session()->put('song_title_sess', trim($_REQUEST['song_title']));

        //New code

        $search_var =  trim($_REQUEST['song_title']);
        $search_var = htmlentities($search_var, ENT_QUOTES);
        $search_var = preg_replace('/&#0+([1-9]+)/', '&#$1', $search_var);
        //$sess_where .= " and tbl_songs.song_title  like '".trim(addslashes($_REQUEST['song_title']))."%'";
        $newString = '';
        $symbol = '+';
        $newString = $symbol . str_replace(' ', " $symbol", $_REQUEST['song_title']);

        // $sess_where .= " and  MATCH (tbl_songs.song_title) AGAINST ('".trim(addslashes($newString))."' IN BOOLEAN MODE) ";
        $sess_where .= " and  MATCH (tbl_songs.song_title) AGAINST ('+" . trim(addslashes($newString)) . "' IN BOOLEAN MODE) ";
    //$where_search = " where tbl_songs.song_title  like '".trim(addslashes($_REQUEST['song_title']))."%'";
    } else {
        session()->put('song_title_sess', null);
    }

    if ($_REQUEST['artist_title'] != "") {
        //$sess_where .= " and tbl_artists.artist_name  like '".trim(addslashes($_REQUEST['artist_title']))."%' ";

        $newString = '';
        $symbol = '+';
        $newString = $symbol . str_replace(' ', " $symbol", $_REQUEST['artist_title']);

        // $sess_where .= " and MATCH (tbl_artists.artist_name) AGAINST ('".trim(addslashes($newString))."' IN BOOLEAN MODE) ";
        $sess_where .= " and MATCH (tbl_artists.artist_name) AGAINST ('+" . trim(addslashes($newString)) . "' IN BOOLEAN MODE) ";
        // $sess_where .= " and MATCH (artist_name) AGAINST ('+" . trim(addslashes($newString)) . "' IN BOOLEAN MODE) ";

        session()->put('artist_title_sess', trim($_REQUEST['artist_title']));
    } else {
        session()->put('artist_title_sess', null);
    }


    if ($_REQUEST['song_status'] != "") {
        $sess_where .= " and song_status = '" . $_REQUEST['song_status'] . "'";
        session()->put('song_status', $_REQUEST['song_status']);
    } else {
        session()->put('song_status', null);
    }
    session()->put('sess_faq', $sess_where);


    $session_where = session()->get('sess_faq');
    $limit = 20; 					//how many items to show per page
    $start = 0;
    $sr_no = 0;
    //PAGGING CODE STARTS HERE



    $targetpage = "song_list"; //your file name  (the name of this file)



    $c = 1;
    if (session()->get('artist_title_sess') != "") {	//echo "artist1";

        $song_list = "Select tbl_songs.id, tbl_songs.song_title, tbl_songs.picture, tbl_songs.description, tbl_songs.song_status, tbl_songs.latest,tbl_songs.popularity,tbl_songs.posted_date,tbl_songs.ranking_order,tbl_artists.id as artist_id from tbl_songs INNER JOIN tbl_songs_artist on tbl_songs_artist.song_id=tbl_songs.id INNER JOIN tbl_artists on tbl_songs_artist.artist_id=tbl_artists.id where 1=1 $session_where      $orderby limit $start, $limit";
       

        $song_list_arr	=	\App\Models\Songs::GetRawData($song_list);
       


        $count_check  =  sizeof($song_list_arr);


        $songs_counter = "Select tbl_songs.id from tbl_songs INNER JOIN tbl_songs_artist on tbl_songs_artist.song_id=tbl_songs.id INNER JOIN tbl_artists on tbl_songs_artist.artist_id=tbl_artists.id  where 1=1 $session_where";

        $res_count_mypro = \App\Models\Songs::GetRawData($songs_counter);
        if ($res_count_mypro) {
            $total_pages = count($res_count_mypro);
        } else {
            $total_pages = 0;
        }
    } else {

        //echo "artist2";
        $song_list = "Select tbl_songs.id, tbl_songs.song_title, tbl_songs.picture, tbl_songs.description, tbl_songs.song_status, tbl_songs.latest,tbl_songs.popularity,tbl_songs.posted_date,tbl_songs.ranking_order from tbl_songs where 1=1 $session_where   LIMIT $start, $limit";

        //echo "</br>";


        $song_list_arr	=	\App\Models\Songs::GetRawData($song_list);
       
        $songs_counter = "SELECT count(tbl_songs.id) as count2 FROM tbl_songs where 1=1 $session_where";


        $total_pages =	\App\Models\Songs::GetRawData($songs_counter);
        if ($total_pages) {
            $total_pages = $total_pages[0]->count2;
        } else {
            $total_pages =  0;
        }
        //$song_list_arr	=	$db->get_results($song_list,ARRAY_A);
    }


    session()->get('total_pages', $total_pages);
} elseif (isset($page) && !empty($page)) {
    
   
   

    //calculate limit, start based on page number
    $limit = 20; 					//how many items to show per page
    if ($page) {
        $start = ($page - 1) * $limit;
    } //first item to display on this page
    else {
        $start = 0;
    }

    //calculate serial number based on page and limit
    if (isset($page) && $page != "") {
        $sr_no = ($page * $limit) - $limit;
    } else {
        $sr_no = 0;
    }
    // echo $start;
    // die;

    //
    if (session()->get('song_title_sess') != "") {
        $newString = '';
        $symbol = '+';
        $newString = $symbol . str_replace(' ', " $symbol", session()->get('song_title_sess'));
        //$sess_where_song .= " and  MATCH (tbl_songs.song_title) AGAINST ('".trim(addslashes($newString))."' IN BOOLEAN MODE) ";
        $sess_where_song .= " and  MATCH (tbl_songs.song_title) AGAINST ('" . trim(addslashes(session()->get('song_title_sess'))) . "' IN BOOLEAN MODE) ";
    }
    if (session()->get('artist_title_sess') != "") {
        $newString = '';
        $symbol = '+';
        $newString = $symbol . str_replace(' ', " $symbol", session()->get('artist_title_sess'));


        $sess_where_artist .= " and MATCH (tbl_artists.artist_name) AGAINST ('".trim(addslashes($newString))."' IN BOOLEAN MODE) ";
       
        // $artist_data = GetByWhere('artists', array('artist_name' => session()->get('artist_title_sess')));
        // $artist_id = $artist_data[0]->id;
        // $sess_where_status .= " and song_status = '" . session()->get('song_status') . "'";

        
        // $sess_where_artist .= " and MATCH (tbl_artists.artist_name) AGAINST ('" . trim(addslashes(session()->get('artist_title_sess'))) . "' IN BOOLEAN MODE) ";
    }
    if (session()->get('song_status') != "") {
        $sess_where_status .= " and song_status = '" . session()->get('song_status') . "'";
    }






    //PAGGING CODE STARTS HERE
    $session_where  = $sess_where_song . $sess_where_artist . $sess_where_status;
    
    $songs_counter = "SELECT COUNT(tbl_songs.id) as count2 FROM tbl_songs where 1= 1 $session_where";
   

    $total_pages =	\App\Models\Songs::GetRawData($songs_counter);
    if ($total_pages) {
        $total_pages = $total_pages[0]->count2; //echo '</br>';
    } else {
        $total_pages = 0;
    }
    $targetpage = "song_list"; //your file name  (the name of this file)

    session()->put('total_pages', $total_pages);



    if (session()->get('song_title_sess') != "" || session()->get('artist_title_sess') != "" || session()->get('song_status') != "") {
        $session_where .= "  $orderby limit $start, $limit ";
    } else {
        // $session_where .= " and tbl_songs.id > $start $orderby limit $limit ";
        $session_where .= "limit $limit , $start";
    }


    session()->put('sess_faq', $session_where);
    //echo "ram2";
    $session_where = session()->get('sess_faq');



    $c = 1;
    if (session()->get('artist_title_sess') != "") {
        //echo "page if ";
        $song_list = "Select tbl_songs.id, tbl_songs.song_title, tbl_songs.picture, tbl_songs.description, tbl_songs.song_status, tbl_songs.latest,tbl_songs.popularity,tbl_songs.posted_date,tbl_songs.ranking_order,tbl_artists.id as artist_id from tbl_songs  join tbl_songs_artist on tbl_songs_artist.song_id=tbl_songs.id join tbl_artists on tbl_songs_artist.artist_id=tbl_artists.id  where 1=1 $session_where  ";
        echo '<pre>';
        print_r($song_list);
        echo '</pre>';
        die;
        //echo "</br>";
        $song_list_arr	=	\App\Models\Songs::GetRawData($song_list);
    } else {

        //echo "page else ";
        $song_list = "Select tbl_songs.id, tbl_songs.song_title, tbl_songs.picture, tbl_songs.description, tbl_songs.song_status, tbl_songs.latest,tbl_songs.popularity,tbl_songs.posted_date,tbl_songs.ranking_order from tbl_songs where 1=1 $session_where";	//echo "</br>";

        $song_list_arr	=	\App\Models\Songs::GetRawData($song_list);
        // echo '<pre>';
        // print_r($song_list_arr);
        // echo '</pre>';
        // die;
    }



    //set new session for query

    //calculate total


    //set order by and limit query


    //final songs query
} else {
    $limit = 20; 		//how many items to show per page
    $start = 0;
    $sr_no = 0;

    $sess_where = " $orderby limit $start , $limit ";
    session()->put('sess_faq', $sess_where);

    $targetpage = "song_list"; //your file name  (the name of this file)
    $songs_counter = "SELECT COUNT(tbl_songs.id) as count FROM tbl_songs ";
    //echo "</br>";

    $total_pages =	\App\Models\Songs::GetRawData($songs_counter);

    if ($total_pages) {
        $total_pages = $total_pages[0]->count; //echo '</br>';
    } else {
        $total_pages = 0;
    }




    $c = 1;
    $song_list = "Select tbl_songs.id, tbl_songs.song_title, tbl_songs.picture, tbl_songs.description, tbl_songs.song_status, tbl_songs.latest,tbl_songs.popularity,tbl_songs.posted_date,tbl_songs.ranking_order from tbl_songs  $sess_where "; //	echo "</br>";
    $song_list_arr	=	\App\Models\Songs::GetRawData($song_list);
    // echo '<pre>';
    // print_r($song_list_arr);
    // echo '</pre>';
    // die;
}









if (isset($_POST['Reset'])) {
    session()->put('song_itunesid_sess', null);
    session()->put('song_title_sess', null);


    session()->put('song_status', null);
    session()->put('artist_title_sess', null);
    session()->put('sess_faq', null);


    session()->put('where_cond', null);
    echo '<script>window.location = "song_list";</script>';
}
/*================== Search Filter End Here=================*/


if (isset($status) && !empty($status)) {
    $status		=	base64_decode($status);

    $status_id	=	base64_decode($status_id);

    if ($status == 1) {
        $sqlquery	=	"update tbl_songs set song_status='$status' where id='$status_id'";
    } else {
        $sqlquery	=	"update tbl_songs set song_status='$status' where id='$status_id'";
    }

    \App\Models\Songs::GetRawData($sqlquery);
    $update_ok_msg = base64_encode("Status has been changed Successfully!");
    $url = "song_list?msg=$update_ok_msg&case=1";
    echo '<script>window.location = "' . $url . '";</script>';
    exit;
}

if (isset($popular) && !empty($popular)) {
    $popular		=	base64_decode($popular);
 

    $status_id	=	base64_decode($status_id);



    if ($popular == 1) {
        $qry  = "select popularity from tbl_songs where popularity = 1";
        $count = array();
        $count = \App\Models\Songs::GetRawData($qry);
        if ($count) {
            $count = count($count);
        } else {
            $count = 0;
        }
        if ($count > 2) {
            $popular_error_msg = base64_encode("Status has been changed Successfully!");
            $url = "song_list?msg=$popular_error_msg&case=1";
            echo '<script>window.location = "' . $url . '";</script>';
            exit;
            exit;
        } else {
            $sqlquery	=	"update tbl_songs set popularity='$popular' where id='$status_id'";
        }
    } else {
        $sqlquery	=	"update tbl_songs set popularity='$popular' where id='$status_id'";
    }

    \App\Models\Songs::GetRawData($sqlquery);
    $update_ok_msg = base64_encode("Status has been changed Successfully!");
    $url = "song_list?msg=$update_ok_msg&case=1";
    echo '<script>window.location = "' . $url . '";</script>';
    exit;
}
if (isset($latest) && !empty($latest)) {
    $latest		=	base64_decode($latest);
    $status_id	=	base64_decode($status_id);
    // echo $latest;
    // die;
    $time = time();

    if ($latest == 1) {
        $sqlquery	=	"update tbl_songs set latest='$latest',timeupdated='" . $time . "' where id='$status_id'";
    } else {
        $sqlquery	=	"update tbl_songs set latest='$latest',timeupdated='" . $time . "' where id='$status_id'";
    }
    \App\Models\Songs::GetRawData($sqlquery);

    // $select_query =  "INSERT INTO tbl_latest_songs SELECT * FROM tbl_songs where id='$status_id' ON DUPLICATE KEY UPDATE latest= $latest";
    // \App\Models\Songs::GetRawData($select_query);
    $update_ok_msg = base64_encode("Status has been changed Successfully!");
    $url = "song_list?msg=$update_ok_msg&case=1";
    echo '<script>window.location = "' . $url . '";</script>';
    exit;
}

?>
<html>

<head>
    <title>Song Listing</title>
    <?php
    if ($top_song_module == 'No') {
        $target	= SERVER_ADMIN_PATH; ?>
    <script language="javascript" type="text/javascript">
        window.location = '<?php echo $target; ?>';
    </script>
    <?php
        exit;
    }
    ?>
    @include("admin.common.header")
    <script language="javascript" type="text/javascript">
        // check boxess submit code
        function toggleChecked(status) {
            $(".check-all").each(function() {
                $(this).attr("checked", status);
            })
        }

        function multiple_action(frm_id) // for changing multiple status or multiple delete 
        {
            var conBox = confirm("Are you sure,you want to Perform this Action?");
            if (conBox) {
                document.forms[frm_id].submit();
            } else {
                return false;
            }
        }

        function show_detail(id) {
            $("#before_details_div_" + id).toggle();
            $("#after_details_div_" + id).toggle();
        }

        function change_status(song_id, status) {
            var csrf_token = $('meta[name=csrf-token]').attr('content');

            $.ajax({

                type: "POST",

                url: JS_ADMIN_SERVER_PATHROOT + 'process/song_status',

                data: {
                    'song_id': song_id,
                    'status': status,
                    "_token": csrf_token,
                },
                beforeSend: function() {
                    $("#remove_song_" + song_id).hide();
                    document.getElementById("loader_song_" + song_id).innerHTML = '<img src=' +
                        JS_ADMIN_SERVER_PATHROOT + 'images/load.gif>';
                },
                success: function(msg) {
                    document.getElementById("loader_song_" + song_id).innerHTML = '';

                    document.getElementById("show_status_" + song_id).innerHTML = msg;

                }

            });
        }
    </script>
</head>

<body>
    <table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">
        <tr>
            <td style="background: #1F3C5C repeat-x;height:60px;" height="60">
                @include("admin.common.top_right_menu")
            </td>
        </tr>
        <tr>
            <td valign="top">
                <table border="0" width="100%">
                    <tr>
                        <td width="10">&nbsp;</td>
                        <td>
                            <!-- End page header -->
                            <!-- End pageheader -->
                            <!-- Start home -->
                            <div class="BodyContainer">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td class="heading1">Song Listing</td>
                                    </tr>
                                    <tr>
                                        <td class="body">
                                            <table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td><a
                                                            href="<?php echo SERVER_ADMIN_PATH; ?>index">Home</a>
                                                        &raquo; <a>Song Listing</a></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <form name="search_form" id="search_form" method="post"
                                                            action="song_list">
                                                            @csrf
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                align="center" width="500"
                                                                style="border:1px solid #000000; padding:10px;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="SmallFieldLabelnew font_bold"
                                                                            align="center" colspan="2">
                                                                            Search Song</td>
                                                                    </tr>

                                                                    <tr height="30">
                                                                        <td class="SmallFieldLabelnew font_bold"
                                                                            align="left" width="150">
                                                                            Song iTunes id
                                                                        </td>
                                                                        <td align="center">
                                                                            <input name="song_itunesid"
                                                                                id="song_itunesid" type="text"
                                                                                class="Field300"
                                                                                value="<?php echo session()->get('song_itunesid_sess'); ?>" />
                                                                        </td>
                                                                    </tr>


                                                                    <tr height="30">
                                                                        <td class="SmallFieldLabelnew font_bold"
                                                                            align="left" width="150">
                                                                            Song
                                                                        </td>
                                                                        <td align="center">
                                                                            <input name="song_title" id="song_title"
                                                                                type="text" class="Field300"
                                                                                value="<?php echo session()->get('song_title_sess'); ?>" />
                                                                        </td>
                                                                    </tr>
                                                                    <tr height="30">
                                                                        <td width="150" align="left"
                                                                            class="SmallFieldLabelnew font_bold">
                                                                            Artist
                                                                        </td>
                                                                        <td align="center">
                                                                            <input type="text"
                                                                                value="<?php echo session()->get('artist_title_sess'); ?>"
                                                                                class="Field300" id="artist_title"
                                                                                name="artist_title">
                                                                        </td>
                                                                    </tr>
                                                                    <tr height="30">
                                                                        <td class="SmallFieldLabelnew font_bold"
                                                                            align="left" width="150">
                                                                            Status
                                                                        </td>
                                                                        <td align="center">
                                                                            <select name="song_status" id="song_status"
                                                                                class="Field300">
                                                                                <option value=""> ------- Please Select
                                                                                    Status ------- </option>
                                                                                <option value="1" <?php if (session()->get('song_status') == '1') {
        echo 'selected="selected"';
    } ?>>Active
                                                                                </option>
                                                                                <option value="0" <?php if (session()->get('song_status') == '0') {
        echo 'selected="selected"';
    } ?>>Block
                                                                                </option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr height="30">
                                                                        <td class="SmallFieldLabelnew font_bold"
                                                                            align="left" width="150">&nbsp;</td>
                                                                        <td align="center">
                                                                            <input type="submit" id="filter"
                                                                                name="filter" value="Search">
                                                                            <input type="submit" id="Reset" name="Reset"
                                                                                value="Reset">
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table cellpadding="0" cellspacing="0" class="Panel">
                                                            <tbody>
                                                                <?php if (isset($msg) && $msg != "") { ?>
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <table border="0" cellpadding="0"
                                                                            cellspacing="0" class="Message">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td width="20"><?php if ($case == 1) { ?>
                                                                                        <img src="images/success_icon.png"
                                                                                            vspace="5" width="18"
                                                                                            height="18" hspace="10">
                                                                                        <?php } ?>
                                                                                        <?php if ($case == 2) { ?>
                                                                                        <img src="images/warning_icon.png"
                                                                                            vspace="5" width="18"
                                                                                            height="18" hspace="10">
                                                                                        <?php } ?>
                                                                                        <?php if ($case == 3) { ?>
                                                                                        <img src="images/error_icon.png"
                                                                                            vspace="5" width="18"
                                                                                            height="18" hspace="10">
                                                                                        <?php } ?>
                                                                                    </td>
                                                                                    <td width="100%"><?php echo base64_decode($msg); ?>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                                <?php
                                                                if ($top_song_module_add == "Yes") {
                                                                    ?>
                                                                <tr>
                                                                    <td colspan="11" width="105" align="right"
                                                                        valign="middle" id="addsymbol">
                                                                        <a
                                                                            href="<?php echo SERVER_ADMIN_PATH; ?>addedit_song"><img
                                                                                src="images/add.png" border="0"
                                                                                title="Add New"></a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td colspan="7">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30" id="Heading_list">Sr #</td>
                                                                    <td width="30" id="Heading_list">Song iTunes id</td>
                                                                    <!--<td width="200" id="Heading_list">Image</td>-->
                                                                    <td width="170" id="Heading_list">Song</td>
                                                                    <td width="100" id="Heading_list">Ranking</td>
                                                                    <td width="100" id="Heading_list">Artist</td>
                                                                    <td width="140" id="Heading_list">Artist Featured in
                                                                    </td>
                                                                    <td width="100" id="Heading_list">Albums</td>
                                                                    <td width="200" id="Heading_list">Summary</td>
                                                                    <td width="100" id="Heading_list">
                                                                        <?php if ($sortby == 'latestdesc') { ?>
                                                                        <a href="song_list?sortby=latestasc&page=<?php echo $page; ?>"
                                                                            class="link_class">Latest</a>
                                                                        <?php } else { ?>
                                                                        <a href="song_list?sortby=latestdesc&page=<?php echo $page; ?>"
                                                                            class="link_class">Latest</a>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td width="100" id="Heading_list">
                                                                        <?php if ($sortby == 'popularitydesc') { ?>
                                                                        <a href="song_list?sortby=popularityasc&page=<?php echo $page; ?>"
                                                                            class="link_class">Popularity</a>
                                                                        <?php } else { ?>
                                                                        <a href="song_list?sortby=popularitydesc&page=<?php echo $page; ?>"
                                                                            class="link_class">Popularity</a>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td width="70" id="Heading_list">
                                                                        <?php if ($sortby == 'statusdesc') { ?>
                                                                        <a href="song_list?sortby=statusasc&page=<?php echo $page; ?>"
                                                                            class="link_class">Status</a>
                                                                        <?php } else { ?>
                                                                        <a href="song_list?sortby=statusdesc&page=<?php echo $page; ?>"
                                                                            class="link_class">Status</a>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td width="230" id="Heading_list"
                                                                        class="righttd_border">&nbsp;&nbsp;&nbsp;<input
                                                                            class="check-all" type="checkbox"
                                                                            onClick="toggleChecked(this.checked);" />
                                                                        Action</td>
                                                                </tr>
                                                                <form
                                                                    action="<?php echo SERVER_ADMIN_PATH; ?>process/songs_actions"
                                                                    method="post" id="faq_form">
                                                                    @csrf
                                                                    <?php
                                                                    //============================================================
                                                                    //PAGGING CODE STARTS HERE





                                                                    if (isset($song_list_arr)) {
                                                                        foreach ($song_list_arr as $val) {
                                                                            $val = (array)$val;
                                                                             
                                                                            $id	  = $val['id'];
                                                                            $song_title = StringReplace($val['song_title']);
                                                                            $picture   = stripslashes(html_entity_decode($val['picture']));
                                                                            $description   = stripslashes(html_entity_decode($val['description']));
                                                                            $status   = $val['song_status'];
                                                                            $latest   = $val['latest'];
                                                                            $popularity   = $val['popularity'];
                                                                            $ranking   = $val['ranking_order'];
                                                                            $posted_date   = $val['posted_date'];
                                                                            $ranking_order   = $val['ranking_order'];
                                                                            $song_title = wordwrap($song_title, 100, " ", true);
                                                                            if ($c % 2 == 0) {
                                                                                $bgcolor = "#FEFEE4";
                                                                            } else {
                                                                                $bgcolor = "#FFFFFF";
                                                                            }

                                                                            $c++;
                                                                            $sr_no++;
                                                                            // if($val['id'] == 697365691)
                                                                            // {
                                                                            // 	// Get artist list
                                                                            // $artist_list	=	"select a.id as db_art_id,a.artist_name, a.artist_seo from tbl_artists a, tbl_songs_artist sa where a.id = sa.artist_id AND sa.song_id = $id order by sa.id asc";
                                                                            // $artist_list_arr	=	\App\Models\Songs::GetRawData($artist_list);
                                                                            // echo '<pre>';
                                                                            // print_r($artist_list_arr);
                                                                            // echo '</pre>';
                                                                            // die;


                                                                            // }
                                                                            // Get artist list
                                                                            $artist_list	=	"select a.id as db_art_id,a.artist_name, a.artist_seo from tbl_artists a, tbl_songs_artist sa where a.id = sa.artist_id AND sa.song_id = $id order by sa.id asc";
                                                                            $artist_list_arr	=	\App\Models\Songs::GetRawData($artist_list);


                                                                            $qry_top_feature_artist = "Select a.artist_seo as f_artist_seo,a.artist_name as feature_artist, a.id as feature_artist_id from tbl_featured_artist_assocs f, tbl_artists a where a.id = f.featured_artist AND f.song_id = '" . $id . "'";
                                                                            $qry_feature_arr = \App\Models\Songs::GetRawData($qry_top_feature_artist);
                                                                            if ($qry_feature_arr) {
                                                                                $count  = count($qry_feature_arr);
                                                                            } else {
                                                                                $count  = 0;
                                                                            }
                                                                            $num = 1;
                                                                            $feature_artists = "";
                                                                            if ($qry_feature_arr) {
                                                                                foreach ($qry_feature_arr as $val_feature) {
                                                                                    $val_feature = (array)$val_feature;
                                                                                    if ($num == $count) {
                                                                                        $feature_artists .= $val_feature['feature_artist'];
                                                                                    } else {
                                                                                        $feature_artists .= $val_feature['feature_artist'] . ", ";
                                                                                    }
                                                                                    $num++;
                                                                                }
                                                                            } ?>
                                                                    <tr bgcolor="<?php echo $bgcolor; ?>"
                                                                        onMouseOver="changebackcolor_hover('row<?php echo $id; ?>')"
                                                                        onMouseOut="changebackcolor_blur('row<?php echo $id; ?>')"
                                                                        id="row<?php echo $id; ?>">
                                                                        <td nowrap="nowrap" class="SmallFieldLabel"
                                                                            width="30"><?php echo $sr_no; ?>
                                                                        </td>
                                                                        <td nowrap="nowrap" class="SmallFieldLabel"
                                                                            width="30"><?php echo $id; ?>
                                                                        </td>
                                                                        <td nowrap="nowrap" class="SmallFieldLabel"
                                                                            width="170">
                                                                            <?php echo $song_title; ?>
                                                                        </td>
                                                                        <td nowrap="nowrap" class="SmallFieldLabel"
                                                                            width="100"><?php echo $ranking; ?>
                                                                        </td>

                                                                        <td nowrap="nowrap" class="SmallFieldLabel"
                                                                            width="100">
                                                                            <?php

                                                                                    $counter_art = count($artist_list_arr);
                                                                            if (isset($artist_list_arr)) {
                                                                                $cr = 0;
                                                                                foreach ($artist_list_arr as $val_artist) {
                                                                                    $val_artist = (array)$val_artist;

                                                                                    $cr++;
                                                                                    $db_art_id	  = $val_artist['db_art_id'];
                                                                                    $db_artist_name	  = $val_artist['artist_name'];
                                                                                    $db_artist_seo	  = $val_artist['artist_seo'];

                                                                                    if ($cr != $counter_art) {
                                                                                        echo   $db_artist_name . ", ";
                                                                                    } else {
                                                                                        echo  $db_artist_name;
                                                                                    }
                                                                                }
                                                                            } ?>
                                                                        </td>
                                                                        <td nowrap="nowrap" class="SmallFieldLabel"
                                                                            width="100">
                                                                            <?php echo $feature_artists; ?>
                                                                        </td>
                                                                        <td nowrap="nowrap" class="SmallFieldLabel"
                                                                            width="100">
                                                                            <?php
                                                                                    $albums_list = "select b.album_title,b.id, b.album_seo from   tbl_songs_artist_album saa, tbl_artist_album b where saa.album_id = b.id AND saa.artist_id = '$db_art_id' AND saa.song_id = '$id' AND saa.display_status = 1";
                                                                                     
                                                                            $albums_list_arr	= \App\Models\Songs::GetRawData($albums_list);
                                                                           
                                                                                     
                                                                                    
                                                                            if (isset($albums_list_arr)) {
                                                                                $g = 1;
                                                                                $count_album  = count($albums_list_arr);
                                                                                $album_title = "";
                                                                                foreach ($albums_list_arr as $val_album) {
                                                                                    $val_album = (array)$val_album;
                                                                                    if ($g == $count_album) {
                                                                                        $album_title .= $val_album['album_title'];
                                                                                    } else {
                                                                                        $album_title .= $val_album['album_title'] . ",";
                                                                                    }
                                                                                    $g++;
                                                                                }
                                                                            }
                                                                            echo $album_title; ?>
                                                                        </td>
                                                                        <td nowrap="nowrap" class="SmallFieldLabel"
                                                                            width="200">
                                                                            <?php echo substr(strip_tags($description), 0, 60); ?>
                                                                        </td>

                                                                        <td nowrap="nowrap" class="SmallFieldLabel"
                                                                            width="100">
                                                                            <?php
                                                                                    /***** For latest song */
                                                                                    if ($latest == 0) {
                                                                                        echo '<a href="song_list?latest=' . base64_encode(1) . '&status_id=' . base64_encode($id) . '" style="text-decoration:none;">Set as latest</a>';
                                                                                    }
                                                                            if ($latest == 1) {
                                                                                echo '<a href="song_list?latest=' . base64_encode(0) . '&status_id=' . base64_encode($id) . '" style="text-decoration:none;">Unset latest</a>';
                                                                            } ?>
                                                                        </td>
                                                                        <td nowrap="nowrap" class="SmallFieldLabel"
                                                                            width="100">
                                                                            <?php
                                                                                    if ($popularity == 0) {
                                                                                        echo '<a href="song_list?popular=' . base64_encode(1) . '&status_id=' . base64_encode($id) . '" style="text-decoration:none;">Set popular</a>';
                                                                                    }
                                                                            if ($popularity == 1) {
                                                                                echo '<a href="song_list?popular=' . base64_encode(0) . '&status_id=' . base64_encode($id) . '" style="text-decoration:none;">Unset popular</a>';
                                                                            } ?>
                                                                        </td>
                                                                        <td nowrap="nowrap" class="SmallFieldLabel"
                                                                            width="70">
                                                                            &nbsp;&nbsp;&nbsp;


                                                                            <?php
                                                                                    if ($status == 0) {
                                                                                        //echo '<a href="song_list?status='.base64_encode(1).'&status_id='.base64_encode($id).'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>';
                                                                                        echo '<a href="javascript:;" onclick = "change_status(' . $id . ', 1)" id = "remove_song_' . $id . '"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>';
                                                                                    }
                                                                            if ($status == 1) {
                                                                                //echo '<a href="song_list?status='.base64_encode(0).'&status_id='.base64_encode($id).'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>';
                                                                                echo '<a href="javascript:;" onclick = "change_status(' . $id . ', 0)" id = "remove_song_' . $id . '"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>';
                                                                            } ?>
                                                                            <span
                                                                                id="loader_song_<?php echo $id; ?>"></span>
                                                                            <span
                                                                                id="show_status_<?php echo $id; ?>"></span>
                                                                        </td>
                                                                        <td nowrap="nowrap"
                                                                            class="SmallFieldLabel righttd_border"
                                                                            width="230">

                                                                            &nbsp;&nbsp; <input type="checkbox"
                                                                                class="check-all" name="ids[]"
                                                                                id="ids[]"
                                                                                value="<?php echo base64_encode($id); ?>"
                                                                                style="margin-top:-5px;" />
                                                                            &nbsp;&nbsp;
                                                                            <?php
                                                                                    if ($top_song_module_add == 'Yes') {
                                                                                        ?>
                                                                            <a
                                                                                href="addedit_song?edit_id=<?php echo base64_encode($id); ?>"><img
                                                                                    src="images/edit.gif" border="0"
                                                                                    title="Edit" class="Action"></a>
                                                                            <?php
                                                                                    }
                                                                            if ($top_artist_module == 'Yes') {
                                                                                ?>
                                                                            <a href="artist_list_song?song_id=<?php echo base64_encode($id); ?>"
                                                                                title="Artists against song <?php echo $song_title; ?>">Artists</a>
                                                                            <?php
                                                                            } ?>
                                                                            &nbsp; &nbsp;
                                                                            <a
                                                                                href="review_add?song_id=<?php echo $id; ?>&art_id=<?php echo $db_art_id; ?>">Add
                                                                                Review</a>
                                                                            <?php
                                                                                    if ($top_song_module_delete == 'Yes') {
                                                                                        ?>
                                                                            &nbsp; &nbsp;
                                                                            <a href="javascript:;"
                                                                                onClick="delete_song('<?php echo $id; ?>')"><img
                                                                                    src="images/delet.gif" border="0"
                                                                                    title="Delete Song"
                                                                                    class="Action"></a>
                                                                            <?php
                                                                                    } ?>
                                                                            <!-- new code  -->
                                                                            &nbsp;&nbsp;
                                                                            <?php
                                                                            $add_feature= '<img src="'.SERVER_ROOTPATH.'admin/images/edit.gif" title="Edit Featured In"  border="0" />';
                                                                            if (empty($feature_artists)) {
                                                                                $add_feature= '<img src="'.SERVER_ROOTPATH.'admin/images/add_icon.png"  border="0" title="Add Featured In" />';
                                                                            } ?>
                                                                            <a href="addedit_featured_artist?song_id=<?php echo base64_encode($id); ?>=&artist_id=<?php echo base64_encode($db_art_id); ?>=&album_id=<?php echo base64_encode($albums_list_arr[0]->id); ?>=&page=song_list"
                                                                                style="margin-left: 12px;"><?php echo $add_feature; ?>
                                                                            </a>

                                                                            <!-- close code  -->
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                    <tr>
                                                                        <td colspan="10" align="center" nowrap="nowrap"
                                                                            class="SmallFieldLabel righttd_border"
                                                                            style="font-weight:bold; color:#FF0000;"> NO
                                                                            RECORD FOUND!</td>
                                                                    </tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    if ($total_pages > 0) {
                                                                        ?>
                                                                    <tr>
                                                                        <td colspan="11" nowrap="nowrap"
                                                                            class="SmallFieldLabel righttd_border">
                                                                            <span
                                                                                style="float:right; padding-bottom:10px; margin-right:8px;">
                                                                                <select name="dropdown"
                                                                                    onChange="multiple_action('faq_form');">
                                                                                    <option value="">Choose an action...
                                                                                    </option>
                                                                                    <option value="Active">Active
                                                                                    </option>
                                                                                    <option value="Inactive">Inactive
                                                                                    </option>
                                                                                    <?php
                                                                                        if ($top_song_module_delete == 'Yes') {
                                                                                            ?>
                                                                                    <option value="Delete">Delete
                                                                                    </option>
                                                                                    <?php
                                                                                        } ?>

                                                                                </select>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="6" align="center" valign="middle">
                                                                            @include("admin.common.paging-playlist")
                                                                        </td>
                                                                    </tr>
                                                                </form>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- End home -->
                            <!-- Start pagefooter -->
                        </td>
                        <td width="10">&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td height="20">
                @include("admin.common.footer")</td>
        </tr>
        </tbody>
    </table>
    <!-- End pagefooter -->
</body>

</html>