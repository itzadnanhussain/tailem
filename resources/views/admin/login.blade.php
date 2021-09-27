@include("admin.includes.top") 

<?php 
// @include("admin.includes.operations.administration_op");
//echo "test2";
//die();


//--------------------------------------------------------------------------------------------
//Captcha Code
$hash 	=	substr(md5(mt_rand(1, 1000)), 10, 20); // Just generate a random hash to use
//--------------------------------------------------------------------------------------------

?>
<script type="text/javascript">
  function reloadCaptcha(imageName)
  {
      var randomnumber=Math.floor(Math.random()*1001); // generate a random number to add to image url to prevent caching
      document.images[imageName].src = document.images[imageName].src + '&amp;rand=' + randomnumber; // change image src to the same url but with the random number on the end
    }
  </script>
<html>
    <head>
        <!-- Start pageheader -->
        <title>Admin - Control Panel</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="pragma" content="no-cache">
        <link rel="shortcut icon" href="favicon.ico" >
        <link rel="stylesheet" id="login-css" href="styles/login.css" type="text/css" media="all">
        <link rel="stylesheet" id="colors-fresh-css" href="styles/colors-fresh.css" type="text/css" media="all">
        <script language="JavaScript" type="text/javascript">
		window.onerror = function() { return true; }
		window.onload = doLoad;
        
		function doLoad() {
			frmLogin.username.focus()
			if (frmLogin.username.value != '') {
                frmLogin.password.focus();
			}
		}
		
		function CheckLogin()
		{
            var f = document.frmLogin;
			
			if(f.username.value == '')
			{
                alert('Please enter your username.');
				f.username.focus();
				f.username.select();
				return false;
			}
			
			if(f.password.value == '')
			{
                alert('Please enter a password.');
				f.password.focus();
				f.password.select();
				return false;
			}
			
			// Everything is OK
			return true;
		}
        
        </script>
        @include("admin.common.header")
</head>
<body class="login">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="height:600px;" align="center" valign="middle"><div id="login">
                <div style="height:50px;">
    <h1>Admin Panel Login</h1>
  </div>
  <form action="" method="post" name="frmLogin" onSubmit="return CheckLogin()">
  @csrf   
  <input type="hidden" id="hash"  value="<?php echo $hash; ?>" name="hash">
      <?php if(isset($msg) && $msg!=""){ ?>
        <p>
            <table>
      <tr>
        <td colspan="10"><table border="0" cellpadding="0" cellspacing="0" class="Message">
            <tbody>
              <tr>
                <td width="25"><img src="<?php SERVER_ADMIN_PATH ?>images/error.gif" vspace="5" width="18" height="18" hspace="10"> </td>
                <td width="100%"><?php echo base64_decode($msg); ?></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
    </table>
    </p>
    <?php } ?>
    <p>
      <label>Username<br>
      <input name="username" id="user_login" class="input" value="" size="20" tabindex="10" type="text">
      </label>
    </p>
    <p>
      <label>Password<br>
      <input name="password" id="user_pass" class="input" value="" size="20" tabindex="20" type="password">
      </label>
    </p>
    
    <p class="submit">
      <input name="SubmitButton" id="wp-submit" value="Log In" tabindex="100" type="submit">
      <input name="testcookie" value="1" type="hidden">
    </p>
  </form>
</div></td>
  </tr>
</table>
<script type="text/javascript">
try{document.getElementById('user_login').focus();}catch(e){}
</script>
</body>
</html>
