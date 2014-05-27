<?php
namespace Upload\Form;


use Zend\Form\Form;

class UploadForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('upload');
		
        $this->setAttribute('method', 'post');       
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('enctype','multipart/form-data');

       
        $this->add(array(
            'name' => 'zip_file',
            'attributes' => array(
                'type'  => 'file',
				'required' => 'required',
            	'class' => 'txtInput txtMedium'
            ),
            'options' => array(
                'label' => 'Upload Zip File',
            ),
        ));
     
        $this->add(array(
        		'name' => 'submit',
        		'attributes' => array(
        				'type'  => 'submit',
        				'value' => 'Upload',
        				'class' => 'btn btn-primary',
        		),
        ));
        
    }
    
    public function upload($files = array(),$file_path = ''){
    	
    	$fileName = '';
    	
    	if(count($files) != 0 && $file_path != ''){
	    	$fileName = $files['picture']['name'];
	    	
	    	$uploadObj = new \Zend\File\Transfer\Adapter\Http();
	    	$uploadObj->setDestination($file_path);
	    	$uploadObj->receive($fileName);
    	}
    	
    	return $fileName;
    }
}
