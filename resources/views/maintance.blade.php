<?php
 error_reporting(0);
//  phpinfo();
//  die;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Tailem.com is an online community of music lovers. Rate, review and share your thoughts on all of your favorite songs">
<meta name="keywords" content="Tailem.com, online community of music lovers,favorite songs">

<title>Tailem.com</title>
<?php //include_once("common/top_script_files.php");?>
</head>
<body>
<header>
	<div class="page-header">
    	<div class="top_bar clearfix">
        	<div class="container">
            	<div class="row">
                <?php 
						$setting_qry = "select desktop_version_logo from tbl_general_setting where setting_id='1'";
						$setting_arr	=	\App\Models\Songs::GetRawDataAdmin($setting_qry);
						$desktop_version_logo	= $setting_arr['desktop_version_logo'];
				?>
                          	
                </div>    
            </div>
        </div>
        <div class="container">
        	<div class="row">
               <div class="col-sm-3">
               		<div class="logo"><a href="<?php echo SERVER_ROOTPATH;?>"><img src="<?php echo SERVER_ROOTPATH;?>assets/phpthumb/phpThumb.php?src=<?php echo SERVER_ROOTPATH;?>site_upload/general_setting/<?php echo $desktop_version_logo;?>&w=231&h=42&zc=1" class="img-responsive"></a></div>
               </div>
               <div class="col-sm-3">&nbsp;</div>
               <div class="col-sm-6">
               		
               </div>
            </div>   
			 <div class="clear pad-5"></div>
			<div class="row">
            <div class="col-lg-12">
                <img src="<?php echo SERVER_ROOTPATH;?>assets/images/website_maintenance_banner.jpg">
            </div>
        </div>         
        </div>        
    </div>
    
</header>
</body>
</html>
