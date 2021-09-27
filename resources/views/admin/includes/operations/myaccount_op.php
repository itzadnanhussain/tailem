<?php
/************************************ Get Admin email *************************************************/
$admin_id       = 	$_SESSION['reviewsite_cpadmin_id'];
$getadmindata	=	"select email from tbl_admin where id=\"".$admin_id."\"";
$rowadmindata	=	$db->get_row($getadmindata,ARRAY_A);
$adminemail		=	$rowadmindata['email'];

$setting_data_qry = "select site_mode, analaytic, itune_url from tbl_setting where setting_id='1'";
$setting_data_arr = $db->get_row($setting_data_qry,ARRAY_A);
$site_mode   	  = $setting_data_arr['site_mode'];
$analaytic   	  = stripslashes($setting_data_arr['analaytic']);
$itune_url   	  = stripslashes($setting_data_arr['itune_url']);
?>