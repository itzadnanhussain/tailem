<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select embed_code_id from tbl_product_embed_code where embed_code_id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$embed_code_id     = $select_arr['embed_code_id'];
	if($embed_code_id=="")
	{
		echo 'Error';

	}
	else
	{
		$del_qry="Delete from tbl_product_embed_code where embed_code_id='".$embed_code_id."'";
		$db->query($del_qry);
		echo 'done';
	}
}
else

{

	echo 'Error';

}
?>