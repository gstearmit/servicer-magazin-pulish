<?php
//Khai bao namespace 
namespace Template\Controller;

//Load lớp AbstractActionController vào CONTROLLER
use Zend\Mvc\Controller\AbstractActionController;

//Load lớp ViewModel vào CONTROLLER
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	
    public function indexAction()
    {    	
   		
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

