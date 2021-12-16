<?php
$user_profile_id = $user_profile;


///count reviews
$count_reviews = '(' . count(GetByWhere('reviews', array('review_user_id' => $user_profile_id))) . ')';


///count likes
$count_likes = '(' . count(GetByWhere('likes', array('like_from_user_id' => $user_profile_id))) . ')';
$count_review_likes = '(' . count(GetByWhere('likes', array('like_from_user_id' => $user_profile_id, 'like_type' => 'review_song'))) . ')';
$count_artist_likes = ' (' . count(GetByWhere('likes', array('like_from_user_id' => $user_profile_id, 'like_type' => 'artist'))) . ')';
$count_profile_likes = ' (' . count(GetByWhere('likes', array('like_from_user_id' => $user_profile_id, 'like_type' => 'profile'))) . ')';
$count_playlist_likes = ' (' . count(GetByWhere('likes', array('like_from_user_id' => $user_profile_id, 'like_type' => 'playlist'))) . ')';


///count playlist
$count_playlist = '(' . count(GetByWhere('user_playlist', array('user_id_playlist' => $user_profile_id))) . ')';



///count posts
$count_posts = '(' . count(GetByWhere('comments', array('comment_user_id' => $user_profile_id))) . ')';








?>
<?php if (isset($user_type) && ($user_type == 'admin')) { ?>


<ul class="list-inline">


    <li><a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artist?user_type=admin"
            <?php if ($currentFile == "my_reviews" || $currentFile == "review_artist" || $currentFile == "review-artist" || $currentFile == "review_album") { ?>class="active"
            <?php } else { ?><?php } ?>>REVIEWS <span class="counter-color"><?php echo $count_reviews ?></span></a> |
        <?php
            if ($main_link == "") {
                $full_link = SERVER_ROOTPATH . $main_link . "like-review";
            } else {
                $full_link = SERVER_ROOTPATH . get_user_detail($user_name) . "/profile-like-review";
            }
            ?>
        <a href="<?php echo $full_link; ?>?user_type=admin" <?php if ($currentFile == "my_account" || $currentFile == "like_artist" || $currentFile == "my_account_profile" || $currentFile == "likes_profile" || $currentFile == "likes_playlist") { ?>
            class="active" <?php } else { ?> <?php } ?>>LIKES <span class="counter-color"><?php echo $count_likes; ?></span></a> |

        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>discussions?user_type=admin"
            <?php if ($currentFile == "my_discussion") { ?>
            class="active" <?php } else { ?><?php } ?>>POSTS <span class="counter-color"><?php echo $count_posts; ?></span></a>
        |
        <?php
            $get_firstplaylist  =  get_first_playlist_record($user_profile);
            if ($get_firstplaylist) {
                $get_firstplaylist = (array)$get_firstplaylist[0];
                $playlist_first  =  "-" . stripslashes($get_firstplaylist['title_playlist_seo']);
            } else {
                $playlist_first  =  "";
            }
            ?>
        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>playlists<?php echo $playlist_first; ?>?user_type=admin"
            <?php if ($currentFile == "my_playlist") { ?>
            class="active" <?php } ?>>PLAYLISTS <span
                class="counter-span"><?php echo $count_playlist ?></span>
        </a>
    </li>

</ul>
<?php
    if ($currentFile == "my_account" || $currentFile == "like_artist" || $currentFile == "my_account_profile" || $currentFile == "likes_profile" || $currentFile == "likes_playlist") {
        ?>
<ul class="list-inline">
    <li>
        <a>By</a>
        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>like-review?user_type=admin"
            <?php if ($currentFile == "my_account" || $currentFile == "my_account_profile") { ?>
            class="active" <?php } else { ?><?php } ?>>REVIEWS <span class="counter-color"><?php echo $count_reviews ?></span></a> |

        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>like-artist?user_type=admin"
            <?php if ($currentFile == "like_artist") { ?>
            class="active" <?php } else { ?> <?php } ?>>ARTISTS</a> |

        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>like-profile?user_type=admin"
            <?php if ($currentFile == "likes_profile") { ?>
            class="active" <?php } else { ?> <?php } ?>>PROFILE</a> |

        <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>like-playlist?user_type=admin"
            <?php if ($currentFile == "likes_playlist") { ?>
            style="color:#c63434;" <?php } else { ?> <?php } ?>>Playlist</a>
    </li>

    <?php
    }

    if ($currentFile == "my_discussion") {
        ?>
    <ul class="list-inline">
        <li>
            <a>By</a> <a class="active"
                href="<?php echo SERVER_ROOTPATH . $main_link; ?>discussions?user_type=admin">POSTS
                <span class="counter-color"><?php echo $count_posts; ?></span></a>
        </li>
    </ul>

    <?php
    }

    if ($currentFile == "my_reviews" || $currentFile == "review_artist" || $currentFile == "review-artist" || $currentFile == "review_album") {
        ?>

    <ul class="list-inline">
        <li>
            <a>By</a>
            <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artist?user_type=admin"
                <?php if ($currentFile == "review_artist" || $currentFile == "review-artist") { ?>
                class="active" <?php } else { ?> <?php } ?>>ARTISTS</a> |

            <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-album?user_type=admin"
                <?php if ($currentFile == "review_album") { ?>
                class="active" <?php } else { ?> <?php } ?>>ALBUMS</a> |

            <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-song?user_type=admin"
                <?php if ($currentFile == "my_reviews") { ?>
                class="active" <?php } else { ?> <?php } ?>> SONGS</a>
    </ul>

    <?php
    }



    if ($currentFile == "my_playlist") {
        ?>
    <ul class="list-inline">
        <li>
            <a>By</a>
            <?php
                    $playlist_arr =  playlist_for_user($user_profile);
        if (isset($playlist_arr)) {
            $total_playlist    =    count($playlist_arr);
            $pl = 1;
            foreach ($playlist_arr as $arr_playlist) {
                ?><a
                href="<?php echo SERVER_ROOTPATH . $main_link; ?>playlists-<?php echo stripslashes($arr_playlist['title_playlist_seo']); ?>?user_type=admin"
                <?php if ($seo_playlist == $arr_playlist['title_playlist_seo']) { ?>
                class="active" <?php } else { ?> <?php } ?>><?php echo stripslashes($arr_playlist['title_playlist']); ?></a>
            <?php
                            if ($total_playlist != $pl) {
                                echo "|";
                            }
                $pl++;
            }
        } ?>


    </ul>

    <?php
    }
        ?>


    <?php } else { ?>


    <ul class="list-inline">


        <li><a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artist"
                <?php if ($currentFile == "my_reviews" || $currentFile == "review_artist" || $currentFile == "review-artist" || $currentFile == "review_album") { ?>class="active"
                <?php } else { ?><?php } ?>>REVIEWS <span class="counter-color"><?php echo $count_reviews ?></span></a> |
            <?php
                if ($main_link == "") {
                    $full_link = SERVER_ROOTPATH . $main_link . "like-review";
                } else {
                    $full_link = SERVER_ROOTPATH . get_user_detail($user_name) . "/profile-like-review";
                }
                ?>
            <a href="<?php echo $full_link; ?>" <?php if ($currentFile == "my_account" || $currentFile == "like_artist" || $currentFile == "my_account_profile" || $currentFile == "likes_profile" || $currentFile == "likes_playlist") { ?>
                class="active" <?php } else { ?> <?php } ?>>LIKES <span class="counter-color"><?php echo $count_likes; ?></span></a> |

            <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>discussions"
                <?php if ($currentFile == "my_discussion") { ?>
                class="active" <?php } else { ?><?php } ?>>POSTS <span class="counter-color"><?php echo $count_posts; ?></span></a>
            |
            <?php
                $get_firstplaylist  =  get_first_playlist_record($user_profile);
                if ($get_firstplaylist) {
                    $get_firstplaylist = (array)$get_firstplaylist[0];
                    $playlist_first  =  "/" . stripslashes($get_firstplaylist['title_playlist_seo']);
                } else {
                    $playlist_first  =  "";
                }
                ?>
            <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>playlists<?php echo $playlist_first; ?>"
                <?php if ($currentFile == "my_playlist") { ?>
                class="active" <?php } ?>>PLAYLISTS <span
                    class="counter-color"><?php echo $count_playlist; ?></span></a>
        </li>

    </ul>
    <?php

        if ($currentFile == "my_account" || $currentFile == "like_artist" || $currentFile == "my_account_profile" || $currentFile == "likes_profile" || $currentFile == "likes_playlist") {
            ?>
    <ul class="list-inline">
        <li>
            <a>By</a>
            <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>like-review"
                <?php if ($currentFile == "my_account" || $currentFile == "my_account_profile") { ?>
                class="active" <?php } else { ?><?php } ?>>REVIEWS <span class="counter-color"><?php echo $count_review_likes ?></span></a> |

            <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>like-artist"
                <?php if ($currentFile == "like_artist") { ?>
                class="active" <?php } else { ?> <?php } ?>>ARTISTS<span class="counter-color"><?php echo $count_artist_likes ?></span></a> |

            <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>like-profile"
                <?php if ($currentFile == "likes_profile") { ?>
                class="active" <?php } else { ?> <?php } ?>>PROFILE<span class="counter-color"><?php echo $count_profile_likes ?></span></a> |

            <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>like-playlist"
                <?php if ($currentFile == "likes_playlist") { ?>
                style="color:#c63434;" <?php } else { ?> <?php } ?>>PLAYLIST<span class="counter-color"><?php echo $count_playlist_likes ?></span></a>
        </li>

        <?php
        }

        if ($currentFile == "my_discussion") {
            ?>
        <ul class="list-inline">
            <li>
                <a>By</a> <a class="active"
                    href="<?php echo SERVER_ROOTPATH . $main_link; ?>discussions">POSTS
                    <span class="counter-color"><?php echo $count_posts; ?></span></a>
            </li>
        </ul>

        <?php
        }

        if ($currentFile == "my_reviews" || $currentFile == "review_artist" || $currentFile == "review-artist" || $currentFile == "review_album") {
            ?>

        <ul class="list-inline">
            <li>
                <a>By</a>
                <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-artist"
                    <?php if ($currentFile == "review_artist" || $currentFile == "review-artist") { ?>
                    class="active" <?php } else { ?> <?php } ?>>ARTISTS <span class="counter-color"><?php echo $count_reviews; ?></span></a> |

                <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-album"
                    <?php if ($currentFile == "review_album") { ?>
                    class="active" <?php } else { ?> <?php } ?>>ALBUMS <span class="counter-color"><?php echo $count_reviews; ?></span></a> |

                <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>review-song"
                    <?php if ($currentFile == "my_reviews") { ?>
                    class="active" <?php } else { ?> <?php } ?>> SONGS <span class="counter-color"><?php echo $count_reviews; ?></span></a>
        </ul>

        <?php
        }



        if ($currentFile == "my_playlist") {
            ?>
        <ul class="list-inline">
            <li>
                <a>By</a>
                <?php
                        $playlist_arr =  playlist_for_user($user_profile);
            if (isset($playlist_arr)) {
                $total_playlist    =    count($playlist_arr);
                $pl = 1;
                foreach ($playlist_arr as $arr_playlist) {
                    $playlist_id = $arr_playlist->id;
                    $playlist_count = '('.count(GetByWhere('user_playlist_songs', array('playlist_id' => $playlist_id))).')';
                            
                    $arr_playlist = (array)$arr_playlist; ?>
                <a href="<?php echo SERVER_ROOTPATH . $main_link; ?>playlists/<?php echo stripslashes($arr_playlist['title_playlist_seo']); ?>"
                    <?php if ($seo_playlist == $arr_playlist['title_playlist_seo']) { ?>
                    class="active" <?php } else { ?> <?php } ?>><?php echo stripslashes($arr_playlist['title_playlist'] . $playlist_count); ?></a>
                <?php
                                if ($total_playlist != $pl) {
                                    echo "|";
                                }
                    $pl++;
                }
            } ?>


        </ul>

        <?php
        }
    } ?>

        <style>
            .counter-color {
                color: #c63434;

            }
        </style>