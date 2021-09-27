<?php
	
	include("includes/top.php");
	include("common/security.php");

	$keyword = $_POST['data'];
	$sql = "select user_name from tbl_users where user_name like '".$keyword."%' limit 0,20";
	//$sql = "select name from ".$db_table."";
	$result = $db->get_results($sql,ARRAY_A);

	if($result)
	{
		echo '<ul class="list">';
		foreach($result as $row)
		{
			$str = stripslashes($row['user_name']);
			$start = strpos($str,$keyword); 
			$end   = similar_text($str,$keyword); 
			$last = substr($str,$end,strlen($str));
			$first = substr($str,$start,$end);
			
			$final = '<span class="bold">'.$first.'</span>'.$last;
		
			echo '<li><a href=\'javascript:void(0);\'>'.$final.'</a></li>';
		}
		echo "</ul>";
	}
	else
		echo 0;
?>	   
