<?php

namespace Magazinepublish\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Magazinepublish\Model\Magazinepublish;
use Magazinepublish\Form\MagazinepublishForm;
use Magazinepublish\Form\MagazineForm;
use Magazinepublish\Form\MagazinepublishSearchForm as SearchFromMagazinepublish ;

use Mzimg\Model\Mzimg;

use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
// check login
use ZfcUser\Service\User as UserService;
use ZfcUser\Options\UserControllerOptionsInterface;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;
use Mzimg\Model\MzimgTable;

class MagazinepublishController extends AbstractActionController {
	protected $magazinepublishTable;
	
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
// 		if (! $this->zfcUserAuthentication ()->hasIdentity ()) {
// 			return $this->redirect ()->toRoute ( 'zfcuser/login' );
// 		} else {
			
			$searchform = new SearchFromMagazinepublish();
			$searchform->get('submit')->setValue('Search');
			
			$select = new Select ();
			
			$order_by = $this->params ()->fromRoute ( 'order_by' ) ? $this->params ()->fromRoute ( 'order_by' ) : 'id';
			$order = $this->params ()->fromRoute ( 'order' ) ? $this->params ()->fromRoute ( 'order' ) : Select::ORDER_DESCENDING;
			$page = $this->params ()->fromRoute ( 'page' ) ? ( int ) $this->params ()->fromRoute ( 'page' ) : 1;
			$search_by = $this->params()->fromRoute('search_by') ? $this->params()->fromRoute('search_by') : '';
			$select->order($order_by . ' ' . $order);
			$where    = new \Zend\Db\Sql\Where();
			$formdata = array();
			if (!empty($search_by)) {
				$formdata = (array) json_decode($search_by);
				if (!empty($formdata['descriptionkey'])) {
					$where->addPredicate(
							new \Zend\Db\Sql\Predicate\Like('descriptionkey', '%' . $formdata['descriptionkey'] . '%')
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
			
			$magazinepublishs = $this->getMagazinepublishTable ()->fetchAll ( $select) ;
			$itemsPerPage = 10; // is Number record/page
			$totalRecord  = $magazinepublishs->count();
			$magazinepublishs->current ();
			$paginator = new Paginator ( new paginatorIterator ( $magazinepublishs ) );
			$paginator->setCurrentPageNumber ( $page )->setItemCountPerPage ( $itemsPerPage )->setPageRange ( 4 ); // is number page want view
			
			return new ViewModel ( array (
					'search_by'  => $search_by,
					'order_by' => $order_by,
					'order_by' => $order_by,
					'order' => $order,
					'page' => $page,
					'paginator' => $paginator ,
					'pageAction' => 'magazinepublishs ',
					'form'       => $searchform,
					'totalRecord' => $totalRecord,
			) );
		//} // login
	}
	public function addAction() {
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$form = new MagazinepublishForm ($dbAdapter); // include Form Class
		$form->get ( 'submit' )->setAttribute ( 'value', 'Add' );
		
		$request = $this->getRequest ();
		
		if ($request->isPost ()) {
			
			$magazinepublish = new Magazinepublish ();
			
			$form->setInputFilter ( $magazinepublish->getInputFilter () ); // check validate
			
			$data = array_merge_recursive ( $this->getRequest ()->getPost ()->toArray (), $this->getRequest ()->getFiles ()->toArray () );
			
			$form->setData ( $data ); // get all post
			
			echo 'validate ';
			var_dump($form->isValid());
			echo '<pre>';
			print_r($form->getData());
			echo '</pre>';
			die;
			
			if ($form->isValid ()) {
				
				$size = new Size ( array (
						'min' => 2000000 
				) ); // minimum bytes filesize
				
				$adapter = new \Zend\File\Transfer\Adapter\Http ();
				$adapter->setValidators ( array (
						$size 
				), $data ['imgkey'] ['size'] );
				$extension = new \Zend\Validator\File\Extension ( array (
						'extension' => array (
								'gif',
								'jpg',
								'png' 
						) 
				) );
				
				if (! $adapter->isValid ()) {
					
					$dataError = $adapter->getMessages ();
					
					$error = array ();
					foreach ( $dataError as $key => $row ) {
						$error [] = $row;
					}
					
					$form->setMessages ( array (
							'imgkey' => $error 
					) );
					// die;
				}
				if ($adapter->isValid ()) {
					
					$adapter->setDestination ( MZIMG_PATH );
					if ($adapter->receive ( $data ['imgkey'] ['name'] )) {
						$profile = new Magazinepublish ();
						$profile->exchangeArray ( $form->getData () );
						// echo 'Profile Name '.$profile->title.' upload '.$profile->imgkey;
						// die;
					}
				}
				
				$magazinepublish->dataArray ( $form->getData () );
				$this->getMagazinepublishTable ()->saveMagazinepublish ( $magazinepublish );
				// Redirect to list of magazinepublishs
				return $this->redirect ()->toRoute ( 'magazinepublish' );
			} else {
				// echo('Magazine is Form Not Validate');
			}
		}
		
		return array (
				'form' => $form 
		);
	}
	
	
	public function adddetailAction() {
		$id = $this->params ()->fromRoute ( 'id', 0 );

		$mzimgArray  = $this->getMagazinepublishTable ()->fetchAllDetailMzimg ($id);
		
// 		echo '<pre>';
// 		print_r($magazinepublishs);
// 		echo '</pre>';
// 	die;

		
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		
		$form2 = new MagazineForm($dbAdapter); // include Form Class
		 
		$form2->get('submit')->setAttribute('value', 'Add');
		 
		$request = $this->getRequest();
		 
		if ($request->isPost()) {
			 
			$mzimg = new Mzimg();
		
			$form2->setInputFilter($mzimg->getInputFilter());  // check validate
		
			$data2 = array_merge_recursive(
					$this->getRequest()->getPost()->toArray(),
					$this->getRequest()->getFiles()->toArray()
			);
		
// 	echo '<pre>';
// 	print_r($data2);
// 	echo '</pre>';
// 	  die;
		
			$form2->setData($data2);  // get all post
			
			if (!$form2->isValid()) {
			
				$size = new Size(array('min'=>2000000)); //minimum bytes filesize
				 
				$adapter = new \Zend\File\Transfer\Adapter\Http();
				$adapter->setValidators(array($size), $data2['img']['size']);
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
					
				}
				if ($adapter->isValid()) {

					
// 					echo 'is valid';
// 					 var_dump(MZIMG_PATH);
// 					 var_dump($data2['img']);
// 					 die;
					   
					   
					$adapter->setDestination(MZIMG_PATH);
					if ($adapter->receive($data2['img']['name'])) {
						$profile = new Mzimg();
						//$profile->exchangeArray($form2->getData());
						
					}
					 
				}
				 
				$mzimg->dataArray($form2->getData());
				
				
				  die(" Error Connectting  Action save Modul Mzimg ");
				
		        $mzimgTable = new MzimgTable();
		        
				$mzimgTable->saveMzimg($mzimg);
				
				// Redirect to list of Mzimgs
				return $this->redirect()->toRoute('mzimg');
			}else 
			{
			  die('is not not valid Dedatil');
			}
		}
		
		return new ViewModel ( array (
				'paginatorimg' => $mzimgArray,
				'form' => $form2,
				'id' => $id,
		) );
	}
	
	
	
	public function editAction() {
		$id = ( int ) $this->params ( 'id' );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'magazinepublish', array (
					'action' => 'add' 
			) );
		}
		$magazinepublish = $this->getMagazinepublishTable ()->getMagazinepublish ( $id );
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$form = new MagazinepublishForm ($dbAdapter);
		$form->bind ( $magazinepublish );
		$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		
		$request = $this->getRequest ();
		
