<?php

namespace Magazinepublish\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Magazinepublish\Model\Magazinepublish;
use Magazinepublish\Form\MagazinepublishForm;
//use Magazinepublish\Form\magazinepublish;
//use Magazinepublish\Form\magazinepublishFormValidator;
//use Magazinepublish\Form\magazinepublishValidator;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
// check login

use ZfcUser\Service\User as UserService;
use ZfcUser\Options\UserControllerOptionsInterface;


class MagazinepublishController extends AbstractActionController {
    
    protected $magazinepublishTable;

    public function indexAction() {
    	// check login
    	if (!$this->zfcUserAuthentication()->hasIdentity()) {
    		return $this->redirect()->toRoute('zfcuser/login');
    	}else 
    	{
    	
        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $magazinepublishs = $this->getMagazinepublishTable()->fetchAll($select->order($order_by . ' ' . $order));
        $itemsPerPage = 10;        // is Number record/page

        $magazinepublishs->current();
        $paginator = new Paginator(new paginatorIterator($magazinepublishs));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(4);  // is number page want view

        return new ViewModel(array(
                    'order_by' => $order_by,
                    'order' => $order,
                    'page' => $page,
                    'paginator' => $paginator,
                ));
    	}//login
    	
    	
    }

    public function addAction() {
    	
        $form = new MagazinepublishForm(); // include Form Class
        $form->get('submit')->setAttribute('value', 'Add');
       
        $request = $this->getRequest();
       
        if ($request->isPost()) {
        	
            $magazinepublish = new Magazinepublish();

            $form->setInputFilter($magazinepublish->getInputFilter());  // check validate
           
            $form->setData($request->getPost());  // get all post
            
            $data = array_merge_recursive(
            		$this->getRequest()->getPost()->toArray(),
            		$this->getRequest()->getFiles()->toArray()
            );
			
//             echo '<pre>';
//             print_r($data);
//             echo '<pre>';
//             die;
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
