<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use  Admin\Form\UserForm;

class IndexController extends AbstractActionController
{

	public function indexAction()
    {
    	echo '<br />' . __METHOD__;    	
    	$userTable = $this->getServiceLocator()->get('Admin\Model\UserTable');  
    	return new ViewModel (array('users' => $userTable->fetchAll()));
    	
    }
 
}
