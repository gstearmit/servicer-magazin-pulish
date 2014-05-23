<?php

namespace Manastory\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Manastory\Model\Manastory;
use Manastory\Form\ManastoryForm;

use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
// check login

use ZfcUser\Service\User as UserService;
use ZfcUser\Options\UserControllerOptionsInterface;

use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;


class ManastoryController extends AbstractActionController {
    
    protected $manastoryTable;

    public function indexAction() {
//     	// check login
//     	if (!$this->zfcUserAuthentication()->hasIdentity()) {
//     		return $this->redirect()->toRoute('zfcuser/login');
//     	}else 
//     	{
    	
        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : Select::ORDER_DESCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $manastorys = $this->getManastoryTable()->fetchAll($select->order($order_by . ' ' . $order));
        $itemsPerPage = 10;        // is Number record/page

        $manastorys->current();
        $paginator = new Paginator(new paginatorIterator($manastorys));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(4);  // is number page want view

        return new ViewModel(array(
                    'order_by' => $order_by,
                    'order' => $order,
                    'page' => $page,
                    'paginatorstory' => $paginator,
                ));
    //	}//login
    	
    	
    }

    public function addAction() {
    	
        $form = new ManastoryForm(); // include Form Class
        $form->get('submit')->setAttribute('value', 'Add');
       
        $request = $this->getRequest();
       
        if ($request->isPost()) {
        	
            $manastory = new Manastory();

            $form->setInputFilter($manastory->getInputFilter());  // check validate
         
            $data = array_merge_recursive(
            		$this->getRequest()->getPost()->toArray(),
            		$this->getRequest()->getFiles()->toArray()
            );
           

           $form->setData($data);  // get all post
  
            if ($form->isValid()) {
            	
            	$size = new Size(array('min'=>2000000)); //minimum bytes filesize
            	 
            	$adapter = new \Zend\File\Transfer\Adapter\Http();
            	$adapter->setValidators(array($size), $data['imgkey']['size']);
            	$extension = new \Zend\Validator\File\Extension(array('extension' => array('gif', 'jpg', 'png')));
            	
            	if (!$adapter->isValid()){
            		
            		$dataError = $adapter->getMessages();
            	
            		$error = array();
            		foreach($dataError as $key=>$row)
            		{
            			$error[] = $row;
            		}
            		
            		$form->setMessages(array('imgkey'=>$error ));
            		//die;
            	} 
            	if ($adapter->isValid()) {
            	//	echo 'is valid';
            	
//             		var_dump(MZIMG_PATH);
//             		var_dump($data['imgkey']);
            		//die;
            		$adapter->setDestination(MZIMG_PATH);
            		if ($adapter->receive($data['imgkey']['name'])) {
            			$profile = new Manastory();
            			$profile->exchangeArray($form->getData());
//             		   echo 'Profile Name '.$profile->title.' upload '.$profile->imgkey;
//             			die;
            		}
            		
            	}
            	
            	
            	
                $manastory->dataArray($form->getData());
                $this->getManastoryTable()->saveManastory($manastory);
                // Redirect to list of manaStorys
                return $this->redirect()->toRoute('manastory');
                
            }else {
            	//echo('Magazine is Form Not Validate');
            	
            }
        }

        return array('form' => $form);
    }

    public function editAction() {
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('manastory', array('action' => 'add'));
        }
        $manastory = $this->getManastoryTable()->getManastory($id);
        
      
        $form = new ManastoryForm();
        $form->bind($manastory);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        
        if ($request->isPost()) {
        	
        	
        	$data = array_merge_recursive(
        			$this->getRequest()->getPost()->toArray(),
        			$this->getRequest()->getFiles()->toArray()
        	);
        	
//         	echo '<pre>';
//         	print_r($data);
//         	echo '</pre>';
        	 
        	
        	
            $form->setData($data);
            
            if ($form->isValid()) {
            	
        
            	$size = new Size(array('min'=>2000000)); //minimum bytes filesize
            	
            	$adapter = new \Zend\File\Transfer\Adapter\Http();
            	$adapter->setValidators(array($size), $data['imgkey']['size']);
            	$extension = new \Zend\Validator\File\Extension(array('extension' => array('gif', 'jpg', 'png')));
//             	if (!$adapter->isValid())
//             	{
//             		echo 'is not valid';
//             		die;
            		
//             		$dataError = $adapter->getMessages();
            			
//             		$error = array();
//             		foreach($dataError as $key=>$row)
//             		{
//             			$error[] = $row;
//             		}
            	
//             		$form->setMessages(array('imgkey'=>$error ));
//             		//die;
//             	}
            	if ($adapter->isValid()) 
            	{
//             			echo 'is valid';
//             			var_dump(MZIMG_PATH);
//             		    var_dump($data['imgkey']);
						//die;
            		
            		$adapter->setDestination(MZIMG_PATH);
            		if ($adapter->receive($data['imgkey']['name'])) {
            			$profile = new Manastory();
            			//						$profile->exchangeArray($form->getData());
            			//             		   echo 'Profile Name '.$profile->title.' upload '.$profile->imgkey;
            			//             			die;
            		}
            	
            	}
            	

            	$manastory2 = new Manastory();
            	$manastory2->dataPost($data);
 				$this->getManastoryTable()->saveManastory2($manastory2);

                // Redirect to list of manastorys
                return $this->redirect()->toRoute('manastory');
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
            return $this->redirect()->toRoute('manastory');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost()->get('id');
                $this->getManastoryTable()->deleteManastory($id);
            }

            // Redirect to list of manaStorys
            return $this->redirect()->toRoute('manastory');
        }

        return array(
            'id' => $id,
            'manastory' => $this->getManastoryTable()->getManastory($id)
        );
    }

    public function getManastoryTable() {
        if (!$this->manastoryTable) {
            $sm = $this->getServiceLocator();
            $this->manastoryTable = $sm->get('Manastory\Model\ManastoryTable');
        }
        return $this->manastoryTable;
    }

}
