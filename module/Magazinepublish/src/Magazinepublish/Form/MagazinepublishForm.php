<?php
namespace Magazinepublish\Form;

use Zend\Form\Form;

namespace Magazinepublish\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class MagazinepublishForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('magazinepublish');

        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
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
      /*  
        $this->add(array(
        		'name' => 'imgupload',
        		'type' => 'file',
        		'attributes' => array(
        				'class' => 'imgmagazine',
        				'id' => 'imgmagazine',
        				'required' => 'required',
        		),
        		'options' => array(
        				'label' => 'Img upload',
        		),
        ));
        
        $this->add(array(
        		'name' => 'namemagazine',
        		'type' => 'Zend\Form\Element\Text',
        		'attributes' => array(
        				'class' => 'namemagazine',
        				'id' => 'namemagazine',
        				'placeholder' => 'Name of Magazine public....',
        				'required' => 'required',
        		),
        		'options' => array(
        				'label' => 'Name Magazine',
        		),
        ));
        
        */
       

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
