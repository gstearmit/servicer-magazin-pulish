<?php

namespace Hamtruyencom\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class HamtruyencomTable extends AbstractTableGateway
{
    protected $table = 'appsatellite';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Hamtruyencom());

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

    public function getHamtruyencom($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveHamtruyencom(Hamtruyencom $hamtruyencom)
    {
        $data = array(
	            'nameapp' => $hamtruyencom->nameapp,
	            'title'  => $hamtruyencom->title,
	        	'link'=>$hamtruyencom->link,
        		'image_thumbnail'=>$hamtruyencom->image_thumbnail,
        		'content_detail'=>$hamtruyencom->content_detail,
        		'content_detail_full'=>$hamtruyencom->content_detail_full,
        		'extend'=>$hamtruyencom->extend,
        );

        $id = (int)$hamtruyencom->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getHamtruyencom($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
   //
    public function savesongkhoemenu($content_detail_full = Array())
    {
    	if (is_array($content_detail_full) and !empty($content_detail_full))
    	{
 
    			$dbAdapter = $this->adapter;
    			$sql       = "INSERT INTO songkhoemenu (title,link,description,image_thumbnail,items)
                              VALUES ('".$content_detail_full['title']."','".$content_detail_full['link']."','".$content_detail_full['description']."','".$content_detail_full['image_thumbnail']."','')";
    
    			$statement = $dbAdapter->query($sql);
    			//return $statement; die;
    			$result    = $statement->execute();
    			$id = $dbAdapter->getDriver()->getLastGeneratedValue();
    		return $id;
    	}else
    		return $result = Null;
    
    }
    //savesongkhoemenuchlid
    public function savesongkhoemenuchlid($content_detail_full = Array(),$id_pa)
    {
    	if (is_array($content_detail_full) and !empty($content_detail_full))
    	{
    
    		$dbAdapter = $this->adapter;
    		$sql       = "INSERT INTO songkhoemenuchlid (titlechild,linkchild,descriptionchild,image_thumbnailchild,id_pa)
                              VALUES ('".$content_detail_full['titlechild']."','".$content_detail_full['linkchild']."','".$content_detail_full['descriptionchild']."','".$content_detail_full['image_thumbnailchild']."','".$id_pa."')";
    
    		$statement = $dbAdapter->query($sql);
    		//return $statement; die;
    		$result    = $statement->execute();
    		$id = $dbAdapter->getDriver()->getLastGeneratedValue();
    		return $id;
    	}else
    		return $result = Null;
    
    }
    
    //
    public function getsongkhoemenuchlid()
    {
    	
    		$dbAdapter = $this->adapter;
    		$sql       = "SELECT * FROM songkhoemenuchlid ";
	    	$statement = $dbAdapter->query($sql);
	    	$result    = $statement->execute();
	    
	    	$selectData = array();
	    
	    	foreach ($result as $res) {
	    		$tmp_tmp = array();
	    		$tmp_tmp['url'] = $res['linkchild'];
	    		$tmp_tmp['id_child'] = $res['id'];
	    		$selectData[]=$tmp_tmp;
	    	}
	    	return $selectData;
    	
    }
    public function getMaxId()
    {
    	
    	$sql = "SELECT MAX(id) FROM songkhoemenu";
    	$statementmax = $dbAdapter->query($sql);
    	$resultmax    = $statementmax->execute();
    	$id;
    	foreach ($resultmax as $res) 
    	{
    		$id = $res['id']; //*generatedValue
    	}
    	return $id;	
    }
    
    public function deleteHamtruyencom($id)
    {
        $this->delete(array('id' => $id));
    }
    //zf2
    public function fetch_All_zf2_Rest_Orderbyiddesc(Select $select = null) {
    	if (null === $select)
    	$select = new Select();
    	$select->from('appsatellite');
    	$select->where(array('appsatellite.nameapp = \'zf2\''));
    	$select->order('id DESC');
    	$resultSet = $this->selectWith($select);
    	//return $resultSet;die;
    	$resultSet->buffer();
    	return $resultSet;
    }
    //Mincecraft
    public function fetch_All_Appmincecraftrest_Rest_Orderbyiddesc(Select $select = null) {
    	if (null === $select)
    		$select = new Select();
    	$select->from('appsatellite');
    	$select->where(array('appsatellite.nameapp = \'minecraftmodscom\''));
    	$select->order('id DESC');
    	$resultSet = $this->selectWith($select);
    	//return $resultSet;die;
    	$resultSet->buffer();
    	return $resultSet;
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
    
    // rest haivl.com
    public function fetch_All_Apphaivlcom_Rest_Orderbyiddesc(Select $select = null) {
    	if (null === $select)
    		$select = new Select();
    	$select->from('appsatellite');
    	$select->where(array('appsatellite.nameapp = \'haivlcom\''));
    	$select->order('id DESC');
    	$resultSet = $this->selectWith($select);
    	//return $resultSet;die;
    	$resultSet->buffer();
    	return $resultSet;
    }
  
    
    
}
