<?php
$sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter, sum(review_rating>=8) as excellent, sum(review_rating>=7 && review_rating<8) as verygood, sum(review_rating>=4 && review_rating<7) as good,sum(review_rating>=2 && review_rating<4) as poor,sum(review_rating>0 && review_rating<2) as terrible from tbl_reviews where review_user_id = '" . $user_profile . "' AND status = 1";
$rate_arr = array();
$rate_arr    =    \App\Models\Songs::GetRawData($sum_rating);
if ($rate_arr) {
    $rate_arr = (array) $rate_arr[0];
    $sum_rate = $rate_arr['sum_rate'];
    $counter = $rate_arr['counter'];
    $excellent = $rate_arr['excellent'];
    $verygood = $rate_arr['verygood'];
    $good = $rate_arr['good'];
    $poor = $rate_arr['poor'];
    $terrible = $rate_arr['terrible'];

    if ($counter > 0 && $sum_rate > 0) {
        $excellent_per = ($excellent / $counter) * 100;
        $verygood_per  = ($verygood / $counter) * 100;
        $good_per        = ($good / $counter) * 100;
        $poor_per        = ($poor / $counter) * 100;
        $terrible_per = ($terrible / $counter) * 100;
    } else {
        $excellent_per =  0;
        $verygood_per  =  0;
        $good_per        = 0;
        $poor_per        = 0;
        $terrible_per =  0;
    }
} else {
    $sum_rate = 0;
    $counter = 0;
    $all_avg = 0;
    $excellent = 0;
    $verygood = 0;
    $good = 0;
    $poor = 0;
    $terrible = 0;
    $excellent_per = 0;
    $verygood_per  = 0;
    $good_per        = 0;
    $poor_per        = 0;
    $terrible_per =  0;
}


if ($sum_rate == "" || $sum_rate == 0 || $counter == '' || $counter == 0) {
    $sum_rate = 0;
    $counter = 0;
    $all_avg = 0;
} else {

    $all_avg  =  $sum_rate / $counter;
}

if ($all_avg == "") {
    $all_avg = 5.0;
}

if ($all_avg == "") {
    $all_avg = 5.0;
}

if ($all_avg >= 8) {
    $color_pick = "#5cb85c";
}

if ($all_avg >= 7 && $all_avg < 8) {
    $color_pick = "#5cb85c";
}

if ($all_avg >= 4 && $all_avg < 7) {
    $color_pick = "#e06d21";
}

if ($all_avg >= 2 && $all_avg < 4) {
    $color_pick = "#d9534f";
}

if ($all_avg > 0 && $all_avg < 2) {
    $color_pick = "#d9534f";
}

$all_avg = number_format($all_avg, 1);
?>

