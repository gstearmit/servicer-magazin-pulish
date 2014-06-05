<?php
namespace ManaStory\Form;

use Zend\Form\Form;

namespace Manastory\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class ManaStorySearchForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('manastory');

        $this->setAttribute('method', 'post');
        //$this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'form-horizontal');
        
        $title = new Element\Text('title');
        $title->setLabel('Title')
        ->setAttribute('class', 'required')
        ->setAttribute('placeholder', 'Title');
        
        $description = new Element\Text('descriptionkey');
        $description->setLabel('Description')
        ->setAttribute('class', 'required')
        ->setAttribute('placeholder', 'description');
        
        
        
        $submit = new Element\Submit('submit');
        $submit->setValue('Search')
        ->setAttribute('class', 'btn btn-primary');
        
        
        $this->add($description);
        $this->add($title);
        
        $this->add($submit);

    }
}
