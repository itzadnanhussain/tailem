<?php
	// Make sure you're using correct path here
	include_once 'ckeditor.php';
	
	if(isset($_POST['test'])){
		
		echo '<pre>';
		print_r($_POST);
		exit;
		
	}
	
 
 ?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="" method="post">
<?php  
	$ckeditor = new CKEditor();
	$ckeditor->basePath = '';
	$ckeditor->config['filebrowserBrowseUrl'] = '/ckfinder/ckfinder.html';
	$ckeditor->config['filebrowserImageBrowseUrl'] = '/evs/usmananwer/ckeditor/ckfinder/ckfinder.html?type=Images';
	$ckeditor->config['filebrowserFlashBrowseUrl'] = '/evs/usmananwer/ckeditor/ckfinder/ckfinder.html?type=Flash';
	$ckeditor->editor('editor1','This is a test message');
?>
<input type="submit" name="test" id="test" value="Submit" />
</form>
</body>
</html>
