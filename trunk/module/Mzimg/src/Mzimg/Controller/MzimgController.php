<?php

namespace Mzimg\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Mzimg\Model\Mzimg;
use Mzimg\Form\MzimgForm;
use Mzimg\Form\MagazineForm;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

use ZfcUser\Service\User as UserService;
use ZfcUser\Options\UserControllerOptionsInterface;

use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;

class MzimgController extends AbstractActionController {

    protected $mzimgTable;

    public function indexAction() {
    	// check login
    	if (!$this->zfcUserAuthentication()->hasIdentity()) {
    		return $this->redirect()->toRoute('zfcuser/login');
    	}
    	
    	
        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_DESCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $mzimgs = $this->getMzimgTable()->fetchAll($select->order($order_by . ' ' . $order));
        $itemsPerPage = 10;        // is Number record/page

        $mzimgs->current();
        $paginator = new Paginator(new paginatorIterator($mzimgs));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(4);  // is number page want view

        return new ViewModel(array(
                    'order_by' => $order_by,
                    'order' => $order,
                    'page' => $page,
                    'paginatorimg' => $paginator,
                ));
    }

    public function addAction() {
//     	$idmz =  $this->params ()->fromRoute ( 'idmz', 0 );
//     	echo 'idmz'; var_dump($idmz);
    	//
    	$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    
        $form = new MzimgForm($dbAdapter); // include Form Class
       
        $form->get('submit')->setAttribute('value', 'Add');
       
        $request = $this->getRequest();
       
        if ($request->isPost()) {
        	
            $mzimg = new Mzimg();

            $form->setInputFilter($mzimg->getInputFilter());  // check validate
            
            $data = array_merge_recursive(
            		$this->getRequest()->getPost()->toArray(),
            		$this->getRequest()->getFiles()->toArray()
            );
            
//                     	echo '<pre>';
//                     	print_r($data);
//                     	echo '</pre>';
            
            
            $form->setData($data);  // get all post
           
            
            if ($form->isValid()) {
            	$size = new Size(array('min'=>2000000)); //minimum bytes filesize
            	
            	$adapter = new \Zend\File\Transfer\Adapter\Http();
            	$adapter->setValidators(array($size), $data['img']['size']);
            	$extension = new \Zend\Validator\File\Extension(array('extension' => array('gif', 'jpg', 'png')));
            	 
            	if (!$adapter->isValid()){
            	    
            		echo 'is not valid';
            		
            		$dataError = $adapter->getMessages();
            		 
            		$error = array();
            		foreach($dataError as $key=>$row)
            		{
            			$error[] = $row;
            		}
            	
//             		var_dump($error);
//             		die;
            		
            		$form->setMessages(array('img'=>$error ));
            		//die;
            	}
            	if ($adapter->isValid()) {
//             			echo 'is valid';
            		 
//             		            		var_dump(MZIMG_PATH);
//             		            		var_dump($data['img']);
//             		die;
            		$adapter->setDestination(MZIMG_PATH);
            		if ($adapter->receive($data['img']['name'])) {
            			$profile = new Mzimg();
            			$profile->exchangeArray($form->getData());
            			//             		   echo 'Profile Name '.$profile->title.' upload '.$profile->imgkey;
            			//             			die;
            		}
            	
            	}
            	
                $mzimg->dataArray($form->getData());
                
//                 var_dump($mzimg);
//                 die();
                
                $this->getMzimgTable()->saveMzimg($mzimg);
                // Redirect to list of Mzimgs
                return $this->redirect()->toRoute('mzimg');
            }
        }

        return array(
        		'form' => $form,
        		//'idmz'=>$idmz
                    );
    }
    
    
    
    
    public function adddetailAction() {
    	
    	$id = $this->params ()->fromRoute ( 'id', 0 );
    	$mzimgArray  = $this->getMzimgTable ()->fetchAllDetailMzimg ($id);
    	
    	
    	$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    
    	$form = new MzimgForm($dbAdapter); // include Form Class
    	 
    	$form->get('submit')->setAttribute('value', 'Add');
    	 
    	$request = $this->getRequest();
    	 
    	if ($request->isPost()) {
    	 
    	$mzimg = new Mzimg();
    
    	$form->setInputFilter($mzimg->getInputFilter());  // check validate
    
    	$data = array_merge_recursive(
    			$this->getRequest()->getPost()->toArray(),
    	$this->getRequest()->getFiles()->toArray()
    	);
    
    	//                     	echo '<pre>';
    	//                     	print_r($data);
    	//                     	echo '</pre>';
    
    
    	$form->setData($data);  // get all post
    	 
    
    	if (!$form->isValid()) {
    	$size = new Size(array('min'=>2000000)); //minimum bytes filesize
    	 
    	$adapter = new \Zend\File\Transfer\Adapter\Http();
    	$adapter->setValidators(array($size), $data['img']['size']);
    	$extension = new \Zend\Validator\File\Extension(array('extension' => array('gif', 'jpg', 'png')));
    
    	if (!$adapter->isValid()){
    	 
    	echo 'is not valid';
    
    	$dataError = $adapter->getMessages();
    	 
    	$error = array();
    	foreach($dataError as $key=>$row)
    	{
    	$error[] = $row;
    	}
    	 
    	//             		var_dump($error);
    	//             		die;
    
    	$form->setMessages(array('img'=>$error ));
    	//die;
    	}
    	if ($adapter->isValid()) {
    		//             			echo 'is valid';
        
//             		            		var_dump(MZIMG_PATH);
    //             		            		var_dump($data['img']);
    //             		die;
    		$adapter->setDestination(MZIMG_PATH);
    		if ($adapter->receive($data['img']['name'])) {
    		$profile = new Mzimg();
    		$profile->exchangeArray($form->getData());
    		//             		   echo 'Profile Name '.$profile->title.' upload '.$profile->imgkey;
    		//             			die;
    	}
    		 
    	}
    	 
    	$mzimg->dataArray($form->getData());
    
    		//                 var_dump($mzimg);
    		//                 die();
    
    		$this->getMzimgTable()->saveMzimg($mzimg);
    		// Redirect to list of Mzimgs
    		return $this->redirect()->toRoute('mzimg');
    	}
    	}
    
    	return new ViewModel ( array (
    			'paginatorimg' => $mzimgArray,
    			'form' => $form,
    			'id' => $id,
    	) );
  	}
    
   
  
  
    public function editAction() {
    	$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('mzimg', array('action' => 'add'));
        }
        $mzimg = $this->getMzimgTable()->getMzimg($id);

