<?php

namespace AlbumRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

use Album\Model\Album;          // <-- Add this import
use Album\Form\AlbumForm;       // <-- Add this import
use Album\Model\AlbumTable;     // <-- Add this import
use Zend\View\Model\JsonModel;

class AlbumRestController extends AbstractRestfulController
{
    protected $albumTable;

    public function getList()
    {
    	
//     	$response = $this->getResponseWithHeader()
//     	->setContent( __METHOD__.' get the list of data');
//     	return $response;
    	 
    	
    	
    	
        $results = $this->getAlbumTable()->fetchAll();
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
        $album = $this->getAlbumTable()->getAlbum($id);

        return new JsonModel(array(
            'data' => $album,
        ));
    }

    public function create($data)
    {
//         $form = new AlbumForm();
//         $album = new Album();
//         $form->setInputFilter($album->getInputFilter());
//         $form->setData($data);
//         if ($form->isValid()) {
//             $album->exchangeArray($form->getData());
//             $id = $this->getAlbumTable()->saveAlbum($album);
//         }

        $idsave = $this->getAlbumTable()->saveAlbum($data);
        return new JsonModel(array(
            'data' => $this->get($idsave),
        ));
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
//         $album = $this->getAlbumTable()->getAlbum($id);
//         $form  = new AlbumForm();
//         $form->bind($album);
//         $form->setInputFilter($album->getInputFilter());
//         $form->setData($data);
//         if ($form->isValid()) {
            //$id = $this->getAlbumTable()->saveAlbum($form->getData());
           $idsave = $this->getAlbumTable()->saveAlbum($data);
       // }

        return new JsonModel(array(
            'data' => $this->get($idsave),
        ));
    }

    public function delete($id)
    {
        $this->getAlbumTable()->deleteAlbum($id);

        return new JsonModel(array(
            'data' => 'deleted',
        ));
    }

    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }
    
    // configure response
    public function getResponseWithHeader()
    {
    	$response = $this->getResponse();
    	$response->getHeaders()
    	//make can accessed by *
    	->addHeaderLine('Access-Control-Allow-Origin','*')
    	//set allow methods
    	->addHeaderLine('Access-Control-Allow-Methods','POST PUT DELETE GET');
    
    	return $response;
    }
}