<?php
namespace Upload\Form;


use Zend\Form\Form;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class UploadForm extends Form
{  
    protected $adapter;
    public function __construct(AdapterInterface $dbAdapter)
    {
    	$this->adapter =$dbAdapter;
        parent::__construct('upload');
		
        $this->setAttribute('method', 'post');       
        //$this->setAttribute('class', 'form-horizontal');
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
        		'name' => 'id',
        		'attributes' => array(
        				'type'  => 'hidden',
        		),
        ));
        
//         $defaul = $this->getidcatalogue();
        
//         $this->add(array(
//         		'type' => 'Zend\Form\Element\Select',
//         		'name' => 'patient_id',
//         		'options' => array(
//         				'label' => 'Select a category father ',
//         				'empty_option' => 'Please Select a category father',
//         				'value_options' => $this->getNameCatalogueForSelect()
//         		),
//         		'attributes' => array(
//         				'value' => $defaul, //set selected to '1'
//         				'inarrayvalidator' => true,
        
//         		)
//         ));
        
        $this->add(array(
        		'name' => 'descriptionkey',
        		'attributes' => array(
        				'type'  => 'textarea',
        		),
        		'options' => array(
        				'label' => 'Description',
        		),
        ));
        
        $this->add(array(
        		'name' => 'title',
        		'attributes' => array(
        				'type'  => 'text',
        		),
        		'options' => array(
        				'label' => 'Title',
        		),
        ));
        
        $this->add(array(
        		'name' => 'imgkey',
        		'attributes' => array(
        				'type'  => 'file',
        		),
        		'options' => array(
        				'label' => 'Upload images description ',
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
    
    public function getNameCatalogueForSelect()
    {
    	$dbAdapter = $this->adapter;
    	$sql       = 'SELECT * FROM upload JOIN uploaddetail  ON upload.id=uploaddetail.idmz';
    	$statement = $dbAdapter->query($sql);
    	$result    = $statement->execute();
    
    	$selectData = array();
    
    	foreach ($result as $res) {
    		$selectData[$res['idmz']] = $res['id'];
    	}
    	return $selectData;
    }
    
    
    //getidcatalogue
    public function getidcatalogue()
    {
    	$dbAdapter = $this->adapter;
    	$sql       = 'SELECT * FROM upload JOIN uploaddetail  ON upload.id=uploaddetail.idmz';
    	$statement = $dbAdapter->query($sql);
    	$result    = $statement->execute();
    
    	if(is_array($result) and !empty($result))
    	{	
	    	foreach ($result as $res) 
	    	{
	    		if($res['id'] != '')
	    		{
	    		  $id = $res['id'];
	    		}
	    	}
    	}else $id = 0;
    	return $id;
    }
}
