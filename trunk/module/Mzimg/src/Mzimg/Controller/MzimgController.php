<?php

namespace Mzimg\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Mzimg\Model\Mzimg;
use Mzimg\Form\MzimgForm;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

class MzimgController extends AbstractActionController {

    protected $mzimgTable;

    public function indexAction() {
    	// check login
    	if (!$this->zfcUserAuthentication()->hasIdentity()) {
    		return $this->redirect()->toRoute('zfcuser/login');
    	}
    	
    	
        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $mzimgs = $this->getMzimgTable()->fetchAll($select->order($order_by . ' ' . $order));
        $itemsPerPage = 10;        // is Number record/page

        $mzimgs->current();
        $paginator = new Paginator(new paginatorIterator($mzimgs));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(4);  // is number page want view

        return new ViewModel(array(
                    'order_by' => $order_by,
                    'order' => $order,
                    'page' => $page,
                    'paginator' => $paginator,
                ));
    }

    public function addAction() {
    	
        $form = new MzimgForm(); // include Form Class
        $form->get('submit')->setAttribute('value', 'Add');
       
        $request = $this->getRequest();
       
        if ($request->isPost()) {
        	
            $mzimg = new Mzimg();

            $form->setInputFilter($mzimg->getInputFilter());  // check validate
           
            $form->setData($request->getPost());  // get all post
            
            $data = array_merge_recursive(
            		$this->getRequest()->getPost()->toArray(),
            		$this->getRequest()->getFiles()->toArray()
            );
            
           // var_dump($data);die;
            
            if ($form->isValid()) {
                $mzimg->exchangeArray($form->getData());
                $this->getMzimgTable()->saveMzimg($mzimg);
                // Redirect to list of Mzimgs
                return $this->redirect()->toRoute('mzimg');
            }
        }

        return array('form' => $form);
    }

    public function editAction() {
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('mzimg', array('action' => 'add'));
        }
        $mzimg = $this->getMzimgTable()->getMzimg($id);

        $form = new MzimgForm();
        $form->bind($mzimg);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getMzimgTable()->saveMzimg($mzimg);

                // Redirect to list of Mzimgs
                return $this->redirect()->toRoute('mzimg');
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
            return $this->redirect()->toRoute('mzimg');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost()->get('id');
                $this->getMzimgTable()->deleteMzimg($id);
            }

            // Redirect to list of Mzimgs
            return $this->redirect()->toRoute('mzimg');
        }

        return array(
            'id' => $id,
            'mzimg' => $this->getMzimgTable()->getMzimg($id)
        );
    }

    public function getMzimgTable() {
        if (!$this->mzimgTable) {
            $sm = $this->getServiceLocator();
            $this->mzimgTable = $sm->get('Mzimg\Model\MzimgTable');
        }
        return $this->mzimgTable;
    }

}
