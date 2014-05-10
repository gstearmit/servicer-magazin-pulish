<?php

namespace Mzimg\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Mzimg\Model\Mzimg;
use Mzimg\Form\MzimgForm;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Zend\Db\Sql\Select;

class MzimgController extends AbstractActionController
{
    protected $mzimgTable;
	
    /*
    public function indexAction()
    {
        return new ViewModel(array(
            'mzimgs' => $this->getMzimgTable()->fetchAll(),
        ));
    }
    */
    
    public function indexAction() {
    	$select = new Select();
    	$order_by = $this->params()->fromRoute('order_by') ?
    	$this->params()->fromRoute('order_by') : 'idmzalbum';
    	$order = $this->params()->fromRoute('order') ?
    	$this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
    	$page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
    
    	$mzimgs = $this->getMzimgTable()->fetchAll($select->order($order_by . ' ' . $order));
    	$itemsPerPage = 3;
    
    	$mzimgs->current();
    	$paginator = new Paginator(new paginatorIterator($mzimgs));
    	$paginator->setCurrentPageNumber($page)
    	->setItemCountPerPage($itemsPerPage)
    	->setPageRange(4);
    
    	return new ViewModel(array(
    			//'mzimgs' => $this->getMzimgTable()->fetchAll(),
    			'order_by' => $order_by,
    			'order' => $order,
    			'page' => $page,
    			'paginator' => $paginator,
    	));
    }

    public function addAction()
    {
    	//echo 'actioc add' ;die;
        $form = new MzimgForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $mzimg = new Mzimg();
            $form->setInputFilter($mzimg->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $mzimg->exchangeArray($form->getData());
                $this->getMzimgTable()->saveMzimg($mzimg);

                // Redirect to list of mzimgs
                return $this->redirect()->toRoute('mzimg');
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $idmzalbum = (int)$this->params('idmzalbum');
        if (!$idmzalbum) {
            return $this->redirect()->toRoute('mzimg', array('action'=>'add'));
        }
        $mzimg = $this->getMzimgTable()->getMzimg($idmzalbum);

        $form = new MzimgForm();
        $form->bind($mzimg);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getMzimgTable()->saveMzimg($mzimg);

                // Redirect to list of mzimgs
                return $this->redirect()->toRoute('mzimg');
            }
        }

        return array(
            'idmzalbum' => $idmzalbum,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $idmzalbum = (int)$this->params('idmzalbum');
        if (!$idmzalbum) {
            return $this->redirect()->toRoute('mzimg');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $idmzalbum = (int)$request->getPost()->get('idmzalbum');
                $this->getMzimgTable()->deleteMzimg($idmzalbum);
            }

            // Redirect to list of mzimgs
            return $this->redirect()->toRoute('mzimg');
        }

        return array(
            'idmzalbum' => $idmzalbum,
            'mzimg' => $this->getMzimgTable()->getMzimg($idmzalbum)
        );
    }

    public function getMzimgTable()
    {
        if (!$this->mzimgTable) {
            $sm = $this->getServiceLocator();
            $this->mzimgTable = $sm->get('Mzimg\Model\MzimgTable');
        }
        return $this->mzimgTable;
    }    
}
