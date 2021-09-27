<?php
/************This function will filter and data. returns a clean string. use this before insertion and updation in table***********/
function clean_url_seo($text)
{
	$text=strtolower($text);
	$code_entities_match = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','=','"');
	$code_entities_replace = array('-','-','','','','','','','','','','','','','','','','','','','','','','','','');
	$text = str_replace($code_entities_match, $code_entities_replace, $text);
	
	$text = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $text);
	$text = preg_replace("/\r?\n?\t/m", "", $text); 
	$text = str_replace(" ","",$text);
	$text = str_replace("&nbsp;","",$text);
	$text = strip_tags($text);
	
	return $text;
}
function category_level($catid,$db)
{
	$select_level="select level as parent_level,parent_id from tbl_categories where cat_id='".$catid."' ";
	$level_arr     = $db->get_row($select_level, ARRAY_A);
	$parent_level  = $level_arr['parent_level'];
	$parent_cat_id = $level_arr['parent_id'];
	
	if($parent_level>=3)
	{
		return category_level($parent_cat_id,$db);
	}
	if($parent_level==2)
	{
		return $parent_cat_id;
	}
	if($parent_cat_id==0)
	{
		return $root_parent = $catid;
	}
	
}
function get_currentUnxTime()
{
	return mktime(date('G'),date('i'),date('s'),date('m'),date('d'),date('Y'));
}

function safe_string($value)
{
	/*if (get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
	}

	if (!is_numeric($value))
	{
		$value = "" . mysqli_real_escape_string($db->dbh, $value) . "";
	}*/
	return $value;
}

function textresize($str,$start,$limit)
{
	$str_len	=	strlen($str);
	if($str_len >= $limit)	
	{
		$newstr	=	substr($str,$start,$limit);
		$newstr	.=	"...";
		return $newstr;
	}
	else
	{
		$newstr	=	$str;
		return $newstr;
	}
}


function ratingcal($ratval)
{
	if($ratval == 0.0)
	{
		$starval	=	0;
		return $starval;
	}
	if($ratval >= 1.0 && $ratval < 1.5 )
	{
		$starval	=	1;
		return $starval;
	}
	if($ratval >= 1.5 && $ratval < 2.0 )
	{
		$starval	=	1.5;
		return $starval;
	}
	if($ratval >= 2.0 && $ratval < 2.5 )
	{
		$starval	=	2;
		return $starval;
	}
	if($ratval >= 2.5 && $ratval < 3.0 )
	{
		$starval	=	2.5;
		return $starval;
	}
	if($ratval >= 3.0 && $ratval < 3.5 )
	{
		$starval	=	3;
		return $starval;
	}
	if($ratval >= 3.5 && $ratval < 4.0 )
	{
		$starval	=	3.5;
		return $starval;
	}
	if($ratval >= 4.0 && $ratval < 4.5 )
	{
		$starval	=	4;
		return $starval;
	}
	if($ratval >= 4.5 && $ratval < 5.0 )
	{
		$starval	=	4.5;
		return $starval;
	}
	if($ratval >= 5.0)
	{
		$starval	=	5;
		return $starval;
	}
	
}

?>