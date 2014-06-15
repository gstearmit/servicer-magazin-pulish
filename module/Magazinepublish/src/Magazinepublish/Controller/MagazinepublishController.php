<?php

namespace Magazinepublish\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Magazinepublish\Model\Magazinepublish;
use Magazinepublish\Form\MagazinepublishForm;
use Magazinepublish\Form\MagazineForm;
use Magazinepublish\Form\MagazinepublishSearchForm as SearchFromMagazinepublish;
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
	public function searchAction() {
		$request = $this->getRequest ();
		
		$url = 'index';
		
		if ($request->isPost ()) {
			$formdata = ( array ) $request->getPost ();
			$search_data = array ();
			foreach ( $formdata as $key => $value ) {
				if ($key != 'submit') {
					if (! empty ( $value )) {
						$search_data [$key] = $value;
					}
				}
			}
			if (! empty ( $search_data )) {
				$search_by = json_encode ( $search_data );
				$url .= '/search_by/' . $search_by;
			}
		}
		$this->redirect ()->toUrl ( $url );
	}
	public function indexAction() {
		// check login
		// if (! $this->zfcUserAuthentication ()->hasIdentity ()) {
		// return $this->redirect ()->toRoute ( 'zfcuser/login' );
		// } else {
		$searchform = new SearchFromMagazinepublish ();
		$searchform->get ( 'submit' )->setValue ( 'Search' );
		
		$select = new Select ();
		
		$order_by = $this->params ()->fromRoute ( 'order_by' ) ? $this->params ()->fromRoute ( 'order_by' ) : 'id';
		$order = $this->params ()->fromRoute ( 'order' ) ? $this->params ()->fromRoute ( 'order' ) : Select::ORDER_DESCENDING;
		$page = $this->params ()->fromRoute ( 'page' ) ? ( int ) $this->params ()->fromRoute ( 'page' ) : 1;
		$search_by = $this->params ()->fromRoute ( 'search_by' ) ? $this->params ()->fromRoute ( 'search_by' ) : '';
		$select->order ( $order_by . ' ' . $order );
		$where = new \Zend\Db\Sql\Where ();
		$formdata = array ();
		if (! empty ( $search_by )) {
			$formdata = ( array ) json_decode ( $search_by );
			if (! empty ( $formdata ['descriptionkey'] )) {
				$where->addPredicate ( new \Zend\Db\Sql\Predicate\Like ( 'descriptionkey', '%' . $formdata ['descriptionkey'] . '%' ) );
			}
			if (! empty ( $formdata ['title'] )) {
				$where->addPredicate ( new \Zend\Db\Sql\Predicate\Like ( 'title', '%' . $formdata ['title'] . '%' ) );
			}
		}
		if (! empty ( $where )) {
			$select->where ( $where );
		}
		
		$magazinepublishs = $this->getMagazinepublishTable ()->fetchAll ( $select );
		$itemsPerPage = 10; // is Number record/page
		$totalRecord = $magazinepublishs->count ();
		$magazinepublishs->current ();
		$paginator = new Paginator ( new paginatorIterator ( $magazinepublishs ) );
		$paginator->setCurrentPageNumber ( $page )->setItemCountPerPage ( $itemsPerPage )->setPageRange ( 4 ); // is number page want view
		
		return new ViewModel ( array (
				'search_by' => $search_by,
				'order_by' => $order_by,
				'order_by' => $order_by,
				'order' => $order,
				'page' => $page,
				'paginator' => $paginator,
				'pageAction' => 'magazinepublishs ',
				'form' => $searchform,
				'totalRecord' => $totalRecord 
		) );
		// } // login
	}
	public function addAction() {
		$dbAdapter = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Adapter' );
		$form = new MagazinepublishForm ( $dbAdapter ); // include Form Class
		$form->get ( 'submit' )->setAttribute ( 'value', 'Add' );
		
		$request = $this->getRequest ();
		
		if ($request->isPost ()) {
			
			$magazinepublish = new Magazinepublish ();
			
			$form->setInputFilter ( $magazinepublish->getInputFilter () ); // check validate
			
			$data = array_merge_recursive ( $this->getRequest ()->getPost ()->toArray (), $this->getRequest ()->getFiles ()->toArray () );
			
			$form->setData ( $data ); // get all post
			
// 			echo 'validate ';
// 			var_dump ( $form->isValid () );
// 			echo '<pre>';
// 			print_r ( $data );
// 			echo '</pre>';
// // 			//die ();
			//var_dump($renname_file_img);	die('hoangpohuihc');
			
			if ($form->isValid ()) {
				
				
				$renname_file_img = $this->uploadImageAlatca ( $data ['imgkey'] );
				$magazinepublish->dataArraySwap ( $data, $renname_file_img );
				
				$this->getMagazinepublishTable ()->saveMagazinepublish ( $magazinepublish );
				
				// Redirect to list of magazinepublishs
				return $this->redirect ()->toRoute ('magazinepublish' ); //magazinepublish
			} else {
				// echo('Magazine is Form Not Validate');
			}
		}
		
		
		return array (
				'form' => $form 
		);
	}
	public function editAction() {
		$id = ( int ) $this->params ( 'id' );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'magazinepublish', array (
					'action' => 'add' 
			) );
		}
		$magazinepublish = $this->getMagazinepublishTable ()->getMagazinepublish ( $id );
		
		$nameimg = $magazinepublish->imgkey;
		
		$dbAdapter = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Adapter' );
		$form = new MagazinepublishForm ( $dbAdapter, $id );
		$form->bind ( $magazinepublish );
		$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		
		$request = $this->getRequest ();
		
		if ($request->isPost ()) {
			
			$data = array_merge_recursive ( $this->getRequest ()->getPost ()->toArray (), $this->getRequest ()->getFiles ()->toArray () );
			
			$form->setData ( $data );
			
			if ($form->isValid ()) {
				
				if ($data ['imgkeyedit'] ['name'] !== '') {
					
					$magazinepublish2 = new Magazinepublish ();
					$renname_file_img = $this->uploadImageAlatca ( $data ['imgkeyedit'] );
					$magazinepublish2->dataArraySwap ( $data, $renname_file_img );
					$this->getMagazinepublishTable ()->saveMagazinepublish2 ( $magazinepublish2 );
				} else {
					
					$magazinepublish2 = new Magazinepublish ();
					$magazinepublish2->dataArraySwap ( $data, $nameimg );
					$this->getMagazinepublishTable ()->saveMagazinepublish2 ( $magazinepublish2 );
				}
				
				// Redirect to list of magazinepublishs
				return $this->redirect ()->toRoute ( 'magazinepublish' );
			}
		}
		
		return array (
				'id' => $id,
				'form' => $form,
				'nameimg' => $nameimg 
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
	
	public function readdetailAction() {
		$id = ( int ) $this->params ( 'id' );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'magazinepublish' );
		}
		
		$read = $this->getMagazinepublishTable ()->getReadMagazinepublish ( $id );
		return array (
				'id' => $id,
				'readdetail' => $read 
		);
	}
	
	
	public function createImageThumbnail($filePathName, $destinationPath, $options) {
		$arr = explode ( '/', $filePathName );
		$file_name = end ( $arr );
		
		$new_file_name = 'thumb_' . $file_name;
		$new_file_path = $destinationPath . '/' . $new_file_name;
		
		list ( $img_width, $img_height ) = @getimagesize ( $filePathName );
		if (! $img_width || ! $img_height) {
			return false;
		}
		$scale = min ( $options ['max_width'] / $img_width, $options ['max_height'] / $img_height );
		$new_width = $img_width * $scale;
		$new_height = $img_height * $scale;
		$new_img = @imagecreatetruecolor ( $new_width, $new_height );
		switch (strtolower ( substr ( strrchr ( $file_name, '.' ), 1 ) )) {
			case 'jpg' :
			case 'jpeg' :
				$src_img = @imagecreatefromjpeg ( $filePathName );
				$write_image = 'imagejpeg';
				$image_quality = isset ( $options ['jpeg_quality'] ) ? $options ['jpeg_quality'] : 75;
				break;
			case 'gif' :
				@imagecolortransparent ( $new_img, @imagecolorallocate ( $new_img, 0, 0, 0 ) );
				$src_img = @imagecreatefromgif ( $filePathName );
				$write_image = 'imagegif';
				$image_quality = null;
				break;
			case 'png' :
				@imagecolortransparent ( $new_img, @imagecolorallocate ( $new_img, 0, 0, 0 ) );
				@imagealphablending ( $new_img, false );
				@imagesavealpha ( $new_img, true );
				$src_img = @imagecreatefrompng ( $filePathName );
				$write_image = 'imagepng';
				$image_quality = isset ( $options ['png_quality'] ) ? $options ['png_quality'] : 9;
				break;
			default :
				$src_img = null;
		}
		$success = $src_img && @imagecopyresampled ( $new_img, $src_img, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height ) && $write_image ( $new_img, $new_file_path, $image_quality );
		// Free up memory (imagedestroy does not delete files):
		@imagedestroy ( $src_img );
		@imagedestroy ( $new_img );
		if ($success)
			return $new_file_name;
		return $success;
	}
	public function deleteImage($image, $dir) {
		try {
			$this->deleteFile ( $dir . '/' . $image );
			$this->deleteFile ( $dir . '/thumb_/thumb_' . $image );
			
			// $logger->writeLog("DEBUG", $userEmail, $arrLog[0], $arrLog[1], "Delete image, file : " . $dir .'/'. $image, ">>");
			// $logger->writeLog("INFO", $userEmail, $arrLog[0], $arrLog[1], "Delete image, file : " . $dir .'/thumb_/thumb_'. $image, ">>");
		} catch ( \Exception $exc ) {
			$this->errorMessage = $exc->getMessage ();
		}
	}
	public function uploadImage($imageData = array(), $dir, $createThumb = true, $options = array()) {
		if (! empty ( $imageData )) {
			$fileName = time () . '.jpg';
			$dirFileName = $dir . '/' . $fileName;
			
			$filter = new \Zend\Filter\File\RenameUpload ( $dirFileName );
			if ($filter->filter ( $imageData )) {
				if ($createThumb) {
					$options = (! empty ( $options )) ? $options : array (
							'max_width' => 65,
							'max_height' => 65,
							'jpeg_quality' => 100 
					);
					$this->createImageThumbnail ( $dirFileName, $dir . '/thumb_', $options );
				}
				
				return $fileName;
			}
		}
		
		return false;
	}
	public function uploadImageAlatca($imageData = array()) {
		if (! empty ( $imageData )) {
			$fileName = time () . '.jpg';
			$dir = ROOT_PATH . UPLOAD_PATH_IMG;
			$dirFileName = $dir . '/' . $fileName;
			
			$filter = new \Zend\Filter\File\RenameUpload ( $dirFileName );
			if ($filter->filter ( $imageData )) {
				$options = array (
						'max_width' => 102,
						'max_height' => 102,
						'jpeg_quality' => 100 
				);
				$this->createImageThumbnail ( $dirFileName, $dir . '/thumb_', $options );
				return $fileName;
			}
		}
		return false;
	}
	public function deleteFile($file_path) {
		if (! empty ( $file_path ) && file_exists ( $file_path )) {
			return @unlink ( $file_path );
		}
		return false;
	}
}
