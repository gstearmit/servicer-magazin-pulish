<?php

namespace News\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class News implements InputFilterAwareInterface
{
    public $id;
	public $name;
	public $brief;
	public $description;
	public $category_id;
	public $image_url;
	public $user_id;
	protected $inputFilter;
  

    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data)
    {
       $this->id = (isset ( $data ['id'] )) ? $data ['id'] : null;
		$this->brief = (isset ( $data ['brief'] )) ? $data ['brief'] : null;
		$this->description = (isset ( $data ['description'] )) ? $data ['description'] : null;
		$this->name = (isset ( $data ['name'] )) ? $data ['name'] : null;
		$this->category_id = (isset ( $data ['category_id'])) ? $data ['category_id'] : null;
		$this->image_url = (isset ( $data ['image_url'])) ? $data ['image_url'] : null;
		$this->user_id = (isset ( $data ['user_id'])) ? $data ['user_id'] : null;
      
    }
    
    public function dataArray($data)
    {
    	$this->id = (isset ( $data ['id'] )) ? $data ['id'] : null;
		$this->brief = (isset ( $data ['brief'] )) ? $data ['brief'] : null;
		$this->description = (isset ( $data ['description'] )) ? $data ['description'] : null;
		$this->name = (isset ( $data ['name'] )) ? $data ['name'] : null;
		$this->category_id = (isset ( $data ['category_id'])) ? $data ['category_id'] : null;
		$this->image_url = (isset ( $data ['image_url'])) ? $data ['image_url'] : null;
		$this->user_id = (isset ( $data ['user_id'])) ? $data ['user_id'] : null;
    
    }
    
    public function dataPost($data)
    {
    	$this->id = (isset ( $data ['id'] )) ? $data ['id'] : null;
		$this->brief = (isset ( $data ['brief'] )) ? $data ['brief'] : null;
		$this->description = (isset ( $data ['description'] )) ? $data ['description'] : null;
		$this->name = (isset ( $data ['name'] )) ? $data ['name'] : null;
		$this->category_id = (isset ( $data ['category_id'])) ? $data ['category_id'] : null;
		$this->image_url = (isset ( $data ['image_url'])) ? $data ['image_url'] : null;
		$this->user_id = (isset ( $data ['user_id'])) ? $data ['user_id'] : null;
    
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
        if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			
			$factory = new InputFactory ();
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'id',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'Int' 
							) 
					) 
			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'description',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					),
					'validators' => array (
							array (
									'name' => 'StringLength',
									'options' => array (
											'encoding' => 'UTF-8',
											'min' => 1,
											'max' => 100 
									) 
							) 
					) 
			) ) );
	
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'image_url',
					'required' =>false,
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
									),
									array (
											'name' => 'StringLength',
											'options' => array (
													'encoding' => 'UTF-8',
													'min' => 1,
													'max' => 100
											),
							) 
					) 
			) ) )
			);
			
			//public $patient_id;
	        //public $url_catalogue;
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'name',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					),
					'validators' => array (
							array (
									'name' => 'StringLength',
									'options' => array (
											'encoding' => 'UTF-8',
											'min' => 1,
											'max' => 100 
									) 
							) 
					) 
			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'brief',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
					'validators' => array (
							array (
									'name' => 'StringLength',
									'options' => array (
											'encoding' => 'UTF-8',
											'min' => 1,
											'max' => 100
									)
							)
					)
			) ) );
			
			
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'category_id',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'Int'
							)
					)
			) ) );
			

            $this->inputFilter = $inputFilter;        
        }

        return $this->inputFilter;
    }
}
