<?php
$artist_list_arr = array();
$artist_list_arr = App\Models\Songs::GetArtistListArray_2();
$top_songs_arr =    $artist_list_arr;
 
if (isset($top_songs_arr)) {
    $i = 1;
    foreach ($top_songs_arr as $val) {
        $val = (array) $val;
        if ($i > 10) {
            break;
        }
        $id      = $val['id'];
        $getartist_id      = $val['artist_id'];
        $song_seo =  strtolower(stripslashes(html_entity_decode($val['song_seo'])));
        $artist_seo =  strtolower(stripslashes(html_entity_decode($val['artist_seo'])));



        // $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where song_id = $id AND status = 1";

        $rate_arr = array();
        $rate_arr = App\Models\Songs::GetRawQuery('reviews', 'sum(review_rating) as sum_rate, count(*) as counter', array('song_id' => $id, 'status' => 1));
       
        if ($rate_arr) {
            $rate_arr = (array)$rate_arr[0];
            $sum_rate = $rate_arr['sum_rate'];
            $counter = $rate_arr['counter'];
            if ($sum_rate == "" || $sum_rate == 0 || $counter == "" || $counter == 0) {
                $sum_rate = 0;
                $counter = 0;
                $all_avg = 5;
            } else {
                $all_avg  =  $sum_rate / $counter;
            }

            if ($all_avg == "") {
                $all_avg = 0;
            } elseif ($all_avg == "10") {
                $all_avg = 10;
            } else {
                $all_avg = $all_avg;
            }
            if ($all_avg >= 7) {
                $color_picker = "#5ebd5e";
            }
            if ($all_avg >= 4 && $all_avg <= 6.9) {
                $color_picker = "#e06d21";
            }
            if ($all_avg >= 0 && $all_avg <= 3.9) {
                $color_picker = "#dd554e";
            }
            /**** for song name *****/

            /**** for song name *****/
            if (strlen($val['song_title']) >= '20') {
                $song_title = substr($val['song_title'], 0, 30);
            //$song_title = substr(stripslashes(mysqli_escape_string($db->dbh, $val['artist_name'])),0,20).'...';
            } else {
                $song_title = $val['song_title'];
            }
            /**** For artist name *****/
            if (strlen($val['artist_name']) >= '20') {
                $artist_name = substr($val['artist_name'], 0, 20) . '...';
            } else {
                $artist_name = $val['artist_name'];
            } ?>
<tr>
    <?php if ($i > 9) { ?>
    <td class="list"><label><?php echo  $i; ?></label> </td>
    <?php } else { ?>
    <td class="list"><label><?php echo "0" . $i; ?></label> </td>
    <?php } ?>
    <td class="rating"><cite class="yellow"
            style="background-color:<?php echo $color_picker; ?>">
            <?php if ($all_avg == 10) {
                echo $all_avg;
            } else {
                echo number_format($all_avg, 1, '.', '');
            } ?>
        </cite></td>
    <td class="song">
        <p><a
                href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><?php echo $song_title; ?></a> (<a
                href="<?php echo SERVER_ROOTPATH . Slug($song_seo) . "/reviews/" . Slug($artist_seo); ?>"><span><?php echo $artist_name; ?></span></a>)</p>
    </td>
</tr>
<?php
            $i++;
        }
    }
}
