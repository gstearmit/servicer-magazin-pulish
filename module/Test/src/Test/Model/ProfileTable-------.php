<?php

namespace TEST\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class TESTTable extends AbstractTableGateway {

    protected $table = 'test';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Profile());

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

    public function getTEST($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
       
       
    }
    
    
  

    public function saveTEST(Profile $profile) {
        $data = array(
            'descriptionkey' => $profile->descriptionkey,
        	'imgkey' => $profile->imgkey,
            'title' => $profile->title,
        );

        $id = (int) $profile->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getTEST($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteTEST($id) {
        $this->delete(array('id' => $id));
    }

}
