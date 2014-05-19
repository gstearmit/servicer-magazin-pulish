<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Model\Acl;
//use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class IndexController extends AbstractActionController
{
// 	public function _getAcl()
// 	{
// 		if(!$this->_acl)
// 		{
// 			$this->_acl = $this->getServiceLocator()->get("Acl");
// 		}
// 		return $this->_acl;
// 	}
	
	 
	
    public function indexAction()
    {
//     	$quyen = "Guest";//se dc lay khi nguoi dung dang nhap
//     	if(!$this->_getAcl()->isAllowed($quyen,null,"index_index"))
//     	{
//     		echo "ban khong co quyen truy cap action nay";
//     	}
//     	else
//     	{
//     		echo "ban co quyen de truy cap vao action nay";
//     	}
    	
        return new ViewModel();
    }
    
 
    
    public function newAction()
    {
    	$quyen = "Guest";//se dc lay khi nguoi dung dang nhap
    	if(!$this->_getAcl()->isAllowed($quyen,null,"index_new"))
    	{
    		echo "ban khng dc phep truy cap vao action nay";
    	}
    }
}
