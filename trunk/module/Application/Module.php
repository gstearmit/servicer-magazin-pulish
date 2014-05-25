<?php

namespace Application;

use Application\Model\Acl;
use Zend\Mvc\ModuleRouteListener;

class Module
{
    public function onBootstrap($e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        		
        );
    }
    
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Acl' => function($sm)
    					{
    						$acl = new Acl();
    						return $acl;
    					},
    			),
    	);
    }

}