		if ($request->isPost ()) {
			
			$data = array_merge_recursive ( $this->getRequest ()->getPost ()->toArray (), $this->getRequest ()->getFiles ()->toArray () );
			
			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';
			
			$form->setData ( $data );
			
			if ($form->isValid ()) {
				
				$size = new Size ( array (
						'min' => 2000000 
				) ); // minimum bytes filesize
				
				$adapter = new \Zend\File\Transfer\Adapter\Http ();
				$adapter->setValidators ( array (
						$size 
				), $data ['imgkey'] ['size'] );
				$extension = new \Zend\Validator\File\Extension ( array (
						'extension' => array (
								'gif',
								'jpg',
								'png' 
						) 
				) );
			
				if ($adapter->isValid ()) {
				
					$adapter->setDestination ( MZIMG_PATH );
					if ($adapter->receive ( $data ['imgkey'] ['name'] )) {
						$profile = new Magazinepublish ();
						
					}
				}
				
				$magazinepublish2 = new Magazinepublish ();
				$magazinepublish2->dataPost ( $data );
				$this->getMagazinepublishTable ()->saveMagazinepublish2 ( $magazinepublish2 );
				
				// Redirect to list of magazinepublishs
				return $this->redirect ()->toRoute ( 'magazinepublish' );
			}
		}
		
		return array (
				'id' => $id,
				'form' => $form 
		);
	}
	public function deleteAction() {
		$id = ( int ) $this->params ( 'id' );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'magazinepublish' );
		}
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$del = $request->getPost ()->get ( 'del', 'No' );
			if ($del == 'Yes') {
				$id = ( int ) $request->getPost ()->get ( 'id' );
				$this->getMagazinepublishTable ()->deleteMagazinepublish ( $id );
			}
			
			// Redirect to list of magazinepublishs
			return $this->redirect ()->toRoute ( 'magazinepublish' );
		}
		
		return array (
				'id' => $id,
				'magazinepublish' => $this->getMagazinepublishTable ()->getMagazinepublish ( $id ) 
		);
	}
	public function getMagazinepublishTable() {
		if (! $this->magazinepublishTable) {
			$sm = $this->getServiceLocator ();
			$this->magazinepublishTable = $sm->get ( 'Magazinepublish\Model\MagazinepublishTable' );
		}
		return $this->magazinepublishTable;
	}
	
   public function readdetailAction()
   {
   	$id = ( int ) $this->params ( 'id' );
   	if (! $id) {
   		return $this->redirect ()->toRoute ( 'magazinepublish' );
   	}
   	
   	$read = $this->getMagazinepublishTable ()->getReadMagazinepublish( $id ) ;
   	return array (
   			'id' => $id,
   			'readdetail' => $read,
   	);
   }
   
   
}
