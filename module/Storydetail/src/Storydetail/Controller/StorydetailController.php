<?php

namespace Storydetail\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Storydetail\Model\Storydetail;
use Storydetail\Form\StorydetailForm;
use Storydetail\Form\MagazineForm as FromClass;

use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use ZfcUser\Service\User as UserService;
use ZfcUser\Options\UserControllerOptionsInterface;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;

class StorydetailController extends AbstractActionController {
	protected $storydetailTable;
	public function indexAction() {
		// check login
// 		if (! $this->zfcUserAuthentication ()->hasIdentity ()) {
// 			return $this->redirect ()->toRoute ( 'zfcuser/login' );
// 		}
		
		$select = new Select ();
		
		$order_by = $this->params ()->fromRoute ( 'order_by' ) ? $this->params ()->fromRoute ( 'order_by' ) : 'id';
		$order = $this->params ()->fromRoute ( 'order' ) ? $this->params ()->fromRoute ( 'order' ) : Select::ORDER_DESCENDING;
		$page = $this->params ()->fromRoute ( 'page' ) ? ( int ) $this->params ()->fromRoute ( 'page' ) : 1;
		
		$storydetails = $this->getStorydetailTable ()->fetchAll ( $select->order ( $order_by . ' ' . $order ) );
		$itemsPerPage = 10; // is Number record/page
		
		$storydetails->current ();
		$paginator = new Paginator ( new paginatorIterator ( $storydetails ) );
		$paginator->setCurrentPageNumber ( $page )->setItemCountPerPage ( $itemsPerPage )->setPageRange ( 4 ); // is number page want view
		
		return new ViewModel ( array (
				'order_by' => $order_by,
				'order' => $order,
				'page' => $page,
				'paginatorstory' => $paginator 
		) );
	}
	public function addAction() {
		$dbAdapter = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Adapter' );
		
		$form = new StorydetailForm ( $dbAdapter ); // include Form Class
		
		$form->get ( 'submit' )->setAttribute ( 'value', 'Add' );
		
		$request = $this->getRequest ();
		
		if ($request->isPost ()) {
			
			$storydetail = new Storydetail ();
			
			$form->setInputFilter ( $storydetail->getInputFilter () ); // check validate
			
			$data = array_merge_recursive ( $this->getRequest ()->getPost ()->toArray (), $this->getRequest ()->getFiles ()->toArray () );
			
			$form->setData ( $data ); // get all post
			
			if ($form->isValid ()) {
				$size = new Size ( array (
						'min' => 2000000 
				) ); // minimum bytes filesize
				
				$adapter = new \Zend\File\Transfer\Adapter\Http ();
				$adapter->setValidators ( array (
						$size 
				), $data ['img'] ['size'] );
				$extension = new \Zend\Validator\File\Extension ( array (
						'extension' => array (
								'gif',
								'jpg',
								'png' 
						) 
				) );
				
				if (! $adapter->isValid ()) {
					
					// echo 'is not valid';
					
					$dataError = $adapter->getMessages ();
					
					$error = array ();
					foreach ( $dataError as $key => $row ) {
						$error [] = $row;
					}
					
					$form->setMessages ( array (
							'img' => $error 
					) );
				}
				if ($adapter->isValid ()) {
					
					$adapter->setDestination ( MZIMG_PATH );
					if ($adapter->receive ( $data ['img'] ['name'] )) {
						$profile = new Storydetail ();
						$profile->exchangeArray ( $form->getData () );
						// echo 'Profile Name '.$profile->title.' upload '.$profile->imgkey;
						// die;
					}
				}
				
				$storydetail->dataArray ( $form->getData () );
				
				$this->getStorydetailTable ()->saveStorydetail ( $storydetail );
				// Redirect to list of Storydetails
				return $this->redirect ()->toRoute ( 'storydetail' );
			}
		}
		
		return array (
				'form' => $form 
		// 'idmz'=>$idmz
				);
	}
	public function adddetailAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		
		$select = new Select ();
		
		$order_by = $this->params ()->fromRoute ( 'order_by' ) ? $this->params ()->fromRoute ( 'order_by' ) : 'id';
		$order = $this->params ()->fromRoute ( 'order' ) ? $this->params ()->fromRoute ( 'order' ) : Select::ORDER_DESCENDING;
		$page = $this->params ()->fromRoute ( 'page' ) ? ( int ) $this->params ()->fromRoute ( 'page' ) : 1;
		
		//$storydetails = $this->getStorydetailTable ()->fetchAll ( $select->order ( $order_by . ' ' . $order ) );
		//$storyArray  = $this->getStorydetailTable()->fetchAllDetailStory ($id ,$select->order ( $order_by . ' ' . $order ));
		$storyArray  = $this->getStorydetailTable()->fetchAllDetailStory ($id);
		
		$itemsPerPage = 10; // is Number record/page
		
// 		$storydetails->current ();
// 		$paginator = new Paginator ( new paginatorIterator ( $storydetails ) );
// 		$paginator->setCurrentPageNumber ( $page )->setItemCountPerPage ( $itemsPerPage )->setPageRange ( 4 ); // is number page want view
		
// 		return new ViewModel ( array (
// 				'order_by' => $order_by,
// 				'order' => $order,
// 				'page' => $page,
// 				'paginatorstory' => $paginator
// 		) );
		
		
		
		
		$dbAdapter = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Adapter' );
		
		$form = new FromClass ( $dbAdapter,$id ); // include Form Class
		
