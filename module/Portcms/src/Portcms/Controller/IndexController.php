<?php
namespace Portcms\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	
    public function indexAction()
    {    
    	//echo 'Hoang OPhcu';die;	
   		
    	$this->layout('layout/home');
    	return new ViewModel(array('action'=>'index'));
    }
    
    public function aboutAction(){	    	
    
    	$this->layout('layout/home');
    }
    
    public function contactAction(){
    	
    	$this->layout('layout/home');
    }
    
    public function hairstyleAction(){    
    
    	$this->layout('layout/home');
    }
    
    public function newsAction(){    
   
    	$this->layout('layout/home');
    }
}

