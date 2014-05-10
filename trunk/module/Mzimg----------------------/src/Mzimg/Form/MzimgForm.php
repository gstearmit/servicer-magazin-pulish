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
            'name' => 'idmzalbum',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
		
		$this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'img',
            'attributes' => array(
                'type'  => 'img',
            ),
            'options' => array(
                'label' => 'img',
            ),
        ));

        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'description',
            ),
        ));
		
		$this->add(array(
            'name' => 'page',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'page',
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
