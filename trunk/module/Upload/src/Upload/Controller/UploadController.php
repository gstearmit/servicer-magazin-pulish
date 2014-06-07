<?php

namespace Upload\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Upload\Form\UploadForm;
use Zend\Filter\Compress\zip;

use Zend\Filter\Exception;
use ZipArchive;
use Upload\Model\Upload;

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
			
// 			echo "<pre>";
// 			print_r ( $files );
// 			echo "</pre>";
		}
		
		return $view;
	}
	public function uploadnewAction() 
	{
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$form = new UploadForm ($dbAdapter);
		
		
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
				if ($mime_type == $type) 
				{
					$okay = true;
					break;
				}
			}
			//check file zip
			$continue = strtolower ( $name [1] ) == 'zip' ? true : false;
			

			if (! $continue) {
				$myMsg = "Please upload a valid .zip file.";
				$backUrl = $this->url()->fromRoute('upload', array('action' => 'uploadnew', 'id' => null), array(), true);
				die("Please upload a valid .zip file. Oops! This project has not Support!" );
			}
			
		
			$path = ROOT_PATH.PATH_ZIP;
		
			$filenoext = basename ( $filename, '.zip' );
			$filenoext = basename ( $filenoext, '.ZIP' );
			
			$myDir = $path . $filenoext; // target directory
			$myFile = $path . $filename; // target zip file
			
			if (is_dir ( $myDir ))
			{
				$this->recursive_dir ( $myDir );
			    mkdir ( $myDir, 0777 );
			}
// 			elseif(is_dir ( $myDir ) === false)
// 			{
// 				//var_dump($path);
// 				die("Oop ! Error , Directoty of Project upload  is Exits !");
// 			}
			
			
			$dirimg = $path.$name[0];

			if (move_uploaded_file ( $source, $myFile ))
			 {
				$zip = new ZipArchive ();
				
				$x = $zip->open ( $myFile ); // open the zip file to extract
				if ($x === true) {
					$zip->extractTo ( $myDir ); // place in the directory with same name
					$zip->close ();
					unlink ( $myFile );
				}
			
				//Rename All 
				$rename = $this->sequentialImages($dirimg,false);
			
				// Read File 
				$imgArray = $this->readallimg($dirimg);
				
// 				echo '<pre>';
// 				print_r($imgArray);
// 				echo '</pre>';
// 				die;
				
				// save file in database
// 				foreach ($imgArray as $keyimg)
// 				{
					
// 				}

				
				
				//Upload
				$form->get ( 'submit' )->setAttribute ( 'value', 'Upload' );
				
				$request = $this->getRequest ();
				
				if ($request->isPost ())
				{
		
					$upload = new Upload();
				
					$form->setInputFilter ( $upload->getInputFilter () ); // check validate
				
					$data = array_merge_recursive ( $this->getRequest ()->getPost ()->toArray (), $this->getRequest ()->getFiles ()->toArray () );
				
					$form->setData ( $data ); // get all post
					
					
					echo 'data';
					echo '<pre>';
					print_r($data);
					echo '</pre>';
					
					echo 'validtae form';
					var_dump($form->isValid());
					die;
					
					
					// Validate the form
					if ($form->isValid()) {
						$validatedData = $form->getData();
						
						echo 'Validate';
						echo '<pre>';
						print_r($validatedData);
						echo '</pre>';
						die;
						
					} else {
						$messages = $form->getMessages();
						//die($messages);
					}	
					
					
				
				}
				
				
				
				
				echo $myMsg = "Your .zip file uploaded and unziped.";
				
				
			} else {
				echo $myMsg = "There was a problem with the upload.";
			}
		}
		
	 }//end if empty	
		
	 $view = new ViewModel ( array (
	 		'form' => $form
	 ) );
	 
		
		 return $view;
		
		
		
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
	
	public function sequentialImages($path, $sort=false) {
		$i = 1;
		
		//burg only suport file .JPG
		//$files = glob($path.'{*.gif,*.jpg,*.jpeg,*.png}',GLOB_BRACE|GLOB_NOSORT);
		
		$files = glob($path.'/*.JPG',GLOB_BRACE|GLOB_NOSORT);
	
		if ( $sort !== false ) {
			usort($files, $sort);
		}
	
		$count = count($files);
		
		//return $files;
		
		foreach ( $files as $file ) {
			$newname = str_pad($i, strlen($count)+1, '0', STR_PAD_LEFT);
			$ext = substr(strrchr($file, '.'), 1);
			$newname = $path.'/'.$newname.'.'.$ext;
			if ( $file != $newname ) {
				rename($file, $newname);
			}
			$i++;
		}
	}
	
	public function sort_by_mtime($file1, $file2) {
		$time1 = filemtime($file1);
		$time2 = filemtime($file2);
		if ( $time1 == $time2 ) {
			return 0;
		}
		return ($time1 < $time2) ? 1 : -1;
	}
	
	
	public function readallimg($dir = null)
	{
		if($dir !== Null)
		{
			if ($opendir = opendir($dir))
			{
			
				$images=array();
				while (($file = readdir($opendir)) !==FALSE)
				{
					if($file != "." && $file != "..")
					{
						$images["$file"]=$file;
					}
				}
			}
			sort($images,SORT_STRING);
			
			// Renname
			foreach ($images as $image)
			{
				//rename($image, "/home/user/login/docs/my_file.txt");
			}
			
	   }
		
		return $images;
		
// 		foreach($images as $image)
// 		{
// 			echo "<img src='$dir/$image'><br>\n";
// 		}
		
	}
}
