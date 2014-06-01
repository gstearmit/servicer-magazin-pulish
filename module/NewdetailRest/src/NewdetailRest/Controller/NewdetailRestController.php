<?php

namespace NewdetailRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;


use News\Model\News;          // <-- Add this import
use News\Form\NewsForm;  
//use News\Model\News;      // <-- Add this import
use News\Model\NewsTable;     // <-- Add this import
use Zend\View\Model\JsonModel;

class NewdetailRestController extends AbstractRestfulController
{
    protected $NewsTable;

    public function getList()
    {
    	//echo 'get list';
    	$results = $this->getNewsTable()->fetchAllOrderbyiddesc();
        $data = array();
        foreach($results as $result) 
        {
            $data[] = $result;
        }

        return new JsonModel(array(
            'data' => $data,
        ));
    }

    public function get($id)
    {
//     	echo "Get Id tra ve";
//     	echo "</br>";
    	
       // $News = $this->getNewsTable()->getRestNews($id);
        $News = $this->getNewsTable()->getrestNews($id);
        //var_dump($news);die();
        return new JsonModel(array(
            'data' => $News,
        ));
    }
    
    

    public function create($data)
    {
        $form = new NewsForm();
        $News = new News();
        $form->setInputFilter($News->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $News->exchangeArray($form->getData());
            $id = $this->getNewsTable()->saveNews($News);
        }

        return new JsonModel(array(
            'data' => $this->get($id),
        ));
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        $News = $this->getNewsTable()->getNews($id);
        $form  = new NewsForm();
        $form->bind($News);
        $form->setInputFilter($News->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $id = $this->getNewsTable()->saveNews($form->getData());
        }

        return new JsonModel(array(
            'data' => $this->get($id),
        ));
    }

    public function delete($id)
    {
        $this->getNewsTable()->deleteNews($id);

        return new JsonModel(array(
            'data' => 'deleted',
        ));
    }

    public function getNewsTable()
    {
        if (!$this->NewsTable) {
            $sm = $this->getServiceLocator();
            $this->NewsTable = $sm->get('News\Model\NewsTable');
        }
        return $this->NewsTable;
    }
}