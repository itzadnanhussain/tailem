<?php
error_reporting(0);
if ($user_id == "") {
    $check_login_var = 'data-toggle="modal" data-target="#signin_form"';
} else {
    $check_login_var = '';
}

function check_report_review2($review_id)
{
    $counter_query	=	"select r_report_id  from tbl_review_report where r_report_user_id = '" . session()->get('user_id') . "' AND r_report_review_id = '$review_id' AND status = 1";
    $arr =    App\Models\Songs::GetRawDataAdmin($counter_query, array());
    return $arr;
}
?>
<style>
	span.under_line {
		text-decoration: none !important;
	}

	span.under_line:hover {
		text-decoration: underline !important;
	}

	.page-numbers {
		padding: 5px 7px;
		font-size: 12px;
	}

	.pagination {
		width: 100%;
		text-align: center;
	}
</style>
<?php
$limit = 5;

function get_user_detail2($un)
{
    $counter_query	=	"select * from tbl_users where user_name = '$un'";
    $arr = App\Models\Songs::GetRawDataAdmin($counter_query, array());
    $user_seo 	= $arr['user_seo'];
    return $user_seo;
}

if (isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction'] != '') {
    $actionfunction = $_REQUEST['actionfunction'];

    call_user_func($actionfunction, $_REQUEST, $con, $limit, $adjacent);
}

