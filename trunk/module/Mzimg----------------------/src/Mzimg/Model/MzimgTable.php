<?php

namespace Mzimg\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class MzimgTable extends AbstractTableGateway
{
    protected $table = 'mzimg';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Mzimg());

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

    public function getMzimg($idmzalbum)
    {
        $idmzalbum  = (int) $idmzalbum;
        $rowset = $this->select(array('idmzalbum' => $idmzalbum));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $idmzalbum");
        }
        return $row;
    }

    public function saveMzimg(Mzimg $mzimg)
    {
        $data = array(
            'img' => $mzimg->img,
            'title'  => $mzimg->title,
        	'id'=> $mzimg->id,
        	'page'=> $mzimg->page,
        	'description'=> $mzimg->description,
        );
        


        $idmzalbum = (int)$mzimg->idmzalbum;
        if ($idmzalbum == 0) {
            $this->insert($data);
        } else {
            if ($this->getMzimg($idmzalbum)) {
                $this->update($data, array('idmzalbum' => $idmzalbum));
            } else {
                throw new \Exception('Form idmzalbum does not exist');
            }
        }
    }

    public function deleteMzimg($idmzalbum)
    {
        $this->delete(array('idmzalbum' => $idmzalbum));
    }

}
