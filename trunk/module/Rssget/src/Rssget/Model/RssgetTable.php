<?php

namespace Rssget\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class RssgetTable extends AbstractTableGateway
{
    protected $table = 'appsatellite';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Rssget());

        $this->initialize();
    }

    /*
    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }
    */
    public function fetchAll(Select $select = null) {
    	if (null === $select)
    		$select = new Select();
    	$select->from($this->table);
    	$resultSet = $this->selectWith($select);
    	$resultSet->buffer();
    	return $resultSet;
    }

    public function getRssget($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveRssget(Rssget $rssget)
    {
        $data = array(
	            'nameapp' => $rssget->nameapp,
	            'title'  => $rssget->title,
	        	'link'=>$rssget->link,
        		'image_thumbnail'=>$rssget->image_thumbnail,
        		'content_detail'=>$rssget->content_detail,
        		'content_detail_full'=>$rssget->content_detail_full,
        		'extend'=>$rssget->extend,
        );

        $id = (int)$rssget->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getRssget($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteRssget($id)
    {
        $this->delete(array('id' => $id));
    }

    //fetch_All_Apphaivltv_Rest_Orderbyiddesc
    public function fetch_All_Apphaivltv_Rest_Orderbyiddesc(Select $select = null) {
    	if (null === $select)
    		$select = new Select();
    	$select->from('appsatellite');
    	$select->where(array('appsatellite.nameapp = \'haivltv\''));
    	$select->order('id DESC');
    	$resultSet = $this->selectWith($select);
    	//return $resultSet;die;
    	$resultSet->buffer();
    	return $resultSet;
    }
    
    public function get_app_hai_vltv_rest($id) {
    	    $id = (int) $id;
    		$sql = new Sql($this->adapter);
    		$select = $sql->select();
    		//$select->columns(array('id'=>'id','title'=>'title','descriptionkey'=>'descriptionkey','imgkey'=>'imgkey'));
    		$select->columns(array());
    		$select->from ('appsatellite');
    	    $select->where(array('appsatellite.id'=>$id ,'appsatellite.nameapp'=>'haivltv'));
    
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
    
    
}
