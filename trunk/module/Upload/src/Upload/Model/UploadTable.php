<?php

namespace Upload\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class UploadTable extends AbstractTableGateway {

    protected $table = 'upload';
    

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Upload());

        $this->initialize();
    }

    public function fetchAll(Select $select = null) 
    {
        if (null === $select)
        $select = new Select();
        $select->from($this->table);
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }
    
    public function fetchAllJoih(Select $select = null)
    {
    	
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	
    	$select->from($this->table);
    	$select->columns(array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    
    	$select->join('librarybooks', 'upload.idmz=librarybooks.id',array('titlelibrarybooks'=>'title','descriptionkeylibrarybooks'=>'descriptionkey'));
    	$select->order('id ASC');
    
    	$selectString = $sql->prepareStatementForSqlObject($select);
    
    	//return $selectString;die;
    
    	$results = $selectString->execute();
    
    	// swap
    	$array = array();
    	foreach ($results as $result)
    	{
    		$tmp = array();
    		$tmp= $result;
    		$array[] = $tmp;
    	}
    
    	return $array;
    }
    
    public function fetchAllDetailUpload( $id)
    {
    	$id = (int) $id;
    	 
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->columns(array('title'=>'title','descriptionkey'=>'descriptionkey'));
    	//$select->columns(array());
    	$select->from ('librarybooks')
    	->join('upload', 'upload.idmz=librarybooks.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('librarybooks.id'=>$id));
    	$select->order('id ASC');
    	// $resultSet = $this->selectWith($select);
    	//$resultSet->buffer();
    	$selectString = $sql->prepareStatementForSqlObject($select);
    
    	//return $selectString;die;
    
    	$results = $selectString->execute();
    
    	// swap
    	$array = array();
    	foreach ($results as $result)
    	{
    		$tmp = array();
    		$tmp= $result;
    		$array[] = $tmp;
    	}
    
    	return $array;
    
    }

    public function getUpload($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
       
       
    }
    
    
    public function getrestUpload($id) {
    	$id = (int) $id;
    	//         $rowset = $this->select(array('id' => $id));
    
    	//         $row = $rowset->current();
    	//         if (!$row) {
    	//             throw new \Exception("Could not find row $id");
    	//         }
    	//         return $row;
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	//$select->columns(array('id'=>'id','title'=>'title','descriptionkey'=>'descriptionkey','imgkey'=>'imgkey'));
    	$select->columns(array());
    	$select->from ('librarybooks')
    	->join('upload', 'upload.id=librarybooks.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('librarybooks.id'=>$id));
    
    	$selectString = $sql->prepareStatementForSqlObject($select);
    	$results = $selectString->execute();
    	 
    	// swap
    	$array = array();
    	foreach ($results as $result)
    	{
    		$tmp = array();
    		$tmp= $result;
    		$array[] = $tmp;
    	}
    
    	return $array;
    	 
    }

    public function saveUpload(Upload $upload) {
        $data = array(
            'idmz' => $upload->idmz,
        	'img' => $upload->img,
            'description' => $upload->description,
			'title' => $upload->title,
			'page' => $upload->page,
        );
        

        $id = (int) $upload->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getUpload($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteUpload($id) 
    {
        $this->delete(array('id' => $id));
    }
    

}
