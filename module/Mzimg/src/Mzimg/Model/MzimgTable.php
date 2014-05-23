<?php

namespace Mzimg\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class MzimgTable extends AbstractTableGateway {

    protected $table = 'mzimg';
    

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Mzimg());

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
    
    	$select->join('magazinepublish', 'mzimg.idmz=magazinepublish.id',array('titlemagazinepublish'=>'title','descriptionkeymagazinepublish'=>'descriptionkey'));
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
    
    public function fetchAllDetailMzimg( $id)
    {
    	$id = (int) $id;
    	 
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->columns(array('title'=>'title','descriptionkey'=>'descriptionkey'));
    	//$select->columns(array());
    	$select->from ('magazinepublish')
    	->join('mzimg', 'mzimg.idmz=magazinepublish.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('magazinepublish.id'=>$id));
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

    public function getMzimg($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
       
       
    }
    
    
    public function getrestMzimg($id) {
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
    	$select->from ('magazinepublish')
    	->join('mzimg', 'mzimg.id=magazinepublish.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('magazinepublish.id'=>$id));
    
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

    public function saveMzimg(Mzimg $mzimg) {
        $data = array(
            'idmz' => $mzimg->idmz,
        	'img' => $mzimg->img,
            'description' => $mzimg->description,
			'title' => $mzimg->title,
			'page' => $mzimg->page,
        );
        

        $id = (int) $mzimg->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getMzimg($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteMzimg($id) 
    {
        $this->delete(array('id' => $id));
    }
    

}