function showData($data, $con, $limit, $adjacent)
{
    $ipad_view = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');
    $GLOBALS['mobile_views'];
    $mm = $GLOBALS['mobile_views'];
    $page = $data['page'];
    $song_id = $data['song_id'];

    if ($page == 1) {
        $start = 0;
    } else {
        $start = ($page - 1) * $limit;
    }
    $sql = "select u.user_id,u.user_name,u.profile_image, c.* from tbl_users u, tbl_comments c where u.user_id = c.comment_user_id AND c.comment_review_id = $song_id  order by comment_id desc";

    $rows  =  App\Models\Songs::GetRawData($sql);

    $rows_count  = count($rows);

    $sql = "select u.user_id,u.user_name,u.profile_image, c.* from tbl_users u, tbl_comments c where u.user_id = c.comment_user_id AND c.comment_review_id = $song_id  order by comment_id desc limit $start,$limit";
    // $sql = "select u.user_id,u.user_name,u.profile_image, c.* from tbl_users u, tbl_comments c where u.user_id = c.comment_user_id AND c.comment_review_id = $song_id  order by comment_id desc";

    $data  =  App\Models\Songs::GetRawData($sql);

    $data_count  = count($data);



    $str =  '<div class="disc_listPan" style="padding:10px;">';

    if ($data_count > 0) {
        $sr_no = 0;
        $prof_counter = 0;
        $count_i = 0;
        while ($row = $data[$count_i]) {
            $row = (array)$row;

            $sr_no++;
            $prof_counter++;
            $db_comment_id   = $row['comment_id'];
            $db_user_name     = $row['user_name'];
            $db_user_id     = $row['user_id'];
            $db_profile_image     = $row['profile_image'];
            $db_comment_details    = stripslashes($row['comment_details']);
            $db_comment_post_date     = date("d M Y", stripslashes($row['comment_post_date']));

            $db_user_name_encode  = urlencode($db_user_name);


            if (strlen($row['user_name']) > 11) {
                $user_art  = substr($row['user_name'], 0, 11) . '..';
            } else {
                $user_art  = $row['user_name'];
            }

            if ($ipad_view == 1) {
                if (strlen($row['user_name']) > 8) {
                    $user_art_ipad  = substr($row['user_name'], 0, 8) . '..';
                }
            }

            if ($db_profile_image != "") {
                $prof_image = SERVER_ROOTPATH . 'assets/phpthumb/phpThumb.php?src=' . SERVER_ROOTPATH . 'site_upload/user_images/' . $db_profile_image . '&w=100&h=75&zc=0';
            } else {
                $prof_image = SERVER_ROOTPATH . 'assets/phpthumb/phpThumb.php?src=' . SERVER_ROOTPATH . 'assets/images/no_image4.png&w=100&h=75&zc=0';
            }

            if ($db_user_name == session()->get('user_name')) {
                $report_status  = '<a data-title="" data-target="#edit_Modal4_' . $sr_no . '" data-toggle="modal" href="' . SERVER_ROOTPATH . 'edit_comment?comment_id=' . $db_comment_id . '&num=' . $sr_no . '">Edit </a>';
            } else {
                if (session()->get('user_id') == "") {
                    $report_status  = '<a href="javascript:;" data-toggle="modal" data-target="#signin_form" class="linktag_new under_line" >Report</a>';
                } else {
                    if (session()->get('user_id')!= "") {
                        $report_status_info = check_report_review2($db_comment_id);

                        if (isset($report_status_info)) {
                            $report_status  = '<a class="linktag_new under_line" href="#" data-toggle="modal" data-target="#report_already_message" data-title="">Report</a>';
                        } else {
                            $report_status  = '<a href="' . SERVER_ROOTPATH . 'report_discussion.php?rev_id=' . $db_comment_id . '&num=' . $sr_no . '" data-toggle="modal" data-target="#edit_Modal4s_' . $sr_no . '" data-title="" class="linktag_new under_line">Report</a>';
                        }
                    }
                }
            } ?>

<?php
            $likes_str  = "";


            $counter_query = "select id from tbl_likes where like_type = 'profile' AND like_id = '$db_user_id'";
            $counter_main =  count(App\Models\Songs::GetRawData($counter_query, array()));
            if (session()->get('user_id') != "") {
                $sql = "select id from tbl_likes where like_from_user_id = '" . session()->get('user_id') . "' AND  like_type = 'profile' AND like_id = '$db_user_id'";
                $counter =  count(App\Models\Songs::GetRawData($sql));
                if ($counter == 0) {
                    if ($counter_main < 2) {
                        $like_text = " Like";
                    } else {
                        $like_text = " Likes";
                    }

                    $likes_str  .= '<span class="revlikespan" id="other_dis_sub_profile_discussion_' . $prof_counter . '">';

                    $likes_str  .= "<a href='javascript:;' onClick=add_in_favourite_user_profile_mainlist_discussion_new('$db_user_id','$prof_counter','$db_user_name_encode') class='like'><i class='fa fa-heart-o heart_color'></i></a>";

                    $likes_str  .= '<span class="like" style="color:#fff; margin-left:2px;"></span>';

                    $likes_str  .= '<a href="' . SERVER_ROOTPATH . 'detail_profile.php?user=' . urlencode($db_user_name) . '&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" style="color:#fff; margin-right:4px; font-size:10px;"> ' . $counter_main . '</a></span>';

                    $likes_str  .=  '<span  id="myStyle_sub_profile_discussion_' . $prof_counter . '"></span>';
                } else {
                    if ($counter_main < 2) {
                        $like_text = " Like";
                    } else {
                        $like_text = " Likes";
                    }


                    $likes_str  .= '<span class="revlikespan2" id="other_dis_sub_profile_discussion_' . $prof_counter . '">';
                    $likes_str  .= "<a href='javascript:;' onClick=add_in_favourite_user_profile_mainlist_discussion_new('$db_user_id','$prof_counter','$db_user_name_encode') class='like'><i class='fa fa-heart heart_color'></i></a>";

                    $likes_str  .= '<span class="like" style="color:#fff; margin-left:2px;"></span>';

                    $likes_str  .= '<a href="' . SERVER_ROOTPATH . 'detail_profile.php?user=' . urlencode($db_user_name) . '&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" style="color:#fff; margin-right:4px; font-size:10px;" > ' . $counter_main . '</a></span>';

                    $likes_str  .=  '<span  id="myStyle_sub_profile_discussion_' . $prof_counter . '"></span>';
                }
            } else {
                if ($counter_main < 2) {
                    $like_text = " Like";
                } else {
                    $like_text = " Likes";
                }

                $likes_str  .= '<span class="revlikespan3" id="other_dis_sub_profile_discussion_' . $prof_counter . '">';

                if (session()->get('user_id') == "") {
                    $likes_str  .= '<a href="javascript:;" data-toggle="modal" data-target="#signin_form" class="like"><i class="fa fa-heart-o heart_color"></i> </a>';
                } else {
                    $likes_str  .= "<a href='javascript:;' onClick=add_in_favourite_user_profile_mainlist_discussion_new('$db_user_id','$prof_counter','$db_user_name_encode') class='like'><i class='fa fa-heart-o heart_color'></i></a>";
                }


                $likes_str  .= '<span class="like" style=" color:#fff; margin-left:2px;"></span>';

                $likes_str  .= '<a href="' . SERVER_ROOTPATH . 'detail_profile.php?user=' . urlencode($db_user_name) . '&critaria=1" data-toggle="modal" data-target="#profile_modal" data-title="" style="color:#fff; margin-right:4px; font-size:10px;" >' . substr($counter_main, 0, 2) . '</a></span>';

                $likes_str  .=  '<span id="myStyle_sub_profile_discussion_' . $prof_counter . '"></span>';
            } ?>
<?php
            if ($mm == 0 || $mm == 1) {
                //echo "aaaa";

                if ($ipad_view == 1) {
                    $user_art = $user_art_ipad;
                }

                $str .=  '<div class="disc_list">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 img-div" style="padding:0;">
                            	<div class="latestsongssec" style="width:100%;">
									<div class="list_item">
									<img src="' . $prof_image . '" class="img-responsive artist-img" style="width:100%;">
											<div class="list_bottom" style="padding:2px;">
												<div class="row">
													<div class="col-lg-8 col-md-8 col-sm-7 col-xs-7 pad_right">
														<a href="' . SERVER_ROOTPATH . get_user_detail2($db_user_name) . '-profile-review-artist"><cite class="reviewscite" style="margin-top:0; font-size:10px; margin-left:6px; color:#fff;"  title = "' . $row['user_name'] . '">' . $user_art . '</cite></a>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 pad_zero">
													  ' . $likes_str . '
                                                                                                								 											                                                    </div>
												</div>
											</div>
									</div>
								</div>
							</div>
							';

                $str .= ' <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8  text-panel" style="margin-top:0; padding-right:2px;">
								<p class="review_detail darkgrey_rev" style="color:#000000; min-height:60px;">' . $db_comment_details . '</p>
								<p><span >' . $db_comment_post_date . '</span>&nbsp; <span class="under_line" style="float:right;">' . $report_status . ' </span></p>
							</div>
                              <div class="clearfix"></div>
						</div>';
            } elseif ($mm == 1) {
            }
            $count_i = $count_i + 1;
        }
    }
    $str .= '</div>'; ?>
<?php

    echo $str;
 
 
    pagination($limit, $adjacent, $rows_count, $page);
}
function pagination($limit, $adjacents, $rows_count, $page)
{
    $pagination = '';
    if ($page == 0) {
        $page = 1;
    }					//if no page var is given, default to 1.
    $prev = $page - 1;							//previous page is page - 1
    $next = $page + 1;							//next page is page + 1
    $prev_ = '';
    $first = '';
    $lastpage = ceil($rows_count / $limit);
    $next_ = '';
    $last = '';
    if ($lastpage > 1) {

        //previous button
        if ($page > 1) {
            $prev_ .= "<a class='page-numbers linkTag under_line' href=\"?page=$prev\">&laquo;</a>";
        } else {
            //$pagination.= "<span class=\"disabled\">previous</span>";
        }

        //pages
        if ($lastpage < 5 + ($adjacents * 2)) {	//not enough pages to bother breaking it up
            $first = '';
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page) {
                    $pagination .= "<span class=\"current\">$counter</span>";
                } else {
                    $pagination .= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";
                }
            }
            $last = '';
        } elseif ($lastpage > 3 + ($adjacents * 2)) {	//enough pages to hide some
            //close to beginning; only hide later pages
            $first = '';
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<span class=\"current\">$counter</span>";
                    } else {
                        $pagination .= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";
                    }
                }
                $last .= "<a class='page-numbers' href=\"?page=$lastpage\">Last</a>";
            }

            //in middle; hide some front and some back
            elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $first .= "<a class='page-numbers' href=\"?page=1\">First</a>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<span class=\"current\">$counter</span>";
                    } else {
                        $pagination .= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";
                    }
                }
                $last .= "<a class='page-numbers' href=\"?page=$lastpage\">Last</a>";
            }
            //close to end; only hide early pages
            else {
                $first .= "<a class='page-numbers' href=\"?page=1\">First</a>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<span class=\"current\">$counter</span>";
                    } else {
                        $pagination .= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";
                    }
                }
                $last = '';
            }
        }
        if ($page < $counter - 1) {
            $next_ .= "<a class='page-numbers linkTag under_line' href=\"?page=$next\">&raquo;</a>";
        } else {
            //$pagination.= "<span class=\"disabled\">next</span>";
        }
        $pagination = "<div class=\"pagination\">" . $first . $prev_ . $pagination . $next_ . $last;
        //next button

        $pagination .= "</div>\n";
    }

    echo $pagination;
}
