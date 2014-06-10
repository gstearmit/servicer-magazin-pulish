<?php

namespace Storydetail\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Storydetail implements InputFilterAwareInterface
{
    public $id;
    public $idmz;
    public $img;
	public $description;
    public $title;
	public $page;

    protected $inputFilter;

    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
       	$this->idmz = (isset($data['idmz'])) ? $data['idmz'] : null;
		$this->img = (isset($data['img'])) ? $data['img'] : null;
		$this->description  = (isset($data['description'])) ? $data['description'] : null;
        $this->title  = (isset($data['title'])) ? $data['title'] : null;
        $this->page  = (isset($data['page'])) ? $data['page'] : null;
      
    }
    
    public function dataArray($data)
    {
    	$this->id     = (isset($data['id'])) ? $data['id'] : null;
    	$this->idmz = (isset($data['idmz'])) ? $data['idmz'] : null;
    	$this->img = (isset($data['img']['name'])) ? $data['img']['name'] : null;
    	$this->description  = (isset($data['description'])) ? $data['description'] : null;
    	$this->title  = (isset($data['title'])) ? $data['title'] : null;
    	$this->page  = (isset($data['page'])) ? $data['page'] : null;
    
    }
    
    public function dataArraySwap($data , $Renamefile)
    {
    	$this->id     = (isset($data['id'])) ? $data['id'] : null;
    	$this->idmz = (isset($data['idmz'])) ? $data['idmz'] : null;
    	$this->img = $Renamefile;
    	$this->description  = (isset($data['description'])) ? $data['description'] : null;
    	$this->title  = (isset($data['title'])) ? $data['title'] : null;
    	$this->page  = (isset($data['page'])) ? $data['page'] : null;	
    }
    
    public function dataPost($data)
    {
    	$this->id     = (isset($data['id'])) ? $data['id'] : null;
    	$this->idmz = (isset($data['idmz'])) ? $data['idmz'] : null;
    	$this->img = (isset($data['img']['name'])) ? $data['img']['name'] : null;
    	$this->description  = (isset($data['description'])) ? $data['description'] : null;
    	$this->title  = (isset($data['title'])) ? $data['title'] : null;
    	$this->page  = (isset($data['page'])) ? $data['page'] : null;
    
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'idmz',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));
            

           $inputFilter->add ( $factory->createInput ( array (
					'name' => 'img',
					'required' => true,
					'validators' => array (
							array (
									'name' => 'FileExtension',
									'options' => array (
											'extension' => 'jpg, jpeg, png' 
									) 
							),
							array (
									'name' => 'FileSize',
									'options' => array (
											'min' => 1000,
											'max' => 4000000 
									) 
							)
						
					) ,
			) ) );
            
			$inputFilter->add($factory->createInput(array(
            		'name'     => 'description',
            		'required' => false,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
            						'name'    => 'StringLength',
            						'options' => array(
            								'encoding' => 'UTF-8',
            								'min'      => 1,
            								'max'      => 4000000,
            						),
            				),
            		),
            )));
			
            $inputFilter->add($factory->createInput(array(
            		'name'     => 'title',
            		'required' => true,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
            						'name'    => 'StringLength',
            						'options' => array(
            								'encoding' => 'UTF-8',
            								'min'      => 1,
            								'max'      => 100,
            						),
            				),
            		),
            )));
			
			$inputFilter->add($factory->createInput(array(
            		'name'     => 'page',
            		'required' => false,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
            						'name'    => 'StringLength',
            						'options' => array(
            								'encoding' => 'UTF-8',
            								'min'      => 1,
            								'max'      => 100,
            						),
            				),
            		),
            )));
			
			

            $this->inputFilter = $inputFilter;        
        }

        return $this->inputFilter;
    }
}
