<?php

namespace Magazinevietnam\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Magazinevietnam\Model\Magazinevietnam;
use Magazinevietnam\Form\MagazinevietnamForm;
use Magazinevietnam\Form\MagazineForm;
use Magazinevietnam\Form\MagazinevietnamSearchForm as SearchFromMagazinevietnam ;

use Mgvndetail\Model\Mgvndetail;

use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
// check login
use ZfcUser\Service\User as UserService;
use ZfcUser\Options\UserControllerOptionsInterface;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;
use Mgvndetail\Model\MgvndetailTable;

class MagazinevietnamController extends AbstractActionController {
	protected $magazinevietnamTable;
	
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
			
			$searchform = new SearchFromMagazinevietnam();
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
			
			$magazinevietnams = $this->getMagazinevietnamTable ()->fetchAll ( $select) ;
			$itemsPerPage = 10; // is Number record/page
			$totalRecord  = $magazinevietnams->count();
			$magazinevietnams->current ();
			$paginator = new Paginator ( new paginatorIterator ( $magazinevietnams ) );
			$paginator->setCurrentPageNumber ( $page )->setItemCountPerPage ( $itemsPerPage )->setPageRange ( 4 ); // is number page want view
			
			return new ViewModel ( array (
					'search_by'  => $search_by,
					'order_by' => $order_by,
					'order_by' => $order_by,
					'order' => $order,
					'page' => $page,
					'paginatormagazinevietnam' => $paginator ,
					'pageAction' => 'magazinevietnams ',
					'form'       => $searchform,
					'totalRecord' => $totalRecord,
			) );
		//} // login
	}
	public function addAction() {
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$form = new MagazinevietnamForm ($dbAdapter); // include Form Class
		$form->get ( 'submit' )->setAttribute ( 'value', 'Add' );
		
		$request = $this->getRequest ();
		
		if ($request->isPost ()) {
			
			$magazinevietnam = new Magazinevietnam ();
			
			$form->setInputFilter ( $magazinevietnam->getInputFilter () ); // check validate
			
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
						$profile = new Magazinevietnam ();
						$profile->exchangeArray ( $form->getData () );
						// echo 'Profile Name '.$profile->title.' upload '.$profile->imgkey;
						// die;
					}
				}
				
				$magazinevietnam->dataArray ( $form->getData () );
				$this->getMagazinevietnamTable ()->saveMagazinevietnam ( $magazinevietnam );
				// Redirect to list of magazinevietnams
				return $this->redirect ()->toRoute ( 'magazinevietnam' );
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

		$MgvndetailArray  = $this->getMagazinevietnamTable ()->fetchAllDetailMgvndetail ($id);
		
// 		echo '<pre>';
// 		print_r($magazinevietnams);
// 		echo '</pre>';
// 	die;

		
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		
		$form2 = new MagazineForm($dbAdapter); // include Form Class
		 
		$form2->get('submit')->setAttribute('value', 'Add');
		 
		$request = $this->getRequest();
		 
		if ($request->isPost()) {
			 
			$Mgvndetail = new Mgvndetail();
		
			$form2->setInputFilter($Mgvndetail->getInputFilter());  // check validate
		
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
						$profile = new Mgvndetail();
						//$profile->exchangeArray($form2->getData());
						
					}
					 
				}
				 
				$Mgvndetail->dataArray($form2->getData());
				
				
				  die(" Error Connectting  Action save Modul Mgvndetail ");
				
		        $MgvndetailTable = new MgvndetailTable();
		        
				$MgvndetailTable->saveMgvndetail($Mgvndetail);
				
				// Redirect to list of Mgvndetails
				return $this->redirect()->toRoute('mgvndetail');
			}else 
			{
			  die('is not not valid Dedatil');
			}
		}
		
		return new ViewModel ( array (
				'paginatorimg' => $MgvndetailArray,
				'form' => $form2,
				'id' => $id,
		) );
	}
	
	
	
	public function editAction() {
		$id = ( int ) $this->params ( 'id' );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'magazinevietnam', array (
					'action' => 'add' 
			) );
		}
		$magazinevietnam = $this->getMagazinevietnamTable ()->getMagazinevietnam ( $id );
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$form = new MagazinevietnamForm ($dbAdapter);
		$form->bind ( $magazinevietnam );
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
						$profile = new Magazinevietnam ();
						
					}
				}
				
				$magazinevietnam2 = new Magazinevietnam ();
				$magazinevietnam2->dataPost ( $data );
				$this->getMagazinevietnamTable ()->saveMagazinevietnam2 ( $magazinevietnam2 );
				
				// Redirect to list of magazinevietnams
				return $this->redirect ()->toRoute ( 'magazinevietnam' );
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
			return $this->redirect ()->toRoute ( 'magazinevietnam' );
		}
		
		$dir = ROOT_PATH . UPLOAD_PATH_IMG;
		// getname- img
		$image_array_all = $this->getMagazinevietnamTable()->getReadMagazinevietnam($id);
		
