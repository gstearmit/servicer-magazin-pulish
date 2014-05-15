<?php
namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

// Add these import statements:
use Admin\Model\UserTable;
use Admin\Model\User;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module
{
	public $tmp;
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    // Add this method:
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					// DB
    					'UserTableGateway' => function ($sm) {
    						//Goi doi tuong ket noi voi Database
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					
    						//Goi doi tuong giup chung ta chuyen 1 doi tuong thanh mot mang
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new User());
    						//$resultSetPrototype = null;
    						//Dua cac gia tri 'users', $dbAdapter, $resultSetPrototype
    						//vao doi tuong Zend\Db\TableGateway
    						return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
    					},
    					'Admin\Model\UserTable' =>  function($sm) {
    						//Luc nao UserTableGateway la mot doi tuong cua Zend\Db\TableGateway
    						//chua cac gia tri ket noi den database va bang chung ta muon truy van
    						$tableGateway = $sm->get('UserTableGateway');
    						
    						//Truyen doi tuong Zend\Db\TableGateway vao trong ham __construct()
    						//cua doi tuong Admin\Model\UserTable
    						$table = new UserTable($tableGateway);
    						return $table;
    					},
    					
    						
    			),
    	);
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

    
    
}
