<?php	
	
	
	chdir(dirname(__DIR__));

	define('APPLICATION_PATH', realpath(dirname(__DIR__)));	
	

	define('LIBRARY_PATH', realpath(APPLICATION_PATH . '/library/'));
	define('PUBLIC_PATH'	, realpath(APPLICATION_PATH . '/public'));
	define('TEMPLATE_PATH'	, realpath(PUBLIC_PATH . '/templates'));
	define('Editorapp_PATH'	, realpath(PUBLIC_PATH . '/editorapp'));
	define('Appeditor_PATH'	, realpath(PUBLIC_PATH . '/appeditor'));
	define('PORTCMS_PATH'	, realpath(PUBLIC_PATH . '/portcms'));
	define('TEMPLATE_ISSUS'	, realpath(PUBLIC_PATH . '/Page_Bottom_Issus'));
	define('DIR_UPLOAD_NEW'	, realpath(PUBLIC_PATH.'/uploadnews'));
	
	//default.png
	define('FILES_PATH'	, realpath(PUBLIC_PATH . '/files'));
	define('MZIMG_PATH'	, realpath(PUBLIC_PATH . '/images'));
	
