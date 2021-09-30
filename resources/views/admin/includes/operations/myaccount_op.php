<?php

/************************************ Get Admin email *************************************************/
$admin_id       = 	session()->get('reviewsite_cpadmin_id');
$getadmindata	=	"select email from tbl_admin where id=\"".$admin_id."\"";
$rowadmindata	=	\App\Models\Songs::GetRawDataAdmin($getadmindata);;
$adminemail		=	$rowadmindata['email'];

$setting_data_qry = "select site_mode, analaytic, itune_url from tbl_setting where setting_id='1'";
$setting_data_arr = \App\Models\Songs::GetRawDataAdmin($setting_data_qry);
$site_mode   	  = $setting_data_arr['site_mode'];
$analaytic   	  = stripslashes($setting_data_arr['analaytic']);
$itune_url   	  = stripslashes($setting_data_arr['itune_url']);
?>