<h3>Reviews</h3>
<?php if( isset($user_type) && ($user_type == 'admin')) { ?>
<div class="row rating-panel">
    <div class="col-lg-5 col-md-4 col-sm-2 col-xs-3 progressLabel" style="color:#5CB85C; text-align:left;">
        Excellent
    </div>
    <div class="col-sm-6 col-xs-8 progress-panel">
        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-song-rating/excellent?user_type=admin">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $excellent_per; ?>%;  cursor:pointer; background-color:#5CB85C;"></div>
            </div>
        </a>
    </div>
    <div class="col-xs-1 progressVal" style="color:#5CB85C;">
        <?php echo $excellent; ?>
    </div>
</div>
<div class="row rating-panel">
    <div class="col-lg-5 col-md-4 col-sm-2 col-xs-3 progressLabel" style="color:#5CB85C; text-align:left;">
        Very Good
    </div>
    <div class="col-sm-6 col-xs-8 progress-panel">
        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-song-rating/verygood?user_type=admin">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $verygood_per; ?>%;  cursor:pointer; background-color:#5CB85C;"></div>
            </div>
        </a>
    </div>
    <div class="col-xs-1 progressVal" style="color:#5CB85C;">
        <?php echo $verygood; ?>
    </div>
</div>
<div class="row rating-panel">
    <div class="col-lg-5 col-md-4 col-sm-2 col-xs-3 progressLabel" style="color:#e06d21; text-align:left;">
        Average
    </div>
    <div class="col-sm-6 col-xs-8 progress-panel">
        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-song-rating/average?user_type=admin">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $good_per; ?>%; cursor:pointer; background-color:#e06d21;"></div>
            </div>
        </a>
    </div>
    <div class="col-xs-1 progressVal" style="color:#e06d21;">
        <?php echo $good; ?>
    </div>
</div>
<div class="row rating-panel">
    <div class="col-lg-5 col-md-4 col-sm-2 col-xs-3 progressLabel" style="color:#dd554e; text-align:left;">
        Poor
    </div>
    <div class="col-sm-6 col-xs-8 progress-panel">
        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-song-rating/poor?user_type=admin">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $poor_per; ?>%; cursor:pointer; background-color:#dd554e;"></div>
            </div>
        </a>
    </div>
    <div class="col-xs-1 progressVal" style="color:#dd554e;">
        <?php echo $poor; ?>
    </div>
</div>
<div class="row rating-panel">
    <div class="col-lg-5 col-md-4 col-sm-2 col-xs-3 progressLabel" style="color:#dd554e; text-align:left;">
        Terrible
    </div>
    <div class="col-sm-6 col-xs-8 progress-panel">
        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-song-rating/terrible?user_type=admin">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $terrible_per; ?>%; background-color:#dd554e;"></div>
            </div>
        </a>
    </div>
    <div class="col-xs-1 progressVal" style="color:#dd554e;">
        <?php echo $terrible; ?>
    </div>
</div>
<?php } else { ?>
    <div class="row rating-panel">
    <div class="col-lg-5 col-md-4 col-sm-2 col-xs-3 progressLabel" style="color:#5CB85C; text-align:left;">
        Excellent
    </div>
    <div class="col-sm-6 col-xs-8 progress-panel">
        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-song-rating/excellent">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $excellent_per; ?>%;  cursor:pointer; background-color:#5CB85C;"></div>
            </div>
        </a>
    </div>
    <div class="col-xs-1 progressVal" style="color:#5CB85C;">
        <?php echo $excellent; ?>
    </div>
</div>
<div class="row rating-panel">
    <div class="col-lg-5 col-md-4 col-sm-2 col-xs-3 progressLabel" style="color:#5CB85C; text-align:left;">
        Very Good
    </div>
    <div class="col-sm-6 col-xs-8 progress-panel">
        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-song-rating/verygood">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $verygood_per; ?>%;  cursor:pointer; background-color:#5CB85C;"></div>
            </div>
        </a>
    </div>
    <div class="col-xs-1 progressVal" style="color:#5CB85C;">
        <?php echo $verygood; ?>
    </div>
</div>
<div class="row rating-panel">
    <div class="col-lg-5 col-md-4 col-sm-2 col-xs-3 progressLabel" style="color:#e06d21; text-align:left;">
        Average
    </div>
    <div class="col-sm-6 col-xs-8 progress-panel">
        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-song-rating/average">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $good_per; ?>%; cursor:pointer; background-color:#e06d21;"></div>
            </div>
        </a>
    </div>
    <div class="col-xs-1 progressVal" style="color:#e06d21;">
        <?php echo $good; ?>
    </div>
</div>
<div class="row rating-panel">
    <div class="col-lg-5 col-md-4 col-sm-2 col-xs-3 progressLabel" style="color:#dd554e; text-align:left;">
        Poor
    </div>
    <div class="col-sm-6 col-xs-8 progress-panel">
        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-song-rating/poor">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $poor_per; ?>%; cursor:pointer; background-color:#dd554e;"></div>
            </div>
        </a>
    </div>
    <div class="col-xs-1 progressVal" style="color:#dd554e;">
        <?php echo $poor; ?>
    </div>
</div>
<div class="row rating-panel">
    <div class="col-lg-5 col-md-4 col-sm-2 col-xs-3 progressLabel" style="color:#dd554e; text-align:left;">
        Terrible
    </div>
    <div class="col-sm-6 col-xs-8 progress-panel">
        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-song-rating/terrible">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $terrible_per; ?>%; background-color:#dd554e;"></div>
            </div>
        </a>
    </div>
    <div class="col-xs-1 progressVal" style="color:#dd554e;">
        <?php echo $terrible; ?>
    </div>
</div>
    <?php } ?>