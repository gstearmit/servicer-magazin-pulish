<?php

namespace Booknews\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Booknews\Model\Booknews;
use Booknews\Form\BooknewsForm;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Zend\Db\Sql\Select;

use ZfcUser\Service\User as UserService;
use ZfcUser\Options\UserControllerOptionsInterface;

class BooknewsController extends AbstractActionController
{
    protected $booknewsTable;
	
    /*
    public function indexAction()
    {
        return new ViewModel(array(
            'booknewss' => $this->getbooknewsTable()->fetchAll(),
        ));
    }
    */
    
    public function indexAction() {
    	
    	//
    	if ($this->zfcUserAuthentication()->hasIdentity()) {
    		return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
    	}else {
    	
    	$select = new Select();
    	$order_by = $this->params()->fromRoute('order_by') ?
    	$this->params()->fromRoute('order_by') : 'id';
    	$order = $this->params()->fromRoute('order') ?
    	$this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
    	$page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
    
    	$booknewss = $this->getBooknewsTable()->fetchAll($select->order($order_by . ' ' . $order));
    	
//     	echo 'var_dum';var_dump($booknewss);
//     	die;
    	
    	$itemsPerPage = 3;
    
    	$booknewss->current();
    	$paginator = new Paginator(new paginatorIterator($booknewss));
    	$paginator->setCurrentPageNumber($page)
    	->setItemCountPerPage($itemsPerPage)
    	->setPageRange(4);
    
    	return new ViewModel(array(
    			//'booknewss' => $this->getbooknewsTable()->fetchAll(),
    			'order_by' => $order_by,
    			'order' => $order,
    			'page' => $page,
    			'paginator' => $paginator,
    	));
    	}//login
    }

    public function addAction()
    {
        $form = new BooknewsForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $booknews = new Booknews();
            $form->setInputFilter($booknews->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $booknews->exchangeArray($form->getData());
                $this->getbooknewsTable()->saveBooknews($booknews);

                // Redirect to list of booknewss
                return $this->redirect()->toRoute('booknews');
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('booknews', array('action'=>'add'));
        }
        $booknews = $this->getbooknewsTable()->getbooknews($id);

        $form = new booknewsForm();
        $form->bind($booknews);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getbooknewsTable()->savebooknews($booknews);

                // Redirect to list of booknewss
                return $this->redirect()->toRoute('booknews');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('booknews');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $this->getbooknewsTable()->deletebooknews($id);
            }

            // Redirect to list of booknewss
            return $this->redirect()->toRoute('booknews');
        }

        return array(
            'id' => $id,
            'booknews' => $this->getbooknewsTable()->getbooknews($id)
        );
    }

    public function getbooknewsTable()
    {
        if (!$this->booknewsTable) {
            $sm = $this->getServiceLocator();
            $this->booknewsTable = $sm->get('Booknews\Model\BooknewsTable');
        }
        return $this->booknewsTable;
    }    
}
