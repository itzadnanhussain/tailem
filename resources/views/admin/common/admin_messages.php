<?php

	$login_error_msg 		= base64_encode("Your login details are incorrect. Please check them and try again.");
	
	$forgetpass_err_msg	 	= base64_encode("Email address you provide does not exits.");
	
	$forgetpass_ok_msg 		= base64_encode("New password has been sent to the provided email address. Please check your email.");
	
	$insert_ok_msg 			= base64_encode("Added Successfully.");
	
	$update_ok_msg 			= base64_encode("Updated Successfully.");

    $content_not_found          = base64_encode("No data found on Lastfm.com.");
	
	$popular_error_msg 			= base64_encode("You cannot set more than three popular song.");
	
	$delete_ok_msg 			= base64_encode("Deleted Successfully.");
	
	$myaccwpass_err_msg		= base64_encode("Password you entered is not correct.");	
	
	$myaccwpass_ok_msg		= base64_encode("Password has been changed.");	
	
	$myaccwemail_ok_msg		= base64_encode("Email address has been changed.");	
	
	$unknownfile_formate	= base64_encode("This file formate is not supported.");	
	
	$unknown_err			= base64_encode("Unknown Error Occured.");	

	$emailsent_ok_msg 		= base64_encode("Account Activation Email Sent Successfully!");
	
	$reply_message_ok 		= base64_encode("Message Sent Successfully!");
	$social_links_ok        = base64_encode("Record Update Successfully!");
	$phone_ok        		= base64_encode("Phone Numbers Update Successfully!");
function time_since($original)
 {
   // array of time period chunks

    $chunks = array(

        array(60 * 60 * 24 * 365 , 'year'),

        array(60 * 60 * 24 * 30 , 'month'),

        array(60 * 60 * 24 * 7, 'week'),

        array(60 * 60 * 24 , 'day'),

        array(60 * 60 , 'hour'),

        array(60 , 'Min'),

    );

   

    $today = time(); /* Current unix time  */

    $since = $today - $original;

    // $j saves performing the count function each time around the loop

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {

       

        $seconds = $chunks[$i][0];

        $name = $chunks[$i][1];

       

        // finding the biggest chunk (if the chunk fits, break)

        if (($count = floor($since / $seconds)) != 0) {

            // DEBUG print "<!-- It's $name -->\n";

            break;

        }

    }

    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";

    if ($i + 1 < $j) {

        // now getting the second item

        $seconds2 = $chunks[$i + 1][0];

        $name2 = $chunks[$i + 1][1];

        // add second item if it's greater than 0

       if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {

            $print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
        }

    }

    return $print;
} 

?>