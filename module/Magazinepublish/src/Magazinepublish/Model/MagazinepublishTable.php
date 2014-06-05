<?php

namespace Magazinepublish\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class MagazinepublishTable extends AbstractTableGateway {

    protected $table = 'magazinepublish';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Magazinepublish());

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
    
    //fetchAllDetailMzimg
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

    public function getMagazinepublish($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
       
       
    }
    
    
    public function getRestMagazinepublish($id) {
    	$id = (int) $id;
    
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	//$select->columns(array('id'=>'id','title'=>'title','descriptionkey'=>'descriptionkey','imgkey'=>'imgkey'));
    	$select->columns(array());
    	$select->from ('magazinepublish')
    	->join('mzimg', 'mzimg.idmz=magazinepublish.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('magazinepublish.id'=>$id));
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
    
    public function getReadMagazinepublish($id)
    {
    	$id = (int) $id;
    	
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	//$select->columns(array('id'=>'id','title'=>'title','descriptionkey'=>'descriptionkey','imgkey'=>'imgkey'));
    	$select->columns(array());
    	$select->from ('magazinepublish')
    	->join('mzimg', 'mzimg.idmz=magazinepublish.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('magazinepublish.id'=>$id));
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

    public function saveMagazinepublish(Magazinepublish $magazinepublish) {
        $data = array(
            'descriptionkey' => $magazinepublish->descriptionkey,
        	'imgkey' => $magazinepublish->imgkey,
            'title' => $magazinepublish->title,
        	'patient_id' => $magazinepublish->patient_id,
        		
        );

        $id = (int) $magazinepublish->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getMagazinepublish($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    
    public function saveMagazinepublish2(Magazinepublish $magazinepublish) {
    	
    	
    	$data = array(
    			'descriptionkey' => $magazinepublish->descriptionkey,
    			'imgkey' => $magazinepublish->imgkey,
    			'title' => $magazinepublish->title,
    			'patient_id' => $magazinepublish->patient_id,
    	);
    	
    	$id = (int) $magazinepublish->id;
    	if ($id == 0) {
    		$this->insert($data);
    	} else {
    		if ($this->getMagazinepublish($id)) {
    			$this->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	
//  	die;
//     	return var_dump(is_array($magazinepublish->imgkey));
//     	die;
    	
    	
//     	if (is_array($magazinepublish->imgkey)) 
//     	{
//     	  	foreach ($magazinepublish->imgkey as $key)
//     	  	{
//     	  		$arrayMa_Img = array();
//     	  		$arrayMa_Img = $key['name'];
//     	  	}
    	  	
//     	  	$data = array(
//     	  			'descriptionkey' => $magazinepublish->descriptionkey,
//     	  			'imgkey' =>$arrayMa_Img,
//     	  			'title' => $magazinepublish->title,
//     	  	);
    	  	
//     	  	$id = (int) $magazinepublish->id;
//     	  	if ($id == 0) {
//     	  		$this->insert($data);
//     	  	} else {
//     	  		if ($this->getMagazinepublish($id)) {
//     	  			$this->update($data, array('id' => $id));
//     	  		} else {
//     	  			throw new \Exception('Form id does not exist');
//     	  		}
//     	  	}
//     	}else 
//     	{
//     		$data = array(
//     				'descriptionkey' => $magazinepublish->descriptionkey,
//     				'imgkey' => 'detaa',
//     				'title' => $magazinepublish->title,
//     		);
    		
//     		$id = (int) $magazinepublish->id;
//     		if ($id == 0) {
//     			$this->insert($data);
//     		} else {
//     			if ($this->getMagazinepublish($id)) {
//     				$this->update($data, array('id' => $id));
//     			} else {
//     				throw new \Exception('Form id does not exist');
//     			}
//     		}
//     	}
    	
    	//return 
    	
    	
    	
    }

    public function deleteMagazinepublish($id) {
        $this->delete(array('id' => $id));
    }

}
