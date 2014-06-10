<?php

namespace Librarybooks\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class LibrarybooksTable extends AbstractTableGateway {

    protected $table = 'librarybooks';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Librarybooks());

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
    
    //fetchAllDetaillibrarydetail
   // public function fetchAllDetaillibrarydetail( $id , Select $select = null)
    public function fetchAllDetaillibrarydetail( $id)
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
    	$select->from ('librarybooks')
    	       ->join('librarydetail', 'librarydetail.idmz=librarybooks.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
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

    public function getLibrarybooks($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
       
       
    }
    
    
    public function getRestLibrarybooks($id) {
    	$id = (int) $id;
    
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	//$select->columns(array('id'=>'id','title'=>'title','descriptionkey'=>'descriptionkey','imgkey'=>'imgkey'));
    	$select->columns(array());
    	$select->from ('librarybooks')
    	->join('librarydetail', 'librarydetail.idmz=librarybooks.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('librarybooks.id'=>$id));
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
    
    public function getReadLibrarybooks($id)
    {
    	$id = (int) $id;
    
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->columns(array());
    	$select->from ('librarybooks')
    	->join('librarydetail', 'librarydetail.idmz=librarybooks.id',array('id'=>'id','img'=>'img','description'=>'description','title'=>'title','page'=>'page'));
    	$select->where(array('librarybooks.id'=>$id));
        $sort[] = 'id ASC';
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
    

    public function saveLibrarybooks(Librarybooks $librarybooks) {
        $data = array(
            'descriptionkey' => $librarybooks->descriptionkey,
        	'imgkey' => $librarybooks->imgkey,
            'title' => $librarybooks->title,
        	'patient_id' => $librarybooks->patient_id,
        		
        );

        $id = (int) $librarybooks->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getLibrarybooks($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    
    public function saveLibrarybooks2(Librarybooks $librarybooks) {
    	
    	
    	$data = array(
    			'descriptionkey' => $librarybooks->descriptionkey,
    			'imgkey' => $librarybooks->imgkey,
    			'title' => $librarybooks->title,
    			'patient_id' => $librarybooks->patient_id,
    	);
    	
    	$id = (int) $librarybooks->id;
    	if ($id == 0) {
    		$this->insert($data);
    	} else {
    		if ($this->getLibrarybooks($id)) {
    			$this->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	
//  	die;
//     	return var_dump(is_array($librarybooks->imgkey));
//     	die;
    	
    	
//     	if (is_array($librarybooks->imgkey)) 
//     	{
//     	  	foreach ($librarybooks->imgkey as $key)
//     	  	{
//     	  		$arrayMa_Img = array();
//     	  		$arrayMa_Img = $key['name'];
//     	  	}
    	  	
//     	  	$data = array(
//     	  			'descriptionkey' => $librarybooks->descriptionkey,
//     	  			'imgkey' =>$arrayMa_Img,
//     	  			'title' => $librarybooks->title,
//     	  	);
    	  	
//     	  	$id = (int) $librarybooks->id;
//     	  	if ($id == 0) {
//     	  		$this->insert($data);
//     	  	} else {
//     	  		if ($this->getLibrarybooks($id)) {
//     	  			$this->update($data, array('id' => $id));
//     	  		} else {
//     	  			throw new \Exception('Form id does not exist');
//     	  		}
//     	  	}
//     	}else 
//     	{
//     		$data = array(
//     				'descriptionkey' => $librarybooks->descriptionkey,
//     				'imgkey' => 'detaa',
//     				'title' => $librarybooks->title,
//     		);
    		
//     		$id = (int) $librarybooks->id;
//     		if ($id == 0) {
//     			$this->insert($data);
//     		} else {
//     			if ($this->getLibrarybooks($id)) {
//     				$this->update($data, array('id' => $id));
//     			} else {
//     				throw new \Exception('Form id does not exist');
//     			}
//     		}
//     	}
    	
    	//return 
    	
    	
    	
    }

    public function deleteLibrarybooks($id) {
        $this->delete(array('id' => $id));
    }
    
    public function getTableByIdDelete($id)
    {
    	$id = (int) $id;
    	$dbAdapter = $this->adapter;
    	$sql       = 'DELETE FROM librarydetail WHERE idmz ='.$id;
    	$statement = $dbAdapter->query($sql);
    	$result    = $statement->execute();
    	//return $result;
    
    
    }

}
