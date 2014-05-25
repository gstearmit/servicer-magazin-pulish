<?php

namespace Manastory\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class ManastoryTable extends AbstractTableGateway {

    protected $table = 'story';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Manastory());

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

    public function getManastory($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
       
       
    }
    
    
    public function getRestManastory($id) {
    	$id = (int) $id;
    
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	//$select->columns(array('id'=>'id','title'=>'title','descriptionkey'=>'descriptionkey','imgkey'=>'imgkey'));
    	$select->columns(array());
    	$select->from ('story')
    	->join('storydetail', 'storydetail.idmz=story.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('story.id'=>$id));
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

    public function saveManastory(Manastory $manastory) {
        $data = array(
            'descriptionkey' => $manastory->descriptionkey,
        	'imgkey' => $manastory->imgkey,
            'title' => $manastory->title,
        	'patient_id' => $magazinepublish->patient_id,
        );

        $id = (int) $manastory->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getManastory($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    
    public function saveManastory2(Manastory $manastory) {
    	
    	
    	$data = array(
    			'descriptionkey' => $manastory->descriptionkey,
    			'imgkey' => $manastory->imgkey,
    			'title' => $manastory->title,
    			'patient_id' => $magazinepublish->patient_id,
    	);
    	
    	$id = (int) $manastory->id;
    	if ($id == 0) {
    		$this->insert($data);
    	} else {
    		if ($this->getManastory($id)) {
    			$this->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	
//  	die;
//     	return var_dump(is_array($manastory->imgkey));
//     	die;
    	
    	
//     	if (is_array($manastory->imgkey)) 
//     	{
//     	  	foreach ($manastory->imgkey as $key)
//     	  	{
//     	  		$arrayMa_Img = array();
//     	  		$arrayMa_Img = $key['name'];
//     	  	}
    	  	
//     	  	$data = array(
//     	  			'descriptionkey' => $manastory->descriptionkey,
//     	  			'imgkey' =>$arrayMa_Img,
//     	  			'title' => $manastory->title,
//     	  	);
    	  	
//     	  	$id = (int) $manastory->id;
//     	  	if ($id == 0) {
//     	  		$this->insert($data);
//     	  	} else {
//     	  		if ($this->getManastory($id)) {
//     	  			$this->update($data, array('id' => $id));
//     	  		} else {
//     	  			throw new \Exception('Form id does not exist');
//     	  		}
//     	  	}
//     	}else 
//     	{
//     		$data = array(
//     				'descriptionkey' => $manastory->descriptionkey,
//     				'imgkey' => 'detaa',
//     				'title' => $manastory->title,
//     		);
    		
//     		$id = (int) $manastory->id;
//     		if ($id == 0) {
//     			$this->insert($data);
//     		} else {
//     			if ($this->getManastory($id)) {
//     				$this->update($data, array('id' => $id));
//     			} else {
//     				throw new \Exception('Form id does not exist');
//     			}
//     		}
//     	}
    	
    	//return 
    	
    	
    	
    }

    public function deleteManastory($id) {
        $this->delete(array('id' => $id));
    }

}