// 		echo '<pre>';
// 		print_r($image_array_all);
// 		echo '</pre>';
	    
		
		$image_array = array();
		if (is_array($image_array_all) and !empty($image_array_all))
			{
						foreach ($image_array_all as $result)
							{
								$tmp = array();
								$tmp= $result['img'];
								$image_array[] = $tmp;
							}
				
			}//else { Echo 'Not get name Imges'; die;}
			
			
			
			$array = array();
			if(is_array($image_array) and !empty($image_array))
			{
			
				foreach ($image_array as $result)
				{
					$arr_temp = explode('/', $result);
					$dir_name = $arr_temp[0];
					$tmp = array();
					$tmp= $arr_temp[1];
					$array[] = $tmp;
				}
			}
			
		
// 			echo '</br>';
// 			echo '<pre>';
// 			print_r($image_array);
// 			echo '</pre>';
			
// 			echo '</br>';
// 			var_dump($dir.$dir_name);
// 			echo '<pre>';
// 			print_r($array);
// 			echo '</pre>';
// 			//die;
		
			
			
			
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$del = $request->getPost ()->get ( 'del', 'No' );
			if ($del == 'Yes') {
				
				$id = ( int ) $request->getPost ()->get ( 'id' );
				$this->getMagazinevietnamTable ()->deleteMagazinevietnam ( $id );
				// delete table con cua no
				$this->getMagazinevietnamTable()->getTableByIdDelete($id);
				
// 				// delete img 
// 				foreach ( $array as $image)
// 				{
// 				   $result = $this->deleteImage($image, $dir.$dir_name);
				  
// 				}
				
			}
			
			// Redirect to list of magazinevietnams
			return $this->redirect ()->toRoute ( 'magazinevietnam' );
		}
		
		return array (
				'id' => $id,
				'magazinevietnam' => $this->getMagazinevietnamTable ()->getMagazinevietnam ( $id ) 
		);
	}
	
	
	public function readdetailAction()
	{
		$id = ( int ) $this->params ( 'id' );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'magazinevietnam' );
		}
	
		$read = $this->getMagazinevietnamTable ()->getReadMagazinevietnam( $id ) ;
		return array (
				'id' => $id,
				'readdetail' => $read,
		);
	}
	
	
	public function getMagazinevietnamTable() {
		if (! $this->magazinevietnamTable) {
			$sm = $this->getServiceLocator ();
			$this->magazinevietnamTable = $sm->get ( 'Magazinevietnam\Model\MagazinevietnamTable' );
		}
		return $this->magazinevietnamTable;
	}
	
	public function deleteImage($image, $dir) {
		
		
		try {
			$this->deleteFile($dir .'/'. $image);
			$this->deleteFile($dir .'/thumb_/thumb_'. $image);
	         
			//$logger->writeLog("DEBUG", $userEmail, $arrLog[0], $arrLog[1], "Delete image, file : " . $dir .'/'. $image, ">>");
			//$logger->writeLog("INFO", $userEmail, $arrLog[0], $arrLog[1], "Delete image, file : " . $dir .'/thumb_/thumb_'. $image, ">>");
		} catch (\Exception $exc) {
			$this->errorMessage = $exc->getMessage();
		}
	
	
	}
}
