<?php
namespace News\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use News\Model\News;
use News\Form\NewsForm;
use News\Form\MagazineForm as FromClass;
use News\Form\NewsSearchForm as SearchFromNews ;


use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

use ZfcUser\Service\User as UserService;
use ZfcUser\Options\UserControllerOptionsInterface;

use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;

class NewsController extends AbstractActionController {

    protected $newsTable;

    public function searchAction()
    {
    
    	$request = $this->getRequest();
    
    	$url = 'index';
    
    	if ($request->isPost()) {
    		$formdata    = (array) $request->getPost();
    		$search_data = array();
    		foreach ($formdata as $key => $value) {
    			if ($key != 'submit') {
    				if (!empty($value)) {
    					$search_data[$key] = $value;
    				}
    			}
    		}
    		if (!empty($search_data)) {
    			$search_by = json_encode($search_data);
    			$url .= '/search_by/' . $search_by;
    		}
    	}
    	$this->redirect()->toUrl($url);
    }
    
    
    public function indexAction() {
    	// check login
//     	if (!$this->zfcUserAuthentication()->hasIdentity()) {
//     		return $this->redirect()->toRoute('zfcuser/login');
//     	}
    	
    	//SearchFromnews
    	$searchform = new SearchFromNews();
    	$searchform->get('submit')->setValue('Search');
    	
        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ?  $this->params()->fromRoute('order') : Select::ORDER_DESCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
        $search_by = $this->params()->fromRoute('search_by') ? $this->params()->fromRoute('search_by') : '';
        $select->order($order_by . ' ' . $order);
        
        $where    = new \Zend\Db\Sql\Where();
        $formdata = array();
        if (!empty($search_by)) {
        	$formdata = (array) json_decode($search_by);
        	if (!empty($formdata['description'])) {
        		$where->addPredicate(
        				new \Zend\Db\Sql\Predicate\Like('description', '%' . $formdata['description'] . '%')
        		);
        	}
        	if (!empty($formdata['title'])) {
        		$where->addPredicate(
        				new \Zend\Db\Sql\Predicate\Like('title', '%' . $formdata['title'] . '%')
        		);
        	}
        
        }
        if (!empty($where)) {
        	$select->where($where);
        }
        
        $newss = $this->getNewsTable()->fetchAll($select);
       
        
        $totalRecord  = $newss->count();
        $itemsPerPage = 10;        // is Number record/page
        $newss->current();
        $paginator = new Paginator(new paginatorIterator($newss));
        $paginator->setCurrentPageNumber($page)
                  ->setItemCountPerPage($itemsPerPage)
                  ->setPageRange(4);  // is number page want view

        return new ViewModel(array(
        		    'search_by'  => $search_by,
                    'order_by' => $order_by,
                    'order' => $order,
                    'page' => $page,
                    'paginatorimg' => $paginator,
	        		'pageAction' => 'news',
	        		'form'       => $searchform,
	        		'totalRecord' => $totalRecord,
        		   
                ));
    }
    
    public function pationAction() {
    	// check login
    	//     	if (!$this->zfcUserAuthentication()->hasIdentity()) {
    	//     		return $this->redirect()->toRoute('zfcuser/login');
    	//     	}
    		 
    	 
    	$select = new Select();
    
    	$order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
    	$order = $this->params()->fromRoute('order') ?  $this->params()->fromRoute('order') : Select::ORDER_DESCENDING;
    	$page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
    
    	// $newss = $this->getNewsTable()->fetchAll($select->order($order_by . ' ' . $order));
    	$newss = $this->getNewsTable()->fetchAllJoih($select->order($order_by . ' ' . $order));
    
    
    	//   $itemsPerPage = 10;        // is Number record/page
    	//  $newss->current();
    	//         $paginator = new Paginator(new paginatorIterator($newss));
    	//         $paginator->setCurrentPageNumber($page)
    	//                 ->setItemCountPerPage($itemsPerPage)
    	//                 ->setPageRange(4);  // is number page want view
    
    	return new ViewModel(array(
    			'order_by' => $order_by,
    			'order' => $order,
    			'page' => $page,
    			//'paginatorimg' => $paginator,
    			'paginatorimg' =>$newss,
    	));
    }

