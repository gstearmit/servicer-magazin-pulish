<?php
defined('SERVER_ENVIRONMENT') ||define('SERVER_ENVIRONMENT','servicer_magazin_pulish.localhost:1913'); //servicer_magazin_pulish.localhost:1910
defined('WEB_PATH') || define('WEB_PATH','http://servicer_magazin_pulish.localhost:1913');//http://192.168.0.33:1910
defined('WEB_PATH_IMG') || define('WEB_PATH_IMG', WEB_PATH.'/images');


return array(
    'modules' => array(
        'Application',
        'Album',
    	'AlbumRest',
    	'Booknews',
		'Magazinepublish',
		'MagazinePublishRest',
    	'MagazineRest',
		'Mzimg',
    	'Manastory',
		'Storydetail',
		'ManastoryRest',
		'MagastoryRestfull',
		'Catalogue',
		'Magazinevietnam',
		'Mgvndetail',
		'Magazinevnrest',
		'Magazinevnrestfull',
		'Librarybooks',
		'Librarydetail',
		//'ZfcUser',
		//'ZfcBase',
		'ZfcAdmin',
		'ZfcFacebook',
		//'ZfcAcl',
		//'BjyAuthorize',
		'FileUpload',
		'Uploadfilemutil',
		//'Test',
		//'ZendDeveloperTools',
		//'ZF2AuthAcl',
		//'DoctrineModule',
        //'DoctrineORMModule'
		//'ZfcUserList',
		//'ZfcRbac',
		//'ZfcUserDoctrineORM',
		'Admin',
		'Template',
		
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
