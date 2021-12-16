<title><?php echo(isset($title) ? $title : '');?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="pragma" content="no-cache">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style type="text/css">
  @import url("<?php echo SERVER_ADMIN_PATH;?>styles/styles.css");
  @import url("<?php echo SERVER_ADMIN_PATH;?>styles/slidingdoors.css");
  @import url("<?php echo SERVER_ADMIN_PATH;?>styles/comp_img_styles.css");
</style>
<script type="text/javascript"
  src="<?php echo SERVER_ADMIN_PATH;?>js/jsconfig.js"></script>
<?php if ($currentFile == 'addedit_song' || $currentFile == "addedit_featured_artist") {?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<link rel="stylesheet" type="text/css"
  href="<?php echo SERVER_ADMIN_PATH;?>styles/jquery.tokenize.css" />
<script type="text/javascript"
  src="<?php echo SERVER_ADMIN_PATH;?>js/jquery.tokenize.js"></script>
<?php } else {?>
<script type="text/javascript"
  src="<?php echo SERVER_ADMIN_PATH;?>js/jquery-1.3.2.min.js"></script>
<?php }?>

<!--<script type="text/javascript" src="<?php echo SERVER_ADMIN_PATH;?>js/jquery-1.7.2.min.js">
</script>-->
<script type="text/javascript"
  src="<?php echo SERVER_ADMIN_PATH;?>js/jquery.form.js" language="javascript">
</script>
<script type="text/javascript"
  src="<?php echo SERVER_ADMIN_PATH;?>js/dropdowntabs.js" language="javascript">
</script>
<script type="text/javascript"
  src="<?php echo SERVER_ADMIN_PATH;?>js/myscript.js?iiia=<?php echo rand(111111, 999999);?>"
  language="javascript"></script>
<script type="text/javascript"
  src="<?php echo SERVER_ADMIN_PATH;?>js/ajaxfunctions.js"
  language="javascript"></script>
<script type="text/javascript"
  src="<?php echo SERVER_ADMIN_PATH;?>ckeditor/ckeditor.js"></script>
<!-- <script type="text/javascript"
  src="<?php echo SERVER_ADMIN_PATH;?>js/jquery.tokenize.js">
</script> -->