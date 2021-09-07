@extends('common.header')
<!-- ./Header end -->
<?php
echo $user_profile;
die;

$mobile_view = 0;
//include_once("common/signin_modal_header.php"); 
$_SESSION[USER_SESSION_ARRAY]['USER_ID'] = session()->get('user_id');
$_SESSION[USER_SESSION_ARRAY]['USER_NAME'] = session()->get('user_name');
$user_profile = $_SESSION[USER_SESSION_ARRAY]['USER_ID'];
 
$USER_NAME = ucfirst($_SESSION[USER_SESSION_ARRAY]['USER_NAME']); 
$USER_NAME =  str_replace(" ", '%20', $USER_NAME);
$main_link = '';


// if ($alpha == "unset") {
// 	unset($_SESSION[search_like_review]['artist_names']);
// 	unset($_SESSION[search_like_review]['result']);
// }

// if (isset($_REQUEST['submit_b']) && $_REQUEST['submit_b'] != "") {

// 	if ($artist_name != "") {

// 		$artist_name = mysqli_escape_string($db->dbh, $artist_name);
// 		$search_where .= " AND a.artist_name like '%$artist_name%'";

// 		$_SESSION[search_like_review]['artist_names'] = $artist_name;
// 		$_SESSION[search_like_review]['result'] = $search_where;
// 	} else {
// 		unset($_SESSION[search_like_review]['artist_names']);
// 		unset($_SESSION[search_like_review]['result']);
// 	}
// }
 
$request_url_check	=	str_replace("/", '', $_SERVER['REQUEST_URI']);

?>


<script type="text/javascript">
	function unset_all(user) {
		if (user == "") {
			window.location.href = "<?php echo SERVER_ROOTPATH; ?>review-artists-unset";
		} else {
			window.location.href = "<?php echo SERVER_ROOTPATH; ?>" + user + "-profile-review-artists-unset";
		}


	}
</script>



