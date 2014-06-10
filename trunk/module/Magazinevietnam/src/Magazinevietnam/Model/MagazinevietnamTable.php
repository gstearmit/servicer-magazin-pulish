<?php

namespace Magazinevietnam\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class MagazinevietnamTable extends AbstractTableGateway {

    protected $table = 'magazinevietnam';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Magazinevietnam());

        $this->initialize();
    }

    public function fetchAll(Select $select = null) 
    {
        if (null === $select)
        $select = new Select();
        $select->from($this->table);
        $select->order('id ASC');
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }
    
    //fetchAllDetailmgvndetail
   // public function fetchAllDetailMzimg( $id , Select $select = null)
    public function fetchAllDetailMzimg( $id)
    {
    	$id = (int) $id;
		    //	if (null === $select) $select = new Select();
		    	
		//     	$select->from($this->table);
		//     	$select->order('id ASC');
		//     	$resultSet = $this->selectWith($select);
		//     	$resultSet->buffer();
		//     	return $resultSet;
		    	
    	

    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->columns(array('title'=>'title','descriptionkey'=>'descriptionkey','patient_id'=>'patient_id'));
    	$select->columns(array());
    	$select->from ('magazinevietnam')
    	       ->join('mgvndetail', 'mgvndetail.idmz=magazinevietnam.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('magazinevietnam.id'=>$id));
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
    
    public function fetchAllOrderbyiddesc(Select $select = null) {
    	if (null === $select)
    		$select = new Select();
    	$select->from($this->table);
    	$select->order('id DESC'); 
       // $sort[] = 'sort_order DESC';
    	//     	$sort[] = 'value ASC';
    	//     	$select->order($sort);
    	$resultSet = $this->selectWith($select);
    	$resultSet->buffer();
    	return $resultSet;
    }

    public function getMagazinevietnam($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
       
       
    }
    
    
    public function getRestMagazinevietnam($id) {
    	$id = (int) $id;
    
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	//$select->columns(array('id'=>'id','title'=>'title','descriptionkey'=>'descriptionkey','imgkey'=>'imgkey'));
    	$select->columns(array());
    	$select->from ('magazinevietnam')
    	->join('mgvndetail', 'mgvndetail.idmz=magazinevietnam.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('magazinevietnam.id'=>$id));
 //   	$sort[] = 'id DESC';
//     	$sort[] = 'value ASC';
 //    	$select->order($sort);
    
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
    
    
    public function getReadMagazinevietnam($id)
    {
    	$id = (int) $id;
    
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->columns(array());
    	$select->from ('magazinevietnam')
    	->join('mgvndetail', 'mgvndetail.idmz=magazinevietnam.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('magazinevietnam.id'=>$id));
        $sort = 'id ASC';

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
    

    public function saveMagazinevietnam(Magazinevietnam $magazinevietnam) {
        $data = array(
            'descriptionkey' => $magazinevietnam->descriptionkey,
        	'imgkey' => $magazinevietnam->imgkey,
            'title' => $magazinevietnam->title,
        	'patient_id' => $magazinevietnam->patient_id,
        		
        );

        $id = (int) $magazinevietnam->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getMagazinevietnam($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    
    public function saveMagazinevietnam2(Magazinevietnam $magazinevietnam) {
    	
    	
    	$data = array(
    			'descriptionkey' => $magazinevietnam->descriptionkey,
    			'imgkey' => $magazinevietnam->imgkey,
    			'title' => $magazinevietnam->title,
    			'patient_id' => $magazinevietnam->patient_id,
    	);
    	
    	$id = (int) $magazinevietnam->id;
    	if ($id == 0) {
    		$this->insert($data);
    	} else {
    		if ($this->getMagazinevietnam($id)) {
    			$this->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}

    }

    public function deleteMagazinevietnam($id) {
        $this->delete(array('id' => $id));
    }

    public function getTableByIdDelete($id)
    {
    	
    	$id = (int) $id;
    	$dbAdapter = $this->adapter;
    	$sql       = 'DELETE FROM mgvndetail WHERE idmz ='.$id;
    	$statement = $dbAdapter->query($sql);
    	$result    = $statement->execute();
    	//return $result;
    
    
    }
}
