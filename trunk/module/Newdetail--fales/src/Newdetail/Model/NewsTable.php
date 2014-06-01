<?php

namespace Newdetail\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class NewsTable extends AbstractTableGateway {

    protected $table = 'news';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new News());

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
    
    //fetchAllDetailnews
   // public function fetchAllDetailnews( $id , Select $select = null)
    public function fetchAllDetailnews( $id)
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
    	$select->columns(array('title'=>'title','descriptionkey'=>'descriptionkey'));
    	$select->columns(array());
    	$select->from ('catalogue')
    	       ->join('news', 'news.idmz=catalogue.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('catalogue.id'=>$id));
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

    public function getNewdetail($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
       
       
    }
    
    
    public function getRestNewdetailNewsReport($id)
     {
    	
    	//die("die o dađê lam tiep ");
    	
    	$id = (int) $id;
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->columns(array('id'=>'id','name'=>'name','brief'=>'brief','description'=>'description'));
    	$select->from (array('e' => 'news'))
    	       ->join(array('r' => 'news'), 'e.category_id= r.id',array(),'left')//; //->group('e.id');
    	       ->join(array('c' => 'catalogue'), 'e.category_id= c.id',array('name_category'=>'title'),'right'); //->group('e.id');
    	$select->where(array('e.category_id'=>$id));
  	    $sort = 'e.id DESC';
     	$select->order($sort);
    
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
    


    public function saveNewdetail(Newdetail $catalogue) {
        $data = array(
            'descriptionkey' => $catalogue->descriptionkey,
        	'imgkey' => $catalogue->imgkey,
            'title' => $catalogue->title,
        	'patient_id' => $catalogue->patient_id,
        	'url_catalogue' => $catalogue->url_catalogue,
        	'url_rest' => $catalogue->url_rest,
        );

        $id = (int) $catalogue->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getNewdetail($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    
    public function saveNewdetail2(Newdetail $catalogue) {
    	
    	
    	$data = array(
    			'descriptionkey' => $catalogue->descriptionkey,
    			'imgkey' => $catalogue->imgkey,
    			'title' => $catalogue->title,
    			'patient_id' => $catalogue->patient_id,
    			'url_catalogue' => $catalogue->url_catalogue,
    			'url_rest' => $catalogue->url_rest,
    	);
    	
    	$id = (int) $catalogue->id;
    	if ($id == 0) {
    		$this->insert($data);
    	} else {
    		if ($this->getNewdetail($id)) {
    			$this->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	
    	
    }

    public function deleteNewdetail($id) {
        $this->delete(array('id' => $id));
    }

}
