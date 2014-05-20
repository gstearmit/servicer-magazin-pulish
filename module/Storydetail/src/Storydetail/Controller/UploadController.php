<?php
namespace Storydetail\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Admin\Form\UploadForm;

class UploadController extends AbstractActionController
{

	public function indexAction()
    {

    	$form = new UploadForm();
    	$view = new ViewModel(array('form'=>$form));
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		
	    	 $files =  $request->getFiles()->toArray();
	    	 $fileName = $files['picture']['name'];
	    	 
	    	 $uploadObj = new \Zend\File\Transfer\Adapter\Http(); 
		     $uploadObj->setDestination(MZIMG_PATH);
		   
		   	 if($uploadObj->receive($fileName)) {
		          echo "<br>Upload success";
		     } 
	    
    	}
    	 
    	return $view;
    }
    
    public function abcAction(){
    	
    	$form = new UploadForm();
    	$view = new ViewModel(array('form'=>$form));
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		echo 'Tap tin vua upload len server la: ';
    		echo $form->upload($request->getFiles()->toArray(),MZIMG_PATH);
    	}
    	
    	return $view;
    }
    

    public function multiAction(){
    	 
    	$form = new \Storydetail\Form\MultiUploadForm();
    	$view = new ViewModel(array('form'=>$form));
    	 
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		
    	 	echo 'Tap tin vua upload len server la: ';
    		$files = $form->upload($request->getFiles()->toArray(),FILES_PATH); 
    		
    		echo "<pre>";
    		print_r($files);
    		echo "</pre>";
    	}
    	 
    	return $view;
    }
    

}
