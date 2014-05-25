<?php
namespace Magazinevietnam\Form;

use Zend\Form\Form;

namespace Magazinevietnam\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class MagazinevietnamForm extends Form
{
	protected $adapter;
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->adapter =$dbAdapter;
        parent::__construct('magazinevietnam');

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
                'value' => 'Go',
                'id' => 'submitbutton',
            	'class'=>"btn btn-primary",
            ),
        ));

    }
    
    public function getNameCatalogueForSelect()
    {
    	$dbAdapter = $this->adapter;
    	$sql       = 'SELECT * FROM catalogue JOIN magazinevietnam  ON catalogue.id=magazinevietnam.patient_id';
    	$statement = $dbAdapter->query($sql);
    	$result    = $statement->execute();
    
    	$selectData = array();
    
    	foreach ($result as $res) {
    		$selectData[$res['patient_id']] = $res['id'];
    	}
    	return $selectData;
    }
    
    
    //getidcatalogue
    public function getidcatalogue()
    {
    	$dbAdapter = $this->adapter;
    	$sql       = 'SELECT * FROM catalogue JOIN magazinevietnam  ON catalogue.id=magazinevietnam.patient_id';
    	$statement = $dbAdapter->query($sql);
    	$result    = $statement->execute();
    
    	foreach ($result as $res) {
    		$id = $res['patient_id'];
    	}
    	return $id;
    }
    
    
}