        $form = new MzimgForm($dbAdapter);
        $form->bind($mzimg);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
        	
        	$data = array_merge_recursive(
        			$this->getRequest()->getPost()->toArray(),
        			$this->getRequest()->getFiles()->toArray()
        	);
        	
            $form->setData($data);
            
            if ($form->isValid()) {
            	
            	$size = new Size(array('min'=>2000000)); //minimum bytes filesize
            	 
            	$adapter = new \Zend\File\Transfer\Adapter\Http();
            	$adapter->setValidators(array($size), $data['img']['size']);
            	$extension = new \Zend\Validator\File\Extension(array('extension' => array('gif', 'jpg', 'png')));
            	
            			if ($adapter->isValid())
            			{
            				
            	
            				$adapter->setDestination(MZIMG_PATH);
            				if ($adapter->receive($data['img']['name'])) {
            					$profile = new Mzimg();
            					
            				}
            				 
            			}
            			 
            	
            	$mzimg2 = new Mzimg();
            	$mzimg2->dataPost($data);
                $this->getMzimgTable()->saveMzimg($mzimg2);

                // Redirect to list of Mzimgs
                return $this->redirect()->toRoute('mzimg');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('mzimg');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost()->get('id');
                $this->getMzimgTable()->deleteMzimg($id);
            }

            // Redirect to list of Mzimgs
            return $this->redirect()->toRoute('mzimg');
        }

        return array(
            'id' => $id,
            'mzimg' => $this->getMzimgTable()->getMzimg($id)
        );
    }

    public function getMzimgTable() {
        if (!$this->mzimgTable) {
            $sm = $this->getServiceLocator();
            $this->mzimgTable = $sm->get('Mzimg\Model\MzimgTable');
        }
        return $this->mzimgTable;
    }

}