    public function addAction() {

    	$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    
        $form = new NewsForm($dbAdapter); // include Form Class
       
        $form->get('submit')->setAttribute('value', 'Add');
       
        $request = $this->getRequest();
       
        if ($request->isPost()) {
        	
            $news = new News();

            $form->setInputFilter($news->getInputFilter());  // check validate
            
            $data = array_merge_recursive(
            		$this->getRequest()->getPost()->toArray(),
            		$this->getRequest()->getFiles()->toArray()
            );
            

            
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
            	

            		
            		$form->setMessages(array('img'=>$error ));
            		//die;
            	}
            	if ($adapter->isValid()) {

            		$adapter->setDestination(MZIMG_PATH);
            		if ($adapter->receive($data['img']['name'])) {
            			$profile = new News();
            			
            		}
            	
            	}
            	
                $news->dataArray($form->getData());

                $this->getNewsTable()->saveNews($news);
                // Redirect to list of Newss
                return $this->redirect()->toRoute('news');
            }
        }

        return array(
        		'form' => $form,
        		
                    );
    }
    
    
    
    
    public function adddetailAction() {
    	
    	$id = (int)$this->params ()->fromRoute ( 'id', 0 );
//     	if ($id == 0 ) {
//     		die('Oopp Error !');
//     	}
    	
    	$newsArray  = $this->getNewsTable ()->fetchAllDetailNews ($id);
    	
    	
    	$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    
    	$form = new FromClass($dbAdapter,$id); // include Form Class
    	 
    	$form->get('submit')->setAttribute('value', 'Add');
    	 
    	$request = $this->getRequest();
    	 
    	if ($request->isPost()) {
    	 
    	$news = new News();
    
    	$form->setInputFilter($news->getInputFilter());  // check validate
    
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
    		$profile = new News();
    		$profile->exchangeArray($form->getData());
    		//             		   echo 'Profile Name '.$profile->title.' upload '.$profile->imgkey;
    		//             			die;
    	}
    		 
    	}
    	 
    	$news->dataArray($form->getData());
    
    		//                 var_dump($news);
    		//                 die();
    
    		$this->getNewsTable()->saveNews($news);
    		// Redirect to list of newss
    		return $this->redirect()->toRoute('news');
    	}
    	}
    
    	return new ViewModel ( array (
    			'paginatorimg' => $newsArray,
    			'form' => $form,
    			'id' => $id,
    	) );
  	}
    
   
  
  
    public function editAction() {
    	
    	$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    	
        $id = (int) $this->params('id');
        
        if (!$id) {
            return $this->redirect()->toRoute('news', array('action' => 'add'));
        }
        
        $news = $this->getNewsTable()->getNews($id);

       // $form = new NewsForm($dbAdapter);
        $form = new FromClass($dbAdapter,$id);
        
        $form->bind($news);
        
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
        	
        	$data = array_merge_recursive(
        			$this->getRequest()->getPost()->toArray(),
        			$this->getRequest()->getFiles()->toArray()
        	);
        	
            $form->setData($data);
            
            if (!$form->isValid()) {
            	
            	$size = new Size(array('min'=>2000000)); //minimum bytes filesize
            	 
            	$adapter = new \Zend\File\Transfer\Adapter\Http();
            	$adapter->setValidators(array($size), $data['img']['size']);
            	$extension = new \Zend\Validator\File\Extension(array('extension' => array('gif', 'jpg', 'png')));
            	
            			if ($adapter->isValid())
            			{
            				
            	
            				$adapter->setDestination(MZIMG_PATH);
            				if ($adapter->receive($data['img']['name'])) {
            					$profile = new News();
            					
            				}
            				 
            			}
            			 
            	
            	$news2 = new News();
            	$news2->dataPost($data);
                $this->getNewsTable()->saveNews($news2);

                // Redirect to list of Newss
                return $this->redirect()->toRoute('news');
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
            return $this->redirect()->toRoute('news');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost()->get('id');
                $this->getNewsTable()->deleteNews($id);
            }

            // Redirect to list of Newss
            return $this->redirect()->toRoute('news');
        }

        return array(
            'id' => $id,
            'news' => $this->getNewsTable()->getNews($id)
        );
    }
    
    public function viewdetailAction() {
    	
    	$id = (int) $this->params('id');
    
    	if (!$id) {
    		return $this->redirect()->toRoute('news', array('action' => 'add'));
    	}
    
    	//$news = $this->getNewsTable()->getNews($id);
    	$news = $this->getNewsTable()->fetchById($id);
//         echo 'controller';
//         var_dump($news);
//         die;
    	
    
    	return array(
    			'id' => $id,
    			'news' => $news,
    	);
    }

    public function getNewsTable() {
        if (!$this->newsTable) {
            $sm = $this->getServiceLocator();
            $this->newsTable = $sm->get('News\Model\NewsTable');
        }
        return $this->newsTable;
    }

}
