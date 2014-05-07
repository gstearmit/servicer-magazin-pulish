<?php

namespace MagazinePublishRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

use Magazinepublish\Model\Magazinepublish;          // <-- Add this import
use Magazinepublish\Form\MagazinepublishForm;       // <-- Add this import
use Magazinepublish\Model\MagazinepublishTable;     // <-- Add this import
use Zend\View\Model\JsonModel;

class MagazinePublishRestController extends AbstractRestfulController
{
    protected $magazinepublishTable;

    public function getList()
    {
        $results = $this->getMagazinepublishTable()->fetchAll();
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
        $magazinepublish = $this->getMagazinepublishTable()->getMagazinepublish($id);

        return new JsonModel(array(
            'data' => $magazinepublish,
        ));
    }

    public function create($data)
    {
        $form = new MagazinepublishForm();
        $magazinepublish = new Magazinepublish();
        $form->setInputFilter($magazinepublish->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $magazinepublish->exchangeArray($form->getData());
            $id = $this->getMagazinepublishTable()->saveMagazinepublish($magazinepublish);
        }

        return new JsonModel(array(
            'data' => $this->get($id),
        ));
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        $magazinepublish = $this->getMagazinepublishTable()->getMagazinepublish($id);
        $form  = new MagazinepublishForm();
        $form->bind($magazinepublish);
        $form->setInputFilter($magazinepublish->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $id = $this->getMagazinepublishTable()->saveMagazinepublish($form->getData());
        }

        return new JsonModel(array(
            'data' => $this->get($id),
        ));
    }

    public function delete($id)
    {
        $this->getMagazinepublishTable()->deleteMagazinepublish($id);

        return new JsonModel(array(
            'data' => 'deleted',
        ));
    }

    public function getMagazinepublishTable()
    {
        if (!$this->magazinepublishTable) {
            $sm = $this->getServiceLocator();
            $this->magazinepublishTable = $sm->get('Magazinepublish\Model\MagazinepublishTable');
        }
        return $this->magazinepublishTable;
    }
}