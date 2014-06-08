<?php

namespace Storydetail\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class StorydetailTable extends AbstractTableGateway {

    protected $table = 'storydetail';
    

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Storydetail());

        $this->initialize();
    }

    public function fetchAll(Select $select = null) {
        if (null === $select)
        $select = new Select();
        $select->from($this->table);
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }

    public function getStorydetail($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
       
       
    }
    
    
    public function getrestStorydetail($id) {
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
    	$select->from ('story')
    	->join('storydetail', 'storydetail.id=story.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('story.id'=>$id));
    
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

    public function saveStorydetail(Storydetail $storydetail) {
        $data = array(
            'idmz' => $storydetail->idmz,
        	'img' => $storydetail->img,
            'description' => $storydetail->description,
			'title' => $storydetail->title,
			'page' => $storydetail->page,
        );
        

        $id = (int) $storydetail->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getStorydetail($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteStorydetail($id) {
        $this->delete(array('id' => $id));
    }
    
    
    public function fetchAllDetailStory( $id)
    {
    	$id = (int) $id;
    
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->columns(array('titlestory'=>'title','descriptionkey'=>'descriptionkey'));
    	$select->columns(array());
    	$select->from ('story')
    	->join('storydetail', 'storydetail.idmz=story.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('story.id'=>$id));
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
    
    //getNameStory
    public function getNameStory( $id)
    {
    	$id = (int) $id;
    
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->columns(array('titlestory'=>'title','descriptionkey'=>'descriptionkey'));
    	$select->from ('story');
    	$select->where(array('story.id'=>$id));
    	
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
}
