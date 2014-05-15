<?php	
	
	//Đường dẫn đến thư mục chứa thư mục hiện thời
	chdir(dirname(__DIR__));
	
	//Hằng số lưu đường dẫn thư mục ứng dụng
	//Hằng số lưu thông tin đường dẫn thư mục
	define('APPLICATION_PATH', realpath(dirname(__DIR__)));	
	
	//Hằng số lưu đường dẫn thư mục chứa thư viên ZF2
	define('LIBRARY_PATH', realpath(APPLICATION_PATH . '/library/'));
	define('PUBLIC_PATH'	, realpath(APPLICATION_PATH . '/public'));
	define('TEMPLATE_PATH'	, realpath(PUBLIC_PATH . '/templates'));
	define('FILES_PATH'	, realpath(PUBLIC_PATH . '/files'));
	define('MZIMG_PATH'	, realpath(PUBLIC_PATH . '/images'));
