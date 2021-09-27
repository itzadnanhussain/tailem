<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Editor</title>
</head>
    <?php
    include_once 'ckeditor/ckeditor.php';  
    $etemp_data = stripslashes(html_entity_decode('Here you write the text inside the editor or use a variable that will display inside the editor'));
    $ckeditor = new CKEditor();
    $ckeditor->basePath = '';
    $ckeditor->config['filebrowserBrowseUrl'] = '/ckfinder/ckfinder.html';
    $ckeditor->config['filebrowserImageBrowseUrl'] =	
    'ckeditor/ckfinder/ckfinder.html?type=Images';
    $ckeditor->config['filebrowserFlashBrowseUrl'] = 
    'ckeditor/ckfinder/ckfinder.html?type=Flash';
    $ckeditor->editor('etemp_data',$etemp_data);
    ?>
<body>
</body>
</html>
