<?php 
include("../includes/top.php");
include("../common/security.php"); 
if(!empty($_POST['del_id']))
{
	$select_qry = "select id from tbl_admin where id='".$_POST['del_id']."' ";	
	$select_arr = $db->get_row($select_qry,ARRAY_A);
	$id     = $select_arr['id'];
	if($id=="")
	{
		echo 'Error';
	}
	elseif($id=='1')
	{
		echo 'This user can not be deleted';
	}
	else
	{
		$del_qry="Delete from tbl_admin where id='".$id."' and id!='1' ";
		$db->query($del_qry);
		
		$del_moderator_qry="Delete from tbl_moderator_rights where moderator_id='".$id."' and id!='1' ";
		$db->query($del_moderator_qry);
				
		echo 'done';
	}
}
else
{
	echo 'Error';
}
?>