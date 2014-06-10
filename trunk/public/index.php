<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
define('ROOT_PATH', dirname(dirname(__DIR__)));
define('PROFILE_IMAGE_PATH', '/servicer_magazin_pulish/public/images/profile');
define('PATH_ZIP', '/servicer_magazin_pulish/public/images/');
define('UPLOAD_PATH_IMG', '/servicer_magazin_pulish/public/images/');

include 'define.php'; 
chdir(dirname(__DIR__));

// Setup autoloading
include 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(include 'config/application.config.php')->run()->send();

//define('REQUEST_MICROTIME', microtime(true));