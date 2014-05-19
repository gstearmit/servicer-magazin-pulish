<?php
namespace ZF2AuthAcl\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Complysight\Service\UserAuthAdapter;
use Zend\Session\Container;
use Complysight\Service\UserPassword;
use Zend\Db\Sql\Update;
use Zend\Validator\Explode;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class Role extends AbstractTableGateway
{

    public $table = 'role';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
        $this->initialize();
    }
    
    public function getUserRoles($where = array(), $columns = array())
    {
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array(
                'role' => $this->table
            ));
            $select->columns(array(
                'rid',
                'role_name',
                'status',
            ));
            $select->where('rid != "Active"');
            if (count($where) > 0) {
                $select->where($where);
            }
            
            if (count($columns) > 0) {
                $select->columns($columns);
            }
            $statement = $sql->prepareStatementForSqlObject($select);
            $roles = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            return $roles;
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
    }

    public function getEmployees()
    {
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()
                ->from('user')
                ->columns(array(
                "id",
                "email"
            ));
            $select->order(array(
                '0' => 'user.id'
            ));
            $statement = $sql->prepareStatementForSqlObject($select);
            $employees = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            return $employees;
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
    }

    public function deleteUserRoles()
    {
        try {
            $this->detele();
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
        return false;
    }

    public function updateUserRole($data, $where)
    {
        return $this->update($data, $where);
    }

    public function getRolesname($rolesID)
    {
        try {
            if (is_array($rolesID)) {
                $rolesID = implode(',', $rolesID);
            }
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()
                ->from($this->table)
                ->columns(array(
                "role_name",
                "description"
            ));
            $select->where("rid in ($rolesID)");
            
            $statement = $sql->prepareStatementForSqlObject($select);
            $rolesName = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            return $rolesName;
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
    }
}
