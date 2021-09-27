<?php
function mktimeToDate($timestr)
{
	global $sys_dateformate;
	return date('M d, Y', $timestr);
}

function mktimeToDate1($timestr)
{
	global $sys_dateformate;
	return date('m/d/Y', $timestr);
}


function valid_url($str)
{
return ( ! preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $str) || empty($str) ) ? FALSE : TRUE;
}




function getCounties($db){	
	$counties_qry = "SELECT county_Id, county FROM tbl_counties WHERE status = '1' ORDER BY county ASC";							
	$result	=	$db->get_results($counties_qry,ARRAY_A);
	return $result;
}



//Get Counties By Id
//---------------------------------------------------------
function getCountiesByID($county_id,$db){
	
	$get_county = $db->get_row("SELECT county FROM tbl_counties where county_Id = '$county_id'");
	$county_name = $get_county->county;
	return $county_name;
		 	
}

//Get Town By Id
//---------------------------------------------------------
function getTownByID($town_id,$db){
	
	$get_town = $db->get_row("SELECT town FROM tbl_towns where town_id = '$town_id'");
	$town_name = $get_town->town;
	return $town_name;
		 	
}


//Get Town By Id
//---------------------------------------------------------
function getIndustries($db){
	
	$qry = $db->get_results("SELECT id, name FROM tbl_industries ORDER BY name ASC", ARRAY_A);
	return $qry;
		 	
}
?>