		$form->get ( 'submit' )->setAttribute ( 'value', 'Add' );
		
		$request = $this->getRequest ();
		
		if ($request->isPost ()) {
			
			$storydetail = new Storydetail ();
			
			$form->setInputFilter ( $storydetail->getInputFilter () ); // check validate
			
			$data = array_merge_recursive ( $this->getRequest ()->getPost ()->toArray (), $this->getRequest ()->getFiles ()->toArray () );
			
			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';
			
			$form->setData ( $data ); // get all post
			
			if (!$form->isValid ()) {
				$size = new Size ( array (
						'min' => 2000000 
				) ); // minimum bytes filesize
				
				$adapter = new \Zend\File\Transfer\Adapter\Http ();
				$adapter->setValidators ( array (
						$size 
				), $data ['img'] ['size'] );
				$extension = new \Zend\Validator\File\Extension ( array (
						'extension' => array (
								'gif',
								'jpg',
								'png' 
						) 
				) );
				
				if (! $adapter->isValid ()) {
					
					echo 'is not valid';
					
					$dataError = $adapter->getMessages ();
					
					$error = array ();
					foreach ( $dataError as $key => $row ) {
						$error [] = $row;
					}
					
					// var_dump($error);
					// die;
					
					$form->setMessages ( array (
							'img' => $error 
					) );
					// die;
				}
				if ($adapter->isValid ()) {
					// echo 'is valid';
					
					// var_dump(MZIMG_PATH);
					// var_dump($data['img']);
					// die;
					$adapter->setDestination ( MZIMG_PATH );
					if ($adapter->receive ( $data ['img'] ['name'] )) {
						$profile = new Storydetail ();
						//$profile->exchangeArray ( $form->getData () );
						// echo 'Profile Name '.$profile->title.' upload '.$profile->imgkey;
						// die;
					}
				}
				
				$storydetail->dataArray ( $form->getData () );
				
				// var_dump($storydetail);
				// die();
				
				$this->getStorydetailTable ()->saveStorydetail ( $storydetail );
				// Redirect to list of Storydetails
				return $this->redirect ()->toRoute ( 'storydetail' );
			}
		}
		return new ViewModel ( array (
				'order_by' => $order_by,
				'order' => $order,
				'page' => $page,
				'paginatorstory' => $storyArray,
				'form' => $form,
				'id' => $id,
		) );
	}
	
	
	public function editAction() {
		$dbAdapter = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Adapter' );
		$id = ( int ) $this->params ( 'id' );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'storydetail', array (
					'action' => 'add' 
			) );
		}
		$storydetail = $this->getStorydetailTable ()->getStorydetail ( $id );
		
		//$form = new StorydetailForm ( $dbAdapter );
		$form = new FromClass ( $dbAdapter,$id );
		
		$form->bind ( $storydetail );
		$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			
			$data = array_merge_recursive ( $this->getRequest ()->getPost ()->toArray (), $this->getRequest ()->getFiles ()->toArray () );
			
			$form->setData ( $data );
			
			if (!$form->isValid ()) {
				
				$size = new Size ( array (
						'min' => 2000000 
				) ); // minimum bytes filesize
				
				$adapter = new \Zend\File\Transfer\Adapter\Http ();
				$adapter->setValidators ( array (
						$size 
				), $data ['img'] ['size'] );
				$extension = new \Zend\Validator\File\Extension ( array (
						'extension' => array (
								'gif',
								'jpg',
								'png' 
						) 
				) );
				// if (!$adapter->isValid())
				// {
				// echo 'is not valid';
				// die;
				
				// $dataError = $adapter->getMessages();
				
				// $error = array();
				// foreach($dataError as $key=>$row)
				// {
				// $error[] = $row;
				// }
				
				// $form->setMessages(array('imgkey'=>$error ));
				// //die;
				// }
				if ($adapter->isValid ()) {
					// echo 'is valid';
					// var_dump(MZIMG_PATH);
					// var_dump($data['imgkey']);
					// die;
					
					$adapter->setDestination ( MZIMG_PATH );
					if ($adapter->receive ( $data ['img'] ['name'] )) {
						$profile = new Storydetail ();
						// $profile->exchangeArray($form->getData());
						// echo 'Profile Name '.$profile->title.' upload '.$profile->imgkey;
						// die;
					}
				}
				
				$storydetail2 = new Storydetail ();
				$storydetail2->dataPost ( $data );
				$this->getStorydetailTable ()->saveStorydetail ( $storydetail2 );
				
				// Redirect to list of storydetails
				return $this->redirect ()->toRoute ( 'storydetail' );
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
			return $this->redirect ()->toRoute ( 'storydetail' );
		}
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$del = $request->getPost ()->get ( 'del', 'No' );
			if ($del == 'Yes') {
				$id = ( int ) $request->getPost ()->get ( 'id' );
				$this->getStorydetailTable ()->deleteStorydetail ( $id );
			}
			
			// Redirect to list of Storydetails
			return $this->redirect ()->toRoute ( 'storydetail' );
		}
		
		return array (
				'id' => $id,
				'storydetail' => $this->getStorydetailTable ()->getStorydetail ( $id ) 
		);
	}
	public function getStorydetailTable() {
		if (! $this->storydetailTable) {
			$sm = $this->getServiceLocator ();
			$this->storydetailTable = $sm->get ( 'Storydetail\Model\StorydetailTable' );
		}
		return $this->storydetailTable;
	}
}
