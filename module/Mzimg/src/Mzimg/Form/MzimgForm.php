<?php
namespace Mzimg\Form;

use Zend\Form\Form;
// use Zend\Db\TableGateway\AbstractTableGateway;
// use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class MzimgForm extends Form
{
	protected $id;
	protected $adapter;
    public function __construct(AdapterInterface $dbAdapter ,$id = Null)
    {
    	$this->adapter =$dbAdapter;
        $this->id = (int)$id;
        parent::__construct('mzimg');

        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

    
        $id_default  = ($this->id)== 0 ? '1' : $this->id;
        $this->add(array(
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'idmz',
        		'options' => array(
        				'label' => 'Mzimg Select ',
        				'empty_option' => 'Please select an Magazine',
        				//'value_options' => $this->fetchAllCatalogue()
        				'value_options' => $this->getOptionsForSelect()
        		),
        		'attributes' => array(
        				'value' => $id_default, //set selected to '1'
        				'inarrayvalidator' => true,
        				'required' => 'required',
        		)
        ));

        $this->add(array(
            'name' => 'img',
            'attributes' => array(
                'type'  => 'file',
            		'required' => 'required',
            ),
            'options' => array(
                'label' => 'Upload images',
            ),
        ));
        
        $this->add(array(
        		'name' => 'imgedit',
        		'attributes' => array(
        				'type'  => 'file',
        				'required' => 'required',
        		),
        		'options' => array(
        				'label' => 'Upload images',
        		),
        ));
        
        $this->add(array(
        		'name' => 'description',
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
        		'name' => 'page',
        		'attributes' => array(
        				'type'  => 'text',
        		),
        		'options' => array(
        				'label' => 'Page',
        		),
        ));
        
        
       

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            	'class' => 'btn btn-primary',
            ),
        ));

    }
    
    public function getOptionsForSelect()
    {
    	$dbAdapter = $this->adapter;
    	$sql       = 'SELECT * FROM `magazinepublish`';
    	$statement = $dbAdapter->query($sql);
    	$result    = $statement->execute();
    
    	$selectData = array();
    	if(is_array($result) and !empty($result))
    	{
	    	foreach ($result as $res) {
	    		$selectData[$res['id']] = $res['title'];
	    	}
	    }else  $selectData = 0;
    	return $selectData;
    }
    
    
    public function fetchAllCatalogue() {
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->columns(array());
    	$select->from ('mzimg')
    	->join('magazinepublish', 'mzimg.idmz=magazinepublish.id',array('id'=>'id','title'=>'title'));
    	$selectString = $sql->prepareStatementForSqlObject($select);
    	//return $selectString;die;
    	$results = $selectString->execute();
    
    	// swap
    	$array = array();
    	foreach ($results as $result)
    	{
    		$tmp = array();
    		$tmp[$result['id']]= $result['title'];
    		$array[] = $tmp;
    	}

    	return $array;
    
    }
}
