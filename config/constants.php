<?php
define('TABLE_PRE','tbl_');
/*
error_reporting(E_ALL);
ini_set('display_errors', 1);*/
//================================================================

// $serverpath	=	"https://".$_SERVER['HTTP_HOST']."/admin/";		//	set site server path
// define('SERVER_ADMIN_PATH', $serverpath);									   //	save path in constant value
//================================================================

//================================================================
 	//	set site server path
define('SERVER_ROOTPATH', 'http://127.0.0.1:8000/');							   //	save path in constant value
define('SERVER_ADMIN_PATH', 'http://127.0.0.1:8000/admin/');							   //	save path in constant value
define('search', 'search');							   //	save path in constant value
//================================================================

//================================================================

// define('COOKIE_FREE_ROOTPATH',  "static/");							   //	save path in constant value
define('COOKIE_FREE_ROOTPATH',  "http://127.0.0.1:8000/");							   //	save path in constant value
//================================================================

define('USER_SESSION_ARRAY', "USER_SESSION_ARRAY");				
define('main_search', "main_search");				


//================================================================
define('PAGE_TITLE', "Music site");					// Setting Page Title
//================================================================

define('SQL_INJECTION_SECURITY_ENABLED', true);

// SITE'S IMAGE PATH //
define('SERVER_IMAGES_PATH', SERVER_ROOTPATH.'assets/images/');

define('MAX_CATEGORY_IMAGE_WIDTH', 75);

// do we need to limit the product image width?
// setting this value to 'true' is recommended
define('LIMIT_PRODUCT_WIDTH',     true);

// maximum width for all product image
define('MAX_PRODUCT_IMAGE_WIDTH', 300);

// the width for product thumbnail
define('THUMBNAIL_WIDTH', 95);

 