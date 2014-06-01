<?php

namespace News\Model;

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
    
    public function fetchAllJoih(Select $select = null)
    {
    	
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	
    	$select->from($this->table);
    	$select->columns(array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    
    	$select->join('catalogue', 'news.idmz=catalogue.id',array('titlecatalogue'=>'title','descriptionkeycatalogue'=>'descriptionkey'));
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
    
    public function fetchAllDetailNews( $id)
    {
    	$id = (int) $id;
    	 
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->columns(array('title'=>'title','descriptionkey'=>'descriptionkey'));
    	//$select->columns(array());
    	$select->from ('catalogue')
    	->join('news', 'news.idmz=catalogue.id',array('id'=>'id','title'=>'title','descriptionkey'=>'descriptionkey','imgkey'=>'imgkey','url_catalogue'=>'url_catalogue','url_rest'=>'url_rest','patient_id'=>'patient_id'));
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
    
    public function fetchById( $id)
    {
    	$id = (int) $id;
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->from ('news');
    	$select->where(array('news.id'=>$id));
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

    
    public function fetchByIdnow( $id)
    {
    	$id = (int) $id;
    	$dbAdapter = $this->adapter;
    	$sql       = 'SELECT * FROM `news` WHERE id='.$id;
    	$statement = $dbAdapter->query($sql);
    	//return  $statement;die;
    	$result    = $statement->execute();
    	return $result;
    
    }
    public function getNews($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
       
       
    }
    
    
    public function getrestNews($id) {
    	$id = (int) $id;
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->columns(array('news_id'=>'id','name'=>'name','brief'=>'brief','description'=>'description','category_id'=>'category_id','image_url'=>'image_url','user_id'=>'user_id'));
    	$select->from ('news')
    	->join('catalogue', 'news.category_id = catalogue.id',array('id'=>'id','title'=>'title','descriptionkey'=>'descriptionkey','imgkey'=>'imgkey','url_catalogue'=>'url_catalogue','url_rest'=>'url_rest','patient_id'=>'patient_id'));
    	$select->where(array('news.id'=>$id));
    
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

    public function saveNews(News $news) {
        $data = array(
            'id' => $news->id,
        	'title' => $news->title,
            'descriptionkey' => $news->descriptionkey,
			'imgkey' => $news->imgkey,
			'url_catalogue' => $news->url_catalogue,
        		'url_rest' => $news->url_rest,
        		'patient_id' => $news->patient_id,
        		
        );
        

        $id = (int) $news->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getNews($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteNews($id) 
    {
        $this->delete(array('id' => $id));
    }
    

}
