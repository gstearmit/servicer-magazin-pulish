<?php

namespace Catalogue\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Catalogue\Model\Catalogue;
use Catalogue\Form\CatalogueForm;
//use Catalogue\Form\MagazineForm;
use Catalogue\Form\CatalogueSearchForm as SearchFromCatalogue ;

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

class CatalogueController extends AbstractActionController {
	protected $catalogueTable;
	
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
			
			$searchform = new SearchFromCatalogue();
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
			
			$catalogues = $this->getCatalogueTable ()->fetchAll ( $select) ;
			$itemsPerPage = 10; // is Number record/page
			$totalRecord  = $catalogues->count();
			$catalogues->current ();
			$paginator = new Paginator ( new paginatorIterator ( $catalogues ) );
			$paginator->setCurrentPageNumber ( $page )->setItemCountPerPage ( $itemsPerPage )->setPageRange ( 4 ); // is number page want view
			
			return new ViewModel ( array (
					'search_by'  => $search_by,
					'order_by' => $order_by,
					'order_by' => $order_by,
					'order' => $order,
					'page' => $page,
					'paginator' => $paginator ,
					'pageAction' => 'catalogues ',
					'form'       => $searchform,
					'totalRecord' => $totalRecord,
			) );
		//} // login
	}
	public function addAction() {
		$form = new CatalogueForm (); // include Form Class
		$form->get ( 'submit' )->setAttribute ( 'value', 'Add' );
		
		$request = $this->getRequest ();
		
		if ($request->isPost ()) {
			
			$catalogue = new Catalogue ();
			
			$form->setInputFilter ( $catalogue->getInputFilter () ); // check validate
			
			$data = array_merge_recursive ( $this->getRequest ()->getPost ()->toArray (), $this->getRequest ()->getFiles ()->toArray () );
			
			$form->setData ( $data ); // get all post
			
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
					// echo 'is valid';
					
					// var_dump(MZIMG_PATH);
					// var_dump($data['imgkey']);
					// die;
					$adapter->setDestination ( MZIMG_PATH );
					if ($adapter->receive ( $data ['imgkey'] ['name'] )) {
						$profile = new Catalogue ();
						$profile->exchangeArray ( $form->getData () );
						// echo 'Profile Name '.$profile->title.' upload '.$profile->imgkey;
						// die;
					}
				}
				
				$catalogue->dataArray ( $form->getData () );
				$this->getCatalogueTable ()->saveCatalogue ( $catalogue );
				// Redirect to list of catalogues
				return $this->redirect ()->toRoute ( 'catalogue' );
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

		$mzimgArray  = $this->getCatalogueTable ()->fetchAllDetailMzimg ($id);
		
// 		echo '<pre>';
// 		print_r($catalogues);
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
			return $this->redirect ()->toRoute ( 'catalogue', array (
					'action' => 'add' 
			) );
		}
		$catalogue = $this->getCatalogueTable ()->getCatalogue ( $id );
		
		$form = new CatalogueForm ();
		$form->bind ( $catalogue );
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
						$profile = new Catalogue ();
						
					}
				}
				
				$catalogue2 = new Catalogue ();
				$catalogue2->dataPost ( $data );
				$this->getCatalogueTable ()->saveCatalogue2 ( $catalogue2 );
				
				// Redirect to list of catalogues
				return $this->redirect ()->toRoute ( 'catalogue' );
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
			return $this->redirect ()->toRoute ( 'catalogue' );
		}
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$del = $request->getPost ()->get ( 'del', 'No' );
			if ($del == 'Yes') {
				$id = ( int ) $request->getPost ()->get ( 'id' );
				$this->getCatalogueTable ()->deleteCatalogue ( $id );
			}
			
			// Redirect to list of catalogues
			return $this->redirect ()->toRoute ( 'catalogue' );
		}
		
		return array (
				'id' => $id,
				'catalogue' => $this->getCatalogueTable ()->getCatalogue ( $id ) 
		);
	}
	public function getCatalogueTable() {
		if (! $this->catalogueTable) {
			$sm = $this->getServiceLocator ();
			$this->catalogueTable = $sm->get ( 'Catalogue\Model\CatalogueTable' );
		}
		return $this->catalogueTable;
	}
	
// 	public function getMzimgTable() {
// 		if (!$this->catalogueTable) {
// 			$sm = $this->getServiceLocator();
// 			$this->catalogueTable = $sm->get('Mzimg\Model\MzimgTable');
// 		}
// 		return $this->catalogueTable;
// 	}
}
