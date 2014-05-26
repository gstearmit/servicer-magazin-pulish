<?php

namespace LibrarybooksRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;


use Librarybooks\Model\Librarybooks;          // <-- Add this import
use Librarybooks\Form\LibrarybooksForm;       // <-- Add this import
use Librarybooks\Model\LibrarybooksTable;     // <-- Add this import
use Zend\View\Model\JsonModel;

class LibrarybooksRestController extends AbstractRestfulController
{
    protected $librarybooksTable;

    public function getList()
    {
    	//$results = $this->getLibrarybooksTable()->fetchAll(); //ASC id
    	$results = $this->getLibrarybooksTable()->fetchAllOrderbyiddesc();
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
        $librarybooks = $this->getLibrarybooksTable()->getRestLibrarybooks($id);
        //var_dump($librarybooks);die();
        return new JsonModel(array(
            'data' => $librarybooks,
        ));
    }

    public function create($data)
    {
        $form = new LibrarybooksForm();
        $librarybooks = new Librarybooks();
        $form->setInputFilter($librarybooks->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $librarybooks->exchangeArray($form->getData());
            $id = $this->getLibrarybooksTable()->saveLibrarybooks($librarybooks);
        }

        return new JsonModel(array(
            'data' => $this->get($id),
        ));
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        $librarybooks = $this->getLibrarybooksTable()->getLibrarybooks($id);
        $form  = new LibrarybooksForm();
        $form->bind($librarybooks);
        $form->setInputFilter($librarybooks->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $id = $this->getLibrarybooksTable()->saveLibrarybooks($form->getData());
        }

        return new JsonModel(array(
            'data' => $this->get($id),
        ));
    }

    public function delete($id)
    {
        $this->getLibrarybooksTable()->deleteLibrarybooks($id);

        return new JsonModel(array(
            'data' => 'deleted',
        ));
    }

    public function getLibrarybooksTable()
    {
        if (!$this->librarybooksTable) {
            $sm = $this->getServiceLocator();
            $this->librarybooksTable = $sm->get('Librarybooks\Model\LibrarybooksTable');
        }
        return $this->librarybooksTable;
    }
}