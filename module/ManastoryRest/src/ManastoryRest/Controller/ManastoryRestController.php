<?php

namespace ManastoryRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;


use Manastory\Model\Manastory;          // <-- Add this import
use Manastory\Form\ManastoryForm;       // <-- Add this import
use Manastory\Model\ManastoryTable;     // <-- Add this import
use Zend\View\Model\JsonModel;

class ManastoryRestController extends AbstractRestfulController
{
    protected $manastoryTable;

    public function getList()
    {
    	//$results = $this->getManastoryTable()->fetchAll(); //ASC id
    	$results = $this->getManastoryTable()->fetchAllOrderbyiddesc();
        $data = array();
        foreach($results as $result) {
            $data[] = $result;
        }

        return new JsonModel(array(
            'data' => $data,
        ));
    }

    public function get($id)
    {
        $manastory = $this->getManastoryTable()->getRestManastory($id);
        //var_dump($manastory);die();
        return new JsonModel(array(
            'data' => $manastory,
        ));
    }

    public function create($data)
    {
        $form = new ManastoryForm();
        $manastory = new Manastory();
        $form->setInputFilter($manastory->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $manastory->exchangeArray($form->getData());
            $id = $this->getManastoryTable()->saveManastory($manastory);
        }

        return new JsonModel(array(
            'data' => $this->get($id),
        ));
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        $manastory = $this->getManastoryTable()->getManastory($id);
        $form  = new ManastoryForm();
        $form->bind($manastory);
        $form->setInputFilter($manastory->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $id = $this->getManastoryTable()->saveManastory($form->getData());
        }

        return new JsonModel(array(
            'data' => $this->get($id),
        ));
    }

    public function delete($id)
    {
        $this->getManastoryTable()->deleteManastory($id);

        return new JsonModel(array(
            'data' => 'deleted',
        ));
    }

    public function getManastoryTable()
    {
        if (!$this->manastoryTable) {
            $sm = $this->getServiceLocator();
            $this->manastoryTable = $sm->get('Manastory\Model\ManastoryTable');
        }
        return $this->manastoryTable;
    }
}