<!-- Middle Section -->
<section class="middle_sec">
    <div class="topRwHead-bodyPan">
        <div class="container pad_zero">

            <div class="topRwHead-panel" style="margin:12px 0 !important; padding-bottom:0; padding-top:10px;">

                <?php if ($mobile_view == 0) { ?>

                    <div class="col-lg-12 col-md-12" style="margin-bottom:0; padding-right:0;">
                         @include("common.my_account_image")
                        
                        <div class="activity-panel">
                            @include("include.review_activities")
                            <?php echo 'wait'; die; ?>

                        </div>
                        <?php include("include/latest_activities.php"); ?>

                        <div class="clearfix"></div>



                    </div>
                    <div class="col-lg-4 col-md-4 review_ipad">
                        <div class="col-sm-12 review_arts" style="padding:2px;">
                            <?php include("include/right_reivews.php"); ?>
                        </div>
                    </div>


            </div>
        </div>

        <?php include("common/ipad_data.php"); ?>

    <?php
                } elseif ($mobile_view == 1) { ?>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php include("common/my_account_image.php"); ?>
        </div>
        <div style="clear:both;"></div>
        <div class="col-sm-12 desc-panel">
            <div class="activity-panel">
                <?php include("include/review_activities.php"); ?>
            </div>
            <?php //include("include/latest_activities.php");
            ?>
        </div>

        <div class="col-lg-4 col-md-4">
            <div class="col-sm-12 review_arts" style="padding:2px;">
                <?php include("include/right_reivews.php"); ?>
            </div>
        </div>


    <?php } ?>


    <div class="clearfix"></div>
    </div>
    <?php if ($main_link != "") { ?>
        <!-- Advertisement Banner Start-->
        <div class="container" style="padding-bottom:10px;">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <?php echo ads_info('Top'); ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
            </div>
        </div>
        <!--Advertisement Banner End-->
    <?php } ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div style="background-color:#FFFFFF; padding:10px;" class="brows-label-penel">
                <?php include("include/artist_review_like_menu.php"); ?>
            </div>
        </div>
    </div>


    <div class="topRwContent-panel" style="margin-bottom:15px;">
        <div class="banner_body">
            <?php if ($mobile_view == 0) { ?>
                <div class="banner-search" style="margin:5px auto 15px auto;">
                    <form method="post" action="" style="width:100%;">
                        <div class="form-group" style="border:1px solid #ccc !important;">
                            <label for="skills" onClick="unset_all('<?php echo $user_seo; ?>')" style="cursor:pointer; border-radius:0;">All</label>
                            <!--for="search"-->
                            <input placeholder="Search for a Review..." type="text" name="artist_name" id="review_artist" class="form-control ac_input" value="<?php echo $_SESSION[search_like_review]['artist_names']; ?>" required><!-- id="search_text"-->
                            <button class="btn" type="submit" value="Search" name="submit_b"><i class="sprite-new sprite-new-xsearch-icon-png-pagespeed-ic-XjnYgjYQAr"></i></button>
                        </div>
                    </form>
                </div>
            <?php
            } elseif ($mobile_view == 1) { ?>
                <div class="banner-search" style="max-width:100%; margin:0;">
                    <form method="post" action="" style="width:100%;">
                        <div class="form-group" style="border:1px solid #ccc; border-right:none; border-left:none;">
                            <label for="skills" onClick="unset_all('<?php echo $user_seo; ?>')" style="cursor:pointer; border-radius:0;">All</label>
                            <input placeholder="Search for a Review..." type="text" name="artist_name" id="review_artist" class="form-control ac_input" value="<?php echo $_SESSION[search_like_review]['artist_names']; ?>" required>
                            <button class="btn" type="submit" value="Search" name="submit_b"><i class="sprite-new sprite-new-xsearch-icon-png-pagespeed-ic-XjnYgjYQAr"></i></button>

                        </div>
                    </form>
                </div>
            <?php } ?>

            <!-- banner-search -->
            <div class="col-sm-12 alpha-panel text-center" style="color:#999999;">
                <?php
                $genere_seo = strtolower($genere_seo);
                if ($genere_seo != "") {
                    $urls = "-" . $genere_seo . "-genre";
                } else {
                    $urls = "";
                }


                $artist_list_pick = "select a.artist_name 
							  from tbl_artists a, tbl_categories c, tbl_reviews r 
							  where 1=1 
							  AND a.artist_status = 1 
							  AND a.genere_cat = c.cat_id 
							  AND r.artist_id = a.id 
							  AND r.status = 1
							  AND r.review_user_id = '" . $user_profile . "' 
							  $where_condition
							  group by r.artist_id
							  order by r.review_id desc limit 50
							 ";

                $artist_list_pick_arr    =    $db->get_results($artist_list_pick, ARRAY_A);
                $array_alpha    =    array();
                if (isset($artist_list_pick_arr)) {
                    $u = 0;
                    foreach ($artist_list_pick_arr as $row_alpha) {
                        $row_artist_name    =    stripslashes($row_alpha['artist_name']);

                        $array_alpha[$u]        =    substr(strip_tags($row_artist_name), 0, 1);
                        $u++;
                    }
                }

                ?>
                <ul class="list-inline" style="color:#999999;">
                    <li>#</li> -
                    <li>
                        <?php if (in_array("A", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'a') { ?>color:#000 !important;<?php } else { ?> color:#70857b !important;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-a">A</a> <?php } else { ?> A <?php } ?> - </li>

                    <?php if (in_array("B", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'b') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-b">B</a> <?php } else { ?> B <?php } ?> - </li>

                    <?php if (in_array("C", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'c') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-c">C</a> <?php } else { ?> C <?php } ?> - </li>

                    <?php if (in_array("D", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'd') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-d">D</a> <?php } else { ?> D <?php } ?> - </li>

                    <?php if (in_array("E", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'e') { ?>color:#000;<?php } ?> <?php if ($alpha == 'e') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-e">E</a> <?php } else { ?> E <?php } ?> - </li>

                    <?php if (in_array("F", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'f') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-f">F</a> <?php } else { ?> F <?php } ?> - </li>

                    <?php if (in_array("G", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'g') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-g">G</a> <?php } else { ?> G <?php } ?> - </li>

                    <?php if (in_array("H", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'h') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-h">H</a> <?php } else { ?> H <?php } ?> - </li>

                    <?php if (in_array("I", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'i') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-i">I</a> <?php } else { ?> I <?php } ?> - </li>

                    <?php if (in_array("J", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'j') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-j">J</a> <?php } else { ?> J <?php } ?> - </li>

                    <?php if (in_array("K", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'k') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-k">K</a> <?php } else { ?> K <?php } ?> - </li>

                    <?php if (in_array("L", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'l') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-l">L</a> <?php } else { ?> L <?php } ?> - </li>

                    <?php if (in_array("M", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'm') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-m">M</a> <?php } else { ?> M <?php } ?> - </li>

                    <?php if (in_array("N", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'n') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-n">N</a> <?php } else { ?> N <?php } ?> - </li>


                    <?php if (in_array("O", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'o') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-o">O</a> <?php } else { ?> O <?php } ?> - </li>

                    <?php if (in_array("P", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'p') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-p">P</a> <?php } else { ?> P <?php } ?> - </li>

                    <?php if (in_array("Q", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'q') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-q">Q</a> <?php } else { ?> Q <?php } ?> - </li>

                    <?php if (in_array("R", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'r') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-r">R</a> <?php } else { ?> R <?php } ?> - </li>

                    <?php if (in_array("S", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 's') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-s">S</a> <?php } else { ?> S <?php } ?> - </li>

                    <?php if (in_array("T", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 't') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-t">T</a> <?php } else { ?> T <?php } ?> - </li>

                    <?php if (in_array("U", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'u') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-u">U</a> <?php } else { ?> U <?php } ?> - </li>

                    <?php if (in_array("V", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'v') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-v">V</a> <?php } else { ?> V <?php } ?> - </li>

                    <?php if (in_array("W", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'w') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-w">W</a> <?php } else { ?> W <?php } ?> - </li>

                    <?php if (in_array("X", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'x') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-x">X</a> <?php } else { ?> X <?php } ?> - </li>

                    <?php if (in_array("Y", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'y') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-y">Y</a> <?php } else { ?> Y <?php } ?> - </li>

                    <?php if (in_array("Z", $array_alpha)) { ?> <a style="font-weight:bold; <?php if ($alpha == 'z') { ?>color:#000;<?php } ?>" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artists<?php echo $urls; ?>-z">Z</a> <?php } else { ?> Z <?php } ?> </li>



                </ul>
            </div>
        </div>

        <div class="row">
            <?php
            $_SESSION['user_profie_id']  = $user_profile;
            $cat_list_arr = array();
            /*	 $cat_list_arr = array();
						 if(MEMCACHE_IS_ENABALED){
									$key = md5("review_artist_cat_list_arr". $where_condition."_".$user_profile); // Unique Words
									$cat_list_arr = $memcache->get($key); // Memcached object 
							}*/

            if (empty($cat_list_arr)) {

                $cat_list = "select a.artist_seo,a.artist_name, a.artist_img, a.id, c.cat_id, c.cat_name, c.cat_seo_name, 			r.review_user_id 
							  from tbl_artists a, tbl_categories c, tbl_reviews r 
							  where 1=1 
							  AND a.artist_status = 1 
							  AND a.genere_cat = c.cat_id 
							  AND r.artist_id = a.id 
							  AND r.status = 1
							  AND r.review_user_id = '" . $user_profile . "' 
							  $where_condition
							  group by c.cat_name
							  order by r.review_id desc 
							 ";
                $cat_list_arr    =    $db->get_results($cat_list, ARRAY_A);
                /* if(MEMCACHE_IS_ENABALED){
									$memcache->set($key, $cat_list_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
							 }
							*/
            }
            $count  = count($cat_list_arr);

            if (isset($cat_list_arr)) {
                $v = 1;
            ?>

                <?php if ($mobile_view == 0) { ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:5px 30px 0 30px;">
                        <div style="background-color:#FFFFFF; margin: 10px 0 10px 0;" class="brows-label-penel">
                            <p class="pull-left" style="line-height:27px;">BROWSE BY GENRE: &nbsp;</p>
                            <ul class="list-inline">
                                <li>
                                    <?php
                                    foreach ($cat_list_arr as $val) {
                                        $cat_id      = $val['cat_id'];
                                        $cat_name = stripslashes(html_entity_decode($val['cat_name']));
                                        $cat_seo_name = strtolower(stripslashes(html_entity_decode($val['cat_seo_name'])));

                                    ?>
                                        <a class="active" href="<?php echo SERVER_ROOTPATH . get_user_detail($USER_NAME); ?>-review-artist-genre-<?php echo $cat_seo_name; ?>"><?php echo $cat_name; ?></a><?php
                                                                                                                                                                                                            if ($v != $count) {
                                                                                                                                                                                                                echo " | ";
                                                                                                                                                                                                            }

                                                                                                                                                                                                            ?>
                                    <?php
                                        $v++;
                                    }
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php
                } elseif ($mobile_view == 1) { ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:5px;">
                        <div style="background-color:#FFFFFF; margin:0; padding: 10px 10px; border-right:none; border-left:none;" class="brows-label-penel">
                            <p class="pull-left">BROWSE BY GENRE: &nbsp;</p>
                            <ul class="list-inline" style="margin-top:-3px;">
                                <li>
                                    <?php
                                    foreach ($cat_list_arr as $val) {
                                        $cat_id      = $val['cat_id'];
                                        $cat_name = stripslashes(html_entity_decode($val['cat_name']));
                                        $cat_seo_name = strtolower(stripslashes(html_entity_decode($val['cat_seo_name'])));

                                    ?>
                                        <a class="active" href="<?php echo SERVER_ROOTPATH . get_user_detail($USER_NAME); ?>-review-artist-genre-<?php echo $cat_seo_name; ?>"><?php echo $cat_name; ?></a><?php
                                                                                                                                                                                                            if ($v != $count) {
                                                                                                                                                                                                                echo " | ";
                                                                                                                                                                                                            }

                                                                                                                                                                                                            ?>
                                    <?php
                                        $v++;
                                    }
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>

        <div class="topsonglistsec col-lg-8 col-md-8 col-sm-12 col-xs-12 pad_zero" style="background:none;">

            <?php if ($mobile_view == 0) { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ul class="songlistings" style=" border:1px solid #ccc;">
                    <?php
                } elseif ($mobile_view == 1) { ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad_zero">
                            <ul class="songlistings">
                            <?php } ?>

                            <?php
                            $where_condition = "";
                            $artist_page = "";
                            if ($genere_seo != "") {
                                /*	  $get_cat_array = array();
							 if(MEMCACHE_IS_ENABALED){
										$key = md5("review_artist_get_cat_array_". $genere_seo); // Unique Words
										$get_cat_array = $memcache->get($key); // Memcached object 
								}*/

                                if (empty($get_cat_array)) {
                                    $get_cat_array = "select cat_id from tbl_categories where cat_seo_name = '$genere_seo'";
                                    $get_cat_array    =    $db->get_row($get_cat_array, ARRAY_A);
                                    /*if(MEMCACHE_IS_ENABALED){
										$memcache->set($key, $get_cat_array, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
								}	*/
                                }
                                $cat_genere_id  = $get_cat_array['cat_id'];

                                $where_condition .= " AND c.cat_seo_name = '$genere_seo'";

                                $artist_page = $main_link . "review-artist-genres-" . $genere_seo;
                            }

                            if ($_SESSION[search_like_review]['result'] != "") {
                                $where_condition .= $_SESSION[search_like_review]['result'];
                            }

                            if ($alpha != "" && $alpha != "unset") {
                                $where_condition .= " AND a.artist_name like '$alpha%' ";
                                $artist_page = $main_link . "review-artist-" . $alpha;
                            }



                            if ($artist_page == "") {
                                $artist_page = $main_link . "review-artist";
                            }

                            $artist_list_arr = array();
                            /* if(MEMCACHE_IS_ENABALED){
										$key = md5("review_artist_get_cat_array_". $user_profile."_".$where_condition); // Unique Words
										$artist_list_arr = $memcache->get($key); // Memcached object 
								}*/

                            if ($alpha != "" && $alpha != "unset" && $genere_seo != "") {
                                $artist_page = $main_link . "review-artists-" . $genere_seo . "-genre-" . $alpha;
                            }


                            if (empty($artist_list_arr)) {


                                if ($_SESSION[search_like_review]['result'] != '') {
                                    $orderby = "CASE 
							   WHEN a.artist_name LIKE '" . $_SESSION[search_like_review]['artist_names'] . "' THEN 1 
							   WHEN a.artist_name LIKE '" . $_SESSION[search_like_review]['artist_names'] . " %' THEN 2 
							   WHEN a.artist_name LIKE '" . $_SESSION[search_like_review]['artist_names'] . "%' THEN 3 
							   ELSE 4 
							   END";
                                } else {
                                    $orderby = " r.review_id desc";
                                }


                                $artist_list = "select a.artist_seo,a.artist_name,a.updated_by_itunes, a.artist_img, a.id, c.cat_name, c.cat_seo_name, r.review_user_id 
							  from tbl_artists a, tbl_categories c, tbl_reviews r 
							  where 1=1 
							  AND a.artist_status = 1 
							  AND a.genere_cat = c.cat_id 
							  AND r.artist_id = a.id 
							  AND r.status = 1
							  AND r.review_user_id = '" . $user_profile . "' 
							  $where_condition
							  group by r.artist_id
							  order by $orderby limit 50
							 ";

                                $artist_list_arr    =    $db->get_results($artist_list, ARRAY_A);
                                /*if(MEMCACHE_IS_ENABALED){
									$memcache->set($key, $artist_list_arr, MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE_TIME); 
								 }
								*/
                            }

                            $targetpage = SERVER_ROOTPATH . $artist_page; //your file name  (the name of this file)
                            $total_pages = count($artist_list_arr);
                            $limit = 10;                     //how many items to show per page
                            $page = $_GET['page'];
                            if ($page)
                                $start = ($page - 1) * $limit; //first item to display on this page
                            else
                                $start = 0;                    //if no page var is given, set start to 0
                            //PAGGING CODE ENDS HERE	
                            //============================================================

                            if (isset($page) && $page != "") {
                                $sr_no = ($page * $limit) - $limit;
                            } else {
                                $sr_no = 0;
                            }

                            $c = 1;


                            $artist_list_arr = array_slice($artist_list_arr, $start, 10);
                            if (isset($artist_list_arr)) {
                                $k = 1;
                                foreach ($artist_list_arr as $val) {

                                    $id      = $val['id'];
                                    $review_user_id = stripslashes(html_entity_decode($val['review_user_id']));
                                    $artist_name = stripslashes(html_entity_decode($val['artist_name']));
                                    $artist_seo = strtolower(stripslashes(html_entity_decode($val['artist_seo'])));
                                    $artist_img   = stripslashes(html_entity_decode($val['artist_img']));
                                    $cat_name   = stripslashes(html_entity_decode($val['cat_name']));
                                    $cat_seo_name   = strtolower(stripslashes(html_entity_decode($val['cat_seo_name'])));

                                    $artist_name = wordwrap($artist_name, 100, " ", true);
                                    $counter_main = mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_type = 'artist' AND like_id = '$id'"));

                                    if ($c % 2 == 0) {
                                        $bgcolor = "#FEFEE4";
                                    } else {
                                        $bgcolor = "#FFFFFF";
                                    }
                                    $sum_rating = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where artist_id = $id AND status = 1";
                                    $rate_arr    =    $db->get_row($sum_rating, ARRAY_A);

                                    $sum_rate = $rate_arr['sum_rate'];
                                    $counter = $rate_arr['counter'];

                                    if ($sum_rate == "" || $sum_rate == 0) {
                                        $sum_rate = 0;
                                    }

                                    $all_avg  =  $sum_rate / $counter;

                                    if ($all_avg == "") {
                                        $all_avg = 0;
                                    }

                                    if ($all_avg >= 8) {
                                        $color_pick = "#5ebd5e";
                                    }

                                    if ($all_avg >= 7 && $all_avg < 8) {
                                        $color_pick = "#5ebd5e";
                                    }

                                    if ($all_avg >= 4 && $all_avg < 6.9) {
                                        $color_pick = "#e06d21";
                                    }

                                    if ($all_avg >= 2 && $all_avg < 3.9) {
                                        $color_pick = "#dd554e";
                                    }

                                    if ($all_avg > 0 && $all_avg < 2) {
                                        $color_pick = "#dd554e";
                                    }

                                    if ($all_avg >= 7) {
                                        $color_pick = "#5ebd5e";
                                    }
                                    if ($all_avg >= 4 && $all_avg <= 6.9) {
                                        $color_pick = "#e06d21";
                                    }
                                    if ($all_avg >= 0 && $all_avg <= 3.9) {
                                        $color_pick = "#dd554e";
                                    }

                                    /*rating current users right side*/
                                    $sum_rating_user = "select sum(review_rating) as sum_rate, count(*) as counter from tbl_reviews where artist_id = $id  AND status = 1 and review_user_id = '$review_user_id'";
                                    $rate_user_arr    =    $db->get_row($sum_rating_user, ARRAY_A);

                                    $sum_user_rate = $rate_user_arr['sum_rate'];
                                    $counter_user = $rate_user_arr['counter'];

                                    if ($sum_rate == "" || $sum_user_rate == 0) {
                                        $sum_user_rate = 0;
                                    }

                                    $all_user_avg  =  $sum_user_rate / $counter_user;

                                    if ($all_user_avg == "") {
                                        $all_user_avg = 0;
                                    }

                                    if ($all_user_avg >= 8) {
                                        $color_pick_user = "#5ebd5e";
                                    }

                                    if ($all_user_avg >= 7 && $all_user_avg < 8) {
                                        $color_pick_user = "#5ebd5e";
                                    }

                                    if ($all_user_avg >= 4 && $all_user_avg < 6.9) {
                                        $color_pick_user = "#e06d21";
                                    }

                                    if ($all_user_avg >= 2 && $all_user_avg < 3.9) {
                                        $color_pick_user = "#dd554e";
                                    }

                                    if ($all_user_avg > 0 && $all_user_avg < 2) {
                                        $color_pick_user = "#dd554e";
                                    }
                                    if ($all_avg >= 7) {
                                        $color_pick = "#5ebd5e";
                                    }
                                    if ($all_avg >= 4 && $all_avg <= 6.9) {
                                        $color_pick = "#e06d21";
                                    }
                                    if ($all_avg >= 0 && $all_avg <= 3.9) {
                                        $color_pick = "#dd554e";
                                    }

                                    $c++;
                                    $sr_no++;

                                    if ($artist_img == '' &&  $val['updated_by_itunes'] == '0000-00-00 00:00:00') {
                                        $req_artist  =  artist_func(urlencode("$artist_name"));
                                    }
                            ?>
                                    <?php
                                    if ($_REQUEST['user_seo'] == '') {
                                        $url_gen    =    SERVER_ROOTPATH . $artist_seo . "-review-albums";
                                    } else {
                                        $url_gen    =    SERVER_ROOTPATH . get_user_detail($USER_NAME) . "-profile-" . $artist_seo . "-review-albums";
                                    }

                                    if ($mobile_view == 0) { ?>
                                        <li>
                                            <div class="row">
                                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                    <span class="list_no"><?php if (strlen($sr_no) == 1) {
                                                                                echo "0";
                                                                            } else {
                                                                            }; ?><?php echo $sr_no; ?></span>
                                                </div>
                                                <div class="col-lg-5 col-md-6 col-sm-5 col-xs-12 pad_zero">
                                                    <div class="album_cover">

                                                        <?php


                                                        if ($artist_img != "") {
                                                            $img_api_linka = album_img_api($artist_img);
                                                            if ($img_api_linka != '') {

                                                        ?>
                                                                <a href="<?php echo $url_gen; ?>"><img src="<?php echo get_small_thumb($img_api_linka); ?>" border="0" width="100" /></a>
                                                            <?php } else { ?>
                                                                <a href="<?php echo $url_gen; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo 'thumb_' . $artist_img; ?>" border="0" width="100" /></a>
                                                            <?php
                                                            }
                                                        } else
													if ($artist_img == "") {

                                                            if ($req_artist['artist_array']['image4'] != "") {
                                                            ?>
                                                                <a href="<?php echo $url_gen; ?>"><img src="<?php echo get_small_thumb($req_artist['artist_array']['image4']); ?>" border="0" width="100" style="max-width:inherit; max-height:90px;" /></a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a href="<?php echo $url_gen; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" width="100" /></a>
                                                        <?php
                                                            }
                                                        }

                                                        ?>

                                                        <cite style="background-color:<?php echo $color_pick; ?>" class="score_big mt-10"><?php if ($all_avg < 10) {
                                                                                                                                                echo number_format($all_avg, 1);
                                                                                                                                            } else {
                                                                                                                                                echo $all_avg;
                                                                                                                                            } ?></cite>
                                                    </div>
                                                    <div class="album_details">
                                                        <label class="title">
                                                            <a href="<?php echo $url_gen; ?>"><?php echo $artist_name; ?></a></label>
                                                        <label class="likes">
                                                            <?php
                                                            if ($user_profile != "") {

                                                                $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$id'"));

                                                                if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                                                                    $bacground_class  =  "text_grey";
                                                                }

                                                                if ($counter == 0) {

                                                            ?>

                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>">
                                                                        <?php
                                                                        if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                                                                        ?>
                                                                            <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <span><?php echo $counter_main; ?></span>
                                                                        <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                    } ?></a></span>

                                                                    <span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>

                                                                <?php
                                                                } else {

                                                                ?>
                                                                    <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>">
                                                                        <?php
                                                                        if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                                                                        ?>
                                                                            <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart heart_color heart_size"></i> </a>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <span><?php echo $counter_main; ?></span>
                                                                        <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                        echo " Like";
                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                        echo " Likes";
                                                                                                                                                                                                                                                                                    } ?></a></span>


                                                                    <span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>
                                                                <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>">

                                                                    <?php
                                                                    if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                                                                    ?>
                                                                        <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <span><?php echo $counter_main; ?></span>
                                                                    <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                    echo " Like";
                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                    echo " Likes";
                                                                                                                                                                                                                                                                                } ?></a></span>

                                                                <span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>
                                                            <?php
                                                            }
                                                            ?>
                                                        </label>
                                                    </div>

                                                </div>
                                                <div class="col-lg-3 col-md-2 col-sm-3 col-xs-12 artist_type red-text pad_zero txtalcnt">
                                                    <a class="red-text" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artist-genre-<?php echo $cat_seo_name; ?>"><?php echo $cat_name; ?></a>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 artist_type red-text">
                                                    <?php if ($all_user_avg != 0) {
                                                    ?><cite style="background-color:<?php echo $color_pick_user; ?>; color:#FFFFFF; padding:8px;"><?php if ($all_user_avg < 10) {
                                                                                                                                                        echo number_format($all_user_avg, 1);
                                                                                                                                                    } else {
                                                                                                                                                        echo $all_user_avg;
                                                                                                                                                    } ?></cite><?php } else { ?> <cite style="background-color:#e06d21;  color:#FFFFFF; padding:8px;">0.5</cite><?php } ?>
                                                </div>
                                            </div>
                                        </li>


                                    <?php
                                    } elseif ($mobile_view == 1) { ?>

                                        <li>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pad_zero">
                                                        <div class="album_cover">
                                                            <?php
                                                            if ($artist_img != "") {
                                                                $img_api_linka = album_img_api($artist_img);
                                                                if ($img_api_linka != '') {
                                                            ?>
                                                                    <a href="<?php echo $url_gen; ?>"><img src="<?php echo get_small_thumb($img_api_linka); ?>" border="0" style="max-width:inherit; width:100px; height:100px;" /></a>
                                                                <?php } else { ?>
                                                                    <a href="<?php echo $url_gen; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>site_upload/artist_images/<?php echo 'thumb_' . $artist_img; ?>" border="0" style="max-width:inherit; width:100px; height:100px;" /></a>
                                                                <?php
                                                                }
                                                            } else
													if ($artist_img == "") {

                                                                if ($req_artist['artist_array']['image4'] != "") {
                                                                ?>
                                                                    <a href="<?php echo $url_gen; ?>"><img src="<?php echo get_small_thumb($req_artist['artist_array']['image4']); ?>" border="0" style="max-width:inherit; width:100px; height:100px;" /></a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a href="<?php echo $url_gen; ?>"><img src="<?php echo SERVER_ROOTPATH; ?>assets/images/no_image4.png" border="0" style="max-width:inherit; width:100px; height:100px;" /></a>
                                                            <?php
                                                                }
                                                            }

                                                            ?>
                                                            <cite class="score_big mt-10" style="background-color:<?php echo $color_pick; ?>; float:right;"><?php if ($all_avg < 10) {
                                                                                                                                                                echo number_format($all_avg, 1);
                                                                                                                                                            } else {
                                                                                                                                                                echo $all_avg;
                                                                                                                                                            } ?></cite>

                                                            <div style="position:absolute; z-index:10; margin-left:82%; color:#FFFFFF; margin-top:-20px;" class="review_screen_txt"><?php echo $sr_no; ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 pad_zero">
                                                        <div class="album_details" style="display:block;">
                                                            <label class="title"><a href="<?php echo $url_gen; ?>"><?php echo $artist_name; ?></a></label>
                                                            <p><label class="likes" style="float:left; height:26px; margin-left:0px; padding-left:0px;">
                                                                    <?php
                                                                    if ($user_profile != "") {

                                                                        $counter =  mysqli_num_rows(mysqli_query($db->dbh, "select id from tbl_likes where like_from_user_id = '" . $_SESSION[USER_SESSION_ARRAY]['USER_ID'] . "' AND  	like_type = 'artist' AND like_id = '$id'"));

                                                                        if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                                                                            $bacground_class  =  "text_grey";
                                                                        }

                                                                        if ($counter == 0) {

                                                                    ?>

                                                                            <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>">
                                                                                <?php
                                                                                if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                                                                                ?>
                                                                                    <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                                <?php
                                                                                } else {
                                                                                ?>
                                                                                    <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                                <span><?php echo $counter_main; ?></span>
                                                                                <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                            } ?></a></span>

                                                                            <span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>

                                                                        <?php
                                                                        } else {

                                                                        ?>
                                                                            <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>">
                                                                                <?php
                                                                                if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                                                                                ?>
                                                                                    <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                                <?php
                                                                                } else {
                                                                                ?>
                                                                                    <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart heart_color heart_size"></i> </a>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                                <span><?php echo $counter_main; ?></span>
                                                                                <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                                echo " Like";
                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                echo " Likes";
                                                                                                                                                                                                                                                                                            } ?></a></span>


                                                                            <span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <span style="overflow:visible;" id="other_dis_sub_<?php echo $id; ?>">
                                                                            <?php
                                                                            if ($_SESSION[USER_SESSION_ARRAY]['USER_ID'] == "") {
                                                                            ?>
                                                                                <a href="#" data-toggle="modal" data-target="#signin_form"><i class="fa fa-heart-o heart_color heart_size"></i></a>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <a href="javascript:;" onClick="add_in_favourite_list_sub('<?php echo $id; ?>','<?php echo $artist_seo; ?>','<?php echo $k; ?>')"><i class="fa fa-heart-o heart_color heart_size"></i> </a>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                            <span><?php echo $counter_main; ?></span>
                                                                            <a href="<?php echo SERVER_ROOTPATH; ?>detail.php?artist=<?php echo $artist_seo; ?>&critaria=1" data-toggle="modal" data-target="#artist_modal" data-title="" class="like link-disable" style="color:#444;"><?php if ($counter_main < 2) {
                                                                                                                                                                                                                                                                                            echo " Like";
                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                            echo " Likes";
                                                                                                                                                                                                                                                                                        } ?></a></span>

                                                                        <span style="overflow:visible; display:none;" id="myStyle_sub_<?php echo $id; ?>"></span>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </label>
                                                                <?php if ($all_user_avg != 0) {
                                                                ?><cite class="score_big mt-10 pad_8" style="background-color:<?php echo $color_pick_user; ?>; float:right;"><?php if ($all_user_avg < 10) {
                                                                                                                                                                                    echo number_format($all_user_avg, 1);
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo $all_user_avg;
                                                                                                                                                                                } ?></cite><?php } else { ?> <cite class="score_big mt-10 pad_8" style="background-color:#e06d21;float:right;">0.5</cite> <?php } ?>
                                                            </p>
                                                            <div style="clear:both;"></div>
                                                            <p>
                                                                <label class="reviews">
                                                                    <a style="color:#D73B3B;" href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artist-genre-<?php echo $cat_seo_name; ?>"><?php echo $cat_name; ?></a></label>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>


                                    <?php } ?>
                            <?php
                                    $k++;
                                }
                            }

                            $kval = $k;
                            ?>
                            </ul>
                        </div>
                        <?php if ($total_pages > $limit) { ?>
                            <div class="page-navigation">
                                <ul>
                                    <?php include("common/paging-playlist.php"); ?>
                                </ul>
                            </div>
                        <?php } ?>
                </div>
                <div class="clearfix"></div>
        </div>
        <?php
        if ($main_link != "") {
        ?>
            <!-- Advertisement Banner Start-->
            <div class="container" style="padding-bottom:15px;">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <?php echo ads_info('Bottom'); ?>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
                </div>
            </div>
            <div class="clear"></div>
            <!--Advertisement Banner End-->
        <?php } ?>
    </div>
    </div>
    <div class="modal fade edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="images/crosspng.png"></span></button>
                    <h4 class="modal-title text_blck">EDIT YOUR REVIEW</h4>
                </div>
                <div class="modal-body">
                    <div class="well">
                        <form>
                            <div class="form-group text-right">
                                <span class="Oswald text_16 mr-10">What is your rating?</span>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                                <a href="#" class="text_blck"><i class="fa fa-star"></i></a>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Review Title" type="text">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="5" placeholder="Your Review"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success Oswald pull-left">Update Review</button>
                            <button type="submit" class="btn btn-danger Oswald pull-right">Delete Review</button>
                            <div class="clear"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ./Middle Section -->







<?php
//include("include/thankyou_messages.php");
//include("common/signin_modal.php");
?>


<div class="modal fade" id="artist_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<div class="modal fade" id="#profile_Modal2_99999999" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>












@include('common.footer')

<style>
	body {
		overflow-x: hidden;
	}
</style>

<script>
	var jq = jQuery.noConflict();
	jq(function() {
		jq("#review_artist").autocomplete({
			source: '<?php echo SERVER_ROOTPATH; ?>search_art2.php'
		});
	});
</script>