<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	$question  = trim($_REQUEST['question']);
	$answer    = trim($_REQUEST['answer']);
	$update_id = $_REQUEST['update_id'];
	if($question == "")
	{
		$errorstr .="Please Enter Question\n";
		$case = 0;
	}
	else
	{   
		if($update_id != '')
		{
			$chk_cat_qry = "select count(faq_id) as chk_question from tbl_faq where question=\"".$question."\" 
			and faq_id!='".$update_id."'";
		}
		else
		{
			$chk_cat_qry = "select count(faq_id) as chk_question from tbl_faq where question=\"".$question."\" ";
		}
		$chk_cat_arr = $db->get_row($chk_cat_qry,ARRAY_A);
		$chk_question = $chk_cat_arr['chk_question'];
		if($chk_question>0)
		{
			$errorstr .= "This Question Already Exsist\n";
			$case = 0;
		}
	}
	if($answer == "")
	{
		$errorstr .= "Please Enter Answer\n";
		$case = 0;
	}

	if($case==1)
	{
		if($update_id != '')
		{
		
			$db->query("update tbl_faq set question ='".mysqli_real_escape_string($db->dbh, stripcslashes($question))."',answer ='".mysqli_real_escape_string($db->dbh, stripcslashes($answer))."' where faq_id='".$update_id."'");
		}
		else
		{
			$db->query("insert into tbl_faq set question ='".mysqli_real_escape_string($db->dbh, stripcslashes($question))."',answer ='".mysqli_real_escape_string($db->dbh, stripcslashes($answer))."', status = '1'");
		}
		
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
