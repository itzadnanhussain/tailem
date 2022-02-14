<?php
include("../includes/top.php");
include("../common/security.php");
if (!empty($_POST['review_ids'])) {
	if ($_POST['dropdown'] == 'Delete') // from button name="delete"
	{
		$checkbox = $_POST['review_ids']; //from name="checkbox[]"
		$countCheck = count($_POST['review_ids']);

		for ($i = 0; $i < $countCheck; $i++) {
			$review_id     = base64_decode($checkbox[$i]);
			$notification_qry = "select review_user_id,review_id from tbl_reviews where review_id='" . $review_id . "'";
			$notification_arr = $db->get_row($notification_qry, ARRAY_A);
			$review_user_id   = $notification_arr['review_user_id'];
			$review_id      = $notification_arr['review_id'];


			$song_notification =
				"select s.song_title, s.song_seo, a.artist_seo  
						   from  tbl_reviews r, tbl_songs s, tbl_artists a  
						   where r.review_id = $review_id 
						   AND r.song_id = s.id
						   AND r.artist_id = a.id";

			$song_result_notification = $db->get_row($song_notification, ARRAY_A);



			$mesg = "Moderator has removed your review on <a class=\"text_blck\" href=\"" . SERVER_ROOTPATH . $song_result_notification['song_seo'] . "/reviews/" . $song_result_notification['artist_seo'] . ".html\"><strong>" . wordwrap(stripslashes($song_result_notification['song_title']), 100, " ", true) . "</strong></a>.";





			$insert_notification_qry = "insert into tbl_likes set 
		like_type='delete_review_song',description='$mesg',read_status='1',like_id='$review_id', like_receive_user='$review_user_id', date='" . date("Y-m-d") . "'";
			$db->query($insert_notification_qry);




			$del_review_qry = "Delete from tbl_reviews where review_id='" . $review_id . "'";
			$result = $db->query($del_review_qry);

			//delete review like
			$del_review_like_qry = "Delete from tbl_review_likes where review_id_like='" . $review_id . "'";
			$db->query($del_review_like_qry);

			//delete review Report
			$del_review_report_qry = "Delete from tbl_review_report where r_report_review_id='" . $review_id . "'";
			$db->query($del_review_report_qry);

			$select_comment_qry = "select comment_id from tbl_comments where comment_review_id='" . $review_id . "'";
			$comment_arr = $db->get_results($select_comment_qry, ARRAY_A);
			if ($comment_arr) {
				foreach ($comment_arr as $val) {
					$comment_id = $val['comment_id'];

					//delete comment like
					$del_com_like_qry = "Delete from tbl_comments_likes where comment_like_comment_id='" . $comment_id . "'";
					$db->query($del_com_like_qry);

					//delete comment Report
					$del_com_report_qry = "Delete from tbl_comment_report where c_report_comment_id='" . $comment_id . "'";
					$db->query($del_com_report_qry);

					//delete comment
					$del_comment_qry = "Delete from tbl_comments where comment_id='" . $comment_id . "'";
					$db->query($del_comment_qry);
				}
			}

			//delete Notification
			$del_notification_qry = "Delete from tbl_notifications where common_notification_id='" . $review_id . "' 
			and type='Review Like'";
			$db->query($del_notification_qry);
		}

		if ($result) {
			$okmsg = base64_encode("Deletion Successfully Done.");
			header('Location:' . SERVER_ADMIN_PATH . "reviews_list.php?msg=$okmsg&case=1");
		} else {
			echo "Error: " . mysqli_error($db->dbh);
		}
	}


	if ($_POST['dropdown'] == 'Active') // from button name="delete"
	{
		$checkbox = $_POST['review_ids']; //from name="checkbox[]"
		$countCheck = count($_POST['review_ids']);

		for ($i = 0; $i < $countCheck; $i++) {
			$del_id  = base64_decode($checkbox[$i]);
			$qry = "select status from tbl_reviews where review_id='" . $del_id . "'";
			$res = mysqli_query($db->dbh, $qry);
			$resul = mysqli_fetch_assoc($res);
			$status = $resul['status'];
			if ($status == 0) {
				$status = 1;
			}
			$del_id  = base64_decode($checkbox[$i]);
			$sql = "update tbl_reviews set status=$status where review_id='" . $del_id . "'";
			$result = mysqli_query($db->dbh, $sql) or die(mysqli_error($mysqli));
		}
		if ($result) {
			$okmsg = base64_encode("status changed successfully.");
			header('Location:' . SERVER_ADMIN_PATH . "reviews_list.php?msg=$okmsg&case=1");
		} else {
			echo "Error: " . mysqli_error($db->dbh);
		}
	}

	if ($_POST['dropdown'] == 'Inactive') // from button name="delete"
	{
		$checkbox = $_POST['review_ids']; // from name="checkbox[]"
		$countCheck = count($_POST['review_ids']);

		for ($i = 0; $i < $countCheck; $i++) {
			$del_id  = base64_decode($checkbox[$i]);
			$qry     = "select status from tbl_reviews where review_id='" . $del_id . "'";
			$res     = mysqli_query($db->dbh, $qry);
			$resul   = mysqli_fetch_assoc($res);
			$status  = $resul['status'];
			if ($status == 1) {
				$status = 0;
			}
			$del_id  = base64_decode($checkbox[$i]);
			$sql = "update tbl_reviews set status=$status where review_id='" . $del_id . "'";
			$result = mysqli_query($db->dbh, $sql); //or die(mysqli_error($db->dbh$sql));
		}

		if ($result) {
			$okmsg = base64_encode('status changed successfully.');
			header('Location:' . SERVER_ADMIN_PATH . "reviews_list.php?msg=$okmsg&case=1");
		} else {
			echo "Error: " . mysqli_error($db->dbh);
		}
	}
} else {
	$errormsg = base64_encode('First select a record to perform some action');
	header('Location:' . SERVER_ADMIN_PATH . "reviews_list.php?msg=$errormsg&case=2");
}
