<?php

namespace Magazinepublish\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Magazinepublish\Model\Magazinepublish;
use Magazinepublish\Form\MagazinepublishForm;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

class MagazinepublishController extends AbstractActionController {

    protected $magazinepublishTable;

    public function indexAction() {
        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $magazinepublishs = $this->getMagazinepublishTable()->fetchAll($select->order($order_by . ' ' . $order));
        $itemsPerPage = 10; // là số record ta muốn hiện trên mỗi trang.

        $magazinepublishs->current();
        $paginator = new Paginator(new paginatorIterator($magazinepublishs));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(4); //là số trang chúng ta muốn hiển thị

        return new ViewModel(array(
                    'order_by' => $order_by,
                    'order' => $order,
                    'page' => $page,
                    'paginator' => $paginator,
                ));
    }

    public function addAction() {
    	
        $form = new MagazinepublishForm(); // goi doi tuong form da dinh nghia
        $form->get('submit')->setAttribute('value', 'Add');
        
        

        $request = $this->getRequest();
       
       
        
        
        if ($request->isPost()) {
        	
            $magazinepublish = new Magazinepublish();
            /*
           echo '<pre>';
	        print_r($request->getPost());
	        echo '</pre>';
	        die();
	        
            echo '<pre>';
            print_r($form->getData());
            echo '</pre>';
            die();
            */
            
            
            
            $form->setInputFilter($magazinepublish->getInputFilter());  // ? 
            
            $form->setData($request->getPost());  // lay het cac post
            
            if ($form->isValid()) {
                $magazinepublish->exchangeArray($form->getData());
                $this->getMagazinepublishTable()->saveMagazinepublish($magazinepublish);

                // Redirect to list of magazinepublishs
                return $this->redirect()->toRoute('magazinepublish');
            }
        }

        return array('form' => $form);
    }

    public function editAction() {
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('magazinepublish', array('action' => 'add'));
        }
        $magazinepublish = $this->getMagazinepublishTable()->getMagazinepublish($id);

        $form = new MagazinepublishForm();
        $form->bind($magazinepublish);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getMagazinepublishTable()->saveMagazinepublish($magazinepublish);

                // Redirect to list of magazinepublishs
                return $this->redirect()->toRoute('magazinepublish');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('magazinepublish');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost()->get('id');
                $this->getMagazinepublishTable()->deleteMagazinepublish($id);
            }

            // Redirect to list of magazinepublishs
            return $this->redirect()->toRoute('magazinepublish');
        }

        return array(
            'id' => $id,
            'magazinepublish' => $this->getMagazinepublishTable()->getMagazinepublish($id)
        );
    }

    public function getMagazinepublishTable() {
        if (!$this->magazinepublishTable) {
            $sm = $this->getServiceLocator();
            $this->magazinepublishTable = $sm->get('Magazinepublish\Model\MagazinepublishTable');
        }
        return $this->magazinepublishTable;
    }

}
