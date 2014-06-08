<?php	
	
	
	chdir(dirname(__DIR__));

	define('APPLICATION_PATH', realpath(dirname(__DIR__)));	
	

	define('LIBRARY_PATH', realpath(APPLICATION_PATH . '/library/'));
	define('PUBLIC_PATH'	, realpath(APPLICATION_PATH . '/public'));
	define('TEMPLATE_PATH'	, realpath(PUBLIC_PATH . '/templates'));
	define('FILES_PATH'	, realpath(PUBLIC_PATH . '/files'));
	define('MZIMG_PATH'	, realpath(PUBLIC_PATH . '/images'));
	
