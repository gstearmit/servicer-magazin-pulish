<?php
namespace Magazinepublish\Form;

use Zend\Form\Form;


use Zend\Captcha;
use Zend\Form\Element;


use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class MagazinepublishForm extends Form
{
	protected $adapter;
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->adapter =$dbAdapter;
        parent::__construct('magazinepublish');

        $this->setAttribute('method', 'post');
       // $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        $defaul = $this->getidcatalogue();
        
        $this->add(array(
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'patient_id',
        		'options' => array(
        				'label' => 'Select a category father ',
        				'empty_option' => 'Please Select a category father',
        				'value_options' => $this->getNameCatalogueForSelect()
        		),
        		'attributes' => array(
        				'value' => $defaul, //set selected to '1'
        				'inarrayvalidator' => true,
        
        		)
        ));

        $this->add(array(
            'name' => 'descriptionkey',
            'attributes' => array(
                'type'  => 'textarea',
            		'required' => 'required',
            ),
            'options' => array(
                'label' => 'Description',
            ),
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
            		'required' => 'required',
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        
        $this->add(array(
        		'name' => 'imgkey',
        		'attributes' => array(
        				'type'  => 'file',
        				'required' => 'required',
        		),
        		'options' => array(
        				'label' => 'Upload images  ',
        		),
        ));
   
  //imgkeyedit 
        $this->add(array(
        		'name' => 'imgkeyedit',
        		'attributes' => array(
        				'type'  => 'file',
        				//'required' => 'required',
        		),
        		'options' => array(
        				'label' => 'Upload images  ',
        		),
        ));
        
        
        
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            	'class'=>"btn btn-primary",
            ),
        ));

    }
    
    public function getNameCatalogueForSelect()
    {
    	$dbAdapter = $this->adapter;
    	$sql       = 'SELECT * FROM catalogue';
    	$statement = $dbAdapter->query($sql);
    	$result    = $statement->execute();
    
    	$selectData = array();
    
    	foreach ($result as $res) {
    		$selectData[$res['id']] = $res['title'];
    	}
    	return $selectData;
    }
    
    
    //getidcatalogue
    public function getidcatalogue()
    {
    	$dbAdapter = $this->adapter;
    	$sql       = 'SELECT * FROM catalogue JOIN magazinepublish  ON catalogue.id=magazinepublish.patient_id';
    	$statement = $dbAdapter->query($sql);
    	$result    = $statement->execute();
    
    	if( is_array($result) and !empty($result))
    	{
	    	foreach ($result as $res) {
	    		$id = $res['patient_id'];
	    	}
    	}else $id = 0;
    	return $id;
    }
    
    
}
