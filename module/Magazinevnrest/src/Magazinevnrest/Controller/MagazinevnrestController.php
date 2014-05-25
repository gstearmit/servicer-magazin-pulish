<?php

namespace Magazinevnrest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;


use Magazinevietnam\Model\Magazinevietnam;          // <-- Add this import
use Magazinevietnam\Form\MagazinevietnamForm;       // <-- Add this import
use Magazinevietnam\Model\MagazinevietnamTable;     // <-- Add this import
use Zend\View\Model\JsonModel;

class MagazinevnrestController extends AbstractRestfulController
{
    protected $magazinevietnamTable;

    public function getList()
    {
    	//$results = $this->getMagazinevietnamTable()->fetchAll(); //ASC id
    	$results = $this->getMagazinevietnamTable()->fetchAllOrderbyiddesc();
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
        $magazinevietnam = $this->getMagazinevietnamTable()->getRestMagazinevietnam($id);
        //var_dump($magazinevietnam);die();
        return new JsonModel(array(
            'data' => $magazinevietnam,
        ));
    }

    public function create($data)
    {
        $form = new MagazinevietnamForm();
        $magazinevietnam = new Magazinevietnam();
        $form->setInputFilter($magazinevietnam->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $magazinevietnam->exchangeArray($form->getData());
            $id = $this->getMagazinevietnamTable()->saveMagazinevietnam($magazinevietnam);
        }

        return new JsonModel(array(
            'data' => $this->get($id),
        ));
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        $magazinevietnam = $this->getMagazinevietnamTable()->getMagazinevietnam($id);
        $form  = new MagazinevietnamForm();
        $form->bind($magazinevietnam);
        $form->setInputFilter($magazinevietnam->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $id = $this->getMagazinevietnamTable()->saveMagazinevietnam($form->getData());
        }

        return new JsonModel(array(
            'data' => $this->get($id),
        ));
    }

    public function delete($id)
    {
        $this->getMagazinevietnamTable()->deleteMagazinevietnam($id);

        return new JsonModel(array(
            'data' => 'deleted',
        ));
    }

    public function getMagazinevietnamTable()
    {
        if (!$this->magazinevietnamTable) {
            $sm = $this->getServiceLocator();
            $this->magazinevietnamTable = $sm->get('magazinevietnam\Model\magazinevietnamTable');
        }
        return $this->magazinevietnamTable;
    }
}