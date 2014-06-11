<?php

namespace Portcms\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Portcms\Model\Portcms;
use Portcms\Form\PortcmsForm;
use Portcms\Form\MagazineForm;
use Portcms\Form\PortcmsSearchForm as SearchFromPortcms ;

use Storydetail\Model\Storydetail;
use Storydetail\Model\StorydetailTable;

use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
// check login
use ZfcUser\Service\User as UserService;
use ZfcUser\Options\UserControllerOptionsInterface;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;


class PortcmsController extends AbstractActionController {
	protected $portcmsTable;
	
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
	
	
	
// 	public function searchAction()
// 	{
	
// 		$request = $this->getRequest();
	
// 		$url = 'index';
	
// 		if ($request->isPost()) {
// 			$formdata    = (array) $request->getPost();
// 			$search_data = array();
// 			foreach ($formdata as $key => $value) {
// 				if ($key != 'submit') {
// 					if (!empty($value)) {
// 						$search_data[$key] = $value;
// 					}
// 				}
// 			}
// 			if (!empty($search_data)) {
// 				$search_by = json_encode($search_data);
// 				$url .= '/search_by/' . $search_by;
// 			}
// 		}
// 		$this->redirect()->toUrl($url);
// 	}
	
	
// 	public function indexAction() {
// 		// check login
// // 		if (! $this->zfcUserAuthentication ()->hasIdentity ()) {
// // 			return $this->redirect ()->toRoute ( 'zfcuser/login' );
// // 		} else {
			
// 			$searchform = new SearchFromPortcms();
// 			$searchform->get('submit')->setValue('Search');
			
// 			$select = new Select ();
			
// 			$order_by = $this->params ()->fromRoute ( 'order_by' ) ? $this->params ()->fromRoute ( 'order_by' ) : 'id';
// 			$order = $this->params ()->fromRoute ( 'order' ) ? $this->params ()->fromRoute ( 'order' ) : Select::ORDER_DESCENDING;
// 			$page = $this->params ()->fromRoute ( 'page' ) ? ( int ) $this->params ()->fromRoute ( 'page' ) : 1;
// 			$search_by = $this->params()->fromRoute('search_by') ? $this->params()->fromRoute('search_by') : '';
// 			$select->order($order_by . ' ' . $order);
// 			$where    = new \Zend\Db\Sql\Where();
// 			$formdata = array();
// 			if (!empty($search_by)) {
// 				$formdata = (array) json_decode($search_by);
// 				if (!empty($formdata['descriptionkey'])) {
// 					$where->addPredicate(
// 							new \Zend\Db\Sql\Predicate\Like('descriptionkey', '%' . $formdata['descriptionkey'] . '%')
// 					);
// 				}
// 				if (!empty($formdata['title'])) {
// 					$where->addPredicate(
// 							new \Zend\Db\Sql\Predicate\Like('title', '%' . $formdata['title'] . '%')
// 					);
// 				}
			
// 			}
// 			if (!empty($where)) {
// 				$select->where($where);
// 			}
			
// 			$portcmss = $this->getPortcmsTable ()->fetchAll ( $select) ;
// 			$itemsPerPage = 10; // is Number record/page
// 			$totalRecord  = $portcmss->count();
// 			$portcmss->current ();
// 			$paginator = new Paginator ( new paginatorIterator ( $portcmss ) );
// 			$paginator->setCurrentPageNumber ( $page )->setItemCountPerPage ( $itemsPerPage )->setPageRange ( 4 ); // is number page want view
			
// 			return new ViewModel ( array (
// 					'search_by'  => $search_by,
// 					'order_by' => $order_by,
// 					'order_by' => $order_by,
// 					'order' => $order,
// 					'page' => $page,
// 					'paginator' => $paginator ,
// 					'pageAction' => 'portcmss ',
// 					'form'       => $searchform,
// 					'totalRecord' => $totalRecord,
// 			) );
// 		//} // login
// 	}
// 	public function addAction() {
		
// 		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
// 		$form = new PortcmsForm ($dbAdapter); // include Form Class
// 		$form->get ( 'submit' )->setAttribute ( 'value', 'Add' );
		
// 		$request = $this->getRequest ();
		
// 		if ($request->isPost ()) {
			
// 			$portcms = new Portcms ();
			
// 			$form->setInputFilter ( $portcms->getInputFilter () ); // check validate
			
// 			$data = array_merge_recursive ( $this->getRequest ()->getPost ()->toArray (), $this->getRequest ()->getFiles ()->toArray () );
			
// 			$form->setData ( $data ); // get all post
			
// 			if ($form->isValid ()) {
				
// 				$size = new Size ( array (
// 						'min' => 2000000 
// 				) ); // minimum bytes filesize
				
// 				$adapter = new \Zend\File\Transfer\Adapter\Http ();
// 				$adapter->setValidators ( array (
// 						$size 
// 				), $data ['imgkey'] ['size'] );
// 				$extension = new \Zend\Validator\File\Extension ( array (
// 						'extension' => array (
// 								'gif',
// 								'jpg',
// 								'png' 
// 						) 
// 				) );
				
// 				if (! $adapter->isValid ()) {
					
// 					$dataError = $adapter->getMessages ();
					
// 					$error = array ();
// 					foreach ( $dataError as $key => $row ) {
// 						$error [] = $row;
// 					}
					
// 					$form->setMessages ( array (
// 							'imgkey' => $error 
// 					) );
// 					// die;
// 				}
// 				if ($adapter->isValid ()) {
// 					// echo 'is valid';
					
// 					// var_dump(MZIMG_PATH);
// 					// var_dump($data['imgkey']);
// 					// die;
// 					$adapter->setDestination ( MZIMG_PATH );
// 					if ($adapter->receive ( $data ['imgkey'] ['name'] )) {
// 						$profile = new Portcms ();
// 						$profile->exchangeArray ( $form->getData () );
// 						// echo 'Profile Name '.$profile->title.' upload '.$profile->imgkey;
// 						// die;
// 					}
// 				}
				
// 				$portcms->dataArray ( $form->getData () );
// 				$this->getPortcmsTable ()->savePortcms ( $portcms );
// 				// Redirect to list of portcmss
// 				return $this->redirect ()->toRoute ( 'portcms' );
// 			} else {
// 				// echo('Magazine is Form Not Validate');
// 			}
// 		}
		
// 		return array (
// 				'form' => $form 
// 		);
// 	}
	
	

	
// 	public function editAction() {
// 		$id = ( int ) $this->params ( 'id' );
// 		if (! $id) {
// 			return $this->redirect ()->toRoute ( 'portcms', array (
// 					'action' => 'add' 
// 			) );
// 		}
// 		$portcms = $this->getPortcmsTable ()->getPortcms ( $id );
// 		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
// 		$form = new PortcmsForm ($dbAdapter);
// 		$form->bind ( $portcms );
// 		$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		
// 		$request = $this->getRequest ();
		
// 		if ($request->isPost ()) {
			
// 			$data = array_merge_recursive ( $this->getRequest ()->getPost ()->toArray (), $this->getRequest ()->getFiles ()->toArray () );
			
// 			// echo '<pre>';
// 			// print_r($data);
// 			// echo '</pre>';
			
// 			$form->setData ( $data );
			
// 			if ($form->isValid ()) {
				
// 				$size = new Size ( array (
// 						'min' => 2000000 
// 				) ); // minimum bytes filesize
				
// 				$adapter = new \Zend\File\Transfer\Adapter\Http ();
// 				$adapter->setValidators ( array (
// 						$size 
// 				), $data ['imgkey'] ['size'] );
// 				$extension = new \Zend\Validator\File\Extension ( array (
// 						'extension' => array (
// 								'gif',
// 								'jpg',
// 								'png' 
// 						) 
// 				) );
			
// 				if ($adapter->isValid ()) {
				
// 					$adapter->setDestination ( MZIMG_PATH );
// 					if ($adapter->receive ( $data ['imgkey'] ['name'] )) {
// 						$profile = new Portcms ();
						
// 					}
// 				}
				
// 				$portcms2 = new Portcms ();
// 				$portcms2->dataPost ( $data );
// 				$this->getPortcmsTable ()->savePortcms2 ( $portcms2 );
				
// 				// Redirect to list of portcmss
// 				return $this->redirect ()->toRoute ( 'portcms' );
// 			}
// 		}
		
// 		return array (
// 				'id' => $id,
// 				'form' => $form 
// 		);
// 	}
// 	public function deleteAction() {
// 		$id = ( int ) $this->params ( 'id' );
// 		if (! $id) {
// 			return $this->redirect ()->toRoute ( 'portcms' );
// 		}
		
		
		
// 		$request = $this->getRequest ();
// 		if ($request->isPost ()) {
// 			$del = $request->getPost ()->get ( 'del', 'No' );
// 			if ($del == 'Yes') {
// 				$id = ( int ) $request->getPost ()->get ( 'id' );
// 				$this->getPortcmsTable ()->deletePortcms ( $id );
				
// 				// delete table con cua no
// 				$this->getPortcmsTable()->getTableByIdDelete($id);
// 			}
			
// 			// Redirect to list of portcmss
// 			return $this->redirect ()->toRoute ( 'portcms' );
// 		}
		
// 		return array (
// 				'id' => $id,
// 				'portcms' => $this->getPortcmsTable ()->getPortcms ( $id ) 
// 		);
// 	}
	
	
// 	public function readdetailAction()
// 	{
// 		$id = ( int ) $this->params ( 'id' );
// 		if (! $id) {
// 			return $this->redirect ()->toRoute ( 'portcms' );
// 		}
	
// 		$read = $this->getPortcmsTable ()->getReadPortcms( $id ) ;
// 		return array (
// 				'id' => $id,
// 				'readdetail' => $read,
// 		);
// 	}
	
	
// 	public function getPortcmsTable() {
// 		if (! $this->portcmsTable) {
// 			$sm = $this->getServiceLocator ();
// 			$this->portcmsTable = $sm->get ( 'Portcms\Model\PortcmsTable' );
// 		}
// 		return $this->portcmsTable;
// 	}
	

}
