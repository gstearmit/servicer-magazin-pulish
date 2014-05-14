<?php

namespace Mzimg\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Mzimg implements InputFilterAwareInterface
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
            

            $inputFilter->add($factory->createInput(array(
                'name'     => 'img',
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
            		'name'     => 'description',
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
            		'name'     => 'cataloguemagazine',
            		'validators' => array(
            				array(
            						'name'    => 'InArray',
            						'options' => array(
            								'haystack' => array(2,3),
            								'messages' => array(
            										'notInArray' => 'Please select your catalogue magazine !'
            								),
            						),
            				),
            		),
            )));
            
            
            $inputFilter->add($factory->createInput(array(
            		'name'     => 'date',
            		'validators' => array(
            				array(
            						'name'    => 'Between',
            						'options' => array(
            								'min' => '1970-01-01',
            								'max' => date('Y-m-d')
            						),
            				),
            		),
            )));

            $this->inputFilter = $inputFilter;        
        }

        return $this->inputFilter;
    }
}
