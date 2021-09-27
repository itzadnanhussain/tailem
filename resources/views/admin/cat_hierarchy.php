<?php
$level4_qry ="Select cat_id as level4_id,cat_name as level4_name,parent_id as level4_parent from tbl_categories where cat_id='".$parent_id."' and level='4'";
$level4_arr    = $db->get_row($level4_qry,ARRAY_A);
$level4_id     = $level4_arr['level4_id'];
$level4_parent = $level4_arr['level4_parent'];
$level4_name   = stripcslashes(html_entity_decode($level4_arr['level4_name']));		

$level3_qry ="Select cat_id as level3_id,cat_name as level3_name,parent_id as level3_parent from tbl_categories where cat_id='".$level4_parent."' and level='3' ";
$level3_arr    = $db->get_row($level3_qry,ARRAY_A);
$level3_id     = $level3_arr['level3_id'];
$level3_parent = $level3_arr['level3_parent'];
$level3_name   = stripcslashes(html_entity_decode($level3_arr['level3_name']));	

$level2_qry ="Select cat_id as level2_id,cat_name as level2_name,parent_id as level2_parent from tbl_categories where cat_id='".$level3_parent."' and level='2' ";
$level2_arr    = $db->get_row($level2_qry,ARRAY_A);
$level2_id     = $level2_arr['level2_id'];
$level2_parent = $level2_arr['level2_parent'];
$level2_name   = stripcslashes(html_entity_decode($level2_arr['level2_name']));	

$level1_qry ="Select cat_id as level1_id,cat_name as level1_name from tbl_categories where cat_id='".$level2_parent."' and level='1' ";
$level1_arr    = $db->get_row($level1_qry,ARRAY_A);
$level1_id     = $level1_arr['level1_id'];
$level1_name   = stripcslashes(html_entity_decode($level1_arr['level1_name']));		
?>