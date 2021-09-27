<?php
error_reporting(0);
//================================================================
$serverpath	=	"http://".$_SERVER['HTTP_HOST']."/Admin-Cp/";		//	set site server path
define(SERVER_ADMIN_PATH, $serverpath);									   //	save path in constant value
//================================================================
$serverpathroot	=	"http://".$_SERVER['HTTP_HOST']."/";	//	set site server path
define(SERVER_ROOTPATH, $serverpathroot);							   //	save path in constant value
//================================================================

//================================================================
define(PAGE_TITLE, "Tailem.com");					// Setting Page Title
//================================================================
define(SQL_INJECTION_SECURITY_ENABLED, true);

// SITE'S IMAGE PATH //
define(SERVER_IMAGES_PATH, SERVER_ROOTPATH.'images/');
define(ADMIN_TITLE, "Tailem.com Admin Control Panel");					// Setting Admin Page Title
define(SITE_TITLE, "Tailem.com");	

$memcache = new Memcache;
$memcache->connect('localhost', 1337) or die ("Could not connect");
define(MEMCACHE_EXPIRE_TIME,2400);
define(MEMCACHE_IS_ENABALED,true);



?>