<?php

namespace Upload\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Upload\Form\UploadForm;
use Zend\Filter\Compress\zip;

use Zend\Filter\Exception;
use ZipArchive;

class UploadController extends AbstractActionController {
	public function indexAction() {
		$form = new UploadForm ();
		$view = new ViewModel ( array (
				'form' => $form 
		) );
		$request = $this->getRequest ();
		
		if ($request->isPost ()) {
			
			$files = $request->getFiles ()->toArray ();
			$fileName = $files ['picture'] ['name'];
			
			$uploadObj = new \Zend\File\Transfer\Adapter\Http ();
			$uploadObj->setDestination ( MZIMG_PATH );
			
			if ($uploadObj->receive ( $fileName )) {
				echo "<br>Upload success";
			}
		}
		
		return $view;
	}
	public function abcAction() {
		$form = new UploadForm ();
		$view = new ViewModel ( array (
				'form' => $form 
		) );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			echo 'Tap tin vua upload len server la: ';
			echo $form->upload ( $request->getFiles ()->toArray (), MZIMG_PATH );
		}
		
		return $view;
	}
	public function multiAction() {
		$form = new \Upload\Form\MultiUploadForm ();
		$view = new ViewModel ( array (
				'form' => $form 
		) );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			
			echo 'Tap tin vua upload len server la: ';
			$files = $form->upload ( $request->getFiles ()->toArray (), FILES_PATH );
			
			echo "<pre>";
			print_r ( $files );
			echo "</pre>";
		}
		
		return $view;
	}
	public function uploadnewAction() 
	{
		$form = new UploadForm ();
		$view = new ViewModel ( array (
				'form' => $form 
		) );
// 		$request = $this->getRequest ();
		
// 		if ($request->isPost ()) {
			
// 			$files = $request->getFiles ()->toArray ();
// 			$fileName = $files ['picture'] ['name'];
			
// 			$uploadObj = new \Zend\File\Transfer\Adapter\Http ();
// 			$uploadObj->setDestination ( MZIMG_PATH );
			
// 			if ($uploadObj->receive ( $fileName )) {
// 				echo "<br>Upload success";
// 			}
// 		}
		
		
	 if (!empty($_FILES))
	 { 		
		if ($_FILES ["zip_file"] ["name"]) {
			$filename = $_FILES ["zip_file"] ["name"];
			$source = $_FILES ["zip_file"] ["tmp_name"];
			$type = $_FILES ["zip_file"] ["type"];
			
			$name = explode ( ".", $filename );
			$accepted_types = array (
					'application/zip',
					'application/x-zip-compressed',
					'multipart/x-zip',
					'application/x-compressed' 
			);
			foreach ( $accepted_types as $mime_type ) {
				if ($mime_type == $type) {
					$okay = true;
					break;
				}
			}
			// kiem tra xem file upload len co phai la file zip khong
			$continue = strtolower ( $name [1] ) == 'zip' ? true : false;
			if (! $continue) {
				$myMsg = "Please upload a valid .zip file.";
			}
			
			/* PHP current path */
			$path = dirname ( __FILE__ ) . '/';
			$filenoext = basename ( $filename, '.zip' );
			$filenoext = basename ( $filenoext, '.ZIP' );
			
			$myDir = $path . $filenoext; // target directory
			$myFile = $path . $filename; // target zip file
			
			if (is_dir ( $myDir ))
				$this->recursive_dir ( $myDir );
			mkdir ( $myDir, 0777 );
			
			if (move_uploaded_file ( $source, $myFile )) {
				$zip = new ZipArchive ();
				
				$x = $zip->open ( $myFile ); // open the zip file to extract
				if ($x === true) {
					$zip->extractTo ( $myDir ); // place in the directory with same name
					$zip->close ();
					unlink ( $myFile );
				}
				echo $myMsg = "Your .zip file uploaded and unziped.";
			} else {
				echo $myMsg = "There was a problem with the upload.";
			}
		}
		
	 }//end if empty	
		
		return $view;
	}
	
	public function recursive_dir($dir) {
		foreach ( scandir ( $dir ) as $file ) {
			if ('.' === $file || '..' === $file)
				continue;
			if (is_dir ( "$dir/$file" ))
				recursive_dir ( "$dir/$file" );
			else
				unlink ( "$dir/$file" );
		}
		rmdir ( $dir );
	}
}
