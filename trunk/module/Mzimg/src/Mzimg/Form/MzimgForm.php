<?php
namespace Mzimg\Form;

use Zend\Form\Form;

class MzimgForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('mzimg');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

       $this->add(array(
           'name' => 'idmz',
           'attributes' => array(
               'type'  => 'text',
           ),
           'options' => array(
               'label' => 'idmz',
           ),
       ));
       
       $this->add(array(
       		'type' => 'Zend\Form\Element\Select',
       		'name' => 'cataloguemagazine',
       		'options' => array(
       				'label' => 'Cataloguemagazine',
       				'value_options' => array(
       						'1' => 'catalogue',
       						'2' => 'catalogue 2',
       						'3' => 'catalogue 3'
       				),
       		),
       		'attributes' => array(
       				'value' => '1' //set selected to '1'
       		)
       ));
       
       $this->add(array(
       		'type' => 'Zend\Form\Element\Date',
       		'name' => 'date',
       		'options' => array(
       				'label' => 'Date'
       		)
       ));

        $this->add(array(
            'name' => 'img',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Thumbnail',
            ),
        ));
        
        $this->add(array(
        		'name' => 'description',
        		'attributes' => array(
        				'type'  => 'text',
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
            ),
        ));

    }
}
