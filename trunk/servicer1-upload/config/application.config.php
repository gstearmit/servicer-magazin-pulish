<?php
defined('SERVER_ENVIRONMENT') ||define('SERVER_ENVIRONMENT','service.topprinter.org');
defined('WEB_PATH') || define('WEB_PATH','http://service.topprinter.org');
defined('WEB_PATH_IMG') || define('WEB_PATH_IMG', WEB_PATH.'/images');

return array(
    'modules' => array(
        'Application',
        'Album',
    	'AlbumRest',
    	'Booknews',
    	'MagazineRest',
		'Magazinepublish',
		'MagazinePublishRest',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);