<?php
ob_start();
/********************************************************* Login Page Operations ******************************************************/
if (isset($SubmitButton)) {

	$username 		=	safe_string($username);
	$password 		=	safe_string($password);
	$password		=	md5($password);


	//ERROR Case 0=invalid & 1=valid
	$case = 1;
	$chklogin		=	"select count(id) as loginchk from tbl_admin WHERE username=\"" . $username . "\" AND password=\"" . $password . "\" AND admin_status='1'";
	$chkloginarr	=	\App\Models\Songs::GetRawData($chkloginarr);

	if ($chkloginarr[0]->loginchk == 0) {
?>
		<script language="javascript" type="text/javascript">
			window.location = 'login.php?msg=<?php echo $login_error_msg; ?>&case=3';
		</script>
	<?php
		exit;
	} else {

		//Getting ADMIN USER ID AND NAME
		$pointchk		=	"SELECT id,username,type from tbl_admin WHERE username=\"" . $username . "\" AND password=\"" . $password . "\" AND admin_status='1'";

		$rowpointchk	 =	\App\Models\Songs::GetRawData($pointchk);
		$rowpointchk	 =	 (array)$rowpointchk[0];

		$id				 =	$rowpointchk["id"];
		$username        =	stripslashes(html_entity_decode($rowpointchk["username"]));
		$login_user_type =	$rowpointchk["type"];
		//----------------------------------------------------

		session()->put('reviewsite_cpadmin_id', $id);
		session()->put('reviewsite_cpadmin_uname', $username);
		session()->put('reviewsite_cpadmin_type', $login_user_type);

		//login logs
		$qry = "insert into tbl_login_logs set login_user_id='" . session()->put('reviewsite_cpadmin_id', $id) . "',
		login_date='" . time() . "',login_ip='" . $_SERVER['REMOTE_ADDR'] . "' ";
		\App\Models\Songs::GetRawData($qry);

	?>
		<script language="javascript" type="text/javascript">
			window.location = 'index.php';
		</script>
<?php
		exit;
	}
}

?>