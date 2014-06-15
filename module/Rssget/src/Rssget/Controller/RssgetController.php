<?php

namespace Rssget\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Rssget\Model\Rssget;
use Rssget\Form\RssgetForm;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Zend\Db\Sql\Select;

// rss
use Zend\Feed\Reader as feed;
use Zend\View\Model\JsonModel;

class RssgetController extends AbstractActionController {
	protected $rssgetTable;
	public function indexAction() {
		
		// if (!$this->zfcUserAuthentication()->hasIdentity()) {
		// return $this->redirect()->toRoute('zfcuser/login');
		// }
		$select = new Select ();
		$order_by = $this->params ()->fromRoute ( 'order_by' ) ? $this->params ()->fromRoute ( 'order_by' ) : 'id';
		$order = $this->params ()->fromRoute ( 'order' ) ? $this->params ()->fromRoute ( 'order' ) : Select::ORDER_ASCENDING;
		$page = $this->params ()->fromRoute ( 'page' ) ? ( int ) $this->params ()->fromRoute ( 'page' ) : 1;
		
		$rssgets = $this->getRssgetTable ()->fetchAll ( $select->order ( $order_by . ' ' . $order ) );
		$itemsPerPage = 3;
		
		$rssgets->current ();
		$paginator = new Paginator ( new paginatorIterator ( $rssgets ) );
		$paginator->setCurrentPageNumber ( $page )->setItemCountPerPage ( $itemsPerPage )->setPageRange ( 4 );
		
		return new ViewModel ( array (
				// 'rssgets' => $this->getRssgetTable()->fetchAll(),
				'order_by' => $order_by,
				'order' => $order,
				'page' => $page,
				'paginator' => $paginator 
		) );
	}
	public function addAction() {
		$form = new RssgetForm ();
		$form->get ( 'submit' )->setAttribute ( 'value', 'Add' );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$rssget = new Rssget ();
			$form->setInputFilter ( $rssget->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$rssget->exchangeArray ( $form->getData () );
				$this->getRssgetTable ()->saveRssget ( $rssget );
				
				// Redirect to list of rssgets
				return $this->redirect ()->toRoute ( 'rssget' );
			}
		}
		
		return array (
				'form' => $form 
		);
	}
	public function editAction() {
		$id = ( int ) $this->params ( 'id' );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'rssget', array (
					'action' => 'add' 
			) );
		}
		$rssget = $this->getRssgetTable ()->getRssget ( $id );
		
		$form = new RssgetForm ();
		$form->bind ( $rssget );
		$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$this->getRssgetTable ()->saveRssget ( $rssget );
				
				// Redirect to list of rssgets
				return $this->redirect ()->toRoute ( 'rssget' );
			}
		}
		
		return array (
				'id' => $id,
				'form' => $form 
		);
	}
	public function deleteAction() {
		$id = ( int ) $this->params ( 'id' );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'rssget' );
		}
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$del = $request->getPost ()->get ( 'del', 'No' );
			if ($del == 'Yes') {
				$id = ( int ) $request->getPost ()->get ( 'id' );
				$this->getRssgetTable ()->deleteRssget ( $id );
			}
			
			// Redirect to list of Rssgets
			return $this->redirect ()->toRoute ( 'rssget' );
		}
		
		return array (
				'id' => $id,
				'rssget' => $this->getRssgetTable ()->getRssget ( $id ) 
		);
	}
	public function rssgetAction() {
		try {
			
			$rss = feed\Reader::import ( 'http://www.wdcdn.net/rss/presentation/library/client/skunkus/id/cc3d06c1cc3834464aef22836c55d13a' );
		} catch ( feed\Exception\RuntimeException $e ) {
			echo "error : " . $e->getMessage ();
			exit ();
		}
		
		$channel = array (
				'title' => $rss->getTitle (),
				//'date'=>$rss->getDateModified(),
				'description' => $rss->getDescription (),
				'link' => $rss->getLink (),
				'items' => array () 
		);
		
	
		foreach ( $rss as $item ) 
		{

			$channel ['items'] [] = array (
					'title' => $item->getTitle (),
					//'date'=>$item->getDateModified(),
					'link' => $item->getLink (),
					'description' => $item->getDescription () ,
			        'image' => $item->getMedia()->url,
						);
		}
		
		return new ViewModel ( array (
				'channel' => $channel 
		) );
	}
	
	public function rssjsonAction() {
		try {
				
			$rss = feed\Reader::import ( 'http://www.wdcdn.net/rss/presentation/library/client/skunkus/id/cc3d06c1cc3834464aef22836c55d13a' );
		} catch ( feed\Exception\RuntimeException $e ) {
			echo "error : " . $e->getMessage ();
			exit ();
		}
	
		$channel = array (
				'title' => $rss->getTitle (),
				//'date'=>$rss->getDateModified(),
				'description' => $rss->getDescription (),
				'link' => $rss->getLink (),
				'items' => array ()
		);
	
	
		foreach ( $rss as $item )
		{
	
			$channel ['items'] [] = array (
					'title' => $item->getTitle (),
					//'date'=>$item->getDateModified(),
					'link' => $item->getLink (),
					'description' => $item->getDescription () ,
					'image' => $item->getMedia()->url,
			);
		}
	
		 return new JsonModel(array(
            'channel' => $channel,
        ));
	}
	
	
	public function getRssgetTable() {
		if (! $this->rssgetTable) {
			$sm = $this->getServiceLocator ();
			$this->rssgetTable = $sm->get ( 'Rssget\Model\RssgetTable' );
		}
		return $this->rssgetTable;
	}
}
